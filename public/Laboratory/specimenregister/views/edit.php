<div class="main-content">
    <div class="page-wrapper">

    <!-- <div class="page-lable lblcolor-page">Table</div>-->
        <div class="page form">
		
		<div class="pagination-right" id="hiddenbtn" style="display: ">
            <button type="submit" id="acceptLab" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit;" class="btn btn-dark"><i class="fa fa-arrow-left"></i> Back </button>
	    </div>
            <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper">Accepted Lab Request</div> 
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
                            <button type="submit" onclick="document.getElementById('action_search').value='';document.getElementById('view').value='';
                        	        document.getElementById('viewpage').value='reset';document.myform.submit;" class="btn btn-success btn-square"> <i class="fa fa-refresh"></i> </button>
                        </div>
                    </div>
                   
						 
                </div>
            </div>




            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
						<th>Lab Number</th>
						<th>Date</th>
                        <th>Patient Name</th>
                        <th>Patient No.</th>
                        <th>Lab. Test</th>
                        <th>Lab. Discipline</th>
                        <th>Remark</th>
						
                    </tr>
                </thead>
                <tbody>
                   <?php
			 if($stmtlist->RecordCount()>0){	
				$num = 1;
				while($obj = $stmtlist->FetchNextObject()){
					echo '
						<td>'.$num++.'</td>
						<td>'.$obj->LT_CODE.'</td>
						<td>'.$sql->UserDate($obj->LT_INPUTEDDATE,'d/m/Y').'</td>
                        <td>'.$obj->LT_PATIENTNAME.'</td>
                        <td>'.$obj->LT_PATIENTNUM.'</td>
                        <td>'.$obj->LT_TESTNAME.'</td>
                        <td>'.$obj->LT_DISCPLINENAME.'</td>
						<td>'.$obj->LT_RMK.'</td>
						<td><button type="submit" class="btn btn-info btn-square" onclick="document.getElementById(\'view\').value=\'add\';document.getElementById(\'keys\').value=\''.$obj->LT_CODE.'\';document.getElementById(\'viewpage\').value=\'add\';document.myform.submit;">Take Specimen</button></td>					 
						
					</tr>';
				 }
			}
              ?>
                </tbody>
            </table>
        </div>
	
						
    </div>

</div>

