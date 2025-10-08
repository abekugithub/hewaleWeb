
<input id="patient" name="patientname" value="<?php echo $patientname; ?>" type="hidden" />
<input id="patientnum" name="patientnum" value="<?php echo $patientnum; ?>" type="hidden" />
<input id="patientdate" name="patientdate" value="<?php echo $patientdate; ?>" type="hidden" />
<input id="visitcode" name="visitcode" value="<?php echo $visitcode; ?>" type="hidden" />

<div class="main-content">
  <div class="page-wrapper">
    <div class="page form">
      <div class="moduletitle" style="padding-bottom:0 !important">
        <div class="moduletitleupper" style="font-size:17px; font-weight:500;">Vital Details <span class="pull-right"></span>
          
          
      </div>
      <div class="col-sm-12">
        <div class="form-group">
                        <div class="moduletitleupper">Personal Information </div>
                        <div class="col-sm-12 personalinfo-info">

                            <table class="table personalinfo-table">
                                <tr>
                                    <td><b>Name:</b> <?php echo $patientname;?></td>
                                    <td><b>Patient Number:</b> <?php echo $patientnum;?></td>
                                    
                                </tr>
                                <tr>
                                    <td><b>Email:</b> <?php echo $patienemail;?></td>
                                    <td><b>Phone Number:</b> <?php echo $patientphone;?></td>
                                    
                                </tr>
                                <tr>
                                    <td><b>Residential Address:</b> <?php echo $patientaddress;?></td>
                                    <td><b>Marital Status:</b> <?php echo $patientmar_status;?></td>
                                    
                                </tr>
                                <tr>
                                    <td><b>Date Of Birth:</b> <?php echo $dob; //$patientbloodgrp;?></td>
                                    <td><b>Gender:</b> <?php echo $patientgender;?></td>
                                  
                                </tr>
                                
                            </table>

                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="moduletitleupper">Vitals </div>
                        <div class="col-sm-12 personalinfo-info">
						 <div class="col-sm-6">
                            <table class="table personalinfo-table">
                            <?php
                 
					if($stmtv->RecordCount() > 0){
						//$num = 1;
						while($obj  = $stmtv->FetchNextObject()){
							?>
                                <tr>
                                    <td><b><?php echo $obj->VITDET_VITALSTYPE;?> :</b></td>
                                    <td><?php echo $obj->VITDET_VITALSVALUE;?></td>
                                    
                                </tr>
                                <?php
                                }}
					?>
                            </table>
							</div>
                        </div>
                    </div>
      </div>
    </div>
  </div>
</div>

