<?php
class settingClass{
	public  $sql;
	public $session;
	public $phpmailer;
	function  __construct() {
			global $sql,$session,$phpmailer;
			$this->session= $session;
			$this->sql = $sql;
			$this->phpmailer = $phpmailer;
		}
		
	
	public function getpaybeforesetting($faccode){

			$stc = '100';
			$stmtr = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_admin_setting WHERE PS_SETTINGCODE = ".$this->sql->Param('a')."   and PS_FACI_CODE = ".$this->sql->Param('a').""),array($stc,$faccode));
			print $this->sql->ErrorMsg();
			if($stmtr->RecordCount() > 0){
				$pprice = $stmtr->FetchNextObject();
					$priamt = $pprice->PS_VALUE;

				 return $priamt;

			 }else{

					return '10' ;

				  }
		}
		
		
		

}
?>