<div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Add Agent Form <span class="pull-right">
                   
                    <button onclick="document.getElementById('view').value='';document.myform.submit;">&times;</button>
                    </span>
                </div>
            </div>
            <div class="col-sm-2">
                   <div class="id-photo">
                    <img src="<?php echo(($photourl))?$photourl:'media/img/avatar.png';?>" alt="" id="prevphoto" style="width:100% !important; margin:0px !important;">
                        <label class="btn btn-info btn-block id-container" for="image">
                        <input id="image" type="file" style="display:none;" onchange="readURL(this);" name = "picturename">
                        <i class="fa fa-pencil"></i> Edit &nbsp; &nbsp;</label>
                        <span class='label label-info' id="upload-file-info"></span>
                </div>
                </div>
                <div class="col-sm-10 paddingclose">
                    <div class="form-group">
                        <div class="moduletitleupper">Personal Information </div>
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
                    <input type="text" class="form-control" id="date" name="startdate" >
                </div>
            </div>

            <div class="btn-group pull-right">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-success" onClick="document.getElementById('viewpage').value='insertagent';document.linkform.submit();"><i class="fa fa-save"></i> Submit</button>
                    
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
