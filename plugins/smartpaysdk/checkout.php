<?php
namespace SmartpaySDK;
require "./config.php";
use SmartpaySDK\checkout;

$smartpay = new checkout();
$amount =  '0.10';
$description = 'New live emergent smartpay api tests';

$params = array(
    'apiKey' => API_KEY, 
    'secretKey' => API_SECRET, 
    'payamount' => $amount, 
    'currency' => 'ghs', 
    'description' => $description, 
    'action' => 'checkout', 
    // 'alertphone' => '0242925729'
    'returnUrl' => 'http://localhost/yourproject?index.php?action=ddoioqququq'
);

$response = $smartpay->receive($params);
\var_dump($response);
if(!$response){
    die('Failed');
}elseif($response['status'] != 'success'){
    die('failed to get checkout url');
}
// insert or update your database with $response['response']['token'] then redirect
$response = $response['response'];

$sql->Execute("INSERT INTO sdk_transactions (TR_TOKEN,TR_AMOUNT,TR_DESC,TR_CHECKOUT_URL,TR_STATUS,TR_CREATEDDATE) VALUES (?,?,?,?,?,?)", array($response['token'],$amount,$description,$response['checkout_url'],'0', date('Y-m-d H:i:s')));

header('location: '. $response['checkout_url']);