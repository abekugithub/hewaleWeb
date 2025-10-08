<?php //$rs = $paging->paginate();?>
<div class="main-content">
    <div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Nurse Details <span class="pull-right">
                    <button class="btn btn-dark" onclick="document.getElementById('view').value='';document.myform.submit;"><i class="fa fa-arrow-left"></i> Back</button>
                    </span>
                </div>
            </div>
            <?php $n = 1;?>
            <div class="col-sm-12 paddingclose personalinfo">
                <div class="col-sm-2">
                    <div class="id-photo">
                        <img src="<?php echo(($patientphoto))?$patientphoto:'media/img/avatar.png';?>" alt="" id="prevphoto" style="width:100% !important; margin:0px !important;">
                    </div>
                </div>
                <input type="hidden" name="nursename" id="nursename" class="" value="<?php echo $nursename;?>">
                <div class="col-sm-10 paddingclose">
                    <div class="form-group">
                        <div class="moduletitleupper">Personal Information </div>
                        <div class="col-sm-12 personalinfo-info">

                            <table class="table personalinfo-table">
                                <tr>
                                    <td><b>Name:</b> <?php echo $nursename;?></td>
                                    <td><b>Licensing PIN:</b> <?php echo $nurselicense;?></td>
                                    <td><b>Blood Group:</b> <?php echo $patientbloodgrp;?></td>
                                </tr>
                                <tr>
                                    <td><b>Email:</b> <?php echo $nurseemail;?></td>
                                    <td><b>Phone Number:</b> <?php echo $nursephone;?></td>
                                    <td><b>Height:</b> <?php echo $patientheight;?></td>
                                </tr>
                                <tr>
                                    <td><b>Hospital of practice:</b> <?php echo $nurseplaceofpractice;?></td>
                                    <td><b>Marital Status:</b> <?php echo $nursemaritalstatus;?></td>
                                    <td><b>Weight:</b> <?php echo $patientweight;?></td>
                                </tr>
                                <tr>
                                    <td><b>Date Of Birth:</b> <?php echo $nursedob; //$patientbloodgrp;?></td>
                                    <td><b>Gender:</b> <?php echo $nursegender;?></td>
<!--                                    <td><b>Nationality:</b> --><?php //echo $patientnation;?><!--</td>-->
                                </tr>
                            </table>
                            <div>
                                <b>Summary:</b> <?php echo $nursesummary;?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="moduletitle">&nbsp;</div>
            <div class="pull-right">
                <button type="submit" class="btn btn-default" onclick="document.getElementById('viewpage').value='savenurserequest';document.getElementById('view').value='';document.getElementById('keys').value='<?php echo $nursecode; ?>';document.getElementById('nursename').value='<?php echo $nursename; ?>';document.myform.submit();"><i class="fa fa-user-plus"></i> Add Nurse</button>
            </div>
        </div>
    </div>

</div>