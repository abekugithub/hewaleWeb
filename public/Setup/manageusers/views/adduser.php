    <div class="main-content">
        <div class="page-wrapper">
            <?php $engine->msgBox($msg,$status); ?>
            <div class="page form">
                <div class="moduletitle">
                    <div class="moduletitleupper">Manage Users
                        <span class="pull-right ">
                            <button class="form-tools" style="font-size:25px; padding-top:-10px;" onclick="document.getElementById('view').value='list';document.myform.submit();">×</button>
                        </span>
                    </div>
                </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-sm-6 required">
                                <label for="fname">Last Name:</label>
                                <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $fname;?>" autocomplete="off" required>
                            </div>
                            <div class="col-sm-6 required">
                                <label for="othername">Other Names:</label>
                                 <input type="text" class="form-control" id="othername" name="othername" value="<?php echo $othername;?>" autocomplete="off" required>
                            </div>
                            
                            <!-- <div class="col-sm-6">
                                <label for="pwd">Username:</label>
                                <input type="text" class="form-control" id="usrname" name="usrname" value="<?php //echo $usrname;?>" autocomplete="off" required>
                            </div> -->
                            
                <div class="col-sm-6 required uniq-user">
                    <label for="username">Username</label>
                    <div class="uniq-left">
                  <input type="text" class="form-control" id="usrname" name="usrname" autocomplete="off" required>
                    </div>
                    <div class="uniq-right">
                    <input type="text" class="form-control" id="alias" name="alias" value="<?php echo '@'.$facilityalias; ?>" readonly>
                    </div>
                </div>
                              
                            <div class="col-sm-6 required">
                                <label for="email">Password</label>
                               <input type="password" class="form-control" id="usrpwd" name="usrpwd" value="<?php echo $usrpwd;?>" autocomplete="off" required>
                            </div>
                            
                            <div class="col-sm-6 required">
                                <label for="email">Phone No.:</label>
                                 <input type="text" class="form-control" id="phoneno" name="phoneno" value="<?php echo $phoneno;?>" autocomplete="off" required>
                            </div>

                           
                        </div>
                        
            
                        <div class="form-group">
                         <div class="col-sm-6">
                                <label for="email">Email</label>
                                 <input type="email" class="form-control" id="email" name="email" value="<?php echo $email;?>" autocomplete="off">
                            </div>
                            
                             <div class="col-sm-6">
                    <label for="altphone">Alternate Phone No.</label>
                    <input type="text" class="form-control" id="altphone" name="altphone" value="<?php echo $altphone;?>" autocomplete="off">
                </div>
                
                <div class="col-sm-6 required">
                    <label for="emcontact">Emergency Contact</label>
                    <input type="text" class="form-control" id="emcontact" name="emcontact" value="<?php echo $emcontact ;?>" autocomplete="off">
                    
                </div>
                
                            <div class="col-sm-6">
                                <label for="email">Address</label>
                                <input type="text" class="form-control" id="address" name="address" value="<?php echo $address;?>" autocomplete="off">
                            </div>
                            
                            <div class="col-sm-6 required">
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
                            
                            <div class="col-sm-6">
                                <label for="userposition">User Position:</label>
                                 <select name="usrposition" id="usrposition" class="form-control">
                                     <option>Select Position</option>
                                     <?php 
									 while($objpos = $stmtpos2->FetchNextObject()){
									 ?>
                                     <option value="<?php echo $objpos->FACPOS_CODE ?>" <?php echo (($usrposition == $objpos->FACPOS_CODE)?'Selected':'') ?>><?php echo $objpos->FACPOS_NAME ;?></option>
                                     <?php } ?>
                                     
                                 </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="status">Status</label>
                                <select class="form-control" name="usrstatus" id="usrstatus">
                                    <option value="0" <?php echo (($usrstatus == 0)?'Selected':'') ?>>Disable</option>
                                    <option value="1" <?php echo (($usrstatus == 1)?'Selected':'') ?>>Enable</option>
                                </select>
                            </div>
                    </div>
              
                    
                    
                    
                    
                    
                    
                    <div class="form-group">
                        <div class="col-sm-12">
                            <label for="status">Department</label>

                            
                            <select class="form-control select2" multiple name="department[]" id="department[]">
                                <option value="" disabled>-- Select Department --</option>
                                <?php
                                while ($dept = $stmtdepartment->FetchNextObj()){?>
                                    <option value="<?php echo $dept->DEPT_CODE; ?>" >
                                        <?php echo $dept->DEPT_NAME; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    
                          
                    
                    

                        <div class="btn-group" style="margin-top:20px;float:right;">
                            <div class="col-sm-12">
                                 <button type="button" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='saveuser';document.myform.submit();" class="btn btn-success"><i class="fa fa-check"></i> Save </button>
                                <button type="submit" class="btn btn-danger" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit;"><i class="fa fa-close"></i> Cancel</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 page-min-block ">
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">Module Accessibilty</legend>
                            
                            <div class="form-group">
                                <div class="gyn-treeview">
                                <ul>
                                    <?php
                                        $num = 1;
                                        $catstmt = $engine->getMenuPreselection($activeinstitution);
                                        while($objcat = $catstmt->FetchNextObject()){
                                            $feaurename = $engine->getFeatureName($objcat->FACFE_MENUCATCODE);
                                    ?>

                                        <li class="has-children">
                                            <input type="checkbox" id="node-0-<?php echo $num ;?>" name="group-<?php echo $num ;?>" id="group-<?php echo $num ;?>">
                                            <label><input type="checkbox" /><span></span></label>
                                            <label for="node-0-<?php echo $num ;?>"><?php echo $feaurename ;?></label>

                                            <ul>
                                                <?php 
                                                $sub =1;
                                                $catsubft = $engine->getSubMenuPreselection($objcat->FACFE_MENUCATCODE);
                                                while($objsubft = $catsubft->FetchNextObject()){
                                                ?>
                                                <li>
                                                <input type="checkbox" id="node-0-<?php echo $sub ;?>-0" name="menubox-<?php echo $sub ;?>"/> 
                                                <label><input type="checkbox" value="<?php echo $objsubft->MENUDET_CODE ?>" name="syscheckbox[<?php echo $objsubft->MENUDET_CODE ; ?>]"/><span></span></label>
                                                <label for="node-0-<?php echo $sub ;?>-0"><a href="#0"><input type="checkbox" name="syscheckbox[<?php echo $objsubft->MENUDET_CODE  ?>]" id="menubox" value="<?php echo $objsubft->MENUDET_CODE ; ?>"> <?php echo $objsubft->MENUDET_NAME ; ?></a></label>
                                                </li>
                                                <?php $sub++; }?>
                                            </ul>
                                        </li>
                                    <?php $num++ ; } ?>
                                </ul>
                                </div>
                            </div>
                        </fieldset>
                    </div>

            </div>
        </div>
    </div>

    <script>
    /* Script to auto select sub tree checkboxes */
        $(".gyn-treeview").delegate("label input:checkbox", "change", function() {    
            var checkbox = $(this),
                nestedList = checkbox.parent().next().next(),
                selectNestedListCheckbox = nestedList.find("label:not([for]) input:checkbox");     
            if (checkbox.is(":checked")) {        
                return selectNestedListCheckbox.prop("checked", true);    
            }    
            selectNestedListCheckbox.prop("checked", false);
        });

    </script>