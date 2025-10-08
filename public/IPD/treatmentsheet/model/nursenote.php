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
if (!empty($time)&&!empty($patientno)&&!empty($nursnote)&&!empty($notedate)){
$notecode=$engine->getnursenotecode();
 $notedate = $engine->getDate_Format($notedate);

$stmtdata = $sql->Execute($sql->Prepare("INSERT INTO hmis_nursenote (MED_CODE, MED_CURDATE,MED_PATIENTNUM,MED_NOTE, MED_DATE,MED_TIME,MED_TYPE,MED_ACTOR,MED_ACTORNAME,MED_VISITCODE,MED_INSTCODE)VALUES(".$sql->Param('a').",".$sql->Param('b').", ".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('k').")"),array($notecode,date('Y-m-d'),$patientno,$nursnote,$notedate,$time,$usertype,$usrcode,$usrname,$visitcode,$activeinstitution));
        print $sql->ErrorMsg();
		
            $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hmis_nursenote WHERE MED_VISITCODE = ".$sql->Param('l')." AND MED_PATIENTNUM = ".$sql->Param('a')." AND MED_STATUS='1' AND MED_DATE=".$sql->Param('a').""),array($visitcode,$patientno,date('Y-m-d')));

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

            }
            echo $results;
        
   $msg = 'Nurse Note has been captured Successfully.';
	    $status = "success";
		
        $activity = "Nurse Note captured Successfully.";
	 $engine->setEventLog("076",$activity);
    }else{
    $msg = "All fields required";
    $status = "error";
		}

echo json_encode($msg);
