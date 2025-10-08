<div class="main-content">

    <div class="page-wrapper">
        <?php $engine->msgBox($msg,$status); ?>
        <div class="page form">
        
            <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper">Point of Sale</div>
            </div>

            <!-- Sales Option Section -->
            <div class="col-sm-12 salesoptblock">
                <div class="col-sm-8 salesoptselect">
                    <div class="form row">
                        <div class="col-sm-6 form-group">
                           <label class="form-label required">Date</label>
                            <input type="text" class="form-control" value="<?php echo date('d-m-Y');?>"id="customername" name="customername" readonly>
                        </div>

                        <div class="col-sm-6 form-group">
                            <label class="form-label required">Customer Name </label>
                            <input type="text" class="form-control" id="customername" name="customername" >
                        </div>

                        <div class="col-sm-6 form-group">
                            <label class="form-label required">Drugs</label>
                            <select type="text" class="form-control select2" id="drugid" name="drugid" >
                            <option value="">Select Drug</option>
                           
                            </select>
                        </div>

                        <div class="col-sm-3 form-group">
                            <label class="form-label required">Payment Method</label>
                            <select type="text" class="form-control" id="paymentmethod" name="paymentmethod" >
                                <option value="" disabled selected hidden>---------</option>

                            </select>
                        </div>

                        

                        <div class="col-sm-2">
                            <label class="form-label">&nbsp;&nbsp;</label>
                            <button type="submit" onClick="document.getElementById('viewpage').value='addtray';document.myform.submit;" class="btn btn-success form-control"><i class="fa fa-plus"></i> Add</button>
                        </div>

                    </div>
                </div>
                <div class="col-sm-4 salestotalarea">
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
                                    <th>Price/(Top Up)</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Insurance</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- table displays here -->
                                <?php
                                $cart = $session->get('cart'); 
                                $grandtotal=0;
                                if (!empty($cart) && count($cart)>0){
                                	$i=1;
                                	foreach ($cart as $key){
                                		$grandtotal = $grandtotal + ($key['QUANTITY']* $key['COST']);
                                	?>
                                	<form method="post" accept-charset="utf-8" action="#" name="myform" id="myform">
                                	
                                <tr>
                                <td><?php echo $i++;?></td>
                                <td><label class="form-label required"><?php echo $key['NAME']?></label>
                               </td>
                                <td><label class="form-label required"><?php echo number_format($key['COST'],2)?></label>
                         		</td>
                                <td><input type="text" class="form-control" id="quantity" name="quantity" value="<?php echo number_format($key['QUANTITY'],2)?>"></td>
                                <td>
                                <label class="form-label required"><?php echo number_format($key['QUANTITY'] * $key['COST'],2)?></label>
                               </td>
                                <td><label class="form-label required"><?php echo number_format($key['NHIS'] * $key['QUANTITY'],2);?></label></td>
                                <input type="hidden" class="form-control" id="drugcode" name="drugcode" value="<?php echo $key['CODE']?>" >
                                <td> <button name="viewpage" id="" value="edittray" class="btn btn-info" id="saveform"><i class="fa fa-pencil"></i> Edit</button> <button name="viewpage" class="btn btn-danger" id="" value="deletetray" ><i class="fa fa-close"></i> Delete</button></td>
                                </tr>	
                             
                              
                                </form>	
                                	<?php }
                                	
                                }?>
                          <?php if(!empty($cart) && count($cart)>0){?>
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
                        <button name="viewpage" value="savesales" class="btn btn-success" id="saveform"></i> Done</button>
                        <button type="submit" class="btn btn-danger" onClick="document.getElementById('viewpage').value='cancelsale'";>Cancel</button>
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