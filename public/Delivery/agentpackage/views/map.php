<div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Delivery Map <span class="pull-right">
                <input type="hidden"  name="patient" class="form-control" value="<?php echo  $patient ;?>"  >
                <input type="hidden"  name="patientnum" class="form-control" value="<?php echo  $patientnum ;?>"  >
                <input type="hidden"  name="pickupcode" class="form-control" value="<?php echo  $pickupcode ;?>"  >
                <input type="hidden"  name="pharmacy" class="form-control" value="<?php echo  $pharmacy ;?>"  >
                <input type="hidden"  name="pharmacyloc" class="form-control" value="<?php echo  $pharmacyloc ;?>"  >
                <input type="hidden"  name="prescriptioncode" class="form-control" value="<?php echo  $prescriptioncode ;?>"  >
                <input type="hidden"  name="pharmacyphone" class="form-control" value="<?php echo  $pharmacyphone ;?>"  >
                <input type="hidden"  name="keys" class="form-control" value="<?php echo  $keys ;?>"  >
             
                <button type="button" class="btn btn-dark" onclick="document.getElementById('viewpage').value='';document.getElementById('view').value='';document.myform.submit();"><i class="fa fa-arrow-left"></i> Back </button>
       
                    </span>
                </div>
            </div>
            <?php $engine->msgBox($msg,$status); ?>
                <div class="col-sm-12 paddingclose">
                    <div class="form-group">
                        <div class="moduletitleupper"> </div>
                        <div class="col-sm-12 personalinfo-info">

                            <div class="form-group">
               

                <div class="btn-group pull-right">
                <div class="col-sm-12">
                   
                    <button type="button" class="btn btn-success" onclick="document.getElementById('viewpage').value='deliverycheck';document.getElementById('view').value='';document.myform.submit();"> Submit </button>
            
                </div>
            </div>
              
                
            </div>
            

           

                        </div>
                    </div>
                </div>

        </div>
    
    <div class="page form">
        <div class="moduletitle" style="margin-bottom:0px;">
          
          <div class="moduletitleupper">Delivery for:
            <?php echo $patient;?>
          </div>
         
        </div>
        <div class="pagination-tab">
          <div class="table-title">
            <div class="pagination-right">
              
              Assigned to : <?php echo $agentnam;?> 
              
            </div>
          </div>
        </div>
        <div class="col-sm-12">
          <div class="col-sm-6">
            <div class="form-group">
              <div class="moduletitleupper">Personal Information </div>
              <div class="col-sm-12 personalinfo-info">

                <table class="table personalinfo-table">
                  <tr>
                    <td><b>Name:</b>
                      <?php echo $patient;?>
                    </td>
                   
                    
                    <td><b>Pickup Code:</b>
                      <?php echo $pickupcode;?>
                    </td>
                   
                  </tr>
                </table>

              </div>
            </div>
          </div>

          <div class="col-sm-6">
            <div class="form-group">
                <div class="moduletitleupper">Pharmacy </div>
                <div class="col-sm-12 personalinfo-info">

                  <table class="table personalinfo-table">
                    <tr>
                      <td><b>Pharmacy:</b>
                        <?php echo $pharmacy; ?>
                      </td>
                      <td><b>Location:</b>
                        <?php echo $pharmacyloc; ?>
                      </td>
                      <td><b>Contact:</b>
                        <?php echo $pharmacyphone; ?>
                      </td>
                    </tr>
                  </table>

                </div>
              </div>
          </div>
      </div>
     
      <div class="col-sm-12 deliveredtrack">
      <ol class="progtrckr" data-progtrckr-steps="4">
        <li class="progtrckr-done"> Pending</li><!--
    --><li class="progtrckr-done">Assign</li><!--
     --><li class="progtrckr-done">In Transit</li><!--
     --><li class="progtrckr-todo">Delivered</li>
      </div>

      <div class="col-sm-12">
        <div class="moduletitleupper">Medication Information </div>
        <table class="table table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Medication</th>
              <th>Quantity</th>
             
            </tr>
          </thead>
          <tbody>
            <?php
                 
                    if($stmtpris->RecordCount()>0){  
                      $num = 1;
                      while($obj = $stmtpris->FetchNextObject()){
                    
                   echo '<tr>
                        <td>'.$num++.'</td>
                        <td>'.$obj->COB_MEDICATION.'</td>
                        <td>'.$obj->COB_QTY.'</td>
                       				
                    </tr>';
										}}
					  ?>
          </tbody>
        </table>


      </div>
    </div>
  </div>
  </div>

<!-- Modal -->


  <!-- Modal -->
  <div id="addDesp" class="modal fade" role="dialog">
  <div class="modal-dialog"> 
    
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Schedule Delivery Time</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
                            <div class="col-sm-8">
                                <label for="fname">Date:</label>
                               <!-- <input type="text" class="form-control" id="date" name="consultdate" value="<?php// echo $consultdate;?>" autocomplete="off" required> -->
                                <input class="form-control" id="date" name="startdate" placeholder="dd/mm/yyyy" type="text" required/>
                                <input class="form-control" id="date" name="newkeys" placeholder="" type="hidden" value="<?php echo $keys;?>" />
                            </div>


<div class="input-group clockpicker">
                            <div class="col-sm-8">
                                <label for="time">Time:</label>
                                <input type="text" id="clockpicker" name="inputtime" class="form-control" value="<?php echo  $inputtime ;?>" required placeholder="09:30">
                            </div>
        </div>                    
                            &nbsp;
                        <div class="col-sm-8">
                                <label for="fname">Assign To:</label>
                              <select class="form-control" name="agents" id="agents">
                            <option value="" disabled selected hidden>Select Agent</option>
                            <?php
			 				    while($obj = $stmtagents->FetchNextObject()){
							?>
   <option value="<?php echo $obj->COU_CODE; ?>"  <?php echo (($obj->COU_CODE == $agents)?'selected="selected"':'') ;?> > <?php echo $obj->COU_FNAME ." ".$obj->COU_SURNAME; ?></option>
    <?php } ?>
                        </select>
                            </div>  
                           
                        </div>
           
           
           <div class="form-group">
                          <div class="col-sm-8">
                          &nbsp;
                          <br />
                          </div>
                          
                         <div class="col-sm-8">
                                 <button type="button" class="btn btn-success btn-square" data-dismiss="modal" onclick="document.getElementById('viewpage').value='updatecourierprocess';document.myform.submit();">Save</button>
        <button type="button" class="btn btn-danger btn-square" data-dismiss="modal">Cancel</button>
                            </div> 
                           
                        </div>
                        
                        
      </div>
   
      <div class="modal-footer">
      
      </div>
    </div>
  </div>
</div>
  
    
        
    
