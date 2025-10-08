<div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Update Leave Type Form <span class="pull-right">
                   
                    <button class ="btn btn-dark" onclick="document.getElementById('view').value='';document.myform.submit;"><i class="fa fa-arrow-left"></i> Back</button>
                    </span>
                </div>
            </div>
            
                <div class="col-sm-12 paddingclose">
                    <div class="form-group">
                        <div class="moduletitleupper"> </div>
                        <div class="col-sm-12 personalinfo-info">

                            <div class="form-group">
                <div class="col-sm-6 required">
                    <label class="control-label" for="leavetype">Leave Type</label>
                    <input type="text" class="form-control" id="leavetype" name="leavetype" value="<?php echo $leavetype;?>">
                </div>
                
                
            </div>
            

            <div class="btn-group pull-right">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-success" onClick="document.getElementById('viewpage').value='updateleavetype';document.myform.submit();"><i class="fa fa-save"></i> Submit</button>
                    
                </div>
            </div>

                        </div>
                    </div>
                </div>

        </div>
    </div>
    
    
        
    
