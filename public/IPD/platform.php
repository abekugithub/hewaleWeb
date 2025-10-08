<?php
    switch($option){
        case md5("Ward Rounds"):
            include ("wardrounds/platform.php");
        break;
		case md5("Treatment Sheet"):
            include ("treatmentsheet/platform.php");
        break;
		case md5("Pending Admissions"):
            include ("pendingadmissions/platform.php");
        break;

		case md5("Manage Admissions"):
            include ("manageadmission/platform.php");
        break;
		case md5("Anaesthesia In-puts"):
            include ("anaesthetics-input/platform.php");
        break;

    }
?>