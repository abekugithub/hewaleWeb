<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 11/28/2017
 * Time: 10:14 AM
 */
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
    <input type="text" name="hiddatefrom" id="hiddatefrom" value="<?php echo (empty($datefrom)?$hiddatefrom:$datefrom); ?>" class="form-control">
    <input type="text" name="hiddateto" id="hiddateto" value="<?php echo (empty($dateto)?$hiddateto:$dateto); ?>" class="form-control">
    <div class="page-wrapper page form">
        <div class="moduletitle">
            <div class="moduletitleupper">Laboratory Request Report
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
        <div class="page-report" id="printReport" style="width: 85%">
            <div class="row report-title">
                <div class="col-sm-3">
                    <img src="<?php echo $report_comp_logo; ?>"/>
                    <h5><?php echo $facilityname; ?></h5>
                </div>
                <div class="col-sm-6">
                    <h4><?php echo $report_title; ?></h4>
                </div>
                <div class="col-sm-3">
                    <span><b>Location:</b> <?php echo $facilitylocation; ?></span><br><br>
                    <span><b>Phone Number:</b> <?php echo $facilityphoneno; ?></span><br><br>
                </div>
            </div>
            <table class="table table-responsive">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Patient Name</th>
                    <th>Hewale No.</th>
                    <th>Lab. Test</th>
                    <th>Discipline</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                <?php
//                if ($stmt->RecordCount()>0){
//                    $num = 0;
//                    while ($obj = $stmt->FetchNextObject()){?>
<!--                        <tr>-->
<!--                            <td>--><?php //echo $n++?><!--</td>-->
<!--                            <td>--><?php //echo $obj->LT_PATIENTNAME?><!--</td>-->
<!--                            <td>--><?php //echo $obj->LT_PATIENTCODE?><!--</td>-->
<!--                            <td>--><?php //echo $encaes->decrypt($obj->LT_TESTNAME)?><!--</td>-->
<!--                            <td>--><?php //echo $obj->LT_DISCPLINENAME?><!--</td>-->
<!--                            <td>--><?php //echo $obj->LT_DATE?><!--</td>-->
<!--                        </tr>-->
<!--                --><?php
//                    }
//                }
                foreach ($result as $obj){?>
                                            <tr>
                                                <td><?php echo $n++?></td>
                                                <td><?php echo $obj['patientname']?></td>
                                                <td><?php echo $obj['patientcode']?></td>
                                                <td><?php echo $obj['testname']?></td>
                                                <td><?php echo $obj['labdiscpline']?></td>
                                                <td><?php echo $obj['labrequestdate']?></td>
                                            </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
        </div>
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