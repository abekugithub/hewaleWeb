<div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Add Component Form <span class="pull-right">
                   
                    <button class ="btn btn-dark" onclick="document.getElementById('view').value='';document.myform.submit;"><i class="fa fa-arrow-left"></i> Back</button>
                    </span>
                </div>
            </div>
            
                <div class="col-sm-12 paddingclose">
                    <div class="form-group">
                        <div class="moduletitleupper"> </div>
                        <div class="col-sm-12 personalinfo-info">

                            <div class="form-group">
                <div class="col-sm-3 required">
                    <label class="control-label" for="fname">Component Name</label>
                    <input type="text" class="form-control" id="componentname" name="componentname" value="<?php echo $componentname;?>">
                </div>
                <div class="col-sm-3 required">
                    <label for="othername">Type </label>
                    <select class="form-control" name="type" id="type">
                            <option value="" disabled selected hidden>Select Type</option>
                            <option value="1" >Earning</option>
                            <option value="2">Deduction</option>
                           
                    </select>
                </div>
                <div class="col-sm-3">
                    <label for="email">Added To</label>
                    <select class="form-control" name="added" id="added">
                            <option value="" disabled selected hidden>Select One</option>
                            <option value="1" >Total Payable</option>
                            <option value="2">Cost to Company</option>
                           
                    </select>
                </div>
                
                <div class="col-sm-3">
                    <label for="phonenumber">Value Type</label>
                    <select class="form-control" name="valuetype" id="valuetype">
                            <option value="" disabled selected hidden>Select One</option>
                            <option value="1" >Amount</option>
                            <option value="2">Percentage</option>
                           
                    </select>
                </div>
            </div>
            

            <div class="btn-group pull-right">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-success" onClick="document.getElementById('viewpage').value='insertcomponent';document.myform.submit();"><i class="fa fa-save"></i> Submit</button>
                    
                </div>
            </div>

                        </div>
                    </div>
                </div>

        </div>
    </div>
    
    
        
    
