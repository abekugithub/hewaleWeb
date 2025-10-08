<?php
include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
$engine = new engineClass();
$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();
$actor = $engine->getActorDetails();
$activeinstitution = $actor->USR_FACICODE;
//echo $getcomplains;
if (!empty($complain)&&!empty($copmlaincode)&&!empty($patientcode)&&!empty($patientno)&&!empty($keys)){
 $comcode = $engine->getcomplainCode();
 $keycode=explode('@@',$keys);
		
$stmtdata = $sql->Execute($sql->Prepare("INSERT INTO hms_patient_complains (PC_CODE,PC_PATIENTNUM,PC_VISITCODE,PC_DATE,PC_COMPLAINCODE,PC_COMPLAIN,PC_INSTCODE,PC_ACTORCODE,PC_ACTORNAME,PC_PATIENTCODE,PC_ENCRYPKEY) VALUES(".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('11').",".$sql->Param('12').")"), array($comcode,$patientno,$keycode[1],date('Y-m-d'),$encaes->encrypt($copmlaincode),$encaes->encrypt($complain),$activeinstitution,$usrcode,$usrname,$patientcode,$encryptkey));
        print $sql->ErrorMsg();
            $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_complains WHERE PC_STATUS='1' AND PC_VISITCODE=".$sql->Param('a')." AND PC_PATIENTNUM=".$sql->Param('b')." AND PC_DATE =".$sql->Param('c')." ORDER BY PC_ID DESC"),array($keycode[1],$patientno,date('Y-m-d')));

            while($obj=$stmt->FetchNextObject()){

                $results.= '
                                    <tr>
                                      
                                       <td>'.$encaes->decrypt($obj->PC_COMPLAIN).'</td>
                                       <td class="text-center valign-middle" width="100">
                                       <button class="btn btn-xs btn-danger square" type="button"
							onclick="deletecomplain(\''.$obj->PC_ID.'\')">
							<i class="fa fa-close"></i>
						</button>
                                       </td>
                                    </tr> ';

            }
            echo $results;
        
   $msg = 'Patient Complain has been captured Successfully.';
	    $status = "success";
		
        $activity = "Patient Complain captured Successfully.";
	 $engine->setEventLog("073",$activity);
    }else{
    $msg = "All fields required";
    $status = "error";
		}

echo json_encode($msg);
