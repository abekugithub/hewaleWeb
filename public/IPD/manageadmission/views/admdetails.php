<?php
$rs = $paging->paginate();
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
		<input type="hidden" class="form-control" id="" name="prescriber" value="<?php echo $prescriber; ?>" readonly>
		<input type="hidden" class="form-control" id="" name="prescribercode" value="<?php echo $prescribercode; ?>" readonly>
		
		
            <?php //$engine->msgBox($msg,$status); ?>

            <!-- <div class="page-lable lblcolor-page">Table</div>-->
            <div class="page form">
                <div class="moduletitle" style="margin-bottom:0px;">
                    <div class="moduletitleupper">Pending Admission - Assign Bed</div> 
                </div>
                
			<div class="form-group">
                <div class="col-sm-4 required">
                    <label class="control-label" for="fname">Patient Name</label>
                    <?php  echo $patient; ?>
                </div>
                <div class="col-sm-4 required">
                    <label for="othername">Hewale Number</label>
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
                        <button type="submit" id="acceptLab" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit;" class="btn btn-Danger"><i class="fa fa-times-circle"></i> Back </button>
                    </div>
                    </div>
                </div>

               
            <?php $engine->msgBox($msg,$status); ?>
           <div class="main-content">
		   
    <div class="page-wrapper">
        <div class="page form">
           
            <div class="form-group">
                <div class="col-sm-4 required">
                    <label class="control-label" for="fname">Date</label>
                    <input type="text" class="form-control datepicker" id="fname" name="startdate">
                </div>
               
                <div class="col-sm-4">
                    <label for="email">Bed</label>
                    		<select name="bed" id="bed" class="form-control" tabindex="2"><option value="<?php echo $bed; ?>"> -- Select Bed , ward --</option>
				<?php while($objdpt = $stmtbedlov->FetchNextObject()){  ?>
				<option value="<?php echo $objdpt->BED_CODE.'@@@'.$objdpt->BED_NAME.'@@@'.$objdpt->BED_WARDID.'@@@'.$objdpt->BED_WARDNAME;?>" <?php echo (($objdpt->BED_CODE == $bed)?'selected':'' )?> ><?php echo $objdpt->BED_NAME.' ,'.$objdpt->BED_WARDNAME ;?></option>
				<?php } ?> 


			</select>
                </div>
            </div>
          

            <div class="btn-group pull-right">
                <div class="col-sm-12">
                    <button type="button" class="btn btn-info btn-square"  onclick="document.getElementById('viewpage').value='saveassignbed';document.myform.submit();">Save</button>
            
                    
                </div>
            </div>

        </div>
    </div>

    