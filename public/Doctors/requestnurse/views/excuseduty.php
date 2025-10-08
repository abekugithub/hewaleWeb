<div class="main-content">
    <div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Excuse Duty
                
                
              <span class="pull-right">
          <button type="button" id="save" onclick="document.getElementById('viewpage').value='saveduty';document.getElementById('view').value='summmaryduty';document.myform.submit();" class="btn btn-info"><i class="fa fa-arrow-right"></i> Review Excuse Note</button>
          <button type="button"  class="btn btn-dark" onclick="document.getElementById('viewpage').value='';document.getElementById('view').value='';document.myform.submit();"><i class="fa fa-arrow-left"></i> Back </button>
          </span>
          
                </div>
            </div>
            <?php $engine->msgBox($msg,$status); ?> 
            <p id="msg" class="alert alert-danger" hidden></p>
            <div class="col-sm-2">
                <div class="id-photo">
                    <img src="<?php echo(($patientphoto))?$patientphoto:'media/img/avatar.png';?>" alt="" id="prevphoto" style="width:100% !important; margin:0px !important;">
                </div>
            </div>
            <div class="col-sm-10">
                <div class="form-group">
                    <div class="col-sm-12 client-info">
                        
                            <table class="table client-table">
                                <tr>
                                    <td><b>Full Name:</b> <?php echo $patientname ;?></td>
                                </tr>
                                <tr>
                                    <td><b>Request Date:</b> <?php echo date("d/m/Y"); ?></td>
                                </tr>
                            </table>
                        
                    </div>
                </div>
                
				
                
                <div class="form-group">
                    <div class="col-sm-12 client-vitals">
                        <table class="table table-hover">
                       
                            <tbody>
                              <div class="form-group">
                             <div class="col-sm-6">
                                <label for="treatmenttype">Patient Email:</label>
                                <input type="text" class="form-control" id="patientemail" name="patientemail" value=" <?php echo (!empty($patientemail)?$patientemail:'') ;?>" autocomplete="off">
                            </div>
                            <div class="col-sm-6">
                                <label for="othername">Patient's Institution Email:</label>
                                 <input type="text" class="form-control" id="institutionemail" name="institutionemail" value="<?php echo $institutionemail ;?>" autocomplete="off">
                            </div>
                            
                            <div class="col-sm-6">
                                <label for="treatmenttype">Treatment Type:</label>
                                <input type="text" class="form-control" id="treatment" name="treatment" value="<?php echo $treatment ;?>" autocomplete="off">
                            </div>
                            <div class="col-sm-6">
                                <label for="othername">Sick Leave Duration:</label>
                                 <input type="text" class="form-control" id="sickleave" name="sickleave" value="<?php echo $sickleave ;?>" autocomplete="off">
                            </div>
                            
                            <div class="col-sm-6">
                                <label for="datereview">Reported Date for Review:</label>
                                 <input type="text" class="form-control" id="startdate" name="startdate" value="<?php echo  (!empty($startdate)?date("d/m/Y", strtotime($startdate)):'')?>" autocomplete="off" placeholder="dd/mm/YYYY">
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
<input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode ;?>">
<input type="hidden" name="patientname" id="patientname" value="<?php echo $patientname ; ?>">
<input type="hidden" name="patientnum" id="patientnum" value="<?php echo $patientnum ; ?>">
<input type="hidden" name="patientemail" id="patientemail" value="<?php echo $patientemail ; ?>">
<input type="hidden" name="patientphoto" id="patientphoto" value="<?php echo $patientphoto ; ?>">