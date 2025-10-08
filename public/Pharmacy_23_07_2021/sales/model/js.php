<script>
    var i =1; var x =1; var s =1;
    var drug=[];

    
   
    function deleteComplains(para) {
       // alert(type);//return array.length;
        var check = drug.includes(para);
        
        var index = drug.indexOf(para);
        if (index > -1) {
          drug.splice(index, 1);
        }
        document.getElementById('totalamount').value='0';
       // console.log(drug);
        if(drug.length > 0){//if it has been filled
        	var costarr= new Array();
        	var quantityarr= new Array();
        	var totalarr= new Array();
            var arraylength = drug.length;
			for (var i=0; i < arraylength; i++){//loop through the id's and assign the current text field value
             var costval = 'cost'+drug[i]; //to get the text field value for cost
             var quantityval = 'quantity'+drug[i]; //to get the text field value for quantity
             var totalval = 'total'+drug[i]; //to get the text field value for total
             costarr[drug[i]]=document.getElementById(costval).value;
             quantityarr[drug[i]]=document.getElementById(quantityval).value;
             totalarr[drug[i]]=document.getElementById(totalval).value;
                }
           
            
            }
      $.ajax({
            type: 'POST',
            url: 'public/Pharmacy/sales/model/addTray.php',
            data: {
                'drugid': drug,
            },
            dataType: 'json',
            success: function (e) {
            	//drug=e;
            	//console.log(drug);
                $('#traydev tbody').html('');
                for (var i = 0; i < e.length; i++) {
                	
                    $('#traydev tbody').append(e[i]);
                }
                for (var key in costarr) {
                	var costfinalval = 'cost'+key;
                    document.getElementById(costfinalval).value=costarr[key];
                }
                for (var key in quantityarr) {
                	var quantityfinalval = 'quantity'+key;
                    document.getElementById(quantityfinalval).value=quantityarr[key];
                }
                for (var key in totalarr) {
                	var totalfinalval = 'total'+key;
                    document.getElementById(totalfinalval).value=totalarr[key];
                }

                var arr = document.getElementsByName('total');
                var tot=0;
                for(var i=0;i<arr.length;i++){
                    if(parseFloat(arr[i].value))
                    tot += parseFloat(arr[i].value);
                    document.getElementById('totalamount').value=tot;
                }
                
                
               /** [
               alert(costarr[con]);
               console.log(costarr[con]);**/
                
            },
            error: function () {}
        });
    
    }


    function fetchComplains(patientnum, visitcode) {
        $.ajax({
            type: 'POST',
            url: 'public/Doctors/consulatationpp/model/fetchComplains.php',
            data: {'patientnum':patientnum,'visitcode':visitcode},
            dataType: 'json',
            async: true,
            cache: false,
            success: function (e) {
                $('#tblcomplain tbody').html('');
                for (var i=0; i<e.length; i++){
                    $('#tblcomplain tbody').append(e[i]);
                }
            },
            error: function (e) {
                console.log(e)
            }
        });
    }

    /*
     * Auto refresh the consultaiton list
     */
    setInterval( function() {
        $.ajax({
            type: 'POST',
            url: 'public/Doctors/consulatationpp/model/consultationupdate.php',
            dataType: 'json',
            data: {"activeinstitution":"<?php echo $activeinstitution;?>","usrcode":"<?php echo $usrcode;?>"},
            success: function(e){
                $('tbody.tbody').html(e)
            },
        });
    }, 30000);



    $(document).ready(function(e){
    

        $('#drug').change(function (e) {
            e.preventDefault();
            var drug = $('#drug').val();
            var drg = drug.split('@@@');
            var drugcode = drg[0];
            var drugname = drg[1];
            var drugdose = drg[2];
            var drugdosename = drg[3];
            if (drugdose === 'DOS0001' || drugdose === 'DOS0004' || drugdose === 'DOS0012' || drugdose === 'DOS0013'){
                $('#qty').val('');
            }else {
                $('#qty').val('1');
            }
        });

        $('#days').on('blur',function () {
            var drug = $('#drug').val();
            var drg = drug.split('@@@');
            var drugdose = drg[2];
            var drugdosename = drg[3];
            var frequency = $('#frequency').val();
            var days = $('#days').val();
            var times = $('#times').val();
            if (drugdose === 'DOS0001' || drugdose === 'DOS0004' || drugdose === 'DOS0012' || drugdose === 'DOS0013'){
                var qty = frequency * days * times ;
                $('#qty').val(qty.toString());
            }else {
                $('#qty').val('1');
            }
        });
		
        $('#save').on('click',function(){
            if($('#cancel').val().trim().length==0){
                alert('Sorry! Field is required');
			}else{
				$('#canceldata').val($('#cancel').val());
				$('#viewpage').val('cancelrequest');
				document.myform.submit();
            }
		});
		// Set admiting note to on and off
		$('#showadmitnote').hide();
		
		$('#actiontype').change(function(){
			var myaction = $( "select#actiontype" ).val();
			if(myaction == 'SER0005_5'){
			   $('#showadmitnote').show();	
			}else{
				$('#showadmitnote').hide();
				 }
		});
        //  Consultation Actions
		
        var counter = 0;
        var counter1 = 0;
        var counter2 = 0;
        var counter3 = 0;
        $('#addcomplain').click(function (e) {
            console.log($('#new_visitcode').val());
            var complain = $('#copmlainner').val();
            var complaincode = $('#copmlaincode').val();
            if (complain != '') {
                $.ajax({
                    type: 'POST',
                    url: 'public/Doctors/consulatationpp/model/saveComplains.php',
                    data: {
                        'complaincode': complaincode,
                        'complain': complain,
                        'patientnum': $('#patientnum').val(),
                        'patientcode': $('#patientcode').val(),
                        'visitcode': $('#new_visitcode').val(),
                        'storyline': $('#storyline').val()
                    },
                    dataType: 'json',
                    success: function (e) {
                        $('#tblcomplain tbody').html('');
                        for (var i = 0; i < e.length; i++) {
                            $('#tblcomplain tbody').append(e[i]);
                        }
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });

                counter++;
                $('#copmlainner').val('');
                $('#copmlaincode').val('');
                $('#storyline').val('');
//                    $('#storyline').hide();
            }
        });

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
                        'visitcode': $('#new_visitcode').val(),
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

        $('#addxray').click(function (e) {
            var xrayopt = $('#xrayopt').val();
            var xray = xrayopt.split('@@@');
            var remark = $('#xrayrmk').val();
            if (xray != '') {
                $.ajax({
                    type: 'POST',
                    url: 'public/Doctors/consulatationpp/model/savexrays.php',
                    data: {
                        'xraycode': xray[0],
                        'xrayname': xray[1],
                        'dicscode': xray[2],
                        'dicsname': xray[3],
                        'remark': remark,
                        'patientnum': $('#patientnum').val(),
                        'patientcode': $('#patientcode').val(),
                        'patientname': $('#patientname').val(),
                        'visitcode': $('#new_visitcode').val(),
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

        $('#adddiagnosis').click(function (e) {
            var diagnosis = $('#dia').val();
            var diag = diagnosis.split('@@@');
            var diagnosisremark = $('#drmk').val();
            if (diagnosis != '') {
                $.ajax({
                    type: 'POST',
                    url: 'public/Doctors/consulatationpp/model/saveDiagnosis.php',
                    data: {
                        'diagnosiscode': diag[0],
                        'diagnosisname': diag[1],
                        'remark': diagnosisremark,
                        'patientnum': $('#patientnum').val(),
                        'patientcode': $('#patientcode').val(),
                        'patientname': $('#patientname').val(),
                        'visitcode': $('#new_visitcode').val()
                    },
                    dataType: 'json',
                    success: function (e) {
                        $('#tbldiagnosis tbody').html('');
                        for (var i = 0; i < e.length; i++) {
                            $('#tbldiagnosis tbody').append(e[i]);
                        }
                    },
                    error: function () {}
                });

                counter2++;
                $('#dia option:selected').remove();
                $('textarea#drmk').val('');
            }
        });
          
        $('#addDrug').click(function (e) {
        	var drugcode =$('#drugid').val();
        	var paymentmethod =$('#paymentmethod').val();
        	var check = drug.includes(drugcode);//check if drug already in tray
        	//alert(drugcode);
        	//console.log(drug);
            if(drug.length > 0){//if it has been filled
            	var costarr= new Array();
            	var quantityarr= new Array();
            	var totalarr= new Array();
                var arraylength = drug.length;
    			for (var i=0; i < arraylength; i++){//loop through the id's and assign the current text field value
                 var costval = 'cost'+drug[i]; //to get the text field value for cost
                 var quantityval = 'quantity'+drug[i]; //to get the text field value for quantity
                 var totalval = 'total'+drug[i]; //to get the text field value for total
                 costarr[drug[i]]=document.getElementById(costval).value;
                 quantityarr[drug[i]]=document.getElementById(quantityval).value;
                 totalarr[drug[i]]=document.getElementById(totalval).value;
                    }
                
                }
            if (check ==false){
            drug.push(drugcode);
            drug.reverse();

           
            if (drug != '' ) {
            	
            	  $.ajax({
                    type: 'POST',
                    url: 'public/Pharmacy/sales/model/addTray.php',
                    data: {
                        'drugid': drug,
                        'paymentmethod': paymentmethod,
                    },
                    dataType: 'json',
                    success: function (e) {
                    	//drug=e;
                    	//console.log(drug);
                        $('#traydev tbody').html('');
                        for (var i = 0; i < e.length; i++) {
                        	
                            $('#traydev tbody').append(e[i]);
                        }
                        for (var key in costarr) {
                        	var costfinalval = 'cost'+key;
                            document.getElementById(costfinalval).value=costarr[key];
                        }
                        for (var key in quantityarr) {
                        	var quantityfinalval = 'quantity'+key;
                            document.getElementById(quantityfinalval).value=quantityarr[key];
                        }
                        for (var key in totalarr) {
                        	var totalfinalval = 'total'+key;
                            document.getElementById(totalfinalval).value=totalarr[key];
                        }

                        var arr = document.getElementsByName('total');
                        var tot=0;
                        for(var i=0;i<arr.length;i++){
                            if(parseFloat(arr[i].value))
                            tot += parseFloat(arr[i].value);
                            document.getElementById('totalamount').value=tot;
                        }

                        
                        
                        
                       /** [
                       alert(costarr[con]);
                       console.log(costarr[con]);**/
                        
                    },
                    error: function () {}
                });
            	//$('#drugid option:selected').remove();
            	
            }
            }
        });


        //remove drug
       
       
       
        
     $('.removeDrug').click(function () {
         alert('Boooom');
        	var drugcode =$('#drugid').val();
        	var check = drug.includes(drugcode);//check if drug already in tray
        	//console.log(drug);
            if(drug.length > 0){//if it has been filled
            	var costarr= new Array();
            	var quantityarr= new Array();
                var arraylength = drug.length;
                for (var i=0; i < arraylength; i++){//loop through the id's and assign the current text field value
                 var costval = 'cost'+drug[i]; //to get the text field value for cost
                 var quantityval = 'quantity'+drug[i]; //to get the text field value for quantity
                 costarr[drug[i]]=document.getElementById(costval).value;
                 quantityarr[drug[i]]=document.getElementById(quantityval).value;
                
                    }
                
                
                }
            if (check ==false){
            drug.push(drugcode);
            drug.reverse();
          
            
          //  alert(check);
           // alert(drugcode);
           
           
            	
            	  $.ajax({
                    type: 'POST',
                    url: 'public/Pharmacy/dispensary/model/addTray.php',
                    data: {
                        'drugid': drug,
                        /**'drugname': drg[1],
                        'drugdose': drg[2],
                        'drugdosename': drg[3],
                        'days': dys,
                        'frequency': frequency,
                        'times': times,
                        'qty': qty,
                        'routecode': routecode,
                        'routename': routename,
                        'patientnum': $('#patientnum').val(),
                        'patientcode': $('#patientcode').val(),
                        'patientname': $('#patientname').val(),
                        'visitcode': $('#new_visitcode').val()**/
                    },
                    dataType: 'json',
                    success: function (e) {
                    	
                        $('#traydev tbody').html('');
                        for (var i = 0; i < e.length; i++) {
                        	
                            $('#traydev tbody').append(e[i]);
                        }
                        for (var key in costarr) {
                        	var costfinalval = 'cost'+key;
                            document.getElementById(costfinalval).value=costarr[key];
                        }
                        for (var key in quantityarr) {
                        	var quantityfinalval = 'quantity'+key;
                            document.getElementById(quantityfinalval).value=quantityarr[key];
                        }
                        
                        
                        
                       /** [
                       alert(costarr[con]);
                       console.log(costarr[con]);**/
                        
                    },
                    error: function () {}
                });
            	  
            	//$('#drugid').val(null);
            	$('#drugid option:selected').remove();
            	/**    counter3++;
                $('#drug option:selected').remove();
                $('#times').val('');
                $('#frequency').val('');
                $('#days').val('');
                $('#qty').val('');
                $('select#route').val(0);**/
//                $('select#route option:first-child').attr("selected", "selected");
            
            }
        });
        

        //  Save Patient Physical Examination
        $('#addphyexams').click(function (e) {
            //alert('hi');
            e.preventDefault();
            var data = $('#myform').serializeArray();

            $.ajax({
                type: 'POST',
                url: 'public/Doctors/consulatationpp/model/savePhysicalExams.php',
                data: data,
                success: function (e) {
                    if(e.match('<tr>')){
                        $('#physicalexams table tbody').html(e);

                    }

                },
                error: function (e) {

                }
            });
            $('#txtarea').val('');
        });

        $('.storydiv').hide();
        $('#addstory').hide();


        $('#addcomplain').click(function (e) {
            $('#addstory').hide();
            $('.storydiv').hide();
        });

        $('#copmlainner').keypress(function (e) {
//            console.log(e.keyCode);
            if ($(this).val() != ''){
                $('#addstory').show()
            }
            if (e.which == 8){
                if ($(this).val() == ''){
//                    $('#addstory').show()
                    $('#addstory').hide()
                }
            }
        });
        $('#addstory').click(function (e) {
            $('.storydiv').show();
        });

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

  /*       setInterval( function() {
		 var senderid = $('#sendercode').val();
		 var patientcode = $('#patientcode').val();
		            $.ajax({
			        type: 'POST',
					url: 'public/Doctors/consulatationpp/model/fetchchat.php',
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

//        $('#addcomplain').click(function (e) {
//            var complain = $('#copmlainner').val();
//            console.log(complain);
//        });
    //Add allergies and chroniques conditions

$('#chroniques').click(function (e) {
	
            e.preventDefault();
            var data = $('#myform').serializeArray();

            $.ajax({
                type: 'POST',
                url: 'public/Doctors/consulatationpp/model/saveAllergies.php',
                data: data,
                success: function (e) {
                    $('.txtarea').val('');
                 
                    if(e.match('<tr>')){
                        $('#veiwallergies table tbody').html(e);
                    }

                },
                error: function (e) {

                }
            });
            
        });//End allergies and chroniques conditions updates

      /*
 * Display referrals options on action taken
 */
 $('.finalaction').change(function(){
    var actiontype = $('#actiontype').val();
    if(actiontype == 'SER0008_8'){
       $('.reff').show();
       $('.reff3').show();
       $('.reff2').hide();
    }else if(actiontype == 'SER0007_7'){
        $('.reff2').show();
        $('.reff3').show();
        $('.reff').hide();
        }else{
        $('.reff').hide(); 
        $('.reff2').hide(); 
        $('.reff3').hide(); 
        }

})

//Count down of character left in textarea
$('#refnote').keyup(function() {
    var maxLength = 160;
    var length = $(this).val().length;
    var length = maxLength-length;
    $('#chars').text(length);

});
     
    });

    function deleteAllergies(){
		//alert('hi');
		var data = $('#myform').serializeArray();
	$.ajax({
			type: 'POST',
			url: 'public/Doctors/consulatationpp/model/deleteAllergies.php',
			data: data,
			success: function (e) {
                if(e.match('<tr>')){
                    $('#veiwallergies table tbody').html(e);
                }

                },
                error: function (e) {

                }
            });
}

function deleteChroniques(){
		//alert('hi');
		var data = $('#myform').serializeArray();
	$.ajax({
			type: 'POST',
			url: 'public/Doctors/consulatationpp/model/deleteChroniques.php',
			data: data,
			success: function (e) {
                if(e.match('<tr>')){
                    $('#veiwallergies table tbody').html(e);
                }

                },
                error: function (e) {

                }
            });
}

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

    function deletePhysicalExams(e){
        //alert('hi');
        var data = $('#myform').serializeArray();
        var patientnum = $('#patientnum').val();
        var visitcode = $('#new_visitcode').val();
        $.ajax({
            type: 'POST',
            url: 'public/Doctors/consulatationpp/model/deletePhysicalExams.php',
            data: { 'keys': e,'patientnum':patientnum,'visitcode':visitcode,'data':data },

            success: function (e) {
                if(e.match('<tr>')){
                    $('#physicalexams table tbody').html(e);

                }

            },
            error: function (e) {

            }
        });
    }

</script>