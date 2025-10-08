    <div class="main-content">

        <div class="page-wrapper">

            <div class="page form">
                <div class="moduletitle">
                    <div class="moduletitleupper">Select Courier Services 
                    
                    
                     <span class="pull-right">
                    <button type="submit" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='savecourierselection';document.myform.submit;" class="btn btn-success"><i class="fa fa-plus-circle"></i> Save </button>
                    <button type="submit" class="btn btn-danger" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit;">Cancel</button>
                 </span>
                    
                    </div>
                    
                  
                </div>
                    
				
                
                <div class="form-group">
					<label class="col-md-3 control-label"></label>
				    <div class="col-md-12">
					<table class="table table-striped table-bordered table-hover table-full-width" id="sample_2">
							<thead>
							<tr>
								<th>
									<div align="center">#</div>
								</th>
								<th>
									Courier Services
								</th>
                                <th>
									Location
								</th>
                                <th>
									Contact
								</th>
								
								
							</tr>
							</thead>
							<tbody>
                            
                             <?php
			
			$num = 1;
								if($stmtcourierbranches->RecordCount() > 0 ){
								while($obj = $stmtcourierbranches->FetchNextObject()){
                            echo '
							<tr>
					        <td><input type="checkbox" value="'.$obj->FACI_CODE.'" name="courierservice[]" id=""></td>
								<td>'.$obj->FACI_NAME.'</td>
								<td>'.$obj->FACI_LOCATION.'</td>
								<td>'.$obj->FACI_PHONENUM.'</td>
	
							</tr>';
			 						}
								}

							?>
							</tbody>
							</table>
														
													</div>
                                                    
                                                    
                                                    
												</div>
                
                
                
                    
             <div class="btn-group" style="float:right;">

                <div class="col-sm-12">
                    <button type="submit" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='savecourierselection';document.myform.submit;" class="btn btn-success"><i class="fa fa-plus-circle"></i> Save </button>
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