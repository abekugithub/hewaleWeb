<?php
class doctorClass extends engineClass{
	public  $sql;
	public $session;
	public $phpmailer;
	function  __construct() {
			global $sql,$session,$phpmailer;
			$this->session= $session;
			$this->sql = $sql;
			$this->phpmailer = $phpmailer;
		}
	
 	 /*
	  * This function below get the doctor profile
	  */
     public function getDoctorProfile($usrcode){
		 $stmtr = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hmsb_med_prac WHERE MP_USRCODE = ".$this->sql->Param('a')." "),array($usrcode));
		 print $this->sql->ErrorMsg();
		 if($stmtr){
			  return $stmtr->FetchNextObject();
		  }else{
			     return false;
			   }
	 }//end of getDoctorProfile
	 
	 
	  /*
	  * This function below get the doctor's speciality
	  */
     public function getDoctorSpeciality($usrcode){
		 if(!empty($usrcode)){
		 $obj = $this->getDoctorProfile($usrcode);
		 return $obj->MP_SPECIALISATION;
		 }else{
			    return false;
			  }
	 }//end of getDoctorSpeciality
	 

	 public function getDoctorPhonenum($usrcode){
		if(!empty($usrcode)){
		$obj = $this->getDoctorProfile($usrcode);
		return $obj->MP_PHONENO;
		}else{
			   return false;
			 }
	}//end of getDoctorSpeciality
	
	 
	 public function getuserSpeciality($usrcode){
		 if(!empty($usrcode)){
		 $obj = $this->getDoctorProfile($usrcode);
		 return $obj->MP_SPECIALISATION_CODE;
		 }else{
			    return false;
			  }
	 }//end of getDoctorSpeciality
	 
	 
	 /*
	  * This function gets the chat locomotive
	  */
	  public function getChatPerPatient($senderid,$receiverid){
	$stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_chat WHERE CH_SENDER_CODE IN (".$this->sql->Param('a').",".$this->sql->Param('b').") AND CH_RECEIVER_CODE IN (".$this->sql->Param('a').",".$this->sql->Param('b').") AND CH_STATUS = '1'"),array($senderid,$receiverid,$senderid,$receiverid));
		 print $this->sql->ErrorMsg();
		 
		 $this->sql->Execute("UPDATE hms_chat SET CH_VIEW_STATUS = '1' WHERE  CH_VIEW_STATUS = '0' AND CH_RECEIVER_CODE = ".$this->sql->Param('a')." AND CH_SENDER_CODE = ".$this->sql->Param('a')."  ",array($receiverid,$senderid));
		 

		 if($stmt){
			 if($stmt->RecordCount() > 0){
				 return $stmt;
			 }
		  }else{return false ;}
	  }
	  
	  
	 /*
	  * This function gets the market chat locomotive
	  */
	  public function getMarketChatPerPatient($senderid,$receiverid){
	$stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_chatmarket WHERE CHT_SENDER_CODE IN (".$this->sql->Param('a').",".$this->sql->Param('b').") AND CHT_RECEIVER_CODE IN (".$this->sql->Param('a').",".$this->sql->Param('b').") AND CHT_STATUS = '1'"),array($senderid,$receiverid,$senderid,$receiverid));
		 print $this->sql->ErrorMsg();

		 $this->sql->Execute("UPDATE hms_chatmarket SET CHT_VIEW_STATUS = '1' WHERE  CHT_VIEW_STATUS = '0' AND CHT_RECEIVER_CODE = ".$this->sql->Param('a')." AND CHT_SENDER_CODE = ".$this->sql->Param('a')."  ",array($receiverid,$senderid));
		 
		 if($stmt){
			 if($stmt->RecordCount() > 0){
				 return $stmt;
			 }
		  }else{return false ;}
	  }
	  
	

	  // Physical Exams Code
    public function getPhysicalExamsCode(){
	$items= 'PEX';
	$stmt = $this->sql->Execute($this->sql->Prepare("SELECT PPEX_CODE FROM hms_patient_physicalexams ORDER BY PPEX_ID DESC LIMIT 1 "));
	print $this->sql->ErrorMsg();
	if($stmt->RecordCount() > 0){
		$obj = $stmt->FetchNextObject();
		$order = substr($obj->PPEX_CODE,3,10000);
		$order = $order + 1;
		if(strlen($order) == 1){
			$orderno = $items.'000'.$order;
		}else if(strlen($order) == 2){
			$orderno = $items.'00'.$order;
		}else if(strlen($order) == 3){
			$orderno = $items.'0'.$order;
		}else{
			$orderno = $items.$order;
		}
	}else{
		$orderno = $items.'0001';
	}
	return $orderno;
}
    //End of Physical Exams Code


 public function getManagementCode(){
	$items= 'MAN';
	$stmt = $this->sql->Execute($this->sql->Prepare("SELECT PM_CODE FROM hms_patient_management ORDER BY PM_ID DESC LIMIT 1 "));
	print $this->sql->ErrorMsg();
	if($stmt->RecordCount() > 0){
		$obj = $stmt->FetchNextObject();
		$order = substr($obj->PM_CODE,3,10000);
		$order = $order + 1;
		if(strlen($order) == 1){
			$orderno = $items.'000'.$order;
		}else if(strlen($order) == 2){
			$orderno = $items.'00'.$order;
		}else if(strlen($order) == 3){
			$orderno = $items.'0'.$order;
		}else{
			$orderno = $items.$order;
		}
	}else{
		$orderno = $items.'0001';
	}
	return $orderno;
}

   /*
    * The function below set or unset doctor session in consulting room
    */
	public function setDoctorConsultSession($usrcode,$patientcode){
	   	//Set consulting room in session
		$stmtp = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_docsession WHERE DOCSES_USRCODE = ".$this->sql->Param('a')." AND DOCSES_STATUS = '1' AND DOCSES_PATIENTCODE != ".$this->sql->Param('b')." "),array($usrcode,$patientcode));
		
		if($stmtp->RecordCount() > 0){
		     //Update existing doctor-patient consultation chat
			 $this->sql->Execute("UPDATE hms_docsession SET DOCSES_STATUS = '2' WHERE DOCSES_STATUS = '1' AND DOCSES_USRCODE = ".$this->sql->Param('a')." ",array($usrcode));
			 
			 //Check status for current patient
			 $stmto = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_docsession WHERE DOCSES_USRCODE = ".$this->sql->Param('a')." AND DOCSES_PATIENTCODE = ".$this->sql->Param('b')." AND DOCSES_STATUS = '0' "),array($usrcode,$patientcode));
			 if($stmto->RecordCount() > 0){
				 //Set Current user to be in session
				  $this->sql->Execute("UPDATE hms_docsession SET DOCSES_STATUS = '1' WHERE DOCSES_USRCODE = ".$this->sql->Param('a')." AND DOCSES_PATIENTCODE = ".$this->sql->Param('b')." ",array($usrcode,$patientcode));
				  }else{
					   //Insert Current user to be in session
				  $this->sql->Execute("INSERT INTO  hms_docsession(DOCSES_PATIENTCODE,DOCSES_USRCODE,DOCSES_STATUS) VALUES(".$this->sql->Param('a').",".$this->sql->Param('b').",".$this->sql->Param('c').") ",array($patientcode,$usrcode,'1'));
					  
					    }
		}else{
			
			 //Check status for current patient
			 $stmto = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_docsession WHERE DOCSES_USRCODE = ".$this->sql->Param('a')." AND DOCSES_PATIENTCODE = ".$this->sql->Param('b')." AND DOCSES_STATUS = '0' "),array($usrcode,$patientcode));
			 if($stmt0->RecordCount > 0){
				 //Set Current user to be in session
				  $this->sql->Execute("UPDATE hms_docsession SET DOCSES_STATUS = '1' WHERE DOCSES_USRCODE = ".$this->sql->Param('a')." AND DOCSES_PATIENTCODE = ".$this->sql->Param('b')." ",array($usrcode,$patientcode));
				  }else{
				 //Insert Current user to be in session
				 $this->sql->Execute("INSERT INTO  hms_docsession(DOCSES_PATIENTCODE,DOCSES_USRCODE,DOCSES_STATUS) VALUES(".$this->sql->Param('a').",".$this->sql->Param('b').",".$this->sql->Param('c').") ",array($patientcode,$usrcode,'1'));
					  
					    }
			
			 }
			 print $this->sql->ErrorMsg();	
	}


	/*
	 * This function gets doctor details from
	 * hmsb_doctorsmonitor
	 * Param: @sessionlogin, @doctorcode
	 */
	public function gettimemonitordetails($sessionlogin,$doctorcode){
		$stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hmsb_doctorsmonitor WHERE DM_SESSIONLOGIN = ".$this->sql->Param('a')." AND  DM_DOCTORCODE = ".$this->sql->Param('b')." "),array($sessionlogin,$doctorcode));
        print $this->sql->ErrorMsg();
		if($stmt->RecordCount() > 0){
		   return $stmt->FetchNextObject();	
		}else{
			return false;
		}
	}

	/*
	 * This function gets doctor details from
	 * assigned and logged in Chps Compound
	 * Param: @usercode
	 */
	public function getDocChpsDetails($usercode){
		$stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_consultation_rooms WHERE CONSROOM_DOCTORCODE = ".$this->sql->Param('a')." AND  CONSROOM_STATUS = '1' "),array($usercode));
        print $this->sql->ErrorMsg();
		if($stmt->RecordCount() > 0){
		   return $stmt->FetchNextObject();	
		}else{
			return false;
		}
	}



	 /*
	  * This function gets the chat per doctor per room
	  */
	  public function getChatPerRoom($senderid,$receiverid){
		$stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_chatvh WHERE CH_SENDER_CODE IN (".$this->sql->Param('a').",".$this->sql->Param('b').") AND CH_RECEIVER_CODE IN (".$this->sql->Param('a').",".$this->sql->Param('b').") AND CH_STATUS = '1'"),array($senderid,$receiverid,$senderid,$receiverid));
			 print $this->sql->ErrorMsg();
			 
			 $this->sql->Execute("UPDATE hms_chatvh SET CH_VIEW_STATUS = '1' WHERE  CH_VIEW_STATUS = '0' AND CH_RECEIVER_CODE = ".$this->sql->Param('a')." AND CH_SENDER_CODE = ".$this->sql->Param('a')."  ",array($receiverid,$senderid));
			
	
			 if($stmt){
				 if($stmt->RecordCount() > 0){ 
					 return $stmt;
				 }
			  }else{return false ;}
		  }
	//End fetching chat


	/*
	 * This function gets doctor possible avaliable
	 * rooms from the Virtual health Hospital
	 * Param: @facicode
	 */
	public function getDocAvailRoom($facicode){
		$stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_consultation_rooms WHERE CONSROOM_FACICODE = ".$this->sql->Param('a')." AND  CONSROOM_STATUS = '1' AND CONSROOM_DOCTORCODE = '' "),array($facicode));
        print $this->sql->ErrorMsg();
		if($stmt->RecordCount() > 0){
		   return $stmt;	
		}else{
			return false;
		}
	}


    /*
	 * This function gets doctor active room
	 * Param: @facicode
	 */
	public function getDocRoom($facicode,$usrcode){
		$stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_consultation_rooms WHERE CONSROOM_FACICODE = ".$this->sql->Param('a')." AND  CONSROOM_DOCTORCODE = ".$this->sql->Param('b')."  "),array($facicode,$usrcode));
        print $this->sql->ErrorMsg();
		if($stmt){
		   return $stmt;	
		}else{
			return false;
		}
	}


	/*
	 * This function sets a room for a doctor
	 * Param: @facicode, @usrcode
	 */
	public function setDocRoom($facicode,$usrcode){
		$stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_consultation_rooms WHERE CONSROOM_FACICODE = ".$this->sql->Param('a')." AND  CONSROOM_DOCTORCODE = ".$this->sql->Param('b')."  "),array($facicode,$usrcode));
		print $this->sql->ErrorMsg();
		
		if($stmt->RecordCount() == 0){
			//Set previous entry into room table as empty
			$this->sql->Execute("UPDATE hms_consultation_rooms SET CONSROOM_DOCTORCODE = '',CONSROOM_DOCTORNAME = '' WHERE CONSROOM_DOCTORCODE = ".$this->sql->Param('a')." ",array($usrcode));
			print $this->sql->ErrorMsg();
			
			 //Get next available room
			 $stmtr =  $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_consultation_rooms WHERE CONSROOM_FACICODE = ".$this->sql->Param('a')." AND  CONSROOM_DOCTORCODE = '' LIMIT 1 "),array($facicode));
			 $objr = $stmtr->FetchNextObject();
			 $roomid = $objr->CONSROOM_ID ;

			 //Update room table
			 $objusr = $this->getDoctorProfile($usrcode);
			 $docname = $objusr->MP_OTHERNAME.' '.$objusr->MP_SURNAME;
             $this->sql->Execute("UPDATE hms_consultation_rooms SET CONSROOM_DOCTORCODE = ".$this->sql->Param('a').",CONSROOM_DOCTORNAME = ".$this->sql->Param('b')." WHERE CONSROOM_ID = ".$this->sql->Param('a')." ",array($usrcode,$docname,$roomid));
		}

		/*if($stmt){
		   return $stmt;	
		}else{
			return false;
		}*/
	}


	/*
	 * This function checks availabilty of rooms
	 * Param: @facicode, @usrcode
	 */
	public function checkRoomAvailability($facicode,$usrcode){
		$stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_consultation_rooms WHERE CONSROOM_FACICODE = ".$this->sql->Param('a')." AND (CONSROOM_DOCTORCODE ='' OR  CONSROOM_DOCTORCODE = ".$this->sql->Param('b').")  "),array($facicode,$usrcode));
        print $this->sql->ErrorMsg();
		if($stmt){
		   return $stmt;	
		}else{
			return false;
		}
	}


	 /*
	  * This function gets the chat between doctor
	  */
	  public function getChatPerDoctor($senderid,$receiverid){
		$stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_chat WHERE CH_SENDER_CODE IN (".$this->sql->Param('a').",".$this->sql->Param('b').") AND CH_RECEIVER_CODE IN (".$this->sql->Param('a').",".$this->sql->Param('b').") AND CH_STATUS = '1'"),array($senderid,$receiverid,$senderid,$receiverid));
			 print $this->sql->ErrorMsg();
			 
			 $this->sql->Execute("UPDATE hms_chat SET CH_VIEW_STATUS = '1' WHERE  CH_VIEW_STATUS = '0' AND CH_RECEIVER_CODE = ".$this->sql->Param('a')." AND CH_SENDER_CODE = ".$this->sql->Param('a')."  ",array($receiverid,$senderid));
			
	
			 if($stmt){
				 if($stmt->RecordCount() > 0){ 
					 return $stmt;
				 }
			  }else{return false ;}
		  }
	//End fetching chat
	

}


?>