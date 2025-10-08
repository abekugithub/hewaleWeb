<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 11/27/2017
 * Time: 5:14 PM
 */

switch ($option){
    case md5('Lab. Request Report'):
        include 'Lab. Request Report/platform.php';
    break;

    case md5('Signed Off Report'):
        include 'Signed Off Report/platform.php';
    break;

    case md5('Cancelled Request Report'):
        include 'Cancelled Request Report/platform.php';
    break;

    case md5('External Lab. Request Report'):
        include 'External Lab. Request Report/platform.php';
    break;

    case md5('Lab. Test Report'):
        include 'Lab. Test Report/platform.php';
    break;

    case md5('Lab. Specimen Report'):
        include 'Lab. Specimen Report/platform.php';
    break;

    case md5('Archived Report'):
        include 'Archived Report/platform.php';
    break;
}