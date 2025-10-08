<script>
    $(document).ready(function(e) {
        /* Disable Autofill for all Inputs */
        $('input').attr('autocomplete', 'off');
        
        $('#totalcost').on('keydown keyup',function (e) {
            $('#totalamount').val($(this).val());
        });

        /*
         * Auto refresh the consultaiton list
         */
        setInterval( function() {
            $.ajax({
                type: 'POST',
                url: 'public/Delivery/pendingdelivery/model/fetch.php',
                dataType: 'json',
            //    data: {"activeinstitution":"<?php echo $activeinstitution;?>","usrcode":"<?php echo $usrcode;?>"},
                success: function(e){
                    $('tbody.tbody').html(e);
                    if( e [0] === '<tr><td colspan="10">No Record found...</td></tr>'){
                        $('#totalVals').html('0');
                    }else{
                        $('#totalVals').html(e.length.toString());
                    }
                    

                },
            });
            $.ajax({
                type: 'POST',
                url: 'public/Delivery/pendingdelivery/model/fetchPending.php',
                dataType: 'json',
           //     data: {"activeinstitution":"<?php echo $activeinstitution;?>","usrcode":"<?php echo $usrcode;?>"},
                success: function(e){
//                    $('tbody.tbody').html(e);
                    $('#countVals').html(e.toString());
                },
            });
        }, 30000);
    });
</script>