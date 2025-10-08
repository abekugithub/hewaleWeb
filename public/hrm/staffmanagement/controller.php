<?php
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$userCourier = $engine->getActorCourier();
switch($viewpage){
	
	case "edit":
	//echo $userCourier;exit;
		$stmt = $sql->Execute($sql->Prepare("SELECT SM_CODE,SM_FNAME, SM_SURNAME,SM_EMAIL,SM_PHONE,SM_ADDRESS,SM_DATE,SM_EMERNAME, SM_EMERCONTACT, SM_EMEREMAIL, SM_JOINED, JB_NAME,SC_NAME,SM_UNAME,SM_INSTU,SM_JOBTYPE,SM_GRADE FROM hms_hrm_staffmgt JOIN hms_hrm_salarycomponents ON SM_GRADE = SC_CODE JOIN hms_hrm_jobcategory ON SM_JOBTYPE = JB_CODE  WHERE SM_CODE  = ".$sql->Param('a')." "),array($keys)); 
		print $sql->ErrorMsg();
		if($stmt->RecordCount() == 1){
			$obj = $stmt->FetchNextObject();
			$fname = $obj->SM_FNAME;
			$othername = $obj->SM_SURNAME;
			$phonenumber = $obj->SM_PHONE;
			$address = $obj->SM_ADDRESS;
			$email = $obj->SM_EMAIL;
			$startdate = $obj->SM_DATE;
			$fullname = $obj->SM_EMERNAME;
			$contactno = $obj->SM_EMERCONTACT;
			$emeremail = $obj->SM_EMEREMAIL;
			$jobcode = $obj->SM_JOBTYPE;
			$jobcodename = $obj->JB_NAME;
			$gradecode = $obj->SM_GRADE;
			$gradename = $obj->SC_NAME;
			$enddate = $obj->SM_JOINED;
			$img = $obj->SM_UNAME;
			$imgold = $obj->SM_UNAME;
			
	    }
		
		$agentdob = date("d-m-Y",strtotime($startdate));
		$staffjoin = date("d-m-Y",strtotime($enddate));
		 
	break;
	
	
	case "insertstaff":
	
	
	$postkey = $session->get("postkey");
if($postkey != $microtime){
	$session->set("postkey",$microtime);
	
	if( empty($fname) || empty($othername) || empty($email) || empty($phonenumber) || empty($address) || empty($startdate)){
		
		$msg = "Please you cannot save. All Fields are Required";
		$status = "error";	
		
	}else {
		
		$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_hrm_staffmgt WHERE SM_FNAME=".$sql->Param('a')." AND SM_SURNAME = ".$sql->Param('b')." AND SM_INSTU = ".$sql->Param('c')." "),array($fname, $othername,$userCourier));
			print $sql->ErrorMsg();
		
		
		
		if($stmt->RecordCount()>0){
				$msg = "Failed, Employee exists already.";
	    		$status = "error";
		}else {
			
			$staffdob = date("Y-m-d",strtotime($startdate));
			$newfirstname = strtoupper($fname);
			$newsurname = strtoupper($othername);
			$staffjoin = date("Y-m-d",strtotime($enddate));
			$staffcode = uniqid();
			
			$sql->Execute($sql->Prepare("INSERT INTO hms_hrm_staffmgt (SM_CODE,SM_FNAME, SM_SURNAME,SM_EMAIL,SM_PHONE,SM_ADDRESS,SM_DATE,SM_EMERNAME, SM_EMERCONTACT, SM_EMEREMAIL, SM_JOINED, SM_JOBTYPE,SM_GRADE,SM_UNAME,SM_PICNAME,SM_PICSIZE,SM_INSTU) VALUES (".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').", ".$sql->Param('e').", ".$sql->Param('f').", ".$sql->Param('g').", ".$sql->Param('h').", ".$sql->Param('i').", ".$sql->Param('j').", ".$sql->Param('k').",".$sql->Param('l').",".$sql->Param('m').",".$sql->Param('n').",".$sql->Param('o').",".$sql->Param('p').",".$sql->Param('q').")"), array($staffcode,$newfirstname,$newsurname,$email, $phonenumber, $address,$staffdob,$fullname,$contactno,$emeremail,$staffjoin,$jobtype,$grade,$neu_name,$_name_,$_size_,$userCourier));
print $sql->ErrorMsg();
			
			
			$id = $sql->Insert_ID();
	
	if(is_uploaded_file($_FILES['picturename']['tmp_name'])){
		  $ext = array('image/pjpeg','image/jpeg','image/jpg','image/png','image/x-png','image/gif');
	$rand_numb = md5(uniqid(microtime()));
	$neu_name = $rand_numb.$_FILES['picturename']['name'];
	$_name_ = $_FILES['picturename']['name'];
	$_type_ = $_FILES['picturename']['type'];
	$_tmp_name_ = $_FILES['picturename']['tmp_name'];
	$_size_ = $_FILES['picturename']['size'] / 1024;
	
	if(in_array($_type_,$ext)){
	
        	
        if(@move_uploaded_file($_tmp_name_,SHOST_IMAGES.$neu_name))
	{
		$stmt = $sql->Execute($sql->Prepare("UPDATE hms_hrm_staffmgt SET 
SM_UNAME =".$sql->Param('a').",SM_PICNAME =".$sql->Param('b').",
SM_PICSIZE =".$sql->Param('c')." WHERE SM_CODE =".$sql->Param('d')." "),
array($neu_name,$_name_,$_size_,$staffcode));
	print $sql->ErrorMsg();	
		
	}
	}
	}
		$msg = "Employee Created Successfully.";
	    $status = "success";
        $activity = "Employee Created Successfully.";
		$engine->setEventLog("036",$activity);	
			
		}
	}
}
	
	
	break;
	
	case "updatestaff":
	$_name_ = $_FILES['picturename']['name'];
			

		if(!empty($keys)){ 
		
			$staffdob = date("Y-m-d",strtotime($startdate));
			$newfirstname = strtoupper($fname);
			$newsurname = strtoupper($othername);
			$staffjoin = date("Y-m-d",strtotime($enddate));
		
			
			$stmt = $sql->Execute($sql->Prepare("UPDATE hms_hrm_staffmgt SET SM_FNAME=".$sql->Param('a').", SM_SURNAME=".$sql->Param('c').", SM_EMAIL=".$sql->Param('d').", SM_PHONE=".$sql->Param('e').",SM_ADDRESS=".$sql->Param('f').", SM_DATE=".$sql->Param('g').", SM_EMERNAME=".$sql->Param('h').", SM_EMERCONTACT=".$sql->Param('i').", SM_EMEREMAIL=".$sql->Param('j').", SM_JOINED=".$sql->Param('g').", SM_JOBTYPE=".$sql->Param('k').", SM_GRADE=".$sql->Param('l').", SM_UNAME=".$sql->Param('m').", SM_PICNAME=".$sql->Param('n').", SM_PICSIZE=".$sql->Param('o')." WHERE SC_CODE=".$sql->Param('b')),array($newfirstname,$newsurname,$email, $phonenumber, $address,$staffdob,$fullname,$contactno,$emeremail,$staffjoin,$jobtype,$grade,$neu_name,$_name_,$_size_,$keys));
		
		
        $msg = "Employee Details Editted Successfully.";
	    $status = "success";
        $activity = "Employee Details Editted Successfully.";
		$engine->setEventLog("037",$activity);	
		
		
		if($pixname != $_name_) {
			
			
			$id = $sql->Insert_ID();
	
	if(is_uploaded_file($_FILES['picturename']['tmp_name'])){
		  $ext = array('image/pjpeg','image/jpeg','image/jpg','image/png','image/x-png','image/gif');
	$rand_numb = md5(uniqid(microtime()));
	$neu_name = $rand_numb.$_FILES['picturename']['name'];
	$_name_ = $_FILES['picturename']['name'];
	$_type_ = $_FILES['picturename']['type'];
	$_tmp_name_ = $_FILES['picturename']['tmp_name'];
	$_size_ = $_FILES['picturename']['size'] / 1024;
	
	if(in_array($_type_,$ext)){
	
        	
        if(@move_uploaded_file($_tmp_name_,SHOST_IMAGES.$neu_name))
	{
		$stmt = $sql->Execute($sql->Prepare("UPDATE hms_hrm_staffmgt SET 
SM_UNAME =".$sql->Param('a').",SM_PICNAME =".$sql->Param('b').",
SM_PICSIZE =".$sql->Param('c')." WHERE SM_CODE =".$sql->Param('d')." "),
array($neu_name,$_name_,$_size_,$keys));;
	print $sql->ErrorMsg();	
		
	}
	}
	}
			
			
			
		}
		
		
		
		}
	break;
	
	
	
	
	
	
	case "reset":
	$fdsearch='';
	
	break;
	

	
}

if(!empty($fdsearch)){
	
	 $query = "SELECT * FROM hms_hrm_staffmgt WHERE SM_STATUS ='1' AND SM_INSTU=".$sql->Param('a')." AND (SM_SURNAME LIKE ".$sql->Param('b')." OR SM_FNAME LIKE ".$sql->Param('b')." ) "; $input = array($userCourier,'%'.$fdsearch.'%','%'.$fdsearch.'%');

}else {

    $query = "SELECT * FROM hms_hrm_staffmgt WHERE SM_STATUS ='1' AND SM_INSTU=".$sql->Param('a')." "; $input = array($userCourier);
}

$stmtjobcate = $sql->Execute($sql->Prepare("SELECT * from hms_hrm_jobcategory where JB_STATUS='1' AND JB_INSTU=".$sql->Param('a')."  "), $input = array($userCourier));

$stmtgrade = $sql->Execute($sql->Prepare("SELECT * from hms_hrm_paygrade where PG_STATUS AND PG_INSTI=".$sql->Param('a')."  "), $input = array($userCourier));

if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=0ae6717ed4b10a21cfd627685a748a46&option=d7537109884329dd67f7f97d974d1ffb&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);

//Get all positions
$stmtpos = $engine->getUserPosition();

?>