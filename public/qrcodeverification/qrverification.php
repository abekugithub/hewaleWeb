<?php
ob_start();
include "../../config.php";
include SPATH_LIBRARIES.DS."engine.Class.php";

$engine = new engineClass();

if(isset($_GET['code'])){
	$codex = $_GET['code'];
    $typex = explode('-',$code);
    $type = $typex[1];
	$code = $typex[0];

if(!empty($code)){ 
switch($type){
   case "excuseduty":
    include('excuseduty.php');
   break;	
 }
if($stmt->RecordCount() > 0){
		echo "<strong>HEWALE - SOCIAL HEALTH</strong> <br /><br /><div style='color:#3BB50A'>QR CODE VERIFIED</div><br /> THANK YOU.";
	}else{
		echo "<strong>HEWALE - SOCIAL HEALTH</strong> <br /><br /><div style='color:#ff0000'>QR CODE NOT VERIFIED</div><br /> THANK YOU.";
		}
		
}}
?>
