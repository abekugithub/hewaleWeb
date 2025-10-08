<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 12/7/2017
 * Time: 11:47 AM
 */

include '../../../../config.php';
//include SPATH_LIBRARIES.DS.'encryptAES.Class.php';

//$encaes = new encAESClass();
//echo $datefrom.$dateto;
if (!empty($datefrom)&&!empty($dateto)) {
    $stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_LABCODE = " . $sql->Param('a') . " AND LT_DATE BETWEEN " . $sql->Param('b') . " AND " . $sql->Param('c')), array($faccode, $hiddatefrom, $hiddateto));
    print $sql->ErrorMsg();

    if ($stmt->RecordCount() > 0) {
        $num = 0;
        while ($obj = $stmt->FetchNextObject()) {
            $result[] = array(
                'patientname' => $obj->LT_PATIENTNAME,
                'patientcode' => $obj->LT_PATIENTCODE,
                'testname' => $encaes->decrypt($obj->LT_TESTNAME),
                'labdiscpline' => $obj->LT_DISCPLINENAME,
                'labrequestdate' => $obj->LT_DATE
            );
        }
    }
}