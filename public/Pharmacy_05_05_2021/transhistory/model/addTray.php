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
		
		$num = 1;
		$cartprepare = $session->get('cartprepare');
		if (empty($cartprepare) || !empty($cartprepare)){
		//adding a new drug	
		//$paymentmethod=(!empty($paymentmethod)?explode('|',$paymentmethod):'');
		
		$stmt = $sql->Execute($sql->Prepare("SELECT ST_NAME,ST_DOSAGE,ST_SHEL_QTY,PPR_PRICE,PPR_NHIS,ST_CODE,PPR_METHODCODE,PPR_METHOD from hms_pharmacystock JOIN hms_pharmacyprice ON ST_CODE=PPR_DRUGCODE WHERE ST_FACICODE =".$sql->Param('a')." AND ST_STATUS=".$sql->Param('b')." AND ST_CODE IN ($drugid) AND ST_STORE_QTY > ".$sql->Param('d')." "),array($faccode,'1','0'));	
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
					/**<input onkeyup="doSum('quantity<?php echo $i;?>','cost<?php echo $i;?>','total<?php echo $i;?>')" type="text" class="form-control" id="cost<?php echo $i;?>" name="cost[<?php echo $i;?>]" value="<?php echo number_format($key['COST'],2)?>">
					**/
					//echo '<script>alert(\'book\')</script>';
					//in_array
	//				$cost = !in_array($obj->ST_CODE,$drugcheck)?'1':'';
				//	$quantity = !in_array($obj->ST_CODE,$drugcheck)?$quantity:;
					
					//$quantity= !empty($_POST['quantity'][1])?$_POST['quantity'][1]:$_POST['quantity'][1];
					$results[]=array("<tr><td>".$counter--."</td>
					<td>".$obj->ST_NAME."</td><td>".$obj->ST_DOSAGE."</td>
					<td><input type='text' class='form-control' id=cost.$num name='cost[$num]' value='$cost'></td>
					<td><input type='text' class='form-control' id='quantity'.$num name='quantity[$num]' value='1'></td>
					<td></td>
					<td><button type='button' id='deletecomplain' onclick='deleteComplains(\"".$obj->ST_CODE."\",\"Prescription\");' class=\"btn-danger removecomplain\">&times;</button></td></tr>");
					$result = array_reverse($results);
					
				}
				
			}
			
			//$view="prepareimage";
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
			
		$result[]=array("<tr><td>".$num++."</td><td>".$obj->ST_NAME."</td><td>".$obj->ST_DOSAGE."</td><td>".$cost."</td><td>".'1'."</td><td></td><td><button type='button' id='deletecomplain' onclick='deleteComplains(\"".$obj->ST_CODE."\",\"Prescription\");' class=\"btn-danger removecomplain\">&times;</button></td></tr>");
				
			}
			
			$view="prepareimage";
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






if (!empty($drugcode)&&!empty($drugname)){
	$drugname = $encaes->encrypt($drugname);
	$drugcode = $encaes->encrypt($drugcode);
//	$routename = $encaes->encrypt($routename);

    $precode = $engine->getprescriptionCode();
//    $qty = $frequency * $days * $times ;

    $prescriptioncheck = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_prescription WHERE PRESC_STATUS='1' AND PRESC_DRUGID=".$sql->Param('a')." AND PRESC_DRUG=".$sql->Param('a')." AND PRESC_VISITCODE=".$sql->Param('a')." AND (PRESC_PATIENTNUM=".$sql->Param('b')." OR PRESC_PATIENTCODE=".$sql->Param('b').")"),array($drugcode,$drugname,$visitcode,$patientnum,$patientcode));
    print $sql->ErrorMsg();

    if ($prescriptioncheck->RecordCount()>0){
        $fetchstmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_prescription WHERE PRESC_STATUS='1' AND PRESC_VISITCODE=".$sql->Param('a')." AND (PRESC_PATIENTNUM=".$sql->Param('b')." OR PRESC_PATIENTCODE=".$sql->Param('b').") ORDER BY PRESC_ID DESC"),array($visitcode,$patientnum,$patientcode));
        print $sql->ErrorMsg();
        $result = array();
        $num = 1;
        if ($fetchstmt->RecordCount()>0){
            while ($obj = $fetchstmt->FetchNextObject()){
				// Decrypt text with another key if necessary
				$decrypid = $obj->PRESC_ENCRYPKEY;
				if($decrypid != $activekey){
				$saltencrypt = $encryptkeys[$decrypid]['salt'];
                $pepperdecrypt =  $encryptkeys[$decrypid]['pepper'];
				$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
				}
				
				$drugname = $encaes->decrypt($obj->PRESC_DRUG);
                $result[]=array("<tr><td>".$num++."</td><td>".$drugname."</td><td>".$obj->PRESC_DAYS."</td><td>".$obj->PRESC_FREQ."</td><td>".$obj->PRESC_TIMES."</td><td>".$obj->PRESC_QUANTITY."</td><td>".$obj->PRESC_ROUTENAME."</td><td><button type='button' id='deletecomplain' onclick='deleteComplains(\"".$obj->PRESC_CODE."\",\"Prescription\");' class=\"btn-danger removecomplain\">&times;</button></td></tr>");
            }
        }
    }else{
        $stmtpresc = $sql->Execute($sql->Prepare("INSERT INTO hms_patient_prescription (PRESC_CODE,PRESC_PATIENT,PRESC_PATIENTNUM,PRESC_DATE,PRESC_VISITCODE,PRESC_DRUGID,PRESC_DRUG,PRESC_QUANTITY,PRESC_DOSAGENAME,PRESC_DOSAGECODE,PRESC_FREQ,PRESC_DAYS,PRESC_TIMES,PRESC_ACTORNAME,PRESC_ACTORCODE,PRESC_INSTCODE,PRESC_PATIENTCODE,PRESC_ENCRYPKEY,PRESC_ROUTECODE,PRESC_ROUTENAME) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').",".$sql->Param('7').",".$sql->Param('8').",".$sql->Param('9').",".$sql->Param('10').",".$sql->Param('11').",".$sql->Param('12').",".$sql->Param('13').",".$sql->Param('14').",".$sql->Param('15').",".$sql->Param('16').",".$sql->Param('16').",".$sql->Param('17').",".$sql->Param('18').",".$sql->Param('19').")"),
            array($precode,$patientname,$patientnum,$day,$visitcode,$drugcode,$drugname,$qty,$drugdosename,$drugdose,$frequency,$days,$times,$usrname,$usrcode,$activeinstitution,$patientcode,$encryptkey,$routecode,$routename));
        print $sql->ErrorMsg();
        if ($stmtpresc){
            $msg = "Consultation has been saved successfully";
            $status = "success";

            $fetchstmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_prescription WHERE PRESC_STATUS='1' AND PRESC_VISITCODE=".$sql->Param('a')." AND (PRESC_PATIENTNUM=".$sql->Param('b')." OR PRESC_PATIENTCODE=".$sql->Param('b').") ORDER BY PRESC_ID DESC"),array($visitcode,$patientnum,$patientcode));
            print $sql->ErrorMsg();
            $result = array();
            $num = 1;
            if ($fetchstmt->RecordCount()>0){
                while ($obj = $fetchstmt->FetchNextObject()){
			    // Decrypt text with another key if necessary
				$decrypid = $obj->PRESC_ENCRYPKEY;
				if($decrypid != $activekey){
				$saltencrypt = $encryptkeys[$decrypid]['salt'];
                $pepperdecrypt =  $encryptkeys[$decrypid]['pepper'];
				$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
				}
				
					$drugname = $encaes->decrypt($obj->PRESC_DRUG);
                    $result[]=array("<tr><td>".$num++."</td><td>".$drugname."</td><td>".$obj->PRESC_DAYS."</td><td>".$obj->PRESC_FREQ."</td><td>".$obj->PRESC_TIMES."</td><td>".$obj->PRESC_QUANTITY."</td><td>".$obj->PRESC_ROUTENAME."</td><td><button type='button' id='deletecomplain' onclick='deleteComplains(\"".$obj->PRESC_CODE."\",\"Prescription\");' class=\"btn-danger removecomplain\">&times;</button></td></tr>");
                }
            }
        }
    }
    echo json_encode($result);
}