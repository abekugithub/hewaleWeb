<script>
$(document).ready(function(e) {
	$('#drugid').change(function(){
		var val = $(this).val();
		$.ajax({
            type: 'POST',
            url: 'public/Pharmacy/sales/model/getPaymentMethod.php',
            data: {'val':val},
            dataType: 'json',
            success: function (e) {
                $('#paymentmethod').html(e);
            },
            error: function (e) {

            }
        });
    });
});

</script>