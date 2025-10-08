<?php

include '../../../../config.php';



if (!empty($patientnum)&&!empty($prnum)&&!empty($relation)){
	
	$i = 1;
    $stmt = $sql->Execute($sql->Prepare("INSERT INTO hms_patient_relation (PR_CODE,PR_PATIENTNUM,PR_RELATION_PATIENTNUM,PR_RELATION) VALUES (".$sql->Param('1').",".$sql->Param('2').",".$sql->Param('3').",".$sql->Param('4').") "), array('001',$patientnum,$prnum,$relation));
    print $sql->ErrorMsg();

    if ($stmt){
		$stmtrln = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_relation WHERE PR_PATIENTNUM = ".$sql->Param('a')." "),array($patientnum));
		
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
        
    }
}else{
    $msg = "All fields required";
    $status = "error";
}
echo json_encode($msg);