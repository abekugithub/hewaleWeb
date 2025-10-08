<?php
// echo "EEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEee";die();
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$userCourier = $engine->getActorCourier();
$ccode = $engine->getparcelcode();
$agentcode = $engine->getActorCode();


switch($viewpage){
	

	// 23 NOV 2018, JOSEPH ADORBOE
	case "deliverycheck":

	if(empty($inputdeliverycode) || empty($keys)){

	       
		$msg = "Failed. Required field(s) can't be empty!.";
		$status = "error";
		$view ='edit';
		
		$stmtpris =  $sql->Execute($sql->prepare("SELECT * from hmsb_courier_basket where COB_PRESCRIPTIONCODE = ".$sql->Param('1').""),array($keys));
		print $sql->ErrorMsg();
        
			   
	}else{
		  
		$stmt = $sql->Execute($sql->Prepare("SELECT COB_ID FROM hmsb_courier_basket where COB_DELIVERYCODE = ".$sql->Param('1')." AND COB_PRESCRIPTIONCODE = ".$sql->Param('1')."  "),array($inputdeliverycode,$keys));
		print $sql->ErrorMsg();
	
		if($stmt->RecordCount() > 0 ){
		
		$stmt = $sql->Execute($sql->Prepare("UPDATE hmsb_courier_basket SET COB_STATUS =".$sql->Param('a')." WHERE COB_PRESCRIPTIONCODE =".$sql->Param('b').""),array('5',$keys));
		print $sql->ErrorMsg();
		
		$stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_prescription_main SET PRESCM_STATUS =".$sql->Param('a')." WHERE PRESCM_PACKAGECODE =".$sql->Param('b').""),array('7',$keys));
		print $sql->ErrorMsg();

		$stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_prescription SET PRESC_STATUS =".$sql->Param('a')." WHERE PRESC_PACKAGECODE =".$sql->Param('b').""),array('7',$keys));
		print $sql->ErrorMsg();

		$stmt = $sql->Execute($sql->Prepare("SELECT POL_VALUE FROM hmsb_policy_settings where POL_NAME = ".$sql->Param('1')."   "),array('hewale_courier'));
		print $sql->ErrorMsg();
	
		if($stmt->RecordCount() > 0 ){

			$obj = $stmt->FetchNextObject();			
			$pervalu = $obj->POL_VALUE;

			$stmtt = $sql->Execute($sql->Prepare("SELECT HRMSWAL_BALANCE FROM hms_wallets where HRMSWAL_USERCODE = ".$sql->Param('1')."   "),array('AD1012'));
			print $sql->ErrorMsg();
		
			if($stmtt->RecordCount() > 0 ){
	
				$objj = $stmtt->FetchNextObject();			
				$hewalebal = $objj->HRMSWAL_BALANCE;	


				$stmtcourier = $sql->Execute($sql->Prepare("SELECT HRMSWAL_BALANCE FROM hms_wallets where HRMSWAL_USERCODE = ".$sql->Param('1')."   "),array($userCourier));
			print $sql->ErrorMsg();
		
			if($stmtcourier->RecordCount() > 0 ){
	
				$objcourier = $stmtcourier->FetchNextObject();			
				$courierbal = $objcourier->HRMSWAL_BALANCE;	




		$stmt = $sql->Execute($sql->Prepare("SELECT HRMSTRANS_COURIER_AMOUNT,HRMSTRANS_CODE FROM hms_wallet_transaction where HRMSTRANS_PACKAGECODE = ".$sql->Param('1')." "),array($keys));
		print $sql->ErrorMsg();
	
		if($stmt->RecordCount() > 0 ){

			$objj = $stmt->FetchNextObject();
			
			$amtvalu = $objj->HRMSTRANS_COURIER_AMOUNT;
			$wcode = $objj->HRMSTRANS_CODE;

			$peramt = $hewalebal + $pervalu ;
			$stmt = $sql->Execute($sql->Prepare("UPDATE hms_wallets SET HRMSWAL_BALANCE = HRMSWAL_BALANCE + ".$sql->Param('a')." WHERE HRMSWAL_USERCODE =".$sql->Param('b').""),array($peramt,'AD1012'));
			print $sql->ErrorMsg();

			$ucode = uniqid();
			$hewaleclose = $hewalebal + $pervalu;
			$sql->Execute($sql->Prepare("INSERT INTO hms_wallet_transaction_details (HRMSTRANSDETAILS_CODE,HRMSTRANSDETAILS_TRANSCODE, HRMSTRANSDETAILS_AMOUNT,HRMSTRANSDETAILS_TYPE,HRMSTRANSDETAILS_USERCODE,HRMSTRANSDETAILS_DESC,HRMSTRANSDETAILS_DATE,HRMSTRANSDETAILS_OPENING_BAL,HRMSTRANSDETAILS_CLOSING_BAL) VALUES 
		(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').", ".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('g').",".$sql->Param('g').")"),array($ucode,$wcode,$peramt,'1','AD1012','Credit Account',date('Y-m-d'),$hewalebal,$hewaleclose));
			print $sql->ErrorMsg();


		$amtbal = $amtvalu - $pervalu;

			$stmt = $sql->Execute($sql->Prepare("UPDATE hms_wallets SET HRMSWAL_BALANCE = HRMSWAL_BALANCE + ".$sql->Param('a')." WHERE HRMSWAL_USERCODE =".$sql->Param('b').""),array($amtbal,$userCourier));
			print $sql->ErrorMsg();

			$ucode = uniqid();
			$courierclose = $courierbal + $amtbal; 
			$sql->Execute($sql->Prepare("INSERT INTO hms_wallet_transaction_details (HRMSTRANSDETAILS_CODE,HRMSTRANSDETAILS_TRANSCODE, HRMSTRANSDETAILS_AMOUNT,HRMSTRANSDETAILS_TYPE,HRMSTRANSDETAILS_USERCODE,HRMSTRANSDETAILS_DESC,HRMSTRANSDETAILS_DATE,HRMSTRANSDETAILS_OPENING_BAL,HRMSTRANSDETAILS_CLOSING_BAL) VALUES 
		(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').", ".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('g').",".$sql->Param('g').")"),array($ucode,$wcode,$amtbal,'1',$userCourier,'Credit Account',date('Y-m-d'),$courierbal,$courierclose));
			print $sql->ErrorMsg();

		}
		
		}

		}
	}

				
		$msg = "Successful: Delivery code is confirmed. Pls make delivery";
		$status = "success";
		$view = '';
	
		}ELSE{
		
		$msg = "Failed. Delivery code is wrong.";
		$status = "error";
		$view ='edit';
			
	}
	}   


	break;



	// 23 NOV 2018, JOSEPH ADORBOE
	case "confirmpickup":

	if(empty($keys)){

	       
		$msg = "Failed. Required field(s) can't be empty!.";
		$status = "error";
		$view ='edit';
		
		
	}else{
		  
			
		$stmt = $sql->Execute($sql->Prepare("UPDATE hmsb_courier_basket SET COB_STATUS =".$sql->Param('a')." WHERE COB_PRESCRIPTIONCODE =".$sql->Param('b').""),array('4',$keys));
		print $sql->ErrorMsg();

		$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hmsb_courier_basket WHERE COB_PRESCRIPTIONCODE =".$sql->Param('a')." "),array($keys));
		print $sql->ErrorMsg();

		if($stmt->RecordCount()>0){
			
			$editobj = $stmt->FetchNextObject();
			
			$dat = $editobj->COB_DATE;
   			$trackingcode = $editobj->COB_TRACKINGCODE;
			$patient = $editobj->COB_PATIENT;
			$patientnum = $editobj->COB_PATIENTNUM;
            $phone = $editobj->COB_PATIENTPHONENUM;
			$deliverylocation = $editobj->COB_DELIVERYLOCATION;
			$visitcode = $editobj->COB_VISITCODE;
			$pickupcode = $editobj->COB_PICKUPCODE;
			$pharmacy = $editobj->COB_PHARMACY;
			$pharmacyloc = $editobj->COB_PHARMACYLOCATION;
			$pharmacyphone = $editobj->COB_PHARMACYPHONE;
			$agent = $editobj->COB_AGENTCODE;
			$agentnam = $editobj->COB_AGENT;
			$delstatus = $editobj->COB_STATUS;
			
			$prescriptioncode = $editobj->COB_PRESCRIPTIONCODE;
			$stmtpris =  $sql->Execute($sql->prepare("SELECT * from hmsb_courier_basket where COB_TRACKINGCODE = ".$sql->Param('1').""),array($keys));
			print $sql->ErrorMsg();
        
		}
		
		
		$msg = "Successful: Pickup is confirmed. Package Now in transit";
		$status = "success";
		$view = 'edit';
	
		
			
	}
	   


	break;

	

	
	
	// 21 NOV 2018 , JOSEPH ADORBOE 
	case "edit":

	

	$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hmsb_courier_basket WHERE COB_PRESCRIPTIONCODE =".$sql->Param('a')." "),array($keys));
		print $sql->ErrorMsg();

		if($stmt->RecordCount()>0){
			
			$editobj = $stmt->FetchNextObject();
			
			$dat = $editobj->COB_DATE;
   			$trackingcode = $editobj->COB_TRACKINGCODE;
			$patient = $editobj->COB_PATIENT;
			$patientnum = $editobj->COB_PATIENTNUM;
            $phone = $editobj->COB_PATIENTPHONENUM;
			$deliverylocation = $editobj->COB_DELIVERYLOCATION;
			$visitcode = $editobj->COB_VISITCODE;
			$pickupcode = $editobj->COB_PICKUPCODE;
			$pharmacy = $editobj->COB_PHARMACY;
			$pharmacyloc = $editobj->COB_PHARMACYLOCATION;
			$pharmacyphone = $editobj->COB_PHARMACYPHONE;
			$agent = $editobj->COB_AGENTCODE;
			$agentnam = $editobj->COB_AGENT;
			$delstatus = $editobj->COB_STATUS;
			
			$prescriptioncode = $editobj->COB_PRESCRIPTIONCODE;
			$stmtpris =  $sql->Execute($sql->prepare("SELECT * from hmsb_courier_basket where COB_TRACKINGCODE = ".$sql->Param('1').""),array($keys));
			print $sql->ErrorMsg();
        
		}
		
	break;
	

	
	case"updatecourierprocess":
		
		$stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_prescription SET PRESC_STATUS='5', PRESC_COUR_AGENTCODE=".$sql->Param('a').", PRESC_COUR_CODE=".$sql->Param('b').", PRESC_COUR_TRACKCODE=".$sql->Param('c')." WHERE PRESC_PICKUPCODE=".$sql->Param('d')),array($agentcode,$userCourier,$ccode,$keys));
		
		
		
		
		$postkey = $session->get("postkey");
		if($postkey != $microtime){
	$session->set("postkey",$microtime);
	
		$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_courierprocesses WHERE CS_PICKUPCODE=".$sql->Param('a')."  "),array($keys));
			print $sql->ErrorMsg();
		
		if($stmt->RecordCount()>0){
				$msg = "Failed, Prescription has been processed already.";
	    		$status = "error";
		}else {
	
			$processdate = date("Y-m-d",strtotime($startdate));
			$sql->Execute($sql->Prepare("INSERT INTO hms_courierprocesses (CS_CODE,CS_PICKUPCODE, CS_AGENTCODE,CS_INSTUID,CS_DATE,CS_VISITCODE) VALUES (".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').", ".$sql->Param('e').",".$sql->Param('f').")"), array($ccode,$keys,$agentcode, $userCourier,$processdate,$visitcode));
		print $sql->ErrorMsg();


		$msg = "Courier Delivery Initiated Successfully.";
	    $status = "success";
        $activity = "Courier Delivery Initiated.";
		$engine->setEventLog("011",$activity);
		
		
		//Send Notification to Patients
		$code = '023';
        $desc = 'Package is in Transit';
        $menudetailscode = '0018';
        $tablerowid = $presccode;
        $engine->setNotification($code,$desc,$menudetailscode,$tablerowid,$sentto="$patcode",$faccodeout="$couriercode");
		
		//Clear Notifications

		$engine->ClearNotification($menudetailscode,$tablerowid);
		
		}
	}
	
	break;
	
	
	case "getdeliverygeolocation": 

	if(!empty($keys)){
		   $stmt = $sql->Execute($sql->Prepare("SELECT BRO_LATITUDE, BRO_LONGITUDE FROM hms_broadcast_prescription WHERE BRO_PRESCCODE = ".$sql->Param('a')." "),array($keys)); 
		   if($stmt->RecordCount() > 0){
			   $obj = $stmt->FetchNextObject(); 
			   $end = "'".$obj->BRO_LATITUDE.','.$obj->BRO_LONGITUDE."'";
			}
		}
	break;
	
	
	case "updatedelivery":

	$responses = "Parcel is in Delivered. Thank you for doing Business with us.";
	
	$stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_prescription SET PRESC_STATUS='6' WHERE PRESC_PICKUPCODE=".$sql->Param('a')),array($keys));
	
	$stmt = $sql->Execute($sql->Prepare("UPDATE hms_courierprocesses SET CS_STATUS='6' WHERE CS_PICKUPCODE=".$sql->Param('a')),array($keys));
	
	/*$stmtp = $sql->Execute($sql->Prepare("UPDATE hms_notifications SET NOT_DETAILS=".$sql->Param('a').", NOT_STATUS='0' WHERE NOT_CODE=".$sql->Param('a')),array($responses,$keys));*/
		
		
        $msg = "Prescription Delivered Successfully.";
	    $status = "success";
        $activity = "Prescription Delivered Successfully.";
		$engine->setEventLog("012",$activity);
	
	
	break;


	case "reset":
	$fdsearch = "";
	break;
	
	
}



	if(!empty($fdsearch)){

		$query = "SELECT * FROM hmsb_courier_basket WHERE COB_STATUS IN ('2','3','4')  AND COB_COURIERCODE = ".$sql->Param('1')." AND ( COB_PATIENT like ".$sql->Param('2')." or COB_PICKUPCODE like ".$sql->Param('3').") ";
		
		$input = array($userCourier,'%'.$fdsearch.'%','%'.$fdsearch.'%');
	
	}else{

	
	$query = "SELECT * FROM hmsb_courier_basket WHERE COB_STATUS IN ('2','3','4') AND COB_COURIERCODE =".$sql->Param('a')." and COB_AGENTCODE =".$sql->Param('a')."   "; $input = array($userCourier,$agentcode);
	

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