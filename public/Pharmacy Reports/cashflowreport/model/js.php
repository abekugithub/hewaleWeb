<script>
    $(document).ready(function () {

        let data = $('#myform').serializeArray();
        $.ajax({
            type: 'POST',
            url: 'public/Pharmacy Reports/cashflowreport/model/fetch.php',
            data: data,
            success: function (e) {
                if(e.match('<tr>')){
                    $('.report-content').html(e);

                }

            },
            error: function (e) {

            }
        });

    });
</script>