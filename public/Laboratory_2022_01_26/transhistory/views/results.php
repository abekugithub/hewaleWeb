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

        <input type="hidden" class="form-control" id="visitcode" name="visitcode" value="<?php echo $visitcode; ?>" readonly>
        <input type="hidden" class="form-control" id="patientnum" name="patientnum" value="<?php echo $patientnum; ?>" readonly>
        <input type="hidden" class="form-control" id="patient" name="patient" value="<?php echo $patient; ?>" readonly>
        <input type="hidden" class="form-control" id="patient" name="patientdate" value="<?php echo $patientdate; ?>" readonly>
        <input type="hidden" class="form-control" id="patient" name="Total" value="<?php echo $Total; ?>" readonly>
        <input type="hidden" class="form-control" id="patient" name="medic" value="<?php echo $medic; ?>" readonly>
        <input type="hidden" class="form-control" id="keys" name="keys" value="<?php echo $keys; ?>" readonly>
        <input type="hidden" class="form-control" id="vkey" name="vkey" value="<?php echo $vkey; ?>" readonly>
        <input type="hidden" class="form-control" id="test" name="testname" value="<?php echo $testname; ?>" readonly>
        <input type="hidden" class="form-control" id="test" name="requestcode" value="<?php echo $requestcode; ?>" readonly>

           

        <!-- <div class="page-lable lblcolor-page">Table</div> -->

        <div class="page form">
            
            <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper"><?php  echo $patient; ?></div>
             
                
                <div class="form-group" style="padding-bottom:20px;">
                <div class="col-sm-3 required">
                    <label class="control-label" for="fname">Hewale Number:</label>
                    <?php  echo $patientnum; ?>
                </div>
                <div class="col-sm-2 required">
                    <label for="othername">Date:</label>
                    <?php  echo $patientdate; ?>
                </div>
                <div class="col-sm-2 required">
                    <label for="othername">Amount ghc:</label>
                    <?php  echo $Total; ?>
                </div>
                <div class="col-sm-3 required">
                    <label for="othername">Medic Requester:</label>
                    <?php  echo $medic; ?>
                </div>

                <div class="pagination-right" id="hiddenbtn" style="padding-bottom:50px;">
						  
					<button type="submit" id="acceptLab" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit;" class="btn btn-dark"><i class="fa fa-arrow-left"></i> Back </button>
                                       
                </div>

            </div>
				
            </div>


        <div class="page form">
            <div class="moduletitle" style="padding-bottom:1">
                <div class="moduletitleupper"> Enter Results</div>
                <div class="form-group" style="padding-bottom:30px;">
                
                 <div class="col-sm-3">
                    <label for="email">Test:</label>
                    <?php  echo $encaes->decrypt($testname); ?>
                </div>
                              
            </div> 
			
        </div>
			
			
			<?php $engine->msgBox($msg,$status); ?>

            <div class="form-group">
			<div class="col-sm-2 required">
                    <label for="othername">Request Number</label>
                    <input type="text" class="form-control" id="" name="vkeys" value="<?php echo $requestcode; ?>" readonly>
                </div>
                <div class="col-sm-4 required">
                    <label for="othername">Attach</label>
					    <input type="file" name="file" id="file" class="form-control">
                </div>
                
                <div class="col-sm-4 required">
                    <label for="othername">Remark</label>
                    <!--<input type="text" class="form-control" id="" name="label" >-->
                    <textarea name= 'remark' cols="" rows="5"></textarea>
                </div>
              
            <div class="btn-group pull-right">
                <div class="col-sm-12">
                   
                <button type="button" class="btn btn-info btn-square"  onclick="document.getElementById('viewpage').value='saveresults';document.myform.submit();">Attach</button>
              
                </div>
            </div>


            
        </div>

    </div>

</div>
