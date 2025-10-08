<?php
$rs = $paging->paginate();

$pg = '9';
?>
<style>
.rowdanger{
	background-color:#97181B4D}
.rowwarning{
	background-color:#EBECB9}
.rowinfo{
	background-color:#FFA500}
</style>
    <div class="main-content">

        <div class="page-wrapper">
        
        
        
		
           	   


            <?php //$engine->msgBox($msg,$status); ?>

            <!-- <div class="page-lable lblcolor-page">Table</div>-->
            <div class="page form">
                <div class="moduletitle" style="margin-bottom:0px;">
                    <div class="moduletitleupper">Ward Rounds - Patient Lab</div> 
                </div>
        <input type="hidden" class="form-control" id="visitcode" name="visitcode" value="<?php echo $patientCls->visitcode($faccode,$patientcode); ?>" readonly>
		<input type="hidden" class="form-control" id="patientno" name="patientno" value="<?php echo $patientno[0]; ?>" readonly>
        
        <input type="hidden" class="form-control" id="dateadded" name="dateadded" value="<?php echo date('Y-m-d'); ?>" readonly>
        <input type="hidden" class="form-control" id="patientcode" name="patientcode" value="<?php  $dataobj=$patientCls->getPatientDetails($patientno[0]);echo $dataobj->PATIENT_PATIENTCODE; ?>" readonly>
        
        <input type="hidden" class="form-control" id="patientname" name="patientname" value="<?php  $dataobj=$patientCls->getPatientDetails($patientno[0]);echo $dataobj->PATIENT_FNAME." ".$dataobj->PATIENT_MNAME." ".$dataobj->PATIENT_LNAME; ?>" readonly>
        <input type="hidden" class="form-control" id="actorid" name="actorid" value="<?php echo $usrcode; ?>" readonly>
        <input type="hidden" class="form-control" id="actorname" name="actorname" value="<?php echo $usrname; ?>" readonly>
        <input type="hidden" class="form-control" id="faccode" name="faccode" value="<?php echo $faccode; ?>" readonly>
        
		<input type="hidden" class="form-control" id="patient" name="patient" value="<?php echo $patient; ?>" readonly>
        <input type="hidden" class="form-control" id="faccode" name="faccode" value="<?php echo $faccode; ?>" readonly>
		<input type="hidden" class="form-control" id="keycode" name="keycode" value="<?php echo $keycode; ?>" readonly>
       <input type="hidden" class="form-control" id="keys" name="keys" value="<?php echo $keys; ?>" readonly>

        
  <input type="hidden" class="form-control" id="actorcode" name="actorcode" value="<?php echo  $engine->getActorCode(); ?>" readonly>

		
			<!--<div class="form-group">
                <div class="col-sm-4 required">
                    <label class="control-label" for="fname">Patient Name</label>
                    <?php  //echo $patient; ?>
                </div>
                <div class="col-sm-4 required">
                    <label for="othername">Patient Number</label>
                    <?php  //echo $patientnum; ?>
                </div>
                <div class="col-sm-4">
                    <label for="email">Visit Code</label>
                    <?php  //echo $visitcode; ?>
                </div>
            </div>-->
			
                <div class="pagination-tab">
                    <div class="table-title">
                      
                        
                       <div class="pagination-right" id="hiddenbtn" style="display: ">
					   <button title="Patient Details" <?php if($pg == '1'){ ?> class="btn btn-success ttip" <?php }else{ ?>class="btn btn-primary"<?php } ?> onclick="document.getElementById('view').value='admdetails';document.getElementById('viewpage').value='admdetails';document.myform.submit()">Patient Details</button>
                       
					   <button title="Patient Vitals" <?php if($pg == '2'){ ?> class="btn btn-success ttip" <?php }else{ ?>class="btn btn-primary"<?php } ?> onclick="document.getElementById('view').value='patientvitals';document.getElementById('viewpage').value='patientvitals';document.myform.submit()">Patient Vitals</button>
		 <button title="Presenting Complains" <?php if($pg == '3'){ ?> class="btn btn-success ttip" <?php }else{ ?>class="btn btn-primary"<?php } ?> onclick="document.getElementById('view').value='complains';document.getElementById('viewpage').value='complains';document.myform.submit()">Presenting Complains</button>
         <button title="Labs" <?php if($pg == '4'){ ?> class="btn btn-success ttip" <?php }else{ ?>class="btn btn-primary"<?php } ?> onclick="document.getElementById('view').value='patientlab';document.getElementById('viewpage').value='patientlab';document.myform.submit()">Laboratory</button>	 
         
         <button title="Patient Diagnosis" <?php if($pg == '5'){ ?> class="btn btn-success ttip" <?php }else{ ?>class="btn btn-primary"<?php } ?> onclick="document.getElementById('view').value='diagnosis';document.getElementById('viewpage').value='diagnosis';document.myform.submit()">Diagnosis</button>	 
         <button title="Patient Prescription" <?php if($pg == '6'){ ?> class="btn btn-success ttip" <?php }else{ ?>class="btn btn-primary"<?php } ?> onclick="document.getElementById('view').value='prescription';document.getElementById('viewpage').value='prescription';document.myform.submit()">Prescription</button>
         
         <button title="Patient Management" <?php if($pg == '7'){ ?> class="btn btn-success ttip" <?php }else{ ?>class="btn btn-primary"<?php } ?> onclick="document.getElementById('view').value='manage';document.getElementById('viewpage').value='manage';document.myform.submit()">Management</button>
         
         	 
         
         <button title="Patient History" <?php if($pg == '8'){ ?> class="btn btn-success ttip" <?php }else{ ?>class="btn btn-primary"<?php } ?> onclick="document.getElementById('view').value='history';document.getElementById('viewpage').value='history';document.myform.submit()">History</button>
         
          
         <button title="Patient History" <?php if($pg == '9'){ ?> class="btn btn-success ttip" <?php }else{ ?>class="btn btn-primary"<?php } ?> onclick="document.getElementById('view').value='action';document.getElementById('viewpage').value='consult';document.myform.submit()">Action</button>
<button type="submit" id="acceptLab" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit;" class="btn btn-dark"><i class="fa fa-arrow-left"></i> Back </button>
                    </div>
                    </div>
                </div>

            <?php $engine->msgBox($msg,$status); ?>
           
    <div class="main-content">
    <div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Action<span class="pull-right">
                   
                    </span>
                </div>
            </div>
            <p id="msg" class="alert alert-danger" hidden></p>
            <div class="col-sm-2">
                <div class="id-photo">
                    <img src="<?php echo SHOST_PASSPORT; ?><?php echo isset($image)?$image:'avatar.png';?>" alt="" id="prevphoto" style="width:100% !important; margin:0px !important;">
                </div>
            </div>
            <div class="col-sm-10">
           <div id="actions" >
                      <div class="form-group">
                        <div class="col-sm-12 required">
                          <input type="hidden" id="copmlaincode" name="copmlaincode">
                          <div class="controls">
                            
                            <select name="actiontype" id="actiontype" class="form-control select2" tabindex="2">
                              <option value="" disabled selected>--- Select Action ---</option>
                              <?php
                              $cltactiondetail = $engine->getConsultActions();
							   print_r($cltactiondetail);
							  echo "ppp";
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
             <button type="button" class="btn btn-success" onclick="takeaction();" style="margin: 20px 0 0 0; float:right">Submit</button>
              </div>
              
               </span>         
                      </div>
                    </div>

            </div>
            <div class="btn-group pull-right">
                <div class="col-sm-12">
                    <!--<button type="button" class="btn btn-success" onclick="savetest();">Submit</button>-->
                </div>
            </div>
        </div>
    </div>
</div>


    