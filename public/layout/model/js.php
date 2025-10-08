<script>
    function setOnline(){
		            $.ajax({
			        type: 'POST',
					url: 'public/layout/model/updateonlinestate.php',
					dataType: 'json',
					success: function(e){
						
						},
			     });
	}

	function setRoomOn(){
		var roomid = $('#roomid').val() ;
		
		            $.ajax({
			        type: 'POST',
					url: 'public/layout/model/updateroom.php',
					data: {
                            'roomid': roomid
                          },
					dataType: 'json',
					success: function(e){
						$('#roomid').val('');
						location.reload();
						
						},
			     });
	}

	function setRoomOff(){		
		            $.ajax({
			        type: 'POST',
					url: 'public/layout/model/closeroom.php',
					dataType: 'json',
					success: function(e){
						location.reload();
						},
			     });
	}
</script>