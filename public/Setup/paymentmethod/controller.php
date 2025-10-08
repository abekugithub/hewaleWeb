<?php
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$userCourier = $engine->getActorCourier();
$facilitytype= $engine->getFacilityType();
$facicode=$session->get("activeinstitution");
$paymentcode=$engine->getPaymentCode();


switch($viewpage){
	case 'savedetails':
		//if CASH
		if ($category=='PC0001'){
			$account=(!empty($accountname))?"$accountname Account Number: $account":$account;
			$stmt=$sql->Execute($sql->Prepare("INSERT INTO hms_facilities_payment (PINS_CODE,PINS_FACICODE,PINS_FACITYPE,PINS_ACC_DETAILS,PINS_CATEGORY_CODE,PINS_METHOD_CODE,PINS_CATEGORY,PINS_METHOD,PINS_TYPE)VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').")"),array($paymentcode,$facicode,$facilitytype,$account,$category,$categorytype,$engine->getPaymentCategoryName($category),$engine->getPaymentCategoryMethod($categorytype),'1'));
			print $sql->ErrorMsg();
			if ($stmt==TRUE){
				$msg="Details Successfully Added";
				$status="success";
				$categorytype="";
			}else{
				$msg="Details could not be added, Please try again!";
				$status="error";
			}
		}
		//if NHIS
		elseif ($category=='PC0002'){
			$location = "District: $district, $location";
			$stmt=$sql->Execute($sql->Prepare("INSERT INTO hms_facilities_payment (PINS_CODE,PINS_FACICODE,PINS_FACITYPE,PINS_LOCATION,PINS_INSURANCE_NAME,PINS_CONTACT,PINS_CATEGORY_CODE,PINS_METHOD_CODE,PINS_CATEGORY,PINS_METHOD,PINS_TYPE)VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('j').",".$sql->Param('k').")"),array($paymentcode,$facicode,$facilitytype,$location,'NHIS',$contact,$category,$categorytype,$engine->getPaymentCategoryName($category),$engine->getPaymentCategoryMethod($categorytype),'2'));
			if ($stmt==TRUE){
				$msg="Details Successfully Added";
				$status="success";
				$categorytype="";
			}else{
				$msg="Details could not be added, Please try again!";
				$status="error";
			}
		
		}
		//if Private health Insurance
		elseif ($category=='PC0003'){
			$stmt=$sql->Execute($sql->Prepare("INSERT INTO hms_facilities_payment (PINS_CODE,PINS_FACICODE,PINS_FACITYPE,PINS_COMPANY_NAME,PINS_INSURANCE_NAME,PINS_LOCATION,PINS_CONTACT,PINS_CATEGORY_CODE,PINS_METHOD_CODE,PINS_CATEGORY,PINS_METHOD,PINS_TYPE)VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('j')." ,".$sql->Param('k').",".$sql->Param('l').")"),array($paymentcode,$facicode,$facilitytype,$companyname,$insurance,$location,$contact,$category,$categorytype,$engine->getPaymentCategoryName($category),$engine->getPaymentCategoryMethod($categorytype),'3'));
			if ($stmt==TRUE){
				$msg="Details Successfully Added";
				$status="success";
				$categorytype="";
			}else{
				$msg="Details could not be added, Please try again!";
				$status="error";
			}
		
		
			
		}
		//if Partner Company
		elseif ($category=='PC0004'){
			$stmt=$sql->Execute($sql->Prepare("INSERT INTO hms_facilities_payment (PINS_CODE,PINS_FACICODE,PINS_FACITYPE,PINS_COMPANY_NAME,PINS_LOCATION,PINS_CONTACT,PINS_CATEGORY_CODE,PINS_METHOD_CODE,PINS_CATEGORY,PINS_METHOD,PINS_TYPE) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('j').",".$sql->Param('k').") "),array($paymentcode,$facicode,$facilitytype,$companyname,$location,$contact,$category,$categorytype,$engine->getPaymentCategoryName($category),$engine->getPaymentCategoryMethod($categorytype),'4'));
			if ($stmt==TRUE){
				$msg="Details Successfully Added";
				$status="success";
				$categorytype="";;
			}else{
				$msg="Details could not be added, Please try again!";
				$status="error";
			}
		
		
			
		
		}
	break;
	case 'getclientdetails':
    //var_dump($keys); die();
        if($keys){
             $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_service_request WHERE REQU_CODE = ".$sql->Param('a')." "),array($keys));
            $client = $stmt->FetchNextObject();
			$patientcode= $client->REQU_PATIENTNUM;
			
              $stmtp = $sql->Execute($sql->Prepare("SELECT PATIENT_IMAGE,TIMESTAMPDIFF(YEAR,PATIENT_DOB, NOW())AS AGE FROM hms_patient WHERE PATIENT_PATIENTNUM = ".$sql->Param('a')." "),array($patientcode));
            $obj = $stmtp->FetchNextObject(); 
			$image=$obj->PATIENT_IMAGE;
			$patientage= $obj->AGE;
        }
        //include "model/js.php";
    break;
    case 'insertaid':
		$postkey = $session->get("postkey");
		if($postkey != $microtime){
		$session->set("postkey",$microtime);
			$vitaldetcode = uniqid();
			if(!empty($reportaid)){
			
		$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_firstaid (FIR_CODE, FIR_VISITCODE, FIR_REQUCODE, FIR_PATIENTID, FIR_SERVICE,  FIR_FACILITYCODE,FIR_PAYMENT,FIR_REPORT)VALUES(".$sql->Param('a').",".$sql->Param('b').", ".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').")"), array($vitaldetcode,$visitcode,$regcode,$patientcode, $servicename,$activeinstitution, $paymenttype,$reportaid));
		
			
			$stmtp = $sql->Execute($sql->Prepare("UPDATE hms_service_request SET REQU_STATUS='2' WHERE REQU_CODE=".$sql->Param('b')),array($keys));
			
		
		$msg = "Patient First Aid Inserted Successfully.";
	    $status = "success";
		
        $activity = "Patient First Aid Inserted Successfully.";
		$engine->setEventLog("013",$activity);
			
	}else{
		$msg = "Sorry! First Aid Report is not captured.";
	    $status = "error";
		}
			
}
	  break;
    default:
    	//FOR TABLE
//if category and type is not selected
if (!empty($category) && !empty($categorytype)){
if(!empty($fdsearch)){
 $query = "SELECT PINS_ID, PINS_CODE, PINS_FACICODE, PINS_ACC_DETAILS, PINS_COMPANY_NAME, PINS_LOCATION, PINS_CONTACT, PINS_INSURANCE_NAME, PINS_CATEGORY_CODE, PINS_METHOD_CODE, PCS_CATEGORY,PAYM_NAME,PINS_STATUS from hms_facilities_payment JOIN hmsb_set_paymentcatgory ON PINS_CATEGORY_CODE=PCS_CATECODE JOIN hmsb_set_paymentmethod ON PINS_METHOD_CODE=PAYM_CODE WHERE PINS_STATUS = '1' AND PINS_CATEGORY_CODE=".$sql->Param('b')." AND PINS_METHOD_CODE=".$sql->Param('b')." AND  PINS_FACICODE=".$sql->Param('c')." AND (PINS_COMPANY_NAME LIKE ".$sql->Param('d')." OR PINS_LOCATION LIKE ".$sql->Param('e')." OR PINS_INSURANCE_NAME LIKE ".$sql->Param('f')." OR PCS_CATEGORY LIKE ".$sql->Param('g')." ) ";
        $input = array($category,$categorytype,$facicode,'%'.$fdsearch.'%','%'.$fdsearch.'%','%'.$fdsearch.'%','%'.$fdsearch.'%');
}else {
 $query = "SELECT PINS_ID, PINS_CODE, PINS_FACICODE, PINS_ACC_DETAILS, PINS_COMPANY_NAME, PINS_LOCATION, PINS_CONTACT, PINS_INSURANCE_NAME, PINS_CATEGORY_CODE, PINS_METHOD_CODE, PCS_CATEGORY,PAYM_NAME,PINS_STATUS from hms_facilities_payment JOIN hmsb_set_paymentcatgory ON PINS_CATEGORY_CODE=PCS_CATECODE JOIN hmsb_set_paymentmethod ON PINS_METHOD_CODE=PAYM_CODE WHERE PINS_STATUS = '1' AND PINS_CATEGORY_CODE=".$sql->Param('b')." AND PINS_METHOD_CODE=".$sql->Param('b')." AND  PINS_FACICODE=".$sql->Param('c')." ";
        $input = array($category,$categorytype,$facicode);
}
}
//if category and type is  selected
elseif (!empty($category) && empty($categorytype)){
	
if(!empty($fdsearch)){
 $query = "SELECT PINS_ID, PINS_CODE, PINS_FACICODE, PINS_ACC_DETAILS, PINS_COMPANY_NAME, PINS_LOCATION, PINS_CONTACT, PINS_INSURANCE_NAME, PINS_CATEGORY_CODE, PINS_METHOD_CODE, PCS_CATEGORY,PAYM_NAME,PINS_STATUS from hms_facilities_payment JOIN hmsb_set_paymentcatgory ON PINS_CATEGORY_CODE=PCS_CATECODE JOIN hmsb_set_paymentmethod ON PINS_METHOD_CODE=PAYM_CODE WHERE PINS_STATUS = '1' AND PINS_CATEGORY_CODE=".$sql->Param('b')." AND  PINS_FACICODE=".$sql->Param('c')." AND (PINS_COMPANY_NAME LIKE ".$sql->Param('d')." OR PINS_LOCATION LIKE ".$sql->Param('e')." OR PINS_INSURANCE_NAME LIKE ".$sql->Param('f')." OR PCS_CATEGORY LIKE ".$sql->Param('g')." ) ";
        $input = array($category,$facicode,'%'.$fdsearch.'%','%'.$fdsearch.'%','%'.$fdsearch.'%','%'.$fdsearch.'%');
}else {
 $query = "SELECT PINS_ID, PINS_CODE, PINS_FACICODE, PINS_ACC_DETAILS, PINS_COMPANY_NAME, PINS_LOCATION, PINS_CONTACT, PINS_INSURANCE_NAME, PINS_CATEGORY_CODE, PINS_METHOD_CODE, PCS_CATEGORY,PAYM_NAME,PINS_STATUS from hms_facilities_payment JOIN hmsb_set_paymentcatgory ON PINS_CATEGORY_CODE=PCS_CATECODE JOIN hmsb_set_paymentmethod ON PINS_METHOD_CODE=PAYM_CODE WHERE PINS_STATUS = '1' AND PINS_CATEGORY_CODE=".$sql->Param('b')." AND  PINS_FACICODE=".$sql->Param('c')." ";
        $input = array($category,$facicode);
}
	
	
}
//if nothing is selected
else{
if(!empty($fdsearch)){
 $query = "SELECT PINS_ID, PINS_CODE, PINS_FACICODE, PINS_ACC_DETAILS, PINS_COMPANY_NAME, PINS_LOCATION, PINS_CONTACT, PINS_INSURANCE_NAME, PINS_CATEGORY_CODE, PINS_METHOD_CODE, PCS_CATEGORY,PAYM_NAME,PINS_STATUS from hms_facilities_payment JOIN hmsb_set_paymentcatgory ON PINS_CATEGORY_CODE=PCS_CATECODE JOIN hmsb_set_paymentmethod ON PINS_METHOD_CODE=PAYM_CODE WHERE PINS_STATUS = '1' AND PINS_FACICODE=".$sql->Param('c')." AND (PINS_COMPANY_NAME LIKE ".$sql->Param('d')." OR PINS_LOCATION LIKE ".$sql->Param('e')." OR PINS_INSURANCE_NAME LIKE ".$sql->Param('f')." OR PCS_CATEGORY LIKE ".$sql->Param('g')." ) ";
        $input = array($facicode,'%'.$fdsearch.'%','%'.$fdsearch.'%','%'.$fdsearch.'%','%'.$fdsearch.'%');
}else {
 $query = "SELECT PINS_ID, PINS_CODE, PINS_FACICODE, PINS_ACC_DETAILS, PINS_COMPANY_NAME, PINS_LOCATION, PINS_CONTACT, PINS_INSURANCE_NAME, PINS_CATEGORY_CODE, PINS_METHOD_CODE, PCS_CATEGORY,PAYM_NAME,PINS_STATUS from hms_facilities_payment JOIN hmsb_set_paymentcatgory ON PINS_CATEGORY_CODE=PCS_CATECODE JOIN hmsb_set_paymentmethod ON PINS_METHOD_CODE=PAYM_CODE WHERE PINS_STATUS = '1' AND PINS_FACICODE=".$sql->Param('c')." ";
        $input = array($facicode);
}
	
	}




if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=50d37588e936ebb72d2716e6944a490c&option=707436a5aa13b82a4d777f64c717a625&uiid=c7e0e599d2520ee7fda7a45375e0e1b5#',$input);
    	
    break;
}
$stmtcat=$sql->Execute($sql->Prepare("SELECT PCS_CATEGORY,PCS_CATECODE from hmsb_set_paymentcatgory WHERE PCS_STATUS=".$sql->Param('a').""),array('1'));
			$catarray=array();
	if($stmtcat->RecordCount()>0){
		while ($obj=$stmtcat->FetchNextObject()){
			$catarray[]=array('CATEGORY_NAME'=>$obj->PCS_CATEGORY,'CATEGORY_CODE'=>$obj->PCS_CATECODE);
		}
	}else{
		return false;
	}
		
if (isset($category) && !empty($category)){
	$stmtcattype =$sql->Execute($sql->Prepare("SELECT PAYM_NAME,PAYM_CODE from hmsb_set_paymentmethod WHERE PAYM_CATEGORYCODE=".$sql->Param('a')." AND PAYM_STATUS=".$sql->Param('b')." "),array($category,'1'));
		$cattypearray=array();
		if ($stmtcattype->RecordCount()>0){
			while ($obj=$stmtcattype->FetchNextObject()){
				$cattypearray[]=array('TYPE_NAME'=>$obj->PAYM_NAME,'TYPE_CODE'=>$obj->PAYM_CODE);
			}
		}else{
			return false;
		}
}	

    	//FOR TABLE
//if category and type is not selected

if (!empty($category) && !empty($categorytype)){
if(!empty($fdsearch)){
 $query = "SELECT PINS_ID, PINS_CODE, PINS_FACICODE, PINS_ACC_DETAILS, PINS_COMPANY_NAME, PINS_LOCATION, PINS_CONTACT, PINS_INSURANCE_NAME, PINS_CATEGORY_CODE, PINS_METHOD_CODE, PCS_CATEGORY,PAYM_NAME,PINS_STATUS from hms_facilities_payment JOIN hmsb_set_paymentcatgory ON PINS_CATEGORY_CODE=PCS_CATECODE JOIN hmsb_set_paymentmethod ON PINS_METHOD_CODE=PAYM_CODE WHERE PINS_STATUS = '1' AND PINS_CATEGORY_CODE=".$sql->Param('b')." AND PINS_METHOD_CODE=".$sql->Param('b')." AND  PINS_FACICODE=".$sql->Param('c')." AND (PINS_COMPANY_NAME LIKE ".$sql->Param('d')." OR PINS_LOCATION LIKE ".$sql->Param('e')." OR PINS_INSURANCE_NAME LIKE ".$sql->Param('f')." OR PCS_CATEGORY LIKE ".$sql->Param('g')." ) ";
        $input = array($category,$categorytype,$facicode,'%'.$fdsearch.'%','%'.$fdsearch.'%','%'.$fdsearch.'%','%'.$fdsearch.'%');
}else {
 $query = "SELECT PINS_ID, PINS_CODE, PINS_FACICODE, PINS_ACC_DETAILS, PINS_COMPANY_NAME, PINS_LOCATION, PINS_CONTACT, PINS_INSURANCE_NAME, PINS_CATEGORY_CODE, PINS_METHOD_CODE, PCS_CATEGORY,PAYM_NAME,PINS_STATUS from hms_facilities_payment JOIN hmsb_set_paymentcatgory ON PINS_CATEGORY_CODE=PCS_CATECODE JOIN hmsb_set_paymentmethod ON PINS_METHOD_CODE=PAYM_CODE WHERE PINS_STATUS = '1' AND PINS_CATEGORY_CODE=".$sql->Param('b')." AND PINS_METHOD_CODE=".$sql->Param('b')." AND  PINS_FACICODE=".$sql->Param('c')." ";
        $input = array($category,$categorytype,$facicode);
}
}
//if category and type is  selected
elseif (!empty($category) && empty($categorytype)){
	
if(!empty($fdsearch)){
 $query = "SELECT PINS_ID, PINS_CODE, PINS_FACICODE, PINS_ACC_DETAILS, PINS_COMPANY_NAME, PINS_LOCATION, PINS_CONTACT, PINS_INSURANCE_NAME, PINS_CATEGORY_CODE, PINS_METHOD_CODE, PCS_CATEGORY,PAYM_NAME,PINS_STATUS from hms_facilities_payment JOIN hmsb_set_paymentcatgory ON PINS_CATEGORY_CODE=PCS_CATECODE JOIN hmsb_set_paymentmethod ON PINS_METHOD_CODE=PAYM_CODE WHERE PINS_STATUS = '1' AND PINS_CATEGORY_CODE=".$sql->Param('b')." AND  PINS_FACICODE=".$sql->Param('c')." AND (PINS_COMPANY_NAME LIKE ".$sql->Param('d')." OR PINS_LOCATION LIKE ".$sql->Param('e')." OR PINS_INSURANCE_NAME LIKE ".$sql->Param('f')." OR PCS_CATEGORY LIKE ".$sql->Param('g')." ) ";
        $input = array($category,$facicode,'%'.$fdsearch.'%','%'.$fdsearch.'%','%'.$fdsearch.'%','%'.$fdsearch.'%');
}else {
 $query = "SELECT PINS_ID, PINS_CODE, PINS_FACICODE, PINS_ACC_DETAILS, PINS_COMPANY_NAME, PINS_LOCATION, PINS_CONTACT, PINS_INSURANCE_NAME, PINS_CATEGORY_CODE, PINS_METHOD_CODE, PCS_CATEGORY,PAYM_NAME,PINS_STATUS from hms_facilities_payment JOIN hmsb_set_paymentcatgory ON PINS_CATEGORY_CODE=PCS_CATECODE JOIN hmsb_set_paymentmethod ON PINS_METHOD_CODE=PAYM_CODE WHERE PINS_STATUS = '1' AND PINS_CATEGORY_CODE=".$sql->Param('b')." AND  PINS_FACICODE=".$sql->Param('c')." ";
        $input = array($category,$facicode);
}
	
	
}
//if nothing is selected
else{
if(!empty($fdsearch)){
 $query = "SELECT PINS_ID, PINS_CODE, PINS_FACICODE, PINS_ACC_DETAILS, PINS_COMPANY_NAME, PINS_LOCATION, PINS_CONTACT, PINS_INSURANCE_NAME, PINS_CATEGORY_CODE, PINS_METHOD_CODE, PCS_CATEGORY,PAYM_NAME,PINS_STATUS from hms_facilities_payment JOIN hmsb_set_paymentcatgory ON PINS_CATEGORY_CODE=PCS_CATECODE JOIN hmsb_set_paymentmethod ON PINS_METHOD_CODE=PAYM_CODE WHERE PINS_STATUS = '1' AND PINS_FACICODE=".$sql->Param('c')." AND (PINS_COMPANY_NAME LIKE ".$sql->Param('d')." OR PINS_LOCATION LIKE ".$sql->Param('e')." OR PINS_INSURANCE_NAME LIKE ".$sql->Param('f')." OR PCS_CATEGORY LIKE ".$sql->Param('g')." ) ";
        $input = array($facicode,'%'.$fdsearch.'%','%'.$fdsearch.'%','%'.$fdsearch.'%','%'.$fdsearch.'%');
}else {
 $query = "SELECT PINS_ID, PINS_CODE, PINS_FACICODE, PINS_ACC_DETAILS, PINS_COMPANY_NAME, PINS_LOCATION, PINS_CONTACT, PINS_INSURANCE_NAME, PINS_CATEGORY_CODE, PINS_METHOD_CODE, PCS_CATEGORY,PAYM_NAME,PINS_STATUS from hms_facilities_payment JOIN hmsb_set_paymentcatgory ON PINS_CATEGORY_CODE=PCS_CATECODE JOIN hmsb_set_paymentmethod ON PINS_METHOD_CODE=PAYM_CODE WHERE PINS_STATUS = '1' AND PINS_FACICODE=".$sql->Param('c')." ";
        $input = array($facicode);
}
	
	}




if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=50d37588e936ebb72d2716e6944a490c&option=707436a5aa13b82a4d777f64c717a625&uiid=c7e0e599d2520ee7fda7a45375e0e1b5#',$input);



?>