<?php
include "../config.php";

// $sql->debug = true;
$logit = file_get_contents('php://input');
$data = json_decode($logit, true);

$stmt = $sql->Execute($sql->Prepare("SELECT * FROM sdk_transactions WHERE TR_TOKEN =".$sql->Param('b')." "),array($data['trans_token']));
echo $sql->ErrorMsg();

if($stmt->RecordCount() > 0){
    $obj = $stmt->FetchNextObject();

    $transtatus = (substr($data['trans_status']))?'success':'fail';


    //update merchant account

    switch($data['trans_response']){
        case "200":
        
        $sql->Execute($sql->Prepare('UPDATE sdk_transactions SET TS_STATUS = '.$sql->Param('b').' WHERE TS_TOKEN ='.$sql->Param('b')),array('1',$data['trans_token']));
        echo $sql->ErrorMsg();  
      
        break;

        case "403":          
        $sql->Execute($sql->Prepare('UPDATE sdk_transactions SET TS_STATUS = '.$sql->Param('b').' WHERE TS_TOKEN ='.$sql->Param('b')),array('2',$data['trans_token']));
        echo $sql->ErrorMsg(); 
        break;
    }

    
    echo '{"status" : "ok"}';
}else{
    //transaction code already verified or doesnt exist
    echo '{"status" : "fail",
        "message" : "failure transaction code/status check!"
    }';

}