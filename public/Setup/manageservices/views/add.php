<div class="main-content">
    <div class="page-wrapper">
        <?php $engine->msgBox($msg,$status); ?>
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Add Service</div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <div class="col-sm-12">
                        <label for="fname">Service:</label>
                        <select name="service" id="service" class="form-control select2">
                            <option value="" disabled selected>Select Service</option>
                            <?php
                            while ($obj = $stmtservices->FetchNextObject()){?>
                                <option value="<?php echo $obj->SERV_CODE?>" <?php echo ($service==$obj->SERV_CODE)?'selected':''?>><?php echo $obj->SERV_NAME?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-12">
                        <label for="userlevel">Department:</label>
                        <select name="userlevel" id="userlevel" class="form-control" required>
                            <option>Select Department</option>
                            <?php
                            $stmtlevel = $engine->getUserLevelLoading();
                            while($objlvl = $stmtlevel->FetchNextObject()){
                                ?>
                                <option value="<?php echo $objlvl->FACLV_ID ?> "  <?php echo (($userlevel == $objlvl->FACLV_ID)?'Selected':'') ?>><?php echo $objlvl->FACLV_USRLEVEL;?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <label for="othername">Description:</label>
                        <textarea class="form-control" cols="20" name="description" id= "description">
                                    <?php echo $description ;?>
                                </textarea>
                    </div>
                    <div class="col-sm-12">
                        <label for="status">Status</label>
                        <select class="form-control" name="usrstatus" id="usrstatus">
                            <option value="1" <?php echo (($usrstatus == 1)?'Selected':'') ?>>Enable</option>
                            <option value="0" <?php echo (($usrstatus == 0)?'Selected':'') ?>>Disable</option>
                        </select>
                    </div>
                </div>
                <div class="btn-group">
                    <div class="col-sm-12">
                        <button type="submit" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='saveservice';document.myform.submit;" class="btn btn-info"><i class="fa fa-plus-circle"></i> Save </button>
                        <button type="submit" class="btn btn-danger" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit;">Cancel</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>