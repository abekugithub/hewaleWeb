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
                                    <td><b>Date of Birth:</b> <?php echo $dob;?></td>
                                    <td><b>Email:</b> <?php echo $email;?></td>
                                </tr>
                                <tr>
                                    <td><b>Phone Number:</b> <?php echo $phonenumber;?></td>
                                    <td><b>Postal Address:</b> <?php echo $postaladdress;?></td>
                                    <td><b>Residential Address:</b> <?php echo $residential;?></td>
                                </tr>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 alegyinfo">
                <div class="col-sm-2"></div>
                <div class="col-sm-10 paddingclose">
                    <div class="form-group">
                        <div class="moduletitleupper">Allergies </div>
                        <div class="col-sm-12 personalinfo-info">

                            <table class="table personalinfo-table">
                                <tr>
                                    <td><b><?php echo $n;?>:</b> <?php echo $allegy;?></td>
                                    <td><b>2:</b> Pollen</td>
                                    <td><b>3:</b> Sulpha Based Drugs</td>
                                </tr>
                            </table>

                        </div>
                    </div>
                </div>

            </div>
            <div class="col-sm-12 chronicinfo">
                <div class="col-sm-2"></div>
                <div class="col-sm-10 paddingclose">
                    <div class="form-group">
                        <div class="moduletitleupper">Chronic Conditions </div>
                        <div class="col-sm-12 personalinfo-info">

                            <table class="table personalinfo-table">
                                <tr>
                                    <td><b><?php echo $n;?>:</b> <?php echo $chronic_condition?></td>
                                    <td><b>2:</b> Diabetes</td>
                                    <td><b>3:</b> Chronic Headaches</td>
                                </tr>
                            </table>

                        </div>
                    </div>
                </div>

            </div>
            
            
            <div class="col-sm-12 conshistoryinfo">
                <div class="col-sm-2"></div>
                <div class="col-sm-10 paddingclose">
                    <div class="form-group">
                        <div class="moduletitleupper">Consultation History </div>
                        <div class="col-sm-12 personalinfo-info">

                             <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
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
                 
				  <td >'.$objsmt->CONS_DOCTORNAME.'</td>
                  <td><button type="button" class="btn btn-primary gyn-lime square" onClick="document.getElementById(s).value=\'viewmedicals\';document.getElementById(\'viewpage\').value=\'viewmedicals\';document.getElementById(\'keys\').value=\''.$objsmt->CONS_VISITCODE.'\';document.myform.submit()"><i class="fa fa-desktop"></i> View History</button> 
                                
                    
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