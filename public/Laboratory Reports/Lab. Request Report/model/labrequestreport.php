<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 11/28/2017
 * Time: 11:31 AM
 */
include "../../../../config.php";
include SPATH_LIBRARIES.DS."engine.Class.php";
$engine = new engineClass();
$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);

$actorname = $engine->getActorName();
$faccode = $engine->getActorDetails()->USR_FACICODE;
$actorcode = $engine->getActorDetails()->USR_CODE;
$userid = $engine->getActorDetails()->USR_USERID;
$crtdate= date("Y-m-d H:m:s");
$report_content = '';

if (!empty($datefrom)&&!empty($dateto)){
    $stmt = $sql->Execute($sql->Prepare("SELECT LT_DATE,LT_LABCODE,LT_TEST,LT_STATUS,LT_VISITCODE,LT_LABNAME,LT_PATIENTNUM,LT_RMK,LT_ACTORCODE,LT_TESTNAME,LT_PATIENTNAME,LT_DISCPLINENAME,LT_DISCIPLINE,LT_CODE,LT_ACTORNAME,LT_INSTCODE,LT_LABREMARK,LT_PATIENTCODE FROM hms_patient_labtest WHERE LT_LABCODE = ".$sql->Param('a')." AND LT_DATE BETWEEN ".$sql->Param('b')." AND ".$sql->Param('c')),array($faccode,$datefrom,$dateto));
    print $sql->ErrorMsg();

    $result.='<table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Hewale Number</th>
                            <th>Lab. Test</th>
                            <th>Discipline</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>';
    if($stmt->RecordCount() > 0){
        $num = 1;
        while($obj  = $stmt->FetchNextObject()){

            $result.='<td>'.$num++.'</td>
                        <td>'.$obj->LT_PATIENTNAME.'</td>
                        <td>'.$obj->LT_PATIENTCODE.'</td>
                        <td>'.$encaes->decrypt($obj->LT_TESTNAME).'</td>
						<td>'.$obj->LT_DISCPLINENAME.'</td>
						<td>'.date("d/m/Y",strtotime($obj->LT_DATE)).'</td>
                    </tr>';
        }
    }
    else{
        $result.='<tr>
					<td colspan="3">No record found.</td>
				<tr>';
    }
    $result.='</tbody></table>';
    echo $result;
}