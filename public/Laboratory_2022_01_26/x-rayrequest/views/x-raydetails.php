<?php $rs = $paging->paginate();?>
<div class="main-content">
    <div class="page-wrapper">

	 <input type="hidden" class="form-control" id="" name="visitcode" value="<?php echo $visitcode; ?>" readonly>
		<input type="hidden" class="form-control" id="" name="patientnum" value="<?php echo $patientnum; ?>" readonly>
		<input type="hidden" class="form-control" id="" name="patient" value="<?php echo $patient; ?>" readonly>
		<input type="hidden" class="form-control" id="" name="keys" value="<?php echo $keys; ?>" readonly>
		<input type="hidden" class="form-control" id="" name="vkeys" value="<?php echo $vkeys; ?>" readonly>
		
		<input type="hidden" class="form-control" id="" name="specimen" value="<?php echo $specimen; ?>" readonly>
		<input type="hidden" class="form-control" id="" name="slabel" value="<?php echo $slabel; ?>" readonly>
		<input type="hidden" class="form-control" id="" name="vol" value="<?php echo $vol; ?>" readonly>


	 <input type="hidden" class="form-control" id="visitcode" name="visitcode" value="<?php echo $visitcode; ?>" readonly>
		<input type="hidden" class="form-control" id="patientnum" name="patientnum" value="<?php echo $patientnum; ?>" readonly>
		<input type="hidden" class="form-control" id="patient" name="patient" value="<?php echo $patient; ?>" readonly>
		<input type="hidden" class="form-control" id="keys" name="keys" value="<?php echo $keys; ?>" readonly>
	<input type="hidden" class="form-control" id="vkey" name="vkey" value="<?php echo $vkey; ?>" readonly>
    	   <input type="hidden" class="form-control" id="test" name="test" value="<?php echo $test; ?>" readonly>

        <div class="page form">
		
            <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper">X-ray Request </div>
                
                <div class="form-group" style="padding-bottom:10px;">
                <div class="col-sm-4 required">
                    <label class="control-label" for="fname">Patient Name</label>
                    <?php  echo $patient; ?>
                </div>
                <div class="col-sm-4 required">
                    <label for="othername">Hewale Number</label>
                    <?php  echo $patientnum; ?>
                </div>
               <div class="pagination-right" id="hiddenbtn" style="padding-bottom:50px;">
                   <button type="submit" id="acceptLab" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit;" class="btn btn-dark"><i class="fa fa-arrow-left"></i> Back </button>
               </div>
            </div>
				
            </div>
			
			<?php $engine->msgBox($msg,$status); ?>
			

            

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
						<th>Date</th>
                        <th>Test</th>
                        <th>Remarks.</th>
						<th>Discipline</th>
						<th>Action</th>
                       
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $num = 1;
					$i =  1;
                    if($stmtlist->Recordcount() > 0 ){
					while ($obj = $stmtlist->FetchNextObject()){
                    
                   echo '<tr>
						
						<td>'.$num.'</td>
						<td>'.$sql->UserDate($obj->XT_DATE,'d/m/Y').'</td>
                        <td>'.$encaes->decrypt($obj->XT_TESTNAME).'</td>
                        <td>'.$encaes->decrypt($obj->XT_RMK).'</td>
						<td>'.$obj->XT_DISCPLINENAME.'</td>										
						<td>					
							<button type="submit" class="btn btn-info btn-square" onclick="document.getElementById(\'view\').value=\'takespacimen\';document.getElementById(\'vkey\').value=\''.$obj->XT_CODE.'\';document.getElementById(\'viewpage\').value=\'takespacimen\';document.myform.submit();">Upload Result</button>
						</td>					 				
					</tr>';
					$num ++;
					?>
	<div id="myModal_<?php echo $i++ ; ?>" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Specimen</h4>
            </div>
			<?php $engine->msgBox($msg,$status); ?>
            <div class="modal-body">
			<div class="form-group">
                <p>
                    <div class="tabs">
					<div class="controls controls-row">
                        <div class="col-sm-12 tabs-col">
						<input type="hidden" class="form-control" id=""  value= "<?php echo $obj->LT_CODE ; ?>" name="cd['.$obj->LT_CODE.']" >
						<div class="col-sm-3">
                        <label>Patient:</label><br />
                        <?php echo $obj->LT_PATIENTNAME ?>
					</div>
					<div class="col-sm-3">
                        <label>Number:</label><br />
                        <?php echo $obj->LT_PATIENTNUM ?>
                    </div>
					<div class="col-sm-3">
                        <label>Test:</label><br/>
                        <?php echo $obj->LT_TESTNAME ?>
                    </div>
					<div class="col-sm-3">
                        <label>Discipline:</label><br/>
                        <?php echo $obj->LT_DISCPLINENAME ?>
                    </div>
                          
                        </div>
                     
                    </div>
					
					<div class="controls controls-row">
                    <div class="col-sm-12 tabs-col">
					<div class="form-group">
					<div class="col-sm-3">
                        <label>Date:</label><br />
						
                        <input type="text" class="form-control" id="date" name="startdate" value ="<?php echo $startdate; ?>" placeholder="dd/mm/yyyy"  >			
					</div>
					<div class="col-sm-3">
                        <label>Specimen:</label><br />
                         <div class="controls">
			<select name="specimen_<?php echo $i ; ?>" id="specimen" class="form-control" tabindex="2"><option value="<?php echo $specimen; ?>"> -- Select Specimen --</option>
				<?php foreach($spec as $rows){  ?>
				<option value="<?php echo $rows->SP_CODE.'@@@'.$rows->SP_NAME ;?>" <?php echo (($rows->SP_CODE == $specimen)?'selected':'' )?> ><?php echo $rows->SP_NAME ;?></option>
				<?php } ?> 

			</select>
              </div>
                    </div>
					<div class="col-sm-3">
                        <label>Label:</label><br/>
						
                        <input type="text" class="form-control" id="" name="slabel_<?php echo $i ; ?>" value="<?php echo $slabel; ?>" >
						
                    </div>
					<div class="col-sm-3">
                        <label>Volumen Taken:</label><br/>
                        <input type="text" class="form-control" id=""  name="vol_<?php echo $i ; ?>" value="<?php echo $vol; ?>" >
                    </div>
                          
                        </div>
                     
                    </div>
                </p>
            </div>
			
			 </div>
            <div class="modal-footer">
			
			<button type="button" class="btn btn-success btn-square" data-dismiss="modal" onclick="document.getElementById('viewpage').value='savespecimen';document.myform.submit();">Save</button>
            <button type="button" class="btn btn-info btn-square" data-dismiss="modal">Close</button>
			
			<!--
			 <button type="submit" data-dismiss="modal" onclick="document.getElementById('viewpage').value='';document.myform.submit;" class="btn btn-success"><i class="fa fa-plus-circle"></i> Save </button>
                   
                <button type="button" class="btn btn-success btn-square" data-dismiss="modal">Save</button>
				
				-->
                
            </div>
        </div>
		
	

    </div>
</div>
			
							
				<?php $i++;	}}
					?>
                </tbody>
            </table>
        </div>
	
						
    </div>

</div>


