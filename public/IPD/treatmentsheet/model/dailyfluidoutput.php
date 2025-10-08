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
 $outdate = $engine->getDate_Format($outdate);

if (!empty($outdate)&&!empty($outtime)&&!empty($misout)&&!empty($outputfluid)){
$dfluidcode=$engine->getfluidoutputcode();
$fluid=explode('@@@',$outputfluid);
$stmtdata = $sql->Execute($sql->Prepare("INSERT INTO hmis_daily_fluidoutput(DFO_CODE, DFO_VISITCODE,DFO_PATIENTNUM, DFO_DATE,DFO_CURDATE,DFO_MIS,DFO_TIME,DFO_OUTPUT,DFO_OUTPUTNAME,DFO_AGE,DFO_WARDID,DFO_WARD,DFO_BEDID,DFO_BED,DFO_INSTCODE,DFO_USERCODE,DFO_USERFULLNAME)VALUES(".$sql->Param('a').",".$sql->Param('b').", ".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('k').",".$sql->Param('a').",".$sql->Param('b').", ".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').")"),array($dfluidcode,$visitcode,$patientno,$outdate,date('Y-m-d'),$misout,$outtime,$fluid[0],$fluid[1],$age,$wardid,$wardname,$bedid,$bedname,$activeinstitution,$usrcode,$usrname));
        print $sql->ErrorMsg();
		
            $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hmis_daily_fluidoutput WHERE DFO_VISITCODE = ".$sql->Param('l')." AND DFO_PATIENTNUM = ".$sql->Param('a')." AND DFO_STATUS='1' AND DFO_CURDATE=".$sql->Param('a').""),array($visitcode,$patientno,date('Y-m-d')));

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

            }
            echo $results;
        
   $msg = 'Daily fluid output has been captured Successfully.';
	    $status = "success";
		
        $activity = "Daily fluid output captured Successfully.";
	 $engine->setEventLog("084",$activity);
    }else{
    $msg = "All fields required";
    $status = "error";
		}

echo json_encode($msg);
