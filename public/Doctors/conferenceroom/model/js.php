<script >
    var i =1; var x =1; var s =1;
    $(document).ready(function(e){
	
        /* Disable Autofill for all Inputs */
        $('input').attr('autocomplete', 'off');
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
    /* Function to populate table by clicking add*/
    function addparticipant(){ 
       
        var participantid = $('#conf_participant').val();
        var confcode = $('#confcode').val();
        $.ajax({
            type: 'POST',
            url: 'public/Doctors/conferenceroom/model/saveparticipant.php',
            data: {'participantid':participantid,'confcode':confcode},
            success: function (e) {
               if(e.match('<tr>')){ 
                    $('#listparticipant table tbody').append(e);
               }
             
            },
            error: function (e) {
                console.log(e)
            }
        });
    }

 
    function deleteparticipant(participantid){
        var confcode = $('#confcode').val();
        $.ajax({
            type: 'POST',
            url: 'public/Doctors/conferenceroom/model/deleteparticipant.php',
            data: {'participantid':participantid,'confcode':confcode},
            success: function (e) {
               // alert("there is no error")
                    $('#listparticipant table tbody').html(e);
             
             
            },
            error: function (e) {
                console.log(e)
            }
        });

    }

    /* Remove Button Functions */
    function tabtn(x){ 
        $('#tabtn'+x).remove();
       
    }
    function saveVitals(){ 
    var arr = $('form').serializeArray();
	var patientcode = $('#patientcode').val();
	var patientno = $('#patientno').val();
	var visitcode = $('#visitcod').val();
	var dateadded = $('#dateadded').val();
    var arr = $('form').serializeArray()
    $('#loading').show(); 
    var patient = $('#patient').val();
    var reqdate = $('#reqdate').val();
    var doctor = $('#doctor').val();
    var paymenttype = $('#paymenttype').val();
    var servicename = $('#servicename').val();
	
    var arr=[];
	
	
    $('#vitalsdata').find('tr').each(function(){
      var data=[];
      var vitaltypes = $(this).children('td').eq(1);
      var vitalvalues = $(this).children('td').eq(2); 

      data.push(vitaltypes.html(),vitalvalues.html(),visitcode,dateadded,patientcode,patientno);
      arr.push(data);
      /*data.push(patient.html(),reqdate.html(),doctor.html(),paymenttype.html(),servicename.html(),vitaltypes.html(),vitalvalues.html());
      arr.push(data);*/
    }); 
    document.getElementById('viewpage').value='savevitals';
    var datax = JSON.stringify(arr);
    document.getElementById('data').value=datax ;
    $('form').submit(); 
    return
  }

</script>