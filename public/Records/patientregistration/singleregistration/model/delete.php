<?php

include '../../../../../config.php';

$num = '001';
$i = 1;
if (!empty($keys)){
    $checkstmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_relation WHERE PR_STATUS='1' AND PR_ID=".$sql->Param('a')." AND PR_PATIENTNUM = ".$sql->Param('a')." "),array($keys,$patientnum));
    print $sql->ErrorMsg();
    if ($checkstmt->RecordCount()>0){
        $stmt = $sql->Execute($sql->Prepare("UPDATE hms_patient_relation SET PR_STATUS='2' WHERE PR_ID = ".$sql->Param('a').""), array($keys));
        print $sql->ErrorMsg();
        if ($stmt){
            $stmtrln = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_relation WHERE PR_STATUS = '1' AND PR_PATIENTNUM = ".$sql->Param('a')." ORDER BY PR_INPUTEDDATE DESC"),array($patientnum));
            print $sql->ErrorMsg();

            while($relation=$stmtrln->FetchNextObject()){
                $results.= '<tr><td>'.$i++.'  </td><td>'.$relation->PR_RELATION_PATIENTNUM.'</td><td>'.$relation->PR_RELATION.'</td><td class="text-center valign-middle" width="100"><button class="btn btn-xs btn-danger square" type="button" onclick="deleteRelation(\''.$relation->PR_ID.'\')"><i class="fa fa-close"></i></button></td></tr>';
            }
            echo $results;
        }
    }else{
        return 0;
    }
}



