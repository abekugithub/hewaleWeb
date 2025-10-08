<div class="main-content">
    <div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Conference Details<span class="pull-right">
                <button type="submit" id="acceptLab" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit();" class="btn btn-dark"><i class="fa fa-arrow-left"></i> Back </button>
                
                <button type="button" class="btn btn-success" onclick="document.getElementById('view').value='savenext';document.getElementById('viewpage').value='savefirst';document.myform.submit();">Next</button>

                  
                    </span>
                </div>

                <?php $engine->msgBox($msg,$status);?>
            </div>
            <p id="msg" class="alert alert-danger" hidden></p>
            <input id="confcode" name="confcode" value="<?php echo $confcode ;?>" type="hidden" />
            <div class="col-sm-12">
            <div class="form-group">
                    <div class="col-sm-12 client-vitals">
                        <table class="table table-hover">
                       
                            <tbody>
                              <div class="form-group">
                             <div class="col-sm-4">
                                <label for="treatmenttype">Conference Name:</label>
                                <input type="text" class="form-control" id="confname" name="confname" value=" <?php echo $confname ;?>" autocomplete="off">
                            </div>
                            <div class="col-sm-4">
                                <label for="datereview">Start Date:</label> 
                                 <input type="text" class="form-control" id="startdate" name="startdate" value=" <?php echo $startdate ;?>" autocomplete="off" placeholder="dd/mm/YYYY">
                            </div>
                            
                            <div class="col-sm-4">
                                <label for="treatmenttype">Start Time:</label>
                                <input type="text" class="form-control" id="starttime" name="starttime" value="<?php echo $starttime ;?>" autocomplete="off">
                            </div>
                           
                           
                        </div> 
                             
                            </tbody>
                        </table>    
                    </div>
                </div>
                
				

            </div>
            
        </div>
    </div>
</div>
