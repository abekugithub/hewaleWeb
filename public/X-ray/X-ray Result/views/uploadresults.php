<?php $rs = $paging->paginate();?>
<div class="main-content">
    <div class="page-wrapper">

        <input type="hidden" class="form-control" id="" name="visitcode" value="<?php echo $visitcode; ?>" readonly>
		<input type="hidden" class="form-control" id="" name="patientnum" value="<?php echo $patientnum; ?>" readonly>
		<input type="hidden" class="form-control" id="" name="patient" value="<?php echo $patient; ?>" readonly>
		<input type="hidden" class="form-control" id="" name="keys" value="<?php echo $keys; ?>" readonly>
	   <input type="hidden" class="form-control" id="vkeys" name="vkeys" value="<?php echo $vkeys; ?>" readonly>
       <input type="hidden" class="form-control" id="vkey" name="vkey" value="<?php echo $vkey; ?>" readonly>
       <input type="hidden" class="form-control" id="test" name="test" value="<?php echo $test; ?>" readonly>

        <div class="page form">
            <div class="moduletitle" style="padding-bottom: 1px">
                <div class="moduletitleupper">Upload X-ray Result
                    <button type="submit" id="acceptLab" onclick="document.getElementById('view').value='labdetails';document.getElementById('viewpage').value='testdetails';document.getElementById('keys').value='<?php echo $keys; ?>';document.myform.submit();" class="btn btn-dark pull-right"><i class="fa fa-arrow-left"></i> Back </button>
                </div>
            </div>

            <?php $engine->msgBox($msg,$status); ?>

            <div class="col-sm-12 paddingclose personalinfo">
                <div class="col-sm-2">
                    <div class="id-photo">
                        <img src="<?php echo((!empty($patientphoto))?$photourl:'media/img/avatar.png');?>" alt="" id="prevphoto" style="width:100% !important; margin:0px !important;">
                    </div>
                </div>
                <div class="col-sm-10 paddingclose">
                    <div class="form-group">
                        <div class="moduletitleupper">Patient Information </div>
                        <div class="col-sm-12 personalinfo-info">

                            <table class="table personalinfo-table">
                                <tr>
                                    <td><b>Patient Number:</b> <?php echo $hewalenum;?></td>
                                    <td><b>Name:</b> <?php echo $patientname;?></td>
                                    <td><b>Date of Birth:</b> <?php echo $patientdob;?></td>
                                </tr>
                                <tr>
                                    <td><b>X-ray Test:</b> <?php echo $testname;?></td>
                                    <td><b>Phone Number:</b> <?php echo $phonenum;?></td>
                                    <td><b>Email:</b> <?php echo $email;?></td>
                                </tr>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-2"></div>
            <div class="col-sm-10">
                <div class="form-group">
<!--                    <div class="col-sm-3 required">-->
<!--                        <label for="othername">Request Number</label>-->
<!--                        <input type="text" class="form-control" id="" name="vkeys" value="--><?php //echo $keys; ?><!--" readonly>-->
<!--                    </div>-->
                    <div class="col-sm-6 required">
                        <label class="control-label" for="xrayimage">X-ray Image</label>
                        <input type="file" class="form-control" id="xrayimage" name="xrayimage" multiple accept="*/*">
<!--                        <div class="input-group">-->
<!--                            <div class="input-group-btn">-->
<!--                                <button class="btn btn-primary"><i class="fa fa-plus"></i> Add</button>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-10 required">
                        <label for="comment">Comment</label>
                        <textarea class="form-control" name="comment" id="comment"></textarea>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="btn-group pull-left">
                        <button type="button" class="btn btn-success btn-square" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='savexrayresult';document.getElementById('keys').value='<?php echo $code; ?>';document.myform.submit();" style="margin-right: 1em">Save</button>
                        <button type="submit" id="acceptLab" onclick="document.getElementById('view').value='labdetails';document.getElementById('viewpage').value='testdetails';document.getElementById('keys').value='<?php echo $keys; ?>';document.myform.submit();" class="btn btn-danger">Cancel </button>
                    </div>
                </div>
            </div>

<div id="message"></div>



        </div>

    </div>

</div>
