<?php
$actorname = $engine->getActorName();
$usrcode = $engine->getActorCode();
$doctor = new doctorClass();
$upload = new importClass();



//print_r($nurseprofile);

//print_r($_POST);

switch($viewpage){
	
	case "save":
	
		
			$sql->Execute("UPDATE hmsb_vitals_post SET VP_DOB = ".$sql->Param('a')." ,VP_GENDER = ".$sql->Param('a')." ,VP_NATIONALITY = ".$sql->Param('a')." ,VP_COUNTRY_OF_RESIDENCE = ".$sql->Param('a')." ,VP_MARITAL_STATUS = ".$sql->Param('a')." ,VP_PHONENO = ".$sql->Param('a')." ,VP_PHONENO2 = ".$sql->Param('a')." ,VP_CURRENCY = ".$sql->Param('a')." ,VP_CONSULTATION_CHARGES = ".$sql->Param('a').",VP_SUMMARY = ".$sql->Param('a').",VP_EMAIL = ".$sql->Param('a')." WHERE VP_USRCODE = ".$sql->Param('a')." ",array($dob, $gender, $nationality, $residence, $mstatus, $phonenumber, $altphonenumber, $currency, $charges,$summary,$email,$usrcode));
		print $sql->ErrorMsg();

		$upload->uploadImage($image,SHOST_IMAGES);

		$msg = "Doctor's Profile has been successfully updated.";
		$status = "success";
	break;


	default:
		
	break;
	 }
	 
	//Get countries
	$stmtnatl = $sql->Execute($sql->Prepare("SELECT * FROM hmsb_countries_nationalities"));
	$nationalities = array();
	while($natl = $stmtnatl->FetchNextObject()){
		$nationalities[]=$natl;
	}

	$stmtrln = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_relation WHERE PR_PATIENTNUM = ".$sql->Param('a')." "),array($data));
	
	$nurseprofile = $doctor->getDoctorProfile($usrcode);

$stmtr = $sql->Execute($sql->Prepare("SELECT * FROM hmsb_vitals_post WHERE VP_USRCODE = ".$sql->Param('a')." "),array($usrcode));
print $sql->ErrorMsg();
if($stmtr){
    $nurseprofile = $stmtr->FetchNextObject();
}else{
    return false;
}

		$image = $nurseprofile->VP_PHOTO;
		$fname = $nurseprofile->VP_SURNAME;
		$lastname = $nurseprofile->VP_OTHERNAME;
		$dob = $nurseprofile->VP_DOB;
		$gender = $nurseprofile->VP_GENDER;
		$nationality = $nurseprofile->VP_NATIONALITY;
		$residence = $nurseprofile->VP_COUNTRY_OF_RESIDENCE;
		$mstatus = $nurseprofile->VP_MARITAL_STATUS;
		$phonenumber = $nurseprofile->VP_PHONENO;
		$altphonenumber = $nurseprofile->VP_PHONENO2;
		$currency = $nurseprofile->VP_CURRENCY;
		$charges = $nurseprofile->VP_CONSULTATION_CHARGES;
		$specialisation = $nurseprofile->VP_SPECIALISATION;
		$summary = $nurseprofile->VP_SUMMARY;
		$email = $nurseprofile->VP_EMAIL;

	
	
   include 'model/js.php';
?>

