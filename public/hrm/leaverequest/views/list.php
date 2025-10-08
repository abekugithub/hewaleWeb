<?php


$rs = $paging->paginate();
?>

    <div class="main-content">

        <div class="page-wrapper">


            

            <!-- <div class="page-lable lblcolor-page">Table</div>-->
            <div class="page form">
                <div class="moduletitle" style="margin-bottom:0px;">
                    <div class="moduletitleupper">Leave Request</div>
                </div>
<?php $engine->msgBox($msg,$status); ?>
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
                                <input type="text" tabindex="1" value="<?php echo $fdsearch; ?>" class="form-control square-input" name="fdsearch" placeholder="Enter Agent Name to Search"
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
                            
                            
                             <button type="submit"  onclick="document.getElementById('view').value = 'add'; document.myform.submit();"  class="btn btn-success">
                                    <i class="fa fa-plus-circle"></i> Request Leave</button>
                        </div>
                    </div>
                </div>


                

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Employee</th>
                            <th>Leave Type</th>
                            <th>Leave Range </th>
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
						   $newstart = $obj->LR_STARTDATE;
						    $newend = $obj->LR_ENDDATE;
						   
						   $delievery = $obj->LR_STATUS;
						   $delstatus = "";
						   
						   $agentdob = date("d/m/Y",strtotime($newstart));
						   $agentend = date("d/m/Y",strtotime($newend));
						   
						   if ($delievery == '1') {
							   $delstatus = 'Pending';
							   }elseif ($delievery == '0') {
								$delstatus = 'Rejected';
							   }elseif ($delievery == '2') {
								$delstatus = 'Approved';
							   }
                    
                   echo '<tr>
                        <td>'.$num++.'</td>
                        <td>'.$obj->LR_STAFF.'</td>
                        <td>'.$obj->LT_NAME.'</td>
                        <td>'.$agentdob." - ".$agentend.'</td>
						<td>'.$delstatus.'</td>';
							   
							   
					   if ($delstatus=='Pending') {
						   echo
					   
		'<td><button class="btn btn-info btn-square" type="button"  onClick="document.getElementById(\'view\').value=\'edit\';document.getElementById(\'viewpage\').value=\'edit\';document.getElementById(\'keys\').value=\''.$obj->LR_CODE.'\';document.myform.submit()"><span class="fa fa-pencil"></span> Edit</button> 
							
						</td>
                    </tr>' ;
					   } else
					   {
						   echo
					   
		'<td><button class="btn btn-info btn-square" type="button" disabled onClick="document.getElementById(\'view\').value=\'edit\';document.getElementById(\'viewpage\').value=\'edit\';document.getElementById(\'keys\').value=\''.$obj->LR_CODE.'\';document.myform.submit()"><span class="fa fa-pencil"></span> Edit</button> 
							
						</td>
                    </tr>' ;
						   
					   }
						   
					   }}
					?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>


    <!-- Modal -->
<div id="addDesp" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Agent</h4>
      </div>
      <div class="modal-body">
        <div class="col-sm-12">
                    <div class="form-group">
                
            </div>
            <div class="form-group">
                <div class="col-sm-5">
                    <label for="fname">First Name:</label>
                    <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $fname; ?>" >
                </div>
                
                <div class="col-sm-5">
                    <label for="lastname">Last Name:</label>
                    <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $lastname; ?>">
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-sm-5">
                    <label for="fname">First Name:</label>
                    <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $fname; ?>" disabled>
                </div>
                
                <div class="col-sm-5">
                    <label for="lastname">Last Name:</label>
                    <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $lastname; ?>" disabled>
                </div>
            </div>
            
            
            
            
            
            
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success btn-square" data-dismiss="modal">Save</button>
        <button type="button" class="btn btn-info btn-square" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>