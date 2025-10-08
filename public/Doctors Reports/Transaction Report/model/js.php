<script>
    $(document).ready(function () {
       //alert('hi');
        var data = $('#myform').serializeArray();
        $.ajax({
            type: 'POST',
            url: 'public/Doctors Reports/Transaction Report/model/fetch.php',
            data: data,
            success: function (e) {
                if(e.match('<tr>')){
                    $('.report-content').html(e);
                }
            },

            error: function (e) {
            }
        });
       // alert('hi');
    });
</script>