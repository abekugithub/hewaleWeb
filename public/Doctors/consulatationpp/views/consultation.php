<script type="text/javascript" src="media/js/jquery-ui.min.js"></script>

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
        <div class="page form row">
            <div class="moduletitle col-sm-12" style="padding-bottom:0 !important">
                <?php $engine->msgBox($msg, $status); ?>

                <div class="moduletitleupper" style="font-size:17px; font-weight:500;">Consultation for
                    <?php echo  $patientname; ?> [ <?php echo  $patientnum; ?>]
                    <span class="timer timerwell2"></span>

                    <span class="pull-right">
                        <span style="font-size:16px; color:#555">Patient in queue:
                            <?php echo (($totalpatient > 0) ? $totalpatient : '0'); ?></span>

                        <button type="button" id="save"
                            onclick="document.getElementById('viewpage').value='saveconsultation';document.getElementById('viewdynamic').value='consulting';document.myform.submit();"
                            class="btn btn-warning"><i class="fa fa-plus-circle"></i> Submit &amp; Next</button>

                        <button type="button" id="save"
                            onclick="document.getElementById('viewpage').value='saveconsultation';document.myform.submit();"
                            class="btn btn-info"><i class="fa fa-plus-circle"></i> Submit</button>
                        <?php if (!empty($labid)) { ?>

                        <?php } else { ?>

                        <button type="button" class="btn btn-dark"
                            onclick="document.getElementById('viewpage').value='cahangeconsultationstate';document.getElementById('view').value='';document.myform.submit();"><i
                                class="fa fa-arrow-left"></i> Back </button>

                        <?php } ?>
                    </span>
                </div>
            </div>

            <p id="msg" class="alert alert-danger" hidden></p>
            <!-- Optional Action buttons -->
            <div class="col-sm-12">
                <div class="tabish pull-right">
                    <!--<button type="button" class="btn btn-success btn-square" onclick="document.getElementById('viewpage').value='management';document.getElementById('view').value='management';document.myform.submit();"> Management</button>-->

                    <button type="button" class="btn btn-info btn-square" onclick='' data-toggle="modal"
                        data-target="#veiwallergies">Allergies / Chronic Cond.</button>


                    <button type="button" class="btn btn-success btn-square" onclick='' data-toggle="modal"
                        data-target="#addManagement"> Management</button>
                    <?php $linkview = 'index.php?pg=' . md5('Doctors') . '&amp;option=' . md5('Consultation') . '&uiid=' . md5('1_pop') . '&viewpage=historylist&view=historylist&keys=' . $patientnum; ?>
                    <button type="button" class="btn btn-info btn-square"
                        onclick="CallSmallerWindow('<?php echo $linkview; ?>')"> Medical History</button>
                    <!--<button type="button" class="btn btn-info btn-square" onclick=
                    "document.getElementById('viewpage').value='historylist';document.getElementById('view').value='historylist';document.myform.submit()"> Medical History</button>-->
                </div>
            </div>
            
            <!-- Users Profile Image and Other details -->
            <div class="col-sm-2">
                <div class="id-photo"> 
                    <img src="<?php echo $photourl; ?>" alt="" id="prevphoto" onerror="this.src='media/img/placeholder.jpg'" style="width:100% !important; margin:0px !important;">
                </div>
                <div class="form-group">
                    <div class="col-sm-12 client-info">
                        <input type="hidden" class="form-control" id="patientnum" name="patientnum"
                            value="<?php echo $patientnum; ?>">
                        <input type="hidden" class="form-control" id="visitcode" name="visitcode"
                            value="<?php echo $visitcode; ?>">
                        <input type="hidden" class="form-control" id="patient" name="patient"
                            value="<?php echo $patient; ?>">
                        <div class="row">
                            <div class="col-sm-6"><b>Age:</b> <?php echo ($patientage < 1) ? '' : $patientage; ?></div>
                            <div class="col-sm-6"><b><?php echo ($patientgender=='M')? 'Male':'Female'; ?></b></div>
                        </div>
                
                        <div id="connectControls" style="display:none">
                            <div id="iam"></div>
                        </div>

                    </div>

                    <!--Camera starts here-->
                    <div class="col-sm-12 clientself-video" style="left:-15px; top:-25px">
                        <div id="wraperselfVideo" style="width:200px; height:220px; padding-bottom:10px !important;">
                            <video autoplay class="matrixMirror" id="selfVideo" muted volume="0" width="100%"
                                height="200" style="float:left;"></video>
                        </div>
                        <?php // Matrix integration replaces legacy EasyRTC implementation ?>
                        <div id="matrixVideoCall" class="btn btn-info btn-block myspecialform startPMsg"
                            style="color:#fff !important; font-size:15px; font-weight:bold;"
                            onclick="startMatrixVideoCall()"> Start Video Call</div>

                        <div id="matrixEndCall" class="btn btn-danger btn-block myspecialform endPMsg"
                            style="width:100%; height:40px; padding-top:8px; padding-bottom:20px !important; color:#fff !important; font-size:15px; font-weight:bold;"
                            onclick="endMatrixCall()"> End Call</div>


                        <div id="matrixVoiceCall" class="btn btn-info btn-block myspecialform startPCall2"
                            style="width:100%; height:40px; padding-top:8px; padding-bottom:20px !important; color:#fff !important; font-size:15px; font-weight:bold;"
                            onclick="startMatrixVoiceCall()"> Start Voice Call</div>

                        <div id="matrixEndVoiceCall" class="btn btn-danger btn-block myspecialform endPMsg2"
                            style="width:100%; height:40px; padding-top:8px; padding-bottom:20px !important; color:#fff !important; font-size:15px; font-weight:bold;"
                            onclick="endMatrixCall()"> End Call</div>

                        <div style="position:relative;float:left;width:300px">
                            <video id="caller" width="300" height="200"></video>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chat Area for Video, Audio and Chat -->
            <div class="col-sm-4">
                <div class="chat-block">
                    <div class="col-sm-12 chat-tab-bar">
                        <div class="chat-tabs"> 
                            <b>Chat Options:</b>
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a data-toggle="tab" href="#chat" onClick="hidevideobtn()"> <i class="fa fa-comment" aria-hidden="true"></i> </a>
                                </li>
                                <li class="">
                                    <a data-toggle="tab" href="#video" onClick="initvideo()"> <i class="fa fa-video-camera" aria-hidden="true"></i></a>
                                </li>
                                <li class="">
                                    <a data-toggle="tab" href="#phone" onClick="phonecall()"><i class="fa fa-phone" aria-hidden="true"></i></a>
                                </li>
																<li class="">
                                    <a data-toggle="tab" href="#voicecall" onClick="voicecall('<?= $patientphone; ?>', '<?= $patientname; ?>')"><i class="fa fa-tty" aria-hidden="true"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div id="video" class="col-sm-12 tab-pane fade in">
                        <div class="callervideoview">
                            <video autoplay id="callerVideo" width="100%" height="300"></video>
                        </div>
                    </div>

                    <div id="phone"> 

                    </div>

                    <div id="chat" class="col-sm-12 tab-pane fade in active">
                        <div class="row">
                            <div class="col-sm-12 chatarea" id="chatareaindoc">
                                <div id="speech-bubble">
                                    <?php
                                    
                                    if ($msgdetails) {
                                        while ($obj = $msgdetails->FetchNextObject()) { 
                                            // var_dump($obj, base64_decode($encaes->decrypt($obj->CH_AUDIO),true));
                                    ?>

                                    <?php if ($obj->CH_SENDER_CODE == $usrcode) { ?>

                                    <div class="speech-bubble-rt">
                                        <div class="speech-bubble-rt speech-bubble-right" id="conversation2">
                                            <?php if($obj->CH_TYPE == "1"){ ?>
                                            <?php echo $encaes->decrypt($obj->CH_MSG); ?>
                                            <div class="formatchatdate">
                                                <div class="formatchatdate">
                                                    <?php echo date("d M Y H:i", strtotime($obj->CH_DATE)); ?>
                                                </div>
                                            </div>
                                            <?php }elseif($obj->CH_TYPE == "2"){ ?>

                                            <audio id="<?php echo $obj->CH_ID."audio"; ?>" controls="controls"
                                                style="width: 100%; height: 2.5em;">
                                                <source id="<?php echo $obj->CH_ID."audioSource"; ?>" src="" type="audio/webm">
                                                </source>
                                                Your browser does not support the audio format.
                                            </audio>

                                            <script>
                                                var decodedStringAtoB = "<?php echo base64_decode($encaes->decrypt($obj->CH_AUDIO),true); ?>";
                                                console.log("decodedStringAtoB: ", decodedStringAtoB);

                                                var audio = document.getElementById('<?php echo $obj->CH_ID."audio"; ?>');

                                                var source = document.getElementById('<?php echo $obj->CH_ID."audioSource"; ?>');
                                                source.src = decodedStringAtoB;

                                                audio.load(); //call this to just preload the audio without playing
                                                // audio.play(); //call this to play the song right away
                                            </script>

                                            <?php }elseif($obj->CH_TYPE == "3"){ ?>
                                            <img src="<?php 
                                                $base64Image = $encaes->decrypt($obj->CH_IMAGE); 
                                                echo $base64Image;
                                                ?>" alt="" width="100%" height="300px" style="margin-bottom: 0.5em; object-fit: cover; border-radius: 5px;"> <br>
                                            <div class="formatchatdate">
                                                <div class="formatchatdate">
                                                    <?php echo date("d M Y H:i", strtotime($obj->CH_DATE)); ?>
                                                </div>
                                            </div>
                                            <?php }elseif($obj->CH_TYPE == "4"){ ?>
                                            <p>File Upload</p>
                                            <div class="formatchatdate">
                                            <img src="<?php 
                                                $base64Image = base64_decode($encaes->decrypt($obj->CH_FILE), true); 
                                                $img = explode(",", $base64Image);
                                                $image = $img[1];
                                                $image = explode(":\"",$img[1]);
                                                echo "data:image/png;base64,".$image[1];
                                                ?>" alt="" width="100%" height="300px" style="margin-bottom: 0.5em; object-fit: cover; border-radius: 5px;"> <br>
                                                <div class="formatchatdate">
                                                    <?php echo date("d M Y H:i", strtotime($obj->CH_DATE)); ?>
                                                </div>
                                            </div>
                                            <?php }?>
                                        </div>
                                    </div>

                                    <?php } else { ?>
                                    <div class="speech-bubble-lt">
                                        <div class="speech-bubble-lt speech-bubble-left" id="conversation">
                                            <?php //echo $encaes->decrypt($obj->CH_MSG); ?>
                                            <!-- <div class="formatchatdate"> -->
                                            <?php //echo date("d M Y H:i", strtotime($obj->CH_DATE)); ?>
                                            <!-- </div> -->


                                            <?php  if($obj->CH_TYPE == "1"){ ?>
                                            <?php echo $encaes->decrypt($obj->CH_MSG); ?>
                                            <div class="formatchatdate">
                                                <div class="formatchatdate">
                                                    <?php echo date("d M Y H:i", strtotime($obj->CH_DATE)); ?>
                                                </div>
                                            </div>
                                            <?php }elseif($obj->CH_TYPE == "2"){ ?>

                                            <!-- <audio controls style="width: 100%; height: 2.5em;">
                                                                <source src="<?php //echo base64_decode($obj->CH_AUDIO); ?>" type="audio/webm">
                                                            </audio> -->

                                            <audio id="<?php echo $obj->CH_ID."audio"; ?>" controls="controls"
                                                style="width: 100%; height: 2.5em;">
                                                <source id="<?php echo $obj->CH_ID."audioSource"; ?>" src=""  type="audio/webm">
                                                </source>
                                                Your browser does not support the audio format.
                                            </audio>

                                            <script>
                                                var decodedStringAtoB = "<?php echo base64_decode($encaes->decrypt($obj->CH_AUDIO),true); ?>";
                                                console.log("decodedStringAtoB");
                                                console.log(decodedStringAtoB);

                                                var audio = document.getElementById(
                                                    '<?php echo $obj->CH_ID."audio"; ?>');

                                                var source = document.getElementById(
                                                    '<?php echo $obj->CH_ID."audioSource"; ?>');
                                                source.src = decodedStringAtoB;

                                                audio.load(); //call this to just preload the audio without playing
                                                // audio.play(); //call this to play the song right away
                                            </script>

                                            <div class="formatchatdate">
                                                <div class="formatchatdate">
                                                    <?php echo date("d M Y H:i", strtotime($obj->CH_DATE)); ?>
                                                </div>
                                            </div>

                                            <?php }elseif($obj->CH_TYPE == "3"){ ?>
                                            <a href="<?php 
                                                $base64Image = $encaes->decrypt($obj->CH_IMAGE); 
                                                echo $base64Image;
                                                ?>"
                                                target="_blank">
                                                <img src="<?php 
                                                $base64Image = $encaes->decrypt($obj->CH_IMAGE); 
                                                echo $base64Image;
                                                ?>" alt="" id="chat-image" width="100%"
                                                height="300px" style="margin-bottom: 0.5em; object-fit: cover; border-radius: 5px;"> <br>
                                            </a>

                                            <div class="formatchatdate">
                                                <div class="formatchatdate">
                                                    <?php echo date("d M Y H:i", strtotime($obj->CH_DATE)); ?>
                                                </div>
                                            </div>
                                            <?php }elseif($obj->CH_TYPE == "4"){ ?>
                                            <p>File Upload</p>
                                            <div class="formatchatdate">
                                            <img src="<?php 
                                                $base64Image = base64_decode($encaes->decrypt($obj->CH_FILE), true); 
                                                $img = explode(",", $base64Image);
                                                $image = $img[1];
                                                $image = explode(":\"",$img[1]);
                                                echo "data:image/png;base64,".$image[1];
                                                ?>" alt="" width="100%" height="300px" style="margin-bottom: 0.5em; object-fit: cover; border-radius: 5px;"> <br>
                                                <div class="formatchatdate">
                                                    <?php echo date("d M Y H:i", strtotime($obj->CH_DATE)); ?>
                                                </div>
                                            </div>
                                            <?php }?>

                                        </div>
                                    </div>
                                    <?php } ?>
                                    <?php }
                                    } ?>
                                </div>

                                <input type="hidden" name="sendercode" id="sendercode"
                                    value="<?php echo $usrcode; ?>">
                                <input type="hidden" id="rcvchat" name="rcvchat">
                            </div>
                            <div class="col-sm-12 chattextarea">
                                <div class="row">   
                                    <div class="col-lg-10 col-sm-9 form-group">
                                        <textarea name="chatmsg" id="chatmsg" class="chatmsg chatmsgcount form-control" cols="5" placeholder="message..." maxlength="230"></textarea>
                                    </div>
                                    <div class="col-lg-2 col-sm-3">
                                    <button type="button" id="matrixSendMessage" class="submitchat"
                                        onclick="sendMatrixMessage()"><i class="fa fa-send"></i></button>
                                    </div>
                                </div>
                                <div class="characters-count">
                                    <digit>0 </digit> / 230 
                                </div>
                            </div>
                        </div>
                    </div>

                    
                </div>
            </div>

            <!-- Doctor Findings -->
            <div class="col-sm-6 client-vitals-opt">
                <div class="col-sm-12 required">
                    <div class="page-wrapper">

                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#complains">Complains</a></li>
                            <li><a data-toggle="tab" href="#labs">Investigation</a></li>
                            <li><a data-toggle="tab" href="#diagnosis">Diagnosis</a></li>
                            <li><a data-toggle="tab" href="#presciption">Prescription</a></li>
                            <li><a data-toggle="tab" href="#actions">Action</a></li>
                        </ul>
                        <div class="page form">
                            <div class="tab-content">
                                <div id="complains" class="tab-pane fade in active">
                                    <div class="form-group">
                                        <div class="col-sm-12 required no-padding">
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
                                                        style="margin: 24px 0 0 0;">Add</button>
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
                                                        <th style="width: 70px">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $n = 1;
                                                    while ($objcom = $stmtcomplain->FetchNextObject()) { ?>
                                                    <tr>
                                                        <td><?php echo $n++; ?></td>
                                                        <td><?php echo $encaes->decrypt($objcom->PC_COMPLAIN); ?>
                                                        </td>
                                                        <td><?php echo $engine->add3dots($encaes->decrypt($objcom->PC_STORYLINE), '...', 20); ?>
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
                                                    while ($objdetail = $cltactiondetail->FetchNextObject()) {
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

                                                        while ($hospi = $referralHospitals->FetchNextObject()) {
                                                            echo "<option value=' " . $hospi->REF_HOSP_CODE . "@@ " . $hospi->REF_HOSP_NAME . "'>" . $hospi->REF_HOSP_NAME . "</option>";
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
                                                        while ($objspecdetail = $referralHospitals->FetchNextObject()) {
                                                        ?>
                                                        <option
                                                            value="<?php echo $objspecdetail->REF_HOSP_TELEPHONE . ',' . $objspecdetail->REF_HOSP_CODE; ?>">
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
                                                        while ($objspecdetail = $specialistdetail->FetchNextObject()) {
                                                        ?>
                                                        <option
                                                            value="<?php echo $objspecdetail->USR_PHONENO . ',' . $objspecdetail->USR_CODE; ?>">
                                                            <?php echo $objspecdetail->USR_OTHERNAME . ' ' . $objspecdetail->USR_SURNAME . ' (' . $objspecdetail->MP_SPECIALISATION . ')'; ?>
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
                                                                <?php while ($objdpt = $stmttestlov->FetchNextObject()) {  ?>
                                                                <option
                                                                    value="<?php echo $objdpt->LTT_CODE . '@@@' . $objdpt->LTT_NAME . '@@@' . $objdpt->LTT_DISCIPLINE . '@@@' . $objdpt->LTT_DISCIPLINENAME; ?>"
                                                                    <?php echo (($objdpt->LTT_CODE == $test) ? 'selected' : '') ?>>
                                                                    <?php echo $objdpt->LTT_NAME; ?></option>
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
                                                        while ($objlabs = $stmtlabs->FetchNextObject()) {
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
                                                                <?php while ($objxray = $stmtxray->FetchNextObject()) {  ?>
                                                                <option
                                                                    value="<?php echo $objxray->X_CODE . '@@@' . $objxray->X_NAME; ?>"
                                                                    <?php echo (($objdpt->X_CODE == $xrayopt) ? 'selected' : '') ?>>
                                                                    <?php echo $objxray->X_NAME . ' (' . (($objxray->X_TYPE == 1) ? 'X-Ray' : 'Ultrasound') . ') '; ?>
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
                                                        while ($objx = $stmtx->FetchNextObject()) {
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
                                                    <?php while ($objdpt = $stmtdiagnosislov->FetchNextObject()) {  ?>
                                                    <option
                                                        value="<?php echo $objdpt->DIS_CODE . '@@@' . $objdpt->DIS_NAME; ?>"
                                                        <?php echo (($objdpt->DIS_CODE == $dia) ? 'selected' : '') ?>>
                                                        <?php echo $objdpt->DIS_NAME; ?></option>
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

                                        </div>
                                    </div>

                                    <div class="control-group span4">
                                        <label class="control-label"> Remark:</label>
                                        <div class="controls">
                                            <textarea name='drmk' id="drmk"></textarea>
                                            <div class="move-low">
                                                <button type="button" class="btn btn-primary"
                                                    id="adddiagnosis">Add</button>
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
                                            while ($objdiag = $stmtdiag->FetchNextObject()) {
                                            ?>
                                            <tr>
                                                <td><?php echo $n++; ?></td>
                                                <td><?php echo $encaes->decrypt($objdiag->DIA_DIAGNOSIS); ?>
                                                </td>
                                                <td><?php echo $encaes->decrypt($objdiag->DIA_RMK); ?></td>
                                                <td><?php echo (($obj->DIA_TYPE == 1) ? 'Final' : 'Provisional'); ?>
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
                                                    <?php while ($objdpt = $stmtdrugslov->FetchNextObject()) {  ?>
                                                    <option
                                                        value="<?php echo $objdpt->DR_CODE . '@@@' . $objdpt->DR_NAME . '@@@' . $objdpt->DR_DOSAGE . '@@@' . $objdpt->DR_DOSAGENAME; ?>"
                                                        <?php echo (($objdpt->DR_CODE == $drug) ? 'selected' : '') ?>>
                                                        <?php echo $objdpt->DR_NAME; ?></option>
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
                                            <?php while ($fetchroute = $stmtroute->FetchNextObject()) { ?>
                                            <option
                                                value="<?php echo $fetchroute->RT_CODE . '@@@' . $fetchroute->RT_NAME ?>">
                                                <?php echo $fetchroute->RT_NAME ?></option>
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

                                            while ($objpres = $stmtpres->FetchNextObject()) {

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
                            <?php include("audio-recording.php"); ?>
                        </div>
                        <!--					<button type="submit" onclick="document.getElementById('viewpage').value='savecomplain';document.myform.submit();" class="btn btn-info"><i class="fa fa-plus-circle"></i> Submit</button>-->
                    </div>
                </div>
                <!-- Buttom Action Buttons -->
                <div class="col-sm-12 mt-4">
                    <div class="form-group">
                        <div class="moduletitleupper" style="font-size:17px; font-weight:500;">
                            <span class="pull-right">
                                <button type="button" id="save"
                                    onclick="document.getElementById('viewpage').value='saveconsultation';document.getElementById('viewdynamic').value='consulting';document.myform.submit();"
                                    class="btn btn-warning"><i class="fa fa-plus-circle"></i> Submit &amp; Next</button>

                                <button type="button" id="save"
                                    onclick="document.getElementById('viewpage').value='saveconsultation';document.myform.submit();"
                                    class="btn btn-info"><i class="fa fa-plus-circle"></i> Submit</button>
                            </span> 
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
                        <textarea rows="6" cols="65" id="txtarea" name="txtarea"></textarea>
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
                        $stmtm = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_management WHERE PM_PATIENTNUM = " . $sql->Param('1') . " AND PM_VISITCODE = " . $sql->Param('2') . " AND PM_STATUS = " . $sql->Param('3') . ""), array($patientnum, $visitcode, '1'));
                        $num = 1;
                        if ($stmtm->RecordCount() > 0) {
                            while ($obj = $stmtm->FetchNextObject()) {
                                $decrypid = $obj->PM_ENCRYPKEY;
                                if ($decrypid != $activekey) {
                                    $saltencrypt = $encryptkeys[$decrypid]['salt'];
                                    $pepperdecrypt =  $encryptkeys[$decrypid]['pepper'];
                                    $encaes = new encAESClass($saltencrypt, 'CBC', $pepperdecrypt);
                                }

                                $txtarea = $encaes->decrypt($obj->PM_MANAGEMENT);
                                echo '<tr>
				<td>' . $num++ . '</td>
				<td>' . $txtarea . '</td>
				<td class="text-center valign-middle" width="100">
                <button class="btn btn-xs btn-danger square" type="button" onclick="deleteManagement(\'' . $obj->PM_ID . '\')"><i class="fa fa-close"></i>
				</button>
                </td>
				<tr>';
                            }
                        } else {
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
                    <div class="col-sm-12">
                        <label class="control-label" for="chroniques">Condition Type</label>
                        <select name="condtype" id="condtype" class="form-control select2 condtype" tabindex="1">
                            <option value="0">Select type of condition</option>
                            <option value="1">Allergies</option>
                            <option value="2">Chronic Conditions</option>
                        </select>
                    </div>
                    <div class="col-sm-12 ">
                        <label class="control-label" for="allergies">Description</label>
                        <textarea rows="3" cols="61" id="txtarea" name="txtarea" class="txtarea"
                            style="border:1px solid #cfcfcf"></textarea>
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
                        $stmtm = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient WHERE PATIENT_PATIENTNUM = " . $sql->Param('a') . " "), array($patientnum));
                        $num = 1;
                        if ($stmtm->RecordCount() > 0) {
                            $obj = $stmtm->FetchNextObject();

                            echo '<tr>
                                    <td>Allergies</td>
                                    <td>' . $obj->PATIENT_ALLERGIES . '</td>
                                    <td class="text-center valign-middle" width="100">
                                    <button class="btn btn-xs btn-danger square" type="button" onclick="if(confirm(\'You are about to delete the allergies. Note: This process cannot be reversed. Are you sure ?.\')){deleteAllergies()}else{ return false;}"><i class="fa fa-close"></i>
                                    </button>
                                    </td>
                                    <tr>
                                    <tr>
                                    <td>Chronic Conditions</td>
                                    <td>' . $obj->PATIENT_CHRONIC_CONDITION . '</td>
                                    <td class="text-center valign-middle" width="100">
                                    <button class="btn btn-xs btn-danger square" type="button" onclick="if(confirm(\'You are about to delete the chronic conditions. Note: This process cannot be reversed. Are you sure ?.\')){deleteChroniques()}else{ return false;}"><i class="fa fa-close"></i>
                                    </button>
                                    </td>
                                <tr>';
                        } else {
                        echo    '<tr>
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
                    ');"><i class="fa fa-close"></i></a></div><div class="col-sm-10"><label>Narration</label><textarea type = "text" class = "form-control" id = "narration" name = "trans[narration][]" placeholder = "Narration"></textarea></div></div>'
                ); //add input box
                adddata(x);
            }
        });

    });


    function remove_cont(x) {
        $('#main_' + x).remove();
        x--;
    };
</script>
<script>
    $("#copmlainner").autocomplete({
        source: 'public/Doctors/consulatationpp/views/fetch.php',
        select: function (event, ui) {
            $("#copmlainner").val(ui.item.label);
            $("#copmlaincode").val(ui.item.value);
            return false;
        },

    });
</script>
<script src="https://unpkg.com/matrix-js-sdk@26.1.0/dist/browser-matrix.min.js"></script>
<script type="text/javascript">
    const matrixConfiguration = {
        baseUrl: 'https://matrix.orconssystems.net',
        userId: '@emma:matrix.orconssystems.net',
        password: 'space123'
    };

    let matrixClient = null;
    let consultRoomId = null;
    let matrixReady = false;
    let activeCall = null;

    const matrixCallEvents = (window.matrixcs && window.matrixcs.CallEvent) ? window.matrixcs.CallEvent : {};

    function escapeHtml(text) {
        return text
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }

    function sanitizeAlias(localpart) {
        const normalized = (localpart || '')
            .toString()
            .toLowerCase()
            .replace(/[^a-z0-9._=\-]+/g, '-');
        return normalized && normalized !== '-' ? normalized : 'consult-' + Date.now();
    }

    function attachMediaStream(element, stream) {
        if (!element || !stream) {
            return;
        }
        if ('srcObject' in element) {
            element.srcObject = stream;
        } else {
            element.src = window.URL.createObjectURL(stream);
        }
        const playPromise = element.play();
        if (playPromise && typeof playPromise.catch === 'function') {
            playPromise.catch(function () {
                // Autoplay might be blocked; ignore.
            });
        }
    }

    function resetCallState() {
        activeCall = null;
        $('.endPMsg, .endPMsg2').hide();
        $('.startPMsg, .startPCall2').show();
        $('.callervideoview').hide();

        const localVideo = document.getElementById('selfVideo');
        const remoteVideo = document.getElementById('callerVideo');

        if (localVideo) {
            localVideo.pause();
            localVideo.srcObject = null;
        }

        if (remoteVideo) {
            remoteVideo.pause();
            remoteVideo.srcObject = null;
        }
    }

    function showMatrixError(message, error) {
        console.error(message, error);
        const alertBox = document.getElementById('msg');
        if (alertBox) {
            alertBox.textContent = message;
            alertBox.hidden = false;
        }
    }

    function appendMatrixMessage(event) {
        const content = event.getContent ? event.getContent() : null;
        if (!content) {
            return;
        }

        let body = content.body || '';
        if (!body.trim()) {
            return;
        }

        const chatContainer = document.getElementById('speech-bubble');
        if (!chatContainer) {
            return;
        }

        const sender = event.getSender ? event.getSender() : null;
        const isMine = sender === (matrixClient ? matrixClient.getUserId() : null);

        const wrapper = document.createElement('div');
        const bubble = document.createElement('div');

        if (isMine) {
            wrapper.className = 'speech-bubble-rt';
            bubble.className = 'speech-bubble-rt speech-bubble-right';
        } else {
            wrapper.className = 'speech-bubble-lt';
            bubble.className = 'speech-bubble-lt speech-bubble-left';
        }

        bubble.innerHTML = escapeHtml(body).replace(/\n/g, '<br />');
        wrapper.appendChild(bubble);
        chatContainer.appendChild(wrapper);

        const chatArea = document.getElementById('chatareaindoc');
        if (chatArea) {
            chatArea.scrollTop = chatArea.scrollHeight;
        }
    }

    function refreshCallFeeds() {
        if (!activeCall) {
            return;
        }

        const localVideo = document.getElementById('selfVideo');
        const remoteVideo = document.getElementById('callerVideo');

        if (typeof activeCall.getLocalFeeds === 'function') {
            activeCall.getLocalFeeds().forEach(function (feed) {
                if (feed && feed.stream) {
                    attachMediaStream(localVideo, feed.stream);
                }
            });
        }

        if (typeof activeCall.getRemoteFeeds === 'function') {
            activeCall.getRemoteFeeds().forEach(function (feed) {
                if (feed && feed.stream) {
                    attachMediaStream(remoteVideo, feed.stream);
                }
            });
        }
    }

    function bindCallLifecycle(call) {
        const hangupEvent = (matrixCallEvents && matrixCallEvents.Hangup) || 'hangup';
        const errorEvent = (matrixCallEvents && matrixCallEvents.Error) || 'error';
        const feedsEvent = (matrixCallEvents && matrixCallEvents.FeedsChanged) || 'feeds_changed';

        call.on(hangupEvent, function () {
            resetCallState();
        });

        call.on(errorEvent, function (error) {
            showMatrixError('Matrix call error occurred.', error);
            resetCallState();
        });

        call.on(feedsEvent, function () {
            refreshCallFeeds();
        });

        if (typeof call.setLocalVideoElement === 'function') {
            call.setLocalVideoElement(document.getElementById('selfVideo'));
        }

        if (typeof call.setRemoteVideoElement === 'function') {
            call.setRemoteVideoElement(document.getElementById('callerVideo'));
        }
    }

    function startMatrixVideoCall() {
        if (!matrixReady || !consultRoomId) {
            showMatrixError('Matrix chat is not ready yet. Please wait a moment and try again.');
            return;
        }

        if (activeCall) {
            return;
        }

        const call = matrixcs.createNewMatrixCall(matrixClient, consultRoomId);
        if (!call) {
            showMatrixError('Unable to start a Matrix video call.');
            return;
        }

        activeCall = call;
        bindCallLifecycle(call);
        call.placeVideoCall();

        $('.startPMsg').hide();
        $('.endPMsg').show();
        $('.callervideoview').show();
    }

    function startMatrixVoiceCall() {
        if (!matrixReady || !consultRoomId) {
            showMatrixError('Matrix chat is not ready yet. Please wait a moment and try again.');
            return;
        }

        if (activeCall) {
            return;
        }

        const call = matrixcs.createNewMatrixCall(matrixClient, consultRoomId);
        if (!call) {
            showMatrixError('Unable to start a Matrix voice call.');
            return;
        }

        activeCall = call;
        bindCallLifecycle(call);
        call.placeVoiceCall();

        $('.startPCall2').hide();
        $('.endPMsg2').show();
    }

    function endMatrixCall() {
        if (activeCall && typeof activeCall.hangup === 'function') {
            activeCall.hangup('user_hangup');
        }
        resetCallState();
    }

    function sendMatrixMessage() {
        if (!matrixReady || !consultRoomId || !matrixClient) {
            showMatrixError('Matrix chat is not ready yet. Please wait a moment and try again.');
            return;
        }

        const messageField = document.getElementById('chatmsg');
        if (!messageField) {
            return;
        }

        const text = messageField.value.trim();
        if (!text) {
            return;
        }

        matrixClient.sendEvent(consultRoomId, 'm.room.message', {
            msgtype: 'm.text',
            body: text
        }).then(function () {
            messageField.value = '';
            const counter = document.querySelector('.characters-count digit');
            if (counter) {
                counter.textContent = '0';
            }
        }).catch(function (error) {
            showMatrixError('Unable to send message.', error);
        });
    }

    function loadExistingMessages(roomId) {
        const room = matrixClient.getRoom(roomId);
        if (!room) {
            return;
        }

        const events = room.getLiveTimeline().getEvents();
        events.forEach(function (event) {
            if (event.getType && event.getType() === 'm.room.message') {
                appendMatrixMessage(event);
            }
        });

        const chatArea = document.getElementById('chatareaindoc');
        if (chatArea) {
            chatArea.scrollTop = chatArea.scrollHeight;
        }
    }

    function bindMatrixEvents(roomId) {
        matrixClient.on('Room.timeline', function (event, room, toStartOfTimeline) {
            if (toStartOfTimeline) {
                return;
            }

            if (!room || room.roomId !== roomId) {
                return;
            }

            if (event.getType && event.getType() === 'm.room.message') {
                appendMatrixMessage(event);
            }
        });

        matrixClient.on('Call.incoming', function (call) {
            if (activeCall) {
                call.hangup('busy');
                return;
            }

            activeCall = call;
            bindCallLifecycle(call);
            call.answer();

            $('.startPMsg, .startPCall2').hide();
            $('.endPMsg, .endPMsg2').show();
            $('.callervideoview').show();
        });
    }

    async function ensureConsultationRoom(aliasLocalpart, roomAlias, patientName) {
        try {
            const joinedRoom = await matrixClient.joinRoom(roomAlias);
            return joinedRoom && (joinedRoom.roomId || joinedRoom.room_id);
        } catch (error) {
            if (error && (error.errcode === 'M_NOT_FOUND' || error.errcode === 'M_UNRECOGNIZED' || error.statusCode === 404)) {
                const created = await matrixClient.createRoom({
                    room_alias_name: aliasLocalpart,
                    name: `Consultation ${patientName || aliasLocalpart}`,
                    preset: 'private_chat',
                    visibility: 'private'
                });
                return created && created.room_id;
            }

            throw error;
        }
    }

    async function initMatrixConsultation() {
        const consultCodeField = document.getElementById('consultcode');
        if (!consultCodeField) {
            return;
        }

        const patientNameField = document.getElementById('patientname');
        const aliasLocalpart = sanitizeAlias(consultCodeField.value);
        const roomAlias = `#${aliasLocalpart}:matrix.orconssystems.net`;

        matrixClient = matrixcs.createClient({
            baseUrl: matrixConfiguration.baseUrl,
            timelineSupport: true
        });

        try {
            await matrixClient.loginWithPassword(matrixConfiguration.userId, matrixConfiguration.password);
        } catch (error) {
            showMatrixError('Unable to connect to the consultation chat service.', error);
            return;
        }

        matrixClient.once('sync', function (state) {
            if (state === 'PREPARED') {
                ensureConsultationRoom(aliasLocalpart, roomAlias, patientNameField ? patientNameField.value : '')
                    .then(function (roomId) {
                        if (!roomId) {
                            throw new Error('Matrix consultation room id is unavailable');
                        }

                        consultRoomId = roomId;
                        matrixReady = true;
                        bindMatrixEvents(roomId);
                        loadExistingMessages(roomId);
                        $('.startPMsg, .startPCall2').removeClass('disabled');
                    })
                    .catch(function (error) {
                        showMatrixError('Unable to prepare the consultation room.', error);
                    });
            }
        });

        matrixClient.startClient({ initialSyncLimit: 20 });
    }

    function phonecall() {
        $('#phone').show();
        $('#video').hide();
        $('#chat').hide();
    }

    function initvideo() {
        $('#phone').hide();
        $('#video').show();
        $('#chat').hide();
    }

    function hidevideobtn() {
        $('#phone').hide();
        $('#video').hide();
        $('#chat').show();
    }

    function voicecall(phone, name = 'Hewale Patient') {
        if (!phone) {
            alert('Patient phone number invalid');
            return;
        }

        const url = 'https://' + window.location.host + '/sip/phone/index.php?phone=' + phone + '&name=' + encodeURIComponent(name);
        const features = 'menubar=no,location=no,resizable=no,scrollbars=no,status=no,addressbar=no,width=320,height=480';
        window.open(url, 'ctxPhone', features);
    }

    $(document).ready(function () {
        $('#phone').hide();
        $('#video').hide();
        $('#chat').show();
        $('.endPMsg, .endPMsg2').hide();
        $('.callervideoview').hide();
        initMatrixConsultation();
    });
</script>
<!--This script is an automatic timer up-->
<script type="text/javascript">
    var timecounter = $(document).ready(function () {
        $('.timer').countimer({
            autoStart: true
        });
    });
</script>
<!--End automatic timer up-->