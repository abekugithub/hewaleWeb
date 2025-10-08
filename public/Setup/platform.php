<?php
switch($option){

    // 15 DEC 2017, JOSEPH ADORBOE , SERVICE PRICING

    // 15 MAR 2018, JOSEPH ADORBOE, WARD SETUP
    case md5("Ward Setup"):
        include("wards/platform.php");
    break;

    // 15 MAR 2018, JOSEPH ADORBOE, BED SETUP
    case md5("Bed Setup"):
        include("beds/platform.php");
    break;

    case md5("Pricing - Labs"):
        include("pricinglabs/platform.php");
    break;

    case md5("Stock Setup"):
        include("pharmacysetup/platform.php");
    break;

    case md5("Manage Users"):
        include("manageusers/platform.php");
    break;

    case md5("Users Positions"):
        include("manageposition/platform.php");
    break;

    case md5("Change Password"):
        include("changepassword/platform.php");
    break;

    case md5("My Settings"):
        include("doctorsettings/platform.php");
    break;

    case md5("Payment Method"):
        include("paymentmethod/platform.php");
    break;

    case md5("Lab Tests Setup"):
        include ("labtestsetup/platform.php");
    break;

    case md5("Map Services"):
        include ("mapservices/platform.php");
    break;

    case md5("Pharmacy Pricing"):
        include ("pharmacypricing/platform.php");
    break;

    case md5("Branches"):
        include("courierbranches/platform.php");
    break;

    case md5("Laboratory Pricing"):
        include ("laboratorypricing/platform.php");
    break;

    case md5("X-ray Pricing"):
        include ("x-raypricing/platform.php");
    break;

    case md5("Consumables Pricing"):
        include("pricingconsumables/platform.php");
    break;

    case md5("Accommodation Pricing"):
        include("pricingaccommodation/platform.php");
    break;

    case md5("Payment Category"):
        include("paymentcategory/platform.php");
    break;

    case md5("Manage Services"):
        include("manageservices/platform.php");
    break;

    case md5("Admin Setting"):
        include("adminsetting/platform.php");
    break;

    case md5("Courier Services"):
        include("courierservices/platform.php");
    break;

    case md5("X-ray Setup"):
        include("xraysetup/platform.php");
    break;

    case md5("Manage Settlement Account"):
        include("settlementaccount/platform.php");
    break;
}
?>