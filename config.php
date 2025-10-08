<?php
// if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
// 	$location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
// 	header('HTTP/1.1 301 Moved Permanently');
// 	header('Location: ' . $location);
// 	exit;
// }
// error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_WARNING);
//GLOBAL VARiABLES
global $sql,$mongo,$session,$config,$target,$viewpage,$msg,$status,$pg,$view,$currency,$default_photo,$default_logo,$activate,$currentusercode,$currentuserspeciality;
error_reporting(error_reporting() & ~E_NOTICE && ~E_WARNING);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define("SPATH_ROOT",dirname(__FILE__));
define("DS",DIRECTORY_SEPARATOR);
define( 'SPATH_LIBRARIES',	 	SPATH_ROOT.DS.'library' );
define( 'SPATH_PLUGINS',		SPATH_ROOT.DS.'plugins'   );
define( 'SPATH_PUBLIC'	   ,	SPATH_ROOT.DS.'public' );
define( 'SPATH_MEDIA'	   ,	SPATH_ROOT.DS.'media' );
define( 'SPATH_CONFIGURATION' , SPATH_ROOT.DS.'configuration' );
define( 'SHOST_IMAGES'	   ,	SPATH_MEDIA.DS.'uploaded' );
//define( 'ATTACH_LABRESULT'	   ,	SPATH_MEDIA.DS.'uploaded'.DS.'labresult' );
define( 'ATTACH_SCANRESULT'	   ,	SPATH_MEDIA.DS.'uploaded'.DS.'xrayresult' );
define( 'SHOST_PASSPORT'	   ,'../uploads/profiles/');
define( 'SPATH_ENCRYPT',	 	SPATH_ROOT.DS.'encrypt' );
define( 'SHOST_PATIENTPHOTO'	   ,'../uploads/profiles/');
define( 'SHOST_FTP_PATIENTPHOTO'	   ,'../uploads/profiles/');
define( 'SHOST_XRAYRESULT'	   , '../uploads/xrayresult/');
define( 'SHOST_DOCTOR_IMG_URL'	   ,	'../uploads/doctors/' );
define( 'SHOST_PRESCRIPTION'	   ,'../uploads/prescriptions/');
define( 'ATTACH_LABTEST'	   ,	'../uploads/labs/labtests/' );
define( 'ATTACH_LABRESULT'	   ,	'../uploads/labs/labresults/' );

define('push_notif_title','Hewale - Social Health');

//Post Keeper
if($_REQUEST){
    foreach($_REQUEST as $key => $value){
        $prohibited = array('<script>','</script>','<style>','</style>');
        $value = str_ireplace($prohibited,"",$value);
        if(is_array($value)){
			$value = implode('',$value);
		}
        $$key = @trim($value);
    }
}
if($_FILES){
    foreach($_FILES as $keyimg => $values){
        foreach($values as $key => $value){
            $$key = $value;
        }
    }

}
//SYSTEM TIMEZONE FORMAT
date_default_timezone_set('UTC');

class JConfig {

    public $secret='22AckerMyCh77';
    public $debug = false;
    public $autoRollback= true;
    public $ADODB_COUNTRECS = false;
    private static $_instance;
    public $smsusername ="";
    public $smspassword="";
    public $smsurl="";

    public function __construct(){

    }

    private function __clone(){}

    public static function getInstance(){

        if(!self::$_instance instanceof self){

            self::$_instance = new self();
            
        }
        return self::$_instance;

    }

}

$config = JConfig::getInstance();
 
//included classes
include SPATH_LIBRARIES.DS."session.Class.php";
include SPATH_PLUGINS.DS."adodb".DS."adodb.inc.php";
include SPATH_CONFIGURATION.DS."configuration.php";
include SPATH_LIBRARIES.DS."sql.php";
include SPATH_LIBRARIES.DS."cryptCls.php";
include SPATH_LIBRARIES.DS."encryptAES.Class.php";
include SPATH_ENCRYPT.DS."keys.php";
include SPATH_LIBRARIES.DS."formating.Class.php";
include SPATH_LIBRARIES.DS."pagination.Class.php";
include SPATH_LIBRARIES.DS."patient.Class.php";
//include SPATH_LIBRARIES.DS."smsgateway.class.php";
include SPATH_PLUGINS.DS.'vendor'.DS.'autoload.php';//Phpspreadsheet
//include SPATH_PLUGINS.DS."PHPExcel".DS."PHPExcel.php";
//include SPATH_PLUGINS.DS."fpdf".DS."fpdf.php";
//include SPATH_PLUGINS.DS."fpdf".DS."fpdf_protection.php";

$currency='¢';
$activate = "";
$default_photo = 'media/img/default.jpg';
$default_logo = 'media/img/logo_here.png';

/*
 *
 * Encryption and decryption keys
 * 128-bit key
 * 
 */
$activekey = '1';

$saltencrypt = $encryptkeys[$activekey]['salt'];
$pepperdecrypt =  $encryptkeys[$activekey]['pepper'];
$encryptkey =  $encryptkeys[$activekey]['enkey'];
// End encryption

?>
