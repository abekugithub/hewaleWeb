<?php
$rs = $paging->paginate();
?>
<style>
.rowdanger{
	background-color:#97181B4D
}
.rowwarning{
	background-color:#EBECB9
}
</style>
    <div class="main-content">

        <div class="page-wrapper row">
        <div class="col-md-12">
                <!-- <div class="page-lable lblcolor-page">Table</div>-->
                <div class="page form">
                    <div class="moduletitle" style="margin-bottom:0px;">
                        <div class="moduletitleupper">Transactions History</div>
                        <input type="hidden" class="form-control" value="" id="imagename" name="imagename" >
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
                            <input type="hidden" class="form-control" value="" id="patientfullname" name="patientfullname" >
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
                            <div class="pagination-right">

                            </div>
                        </div>
                    </div>

                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Prescription Date</th>
                            <th>Prescription Code</th>
                            <th>Patient Name</th>
                            <th>Patient Number</th>
                            <th>Delivery</th>
                            <th>Courier Name</th>
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
                            	if ($obj->PRESCM_STATUS == 1){$status = 'Pending Request';}elseif($obj->PRESCM_STATUS == 2){$status = 'Pending Payment';}elseif($obj->PRESCM_STATUS == 3){$status = 'Paid - Awaiting Collection';}elseif($obj->PRESCM_STATUS == 4){$status = 'Ready for dispatch';}elseif($obj->PRESCM_STATUS == 5){$status = 'Collected - In Transit';}elseif($obj->PRESCM_STATUS == 6){$status = 'Dispatched to Courier';}elseif($obj->PRESCM_STATUS == 7){$status = 'Delivered to Client';}
                                //	   $consperiod = $patientCls->getConsultPeriod($obj->PRESC_CODE);
                                //echo '';
                                echo '<tr >
				       <td>'.$num++.'</td>
                        <td>'.date("d/m/Y",strtotime($obj->PRESCM_DATE)).'</td>
                        <td>'.$obj->PRESCM_PACKAGECODE.'</td>
                        <td>'.$obj->PRESCM_PATIENT.'</td>
                        <td>'.$obj->PRESCM_PATIENTNUM.'</td>
						<td>'.(($obj->PRESCM_DEL_STATUS == 1)?'Courier':(($obj->PRESCM_DEL_STATUS == 0)?'Self Pickup':'')).'</td>
						<td>'.(!empty($obj->PRESCM_COUR_NAME)?$obj->PRESCM_COUR_NAME:'N/A').'</td>
                        <td>'.(!empty($obj->PRESCM_PICKUPCODE)?$obj->PRESCM_PICKUPCODE:'N/A').'</td>
                        <td>'.$status.'</td>
						<td><button type="submit" class="btn btn-success btn-square" onclick="document.getElementById(\'view\').value=\'sales\';document.getElementById(\'hewale_number\').value=\''.$obj->PRESCM_PATIENTNUM.'\';document.getElementById(\'keys\').value=\''.$obj->PRESCM_PACKAGECODE.'\';document.getElementById(\'viewpage\').value=\'sales\';document.myform.submit;">Details</button></td>
						
                    </tr>';
                            
                            }
                        }
                        ?>
                       
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>