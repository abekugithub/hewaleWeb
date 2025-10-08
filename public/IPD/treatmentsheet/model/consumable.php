<?php
include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
include SPATH_LIBRARIES.DS."doctors.Class.php";

$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
$engine = new engineClass();
$doc = new doctorClass();
$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();
$actor = $engine->getActorDetails();
$activeinstitution = $actor->USR_FACICODE;
$usertype=$actor->USR_TYPE;
 $csdate = $engine->getDate_Format($csdate);
  
if (!empty($csconsume)&&!empty($csdate)&&!empty($csqty)){
$cscode=$engine->getConsumecode();
$consumable=explode('@@@',$csconsume);
$stmtdata = $sql->Execute($sql->Prepare("INSERT INTO hmis_consumable_used(CSU_CODE, CSU_VISITCODE,CSU_PATIENTNUM, CSU_DATE,CSU_CURDATE,CSU_ITEMCODE,CSU_ITEMNAME,CSU_QTY,CSU_INSTCODE,CSU_USERCODE,CSU_USERFULLNAME)VALUES(".$sql->Param('a').",".$sql->Param('b').", ".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('k').",".$sql->Param('a').")"),array($cscode,$visitcode,$patientno,$csdate,date('Y-m-d'),$consumable[0],$consumable[1],$csqty,$activeinstitution,$usrcode,$usrname));
        print $sql->ErrorMsg();
		
            $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hmis_consumable_used WHERE CSU_VISITCODE = ".$sql->Param('l')." AND CSU_PATIENTNUM = ".$sql->Param('a')." AND CSU_STATUS='1' AND CSU_CURDATE=".$sql->Param('a').""),array($visitcode,$patientno,date('Y-m-d')));

            while($obj=$stmt->FetchNextObject()){

                $results.= '
                                    <tr>
                                       <td>'.$obj->CSU_DATE.'</td>
                                       <td>'.$obj->CSU_ITEMNAME.'</td>
									   <td>'.$obj->CSU_QTY.'</td>
                                       <td class="text-center valign-middle" width="100">
                                       <button class="btn btn-xs btn-danger square" type="button"
							onclick="deleteconsume(\''.$obj->CSU_ID.'\')">
							<i class="fa fa-close"></i>
						</button>
                                       </td>
                                    </tr> ';

            }
            echo $results;
        
   $msg = 'Consumable used has been captured Successfully.';
	    $status = "success";
		
        $activity = "Consumable used captured Successfully.";
	 $engine->setEventLog("085",$activity);
    }else{
    $msg = "All fields required";
    $status = "error";
		}

echo json_encode($msg);
