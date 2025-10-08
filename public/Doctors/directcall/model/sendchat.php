<?php
include('../../../config.php');
$engine = new engineClass();
$usrcode = $session->get('userid');

echo "greattt";
	if(!empty($usrcode) && !empty($doctorcode) && !empty($message) ){
    $action ="sendchat";
    $data ="&sender_code=".$usrcode."&receiver_code=".$doctorcode."&msg=".$message;
    $request = $engine->request_api($action,$data);
    $response = json_decode($request);
   // echo('<br>'.$response->data);
    if($response->status=='200'){
        echo json_encode(1);
    }else{
        $response = array('status'=>'404', 'data'=>array('msg'=>$sql->ErrorMsg()));
    }
}
    
?>