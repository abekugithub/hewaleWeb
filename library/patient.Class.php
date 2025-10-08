<?php
class patientClass{
	public  $sql;
	public $session;
	public $phpmailer;
	function  __construct() {
			global $sql,$session,$phpmailer;
			$this->session= $session;
			$this->sql = $sql;
			$this->phpmailer = $phpmailer;
		}
		
		public function getPatientNum($initial){
				$initial = strtoupper($initial);
				$stmt = $this->sql->Prepare("SELECT * FROM hms_patient_numbers WHERE PN_INITIALS= ".$this->sql->Param('a'));
				$stmt = $this->sql->Execute($stmt,array($initial));
				
				if($stmt && ($stmt->RecordCount() > 0)){
					
					$obj = $stmt->FetchNextObject();
			$pn_count=$obj->PN_COUNT;
			$pn_count = $pn_count + 1;
		if(strlen($pn_count) == 1){
			$pn_code = $initial.'00'.$pn_count;
		}else if(strlen($pn_count) == 2){
			$pn_code = $initial.'0'.$pn_count;
		}else{
			$pn_code = $initial.$pn_count;
		}
			
    		$stmt = $this->sql->Execute($this->sql->Prepare("UPDATE hms_patient_numbers SET PN_COUNT = ".$this->sql->Param('a')." , PN_CODE = ".$this->sql->Param('b')." WHERE PN_INITIALS = ".$this->sql->Param('c')),array($pn_count, $pn_code, $initial));
		
		}else{
			$pn_count = 1;
			$pn_code = $initial."001";
			
			$this->sql->Execute($this->sql->Prepare("INSERT INTO hms_patient_numbers (PN_CODE,PN_INITIALS,PN_COUNT) VALUES (".$this->sql->Param('a').",".$this->sql->Param('b').",".$this->sql->Param('c').")"),array($pn_code, $initial, $pn_count)); 
		
		}
					
		 return $pn_code;
		 
		}//end of getPatientNum
		
		
	  

	public function getPatientCode(){
	$items= 'PAT';
	$stmt = $this->sql->Execute($this->sql->Prepare("SELECT PATIENT_PATIENTCODE FROM hms_patient ORDER BY PATIENT_ID DESC LIMIT 1 "));
	print $this->sql->ErrorMsg();
	if($stmt->RecordCount() > 0){
		$obj = $stmt->FetchNextObject();
		$order = substr($obj->PATIENT_PATIENTCODE,3,10000);
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
	 * The function below gets the patient service request details
	 */
	 
	 public function getServRequestDetail($requstcode)
	 {
		$stmt =  $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_service_request WHERE REQU_CODE = ".$this->sql->Param('a')." "),array($requstcode));
		print $this->sql->ErrorMsg();
		if($stmt){
		   if($stmt->RecordCount() > 0){
			   return $stmt->FetchNextObject() ;
			}	
		}else{return false;}
	 }//End getServRequestDetail
	 
	 
   /*
    * The function below sets the consultation code
    */
	
	public function getConsultCode($facicode){
		//Get the last inserted consultation code
		$stmt = $this->sql->Execute($this->sql->Prepare("SELECT CONS_CODE FROM hms_consultation WHERE CONS_CODE LIKE ".$this->sql->Param('a')."  ORDER BY CONS_ID DESC LIMIT 1"),array('%'.$facicode.'%'));
		print $this->sql->ErrorMsg();
		if($stmt){
			if($stmt->RecordCount() > 0){
				$obj = $stmt->FetchNextObject();
				$consltvar = $obj->CONS_CODE;
				$consultcode = substr($consltvar,strpos($consltvar,'-')+1);
				
				$consultcode = $consultcode + 1;
				
				if(strlen($consultcode) == 1){
					 $consultcode = '000000'.$consultcode;
				}elseif(strlen($consultcode) == 2){
					 $consultcode = '00000'.$consultcode;
					}elseif(strlen($consultcode) == 3){
					 $consultcode = '0000'.$consultcode;
					}elseif(strlen($consultcode) == 4){
					 $consultcode = '000'.$consultcode;
					}elseif(strlen($consultcode) == 5){
					 $consultcode = '00'.$consultcode;
					}elseif(strlen($consultcode) == 6){
					 $consultcode = '0'.$consultcode;
					}
				return $consultstrg = 'CS'.$facicode.'-'.$consultcode;
			}else{
				   return $consultstrg = 'CS'.$facicode.'-0000001';
				 }
		}else{
			return false;}
	}//End getConsultCode
	
	
		    /*
    * The function below sets the visit code
    */
	
	public function visitcode($facicode,$patientnum){
		//Get the last inserted consultation code
		$stmt = $this->sql->Execute($this->sql->Prepare("SELECT REQU_VISITCODE FROM hms_service_request WHERE REQU_VISITCODE LIKE ".$this->sql->Param('a')."  ORDER BY REQU_ID DESC LIMIT 1"),array('%'.$facicode.'%'));
		print $this->sql->ErrorMsg();
		$actualdate = date('Ymd');
		if($stmt){
			if($stmt->RecordCount() > 0){
				$obj = $stmt->FetchNextObject();
				$consltvar = $obj->CONS_CODE;
				$consultcode = substr($consltvar,strpos($consltvar,'-')+1);
				
				$consultcode = $consultcode + 1;
				
				if(strlen($consultcode) == 1){
					 $consultcode = '000000'.$consultcode;
				}elseif(strlen($consultcode) == 2){
					 $consultcode = '00000'.$consultcode;
					}elseif(strlen($consultcode) == 3){
					 $consultcode = '0000'.$consultcode;
					}elseif(strlen($consultcode) == 4){
					 $consultcode = '000'.$consultcode;
					}elseif(strlen($consultcode) == 5){
					 $consultcode = '00'.$consultcode;
					}elseif(strlen($consultcode) == 6){
					 $consultcode = '0'.$consultcode;
					}
				return $consultstrg = 'VS'.$actualdate.$facicode.$patientnum.'-'.$consultcode;
			}else{
				  return $consultstrg = 'VS'.$actualdate.$facicode.$patientnum.'-0000001';
				 }
		}else{return false;}
	}//End visitcode
	
	
	/*
	 * The function below calculate the consulation period
	 * and highlight row when necessary.
	 * Param::@consultcode
	 */
	 public function getConsultPeriod($consultcode){
		 
		 $stmt = $this->sql->Execute($this->sql->Prepare("SELECT DATEDIFF(CONS_SCHEDULEDATE,CURDATE()) AS CONSPERIOD FROM hms_consultation WHERE CONS_CODE = ".$this->sql->Param('a')." "),array($consultcode));
		 print $this->sql->ErrorMsg();
		 if($stmt){
			 $obj = $stmt->FetchNextObject();
			 return $period = $obj->CONSPERIOD;
		  }else{
			     return false;
			   }
		  
	 }//End getConsultPeriod
	 
	 /*
	  * The function belows get patient consultation details based on 
	  * consultation code
	  * Param::@consultcode
	  */
	  public function getConsultationDetails($consultcode){
		 $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_consultation WHERE CONS_CODE = ".$this->sql->Param('a')." "),array($consultcode));
		 print $this->sql->ErrorMsg();
		 if($stmt){
			 if($stmt->RecordCount() > 0){
			 return $stmt->FetchNextObject(); 
			 }
		  }else{
			     return false;
			    }
	  }

	  	 /*
	  * The function belows get patient consultation details based on 
	  * visit code
	  * Param::@visitcode
	  */
	  public function getConsultationVisitDetails($visitcode){
		$stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_consultation WHERE CONS_VISITCODE = ".$this->sql->Param('a')." "),array($visitcode));
		print $this->sql->ErrorMsg();
		if($stmt){
			if($stmt->RecordCount() > 0){
			return $stmt->FetchNextObject(); 
			}
		 }else{
				return false;
			   }
	 }
	  
	 /*
	  * The function belows get patient details 
	  * 
	  * Param::@patientnum
	  */
	  public function getPatientDetails($patientnum){
		 $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_patient JOIN hms_patient_connect ON PATIENT_PATIENTCODE = PATCON_PATIENTCODE WHERE PATIENT_PATIENTNUM = ".$this->sql->Param('a')." "),array($patientnum));
		 print $this->sql->ErrorMsg();
		 if($stmt){
			 if($stmt->RecordCount() > 0){
			 return $stmt->FetchNextObject(); 
			 }
		  }else{
			     return false;
			    }  
	  }
	  
	
	    public function getVitals(){
		 $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_vitals WHERE VITALS_STATUS = ".$this->sql->Param('a')." "),array('1'));
		 print $this->sql->ErrorMsg();
		 if($stmt){
			 if($stmt->RecordCount() > 0){
			 return $stmt->RecordCount(); 
			 }
		  }else{
			     return false;
			    }  
	  }
	  
	 /*
	  * The function belows get patient passport picture 
	  * 
	  * Param::@patientnum
	  */
	  public function getPassPicture($patientnum){
		  $obj = $this->getPatientDetails($patientnum);
		  if(!empty($obj->PATIENT_IMAGE)){
		  return $obj->PATIENT_IMAGE;
	      }else{return false;}
	  }
	  
	  /*
	   * The function below gets the request status each time a new request is
	   * raised. It feed itself from the request code and request status in the request table
	   * Param:: @requestcode
	   */
	   public function getRequestStatus($requestcode){
		  switch($requestcode){
		   // Consultation
		   case 'SER0001':
		     $requestatus = '2';
		   break;
		   // First Aid
		   case 'SER0002':
		     $requestatus = '7';
		   break;
		   // Vitals
		   case 'SER0004':
		      $requestatus = '8';
		   break;
		   // Admission
		    case 'SER0005':
		      $requestatus = '4';
		   break;
		    // Detain
		    case 'SER0006':
		      $requestatus = '6';
		   break;
		    // Internal Referral
		   case 'SER0007':
		      $requestatus = '9';
		   break;
		   // External Referral
		   case 'SER0008':
		      $requestatus = '10';
		   break;
		   // Emergency
		   case "SER0010":
		     $requestatus = '11';
		   break;
		  }
		  
		  return $requestatus;
	   }
	   
	/*
	 * The function below gets the patient service request details
	 * Param:: @visitcode
	 */
	 public function getServRequestInfo($visitcode)
	 {
		$stmt =  $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_service_request WHERE REQU_VISITCODE = ".$this->sql->Param('a')." "),array($visitcode));
		print $this->sql->ErrorMsg();
		if($stmt){
		   if($stmt->RecordCount() > 0){
			   return $stmt->FetchNextObject() ;
			}	
		}else{return false;}
	 }//End getServRequestDetail



    /*
     * This function gets the patient group code
     */
    public function getPatientGroupCode($faccode){
        $items= 'PATGP';
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT PATGRP_CODE FROM hms_patient_group ORDER BY PATGRP_ID DESC LIMIT 1 "));
        print $this->sql->ErrorMsg();
        if($stmt->RecordCount() > 0){
            $obj = $stmt->FetchNextObject();
            $order = substr($obj->PATGRP_CODE,5,10000);
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
	  * Get Patient Excuse Duty Details
	  * Param::@visitcode
	  */
	  public function getExcuseDutyDetails($visicode){
		 $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_patient_excuseduty WHERE EXCD_VISITCODE = ".$this->sql->Param('a')." "),array($visicode));
		 if($stmt){
			 return $stmt->FetchnextObject();
		}else{ return 0 ;} 
	  }
	  
	  /*
    * The function below sets the emergency code
    */
	
	public function getEmergCode($facicode){
		//Get the last inserted emergency code
		$stmt = $this->sql->Execute($this->sql->Prepare("SELECT EMER_CODE FROM hms_emergency WHERE EMER_CODE LIKE ".$this->sql->Param('a')."  ORDER BY EMER_ID DESC LIMIT 1"),array('%'.$facicode.'%'));
		print $this->sql->ErrorMsg();
		if($stmt){
			if($stmt->RecordCount() > 0){
				$obj = $stmt->FetchNextObject();
				$emervar = $obj->EMER_CODE;
				$emercode = substr($emervar,strpos($emervar,'-')+1);
				
				$emercode = $emercode + 1;
				
				if(strlen($emercode) == 1){
					 $emercode = '000000'.$emercode;
				}elseif(strlen($emercode) == 2){
					 $emercode = '00000'.$emercode;
					}elseif(strlen($emercode) == 3){
					 $emercode = '0000'.$emercode;
					}elseif(strlen($emercode) == 4){
					 $emercode = '000'.$emercode;
					}elseif(strlen($emercode) == 5){
					 $emercode = '00'.$emercode;
					}elseif(strlen($emercode) == 6){
					 $emercode = '0'.$emercode;
					}
				return $emerstrg = 'CS'.$facicode.'-'.$emercode;
			}else{
				   return $emerstrg = 'CS'.$facicode.'-0000001';
				 }
		}else{
			return false;}
	}//End getEmergencyCode


    /*
     * The function below sets the Patient Payment Scheme
     */

	public function getPatientPaymentSchemeCode(){
		//Get the last inserted payment scheme code
		$stmt = $this->sql->Execute($this->sql->Prepare("SELECT PAY_CODE FROM hms_patient_paymentscheme ORDER BY PAY_ID DESC LIMIT 1"));
		print $this->sql->ErrorMsg();
		if($stmt){
			$pp = 'PS';
			$yrr = Date('y');
		    $items = $pp.''.$yrr;
			if($stmt->RecordCount() > 0){
				$obj = $stmt->FetchNextObject();
                $order = substr($obj->PAY_CODE,5,10000000);
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
                return $orderno;
			}else{
                return $orderno = $items.'-00000001';
				 }
		}else{
			return false;
		}
	}//End getEmergencyCode
	
	public function getPrescriptionInfo($visitcode){
		$stmt =  $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_patient_prescription WHERE PRESC_VISITCODE = ".$this->sql->Param('a')." AND PRESC_STATUS != '0' "),array($visitcode));
		print $this->sql->ErrorMsg();
		if($stmt){
		   if($stmt->RecordCount() > 0){
			   return $stmt->FetchNextObject() ;
			}	
		}else{return false;}
	 }//End getServRequestDetail	

}


?>