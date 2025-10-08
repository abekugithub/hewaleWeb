<div class="main-content">
    <div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Vitals Form <span class="pull-right">
                   <button type="submit" id="acceptLab" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit;" class="btn btn-dark"><i class="fa fa-arrow-left"></i> Back </button>
                    </span>
                </div>
            </div>
            <p id="msg" class="alert alert-danger" hidden></p>
            <div class="col-sm-2">
                <div class="id-photo">
                    <img src="<?php echo(($photourl))?$photourl:'media/img/avatar.png';?>" alt="" id="prevphoto" style="width:100% !important; margin:0px !important;">
                </div>
            </div>
            <div class="col-sm-10">
                <div class="form-group">
                    <div class="col-sm-12 client-info">
                        
                            <table class="table client-table">
                                <tr>
                                    <td><b>Name:</b> <?php echo $requestdetails->REQU_PATIENT_FULLNAME;?></td>
                                    <td><b>Vital Date:</b> <?php echo $requestdetails->REQU_DATE;?></td>
                                    <td><b>Assigned Doctor:</b> <?php echo $requestdetails->REQU_DOCTORNAME;?></td>
                                </tr>
                                <tr>
                                    <td><b>Request Officer:</b> <?php echo $requestdetails->REQU_ACTOR;?></td>
                                    <td><b>Payment Type:</b> <?php echo $requestdetails->REQU_PAYMETNAME;?></td>
                                    <td><b>Service Name:</b> <?php echo $requestdetails->REQU_SERVICENAME;?></td>
                                </tr>
                            </table>
                        
                    </div>
                </div>
                
				<input id="patientcode" name="patientcode" value="<?php echo $client->REQU_PATIENTCODE;?>" type="hidden" />
                <input id="patient" name="patient" value="<?php echo $client->REQU_PATIENT_FULLNAME;?>" type="hidden" />
                <input id="reqdate" name="reqdate" value="<?php echo $client->REQU_DATE;?>" type="hidden" />
                <input id="doctor" name="doctor" value="<?php echo $client->REQU_DOCTORNAME;?>" type="hidden" />
                <input id="actor" name="actor" value="<?php echo $client->REQU_ACTORNAME;?>" type="hidden" />
                <input id="paymenttype" name="paymenttype" value="<?php echo $client->REQU_PAYMETNAME;?>" type="hidden" />
                <input id="servicename" name="servicename" value="<?php echo $client->REQU_SERVICENAME;?>" type="hidden" />
                <input id="regcode" name="regcode" value="<?php echo $client->REQU_CODE;?>" type="hidden" />
                <input id="visitcode" name="visitcode" value="<?php echo $client->REQU_VISITCODE;?>" type="hidden" />
                <input id="dateadded" name="dateadded" value="<?php echo date("Y-m-d");?>" type="hidden" />

                
                <div class="form-group">
                    <div class="col-sm-12 client-vitals">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Vital Type</th>
                                    <th>Value</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                               
                              <?php
						
                 $num = 1;
                  if($stmt->RecordCount() > 0 ){
                           while($obj = $stmt->FetchNextObject()){
                   echo '<tr>
                        <td>'.$num++.'</td>
						<td>'.$obj->VITDET_VITALSTYPE.'</td>
                        <td>'.$obj->VITDET_VITALSVALUE.'</td>
                    </tr>';
					}}
					?> 
                               
                               
                               
                            </tbody>
                        </table>    
                    </div>
                </div>

            </div>
            
        </div>
    </div>
</div>
