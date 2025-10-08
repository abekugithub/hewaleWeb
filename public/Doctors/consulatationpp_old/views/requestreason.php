    <style>
        .rowdanger {
            background-color: #97181B4D
        }

        .rowwarning {
            background-color: #EBECB9
        }
    </style>
    <div class="main-content notepaper">

       <?php
       $obj  = $stmthl->FetchNextObject();
       ?>
        <div class="page-wrapper">

            <input id="patientnum" name="patientnum" value="<?php echo $patientnum; ?>" type="hidden" />

            <div class="page form">
                <div class="moduletitle" style="margin-bottom:0px;">
                    <div class="moduletitleupper">Request Reason for <?php echo $obj->REQU_PATIENT_FULLNAME ;?> </div>
                </div>
            
				<div class="col-sm-12 conshistoryinfo" style="padding-top:20px">
                
                <?php
				   if($stmthl->RecordCount() > 0){						  
                   echo $obj->REQU_REASONS;
					}
				?>
                   
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