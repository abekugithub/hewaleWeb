<div class="main-content">

        <div class="page-wrapper">

            <?php $engine->msgBox($msg,$status); ?>

            <div class="page form">
                <div class="moduletitle">
                    <div class="moduletitleupper">Editing of stock</div>
                </div>
                    <div class="col-sm-12">
                   
                        <div class="form-group">
                           <div class="col-sm-6">
                                <label for="itemname">item name:</label>
                                <input type="text" class="form-control" id="itemname" name="itemname"  autocomplete="off" readonly  value="<?php echo $itemname;?>">
                            </div>
                             
                            
                            <div class="col-sm-6">
                                <label for="dosage">Dosage:</label>
                                 <input type="text" class="form-control" id="dosage" name="dosage"  autocomplete="off" readonly  value="<?php echo $dosage;?>">
                            </div>
                            
                            
                            
                           
                            
                
                            
                           
                           

                           
                       
                        
            
                        <div class="form-group">
                         <div class="col-sm-6">
                                <label for="qty">Store Quantity</label>
                       <input type="text" class="form-control" id="qty" name="qty" value="<?php echo $qty;?>" autocomplete="off" readonly>
                            </div>
                          </div>
                          
                          <div class="form-group">
                         <div class="col-sm-6">
                                <label for="qty1">Shelf Quantity</label>
                       <input type="text" class="form-control" id="qty1" name="qty1" value="<?php echo $qty1;?>" autocomplete="off" readonly>
                            </div>
                          </div>
                          
                          <div class="form-group">
                         <div class="col-sm-6">
                                <label for="qtymove">Quantity to move</label>
                       <input type="text" class="form-control" id="qtymove" name="qtymove" value="<?php echo $qtymove;?>" autocomplete="off">
                            </div>
                          </div>
                          
                          
                          
                          
                          
                          
                        
                          
                          
                          
                          
                          
                          
                          
                          
                          <div class="form-group">
                         <div class="col-sm-6">
                                
                                 <input type="hidden"  class="form-control" id="itemcode" name="itemcode" value="<?php echo $item;?>" autocomplete="off" readonly>
                            </div>
                          </div>
                          
                          
                          
                          
              
                    

                        <div class="form-group">
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