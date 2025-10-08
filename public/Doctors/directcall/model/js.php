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
		   var mychat = $('#chatmsg').val();
		   if(mychat.length > 0){
		   //html = '<div class="speech-bubble-rt"><div class="speech-bubble-rt speech-bubble-right">'+mychat+'</div></div>';
		   //$('#chatareaindoc').append(html);
		   //$('#chatmsg').val('');
		  // mychat = '';
		   }
		   
		$('#chatareaindoc').scrollTop($('#chatareaindoc')[0].scrollHeight);
				 
		   $.ajax({
			        type: 'POST',
					url: 'public/Doctors/consulatationpp/model/addchat.php',
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

	    /*
		 * Start chat population module here
		 *
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


//Count down of character left in textarea
$('#refnote').keyup(function() {
    var maxLength = 160;
    var length = $(this).val().length;
    var length = maxLength-length;
    $('#chars').text(length);

});


    //Counts the number of characters in the textarea
    $('.chatmsgcount').keyup(function () { 
        var charleng = $(this).val().length;
        var messagecount = 0;
        $('.characters-count>digit').html(charleng);
        messagecount = charleng / 160;
        $('.messages-count>digit').html(Math.ceil(messagecount));
    });
     
    });



    /* Function to populate table by clicking add*/
    function addvitals(){ 
        if( !$('#vitals-value').val()){
            document.querySelector(swal("Ooops!", "Please fill all fields to proceed...Thank you", "error"));
            return;
        }else{
        var line='<tr id="tabtn' + x++ + '"><td>' + i++ + '</td><td>'+ $('#vitals-type').val()+'</td><td>'+ $('#vitals-value').val()+'</td><td><div class="btn-group"><button type="button" class="btn btn-danger" onClick="tabtn(' + s++ + ')"><i class="fa fa-close"></i></button></div></td></tr>';
        $('#vitalsdata').append(line);
    
        }
        $('#vitals-value').val('');
        $('#vitals-type').val('');
    }

    /* Remove Button Functions */
    function tabtn(x){ 
        $('#tabtn'+x).remove();
    }

    function saveVitals(){ 
    var arr = $('form').serializeArray();

    $('#loading').show(); 
    var arr=[];
    $('#vitalsdata').find('tr').each(function(){
      var data=[];
      var vitaltypes = $(this).children('td').eq(1);
      var vitalvalues = $(this).children('td').eq(2); 
      data.push(vitaltypes.html(),vitalvalues.html());
      arr.push(data);
    }); 

    document.getElementById('viewpage').value='savevitals';
    var doc = $.merge([],arr);
    var datax = JSON.stringify(doc);
    document.getElementById('data').value=datax ;
    $('form').submit(); 
    return
  }

 
  function openFullscreen(){
        var elem = document.getElementById("callerVideo"); 

        if (elem.requestFullscreen) {
            elem.requestFullscreen();
            } else if (elem.mozRequestFullScreen) { // Firefox 
            elem.mozRequestFullScreen();
            } else if (elem.webkitRequestFullscreen) { // Chrome, Safari and Opera 
            elem.webkitRequestFullscreen();
            } else if (elem.msRequestFullscreen) { // IE/Edge 
            elem.msRequestFullscreen();
            }
    }  

</script>