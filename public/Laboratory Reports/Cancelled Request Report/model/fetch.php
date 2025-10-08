<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 12/8/2017
 * Time: 3:18 PM
 */
include '../../../../config.php';
include SPATH_LIBRARIES.DS."engine.Class.php";
include SPATH_LIBRARIES.DS."doctors.Class.php";
$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);

$engine = new engineClass();
$doc = new doctorClass();
$day = Date("Y-m-d");
$usrcode = $engine->getActorCode();
$usrname = $engine->getActorName();
$actor = $engine->getActorDetails();
$activeinstitution = $actor->USR_FACICODE;


//if (!empty($txtarea)){
$from = date("Y-m-d",strtotime($datefrom));
$to = date("Y-m-d",strtotime($dateto));

$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_labtest WHERE LT_LABCODE = ".$sql->Param('a')." AND LT_DATE BETWEEN ".$sql->Param('b')." AND ".$sql->Param('c')),array($activeinstitution,$from,$to));
print $sql->ErrorMsg();
//$result = array();
$num = 1;

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
    }}
else{
    $result.='<tr>
					<td colspan="3">No record found.</td>
				<tr>';
}
$result.='
                    
                    </tbody>
                </table>';


echo $result;