<?php


class smsgetway extends engineClass
{
    public  $sql;
    public $session;

    function  __construct() {
        global $sql,$session,$phpmailer;
        $this->session= $session;
        $this->sql = $sql;
    }

    public function sendSms($to,$msg,$from = "HEWALE"){
        $url = 'https://txtkube.com/api/send';
        $tokenUsername = 'eelPsPrc';
        $tokenPassword = 'CcsA1csm';
        $phoneNumber = ''; // Phone number of recepient 233545155292
        $senderName = ''; // Name of the sender
        $message = ''; // Message to be sent
        $params = '?tokenUsername='.$tokenUsername;
        $params.= '&tokenPassword='.$tokenPassword;
        $params.= '&to='.urlencode($to);
        $params.= '&from='.urlencode($from);
        $params.= '&content='.urlencode($msg);
// Send through Curl
        $ch = curl_init();
        $headers = array('Content-Type: multipart/form-data');
        curl_setopt($ch, CURLOPT_URL, $url.$params);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);


        $data = explode('|',$result);
        if($data['0'] == "1701"){
            $result = "Success";
        }else {
            $errormsg = array('1703' => 'Invalid Username Or Password',
                '1704' => 'Invalid value in type field',
                '1705' => 'Invalid Message ',
                '1706' => 'Invalid Destination ',
                '1707' => 'Invalid Source (Sender ',
                '1708' => 'Invalid value for dlr field ',
                '1709' => 'User validation failed ',
                '1710' => 'Internal Error ',
                '1025' => 'Insufficient Credit User '
            );

            $result = $errormsg[$data['0']];
        }
        return $result;
    }


    public function validateNumber($number, $forced_prefix = NULL, $number_length = '0'){

        if (!$forced_prefix){
            $forced_prefix = "+233";
        }

        // Remove any non-numeric characters in the number
        $number = preg_replace('/[^\+0-9]/s','',$number);

        // If a prefix is allready added then return the number "as is"
        if ( substr($number, 0, 1) == "+" || substr($number, 0, 2) === "00" || substr($number, 0, 3) === "233" ){
            return $number;
        }

        if (substr($number, 0, 1)=='0' && substr($number,0,2)!='00'){
            // single 0 at the beginning of number, we're supposed to remove that
            $number = substr($number,1);
        }

        // Add a prefix if the number doesn't have one yet
        if (isset($forced_prefix) && strlen($forced_prefix) > 0){
            if (substr($number, 0, strlen($forced_prefix)) != $forced_prefix){
                // The beginning of the number does not match the forced prefix
            }else{
                $number = substr($number, strlen($forced_prefix));
            }
        }

        // Check if the number is still not numeric, if so we return 0/false
        if (!is_numeric($number)){
            return 0;
        }

        // Check if the number has the correct length.
        // Setting $number_length to 0 or false will skip this test
        if ($number_length && strlen($number) != $number_length){
            return 0;
        }

        // Add the forced prefix
        $number = $forced_prefix . $number;

        return $number;
    }


    /**
     * This code below does the insertion of each message sent in the sms_log table
     *
     */
    private function smslog($destination,$message,$response){
        $uniqid = uniqid(date('Y-m-d'));
        $currentdate = date('Y-m-d H:i:s');
        $stmt = $this->sql->Prepare("INSERT INTO hms_sms_logs(SMS_ID,SMS_DESTINATION,SMS_CONTENT,SMS_DATE_SENT,SMS_RESPONSE) VALUES (".$this->sql->Param('a').",".$this->sql->Param('b').",".$this->sql->Param('c').",".$this->sql->Param('d').",".$this->sql->Param('e').")" );
        $stmt = $this->sql->Execute($stmt,array($uniqid,$destination,$message,$currentdate,$response));
        print $this->sql->ErrorMsg();
    }

}