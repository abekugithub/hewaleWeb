<div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Add Supplies (Step 2 of 3)<span class="pull-right">
                   
                     <button type="button" class="btn btn-dark" onclick="document.getElementById('viewpage').value='addprior';document.getElementById('view').value='add';document.myform.submit();"><i class="fa fa-arrow-left"></i> Previous </button>
                     
                    <button type="button" class="btn btn-info" onclick="document.getElementById('viewpage').value='fetchstock';document.getElementById('view').value='addstockfinal';document.myform.submit();"><i class="fa fa-arrow-right"></i> Next </button>
                    
                  
                </div>
            </div>
            
            <div id="recallmsg" ></div>
           

                    <div class="form-group" id="noncontent">
                        <div class="col-sm-12">

            <div class="form-group">
                <div class="col-sm-4">
                    <label for="stock">Stock</label>
                   
           <select name="stock" id="stock" class="form-control select2" ><option value="<?php echo $stock; ?>"> -- Select Stock --</option>
				<?php while($obj = $stmtstock->FetchNextObject()){  ?>
				<option value="<?php echo $obj->ST_CODE.'&&'.$obj->ST_NAME ; ?>" <?php echo (($obj->ST_CODE == $supplier)?'selected':'' )?> ><?php echo $obj->ST_NAME ;?></option>
				<?php } ?> 

			</select>
                   
                </div>
                
                <div class="col-sm-4">
                    <label for="phonenumber">Quantity</label>
                    <input type="text" class="form-control onlynums" id="qtity" name="qtity" value="<?php echo $qtity;?>">
                </div>
                
                <div class="col-sm-4">
                    <label for="phonenumber">Unit Price</label>
                    <input type="text" class="form-control onlynums" id="unitprice" name="unitprice" value="<?php echo $unitprice;?>">
                </div>
            </div>
            
            
            <div class="form-group">
                <div class="col-sm-4">
                
                <label for="phonenumber">Batch Code</label>
                    <input type="text" class="form-control" id="batchcode" name="batchcode" value="<?php echo $batchcode;?>" >
                
                    
                </div>
                
                <div class="col-sm-4">
                
                <label for="phonenumber">Expiry Date</label>
                    <input type="text" class="form-control" id="enddate" name="enddate" value="<?php echo $enddate;?>">
                
                    
                </div>
                
                <div class="col-sm-4">
                
                <label for="stocktype">Restock Type </label>
                 <select name="stocktype" id="stocktype" class="form-control select2" ><option value="<?php echo $stock; ?>"> -- Select Re-stock --</option>
				
				<option value="1" <?php echo (($stocktype == '1')?'selected':'' )?> >Store</option>
                <option value="2" <?php echo (($stocktype == '2')?'selected':'' )?> >Shelf</option>
		

			</select>
                    
                </div>
            </div>
            
             <div class="btn-group">
                <div class="col-sm-12">
                </div>
            </div>
<br />
            <div class="btn-group pull-right">
                <div class="col-sm-12">
                    <button type="button" class="btn btn-success" id="addeditedstock"><i class="fa fa-plus"></i> Add Stock</button>
                    
                </div>
            </div>

                        </div>
                    </div>
     
             <div class="btn-group">
                <div class="col-sm-12">
                </div>
            </div>
            <br />
            <div id="recallfail" class="alert alert-danger" style="display:none" ></div>  
<table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Stock Name</th>
                        <th>Batch Code</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Expiry Date</th>
                        <th>Restock Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="stockadded">
               
          <?php
		  $i = 1;
		  if($stmtsup){
		
           while($objsup = $stmtsup->FetchNextObject()){
			  
			   $objstockdetails = $engine->getStockDetails($objsup->SUPDT_STOCKCODE,$facicode);
			   
	       echo '
	       <tr id="'.$objsup->SUPDT_ID.'">
           <td class="center">'.$i++.'</td>
           <td>'.$objsup->SUPDT_STOCKNAME.'</td>
           <td>'.$objsup->SUPDT_BATCHCODE.'</td>
           <td>'.$objsup->SUPDT_QUANTITY.'</td>
           <td>'.$objsup->SUPDT_UNITPRICE.'</td>
		   <td>'.date("d/m/Y",strtotime($objsup->SUPDT_EXPIRYDATE)).'</td>
		   <td>'.(($objsup->SUPDT_TYPE == 1)?'Store':'Shelf').'</td>
           <td class="hidden-xs">
		   
		  '.((!$objstockdetails)?'<button type="button" class="btn btn-danger deleterow" ><i class="fa fa-trash-o"></i> Delete Stock</button>':' <button type="button" class="btn btn-danger recallrow" ><i class="fa fa-chevron-left"></i> Recall Stock</button>').'
		  
		   </td>
		   <input type="hidden" name="rowvalue" id="rowvalue" value="'.$objsup->SUPDT_ID.'">
		   
         </tr>
	     ';
            }
		  }
					?>
                   
                </tbody>
            </table>

        </div>
    </div>
<input type="hidden" name="suppcode" id="suppcode" value="<?php echo $suppcode; ?>" >