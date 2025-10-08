<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 8/25/2017
 * Time: 11:59 AM
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

$stmtcheck=$sql->Execute($sql->Prepare("SELECT COU_ID from hms_courieragents WHERE COU_CODE=".$sql->Param('a')." AND COU_INSTCODE=".$sql->Param('b').""),array($usrcode,$activeinstitution));
		if ($stmtcheck->RecordCount()>0){
			$courieragent='Yes';
		}else{
			$courieragent='No';
		}
		
			if (empty($agent_name) ){
				//If the user is an agent
				if ($courieragent=='Yes'){
//if (!empty($txtarea)){
		$from = date("Y-m-d",strtotime($datefrom));
		$to = date("Y-m-d",strtotime($dateto));
	$stmt = $sql->Execute($sql->Prepare("SELECT COB_CODE,COB_PHARMACY,COB_DELIVERYLOCATION,COB_PATIENT,COB_PATIENTPHONENUM,COB_TRACKINGCODE,COB_DATE,COB_AGENT,CASE COB_STATUS WHEN '0' THEN 'CANCELLED' WHEN '1' THEN 'PENDING' WHEN '2' THEN 'ASSIGNED' WHEN '3' THEN 'PICKED UP' WHEN '4' THEN 'DELIVERED' END COB_STATUS FROM hmsb_courier_basket WHERE COB_COURIERCODE =".$sql->Param('a')." AND COB_DATE >= ".$sql->Param('a')." AND COB_DATE   <= ".$sql->Param('a')." AND COB_AGENTCODE=".$sql->Param('a').""),array($activeinstitution,$from,$to,$usrcode));
		 if ($stmt->RecordCount()>0){
		 	while ($obj=$stmt->FetchNextObject()){
		 		$data_array[$obj->COB_CODE]=array('COB_PHARMACY'=>$obj->COB_PHARMACY,'COB_DELIVERYLOCATION'=>$obj->COB_DELIVERYLOCATION,'COB_PATIENT'=>$obj->COB_PATIENT,'COB_PATIENTPHONENUM'=>$obj->COB_PATIENTPHONENUM,'COB_TRACKINGCODE'=>$obj->COB_TRACKINGCODE,'COB_DATE'=>$obj->COB_DATE,'COB_AGENT'=>$obj->COB_AGENT,'COB_STATUS'=>$obj->COB_STATUS);
		 	}
		 }
	    print $sql->ErrorMsg();
	      //$result = array();
     
        if(is_array($data_array) && count($data_array)>0){
        	$number=1;
        	
		$result.= '<br><table class="table table-hover" >
                    <thead>
                    	<th colspan="3">Agent : '. $usrname.'</th>
                    	<th colspan="3">From : '. $from.'</th>
                    	<th colspan="3">To : '. $to.'</th>
                    	
                        <tr>
                            <th>#</th>
                            <th width="200px">Pharmacy</th>
                            <th width="400px">Patient Name</th>
                            <th width="200px">Patient Contact</th>
                            <th width="200px">Tracking Code</th>
                            <th width="200px">Date&Time</th>
                            <th width="200px">Status</th>
                            
                            
                        </tr>
                        </thead>
                    <tbody>';
					$num = 1;
                   foreach ($data_array as $value){  
					
                   $result.='<tr><td>'.$num++.'</td>
                        <td>'.$value['COB_PHARMACY'].'</td>
                        <td>'.$value['COB_PATIENT'].'</td>
                        <td>'.$value['COB_PATIENTPHONENUM'].'</td>
                        <td>'.$value['COB_TRACKINGCODE'].'</td>
                        <td>'.$value['COB_DATE'].'</td>
                        <td>'.$value['COB_STATUS'].'</td>
                        </tr>';
                   }
					$result.='
                    </tbody>
                </table>
                </br>
                </br>
                ';$number++;}else{
                $result.='<table class="table table-hover" >
                <tbody>
                <tr>
                <td colspan="6">No record found.</td>
				</tr>
				</tbody>
				</table>
				';
                };
                
       
		echo $result;
				}
				//If the user is not an agent
				elseif ($courieragent=='No'){
					
//if (!empty($txtarea)){
		$from = date("Y-m-d",strtotime($datefrom));
		$to = date("Y-m-d",strtotime($dateto));
	$stmt = $sql->Execute($sql->Prepare("SELECT COB_CODE,COB_PHARMACY,COB_DELIVERYLOCATION,COB_PATIENT,COB_PATIENTPHONENUM,COB_TRACKINGCODE,COB_DATE,COB_AGENT,CASE COB_STATUS WHEN '0' THEN 'CANCELLED' WHEN '1' THEN 'PENDING' WHEN '2' THEN 'ASSIGNED' WHEN '3' THEN 'PICKED UP' WHEN '4' THEN 'DELIVERED' END COB_STATUS FROM hmsb_courier_basket WHERE COB_COURIERCODE =".$sql->Param('a')." AND COB_DATE >= ".$sql->Param('a')." AND COB_DATE   <= ".$sql->Param('a').""),array($activeinstitution,$from,$to));
		 if ($stmt->RecordCount()>0){
		 	while ($obj=$stmt->FetchNextObject()){
		 		$data_array[$obj->COB_CODE]=array('COB_PHARMACY'=>$obj->COB_PHARMACY,'COB_DELIVERYLOCATION'=>$obj->COB_DELIVERYLOCATION,'COB_PATIENT'=>$obj->COB_PATIENT,'COB_PATIENTPHONENUM'=>$obj->COB_PATIENTPHONENUM,'COB_TRACKINGCODE'=>$obj->COB_TRACKINGCODE,'COB_DATE'=>$obj->COB_DATE,'COB_AGENT'=>$obj->COB_AGENT,'COB_STATUS'=>$obj->COB_STATUS);
		 	}
		 }
	    print $sql->ErrorMsg();
	  
        if(is_array($data_array) && count($data_array)>0){
        	$number=1;
        	
		$result.= '<br><table class="table table-hover" >
                    <thead>
                    	<th colspan="3">From : '. $from.'</th>
                    	<th colspan="3">To : '. $to.'</th>
                    	
                        <tr>
                            <th>#</th>
                            <th width="200px">Pharmacy</th>
                            <th width="400px">Patient Name</th>
                            <th width="200px">Patient Contact</th>
                            <th width="200px">Tracking Code</th>
                            <th width="200px">Date&Time</th>
                            <th width="200px">Agent</th>
                            <th width="200px">Status</th>
                            
                            
                        </tr>
                        </thead>
                    <tbody>';
					$num = 1;
                   foreach ($data_array as $value){  
					
                   $result.='<tr><td>'.$num++.'</td>
                        <td>'.$value['COB_PHARMACY'].'</td>
                        <td>'.$value['COB_PATIENT'].'</td>
                        <td>'.$value['COB_PATIENTPHONENUM'].'</td>
                        <td>'.$value['COB_TRACKINGCODE'].'</td>
                        <td>'.$value['COB_DATE'].'</td>
                        <td>'.$value['COB_AGENT'].'</td>
                        <td>'.$value['COB_STATUS'].'</td>
                        </tr>';
                   }
					$result.='
                    </tbody>
                </table>
                </br>
                </br>
                ';$number++;}else{
                $result.='<table class="table table-hover" >
                <tbody>
                <tr>
                <td colspan="6">No record found.</td>
				</tr>
				</tbody>
				</table>
				';
                };
                
       
		echo $result;
    //}
//}
					
				}
    //}
//}
}
//if a hewale number is entered
elseif (!empty($agent_name)){
	//echo "BooooooooooooM";
	//die(); 
	$agent_name=!empty($agent_name)?explode('|',$agent_name):'';
		$from = date("Y-m-d",strtotime($datefrom));
		$to = date("Y-m-d",strtotime($dateto));
	$stmt = $sql->Execute($sql->Prepare("SELECT COB_CODE,COB_PHARMACY,COB_DELIVERYLOCATION,COB_PATIENT,COB_PATIENTPHONENUM,COB_TRACKINGCODE,COB_DATE,COB_AGENT,CASE COB_STATUS WHEN '0' THEN 'CANCELLED' WHEN '1' THEN 'PENDING' WHEN '2' THEN 'ASSIGNED' WHEN '3' THEN 'PICKED UP' WHEN '4' THEN 'DELIVERED' END COB_STATUS FROM hmsb_courier_basket WHERE COB_COURIERCODE =".$sql->Param('a')." AND COB_AGENTCODE=".$sql->Param('a')." AND COB_DATE >= ".$sql->Param('a')." AND COB_DATE   <= ".$sql->Param('a').""),array($activeinstitution,$agent_name[0],$from,$to));
		 if ($stmt->RecordCount()>0){
		 	while ($obj=$stmt->FetchNextObject()){
		 		$data_array[$obj->COB_CODE]=array('COB_PHARMACY'=>$obj->COB_PHARMACY,'COB_DELIVERYLOCATION'=>$obj->COB_DELIVERYLOCATION,'COB_PATIENT'=>$obj->COB_PATIENT,'COB_PATIENTPHONENUM'=>$obj->COB_PATIENTPHONENUM,'COB_TRACKINGCODE'=>$obj->COB_TRACKINGCODE,'COB_DATE'=>$obj->COB_DATE,'COB_AGENT'=>$obj->COB_AGENT,'COB_STATUS'=>$obj->COB_STATUS);
		 	}
		 }
	    print $sql->ErrorMsg();
	   
        
        if(is_array($data_array) && count($data_array)>0){
        	$number=1;
        	
		$result.= '<br><table class="table table-hover" >
                    <thead>
                    	<th colspan="3">Agent:'.$agent_name[1].'</th>
                    	<th colspan="3">From : '. $from.'</th>
                    	<th colspan="3">To : '.$to.'</th>
                    	
                        <tr>
                            <th>#</th>
                            <th width="200px">Pharmacy</th>
                            <th width="400px">Patient Name</th>
                            <th width="200px">Patient Contact</th>
                            <th width="200px">Tracking Code</th>
                            <th width="200px">Date</th>
                            <th width="200px">Status</th>
                            
                            
                        </tr>
                        </thead>
                    <tbody>';
					$num = 1;
                   foreach ($data_array as $value){  
					
                   $result.='<tr><td>'.$num++.'</td>
                        <td>'.$value['COB_PHARMACY'].'</td>
                        <td>'.$value['COB_PATIENT'].'</td>
                        <td>'.$value['COB_PATIENTPHONENUM'].'</td>
                        <td>'.$value['COB_TRACKINGCODE'].'</td>
                        <td>'.$value['COB_DATE'].'</td>
                        <td>'.$value['COB_STATUS'].'</td>
                        </tr>';
                   }
					$result.='
                    </tbody>
                </table>
                </br>
                </br>
                ';$number++;}else{
                $result.='<table class="table table-hover" >
                <tbody>
                <tr>
                <td colspan="6">No record found.</td>
				</tr>
				</tbody>
				</table>
				';
                };
                
       
		echo $result;
    //}
//}
	
	
}
?>