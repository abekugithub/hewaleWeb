<div class="main-content">
    <div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Confrence Participants
                
                
              <span class="pull-right">
          <button type="button"  class="btn btn-dark" onclick="document.getElementById('viewpage').value='';document.getElementById('view').value='';document.myform.submit();"><i class="fa fa-arrow-left"></i> Back </button>
          </span>
          
                </div>
            </div>

            <table class="table table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Facility</th>
                    <th>Phone No.</th>                                       
                                                       
                </tr>
                </thead>
                <tbody>
                <?php
                 $num = 1;
               
                while (!$stmtpartlist->EOF) {
                    # code...
                    $objz= $stmtpartlist->FetchNextObject();


                    $stmtoptions1 = $sql->Execute($sql->Prepare("SELECT * FROM hms_users JOIN hmsb_vhealthunit ON VHSUBDET_FACICODE = USR_FACICODE WHERE  VHSUBDET_MENUGPCODE = ".$sql->Param('a')." AND USR_CODE != ".$sql->Param('b')." AND USR_CODE = ".$sql->Param('b')." "),array($directoratecode,$actor_id, $objz->CONFER_INVITED_USERID));

                    $obj1= $stmtoptions1->FetchNextObject();
                    $objfaci = $engine->getUserFacility($obj1->USR_CODE) ;
                    
                    echo '<tr>
                    <td>'.$num.'</td>
                    <td>'.(($obj1->USR_TYPE == 7)?'Dr.': '').' '.$obj1->USR_OTHERNAME.' '.$obj1->USR_SURNAME.'</td>
                    <td>'.$objfaci->FACI_NAME.'</td>
                    <td>'.$obj1->USR_PHONENO.'</td>
                    <td> 
                    
                  
                        
                    </td>
                  </tr>';
                    $num ++;

                }
                
                
                ?>
                
                </tbody>

</table>
        </div>
    </div>
</div>
<input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode ;?>">
<input type="hidden" name="patientname" id="patientname" value="<?php echo $patientname ; ?>">
<input type="hidden" name="patientnum" id="patientnum" value="<?php echo $patientnum ; ?>">
<input type="hidden" name="patientemail" id="patientemail" value="<?php echo $patientemail ; ?>">
<input type="hidden" name="patientphoto" id="patientphoto" value="<?php echo $patientphoto ; ?>">