<script>
    var i =1; var x =1; var s =1;
    $(document).ready(function(e){


$('#addpay').click(function (e) {
    if( !$('#fname').val() || !$('#tamount2').val() ){
    document.querySelector(swal("Ooops!", "Please fill all fields to proceed...Thank you", "error"));
}});

        /* Disable Autofill for all Inputs */
        $('input').attr('autocomplete', 'off');
    });
    /* function to add checked vales sum*/
    function addsum(me){
            var cashcost=$(me).closest('tr').children('td').eq(4).text();
            var total=  $('#tamount1').val();

            if($(me).is(':checked')) {
                $('#tamount1').val(Number(total)+Number(cashcost));
                $('#cashamt').text(Number(total)+Number(cashcost));
            }else{
                $('#tamount1').val( Number(total)-Number(cashcost));
                $('#cashamt').text( Number(total)-Number(cashcost));
             } };

    ///// function for empty fills in cashier ///

    /* Function to populate table by clicking add*/
    function addvitals(){ 
        if( !$('#vitals_value').val()){
            document.querySelector(swal("Ooops!", "Please fill all fields to proceed...Thank you", "error"));
            return;
        }else{
        var line='<tr id="tabtn' + x++ + '"><td>' + i++ + '</td><td>'+ $('#vitals_type').val()+'</td><td>'+ $('#vitals_value').val()+'</td><td><div class="btn-group"><button type="button" class="btn btn-danger" onClick="tabtn(' + s++ + ')"><i class="fa fa-close"></i></button></div></td></tr>';
        $('#vitalsdata').append(line);
        }
        $('#vitals_value').val('');
        $('#vitals_type').val('');
    }

    /* Remove Button Functions */
    function tabtn(x){ 
        $('#tabtn'+x).remove();
    }
    function saveVitals(){ 
    var arr = $('form').serializeArray();
	var patientcode = $('#patkey').val();
	var patientno = $('#patientnum').val();
	var emergencycode = $('#v').val();
	var visitcode = $('#keys').val();
	var faccode = $('#faccode').val();
	var actor = $('#actor').val();
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

      data.push(vitaltypes.html(),vitalvalues.html(),visitcode,dateadded,patientcode,patientno,emergencycode,faccode,actor);
      arr.push(data);
      /*data.push(patient.html(),reqdate.html(),doctor.html(),paymenttype.html(),servicename.html(),vitaltypes.html(),vitalvalues.html());
      arr.push(data);*/
    }); 
   
    document.getElementById('viewpage').value='vitals';
    var datax = JSON.stringify(arr);
    document.getElementById('data').value=datax ;
    document.getElementById('views').value='add';
    $('form').submit(); 
    return
  }

</script>