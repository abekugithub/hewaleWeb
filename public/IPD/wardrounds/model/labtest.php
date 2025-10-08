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
//echo $patient."alaga";
if (!empty($keys)&&!empty($patientno)&&!empty($patientcode)&&!empty($patient)&&!empty($labtest)){
$lbtest=explode('@@',$labtest);
$spmem=explode('@@',$specimen);
$keyscode=explode('@@',$keys);
$ltcode=$engine->getlabtestCode();

$stmtdata = $sql->Execute($sql->Prepare("INSERT INTO hms_patient_labtest (LT_CODE, LT_VISITCODE,LT_DATE, LT_PATIENTNUM,LT_PATIENTCODE,LT_PATIENTNAME,LT_TEST,LT_TESTNAME,LT_SPECIMENCODE,LT_SPECIMEN,LT_SPECIMENDATE,LT_SPECIMENLABEL,LT_SPECIMENVOLUME,LT_ACTORCODE,LT_ACTORNAME,LT_INSTCODE,LT_STATUS,LT_LABCODE)VALUES(".$sql->Param('a').",".$sql->Param('b').", ".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('k').",".$sql->Param('l').",".$sql->Param('m').",".$sql->Param('m').",".$sql->Param('k').",".$sql->Param('l').",".$sql->Param('l').",".$sql->Param('l').",".$sql->Param('l').")"),array($ltcode,$keyscode[1],date('Y-m-d'),$patientno,$patientcode,$patient,$encaes->encrypt($lbtest[0]),$encaes->encrypt($lbtest[1]),$encaes->encrypt($spmem[0]),$encaes->encrypt($spmem[1]),date('Y-m-d'),$label,$vol,$actorid,$actorname,$activeinstitution,'3',$activeinstitution));
        print $sql->ErrorMsg();

            $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_VISITCODE = ".$sql->Param('l')." AND LT_PATIENTNUM = ".$sql->Param('a')." AND LT_STATUS='3' AND LT_DATE=".$sql->Param('a').""),array($keyscode[1],$patientno,date('Y-m-d')));

            while($obj=$stmt->FetchNextObject()){

                $results.= '
                                    <tr>
                                      
                                       <td>'.$encaes->decrypt($obj->LT_TESTNAME).'</td>
                                       <td>'.$encaes->decrypt($obj->LT_SPECIMEN).'</td>
									   <td>'.$obj->LT_SPECIMENLABEL.'</td>
									   <td>'.$obj->LT_SPECIMENVOLUME.'</td>
                                       
                                       <td class="text-center valign-middle" width="100">
                                       <button class="btn btn-xs btn-danger square" type="button"
							onclick="deletetest(\''.$obj->LT_ID.'\')">
							<i class="fa fa-close"></i>
						</button>
                                       </td>
                                    </tr> ';

            }
            echo $results;
        
   $msg = 'Patient Lab has been captured Successfully.';
	    $status = "success";
		
        $activity = "Patient Specimen captured Successfully.";
	 $engine->setEventLog("065",$activity);
    }else{
    $msg = "All fields required";
    $status = "error";
		}

echo json_encode($msg);
