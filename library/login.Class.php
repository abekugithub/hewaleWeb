<?php
/**
 * This class defines the login class and handles all ways for
 * institutions (Hosptial/ Labs / Pharmacies) logins.
 */
@define('USER_LOGIN_VAR',$uname);
@define('USER_PASSW_VAR',$pwd);
@define('USER_INST_VAR',$inst);
@define('USER_CAPTCHA_VAR',$captcha);
@define('USER_CAPTCHA_TXT',$txtcaptha);

class Login{
    private $session;
    private $redirect;
    private $hashkey;
    private $md5 = false;
    private $sha2 = false;
    private $remoteip;
    private $useragent;
    private $connect;
    private $crypt;
    private $jconfig;
    private $mongo;


    public function __construct(){
        global $sql,$session, $mongo;
        $this->redirect ="index.php?action=Login&inst=".USER_INST_VAR;
        $this->hashkey	=$_SERVER['HTTP_HOST'];
        $this->sha2=true;
        $this->remoteip = $_SERVER['HTTP_X_REAL_IP'];
        //$this->useragent = $_SERVER['HTTP_USER_AGENT'];
        $this->session	=$session;
        $this->connect = $sql;
        $this->crypt = new cryptCls();
        $this->sessionid = $this->session->getSessionID();
        $this->mongo = $mongo; 
        $this->signin();

    }

    private function signin(){

        
        if($this->session->get('hash_key'))
        {
            
            $this->confirmAuth();
            return;
        }

        if(!isset($_POST['doLogin'])){
          
            $this->logout();
        }

        if(USER_LOGIN_VAR=="" || USER_PASSW_VAR == ""){
            
            $this->logout("empty");
        }

      
        if(USER_CAPTCHA_TXT =="" ||($this->session->get('code') != USER_CAPTCHA_TXT)){
           
            $this->direct("captchax");

        }


        if($this->sha2){
            if(USER_INST_VAR != ""){
                $uname2 = USER_LOGIN_VAR.'@'.strtoupper(USER_INST_VAR);
                $passwrd = $this->crypt->loginPassword($uname2,USER_PASSW_VAR);
            }else{ 
                $passwrd = $this->crypt->loginPassword(USER_LOGIN_VAR,USER_PASSW_VAR);
                $uname2 = USER_LOGIN_VAR;
            }
        }

        //die($passwrd);
      

        $query = "SELECT USR_USERID,USR_STATUS,USR_FACICODE,USR_SESSION_STATE,USR_SESSION_DATETIME,USR_HOSPANNEXCODE,USR_TYPE,USR_SURNAME,USR_OTHERNAME,USR_LEVEL_FACLVID,USR_HOSPOSITION,FACI_TYPE,USR_CODE,USR_COUNTRYCODE FROM hms_users JOIN hmsb_allfacilities ON USR_FACICODE = FACI_CODE WHERE USR_STATUS='1' AND USR_DELETE_STATUS='0' AND USR_USERNAME=".$this->connect->Param('a')." AND USR_PASSWORD=".$this->connect->Param('b')." AND FACI_STATUS = '1' ";

        $stmt = $this->connect->Prepare($query);
        $stmt = $this->connect->Execute($stmt,array($uname2,$passwrd));
        print $this->connect->ErrorMsg();
     

        if($stmt){
           
            if($stmt->RecordCount() == 1){

                $arr = $stmt->FetchNextObject();

                $userid = $arr->USR_USERID;
                $accstatus = $arr->USR_STATUS;
                $institutioncode = $arr->USR_FACICODE;
                $institutiontype = $arr->FACI_TYPE;
                $loginstatus =$arr->USR_SESSION_STATE;
                $logintime = $arr->USR_SESSION_DATETIME;
                $infullname = $arr->USR_OTHERNAME.' '.$arr->USR_SURNAME;
                $usercode = $arr->USR_CODE;
								$countrycode = $arr->USR_COUNTRYCODE;

                //CHECK IF ACCOUNT IS LOCKED
                if($accstatus =='3'){
                    $this->logout("locked");
                }

                $this->storeAuth($userid,$uname2,$institutioncode,$infullname,$institutiontype,$usercode,$countrycode);
                $this->setLog("1");
                header('Location: ' . $this->redirect);
                //actions

            }else{
                $activity = "From a REMOTE IP:".$this->remoteip." USERAGENT:".$this->useragent."  with USERNAME:".$uname2." and PASSWORD:".USER_PASSW_VAR;
                $ufullname ='';
                $type ='003';

                $toinsetsession = $this->session->getSessionID();

                 //Start insertion in mongo db
                $eventname = "";
                $evobj = $this->mongo->GetOne("hms_eventtype", ["EVT_CODE" => $type]);
                print $this->mongo->ErrorMsg();
                if ($evobj) {
                $eventname = $evobj->EVT_NAME;
                }
                $rawpost = ($type == '001') ? '' : serialize($_POST);
                $input = [
                    "EVL_EVTCODE" => $type, 
                    "EVL_EVT_NAME" => $eventname,
                    "EVL_USERID" => '0',
                    "EVL_FULLNAME" => $ufullname,
                    "EVL_ACTIVITIES" => $activity,
                    "EVL_IP" => $this->remoteip,
                    "EVL_SESSION_ID" => $toinsetsession,
                    "EVL_BROWSER" => $this->useragent,
                    "EVL_RAW" => $rawpost,
                    "EVL_INPUTEDDATE" => date("Y-m-d H:i:s", time())
                ];
                 
                $this->mongo->InsertOne("hms_eventlog", $input);
                /*echo "<pre>";
                print_r($input);
                echo "<pre />";*/
                print $this->mongo->ErrorMsg(); 

                //$query = "INSERT INTO hms_eventlog(EVL_EVTCODE,EVL_USERID,EVL_FULLNAME,EVL_ACTIVITIES,EVL_IP,EVL_SESSION_ID,EVL_BROWSER) VALUES(".$this->connect->Param('a').",".$this->connect->Param('b').",".$this->connect->Param('c').",".$this->connect->Param('d').",".$this->connect->Param('e').",".$this->connect->Param('f').",".$this->connect->Param('g').")";
               // $stmt = $this->connect->Execute($query,array($type,'0',$ufullname,$activity,$this->remoteip,$toinsetsession,$this->useragent));

                print $this->connect->ErrorMsg();
                $this->logout("wrong");
            }


        }else{
            //error msg
        }



    }//end

    public function direct($direction=''){
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-store, no-cache, must-validate');
        header('Cache-Control: post-check=0, pre-check=0',FALSE);
        header('Pragma: no-cache');

        if($direction == 'empty'){
            header('Location: ' . $this->redirect.'&attempt_in=0');
        }else if($direction == 'wrong'){
            header('Location: ' .$this->redirect.'&attempt_in=1');
        }else if($direction == 'locked'){
            header('Location: ' .$this->redirect.'&attempt_in=110');
        }else if($direction=="out"){
            header('Location: ' .$this->redirect);
        }else if ( $direction =='captchax'){

            header('Location: ' .$this->redirect.'&attempt_in=11');
        }else{
            
            header('Location: ' .$this->redirect);

        }
        exit;

    }

    public function storeAuth($userid,$login,$institutioncode,$infullname,$institutiontype,$usercode,$countrycode)
    {
        $this->session->set('userid',$userid);
        $this->session->set('h1',$login);
        $this->session->set('activeinstitution',$institutioncode);
        $this->session->set('institutiontype',$institutiontype);
        $this->session->set('loginuserfulname',$infullname);
        $this->session->set('usercode',$usercode);
				$this->session->set('countrycode',$countrycode);
        $this->session->set('random_seed',md5(uniqid(microtime())));

        $hashkey = md5($this->hashkey . $login .$this->remoteip.$this->sessionid.$this->useragent);
        $this->session->set('hash_key',$hashkey);
        $this->session->set("LAST_REQUEST_TIME",time());

    }//end

    public function logout($msg="out")
    {

        if($msg =="out"){
            //UNLOCK SESSION
            $userid=$this->session->get("userid");
            $usercode=$this->session->get("usercode");
            $this->setLog("0");


        //Start updating time monitor table (hmsb_doctormonitor)
        /*
         * Get time difference
         */
        $sessiononlinestate = $this->session->get('sessiononlinestate');
        //$stmtp = $this->connect->Execute($this->connect->Prepare("SELECT * FROM hmsb_doctorsmonitor WHERE DM_SESSIONLOGIN = ".$this->connect->Param('a')." AND  DM_DOCTORCODE = ".$this->connect->Param('b')." "),array($sessiononlinestate,$usercode));
        $stmtp = $this->connect->Execute($this->connect->Prepare("SELECT * FROM hmsb_doctorsmonitor WHERE DM_DOCTORCODE = ".$this->connect->Param('b')." ORDER BY DM_ID DESC LIMIT 1"),array($usercode));
        print $this->connect->ErrorMsg();

        if($stmtp->RecordCount() > 0){
            $objmon =  $stmtp->FetchNextObject();
            $starttime = $objmon->DM_STARTTIME;
            $docmonitorid = $objmon->DM_ID;

            $currenttime = date('Y-m-d H:i:s');

            //$timediff = date( "i", abs(strtotime($currenttime) - strtotime($starttime)));

            /** End getting time difference */
            $this->connect->Execute("UPDATE hmsb_doctorsmonitor SET DM_ENDTIME = ".$this->connect->Param('a').",DM_TIMEDIFF = CONCAT(
			MOD (
				HOUR (
					TIMEDIFF(
						".$this->connect->Param('b').",
						".$this->connect->Param('c')."
					)
				),
				24
			),
			'H : ',
			MINUTE (
				TIMEDIFF(
					".$this->connect->Param('d').",
					".$this->connect->Param('e')."
				)
			),
			'min'
		),DM_SOURCE = '3' WHERE DM_DOCTORCODE = ".$this->connect->Param('f')." AND DM_ID =  ".$this->connect->Param('g')." ",array($currenttime,$starttime,$currenttime,$starttime,$currenttime,$usercode,$docmonitorid));
            print $this->connect->ErrorMsg();

            $this->session->del('sessiononlinestate');
        }
        //End time monitor



        }

        //Set User offline
        $query = "UPDATE hms_users SET USR_ONLINE_STATUS = '0',USR_CONSULTING_STATUS = '0',USR_CHATSTATE = '' WHERE USR_USERID =  ".$this->connect->Param('a')."";
        $stmt = $this->connect->Execute($query,array($userid));
        print $this->connect->ErrorMsg();

        $this->connect->Execute($this->connect->Prepare("UPDATE hms_consultation SET CONS_INCONSULTATION = '0' WHERE CONS_DOCTORCODE = ".$this->connect->Param('a')." "),array($usercode));
        print $this->connect->ErrorMsg();

        //Set Room to be empty
        $this->connect->Execute("UPDATE hms_users SET USR_ROOM_STATUS = '0' WHERE USR_CODE = ".$this->connect->Param('a')." ",array($usercode));
            
        //Set previous entry into room table as empty
        $this->connect->Execute("UPDATE hms_consultation_rooms SET CONSROOM_DOCTORCODE = '',CONSROOM_DOCTORNAME = '' WHERE CONSROOM_DOCTORCODE = ".$this->connect->Param('a')." ",array($usercode));

        $this->session->del('userid');
        $this->session->del('loginuserfulname');
        $this->session->del('h1');
        $this->session->del('activeinstitution');
        $this->session->del('random_seed');
        $this->session->del('hash_key');
        $this->session->del('usercode');
        $this->direct($msg);

    }//end

    public function confirmAuth(){

        $login = $this->session->get("h1");
        $hashkey = $this->session->get('hash_key');

        if(md5($this->hashkey . $login .$this->remoteip.$this->sessionid.$this->useragent) != $hashkey)
        {
            $this->logout();
        }
    }//end


    private function setLog($act){
        $userid=$this->session->get("userid");
        $ufullname = $this->session->get('loginuserfulname');
        $toinsetsession = $this->session->getSessionID();
        $server = $_SERVER;
        unset($server['CONTEXT_DOCUMENT_ROOT']);
        unset($server['PATH']);
        unset($server['SystemRoot']);
        unset($server['SERVER_ADMIN']);
        unset($server['DOCUMENT_ROOT']);
        unset($server['SERVER_SOFTWARE']);
        unset($server['SERVER_SIGNATURE']);
        $ser = serialize($server);
       // $query = "INSERT INTO hms_eventlog(EVL_EVTCODE,EVL_USERID,EVL_FULLNAME,EVL_ACTIVITIES,EVL_IP,EVL_SESSION_ID,EVL_BROWSER,EVL_RAW) VALUES(".$this->connect->Param('a').",".$this->connect->Param('b').",".$this->connect->Param('c').",".$this->connect->Param('d').",".$this->connect->Param('e').",".$this->connect->Param('f').",".$this->connect->Param('g').",".$this->connect->Param('g').")";


        if($act == "1"){
            $type ='001';
            $activity = "From a REMOTE IP:".$this->remoteip." USERAGENT:".$this->useragent."  on SESSION ID:".$this->session->getSessionID();

        }else if($act == "0"){
            $userid = ($userid == "0")?"-1":$userid;
            $type ='002';
            $activity = "From a REMOTE IP:".$this->remoteip." USERAGENT:".$this->useragent."  on SESSION ID:".$this->session->getSessionID();
        }

        //Start insertion in mongo db
        $eventname = "";
       
        $evobj = $this->mongo->GetOne("hms_eventtype", ["EVT_CODE" => $type]);
        
       
        print $this->mongo->ErrorMsg();
        if ($evobj) {
           $eventname = $evobj->EVT_NAME;
        }
        $rawpost = ($type == '001') ? '' : serialize($_POST);
        $input = [
            "EVL_EVTCODE" => $type, 
            "EVL_EVT_NAME" => $eventname,
            "EVL_USERID" => $userid,
            "EVL_FULLNAME" => $ufullname,
            "EVL_ACTIVITIES" => $activity,
            "EVL_IP" => $this->remoteip,
            "EVL_SESSION_ID" => $toinsetsession,
            "EVL_BROWSER" => $this->useragent,
            "EVL_RAW" => $rawpost,
            "EVL_INPUTEDDATE" => date("Y-m-d H:i:s", time())
         ];
         
         if($userid !='-1'){
             $this->mongo->InsertOne("hms_eventlog", $input);
             /*echo "<pre>";
             print_r($input);
             echo "<pre />";*/
             print $this->mongo->ErrorMsg();
         }
       // $stmt = $this->connect->Execute($query,array($type,$userid,$ufullname,$activity,$this->remoteip,$toinsetsession,$this->useragent,$ser));
       // print $this->connect->ErrorMsg();
    }

}
?>