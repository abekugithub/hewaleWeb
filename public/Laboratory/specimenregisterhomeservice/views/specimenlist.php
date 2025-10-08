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
		<input type="hidden" class="form-control" id="" name="vkeys" value="<?php echo $vkeys; ?>" readonly>
		
		<input type="hidden" class="form-control" id="" name="specimen" value="<?php echo $specimen; ?>" readonly>
		<input type="hidden" class="form-control" id="" name="slabel" value="<?php echo $slabel; ?>" readonly>
		<input type="hidden" class="form-control" id="" name="vol" value="<?php echo $vol; ?>" readonly>


	 <input type="hidden" class="form-control" id="visitcode" name="visitcode" value="<?php echo $visitcode; ?>" readonly>
		<input type="hidden" class="form-control" id="patientnum" name="patientnum" value="<?php echo $patientnum; ?>" readonly>
		<input type="hidden" class="form-control" id="patient" name="patient" value="<?php echo $patient; ?>" readonly>
		<input type="hidden" class="form-control" id="keys" name="keys" value="<?php echo $keys; ?>" readonly>
	<input type="hidden" class="form-control" id="vkeys" name="vkeys" value="<?php echo $vkeys; ?>" readonly>
    	   <input type="hidden" class="form-control" id="test" name="test" value="<?php echo $test; ?>" readonly>


	
		
        

        <!-- <div class="page-lable lblcolor-page">Table</div>-->
        <div class="page form">
		
            <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper">Specimen for </div> 
                
                <div class="form-group" style="padding-bottom:10px;">
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
				
            </div>
			
			
			

            <div class="pagination-tab">
            <?php $engine->msgBox($msg,$status); ?>
                <div class="table-title">
                    <div class="col-sm-3">
                        <div id="pager">
                            <?php echo $paging->renderFirst('<span class="fa fa-angle-double-left"></span>');?>
                            <?php echo $paging->renderPrev('<span class="fa fa-arrow-circle-left"></span>','<span class="fa fa-arrow-circle-left"></span>');?>
                            <input name="page" type="text" class="pagedisplay short" value="<?php echo $paging->renderNavNum();?>" readonly />
                            <?php echo $paging->renderNext('<span class="fa fa-arrow-circle-right"></span>','<span class="fa fa-arrow-circle-right"></span>');?>
                            <?php echo $paging->renderLast('<span class="fa fa-angle-double-right"></span>');?>
                            <?php $paging->limitList($limit,"myform");?>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="input-group">
                            <input type="text" tabindex="1" value="<?php echo $fdsearch; ?>" class="form-control square-input" name="fdsearch" placeholder="patient number, patient name"/>
                            <span class="input-group-btn">
                                <button type="submit" onclick="document.getElementById('action_search').value='search';document.getElementById('viewpage').value='';document.myform.submit;" class="btn btn-default btn-gyn-search"> <i class="fa fa-search"></i> </button>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group">
                            <button type="submit" onclick="document.getElementById('action_search').value='';document.getElementById('view').value='';
                        	        document.getElementById('viewpage').value='reset';document.myform.submit;" class="btn btn-success btn-square"> <i class="fa fa-refresh"></i> </button>
                        </div>
                    </div>
                   
						  <div class="pagination-right" id="hiddenbtn" style="display: ">
						  
						  <button type="submit" id="acceptLab" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit;" class="btn btn-dark"><i class="fa fa-arrow-left"></i> Back </button>
                 
                                       </div>
                </div>
            </div>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
						<th>Date</th>
                        <th>Test</th>
                        <th>Remarks.</th>
						<th>Discipline</th>
                        <th>Specimen</th>
                        <th>Label</th>
						<th>Volume</th>
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
						<td>'.$sql->UserDate($obj->LT_DATE,'d/m/Y').'</td>
                        <td>'.$obj->LT_TESTNAME.'</td>
                        <td>'.$obj->LT_RMK.'</td>
						<td>'.$obj->LT_DISCPLINENAME.'</td>
						<td>'.$obj->LT_SPECIMEN.'</td>
						<td>'.$obj->LT_SPECIMENLABEL.'</td>
						<td>'.$obj->LT_SPECIMENVOLUME.'</td>
						<td> <button type="button"  data-toggle="modal" data-target="#myModal_'.$i.'" class="btn btn-info" >Take Specimen</button></td>
                    
											 

						<td>
						
							<button type="submit" class="btn btn-info btn-square" onclick="document.getElementById(\'view\').value=\'add\';document.getElementById(\'vkeys\').value=\''.$obj->LT_CODE.'\';document.getElementById(\'viewpage\').value=\'add\';document.myform.submit;">Take Specimen</button>
						
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


