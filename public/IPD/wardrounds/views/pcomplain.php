<?php
$rs = $paging->paginate();

$pg = '3';
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
         <input type="hidden" class="form-control" id="complainid" name="complainid" value="<?php echo $complainid; ?>" /> 
        <input type="hidden" class="form-control" id="patientcode" name="patientcode" value="<?php $dataobj=$patientCls->getPatientDetails($patientno[0]);echo $dataobj->PATIENT_PATIENTCODE; ?>" readonly>
        <input type="hidden" class="form-control" id="compdate" name="compdate" value="<?php echo date('Y-m-d'); ?>" readonly>
 <input type="hidden" class="form-control" id="compcode" name="compcode" value="<?php echo $engine->getcomplainCode(); ?>" readonly>
  <input type="hidden" class="form-control" id="actorcode" name="actorcode" value="<?php echo $engine->getActorCode(); ?>" readonly>
        <input type="hidden" class="form-control" id="faccode" name="faccode" value="<?php echo $faccode; ?>" readonly>
        
  <input type="hidden" class="form-control" id="getcomplains" name="getcomplains" value="<?php  $mycomplains = "'".implode("','", $session->get('complains'))."'"; //echo $mycomplains; ?>" readonly>

		<input type="hidden" class="form-control" id="keycode" name="keycode" value="<?php echo $keycode; ?>" readonly>
        <input type="hidden" class="form-control" id="actorname" name="actorname" value="<?php echo  $engine->getActorName(); ?>" readonly>
        
		
            
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
                <div class="moduletitleupper">Patient Complains<span class="pull-right">
                   
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
$stmt = $sql->Execute($sql->Prepare("SELECT PC_INPUTEDDATE FROM hms_patient_complains WHERE  PC_PATIENTNUM = ".$sql->Param('a')." AND PC_VISITCODE=".$sql->Param('b')." GROUP BY PC_INPUTEDDATE"),array($keys_code[0],$keys_code[1]));
print $sql->ErrorMsg();
while($obj=$stmt->FetchNextObject()){

			 ?>
             <div><b>Captured Date:</b> <?php echo $obj->PC_INPUTEDDATE; ?></div>
             
             <?php 
			 $stmts = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient_complains WHERE  PC_PATIENTNUM = ".$sql->Param('a')." AND PC_VISITCODE=".$sql->Param('b')." AND PC_INPUTEDDATE=".$sql->Param('c')." "),array($keys_code[0],$keys_code[1],$obj->PC_INPUTEDDATE));
print $sql->ErrorMsg();
			  ?>
                <div class="form-group">
                    <div class="col-sm-12 client-info">
                        
                            <table class="table table-hover">
                            <thead>
                            <tr><td><b>Complains</b> </td></tr>
                            <?php
							if($stmts->RecordCount()> 0){
	 while($objs=$stmts->FetchNextObject()){ 
	 $complains[]=$objs->PC_COMPLAIN;
	 $session->set('complains',$complains);
							 ?>
                                <tr>
                                    <td><?php echo $encaes->decrypt($objs->PC_COMPLAIN);?></td>
                                    
                                </tr>
                                 <?php  }}?>
                                 </thead>
                            </table>
                        
                    </div>
                </div>
                
                <?php
				
		}
				 ?>
                
                <div id="complains" class="tab-pane fade in active">
                      <div class="form-group">
                        <div class="col-sm-12 required">
                          <input type="hidden" id="copmlaincode" name="copmlaincode">
                          <div class="form-group input-group">
                            <label class="control-label" for="copmlainner">Complains</label>
                            <input type="text" class="form-control" id="copmlainner" name="copmlainner">
                            <span class="input-group-btn">
                            <button type="button" class="btn btn-success" onclick="saveComplain();" style="margin: 24px 0 0 0;">Submit</button>
                            
                            
                            </span> </div>
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
                        </div>
                      </div>
                    </div>
                

            </div>
            <div class="btn-group pull-right">
                <div class="col-sm-12">
                    
                </div>
            </div>
        </div>
    </div>
</div>

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
    