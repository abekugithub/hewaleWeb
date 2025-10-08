<div class="main-content">

        <div class="page-wrapper">

            <?php $engine->msgBox($msg,$status); ?>

            <div class="page form">
                <div class="moduletitle">
                    <div class="moduletitleupper">Upload Drugs
                    <div class="pull-right btn-group">
                    <button type="submit" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit();" class="btn btn-dark btn-square" style="margin-right: 5px"><i class="fa fa-arrow-left"></i> Back </button>
                   </div>
                   </div>
                </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                <div class="form-group">
                    <label for="upload">Select File</label>
                    <input type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" class="form-control" name="uploadinput" id="upload" />
                </div>
                <div class="form-group">
                    <button type="submit" onclick="document.getElementById('viewpage').value='upload';document.getElementById('view').value='';" class="btn btn-square btn-success"><i class="fa fa-upload"></i> Upload</button>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-10">
                    <h4>Sample upload file.</h4>
                    <p> Be sure the file to be uploaded looks like the sample file below. File should be an Excel Worksheet with extension (.xlsx) </p>
                    <img src="media/img/sample2.png">
                </div>
            </div>

                    </div>

                    

            </div>
        </div>
    </div>
    