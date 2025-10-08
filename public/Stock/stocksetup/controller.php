<?php
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$actorid = $session->get("userid");


$objdtls = $engine->getFacilityDetails();
$facilityalias = $objdtls->FACI_ALIAS ;
$faccode = $objdtls->FACI_CODE ;
switch($viewpage)
{
		case "saveitem":
		
 
	if(empty($item)) {

			$msg = "Failed. Required field(s) can't be empty!.";
			$status = "error";
			$view ='add';
		
		}else{
			$item2 = $itemcode;
			$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_pharmacystock WHERE ST_CODE =".$sql->Param('a')." AND ST_FACICODE=".$sql->Param('b')." "),array($item2,$faccode));
			print $sql->ErrorMsg();
				
			if($stmt->RecordCount()>0){
				
                $msg = "Failed, Item exist already!";
				$status = "error";
				$view ='add';
				
			}else{
				
				
		$stmt = $sql->Execute($sql->Prepare("SELECT DR_NAME FROM hmsb_st_phdrugs WHERE DR_CODE =".$sql->Param('a')." "),array($item2));
			print $sql->ErrorMsg();
				
			if($stmt->RecordCount()>0){
				$addobj = $stmt->FetchNextObject();
			$items = $addobj->DR_NAME;
				
		
						
				
			}
				
           $enddate2 = $sql->BindDate($engine->getDateFormat($enddate));    
				
				$pharmacypricecode=$engine->getpharmacypricecode();
				
				
		//	
$sql->Execute($sql->Prepare("INSERT INTO hms_pharmacystock (ST_NAME,ST_DOSAGE,ST_CODE,ST_DATE,ST_REORDER_LEVEL,ST_STORE_QTY,ST_SHEL_QTY,ST_PRICE,ST_FACICODE,ST_STATUS,ST_USER_ID
) VALUES(".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5')." ,".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').")"),array($items,$dosage,$itemcode,$enddate2,$level,$qty,$qty1,$price,$faccode,"1",$actorid));
print $sql->ErrorMsg();
				

$sql->Execute($sql->Prepare("INSERT INTO hms_pharmacyprice (PPR_CODE,PPR_FACICODE,PPR_DRUG,PPR_DRUGCODE) VALUES(".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').")"),array($pharmacypricecode,$faccode,$items,$itemcode));
			
            	$msg = " Item has been registered successfully.";
				$status = "success";
				$view =''; 
						
				// userlog event
				$activity= "STOCK ITEM SETTING UP: ".$items.", QUANTITY: ".$qty."  ";
                $engine->setEventLog("051",$activity);
                
                $drug=$keys=$dose=$type=$typ=$s=$p=$rqty=$qty=$sunit=$nhiscode=$price=$level=$datestock=$itemcashprice=$qty1= '';
				}
                }
					
		
	
break;
		
		case "edititem":
	 if(isset($keys) && $keys != ''){
		$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_pharmacystock WHERE ST_CODE = ".$sql->Param('a')." "),array($keys)); 
		print $sql->ErrorMsg();
		if($stmt->RecordCount() == 1){
			$obj = $stmt->FetchNextObject();
			$item = $obj->ST_CODE;
			$itemname =$obj->ST_NAME;
			$dosage = $obj->ST_DOSAGE;
			$level = $obj->ST_REORDER_LEVEL;
			$price = $obj->ST_PRICE;
			$qty = $obj->ST_STORE_QTY;
			$qty1 = $obj->ST_SHEL_QTY;
			$enddate = $obj->ST_DATE;
			
	    }
		 
	}
	break;
		
		case "savedititem":

		if (isset($keys) && !empty($keys)){
			//$enddate = $sql->BindDate($engine->getDateFormat($enddate)); 
			$stmt=$sql->Execute($sql->Prepare("UPDATE hms_pharmacystock SET ST_STORE_QTY=".$sql->Param('a').",ST_SHEL_QTY=".$sql->Param('b').",ST_REORDER_LEVEL=".$sql->Param('c').",ST_DATE=".$sql->Param('d')." WHERE ST_CODE=".$sql->Param('d')." "),array($qty,$qty1,$level,$enddate,$keys));
		}
		 	if ($stmt==TRUE){
			$msg = " Item has been updated successfully.";
		    $status = "success";
			$view =''; 
		 	}else{
		 		$msg = " Item could not be updated.";
				$status = "error";
				$view ='edit'; 
		 	}
		break;
		case "upload":
		$file = $_FILES['uploadinput'];
        if (isset($file)&&!empty($file)){
            if (file_exists($file['tmp_name'])){
                $num=0;
                //upload of exce file in the pending termination table

                //open and read the excel file

                $fichierACharger = $file["tmp_name"];
                $fichierType = PHPExcel_IOFactory::identify($fichierACharger);
                $objetALire = PHPExcel_IOFactory::createReader($fichierType);
                $objetALire->setReadDataOnly(true);
                $objPHPExcel = $objetALire->load($fichierACharger);

                $feuille = $objPHPExcel->getSheet(0);
                $highestRow = $feuille->getHighestRow();
                $highestCol = $feuille->getHighestColumn();
                $indexCol = PHPExcel_Cell::columnIndexFromString($highestCol);

                for ($row = 2;$row <= $highestRow; $row++){
					$code = $feuille->getCellByColumnAndRow(0,$row)->getValue();
                    $drugname = $feuille->getCellByColumnAndRow(1,$row)->getValue();
					$drugdosage = $feuille->getCellByColumnAndRow(2,$row)->getValue();
					$drugprice = $feuille->getCellByColumnAndRow(3,$row)->getValue();
                    $drugreorder = $feuille->getCellByColumnAndRow(3,$row)->getValue();
                    $drugstorequantity = $feuille->getCellByColumnAndRow(4,$row)->getValue();
                    $drugshelfquantity = $feuille->getCellByColumnAndRow(5,$row)->getValue();
                   // $drugcashprice = $feuille->getCellByColumnAndRow(5,$row)->getValue();
                 //   $drugnhisprice = $feuille->getCellByColumnAndRow(6,$row)->getValue();
                    $detcode = uniqid();
                    if(!empty($drugname)){
						
                        $udise = strtoupper($drugname);
                        $stmt = $sql->Execute($sql->Prepare("SELECT ST_NAME FROM hms_pharmacystock WHERE ST_NAME =".$sql->Param('a')." AND ST_DOSAGE=".$sql->Param('b')." AND ST_FACICODE = ".$sql->Param('d')." "),array($drugname,$drugdosage,$faccode));
                        print $sql->ErrorMsg();

                        if($stmt->RecordCount()>0){
                        	$drugerror[]=$drugname;
                        	
                        }else{
							//$code = $engine->getdrugCode();
							$dosagename = $engine->getDrugDosageName($code);
							$stmt_pharm= $sql->Execute($sql->Prepare("INSERT INTO hms_pharmacystock (ST_CODE,ST_NAME,ST_DOSAGE,ST_REORDER_LEVEL,ST_STORE_QTY,ST_SHEL_QTY,ST_FACICODE,ST_STATUS,ST_DOSAGENAME) VALUES(".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9')." )"),array($code,$drugname,$drugdosage,$drugreorder,$drugstorequantity,$drugshelfquantity,$faccode,'2',$dosagename));
                            print $sql->ErrorMsg();
							if ($stmt_pharm==TRUE){
								$pharmacypricecode=$engine->getpharmacypricecode();
							$sql->Execute($sql->Prepare("INSERT INTO hms_pharmacyprice (PPR_CODE,PPR_FACICODE,PPR_DRUG,PPR_DRUGCODE,PPR_PRICE) VALUES(".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').")"),array($pharmacypricecode,$faccode,$drugname,$code,$drugprice));	
							 print $sql->ErrorMsg();
							$msg = "Drug has been saved successfully.";
                            $status = "success";
							$view ='';
							}
                            
							
                            // userlog event
                            $activity= " SETUP DRUG. ADDED DRUG: ".$udise."  ";
                            $engine->setEventLog("019",$activity);
                            $disease= '';
                            


                        }
                    }else{
                        $msg = 'Drug Name can not be empty';
                        $status = 'error';
                        $view = 'upload';
                    }
                }
                  if (count($drugerror)>0){
                  	$drugerror = (is_array($drugerror)&& count($drugerror)>0 )?"Upload was successful but these drugs input failed because they already exist :".implode(',',$drugerror):'';
                  	 $msg = "$drugerror";
                     $status = "error";
					 $view ='';
                  	
                  }
            }else{
                if ($file['error']>0){
                    $msg = 'The file name you entered/selected does not exist. Please check and enter/select a valid file like the template';
                    $status = 'error';
                    $views = 'upload';
                }
            }
        }else{
            //$msg = 'No file was selected';
          //  $status = 'error';
          //  $views = 'bulkupload';
        }
		break;
	
		
		
		
		
		
		
		
		
		
		
		
		
		
				
	
}

if(!empty($fdsearch)){
 $query = "SELECT * from hms_pharmacystock LEFT JOIN hms_pharmacyprice ON ST_CODE=PPR_DRUGCODE WHERE ST_FACICODE = ".$sql->Param('a')."  AND (ST_STATUS = ".$sql->Param('b')." OR ST_STATUS = ".$sql->Param('c').") AND (ST_NAME LIKE ".$sql->Param('c')." OR ST_DOSAGE LIKE ".$sql->Param('c').") ";
    $input = array($faccode,'1','2','%'.$fdsearch.'%','%'.$fdsearch.'%');
}else {

    $query = "SELECT * from hms_pharmacystock LEFT JOIN hms_pharmacyprice ON ST_CODE=PPR_DRUGCODE WHERE ST_FACICODE = ".$sql->Param('a')."  AND (ST_STATUS = ".$sql->Param('b')." OR ST_STATUS = ".$sql->Param('c').") ";
    $input = array($faccode,'1','2');
}
if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=27ce7f8b5623b2e2df568d64cf051607&option=a8eeadce8f6beba98cf36604423f8ca7&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);


//Get all positions
$stmtpos = $engine->getUserPosition();
$stmtstockitem = $sql->Execute($sql->Prepare("SELECT * from hmsb_st_phdrugs WHERE DR_CODE NOT IN (SELECT ST_CODE from hms_pharmacystock WHERE ST_FACICODE=".$sql->Param('a').") ORDER BY DR_NAME ASC"),array($faccode));


?>