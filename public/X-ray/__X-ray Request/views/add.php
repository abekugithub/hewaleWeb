<?php $rs = $paging->paginate();?>
<style type="text/css">
    .demo {
        position: relative;
    }

    .demo i {
        position: absolute;
        bottom: 10px;
        right: 24px;
        top: auto;
        cursor: pointer;
    }
</style>
<style>
.rowdanger{
	background-color:#97181B4D}
.rowwarning{
	background-color:#EBECB9}
.rowinfo{
	background-color:#C0C0C0}
</style>
 
<div class="main-content">
    <div class="page-wrapper">

        <input type="hidden" class="form-control" id="" name="visitcode" value="<?php echo $visitcode; ?>" readonly>
		<input type="hidden" class="form-control" id="" name="patientnum" value="<?php echo $patientnum; ?>" readonly>
		<input type="hidden" class="form-control" id="" name="patient" value="<?php echo $patient; ?>" readonly>
		<input type="hidden" class="form-control" id="" name="keys" value="<?php echo $keys; ?>" readonly>
	   <input type="hidden" class="form-control" id="vkeys" name="vkeys" value="<?php echo $vkeys; ?>" readonly>  
       <input type="hidden" class="form-control" id="vkey" name="vkey" value="<?php echo $vkey; ?>" readonly>   
       <input type="hidden" class="form-control" id="test" name="test" value="<?php echo $test; ?>" readonly>
		
           

        <!-- <div class="page-lable lblcolor-page">Table</div> -->
        <div class="page form">
            <div class="moduletitle" style="padding-bottom: 1px">
                <div class="moduletitleupper">Upload X-ray Result</div>
                <div class="form-group" style="padding-bottom:30px;">
                    <div class="col-sm-3 required">
                        <label class="control-label" for="fname">Patient Name:</label>
                        <?php  echo $patient; ?>
                    </div>
                    <div class="col-sm-3 required">
                        <label for="othername">Hewale Number:</label>
                        <?php  echo $patientnum; ?>
                    </div>
                    <div class="col-sm-3">
                        <label for="email">X-Ray:</label>
                        <?php  echo $test; ?>
                    </div>
                </div>
            </div>
			
			<?php $engine->msgBox($msg,$status); ?>

            <div class="form-group">
                <div class="col-sm-3 required">
                        <label for="othername">Request Number</label>
                        <input type="text" class="form-control" id="" name="vkeys" value="<?php echo $keys; ?>" readonly>
                    </div>
                    <div class="col-sm-4 required">
                        <label class="control-label" for="fname">X-ray Image</label>
                        <input type="file" class="form-control" id="xrayimage" name="xrayimage" accept="image/*">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12 required">
                        <label for="comment">Comment</label>
                        <textarea class="form-control" name="comment" id="comment"></textarea>
                    </div>
                </div>
                <div class="btn-group pull-right">
                    <div class="col-sm-12">
                       <button type="button" class="btn btn-success btn-square"  onclick="document.getElementById('viewpage').value='savespecimen';document.myform.submit();">Save</button>
                       <button type="submit" id="acceptLab" onclick="document.getElementById('view').value='labdetails';document.getElementById('viewpage').value='testdetails';document.getElementById('keys').value='<?php echo $keys; ?>';document.myform.submit();" class="btn btn-dark"><i class="fa fa-arrow-left"></i> Back </button>
                    </div>
            </div>

<div id="message"></div>


            
        </div>

    </div>

</div>
