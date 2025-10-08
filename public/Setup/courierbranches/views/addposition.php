    <div class="main-content">

        <div class="page-wrapper">

            <?php $engine->msgBox($msg,$status); ?>

            <div class="page form">
                <div class="moduletitle">
                    <div class="moduletitleupper">Add Branch</div>
                </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label for="fname">Branch Name:</label>
                                <input type="text" class="form-control" id="branchname" name="branchname" value="<?php echo $branchname;?>" autocomplete="off" >
                            </div>
                             <div class="col-sm-12">
                                <label for="country">Country:</label>
                               
                                 
                                   <select name="branchcountry" id="branchcountry" class="form-control" required onChange="document.getElementById('viewpage').value='load_regions';document.getElementById('view').value='addposition';document.myform.submit();">
                                     <option>Select Country</option>
                                    <?php
			 				   			 while($obj1 = $stmtcountries->FetchNextObject()){
							?>
   <option value="<?php echo $obj1->CN_ID; ?>"  <?php echo (($obj1->CN_ID == $branchcountry)?'selected="selected"':'') ;?> > <?php echo $obj1->CN_COUNTRY; ?></option>
    <?php } ?>
                                    	
                                 </select>
                                 
                            </div>
                            <?php if (!empty($branchcountry)) {?>
                            <div class="col-sm-12">
                               <label for="region">Region:</label>
                               <select name="inputregions" id="inputelementcode" class="form-control" >
                    		<option value="">Select Region</option>
                            <?php
			 				   			 while($objx = $stmtregions->FetchNextObject()){
							?>
   <option value="<?php echo $objx->REG_CODE; ?>"  <?php echo (($objx->REG_CODE == $inputregions)?'selected="selected"':'') ;?> > <?php echo $objx->REG_NAME; ?></option>
    <?php } ?>
                            
                    
                  </select>
                            </div>
                            <?php } ?>
                               <div class="col-sm-12">
                               <label for="location">Location:</label>
                                <input type="text" class="form-control" id="branchlocation" name="branchlocation" value="<?php echo $branchlocation;?>" autocomplete="off" >
                            </div> 
                            
                            <div class="col-sm-12">
                               <label for="location">Contact Person:</label>
                                <input type="text" class="form-control" id="branchcontact" name="branchcontact" value="<?php echo $branchcontact;?>" autocomplete="off" >
                            </div> 
                            
                            <div class="col-sm-12">
                               <label for="location">Telephone No.:</label>
                                <input type="text" class="form-control" id="branchtelephone" name="branchtelephone" value="<?php echo $branchtelephone;?>" autocomplete="off" >
                            </div>  
                            
                                
                            
                   
                        </div>
                      <div class="btn-group">
                            <div class="col-sm-12">
                                 <button type="submit" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='savebranch';document.myform.submit;" class="btn btn-info"><i class="fa fa-plus-circle"></i> Save </button>
                                <button type="submit" class="btn btn-danger" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit;">Cancel</button>
                            </div>
                        </div>
                        
                    </div>

                    

            </div>
        </div>
    </div>

  