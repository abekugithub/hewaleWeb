<?php
//$sms = new smsgatewayClass();
$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$patientCls = new patientClass();
$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();
$objdtls = $engine->getFacilityDetails();
$facilityalias = $objdtls->FACI_ALIAS ;
$faciname=$objdtls->FACI_NAME;
$faccode = $objdtls->FACI_CODE ;
//echo $faccode;die();
$engine = new engineClass();
$patientCls = new patientClass();
$sms = new smsgetway();

switch($viewpage){
    
    case 'prepare':
        if ($deliverystatus=='1' && empty($courier)){
            $msg="Please select a courier";
            $status="error";
            $view="prescdetails";


            $stmt = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_prescription WHERE PRESC_VISITCODE = ".$sql->Param('1').""),array($keys));
            print $sql->Errormsg();

            if($stmt->Recordcount() > 0 ){

                $obj = $stmt->FetchNextObject();

                $patient = $obj->PRESC_PATIENT;
                $patientnum= $obj->PRESC_PATIENTNUM;
                $visitcode= $obj->PRESC_VISITCODE;
                //$faccode = $obj->PRESC_FACICODE;
                $pickupcode=$obj->PRESC_PICKUPCODE;
                $pickupdelivery=$obj->PRESC_DEL_STATUS;
                $deliverystatus=$obj->PRESC_DEL_STATUS;

            }

            $stmtlist = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_prescription WHERE PRESC_VISITCODE = ".$sql->Param('1')." "),array($keys));
            print $sql->Errormsg();


            //$stmtcourierlov= $sql->Execute($sql->Prepare("SELECT PCO_COURIER,PCO_COURIERCODE FROM hms_pharmacycourier WHERE PCO_FACICODE=".$sql->Param('a')." "),array($faccode));
            $stmtcourierlov= $sql->Execute($sql->Prepare("SELECT CS_COURIERNAME,CS_COURIERCODE FROM hms_pharmcourierselection WHERE CS_PHARMCODE=".$sql->Param('a')." "),array($faccode));


        }else{


            if ($deliverystatus==1)//for courier
            {
                //to find patient phone number
                $stmt = $sql->execute($sql->Prepare("SELECT PRESC_PATIENTCODE FROM hms_patient_prescription WHERE PRESC_VISITCODE = ".$sql->Param('1')." "),array($keys));
                print $sql->Errormsg();
                if($stmt->Recordcount() > 0 ){
                    $obj = $stmt->FetchNextObject();
                    $patientcode= $obj->PRESC_PATIENTCODE;
                }
                $pickupcode = $engine->pickupcode();
                $receivercode = rand(999,10000);
                $sql->Execute($sql->Prepare("INSERT INTO hms_prescriptioncode(C_PICKUPCODE,C_RECIVERCODE,C_DATE) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').")"),array($pickupcode,$receivercode,date('Y-M-d')));
                //clear notification
                $stmt_clear=$sql->Execute($sql->Prepare("SELECT PRESC_ID from hms_patient_prescription WHERE PRESC_VISITCODE=".$sql->Param('a')." AND (PRESC_STATUS=".$sql->Param('b')." OR PRESC_STATUS=".$sql->Param('c').") ORDER BY PRESC_ID DESC LIMIT 1"),array($visitcode,'2','3'));
                if($stmt_clear->RecordCount()>0){
                    while($obj_clear=$stmt_clear->FetchNextObject()){
                        $tablerowid=$obj_clear->PRESC_ID;
                    }
                }else{
                    $tablerowid='';
                }
                $engine->ClearNotification('0029',$tablerowid);
                $courierarray=(!empty($courier)?explode('|',$courier):'');
                $stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_prescription SET PRESC_STATUS=".$sql->Param('a').",PRESC_COUR_CODE=".$sql->Param('b').",PRESC_COUR_NAME=".$sql->Param('c').",PRESC_PICKUPCODE=".$sql->Param('d')." WHERE PRESC_VISITCODE=".$sql->Param('d')." AND PRESC_FACICODE=".$sql->Param('e')." AND PRESC_STATUS=".$sql->Param('f')." "),array('4',$courierarray['0'],$courierarray['1'],$pickupcode,$visitcode,$faccode,'3'));
                print $sql->ErrorMsg();
                //echo $courierarray['0'];echo"$$$$"; echo $courierarray['1'];echo"$$$$"; echo $pickupcode;echo"$$$$"; echo$visitcode; echo"$$$$"; echo$facicode;
                //die();
                if ($stmt==TRUE){

                    //update the pharm courier price table with the assigned courier
                    $sql->Execute("UPDATE hms_pharm_courier_price SET PCP_COURIER_CODE=".$sql->Param('a')." WHERE PCP_PATIENT_VISITCODE=".$sql->Param('b')." ",array($courierarray['0'],$visitcode));
                    //get phone number of courier and send sms
                    $stmt_phone=$sql->Execute($sql->Prepare("SELECT FACI_PHONENUM from hmsb_allfacilities WHERE FACI_CODE=".$sql->Param('a').""),array($courierarray['0']));
                    if ($stmt_phone->RecordCount()>0){
                        while($obj=$stmt_phone->FetchNextObject()){
                            $courier_phone=$obj->FACI_PHONENUM;
                        }
                    }else{
                        $courier_phone='';
                    }
                    $stmt_pat_phone=$sql->Execute($sql->Prepare("SELECT PATCON_PHONENUM from hms_patient_connect WHERE PATCON_PATIENTCODE=".$sql->Param('a').""),array($patientcode));
                    if ($stmt_phone->RecordCount()>0){
                        while($objs=$stmt_pat_phone->FetchNextObject()){
                            $patient_phone=$objs->PATCON_PHONENUM;
                        }
                    }else{
                        $patient_phone='';
                    }
                    //send sms to courier
                    $message = "Description:Medication Pickup \nPharmacy: code: ".$prescripcode." \nStatus: In transit \nDelivery Code: ".$deliverycode." \nFor Assistance call 0203618205 ";
			
                    $couriermsg="Drug ready for pickup with pickupcode : $pickupcode";
                    $courierphone=$sms->validateNumber($courier_phone);
                    $courierresults=$sms->sendSms($courierphone,$couriermsg);
                    //send sms to patient
                    $patientmsg="Your drug has been prepared and ready for delivery with receiver code: $receivercode";
                    $patientphone=$sms->validateNumber($patient_phone);
                    $patientresults=$sms->sendSms($patientphone,$patientmsg);


                    $msg="Drug has been prepared.";
                    $status="success";
                    $view="";

                    //Push notification to the patient
                    $code = '012';
                    $patientobj = $patientCls->getPatientDetails($patientnum);
                    $playerid = $patientobj->PATCON_PLAYERID;
                    //$patientphone= $patientobj->PATIENT_PHONENUM;
                    $ptitle = push_notif_title;
                    $pmessage = $engine->getPushMessage($code);
                    $engine->broadcastIndividualMessage($ptitle,$pmessage,$playerid,$code,'',$largimg='',$bigimg='');
                    //End push notification
                    //send sms
                    //$sms->sendSms($patientphone,$pmessage);


                    //Notification to courier
                    $code = '013';
                    $facidetails = $engine->getFacilityDetails();
                    $faciname = $facidetails->FACI_NAME;
                    $menudetailscode = '0018';
                    $desc = "You are requested to pickup some drugs at ".$faciname. "with pickup code ".$pickupcode;
                    //to clear notification we need to get the latest row id
                    $stmt_clear=$sql->Execute($sql->Prepare("SELECT PRESC_ID from hms_patient_prescription WHERE PRESC_VISITCODE=".$sql->Param('a')." AND (PRESC_STATUS=".$sql->Param('b')." OR PRESC_STATUS=".$sql->Param('c').") ORDER BY PRESC_ID DESC LIMIT 1"),array($visitcode,'2','3'));
                    if($stmt_clear->RecordCount()>0){
                        while($obj_clear=$stmt_clear->FetchNextObject()){
                            $tablerowid=$obj_clear->PRESC_ID;
                        }
                    }else{
                        $tablerowid='';
                    }
                    //$smtrequstdetails = $patientCls->getPrescriptionInfo($visitcode);
                    $tablerowid = $smtrequstdetails->PRESC_ID;

                    $engine->setNotification($code,$desc,$menudetailscode,$tablerowid,"",$courierarray['0']);

                    $playerid2 = array();
                    $stmtfaciusers = $engine->getUserFaciDetails($courierarray['0']);


                    $ptitle = push_notif_title;
                    $pmessage = $engine->getPushMessage($code);

                    while($objfaciusers = $stmtfaciusers->FetchNextObject()){
                        $playerid = $objfaciusers->USR_PLAYERID;

                        $engine->broadcastIndividualMessage($ptitle,$pmessage,$playerid,$code,'',$largimg='',$bigimg='');
                    }
                    // print_r($playerid2);

                }else{
                    $msg="Drug could not be prepared";
                    $status="error";
                    $view="";
                }
            }

            else //self pickup
            {
                $stmt_clear=$sql->Execute($sql->Prepare("SELECT PRESC_ID from hms_patient_prescription WHERE PRESC_VISITCODE=".$sql->Param('a')." AND (PRESC_STATUS=".$sql->Param('b')." OR PRESC_STATUS=".$sql->Param('c').") ORDER BY PRESC_ID DESC LIMIT 1"),array($visitcode,'2','3'));
                if($stmt_clear->RecordCount()>0){
                    while($obj_clear=$stmt_clear->FetchNextObject()){
                        $tablerowid=$obj_clear->PRESC_ID;
                    }
                }else{
                    $tablerowid='';
                }
                $engine->ClearNotification('0029',$tablerowid);

                $stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_prescription SET PRESC_STATUS=".$sql->Param('a')." WHERE PRESC_VISITCODE=".$sql->Param('d')." "),array('4',$visitcode));
                if ($stmt==TRUE){

                    $msg="Drug has been prepared.";
                    $status="success";
                    $view="";

                    //Push notification to the patient
                    $code = '012';
                    $patientobj = $patientCls->getPatientDetails($patientnum);
                    $playerid = $patientobj->PATCON_PLAYERID;
                    $patientphone= $patientobj->PATIENT_PHONENUM;
                    $ptitle = push_notif_title;
                    $pmessage = $engine->getPushMessage($code);
                    $engine->broadcastIndividualMessage($ptitle,$pmessage,$playerid,$code,'',$largimg='',$bigimg='');
                    //End push notification
                    //send sms
                    $sms->sendSms($patientphone,$pmessage);

                }else{
                    $msg="Drug could not be prepared";
                    $status="error";
                    $view="";
                }
            }
        }
        break;
    case 'prescrdetails':

        if(empty($keys)){

            $msg = "Failed, prescription not found!.";
            $status = "error";
            $view ='';

        }else{

            $stmt = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_prescription LEFT JOIN hms_broadcast_prescription ON BRO_VISITCODE=PRESC_VISITCODE WHERE PRESC_PACKAGECODE = ".$sql->Param('1').""),array($keys));
            print $sql->Errormsg();

            if($stmt->Recordcount() > 0 ){

                $obj = $stmt->FetchNextObject();
                $behalfname=$obj->BRO_OTHERNAME;
                $behalfgender=$obj->BRO_OTHERGENDER;
                $behalfdob=$obj->BRO_OTHERDOB;
                $patient = $obj->PRESC_PATIENT;
                $patientnum= $obj->PRESC_PATIENTNUM;
                $visitcode= $obj->PRESC_VISITCODE;
                //$faccode = $obj->PRESC_FACICODE;
                $pickupcode=$obj->PRESC_PICKUPCODE;
                $pickupdelivery=$obj->PRESC_DEL_STATUS;
                $deliverystatus=$obj->PRESC_DEL_STATUS;

            }

            $stmtlist = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_prescription WHERE PRESC_PACKAGECODE = ".$sql->Param('1')."  AND (PRESC_STATUS = ".$sql->Param('a')." OR PRESC_STATUS=".$sql->Param('b')." ) "),array($keys,'2','3'));
            print $sql->Errormsg();


            $stmtcourierlov= $sql->Execute($sql->Prepare("SELECT CS_COURIERNAME,CS_COURIERCODE FROM hms_pharmcourierselection WHERE CS_PHARMCODE=".$sql->Param('a')." "),array($faccode));

        }
        break;
    case 'presdetails':
        $session->del('cartprepare');
        if(empty($keys)){

            $msg = "Failed, prescription not found!.";
            $status = "error";
            $view ='';

        }else{

            $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_prescription WHERE PRESC_PACKAGECODE = ".$sql->Param('1')." "),array($keys));
            print $sql->Errormsg();
            
            if($stmt->Recordcount() > 0 ){

                $obj = $stmt->FetchNextObject();

                $patient = $obj->PRESC_PATIENT;
                $patientnum= $obj->PRESC_PATIENTNUM;
                $visitcode= $obj->PRESC_VISITCODE;
                //$faccode = $obj->PRESC_FACICODE;
                $pickupcode=$obj->PRESC_PICKUPCODE;
                $pickupdelivery=$obj->PRESC_DEL_STATUS;
                $deliverystatus=$obj->PRESC_DEL_STATUS;
                $patientgender = !empty($patientCls->getPatientDetails($patientnum)->PATIENT_GENDER)?$patientCls->getPatientDetails($patientnum)->PATIENT_GENDER=='M'?'Male':'Female':'';
                $patientage = !empty($patientCls->getPatientDetails($patientnum)->PATIENT_DOB)?$engine->calculateAge($patientCls->getPatientDetails($patientnum)->PATIENT_DOB):'';
                $patientcontact = $patientCls->getPatientDetails($patientnum)->PATIENT_PHONENUM;
                $allergies = $patientCls->getPatientDetails($patientnum)->PATIENT_ALLERGIES;
                $prescriptioncode = $obj->PRESC_PACKAGECODE;
                $itemcode = $obj->PRESC_ITEMCODE ;

            }

//echo "tasdfasdf";

            $stmtlist = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_prescription WHERE PRESC_PACKAGECODE = ".$sql->Param('1')."  AND (PRESC_STATUS = ".$sql->Param('a')." OR PRESC_STATUS=".$sql->Param('b')." ) "),array($keys,'2','3'));
            print $sql->Errormsg();

            $stmtinstpercentage = $sql->Execute($sql->Prepare("SELECT FACI_INST_PERCENTAGE FROM hmsb_allfacilities WHERE FACI_CODE = ".$sql->Param('1')." "),array($faccode));
            print $sql->Errormsg();
            if ($stmtinstpercentage->RecordCount()>0){
                $instpercentage = $stmtinstpercentage->FetchNextObject()->FACI_INST_PERCENTAGE;
            }

            $stmtdiag= $sql->Execute($sql->Prepare("SELECT DIA_DIAGNOSIS FROM hms_patient_diagnosis LEFT JOIN hms_patient_prescription ON DIA_VISITCODE = PRESC_VISITCODE WHERE PRESC_PACKAGECODE = ".$sql->Param('1')." "),array($keys));
            if ($stmtdiag->RecordCount()>0){
                $objdia = $stmtdiag->FetchNextObject();
                $diagnosis =  $encaes->decrypt($objdia->DIA_DIAGNOSIS);
            }

            $stmtcourierlov= $sql->Execute($sql->Prepare("SELECT CS_COURIERNAME,CS_COURIERCODE FROM hms_pharmcourierselection WHERE CS_PHARMCODE=".$sql->Param('a')." "),array($faccode));

//TO pick the drugs prescribed

            //echo $drugid;
            //opening a cartprepare
            $cartprepare = $session->get('cartprepare');
         
            if (empty($cartprepare)){
                //adding a new drug
                //$paymentmethod=(!empty($paymentmethod)?explode('|',$paymentmethod):'');
                $stmt_getid = $sql->Execute($sql->Prepare("SELECT PRESC_CODE,PRESC_DRUGID,PRESC_QUANTITY,PRESC_DOSAGENAME,PRESC_DOSAGECODE,PRESC_DRUG,PRESC_FREQ,PRESC_DAYS,PRESC_TIMES FROM hms_patient_prescription WHERE PRESC_PACKAGECODE=".$sql->Param('a')." AND PRESC_STATUS != ".$sql->Param('b')),array($keys,'0'));
                if ($stmt_getid->RecordCount()>0){
                    while($obj_id=$stmt_getid->FetchNextObject()){
                        $drugid = $encaes->decrypt($obj_id->PRESC_DRUGID);
                        $drug =$encaes->decrypt($obj_id->PRESC_DRUG);
                        $drugidarray[$drugid]=array('PRESCRIPTION'=>$obj_id->PRESC_CODE,'QUANTITY'=>$obj_id->PRESC_QUANTITY,'DOSAGENAME'=>$obj_id->PRESC_DOSAGENAME,'DOSAGECODE'=>$obj_id->PRESC_DOSAGECODE,'DRUG'=>$drug,'PRESC_FREQ'=>$obj_id->PRESC_FREQ,'PRESC_DAYS'=>$obj_id->PRESC_DAYS,'PRESC_TIMES'=>$obj_id->PRESC_TIMES);
                    }
                }
                //	print_r($drugidarray); die();
                if(is_array($drugidarray) && count($drugidarray)>0 ){
                   
                    foreach ($drugidarray as $drugid=>$drugpresc){

                        $stmt = $sql->Execute($sql->Prepare("SELECT ST_NAME ,ST_DOSAGE ,ST_SHEL_QTY,PPR_PRICE,PPR_NHIS, ST_CODE,IFNULL(ST_CODE,'NEW') ST_TYPE,PPR_METHODCODE,PPR_METHOD from hms_pharmacystock JOIN hms_pharmacyprice ON ST_CODE=PPR_DRUGCODE 
                         WHERE ST_FACICODE =".$sql->Param('a')."  AND ST_STATUS=".$sql->Param('b')."  AND ST_CODE =".$sql->Param('c')." "),array($faccode,'1',$drugid));
                         if($stmt->RecordCount() == 0){

                            $stmt = $sql->Execute($sql->Prepare("SELECT DR_NAME AS ST_NAME,DR_DOSAGENAME AS ST_DOSAGE,'0' AS ST_SHEL_QTY,'0' AS PPR_PRICE,'0' AS PPR_NHIS,DR_CODE AS ST_CODE,'NEW' AS ST_TYPE,'' AS PPR_METHODCODE,'' AS PPR_METHOD from hmsb_st_phdrugs  WHERE DR_CODE=".$sql->Param('d')." "),array($drugid));
                         }

                        /*$stmt = $sql->Execute($sql->Prepare("SELECT IFNULL(ST_NAME,DR_NAME) ST_NAME,IFNULL(ST_DOSAGE,DR_DOSAGENAME) ST_DOSAGE,ST_SHEL_QTY,PPR_PRICE,PPR_NHIS,IFNULL(ST_CODE,DR_CODE) ST_CODE,IFNULL(ST_CODE,'NEW') ST_TYPE,PPR_METHODCODE,PPR_METHOD from hms_pharmacystock JOIN hms_pharmacyprice ON ST_CODE=PPR_DRUGCODE RIGHT JOIN hmsb_st_phdrugs ON DR_CODE=ST_CODE WHERE (ST_FACICODE =".$sql->Param('a')." OR ST_FACICODE IS NULL) AND (ST_STATUS=".$sql->Param('b')." OR ST_STATUS IS NULL) AND (ST_CODE =".$sql->Param('c')." OR DR_CODE=".$sql->Param('d').")"),array($faccode,'1',$drugid,$drugid)); */
                       // if ($stmt->RecordCount()>0){
                            while ($obj=$stmt->FetchNextObject()){
                                //print_r($obj); die();
                                //check the cost based on nhis or cash
                                if (empty($obj->PPR_NHIS) && $obj->PPR_METHODCODE=='PMT0003'){
                                    //if the drug has been absorbed by nhis
                                    $cost ='0';
                                    $nhis = $obj->PPR_PRICE;
                                }elseif (!empty($obj->PPR_NHIS) && $obj->PPR_METHODCODE=='PMT0003'){
                                    //if the drug needs nhis topup
                                    $cost = $obj->PPR_NHIS;
                                    $nhis =	$obj->PPR_PRICE;
                                }else{
                                    //if it is not covered by nhis
                                    $cost=$obj->PPR_PRICE;
                                    $nhis ='0';
                                }

                                $_SESSION['cartprepare'][$drugid]=array(
                                    'CODE'=>$obj->ST_CODE,
                                    'NAME'=>$obj->ST_NAME,
                                    'SHEL'=>$obj->ST_SHEL_QTY,//where deduction takes place
                                    'DOSAGE'=>$obj->ST_DOSAGE,
                                    'NHIS'=>$nhis,
                                    'COST'=>$cost,
                                    'QUANTITY'=>$drugpresc['QUANTITY'],
                                    'METHOD'=>$obj->PPR_METHOD,
                                    'METHODCODE'=>$obj->PPR_METHODCODE,
                                    'PRESCRIPTIONCODE'=>$drugpresc['PRESCRIPTION'],
                                    'DOSAGECODE'=>$drugpresc['DOSAGECODE'],
                                    'DOSAGENAME'=>$drugpresc['DOSAGENAME'],
                                    'TYPE'=>$obj->ST_TYPE,
                                    'PRESC_FREQ'=>$drugpresc['PRESC_FREQ'],
                                    'PRESC_DAYS'=>$drugpresc['PRESC_DAYS'],
                                    'PRESC_TIMES'=>$drugpresc['PRESC_TIMES']
                                );
                            }
                       // }
                    }
                }
                $view="prescdetails";
            }else{
                //if the item is already in the tray increase by 1.
                if (array_key_exists($drugid,$cartprepare)){
                    $_SESSION['cartprepare'][$drugid]['QUANTITY']=$_SESSION['cartprepare'][$drugid]['QUANTITY'] +1;
                }else{
                    //echo "BooooooooooooooooooooooooooooM"; die();
                    $paymentmethod=(!empty($paymentmethod)?explode('|',$paymentmethod):'');

                    //if it is a new drug after the cartprepare has been opened
                    $stmt = $sql->Execute($sql->Prepare("SELECT ST_NAME,ST_DOSAGE,ST_SHEL_QTY,PPR_PRICE,PPR_NHIS,ST_CODE,PPR_METHODCODE,PPR_METHOD from hms_pharmacystock JOIN hms_pharmacyprice ON ST_CODE=PPR_DRUGCODE WHERE ST_FACICODE =".$sql->Param('a')." AND ST_STATUS=".$sql->Param('b')." AND ST_CODE=".$sql->Param('c')." AND ST_STORE_QTY > ".$sql->Param('d')." "),array($faccode,'1',$drugid,'0'));
                    print $sql->ErrorMsg();
                    //	echo "BINGOOOOOOOOOOOOOOOOOOOOOOOOOO".$faccode.' '.$drugid.' '.$paymentmethod[0];
                    if ($stmt->RecordCount()>0){

                        while ($obj=$stmt->FetchNextObject()){
                            //check the cost based on nhis or cash
                            if (empty($obj->PPR_NHIS) && $obj->PPR_METHODCODE=='PMT0003'){
                                //if the drug has been absorbed by nhis
                                $cost ='0';
                                $nhis = $obj->PPR_PRICE;
                            }elseif (!empty($obj->PPR_NHIS) && $obj->PPR_METHODCODE=='PMT0003'){
                                //if the drug needs nhis topup
                                $cost = $obj->PPR_NHIS;
                                $nhis =	$obj->PPR_PRICE;
                            }else{
                                //if it is not covered by nhis
                                $cost=$obj->PPR_PRICE;
                                $nhis ='0';
                            }

                            $_SESSION['cartprepare'][$drugid]=array(
                                'CODE'=>$obj->ST_CODE,
                                'NAME'=>$obj->ST_NAME,
                                'DOSAGE'=>$obj->ST_DOSAGE,
                                'SHEL'=>$obj->ST_SHEL_QTY,//where deduction takes place
                                'NHIS'=>$nhis,
                                'COST'=>$cost,
                                'QUANTITY'=>'1',
                                'METHOD'=>$obj->PPR_METHOD,
                                'METHODCODE'=>$obj->PPR_METHODCODE,
                            );
                        }
                    }


                }

                $view="prescdetails";
            }



        }
        break;

    /**'CODE'=>$obj->ST_CODE,
    'NAME'=>$obj->ST_NAME,
    'DOSAGE'=>$obj->ST_DOSAGE,
    'SHEL'=>$obj->ST_SHEL_QTY,//where deduction takes place
    'NHIS'=>$nhis,
    'COST'=>$cost,
    'QUANTITY'=>'1',
    'METHOD'=>$obj->PPR_METHOD,
    'METHODCODE'=>$obj->PPR_METHODCODE**/
    case 'sales':
        $stmtcourierlov= $sql->Execute($sql->Prepare("SELECT CS_COURIERNAME,CS_COURIERCODE FROM hms_pharmcourierselection WHERE CS_PHARMCODE=".$sql->Param('a')." "),array($faccode));
        if ($deliverystatus=='1' && empty($courier)){
            $msg="Please select a courier";
            $status="error";
            $view="prescdetails";


            $stmt = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_prescription WHERE PRESC_VISITCODE = ".$sql->Param('1')." AND PRESC_FACICODE=".$sql->Param('2')." "),array($keys,$faccode));
            print $sql->Errormsg();

            if($stmt->Recordcount() > 0 ){

                $obj = $stmt->FetchNextObject();

                $patient = $obj->PRESC_PATIENT;
                $patientnum= $obj->PRESC_PATIENTNUM;
                $visitcode= $obj->PRESC_VISITCODE;
                //$faccode = $obj->PRESC_FACICODE;
                $pickupcode=$obj->PRESC_PICKUPCODE;
                $pickupdelivery=$obj->PRESC_DEL_STATUS;
                $deliverystatus=$obj->PRESC_DEL_STATUS;

            }

            $stmtlist = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_prescription WHERE PRESC_VISITCODE = ".$sql->Param('1')." AND PRESC_FACICODE=".$sql->Param('2').""),array($keys,$faccode));
            print $sql->Errormsg();

            $stmtcourierlov= $sql->Execute($sql->Prepare("SELECT CS_COURIERNAME,CS_COURIERCODE FROM hms_pharmcourierselection WHERE CS_PHARMCODE=".$sql->Param('a')." "),array($faccode));
            //$stmtcourierlov= $sql->Execute($sql->Prepare("SELECT PCO_COURIER,PCO_COURIERCODE FROM hms_pharmacycourier WHERE PCO_FACICODE=".$sql->Param('a')." "),array($faccode));


        }else{
            if ($deliverystatus=='1'){//for courier
                $stmt = $sql->execute($sql->Prepare("SELECT PRESC_PATIENTNUM FROM hms_patient_prescription WHERE PRESC_VISITCODE = ".$sql->Param('1')." and  PRESC_FACICODE = ".$sql->Param('a')." "),array($keys,$faccode));
                print $sql->Errormsg();

                if($stmt->Recordcount() > 0 ){

                    $obj = $stmt->FetchNextObject();
                    $patientnum= $obj->PRESC_PATIENTNUM;
                }
                $pickupcode = $engine->pickupcode();
                $receivercode = rand(999,10000);
                $sql->Execute($sql->Prepare("INSERT INTO hms_prescriptioncode(C_PICKUPCODE,C_RECIVERCODE,C_DATE) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').")"),array($pickupcode,$receivercode,date('Y-M-d')));
                $courierarray=(!empty($courier)?explode('|',$courier):'');
                $sql->Execute($sql->Prepare("UPDATE hms_patient_prescription SET PRESC_COUR_CODE=".$sql->Param('a').",PRESC_COUR_NAME=".$sql->Param('b').",PRESC_STATUS=".$sql->Param('c')." WHERE PRESC_VISITCODE=".$sql->Param('d')." AND PRESC_FACICODE=".$sql->Param('e')." AND PRESC_STATUS =".$sql->Param('f')." "),array($courierarray[0],$courierarray[1],'4',$visitcode,$faccode,'3'));
                print $sql->ErrorMsg();
                //update the pharm courier price table with the assigned courier
                $sql->Execute("UPDATE hms_pharm_courier_price SET PCP_COURIER_CODE=".$sql->Param('a')." WHERE PCP_PATIENT_VISITCODE=".$sql->Param('b')." ",array($courierarray['0'],$visitcode));
                //Push notification to the patient
                $code = '038';
                $patientobj = $patientCls->getPatientDetails($patientnum);
                $playerid = $patientobj->PATCON_PLAYERID;
                $patientphone= $patientobj->PATIENT_PHONENUM;
                $ptitle = push_notif_title;
                $pmessage = $engine->getPushMessage($code)." with delivery code $receivercode";
                $engine->broadcastIndividualMessage($ptitle,$pmessage,$playerid,$code,'',$largimg='',$bigimg='');
                //End push notification
                //send sms
                $sms->sendSms($patientphone,$pmessage);

            }
            $stmt = $sql->Execute($sql->Prepare("SELECT PRESC_VISITCODE,PRESC_DRUGID,PRESC_DRUG,PRESC_QUANTITY,PRESC_DOSAGENAME,PRESC_QUANTITY,'HEWALE' AS PRESC_METHOD,PRESC_TOTAL,PEND_TOTAL,PEND_UNITPRICE,PRESC_UNITPRICE,PRESC_PATIENT,PRESC_PATIENTNUM,PRESC_PICKUPCODE,PRESC_DEL_STATUS,PEND_QUANTITY FROM hms_patient_prescription LEFT JOIN hms_pending_prescription ON PRESC_VISITCODE=PEND_VISITCODE AND PRESC_CODE=PEND_PRESC_CODE WHERE PRESC_VISITCODE=".$sql->Param('a')." AND PRESC_FACICODE=".$sql->Param('a')." "),array($keys,$faccode));
            if ($stmt->RecordCount()>0){
                while($obj=$stmt->FetchNextObject()){
                    $customername=$obj->PRESC_PATIENT;
                    $hewalenumber=$obj->PRESC_PATIENTNUM;
                    $drugs = $encaes->decrypt($obj->PRESC_DRUG);
                    $drugid = $encaes->decrypt($obj->PRESC_DRUGID);
                    $pickupcode = $obj->PRESC_PICKUPCODE;
                    $visitcode=$obj->PRESC_VISITCODE;
                    $deliverystatus=$obj->PRESC_DEL_STATUS;
                    $cart[$obj->PRESC_DRUGID]=array('CODE'=>$drugid,'NAME'=>$drugs,'DOSAGE'=>$obj->PRESC_DOSAGENAME,'COST'=>$obj->PEND_UNITPRICE,'QUANTITY'=>$obj->PEND_QUANTITY,'METHOD'=>$obj->PRESC_METHOD,'TOTAL'=>PRESC_TOTAL);
                }
            }

        }
        break;

    case 'savesales':
        //echo "OIOI";

        $session->del('salecode');
        $salecode = $engine->pharmacysaleCode();
        $salesid = date('Ymdhis').uniqid().$usrcode;
        $stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_pharmacysales(SAL_CODE, SAL_DRUGCODE, SAL_DRUG, SAL_DOSAGE, SAL_QUANTITY, SAL_COST, SAL_NHIS, SAL_CUSTOMER, SAL_USERCODE, SAL_USERNAME, SAL_FACICODE, SAL_METHOD, SAL_METHODCODE, SAL_STATUS, SAL_UNIQCODE) SELECT '$salecode',PRESC_DRUGID,PRESC_DRUG,PRESC_DOSAGENAME,PEND_QUANTITY,PEND_UNITPRICE,'0',PRESC_PATIENT,'$usrcode','$usrname','$faccode','HEWALE','000','1','$salesid' from hms_patient_prescription JOIN hms_pending_prescription ON PEND_VISITCODE=PRESC_VISITCODE AND PRESC_CODE=PEND_PRESC_CODE WHERE PRESC_VISITCODE= ".$sql->Param('a')." AND PRESC_FACICODE=".$sql->Param('b').""),array($visitcode,$faccode));
        print $sql->ErrorMsg();
        if ($stmt==TRUE){
            if ($deliverystatus=='1'){
                $pickupcode = $engine->pickupcode();
                $receivercode = rand(999,10000);
                $sql->Execute($sql->Prepare("INSERT INTO hms_prescriptioncode(C_PICKUPCODE,C_RECIVERCODE,C_DATE) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').")"),array($pickupcode,$receivercode,date('Y-M-d')));
            }
            $courierarray=(!empty($courier)?explode('|',$courier):'');

            $courierarray=(!empty($courier)?explode('|',$courier):'');
            $stmtup= $sql->Execute($sql->Prepare("UPDATE hms_pending_prescription SET PEND_STATUS=".$sql->Param('a').", PEND_COUR_CODE=".$sql->Param('b').", PEND_COUR_NAME=".$sql->Param('c')." WHERE PEND_VISITCODE=".$sql->Param('a')." AND PEND_FACICODE=".$sql->Param('b').""),array('4',$courierarray[0],$courierarray[1],$visitcode,$faccode));
            $stmtup2=$sql->Execute($sql->Prepare("UPDATE hms_broadcast_prescription SET BRO_STATUS=".$sql->Param('a')." WHERE BRO_VISITCODE=".$sql->Param('b')." AND BRO_PHARMACYCODE=".$sql->Param('c')." AND BRO_STATUS=".$sql->Param('d')." "),array('4',$visitcode,$faccode,'3'));
            //move values from transit table to wallet table if there's a courier involved
            if ($deliverystatus=='1'){

                $stmtcash = $sql->Execute($sql->Prepare("SELECT PCP_PHARM_AMT,PCP_COURIER_AMT,PCP_COURIER_CODE,PCP_PATIENTCODE from hms_pharm_courier_price WHERE PCP_PATIENT_VISITCODE =".$sql->Param('a')." AND PCP_PHARM_CODE=".$sql->Param('b')." AND PCP_STATUS=".$sql->Param('c')." "),array($visitcode,$faccode,'0'));
                if ($stmtcash->RecordCount()>0){
                    $obj = $stmtcash->FetchNextObject();
                    $patientcode=$obj->PCP_PATIENTCODE;
                    $pharmacyamount = $obj->PCP_PHARM_AMT;
                    $courieramount = $obj->PCP_COURIER_AMT;
                    $couriercode= $obj->PCP_COURIER_CODE;
                }
            }else{
                //echo "BONGOOOOOOO";die();
                $stmtcash = $sql->Execute($sql->Prepare("SELECT WAL_HOLD_AMT,WAL_PATIENTCODE from hms_wallet_trans_holder WHERE WAL_PATIENT_VISITCODE=".$sql->Param('a')." AND WAL_SERV_PROVIDERCODE=".$sql->Param('b')." AND WAL_STATUS=".$sql->Param('c')." "),array($visitcode,$faccode,'0'));
                if ($stmtcash->RecordCount()>0){
                    $obj =$stmtcash->FetchNextObject();
                    $patientcode=$obj->WAL_PATIENTCODE;
                    $pharmacyamount = $obj->WAL_HOLD_AMT;
                    $courieramount=NULL;
                    $couriercode=NULL;
                }
            }
            //echo $patientcode."--".$pharmacyamount."--".$faccode."--".$visitcode."--".$couriercode."--".$courieramount;
            //die();
            //distribute payment
            $engine->patienttopharmacyprice($patientcode,$pharmacyamount,$faccode,$visitcode,$couriercode,$courieramount);
            //reduce quantity by selecting the various quantities
            $stcheck =$sql->Execute($sql->Prepare("SELECT PEND_DRUG,PEND_DOSAGENAME,PEND_QUANTITY from hms_pending_prescription WHERE PEND_PACKAGECODE=".$sql->Param('a')." AND PEND_FACICODE=".$sql->Param('b')." "),array($packagecode,$faccode));
            print $sql->ErrorMsg();
            if ($stcheck->RecordCount()>0){
                while ($obj = $stcheck->FetchNextObject()){
                    $datarray[]=array('NAME'=>$obj->PEND_DRUG,'DOSAGE'=>$obj->PRESC_DOSAGENAME,'QUANTITY'=>$obj->PEND_QUANTITY);
                }
                if (is_array($datarray) && count($datarray)>0){
                    foreach ($datarray as $key){
                        //make the subtraction
                        $sql->Execute($sql->Prepare("UPDATE hms_pharmacystock SET ST_STORE_QTY=ST_STORE_QTY- ".$sql->Param('a')." WHERE ST_NAME=".$sql->Param('b')." AND ST_DOSAGE=".$sql->Param('c')." "),array($key['QUANTITY'],$key['NAME'],$key['DOSAGE']));
                        print $sql->ErrorMsg();
                    }
                }
            }
            //update the state to transit
            $sql->Execute($sql->Prepare("UPDATE hms_patient_prescription SET PRESC_STATUS=".$sql->Param('a').",PRESC_STATE=".$sql->Param('b')." WHERE PRESC_VISITCODE=".$sql->Param('c')." "),array('5','4',$visitcode));
            print $sql->ErrorMsg();
            if ($deliverystatus=='1'){
                $msg="Sale successfully completed with pickup code $pickupcode";
            }else{
                $msg="Sale successfully completed";
            }
            $status="success";
            $session->set('salecode',$salecode);
            $view="receipt";
            //to clear notification we need to get the latest row id
            $stmt_clear=$sql->Execute($sql->Prepare("SELECT PRESC_ID from hms_patient_prescription WHERE PRESC_VISITCODE=".$sql->Param('a')." AND (PRESC_STATUS=".$sql->Param('b')." OR PRESC_STATUS=".$sql->Param('c').") ORDER BY PRESC_ID DESC LIMIT 1"),array($visitcode,'2','3'));
            if($stmt_clear->RecordCount()>0){
                while($obj_clear=$stmt_clear->FetchNextObject()){
                    $tablerowid=$obj_clear->PRESC_ID;
                }
            }else{
                $tablerowid='';
            }
            $engine->ClearNotification('0029',$tablerowid);
        }else{
            $msg="Sale not processed, please try again.";
            $status="error";
            $view="";
        }
        break;
    /**BEGINING OF IMAGESALE **/
    case 'salesimage':
        $stmtcourierlov= $sql->Execute($sql->Prepare("SELECT CS_COURIERNAME,CS_COURIERCODE FROM hms_pharmcourierselection WHERE CS_PHARMCODE=".$sql->Param('a')." "),array($faccode));
        if ($deliverystatus=='1' && empty($courier)){
            $msg="Please select a courier";
            $status="error";
            $view="prescdetails";


            $stmt = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_prescription WHERE PRESC_VISITCODE = ".$sql->Param('1')." AND PRESC_FACICODE=".$sql->Param('2')." "),array($keys,$faccode));
            print $sql->Errormsg();

            if($stmt->Recordcount() > 0 ){

                $obj = $stmt->FetchNextObject();

                $patient = $obj->PRESC_PATIENT;
                $patientnum= $obj->PRESC_PATIENTNUM;
                $visitcode= $obj->PRESC_VISITCODE;
                //$faccode = $obj->PRESC_FACICODE;
                $pickupcode=$obj->PRESC_PICKUPCODE;
                $pickupdelivery=$obj->PRESC_DEL_STATUS;
                $deliverystatus=$obj->PRESC_DEL_STATUS;

            }

            $stmtlist = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_prescription WHERE PRESC_VISITCODE = ".$sql->Param('1')." AND PRESC_FACICODE=".$sql->Param('2').""),array($keys,$faccode));
            print $sql->Errormsg();

            $stmtcourierlov= $sql->Execute($sql->Prepare("SELECT CS_COURIERNAME,CS_COURIERCODE FROM hms_pharmcourierselection WHERE CS_PHARMCODE=".$sql->Param('a')." "),array($faccode));
            //$stmtcourierlov= $sql->Execute($sql->Prepare("SELECT PCO_COURIER,PCO_COURIERCODE FROM hms_pharmacycourier WHERE PCO_FACICODE=".$sql->Param('a')." "),array($faccode));


        }else{
            if ($deliverystatus=='1'){//for courier
                $stmt = $sql->execute($sql->Prepare("SELECT PRESC_PATIENTNUM FROM hms_patient_prescription WHERE PRESC_VISITCODE = ".$sql->Param('1')." and  PRESC_FACICODE = ".$sql->Param('a')." "),array($keys,$faccode));
                print $sql->Errormsg();

                if($stmt->Recordcount() > 0 ){

                    $obj = $stmt->FetchNextObject();
                    $patientnum= $obj->PRESC_PATIENTNUM;
                }
                $pickupcode = $engine->pickupcode();
                $receivercode = rand(999,10000);
                $sql->Execute($sql->Prepare("INSERT INTO hms_prescriptioncode(C_PICKUPCODE,C_RECIVERCODE,C_DATE) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').")"),array($pickupcode,$receivercode,date('Y-M-d')));
                $courierarray=(!empty($courier)?explode('|',$courier):'');
                $sql->Execute($sql->Prepare("UPDATE hms_patient_prescription SET PRESC_COUR_CODE=".$sql->Param('a').",PRESC_COUR_NAME=".$sql->Param('b').",PRESC_STATUS=".$sql->Param('c')." WHERE PRESC_VISITCODE=".$sql->Param('d')." AND PRESC_FACICODE=".$sql->Param('e')." AND PRESC_STATUS =".$sql->Param('f')." "),array($courierarray[0],$courierarray[1],'4',$visitcode,$faccode,'3'));
                print $sql->ErrorMsg();
                //update the pharm courier price table with the assigned courier
                $sql->Execute("UPDATE hms_pharm_courier_price SET PCP_COURIER_CODE=".$sql->Param('a')." WHERE PCP_PATIENT_VISITCODE=".$sql->Param('b')." ",array($courierarray['0'],$visitcode));
                //Push notification to the patient
                $code = '038';
                $patientobj = $patientCls->getPatientDetails($patientnum);
                $playerid = $patientobj->PATCON_PLAYERID;
                $patientphone= $patientobj->PATIENT_PHONENUM;
                $ptitle = push_notif_title;
                $pmessage = $engine->getPushMessage($code)." with delivery code $receivercode";
                $engine->broadcastIndividualMessage($ptitle,$pmessage,$playerid,$code,'',$largimg='',$bigimg='');
                //End push notification
                //send sms
                $sms->sendSms($patientphone,$pmessage);

            }
            $stmt = $sql->Execute($sql->Prepare("SELECT PRESC_VISITCODE,PEND_DRUGID,PEND_DRUG,PRESC_QUANTITY,PRESC_DOSAGENAME,PRESC_QUANTITY,'HEWALE' AS PRESC_METHOD,PRESC_TOTAL,PEND_TOTAL,PEND_UNITPRICE,PRESC_UNITPRICE,PRESC_PATIENT,PRESC_PATIENTNUM,PRESC_PICKUPCODE,PRESC_DEL_STATUS,PEND_QUANTITY FROM hms_patient_prescription LEFT JOIN hms_pending_prescription ON PRESC_VISITCODE=PEND_VISITCODE WHERE PRESC_VISITCODE=".$sql->Param('a')." AND PRESC_FACICODE=".$sql->Param('a')." "),array($keys,$faccode));
            if ($stmt->RecordCount()>0){
                while($obj=$stmt->FetchNextObject()){
                    $customername=$obj->PRESC_PATIENT;
                    $hewalenumber=$obj->PRESC_PATIENTNUM;
                    $drugs = $encaes->decrypt($obj->PEND_DRUG);
                    $drugid = $encaes->decrypt($obj->PEND_DRUGID);
                    $pickupcode = $obj->PRESC_PICKUPCODE;
                    $visitcode=$obj->PRESC_VISITCODE;
                    $deliverystatus=$obj->PRESC_DEL_STATUS;
                    $cart[$obj->PEND_DRUGID]=array('CODE'=>$drugid,'NAME'=>$drugs,'DOSAGE'=>$obj->PRESC_DOSAGENAME,'COST'=>$obj->PEND_UNITPRICE,'QUANTITY'=>$obj->PEND_QUANTITY,'METHOD'=>$obj->PRESC_METHOD,'TOTAL'=>PRESC_TOTAL);
                }
            }

        }
        break;

        case "pharmahistorydetails":

            $stmthis = $sql->Execute($sql->Prepare("SELECT DISTINCT PRESCM_DATE,PRESCM_VISITCODE FROM hms_patient_prescription_main WHERE PRESCM_PATIENTNUM=".$sql->Param('a')." ORDER BY PRESCM_DATE DESC LIMIT 5 "),array($patientcode));
            print $sql->ErrorMsg();

          
        break;
    /** END OG IMAGE SALES**/
    /**BEGINING SAVE SALES FOR IMAGE**/
    case 'saveimagesales':
        //echo "OIOI";

        $session->del('salecode');
        $salecode = $engine->pharmacysaleCode();
        $salesid = date('Ymdhis').uniqid().$usrcode;
        $stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_pharmacysales(SAL_CODE, SAL_DRUGCODE, SAL_DRUG, SAL_DOSAGE, SAL_QUANTITY, SAL_COST, SAL_NHIS, SAL_CUSTOMER, SAL_USERCODE, SAL_USERNAME, SAL_FACICODE, SAL_METHOD, SAL_METHODCODE, SAL_STATUS, SAL_UNIQCODE) SELECT '$salecode',PEND_DRUGID,PEND_DRUG,PRESC_DOSAGENAME,PEND_QUANTITY,PEND_UNITPRICE,'0',PRESC_PATIENT,'$usrcode','$usrname','$faccode','HEWALE','000','1','$salesid' from hms_patient_prescription JOIN hms_pending_prescription ON PEND_VISITCODE=PRESC_VISITCODE WHERE PRESC_VISITCODE= ".$sql->Param('a')." AND PRESC_FACICODE=".$sql->Param('b').""),array($visitcode,$faccode));
        print $sql->ErrorMsg();
        if ($stmt==TRUE){
            //print_r($courier);//die();
            if ($deliverystatus=='1'){
                $pickupcode = $engine->pickupcode();
                $receivercode = rand(999,10000);
                $sql->Execute($sql->Prepare("INSERT INTO hms_prescriptioncode(C_PICKUPCODE,C_RECIVERCODE,C_DATE) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').")"),array($pickupcode,$receivercode,date('Y-M-d')));
            }
            $courierarray=(!empty($courier)?explode('|',$courier):'');
            $stmtup= $sql->Execute($sql->Prepare("UPDATE hms_pending_prescription SET PEND_STATUS=".$sql->Param('a').", PEND_COUR_CODE=".$sql->Param('b').",PEND_COUR_NAME=".$sql->Param('c')." WHERE PEND_VISITCODE=".$sql->Param('a')." AND PEND_FACICODE=".$sql->Param('b').""),array('4',$courierarray[0],$courierarray[1],$visitcode,$faccode));
            $stmtup2=$sql->Execute($sql->Prepare("UPDATE hms_broadcast_prescription SET BRO_STATUS=".$sql->Param('a')." WHERE BRO_VISITCODE=".$sql->Param('b')." AND BRO_PHARMACYCODE=".$sql->Param('c')." AND BRO_STATUS=".$sql->Param('d')." "),array('4',$visitcode,$faccode,'3'));
            //move values from transit table to wallet table if there's a courier involved
            if ($deliverystatus=='1'){

                $stmtcash = $sql->Execute($sql->Prepare("SELECT PCP_PHARM_AMT,PCP_COURIER_AMT,PCP_COURIER_CODE,PCP_PATIENTCODE from hms_pharm_courier_price WHERE PCP_PATIENT_VISITCODE =".$sql->Param('a')." AND PCP_PHARM_CODE=".$sql->Param('b')." AND PCP_STATUS=".$sql->Param('c')." "),array($visitcode,$faccode,'0'));
                if ($stmtcash->RecordCount()>0){
                    $obj = $stmtcash->FetchNextObject();
                    $patientcode=$obj->PCP_PATIENTCODE;
                    $pharmacyamount = $obj->PCP_PHARM_AMT;
                    $courieramount = $obj->PCP_COURIER_AMT;
                    $couriercode= $obj->PCP_COURIER_CODE;
                }
            }else{
                //echo "BONGOOOOOOO";die();
                $stmtcash = $sql->Execute($sql->Prepare("SELECT WAL_HOLD_AMT,WAL_PATIENTCODE from hms_wallet_trans_holder WHERE WAL_PATIENT_VISITCODE=".$sql->Param('a')." AND WAL_SERV_PROVIDERCODE=".$sql->Param('b')." AND WAL_STATUS=".$sql->Param('c')." "),array($visitcode,$faccode,'0'));
                if ($stmtcash->RecordCount()>0){
                    $obj =$stmtcash->FetchNextObject();
                    $patientcode=$obj->WAL_PATIENTCODE;
                    $pharmacyamount = $obj->WAL_HOLD_AMT;
                    $courieramount=NULL;
                    $couriercode=NULL;
                }
            }
            //echo $patientcode."--".$pharmacyamount."--".$faccode."--".$visitcode."--".$couriercode."--".$courieramount;
            //die();
            //distribute payment
            $engine->patienttopharmacyprice($patientcode,$pharmacyamount,$faccode,$visitcode,$couriercode,$courieramount);
            //reduce quantity by selecting the various quantities
            $stcheck =$sql->Execute($sql->Prepare("SELECT PEND_DRUG,PEND_DOSAGENAME,PEND_QUANTITY from hms_pending_prescription WHERE PEND_PACKAGECODE=".$sql->Param('a')." AND PEND_FACICODE=".$sql->Param('b')." "),array($packagecode,$faccode));
            print $sql->ErrorMsg();
            if ($stcheck->RecordCount()>0){
                while ($obj = $stcheck->FetchNextObject()){
                    $datarray[]=array('NAME'=>$obj->PEND_DRUG,'DOSAGE'=>$obj->PRESC_DOSAGENAME,'QUANTITY'=>$obj->PEND_QUANTITY);
                }
                if (is_array($datarray) && count($datarray)>0){
                    foreach ($datarray as $key){
                        //make the subtraction
                        $sql->Execute($sql->Prepare("UPDATE hms_pharmacystock SET ST_STORE_QTY=ST_STORE_QTY- ".$sql->Param('a')." WHERE ST_NAME=".$sql->Param('b')." AND ST_DOSAGE=".$sql->Param('c')." "),array($key['QUANTITY'],$key['NAME'],$key['DOSAGE']));
                        print $sql->ErrorMsg();
                    }
                }
            }
            //update the state to transit
            $sql->Execute($sql->Prepare("UPDATE hms_patient_prescription SET PRESC_STATUS=".$sql->Param('a').",PRESC_STATE=".$sql->Param('b')." WHERE PRESC_VISITCODE=".$sql->Param('c')." "),array('5','4',$visitcode));
            print $sql->ErrorMsg();
            if ($deliverystatus=='1'){
                $msg="Sale successfully completed with pickup code $pickupcode";
            }else{
                $msg="Sale successfully completed";
            }
            $status="success";
            $session->set('salecode',$salecode);
            $view="receipt";
            //to clear notification we need to get the latest row id
            $stmt_clear=$sql->Execute($sql->Prepare("SELECT PRESC_ID from hms_patient_prescription WHERE PRESC_VISITCODE=".$sql->Param('a')." AND (PRESC_STATUS=".$sql->Param('b')." OR PRESC_STATUS=".$sql->Param('c').") ORDER BY PRESC_ID DESC LIMIT 1"),array($visitcode,'2','3'));
            if($stmt_clear->RecordCount()>0){
                while($obj_clear=$stmt_clear->FetchNextObject()){
                    $tablerowid=$obj_clear->PRESC_ID;
                }
            }else{
                $tablerowid='';
            }
            $engine->ClearNotification('0029',$tablerowid);
        }else{
            $msg="Sale not processed, please try again.";
            $status="error";
            $view="";
        }
        break;
    /**END OF IMAGE SAVE**/
    /**BEGINING OF PRESCRIPTION PROCESSING**/
    case 'prescaddtray':
        if (!empty($drugid) /**&& !empty($paymentmethod)**/){
            //echo $drugid;
            //opening a cartprepare
            $cartprepare = $session->get('cartprepare');
            if (empty($cartprepare)){
                //adding a new drug
                //$paymentmethod=(!empty($paymentmethod)?explode('|',$paymentmethod):'');
                $stmt = $sql->Execute($sql->Prepare("SELECT ST_NAME,ST_DOSAGE,ST_SHEL_QTY,PPR_PRICE,PPR_NHIS,ST_CODE,PPR_METHODCODE,PPR_METHOD from hms_pharmacystock JOIN hms_pharmacyprice ON ST_CODE=PPR_DRUGCODE WHERE ST_FACICODE =".$sql->Param('a')." AND ST_STATUS=".$sql->Param('b')." AND ST_CODE =".$sql->Param('c')." AND ST_STORE_QTY > ".$sql->Param('d')." "),array($faccode,'1',$drugid,'0'));
                if ($stmt->RecordCount()>0){
                    while ($obj=$stmt->FetchNextObject()){
                        //check the cost based on nhis or cash
                        if (empty($obj->PPR_NHIS) && $obj->PPR_METHODCODE=='PMT0003'){
                            //if the drug has been absorbed by nhis
                            $cost ='0';
                            $nhis = $obj->PPR_PRICE;
                        }elseif (!empty($obj->PPR_NHIS) && $obj->PPR_METHODCODE=='PMT0003'){
                            //if the drug needs nhis topup
                            $cost = $obj->PPR_NHIS;
                            $nhis =	$obj->PPR_PRICE;
                        }else{
                            //if it is not covered by nhis
                            $cost=$obj->PPR_PRICE;
                            $nhis ='0';
                        }

                        $_SESSION['cartprepare'][$drugid]=array(
                            'CODE'=>$obj->ST_CODE,
                            'NAME'=>$obj->ST_NAME,
                            'SHEL'=>$obj->ST_SHEL_QTY,//where deduction takes place
                            'DOSAGE'=>$obj->ST_DOSAGE,
                            'NHIS'=>$nhis,
                            'COST'=>$cost,
                            'QUANTITY'=>'1',
                            'METHOD'=>$obj->PPR_METHOD,
                            'METHODCODE'=>$obj->PPR_METHODCODE,
                        );
                    }
                }
                $view="prescdetails";
            }else{
                //if the item is already in the tray increase by 1.
                if (array_key_exists($drugid,$cartprepare)){
                    $_SESSION['cartprepare'][$drugid]['QUANTITY']=$_SESSION['cartprepare'][$drugid]['QUANTITY'] +1;
                }else{
                    //echo "BooooooooooooooooooooooooooooM"; die();
                    $paymentmethod=(!empty($paymentmethod)?explode('|',$paymentmethod):'');

                    //if it is a new drug after the cartprepare has been opened
                    $stmt = $sql->Execute($sql->Prepare("SELECT ST_NAME,ST_DOSAGE,ST_SHEL_QTY,PPR_PRICE,PPR_NHIS,ST_CODE,PPR_METHODCODE,PPR_METHOD from hms_pharmacystock JOIN hms_pharmacyprice ON ST_CODE=PPR_DRUGCODE WHERE ST_FACICODE =".$sql->Param('a')." AND ST_STATUS=".$sql->Param('b')." AND ST_CODE=".$sql->Param('c')." AND ST_STORE_QTY > ".$sql->Param('d')." "),array($faccode,'1',$drugid,'0'));
                    print $sql->ErrorMsg();
                    //	echo "BINGOOOOOOOOOOOOOOOOOOOOOOOOOO".$faccode.' '.$drugid.' '.$paymentmethod[0];
                    if ($stmt->RecordCount()>0){

                        while ($obj=$stmt->FetchNextObject()){
                            //check the cost based on nhis or cash
                            if (empty($obj->PPR_NHIS) && $obj->PPR_METHODCODE=='PMT0003'){
                                //if the drug has been absorbed by nhis
                                $cost ='0';
                                $nhis = $obj->PPR_PRICE;
                            }elseif (!empty($obj->PPR_NHIS) && $obj->PPR_METHODCODE=='PMT0003'){
                                //if the drug needs nhis topup
                                $cost = $obj->PPR_NHIS;
                                $nhis =	$obj->PPR_PRICE;
                            }else{
                                //if it is not covered by nhis
                                $cost=$obj->PPR_PRICE;
                                $nhis ='0';
                            }

                            $_SESSION['cartprepare'][$drugid]=array(
                                'CODE'=>$obj->ST_CODE,
                                'NAME'=>$obj->ST_NAME,
                                'DOSAGE'=>$obj->ST_DOSAGE,
                                'SHEL'=>$obj->ST_SHEL_QTY,//where deduction takes place
                                'NHIS'=>$nhis,
                                'COST'=>$cost,
                                'QUANTITY'=>'1',
                                'METHOD'=>$obj->PPR_METHOD,
                                'METHODCODE'=>$obj->PPR_METHODCODE,
                            );
                        }
                    }


                }

                $view="prescdetails";
            }

        }else{
            //if select field is left empty
            $msg='Please select a drug or payment method';
            $status='error';
            $view="prescdetails";
        }
        //print_r($session->get('cartprepare'));

        break;

    case 'prescedittray':
        $cartprepare = $session->get('cartprepare');
        if ($drugcode && !empty($cartprepare)){
            if (array_key_exists($drugcode,$cartprepare))
                $_SESSION['cartprepare'][$drugcode]['QUANTITY']=$quantity;
            $view="prescdetails";
        }else{
            $msg='Please try again!';
            $status='error';
            $view="prescdetails";
        }
        break;

    case 'prescdeletetray'://delete from tray
        //			echo "BINGOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO$drugcode";die($newk);
        $cartprepare = $session->get('cartprepare');
        if ($newk  && !empty($cartprepare)){
            if (array_key_exists($newk,$cartprepare)){
                unset($_SESSION['cartprepare'][$newk]);
            }
        }
        $view="prescdetails";
        break;
    /**END OF PRESCRIPTION PROCESSING**/
    /**BEGINGING OF IMAGE PROCESSING**/
    case 'addtray':
        if (!empty($drugid) /**&& !empty($paymentmethod)**/){
            //echo $drugid;
            //opening a cartprepare
            $cartprepare = $session->get('cartprepare');
            if (empty($cartprepare)){
                //adding a new drug
                //$paymentmethod=(!empty($paymentmethod)?explode('|',$paymentmethod):'');
                $stmt = $sql->Execute($sql->Prepare("SELECT ST_NAME,ST_DOSAGE,ST_SHEL_QTY,PPR_PRICE,PPR_NHIS,ST_CODE,PPR_METHODCODE,PPR_METHOD from hms_pharmacystock JOIN hms_pharmacyprice ON ST_CODE=PPR_DRUGCODE WHERE ST_FACICODE =".$sql->Param('a')." AND ST_STATUS=".$sql->Param('b')." AND ST_CODE =".$sql->Param('c')." AND ST_STORE_QTY > ".$sql->Param('d')." "),array($faccode,'1',$drugid,'0'));
                if ($stmt->RecordCount()>0){
                    while ($obj=$stmt->FetchNextObject()){
                        //check the cost based on nhis or cash
                        if (empty($obj->PPR_NHIS) && $obj->PPR_METHODCODE=='PMT0003'){
                            //if the drug has been absorbed by nhis
                            $cost ='0';
                            $nhis = $obj->PPR_PRICE;
                        }elseif (!empty($obj->PPR_NHIS) && $obj->PPR_METHODCODE=='PMT0003'){
                            //if the drug needs nhis topup
                            $cost = $obj->PPR_NHIS;
                            $nhis =	$obj->PPR_PRICE;
                        }else{
                            //if it is not covered by nhis
                            $cost=$obj->PPR_PRICE;
                            $nhis ='0';
                        }

                        $_SESSION['cartprepare'][$drugid]=array(
                            'CODE'=>$obj->ST_CODE,
                            'NAME'=>$obj->ST_NAME,
                            'SHEL'=>$obj->ST_SHEL_QTY,//where deduction takes place
                            'DOSAGE'=>$obj->ST_DOSAGE,
                            'NHIS'=>$nhis,
                            'COST'=>$cost,
                            'QUANTITY'=>'1',
                            'METHOD'=>$obj->PPR_METHOD,
                            'METHODCODE'=>$obj->PPR_METHODCODE,
                        );
                    }
                }
                $view="prepareimage";
            }else{
                //if the item is already in the tray increase by 1.
                if (array_key_exists($drugid,$cartprepare)){
                    $_SESSION['cartprepare'][$drugid]['QUANTITY']=$_SESSION['cartprepare'][$drugid]['QUANTITY'] +1;
                }else{
                    //echo "BooooooooooooooooooooooooooooM"; die();
                    $paymentmethod=(!empty($paymentmethod)?explode('|',$paymentmethod):'');

                    //if it is a new drug after the cartprepare has been opened
                    $stmt = $sql->Execute($sql->Prepare("SELECT ST_NAME,ST_DOSAGE,ST_SHEL_QTY,PPR_PRICE,PPR_NHIS,ST_CODE,PPR_METHODCODE,PPR_METHOD from hms_pharmacystock JOIN hms_pharmacyprice ON ST_CODE=PPR_DRUGCODE WHERE ST_FACICODE =".$sql->Param('a')." AND ST_STATUS=".$sql->Param('b')." AND ST_CODE=".$sql->Param('c')." AND ST_STORE_QTY > ".$sql->Param('d')." "),array($faccode,'1',$drugid,'0'));
                    print $sql->ErrorMsg();
                    //	echo "BINGOOOOOOOOOOOOOOOOOOOOOOOOOO".$faccode.' '.$drugid.' '.$paymentmethod[0];
                    if ($stmt->RecordCount()>0){

                        while ($obj=$stmt->FetchNextObject()){
                            //check the cost based on nhis or cash
                            if (empty($obj->PPR_NHIS) && $obj->PPR_METHODCODE=='PMT0003'){
                                //if the drug has been absorbed by nhis
                                $cost ='0';
                                $nhis = $obj->PPR_PRICE;
                            }elseif (!empty($obj->PPR_NHIS) && $obj->PPR_METHODCODE=='PMT0003'){
                                //if the drug needs nhis topup
                                $cost = $obj->PPR_NHIS;
                                $nhis =	$obj->PPR_PRICE;
                            }else{
                                //if it is not covered by nhis
                                $cost=$obj->PPR_PRICE;
                                $nhis ='0';
                            }

                            $_SESSION['cartprepare'][$drugid]=array(
                                'CODE'=>$obj->ST_CODE,
                                'NAME'=>$obj->ST_NAME,
                                'DOSAGE'=>$obj->ST_DOSAGE,
                                'SHEL'=>$obj->ST_SHEL_QTY,//where deduction takes place
                                'NHIS'=>$nhis,
                                'COST'=>$cost,
                                'QUANTITY'=>'1',
                                'METHOD'=>$obj->PPR_METHOD,
                                'METHODCODE'=>$obj->PPR_METHODCODE,
                            );
                        }
                    }


                }

                $view="prepareimage";
            }

        }else{
            //if select field is left empty
            $msg='Please select a drug or payment method';
            $status='error';
            $view="prepareimage";
        }
        //print_r($session->get('cartprepare'));

        break;

    case 'edittray':
        $cartprepare = $session->get('cartprepare');
        if ($drugcode && !empty($cartprepare)){
            if (array_key_exists($drugcode,$cartprepare))
                $_SESSION['cartprepare'][$drugcode]['QUANTITY']=$quantity;
            $view="prepareimage";
        }else{
            $msg='Please try again!';
            $status='error';
            $view="prepareimage";
        }
        break;
 	case 'cancelsale'://clear the sales
	//	echo "BooooooooooM"; die();
	$session->del('cartprepare');
	//$view="prepareimage";
	break;

    
    case 'prepareprescription'://prepare the drugs from prescription
        //echo "$visitcode"; die();
       // 	print_r($_REQUEST); die();
        $stmt=$sql->Execute($sql->Prepare("SELECT PRESC_PATIENT,PRESC_PATIENTCODE,PRESC_PATIENTNUM,PRESC_DATE,PRESC_VISITCODE,PRESC_ENCRYPKEY,PRESC_CODE,PRESC_DRUG,PRESC_ID,PRESC_PACKAGECODE from hms_patient_prescription WHERE PRESC_PACKAGECODE=".$sql->Param('a')." "),array($visitcode));
        if ($stmt->RecordCount()>0){
            while ($obj=$stmt->FetchNextObject()){
                $patientname=$obj->PRESC_PATIENT;
                $patientcode=$obj->PRESC_PATIENTCODE;
                $patientnum=$obj->PRESC_PATIENTNUM;
                $prescdate=$obj->PRESC_DATE;
                $prescvisitcode=$obj->PRESC_VISITCODE;
                $prescencrypt=$obj->PRESC_ENCRYPKEY;
                $presccode =$encaes->decrypt($obj->PRESC_DRUG);
                $prescpackagecode = $obj->PRESC_PACKAGECODE;
            }
        }else {
            $patientname="";
            $patientcode="";
            $patientnum="";
            $prescdate="";
            $prescvisitcode="";
            $prescencrypt="";
            $presccode="";
        }
        //	print_r($presccodearray); die();

        //$session->del('salecode');
//        $pendingcode = $engine->getPendingCode();
        $pendingcode = $engine->getPendingCode();
        //$presccode = $engine->getprescriptionCode();
        $salesid = date('Ymdhis').uniqid().$usrcode;
        $cartprepare = $session->get('cartprepare');

        if (!empty($cartprepare)) {
            $counter = count($cartprepare);
            //echo "BOOOOOOOM$counter";die();
            $numcount = 2;
            $stopcount = $counter + $numcount;
            //echo $_POST['drugcode'][$numcount];
            do {
                if ($_POST['type'][$numcount] == 'NEW' && $_POST['cost'][$numcount] > 0) {
                    $newdrugs[] = $numcount;
                }
                if (array_key_exists($_POST['drugcode'][$numcount], $cartprepare)) {
                    $_SESSION['cartprepare'][$_POST['drugcode'][$numcount]]['QUANTITY'] = $_POST['quantity'][$numcount];
                    $_SESSION['cartprepare'][$_POST['drugcode'][$numcount]]['COST'] = $_POST['cost'][$numcount];
                    $numcount++;
                    //echo "Bingoooooo";
                }
            } while ($numcount < $stopcount);
            //print_r($newdrugsarray);die();
				
            $pharmacypricecode = $engine->getpharmacypricecode();
            if(is_array($newdrugs) && count($newdrugs)>0){

            foreach ($newdrugs as $newdrugindex) {

                $newdrugsarray[] = '(
				"' . $_POST['drugname'][$newdrugindex] . '",
				"' . $_POST['dosagename'][$newdrugindex] . '",
				"' . $_POST['dosagecode'][$newdrugindex] . '",
				"' . $_POST['drugcode'][$newdrugindex] . '",
				"' . date('Y-m-d') . '",
				"' . $faccode . '"
			)';
                $newpricearray[] = '(
			
				"' . $pharmacypricecode . '",
				"' . $faccode . '",
				"'.'CASH'.'",
				"'.'PMT0010'.'",
				"'.'PC0001'.'",
				"' . $_POST['drugname'][$newdrugindex] . '",
				"' . $_POST['drugcode'][$newdrugindex] . '",
				"' . $_POST['cost'][$newdrugindex] . '"
			
			)';
                $initial = substr($pharmacypricecode, 0, 3);
                $number = substr($pharmacypricecode, 3, 7);
                $number = str_pad($number + 1, 7, 0, STR_PAD_LEFT);
                $pharmacypricecode = $initial . $number;

            }
        }
     //   print_r($newdrugsarray);echo"BOOOOOM";echo'<br>';
     //   print_r($newpricearray);echo "BoooooM";echo'<br>';
            $newdrugsarray = is_array($newdrugsarray)?implode(',', $newdrugsarray):'';
            $newpricearray = is_array($newpricearray)?implode(',', $newpricearray):'';
            //echo $newdrugsarray;echo '<br>';
            //echo $newpricearray; die();

        }
        $cartprepare=$_SESSION['cartprepare'];
        if(!empty($cartprepare)){
            //print_r($cartprepare);die();
             $finaltotal=0;
            foreach ($cartprepare as $key){
            	$finaltotal=$finaltotal+($key['QUANTITY'] * $key['COST']);
            }
            foreach($cartprepare as $key){
                //  echo $keyname; die();
               if ($key['COST']>0){
                   $total = $key['QUANTITY'] * $key['COST'];
                   $percentapplied = number_format((($instpercentage / 100) * ($key['QUANTITY'] * $key['COST'])),2);
                   $totalwithpercentapplied = $total + $percentapplied;
              /**  $finarray[] = '(
				"'.$pendingcode.'",
				"'.$key['PRESCRIPTIONCODE'].'",
				"'.$patientname.'",
				"'.$patientcode.'",
				"'.$patientnum.'",
				"'.$prescdate.'",
				"'.$prescvisitcode.'",
				"'.$encaes->encrypt(trim($key['CODE'])).'",
				"'.$encaes->encrypt(trim($key['NAME'])).'",
				"'.$key['QUANTITY'].'",
				"'.$key['COST'].'",
				"'.number_format($key['QUANTITY'] * $key['COST'],2).'",
				"'.'2'.'",
				"'.$faccode.'",
				"'.$usrname.'",
				"'.$usrcode.'",
				"'.$faccode.'",
				"'.$faciname.'",
				"'.$prescencrypt.'",
				"'.$key['DOSAGECODE'].'",
				"'.$key['DOSAGENAME'].'",
				"'.$gtotal.'",
				"'.$instpercentage.'",
				"'.number_format((($instpercentage / 100) * ($key['QUANTITY'] * $key['COST'])),2).'",
				"'.number_format($totalwithpercentapplied,2).'",
				"'.$prescpackagecode.'"
            )';**/
            

            $idrugcode = $encaes->encrypt(trim($key['CODE']));
            $idrugname = $encaes->encrypt(trim($key['NAME']));
            $idrugtotal = number_format($key['QUANTITY'] * $key['COST'],2);
            $idrugcommission = number_format((($instpercentage / 100) * ($key['QUANTITY'] * $key['COST'])),2);
            $itotalappperc = number_format($totalwithpercentapplied,2);
						$idrugtotal = str_replace(',', '', $idrugtotal) * 1.0;
						$itotalappperc = str_replace(',', '', $itotalappperc) * 1.0;
						$idrugcommission = str_replace(',', '', $idrugcommission) * 1.0;
												
            $stmt= $sql->Execute($sql->Prepare("INSERT INTO hms_pending_prescription(PEND_CODE,PEND_PRESC_CODE, PEND_PATIENT,PEND_PATIENTCODE, PEND_PATIENTNUM,PEND_DATE,PEND_VISITCODE,PEND_DRUGID,PEND_DRUG,PEND_QUANTITY,PEND_UNITPRICE,PEND_TOTAL,PEND_STATUS,PEND_INSTCODE,PEND_ACTORNAME,PEND_ACTORCODE,PEND_FACICODE,PEND_PHARMNAME,PEND_ENCRYPKEY,PEND_DOSAGECODE,PEND_DOSAGENAME,PEND_GRAND_TOTAL, PEND_PERCENTAGE, PEND_TOTALCOMMISSION,PEND_TOTAL_APPLY_PERCT,PEND_PACKAGECODE)VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('14').",".$sql->Param('15').",".$sql->Param('16').",".$sql->Param('17').",".$sql->Param('18').",".$sql->Param('19').",".$sql->Param('20').",".$sql->Param('21').",".$sql->Param('22').",".$sql->Param('23').",".$sql->Param('24').",".$sql->Param('25').",".$sql->Param('26').")"),array($pendingcode,$key['PRESCRIPTIONCODE'],$patientname,$patientcode,$patientnum,$prescdate,$prescvisitcode,$idrugcode,$idrugname,$key['QUANTITY'],$key['COST'],$idrugtotal,'2',$faccode,$usrname,$usrcode,$faccode,$faciname,$prescencrypt,$key['DOSAGECODE'],$key['DOSAGENAME'],$gtotal,$instpercentage,$idrugcommission,$itotalappperc,$prescpackagecode));
            print $sql->ErrorMsg();

               }
                /**$initial=substr($presccode,0,5);
                $number=substr($presccode,5,7);
                $number=str_pad($number +1,7,0,STR_PAD_LEFT);
                $presccode=$initial.$number;**/
                $initial=substr($pendingcode,0,5);
                $number=substr($pendingcode,5,7);
                $number=str_pad($number +1,7,0,STR_PAD_LEFT);
                $pendingcode=$initial.$number;
            }
	//			print_r($finarray);die();
            $listtomove = is_array($finarray)?implode(',', $finarray):'';
            //INSERT INTO the sales table
            //echo $listtomove; die();
            //echo count($POST['drugcode']);echo '<br>';
//            print_r($listtomove);die();
           /* $stmt= $sql->Execute($sql->Prepare("INSERT INTO hms_pending_prescription(PEND_CODE,PEND_PRESC_CODE, PEND_PATIENT,PEND_PATIENTCODE, PEND_PATIENTNUM,PEND_DATE,PEND_VISITCODE,PEND_DRUGID,PEND_DRUG,PEND_QUANTITY,PEND_UNITPRICE,PEND_TOTAL,PEND_STATUS,PEND_INSTCODE,PEND_ACTORNAME,PEND_ACTORCODE,PEND_FACICODE,PEND_PHARMNAME,PEND_ENCRYPKEY,PEND_DOSAGECODE,PEND_DOSAGENAME,PEND_GRAND_TOTAL, PEND_PERCENTAGE, PEND_TOTALCOMMISSION,PEND_TOTAL_APPLY_PERCT,PEND_PACKAGECODE)VALUES $listtomove"));
            print $sql->ErrorMsg();
            */
            if ($stmt==TRUE){
                if (!empty($newdrugsarray)>0){
                    $stmtins=$sql->Execute($sql->Prepare("INSERT INTO hms_pharmacystock(ST_NAME,ST_DOSAGENAME,ST_DOSAGE,ST_CODE,ST_DATE,ST_FACICODE) VALUES $newdrugsarray"));
                    $stmtinsprice=$sql->Execute($sql->Prepare("INSERT INTO hms_pharmacyprice(PPR_CODE,PPR_FACICODE,PPR_METHOD,PPR_METHODCODE,PPR_CATEGORYCODE,PPR_DRUG,PPR_DRUGCODE,PPR_PRICE) VALUES $newpricearray"));
                }
                //die();
                $stmtupdate=$sql->Execute($sql->Prepare("UPDATE hms_broadcast_prescription SET BRO_STATUS=".$sql->Param('a')." WHERE BRO_PHARMACYCODE=".$sql->Param('b')." AND BRO_PRESCCODE=".$sql->Param('c')." "),array('2',$faccode,$visitcode));
                //deduct quantity from stock
                
                //SMS
                $msgbody = "$faciname has responded to your prescription request. Check your Hewale app for more info.";
                $patientphonenum = $patientCls->getPatientDetails($patientnum)->PATIENT_PHONENUM;
                $phonenumber = $sms->validateNumber($patientphonenum);
                $sms->sendSms($phonenumber,$msgbody);

                $stmt=$sql->Execute($sql->Prepare("SELECT PRESCM_PACKAGECODE from hms_patient_prescription_main WHERE PRESCM_VISITCODE=".$sql->Param('a')." "),array($visitcode));
                if ($stmt->RecordCount()>0){
                    $prescid = $stmt->FetchNextObject()->PRESCM_PACKAGECODE;
                }

                //Eventlog
                $activity = "{$faciname} has prepared patient with patientnum: {$patientnum} prescription request.";
                $engine->setEventLog('119',$activity);
                $engine->ClearNotification('0150',$prescid);

                $view="";
                $msg="Prescription successfully prepared and sent to patient";
                $status="success";
                $session->del('cartprepare');
            }else{
                $view="prescdetails";
                $msg="Prescription could not be prepared, please try again";
                $status="error";

            }
            //	die();

        }else{

            $msg='Please select a drug';
            $status='error';
        }
        break;


        case 'detailshist':

            $stmtdetails = $sql->Execute($sql->Prepare("SELECT PRESC_DRUG,PRESC_QUANTITY,PRESC_DOSAGENAME FROM hms_patient_prescription WHERE PRESC_VISITCODE=".$sql->Param('a')." "),array($keyscode));
            print $sql->ErrorMsg();

        break;
        
    case 'prepareimage'://prepare the drugs

        $stmt=$sql->Execute($sql->Prepare("SELECT PRESC_PATIENT,PRESC_PATIENTCODE,PRESC_PATIENTNUM,PRESC_DATE,PRESC_VISITCODE,PRESC_ENCRYPKEY,PRESC_CODE,PRESC_DRUGID from hms_patient_prescription WHERE PRESC_VISITCODE=".$sql->Param('a')." "),array($visitcode));
        if ($stmt->RecordCount()>0){
            while ($obj=$stmt->FetchNextObject()){
                $patientname=$obj->PRESC_PATIENT;
                $patientcode=$obj->PRESC_PATIENTCODE;
                $patientnum=$obj->PRESC_PATIENTNUM;
                $prescdate=$obj->PRESC_DATE;
                $prescvisitcode=$obj->PRESC_VISITCODE;
                $prescencrypt=$obj->PRESC_ENCRYPKEY;
                $presccode =$encaes->decrypt($obj->PRESC_DRUGID);
                $presccodearray["$presccode"]=$obj->PRESC_CODE;

            }
        }else {
            $patientname="";
            $patientcode="";
            $patientnum="";
            $prescdate="";
            $prescvisitcode="";
            $prescencrypt="";
            $prescode="";
        }
        //$session->del('salecode');
        $pendingcode = $engine->getPendingCode();
        $presccode = $engine->getprescriptionCode('hms_patient_prescription','DR','PRESC_CODE');
        $salesid = date('Ymdhis').uniqid().$usrcode;
        $counter= is_array($_POST['code'])?count($_POST['code']):0;
        for($i=1;$i<=$counter;$i++){
            if ($_POST['type'][$i]=='NEW'){
                $newdrugs[]=$i;
            }
            $finarray[] = '(
				"'.$pendingcode.'",
				"'.$presccode.'",
				"'.$patientname.'",
				"'.$patientcode.'",
				"'.$patientnum.'",
				"'.$prescdate.'",
				"'.$prescvisitcode.'",
				"'.$encaes->encrypt($_POST['code'][$i]).'",
				"'.$encaes->encrypt($_POST['drugname'][$i]).'",
				"'.$_POST['quantity'][$i].'",
				"'.$_POST['cost'][$i].'",
				"'.number_format($_POST['quantity'][$i] *$_POST['cost'][$i],2).'",
				"'.'1'.'",
				"'.$faccode.'",
				"'.$usrname.'",
				"'.$usrcode.'",
				"'.$faccode.'",
				"'.$faciname.'",
				"'.$prescencrypt.'"
			)';
            $initial=substr($presccode,0,5);
            $number=substr($presccode,5,7);
            $number=str_pad($number +1,7,0,STR_PAD_LEFT);
            $presccode=$initial.$number;
            $initial=substr($pendingcode,0,5);
            $number=substr($pendingcode,5,7);
            $number=str_pad($number +1,6,0,STR_PAD_LEFT);
            $pendingcode=$initial.$number;
            
        }
        if(count($newdrugs)>0)//if there are new drugs previously not entered
        {
            $pharmacypricecode=$engine->getpharmacypricecode();
            foreach ($newdrugs as $newdrugindex){

                $newdrugsarray[] = '(
				"'.$_POST['drugname'][$newdrugindex].'",
				"'.$_POST['dosagename'][$newdrugindex].'",
				"'.$_POST['dosagecode'][$newdrugindex].'",
				"'.$_POST['code'][$newdrugindex].'",
				"'.date('Y-m-d').'",
				"'.$faccode.'"
			)';
                $newpricearray[] = '(
			
				"'.$pharmacypricecode.'",
				"'.$faccode.'",
				"'.'CASH'.'",
				"'.'PMT0010'.'",
				"'.'PC0001'.'",
				"'.$_POST['drugname'][$newdrugindex].'",
				"'.$_POST['code'][$newdrugindex].'",
				"'.$_POST['cost'][$newdrugindex].'"
			
			)';
                $initial=substr($pharmacypricecode,0,3);
                $number=substr($pharmacypricecode,3,7);
                $number=str_pad($number +1,7,0,STR_PAD_LEFT);
                $pharmacypricecode=$initial.$number;

            }
        }
        $cartprepare = $session->get('cartprepare');
        if(count($_POST['code'])>0){
            /**	foreach($cartprepare as $key){
            $finarray[] = '(
            "'.$broadcastcode.'",
            "'.$presccode.'",
            "'.$patientname.'",
            "'.$patientcode.'",
            "'.$patientnum.'",
            "'.$prescdate.'",
            "'.$prescvisitcode.'",
            "'.$encaes->encrypt($key['CODE']).'",
            "'.$encaes->encrypt($key['NAME']).'",
            "'.$key['QUANTITY'].'",
            "'.$key['COST'].'",
            "'.number_format($key['QUANTITY'] * $key['COST'],2).'",
            "'.'1'.'",
            "'.$faccode.'",
            "'.$usrname.'",
            "'.$usrcode.'",
            "'.$faccode.'",
            "'.$faciname.'",
            "'.$prescencrypt.'"
            )';
            $initial=substr($presccode,0,5);
            $number=substr($presccode,5,7);
            $number=str_pad($number +1,7,0,STR_PAD_LEFT);
            $presccode=$initial.$number;
            $initial=substr($broadcastcode,0,5);
            $number=substr($broadcastcode,5,7);
            $number=str_pad($number +1,7,0,STR_PAD_LEFT);
            $broadcastcode=$initial.$number;
            }**/
            $newdrugsarray = is_array($newdrugsarray)?implode(',', $newdrugsarray):'';
            $newpricearray = is_array($newpricearray)?implode(',', $newpricearray):'';

            //	print_r($_REQUEST);die();
            $listtomove = is_array($finarray)?implode(',', $finarray):'';
            //echo $listtomove; die();
            //INSERT INTO the sales table
            $stmt= $sql->Execute($sql->Prepare("INSERT INTO hms_pending_prescription(PEND_CODE,PEND_PRESC_CODE, PEND_PATIENT,PEND_PATIENTCODE, PEND_PATIENTNUM,PEND_DATE,PEND_VISITCODE,PEND_DRUGID,PEND_DRUG,PEND_QUANTITY,PEND_UNITPRICE,PEND_TOTAL,PEND_STATUS,PEND_INSTCODE,PEND_ACTORNAME,PEND_ACTORCODE,PEND_FACICODE,PEND_PHARMNAME,PEND_ENCRYPKEY)VALUES $listtomove"));
            print $sql->ErrorMsg();
            if ($stmt==TRUE){
                //INSERT NEW DRUGS
                if(count($newdrugs)>0){
                    $stmtins=$sql->Execute($sql->Prepare("INSERT INTO hms_pharmacystock(ST_NAME,ST_DOSAGENAME,ST_DOSAGE,ST_CODE,ST_DATE,ST_FACICODE) VALUES $newdrugsarray"));
                    $stmtinsprice=$sql->Execute($sql->Prepare("INSERT INTO hms_pharmacyprice(PPR_CODE,PPR_FACICODE,PPR_METHOD,PPR_METHODCODE,PPR_CATEGORYCODE,PPR_DRUG,PPR_DRUGCODE,PPR_PRICE) VALUES $newpricearray"));
                }
                $stmtupdate=$sql->Execute($sql->Prepare("UPDATE hms_broadcast_prescription SET BRO_STATUS=".$sql->Param('a')." WHERE BRO_PHARMACYCODE=".$sql->Param('b')." AND BRO_VISITCODE=".$sql->Param('c')." "),array('2',$faccode,$visitcode));
                //deduct quantity from stock
                /**
                foreach ($cartprepare as $key){
                $stmtreset = $sql->Execute($sql->Prepare("UPDATE hms_patient_prescription SET PRESC_VISITCODE=CONCAT(PRESC_VISITCODE,".$sql->Param('a')."),PRESC_STATE=".$sql->Param('b').",PRESC_STATUS=".$sql->Param('c')." WHERE PRESC_INSTCODE=".$sql->Param('d')." AND PRESC_VISITCODE=".$sql->Param('e')." "),array("IMAGEPROCESSED",'6','0',$faccode,$visitcode));
                print $sql->ErrorMsg();
                }
                if ($stmtreset==TRUE){
                $view="";
                $msg="Prescription image successfully prepared";
                $status="success";
                $session->del('cartprepare');

                }**/
                $view="";
                $msg="Prescription image successfully prepared";
                $status="success";
                $session->del('cartprepare');
            }else{
                $view="prepareimage";
                $msg="Prescription could not be prepared, please try again";
                $status="error";

            }
            //	die();

        }else{
            $msg='Please select a drug';
            $status='error';
            $view="prepareimage";
        }
        break;
    case "reset":
        $fdsearch = "";
        break;

    case 'saveimagegrandtotal':
        if (!empty($totalcost)){
            $stmt=$sql->Execute($sql->Prepare("SELECT PRESC_PATIENT,PRESC_PATIENTCODE,PRESC_PATIENTNUM,PRESC_DATE,PRESC_VISITCODE,PRESC_ENCRYPKEY,PRESC_CODE,PRESC_DRUGID,PRESC_ID,PRESC_PACKAGECODE from hms_patient_prescription WHERE PRESC_VISITCODE=".$sql->Param('a')." "),array($visitcode));
            print $sql->ErrorMsg();
            if ($stmt->RecordCount()>0){
                while ($obj=$stmt->FetchNextObject()){
                    $patientname=$obj->PRESC_PATIENT;
                    $patientcode=$obj->PRESC_PATIENTCODE;
                    $patientnum=$obj->PRESC_PATIENTNUM;
                    $prescdate=$obj->PRESC_DATE;
                    $prescvisitcode=$obj->PRESC_VISITCODE;
                    $packagecode=$obj->PRESC_PACKAGECODE;
                    $prescencrypt=$obj->PRESC_ENCRYPKEY;
                    $presccode =$encaes->decrypt($obj->PRESC_DRUGID);
                    $presccodearray["$presccode"]=$obj->PRESC_CODE;
//                    $prescid = $obj->PRESC_ID;
                }
                $totalwithpercent = $totalcost + (($instpercentage /100) * $totalcost);
                $totalcommission = (($instpercentage /100) * $totalcost);
                $pendstate = !empty($imagename)?'2':'3';
                $pendimage = !empty($imagename)?$imagename:$prescription;
                $pendingcode = $engine->getPendingCode();
                $presccode = $engine->getprescriptionCode('hms_patient_prescription','DR','PRESC_CODE');
                $stmt= $sql->Execute($sql->Prepare("INSERT INTO hms_pending_prescription(PEND_CODE,PEND_PRESC_CODE, PEND_PATIENT,PEND_PATIENTCODE, PEND_PATIENTNUM,PEND_DATE,PEND_VISITCODE,PEND_GRAND_TOTAL,PEND_STATUS,PEND_INSTCODE,PEND_ACTORNAME,PEND_ACTORCODE,PEND_FACICODE,PEND_PHARMNAME,PEND_ENCRYPKEY,PEND_IMAGE,PEND_OTHER_GENDER,PEND_OTHER_AGE,PEND_TOTALCOMMISSION,PEND_PERCENTAGE,PEND_TOTAL_APPLY_PERCT,PEND_TOTAL,PEND_STATE,PEND_PACKAGECODE) VALUES (".$sql->Param('1').",".$sql->Param('1').", ".$sql->Param('1').",".$sql->Param('1').", ".$sql->Param('1').",".$sql->Param('1').",".$sql->Param('1').",".$sql->Param('1').",".$sql->Param('1').",".$sql->Param('1').",".$sql->Param('1').",".$sql->Param('1').",".$sql->Param('1').",".$sql->Param('1').",".$sql->Param('1').",".$sql->Param('1').",".$sql->Param('1').",".$sql->Param('1').",".$sql->Param('1').",".$sql->Param('1').",".$sql->Param('1').",".$sql->Param('1').",".$sql->Param('1').",".$sql->Param('1').")"),array($pendingcode,$presccode,$patientname,$patientcode,$patientnum,$prescdate,$prescvisitcode,$totalwithpercent,'2',$faccode,$usrname,$usrcode,$faccode,$faciname,$prescencrypt,$pendimage,$othergender,$otherage,$totalcommission,$instpercentage,$totalwithpercent,$totalcost,$pendstate,$packagecode));
                print $sql->ErrorMsg();
                if ($stmt){
                    $stmtupdate=$sql->Execute($sql->Prepare("UPDATE hms_broadcast_prescription SET BRO_STATUS=".$sql->Param('a')." WHERE BRO_PHARMACYCODE=".$sql->Param('b')." AND BRO_VISITCODE=".$sql->Param('c')." "),array('2',$faccode,$visitcode));
                    print $sql->ErrorMsg();

                    //SMS
                    $msgbody = "$faciname has responded to your prescription request. Check your Hewale app for more info.";
                    $patientphonenum = $patientCls->getPatientDetails($patientnum)->PATIENT_PHONENUM;
                    $phonenumber = $sms->validateNumber($patientphonenum);
                    $sms->sendSms($phonenumber,$msgbody);

                    $stmt=$sql->Execute($sql->Prepare("SELECT PRESCM_PACKAGECODE from hms_patient_prescription_main WHERE PRESCM_VISITCODE=".$sql->Param('a')." "),array($visitcode));
                    if ($stmt->RecordCount()>0){
                        $prescid = $stmt->FetchNextObject()->PRESCM_PACKAGECODE;
                    }

                    //Eventlog
                    $activity = "{$faciname} has sent patient with patientnum: {$patientnum} the Total Cost of {$totalcost} for his/her prescription request.";
                    $engine->setEventLog('119',$activity);
                    $engine->ClearNotification('0150',$prescid);
//                $view="";
                    $msg="Prescription image successfully prepared";
                    $status="success";
                    $session->del('cartprepare');
                }

                //Notification
            }else{
                $msg="This patient has no active or pending prescription.";
                $status="error";
            }
        }else{
            $msg="Total Cost field can not be empty. Enter the Total Cost of the patients prescription to proceed.";
            $status="error";
        }
    break;

    case 'imageprepare':
        $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_prescription_main LEFT JOIN hms_patient_prescription ON PRESCM_VISITCODE=PRESC_VISITCODE WHERE PRESC_VISITCODE = ".$sql->Param('1').""),array($keys));
        print $sql->Errormsg();

        if($stmt->Recordcount() > 0 ){

            $obj = $stmt->FetchNextObject();

            $patient = $obj->PRESC_PATIENT;
            $patientnum= $obj->PRESC_PATIENTNUM;
            $visitcode= $obj->PRESC_VISITCODE;
            //$faccode = $obj->PRESC_FACICODE;
            $pickupcode=$obj->PRESC_PICKUPCODE;
            $pickupdelivery=$obj->PRESC_DEL_STATUS;
            $deliverystatus=$obj->PRESC_DEL_STATUS;
            $patientgender = !empty($patientCls->getPatientDetails($patientnum)->PATIENT_GENDER)?$patientCls->getPatientDetails($patientnum)->PATIENT_GENDER=='M'?'Male':'Female':'';
            $patientage = !empty($patientCls->getPatientDetails($patientnum)->PATIENT_DOB)?$engine->calculateAge($patientCls->getPatientDetails($patientnum)->PATIENT_DOB):'';
            $patientcontact = $patientCls->getPatientDetails($patientnum)->PATIENT_PHONENUM;
            $allergies = $patientCls->getPatientDetails($patientnum)->PATIENT_ALLERGIES;
            $imagename = $obj->PRESCM_IMAGE;
            $othergender = !empty($obj->PRESCM_OTHERGENDER)?($obj->PRESCM_OTHERGENDER === '01')?'Male':'Female':'';
            $otherage = $obj->PRESCM_OTHERAGE;
            $prescriptioncode=$obj->PRESCM_PACKAGECODE;
            $itemcode = $obj->PRESCM_ITEMCODE ;
//                $packagecode = $obj->PRESC_PACKAGECODE;

            $stmtinstpercentage = $sql->Execute($sql->Prepare("SELECT FACI_INST_PERCENTAGE FROM hmsb_allfacilities WHERE FACI_CODE = ".$sql->Param('1')." "),array($faccode));
            print $sql->Errormsg();
            if ($stmtinstpercentage->RecordCount()>0){
                $instpercentage = $stmtinstpercentage->FetchNextObject()->FACI_INST_PERCENTAGE;
            }

        }
    break;

    case 'preparetextprescription':
        $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_prescription_main WHERE PRESCM_VISITCODE = ".$sql->Param('1').""),array($keys));
        print $sql->Errormsg();

        if($stmt->Recordcount() > 0 ){

            $obj = $stmt->FetchNextObject();

            $patient = $obj->PRESCM_PATIENT;
            $patientnum= $obj->PRESCM_PATIENTNUM;
            $visitcode= $obj->PRESCM_VISITCODE;
            //$faccode = $obj->PRESC_FACICODE;
            $pickupcode=$obj->PRESCM_PICKUPCODE;
            $pickupdelivery=$obj->PRESCM_DEL_STATUS;
            $deliverystatus=$obj->PRESCM_DEL_STATUS;
            $prescription=$obj->PRESCM_IMAGE;
            $otherage=$obj->PRESCM_OTHERAGE;
            $prescriptioncode=$obj->PRESCM_PACKAGECODE;
            $othergender = !empty($obj->PRESCM_OTHERGENDER)?($obj->PRESCM_OTHERGENDER == '01')?'Male':'Female':'';
            $patientgender = !empty($patientCls->getPatientDetails($patientnum)->PATIENT_GENDER)?$patientCls->getPatientDetails($patientnum)->PATIENT_GENDER=='M'?'Male':'Female':'';
            $patientage = !empty($patientCls->getPatientDetails($patientnum)->PATIENT_DOB)?$engine->calculateAge($patientCls->getPatientDetails($patientnum)->PATIENT_DOB):'';
            $patientcontact = $patientCls->getPatientDetails($patientnum)->PATIENT_PHONENUM;
            $allergies = $patientCls->getPatientDetails($patientnum)->PATIENT_ALLERGIES;
            $itemcode = $obj->PRESCM_ITEMCODE ;
//                $packagecode = $obj->PRESC_PACKAGECODE;

            $stmtinstpercentage = $sql->Execute($sql->Prepare("SELECT FACI_INST_PERCENTAGE FROM hmsb_allfacilities WHERE FACI_CODE = ".$sql->Param('1')." "),array($faccode));
            print $sql->Errormsg();
            if ($stmtinstpercentage->RecordCount()>0){
                $instpercentage = $stmtinstpercentage->FetchNextObject()->FACI_INST_PERCENTAGE;
            }

        }
    break;

    case 'viewpresc':
        if (isset($keys) && !empty($keys)){
            $stmt=$sql->Execute($sql->Prepare("SELECT PRESCM_PATIENT,PRESCM_PATIENTCODE,PRESCM_PATIENTNUM,PRESCM_DATE,PRESCM_VISITCODE,PRESCM_ENCRYPKEY,PRESCM_PACKAGECODE,PRESCM_ITEMCODE FROM hms_patient_prescription_main WHERE PRESCM_PACKAGECODE=".$sql->Param('a')." "),array($keys));
            if ($stmt->RecordCount()>0){
                $obj=$stmt->FetchNextObject();
                $patientfullname=$obj->PRESCM_PATIENT;
                $patientcode=$obj->PRESCM_PATIENTCODE;
                $patientnum=$obj->PRESCM_PATIENTNUM;
                $prescdate=$obj->PRESCM_DATE;
                $prescvisitcode=$obj->PRESCM_VISITCODE;
                $prescencrypt=$obj->PRESCM_ENCRYPKEY;
                $prescriptioncode=$obj->PRESCM_PACKAGECODE;
                $presccode =$encaes->decrypt($obj->PRESC_DRUG);
                $patientgender = $patientCls->getPatientDetails($patientnum)->PATCON_GENDER;
                $patientage = $engine->calculateAge($patientCls->getPatientDetails($patientnum)->PATCON_DOB);
                $patientcontact = $patientCls->getPatientDetails($patientnum)->PATCON_PHONENUM;
                $allergies = $patientCls->getPatientDetails($patientnum)->PATIENT_ALLERGIES;
                $itemcode = $obj->PRESCM_ITEMCODE ;
            }
            $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_pending_prescription JOIN hms_broadcast_prescription ON BRO_PRESCCODE = PEND_PACKAGECODE WHERE PEND_PACKAGECODE = ".$sql->Param('a')." AND PEND_FACICODE = ".$sql->Param('a')." AND BRO_STATUS = ".$sql->Param('b')),array($keys,$faccode,'2'));
            print $sql->ErrorMsg();
            $result = array();
            if ($stmt->RecordCount() > 0){
                $result = $stmt->GetAll();
            }
            $totalview = number_format($result[0]['PEND_GRAND_TOTAL'], 2);
            $patientnum = $result[0]['PEND_PATIENTNUM'];
            $patientprescimage = $result[0]['PEND_IMAGE'];
            $otherage = $result[0]['PEND_OTHER_AGE'];
            $othergender = $result[0]['PEND_OTHER_GENDER'];
            $totalamount = $result[0]['PEND_GRAND_TOTAL'];
            $totalcost = $result[0]['PEND_TOTAL'];
            $instpercentage = $result[0]['PEND_PERCENTAGE'];
            $patientage = $engine->calculateAge($patientCls->getPatientDetails($patientnum)->PATCON_DOB);
            $patientgender = $patientCls->getPatientDetails($patientnum)->PATCON_GENDER;
            $patientcontact = $patientCls->getPatientDetails($patientnum)->PATCON_PHONENUM;
//            print_r($result);
        }
    break;

    case 'viewimage':
        if (isset($keys) && !empty($keys)){
            $stmt=$sql->Execute($sql->Prepare("SELECT PRESCM_PATIENT,PRESCM_PATIENTCODE,PRESCM_PATIENTNUM,PRESCM_DATE,PRESCM_VISITCODE,PRESCM_ENCRYPKEY,PRESCM_PACKAGECODE,PRESCM_ITEMCODE FROM hms_patient_prescription_main WHERE PRESCM_VISITCODE=".$sql->Param('a')." "),array($visitcode));
            if ($stmt->RecordCount()>0){
                $obj=$stmt->FetchNextObject();
                $patientfullname=$obj->PRESCM_PATIENT;
                $patientcode=$obj->PRESC_PATIENTCODE;
                $patientnum=$obj->PRESC_PATIENTNUM;
                $prescdate=$obj->PRESC_DATE;
                $prescvisitcode=$obj->PRESC_VISITCODE;
                $prescencrypt=$obj->PRESC_ENCRYPKEY;
                $prescriptioncode = $obj->PRESCM_PACKAGECODE;
                $allergies = $patientCls->getPatientDetails($patientnum)->PATIENT_ALLERGIES;
                $presccode =$encaes->decrypt($obj->PRESC_DRUG);
                $itemcode = $obj->PRESCM_ITEMCODE ;
            }
            $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_pending_prescription JOIN hms_broadcast_prescription ON BRO_VISITCODE=PEND_VISITCODE WHERE PEND_VISITCODE = ".$sql->Param('a')." AND PEND_FACICODE = ".$sql->Param('a')." AND BRO_STATUS = ".$sql->Param('b')),array($keys,$faccode,'2'));
            print $sql->ErrorMsg();
            $result = array();
            if ($stmt->RecordCount() > 0){
                $result = $stmt->GetAll();
            }
            $totalview = $result[0]['PEND_GRAND_TOTAL'];
            $patientnum = $result[0]['PEND_PATIENTNUM'];
            $patientprescimage = $result[0]['PEND_IMAGE'];
            $otherage = $result[0]['PEND_OTHER_AGE'];
            $othergender = $result[0]['PEND_OTHER_GENDER'];
            $totalamount = $result[0]['PEND_GRAND_TOTAL'];
            $totalcost = $result[0]['PEND_TOTAL'];
            $instpercentage = $result[0]['PEND_PERCENTAGE'];
            $patientage = $engine->calculateAge($patientCls->getPatientDetails($patientnum)->PATCON_DOB);
            $patientgender = $patientCls->getPatientDetails($patientnum)->PATCON_GENDER;
            $patientcontact = $patientCls->getPatientDetails($patientnum)->PATCON_PHONENUM;
//            print_r($result);
        }
    break;

    case 'deletefrombroadcastlist':
        // This case deletes patients prescription from the broadcast prescription table or list.
        if (isset($keys) && !empty($keys)){
            $stmt = $sql->Execute($sql->Prepare("UPDATE hms_broadcast_prescription SET BRO_STATUS = ".$sql->Param('a')." WHERE BRO_PHARMACYCODE = ".$sql->Param('b')." AND (BRO_PRESCCODE = ".$sql->Param('c')." OR BRO_VISITCODE = ".$sql->Param('d').")"),array('0',$faccode,$keys,$keys));
            if ($stmt){
                $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_pending_prescription WHERE PEND_PACKAGECODE = ".$sql->Param('a')." AND PEND_FACICODE = ".$sql->Param('b')),array($keys,$faccode));
                if ($stmt->RecordCount() > 0){
                  $stmt = $sql->Execute($sql->Prepare("UPDATE hms_pending_prescription SET PEND_STATUS = ".$sql->Param('a')." WHERE PEND_FACICODE = ".$sql->Param('b')." AND PEND_PACKAGECODE = ".$sql->Param('c')),array('0',$faccode,$keys));
                }
                $msg = "You have successfully deleted prescription with prescription code {$keys}.";
                $status = "success";
                // Event Log
                $activity = "Pharmacy with pharmacycode {$faccode} has deleted prescription with prescriptioncode {$keys} from their prescription broadcast list.";
                $engine->setEventLog('122',$activity);
            }else{
                $msg = "There was an error trying to delete this prescription. ".$sql->ErrorMsg();
                $status = "error";
            }
        }
    break;

}

include ('model/js.php');

if(isset($keys) && !empty($keys)){
    $stmtprescription=$sql->Execute($sql->Prepare("SELECT PRESC_DRUG,PRESC_QUANTITY,PRESC_DOSAGENAME,PRESC_PATIENT from hms_patient_prescription WHERE PRESC_PACKAGECODE=".$sql->Param('a')." "),array($keys));
    if($stmtprescription->RecordCount()>0){
        while($objpresc=$stmtprescription->FetchNextObject()){
            $patientfullname=$objpresc->PRESC_PATIENT;
            $prescarray[]=array($objpresc->PRESC_PATIENT,$objpresc->PRESC_DRUG,$objpresc->PRESC_QUANTITY,$objpresc->PRESC_DOSAGENAME);
        }
    }else{
        $prescarray=array();
    }
}

//$stmtdrugs = $sql->Execute($sql->Prepare("SELECT DR_NAME ST_NAME,IFNULL(ST_DOSAGE,DR_DOSAGENAME) ST_DOSAGE,IFNULL(ST_SHEL_QTY,'0')ST_SHEL_QTY,IFNULL(ST_STORE_QTY,0)ST_STORE_QTY,IFNULL(PPR_PRICE,0) PPR_PRICE,IFNULL(PPR_NHIS,0)PPR_NHIS,IFNULL(ST_CODE,DR_CODE) ST_CODE from hms_pharmacystock JOIN hms_pharmacyprice ON ST_CODE=PPR_DRUGCODE RIGHT JOIN hmsb_st_phdrugs ON DR_CODE=ST_CODE WHERE (ST_FACICODE =".$sql->Param('a')." OR DR_INSDT IS NULL) AND (ST_STATUS=".$sql->Param('b')." OR DR_STATUS =".$sql->Param('c').") "),array($faccode,'1','1'));

if($view=='prepareprescription'){
$stmtdrugs = $sql->Execute($sql->Prepare("SELECT ST_NAME,ST_DOSAGENAME ST_DOSAGE,ST_SHEL_QTY,ST_STORE_QTY,IFNULL(PPR_PRICE,0) PPR_PRICE,IFNULL(PPR_NHIS,0)PPR_NHIS,ST_CODE from hms_pharmacystock JOIN hms_pharmacyprice ON ST_CODE=PPR_DRUGCODE WHERE ST_FACICODE =".$sql->Param('a')." AND PPR_METHODCODE=".$sql->Param('b')." AND ST_STATUS=".$sql->Param('c')." "),array($faccode,'PMT0010','1'));
		if($stmtdrugs->RecordCount()>0){
		while($objdrugs=$stmtdrugs->FetchNextObject()){
			$drugsarray[$objdrugs->ST_CODE]=array('ST_NAME'=>$objdrugs->ST_NAME,'ST_DOSAGENAME'=>$objdrugs->ST_DOSAGENAME,'ST_DOSAGE'=>$objdrugs->ST_DOSAGE,'ST_SHEL_QTY'=>$objdrugs->ST_SHEL_QTY,'ST_STORE_QTY'=>$objdrugs->ST_STORE_QTY,'PPR_PRICE'=>$objdrugs->PPR_PRICE,'PPR_NHIS'=>$objdrugs->PPR_NHIS,'ST_CODE'=>$objdrugs->ST_CODE);
		}
	}
$stmtdrugs1=$sql->Execute($sql->Prepare("SELECT DR_NAME ST_NAME,DR_DOSAGENAME ST_DOSAGE,'0' ST_SHEL_QTY,'0' ST_STORE_QTY,'0' PPR_PRICE,'0' PPR_NHIS,DR_CODE ST_CODE from hmsb_st_phdrugs WHERE DR_CODE NOT IN(SELECT ST_CODE from hms_pharmacystock JOIN hms_pharmacyprice ON ST_CODE=PPR_DRUGCODE WHERE ST_FACICODE=".$sql->Param('a')." AND PPR_METHODCODE=".$sql->Param('b')." AND ST_STATUS=".$sql->Param('c')." ) AND DR_STATUS =".$sql->Param('c')." "),array($faccode,'PMT0010','1','1'));
	if($stmtdrugs1->RecordCount()>0){
		while($objdrugs1=$stmtdrugs1->FetchNextObject()){
			$drugs1array[$objdrugs1->ST_CODE]=array('ST_NAME'=>$objdrugs1->ST_NAME,'ST_DOSAGENAME'=>$objdrugs1->ST_DOSAGENAME,'ST_DOSAGE'=>$objdrugs1->ST_DOSAGE,'ST_SHEL_QTY'=>$objdrugs1->ST_SHEL_QTY,'ST_STORE_QTY'=>$objdrugs1->ST_STORE_QTY,'PPR_PRICE'=>$objdrugs1->PPR_PRICE,'PPR_NHIS'=>$objdrugs1->PPR_NHIS,'ST_CODE'=>$objdrugs1->ST_CODE);
		}
	}

	$finaldrugsarray=array_merge($drugsarray,$drugs1array);
	//$finaldrugsarray=sort($drugsarray);
	function compareByName($finaldrugsarray, $b) {
	  return strcmp($finaldrugsarray["ST_NAME"], $b["ST_NAME"]);
	}
	usort($finaldrugsarray, 'compareByName');
	

}

//Drugs
$stmtdrugslov = $sql->Execute($sql->Prepare("SELECT * FROM hmsb_st_phdrugs order by DR_NAME ")) ;
$druglists = '';
while($objdpt = $stmtdrugslov->FetchNextObject()){
    $druglists .= "<option value=".$objdpt->DR_CODE.'@@@'.$objdpt->DR_NAME.'@@@'.$objdpt->DR_DOSAGE.'@@@'.$objdpt->DR_DOSAGENAME.">$objdpt->DR_NAME</option>";
}
//echo $druglists;
//if ($stmtdrugslov){
//    $alldrugs = $stmtdrugslov->GetAll();
//}

$stmt = $sql->Execute($sql->Prepare("SELECT DISTINCT PRESCM_VISITCODE,PRESCM_PATIENT,PRESCM_PATIENTNUM,PRESCM_DATE,PRESCM_STATUS,PRESCM_PICKUPCODE,PRESCM_COUR_NAME,PRESCM_STATE,BRO_STATUS,BRO_IMAGENAME,BRO_VISITCODE,BRO_STATE,PRESCM_PACKAGECODE,PRESCM_ITEMCODE FROM hms_patient_prescription_main JOIN hms_broadcast_prescription ON PRESCM_VISITCODE=BRO_VISITCODE WHERE PRESCM_STATUS IN ('1','2') AND BRO_PHARMACYCODE = ".$sql->Param('a')." AND BRO_STATUS = ".$sql->Param('b').""),array($faccode,'1'));
print $sql->ErrorMsg();

if($stmt) {
    $total_pending = $stmt->RecordCount();
//    echo json_encode($total_pending);
}

if(!empty($fdsearch)){
    $query = "SELECT DISTINCT PRESCM_PATIENTNUM,PRESCM_VISITCODE,PRESCM_PATIENT,PRESCM_DATE,PRESCM_PICKUPCODE,PRESCM_STATUS,PRESCM_COUR_NAME,PRESCM_STATE,BRO_STATUS,BRO_IMAGENAME,BRO_VISITCODE,BRO_STATE,PRESCM_PACKAGECODE,PRESCM_ITEMCODE FROM hms_patient_prescription_main JOIN hms_broadcast_prescription ON PRESCM_VISITCODE=BRO_VISITCODE WHERE PRESCM_STATUS IN ('1','2') AND BRO_PHARMACYCODE = ".$sql->Param('a')." AND BRO_STATUS IN ('1','2') AND (PRESCM_PICKUPCODE LIKE ".$sql->Param('h')." OR PRESCM_PATIENT LIKE ".$sql->Param('j')." OR PRESCM_PATIENTNUM LIKE ".$sql->Param('j')." OR PRESCM_PACKAGECODE LIKE ".$sql->Param('j')." )";
    $input = array($faccode,'%'.$fdsearch.'%','%'.$fdsearch.'%','%'.$fdsearch.'%','%'.$fdsearch.'%');
    print $sql->ErrorMsg();
}else {//1=> Pending Preparation, 2=>Prepared , 3=>Purchase, 4=>Completed
    $query = "SELECT DISTINCT PRESCM_VISITCODE,PRESCM_PATIENT,PRESCM_PATIENTNUM,PRESCM_DATE,PRESCM_STATUS,PRESCM_PICKUPCODE,PRESCM_COUR_NAME,PRESCM_STATE,BRO_STATUS,BRO_IMAGENAME,BRO_VISITCODE,BRO_STATE,PRESCM_PACKAGECODE,PRESCM_IMAGE,PRESCM_ITEMCODE FROM hms_patient_prescription_main JOIN hms_broadcast_prescription ON PRESCM_VISITCODE=BRO_VISITCODE WHERE PRESCM_STATUS IN ('1','2') AND BRO_PHARMACYCODE = ".$sql->Param('a')." AND BRO_STATUS IN ('1','2')" ;
    $input = array($faccode);
}
if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,"index.php?pg={$pg}&option={$option}",$input);

//$queryBroad = "SELECT * FROM hms_pending_prescription WHERE PEND_FACICODE = ".$sql->Param('a')." AND PEND_STATUS =  ".$sql->Param('b') ;
//$input = array($faccode,'1');
//$pagingBroad = new OS_Pagination($sql,$queryBroad,$limit,$lenght,"index.php?pg={$pg}&option={$option}",$input);
//die(var_dump($pagingBroad));
//Get all positions
$stmtpos = $engine->getUserPosition();

?>