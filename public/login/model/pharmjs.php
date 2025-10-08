<script>
    $('#pharm').click(function (e) {
		e.preventDefault();
		var process = true;
        var data = $('#pharmForm').serializeArray();
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
            url: 'public/login/model/pharmsave.php',
            data: data,
            success: function (e) {
                $('#msg').val(e.toString());
                document.querySelector(swal("Success!", e.toString(), "success"));
            },
            error: function (e) {
				document.querySelector(swal("Error!", e.toString(), "error"));
            }
        });
        closeMod('pharmReg');
        closeMod('signUp');
    });
</script>