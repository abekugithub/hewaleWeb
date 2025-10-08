<?php
// Get Doctor Code
$actor_id = $engine->getActorCode();
$userInfo= $engine->getActorDetails();


switch ($viewpage){
	case 'transfer_payment':

		

	if(!empty($modetype) && !empty($phone) && !empty($amount)){

		
		if($bal > $amount){

			$describe=urlencode("movement of funds into doctors mobile money accounts");
			$action="paywallettransaction";
 	$token=$userInfo->USR_TOKEN;
 	$params= array("usercode"=>$actor_id,"amount"=>$amount,"actions"=>$action,"token"=>$token,"phone"=>$phone,"describe"=>$describe,"modetype"=>$modetype);
 	$url=("https://hewale.net/api_doctors/");
 	// $url="http://localhost:8080/api_socialhealthdoctors/";
 	// $params=array();
 	// $url="http://localhost:8080/api_socialhealthdoctors?actions=paywallettransaction&usercode=$actor_id&token=$token&amount=$amount&modetype=$modetype&describe=$describe&phone=$phone";
 	$result  = $engine->curlMain($params,$url);
 	// $result  = (array) json_decode( file_get_contents($url));

 	// die();

 if($result['response']== true){
 	

	$msg = "Transfer pending......"; $status = "success";
						}else{
 $msg = "Transfer failed. Try again"; $status = "error";	
						}
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
        $query = "SELECT HRMSTRANS_ID,HRMSTRANS_CODE,HRMSTRANS_WALCODE,HRMSTRANS_USERCODE,HRMSTRANS_USERTYPE,HRMSTRANS_AMOUNT,HRMSTRANS_DATE,HRMSTRANS_RECEIVER,HRMSTRANS_STATUS,HRMSTRANS_INPUTDATE,USR_CODE,USR_SURNAME,USR_OTHERNAME FROM hms_wallet_transaction JOIN hms_users ON HRMSTRANS_USERCODE=USR_CODE  WHERE HRMSTRANS_RECEIVER = ".$sql->Param('a')." AND ( USR_SURNAME LIKE ".$sql->Param('b')." OR USR_OTHERNAME LIKE ".$sql->Param('c')." )  ORDER BY CONS_INPUTDATE";
        $input = array($actor_id,'%'.$fdsearch.'%',$fdsearch.'%');
    }
}else {

    $query = "SELECT HRMSTRANS_ID,HRMSTRANS_CODE,HRMSTRANS_WALCODE,HRMSTRANS_USERCODE,HRMSTRANS_USERTYPE,HRMSTRANS_AMOUNT,HRMSTRANS_DATE,HRMSTRANS_RECEIVER,HRMSTRANS_STATUS,HRMSTRANS_INPUTDATE,USR_CODE,USR_SURNAME,USR_OTHERNAME FROM hms_wallet_transaction JOIN hms_users ON HRMSTRANS_USERCODE=USR_CODE  WHERE HRMSTRANS_RECEIVER = ".$sql->Param('a')."  ORDER BY HRMSTRANS_DATE DESC";
    $input = array($actor_id);
}


if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=f77ccbdb203c19d3d52b12a85f33faf5&option=f6383c07b345b6560d170c5e09bea356&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);
$stmtd=$sql->Execute($sql->Prepare("SELECT HRMSWAL_USERCODE,HRMSWAL_BALANCE FROM hms_wallets WHERE HRMSWAL_USERCODE=".$sql->Param('a')." "),array($actor_id));
if($stmtd->RecordCount() > 0){
	$editobj= $stmtd->FetchNextObject();
	$balace=$editobj->HRMSWAL_BALANCE;
}							//chart values from january to december
 							$jan= empty($engine->getSumMonth('1',$actor_id))?'0':$engine->getSumMonth('1',$actor_id);
                            $feb= empty($engine->getSumMonth('2',$actor_id))?'0':$engine->getSumMonth('2',$actor_id); 
                            $mar= empty($engine->getSumMonth('3',$actor_id))?'0':$engine->getSumMonth('3',$actor_id);
                            $apr= empty($engine->getSumMonth('4',$actor_id))?'0':$engine->getSumMonth('4',$actor_id);
                            $may= empty($engine->getSumMonth('5',$actor_id))?'0':$engine->getSumMonth('5',$actor_id); 
                            $jun= empty($engine->getSumMonth('6',$actor_id))?'0':$engine->getSumMonth('6',$actor_id);
                            $jul= empty($engine->getSumMonth('7',$actor_id))?'0':$engine->getSumMonth('7',$actor_id);
                            $aug= empty($engine->getSumMonth('8',$actor_id))?'0':$engine->getSumMonth('8',$actor_id); 
                            $sep= empty($engine->getSumMonth('9',$actor_id))?'0':$engine->getSumMonth('9',$actor_id);
                            $oct= empty($engine->getSumMonth('10',$actor_id))?'0':$engine->getSumMonth('10',$actor_id);
                            $nov= empty($engine->getSumMonth('11',$actor_id))?'0':$engine->getSumMonth('11',$actor_id); 
                            $dec= empty($engine->getSumMonth('12',$actor_id))?'0':$engine->getSumMonth('12',$actor_id);

 ?>
 

