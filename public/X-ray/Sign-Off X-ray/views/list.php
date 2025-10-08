<?php $rs = $paging->paginate();?>
<div class="main-content">
    <div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper">Pending X-Ray Result Sign off</div>
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

                </div>
            </div>

            <?php $engine->msgBox($msg,$status); ?>

            <table class="table table-hover">
                <thead>
                <tr>
                    <th width="20px">#</th>
                    <th width="100px">Date</th>
                    <th width="100px">Hewale No.</th>
                    <th width="150px">Patient Name</th>
                    <th width="170px">X-Ray Test</th>
                    <th width="200px">Action</th>
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
						
							</div>
						<td>'.$num.'</td>
						<td>'.$sql->UserDate($obj->XT_INPUTEDDATE,'d/m/Y').'</td>
                        <td>'.$obj->XT_PATIENTNUM.'</td>
                        <td>'.$obj->XT_PATIENTNAME.'</td>
                        <td>'.$encaes->decrypt($obj->XT_TESTNAME).'</td>
						<td>
						<a href="media/uploaded/labresult/'.$obj->LT_LABRESULT.'"  class="btn btn-info btn-square">Download Result
						<i class="fa fa-download"></i></a>
						
						<button type="submit" class="btn btn-info btn-square" onclick="document.getElementById(\'viewpage\').value=\'patientdetails\';document.getElementById(\'view\').value=\'scanview\';document.getElementById(\'keys\').value=\''.$obj->XT_CODE.'\';document.myform.submit;"> View </button>
						
						<button type="submit" class="btn btn-primary btn-square" onclick="if (confirm(\'Are you sure you want to  Sign off this test?\')){document.getElementById(\'keys\').value=\''.$obj->XT_CODE.'\';document.getElementById(\'viewpage\').value=\'signoff\';document.myform.submit;}">Sign off</button>
						</td>
						
						
					
					</tr>';
                        $num ++;


                        ?>
                        <div id="myModal_<?php echo $i++ ; ?>" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-lg">


                            </div>
                        </div>


                        <?php $i++;	}}
                ?>
                </tbody>
            </table>
        </div>


    </div>

</div>

