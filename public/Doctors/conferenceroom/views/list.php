<?php $rs = $paging->paginate();?>

<div class="main-content">

    <div class="page-wrapper">

        <!-- <div class="page-lable lblcolor-page">Table</div>-->
        <div class="page form">
            <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper">Conference Room
                
                <span class="pull-right btnnumqueue">
                
                    <button type="button" title="Start a conference" id="" onclick="document.getElementById('viewpage').value='';document.getElementById('view').value='setupconference';document.myform.submit();" class="btn btn-info">Start Conference</button>
                 
                </span>

                </div>
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
                                <button type="submit" onclick="document.getElementById('action_search').value='search';document.getElementById('viewpage').value='';document.myform.submit;" class="btn btn-default btn-gyn-search"> <i class="fa fa-search"></i> </button>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group">
                            <button type="submit" onclick="document.getElementById('action_search').value='';document.getElementById('s').value='';
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
                <tr >
                    <th>#</th>
                    <th>Conference Name</th>
                    <th>No. of Part.</th>
                    <th>Start Date</th>
                    <th>Start Time</th>
                    <th>Author</th>
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
                      // $sql->debug= true;
                        $actorname= $engine->getUSerDetils($obj->CONF_ACTOR);
                       if($obj->CONF_ACTOR !== $actor_id){
                           $styl = 'style="border:2pt solid red;"';
                       }
                        echo  '<tr '.$styl.'>
                        <td >'.$num.'</td>
                        <td>'.$obj->CONF_NAME.'</td>
                        <td>'.$obj->MEMBERS.'</td>
                        <td>'.$obj->CONF_DATE.'</td>
                        <td>'.$obj->CONF_TIME.'</td>
                        <td>'.$obj->CONF_ACTOR.'</td>
						<td> 
						
						<div class="btn-group">
                                <button type="button" class="btn btn-info btn-square" dropdown-toggle" data-toggle="dropdown">Options <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><button type="submit" data-toggle="modal" data-target="#addDesp" onclick="document.getElementById(\'view\').value=\'conferenceview\';document.getElementById(\'keys\').value=\''.$obj->CONF_CODE.'\';document.getElementById(\'viewpage\').value=\'confdetails\';document.myform.submit;">Conference Room</button></li>
                                   '.(($obj->CONF_ACTOR !== $actor_id )? " " : '
                                   
                                   <li><button type="submit" data-toggle="modal" data-target="#addDesp" onclick="document.getElementById(\'view\').value=\'editcon\';document.getElementById(\'keys\').value=\''.$obj->CONF_CODE.'\';document.getElementById(\'viewpage\').value=\'fetchcondeatils\';document.myform.submit;"> Edit</button></li>
                                
                                   ').'                           
<li><button type="submit" data-toggle="modal" data-target="#addDesp" onclick="document.getElementById(\'view\').value=\'excuseduty\';document.getElementById(\'keys\').value=\''.$obj->CONF_CODE.'\';document.getElementById(\'viewpage\').value=\'listparts\';document.myform.submit;">Participants List</button></li>								
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