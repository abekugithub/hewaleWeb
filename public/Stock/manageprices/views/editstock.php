<div class="main-content">

        <div class="page-wrapper">
				<input type="hidden" name="pricecode" value="<?php echo $pricecode;?>" id="pricecode" />
            <?php $engine->msgBox($msg,$status); ?>

            <div class="page form">
                <div class="moduletitle">
                    <div class="moduletitleupper">Editing of Price</div>
                </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                           <div class="col-sm-6">
                                <label for="item">item name:</label>
                                 <select readonly name="item" id="item" class="form-control">
                                <option value="<?php echo $item.'|'.$itemname.'|'.$paymentcat;?>" data-dosage="<?php echo $dosage;?>"  ><?php echo $itemname;?></option>
   								</select>
                            </div>
                            
                            <div class="col-sm-6">
                                <label for="dosage">Dosage:</label>
                                 <input type="text" class="form-control" id="dosage" name="dosage"  autocomplete="off" readonly  value="<?php echo $dosage;?>">
                            </div>
                            
                            
                            
                           
                            
                
                            <div class="form-group">  
                            <div class="col-sm-6">
                                <label for="level">Alert Stock</label>
                               <input type="text" class="form-control" id="level" name="level" value="<?php echo $level;?>" autocomplete="off">
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
                          </div>
                          
                    
                          
                          
                        
                          
                          
                          
                          
                          
                          
                          
                          
                          <div class="form-group">
                         <div class="col-sm-6">
                                
                               
                            </div>
                          </div>
                          
                          
                          
                          
              
                    

                        <div class="form-group">
                            <div class="col-sm-12">
                                 <button type="submit" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='savedititem';document.myform.submit;" class="btn btn-info"><i class="fa fa-plus-circle"></i> Save </button>
                                <button type="submit" class="btn btn-danger" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit;">Cancel</button>
                            </div>
                        </div>
                    </div>

                    

            </div>
        </div>
    </div>
    
               
