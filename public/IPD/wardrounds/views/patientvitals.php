<?php
$rs = $paging->paginate();

$pg = '2';
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
                    <div class="moduletitleupper">Ward Rounds - Patient Details</div> 
                </div>
        <input type="hidden" class="form-control" id="visitcode" name="visitcode" value="<?php echo $patientCls->visitcode($faccode,$patientcode); ?>" readonly>
		<input type="hidden" class="form-control" id="patientno" name="patientno" value="<?php echo $patientno[0]; ?>" readonly>
        <input type="hidden" class="form-control" id="patientcode" name="patientcode" value="<?php $dataobj=$patientCls->getPatientDetails($patientno[0]);echo $dataobj->PATIENT_PATIENTCODE; ?>" readonly>
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
         
          
         <button title="Patient History" <?php if($pg == '9'){ ?> class="btn btn-success ttip" <?php }else{ ?>class="btn btn-primary"<?php } ?> onclick="document.getElementById('view').value='action';document.getElementById('viewpage').value='action';document.myform.submit()">Action</button>
<button type="submit" id="acceptLab" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit;" class="btn btn-dark"><i class="fa fa-arrow-left"></i> Back </button>
                    </div>
                    </div>
                </div>

            <?php $engine->msgBox($msg,$status); ?>
           
    <div class="main-content">
    <div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Vitals Form <span class="pull-right">
                   
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
		//print_r($keys_code);
$stmt = $sql->Execute($sql->Prepare("SELECT VITALS_INPUTEDDATE FROM hms_vitals WHERE  VITALS_PATIENTNO = ".$sql->Param('a')." AND VITALS_VISITCODE=".$sql->Param('b')." GROUP BY VITALS_INPUTEDDATE"),array($keys_code[0],$keys_code[1]));
print $sql->ErrorMsg();
while($obj=$stmt->FetchNextObject()){

			 ?>
             <div><b>Date:</b> <?php echo $obj->VITALS_INPUTEDDATE; ?></div>
             
             <?php 
			 $stmts = $sql->Execute($sql->Prepare("SELECT * FROM hms_vitals_details WHERE  VITDET_PATIENTNO = ".$sql->Param('a')." AND VITDET_VISITCODE=".$sql->Param('b')." AND VITDET_DATEADDED=".$sql->Param('c').""),array($keys_code[0],$keys_code[1],$obj->VITALS_INPUTEDDATE));
print $sql->ErrorMsg();
			  ?>
                <div class="form-group">
                    <div class="col-sm-12 client-info">
                        
                            <table class="table table-hover">
                            <thead>
                            <tr><td><b>Name:</b> </td><td width="20%"><b>Value:</b> </td></tr>
                            <?php
							if($stmts->RecordCount()> 0){
	 while($objs=$stmts->FetchNextObject()){ 
							 ?>
                                <tr>
                                    <td><?php echo $objs->VITDET_VITALSTYPE;?></td>
                                    <td><?php echo $objs->VITDET_VITALSVALUE;?></td>
                                </tr>
                                 <?php  }}?>
                                 </thead>
                            </table>
                        
                    </div>
                </div>
                
                <?php
				
		}
				 ?>
                
				
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
                        <div class="col-sm-4 ">
                            <label for="othername">&nbsp;</label>
                            <button type="button" onclick="addvitals();" class="btn btn-info "><i class="fa fa-plus-circle"></i> Add</button>
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

            </div>
            <div class="btn-group pull-right">
                <div class="col-sm-12">
                    <button type="button" class="btn btn-success" onclick="saveVitals();">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>


    