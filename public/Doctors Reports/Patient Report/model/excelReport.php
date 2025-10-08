<?php
/*
* This represents the excel report class
* It contains the header, property and various excel's report functions 
*/

 class excelReport
 {
	  private $sql;
	  private $objExcel;
	  private $PageMargins;
	  private $Style;
	  private $objDrawing;
	  
      function  __construct() {
            global $sql;
        $this->sql=$sql;
		$this->objExcel = new PHPExcel();
		$this->PageMargins = new PHPExcel_Worksheet_PageMargins();
		$this->Style = new PHPExcel_Style();
		
		
		
		//Stylings
		$this->Style->applyFromArray(
	array(
		  'borders' => array(
								'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
								'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
							)
		 ));
		 
		 
		
        }
		
	 
	  function ReportHeader($header)
	  {
		  
		   // Set properties
          $this->objExcel->getProperties()->setCreator($header[0])
							 ->setLastModifiedBy($header[0])
							 ->setTitle($header[0])
							 ->setSubject("Excel Report Document")
							 ->setDescription("Report Document for Office 2007 XLSX.")
							 ->setKeywords("office excel 2007 ")
							 ->setCategory("Exported Excel Reports");
		// Set header and footer. When no different headers for odd/even are used, odd header is assumed.
		 
         $this->objExcel->getActiveSheet()->getHeaderFooter()->setOddHeader("&L&G&R&H".$header[0]."\n".$header[1]."\n".$header[2]."\n".$header[3]."\n".$header[4]."\n\n".$header[5]."\n".$header[6]."\n".$header[7]." ");
         $this->objExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $this->objExcel->getProperties()->getTitle() . '&RPage &P of &N');		
	  }
	
	
	
	
	
 	  
	
	
	function consultation($data)
	  {	  
	  
	  	$limitcadre = count($data) + 1;
	  	$this->objExcel->getActiveSheet()->setSharedStyle($this->Style, "A1:E".$limitcadre);
	  
	  $styleArray = array(
     	'font' => array(
		'bold' => true,
    	),
	    'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
	    ),
       );
	  
	  $styleArraydline = array(
	        'font' => array(
    'underline' => PHPExcel_Style_Font::UNDERLINE_DOUBLE
	       ),
       );   
	  
	
		
	
		//$this->objExcel->getActiveSheet()->getStyle('A6:E7')->getFon
		//$this->objExcel->getActiveSheet()->SetCellValue('A5', $orgadd.$orgbox.$orgph.$orgfax.$orgemail.$orgwb);
		
		
		
		
       //Report and Company Name
       $this->objExcel->setActiveSheetIndex(0);
	   
      //setting column width
      $this->objExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
      $this->objExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
      $this->objExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
      $this->objExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
      $this->objExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
      $this->objExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
      $this->objExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    //   $this->objExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
      
	/*  $this->objExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
	  $this->objExcel->getActiveSheet()->getColumnDimension('G')->setWidth(21);*/
	  /*$this->objExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);*/
	 

      $this->objExcel->setActiveSheetIndex(0);
	  $this->objExcel->getActiveSheet()->getStyle('A1:E1')->applyFromArray($styleArray);
      $this->objExcel->getActiveSheet()->SetCellValue('A1', 'NO');
	  $this->objExcel->getActiveSheet()->SetCellValue('B1', 'PATIENT NAME');
	  $this->objExcel->getActiveSheet()->SetCellValue('C1', 'HEWALE NUMBER');
	  $this->objExcel->getActiveSheet()->SetCellValue('D1', 'GENDER');
	  $this->objExcel->getActiveSheet()->SetCellValue('E1', 'EMAIL');
	  $this->objExcel ->getActiveSheet()->SetCellValue('F1', 'PHONE NO');
	  $this->objExcel ->getActiveSheet()->SetCellValue('G1', 'DATE');
	//   $this->objExcel ->getActiveSheet()->SetCellValue('F1', 'CATEGORY');
	/*  
	  $this->objExcel->getActiveSheet()->SetCellValue('G1', 'ZONE');*/
	  
	  /*$this->objExcel->getActiveSheet()->SetCellValue('G1', 'Department');
	  $this->objExcel->getActiveSheet()->SetCellValue('H1', 'Status');
			*/

	    $i = 2;
		$b = 1;
	   if(is_array($data) && count($data) > 0){
	   foreach($data as $value)
	   {			
	   
            $this->objExcel->getActiveSheet()->SetCellValueByColumnAndRow("0",$i,$b);
            $this->objExcel->getActiveSheet()->SetCellValueByColumnAndRow("1",$i,$value[0]);
			$this->objExcel ->getActiveSheet()->SetCellValueByColumnAndRow("2",$i,$value[1]);
            $this->objExcel->getActiveSheet()->SetCellValueByColumnAndRow("3",$i,$value[2]);
            $this->objExcel ->getActiveSheet()->SetCellValueByColumnAndRow("4",$i,$value[3]);
            $this->objExcel ->getActiveSheet()->SetCellValueByColumnAndRow("5",$i,$value[4]);
            $this->objExcel ->getActiveSheet()->SetCellValueByColumnAndRow("6",$i,$value[5]);
            $this->objExcel ->getActiveSheet()->SetCellValueByColumnAndRow("7",$i,$value[6]);
            //	$this->objExcel ->getActiveSheet()->SetCellValueExplicitByColumnAndRow("2",$i,$value[1], PHPExcel_Cell_DataType::TYPE_STRING);
		//	$this->objExcel ->getActiveSheet()->SetCellValueByColumnAndRow("4",$i,$value[3]);
		//	$this->objExcel ->getActiveSheet()->SetCellValueByColumnAndRow("5",$i,$value[4]);
			//$this->objExcel ->getActiveSheet()->SetCellValueByColumnAndRow("5",$i,$value[4]);
			/*$this->objExcel ->getActiveSheet()->SetCellValueByColumnAndRow("5",$i,$value[4]);
			$this->objExcel ->getActiveSheet()->SetCellValueByColumnAndRow("6",$i,$value[5]);*/
			/*$this->objExcel ->getActiveSheet()->SetCellValueByColumnAndRow("7",$i,$value[6]);*/
		$i++;
		$b++;	
	   }
		} 
		
		$this->objExcel->getActiveSheet()->getStyle('E1:G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		
		$this->objExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$this->objExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

$this->PageMargins->setBottom(0.5);
$this->PageMargins->setTop(2.2);
$this->PageMargins->setLeft(0.2);
$this->PageMargins->setRight(0.2);

$this->objExcel->getActiveSheet()->setPageMargins($this->PageMargins);

     // worksheet name
     $this->objExcel->getActiveSheet()->setTitle('Event_Log'); 
	 
	//Output to client browser
	// Redirect output to a client's web browser (Excel2007)
	  
	  	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	  	header('Content-Disposition: attachment;filename="'."Doctor Patient".'.xlsx"');
	  	header('Cache-Control: max-age=0');
	  
	  	$objWriter = PHPExcel_IOFactory::createWriter($this->objExcel, 'Excel2007');
	  	$objWriter->save('php://output');
	  	exit;
	  }//End of all terminated data
	  
	 
  }
?>