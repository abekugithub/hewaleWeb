    <div class="main-content">

        <div class="page-wrapper">

            <?php $engine->msgBox($msg,$status); ?>

            <div class="page form">
                <div class="moduletitle">
                    <div class="moduletitleupper">Manage Consumables - Pricing</div>
                </div>
                    
				
					<div class="col-sm-4">
                        
							
                        <label>Consumables</label><br />
                         
						<select name="consumables" id="consumables" class="form-control" tabindex="2"><option value="<?php echo $consumables; ?>"> -- Select consumables --</option>
							<?php while($obj = $stmtconsumableslov->FetchNextObject()){  ?>
							<option value="<?php echo $obj->CS_CODE.'@@@'.$obj->CS_NAME ;?>" <?php echo (($obj->CS_CODE == $consumables)?'selected':'' )?> ><?php echo $obj->CS_NAME ;?></option>
							<?php } ?> 

						</select>
						  
                    </div>
					
					<div class="col-sm-4">
                        
							
                        <label>Method</label><br />
                         
						<select name="paymeth" id="paymeth" class="form-control" tabindex="2"><option value="<?php echo $paymeth; ?>"> -- Select Method --</option>
							<?php while($obj = $stmtpayschemelov->FetchNextObject()){  ?>
							<option value="<?php echo $obj->PAYM_CODE.'@@@'.$obj->PAYM_NAME ;?>" <?php echo (($obj->PAYM_CODE == $paymeth)?'selected':'' )?> ><?php echo $obj->PAYM_NAME ;?></option>
							<?php } ?> 

						</select>
						  
                    </div>
                    
					
					<div class="col-sm-4">
                        <label for="fname">Price:</label>
                        <input type="text" class="form-control" id="price" name="price" value="<?php echo $price;?>" autocomplete="off" >
                    </div>
                        

                        
                            <div class="col-sm-12">
                                 <button type="submit" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='updateprice';document.myform.submit;" class="btn btn-info"><i class="fa fa-plus-circle"></i> Apply Changes </button>
                                <button type="submit" class="btn btn-danger" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit;">Cancel</button>
                            </div>
                       
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