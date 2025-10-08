<?php
include('../../../../public/Doctors/consultingroom/validate.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
<link href="../../../../media/css/main.css" rel = "stylesheet" type = "text/css"/>

<script type="text/javascript" src="../../../../media/js/jquery.min.js"></script>
<script type="text/javascript" src="../../../../media/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../../../../media/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../../../../media/js/bootstrap-toggle.min.js"></script>

<script type="text/javascript" src="../../../../media/js/select2.full.js"></script>
<script type="text/javascript" src="../../../../media/js/custom.js"></script>
<script type="text/javascript" src="../../../../media/js/moment.min.js"></script>
<script type="text/javascript" src="../../../../media/js/ez.countimer.js"></script>

</head>

<body>
<form action="consultinglist.php?viewpage=saveconsultation" method="POST">
<input id="consultcode" name="consultcode" value="<?php echo $consultcode; ?>" type="hidden" />
<input id="patientname" name="patientname" value="<?php echo $patientname; ?>" type="hidden" />
<input id="patientnum" name="patientnum" value="<?php echo $patientnum; ?>" type="hidden" />
<input id="patientdate" name="patientdate" value="<?php echo $patientdate; ?>" type="hidden" />
<input id="visitcode" name="visitcode" value="<?php echo $visitcode; ?>" type="hidden" />
<input id="new_visitcode" name="new_visitcode" value="<?php echo $new_visitcode; ?>" class="form-control"
    type="hidden" />
<input id="patientcode" name="patientcode" value="<?php echo $patientcode; ?>" type="hidden" />
<input id="viewdynamic" name="viewdynamic" value="" type="hidden" />

<div class="main-content">
    <div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle" style="padding-bottom:0 !important">
                <?php $engine->msgBox($msg,$status); ?>

                <div class="moduletitleupper" style="font-size:17px; font-weight:500;"> <strong><?php echo $roomname ;?></strong> :: Consultation for
                    <?php echo  $patientname ;?> [ <?php echo  $patientnum ;?>]
                    
                    <span class="pull-right">

                        <button type="submit" id="save"
                            onclick="document.getElementById('viewpage').value='saveconsultation';document.myform.submit();"
                            class="btn btn-info"><i class="fa fa-plus-circle"></i> Submit</button>
                        <?php if(!empty($labid)){ ?>

                        <?php }else{?>

                       <a href="consultinglist.php"> <button type="button" class="btn btn-dark"
                            onclick="document.getElementById('viewpage').value='cahangeconsultationstate';document.getElementById('view').value='';document.myform.submit();"><i
                                class="fa fa-arrow-left"></i> Back </button></a>

                        <?php } ?>
                    </span> </div>
            </div>
            <p id="msg" class="alert alert-danger" hidden></p>
            
            <div class="col-sm-12">
                <div class="form-group">

                    <div class="tabish ">
                    <?php $vitallink = 'vitallist.php?viewpage=vitallist&keys='.$new_visitcode.'&patientcode='.$patientcode; ?>
                    <button type="button" class="btn btn-info btn-square" onclick="CallSmallerWindow('<?php echo $vitallink;?>')"> Vital Details</button>
                    <button type="button" class="btn btn-info btn-square" onclick='' data-toggle="modal"
                            data-target="#veiwallergies">Allergies / Chronic Cond.</button>
                    <button type="button" class="btn btn-info btn-square" onclick='' data-toggle="modal"
                            data-target="#addManagement"> Management</button>
                        <?php $linkview = 'historylist.php?viewpage=historylist&keys='.$patientnum; ?>
                    <button type="button" class="btn btn-info btn-square"
                            onclick="CallSmallerWindow('<?php echo $linkview ;?>')"> Medical History</button>
                       
                            <?php $linkviewz = 'labdetails.php?viewpage=labdetails&keys='.$new_visitcode; ?>
                                <button type="button"  onclick="CallSmallerWindow('<?php echo $linkviewz ;?>')" class="btn btn-info btn-square">LAB RESULTS</button>
                    
                    </div>
                    <div class="col-sm-12 client-vitals-opt">
                        <div class="col-sm-12 required">
                            <div class="page-wrapper">

                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#default">#</a></li>
                                    <li><a data-toggle="tab" href="#complains">Complains</a></li>
                                    <li><a data-toggle="tab" href="#labs">Investigation</a></li>
                                    <li><a data-toggle="tab" href="#diagnosis">Diagnosis</a></li>
                                    <li><a data-toggle="tab" href="#presciption">Prescription</a></li>
                                    <li><a data-toggle="tab" href="#actions">Action</a></li>
                                </ul>
                                <div class="page form">
                                    <div class="tab-content">
                                    <div id="default" class="tab-pane fade in active">
                                            <div class="form-group">
                                                <div class="col-sm-12 ">
                                                <div class="col-sm-2 consult-profile">
                                                    <img src="<?php echo $photourl ;?>" alt="photo">
                                                </div>
                                                <div class="col-sm-5 form-group">
                                                    <section liketable><b>Age:</b> <span><?php echo $patientage;?></span></section> 
                                                    <section liketable><b>Gender:</b> <span><?php echo $patientgender ; ?></span></section>
                                                </div>
                                                <div class="col-sm-5 form-group">
                                                    <section liketable><b>Blood Group:</b> <span><?php echo $patientbloodgrp ;?></span></section>
                                                    <section liketable><b>Weight:</b> <span><?php echo $patientweight ;?></span></section>
                                                </div>
                                                     
                                                </div>
                                            </div>
                                        </div>
                                        <div id="complains" class="tab-pane fade in">
                                            <div class="form-group">
                                                <div class="col-sm-12 required">
                                                    <input type="hidden" id="copmlaincode" name="copmlaincode">
                                                    <div class="form-group input-group">
                                                        <label class="control-label" for="copmlainner">Complains</label>
                                                        <input type="text" class="form-control" id="copmlainner"
                                                            name="copmlainner">
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-success"
                                                                title="Add Storyline for this complain" id="addstory"
                                                                style="margin: 24px 0 0 0;"><i
                                                                    class="fa fa-plus-circle"></i></button>
                                                            <button type="button" class="btn btn-primary"
                                                                id="addcomplain"
                                                                style="margin: 20px 0 0 0;">Add</button>
                                                        </span>
                                                    </div>
                                                    <div class="storydiv">
                                                        <label class="control-label" for="copmlainner">Storyline</label>
                                                        <textarea class="form-control" id="storyline"
                                                            name="storyline"></textarea>
                                                    </div>
                                                    <table class="table table-responsive table-bordered"
                                                        id="tblcomplain">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Complain</th>
                                                                <th>Storyline</th>
                                                                <th style="width: 0">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                        $n = 1;
                                                        while ($objcom = $stmtcomplain->FetchNextObject()){?>
                                                            <tr>
                                                                <td><?php echo $n++; ?></td>
                                                                <td><?php echo $encaes->decrypt($objcom->PC_COMPLAIN); ?>
                                                                </td>
                                                                <td><?php echo $engine->add3dots($encaes->decrypt($objcom->PC_STORYLINE),'...',20); ?>
                                                                </td>
                                                                <td><button type='button' id='deletecomplain'
                                                                        onclick='deleteComplains("<?php echo $objcom->PC_CODE; ?>","Complains");'
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
                                        </div>
                                        <div id="actions" class="tab-pane fade">
                                            <div class="form-group">
                                                <div class="col-sm-12 required">
                                                    <input type="hidden" id="copmlaincode" name="copmlaincode">
                                                    <div class="controls">
                                                        <label class="control-label" for="copmlainner">Actions</label>
                                                        <select name="actiontype" id="actiontype"
                                                            class="form-control select2 finalaction" tabindex="2">
                                                            <option value="" disabled selected>--- Select Action ---
                                                            </option>
                                                            <?php
                                                            $cltactiondetail = $engine->getConsultActions();
                                                            while($objdetail = $cltactiondetail->FetchNextObject()){
                                                                if ($objdetail->SERV_CODE !== 'SER0001') {
                                                                    ?>
                                                            <option
                                                                value="<?php echo $objdetail->SERV_CODE . '_' . $objdetail->SERV_CONSULTATIONSTATUS; ?>">
                                                                <?php echo $objdetail->SERV_NAME; ?></option>
                                                            <?php
                                                                }
                                                            } ?>
                                                        </select>
                                                    </div>


                                                    <!-- ############################################################################# -->



                                                    <div class="control-group span4 reffhos" style="margin-top:10px;">
                                                        <label class="control-label">select hospital</label>
                                                        <div class="controls">


                                                            <select name="refferalhos" id="refferalType"
                                                                class="form-control select2 finalaction1">
                                                                <option value="">-- Select Hospital --</option>
                                                                <?php
                                             
                                               while ($hospi = $referralHospitals->FetchNextObject()){
                                                echo "<option value=' ".$hospi->CHA_REFERHOSPITAL_FACCODE."@@ ".$hospi->CHA_REFERHOSPITAL_NAME."'>".$hospi->CHA_REFERHOSPITAL_NAME."</option>";
                                            }
                                            ?>
                                                            </select>

                                                        </div>
                                                    </div>







                                                    <!-- ############################################################################### -->

                                                    <div class="control-group span4 reff1" style="margin-top:10px;">
                                                        <label class="control-label">Referral Type</label>
                                                        <div class="controls">

                                                            <select name="refferalType" id="refferalType"
                                                                class="form-control select2 finalaction1">
                                                                <option value="" disabled selected>--- Select Action ---
                                                                </option>
                                                                <option value="specialist">Referral to Specialist
                                                                </option>
                                                                <option value="hospital">Referral to Hospital</option>
                                                            </select>

                                                        </div>
                                                    </div>

                                                    <div class="control-group span4 reff">
                                                        <label class="control-label">
                                                            Specialist Contact Number
                                                        </label>
                                                        <div class="controls">
                                                            <input type='text' class="form-control onlynums"
                                                                name="ctnumber" id="ctnumber">
                                                        </div>
                                                    </div>

                                                    <div class="control-group span4 reffHospital"
                                                        style="margin-bottom:10px;">
                                                        <label class="control-label">Hospital Name</label>
                                                        <div class="controls">

                                                            <select name="specialistphone" id="specialistphone"
                                                                class="form-control select2 finalaction">
                                                                <option value="" disabled selected>--- Select a
                                                                    Specialist ---</option>
                                                                <?php
                                                                    while($objspecdetail = $referralHospitals->FetchNextObject()){
                                                                    ?>
                                                                <option
                                                                    value="<?php echo $objspecdetail->REF_HOSP_TELEPHONE.','.$objspecdetail->REF_HOSP_CODE; ?>">
                                                                    <?php echo $objspecdetail->REF_HOSP_NAME; ?>
                                                                </option>
                                                                <?php
                                                                    } ?>
                                                            </select>

                                                        </div>
                                                    </div>

                                                    <div class="control-group span4 reff2" style="margin-bottom:10px;">
                                                        <label class="control-label">Specialists Name</label>
                                                        <div class="controls">

                                                            <select name="specialistphone" id="specialistphone"
                                                                class="form-control select2 finalaction">
                                                                <option value="" disabled selected>--- Select a
                                                                    Specialist ---</option>
                                                                <?php
                                                                    while($objspecdetail = $specialistdetail->FetchNextObject()){
                                                                    ?>
                                                                <option
                                                                    value="<?php echo $objspecdetail->USR_PHONENO.','.$objspecdetail->USR_CODE; ?>">
                                                                    <?php echo $objspecdetail->USR_OTHERNAME.' '.$objspecdetail->USR_SURNAME.' ('.$objspecdetail->MP_SPECIALISATION.')'; ?>
                                                                </option>
                                                                <?php
                                                                    } ?>
                                                            </select>

                                                        </div>
                                                    </div>

                                                    <div class="control-group span4 reff3">
                                                        <label class="control-label">Patient Referral Note (Will be sent
                                                            to the patient):</label>
                                                        <div class="controls">
                                                            <textarea name='refnote' id="refnote" maxlength="160"
                                                                placeholder="Message will be sent to patient"></textarea>
                                                            Character left <span id="chars">160</span>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>

                                        <div id="labs" class="tab-pane fade">
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a data-toggle="tab" href="#labrequest">Lab.
                                                        Request</a></li>
                                                <li><a data-toggle="tab" href="#xray">Radiology</a></li>
                                            </ul>
                                            <div class="page form">
                                                <div class="tab-content">
                                                    <div id="labrequest" class="tab-pane fade in active">
                                                        <div class="controls controls-row">
                                                            <div class="control-group span4">
                                                                <label class="control-label">Test:</label>
                                                                <div class="controls" style="margin-bottom:10px;">
                                                                    <select name="test" id="test"
                                                                        class="form-control select2" tabindex="2">
                                                                        <option value="">-- Select Test --</option>
                                                                        <?php while($objdpt = $stmttestlov->FetchNextObject()){  ?>
                                                                        <option
                                                                            value="<?php echo $objdpt->LTT_CODE.'@@@'.$objdpt->LTT_NAME.'@@@'.$objdpt->LTT_DISCIPLINE.'@@@'.$objdpt->LTT_DISCIPLINENAME;?>"
                                                                            <?php echo (($objdpt->LTT_CODE == $test)?'selected':'' )?>>
                                                                            <?php echo $objdpt->LTT_NAME ;?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="control-group span4">
                                                                    <label class="control-label">Clinical
                                                                        Remark:</label>
                                                                    <div class="controls">
                                                                        <textarea name='crmk' id="crmk"></textarea>
                                                                        <div class="move-low">
                                                                            <button type="button"
                                                                                class="btn btn-primary"
                                                                                id="addlabs">Add</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <table class="table table-responsive table-bordered"
                                                            id="tbllabs">
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
                                                                    <td><?php echo $n++; ?></td>
                                                                    <td><?php echo $encaes->decrypt($objlabs->LT_TESTNAME); ?>
                                                                    </td>
                                                                    <td><?php echo $encaes->decrypt($objlabs->LT_RMK); ?>
                                                                    </td>
                                                                    <td>
                                                                        <button type='button' id='deletecomplain'
                                                                            onclick='deleteComplains("<?php echo $objlabs->LT_CODE; ?>","Labs");'
                                                                            class="btn-danger removecomplain">&times;</button>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                            }
                                                            ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div id="xray" class="tab-pane fade">
                                                        <div class="controls controls-row" style="margin-bottom:10px;">
                                                            <div class="control-group span6">
                                                                <label class="control-label">Radiology:</label>
                                                                <div class="controls">
                                                                    <select name="xrayopt" id="xrayopt"
                                                                        class="form-control select2" tabindex="2">
                                                                        <option value="all" selected disabled>-- Select
                                                                            Radiology --</option>
                                                                        <?php while($objxray = $stmtxray->FetchNextObject()){  ?>
                                                                        <option
                                                                            value="<?php echo $objxray->X_CODE.'@@@'.$objxray->X_NAME ; ?>"
                                                                            <?php echo (($objdpt->X_CODE == $xrayopt)?'selected':'' )?>>
                                                                            <?php echo $objxray->X_NAME .' ('.(($objxray->X_TYPE == 1)?'X-Ray':'Ultrasound') .') ' ;?>
                                                                        </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="control-group span4">
                                                            <label class="control-label"> Remark:</label>
                                                            <div class="controls">
                                                                <textarea name='xrayrmk' id="xrayrmk"></textarea>
                                                                <div class="move-low">
                                                                    <button type="button" class="btn btn-primary"
                                                                        id="addxray">Add</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <table class="table table-responsive table-bordered"
                                                            id="tblxray">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Radiology</th>
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
                                                                    <td><?php echo $n++; ?></td>
                                                                    <td><?php echo $encaes->decrypt($objx->XT_TESTNAME); ?>
                                                                    </td>
                                                                    <td><?php echo $encaes->decrypt($objx->XT_RMK); ?>
                                                                    </td>
                                                                    <td>
                                                                        <button type='button' id='deletecomplain'
                                                                            onclick='deleteComplains("<?php echo $objx->XT_CODE; ?>","Xray");'
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
                                            </div>
                                        </div>
                                        <div id="diagnosis" class="tab-pane fade">
                                            <div class="controls controls-row" style="margin-bottom:10px;">
                                                <div class="control-group span6">

                                                    <div class="controls col-sm-8">
                                                        <label class="control-label">Diagnosis:</label>
                                                        <select name="dia" id="dia" class="form-control select2"
                                                            tabindex="2">
                                                            <option value="<?php echo $dia; ?>"> -- Select Test --
                                                            </option>
                                                            <?php while($objdpt = $stmtdiagnosislov->FetchNextObject()){  ?>
                                                            <option
                                                                value="<?php echo $objdpt->DIS_CODE.'@@@'.$objdpt->DIS_NAME ; ?>"
                                                                <?php echo (($objdpt->DIS_CODE == $dia)?'selected':'' )?>>
                                                                <?php echo $objdpt->DIS_NAME ;?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>

                                                    <div class="controls col-sm-4">
                                                        <label class="control-label">Type:</label>
                                                        <select name="diatype" id="diatype" class="form-control select2"
                                                            tabindex="2">
                                                            <option value="1"> Final </option>
                                                            <option value="2"> Provisional </option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="controls col-sm-12" style="margin-top:10px;">
                                                        <label class="control-label"> Remark:</label>
                                                        <textarea name='drmk' id="drmk" rows="4"></textarea>
                                                        <div class="move-low">
                                                            <button type="button" class="btn btn-primary" id="adddiagnosis">Add</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <table class="table table-responsive table-bordered" id="tbldiagnosis">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Diagnosis</th>
                                                        <th>Remark</th>
                                                        <th>Type</th>
                                                        <th style="width: 0">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                $n = 1;
                                                while ($objdiag = $stmtdiag->FetchNextObject()){
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $n++; ?></td>
                                                        <td><?php echo $encaes->decrypt($objdiag->DIA_DIAGNOSIS); ?>
                                                        </td>
                                                        <td><?php echo $encaes->decrypt($objdiag->DIA_RMK); ?></td>
                                                        <td><?php echo (($obj->DIA_TYPE == 1)?'Final':'Provisional'); ?>
                                                        </td>
                                                        <td>
                                                            <button type='button' id='deletecomplain'
                                                                onclick='deleteComplains("<?php echo $objdiag->DIA_CODE; ?>","Diagnosis");'
                                                                class="btn-danger removecomplain">&times;</button>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div id="presciption" class="tab-pane fade">
                                            <div class="controls controls-row" style="margin-bottom:10px;">
                                                <div class="control-group span4">
                                                    <label class="control-label">Prescription:</label>
                                                    <div class="controls">
                                                        <select name="drug" id="drug" class="form-control select2"
                                                            tabindex="2">
                                                            <option value="<?php echo $drug; ?>"> -- Select Drugs --
                                                            </option>
                                                            <?php while($objdpt = $stmtdrugslov->FetchNextObject()){  ?>
                                                            <option
                                                                value="<?php echo $objdpt->DR_CODE.'@@@'.$objdpt->DR_NAME.'@@@'.$objdpt->DR_DOSAGE.'@@@'.$objdpt->DR_DOSAGENAME ;?>"
                                                                <?php echo (($objdpt->DR_CODE == $drug)?'selected':'' )?>>
                                                                <?php echo $objdpt->DR_NAME ;?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-1" style="width: 18%">
                                                <label>Dosage</label>
                                                <input type="text" class="form-control" id="frequency" name="frequency"
                                                    placeholder="Dosage">
                                            </div>
                                            <div class="col-sm-1" style="width: 18%">
                                                <label>Times</label>
                                                <input type="text" class="form-control" id="times" name="times"
                                                    placeholder="Times">
                                            </div>
                                            <div class="col-sm-1" style="width: 16%; padding-left:0px !important;">
                                                <label>Days</label>
                                                <input type="text" class="form-control" id="days" name="days"
                                                    placeholder="Days">
                                            </div>
                                            <div class="col-sm-1" style="width: 18%">
                                                <label>Quantity.</label>
                                                <input type="text" class="form-control" id="qty" name="qty"
                                                    placeholder="Qty.">
                                            </div>
                                            <div class="col-sm-2" style="width: 25%; margin-top: 5px">
                                                <label>Route</label>
                                                <select name="route" id="route" class="form-control">
                                                    <option value="0" selected disabled>Select Route</option>
                                                    <?php while ($fetchroute = $stmtroute->FetchNextObject()){?>
                                                    <option
                                                        value="<?php echo $fetchroute->RT_CODE.'@@@'.$fetchroute->RT_NAME?>">
                                                        <?php echo $fetchroute->RT_NAME?></option>
                                                    <?php } ?>
                                                </select>
                                                <!--                        <input type="text" class="form-control" id="route" name="route" placeholder="Route">-->
                                            </div>
                                            <div class="col-sm-1 pull-right">
                                                <label id="lbl">&nbsp;</label>
                                                <button type="button" class="form-control btn btn-primary"
                                                    id="addprescription" style="margin-top: -5px;">Add</button>
                                            </div>
                                            <table class="table table-responsive table-bordered" id="tblprescription">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Prescription</th>
                                                        <th>Dosage</th>
                                                        <th>Times</th>
                                                        <th>Days</th>
                                                        <th>Quantity</th>
                                                        <th>Route</th>
                                                        <th style="width: 0">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                $n = 1;
                                                
                                                while ($objpres = $stmtpres->FetchNextObject()){
                                                
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $n++; ?></td>
                                                        <td><?php echo $encaes->decrypt($objpres->PRESC_DRUG); ?></td>
                                                        <td><?php echo $objpres->PRESC_FREQ; ?></td>
                                                        <td><?php echo $objpres->PRESC_TIMES; ?></td>
                                                        <td><?php echo $objpres->PRESC_DAYS; ?></td>
                                                        <td><?php echo $objpres->PRESC_QUANTITY; ?></td>
                                                        <td><?php echo $objpres->PRESC_ROUTENAME; ?></td>
                                                        <td>
                                                            <button type='button' id='deletecomplain'
                                                                onclick='deleteComplains("<?php echo $objpres->PRESC_CODE; ?>","Prescription");'
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
                                </div>
                                <div>
                                    <?php include ("audio-recording.php");?>
                                </div>
                                <!--					<button type="submit" onclick="document.getElementById('viewpage').value='savecomplain';document.myform.submit();" class="btn btn-info"><i class="fa fa-plus-circle"></i> Submit</button>-->
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="addManagement" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Management</h4>
                <div class="modal-body">
                    <div class="col-sm-12 ">
                        <textarea rows="6" cols="65" id="txtarea" name="txtarea">

</textarea>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" id="addm" class="btn btn-success btn-square">Save</button>
                <button type="button" class="btn btn-info btn-square" data-dismiss="modal">Close</button>
            </div>
            <div class="modal-body">
                <p>

                    <table class="table table-responsive table-bordered" id="tblmanagement">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Management</th>
                                <th style="width: 0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                    $stmtm = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_management WHERE PM_PATIENTNUM = ".$sql->Param('1')." AND PM_VISITCODE = ".$sql->Param('2')." AND PM_STATUS = ".$sql->Param('3').""),array($patientnum,$visitcode,'1'));
                    $num = 1;
                    if ($stmtm->RecordCount()>0){
                        while ($obj = $stmtm->FetchNextObject()){
				$decrypid = $obj->PM_ENCRYPKEY;
				if($decrypid != $activekey){
				$saltencrypt = $encryptkeys[$decrypid]['salt'];
                $pepperdecrypt =  $encryptkeys[$decrypid]['pepper'];
				$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
				}
				
                $txtarea = $encaes->decrypt($obj->PM_MANAGEMENT);			
                            echo '<tr>
				<td>'.$num++.'</td>
				<td>'.$txtarea.'</td>
				<td class="text-center valign-middle" width="100">
                <button class="btn btn-xs btn-danger square" type="button" onclick="deleteManagement(\''.$obj->PM_ID.'\')"><i class="fa fa-close"></i>
				</button>
                </td>
				<tr>';
                        }}
                    else{
                        echo '<tr>
					<td colspan="3">No record found.</td>
				<tr>';
                    }
                    ?>
                        </tbody>
                    </table>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="veiwallergies" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Allergies / Chronic Conditions</h4>
                <div class="modal-body">
                    <div class="col-sm-9">
                        <label class="control-label" for="chroniques">Condition Type</label>
                        <select name="condtype" id="condtype" class="form-control select2 condtype" tabindex="1">
                            <option value="0">Select type of condition</option>
                            <option value="1">Allergies</option>
                            <option value="2">Chronic Conditions</option>
                        </select>
                    </div>
                    <div class="col-sm-9 ">
                        <label class="control-label" for="allergies">Description</label>
                        <textarea rows="3" cols="61" id="txtcontent" name="txtarea" class="txtarea"
                            style="border:1px solid #cfcfcf">

</textarea>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" id="chroniques" class="btn btn-success btn-square">Save</button>
                <button type="button" class="btn btn-info btn-square" data-dismiss="modal">Close</button>
            </div>
            <div class="modal-body">
                <p>

                    <table class="table table-responsive table-bordered" id="tblmanagement">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Description</th>
                                <th style="width: 0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
            $stmtm = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient WHERE PATIENT_PATIENTNUM = ".$sql->Param('a')." "),array($patientnum));
            $num = 1;
            if ($stmtm->RecordCount()>0){
            $obj = $stmtm->FetchNextObject();
        	
        echo '<tr>
        <td>Allergies</td>
        <td>'.$obj->PATIENT_ALLERGIES.'</td>
        <td class="text-center valign-middle" width="100">
        <button class="btn btn-xs btn-danger square" type="button" onclick="if(confirm(\'You are about to delete the allergies. Note: This process cannot be reversed. Are you sure ?.\')){deleteAllergies()}else{ return false;}"><i class="fa fa-close"></i>
        </button>
        </td>
        <tr>
        <tr>
        <td>Chronic Conditions</td>
        <td>'.$obj->PATIENT_CHRONIC_CONDITION.'</td>
        <td class="text-center valign-middle" width="100">
        <button class="btn btn-xs btn-danger square" type="button" onclick="if(confirm(\'You are about to delete the chronic conditions. Note: This process cannot be reversed. Are you sure ?.\')){deleteChroniques()}else{ return false;}"><i class="fa fa-close"></i>
        </button>
        </td>
        <tr>';
                }
            else{
                echo '<tr>
            <td colspan="3">No record found.</td>
        <tr>';
            }
            ?>
                        </tbody>
                    </table>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
  
    $(document).ready(function () {
        var max_fields = 5; //maximum input boxes allowed
        var wrapper = $(".input_fields_wrap"); //Fields wrapper
        var add_button = $(".add_field_button"); //Add button ID

        var x = 0; //initlal text box count
        $(add_button).click(function (e) { //on add input button click
            e.preventDefault();

            if (x < max_fields) { //max input box allowed
                x++; //text box increment
                $(wrapper).append('<div class="col-sm-12" id="main_' + x +
                    '">    <input type = "hidden" class = "form-control" id = "memid' +
                    x +
                    '" name = "trans[memid][]"/><label>Member Name</label><input type = "text" class = "form-control" id = "titname' +
                    x +
                    '" name = "memname" placeholder = "Member Name" required></div><div class="col-sm-4"><label>Amount</label><input type = "text" class = "form-control" id = "titamount" name = "trans[tranamount][]" placeholder = "Amount" requied></div><div class="col-sm-1 gyn-add"><a class="btn btn-gyn-add square" onClick="remove_cont(' +
                    x +
                    ');"><i class="fa fa-close"></i></span></div><div class="col-sm-10"><label>Narration</label><textarea type = "text" class = "form-control" id = "narration" name = "trans[narration][]" placeholder = "Narration"></textarea></div></div>'
                ); //add input box
                adddata(x);
            }
        });

    });


    function remove_cont(x) {
        $('#main_' + x).remove();
        x--;
    };

    $("#copmlainner").autocomplete({
        source: '../../../../public/Doctors/consulatationpp/views/fetch.php',
        select: function (event, ui) {
            $("#copmlainner").val(ui.item.label);
            $("#copmlaincode").val(ui.item.value);
            return false;
        },

    });

function CallSmallerWindow(linkview) {
 var winpop =  window.open(linkview,linkview,"toolbar=no,scrollbars=yes,resizable=yes,top=160,left=245,channelmode=1,location=0,menubar=0,status=no,titlebar=0,toolbar=0,modal=1,width=1130,height=550");
 
}
</script>

</body>

</html>
