<div class="main-content">

    <div class="page-wrapper">

        <?php $engine->msgBox($msg,$status); ?>

        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Manage Lab
                    <button type="submit" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit();" class="btn btn-dark" style="float: right"><i class="fa fa-arrow-left"></i> Back </button>
                </div>
            </div>

<!--            <div class="col-sm-4 ">-->
<!--                <label class="control-label" for="fname">Date</label>-->
<!--                <input type="text" class="form-control" id="fname" name="startdate">-->
<!--            </div>-->
            <div class="col-sm-4">
                <label>Lab Test</label><br />
                <select name="labtest" id="labtest" class="form-control" tabindex="2">
                    <option value="0"> -- Select Test --</option>
                    <?php while($obj = $stmttestlov->FetchNextObject()){  ?>
                        <option value="<?php echo $obj->LTT_CODE.'@@@'.$obj->LTT_NAME ;?>" <?php echo (($obj->LTT_CODE == $labtest)?'selected':'' )?> ><?php echo $obj->LTT_NAME ;?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-sm-4">
                <label for="fname">Price:</label>
                <input type="text" class="form-control" id="testprice" name="testprice" value="<?php echo (!empty($testprice)?$testprice:'');?>" autocomplete="off" >
            </div>
            <div class="col-sm-12">
                <button type="submit" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='savelab';document.myform.submit();" class="btn btn-info"><i class="fa fa-plus-circle"></i> Save </button>
                <button type="submit" class="btn btn-danger" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit;">Cancel</button>
            </div>

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