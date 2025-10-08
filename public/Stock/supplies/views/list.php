<?php $rs = $paging->paginate();?>
<div class="main-content">

    <div class="page-wrapper">

        <div class="page form">
            <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper">Manage Supplies</div>
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
                    
                    <div class="pagination-right">
                            
                            
                             <button type="submit"  onclick="document.getElementById('view').value = 'add';document.getElementById('viewpage').value = 'getsuppcode'; document.myform.submit();"  class="btn btn-info">
                                    <i class="fa fa-plus-circle"></i> Add Supplies</button>
                        </div>
                   
                </div>
            </div>
             <?php $engine->msgBox($msg,$status); ?>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="50px">#</th>
                        <th width="210px">Suppliers</th>
                        <th width="160px">Date</th>
                        <th width="160px">Waybill</th>
                        <th width="130px">Total Stock</th>
                        <th width="100px">Action</th>
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
						   
						   //get total stock
						   $totalstock = $engine->getTotalSupplystock($obj->SUP_CODE);
                    
                   echo '<tr>
                        <td>'.$num.'</td>
                        <td>'.$obj->SUP_SUPPLIERNAME.'</td>
                        <td>'.date("d/m/Y", strtotime($obj->SUP_DATE)).'</td>
						<td>'.$obj->SUP_WAYBILL.'</td>
                        <td>'.$totalstock.'</td>
						<td> 
						<div class="btn-group">
 <button type="submit"  onclick="document.getElementById(\'view\').value = \'editsupply\';document.getElementById(\'viewpage\').value = \'fetchstock\';document.getElementById(\'suppcode\').value=\''.$obj->SUP_CODE.'\'; document.myform.submit();"  class="btn btn-info">Manage Supply</button>
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
<input type="hidden" name="suppcode" id="suppcode" value="" >