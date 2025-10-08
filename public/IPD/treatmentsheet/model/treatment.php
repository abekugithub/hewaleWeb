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
if (!empty($trsdate)&&!empty($trtime)&&!empty($drug)&&!empty($quantity)){
$treatcode=$engine->getTreatmentcode();
$drugs=explode('@@',$drug);
 $trsdate = $engine->getDate_Format($trsdate);

$stmtdata = $sql->Execute($sql->Prepare("INSERT INTO hmis_treatment_sheet(TR_CODE, TR_CURDATE,TR_PATIENTNUM,TR_PATIENT, TR_VISITCODE,TR_DRUGID,TR_DRUG,TR_DOSAGE,TR_DOSAGENAME,TR_TIME,TR_QTY,TR_TYPE,TR_DT,TR_WARDID,TR_WARD,TR_BEDID,TR_BED,TR_INSTCODE,TR_USERCODE,TR_USERFULLNAME)VALUES(".$sql->Param('a').",".$sql->Param('b').", ".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('k').",".$sql->Param('a').",".$sql->Param('b').", ".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('h').",".$sql->Param('i').")"),array($treatcode,date('Y-m-d'),$patientno,$patientname,$visitcode,$drugs[0],$encaes->encrypt($drugs[1]),$encaes->encrypt($drugs[2]),$drugs[3],$trtime,$quantity,$usertype,$trsdate,$wardid,$wardname,$bedid,$bedname,$activeinstitution,$usrcode,$usrname));
        print $sql->ErrorMsg();
		
            $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hmis_treatment_sheet WHERE TR_VISITCODE = ".$sql->Param('l')." AND TR_PATIENTNUM = ".$sql->Param('a')." AND TR_STATUS='1' AND TR_DT=".$sql->Param('a').""),array($visitcode,$patientno,$trsdate));

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

            }
            echo $results;
        
   $msg = 'Treatment has been captured Successfully.';
	    $status = "success";
		
        $activity = "Treatment captured Successfully.";
	 $engine->setEventLog("078",$activity);
    }else{
    $msg = "All fields required";
    $status = "error";
		}

echo json_encode($msg);
