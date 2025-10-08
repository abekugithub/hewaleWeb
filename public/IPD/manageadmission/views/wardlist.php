<script type="text/javascript" src="media/js/jquery-ui.min.js"></script>
<!--<form name="myform" id="myform" method="post" action="#">
    <input id="view" name="view" value="" type="hidden" />
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

<div class="main-content">
  <div class="page-wrapper">
    <div class="page form">
      <div class="moduletitle" style="padding-bottom:0 !important">
        <div class="moduletitleupper" style="font-size:17px; font-weight:500;">Patient on Admission <?php  $dataobj=$patientCls->getPatientDetails($patientno[0]);echo $dataobj->PATIENT_FNAME." ".$dataobj->PATIENT_MNAME." ".$dataobj->PATIENT_LNAME; ?> [ <?php echo  $patientno[0] ;?>]<span class="pull-right">
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
            <!--<button type="button" class="btn btn-success btn-square" onclick="document.getElementById('viewpage').value='management';document.getElementById('view').value='management';document.myform.submit();"> Management</button>-->

            
           <!-- <?php //$vitallink = 'index.php?pg='.md5('Doctors').'&amp;option='.md5('Consultation').'&uiid='.md5('1_pop').'&viewpage=vitallist&view=vitallist&visitcode='.$visitcode.'&patientcode='.$patientcode; ?>
             <button type="button" class="btn btn-info btn-square" onclick="CallSmallerWindow('<?php //echo $vitallink;?>')"> Vital Details</button>

            <button type="button" class="btn btn-success btn-square" onclick='' data-toggle="modal" data-target="#addManagement"> Management</button>
            <?php //$linkview = 'index.php?pg='.md5('Doctors').'&amp;option='.md5('Consultation').'&uiid='.md5('1_pop').'&viewpage=historylist&view=historylist&keys='.$patientnum; ?>
            <button type="button" class="btn btn-info btn-square" onclick="CallSmallerWindow('<?php //echo $linkview;?>')"> Medical History</button>-->
            <!--<button type="button" class="btn btn-info btn-square" onclick=
"document.getElementById('viewpage').value='historylist';document.getElementById('view').value='historylist';document.myform.submit()"> Medical History</button>--> 
          </div>
           <?php //$linkview = 'index.php?pg='.md5('IPD').'&amp;option='.md5('Ward Rounds').'&uiid='.md5('1_pop').'&view=history&viewpage=history&keys='.$patientno[0].'&visitcode='.$patientno[1]; ?>
           
          <div class="col-sm-12 client-vitals-opt pull-right">
            <div class="col-sm-12 required">
              <div class="page-wrapper">
                <ul class="nav nav-tabs">
                  <li class="active"><a data-toggle="tab" href="#patientdetails">Patient Details</a></li>
                   <li><a data-toggle="tab" href="#vitals">Vitals</a></li>
                  <li><a data-toggle="tab" href="#labs">Lab.</a></li>
                  <li><a data-toggle="tab" href="#diagnosis"> Diagnosis</a></li>
                  <li><a data-toggle="tab" href="#complains">Complains</a></li>
                  <li><a data-toggle="tab" href="#presciption">Prescription</a></li>
                  <li><a data-toggle="tab" href="#management">Management</a></li>
                  <li><a data-toggle="tab"  href="#history">History</a></li>
                  <li><a data-toggle="tab" href="#actions">Action</a></li>
                </ul>
                <div class="page form">
                  <div class="tab-content">
                    <div id="patientdetails" class="tab-pane fade in active">
                      <div class="page-wrapper">
        <div class="page form">
           
           <div class="form-group">
           
           <div class="col-sm-3 required">
                    <label class="control-label" for="fname">Patient Name</label>
                    <?php echo $dataobj->PATIENT_FNAME." ".$dataobj->PATIENT_MNAME." ".$dataobj->PATIENT_LNAME; ?>
                </div>
                <div class="col-sm-3 required">
                    <label class="control-label" for="fname">Gender</label>
                    <?php $gender= $dataobj->PATIENT_GENDER;
					echo (($gender=='M')?'Male':'Female');
			
					 ?>
                </div>
                
                <div class="col-sm-3 required">
                    <label class="control-label" for="fname">Phone Number</label>
                    <?php echo $dataobj->PATIENT_PHONENUM;
					 ?>
                </div>
                
                 <div class="col-sm-3 required">
                    <label class="control-label" for="fname">Address</label>
                    <?php echo $dataobj->PATIENT_ADDRESS;
					 ?>
                </div>
                 <div class="col-sm-3 required">
                    <label class="control-label" for="fname">Email</label>
                    <?php echo $dataobj->PATIENT_EMAIL;
					 ?>
                </div>
                 <div class="col-sm-3 required">
                    <label class="control-label" for="fname">Emergency Name</label>
                    <?php echo $dataobj->PATIENT_EMERGNAME1;
					 ?>
                </div>
                
                 <div class="col-sm-3 required">
                    <label class="control-label" for="fname">Emergency Number</label>
                    <?php echo $dataobj->PATIENT_EMERGNUM1;
					 ?>
                </div>
                <div class="col-sm-3 required">
                    <label class="control-label" for="fname">Emergency Address</label>
                    <?php echo $dataobj->PATIENT_EMERGADDRESS1;
					 ?>
                </div>
               <div class="col-sm-3 required">
                    <label class="control-label" for="fname">Blood Group</label>
                    <?php echo $dataobj->PATIENT_BLOODGROUP;
					 ?>
                </div>
              <div class="col-sm-3 required">
                    <label class="control-label" for="fname">Marital Status</label>
                    <?php echo $dataobj->PATIENT_MARITAL_STATUS;
					 ?>
                </div>
                <div class="col-sm-3 required">
                    <label class="control-label" for="fname">Nationality</label>
                    <?php echo $dataobj->PATIENT_NATIONALITY;
					 ?>
                </div>
                <div class="col-sm-3 required">
                    <label class="control-label" for="fname">Country Resident</label>
                    <?php echo $dataobj->PATIENT_COUNTRY_RESIDENT;
					 ?>
                </div>
            </div>

           

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
                              $cltactiondetail = $engine->getwardActions();
							  
                              while($objdetail = $cltactiondetail->FetchNextObject()){
                               
                                      ?>
                                      <option value="<?php echo $objdetail->SERV_CODE.'_'.$objdetail->SERV_WARD_STATUS ;?>"><?php echo $objdetail->SERV_NAME ;?></option>
                              <?php
                                
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
               <div class="col-sm-4" style="padding-top:25px;">
                           
                            <button  type="submit" onclick="document.getElementById('viewpage').value='takeaction';document.form.submit();" class="btn btn-success"><!--<i class="fa fa-plus-circle">--></i> Submit</button>
                        </div>
               </span>         
                      </div>
                    </div>
                    <div id="vitals" class="tab-pane fade">
                      <div class="controls controls-row" >
                        <div class="form-group">
                <div id="message"></div>
                    <div class="col-sm-12 client-vitals-opt">
                     <div class="form-group">
                    <div class="col-sm-12 client-vitals-opt">
                    <div class="col-sm-4 required">
                        <label class="control-label" for="fname">Vitals Type</label>
                        <select class="form-control" name="vitalstype" id="vitalstype">
                        
                            <option value="" disabled selected hidden>---------</option>
                            <?php
			 				    while($obj1 = $stmtoptions->FetchNextObject()){
							?>
   <option value="<?php echo $obj1->VIT_NAME; ?>"  <?php echo (($obj1->VIT_NAME == $vitals_type)?'selected="selected"':'') ;?> > <?php echo $obj1->VIT_NAME; ?></option>
    <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-4 required">
                        <label for="othername">Value</label>
                        <input type="text" class="form-control" id="vitals-value" name="vitals-value">
                    </div>
                    <div class="btn-group">
                        <div class="col-sm-4 " style="padding-top:30px;">
                            
                            <button type="button" onclick="addvitals();" class="btn btn-info "><i class="fa fa-plus-circle"></i> Add</button>
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
                <div class="btn-group pull-right">
                <div class="col-sm-12" style="padding-bottom:10px;">
                    <button type="button" class="btn btn-success" onclick="saveVitals();">Submit</button>
                </div>
            </div>
                      <table class="table table-responsive table-bordered" id="tbllabs">
                        <thead>
                          <tr>
                            <th>Vital Type</th>
                            <th>Value</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                        $n = 1;
						if($stmtvitals->RecordCount()>0){
                        while ($objlabs = $stmtvitals->FetchNextObject()){
                            ?>
                            <tr>
                               <td><?php echo $objlabs->VITDET_VITALSTYPE;?></td>
                                <td><?php echo $objlabs->VITDET_VITALSVALUE;?></td>
                            </tr>
                            <?php
                        }
					}else{
                        ?>
                        <tr><td colspan="2">
                         No Vitals
                        </td></tr>
                        <?php } ?>
                        </tbody>
                      </table>
                    </div>
                    <div id="labs" class="tab-pane fade">
                      <div class="controls controls-row" >
                        <div class="form-group">
                <div id="message"></div>
                    <div class="col-sm-12 client-vitals-opt">
                    <div class="col-sm-4 required">
                        <label for="othername">Test Name</label>
                        <select name="labtest" id="labtest" class="form-control" tabindex="2"><option value="<?php echo $labtest; ?>"> -- Select Test --</option>
				<?php while($obj = $stmttestlov->FetchNextObject()){  ?>
				<option value="<?php echo $obj->LTT_CODE.'@@'.$obj->LTT_NAME ;?>" <?php echo (($obj->LTT_CODE == $labtest)?'selected':'' )?> ><?php echo $obj->LTT_NAME ;?></option>
				<?php } ?> 

			</select>
                    </div>
                    <div class="col-sm-4 required">
                        <label class="control-label" for="fname">Specimem</label>
                        <select name="specimen" id="specimen" class="form-control" tabindex="2"><option value="<?php echo $specimen; ?>"> -- Select Specimen --</option>
				<?php while($obj = $stmtspecimen->FetchNextObject()){  ?>
				<option value="<?php echo $obj->SP_CODE.'@@'.$obj->SP_NAME ;?>" <?php echo (($obj->SP_CODE == $specimen)?'selected':'' )?> ><?php echo $obj->SP_NAME ;?></option>
				<?php } ?> 

			</select>
                    </div>
                     
                    <div class="col-sm-4 required">
                        <label for="othername">Label</label>
                        <input type="text" class="form-control"  name="label" id="label" >
                    </div>
                    <div class="col-sm-4 required">
                        <label for="othername">Volume</label>
                        <input type="text" class="form-control" id="vol"  name="vol" >
                    </div>
                    <div class="btn-group">
                        
                    </div>
                    <div class="col-sm-4" style="padding-top:25px;">
                           
                            <button  type="button" onclick="savelabtest();" class="btn btn-success"><!--<i class="fa fa-plus-circle">--></i> Submit</button>
                        </div>
                    </div>
                    
                </div>
                      </div>
                      <div class="form-group">
                    <div class="col-sm-12 client-vitals">
                     <table class="table table-hover">
                            <thead>
                                <tr><td><b>Test Name</b> </td><td width="20%"><b>Specimem</b> </td><td width="20%"><b>Label</b> </td><td width="20%"><b>Volume</b> </td><td  width="100"><b>Action</b> </td></tr>
                            </thead>
                            <tbody id="labdata">
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
                      <table class="table table-responsive table-bordered" id="tbllabs">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Lab. Test</th>
                            <th>Spacimen</th>
                            <th>Label</th>
                            <th>Volume</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                        $n = 1;
						if($stmtlabs->RecordCount()>0){
                        while ($objlabs = $stmtlabs->FetchNextObject()){
                            ?>
                            <tr>
                                <td><?php echo $n++; ?></td>
                                 <td><?php echo $objlabs->LT_DATE; ?></td>
                                <td><?php echo $encaes->decrypt($objlabs->LT_TESTNAME); ?></td>
                                 <td><?php echo $encaes->decrypt($objlabs->LT_SPECIMEN); ?></td>
                                  <td><?php echo $objlabs->LT_SPECIMENLABEL; ?></td>
                                <td><?php echo $objlabs->LT_SPECIMENVOLUME; ?></td>
                               
                            </tr>
                            <?php
                        }
					}else{
                        ?>
                        <tr><td colspan="6">
                         No Lab test
                        </td></tr>
                        <?php } ?>
                        </tbody>
                      </table>
                    </div>
                    <div id="diagnosis" class="tab-pane fade">
                      <div class="controls controls-row" style="margin-bottom:10px;">
                        <div class="control-group span6">
                          <label class="control-label">Diagnosis:</label>
                          <div class="controls">
                            <select name="diagnoses" id="diagnoses" class="form-control select2" tabindex="2">
                              <option value="<?php echo $dia; ?>"> -- Select Diagnosis --</option>
                              <?php while($objdpt = $stmtdiagnosislov->FetchNextObject()){  ?>
                              <option value="<?php echo $objdpt->DIS_CODE.'@@'.$objdpt->DIS_NAME ; ?>" <?php echo (($objdpt->DIS_CODE == $dia)?'selected':'' )?> ><?php echo $objdpt->DIS_NAME ;?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="control-group span4">
                        <label class="control-label"> Remark:</label>
                        <div class="controls">
                          <textarea name='remark' id="remark"></textarea>
                          
                          <div class="move-low">
                            <button type="button" class="btn btn-success" id="savediagnose"  >Submit</button>
                          </div>
                          <div class="form-group">
                    <div class="col-sm-12 client-vitals">
                    
                     <table class="table table-hover">
                            <thead>
    <tr><td><b>Diagnosis</b> </td><td width="20%"><b>Remark</b> </td><td  width="100"><b>Action</b> </td></tr>
                            </thead>
                            <tbody id="diagnosdata">
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
                          
                        </div>
                      </div>
                      
                      <table class="table table-responsive table-bordered" id="tbldiagnosis">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Date </th>
                            <th>Diagnosis</th>
                            <th>Remark</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                        $n = 1;
						if($stmtdiag->RecordCount()>0){
                        while ($objdiag = $stmtdiag->FetchNextObject()){
                            ?>
                            <tr>
                                <td><?php echo $n++; ?></td>
                                <td><?php echo $objdiag->DIA_DATE; ?></td>
                                <td><?php echo $encaes->decrypt($objdiag->DIA_DIAGNOSIS); ?></td>
                                <td><?php echo $encaes->decrypt($objdiag->DIA_RMK); ?></td>
                                
                            </tr>
                            <?php
						}
                      }else{
                        ?>
                        <tr><td colspan="5">
                         No Patient Diagnosis
                        </td></tr>
                        <?php } ?>
                        </tbody>
                      </table>
                    </div>
                    <div id="complains" class="tab-pane fade">
                      <div class="controls controls-row" style="margin-bottom:10px;">
                        <div class="control-group span6">
                          <label class="control-label">Complains:</label>
                          <div class="controls">
                            <input type="text" class="form-control" id="copmlainner" name="copmlainner">
                            <span class="input-group-btn">
                            <button type="button" class="btn btn-success" onclick="saveComplain();" style="margin: 24px 0 0 0;">Submit</button>
                            
                            
                            </span>
                          </div>
                        </div>
                      </div>
                      
                      
                      <table class="table table-responsive table-bordered" id="tblcomplain">
                            <thead>
                              <tr>
                                <th>Complain</th>
                                <th style="width: 0">Action</th>
                              </tr>
                            </thead>
                            <tbody id="complaindata">
                              <!--                        <tr><td colspan="3">No Complains </td></tr>-->
                            </tbody>
                          </table>
                          <table class="table table-responsive table-bordered" id="tbldiagnosis">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Date</th>
                             <th>Complain</th>
                             
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                        $n = 1;
						if($stmtcomp->RecordCount()>0){
                        while ($objcomp = $stmtcomp->FetchNextObject()){
                            ?>
                            <tr>
                                <td><?php echo $n++; ?></td>
                                <td><?php echo $objcomp->PC_DATE; ?></td>
                               <td><?php echo $encaes->decrypt($objcomp->PC_COMPLAIN);?></td>
                                
                            </tr>
                            <?php
						}
                      }else{
                        ?>
                        <tr><td colspan="3">
                         No Patient Complains
                        </td></tr>
                        <?php } ?>
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
                              <option value="<?php echo $objdpt->DR_CODE.'@@'.$objdpt->DR_NAME.'@@'.$objdpt->DR_DOSAGE.'@@'.$objdpt->DR_DOSAGENAME ;?>" <?php echo (($objdpt->DR_CODE == $drug)?'selected':'' )?> ><?php echo $objdpt->DR_NAME ;?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-3" style="width: 27%; padding-left:0px !important;">
                        <label>Days</label>
                        <input type="numbers" class="form-control" id="days" name="days" placeholder="Days">
                      </div>
                      <div class="col-sm-3" style="width: 27%">
                        <label>Frequency</label>
                        <input type="numbers" class="form-control" id="frequency" name="frequency" placeholder="Frequency">
                      </div>
                      <div class="col-sm-3" style="width: 27%">
                        <label>Times</label>
                        <input type="numbers" class="form-control" id="times" name="times" placeholder="Times">
                      </div>
                      <div class="col-sm-2 pull-right">
                        <label id="lbl">&nbsp;</label>
                        <button type="button" class="form-control btn btn-success" id="saveprescription">Submit</button>
                      </div>
                      
                      <div class="form-group">
                    <div class="col-sm-12 client-vitals">
                     <table class="table table-hover">
                            <thead>
                          <tr>
                            <th>Prescription</th>
                            <th>Days</th>
                            <th>Frequency</th>
                            <th>Times</th>
                            <th width="100">Action</th>
                          </tr>
                        </thead>
                            <tbody id="prescription">
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
                            <th>Prescription</th>
                            <th>Days</th>
                            <th>Frequency</th>
                            <th>Times</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                        $n = 1;
						if($stmtpres->RecordCount()>0){
                       while ($objpres = $stmtpres->FetchNextObject()){
                            ?>
                            <tr>
                                <td><?php echo $n++; ?></td>
                                <td><?php echo $objpres->PRESC_DATE; ?></td>
                                <td><?php echo $encaes->decrypt($objpres->PRESC_DRUG); ?></td>
                                <td><?php echo $objpres->PRESC_DAYS; ?></td>
                                <td><?php echo $objpres->PRESC_FREQ; ?></td>
                                <td><?php echo $objpres->PRESC_TIMES; ?></td>
                                
                            </tr>
                            <?php
                        }
                        }else{
                        ?>
                        <tr><td colspan="7">
                         No Patient Prescription
                        </td></tr>
                        <?php } ?>
                        </tbody>
                      </table>
                    </div>
                    
                    <div id="management" class="tab-pane fade">
                      <div class="controls controls-row" style="margin-bottom:10px;">
                        <div class="control-group span6">
                          <label class="control-label">Management:</label>
                          <div class="controls">
                           <textarea rows="6" cols="65" id="mgnt" name="mgnt">

                        </textarea>
                          </div>
                           <div class="move-low">
                            <button type="button" class="btn btn-success" id="savemgnt"  >Submit</button>
                          </div>
                        </div>
                      </div>
                      <div class="control-group span4">
                        <div class="controls">
                    <div class="col-sm-12 client-vitals">
                     <table class="table table-hover">
                            <thead>
                          <tr>
                            <th>Management</th>
                            <th width="100">Action</th>
                          </tr>
                        </thead>
                            <tbody id="mgntdata">
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
                         
                        </div>
                        <table class="table table-responsive table-bordered" id="tbldiagnosis">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Management</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                        $n = 1;
						if($stmtmgnt->RecordCount()>0){
                        while ($objmgnt = $stmtmgnt->FetchNextObject()){
                            ?>
                            <tr>
                                <td><?php echo $n++; ?></td>
                                <td><?php echo $encaes->decrypt($objmgnt->PM_MANAGEMENT);?></td>
                                
                            </tr>
                            <?php
						}
                      }else{
                        ?>
                        <tr><td colspan="2">
                         No Management captured
                        </td></tr>
                        <?php } ?>
                        </tbody>
                      </table>
                      </div>
                      
                      <div id="history" class="tab-pane fade">
                      <div class="controls controls-row" style="margin-bottom:10px;">
                        <div class="control-group span6">
                          <label class="control-label">Complains History:</label>
                        </div>
                      </div>
                      
                        <div class="form-group">
                    <div class="col-sm-12 required">
                      <table class="table table-responsive table-bordered" id="tblcomplain">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Complain</th>
                            <th>Actor</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
					if($stmtpc->RecordCount() > 0){
						$num = 1;
						while($obj  = $stmtpc->FetchNextObject()){
						
						?>
                          <tr>
                            <td><?php echo $num++; ?></td>
                            <td><?php echo $obj->PC_DATE; ?></td>
                            <td><?php echo $encaes->decrypt($obj->PC_COMPLAIN); ?></td>
                            <td><?php echo $obj->PC_ACTORNAME; ?></td>
                          </tr>
                          <?php
						  
						}
					}else{
						?>
                        <tr><td colspan="4">
                        No Complain History
                        </td></tr>
                        <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="controls controls-row" style="margin-bottom:10px;">
                        <div class="control-group span6">
                          <label class="control-label">Vitals History:</label>
                        </div>
                      </div>
                  <div class="form-group">
                    <div class="col-sm-12 required">
                      <table class="table table-responsive table-bordered" id="tblcomplain">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Vital Type</th>
                             <th>Value</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
					if($stmtvt->RecordCount() > 0){
						$num = 1;
						while($objvt  = $stmtvt->FetchNextObject()){
						
						?>
                          <tr>
                            <td><?php echo $num++; ?></td>
                             <td><?php echo date('Y-m-d',strtotime($objvt->VITDET_DATEADDED));?></td>
                            <td><?php echo $objvt->VITDET_VITALSTYPE;?></td>
                             <td><?php echo $objvt->VITDET_VITALSVALUE;?></td>
                          </tr>
                          <?php
						  
						}
					}else{
						?>
                        <tr><td colspan="5">
                        No Vitals History
                        </td></tr>
                        <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  
                  <div class="controls controls-row" style="margin-bottom:10px;">
                        <div class="control-group span6">
                          <label class="control-label">Lab History:</label>
                        </div>
                      </div>
                      <div class="form-group">
                    <div class="col-sm-12 required">
                      <table class="table table-responsive table-bordered" id="tbllabs">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Lab. Test</th>
                        <th>Clinical Remark</th>
                        <th>Actor</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
					if($stmtlt->RecordCount() > 0){
						$num = 1;
						while($obj  = $stmtlt->FetchNextObject()){
						
						?>
                          <tr>
                            <td><?php echo $num++; ?></td>
                            <td><?php echo $obj->LT_DATE; ?></td>
                            <td><?php echo $encaes->decrypt($obj->LT_TESTNAME); ?></td>
                            <td><?php echo $encaes->decrypt($obj->LT_RMK); ?></td>
                            <td><?php echo $obj->LT_ACTORNAME; ?></td>
                          </tr>
                          <?php
						  
						}
					}
					else{
						?>
                        <tr><td colspan="5">
                        No Lab Test History
                        </td></tr>
                        <?php } ?>
                    </tbody>
                  </table>
                  </div>
                  </div>
                  <div class="controls controls-row" style="margin-bottom:10px;">
                        <div class="control-group span6">
                          <label class="control-label">Diagnosis History:</label>
                        </div>
                      </div>
                      <div class="form-group">
                    <div class="col-sm-12 required">
                  <table class="table table-responsive table-bordered" id="tbldiagnosis">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Diagnosis</th>
                        <th>Remark</th>
                        <th>Actor</th>
                      </tr>
                    </thead>
                    <tbody>
                    	<?php 
					if($stmtdia->RecordCount() > 0){
						$num = 1;
						while($obj  = $stmtdia->FetchNextObject()){
						
						?>
                          <tr>
                            <td><?php echo $num++; ?></td>
                            <td><?php echo $obj->DIA_DATE; ?></td>
                            <td><?php echo $encaes->decrypt($obj->DIA_DIAGNOSIS); ?></td>
                            <td><?php echo $encaes->decrypt($obj->DIA_RMK); ?></td>
                            <td><?php echo $obj->DIA_ACTORNAME; ?></td>
                          </tr>
                          <?php
						  
						}
					}else{
						?>
                        <tr><td colspan="5">
                        No Diagnosis History
                        </td></tr>
                        <?php } ?>
                    </tbody>
                  </table>
                  </div>
                  </div>
                   <div class="controls controls-row" style="margin-bottom:10px;">
                        <div class="control-group span6">
                          <label class="control-label">Prescription History:</label>
                        </div>
                      </div>
                      <div class="form-group">
                    <div class="col-sm-12 required">
                  <table class="table table-responsive table-bordered" id="tblprescription">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Prescription</th>
                        <th>Days</th>
                        <th>Frequency</th>
                        <th>Times</th>
                        <th>Actor</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
					if($stmtp->RecordCount() > 0){
						$num = 1;
						while($obj  = $stmtp->FetchNextObject()){
						
						?>
                          <tr>
                            <td><?php echo $num++; ?></td>
                            <td><?php echo date('Y-m-d',strtotime($obj->PRESC_DATE))?></td>
                            <td><?php echo $encaes->decrypt($obj->PRESC_DRUG); ?></td>
                            <td><?php echo $obj->PRESC_DAYS; ?></td>
                            <td><?php echo $obj->PRESC_FREQ; ?></td>
                            <td><?php echo $obj->PRESC_TIMES; ?></td>
                            <td><?php echo $obj->PRESC_ACTORNAME; ?></td>
                          </tr>
                          <?php
						  
						}
					}else{
						?>
                        <tr><td colspan="7">
                        No Prescription History 
                        </td></tr>
                        <?php } ?>
                    </tbody>
                  </table>
                  </div>
                  </div>
                  
                  <div class="controls controls-row" style="margin-bottom:10px;">
                        <div class="control-group span6">
                          <label class="control-label">Management History:</label>
                        </div>
                      </div>
                      <div class="form-group">
                    <div class="col-sm-12 required">
                  <table class="table table-responsive table-bordered" id="tbldiagnosis">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Management</th>
                        <th>Actor</th>
                      </tr>
                    </thead>
                    <tbody>
                    	<?php 
					if($stmtmg->RecordCount() > 0){
						$num = 1;
						while($objm  = $stmtmg->FetchNextObject()){
						
						?>
                          <tr>
                            <tr>
                                <td><?php echo $n++; ?></td>
                                <td><?php echo $objm->PM_DATE;?></td>
                                <td><?php echo $encaes->decrypt($objm->PM_MANAGEMENT);?></td>
                                <td><?php echo $objm->PM_ACTORNAME;?></td>
                                
                            </tr>
                          </tr>
                          <?php
						  
						}
					}else{
						?>
                        <tr><td colspan="5">
                        No Management History
                        </td></tr>
                        <?php } ?>
                    </tbody>
                  </table>
                  </div></div>
                  
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