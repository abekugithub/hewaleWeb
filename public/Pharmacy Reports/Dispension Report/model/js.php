 <script>
	$(document).ready(function () {
		
        //$('#addm').click(function (e) {
			//alert('hi');
            //e.preventDefault();
            var data = $('#myform').serializeArray();
			
            $.ajax({
                type: 'POST',
                url: 'public/Pharmacy Reports/Dispension Report/model/fetch.php',
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
	



</script>