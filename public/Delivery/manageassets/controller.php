<?php
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$userCourier = $engine->getActorCourier();
switch($viewpage){
	
	case "edit":
	//echo $userCourier;exit;
		$stmt = $sql->Execute($sql->Prepare("SELECT MA_CODE,MA_NAME, MA_SERIAL,MA_DATE_PUR,MA_DATE_ASS,MA_STATUS,MA_INSTCODE, MA_ASSETNO,COU_FNAME, COU_SURNAME,MA_UNAME FROM hms_courierasset join hms_courieragents ON COU_CODE = MA_ASSIGNED  WHERE MA_CODE  = ".$sql->Param('a')." "),array($keys)); 
		print $sql->ErrorMsg();
		if($stmt->RecordCount() == 1){
			$obj = $stmt->FetchNextObject();
			$assetname = $obj->MA_NAME;
			$serialno = $obj->MA_SERIAL;
			$agent = $obj->COU_FNAME." ".$obj->COU_SURNAME;
			$enddate = $obj->MA_DATE_ASS;
			$startdate = $obj->MA_DATE_PUR;
			$delstatus = $obj->MA_STATUS;
			$img = $obj->MA_UNAME;
			$regno = $obj->MA_ASSETNO;
			 
			 $imgold = $obj->MA_UNAME;
			
	    }
		
		$agentdob = date("d-m-Y",strtotime($startdate));
		 
	break;
	
	
	case "insertasset":

	
	$postkey = $session->get("postkey");
if($postkey != $microtime){
	$session->set("postkey",$microtime);
	
	if( empty($assetname) || empty($serialno) || empty($startdate)){
		
		$msg = "Please you cannot save. All Fields are Required";
		$status = "error";	
		
	}else {
		
		$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_courierasset WHERE MA_NAME=".$sql->Param('a')." AND MA_SERIAL = ".$sql->Param('b')."  "),array($assetname, $serialno));
			print $sql->ErrorMsg();
		
		
		
		if($stmt->RecordCount()>0){
				$msg = "Failed, Asset exists already.";
	    		$status = "error";
		}else {
			
			$purdate = date("Y-m-d",strtotime($startdate));
			$assigneddate = date("Y-m-d",strtotime($enddate));
			$newassetname = strtoupper($assetname);
			$assettcode = uniqid();
			
			$sql->Execute($sql->Prepare("INSERT INTO hms_courierasset (MA_CODE,MA_NAME, MA_SERIAL,MA_ASSIGNED,MA_DATE_PUR,MA_DATE_ASS,MA_INSTCODE,MA_ASSETNO, MA_UNAME, MA_PICNAME, MA_PICSIZE) VALUES (".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').", ".$sql->Param('e').", ".$sql->Param('f').", ".$sql->Param('g').", ".$sql->Param('h').", ".$sql->Param('i').", ".$sql->Param('j').", ".$sql->Param('k').")"), array($assettcode,$newassetname,$serialno, $assigned,$purdate, $assigneddate,$userCourier,$regno,$neu_name,$_name_,$_size_));
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
		$stmt = $sql->Execute($sql->Prepare("UPDATE hms_courierasset SET 
MA_UNAME =".$sql->Param('a').",MA_PICNAME =".$sql->Param('b').",
MA_PICSIZE =".$sql->Param('c')." WHERE MA_CODE =".$sql->Param('d')." "),
array($neu_name,$_name_,$_size_,$assettcode));
	print $sql->ErrorMsg();	
		
	}
	}
	}
		$msg = "Agent Created Successfully.";
	    $status = "success";
        $activity = "Agent Created Successfully.";
		$engine->setEventLog("015",$activity);	
			
		}
	}
}
	
	
	break;
	
	case "updateagent":
	$_name_ = $_FILES['picturename']['name'];
			

		if(!empty($keys)){ 
		
			$agentdobs = date("Y-m-d",strtotime($startdate));
			$newfirstname = strtoupper($fname);
			$newsurname = strtoupper($othername);
		
			
			$stmt = $sql->Execute($sql->Prepare("UPDATE hms_courieragents SET COU_FNAME=".$sql->Param('a').", COU_SURNAME=".$sql->Param('c').", COU_CONTACT=".$sql->Param('d').", COU_EMAIL=".$sql->Param('e').",COU_ADDRESS=".$sql->Param('f').", COU_DOB=".$sql->Param('g')."  WHERE COU_CODE=".$sql->Param('b')),array($newfirstname,$newsurname, $phonenumber,$email, $address,$agentdobs,$keys));

		
		
        $msg = "Agent Details Edit Successfully.";
	    $status = "success";
        $activity = "Agent Details Edit Successfully.";
		$engine->setEventLog("016",$activity);	
		
		
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
		$stmt = $sql->Execute($sql->Prepare("UPDATE hms_courieragents SET 
COU_UNAME =".$sql->Param('a').",COU_PICNAME =".$sql->Param('b').",
COU_PICSIZE =".$sql->Param('c')." WHERE COU_CODE =".$sql->Param('d')." "),
array($neu_name,$_name_,$_size_,$keys));
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
	
	 $query = "SELECT COU_CODE,COU_FNAME, COU_SURNAME,COU_CONTACT,COU_EMAIL,COU_ADDRESS,COU_DOB,COU_INSTCODE,COU_STATUS FROM hms_courieragents WHERE COU_STATUS ='1' AND COU_INSTCODE=".$sql->Param('a')." AND (COU_SURNAME LIKE ".$sql->Param('b')." OR COU_FNAME LIKE ".$sql->Param('b')." ) "; $input = array($userCourier,'%'.$fdsearch.'%','%'.$fdsearch.'%');

}else {

    $query = "SELECT MA_CODE,MA_NAME, MA_SERIAL,MA_DATE_PUR,MA_DATE_ASS,MA_STATUS,MA_INSTCODE, MA_ASSETNO,COU_FNAME, COU_SURNAME FROM hms_courierasset join hms_courieragents ON COU_CODE = MA_ASSIGNED WHERE MA_INSTCODE=".$sql->Param('a')." "; $input = array($userCourier);
}

$stmtagents = $sql->Execute($sql->Prepare("SELECT COU_CODE,COU_FNAME, COU_SURNAME from hms_courieragents where COU_STATUS AND COU_INSTCODE=".$sql->Param('a')."  "), $input = array($userCourier));


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