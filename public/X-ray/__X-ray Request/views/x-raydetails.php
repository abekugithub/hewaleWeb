<?php $rs = $paging->paginate();?>
<div class="main-content">
    <div class="page-wrapper">
        <input type="hidden" class="form-control" id="" name="visitcode" value="<?php echo $visitcode; ?>" readonly>
        <input type="hidden" class="form-control" id="" name="patientnum" value="<?php echo $patientnum; ?>" readonly>
        <input type="hidden" class="form-control" id="" name="patient" value="<?php echo $patient; ?>" readonly>
        <input type="hidden" class="form-control" id="" name="keys" value="<?php echo $keys; ?>" readonly>
        <input type="hidden" class="form-control" id="" name="vkeys" value="<?php echo $vkeys; ?>" readonly>
        <input type="hidden" class="form-control" id="" name="specimen" value="<?php echo $specimen; ?>" readonly>
        <input type="hidden" class="form-control" id="" name="slabel" value="<?php echo $slabel; ?>" readonly>
        <input type="hidden" class="form-control" id="" name="vol" value="<?php echo $vol; ?>" readonly>
        <input type="hidden" class="form-control" id="visitcode" name="visitcode" value="<?php echo $visitcode; ?>" readonly>
        <input type="hidden" class="form-control" id="patientnum" name="patientnum" value="<?php echo $patientnum; ?>" readonly>
        <input type="hidden" class="form-control" id="patient" name="patient" value="<?php echo $patient; ?>" readonly>
        <input type="hidden" class="form-control" id="keys" name="keys" value="<?php echo $keys; ?>" readonly>
        <input type="hidden" class="form-control" id="vkey" name="vkey" value="<?php echo $vkey; ?>" readonly>
        <input type="hidden" class="form-control" id="test" name="test" value="<?php echo $test; ?>" readonly>
        <input type="hidden" class="form-control" id="target" name="target" value="<?php echo $test; ?>" readonly>

        <div class="page form">
            <div class="moduletitle" style="padding-bottom: 1px;">
                <div class="moduletitleupper">X-ray Request
                    <button type="submit" id="acceptLab" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit;" class="btn btn-dark pull-right"><i class="fa fa-arrow-left"></i> Back </button>
                </div>
            </div>

            <div class="col-sm-12 paddingclose personalinfo">
                <div class="col-sm-2">
                    <div class="id-photo">
                        <img src="<?php echo((!empty($patientphoto))?$photourl:'media/img/avatar.png');?>" alt="" id="prevphoto" style="width:90% !important; margin:0px !important;">
                    </div>
                </div>
                <div class="col-sm-10 paddingclose">
                    <div class="form-group">
                        <div class="moduletitleupper">Patient Information </div>
                        <div class="col-sm-12 personalinfo-info">

                            <table class="table personalinfo-table">
                                <tr>
                                    <td><b>Patient Number:</b> <?php echo $patientnum;?></td>
                                    <td><b>Name:</b> <?php echo $patient;?></td>
                                    <td><b>Date of Birth:</b> <?php echo $patientdob;?></td>
                                </tr>
                                <tr>
<!--                                    <td><b>X-ray Test:</b> --><?php //echo $testname;?><!--</td>-->
                                    <td><b>Phone Number:</b> <?php echo $phonenum;?></td>
                                    <td><b>Email:</b> <?php echo $email;?></td>
                                </tr>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
            <?php $engine->msgBox($msg,$status); ?>
            <table class="table table-hover" style="margin-top: 21em">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Test Type</th>
                    <th>Remarks.</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $num = 1;
                $i =  1;
                if($stmtlist->Recordcount() > 0 ) {
                    while ($obj = $stmtlist->FetchNextObject()) {
                        echo '<tr>
						<td>' . $num . '</td>
						<td>' . $sql->UserDate($obj->XT_DATE, 'd/m/Y') . '</td>
                        <td>' . $encaes->decrypt($obj->XT_TESTNAME) . '</td>
                        <td>' . $encaes->decrypt($obj->XT_RMK) . '</td>
						<td>					
							<button type="submit" class="btn btn-info btn-square" onclick="document.getElementById(\'view\').value=\'\';document.getElementById(\'target\').value=\'' . $obj->XT_CODE . '\';document.getElementById(\'viewpage\').value=\'processtest\';document.myform.submit();">Process</button>
						</td>					 				
					</tr>';
                        $num++;
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>