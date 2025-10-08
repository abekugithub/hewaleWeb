<?php
$rs = $paging->paginate();
?>
<style>
.rowdanger{
	background-color:#97181B4D}
.rowwarning{
	background-color:#EBECB9}
.rowinfo{
	background-color:#FFA500}
</style>
    <div class="main-content">

        <div class="page-wrapper">


            <?php //$engine->msgBox($msg,$status); ?>

            <!-- <div class="page-lable lblcolor-page">Table</div>-->
            <div class="page form">
                <div class="moduletitle" style="margin-bottom:0px;">
                    <div class="moduletitleupper">Prescriptions</div> 
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
                                <input type="text" tabindex="1" value="<?php echo $fdsearch; ?>" class="form-control square-input" name="fdsearch" placeholder="Enter Category to Search"/>
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
                     
                    </div>
                </div>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            
							<th>#</th>
							<th>Prescription Date</th>
							<th>Patient Name</th>
							<th>Patient Number</th>
							<th>Delivery Method</th>
							<th>Pickup Code</th>
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
						//   $consperiod = $patientCls->getConsultPeriod($obj->PRESC_CODE);
						  
                   echo '<tr >
				  
                        <td>'.$num++.'</td>
                        <td>'.date("d/m/Y",strtotime($obj->PRESC_DATE)).'</td>
                        <td>'.$obj->PRESC_PATIENT.'</td>
                        <td>'.$obj->PRESC_PATIENTNUM.'</td>
                        <td>'.(($obj->PRESC_DEL_STATUS == 1)?'Courrier Pickup':'Self Pickup').'</td>
                        <td>'.$obj->PRESC_PICKUPCODE.'</td>
						<td>'.(($obj->PRESC_STATUS == 3)?'Paid':'Ready').'</td>
                        <td> 
						'.(($obj->PRESC_STATUS == 3)?'<button type="submit" class="btn btn-info btn-square" onclick="document.getElementById(\'view\').value=\'prescdetails\';document.getElementById(\'keys\').value=\''.$obj->PRESC_VISITCODE.'\';document.getElementById(\'viewpage\').value=\'prescrdetails\';document.myform.submit;">Details</button>':'N/A').'
						
							
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
        <h4 class="modal-title">Add Despensary</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success btn-square" data-dismiss="modal">Save</button>
        <button type="button" class="btn btn-info btn-square" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>