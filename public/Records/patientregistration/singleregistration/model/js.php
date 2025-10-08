<script>
	$(document).ready(function () {
        $('#membershipnumberdiv').hide();
        $('#issuedatediv').hide();
        $('#expiredatediv').hide();
        $('#startdatediv').hide();
        $('#enddatediv').hide();
        $('#prescriberdiv').hide();
        $('#departmentdiv').hide();
        $('#pat_paymentschemediv').hide();
        $('#servicediv').hide();


        $('#paymentcategory').change(function () {
            var paycat = $(this).val().split('@@@');
            var paycatcode = paycat[0];
            var paycatname = paycat[1];
            var facilitycode = $('#faccode').val();
            if (paycatcode != ''){
                $.ajax({
                    type: 'POST',
                    url: 'public/Records/patientregistration/singleregistration/model/getpaymentschemes.php',
                    data: {'paycatcode':paycatcode,'facilitycode':facilitycode},
                    dataType: 'json',
                    success: function (e) {
                        if (e){
                            $('#pat_paymentscheme').html('');
                            for (var i=0; i<e.length; i++){
                                $('#pat_paymentscheme').append(e[i][0]);
                            }
                        }
                    }
                })
                $('#pat_paymentschemediv').show();
                if (paycatcode == 'PC0002' || paycatcode == 'PC0003'){
                    // NHIS and Private Insurances
                    $('#membershipnumberdiv').show();
                    $('#issuedatediv').show();
                    $('#expiredatediv').show();
                    $('#startdatediv').show();
                    $('#enddatediv').show();
                }else if (paycatcode == 'PC0004'){
                    // Partner Company
//                    $('#pat_paymentschemediv').hide();
                    $('#membershipnumberdiv').hide();
                    $('#issuedatediv').hide();
                    $('#expiredatediv').hide();
                    $('#startdatediv').hide();
                    $('#enddatediv').hide();
                }else {
                    // Cash and Other
//                    $('#pat_paymentschemediv').hide();
                    $('#membershipnumberdiv').hide();
                    $('#issuedatediv').hide();
                    $('#expiredatediv').hide();
                    $('#startdatediv').hide();
                    $('#enddatediv').hide();
                }
            }else {
                $('#pat_paymentschemediv').hide();
                $('#membershipnumberdiv').hide();
                $('#issuedatediv').hide();
                $('#expiredatediv').hide();
                $('#startdatediv').hide();
                $('#enddatediv').hide();
            }
        });




        $('.panel-warning').hide();
        $('#newgroup').click(function (e) {
            e.preventDefault();
            var groupname = $('#groupname').val();
            var grouptype = $('#grouptype').val();
            var groupcode = $('#groupcode').val();
            if (groupname != ''){
                $.ajax({
                    type: 'POST',
                    url: 'public/Records/patientregistration/groupregisteration/model/savegroupname.php',
                    data: {'groupname':groupname,'grouptype':grouptype,'groupcode':groupcode},
                    dataType: 'json',
                    cache: false,
                    success: function (data) {
                        if (data){

                            console.log('hello');
                            console.log(data);
                            $('#groupcode').val(data);
                        }
                        document.getElementById('groupcode').value = data;
                        $('#groupcode').val(data);

////                       var result = e.split('@@@');
//                       getdata = data;
//                       console.log(getdata);
////                       $('#frmmyform').prepend(result[0]);
//                       $('#groupcode').val(getdata);
//                       $('.panel-warning').show();
//                       $('.medal').text('Patient Group name has been saved successfully');
//                       setTimeout(function () {
//                           $('.panel-warning').fadeOut(1000);
//                       },5000);
//                       $('#v').val('group');
                       $('#myform').submit();
                    },
                    error: function (e) {
                        console.log(e)
                    }
                });
            }else {
                $('.panel-warning').show();
                $('.medal').text('Group name can not be empty. Enter group name to create a patient group');
                setTimeout(function () {
                    $('.panel-warning').fadeOut(1000);
                },5000);
            }
        });


        var patient_num;

        $('.datepicker').datepicker();

        $('input').attr('autocomplete', 'off');
		
        $('#add').click(function (e) {

            e.preventDefault();
            var data = $('#myform').serializeArray();

            $.ajax({
                type: 'POST',
                url: 'public/Records/patientregistration/singleregistration/model/save.php',
                data: data,
                success: function (e) {
                    if(e.match('<tr>')){
                        $('#family table tbody').html(e);

                    }

                },
                error: function (e) {

                }
            });
            $('#relation').val('');
            $('#prnum').val('');
        });

        $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', function (e)
        {
            var target = $(e.target);
            var targetid = target.attr("href");
            if ((targetid == '#personal' || targetid == '#emergency' || targetid == '#health' || targetid == '#patientpaymentscheme' || targetid == '#family' || targetid == '#requestservice'))
            {
                var data = $('#myform').serializeArray();
                $.ajax({
                    type: 'POST',
                    url: "public/Records/patientregistration/singleregistration/model/savepatient.php",
                    data: data,
                    success: function (e) {
                        var pat_num = e.split('@@@');
                        $('#patientcode').val(pat_num[0]);
                        $('#patientnum').val(pat_num[1]);
                    }


                });
            }
            if (targetid == '#requestservice'){
                // Get Patient's Payment Scheme
                var data = $('#myform').serializeArray();
                $.ajax({
                    type: 'POST',
                    url: "public/Records/patientregistration/singleregistration/model/getpatientpaymentscheme.php",
                    data: data,
                    dataType: 'json',
                    success: function (e) {
//                        var pat_num = e.split('@@@');
//                        $('#patientnum').val(pat_num[0]);
//                        $('#patientcode').val(pat_num[1]);
                        if (e){
//                            $('#paymentscheme').html('');
                            for (var i=0; i<e.length; i++){
                            $('#paymentscheme').append(e[i][0]);
                            }
                        }
                    }
                });
            }
        });

        $('#addpatpayscheme').click(function (e) {
            e.preventDefault();
            var data = $('#myform').serializeArray();
            $.ajax({
                type: 'POST',
                url: 'public/Records/patientregistration/singleregistration/model/savepatientpaymentscheme.php',
                data: data,
                dataType: 'json',
                success: function (e) {
                    $('#tblpatpaymentscheme tbody').html('');
                    for (var i = 0; i < e.length; i++) {
                        $('#tblpatpaymentscheme tbody').append(e[i]);
                    }
                }
            });
        });

        $('#paymentscheme').change(function () {
            $('#servicediv').show();
        });

        $('#servicediv').change(function () {
            var ser = $('#service').val().split('@@@');
            var servicecode = ser[0];
            if (servicecode == 'SER0001'){
                $('#prescriberdiv').show();
            }else {
                $('#prescriberdiv').hide();
            }
        });

        $('#department').change(function (e) {
            var dept = $(this).val().split('@@@');
            var deptcode = dept[0];
            var deptname = dept[1];
            $.ajax({
                type: 'POST',
                url: 'public/Records/patientregistration/singleregistration/model/getprescriber.php',
                data: {'departmentcode':deptcode, 'userid':"<?php echo $userid ?>", 'usercode':"<?php echo $actorcode ?>", 'faccode':"<?php echo $faccode ?>"},
                dataType: 'json',
                success: function (e) {
                    for (var i = 0; i < e.length; i++){
                        $('#prescribe').append(e[i][0]);
                    }
                    console.log(e);
                }
            });

        });

	});
	
	function deleteRelation(e){
		
	$.ajax({
			type: 'POST',
			url: 'public/Records/patientregistration/singleregistration/model/delete.php',
			data: { 'keys': e ,'patientnum': $('#patientnum').val()},
			success: function (e) {
				$('#family table tbody').html(e);
			},
		});
}

/* Photo Previewer */
    function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#prevphoto').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
    }

    // Delete Patient Payment Scheme
    function deleteScheme(code,patientcode) {
//        var patientcode = $('#patientcode').val();
        console.log(code+' && '+patientcode);
        $.ajax({
            type: 'POST',
            url: 'public/Records/patientregistration/singleregistration/model/deletepaymentscheme.php',
            data: {'code':code,'patientcode':patientcode},
            dataType: 'json',
            success: function (e) {
                console.log(e);
                $('#tblpatpaymentscheme tbody').html('');
                for (var i = 0; i < e.length; i++) {
                    $('#tblpatpaymentscheme tbody').append(e[i]);
                }
            }
        });
    }
</script>