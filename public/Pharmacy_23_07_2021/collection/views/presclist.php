<div class="main-content">

    <div class="page-wrapper">
        <?php $engine->msgBox($msg,$status); ?>
        <div class="page form">
        
            <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper">Prepare Prescription</div>
                <?php //print_r($_REQUEST);?>
            </div>
			<div class="row col-sm-9">
            <!-- Sales Option Section -->
            <div class="col-sm-8 salesoptblock">
                <div class="col-sm-6 salesoptselect">
                    <div class="form row">
                        <div class="col-sm-6 form-group">
                           <label class="form-label required">Date</label>
                            <input type="text" class="form-control" value="<?php echo date('d-m-Y');?>"id="customername" name="customername" readonly>
                            <input type="hidden" class="form-control" value="<?php echo $keys;?>"id="visitcode" name="visitcode" >
                        </div>

                        <div class="col-sm-6 form-group">
                            <label class="form-label required">Customer Name </label>
                            <input type="text" class="form-control" id="patientfullname" name="patientfullname" value="<?php echo $patientfullname;?>" readonly>
                        </div>

                       <!--  <div class="col-sm-8 form-group">
                            <label class="form-label required">Drugs</label>
                            <select type="text" class="form-control select2" id="drugid" name="drugid" >
                            <option value="">Select Drug</option>
                            <?php if ($stmtdrugs->RecordCount()>0){
                            while ($obj=$stmtdrugs->FetchNextObject()){
                            ?>
                                <option value="<?php echo $obj->ST_CODE;?>"><?php echo $obj->ST_NAME.' '.$obj->ST_DOSAGE?></option>
                                <?php }
                            }else{?>
                            	<option value="">No Drug Found</option>
                           <?php  }?>
                            </select>
                        </div>-->

                       <!--  <div class="col-sm-3 form-group">
                            <label class="form-label required">Payment Method</label>
                            <select type="text" class="form-control" id="paymentmethod" name="paymentmethod" >
                                <option value="" disabled selected hidden>---------</option>

                            </select>
                        </div>-->

                        

                        <!-- <div class="col-sm-3">
                            <label class="form-label">&nbsp;&nbsp;</label>
                            <button type="submit" onClick="document.getElementById('viewpage').value='prescaddtray';document.myform.submit;" class="btn btn-success form-control"><i class="fa fa-plus"></i> Add</button>
                        </div>-->

                    </div>
                </div>
                <div class="col-sm-4 salespreparearea">
                    <div class="col-sm-12">
                        <label>Total:</label>
                        <span><?php echo $currency;?></span>
                        <input type="text" name="totalamount" id="totalamount" maxLength="7" >
                    </div>
                </div>
            </div>
            <!-- End -->

            <!-- Table Section -->
            <div class="col-sm-12 tableoptblock">
                <div class="row">
                    <div class="panel-body table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Drug</th>
                                    <th>Dosage</th>
                                    <th>Price/(Top Up)</th>
                                    <th width="5%">Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- table displays here -->
                                <?php
                                $cartprepare = $session->get('cartprepare'); 
                              
                                $grandtotal=0;
                                if (!empty($cartprepare) && count($cartprepare)>0){
                                	$i=1;
                                	//print_r($cartprepare); 
                                	
                                	foreach ($cartprepare as $key){
                                		$grandtotal = $grandtotal + ($key['QUANTITY']* $key['COST']);
                                	?>

                                	<input type="hidden" class="form-control" value="<?php echo $keys;?>"id="visitcode" name="visitcode" >
                                	<input type="hidden" class="form-control" value="<?php echo $keys;?>"id="keys" name="keys" >
                                	<input type="hidden" class="form-control" value=""id="newk" name="newk" >
                                <tr>
                                <td><?php echo $i++;?></td>
                                <td><label class="form-label required"><?php echo $key['NAME']?></label>
                                <input type="hidden" class="form-control" value="<?php echo $key['NAME']?>" id="drugname<?php echo $i;?>" name="drugname[<?php echo $i;?>]" >
                                <input type="hidden" class="form-control" value="<?php echo $key['CODE']?>" id="drugcode<?php echo $i;?>" name="drugcode[<?php echo $i;?>]" >
                               </td>
                               <td><label class="form-label required"><?php echo $key['DOSAGE']?></label>
                               <input type="hidden" class="form-control" value="<?php echo $key['DOSAGE']?>" id="dosname<?php echo $i;?>" name="dosname[<?php echo $i;?>]" >
                               </td>
                                <td><input onkeyup="doSum('quantity<?php echo $i;?>','cost<?php echo $i;?>','total<?php echo $i;?>')" type="text" class="form-control" id="cost<?php echo $i;?>" name="cost[<?php echo $i;?>]" value="<?php echo number_format($key['COST'],2)?>">
                         		</td>
                                <td><input onkeyup="doSum('quantity<?php echo $i;?>','cost<?php echo $i;?>','total<?php echo $i;?>')" type="text" class="form-control" id="quantity<?php echo $i;?>" name="quantity[<?php echo $i;?>]" value="<?php echo number_format($key['QUANTITY'],2)?>"></td>
                                <td>
                                <input type="text" class="form-control" id="total<?php echo $i;?>" value="<?php echo number_format($key['QUANTITY'] * $key['COST'],2)?>" name="total" readonly >
                                <!-- <label class="form-label required" id><?php echo number_format($key['QUANTITY'] * $key['COST'],2)?></label>-->
                               </td>
                       
                                <!-- <td> <button name="viewpage" id="" value="prescedittray" class="btn btn-info" id="saveform"><i class="fa fa-pencil"></i> Edit</button> <!-- <button type="button" onClick="if (confirm('Are you sure you want to  delete this item from tray?')){document.getElementById('newk').value='<?php echo $key['CODE'];?>';document.getElementById('viewpage').value='prescdeletetray';document.myform.submit();}" class="btn btn-danger" id="" ><i class="fa fa-close"></i> Delete</button></td>-->
                                </tr>	
                             <script type="text/javascript">
    function doSum(quantity,cost,total)
    {
        
        // Capture the entered values of two input boxes
        var my_quantity = document.getElementById(quantity).value;
        var my_cost = document.getElementById(cost).value;
      //  alert(my_quantity);
        // Add them together and display
        var tot = my_quantity *my_cost;
        document.getElementById(total).value = tot;

         var arr = document.getElementsByName('total');
        var tot=0;
        for(var i=0;i<arr.length;i++){
            if(parseFloat(arr[i].value))
                tot += parseFloat(arr[i].value);
        }
        document.getElementById('gtotal').value = tot;
        document.getElementById('totalamount').value = tot;
 }
  
        
    
							</script>
                              
                                	<?php }
                                	
                                }?>
                          <?php if(!empty($cartprepare) && count($cartprepare)>0){?>
                           <tr >
                             <td colspan="5">
                             <label class="form-label required">Total</label>
                             </td>          
                             <td><strong></strong>
                             <label class="form-label required">
                             <input type="text" class="form-control" readonly value="<?php  echo (!empty($grandtotal)?number_format($grandtotal,2):'0');?>" id="gtotal" name="gtotal">
                             </label>
                             <input type="hidden" class="form-control" id="grandtotal" name="grandtotal" value="<?php  echo (!empty($grandtotal)?number_format($grandtotal,2):'0');?>" readonly></strong></td>
                             <td colspan="2"></td>
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
                        <button type="submit" onClick="if (confirm('Are you sure you want to  proceed?')){document.getElementById('viewpage').value='prepareprescription';document.myform.submit();}" class="btn btn-success" id="saveform"></i> Prepare</button>
                        <button type="submit" class="btn btn-danger" onClick="if (confirm('Are you sure you want to  cancel this sale?')){document.getElementById('viewpage').value='cancelsale';document.myform.submit();}">Cancel</button>
                    </div>
                </div>
            </div>
		</div>
		
		
<!-- Begining of image 
		<div class="row col-sm-3" >
		<table class="table table-hover">
		<thead><td>Drug</td><td>Quantity</td><td>Dosage</td></thead>
		<tbody>
<?php foreach ($prescarray as $value){?>
		<tr><td><?php echo $encaes->decrypt($value[1]);?></td><td><?php echo $value[2];?></td><td><?php echo $value[3];?></td></tr>
           <?php }?>
		<?php  //print_r($prescarray);?>
		</tbody>
		</table>
		    </div>-->
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