<script>
    $(document).ready(function () {
		
		 $('#selcheckall').click(function(event) { 
		  //on click 
        if(this.checked) { // check select status
            $('.selcheck').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"               
            });
        }else{
            $('.selcheck').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
            });         
        }
    });
	
	$('#acceptLab').click(function(){
  /*if(confirm("Are you sure you want to Validate this?"))
  {*/
   var id = [];
   
   $(':checkbox:checked').each(function(i){
    id[i] = $(this).val();
   });
   //alert(id);
  $('#labcode').val(id);
   alert(id);
   if(id.length === 0) //tell you if the array is empty
   {
    alert("Please Select at least one checkbox");
	 $("#myform").submit(function(){
                return true;
            });
   }
   
   else
   {
	   
	
    $.ajax({
     url:'public/laboratory/Lab Request/model/acceptrequest.php?patientnum=<?php echo $patientnum; ?>',
     method:'POST',
     data:{id:id},
     success:function(data)
     {
		 $('.selcheck:checkbox:checked').parents("tr").remove();
		 
		 $('#message').html("<div class='alert alert-success' id='message'>You have accepted to perform the lab. request for patient </div>");
		 <?php 
		 $logmsg = "lab request accepted successfully";
		 $engine->setEventLog("028",$logmsg);
			?>
			 return true;
			
			  var line='<tr id="tabtn' + x++ + '"><td>' + i++ + '</td><td>'+ $('#vitals_type').val()+'</td><td>'+ $('#vitals-value').val()+'</td></tr>';
        $('#labdata').append(line);
         }
    });
	
   }
   
 
 });
 
 $('#decline').click(function(){
	
  /*if(confirm("Are you sure you want to Validate this?"))
  {*/
   var id = [];
 
   
   $(':checkbox:checked').each(function(i){
    id[i] = $(this).val();
   });
   if(id.length === 0) //tell you if the array is empty
   {
    alert("Please Select at least one checkbox");
	 $("#myform").submit(function(){
                return true;
            });
   }
   
   else
   {
	
    $.ajax({
     url:'public/laboratory/Lab Request/model/rejectrequest.php',
     method:'POST',
     data:{id:id},
     success:function()
     {
		 $('.selcheck:checkbox:checked').parents("tr").remove();
		 
		 $('#message').html("<div class='alert alert-success' id='message'>You have rejected to perform the lab. request for patient </div>");
		 <?php 
		 $logmsg = "lab request Rejected successfully";
		 $engine->setEventLog("029",$logmsg);
			?>
			 return true;
         }
    });
	
   }
   
 
 });
 	
        "use_strict";

        // This array will store the values of the "checked" vehicle checkboxes
        var cboxArray = [];

        // Check if the vehicle value has already been added to the array and if not - add it
        function itemExistsChecker(cboxValue) {

            var len = cboxArray.length;

            if (len > 0) {
                for (var i = 0; i < len; i++) {
                    if (cboxArray[i] == cboxValue) {
                        return true;
                    }
                }
            }

            cboxArray.push(cboxValue);
        }

        $('input[type="checkbox"]').each(function() {

            var cboxValue = $(this).val();
            var cboxChecked = localStorage.getItem(cboxValue) == 'true' ? true : false;

            // On page load check if any of the checkboxes has previously been selected and mark it as "checked"
            if (cboxChecked) {

//                $(this).prop('checked', true);
//                itemExistsChecker(cboxValue);

            }

            // On checkbox change add/remove the vehicle value from the array based on the choice
            $(this).change(function() {

                localStorage.setItem(cboxValue, $(this).is(':checked'));

                if ($(this).is(':checked')) {

                    itemExistsChecker(cboxValue);

                } else {

                    // Delete the vehicle value from the array if its checkbox is unchecked
                    var cboxValueIndex = cboxArray.indexOf(cboxValue);

                    if (cboxValueIndex >= 0) {
                        cboxArray.splice( cboxValueIndex, 1 );
                    }

                }

                console.log(cboxArray);

            });

        });

        console.log(cboxArray);
//        document.getElementById('keys').value=cboxArray;

        /*$('#acceptLab').click(function (e) {
            $.ajax({
                type: 'POST',
                url: 'public/Laboratory/Lab Request/model/acceptLab.php',
                data: '',
                success: function (e) {

                }
            });
        });*/
    });
</script>