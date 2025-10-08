<?php
class codesClass{
	public  $sql;
	public $session;
	public $phpmailer;
	function  __construct() {
			global $sql,$session,$phpmailer;
			$this->session= $session;
			$this->sql = $sql;
			$this->phpmailer = $phpmailer;
		}
		
		
		// 21 NOV 2018, JOSEPH ADORBOE , SET COURIERCODE
		public function getcourierCode(){
			$yr= date('y');
			$items= $yr.'C';
			$stmt = $this->sql->Execute($this->sql->Prepare("SELECT COB_CODE FROM hmsb_courier_basket ORDER BY COB_ID DESC LIMIT 1 "));
			print $this->sql->ErrorMsg();
			if($stmt->RecordCount() > 0){
				$obj = $stmt->FetchNextObject();
				$order = substr($obj->COB_CODE,5,10000000);
				$order = $order + 1;
				if(strlen($order) == 1){
					$orderno = $items.'-000000'.$order;
				}else if(strlen($order) == 2){
					$orderno = $items.'-00000'.$order;
				}else if(strlen($order) == 3){
					$orderno = $items.'-0000'.$order;
				}else if(strlen($order) == 4){
					$orderno = $items.'-000'.$order;
				}else if(strlen($order) == 5){
					$orderno = $items.'-00'.$order;
				}else if(strlen($order) == 6){
					$orderno = $items.'-0'.$order;
				}else if(strlen($order) == 7){
					$orderno = $items.'-'.$order;
				}else{
					$orderno = $items.$order;
				}
			}else{
				$orderno = $items.'-0000001';
			}
			return $orderno;
		}
		
		
		
		// 15 MAR 2018, JOSEPH ADORBOE , SET WARD
		public function getbedscode(){
		
			$items= 'BD';
			$stmt = $this->sql->Execute($this->sql->Prepare("SELECT BED_CODE FROM hms_st_wardbed ORDER BY BED_ID DESC LIMIT 1 "));
			print $this->sql->ErrorMsg();
			if($stmt->RecordCount() > 0){
				$obj = $stmt->FetchNextObject();
				$order = substr($obj->BED_CODE,3,10000);
				$order = $order + 1;
				if(strlen($order) == 1){
					$orderno = $items.'-0000'.$order;
				}else if(strlen($order) == 2){
					$orderno = $items.'-000'.$order;
				}else if(strlen($order) == 3){
					$orderno = $items.'-00'.$order;
				}else if(strlen($order) == 4){
					$orderno = $items.'-0'.$order;
			
				}else{
					$orderno = $items.'-'.$order;
				}
			}else{
				$orderno = $items.'-00001';
			}
			return $orderno;
		}
		
		// 15 MAR 2018, JOSEPH ADORBOE , SET WARD
		public function getwardscode(){
		//	$yr= date('y');
			$items= 'WD';
			$stmt = $this->sql->Execute($this->sql->Prepare("SELECT WARD_CODE FROM hms_st_ward ORDER BY WARD_ID DESC LIMIT 1 "));
			print $this->sql->ErrorMsg();
			if($stmt->RecordCount() > 0){
				$obj = $stmt->FetchNextObject();
				$order = substr($obj->WARD_CODE,3,10000);
				$order = $order + 1;
				if(strlen($order) == 1){
					$orderno = $items.'-0000'.$order;
				}else if(strlen($order) == 2){
					$orderno = $items.'-000'.$order;
				}else if(strlen($order) == 3){
					$orderno = $items.'-00'.$order;
				}else if(strlen($order) == 4){
					$orderno = $items.'-0'.$order;
			
				}else{
					$orderno = $items.'-'.$order;
				}
			}else{
				$orderno = $items.'-00001';
			}
			return $orderno;
		}
		
		
		// 15 FEB 2018, JOSEPH ADORBOE , SET BILL ITEM
		public function getbillitemCode(){
			$yr= date('y');
			$items= $yr.'B';
			$stmt = $this->sql->Execute($this->sql->Prepare("SELECT B_CODE FROM hms_billitem ORDER BY B_ID DESC LIMIT 1 "));
			print $this->sql->ErrorMsg();
			if($stmt->RecordCount() > 0){
				$obj = $stmt->FetchNextObject();
				$order = substr($obj->B_CODE,5,10000000);
				$order = $order + 1;
				if(strlen($order) == 1){
					$orderno = $items.'-000000'.$order;
				}else if(strlen($order) == 2){
					$orderno = $items.'-00000'.$order;
				}else if(strlen($order) == 3){
					$orderno = $items.'-0000'.$order;
				}else if(strlen($order) == 4){
					$orderno = $items.'-000'.$order;
				}else if(strlen($order) == 5){
					$orderno = $items.'-00'.$order;
				}else if(strlen($order) == 6){
					$orderno = $items.'-0'.$order;
				}else if(strlen($order) == 7){
					$orderno = $items.'-'.$order;
				}else{
					$orderno = $items.$order;
				}
			}else{
				$orderno = $items.'-0000001';
			}
			return $orderno;
		}
		
		// 15 FEB 2018, JOSEPH ADORBOE , SET PRICES
		public function gethmspriceCode(){
			$yr= date('y');
			$items= $yr.'P';
			$stmt = $this->sql->Execute($this->sql->Prepare("SELECT PS_CODE FROM hms_st_pricing ORDER BY PS_ID DESC LIMIT 1 "));
			print $this->sql->ErrorMsg();
			if($stmt->RecordCount() > 0){
				$obj = $stmt->FetchNextObject();
				$order = substr($obj->PS_CODE,4,10000000);
				$order = $order + 1;
				if(strlen($order) == 1){
					$orderno = $items.'-0000000'.$order;
				}else if(strlen($order) == 2){
					$orderno = $items.'-000000'.$order;
				}else if(strlen($order) == 3){
					$orderno = $items.'-00000'.$order;
				}else if(strlen($order) == 4){
					$orderno = $items.'-0000'.$order;
				}else if(strlen($order) == 5){
					$orderno = $items.'-000'.$order;
				}else if(strlen($order) == 6){
					$orderno = $items.'-00'.$order;
				}else if(strlen($order) == 7){
					$orderno = $items.'-0'.$order;
				}else{
					$orderno = $items.'-'.$order;
				}
			}else{
				$orderno = $items.'-00000001';
			}
			return $orderno;
		}
	
		

}


?>