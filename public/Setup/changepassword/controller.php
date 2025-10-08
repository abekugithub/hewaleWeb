<?php
//print_r($_POST);
$crypt = new cryptCls();
$actorid = $session->get("userid");
$startdate = date("Y-m-d H:m:s");

switch ($viewpage){
	
	case "savepassword":
	
		if(empty($oldpassword) || empty($inputuserpassword) || empty($newinputuserpassword )){
			$msg = " Failed. Required field(s) can't be empty!.";
			$status = "error";
			$target ='';
	}
	
		if(!empty($inputuserpassword)){
			
			
			 if(strlen($inputuserpassword) < 6 ) {
				
				$msg = " Password length must be 6 to 14 Characters, Both numbers & Letters !";
			    $status = "error";
				$target ='';
				
				break;
			
				}
				if (!preg_match("#[0-9]+#", $inputuserpassword)) {
				$msg = " Password length must be 6 to 14 Characters, Both numbers & Letters !";
			    $status = "error";	
				$target ='';
				 
				 break;
				 }
				if (!preg_match("#[a-zA-Z]+#",$inputuserpassword)) {
					
				$msg = " Password length must be 6 to 14 Characters, Both numbers & Letters !";
			    $status = "error";
				$target ='';
				break;
					
				}
				if ($inputuserpassword !=  $newinputuserpassword) {
					
				$msg = " Password confirmation does not match, try again!";
			    $status = "error";
				$target ='';
				break;
					
				}
				
				$usrdetail = $engine->getActorDetails();
			
		
	$inputusername=$usrdetail->USR_USERNAME;
	$inputuserpassword1=$usrdetail->USR_PASSWORD;
	$inputuserpassword2 = $crypt->loginPassword($inputusername,$oldpassword);
	$inputuserpassword = $crypt->loginPassword($inputusername,$inputuserpassword);
	
	
	if($inputuserpassword2 == $inputuserpassword1) {
	$stmt = $sql->Execute($sql->Prepare("UPDATE hms_users SET USR_PASSWORD=".$sql->Param('a').",USR_CHANGE_PASSWORD_STATUS = '1' WHERE USR_USERID=".$sql->Param('b')),array($inputuserpassword,$actorid));
   
	$msg = "<a href='index.php?action=index&pg=dashboard'>Password Changed Successfully. Click here to go to Dashboard.</a>";
	$status = "success";
	
	$activity = "Password Changed Successfully.";
	$engine->setEventLog("018",$activity);
	$view ='passwordsuccess';
    
			}else{
				$msg = "Wrong old password entered.";
			    $status = "error";
				$view ='';
				 }		
		}
	
	break;
	
	
	
}







?>