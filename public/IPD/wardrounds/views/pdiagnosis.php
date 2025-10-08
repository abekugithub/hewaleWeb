<?php
$rs = $paging->paginate();

$pg = '5';
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
                <div class="moduletitleupper">Diagnosis Details<span class="pull-right">
                   
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
            <?php
			$keys_code=explode('@@',$keys);			
				
			
			$stmt = $sql->Execute($sql->Prepare("SELECT DIA_DATE FROM hms_patient_diagnosis WHERE DIA_STATUS = ".$sql->Param('a')." AND DIA_PATIENTNUM=".$sql->Param('b')." AND DIA_VISITCODE=".$sql->Param('c')." GROUP BY DIA_DATE"),array('1',$patientno[0],$keys_code[1]));
			
			if($stmt->RecordCount()>0){
		while($obj=$stmt->FetchNextObject()){
        $pcode=$obj->LT_PATIENTCODE;
			 ?>
             <div><b>Date:</b> <?php echo $obj->DIA_DATE; ?></div>
             
             <?php 
			$stmts = $sql->Execute($sql->Prepare("SELECT DIA_DIAGNOSIS,DIA_RMK FROM hms_patient_diagnosis WHERE DIA_STATUS = ".$sql->Param('a')." AND DIA_VISITCODE=".$sql->Param('b')." AND DIA_DATE=".$sql->Param('c')." "),array('1',$keys_code[1],$obj->DIA_DATE));


			  ?>
            
                <div class="form-group">
                    <div class="col-sm-12 client-info">
                        
                            <table class="table table-hover">
                            <thead>
                            <tr><td><b>Diagnosis</b> </td><td width="20%"><b>Remark</b> </td></tr>
                            <?php
							if($stmts->RecordCount()> 0){
	 while($objs=$stmts->FetchNextObject()){ 
							 ?>
                                <tr>
                                    <td><?php echo $encaes->decrypt($objs->DIA_DIAGNOSIS);?></td>
                                    <td><?php echo $encaes->decrypt($objs->DIA_RMK);?></td>
                                </tr>
                                 <?php  }
								 
								 }?>
                                 </thead>
                            </table>
                        
                    </div>
                </div>
                
                <?php
				
		}
		}
				 ?>
                
				
                <div class="form-group">
                <div id="message"></div>
                    <div class="col-sm-12 client-vitals-opt">
                    <div class="col-sm-4 required">
                        <label for="othername">Diagnosis</label>
                        <select name="diagnosis" id="diagnosis" class="form-control select2" tabindex="2">
                              <option value="<?php echo $dia; ?>"> -- Select Diagnosis --</option>
                              <?php while($objdpt = $stmtdiagnosislov->FetchNextObject()){  ?>
                              <option value="<?php echo $objdpt->DIS_CODE.'@@'.$objdpt->DIS_NAME ; ?>" <?php echo (($objdpt->DIS_CODE == $dia)?'selected':'' )?> ><?php echo $objdpt->DIS_NAME ;?></option>
                              <?php } ?>
                            </select>
                    </div>
                    <div class="col-sm-4 required">Remark
                      <textarea name='remark' id="remark"></textarea>
                    </div>
                    <div class="btn-group">
                        <div class="col-sm-4 ">
                            <label for="othername">&nbsp;</label>
                            <button type="button" onclick="savediagnose();" class="btn btn-success"><i class="fa fa-plus-circle"></i> Submit</button>
                        </div>
                    </div>
                    </div>
                </div>
                 
                <div class="form-group">
                    <div class="col-sm-12 client-vitals">
                     <table class="table table-hover">
                            <thead>
    <tr><td><b>Diagnosis Name</b> </td><td width="20%"><b>Remark</b> </td><td  width="100"><b>Action</b> </td></tr>
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
            <div class="btn-group pull-right">
                <div class="col-sm-12">
                    <!--<button type="button" class="btn btn-success" onclick="savetest();">Submit</button>-->
                </div>
            </div>
        </div>
    </div>
</div>


    