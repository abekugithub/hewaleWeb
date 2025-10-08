<?php
include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
$engine = new engineClass();
$actorid = $engine->getActorCode();
$actorname = $engine->getActorName();
$actor = $engine->getActorDetails();
$activeinstitution = $actor->USR_FACICODE;
$dtcode=$engine->getdiagnosisCode();

if (!empty($keys)&&!empty($patientno)&&!empty($patientcode)&&!empty($patientname)&&!empty($remark)&&!empty($diagnosis)){
$diagnose=explode('@@',$diagnosis);
$keycode=explode('@@',$keys);

$stmtdata = $sql->Execute($sql->Prepare("INSERT INTO hms_patient_diagnosis (DIA_CODE, DIA_VISITCODE,DIA_DATE,DIA_PATIENTNUM,DIA_PATIENTCODE, DIA_DIA,DIA_DIAGNOSIS,DIA_RMK,DIA_INSTCODE,DIA_ACTORNAME,DIA_ACTORCODE,DIA_ENCRYPKEY,DIA_STATUS)VALUES(".$sql->Param('a').",".$sql->Param('b').", ".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('k').",".$sql->Param('l').",".$sql->Param('m').",".$sql->Param('n').")"),array($dtcode,$keycode[1],date('Y-m-d'),$patientno,$patientcode,$encaes->encrypt($diagnose[0]),$encaes->encrypt($diagnose[1]),$encaes->encrypt($remark),$activeinstitution,$actorname,$actorid,'1','1'));
        print $sql->ErrorMsg();
            $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_diagnosis WHERE DIA_VISITCODE = ".$sql->Param('l')." AND DIA_PATIENTNUM = ".$sql->Param('a')." AND DIA_STATUS='1' AND date_format(DIS_INPUTEDDATE,'%Y-%m-%d')=".$sql->Param('a').""),array($keycode[1],$patientno,date('Y-m-d')));

            while($obj=$stmt->FetchNextObject()){

                $results.= '
                                    <tr>
                                      
                                       <td>'.$encaes->decrypt($obj->DIA_DIAGNOSIS).'</td>
                                       <td>'.$encaes->decrypt($obj->DIA_RMK).'</td>
                                       <td class="text-center valign-middle" width="100">
                                       <button class="btn btn-xs btn-danger square" type="button"
							onclick="deletediagnose(\''.$obj->DIA_ID.'\')">
							<i class="fa fa-close"></i>
						</button>
                                       </td>
                                    </tr> ';

            }
            echo $results;
        
   $msg = 'Patient Diagnosis has been captured Successfully.';
	    $status = "success";
		
        $activity = "Patient Diagnosis captured Successfully.";
	 $engine->setEventLog("067",$activity);
    }else{
    $msg = "All fields required";
    $status = "error";
		}

echo json_encode($msg);
