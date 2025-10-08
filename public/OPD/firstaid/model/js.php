<script>
$(document).ready(function(e) {
    $('#save').on('click',function(){
		if($('#cancel').val().trim().length==0){
			 alert('Sorry! Field is required');
			}else{
				$('#canceldata').val($('#cancel').val());
				$('#viewpage').val('cancelrequest');
	            document.myform.submit();
				}
		})
});
</script>