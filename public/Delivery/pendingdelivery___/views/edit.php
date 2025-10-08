<?php
//echo $delstatus;exit;
?>

  <div class="main-content">
    <div class="page-wrapper">

      <!-- <div class="page-lable lblcolor-page">Table</div>-->
      <div class="page form">
        <div class="moduletitle" style="margin-bottom:0px;">
          <?php if ($delstatus == '4') {?>
          <div class="moduletitleupper">View Pending Delivery Of:
            <?php echo $patientname;?>
          </div>
          <?php }else { ?>
          <div class="moduletitleupper">View Processed Delivery Of:
            <?php echo $patientname;?>
          </div>
          <?php } ?>
        </div>
        <div class="pagination-tab">
          <div class="table-title">
            <div class="pagination-right">
              <?php if ($delstatus == '4') {?>
             <!-- <button type="button" data-toggle="modal" data-target="#addDesp" class="btn btn-info"><i class="fa fa-check-circle-o "></i> Process </button>-->

              <button type="button" class="btn btn-dark" onclick="document.getElementById('viewpage').value='';document.getElementById('view').value='';document.myform.submit();"><i class="fa fa-arrow-left"></i> Back </button>

              <?php }else { ?>
             <!-- <button type="button" class="btn btn-success" onclick="document.getElementById('viewpage').value='updatedelivery';document.myform.submit();"><i class="fa fa-asl-interpreting "></i> Delivered </button>-->

              <button type="button" class="btn btn-danger" onclick="document.getElementById('viewpage').value='';document.getElementById('view').value='';document.myform.submit();"><i class="fa fa-arrow-left"></i> Back </button>
              <?php } ?>
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
                      <?php echo $patientname;?>
                    </td>
                    <td><b>Contact No:</b>
                      <?php echo $patientcontact;?>
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
                        <?php echo $pharmname; ?>
                      </td>
                      <td><b>Location:</b>
                        <?php echo $pharmloc; ?>
                      </td>
                      <td><b>Date:</b>
                        <?php echo $pharmdate; ?>
                      </td>
                    </tr>
                  </table>

                </div>
              </div>
          </div>
      </div>
      
      
      <div class="col-sm-12 deliveredtrack">
      		<?php if($delstatus == '4') {?>
            <ol class="progtrckr" data-progtrckr-steps="3">
        <li class="progtrckr-done"> Processing</li><!--
     --><li class="progtrckr-todo">In Transit</li><!--
     --><li class="progtrckr-todo">Delivered</li>
    </ol>
      <?php }elseif($delstatus == '5') {?>
      
      
            <ol class="progtrckr" data-progtrckr-steps="3">
        <li class="progtrckr-done"> Processing</li><!--
     --><li class="progtrckr-done">In Transit</li><!--
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
      

      <div class="col-sm-12">
        <div class="moduletitleupper">Drugs Information </div>
        <table class="table table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Drugs</th>
              <th>Quantity</th>
              <th>Dosage Type</th>
              
            </tr>
          </thead>
          <tbody>
            <?php
                 
                    if($stmtpris->RecordCount()>0){
                      $num = 1;
                      while($obj = $stmtpris->FetchNextObject()){
                    
                   echo '<tr>
                        <td>'.$num++.'</td>
                        <td>'.$encaes->decrypt($obj->PRESC_DRUG).'</td>
                        <td>'.$obj->PRESC_QUANTITY.'</td>
                        <td>'.$obj->PRESC_DOSAGENAME.'</td>
						
						
                    </tr>';
										}
                    }else{
                        echo '<tr><td>No Record found...</td></tr>';
                    }
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
  
  
  
  
