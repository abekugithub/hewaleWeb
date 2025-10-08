<div class="main-content">

        <div class="page-wrapper">

            <?php $engine->msgBox($msg,$status); ?>

            <div class="page form">
                <div class="moduletitle">
                    <div class="moduletitleupper">Add Prices</div>
                </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                           <div class="col-sm-4">
                                <label for="item">Stock Item:</label>
                                 <select name="stockitem" id="stockitem" class="form-control select2" tabindex="1">
                                    <option value="<?php echo $item; ?>"> --Select Stock -- </option>
   								<?php while($objitem = $stmtstockitem->FetchNextObject()){  ?>
  								<option value="<?php echo $objitem->ST_CODE.'|'.$objitem->ST_NAME?>" data-dosage="<?php echo $objitem->ST_DOSAGENAME;?>" ><?php echo $objitem->ST_NAME ;?></option>
   								<?php } ?>  
                                     
                                     
                                 </select>
                            </div>
                            
                            <div class="col-sm-2">
                                <label for="dosage">Dosage Form:</label>
                                 <input type="text" class="form-control" id="dosage" name="dosage" value="" autocomplete="off" readonly  value="<?php echo $dosage;?>">
                            </div>
                            
                          
                            
                            
                           
                            
                
                            <div class="form-group">  
                            <div class="col-sm-2">
                                <label for="level">Payment Method</label>
                                <select name="paymentmethod" id="paymentmethod" class="form-control select2" tabindex="1">
                                    <option value="<?php echo $paymentmethod; ?>"> --Select Stock -- </option>
   								<?php while($objitem = $stmtpaymeth->FetchNextObject()){  ?>
  								<option value="<?php echo $objitem->PINS_METHOD_CODE.'|'.$objitem->PINS_METHOD.'|'.$objitem->PINS_CATEGORY_CODE;?>" data-dosage="<?php echo $objitem->PINS_METHOD_CODE;?>" ><?php echo $objitem->PINS_METHOD ;?></option>
   								<?php } ?>  
                                     
                                     
                                 </select>
                            
                            </div>
							</div>
                           
                           

                           
                        </div>
                        
            
                        <div class="form-group">
                         <div class="col-sm-2">
                                <label for="qty">Amount</label>
                       <input type="text" class="form-control" id="amt" name="amt" value="<?php echo $amt;?>" autocomplete="off" placeholder="Figures Only">
                            </div>
                            <div class="col-sm-2">
                                <label for="qty">NHIS Top Up</label>
                       <input type="text" class="form-control" id="topup" name="topup" value="<?php echo $topup;?>" autocomplete="off" placeholder="Figures Only">
                            </div>
                          </div>
                          
                       
                          
                          
                          <div class="form-group">
                         <div class="col-sm-6">
                                
                                 <input type="hidden" class="form-control" id="itemcode" name="itemcode" value="<?php echo $itemcode;?>" autocomplete="off" readonly>
                            </div>
                          </div>
                          
                          
                          
                          
              
                    

                        <div class="form-group pull-right">
                            <div class="col-sm-12">
                                 <button type="submit" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='savestockitem';document.myform.submit;" class="btn btn-info"><i class="fa fa-plus-circle"></i> Save </button>
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