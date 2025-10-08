<?php $rs = $paging->paginate();?>
<style type="text/css">
    .demo {
        position: relative;
    }

    .demo i {
        position: absolute;
        bottom: 10px;
        right: 24px;
        top: auto;
        cursor: pointer;
    }
</style>
<style>
    .rowdanger {
        background-color: #97181B4D
    }

    .rowwarning {
        background-color: #EBECB9
    }

    .rowinfo {
        background-color: #C0C0C0
    }
</style>


<div class="main-content">

    <div class="page-wrapper">
        <div class="page form">


            <input type="hidden" class="form-control" id="" name="packagecode" value="<?php echo $packagecode; ?>"
                readonly>
            <input type="hidden" class="form-control" id="" name="visitcode" value="<?php echo $visitcode; ?>" readonly>
            <input type="hidden" class="form-control" id="" name="patientnum" value="<?php echo $patientnum; ?>"
                readonly>
            <input type="hidden" class="form-control" id="" name="patient" value="<?php echo $patient; ?>" readonly>
            <input type="hidden" class="form-control" id="" name="keys" value="<?php echo $keys; ?>" readonly>
            <input type="hidden" class="form-control" id="" name="vkeys" value="<?php echo $vkeys; ?>" readonly>

            <input type="hidden" class="form-control" id="" name="patientgender" value="<?php echo $patientgender; ?>"
                readonly>
            <input type="hidden" class="form-control" id="" name="patientage" value="<?php echo $patientage; ?>"
                readonly>
            <input type="hidden" class="form-control" id="" name="patientcontact" value="<?php echo $patientcontact; ?>"
                readonly>


            <input type="hidden" class="form-control" id="visitcode" name="visitcode" value="<?php echo $visitcode; ?>"
                readonly>
            <input type="hidden" class="form-control" id="patientnum" name="patientnum"
                value="<?php echo $patientnum; ?>" readonly>
            <input type="hidden" class="form-control" id="patient" name="patient" value="<?php echo $patient; ?>"
                readonly>
            <input type="hidden" class="form-control" id="patient" name="patientdate"
                value="<?php echo $patientdate; ?>" readonly>
            <input type="hidden" class="form-control" id="patient" name="Total" value="<?php echo $Total; ?>" readonly>
            <input type="hidden" class="form-control" id="patient" name="medic" value="<?php echo $medic; ?>" readonly>
            <input type="hidden" class="form-control" id="keys" name="keys" value="<?php echo $keys; ?>" readonly>
            <input type="hidden" class="form-control" id="vkey" name="vkey" value="<?php echo $vkey; ?>" readonly>
            <input type="hidden" class="form-control" id="test" name="test" value="<?php echo $test; ?>" readonly>


            <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper">Lab Request Details</div>

                <button class="btn btn-dark pull-right"
                    onclick="document.getElementById('view').value='';document.myform.submit;"
                    style="font-size:15px; padding-top:-10px; line-height:1.3em;  margin-top:-40px;" title="Back"
                    formnovalidate>Back</button>

            </div>
            <?php $engine->msgBox($msg,$status); ?>
            <div class="col-sm-12 salesoptblock">
                <div class="col-sm-8 salesoptselect">
                    <div class="form row">
                        <div class="col-sm-6 form-group">
                            <label class="form-label required">Batch Code:
                                <?php echo ($packagecode?$packagecode:'');?></label>

                        </div>
                        <div class="col-sm-6 form-group">
                            <label class="form-label required">Gender:
                                <?php echo ($patientgender?$patientgender:'');?></label>

                        </div>

                        <div class="col-sm-6 form-group">
                            <label class="form-label required">Customer Name:
                                <?php echo ($patient?$patient:'');?></label>
                            <input type="hidden" name="customername" value="<?php echo $patient;?>">
                        </div>

                        <div class="col-sm-6 form-group">
                            <label class="form-label required">Age:
                                <?php echo ($patientage?$patientage:'N/A') ; ?></label>

                        </div>

                        <div class="col-sm-6 form-group">
                            <label class="form-label required">Hewale Number:
                                <?php echo ($patientnum?$patientnum:'') ; ?></label>

                        </div>

                        <div class="col-sm-6 form-group">
                            <label class="form-label required">Request Date:
                                <?php echo date("d/m/Y",strtotime($patientdate))  ;?></label>

                        </div>

                        <div class="col-sm-6 form-group">
                            <label class="form-label required">Customer Contact:
                                <?php echo ($patientcontact?$patientcontact:'');?></label>

                        </div>

                        <div class="col-sm-6 form-group">
                            <label class="form-label required">Doctor: <?php echo ($medic?$medic:'N/A') ;?> </label>

                        </div>
                    </div>
                </div>
                <small><b>NB:</b> A service charge of 10% will be added to the total amount entered</small>
                <div class="col-sm-4 salestotalarea">
                    <div class="col-sm-12" style="/*border: 1px solid red*/height: 130px;">
                        <label style="padding-top: 1px;">Total:</label>
                        <span style="height: 20vh;padding-top: 4vh;"><?php echo $currency;?></span>
                        <input type="text" name="totalamounts" id="totalamounts" value="<?php echo $Total;?>" maxLength="7" autofocus placeholder="15.00" style="height: 20vh;font-size: 10vh;" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12" style="line-height: 0">
                        <div class="col-sm-4">
                            <!-- <label class="form-label">&nbsp;&nbsp;</label> -->
                            <button type="button" onClick="window.open('index.php?pg=<?php echo md5('Home Service')?>&option=<?php echo md5('Home Service')?>&uiid=c7e0e599d2520ee7fda7a45375e0e1b5&view=maps&ploc=<?php echo $patientlocation?>','Hewale Patient Location','toolbar=no,scrollbars=yes,resizable=yes,top=90,left=80,channelmode=1,location=0,menubar=0,status=no,titlebar=0,toolbar=0,modal=1,width=1200,height=600');" class="btn btn-default form-control"><i class="fa fa-map-marker"></i> Click here to view patient's location</button>
                        </div>
                        <div class="col-sm-4 pull-right">
                            <!-- <label class="form-label">&nbsp;&nbsp;</label> -->
                            <button type="submit" onClick="document.getElementById('viewpage').value='resultdone';document.myform.submit;" class="btn btn-success form-control"><i class="fa fa-check"></i> Done</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-10">
                <label class="form-label">&nbsp;&nbsp;</label>
            </div>
            <!-- <div class="col-sm-2">
                <label class="form-label">&nbsp;&nbsp;</label>
                <button type="submit"
                    onClick="document.getElementById('viewpage').value='resultdone';document.myform.submit;"
                    class="btn btn-success form-control"><i class="fa fa-check"></i> Done</button>
            </div> -->
            <?php if($homeservicestatus == '0' || $homeservicestatus == '2'){ ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Test</th>
                            <th>Discipline</th>
                            <th>Remarks.</th>
                            <!-- <th>Status.</th> -->
                            <!-- <th>Action</th> -->
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                    $num = 1;
                    $i =  1;
                    if($stmtlisttestdetails->Recordcount() > 0 ){
                        while ($obj = $stmtlisttestdetails->FetchNextObject()){
                    ?>
                        <tr>
                            <td><?php echo $num ?></td>
                            <td><?php echo $sql->UserDate($obj->LT_DATE,'d/m/Y') ?></td>
                            <td><?php echo $encaes->decrypt($obj->LT_TESTNAME) ?></td>
                            <td><?php echo $obj->LT_DISCPLINENAME ?></td>
                            <td><?php echo $encaes->decrypt($obj->LT_RMK) ?></td>
                            <!-- <td><?php echo (($obj->LT_STATUS == '3')?'Pending':(($obj->LT_STATUS == '6' )?'Results Attached':'N/A')) ?></td> -->
                            <!-- <td>
                            <?php echo (($obj->LT_STATUS == '3') ? '<button type="submit" class="btn btn-info btn-square" onclick="document.getElementById(\'view\').value=\'results\';document.getElementById(\'vkey\').value=\'<?php echo $obj->LT_CODE ?>\';document.getElementById(\'viewpage\').value=\'res\';document.myform.submit;">Enter Results</button>':(($obj->LT_STATUS == '8')?'<button type="submit" class="btn btn-warning btn-square" onclick="document.getElementById(\'view\').value=\'results\';document.getElementById(\'vkey\').value=\'<?php echo $obj->LT_CODE ?>\';document.getElementById(\'viewpage\').value=\'res\';document.myform.submit;">Change Results</button>':'N/A')) ?>
                            </td> -->
                            </tr>
                        <?php
                        $num ++; 					
                        $i++;	
                        }
                    }
                        ?>
                    </tbody>
                </table>
            <?php } else {
                if($stmtlisttestdetails->Recordcount() > 0 ){
                    while ($obj = $stmtlisttestdetails->FetchNextObject()){
            ?>
            <hr class="clear" />
            <div class="row">
                <div class="col-sm-12">
                    <?php if (!empty($obj->LT_IMAGE)){ ?>
                        <div class="border-sm" style="">
                            <!-- <img src="<?php echo ATTACH_LABTEST.$obj->LT_IMAGE ?>" class="thumbnail" id="" alt="lab. test image" width="608" /> -->
                            
                            <iframe id="labtestresult"
                                title="Lab Test Result"
                                width="300"
                                height="700"
                                style="border: 1px solid black;width: 90%;margin: 0 auto;display: block;min-height: 85vh;height: 100%" 
                                src="<?php echo ATTACH_LABTEST.$obj->LT_IMAGE ?>">
                            </iframe>

                        </div>
                    <?php } ?>
                    <?php if (!empty($obj->LT_TEXT) && ($encaes->decrypt($obj->LT_TEXT) != 'undefined')){ ?>
                        <div class="border-sm" style="">
                            <div class="" id="" style="padding: 10px;border: 1px solid black;width: 90%;margin: 0 auto;display: block;height: auto" ><?php echo $encaes->decrypt($obj->LT_TEXT) ?></div>
                        </div>
                    <?php } ?>
                </div>
                
            </div>

            <!-- <div class="row">
                <div class="col-sm-12" style="outline: thin solid red">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15882.31733496339!2d-0.2366674!3d5.6289428!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x79990ee5c3b6e72e!2sOrcons%20Systems%20Ltd!5e0!3m2!1sen!2sgh!4v1621430053591!5m2!1sen!2sgh" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div> -->
            
            <?php
                    }
                } 
            } 
        ?>
        </div>

    </div>

</div>