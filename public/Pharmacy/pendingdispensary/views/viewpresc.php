<div class="main-content">

    <div class="page-wrapper">
        <div class="page form">
            <input type="hidden" value="<?php echo $instpercentage?>" name="instpercentage" id="instpercentage">
            <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper">Prepare Prescription <button type="submit" class="btn btn-dark pull-right" onClick="document.getElementById('view').value='';document.getElementById('viewpage').value='cancelsale';;document.myform.submit();">Back</button></div>
                <?php $engine->msgBox($msg,$status); ?>
            </div>
            <div class="col-sm-12 salesoptblock">
                <div class="col-sm-8 salesoptselect">
                    <div class="form row">
                        <div class="col-sm-6 form-group">
                            <label class="form-label required">Prescription Code: <?php echo $prescriptioncode;?></label>
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

                        <div class="col-sm-3 form-group">
                            <label class="form-label required">Diagnosis:  <?php echo $allergies ;?></label>

                        </div>



                        <div class="col-sm-2">
                            <label class="form-label">&nbsp;&nbsp;</label>

                        </div>

                    </div>
                </div>
                <div class="col-sm-4 salestotalarea">
                    <div class="col-sm-12">
                        <label>Total:</label>
                        <span><?php echo $currency;?></span>
                        <input type="text" name="totalamount" id="totalamount" value="<?php echo $totalview ?>" maxLength="7" >
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
                                    <th>Dosage</th>
                                    <th>Price/(Top Up)</th>
                                    <th width="5%">Quantity</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $num = 1;
                                $commission = 0;
                                $percentage = $total = 0;
                                if (is_array($result) && count($result) > 0){
                                    foreach ($result as $res) {
                                        ?>
                                        <tr>
                                            <td><?php echo $num++; ?></td>
                                            <td><?php echo $encaes->decrypt($res['PEND_DRUG']) ?></td>
                                            <td><?php echo $res['PEND_DOSAGENAME'] ?></td>
                                            <td><?php echo $res['PEND_UNITPRICE'] ?></td>
                                            <td><?php echo $res['PEND_QUANTITY'] ?></td>
                                            <td><?php echo number_format($res['PEND_TOTAL'], 2); ?></td>
                                        </tr>
                                        <?php
                                        $commission = $commission + $res['PEND_TOTALCOMMISSION'];
                                        $percentage = number_format($res['PEND_PERCENTAGE'],0);
                                        $total = number_format($res['PEND_GRAND_TOTAL'], 2);
                                    }
                                }
                                ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="3"></td>
                                    <td style="text-align: right">Service Charge (<?php echo $percentage?>%)</td>
                                    <td></td>
                                    <td><?php echo $commission?></td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td style="text-align: right"><strong>Total</strong></td>
                                    <td></td>
                                    <td><?php echo $total?></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- End -->

                <!-- Footer Section -->
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
    });
</script>