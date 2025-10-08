<?php
include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
$engine = new engineClass();

if (!empty($keys) && !empty($visitcode)){
	//$key_code=explode('@@',$keycode);
   $stmt = $sql->Execute($sql->Prepare("Delete From hms_patient_labtest  WHERE LT_ID = ".$sql->Param('a').""), array($keys));
        print $sql->ErrorMsg();

 $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_VISITCODE = ".$sql->Param('a')."AND LT_DATE=".$sql->Param('a').""),array($visitcode,date('Y-m-d')));
if($stmt->RecordCount() > 0){
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

            }}
            echo $results;
        
       $msg = 'Patient Lab has been removed Successfully.';
	    $status = "success";
		
        $activity = "Patient Specimen removed Successfully.";
	 $engine->setEventLog("066",$activity);
    }else{
    $msg = "All fields required";
    $status = "error";
		}

//echo json_encode($msg);