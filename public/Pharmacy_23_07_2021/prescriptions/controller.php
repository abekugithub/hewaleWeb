<?php
$patientCls = new patientClass();
$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();

$objdtls = $engine->getFacilityDetails();
$facilityalias = $objdtls->FACI_ALIAS ;
$faccode = $objdtls->FACI_CODE ;


$day = Date("Y-m-d");
switch($viewpage){

case 'accept':
        
		IF(empty($_POST["syscheckbox"])){
	       
            $msg = "Failed. Required field(s) can't be empty!.";
			$status = "error";
			$view ='prescdetails';
            
            $stmtlist = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_prescription WHERE PRESC_VISITCODE = ".$sql->Param('1')."  and PRESC_FACICODE = ".$sql->Param('a')." "),array($visitcode,$faccode));
	        print $sql->Errormsg();
	
	       
	    }else{
        
		$pickupcode = $engine->pickupcode();
		$recivercode = $engine->getreciverCode();
		$day = date("Y-m-d");
		
		$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_prescriptioncode (C_PICKUPCODE,C_RECIVERCODE,C_DATE) VALUES (".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').")"),array($pickupcode,$recivercode,$day));
		print $sql->ErrorMsg();
		
        foreach($_POST["syscheckbox"] as $keys ){
		
		$predetail = explode('@@@', $keys);
		$precode = $predetail[0];
		$predrug = $predetail[1];
		$preqty = $predetail[2];
        
        $couriers = explode('@@@', $courier);
        $couriercode = $couriers[0];
        $couriername = $couriers[1];
        
       
		
	    $stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_prescription SET PRESC_STATUS = ".$sql->Param('1').", PRESC_PICKUPCODE = ".$sql->Param('2').",  PRESC_RECIVERCODE = ".$sql->Param('3').", PRESC_COUR_CODE = ".$sql->Param('4')." WHERE PRESC_CODE = ".$sql->Param('5').""),array('4',$pickupcode,$recivercode,$couriercode,$precode));
		print $sql->ErrorMsg();
		
		$stmt = $sql->Execute($sql->Prepare("UPDATE hms_pharmacystock SET ST_SHEL_QTY =  ST_SHEL_QTY - ".$sql->Param('1')." WHERE ST_CODE = ".$sql->Param('2')." and ST_FACICODE = ".$sql->Param('a').""),array($preqty,$predrug,$faccode));
		print $sql->ErrorMsg();
		
        $stmtlist = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_prescription WHERE PRESC_VISITCODE = ".$sql->Param('1')."  and PRESC_FACICODE = ".$sql->Param('a')." "),array($visitcode,$faccode));
	    print $sql->Errormsg();
		
		$obj1 = $stmtlist->FetchNextObject();
		$patient = $obj1->PRESC_PATIENTCODE;
		$pid = $obj1->PRESC_ID;
			
		}
        
        $code = '022';
        $desc = 'Prescription is Ready for pickup';
        $menudetailscode = '0018';
        $tablerowid = $pid;
        $engine->setNotification($code,$desc,$menudetailscode,$tablerowid,$sentto="",$faccodeout="$couriercode");
        
		
		$code = '022';
        $desc = 'Prescription Receiver code is '.$recivercode.' . Thanks ';
        $menudetailscode = '0018';
        $tablerowid = $pid;
        $engine->setNotification($code,$desc,$menudetailscode,$tablerowid,$sentto="$patient",$faccodeout="");
        
		
		$msg = 'Prescription is ready for pickup. Pickup code is  '.$pickupcode.'';
        $status = 'success';
        $view ='';
        
		}
		
break;


case 'decline':
        
		IF(empty($_POST["syscheckbox"])){
	       
            $msg = "Failed. Required field(s) can't be empty!.";
			$status = "error";
			$view ='prescdetails';
            
            $stmtlist = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_prescription WHERE PRESC_VISITCODE = ".$sql->Param('1')." and PRESC_STATUS = ".$sql->Param('2')." and PRESC_FACICODE = ".$sql->Param('a')." "),array($visitcode, '1',$faccode));
	        print $sql->Errormsg();
	
	       
	    }else{
              
       foreach($_POST["syscheckbox"] as $keys ){
	   $nnil = '';
       
	   $stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_prescription SET PRESC_STATUS = ".$sql->Param('1').", PRESC_FACICODE = ".$sql->Param('2')." WHERE PRESC_CODE = ".$sql->Param('3').""),array('1',$nnil,$keys));
	   print $sql->ErrorMsg();
       
       $stmtlist = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_prescription WHERE PRESC_VISITCODE = ".$sql->Param('1')." and PRESC_STATUS = ".$sql->Param('2')." and PRESC_FACICODE = ".$sql->Param('a')." "),array($visitcode, '1',$faccode));
	        print $sql->Errormsg();
	
		
		
		$msg = 'You have Declined to supply this prescription to this patient';
        $status = 'success';
        $view ='prescdetails';
		}
        }
		
break;



	
	
    case 'prescrdetails':
	
	if(empty($keys)){
	
    	$msg = "Failed. Required field(s) can't be empty!.";
    	$status = "error";
    	$view ='';
    	
	}else{
	
	$stmt = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_prescription WHERE PRESC_VISITCODE = ".$sql->Param('1')." and  PRESC_FACICODE = ".$sql->Param('a')." "),array($keys,$faccode));
	print $sql->Errormsg();
	
	if($stmt->Recordcount() > 0 ){
	
	$obj = $stmt->FetchNextObject();
	
	$patient = $obj->PRESC_PATIENT;
	$patientnum= $obj->PRESC_PATIENTNUM;
	$visitcode= $obj->PRESC_VISITCODE;
	$faccode = $obj->PRESC_FACICODE;
	
	}
	
	$stmtlist = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_prescription WHERE PRESC_VISITCODE = ".$sql->Param('1')."  and PRESC_FACICODE = ".$sql->Param('a')."  "),array($keys,$faccode));
	print $sql->Errormsg();
	
	}
	
	
	break;
	
	
    
    
	case "reset":
	$fdsearch = "";
	break;
    
}


if(!empty($fdsearch)){
	$query = "SELECT DISTINCT PRESC_VISITCODE,PRESC_PATIENT,PRESC_PATIENTNUM,PRESC_DATE,PRESC_STATUS,PRESC_DEL_STATUS FROM hms_patient_prescription WHERE PRESC_PATIENT LIKE ".$sql->Param('1')." or PRESC_PATIENTNUM LIKE ".$sql->Param('2')."  AND PRESC_FACICODE = ".$sql->Param('a')." ";
	
	print $sql->ErrorMsg();
    $input = array('%'.$fdsearch.'%','%'.$fdsearch.'%',$faccode);
}else{

    $query = "SELECT DISTINCT PRESC_VISITCODE,PRESC_PATIENT,PRESC_PATIENTNUM,DATE(PRESC_DATE) AS PRESC_DATE,PRESC_STATUS,PRESC_DEL_STATUS FROM hms_patient_prescription WHERE PRESC_FACICODE = ".$sql->Param('a')." AND PRESC_STATUS  IN ('3')  ";
    $input = array($faccode);
}
if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){

    $limit =20;
	
}

$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=f77ccbdb203c19d3d52b12a85f33faf5&option=6bf17fe4762ece7a82410014d090d322&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);

$usp = $doctors->getuserSpeciality($usrcode);
$stmtcourierlov = $sql->Execute($sql->Prepare("SELECT * from hms_pharmacycourier where PCO_FACICODE = '$faccode' order by PCO_COURIER ")) ;
$stmttestlov = $sql->Execute($sql->Prepare("SELECT * from hmsb_st_labtest order by LTT_NAME ")) ;
$stmtdiagnosislov = $sql->Execute($sql->Prepare("SELECT * from hmsb_st_disease order by DIS_NAME ")) ;
$stmtdrugslov = $sql->Execute($sql->Prepare("SELECT * from hmsb_st_phdrugs order by DR_NAME ")) ;


?>