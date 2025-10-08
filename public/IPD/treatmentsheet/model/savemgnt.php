<?php
include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
include SPATH_LIBRARIES.DS."doctors.Class.php";

$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
$engine = new engineClass();
$doc = new doctorClass();
$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();
$actor = $engine->getActorDetails();
$activeinstitution = $actor->USR_FACICODE;

if (!empty($keys)&&!empty($patientno)&&!empty($patientcode)&&!empty($patientname)&&!empty($mgnt)){
    $managementcode = $doc->getManagementCode();
    $keyscode=explode('@@',$keys);
$stmtman = $sql->Execute($sql->Prepare("INSERT INTO hms_patient_management (PM_MANAGEMENT,PM_CODE,PM_DATE,PM_PATIENTNUM,PM_VISITCODE,PM_INSTCODE,PM_ACTORNAME,PM_ACTORCODE,PM_ENCRYPKEY,PM_STATUS) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').")"),array($encaes->encrypt($mgnt),$managementcode,date('Y-m-d'),$patientno,$keyscode[1],$activeinstitution,$usrname,$usrcode,$encryptkey,'1'));
        print $sql->ErrorMsg();
            $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_management WHERE PM_VISITCODE = ".$sql->Param('l')." AND PM_PATIENTNUM = ".$sql->Param('a')." AND PM_STATUS='1' AND PM_DATE= ".$sql->Param('2').""),array($keyscode[1],$patientno,date('Y-m-d')));

            while($obj=$stmt->FetchNextObject()){

                $results.= '
                                    <tr>
                                      
                                       <td>'.$encaes->decrypt($obj->PM_MANAGEMENT).'</td>
                                       
                                       <td class="text-center valign-middle" width="100">
                                       <button class="btn btn-xs btn-danger square" type="button"
							onclick="deletemgnt(\''.$obj->PM_ID.'\')">
							<i class="fa fa-close"></i>
						</button>
                                       </td>
                                    </tr> ';

            }
            echo $results;
        
   $msg = 'Patient Managemenet has been captured Successfully.';
	    $status = "success";
		
        $activity = "Patient Managemenet captured Successfully.";
	 $engine->setEventLog("071",$activity);
    }else{
    $msg = "All fields required";
    $status = "error";
		}

echo json_encode($msg);
