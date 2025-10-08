<?php //include ('model/js.php');?>
<div class="main-content">

    <div class="page-wrapper">
        <?php $engine->msgBox($msg,$status); ?>
        <div class="page form">
        
            <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper">Prepare Image Prescription</div>
            </div>
			<div class="row col-sm-9">
            <!-- Sales Option Section -->
            <div class="col-sm-8 salesoptblock">
                <div class="col-sm-6 salesoptselect">
                    <div class="form row">
                        <div class="col-sm-6 form-group">
                           <label class="form-label required">Date</label>
                            <input type="text" class="form-control" value="<?php echo date('d-m-Y');?>"id="customername" name="customername" readonly>
                            <input type="hidden" class="form-control" value="<?php echo $imagename;?>"id="imagename" name="imagename" >
                            <input type="hidden" class="form-control" value="<?php echo $keys;?>"id="visitcode" name="visitcode" >
                        </div>

                        <div class="col-sm-6 form-group">
                            <label class="form-label required">Customer Name </label>
                            <input type="text" class="form-control" id="patientfullname" name="patientfullname" value="<?php echo $patientfullname?>" readonly>
                        </div>

                        <div class="col-sm-8 form-group">
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
                        </div>

                       <!--  <div class="col-sm-3 form-group">
                            <label class="form-label required">Payment Method</label>
                            <select type="text" class="form-control" id="paymentmethod" name="paymentmethod" >
                                <option value="" disabled selected hidden>---------</option>

                            </select>
                        </div>-->

                        

                        <div class="col-sm-3">
                            <label class="form-label">&nbsp;&nbsp;</label>
                           <!--  <button type="submit" onClick="document.getElementById('viewpage').value='addtray';document.myform.submit;" class="btn btn-success form-control"><i class="fa fa-plus"></i> Add</button>-->
                            <button type="button" id="addDrug" class="btn btn-success form-control"><i class="fa fa-plus"></i> Add</button>
                        </div>

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
                        <table class="table table-hover" id="traydev">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Drug</th>
                                    <th>Dosage</th>
                                    <th>Price/(Top Up)</th>
                                    <th width="5%">Quantity</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="traydev">
                                <!-- table displays here -->
                                <?php
                                $cartprepare = $session->get('cartprepare'); 
                              
                                $grandtotal=0;
                                if (!empty($cartprepare) && count($cartprepare)>0){
                                	$i=1;
                                	
                                	foreach ($cartprepare as $key){
                                		$grandtotal = $grandtotal + ($key['QUANTITY']* $key['COST']);
                                	?>
                                	<form method="post" accept-charset="utf-8" action="#" name="myform1" id="myform1">
                                	<input type="hidden" class="form-control" value="<?php echo $keys;?>"id="visitcode" name="visitcode" >
                                	<input type="hidden" class="form-control" value="<?php echo $keys;?>"id="keys" name="keys" >
                                	<input type="hidden" class="form-control" value=""id="newk" name="newk" >
                                <tr>
                                <td><?php echo $i++;?></td>
                                <td><label class="form-label required"><?php echo $key['NAME']?></label>
                               </td>
                               <td><label class="form-label required"><?php echo $key['DOSAGE']?></label>
                               </td>
                                <td><label class="form-label required"><input type="text" class="form-control" value="<?php echo isset($_POST[$cost[$i]])? $_POST[$cost[$i]]:number_format($key['COST'],2)?>"id="cost<?php echo $i;?>" name="cost[<?php echo $i;?>]" ></label>
                         		</td>
                                <td><input type="text" class="form-control" id="quantity" name="quantity" value="<?php echo number_format($key['QUANTITY'],2)?>"></td>
                                <td>
                                <label class="form-label required"><?php echo number_format($key['QUANTITY'] * $key['COST'],2)?></label>
                               </td>
                                <input type="hidden" class="form-control" id="drugcode" name="drugcode" value="<?php echo $key['CODE']?>" >
                                <td> <button name="viewpage" id="" value="edittray" class="btn btn-info" id="saveform"><i class="fa fa-pencil"></i> Edit</button> <button type="button" onClick="if (confirm('Are you sure you want to  delete this item from tray?')){document.getElementById('newk').value='<?php echo $key['CODE'];?>';document.getElementById('viewpage').value='deletetray';document.myform.submit();}" class="btn btn-danger" id="" ><i class="fa fa-close"></i> Delete</button></td>
                                </tr>	
                             
                              
                                </form>	
                                	<?php }
                                	
                                }?>
                          <?php if(!empty($cartprepare) && count($cartprepare)>0){?>
                           <tr >
                             <td colspan="4">
                             <label class="form-label required">Total</label>
                             </td>          
                             <td><strong></strong>
                             <label class="form-label required"><?php  echo (!empty($grandtotal)?number_format($grandtotal,2):'0');?></label>
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
                        <button type="submit" onClick="if (confirm('Are you sure you want to  proceed?')){document.getElementById('viewpage').value='prepareimage';document.myform.submit();}" class="btn btn-success" id="saveform"></i> Prepare</button>
                        <button type="submit" class="btn btn-danger" onClick="if (confirm('Are you sure you want to  cancel this sale?')){document.getElementById('viewpage').value='cancelsale';document.myform.submit();}">Cancel</button>
                    </div>
                </div>
            </div>
		</div>
		
		
<!-- Begining of image -->
		<div class="row col-sm-3" >
		 <table class="table table-hover">
		<img src="https://www.hewale.net/api/media/uploads/<?php echo $imagename;?>" alt="No prescription" style="width:400px;height:600px;">
		   </table>
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