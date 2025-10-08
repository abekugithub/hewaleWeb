<?php $engine->msgBox($msg,$status); ?>
<div class="main-content">
    <form action="" method="post" enctype="multipart/form-data" name="myform">
        <input type="hidden" name="views" value="" id="views" class="form-control" />
        <input type="hidden" name="v" value="" id="v" class="form-control" />
        <input type="hidden" name="viewpages" value="" id="viewpages" class="form-control" />
        <input type="hidden" name="action_search" value="" id="action_search" class="form-control" />
	    <input type="hidden" class="form-control" id="patientnum" name="patientnum" value="<?php echo $patientnum; ?>" >
	    <input type="hidden" class="form-control" id="patientcode" name="patientcode" value="<?php echo $patientcode; ?>" >
	    <input type="hidden" class="form-control" id="faccode" name="faccode" value="<?php echo $faccode; ?>" >
	    <input type="hidden" class="form-control" id="groupcode" name="groupcode" value="<?php echo $groupcode; ?>" >
	    <input type="hidden" class="form-control" id="groupname" name="groupname" value="<?php echo $groupname; ?>" >
    <div class="page-wrapper">
        <div class=" col-sm-4 pull-right">
            <div class="pull-right ">
                <button type="reset" onclick="document.getElementById('views').value='groupregistrationlist';document.getElementById('viewpages').value='';document.myform.submit();" class="btn btn-dark btn-square" style="margin-right: 5px"><i class="fa fa-arrow-left"></i> Back </button>
                <button type="submit" onclick="document.getElementById('views').value='groupregistrationlist';document.getElementById('viewpages').value='savegrouppatient';" class="btn btn-success"><i class="fa fa-check"></i> Save </button>
            </div>
            <div class="col-sm-6" style="position: relative;left: 60px;">
                <select name="saveoption" id="saveoption" class="form-control select2" style="width: 130px;">
                    <option value="1">Save & Add</option>
                    <option value="2">Save & Exit</option>
                </select>
            </div>
        </div>
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#personal">1. Personal Information</a></li>
            <li><a data-toggle="tab" href="#emergency">2. Emergency Contact</a></li>
            <li><a data-toggle="tab" href="#health">3. Health Info</a></li>
            <li><a data-toggle="tab" href="#patientpaymentscheme">4. Payment Scheme</a></li>
            <li><a data-toggle="tab" href="#family">5. Family</a></li>
        </ul>


        <div class="page form">
            <div class="tab-content">
                <div id="personal" class="tab-pane fade in active">
                    <h3>Personal Information</h3>
                    <div class="col-sm-2">
                <div class="id-photo">
                    <img src="<?php echo(($photourl))?$photourl:'media/img/avatar.png';?>" alt="" id="prevphoto" style="width:100% !important; margin:0px !important;">
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
                    <input type="text" class="form-control" id="fname" name="fname" required>
                </div>
                <div class="col-sm-4">
                    <label for="middlename">Middle Name:</label>
                    <input type="text" class="form-control" id="middlename" name="middlename">
                </div>
                <div class="col-sm-4">
                    <label for="lastname">Last Name:</label>
                    <input type="text" class="form-control" id="lastname" name="lastname" required>
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
                    	<option value="" selected disabled>Gender</option>
                     	<option value="M" <?php echo (($gender == 'M')?"selected":"");?>>Male</option>
                     	<option value="F" <?php echo (($gender == 'F')?"selected":"");?>>Female</option>

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
                    <label for="nationality">Nationality :</label>
                    <select id="nationality" name="nationality" class="form-control select2" >
                      <option value="" disabled selected>Nationality</option>
                      <?php foreach($nationalities as $nationality){ ?>
                      <option value="<?php echo $nationality->CN_NATIONALITY; ?>"
					  <?php //echo (('Ghanaian' == $nationality->CN_NATIONALITY)?"selected":"");?>
					   ><?php echo $nationality->CN_NATIONALITY; ?></option>
                      <?php } ?>

                  </select>

                </div>
            </div>
                        <div class="form-group">

                <div class="col-sm-4">
                    <label for="residence">Country of Residence:</label>
                    <select id="residence" name="residence" class="form-control select2" >
                      <option value="" disabled selected>Country of Residence</option>
                      <?php foreach($nationalities as $nationality){ ?>
                      <option value="<?php echo $nationality->CN_COUNTRY; ?>"
					  <?php //echo (('Ghanaian' == $nationality->CN_NATIONALITY)?"selected":"");?>
					   ><?php echo $nationality->CN_COUNTRY; ?></option>
                      <?php } ?>

                  </select>

                </div>

                            <div class="col-sm-4">
                                <label for="address">Postal Address:</label>
                                <input type="text" class="form-control" id="address" name="address" value="<?php echo $address; ?>" placeholder="P. O. Box BT 73, Comm. 2, Tema">
                            </div>

                            <div class="col-sm-4">
                                <label for="address">Residential Address:</label>
                                <input type="text" class="form-control" id="residentialaddress" name="residentialaddress" value="<?php echo $residentialaddress; ?>" placeholder="H/No. A12, A Road, Comm. 5, Tema">
                            </div>
                            <div class="col-sm-4">
                                <label for="address">Digital Address:</label>
                                <input type="text" class="form-control" id="digitaladdress" name="digitaladdress" value="<?php echo $digitaladdress; ?>" placeholder="">
                            </div>
                            <div class="col-sm-4">
                                <label for="address">National ID:</label>
                                <input type="text" class="form-control" id="nationalid" name="nationalid" value="<?php echo $nationalid; ?>" placeholder="GHA-000000000-0">
                            </div>
            </div>
            <div class="form-group">

                <div class="col-sm-4">
                    <label for="phonenumber">Phone Number:</label>
                    <input type="tel" class="form-control" id="phonenumber" name="phonenumber">
                </div>
                <div class="col-sm-4">
                    <label for="altphonenumber">Alternative Phone Number:</label>
                    <input type="tel" class="form-control" id="altphonenumber" name="altphonenumber">
                </div>

                <div class="col-sm-4">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
            </div>


			</div>
                </div>
                <div id="emergency" class="tab-pane fade">
                    <h3>Emergency Contact</h3>
                    <p>

                    <div class="col-sm-12">




            <div class="form-group">
                <div class="col-sm-4">
                    <label for="emername1">Emergency Contact Name 1:</label>
                    <input type="text" class="form-control" id="emername1" name="emername1">
                </div>
                <div class="col-sm-4">
                    <label for="emerphonenumber1">Emergency Contact Number 1:</label>
                    <input type="tel" class="form-control" id="emerphonenumber1" name="emerphonenumber1">
                </div>
                <div class="col-sm-4">
                    <label for="emeraddress1">Emergency Contact Address 1:</label>
                    <input type="text" class="form-control" id="emeraddress1" name="emeraddress1">
                </div>

            </div>
            <div class="form-group">
                <div class="col-sm-4">
                    <label for="emername2">Emergency Contact Name 2:</label>
                    <input type="text" class="form-control" id="emername2" name="emername2">
                </div>
                <div class="col-sm-4">
                    <label for="emerphonenumber2">Emergency Contact Number 2:</label>
                    <input type="tel" class="form-control" id="emerphonenumber2" name="emerphonenumber2">
                </div>
                <div class="col-sm-4">
                    <label for="emeraddress2">Emergency Contact Address 2:</label>
                    <input type="text" class="form-control" id="emeraddress2" name="emeraddress2">
                </div>

            </div>
			</div>

                    </p>
                </div>
                <div id="health" class="tab-pane fade">
                    <h3>Health Info</h3>
                    <p>
                    <div class="col-sm-12">
            <div class="form-group">
                <div class="col-sm-4">
                    <label for="bgroup">Blood Group:</label>
                    <input type="text" class="form-control" id="bgroup" name="bgroup">
                </div>
                <div class="col-sm-4">
                    <label for="allergies">Allergies:</label>
                    <input type="text" class="form-control" id="allergies" name="allergies">
                </div>
                <div class="col-sm-4">
                    <label for="conditions">Chronic Conditions:</label>
                    <input type="text" class="form-control" id="conditions" name="conditions">
                </div>
            </div>




			</div>

                    </p>
                </div>
                <!--       4. Start of Payment Scheme Tab         -->
                <div id="patientpaymentscheme" class="tab-pane fade">
                    <h3>Payment Scheme</h3>
                    <p>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="col-sm-4">
                                <label for="relation">Payment Category :</label>
                                <select name="paymentcategory" id="paymentcategory" class="form-control select2">
                                    <option value="" selected disabled> Select Payment Category </option>
                                    <?php while ($patient_paycat = $stmtpaymentcategory->FetchNextObject()){?>
                                        <option value="<?php echo $patient_paycat->PCS_CATECODE.'@@@'.$patient_paycat->PCS_CATEGORY?>"><?php echo $patient_paycat->PCS_CATEGORY?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-sm-4" id="pat_paymentschemediv">
                                <label for="relation">Payment Scheme :</label>
                                <select name="pat_paymentscheme" id="pat_paymentscheme" class="form-control select2">
                                    <option value="" selected disabled> Select Payment Scheme </option>
                                </select>
                            </div>
                            <div class="col-sm-4" style="" id="membershipnumberdiv">
                                <label for="membershipnumber">Membership Number:</label>
                                <input type="text" class="form-control" id="membershipnumber" name="membershipnumber">
                            </div>
                            <div class="col-sm-4" id="issuedatediv">
                                <label for="issuedate" id="lblfname">Date of Issue:</label>
                                <input name="issuedate" id="issuedate" class="form-control datepicker">
                            </div>
                            <div class="col-sm-4" id="expiredatediv">
                                <label for="expirydate">Expiry Date:</label>
                                <input type="text" class="form-control datepicker" id="expirydate" name="expirydate">
                            </div>
                            <div class="col-sm-4" id="startdatediv">
                                <label for="startdate">Start Date:</label>
                                <input name="startdate" id="startdate" class="form-control datepicker">
                            </div>
                            <div class="col-sm-4" id="enddatediv">
                                <label for="enddate">End Date:</label>
                                <input name="enddate" id="enddate" class="form-control datepicker">
                            </div>
                            <div class="col-sm-4" style="margin-top: 1.6em;">
                                <button type="button" class="btn btn-primary" id="addpatpayscheme">Add</button>
                            </div>
                        </div>


                    </div>
                    <div class="col-sm-12" style="margin-top: 1em;">
                        <table class="table table-responsive table-bordered" id="tblpatpaymentscheme">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Payment Category</th>
                                <th>Payment Scheme</th>
                                <th>Membership Number</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th style="width: 0">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $n = 1;
                            if ($fetchstmt){

                                while ($objscheme = $fetchstmt->FetchNextObject()){
                                    ?>
                                    <tr>
                                        <td><?php echo $n++; ?></td>
                                        <td><?php echo $objscheme->PAY_PAYMENTMETHOD; ?></td>
                                        <td><?php echo $objscheme->PAY_SCHEMENAME; ?></td>
                                        <td><?php echo $objscheme->PAY_CARDNUM; ?></td>
                                        <td><?php echo ($objscheme->PAY_STARTDT != '' && $objscheme->PAY_STARTDT != '1970-01-01')?$objscheme->PAY_STARTDT:''; ?></td>
                                        <td><?php echo ($objscheme->PAY_ENDDT != '' && $objscheme->PAY_ENDDT != '1970-01-01')?$objscheme->PAY_ENDDT:''; ?></td>
                                        <td>
                                            <button type='button' id='deletescheme' onclick='deleteScheme("<?php echo $objscheme->PAY_CODE; ?>","<?php echo $objscheme->PAY_PATIENTCODE?>");' class="btn-danger removecomplain">&times;</button>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>

                    </p>
                </div>
                <!--      End of Payment Scheme Tab          -->
                <div id="family" class="tab-pane fade">
                    <h3>Family</h3>
                    <p>
                    <div class="col-sm-12">
            <div class="form-group">

                <div class="col-sm-4">


                    <label for="relation">Relation :</label>
                    <select id="relation" name="relation" class="form-control" >
                    	<option value="" >Relation</option>
                     	<option value="Spouse" <?php echo (($relation == 'Spouse')?"selected":"");?>>Spouse</option>
                     	<option value="Child" <?php echo (($relation == 'Child')?"selected":"");?>>Child</option>

                  </select>
                </div>
                <div class="col-sm-4">
                    <label for="prnum">Patient Number:</label>
                    <input type="text" class="form-control" id="prnum" name="prnum">
                </div>
                <div class="col-sm-4">
<!--                    <label for="prnum"></label><br>-->
                    <button type="submit" id="add" class="btn btn-info" style="margin-top: 24px"> Add </button>
                </div>

            </div>

            <div class="form-group">
            <div class="col-sm-10">
                <table id="datatable" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Patient Number</th>
                      <th>Relation</th>
                      <th width="100"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                            $i=1;
							if(!empty($stmtrln)){
                               while($relation=$stmtrln->FetchNextObject()){

                                 echo '
                                    <tr>
                                       <td width="5%" align="center">'.$i++.'  </td>
                                       <td>'.$relation->NOR_NAME.'</td>
                                       <td>'.$relation->NOR_NORNUM.'</td>
                                       
									   <td width="5%" align="center">
											<button class="btn btn-xs btn-danger square" type="button"
												onclick="deleteRelation(\''.$relation->NOR_ID.'\')">
												<i class="fa fa-close"></i>
											</button>
										</td>
                                    </tr> ';

                               }
							}

                           ?>
                </tbody>
                </table>
              </div>
            </div>

			</div>
            <!--<div class="btn-group pull-right">
                <div class="col-sm-12">


                    <button type="submit" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='save';document.myform.submit;" class="btn btn-info"> Save </button>

                </div>
            </div>-->
                    </p>
                </div>
            </div>
        </div>
    </div>



</div>

