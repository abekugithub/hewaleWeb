<div class="main-content">

        <div class="page-wrapper">

            <?php $engine->msgBox($msg,$status); ?>

            <div class="page form">
                <div class="moduletitle">
                    <div class="moduletitleupper">Registration of stock</div>
                </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                           <div class="col-sm-6">
                                <label for="item">item name:</label>
                                 <select name="item" id="item" class="form-control select2" tabindex="1">
                                    <option value="<?php echo $item; ?>"> --Select Item -- </option>
   								<?php while($objitem = $stmtstockitem->FetchNextObject()){  ?>
  								<option value="<?php echo $objitem->DR_CODE?>" data-dosage="<?php echo $objitem->DR_DOSAGENAME;?>" ><?php echo $objitem->DR_NAME ;?></option>
   								<?php } ?>  
                                     
                                     
                                 </select>
                            </div>
                            
                            <div class="col-sm-6">
                                <label for="dosage">Dosage:</label>
                                 <input type="text" class="form-control" id="dosage" name="dosage" value="" autocomplete="off" readonly  value="<?php echo $dosage;?>">
                            </div>
                            
                            
                            
                           
                            
                
                            <div class="form-group">  
                            <div class="col-sm-6">
                                <label for="level">Alert Stock</label>
                               <input type="text" class="form-control" id="level" name="level" value="<?php echo $level;?>" autocomplete="off">
                            </div>
							</div>
                           
                           

                           
                        </div>
                        
            
                        <div class="form-group">
                         <div class="col-sm-6">
                                <label for="qty">Store Quantity</label>
                       <input type="text" class="form-control" id="qty" name="qty" value="<?php echo $qty;?>" autocomplete="off">
                            </div>
                          </div>
                          
                          <div class="form-group">
                         <div class="col-sm-6">
                                <label for="qty1">Shelf Quantity</label>
                       <input type="text" class="form-control" id="qty1" name="qty1" value="<?php echo $qty1;?>" autocomplete="off">
                            </div>
                             <div class="col-sm-6">
                                <label for="enddate">Expiring Date</label>
                                 <input type="text" class="form-control" id="enddate" name="enddate" value="<?php echo $enddate;?>"  >
                            </div>
                          </div>
                          
                         
                          
                          
                          
                          
                          
                        
                          
                          
                          
                          
                          
                          
                          
                          
                          <div class="form-group">
                         <div class="col-sm-6">
                                
                                 <input type="hidden" class="form-control" id="itemcode" name="itemcode" value="<?php echo $itemcode;?>" autocomplete="off" readonly>
                            </div>
                          </div>
                          
                          
                          
                          
              
                    

                        <div class="form-group pull-right">
                            <div class="col-sm-12">
                                 <button type="submit" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='saveitem';document.myform.submit;" class="btn btn-info"><i class="fa fa-plus-circle"></i> Save </button>
                                <button type="submit" class="btn btn-danger" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit;">Cancel</button>
                            </div>
                        </div>
                    </div>

                    

            </div>
        </div>
    </div>
    
               
<script>
	$(function(){
    $('#item').change(function(){
        $('#dosage').val($('#item option:selected').data('dosage'));
		 $("#itemcode").val($(this).val());
		
    });
});



</script>