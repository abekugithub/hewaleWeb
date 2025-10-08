<?php
/*
 ***************************************************************
 This file fetches all mail (lab results) sent by external labs
 from Hewale. All labs results' attachments are then sent to the
 patient lab request in Hewale.
 
 Author: Acker
 Date: Feb 04th, 2019
 Group: Hewale Team
 ***************************************************************
 */
include "../config.php";
include SPATH_LIBRARIES.DS."engine.Class.php";
include SPATH_LIBRARIES.DS."doctors.Class.php";
include SPATH_LIBRARIES.DS."smsgateway.class.php";

$engine = new engineClass();
$sms = new smsgetway();
$doctors = new doctorClass();
$patientCls = new patientClass();

$currentdate = date('Y-m-d');
/**For online connection to hewale use the open stream line below**/

//$mbox = imap_open("{mail.hewale.net:995/pop3/ssl/novalidate-cert}", "labs@hewale.net", "y03nnXeFKez*");
$mbox = imap_open("{mail.hewale.net:993/imap/ssl}INBOX", "labs@hewale.net", "y03nnXeFKez*");
//$imapobj = imap_check($mbox);
//var_dump($imapobj);
$num_msg = imap_num_msg($mbox);
/*
$allheaders = imap_headers($mbox);
print "<pre>";
print_r($allheaders);
print "<pre />";
*/
for($v=2; $v <= $num_msg; $v++){
//$msgheader = imap_header($mbox,$v);

$msgheader = imap_headerinfo($mbox,$v);

 $mailsubject = $msgheader->subject;
 $mailsubject = str_replace('Re:','',$mailsubject);
 $mailsubject = str_replace('Fwd:','',$mailsubject);

 $mailstruc = imap_fetchstructure($mbox,$v);

 /*
 print "<pre>";
 print_r($mailstruc);
 print "<pre />";
 
 
 print "<pre>";
 print_r($msgheader);
 print "<pre />";
 */


$attachments = array();
if(isset($mailstruc->parts) && count($mailstruc->parts)) {

	for($i = 0; $i < count($mailstruc->parts); $i++) {

		$attachments[$i] = array(
			'is_attachment' => false,
			'filename' => '',
			'name' => '',
			'attachment' => ''
		);
		
		if($mailstruc->parts[$i]->ifdparameters) {
			foreach($mailstruc->parts[$i]->dparameters as $object) {
				if(strtolower($object->attribute) == 'filename') {
					$attachments[$i]['is_attachment'] = true;
					$attachments[$i]['filename'] = $object->value; 
				}
			}
		}
		
		if($mailstruc->parts[$i]->ifparameters) {
			foreach($mailstruc->parts[$i]->parameters as $object) {
				if(strtolower($object->attribute) == 'name') {
					$attachments[$i]['is_attachment'] = true;
					$attachments[$i]['name'] = $object->value;
				}
			}
		}
		
		if($attachments[$i]['is_attachment']) {
			$attachments[$i]['attachment'] = imap_fetchbody($mbox, $v, $i+1);
            if($mailstruc->parts[$i]->encoding == 3) { // 3 = BASE64
               
				$decodedfile = $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
			}
			elseif($mailstruc->parts[$i]->encoding == 4) { // 4 = QUOTED-PRINTABLE
				$decodedfile = $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
			}
		  
			//Get file extension
		     $filename = $attachments[$i]['filename'];
			 $dotpos = stripos($filename,'.');
			 $fileextension = substr($filename,$dotpos);
			 

			//Begin download the lab file attached in the mail
			//Because we don't exactly which request is related to 
			//the file, the attachement will be linked to the default request.

			$uniq = uniqid();
			$file = 'labresult'.$uniq.$fileextension;
			$test = file_put_contents('../../uploads/labs/labresults/'.$file, $decodedfile);
			//$test = file_put_contents($file, $decodedfile);
			
			/*
			 * This section below begins insertion in the database
			 * and add the various downloaded files to a particular 
			 * lab request.
			 */
			$mailsubject = trim($mailsubject);
			
			$testtype = strtolower(substr($mailsubject, -1));

            if( $testtype != 'r'){
			
			$stmt = $sql->Execute($sql->Prepare("SELECT LTM_VISITCODE,LTM_PATIENTNUM,LTM_PATIENTCODE,LTM_PATIENTNAME,LTM_ACTORCODE FROM hms_patient_labtest_main WHERE LTM_PACKAGECODE = ".$sql->Param('a')." "),array($mailsubject));
			print $sql->ErrorMsg();

			if($stmt->RecordCount() > 0){
				$obj = $stmt->FetchNextObject();
				$prltkey = uniqid();

				//Get any of the lab request code
				$stmtp = $sql->Execute($sql->Prepare("SELECT LT_CODE FROM hms_patient_labtest WHERE LT_PACKAGECODE = ".$sql->Param('a')." LIMIT 1 "),array($mailsubject));
				print $sql->ErrorMsg();
				$objp = $stmtp->FetchNextObject();
				$labreqcode = $objp->LT_CODE ;

				$sql->Execute($sql->Prepare("INSERT INTO hms_patient_labresult_files(LTMI_ID,LTMI_PACKAGECODE, LTMI_VISITCODE, LTMI_DATE, LTMI_PATIENTNUM, LTMI_PATIENTCODE, LTMI_LTCODE, LTMI_FILENAME) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').")"),array($prltkey,$mailsubject,$obj->LTM_VISITCODE,$currentdate, $obj->LTM_PATIENTNUM, $obj->LTM_PATIENTCODE,$labreqcode,$file));
				print $sql->ErrorMsg();

				//Update patient_labtest_table
				$sql->Execute("UPDATE hms_patient_labtest SET LT_STATUS = '7' WHERE LT_PACKAGECODE = ".$sql->Param('a')." AND LT_STATUS != '0' ",array($mailsubject));
				print $sql->ErrorMsg();
				
				$sql->Execute("UPDATE hms_patient_labtest_main SET LTM_STATUS = '7' WHERE LTM_PACKAGECODE = ".$sql->Param('a')." ",array($mailsubject));

				//sms
				$objdoc = $doctors->getDoctorProfile($obj->LTM_ACTORCODE);
				$msg = 'Lab result for patient '.$obj->LTM_PATIENTNAME.' With Hewale number '.$obj->LTM_PATIENTNUM.' is now ready and sent for your perusal.';
				$phone = $objdoc->MP_PHONENO;
				$phone = $sms->validateNumber($phone,+233);
				$results = $sms->sendSms($phone,$msg);
				//end of sms

				//Notification
				$notifmsg =  "Lab result sent successfully for patient ".$obj->LTM_PATIENTNAME." with patient number: ".$obj->LTM_PATIENTNUM." visit code: ".$obj->LTM_VISITCODE." and batch code : ".$mailsubject;
				$notifycode = '044';
				$objpt = $patientCls->getConsultationVisitDetails($obj->LTM_VISITCODE);
				$tablerowid = $objpt->CONS_ID;
				$menudetailscode = '0137';
				$sentto = $obj->LTM_ACTORCODE;
				$engine->setNotification($notifycode,$notifmsg,$menudetailscode,$tablerowid,$sentto);
				//End of notification

				$engine->setEventLog("121",$notifmsg);

                //Delete message
				imap_delete($mbox,$v);

			} 
		}elseif($testtype == 'r'){

            $stmt = $sql->Execute($sql->Prepare("SELECT XTM_VISITCODE,XTM_PATIENTNUM,XTM_PATIENTCODE,XTM_PATIENTNAME,XTM_ACTORCODE FROM hms_patient_xraytest_main WHERE XTM_PACKAGECODE = ".$sql->Param('a')." "),array($mailsubject));
			print $sql->ErrorMsg();

			if($stmt->RecordCount() > 0){
				$obj = $stmt->FetchNextObject();
				$prltkey = uniqid();

				//Get any of the lab request code
				$stmtp = $sql->Execute($sql->Prepare("SELECT XT_CODE FROM hms_patient_xraytest WHERE XT_PACKAGECODE = ".$sql->Param('a')." LIMIT 1 "),array($mailsubject));
				print $sql->ErrorMsg();
				$objp = $stmtp->FetchNextObject();
				$labreqcode = $objp->XT_CODE ;

				$sql->Execute($sql->Prepare("INSERT INTO hms_patient_xraytest_files(XTMI_ID,XTMI_PACKAGECODE, XTMI_VISITCODE, XTMI_DATE, XTMI_PATIENTNUM, XTMI_PATIENTCODE, XTMI_LTCODE, XTMI_FILENAME) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').")"),array($prltkey,$mailsubject,$obj->XTM_VISITCODE,$currentdate, $obj->XTM_PATIENTNUM, $obj->XTM_PATIENTCODE,$labreqcode,$file));
				print $sql->ErrorMsg();

				//Update patient_labtest_table
				$sql->Execute("UPDATE hms_patient_xraytest SET XT_STATUS = '7' WHERE XT_PACKAGECODE = ".$sql->Param('a')." AND XT_STATUS != '0' ",array($mailsubject));
				print $sql->ErrorMsg();
				
				$sql->Execute("UPDATE hms_patient_xraytest_main SET XTM_STATUS = '7' WHERE XTM_PACKAGECODE = ".$sql->Param('a')." ",array($mailsubject));

				//sms
				$objdoc = $doctors->getDoctorProfile($obj->XTM_ACTORCODE);
				$msg = 'Scan result for patient '.$obj->XTM_PATIENTNAME.' With Hewale number '.$obj->XTM_PATIENTNUM.' is now ready and sent for your perusal.';
				$phone = $objdoc->MP_PHONENO;
				$phone = $sms->validateNumber($phone,+233);
				$results = $sms->sendSms($phone,$msg);
				//end of sms

				//Notification
				$notifmsg =  "Lab result sent successfully for patient ".$obj->XTM_PATIENTNAME." with patient number: ".$obj->XTM_PATIENTNUM." visit code: ".$obj->XTM_VISITCODE." and batch code : ".$mailsubject;
				$notifycode = '044';
				$objpt = $patientCls->getConsultationVisitDetails($obj->XTM_VISITCODE);
				$tablerowid = $objpt->CONS_ID;
				$menudetailscode = '0138';
				$sentto = $obj->XTM_ACTORCODE;
				$engine->setNotification($notifycode,$notifmsg,$menudetailscode,$tablerowid,$sentto);
				//End of notification

				$engine->setEventLog("121",$notifmsg);

                //Delete message
				imap_delete($mbox,$v);

		}

			 /* End of insertion in database */


		}
	}

}




}
}
//Delete all messages marked for deletion after fetching attachment
imap_expunge($mbox);
//Close the opened imap stream after fetching attachment
imap_close();

echo "bravooooo";
?>