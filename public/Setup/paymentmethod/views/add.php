<div class="main-content">
    <div class="page-wrapper">
        <input id="search" name="search" value="" type="hidden" class="form-control"/>
        <div class="page form">
            <div class="moduletitle">

               <div class="moduletitleupper">Payment Scheme
            <div class="pull-right btn-group">
                    <button type="submit" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit();" class="btn btn-dark btn-square" style="margin-right: 5px"><i class="fa fa-arrow-left"></i> Back </button>
                   
                </div>
                </div>

            </div>
<!--            <div class=""></div>-->
            <div class="col-sm-12 row">
            
                <div class="form-group">
                    <div class="col-sm-4">
                        <label for="">Payment Category</label>
                        <select name="category" id="category" class="form-control select2">
                            <option value="" selected disabled>Select Category</option>
                            <?php if(is_array($catarray) && count($catarray)>0){
                                foreach ($catarray as $value){?>
                                    <option value="<?php echo $value['CATEGORY_CODE']?>" <?php echo ($value['CATEGORY_CODE']==$category)?"selected":''; ?> ><?php echo $value['CATEGORY_NAME']?></option>
                                <?php }}?>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="">Payment Type</label>
                        <input type="text" class="form-control" id="paymenttype" name="paymenttype">
                    </div>
                    <div class="col-sm-4">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="description"></textarea>
                    </div>
                </div>
                <div class="form-group pull-right">
                    <div class="col-sm-12 row">
                        <button name="savescheme" id="savescheme" class="btn btn-success"><i class="fa fa-check"></i> Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
