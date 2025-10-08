<script>
    var i =1; var x =1; var s =1;

 $(document).ready(function(e){
        /* Disable Autofill for all Inputs */
        $('input').attr('autocomplete', 'off');
		
		$('#chatareaindoc').scrollTop($('#chatareaindoc')[0].scrollHeight);
		/*
		 * Start chat insertion module here
		 * Parameter send::@ChatMsg
		 * By: Acker
		 */
		$('.submitchat').click(function(e){
		   var data = $('form').serializeArray();
		   
		   var html;
		   var mychat = $('.chatmsg').val();
		   /*if(mychat.length > 0){
		   html = '<div class="speech-bubble-rt"><div class="speech-bubble-rt speech-bubble-right">'+mychat+'</div></div>';
		   $('#chatareaindoc').append(html);
		   $('#chatmsg').val('');
		   mychat = '';
		   }*/
		   $('#chatareaindoc').scrollTop($('#chatareaindoc')[0].scrollHeight);
						 
		   $.ajax({
			        type: 'POST',
					url: 'public/Doctors/quickconsult/model/addchat.php',
					data: data,
					success: function(e){
						$('.chatmsg').val('');
						mychat = '';
					},
			     });
		   
		});
		/*
		 * End chat insertion
		 */

 /*Check easyrtcid*/
      setInterval( function() {
			var patientcode = $('#patientcode').val();
        $.ajax({
            type: 'POST',
            url: 'public/Doctors/quickconsult/model/getneweasyrtcid.php',
            dataType: 'json',
            data: {"patientcode":patientcode},
            success: function(e){
               //console.log(e.patienteasycode);
               $('#easyrtcid').val(e.patienteasycode) ;
            },
        });
        }, 3000);

		 /*End checking the easyrtcid*/

	    /*
		 * Start chat population module here
		 *
		 */
/*
         setInterval( function() {
		 var senderid = $('#sendercode').val();
		 var patientcode = $('#patientcode').val();
		            $.ajax({
			        type: 'POST',
					url: 'public/Doctors/quickconsult/model/fetchchat.php',
					dataType: 'json',
					data: {"senderid":senderid,"patientcode":patientcode},
					success: function(e){ 
					
					var mychat = e.chatmsg;
					
					var html;
					
					if(mychat.length > 0){
		            html = '<div class="speech-bubble-lt"><div class="speech-bubble-lt speech-bubble-left">'+mychat+'</div></div>';
		             $('#chatareaindoc').append(html);
					}
					$('#chatareaindoc').scrollTop($('#chatareaindoc')[0].scrollHeight);
					
					},
			     });
		 
		 
		  }, 2000);
*/

	    /*
		 * End chat population
		 */

		//Counts the number of characters in the textarea
	    $('.chatmsgcount').keyup(function () { 
        var charleng = $(this).val().length;
        var messagecount = 0;
        $('.characters-count>digit').html(charleng);
        messagecount = charleng / 160;
        $('.messages-count>digit').html(Math.ceil(messagecount));
        });

    });

    /* Remove Button Functions */
  

</script>