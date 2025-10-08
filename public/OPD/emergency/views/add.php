<?php $engine->msgBox($msg,$status); ?>
<div class="main-content">
    <form action="" method="post" enctype="multipart/form-data" name="myform">
        <input type="hidden" name="views" value="" id="views" class="form-control" />
        <input type="hidden" name="v" value="<?php echo $v;?>" id="v" class="form-control" />
        <input type="hidden" name="emergencycode" value="<?php echo $v;?>" id="emergencycode" class="form-control" />
        <input type="hidden" name="visitcode" value="<?php echo $keys;?>" id="visitcode" class="form-control" />
        <input type="hidden" name="tab_on" value="<?php echo $tab_on;?>" id="tab_on" class="form-control" />
        <input type="hidden" name="viewpages" value="" id="viewpages" class="form-control" />
        <input type="hidden" name="keys" value="<?php echo $keys;?>" id="keys" class="form-control" />
        <input type="hidden" name="keys2" value="<?php echo $keys2;?>" id="keys2" class="form-control" />
        <input type="hidden" name="patkey" value="<?php echo $patkey; ?>" id="patkey" class="form-control" />
        <input type="hidden" name="action_search" value="" id="action_search" class="form-control" />
        <input type="hidden" name="actor" value="<?php echo $actorname?>" id="actor" class="form-control" />
        <input type="hidden" class="form-control" id="patientnum" name="patientnum" value="<?php echo $patientnum; ?>">
        <input type="hidden" class="form-control" id="patientcode" name="patientcode" value="<?php echo $patkey; ?>">
        <input type="hidden" id="faccode" name="faccode" value="<?php echo $faccode; ?>">

        <div class="page-wrapper form">
            <div class=" col-sm-2 pull-right">
                <div class="pull-right ">
                    <!--  <button type="reset" onclick="document.getElementById('v').value='group';document.getElementById('viewpages').value='';document.myform.submit();" class="btn btn-dark btn-square" style="margin-right: 5px"><i class="fa fa-arrow-left"></i> Back </button> -->
                    <button type="submit" onclick="document.getElementById('views').value='list';document.myform.submit;" class="btn btn-dark">
                        <i class="fa fa-arrow-left"></i> Back </button>

                </div>
                <!--  <div class="col-sm-6" style="position: relative;left: 60px;">
                <select name="saveoption" id="saveoption" class="form-control select2" style="width: 130px;">
                    <option value="1">Save & Add</option>
                    <option value="2">Save & Exit</option>
                </select>
            </div>-->
            </div>
            <ul class="nav nav-tabs">
                <li class="<?php echo ($tab_on=='vitals' || empty($tab_on))?'active':''?>">
                    <a data-toggle="tab" href="#vitals">1. Vitals</a>
                </li>
                <li class="<?php echo ($tab_on=='activities')?'active':''?>">
                    <a data-toggle="tab" href="#activities">2. Activities</a>
                </li>
                <li class="<?php echo ($tab_on=='consumables')?'active':''?>">
                    <a data-toggle="tab" href="#consumables">3. Consumables</a>
                </li>

                <li class="<?php echo ($tab_on=='prescription')?'active':''?>">
                    <a data-toggle="tab" href="#prescription">4. Prescription Given</a>
                </li>
                <li class="<?php echo ($tab_on=='lab')?'active':''?>">
                    <a data-toggle="tab" href="#lab">5. Lab Request</a>
                </li>
                <li class="<?php echo ($tab_on=='xray')?'active':''?>">
                    <a data-toggle="tab" href="#xray">6. X-Ray</a>
                </li>

                <li class="<?php echo ($tab_on=='reports')?'active':''?>">
                    <a data-toggle="tab" href="#report">7. Reports</a>
                </li>
                <li class="<?php echo ($tab_on=='action')?'active':''?>">
                    <a data-toggle="tab" href="#action">8. Action</a>
                </li>
            </ul>


            <div class="page form">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="id-photo">
                            <img src="<?php echo SHOST_PASSPORT; ?><?php echo isset($image)?$image:'media/img/avatar.png';?>" alt="" onError="this.src='media/img/avatar.png'"
                                id="prevphoto" style="width:100% !important; margin:0px !important;">
                        </div>
                    </div>

                    <div class="col-sm-10">
                        <div class="form-group">
                            <br>
                            <div class="col-sm-12 client-info">
                                <table class="table client-table">
                                    <tr>
                                        <td>
                                            <b>Name:</b>
                                            <?php echo $client->REQU_PATIENT_FULLNAME;?>
                                        </td>
                                        <td>
                                            <b>Request Date:</b>
                                            <?php echo $client->REQU_DATE;?>
                                        </td>
                                        <td>
                                            <b>Patient No.:</b>
                                            <?php echo $client->REQU_PATIENTNUM;?>
                                        </td>
                                        <td>
                                            <b>Emergency 1.:</b>
                                            <?php echo $client->PATIENT_EMERGNAME1.' '.$client->PATIENT_EMERGNUM1;?>
                                        </td>
                                        <td>
                                            <b>Emergency 2.:</b>
                                            <?php echo $client->PATIENT_EMERGNAME2.' '.$client->PATIENT_EMERGNUM2;?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Blood Group:</b>
                                            <?php echo $client->PATIENT_BLOODGROUP;?>
                                        </td>
                                        <td>
                                            <b>Alergies:</b>
                                            <?php echo $client->PATIENT_ALLERGIES;?>
                                        </td>
                                        <td>
                                            <b>Age:</b>
                                            <?php echo $patientage;?>
                                        </td>
                                        <td>
                                            <b>Request Officer:</b>
                                            <?php echo $client->REQU_ACTORNAME;?>
                                        </td>
                                        <td>
                                            <b>Service Name:</b>
                                            <?php echo $client->REQU_SERVICENAME;?>
                                        </td>
                                        <td>
                                            <b>Chronic Condition:</b>
                                            <?php echo $client->PATIENT_CHRONIC_CONDITION;?>
                                        </td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="tab-content">
                        <div id="vitals" class="tab-pane fade <?php echo ($tab_on=='vitals'|| empty($tab_on))?'in active':''?>">
                        <h3>Vitals</h3>
                            <p>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="col-sm-12 client-vitals-opt">
                                            <div class="col-sm-4 required">
                                                <label class="control-label" for="fname">Vitals Type</label>
                                                <select class="form-control" name="vitals_type" id="vitals_type">
                                                    <option value="" disabled selected hidden>---------</option>
                                                    <?php
                                                        while($obj1 = $stmtoptions->FetchNextObject()){
                                                    ?>
                                                        <option value="<?php echo $obj1->VIT_NAME; ?>" <?php echo (($obj1->VIT_NAME == $vitals_type)?'selected="selected"':'') ;?> >
                                                            <?php echo $obj1->VIT_NAME; ?>
                                                        </option>
                                                        <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-4 required">
                                                <label for="vitals_value">Value</label>
                                                <input type="text" class="form-control" id="vitals_value" name="vitals_value">
                                            </div>
                                            <div class="btn-group">
                                                <div class="col-sm-4">
                                                    <label for="othername">&nbsp;</label>
                                                    <button type="button" id="addvitals" name="addvitals" class="btn btn-info ">
                                                        <i class="fa fa-plus-circle"></i> Add</button>
                                                </div>
                                                <!--<div class="col-sm-4">
                            <label for="other">&nbsp;</label>
                    <button type="button" class="btn btn-success" onclick="saveVitals();">Save</button>
                        </div>-->
                                            </div>
                                        </div>
                                        <div class="col-sm-12 client-vitals">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Vital Type</th>
                                                        <th>Value</th>
                                                        <th width="50">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="vitalsdata">
                                                    <!-- Table data goes here from JS.php -->
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-sm-12 history-vitals">
                                            <h4>Previous Vitals Records</h4>
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Vital Type</th>
                                                        <th>Value</th>
                                                        <th>Added By</th>
                                                        <th width="50">Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="vit">
                                                    <?php if(is_array($vitals_array) && count($vitals_array)){
                                                    $i=1;
                                                    foreach ($vitals_array as $value){
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $i; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $value['VITALS_TYPE'];?>
                                                        </td>
                                                        <td>
                                                            <?php echo $value['VITALS_VALUE'];?>
                                                        </td>
                                                        <td>
                                                            <?php echo $value['VITALS_ACTOR'];?>
                                                        </td>
                                                        <td>
                                                            <?php echo $sql->userDate($value['VITALS_DATE'],'d/m/Y');?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                $i++;
                                                }
                                                }?>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </p>
                        </div>

                        <!--Prescription Given-->

                        <div id="prescription" class="tab-pane fade <?php echo ($tab_on=='prescription')?'in active':''?> ">
                            <h3>Prescription Given</h3>
                            <div class="col-sm-12 client-vitals-opt">
                                <div class="col-sm-3">
                                    <label>Drug</label>
                                    <select name="drug" id="drug" class="form-control select2" tabindex="2">
                                        <option value="<?php echo $drug; ?>"> -- Select Drugs --</option>
                                        <?php while($objdpt = $stmtdrugslov->FetchNextObject()){  ?>
                                        <option value="<?php echo $objdpt->DR_CODE.'@@@'.$objdpt->DR_NAME.'@@@'.$objdpt->DR_DOSAGE.'@@@'.$objdpt->DR_DOSAGENAME ;?>"
                                            <?php echo (($objdpt->DR_CODE == $drug)?'selected':'' )?> ><?php echo $objdpt->DR_NAME ;?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <label>Days</label>
                                    <input type="numbers" class="form-control" id="days" name="days" placeholder="Days">
                                </div>
                                <div class="col-sm-2">
                                    <label>Frequency</label>
                                    <input type="numbers" class="form-control" id="frequency" name="frequency" placeholder="Frequency">
                                </div>
                                <div class="col-sm-2">
                                    <label>Times</label>
                                    <input type="numbers" class="form-control" id="times" name="times" placeholder="Times">
                                </div>
                                <div class="col-sm-2 pull-right">
                                    <label id="lbl">&nbsp;</label>
                                    <button type="button" class="form-control btn btn-primary" id="addprescription">Add</button>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <table class="table table-responsive table-hover" id="tblprescription">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Prescription</th>
                                            <th>Days</th>
                                            <th>Frequency</th>
                                            <th>Times</th>
                                            <th style="width: 0">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $n = 1;
                                            while ($objpres = $stmtpres->FetchNextObject()){
                                        ?>
                                            <tr>
                                                <td>
                                                    <?php echo $n++; ?>
                                                </td>
                                                <td>
                                                    <?php echo $encaes->decrypt($objpres->PRESC_DRUG); ?>
                                                </td>
                                                <td>
                                                    <?php echo $objpres->PRESC_DAYS; ?>
                                                </td>
                                                <td>
                                                    <?php echo $objpres->PRESC_FREQ; ?>
                                                </td>
                                                <td>
                                                    <?php echo $objpres->PRESC_TIMES; ?>
                                                </td>
                                                <td>
                                                    <button type='button' id='deletecomplain' onclick='deleteComplains("<?php echo $objpres->PRESC_CODE; ?>","Prescription");'
                                                        class="btn-danger removecomplain">&times;</button>
                                                </td>
                                            </tr>
                                            <?php
                                            }
                                            ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--End of Prescription Given-->

                        <!-- Lab-->
                        <div id="lab" class="tab-pane fade <?php echo ($tab_on=='lab')?'in active':''?> ">
                            <h3>Lab Request</h3>
                            <div class="col-sm-12 client-vitals-opt">
                                <div class="control-group span4">
                                    <div class="controls col-sm-3" style="margin-bottom:10px;">
                                        <label class="control-label">Test:</label>

                                        <select name="test" id="test" class="form-control select2" tabindex="2">
                                            <option value="<?php echo $test; ?>"> -- Select Test --</option>
                                            <?php while($objdpt = $stmttestlov->FetchNextObject()){  ?>
                                            <option value="<?php echo $objdpt->LTT_CODE.'@@@'.$objdpt->LTT_NAME.'@@@'.$objdpt->LTT_DISCIPLINE.'@@@'.$objdpt->LTT_DISCIPLINENAME;?>"
                                                <?php echo (($objdpt->LTT_CODE == $test)?'selected':'' )?> >
                                                <?php echo $objdpt->LTT_NAME ;?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="controls col-sm-6">
                                        <label class="control-label">Clinical Remark:</label>

                                        <textarea name='crmk' id="crmk"></textarea>

                                    </div>
                                    <div class="col-sm-2 pull-right">
                                        <label id="lbl">&nbsp;</label>
                                        <button type="button" class="form-control btn btn-primary" id="addlabs">Add</button>
                                    </div>

                                </div>
                            </div>
                            <div class="col-sm-12">
                                <table class="table table-responsive table-hover" id="tbllabs">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Lab. Test</th>
                                            <th>Clinical Remark</th>
                                            <th style="width: 0">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $n = 1;
                                            while ($objlabs = $stmtlabs->FetchNextObject()){
                                        ?>
                                            <tr>
                                                <td>
                                                    <?php echo $n++; ?>
                                                </td>
                                                <td>
                                                    <?php echo $encaes->decrypt($objlabs->LT_TESTNAME); ?>
                                                </td>
                                                <td>
                                                    <?php echo $encaes->decrypt($objlabs->LT_RMK); ?>
                                                </td>
                                                <td>
                                                    <button type='button' id='deletecomplain' onclick='deleteComplains("<?php echo $objlabs->LT_CODE; ?>","Labs");' class="btn-danger removecomplain">&times;</button>
                                                </td>
                                            </tr>
                                            <?php
                                            }
                                            ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- End of Lab-->

                        <!--Prescription Given-->

                        <div id="xray" class="tab-pane fade <?php echo ($tab_on=='xray')?'in active':''?> ">
                            <h3>X-Ray</h3>
                            <div class="col-sm-12">
                                <div class="col-sm-12 row client-vitals-opt">
                                        <div class="col-sm-4">
                                            <label class="control-label">X-ray:</label>

                                            <select name="xrayopt" id="xrayopt" class="form-control select2" tabindex="2">
                                                <option value="all" selected disabled>-- Select X-ray --</option>
                                                <?php while($objxray = $stmtxray->FetchNextObject()){  ?>
                                                <option value="<?php echo $objxray->X_CODE.'@@@'.$objxray->X_NAME ; ?>" <?php echo (($objdpt->X_CODE == $xrayopt)?'selected':'' )?> >
                                                    <?php echo $objxray->X_NAME ;?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="control-label"> Remark:</label>
                                            <textarea name='xrayrmk' id="xrayrmk"></textarea>
                                        </div>
                                        <div class="col-sm-2">
                                            <label id="lbl">&nbsp;</label>
                                            <button type="button" class="form-control btn btn-primary" id="addxray">Add</button>
                                        </div>
                                </div>
                                <div class="col-sm-12">
                                    <table class="table table-responsive table-hover" id="tblxray">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>X-ray</th>
                                                <th>Remark</th>
                                                <th style="width: 0">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $n = 1;
                                                while ($objx = $stmtx->FetchNextObject()){
                                                    ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $n++; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $encaes->decrypt($objx->XT_TESTNAME); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $encaes->decrypt($objx->XT_RMK); ?>
                                                    </td>
                                                    <td>
                                                        <button type='button' id='deletecomplain' onclick='deleteComplains("<?php echo $objx->XT_CODE; ?>","Xray");' class="btn-danger removecomplain">&times;</button>
                                                    </td>
                                                </tr>
                                                <?php
                                                }
                                                ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!--Prescription Given-->
                        <div id="activities" class="tab-pane fade <?php echo ($tab_on=='activities')?'in active':''?> ">
                            <h3>Activities</h3>

                            <div class="col-sm-12">
                                <div class="col-sm-12 client-vitals-opt form-group">
                                    <div class="col-sm-3">
                                        <label for="triage">Select Type:</label>
                                        <select name="triage" id="triage" class="form-control select2">
                                            <option value="" selected disabled>Type</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="condition">Date/Time</label>
                                        <input type="datetime" class="form-control" id="condition" name="condition">
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="condition">Remarks</label>
                                        <textarea type="text" class="form-control" id="condition" name="condition"></textarea>
                                    </div>
                                    <div class="col-sm-2">
                                        </br>
                                        <button type="submit" onclick="document.getElementById('viewpage').value='activities';document.getElementById('views').value='add';document.getElementById('tab_on').value='activities';document.myform.submit;"
                                            class="btn btn-info">
                                            <i class="fa fa-plus"></i> Add </button>
                                    </div>
                                </div>

                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <!--                    <th></th>-->
                                            <th>#</th>
                                            <th>Type</th>
                                            <th>Date/Time</th>
                                            <th>Remark</th>
                                            <th>Added By</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(is_array($activity_array) && count($activity_array)){
                                	$i=1;
                                foreach ($activity_array as $value){
                                	?>
                                        <tr>
                                            <td>
                                                <?php echo $i; ?>
                                            </td>
                                            <td>
                                                <?php echo $value['ACTIVITY_TRIAGE'];?>
                                            </td>
                                            <td>
                                                <?php echo $sql->userDate($value['ACTIVITY_DATE'],'d/m/Y');?>
                                            </td>
                                            <td>
                                                <?php echo $value['ACTIVITY_BED'];?>
                                            </td>
                                            <td>
                                                <?php echo $value['ACTIVITY_ACTOR'];?>
                                            </td>

                                        </tr>
                                        <?php
                                 $i++;
                                 }
                                }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Consumables -->
                        <div id="consumables" class="tab-pane fade <?php echo ($tab_on=='consumables')?'in active':''?>">
                            <h3>Consumables</h3>
                            <p>
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <div class="col-sm-12 client-vitals-opt">
                                            <div class="col-sm-4">
                                                <label for="product">Product :</label>
                                                <input type="text" class="form-control" id="product" name="product">
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="quantity">Quantity:</label>
                                                <input type="text" class="form-control" id="quantity" name="quantity">
                                            </div>
                                            <div class="col-sm-4">
                                                <!--                    <label for="prnum"></label><br>-->
                                                <button type="submit" onclick="document.getElementById('viewpage').value='consumables';document.getElementById('views').value='add';document.getElementById('tab_on').value='consumables';document.myform.submit;"
                                                    id="add" class="btn btn-info" style="margin-top: 24px">
                                                    <i class="fa fa-plus"></i> Add </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <table id="datatable" class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Product</th>
                                                        <th>Quantity</th>
                                                        <th>Added By</th>
                                                        <th>Date Added</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if(is_array($consumbles_array) && count($consumbles_array)){
                                                        $i=1;
                                                        foreach ($consumbles_array as $value){
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $i; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $value['CONSUMABLE_ITEM'];?>
                                                        </td>
                                                        <td>
                                                            <?php echo $value['CONSUMBALE_QUANTITY'];?>
                                                        </td>
                                                        <td>
                                                            <?php echo $value['CONSUMABLE_ACTOR'];?>
                                                        </td>
                                                        <td>
                                                            <?php echo $sql->userDate($value['CONSUMABLE_DATE'],'d/m/Y');?>
                                                        </td>
                                                    </tr>
                                                    <?php $i++;}}?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </p>
                        </div>

                        <div id="report" class="tab-pane fade <?php echo ($tab_on=='reports')?'in active':''?>">
                            <h3>Reports</h3>
                            <p>
                                <div class="col-sm-12">
                                    <div class="col-sm-12 client-vitals-opt">
                                        <div class="col-sm-8">
                                            <label for="reportarea">Enter Reports</label>
                                            <textarea type="text" class="form-control" id="reportarea" name="reportarea"></textarea>
                                        </div>
                                        <div class="col-sm-4">
                                            <!--                    <label for="prnum"></label><br>-->
                                            <button type="submit" id="addreport" class="btn btn-info" style="margin-top: 24px">
                                                <i class="fa fa-plus"></i> Add </button>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <!--                    <th></th>-->
                                                    <th>#</th>
                                                    <th>Summary</th>
                                                    <th>Added By</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </p>
                        </div>

                        <div id="action" class="tab-pane fade <?php echo ($tab_on=='action')?'in active':''?>">
                            <h3>Action</h3>
                            <p>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="col-sm-8">
                                            <label for="dischargearea">Reasons:</label>
                                            <textarea type="text" class="form-control" id="dischargearea" name="dischargearea"></textarea>
                                        </div>
                                        <div class="col-sm-4">
                                            <!--                    <label for="prnum"></label><br>-->
                                            <button type="submit" id="savedischarge" class="btn btn-success" style="margin-top: 24px">
                                                <i class="fa fa-check"></i> Save </button>
                                        </div>

                                    </div>



                                </div>
                                <!--<div class="btn-group pull-right">
                <div class="col-sm-12">


                    <button type="submit" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='save';document.myform.submit;" class="btn btn-info"> Save </button>

                </div>
            </div>-->
                            </p>
                        </div>
                    </div>
                </div>
            </div> </div>



        </div>