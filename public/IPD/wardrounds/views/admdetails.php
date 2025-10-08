<?php
$rs = $paging->paginate();

$pg = '1';
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
        
        
         <input type="hidden" class="form-control" id="" name="visitcode" value="<?php echo $visitcode; ?>" readonly>
		<input type="hidden" class="form-control" id="" name="patientnum" value="<?php echo $patientnum; ?>" readonly>
		<input type="hidden" class="form-control" id="" name="patient" value="<?php echo $patient; ?>" readonly>
        <input type="hidden" class="form-control" id="" name="faccode" value="<?php echo $faccode; ?>" readonly>
		<input type="hidden" class="form-control" id="" name="keycode" value="<?php echo $keycode; ?>" readonly>
		<input type="hidden" class="form-control" id="patientno" name="patientno" value="<?php echo $patientno[0]; ?>" readonly>
		
           


            <?php //$engine->msgBox($msg,$status); ?>

            <!-- <div class="page-lable lblcolor-page">Table</div>-->
            <div class="page form">
                <div class="moduletitle" style="margin-bottom:0px;">
                    <div class="moduletitleupper">Ward Rounds - Patient Details</div> 
                </div>
                
			<div class="form-group">
                <div class="col-sm-4 required">
                    <label class="control-label" for="fname">Patient Name</label>
                    <?php  echo $patient; ?>
                </div>
                <div class="col-sm-4 required">
                    <label for="othername">Patient Number</label>
                    <?php  echo $patientnum; ?>
                </div>
                <div class="col-sm-4">
                    <label for="email">Visit Code</label>
                    <?php  echo $visitcode; ?>
                </div>
            </div>
			
                <div class="pagination-tab">
                    <div class="table-title">
                      
                        
                       <div class="pagination-right" id="hiddenbtn" style="display: ">
					   <button title="Patient Details" <?php if($pg == '1'){ ?> class="btn btn-success ttip" <?php }else{ ?>class="btn btn-primary"<?php } ?> onclick="document.getElementById('view').value='details';document.getElementById('viewpage').value='consult';document.myform.submit()">Patient Details</button>
					   <button title="Patient Vitals" <?php if($pg == '11'){ ?> class="btn btn-success ttip" <?php }else{ ?>class="btn btn-primary"<?php } ?> onclick="document.getElementById('view').value='vitals';document.getElementById('viewpage').value='consult';document.myform.submit()">Patient Vitals</button>
		 <button title="Presenting Complains" <?php if($pg == '2'){ ?> class="btn btn-success ttip" <?php }else{ ?>class="btn btn-primary"<?php } ?> onclick="document.getElementById('view').value='complains';document.getElementById('viewpage').value='consult';document.myform.submit()">Presenting Complains</button>
         <button title="Labs" <?php if($pg == '4'){ ?> class="btn btn-success ttip" <?php }else{ ?>class="btn btn-primary"<?php } ?> onclick="document.getElementById('view').value='labs';document.getElementById('viewpage').value='consult';document.myform.submit()">Laboratory</button>	 
         
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
           
           <div class="form-group">
                <div class="col-sm-3 required">
                    <label class="control-label" for="fname">Gender</label>
                    <?php echo $p; ?>
                </div>
               
             
            </div>

           

        </div>
    </div>

    