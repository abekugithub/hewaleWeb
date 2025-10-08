<?php
$rs = $paging->paginate();
?>

    <div class="main-content">

        <div class="page-wrapper">


            <?php $engine->msgBox($msg,$status); ?>

            <!-- <div class="page-lable lblcolor-page">Table</div>-->
            <div class="page form">
                <div class="moduletitle" style="margin-bottom:0px;">
                    <div class="moduletitleupper">Manage Services</div>
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
                                <input type="text" tabindex="1" value="<?php echo $fdsearch; ?>" class="form-control square-input" name="fdsearch" placeholder="Enter Service to Search"
                                />
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
                        <div class="pagination-right">
                            <button type="submit" onclick="document.getElementById('view').value='add';document.getElementById('viewpage').value='';document.myform.submit;" class="btn btn-info"><i class="fa fa-plus-circle"></i> Add Service </button>
                            
                            
                        </div>
                    </div>
                </div>


                

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Service</th>
                            <th>Description</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th>Action</th>
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
                    
                   echo '<tr>
                        <td>'.$num.'</td>
                        <td>'.$engine->getServiceDetails($obj->HOSPSERV_SERVCODE)->SERV_NAME.'</td>
                        <td>'.$obj->FACPOS_DESCRIPTION.'</td>
                        <td>'.$obj->FACLV_USRLEVEL.'</td>
						<td>'.(($obj->HOSPSERV_STATUS == 1)?'Active':'Disable').'</td>
						<td> 					
						<button type="submit" class="btn btn-success" onclick="document.getElementById(\'view\').value=\'add\';document.getElementById(\'keys\').value=\''.$obj->HOSPSERV_ID.'\';document.getElementById(\'viewpage\').value=\'editservice\';document.myform.submit();"><i class="fa fa-pencil"></i> Edit Service</button>
						<button type="submit" class="btn btn-danger" onclick="(confirm(\'Are you sure you want to delete this service?\')?document.getElementById(\'view\').value=\'\';document.getElementById(\'keys\').value=\''.$obj->HOSPSERV_ID.'\';document.getElementById(\'viewpage\').value=\'deleteservice\';document.myform.submit();:\'\';)"><i class="fa fa-trash-o"></i> Delete Service</button>
						</td>
                    </tr>';
										$num ++; }
                  }else{
                      echo "<tr><td>No Record Found!</td></tr>";
                  }
					?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>