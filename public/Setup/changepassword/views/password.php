<div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Change Password <span class="pull-right">
                   
                    <!--<button onclick="document.getElementById('view').value='';document.myform.submit;">&times;</button>-->
                    </span>
                </div>
            </div>
            
                <div class="col-sm-10 paddingclose">
                    <div class="form-group">
                    <?php $engine->msgBox($msg,$status); ?>
                        <div class="moduletitleupper"></div>
                        
                        <div class="col-sm-12 personalinfo-info">

                            <div class="form-group">
                <div class="col-sm-4 required">
                    <label class="control-label" for="fname">Old Password </label>
                    <input type="password" class="form-control" id="oldpassword" name="oldpassword" value="<?php echo $oldpassword;?>" autocomplete="off">
                </div>
                <div class="col-sm-4 required">
                    <label for="othername">New Password </label>
                    <input type="password" class="form-control" id="inputuserpassword" name="inputuserpassword" value="<?php echo $inputuserpassword;?>" autocomplete="off">
                </div>
                <div class="col-sm-4 required">
                    <label for="email">Confirm Password </label>
                    <input type="password" class="form-control" id="newinputuserpassword" name="newinputuserpassword" value="<?php echo $newinputuserpassword;?>" autocomplete="off">
                </div>
            </div>
            

            <div class="btn-group pull-right">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-success" onClick="document.getElementById('viewpage').value='savepassword';document.myform.submit();"><i class="fa fa-save"></i> Save Password</button>
                    
                </div>
            </div>

                        </div>
                    </div>
                </div>

        </div>
    </div>
    
    
        
    
