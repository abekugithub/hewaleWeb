<?php
$rs = $paging->paginate();
?>

    <div class="main-content">

        <div class="page-wrapper">

            <?php $engine->msgBox($msg,$status); ?>

            <div class="page form">
                <div class="moduletitle">
                    <div class="moduletitleupper">Reset Password</div>
                </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-sm-6">
                                <label for="password">New Password:</label>
                                <input type="password" class="form-control" id="pwd" name="pwd" value="" autocomplete="off">
                            </div>
                            <div class="col-sm-6">
                                <label for="password2">Re-Enter Password:</label>
                                 <input type="password" class="form-control" id="pwd2" name="pwd2" value="" autocomplete="off">
                            </div>
                           
                        </div>
              
                    

                        <div class="btn-group">
                            <div class="col-sm-12">
                                 <button type="submit" onclick="document.getElementById('keys').value='<?php echo $keys ;?>';document.getElementById('view').value='';document.getElementById('viewpage').value='resetpwd';document.myform.submit;" class="btn btn-info"><i class="fa fa-plus-circle"></i> Save </button>
                                <button type="submit" class="btn btn-danger" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit;">Cancel</button>
                            </div>
                        </div>
                    </div>

                    

            </div>
        </div>
    </div>