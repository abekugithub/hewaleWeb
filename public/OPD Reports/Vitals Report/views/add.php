<?php $engine->msgBox($msg,$status); ?>
<div class="main-content">
    <!--<form action="" method="post" enctype="multipart/form-data" name="myform">--> 
        <input type="hidden" name="views" value="" id="views" class="form-control" />
        <input type="hidden" name="viewpages" value="" id="viewpages" class="form-control" />
        <input type="hidden" name="action_search" value="" id="action_search" class="form-control" />
	    <input type="hidden" class="form-control" id="patientnum" name="patientnum" value="<?php echo $patientnum; ?>" >
	    <input type="hidden" class="form-control" id="patientcode" name="patientcode" value="<?php echo $patientcode; ?>" >
	    <input type="hidden" class="form-control" id="faccode" name="faccode" value="<?php echo $faccode; ?>" >
    <div class="page-wrapper">
    <div class=" col-sm-4 pull-right">
                <div class="pull-right btn-group">
                    <button type="reset" onclick="document.getElementById('views').value='';document.getElementById('viewpages').value='';document.myform.submit();" class="btn btn-dark btn-square" style="margin-right: 5px"><i class="fa fa-arrow-left"></i> Back </button>
                    <button type="submit" onclick="document.getElementById('views').value='';document.getElementById('viewpages').value='save';document.myform.submit;" class="btn btn-info"> Save </button>
                </div>
            </div>
        


        <div class="page form">
            <div class="tab-content">
                <div id="personal" class="tab-pane fade in active">
                    <h3>Personal Information</h3>
                    <div class="col-sm-2">
                <div class="id-photo">
                    <img src="<?php echo((!empty($patientphoto))?$photourl:'media/img/avatar.png');?>" alt="" id="prevphoto" style="width:100% !important; margin:0px !important;">
                        <label class="btn btn-info btn-block id-container" for="image">
                        <input id="image" type="file" style="display:none;" onchange="readURL(this);" name = "image">
                        <i class="fa fa-pencil"></i> Edit &nbsp; &nbsp;</label>
                        <span class='label label-info' id="upload-file-info"></span>
                </div>
            </div>
                    <div class="col-sm-10">
                    <div class="form-group">

            </div>
            <div class="form-group">
                <div class="col-sm-4">
                    <label for="fname">First Name:</label>
                    <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $fname; ?>" required>
                </div>
                <div class="col-sm-4">
                    <label for="middlename">Middle Name:</label>
                    <input type="text" class="form-control" id="middlename" name="middlename" value="<?php echo $mname; ?>">
                </div>
                <div class="col-sm-4">
                    <label for="lastname">Last Name:</label>
                    <input type="text" class="form-control" id="lastname" name="lastname" required value="<?php echo $lname; ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-4">
                    <label for="dob">Date of Birth:</label>
<!--                    <input type="date" class="form-control" id="dob" name="dob" value="--><?php //echo $dob; ?><!--">-->
                    <div class="form-group">
                        <div class="col-sm-3" style="padding: 0 5px 0 0;">
                            <select name="dob_day" id="dob_day" class="form-control select2">
                                <option value="" selected disabled>day</option>
                                <?php foreach ($days as $value => $day){?>
                                    <option value="<?php echo $day?>" <?php echo (($dob_day == $day)?'selected':''); ?>><?php echo $day?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-5" style="padding: 0 5px 0 5px;">
                            <select name="dob_month" id="dob_month" class="form-control select2">
                                <option value="" selected disabled>month</option>
                                <?php foreach ($months as $value => $month){?>
                                <option value="<?php echo $value?>" <?php echo (($dob_month == $value)?'selected':''); ?>><?php echo $month?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-4" style="padding: 0 0 0 5px;">
                            <select name="dob_year" id="dob_year" class="form-control select2">
                                <option value="" selected disabled>year</option>
                                <?php foreach ($years as $value => $year){?>
                                    <option value="<?php echo $year?>" <?php echo (($dob_year == $year)?'selected':''); ?>><?php echo $year?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" class="form-control select2" >
                    	<option value="" selected disabled >Gender</option>
                     	<option value="M" <?php echo (($gender == 'M')?"selected":"");?>>Male</option>
                     	<option value="F" <?php echo (($gender == 'F')?"selected":"");?>>Female</option>

                  </select>

                </div>

                <div class="col-sm-4">
                    <label for="nationality">Nationality :</label>
                    <select id="nationality" name="nationality" class="form-control select2" >
                      <option value="" disabled selected>Nationality</option>
                      <?php foreach($nationalities as $nationality){ ?>
                      <option value="<?php echo $nationality->CN_NATIONALITY; ?>"
					  <?php echo (($national == $nationality->CN_NATIONALITY)?"selected":"");?>
					   ><?php echo $nationality->CN_NATIONALITY; ?></option>
                      <?php } ?>

                  </select>

                </div>

                <div class="col-sm-4">
                    <label for="residence">Country of Residence:</label>
                    <select id="residence" name="residence" class="form-control select2" >
                      <option value="" disabled selected>Country of Residence</option>
                      <?php foreach($nationalities as $nationality){ ?>
                      <option value="<?php echo $nationality->CN_COUNTRY; ?>"
					  <?php echo (($national == $nationality->CN_NATIONALITY)?"selected":"");?>
					   ><?php echo $nationality->CN_COUNTRY; ?></option>
                      <?php } ?>

                  </select>

                </div>

                <div class="col-sm-4">
                    <label for="mstatus">Marital Status:</label>
                    <select id="mstatus" name="mstatus" class="form-control select2" >
                    	<option value="" disabled selected>Marital Status</option>
                     	<option value="Single" <?php echo (($mstatus == 'Single')?"selected":"");?>>Single</option>
                     	<option value="Married" <?php echo (($mstatus == 'Married')?"selected":"");?>>Married</option>
                        <option value="Divorced" <?php echo (($mstatus == 'Divorced')?"selected":"");?>>Divorced</option>

                  </select>
                  </div>
                <div class="col-sm-4">
                    <label for="address">Address:</label>
                    <input type="text" class="form-control" id="address" name="address" value="<?php echo $address; ?>">
                </div>
            </div>
            <div class="form-group">

                <div class="col-sm-4">
                    <label for="phonenumber">Phone Number:</label>
                    <input type="tel" class="form-control" id="phonenumber" name="phonenumber" value="<?php echo $phonenumber; ?>">
                </div>
                <div class="col-sm-4">
                    <label for="altphonenumber">Alternative Phone Number:</label>
                    <input type="tel" class="form-control" id="altphonenumber" name="altphonenumber" value="<?php echo $altphonenumber; ?>">
                </div>

                <div class="col-sm-4">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
                </div>
            </div>


			</div>
                </div>
               

            </div>
        </div>
    </div>




