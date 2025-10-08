<div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Manage Payment setting <span class="pull-right">
                   
                    <!--<button onclick="document.getElementById('view').value='';document.myform.submit;">&times;</button>-->
                    </span>
                </div>
            </div>
             <input id="keys" name="keys" value="<?php echo $keys;?>" type="hidden" />
                <div class="col-sm-10 paddingclose">
                    <div class="form-group">
                    <?php $engine->msgBox($msg,$status); ?>
                        <div class="moduletitleupper"></div>
                        
                        <div class="col-sm-12 personalinfo-info">

                            <div class="form-group">
                <div class="col-sm-4 required">Description
                  <input type="text" class="form-control" id="description" name="description" value="<?php echo $description;?>" autocomplete="off">
                </div>
                <div class="col-sm-4 required">Status
                  <select name="paystatus" class="form-control">
                  <option></option>
                  <option value="1" <?php echo (($paystatus == 1)?'selected="selected"':'')?>>Pay Before service</option>
                  <option value="2" <?php echo (($paystatus == 2)?'selected="selected"':'')?>>Pay After service</option>
                  </select>
                </div>
                <div class="col-sm-4 required"></div>
            </div>
            

            <div class="btn-group pull-right">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-success" onClick="document.getElementById('viewpage').value='savesetting';document.myform.submit();"><i class="fa fa-save"></i> Save </button>
                    
                </div>
            </div>

                        </div>
                    </div>
                </div>

        </div>
    </div>
    
    
        
    
