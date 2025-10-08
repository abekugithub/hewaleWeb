<?php
// Get Doctor Code
$actor_id = $engine->getActorCode();
$userInfo = $engine->getActorDetails();
$facilitycode = $engine->getFacilityDetails();
$actor_facilitycode =!empty($facilitycode->FACI_CODE)?$facilitycode->FACI_CODE:$actor_id;
//die($actor_facilitycode);

// die($actor_id);
$result=[];
switch ($viewpage){
	case 'transfer_payment':
		
		$modetype = explode("@#@",$modetype );
		$modetype = $modetype[0];
		
		
		if(!empty($modetype) && !empty($phone) && !empty($amount)){
			$totamtper = $amount * $perc;
			$totamt    = $amount + $totamtper;
			// echo $totamtper.' '.$totamt;
			
			
			if($bal > $totamt){
				// die("akos");
				// $describe=urlencode("movement of funds into facillity mobile money accounts");
				// $describe=$amount." movement of funds into facillity mobile money accounts";
				$describe='An amount ' .$amount. '.00  was moved from social health wallet on  '.date('Y-m-d H:i:s'). ' to momo account';
				
				// $token=$userInfo->USR_TOKEN;
				// die($token);
				//  	if(!empty($token)){
					//  		$mytoken=$token;
					//  	}else{
						
						// // die($actor_id);
						//  		$mytoken1= $engine->getToken();
						//  		$stmt=$sql->Execute($sql->Prepare("UPDATE hms_users SET USR_TOKEN=".$sql->Param('a')." WHERE USR_CODE=".$sql->Param('a')." "),array($mytoken1,$actor_facilitycode));
						//  		if($stmt==true){
							//  			$token1=$userInfo->USR_TOKEN;
							//  			$mytoken=$token1;
							//  		}
							
							
							//  	}
							$actins="credituseraccount";
							$apiKey="d24qwk2d210e35ww3f3wd540e";
							$secretKey="cds59333sd2sGGa2s432c0G97";
							// $params= array("action"=>$actins,"apiKey"=>$apiKey,"secretKey"=>$secretKey,"payamount"=>$amount,"payaccountno"=>$phone,"description"=>$describe,"paymode"=>$modetype);
							// die(var_dump($params));
							// 	  $url=("https://www.smartpaygh.com/api/");
							// $params= array("usercode"=>$actor_facilitycode,"amount"=>$amount,"actions"=>$action,"token"=>$mytoken,"phone"=>$phone,"describe"=>$describe,"modetype"=>$modetype);
							//  	 $url=("http://localhost:8089/api_socialhealthdoctors/");
							// $params=array();
							// $url="http://localhost:8080/api_socialhealthdoctors?actions=paywallettransaction&usercode=$actor_id&token=$token&amount=$amount&modetype=$modetype&describe=$describe&phone=$phone";
							// $result  = (array) json_decode( file_get_contents($url));
							//https://www.smartpaygh.com/api/index.php?apiKey=d24qwk2d210e35ww3f3wd540e&secretKey=cds59333sd2sGGa2s432c0G97&action=credituseraccount&payamount=0.50&payaccountno=0249062752&paymode=0908172&description=with draw
							// die(var_dump($result));
							// $url="https://www.smartpaygh.com/api/index.php?apiKey=d24qwk2d210e35ww3f3wd540e&secretKey=cds59333sd2sGGa2s432c0G97&action=credituseraccount&payamount={$amount}&payaccountno={$phone}&paymode={$modetype}&description={$describe}";
							// // echo $url;
							$url="https://www.smartpaygh.com/api/index.php?apiKey=d24qwk2d210e35ww3f3wd540e&secretKey=cds59333sd2sGGa2s432c0G97&action=credituseraccount&payamount={$amount}&payaccountno={$phone}&paymode={$modetype}&description=movement of funds into facillity mobile money accounts";
							// echo $url."<br>";
							// var_dump(file_get_contents($url));
							// die();
							
							$result  = (array) json_decode( file_get_contents($url));
							
							// $result  = $engine->curlMain($params,$url);
							//  die(var_dump($result));
							
							// echo $result['status'];
							// die();
							$usertype=$engine->getWalletDetails($actor_facilitycode)->HRMSWAL_USERTYPE;
							$walletcode=$engine->getWalletDetails($actor_facilitycode)->HRMSWAL_CODE;
							
							$transcode=$engine->getTransCode();
							// echo $transcode.'<br> '.$walletcode.'<br> '.$usertype;
							// die();
							// die(var_dump());1827ef0a8638
							if($result['status']=='success'){
								$token1 =($result['response']);
								$token1 = $token1->token;
								// echo $token1;
								
								
								
								
								
								
								//matt: updating Balance
								$new_balance  = $bal - $totamt;
								$stmt = $sql->Execute($sql->Prepare("UPDATE hms_wallets SET HRMSWAL_BALANCE = ".$sql->Param('a')." WHERE HRMSWAL_CODE=".$sql->Param('a')." "),[$new_balance, $walletcode]);
								print   $errormsg = $sql->ErrorMsg(); 
								//matt
								
								
								
								/**
								* `HRMSTRANS_ID`, `HRMSTRANS_CODE`, `HRMSTRANS_WALCODE`, `HRMSTRANS_USERCODE`, `HRMSTRANS_USERTYPE`, `HRMSTRANS_AMOUNT`, `HRMSTRANS_DATE`, `HRMSTRANS_RECEIVER`, `HRMSTRANS_STATUS`, `HRMSTRANS_TYPE`, `HRMSTRANS_DESCRIPTION`, `HRMSTRANS_INPUTDATE`, `HRMSTRANS_CONFIRM_STATUS`, `HRMSTRANS_TRANS_TOKEN`, `HRMSTRANS_TRANS_ACC`, `HRMSTRANS_DEDU_AMOUNT`, `HRMSTRANS_COURIER_AMOUNT`, `HRMSTRANS_COURIER_NAME`, `HRMSTRANS_COURIER_CODE`, `HRMSTRANS_SUCCESS_ACTION`, `HRMSTRANS_SUCCESS_DATA`, `HRMSTRANS_SUCCESS_TOKEN`, `HRMSTRANS_PACKAGECODE`
								* 
								*/
								
								$stmt = $sql->Execute("INSERT INTO hms_wallet_transaction (HRMSTRANS_CODE,HRMSTRANS_WALCODE,HRMSTRANS_USERCODE,HRMSTRANS_USERTYPE,HRMSTRANS_AMOUNT,HRMSTRANS_DATE,HRMSTRANS_RECEIVER,HRMSTRANS_STATUS,HRMSTRANS_TYPE,HRMSTRANS_DESCRIPTION,HRMSTRANS_TRANS_TOKEN,HRMSTRANS_TRANS_ACC) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('f').",".$sql->Param('f').",".$sql->Param('f').",".$sql->Param('f').",".$sql->Param('f').",".$sql->Param('f').")",array($transcode, $walletcode,$actor_id,$usertype,$amount,date('Y-m-d H:i:s'),$actor_facilitycode,'2','3',$describe,$token1,$phone));
								print $sql->ErrorMsg();
								// var_dump($stmt);
								$eventype = '097';
								$activity = 'facility  with ID. '.$actor_facilitycode.'moved this amount ' .$amount. '.00 from social health wallet on  '.date('Y-m-d H:i:s'). ' to smartpay';
								
							}else{
								$msg = "Transfer failed. Try again"; $status = "error";	
								
							}
							
							//  
							
							
							
							
							
							// $percentage=$engine->userPercentage($actor_facilitycode);
							// $transcode=$engine->getTransCode();
							
							// echo $percentage;
							// die();
							
							// if($result['response']== true){
								
								
								// $msg = "Transfer pending......"; $status = "success";
								// 					}else{
									// $msg = "Transfer failed. Try again"; $status = "error";	
									// 					}
								}else{
									$msg = "Insufficient funds"; $status = "error";	
								}
								
							}else{
								$msg = "All fields with * are required"; $status = "error"; 
								
							}
						break;
						
					}
					
					
					
					$endpoint = "https://smartpaygh.com/api/";
					// $endpoint = "localhost:8080/smartpayapi/";
					$apikey='d24qwk2d210e35ww3f3wd540e';
					$secretKey='cds59333sd2sGGa2s432c0G97';
					$action='getallmodes';
					$params=array("apiKey"=>$apikey,"secretKey"=>$secretKey,"action"=>$action);
					// $modes = file_get_contents('?apiKey=d24qwk2d210e35ww3f3wd540e&secretKey=cds59333sd2sGGa2s432c0G97&action=getallmodes');
					$modes  = $engine->curlMain($params, $endpoint,false);
					// die(var_dump($modes));
					// $modes = (array) json_decode($modes);
					
					$modes = (array) $modes['modes'];
					
					
					if(isset($action_search) && $action_search == "search"){
						if(!empty($fdsearch)){
							$query = "SELECT HRMSTRANS_ID,HRMSTRANS_CODE,HRMSTRANS_WALCODE,HRMSTRANS_USERCODE,HRMSTRANS_USERTYPE,HRMSTRANS_AMOUNT,HRMSTRANS_DATE,HRMSTRANS_RECEIVER,HRMSTRANS_STATUS,HRMSTRANS_INPUTDATE,HRMSTRANS_TRANS_ACC,USR_CODE,USR_SURNAME,USR_OTHERNAME FROM hms_wallet_transaction JOIN hms_users ON HRMSTRANS_USERCODE=USR_CODE  WHERE HRMSTRANS_RECEIVER = ".$sql->Param('a')." AND ( USR_SURNAME LIKE ".$sql->Param('b')." OR USR_OTHERNAME LIKE ".$sql->Param('c')." )  ORDER BY CONS_INPUTDATE";
							$input = array($actor_facilitycode,'%'.$fdsearch.'%',$fdsearch.'%');
						}
					}else {
						
						// $query = "SELECT HRMSTRANS_ID,HRMSTRANS_CODE,HRMSTRANS_WALCODE,HRMSTRANS_USERCODE,HRMSTRANS_USERTYPE,HRMSTRANS_AMOUNT,HRMSTRANS_DATE,HRMSTRANS_RECEIVER,HRMSTRANS_STATUS,HRMSTRANS_INPUTDATE,USR_CODE,USR_SURNAME,USR_OTHERNAME,HRMSWAL_USERTYPE,HRMSTRANS_TRANS_ACC FROM hms_wallet_transaction JOIN hms_users ON HRMSTRANS_USERCODE=USR_CODE JOIN hms_wallets ON  HRMSWAL_USERCODE = HRMSTRANS_USERCODE WHERE HRMSTRANS_RECEIVER = ".$sql->Param('a')."  ORDER BY HRMSTRANS_DATE DESC";  
						// $query = "SELECT HRMSTRANS_ID,HRMSTRANS_CODE,HRMSTRANS_WALCODE,HRMSTRANS_USERCODE,HRMSTRANS_USERTYPE,HRMSTRANS_AMOUNT,HRMSTRANS_DATE,HRMSTRANS_RECEIVER,HRMSTRANS_STATUS,HRMSTRANS_INPUTDATE,HRMSWAL_USERTYPE,HRMSTRANS_TRANS_ACC FROM hms_wallet_transaction  JOIN hms_wallets ON  HRMSWAL_USERCODE = HRMSTRANS_USERCODE WHERE HRMSTRANS_RECEIVER = ".$sql->Param('a')."  ORDER BY HRMSTRANS_DATE DESC";
						
						$query="SELECT HRMSTRANS_ID,HRMSTRANS_CODE,HRMSTRANS_WALCODE,HRMSTRANS_USERCODE,HRMSTRANS_USERTYPE,HRMSTRANS_AMOUNT,HRMSTRANS_DATE,HRMSTRANS_RECEIVER,HRMSTRANS_TRANS_ACC,HRMSTRANS_STATUS,HRMSTRANS_CONFIRM_STATUS FROM hms_wallet_transaction   WHERE HRMSTRANS_RECEIVER = ".$sql->Param('a')."  ORDER BY HRMSTRANS_DATE DESC";
						$input = array($actor_facilitycode);
					}
					
					
					if(!isset($limit)){
						$limit = $session->get("limited");
					}else if(empty($limit)){
						$limit =20;
					}
					$session->set("limited",$limit);
					$lenght = 10;
					$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=156e132b014314b1eae89410e54bcc8c&option=d1cbc766755b71cadbae46ea30ae4e1a',$input);
					
					$stmdd=$sql->Execute($sql->Prepare("SELECT POL_VALUE FROM hmsb_policy_settings WHERE POL_NAME=".$sql->Param('a')." AND POL_OWNER_CODE=".$sql->Param('a')." "),array('momo_out',$actor_facilitycode));
					// var_dump($stmdd);
					if($stmdd->RecordCount() > 0){
						$eobjd=$stmdd->FetchNextObject();
						$disco= $eobjd->POL_VALUE / 100;
						
					}else{
						$stmdds=$sql->Execute($sql->Prepare("SELECT POL_VALUE FROM hmsb_policy_settings WHERE POL_NAME=".$sql->Param('a')." AND POL_OWNER_CODE=".$sql->Param('a')."  "),array('momo_out','1'));
						$obej  = $stmdds->FetchNextObject();
						$disco = $obej->POL_VALUE / 100;
					}
					// die($disco);
					
					$stmtd=$sql->Execute($sql->Prepare("SELECT HRMSWAL_USERCODE,HRMSWAL_BALANCE FROM hms_wallets WHERE HRMSWAL_USERCODE=".$sql->Param('a')." "),array($actor_facilitycode));
					if($stmtd->RecordCount() > 0){
						$editobj= $stmtd->FetchNextObject();
						$balace=$editobj->HRMSWAL_BALANCE;
					}							
					//chart values from january to december
					$jan= empty($engine->getSumMonth('1',$actor_facilitycode))?'0':$engine->getSumMonth('1',$actor_facilitycode);
					$feb= empty($engine->getSumMonth('2',$actor_facilitycode))?'0':$engine->getSumMonth('2',$actor_facilitycode);
					$mar= empty($engine->getSumMonth('3',$actor_facilitycode))?'0':$engine->getSumMonth('3',$actor_facilitycode);
					$apr= empty($engine->getSumMonth('4',$actor_facilitycode))?'0':$engine->getSumMonth('4',$actor_facilitycode);
					$may= empty($engine->getSumMonth('5',$actor_facilitycode))?'0':$engine->getSumMonth('5',$actor_facilitycode);
					$jun= empty($engine->getSumMonth('6',$actor_facilitycode))?'0':$engine->getSumMonth('6',$actor_facilitycode);
					$jul= empty($engine->getSumMonth('7',$actor_facilitycode))?'0':$engine->getSumMonth('7',$actor_facilitycode);
					$aug= empty($engine->getSumMonth('8',$actor_facilitycode))?'0':$engine->getSumMonth('8',$actor_facilitycode);
					$sep= empty($engine->getSumMonth('9',$actor_facilitycode))?'0':$engine->getSumMonth('9',$actor_facilitycode);
					$oct= empty($engine->getSumMonth('10',$actor_facilitycode))?'0':$engine->getSumMonth('10',$actor_facilitycode);
					$nov= empty($engine->getSumMonth('11',$actor_facilitycode))?'0':$engine->getSumMonth('11',$actor_facilitycode);
					$dec= empty($engine->getSumMonth('12',$actor_facilitycode))?'0':$engine->getSumMonth('12',$actor_facilitycode);
					
					
					?>
					
					
					