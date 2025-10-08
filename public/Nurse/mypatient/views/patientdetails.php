<?php //$rs = $paging->paginate();?>
<div class="main-content">
    <div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Medical History <span class="pull-right">
                    <button class="btn btn-dark" onclick="document.getElementById('view').value='';document.myform.submit;"><i class="fa fa-arrow-left"></i> Back</button>
                    </span>
                </div>
            </div>
            <?php $n = 1;?>
            <div class="col-sm-12 paddingclose personalinfo">
                <div class="col-sm-2">
                    <div class="id-photo">
                        <img src="<?php echo(($patientphoto))?$patientphoto:'media/img/avatar.png';?>" alt="" id="prevphoto" style="width:100% !important; margin:0px !important;">
                    </div>
                </div>
                <div class="col-sm-10 paddingclose">
                    <div class="form-group">
                        <div class="moduletitleupper">Personal Information </div>
                        <div class="col-sm-12 personalinfo-info">

                            <table class="table personalinfo-table">
                                <tr>
                                    <td><b>Name:</b> <?php echo $patientname;?></td>
                                    <td><b>Patient Number:</b> <?php echo $patientcode;?></td>
                                    <td><b>Blood Group:</b> <?php echo $patientbloodgrp;?></td>
                                </tr>
                                <tr>
                                    <td><b>Email:</b> <?php echo $patienemail;?></td>
                                    <td><b>Phone Number:</b> <?php echo $patientphone;?></td>
                                    <td><b>Height:</b> <?php echo $patientheight;?></td>
                                </tr>
                                <tr>
                                    <td><b>Residential Address:</b> <?php echo $patientaddress;?></td>
                                    <td><b>Marital Status:</b> <?php echo $patientmar_status;?></td>
                                    <td><b>Weight:</b> <?php echo $patientweight;?></td>
                                </tr>
                                <tr>
                                    <td><b>Date Of Birth:</b> <?php echo $dob; //$patientbloodgrp;?></td>
                                    <td><b>Gender:</b> <?php echo $patientgender;?></td>
<!--                                    <td><b>Nationality:</b> --><?php //echo $patientnation;?><!--</td>-->
                                </tr>
                                <tr>
                                    <td><b>Nationality:</b> <?php echo $patientnation;?></td>
<!--                                    <td><b>Nationality:</b> --><?php //echo $patientnation;?><!--</td>-->
                                </tr>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

            <!--<div class="col-sm-12 alegyinfo">
                <div class="col-sm-2"></div>
                <div class="col-sm-10 paddingclose">
                    <div class="form-group">
                        <div class="moduletitleupper">Allergies </div>
                        <div class="col-sm-12 personalinfo-info">

                            <table class="table personalinfo-table">
                                <tr>
                                    <td><b><?php //echo $n;?>:</b> <?php //echo $allegy;?></td>
                                    <td><b>2:</b> Pollen</td>
                                    <td><b>3:</b> Sulpha Based Drugs</td>
                                </tr>
                            </table>

                        </div>
                    </div>
                </div>

            </div>-->
            <!--<div class="col-sm-12 chronicinfo">
                <div class="col-sm-2"></div>
                <div class="col-sm-10 paddingclose">
                    <div class="form-group">
                        <div class="moduletitleupper">Chronic Conditions </div>
                        <div class="col-sm-12 personalinfo-info">

                            <table class="table personalinfo-table">
                                <tr>
                                    <td><b><?php //echo $n;?>:</b> <?php //echo $chronic_condition?></td>
                                    <td><b>2:</b> Diabetes</td>
                                    <td><b>3:</b> Chronic Headaches</td>
                                </tr>
                            </table>

                        </div>
                    </div>
                </div>

            </div>-->
            
            
            
            <div class="col-sm-12 conshistoryinfo">
                <div class="col-sm-2"></div>
                <div class="col-sm-10 paddingclose">
                    <div class="form-group">
                        <div class="moduletitleupper">Consultation History </div>
                        <div class="col-sm-12 personalinfo-info">
                        
                        
                        <div class="pagination-tab">
                <div class="table-title">
                    <div class="col-sm-3">
                    
                    
                        
                    </div>
                    <div class="col-sm-5">
                        <div class="input-group">
                            <input type="text" tabindex="1" value="<?php echo $startdate; ?>" class="form-control square-input" name="startdate" placeholder="Enter Date to Search"/>
                            <span class="input-group-btn">
                                <button type="submit" onclick="document.getElementById('view').value='patientdetails';document.getElementById('viewpage').value='searchpatlist';document.myform.submit;" class="btn btn-default btn-gyn-search"> <i class="fa fa-search"></i> </button>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group">
                            <button type="submit" onclick="document.getElementById('action_search').value='patientdetails';document.getElementById('view').value='';
                        	        document.getElementById('viewpage').value='resets';document.myform.submit;" class="btn btn-success btn-square"> <i class="fa fa-refresh"></i> </button>
                        </div>
                    </div>
                    <div class="pagination-right">
                        <!-- Content goes here -->
                    </div>
                </div>
            </div>
                        
                        

                             <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Diagnosis</th>
                        <th>Prescription</th>
                        <th>Prescriber (Doctor)</th>
						<th>Action</th>
<!--                        <th>Password</th>-->
                    </tr>
                </thead>
                <tbody>
                
                
                 <?php
                    

                    if($stmtpat->RecordCount()>0){  
    $num = 1;
    while($objsmt = $stmtpat->FetchNextObject()){
			$listdate = $objsmt->CONS_INPUTDATE;
            $paymentdate = date("d/m/Y",strtotime($listdate));
			
            
            echo '
                    <td >'.$num++.'</td> 
                     <td >'.$paymentdate.'</td> 
                  <td >'.$objsmt->DIA_DIAGNOSIS.'</td> 
                  <td >'.$objsmt->PRESC_DRUG.'</td>
				  <td >'.$objsmt->CONS_DOCTORNAME.'</td>
                  <td><button type="button" class="btn btn-primary gyn-lime square" onClick="document.getElementById(\'view\').value=\'viewmedicals\';document.getElementById(\'viewpage\').value=\'viewmedicals\';document.getElementById(\'newkeys\').value=\''.$objsmt->CONS_VISITCODE.'\';document.myform.submit()"><i class="fa fa-desktop"></i> View History</button> 
                                
                    
              </tr>';
             }
            }
            
            
                                    
                                    
                                    
                                    
                            ?>
                
                
                
               
                </tbody>
            </table>

                        </div>
                    </div>
                </div>
            </div>
            
            
            
            
            

        </div>
    </div>

</div>