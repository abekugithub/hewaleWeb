<?php
//print_r($_POST);
$crypt = new cryptCls();
$actorid = $session->get("userid");
$actorname = $engine->getActorName();
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$objdtls = $engine->getFacilityDetails();
$facilityalias = $objdtls->FACI_ALIAS ;

switch($viewpage){
	case "saveuser":
	$duplicatekeeper = $session->get("post_key");
	if($microtime != $duplicatekeeper){
		$session->set("post_key",$microtime);
	if(!empty($fname) && !empty($othername) && !empty($phoneno) && !empty($emcontact) && !empty($userlevel) && !empty($usrname) && !empty($usrpwd)){
			//Get user code
			$fr = substr($fname,0,1);
			$usrcode = $engine->getUserCode();
			$finalcode = strtoupper($fr).$usrcode;
			
			//Build username
			$usrname = $usrname.'@'.$facilityalias;
			
			//Set Password
			$inputpwd = $crypt->loginPassword($usrname,$usrpwd);

			//Check if username is unique
			$stmt = $sql->Execute($sql->Prepare("SELECT USR_USERNAME FROM hms_users WHERE USR_USERNAME = ".$sql->Param('a')." "),array($usrname));
			print $sql->ErrorMsg();
			if($stmt){
			    if($stmt->RecordCount() == 0){

			$sql->Execute("INSERT INTO hms_users(USR_CODE,USR_FACICODE,USR_SURNAME,USR_OTHERNAME,USR_PASSWORD,USR_USERNAME,USR_STARTDATE,USR_EMAIL,USR_PHONENO,USR_EMERGENCYCONTACT,USR_ADDRESS,USR_TYPE,USR_LEVEL_FACLVID,USR_HOSPOSITION,USR_STATUS,USR_ACTOR,USR_PHONENO2) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('j').",".$sql->Param('k').",".$sql->Param('l').",".$sql->Param('m').",".$sql->Param('n').",".$sql->Param('o').",".$sql->Param('p').",".$sql->Param('p').")",array($finalcode,$activeinstitution,$fname,$othername,$inputpwd,$usrname,$startdate,$email,$phoneno,$emcontact,$address,'2',$userlevel,$usrposition,$usrstatus,$actorid,$altphone));
			print $sql->ErrorMsg();
			
			$insertedid = $sql->Insert_ID();

			foreach($_POST['syscheckbox'] as $value){
				$sql->Execute("INSERT INTO hmsb_menusubusers(MENUCT_USRUSERID,MENUCT_MENUDETCODE,MENUCT_ADDEDBY) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').")",array($insertedid,$value,$actorid));
				
				//Populate module in a array for event log
				$menuaccess[] = $value;
			print $sql->ErrorMsg();
			}
			
			 $menuaccessa = implode(',',$menuaccess);
			 $activity = 'New user created with full name: '.$fname.' '.$othername.' user code: '.$finalcode.' username: '.$usrname.' Module Accessibility: '.$menuaccessa.' by '.$actorname;
             $engine->setEventLog('004',$activity);
			 
				   $msg = "Success: User captured successfully.";
	               $status = "success";
	               $view ='';
				}else{
					 $msg = "Failed. Username already exists.";
	                 $status = "error";
	                 $view ='adduser';
					  }
				
				 }
			}else{
				   $msg = "Failed. Required field(s) cannot be empty.";
	               $status = "error";
	               $view ='adduser';
				 }
	}
	break;
	
	case "edituser":
	 if(isset($keys) && $keys != ''){
		$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_users WHERE USR_USERID = ".$sql->Param('a')." "),array($keys)); 
		print $sql->ErrorMsg();
		if($stmt->RecordCount() == 1){
			$obj = $stmt->FetchNextObject();
			$fname = $obj->USR_SURNAME;
			$othername = $obj->USR_OTHERNAME;
			$phoneno = $obj->USR_PHONENO;
			$email = $obj->USR_EMAIL;
			$altphone = $obj->USR_PHONENO2;
			$emcontact = $obj->USR_EMERGENCYCONTACT;
			$address = $obj->USR_ADDRESS;
			$userlevel = $obj->USR_LEVEL_FACLVID;
			$usrposition = $obj->USR_HOSPOSITION;
			$usrstatus = $obj->USR_STATUS;
	    }
		 
	}
	break;
	
	case "saveedit":
	if(isset($keys) && !empty($keys)){
	if(!empty($fname) && !empty($othername) && !empty($phoneno) && !empty($emcontact) && !empty($userlevel)){
				
 $sql->Execute("UPDATE hms_users SET USR_SURNAME = ".$sql->Param('a')." ,USR_OTHERNAME = ".$sql->Param('b')." ,USR_EMAIL = ".$sql->Param('c').",USR_PHONENO = ".$sql->Param('d').",USR_EMERGENCYCONTACT = ".$sql->Param('a')." ,USR_ADDRESS = ".$sql->Param('a')." ,USR_LEVEL_FACLVID = ".$sql->Param('a')." ,USR_HOSPOSITION = ".$sql->Param('a')." ,USR_STATUS = ".$sql->Param('a')." ,USR_PHONENO2 = ".$sql->Param('a')." WHERE USR_USERID = ".$sql->Param('a')." ",array($fname,$othername,$email,$phoneno,$emcontact,$address,$userlevel,$usrposition,$usrstatus,$altphone,$keys));
	print $sql->ErrorMsg();
	
	 //Set module accessibility
	 //Delete before rebuliding
	 $sql->Execute("DELETE FROM hmsb_menusubusers WHERE MENUCT_USRUSERID = ".$sql->Param('a')." ",array($keys));
	  
	foreach($_POST['syscheckbox'] as $value){
				$sql->Execute("INSERT INTO hmsb_menusubusers(MENUCT_USRUSERID,MENUCT_MENUDETCODE,MENUCT_ADDEDBY) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').")",array($keys,$value,$actorid));
				
				//Populate module in a array for event log
				$menuaccess[] = $value;
			print $sql->ErrorMsg();
			}
	
	 $menuaccessa = implode(',',$menuaccess);
	 $activity = 'User edited with full name: '.$fname.' '.$othername.' Module Accessibility: '.$menuaccessa.' by '.$actorname;
     $engine->setEventLog('006',$activity);
				   $msg = "Success: User edited successfully.";
	               $status = "success";
	               $view ='';
	}else{
		   		   $msg = "Failed. Required field(s) cannot be empty.";
	               $status = "error";
	               $view ='edituser';
		 }
	}
	break;
	
	case "resetpwd":
	if(isset($keys) && !empty($keys))
	{
	    if(!empty($pwd) && ($pwd == $pwd2)){
			//Get username
			$objusr = $engine->geAllUsersDetails($keys);
			$username = $objusr->USR_USERNAME;
			
			$passwd = $crypt->loginPassword($username,$pwd);
			
			 $sql->Execute("UPDATE hms_users SET USR_PASSWORD = ".$sql->Param('a').",USR_CHANGE_PASSWORD_STATUS = '0' WHERE USR_USERID = ".$sql->Param('a')." ",array($passwd,$keys));
	print $sql->ErrorMsg();
	  
	  $activity = 'Password reset for : '.$objusr->USR_SURNAME.' '.$objusr->USR_OTHERNAME.' with username: '.$objusr->USR_USERNAME.' User Code: '.$objusr->USR_CODE.' by '.$actorname;
     $engine->setEventLog('007',$activity);
	
				   $msg = "Success: Password successfully reset.";
	               $status = "success";
	               $view ='';
		}else{
			       $msg = "Failed. Password mismatch. Re-enter the password.";
	               $status = "error";
	               $view ="resetpwd";
			
			 }	
	}
	break;
	
	case "deleteuser":
	  if(isset($keys) && !empty($keys)){
		  $objusr = $engine->geAllUsersDetails($keys);
		  
		   $sql->Execute("UPDATE hms_users SET USR_DELETE_STATUS = '1', USR_STATUS = '2', USR_DELETE_DATE = ".$sql->Param('a')." WHERE USR_USERID = ".$sql->Param('b')." ",array($startdate,$keys)); 
		  
		  	  $activity = 'User deleted. User fullname : '.$objusr->USR_SURNAME.' '.$objusr->USR_OTHERNAME.' with username: '.$objusr->USR_USERNAME.' User Code: '.$objusr->USR_CODE.' by '.$actorname;
     $engine->setEventLog('008',$activity);

		           $msg = "Success: User successfully deleted.";
	               $status = "success";
	               $view ='';
	  }
	break;
	
	case "reset":
	   $fdsearch = $action_search = "";
	break;
}

if(isset($action_search) && $action_search == "search"){
	if(!empty($fdsearch)){
    $query = "SELECT * FROM hms_users WHERE USR_DELETE_STATUS = '0' AND USR_FACICODE = ".$sql->Param('a')." AND ( USR_SURNAME LIKE ".$sql->Param('b')." OR USR_OTHERNAME LIKE ".$sql->Param('c')." OR USR_USERNAME LIKE ".$sql->Param('d')." OR USR_PHONENO = ".$sql->Param('e').")";
    $input = array($activeinstitution,$fdsearch.'%',$fdsearch.'%',$fdsearch.'%',$fdsearch);
	}
}else {

    $query = "SELECT * FROM hms_users WHERE USR_DELETE_STATUS = '0' AND USR_FACICODE = ".$sql->Param('a')." ";
    $input = array($activeinstitution);
}
if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=ad2376beebecdcf7846ba973fa1a005b&option=6831b98f85019ddb98bd98d44bdbac40#',$input);

//Get all positions
$stmtpos2 = $engine->getUserPosition();
?>