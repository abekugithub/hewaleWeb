<?php
include('../../../../public/Doctors/consultingroom/validate.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
<link href="../../../../media/css/main.css" rel = "stylesheet" type = "text/css"/>

<script type="text/javascript" src="../../../../media/js/jquery.min.js"></script>
<script type="text/javascript" src="../../../../media/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../../../../media/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../../../../media/js/bootstrap-toggle.min.js"></script>

</head>

<body>
    <style>
        .rowdanger {
            background-color: #97181B4D
        }

        .rowwarning {
            background-color: #EBECB9
        }
    </style>
    <div class="main-content notepaper">

        <div class="page-wrapper">
        <input type="hidden" class="form-control" id="test" name="test" value="<?php echo $test; ?>" >
            <input id="patientnum" name="patientnum" value="<?php echo $patientnum; ?>" type="hidden" />
            <?php //$engine->msgBox($msg,$status); ?>

            <!-- <div class="page-lable lblcolor-page">Table</div>-->
            <div class="page form">
                <div class="moduletitle" style="margin-bottom:0px;">
                    <div class="moduletitleupper">Lab History</div>
                </div>
             
				<div class="col-sm-12 conshistoryinfo">
                <table class="table table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Patient No.</th>
                    <th>Patient Name</th>
                    <th>Date</th>
                    <th>Lab Name</th>
                    <th>Lab Contact</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $num = 1;
                if($stmthl->RecordCount() > 0){
                   
                    while($obj  = $stmthl->FetchNextObject()){
                 
             
				$stmt1 = $sql->Execute($sql->Prepare("SELECT * FROM hms_consultation  WHERE CONS_VISITCODE = " . $sql->Param('a') . " ORDER BY CONS_CODE DESC LIMIT 1 "), array($obj->LTM_VISITCODE));
				$obj1=$stmt1->FetchNextObject();
				
                  $linkview = 'index.php?pg='.md5('Doctors').'&amp;option='.md5('Consultation').'&uiid='.md5('1_pop').'&view=consulting&viewpage=consult&keys='.$obj1->CONS_CODE.'&visitcode='.$obj->LTM_VISITCODE.'&labid='.$obj->LTM_ID;
        

                  $linkview2 = "public/Doctors/consultingroom/views/consultingdetails.php?keys=".$obj1->CONS_CODE."&patientcode=".md5($obj1->CONS_PATIENTNUM)."&new_visitcode=".$obj->LTM_VISITCODE."&viewpage=consult";
                		
                        echo '<tr>
                        <td>'.$num.'</td>
                        <td>'.$obj->LTM_PATIENTNUM.'</td>
                        <td>'.$obj->LTM_PATIENTNAME.'</td>
                        <td>'.$obj->LTM_DATE.'</td>
                        <td>'.$obj->LTM_LABNAME.'</td>
                        <td>'.$engine->faciPhoneNum($obj->LTM_LABCODE).'</td>
                        <td>'.(($obj->LTM_STATUS !="7")?'Pending':
                                            
                        '<a href="labdetails.php?viewpage=labdetails&keys='.$obj->LTM_VISITCODE.'&newkeys='.$obj->LTM_PATIENTNUM.'&test='.$obj->LTM_PACKAGECODE.'"><button type="button" class="btn btn-info btn-square" onclick= "document.getElementById(\'viewpage\').value=\'labdetails\';document.getElementById(\'view\').value=\'labdetails\';document.getElementById(\'keys\').value=\''.$obj->LTM_VISITCODE.'\';document.getElementById(\'test\').value=\''.$obj->LTM_PACKAGECODE.'\';document.myform.submit()"> Details</button></a>').'
                        </td> 
                        </tr>';
                        $num ++; }}
					 
                ?>
                </tbody>
            </table>
                </div>
            </div>

        </div>

    </div>


    <!-- Modal -->
    <div id="addDesp" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Despensary</h4>
                </div>
                <div class="modal-body">
                    <p>Some text in the modal.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-square" data-dismiss="modal">Save</button>
                    <button type="button" class="btn btn-info btn-square" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    </body>

    </html>