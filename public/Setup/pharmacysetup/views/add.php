

<script type="text/javascript" src="media/js/jquery-ui.min.js"></script>

<div class="main-content">
    <div class="page-wrapper">
        <div class="page form">
		<div class="pagination-right" id="hiddenbtn" style="display: ">
            <button type="submit" id="acceptLab" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit;" class="btn btn-warning"> Back </button>
	    </div>
            <div class="moduletitle">
                <div class="moduletitleupper">Take Specimen for<span class="pull-right"> 
                     </span>
					 <br />
					 Name: <?php echo $names; ?>
					 
					 <br />
					 Patient Number: <?php echo $indexnum; ?>
					 <br />
					 Test: <?php echo $test; ?>
                </div>
            </div>
			<?php $engine->msgBox($msg,$status); ?>
            <div class="form-group">
			<div class="col-sm-2 required">
                    <label for="othername">Request Number</label>
                    <input type="text" class="form-control" id="" name="keys" value="<?php echo $keys; ?>" readonly>
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
            
                    
                </div>
            </div>

        </div>
    </div>

    

</div>

