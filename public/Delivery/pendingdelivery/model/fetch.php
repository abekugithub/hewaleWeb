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
$userCourier = $engine->getActorCourier();
$ccode = $engine->getparcelcode();
$agentcode = $engine->getActorCode();
$last = !empty($_SESSION['lasttxfetch']) ?  $_SESSION['lasttxfetch']  : date('Y-m-d H:i:s') ;

//die($objdtls->FACI_CODE);
//$query = "SELECT DISTINCT COB_TRACKINGCODE,COB_PATIENT, COB_PATIENTCODE,COB_PATIENTNUM,COB_DATE, COB_VISITCODE,COB_PICKUPCODE,COB_PHARMACYCODE,COB_PHARMACY,COB_PHARMACYLOCATION,COB_STATUS,COB_PRESCRIPTIONCODE FROM hmsb_courier_basket WHERE  COB_COURIERCODE = ".$sql->Param('1')." AND COB_STATUS IN ('1') "; $input = array($userCourier);
//$stmt = $sql->Execute($sql->Prepare("SELECT DISTINCT PRESC_VISITCODE,PRESC_PATIENT,PRESC_PATIENTNUM,DATE(PRESC_DATE) AS PRESC_INPUTEDDATE,PRESC_STATUS,PRESC_PICKUPCODE,PRESC_COUR_NAME,PRESC_STATE,BRO_STATUS,BRO_IMAGENAME,BRO_VISITCODE,BRO_STATE,PRESC_PACKAGECODE FROM hms_patient_prescription JOIN hms_broadcast_prescription ON PRESC_VISITCODE=BRO_VISITCODE WHERE BRO_PHARMACYCODE = ".$sql->Param('a')." AND BRO_STATUS IN ('1','2')"),array($faccode));
	
$stmt = $sql->Execute($sql->Prepare("SELECT DISTINCT COB_TRACKINGCODE,COB_PATIENT, COB_PATIENTCODE,COB_PATIENTNUM,COB_DATE, COB_VISITCODE,COB_PICKUPCODE,COB_PHARMACYCODE,COB_PHARMACY,COB_PHARMACYLOCATION,COB_STATUS,COB_PRESCRIPTIONCODE FROM hmsb_courier_basket WHERE  COB_COURIERCODE = ".$sql->Param('1')." AND COB_STATUS IN ('1') "),array($userCourier));
print $sql->ErrorMsg();
$ress = [];
if(!$sql->ErrorMsg()){
    if($stmt->RecordCount()>0){
        $num = 1;
        while ($obj = $stmt->FetchNextObject()){
			$delievery = $obj->COB_STATUS;

						   $delstatus = "";
						   
						   if ($delievery == '1') {
							    $delstatus = 'Pending';
							    }elseif ($delievery == '2') {
								$delstatus = 'Assigned';
							    }elseif ($delievery == '3') {
                                $delstatus = 'In Transit';
                                }elseif ($delievery == '4') {
								$delstatus = 'Delivered';
							   }
            $res = '';
            $res = '<tr>
            <td>'.$num++.'</td>
            <td>'.$obj->COB_PATIENT.'</td>
            <td>'.$obj->COB_PICKUPCODE.'</td>
            <td>'.$obj->COB_PRESCRIPTIONCODE.'</td>
            <td>'.$obj->COB_PHARMACY.'</td>
            <td>'.$obj->COB_PHARMACYLOCATION.'</td>
            <td>'.$obj->COB_DATE.'</td>
            
            
            <td>'.$delstatus.'</td>
            <td><button class="btn btn-primary" type="button" onClick="document.getElementById(\'view\').value=\'details\';document.getElementById(\'viewpage\').value=\'details\';document.getElementById(\'keys\').value=\''.$obj->COB_PRESCRIPTIONCODE.'\';document.myform.submit()"><span class="fa fa-pencil"></span> Details</button></td>
            </tr>';

            $ress[] = $res;
        }
    }else{
        $ress[] = '<tr><td colspan="10">No Record found...</td></tr>';
    }

    echo json_encode($ress);
}
?>