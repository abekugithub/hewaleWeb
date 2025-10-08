<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 12/8/2017
 * Time: 1:32 PM
 */?>
<script>
    $(document).ready(function () {
        var data = $('#myform').serializeArray();

        $.ajax({
            type: 'POST',
            url: 'public/Laboratory Reports/Signed Off Report/model/fetch.php',
            data: data,
            success: function (e) {
                if(e.match('<tr>')){
                    $('.report-content').html(e);
                }

            },
            error: function (e) {}
        });

    });
</script>
