<div class="page-wrapper">
  <div class="page form">
    <div class="moduletitle">
      <div class="moduletitleupper">Add Leave Request Form <span class="pull-right">
        <button class ="btn btn-dark" onclick="document.getElementById('view').value='';document.myform.submit();"><i class="fa fa-arrow-left"></i> Back</button>
        </span> </div>
    </div>
    <div class="col-sm-12 paddingclose">
      <div class="form-group">
        <div class="moduletitleupper"> </div>
        <div class="col-sm-12 personalinfo-info">
        
          <div class="form-group">
            <div class="col-sm-12 required">
              <label class="control-label" for="leavetype">Employee Name</label>
              <select name="empcode" id="empcode" class="form-control" onChange="document.getElementById('viewpage').value='load_empname';document.getElementById('view').value='add';document.myform.submit();">
                <option value="" disabled selected>Select Employee</option>
                <?php  while($obj = $stmtemployee->FetchNextObject()){ ?>
                <option value='<?php echo $obj->SM_CODE; ?>' <?php  echo (($obj->SM_CODE == $empcode)?"selected":""); ?>>
				<?php echo $obj->SM_SURNAME." ".$obj->SM_FNAME; ?></option>
                <?php } ?>
              </select>
               <input type="hidden" class="form-control" id="leavetype" name="empname" value="<?php echo $empname;?>">
            </div>
            
          </div>
          
          <div class="form-group">
            <div class="col-sm-4">
              <label class="control-label" for="leavetype">Leave Type</label>
              <select name="leavetype" id="leavetype" value="" class="form-control ">
                <option value="" disabled selected>Select Job</option>
                <?php  while($obj = $stmtleavetype->FetchNextObject()){ ?>
                <option value='<?php echo $obj->LT_CODE; ?>' <?php  echo (($obj->LT_CODE == $leavetype)?"selected":""); ?>>
				<?php echo $obj->LT_NAME; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-sm-4 required">
              <label class="control-label" for="leavetype">Leave Start</label>
              <input type="text" class="form-control" id="leavetype" name="startdate" >
            </div>
            <div class="col-sm-4 required">
              <label class="control-label" for="leavetype">Leave End</label>
              <input type="text" class="form-control" id="enddate" name="enddate" value="<?php echo $enddate;?>">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-12">
              <label class="control-label" for="leavetype">Leave Reasons</label>
              <textarea  name="reason" ></textarea>
            </div>
          </div>
          <div class="btn-group pull-right">
            <div class="col-sm-12">
              <button type="submit" class="btn btn-success" onClick="document.getElementById('viewpage').value='insertleaverequest';document.myform.submit();"><i class="fa fa-save"></i> Submit</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
