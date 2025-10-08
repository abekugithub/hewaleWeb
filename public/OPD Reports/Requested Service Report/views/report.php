<?php
    $report_comp_logo = "media/img/report-logo.png";
    $report_comp_name = "Hewale Hospital";
    $report_title = "Medical Record";
    $report_comp_location = "P.O.Box AC 123 Achomota Accra.";
    $report_phone_number = "0302 000 123";
    $report_content = '';
?>

<div class="main-content">
    <div class="page-wrapper page form">
        <div class="moduletitle">
            <div class="moduletitleupper">Report
                <span class="pull-right">
                    <button class="form-tools" onclick="document.getElementById('view').value='';document.myform.submit;" style="font-size:18px; padding-top:-10px;" title="Generate Excel">
                        <i class="fa fa-file-excel-o"></i>
                    </button>
                    <button class="form-tools" onclick="document.getElementById('view').value='';document.myform.submit;" style="font-size:18px; padding-top:-10px;" title="Generate PDF">
                        <i class="fa fa-file-pdf-o"></i>
                    </button>
                    <button type="button" class="form-tools print-block" onclick="printDiv('printReport')" style="font-size:18px; padding-top:-10px;" title="Print Document">
                        <i class="fa fa-print"></i>
                    </button>
                    <button class="form-tools" onclick="document.getElementById('view').value='';document.myform.submit;" style="font-size:25px; padding-top:-10px; line-height:1.3em" title="Close">&times;</button>
                </span>
            </div>
        </div>
        <div class="page-report" id="printReport">
            <table>
                <tr class="report-title">
                    <td width="15%">
                        <img src="<?php echo $report_comp_logo; ?>"/>
                        <h5><?php echo $report_comp_name; ?></h5>
                    </td>
                    <td width="60%"><h4><?php echo $report_title; ?></h4></td>
                    <td class="address" width="30%">
                        <span><b>Location:</b> <?php echo $report_comp_location; ?></span><br><br>
                        <span><b>Phone Number:</b> <?php echo $report_phone_number; ?></span><br><br>
                    </td>
                </tr>
                <tr>
                    <td class="report-content">
                        <?php echo $report_content; ?>
                    </td>
                </tr>
            </table>
            
            <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Hewale Number</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Date</th>
                            <th>Actor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                 
					if($stmt->RecordCount() > 0){
						$num = 1;
						while($obj  = $stmt->FetchNextObject()){
						  
                   echo '<td>'.$num++.'</td>
                        <td>'.$obj->PATIENT_FNAME.' '.$obj->PATIENT_MNAME.' '.$obj->PATIENT_LNAME.'</td>
                        <td>'.$obj->PATIENT_PATIENTNUM.'</td>
                        <td>'.$obj->PATIENT_PHONENUM.'</td>
						<td>'.$obj->PATIENT_ADDRESS.'</td>
                        <td>'.$obj->PATIENT_EMAIL.'</td>
						<td>'.date("d/m/Y",strtotime($obj->PATIENT_DATE)).'</td>
						<td>'.$obj->PATIENT_USERCODE.'</td>
                    </tr>';
					}}
					?>
                    </tbody>
                </table>
        </div>
        
    </div>
    
</div>
<script>
   function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}
</script>