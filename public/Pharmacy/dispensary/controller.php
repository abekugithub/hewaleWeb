<?php
//$sms = new smsgatewayClass();
include ('model/js.php');
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$patientCls = new patientClass();
$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();
$objdtls = $engine->getFacilityDetails();
$facilityalias = $objdtls->FACI_ALIAS ;
$faciname=$objdtls->FACI_NAME;
$faccode = $objdtls->FACI_CODE ;
//echo $faccode;die();
$engine = new engineClass();
$patientCls = new patientClass();
$sms = new smsgetway();

switch($viewpage){
	#################################################################################################
	/**
	 * VIEW THE PREPARED SALES BY THE PHARMACY
	**/
	#################################################################################################
 case 'sales':
 	//to find the delivery status from the prescription main table
 	$stmtstatus=$sql->Execute($sql->Prepare("SELECT PRESCM_DEL_STATUS from hms_patient_prescription_main WHERE PRESCM_PACKAGECODE=".$sql->Param('a')." "),array($keys));
 	print $sql->ErrorMsg();
 	if ($stmtstatus->RecordCount()>0){
 		$objstatus=$stmtstatus->FetchNextObject();
 		$deliverystatus=$objstatus->PRESCM_DEL_STATUS;
 	}
 	//build courier select
 	$stmtcourierlov= $sql->Execute($sql->Prepare("SELECT CS_COURIERNAME,CS_COURIERCODE FROM hms_pharmcourierselection WHERE CS_PHARMCODE=".$sql->Param('a')." ORDER BY CS_COURIERNAME ASC"),array($faccode));
 	
 	$stmt = $sql->Execute($sql->Prepare("SELECT PRESC_VISITCODE,PRESC_DRUGID,PRESC_DRUG,PRESC_QUANTITY,PRESC_DOSAGENAME,PRESC_QUANTITY,'HEWALE' AS PRESC_METHOD,PRESC_TOTAL,PEND_TOTAL,PEND_UNITPRICE,PRESC_UNITPRICE,PRESC_PATIENT,PRESC_PATIENTNUM,PRESC_PICKUPCODE,PRESC_DEL_STATUS,PEND_QUANTITY,PRESC_PACKAGECODE,PRESC_DATE,PEND_GRAND_TOTAL,PEND_TOTALCOMMISSION FROM hms_patient_prescription LEFT JOIN hms_pending_prescription ON PEND_PACKAGECODE=PRESC_PACKAGECODE AND PRESC_CODE=PEND_PRESC_CODE WHERE PRESC_PACKAGECODE=".$sql->Param('a')."  "),array($keys));
 	 if ($stmt->RecordCount()>0){
 	 	$totalcommission=0;
 	 	
 	 	while($obj=$stmt->FetchNextObject()){
 	 		$customername=$obj->PRESC_PATIENT;
 	 		$hewalenumber=$obj->PRESC_PATIENTNUM;
 	 		$patientnum=$obj->PRESC_PATIENTNUM;
 	 		$prescdate=$obj->PRESC_DATE;
 	 		$drugs = $encaes->decrypt($obj->PRESC_DRUG);
			$drugid = $encaes->decrypt($obj->PRESC_DRUGID);
			$pickupcode = $obj->PRESC_PICKUPCODE;
			$visitcode=$obj->PRESC_VISITCODE;
			$packagecode=$obj->PRESC_PACKAGECODE;
			$totalcommission=$totalcommission+$obj->PEND_TOTALCOMMISSION;
			//$deliverystatus=$obj->PRESC_DEL_STATUS;
			$finalgrandtotal=$obj->PEND_GRAND_TOTAL;
 	 		$cart[$obj->PRESC_DRUGID]=array('CODE'=>$drugid,'NAME'=>$drugs,'DOSAGE'=>$obj->PRESC_DOSAGENAME,'COST'=>$obj->PEND_UNITPRICE,'QUANTITY'=>$obj->PEND_QUANTITY,'METHOD'=>$obj->PRESC_METHOD,'TOTAL'=>$obj->PRESC_TOTAL);
 	 	}
 	 	$stmtpatdetails= $sql->Execute($sql->Prepare("SELECT PATIENT_PHONENUM,CONCAT(PATIENT_FNAME,' ',PATIENT_MNAME,' ',PATIENT_LNAME) AS PATIENT_FULLNAME, PATIENT_GENDER, YEAR(CURDATE()) - YEAR(PATIENT_DOB) AS PATIENT_DOB,PATIENT_ALLERGIES from hms_patient WHERE PATIENT_PATIENTNUM=".$sql->Param('a').""),array($hewalenumber));
 	 	$objdet=$stmtpatdetails->FetchNextObject();
 	 	$patphonenumber=$objdet->PATIENT_PHONENUM;
 	 	$patgender=$objdet->PATIENT_GENDER;
 	 	$patage=$objdet->PATIENT_DOB;
 	 	$patalergies=$objdet->PATIENT_ALERGIES;
 	 	//$patientfullname=$objdet->PATIENT_FULLNAME;;
 	 }
 	 
 	
 	break;

	#################################################################################################
	/**
	 * SAVE THE SALES THAT HAS BEEN PREPARED BY THE PHARMACY
	**/
	#################################################################################################
 case 'savesales':
 	if ($deliverystatus=='1' && empty($courier)){//to find the delivery status from the prescription main table
 	$stmtstatus=$sql->Execute($sql->Prepare("SELECT PRESCM_DEL_STATUS from hms_patient_prescription_main WHERE PRESCM_PACKAGECODE=".$sql->Param('a')." "),array($keys));
 	print $sql->ErrorMsg();
 	if ($stmtstatus->RecordCount()>0){
 		$objstatus=$stmtstatus->FetchNextObject();
 		$deliverystatus=$objstatus->PRESCM_DEL_STATUS;
 	}
 	//build courier select
 	$stmtcourierlov= $sql->Execute($sql->Prepare("SELECT CS_COURIERNAME,CS_COURIERCODE FROM hms_pharmcourierselection WHERE CS_PHARMCODE=".$sql->Param('a')." ORDER BY CS_COURIERNAME ASC"),array($faccode));
 	
 	$stmt = $sql->Execute($sql->Prepare("SELECT PRESC_VISITCODE,PRESC_DRUGID,PRESC_DRUG,PRESC_QUANTITY,PRESC_DOSAGENAME,PRESC_QUANTITY,'HEWALE' AS PRESC_METHOD,PRESC_TOTAL,PEND_TOTAL,PEND_UNITPRICE,PRESC_UNITPRICE,PRESC_PATIENT,PRESC_PATIENTNUM,PRESC_PICKUPCODE,PRESC_DEL_STATUS,PEND_QUANTITY,PRESC_PACKAGECODE,PRESC_DATE,PEND_GRAND_TOTAL,PEND_TOTALCOMMISSION FROM hms_patient_prescription LEFT JOIN hms_pending_prescription ON PEND_PACKAGECODE=PRESC_PACKAGECODE AND PRESC_CODE=PEND_PRESC_CODE WHERE PRESC_PACKAGECODE=".$sql->Param('a')."  "),array($keys));
 	 if ($stmt->RecordCount()>0){
 	 	$totalcommission=0;
 	 	while($obj=$stmt->FetchNextObject()){
 	 		$customername=$obj->PRESC_PATIENT;
 	 		$hewalenumber=$obj->PRESC_PATIENTNUM;
 	 		$patientnum=$obj->PRESC_PATIENTNUM;
 	 		$prescdate=$obj->PRESC_DATE;
 	 		$drugs = $encaes->decrypt($obj->PRESC_DRUG);
			$drugid = $encaes->decrypt($obj->PRESC_DRUGID);
			$pickupcode = $obj->PRESC_PICKUPCODE;
			$visitcode=$obj->PRESC_VISITCODE;
			$packagecode=$obj->PRESC_PACKAGECODE;
			$totalcommission=$totalcommission+$obj->PEND_TOTALCOMMISSION;
			//$deliverystatus=$obj->PRESC_DEL_STATUS;
			$finalgrandtotal=$obj->PEND_GRAND_TOTAL;
			//$totalcommission=$obj->PEND_TOTALCOMMISSION;
 	 		$cart[$obj->PRESC_DRUGID]=array('CODE'=>$drugid,'NAME'=>$drugs,'DOSAGE'=>$obj->PRESC_DOSAGENAME,'COST'=>$obj->PEND_UNITPRICE,'QUANTITY'=>$obj->PEND_QUANTITY,'METHOD'=>$obj->PRESC_METHOD,'TOTAL'=>$obj->PRESC_TOTAL);
 	 	}
 	 	$stmtpatdetails= $sql->Execute($sql->Prepare("SELECT PATIENT_PHONENUM,PATIENT_GENDER, YEAR(CURDATE()) - YEAR(PATIENT_DOB) AS PATIENT_DOB,PATIENT_ALLERGIES from hms_patient WHERE PATIENT_PATIENTNUM=".$sql->Param('a').""),array($hewalenumber));
 	 	$objdet=$stmtpatdetails->FetchNextObject();
 	 	$patphonenumber=$objdet->PATIENT_PHONENUM;
 	 	$patgender=$objdet->PATIENT_GENDER;
 	 	$patage=$objdet->PATIENT_DOB;
 	 	$patalergies=$objdet->PATIENT_ALERGIES;
 	 }
 	 $msg="Courier has to be selected";
 	$status="error";
 	$view="sales";
 	}else{
 		$stmtcommission=$sql->Execute($sql->Prepare("SELECT SUM(PEND_TOTALCOMMISSION) PEND_TOTALCOMMISSION FROM hms_pending_prescription WHERE  PEND_PACKAGECODE=".$sql->Param('b').""),array($keys));
 	 	if ($stmtcommission->RecordCount()>0){
 	 		$objcommission=$stmtcommission->FetchNextObject();
 	 		$totalcommission=$objcommission->PEND_TOTALCOMMISSION;
 	 	}
 	 	$instpercent= $sql->Execute($sql->Prepare("SELECT PEND_PERCENTAGE from hms_pending_prescription WHERE PEND_PACKAGECODE=".$sql->Param('a').""),array($keys));
		if ($instpercent->RecordCount()>0){
			$objcent=$instpercent->FetchNextObject();
			$facilitypercent=$objcent->PEND_PERCENTAGE;
		}else{
		$facilitypercent='0';
		}
		$facilitypercent=($facilitypercent/100);
 	 $session->del('pickupcode');	
	$session->del('salecode');
	$salecode = $engine->pharmacysaleCode();
	$salesid = date('Ymdhis').uniqid().$usrcode;
	$courierarray=(!empty($courier)?explode('|',$courier):'');
 	$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_pharmacysales(SAL_CODE, SAL_DRUGCODE, SAL_DRUG, SAL_DOSAGE, SAL_QUANTITY, SAL_COST, SAL_NHIS, SAL_CUSTOMER, SAL_USERCODE, SAL_USERNAME, SAL_FACICODE, SAL_METHOD, SAL_METHODCODE, SAL_STATUS,SAL_TOTALCOMMISSION,SAL_GRANDTOTAL, SAL_UNIQCODE) SELECT '$salecode',PRESC_DRUGID,PRESC_DRUG,PRESC_DOSAGENAME,PEND_QUANTITY,(PEND_UNITPRICE +(PEND_UNITPRICE*$facilitypercent)) AS PEND_UNITPRICE,'0',PRESC_PATIENT,'$usrcode','$usrname','$faccode','HEWALE','000','1','$totalcommission',PEND_GRAND_TOTAL,'$salesid' from hms_patient_prescription JOIN hms_pending_prescription ON PEND_PACKAGECODE=PRESC_PACKAGECODE AND PRESC_CODE=PEND_PRESC_CODE WHERE PRESC_PACKAGECODE= ".$sql->Param('a').""),array($packagecode));
 	print $sql->ErrorMsg();
 	//echo $stmt[EOF];	
 
 	if ($stmt==TRUE){
 		
 		if ($deliverystatus=='1'){
 		$pickupcode = $engine->pickupcode();
		$receivercode = rand(999,10000);
		$tablerowid=$sql->insert_Id();
		$desc='Courier has been requested';
		$engine->setNotification('013',$desc,'0018',$tablerowid,$courierarray[0],$courierarray[0]);
		$sql->Execute($sql->Prepare("INSERT INTO hms_prescriptioncode(C_PICKUPCODE,C_RECIVERCODE,C_DATE) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').")"),array($pickupcode,$receivercode,date('Y-M-d')));
		$stmtpatdetails= $sql->Execute($sql->Prepare("SELECT PATIENT_PHONENUM,PATIENT_GENDER, YEAR(CURDATE()) - YEAR(PATIENT_DOB) AS PATIENT_DOB,PATIENT_ALLERGIES from hms_patient WHERE PATIENT_PATIENTNUM=".$sql->Param('a').""),array($hewalenumber));
 	 	$objdet=$stmtpatdetails->FetchNextObject();
 	 	$patientphone=$objdet->PATIENT_PHONENUM;
		//$patientphone= $patientobj->PATIENT_PHONENUM;
		$pmessage="Receiver code :$receivercode for hewale prescription";
		$sms->sendSms($patientphone,$pmessage);
 		}else{
 		$pickupcode = $engine->pickupcode();
		$receivercode = rand(999,10000);
		$tablerowid=$sql->insert_Id();
		$sql->Execute($sql->Prepare("INSERT INTO hms_prescriptioncode(C_PICKUPCODE,C_RECIVERCODE,C_DATE) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').")"),array($pickupcode,$receivercode,date('Y-M-d')));
		$stmtpatdetails= $sql->Execute($sql->Prepare("SELECT PATIENT_PHONENUM,PATIENT_GENDER, YEAR(CURDATE()) - YEAR(PATIENT_DOB) AS PATIENT_DOB,PATIENT_ALLERGIES from hms_patient WHERE PATIENT_PATIENTNUM=".$sql->Param('a').""),array($hewalenumber));
 	 	$objdet=$stmtpatdetails->FetchNextObject();
 	 	$patientphone=$objdet->PATIENT_PHONENUM;
		#$patientphone= $patientobj->PATIENT_PHONENUM;
		$pmessage="Receiver code :$receivercode for hewale prescription";
		$sms->sendSms($patientphone,$pmessage);
 			
 			
 		}
 		
 		$stmtup= $sql->Execute($sql->Prepare("UPDATE hms_pending_prescription SET PEND_STATUS=".$sql->Param('a').", PEND_COUR_CODE=".$sql->Param('b').", PEND_COUR_NAME=".$sql->Param('c')." WHERE PEND_PACKAGECODE=".$sql->Param('a')." AND PEND_FACICODE=".$sql->Param('b').""),array('4',$courierarray[0],$courierarray[1],$packagecode,$faccode));
 		$stmtup2=$sql->Execute($sql->Prepare("UPDATE hms_broadcast_prescription SET BRO_STATUS=".$sql->Param('a')." WHERE BRO_PRESCCODE=".$sql->Param('b')." AND BRO_STATUS=".$sql->Param('d')." "),array('4',$packagecode,'3'));
 		
 		
 		//move values from transit table to wallet table if there's a courier involved
 		if ($deliverystatus=='1'){
 		$st=$sql->Execute($sql->Prepare("SELECT HRMSTRANS_CONFIRM_STATUS from hms_wallet_transaction WHERE HRMSTRANS_PACKAGECODE=".$sql->Param('a')." "),array($packagecode));
 		if ($st->RecordCount()>0){
 		$ot=$st->FetchNextObject();
 		$not=$ot->HRMSTRANS_CONFIRM_STATUS;
 		if ($not=='1'){
 			#echo "BiiiiiiiiiiiiiiiiiiiIM";die();
 		$stmtup=$sql->Execute($sql->Prepare("UPDATE hms_wallet_transaction SET HRMSTRANS_COURIER_NAME=".$sql->Param('a').",HRMSTRANS_COURIER_CODE=".$sql->Param('b')." WHERE HRMSTRANS_PACKAGECODE=".$sql->Param('c')." "),array($courierarray[1],$courierarray[0],$packagecode));
 		}else{
 			#echo "BM";die();
 		}
 		}
 			#$stmtup=$sql->Execute($sql->Prepare("UPDATE hms_wallet_transaction SET HRMSTRANS_COURIER_NAME=".$sql->Param('a').",HRMSTRANS_COURIER_CODE=".$sql->Param('b')." WHERE HRMSTRANS_PACKAGECODE=".$sql->Param('c')." "),array($courierarray[1],$courierarray[0],$packagecode));
 			$stmtup2=$sql->Execute($sql->Prepare("UPDATE hms_patient_prescription SET PRESC_COUR_CODE=".$sql->Param('b').", PRESC_COUR_NAME=".$sql->Param('c').",PRESC_PICKUPCODE=".$sql->Param('v').",PRESC_RECIVERCODE=".$sql->Param('v').",PRESC_REMARKS=".$sql->Param('v')." WHERE PRESC_PACKAGECODE=".$sql->Param('b')." "),array($courierarray[0],$courierarray[1],$pickupcode,$receivercode,$remarks,$packagecode));
		
 			$stmtup2=$sql->Execute($sql->Prepare("UPDATE hms_patient_prescription_main SET PRESCM_COUR_CODE=".$sql->Param('b').", PRESCM_COUR_NAME=".$sql->Param('c').",PRESCM_PICKUPCODE=".$sql->Param('v').",PRESCM_RECIVERCODE=".$sql->Param('v').",PRESCM_REMARKS=".$sql->Param('v')." WHERE PRESCM_PACKAGECODE=".$sql->Param('b')." "),array($courierarray[0],$courierarray[1],$pickupcode,$receivercode,$remarks,$packagecode));
 			
	$ccode = $coder->getcourierCode();
	$engine->getcourieritem($packagecode,$ccode);
		$stmtcash = $sql->Execute($sql->Prepare("SELECT PCP_PHARM_AMT,PCP_COURIER_AMT,PCP_COURIER_CODE,PCP_PATIENTCODE from hms_pharm_courier_price WHERE PCP_PATIENT_VISITCODE =".$sql->Param('a')." AND PCP_PHARM_CODE=".$sql->Param('b')." AND PCP_STATUS=".$sql->Param('c')." "),array($visitcode,$faccode,'0'));
 		if ($stmtcash->RecordCount()>0){
 		$obj = $stmtcash->FetchNextObject();
 		$patientcode=$obj->PCP_PATIENTCODE;
 		$pharmacyamount = $obj->PCP_PHARM_AMT;
 		$courieramount = $obj->PCP_COURIER_AMT;
 		$couriercode= $obj->PCP_COURIER_CODE;
 		}
 		}else{
 			//echo "BONGOOOOOOO";die();
 			$stmtup2=$sql->Execute($sql->Prepare("UPDATE hms_patient_prescription SET PRESC_PICKUPCODE=".$sql->Param('v').",PRESC_REMARKS=".$sql->Param('v')." WHERE PRESC_PACKAGECODE=".$sql->Param('b')." "),array($pickupcode,$remarks,$packagecode));
		
 			$stmtup2=$sql->Execute($sql->Prepare("UPDATE hms_patient_prescription_main SET PRESCM_PICKUPCODE=".$sql->Param('v').",PRESCM_REMARKS=".$sql->Param('v')." WHERE PRESCM_PACKAGECODE=".$sql->Param('b')." "),array($pickupcode,$remarks,$packagecode));
 			
 		$stmtcash = $sql->Execute($sql->Prepare("SELECT WAL_HOLD_AMT,WAL_PATIENTCODE from hms_wallet_trans_holder WHERE WAL_PATIENT_VISITCODE=".$sql->Param('a')." AND WAL_SERV_PROVIDERCODE=".$sql->Param('b')." AND WAL_STATUS=".$sql->Param('c')." "),array($visitcode,$faccode,'0'));
 		if ($stmtcash->RecordCount()>0){
 			$obj =$stmtcash->FetchNextObject();
 			$patientcode=$obj->WAL_PATIENTCODE;
 			$pharmacyamount = $obj->WAL_HOLD_AMT;
 			$courieramount=NULL;
 			$couriercode=NULL;
 		}	
 		}
 		//echo $patientcode."--".$pharmacyamount."--".$faccode."--".$visitcode."--".$couriercode."--".$courieramount;
 		//die();
 		//distribute payment
 		$engine->patienttopharmacyprice($patientcode,$pharmacyamount,$faccode,$visitcode,$couriercode,$courieramount);
 		//reduce quantity by selecting the various quantities
 		    $stcheck =$sql->Execute($sql->Prepare("SELECT PEND_DRUG,PRESC_DOSAGENAME,PEND_QUANTITY from hms_patient_prescription JOIN hms_pending_prescription ON PEND_PACKAGECODE=PRESC_PACKAGECODE AND PRESC_CODE=PEND_PRESC_CODE WHERE PRESC_PACKAGECODE=".$sql->Param('a')." AND PRESC_FACICODE=".$sql->Param('b')." "),array($packagecode,$faccode));
 		    print $sql->ErrorMsg();
 		     if ($stcheck->RecordCount()>0){
 		     	while ($obj = $stcheck->FetchNextObject()){
 		     		$datarray[]=array('NAME'=>$obj->PEND_DRUG,'DOSAGE'=>$obj->PRESC_DOSAGENAME,'QUANTITY'=>$obj->PEND_QUANTITY);
 		     	}
 		     	if (is_array($datarray) && count($datarray)>0){
 		     		
 		     		foreach ($datarray as $key){
 		     			$dname =$encaes->decrypt($key['NAME']);
 		     			//make the subtraction
 		     			$lister =$sql->Execute($sql->Prepare("UPDATE hms_pharmacystock SET ST_STORE_QTY=ST_STORE_QTY- ".$sql->Param('a')." WHERE ST_NAME=".$sql->Param('b')." AND ST_DOSAGENAME=".$sql->Param('c')." "),array($key['QUANTITY'],$dname,$key['DOSAGE']));	
 		     			print $sql->ErrorMsg();		
 		     		//	print_r($lister);
 		     		}
 		     	}
 		     //	die();
 		     }
 		     //update the state to transit
 		     $newstate=($deliverystatus=='1')?'4':'5';
 		  $sql->Execute($sql->Prepare("UPDATE hms_patient_prescription SET PRESC_STATUS=".$sql->Param('a').",PRESC_STATE=".$sql->Param('b')." WHERE PRESC_PACKAGECODE=".$sql->Param('c')." "),array($newstate,'4',$packagecode));  
		   print $sql->ErrorMsg(); 
		    //update main state to transit
 		  $sql->Execute($sql->Prepare("UPDATE hms_patient_prescription_main SET PRESCM_STATUS=".$sql->Param('a').",PRESCM_STATE=".$sql->Param('b')." WHERE PRESCM_PACKAGECODE=".$sql->Param('c')." "),array($newstate,'4',$packagecode));  
		   print $sql->ErrorMsg(); 

	


 	if ($deliverystatus=='1'){
		
 		$msg="Sale successfully completed with pickup code $pickupcode";
 		  }else{
 		  	$msg="Sale successfully completed";
 		  }
 		$status="success";
 		$session->set('salecode',$salecode);
 		$session->set('pickupcode',$pickupcode);
 		$view="receipt";
 		//to clear notification we need to get the latest row id
 		$stmt_clear=$sql->Execute($sql->Prepare("SELECT PRESCM_PACKAGECODE from hms_patient_prescription_main WHERE PRESCM_VISITCODE=".$sql->Param('a')." AND (PRESCM_STATUS=".$sql->Param('b')." OR PRESCM_STATUS=".$sql->Param('c').") ORDER BY PRESCM_INPUTEDDATE DESC LIMIT 1"),array($visitcode,'4','5'));
 		if($stmt_clear->RecordCount()>0){
 			while($obj_clear=$stmt_clear->FetchNextObject()){
 				$tablerowid=$obj_clear->PRESCM_PACKAGECODE;
 			}
 		}else{
 			$tablerowid='';
 		}
 		$engine->ClearNotification('0015',$tablerowid);
 	}else{
 		$msg="Sale not processed, please try again.";
 		$status="error";
 		$view="";
 	}
 	}
 	break;
 	/**BEGINING OF IMAGESALE **/
 	#################################################################################################
	/**
	 * PREPARE THE IMAGE WHEN IMAGE IS SENT TO THE PHARMACY
	**/
	#################################################################################################
	case 'prepareimage'://prepare the drugs
	//	print_r($_REQUEST);die();
	
	$stmtcourierlov= $sql->Execute($sql->Prepare("SELECT CS_COURIERNAME,CS_COURIERCODE FROM hms_pharmcourierselection WHERE CS_PHARMCODE=".$sql->Param('a')." ORDER BY CS_COURIERNAME ASC"),array($faccode));
	$stmt=$sql->Execute($sql->Prepare("SELECT PRESCM_PATIENT,PRESCM_PATIENTCODE,PRESCM_PATIENTNUM,PRESCM_DATE,PRESCM_VISITCODE,PRESCM_ENCRYPKEY,PRESCM_PACKAGECODE,PRESCM_DEL_STATUS,PRESCM_TOTAL,PRESCM_OTHERAGE,PRESCM_OTHERGENDER,PRESCM_IMAGE from hms_patient_prescription_main WHERE PRESCM_PACKAGECODE=".$sql->Param('a')." "),array($keys));
	print $sql->ErrorMsg();
	if ($stmt->RecordCount()>0){
		while ($obj=$stmt->FetchNextObject()){
		$patientname=$obj->PRESCM_PATIENT;
		$patientcode=$obj->PRESCM_PATIENTCODE;
		$patientnum=$obj->PRESCM_PATIENTNUM;
		$prescdate=$obj->PRESCM_DATE;
		$prescvisitcode=$obj->PRESCM_VISITCODE;	
		$prescencrypt=$obj->PRESCM_ENCRYPKEY;
		$packagecode=$obj->PRESCM_PACKAGECODE;
		$deliverystatus=$obj->PRESCM_DEL_STATUS;
		$expectedtotal=$obj->PRESCM_TOTAL;
		$behalfage=$obj->PRESCM_OTHERAGE;
		$behalfgender=$obj->PRESCM_OTHERGENDER;
		$behalfimage=$obj->PRESCM_IMAGE;
		//$presccode =$encaes->decrypt($obj->PRESCM_DRUGID);
		//$presccodearray["$presccode"]=$obj->PRESCM_CODE;
		
		
		}
		$stmtpatdetails= $sql->Execute($sql->Prepare("SELECT PATIENT_PHONENUM,PATIENT_GENDER, YEAR(CURDATE()) - YEAR(PATIENT_DOB) AS PATIENT_DOB,PATIENT_ALLERGIES from hms_patient WHERE PATIENT_PATIENTNUM=".$sql->Param('a').""),array($patientnum));
 	 	$objdet=$stmtpatdetails->FetchNextObject();
 	 	$patphonenumber=$objdet->PATIENT_PHONENUM;
 	 	$patgender=$objdet->PATIENT_GENDER;
 	 	$patage=$objdet->PATIENT_DOB;
 	 	$patalergies=$objdet->PATIENT_ALERGIES;
		}else {
		$patientname="";
		$patientcode="";
		$patientnum="";
		$prescdate="";
		$prescvisitcode="";
		$prescencrypt="";
		$prescode="";
		}
	//$session->del('salecode');
	$pendingcode = $engine->getPendingCode();
	$presccode = $engine->getprescriptionCode('hms_patient_prescription','DR','PRESC_CODE');
	//$presccode = $engine->getprescriptionCode();
	$salesid = date('Ymdhis').uniqid().$usrcode;
	$counter= is_array($_POST['code'])?count($_POST['code']):0;
	for($i=1;$i<=$counter;$i++){
		if ($_POST['type'][$i]=='NEW'){
			$newdrugs[]=$i;
		}
		$finarray[] = '(
				"'.$pendingcode.'",
				"'.$presccode.'",
				"'.$patientname.'",
				"'.$patientcode.'",
				"'.$patientnum.'",
				"'.$prescdate.'",
				"'.$prescvisitcode.'",
				"'.$encaes->encrypt($_POST['code'][$i]).'",
				"'.$encaes->encrypt($_POST['drugname'][$i]).'",
				"'.$_POST['quantity'][$i].'",
				"'.$_POST['cost'][$i].'",
				"'.number_format($_POST['quantity'][$i] *$_POST['cost'][$i],2).'",
				"'.'1'.'",
				"'.$faccode.'",
				"'.$usrname.'",
				"'.$usrcode.'",
				"'.$faccode.'",
				"'.$faciname.'",
				"'.$prescencrypt.'",
				"'.$packagecode.'"
			)';
			$initial=substr($presccode,0,5);
			$number=substr($presccode,5,7);
			$number=str_pad($number +1,7,0,STR_PAD_LEFT);
			$presccode=$initial.$number;
			$initial=substr($pendingcode,0,5);
			$number=substr($pendingcode,5,7);
			$number=str_pad($number +1,6,0,STR_PAD_LEFT);
			$pendingcode=$initial.$number;
	}
	if(!empty($newdrugs) && count($newdrugs)>0)//if there are new drugs previously not entered
	{
		$pharmacypricecode=$engine->getpharmacypricecode();
		foreach ($newdrugs as $newdrugindex){
			
			$newdrugsarray[] = '(
				"'.$_POST['drugname'][$newdrugindex].'",
				"'.$_POST['dosagename'][$newdrugindex].'",
				"'.$_POST['dosagecode'][$newdrugindex].'",
				"'.$_POST['code'][$newdrugindex].'",
				"'.date('Y-m-d').'",
				"'.$faccode.'"
			)';
			$newpricearray[] = '(
			
				"'.$pharmacypricecode.'",
				"'.$faccode.'",
				"'.'CASH'.'",
				"'.'PMT0010'.'",
				"'.'PC0001'.'",
				"'.$_POST['drugname'][$newdrugindex].'",
				"'.$_POST['code'][$newdrugindex].'",
				"'.$_POST['cost'][$newdrugindex].'"
			
			)';
			$initial=substr($pharmacypricecode,0,3);
			$number=substr($pharmacypricecode,3,7);
			$number=str_pad($number +1,7,0,STR_PAD_LEFT);
			$pharmacypricecode=$initial.$number;
			
		}
	}
	$cartprepare = $session->get('cartprepare');
	if(!empty($_POST['code']) && count($_POST['code'])>0){
	
		$newdrugsarray = is_array($newdrugsarray)?implode(',', $newdrugsarray):'';
		$newpricearray = is_array($newpricearray)?implode(',', $newpricearray):'';
	//	print_r($_REQUEST);die();
  		$listtomove = is_array($finarray)?implode(',', $finarray):'';
  		//echo $listtomove; die();
  		//INSERT INTO the sales table
  		$stmt= $sql->Execute($sql->Prepare("INSERT INTO hms_pending_prescription(PEND_CODE,PEND_PRESC_CODE, PEND_PATIENT,PEND_PATIENTCODE, PEND_PATIENTNUM,PEND_DATE,PEND_VISITCODE,PEND_DRUGID,PEND_DRUG,PEND_QUANTITY,PEND_UNITPRICE,PEND_TOTAL,PEND_STATUS,PEND_INSTCODE,PEND_ACTORNAME,PEND_ACTORCODE,PEND_FACICODE,PEND_PHARMNAME,PEND_ENCRYPKEY,PEND_PACKAGECODE)VALUES $listtomove"));
  		print $sql->ErrorMsg();
  		if ($stmt==TRUE){
  			//INSERT NEW DRUGS
  			if(!empty($newdrugs) && count($newdrugs)>0){
  			$stmtins=$sql->Execute($sql->Prepare("INSERT INTO hms_pharmacystock(ST_NAME,ST_DOSAGENAME,ST_DOSAGE,ST_CODE,ST_DATE,ST_FACICODE) VALUES $newdrugsarray"));
  			$stmtinsprice=$sql->Execute($sql->Prepare("INSERT INTO hms_pharmacyprice(PPR_CODE,PPR_FACICODE,PPR_METHOD,PPR_METHODCODE,PPR_CATEGORYCODE,PPR_DRUG,PPR_DRUGCODE,PPR_PRICE) VALUES $newpricearray"));
  		}
  			$stmtupdate=$sql->Execute($sql->Prepare("UPDATE hms_broadcast_prescription SET BRO_STATUS=".$sql->Param('a')." WHERE BRO_PHARMACYCODE=".$sql->Param('b')." AND BRO_PRESCCODE=".$sql->Param('c')." "),array('2',$faccode,$packagecode));
  			//deduct quantity from stock
  			/**
  			foreach ($cartprepare as $key){
  			$stmtreset = $sql->Execute($sql->Prepare("UPDATE hms_patient_prescription SET PRESC_VISITCODE=CONCAT(PRESC_VISITCODE,".$sql->Param('a')."),PRESC_STATE=".$sql->Param('b').",PRESC_STATUS=".$sql->Param('c')." WHERE PRESC_INSTCODE=".$sql->Param('d')." AND PRESC_VISITCODE=".$sql->Param('e')." "),array("IMAGEPROCESSED",'6','0',$faccode,$visitcode));
  			print $sql->ErrorMsg();
  			}
  			if ($stmtreset==TRUE){
  				$view="";
  				$msg="Prescription image successfully prepared";
  				$status="success";
  				$session->del('cartprepare');
  				
  			}**/
  				$view="";
  				$msg="Prescription image successfully prepared";
  				$status="success";
  				$session->del('cartprepare');
  		}else{
  			$view="prepareimage";
  			$msg="Prescription could not be prepared, please try again";
  			$status="error";
  			
  		}
	//	die();
	
	}/**else{
		$msg='Please select a drug';
		$status='error';
		$view="prepareimage";
	}**/
	break;	
 		
 	/** END OF IMAGE SALES**/
 	
	#################################################################################################
	/**
	 * SAVE THE IMAGE SENT TO THE PHARMACY
	**/
	#################################################################################################
 
 	
 	case 'saveimagesales':
 		//echo $packagecode; die();
 		if ($deliverystatus=='1' && empty($courier)){
 		$msg="Please select a courier";
 		$status="error";
 		$view="prepareimage";
 		//$viewpage="prepareimage";	
 		}else{
 	$session->del('pickupcode');
 	$session->del('salecode');
 	$salecode = $engine->pharmacysaleCode();
 	$grandtotal=0;
 	$totalcommission=0;
	$salesid = date('Ymdhis').uniqid().$usrcode;
	

	$counter= is_array($_POST['code'])?count($_POST['code']):0;
	for($i=1;$i<=$counter;$i++){
		$grandtotal=$grandtotal+($_POST['cost'][$i]*$_POST['quantity'][$i]);
		$totalcommission=$grandtotal*$facilitypercent;
	}
	$grandtotal=$grandtotal+$totalcommission;
	for($i=1;$i<=$counter;$i++){
		if ($_POST['type'][$i]=='NEW'){
			$newdrugs[]=$i;
		}
		$cost=$_POST['cost'][$i]+($_POST['cost'][$i]*$facilitypercent);
			//INSERT INTO PHARMACY PRESCRIPTION TABLE
	$precode = $engine->getprescriptionCode('hms_patient_prescription','DR','PRESC_CODE');
	 $presid = uniqid();
	 $encrypted_drugname=$encaes->encrypt(trim($_POST['drugname'][$i]));
	 $encrypted_drugcode=$encaes->encrypt(trim($_POST['code'][$i]));
	 $dosage_name=$_POST['dosagename'][$i];
	 $drug_quantity=$_POST['quantity'][$i];
	 $newstate=($deliverystatus=='1')?'4':'5';
	 //$getdetails=$sql->Execute($sql->Prepare("SELECT '$presid','$precode','$packagecode',PRESCM_PATIENT,PRESCM_PATIENTCODE,PRESCM_PATIENTNUM,PRESCM_DATE,PRESCM_VISITCODE,'$encrypted_drugcode','$encrypted_drugname','$drug_quantity','','$dosage_name', '4', '$newstate', PRESCM_INPUTEDDATE, PRESCM_INSTCODE, '$usrname', '$usrcode',PRESCM_COUR_CODE, PRESCM_COUR_NAME,PRESCM_TIME, PRESCM_COUR_AGENTCODE, PRESCM_COUR_TRACKCODE,'$faccode', '$cost', $grandtotal, PRESCM_METHOD, PRESCM_METHODCODE, PRESCM_PHARMNAME, PRESCM_PHARMLOC, PRESCM_PATIENTCONTACT, PRESCM_PATIENTLOC, PRESCM_OTHERAGE, PRESCM_OTHERGENDER, PRESCM_PICKUPCODE, PRESCM_PACKDELCODE, PRESCM_RECIVERCODE, PRESCM_ENCRYPKEY, PRESCM_DEL_STATUS, PRESCM_COURDATE, PRESCM_IMAGE, PRESCM_SOURCE, '$remarks' from hms_patient_prescription_main WHERE PRESCM_PACKAGECODE='$packagecode'"));
	 $getdetails=$sql->Execute($sql->Prepare("SELECT PRESCM_PATIENT,PRESCM_PATIENTCODE,PRESCM_PATIENTNUM,PRESCM_DATE,PRESCM_VISITCODE,PRESCM_INPUTEDDATE, PRESCM_INSTCODE,PRESCM_COUR_CODE, PRESCM_COUR_NAME,PRESCM_TIME, PRESCM_COUR_AGENTCODE, PRESCM_COUR_TRACKCODE, PRESCM_METHOD, PRESCM_METHODCODE, PRESCM_PHARMNAME, PRESCM_PHARMLOC, PRESCM_PATIENTCONTACT, PRESCM_PATIENTLOC, PRESCM_OTHERAGE, PRESCM_OTHERGENDER, PRESCM_PICKUPCODE, PRESCM_PACKDELCODE, PRESCM_RECIVERCODE, PRESCM_ENCRYPKEY, PRESCM_DEL_STATUS, PRESCM_COURDATE, PRESCM_IMAGE, PRESCM_SOURCE from hms_patient_prescription_main WHERE PRESCM_PACKAGECODE=".$sql->Param('a').""),array($packagecode));
	 if ($getdetails->RecordCount()>0){
	 	while ($objp=$getdetails->FetchNextObject()){
	 $getpatientname=$objp->PRESCM_PATIENT;
	 $getpatientcode=$objp->PRESCM_PATIENTCODE;
	 $getpatientnum=$objp->PRESCM_PATIENTNUM;
	 $getpatientdate=$objp->PRESCM_DATE;
	 $getvisitcode=$objp->PRESCM_VISITCODE;
	 $getinputeddate=$objp->PRESCM_INPUTEDDATE;
	 $getinstcode=$objp->PRESCM_INSTCODE;
	 $getcouriercode=$objp->PRESCM_COUR_CODE;
	 $getcouriername=$objp->PRESCM_COUR_NAME;
	 $gettime=$objp->PRESCM_TIME;
	 $getcouragentcode=$objp->PRESCM_COUR_AGENTCODE;
	 $getcourtrackcode=$objp->PRESCM_COUR_TRACKCODE;
	 $getmethod=$objp->PRESCM_METHOD;
	 $getmethodcode=$objp->PRESCM_METHODCODE;
	 $getpharmname=$objp->PRESCM_PHARMNAME;
	 $getpharmloc=$objp->PRESCM_PHARMLOC;
	 $getpatcontact=$objp->PRESCM_PATIENTCONTACT;
	 $getpatloc=$objp->PRESCM_PATIENTLOC;
	 $getpatage=$objp->PRESCM_OTHERAGE;
	 $getothergender=$objp->PRESCM_OTHERGENDER;
	 $getpickupcode=$objp->PRESCM_PICKUPCODE;
	 $getpackdelcode=$objp->PRESCM_PACKDELCODE;
	 $getreceivercode=$objp->PRESCM_RECIVERCODE;
	 $getencrypt=$objp->PRESCM_ENCRYPKEY;
	 $getdelivery=$objp->PRESCM_DEL_STATUS;
	 $getcourdate=$objp->PRESCM_COURDATE;
	 $getimage=$objp->PRESCM_IMAGE;
	 $getsource=$objp->PRESCM_SOURCE;
	}
	 }
	 //$getdetails=$sql->Execute($sql->Prepare("SELECT '$presid','$precode','$packagecode',PRESCM_PATIENT,PRESCM_PATIENTCODE,PRESCM_PATIENTNUM,PRESCM_DATE,PRESCM_VISITCODE,'$encrypted_drugcode','$encrypted_drugname','$drug_quantity','','$dosage_name', '4', '$newstate', PRESCM_INPUTEDDATE, PRESCM_INSTCODE, '$usrname', '$usrcode',PRESCM_COUR_CODE, PRESCM_COUR_NAME,PRESCM_TIME, PRESCM_COUR_AGENTCODE, PRESCM_COUR_TRACKCODE,'$faccode', '$cost', $grandtotal, PRESCM_METHOD, PRESCM_METHODCODE, PRESCM_PHARMNAME, PRESCM_PHARMLOC, PRESCM_PATIENTCONTACT, PRESCM_PATIENTLOC, PRESCM_OTHERAGE, PRESCM_OTHERGENDER, PRESCM_PICKUPCODE, PRESCM_PACKDELCODE, PRESCM_RECIVERCODE, PRESCM_ENCRYPKEY, PRESCM_DEL_STATUS, PRESCM_COURDATE, PRESCM_IMAGE, PRESCM_SOURCE, '$remarks' from hms_patient_prescription_main WHERE PRESCM_PACKAGECODE='$packagecode'"));

	 
	$sql->Execute($sql->Prepare("INSERT INTO hms_patient_prescription(PRESC_ID,PRESC_CODE,PRESC_PACKAGECODE, PRESC_PATIENT,PRESC_PATIENTCODE,PRESC_PATIENTNUM,PRESC_DATE,PRESC_VISITCODE,PRESC_DRUGID,PRESC_DRUG,PRESC_QUANTITY, PRESC_DOSAGECODE,PRESC_DOSAGENAME, PRESC_STATE, PRESC_STATUS, PRESC_INPUTEDDATE, PRESC_INSTCODE, PRESC_ACTORNAME, PRESC_ACTORCODE, PRESC_COUR_CODE, PRESC_COUR_NAME, PRESC_TIME, PRESC_COUR_AGENTCODE, PRESC_COUR_TRACKCODE, PRESC_FACICODE, PRESC_UNITPRICE, PRESC_TOTAL, PRESC_METHOD, PRESC_METHODCODE, PRESC_PHARMNAME, PRESC_PHARMLOC, PRESC_PATIENTCONTACT, PRESC_PATIENTLOC, PRESC_OTHERAGE, PRESC_OTHERGENDER, PRESC_PICKUPCODE, PRESC_PACKDELCODE, PRESC_RECIVERCODE, PRESC_ENCRYPKEY, PRESC_DEL_STATUS, PRESC_COURDATE, PRESC_IMAGE, PRESC_SOURCE, PRESC_REMARKS)VALUES(".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('14').",".$sql->Param('15').",".$sql->Param('16').",".$sql->Param('17').",".$sql->Param('18').",".$sql->Param('19').",".$sql->Param('20').",".$sql->Param('21').",".$sql->Param('22').",".$sql->Param('23').",".$sql->Param('24').",".$sql->Param('25').",".$sql->Param('26').",".$sql->Param('27').",".$sql->Param('28').",".$sql->Param('29').",".$sql->Param('30').",".$sql->Param('31').",".$sql->Param('32').",".$sql->Param('33').",".$sql->Param('34').",".$sql->Param('35').",".$sql->Param('36').",".$sql->Param('37').",".$sql->Param('38').",".$sql->Param('39').",".$sql->Param('40').",".$sql->Param('41').",".$sql->Param('42').",".$sql->Param('43').",".$sql->Param('44').")"),array($presid,$precode,$packagecode,$getpatientname,$getpatientcode,$getpatientnum,$getpatientdate,$getvisitcode,$encrypted_drugcode,$encrypted_drugname,$drug_quantity,'',$dosage_name,'4',$newstate,$getinputeddate,'H0001',$usrname,$usrcode,$getcouriercode,$getcouriername,$gettime,$getcouragentcode,$getcourtrackcode,$faccode,$cost,$grandtotal,$getmethod,$getmethodcode,$getpharmname,$getpharmloc,$getpatcontact,$getpatloc,$getpatage,$getothergender,$getpickupcode,$getpackdelcode,$getreceivercode,$getencrypt,$getdelivery,$getcourdate,$getimage,$getsource,$remarks));
	print $sql->ErrorMsg();
	
	
	//INSERTING INTO PENDING PRESCRIPTION TABLE
	$stmtinstpercentage = $sql->Execute($sql->Prepare("SELECT FACI_INST_PERCENTAGE FROM hmsb_allfacilities WHERE FACI_CODE = ".$sql->Param('1')." "),array($faccode));
            print $sql->Errormsg();
            if ($stmtinstpercentage->RecordCount()>0){
                $instpercentage = $stmtinstpercentage->FetchNextObject()->FACI_INST_PERCENTAGE;
            }else{
            	$instpercentage='0';
            }
            
	$pendingcode = $engine->getPendingCode();
	$sql->Execute($sql->Prepare("INSERT INTO hms_pending_prescription(PEND_CODE, PEND_PRESC_CODE, PEND_PATIENT,PEND_PATIENTCODE, PEND_PATIENTNUM, PEND_DATE, PEND_PACKAGECODE, PEND_VISITCODE, PEND_DRUGID, PEND_DRUG, PEND_QUANTITY, PEND_DOSAGECODE, PEND_DOSAGENAME,PEND_STATE, PEND_STATUS, PEND_INPUTEDDATE, PEND_ACTORNAME, PEND_ACTORCODE, PEND_FACICODE, PEND_UNITPRICE, PEND_TOTAL, PEND_TOTAL_APPLY_PERCT, PEND_TOTALCOMMISSION, PEND_GRAND_TOTAL, PEND_PERCENTAGE, PEND_PHARMNAME, PEND_PHARMLOC, PEND_PATIENTCONTACT, PEND_PATIENTLOC, PEND_DEL_STATUS, PEND_IMAGE, PEND_OTHER_GENDER, PEND_OTHER_AGE)VALUES(".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('14').",".$sql->Param('15').",".$sql->Param('16').",".$sql->Param('17').",".$sql->Param('18').",".$sql->Param('19').",".$sql->Param('20').",".$sql->Param('21').",".$sql->Param('22').",".$sql->Param('23').",".$sql->Param('24').",".$sql->Param('25').",".$sql->Param('26').",".$sql->Param('27').",".$sql->Param('28').",".$sql->Param('29').",".$sql->Param('30').",".$sql->Param('31').",".$sql->Param('32').",".$sql->Param('33').")"),array($pendingcode,$precode,$getpatientname,$getpatientcode,$getpatientnum,$getpatientdate,$packagecode,$getvisitcode,$encrypted_drugcode,$encrypted_drugname,$drug_quantity,'',$dosage_name,$getsource,'3',$getinputeddate,$usrname,$usrcode,$faccode,$cost,$grandtotal,$facilitypercent,$totalcommission,$grandtotal,$instpercentage,$getpharmname,$getpharmloc,$getpatcontact,$getpatloc,$getdelivery,$getimage,$getothergender,$getpatage));
	print $sql->ErrorMsg();
		$encrypted_drugname=$encaes->encrypt(trim($_POST['drugname'][$i]));
	 $encrypted_drugcode=$encaes->encrypt(trim($_POST['code'][$i]));
	 $dosage_name=$_POST['dosagename'][$i];
	 $drug_quantity=$_POST['quantity'][$i];
	$stmt_insert=$sql->Execute($sql->Prepare("INSERT INTO hms_pharmacysales(SAL_CODE, SAL_DRUGCODE, SAL_DRUG, SAL_DOSAGE, SAL_QUANTITY, SAL_COST, SAL_NHIS, SAL_CUSTOMER, SAL_USERCODE, SAL_USERNAME, SAL_FACICODE, SAL_METHOD, SAL_METHODCODE, SAL_STATUS,SAL_TOTALCOMMISSION,SAL_GRANDTOTAL,SAL_UNIQCODE)VALUE (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('14').",".$sql->Param('15').",".$sql->Param('16').",".$sql->Param('17').")"),array($salecode,$encrypted_drugcode,$encrypted_drugname,$dosage_name,$drug_quantity,$cost,'0',$customername,$usrcode,$username,$faccode,'HEWALE','000','1',$totalcommission,$grandtotal,$salesid));
		/**$finarray[] = '(
				"'.$salecode.'",
				"'.$encaes->encrypt($_POST['code'][$i]).'",
				"'.$encaes->encrypt($_POST['drugname'][$i]).'",
				"'.$_POST['dosagename'][$i].'",
				"'.$_POST['quantity'][$i].'",
				"'.$cost.'",
				"'.'0'.'",
				"'.$customername.'",
				"'.$usrcode.'",
				"'.$usrname.'",
				"'.$faccode.'",
				"'.'HEWALE'.'",
				"'.'000'.'",
				"'.'1'.'",
				"'.$totalcommission.'",
				"'.$grandtotal.'",
				"'.$salesid.'"
				
			)';**/
			
	}
	if(!empty($newdrugs) && count($newdrugs)>0)//if there are new drugs previously not entered
	{
		$pharmacypricecode=$engine->getpharmacypricecode();
		foreach ($newdrugs as $newdrugindex){
			
			$newdrugsarray[] = '(
				"'.$_POST['drugname'][$newdrugindex].'",
				"'.$_POST['dosagename'][$newdrugindex].'",
				"'.$_POST['dosagecode'][$newdrugindex].'",
				"'.$_POST['code'][$newdrugindex].'",
				"'.date('Y-m-d').'",
				"'.$faccode.'"
			)';
			$newpricearray[] = '(
			
				"'.$pharmacypricecode.'",
				"'.$faccode.'",
				"'.'CASH'.'",
				"'.'PMT0010'.'",
				"'.'PC0001'.'",
				"'.$_POST['drugname'][$newdrugindex].'",
				"'.$_POST['code'][$newdrugindex].'",
				"'.$_POST['cost'][$newdrugindex].'"
			
			)';
			$initial=substr($pharmacypricecode,0,3);
			$number=substr($pharmacypricecode,3,7);
			$number=str_pad($number +1,7,0,STR_PAD_LEFT);
			$pharmacypricecode=$initial.$number;
			
		}
	}
		$newdrugsarray = is_array($newdrugsarray)?implode(',', $newdrugsarray):'';
		$newpricearray = is_array($newpricearray)?implode(',', $newpricearray):'';
	//	print_r($_REQUEST);die();
  	//	$listtomove = is_array($finarray)?implode(',', $finarray):'';
  	//	echo $listtomove;die();
  //	echo $courier;
	//echo $listtomove;die();
	//die();
	
 	//$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_pharmacysales(SAL_CODE, SAL_DRUGCODE, SAL_DRUG, SAL_DOSAGE, SAL_QUANTITY, SAL_COST, SAL_NHIS, SAL_CUSTOMER, SAL_USERCODE, SAL_USERNAME, SAL_FACICODE, SAL_METHOD, SAL_METHODCODE, SAL_STATUS,SAL_TOTALCOMMISSION,SAL_GRANDTOTAL,SAL_UNIQCODE)VALUE $listtomove"));
 	//print $sql->ErrorMsg();
 	if ($stmt_insert==TRUE){
 		$tablerowid=$sql->insert_Id();
 		$courierarray=(!empty($courier)?explode('|',$courier):'');
 		//print_r($courier);//die();
 	if (!empty($newdrugs) && count($newdrugs)>0){
  			$stmtins=$sql->Execute($sql->Prepare("INSERT INTO hms_pharmacystock(ST_NAME,ST_DOSAGENAME,ST_DOSAGE,ST_CODE,ST_DATE,ST_FACICODE) VALUES $newdrugsarray"));
  			$stmtinsprice=$sql->Execute($sql->Prepare("INSERT INTO hms_pharmacyprice(PPR_CODE,PPR_FACICODE,PPR_METHOD,PPR_METHODCODE,PPR_CATEGORYCODE,PPR_DRUG,PPR_DRUGCODE,PPR_PRICE) VALUES $newpricearray"));
  			}
 		if ($deliverystatus=='1'){
 			
		$desc='Courier has been requested';
		$engine->setNotification('013',$desc,'0018',$tablerowid,$courierarray[0],$courierarray[0]);
 		$pickupcode = $engine->pickupcode();
		$receivercode = rand(999,10000);
		$stmtpatdetails= $sql->Execute($sql->Prepare("SELECT PATIENT_PHONENUM,PATIENT_GENDER, YEAR(CURDATE()) - YEAR(PATIENT_DOB) AS PATIENT_DOB,PATIENT_ALLERGIES from hms_patient WHERE PATIENT_PATIENTNUM=".$sql->Param('a').""),array($hewalenumber));
 	 	$objdet=$stmtpatdetails->FetchNextObject();
 	 	$patientphone=$objdet->PATIENT_PHONENUM;
		#$patientphone= $patientobj->PATIENT_PHONENUM;
		$pmessage="Receiver code :$receivercode for hewale prescription";
		$sms->sendSms($patientphone,$pmessage);
		$sql->Execute($sql->Prepare("INSERT INTO hms_prescriptioncode(C_PICKUPCODE,C_RECIVERCODE,C_DATE) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').")"),array($pickupcode,$receivercode,date('Y-M-d')));
 		$stmtup= $sql->Execute($sql->Prepare("UPDATE hms_pending_prescription SET PEND_STATUS=".$sql->Param('a').", PEND_COUR_CODE=".$sql->Param('b').",PEND_COUR_NAME=".$sql->Param('c')." WHERE PEND_PACKAGECODE=".$sql->Param('a')." AND PEND_FACICODE=".$sql->Param('b').""),array('4',$courierarray[0],$courierarray[1],$packagecode,$faccode));
 		$stmtup2=$sql->Execute($sql->Prepare("UPDATE hms_broadcast_prescription SET BRO_STATUS=".$sql->Param('a')." WHERE BRO_PRESCCODE=".$sql->Param('b')." AND BRO_PHARMACYCODE=".$sql->Param('c')." AND BRO_STATUS=".$sql->Param('d')." "),array('4',$packagecode,$faccode,'3'));
 		$st=$sql->Execute($sql->Prepare("SELECT HRMSTRANS_CONFIRM_STATUS from hms_wallet_transaction WHERE HRMSTRANS_PACKAGECODE=".$sql->Param('a')." "),array($packagecode));
 		if ($st->RecordCount()>0){
 		$ot=$st->FetchNextObject();
 		$not=$ot->HRMSTRANS_CONFIRM_STATUS;
 		if ($not=='1'){
 			
 		$stmtup=$sql->Execute($sql->Prepare("UPDATE hms_wallet_transaction SET HRMSTRANS_COURIER_NAME=".$sql->Param('a').",HRMSTRANS_COURIER_CODE=".$sql->Param('b')." WHERE HRMSTRANS_PACKAGECODE=".$sql->Param('c')." "),array($courierarray[1],$courierarray[0],$packagecode));
 		//echo "BoooooooooM";die();
 		}else{
 			//print_r($ot);
 		//	echo "$ot BO";die();
 		}
 		}
 		}else{
 		$pickupcode = $engine->pickupcode();
		$receivercode = rand(999,10000);
		$sql->Execute($sql->Prepare("INSERT INTO hms_prescriptioncode(C_PICKUPCODE,C_RECIVERCODE,C_DATE) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').")"),array($pickupcode,$receivercode,date('Y-M-d')));
		$stmtpatdetails= $sql->Execute($sql->Prepare("SELECT PATIENT_PHONENUM,PATIENT_GENDER, YEAR(CURDATE()) - YEAR(PATIENT_DOB) AS PATIENT_DOB,PATIENT_ALLERGIES from hms_patient WHERE PATIENT_PATIENTNUM=".$sql->Param('a').""),array($hewalenumber));
 	 	$objdet=$stmtpatdetails->FetchNextObject();
 	 	$patientphone=$objdet->PATIENT_PHONENUM;
 	 	#echo "BOOOOOOOOOM$patientphone";
		#$patientphone= $patientobj->PATIENT_PHONENUM;
		$pmessage="Receiver code :$receivercode for hewale prescription";
		$sms->sendSms($patientphone,$pmessage);
 		$stmtup= $sql->Execute($sql->Prepare("UPDATE hms_pending_prescription SET PEND_STATUS=".$sql->Param('a')." WHERE PEND_PACKAGECODE=".$sql->Param('a')." AND PEND_FACICODE=".$sql->Param('b').""),array('4',$packagecode,$faccode));
 		$stmtup2=$sql->Execute($sql->Prepare("UPDATE hms_broadcast_prescription SET BRO_STATUS=".$sql->Param('a')." WHERE BRO_PRESCCODE=".$sql->Param('b')." AND BRO_PHARMACYCODE=".$sql->Param('c')." AND BRO_STATUS=".$sql->Param('d')." "),array('4',$packagecode,$faccode,'3'));
 		}
 		
 		
 		//move values from transit table to wallet table if there's a courier involved
 		if ($deliverystatus=='1'){
 		//	echo "BOOOOOOM";die();
 			$stmtup= $sql->Execute($sql->Prepare("UPDATE hms_patient_prescription SET PRESC_COUR_CODE=".$sql->Param('b').",PRESC_COUR_NAME=".$sql->Param('c').",PRESC_PICKUPCODE=".$sql->Param('v').",PRESC_RECIVERCODE=".$sql->Param('v').",PRESC_REMARKS=".$sql->Param('v')." WHERE PRESC_PACKAGECODE=".$sql->Param('a')." "),array($courierarray[0],$courierarray[1],$pickupcode,$receivercode,$remarks,$packagecode));
 			
 			$stmtup= $sql->Execute($sql->Prepare("UPDATE hms_patient_prescription_main SET PRESCM_COUR_CODE=".$sql->Param('b').",PRESCM_COUR_NAME=".$sql->Param('c').",PRESCM_PICKUPCODE=".$sql->Param('v').",PRESCM_RECIVERCODE=".$sql->Param('v').",PRESCM_REMARKS=".$sql->Param('v')." WHERE PRESCM_PACKAGECODE=".$sql->Param('a')." "),array($courierarray[0],$courierarray[1],$pickupcode,$receivercode,$remarks,$packagecode));
			 
		$ccode = $coder->getcourierCode();			 
		$engine->getcourieritem($packagecode,$ccode);	

		
 		$stmtcash = $sql->Execute($sql->Prepare("SELECT PCP_PHARM_AMT,PCP_COURIER_AMT,PCP_COURIER_CODE,PCP_PATIENTCODE from hms_pharm_courier_price WHERE PCP_PATIENT_VISITCODE =".$sql->Param('a')." AND PCP_PHARM_CODE=".$sql->Param('b')." AND PCP_STATUS=".$sql->Param('c')." "),array($visitcode,$faccode,'0'));
 		if ($stmtcash->RecordCount()>0){
 		$obj = $stmtcash->FetchNextObject();
 		$patientcode=$obj->PCP_PATIENTCODE;
 		$pharmacyamount = $obj->PCP_PHARM_AMT;
 		$courieramount = $obj->PCP_COURIER_AMT;
 		$couriercode= $obj->PCP_COURIER_CODE;
 		}
 		}else{
 			//echo "BONGOOOOOOO";die();
 			
 		//	echo "BOOOOOOM";die();
 			$stmtup= $sql->Execute($sql->Prepare("UPDATE hms_patient_prescription SET PRESC_PICKUPCODE=".$sql->Param('v').",PRESC_RECIVERCODE=".$sql->Param('v').",PRESC_REMARKS=".$sql->Param('v')." WHERE PRESC_PACKAGECODE=".$sql->Param('a')." "),array($pickupcode,$receivercode,$remarks,$packagecode));
 			
 			$stmtup= $sql->Execute($sql->Prepare("UPDATE hms_patient_prescription_main SET PRESCM_PICKUPCODE=".$sql->Param('v').",PRESCM_RECIVERCODE=".$sql->Param('v').",PRESCM_REMARKS=".$sql->Param('v')." WHERE PRESCM_VISITCODE=".$sql->Param('a')." "),array($pickupcode,$receivercode,$remarks,$visitcode));
 			
 		$stmtcash = $sql->Execute($sql->Prepare("SELECT WAL_HOLD_AMT,WAL_PATIENTCODE from hms_wallet_trans_holder WHERE WAL_PATIENT_VISITCODE=".$sql->Param('a')." AND WAL_SERV_PROVIDERCODE=".$sql->Param('b')." AND WAL_STATUS=".$sql->Param('c')." "),array($visitcode,$faccode,'0'));
 		if ($stmtcash->RecordCount()>0){
 			$obj =$stmtcash->FetchNextObject();
 			$patientcode=$obj->WAL_PATIENTCODE;
 			$pharmacyamount = $obj->WAL_HOLD_AMT;
 			$courieramount=NULL;
 			$couriercode=NULL;
 		}	
 		}
 		//echo $patientcode."--".$pharmacyamount."--".$faccode."--".$visitcode."--".$couriercode."--".$courieramount;
 		//die();
 		//distribute payment
 		$engine->patienttopharmacyprice($patientcode,$pharmacyamount,$faccode,$visitcode,$couriercode,$courieramount);
 		//reduce quantity by selecting the various quantities
 		    $stcheck =$sql->Execute($sql->Prepare("SELECT PEND_DRUG,PEND_DOSAGENAME,PEND_QUANTITY from hms_pending_prescription WHERE PEND_PACKAGECODE=".$sql->Param('a')." AND PEND_FACICODE=".$sql->Param('b')." "),array($packagecode,$faccode));
 		    print $sql->ErrorMsg();
 		     if ($stcheck->RecordCount()>0){
 		     	while ($obj = $stcheck->FetchNextObject()){
 		     		$datarray[]=array('NAME'=>$obj->PEND_DRUG,'DOSAGE'=>$obj->PEND_DOSAGENAME,'QUANTITY'=>$obj->PEND_QUANTITY);
 		     	}
 		     	if (is_array($datarray) && count($datarray)>0){
 		     		foreach ($datarray as $key){
 		     			//make the subtraction
 		     			$dname =$encaes->decrypt($key['NAME']);
 		     			
 		     			$sql->Execute($sql->Prepare("UPDATE hms_pharmacystock SET ST_STORE_QTY=ST_STORE_QTY- ".$sql->Param('a')." WHERE ST_NAME=".$sql->Param('b')." AND ST_DOSAGENAME=".$sql->Param('c')." "),array($key['QUANTITY'],$dname,$key['DOSAGE']));	
 		     			print $sql->ErrorMsg();		
 		     		}
 		     	}
 		     }
 		     //update the state to transit
 		     $newstate=($deliverystatus=='1')?'4':'5';
 		  $sql->Execute($sql->Prepare("UPDATE hms_patient_prescription SET PRESC_STATUS=".$sql->Param('a').",PRESC_STATE=".$sql->Param('b')." WHERE PRESC_PACKAGECODE=".$sql->Param('c')." "),array($newstate,'4',$packagecode));  
 		  print $sql->ErrorMsg(); 
 		  $sql->Execute($sql->Prepare("UPDATE hms_patient_prescription_main SET PRESCM_STATUS=".$sql->Param('a').",PRESCM_STATE=".$sql->Param('b').",PRESCM_FACICODE =".$sql->Param('b')." WHERE PRESCM_PACKAGECODE=".$sql->Param('c')." "),array($newstate,'4',$faccode,$packagecode));  
 		  print $sql->ErrorMsg(); 
 		  if ($deliverystatus=='1'){
 		$msg="Sale successfully completed with pickup code $pickupcode";
 		  }else{
 		  	$msg="Sale successfully completed";
 		  }
 		$status="success";
 		$session->set('salecode',$salecode);
 		$session->set('pickupcode',$pickupcode);
 		$view="receipt";
 		//to clear notification we need to get the latest row id
 		$stmt_clear=$sql->Execute($sql->Prepare("SELECT PRESCM_PACKAGECODE from hms_patient_prescription_main WHERE PRESCM_PACKAGECODE=".$sql->Param('a')." AND (PRESCM_STATUS=".$sql->Param('b')." OR PRESCM_STATUS=".$sql->Param('c').") ORDER BY PRESCM_INPUTEDDATE DESC LIMIT 1"),array($packagecode,'4','5'));
 		print $sql->ErrorMsg();
 		if($stmt_clear->RecordCount()>0){
 			while($obj_clear=$stmt_clear->FetchNextObject()){
 				$tablerowid=$obj_clear->PRESCM_PACKAGECODE;
 			}
 		}else{
 			$tablerowid='';
 		}
 		$engine->ClearNotification('0015',$tablerowid);
 	}else{
 		$msg="Sale not processed, please try again.";
 		$status="error";
 		$view="";
 	}
 		}
 	break;
 	/**END OF IMAGE SAVE**/
 	
	/** END OF IMAGE PROCESSING **/
	case 'cancelsale'://clear the sales
	//	echo "BooooooooooM"; die();
	$session->del('cartprepare');
	//$view="prepareimage";
	$keys="";
	break;

   case "reset":
	$fdsearch = "";
	break;
	
}

if(isset($keys) && !empty($keys)){
$stmtprescription=$sql->Execute($sql->Prepare("SELECT PRESC_DRUG,PRESC_QUANTITY,PRESC_DOSAGENAME,PRESC_PATIENT from hms_patient_prescription WHERE PRESC_VISITCODE=".$sql->Param('a')." "),array($keys));
 if($stmtprescription->RecordCount()>0){
 	while($objpresc=$stmtprescription->FetchNextObject()){
 		$patientfullname=$objpresc->PRESC_PATIENT;
 		$prescarray[]=array($objpresc->PRESC_PATIENT,$objpresc->PRESC_DRUG,$objpresc->PRESC_QUANTITY,$objpresc->PRESC_DOSAGENAME);
 	}
 }else{
 	$prescarray=array();
 }
}

//$stmtdrugs = $sql->Execute($sql->Prepare("SELECT DR_NAME ST_NAME,IFNULL(ST_DOSAGENAME,DR_DOSAGENAME) ST_DOSAGE,IFNULL(ST_SHEL_QTY,'0')ST_SHEL_QTY,IFNULL(ST_STORE_QTY,0)ST_STORE_QTY,IFNULL(PPR_PRICE,0) PPR_PRICE,IFNULL(PPR_NHIS,0)PPR_NHIS,IFNULL(ST_CODE,DR_CODE) ST_CODE from hms_pharmacystock JOIN hms_pharmacyprice ON ST_CODE=PPR_DRUGCODE RIGHT JOIN hmsb_st_phdrugs ON DR_CODE=ST_CODE WHERE (ST_FACICODE =".$sql->Param('a')." OR DR_INSDT IS NULL) AND (ST_STATUS=".$sql->Param('b')." OR DR_STATUS =".$sql->Param('c').") "),array($faccode,'1','1'));
if($view=='prepareimage'){
$stmtdrugs = $sql->Execute($sql->Prepare("SELECT TRIM(ST_NAME)ST_NAME,ST_DOSAGENAME ST_DOSAGE,ST_SHEL_QTY,ST_STORE_QTY,IFNULL(PPR_PRICE,0) PPR_PRICE,IFNULL(PPR_NHIS,0)PPR_NHIS,TRIM(ST_CODE)ST_CODE from hms_pharmacystock JOIN hms_pharmacyprice ON ST_CODE=PPR_DRUGCODE WHERE ST_FACICODE =".$sql->Param('a')." AND PPR_METHODCODE=".$sql->Param('b')." AND ST_STATUS=".$sql->Param('c')." "),array($faccode,'PMT0010','1'));
		if($stmtdrugs->RecordCount()>0){
		while($objdrugs=$stmtdrugs->FetchNextObject()){
			$drugsarray[$objdrugs->ST_CODE]=array('ST_NAME'=>$objdrugs->ST_NAME,'ST_DOSAGENAME'=>$objdrugs->ST_DOSAGENAME,'ST_DOSAGE'=>$objdrugs->ST_DOSAGE,'ST_SHEL_QTY'=>$objdrugs->ST_SHEL_QTY,'ST_STORE_QTY'=>$objdrugs->ST_STORE_QTY,'PPR_PRICE'=>$objdrugs->PPR_PRICE,'PPR_NHIS'=>$objdrugs->PPR_NHIS,'ST_CODE'=>$objdrugs->ST_CODE);
		}
	}
$stmtdrugs1=$sql->Execute($sql->Prepare("SELECT TRIM(DR_NAME) ST_NAME,DR_DOSAGENAME ST_DOSAGE,'0' ST_SHEL_QTY,'0' ST_STORE_QTY,'0' PPR_PRICE,'0' PPR_NHIS,TRIM(DR_CODE) ST_CODE from hmsb_st_phdrugs WHERE DR_CODE NOT IN(SELECT ST_CODE from hms_pharmacystock JOIN hms_pharmacyprice ON ST_CODE=PPR_DRUGCODE WHERE ST_FACICODE=".$sql->Param('a')." AND PPR_METHODCODE=".$sql->Param('b')." AND ST_STATUS=".$sql->Param('c')." ) AND DR_STATUS =".$sql->Param('c')." "),array($faccode,'PMT0010','1','1'));
	if($stmtdrugs1->RecordCount()>0){
		while($objdrugs1=$stmtdrugs1->FetchNextObject()){
			$drugs1array[$objdrugs1->ST_CODE]=array('ST_NAME'=>$objdrugs1->ST_NAME,'ST_DOSAGENAME'=>$objdrugs1->ST_DOSAGENAME,'ST_DOSAGE'=>$objdrugs1->ST_DOSAGE,'ST_SHEL_QTY'=>$objdrugs1->ST_SHEL_QTY,'ST_STORE_QTY'=>$objdrugs1->ST_STORE_QTY,'PPR_PRICE'=>$objdrugs1->PPR_PRICE,'PPR_NHIS'=>$objdrugs1->PPR_NHIS,'ST_CODE'=>$objdrugs1->ST_CODE);
		}
	}
	if ((is_array($drugsarray) && count($drugsarray)>0) && is_array($drugs1array)){
	$finaldrugsarray=array_merge($drugsarray,$drugs1array);
	//$finaldrugsarray=sort($drugsarray);
	function compareByName($finaldrugsarray, $b) {
	return strcmp($finaldrugsarray["ST_NAME"], $b["ST_NAME"]);
	}
	usort($finaldrugsarray, 'compareByName');
	}else{
		$finaldrugsarray=$drugs1array;
		function compareByName($finaldrugsarray, $b) {
	  	return strcmp($finaldrugsarray["ST_NAME"], $b["ST_NAME"]);
	}
	usort($finaldrugsarray, 'compareByName');
	}

}
$instpercent= $sql->Execute($sql->Prepare("SELECT FACI_INST_PERCENTAGE from hmsb_allfacilities WHERE FACI_CODE=".$sql->Param('a').""),array($faccode));
		if ($instpercent->RecordCount()>0){
			$objcent=$instpercent->FetchNextObject();
			$facilitypercent=$objcent->FACI_INST_PERCENTAGE;
		}else{
		$facilitypercent='0';
		}
		$facilitypercent=($facilitypercent/100);

if(!empty($fdsearch)){
	$query = "SELECT PRESCM_PATIENTNUM,PRESCM_VISITCODE,PRESCM_PATIENT,DATE(PRESCM_DATE) AS PRESCM_INPUTEDDATE,PRESCM_PICKUPCODE,PRESCM_STATUS,PRESCM_COUR_NAME,PRESCM_STATE,'3' AS BRO_STATUS,PRESCM_IMAGE AS BRO_IMAGENAME,PRESCM_VISITCODE AS BRO_VISITCODE,PRESCM_SOURCE AS BRO_STATE,PRESCM_PACKAGECODE,PRESCM_DEL_STATUS,PRESCM_IMAGE,PRESCM_FACICODE,PRESCM_ITEMCODE FROM hms_patient_prescription_main WHERE (PRESCM_STATUS=".$sql->Param('b')." ) AND (PRESCM_PICKUPCODE LIKE ".$sql->Param('h')." OR PRESCM_PATIENT LIKE ".$sql->Param('j')." OR PRESCM_PACKAGECODE LIKE ".$sql->Param('j')." )";
	$input = array('3','%'.$fdsearch.'%','%'.$fdsearch.'%','%'.$fdsearch.'%');
	print $sql->ErrorMsg();
}else {//1=> Pending Preparation, 2=>Prepared , 3=>Purchase, 4=>Completed
    $query = "SELECT PRESCM_VISITCODE,PRESCM_PATIENT,PRESCM_PATIENTNUM,DATE(PRESCM_DATE) AS PRESCM_INPUTEDDATE,PRESCM_FACICODE,PRESCM_STATUS,PRESCM_PICKUPCODE,PRESCM_COUR_NAME,PRESCM_STATE,'3' AS BRO_STATUS,PRESCM_IMAGE AS BRO_IMAGENAME,PRESCM_VISITCODE AS BRO_VISITCODE,PRESCM_SOURCE AS BRO_STATE,PRESCM_PACKAGECODE,PRESCM_DEL_STATUS,PRESCM_IMAGE,PRESCM_ITEMCODE FROM hms_patient_prescription_main WHERE PRESCM_FACICODE = ".$sql->Param('a')." AND (PRESCM_STATUS=".$sql->Param('b').")" ;
    $input = array($faccode,'3');
}
if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=ad2376beebecdcf7846ba973fa1a005b&option=6831b98f85019ddb98bd98d44bdbac40#',$input);

$queryBroad = "SELECT * FROM hms_pending_prescription WHERE PEND_FACICODE = ".$sql->Param('a')." AND PEND_STATUS =  ".$sql->Param('b') ;
$input = array($faccode,'1');
$pagingBroad = new OS_Pagination($sql,$queryBroad,$limit,$lenght,'index.php?pg=ad2376beebecdcf7846ba973fa1a005b&option=6831b98f85019ddb98bd98d44bdbac40#',$input);
//die(var_dump($pagingBroad));
//Get all positions
$stmtpos = $engine->getUserPosition();

?>