<div class="main-content">

    <div class="page-wrapper">
        <div class="page form">
        <input id="patientcode" name="patientcode" value="<?php echo $patientnum; ?>" type="hidden" />
            <?php  $linkviewrequst =  'index.php?pg='.md5('Pharmacy').'&amp;option='.md5('Monitor Prescription').'&uiid='.md5('1_pop').'&viewpage=pharmahistorydetails&view=pharmahistory&patientcode='.$patientnum;?>
            <input type="hidden" value="<?php echo $instpercentage?>" name="instpercentage" id="instpercentage">

            

            <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper">Prepare Prescription  
                    
                <button type="button" class="btn btn-primary" onClick="CallSmallerWindow('<?php echo $linkviewrequst?>')">Prescription History</button>
                
                <button type="submit" class="btn btn-dark pull-right" onClick="document.getElementById('view').value='';document.getElementById('viewpage').value='cancelsale';document.myform.submit();">Back</button></div>

                <?php $engine->msgBox($msg,$status); ?>
            </div>
            <div class="col-sm-12 salesoptblock">
                <div class="col-sm-8 salesoptselect">
                    <div class="form row">
                        <div class="col-sm-6 form-group">
                            <label class="form-label required">Prescription Code: <?php echo $itemcode;?></label>
                        </div>

                        <div class="col-sm-6 form-group">
                            <label class="form-label required">Gender: <?php echo $patientgender;?></label>
                        </div>

                        <div class="col-sm-6 form-group">
                            <label class="form-label required">Customer Name:  <?php echo $patientfullname;?></label>
                        </div>

                        <div class="col-sm-6 form-group">
                            <label class="form-label required">Age: <?php echo $patientage ; ?></label>
                        </div>

                        <div class="col-sm-6 form-group">
                            <label class="form-label required">Hewale Number:  <?php echo $patientnum ; ?></label>
                        </div>

                        <div class="col-sm-6 form-group">
                            <label class="form-label required">Prescription Date:  <?php echo date('d-m-Y');?></label>
                        </div>

                        <div class="col-sm-6 form-group">
                            <label class="form-label required">Customer Contact:  <?php echo $patientcontact;?></label>
                        </div>

                        <div class="col-sm-3 form-group">
                            <label class="form-label required">Allergies:  <?php echo $allergies ;?></label>
                        </div>


                        <div class="col-sm-3">
                            <label class="form-label">Diagnosis: <?php echo $diagnosis ;?></label>
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
            <div class="row col-sm-12">
                <!-- Table Section -->
                <div class="col-sm-12 tableoptblock">
                    <small class=""><b>NB</b>: A <?php echo !empty($instpercentage)?$instpercentage:'0'; ?>% service charge will be applied to your prices.</small>
                    <div class="row">
                        <div class="panel-body table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Medication</th>
                                    <th width="5%">Dosage</th>
                                    <th width="5%">Times</th>
                                    <th width="5%">Days</th>
                                    <th>Price/(Top Up)</th>
                                    <th width="5%">Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <!-- table displays here -->
                                <?php
                                $cartprepare = $session->get('cartprepare');

                                $grandtotal=0;
                                $grandtotal1=0;
                                if (!empty($cartprepare) && count($cartprepare)>0){
                                    $i=1;
                                    $totalwithoutpercentage = 0;
                                    //print_r($cartprepare);

                                    foreach ($cartprepare as $key){
                                        $grandtotal = $grandtotal + ($key['QUANTITY'] * $key['COST']);
                                        ?>

                                        <input type="hidden" class="form-control" value="<?php echo $keys;?>"id="visitcode" name="visitcode" >
                                        <input type="hidden" class="form-control" value="<?php echo $keys;?>"id="keys" name="keys" >
                                        <input type="hidden" class="form-control" value=""id="newk" name="newk" >
                                        <tr>
                                            <td><?php echo $i++;?></td>
                                            <td>
                                                <label class="form-label required"><?php echo $key['NAME']?></label>
<!--                                                <br><div class="form-label required"><strike>--><?php //echo $key['PRESC_FREQ'] .' * '.$key['PRESC_DAYS']?><!--</strike></div>-->
                                                <input type="hidden" class="form-control" value="<?php echo $key['NAME']?>" id="drugname<?php echo $i;?>" name="drugname[<?php echo $i;?>]" >
                                                <input type="hidden" class="form-control" value="<?php echo $key['CODE']?>" id="drugcode<?php echo $i;?>" name="drugcode[<?php echo $i;?>]" >
                                                <input type="hidden" class="form-control" value="<?php echo $key['TYPE']?>" id="type<?php echo $i;?>" name="type[<?php echo $i;?>]" >
                                            </td>
                                            <td><label class="form-label required"><?php echo $key['PRESC_FREQ']?></label>
                                                <input type="hidden" class="form-control" value="<?php echo $key['DOSAGE']?>" id="dosagename<?php echo $i;?>" name="dosagename[<?php echo $i;?>]" >
                                                <input type="hidden" class="form-control" value="<?php echo $key['DOSAGECODE']?>" id="dosagecode<?php echo $i;?>" name="dosagecode[<?php echo $i;?>]" >
                                                
                                            </td>
                                            <td><label class="form-label required"><?php echo $key['PRESC_TIMES']?></label></td>
                                            <td><label class="form-label required"><?php echo $key['PRESC_DAYS']?></label></td>
                                            <td><input onkeyup="doSum('quantity<?php echo $i;?>','cost<?php echo $i;?>','total<?php echo $i;?>')" type="text" class="form-control" id="cost<?php echo $i;?>" name="cost[<?php echo $i;?>]" value="<?php echo !empty($key['COST'])?number_format($key['COST'],2):0?>">
                                            </td>
                                            <td><input onkeyup="doSum('quantity<?php echo $i;?>','cost<?php echo $i;?>','total<?php echo $i;?>')" type="text" class="form-control" id="quantity<?php echo $i;?>" name="quantity[<?php echo $i;?>]" value="<?php echo $key['QUANTITY']?>"></td>
                                            <td>
                                                <input type="text" class="form-control" id="total<?php echo $i;?>" value="<?php echo number_format($key['QUANTITY'] * $key['COST'],2)?>" name="total" readonly >
                                                <?php
                                                $getval = number_format($key['QUANTITY'] * $key['COST'],2);
                                                $grandtotal1 = floatval($getval) + floatval($grandtotal1);
                                                $totalwithoutpercentage = $totalwithoutpercentage + ($key['QUANTITY'] * $key['COST']);
                                                $finaltotal = number_format((($instpercentage / 100) * $grandtotal1),2);
                                                ?>
                                                <!-- <label class="form-label required" id><?php echo number_format($key['QUANTITY'] * $key['COST'],2)?></label>-->
                                            </td>
                                            <td>
                                            <!--<button class="btn btn-default switch-prescription" ><i class="fa fa-exchange"></i> </button> --></td>

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
//                                                var percenttotal = ((<?php //echo $instpercentage?>// / 100) * tot) + parseFloat(tot);
                                                document.getElementById(total).value = tot.toFixed(2);

                                                var arr = document.getElementsByName('total');
                                                var tot=0;
                                                for(var i=0;i<arr.length;i++){
                                                    if(parseFloat(arr[i].value))
                                                        tot += parseFloat(arr[i].value);
                                                }
//                                                let percentage_added = ((<?php //echo $instpercentage?>// / 100) * tot) + parseFloat(tot);
                                                var scharge = ((<?php echo $instpercentage?> / 100) * tot);
                                                var totaltot = tot + scharge;
                                                document.getElementById('gtotal').value = totaltot.toFixed(2);
                                                document.getElementById('totalamount').value = totaltot.toFixed(2);
                                                document.getElementById('servicecharge').value = scharge.toFixed(2);
                                            }



                                        </script>

                                    <?php }

                                }?>
                                <?php if(!empty($cartprepare) && count($cartprepare)>0){?>
                                    <tr>
                                        <td colspan="5"></td>
                                        <td style="text-align: right">Service Charge (<?php echo $instpercentage?>%)</td>
                                        <td></td>
                                        <td><strong></strong>
                                            <label class="form-label required">
                                                <input type="text" class="form-control" readonly value="<?php echo (!empty($grandtotal1)?number_format((($instpercentage / 100) * $grandtotal1),2):'0');?>" id="servicecharge" name="servicecharge">
                                            </label>
                                            <input type="hidden" class="form-control" id="scharge" name="scharge" value="<?php  echo (!empty($grandtotal1)?number_format($grandtotal1,2):'0');?>" readonly>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr >
                                        <td colspan="5"></td>
                                        <td style="text-align: right">
                                            <label class="form-label required">Total</label>
                                        </td>
                                        <td></td>
                                        <td><strong></strong>
                                            <label class="form-label required">
                                                <input type="text" class="form-control" readonly value="<?php echo (!empty($grandtotal1)?number_format(($grandtotal1 + $finaltotal),2):'0');?>" id="gtotal" name="gtotal">
                                            </label>
                                            <input type="hidden" class="form-control" id="grandtotal" name="grandtotal" value="<?php  echo (!empty($grandtotal1)?number_format(($grandtotal1 + $finaltotal),2):'0');?>" readonly>
                                            <input type="hidden" class="form-control" id="totalwithoutpercentage" name="totalwithoutpercentage" value="<?php  echo number_format($totalwithoutpercentage,2);?>" readonly></strong></td>
                                        <td></td>
                                    </tr>
                                <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- End -->

                <!-- Footer Section -->
                <?php if ($data !== 'hide'){?>
                <div class="col-sm-12">
                    <div class="col-sm-12 salesfooter">

                        <div class="pull-right">
                            <button type="button" onClick="confirmSubmit('Are you sure you want to  proceed?','Yes',function(){document.getElementById('viewpage').value='prepareprescription';document.myform.submit();});" class="btn btn-success" id="saveform"> Prepare</button>
                            <button type="button" class="btn btn-danger" onClick="confirmSubmit('Are you sure you want to  cancel this sale?','Yes',function() {document.getElementById('viewpage').value='cancelsale';document.myform.submit();})">Cancel</button>
                        </div>
                    </div>
                </div>
                <?php } ?>
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
//        let percentage_added = ((<?php //echo $instpercentage; ?>// / 100) * value) + parseFloat(value);
        $('#totalamount').val(value);

        $('.switch-prescription').click(function (e) {
            e.preventDefault();
            $(this).parents('tr').children('td').eq(1).find('label')
                .css('text-decoration','line-through')
                .before("<div><select name='pharmacydrugs' id='pharmacydrugs' class='form-control select2'>" +
                "<option value=''>-- Select Drugs --</option> " +
                "<option value=''>option 2</option> " +
                "<option value=''>option 3</option> " +
                "<option value=''>option 4</option> " +
                "<option value=''>option 5</option> " +
                "</select></div>");
            $(this).parents('tr').children('td').eq(2).find('label')
                .css('text-decoration','line-through')
                .before("<div><input type='text' name='drugfreq' id='drugfreq' class='form-control'></div>")
            $(this).parents('tr').children('td').eq(3).find('label')
                .css('text-decoration','line-through')
                .before("<div><input type='text' name='drugtimes' id='drugtimes' class='form-control'></div>")
            $(this).parents('tr').children('td').eq(4).find('label')
                .css('text-decoration','line-through')
                .before("<div><input type='text' name='drugdays' id='drugdays' class='form-control'></div>")
//            alert($(this).parents('tr').html())
        });
    });
</script>