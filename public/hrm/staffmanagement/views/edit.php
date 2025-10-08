<div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Add Staff Form <span class="pull-right">
                   
                     <button class ="btn btn-dark" onclick="document.getElementById('view').value='';document.myform.submit;"><i class="fa fa-arrow-left"></i> Back</button>
                    </span>
                </div>
            </div>
            <div class="col-sm-2">
                   <div class="id-photo">
                    <img src="media/uploaded/<?php echo $img;?>" alt="" id="prevphoto" style="width:100% !important; margin:0px !important;">
                        <label class="btn btn-info btn-block id-container" for="image">
                        <input id="image" type="file" style="display:none;" onchange="readURL(this);" name = "picturename">
                        <i class="fa fa-pencil"></i> Edit &nbsp; &nbsp;</label>
                        <span class='label label-info' id="upload-file-info"></span>
                        <input type="hidden" class="form-control" id="pixname" name="pixname" value="<?php echo $img;?>">
                </div>
                </div>
                <div class="col-sm-10 paddingclose">
                    <div class="form-group">
                        <h4>Personal Information</h4>
                        <div class="col-sm-12 personalinfo-info">

                            <div class="form-group">
                <div class="col-sm-4 required">
                    <label class="control-label" for="fname">First Name</label>
                    <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $fname;?>">
                </div>
                <div class="col-sm-4 required">
                    <label for="othername">Other Names</label>
                    <input type="text" class="form-control" id="othername" name="othername" value="<?php echo $othername;?>">
                </div>
                <div class="col-sm-4">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $email;?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-4">
                    <label for="phonenumber">Phone Number</label>
                    <input type="number" class="form-control" id="phonenumber" name="phonenumber" value="<?php echo $phonenumber;?>">
                </div>
                
                <div class="col-sm-4">
                    <label for="phonenumber">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="<?php echo $address;?>">
                </div>
                
                <div class="col-sm-4">
                    <label for="phonenumber">Date Of Birth</label>
                    <input type="text" class="form-control" id="date" name="startdate" value="<?php echo $startdate; ?>" >
                </div>
            </div>

            

                        </div>
                    </div>
                </div>
                
                <div class="col-sm-2">
                   
                </div>
                
                <div class="col-sm-10 paddingclose">
                    <div class="form-group">
                        <h4>Emergency Contacts</h4>
                        <div class="col-sm-12 personalinfo-info">

                            <div class="form-group ">
                <div class="col-sm-4 required">
                    <label class="control-label" for="fname">Full Name</label>
                    <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $fullname;?>">
                </div>
                <div class="col-sm-4 required">
                    <label for="othername">Contact</label>
                    <input type="text" class="form-control" id="contactno" name="contactno" value="<?php echo $contactno;?>">
                </div>
                <div class="col-sm-4">
                    <label for="email">E-mail</label>
                    <input type="email" class="form-control" id="emeremail" name="emeremail" value="<?php echo $emeremail;?>">
                </div>
            </div>
                 </div>
                    </div>
                </div>
                
                <div class="col-sm-2">
                   
                </div>
                
                <div class="col-sm-10 paddingclose">
                    <div class="form-group">
                        <h4>Job Details</h4>
                        <div class="col-sm-12 personalinfo-info">

                            <div class="form-group">
                <div class="col-sm-4 required">
                    <label class="control-label" for="fname">Date Joined</label>
                    <input type="text" class="form-control" id="enddate" name="enddate" value="<?php echo $staffjoin; ?>">
                </div>
                <div class="col-sm-4 required">
                    <label for="othername">Job Type</label>
                    
                    <select name="jobtype" id="jobtype" value="" class="form-control">
                                        <option value="<?php echo $jobcode; ?>" disabled selected><?php echo $jobcodename; ?></option>
                                        <?php  while($obj = $stmtjobcate->FetchNextObject()){ ?>
                                        <option value='<?php echo $obj->JB_CODE; ?>' <?php  echo (($obj->JB_CODE == $objany)?"selected":""); ?>><?php echo $obj->JB_NAME; ?></option>
                                        <?php } ?>
                    </select>
                    
                    
                    
                    
                    
                </div>
                <div class="col-sm-4">
                    <label for="email">Salary Grade</label>
                    
                     <select name="grade" id="grade" value="" class="form-control">
                                        <option value="<?php echo $gradecode; ?>" disabled selected><?php echo $gradename; ?></option>
                                        <?php  while($obj = $stmtgrade->FetchNextObject()){ ?>
                                        <option value='<?php echo $obj->SC_CODE; ?>' <?php  echo (($obj->SC_CODE == $objany)?"selected":""); ?>><?php echo $obj->SC_NAME; ?></option>
                                        <?php } ?>
                    </select>
                    
                   
                </div>
            </div>
            

            <div class="btn-group pull-right">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-success" onClick="document.getElementById('viewpage').value='updatestaff';document.myform.submit();"><i class="fa fa-save"></i> Submit</button>
                    
                </div>
            </div>

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
                }

                reader.readAsDataURL(input.files[0]);
            }
    }
        </script>
        
    <script type="text/javascript">
$('.clockpicker').clockpicker()
	.find('input').change(function(){
		console.log(this.value);
	});
var input = $('#single-input').clockpicker({
	placement: 'bottom',
	align: 'left',
	autoclose: true,
	'default': 'now'
});

$('.clockpicker-with-callbacks').clockpicker({
		donetext: 'Done',
		init: function() { 
			console.log("colorpicker initiated");
		},
		beforeShow: function() {
			console.log("before show");
		},
		afterShow: function() {
			console.log("after show");
		},
		beforeHide: function() {
			console.log("before hide");
		},
		afterHide: function() {
			console.log("after hide");
		},

		beforeHourSelect: function() {
			console.log("before hour selected");
		},
		afterHourSelect: function() {
			console.log("after hour selected");
		},
		beforeDone: function() {
			console.log("before done");
		},
		afterDone: function() {
			console.log("after done");
		}
	})
	.find('input').change(function(){
		console.log(this.value);
	});

// Manually toggle to the minutes view
$('#check-minutes').click(function(e){
	// Have to stop propagation here
	e.stopPropagation();
	input.clockpicker('show')
			.clockpicker('toggleView', 'minutes');
});

</script>
