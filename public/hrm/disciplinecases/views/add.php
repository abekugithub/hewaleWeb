<div class="page-wrapper">
  <div class="page form">
    <div class="moduletitle">
      <div class="moduletitleupper">Disciplinary Case Form <span class="pull-right">
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
				<?php echo $obj->SM_FNAME." ".$obj->SM_SURNAME." (".$obj->SM_CODE.")"; ?></option>
                <?php } ?>
              </select>
                <input type="hidden" class="form-control" id="leavetype" name="empname" value="<?php echo $empname;?>">
            </div>
            
          </div>
          
          <div class="form-group">
            <div class="col-sm-6">
              <label class="control-label" for="casename">Case Name</label>
              <input type="text" class="form-control" id="casename" name="casename" >
            </div>
            
            
            <div class="col-sm-3">
              <label class="control-label" for="casetype">Case Type</label>
              <select name="casetype" id="casetype" value="" class="form-control ">
                <option value="" disabled selected>Select Type</option>
               <option value="1">Written Query</option>
               <option value="2">Suspension Notice</option>
              </select>
            </div>
            
            
            <div class="col-sm-3 required">
              <label class="control-label" for="startdate">Response End Date</label>
              <input type="text" class="form-control" id="startdate" name="startdate" >
            </div>
            
          </div>
          <div class="form-group">
            <div class="col-sm-12">
              <label class="control-label" for="description">Case Description</label>
              <textarea  name="description" ></textarea>
            </div>
          </div>
         
          <div class="btn-group pull-right">
            <div class="col-sm-12">
           
              <button type="submit" class="btn btn-success" onClick="document.getElementById('viewpage').value='insertcase';document.myform.submit();"><i class="fa fa-save"></i> Submit</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
