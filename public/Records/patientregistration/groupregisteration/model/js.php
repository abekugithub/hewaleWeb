<script>
    $(document).ready(function () {
        var getdata;
        $('.panel-warning').hide();
       $('#newgroup').click(function (e) {
           e.preventDefault();
           var groupname = $('#groupname').val();
           var grouptype = $('#grouptype').val();
           if (groupname != ''){
               $.ajax({
                   type: 'POST',
                   url: 'public/Records/patientregistration/groupregisteration/model/savegroupname.php',
                   data: {'groupname':groupname,'grouptype':grouptype},
                   dataType: 'json',
                   cache: false,
                   success: function (data) {
                       if (data){

                           console.log('hello');
                           console.log(data);
                           $('#groupcode').val(data);
                       }
                       document.getElementById('groupcode').value = data;
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
//                       $('#myform').submit();
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
    });

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