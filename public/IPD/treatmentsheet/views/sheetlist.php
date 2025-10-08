<script type="text/javascript" src="media/js/jquery-ui.min.js"></script>
<!--<form name="myform" id="myform" method="post" action="#">
    <input sview" nasview" value="" type="hidden" />
    <input id="viewpage" name="viewpage" value="" type="hidden" />
    <input id="keys" name="keys" value="" type="hidden" />
    <input id="micro_time" name="micro_time" value="<?php //echo md5(microtime()); ?>" type="hidden" />
-->
 
    <input id="consultcode" name="consultcode" value="<?php echo $consultcode; ?>" type="hidden" />
    <input id="patientno" name="patientno" value="<?php echo $patientno[0]; ?>" type="hidden" />
    <input id="patientdate" name="patientdate" value="<?php echo $patientdate; ?>" type="hidden" />
    <input id="visitcode" name="visitcode" value="<?php echo $patientno[1]; ?>" type="hidden" />
    <input id="activeinstitution" name="activeinstitution" value="<?php echo $activeinstitution; ?>" type="hidden" />
    <input type="hidden" class="form-control" id="patientcode" name="patientcode" value="<?php  $dataobj=$patientCls->getPatientDetails($patientno[0]);echo $dataobj->PATIENT_PATIENTCODE; ?>" readonly>
    
      <input type="hidden" class="form-control" id="patient" name="patient" value="<?php  $dataobj=$patientCls->getPatientDetails($patientno[0]);echo $dataobj->PATIENT_FNAME." ".$dataobj->PATIENT_MNAME." ".$dataobj->PATIENT_LNAME; ?>" readonly>
 <input id="wardid" name="wardid" value="<?php echo $patientno[2]; ?>" type="hidden" />
 <input id="wardname" name="wardname" value="<?php echo $patientno[3]; ?>" type="hidden" />
 <input id="bedid" name="bedid" value="<?php echo  $patientno[4]; ?>" type="hidden" />
  <input id="bedname" name="bedname" value="<?php echo $patientno[5]; ?>" type="hidden" />
<div class="main-content">
  <div class="page-wrapper">
    <div class="page form">
      <div class="moduletitle" style="padding-bottom:0 !important">
        <div class="moduletitleupper" style="font-size:17px; font-weight:500;">Patient Treatment for <?php  $dataobj=$patientCls->getPatientDetails($patientno[0]);echo $dataobj->PATIENT_FNAME." ".$dataobj->PATIENT_MNAME." ".$dataobj->PATIENT_LNAME; ?> [ <?php echo  $patientno[0] ;?>]<span class="pull-right">
          <!--<button type="button" id="save" onclick="document.getElementById('viewpage').value='saveconsultation';document.myform.submit();" class="btn btn-info"><i class="fa fa-plus-circle"></i> Submit</button>-->
          <button type="button"  class="btn btn-dark" onclick="document.getElementById('viewpage').value='';document.getElementById('view').value='';document.myform.submit();"><i class="fa fa-arrow-left"></i> Back </button>
          </span> </div>
      </div>
      <p id="msg" class="alert alert-danger" hidden></p>
      
      <?php 
	  $stmtem = $sql->Execute($sql->Prepare("SELECT * FROM hms_firstaid WHERE FIR_STATUS = '1' AND FIR_VISITCODE=".$sql->Param('a')." "),array($visitcode));
	  
            print $sql->ErrorMsg();
            if ($stmtem->RecordCount() > 0){
				$msg = 'First Aid';
				$status = 'error';
	  $engine->msgBox($msg,$status); 
	  }
	  ?>
      <div class="col-sm-2">
        <div class="id-photo"> <img src="<?php echo(!empty($photourl))?$photourl:'media/img/avatar.png';?>" alt="" id="prevphoto" style="width:100% !important; margin:0px !important;"> </div>
        <div class="form-group">
          <div class="col-sm-12 client-info">
            <!--<input type="hidden" class="form-control" id="patientno" name="patientno" value="<?php //echo $patientnum; ?>">
            <input type="hidden" class="form-control" id="visitcode" name="visitcode" value="<?php //echo $visitcode; ?>">
            <input type="hidden" class="form-control" id="patient" name="patient" value="<?php //echo $patient; ?>">-->
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
            <!--<button type="button" class="btn btn-success btn-square" onclick="document.getElementById('viewpage').value='management';document.getElementBysview').value='management';document.myform.submit();"> Management</button>-->

            
           <!-- <?php //$vitallink = 'index.php?pg='.md5('Doctors').'&amp;option='.md5('Consultation').'&uiid='.md5('1_pop').'&viewpage=vitallist&s=vitallist&visitcode='.$visitcode.'&patientcode='.$patientcode; ?>
             <button type="button" class="btn btn-info btn-square" onclick="CallSmallerWindow('<?php //echo $vitallink;?>')"> Vital Details</button>

            <button type="button" class="btn btn-success btn-square" onclick='' data-toggle="modal" data-target="#addManagement"> Management</button>
            <?php //$linkview = 'index.php?pg='.md5('Doctors').'&amp;option='.md5('Consultation').'&uiid='.md5('1_pop').'&viewpage=historylist&s=historylist&keys='.$patientnum; ?>
            <button type="button" class="btn btn-info btn-square" onclick="CallSmallerWindow('<?php //echo $linkview;?>')"> Medical History</button>-->
            <!--<button type="button" class="btn btn-info btn-square" onclick=
"document.getElementById('viewpage').value='historylist';document.getElementBysview').value='historylist';document.myform.submit()"> Medical History</button>-->
          </div>
           <?php //$linkview = 'index.php?pg='.md5('IPD').'&amp;option='.md5('Ward Rounds').'&uiid='.md5('1_pop').'&s=history&viewpage=history&keys='.$patientno[0].'&visitcode='.$patientno[1]; ?>
           
          <div class="col-sm-12 client-vitals-opt pull-right">
            <div class="col-sm-12 required">
              <div class="page-wrapper">
                <ul class="nav nav-tabs">   
                   <li><a data-toggle="tab" href="#nursenote">Nurse Notes</a></li>
                  <li><a data-toggle="tab" href="#treatment">Treatment</a></li>
                  <li><a data-toggle="tab" href="#dailyfluidplan"> Daily Fluid Plan</a></li>
                  <li><a data-toggle="tab" href="#dailyfluidintake"> Daily Fluid Intake</a></li>
                  <li><a data-toggle="tab" href="#dailyfluidoutput"> Daily Fluid Output</a></li>
                  <li><a data-toggle="tab" href="#consumable">Consumable</a></li>
                  
                </ul>
                <div class="page form">
                  <div class="tab-content">
                    <div id="nursenote" class="tab-pane fade in active">
                      <div class="controls controls-row" >
                        <div class="form-group">
                <div id="message"></div>
                    <div class="">
                     <div class="form-group">
                    <div class="col-sm-12 client-vitals-opt">
                    <div class="col-sm-4 required">
                        <label class="control-label" for="fname">Date</label>
                         <input type="text" class="form-control" id="notedate" name="startdate">
                    </div>
                    <div class="col-sm-4 required">
                        <label for="time">Time</label>
                        <input type="text" class="form-control" id="time" name="time">
                    </div>
                    <div class="col-sm-8 required">
                        <label for="nurse">Nurse Note</label>
            <textarea name="nursnote" id="nursnote" cols="" placeholder=""></textarea>

                    </div>
                    <div class="btn-group">
                        <div class="col-sm-4 " style="padding-top:30px;">
                            
                            <button type="button" id="addnote" class="btn btn-info "><i class="fa fa-plus-circle"></i> Submit</button>
                        </div>
                    </div>
                    </div>
                </div>
                    
                    </div>
                    
                </div>
                      </div>
                      <div class="form-group">
                    <div class="col-sm-12 client-vitals">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th width="50">Note</th>
                                </tr>
                            </thead>
                            <tbody id="nursenotedata">
                            
                            </tbody>
                        </table>    
                    </div>
                </div>
                <!--<div class="btn-group pull-right">
                <div class="col-sm-12" style="padding-bottom:10px;">
                    <button type="button" class="btn btn-success" onclick="saveVitals();">Submit</button>
                </div>
            </div>-->
                      <table class="table table-responsive table-bordered" id="tbllabs">
                        <thead>
                          <tr>
                              <th>Date</th>
                              <th>Time</th>
                             <th>Note</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                        $n = 1;
						if($stmtnote->RecordCount()>0){
                        while ($objn = $stmtnote->FetchNextObject()){
                            ?>
                            <tr>
                               <td><?php echo $objn->MED_DATE;?></td>
                                <td><?php echo $objn->MED_TIME;?></td>
                                <td><?php echo $objn->MED_NOTE;?></td>
                            </tr>
                            <?php
                        }
					}else{
                        ?>
                        <tr><td colspan="3">
                         No Nurse Note
                        </td></tr>
                        <?php } ?>
                        </tbody>
                      </table>
                    </div>
                    <div id="treatment" class="tab-pane fade">
                      <div class="controls controls-row" >
                        <div class="form-group">
                <div id="message"></div>
                    <div class="col-sm-12 client-vitals-opt">
                    <div class="col-sm-4 required">
                        <label for="treatment">Date</label>
                        <input type="text" class="form-control" id="trsdate"  name="startdate" >
                         <label class="control-label" for="fname">Time</label>
                       <input type="text" class="form-control" id="trtime"  name="trtime" >

                    </div>
                    
                    <div class="col-sm-4 required">
                        <label for="drug">Prescription</label>
                        <select name="drugs" id="drugs" class="form-control select2" tabindex="2">
                              <option value="<?php echo $drug; ?>"> -- Select Drugs --</option>
                              <?php while($objdpt = $stmtdrugslov->FetchNextObject()){  ?>
                              <option value="<?php echo $objdpt->DR_CODE.'@@'.$objdpt->DR_NAME.'@@'.$objdpt->DR_DOSAGE.'@@'.$objdpt->DR_DOSAGENAME ;?>" <?php echo (($objdpt->DR_CODE == $drug)?'selected':'' )?> ><?php echo $objdpt->DR_NAME ;?></option>
                              <?php } ?>
                            </select>
                    </div>
                    <div class="col-sm-4 required">
                        <label for="othername">Quantity</label>
                        <input type="text" class="form-control" id="quantity"  name="quantity" >
                    </div>
                    
                    <div class="col-sm-4" style="padding-top:25px;">
                           
                            <button  type="button" id="savetreatment" class="btn btn-info"><i class="fa fa-plus-circle"></i> Submit</button>
                        </div>
                    </div>
                    
                </div>
                      </div>
                      <div class="form-group">
                    <div class="col-sm-12 client-vitals">
                      
                        
                        <table class="table table-hover">
                            <thead>
                                <tr><td><b>Date</b> </td><td width="20%"><b>Time</b> </td><td width="20%"><b>Prescription</b> </td><td width="20%"><b>Quantity</b> </td><td width="20%"><b>Action</b> </td></tr>
                            </thead>
                            <tbody id="treatsheet">
                            </tbody>
                        </table>    
                    </div>
                </div>
                      <table class="table table-responsive table-bordered">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Prescription</th>
                            <th>Quantity</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                        $n = 1;
						if($stmttr->RecordCount()>0){
                        while ($objtr = $stmttr->FetchNextObject()){
                            ?>
                            <tr>
                                <td><?php echo $n++; ?></td>
                                 <td><?php echo $objtr->TR_DT; ?></td>
                                <td><?php echo  $objtr->TR_TIME; ?></td>
                                 <td><?php echo $encaes->decrypt($objtr->TR_DRUG); ?></td>
                                  <td><?php echo $objtr->TR_QTY; ?></td>
                               
                            </tr>
                            <?php
                        }
					}else{
                        ?>
                        <tr><td colspan="5">
                         No Patient Treatment Sheet
                        </td></tr>
                        <?php } ?>
                        </tbody>
                      </table>
                    </div>
                    <div id="dailyfluidplan" class="tab-pane fade">
                      <div class="controls controls-row" >
                        <div class="form-group">
                <div id="message"></div>
                    <div class="col-sm-12 client-vitals-opt">
                    <div class="col-sm-4 required">
                        <label for="treatment">Date</label>
                        <input type="text" class="form-control" id="fdate"  name="startdate" >
                    </div>
                    <div class="col-sm-4 required">
                        <label class="control-label" for="fname">Time</label>
                       <input type="text" class="form-control" id="ftime"  name="ftime" >

                    </div>
                    <div class="col-sm-4 required">
                        <label class="control-label" for="fdname">Name</label>
                       <input type="text" class="form-control" id="fdname"  name="fdname" >

                    </div>
                    <div class="col-sm-4 required">
                        <label for="othername">Type Of Fluid</label>
                        <input type="text" class="form-control"  name="fluidtype" id="fluidtype" >
                    </div>
                    <div class="col-sm-4 required">
                        <label for="othername">Route</label>
                        <input type="text" class="form-control" id="route"  name="route" >
                    </div>
                    <div class="col-sm-4 required">
                        <label for="othername">Amount</label>
                        <input type="text" class="form-control" id="famount"  name="famount" >
                    </div>
                    <div class="col-sm-4 required">
                        <label for="othername">Mis</label>
                        <input type="text" class="form-control" id="fmis"  name="fmis" >
                    </div>
                     <div class="col-sm-4 required">
                        <label for="othername">Method</label>
 <select name="flmethod" id="flmethod" class="form-control select2" tabindex="2">
                              <option value=""> -- Select Method -- </option>
                           <?php
                          while($objind = $stmtmethodlov->FetchNextObject()){
                          ?>
                          <option value="<?php echo $objind->DIS_CODE."@@@".$objind->DIS_NAME ;?>" <?php echo (($objind->DIS_CODE == $meth)?'selected':'' )?> ><?php echo $objind->DIS_NAME ;?></option>
                           <?php } ?>    
                            </select>                    </div>
                    <div class="btn-group">
                        
                    </div>
                    <div class="col-sm-4" style="padding-top:25px;">
                           
                            <button  type="button" id="dailyfluidp" class="btn btn-info"><i class="fa fa-plus-circle"></i> Submit</button>
                        </div>
                    </div>
                    
                </div>
                      </div>
                      <div class="form-group">
                    <div class="col-sm-12 client-vitals">
                      
                        
                        <table class="table table-hover">
                            <thead>
                                <tr><td><b>Date</b> </td><td width="20%"><b>Time</b> </td><td width="20%"><b>Name</b> </td><td width="20%"><b>Type Of Fluid</b> </td><td width="20%"><b>Route</b> </td><td width="20%"><b>Amount</b> </td><td width="20%"><b>Mis</b> </td><td width="20%"><b>Method</b> </td><td width="20%"><b>Action</b> </td></tr>
                            </thead>
                            <tbody id="fluiddata">
                            </tbody>
                        </table>    
                    </div>
                </div>
                      
                      <table class="table table-responsive table-bordered" id="tbllabs">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Name</th>
                            <th>Type of Fluid</th>
                            <th>Route</th>
                            <th>Amount</th>
                            <th>Mis</th>
                            <th>Method</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                        $n = 1;
						if($stmtdfp->RecordCount()>0){
                        while ($objfp = $stmtdfp->FetchNextObject()){
                            ?>
                            <tr>
                                <td><?php echo $n++; ?></td>
                                 <td><?php echo $objfp->DF_DATE; ?></td>
                                <td><?php echo $objfp->DF_TIME; ?></td>
                                 <td><?php echo $objfp->DF_NAME; ?></td>
                                  <td><?php echo $objfp->DF_FLUID_TYPE; ?></td>
                                  <td><?php echo $objfp->DF_ROUTE; ?></td>
                                   <td><?php echo $objfp->DF_FLUID_AMT; ?></td>
                                 <td><?php echo $objfp->DF_MIS; ?></td>
                                  <td><?php echo $objfp->DF_METHODNAME; ?></td>
                            </tr>
                            <?php
                        }
					}else{
                        ?>
                        <tr><td colspan="9">
                         No Daily Fluid
                        </td></tr>
                        <?php } ?>
                        </tbody>
                      </table>
                    </div>
                    <div id="dailyfluidintake" class="tab-pane fade">
                    <input type="hidden" class="form-control " value="<?php echo $msg; ?>" id="msg" name="msg">
                    <input type="hidden" class="form-control " value="<?php echo $status; ?>" id="status" name="status">
                    <div class="controls controls-row" >
                        <div class="form-group">
                <div id="messageid"></div>
                    <div class="col-sm-12 client-vitals-opt">
                    <div class="col-sm-4 required">
                        <label class="control-label">Plan</label>
                        <select name="fplan" id="fplan" class="form-control select2" tabindex="2">
                             <option value=""> -- Select Plan -- </option>
                              <?php
                              while($objind = $stmtplanlov->FetchNextObject()){
                              ?>
                              <option value="<?php echo $objind->DF_CODE.'@@@'.$objind->DF_NAME.'@@@'.$objind->DF_ID ;?>" <?php echo (($objind->DF_NAME == $plan)?'selected':'' )?> ><?php echo $objind->DF_NAME ;?></option>
                              <?php } ?>  
                            </select> 
                    </div>
                    <div class="col-sm-4 required">
                        <label class="control-label" for="fname">Date</label>
                            <input type="text" class="form-control datepicker" id="fddate" name="startdate">

                    </div>
                    <div class="col-sm-4 required">
                        <label class="control-label" for="fname">Time</label>
                       <input type="text" class="form-control" id="fdtime"  name="fdtime" >

                    </div>
                      
                    <div class="col-sm-4" style="padding-top:25px;">
                           
                            <button  type="button" id="savetinfluid" class="btn btn-info"><i class="fa fa-plus-circle"></i> Submit</button>
                        </div>
                    </div>
                    
                </div>
                      </div>
                       <!--<div class="form-group">
                    <div class="col-sm-12 client-vitals">
                         <table class="table table-responsive table-bordered" id="tblcomplain">
                            <thead>
                              <tr>
                                <th>Complain</th>
                                <th style="width: 0">Action</th>
                              </tr>
                            </thead>
                            <tbody id="fluidintakedata">
                              
                            </tbody>
                          </table>
                          </div>
                          </div>-->
                          
                          <table class="table table-responsive table-bordered" id="tbldiagnosis">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Plan</th>
                            <th>Time</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                        $n = 1;
						if($stmtpl->RecordCount()>0){
                        while ($objpl = $stmtpl->FetchNextObject()){
                            ?>
                            <tr>
                                <td><?php echo $n++; ?></td>
                                <td><?php echo $objpl->DT_DTINTAKE; ?></td>
                                <td><?php echo $objpl->DF_NAME; ?></td>
                                <td><?php echo $objpl->DF_TIMEINTAKE; ?></td>
                            </tr>
                            <?php
						}
                      }else{
                        ?>
                        <tr><td colspan="3">
                         No Daily fluid Intake
                        </td></tr>
                        <?php } ?>
                        </tbody>
                      </table>
                    </div>
                    <div id="dailyfluidoutput" class="tab-pane fade">
                    
                    <div class="controls controls-row" >
                        <div class="form-group">
                <div id="message"></div>
                    <div class="col-sm-12 client-vitals-opt">
                    <div class="col-sm-4 required">
                        <label class="control-label">Date</label>
                        <input type="text" class="form-control" id="outdate" name="startdate"> 
                    </div>
                    <div class="col-sm-4 required">
                        <label class="control-label" for="fname">Time</label>
                            <input type="text" class="form-control" id="outtime" name="outtime">

                    </div>
                    <div class="col-sm-4 required">
                        <label class="control-label" for="fname">Mis</label>
                       <input type="text" class="form-control" id="misout"  name="misout" >

                    </div>
                    <div class="col-sm-4 required">
                        <label class="control-label" for="fname">Output</label>
                      <select name="outputfluid" id="outputfluid" class="form-control select2" tabindex="2">
              <option value=""> -- Select Output -- </option>
               <?php
              while($objind = $stmtoutputlov->FetchNextObject()){
              ?>
              <option value="<?php echo $objind->DIS_CODE.'@@@'.$objind->DIS_NAME ;?>" <?php echo (($objind->DIS_CODE == $output)?'selected':'' )?> ><?php echo $objind->DIS_NAME ;?></option>
               <?php } ?>    
                   </select> 

                    </div>
                      
                    <div class="col-sm-4" style="padding-top:25px;">
                           
                            <button  type="button" id="savefluidoutput" class="btn btn-info"><i class="fa fa-plus-circle"></i> Submit</button>
                        </div>
                    </div>
                    
                </div>
                      </div>
                         <table class="table table-responsive table-bordered" id="tblcomplain">
                            <thead>
                              <tr>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Mis</th>
                                <th>Output</th>
                                <th style="width: 0">Action</th>
                              </tr>
                            </thead>
                            <tbody id="fluidoutput">
                              <!--                        <tr><td colspan="3">No Complains </td></tr>-->
                            </tbody>
                          </table>
                          <table class="table table-responsive table-bordered" id="tbldiagnosis">
                        <thead>
                          <tr>
                            <th>#</th>
                             <th>Date</th>
                             <th>Time</th>
                             <th>Mis</th>
                             <th>Output</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                        $n = 1;
						if($stmtout->RecordCount()>0){
                        while ($objout = $stmtout->FetchNextObject()){
                            ?>
                            <tr>
                                <td><?php echo $n++; ?></td>
                                <td><?php echo $objout->DFO_DATE; ?></td>
                               <td><?php echo $objout->DFO_TIME;?></td>
                               <td><?php echo $objout->DFO_MIS;?></td>
                               <td><?php echo $objout->DFO_OUTPUTNAME;?></td>
                                
                            </tr>
                            <?php
						}
                      }else{
                        ?>
                        <tr><td colspan="5">
                         No Daily fluid output
                        </td></tr>
                        <?php } ?>
                        </tbody>
                      </table>
                    </div>
                    <div id="consumable" class="tab-pane fade">
                      
                    <div class="controls controls-row" >
                        <div class="form-group">
                <div id="message"></div>
                    <div class="col-sm-12 client-vitals-opt">
                    <div class="col-sm-4 required">
                        <label class="control-label">Date</label>
                       <input type="text" class="form-control" id="csdate" name="startdate">

                    </div>
                    <div class="col-sm-4 required">
                        <label class="control-label" for="fname">Consumable</label>
                            <select name="csconsume" id="csconsume" class="form-control select2" tabindex="2">
                                                        
                          <option value=""> -- Select Consumable -- </option>
                           <?php
                          while($objind = $stmtconson->FetchNextObject()){
                          ?>
                          <option value="<?php echo $objind->CS_CODE.'@@@'.$objind->CS_NAME ;?>" <?php echo (($objind->CS_CODE == $cons)?'selected':'' )?> ><?php echo $objind->CS_NAME ;?></option>
                           <?php } ?>   
                           </select> 

                    </div>
                    <div class="col-sm-4 required">
                        <label class="control-label" for="fname">Quantity</label>
                       <input type="text" class="form-control" id="csqty"  name="csqty" >

                    </div>
                      
                    <div class="col-sm-4" style="padding-top:25px;">
                           
                            <button  type="button" id="saveconsumable" class="btn btn-info"><i class="fa fa-plus-circle"></i> Submit</button>
                        </div>
                    </div>
                    
                </div>
                      </div>
                      
                      <div class="form-group">
                    <div class="col-sm-12 client-vitals">
                     <table class="table table-hover">
                            <thead>
                          <tr>
                            <th>Date</th>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th width="100">Action</th>
                          </tr>
                        </thead>
                            <tbody id="consumabledata">
                            </tbody>
                        </table> 
                        
                        <!--<table class="table table-hover">
                            <thead>
                                <tr><td><b>Test Name</b> </td><td width="20%"><b>Specimem</b> </td><td width="20%"><b>Label</b> </td><td width="20%"><b>Volume</b> </td><td width="20%"><b>Action</b> </td></tr>
                            </thead>
                            <tbody id="labdata">
                            </tbody>
                        </table>-->    
                    </div>
                </div>
                      <table class="table table-responsive table-bordered" id="tblprescription">
                        <thead>
                          <tr>
                            <th>#</th>
                              <th>Date</th>
                            <th>Item</th>
                            <th>Quantity</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                        $n = 1;
						if($stmtcs->RecordCount()>0){
                       while ($objcs = $stmtcs->FetchNextObject()){
                            ?>
                            <tr>
                                <td><?php echo $n++; ?></td>
                                <td><?php echo $objcs->CSU_DATE; ?></td>
                                <td><?php echo $objcs->CSU_ITEMNAME; ?></td>
                                <td><?php echo $objcs->CSU_QTY; ?></td>
                            </tr>
                            <?php
                        }
                        }else{
                        ?>
                        <tr><td colspan="7">
                         No Patient Consumable
                        </td></tr>
                        <?php } ?>
                        </tbody>
                      </table>
                    </div>
                    </div>
                  </div>
                </div>
                
                <!--					<button type="submit" onclick="document.getElementById('viewpage').value='savecomplain';document.myform.submit();" class="btn btn-info"><i class="fa fa-plus-circle"></i> Submit</button>--> 
              </div>
            </div>
          </div>
          <div class="col-sm-12 moduletitleupper" style="font-size:17px; font-weight:500;"><span class="pull-right">
            <!--<button type="button" id="save" onclick="document.getElementById('viewpage').value='saveconsultation';document.myform.submit();" class="btn btn-info"><i class="fa fa-plus-circle"></i> Submit</button>-->
            </span> </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->

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