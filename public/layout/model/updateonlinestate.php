<?php
ob_start();
include('../../../config.php');
include SPATH_LIBRARIES.DS.'engine.Class.php';
include SPATH_LIBRARIES.DS."doctors.Class.php";
$engine = new engineClass();
$doctors = new doctorClass();

$usrcode = $engine->getActorCode();
$usrdetails = $engine->getActorDetails();
$docname = $usrdetails->USR_OTHERNAME.' '.$usrdetails->USR_SURNAME;
$currentdate = date('Y-m-d ');
$currenttime = date('Y-m-d H:i:s');

$sessiononlinestate = $session->get('sessiononlinestate');
		
		$stmt = $sql->Execute($sql->Prepare("SELECT USR_ONLINE_STATUS FROM hms_users WHERE USR_CODE = ".$sql->Param('a')." "),array($usrcode));
		
		if($stmt){
			if($stmt->RecordCount() > 0){
			 $obj = $stmt->FetchNextObject();
			 $onlinestatus = $obj->USR_ONLINE_STATUS;
			
			 if($onlinestatus == '0'){
			$session->set('sessiononlinestate',md5(uniqid(microtime())));
			$sessiononlinestate = $session->get('sessiononlinestate');
          
			 $newstate = '1';
             
			 $sql->Execute("UPDATE hms_users SET USR_ONLINE_STATUS = '1' WHERE  USR_STATUS = '1' AND USR_CODE = ".$sql->Param('a')." ",array($usrcode));

			 //Start insertion into time monitor table (hmsb_doctormonitor)
			 $sql->Execute("INSERT INTO hmsb_doctorsmonitor(DM_DOCTORCODE,DM_DOCTORNAME,DM_DATE,DM_STARTTIME,DM_SESSIONLOGIN) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').") ",array($usrcode,$docname,$currentdate,$currenttime,$sessiononlinestate));
			 print $sql->ErrorMsg();
             echo "c";
			 //Send push notification to all patients
			 $stmtr = $sql->Execute($sql->Prepare("SELECT * FROM hms_users_online WHERE USRON_USRCODE = ".$sql->Param('a')." AND USRON_DATE = ".$sql->Param('b')." "),array($usrcode,$currentdate));
			 print $sql->ErrorMsg();
			 if($stmtr->RecordCount() == 0){
                 echo "d";
			 //Insert into online status table
			 $sql->Execute("INSERT INTO hms_users_online(USRON_USRCODE,USRON_DATE) VALUE(".$sql->Param('a').",".$sql->Param('b').") ",array($usrcode,$currentdate));

				 //$playerid = '5feba50b-4bcf-4fdf-8e7d-29078b140b8b';

				 $code = '037';
		         $ptitle = push_notif_title;
				 $pmessage = 'Doctor '.$docname.' is online.';  
                 //Get all patients who consult the active doctor
				 //coming online now
				 $Stmtonline = $sql->Execute($sql->Prepare("SELECT * FROM hms_consultation JOIN hms_patient_connect ON CONS_PATIENTCODE = PATCON_PATIENTCODE WHERE CONS_DOCTORCODE = ".$sql->Param('a')." AND CONS_STATUS IN ('1','2')  "),array($usrcode));
                 print $sql->ErrorMsg();
				 
				 //$playerid = '861cb9d3-12e1-4782-8c6a-715d83027aaf';
				 while( $objonline = $Stmtonline->FetchNextObject()){
				 if(!empty($objonline->PATCON_PLAYERID)){ echo $objonline->PATCON_PLAYERID ;
				 $engine->broadcastIndividualMessage($ptitle,$pmessage,$objonline->PATCON_PLAYERID ,$code,'',$largimg='',$bigimg='');
				 }
				 }
				 //$pmessagetext = "This is another try";
				 //$engine->broadcastIndividualMessage($ptitle,$pmessagetext,$playerid,$code,'',$largimg='',$bigimg='');

			 }
			 }else{
			 $sessiononlinestate = $session->get('sessiononlinestate');

			 $newstate = '0';
			 $stmt = $sql->Execute("UPDATE hms_users SET USR_ONLINE_STATUS = '0',USR_CONSULTING_STATUS= '0' WHERE  USR_STATUS = '1' AND USR_CODE = ".$sql->Param('a')." ",array($usrcode));

			 $sql->Execute($sql->Prepare("UPDATE hms_consultation SET CONS_INCONSULTATION = '0' WHERE CONS_DOCTORCODE = ".$sql->Param('a')." "),array($usrcode));


			  //Start updating time monitor table (hmsb_doctormonitor)
			   /*
			    * Get time difference
				*/
				$objmon = $doctors->gettimemonitordetails($sessiononlinestate,$usrcode);
				$starttime = $objmon->DM_STARTTIME;
              
				//$timediff = date( "i", abs(strtotime($currenttime) - strtotime($starttime)));
				//$timediff = date('i', $timediff);
				//$timediff = $timediff/3600;
				//$timediff = date_diff($currenttime, $starttime);
			  

				/** End getting time difference */
			  $sql->Execute("UPDATE hmsb_doctorsmonitor SET DM_ENDTIME = ".$sql->Param('a')." ,DM_TIMEDIFF = CONCAT(
				MOD (
					HOUR (
						TIMEDIFF(
							".$sql->Param('b').",
							".$sql->Param('c')."
						)
					),
					24
				),
				'H : ',
				MINUTE (
					TIMEDIFF(
						".$sql->Param('d').",
						".$sql->Param('e')."
					)
				),
				'min'
			),DM_SOURCE = '1' WHERE DM_SESSIONLOGIN = ".$sql->Param('f')." AND DM_DOCTORCODE = ".$sql->Param('g')." AND DM_ENDTIME IS NULL ",array($currenttime,$starttime,$currenttime,$starttime,$currenttime,$sessiononlinestate,$usrcode));
            print $sql->ErrorMsg();
			  $session->del('sessiononlinestate');
			 }
			 
			
			 
				
			 }else{
				 
				  }
			}
?>