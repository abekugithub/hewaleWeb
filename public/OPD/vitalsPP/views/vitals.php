<div class="main-content">
    <div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Vitals Form <span class="pull-right">
                   <button type="submit" id="acceptLab" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit;" class="btn btn-dark"><i class="fa fa-arrow-left"></i> Back </button>
                    </span>
                </div>
            </div>
            <p id="msg" class="alert alert-danger" hidden></p>
            <div class="col-sm-2">
                <div class="id-photo">
                    <img src="<?php echo SHOST_PASSPORT; ?><?php echo isset($image)?$image:'avatar.png';?>" alt="" id="prevphoto" style="width:100% !important; margin:0px !important;">
                </div>
            </div>
            <div class="col-sm-10">
                <div class="form-group">
                    <div class="col-sm-12 client-info">
                            <table class="table client-table">
                                <tr>
                                    <td><b>Name:</b> <?php echo $client->REQU_PATIENT_FULLNAME;?></td>
                                    <td><b>Request Date:</b> <?php echo $client->REQU_DATE;?></td>
                                    <td><b>Patient No.:</b> <?php echo $client->REQU_PATIENTNUM;?></td>
                                </tr>
                                <tr>
                                    <td><b>Request Officer:</b> <?php echo $client->REQU_ACTORNAME;?></td>
                                    <td><b>Service Name:</b> <?php echo $client->REQU_SERVICENAME;?></td>
                                    <td><b>Age:</b> <?php echo $patientage;?></td>
                                </tr>
                            </table>
                        
                    </div>
                </div>
                
				<input id="patientcode" name="patientcode" value="<?php echo $client->REQU_PATIENTCODE;?>" type="hidden" />
                <input id="patientno" name="patientno" value="<?php echo $client->REQU_PATIENTNUM;?>" type="hidden" />
                <input id="patient" name="patient" value="<?php echo $client->REQU_PATIENT_FULLNAME;?>" type="hidden" />
                <input id="reqdate" name="reqdate" value="<?php echo $client->REQU_DATE;?>" type="hidden" />
                <input id="doctor" name="doctor" value="<?php echo $client->REQU_DOCTORNAME;?>" type="hidden" />
                <input id="actor" name="actor" value="<?php echo $client->REQU_ACTORNAME;?>" type="hidden" />
                <input id="paymenttype" name="paymenttype" value="<?php echo $client->REQU_PAYMETNAME;?>" type="hidden" />
                <input id="servicename" name="servicename" value="<?php echo $client->REQU_SERVICENAME;?>" type="hidden" />
                <input id="regcode" name="regcode" value="<?php echo $client->REQU_CODE;?>" type="hidden" />
                <input id="visitcode" name="visitcode" value="<?php echo $client->REQU_VISITCODE;?>" type="hidden" />
                <input id="dateadded" name="dateadded" value="<?php echo date("Y-m-d");?>" type="hidden" />

                <div class="form-group">
                    <div class="col-sm-12 client-vitals-opt">
                    <div class="col-sm-4 required">
                        <label class="control-label" for="fname">Vitals Type</label>
                        <select class="form-control" name="vitals_type" id="vitals_type">
                            <option value="" disabled selected hidden>---------</option>
                            <?php
			 				    while($obj1 = $stmtoptions->FetchNextObject()){
							?>
   <option value="<?php echo $obj1->VIT_NAME; ?>"  <?php echo (($obj1->VIT_NAME == $vitals_type)?'selected="selected"':'') ;?> > <?php echo $obj1->VIT_NAME; ?></option>
    <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-4 required">
                        <label for="othername">Value</label>
                        <input type="text" class="form-control" id="vitals-value" name="vitals-value">
                    </div>
                    <div class="btn-group">
                        <div class="col-sm-4 ">
                            <label for="othername">&nbsp;</label>
                            <button type="button" onclick="addvitals();" class="btn btn-info "><i class="fa fa-plus-circle"></i> Add</button>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12 client-vitals">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Vital Type</th>
                                    <th>Value</th>
                                    <th width="50">Action</th>
                                </tr>
                            </thead>
                            <tbody id="vitalsdata">
                                <!-- Table data goes here from JS.php -->
                            </tbody>
                        </table>    
                    </div>
                </div>

            </div>
            <div class="btn-group pull-right">
                <div class="col-sm-12">
                    <button type="button" class="btn btn-success" onclick="saveVitals();">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
