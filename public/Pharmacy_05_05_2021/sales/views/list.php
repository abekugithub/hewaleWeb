<div class="main-content">

    <div class="page-wrapper">
        <?php $engine->msgBox($msg,$status); ?>
        <div class="page form">
        
            <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper">Point of Sale</div>
            </div>
<input type="hidden" class="form-control" id="grandtotal" name="grandtotal" value="" readonly></strong></td>
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
                            <label class="form-label required">Medication</label>
                            <select type="text" class="form-control select2" id="drugid" name="drugid" >
                            <option value="">Select Drug</option>
                            <?php foreach ($finaldrugsarray as $key=>$value){
                          
                            ?>
                                <option value="<?php echo $value['ST_CODE'];?>"><?php echo $value['ST_NAME'].' '.$value['ST_DOSAGE']?></option>
                                <?php }?>
                            <?php /**if ($stmtdrugs->RecordCount()>0){
                            while ($obj=$stmtdrugs->FetchNextObject()){
                            ?>
                                <option value="<?php echo $obj->ST_CODE;?>"><?php echo $obj->ST_NAME.' '.$obj->ST_DOSAGE?></option>
                                <?php }
                            }else{?>
                            	<option value="">No Drug Found</option>
                           <?php  }**/?>
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
                            <button type="button" id="addDrug" class="btn btn-success form-control"><i class="fa fa-plus"></i> Add</button>
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
                        <table class="table table-hover" id="traydev">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Drug</th>
                                    <th>Dosage</th>
                                    <th>Price/(Top Up)</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Insurance</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="traydev">
                              
                             <input type="hidden" class="form-control" id="grandtotal" name="grandtotal" value="<?php  echo (!empty($grandtotal)?number_format($grandtotal,2):'0');?>" readonly></strong></td>
                             <td colspan="2"></td>
                           </tr>
                          
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
                        <button type="button" onClick="if (confirm('Are you sure you want to  proceed?')){document.getElementById('viewpage').value='savesales';document.myform.submit();}" class="btn btn-success" id="saveform"></i> Done</button>
                        <button type="button" class="btn btn-danger" onClick="if (confirm('Are you sure you want to  cancel this sale?')){document.getElementById('viewpage').value='cancelsale';document.myform.submit();}">Cancel</button>
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
    function doSum(quantity,cost,total)
    {
       // alert('Bingoooo');
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
      //  alert(tot);
        document.getElementById('grandtotal').value = tot;
        document.getElementById('totalamount').value = tot;
        document.getElementById('grtotal').value = tot;
 }
</script>