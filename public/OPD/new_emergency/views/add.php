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

        <div class="page-wrapper">
           
            <div class="page form">
                <div class="row">
                    <div class=" col-sm-12">
                        <div class="moduletitle" style="margin-bottom:0px;">
                            <div class="moduletitleupper">Vitals
                                <span class="pull-right ">
                                    <button type="submit" onclick="document.getElementById('views').value='list';document.myform.submit;" class="btn btn-dark"><i class="fa fa-arrow-left"></i> Back </button>
                                    <button type="button" class="btn btn-success" onclick="saveVitals();"><i class="fa fa-check"></i> Save</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <div class="id-photo">
                            <img src="<?php echo SHOST_PASSPORT; ?><?php echo isset($image)?$image:'avatar.png';?>" alt="" id="prevphoto" style="width:100% !important; margin:0px !important;"
                                onError="this.src='media/img/avatar.png'">
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
                                            <b>Chronic Condition:</b>
                                            <?php echo $client->PATIENT_CHRONIC_CONDITION;?>
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
                                            <b>Age:</b>
                                            <?php echo $patientage;?>
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
                                                <label for="othername">Value</label>
                                                <input type="text" class="form-control" id="vitals-value" name="vitals-value">
                                            </div>
                                            <div class="btn-group">
                                                <div class="col-sm-4">
                                                    <label for="othername">&nbsp;</label>
                                                    <button type="button" onclick="addvitals();" class="btn btn-info ">
                                                        <i class="fa fa-plus-circle"></i> Add</button>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="other">&nbsp;</label>

                                                </div>
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
                                    </div>




                                </div>

                            </p>

                            <p>
                                <div class="col-sm-12">
                                    <div class="form-group">

                                        <div class="col-sm-3 client-triage-opt">
                                            <div class="col-sm-12">
                                                <label for="triage">Select Triage:</label>
                                                <select name="triage" id="triage" class="form-control select2">
                                                    <option value="" selected disabled>Triage</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 client-triage-opt">
                                            <div class="col-sm-12">
                                                <label for="availablebed">Available Bed:</label>
                                                <select name="availablebed" id="availablebed" class="form-control select2">
                                                    <option value="" selected disabled>Bed</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 client-triage-opt">
                                            <label for="doctor">Prescribe a doctor:</label>
                                            <div class="col-sm-12">
                                                <select name="doctor" id="doctor" class="form-control select2">
                                                    <option value="" selected disabled>Select doctor</option>
                                                    <?php 
                            if ($stmtprescriber->RecordCount()>0){
                            while ($prescriber= $stmtprescriber->FetchNextObject()){?>
                                                    <option value="<?php echo $prescriber->USR_CODE.'@@@'.$prescriber->USR_FULLNAME?>">
                                                        <?php echo $prescriber->USR_FULLNAME .' '.(($prescriber->USR_ONLINE_STATUS=='1')?"(Available)":"(Unavailable)")?>
                                                    </option>
                                                    <?php } }?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 client-reports-opt">
                                            <div class="col-sm-12">
                                                <label for="condition">Enter Report</label>
                                                <textarea type="text" class="form-control" id="condition" name="condition"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </p>


                        </div>

                    </div>
                </div>
            </div>
        </div>



</div>