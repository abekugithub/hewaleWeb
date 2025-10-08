<?php
include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
$engine = new engineClass();

if (!empty($keys) && !empty($visitcode)){
	//$key_code=explode('@@',$keycode);
   $stmt = $sql->Execute($sql->Prepare("Delete From hmis_daily_fluidoutput  WHERE DFO_ID = ".$sql->Param('a').""), array($keys));
        print $sql->ErrorMsg();

 $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hmis_daily_fluidoutput WHERE DFO_VISITCODE = ".$sql->Param('a')." AND DFO_CURDATE=".$sql->Param('a').""),array($visitcode,date('Y-m-d')));
if($stmt->RecordCount() > 0){
            while($obj=$stmt->FetchNextObject()){

                $results.= '
                                     <tr>
                                      <td>'.$obj->DFO_DATE.'</td>
                                       <td>'.$obj->DFO_TIME.'</td>
									   <td>'.$obj->DFO_MIS.'</td>
									   <td>'.$obj->DFO_OUTPUTNAME.'</td>
                                       <td class="text-center valign-middle" width="100">
                                       <button class="btn btn-xs btn-danger square" type="button"
							onclick="deletefluidout(\''.$obj->DFO_ID.'\')">
							<i class="fa fa-close"></i>
						</button>
                                       </td>
                                    </tr> ';

            }}
            echo $results;
        
       $msg = 'Daily fluid output has been removed Successfully.';
	    $status = "success";
		
        $activity = "Daily fluid output removed Successfully.";
	 $engine->setEventLog("084",$activity);
    }else{
    $msg = "All fields required";
    $status = "error";
		}

//echo json_encode($msg);