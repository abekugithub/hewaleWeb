<?php $rs = $paging->paginate();?>
<style type="text/css">
    .demo {
        position: relative;
    }

    .demo i {
        position: absolute;
        bottom: 10px;
        right: 24px;
        top: auto;
        cursor: pointer;
    }
</style>
<style>
.rowdanger{
	background-color:#97181B4D}
.rowwarning{
	background-color:#EBECB9}
.rowinfo{
	background-color:#C0C0C0}
</style>
 
<div class="main-content">
    <div class="page-wrapper">

        <input type="hidden" class="form-control" id="" name="visitcode" value="<?php echo $visitcode; ?>" readonly>
		<input type="hidden" class="form-control" id="" name="patientnum" value="<?php echo $patientnum; ?>" readonly>
		<input type="hidden" class="form-control" id="" name="patient" value="<?php echo $patient; ?>" readonly>
		<input type="hidden" class="form-control" id="" name="keys" value="<?php echo $keys; ?>" readonly>
	   <input type="hidden" class="form-control" id="vkeys" name="vkeys" value="<?php echo $vkeys; ?>" readonly>   
       <input type="hidden" class="form-control" id="test" name="test" value="<?php echo $test; ?>" readonly>     	
		
           

        <!-- <div class="page-lable lblcolor-page">Table</div> -->
        <div class="page form">
            <div class="moduletitle" style="padding-bottom:1">
                <div class="moduletitleupper"> Take Specimen for</div>
                <div class="form-group" style="padding-bottom:30px;">
                <div class="col-sm-3 required">
                    <label class="control-label" for="fname">Patient Name:</label>
                    <?php  echo $names; ?>
                </div>
                <div class="col-sm-3 required">
                    <label for="othername">Patient Number:</label>
                    <?php  echo $indexnum; ?>
                </div>
                 <div class="col-sm-3">
                    <label for="email">Test:</label>
                    <?php  echo $test; ?>
                </div>
                <div class="col-sm-4">
                    <label for="email">Visit Code:</label>
                    <?php  echo $visitcode; ?>
                </div>
               
            </div> 
			
            </div>
			
			
			<?php $engine->msgBox($msg,$status); ?>

            <div class="form-group">
			<div class="col-sm-2 required">
                    <label for="othername">Request Number</label>
                    <input type="text" class="form-control" id="" name="vkeys" value="<?php echo $vkeys; ?>" readonly>
                </div>
                <div class="col-sm-3 required">
                    <label class="control-label" for="fname">Date</label>
                    <input type="text" class="form-control" id="fname" name="startdate">
                </div>
				<div class="col-sm-3 required">
                        <label>Specimen</label><br />
                         <div class="controls">
			<select name="specimen" id="specimen" class="form-control" tabindex="2"><option value="<?php echo $specimen; ?>"> -- Select Specimen --</option>
				<?php while($obj = $stmtspecimen->FetchNextObject()){  ?>
				<option value="<?php echo $obj->SP_CODE.'@@@'.$obj->SP_NAME ;?>" <?php echo (($obj->SP_CODE == $specimen)?'selected':'' )?> ><?php echo $obj->SP_NAME ;?></option>
				<?php } ?> 

			</select>
              </div>
                    </div>
                <div class="col-sm-2 required">
                    <label for="othername">Label</label>
                    <input type="text" class="form-control" id="" name="label" >
                </div>
                <div class="col-sm-2 required">
                    <label for="email">Volume</label>
                   <input type="text" class="form-control" id=""  name="vol" >
                </div>
            </div>
            
            <div class="btn-group pull-right">
                <div class="col-sm-12">
                   
                   <button type="button" class="btn btn-success btn-square"  onclick="document.getElementById('viewpage').value='savespecimen';document.myform.submit();">Save</button>
            <button type="submit" id="acceptLab" onclick="document.getElementById('view').value='details';document.getElementById('viewpage').value='back';document.myform.submit;" class="btn btn-dark"><i class="fa fa-arrow-left"></i> Back </button>  
                    
                </div>
            </div>

<div id="message"></div>


            
        </div>

    </div>

</div>
