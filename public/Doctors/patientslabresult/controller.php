<?php
//include("../../../config.php");
//include("../../../plugins/fpdf/fpdf.php");

$patientCls = new patientClass();
// Get Doctor Code
$actor_id = $engine->getActorCode();
// Get Doctor Facility Code
$actor = $engine->getActorDetails();
$actorname = $engine->getActorName();
$facility_code = $actor->USR_FACICODE;
$vhgroupcode = $actor->USR_VHGP_CODE;
$usertype = $actor->USR_TYPE; 
$actudate = date("Y-m-d");

switch ($viewpage){
    case 'pdf':
        function pdfEncrypt($origFile,$pass,$destFile){

//            include("../../../plugins/fpdf/fpdf_protection.php");
//            include("../../../plugins/fpdf/fpdf.php");
//            include(SPATH_PLUGINS.DS."fpdf/fpdf_protection.php");
            $pdf = new FPDF_Protection();

            // set the format of the destinaton file, in our case 6×9 inch
            $pdf->FPDF('P', 'in', array('6','9'));

            //calculate the number of pages from the original document
            $pagecount = $pdf->setSourceFile($origFile);

            // copy all pages from the old unprotected pdf in the new one
            for ($loop = 1; $loop <= $pagecount; $loop++) {
                $tplidx = $pdf->importPage($loop);
                $pdf->addPage();
                $pdf->useTemplate($tplidx);
            }

            // protect the new pdf file, and allow no printing, copy etc and leave only reading allowed
            $pdf->SetProtection(array(),$pass);
            $pdf->Output($destFile, 'F');

            return $destFile;

//            $pdf->SetProtection(array(), 'password', 'admin', 'ARCFOUR', 128);
//            $pdf->AddPage();
//            $pdf->SetFont('Arial');
//            $pdf->Write(10,'You can print me but not copy my text.');
//            $pdf->Output();
        }

        pdfEncrypt($labresult,'come','fred');
        echo $labresult;
    break;
    case 'newpdf':
    	//echo $test; die();
    	$stmt = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest_main WHERE LTM_PACKAGECODE = ".$sql->Param('1')."   "),array($test));
		print $sql->Errormsg();

			
		if($stmt->Recordcount() > 0){

			$obj = $stmt->FetchNextObject();
			$patient = $obj->LTM_PATIENTNAME;
			$patientnum = $obj->LTM_PATIENTNUM;
			$patientcode = $obj->LTM_PATIENTCODE;
			$packagecode = $obj->LTM_PACKAGECODE;
			$patientdate = $obj->LTM_DATE;
			$medic = $obj->LTM_ACTORNAME;
			$labname =$obj->LTM_LABNAME;
			$Total  = $obj->LTM_TOTAL_AMOUNT;
		}
		$stmtlisttestdetails = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_CODE = ".$sql->Param('1')." AND LT_STATUS !=".$sql->Param('2')." "),array($vkey,'0'));
		print $sql->Errormsg();
if ($stmtlisttestdetails->RecordCount()>0){
		  while ($objtest=$stmtlisttestdetails->FetchNextObject()){
		  $test_name=$objtest->LT_TESTNAME;
		  }
		  }
		  
				$stmtlistfiles = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labresult_files WHERE LTMI_LTCODE = ".$sql->Param('1')."  AND LTMI_STATUS=".$sql->Param('2')." "),array($vkey,'1'));
		print $sql->Errormsg();
		  if ($stmtlistfiles->RecordCount()>0){
		  while ($objlist=$stmtlistfiles->FetchNextObject()){
		  $pdffile[]=$objlist->LTMI_FILENAME;
		  }
		  }
	break;
    case 'details':
$stmt = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest_main WHERE LTM_VISITCODE = ".$sql->Param('1')." AND LTM_STATUS !=".$sql->Param('2')." "),array($keys,'0'));
		print $sql->Errormsg();

			
		if($stmt->Recordcount() > 0){

			$obj = $stmt->FetchNextObject();
			$patient = $obj->LTM_PATIENTNAME;
			$patientnum = $obj->LTM_PATIENTNUM;
			$patientcode = $obj->LTM_PATIENTCODE;
			$packagecode = $obj->LTM_PACKAGECODE;
			$patientdate = $obj->LTM_DATE;
			$medic = $obj->LTM_ACTORNAME;
			$labname =$obj->LTM_LABNAME;
			$Total  = $obj->LTM_TOTAL_AMOUNT;
            $patientdob = $patientCls->getPatientDetails($patientnum)->PATIENT_DOB;
            $patientcontact = $patientCls->getPatientDetails($patientnum)->PATIENT_PHONENUM;
            $patientage = $engine->calculateAge($patientdob);
            $patientgender = !empty($patientCls->getPatientDetails($patientnum)->PATIENT_GENDER)?($patientCls->getPatientDetails($patientnum)->PATIENT_GENDER == 'M' || $patientCls->getPatientDetails($patientnum)->PATIENT_GENDER == 'Male')?'Male':'Female':'N/A';
		}
		$stmtlisttestdetails = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_VISITCODE = ".$sql->Param('1')."  AND LT_STATUS !=".$sql->Param('2')." "),array($keys,'0'));
		print $sql->Errormsg();
		

		
        
    break;	
    case 'reset':
        $fdsearch = '';
        $view = '';
    break;
	
}


 

if(isset($action_search) && $action_search == "search"){
    if(!empty($fdsearch)){
		if($usertype == 7){
			$query = "SELECT * FROM hms_patient_labtest_main JOIN hmsb_vhealthunit ON LTM_INSTCODE = VHSUBDET_FACICODE WHERE VHSUBDET_MENUGPCODE = ".$sql->Param('a')." AND LTM_STATUS <> '0' AND (LTM_PATIENTNUM LIKE ".$sql->Param('c')." OR LTM_PATIENTNAME LIKE ".$sql->Param('d')." OR LTM_LABNAME LIKE ".$sql->Param('e')." ) ";
			$input = array($vhgroupcode,'%'.$fdsearch.'%','%'.$fdsearch.'%','%'.$fdsearch.'%');
		}else{
    	$query = "SELECT * FROM hms_patient_labtest_main WHERE LTM_ACTORCODE = ".$sql->Param('a')." AND LTM_INSTCODE = ".$sql->Param('b')." AND LTM_STATUS <> ".$sql->Param('c')." AND (LTM_PATIENTNUM LIKE ".$sql->Param('c')." OR LTM_PATIENTNAME LIKE ".$sql->Param('d')." OR LTM_LABNAME LIKE ".$sql->Param('e')." ) ";
	$input = array($actor_id,$facility_code,'0','%'.$fdsearch.'%','%'.$fdsearch.'%','%'.$fdsearch.'%');
		}
    }
}else {

	if($usertype == 7){
		$query = "SELECT * FROM hms_patient_labtest_main JOIN hmsb_vhealthunit ON LTM_INSTCODE = VHSUBDET_FACICODE WHERE VHSUBDET_MENUGPCODE = ".$sql->Param('a')." AND LTM_STATUS != '0' ";
		$input = array($vhgroupcode);
	}else{
    $query = "SELECT * FROM hms_patient_labtest_main WHERE LTM_ACTORCODE = ".$sql->Param('a')." AND LTM_INSTCODE = ".$sql->Param('b')." AND LTM_STATUS != ".$sql->Param('c')." ";
	$input = array($actor_id,$facility_code,'0');
	}

}

if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=f77ccbdb203c19d3d52b12a85f33faf5&option=f6383c07b345b6560d170c5e09bea356&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);

//Get all positions
$stmtpos2 = $engine->getUserPosition();