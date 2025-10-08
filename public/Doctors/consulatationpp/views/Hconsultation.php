<script type="text/javascript" src="media/js/jquery-ui.min.js"></script>
<!--<form name="myform" id="myform" method="post" action="#">
    <input id="view" name="view" value="" type="hidden" />
    <input id="viewpage" name="viewpage" value="" type="hidden" />
    <input id="keys" name="keys" value="" type="hidden" />
    <input id="micro_time" name="micro_time" value="<?php //echo md5(microtime()); ?>" type="hidden" />
-->

    <input id="consultcode" name="consultcode" value="<?php echo $consultcode; ?>" type="hidden" />
    <input id="patientname" name="patientname" value="<?php echo $patientname; ?>" type="hidden" />
    <input id="patientnum" name="patientnum" value="<?php echo $patientnum; ?>" type="hidden" />
    <input id="patientdate" name="patientdate" value="<?php echo $patientdate; ?>" type="hidden" />
    <input id="new_visitcode" name="visitcode" value="<?php echo $visitcode; ?>" type="hidden" />
    <input id="patientcode" name="patientcode" value="<?php echo $patientcode; ?>" type="hidden" />
    <input id="activeinstitution" name="activeinstitution" value="<?php echo $activeinstitution; ?>" type="hidden" />

<div class="main-content">
  <div class="page-wrapper">
    <div class="page form">
      <div class="moduletitle" style="padding-bottom:0 !important">
        <div class="moduletitleupper" style="font-size:17px; font-weight:500;">Consultation for <?php echo  $patientname ;?> [ <?php echo  $patientnum ;?>]<span class="pull-right">
          <button type="button" id="save" onclick="document.getElementById('viewpage').value='saveconsultation';document.myform.submit();" class="btn btn-info"><i class="fa fa-plus-circle"></i> Submit</button>
          <button type="button"  class="btn btn-dark" onclick="document.getElementById('viewpage').value='';document.getElementById('view').value='';document.myform.submit();"><i class="fa fa-arrow-left"></i> Back </button>
          </span> </div>
      </div>
      <p id="msg" class="alert alert-danger" hidden></p>
      
      <?php 
	  $stmtem = $sql->Execute($sql->Prepare("SELECT * FROM hms_firstaid WHERE FIR_STATUS = '1' AND FIR_VISITCODE=".$sql->Param('a')." "),array($new_visitcode));
	  
            print $sql->ErrorMsg();
            if ($stmtem->RecordCount() > 0){
				$msg = 'First Aid';
				$status = 'error';
	  $engine->msgBox($msg,$status); 
	  }
	  ?>
      <div class="col-sm-2">
        <div class="id-photo"> <img src="<?php echo(!empty($photourl))?$photourl:'media/img/avatar.png';?>" alt="Patient Image" id="prevphoto" style="width:100% !important; margin:0px !important;"> </div>
        <div class="form-group">
          <div class="col-sm-12 client-info">
            <input type="hidden" class="form-control" id="patientnum" name="patientnum" value="<?php echo $patientnum; ?>">
<!--            <input type="hidden" class="form-control" id="visitcode" name="visitcode" value="--><?php //echo $visitcode; ?><!--">-->
            <input type="hidden" class="form-control" id="patient" name="patient" value="<?php echo $patient; ?>">
            </div>
          
          <!--Camera starts here-->
          <div class="col-sm-12 clientself-video" style="left:-15px; top:-25px">
            <video autoplay class="easyrtcMirror" id="selfVideo" muted volume="0" width="200" height="200"></video>
            <div id="otherClients"> </div>
            <video style="float:left" id="self" width="200" height="200"></video>
            <div style="position:relative;float:left;width:300px">
              <video id="caller" width="300" height="200"></video>
            </div>
          </div>
          
          <!--         
            <div id="videos">
            <video autoplay class="easyrtcMirror" id="selfVideo" muted volume="0" ></video>
            <div style="position:relative;float:left;">
            <video autoplay id="callerVideo"></video>
            </div> </div> --> 
          
          <!--<div id="demoContainer">
          <div id="connectControls">
            <div id="iam">Not yet connected...</div>
            <br />
            <strong>Connected users:</strong>
            <div id="otherClients"></div>
          </div>
          <div id="videos">
            
            <!-- <div style="position:relative;float:left;">
            <video autoplay id="callerVideo"></video>
            </div> --> 
          <!-- each caller video needs to be in it"s own div so it"s close button can be positioned correctly --> 
          <!-- </div>
        </div> --> 
          
          <!--Camera ends here--> 
        </div>
      </div>
      <div class="col-sm-10">
        <div class="form-group">
        <?php if($usrtype == 2){ ?>
          <div class="col-sm-4">
            <div class="form-group">
              <div class="col-sm-12 chatheadexp">
                <div class="innerchatwrap">
                  <div class="onlineheadertop">
                    <div align="right"> <span class="chatawe">
                      <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#chat"><i class="fa fa-comment" aria-hidden="true"></i></a></li>
                        <li class=""><a data-toggle="tab" href="#video" onClick="connect()"> <i class="fa fa-video-camera" aria-hidden="true"></i></a></li>
                        <li class=""><a data-toggle="tab" href="#phone"><i class="fa fa-phone" aria-hidden="true"></i></a></li>
                      </ul>
                      </span> </div>

                    <!--<label class="control-label" for="fname">Chat</label>-->
                  </div>
                  <div class="col-sm-6 required"> </div>
                </div>
                <!--End innerchatwrap-->

              </div>
              <div id="chat" class="tab-pane fade in active">
                <div class="col-sm-12 chatarea" id="chatareaindoc">
                  <?php
					  if($msgdetails){
					  while($obj = $msgdetails->FetchNextObject()){?>
                  <?php if($obj->CH_SENDER_CODE == $usrcode){ ?>
                  <div class="speech-bubble-rt">
                    <div class="speech-bubble-rt speech-bubble-right"> <?php echo $obj->CH_MSG ;?> </div>
                  </div>
                  <?php }else{ ?>
                  <div class="speech-bubble-lt">
                    <div class=" speech-bubble-lt speech-bubble-left"> <?php echo $obj->CH_MSG ;?> </div>
                  </div>
                  <?php } ?>
                  <?php } }?>
                  <input type="hidden" name="sendercode" id="sendercode" value="<?php echo $usrcode; ?>">
                  <input type="hidden" id="rcvchat" name="rcvchat">
                </div>
                <div class="col-sm-12 chattextarea">
                  <textarea name="chatmsg" id="chatmsg" cols="" placeholder="message..."></textarea>
                  <button type="button" id="submitchat"><i class="fa fa-send"></i></button>
                </div>
              </div>
              <div id="video" class="tab-pane fade in active">
                <div style="position:relative;float:left; top:-370px">
                  <video autoplay id="callerVideo" width="289" height="300"></video>
                </div>
              </div>
              <div id="phone" class="tab-pane fade in active"> </div>
            </div>
          </div>
          <?php } ?>
          
          
          <div class="tabish pull-right">

              <button type="button" class="btn btn-success btn-square" onclick="" data-toggle="modal" data-target="#physicalexams"> Physical Exams</button>

            <?php $vitallink = 'index.php?pg='.md5('Doctors').'&amp;option='.md5('Consultation').'&uiid='.md5('1_pop').'&viewpage=vitallist&view=vitallist&visitcode='.$new_visitcode.'&patientcode='.$patientcode; ?>
             <button type="button" class="btn btn-info btn-square" onclick="CallSmallerWindow('<?php echo $vitallink;?>')"> Vital Details</button>
            
             <button type="button" class="btn btn-info btn-square" onclick='' data-toggle="modal" data-target="#veiwallergies">Allergies / Chronic Cond.</button>
             
            <button type="button" class="btn btn-success btn-square" onclick='' data-toggle="modal" data-target="#addManagement"> Management</button>
            <?php $linkview = 'index.php?pg='.md5('Doctors').'&amp;option='.md5('Consultation').'&uiid='.md5('1_pop').'&viewpage=historylist&view=historylist&keys='.$patientnum; ?>
            <button type="button" class="btn btn-info btn-square" onclick="CallSmallerWindow('<?php echo $linkview;?>')"> Medical History</button>
            <!--<button type="button" class="btn btn-info btn-square" onclick=
"document.getElementById('viewpage').value='historylist';document.getElementById('view').value='historylist';document.myform.submit()"> Medical History</button>-->
          </div>
          <div class="col-sm-12 client-vitals-opt pull-right">
            <div class="col-sm-12 required">
              <div class="page-wrapper">
                <ul class="nav nav-tabs">
                  <li class="active"><a data-toggle="tab" href="#complains">Complains</a></li>
                  <li><a data-toggle="tab" href="#labs">Investigations</a></li>
                  <li><a data-toggle="tab" href="#diagnosis">Diagnosis</a></li>
                  <li><a data-toggle="tab" href="#presciption">Prescription</a></li>
                  <li><a data-toggle="tab" href="#actions">Action</a></li>
                </ul>
                <div class="page form">
                  <div class="tab-content">
                    <div id="complains" class="tab-pane fade in active">
                      <div class="form-group">
                        <div class="col-sm-12 required">
                          <input type="hidden" id="copmlaincode" name="copmlaincode">
                          <div class="form-group input-group">
                            <label class="control-label" for="copmlainner">Complains</label>
                            <input type="text" class="form-control" id="copmlainner" name="copmlainner">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-success" title="Add Storyline for this complain" id="addstory" style="margin: 24px 0 0 0;"><i class="fa fa-plus-circle"></i></button>
                                <button type="button" class="btn btn-primary" id="addcomplain" style="margin: 22px 0 0 0;">Add</button>
                            </span>
                          </div>
                            <div class="storydiv">
                                <label class="control-label" for="copmlainner">Storyline</label>
                                <textarea class="form-control" id="storyline" name="storyline"></textarea>
                            </div>
                          <table class="table table-responsive table-bordered" id="tblcomplain">
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
                                    <td><?php echo $encaes->decrypt($objcom->PC_COMPLAIN); ?></td>
                                    <td><?php echo $engine->add3dots($encaes->decrypt($objcom->PC_STORYLINE),'...',20); ?></td>
                                    <td><button type='button' id='deletecomplain' onclick='deleteComplains("<?php echo $objcom->PC_CODE; ?>","Complains");' class="btn-danger removecomplain">&times;</button></td>
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
                            <select name="actiontype" id="actiontype" class="form-control select2" tabindex="2">
                              <option value="" disabled selected>--- Select Action ---</option>
                              <?php
                              $cltactiondetail = $engine->getConsultActions();
							 
                              while($objdetail = $cltactiondetail->FetchNextObject()){
                                  if ($objdetail->SERV_CODE !== 'SER0001'){
                                      ?>
                                      <option value="<?php echo $objdetail->SERV_CODE.'_'.$objdetail->SERV_CONSULTATIONSTATUS ;?>"><?php echo $objdetail->SERV_NAME ;?></option>
                              <?php
                                  }
                              } ?>
                            </select>



                          </div>
                        </div>

                    <div class="col-sm-12">
                        &nbsp;
                   </div>

               <span id="showadmitnote">
               <div class="col-sm-12">
               <label class="control-label" for="copmlainner">Admitting Note</label>
                  <textarea name="admittingnote" id="admittingnote" cols="" placeholder="Admitting note..."></textarea>
              </div>
               </span>
                      </div>
                    </div>
                    <div id="labs" class="tab-pane fade">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#labrequest">Lab. Request</a></li>
                            <li><a data-toggle="tab" href="#xray">X-ray</a></li>
                        </ul>
                        <div class="page form">
                            <div class="tab-content">
                                <div id="labrequest" class="tab-pane fade in active">
                                    <div class="controls controls-row" >
                                        <div class="control-group span4">
                                            <label class="control-label">Test:</label>
                                            <div class="controls" style="margin-bottom:10px;">
                                                <select name="test" id="test" class="form-control select2" tabindex="2">
                                                    <option value="<?php echo $test; ?>"> -- Select Test --</option>
                                                    <?php while($objdpt = $stmttestlov->FetchNextObject()){  ?>
                                                        <option value="<?php echo $objdpt->LTT_CODE.'@@@'.$objdpt->LTT_NAME.'@@@'.$objdpt->LTT_DISCIPLINE.'@@@'.$objdpt->LTT_DISCIPLINENAME;?>" <?php echo (($objdpt->LTT_CODE == $test)?'selected':'' )?> ><?php echo $objdpt->LTT_NAME ;?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="control-group span4">
                                                <label class="control-label">Clinical Remark:</label>
                                                <div class="controls">
                                                    <textarea name='crmk' id="crmk"></textarea>
                                                    <div class="move-low">
                                                        <button type="button" class="btn btn-primary" id="addlabs">Add</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table table-responsive table-bordered" id="tbllabs">
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
                                                <td><?php echo $encaes->decrypt($objlabs->LT_TESTNAME); ?></td>
                                                <td><?php echo $encaes->decrypt($objlabs->LT_RMK); ?></td>
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
                                <div id="xray" class="tab-pane fade">
                                    <div class="controls controls-row" style="margin-bottom:10px;">
                                        <div class="control-group span6">
                                            <label class="control-label">X-ray:</label>
                                            <div class="controls">
                                                <select name="xrayopt" id="xrayopt" class="form-control select2" tabindex="2">
<!--                                                    <option value="all" selected disabled>-- Select X-ray --</option>-->
                                                    <?php while($objxray = $stmtxray->FetchNextObject()){  ?>
                                                        <option value="<?php echo $objxray->X_CODE.'@@@'.$objxray->X_NAME ; ?>" <?php echo (($objdpt->X_CODE == $xrayopt)?'selected':'' )?> ><?php echo $objxray->X_NAME ;?></option>
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
                                                <button type="button" class="btn btn-primary" id="addxray">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table table-responsive table-bordered" id="tblxray">
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
                                        while ($objxray = $stmtx->FetchNextObject()){
                                            ?>
                                            <tr>
                                                <td><?php echo $n++; ?></td>
                                                <td><?php echo $encaes->decrypt($objxray->XT_TESTNAME); ?></td>
                                                <td><?php echo $encaes->decrypt($objxray->XT_RMK); ?></td>
                                                <td>
                                                    <button type='button' id='deletecomplain' onclick='deleteComplains("<?php echo $objxray->XT_CODE; ?>","Xray");' class="btn-danger removecomplain">&times;</button>
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
                          <label class="control-label">Diagnosis:</label>
                          <div class="controls">
                            <select name="dia" id="dia" class="form-control select2" tabindex="2">
                              <option value="<?php echo $dia; ?>"> -- Select Test --</option>
                              <?php while($objdpt = $stmtdiagnosislov->FetchNextObject()){  ?>
                              <option value="<?php echo $objdpt->DIS_CODE.'@@@'.$objdpt->DIS_NAME ; ?>" <?php echo (($objdpt->DIS_CODE == $dia)?'selected':'' )?> ><?php echo $objdpt->DIS_NAME ;?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="control-group span4">
                        <label class="control-label"> Remark:</label>
                        <div class="controls">
                          <textarea name='drmk' id="drmk"></textarea>
                          <div class="move-low">
                            <button type="button" class="btn btn-primary" id="adddiagnosis">Add</button>
                          </div>
                        </div>
                      </div>
                      <table class="table table-responsive table-bordered" id="tbldiagnosis">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Diagnosis</th>
                            <th>Remark</th>
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
                                <td><?php echo $encaes->decrypt($objdiag->DIA_DIAGNOSIS); ?></td>
                                <td><?php echo $encaes->decrypt($objdiag->DIA_RMK); ?></td>
                                <td>
                                    <button type='button' id='deletecomplain' onclick='deleteComplains("<?php echo $objdiag->DIA_CODE; ?>","Diagnosis");' class="btn-danger removecomplain">&times;</button>
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
                            <select name="drug" id="drug" class="form-control select2" tabindex="2">
                              <option value="<?php echo $drug; ?>"> -- Select Drugs --</option>
                              <?php while($objdpt = $stmtdrugslov->FetchNextObject()){  ?>
                              <option value="<?php echo $objdpt->DR_CODE.'@@@'.$objdpt->DR_NAME.'@@@'.$objdpt->DR_DOSAGE.'@@@'.$objdpt->DR_DOSAGENAME ;?>" <?php echo (($objdpt->DR_CODE == $drug)?'selected':'' )?> ><?php echo $objdpt->DR_NAME ;?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                      </div>
                        <div class="col-sm-2" style="width: 18%">
                            <label>Dosage</label>
                            <input type="numbers" class="form-control" id="frequency" name="frequency" placeholder="Dosage">
                        </div>
                        <div class="col-sm-2" style="width: 18%">
                            <label>Times</label>
                            <input type="numbers" class="form-control" id="times" name="times" placeholder="Times">
                        </div>
                        <div class="col-sm-2" style="width: 18%; padding-left:0px !important;">
                            <label>Days</label>
                            <input type="numbers" class="form-control" id="days" name="days" placeholder="Days">
                        </div>
                      <div class="col-sm-3" style="width: 26%">
                        <label>Route</label>
                        <select name="route" id="route" class="form-control">
                            <option value="0" selected disabled>Select Route</option>
                            <?php while ($fetchroute = $stmtroute->FetchNextObject()){?>
                                <option value="<?php echo $fetchroute->RT_CODE.'@@@'.$fetchroute->RT_NAME?>"><?php echo $fetchroute->RT_NAME?></option>
                            <?php } ?>
                        </select>
<!--                        <input type="text" class="form-control" id="route" name="route" placeholder="Route">-->
                      </div>
                      <div class="col-sm-2 pull-right">
                        <label id="lbl">&nbsp;</label>
                        <button type="button" class="form-control btn btn-primary" id="addprescription">Add</button>
                      </div>
                      <table class="table table-responsive table-bordered" id="tblprescription">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Prescription</th>
                            <th>Dosage</th>
                            <th>Times</th>
                            <th>Days</th>
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
                                <td><?php echo $objpres->PRESC_DAYS; ?></td>
                                <td><?php echo $objpres->PRESC_FREQ; ?></td>
                                <td><?php echo $objpres->PRESC_TIMES; ?></td>
                                <td><?php echo $objpres->PRESC_ROUTENAME; ?></td>
                                <td>
                                    <button type='button' id='deletecomplain' onclick='deleteComplains("<?php echo $objpres->PRESC_CODE; ?>","Prescription");' class="btn-danger removecomplain">&times;</button>
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
                  <?php include ("audio-recording.php");?>
                <!--					<button type="submit" onclick="document.getElementById('viewpage').value='savecomplain';document.myform.submit();" class="btn btn-info"><i class="fa fa-plus-circle"></i> Submit</button>--> 
              </div>
            </div>
          </div>
          <div class="col-sm-12 moduletitleupper" style="font-size:17px; font-weight:500;"><span class="pull-right">
            <button type="button" id="save" onclick="document.getElementById('viewpage').value='saveconsultation';document.myform.submit();" class="btn btn-info"><i class="fa fa-plus-circle"></i> Submit</button>
            </span> </div>
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
        $stmtm = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_management WHERE PM_PATIENTNUM = ".$sql->Param('1')." AND PM_VISITCODE = ".$sql->Param('2')." AND PM_STATUS = ".$sql->Param('3').""),array($patientnum,$new_visitcode,'1'));
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

<!-- Physical Exams Modal -->
<div id="physicalexams" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Physical Exams</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group" style="margin-bottom: 60px;">
                        <div class="col-sm-12">
                            <select class="form-control select2" name="physicalexamstype" id="physicalexamstype">
                                <option value="" selected disabled>-- Select Physical Exams Type --</option>
                                <?php
                                while ($phyexam = $stmtphysicalexams->FetchNextObject()){
                                    ?>
                                    <option value="<?php echo $phyexam->PHYEX_CODE.'@@@'.$phyexam->PHYEX_TYPE?>" <?php echo (($phyexam->PHYEX_CODE == $physicalexamstype)?'selected':'')?>><?php echo $phyexam->PHYEX_TYPE?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <textarea class="form-control" rows="6" cols="65" id="physicalexamsdetails" name="physicalexamsdetails"></textarea>
                        </div>
                    </div>
                    <div class="container-fluid" style=" float: right;margin-top: 10px">
                        <button type="button" id="addphyexams" class="btn btn-success btn-square">Save</button>
                        <button type="button" class="btn btn-info btn-square" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <div class="">
                    <p>

                    <table class="table table-responsive table-bordered" id="tblmanagement">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Physical Exams Type</th>
                            <th>Management</th>
                            <th style="width: 0">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $stmtppex = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_physicalexams WHERE PPEX_PATIENTNUM = ".$sql->Param('1')." AND PPEX_VISITCODE = ".$sql->Param('2')." AND PPEX_STATUS = ".$sql->Param('3').""),array($patientnum,$new_visitcode,'1'));
                        $num = 1;
                        if ($stmtppex->RecordCount()>0){
                            while ($obj = $stmtppex->FetchNextObject()){
                                echo '<tr>
				<td>'.$num++.'</td>
				<td>'.$encaes->decrypt($obj->PPEX_PHYSICALEXAMSTYPE).'</td>
				<td>'.$encaes->decrypt($obj->PPEX_PHYSICALEXAMSDETAILS).'</td>
				<td class="text-center valign-middle" width="100">
                <button class="btn btn-xs btn-danger square" type="button" onclick="deletePhysicalExams(\''.$obj->PPEX_ID.'\')"><i class="fa fa-close"></i>
				</button>
                </td>
				<tr>';
                            }}
                        else{
                            echo '<tr>
					<td colspan="4">No record found.</td>
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
<textarea rows="3" cols="61" id="txtarea" name="txtarea" class="txtarea" style="border:1px solid #cfcfcf">

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
        <button class="btn btn-xs btn-danger square" type="button" onclick="if(confirm(\'You are about to delete the allergies.\n\n Note: This process cannot be reversed.\n \n Are you sure ?.\')){deleteAllergies()}else{ return false;}"><i class="fa fa-close"></i>
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
<script type="text/javascript">
        function my_init() {
            easyrtc.setRoomOccupantListener(loggedInListener);
            easyrtc.easyApp("Company_Chat_Line", "self", ["caller"],
                function (myId) {
                    console.log("My easyrtcid is " + myId);
                }
            );
        }


        function loggedInListener(roomName, otherPeers) {
            var otherClientDiv = document.getElementById('otherClients');
            while (otherClientDiv.hasChildNodes()) {
                otherClientDiv.removeChild(otherClientDiv.lastChild);
            }
            for (var i in otherPeers) {
                var button = document.createElement('button');
                button.onclick = function (easyrtcid) {
                    return function () {
                        performCall(easyrtcid);
                    }
                }(i);

                label = document.createTextNode(i);
                button.appendChild(label);
                otherClientDiv.appendChild(button);
            }
        }


        function performCall(easyrtcid) {
            easyrtc.call(
                easyrtcid,
                function (easyrtcid) {
                    console.log("completed call to " + easyrtcid);
                },
                function (errorMessage) {
                    console.log("err:" + errorMessage);
                },
                function (accepted, bywho) {
                    console.log((accepted ? "accepted" : "rejected") + " by " + bywho);
                }
            );
        }



        var selfEasyrtcid = "";


        function connect() {
            easyrtc.setSocketUrl("192.168.15.8:8080");
            easyrtc.setVideoDims(640, 480);
            easyrtc.setRoomOccupantListener(convertListToButtons);
            easyrtc.easyApp("easyrtc.audioVideoSimple", "selfVideo", ["callerVideo"], loginSuccess, loginFailure);
        }


        function clearConnectList() {
            var otherClientDiv = document.getElementById("otherClients");
            while (otherClientDiv.hasChildNodes()) {
                otherClientDiv.removeChild(otherClientDiv.lastChild);
            }
        }


        function convertListToButtons(roomName, data, isPrimary) {
            clearConnectList();
            var otherClientDiv = document.getElementById("otherClients");
            for (var easyrtcid in data) {
                var button = document.createElement("button");
                button.onclick = function (easyrtcid) {
                    return function () {
                        performCall(easyrtcid);
                    };
                }(easyrtcid);

                var label = document.createTextNode(easyrtc.idToName(easyrtcid));
                button.appendChild(label);
                otherClientDiv.appendChild(button);
            }
        }




        function loginSuccess(easyrtcid) {
            selfEasyrtcid = easyrtcid;
            document.getElementById("iam").innerHTML = "I am " + easyrtc.cleanId(easyrtcid);
        }


        function loginFailure(errorCode, message) {
            easyrtc.showError(errorCode, message);
        }
    </script>