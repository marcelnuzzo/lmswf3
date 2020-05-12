<?php

namespace App\Controller;

use App\Entity\Testquiz;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\IReader;


class TestquizController extends AbstractController
{
    /**
     * @Route("/testquiz", name="testquiz")
     */
    public function index(EntityManagerInterface $manager)
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("C://wamp64/www/testquiz.xlsx");
        $sheet = $spreadsheet->getActiveSheet();
       
        $getHighestColumn = $spreadsheet->setActiveSheetIndex(0)->getHighestColumn();
        $getHighestRow = $spreadsheet->setActiveSheetIndex(0)->getHighestRow();
        $nbCol = hexdec($getHighestColumn) - 9;
        $alpha='A';
        $valCellX=[];
        $count=0;
        
            
        for($i=1; $i<=$getHighestRow; $i++) { 
            
            for($j=1; $j<=$nbCol; $j++) {              
                $valCellX[] = $sheet->getCell($alpha.$i)->getValue($j);        
                ++$alpha;
                $count++;
            }
            if($alpha == "D")
                $alpha = "A";
               
        }
        
        $ctr=0;
        for($i=1; $i<=$getHighestRow; $i++) {
            $testquiz = new Testquiz();
            $testquiz->setQuestion($valCellX[$ctr]);
            $ctr++;
            $testquiz->setProposition($valCellX[$ctr]);
            $ctr++;
            $testquiz->setCorrection($valCellX[$ctr]);
            $ctr++;
            $manager->persist($testquiz);
           
        }
        $manager->flush();

        return $this->render('testquiz/index.html.twig', [
            'controller_name' => 'TestquizController',
        ]);
    }
}
