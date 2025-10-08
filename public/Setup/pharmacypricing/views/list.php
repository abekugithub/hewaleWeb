<?php
$rs = $paging->paginate();
?>
<div class="main-content">
    <div class="page-wrapper">
        <?php $engine->msgBox($msg,$status); ?>
        <div class="page form">
            <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper">Pharmacy Pricing</div>
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
                            <input type="text" tabindex="1" value="<?php echo $fdsearch; ?>" class="form-control square-input" name="fdsearch" placeholder="Enter to Search"
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
                        <button type="submit" onclick="document.getElementById('view').value='add';document.getElementById('viewpage').value='';document.myform.submit;" class="btn btn-info"><i class="fa fa-plus-circle"></i> Add  </button>
                        <!--<button type="submit" onclick="document.getElementById('view').value='upload';document.myform.submit;" class="btn btn-primary"><i class="fa fa-upload"></i> Upload Setup  </button>-->

                    </div>
                </div>
            </div>




            <table class="table table-hover">
                <thead>
                <tr>
                    <th>#</th>

                    <th>Service</th>
                    <th>Method</th>
                    <th>Price</th>
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
                       
                        <td>'.$obj->PS_ITEMNAME.'</td>
						<td>'.$obj->PS_PAYSCHEMENAME.'</td>
                        <td>'.$obj->PS_PRICE.'</td>
                       	<td> 
						
						<div class="btn-group">
                                <button type="button" class="btn btn-info btn-square" dropdown-toggle" data-toggle="dropdown">Options <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><button type="submit" onclick="document.getElementById(\'view\').value=\'add\';document.getElementById(\'keys\').value=\''.$obj->PS_CODE.'\';document.getElementById(\'viewpage\').value=\'edit\';document.myform.submit;">Edit</button></li>
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