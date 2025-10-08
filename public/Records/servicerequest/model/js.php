<script>
	$(document).ready(function () {
        $('#prescriberdiv').hide();
        $('#doctordiv').hide();
        $('input').attr('autocomplete', 'off');
         /**$('#cardnum').hide();
        $('#cardexpire').hide();

       
		
            $('#add').click(function (e) {

            e.preventDefault();
            var data = $('#myform').serializeArray();

            $.ajax({
                type: 'POST',
                url: 'public/Records/patientregistration/model/save.php',
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
            if ((targetid == '#personal' || targetid == '#emergency' || targetid == '#health' || targetid == '#family'))
            {
                var data = $('#myform').serializeArray();
                $.ajax({
                    type: 'POST',
                    url: "public/Records/patientregistration/model/savepatient.php",
                    data: data,
                    success: function (e) {
                        $('#patientnum').val(e);
                    }


                });
            }
        });
**/
        $('#service').change(function () {
            var code = $(this).val().split('@@@');
            var firstcode = code[0];
           if (firstcode == 'SER0001'){  //  Prescriber
               
    $('#prescriberdiv').show();
           }else {
               $('#prescriberdiv').hide();
           }
        });


        $('#prescribe').change(function () {
            
            var code = $(this).val().split('@@@');
            var firstcode = code[0];
            $('#doctordiv').show();
            if (firstcode == 'SER0001'){  //  Prescriber
           }else {
               //$('#doctordiv').hide();
           }
        });

	});
	
	/**function deleteRelation(e){
		
	$.ajax({
			type: 'POST',
			url: 'public/Records/patientregistration/model/delete.php',
			data: { 'keys': e ,'patientnum': $('#patientnum').val()},
			success: function (e) {
				$('#family table tbody').html(e);	
			},
		});
}**/

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
</script>