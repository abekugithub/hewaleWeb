<?php
$rs = $paging->paginate();
//$rsb = $pagingBroad->paginate();

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
                        <div class="moduletitleupper">Pending Dispensary</div>
                        <input type="hidden" class="form-control" value="" id="imagename" name="imagename" >
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
                            <input type="hidden" class="form-control" value="" id="patientfullname" name="patientfullname" >
                                <div class="input-group">
                                    <input type="text" tabindex="1" value="<?php echo $fdsearch; ?>" class="form-control square-input" name="fdsearch" placeholder="Enter to Search..."/>
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
                    <?php $engine->msgBox($msg,$status); ?>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center">
                                <h1 id="totalVals" class="values"> <?php echo $paging->total_rows ?> </h1>
                                <h3 style="margin-top: -5px">Total Request</h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center" id="secondTenthsExample">
                                <h1 class="values"></h1>
                                <h3 style="margin-top: -5px">UPTIME</h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <h1 id="countVals" class="values"> <?php echo $total_pending;?> </h1>
                                <h3 style="margin-top: -5px">New Pending Request</h3>
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
                            <th>Hewale Number</th>
                            <th>Gender</th>
                            <th>Age</th>
                            <th>Status</th>
                            <th width="170">Action</th>
                        </tr>
                        </thead>
                        <tbody class="tbody">
                        <?php
                        $num = 1;
                        if($paging->total_rows > 0 ){
                            $page = (empty($page))? 1:$page;
                            $num = (isset($page))? ($limit*($page-1))+1:1;
                            while(!$rs->EOF){
                            	$obj = $rs->FetchNextObject();
                                echo '<tr >
				       <td>'.$num++.'</td>
                        <td>'.date("d/m/Y",strtotime($obj->PRESCM_DATE)).'</td>
                        <td>'.$obj->PRESCM_ITEMCODE.'</td>
                        <td>'.$obj->PRESCM_PATIENT.'</td>
                        <td>'.$obj->PRESCM_PATIENTNUM.'</td>
						<td>'.(!empty($patientCls->getPatientDetails($obj->PRESCM_PATIENTNUM)->PATIENT_GENDER)?$patientCls->getPatientDetails($obj->PRESCM_PATIENTNUM)->PATIENT_GENDER=='M'?'Male':'Female':'').'</td>
						<td>'.(!empty($patientCls->getPatientDetails($obj->PRESCM_PATIENTNUM)->PATIENT_DOB)?$engine->calculateAge($patientCls->getPatientDetails($obj->PRESCM_PATIENTNUM)->PATIENT_DOB):'N/A').'</td>
						<td>';
                                if ($obj->BRO_STATUS == 1) {    //Pending for Preparation
                                    echo '<label class="label label-success">New</label>';
                                } elseif ($obj->BRO_STATUS == 2) {  //Prepared but Pending Patient Payment
                                    echo '<label class="label label-danger">Pending...</label>';
                                }
                                echo '</td>
						<td>';
                                    if($obj->BRO_STATE==1) {    // Prescription From Doctors
                                        if ($obj->BRO_STATUS == 1) {    //Pending for Preparation
                                            echo '<button type="submit" class="btn btn-success btn-square"
                            onclick="document.getElementById(\'view\').value=\'prepareprescription\';document.getElementById(\'keys\').value=\''.$obj->PRESCM_PACKAGECODE .'\';document.getElementById(\'viewpage\').value=\'presdetails\';document.myform.submit();">Prepare</button>&nbsp;<button type="button" class="btn btn-danger btn-square"
                            onclick="confirmSubmit(\'Are you sure you want to delete this prescription.\',\'Yes\',function() {
                             document.getElementById(\'view\').value=\'\';document.getElementById(\'keys\').value=\''.$obj->PRESCM_PACKAGECODE .'\';document.getElementById(\'viewpage\').value=\'deletefrombroadcastlist\';document.myform.submit(); 
                            })">Delete</button>';
                                        } elseif ($obj->BRO_STATUS == 2) {  //Prepared but Pending Patient Payment
                                            echo  '<button type="submit" class="btn btn-success btn-square"
                            onclick="document.getElementById(\'view\').value=\'viewpresc\';document.getElementById(\'keys\').value=\''.$obj->PRESCM_PACKAGECODE .'\';document.getElementById(\'viewpage\').value=\'viewpresc\';document.myform.submit();">View</button>&nbsp;<button type="button" class="btn btn-danger btn-square" onclick="confirmSubmit(\'Are you sure you want to delete this prescription.\',\'Yes\',function() {
                            document.getElementById(\'view\').value=\'\';document.getElementById(\'keys\').value=\''.$obj->PRESCM_PACKAGECODE .'\';document.getElementById(\'viewpage\').value=\'deletefrombroadcastlist\';document.myform.submit();
})">Delete</button>';
                                        }
                                    }elseif($obj->BRO_STATE==3) {    // Prescription From Patient Using Text
                                        if ($obj->BRO_STATUS == 1) {    //Pending for Preparation
                                            echo '<button type="submit" class="btn btn-success btn-square"
                            onclick="document.getElementById(\'view\').value=\'prepareimage\';document.getElementById(\'keys\').value=\''.$obj->PRESCM_VISITCODE .'\';document.getElementById(\'viewpage\').value=\'preparetextprescription\';document.myform.submit();">Prepare</button>&nbsp;<button type="button" class="btn btn-danger btn-square"
                            onclick="confirmSubmit(\'Are you sure you want to delete this prescription.\',\'Yes\',function() {
                            document.getElementById(\'view\').value=\'\';document.getElementById(\'keys\').value=\''.$obj->PRESCM_VISITCODE .'\';document.getElementById(\'viewpage\').value=\'deletefrombroadcastlist\';document.myform.submit();
})">Delete</button>';
                                        } elseif ($obj->BRO_STATUS == 2) {  //Prepared but Pending Patient Payment
                                            echo  '<button type="submit" class="btn btn-success btn-square"
                            onclick="document.getElementById(\'view\').value=\'viewprepareimage\';document.getElementById(\'keys\').value=\''.$obj->PRESCM_PACKAGECODE .'\';document.getElementById(\'viewpage\').value=\'viewpresc\';document.myform.submit();">View</button>&nbsp;<button type="button" class="btn btn-danger btn-square" onclick="confirmSubmit(\'Are you sure you want to delete this prescription.\',\'Yes\',function() {
                            document.getElementById(\'view\').value=\'\';document.getElementById(\'keys\').value=\''.$obj->PRESCM_PACKAGECODE .'\';document.getElementById(\'viewpage\').value=\'deletefrombroadcastlist\';document.getElementById(\'imagename\').value=\''.$obj->BRO_IMAGENAME.'\';document.myform.submit();
})">Delete</button>';
                                        }
                                    }else{  //Prescription From Image
                                        if ($obj->BRO_STATUS == 1) {    //Pending for Preparation
                                            echo '<button type="submit" class="btn btn-success btn-square"
                            onclick="document.getElementById(\'view\').value=\'prepareimage\';document.getElementById(\'keys\').value=\''.$obj->PRESCM_VISITCODE .'\';document.getElementById(\'viewpage\').value=\'imageprepare\';document.getElementById(\'imagename\').value=\''.$obj->BRO_IMAGENAME.'\';document.myform.submit();">Prepare</button>&nbsp;<button type="button" class="btn btn-danger btn-square" onclick="confirmSubmit(\'Are you sure you want to delete this prescription.\',\'Yes\',function() {
                            document.getElementById(\'view\').value=\'\';document.getElementById(\'keys\').value=\''.$obj->PRESCM_VISITCODE .'\';document.getElementById(\'viewpage\').value=\'deletefrombroadcastlist\';document.getElementById(\'imagename\').value=\''.$obj->BRO_IMAGENAME.'\';document.myform.submit();
})">Delete</button>';
                                        } elseif ($obj->BRO_STATUS == 2) {  //Prepared but waiting for Patient Payment
                                            echo '<button type="submit" class="btn btn-success btn-square"
                            onclick="document.getElementById(\'view\').value=\'viewprepareimage\';document.getElementById(\'keys\').value=\''.$obj->PRESCM_VISITCODE .'\';document.getElementById(\'viewpage\').value=\'viewimage\';document.getElementById(\'imagename\').value=\''.$obj->BRO_IMAGENAME.'\';document.myform.submit();">View</button>&nbsp;<button type="button" class="btn btn-danger btn-square" onclick="confirmSubmit(\'Are you sure you want to delete this prescription.\',\'Yes\',function() {
                            document.getElementById(\'view\').value=\'\';document.getElementById(\'keys\').value=\''.$obj->PRESCM_PACKAGECODE .'\';document.getElementById(\'viewpage\').value=\'deletefrombroadcastlist\';document.getElementById(\'imagename\').value=\''.$obj->BRO_IMAGENAME.'\';document.myform.submit();
})">Delete</button>';
                                        }
                                    }
							
					echo	'</td>
						
                    </tr>';
                            }
                        }else{
                            echo '<tr><td colspan="10">No Record found...</td></tr>';
                        }
                        ?>
                        </tbody>
                    </table>
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