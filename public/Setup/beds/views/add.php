    <div class="main-content">

        <div class="page-wrapper">

           

            <div class="page form">
                <div class="moduletitle">
                    <div class="moduletitleupper">Bed Setup - Add </div>
                </div>
                     <?php $engine->msgBox($msg,$status); ?>
				<div class="col-sm-12">
					<div class="col-sm-3">
                        <label for="fname">Bed:</label>
                        <input type="text" class="form-control" id="ward" name="bed" value="<?php echo $bed;?>" autocomplete="off" >
                    </div>
					<div class="col-sm-3">
                        <label for="fname">Ward:</label>
						<select name="ward" id="ward" class="form-control" tabindex="2"><option value="<?php echo $ward; ?>"> -- Select ward --</option>
							<?php while($obj = $stmtwardlov->FetchNextObject()){  ?>
							<option value="<?php echo $obj->WARD_CODE.'@@@'.$obj->WARD_NAME.'@@@'.$obj->WARD_GENDER ;?>" <?php echo (($obj->WARD_CODE == $ward)?'selected':'' )?> ><?php echo $obj->WARD_NAME ;?></option>
							<?php } ?> 

						</select>
                    </div>
					
				</div>
                    
					
					
					
                        
				<div class="col-sm-12">	
                     <div class="btn-group pull-right">
                <div class="col-sm-12">
                   
                    <button type="submit" onclick="document.getElementById('viewpage').value='savebed';document.myform.submit;" class="btn btn-success">Save</button>
                    <button type="submit" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit;" class="btn btn-danger">Cancel</button>
                    
                </div>
				</div>    
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