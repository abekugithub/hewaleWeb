<?php
$rs = $paging->paginate();
$rsb = $pagingBroad->paginate();

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
                        <div class="moduletitleupper">Dispensary</div>
                        <input type="hidden" class="form-control" value="" id="imagename" name="imagename" >
                        <input type="hidden" class="form-control" value="" id="state" name="state" >
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
                                    <input type="text" tabindex="1" value="<?php echo $fdsearch; ?>" class="form-control square-input" name="fdsearch" placeholder="Enter patient id or name to Search"/>
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
                            <th>Patient Name</th>
                            <th>Hewale Number</th>

                            <th>Delivery</th>
                            <th>Prescription Code</th>
                            <th>Courier Name</th>
                            <th>PickupCode</th>
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
                            	if ($obj->BRO_STATUS !='4'){
                                //	   $consperiod = $patientCls->getConsultPeriod($obj->PRESCM_CODE);
                                //echo '';
                         	$color=($obj->PRESCM_FACICODE!=$faccode)?"bgcolor=gray":"";
                            		echo '<tr '."$color".'>
				       <td>'.$num++.'</td>
                        <td>'.date("d/m/Y",strtotime($obj->PRESCM_INPUTEDDATE)).'</td>
                        <td>'.$obj->PRESCM_PATIENT.'</td>
                        <td>'.$obj->PRESCM_PATIENTNUM.'</td>
					
						<td>'.(($obj->PRESCM_DEL_STATUS == 1)?'Courier':(($obj->PRESCM_DEL_STATUS == 0)?'Self Pickup':'')).'</td>
						<td>'.(!empty($obj->PRESCM_ITEMCODE)?$obj->PRESCM_ITEMCODE:'N/A').'</td>
						<td>'.(!empty($obj->PRESCM_COUR_NAME)?$obj->PRESCM_COUR_NAME:'N/A').'</td>
						<td>'.(!empty($obj->PRESCM_PICKUPCODE)?$obj->PRESCM_PICKUPCODE:'N/A').'</td>
						
						<td> 
						'; 
                            if($obj->BRO_STATUS==3 && $obj->BRO_STATE==1)//USER HAS REPLIED AND DECIDED TO PURCHASE THE DRUG
                                {echo '<button type="submit" class="btn btn-warning btn-square" onclick="document.getElementById(\'view\').value=\'sales\';document.getElementById(\'keys\').value=\''.$obj->PRESCM_PACKAGECODE.'\';document.getElementById(\'viewpage\').value=\'sales\';document.getElementById(\'patientfullname\').value=\''.$obj->PRESCM_PATIENT.'\';document.myform.submit;">Sale</button>';}
                            	elseif($obj->BRO_STATUS==3 && ($obj->BRO_STATE==2 ||$obj->BRO_STATE==3))//USER HAS REPLIED AND DECIDED TO PURCHASE THE IMAGE DRUG 
                                { if ($obj->BRO_STATE==2){
                                	echo '<button type="submit" class="btn btn-warning btn-square" onclick="document.getElementById(\'view\').value=\'prepareimage\';document.getElementById(\'keys\').value=\''.$obj->PRESCM_PACKAGECODE.'\';document.getElementById(\'viewpage\').value=\'prepareimage\';document.getElementById(\'patientfullname\').value=\''.$obj->PRESCM_PATIENT.'\';document.getElementById(\'imagename\').value=\''.$obj->PRESCM_IMAGE.'\';document.getElementById(\'state\').value=\''.$obj->BRO_STATE.'\';document.myform.submit;">Sale</button>';
                                }elseif ($obj->BRO_STATE=3){
                                	echo '<button type="submit" class="btn btn-warning btn-square" onclick="document.getElementById(\'view\').value=\'prepareimage\';document.getElementById(\'keys\').value=\''.$obj->PRESCM_PACKAGECODE.'\';document.getElementById(\'viewpage\').value=\'prepareimage\';document.getElementById(\'patientfullname\').value=\''.$obj->PRESCM_PATIENT.'\';document.getElementById(\'state\').value=\''.$obj->BRO_STATE.'\';document.myform.submit;">Sale</button>';
                                }else{
                                	echo '<button type="submit" class="btn btn-warning btn-square" onclick="document.getElementById(\'view\').value=\'sales\';document.getElementById(\'keys\').value=\''.$obj->PRESCM_PACKAGECODE.'\';document.getElementById(\'viewpage\').value=\'sales\';document.getElementById(\'patientfullname\').value=\''.$obj->PRESCM_PATIENT.'\';document.myform.submit;">Sale</button>';
                                }
                                }    
                             /**   elseif($obj->BRO_STATUS == 2){//PREPARED AND WAITING FOR RESPONSE FROM USER
								  	echo '<button type="submit" disabled class="btn btn-secondary btn-square">Pending</button>';
                                }
                                elseif($obj->BRO_STATUS==1 &&$obj->BRO_STATE == 2){//for image prescription
								 echo '<button type="submit" class="btn btn-info btn-square" onclick="document.getElementById(\'view\').value=\'prepareimage\';document.getElementById(\'keys\').value=\''.$obj->PRESCM_VISITCODE.'\';document.getElementById(\'viewpage\').value=\'prescrdetails\';document.getElementById(\'patientfullname\').value=\''.$obj->PRESCM_PATIENT.'\';document.getElementById(\'imagename\').value=\''.$obj->BRO_IMAGENAME.'\';document.myform.submit;">Prepare Image</button>
						';
                                }elseif ($obj->BRO_STATUS==1 && $obj->BRO_STATE==1){//for prescription
                                             echo '<button type="submit" class="btn btn-info btn-square" onclick="document.getElementById(\'view\').value=\'prescdetails\';document.getElementById(\'keys\').value=\''.$obj->PRESCM_VISITCODE.'\';document.getElementById(\'viewpage\').value=\'presdetails\';document.getElementById(\'patientfullname\').value=\''.$obj->PRESCM_PATIENT.'\';document.myform.submit;">Prepare</button>
						'; 	
                                }**/
                              
                            	
                                /**elseif($obj->PRESCM_STATUS==3)
                                {              echo '<button type="submit" class="btn btn-info btn-square" onclick="document.getElementById(\'view\').value=\'prescdetails\';document.getElementById(\'keys\').value=\''.$obj->PRESCM_VISITCODE.'\';document.getElementById(\'viewpage\').value=\'prescrdetails\';document.myform.submit;">Prepare</button>
						';}else{echo '<button type="submit" class="btn btn-success btn-square" onclick="document.getElementById(\'view\').value=\'sales\';document.getElementById(\'keys\').value=\''.$obj->PRESCM_VISITCODE.'\';document.getElementById(\'viewpage\').value=\'sales\';document.myform.submit;">Sale</button>';}'**/
						
							
					echo	'</td>
						
                    </tr>';
                            }
                            }
                        }
                        ?>
                        <!-- for sale	<button type="submit" class="btn btn-success btn-square" onclick="document.getElementById(\'view\').value=\'sales\';document.getElementById(\'keys\').value=\''.$obj->PRESCM_VISITCODE.'\';document.getElementById(\'viewpage\').value=\'sales\';document.myform.submit;">Sale</button> -->
                        </tbody>
                    </table>
                </div>
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
        <h4 class="modal-title">Add Dispensary</h4>
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
<script src="media/timer/timer.js"></script>
<script>
    var timer = new Timer();
    timer.start({precision: 'secondTenths'});
    timer.addEventListener('secondTenthsUpdated', function (e) {
        $('#secondTenthsExample .values').html(timer.getTimeValues().toString(['hours', 'minutes', 'seconds', 'secondTenths']));
    });
</script>