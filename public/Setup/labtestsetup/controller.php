<?php
//print_r($_POST);
$crypt = new cryptCls();
$actorid = $session->get("userid");
$actorname = $engine->getActorName();
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$objdtls = $engine->getFacilityDetails();
$facilityalias = $objdtls->FACI_ALIAS ;
$activeinstitution = $objdtls->FACI_CODE ;

switch($viewpage){
	case "savelab":
	
	if(empty($labtest) || empty($testprice)){
	$msg = "Failed. Required field(s) can't be empty!.";
	$status = "error";
	$view ='add';
	}else{

	$lab = explode('@@@', $labtest);
	$lcode = $lab['0'];
	$lname = $lab['1'];

	if (isset($keys) && !empty($keys)){
	    //Do Edit Here
        $stmt = $sql->Execute($sql->Prepare("UPDATE hms_lab_testprice SET LL_PRICE = ".$sql->Param('a')." WHERE LL_CODE = ".$sql->Param('b')),array($testprice,$keys));
        print $sql->ErrorMsg();

        if ($stmt){
            $msg = "Laboratory Test Price successfully updated";
            $status = "success";
            $view ='';
        }else{
            $msg = "An error occurred while updating Lab Test Price. Try again!";
            $status = "error";
            $view ='add';
        }
    }else{
	    //Do insertion here
        $stmt = $sql->Execute($sql->Prepare("SELECT * from hms_lab_testprice WHERE LL_TESTCODE = ".$sql->Param('1')." and LL_FACICODE = ".$sql->Param('2')." AND LL_STATUS = '1'"),array($lcode,$activeinstitution));
        print $sql->ErrorMsg();

        if($stmt->RecordCount() > 0){

            $msg = "Failed. Lab Test exist Already";
            $status = "error";
            $view ='add';

        }else{
            $ttcode = $engine->labtestpricecode();
            $stmt_insert = $sql->Execute($sql->Prepare("INSERT INTO hms_lab_testprice(LL_CODE, LL_DATE, LL_TESTCODE, LL_TESTNAME, LL_FACICODE,LL_PRICE) VALUES (".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').")"),array($ttcode,$startdate,$lcode,$lname,$activeinstitution,$testprice));
            print $sql->ErrorMsg();
            if ($stmt_insert){
                $msg = "Success:Saved successfully";
                $status = "success";
                $view ='';
            }
        }
    }

    }
	break;

    case "editlabprice":
        if (isset($keys) && !empty($keys)){
            $stmt = $sql->Execute($sql->Prepare("SELECT LL_CODE,LL_FACICODE,LL_DATE,LL_PRICE,LL_TESTCODE,LL_TESTNAME,LL_STATUS FROM hms_lab_testprice WHERE LL_CODE=".$sql->Param('a')." AND LL_STATUS=".$sql->Param('b')),array($keys,'1'));
            print $sql->ErrorMsg();
            if ($stmt->RecordCount()>0){
                $obj = $stmt->FetchNextObject();

                $testprice = $obj->LL_PRICE;
                $labtest = $obj->LL_TESTCODE;
//                $labtest = $obj->LL_TESTNAME;
            }
        }
    break;

    case "deletelabprice":
        if (isset($keys) && !empty($keys)){
            $stmt = $sql->Execute($sql->Prepare("UPDATE hms_lab_testprice SET LL_STATUS='0' WHERE LL_CODE=".$sql->Param('a')),array($keys));
            print $sql->ErrorMsg();

            if ($stmt){
                $msg = "Success: Laboratory Test Price has been successfully updated.";
                $status = "success";
                $view ='';
            }
        }
    break;
	
	case "reset":
	   $fdsearch = $action_search = "";
	break;
}


$stmttestlov = $sql->Execute($sql->prepare("SELECT * from hmsb_st_labtest "));
		
if(isset($action_search) && $action_search == "search"){
	if(!empty($fdsearch)){
    $query = "SELECT * FROM hms_lab_testprice WHERE  LL_FACICODE = ".$sql->Param('1')." AND ( LL_TESTNAME LIKE ".$sql->Param('b')." OR LL_TESTCODE LIKE ".$sql->Param('c')." OR LL_PRICE = ".$sql->Param('e')." AND LL_STATUS = '1') ORDER BY LL_ID DESC";
    $input = array($activeinstitution,$fdsearch.'%',$fdsearch.'%',$fdsearch);
	}
}else{

    $query = "SELECT * FROM hms_lab_testprice WHERE LL_FACICODE = ".$sql->Param('1')." AND LL_STATUS = '1' ORDER BY LL_ID DESC";
    $input = array($activeinstitution);
}


if(!isset($limit)){
    $limit = $session->get("limited");
}else if(empty($limit)){
    $limit =20;
}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'index.php?pg=ad2376beebecdcf7846ba973fa1a005b&option=6831b98f85019ddb98bd98d44bdbac40#',$input);

//Get all positions
$stmtpos2 = $engine->getUserPosition();
?>