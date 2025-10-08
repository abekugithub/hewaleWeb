<script>
    var i =1; var x =1; var s =1;
    $(document).ready(function(e){
        /* Disable Autofill for all Inputs */
        $('input').attr('autocomplete', 'off');
    });
    /* Function to populate table by clicking add*/
    function addvitals(){ 
        if( !$('#vitals-value').val()){
            document.querySelector(swal("Ooops!", "Please fill all fields to proceed...Thank you", "error"));
            return;
        }else{
        var line='<tr id="tabtn' + x++ + '"><td>' + i++ + '</td><td>'+ $('#vitals_type').val()+'</td><td>'+ $('#vitals-value').val()+'</td><td><div class="btn-group"><button type="button" class="btn btn-danger" onClick="tabtn(' + s++ + ')"><i class="fa fa-close"></i></button></div></td></tr>';
        $('#vitalsdata').append(line);
        }
        $('#vitals-value').val('');
        $('#vitals_type').val('');
    }

    /* Remove Button Functions */
    function tabtn(x){ 
        $('#tabtn'+x).remove();
    }
    function saveVitals(){ 
    var arr = $('form').serializeArray();
	var patientcode = $('#patientcode').val();
	var patientno = $('#patientno').val();
	var visitcode = $('#visitcode').val();
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