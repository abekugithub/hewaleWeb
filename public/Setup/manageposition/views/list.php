<?php
$rs = $paging->paginate();
?>

    <div class="main-content">

        <div class="page-wrapper">

            <!-- <div class="page-lable lblcolor-page">Table</div>-->
            <div class="page form">
                <div class="moduletitle" style="margin-bottom:0px;">
                    <div class="moduletitleupper">Manage Users Roles &amp; Positions</div>
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
                                <input type="text" tabindex="1" value="<?php echo $fdsearch; ?>" class="form-control square-input" name="fdsearch" placeholder="Enter Category to Search"
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
                            <button type="submit" onclick="document.getElementById('view').value='addposition';document.getElementById('viewpage').value='';document.myform.submit;" class="btn btn-info"><i class="fa fa-plus-circle"></i> Add Position </button>
                            
                            
                        </div>
                    </div>
                </div>

                <?php $engine->msgBox($msg,$status); ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Role</th>
                            <th>Description</th>
                            <th>Level</th>
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
                        <td>'.$obj->FACPOS_NAME.'</td>
                        <td>'.$obj->FACPOS_DESCRIPTION.'</td>
                        <td>'.$obj->FACLV_USRLEVEL.'</td>
						<td>'.(($obj->FACPOS_STATUS == 1)?'Active':'Disable').'</td>
						<td> 
						
						<div class="btn-group">
                                <button type="button" class="btn btn-info btn-square" dropdown-toggle" data-toggle="dropdown">Options <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><button type="submit" onclick="document.getElementById(\'view\').value=\'addposition\';document.getElementById(\'keys\').value=\''.$obj->FACPOS_ID.'\';document.getElementById(\'viewpage\').value=\'editrole\';document.myform.submit;">Edit Role</button></li>
                                    <li><button type="submit" onclick="if(confirm(\'You are about to delete this user.\n\n Note: This process cannot be reversed.\n \n Are you sure ?.\')){document.getElementById(\'view\').value=\'\';document.getElementById(\'keys\').value=\''.$obj->FACPOS_ID.'\';document.getElementById(\'viewpage\').value=\'deleterole\';document.myform.submit;}else{return false ; }">Delete Role</button></li>
                                </ul>
                            </div>
							
						</td>
                    </tr>';
										$num ++; }}
					?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>