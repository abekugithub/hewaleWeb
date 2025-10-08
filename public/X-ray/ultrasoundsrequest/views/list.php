<?php $rs = $paging->paginate();?>
<style type="text/css">
    .demo {
        position: relative;
    }

    .demo i {
        position: absolute;
        bottom: 10px;
        right: 24px;
        top: auto;
        cursor: pointer;
    }
</style>
<style>
.rowdanger{
	background-color:#97181B4D}
.rowwarning{
	background-color:#EBECB9}
.rowinfo{
	background-color:#C0C0C0}
</style>
 
<div class="main-content">
    <div class="page-wrapper">

        

        <!-- <div class="page-lable lblcolor-page">Table</div> -->
        <div class="page form">
            <div class="moduletitle" style="margin-bottom:0px;">
               
                <div class="moduletitleupper">Pending Ultrasound Request</div> 
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
                            <input type="text" tabindex="1" value="<?php echo $fdsearch; ?>" class="form-control square-input" name="fdsearch" placeholder="patient number, patient name"/>
                            <span class="input-group-btn">
                                <button type="submit" onclick="document.getElementById('action_search').value='search';document.getElementById('viewpage').value='';document.myform.submit;" class="btn btn-default btn-gyn-search"> <i class="fa fa-search"></i> </button>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group">
                            <button type="submit" onclick="document.getElementById('action_search').value='';
                        	        document.getElementById('viewpage').value='reset';document.myform.submit;" class="btn btn-success btn-square"> <i class="fa fa-refresh"></i> </button>
                        </div>
                    </div>
                    <div class="pagination-right" id="hiddenbtn" style="display: ">
                                 </div>
                </div>
            </div>



            <table class="table table-hover">
                <thead>
                    <tr>
                        <th></th>
                        
						<th>Date</th>
						<th>Batch Code</th>
                        <th>Patient Name</th>
                        <th>Hewale No.</th>
                        <th>Total ( Ghc )</th>
						<th>Doctor</th>
                        <th>Contact</th>
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
                           //$usergroup = $engine->geAllUsersGroup($obj->USR_USERID);
                           $rphone = $doctors->getDoctorPhonenum($obj->XTM_ACTORCODE);
                           
                   echo '<tr >
							
						<td>'.$num.'</td>
						<td>'.$sql->UserDate($obj->XTM_DATE,'d/m/Y').'</td>
						<td>'.$obj->XTM_PACKAGECODE.'</td>
						
                        <td>'.$obj->XTM_PATIENTNAME.'</td>
                        <td>'.$obj->XTM_PATIENTNUM.'</td>
                        <td>'.$obj->XTM_TOTAL_AMOUNT.'</td>
                        <td>'.$obj->XTM_ACTORNAME.'</td>
                        <td>'.$rphone.'</td>
                        
						<td> 
						
						<button type="submit" class="btn btn-info btn-square" onclick="document.getElementById(\'view\').value=\'details\';document.getElementById(\'keys\').value=\''.$obj->XTM_PACKAGECODE.'\';document.getElementById(\'viewpage\').value=\'details\';document.myform.submit;">Details </button>
                       
						</td>
                    </tr>';
					$num ++; }
				
					
					}else{
					?>
                    <tr><td colspan="5">No Records Found</td></tr>
                    <?php }?>
                </tbody>
            </table>
        </div>

    </div>

</div>

