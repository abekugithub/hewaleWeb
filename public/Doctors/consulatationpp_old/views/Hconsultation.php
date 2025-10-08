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



           