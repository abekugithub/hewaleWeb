<script>

 $('#vitalpost').click(function (e) {
        var process = true;
        var data = $('#VitalsForm').serializeArray();
        data.forEach(function(element) {
            if (element.value==""){
                document.querySelector(swal("Ooops!", "Please fill all fields to proceed...Thank you", "error"));
                process = false;
            };
        }, this);
        if (!process){
            return;
        }
        $.ajax({
            type: 'POST',
            url: 'public/login/model/savevitalspost.php',
            data: data,
            success: function (e) {
                $('#msg').val(e.toString());
                document.querySelector(swal("Success!", e.toString(), "success"));
				$('#vitalspost').find('input').val('');
            },
            error: function (e) {
                document.querySelector(swal("Error!", e.toString(), "error"));
            }
        });
        closeMod('docReg');
        closeMod('signUp');
    });
	// saving of doctor
    $('#doctor').click(function (e) {
        var process = true;
        var data = $('#doctorForm').serializeArray();
        data.forEach(function(element) {
            if (element.value==""){
                document.querySelector(swal("Ooops!", "Please fill all fields to proceed...Thank you", "error"));
                process = false;
            };
        }, this);
        if (!process){
            return;
        }
        $.ajax({
            type: 'POST',
            url: 'public/login/model/savedoctor.php',
            data: data,
            success: function (e) {
                $('#msg').val(e.toString());
                document.querySelector(swal("Success!", e.toString(), "success"));
            },
            error: function (e) {
                document.querySelector(swal("Error!", e.toString(), "error"));
            }
        });
        closeMod('docReg');
        closeMod('signUp');
    });
	
	$('#labs').click(function (e) {
		var process = true;
        var data = $('#labforms').serializeArray();
		 data.forEach(function(element) {
        if (element.value==""){
            document.querySelector(swal("Ooops!", "Please fill all fields to proceed...Thank you", "error"));
            process = false;
        };  
        }, this);
        if (!process){
            return;
        }
        $.ajax({
            type: 'POST',
            url: 'public/login/model/reglabs.php',
            data: data,
            success: function (e) {
				
                $('#msg').val(e.toString());
                document.querySelector(swal("Success!", e.toString(), "success"));
            },
            error: function (e) {
				document.querySelector(swal("Error!", e.toString(), "error"));
            }
        });
        closeMod('labReg');
        closeMod('signUp');
    });

   $('#save-hospital').click(function (e) {
        var process = true;
        var data = $('#hospitalform').serializeArray();
        data.forEach(function(element) {
        if (element.value==""){
            document.querySelector(swal("Ooops!", "Please fill all fields to proceed...Thank you", "error"));
            process = false;
        };  
        }, this);
        if (!process){
            return;
        }
        $.ajax({
            type: 'POST',
            url: 'public/login/model/savehospital.php',
            data: data,
            success: function (e) {
                $('#msg').val(e.toString());
                 document.querySelector(swal("Success!", e.toString(), "success"));
            },
            error: function (e) {
                document.querySelector(swal("Error!", e.toString(), "error"));
            }
        });
        closeMod('hospitalReg');
        closeMod('signUp');
    });
	
	
	$('#save-courier').click(function (e) {
        var process = true;
        var data = $('#courierform').serializeArray();
        data.forEach(function(element) {
        if (element.value==""){
            document.querySelector(swal("Ooops!", "Please fill all fields to proceed...Thank you", "error"));
            process = false;
        };  
        }, this);
        if (!process){
            return;
        }
        $.ajax({
            type: 'POST',
            url: 'public/login/model/couriersave.php',
            data: data,
            success: function (e) {
                $('#msg').val(e.toString());
                 document.querySelector(swal("Success!", e.toString(), "success"));
            },
            error: function (e) {
                document.querySelector(swal("Error!", e.toString(), "error"));
            }
        });
        closeMod('courierform');
        closeMod('signUp');
    });


	$('#fac_type').change(function (e) {
        e.preventDefault();
        if ($(this).val() == '2'){
            $('#labname').attr('placeholder','X-ray Name');
        }else{
            $('#labname').attr('placeholder','Laboratory Name');
        }
    })
	
	


</script>