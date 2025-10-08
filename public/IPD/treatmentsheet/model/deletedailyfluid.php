<?php
include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
$engine = new engineClass();

if (!empty($keys) && !empty($visitcode)){
	//$key_code=explode('@@',$keycode);
   $stmt = $sql->Execute($sql->Prepare("Delete From hmis_daily_fluid  WHERE DF_ID = ".$sql->Param('a').""), array($keys));
        print $sql->ErrorMsg();

 $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hmis_daily_fluid WHERE DF_VISITCODE = ".$sql->Param('a')." AND DF_CURDATE=".$sql->Param('a').""),array($visitcode,date('Y-m-d')));
if($stmt->RecordCount() > 0){
            while($obj=$stmt->FetchNextObject()){

                $results.= '
                                     <tr>
                                      <td>'.$obj->DF_DATE.'</td>
                                       <td>'.$obj->DF_TIME.'</td>
									   <td>'.$obj->DF_NAME.'</td>
									   <td>'.$obj->DF_ROUTE.'</td>
									   <td>'.$obj->DF_FLUID_AMT.'</td>
									   <td>'.$obj->DF_MIS.'</td>
									   <td>'.$obj->DF_METHODNAME.'</td>
                                       <td class="text-center valign-middle" width="100">
                                       <button class="btn btn-xs btn-danger square" type="button"
							onclick="deletefluid(\''.$obj->FD_ID.'\')">
							<i class="fa fa-close"></i>
						</button>
                                       </td>
                                    </tr> ';

            }}
            echo $results;
        
       $msg = 'Daily fluid has been removed Successfully.';
	    $status = "success";
		
        $activity = "Daily fluid removed Successfully.";
	 $engine->setEventLog("081",$activity);
    }else{
    $msg = "All fields required";
    $status = "error";
		}

//echo json_encode($msg);