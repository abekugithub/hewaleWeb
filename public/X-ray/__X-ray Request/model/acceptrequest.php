<?php 
include('../../../../config.php');
include SPATH_LIBRARIES.DS."engine.Class.php";
$engine=new engineClass();
$memberdetails=new patientClass();
$actorid = $session->get("userid");
$actorname = $engine->getActorName();
print_r($_POST);

if(isset($_POST["id"])){
$postto=explode('@@@',implode(',',$_POST["id"]));
$datapost1 =(str_replace(',','',$postto));
$datapost =(str_replace('on','',$datapost1));
for ($i=0;$i < count($datapost);$i++){
	$stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_labtest SET LT_STATUS='2' WHERE LT_CODE=".$sql->Param('a').""),array($datapost[$i]));
	print $sql->ErrorMsg();
 $stmts = $sql->Execute($sql->Prepare("SELECT * FROM hms_lab_testprice WHERE LL_FACICODE=".$sql->Param('a').""),array($datapost[$i]));
print $sql->ErrorMsg();
$obj = $stmts->FetchNextObject();
$price = $obj->LL_PRICE;
$lbcode=$obj->LL_TESTCODE;
$testname=$obj->LL_TESTNAME;
$facicode=$obj->LL_FACICODE;			
	}
$description="Lab request for patient with ID ".$patientnum." has been accepted, waiting for the bill payment to conduct the Lab";
$getinserted=$sql->Insert_ID();
$getPatientDetails=$memberdetails->getPatientDetails($patientnum);
$getcode=$getPatientDetails->PATIENT_CODE;
//$notification=$engine->setNotification("018",$description,"0008",$getinserted,$getcode,$facicode);
	//print_r($data);
}
?>
