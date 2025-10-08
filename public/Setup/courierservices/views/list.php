<?php
$rs = $paging->paginate();
?>

    <div class="main-content">

        <div class="page-wrapper">

            <!-- <div class="page-lable lblcolor-page">Table</div>-->
            <div class="page form">
                <div class="moduletitle" style="margin-bottom:0px;">
                    <div class="moduletitleupper">Courier Services</div>
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
                                <input type="text" tabindex="1" value="<?php echo $fdsearch; ?>" class="form-control square-input" name="fdsearch" placeholder="Enter Name to Search"
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
                            <button type="submit" onclick="document.getElementById('view').value='add';document.getElementById('viewpage').value='add';document.myform.submit;" class="btn btn-info"><i class="fa fa-plus-circle"></i> Add </button>
                            
                            
                        </div>
                    </div>
                </div>

                <?php $engine->msgBox($msg,$status); ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Courier Service</th>
                            <th>Contact No</th>
                            <th>Location</th>
                           
                           
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
						<td>'.$obj->FACI_NAME.'</td>
						<td>'.$obj->FACI_PHONENUM.'</td>
						<td>'.$obj->FACI_LOCATION.'</td>
                        
						<td> 
						
						<button class="btn btn-danger" type="button" onClick="if (confirm(\'Are you sure you want to  delete?\')){document.getElementById(\'view\').value=\'\';document.getElementById(\'viewpage\').value=\'remove\';document.getElementById(\'keys\').value=\''.$obj->CS_CODE.'\';document.myform.submit()}"><span class="fa fa-close"></span> Remove</button>
							
						</td>
                    </tr>';
					$num ++; }}
					?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>