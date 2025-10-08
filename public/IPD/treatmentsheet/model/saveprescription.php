<?php
include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
$engine = new engineClass();
$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();
$actor = $engine->getActorDetails();
$activeinstitution = $actor->USR_FACICODE;
echo $patientname."pppppppp";
if (!empty($keys)&&!empty($patientno)&&!empty($patientcode)&&!empty($patientname)&&!empty($drug)){
$drug=explode('@@',$drug);
    $drugname = $encaes->encrypt($drug[1]);
	$drugcode = $encaes->encrypt($drug[0]);
    $precode = $engine->getprescriptionCode();
    $qty = $frequency * $days * $times;
	$keyscode=explode('@@',$keys);

 $stmtpresc = $sql->Execute($sql->Prepare("INSERT INTO hms_patient_prescription (PRESC_CODE,PRESC_PATIENT,PRESC_PATIENTNUM,PRESC_DATE,PRESC_VISITCODE,PRESC_DRUGID,PRESC_DRUG,PRESC_QUANTITY,PRESC_DOSAGENAME,PRESC_DOSAGECODE,PRESC_FREQ,PRESC_DAYS,PRESC_TIMES,PRESC_ACTORNAME,PRESC_ACTORCODE,PRESC_INSTCODE,PRESC_PATIENTCODE,PRESC_ENCRYPKEY) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('14').",".$sql->Param('15').",".$sql->Param('16').",".$sql->Param('16').",".$sql->Param('17').")"),
            array($precode,$patientname,$patientno,date('Y-m-d'),$keyscode[1],$drugcode,$drugname,$qty,$drug[2],$drug[3],$frequency,$days,$times,$usrname,$usrcode,$activeinstitution,$patientcode,'1'));
        print $sql->ErrorMsg();

          $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_prescription WHERE PRESC_STATUS='1' AND PRESC_VISITCODE=".$sql->Param('a')." AND (PRESC_PATIENTNUM=".$sql->Param('b')." OR PRESC_PATIENTCODE=".$sql->Param('b').") ORDER BY PRESC_ID DESC"),array($keyscode[1],$patientno,$patientcode));
        print $sql->ErrorMsg();
            while($obj=$stmt->FetchNextObject()){

                $results.= '
                                    <tr>
                                      
                                       <td>'.$encaes->decrypt($obj->PRESC_DRUG).'</td>
                                       <td>'.$obj->PRESC_DAYS.'</td>
									   <td>'.$obj->PRESC_FREQ.'</td>
									   <td>'.$obj->PRESC_TIMES.'</td>
                                       
                                       <td class="text-center valign-middle" width="100">
                                       <button class="btn btn-xs btn-danger square" type="button"
							onclick="deletedrug(\''.$obj->PRESC_ID.'\')">
							<i class="fa fa-close"></i>
						</button>
                                       </td>
                                    </tr> ';

            }
            echo $results;
        
   $msg = 'Patient Prescription has been captured Successfully.';
   $status = "success";
		
        $activity = "Patient Prescription captured Successfully.";
	 $engine->setEventLog("069",$activity);
    }else{
    $msg = "All fields required";
    $status = "error";
		}

echo json_encode($msg);
