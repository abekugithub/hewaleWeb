<?php
/**
 * This file contains common ways of using the smartpaysdk.
 *
 * @package    SmartpaySDK
 * @license    http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @author     Albert Angmor <albertangmor@gmail.com>
 * @methods eg checkout, direct
 *  
 * /
$smartpay = new SmartpayClass();

$smartpay->checkout($params);

$smartpay->direct($params);