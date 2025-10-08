<?php $engine->msgBox($msg,$status); ?>
<div class="main-content">
    <div class="page-wrapper">
            <div class="page form">
                <form action="" method="post" enctype="multipart/form-data" name="myform">
                    <input type="hidden" name="views" value="" id="views" class="form-control" />
                    <input type="hidden" name="viewpages" value="" id="viewpages" class="form-control" />
                    <input type="hidden" name="action_search" value="" id="action_search" class="form-control" />
                    <input type="hidden" name="key" value="<?php echo $key; ?>" id="key" class="form-control" />
                    <input type="hidden" name="patkey" value="<?php echo $patkey; ?>" id="patkey" class="form-control" />
                    <input type="hidden" class="form-control" id="patientnum" name="patientnum" value="<?php echo $patientnum; ?>" >
                    <input type="hidden" class="form-control" id="patientcode" name="patientcode" value="<?php echo $patientcode; ?>" >
                     <input type="hidden" class="form-control" id="requestcode" name="requestcode" value="<?php echo $requestcode; ?>" >
                <div class="col-sm-3 pull-right" >
                <button type="button" onclick="document.getElementById('views').value='';document.getElementById('viewpage').value='';document.myform.submit();" class="btn btn-dark btn-square "><i class="fa fa-undo"></i> Return </button>
				                <button type="button" class="btn btn-success" onclick="document.getElementById('views').value='requestqueue';document.getElementById('viewpages').value='saveservicerequestqueue';document.myform.submit();"><i class="fa fa-check"></i> Request</button>
				          <!--        <button type="button" class="btn btn-primary pull-right" onclick="document.getElementById('views').value='';document.getElementById('viewpages').value='saveservicerequest';document.myform.submit();"><i class="fa fa-arrow-right"></i> Next</button>
				                 <button type="button" onclick="document.getElementById('views').value='';document.getElementById('viewpage').value='';document.myform.submit();" class="btn btn-primary btn-square pull-right"><i class="fa fa-arrow-left"></i> Previous </button>
				                 -->
				                
            </div>
            
            <div class="col-sm-3 pull-right" id="doctordiv">
                    <select name="$prescribedoc" id="$prescribedoc" class="form-control select2">
                        <option value="" selected disabled>-- Select Prescriber --</option>
                        <?php while ($prescriber= $stmtprescriber->FetchNextObject()){?>
                            <option value="<?php echo $prescriber->USR_CODE.'@@@'.$prescriber->USR_FULLNAME?>"><?php echo $prescriber->USR_FULLNAME .' '.(($prescriber->USR_ONLINE_STATUS=='1')?"(Available)":"(Unavailable)")?></option>
                        <?php } ?>
                    </select>
                </div>
            <div class="col-sm-3 pull-right" id="prescriberdiv">
                    <select name="prescribe" id="prescribe" class="form-control select2">
                        <option value="" selected disabled>-- Select Department --</option>
                        <?php while ($department= $stmtdepartments->FetchNextObject()){?>
                            <option value="<?php echo $department->ST_DEPT.'@@@'.$department->ST_DEPTNAME?>"><?php echo $department->ST_DEPTNAME?></option>
                        <?php } ?>
                    </select>
                </div>
				 <div class="col-sm-2 pull-right">
                    <select name="service" id="service" class="form-control select2">
                        <option value="" selected disabled>-- Select  Service --</option>
                        <?php
                        while ($servicerequest = $stmtservcie->FetchNextObject()){?>
                            <option value="<?php echo $servicerequest->ST_SERVICE.'@@@'.$servicerequest->ST_SERVICENAME; ?>"><?php echo $servicerequest->ST_SERVICENAME; ?></option>
                        <?php } 
                        ?>
                    </select>
                </div>

                <div class="moduletitle">
                    <div class="moduletitleupper">Request Service</div>
                </div>
            <div class="col-sm-12 paddingclose personalinfo">
                <div class="col-sm-2">
                    <div class="id-photo">
                        <img src="<?php echo(($patientphoto))?$patientphoto:'media/img/avatar.png';?>" alt="" id="prevphoto" style="width:100% !important; margin:0px !important;">
                    </div>
<!--                    <div class="" style="margin-top: 10px;">-->
<!--                        <span><b>Patient Number:</b></span>-->
<!--                    </div>-->
                </div>
                <div class="col-sm-8 paddingclose">
                    <div class="form-group">
                        <div class="moduletitleupper">Patient Information </div>
                        <div class="col-sm-12 personalinfo-info">

                            <table class="table personalinfo-table">
                                <tr>
                                    <td><b>Patient Number:</b> <?php echo $patientnum;?></td>
                                    <td><b>Name:</b> <?php echo $patient_fullname;?></td>
                                    <td><b>Age:</b> <?php echo $patientdob;?></td>
                                </tr>
                                <tr>
                                    <td><b>Blood Group:</b> <?php echo $patientbloodgrp;?></td>
                                    <td><b>Height:</b> <?php echo $patientheight;?></td>
                                    <td><b>Weight:</b> <?php echo $patientweight;?></td>
                                </tr>
                                <tr>
                                    <td><b>Phone Number:</b> <?php echo $patientphonenum;?></td>

                                </tr>
                            </table>

                        </div>
                    </div>
                </div>
                
             

           <!--  <div class="form-group">
                <div class="col-sm-4">
                    <label for="fname">Payment Scheme:</label>
                    <select name="paymentscheme" id="paymentscheme" class="form-control select2">
                        <option value="" selected disabled>-- Select Payment Scheme --</option>
                        
                    </select>
                </div>
                
              <!--    <div class="col-sm-4" style="" id="cardnum">
                    <label for="lastname">Card Number:</label>
                    <input type="text" class="form-control" id="cardnumber" name="cardnumber" required>
                </div>
                <div class="col-sm-4" id="cardexpire">
                    <label for="lastname">Card Expiry Date:</label>
                    <input type="text" class="form-control" id="cardexpirydate" name="cardexpirydate" required>
                </div>-->
                
             </div> -->
          <!--  <div class="col-sm-12" style="margin-top: 10px">
                <button type="button" class="btn btn-success" onclick="document.getElementById('views').value='';document.getElementById('viewpages').value='saveservicerequest';document.myform.submit();"><i class="fa fa-save"></i> Save</button>
                <button type="submit" class="btn btn-danger"><i class="fa fa-close"></i> Cancel</button>
            </div> -->
        </div>
    </div>



</div>

