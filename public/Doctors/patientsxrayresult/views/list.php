<?php $rs = $paging->paginate();?>

<div class="main-content">

    <div class="page-wrapper">

        <!-- <div class="page-lable lblcolor-page">Table</div>-->
        <div class="page form">
            <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper">Patients X-Ray Result</div>
            </div>
            
            <div class="pagination-tab">
                <div class="table-title">
                    <div class="col-sm-3">
                        <div id="pager">
                            <?php echo $paging->renderFirst('<span class="fa fa-angle-double-left"></span>');?>
                            <?php echo $paging->renderPrev('<span class=""></span>','<span class="fa fa-arrow-circle-left"></span>');?>
                            <input name="page" type="text" class="pagedisplay short" value="<?php echo $paging->renderNavNum();?>" readonly />
                            <?php echo $paging->renderNext('<span class="fa fa-arrow-circle-right"></span>','<span class="fa fa-arrow-circle-right"></span>');?>
                            <?php echo $paging->renderLast('<span class="fa fa-angle-double-right"></span>');?>
                            <?php $paging->limitList($limit,"myform");?>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="input-group">
                  
                        
                            <input type="text" tabindex="1" value="<?php echo $fdsearch; ?>" class="form-control square-input" name="fdsearch" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type="submit" onclick="document.getElementById('action_search').value='search';document.getElementById('viewpage').value='patientdetails';document.myform.submit();" class="btn btn-default btn-gyn-search"> <i class="fa fa-search"></i> </button>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group">
                            <button type="submit" onclick="document.getElementById('action_search').value='';document.getElementById('view').value='';
                        	        document.getElementById('viewpage').value='reset';document.myform.submit;" class="btn btn-success btn-square"> <i class="fa fa-refresh"></i> </button>
                        </div>
                    </div>
                    <div class="pagination-right">
                        <!-- Content goes here -->
                    </div>
                </div>
            </div>

            <?php $engine->msgBox($msg,$status); ?>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Patient No.</th>
                    <th width="200px">Patient Name</th>
                    <th >X-Ray Type</th>
                    <th>Processing Date</th>
                    <th width="250px">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $num = 1;
                if($paging->total_rows > 0 ){
                    $page = (empty($page))? 1:$page;
                    $num = (isset($page))? ($limit*($page-1))+1:1;
                    while(!$rs->EOF){
                        $obj = $rs->FetchNextObject();
				$stmt1 = $sql->Execute($sql->Prepare("SELECT CONS_CODE FROM hms_consultation  WHERE CONS_VISITCODE = " . $sql->Param('a') . " ORDER BY CONS_CODE DESC LIMIT 1 "), array($obj->LT_VISITCODE));
				$obj1=$stmt1->FetchNextObject();
				?>
                        <tr>
                        <td><?php echo $num ?></td>
                        <td><?php echo $obj->XTM_PATIENTNUM?></td>
                        <td><?php echo $obj->XTM_PATIENTNAME?></td>
                        <td><?php echo ($obj->XTM_TYPE == '1')?'XRAY':'ULTRASOUND'?></td>
						<td><?php echo (!empty($obj->XTM_SIGNOFFDATE)?date("d/m/Y",strtotime($obj->XTM_SIGNOFFDATE)):date("d/m/Y",strtotime($obj->XTM_DATE)))?></td>
						<td><?php echo (($obj->XTM_STATUS !="7")?'Pending':'<button id="view" name="view" class="btn btn-info" type="button" onclick="/*window.open(\'localhost/socialhealth/media/uploaded/\');*/document.getElementById(\'keys\').value=\''.$obj->XTM_VISITCODE.'\';document.getElementById(\'view\').value=\'details\';document.getElementById(\'viewpage\').value=\'details\';document.myform.submit();"> Details</button>').' '.(($usertype == 7 )?(($obj->XTM_STATUS !="7")?'':'<button class="btn btn-info" type="submit" onclick="CallSmallerWindow(\''.$linkview2.'\')">Consulting Room</button>'):(($obj->XTM_STATUS !="7")?'':'<button class="btn btn-info" type="submit" onclick="CallSmallerWindow(\''.$linkview.'\')">Consulting Room</button>')).'			
		</td>
                    </tr>';
                        $num ++; }}
						
                ?>
                </tbody>
            </table>
        </div>

		</td> 
    </div>

</div>
