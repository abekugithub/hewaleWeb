<div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Add Supplier Form <span class="pull-right">
                   
                    <button type="button" class="btn btn-danger" onclick="document.getElementById('viewpage').value='';document.getElementById('view').value='';document.myform.submit();"><i class="fa fa-arrow-left"></i> Back </button>
                </div>
            </div>
            
                <div class="col-sm-12 paddingclose">
                    <div class="form-group">
                        <div class="moduletitleupper">Supplier Information </div>
                        <div class="col-sm-12 personalinfo-info">

                            <div class="form-group">
                <div class="col-sm-4 required">
                    <label class="control-label" for="fname">Supplier Name</label>
                    <input type="text" class="form-control" id="supplier" name="supplier" value="<?php echo $supplier;?>">
                </div>
                <div class="col-sm-4 required">
                    <label for="othername">Contact Number</label>
                    <input type="text" class="form-control" id="contactno" name="contactno" value="<?php echo $contactno;?>">
                </div>
                <div class="col-sm-4">
                    <label for="email">Company Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $email;?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-4">
                    <label for="phonenumber">Company Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="<?php echo $address;?>">
                </div>
                
                <div class="col-sm-4">
                    <label for="phonenumber">Company Location</label>
                    <input type="text" class="form-control" id="location" name="location" value="<?php echo $location;?>">
                </div>
                
                <div class="col-sm-4">
                    <label for="phonenumber">Supplier Status</label>
                     <select class="form-control" name="supstatus" id="supstatus">
                          
                           
   						 <option value="1" > Enable</option>
                         <option value="0" > Disable</option>
   
                        </select>
                </div>
            </div>
            
            
            <div class="form-group">
                <div class="col-sm-4">
                
                <label for="phonenumber">Contact Person</label>
                    <input type="text" class="form-control" id="date" name="contperson" value="<?php echo $contperson;?>" >
                
                    
                </div>
                
                <div class="col-sm-4">
                
                <label for="phonenumber">Phone Number</label>
                    <input type="number" class="form-control" id="phonenumber" name="phonenumber" value="<?php echo $phonenumber;?>">
                
                    
                </div>
                
                <div class="col-sm-4">
                
                <label for="phonenumber">Email </label>
                    <input type="text" class="form-control" id="peremail" name="peremail" value="<?php echo $peremail;?>">
                
                
                    
                </div>
            </div>
            

            <div class="btn-group pull-right">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-success" onClick="document.getElementById('viewpage').value='insertsupplier';document.linkform.submit();"><i class="fa fa-save"></i> Submit</button>
                    
                </div>
            </div>

                        </div>
                    </div>
                </div>

        </div>
    </div>
    
  
