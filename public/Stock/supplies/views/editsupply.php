<div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Manage Supplies (Step 1 of 3)<span class="pull-right">
                   
                    <button type="button" class="btn btn-dark" onclick="document.getElementById('viewpage').value='';document.getElementById('view').value='';document.myform.submit();"><i class="fa fa-arrow-left"></i> Cancel </button>
                    
                    <button type="button" class="btn btn-info" onclick="document.getElementById('viewpage').value='savewaybill';document.getElementById('view').value='editstocknext';document.myform.submit();"><i class="fa fa-arrow-right"></i> Next </button>
                    
                </div>
            </div>
           <?php $engine->msgBox($msg,$status); ?>
            <div class="form-group supplier-info">
                 <div class="col-sm-12">

                  <div class="form-group">
                <div class="col-sm-4 required">
                    <label class="control-label" for="fname">Supplier Name </label>
              <select name="supplier" id="supplier" class="form-control select2" tabindex="1" ><option value="<?php echo $supplier; ?>"> -- Select Supplier --</option>
				<?php while($obj = $stmtsupp->FetchNextObject()){  ?>
				<option value="<?php echo $obj->SU_CODE.'&&'.$obj->SU_NAME ; ?>" <?php echo (($obj->SU_CODE.'&&'.$obj->SU_NAME == $supplier)?'selected':'' )?> ><?php echo $obj->SU_NAME ;?></option>
				<?php } ?> 

			</select>
            
                </div>
                
                <div class="col-sm-4">
                    <label for="startdate">Supply Date </label>
                    <input type="text" class="form-control" id="startdate" name="startdate" placeholder="dd/mm/yyyy" value="<?php echo (($startdate == "")?'':date("d/m/Y", strtotime($startdate)));?>" >
                </div>
                
                <div class="col-sm-4 required">
                    <label for="othername">Waybill </label>
                    <input type="text" class="form-control" id="waybill" name="waybill" value="<?php echo $waybill;?>" style="background:#E3F1B6">
                </div>
                
                
            </div>
            
            
            
             <div class="btn-group">
                <div class="col-sm-12">
                </div>
            </div>
            <br /><br />
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
                        <th></th>
                       
                    </tr>
                </thead>
                <tbody id="stockadded">
               
                           <?php
		  $i = 1;
		  if($stmtsup){
           while($objsup = $stmtsup->FetchNextObject()){
	       echo '
	       <tr id="'.$objsup->SUPDT_ID.'">
           <td class="center">'.$i++.'</td>
           <td>'.$objsup->SUPDT_STOCKNAME.'</td>
           <td>'.$objsup->SUPDT_BATCHCODE.'</td>
           <td>'.$objsup->SUPDT_QUANTITY.'</td>
           <td>'.$objsup->SUPDT_UNITPRICE.'</td>
		   <td>'.date("d/m/Y",strtotime($objsup->SUPDT_EXPIRYDATE)).'</td>
		   <td>'.(($objsup->SUPDT_TYPE == 1)?'Store':'Shelf').'</td>
           <td></td>
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

        </div>
    </div>
    <input type="hidden" name="suppcode" id="suppcode" value="<?php echo $suppcode; ?>" >