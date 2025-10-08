<?php
include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
$engine = new engineClass();

if (!empty($keys) && !empty($visitcode)){
	$key_code=explode('@@',$keycode);
  $stmt = $sql->Execute($sql->Prepare("Delete From hms_patient_diagnosis  WHERE DIA_ID = ".$sql->Param('a').""), array($keys));
        print $sql->ErrorMsg();
 $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_diagnosis WHERE DIA_VISITCODE = ".$sql->Param('l')." AND DIA_STATUS='1' AND date_format(DIS_INPUTEDDATE,'%Y-%m-%d')=".$sql->Param('a')." "),array($visitcode,date('Y-m-d')));
if($stmt->RecordCount() > 0){

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
			
			
			
			}
            echo $results;
        
       $msg = 'Patient Diagnosis has been removed Successfully.';
	    $status = "success";
		
        $activity = "Patient Diagnosis removed Successfully.";
	 $engine->setEventLog("068",$activity);
    }else{
    $msg = "All fields required";
    $status = "error";
		}

//echo json_encode($msg);