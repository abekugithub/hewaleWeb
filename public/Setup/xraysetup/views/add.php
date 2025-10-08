<div class="main-content">
    <div class="page-wrapper">
        <form action="" method="post" id="myform" name="myform" enctype="multipart/form-data">
            <input type="hidden" id="keys" name="keys" value="<?php echo $keys; ?>" />
            <input type="hidden" id="target" name="target" value="<?php echo $target; ?>" />
        <?php $engine->msgBox($msg,$status); ?>
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">X-ray Price Setup
                    <button class="btn btn-dark pull-right" onclick="document.getElementById('view').value='';document.getElementById('target').value='';document.myform.submit();"><i class="fa fa-arrow-left"></i> Back</button></div>
            </div>
            <div class="col-sm-4">
                <label>Test</label><br />
                <select name="xraytest" id="xraytest" class="form-control" tabindex="1">
                    <option value="" selected disabled>-- Select Test --</option>
                    <?php while($obj = $stmtxraytest->FetchNextObject()){  ?>
                        <option value="<?php echo $obj->X_CODE.'@@@'.$obj->X_NAME ;?>" <?php echo (($obj->X_CODE == $testcode)?'selected':'' )?> ><?php echo $obj->X_NAME ;?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-sm-4">
                <label>Price</label><br />
                <input type="number" class="form-control" name="xray_testprice" id="xray_testprice" value="<?php echo $xray_testprice; ?>" pattern="[0-9]" min="1"/>
            </div>

            <div class="col-sm-12">
                <button type="submit" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='saveprice';document.myform.submit();" class="btn btn-info"><i class="fa fa-plus-circle"></i> Save </button>
                <button type="submit" class="btn btn-danger" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit();">Cancel</button>
            </div>

        </div>
    </div>
</div>

<script>
    /* Script to auto select sub tree checkboxes */
    $(".gyn-treeview").delegate("label input:checkbox", "change", function() {
        var checkbox = $(this),
            nestedList = checkbox.parent().next().next(),
            selectNestedListCheckbox = nestedList.find("label:not([for]) input:checkbox");
        if (checkbox.is(":checked")) {
            return selectNestedListCheckbox.prop("checked", true);
        }
        selectNestedListCheckbox.prop("checked", false);
    });

</script>