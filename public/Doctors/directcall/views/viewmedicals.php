<div class="main-content">
    <div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Medical History <span class="pull-right">
                    <button class="btn btn-dark" onclick="document.getElementById('view').value='history';document.getElementById('viewpage').value='historyback';document.myform.submit;"><i class="fa fa-arrow-left"></i> Back</button>
                    </span>
                </div>
            </div>

            <div class="col-sm-12 conshistoryinfo">

                <div class="col-sm-3">
                    <b>Diagnosis:</b>
                </div>
                <div class="col-sm-8">
                    <?php echo $diagnosishes;?>
                </div>

                <div class="col-sm-3">
                    <b>Lab Request:</b>
                </div>
                <div class="col-sm-8">
                    <?php echo $labshes;?>
                </div>

                <div class="col-sm-3">
                    <b>Prescription:</b>
                </div>
                <div class="col-sm-8">
                    <?php echo $patpresc;?>
                </div>

            </div>
        </div>
    </div>

</div>