<?php
include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
$engine = new engineClass();

if (!empty($keys) && !empty($visitcode)){
	//$key_code=explode('@@',$keycode);
   $stmt = $sql->Execute($sql->Prepare("Delete From hmis_treatment_sheet  WHERE TR_ID = ".$sql->Param('a').""), array($keys));
        print $sql->ErrorMsg();

 $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hmis_treatment_sheet WHERE TR_VISITCODE = ".$sql->Param('a')."AND TR_CURDATE=".$sql->Param('a').""),array($visitcode,date('Y-m-d')));
if($stmt->RecordCount() > 0){
            while($obj=$stmt->FetchNextObject()){

                $results.= '
                                     <tr>
                                      <td>'.$obj->TR_DT.'</td>
                                       <td>'.$obj->TR_TIME.'</td>
									   <td>'.$encaes->decrypt($obj->TR_DRUG).'</td>
									   <td>'.$obj->TR_QTY.'</td>
                                       <td class="text-center valign-middle" width="100">
                                       <button class="btn btn-xs btn-danger square" type="button"
							onclick="deletedata(\''.$obj->TR_ID.'\')">
							<i class="fa fa-close"></i>
						</button>
                                       </td>
                                    </tr> ';

            }}
            echo $results;
        
       $msg = 'Treatment has been removed Successfully.';
	    $status = "success";
		
        $activity = "Treatment removed Successfully.";
	 $engine->setEventLog("079",$activity);
    }else{
    $msg = "All fields required";
    $status = "error";
		}

//echo json_encode($msg);