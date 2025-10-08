<?php
/**
 * Created by PhpStorm.
 * User: Adusei
 * Date: 11/15/2018
 * Time: 12:11 PM
 */
$actor_id = $engine->getActorCode();
$userInfo= $engine->getActorDetails();
$facilitycode = $engine->getFacilityDetails();
$actor_facilitycode =!empty($facilitycode->FACI_CODE)?$facilitycode->FACI_CODE:$actor_id;
$prefix='SETT'.date('y').'-';
$settlecode=$engine->settlementAccno('hms_settlement_account', $prefix,'SET_CODE' );

$date=date("Y-m-d H:i:s");
switch ($viewpage) {
	case 'savemomo':
		# code...
if(!empty($paymode) && !empty($userlevel1) && !empty($momo_crdno)){
	// die("good");
	$stmt=$sql->Execute($sql->Prepare("SELECT SET_ACC_NO FROM hms_settlement_account WHERE SET_ACC_NO=".$sql->Param('a')." AND SET_FAC_CODE=".$sql->Param('a')."  "),array($momo_crdno,$actor_facilitycode));	
if ($stmt->RecordCount() > 0) {
	# code...
	$msg = "Failed. Phone number exist.. Please try again";
		$status = "error";
		$view ='add';
}else{
	// $paymode == '1816111'?"Mobile Money"
	// if ($paymode == '1816111') {
	// 	# code...
	// 	$mode="Mobile Money";
	// }
$stmtd=$sql->Execute($sql->Prepare("INSERT INTO hms_settlement_account(SET_CODE,SET_FAC_CODE,SET_TYPE,SET_ACC_CODE,SET_ACC_NAME,SET_ACC_NO,SET_DATE) VALUES(".$sql->Param('a').",".$sql->Param('a').",".$sql->Param('a').",".$sql->Param('a').",".$sql->Param('a').",".$sql->Param('a').",".$sql->Param('a').")"),array($settlecode,$actor_facilitycode,'1',$paymode,$userlevel1,$momo_crdno,$date));
if($stmtd==true){
$msg = "Successful. Account saved ";
		$status = "success";
		$view ='';

}else{
	$msg = "Failed. Please try again";
		$status = "error";
		$view ='add';
}

}

}else{
	$msg = "Failed. All Fields required";
		$status = "error";
		$view ='add';
}

	
		break;

		case 'savecard':
		# code...
		if (!empty($paymode) && !empty($momo_crdno)) {

			# code...

			$stmt=$sql->Execute($sql->Prepare("SELECT SET_ACC_NO FROM hms_settlement_account WHERE SET_ACC_NO=".$sql->Param('a')." AND SET_FAC_CODE=".$sql->Param('a')."  "),array($momo_crdno,$actor_facilitycode));	
if ($stmt->RecordCount() > 0) {
	# code...
	$msg = "Failed. Account Number exist.. Please try again";
		$status = "error";
		$view ='add';
}else{
	$userlevel1="Card";
	$stmtd=$sql->Execute($sql->Prepare("INSERT INTO hms_settlement_account(SET_CODE,SET_FAC_CODE,SET_TYPE,SET_ACC_CODE,SET_ACC_NAME,SET_ACC_NO,SET_DATE) VALUES(".$sql->Param('a').",".$sql->Param('a').",".$sql->Param('a').",".$sql->Param('a').",".$sql->Param('a').",".$sql->Param('a').",".$sql->Param('a').")"),array($settlecode,$actor_facilitycode,'2',$paymode,$userlevel1,$momo_crdno,$date));
	if($stmtd==true){
$msg = "Successful. Account saved ";
		$status = "success";
		$view ='';

}else{
	$msg = "Failed. Please try again";
		$status = "error";
		$view ='add';
}


}


		}else{
			$msg = "Failed. All Fields required";
		$status = "error";
		$view ='add';
		}
		// die('card');
		break;
		case 'savebank':
			# code...
		if (!empty($paymode) && !empty($userlevel1) && !empty($momo_crdno) && !empty($branchname)) {
			# code...
			
			$stmt=$sql->Execute($sql->Prepare("SELECT SET_ACC_NO FROM hms_settlement_account WHERE SET_ACC_NO=".$sql->Param('a')." AND SET_FAC_CODE=".$sql->Param('a')."  "),array($momo_crdno,$actor_facilitycode));
			if ($stmt->RecordCount() > 0) {
	# code...
	$msg = "Failed. Account exist.. Please try again";
		$status = "error";
		$view ='add';
}else{
	$stmtd=$sql->Execute($sql->Prepare("INSERT INTO hms_settlement_account(SET_CODE,SET_FAC_CODE,SET_TYPE,SET_ACC_CODE,SET_ACC_NAME,SET_ACC_NO,SET_DATE,SET_BANK_BRANCH) VALUES(".$sql->Param('a').",".$sql->Param('a').",".$sql->Param('a').",".$sql->Param('a').",".$sql->Param('a').",".$sql->Param('a').",".$sql->Param('a').",".$sql->Param('a').")"),array($settlecode,$actor_facilitycode,'3',$paymode,$userlevel1,$momo_crdno,$date,$branchname));

		if($stmtd==true){
$msg = "Successful. Account saved ";
		$status = "success";
		$view ='';

}else{
	$msg = "Failed. Please try again";
		$status = "error";
		$view ='add';
}


}


		}else{

				$msg = "Failed. All Fields required";
		$status = "error";
		$view ='add';
		}


			break;
//edit
case 'edit':
		$stmt=$sql->Execute($sql->Prepare("SELECT * FROM hms_settlement_account WHERE SET_CODE=".$sql->Param('a')." "),array($keys));
		$stmtd=$sql->Execute($sql->Prepare("SELECT * FROM hms_bank"));
		$edjobj= $stmt->FetchNextObject();
		// die(var_dump($edjobj));

		$catname= $edjobj->SET_ACC_CODE;
		$accname=$edjobj->SET_ACC_NAME;
		$type =$edjobj->SET_TYPE;
		$accno=$edjobj->SET_ACC_NO;
		$expydate=$edjobj->SET_CARD_EXP_DATE;
		$ccvcode=$edjobj->SET_CV_CODE;
		$mstatus= $edjobj->SET_STATUS;
		$msbranch= $edjobj->SET_BANK_BRANCH;

		// echo $accname;
// echo $cat;
// die("dadas");
		break;	

case 'editmomo':
	# code...
// echo $userlevel1;
// die("momo");
// $status!=='2'?$status:'2';
$stmd= $sql->Execute($sql->Prepare("UPDATE hms_settlement_account SET SET_ACC_NAME=".$sql->Param('a').",SET_ACC_NO=".$sql->Param('a').",SET_STATUS=".$sql->Param('a')." WHERE SET_CODE=".$sql->Param('a')."  "),array($userlevel1,$momo_crdno,$status,$keys));
if ($stmd==true) {
	# code...
	$msg = "Successful. Account details updated ";
		$status = "success";
		$view ='';
}else{
$msg = "Failed. Please try again";
		$status = "error";
		$view ='';
}

	break;
case 'editcard':
	# code...
// die("card");
// $status!=='2'?$status:'2';
$stmtd=$sql->Execute($sql->Prepare("UPDATE hms_settlement_account SET SET_ACC_NO=".$sql->Param('a').",SET_STATUS=".$sql->Param('a').",SET_CARD_EXP_DATE=".$sql->Param('a').",SET_CV_CODE=".$sql->Param('a')." WHERE SET_CODE=".$sql->Param('a')." "),array($momo_crdno,$status,$cardExpiry,$cvcode,$keys));
if ($stmtd==true) {

	# code...
	$msg = "Successful. Account details updated ";
		$status = "success";
		$view ='';
}else{
	$msg = "Failed. Please try again";
		$status = "error";
		$view ='';
}


	break;
	case 'editbank':
		# code...
	$stmd= $sql->Execute($sql->Prepare("UPDATE hms_settlement_account SET SET_ACC_NAME=".$sql->Param('a').",SET_ACC_NO=".$sql->Param('a').",SET_STATUS=".$sql->Param('a').",SET_BANK_BRANCH=".$sql->Param('a')." WHERE SET_CODE=".$sql->Param('a')."  "),array($userlevel1,$momo_crdno,$status,$branchname,$keys));
if ($stmd==true) {
	# code...
	$msg = "Successful. Account details updated ";
		$status = "success";
		$view ='';
}else{
$msg = "Failed. Please try again";
		$status = "error";
		$view ='';
}
		break;
		case 'delete':
			# code...
		$stmd= $sql->Execute($sql->Prepare("UPDATE hms_settlement_account SET SET_STATUS=".$sql->Param('a')." WHERE  SET_CODE=".$sql->Param('a')." "),array('2',$keys));
			break;
			if ($stmtd==true) {
				# code...
				$msg = "Successful. Account deleted ";
				$status = "success";
				$view ='';
			}
	
}








	switch (strtolower($view)){
		
		
		default:
		
			$categories = array();
			$srvcategory = isset($srvcategory)?$srvcategory:'%';
			$cstmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_settlement_paymodes  WHERE  SETM_STATUS='1' ORDER BY SETM_NAME ASC"),array());
			while($cat = $cstmt->FetchNextObject()){
				$categories[$cat->SETM_CODE] = $cat->SETM_NAME;
			}
			#if category is not set
			if ($srvcategory=='%'){
			if(empty($fdsearch)){
				$query="SELECT * FROM hms_settlement_account WHERE SET_FAC_CODE=".$sql->Param('b')." AND SET_STATUS IN ('0','1') ORDER BY SET_INPUTTEDDATE DESC ";
				$input=array($actor_facilitycode);
		}elseif(!empty($fdsearch)){
			$query="SELECT * FROM hms_settlement_account WHERE  SET_STATUS IN ('0','1') AND SET_FAC_CODE=".$sql->Param('b')." AND (SET_ACC_NAME ".$sql->Param('c')." OR SET_ACC_NO LIKE ".$sql->Param('c').")  ORDER BY SET_INPUTTEDDATE DESC";
				$input=array($actor_facilitycode,"%".$fdsearch."%","%".$fdsearch."%");
		}
			}
			#if category is set
			else{
		
			if(empty($fdsearch)){
				$query="SELECT * FROM hms_settlement_account   WHERE  SET_STATUS IN ('0','1') AND SET_FAC_CODE=".$sql->Param('b')." AND SET_ACC_CODE LIKE ".$sql->Param('c')."  ORDER BY SET_INPUTTEDDATE DESC ";
				$input=array($actor_facilitycode,$srvcategory);
		}elseif(!empty($fdsearch)){
			$query="SELECT * FROM hms_settlement_account WHERE  SET_STATUS IN ('0','1') AND SET_FAC_CODE=".$sql->Param('b')." AND (SET_ACC_NAME LIKE ".$sql->Param('c')." OR SET_ACC_NO LIKE ".$sql->Param('c').") AND SET_ACC_CODE LIKE ".$sql->Param('d')."  ORDER BY SET_INPUTTEDDATE DESC ";
				$input=array($actor_facilitycode,"%".$fdsearch."%","%".$fdsearch."%",$srvcategory);
		}
			
				
			}
				
		
	}




if(!isset($limit)){
	$limit = $session->get("limited");
}else if(empty($limit)){
	$limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'action=index&pg='.$pg.'&option='.$option,$input);
$stmt= $sql->Execute($sql->Prepare("SELECT * FROM hms_settlement_paymodes  WHERE  SETM_STATUS='1' ORDER BY SETM_NAME ASC"),array());