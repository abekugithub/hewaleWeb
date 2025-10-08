<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 11/21/2017
 * Time: 12:22 PM
 */
?>

<?php $rs = $paging->paginate();?>
<div class="main-content">
    <div class="page-wrapper">
        <div class="page form">
            <?php $engine->msgBox($msg,$status); ?>
            <div class="panel-warning">
                <div class="alert alert-danger medal"></div>
            </div>
            <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper">Group Name: <?php echo $groupname;?>
                    <button type="button" style="float: right;" class="btn btn-dark" onclick="document.getElementById('views').value='groupregistrationlist';document.myform.submit();"><i class="fa fa-arrow-left"></i> Back </button>
                </div>

            </div>

            <form action="" method="post" enctype="multipart/form-data" id="frmmyform" name="myform">
                <input type="hidden" name="views" value="" id="views" class="form-control" />
                <input type="hidden" name="viewpages" value="" id="viewpages" class="form-control" />
                <input type="hidden" name="key" value="<?php echo $key;?>" id="key" class="form-control" />
                <input type="hidden" name="patkey" value="<?php echo $patkey; ?>" id="patkey" class="form-control" />
                <input type="hidden" name="action_search" value="" id="action_search" class="form-control" />
                <input type="hidden" name="groupcode" value="" id="groupcode" class="form-control" />
                <input type="hidden" name="groupname" value="" id="groupname" class="form-control" />
                <input type="hidden" name="v" value="" id="v" class="form-control" />

                <div class="pagination-tab">
                    <div class="table-title">
                        <div class="col-sm-2">
                            <div id="pager">
                                <?php echo $paging->renderFirst('<span class="fa fa-angle-double-left"></span>');?>
                                <?php echo $paging->renderPrev('<span class="fa fa-arrow-circle-left"></span>','<span class="fa fa-arrow-circle-left"></span>');?>
                                <input name="page" type="text" class="pagedisplay short" value="<?php echo $paging->renderNavNum();?>" readonly />
                                <?php echo $paging->renderNext('<span class="fa fa-arrow-circle-right"></span>','<span class="fa fa-arrow-circle-right"></span>');?>
                                <?php echo $paging->renderLast('<span class="fa fa-angle-double-right"></span>');?>
                                <?php $paging->limitList($limit,"myform");?>
                            </div>
                        </div>
                        <div class="col-sm-6" style="display: inline-flex">
                            <select name="" class="form-control" style="width: 130px;">
                                <option>Advance</option>
                                <option>Advance</option>
                            </select>
                            <div class="input-group">
                                <input type="text" tabindex="1" value="<?php echo $fdsearch; ?>" class="form-control square-input" name="fdsearch" placeholder="Enter Group Name or Patient Number to Search"/>
                                <span class="input-group-btn">
                                <button type="submit" onclick="document.getElementById('action_search').value='search';document.getElementById('viewpage').value='';document.myform.submit;" class="btn btn-default btn-gyn-search"> <i class="fa fa-search"></i> </button>
                            </span>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <button type="button" onclick="document.getElementById('action_search').value='';document.getElementById('views').value='viewgroup';document.getElementById('viewpages').value='reset';document.myform.submit();" class="btn btn-success btn-square">
                                <i class="fa fa-refresh"></i>
                            </button>
                        </div>
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-success" title="Add Patient to this Group" onclick="document.getElementById('views').value='groupregistrationadd';document.getElementById('groupcode').value='<?php echo $groupcode;?>';document.getElementById('groupname').value='<?php echo $groupname;?>';document.getElementById('groupname').value='<?php echo $obj->PATGRP_NAME;?>';document.myform.submit();"><i class="fa fa-plus-circle"></i> Add Member</button>
                        </div>

                    </div>
                </div>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Patient Name</th>
                        <th>Hewale No.</th>
                        <th>Email</th>
                        <th>Phone No.</th>
                        <th>Gender</th>
                        <th>Marital Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $num = 1;
                    $i =  1;
                    if($paging->total_rows > 0 ){
                        $page = (empty($page))? 1:$page;
                        $num = (isset($page))? ($limit*($page-1))+1:1;
                        while(!$rs->EOF) {
                            $obj = $rs->FetchNextObject();
                            ?>
                            <tr>
                                <td><?php echo $num; ?></td>
                                <td><?php echo $obj->PATIENT_FNAME.' '.$obj->PATIENT_MNAME.' '.$obj->PATIENT_LNAME; ?></td>
                                <td><?php echo $obj->PATIENT_PATIENTNUM; ?></td>
                                <td><?php echo $obj->PATIENT_EMAIL; ?></td>
                                <td><?php echo $obj->PATIENT_PHONENUM; ?></td>
                                <td><?php echo (($obj->PATIENT_GENDER == 'F')?'Female':'Male'); ?></td>
                                <td><?php echo $obj->PATIENT_MARITAL_STATUS; ?></td>
                                <td><?php echo $sql->userDate($obj->PATIENT_INPUTEDDATE,'d/m/Y'); ?></td>
                                <td>
                                    <button type="submit" class="btn btn-success" onclick="document.getElementById('keys').value='<?php echo $obj->PATIENT_PATIENTCODE?>';document.getElementById('views').value='add';document.getElementById('viewpages').value='editpatient';"><i class="fa fa-pencil"></i> Edit</button>
                                    <button type="submit" class="btn btn-primary" onclick="document.getElementById('patkey').value='<?php echo $obj->PATIENT_PATIENTCODE?>';document.getElementById('views').value='requestservice';document.getElementById('viewpages').value='patientdetails';"><i class="fa fa-thermometer"></i> Request Service</button>
                                </td>
                            </tr>
                            <?php $num++; }
                    }
                    ?>
                    </tbody>
                </table>
        </div>
    </div>
</div>