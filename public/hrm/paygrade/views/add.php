<div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Add Grade Form <span class="pull-right">
                   
                    <button class ="btn btn-dark" onclick="document.getElementById('view').value='';document.myform.submit;"><i class="fa fa-arrow-left"></i> Back</button>
                    </span>
                </div>
            </div>
            
                <div class="col-sm-12 paddingclose">
                    <div class="form-group">
                        <div class="moduletitleupper"> </div>
                        <div class="col-sm-12 personalinfo-info">

                            <div class="form-group">
                <div class="col-sm-4 required">
                    <label class="control-label" for="fname">Grade Name</label>
                    <input type="text" class="form-control" id="gradename" name="gradename" value="<?php echo $gradename;?>">
                </div>
                
                <div class="col-sm-4 required">
                    <label class="control-label" for="fname">Min Salary</label>
                    <input type="text" class="form-control" id="minsalary" name="minsalary" value="<?php echo $minsalary;?>">
                </div>
                
                <div class="col-sm-4 required">
                    <label class="control-label" for="fname">Max Salary</label>
                    <input type="text" class="form-control" id="maxsalary" name="maxsalary" value="<?php echo $maxsalary;?>">
                </div>
                
                
                
                
            </div>
            

            <div class="btn-group pull-right">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-success" onClick="document.getElementById('viewpage').value='insertgrade';document.myform.submit();"><i class="fa fa-save"></i> Submit</button>
                    
                </div>
            </div>

                        </div>
                    </div>
                </div>

        </div>
    </div>
    
    
        
    
