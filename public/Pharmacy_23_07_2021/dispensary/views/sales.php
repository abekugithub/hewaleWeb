<div class="main-content">

    <div class="page-wrapper">
        <?php $engine->msgBox($msg,$status); ?>
        <div class="page form">
         <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper">Point of Sale</div>
                <button class="btn btn-dark pull-right" onclick="document.getElementById('view').value='';document.myform.submit;" style="font-size:15px; padding-top:-10px; line-height:1.3em;  margin-top:-40px;" title="Back" formnovalidate>Back</button>
              
            </div>
<input type="hidden" class="form-control" id="visitcode" name="visitcode" value="<?php echo $visitcode;?>">
<input type="hidden" class="form-control" id="" name="deliverystatus" value="<?php echo $deliverystatus; ?>" readonly>
            <!-- Sales Option Section -->
            <div class="col-sm-12 salesoptblock">
                <div class="col-sm-8 salesoptselect">
                    <div class="form row">
                                <div class="col-sm-6 form-group">
                        <label class="form-label required">Prescription Code: <?php echo ($packagecode?$packagecode:'');?></label>
                            <input type="hidden" class="form-control" value="<?php echo $imagename;?>"id="imagename" name="imagename" >
                            <input type="hidden" class="form-control" value="<?php echo $keys;?>"id="visitcode" name="visitcode" >
                            <input type="hidden" class="form-control" value="<?php echo $keys;?>"id="keys" name="keys" >
                           <input type="hidden" class="form-control" value="<?php echo $packagecode;?>"id="packagecode" name="packagecode" > 
                        </div>
                        <div class="col-sm-6 form-group">
                            <label class="form-label required">Gender: <?php echo ($patgender?$patgender:'');?></label>
                           
                        </div>

                        <div class="col-sm-6 form-group">
                        <label class="form-label required">Customer Name:  <?php echo ($patientfullname?$patientfullname:'');?></label>
                           <input type="hidden" name="customername" value="<?php echo $patientfullname;?>">
                        </div>

                        <div class="col-sm-6 form-group">
                            <label class="form-label required">Age: <?php echo ($patage?$patage:'') ; ?></label>
                           
                        </div>

                        <div class="col-sm-6 form-group">
                        <label class="form-label required">Hewale Number:  <?php echo ($patientnum?$patientnum:'') ; ?></label>
                           
                        </div>
                        
                        <div class="col-sm-6 form-group">
                        <label class="form-label required">Prescription Date:  <?php echo date("d/m/Y",strtotime($prescdate))  ;?></label>
                           
                        </div>

                        <div class="col-sm-6 form-group">
                        <label class="form-label required">Customer Contact:  <?php echo ($patphonenumber?$patphonenumber:'');?></label>
                           
                        </div>

                        <div class="col-sm-6 form-group">
                        <label class="form-label required">Allergies:  <?php echo ($patalergies?$patalergies:'N/A') ;?></label>
                           
                        </div>
                        
						

                        

                        

                        <div class="col-sm-2">
                            <label class="form-label">&nbsp;&nbsp;</label>
                          <!--    <button type="submit" onClick="document.getElementById('viewpage').value='addtray';document.myform.submit;" class="btn btn-success form-control"><i class="fa fa-plus"></i> Add</button>-->
                        </div>

                    </div>
                    </div>
                <div class="col-sm-4 salestotalarea">
                    <div class="col-sm-12">
                        <label>Total:</label>
                        <span><?php echo $currency;?></span>
                        <input type="text" name="totalamounts" id="totalamounts" value="<?php echo $finalgrandtotal;?>" maxLength="7" >
                    </div>
                </div>
            </div>
            <!-- End -->
			<?php  if ($deliverystatus=='1'){?>
                       
						<div class="col-sm-4 form-group">
						<label>Courier:</label>
                       <select name="courier" id="courier" class="form-control select2" tabindex="2" required><option value=""> -- Select Courier --</option>
        				<?php while($obj = $stmtcourierlov->FetchNextObject()){  ?>
        				<option value="<?php echo $obj->CS_COURIERCODE.'|'.$obj->CS_COURIERNAME ;?>" <?php echo (($obj->CS_COURIERCODE == $courier)?'selected':'' )?> ><?php echo $obj->CS_COURIERNAME ;?></option>
        				<?php }  ?> 

			           </select>
                        </div>
                        <?php }?>
                        <div class="col-sm-4 form-group">
                        <label>Instructions:</label>
                        <textarea name="remarks" placeholder="Enter Instructions"></textarea>                          
                        </div>
            <!-- Table Section -->
            <div class="col-sm-12 tableoptblock">
                <div class="row">
                    <div class="panel-body table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Medication</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- table displays here -->
                                <?php
                                $grandtotal=0;
                                if (!empty($cart) && count($cart)>0){
                                	$i=1;
                                	foreach ($cart as $key){
                                		$grandtotal = $grandtotal + ($key['QUANTITY']* $key['COST']);
                                	?>
<!--                                	<form method="post" accept-charset="utf-8" action="#" name="myform" id="myform">-->
                                	
                                <tr>
                                <td><?php echo $i++;?></td>
                                <td><label class="form-label required"><?php echo $key['NAME']?></label>
                               </td>
                                <td><label class="form-label required"><?php echo number_format($key['COST'],2);?></label>
                         		</td>
                                <td><input type="text" class="form-control" id="quantity" name="quantity" value="<?php echo number_format($key['QUANTITY'],2);?>" readonly></td>
                                <td>
                                <label class="form-label required"><?php echo number_format($key['QUANTITY'] * $key['COST'],2);?></label>
                               </td>
                                
                                <input type="hidden" class="form-control" id="drugcode" name="drugcode" value="<?php echo $key['CODE']?>" >
                                <!--  <td> <button name="viewpage" id="" value="edittray" class="btn btn-info" id="saveform"><i class="fa fa-pencil"></i> Edit</button> <button name="viewpage" class="btn btn-danger" id="" value="deletetray" ><i class="fa fa-close"></i> Delete</button></td>-->
                                </tr>	
                             
                              
<!--                                </form>	-->
                                	<?php }
                                	
                                }?>
                          <?php if(!empty($cart) && count($cart)>0){?>
                          <tr >
                          <td colspan="3">
                          </td>
                             <td style="text-align: right">
                             <label class="form-label required"><p style="font-size:10px">Service Charge  (<?php echo $facilitypercent*100?>%):</p></label>
                             </td>          
                             <td>
                             <label class="form-label required"><p style="font-size:10px"><?php  echo (!empty($totalcommission)?number_format($totalcommission,2):'0');?></p></label>
                            </td>
                             
                           </tr>
                           <tr >
                             <td colspan="3">
                             </td>
                             <strong>
                             <td style="text-align: right">
                             <label class="form-label required" align="right">Total</label>
                             </td>          
                             <td></strong><strong>
                             <label class="form-label required"><?php  echo (!empty($finalgrandtotal)?number_format($finalgrandtotal,2):'0');?></label>
                             <input type="hidden" class="form-control" id="grandtotal" name="grandtotal" value="<?php  echo (!empty($finalgrandtotal)?number_format($finalgrandtotal,2):'0');?>" readonly></strong></td>
                             
                           </tr>
                           <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End -->

            <!-- Footer Section -->
            <div class="col-sm-12">
                <div class="col-sm-12 salesfooter">
               
                    <div class="pull-right">
                   <!--  <button type="button" onClick="confirmSubmit('Are you sure you want to  proceed?','Yes',function(){document.getElementById('viewpage').value='prepareprescription';document.myform.submit();});" class="btn btn-success" id="saveform"> Prepare</button>
                            <button type="button" class="btn btn-danger" onClick="confirmSubmit('Are you sure you want to  cancel this sale?','Yes',function() {document.getElementById('viewpage').value='cancelsale';document.myform.submit();})">Cancel</button>-->
                         <button type="button" onClick="confirmSubmit('Are you sure you want to  proceed?','Yes',function(){document.getElementById('viewpage').value='savesales';document.myform.submit();});"
                          class="btn btn-success" > Done</button>
                        <button type="button" class="btn btn-danger" onClick="confirmSubmit('Are you sure you want to  cancel this sale?','Yes',function(){document.getElementById('viewpage').value='';document.myform.submit();});" >Cancel</button>
                    </div>
                </div>
            </div>

            
        </div>

    </div>
</div>
</div>

<script>
    $(document).ready(function () {
    	var value = document.getElementById('grandtotal').value;
    	$('#totalamount').val(value);
    });
</script>