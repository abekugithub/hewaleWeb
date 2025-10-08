<form name="myform" id="myform" method="post" action="#">
    <input id="view" name="view" value="" type="hidden" />
    <input id="viewpage" name="viewpage" value="" type="hidden" />
    <input id="keys" name="keys" value="" type="hidden" />
    <input id="micro_time" name="micro_time" value="<?php echo md5(microtime()); ?>" type="hidden" />
    <div class="content">
        <div class="page-header">
            <h1 class="title">Add Transaction</h1>
            <!--<ol class="breadcrumb">
      <li class="active">&nbsp;</li>
    </ol>-->

            <!-- Start Page Header Right Div -->
            <div class="right">
                <div class="btn-group">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-gyn-teal square" onClick="document.getElementById('viewpage')
                    .value='add_tithe';document.myform.submit;"><i class="fa fa-check"></i> Save
                  </button>
                        <button type="button" onClick="document.getElementById('view').value='';$('#myform').submit();" class="btn btn-danger square"><i class="fa fa-dark"></i>Cancel
                  </button>

                    </div>

                </div>
            </div>
            <!-- End Page Header Right Div -->

        </div>
        <!-- End Page Header Right Div -->


        <?php $engine->msgBox($msg,$status); ?>
        <div class="panel-body table-responsive form">
            <div class="form-group form input_fields_wrap has-response">
                <div class="col-sm-12">
                    <div class="col-sm-2">
                        <label>Options</label>
                        <select class="form-control" id="optname" name="trans[optname][]" required>
                  <option>---</option>
                  <?php foreach($data as $row){?>
                    <option value="<?php echo $row -> TRANS_OPTID ?>"><?php echo $row -> TRANS_OPTNAME ?></option>
					<?php }?>
                  </select>
                    </div>
                    <div class="col-sm-4">
                        <input type="hidden" class="form-control" id="memid" name="trans[memid][]" />
                        <label>Member Name</label>
                        <input type="text" class="form-control" id="titname" name="memname" placeholder="Member Name" required>
                        <input type="hidden" name="tithname">
                    </div>

                    <div class="col-sm-4">
                        <label>Amount</label>
                        <input type="numbers" class="form-control" id="titamount" name="trans[tranamount][]" placeholder="Amount" required>
                    </div>

                    <div class="col-sm-2 offering">
                        <button type="button" class="btn btn-gyn-teal square add_field_button"><i class="fa fa-plus"></i>
                  </button>
                    </div>

                    <div class="col-sm-10">
                        <label>Narration</label>
                        <textarea type="text" class="form-control" id="narration" name="trans[narration][]" placeholder="Narration"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="space"></div>
    </div>
</form>


<script>
    $(document).ready(function () {
        var max_fields = 5; //maximum input boxes allowed
        var wrapper = $(".input_fields_wrap"); //Fields wrapper
        var add_button = $(".add_field_button"); //Add button ID

        var x = 0; //initlal text box count
        $(add_button).click(function (e) { //on add input button click
            e.preventDefault();

            if (x < max_fields) { //max input box allowed
                x++; //text box increment
                $(wrapper).append('<div class="col-sm-12" id="main_' + x +
                    '">   <div class="col-sm-2"><label>Options</label><select  class = "form-control" id = "optname" name = "trans[optname][]" required ><option>---</option><?php foreach($data as $row){?><option value="<?php echo $row -> TRANS_OPTID ?>"><?php echo $row -> TRANS_OPTNAME ?></option><?php }?></select></div><div class="col-sm-4"> <input type = "hidden" class = "form-control" id = "memid' +
                    x +
                    '" name = "trans[memid][]"/><label>Member Name</label><input type = "text" class = "form-control" id = "titname' +
                    x +
                    '" name = "memname" placeholder = "Member Name" required></div><div class="col-sm-4"><label>Amount</label><input type = "text" class = "form-control" id = "titamount" name = "trans[tranamount][]" placeholder = "Amount" requied></div><div class="col-sm-1 gyn-add"><a class="btn btn-gyn-add square" onClick="remove_cont(' +
                    x +
                    ');"><i class="fa fa-close"></i></a></div><div class="col-sm-10"><label>Narration</label><textarea type = "text" class = "form-control" id = "narration" name = "trans[narration][]" placeholder = "Narration"></textarea></div></div>'
                ); //add input box
                adddata(x);
            }
        });
    });


    function remove_cont(x) {
        $('#main_' + x).remove();
        x--;
    };
</script>

<script>
    function adddata(a) {
        $('#titname' + a).autocomplete({
            source: 'public/transactions/views/fetch.php',
            select: function (event, ui) {
                $('#titname' + a).val(ui.item.label);
                $('#memid' + a).val(ui.item.value);
                return false;
            },
        });
    };
    $(function () {
        $("#titname").autocomplete({
            source: 'public/transactions/views/fetch.php',
            select: function (event, ui) {
                $("#titname").val(ui.item.label);
                $("#memid").val(ui.item.value);
                return false;
            },

        });
    });
</script>