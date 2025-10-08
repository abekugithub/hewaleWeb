<?php $rs = $paging->paginate();?>
<div class="main-content">
    <div class="page-wrapper">
        <div class="page form">
            <?php $engine->msgBox($msg,$status); ?>
            <div class="panel-warning">
                <div class="alert alert-danger medal"></div>
            </div>
            <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper">Patient Group Registration
                    <button type="button" style="float: right;" class="btn btn-dark" onclick="document.getElementById('v').value='';document.myform.submit();"><i class="fa fa-arrow-left"></i> Back </button>
                </div>

            </div>

            <form action="" method="post" enctype="multipart/form-data" id="frmmyform" name="myform">
                <input type="hidden" name="views" value="" id="views" class="form-control" />
                <input type="hidden" name="viewpages" value="" id="viewpages" class="form-control" />
                <input type="hidden" name="key" value="<?php echo $key;?>" id="key" class="form-control" />
                <input type="hidden" name="patkey" value="<?php echo $patkey; ?>" id="patkey" class="form-control" />
                <input type="hidden" name="action_search" value="" id="action_search" class="form-control" />
                <input type="hidden" name="groupcode" value="" id="groupcode" class="form-control" />
                <input type="hidden" name="v" value="" id="v" class="form-control" />

            <div class="pagination-tab">
                <div class="table-title">
                    <div class="col-sm-2">
                        <div id="pager">
                            <?php echo $paging->renderFirst('<span class="fa fa-angle-double-left"></span>');?>
                            <?php echo $paging->renderPrev('<span class=""></span>','<span class="fa fa-arrow-circle-left"></span>');?>
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
                        <button type="button" onclick="document.getElementById('action_search').value='';document.getElementById('v').value='group';document.getElementById('viewpages').value='reset';document.myform.submit();" class="btn btn-success btn-square">
                            <i class="fa fa-refresh"></i>
                        </button>
                    </div>
                    <div class="col-sm-2">
                        <button type="button" data-toggle="modal" data-target="#Group" class="btn btn-success" onclick=""><i class="fa fa-users"></i> New Group</button>
                    </div>

                </div>
            </div>

            <table class="table table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Group Name</th>
                    <th>No. of Members</th>
                    <th>Prime Patient Name</th>
                    <th>Prime Patient Contact</th>
                    <th>Prime Patient Email</th>
<!--                    <th>Marital Status</th>-->
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
                            <td><?php echo $obj->PATGRP_NAME;?></td>
                        <td><?php echo (($obj->PATGRP_NUMBEROFPATIENT != '')?$obj->PATGRP_NUMBEROFPATIENT:'0'); ?></td>
                        <td><?php echo $obj->PATIENT_EMAIL  ; ?></td>
                        <td><?php echo $obj->PATIENT_PHONENUM; ?></td>
                        <td><?php echo $obj->PATIENT_GENDER; ?></td>
<!--                        <td>--><?php //echo $obj->PATIENT_MARITAL_STATUS; ?><!--</td>-->
                        <td><?php echo $sql->userDate($obj->PATGRP_INPUTEDDATE,'d/m/Y'); ?></td>
                        <td>
                            <button type="button" class="btn btn-primary" title="Add Patient to this Group" onclick="document.getElementById('v').value='add';document.myform.submit();"><i class="fa fa-plus-circle"></i> Add</button>
                            <button type="submit" class="btn btn-success" title="Edit Patient in this Group" onclick="document.getElementById('key').value='<?php $obj->PATGRP_CODE?>';document.getElementById('groupname').value='<?php $obj->PATGRP_CODE?>';document.getElementById('views').value='add';document.getElementById('viewpages').value='editpatient';"><i class="fa fa-pencil"></i> View</button>
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

<!--The modal below pops up the schedule window-->
<div id="Group" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Patient Group Name</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-sm-8">
                        <label for="fname">Group Name:</label>
                        <input class="form-control" id="groupname" name="groupname" placeholder="Enter Group Name" type="text" required/>
                    </div>
                    <div class="col-sm-4">
                        <label for="fname">Group Type:</label>
                        <select name="grouptype" id="grouptype" class="form-control">
<!--                            <option value="">-- Select Group --</option>-->
                            <option value="1">Family</option>
                            <option value="2">Company</option>
                        </select>
<!--                        <input class="form-control" id="groupname" name="groupname" placeholder="Enter Group Name" type="text" required/>-->
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-8">
                        &nbsp;
                        <br />
                    </div>

                    <div class="col-sm-8">
                        <button type="button" id="newgroup" class="btn btn-success btn-square" data-dismiss="modal" onclick="document.getElementById('v').value='add';/*document.myform.submit();/*document.getElementById('viewpages').value='add';*/document.myform.submit();"><i class="fa fa-check"></i> Save</button>
                        <button type="button" class="btn btn-danger btn-square" data-dismiss="modal">Cancel</button>
                    </div>

                </div>

            </div>

            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<!--End of setting the schedule pop up-->