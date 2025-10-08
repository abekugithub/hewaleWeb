<?php
namespace SmartpaySDK;

/**
 * main class
 *
 * The class is connects to various payment gateway modes.
 *
 * @package    SmartpaySDK
 * @author     Albert Angmor <albertangmor@gmail.com>
 */

class direct 
{
    private $gateway_mode;

    /**
     * Sets the mode of the sdk and all functions depend on this mode
     *
     * @param string $gaeway_mode Either checkout or direct
     */
    public function __construct($gateway_mode){
        $this->gateway_mode = $gateway_mode;
    }

    /**
     * Allows you to debit an account. Either a mobile account or card or smartpay and returns either a token or url based on $this->gateway_mode
     *
     * @param int|string $user Either an ID or a username
     * @param PDO $pdo A valid PDO object
     * @return User Returns User object or null if not found
     */
    public function receive($params = array())
    {

    }

    public function send($params)
    {

    }
}
