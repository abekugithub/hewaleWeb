<?php
//echo $delstatus;exit;
?>

  <div class="main-content">
    <div class="page-wrapper">

    <input type="hidden"  name="prescriptioncode" class="form-control" value="<?php echo  $prescriptioncode ;?>"  >
    <input type="hidden"  name="pickupcode" class="form-control" value="<?php echo  $pickupcode ;?>"  >
    <input type="hidden"  name="dat" class="form-control" value="<?php echo  $dat ;?>"  >

    <input type="hidden"  name="patient" class="form-control" value="<?php echo  $patient ;?>"  >
    <input type="hidden"  name="patientnum" class="form-control" value="<?php echo  $patientnum ;?>"  >
    <input type="hidden"  name="phone" class="form-control" value="<?php echo  $phone ;?>"  >

    <input type="hidden"  name="deliverylocation" class="form-control" value="<?php echo  $deliverylocation ;?>"  >
    <input type="hidden"  name="visit" class="form-control" value="<?php echo  $visit ;?>"  >
    <input type="hidden"  name="pharmacy" class="form-control" value="<?php echo  $pharmacy ;?>"  >

    <input type="hidden"  name="pharmacyloc" class="form-control" value="<?php echo  $pharmacyloc ;?>"  >
    <input type="hidden"  name="pharmacyphone" class="form-control" value="<?php echo  $pharmacyphone ;?>"  >
    <input type="hidden"  name="agent" class="form-control" value="<?php echo  $agent ;?>"  >

    <input type="hidden"  name="delstatus" class="form-control" value="<?php echo  $delstatus ;?>"  >
               

      <!-- <div class="page-lable lblcolor-page">Table</div>-->
      <div class="page form">
        <div class="moduletitle" style="margin-bottom:0px;">
          
          <div class="moduletitleupper">Pending Delivery For:
            <?php echo $patient;?>  
            <span class="pull-right">
           
            <button type="button" class="btn btn-danger" onclick="document.getElementById('viewpage').value='';document.getElementById('view').value='';document.myform.submit();"><i class="fa fa-arrow-left"></i> Back </button>
            </span>
          </div>
         
         
         
        </div>
		
            
        <div class="pagination-tab">
          <div class="table-title">
            <div class="pagination-left">
            
                <div class="col-sm-4">
                    <label class="control-label" for="leavetype">Assign:</label>
                    <select name="agent" id="agent" class="form-control select2"><option value="<?php echo $agent; ?>"> -- Select Assign -- </option>
  
   								<?php while($objdpt = $stmtagents->FetchNextObject()){  ?>
  								<option value="<?php echo $objdpt->COU_USERCODE.'@@@'.$objdpt->COU_FNAME.' '.$objdpt->COU_SURNAME ;?>" <?php echo (($objdpt->COU_USERCODE == $agent)?'selected':'' )?> ><?php echo $objdpt->COU_FNAME.' '.$objdpt->COU_SURNAME ;?></option>
   								<?php } ?>    
       							</select>
                    
                </div>
				
               <label class="control-label" for="leavetype">.</label><br />
				<button type="button" class="btn btn-success" onclick="document.getElementById('viewpage').value='assign';document.getElementById('view').value='';document.myform.submit();"> Save </button> 
 
              </div>
            </div>
           
        </div>
        <div class="col-sm-12">
          <div class="col-sm-6">
            <div class="form-group">
              <div class="moduletitleupper">Client Information </div>
              <div class="col-sm-12 personalinfo-info">
              <div class="col-sm-12">
                <div class="form-group">    
                  <b>Client:</b>
                      <?php echo $patient;?>
                    
                </div>
                <div class="form-group">    
                  <b>Contact Num:</b>
                      <?php echo $phone;?>
                    
                </div>
                <div class="form-group">    
                  <b>Pickup Code:</b>
                      <?php echo $pickupcode;?>
                  
                </div>
                <div class="form-group">    
                  <b>Prescription Code:</b>
                      <?php echo $prescriptioncode;?>
               
                </div>
                </div>
                </div>
            </div>
          </div>

          <div class="col-sm-6">
            <div class="form-group">
                <div class="moduletitleupper">Pharmacy </div>
                <div class="col-sm-12 personalinfo-info">

                <div class="col-sm-12">
                
                <div class="form-group">    
                  <b>Pharmacy:</b>
                      <?php echo $pharmacy;?>
                    
                </div>
                <div class="form-group">    
                  <b>Location:</b>
                      <?php echo $pharmacyloc;?>
                    
                </div>
                <div class="form-group">    
                  <b>Phone:</b>
                      <?php echo $pharmacyphone;?>
                  
                </div>
                  

                </div>
              </div>
          </div>
      </div>
      
      
      <div class="col-sm-12 deliveredtrack">
      		<?php if($delstatus == '1') {?>
            <ol class="progtrckr" data-progtrckr-steps="5">
        <li class="progtrckr-done"> Pending</li><!--
    --><li class="progtrckr-todo">Assign</li><!--
     --><li class="progtrckr-todo">Awaiting Pickup</li><!--
	 --><li class="progtrckr-todo">Pickup In Transit</li><!--
     --><li class="progtrckr-todo">Delivered</li>
    </ol>
      <?php }elseif($delstatus == '2') {?>
      
      
      <ol class="progtrckr" data-progtrckr-steps="5">
      <li class="progtrckr-done"> Pending</li><!--
      --><li class="progtrckr-done"> Assigned</li><!--
    --><li class="progtrckr-todo">Awaiting Pickup</li><!--
	 --><li class="progtrckr-todo">Pickup In Transit</li><!--
     --><li class="progtrckr-todo">Delivered</li>
    </ol>
    
    <?php }elseif($delstatus == '6') {?>
      
      
            <ol class="progtrckr" data-progtrckr-steps="3">
        <li class="progtrckr-done"> Processing</li><!--
     --><li class="progtrckr-done">In Transit</li><!--
     --><li class="progtrckr-done">Delivered</li>
    </ol>
      <?php }?>
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
  
  
  
  
