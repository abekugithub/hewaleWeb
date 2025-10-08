<?php $engine->msgBox($msg,$status); ?>
<div class="main-content">
    <div class="page-wrapper">
            <div class="page form">
                <form action="" method="post" enctype="multipart/form-data" name="myform">
                    <input type="hidden" name="views" value="" id="views" class="form-control" />
                    <input type="hidden" name="viewpages" value="" id="viewpages" class="form-control" />
                    <input type="hidden" name="action_search" value="" id="action_search" class="form-control" />
                    <input type="hidden" name="key" value="<?php echo $key; ?>" id="key" class="form-control" />
                    <input type="hidden" name="patkey" value="<?php echo $patkey; ?>" id="patkey" class="form-control" />
                    <input type="hidden" class="form-control" id="patientnum" name="patientnum" value="<?php echo $patientnum; ?>" >
                    <input type="hidden" class="form-control" id="patientcode" name="patientcode" value="<?php echo $patientcode; ?>" >
                    <input type="hidden" class="form-control" id="patientname" name="patientname" value="<?php echo $patient_fullname; ?>" >

                <div class=" col-sm-4 pull-right">
                    <div class="pull-right btn-group">
                        <button type="button" onclick="document.getElementById('views').value='';document.getElementById('viewpage').value='';document.myform.submit();" class="btn btn-dark btn-square"><i class="fa fa-arrow-left"></i> Back </button>
<!--                        <button type="submit" onclick="document.getElementById('views').value='';document.getElementById('viewpages').value='save';document.myform.submit;" class="btn btn-info"> Save </button>-->
                    </div>
                </div>

                <div class="moduletitle">
                    <div class="moduletitleupper">Upload Lab Setup</div>
                </div>

            <div class="form-group">
                <div class="col-sm-12">
                    <div class="col-sm-6">
                        <label for="lastname">File:</label>
                        <input type="file" class="form-control" id="patientupload" name="patientupload" required>
                    </div>
                    <div class="col-sm-6" style="margin-top: 25px">
                        <button type="button" class="btn btn-success" onclick="document.getElementById('views').value='';document.getElementById('viewpages').value='uploadfile';document.myform.submit();"><i class="fa fa-save"></i> Save</button>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <h3>Sample upload file</h3>
                    <p>Be sure the file to be uploaded looks like the sample file below. File should be an Excel Worksheet with extension (.xlsx)</p>
                    <div class="col-sm-12 img-responsive">
                        <img src="media/uploaded/labresult/labsetup.png" width="400" height="200"  />
                    </div>
                </div>

            </div>
        </div>
    </div>



</div>

