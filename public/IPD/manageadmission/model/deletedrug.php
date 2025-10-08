<?php
include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
$engine = new engineClass();
echo "ollll".$visitcode;
if (!empty($keys) && !empty($visitcode)){
	//$key_code=explode('@@',$keycode);

  $stmt = $sql->Execute($sql->Prepare("Delete From hms_patient_prescription  WHERE PRESC_ID = ".$sql->Param('a').""), array($keys));
        print $sql->ErrorMsg();
 $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_prescription WHERE PRESC_VISITCODE = ".$sql->Param('l')." AND date_format(PRESC_DATE,'%Y-%m-%d')  = ".$sql->Param('2')." "),array($visitcode,date('Y-m-d')));
if($stmt->RecordCount() > 0){

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
			
			
			
			}
            echo $results;
        
       $msg = 'Patient Prescription has been removed Successfully.';
	    $status = "success";
		
        $activity = "Patient Prescription removed Successfully.";
	 $engine->setEventLog("070",$activity);
    }else{
    $msg = "All fields required";
    $status = "error";
		}

//echo json_encode($msg);