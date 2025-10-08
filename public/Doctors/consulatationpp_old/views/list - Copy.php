<?php
$rs = $paging->paginate();
?>
    <style>
        .rowdanger {
            background-color: #97181B4D
        }

        .rowwarning {
            background-color: #EBECB9
        }
    </style>
    <div class="main-content">

        <div class="page-wrapper">


            <?php //$engine->msgBox($msg,$status); ?>

            <!-- <div class="page-lable lblcolor-page">Table</div>-->
            <div class="page form">
                <div class="moduletitle" style="margin-bottom:0px;">
                    <div class="moduletitleupper">Consulation List</div>
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
                                <input type="text" tabindex="1" value="<?php echo $fdsearch; ?>" class="form-control square-input" name="fdsearch" placeholder="Enter Category to Search"
                                />
                                <span class="input-group-btn">
                                            <button type="submit" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='searchitem';document.myform.submit;" class="btn btn-default btn-gyn-search"> <i class="fa fa-search"></i> </button>
                                        </span>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <button type="submit" onclick="document.getElementById('view').value='';
                        	        document.getElementById('viewpage').value='reset';document.myform.submit;" class="btn btn-success btn-square"> <i class="fa fa-refresh"></i> </button>
                            </div>
                        </div>
                        <div class="pagination-right">

                        </div>
                    </div>
                </div>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Request Date</th>
                            <th>Patient Name</th>
                            <th>Patient Number</th>
                            <th>Schedule Date</th>
                            <th>Schedule Time</th>
                            <th>Status</th>
                            <th width="170">Action</th>
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
						   $consperiod = $patientCls->getConsultPeriod($obj->CONS_CODE);
						  
                   echo '<tr '.(($consperiod <= 1)?'class="rowdanger"':(($consperiod <= 2)?'class="rowwarning"':'')).'>
                        <td>'.$num++.'</td>
                        <td>'.date("d/m/Y",strtotime($obj->CONS_REQUCONFIRMDATE)).'</td>
                        <td>'.$obj->CONS_PATIENTNAME.'</td>
                        <td>'.$obj->CONS_PATIENTNUM.'</td>
						<td>'.date("d/m/Y",strtotime($obj->CONS_SCHEDULEDATE)).'</td>
                        <td>'.$obj->CONS_SCHEDULETIME.'</td>
						<td>'.(($obj->CONS_STATUS == 1)?'Pending':(($obj->CONS_STATUS == 2)?'Rescheduled':'')).'</td>
						<td><div class="btn-group">
                                <button type="button" class="btn btn-info btn-square" dropdown-toggle" data-toggle="dropdown">Options <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><button type="submit" class="startchat" onclick="fetchComplains(\''.$obj->CONS_PATIENTNUM.'\',\''.$obj->CONS_VISITCODE.'\');document.getElementById(\'keys\').value=\''.$obj->CONS_CODE.'\';document.getElementById(\'viewpage\').value=\'consult\';document.getElementById(\'view\').value=\'consulting\';document.myform.submit;">Consulting Room</button></li>
									<li><button>Reschedule</button></li>
                                    <li><button type="submit" onclick="document.getElementById(\'keys\').value=\''.$obj->CONS_PATIENTNUM.'\';document.getElementById(\'viewpage\').value=\'history\';document.getElementById(\'view\').value=\'history\';document.myform.submit;">Medical History</button></li>
                                </ul>
                            </div>
                        </td>
                    </tr>';
					}}
					?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>


    <!-- Modal -->
    <div id="addDesp" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Despensary</h4>
                </div>
                <div class="modal-body">
                    <p>Some text in the modal.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-square" data-dismiss="modal">Save</button>
                    <button type="button" class="btn btn-info btn-square" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>