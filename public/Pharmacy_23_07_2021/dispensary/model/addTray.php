<?php
ob_start();
include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
//$result=array();
$engine = new engineClass();
$day = Date("Y-m-d H:m:s");
$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();
$actor = $engine->getActorDetails();
$activeinstitution = $actor->USR_FACICODE;
$faccode = $actor->USR_FACICODE;
//if (is_array($drugid) /**&& !empty($paymentmethod)**/){
		//echo $drugid;
		//opening a cartprepare
		
		$counter = count($_POST['drugid']);
		$drugcheck=$_POST['drugid'];
		$drugid=is_array($_POST['drugid'])?(implode("','",$_POST['drugid'])):'';
		$drugid="'".$drugid."'";
		$instpercent= $sql->Execute($sql->Prepare("SELECT FACI_INST_PERCENTAGE from hmsb_allfacilities WHERE FACI_CODE=".$sql->Param('a').""),array($faccode));
		if ($instpercent->RecordCount()>0){
			$objcent=$instpercent->FetchNextObject();
			$facilitypercent=$objcent->FACI_INST_PERCENTAGE;
		}else{
		$facilitypercent='0';
		}
		$facilitypercent=($facilitypercent/100);
		$num = 1;
		$cartprepare = $session->get('cartprepare');
		if (empty($cartprepare) || !empty($cartprepare)){
		//adding a new drug	
		//$paymentmethod=(!empty($paymentmethod)?explode('|',$paymentmethod):'');
		/** $stmt = $sql->Execute($sql->Prepare("SELECT ST_NAME ,ST_DOSAGE ,ST_SHEL_QTY,PPR_PRICE,PPR_NHIS, ST_CODE,IFNULL(ST_CODE,'NEW') ST_TYPE,PPR_METHODCODE,PPR_METHOD from hms_pharmacystock JOIN hms_pharmacyprice ON ST_CODE=PPR_DRUGCODE WHERE PPR_FACICODE=".$sql->Param('a')." AND ST_FACICODE =".$sql->Param('a')."  AND ST_STATUS=".$sql->Param('b')." AND ST_CODE IN ($drugid) "),array($faccode,$faccode,'1'));
		 	//print_r($stmt);
                         if($stmt->RecordCount() == 0){
 $stmt = $sql->Execute($sql->Prepare("SELECT DR_NAME AS ST_NAME,DR_DOSAGENAME AS ST_DOSAGE,'0' AS ST_SHEL_QTY,'0' AS PPR_PRICE,'0' AS PPR_NHIS,DR_CODE AS ST_CODE,'NEW' AS ST_TYPE,'' AS PPR_METHODCODE,'' AS PPR_METHOD from hmsb_st_phdrugs  WHERE DR_CODE IN ($drugid)"));
                         }
		**/
		//$stmt = $sql->Execute($sql->Prepare("SELECT DR_NAME ST_NAME,IFNULL(ST_DOSAGENAME,DR_DOSAGENAME) ST_DOSAGE,IFNULL(ST_DOSAGE,DR_DOSAGE) ST_DOSAGECODE,IFNULL(ST_SHEL_QTY,'0')ST_SHEL_QTY,IFNULL(ST_STORE_QTY,0)ST_STORE_QTY,IFNULL(PPR_PRICE,0) PPR_PRICE,IFNULL(PPR_NHIS,0)PPR_NHIS,IFNULL(ST_CODE,DR_CODE) ST_CODE,IFNULL(ST_CODE,'NEW') ST_TYPE from hms_pharmacystock JOIN hms_pharmacyprice ON ST_CODE=PPR_DRUGCODE RIGHT JOIN hmsb_st_phdrugs ON DR_CODE=ST_CODE WHERE (ST_FACICODE =".$sql->Param('a')." OR DR_INSDT IS NULL OR DR_INSDT ='') AND (ST_STATUS=".$sql->Param('b')." OR DR_STATUS =".$sql->Param('c').") AND ST_CODE IN ($drugid) OR DR_CODE IN ($drugid)" ),array($faccode,'1','1'));
		$stmt = $sql->Execute($sql->Prepare("SELECT TRIM(DR_NAME) ST_NAME,DR_DOSAGENAME ST_DOSAGE,DR_DOSAGE ST_DOSAGECODE,ST_SHEL_QTY,ST_STORE_QTY,PPR_PRICE,PPR_NHIS,TRIM(DR_CODE) ST_CODE,ST_CODE ST_TYPE from hms_pharmacystock JOIN hms_pharmacyprice ON ST_CODE = PPR_DRUGCODE AND PPR_FACICODE = ".$sql->Param('c')." AND PPR_METHODCODE = ".$sql->Param('c')." AND ST_FACICODE = ".$sql->Param('c')." AND ST_STATUS=".$sql->Param('c')." RIGHT JOIN hmsb_st_phdrugs ON ST_CODE = DR_CODE WHERE DR_CODE IN ($drugid) " ),array($faccode,'PMT0010',$faccode,'1'));
			
		   print $sql->ErrorMsg();
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
						$nhis =	$obj->PPR_PRICE;//+($obj->PPR_PRICE*$facilitypercent);
					}else{
						//if it is not covered by nhis
						$cost=(!empty($obj->PPR_PRICE)?$obj->PPR_PRICE:'0');//+($obj->PPR_PRICE*$facilitypercent);
						$nhis ='0';
					}
					//$addedpercent=$cost +($cost*$facilitypercent);
					
					$_SESSION['cartprepare'][$drugid]=array(
					'CODE'=>$obj->ST_CODE,
					'NAME'=>$obj->ST_NAME,
					'SHEL'=>(!empty($obj->ST_SHEL_QTY)?$obj->ST_SHEL_QTY:'0'),//where deduction takes place
					'DOSAGE'=>$obj->ST_DOSAGE,
					'DOSAGECODE'=>$obj->ST_DOSAGECODE,
					'NHIS'=>$nhis,
					'COST'=>$cost,
					'QUANTITY'=>'1',
					'METHOD'=>$obj->PPR_METHOD,
					'METHODCODE'=>$obj->PPR_METHODCODE,
					);
					$type=(!empty($obj->ST_TYPE)?$obj->ST_TYPE:'NEW');
					$results[]=array("<tr><td>".$counter--."</td>
					<td>".$obj->ST_NAME."</td><td>".$obj->ST_DOSAGE."</td>
					<input type='hidden' value='$obj->ST_NAME' name='drugname[$num]'>
					<input type='hidden' value='$obj->ST_DOSAGE' name='dosagename[$num]'>
					<input type='hidden' value='$obj->ST_DOSAGECODE' name='dosagecode[$num]'>
					<td><input type='text' onkeyup=doSum('quantity$obj->ST_CODE','cost$obj->ST_CODE','total$obj->ST_CODE') class='form-control' id=cost$obj->ST_CODE name='cost[$num]' value='$cost'>
					<input type='hidden' value=$obj->ST_CODE name='code[$num]'>
					<input type='hidden' value=$type name='type[$num]'>
					</td>
					<td><input type='text' onkeyup=doSum('quantity$obj->ST_CODE','cost$obj->ST_CODE','total$obj->ST_CODE') class='form-control' id=quantity$obj->ST_CODE name='quantity[$num]' value='1'></td>
					<td><input readonly type='text' onkeyup=doSum('quantity$obj->ST_CODE','cost$obj->ST_CODE','total$obj->ST_CODE') class='form-control' id=total$obj->ST_CODE name='total' value='$cost'></td>
					<td><button type='button' onClick='deleteComplains(\"$obj->ST_CODE\")' id='removedr' class=\"btn-danger removeDrug\">&times;</button></td></tr>");
						$num++;
					$result = array_reverse($results);
					
				}
				
			}/**else{
			$result="BILOKD";
			}**/
			
			//$view="prepareimage";
		}else{
			$result="BinGOOOOOOOOO";
		}
		//$result=array('<tr><td>ONE</td><td>TWO</td><td>THREE</td><td>FOUR</td><td>FIVE</td></tr><br>');
		
	/**	}else{
			$result[]=array("UGLY");
			//if select field is left empty
			$msg='Please select a drug or payment method';
			$status='error';
			$view="prepareimage";
		}**/
		echo json_encode($result);
	//print_r($session->get('cartprepare'));
