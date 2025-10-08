<script>
    $(document).ready(function(e) {
        /* Disable Autofill for all Inputs */
        $('input').attr('autocomplete', 'off');
        
        $('#totalcost').on('keydown keyup',function (e) {
            var totalcost = $(this).val();
            var percenttotal = isNaN((($('#instpercentage').val() / 100) * totalcost) + parseFloat(totalcost))?0:(($('#instpercentage').val() / 100) * totalcost) + parseFloat(totalcost);
            $('#totalamount').val(percenttotal);
        });

        /*
         * Auto refresh the consultaiton list
         */
        setInterval( function() {
            $.ajax({
                type: 'POST',
                url: 'public/Pharmacy/pendingdispensary/model/fetch.php',
                dataType: 'json',
                data: {"activeinstitution":"<?php echo $activeinstitution;?>","usrcode":"<?php echo $usrcode;?>"},
                success: function(e){
                    $('tbody.tbody').html(e);
                    if (e[0] === '<tr><td colspan="10">No Record found...</td></tr>'){
                        $('#totalVals').html('0');
                    }else{
                        $('#totalVals').html(e.length.toString());
                    }
                },
            });
            $.ajax({
                type: 'POST',
                url: 'public/Pharmacy/pendingdispensary/model/fetchPending.php',
                dataType: 'json',
                data: {"activeinstitution":"<?php echo $activeinstitution;?>","usrcode":"<?php echo $usrcode;?>"},
                success: function(e){
//                    $('tbody.tbody').html(e);
                    $('#countVals').html(e.toString());
                },
            });
        }, 30000);
    });
</script>