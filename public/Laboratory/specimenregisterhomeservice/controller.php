<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 8/8/2017
 * Time: 5:14 PM
 */

//var_dump($_POST);
$crypt = new cryptCls();
$actorid = $session->get("userid");
$actorname = $engine->getActorName();
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$objdtls = $engine->getFacilityDetails();
$facilityalias = $objdtls->FACI_ALIAS ;
$faccode = $objdtls->FACI_CODE ;
$patientCls = new patientClass();


//print_r($_POST);
//echo $keys;
switch ($viewpage){
    
	case "testdetails":

        $stmt = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest_main WHERE LTM_PACKAGECODE = ".$sql->Param('1')." "),array($keys));
        print $sql->Errormsg();
    
        if($stmt->Recordcount() > 0){

            $obj = $stmt->FetchNextObject();
            $patient = $obj->LTM_PATIENTNAME;
            $patientnum = $obj->LTM_PATIENTNUM;
            $patientcode = $obj->LTM_PATIENTCODE;
            $packagecode = $obj->LTM_PACKAGECODE;
            $patientdate = $obj->LTM_DATE;
            $medic = $obj->LTM_ACTORNAME;
            $total  = $obj->LTM_TOTAL_AMOUNT;
            $labsource  = $obj->LTM_SOURCE;

            $patientcontact = $patientCls->getPatientDetails($patientnum)->PATIENT_PHONENUM ;
            $patientgender = $patientCls->getPatientDetails($patientnum)->PATIENT_GENDER ;

        }

        $stmtlisttestdetails = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_PACKAGECODE = ".$sql->Param('1').""),array($keys));
        print $sql->Errormsg();
        // print_r($stmtlisttestdetails->GetAll());

    break;

    case "takesample":
        // print_r($_POST);die(' dying ');
		$stmt = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_CODE = ".$sql->Param('1')."   "),array($vkey));
		print $sql->Errormsg();
			
		if($stmt->Recordcount() > 0){

			$obj = $stmt->FetchNextObject();
			$requestcode = $obj->LT_CODE;
			$testname = $encaes->decrypt($obj->LT_TESTNAME);
			$packagecode = $obj->LT_PACKAGECODE;
			$discpline = $obj->LT_DISCPLINENAME;
            $label = $obj->LT_SPECIMENLABEL;
            $volume = $obj->LT_SPECIMENVOLUME;
            $remark = $encaes->decrypt($obj->LT_SPECIMENREMARK);
            $specimencode = $encaes->decrypt($obj->LT_SPECIMENCODE);
            $specimenname = $encaes->decrypt($obj->LT_SPECIMEN);
            $sample = $specimencode.'@@@'.$specimenname;

		}

	break;

    case "savesample":
        if(empty($vkey)  || empty($sample) || empty($label) || empty($volume)  ){

            $msg = "Failed. Required field(s) can't be empty!.";
            $status = "error";
            $view ='takesample';
            
        }else{

            $sp = explode('@@@' , $sample);
            $scode = $sp['0'];
            $sname = $sp['1'];
            $scodes = $encaes->encrypt($scode);
            $snames = $encaes->encrypt($sname);
            $remark = $encaes->encrypt($remark);
            $startdate = date('Y-m-d');
            $dt = Date("Y-m-d", strtotime(str_replace('/','-', $startdate)));
            
            $stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_labtest SET LT_SPECIMEN =".$sql->Param('1').", LT_SPECIMENCODE =".$sql->Param('2')." ,LT_SPECIMENLABEL  =".$sql->Param('3')." ,LT_SPECIMENVOLUME =".$sql->Param('4')." ,LT_SPECIMENDATE =".$sql->Param('5')." ,LT_STATUS =".$sql->Param('6').", LT_SPECIMENACTOR =".$sql->Param('7').", LT_SPECIMENACTORCODE =".$sql->Param('8')." , LT_SPECIMENSTATE =".$sql->Param('8').", LT_SPECIMENREMARK =".$sql->Param('8')." WHERE LT_CODE=".$sql->Param('10')." "),array($snames,$scodes,$label,$volume,$dt,'4',$actorid,$actorname,'1',$remark,$vkey));
            print $sql->ErrorMsg();

            // Check to if all test samples are taken then set lab main status to indicate so (4)
            $stmt = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_PACKAGECODE = ".$sql->Param('1')." AND LT_STATUS < ".$sql->Param('2')),array($keys, '4'));
            print $sql->Errormsg();
            if($stmt->Recordcount() < 1){
                // Update Lab main to 4
                $stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_labtest_main SET LTM_STATUS =".$sql->Param('1').", LTM_SAMPLESTATE =".$sql->Param('2')." WHERE LTM_PACKAGECODE = ".$sql->Param('3')." "),array('4','1',$keys));
                print $sql->ErrorMsg();

                $view ='list';
            } else {
                $view ='labsample';
            }

            $stmt = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest_main WHERE LTM_PACKAGECODE = ".$sql->Param('1')." "),array($keys));
            print $sql->Errormsg();
        
            if($stmt->Recordcount() > 0){

                $obj = $stmt->FetchNextObject();
                $patient = $obj->LTM_PATIENTNAME;
                $patientnum = $obj->LTM_PATIENTNUM;
                $patientcode = $obj->LTM_PATIENTCODE;
                $packagecode = $obj->LTM_PACKAGECODE;
                $patientdate = $obj->LTM_DATE;
                $medic = $obj->LTM_ACTORNAME;
                $total  = $obj->LTM_TOTAL_AMOUNT;

                $patientcontact = $patientCls->getPatientDetails($patientnum)->PATIENT_PHONENUM ;
                $patientgender = $patientCls->getPatientDetails($patientnum)->PATIENT_GENDER ;

            }
            
            $stmtlisttestdetails = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_PACKAGECODE = ".$sql->Param('1').""),array($keys));
            print $sql->Errormsg();
            // print_r($_POST);

            $msg = "Success! Sample has been save successfully";
            $status = "success";

        }
	
	break;

    case 'sampletaken':
        if (!empty($keys)) {
            // Specimen Sample Taken
            $stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_labtest_main SET LTM_STATUS =".$sql->Param('1').", LTM_SAMPLESTATE =".$sql->Param('2')." WHERE LTM_PACKAGECODE = ".$sql->Param('3')." "),array('4','1',$keys));
            print $sql->ErrorMsg();

            if ($stmt) {
                $stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_labtest SET LT_STATUS =".$sql->Param('1')." WHERE LT_PACKAGECODE = ".$sql->Param('2')." "),array('4',$keys));
                print $sql->ErrorMsg();
            }

            $msg = "Success! Sample has been taken successfully";
            $status = "success";
        }
    break;
    
}
include 'model/js.php';

$statusdesc = ['1'=>'Unassigned', '2'=>'Pending', '3'=>'Paid', '4'=>'Specimen Taken', '5'=>'Processing', '6'=>'Result Ready', '7'=>'Result Signoff'];

$stmtlisttestsampledetails = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_PACKAGECODE = ".$sql->Param('1')." and  LT_SPECIMENSTATE = ".$sql->Param('1')." "),array($keys,'0'));
print $sql->Errormsg();

$stmtspecimen = $sql->Execute($sql->prepare("SELECT * from hmsb_st_labspecimen where SP_STATUS = ".$sql->Param('a').""),array('1'));

if(!empty($fdsearch)){

    $query = "SELECT LTM_VISITCODE,LTM_DATE,LTM_PATIENTNUM,LTM_PATIENTCODE,LTM_PATIENTNAME,LTM_RMK,LTM_ACTORCODE,LTM_ACTORNAME,LTM_INSTCODE,LTM_TOTAL_AMOUNT,LTM_PACKAGECODE,LTM_STATUS FROM hms_patient_labtest_main WHERE LTM_LABCODE = ".$sql->Param('a')." AND LTM_STATUS = ".$sql->Param('a')." AND LTM_SAMPLESTATE  ".$sql->Param('b')." AND LTM_SOURCE = ".$sql->Param('e') ." AND LTM_HOMESERVICE IN ('1','2') AND (LTM_PATIENTNAME LIKE ".$sql->Param('c')." OR LTM_PATIENTNUM LIKE ".$sql->Param('d')."  ) ";
   $input = array($faccode,'3','0','1','%'.$fdsearch.'%','%'.$fdsearch.'%');

}else {

   //echo $faccode;
   $query = "SELECT LTM_VISITCODE,LTM_DATE,LTM_PATIENTNUM,LTM_PATIENTCODE,LTM_PATIENTNAME,LTM_RMK,LTM_ACTORCODE,LTM_ACTORNAME,LTM_INSTCODE,LTM_TOTAL_AMOUNT,LTM_PACKAGECODE,LTM_STATUS FROM hms_patient_labtest_main WHERE LTM_STATUS = ".$sql->Param('a')." AND LTM_SAMPLESTATE = ".$sql->Param('a')." AND LTM_LABCODE = ".$sql->Param('b')." AND LTM_TOTAL_AMOUNT > ".$sql->Param('d')." AND LTM_HOMESERVICE IN ('1','2')";
   $input = array('3','0',$faccode,0);

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

