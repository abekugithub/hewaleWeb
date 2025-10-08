<?php


$rs = $paging->paginate();
?>

    <div class="main-content">

        <div class="page-wrapper">

            <!-- <div class="page-lable lblcolor-page">Table</div>-->
            <div class="page form">
                <div class="moduletitle" style="margin-bottom:0px;">
                    <div class="moduletitleupper">My Suppliers</div>
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
                                <input type="text" tabindex="1" value="<?php echo $fdsearch; ?>" class="form-control square-input" name="fdsearch" placeholder="Enter Supplier Name Or Contact to Search"
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
                                    <i class="fa fa-plus-circle"></i> Create Supplier</button>
                        </div>
                    </div>
                </div>
                
               <?php $engine->msgBox($msg,$status); ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Supplier</th>
                            <th>Phone No</th>
                            <th>Email </th>
                            <th>Location</th>
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
						   
                    		 $delievery = $obj->SU_STATUS;
						   $delstatus = "";
						   
						   if ($delievery == '1') {
							   $delstatus = 'Active';
							  }else {
								  
								$delstatus = 'Dsabled';  
							  }
								
							
							
                   echo '<tr>
                        <td>'.$num++.'</td>
                        <td>'.$obj->SU_NAME.'</td>
                        <td>'.$obj->SU_CONTACT.'</td>
                        <td>'.$obj->SU_EMAIL.'</td>
						<td>'.$obj->SU_LOCATION.'</td>
						<td>'.$delstatus.'</td>
						<td><button class="btn btn-info btn-square" type="submit" onclick="document.getElementById(\'view\').value=\'edit\';document.getElementById(\'keys\').value=\''.$obj->SU_CODE.'\';document.getElementById(\'viewpage\').value=\'edit\';document.myform.submit;">View Details</button>
						
						
							
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