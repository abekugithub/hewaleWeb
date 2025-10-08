<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 11/28/2017
 * Time: 11:20 AM
 */?>
<script>
    $(document).ready(function () {
        var datefrom = $('#datefrom').val();
        var dateto = $('#dateto').val();

        var data = $('#myform').serializeArray();

//        $('#report').click(function () {
            $.ajax({
                type: 'POST',
                url: 'public/Laboratory Reports/Lab. Request Report/model/labrequestreport.php',
                data: data,
                success: function (e) {
                    if(e.match('<tr>')){
                        $('.report-content').html(e);

                    }
                },
                error: function (e,jqXHR, status) {

                }
            });
//        });
    });
</script>
