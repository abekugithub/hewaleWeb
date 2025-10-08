 <script>
	$(document).ready(function () {
		
        //$('#addm').click(function (e) {
			//alert('hi');
            //e.preventDefault();
            var data = $('#myform').serializeArray();
			
            $.ajax({
                type: 'POST',
                url: 'public/OPD Reports/Patient Registration Report/model/fetch.php',
                data: data,
                success: function (e) {
                    if(e.match('<tr>')){
                        $('.report-content').html(e);

                    }

                },
                error: function (e) {

                }
            });
           
        });
	
        

	//});
	
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