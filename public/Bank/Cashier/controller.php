<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 9/18/2017
 * Time: 4:36 PM
 */
//print_r($_POST);
$actorid = $session->get("userid");
$actorname = $engine->getActorName();
$usrcode = $engine->getUserCode();
$patientCls = new patientClass();
$sms = new smsgetway();
$import = new importClass();
$faccode = $engine->getActorDetails()->USR_FACICODE;
$crtdate= date("Y-m-d H:m:s");

switch ($viewpage){
 /*
    case "details11":
        $stmt = $sql->Execute($sql->Prepare("SELECT * from hms_visit WHERE VISIT_INDEXNUM = {$sql->Param('a')}"),
            [$keys]);
        $detail=$stmt->FetchNextObject();
         //  echo $detail->VISIT_INDEXNUM;

        $stmtitems = $sql->Execute($sql->Prepare("SELECT * from hms_billitem ")) ;
        break;
*/
    
	case "tdetails":
	$stmt = $sql->Execute($sql->Prepare("SELECT * from hms_visit JOIN hms_billitem on VISIT_CODE=B_VISITCODE WHERE B_VISITCODE = {$sql->Param('a')}"),
    [$keys]);
		$detail=$stmt->FetchNextObject();
		$visitcode= $detail->B_VISITCODE;
		$nam = $detail->VISIT_PATIENT;
		$dat=$detail->VISIT_DATE;
		$p_num=$detail->VISIT_PATIENTNUM;
		$v_code=$detail->VISIT_CODE;
		$v_cash=$detail-> VISIT_CASHAMT;
		$v_altamt= $detail->VISIT_ALTAMT;
		$v_mde= $detail->B_PAYSCHEMENAME;
		$v_tot=$detail->B_TOTAMT;

	break;

	case "savepay":
      //0508921365
        $duplicatekeeper = $session->get("post_key");
        if($microtime != $duplicatekeeper) {
            $session->set("post_key", $microtime);

            if ( !isset($_POST['chkitems'])) {
                $msg = "please select item(s) to pay";
                $status = "error";
                $views = 'details';

        } elseif (!empty($description) || !empty($tamount2) || !empty($startdate)) {
			
                $stmtsums = $sql->Execute($sql->Prepare("SELECT * FROM hms_billitem join hms_visit on VISIT_CODE = B_VISITCODE WHERE B_VISITCODE={$sql->Param('a')}"), array($keys));
                print $sql->ErrorMsg();
                if ($stmtsums->RecordCount() > 0) {
                    $objsum = $stmtsums->FetchNextObject();
                  //  $tamount = '';
                   // $description =  $v_tot "";
				   
				   $servcode = $objsum->B_SERVCODE ; 
				   $visitcode = $objsum->B_VISITCODE ; 
				   $dpt = $objsum->B_DPT ; 

                }
                if ($tamount > $amtpaid) {
                    $msg = "Failed. Amount paid Cannot be less than Total amount!.";
                    $status = "error";
                    $views = 'details';
                } else {
                    $balance = $amtpaid - $tamount;
                    $impstring = "'".implode("','",$_POST['chkitems'])."'";
                  // echo $balance.'kokonte';
                    $rcode = $engine->getreciptcode();
                    $dts = date("Y-m-d",strtotime(str_replace('/','-',$startdate)));
                    $sql->Execute("INSERT INTO  hms_reciept (BP_CODE,BP_DATE,BP_PATIENTCODE,BP_PATIENT,BP_DESC,BP_VISITCODE,BP_TOTAL,BP_AMTPAID,BP_CHANGE,BP_BALANCE,BP_ACTOR,BP_USER,BP_INSTCODE) VALUES ({$sql->Param('a')},{$sql->Param('a')},{$sql->Param('a')},{$sql->Param('a')},{$sql->Param('a')},{$sql->Param('a')},{$sql->Param('a')},{$sql->Param('a')},{$sql->Param('a')},{$sql->Param('a')},{$sql->Param('a')},{$sql->Param('a')},{$sql->Param('a')})",[$rcode,$dts,$p_num,$nam,$description,$v_code,$v_tot,$amtpaid,$balance,$balance,$usrcode,$actorname,$faccode]);


                        $sql->Execute("UPDATE hms_billitem SET
							B_STATUS= {$sql->Param('1')},
							B_STATE= {$sql->Param('2')},
							B_PAYDATE= {$sql->Param('3')},
							B_PAYUSERCODE = {$sql->Param('4')},
							B_PAYUSERFULLNAME ={$sql->Param('5')},
							 B_RECIPTNUM = {$sql->Param('5')}
							 WHERE B_CODE IN (({$impstring}))",
							 ['2','3',$dts,$usrcode,$actorname,$rcode]);


				$stmtvcash =  $sql->Execute($sql->Prepare("UPDATE hms_visit SET VISIT_CASHAMT = VISIT_CASHAMT - ".$sql->Param('1')." WHERE VISIT_CODE = {$sql->Param('2')} "),array($totalrate,$v_code));
                print $sql->ErrorMsg();
				
				$stmtd = $sql->Execute($sql->Prepare("UPDATE hms_service_request SET REQU_PAYSTATE = ".$sql->Param('1').", REQU_STATE = ".$sql->Param('2')." where REQU_CODE = ".$sql->Param('2')." and  REQU_VISITCODE = ".$sql->Param('2')." "), array('2','2',$servcode,$visitcode));
				print $sql->ErrorMsg();
				
				if($dpt == 'CONSULT'){
					
			//		$stmtd = $sql->Execute($sql->Prepare("UPDATE hms_consultation SET CONS_PAYSTATE = ".$sql->Param('1')." where CONS_REQUCODE = ".$sql->Param('2')." and  CONS_VISITCODE = ".$sql->Param('2')." "), array('2',$servcode,$visitcode));
					print $sql->ErrorMsg();
					
				}	

                    if ($stmtvcash == false){
                        $msg = "not paid!.";
                        $status = "error";
                        $views = 'details';
                    }

                        $msg = "Paid Successful!.";
                        $status = "success";
                        $views = '';

                }

            }
        }
        break;

		case "manage":

        $stmtpres = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_prescription WHERE PRESC_STATUS='1' AND PRESC_VISITCODE=".$sql->Param('a')." AND (PRESC_PATIENTNUM=".$sql->Param('b')." OR PRESC_PATIENTCODE=".$sql->Param('b').") ORDER BY PRESC_ID DESC"),array($visitcode,$patientnum,$patientcode));
        print $sql->ErrorMsg();

        $stmtitems = $sql->Execute($sql->Prepare("SELECT * from hms_billitem ")) ;

        $stmtlabs = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_STATUS IN ('1','6') AND LT_VISITCODE=".$sql->Param('a')." AND (LT_PATIENTNUM=".$sql->Param('b')." OR LT_PATIENTCODE=".$sql->Param('b').") ORDER BY LT_ID DESC"),array($visitcode,$patientnum,$patientcode));
        print $sql->ErrorMsg();

        $stmtdrugslov = $sql->Execute($sql->Prepare("SELECT * from hmsb_st_phdrugs order by DR_NAME ")) ;

        $stmttestlov = $sql->Execute($sql->Prepare("SELECT * from hmsb_st_labtest order by LTT_NAME ")) ;

        $stmtxray = $sql->Execute($sql->Prepare("SELECT * from hmsb_st_xray order by X_ID DESC ")) ;

        $stmtx = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_xraytest WHERE XT_STATUS IN ('1','6') AND XT_VISITCODE=".$sql->Param('a')." AND (XT_PATIENTNUM=".$sql->Param('b')." OR XT_PATIENTCODE=".$sql->Param('b').") ORDER BY XT_ID DESC"),array($visitcode,$patientnum,$patientcode));
        print $sql->ErrorMsg();

        break;
		
		
    case "vitals":
        /*
        $postkey = $session->get("postkey");
        if($postkey != $microtime){
        $session->set("postkey",$microtime);
        //DECODE THE JASON ARRAY
            $newdata = json_decode($data);
            $vitaldetcode = uniqid();
            if(is_array($newdata) && count($newdata) > 0){
            $stmtdata = $sql->Execute($sql->Prepare("INSERT INTO hms_emergency_vitals(VIT_VITALSTYPE, VIT_VITALSVALUE,VIT_VISITCODE,  VIT_DATEADDED, VIT_PATIENTCODE,VIT_PATIENTNUM,VIT_EMERCODE,VIT_FACICODE,VIT_ACTOR)VALUES(".$sql->Param('a').",".$sql->Param('b').", ".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').")"),$newdata);
            print $sql->ErrorMsg();
            if ($stmtdata==TRUE){
        $msg = "Patient Vitals has been captured Successfully.";
        $status = "success";
        $views ="add";
        $activity = "Patient Vitals captured Successfully.";
        $engine->setEventLog("013",$activity);
        $tablerowid =$session->get('tablerowid');
            }else{
        $msg = "Patient Vitals could not be captured.";
        $status = "error";
        $views ="add";


            }

            $engine->ClearNotification('0004',$tablerowid);
            }else{
        $msg = "Sorry! No Patient Vital captured.";
        $status = "error";

                }

        }
        */
        break;
		
		
		case "activities":
        $postkey = $session->get("postkey");
        if($postkey != $microtime){
            $session->set("postkey",$microtime);
            $stmt=$sql->Execute($sql->Prepare("INSERT INTO hms_emergency_activity(ACV_EMERCODE, ACV_VISITCODE,ACV_TRIAGE, ACV_PRESENT_CONDITION, ACV_BED, ACV_PATIENTNUM, ACV_PATIENTCODE, ACV_ACTOR, ACV_STATUS, ACV_FACICODE)VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('j').")"),array($v,$keys,$triage,$condition,$availablebed,$patientnum,$patkey,$actorname,'1',$faccode));
            if ($stmt==TRUE){
                $msg = "Patient activities have been captured Successfully.";
                $status = "success";
                $views='add';
            }else{
                $msg = "Patient activities could not be captured, please try again.";
                $status = "error";
                $view='add';
            }
        }
        break;
		
		
		case "consumables":
        $postkey = $session->get("postkey");
        if($postkey != $microtime){
            $session->set("postkey",$microtime);
            $stmt=$sql->Execute($sql->Prepare("INSERT INTO hms_emergency_consumables(CON_EMERCODE, CON_VISITCODE,CON_ITEMNAME, CON_QUANTITY,CON_PATIENTNUM,CON_PATIENTCODE,CON_ACTOR,CON_STATUS, CON_FACICODE)VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').")"),array($v,$keys,$product,$quantity,$patientnum,$patkey,$actorname,'1',$faccode));
            if ($stmt==TRUE){
                $msg = "Patient consumable have been captured Successfully.";
                $status = "success";
                $views='add';
            }else{
                $msg = "Patient consumable could not be captured, please try again.";
                $status = "success";
                $views='add';
            }
        }
        break;
}

$stmt = $sql->Execute($sql->Prepare("SELECT * from hms_visit JOIN hms_billitem on VISIT_CODE=B_VISITCODE WHERE B_VISITCODE = {$sql->Param('a')}"),
    [$keys]);
$detail=$stmt->FetchNextObject();
$visitcode= $detail->B_VISITCODE;
$nam = $detail->VISIT_PATIENT;
$dat=$detail->VISIT_DATE;
$p_num=$detail->VISIT_PATIENTNUM;
$v_code=$detail->VISIT_CODE;
$v_cash=$detail-> VISIT_CASHAMT;
$v_altamt= $detail->VISIT_ALTAMT;
$v_mde= $detail->B_PAYSCHEMENAME;
$v_tot=$detail->B_TOTAMT;

$stmtitems = $sql->Execute($sql->Prepare("SELECT * from hms_billitem JOIN hms_visit on VISIT_CODE=B_VISITCODE WHERE B_VISITCODE = {$sql->Param('a')} AND 
B_CASHAMT > {$sql->Param('2')} AND B_STATUS = {$sql->Param('3')}"),[$visitcode,0,1]) ;

include 'model/js.php';

 //if(isset($action_search) && $action_search == "search"){
    if(!empty($fdsearch)){

        $query = "SELECT * FROM hms_emergency JOIN hms_patient ON EMER_PATIENTCODE=PATIENT_PATIENTCODE WHERE EMER_STATUS = '2' AND EMER_FACICODE=".$sql->Param('2')." AND (EMER_PATIENTNUM = ".$sql->Param('a')." OR EMER_PATIENTNAME LIKE ".$sql->Param('b').") ORDER BY EMER_INPUTDATE DESC";
        $input = array($faccode,$fdsearch,'%'.$fdsearch.'%');

  //  }  1 - ACTIVE, 2 DISCHARGED OPD, 3- ADMIT AT IPD/ EMERGENCY,  4- DISCHARGED AT IPD/ EM ,  5 - DISCHAGED AND  BILL READY, 6 - OWEING, 7 BILLS CLEAREDD , 0 BILLS SETTLED VISIT ENDED
}else{

    $query = "SELECT * FROM hms_visit WHERE VISIT_STATUS = {$sql->Param('1')} AND VISIT_CASHAMT > {$sql->Param('2')} ";
    $input = array('1','0');

}

if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=ad2376beebecdcf7846ba973fa1a005b&option=6831b98f85019ddb98bd98d44bdbac40#',$input);

include("model/js.php");
?>