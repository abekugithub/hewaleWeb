

    <div class="main-content">

        <div class="page-wrapper">


            

            <!-- <div class="page-lable lblcolor-page">Table</div>-->
            <div class="page form">
                <div class="moduletitle" style="margin-bottom:0px;">
                    <div class="moduletitleupper">Patient Vitals History</div>
                </div>
			<?php $engine->msgBox($msg,$status); ?>
                <div class="pagination-tab">
                    <div class="table-title">
                        <div class="col-sm-3">
                            <div id="pager">
                                
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" tabindex="1" value="<?php echo $fdsearch; ?>" class="form-control square-input" name="fdsearch"  placeholder="patient number"
                                />
                                <span class="input-group-btn">
                                            <button type="submit" onclick="document.getElementById('view').value='vitalhistory';document.getElementById('viewpage').value='searchvitalh';document.myform.submit;" class="btn btn-default btn-gyn-search"> <i class="fa fa-search"></i> </button>
                                            
                                            
                                            
                                        </span>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <button type="submit" onclick="document.getElementById('view').value='vitalhistory';
                        	        document.getElementById('viewpage').value='vitalhistory';document.myform.submit;" class="btn btn-success btn-square"> <i class="fa fa-refresh"></i> </button>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            
                        </div>
                        <div class="pagination-right">
                            <!-- <button type="submit" onclick="document.getElementById('view').value='vitals';document.myform.submit;" class="btn btn-info"><i class="fa fa-plus-circle"></i> Add Dispensary </button> -->
                        </div>
                    </div>
                </div>


                

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Vital Date</th>
                            <th>Patient No.</th>
                            <th>Patient Name</th>
                            <th>Service</th>
                           <th width="170">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
						
                 $num = 1;
                  if($stmt->RecordCount() > 0 ){
                           while($obj = $stmt->FetchNextObject()){
						$objname=$patient->getPatientDetails($obj->VITALS_PATIENTNO);
						
                   echo '<tr>
                        <td>'.$num++.'</td>
						<td>'.$obj->VITALS_INPUTEDDATE.'</td>
                        <td>'.$obj->VITALS_PATIENTNO.'</td>
						<td>'.$objname->PATIENT_FNAME.' '.$objname->PATIENT_MNAME.' '.$objname->PATIENT_LNAME.'</td>
                        <td>'.$obj->VITALS_SERVICE.'</td>
						<td><button class="btn btn-info" type="submit" onclick="document.getElementById(\'keys\').value=\''.$obj->VITALS_VISITCODE.'@@'.$obj->VITALS_REQUCODE.'\';document.getElementById(\'viewpage\').value=\'vitalview\';document.getElementById(\'view\').value=\'vitalview\';document.myform.submit;">View Details</button>
                        </td>
                    </tr>';
					}}
					?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>


    <!-- Modal -->
<div id="addDesp" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="submit" id="acceptLab" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit;" class="btn btn-dark"><i class="fa fa-arrow-left"></i> Back </button>
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