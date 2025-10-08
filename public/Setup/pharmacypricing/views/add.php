<div class="main-content">
    <div class="page-wrapper">
        <?php $engine->msgBox($msg,$status); ?>
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Manage Pharmacy Pricing</div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label>Drug</label><br />
                    <select name="drug" id="drug" class="form-control select2" tabindex="2">
                        <option value="<?php echo $drug; ?>">-- Select Drug --</option>
                        <?php while($obj = $stmtservicelov->FetchNextObject()){  ?>
                            <option value="<?php echo $obj->DR_CODE.'@@@'.$obj->DR_NAME ;?>" <?php echo (($obj->DR_CODE == $drug)?'selected':'' )?> ><?php echo $obj->DR_NAME ;?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-4">
                    <label>Payment Method</label><br />
                    <select name="paymeth" id="paymeth" class="form-control select2" tabindex="2">
                        <option value="<?php echo $paymeth; ?>"> -- Select Payment Method --</option>
                        <?php while($obj = $stmtpayschemelov->FetchNextObject()){  ?>
                            <option value="<?php echo $obj->PAYM_CODE.'@@@'.$obj->PAYM_NAME ;?>" <?php echo (($obj->PAYM_CODE == $paymeth)?'selected':'' )?> ><?php echo $obj->PAYM_NAME ;?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-4">
                    <label for="fname">Price:</label>
                    <input type="text" class="form-control" id="price" name="price" value="<?php echo $price;?>" autocomplete="off" >
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <button type="submit" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='saveprice';document.myform.submit;" class="btn btn-info"><i class="fa fa-plus-circle"></i> Save </button>
                    <button type="submit" class="btn btn-danger" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit;">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>