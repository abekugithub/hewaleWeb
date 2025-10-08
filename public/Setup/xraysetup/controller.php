<?php
//print_r($_POST);
$crypt = new cryptCls();
$actorid = $session->get("userid");
$actorname = $engine->getActorName();
$actorgroup = $engine->getUsergroup();
$startdate = date("Y-m-d H:m:s");
$objdtls = $engine->getFacilityDetails();
$facilityalias = $objdtls->FACI_ALIAS ;

switch($viewpage){
	case "edit":
	 if(isset($target) && !empty($target)){
		$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_xray_testprice WHERE XP_CODE = ".$sql->Param('a')." "),array($target));
		print $sql->ErrorMsg();
		if($stmt->RecordCount() == 1){
			$obj = $stmt->FetchNextObject();
			$testcode = $obj->XP_TESTCODE;
			$testname = $obj->XP_TESTNAME;
			$xray_testprice = $obj->XP_PRICE;
	    }
	}else{
	     $msg = 'The test you\'ve opted to edit does not exist. Try Again!';
	     $status = 'error';
     }
	break;

    case "delete":
        if (isset($target) && !empty($target)){
            $stmt = $sql->Execute($sql->Prepare("UPDATE hms_xray_testprice SET XP_STATUS='0' WHERE XP_CODE=".$sql->Param('a')),array($target));
            print $sql->ErrorMsg();
            if ($stmt){
                $msg = 'You have successfully deleted this test and price.';
                $status = 'success';
            }
        }
    break;
	
	case "saveprice":
	    if (!empty($xray_testprice) && !empty($xraytest)){
	        $xraytest = explode('@@@',$xraytest);
	        $testcode = $xraytest[0];
	        $testname = $xraytest[1];
	        if (isset($target) && !empty($target)){
	            // Update Test Price
                $stmt = $sql->Execute($sql->Prepare("UPDATE hms_xray_testprice SET XP_TESTCODE=".$sql->Param('a').",XP_TESTNAME=".$sql->Param('b').", XP_PRICE=".$sql->Param('c')." WHERE XP_CODE=".$sql->Param('d')),array($testcode,$testname,$xray_testprice,$target));
                print $sql->ErrorMsg();
                if ($stmt){
                    $msg = 'You have successfully updated x-ray test price.';
                    $status = 'success';
                }else{
                    $msg = 'There was an trying to update this test price.';
                    $status = 'error';
                }
            }else{
	            // Save Test Price
                $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_xray_testprice WHERE XP_FACICODE=".$sql->Param('a')." AND XP_TESTCODE=".$sql->Param('a')." AND XP_TESTNAME=".$sql->Param('b')),array($activeinstitution,$testcode,$testname));
                print $sql->ErrorMsg();
                if ($stmt->RecordCount() < 1){
                    $code = $engine->xrayTestPriceCode();
                    $stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_xray_testprice (XP_CODE, XP_DATE, XP_TESTCODE, XP_TESTNAME, XP_FACICODE,XP_PRICE) VALUES (".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').")"),array($code,$sql->UserDate($startdate,'Y-m-d'),$testcode,$testname,$activeinstitution,$xray_testprice));
                    print $sql->ErrorMsg();
                    if ($stmt){
                        $msg = 'Test Price has been successfully saved.';
                        $status = 'success';
                    }
                }else{
                    // Record already exit so just update
                    $stmt = $sql->Execute($sql->Prepare("UPDATE hms_xray_testprice SET XP_PRICE=".$sql->Param('c')." WHERE XP_TESTCODE=".$sql->Param('d')),array($xray_testprice,$testcode));
                    print $sql->ErrorMsg();
                    if ($stmt){
//                        $msg = 'You have successfully updated x-ray test price.';
                        $msg = 'Updated Successful.';
                        $status = 'success';
                    }
                }
            }
        }else{
	        $msg = 'Price field cannot be empty.';
	        $status = 'error';
        }
        $keys = '';
        $target = '';
	break;

	case "reset":
	   $fdsearch = $action_search = "";
	break;
}

$stmtxraytest = $sql->Execute($sql->prepare("SELECT X_ID,X_NAME,X_CODE,X_DESC FROM hmsb_st_xray WHERE X_STATUS = '1'"));
		
if(isset($action_search) && $action_search == "search"){
	if(!empty($fdsearch)){
    $query = "SELECT * FROM hms_xray_testprice WHERE  XP_FACICODE = ".$sql->Param('1')." AND XP_STATUS = ".$sql->Param('2')." AND  XP_TESTNAME LIKE ".$sql->Param('3')." ORDER BY XP_ID DESC";
    $input = array($activeinstitution,'1','%'.$fdsearch.'%');
	}
}else{
    $query = "SELECT * FROM hms_xray_testprice WHERE XP_FACICODE = ".$sql->Param('1')." and XP_STATUS = ".$sql->Param('2')." ORDER BY XP_ID DESC";
    $input = array($activeinstitution,'1');
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