<?php
$patientCls = new patientClass();
$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();

$objdtls = $engine->getFacilityDetails();
$facilityalias = $objdtls->FACI_ALIAS ;
$faccode = $objdtls->FACI_CODE ;
$day = Date("Y-m-d");
$patientno=explode('@@',$keys);
switch($viewpage){
case 'treatment':

//print_r($patientno);
$stmtnote = $sql->Execute($sql->Prepare("SELECT MED_PATIENTNUM,MED_NOTE,MED_DATE,MED_TIME FROM hms_nursenote WHERE MED_STATUS = '1' AND MED_VISITCODE=".$sql->Param('b')." AND MED_PATIENTNUM=".$sql->Param('b')." ORDER BY MED_DATE DESC "),array($patientno[1],$patientno[0]));

$stmttr = $sql->Execute($sql->Prepare("SELECT TR_PATIENTNUM,TR_PATIENT,TR_DT, TR_VISITCODE,TR_DRUG,TR_DRUGID,TR_DOSAGE,TR_TIME,TR_AGE,TR_QTY,TR_WARDID FROM hms_treatment_sheet WHERE TR_STATUS = '1' AND TR_PATIENTNUM=".$sql->Param('b')." AND  TR_VISITCODE =".$sql->Param('c')." ORDER BY TR_DT DESC "),array($patientno[0],$patientno[1]));

$stmtdfp = $sql->Execute($sql->Prepare("SELECT DF_DATE,DF_TIME, DF_NAME,DF_ROUTE,DF_FLUID_AMT,DF_MIS,DF_METHODNAME,DF_FLUID_TYPE FROM hms_daily_fluid WHERE DF_STATUS = '1' AND DF_PATIENTNUM =".$sql->Param('b')." AND DF_VISITCODE=".$sql->Param('c')." ORDER BY DF_CURDATE DESC "),array($patientno[0],$patientno[1]));

$stmtpl = $sql->Execute($sql->Prepare("SELECT DF_DATE,DF_TIME, DF_NAME,DF_ROUTE,DF_FLUID_AMT,DF_MIS,DF_METHODNAME,DF_FLUID_TYPE,DT_DTINTAKE,DF_TIMEINTAKE FROM hms_daily_fluid WHERE DF_STATUS = '1' AND DF_PATIENTNUM =".$sql->Param('b')." AND DF_VISITCODE=".$sql->Param('c')." AND DT_DTINTAKE!='' ORDER BY DF_CURDATE DESC "),array($patientno[0],$patientno[1]));

$stmtout = $sql->Execute($sql->Prepare("SELECT DFO_TIME,DFO_DATE, DFO_MIS,DFO_OUTPUTNAME FROM hms_daily_fluidoutput WHERE DFO_STATUS = '1' AND DFO_PATIENTNUM =".$sql->Param('b')." AND DFO_VISITCODE=".$sql->Param('c')."  ORDER BY DFO_CURDATE DESC "),array($patientno[0],$patientno[1]));

$stmtcs = $sql->Execute($sql->Prepare("SELECT CSU_DATE,CSU_QTY, CSU_ITEMNAME FROM hms_consumable_used WHERE CSU_STATUS = '1' AND CSU_PATIENTNUM =".$sql->Param('b')." AND CSU_VISITCODE=".$sql->Param('c')."  ORDER BY CSU_CURDATE DESC "),array($patientno[0],$patientno[1]));

	
	
break;
case 'admdetails':
$patient_num=$session->get('patientno');
$patientno=explode('@@',$keys);
if(!empty($patient_num)){
	//print_r($patientno);
$patientdetails=$patientCls->getPatientDetails($patient_num);
}else{

	$patientdetails=$patientCls->getPatientDetails($patientno[0]);

	}
//print_r($patientdetails);
break;

case "takeaction":
$wardstatus = explode('_',$actiontype);
//print_r($wardstatus);
$sql->Execute("UPDATE hms_patient_admissions SET ADMIN_SERVCODE = ".$sql->Param('a').", ADMIN_STATUS = ".$sql->Param('b').",ADMIN_ADMITINGNOTE=".$sql->Param('c')." WHERE ADMIN_VISITCODE = ".$sql->Param('c')." AND ADMIN_PATIENTNO=".$sql->Param('c')." ",array($wardstatus[0],$wardstatus[1],$admittingnote,$visitcode,$patientno));
$msg = "Ward round Action has been Successfully taken.";
$status = "success";
// userlog event
$service=$engine->getServiceDetails($wardstatus[0]);
$servicename=$service->SERV_NAME;
$activity= "Ward Round action : ".$servicename." has been taken for patient with No. ".$patientno;
$engine->setEventLog("075",$activity);

			
break;

case 'prescription':
 $patientno=explode('@@',$keys);
 break;
 
 case 'manage':
 $patientno=explode('@@',$keys);
 break;
 
case "history":
//$patientno=explode('@@',$keys);
//$patient_num=$session->get('patientno');
if(!empty($keys)){
	
		$stmthl = $sql->Execute($sql->Prepare("SELECT * FROM hms_consultation WHERE CONS_PATIENTNUM=".$sql->Param('a')." AND CONS_VISITCODE=".$sql->Param('a')." ORDER BY CONS_ID DESC LIMIT 5 "),array($keys,$visitcode));
}else{
	//echo $patientno[0];
	$stmthl = $sql->Execute($sql->Prepare("SELECT * FROM hms_consultation WHERE CONS_PATIENTNUM=".$sql->Param('a')." ORDER BY CONS_ID DESC LIMIT 5 "),array($patientno[0]));
	}
	break;
	
	case "historydetails":
	$patientno=explode('@@',$keys);
	//$patient_num=$session->get('patientno');
   //print_r($patientno);
		
	break;

case 'patientvitals':
	
 $patientno=explode('@@',$keys);


$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_vitals WHERE VITALS_STATUS = ".$sql->Param('a')." AND VITALS_PATIENTNO=".$sql->Param('b')." "),array('1',$patientno[0]));
		 print $sql->ErrorMsg();
		 if($stmt){
			 if($stmt->RecordCount() > 0){
			while($obj=$stmt->FetchNextObject()){
			 $patientvisitcode[]=$obj->VITALS_VISITCODE;	
			 $patientcode=$obj->VITALS_PATIENTID;	
			}
			 }
			$session->set('patientvisitcode',$patientvisitcode);
		 }
break;

case 'patientlab':
$patientno=explode('@@',$keys);
 //print_r($patientno);
/*$stmt = $sql->Execute($sql->Prepare("SELECT DISTINCT LT_VISITCODE,LT_PATIENTNUM FROM hms_patient_labtest WHERE LT_STATUS = ".$sql->Param('a')." AND LT_PATIENTNUM=".$sql->Param('b')." "),array('7',$patientno[0]));
		 print $sql->ErrorMsg();
		 if($stmt){
			 if($stmt->RecordCount() > 0){
			while($obj=$stmt->FetchNextObject()){
			 $patientvisitcode[]=$obj->LT_VISITCODE;	
			 $patientcode=$obj->LT_PATIENTCODE;	
			}
			 }
			 //print_r($patientvisitcode);
		 }
*/break;
case 'complains':
$patientno=explode('@@',$keys);

$stmt = $sql->Execute($sql->Prepare("SELECT DISTINCT PC_VISITCODE,PC_PATIENTCODE FROM hms_patient_complains WHERE PC_STATUS = ".$sql->Param('a')." AND PC_PATIENTNUM=".$sql->Param('b')." "),array('1',$patientno[0]));
		 print $sql->ErrorMsg();
		 if($stmt){
			 if($stmt->RecordCount() > 0){
			while($obj=$stmt->FetchNextObject()){
			 $patientvisitcode[]=$obj->PC_VISITCODE;	
			 $patientcode=$obj->PC_PATIENTCODE;	
			}
			 }
			 //print_r($patientvisitcode);
		 }
break;

case 'diagnosis';
$patientno=explode('@@',$keys);
 //print_r($patientno);
break;

case 'savecomplains':
$postkey = $session->get("postkey");
		if($postkey != $microtime){
		$session->set("postkey",$microtime);
		//DECODE THE JASON ARRAY
			$compdata = json_decode($data);
			if(is_array($compdata)){

$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_patient_complains (PC_CODE,PC_PATIENTNUM,PC_VISITCODE,PC_DATE,PC_COMPLAINCODE,PC_COMPLAIN,PC_INSTCODE,PC_ACTORCODE,PC_ACTORNAME,PC_PATIENTCODE) VALUES(".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').")"),$compdata);
        print $sql->ErrorMsg();
			}
			$view='complains';
			
			/*$view='admdetails';
			$stmtpatient = $sql->execute($sql->Prepare("SELECT * FROM hms_patient WHERE PATIENT_PATIENTNUM = ".$sql->Param('1')."  "),array($patientno[0]));
	print $sql->Errormsg();
	
	if($stmt->Recordcount() > 0 ){
	
	$obj = $stmt->FetchNextObject();
	$p = $obj->PATIENT_FNAME;
	$pdob = $obj->PATIENT_DOB;
	$gender= $obj->PATIENT_GENDER;
	$phone= $obj->PATIENT_PHONENUM;
	$address = $obj->PATIENT_ADDRESS;
	$name1 = $obj->PATIENT_EMERGNAME1;
	$phone2 = $obj->PATIENT_EMERGNUM1;
	$address1 = $obj->PATIENT_EMERGADDRESS1;
	$name2 = $obj->PATIENT_EMERGNAME2;
	$phone3 = $obj->PATIENT_EMERGNUM2;
	$address2 = $obj->PATIENT_EMERGADDRESS2;
	$weight = $obj->PATIENT_WEIGHT;
	$height = $obj->PATIENT_HEIGHT;
	$blood = $obj->PATIENT_BLOODGROUP;
	$allegy = $obj->PATIENT_ALLERGIES;
	$chronic = $obj->PATIENT_CHRONIC_CONDITION;
	$nati = $obj->PATIENT_NATIONALITY;
	$mat = $obj->PATIENT_MARITAL_STATUS;
	
	}
			*/
	}
break;

 case 'savelabtest':
		/*$postkey = $session->get("postkey");
		if($postkey != $microtime){
		$session->set("postkey",$microtime);
		//DECODE THE JASON ARRAY
			$newdata = json_decode($data);
			$vitaldetcode = uniqid();
			print_r($newdata);
			exit;
			if(is_array($newdata)){
			$stmtdata = $sql->Execute($sql->Prepare("INSERT INTO hms_patient_labtest (LT_CODE, LT_VISITCODE,LT_DATE, LT_PATIENTNUM,LT_PATIENTCODE,LT_PATIENTNAME,LT_TESTNAME,LT_SPECIMEN,LT_SPECIMENDATE,LT_SPECIMENLABEL,LT_SPECIMENVOLUME,LT_ACTORCODE,LT_ACTORNAME,LT_INSTCODE)VALUES(".$sql->Param('a').",".$sql->Param('b').", ".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('i').",".$sql->Param('k').",".$sql->Param('l').",".$sql->Param('m').",".$sql->Param('k').",".$sql->Param('l').")"),$newdata);
		print $sql->ErrorMsg();	
		$msg = "Patient Lab has been captured Successfully.";
	    $status = "success";
		
        $activity = "Patient Specimen captured Successfully.";
	 $engine->setEventLog("065",$activity);
		
			}else{
		$msg = "Sorry! No Patient Specimen captured.";
	    $status = "error";
		
				}
			
		}*/

break;
 case 'savevitals':
		$postkey = $session->get("postkey");
		if($postkey != $microtime){
		$session->set("postkey",$microtime);
		//DECODE THE JASON ARRAY
			$newdata = json_decode($data);
			$vitaldetcode = uniqid();
			
			if(is_array($newdata)){
			$stmtdata = $sql->Execute($sql->Prepare("INSERT INTO hms_vitals_details (VITDET_VITALSTYPE, VITDET_VITALSVALUE,VITDET_VISITCODE, VITDET_PATIENTID,VITDET_PATIENTNO)VALUES(".$sql->Param('a').",".$sql->Param('b').", ".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').")"),$newdata);
		print $sql->ErrorMsg();	
			
		$keys_code=explode('@@',$keys);
	$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_vitals (VITALS_CODE, VITALS_VISITCODE, VITALS_REQUCODE, VITALS_PATIENTID, VITALS_SERVICE,  VITALS_FACILITYCODE,VITALS_PAYMENT,VITALS_PATIENTNO,VITALS_ACTOR)VALUES(".$sql->Param('a').",".$sql->Param('b').", ".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('g').",".$sql->Param('g').")"), array($vitaldetcode,$keys_code[1],$regcode,$patientcode, 'VITALS',$activeinstitution, $paymenttype,$patientno,$usrcode));		
	print $sql->ErrorMsg();				
			
		
		$msg = "Patient Vitals has been captured Successfully.";
	    $status = "success";
		$view='wardlist';
		
        $activity = "Patient Vitals captured Successfully.";
		$engine->setEventLog("013",$activity);
		
			}else{
		$msg = "Sorry! No Patient Vital captured.";
	    $status = "error";
		
				}
			
		}

break;

case 'saveassignbed':

if(empty($startdate) || empty($bed)  || empty($patientnum) || empty($patient) || empty($faccode)  || empty($visitcode)  || empty($keycode) ){

$msg = "Failed. Required field(s) can't be empty!.";
$status = "error";
$view ='admdetails';

}else{


$wardbed = explode('@@@', $bed);
$bedcode = $wardbed[0];
$bedname = $wardbed[1];
$wardcode = $wardbed[2];
$wardname = $wardbed[3];


$sql->Execute($sql->Prepare("UPDATE hms_service_request SET REQU_STATUS  = ".$sql->Param('a')." WHERE REQU_CODE = ".$sql->Param('b').""),array('4',$keycode));
print $sql->ErrorMsg();


$adcode = $engine->getadmissionCode();
$dt = date("Y-m-d", strtotime(str_replace('/','-', $startdate))); 
$sql->Execute($sql->Prepare("INSERT INTO hms_patient_admissions (ADMIN_CODE,ADMIN_INDEXNUM,ADMIN_PATIENT,ADMIN_DATE,ADMIN_VISITCODE,ADMIN_WARDID,ADMIN_WARD,ADMIN_BEDID,ADMIN_BED,ADMIN_FACICODE,ADMIN_USERCODE,ADMIN_USERFULLNAME) VALUES(".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').")"),
array($adcode,$patientnum,$patient,$dt,$visitcode,$wardcode,$wardname,$bedcode,$bedname,$faccode,$usrcode,$usrname));
print $sql->ErrorMsg();

$sql->Execute($sql->Prepare("UPDATE hms_st_wardbed SET BED_STATUS  = ".$sql->Param('a')." WHERE BED_CODE = ".$sql->Param('b').""),array('1',$bedcode));
print $sql->ErrorMsg();

$msg = "Saved successfully.";
$status = "success";
$view ='';

}

break;

// 20 NOV 2015, JOSEPH ADORBOE, SAVE THE SYMTOMS.
case "saveconsultation#":


if(empty($complains) || empty($patientnum) || empty($visitcode)) {

$msg = "Failed. Required field(s) can't be empty!.";
$status = "error";
$view ='consulation';

}else {
//INSERT INTO symtoms TABLE
$stmt = $sql->Execute($sql->Prepare("SELECT SYM_ID FROM hms_symtons WHERE  SYM_INDEXNUM = ".$sql->Param('a')." and SYM_ITEM = ".$sql->Param('b')." and SYM_VISITCODE = ".$sql->Param('c')." and SYM_STATUS = ".$sql->Param('c')." "),array($indexnum,$sym,$visitcode,'1'));
print $sql->ErrorMsg();

if($stmt->RecordCount()>0){
$msg = "Failed, Symtoms exist already!";
$status = "error";
$view ='syms';
$sym ='';

}else{
$scode = $codes->getsymtomscode();
$symt = explode('@@@',$sym);
$sym = $symt[0];
$sy = $symt[1];
//      $sy = $lovn->getsymtoms($sym);
$sql->Execute($sql->Prepare("INSERT INTO hms_symtons (SYM_CODE,SYM_DATE,SYM_INDEXNUM,SYM_VISITCODE,SYM_ITEM,SYM_COMPID,SYM_ACTOR,SYM_USER,SYM_SYMTOMS) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('h').")"),array($scode,$dt,$patientnum,$visitcode,$sym,$instcode,$currentusercode,$currentuser,$sy));
print $sql->ErrorMsg();

$msg = "Symtoms been saved successfully.";
$status = "success";


// userlog event
$activity= "OPD PATIENT SYSMTOMS ADDED PATIENT : ".$names." , NUMBER  ".$indexnum.", VISITCODE:".$visitcode.", SYMTON:".$sy." ";
$engine->setEventLog("162",$activity);

$view ='syms';
$sym ='';
}
}
break;
	case 'consult':
	if(isset($keys) && !empty($keys)){
		$ptdetails = $patientCls->getConsultationDetails($keys);
		$patientname = $ptdetails->CONS_PATIENTNAME;
		$patientnum = $ptdetails->CONS_PATIENTNUM;
		
		//get passport picture
		$picname = $patientCls->getPassPicture($patientnum);
		$photourl = SHOST_PASSPORT.$picname;
	}
    break;
	
	
   
    case 'admdetails____':
	
	if(empty($keys)){
	
	$msg = "Failed. Required field(s) can't be empty!.";
	$status = "error";
	$view ='';
	
	}else{
	
	$stmt = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_admissions WHERE ADMIN_CODE = ".$sql->Param('1')." and ADMIN_STATUS = ".$sql->Param('2')." and ADMIN_FACICODE = ".$sql->Param('a')."  "),array($keys,'1',$faccode));
	print $sql->Errormsg();
	
	if($stmt->Recordcount() > 0 ){
	
	$obj = $stmt->FetchNextObject();
	
	$patient = $obj->ADMIN_PATIENT;
	$patientnum= $obj->ADMIN_INDEXNUM;
	$visitcode= $obj->ADMIN_VISITCODE;
	$faccode = $obj->ADMIN_FACICODE;
	$keycode = $obj->ADMIN_CODE;
	
	}
	
	$stmtpatient = $sql->execute($sql->Prepare("SELECT * FROM hms_patient WHERE PATIENT_PATIENTNUM = ".$sql->Param('1')."  "),array($patientnum));
	print $sql->Errormsg();
	
	if($stmt->Recordcount() > 0 ){
	
	$obj = $stmt->FetchNextObject();
	$p = $obj->PATIENT_FNAME;
	$pdob = $obj->PATIENT_DOB;
	$gender= $obj->PATIENT_GENDER;
	$phone= $obj->PATIENT_PHONENUM;
	$address = $obj->PATIENT_ADDRESS;
	$name1 = $obj->PATIENT_EMERGNAME1;
	$phone2 = $obj->PATIENT_EMERGNUM1;
	$address1 = $obj->PATIENT_EMERGADDRESS1;
	$name2 = $obj->PATIENT_EMERGNAME2;
	$phone3 = $obj->PATIENT_EMERGNUM2;
	$address2 = $obj->PATIENT_EMERGADDRESS2;
	$weight = $obj->PATIENT_WEIGHT;
	$height = $obj->PATIENT_HEIGHT;
	$blood = $obj->PATIENT_BLOODGROUP;
	$allegy = $obj->PATIENT_ALLERGIES;
	$chronic = $obj->PATIENT_CHRONIC_CONDITION;
	$nati = $obj->PATIENT_NATIONALITY;
	$mat = $obj->PATIENT_MARITAL_STATUS;
	
	}
	
	$stmtlist = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_admissions  WHERE ADMIN_CODE = ".$sql->Param('1')." and ADMIN_STATUS = ".$sql->Param('2')."  "),array($keys, '1'));
	print $sql->Errormsg();
	
	}
	
	break;
	
    
	case "reset":
	$fdsearch = "";
	break;
  $session->set('patientno',$patientno);
  
}


if(!empty($fdsearch)){
	$query = "SELECT * FROM hms_patient_admissions WHERE  ADMIN_PATIENT LIKE ".$sql->Param('1')." or ADMIN_INDEXNUM LIKE ".$sql->Param('2')."  AND ADMIN_FACICODE = ".$sql->Param('a')." ";
	print $sql->ErrorMsg();
    $input = array('%'.$fdsearch.'%','%'.$fdsearch.'%',$faccode);
}else {

    $query = "SELECT * FROM hms_patient_admissions WHERE ADMIN_FACICODE = ".$sql->Param('1')."  AND ADMIN_STATUS =  ".$sql->Param('2')." ";
	print $sql->ErrorMsg();
    $input = array($faccode,'1');
}

$stmtwardslov   = $sql->Execute($sql->Prepare("SELECT * FROM hms_st_ward ORDER BY WARD_NAME "));
$stmtbedlov   = $sql->Execute($sql->Prepare("SELECT * FROM hms_st_wardbed where  BED_STATUS = '0' ORDER BY BED_NAME "));
if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=f77ccbdb203c19d3d52b12a85f33faf5&option=6bf17fe4762ece7a82410014d090d322&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);
$stmttestlov = $sql->Execute($sql->prepare("SELECT * from hmsb_st_labtest "));
$stmtoptions = $sql->Execute($sql->Prepare("SELECT * from hms_vitaloptions where VIT_STATU='1' "));
$stmtspecimen = $sql->Execute($sql->prepare("SELECT * from hmsb_st_labspecimen where SP_STATUS = ".$sql->Param('a').""),array('1'));
$stmtdiagnosislov = $sql->Execute($sql->Prepare("SELECT * from hmsb_st_disease order by DIS_NAME ")) ;
$stmtdrugslov = $sql->Execute($sql->Prepare("SELECT * from hmsb_st_phdrugs order by DR_NAME ")) ;
$stmtmethodlov = $sql->Execute($sql->Prepare("SELECT DIS_CODE,DIS_NAME FROM hms_st_fluidmethod "));
$stmtconson = $sql->Execute($sql->Prepare("SELECT CS_CODE,CS_NAME FROM hmsb_st_consumables order by CS_NAME "));
$stmtplanlov = $sql->Execute($sql->Prepare("SELECT * from hms_daily_fluid where DF_VISITCODE = ".$sql->Param('a')." and DF_CATEGORY = ".$sql->Param('b')." "),array($patientno[1],'1')) ;
$stmtoutputlov = $sql->Execute($sql->Prepare("SELECT DIS_CODE,DIS_NAME FROM hms_st_fluidoutput "));

include("model/js.php");
?>