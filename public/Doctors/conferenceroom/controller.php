<?php
$patientCls = new patientClass();
// Get Doctor Code
$actor_id = $engine->getActorCode();
// Get Doctor Facility Code
$actor = $engine->getActorDetails();
$actorname = $engine->getActorName();
$facility_code = $actor->USR_FACICODE;
$directoratecode = $actor->USR_VHGP_CODE ;
$actudate = date("Y-m-d");

//$actor = $engine->getActorDetails();
//echo $startdate11."___";

switch ($viewpage){
    case 'reset':
        $fdsearch = '';
        $view = '';
	break;
	
	case "confdetails":
     if(!empty($keys)){
		$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_conference_room WHERE CONF_CODE=".$sql->Param('a')." "),array($keys));
		$obj = $stmt->FetchNextObject();
		$roomname = $obj->CONF_ROOMNAME;
	 }
	break;

	case "savefirst":
	
	
	if(empty($confcode)){
		//echo "BEGIN han111".$confcode;
	$confcode = $engine->getconferenceCode();
	$roomname = uniqid();
     if(!empty($confname) && !empty($startdate) && !empty($starttime)){

		$date22 = str_replace('/', '-', $startdate);
		$sdate1=date("Y-m-d",strtotime($date22));
		
		
		if($sdate1 < date("Y-m-d")) {
			//echo  "thi is inside_________the date is =".date("Y-m-d"). "__the date from txtbox is ".$sdate1;
		
			$msg = "Date Cannot be lower than today";
			$status = "danger";
			$view = "setupconference";
		
		}else{
		//	echo  "this is outside_________________the date is =".date("Y-m-d"). "__the date from txtbox is ".$sdate1;
		
			//die;
		
	//	$sql->debug = true;
		$date22 = str_replace('/', '-', $startdate);
        $sdate1=date("Y-m-d",strtotime($date22));
		$stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_conference_room(CONF_CODE,CONF_NAME,CONF_ROOMNAME,CONF_DATE,CONF_TIME,CONF_ACTOR) VALUES(".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').",".$sql->Param('6').")"),
		array($confcode,$confname,$roomname,$sdate1,$starttime,$actor_id));
  		print $sql->ErrorMsg();

		$stmtpart = $sql->Execute($sql->Prepare("SELECT * FROM hms_conference_panels WHERE CONFER_CONFCODE=".$sql->Param('a')." "),array($confcode));

	}
	 }else{

		if(!empty($confname) && !empty($startdate) && !empty($starttime)){
			$stmt = $sql->Execute("UPDATE hms_conference_room SET CONF_NAME = ".$sql->Param('1').",CONF_DATE = ".$sql->Param('2').",CONF_TIME = ".$sql->Param('3')." ",
			array($confname,$sdate1,$starttime));
		print $sql->ErrorMsg();
	
		}

	 $stmtpart = $sql->Execute($sql->Prepare("SELECT * FROM hms_conference_panels WHERE CONFER_CONFCODE=".$sql->Param('a')." "),array($confcode));
	 }

	}
	// die;
	break;


	case "fetchcondeatils":

	//echo "___thhis __".$keys;
	if(!empty($keys)){
	$stmtc = $sql->Execute($sql->Prepare("SELECT * FROM hms_conference_room WHERE CONF_CODE=".$sql->Param('a')." "),array($keys));
	print $sql->ErrorMsg();
	$objc = $stmtc->FetchNextObject();
	$confname = $objc->CONF_NAME ;
	$startdate = $objc->CONF_DATE ;
	$starttime = $objc->CONF_TIME ;
	}
	break;

	case "updatecon":
//	$sql->debug = true;

	$date22 = str_replace('/', '-', $startdate);
    $sdate1=date("Y-m-d",strtotime($date22));
//echo $sdate1.'_@@@@@@@@@@@@@@@_'.$startdate;
	$stmt = $sql->Execute("UPDATE hms_conference_room SET CONF_NAME = ".$sql->Param('1').",CONF_DATE = ".$sql->Param('2').",CONF_TIME = ".$sql->Param('3')." WHERE CONF_CODE=".$sql->Param('a')."  ",
	array($confname1,$sdate1,$starttime1,$keys));
//	die;	
	break;

	case "listparts":
	//	echo $keys;
		// $sql->debug = true;
	$stmtpartlist = $sql->Execute($sql->Prepare("SELECT * FROM hms_conference_room JOIN hms_conference_panels ON CONF_CODE = CONFER_CONFCODE WHERE CONFER_CONFCODE = ".$sql->Param('a')." AND CONF_STATUS = '1'  " ),[$keys]);

	// $stmtpartlist = $sql->Execute($sql->Prepare("SELECT * FROM hms_conference_panels  JOIN hms_conference_room ON CONFER_CONFCODE = CONF_CODE  WHERE CONFER_CONFCODE = ".$sql->Param('a')." AND CONF_STATUS = '1'  " ),[$keys]);

	// $stmtoptions1 = $sql->Execute($sql->Prepare("SELECT * FROM hms_users JOIN hmsb_vhealthunit ON VHSUBDET_FACICODE = USR_FACICODE WHERE  VHSUBDET_MENUGPCODE = ".$sql->Param('a')." AND USR_CODE != ".$sql->Param('b')." "),array($directoratecode,$actor_id));
	// $obj1= $stmtoptions1->FetchNextObject();
//  die();

	break;
	
	
}

if(isset($action_search) && $action_search == "search"){
    if(!empty($fdsearch)){
        $query = "SELECT DISTINCT(CONS_PATIENTNUM) AS CONS_PATIENTNUM FROM hms_consultation JOIN hms_patient ON CONS_PATIENTNUM=PATIENT_PATIENTNUM WHERE CONS_DOCTORCODE = ".$sql->Param('a')." AND CONS_FACICODE = ".$sql->Param('a')." AND CONS_STATUS IN ('0','8','7','6','5','4','3','2','1') AND ( CONS_PATIENTNAME LIKE ".$sql->Param('b')." OR CONS_PATIENTNUM LIKE ".$sql->Param('c')." ) ";
        $input = array($actor_id,$facility_code,'%'.$fdsearch.'%',$fdsearch.'%');
    }
}else {
    
    $query = "SELECT COUNT(CONF_CODE) AS MEMBERS ,CONF_NAME,CONF_DATE,CONF_TIME,CONF_CODE,CONF_ACTOR FROM hms_conference_room JOIN hms_conference_panels ON CONF_CODE = CONFER_CONFCODE WHERE (CONFER_INVITEDBY = ".$sql->Param('a')." OR  CONFER_INVITED_USERID = ".$sql->Param('a').") AND CONF_STATUS = '1' AND CONF_DATE >=".$sql->Param('a')." GROUP BY CONF_CODE,CONF_NAME,CONF_DATE,CONF_TIME,CONF_ACTOR ";
    $input = array($actor_id,$actor_id,$actudate );
}
//CONFER_INVITEDBY
//CONFER_INVITED_USERID
if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=f77ccbdb203c19d3d52b12a85f33faf5&option=0a0bb39e17186a9701375cea2f6f73cd&uiid=c7e0e599d2520ee7fda7a45375e0e1b5',$input);

//Get all users
$stmtoptions = $sql->Execute($sql->Prepare("SELECT * FROM hms_users JOIN hmsb_vhealthunit ON VHSUBDET_FACICODE = USR_FACICODE WHERE  VHSUBDET_MENUGPCODE = ".$sql->Param('a')." AND USR_CODE != ".$sql->Param('b')." "),array($directoratecode,$actor_id));
// $sql->debug = true;


include('model/js.php');