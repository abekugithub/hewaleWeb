
<input id="patient" name="patientname" value="<?php echo $patientname; ?>" type="hidden" />
<input id="patientnum" name="patientnum" value="<?php echo $patientnum; ?>" type="hidden" />
<input id="patientdate" name="patientdate" value="<?php echo $patientdate; ?>" type="hidden" />
<input id="visitcode" name="visitcode" value="<?php echo $visitcode; ?>" type="hidden" />
<input type="hidden" class="form-control" id="patientno" name="patientno" value="<?php echo $patientno[0]; ?>" readonly>

<div class="main-content">
  <div class="page-wrapper">
    <div class="page form">
      <div class="moduletitle" style="padding-bottom:0 !important">
        <div class="moduletitleupper" style="font-size:17px; font-weight:500;">Medical History For <?php  $dataobj=$patientCls->getPatientDetails($patientno[0]);echo $dataobj->PATIENT_FNAME." ".$dataobj->PATIENT_MNAME." ".$dataobj->PATIENT_LNAME; ?> [ <?php echo  $patientno[0] ;?>] <span class="pull-right">
         
          
          <button type="button"  class="btn btn-dark" onclick="document.getElementById('view').value='history';document.getElementById('viewpage').value='history';document.myform.submit()" ><i class="fa fa-arrow-left"></i> Back </button>
          </span> </div>
      </div>
      <div class="col-sm-12">
        <div class="form-group">
          <div class="page-wrapper">
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#complains">Complains</a></li>
               <li><a data-toggle="tab" href="#vitals">Vitals</a></li>
              <li><a data-toggle="tab" href="#labs">Lab.</a></li>
              <li><a data-toggle="tab" href="#diagnosis">Diagnosis</a></li>
              <li><a data-toggle="tab" href="#presciption">Prescription</a></li>
              <li><a data-toggle="tab" href="#management">Management</a></li>
            </ul>
            <div class="page form">
              <div class="tab-content">
                <div id="complains" class="tab-pane fade in active">
                  <div class="form-group">
                    <div class="col-sm-12 required">
                      <table class="table table-responsive table-bordered" id="tblcomplain">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Complain</th>
                            <th>Actor</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
					if($stmtpc->RecordCount() > 0){
						$num = 1;
						while($obj  = $stmtpc->FetchNextObject()){
						
						?>
                          <tr>
                            <td><?php echo $num++; ?></td>
                            <td><?php echo $obj->PC_DATE; ?></td>
                            <td><?php echo $encaes->decrypt($obj->PC_COMPLAIN); ?></td>
                            <td><?php echo $obj->PC_ACTORNAME; ?></td>
                          </tr>
                          <?php
						  
						}
					}else{
						?>
                        <tr><td colspan="4">
                        No Complain History
                        </td></tr>
                        <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                
                    <div id="actions" class="tab-pane fade">
                  <div class="form-group">
                    <div class="col-sm-12 required"> </div>
                  </div>
                </div>
                
                <div id="vitals" class="tab-pane">
                  <div class="form-group">
                    <div class="col-sm-12 required">
                      <table class="table table-responsive table-bordered" id="tblcomplain">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Vital Type</th>
                             <th>Value</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
					if($stmtvt->RecordCount() > 0){
						$num = 1;
						while($objvt  = $stmtvt->FetchNextObject()){
						
						?>
                          <tr>
                            <td><?php echo $num++; ?></td>
                             <td><?php echo date('Y-m-d',strtotime($objvt->VITDET_DATEADDED));?></td>
                            <td><?php echo $objvt->VITDET_VITALSTYPE;?></td>
                             <td><?php echo $objvt->VITDET_VITALSVALUE;?></td>
                          </tr>
                          <?php
						  
						}
					}else{
						?>
                        <tr><td colspan="5">
                        No Vitals History
                        </td></tr>
                        <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div id="labs" class="tab-pane fade">
                  <table class="table table-responsive table-bordered" id="tbllabs">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Lab. Test</th>
                        <th>Clinical Remark</th>
                        <th>Actor</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
					if($stmtlt->RecordCount() > 0){
						$num = 1;
						while($obj  = $stmtlt->FetchNextObject()){
						
						?>
                          <tr>
                            <td><?php echo $num++; ?></td>
                            <td><?php echo $obj->LT_DATE; ?></td>
                            <td><?php echo $encaes->decrypt($obj->LT_TESTNAME); ?></td>
                            <td><?php echo $encaes->decrypt($obj->LT_RMK); ?></td>
                            <td><?php echo $obj->LT_ACTORNAME; ?></td>
                          </tr>
                          <?php
						  
						}
					}
					else{
						?>
                        <tr><td colspan="5">
                        No Lab Test History
                        </td></tr>
                        <?php } ?>
                    </tbody>
                  </table>
                </div>
                <div id="diagnosis" class="tab-pane fade">
                  <div class="controls controls-row" style="margin-bottom:10px;"> </div>
                  <table class="table table-responsive table-bordered" id="tbldiagnosis">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Diagnosis</th>
                        <th>Remark</th>
                        <th>Actor</th>
                      </tr>
                    </thead>
                    <tbody>
                    	<?php 
					if($stmtdia->RecordCount() > 0){
						$num = 1;
						while($obj  = $stmtdia->FetchNextObject()){
						
						?>
                          <tr>
                            <td><?php echo $num++; ?></td>
                            <td><?php echo $obj->DIA_DATE; ?></td>
                            <td><?php echo $encaes->decrypt($obj->DIA_DIAGNOSIS); ?></td>
                            <td><?php echo $encaes->decrypt($obj->DIA_RMK); ?></td>
                            <td><?php echo $obj->DIA_ACTORNAME; ?></td>
                          </tr>
                          <?php
						  
						}
					}else{
						?>
                        <tr><td colspan="5">
                        No Diagnosis History
                        </td></tr>
                        <?php } ?>
                    </tbody>
                  </table>
                </div>
                <div id="presciption" class="tab-pane fade">
                  <div class="controls controls-row" style="margin-bottom:10px;"> </div>
                  <table class="table table-responsive table-bordered" id="tblprescription">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Prescription</th>
                        <th>Days</th>
                        <th>Frequency</th>
                        <th>Times</th>
                        <th>Actor</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
					if($stmtp->RecordCount() > 0){
						$num = 1;
						while($obj  = $stmtp->FetchNextObject()){
						
						?>
                          <tr>
                            <td><?php echo $num++; ?></td>
                            <td><?php echo date('Y-m-d',strtotime($obj->PRESC_DATE))?></td>
                            <td><?php echo $encaes->decrypt($obj->PRESC_DRUG); ?></td>
                            <td><?php echo $obj->PRESC_DAYS; ?></td>
                            <td><?php echo $obj->PRESC_FREQ; ?></td>
                            <td><?php echo $obj->PRESC_TIMES; ?></td>
                            <td><?php echo $obj->PRESC_ACTORNAME; ?></td>
                          </tr>
                          <?php
						  
						}
					}else{
						?>
                        <tr><td colspan="7">
                        No Prescription History 
                        </td></tr>
                        <?php } ?>
                    </tbody>
                  </table>
                </div>
                
                <div id="management" class="tab-pane fade">
                  <div class="controls controls-row" style="margin-bottom:10px;"> </div>
                  <table class="table table-responsive table-bordered" id="tbldiagnosis">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Management</th>
                        <th>Actor</th>
                      </tr>
                    </thead>
                    <tbody>
                    	<?php 
					if($stmtmgnt->RecordCount() > 0){
						$num = 1;
						while($objm  = $stmtmgnt->FetchNextObject()){
						
						?>
                          <tr>
                            <tr>
                                <td><?php echo $n++; ?></td>
                                <td><?php echo $objm->PM_DATE;?></td>
                                <td><?php echo $encaes->decrypt($objm->PM_MANAGEMENT);?></td>
                                <td><?php echo $objm->PM_ACTORNAME;?></td>
                                
                            </tr>
                          </tr>
                          <?php
						  
						}
					}else{
						?>
                        <tr><td colspan="5">
                        No Diagnosis History
                        </td></tr>
                        <?php } ?>
                    </tbody>
                  </table>
                </div>
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function goBack() {
    window.history.back();
}
</script>