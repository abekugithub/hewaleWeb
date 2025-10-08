<?php
//$rs = $paging->paginate();
?>
<div class="main-content">
    <input type="hidden" class="form-control" id="patientnum" name="patientnum" value="<?php echo $patientnum; ?>" >
    <div class="page-wrapper">
        <?php $engine->msgBox($msg,$status); ?>

        <div class="btn-group pull-right">
            <div class="col-sm-4">
                <!--<button type="submit" class="btn btn-default">Submit</button>-->

                <button type="submit" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='save';document.myform.submit();" class="btn btn-info"> Save </button>

            </div>
        </div>
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#personal">1. Personal Information</a></li>
            <li><a data-toggle="tab" href="#other">2. Professional Background</a></li>
            <!--<li><a data-toggle="tab" href="#health">3. Health Info</a></li>
            <li><a data-toggle="tab" href="#family">4. Family</a></li>-->
        </ul>


        <div class="page form">
            <div class="tab-content">
                <div id="personal" class="tab-pane fade in active">
                    <h3>Personal Information</h3>
                    <div class="col-sm-2">
                        <div class="id-photo">
														<input type="hidden" class="form-control" name="image" value="<?php echo $image; ?>" />
                            <img src="<?php echo(!empty($image)?SHOST_DOCTOR_IMG_URL.DS.$image:'media/img/avatar.png');?>" alt="Dr. <?php echo $fname?>'s Photo" id="prevphoto" style="width:100% !important; margin:0px !important;" onerror="this.onerror=null;this.src='media/img/avatar.png';">
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
                                <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $fname; ?>" />
                            </div>

                            <div class="col-sm-4">
                                <label for="lastname">Last Name:</label>
                                <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $lastname; ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4">
                                <label for="dob">Date of Birth:</label>
                                <input type="date" class="form-control" id="dob" value="<?php echo $dob; ?>" name="dob">
                            </div>
                            <div class="col-sm-4">
                                <label for="gender">Gender:</label>
                                <select id="gender" name="gender" class="form-control" >
                                    <option value="" selected disabled>Gender</option>
                                    <option value="M" <?php echo (($gender == 'M')?"selected":"");?>>Male</option>
                                    <option value="F" <?php echo (($gender == 'F')?"selected":"");?>>Female</option>

                                </select>

                            </div>

                            <div class="col-sm-4">
                                <label for="nationality">Nationality :</label>
                                <select id="nationality" name="nationality" class="form-control" >
                                    <option value="" disabled selected>Nationality</option>
                                    <?php foreach($nationalities as $natl){ ?>
                                        <option value="<?php echo $natl->CN_NATIONALITY; ?>"
                                            <?php echo (($nationality == $natl->CN_NATIONALITY)?"selected":"");?>
                                        ><?php echo $natl->CN_NATIONALITY; ?></option>
                                    <?php } ?>

                                </select>

                            </div>

                            <div class="col-sm-4">
                                <label for="residence">Country of Residence:</label>
                                <select id="residence" name="residence" class="form-control" >
                                    <option value="" disabled selected>Country of Residence</option>
                                    <?php foreach($nationalities as $natl){ ?>
                                        <option value="<?php echo $natl->CN_COUNTRY; ?>"
                                            <?php echo (($residence == $natl->CN_COUNTRY)?"selected":"");?>
                                        ><?php echo $natl->CN_COUNTRY; ?></option>
                                    <?php } ?>

                                </select>

                            </div>

                            <div class="col-sm-4">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" value="<?php echo $email; ?>" id="email" name="email" />
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
                                <input type="text" class="form-control" id="address" value="<?php echo $address; ?>" name="address" />
                            </div>
                        </div>
                        <div class="form-group">

                            <div class="col-sm-4">
                                <label for="phonenumber">Phone Number:</label>
                                <input type="tel" class="form-control" id="phonenumber" value="<?php echo $phonenumber; ?>" name="phonenumber" />
                            </div>
                            <div class="col-sm-4">
                                <label for="altphonenumber">Alternative Phone Number:</label>
                                <input type="tel" class="form-control" id="altphonenumber" value="<?php echo $altphonenumber; ?>" name="altphonenumber" />
                            </div>

                            <div class="col-sm-4">
                                <label for="specialisation">Specialisation:</label>
                                <input type="text" class="form-control" value="<?php echo $specialisation; ?>" id="specialisation" name="specialisation" />
                            </div>


                        </div>


                    </div>
                </div>
                <div id="other" class="tab-pane fade">
                    <h3>Summary</h3>
                    <p>

                        <div class="col-sm-12">



                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="">
                                        <!--                        <h3>Let’s add your summary</h3>-->
                    <p>Kindly provide your medical experience, specialty, skills and achievements.</p>
                </div>
                <textarea class="ckeditor" id="ckeditor" name="summary" placeholder="Summary"><?php echo $summary; ?></textarea>
            </div>
        </div>
        <div class="form-group" style="display: none">
            <div class="col-sm-4">
                <label for="currency">Currency:</label>
                <select id="currency" name="currency" class="form-control" >
                    <option value="" disabled selected>Currency</option>
                    <?php foreach($currencies as $curr){ ?>
                        <option value="<?php echo $curr->CY_NAME; ?>"
                            <?php echo (($currency == $curr->CY_NAME)?"selected":"");?>
                        ><?php echo $curr->CY_NAME; ?></option>
                    <?php } ?>

                </select>
            </div>
            <div class="col-sm-4">
                <label for="charges">Consultation Charges:</label>
                <input type="number" class="form-control" value="<?php echo $charges; ?>" id="charges" name="charges">
            </div>

            <div class="col-sm-4">
                <label for="numbercons">Number of Consultation Per Day:</label>
                <input type="text" class="form-control" id="numbercons" name="numbercons">
            </div>

        </div>

        <!--
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
        -->
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

<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#prevphoto').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>