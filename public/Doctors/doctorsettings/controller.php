<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 8/11/2017
 * Time: 1:32 PM
 */

$actor_id = $engine->getActorCode();
//Get currency
$currencies = $engine->getCurrency();

switch ($viewpage){
    case 'save':
        if (!empty($qconsulttype)){
            if (is_array($_POST['drugcountry'])){
                $drugcountry = implode(',',$_POST['drugcountry']); 
            }
            $stmt = $sql->Execute($sql->Prepare("UPDATE hmsb_med_prac SET MP_CURRENCY=".$sql->Param('a').",MP_CONSULTATION_CHARGES=".$sql->Param('a').",MP_NUMBER_OF_CONSULTATION=".$sql->Param('a').",MP_DRUGCOUNTRYREGISTER=".$sql->Param('a').",MP_APPOINTMENT_CHARGES=".$sql->Param('a').",MP_QCONSULT_CHARGES=".$sql->Param('a').",MP_QCONSULT_TYPE=".$sql->Param('a').",MP_DISCLAIMER=".$sql->Param('a').",MP_PREMIUM_CHARGE_DOC=".$sql->Param('a').",MP_PREMIUM_CHARGE_NURSE=".$sql->Param('a')." WHERE MP_USRCODE=".$sql->Param('a').""),
                array($dr_currency,$charges,$numbercons,$drugcountry,$perappoint,$perqconsult,$qconsulttype,$disclaimer,$premserCharge,$premserChargeNurses,$actor_id));
            print $sql->ErrorMsg();

            if ($stmt){
                $msg = 'Your set up was successful.';
                $status = 'success';

            }else{
                $msg = 'An error was encountered while trying to set you up for business. Be sure all fields are filled and try again.';
                $status = 'error';
            }
        }else{
            $msg = 'All fields are required';
            $status = 'error';
        }
    break;

}

 include("model/js.php") ;
$countries = $engine->getCountry();

if (!empty($actor_id)){
    $query = $sql->Execute($sql->Prepare("SELECT * FROM hmsb_med_prac WHERE MP_USRCODE=".$sql->Param('a').""),array($actor_id));
    print $sql->ErrorMsg();
    if ($query->RecordCount()>0){
        $obj = $query->FetchNextObject();
        $dr_currency = $obj->MP_CURRENCY;
        $charges = $obj->MP_CONSULTATION_CHARGES;
        $numbercons = $obj->MP_NUMBER_OF_CONSULTATION;
        $drugcountry = $obj->MP_DRUGCOUNTRYREGISTER;
        $drug_country = explode(',',$drugcountry);
        $perappoint= $obj->MP_APPOINTMENT_CHARGES;
        $perqconsult= $obj->MP_QCONSULT_CHARGES;
        $qconsulttype= $obj->MP_QCONSULT_TYPE;
        $disclaimer = $obj->MP_DISCLAIMER;
        $premserCharge = $obj->MP_PREMIUM_CHARGE_DOC;
        $premserChargeNurses = $obj->MP_PREMIUM_CHARGE_NURSE;
    }
}