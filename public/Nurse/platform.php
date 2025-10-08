<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 5/1/2018
 * Time: 5:12 PM
 */

switch ($option){
    case md5('Doctor Request'):
        include 'doctorrequest/platform.php';
    break;

    case md5('My Patient'):
        include 'mypatient/platform.php';
    break;

    case md5('Nurse Profile'):
        include 'nurseprofile/platform.php';
    break;

    case md5('My Wallet'):
//        include 'wallet/platform.php';
        include 'public/wallet/mywallet/platform.php';
    break;

    case md5('First Aid'):
        include 'public/OPD/firstaid/platform.php';
    break;

    case md5('Vitals'):
        include 'public/OPD/vitals/platform.php';
    break;

    case md5('Treatment Sheet'):
        include 'public/IPD/treatmentsheet/platform.php';
    break;

    case md5('My Doctors'):
        include 'mydoctors/platform.php';
    break;
}