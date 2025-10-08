<?php 

$crypt = new cryptCls();
$actorid = $session->get("userid");
$actorname = $engine->getActorName();
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$objdtls = $engine->getFacilityDetails();
$facilityalias = $objdtls->FACI_ALIAS ;
$faccode = $objdtls->FACI_CODE ;
$patientCls = new patientClass();
$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);

switch ($viewpage){
    case "testdetails":
		$stmt = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest_main WHERE LTM_PACKAGECODE = ".$sql->Param('1')."   "),array($keys));
		print $sql->Errormsg();
			
		if($stmt->Recordcount() > 0){

			$obj = $stmt->FetchNextObject();
			$patient = $obj->LTM_PATIENTNAME;
			$patientnum = $obj->LTM_PATIENTNUM;
			$patientcode = $obj->LTM_PATIENTCODE;
			$packagecode = $obj->LTM_PACKAGECODE;
			$patientdate = $obj->LTM_DATE;
			$medic = $obj->LTM_ACTORNAME;
			$Total  = $obj->LTM_TOTAL_AMOUNT;
			$visitcode  = $obj->LTM_VISITCODE;
			$homeservicestatus  = $obj->LTM_HOMESERVICE;
			$patientlocation  = $obj->LTM_PATIENT_LOCATION;

			$patientcontact = $patientCls->getPatientDetails($patientnum)->PATIENT_PHONENUM ;
			$patientgender = $patientCls->getPatientDetails($patientnum)->PATIENT_GENDER ;
	
		}

		$stmtlisttestdetails = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_PACKAGECODE = ".$sql->Param('1')." and LT_STATUS IN ('1','2','3','4','8') "),array($keys));
		print $sql->Errormsg();   

	break;

    case 'resultdone':
        if(!empty($keys)){
            $stmtcheck = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest_main WHERE LTM_PACKAGECODE = ".$sql->Param('1').""), array($packagecode));
            print $sql->Errormsg();

            if($stmtcheck->Recordcount() > 0){
                $hewalepercentage = 10;
                $hewalepercentageamount = floatval(($hewalepercentage / 100) * floatval($totalamounts));
                $hewaletotalamount = floatval($totalamounts + $hewalepercentageamount);

                $stmtlabmain = $sql->Execute($sql->Prepare("UPDATE hms_patient_labtest_main SET LTM_STATUS = ".$sql->Param('a').", LTM_TOTAL_AMOUNT = ".$sql->Param('b').", LTM_TOTALDUE_LAB = ".$sql->Param('c').",LTM_TOTALDUE_HEWALE = ".$sql->Param('d').", LTM_PERCENTAGE_APPLIED = ".$sql->Param('e')." WHERE LTM_PACKAGECODE = ".$sql->Param('f')." "),array('2', $hewaletotalamount, $totalamounts, $hewalepercentageamount, $hewalepercentage, $packagecode));
                
                $stmtlab = $sql->Execute($sql->Prepare("UPDATE hms_patient_labtest SET LT_STATUS = ".$sql->Param('a')." WHERE LT_PACKAGECODE = ".$sql->Param('b')." "),array('2', $packagecode));

                if($stmtlabmain && $stmtlab){
                    $msg = "Success! Lab Result has been save successfully";
                    $status = "success";
                    $view ='';	
                } else {
                    $msg = $sql->Errormsg();
                    $status = "error";
                    $view ='';	
                }
            } else {

                $msg = "Failed! Pending lab Result";
                $status = "error";
                $view ='labdetails';	
            }
        }else{
            $msg = "Failed! Required Fields can't be empty";
            $status = "error";
            $view ='labdetails';	
        }
	break;
}


// $stmtlisttestdetails = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_PACKAGECODE = ".$sql->Param('1')." and  LT_STATUS IN ('3','6','8')   "),array($keys));
// print $sql->Errormsg();

$stmtlisttestsampledetails = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_PACKAGECODE = ".$sql->Param('1')." and  LT_STATUS IN ('3','4','8')   "),array($keys));
print $sql->Errormsg();

$stmtlisttestresults = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labresult_files WHERE LTMI_LTCODE = ".$sql->Param('1')." and LTMI_STATUS = ".$sql->Param('2')." "),array($requestcode,'1'));
print $sql->Errormsg();


$stmtspecimen = $sql->Execute($sql->prepare("SELECT * from hmsb_st_labspecimen where SP_STATUS = ".$sql->Param('a').""),array('1'));


if(!empty($fdsearch)){
    $query = "SELECT LTM_VISITCODE,LTM_DATE,LTM_PATIENTNUM,LTM_PATIENTCODE,LTM_PATIENTNAME,LTM_RMK,LTM_ACTORCODE,LTM_ACTORNAME,LTM_INSTCODE,LTM_TOTAL_AMOUNT,LTM_PACKAGECODE FROM hms_patient_labtest_main WHERE LTM_LABCODE = ".$sql->Param('a')." AND LTM_STATUS IN ('2','3') AND LTM_HOMESERVICE IN ('1','2') AND (LTM_PATIENTNAME LIKE ".$sql->Param('c')." OR LTM_PATIENTNUM LIKE ".$sql->Param('d')." ) ";
    $input = array($faccode,'%'.$fdsearch.'%','%'.$fdsearch.'%');
}else {
    
    $query = "SELECT LTM_VISITCODE,LTM_DATE,LTM_PATIENTNUM,LTM_PATIENTCODE,LTM_PATIENTNAME,LTM_RMK,LTM_ACTORCODE,LTM_ACTORNAME,LTM_INSTCODE,LTM_TOTAL_AMOUNT,LTM_PACKAGECODE FROM hms_patient_labtest_main WHERE LTM_STATUS IN ('2','3') AND LTM_HOMESERVICE IN ('1','2') AND LTM_LABCODE = ".$sql->Param('b')." ";
    $input = array($faccode);
}


if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=e684d8eeee72ed2583865b78e8d3f57a&option=85401ead437783774ed80a3807ed532a&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);

//Get all positions
$stmtpos2 = $engine->getUserPosition();
//include 'model/js.php';

?>