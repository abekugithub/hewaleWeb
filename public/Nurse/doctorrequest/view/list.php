<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 5/1/2018
 * Time: 5:33 PM
 */
$rs = $paging->paginate();
?>
<div class="main-content">
    <input id="doctorname" name="doctorname" value="" type="hidden" />
    <input id="doctorcode" name="doctorcode" value="" type="hidden" />
    <input id="nursename" name="nursename" value="" type="hidden" />
    <input id="nursecode" name="nursecode" value="" type="hidden" />
    <input type="hidden" name="canceldata" id="canceldata" />

    <div class="page-wrapper">
        <?php //$engine->msgBox($msg,$status); ?>
        <div class="page form">
            <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper">Doctors Request List</div>
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
                            <input type="text" tabindex="1" value="<?php echo $fdsearch; ?>" class="form-control square-input" name="fdsearch" placeholder="Search..."
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

                    </div>
                </div>
            </div>
            <?php $engine->msgBox($msg,$status); ?>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Request Date</th>
                    <th>Doctor's Name</th>
                    <th>Doctor's Specialty</th>
                    <th>Doctor's Med. License</th>
<!--                    <th>Schedule Time</th>-->
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
                        $consperiod = $patientCls->getConsultPeriod($obj->CONS_CODE);
                        $linkview = 'index.php?pg='.md5('Doctors').'&amp;option='.md5('Consultation').'&uiid='.md5('1_pop').'&viewpage=historylist&view=historylist&keys='.$obj->CONS_PATIENTNUM;

                        echo '<tr >
                        <td>'.$num++.'</td>
                        <td>'.date("d/m/Y",strtotime($obj->NRQ_DATE)).'</td>
                        <td>'.$obj->NRQ_DOCTOR_NAM.'</td>
                        <td>'.$obj->NRQ_DOCTOR_SPECIALTY.'</td>                      
						<td>'.$obj->NRQ_DOCTOR_MEDLICENSE.'</td>
						<td><span class="">'.$status_arr[$obj->NRQ_STATUS].'</span></td>
						<td><div class="btn-group">
                                <button type="button" class="btn btn-info btn-square" dropdown-toggle" data-toggle="dropdown">Options <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="menu">';
                        echo '<li>
									<button type="submit" class="startchat" onclick="document.getElementById(\'keys\').value=\''.$obj->NRQ_ID.'\';document.getElementById(\'nursecode\').value=\''.$obj->NRQ_NURSE_CODE.'\';document.getElementById(\'nursename\').value=\''.$obj->NRQ_NURSE_NAME.'\';document.getElementById(\'doctorcode\').value=\''.$obj->NRQ_DOCTOR_CODE.'\';document.getElementById(\'doctorname\').value=\''.$obj->NRQ_DOCTOR_NAME.'\';document.getElementById(\'viewpage\').value=\'viewdoctorprofile\';document.getElementById(\'view\').value=\'\';document.myform.submit();">View Doctor Profile</button>
									</li>
									<div class="divider"></div>
									<li>
									<button type="submit" class="startchat" onclick="document.getElementById(\'keys\').value=\''.$obj->NRQ_ID.'\';document.getElementById(\'nursecode\').value=\''.$obj->NRQ_NURSE_CODE.'\';document.getElementById(\'nursename\').value=\''.$obj->NRQ_NURSE_NAME.'\';document.getElementById(\'doctorcode\').value=\''.$obj->NRQ_DOCTOR_CODE.'\';document.getElementById(\'doctorname\').value=\''.$obj->NRQ_DOCTOR_NAME.'\';document.getElementById(\'viewpage\').value=\'acceptrequest\';document.getElementById(\'view\').value=\'\';document.myform.submit();">Accept Request</button>
									</li>
									<li>
									    <button type="submit" class="startchat" onclick="document.getElementById(\'keys\').value=\''.$obj->NRQ_ID.'\';document.getElementById(\'nursecode\').value=\''.$obj->NRQ_NURSE_CODE.'\';document.getElementById(\'nursename\').value=\''.$obj->NRQ_NURSE_NAME.'\';document.getElementById(\'doctorcode\').value=\''.$obj->NRQ_DOCTOR_CODE.'\';document.getElementById(\'doctorname\').value=\''.$obj->NRQ_DOCTOR_NAME.'\';document.getElementById(\'viewpage\').value=\'rejectrequest\';document.getElementById(\'view\').value=\'\';document.myform.submit();">Reject Request</button>
									</li>
                                </ul>
                            </div>
                        </td>
                    </tr>';
                    }
                }else{
                    echo '<tr><td colspan="9">No Request Found...</td></tr>';
                }
                ?>
                </tbody>
            </table>
        </div>

    </div>

</div>