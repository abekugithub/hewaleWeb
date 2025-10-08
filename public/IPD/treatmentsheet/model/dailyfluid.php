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
 $fdate = $engine->getDate_Format($fdate);

if (!empty($route)&&!empty($famount)&&!empty($fmis)&&!empty($flmethod) && !empty($fluidtype)&&!empty($fdate)&&!empty($ftime)&&!empty($fdname)){
$dfluidcode=$engine->getfluiddailycode();
$method=explode('@@@',$flmethod);
$stmtdata = $sql->Execute($sql->Prepare("INSERT INTO hmis_daily_fluid(DF_CODE, DF_VISITCODE,DF_NAME, DF_DATE,DF_CURDATE,DF_PATIENTNUM,DF_CATEGORY,DF_METHOD,DF_METHODNAME,DF_FLUID_TYPE,DF_FLUID_AMT,DF_ROUTE,DF_TIME,DF_MIS,DF_TYPE,DF_AGE,DF_WARDID,DF_WARD,DF_BEDID,DF_BED,DF_TIMEINTAKE,DT_DTINTAKE,DT_BYINTAKE,DT_BYCODEINTAKE,DF_OUTPUT,DF_INSTCODE,DF_USERCODE,DF_USERFULLNAME)VALUES(".$sql->Param('a').",".$sql->Param('b').", ".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('k').",".$sql->Param('a').",".$sql->Param('b').", ".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('a').",".$sql->Param('b').", ".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').")"),array($dfluidcode,$visitcode,$fdname,$fdate,date('Y-m-d'),$patientno,'1',$method[0],$method[1],$fluidtype,$famount,$route,$ftime,$fmis,$usertype,$age,$wardid,$wardname,$bedid,$bedname,$timeintake,$dtintake,$byintake,$bycodeintake,$fluidoutput,$activeinstitution,$usrcode,$usrname));
        print $sql->ErrorMsg();
		
            $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hmis_daily_fluid WHERE DF_VISITCODE = ".$sql->Param('l')." AND DF_PATIENTNUM = ".$sql->Param('a')." AND DF_STATUS='1' AND DF_CURDATE=".$sql->Param('a').""),array($visitcode,$patientno,date('Y-m-d')));

            while($obj=$stmt->FetchNextObject()){

                $results.= '
                                    <tr>
                                      
                                       <td>'.$obj->DF_DATE.'</td>
                                       <td>'.$obj->DF_TIME.'</td>
									   <td>'.$obj->DF_NAME.'</td>
									   <td>'.$obj->DF_ROUTE.'</td>
									    <td>'.$obj->DF_FLUID_TYPE.'</td>
									   <td>'.$obj->DF_FLUID_AMT.'</td>
									   <td>'.$obj->DF_MIS.'</td>
									   <td>'.$obj->DF_METHODNAME.'</td>
                                       <td class="text-center valign-middle" width="100">
                                       <button class="btn btn-xs btn-danger square" type="button"
							onclick="deletefluid(\''.$obj->DF_ID.'\')">
							<i class="fa fa-close"></i>
						</button>
                                       </td>
                                    </tr> ';

            }
            echo $results;
        
   $msg = 'Daily fluid has been captured Successfully.';
	    $status = "success";
		
        $activity = "Daily fluid captured Successfully.";
	 $engine->setEventLog("080",$activity);
    }else{
    $msg = "All fields required";
    $status = "error";
		}

echo json_encode($msg);
