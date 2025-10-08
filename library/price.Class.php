<?php
class priceClass {
	public  $sql;
	public $session;
	public $phpmailer;
	function  __construct() {
			global $sql,$session,$phpmailer;
			$this->session= $session;
			$this->sql = $sql;
			$this->phpmailer = $phpmailer;
		}
		
	
	public function getserviceprice($servicecode,$faccode,$paschcode){
		
			$stmtr = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_st_pricing WHERE PS_ITEMCODE = ".$this->sql->Param('a')."   and PS_PAYSCHEME = ".$this->sql->Param('a')."  and PS_FACICODE = ".$this->sql->Param('a').""),array($servicecode,$paschcode,$faccode));
			print $this->sql->ErrorMsg();
			if($stmtr->RecordCount() > 0){
				$pprice = $stmtr->FetchNextObject();
					$priamt = $pprice->PS_PRICE;

				 return $priamt;

			 }else{
                  
			  return 0;

				}
		}
		
		
	public function getserviceotherprice($servicecode,$faccode,$paschcode){

		
			$stmtr = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_st_pricing WHERE PS_ITEMCODE = ".$this->sql->Param('a')."   and PS_PAYSCHEME = ".$this->sql->Param('a')."  and PS_FACICODE = ".$this->sql->Param('a').""),array($servicecode,$paschcode,$faccode));
			print $this->sql->ErrorMsg();
			if($stmtr->RecordCount() > 0){
				$pprice = $stmtr->FetchNextObject();
					$priamt = $pprice->PS_PRICE;

				 return $priamt;

			 }else{

					return 0 ;

				}
		}
		
		
		
		
		

}
?>