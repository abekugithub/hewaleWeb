<?php
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();
$objdtls = $engine->getFacilityDetails();
$facilityalias = $objdtls->FACI_ALIAS ;
$faccode = $objdtls->FACI_CODE ;
switch($viewpage){
	case 'savesales'://save the sales
		//print_r($_REQUEST); die();
	$session->del('salecode');
	$salecode = $engine->pharmacysaleCode();
	$salesid = date('Ymdhis').uniqid().$usrcode;
	 if (count($_POST['code'])>0){
$counter= is_array($_POST['code'])?count($_POST['code']):0;
	for($i=1;$i<=$counter;$i++){
		if ($_POST['type'][$i]=='NEW'){
			$newdrugs[]=$i;
		}
		
		$finarray[] = '(
				"'.$salecode.'",
				"'.$_POST['code'][$i].'",
				"'.$_POST['drugname'][$i].'",
				"'.$_POST['dosagename'][$i].'",
				"'.$_POST['quantity'][$i].'",
				"'.$_POST['cost'][$i].'",
				"'.$_POST['insurance'][$i].'",
				"'.$customername.'",
				"'.$usrcode.'",
				"'.$usrname.'",
				"'.$faccode.'",
				"'.$_POST['method'][$i].'",
				"'.$_POST['methodcode'][$i].'",
				"'.'2'.'",
				"'.$salesid.'"
				
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
				"'.$_POST['code'][$newdrugindex].'",
				"'.date('Y-m-d').'",
				"'.$faccode.'"
			)';
			$newpricearray[] = '(
			
				"'.$pharmacypricecode.'",
				"'.$faccode.'",
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
	 $listtomove = is_array($finarray)?implode(',', $finarray):'';
	 $newdrugsarray = is_array($newdrugsarray)?implode(',', $newdrugsarray):'';
	 $newpricearray = is_array($newpricearray)?implode(',', $newpricearray):'';
	
  		//INSERT INTO the sales table
  		$stmt= $sql->Execute($sql->Prepare("INSERT INTO hms_pharmacysales(SAL_CODE, SAL_DRUGCODE, SAL_DRUG, SAL_DOSAGE, SAL_QUANTITY, SAL_COST, SAL_NHIS, SAL_CUSTOMER, SAL_USERCODE,SAL_USERNAME, SAL_FACICODE, SAL_METHOD, SAL_METHODCODE, SAL_STATUS, SAL_UNIQCODE)VALUES $listtomove"));
  		print $sql->ErrorMsg();
  		if ($stmt==TRUE){
  		//INSERT NEW DRUGS
  			if(count($newdrugs)>0){
  			$stmtins=$sql->Execute($sql->Prepare("INSERT INTO hms_pharmacystock(ST_NAME,ST_DOSAGENAME,ST_CODE,ST_DATE,ST_FACICODE) VALUES $newdrugsarray"));
  			$stmtinsprice=$sql->Execute($sql->Prepare("INSERT INTO hms_pharmacyprice(PPR_CODE,PPR_FACICODE,PPR_DRUG,PPR_DRUGCODE,PPR_PRICE) VALUES $newpricearray"));
  		}
  			//deduct quantity from stock
  			
  				for($j=1;$j<=$counter;$j++){
  			//	print_r($key);
  		//		echo "BOOOOOOOOOOOOOOOOOOOOOOOOOM"; die();
  			$stmtdeduct = $sql->Execute($sql->Prepare("UPDATE hms_pharmacystock SET ST_STORE_QTY=ST_STORE_QTY -".$sql->Param('a')." WHERE ST_FACICODE=".$sql->Param('b')." AND ST_CODE=".$sql->Param('c')." "),array($_POST['quantity'][$j],$faccode,$_POST['code'][$j]));
  			print $sql->ErrorMsg();
  			}
  			if ($stmtdeduct==TRUE){
  				$view="receipt";
  				$msg="Sale successfully completed";
  				$status="success";
  				$session->del('cart');
  				$session->set('salecode',$salecode);
  				
  			}
  		}
}else{
		$msg='Please select a drug';
		$status='error';
	}
	break;	
}

//$stmtdrugs = $sql->Execute($sql->Prepare("SELECT IFNULL(ST_NAME,DR_NAME)ST_NAME,IFNULL(ST_DOSAGENAME,DR_DOSAGENAME) ST_DOSAGE,ST_SHEL_QTY,ST_STORE_QTY,IFNULL(PPR_PRICE,'0') PPR_PRICE,PPR_NHIS,IFNULL(ST_CODE,DR_CODE) ST_CODE from hms_pharmacystock JOIN hms_pharmacyprice ON ST_CODE=PPR_DRUGCODE RIGHT JOIN hmsb_st_phdrugs ON ST_CODE=DR_CODE WHERE (ST_FACICODE =".$sql->Param('a')." OR ST_FACICODE IS NULL ) AND (ST_STATUS=".$sql->Param('b')." OR ST_STATUS IS NULL) "),array($faccode,'1'));

	
$stmtdrugs = $sql->Execute($sql->Prepare("SELECT TRIM(ST_NAME)ST_NAME,ST_DOSAGENAME ST_DOSAGE,ST_SHEL_QTY,ST_STORE_QTY,IFNULL(PPR_PRICE,0) PPR_PRICE,IFNULL(PPR_NHIS,0)PPR_NHIS,TRIM(ST_CODE)ST_CODE from hms_pharmacystock JOIN hms_pharmacyprice ON ST_CODE=PPR_DRUGCODE WHERE ST_FACICODE =".$sql->Param('a')." AND PPR_METHODCODE=".$sql->Param('b')." AND ST_STATUS=".$sql->Param('c')." "),array($faccode,'PMT0010','1'));
		if($stmtdrugs->RecordCount()>0){
		while($objdrugs=$stmtdrugs->FetchNextObject()){
			$drugsarray[$objdrugs->ST_CODE]=array('ST_NAME'=>$objdrugs->ST_NAME,'ST_DOSAGENAME'=>$objdrugs->ST_DOSAGENAME,'ST_DOSAGE'=>$objdrugs->ST_DOSAGE,'ST_SHEL_QTY'=>$objdrugs->ST_SHEL_QTY,'ST_STORE_QTY'=>$objdrugs->ST_STORE_QTY,'PPR_PRICE'=>$objdrugs->PPR_PRICE,'PPR_NHIS'=>$objdrugs->PPR_NHIS,'ST_CODE'=>$objdrugs->ST_CODE);
		}
	}
$stmtdrugs1=$sql->Execute($sql->Prepare("SELECT TRIM(DR_NAME) ST_NAME,DR_DOSAGENAME ST_DOSAGE,'0' ST_SHEL_QTY,'0' ST_STORE_QTY,'0' PPR_PRICE,'0' PPR_NHIS,TRIM(DR_CODE) ST_CODE from hmsb_st_phdrugs WHERE DR_CODE NOT IN(SELECT ST_CODE from hms_pharmacystock JOIN hms_pharmacyprice ON ST_CODE=PPR_DRUGCODE WHERE ST_FACICODE=".$sql->Param('a')." AND PPR_METHODCODE=".$sql->Param('b')." AND ST_STATUS=".$sql->Param('c')." ) AND DR_STATUS =".$sql->Param('c')." "),array($faccode,'PMT0010','1','1'));
	if($stmtdrugs1->RecordCount()>0){
		while($objdrugs1=$stmtdrugs1->FetchNextObject()){
			$drugs1array[$objdrugs1->ST_CODE]=array('ST_NAME'=>$objdrugs1->ST_NAME,'ST_DOSAGENAME'=>$objdrugs1->ST_DOSAGENAME,'ST_DOSAGE'=>$objdrugs1->ST_DOSAGE,'ST_SHEL_QTY'=>$objdrugs1->ST_SHEL_QTY,'ST_STORE_QTY'=>$objdrugs1->ST_STORE_QTY,'PPR_PRICE'=>$objdrugs1->PPR_PRICE,'PPR_NHIS'=>$objdrugs1->PPR_NHIS,'ST_CODE'=>$objdrugs1->ST_CODE);
		}
	}

	if ((is_array($drugsarray) && count($drugsarray)>0) && is_array($drugs1array)){
	$finaldrugsarray=array_merge($drugsarray,$drugs1array);
	//$finaldrugsarray=sort($drugsarray);
	function compareByName($finaldrugsarray, $b) {
	return strcmp($finaldrugsarray["ST_NAME"], $b["ST_NAME"]);
	}
	usort($finaldrugsarray, 'compareByName');
	}else{
		$finaldrugsarray=$drugs1array;
		function compareByName($finaldrugsarray, $b) {
	  	return strcmp($finaldrugsarray["ST_NAME"], $b["ST_NAME"]);
	}
	usort($finaldrugsarray, 'compareByName');
	}
//	$finaldrugsarray=array_merge($drugsarray,$drugs1array);
	//$finaldrugsarray=sort($drugsarray);
//	function compareByName($finaldrugsarray, $b) {
//	  return strcmp($finaldrugsarray["ST_NAME"], $b["ST_NAME"]);
//	}
//	usort($finaldrugsarray, 'compareByName');
	

	


if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=ad2376beebecdcf7846ba973fa1a005b&option=6831b98f85019ddb98bd98d44bdbac40#',$input);

//Get all positions
$stmtpos = $engine->getUserPosition();
include('model/js.php');
include('model/js1.php');

?>