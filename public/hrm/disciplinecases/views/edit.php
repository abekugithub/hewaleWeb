<div class="page-wrapper">
  <div class="page form">
    <div class="moduletitle">
      <div class="moduletitleupper">Disciplinary Case - Response Form <span class="pull-right">
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
              <input name="empname"  class="form-control" id="leavetype" value="<?php echo $empname;?>" readonly>
                
            </div>
            
          </div>
          
          <div class="form-group">
            <div class="col-sm-6">
              <label class="control-label" for="casename">Case Name</label>
              <input name="casename" type="text" class="form-control" id="casename" readonly="readonly"  value="<?php echo $casename;?>">
            </div>
            
            
            <div class="col-sm-3">
            <?php if($casetype=='1') {
						$casetypename ="Written Query";
								
				}elseif ($casetype=='2') {
								$casetypename ="Suspension Notice";
				} ?>
              <label class="control-label" for="casetype">Case Type</label>
              <input name="types" type="text" class="form-control" id="types" readonly value="<?php echo $casetypename;?>">
            </div>
            
            
            <div class="col-sm-3 required">
              <label class="control-label" for="startdate">Response End Date</label>
              <input name="startdate" type="text" class="form-control" id="startdate" readonly value="<?php echo $caseend;?>">
            </div>
            
          </div>
          <div class="form-group">
            <div class="col-sm-12">
              <label class="control-label" for="description">Case Description</label>
              <textarea  name="description" readonly ><?php echo $description;?></textarea>
            </div>
          </div>
          <?php if($delievery == '1') {?>
          <div class="form-group">
            <div class="col-sm-12">
              <label class="control-label" for="reponse">Case Response</label>
              <textarea  name="response" ></textarea>
            </div>
            

            
          </div>
          <div class="form-group">
          <div class="col-sm-12">
              <label class="control-label" for="casetype">Case Status</label>
              <select name="casestatus" id="casestatus" value="" class="form-control ">
               <option value="0">Closed</option>
              </select>
            </div>
          </div>
          
          <div class="btn-group pull-right">
            <div class="col-sm-12">
            
            <button type="submit" class="btn btn-success" onClick="document.getElementById('viewpage').value='updatecase';document.myform.submit();"><i class="fa fa-save"></i> Update Case</button>
            
             
            </div>
          </div>
          
          <?php } else {?>
          
          <div class="form-group">
            <div class="col-sm-12">
              <label class="control-label" for="reponse">Case Response</label>
              <textarea  name="response" ><?php echo $response;?></textarea>
            </div>
            

            
          </div>
          <div class="form-group">
          <div class="col-sm-12">
          
          		<?php if($statusdel =='0') {
					$statuss="Closed";
				}
				?>
          
              <label class="control-label" for="casetype">Case Status</label>
             <input name="statuss" type="text" class="form-control" id="startdate" readonly value="<?php echo $statuss;?>">
            </div>
          </div>
          
          <?php } ?>
          
        </div>
      </div>
    </div>
  </div>
</div>
