<div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Update Component Form <span class="pull-right">
                   
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
                    
                    	<?php 
						$saltype = $obj->SC_TYPE;
						$saltypestatus = "";
						
							if($saltype == '1'){
								$saltypestatus = "Earning";
							}else{
								$saltypestatus="Deduction";
							}
						
						?>
                    
                    <select class="form-control" name="type" id="type">
                            <option value="$type" disabled selected hidden><?php echo $saltypestatus;?></option>
                            <option value="1" >Earning</option>
                            <option value="2">Deduction</option>
                           
                    </select>
                </div>
                <div class="col-sm-3">
                
                <?php 
						$saladded = $obj->SC_ADDTO;
						$saladdedstatus = "";
						
							if($saladded == '1'){
								$saladdedstatus = "Total Payable";
							}else{
								$saladdedstatus="Cost to Company";
							}
						
						?>
                    <label for="email">Added To</label>
                    <select class="form-control" name="added" id="added">
                            <option value="$added " disabled selected hidden><?php echo $saladdedstatus;?></option>
                            <option value="1" >Total Payable</option>
                            <option value="2">Cost to Company</option>
                           
                    </select>
                </div>
                
                <div class="col-sm-3">
                
                 <?php 
						$valueaddtype = $obj->SC_VALUE;
						$valueaddstatus = "";
						
							if($valueaddtype == '1'){
								$valueaddstatus = "Amount";
							}else{
								$valueaddstatus="Percentage";
							}
						
						?>
                    <label for="phonenumber">Value Type</label>
                    <select class="form-control" name="valuetype" id="valuetype">
                            <option value="valueadd" disabled selected hidden><?php echo $valueaddstatus;?></option>
                            <option value="1" >Amount</option>
                            <option value="2">Percentage</option>
                           
                    </select>
                </div>
            </div>
            

            <div class="btn-group pull-right">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-success" onClick="document.getElementById('viewpage').value='updatecomponent';document.myform.submit();"><i class="fa fa-save"></i> Submit</button>
                    
                </div>
            </div>

                        </div>
                    </div>
                </div>

        </div>
    </div>
    
    
        
    
