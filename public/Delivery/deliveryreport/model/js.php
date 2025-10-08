 <script>
	$(document).ready(function () {
		
        //$('#addm').click(function (e) {
			//alert('hi');
            //e.preventDefault();
            var data = $('#myform').serializeArray();
			//var grkeys=$('#grkeys').val();
            $.ajax({
                type: 'POST',
                url: 'public/Delivery/deliveryreport/model/fetch.php',
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