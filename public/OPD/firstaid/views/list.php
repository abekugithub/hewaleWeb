<?php
$rs = $paging->paginate();
?>

    <div class="main-content">

        <div class="page-wrapper">

<input type="hidden" name="canceldata" id="canceldata" />
            

            <!-- <div class="page-lable lblcolor-page">Table</div>-->
            <div class="page form">
                <div class="moduletitle" style="margin-bottom:0px;">
                    <div class="moduletitleupper">First Aid</div>
                </div>
			<?php $engine->msgBox($msg,$status); ?>
                <div class="pagination-tab">
                    <div class="table-title">
                        <div class="col-sm-3">
                            <div id="pager">
                                <?php echo $paging->renderFirst('<span class="fa fa-angle-double-left"></span>');?>
                                <?php echo $paging->renderPrev('<span class="fa fa-arrow-circle-left"></span>','<span class="fa fa-arrow-circle-left"></span>');?>
                                <input name="page" type="text" class="pagedisplay short" value="<?php echo $paging->renderNavNum();?>" readonly />
                                <?php echo $paging->renderNext('<span class="fa fa-arrow-circle-right"></span>','<span class="fa fa-arrow-circle-right"></span>');?>
                                <?php echo $paging->renderLast('<span class="fa fa-angle-double-right"></span>');?>
                                <?php $paging->limitList($limit,"myform");?>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" tabindex="1" value="<?php echo $fdsearch; ?>" class="form-control square-input" name="fdsearch" placeholder="patient name, patient number"
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
                            <!-- <button type="submit" onclick="document.getElementById('view').value='vitals';document.myform.submit;" class="btn btn-info"><i class="fa fa-plus-circle"></i> Add Dispensary </button> -->
                        </div>
                    </div>
                </div>


                

                <table class="table table-hover">
                    <thead>
                        <tr>
                           <th>#</th>
                            <th>Visite Date</th>
                            <th>Patient No.</th>
                            <th>Patient Name</th>
                            <th>Service</th>
                            <th>Status</th>
                           <th width="170">Action</th>
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
						   $usergroup = $engine->geAllUsersGroup($obj->USR_USERID);
                    
                   echo '<tr>
                        <td>'.$num++.'</td>
						<td>'.$obj->REQU_DATE.'</td>
                        <td>'.$obj->REQU_PATIENTNUM.'</td>
                        <td>'.$obj->REQU_PATIENT_FULLNAME.'</td>
                        <td>'.$obj->REQU_SERVICENAME.'</td>
						<td>'.(($obj->REQU_STATUS == 7)?'Pending':(($obj->REQU_STATUS == 2)?'Sent to Consultation':'Locked')).'</td>
						<td><div class="btn-group">
                                <button type="button" class="btn btn-info btn-square">Options</button>
                                <button type="" class="btn btn-info btn-square dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
								
								<li><button type="submit" onclick="document.getElementById(\'keys\').value=\''.$obj->REQU_CODE.'\';document.getElementById(\'viewpage\').value=\'getclientdetails\';document.getElementById(\'view\').value=\'firstaid\';document.myform.submit;">Take First Aid</button></li>
								
								<li>
              <button type="button" class="" data-toggle="modal" data-target="#addDesp" onclick="document.getElementById(\'keys\').value=\''.$obj->REQU_CODE.'\';document.myform.submit;">Cancel</button>
			  </li>
			  
								
                                    
                                </ul>
                            </div>
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
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Cancellation Reason</h4>
      </div>
      <div class="modal-body ">
        <p><textarea class="form-control" name="cancel" id="cancel"></textarea> </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success btn-square" id="save" data-dismiss="modal">Save</button>
        <button type="button" class="btn btn-info btn-square" data-dismiss="modal">Close</button>
        
      </div>
    </div>

  </div>
</div>