<?php

include '../../../../../config.php';

if (!empty($patientcode)&&!empty($patientnum)&&!empty($prnum)&&!empty($relation)){

    $relationexist = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient WHERE PATIENT_STATUS = '1' AND PATIENT_PATIENTCODE = ".$sql->Param('a')." "),array($patientcode));
    print $sql->ErrorMsg();

    if ($relationexist->RecordCount()>0){
        $i = 1;
        $stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_patient_relation (PR_CODE,PR_PATIENTCODE,PR_PATIENTNUM,PR_RELATION_PATIENTNUM,PR_RELATION) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').",".$sql->Param('5').") "), array('001',$patientcode,$patientnum,$prnum,$relation));
        print $sql->ErrorMsg();

        if ($stmt){
            $stmtrln = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_relation WHERE PR_STATUS = '1' AND PR_PATIENTNUM = ".$sql->Param('a')." ORDER BY PR_INPUTEDDATE DESC"),array($patientnum));

            while($relation=$stmtrln->FetchNextObject()){

                $results.= '
                                    <tr>
                                       <td>'.$i++.'  </td>
                                       <td>'.$relation->PR_RELATION_PATIENTNUM.'</td>
                                       <td>'.$relation->PR_RELATION.'</td>
                                       
                                       <td class="text-center valign-middle" width="100">
                                       <button class="btn btn-xs btn-danger square" type="button"
							onclick="deleteRelation(\''.$relation->PR_ID.'\')">
							<i class="fa fa-close"></i>
						</button>
                                       </td>
                                    </tr> ';

            }
            echo $results;
        }else{
            return 0;
        }
    }else{
        $msg = 'The Patient Number entered does not exist';
    }
}else{
    $msg = "All fields required";
    $status = "error";
}
echo json_encode($msg);