<?php
$patientCls = new patientClass();
$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();

$objdtls = $engine->getFacilityDetails();
$facilityalias = $objdtls->FACI_ALIAS ;
$faccode = $objdtls->FACI_CODE ;


$day = Date("Y-m-d");
switch($viewpage){



case 'accept':
        
		IF(empty($_POST["syscheckbox"])){
	       
            $msg = "Failed. Required field(s) can't be empty!.";
			$status = "error";
			$view ='prescdetails';
            
            $stmtlist = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_prescription WHERE PRESC_VISITCODE = ".$sql->Param('1')." and PRESC_STATUS = ".$sql->Param('2')." and PRESC_FACICODE = ".$sql->Param('a')." "),array($visitcode, '1',$faccode));
	        print $sql->Errormsg();
	
	       
	    }else{
              
        foreach($_POST["syscheckbox"] as $keys ){
            
        $predetails = explode('@@@', $keys);
        $prcode = $predetails[0];
        $uprice = $predetails[1];
        $tota = $predetails[2];
        
	    $cash = 'PC0001';
        $cashmeth = 'CASH';
	    $stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_prescription SET PRESC_STATUS = ".$sql->Param('1').", PRESC_UNITPRICE = ".$sql->Param('2').", PRESC_TOTAL = ".$sql->Param('3').", PRESC_METHOD = ".$sql->Param('4').", PRESC_METHODCODE = ".$sql->Param('5')." WHERE PRESC_CODE = ".$sql->Param('2').""),array('2',$uprice,$tota,$cashmeth,$cash,$prcode));
		print $sql->ErrorMsg();
        
        $stmtlist = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_prescription WHERE PRESC_VISITCODE = ".$sql->Param('1')." and PRESC_STATUS = ".$sql->Param('2')." and PRESC_FACICODE = ".$sql->Param('a')." "),array($visitcode, '1',$faccode));
	    print $sql->Errormsg();
	
		
		}
        
		$msg = 'You have accepted to supply this prescription to this patient';
        $status = 'success';
        $view ='prescdetails';
        
		}
		
break;




case 'acceptone':
       
	    $stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_prescription SET PRESC_STATUS = ".$sql->Param('1')." WHERE PRESC_CODE = ".$sql->Param('2').""),array('2',$keys));
		print $sql->ErrorMsg();
		
        $stmtlist = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_prescription WHERE PRESC_VISITCODE = ".$sql->Param('1')." and PRESC_STATUS = ".$sql->Param('2')."  "),array($visitcode, '1'));
	    print $sql->Errormsg();
	
		
		$msg = 'You have accepted to supply this prescription to this patient';
        $status = 'success';
        $view ='prescdetails';
    
		
break;



case 'decline':
        
		IF(empty($_POST["syscheckbox"])){
	       
            $msg = "Failed. Required field(s) can't be empty!.";
			$status = "error";
			$view ='prescdetails';
            
            $stmtlist = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_prescription WHERE PRESC_VISITCODE = ".$sql->Param('1')." and PRESC_STATUS = ".$sql->Param('2')." and PRESC_FACICODE = ".$sql->Param('a')." "),array($visitcode, '1',$faccode));
	        print $sql->Errormsg();
	
	       
	    }else{
              
       foreach($_POST["syscheckbox"] as $keys ){
	   $nnil = '';
       
	   $stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_prescription SET PRESC_STATUS = ".$sql->Param('1').", PRESC_FACICODE = ".$sql->Param('2')." WHERE PRESC_CODE = ".$sql->Param('3').""),array('1',$nnil,$keys));
	   print $sql->ErrorMsg();
       
       $stmtlist = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_prescription WHERE PRESC_VISITCODE = ".$sql->Param('1')." and PRESC_STATUS = ".$sql->Param('2')." and PRESC_FACICODE = ".$sql->Param('a')." "),array($visitcode, '1',$faccode));
	        print $sql->Errormsg();
	
		
		
		$msg = 'You have Declined to supply this prescription to this patient';
        $status = 'success';
        $view ='prescdetails';
		}
        }
		
break;




case 'savecomplain':

if(empty($patientnum)){

$msg = "Failed. Required field(s) can't be empty!.";
$status = "error";
$view ='consulting';
}else{

if(!empty($complain)){

$comcode = $engine->getcomplainCode(); 
$sql->Execute($sql->Prepare("INSERT INTO hms_patientcomplains (PC_CODE,PC_PATIENTNUM,PC_VISITCODE,PC_DATE,PC_COMPLAINCODE,PC_COMPLAIN,PC_INSTCODE,PC_ACTORCODE,PC_ACTORNAME) VALUES(".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').")"),array($comcode,$patientnum,$visitcode,$day,$subid,$complain,$activeinstitution,$usrcode,$usrname));
print $sql->ErrorMsg();
}

IF(!empty($test)){

$lqcode = $engine->getlabtestCode();

$lt = explode('@@@', $test);
$lcode = $lt['0'];
$ltest = $lt['1'];
$dcode = $lt['2'];
$ddis = $lt['3'];

$sql->Execute($sql->Prepare("INSERT INTO hms_lab_test (LT_CODE,LT_VISITCODE,LT_DATE,LT_PATIENTNUM,LT_PATIENTNAME,LT_TEST,LT_TESTNAME,LT_DISCIPLINE,LT_DISCPLINENAME,LT_RMK,LT_ACTORCODE,LT_ACTORNAME,LT_INSTCODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').")"),array($lqcode,$visitcode,$day,$patientnum,$patient,$lcode,$ltest,$dcode,$ddis,$crmk,$usrcode,$usrname,$activeinstitution));
print $sql->ErrorMsg();
}


IF(!empty($dia)){

$diacode = $engine->getdiagnosisCode();

$di = explode('@@@', $dia);
$dicode = $di['0'];
$diname = $di['1'];


$sql->Execute($sql->Prepare("INSERT INTO hms_diagnosis (DIA_CODE,DIA_VISITCODE,DIA_DATE,DIA_PATIENTNUM,DIA_DIA,DIA_DIAGNOSIS,DIA_RMK,DIA_ACTORNAME,DIA_ACTORCODE,DIA_INSTCODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('9').")"),array($diacode,$visitcode,$day,$patientnum,$dicode,$diname,$drmk,$usrname,$usrcode,$activeinstitution));
print $sql->ErrorMsg();
}


IF(!empty($drug)){

$precode = $engine->getprescriptionCode();

$pre = explode('@@@', $drug);
$drcode = $pre['0'];
$drname = $pre['1'];
$dscode = $pre['2'];
$dsname = $pre['3'];

$qty = $frequency * $days * $times ;

$sql->Execute($sql->Prepare("INSERT INTO hms_ph_prescription (PRESC_CODE,PRESC_PATIENT,PRESC_PATIENTNUM,PRESC_DATE,PRESC_VISITCODE,PRESC_DRUGID,PRESC_DRUG,PRESC_QUANTITY,PRESC_DOSAGENAME,PRESC_DOSAGECODE,PRESC_FREQ,PRESC_DAYS,PRESC_TIMES,PRESC_ACTORNAME,PRESC_ACTORCODE,PRESC_INSTCODE) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('14').",".$sql->Param('15').",".$sql->Param('16').")"),array($precode,$patient,$patientnum,$day,$visitcode,$drcode,$drname,$qty,$dsname,$dscode,$frequency,$days,$times,$usrname,$usrcode,$activeinstitution));
print $sql->ErrorMsg();

}

$msg = "Saved successfully.";
$status = "success";
$view ='consulting';
}


//die('hard ');
break;

// 20 NOV 2015, JOSEPH ADORBOE, SAVE THE SYMTOMS.
case "saveconsultation#":


if(empty($complains) || empty($patientnum) || empty($visitcode)) {

$msg = "Failed. Required field(s) can't be empty!.";
$status = "error";
$view ='consulation';

}else {
//INSERT INTO symtoms TABLE
$stmt = $sql->Execute($sql->Prepare("SELECT SYM_ID FROM hmis_symtons WHERE  SYM_INDEXNUM = ".$sql->Param('a')." and SYM_ITEM = ".$sql->Param('b')." and SYM_VISITCODE = ".$sql->Param('c')." and SYM_STATUS = ".$sql->Param('c')." "),array($indexnum,$sym,$visitcode,'1'));
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
$sql->Execute($sql->Prepare("INSERT INTO hmis_symtons (SYM_CODE,SYM_DATE,SYM_INDEXNUM,SYM_VISITCODE,SYM_ITEM,SYM_COMPID,SYM_ACTOR,SYM_USER,SYM_SYMTOMS) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('h').")"),array($scode,$dt,$patientnum,$visitcode,$sym,$instcode,$currentusercode,$currentuser,$sy));
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
	
	
    case 'savevitals':
        die($patient.' ,'.$reqdate.', '.$doctor.', '.$actor.', '.$paymenttype.', '.$servicename.', '.$data);
    break;
	
    
    
    case 'prescrdetails':
	
	if(empty($keys)){
	
	$msg = "Failed. Required field(s) can't be empty!.";
	$status = "error";
	$view ='';
	
	}else{
	
	$stmt = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_prescription WHERE PRESC_VISITCODE = ".$sql->Param('1')." and PRESC_STATUS = ".$sql->Param('2')." and PRESC_FACICODE = ".$sql->Param('a')."  "),array($keys,'1',$faccode));
	print $sql->Errormsg();
	
	if($stmt->Recordcount() > 0 ){
	
	$obj = $stmt->FetchNextObject();
	
	$patient = $obj->PRESC_PATIENT;
	$patientnum= $obj->PRESC_PATIENTNUM;
	$visitcode= $obj->PRESC_VISITCODE;
	$faccode = $obj->PRESC_FACICODE;
	
	}
	
	$stmtlist = $sql->execute($sql->Prepare("SELECT * FROM hms_patient_prescription  WHERE PRESC_VISITCODE = ".$sql->Param('1')." and PRESC_STATUS = ".$sql->Param('2')."  "),array($keys, '1'));
	print $sql->Errormsg();
	
	}
	
	
	break;
	
	
    
    
	case "reset":
	$fdsearch = "";
	break;
    
}


if(!empty($fdsearch)){
//	$query = "SELECT * FROM hms_patient_prescription WHERE PRESC_FACICODE = ".$sql->Param('a')."  AND AND PRESC_STATUS = ".$sql->Param('a').") And (PRESC_PATIENT LIKE ".$sql->Param('1')." or PRESC_PATIENTNUM LIKE ".$sql->Param('2')." OR PRESC_DRUG LIKE ".$sql->Param('3').") ";
	$query = "SELECT DISTINCT PRESC_VISITCODE,PRESC_PATIENT,PRESC_PATIENTNUM,PRESC_DATE,PRESC_DEL_STATUS FROM hms_patient_prescription WHERE PRESC_PATIENT LIKE ".$sql->Param('1')." or PRESC_PATIENTNUM LIKE ".$sql->Param('2')."  AND PRESC_FACICODE = ".$sql->Param('a')." ";
	
	print $sql->ErrorMsg();
    $input = array('%'.$fdsearch.'%','%'.$fdsearch.'%',$faccode);
//	$input = array($faccode,'1','%'.$fdsearch.'%','%'.$fdsearch.'%','%'.$fdsearch.'%');
}else {

    $query = "SELECT DISTINCT PRESC_VISITCODE,PRESC_PATIENT,PRESC_PATIENTNUM,PRESC_DATE,PRESC_DEL_STATUS FROM hms_patient_prescription WHERE PRESC_FACICODE = ".$sql->Param('a')." AND PRESC_STATUS =  ".$sql->Param('2')." ";
    $input = array($faccode,'1');
}
if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=f77ccbdb203c19d3d52b12a85f33faf5&option=6bf17fe4762ece7a82410014d090d322&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);

$usp = $doctors->getuserSpeciality($usrcode);
$stmttestlov = $sql->Execute($sql->Prepare("SELECT * from hmsb_st_labtest order by LTT_NAME ")) ;
$stmtdiagnosislov = $sql->Execute($sql->Prepare("SELECT * from hmsb_st_disease order by DIS_NAME ")) ;
$stmtdrugslov = $sql->Execute($sql->Prepare("SELECT * from hmsb_st_phdrugs order by DR_NAME ")) ;


?>