<!--
Developer: Ake Sylvain
Project Module: Supplies
@Orcons Systems
-->
<script type="text/javascript">	
	
$(document).ready(function(e) {

	//Start insersion of stock supplies
	$('#addstock').on('click',function(e){
		var stock = $('#stock').val();
		var qtity = $('#qtity').val();
		var batchcode = $('#batchcode').val();
		var suppcode = $('#suppcode').val();
		var enddate = $('#enddate').val();
		
		if(stock == '' || qtity == '' || batchcode == '' || suppcode == ''){
			//$('#errormsg2').show();
		}else{
			var data = $("form").serializeArray();
			$.ajax({
				   type:'POST',
				   url:"public/Stock/supplies/model/addstock.php",
				   data: data,
				   success: function(e){
					// if(e.match('<tr id="">')){
					$('#stockadded').html(e);
					$('#noncontent').find('input,textarea,select').val('');	
					$('select').change();
					$('#errormsg2').hide();
					$('#successmsg2').show(); 
					$('#successmsg2').hide(8000); 
					// }
					},
				  });
			
			//$('#newMsg').hide();
			
			 }
				
	});
	//End insertion of supply details
	
	
		//Start insersion of stock supplies
	$('#addeditedstock').on('click',function(e){
		var stock = $('#stock').val();
		var qtity = $('#qtity').val();
		var batchcode = $('#batchcode').val();
		var suppcode = $('#suppcode').val();
		var enddate = $('#enddate').val();
		
		if(stock == '' || qtity == '' || batchcode == '' || suppcode == ''){
			//$('#errormsg2').show();
		}else{
			var data = $("form").serializeArray();
			$.ajax({
				   type:'POST',
				   url:"public/Stock/supplies/model/addeditedstock.php",
				   data: data,
				   success: function(e){
					// if(e.match('<tr id="">')){
					$('#stockadded').html(e);
					$('#noncontent').find('input,textarea,select').val('');	
					$('select').change();
					$('#errormsg2').hide();
					$('#successmsg2').show(); 
					$('#successmsg2').hide(8000); 
					// }
					},
				  });
			
			//$('#newMsg').hide();
			
			 }
				
	});
	//End insertion of supply details
	
   $(document).on('click', ".deleterow", function (e) {
	     var supid = $('#suppcode').val();
		 var rowid = $(this).closest('tr').attr('id');
		if(confirm("Are you sure you want to delete?")){		   
	     	$.ajax({
				   type:'POST',
				   url:"public/Stock/supplies/model/deletestock.php?rowrecord="+rowid+"&suppcode="+supid,
				   success: function(e){
					$('#stockadded').html(e);
					},
				  });
	}		 
	});
	
	
	$(document).on('click', ".recallrow", function (e) {
	     var supid = $('#suppcode').val();
		 var rowid = $(this).closest('tr').attr('id');
		if(confirm("Recall will remove the stock and reduce stock level.\n Do you want to proceed?")){		   
	     	$.ajax({
				   type:'POST',
				   dataType:'json',
				   url:"public/Stock/supplies/model/recallstock.php?rowrecord="+rowid+"&suppcode="+supid,
				   success: function(e){
					   if(e.data1 == 1){
					     var wrongstock = "Recall Failed. Stock is lower than supply value.";
						$('#recallfail').html(wrongstock);
						$('#recallfail').show();
					   }
					$('#stockadded').html(e.data2);
					},
				  });
	}		 
	});

		 
});
</script>