<?php
	//MONGO DB
	$mongo = NewADOConnection($engine_mongo);
	$mongo->debug = $config->debug;
	//echo $server_mongo.' '.$username_mongo.' '.$password_mongo.' '.$database_mongo ;
	$db2 = $mongo->Connect($server_mongo, $username_mongo, $password_mongo, $database_mongo);

	if (!$db2) {
   		exit('Server II Connection Down');
	} 

	//$config = new JConfig();
    $sql = ADONewConnection($engine);
    $sql->debug = $config->debug;
	$sql->autoRollback = $config->autoRollback;
	$sql->bulkBind = true;
	$sql->SetFetchMode(ADODB_FETCH_ASSOC);
    $db = $sql->Connect($server, $username, $password, $database);
    $session = new Session();
	if(!$db){
		exit('Connection Down');	
	}
?>
