<?php
/*
 * This is the menu class for the social health platform
 * The menu class is loaded once and need not to be call again
 * Acker@Orcons
 * Date: 2017-07-20
 */
 
 class MenuClass extends engineClass{
	   
	   function __construct(){
		   
		   parent::__construct();
		   $this->userid = $this->session->get('userid');
		   $this->activeinstitution =  $this->session->get("institutioncode");
		   $this->institutiontype =  $this->session->get("institutiontype");
		   switch($this->institutiontype){
			  case "H":
			  $view = $this->getHospitalView();
			  break;
			  case "L":
			  $view = $this->getLaboratoryView();
			  break;
			  case "P":
			  $view = $this->getPharmacyView();
			  break;
			  case "C":
			  $view = $this->getCourrierView();
			  break;
			  case "A":
			  $view = $this->getAmbulanceView();
			  break;
			  case "CC":
			  $view = $this->getVirtualHospitalView();
			  break;
			  case "VH":
			  $view = $this->getVirtualHospitalViewVH();
			  break;
			  default:
			  //This is called only when a menu search is triggered
              $mainmenu = $this->getInstitutionView();
			  break;
		   } 
		      
	   } 
	   
	   /*
	    * This function loads the hospital default menu
		*/
	   private function getHospitalView(){
		    $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hmsb_menusubgroupdetail WHERE MENUDET_MENUGPCODE = '001' AND MENUDET_STATUS = '1'  "));
			print $this->sql->ErrorMsg();
			if($stmt){
				while($obj = $stmt->FetchNextObject()){
				   $thismenu[] = array($obj->MENUDET_ID,$obj->MENUDET_NAME,$obj->MENUDET_IMAGEUNINAME,$obj->MENUDET_NOTIFICATION,$obj->MENUDET_CODE);
				}
				return $thismenu;
			}else{return false ;}
	    }
	   
	   /*
	    * This function loads the hospital default menu for the side bar
		*/
	   private function getHospitalViewSide(){
		    $mainmenu = $this->getHospitalView();
		    $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hmsb_menusubgroupdetail WHERE MENUDET_MENUGPCODE = '001' AND MENUDET_STATUS = '1' AND MENUDET_SIDEBAR = '1' "));
			print $this->sql->ErrorMsg();
			if($stmt){
				while($obj = $stmt->FetchNextObject()){
					$sidesmenu[] = array($obj->MENUDET_ID,$obj->MENUDET_NAME,$obj->MENUDET_IMAGEUNINAME,$obj->MENUDET_NOTIFICATION,$obj->MENUDET_CODE);	
				}
				return $thismenu = array_intersect($sidesmenu,$mainmenu);
			}else{return false ;}
	    }
		
	   /*
	    * This function loads the hospital default menu for the side Dashboard
		*/
	   private function getHospitalViewDash(){
		    $mainmenu = $this->getHospitalView();
		    $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hmsb_menusubgroupdetail WHERE MENUDET_MENUGPCODE = '001' AND MENUDET_STATUS = '1' AND MENUDET_DASHBOARD = '1' "));
			print $this->sql->ErrorMsg();
			if($stmt){
				while($obj = $stmt->FetchNextObject()){
					$sidesmenu[] = array($obj->MENUDET_ID,$obj->MENUDET_NAME,$obj->MENUDET_IMAGEUNINAME,$obj->MENUDET_NOTIFICATION,$obj->MENUDET_CODE);	
				}
				return $thismenu = array_intersect($sidesmenu,$mainmenu);
			}else{return false ;}
	    }
		
		
	   /*
	    * This function loads the default menu aceess right
		*/
	   public function getMenuViewAccessRightSide($catcode){
		     $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hmsb_menusubusers JOIN hmsb_menusubgroupdetail ON MENUCT_MENUDETCODE = MENUDET_CODE WHERE MENUCT_USRUSERID = ".$this->sql->Param('a')." AND MENUCT_STATUS = '1' AND MENUDET_MENUCATCODE = ".$this->sql->Param('a')." AND MENUDET_STATUS = '1' "),array($this->userid,$catcode));
			print $this->sql->ErrorMsg();
			if($stmt){
				return $stmt;
				
			}else{return false ;}
		}
		

	   /*
	    * This function loads the virtual hospital default menu for the side Dashboard
		*/
		private function getVirtualHospitalViewDash(){
		    $mainmenu = $this->getVirtualHospitalView();
		    $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hmsb_menusubgroupdetail WHERE MENUDET_MENUGPCODE = '011' AND MENUDET_STATUS = '1' AND MENUDET_DASHBOARD = '1' "));
			print $this->sql->ErrorMsg();
			if($stmt){
				while($obj = $stmt->FetchNextObject()){
					$sidesmenu[] = array($obj->MENUDET_ID,$obj->MENUDET_NAME,$obj->MENUDET_IMAGEUNINAME,$obj->MENUDET_NOTIFICATION,$obj->MENUDET_CODE);	
				}
				return $thismenu = array_intersect($sidesmenu,$mainmenu);
			}else{return false ;}
		}
		

			   /*
	    * This function loads the hospital default menu
		*/
		private function getVirtualHospitalView(){
		    $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hmsb_menusubgroupdetail WHERE MENUDET_MENUGPCODE = '011' AND MENUDET_STATUS = '1'  "));
			print $this->sql->ErrorMsg();
			if($stmt){
				while($obj = $stmt->FetchNextObject()){
				   $thismenu[] = array($obj->MENUDET_ID,$obj->MENUDET_NAME,$obj->MENUDET_IMAGEUNINAME,$obj->MENUDET_NOTIFICATION,$obj->MENUDET_CODE);
				}
				return $thismenu;
			}else{return false ;}
	    }
		
		
	   /*
	    * This function loads the default menu access right
		*/
	   public function getMenuViewAccessRightDash(){
		   
		   switch($this->institutiontype){
			  case "H":
			  $mainmenu = $this->getHospitalViewDash();
			  break;
			  case "L":
			  $mainmenu = $this->getLabViewDash();
			  break;
			  case "P":
			  $mainmenu = $this->getPharmViewDash();
			  break;
			  case "C":
			  $mainmenu = $this->getCourierViewDash();
			  break;
			  case "X":
			  $mainmenu = $this->getXrayViewDash();
			  break;
			  case "A":
			  $mainmenu = $this->getAmbulanceViewDash();
			  break;
			  case "CC":
			  $mainmenu = $this->getVirtualHospitalViewDash();
			  break;
			  
		   }
		     $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hmsb_menusubusers JOIN hmsb_menusubgroupdetail ON MENUCT_MENUDETCODE = MENUDET_CODE JOIN hmsb_menusubgroup ON MENUCAT_CODE = MENUDET_MENUCATCODE WHERE MENUCT_USRUSERID = ".$this->sql->Param('a')." AND MENUCT_STATUS = '1' AND MENUDET_STATUS = '1' AND MENUDET_DASHBOARD = '1' AND MENUDET_SIDEBAR = '1' "),array($this->userid));
			print $this->sql->ErrorMsg();
			if($stmt){
				while($obj = $stmt->FetchNextObject()){
					$usrsidesmenu[] = array($obj->MENUCAT_NAME,$obj->MENUDET_NAME,$obj->MENUDET_IMAGEUNINAME,$obj->MENUDET_NOTIFICATION,$obj->MENUDET_CODE);	
				}
				
				if(is_array($usrsidesmenu) && is_array($mainmenu)){
				return $thismenu = array_intersect($usrsidesmenu,$mainmenu);
				}else{return false ;}
			}else{return false ;}
	    }
		
		/*
		 * This function gets all categories for the 
		 * appropriate institution
		 */
		 public function getAllCategory(){
			 $stmt = $this->sql->Execute($this->sql->Prepare("SELECT DISTINCT MENUCAT_NAME,MENUCAT_CODE,MENUCAT_ICONS FROM  hmsb_menusubgroup JOIN hmsb_menusubgroupdetail ON MENUCAT_CODE = MENUDET_MENUCATCODE JOIN hmsb_menusubusers ON MENUCT_MENUDETCODE = MENUDET_CODE WHERE MENUCT_USRUSERID = ".$this->sql->Param('a')." AND MENUDET_STATUS = '1'  "),array($this->userid));
			 print $this->sql->ErrorMsg();
			 if($stmt){
				 return $stmt;
			 }else{ return false;}
		 }
		 
		 /*
		  *
		  * The following function build the laboratory menu
		  *
		  */
		  
	   /*
	    * This function loads the laboratory default menu
		*/
	   private function getLaboratoryView(){
		    $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hmsb_menusubgroupdetail WHERE MENUDET_MENUGPCODE = '002' AND MENUDET_STATUS = '1'  "));
			print $this->sql->ErrorMsg();
			if($stmt){
				while($obj = $stmt->FetchNextObject()){
				   $thismenu[] = array($obj->MENUDET_ID,$obj->MENUDET_NAME,$obj->MENUDET_IMAGEUNINAME);
				}
				return $thismenu;
				//print_r($thismenu);
			}else{return false ;}
	    }
		
		
	   /*
	    * This function loads the laboratory default menu for the side Dashboard
		*/
	   private function getLabViewDash(){
		    $mainmenu = $this->getLaboratoryView();
		    $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hmsb_menusubgroupdetail WHERE MENUDET_MENUGPCODE = '002' AND MENUDET_STATUS = '1' AND MENUDET_DASHBOARD = '1' "));
			print $this->sql->ErrorMsg();
			if($stmt){
				while($obj = $stmt->FetchNextObject()){
					$sidesmenu[] = array($obj->MENUDET_ID,$obj->MENUDET_NAME,$obj->MENUDET_IMAGEUNINAME);	
				}
				if(is_array($sidesmenu)){		
				return $thismenu = array_intersect($sidesmenu,$mainmenu);
				}else{return false ;}
			}else{return false ;}
	    }
		  
		  /*
		   * End building the laboratory service
		   */
		   
		 
		 
		 /*
		  *
		  * The following function build the pharmacy menu
		  *
		  */
		  
	   /*
	    * This function loads the pharmacy default menu
		*/
	   private function getPharmacyView(){
		    $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hmsb_menusubgroupdetail WHERE MENUDET_MENUGPCODE = '003' AND MENUDET_STATUS = '1'  "));
			print $this->sql->ErrorMsg();
			if($stmt){
				while($obj = $stmt->FetchNextObject()){
				   $thismenu[] = array($obj->MENUDET_ID,$obj->MENUDET_NAME,$obj->MENUDET_IMAGEUNINAME);
				}
				return $thismenu;
				//print_r($thismenu);
			}else{return false ;}
	    }
		
		
	   /*
	    * This function loads the pharmacy default menu for the side Dashboard
		*/
	   private function getPharmViewDash(){
		    $mainmenu = $this->getPharmacyView();
		    $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hmsb_menusubgroupdetail WHERE MENUDET_MENUGPCODE = '003' AND MENUDET_STATUS = '1' AND MENUDET_DASHBOARD = '1' "));
			print $this->sql->ErrorMsg();
			if($stmt){
				while($obj = $stmt->FetchNextObject()){
					$sidesmenu[] = array($obj->MENUDET_ID,$obj->MENUDET_NAME,$obj->MENUDET_IMAGEUNINAME);	
				}
				if(is_array($sidesmenu)){		
				return $thismenu = array_intersect($sidesmenu,$mainmenu);
				}else{return false ;}
			}else{return false ;}
	    }
		  
		  /*
		   * End building the pharmacy service
		   */
		   
		   
		 /*
		  *
		  * The following function build the courier menu
		  *
		  */
		  
	   /*
	    * This function loads the courier default menu
		*/
	   private function getCourrierView(){
		    $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hmsb_menusubgroupdetail WHERE MENUDET_MENUGPCODE = '005' AND MENUDET_STATUS = '1'  "));
			print $this->sql->ErrorMsg();
			if($stmt){
				while($obj = $stmt->FetchNextObject()){
				   $thismenu[] = array($obj->MENUDET_ID,$obj->MENUDET_NAME,$obj->MENUDET_IMAGEUNINAME);
				}
				return $thismenu;
			}else{return false ;}
	    }
		
	   /*
	    * This function loads the courier default menu for the side Dashboard
		*/
	   private function getCourierViewDash(){
		    $mainmenu = $this->getCourrierView();
		    $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hmsb_menusubgroupdetail WHERE MENUDET_MENUGPCODE = '005' AND MENUDET_STATUS = '1' AND MENUDET_DASHBOARD = '1' "));
			print $this->sql->ErrorMsg();
			if($stmt){
				while($obj = $stmt->FetchNextObject()){
					$sidesmenu[] = array($obj->MENUDET_ID,$obj->MENUDET_NAME,$obj->MENUDET_IMAGEUNINAME);	
				}		
				return $thismenu = array_intersect($sidesmenu,$mainmenu);
			}else{return false ;}
	    }
		  
		  /*
		   * End building the courier service
		   */


     /*
	  * This function loads the ambulance default menu
	  */
     private function getAmbulanceView(){
         $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hmsb_menusubgroupdetail WHERE MENUDET_MENUGPCODE = '010' AND MENUDET_STATUS = '1'  "));
         print $this->sql->ErrorMsg();
         if($stmt){
             while($obj = $stmt->FetchNextObject()){
                 $thismenu[] = array($obj->MENUDET_ID,$obj->MENUDET_NAME,$obj->MENUDET_IMAGEUNINAME);
             }
             return $thismenu;
         }else{return false ;}
     }
     /*
      * End of ambulance default menu
      */


     /*
	  * This function loads the ambulance default menu for the side Dashboard
	  */
     private function getAmbulanceViewDash(){
         $mainmenu = $this->getCourrierView();
         $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hmsb_menusubgroupdetail WHERE MENUDET_MENUGPCODE = '010' AND MENUDET_STATUS = '1' AND MENUDET_DASHBOARD = '1' "));
         print $this->sql->ErrorMsg();
         if($stmt){
             while($obj = $stmt->FetchNextObject()){
                 $sidesmenu[] = array($obj->MENUDET_ID,$obj->MENUDET_NAME,$obj->MENUDET_IMAGEUNINAME);
             }
             return $thismenu = array_intersect($sidesmenu,$mainmenu);
         }else{return false ;}
     }
     /*
      * End of ambulance default menu for the side Dashboard
      */


     /*
     * This function loads the x-ray default menu for the side Dashboard
     */
     private function getXrayViewDash(){
         $mainmenu = $this->getXrayView();
         $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hmsb_menusubgroupdetail WHERE MENUDET_MENUGPCODE = '007' AND MENUDET_STATUS = '1' AND MENUDET_DASHBOARD = '1' "));
         print $this->sql->ErrorMsg();
         if($stmt){
             while($obj = $stmt->FetchNextObject()){
                 $sidesmenu[] = array($obj->MENUDET_ID,$obj->MENUDET_NAME,$obj->MENUDET_IMAGEUNINAME);
             }
             return $thismenu = array_intersect($sidesmenu,$mainmenu);
         }else{return false ;}
     }

     /*
      * End building the x-ray service
      */



     /*
	    * This function loads the x-ray default menu
		*/
     private function getXrayView(){
         $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hmsb_menusubgroupdetail WHERE MENUDET_MENUGPCODE = '007' AND MENUDET_STATUS = '1'  "));
         print $this->sql->ErrorMsg();
         if($stmt){
             while($obj = $stmt->FetchNextObject()){
                 $thismenu[] = array($obj->MENUDET_ID,$obj->MENUDET_NAME,$obj->MENUDET_IMAGEUNINAME);
             }
             return $thismenu;
         }else{return false ;}
	 }
	 


	   /*
		* This function loads the default menu
		* This function is called only in the case of menu search
		*/
		private function getInstitutionView(){
		    $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hmsb_menusubgroupdetail WHERE MENUDET_STATUS = '1'  "));
			print $this->sql->ErrorMsg();
			if($stmt){
				while($obj = $stmt->FetchNextObject()){
				   $thismenu[] = array($obj->MENUDET_ID,$obj->MENUDET_NAME,$obj->MENUDET_IMAGEUNINAME,$obj->MENUDET_NOTIFICATION,$obj->MENUDET_CODE);
				}
				return $thismenu;
			}else{return false; }
		}
		
	   /*
		* This function loads the default menu for the side Dashboard
		* This function is loaded only in the case of menu search
		*/
		private function getInstitutionViewDash(){
		    $mainmenu = $this->getInstitutionView();
		    $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hmsb_menusubgroupdetail WHERE  MENUDET_STATUS = '1' AND MENUDET_DASHBOARD = '1' "));
			print $this->sql->ErrorMsg();
			if($stmt){
				while($obj = $stmt->FetchNextObject()){
					$sidesmenu[] = array($obj->MENUDET_ID,$obj->MENUDET_NAME,$obj->MENUDET_IMAGEUNINAME,$obj->MENUDET_NOTIFICATION,$obj->MENUDET_CODE);	
				}
				return $thismenu = array_intersect($sidesmenu,$mainmenu);
			}else{return false ;}
	    }

	   /*
	    * This function loads the default menu access right based on search item
		*/
		public function getMenuViewAccessRightDashSearch($search){

			  $mainmenu = $this->getInstitutionViewDash();

			  $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hmsb_menusubusers JOIN hmsb_menusubgroupdetail ON MENUCT_MENUDETCODE = MENUDET_CODE JOIN hmsb_menusubgroup ON MENUCAT_CODE = MENUDET_MENUCATCODE WHERE MENUCT_USRUSERID = ".$this->sql->Param('a')." AND MENUCT_STATUS = '1' AND MENUDET_STATUS = '1' AND MENUDET_DASHBOARD = '1' AND MENUDET_SIDEBAR = '1' AND MENUDET_NAME LIKE ".$this->sql->Param('b')." "),array($this->userid,'%'.$search.'%'));
			 print $this->sql->ErrorMsg();
			 if($stmt){
				 while($obj = $stmt->FetchNextObject()){
					 $usrsidesmenu[] = array($obj->MENUCAT_NAME,$obj->MENUDET_NAME,$obj->MENUDET_IMAGEUNINAME,$obj->MENUDET_NOTIFICATION,$obj->MENUDET_CODE);	
				 }
				 
				 if(is_array($usrsidesmenu) && is_array($mainmenu)){
				 return $thismenu = array_intersect($usrsidesmenu,$mainmenu);
				 }else{return false ;}
			 }else{return false ;}
		 }

 }
?>