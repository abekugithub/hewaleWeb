<?php $rs = $paging->paginate(); ?>
<div class="main-content">
    <div class="page-wrapper">
        <form action="" method="post" id="myform" name="myform" enctype="multipart/form-data">
            <input type="hidden" id="keys" name="keys" value="<?php echo $keys; ?>" />
            <input type="hidden" id="target" name="target" value="<?php echo $target; ?>" />
        <div class="page form">
            <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper">X-ray Setup</div>
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
                            <input type="text" tabindex="1" value="<?php echo $fdsearch; ?>" class="form-control square-input" name="fdsearch" placeholder="Search..." />
                            <span class="input-group-btn">
                                <button type="submit" onclick="document.getElementById('action_search').value='search';document.getElementById('viewpage').value='';document.myform.submit;" class="btn btn-default btn-gyn-search"> <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group">
                            <button type="submit" onclick="document.getElementById('action_search').value='';document.getElementById('view').value='';document.getElementById('viewpage').value='reset';document.myform.submit;" class="btn btn-success btn-square"> <i class="fa fa-refresh"></i> </button>
                        </div>
                    </div>
                    <div class="pagination-right">
                        <button type="submit" onclick="document.getElementById('view').value='add';document.getElementById('viewpage').value='';document.getElementById('target').value='';document.myform.submit();" class="btn btn-info"><i class="fa fa-plus-circle"></i> Add  </button>
                    </div>
                </div>
            </div>
            <?php $engine->msgBox($msg,$status); ?>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Test</th>
                    <th>Price(GHS)</th>
                    <th>Date</th>
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
                       
                        <td>'.$obj->XP_TESTNAME.'</td>
						<td>'.$obj->XP_PRICE.'</td>
                        <td>'.$sql->UserDate($obj->XP_DATE,'d/m/Y').'</td>
                       	<td> 
						
						<div class="btn-group">
                                <button type="button" class="btn btn-info btn-square" dropdown-toggle" data-toggle="dropdown">Options <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><button type="submit" onclick="document.getElementById(\'view\').value=\'add\';document.getElementById(\'target\').value=\''.$obj->XP_CODE.'\';document.getElementById(\'viewpage\').value=\'edit\';document.myform.submit();">Edit</button></li>
                                    <li><button type="submit" onclick="if (confirm(\'Are you sure you want to delete this test price?\')){document.getElementById(\'view\').value=\'\';document.getElementById(\'target\').value=\''.$obj->XP_CODE.'\';document.getElementById(\'viewpage\').value=\'delete\';document.myform.submit();}">Delete</button></li>
                                </ul>
                            </div>
							
						</td>
                    </tr>';
                        $num ++;
                    }
                }else{
                    echo "<tr><td>No Record Found!</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>

    </div>

</div>