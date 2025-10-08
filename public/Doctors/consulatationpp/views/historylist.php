<?php
$rs = $paging->paginate();
?>
    <style>
        .rowdanger {
            background-color: #97181B4D
        }

        .rowwarning {
            background-color: #EBECB9
        }
    </style>
    <div class="main-content notepaper">

        <div class="page-wrapper">

            <input id="patientnum" name="patientnum" value="<?php echo $patientnum; ?>" type="hidden" />
            <?php //$engine->msgBox($msg,$status); ?>

            <!-- <div class="page-lable lblcolor-page">Table</div>-->
            <div class="page form">
                <div class="moduletitle" style="margin-bottom:0px;">
                    <div class="moduletitleupper">Medical History</div>
                </div>
             
				<div class="col-sm-12 conshistoryinfo">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Consultation Date</th>
                            <th>Patient Name</th>
                            <th>Patient Number</th>
                            <th>Status</th>
                            <th width="170">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                 
					if($stmthl->RecordCount() > 0){
						$num = 1;
						while($obj  = $stmthl->FetchNextObject()){
                        
                        //Check if the medical record contains data, specially a complain registered
                        $stmtcp = $sql->Execute($sql->Prepare("SELECT PC_PATIENTNUM FROM hms_patient_complains WHERE PC_VISITCODE = ".$sql->Param('a')." "),array($obj->CONS_VISITCODE));
                        if($stmtcp->RecordCount() > 0){
						
						   $consperiod = $patientCls->getConsultPeriod($obj->CONS_CODE);
						  
                   echo '<tr '.(($consperiod <= 1)?'class=""':(($consperiod <= 2)?'class="rowwarning"':'')).'>
                        <td>'.$num++.'</td>
                        <td>'.date("d/m/Y",strtotime($obj->CONS_DATE)).'</td>
                        <td>'.$obj->CONS_PATIENTNAME.'</td>
                        <td>'.$obj->CONS_PATIENTNUM.'</td>
						
						<td>'.(($obj->CONS_STATUS == 1)?'Pending':(($obj->CONS_STATUS == 2)?'Incomplete':'Complete')).'</td>
						<td>
						<button type="button" class="btn btn-info btn-square" onclick=
"document.getElementById(\'viewpage\').value=\'historydetails\';document.getElementById(\'view\').value=\'historydetails\';document.getElementById(\'keys\').value=\''.$obj->CONS_VISITCODE.'\';document.myform.submit()"> Details</button>
						
                        </td>
                    </tr>';
                        }
					}}
					?>
                    </tbody>
                </table>
                </div>
            </div>

        </div>

    </div>


    <!-- Modal -->
    <div id="addDesp" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Despensary</h4>
                </div>
                <div class="modal-body">
                    <p>Some text in the modal.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-square" data-dismiss="modal">Save</button>
                    <button type="button" class="btn btn-info btn-square" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>