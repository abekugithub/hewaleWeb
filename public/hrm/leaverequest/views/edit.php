<div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Edit Leave Request Form <span class="pull-right">
                   
                     <button class ="btn btn-dark" onclick="document.getElementById('view').value='';document.myform.submit;"><i class="fa fa-arrow-left"></i> Back</button>
                    </span>
                </div>
            </div>
            
                <div class="col-sm-10 paddingclose">
                    <div class="form-group">
                        
                        <div class="col-sm-12 personalinfo-info">

                            <div class="form-group">
                <div class="col-sm-12 required">
                    <label class="control-label" for="fname">Employee Name</label>
                    <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $fname;?>" readonly>
                </div>
               
                <div class="col-sm-4">
              <label class="control-label" for="leavetype">Leave Type</label>
              <select name="leavetype" id="leavetype" value="" class="form-control ">
                <option value='<?php echo $leavetypecode;?>' disabled selected><?php echo $leavetype; ?></option>
                <?php  while($obj = $stmtleavetype->FetchNextObject()){ ?>
                <option value='<?php echo $obj->LT_CODE; ?>' <?php  echo (($obj->LT_CODE == $leavetype)?"selected":""); ?>>
				<?php echo $obj->LT_NAME; ?></option>
                <?php } ?>
              </select>
            </div>
            </div>
            
                
                
                
                <div class="col-sm-4">
                    <label for="startdate">Leave Start Date</label>
                    <input type="text" class="form-control" id="startdate" name="startdate" value="<?php echo $startdate; ?>" >
                </div>
                
                <div class="col-sm-4">
                    <label for="enddate">Leave End Date</label>
                    <input type="text" class="form-control" id="enddate" name="enddate" value="<?php echo $enddate; ?>" >
                </div>
                            <?php
            
            if ($delievery == '1') {
							   $delstatus = 'Pending';
							   }elseif ($delievery == '0') {
								$delstatus = 'Rejected';
							   }elseif ($delievery == '2') {
								$delstatus = 'Approved';
							   }
						?>
             
           
              
              
              
              <div class="form-group">
            <div class="col-sm-12">
              <label class="control-label" for="leavetype">Leave Reasons</label>
              <textarea  name="reason" ><?php echo $content; ?></textarea>
            </div>
          </div>
                  
                  
                  <div class="btn-group pull-right">
            <div class="col-sm-12">
              <button type="submit" class="btn btn-success" onClick="document.getElementById('viewpage').value='updateleaverequest';document.myform.submit();"><i class="fa fa-save"></i> Submit</button>
            </div>
          </div>
                   
               
               
                
                
                
            </div>

                    

            

                        </div>
                    </div>
                </div>
                
                <div class="col-sm-2">
                   
                </div>
                
                
                
                <div class="col-sm-2">
                   
                </div>
                
                

        </div>
    </div>