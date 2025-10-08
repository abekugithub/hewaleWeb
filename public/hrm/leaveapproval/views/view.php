<div class="page-wrapper">
  <div class="page form">
    <div class="moduletitle">
      <div class="moduletitleupper">Approve Leave Request Form <span class="pull-right">
        <button class ="btn btn-dark" onclick="document.getElementById('view').value='';document.myform.submit;"><i class="fa fa-arrow-left"></i> Back</button>
        </span> </div>
    </div>
    <div class="col-sm-12 paddingclose">
      <div class="form-group">
        <div class="moduletitleupper"> </div>
        <div class="col-sm-12 personalinfo-info">
        
          <div class="form-group">
            <div class="col-sm-8 required">
              <label class="control-label" for="leavetype">Employee Name</label>
               
               <input type="text" class="form-control" id="leavetype" name="empname" value="<?php echo $empname;?>" readonly>
            </div>
            
            <div class="col-sm-4 required">
              <label class="control-label" for="leavetype">No Of Days</label>
               
               <input type="text" class="form-control" id="leavetype" name="noofdays" value="<?php echo $noofdays;?>" readonly>
            </div>
            
          </div>
          
          <div class="form-group">
            <div class="col-sm-4">
              <label class="control-label" for="leavetype">Leave Type</label>
              <input type="text" class="form-control" id="leavetype" name="leavetype" value="<?php echo $leavetype;?>" readonly>
             
            </div>
            <div class="col-sm-4 required">
              <label class="control-label" for="leavetype">Leave Start</label>
              <input type="text" class="form-control" id="leavetype" name="startdate" value="<?php echo $leavestart;?>" readonly>
            </div>
            <div class="col-sm-4 required">
              <label class="control-label" for="leavetype">Leave End</label>
              <input type="text" class="form-control" id="enddate" name="enddate" value="<?php echo $leaveend;?>" readonly>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-12">
              <label class="control-label" for="leavetype">Leave Reasons</label>
              <textarea  name="reason" readonly><?php echo $reason;?></textarea>
            </div>
          </div>
          
          
          
          <div class="btn-group pull-right">
            <div class="col-sm-12">
              <button type="submit" class="btn btn-success" onClick="document.getElementById('viewpage').value='approveleaverequest';document.myform.submit();"><i class="fa fa-save"></i> Approve</button>
              <button type="submit" class="btn btn-danger" onClick="document.getElementById('viewpage').value='delleaverequest';document.myform.submit();"><i class="fa fa-times"></i> Reject</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
