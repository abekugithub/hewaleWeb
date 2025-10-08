<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 12/5/2017
 * Time: 1:01 PM
 */
//include '../../../../config.php';
include '../model/reportquery.php';
//include '../../../layout/header.php';
$report_comp_logo = "../../../../media/img/report-logo.png";
?>
<!--<div id="main"></div>-->
<form name="myform" id="myform" method="post" action="<?php echo $export_url; ?>" >
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
<!--        --><?php
//        if ($stmt->RecordCount()>0){
//            $num = 0;
//            while ($obj = $stmt->FetchNextObject()){?>
<!--                <tr>-->
<!--                    <td>--><?php //echo $n++?><!--</td>-->
<!--                    <td>--><?php //echo $obj->LT_PATIENTNAME?><!--</td>-->
<!--                    <td>--><?php //echo $obj->LT_PATIENTCODE?><!--</td>-->
<!--                    <td>--><?php //echo $encaes->decrypt($obj->LT_TESTNAME)?><!--</td>-->
<!--                    <td>--><?php //echo $obj->LT_DISCPLINENAME?><!--</td>-->
<!--                    <td>--><?php //echo $obj->LT_DATE?><!--</td>-->
<!--                </tr>-->
<!--                --><?php
//            }
//        }
        if (!empty($result)&&is_array($result)){
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
        }
        ?>
        </tbody>
    </table>
</div>
