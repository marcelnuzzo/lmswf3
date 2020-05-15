<?php

namespace App\Service;

class Readfile
{
    public function getResult($fichier)
    {
        $getHighestRow = $this->getRead($fichier);

        return compact('getHighestRow', 'valCellX');

    }

    public function getRead($fichier)
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($fichier);
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
        return [$getHighestRow, $valCellX];
        
    }

    public function getRead2($fichier)
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet1 = $reader->load($fichier)->getSheet(0);
        $getHighestColumn1 = $spreadsheet1->getHighestColumn();
        $getHighestRow1 = $spreadsheet1->getHighestRow();
        $nbCol = hexdec($getHighestColumn1) - 9;
        $alpha='A';
        $valCell1=[];
        $count=0;
        for($i=1; $i<=$getHighestRow1; $i++) { 
            
            for($j=1; $j<=$nbCol; $j++) {              
                $valCell1[] = $spreadsheet1->getCell($alpha.$i)->getValue($j);        
                ++$alpha;
                $count++;
            }
            if($alpha == "D")
                $alpha = "A";                   
        }

        $spreadsheet2 = $reader->load($fichier)->getSheet(1);
        $getHighestColumn2 = $spreadsheet2->getHighestColumn();
        $getHighestRow2 = $spreadsheet2->getHighestRow();
        $nbCol = hexdec($getHighestColumn2) - 9;
        $alpha='A';
        $valCell2=[];
        $count=0;
        for($i=1; $i<=$getHighestRow2; $i++) { 
            
            for($j=1; $j<=$nbCol; $j++) {              
                $valCell2[] = $spreadsheet2->getCell($alpha.$i)->getValue($j);        
                ++$alpha;
                $count++;
            }
            if($alpha == "B")
                $alpha = "A";                   
        }


        return [$getHighestRow1, $valCell1, $getHighestRow2, $valCell2];
    }
}