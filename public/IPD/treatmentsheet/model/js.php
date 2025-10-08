

<script>
 function remove_cont(x) {
            $('#main_' + x).remove();
            x--;
        };
    var i =1; var x =1; var s =1;
	
    $(document).ready(function(e){
		
		 $('#saveconsumable').click(function (e) {
		 if($('#csconsume').val().trim().length == 0 && !$('#csqty').val()&& !$('#csdate').val()){
            document.querySelector(swal("Ooops!", "Please fill all fields to proceed...Thank you", "error"));
            return;
        }else{
	  //var arr = $('form').serializeArray();
	var csconsume = $('#csconsume').val();
	var csqty = $('#csqty').val();
	var csdate = $('#csdate').val();
	var visitcode = $('#visitcode').val();
	var patientno = $('#patientno').val();
	
			 $.ajax({
                type: 'POST',
                url: 'public/IPD/treatmentsheet/model/consumable.php',
                data: {csconsume:csconsume,csqty:csqty,csdate:csdate,visitcode:visitcode,patientno:patientno},
                success: function (e) {
                    if(e.match('<tr>')){
                        $('#consumabledata').html(e);

                    }
					
					//$('#message').html(e.message);

                },
                error: function (e) {

                }
            });
			 $('#csconsume').val('');
			 $('#csdate').val('');
			 $('#csqty').val('');
			 
		
		}});
		
		 $('#savefluidoutput').click(function (e) {
		 if($('#outputfluid').val().trim().length == 0 && !$('#outdate').val()&& !$('#outtime').val()&& !$('#misout').val()){
            document.querySelector(swal("Ooops!", "Please fill all fields to proceed...Thank you", "error"));
            return;
        }else{
	  //var arr = $('form').serializeArray();
	var outdate = $('#outdate').val();
	var outtime = $('#outtime').val();
	var misout = $('#misout').val();
	var visitcode = $('#visitcode').val();
	var patientno = $('#patientno').val();
	var outputfluid = $('#outputfluid').val();
	
			 $.ajax({
                type: 'POST',
                url: 'public/IPD/treatmentsheet/model/dailyfluidoutput.php',
                data: {outdate:outdate,outtime:outtime,misout:misout,visitcode:visitcode,patientno:patientno,outputfluid:outputfluid},
                success: function (e) {
                    if(e.match('<tr>')){
                        $('#fluidoutput').html(e);

                    }
					
					//$('#message').html(e.message);

                },
                error: function (e) {

                }
            });
			 $('#outdate').val('');
			 $('#outtime').val('');
			 $('#misout').val('');
			 $('#outputfluid').val('');
			 
		
		}});
		
		
		$('#savetinfluid').click(function (e) {
		 if($('#fplan').val().trim().length==0 && !$('#fddate').val()&& !$('#fdtime').val()){
            document.querySelector(swal("Ooops!", "Please fill all fields to proceed...Thank you", "error"));
            return;
        }else{
	  //var arr = $('form').serializeArray();
	var fplan = $('#fplan').val();
	var fddate = $('#fddate').val();
	var fdtime = $('#fdtime').val();
	var visitcode = $('#visitcode').val();
	var patientno = $('#patientno').val();
	var keys = $('#keys').val();
	
			 $.ajax({
                type: 'POST',
                url: 'public/IPD/treatmentsheet/model/dailyfluidintake.php',
                data: {fplan:fplan,fddate:fddate,fdtime:fdtime,patientno:patientno,visitcode:visitcode},
                success: function (response) {
                    if(response!='Daily fluid intake captured Successfully.'){
						var message='<div class="alert alert-success">Daily fluid intake captured Successfully.</div>';
						}else{
							var message='<div class="alert alert-danger "> All fields required.</div>';
							}
						  $('#messageid').html(message);
                        
                },
                error: function (e) {

                }
            });
			 $('#fplan').val('');
			 $('#fddate').val('');
			 $('#fdtime').val('');
		
		}});
		
		
		 $('#dailyfluidp').click(function (e) {
		 if(!$('#fdate').val()&& !$('#ftime').val()&& !$('#fdname').val()&& !$('#route').val()&& !$('#fluidtype').val()&& !$('#famount').val()&& !$('#fmis').val()&& !$('#fmethod').val()){
            document.querySelector(swal("Ooops!", "Please fill all fields to proceed...Thank you", "error"));
            return;
        }else{
	  //var arr = $('form').serializeArray();
	var fdate = $('#fdate').val();
	var ftime = $('#ftime').val();
	var fdname = $('#fdname').val();
	var visitcode = $('#visitcode').val();
	var patientno = $('#patientno').val();
	var fluidtype = $('#fluidtype').val();
	var route= $('#route').val();
	var famount= $('#famount').val();
	var fmis= $('#fmis').val();
	var flmethod= $('#flmethod').val();
	
			 $.ajax({
                type: 'POST',
                url: 'public/IPD/treatmentsheet/model/dailyfluid.php',
                data: {route:route,famount:famount,fmis:fmis,flmethod:flmethod,fdate:fdate,ftime:ftime,fdname:fdname,patientno:patientno,visitcode:visitcode,fluidtype:fluidtype},
                success: function (e) {
                    if(e.match('<tr>')){
                        $('#fluiddata').html(e);

                    }
					
					//$('#message').html(e.message);

                },
                error: function (e) {

                }
            });
			 $('#nursnote').val('');
			 $('#notedate').val('');
			 $('#time').val('');
		
		}});
		
		 $('#addnote').click(function (e) {
		 if(!$('#notedate').val()&& !$('#time').val()&& !$('#nursenote').val()){
            document.querySelector(swal("Ooops!", "Please fill all fields to proceed...Thank you", "error"));
            return;
        }else{
			
	 
	  //var arr = $('form').serializeArray();
	var notedate = $('#notedate').val();
	var time = $('#time').val();
	var nursnote = $('#nursnote').val();
	var visitcode = $('#visitcode').val();
	var patientno = $('#patientno').val();
	var notedate = $('#notedate').val();
	
	
			 $.ajax({
                type: 'POST',
                url: 'public/IPD/treatmentsheet/model/nursenote.php',
                data: {notedate:notedate,time:time,nursnote:nursnote,patientno:patientno,visitcode:visitcode,notedate:notedate},
                success: function (e) {
                    if(e.match('<tr>')){
                        $('#nursenotedata').html(e);

                    }
					
					//$('#message').html(e.message);

                },
                error: function (e) {

                }
            });
			 $('#nursnote').val('');
			 $('#notedate').val('');
			 $('#time').val('');
		
		}});
		
		
		 $('#savetreatment').click(function (e) {
			 
	 if( !$('#trtime').val() && !$('#trdate').val() && !$('#prescription').val()&& !$('#quantity').val()){
            document.querySelector(swal("Ooops!", "Please fill all fields to proceed...Thank you", "error"));
            return;
        }else{
			
	   //alert('okk');
	  //var arr = $('form').serializeArray();
	var patientcode = $('#patientcode').val();
	var patientno = $('#patientno').val();
	var visitcode = $('#visitcode').val();
	var patientname=$('#patient').val();
   //var arr = $('form').serializeArray()
   
	var trtime = $('#trtime').val();
	var trsdate = $('#trsdate').val();
	var drug = $('#drugs').val();
	var quantity = $('#quantity').val();
	var wardid = $('#wardid').val();
	var wardname = $('#wardname').val();
	var bedid = $('#bedid').val();
	var bedname = $('#bedname').val();
	
	// $('#loading').show(); 

            //e.preventDefault();
           // var data = $('#myform').serializeArray();
			 $.ajax({
                type: 'POST',
                url: 'public/IPD/treatmentsheet/model/treatment.php',
                data: {bedname:bedname,bedid:bedid,wardname:wardname,wardid:wardid,visitcode:visitcode,trtime:trtime,trsdate:trsdate,drug:drug,patientcode:patientcode,patientno:patientno,quantity:quantity,patientname:patientname},
                success: function (e) {
                    if(e.match('<tr>')){
                        $('#treatsheet').html(e);

                    }
					
					//$('#message').html(e.message);

                },
                error: function (e) {

                }
            });
 $('#trtime').val('');
 $('#trsdate').val('');
 $('#drugs').val('');  
 $('#quantity').val('').trim();
		}
		
	});
		
	
		 $('#savediagnose').click(function (e) {
			 
	 if( !$('#diagnosis').val() && $('#remark').val().trim().length == 0){
            document.querySelector(swal("Ooops!", "Please fill all fields to proceed...Thank you", "error"));
            return;
        }else{
			
	   //alert('okk');
	  //var arr = $('form').serializeArray();
	var patientcode = $('#patientcode').val();
	var patientno = $('#patientno').val();
	var dateadded = $('#dateadded').val();
	var patientname=$('#patient').val();
   //var arr = $('form').serializeArray()
    var reqdate = $('#reqdate').val();
    var actorid = $('#actorid').val();
	var actorname = $('#actorname').val();
	var faccode = $('#faccode').val();
	var diagnosis = $('#diagnoses').val();
	var remark = $('#remark').val();
	var keys = $('#keys').val();
	
	// $('#loading').show(); 

            //e.preventDefault();
           // var data = $('#myform').serializeArray();
			 $.ajax({
                type: 'POST',
                url: 'public/IPD/wardrounds/model/diagnosis.php',
                data: {patientcode:patientcode,patientno:patientno,patientname:patientname,keys:keys,diagnosis:diagnosis,remark:remark},
                success: function (e) {
                    if(e.match('<tr>')){
                        $('#diagnosdata').html(e);

                    }
					
					//$('#message').html(e.message);

                },
                error: function (e) {

                }
            });
			
		$('#remark').val('');  
		$('#diagnoses').val(''); 
		
			}
        
			});
  
        /* Disable Autofill for all Inputs */
        //$('input').attr('autocomplete', 'off');
		    var counter = 0;
            var counter1 = 0;
            var counter2 = 0;
            var counter3 = 0;
		 $('#addcomplain').click(function (e) {
                var complain = $('#copmlainner').val();
                var complaincode = $('#copmlaincode').val();
                if (complain != '') {
                    $.ajax({
                        type: 'POST',
                        url: 'public/Doctors/consulatationpp/model/saveComplains.php',
                        data: {
                            'complaincode': complaincode,
                            'complain': complain,
                            'patientnum': $('#patientno').val(),
                            'patientcode': $('#patientcode').val(),
                            'visitcode': $('#visitcode').val()
                        },
                        dataType: 'json',
                        success: function (e) {
                            $('#tblcomplain tbody').html('');
                            for (var i = 0; i < e.length; i++) {
                                $('#tblcomplain tbody').append(e[i]);
                            }
                        },
                        error: function () {}
                    });

                    counter++;
                    $('#copmlainner').val('');
                    $('#copmlaincode').val('');
                }
            });

    });
	
	// end of automatic jquery
	
	function deleteconsume(e){
			
	$.ajax({
			type: 'POST',
			url: 'public/IPD/treatmentsheet/model/deleteconsumable.php',
			data: { 'keys': e,'visitcode': $('#visitcode').val() },
			success: function (e) {
				
						//$('#loading').hide(); 
						alert('Successfully Deleted');
						$('#consumabledata').html(e);
			},
		});
}
	
	function deletefluidout(e){
			
	$.ajax({
			type: 'POST',
			url: 'public/IPD/treatmentsheet/model/deletedailyfluidoutput.php',
			data: { 'keys': e,'visitcode': $('#visitcode').val() },
			success: function (e) {
				
						//$('#loading').hide(); 
						alert('Successfully Deleted');
						$('#fluidoutput').html(e);
			},
		});
}
	
		function deletefluid(e){
			
	$.ajax({
			type: 'POST',
			url: 'public/IPD/treatmentsheet/model/deletedailyfluid.php',
			data: { 'keys': e,'visitcode': $('#visitcode').val() },
			success: function (e) {
				
						//$('#loading').hide(); 
						alert('Successfully Deleted');
						$('#fluiddata').html(e);
			},
		});
}
	
		function deletedata(e){
			
	$.ajax({
			type: 'POST',
			url: 'public/IPD/treatmentsheet/model/deletetreatment.php',
			data: { 'keys': e,'visitcode': $('#visitcode').val() },
			success: function (e) {
				
						//$('#loading').hide(); 
						alert('Successfully Deleted');
						$('#treatsheet').html(e);
			},
		});
}

// delete nurse note
		function deletenote(e){
	
	$.ajax({
			type: 'POST',
			url: 'public/IPD/treatmentsheet/model/deletenursenote.php',
			data: { 'keys': e,'visitcode': $('#visitcode').val() },
			success: function (e) {
				
						$('#loading').hide(); 
						alert('Successfully Deleted');
						$('#nursenotedata').html(e);
			},
		});
}

		
	
	function saveComplain(){ 
	if( !$('#copmlainner').val()){
            document.querySelector(swal("Ooops!", "Please fill all fields to proceed...Thank you", "error"));
            return;
        }else{
	var complain = $('#copmlainner').val();
    var copmlaincode = $('#copmlaincode').val();
	var patientno= $('#patientno').val();
    var patientcode= $('#patientcode').val();
    var visitcode= $('#visitcode').val();
    var compcode = $('#compcode').val();
	var getcomplains = $('#getcomplains').val();
	 
	var keys=$('#keys').val();									
    //$('#loading').show(); 
	
	 $.ajax({
                type: 'POST',
                url: 'public/IPD/wardrounds/model/complain.php',
                data: {getcomplains:getcomplains,complain:complain,copmlaincode:copmlaincode,patientcode:patientcode,patientno:patientno,keys:keys},
                success: function (e) {
                    if(e.match('<tr>')){
                        $('#complaindata').html(e);

                    }
					
					//$('#message').html(e.message);

                },
                error: function (e) {

                }
            });
		}
			
			
			
   // var arr=[];
    /*$('#complaindata').find('tr').each(function(){
      var data=[];
      var complains = $(this).children('td').eq(1);
       data.push(compcode,patientno,visitcode,compdate,copmlaincode,complains.html(),faccode,actorcode,actorname,patientcode);
      arr.push(data);
      
    }); 
*/
   /* document.getElementById('viewpage').value='savecomplains';
    var datax = JSON.stringify(arr);
    document.getElementById('data').value=datax ;
    $('form').submit(); 
    return*/
  }

	
	  /* Function to populate table by clicking add*/
    function addcomplain(){ 
	
        if( !$('#copmlainner').val()){
            document.querySelector(swal("Ooops!", "Please fill all fields to proceed...Thank you", "error"));
            return;
        }else{
			
        var line='<tr id="tabtn' + x++ + '"><td>' + i++ + '</td><td>'+ $('#copmlainner').val()+'</td><td><div class="btn-group"><button type="button" class="btn btn-danger" onClick="tabtn(' + s++ + ')"><i class="fa fa-close"></i></button></div></td></tr>';
        $('#complaindata').append(line);
    
        }
        $('#copmlainner').val('');
        
    }
	
	
	 function addlabtest(){ 
	
        if( !$('#specimen').val() && !$('#label').val() && !$('#vol').val()){
            document.querySelector(swal("Ooops!", "Please fill all fields to proceed...Thank you", "error"));
            return;
        }else{
			 var specimen = $('#specimen').val().split('@@@');
			 var labtest=$('#labtest').val().split('@@@');
        var line='<tr id="tabtn' + x++ + '"><td>'+ labtest[1]+ '</td><td>'+ specimen[1] +'</td><td>'+ $('#label').val()+'</td><td>'+ $('#vol').val()+'</td><td><div class="btn-group"><button type="button" class="btn btn-danger" onClick="tabtn(' + s++ + ')"><i class="fa fa-close"></i></button></div></td></tr>';
        $('#labdata').append(line);
    
        }
	    $('#labtest').val('');
        $('#specimen').val('');
		$('#label').val('');
		$('#vol').val('');
        
    }
	
	/* function savelabtest1(){ 
    var arr = $('form').serializeArray();
	var patientcode = $('#patientcode').val();
	var patientno = $('#patientno').val();
	var visitcode = $('#visitcode').val();
	var ltcode = $('#ltcode').val();
	var dateadded = $('#dateadded').val();
	var patientname=$('#patientname').val();
    var arr = $('form').serializeArray()
    $('#loading').show(); 
    var patient = $('#patient').val();
    var reqdate = $('#reqdate').val();
    var actorid = $('#actorid').val();
	var actorname = $('#actorname').val();
	var faccode = $('#faccode').val();
    
    var arr=[];
    $('#labdata').find('tr').each(function(){
      var data=[];
	   var labtest = $(this).children('td').eq(0);
      var specimem = $(this).children('td').eq(1);
      var label = $(this).children('td').eq(2);
	  var volume = $(this).children('td').eq(3); 
	  //var remark = $(this).children('td').eq(4); 
alert(specimem[0]);
      data.push(ltcode,visitcode,dateadded,patientno,patientcode,patientname,labtest.html(),specimem.html() ,dateadded,label.html(),volume.html(),actorid,actorname,faccode);
      arr.push(data);
      /*data.push(patient.html(),reqdate.html(),doctor.html(),paymenttype.html(),servicename.html(),vitaltypes.html(),vitalvalues.html());
      arr.push(data);/
    }); 

    document.getElementById('viewpage').value='savelabtest';
    var datax = JSON.stringify(arr);
    document.getElementById('data').value=datax ;
    $('form').submit(); 
    return
  }*/
  
function deletecomplain(e){
	
	$.ajax({
			type: 'POST',
			url: 'public/IPD/wardrounds/model/deletecomplain.php',
			data: { 'keys': e,'visitcode': $('#visitcode').val() },
			success: function (e) {
				$('#complaindata').html(e);
				alert('Successfully Deleted');
			},
		});
}
 function deletediagnose(e){
	$.ajax({
			type: 'POST',
			url: 'public/IPD/wardrounds/model/deletediagnose.php',
			data: { 'keys': e,'visitcode': $('#visitcode').val() },
			success: function (e) {
				$('#diagnosdata').html(e);
				alert('Successfully Deleted');
			},
		});
}
function deletedrug(e){
	$.ajax({
			type: 'POST',
			url: 'public/IPD/wardrounds/model/deletedrug.php',
			data: { 'keys': e,'visitcode': $('#visitcode').val() },
			success: function (e) {
				$('#prescription').html(e);
				alert('Successfully Deleted');
			},
		});
}

function deletemgnt(e){
	$.ajax({
			type: 'POST',
			url: 'public/IPD/wardrounds/model/deletemgnt.php',
			data: { 'keys': e,'visitcode': $('#visitcode').val() },
			success: function (e) {
				$('#mgntdata').html(e);
				alert('Successfully Deleted');
			},
		});
}


		
	function savemgnt(){ 
	var mgnt = $('#mgnt').val();
		 if($('#mgnt').val().trim().length == 0){
            document.querySelector(swal("Ooops!", "Please fill all fields to proceed...Thank you", "error"));
            return;
        }else{
			
			}
			
 
        };
			
    function savelabtest(){ 
	 if( $('#specimen').val().trim().length == 0 && !$('#label').val() && $('#labtest').val().trim().length == 0 && !$('#vol').val()){
            document.querySelector(swal("Ooops!", "Please fill all fields to proceed...Thank you", "error"));
            return;
        }else{
	   //alert('okk');
	  //var arr = $('form').serializeArray();
	var patientcode = $('#patientcode').val();
	var patientno = $('#patientno').val();
	var visitcode = $('#visitcode').val();
	var ltcode = $('#ltcode').val();
	var dateadded = $('#dateadded').val();
	var patient=$('#patient').val();
   //var arr = $('form').serializeArray()
   
   
    var patient = $('#patient').val();
    var reqdate = $('#reqdate').val();
    var actorid = $('#actorid').val();
	var actorname = $('#actorname').val();
	var faccode = $('#faccode').val();
	var labtest = $('#labtest').val();
	var label = $('#label').val();
	var vol = $('#vol').val();
	var specimen = $('#specimen').val();
	var keys = $('#keys').val();
	//alert(patient);


            //e.preventDefault();
           // var data = $('#myform').serializeArray();
			 $.ajax({
                type: 'POST',
                url: 'public/IPD/wardrounds/model/labtest.php',
                data: {specimen:specimen,label:label,labtest:labtest,patientcode:patientcode,patientno:patientno,patient:patient,keys:keys,vol:vol,visitcode:visitcode},
                success: function (e) {
					
                    if(e.match('<tr>')){
						if(!(e)){
								$('#loading').show(); 
						}else{
							 $('#labdata').html(e);
							 $('#loading').hide(); 
							}
                       
						
                    }
					
					//$('#message').html(e.message);

                },
                error: function (e) {

                }
            });
		}
			
 $('#labtest').val('');
 $('#vol').val('');
 $('#label').val('');  
 $('#vol').val('');  
 $('#specimen').val('');    
        };
	
 /* function savediagnose(){ 
	 if( !$('#diagnosis').val() && $('#remark').val().trim().length == 0){
            document.querySelector(swal("Ooops!", "Please fill all fields to proceed...Thank you", "error"));
            return;
        }else{}
        };*/
    /* Function to populate table by clicking add*/
    function addvitals(){ 
	
        if( !$('#vitals-value').val()){
            document.querySelector(swal("Ooops!", "Please fill all fields to proceed...Thank you", "error"));
            return;
        }else{
			
        var line='<tr id="tabtn' + x++ + '"><td>' + i++ + '</td><td>'+ $('#vitalstype').val()+'</td><td>'+ $('#vitals-value').val()+'</td><td><div class="btn-group"><button type="button" class="btn btn-danger" onClick="tabtn(' + s++ + ')"><i class="fa fa-close"></i></button></div></td></tr>';
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
	var patientcode = $('#patientcode').val();
	var patientno = $('#patientno').val();
	var keycode = $('#keys').val().split('@@');
	var dateadded = $('#dateadded').val();
	var visitcode=keycode[1];
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
//alert(visitcode);
      data.push(vitaltypes.html(),vitalvalues.html(),visitcode,patientcode,patientno);
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