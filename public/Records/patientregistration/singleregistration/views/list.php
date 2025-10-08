<?php $rs = $paging->paginate();?>
<div class="main-content">
    <div class="page-wrapper">
        <div class="page form">
            <?php $engine->msgBox($msg,$status); ?>
            <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper">Patient Registration </div>
            </div>

            <form action="" method="post" enctype="multipart/form-data" name="myform">
                <input type="hidden" name="views" value="" id="views" class="form-control" />
                <input type="hidden" name="viewpages" value="" id="viewpages" class="form-control" />
                <input type="hidden" name="key" value="<?php echo $key;?>" id="key" class="form-control" />
                <input type="hidden" name="patkey" value="<?php echo $patkey; ?>" id="patkey" class="form-control" />
                <input type="hidden" name="action_search" value="" id="action_search" class="form-control" />
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
                    <div class="col-sm-5" style="display: inline-flex;">
                        <select name="advancesearch" id="advancesearch" class="form-control" style="width: 130px;" title="Search for all external patients">
                            <option value=""></option>
                            <option value="advance">Advance</option>
                        </select>
                        <div class="input-group">
                            <input type="text" tabindex="1" value="<?php echo $fdsearch; ?>" class="form-control square-input" name="fdsearch" placeholder="Enter Hewale Number or Patient Name to Search"/>
                            <span class="input-group-btn">
                                <button type="submit" onclick="document.getElementById('action_search').value='search';document.getElementById('viewpage').value='';document.myform.submit;" class="btn btn-default btn-gyn-search"> <i class="fa fa-search"></i> </button>
                            </span>
                        </div>
                    </div>
<!--                    <div class="col-sm-1">-->
<!--                    </div>-->
                    <div class="col-sm-4 pull-right">
                        <button style="margin-left:10px" type="submit" style="" onclick="document.getElementById('action_search').value='';document.getElementById('view').value='';document.getElementById('viewpages').value='reset';document.myform.submit;" class="btn btn-success btn-square">
                            <i class="fa fa-refresh"></i>
                        </button>
                        <span style="margin-left:40px">
                        <button type="submit" class="btn btn-primary" onclick="document.getElementById('views').value='add';document.myform.submit();"><i class="fa fa-user-plus"></i> Single </button>

                        <button type="button" class="btn btn-primary" onclick="document.getElementById('views').value='groupregistrationlist';document.getElementById('viewpages').value='groupregistrationlist';document.myform.submit();"><i class="fa fa-users"></i> Group</button>

                        <button type="submit" class="btn btn-primary" onclick="document.getElementById('views').value='upload';document.myform.submit();"><i class="fa fa-upload"></i> Upload </button>
                        </span>
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
                            <button type="submit" class="btn btn-primary" onclick="document.getElementById('patkey').value='<?php echo $obj->PATIENT_PATIENTCODE?>';document.getElementById('views').value='';document.getElementById('viewpages').value='';" title="Print Patient Card"><i class="fa fa-print"></i> Print</button>
                        </td>
                    </tr>
                <?php $num++; }
                }else{
                    ?>
                    <td colspan="5"><?php echo "No Search Record found!"; ?></td>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>