<?php
include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
$engine = new engineClass();

if (!empty($keys) && !empty($visitcode)){
	//$key_code=explode('@@',$keycode);

  $stmt = $sql->Execute($sql->Prepare("Delete From hms_patient_complains  WHERE PC_ID = ".$sql->Param('a').""), array($keys));
        print $sql->ErrorMsg();
 $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_complains WHERE PC_VISITCODE = ".$sql->Param('l')." AND PC_DATE =".$sql->Param('c')." "),array($visitcode,date('Y-m-d')));
if($stmt->RecordCount() > 0){

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