<?php //include ('model/js.php');?>
<div class="main-content">

    <div class="page-wrapper">
        <div class="page form">
            <input type="hidden" value="<?php echo $instpercentage?>" name="instpercentage" id="instpercentage">
            <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper">Prepare Image Prescription<button type="submit" class="btn btn-dark pull-right" onClick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit();">Back</button></div>
            </div>
            <?php $engine->msgBox($msg,$status); ?>
            <div class="col-sm-9">
                <!-- Sales Option Section -->
                <div class="col-sm-8 salesoptblock">
                    <small class=""><b>NB</b>: A <?php echo !empty($instpercentage)?$instpercentage:'0'; ?>% addition will be applied to your prices.</small>
                    <div class="col-sm-8 salesoptselect">
                        <div class="form row">
                            <div class="col-sm-6 form-group">
                                <label class="form-label required">Prescription Code:  <?php echo $prescriptioncode;?></label>
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

                            <div class="col-sm-6 form-group">
                                <label class="form-label required">Allergies:  <?php echo $allergies ;?></label>

                            </div>

                            <div class="col-sm-6 form-group">
<!--                                <label class="form-label required">Date</label>-->
<!--                                <input type="text" class="form-control" value="--><?php //echo date('d-m-Y');?><!--"id="customername" name="customername" readonly>-->
                                <input type="hidden" class="form-control" value="<?php echo $imagename;?>" id="imagename" name="imagename" >
                                <input type="hidden" class="form-control" value="<?php echo $keys;?>" id="visitcode" name="visitcode" >
                            </div>
<!--                            <div class="col-sm-6 form-group">-->
<!--                                <label class="form-label required">Customer Name </label>-->
<!--                                <input type="text" class="form-control" id="patientfullname" name="patientfullname" value="--><?php //echo $patientfullname?><!--" readonly>-->
<!--                            </div>-->
                            <div class="col-sm-6 form-group">
                                <label for="totalcost" class="form-label required">Total Cost</label>
                                <input type="text" class="form-control" name="totalcost" id="totalcost" value="<?php echo $totalcost?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 salespreparearea">
                        <div class="col-sm-12">
                            <label>Total:</label>
                            <span><?php echo $currency;?></span>
                            <input type="text" name="totalamount" id="totalamount" maxLength="7" value="<?php echo $totalamount ?>">
                        </div>
                    </div>
                </div>
                <!-- End -->

                <!-- Footer Section -->

            </div>


            <!-- Begining of image -->
            <div class="col-sm-3" style="background: #eee; padding-top: 10px">
                <table class="table table-hover">
                    <?php if (!empty($viewpage) && $viewpage === 'viewimage'){
                        if (!empty($otherage) && !empty($othergender)){
                            ?>
                            <div class="" style="margin-top: 10px">
                                <label>Please Note: <span>The prescription request below is for the person with the following details:</span></label>
                                <p><label style="width: 9em">Patient Age:</label><label><?php echo $otherage?></label></p>
                                <p><label style="width: 9em">Patient Gender:</label><label><?php echo $othergender?></label></p>
                            </div>
                        <?php } ?>
                        <img src="<?php echo SHOST_PRESCRIPTION.$patientprescimage;?>" alt="Prescription Image" style="width:100%;height:600px;" />
<!--                        <img src="https://www.hewale.net/api/media/uploads/prescription/0b37587d1c640fc0eb6e3f2fbab358c4SimeonOdo.jpg" alt="Prescription Image" style="width:400px;height:600px;" />-->
                    <?php }else{
                        if (!empty($otherage) && !empty($othergender)){
                        ?>
                        <div class="">
                            <p><b>Please Note:</b> <span>The prescription request below is for the person with the following details:</span></p>
                            <p><label style="width: 9em;font-weight: 400">Patient Age:</label><label><?php echo $otherage?></label></p>
                            <p><label style="width: 9em;font-weight: 400">Patient Gender:</label><label><?php echo $othergender?></label></p>
                        </div>
                        <?php } ?>
<!--                        <hr style="border: 1px dashed;"/>-->
                        <div style="border: 1px dashed;padding: 0 3px"><?php echo nl2br($patientprescimage); ?></div>
                    <?php
                    } ?>
                </table>
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