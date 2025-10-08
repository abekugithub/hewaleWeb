<?php
include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
$engine = new engineClass();

if (!empty($keys) && !empty($visitcode)){
	//$key_code=explode('@@',$keycode);
   $stmt = $sql->Execute($sql->Prepare("Delete From hmis_nursenote  WHERE MED_ID = ".$sql->Param('a').""), array($keys));
        print $sql->ErrorMsg();

 $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hmis_nursenote WHERE MED_VISITCODE = ".$sql->Param('a')."AND MED_CURDATE=".$sql->Param('a').""),array($visitcode,date('Y-m-d')));
if($stmt->RecordCount() > 0){
            while($obj=$stmt->FetchNextObject()){

                $results.= '
                                     <tr>
                                      
                                       <td>'.$obj->MED_DATE.'</td>
                                       <td>'.$obj->MED_TIME.'</td>
									   <td>'.$obj->MED_NOTE.'</td>
                                       <td class="text-center valign-middle" width="100">
                                       <button class="btn btn-xs btn-danger square" type="button"
							onclick="deletenote(\''.$obj->MED_ID.'\')">
							<i class="fa fa-close"></i>
						</button>
                                       </td>
                                    </tr> ';

            }}
            echo $results;
        
       $msg = 'Nurse Note has been removed Successfully.';
	    $status = "success";
		
        $activity = "Nurse Note removed Successfully.";
	 $engine->setEventLog("077",$activity);
    }else{
    $msg = "All fields required";
    $status = "error";
		}

//echo json_encode($msg);