 <script>
	$(document).ready(function () {
        $('#addm').click(function (e) {
            e.preventDefault();
            //var alldata = $('#myform').serializeArray();
            var txtarea = $('#txtarea').val();
            var patientnum = $('#patientnum').val();
            var patientcode = $('#patientcode').val();
            var visitcode = $('#new_visitcode').val();
       
            $.ajax({
                type: 'POST',
                url: 'public/Doctors/consulatationpp/model/saveManagement.php',
                data:  {'txtarea': txtarea,'patientnum': patientnum,'patientcode': patientcode,'visitcode': visitcode},
                success: function (e) {
                    if(e.match('<tr>')){
                        $('#addManagement table tbody').html(e);

                    }

                },
                error: function (e) {

                }
            });
            $('#txtarea').val('');
        });
	
        

	});
	
	function deleteManagement(e){
		//alert('hi');
		var data = $('#myform').serializeArray();
		var patientnum = $('#patientnum').val();
		var visitcode = $('#visitcode').val();
	$.ajax({
			type: 'POST',
			url: 'public/Doctors/consulatationpp/model/deleteManagement.php',
			data: { 'keys': e,'patientnum':patientnum,'visitcode':visitcode },
			
			success: function (e) {
				if(e.match('<tr>')){
                        $('#addManagement table tbody').html(e);

                    }

                },
                error: function (e) {

                }
            });
}


</script>