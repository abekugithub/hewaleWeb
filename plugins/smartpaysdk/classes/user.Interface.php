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

interface userInterface 
{

    /**
     * creating a standard interface for the user 
     */
    public function receive($params = array());

    public function send($params = array());
}
