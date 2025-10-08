<?php
$actorname = $engine->getActorName();
$usrcode = $engine->getActorCode();
$doctor = new doctorClass();
$upload = new importClass();

switch($viewpage){
	
	case "save":
        if (!empty($_FILES['image']['name'])){
						$image = $upload->uploadImage($_FILES['image'],SHOST_DOCTOR_IMG_URL.DS);
            $arr = explode('.',$image);
            $ext = (is_array($arr) && count($arr)>1?strtoupper($arr[1]):'');
        }else{
            //$image = $_POST['image'];
            $arr = explode('.',$image);
            $ext = (is_array($arr) && count($arr)>1?strtoupper($arr[1]):'');
        }

        $sql->Execute("UPDATE hmsb_med_prac SET MP_DOB = ".$sql->Param('a')." ,MP_GENDER = ".$sql->Param('a')." ,MP_NATIONALITY = ".$sql->Param('a')." ,MP_COUNTRY_OF_RESIDENCE = ".$sql->Param('a')." ,MP_MARITAL_STATUS = ".$sql->Param('a')." ,MP_PHONENO = ".$sql->Param('a')." ,MP_PHONENO2 = ".$sql->Param('a')." ,MP_CURRENCY = ".$sql->Param('a')." ,MP_CONSULTATION_CHARGES = ".$sql->Param('a').",MP_SUMMARY = ".$sql->Param('a').",MP_EMAIL = ".$sql->Param('a').",MP_PHOTO = ".$sql->Param('a').",MP_PHOTO_TYPE = ".$sql->Param('a').",MP_SURNAME = ".$sql->Param('a').",MP_OTHERNAME = ".$sql->Param('a').",MP_RESIDENCEADDRESS = ".$sql->Param('a')." WHERE MP_USRCODE = ".$sql->Param('a')." ",array($dob, $gender, $nationality, $residence, $mstatus, $phonenumber, $altphonenumber, $currency, $charges,$summary,$email,$image,$ext,$lastname,$fname,$address,$usrcode));
        print $sql->ErrorMsg();


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
	
	$doctorprofile = $doctor->getDoctorProfile($usrcode);
	
		$image = $doctorprofile->MP_PHOTO;
		$fname = $doctorprofile->MP_OTHERNAME;
		$lastname = $doctorprofile->MP_SURNAME;
		$dob = $doctorprofile->MP_DOB;
		$gender = $doctorprofile->MP_GENDER;
		$nationality = $doctorprofile->MP_NATIONALITY;
		$residence = $doctorprofile->MP_COUNTRY_OF_RESIDENCE;
		$mstatus = $doctorprofile->MP_MARITAL_STATUS;
		$phonenumber = $doctorprofile->MP_PHONENO;
		$altphonenumber = $doctorprofile->MP_PHONENO2;
		$currency = $doctorprofile->MP_CURRENCY;
		$charges = $doctorprofile->MP_CONSULTATION_CHARGES;
		$specialisation = $doctorprofile->MP_SPECIALISATION;
		$summary = $doctorprofile->MP_SUMMARY;
		$email = $doctorprofile->MP_EMAIL;
		$address = $doctorprofile->MP_RESIDENCEADDRESS;

	
	
   include 'model/js.php';
?>

