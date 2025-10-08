<?php
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$userCourier = $engine->getActorCourier();
$ccode = $engine->getparcelcode();
$agentcode = $engine->getActorCode();
$objdtls = $engine->getFacilityDetails();
$facilityalias = $objdtls->FACI_ALIAS ;
$faccode = $objdtls->FACI_CODE ;

switch($viewpage){
	
	// 22 NOV 2018 JOSEPH ADORBOE

	
	case "assign":

		
		if(empty($prescriptioncode) || empty($agent) ) {
	
			$msg = "Failed. Required field(s) can't be empty!.";
			$status = "error";
			$view ='details';
			

		
		}else{
				$ag = explode('@@@', $agent);
				$agentcode = $ag[0];
				$agentname = $ag[1];
				
				$sql->Execute($sql->Prepare("UPDATE hmsb_courier_basket SET COB_AGENTCODE = ".$sql->Param('1')." , COB_AGENT = ".$sql->Param('2').", COB_STATUS = ".$sql->Param('3')." WHERE COB_PRESCRIPTIONCODE = ".$sql->Param('4')." "),array($agentcode,$agentname,'2',$prescriptioncode));
				print $sql->ErrorMsg();

				//$visit ='VS20181011H0001-0000001';
				//$ccode = '10000';
				//$engine->getcourieritem($visit,$ccode);
				
				$engine->ClearNotification('0018','0');
				$msg = " Assigned Successfully.";
				$status = "success";
				$activity= "Assigned Successfully ".$agentname." was requested for was added successfully ";
				$engine->setEventLog("116",$activity);

				$desc = 'New Package Ready for Pickup';
        		$menudetailscode = '0039';
        		$tablerowid = $prescriptioncode;
        		$engine->setNotification($code,$desc,$menudetailscode,$tablerowid,$sentto="$patcode",$faccodeout="$couriercode");


				//Clear Notifications

				$engine->ClearNotification($menudetailscode,$tablerowid);
				
				
		}	
	break;		
			
		
    
	// 21 NOV 2018 , JOSEPH ADORBOE 
	case "details":

	$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hmsb_courier_basket WHERE COB_PRESCRIPTIONCODE=".$sql->Param('a')." limit 1 "),array($keys));
		print $sql->ErrorMsg();
				
		if($stmt->RecordCount()>0){

			$editobj = $stmt->FetchNextObject();
			$dat = $editobj->COB_DATE;
   			$trackingcode = $editobj->COB_TRACKINGCODE;
			$patient = $editobj->COB_PATIENT;
			$patientnum = $editobj->COB_PATIENTNUM;
            $phone = $editobj->COB_PATIENTPHONENUM;
			$deliverylocation = $editobj->COB_DELIVERYLOCATION;
			$visit = $editobj->COB_VISITCODE;
			$pickupcode = $editobj->COB_PICKUPCODE;
			$pharmacy = $editobj->COB_PHARMACY;
			$pharmacyloc = $editobj->COB_PHARMACYLOCATION;
			$pharmacyphone = $editobj->COB_PHARMACYPHONE;
			$agent = $editobj->COB_AGENTCODE;
			$prescriptioncode = $editobj->COB_PRESCRIPTIONCODE;
			$delstatus = $editobj->COB_STATUS;
			$stmtpris =  $sql->Execute($sql->prepare("SELECT * from hmsb_courier_basket where COB_PRESCRIPTIONCODE = ".$sql->Param('1').""),array($keys));
			print $sql->ErrorMsg();
        
		}
		
	break;
	
	
	
	case"insertcode":
	
	
	
	$stmt = $sql->Execute($sql->Prepare("SELECT C_RECIVERCODE FROM hms_prescriptioncode WHERE C_PICKUPCODE=".$sql->Param('a')."  "),array($keys));
			print $sql->ErrorMsg();
			if($stmt->RecordCount() == 1){
			$obj = $stmt->FetchNextObject();
			 $delcode = $obj->C_RECIVERCODE;
			}
			if(!empty($inputdeliverycode)) {
			
			if($delcode == $inputdeliverycode) {
				//echo $delcode."BOOOOOOOOOOOOOOOOOOOOM".$inputdeliverycode; die();
				//fetch the visitcode
		$stmtcode = $sql->Execute($sql->Prepare("SELECT PRESC_VISITCODE,PRESC_COUR_CODE from hms_patient_prescription WHERE PRESC_PICKUPCODE =".$sql->Param('a')." "),array($keys));
		if ($stmtcode->RecordCount()>0){
			$objcode=$stmtcode->FetchNextObject();
			$visitcode = $objcode->PRESC_VISITCODE;
	//	echo $visitcode; die();
		}
		else{
			$visitcode=NULL;
		}

	//this fetches the amount to be paid to courier
	$stmtcash = $sql->Execute($sql->Prepare("SELECT PCP_PHARM_AMT,PCP_COURIER_AMT,PCP_COURIER_CODE,PCP_PATIENTCODE from hms_pharm_courier_price WHERE PCP_PATIENT_VISITCODE =".$sql->Param('a')." AND PCP_COURIER_CODE=".$sql->Param('b')." "),array($visitcode,$faccode));
 		if ($stmtcash->RecordCount()>0){
 		//	echo "BIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIM";echo '<br>';// die();
 		$obj = $stmtcash->FetchNextObject();
 		$patientcode=$obj->PCP_PATIENTCODE;
 		//$pharmacyamount = $obj->PCP_PHARM_AMT;
 		$courieramount = $obj->PCP_COURIER_AMT;
 		$couriercode= $obj->PCP_COURIER_CODE;
 		//echo $patientcode.'--'.$courieramount.'--'.$faccode.'--'.$visitcode;die();
 		$engine->patienttocourierprice($patientcode,$courieramount,$faccode,$visitcode);	
		
 		}
				
				
				$stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_prescription SET PRESC_STATUS=".$sql->Param('c').", PRESC_COUR_AGENTCODE=".$sql->Param('a').", PRESC_COUR_CODE=".$sql->Param('b').", PRESC_PACKDELCODE=".$sql->Param('c')." WHERE PRESC_PICKUPCODE=".$sql->Param('d')),array('6',$agentcode,$userCourier,$inputdeliverycode,$keys));
		
		
		$stmtp = $sql->Execute($sql->Prepare("UPDATE hms_courierprocesses SET CS_STATUS=".$sql->Param('c').", CS_PACKDELCODE=".$sql->Param('c')." WHERE CS_PICKUPCODE=".$sql->Param('d')),array('6',$inputdeliverycode,$keys));
		
		$msg = "Courier Delivered Package Successfully.";
	    $status = "success";
        $activity = "Courier Delivered Package Successfully.";
		$engine->setEventLog("012",$activity);
				
			}else {
				$msg = "Please Delivery Code is not correct for this Package.";
	    	$status = "error";
				
			}
		
			}else {
				$msg = "Please Enter Delivery Code .";
	    	$status = "error";
				
			}
		
		


		
		
		
		//Send Notification to Patients
		/*$code = '023';
        $desc = 'Package is in Transit';
        $menudetailscode = '0018';
        $tablerowid = $presccode;
        $engine->setNotification($code,$desc,$menudetailscode,$tablerowid,$sentto="$patcode",$faccodeout="$couriercode");
		
		//Clear Notifications

		$engine->ClearNotification($menudetailscode,$tablerowid);*/
		
	
	break;
	
	
	
	
	
	case "updatedelivery":
		 		

	$responses = "Parcel is in Delivered. Thank you for doing Business with us.";
	
	$stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_prescription SET PRESC_STATUS='6' WHERE PRESC_PICKUPCODE=".$sql->Param('a')),array($keys));
	
	$stmt = $sql->Execute($sql->Prepare("UPDATE hms_courierprocesses SET CS_STATUS='6' WHERE CS_PICKUPCODE=".$sql->Param('a')),array($keys));
	
	/*$stmtp = $sql->Execute($sql->Prepare("UPDATE hms_notifications SET NOT_DETAILS=".$sql->Param('a').", NOT_STATUS='0' WHERE NOT_CODE=".$sql->Param('a')),array($responses,$keys));*/
		
		
        $msg = "Priscription Delivered Successfully.";
	    $status = "success";
        $activity = "Priscription Delivered Successfully.";
		$engine->setEventLog("012",$activity);
	
	
	break;
	
	case "reset":
	$fdsearch = "";
	break;
	
}


$stmtagents = $sql->Execute($sql->Prepare("SELECT COU_USERCODE,COU_FNAME, COU_SURNAME from hms_courieragents where COU_STATUS AND COU_INSTCODE=".$sql->Param('a')."  "), $input = array($userCourier));


include 'model/js.php';

if(!empty($fdsearch)){

	$query = "SELECT  COB_TRACKINGCODE,COB_PATIENT, COB_PATIENTCODE,COB_PATIENTNUM,COB_DATE, COB_VISITCODE,COB_PICKUPCODE,COB_PHARMACYCODE,COB_PHARMACY,COB_PHARMACYLOCATION,COB_STATUS,COB_PRESCRIPTIONCODE FROM hmsb_courier_basket WHERE COB_STATUS ='1' AND COB_COURIERCODE = ".$sql->Param('2')." and ( COB_PICKUPCODE like ".$sql->Param('2')." or COB_PATIENT like  ".$sql->Param('2')." )"; $input = array($userCourier,'%'.$fdsearch.'%','%'.$fdsearch.'%');

}else {
	
	$query = "SELECT COB_TRACKINGCODE,COB_PATIENT, COB_PATIENTCODE,COB_PATIENTNUM,COB_DATE, COB_VISITCODE,COB_PICKUPCODE,COB_PHARMACYCODE,COB_PHARMACY,COB_PHARMACYLOCATION,COB_STATUS,COB_PRESCRIPTIONCODE,COB_STATUS FROM hmsb_courier_basket WHERE  COB_COURIERCODE = ".$sql->Param('1')." AND COB_STATUS IN ('1') "; $input = array($userCourier);
	
	
}



if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=065ab3a28ca4f16f55f103adc7d0226f&option=1ac3d3b7e44de2f0ad6280c012e3825c&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);

//Get all positions
$stmtpos = $engine->getUserPosition();

?>