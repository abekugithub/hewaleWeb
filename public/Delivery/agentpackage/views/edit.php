<?php
//echo $delstatus;exit;
?>

  <div class="main-content">
    <div class="page-wrapper">
    <input type="hidden"  name="patient" class="form-control" value="<?php echo  $patient ;?>"  >
    <input type="hidden"  name="phone" class="form-control" value="<?php echo  $phone ;?>"  >
    <input type="hidden"  name="pickupcode" class="form-control" value="<?php echo  $pickupcode ;?>"  >
    <input type="hidden"  name="prescriptioncode" class="form-control" value="<?php echo  $prescriptioncode ;?>"  >
    <input type="hidden"  name="pharmacy" class="form-control" value="<?php echo  $pharmacy ;?>"  >
    <input type="hidden"  name="pharmacyloc" class="form-control" value="<?php echo  $pharmacyloc ;?>"  >
    <input type="hidden"  name="pharmacyphone" class="form-control" value="<?php echo  $pharmacyphone ;?>"  >
    <input type="hidden"  name="agentnam" class="form-control" value="<?php echo  $agentnam ;?>"  >
    <input type="hidden"  name="visitcode" class="form-control" value="<?php echo  $visitcode ;?>"  >
	<input type="hidden"  name="delstatus" class="form-control" value="<?php echo  $delstatus ;?>"  >
     <!-- <div class="page-lable lblcolor-page">Table</div>-->
      <div class="page form">
        <div class="moduletitle" style="margin-bottom:0px;">
          
          <div class="moduletitleupper">Delivery for:
            <?php echo $patient;?>
            <span class="pull-right">
            <div class="form-group">
              <div class="col-sm-12 clientself-video" >
			  <?php if($delstatus == 3) {?>
			  <button type="button" class="btn btn-success" onclick="document.getElementById('viewpage').value='confirmpickup';document.getElementById('view').value='';document.myform.submit();"><i class="fa fa-check"></i> Confirm Pickup </button>
			  
			  <?php  } ?>
			  <!--
               <?php $linkview = 'index.php?pg='.md5('Delivery').'&amp;option='.md5('agentpackage').'&uiid='.md5('1_pop').'&viewpage=getdeliverygeolocation&view=maplocation&keys='.$visitcode; ?>     
              <button type="button" class="btn btn-warning" onClick="CallSmallerWindow('<?php echo $linkview;?>')"><i class="fa fa-map-marker"></i> Start Journey </button>
		-->
    <?php if($delstatus == 4) {?>

    		<button type="button" class="btn btn-warning" onclick="document.getElementById('viewpage').value='getdeliverygeolocation';document.getElementById('view').value='maplocation';document.myform.submit();"><i class="fa fa-map-marker"></i> Start Journey </button>
		
    <?php  } ?>
              <button type="button" class="btn btn-danger" onclick="document.getElementById('viewpage').value='';document.getElementById('view').value='';document.myform.submit();"><i class="fa fa-arrow-left"></i> Back </button>
            </span>
          </div>
          </div>
        </div>
        <?php $engine->msgBox($msg,$status); ?>
        <?php if($delstatus == 4) {?>
                    <div class="form-group">
                    

                        <div class="col-sm-12 personalinfo-info">

                            <div class="form-group">
                <div class="col-sm-4 required">
                    <label class="control-label" for="leavetype">Delivery Code:</label>
                    <input type="text"  name="inputdeliverycode" class="form-control" value="<?php echo  $inputdeliverycode ;?>"  >
                    <button type="button" class="btn btn-success" onclick="document.getElementById('viewpage').value='deliverycheck';document.getElementById('view').value='';document.myform.submit();"> Submit Delivery Code</button>
        
                </div>
                
              
            </div>
			
			
            </div>  
            </div>
            <?php  } ?>
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
              <div class="form-group">    
                <b>Assigned To:</b>
                    <?php echo $agentnam;?>
                
              </div>
             
                

              </div>
            </div>
        </div>
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
  
  
  
  
