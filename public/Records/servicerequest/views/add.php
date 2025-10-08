<?php $engine->msgBox($msg,$status); ?>
<div class="main-content">
    <form action="" method="post" enctype="multipart/form-data" name="myform">
        <input type="hidden" name="views" value="" id="views" class="form-control" />
        <input type="hidden" name="viewpage" value="" id="viewpage" class="form-control" />
        <input type="hidden" name="action_search" value="" id="action_search" class="form-control" />
	    <input type="hidden" class="form-control" id="patientnum" name="patientnum" value="<?php echo $patientnum; ?>" >
    <div class="page-wrapper">
    <div class=" col-sm-4 pull-right">
                <div class="pull-right btn-group">
                    <button type="submit" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit();" class="btn btn-dark btn-square" style="margin-right: 5px"><i class="fa fa-arrow-left"></i> Back </button>
                    <button type="submit" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='save';document.myform.submit;" class="btn btn-success"><i class="fa fa-check"></i> Save </button>
                </div>
            </div>
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#personal">1. Personal Information</a></li>
            <li><a data-toggle="tab" href="#emergency">2. Emergency Contact</a></li>
            <li><a data-toggle="tab" href="#health">3. Health Info</a></li>
            <li><a data-toggle="tab" href="#family">4. Family</a></li>
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
                    <input type="date" class="form-control" id="dob" name="dob">
                </div>
                <div class="col-sm-4">
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" class="form-control" >
                    	<option value="" >Gender</option>
                     	<option value="M" <?php echo (($gender == 'M')?"selected":"");?>>Male</option>
                     	<option value="F" <?php echo (($gender == 'F')?"selected":"");?>>Female</option>

                  </select>

                </div>

                <div class="col-sm-4">
                    <label for="nationality">Nationality :</label>
                    <select id="nationality" name="nationality" class="form-control" >
                      <option value="" disabled selected>Nationality</option>
                      <?php foreach($nationalities as $nationality){ ?>
                      <option value="<?php echo $nationality->CN_NATIONALITY; ?>"
					  <?php //echo (('Ghanaian' == $nationality->CN_NATIONALITY)?"selected":"");?>
					   ><?php echo $nationality->CN_NATIONALITY; ?></option>
                      <?php } ?>

                  </select>

                </div>

                <div class="col-sm-4">
                    <label for="residence">Country of Residence:</label>
                    <select id="residence" name="residence" class="form-control" >
                      <option value="" disabled selected>Country of Residence</option>
                      <?php foreach($nationalities as $nationality){ ?>
                      <option value="<?php echo $nationality->CN_COUNTRY; ?>"
					  <?php //echo (('Ghanaian' == $nationality->CN_NATIONALITY)?"selected":"");?>
					   ><?php echo $nationality->CN_COUNTRY; ?></option>
                      <?php } ?>

                  </select>

                </div>

                <div class="col-sm-4">
                    <label for="mstatus">Marital Status:</label>
                    <select id="mstatus" name="mstatus" class="form-control" >
                    	<option value="" disabled selected>Marital Status</option>
                     	<option value="Single" <?php echo (($mstatus == 'Single')?"selected":"");?>>Single</option>
                     	<option value="Married" <?php echo (($mstatus == 'Married')?"selected":"");?>>Married</option>
                        <option value="Divorced" <?php echo (($mstatus == 'Divorced')?"selected":"");?>>Divorced</option>

                  </select>
                  </div>
                <div class="col-sm-4">
                    <label for="address">Address:</label>
                    <input type="text" class="form-control" id="address" name="address">
                </div>
            </div>
            <div class="form-group">

                <div class="col-sm-4">
                    <label for="phonenumber">Phone Number:</label>
                    <input type="number" class="form-control" id="phonenumber" name="phonenumber">
                </div>
                <div class="col-sm-4">
                    <label for="altphonenumber">Alternative Phone Number:</label>
                    <input type="number" class="form-control" id="altphonenumber" name="altphonenumber">
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
                    <input type="number" class="form-control" id="emerphonenumber1" name="emerphonenumber1">
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
                    <input type="number" class="form-control" id="emerphonenumber2" name="emerphonenumber2">
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

                    <button type="submit" id="add" class="btn btn-info"> Add </button>
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

