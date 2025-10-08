<?php
namespace SmartpaySDK;
use SmartpaySDK\engine;
 
/**
 * main class
 *
 * The class is connects to various payment gateway modes.
 *
 * @package    SmartpaySDK
 * @author     Albert Angmor <albertangmor@gmail.com>
 */

class checkout implements userInterface 
{
    /**
     * Allows you to debit an account. Either a mobile account or card or smartpay and returns either a token or url based on $this->gateway_mode
     *
     * @param array
     * @return string Returns a json string with redirect url
     */
    public function receive($params = array())
    {
        $engine = new engine();
        $response = $engine->smartCurl($params); 
        return $response;
    }

    public function send($params = array())
    {

    }
}
