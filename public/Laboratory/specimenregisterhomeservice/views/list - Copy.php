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



<div class="main-content">
    <div class="page-wrapper">

        

        <!-- <div class="page-lable lblcolor-page">Table</div>-->
        <div class="page form">
            <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper">Specimen Register</div> 
            </div>
			
			<?php $engine->msgBox($msg,$status); ?>

            <div class="pagination-tab">
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
                            <input type="text" tabindex="1" value="<?php echo $fdsearch; ?>" class="form-control square-input" name="fdsearch" placeholder="Enter Category to Search"/>
                            <span class="input-group-btn">
                                <button type="submit" onclick="document.getElementById('action_search').value='search';document.getElementById('viewpage').value='';document.myform.submit;" class="btn btn-default btn-gyn-search"> <i class="fa fa-search"></i> </button>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group">
                            <button type="submit" onclick="document.getElementById('action_search').value='';document.getElementById('s').value='';
                        	        document.getElementById('viewpage').value='reset';document.myform.submit;" class="btn btn-success btn-square"> <i class="fa fa-refresh"></i> </button>
                        </div>
                    </div>
                    <div class="pagination-right" id="hiddenbtn" style="display: ">
                          </div>
                </div>
            </div>




            <table class="table table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <th>#</th>
                        <th>Patient Name</th>
                        <th>Patient No.</th>
                        <th>Lab. Test</th>
                        <th>Lab. Discipline</th>
                        <th>Specimen</th>
                        <th>Label</th>
                        <th>Date</th>
                        <th>Action</th>
						<th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $num = 1;
					$i =  1;
                    if($paging->total_rows > 0 ){
                           $page = (empty($page))? 1:$page;
                           $num = (isset($page))? ($limit*($page-1))+1:1;
                           while(!$rs->EOF){
                           $obj = $rs->FetchNextObject();
						   $usergroup = $engine->geAllUsersGroup($obj->USR_USERID);
						   
                    
                   echo '<tr>
							<div align="center">
						<td> <input type="checkbox" value="'.$obj->LT_CODE.'" name="syscheckbox['.$obj->LT_CODE.']" id="selcheck" > </td>
							</div>
						<td>'.$num.'</td>
                        <td>'.$obj->LT_PATIENTNAME.'</td>
                        <td>'.$obj->LT_PATIENTNUM.'</td>
                        <td>'.$obj->LT_TESTNAME.'</td>
                        <td>'.$obj->LT_DISCPLINENAME.'</td>
						<td>'.$obj->LT_SPECIMEN.'</td>
						<td>'.$obj->LT_SPECIMENLABEL.'</td>
						<td>'.$sql->UserDate($obj->LT_INPUTEDDATE,'d/m/Y').'</td>
						<td> 
						
						<div class="btn-group">
                                <button type="button" class="btn btn-info btn-square" dropdown-toggle" data-toggle="dropdown">Options <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><button type="submit" onclick="document.getElementById(\'s\').value=\'takespecimen\';document.getElementById(\'keys\').value=\''.$obj->LT_CODE.'\';document.getElementById(\'viewpage\').value=\'specimen\';document.myform.submit;">Take Specimen</button></li>
                               <li><button type="submit" onclick="document.getElementById(\'s\').value=\'edit\';document.getElementById(\'keys\').value=\''.$obj->PRESCORD_CODE.'\';document.getElementById(\'viewpage\').value=\'edit\';document.myform.submit;">View Prescription</button></li>
                                    
								</ul>
                        </div>
							
						</td>
						<td> <button type="button"  data-toggle="modal" data-target="#myModal_'.$i.'" class="btn btn-success" >Modal</button></td>
                    
					
					
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
						<input type="hidden" class="form-control" id="" name="cd" value= "<?php echo $obj->LT_CODE ; ?>" >
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
                        <label>Discpline:</label><br/>
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
			<select name="specimen" id="specimen" class="form-control" tabindex="2"><option value="<?php echo $specimen; ?>"> -- Select Specimen --</option>
				<?php foreach($spec as $rows){  ?>
				<option value="<?php echo $rows->SP_CODE.'@@@'.$rows->SP_NAME ;?>" <?php echo (($rows->SP_CODE == $specimen)?'selected':'' )?> ><?php echo $rows->SP_NAME ;?></option>
				<?php } ?> 

			</select>
              </div>
                    </div>
					<div class="col-sm-3">
                        <label>Label:</label><br/>
						
                        <input type="text" class="form-control" id="" name="slabel_<?php echo $i ; ?>" >
						
                    </div>
					<div class="col-sm-3">
                        <label>Volumen Taken:</label><br/>
                        <input type="text" class="form-control" id=""  name="vol_<?php echo $i ; ?>" >
                    </div>
                          
                        </div>
                     
                    </div>
                </p>
            </div>
			
			 </div>
            <div class="modal-footer">
			
			<button type="button" class="btn btn-success btn-square" data-dismiss="modal" onclick="document.getElementById('viewpage').value='savespecimen';document.myform.submit();">Save</button>
               <!--
			 <button type="submit" data-dismiss="modal" onclick="document.getElementById('viewpage').value='';document.myform.submit;" class="btn btn-success"><i class="fa fa-plus-circle"></i> Save </button>
                   
                <button type="button" class="btn btn-success btn-square" data-dismiss="modal">Save</button>
				
				-->
                <button type="button" class="btn btn-info btn-square" data-dismiss="modal">Close</button>
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

