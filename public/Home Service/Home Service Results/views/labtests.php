<?php $rs = $paging->paginate();?>
<div class="main-content">

    <div class="page-wrapper">
        <div class="page form">
            <input type="hidden" class="form-control" id="" name="packagecode" value="<?php echo $packagecode; ?>"
                readonly>
            <input type="hidden" class="form-control" id="" name="visitcode" value="<?php echo $visitcode; ?>" readonly>
            <input type="hidden" class="form-control" id="patientcode" name="patientcode" value="<?php echo $patientcode; ?>"
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
                <div class="moduletitleupper">Home Service Result Details</div>

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
                <div class="col-sm-4 salestotalarea">
                    <div class="col-sm-12" style="/*border: 1px solid red*/height: 130px;">
                        <div style="">&nbsp;</div>
                        <!-- <span style="height: 20vh;padding-top: 4vh;"><?php echo $currency;?></span> -->
                        <div class="text" id="totalamounts" style="height: 20vh;font-size: 10vh;" ><?php echo $currency;?><?php echo $total; ?></div>
                    </div>
                </div>

                <div class="col-sm-4 pull-right">
                    <label class="form-label">&nbsp;&nbsp;</label>
                    <button type="button" data-toggle="modal" data-target="#exampleModal" class="btn btn-success form-control"><i class="fa fa-check"></i> Upload Result</button>
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
                            <th>Remarks</th>
                            <!-- <th>Status</th> -->
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
                            <!-- <td>
                            <?php // if ($obj->LT_STATUS == '3'){
                                // echo 'Pending';
                            // } elseif($obj->LT_STATUS == '6' ){
                                // echo 'Results Attached';
                            // } else {
                                // echo 'N/A';
                            // } 
                            ?>
                            </td> -->
                            <!-- <td>
                            <?php 
                            // if ($obj->LT_STATUS > '3' && $obj->LT_STATUS < '7') { 
                            //     echo '<button type="submit" class="btn btn-info btn-square" onclick="document.getElementById(\'view\').value=\'results\';document.getElementById(\'vkey\').value=\''. $obj->LT_CODE .'\';document.getElementById(\'viewpage\').value=\'res\';document.myform.submit();">Enter Results</button>';
                            // } elseif($obj->LT_STATUS == '8'){
                            //     echo '<button type="submit" class="btn btn-warning btn-square" onclick="document.getElementById(\'view\').value=\'results\';document.getElementById(\'vkey\').value=\''. $obj->LT_CODE .'\';document.getElementById(\'viewpage\').value=\'res\';document.myform.submit();">Change Results</button>';
                            // } else {
                            //     echo 'N/A';
                            // } 
                            ?> -->
                            </td>
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
                <!-- <div class="col-sm-6">
                    <div class="border-sm" style="">
                        <img src="<?php echo 'media'.DS.'img'.DS.'result.png' ?>" class="thumbnail" id="" alt="lab. test image" width="608" />
                    </div>
                    <div class="border-sm" style="">
                        <div class="" id="" style="padding: 10px 10px 10px 10px" ><?php echo $obj->LT_TEXT ?></div>
                    </div>
                </div> -->
                
            </div>
            <?php
                    }
                } 
            } 
        ?>
        </div>

    </div>

    <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalCenterTitle">Attach Lab. Result</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- <div class="row">
            <div class="form-group">
			    <div class="col-sm-12 required">
                    <label for="othername">Request Number</label>
                    <input type="text" class="form-control" id="" name="vkeys" value="<?php echo $requestcode; ?>" readonly>
                </div>
            </div>
        </div> -->
        <div class="row">
            <div class="form-group">
                <div class="col-sm-12 required">
                    <label for="othername">Attach (PDF ONLY)</label>
                    <input type="file" name="file" id="file" class="form-control" />
                </div>
            </div>
        </div>
        &nbsp;
        <div class="row">
            <div class="form-group">
                <div class="col-sm-12">
                    <label for="remark">Remark</label>
                    <textarea name="remark" class="form-control" rows="5"></textarea>
                </div>
            </div>
        </div>
            
        <!-- </div> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="document.getElementById('viewpage').value='';document.myform.submit();">Close</button>
        <button type="button" class="btn btn-success btn-square"  onclick="document.getElementById('viewpage').value='attached';document.myform.submit();">Save</button>
      </div>
    </div>
  </div>
</div>

</div>