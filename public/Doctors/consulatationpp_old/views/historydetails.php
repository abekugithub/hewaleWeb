
<input id="patient" name="patientname" value="<?php echo $patientname; ?>" type="hidden" />
<input id="patientnum" name="patientnum" value="<?php echo $patientnum; ?>" type="hidden" />
<input id="patientdate" name="patientdate" value="<?php echo $patientdate; ?>" type="hidden" />
<input id="visitcode" name="visitcode" value="<?php echo $visitcode; ?>" type="hidden" />

<div class="main-content">
  <div class="page-wrapper">
    <div class="page form">
      <div class="moduletitle" style="padding-bottom:0 !important">
        <div class="moduletitleupper" style="font-size:17px; font-weight:500;">History Details <span class="pull-right">
          
          <button type="button"  class="btn btn-dark" onclick="goBack()" ><i class="fa fa-arrow-left"></i> Back </button>
          </span> </div>
      </div>
      <div class="col-sm-12">
        <div class="form-group">
          <div class="page-wrapper">
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#complains">Complains</a></li>
              <li><a data-toggle="tab" href="#labs">Lab Request</a></li>
              <li><a data-toggle="tab" href="#diagnosis">Diagnosis</a></li>
              <li><a data-toggle="tab" href="#presciption">Prescription</a></li>
              <li><a data-toggle="tab" href="#audio">Audio</a></li>
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
					}
						?>
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
						?>
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
					}
						?>
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
                            <td><?php echo $obj->PRESC_DATE; ?></td>
                            <td><?php echo $encaes->decrypt($obj->PRESC_DRUG); ?></td>
                            <td><?php echo $obj->PRESC_DAYS; ?></td>
                            <td><?php echo $obj->PRESC_FREQ; ?></td>
                            <td><?php echo $obj->PRESC_TIMES; ?></td>
                            <td><?php echo $obj->PRESC_ACTORNAME; ?></td>
                          </tr>
                          <?php
						  
						}
					}
						?>
                    </tbody>
                  </table>
                </div>
                <div id="audio" class="tab-pane fade">
                <?php if($stmtaud->RecordCount()>0){
                while ($obj = $stmtaud->FetchNextObject()){
                ?> 
                 <audio controls><source src="media/uploads/<?php echo $obj->AUD_CODE;?>" type="audio/ogg"> </audio>
                 <?php }}else{?>
                 No audio available.
                 <?php }?>
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