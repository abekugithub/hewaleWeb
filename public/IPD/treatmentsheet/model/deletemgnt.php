<?php
include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
$engine = new engineClass();
if (!empty($keys) && !empty($visitcode)){
	

  $stmt = $sql->Execute($sql->Prepare("Delete From hms_patient_management  WHERE PM_ID = ".$sql->Param('a').""), array($keys));
        print $sql->ErrorMsg();
 $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_management WHERE PM_VISITCODE = ".$sql->Param('l')." AND PM_DATE= ".$sql->Param('2').""),array($visitcode,date('Y-m-d')));
if($stmt->RecordCount() > 0){

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
			
			
			
			}
            echo $results;
        
       $msg = 'Patient Management has been removed Successfully.';
	    $status = "success";
		
        $activity = "Patient Management removed Successfully.";
	 $engine->setEventLog("072",$activity);
    }else{
    $msg = "All fields required";
    $status = "error";
		}

//echo json_encode($msg);