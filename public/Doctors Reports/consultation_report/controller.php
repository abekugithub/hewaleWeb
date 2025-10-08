<?php
$actor = $engine->getActorDetails();
$activeinstitution = $actor->USR_ACTIVECC;
//print_r ($_POST);
$usrcode= $actor->USR_CODE;
//echo $usrcode;


switch($viewpage){
	
	case "report":
	$export_url ="public/Doctors Reports/consultation_report/views/export.php?from=".$datefrom."&to=".$dateto."&usrcode=".$usrcode."&activeinstitution=".$activeinstitution;
	    // public\Doctors Reports\consultation_report\views\export.php
	if (!empty($datefrom)&&!empty($dateto)){	
		if (strtotime($datefrom)<=strtotime($dateto)){
		$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hmsb_allfacilities WHERE FACI_CODE =".$sql->Param('a').""),array($activeinstitution));
		$obj = $stmt->FetchNextObject(); 
		
		$report_comp_logo = "media/img/".$obj->FACI_LOGO_UNINAME;
    	$report_comp_name = $obj->FACI_NAME;
    	$report_title = "Consultation Report";
    	$report_comp_location = $obj->FACI_LOCATION;
    	$report_phone_number = $obj->FACI_PHONENUM;
    	 $report_content = '';
    	// $report_content = '';
		//include("model/js.php");





/// the report view begins here ##################

		$from = date("Y-m-d",strtotime($datefrom));
		$to = date("Y-m-d",strtotime($dateto));
// $sql->debug= true;
		$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_consultation WHERE CONS_SCHEDULEDATE >= ".$sql->Param('a')." AND CONS_SCHEDULEDATE   <= ".$sql->Param('a')." AND CONS_DOCTORCODE =".$sql->Param('a').""),array($from,$to,$usrcode));
        print $sql->ErrorMsg();
        
        // $result = array();
        $num = 1;
		
		$result.='<table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Hewale Number</th>
                            <th>Visit Code</th>
                            
                            <th>Date</th>
                            <th>Doctor</th>
                        </tr>
                    </thead>
                    <tbody>';
                       
                 
					if($stmt->RecordCount() > 0){
						$num = 1;
						while($obj  = $stmt->FetchNextObject()){
						  
                   $result.='<td>'.$num++.'</td>
                        <td>'.$obj->CONS_PATIENTNAME.'</td>
                        <td>'.$obj->CONS_PATIENTNUM.'</td>
                        <td>'.$obj->CONS_VISITCODE.'</td>
						
						<td>'.date("d/m/Y",strtotime($obj->CONS_SCHEDULEDATE)).'</td>
						<td>'.$obj->CONS_DOCTORNAME.'</td>
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
                
				$report_content = $result;
		       // echo $report_content;

		}
		else{
			//compare date
		$view ="";
	}
	}else{
		$view ="";
	}
	break;
	
	
}


?>