<?php

namespace App\Service;

use App\Entity\Testquiz;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\HomeController;

class Writefile
{
    private $manager;

    public function __construct(EntityManagerInterface $manager) {
        $this->manager = $manager;    
    }
    
    public function getWrite(Readfile $readfile, $fichier)
    {
        $getHighestRow = $readfile->getRead($fichier)[0];
        $valCellX = $readfile->getRead($fichier)[1];
        dd($getHighestRow);
        $ctr=0;
                for($i=1; $i<=$getHighestRow; $i++) {
                    $testquiz = new Testquiz();
                    $testquiz->setQuestion($valCellX[$ctr]);
                    $ctr++;
                    $testquiz->setProposition($valCellX[$ctr]);
                    $ctr++;
                    $testquiz->setCorrection($valCellX[$ctr]);
                    $ctr++;
                    $this->manager->persist($testquiz);
                
                }
                return $testquiz;
    }
}