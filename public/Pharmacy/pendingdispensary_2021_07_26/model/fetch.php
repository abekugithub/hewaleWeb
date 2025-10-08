<?php
ob_start();
include("../../../../config.php");
include("../../../../library/engine.Class.php");
//include "../platform.php";
//include("../../../../library/patient.Class.php");
$engine = new engineClass();
$patientCls = new patientClass();
$objdtls = $engine->getFacilityDetails();
$faccode = $objdtls->FACI_CODE;
$facilityalias = $objdtls->FACI_ALIAS ;
$last = !empty($_SESSION['lasttxfetch']) ?  $_SESSION['lasttxfetch']  : date('Y-m-d H:i:s') ;

//die($objdtls->FACI_CODE);
$stmt = $sql->Execute($sql->Prepare("SELECT DISTINCT PRESCM_VISITCODE,PRESCM_PATIENT,PRESCM_PATIENTNUM,PRESCM_DATE,PRESCM_STATUS,PRESCM_PICKUPCODE,PRESCM_COUR_NAME,PRESCM_STATE,BRO_STATUS,BRO_IMAGENAME,BRO_VISITCODE,BRO_STATE,PRESCM_PACKAGECODE FROM hms_patient_prescription_main JOIN hms_broadcast_prescription ON PRESCM_VISITCODE=BRO_VISITCODE WHERE PRESCM_STATUS IN ('1','2') AND BRO_PHARMACYCODE = ".$sql->Param('a')." AND BRO_STATUS IN ('1','2')"),array($faccode));
print $sql->ErrorMsg();
$ress = [];
if(!$sql->ErrorMsg()){
    if($stmt->RecordCount()>0){
        $num = 1;
        while ($obj = $stmt->FetchNextObject()){
            $res = '';
            $res = '<tr>
                        <td>'.$num++.'</td>
                        <td>'.date("d/m/Y",strtotime($obj->PRESCM_DATE)).'</td>
                        <td>'.$obj->PRESCM_ITEMCODE.'</td>
                        <td>'.$obj->PRESCM_PATIENT.'</td>
                        <td>'.$obj->PRESCM_PATIENTNUM.'</td>
						<td>'.(!empty($patientCls->getPatientDetails($obj->PRESCM_PATIENTNUM)->PATIENT_GENDER)?$patientCls->getPatientDetails($obj->PRESCM_PATIENTNUM)->PATIENT_GENDER=='M'?'Male':'Female':'').'</td>
						<td>'.(!empty($patientCls->getPatientDetails($obj->PRESCM_PATIENTNUM)->PATIENT_DOB)?$engine->calculateAge($patientCls->getPatientDetails($obj->PRESCM_PATIENTNUM)->PATIENT_DOB):'N/A').'</td>
						<td>';
            if ($obj->BRO_STATUS == 1) {    //Pending for Preparation
                $res .= '<label class="label label-success">New</label>';
            } elseif ($obj->BRO_STATUS == 2) {  //Prepared but Pending Patient Payment
                $res .= '<label class="label label-danger">Pending...</label>';
            }
                    $res .= '</td>
						<td>';
            if($obj->BRO_STATE==1) {    // Prescription From Doctors
                if ($obj->BRO_STATUS == 1) {    //Pending for Preparation
                    $res .= '<button type="submit" class="btn btn-success btn-square"
                            onclick="document.getElementById(\'view\').value=\'prepareprescription\';document.getElementById(\'keys\').value=\''.$obj->PRESCM_PACKAGECODE .'\';document.getElementById(\'viewpage\').value=\'presdetails\';document.myform.submit();">Prepare</button>&nbsp;<button type="button" class="btn btn-danger btn-square"
                            onclick="confirmSubmit(\'Are you sure you want to delete this prescription.\',\'Yes\',function() {
                             document.getElementById(\'view\').value=\'\';document.getElementById(\'keys\').value=\''.$obj->PRESCM_PACKAGECODE .'\';document.getElementById(\'viewpage\').value=\'deletefrombroadcastlist\';document.myform.submit(); 
                            })">Delete</button>';
                } elseif ($obj->BRO_STATUS == 2) {  //Prepared but Pending Patient Payment
                    $res .= '<button type="submit" class="btn btn-success btn-square"
                            onclick="document.getElementById(\'view\').value=\'viewpresc\';document.getElementById(\'keys\').value=\''.$obj->PRESCM_PACKAGECODE .'\';document.getElementById(\'viewpage\').value=\'viewpresc\';document.getElementById(\'data\').value=\'hide\';document.myform.submit();">View</button>&nbsp;<button type="button" class="btn btn-danger btn-square" onclick="confirmSubmit(\'Are you sure you want to delete this prescription.\',\'Yes\',function() {
                            document.getElementById(\'view\').value=\'\';document.getElementById(\'keys\').value=\''.$obj->PRESCM_PACKAGECODE .'\';document.getElementById(\'viewpage\').value=\'deletefrombroadcastlist\';document.myform.submit();
})">Delete</button>';
                }
            }elseif($obj->BRO_STATE==3) {    // Prescription From Text
                if ($obj->BRO_STATUS == 1) {    //Pending for Preparation
                    $res .= '<button type="submit" class="btn btn-success btn-square"
                            onclick="document.getElementById(\'view\').value=\'prepareimage\';document.getElementById(\'keys\').value=\''.$obj->PRESCM_VISITCODE .'\';document.getElementById(\'viewpage\').value=\'preparetextprescription\';document.myform.submit();">Prepare</button>&nbsp;<button type="button" class="btn btn-danger btn-square"
                            onclick="confirmSubmit(\'Are you sure you want to delete this prescription.\',\'Yes\',function() {
                            document.getElementById(\'view\').value=\'\';document.getElementById(\'keys\').value=\''.$obj->PRESCM_VISITCODE .'\';document.getElementById(\'viewpage\').value=\'deletefrombroadcastlist\';document.myform.submit();
})">Delete</button>';
                } elseif ($obj->BRO_STATUS == 2) {  //Prepared but Pending Patient Payment
                    $res .= '<button type="submit" class="btn btn-success btn-square"
                            onclick="document.getElementById(\'view\').value=\'viewprepareimage\';document.getElementById(\'keys\').value=\''.$obj->PRESCM_PACKAGECODE .'\';document.getElementById(\'viewpage\').value=\'viewpresc\';document.myform.submit();">View</button>&nbsp;<button type="button" class="btn btn-danger btn-square" onclick="confirmSubmit(\'Are you sure you want to delete this prescription.\',\'Yes\',function() {
                            document.getElementById(\'view\').value=\'\';document.getElementById(\'keys\').value=\''.$obj->PRESCM_PACKAGECODE .'\';document.getElementById(\'viewpage\').value=\'deletefrombroadcastlist\';document.getElementById(\'imagename\').value=\''.$obj->BRO_IMAGENAME.'\';document.myform.submit();
})">Delete</button>';
                }
            }else{  //Prescription From Image
                if ($obj->BRO_STATUS == 1) {    //Pending for Preparation
                    $res .= '<button type="submit" class="btn btn-success btn-square"
                            onclick="document.getElementById(\'view\').value=\'prepareimage\';document.getElementById(\'keys\').value=\''.$obj->PRESCM_VISITCODE .'\';document.getElementById(\'viewpage\').value=\'imageprepare\';document.getElementById(\'imagename\').value=\''.$obj->BRO_IMAGENAME.'\';document.myform.submit();">Prepare</button>&nbsp;<button type="button" class="btn btn-danger btn-square" onclick="confirmSubmit(\'Are you sure you want to delete this prescription.\',\'Yes\',function() {
                            document.getElementById(\'view\').value=\'\';document.getElementById(\'keys\').value=\''.$obj->PRESCM_VISITCODE .'\';document.getElementById(\'viewpage\').value=\'deletefrombroadcastlist\';document.getElementById(\'imagename\').value=\''.$obj->BRO_IMAGENAME.'\';document.myform.submit();
})">Delete</button>';
                } elseif ($obj->BRO_STATUS == 2) {  //Prepared but waiting for Patient Payment
                    $res .= '<button type="submit" class="btn btn-success btn-square"
                            onclick="document.getElementById(\'view\').value=\'viewprepareimage\';document.getElementById(\'keys\').value=\''.$obj->PRESCM_VISITCODE .'\';document.getElementById(\'viewpage\').value=\'viewimage\';document.getElementById(\'imagename\').value=\''.$obj->BRO_IMAGENAME.'\';document.getElementById(\'data\').value=\'hide\';document.myform.submit();">View</button>&nbsp;<button type="button" class="btn btn-danger btn-square" onclick="confirmSubmit(\'Are you sure you want to delete this prescription.\',\'Yes\',function() {
                            document.getElementById(\'view\').value=\'\';document.getElementById(\'keys\').value=\''.$obj->PRESCM_PACKAGECODE .'\';document.getElementById(\'viewpage\').value=\'deletefrombroadcastlist\';document.getElementById(\'imagename\').value=\''.$obj->BRO_IMAGENAME.'\';document.myform.submit();
})">Delete</button>';
                }
            }
						$res .= '</td></tr>';

            $ress[] = $res;
        }
    }else{
        $ress[] = '<tr><td colspan="10">No Record found...</td></tr>';
    }

    echo json_encode($ress);
}
?>