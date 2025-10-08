<script>
    $(document).ready(function () {
		
		$('#file').change(function(){
		var file = this.files[0];
		var imagefile = file.type;
		var match= ["application/vnd.openxmlformats-officedocument.wordprocessingml.document","application/pdf"];
		if(!((imagefile==match[0]) || (imagefile==match[1])))
		{
		//$('#previewing').attr('src','photo.jpg');
		$("#message").html("<div  class='alert alert-danger alert-dismissible'>Please Select A valid Image File.Only docx and pdf Files type allowed</div>");
		return false;
		}else{
		$("#message").html('');
		
		var reader = new FileReader();
		reader.onload = imageIsLoaded;
		reader.readAsDataURL(this.files[0]);
		}			
		})

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

        $('#acceptLab').click(function (e) {
            $.ajax({
                type: 'POST',
                url: 'public/Laboratory/Lab Request/model/acceptLab.php',
                data: '',
                success: function (e) {

                }
            });
        });
    });
</script>