    <div class="main-content">

        <div class="page-wrapper">

            <?php $engine->msgBox($msg,$status); ?>

            <div class="page form">
                <div class="moduletitle">
                    <div class="moduletitleupper">Add Roles &amp; Positions</div>
                </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label for="fname">Position:</label>
                                <input type="text" class="form-control" id="prole" name="prole" value="<?php echo $prole;?>" autocomplete="off" >
                            </div>
                            
                            
                               <div class="col-sm-12">
                               
                            </div>  
                            
                                 <div class="col-sm-12">
                                <label for="userlevel">User Level:</label>
                               
                                 
                                   <select name="userlevel" id="userlevel" class="form-control" required>
                                     <option>Select Level</option>
                                     <?php 
									 $stmtlevel = $engine->getUserLevelLoading();
									 while($objlvl = $stmtlevel->FetchNextObject()){
									 ?>
                                     <option value="<?php echo $objlvl->FACLV_ID ?> "  <?php echo (($userlevel == $objlvl->FACLV_ID)?'Selected':'') ?>><?php echo $objlvl->FACLV_USRLEVEL;?></option>
                                     <?php } ?>
                                 </select>
                                 
                            </div>
                            
                   
                        </div>
                       
                        
            
                        <div class="form-group">
   
                          <div class="col-sm-12">
                                <label for="othername">Description:</label>                                 
                                 <textarea class="form-control" cols="20" name="descrpt" id= "descrpt">
                                 <?php echo $descrpt ;?>
                                 </textarea>
                                 
                            </div>
                            
                            <div class="col-sm-12">
                                 <label for="status">Status</label>

                            
                            <select class="form-control" name="usrstatus" id="usrstatus">
                                <option value="0" <?php echo (($usrstatus == 0)?'Selected':'') ?>>Disable</option>
                                <option value="1" <?php echo (($usrstatus == 1)?'Selected':'') ?>>Enable</option>
                            </select>
                            </div>
       
                        </div>
              
                    
<div class="btn-group">
                            <div class="col-sm-12">
                                 <button type="submit" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='saverole';document.myform.submit;" class="btn btn-info"><i class="fa fa-plus-circle"></i> Save </button>
                                <button type="submit" class="btn btn-danger" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit;">Cancel</button>
                            </div>
                        </div>
                        
                    </div>

                    

            </div>
        </div>
    </div>

  