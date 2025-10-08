<?php
require "vendor/autoload.php";
define('API_URL', 'https://smartpaygh.com/frontapi/index.php');
define('API_KEY', 'as5sds3s6b735f43fa5s3as13');
define('API_SECRET', '3fdsk7w0k3e50rdf23d53f5f1');

global $gclient, $sql;

$gclient = new GuzzleHttp\Client();
