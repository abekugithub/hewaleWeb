<?php
class engineClass{
    public  $sql;
    public $session;
    public $phpmailer;
    public $mongo;
    function  __construct() {
        global $sql,$session,$phpmailer,$mongo;
        $this->session= $session;
        $this->sql = $sql;
        $this->phpmailer = $phpmailer;
        $this->mongo = $mongo;
    }
    public function concatmoney($num){
        if($num>1000000000000) {
            return round(($num/1000000000000),1).' tri';
        }else if($num>1000000000){ return round(($num/1000000000),1).' bil';
        }else if($num>1000000) {return round(($num/1000000),1).' mil';
        }else if($num>1000){ return round(($num/1000),1).' k';
        }
        return number_format($num);
    }
    public function getToken(){
        $length = '64';
        $token = bin2hex(substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"),0,$length));
        return $token;
    }
    public function getActorDetails(){
        $actor_id = $this->session->get("userid");
        $stmt = $this->sql->Prepare("SELECT * FROM hms_users WHERE USR_USERID = ".$this->sql->Param('a'));
        $stmt = $this->sql->Execute($stmt,array($actor_id));
        if($stmt && ($stmt->RecordCount() > 0)){
            return $stmt->FetchNextObject();
        }else{
            print $this->sql->ErrorMsg();
            return false;
        }
    }//end of getActorsDetails

    /*
	 * This function gets the facility details
	 */
    public function getFacilityDetails(){
        $activeinstitution = $this->session->get("activeinstitution");
        $stmt = $this->sql->Prepare("SELECT * FROM hmsb_allfacilities WHERE FACI_CODE = ".$this->sql->Param('a'));
        $stmt = $this->sql->Execute($stmt,array($activeinstitution));
        if($stmt && ($stmt->RecordCount() > 0)){
            return $stmt->FetchNextObject();
        }else{
            print $this->sql->ErrorMsg();
            return false;
        }
    }//end of getActorsDetails
    /**
     * this function is use to return actors full name.
     * @return <string>
     */
    public function getActorName(){
        $obj = $this->getActorDetails();
        return $obj->USR_OTHERNAME.' '.$obj->USR_SURNAME;
    }// end getActorName


    /**
     * this function is use to return actors code
     * @return <string>
     */
    public function getActorCode(){
        $obj = $this->getActorDetails();
        return $obj->USR_CODE;
    }// end getActorCode

    /**
     * this function is use to return Inst code
     * @return <string>
     */
    public function getActorCourier(){
        $obj = $this->getActorDetails();
        return $obj->USR_FACICODE;
    }// end getActorCode

    public function getActorCourierAlias(){
        $obj = $this->getActorDetails();
        return $obj->USR_HOSPANNEXCODE;
    }// end getActorCodeAlias



    /**
     * this function is use to return actor's group
     * @return <string>
     */
    public function getUsergroup(){
        $obj = $this->getActorDetails();

        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_facilities_usrlevel WHERE FACLV_ID = ".$this->sql->Param('a')." "),array($obj->USR_LEVEL_FACLVID));
        print $this->sql->ErrorMsg();
        if($stmt){
            $obj = $stmt->FetchNextObject();
            return $obj->FACLV_USRLEVEL;
        }else{ return false ;}

    }// end getUsergroup


    /**
     * this function is use to return actor's position
     * @return <string>
     */
    public function getUserRole(){
        $actor_id = $this->session->get("userid");
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_users JOIN hms_facilities_usrposition ON USR_HOSPOSITION = FACPOS_CODE WHERE USR_USERID = ".$this->sql->Param('a')." "),array($actor_id));
        print $this->sql->ErrorMsg();
        if($stmt){
            $obj = $stmt->FetchNextObject();
            return $obj->FACPOS_NAME;
        }else{ return false ;}

    }// end getUserRole

    /**
     * this function is use to return all actor's details
     * @return <string>
     */
    public function geAllUsersDetails($userid){
        $stmt = $this->sql->Prepare("SELECT * FROM hms_users WHERE USR_USERID = ".$this->sql->Param('a'));
        $stmt = $this->sql->Execute($stmt,array($userid));

        if($stmt)	{
            return $stmt->FetchNextObject();

        }else{return false ;}
    }// end geAllUsersDetails


    /**
     * this function is use to return all actor's Group
     * @return <string>
     */
    public function geAllUsersGroup($userid){
        $obj = $this->geAllUsersDetails($userid);

        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_facilities_usrlevel WHERE FACLV_ID = ".$this->sql->Param('a')." "),array($obj->USR_LEVEL_FACLVID));
        print $this->sql->ErrorMsg();
        if($stmt){
            $obj = $stmt->FetchNextObject();
            return $obj->FACLV_USRLEVEL;
        }else{ return false ;}

    }// end geAllUsersGroup

    public function msgBox($msg,$status){
        if(!empty($status)){
            if($status == "success"){
                echo '<div class="alert alert-success"> '.$msg.'</div>';
            }elseif($status == "info"){
                echo '<div class="alert alert-info"> '.$msg.'</div>';
            }else{
                echo '<div class="alert alert-danger"> '.$msg.'</div>';
            }
        }
    }

    /**
     * This function is use for loading the approriate login page
     * @parameter $snake :: Facility's alias
     */

    // get nursenote code
    public function getConsumecode(){
        $items= 'CSU'.date('y');
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT CSU_CODE FROM hmis_consumable_used ORDER BY CSU_ID DESC LIMIT 1 "));
        print $this->sql->ErrorMsg();
        if($stmt->RecordCount() > 0){
            $obj = $stmt->FetchNextObject();
            $order = substr($obj->CSU_CODE,5,10000000);
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
    // get nursenote code
    public function getnursenotecode(){
        $items= 'DN'.date('y');
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT MED_CODE FROM hmis_nursenote ORDER BY MED_ID DESC LIMIT 1 "));
        print $this->sql->ErrorMsg();
        if($stmt->RecordCount() > 0){
            $obj = $stmt->FetchNextObject();
            $order = substr($obj->MED_CODE,5,10000000);
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
// get daily fluid output code
    public function getfluidoutputcode(){
        $items= 'DFO'.date('y');
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT DFO_CODE FROM hmis_daily_fluidoutput ORDER BY DFO_ID DESC LIMIT 1 "));
        print $this->sql->ErrorMsg();
        if($stmt->RecordCount() > 0){
            $obj = $stmt->FetchNextObject();
            $order = substr($obj->DFO_CODE,5,10000000);
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

    public function getTreatmentcode(){
        $items= 'TS'.date('y');
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT TR_CODE FROM hmis_treatment_sheet ORDER BY TR_ID DESC LIMIT 1 "));
        print $this->sql->ErrorMsg();
        if($stmt->RecordCount() > 0){
            $obj = $stmt->FetchNextObject();
            $order = substr($obj->TR_CODE,5,10000000);
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

    public function getfluiddailycode(){
        $items= 'DF'.date('y');
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT DF_CODE FROM hmis_daily_fluid ORDER BY DF_ID DESC LIMIT 1 "));
        print $this->sql->ErrorMsg();
        if($stmt->RecordCount() > 0){
            $obj = $stmt->FetchNextObject();
            $order = substr($obj->DF_CODE,5,10000000);
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


// 15 DEC 2017 , JOSEPH ADORBOE, PRICES
    public function getpricescode(){
        $items= 'PR'.date('y');
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT PS_CODE FROM hmsb_st_pricing ORDER BY PS_ID DESC LIMIT 1 "));
        print $this->sql->ErrorMsg();
        if($stmt->RecordCount() > 0){
            $obj = $stmt->FetchNextObject();
            $order = substr($obj->PS_CODE,5,10000000);
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



    public function getLogingPage($snake){

        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT FACI_NAME,FACI_LOGO_UNINAME,FACI_ALIAS FROM hmsb_allfacilities WHERE FACI_ALIAS = ".$this->sql->Param('a')." "),array(strtoupper($snake)));
        print $this->sql->ErrorMsg();
        if($stmt && $stmt->RecordCount() > 0){
            return $stmt->FetchNextObject();
        }else{
            return false;
        }
    }

    /*
     * This function get the menu category
     * for the facility's admin in order to assign the menu to
     * the personnels he/she is managing
     * @Param:: $facilitycode
     */
    public function getMenuPreselection($facilitycode){
        //echo "okkk".$facilitycode;
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hmsb_facilities_features WHERE FACFE_FACICODE = ".$this->sql->Param('a')." AND FACFE_STATUS = '1' "),array($facilitycode));
        print $this->sql->ErrorMsg();

        if($stmt){
            return $stmt;
        }else{
            return false;
        }

    }

    //get user balance
    public function getUserBalded($facilitycode,$amount){
        $stmt= $this->sql->Execute($this->sql->Prepare("UPDATE hms_wallets SET HRMSWAL_BALANCE= HRMSWAL_BALANCE - ".$this->sql->Param('a')." WHERE HRMSWAL_USERCODE=".$this->sql->Param('c')." "),array($amount,$facilitycode));
        if($stmt==true){
            return true;
        }else{
            return false;
        }

    }
    //userbal
    public function checkbalance($faccode){ //URGENT CARE
        $stmt=$this->sql->Execute($this->sql->Prepare("SELECT HRMSWAL_BALANCE FROM hms_wallets WHERE  HRMSWAL_USERCODE=".$this->sql->Param('c').""),array($faccode));
        if ($stmt->RecordCount() > 0) {
            # code...
            $obj=$stmt->FetchNextObject();
            return $obj->HRMSWAL_BALANCE;
        }else{
            return 0;
        }


    }
    public function setDeduateAmount($facilitycode,$amount){
        $stmt= $this->sql->Execute($this->sql->Prepare("UPDATE hms_wallets SET HRMSWAL_INST_BALANCE= HRMSWAL_INST_BALANCE + ".$this->sql->Param('a')." WHERE HRMSWAL_USERCODE=".$this->sql->Param('c')." "),array($amount,$facilitycode));
        if($stmt==true){
            return true;
        }else{
            return false;
        }
    }

    public function getWalletDetails($facilitycode){

        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_wallets WHERE HRMSWAL_USERCODE=".$this->sql->Param('a')." "),array($facilitycode));

        if ($stmt->Recordcount() > 0) {
            # code...
            $obj =$stmt->FetchNextObject();
            return $obj;
        }else{
            return false;
        }
    }
    public function getUSerDetils($usercode){
        // echo $usercode;
        $stmt=$this->sql->Execute($this->sql->Prepare("SELECT USR_SURNAME,USR_OTHERNAME FROM hms_users WHERE USR_CODE=".$this->sql->Param('a')." "),array($usercode));
        if ($stmt->Recordcount() > 0) {
            # code...
            $obj = $stmt->FetchNextObject();
            return $obj->USR_SURNAME.' '.$obj->USR_OTHERNAME;
        }else{
            $stmt=$this->sql->Execute($this->sql->Prepare("SELECT PATIENT_FNAME,PATIENT_MNAME,PATIENT_LNAME FROM hms_patient WHERE PATIENT_PATIENTCODE=".$this->sql->Param('a')." "),array($usercode));

            $obj = $stmt->FetchNextObject();
            return $obj->PATIENT_LNAME.' '.$obj->PATIENT_FNAME.' '.$obj->PATIENT_MNAME;
        }

    }
    public function getPatDetils($usercode){
        // echo $usercode;
        $stmt=$this->sql->Execute($this->sql->Prepare("SELECT PATIENT_FNAME,PATIENT_MNAME,PATIENT_LNAME FROM hms_patient WHERE PATIENT_PATIENTCODE=".$this->sql->Param('a')." "),array($usercode));

        $obj = $stmt->FetchNextObject();
        return $obj->PATIENT_LNAME.' '.$obj->PATIENT_FNAME.' '.$obj->PATIENT_MNAME;
    }
//facility code
    public function getFacDetCode($faccode){

        $stmt=$this->sql->Execute($this->sql->Prepare("SELECT FACI_TYPE FROM hmsb_allfacilities WHERE FACI_CODE=".$this->sql->Param('a')." "),array($faccode));
        $obj= $stmt->FetchNextObject();
        if($obj->FACI_TYPE=='C'){
            $status="Courrier";
        }elseif($obj->FACI_TYPE=='P'){
            $status="Pharmacy";
        }elseif($obj->FACI_TYPE=='H'){
            $status="Hospital";
        }elseif($obj->FACI_TYPE=='L'){
            $status="Laboratory";
        }elseif($obj->FACI_TYPE=='X'){
            $status="X-ray";
        }elseif($obj->FACI_TYPE=='A'){
            $status="Ambulance";
        }elseif($obj->FACI_TYPE=='V'){
            $status="Vital Post";
        }
        return $status;
    }

//
    public function getPaymentBy($usercode){
        $stmt=$this->sql->Execute($this->sql->Prepare("SELECT USR_FACICODE FROM hms_users WHERE USR_CODE=".$this->sql->Param('a')." "),array($usercode));
        if ($stmt->Recordcount() > 0) {
            # code...
            $status="Self";
            return $status;
        }
    }

//desc
// public function 

//get user percentage
    public function userPercentage($facilitycode){
// echo $facilitycode;
// die();
        $stmt=$this->sql->Execute($this->sql->Prepare("SELECT FACI_INST_PERCENTAGE FROM hmsb_allfacilities WHERE FACI_CODE=".$this->sql->Param('a')." "),array($facilitycode));
        if($stmt->RecordCount() > 0){
            $obj = $stmt->FetchNextObject();
            $tot= $obj->FACI_INST_PERCENTAGE / 100;
            return $tot;

        }else{
            return 0;
        }
    }

    /*
    * This function get the features name
    */

    public function getFeatureName($featurecode){
        ///echo $featurecode;
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT MENUCAT_NAME FROM hmsb_menusubgroup WHERE MENUCAT_CODE = ".$this->sql->Param('a')." "),array($featurecode));
        print $this->sql->ErrorMsg();

        if($stmt){
            $obj = $stmt->FetchNextObject();
            return $obj->MENUCAT_NAME;
        }else{
            return false;
        }
    }


    /*
     * This function get the sub features for selection
     */
    public function getSubMenuPreselection($subcatcode){
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hmsb_menusubgroupdetail WHERE MENUDET_MENUCATCODE = ".$this->sql->Param('a')." AND MENUDET_STATUS = '1' AND MENUDET_ADMIN_ACCESSRIGHT = '1' "),array($subcatcode));
        print $this->sql->ErrorMsg();

        if($stmt){
            return $stmt;
        }else{
            return false;
        }
    }

    /*
     * This function below generates the user code
     */
    public function getUserCode(){
        $activeinstitution = $this->session->get("activeinstitution");
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT COUNT(USR_USERID) AS TOTALUSER FROM hms_users WHERE USR_FACICODE =  ".$this->sql->Param('a')." "),array($activeinstitution));
        print $this->sql->ErrorMsg();

        if($stmt){
            $obj = $stmt->FetchNextObject();
            $totusr = $obj->TOTALUSER + 1;
            return $subcounter = $activeinstitution.$totusr;
        }else{
            return false;
        }
    }


    /*
     * 27 NOV 2018, JOSEPH ADORBOE This function below generates the user code
     */
    public function getcourieritem($packagecode,$ccode){

        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_patient_prescription_main WHERE PRESCM_PACKAGECODE =  ".$this->sql->Param('a')." limit 1 "),array($packagecode));
        print $this->sql->ErrorMsg();

        if($stmt){

            $obj = $stmt->FetchNextObject();
            $packagecode = $obj->PRESCM_PACKAGECODE;
            $trackingcode = $obj->PRESCM_COUR_TRACKCODE;
            $patient = $obj->PRESCM_PATIENT;
            $patientnum = $obj->PRESCM_PATIENTNUM;
            $dat = $obj->PRESCM_DATE;
            $visit = $obj->PRESCM_VISITCODE;
            $couriercode = $obj->PRESCM_COUR_CODE;
            $couriername = $obj->PRESCM_COUR_NAME;
            $pharma = $obj->PRESCM_PHARMNAME;
            $pharmaloc = $obj->PRESCM_PHARMLOC;
            $pickupcode = $obj->PRESCM_PICKUPCODE;
            $reciver = $obj->PRESCM_RECIVERCODE;
            $phone = $obj->PRESCM_PATIENTCONTACT;
            $delloc = $obj->PRESCM_PATIENTLOC;




            $stmtt = $this->sql->Prepare("INSERT INTO hmsb_courier_basket (COB_CODE,COB_TRACKINGCODE,COB_PRESCRIPTIONCODE,COB_PATIENT,COB_PATIENTNUM,COB_PICKUPCODE,COB_DELIVERYCODE,COB_PATIENTPHONENUM,COB_DELIVERYLOCATION,COB_DATE,COB_VISITCODE,COB_PHARMACYCODE,COB_PHARMACY,COB_PHARMACYLOCATION,COB_PHARMACYPHONE,COB_COURIERCODE,COB_COURIER) VALUES (".$this->sql->Param('1').",".$this->sql->Param('2').",".$this->sql->Param('3').",".$this->sql->Param('4').",".$this->sql->Param('5').",".$this->sql->Param('6').",".$this->sql->Param('7').",".$this->sql->Param('8').",".$this->sql->Param('9').",".$this->sql->Param('10').",".$this->sql->Param('11').",".$this->sql->Param('12').",".$this->sql->Param('13').",".$this->sql->Param('14').",".$this->sql->Param('15').",".$this->sql->Param('16').",".$this->sql->Param('17').")");
            $stmtt = $this->sql->Execute($stmtt,array($ccode,$trackingcode,$packagecode,$patient,$patientnum,$pickupcode,$reciver,$phone,$delloc,$dat,$visit,$pharma,$pharma,$pharmaloc,$phone,$couriercode,$couriername));
            print $this->sql->ErrorMsg();


        }else{
            return false;
        }
    }


    /*
     * This function populates role position per facilities
     */
    public function getUserPosition(){
        $objfac = $this->getFacilityDetails();
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_facilities_usrposition WHERE FACPOS_FACICODE =  ".$this->sql->Param('a')." AND FACPOS_STATUS = '1' "),array($objfac->FACI_CODE));
        print $this->sql->ErrorMsg();

        if($stmt){
            return $stmt;
        }else{
            return false;
        }
    }
    //Leave Days Difference
    public function getDaysRunning($startdate,$enddate){
        $date2 = strtotime($enddate) - strtotime($startdate);
        if($date2 >=0){
            $daysrun = ($date2/ (60*60*24));
        }else{
            $daysrun='0';
        }
        return $daysrun;
    }

    /*
     * This menu loads the user level for setup
     * according to active facily
     */
    public function getUserLevelLoading(){
        $objdetail = $this->getFacilityDetails();
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_facilities_usrlevel WHERE FACLV_FACITYPE = ".$this->sql->Param('a')." OR FACLV_FACITYPE = 'O' "),array($objdetail->FACI_TYPE));
        print $this->sql->ErrorMsg();

        if($stmt){
            return $stmt;
        }else{
            return false;
        }
    }


    //Event log
 /*   public function setEventLog($event_type,$activity){
        $actor_id = $this->session->get("userid");
        $fullname = $this->getActorName();
        $remoteip = $_SERVER['REMOTE_ADDR'];
        $useragent = empty($_SERVER['HTTP_USER_AGENT'])? '': $_SERVER['HTTP_USER_AGENT'] ;
        $sessionid = $this->session->getSessionID();

        $stmt = $this->sql->Prepare("INSERT INTO hms_eventlog (EVL_EVTCODE,EVL_USERID,EVL_FULLNAME,EVL_ACTIVITIES,EVL_SESSION_ID,EVL_BROWSER) VALUES (".$this->sql->Param('1').",".$this->sql->Param('2').",".$this->sql->Param('3').",".$this->sql->Param('4').",".$this->sql->Param('5').",".$this->sql->Param('6').")");
        $stmt = $this->sql->Execute($stmt,array($event_type,$actor_id,$fullname,$activity,$sessionid,$useragent));
        print $this->sql->ErrorMsg();
    }//end
*/
    // Facility Code Generator
    /*public function GetFacilityCode(){
        $items= '';
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT FACI_CODE FROM hmsb_allfacilities ORDER BY FACI_CODE DESC LIMIT 1 "));
        print $this->sql->ErrorMsg();
        if($stmt->RecordCount() > 0){
            $obj = $stmt->FetchNextObject();
            $order = substr($obj->FACI_CODE,2,10000);
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
    }*/
//////////////////////////////////////////////// recipt code //////////////
    public function getreciptcode(){
        $items= 'HWE'.date('y');
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT BP_CODE FROM hms_reciept ORDER BY BP_ID DESC LIMIT 1 "));
        print $this->sql->ErrorMsg();
        if($stmt->RecordCount() > 0){
            $obj = $stmt->FetchNextObject();
            $order = substr($obj->BP_CODE,6,10000000);
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


    //GetFacilityCode
    public function getadmissionCode(){
        $items= 'AD'.date('y');
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT ADMIN_CODE FROM hms_patient_admissions ORDER BY ADMIN_ID DESC LIMIT 1 "));
        print $this->sql->ErrorMsg();
        if($stmt->RecordCount() > 0){
            $obj = $stmt->FetchNextObject();
            $order = substr($obj->ADMIN_CODE,5,10000000);
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
    }//End GetFacilityCode


    //GetFacilityCode
    public function getCode(){
        $items= 'AD'.date('y');
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT ADMIN_CODE FROM hms_patient_admissions ORDER BY ADMIN_ID DESC LIMIT 1 "));
        print $this->sql->ErrorMsg();
        if($stmt->RecordCount() > 0){
            $obj = $stmt->FetchNextObject();
            $order = substr($obj->ADMIN_CODE,5,10000000);
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
    }//End GetFacilityCode



    //GetFacilityCode
    public function labtestpricecode(){
        $items= 'DR'.date('y');
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT LL_CODE FROM hms_lab_testprice ORDER BY LL_ID DESC LIMIT 1 "));
        print $this->sql->ErrorMsg();
        if($stmt->RecordCount() > 0){
            $obj = $stmt->FetchNextObject();
            $order = substr($obj->LL_CODE,5,10000000);
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
    }//End GetFacilityCode

//set code
    public function settlementAccno($table, $prefix, $code_column){
        $code_column = strtoupper($code_column);
        $no_prec = 3;#Maximum number of preceding Zeros;
        $pref_len = strlen($prefix);
        $pref_len_m = $pref_len+1;
        $surplus = $no_prec - $pref_len;
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT  MAX(CAST( SUBSTRING({$code_column} FROM {$pref_len_m}) AS UNSIGNED)) AS {$code_column}  FROM {$table} LIMIT 1"));
        print $this->sql->ErrorMsg();
        if($stmt->RecordCount() > 0){
            $obj = $stmt->FetchNextObject();
            $prev_code = $obj->$code_column;
            $next_code = $prev_code + 1;

            $multiplier = $no_prec - strlen($next_code);
            $multiplier = $multiplier <= 0 ? 0 : $multiplier ;
            $code = str_repeat("0",$multiplier) . $next_code;
        }else{
            $code = str_repeat("0",$no_prec) . 1;
        }
        $final = $prefix.$code;

        return $final ;
    }

    //GetFacilityCode
    public function GetFacilityCode($factype){
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT FACI_CODE FROM hmsb_allfacilities WHERE FACI_CODE LIKE ".$this->sql->Param('a')." ORDER BY FACI_ID DESC LIMIT 1 "),array($factype.'%'));
        print $this->sql->ErrorMsg();
        if($stmt){
            if($stmt->RecordCount() > 0){
                $obj = $stmt->FetchNextObject();
                $facode = $obj->FACI_CODE;
                $facodenum = substr($facode,1);
                $facodenum = $facodenum + 1 ;
                if(strlen($facodenum) == 1){
                    $mainfacode = $factype.'000'.$facodenum;
                }else if(strlen($facodenum) == 2){
                    $mainfacode = $factype.'00'.$facodenum;
                }else if(strlen($facodenum) == 3){
                    $mainfacode = $factype.'0'.$facodenum;
                }else{
                    $mainfacode = $factype.$facodenum;
                }
            }else{
                $mainfacode = $factype.'0001';
            }
            return $mainfacode;
        }else{
            return false;
        }
    }//End GetFacilityCode



    // THIS FUNCTION GENERATES THE VITALS CODE FOR EACH VISIST FOR EACH PATIENT VISIT
//    public function getprescriptionCode(){
//        $items= 'DR'.date('y');
//        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT PRESC_CODE FROM hms_patient_prescription ORDER BY PRESC_ID DESC LIMIT 1 "));
//        print $this->sql->ErrorMsg();
//        if($stmt->RecordCount() > 0){
//            $obj = $stmt->FetchNextObject();
//            $order = substr($obj->PRESC_CODE,5,10000000);
//            $order = $order + 1;
//            if(strlen($order) == 1){
//                $orderno = $items.'-000000'.$order;
//            }else if(strlen($order) == 2){
//                $orderno = $items.'-00000'.$order;
//            }else if(strlen($order) == 3){
//                $orderno = $items.'-0000'.$order;
//            }else if(strlen($order) == 4){
//                $orderno = $items.'-000'.$order;
//            }else if(strlen($order) == 5){
//                $orderno = $items.'-00'.$order;
//            }else if(strlen($order) == 6){
//                $orderno = $items.'-0'.$order;
//            }else if(strlen($order) == 7){
//                $orderno = $items.'-'.$order;
//            }else{
//                $orderno = $items.$order;
//            }
//        }else{
//            $orderno = $items.'-0000001';
//        }
//        return $orderno;
//    }

    public function getprescriptionCode($table,$prefix,$code_column){
        return $this->generateCode_bk($table,$prefix,$code_column);
    }


    /*
     * This function generates code
     */
    public function generateCode_bk($table, $prefix, $code_column){
        $code_column = strtoupper($code_column);
        $no_prec = 10;#Maximum number of preceding Zeros;
        $pref_len = strlen($prefix);
        $pref_len_m = $pref_len+1;
        $surplus = $no_prec - $pref_len;
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT  MAX(CAST( SUBSTRING({$code_column} FROM {$pref_len_m}) AS UNSIGNED)) AS {$code_column}  FROM {$table} LIMIT 1"));
        print $this->sql->ErrorMsg();
        if($stmt->RecordCount() > 0){
            $obj = $stmt->FetchNextObject();
            $prev_code = $obj->$code_column;
            $next_code = $prev_code + 1;
            $multiplier = $no_prec - strlen($next_code);
            $multiplier = $multiplier <= 0 ? 0 : $multiplier ;
            $code = str_repeat("0",$multiplier) . $next_code;
        }else{
            $code = str_repeat("0",$no_prec) . 1;
        }
        $final = $prefix.$code;
        #check if code already exists
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT {$code_column}  FROM {$table} WHERE {$code_column}={$this->sql->Param('a')} LIMIT 1"),[$final]);
        if($stmt->RecordCount()>0){
            return  $this->generateCode($table, $prefix, $code_column);
        }

        return $final ;
    }


// THIS FUNCTION GENERATES THE VITALS CODE FOR EACH VISIST FOR EACH PATIENT VISIT
    public function getdiagnosisCode(){
        $items= 'DA'.date('y');
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT DIA_CODE FROM hms_patient_diagnosis ORDER BY DIA_ID DESC LIMIT 1 "));
        print $this->sql->ErrorMsg();
        if($stmt->RecordCount() > 0){
            $obj = $stmt->FetchNextObject();
            $order = substr($obj->DIA_CODE,5,10000000);
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



// THIS FUNCTION GENERATES THE VITALS CODE FOR EACH VISIST FOR EACH PATIENT VISIT
    public function getcomplainCode(){
        $items= 'PC'.date('y');
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT PC_CODE FROM hms_patient_complains ORDER BY PC_ID DESC LIMIT 1 "));
        print $this->sql->ErrorMsg();
        if($stmt->RecordCount() > 0){
            $obj = $stmt->FetchNextObject();
            $order = substr($obj->PC_CODE,5,10000000);
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




// THIS FUNCTION GENERATES THE VITALS CODE FOR EACH VISIST FOR EACH PATIENT VISIT
    public function getlabtestCode(){
        $items= 'LT'.date('y');
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT LT_CODE FROM hms_patient_labtest ORDER BY LT_INPUTEDDATE DESC LIMIT 1 "));
        print $this->sql->ErrorMsg();
        if($stmt->RecordCount() > 0){
            $obj = $stmt->FetchNextObject();
            $order = substr($obj->LT_CODE,5,10000000);
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


    /*
     * Generate X-Ray Test Code
     */
    public function getXrayTestCode(){
        $items= 'XT'.date('y');
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT XT_CODE FROM hms_patient_xraytest ORDER BY XT_INPUTEDDATE DESC LIMIT 1 "));
        print $this->sql->ErrorMsg();
        if($stmt->RecordCount() > 0){
            $obj = $stmt->FetchNextObject();
            $order = substr($obj->XT_CODE,5,10000000);
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



//THIS FUNCTION GENERATES THE PARCEL CODES
    public function getparcelcode(){
        $items = 'CO';
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT CS_CODE FROM hms_courierprocesses ORDER BY CS_ID DESC LIMIT 1 "));
        print $this->sql->ErrorMsg();
        if($stmt->RecordCount() > 0){
            $obj = $stmt->FetchNextObject();
            $order = substr($obj->CS_CODE,5,10000000);
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



    public function getpharmcystocks($faccode,$dg,$qq){
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT ST_ID FROM hms_pharmacystock WHERE ST_CODE=".$this->sql->Param('a')." and ST_FACICODE =".$this->sql->Param('a')." and ST_QTY > ".$this->sql->Param('a')." "),array($dg,$faccode,$qq));
        print $this->sql->ErrorMsg();

        if ($stmt){
            if($stmt->RecordCount() > 0){
                return 1 ;
            }else{
                return 0 ;

            }
        }

    }



    public function getunitprice($faccode,$dg){
        $meth = 'PC0001';
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT PPR_PRICE FROM hms_pharmacyprice WHERE PPR_DRUGCODE=".$this->sql->Param('a')." and PPR_FACICODE =".$this->sql->Param('a')." and PPR_METHOD = ".$this->sql->Param('a')." "),array($dg,$faccode,$meth));
        print $this->sql->ErrorMsg();

        if ($stmt){
            if($stmt->RecordCount() > 0){

                $obj = $stmt->FetchNextObject();
                return $obj->PPR_PRICE;

            }else{
                return 0 ;

            }
        }

    }



//This function return the accessibility per user and per unit
    public function getUserUnitAccess($userid,$unitcode){
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hmsb_menusubusers WHERE MENUCT_USRUSERID = ".$this->sql->Param('a')." AND MENUCT_MENUDETCODE = ".$this->sql->Param('b')." "),array($userid,$unitcode));
        print $this->sql->ErrorMsg();
        if($stmt){
            return $stmt;
        }else{return false ;}

    }

    /*
        * This function get the medical practitioner specialty
        * @Param specialtycode
        */
    public function getDoctorSpecialty($specialcode){
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT SP_NAME FROM hmsb_st_speciality WHERE SP_CODE=".$this->sql->Param('a').""),array($specialcode));
        print $this->sql->ErrorMsg();

        if ($stmt){
            $obj = $stmt->FetchNextObject();
            return $obj->SP_NAME;
        }else{
            return false;
        }
    }

    /*This function generate the position code*/
    public function getPositionCode($facilitycode){
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT FACPOS_ID FROM hms_facilities_usrposition WHERE FACPOS_FACICODE = ".$this->sql->Param('a')." ORDER BY FACPOS_ID DESC LIMIT 1"),array($facilitycode));
        print $this->sql->ErrorMsg();

        if($stmt){
            $obj = $stmt->FetchNextObject();
            $poscode = $obj->FACPOS_ID + 1;
            return $poscode = $poscode.'_'.$facilitycode;

        }else{return false;}
    }

    public function getDefaultService(){
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hmsb_services WHERE SERV_LMARK = '1'"),array());
        print $this->sql->ErrorMsg();

        if($stmt){
            if($stmt->RecordCount() > 0)
            {
                return $stmt->FetchNextObject();
            }
        }else{return false;}

    }

    /*
     * Get service name
     * Param:: @servicecode
     */
    public function getServiceDetails($servicecode){
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hmsb_services WHERE SERV_CODE = ".$this->sql->Param('a')." "),array($servicecode));
        print $this->sql->ErrorMsg();

        if($stmt){
            if($stmt->RecordCount() > 0)
            {
                return $stmt->FetchNextObject();
            }
        }else{return false;}

    } //End service details

    /*
     * Get all official services in the hospital
     */

    public function getAllOfficialServices(){
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hmsb_services WHERE SERV_OFFICIAL = '1'"),array());
        print $this->sql->ErrorMsg();

        if($stmt){
            if($stmt->RecordCount() > 0)
            {
                return $stmt;
            }
        }else{return false;}

    }
    //End getAllOfficialServices

    public function getDateFormat($inputdate,$format="Y-m-j"){
        //echo '. '.$inputdate."<br/>";
        $input = explode("/",$inputdate);
        $mk = $input[2].'-'.$input[1].'-'.$input[0];
        if($format=="j/m/Y"){
            $input = explode("-",$inputdate);
            $mk =$input[2].'/'.$input[1].'/'.$input[0];
        }
        return $mk;
    }

    public function getDate_Format($inputdate,$format="Y-m-j"){
        //echo '. '.$inputdate."<br/>";
        $input = explode("/",$inputdate);
        $mk = $input[2].'-'.$input[0].'-'.$input[1];
        if($format=="m/j/Y"){
            $input = explode("-",$inputdate);
            $mk =$input[2].'/'.$input[0].'/'.$input[1];
        }
        return $mk;
    }

    /*
     * This function gets a patients consultation history
     *  param @patientnum
     */
    public function getPatientConsultationRecord($patientnum){
        $stmt1 = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_patient_diagnosis JOIN hms_consultation 
ON hms_consultation.CONS_VISITCODE=hms_patient_diagnosis.DIA_VISITCODE
JOIN hms_patient_prescription
ON hms_patient_prescription.PRESC_VISITCODE=hms_consultation.CONS_VISITCODE 
WHERE CONS_PATIENTNUM=".$this->sql->Param('a')." ORDER BY CONS_INPUTDATE"),array($patientnum));
        print $this->sql->ErrorMsg();
        if ($stmt1){
            return $stmt1;
        }
    }


    /*
     * This function gets all currencies
     */
    public function getCurrency(){
        $stmtc = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_currency WHERE CY_STATUS = '1'"));
        if ($stmtc){
            $currencies = array();
            while($cur = $stmtc->FetchNextObject()){
                $currencies[]=$cur;
            }
        }
        return $currencies;
    }

    public function getPharmacyStockItem(){
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * from hms_ph_drugs ORDER BY ST_NAME ASC"),array());
        print $this->sql->ErrorMsg();

        if($stmt){
            if($stmt->RecordCount() > 0)
            {
                return $stmt->FetchNextObject();
            }
        }else{return false;}

    }

    /*
     * This function is to generates the notification
     * for the various aspects of the systems.
     */
    public function setNotification($code,$desc,$menudetailscode,$tablerowid,$sentto="",$faccodein=""){
        //Active user
        $actualdate = date("Y-m-d h:m:s");
        $actordetails = $this->getActorDetails();
        $actorcode = $actordetails->USR_CODE;
        $facdetails = $this->getFacilityDetails();
        $faccode = $facdetails->FACI_CODE;
        $facourier=($code=='013')?$faccodein:'';
        if($faccode != 'H0001' &&  $code != '052'){
            $faccodein = $faccode;
        }
        $faccodein=(!empty($facourier)?$facourier:$faccodein);

        $stmt = $this->sql->Execute("INSERT INTO hms_notification_details(NOTIFD_NOTIFCODE,NOTIFD_DESCRIPTION,NOTIFD_SENTBY,NOTIFD_SENTTO,NOTIFD_FACCODE_OUT,NOTIFD_FACCODE_IN,NOTIFD_SENTDATE,NOTIFD_MENUDETCODE,NOTIFD_TABLEROWID) VALUES(".$this->sql->Param('a').",".$this->sql->Param('b').",".$this->sql->Param('c').",".$this->sql->Param('d').",".$this->sql->Param('e').",".$this->sql->Param('f').",".$this->sql->Param('g').",".$this->sql->Param('g').",".$this->sql->Param('h').") ",array($code,$desc,$actorcode,$sentto,$faccode,$faccodein,$actualdate,$menudetailscode,$tablerowid));
        print $this->sql->ErrorMsg();
    }

    //curl connection class
    function curlMain($params, $url,$post=true) {
        try {

            $adb_option_defaults = array (
                CURLOPT_HEADER => false,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 700000
            );

            $options = array (
                CURLOPT_URL => $url,
                CURLOPT_POST => $post,
                CURLOPT_POSTFIELDS => $params,
								CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false
            );

            if (! isset ( $adb_handle ))
                $adb_handle = curl_init ();

            curl_setopt_array ( $adb_handle, ($options + $adb_option_defaults) );
            // var_dump("Sdssd");
            // send request and wait for responce

            $output = curl_exec ( $adb_handle );
            // print_r($output);
            // die();
            if ($output != false) {

                $responce = json_decode ( $output, true );
                // $responce = $output;
                // die($output);

                curl_close ( $adb_handle );
                // print_r($responce.'fgdgdg');
                // die();
                return ($responce);
            } else {
                echo 'Curl error: ' . curl_error ( $adb_handle );
            }

            curl_close ( $adb_handle );

            return false;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }


    /*
     * End of notification
     */

    /*
     * This function is to set the notification to read
     */
    public function ClearNotification($menudetailscode,$tablerowid){
        //Active user
        $actordetails = $this->getActorDetails();
        $actorcode = $actordetails->USR_CODE;
        $stmt = $this->sql->Execute("UPDATE hms_notification_details SET NOTIFD_STATUS = '1',NOTIFD_READBY = ".$this->sql->Param('a')." WHERE NOTIFD_MENUDETCODE = ".$this->sql->Param('b')." AND NOTIFD_TABLEROWID = ".$this->sql->Param('c')." ",array($actorcode,$menudetailscode,$tablerowid));
        print $this->sql->ErrorMsg();
    }

    /*
     * End of notification
     */


    /*
     * This function is to count the notification
     * for the various aspects of the systems.
     * Param1: $menudetailscode (defines the module details code)
     * Param2: $notiftype (defines the notification type:: 1 for medical pratitionners and 2 for facily targeted    notification)
     */
    public function getTotalNotification($menudetailscode,$notiftype){
        //echo $menudetailscode."<br>";

        //echo $notiftype."<br>";
        $actordetails = $this->getActorDetails();

        if($notiftype == 1){

            $actorcode = $actordetails->USR_CODE;
            $stmt = $this->sql->Execute($this->sql->Prepare("SELECT COUNT(NOTIFD_ID) AS TOTALNOTIF FROM hms_notification_details WHERE NOTIFD_MENUDETCODE = ".$this->sql->Param('a')." AND NOTIFD_SENTTO = ".$this->sql->Param('b')." AND NOTIFD_STATUS = '0' "),array($menudetailscode,$actorcode));
            print $this->sql->ErrorMsg();

        }elseif($notiftype == 2){ 

            $actorcode = $actordetails->USR_CODE;
            $facicode = $actordetails->USR_FACICODE;

            //echo $menudetailscode."<br>";
            $stmt = $this->sql->Execute($this->sql->Prepare("SELECT COUNT(NOTIFD_ID) AS TOTALNOTIF FROM hms_notification_details WHERE NOTIFD_MENUDETCODE = ".$this->sql->Param('a')." AND NOTIFD_FACCODE_IN = ".$this->sql->Param('b')."  AND NOTIFD_STATUS = '0'  "),array($menudetailscode,$facicode));
            print $this->sql->ErrorMsg();

        }

        if($stmt){
            $obj = $stmt->FetchNextObject();
            return $obj->TOTALNOTIF;
        }else{return false ; }
    }



    public function getTotalNotificationRefresh($menudetailscode,$notiftype,$targetcode){
        //echo $menudetailscode."<br>";

        //echo $notiftype."<br>";

        if($notiftype == 1){

            
            $stmt = $this->sql->Execute($this->sql->Prepare("SELECT COUNT(NOTIFD_ID) AS TOTALNOTIF FROM hms_notification_details WHERE NOTIFD_MENUDETCODE = ".$this->sql->Param('a')." AND NOTIFD_SENTTO = ".$this->sql->Param('b')." AND NOTIFD_STATUS = '0' "),array($menudetailscode,$targetcode));
            print $this->sql->ErrorMsg();

        }elseif($notiftype == 2){

           // $actorcode = $actordetails->USR_CODE;
            //$facicode = $actordetails->USR_FACICODE;
            //echo $menudetailscode."<br>";
            $stmt = $this->sql->Execute($this->sql->Prepare("SELECT COUNT(NOTIFD_ID) AS TOTALNOTIF FROM hms_notification_details WHERE NOTIFD_MENUDETCODE = ".$this->sql->Param('a')." AND NOTIFD_FACCODE_IN = ".$this->sql->Param('b')."  AND NOTIFD_STATUS = '0'  "),array($menudetailscode,$targetcode));
            print $this->sql->ErrorMsg();

        }

        if($stmt){
            $obj = $stmt->FetchNextObject();
            return $obj->TOTALNOTIF;
        }else{return false ; }
    }


    /*
     *  This function gets Countries
     */
    public function getCountry(){
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hmsb_countries_nationalities WHERE CN_STATUS='1'"));
        print $this->sql->ErrorMsg();
        if ($stmt){
            return $stmt;
        }
    }

    /*
     * End of notification count
     */

    /*
     * This function gets all suppliers for a pharmacy
     */

    public function getSuppliers($facicode){
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_pharmsuppliers 
WHERE SU_INSTICODE=".$this->sql->Param('a')." AND SU_STATUS = '1' "),array($facicode));
        print $this->sql->ErrorMsg();
        if($stmt){
            return $stmt;
        }else{
            return false;
        }
    }


    /*
     * This function gets all stocks for a pharmacy
     */
    public function getPharmStock($facicode){
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_pharmacystock 
WHERE ST_FACICODE = ".$this->sql->Param('a')." AND ST_STATUS = '1' "),array($facicode));
        print $this->sql->ErrorMsg();
        if($stmt){
            return $stmt;
        }else{
            return false;
        }
    }

    /*
     * This function generates a supply code for the pharmacy
     */
    public function getSuppCode($facicode){
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT SUP_CODE FROM hms_ph_supplies 
WHERE SUP_FACICODE = ".$this->sql->Param('a')." ORDER BY SUP_ID DESC LIMIT 1 "),array($facicode));
        print $this->sql->ErrorMsg();
        if($stmt){
            if($stmt->RecordCount() > 0){
                $obj = $stmt->FetchNextObject();
                $temp = $obj->SUP_CODE;
                $tempcode = substr($temp,strpos($temp,'_') + 1);
                $suppcount = $tempcode + 1;
                $suppcode = $facicode.'_'.$suppcount;

            }else{
                $suppcode = $facicode.'_1';
            }

            return $suppcode;
        }else{
            return false;
        }
    }


    /*
     * The function below generates the Service Request Code
     * and highlight row when necessary.
     * Param::@facicode, @patientnum
     */
    public function serviceRequestCode($facicode,$patientnum){
        //Get the last inserted consultation code
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT REQU_CODE FROM hms_service_request WHERE REQU_FACI_CODE = ".$this->sql->Param('a')." ORDER BY REQU_ID DESC LIMIT 1"),array($facicode));
        print $this->sql->ErrorMsg();
        $actualdate = date('Ymd');
        if($stmt){
            if($stmt->RecordCount() > 0){
                $obj = $stmt->FetchNextObject();

                $consltvar = $obj->REQU_CODE;
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
                return $consultstrg = 'SR'.$actualdate.$facicode.$patientnum.'-'.$consultcode;
            }else{
                return $consultstrg = 'SR'.$actualdate.$facicode.$patientnum.'-0000001';
            }
        }else{return false;}
    }//End servicerequestcode





    /*
    * The function below sets the visit code
	
    */

    // THIS FUNCTION GENERATES THE PAYMENT CODE FOR EACH PAYMENT BELONGING TO AN INSTITUTION
    public function getreciverCode(){
        //    $items= 'PINS';
        $dat = date("Y-m-d");
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT C_RECIVERCODE FROM hms_prescriptioncode where C_DATE = ".$this->sql->Param('a')." ORDER BY C_ID DESC LIMIT 1 "),array($dat));
        print $this->sql->ErrorMsg();
        if($stmt->RecordCount() > 0){
            $obj = $stmt->FetchNextObject();
            $order = substr($obj->C_RECIVERCODE,1,10000);
            $order = $order + 1;
            if(strlen($order) == 1){
                $orderno = '0000'.$order;
            }else if(strlen($order) == 2){
                $orderno = '000'.$order;
            }else if(strlen($order) == 3){
                $orderno = '00'.$order;
            }else if(strlen($order) == 4){
                $orderno = '0'.$order;
            }else if(strlen($order) == 5){
                $orderno = $order;
            }
        }else{
            $orderno = 00001;
        }
        return $orderno;
    }



    public function pickupcode(){

        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT C_PICKUPCODE FROM hms_prescriptioncode ORDER BY C_ID DESC LIMIT 1"));
        print $this->sql->ErrorMsg();
        $actualdate = date('ymd');
        // $consltvar='0';
        if($stmt){
            if($stmt->RecordCount() > 0){
                $obj = $stmt->FetchNextObject();
                $consltvar = $obj->C_PICKUPCODE;
                // $consltvar=$consltvar+1;
                $lasttwo=substr($consltvar,-2);
                /** $pickupcode = substr($consltvar,strpos($consltvar,'-')+1);

                $pickupcode = $pickupcode + 1;

                if(strlen($pickupcode) == 1){
                $pickupcode = '000'.$pickupcode;
                }elseif(strlen($pickupcode) == 2){
                $pickupcode = '00'.$pickupcode;
                }elseif(strlen($pickupcode) == 3){
                $pickupcode = '0'.$pickupcode;

                }**/
                return $consultstrg = $actualdate.$lasttwo+1;

            }else{

                return $consultstrg =$actualdate.'1';
            }

        }else{return false;}
    }//End visitcode

    //transaction chart
    public function getSumMonth($value,$userid){

        $stmt= $this->sql->Execute($this->sql->Prepare("SELECT SUM(HRMSTRANS_AMOUNT) AS MONTH_TOTAL FROM hms_wallet_transaction WHERE HRMSTRANS_RECEIVER=".$this->sql->Param('a')." AND YEAR(HRMSTRANS_DATE) = YEAR(CURDATE()) AND MONTH(HRMSTRANS_DATE)=".$this->sql->Param('a')." "),array($userid,$value));
        if($stmt->RecordCount()> 0){
            $obj= $stmt->FetchNextObject();
            return $obj->MONTH_TOTAL;
        }else{
            return 0;
        }
    }


    public function visitcode($facicode,$patientnum){
        //Get the last inserted consultation code
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT REQU_VISITCODE FROM hms_service_request WHERE REQU_VISITCODE LIKE ".$this->sql->Param('a')." ORDER BY REQU_ID DESC LIMIT 1"),array('%'.$facicode.'%'));
        print $this->sql->ErrorMsg();
        $actualdate = date('Ymd');
        if($stmt){
            if($stmt->RecordCount() > 0){
                $obj = $stmt->FetchNextObject();
                $consltvar = $obj->REQU_VISITCODE;
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
	 * This function gets a total stock
	 * for a supply
	 * Param @suppcode
	 */
    public function getTotalSupplystock($suppcode){
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT SUM(SUPDT_QUANTITY) AS TOTALQTY FROM hms_ph_suppliesdetails WHERE SUPDT_SUPCODE = ".$this->sql->Param('a')." "),array($suppcode));
        print $this->sql->ErrorMsg();
        if($stmt){
            $obj = $stmt->FetchNextObject();
            return $obj->TOTALQTY;
        }else{
            return false;
        }
    }
    //End total stock

    /*
     * Get stock supply details
     */
    public function getStockSupplyDetails($supid){
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_ph_suppliesdetails WHERE SUPDT_ID = ".$this->sql->Param('b')." "),array($supid));
        print $this->sql->ErrorMsg();
        if($stmt){
            return $stmt->FetchNextObject();
        }else{
            return false;
        }
    }
    //End stock supply details


    /*
     *  Get stock details from stocks level
     */
    public function getStockDetails($stockcode,$facicode){
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_pharmacystock WHERE ST_CODE = ".$this->sql->Param('b')." AND ST_FACICODE = ".$this->sql->Param('b')." "),array($stockcode,$facicode));
        print $this->sql->ErrorMsg();
        if($stmt){
            return $stmt->FetchNextObject();
        }else{
            return false;
        }
    }

    public function getUsertype(){
        $actordetail = $this->getActorDetails();
        $usrtype = $actordetail->USR_TYPE;
        return  $usrtype;
    }
    // End stock details from stocks level

    //This function fetches all services
    public function getConsultActions(){
        $actordetail = $this->getActorDetails();
        $usrtype = $actordetail->USR_TYPE;
        if($usrtype == 2){
            $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hmsb_services WHERE SERV_STATUS = '1' AND SERV_DOC_STATUS IN ('1','3') "));
        }else{
            $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hmsb_services WHERE SERV_STATUS = '1' AND SERV_DOC_STATUS IN ('2','3') "));
        }
        print $this->sql->ErrorMsg();

        if($stmt){
            return  $stmt;
        }else{
            return false;
        }
    }


    public function getwardActions(){
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hmsb_services WHERE SERV_STATUS = '1' AND SERV_WARD_STATUS IN ('0','1','2','3','4','5','6','7','8','9','10') "));

        if($stmt){
            return  $stmt;
        }else{
            return false;
        }
    }
    /*
     * This function generates/get the Patient Group Code for Group Patient Registration
     * @Params: faccode
     */
    public function userdepartmentcode($faccode){
        $item = 'UDC'.date('Ymd');
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT USRDEPT_CODE FROM hms_userdepartment WHERE hms_userdepartment.USRDEPT_CODE LIKE ".$this->sql->Param('a')." ORDER BY USRDEPT_ID DESC LIMIT 1"),array('%'.$faccode.'%'));
        print $this->sql->ErrorMsg();
        if ($stmt->RecordCount()>0){
            $obj = $stmt->FetchNextObject()->USRDEPT_CODE;

            $grpcode = substr($obj,strpos($obj,'-')+1);
            $grpcode = $grpcode + 1;
            $groupcode='';

            if (strlen($grpcode) == 1){
                $grpcode = '00'.$grpcode;
            }elseif (strlen($grpcode) == 2){
                $grpcode = '0'.$grpcode;
            }elseif (strlen($grpcode) == 3){
                $grpcode = $grpcode;
            }
            $groupcode = $item.$faccode.'-'.$grpcode;
        }else{
            $groupcode = $item.$faccode.'-001';
        }
        return $groupcode;
    }

    public function getFacilityType(){
        $obj =$this->getFacilityDetails();
        return $obj->FACI_TYPE;
    }

    // THIS FUNCTION GENERATES THE PAYMENT CODE FOR EACH PAYMENT BELONGING TO AN INSTITUTION
    public function getPaymentCode(){
        $items= 'PINS';
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT PINS_CODE FROM hms_facilities_payment ORDER BY PINS_ID DESC LIMIT 1 "));
        print $this->sql->ErrorMsg();
        if($stmt->RecordCount() > 0){
            $obj = $stmt->FetchNextObject();
            $order = substr($obj->PINS_CODE,5,10000000);
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


    public function getPaymentSchemeCode(){
        $items= 'PMT';
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT PAYM_CODE FROM hmsb_st_paymentmethod ORDER BY PAYM_ID DESC LIMIT 1 "));
        print $this->sql->ErrorMsg();
        if($stmt->RecordCount() > 0){
            $obj = $stmt->FetchNextObject();
            $order = substr($obj->PAYM_CODE,5,10000000);
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

    public function getPaymentcategoryCode(){
        $items= 'PMT';
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT FPC_CODE FROM hmsb_pay_facilitypaymentcategory ORDER BY FPC_ID DESC LIMIT 1 "));
        print $this->sql->ErrorMsg();
        if($stmt->RecordCount() > 0){
            $obj = $stmt->FetchNextObject();
            $order = substr($obj->FPC_CODE,5,10000000);
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



    /*
        * This function gets category name based on category code
        */
    public function getPaymentCategoryName($catecode){
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT PCS_CATEGORY from hmsb_set_paymentcatgory WHERE PCS_CATECODE=".$this->sql->Param('a')." AND PCS_STATUS=".$this->sql->Param('b')." LIMIT 1"),array($catecode,'1'));
        print $this->sql->ErrorMsg();
        if ($stmt->RecordCount()>0){
            while ($obj=$stmt->FetchNextObject()){
                $category=$obj->PCS_CATEGORY;
            }
            return $category;
        }else{
            return false;
        }
    }

    /*
     * This function gets category name based on category code
     */
    public function getPaymentCategoryMethod($methodecode){
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT PAYM_NAME from hmsb_set_paymentmethod WHERE PAYM_CODE=".$this->sql->Param('a')." AND PAYM_STATUS=".$this->sql->Param('b')." LIMIT 1"),array($methodecode,'1'));
        print $this->sql->ErrorMsg();
        if ($stmt->RecordCount()>0){
            while ($obj=$stmt->FetchNextObject()){
                $method=$obj->PAYM_NAME;
            }
            return $method;
        }else{
            return false;
        }
    }

    /*
     * This function gets all services
     * related to a depatment
     */
    public function getMappedServices($depcode){
        $allservices = array();
        $activeinstitution = $this->session->get("activeinstitution");
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_assigndept WHERE ST_FACICODE = ".$this->sql->Param('a')." AND ST_DEPT = ".$this->sql->Param('b')." "),array($activeinstitution,$depcode));
        print $this->sql->ErrorMsg();

        if($stmt){
            while($obj = $stmt->FetchNextObject()){
                $allservices[] = $obj->ST_SERVICENAME;
            }
            return $allservices;
        }else{
            return false;
        }
    }
    //End of services relate to department

    /*
     * Get service name
     * Param:: @servicecode
     */
    public function getDepartmentDetails($depcode){
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hmsb_department WHERE DEPT_CODE = ".$this->sql->Param('a')." "),array($depcode));
        print $this->sql->ErrorMsg();

        if($stmt){
            if($stmt->RecordCount() > 0)
            {
                return $stmt->FetchNextObject();
            }
        }else{return false;}

    } //End get service name

//This function return the service per department
    public function getServiceMapDept($facicode,$deptcode,$servcode){
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_assigndept WHERE ST_FACICODE = ".$this->sql->Param('a')." AND ST_DEPT = ".$this->sql->Param('b')." AND ST_SERVICE = ".$this->sql->Param('c')." "),array($facicode,$deptcode,$servcode));
        print $this->sql->ErrorMsg();

        if($stmt){

            return $stmt;

        }else{
            return false ;

        }

    }

    public function getpharmacypricecode(){

        $items= 'PP';
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT PPR_CODE FROM hms_pharmacyprice WHERE PPR_CODE LIKE ".$this->sql->Param('a')." ORDER BY PPR_ID DESC LIMIT 1"),array('PP%'));
        print $this->sql->ErrorMsg();
        if($stmt->RecordCount() > 0){
            $obj = $stmt->FetchNextObject();
            $order = substr($obj->PPR_CODE,5,10000000);
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

    }//End GetFacilityCode

    /*
        * This function get the users assigned departments
        */
    public function getUserAssignedDepartment($usercode,$faccode){
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT USRDEPT_DEPTCODE FROM hms_userdepartment WHERE USRDEPT_USERCODE=".$this->sql->Param('a')." AND USRDEPT_FACCODE=".$this->sql->Param('b')),array($usercode,$faccode));
        print $this->sql->ErrorMsg();
        if ($stmt->RecordCount()>0){
            $obj = $stmt->FetchNextObject();
            $departcode = $obj->USRDEPT_DEPTCODE;
        }
        return $departcode;
    }


    /**
     * @param $string
     * @param $repl
     * @param $limit
     * @return string
     */
    public function add3dots($string, $repl, $limit) {
        if(strlen($string) > $limit) {
            return substr($string, 0, $limit) . $repl;
        }else {
            return $string;
        }
    }


    /**
     * Description : function used to send push notification
     * to specific mobile app users
     * @param string $title stands for the title of the push notifications
     * @param string $message stands for the body/content of the push notifications
     * @param string $playerid stands for the deviceId of the specific user
     * @param string $type stands for the type of broadcast being sent
     * @param array  $data stands for the data sent along side the $type parameter
     * @param string $largimg stands for the medium image of the push notifications
     * @param string $bigimg stands for the bigger image of the push notifications
     * @return mixed
     *
     * Author: Acker
     * Parameter @title: Message title, @message: message seen by the mobile app user, @player: User phone player id
     * @type: the type is defined in the hms_notification_type table, @data: Extra data sent
     * @largimg: large image seen by user when push notification is delivered, @bigimg stands as favicon for push
     */
    public function broadcastIndividualMessage( $title,$message,$playerid,$type=null,$data=array(),$largimg='',$bigimg=''){
        $appid="7552392c-4d7d-4e4d-a672-56509c316478";
        $authorization="YmMxOTU4YTktZDAxMC00YzAxLWIyYjktYjQwZmQyYjI3NTE4";
        $content = array(
            "en" => $message
        );

        $fields = array(
            'app_id' => $appid,
            // 'included_segments' => array('All'),
            'include_player_ids' => array($playerid),//array("6392d91a-b206-4b7b-a620-cd68e32c3a76","76ece62b-bcfe-468c-8a78-839aeaa8c5fa","8e0f21fa-9a5a-4ae7-a9a6-ca1f24294b86"),
            'android_group' => '',
            'data' => array("type" => $type,
                "data"=>$data),
            'contents' => $content,
            'headings'=>array(
                "en" => $title
            ),
            'small_icon'=> 'http://hewale.net/media/img/favicon.png',
            'large_icon'=> (($largimg)? $largimg :'http://hewale.net/media/img/report-logo.png'),
            'big_picture'=>'http://hewale.net/media/img/'.$bigimg
        );

        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
            'Authorization: Basic '.$authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $response = curl_exec($ch);
        if(curl_error($ch)){
            $response =curl_error($ch);
        }

        curl_close($ch);

        return $response;
    }


    public function broadcasttoapp( $title,$message,$type=null,$data=array(),$largimg='',$bigimg=''){
        $appid="7552392c-4d7d-4e4d-a672-56509c316478";
        $authorization="YmMxOTU4YTktZDAxMC00YzAxLWIyYjktYjQwZmQyYjI3NTE4";
        $content = array(
            "en" => $message
        );

        $fields = array(
            'app_id' => $appid,
            // 'included_segments' => array('All'),
            'included_segments' => array('Hewale_patient_app'),
            'android_group' => '',
            'data' => array("type" => $type,
                "data"=>$data),
            'contents' => $content,
            'headings'=>array(
                "en" => $title
            ),
            'small_icon'=> 'http://hewale.net/media/img/favicon.png',
            'large_icon'=> (($largimg)? $largimg :'http://hewale.net/media/img/report-logo.png'),
            'big_picture'=>'http://hewale.net/media/img/'.$bigimg
        );

        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
            'Authorization: Basic '.$authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $response = curl_exec($ch);
        if(curl_error($ch)){
            $response =curl_error($ch);
        }

        curl_close($ch);

        return $response;
    }

    public function broadcasttest( $title,$message,$type=null,$data=array(),$largimg='',$bigimg=''){
        $appid="7552392c-4d7d-4e4d-a672-56509c316478";
        $authorization="YmMxOTU4YTktZDAxMC00YzAxLWIyYjktYjQwZmQyYjI3NTE4";
        $content = array(
            "en" => $message
        );

        $fields = array(
            'app_id' => $appid,
            // 'included_segments' => array('All'),
            'included_segments' => array('test'),
            'android_group' => '',
            'data' => array("type" => $type,
                "data"=>$data),
            'contents' => $content,
            'headings'=>array(
                "en" => $title
            ),
            'small_icon'=> 'http://hewale.net/media/img/favicon.png',
            'large_icon'=> (($largimg)? $largimg :'http://hewale.net/media/img/report-logo.png'),
            'big_picture'=>'http://hewale.net/media/img/'.$bigimg
        );

        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
            'Authorization: Basic '.$authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $response = curl_exec($ch);
        if(curl_error($ch)){
            $response =curl_error($ch);
        }

        curl_close($ch);

        return $response;
    }

    /*
        * This function gets unread chat for doctors
        */
    public function getUnreadChat($doctorcode,$patientcode){
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT COUNT(CHT_VIEW_STATUS) CHT_UNREAD from hms_chatmarket WHERE CHT_VIEW_STATUS=".$this->sql->Param('a')." AND CHT_RECEIVER_CODE=".$this->sql->Param('b')." AND CHT_SENDER_CODE=".$this->sql->Param('c')." "),array('0',$doctorcode,$patientcode));
        print $this->sql->ErrorMsg();
        if ($stmt->RecordCount()>0){
            while ($obj=$stmt->FetchNextObject()){
                $data=$obj->CHT_UNREAD;
            }
            return $data;
        }else{
            return false;
        }
    }

    /*
     * This function gets unread chat for doctors
     */
    public function getUnreadConsChat($doctorcode,$patientcode){
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT COUNT(CH_VIEW_STATUS) CH_UNREAD FROM hms_chat WHERE CH_VIEW_STATUS=".$this->sql->Param('a')." AND CH_RECEIVER_CODE=".$this->sql->Param('b')." AND CH_SENDER_CODE=".$this->sql->Param('c')." "),array('0',$doctorcode,$patientcode));
        print $this->sql->ErrorMsg();
        if ($stmt->RecordCount()>0){
            while ($obj=$stmt->FetchNextObject()){
                $data=$obj->CH_UNREAD;
            }
            return $data;
        }else{
            return false;
        }
    }

    /*
     * This function return message defined in the
     * notification table for push output
     * Author: Acker
     */
    public function getPushMessage($code){
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT NOTIF_MESSAGE FROM hms_notification_type WHERE NOTIF_CODE = ".$this->sql->Param('a')." "),array($code));
        print $this->sql->ErrorMsg();
        if($stmt->RecordCount() > 0){
            $obj = $stmt->FetchNextObject();
            return $obj->NOTIF_MESSAGE ;
        }else{
            return false;
        }
    }
    /*
     * This function returns percentage charged for doctor in quick consult
     */
    public function getQuickConsultPercentage($doctorcode){
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT MP_QUICKPERCENT_DOC FROM hmsb_med_prac WHERE MP_USRCODE =".$this->sql->Param(1)." LIMIT 1"),array($doctorcode));
        if ($stmt->RecordCount() >0){
            $obj=$stmt->FetchNextObject();
            $data = $obj->MP_QUICKPERCENT_DOC;
            return $data;
        }else{
            return false;
        }
    }


    /*
     * This function returns percentage charged for Facility
     */
    public function getFacilityPercentage($patientcode,$amount,$facilitycode){
        $obj = $this->getFacilityDetails();
        $facility_percentage = $obj->FACI_PERCENTAGE;
        $institution_percentage = $obj->FACI_INST_PERCENTAGE;
        //  Calculation of Deductible Percentage
        $institution_amount = ($institution_percentage/100) * $amount;
        $facility_amount = $amount - $institution_amount;
        //  Query
//        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT WAL_CODE,WAL_HOLD_AMT,WAL_PATIENTCODE,WAL_SERV_PROVIDERCODE,WAL_STATUS FROM hms_wallet_trans_holder WHERE WAL_PATIENTCODE=".$this->sql->Param('a')." AND WAL_SERV_PROVIDERCODE=".$this->sql->Param('b')." AND WAL_STATUS=".$this->sql->Param('c')),array($patientcode,$facilitycode,'0'));
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT WAL_CODE,WAL_HOLD_AMT,WAL_PATIENTCODE,WAL_SERV_PROVIDERCODE,WAL_STATUS FROM hms_wallet_trans_holder WHERE WAL_PATIENTCODE=".$this->sql->Param('a')." AND WAL_SERV_PROVIDERCODE=".$this->sql->Param('b')." AND WAL_HOLD_AMT >".$this->sql->Param('c')),array($patientcode,$facilitycode,'0'));
        if ($stmt->RecordCount()>0){
            $wallet = $stmt->FetchNextObject();

            $update_facility_wallet = $this->sql->Execute($this->sql->Prepare("UPDATE hms_wallets SET HRMSWAL_BALANCE = HRMSWAL_BALANCE + ".$this->sql->Param('a').",HRMSWAL_INST_BALANCE = HRMSWAL_INST_BALANCE + ".$this->sql->Param('a')." WHERE HRMSWAL_USERCODE=".$this->sql->Param('a')),array($facility_amount,$institution_amount,$facilitycode));
            print $this->sql->ErrorMsg();

            $update_wallet_holder = $this->sql->Execute($this->sql->Prepare("UPDATE hms_wallet_trans_holder SET WAL_HOLD_AMT = WAL_HOLD_AMT - ".$this->sql->Param('a').", WAL_STATUS=".$this->sql->Param('b')." WHERE WAL_PATIENTCODE=".$this->sql->Param('c')." AND WAL_SERV_PROVIDERCODE=".$this->sql->Param('d')),array($amount,'1',$patientcode,$facilitycode));
            print $this->sql->ErrorMsg();

            // SET EVENT LOG
            $event_type = '107';
            $activity = 'An amout of GHS'.$facility_amount.' has been transferred to Facility with code '.$facilitycode.' as payment for Lab. Test.';
            $this->setEventLog($event_type,$activity);

            //  SEND NOTIFICATION TO FACILITY
            $code = '034';
            $description = 'You have received an amount of GHS'.$facility_amount.' as payment for Patient with Code '.$patientcode.' Lab. Test';
            $menudetailscode = '00121';
            $tablerowid = '';
            $faccodeout = '';
            $this->setNotification($code,$description,$menudetailscode,$tablerowid,$facilitycode,'');
        }

//	    return $facility_percentage;
    }



    /*
     * This function brings a list of patients a doctor has had a chat with
     */
    public function getDoctorChatPaddies($patientcode,$search=NULL){
        //if a search pattern is given
        if (!empty($search)){
            $stmt =$this->sql->Execute($this->sql->Prepare("SELECT PATIENT_PATIENTCODE,PATIENT_PATIENTNUM,CONCAT(PATIENT_FNAME,' ',PATIENT_LNAME) PATIENT_FULLNAME,PATIENT_GENDER,TIMESTAMPDIFF(YEAR,PATIENT_DOB,NOW()) AS PATIENT_AGE FROM hms_patient WHERE PATIENT_PATIENTCODE =".$this->sql->Param('a')." AND (PATIENT_FNAME LIKE ".$this->sql->Param('b')." OR PATIENT_MNAME LIKE ".$this->sql->Param('c')." OR PATIENT_LNAME LIKE ".$this->sql->Param('c')." OR PATIENT_PATIENTNUM LIKE ".$this->sql->Param('c').") "),array($patientcode,'%'.$search.'%',$search.'%','%'.$search.'%',$search.'%'));
            if ($stmt->RecordCount() >0){
                while ($obj =$stmt->FetchNextObject()){
                    $datarray[$patientcode]=array('PATIENT_PATIENTCODE'=>$obj->PATIENT_PATIENTCODE,'PATIENT_PATIENTNUM'=>$obj->PATIENT_PATIENTNUM,'PATIENT_FULLNAME'=>$obj->PATIENT_FULLNAME,'PATIENT_GENDER'=>$obj->PATIENT_GENDER,'PATIENT_AGE'=>$obj->PATIENT_AGE);
                }
                return $datarray;
            }else{
                return false;
            }
        }
        // if a search pattern isn't given
        else{
            $stmt =$this->sql->Execute($this->sql->Prepare("SELECT PATIENT_PATIENTCODE,PATIENT_PATIENTNUM,CONCAT(PATIENT_FNAME,' ',PATIENT_LNAME) PATIENT_FULLNAME,PATIENT_GENDER,TIMESTAMPDIFF(YEAR,PATIENT_DOB,NOW()) AS PATIENT_AGE FROM hms_patient WHERE PATIENT_PATIENTCODE =".$this->sql->Param('a')." "),array($patientcode));
            if ($stmt->RecordCount() >0){
                while ($obj =$stmt->FetchNextObject()){
                    $datarray[$patientcode]=array('PATIENT_PATIENTCODE'=>$obj->PATIENT_PATIENTCODE,'PATIENT_PATIENTNUM'=>$obj->PATIENT_PATIENTNUM,'PATIENT_GENDER'=>$obj->PATIENT_GENDER,'PATIENT_FULLNAME'=>$obj->PATIENT_FULLNAME,'PATIENT_AGE'=>$obj->PATIENT_AGE);
                }
                return $datarray;
            }else{
                return false;
            }
        }
    }

    public function getdrugCode(){
        $items= 'PS';
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT ST_CODE FROM hms_pharmacystock WHERE ST_CODE LIKE ".$this->sql->Param('a')." ORDER BY ST_ID DESC LIMIT 1 "),array('PS%'));
        print $this->sql->ErrorMsg();
        if($stmt->RecordCount() > 0){
            $obj = $stmt->FetchNextObject();
            $order = substr($obj->ST_CODE,2,10000);
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

    public function pharmacysaleCode(){
        $facdetails = $this->getFacilityDetails();
        $items= 'SAL';
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT SAL_CODE FROM hms_pharmacysales WHERE SAL_FACICODE=".$this->sql->Param('a')." ORDER BY SAL_ID DESC LIMIT 1 "),array($facdetails->FACI_CODE));
        print $this->sql->ErrorMsg();
        if($stmt->RecordCount() > 0){
            $obj = $stmt->FetchNextObject();
            $order = substr($obj->SAL_CODE,5,10000000);
            $order = $order + 1;
            if(strlen($order) == 1){
                $orderno = $items.'000000'.$order;
            }else if(strlen($order) == 2){
                $orderno = $items.'00000'.$order;
            }else if(strlen($order) == 3){
                $orderno = $items.'0000'.$order;
            }else if(strlen($order) == 4){
                $orderno = $items.'000'.$order;
            }else if(strlen($order) == 5){
                $orderno = $items.'00'.$order;
            }else if(strlen($order) == 6){
                $orderno = $items.'0'.$order;
            }else if(strlen($order) == 7){
                $orderno = $items.$order;
            }else{
                $orderno = $items.$order;
            }
        }else{
            $orderno = $items.'0000001';
        }
        return $orderno;
    }



    //this function distributes money to pharmacy and courier
    public function patienttopharmacyprice($patientcode,$amount,$facilitycode,$visitcode,$couriercode=NULL,$courieramount=NULL){
        $transactioncode=$this->getTransCode();
        // if no courier is selected
        if ($couriercode==NULL){
            //	echo "BONGIIIIIIIIIIIIIIIIIIIIIIIIII"; die();
            $obj = $this->getFacilityDetails();
            $facility_percentage = $obj->FACI_PERCENTAGE;
            $institution_percentage = $obj->FACI_INST_PERCENTAGE;
            //  Calculation of Deductible Percentage
            $institution_amount = ($institution_percentage/100) * $amount;
            $facility_amount = $amount - $institution_amount;
            $stmt = $this->sql->Execute($this->sql->Prepare("SELECT WAL_CODE,WAL_HOLD_AMT,WAL_PATIENTCODE,WAL_SERV_PROVIDERCODE,WAL_STATUS FROM hms_wallet_trans_holder WHERE WAL_PATIENTCODE=".$this->sql->Param('a')." AND WAL_PATIENT_VISITCODE=".$this->sql->Param('d')." AND WAL_SERV_PROVIDERCODE=".$this->sql->Param('b')." AND WAL_HOLD_AMT >".$this->sql->Param('c')),array($patientcode,$visitcode,$facilitycode,'0'));
            if ($stmt->RecordCount()>0){
                $wallet = $stmt->FetchNextObject();
                //add to the pharmacy wallet
                $update_facility_wallet = $this->sql->Execute($this->sql->Prepare("UPDATE hms_wallets SET HRMSWAL_BALANCE = HRMSWAL_BALANCE + ".$this->sql->Param('a').",HRMSWAL_INST_BALANCE = HRMSWAL_INST_BALANCE + ".$this->sql->Param('a')." WHERE HRMSWAL_USERCODE=".$this->sql->Param('a')),array($facility_amount,$institution_amount,$facilitycode));
                print $this->sql->ErrorMsg();
                $update_wallet_holder = $this->sql->Execute($this->sql->Prepare("UPDATE hms_wallet_trans_holder SET WAL_HOLD_AMT = WAL_HOLD_AMT - ".$this->sql->Param('a').", WAL_STATUS=".$this->sql->Param('b')." WHERE WAL_PATIENTCODE=".$this->sql->Param('c')." AND WAL_SERV_PROVIDERCODE=".$this->sql->Param('d')." AND WAL_PATIENT_VISITCODE=".$this->sql->Param('e')." "),array($amount,'1',$patientcode,$facilitycode,$visitcode));
                print $this->sql->ErrorMsg();
                // SET EVENT LOG
                $event_type = '107';
                $activity = 'An amount of GHS'.$facility_amount.' has been transferred to Facility with code '.$facilitycode.' as payment drugs .';
                $this->setEventLog($event_type,$activity);
                //SELECT THE WALLET CODE BASED ON FACILITY CODE
                $stmt_code= $this->sql->Execute($this->sql->Prepare("SELECT HRMSWAL_CODE from hms_wallets WHERE HRMSWAL_USERCODE=".$this->sql->Param('a')." LIMIT 1"),array($patientcode));
                if($stmt_code->RecordCount()>0){
                    $objcode=$stmt_code->FetchNextObject();
                    $wallcode=$objcode->HRMSWAL_CODE;
                }else{
                    $wallcode='';
                }
                //UPDATE wallet transactions table
                $this->sql->Execute($this->sql->Prepare("INSERT INTO hms_wallet_transaction(HRMSTRANS_CODE, HRMSTRANS_WALCODE, HRMSTRANS_USERCODE, HRMSTRANS_USERTYPE, HRMSTRANS_AMOUNT, HRMSTRANS_DATE, HRMSTRANS_RECEIVER, HRMSTRANS_STATUS, HRMSTRANS_TYPE, HRMSTRANS_DESCRIPTION) VALUES
            (".$this->sql->Param('a').",".$this->sql->Param('b').",".$this->sql->Param('c').",".$this->sql->Param('d').",".$this->sql->Param('e').",".$this->sql->Param('f').",".$this->sql->Param('g').",".$this->sql->Param('h').",".$this->sql->Param('i').",".$this->sql->Param('j')." )"),
                    array($transactioncode,$wallcode,$patientcode,'4',$facility_amount,date('Y-m-d'),$facilitycode,'1','3',$activity));


                //  SEND NOTIFICATION TO FACILITY
                $code = '034';
                $description = 'You have received an amount of GHS'.$facility_amount.' as payment for Patient with Code '.$patientcode.' Drugs';
                $menudetailscode = '00121';
                $tablerowid = '';
                $faccodeout = '';
                $this->setNotification($code,$description,$menudetailscode,$tablerowid,$facilitycode,'');
            }

//	    return $facility_percentage;


        }



        //if a courier is selected
        else{

            $obj = $this->getFacilityDetails();
            $facility_percentage = $obj->FACI_PERCENTAGE;
            $institution_percentage = $obj->FACI_INST_PERCENTAGE;
            //  Calculation of Deductible Percentage for pharmacy
            $institution_amount = ($institution_percentage/100) * $amount; // FOR OROCNS
            $facility_amount = $amount - $institution_amount; // FOR PHARMACY
            //  Calculation of Deductible Percentage for courier
            /**    $stmtcourier= $this->sql->Execute($this->sql->Prepare("SELECT FACI_PERCENTAGE FROM hmsb_allfacilities WHERE FACI_CODE=".$this->sql->Param('a')." "),array($couriercode));
            if ($stmtcourier->Recordcount()>0 ){
            $courobj = $stmtcourier->FetchNextObject();
            $courpercent =$courobj->FACI_PERCENTAGE;
            $courpercent = ($courpercent/100) * $courieramount;
            $inst_courpercent= $courieramount - $courpercent;
            }**/
            $stmt = $this->sql->Execute($this->sql->Prepare("SELECT PCP_WAL_CODE,PCP_PHARM_AMT,PCP_PATIENTCODE,PCP_PATIENT_VISITCODE,PCP_PHARM_CODE,PCP_COURIER_CODE,PCP_PHARM_AMT,PCP_COURIER_AMT FROM hms_pharm_courier_price WHERE PCP_PATIENTCODE=".$this->sql->Param('a')." AND PCP_PHARM_CODE=".$this->sql->Param('b')." AND PCP_COURIER_CODE =".$this->sql->Param('c')." AND PCP_STATUS=".$this->sql->Param('d')." AND PCP_PATIENT_VISITCODE =".$this->sql->Param('e')." " ),array($patientcode,$facilitycode,$couriercode,'0',$visitcode));
            //  echo $patientcode.'--'.$facilitycode.'--'.$couriercode.'--'.$visitcode;echo "BINGOOOOOOOOOOOOOOOOOOOOO";
            if ($stmt->RecordCount()>0){
                $wallet = $stmt->FetchNextObject();
                //add to the pharmacy wallet

                //    echo '<br>';
                //   echo $facility_amount.'--'.$institution_amount.'--'.$facilitycode;echo '<br>';
                //   echo $courpercent.'--'.$inst_courpercent.'--'.$couriercode; die();
                $update_facility_wallet = $this->sql->Execute($this->sql->Prepare("UPDATE hms_wallets SET HRMSWAL_BALANCE = HRMSWAL_BALANCE + ".$this->sql->Param('a').",HRMSWAL_INST_BALANCE = HRMSWAL_INST_BALANCE + ".$this->sql->Param('a')." WHERE HRMSWAL_USERCODE=".$this->sql->Param('a')),array($facility_amount,$institution_amount,$facilitycode));
                print $this->sql->ErrorMsg();
                //add to the courier wallet
                /**	$update_facility_wallet = $this->sql->Execute($this->sql->Prepare("UPDATE hms_wallets SET HRMSWAL_BALANCE = HRMSWAL_BALANCE + ".$this->sql->Param('a').",HRMSWAL_INST_BALANCE = HRMSWAL_INST_BALANCE + ".$this->sql->Param('a')." WHERE HRMSWAL_USERCODE=".$this->sql->Param('a')),array($courpercent,$inst_courpercent,$couriercode));
                print $this->sql->ErrorMsg();**/
                //set the pending table value to done
                $update_wallet_holder = $this->sql->Execute($this->sql->Prepare("UPDATE hms_pharm_courier_price SET PCP_STATUS=".$this->sql->Param('b')." WHERE PCP_PATIENTCODE=".$this->sql->Param('c')." AND PCP_PHARM_CODE=".$this->sql->Param('d')." AND PCP_COURIER_CODE=".$this->sql->Param('d')." AND PCP_PATIENT_VISITCODE=".$this->sql->Param('e')." "),array('1',$patientcode,$facilitycode,$couriercode,$visitcode));
                print $this->sql->ErrorMsg();
                $update_wallet_holder_update = $this->sql->Execute($this->sql->Prepare("UPDATE hms_wallet_trans_holder SET WAL_STATUS=".$this->sql->Param('b')." WHERE WAL_PATIENTCODE=".$this->sql->Param('c')." AND WAL_SERV_PROVIDERCODE=".$this->sql->Param('d')." AND WAL_PATIENT_VISITCODE=".$this->sql->Param('e')." "),array('1',$patientcode,$facilitycode,$visitcode));
                print $this->sql->ErrorMsg();

                // SET EVENT LOG
                $event_type = '107';
                $activity = 'An amout of GHS'.$facility_amount.' has been transferred to Facility with code '.$facilitycode.' as payment for Hewale drugs.';
                $this->setEventLog($event_type,$activity);
                //SELECT THE WALLET CODE BASED ON FACILITY CODE
                $stmt_code= $sql->Execute($sql->Prepare("SELECT HRMSWAL_CODE from hms_wallets WHERE HRMSWAL_USERCODE=".$this->sql->Param('a')." LIMIT 1"),array($patientcode));
                if($stmt_code->RecordCount()>0){
                    $objcode=$stmt_code->FetchNextObject();
                    $wallcode=$objcode->HRMSWAL_CODE;
                }else{
                    $wallcode='';
                }
                $sql->Execute($sql->Prepare("INSERT INTO hms_wallet_transaction(HRMSTRANS_CODE, HRMSTRANS_WALCODE, HRMSTRANS_USERCODE, HRMSTRANS_USERTYPE, HRMSTRANS_AMOUNT, HRMSTRANS_DATE, HRMSTRANS_RECEIVER, HRMSTRANS_STATUS, HRMSTRANS_TYPE, HRMSTRANS_DESCRIPTION) VALUES
            (".$this->sql->Param('a').",".$this->sql->Param('b').",".$this->sql->Param('c').",".$this->sql->Param('d').",".$this->sql->Param('e').",".$this->sql->Param('f').",".$this->sql->Param('g').",".$this->sql->Param('h').",".$this->sql->Param('i').",".$this->sql->Param('j')." )"),
                    array($transactioncode,$wallcode,$patientcode,'4',$facility_amount,date('Y-m-d'),$facilitycode,'1','3',$activity));
                //  SEND NOTIFICATION TO FACILITY
                $code = '034';
                $description = 'You have received an amount of GHS'.$facility_amount.' as payment for Patient with Code '.$patientcode.' Hewale drugs';
                $menudetailscode = '00121';
                $tablerowid = '';
                $faccodeout = '';
                $this->setNotification($code,$description,$menudetailscode,$tablerowid,$facilitycode,'');
            }

//	    return $facility_percentage;



        }

    }
    #end of function for patienttopharmacy
    #begin function for patienttocourierprice
    public function patienttocourierprice($patientcode,$amount,$facilitycode,$visitcode) {
        //	echo "BOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOM"; die();
        $obj = $this->getFacilityDetails();
        $facility_percentage = $obj->FACI_PERCENTAGE;
        $institution_percentage = $obj->FACI_INST_PERCENTAGE;
        $stmtcourier= $this->sql->Execute($this->sql->Prepare("SELECT FACI_PERCENTAGE FROM hmsb_allfacilities WHERE FACI_CODE=".$this->sql->Param('a')." "),array($facilitycode));
        if ($stmtcourier->Recordcount()>0 ){
            $courobj = $stmtcourier->FetchNextObject();
            $courpercent =$courobj->FACI_PERCENTAGE;
            $courpercent = ($courpercent/100) * $amount;
            $inst_courpercent= $amount - $courpercent;
        }
        //add to the courier wallet
        $update_facility_wallet = $this->sql->Execute($this->sql->Prepare("UPDATE hms_wallets SET HRMSWAL_BALANCE = HRMSWAL_BALANCE + ".$this->sql->Param('a').",HRMSWAL_INST_BALANCE = HRMSWAL_INST_BALANCE + ".$this->sql->Param('a')." WHERE HRMSWAL_USERCODE=".$this->sql->Param('a')),array($courpercent,$inst_courpercent,$facilitycode));
        print $this->sql->ErrorMsg();
        // SET EVENT LOG
        $event_type = '107';
        $activity = 'An amout of GHS'.$amount.' has been transferred to Facility with code '.$facilitycode.' as payment for Hewale drugs.';
        $this->setEventLog($event_type,$activity);

        //  SEND NOTIFICATION TO FACILITY
        $code = '034';
        $description = 'You have received an amount of GHS'.$amount.' as payment for Patient with Code '.$patientcode.' Hewale drugs';
        $menudetailscode = '00121';
        $tablerowid = '';
        $faccodeout = '';
        $this->setNotification($code,$description,$menudetailscode,$tablerowid,$facilitycode,'');

    }

/*
 * Get all users from a specific  facility
 * Param:: @facicode
 */
    public function getUserFaciDetails($facicode){
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_users WHERE USR_FACICODE = ".$this->sql->Param('a')." "),array($facicode));
        print $this->sql->ErrorMsg();

        if($stmt){
            if($stmt->RecordCount() > 0)
            {
                return $stmt;
            }
        }else{return false;}

    } //End service details

//Get transaction code for wallet
    public function getTransCode(){
        $items= 'WT'.date('y');
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT HRMSTRANS_CODE FROM hms_wallet_transaction ORDER BY HRMSTRANS_ID DESC LIMIT 1 "));
        print $this->sql->ErrorMsg();
        if($stmt->RecordCount() > 0){
            $obj = $stmt->FetchNextObject();
            $order = substr($obj->HRMSTRANS_CODE,5,10000000);
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


    public function getserviceprice($servicecode,$faccode,$paschcode){
        $stmtr = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hms_st_pricing WHERE PS_ITEMCODE = ".$this->sql->Param('a')."   and PS_PAYSCHEME = ".$this->sql->Param('a')."  and PS_FACICODE = ".$this->sql->Param('a').""),array($servicecode,$paschcode,$faccode));
        print $this->sql->ErrorMsg();
        if($stmtr->RecordCount() > 0){
            $pprice = $stmtr->FetchNextObject();
            $priamt = $pprice->PS_PRICE;

        }else{

            return 0;
        }
    }

    public function getVitalsCode(){
        $items= 'VIT';
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT VITALS_CODE FROM hms_vitals ORDER BY VITALS_ID DESC LIMIT 1 "));
        print $this->sql->ErrorMsg();
        if($stmt->RecordCount() > 0){
            $obj = $stmt->FetchNextObject();
            $order = substr($obj->VITALS_CODE,5,10000000);
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


    //CODE CLASS FOR BROADCAST
// get nursenote code
    public function getPendingCode(){
        $items= 'PEND';
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT PEND_CODE FROM hms_pending_prescription ORDER BY PEND_ID DESC LIMIT 1 "));
        print $this->sql->ErrorMsg();
        if($stmt->RecordCount() > 0){
            $obj = $stmt->FetchNextObject();
            $order = substr($obj->PEND_CODE,5,10000000);
            $order = $order + 1;
            if(strlen($order) == 1){
                $orderno = $items.'000000'.$order;
            }else if(strlen($order) == 2){
                $orderno = $items.'00000'.$order;
            }else if(strlen($order) == 3){
                $orderno = $items.'0000'.$order;
            }else if(strlen($order) == 4){
                $orderno = $items.'000'.$order;
            }else if(strlen($order) == 5){
                $orderno = $items.'00'.$order;
            }else if(strlen($order) == 6){
                $orderno = $items.'0'.$order;
            }else if(strlen($order) == 7){
                $orderno = $items.$order;
            }else{
                $orderno = $items.$order;
            }
        }else{
            $orderno = $items.'0000001';
        }
        return $orderno;
    }


    /*
     * This function calculates a persons age given the the date of birth
     * @Param:  $userDob
     */
    public function calculateAge($userDob){
        //Create a DateTime object using the user's date of birth.
        $dob = new DateTime($userDob);

        //We need to compare the user's date of birth with today's date.
        $now = new DateTime();

        //Calculate the time difference between the two dates.
        $difference = $now->diff($dob);

        //Get the difference in years, as we are looking for the user's age.
        $age = $difference->y;

        return $age;
    }


    /*
   * This function generates the code for pending prescription
   */
    public function getBroadcastPrescriptionCode(){
        $items= 'BPC'.date('y');
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT BRO_CODE FROM hms_broadcast_prescription ORDER BY BRO_ID DESC LIMIT 1 "));
        print $this->sql->ErrorMsg();
        if($stmt->RecordCount() > 0){
            $obj = $stmt->FetchNextObject();
            $order = substr($obj->BRO_CODE,6,10000000);
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


    /*public function notify($appid,$contents,$playerid,$type){
        $data = array(
            'app_id' => $appid,
            'contents' => array('en' => $contents),
            // 'included_segments' => ['All']
            'include_player_ids'=>array($playerid),
            'data'=>array('type'=>$type)
        );
        $data_string = json_encode($data);
        $ch = curl_init('https://onesignal.com/api/v1/notifications');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Authorization: Basic YmMxOTU4YTktZDAxMC00YzAxLWIyYjktYjQwZmQyYjI3NTE4' )
        );
        $result = json_decode(curl_exec($ch));
        if(curl_error($ch)){
            $result=curl_error($ch);
        }
        //$this->response(array('data'=>$result),200);
    }*/


    public function notify( $title,$message,$playerid,$type,$data=array(),$largimg='',$bigimg=''){
        $appid="7552392c-4d7d-4e4d-a672-56509c316478";
        $authorization="YmMxOTU4YTktZDAxMC00YzAxLWIyYjktYjQwZmQyYjI3NTE4";
        $content = array(
            "en" => $message
            );

        $fields = array(
            'app_id' => $appid,
           // 'included_segments' => array('All'),
            'include_player_ids' => array($playerid),//array("6392d91a-b206-4b7b-a620-cd68e32c3a76","76ece62b-bcfe-468c-8a78-839aeaa8c5fa","8e0f21fa-9a5a-4ae7-a9a6-ca1f24294b86"),
      'data' => array("type" => $type,
                        "data"=>$data),
            'contents' => $content,
            'headings'=>array(
            "en" => $title
            ),
            'small_icon'=> 'https://hewale.net/socialhealth/media/img/favicon.png',
            'large_icon'=> (($largimg)? $largimg :'https://hewale.net/socialhealth/media/img/report-logo.png'),
            'big_picture'=>'https://hewale.net/socialhealth/media/img/'.$bigimg
        );

        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                   'Authorization: Basic '.$authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $response = curl_exec($ch);
        if(curl_error($ch)){
            $response =curl_error($ch);
        }

        curl_close($ch);

        return $response;
    }



    /*
 * This function is to generates the notification
 * for the various aspects of the systems.
 */
    public function setNotificationLikePhone($actorcode,$code,$desc,$menudetailscode,$tablerowid,$sentto="",$faccodein=""){
        //Active user
        $actualdate = date("Y-m-d h:m:s");

        $faccode = 'H0001';

        if($faccode != 'H0001' &&  $code != '032'){
            $faccodein = $faccode;
        }

        $stmt = $this->sql->Execute("INSERT INTO hms_notification_details(NOTIFD_NOTIFCODE,NOTIFD_DESCRIPTION,NOTIFD_SENTBY,NOTIFD_SENTTO,NOTIFD_FACCODE_OUT,NOTIFD_FACCODE_IN,NOTIFD_SENTDATE,NOTIFD_MENUDETCODE,NOTIFD_TABLEROWID) VALUES(".$this->sql->Param('a').",".$this->sql->Param('b').",".$this->sql->Param('c').",".$this->sql->Param('d').",".$this->sql->Param('e').",".$this->sql->Param('f').",".$this->sql->Param('g').",".$this->sql->Param('g').",".$this->sql->Param('h').") ",array($code,$desc,$actorcode,$sentto,$faccode,$faccodein,$actualdate,$menudetailscode,$tablerowid));
        print $this->sql->ErrorMsg();
    }


    public function getcountryphoneprefix($cccode){
        $stmt = $this->sql->Prepare("SELECT CN_PHONEPREFIX FROM hmsb_countries_nationalities WHERE CN_ID = ".$this->sql->Param('a'));
        $stmt = $this->sql->Execute($stmt,array($cccode));
        if($stmt && ($stmt->RecordCount() > 0)){
            $obj = $stmt->FetchNextObject();
            return $obj->CN_PHONEPREFIX;
        }else{
            print $this->sql->ErrorMsg();
            return false;
        }
    }


    /*
     *  Get dosage name from drug table
     */
    public function getDrugDosageName($drugcode){
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hmsb_st_phdrugs WHERE DR_CODE = ".$this->sql->Param('a')." "),array($drugcode));
        print $this->sql->ErrorMsg();
        if($stmt->RecordCount() > 0){
            $obj = $stmt->FetchNextObject();
            return  $obj->DR_DOSAGENAME ;
        }else{
            return false;
        }
    }


    /*
      * This function generates the symptoms code
      */
    public function getsymptomCode(){
        $items= 'SY';
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT SY_CODE FROM hmsb_st_symtoms ORDER BY SY_ID DESC LIMIT 1"));
        print $this->sql->ErrorMsg();
        if($stmt->RecordCount() > 0){
            $obj = $stmt->FetchNextObject();
            $order = substr($obj->SY_CODE,2,10000);
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
     * This function gets the telephone number of a facility
     * 
     */
public function faciPhoneNum($faccode){
 $stmt= $this->sql->Execute($this->sql->Prepare("SELECT FACI_PHONENUM from hmsb_allfacilities WHERE FACI_CODE=".$this->sql->Param('a').""),array($faccode));
 if ($stmt->RecordCount()>0){
 $obj=$stmt->FetchNextObject();
 return $obj->FACI_PHONENUM;
 }else{
 return 'N/A';
 }
 }


 /*
 * Get facility details from a specific user
 * Param:: @facicode
 */
public function getUserFacility($usrcode){
    $stmt = $this->sql->Execute($this->sql->Prepare("SELECT FACI_CODE,FACI_NAME,FACI_PHONENUM FROM hms_users JOIN hmsb_allfacilities ON USR_FACICODE = FACI_CODE WHERE USR_CODE = ".$this->sql->Param('a')." "),array($usrcode));
    print $this->sql->ErrorMsg();

    if($stmt){
        if($stmt->RecordCount() > 0)
        {
            return $stmt->FetchNextObject();
        }
    }else{return false;}

} //End service details
 
 
/**
 *  This code helps to generate the conference code
 */
public function getconferenceCode(){
    $items= 'CF'.date('y');
    $stmt = $this->sql->Execute($this->sql->Prepare("SELECT CONF_CODE FROM hms_conference_room ORDER BY CONF_ID DESC LIMIT 1 "));
    print $this->sql->ErrorMsg();
    if($stmt->RecordCount() > 0){
        $obj = $stmt->FetchNextObject();
        $order = substr($obj->CONF_CODE,5,10000000);
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
//End generating conference code

/*
 * Get virtual hospital assigned to a doctor
 * Param:: @usrcode
 */
public function getDoctorVirtualHospitals($usrcode){
    $stmt = $this->sql->Execute($this->sql->Prepare("SELECT * FROM hmsb_chps_doctors_assignments WHERE CDA_DOCTOR_USRCODE = ".$this->sql->Param('a')." "),array($usrcode));
    print $this->sql->ErrorMsg();

    if($stmt){
        return $stmt;
    }else{return false;}

} //End VH details


/*
 * Get Number of pending patient per virtual hospital
 * Param:: @facicode
 */
public function getTotalPendingPatientVH($facicode){
    $stmt = $this->sql->Execute($this->sql->Prepare("SELECT COUNT(*) AS TOTALPATIENT FROM hms_consultation WHERE CONS_FACICODE = ".$this->sql->Param('a')." AND CONS_STATUS = '1' "),array($facicode));
    print $this->sql->ErrorMsg();

    if($stmt){
        $obj = $stmt->FetchNextObject();
        return  $obj->TOTALPATIENT;
    }else{return false;}

} //End VH details


    /*
     * This function gets the labtest price for a facility
     * @param:  facilitycode, paymentmethodcode
     */
    public function getLabTestPrice($testcode, $facilitycode, $paymentmethodcode, $paymentmethod){
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT LL_PRICE FROM hms_lab_testprice WHERE LL_FACICODE = ".$this->sql->Param('a')." AND LL_TESTCODE = ".$this->sql->Param('a')." AND (LL_METHODCODE = ".$this->sql->Param('a')." OR LL_METHOD = ".$this->sql->Param('a').") AND LL_STATUS = '1' "),array($facilitycode, $testcode, $paymentmethodcode, $paymentmethod));
        print $this->sql->ErrorMsg();
        if($stmt){
            $obj = $stmt->FetchNextObject();
            return  $obj->LL_PRICE;
        }else{
            return false;
        }
    }


    /*
     * This function gets the xraytest price for a facility
     * @param:  facilitycode, paymentmethodcode
     */
    public function getXrayTestPrice($testcode, $facilitycode, $paymentmethodcode, $paymentmethod){
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT XP_PRICE FROM hms_xray_testprice WHERE XP_FACICODE = ".$this->sql->Param('a')." AND XP_TESTCODE = ".$this->sql->Param('a')." AND (XP_METHODCODE = ".$this->sql->Param('a')." OR XP_METHOD = ".$this->sql->Param('a').") AND XP_STATUS = '1' "),array($facilitycode, $testcode, $paymentmethodcode, $paymentmethod));
        print $this->sql->ErrorMsg();
        if($stmt){
            $obj = $stmt->FetchNextObject();
            return  $obj->LL_PRICE;
        }else{
            return false;
        }
    }


    /*
     * This function gets the prescription price for a facility
     * @param:  facilitycode, paymentmethodcode
     */
    public function getPrescriptionPrice($drugcode, $facilitycode = 'H002', $paymentmethodcode, $paymentmethod){
        $stmt = $this->sql->Execute($this->sql->Prepare("SELECT PPR_PRICE FROM hms_pharmacyprice WHERE PPR_FACICODE = ".$this->sql->Param('a')." AND PPR_DRUGCODE = ".$this->sql->Param('a')." AND (PPR_METHODCODE = ".$this->sql->Param('a')." OR PPR_METHOD = ".$this->sql->Param('a').") AND PPR_STATUS = '1' "),array('H002', $drugcode, $paymentmethodcode, $paymentmethod));
        print $this->sql->ErrorMsg();
        if($stmt){
            $obj = $stmt->FetchNextObject();
            return  $obj->PPR_PRICE;
        }else{
            return false;
        }
    }

    /*
     * This code below generate an item code for each of the 
     * prescription, lab test, xray and so forth generated
     */
    public function getItemCode($patientnum){
      $frat = strtoupper(substr($patientnum,0,2)).rand(10,99);
      $year = date('y');
      $a = substr($frat,0,1);
      $b = substr($frat,1,1);
      $c = substr($frat,2,1);
      $d = substr($frat,3,1);
      $str = $a.' '.$b.' '.$c.' '.$d;
      $com = explode(' ',$str);
      shuffle($com);
      $itemcode = implode('',$com).$year;
      
      //Check if value is unique in itemcode table
      $stmt = $this->sql->Execute($this->sql->Prepare("SELECT ITE_CODE FROM hms_itemcode WHERE ITE_CODE = ".$this->sql->Param('a')." "),array($itemcode));
      print $this->sql->ErrorMsg();
      if($stmt->RecordCount() == 1){
          $this->getItemCode($patientnum);
      }else{
       //Start Insertion into hms_itemcode
       $iteid = uniqid();
       $this->sql->Execute("INSERT INTO hms_itemcode(ITE_ID,ITE_CODE) VALUES(".$this->sql->Param('a').",".$this->sql->Param('b')." ) ",array($iteid,$itemcode));
        print $this->sql->ErrorMsg();

      return $itemcode;
      }


    }

public function setEventLog($eventcode, $eventdesc)
{
   //global $mongo;
   $usercode = $this->session->get("userid");
   $ufullname = $this->getActorName();
   $toinsetsession = $this->session->getSessionID();
   $ips = (isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : @$_SERVER['HTTP_X_FORWARDED_FOR'];
   $useragent = empty($_SERVER['HTTP_USER_AGENT'])? '': $_SERVER['HTTP_USER_AGENT'] ;
  // $raw = serialize($_SERVER);
   $rawpost = ($eventcode == '001') ? '' : serialize($_POST);
   //GET EVENT TYPE NAME
   $eventname = "";
   //$evobj = $this->mongo->GetOne("hms_eventtype", ["EVT_CODE" => $eventcode]);
   //print $this->mongo->ErrorMsg();
   if ($evobj) {
      $eventname = $evobj->EVT_NAME;
   }

   $input = [
      "EVL_EVTCODE" => $eventcode, 
      "EVL_EVT_NAME" => $eventname,
      "EVL_USERID" => $usercode,
      "EVL_FULLNAME" => $ufullname,
      "EVL_ACTIVITIES" => $eventdesc,
      "EVL_IP" => $ips,
      "EVL_SESSION_ID" => $toinsetsession,
      "EVL_BROWSER" => $useragent,
      "EVL_RAW" => $rawpost,
      "EVL_INPUTEDDATE" => date("Y-m-d H:i:s", time())
   ];
  
   //$this->mongo->InsertOne("hms_eventlog", $input);
   /*echo "<pre>";
   print_r($input);
   echo "<pre />";*/
   //print $this->mongo->ErrorMsg(); 
              
   return TRUE;
}

}

?>