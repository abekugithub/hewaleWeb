<div class="main-content">
    <div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Excuse Duty
                
             
              <span class="pull-right">
               <button type="button"  class="btn btn-dark" onclick="document.getElementById('viewpage').value='viewpatient';document.getElementById('view').value='excuseduty';document.myform.submit();"><i class="fa fa-arrow-left"></i> Previous </button>
               
          <button type="button" id="save" onclick="document.getElementById('viewpage').value='mailexcuseduty';document.getElementById('view').value='';document.myform.submit();" class="btn btn-info"><i class="fa fa-envelope"></i> Mail</button>
          
                 <button type="button" id="save" onclick="document.getElementById('viewpage').value='printexcuseduty';document.getElementById('view').value='';document.myform.submit();" class="btn btn-warning"><i class="fa fa-print"></i>Print</button>
         
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
                    <div class="col-sm-12 client-vitals">
                        <table class="table table-hover">
                       
                            <tbody>
                              <div class="form-group">
                             <div class="col-sm-12" style="font-size:16px">
                             
                               <?php echo $content; ?>
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
<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode ; ?>">

<input type="hidden" name="patientemail" id="patientemail" value="<?php echo $patientemail ; ?>">
<input type="hidden" name="institutionemail" id="institutionemail" value="<?php echo $institutionemail ; ?>">
<input type="hidden" name="treatment" id="treatment" value="<?php echo $treatment ; ?>">
<input type="hidden" name="sickleave" id="sickleave" value="<?php echo $sickleave ; ?>">
<input type="hidden" name="startdate" id="startdate" value="<?php echo $startdate ; ?>">

