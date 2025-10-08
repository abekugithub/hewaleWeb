<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 8/25/2017
 * Time: 11:59 AM
 */
include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
include SPATH_LIBRARIES.DS."doctors.Class.php";
$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);

$engine = new engineClass();
$doc = new doctorClass();
$day = Date("Y-m-d");
$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();
$actor = $engine->getActorDetails();
$activeinstitution = $actor->USR_FACICODE;
//$managementcode = '000';

if (!empty($physicalexamstype)){
    $visitcode = $new_visitcode;
    $phyexcode = $doc->getPhysicalExamsCode();
    $phyexam = explode('@@@',$physicalexamstype);
    $physicalexamstypecode = $phyexam[0];
    $physicalexamsname = $phyexam[1];
	$physicalexamstype = $encaes->encrypt($physicalexamsname);
	$physicalexamsdetails = $encaes->encrypt($physicalexamsdetails);

    
	$stmtman = $sql->Execute($sql->Prepare("INSERT INTO hms_patient_physicalexams (PPEX_CODE, PPEX_DATE, PPEX_PATIENTNUM, PPEX_VISITCODE, PPEX_PHYSICALEXAMSTYPE, PPEX_PHYSICALEXAMSDETAILS, PPEX_INSTCODE, PPEX_ACTORNAME, PPEX_ENCRYPKEY, PPEX_ACTORCODE,PPEX_PHYSICALEXAMSTYPECODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').")"),array($phyexcode,$day,$patientnum,$visitcode,$physicalexamstype,$physicalexamsdetails,$activeinstitution,$usrname,$encryptkey,$usrcode,$physicalexamstypecode));
    print $sql->ErrorMsg();
    if ($stmtman){
        //$msg = "Consultation has been saved successfully";
        //$status = "success";

		$fetchstmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_physicalexams WHERE PPEX_PATIENTNUM = ".$sql->Param('1')." AND PPEX_VISITCODE = ".$sql->Param('2')." AND PPEX_STATUS = ".$sql->Param('3').""),array($patientnum,$visitcode,'1'));
        print $sql->ErrorMsg();
        $result = array();
        $num = 1;
        if ($fetchstmt->RecordCount()>0){
            while ($obj = $fetchstmt->FetchNextObject()){
				// Decrypt text with another key if necessary
				$decrypid = $obj->PPEX_ENCRYPKEY;
				if($decrypid != $activekey){
				$saltencrypt = $encryptkeys[$decrypid]['salt'];
                $pepperdecrypt =  $encryptkeys[$decrypid]['pepper'];
				$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
				}
				
                $physicalexamstype = $encaes->decrypt($obj->PPEX_PHYSICALEXAMSTYPE);
                $physicalexamsdetails = $encaes->decrypt($obj->PPEX_PHYSICALEXAMSDETAILS);

				$result.='<tr>
				<td>'.$num++.'</td>
				<td>'.$physicalexamstype.'</td>
				<td>'.$physicalexamsdetails.'</td>
				<td class="text-center valign-middle" width="100">
                <button class="btn btn-xs btn-danger square" type="button" onclick="deletePhysicalExams(\''.$obj->PPEX_ID.'\')"><i class="fa fa-close"></i>
				</button>
                </td>
				<tr>';
            }
           
        }else{
				$result.='<tr>
					<td colspan="4">No record found.</td>
				<tr>';
			}
		echo $result;
    }
}