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
    case "saveprice":
        if(empty($price) || empty($drug)  || empty($paymeth)){
            $msg = "Failed. Required field(s) can't be empty!.";
            $status = "error";
            $view ='add';
        }else{

            $drug = explode('@@@', $drug);
            $scode = $drug['0'];
            $sname = $drug['1'];

            $pay = explode('@@@', $paymeth);
            $pcode = $pay['0'];
            $pname = $pay['1'];

            $stmt = $sql->Execute($sql->Prepare("SELECT * from hmsb_st_pricing WHERE PS_ITEMCODE = ".$sql->Param('1')." AND PS_PAYSCHEME = ".$sql->Param('2')." and PS_FACICODE = ".$sql->Param('2').""),array($scode,$pcode,$faccode));
            print $sql->ErrorMsg();

            if($stmt->RecordCount() > 0){
                $msg = "Failed. Price exist Already";
                $status = "error";
                $view ='add';
            }else{
                if (empty($keys)){
                    $ttcode = $engine->getpricescode();
                    $sql->Execute("INSERT INTO hmsb_st_pricing(PS_CODE,PS_CATEGORY,PS_ITEMCODE,PS_ITEMNAME,PS_PRICE,PS_PAYSCHEME,PS_PAYSCHEMENAME,PS_USERCODE,PS_USERFULLNAME,PS_FACICODE) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').",".$sql->Param('h').",".$sql->Param('j').",".$sql->Param('k').")",array($ttcode,'2',$scode,$sname,$price,$pcode,$pname,$actorid,$actorname,$activeinstitution));
                    print $sql->ErrorMsg();

                    $msg = "Success:Saved successfully";
                }else{
                    $stmt = $sql->Execute($sql->Prepare("UPDATE hmsb_st_pricing SET PS_ITEMCODE = ".$sql->Param('1').", PS_ITEMNAME = ".$sql->Param('2')." ,PS_PRICE = ".$sql->Param('3').", PS_PAYSCHEME = ".$sql->Param('4')." ,PS_PAYSCHEMENAME = ".$sql->Param('5')." WHERE PS_CODE = ".$sql->Param('6')." "), array($scode,$sname,$price,$pcode,$pname,$keys));
                    print $sql->ErrorMsg();

                    $msg = "Success:Changes applied successfully";
                }

                $status = "success";
                $view ='';
            }
        }
    break;

	case "edit":
        if(isset($keys) && $keys != ''){
            $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hmsb_st_pricing WHERE PS_CODE = ".$sql->Param('a')." "),array($keys));
            print $sql->ErrorMsg();
            if($stmt->RecordCount() == 1){
                $obj = $stmt->FetchNextObject();
                $drug = $obj->PS_ITEMCODE;
                $paymeth = $obj->PS_PAYSCHEME;
                $price = $obj->PS_PRICE;
                $keys = $obj->PS_CODE;
            }
        }
	break;

	case "reset":
	   $fdsearch = $action_search = "";
	break;
}

$stmtpayschemelov = $sql->Execute($sql->prepare("SELECT * from hmsb_st_paymentmethod WHERE PAYM_FACICODE = '$activeinstitution'"));
$stmtservicelov = $sql->Execute($sql->prepare("SELECT * from hmsb_st_phdrugs WHERE DR_STATUS = '1'"));
		
if(isset($action_search) && $action_search == "search"){
	if(!empty($fdsearch)){
    $query = "SELECT * FROM hmsb_st_pricing WHERE  PS_FACICODE = ".$sql->Param('1')." and PS_CATEGORY = ".$sql->Param('2')." and  PS_ITEMNAME like ".$sql->Param('3')."";
    $input = array($activeinstitution,'2','%'.$fdsearch.'%');
	}
}else{

    $query = "SELECT * FROM hmsb_st_pricing WHERE PS_FACICODE = ".$sql->Param('1')." and PS_CATEGORY = ".$sql->Param('2')." ";
    $input = array($activeinstitution,'2');
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