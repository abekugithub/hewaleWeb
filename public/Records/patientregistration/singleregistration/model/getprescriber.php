<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 10/26/2017
 * Time: 11:46 AM
 */

include '../../../../../config.php';
include SPATH_LIBRARIES . DS . "engine.Class.php";
$patientCls = new patientClass();
$engine = new engineClass();
$actorname = $engine->getActorName();

$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_userdepartment WHERE USRDEPT_DEPTCODE LIKE ".$sql->Param('a')." AND USRDEPT_FACCODE = ".$sql->Param('c')),array('%'.$departmentcode.'%',$faccode));
print $sql->ErrorMsg();

$result = '';
if ($stmt->RecordCount()>0){
    while ($obj = $stmt->FetchNextObject()){
        $result .= $obj->USRDEPT_USERCODE.',';
//        $result[] = array("<option value='".$obj->PINS_METHOD_CODE."'>".$obj->PINS_COMPANY_NAME."</option>");
    }
    $result = substr($result,0,-1);
    $result = implode("','",explode(',',$result));
    if (!empty($result)){
        $stmt = $sql->Execute($sql->Prepare("SELECT USR_CODE,CONCAT(USR_SURNAME,' ',USR_OTHERNAME) USR_FULLNAME,USR_ONLINE_STATUS FROM hms_users WHERE USR_CODE IN ('".$result."') AND USR_FACICODE= ".$sql->Param('a')." AND USR_TYPE=".$sql->Param('b').""),array($faccode,'1'));
        print $sql->ErrorMsg();

        $result1 = array();
        if ($stmt->RecordCount()>0){
            while ($res = $stmt->FetchNextObject()){
                $result1[] = array("<option value='".$res->USR_CODE.'@@@'.$res->USR_FULLNAME."'>".$res->USR_FULLNAME.' '.(($prescriber->USR_ONLINE_STATUS=='1')?"(Available)":"(Unavailable)")."</option>");
            }
        }else{
            $result1 = "no result";
        }
    }else{
        $result1 = "<option value=''>No Record Found</option>";
    }
}else{
    $result1 = "<option value=''>No Record found</option>";
}
echo json_encode($result1);