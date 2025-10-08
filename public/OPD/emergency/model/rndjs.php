 <script>
	$(document).ready(function () {
		
		 $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', function (e)
    {
        var target = $(e.target);
        var targetid = target.attr("href");
        if ((targetid == '#report'))
        {
			var patientcode = $('#patkey').val();
			var visitcode = $('#keys').val();
			//alert(visitcode);
            //var data = $("form").serializeArray();
            $.ajax({
			type: 'POST',
			url: 'public/OPD/emergency/model/fetchReport.php',
			data: {'patientcode':patientcode,'visitcode':visitcode },
			
			success: function (e) {
				if(e.match('<tr>')){
                        $('#report table tbody').html(e);

                    }

                },
                error: function (e) {

                }
            });
        }
 });
 
		
		 $('#addvitals').click(function (e) {
			//alert('hi');
            e.preventDefault();
		
            var data = $('#myform').serializeArray();

            $.ajax({
                type: 'POST',
                url: 'public/OPD/emergency/model/savevitals.php',
                data: data,
                success: function (e) {
					alert(e);
					/*
                    if(e.match('<tr>')){
                        $('#report table tbody').html(e);

                    }*/

                },
                error: function (e) {

                }
            });
			if( !$('#vitals_value').val()){
            document.querySelector(swal("Ooops!", "Please fill all fields to proceed...Thank you", "error"));
            return;
        }else{
        var line='<tr id="tabtn' + x++ + '"><td>' + i++ + '</td><td>'+ $('#vitals_type').val()+'</td><td>'+ $('#vitals_value').val()+'</td><td><div class="btn-group"><button type="button" class="btn btn-danger" onClick="tabtn(' + s++ + ')"><i class="fa fa-close"></i></button></div></td></tr>';
        $('#vitalsdata').append(line);
        }
        $('#vitals_value').val('');
        $('#vitals_type').val('');
            //$('#vitals_type').val('');
			//$('#vitals_value').val('');
        });
		
		$('#addxray').click(function (e) {
            var xrayopt = $('#xrayopt').val();
            var xray = xrayopt.split('@@@');
            var remark = $('#xrayrmk').val();
            if (xray != '') {
                $.ajax({
                    type: 'POST',
                    url: 'public/OPD/emergency/model/savexrays.php',
                    data: {
                        'xraycode': xray[0],
                        'xrayname': xray[1],
                        'dicscode': xray[2],
                        'dicsname': xray[3],
                        'remark': remark,
                        'patientnum': $('#patientnum').val(),
                        'patientcode': $('#patientcode').val(),
                        'patientname': $('#patientname').val(),
                        'visitcode': $('#visitcode').val(),
                        'activeinstitution': $('#activeinstitution').val()
                    },
                    dataType: 'json',
                    success: function (e) {
                        $('#tblxray tbody').html('');
                        for (var i = 0; i < e.length; i++) {
                            $('#tblxray tbody').append(e[i]);
                        }
                    },
                    error: function () {}
                });

                counter1++;
                $('select#xrayopt option:selected').remove();
                $('textarea#xrayrmk').val('');
            }
        });
	
		
        $('#addreport').click(function (e) {
			//alert('hi');
            e.preventDefault();
            var data = $('#myform').serializeArray();

            $.ajax({
                type: 'POST',
                url: 'public/OPD/emergency/model/saveReport.php',
                data: data,
                success: function (e) {
                    if(e.match('<tr>')){
                        $('#report table tbody').html(e);

                    }

                },
                error: function (e) {

                }
            });
            $('#reportarea').val('');
        });
		
		$('#addprescription').click(function (e) {
            var drug = $('#drug').val();
            var drg = drug.split('@@@')
            var times = $('#times').val();
            var frequency = $('#frequency').val();
            var dys = $('#days').val();
            if (drug != '') {
                $.ajax({
                    type: 'POST',
                    url: 'public/OPD/emergency/model/savePrescription.php',
                    data: {
                        'drugcode': drg[0],
                        'drugname': drg[1],
                        'drugdose': drg[2],
                        'drugdosename': drg[3],
                        'days': dys,
                        'frequency': frequency,
                        'times': times,
                        'patientnum': $('#patientnum').val(),
                        'patientcode': $('#patientcode').val(),
                        'patientname': $('#patientname').val(),
                        'visitcode': $('#visitcode').val()
                    },
                    dataType: 'json',
                    success: function (e) {
                        $('#tblprescription tbody').html('');
                        for (var i = 0; i < e.length; i++) {
                            $('#tblprescription tbody').append(e[i]);
                        }
                    },
                    error: function () {}
                });

                counter3++;
                $('#drug option:selected').remove();
                $('#times').val('');
                $('#frequency').val('');
                $('#days').val('');
            }
        });
        //  End of prescription
		
		$('#addlabs').click(function (e) {
            var labs = $('#test').val();
            var lab = labs.split('@@@');
            var remark = $('#crmk').val();
            if (labs != '') {
                $.ajax({
                    type: 'POST',
                    url: 'public/Doctors/consulatationpp/model/saveLabs.php',
                    data: {
                        'testcode': lab[0],
                        'testname': lab[1],
                        'dicscode': lab[2],
                        'dicsname': lab[3],
                        'remark': remark,
                        'patientnum': $('#patientnum').val(),
                        'patientcode': $('#patientcode').val(),
                        'patientname': $('#patientname').val(),
                        'visitcode': $('#visitcode').val(),
                        'activeinstitution': $('#activeinstitution').val()
                    },
                    dataType: 'json',
                    success: function (e) {
                        $('#tbllabs tbody').html('');
                        for (var i = 0; i < e.length; i++) {
                            $('#tbllabs tbody').append(e[i]);
                        }
                    },
                    error: function () {}
                });

                counter1++;
                $('select#test option:selected').remove();
                $('textarea#crmk').val('');
            }
        });
		
		
		$('#savedischarge').click(function (e) {
			//alert('hi');
            e.preventDefault();
            var data = $('#myform').serializeArray();

            $.ajax({
                type: 'POST',
                url: 'public/OPD/emergency/model/saveDischarge.php',
                data: data,
                success: function (e) {
                    if(e.match('<tr>')){
                        $('#report table tbody').html(e);

                    }

                },
                error: function (e) {

                }
            });
            $('#dischargearea').val('');
        });

	});
	
	function deleteReport(e){
		//alert(e);
		//var data = $('#myform').serializeArray();
		
	$.ajax({
			type: 'POST',
			url: 'public/OPD/emergency/model/deleteReport.php',
			data: { 'keys': e,'patientcode':patientcode,'visitcode':visitcode },
			
			success: function (e) {
				if(e.match('<tr>')){
                        $('#report table tbody').html(e);

                    }

                },
                error: function (e) {

                }
            });
}

function deleteprescription(e){
		alert(e);
		//var data = $('#myform').serializeArray();
		
	$.ajax({
			type: 'POST',
			url: 'public/OPD/emergency/model/deletePrescription.php',
			data: { 'keys': e,'patientcode':patientcode,'visitcode':visitcode },
			
			success: function (e) {
				$('#tblprescription tbody').html('');
                        for (var i = 0; i < e.length; i++) {
                            $('#tblprescription tbody').append(e[i]);
                        }
                    },

                error: function (e) {

                }
            });
			
}

function addvitals(){ 
        if( !$('#vitals_value').val()){
            document.querySelector(swal("Ooops!", "Please fill all fields to proceed...Thank you", "error"));
            return;
        }else{
        var line='<tr id="tabtn' + x++ + '"><td>' + i++ + '</td><td>'+ $('#vitals_type').val()+'</td><td>'+ $('#vitals_valuevitals_value').val()+'</td><td><div class="btn-group"><button type="button" class="btn btn-danger" onClick="tabtn(' + s++ + ')"><i class="fa fa-close"></i></button></div></td></tr>';
        $('#vitalsdata').append(line);
        }
        $('#vitals_value').val('');
        $('#vitals_type').val('');
    }




</script>