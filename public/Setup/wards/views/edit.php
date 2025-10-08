    <div class="main-content">

        <div class="page-wrapper">

            

            <div class="page form">
                <div class="moduletitle">
                    <div class="moduletitleupper">SETUP WARD - EDIT </div>
                </div>
                    
				<?php $engine->msgBox($msg,$status); ?>
				<div class="col-sm-12">
					<div class="col-sm-3">
                        <label for="fname">Ward:</label>
                        <input type="text" class="form-control" id="ward" name="ward" value="<?php echo $ward;?>" autocomplete="off" >
                    </div>
					<div class="col-sm-3">
                        <label for="fname">Gender:</label>
						<select name="gender" class="form-control"><option value=''><?php echo $gend; ?></option><option value=''>--Select Gender--</option><option value='Male'>Male</option><option value='Female'>Female</option><option value='Any'>Any</option></select>
                        
                    </div>
					
				</div>
                    
					
					
					
                        
				<div class="col-sm-12">	
                     <div class="btn-group pull-right">
                <div class="col-sm-12">
                   
                    <button type="submit" onclick="document.getElementById('viewpage').value='editward';document.myform.submit;" class="btn btn-success">Apply Changes</button>
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