<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 11/28/2017
 * Time: 10:14 AM
 */
?>
<?php
$rs = $paging->paginate();
$fdsearch = "";
?>
<?php
$report_comp_logo = "media/img/report-logo.png";
//$report_comp_name = "Hewale Hospital";
//$report_title = "Medical Record";
//$report_comp_location = "P.O.Box AC 123 Achomota Accra.".$actorcode;
//$report_phone_number = "0302 000 123";
//$report_content = '';
?>

<div class="main-content">
    <div class="page-wrapper page form">
        <div class="moduletitle">
            <div class="moduletitleupper">Signed Off Report
                <span class="pull-right">
                    <button class="form-tools" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='excelexport';document.myform.submit;" style="font-size:18px; padding-top:-10px;" title="Generate Excel">
                        <i class="fa fa-file-excel-o"></i>
                    </button>
                    <button class="form-tools" onclick="document.getElementById('view').value='report';document.getElementById('viewpage').value='pdfexport';document.myform.submit;" style="font-size:18px; padding-top:-10px;" title="Generate PDF">
                        <i class="fa fa-file-pdf-o"></i>
                    </button>
                    <button type="button" class="form-tools print-block" onclick="printDiv('printReport')" style="font-size:18px; padding-top:-10px;" title="Print Document">
                        <i class="fa fa-print"></i>
                    </button>
                    <button class="form-tools" onclick="document.getElementById('view').value='';document.myform.submit;" style="font-size:25px; padding-top:-10px; line-height:1.3em" title="Close">&times;</button>
                </span>
            </div>
        </div>
        <iframe allowtransparency="1" frameborder="0" src="<?php echo $printpath; ?>" id="printframe" name="printframe" style="width:100%; height:920px; border:1px #000000 solid; padding:1px;"></iframe>

    </div>
</div>
<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>