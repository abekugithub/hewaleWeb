<?php
include SPATH_LIBRARIES.DS."import.Class.php";
switch($viewpage){
	case 'add_tithe':
		$postkey =$engine->validatePostForm($micro_time);
			if($postkey==true){
				if(!empty($_POST['trans'])){
					$field = $_POST['trans'];
					for($i=0; $i< count($field['memid']); $i++){ 
						$actor = $actordetails->USR_ID;
						$stmta = $sql->Execute($sql->Prepare("INSERT INTO church_transactions (TRANS_MEM_ID,TRANS_OPTID,TRANS_AMOUNT,TRANS_NARRATION,TRANS_USER_ID,TRANS_BRAN_CODE,TRANS_CHUR_CODE) VALUES(".$sql->Param('a').",".$sql->Param('b').",".$sql->Param('c').",".$sql->Param('d').",".$sql->Param('e').",".$sql->Param('f').",".$sql->Param('g').")"),array($field['memid'][$i],$field['optname'][$i],$field['tranamount'][$i],$field['narration'][$i],$actor,$branchcode,$churchcode));
			}
					if($stmta == true){
						$msg = 'Transaction Added successfully';
						$status = 'success';
					}else{
						$msg = $sql->errorMsg();
						$status = 'error';
					}
			}
		}
	break;
	
	/// Rest Search Field	
	case "reset":
		$fdsearch = "";
	break;
	
	case 'delete_tithe':
		if(!empty($keys)){ 
			$stmta = $sql->Execute($sql->Prepare("UPDATE church_transactions SET 
			TRANS_STATUS = ".$sql->Param('a')." WHERE TRANS_ID = ".$sql->Param('b').""),array('0',$keys));		
		}
		if($stmta == true && $stmtb == true){
				$msg = 'Deleted successfully';
				$status = 'success';
			}else{
				$msg = $sql->errorMsg();
				$status = 'error';
			}
	break;
	
}

$stmtn = $sql->Execute($sql->Prepare("SELECT TRANS_OPTID,TRANS_OPTNAME FROM church_transaction_options WHERE TRANS_OPTBRAN_CODE=".$sql->Param('a')." AND TRANS_OPTCHUR_CODE=".$sql->Param('b')." "),array($branchcode,$churchcode));
//die($sql->errorMsg());
$data=array();
while($row=$stmtn->FetchNextObject()){
	$data[] = $row;	
}

/// Fetch All Members and Display them with Pagination
if(strtolower($viewpage) == 'searchitem' && !empty($fdsearch)){ 
$query ="SELECT
church_members.MEM_NAME,
church_transaction_options.TRANS_OPTNAME,
church_transactions.TRANS_AMOUNT,
church_transactions.TRANS_DATE_ADDED,
church_users.USR_SURNAME,
church_transactions.TRANS_ID
FROM
church_transactions
INNER JOIN church_transaction_options ON church_transactions.TRANS_OPTID = church_transaction_options.TRANS_OPTID
INNER JOIN church_users ON church_transactions.TRANS_USER_ID = church_users.USR_ID
INNER JOIN church_members ON church_transactions.TRANS_MEM_ID = church_members.MEM_ID WHERE church_transactions.TRANS_STATUS='1' AND (church_members.MEM_NAME LIKE ".$sql->Param('a')." OR church_members.MEM_ID = ".$sql->Param('b').") AND church_transactions.TRANS_BRAN_CODE=".$sql->Param('b')." AND church_transactions.TRANS_CHUR_CODE=".$sql->Param('c')." ORDER BY TRANS_ID DESC";
$input = array($fdsearch.'%',$fdsearch,$branchcode,$churchcode);	
}else{
$query = "SELECT
church_members.MEM_NAME,
church_transaction_options.TRANS_OPTNAME,
church_transactions.TRANS_AMOUNT,
church_transactions.TRANS_DATE_ADDED,
church_users.USR_SURNAME,
church_transactions.TRANS_ID
FROM
church_transactions
INNER JOIN church_transaction_options ON church_transactions.TRANS_OPTID = church_transaction_options.TRANS_OPTID
INNER JOIN church_users ON church_transactions.TRANS_USER_ID = church_users.USR_ID
INNER JOIN church_members ON church_transactions.TRANS_MEM_ID = church_members.MEM_ID WHERE church_transactions.TRANS_STATUS='1' AND church_transactions.TRANS_BRAN_CODE=".$sql->Param('b')." AND church_transactions.TRANS_CHUR_CODE=".$sql->Param('c')." ORDER BY TRANS_ID DESC";
$input = array($branchcode,$churchcode);
}

if(!isset($limit)){
	$limit = $session->get("limited");
}else if(empty($limit)){
	$limit =20;
	}
$session->set("limited",$limit);
$lenght = 10;
$paging = new OS_Pagination($sql,$query,$limit,$lenght,'pg=d2e3083420929d8bfae81f58fa4594cb&option=8937250090b7a5f003b21e1c4b72112a',$input);
