<script>
    var i =1; var x =1; var s =1;
    var drug=[];

    
   
    function deleteComplains(para) {
        //alert('booooom');
       // alert(type);//return array.length;
        var facilitypercent=$('#facilitypercent').val();//document.getElementById('facilitypercent');     
        var check = drug.includes(para);
        
        var index = drug.indexOf(para);
        if (index > -1) {
          drug.splice(index, 1);
        }
        document.getElementById('totalamount').value='0';
		document.getElementById('commission').value='0';
        document.getElementById('finalgrandtotal').value='0'; 
       // console.log(drug);
        if(drug.length > 0){//if it has been filled
        	document.getElementById('saveform').disabled = false;
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
           
            
            }else{
            	document.getElementById('saveform').disabled = true;
             }
      $.ajax({
            type: 'POST',
            url: 'public/Pharmacy/dispensary/model/addTray.php',
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
                var commission=0;
                var totalcommission=0;
                for(var i=0;i<arr.length;i++){
                    if(parseFloat(arr[i].value))
                    tot += parseFloat(arr[i].value);
                    commission=parseFloat(tot)*parseFloat(facilitypercent);
                    totalcommission=parseFloat(tot)+parseFloat(commission);
                    document.getElementById('totalamount').value=totalcommission;
                    document.getElementById('commission').value=commission.toFixed(2);
                    document.getElementById('finalgrandtotal').value=totalcommission;   
                }
                
                
               /** [
               alert(costarr[con]);
               console.log(costarr[con]);**/
                
            },
            error: function () {}
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
    

               
	            $('#addDrug').click(function (e) {
	        var facilitypercent=$('#facilitypercent').val();//document.getElementById('facilitypercent');        
        	var drugcode =$('#drugid').val();
        	var check = drug.includes(drugcode);//check if drug already in tray
        	document.getElementById('saveform').disabled = false;
			
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
                    url: 'public/Pharmacy/dispensary/model/addTray.php',
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
                        var commission=0;
                        var totalcommission=0;
                        for(var i=0;i<arr.length;i++){
                            if(parseFloat(arr[i].value))
                            tot += parseFloat(arr[i].value);
                            commission=parseFloat(tot)*parseFloat(facilitypercent);
                            totalcommission=parseFloat(tot)+parseFloat(commission);
                            document.getElementById('totalamount').value=totalcommission;
                            document.getElementById('commission').value=commission.toFixed(2);
                            document.getElementById('finalgrandtotal').value=totalcommission;   
                        }
					
                        
                        
                        
                     
                        
                    },
                    error: function () {}
                });
            	//$('#drugid option:selected').remove();
            	
            }
            }
        });
    });



</script>