<div class="main-content">
    <div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Conference Participants Details<span class="pull-right">

                <button type="submit" id="acceptLab" onclick="document.getElementById('view').value='setupconference';document.getElementById('viewpage').value='fetchcondeatils';document.myform.submit();" class="btn btn-dark"><i class="fa fa-arrow-left"></i> Back </button>

                <button type="button" class="btn btn-success" onclick="saveVitals();">Save</button>

                   
                    </span>
                </div>
            </div>
            <p id="msg" class="alert alert-danger" hidden></p>
           
            <div class="col-sm-12">

                <input id="confcode" name="confcode" value="<?php echo $confcode ;?>" type="hidden" />

                <div class="form-group">
                    <div class="col-sm-12 client-vitals-opt">
                    <div class="col-sm-4 required">
                        <label class="control-label" for="fname">Participants</label>
                        <select class="form-control select2" name="particpts" id="conf_participant">
                            <option value="" disabled selected hidden>Select participant</option>
                            <?php
			 				    while($obj1 = $stmtoptions->FetchNextObject()){
                                    $objfaci = $engine->getUserFacility($obj1->USR_CODE) ;
							?>
   <option value="<?php echo $obj1->USR_CODE; ?>"  > <?php echo (($obj1->USR_TYPE == 7)?'Dr.': '').' '.$obj1->USR_OTHERNAME.' '.$obj1->USR_SURNAME.' ('.$objfaci->FACI_NAME.')' ; ?></option>
    <?php } ?>
                        </select>
                    </div>
                    
                    <div class="btn-group">
                        <div class="col-sm-4 ">
                            <label for="othername">&nbsp;</label>
                            <button type="button" onclick="addparticipant();" class="btn btn-info "><i class="fa fa-plus-circle"></i> Add</button>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12 client-vitals" id="listparticipant">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Participant Name</th>
                                    <th width="50">Action</th>
                                </tr>
                            </thead>
                            <tbody >
                            
                            
                            </tbody>

                        </table>
                        
                    </div>
                </div>

            </div>
            <div class="btn-group pull-right">
                <div class="col-sm-12">
                <button type="submit" id="acceptLab" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit();" class="btn btn-dark"><i class="fa fa-arrow-left"></i> Back </button>

                    <button type="button" class="btn btn-success" onclick="saveVitals();">Save</button>
                   
                </div>
            </div>
        </div>
    </div>
</div>
