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

<script type="text/javascript" src="../../../../media/js/select2.full.js"></script>
<script type="text/javascript" src="../../../../media/js/custom.js"></script>
<script type="text/javascript" src="../../../../media/js/moment.min.js"></script>
<script type="text/javascript" src="../../../../media/js/ez.countimer.js"></script>

<style type="text/css">
    .demo {
        position: relative;
    }

    .demo i {
        position: absolute;
        bottom: 10px;
        right: 24px;
        top: auto;
        cursor: pointer;
    }
</style>
<style>
.rowdanger{
	background-color:#97181B4D}
.rowwarning{
	background-color:#EBECB9}
.rowinfo{
	background-color:#C0C0C0}
</style>
 

</head>

<body>

 <div class="main-content">

 <div class="page-wrapper">
     <?php $engine->msgBox($msg,$status); ?>
     <div class="page form">


	    
	    <input type="hidden" class="form-control" id="visitcode" name="visitcode" value="<?php echo $visitcode; ?>" readonly>
		<input type="hidden" class="form-control" id="patientnum" name="patientnum" value="<?php echo $patientnum; ?>" readonly>
		<input type="hidden" class="form-control" id="patient" name="patient" value="<?php echo $patient; ?>" readonly>
        <input type="hidden" class="form-control" id="patient" name="patientdate" value="<?php echo $patientdate; ?>" readonly>
        <input type="hidden" class="form-control" id="patient" name="Total" value="<?php echo $Total; ?>" readonly>
        <input type="hidden" class="form-control" id="patient" name="medic" value="<?php echo $medic; ?>" readonly>
		<input type="hidden" class="form-control" id="keys" name="keys" value="<?php echo $keys; ?>" readonly>
	    <input type="hidden" class="form-control" id="vkey" name="vkey" value="<?php echo $vkey; ?>" readonly>
    	<input type="hidden" class="form-control" id="test" name="test" value="<?php echo $test; ?>" readonly>
         
   
     <div class="moduletitle" style="margin-bottom:0px;">
            <div class="moduletitleupper">Lab Request Details</div>
            <button class="btn btn-dark pull-right" onclick="document.getElementById('view').value='';document.myform.submit;" style="font-size:15px; padding-top:-10px; line-height:1.3em;  margin-top:-40px;" title="Back" formnovalidate>Back</button>
            
        </div>
        <div class="col-sm-12 salesoptblock">
                <div class="col-sm-12 salesoptselect">
                    <div class="form row">
                                <div class="col-sm-4 form-group">
                        <label class="form-label required">Batch Code: <?php echo ($packagecode?$packagecode:'');?></label>
                            
                        </div>
                        <div class="col-sm-4 form-group">
                            <label class="form-label required">Gender: <?php echo ($patientgender?$patientgender:'');?></label>
                           
                        </div>

                        <div class="col-sm-4 form-group">
                        <label class="form-label required">Customer Name:  <?php echo ($patient?$patient:'');?></label>
                           <input type="hidden" name="customername" value="<?php echo $patient;?>">
                        </div>

                        <div class="col-sm-4 form-group">
                            <label class="form-label required">Age: <?php echo ($patientage?$patientage:'N/A') ; ?></label>
                           
                        </div>

                        <div class="col-sm-4 form-group">
                        <label class="form-label required">Hewale Number:  <?php echo ($patientnum?$patientnum:'') ; ?></label>
                           
                        </div>
                        
                        <div class="col-sm-4 form-group">
                        <label class="form-label required">Request Date:  <?php echo date("d/m/Y",strtotime($patientdate))  ;?></label>
                           
                        </div>

                        <div class="col-sm-4 form-group">
                        <label class="form-label required">Customer Contact:  <?php echo ($patientcontact?$patientcontact:'');?></label>
                           
                        </div>

                        <div class="col-sm-4 form-group">
                        <label class="form-label required">Lab:  <?php echo ($labname?$labname:'N/A') ;?> </label>
                           
                        </div>
                        
						
                        

                    </div>
                    </div>
                <!-- <div class="col-sm-4 salestotalarea">
                    <div class="col-sm-12">
                        <label>Total:</label>
                        <span><?php echo $currency;?></span>
                        <input type="text" name="totalamounts" id="totalamounts" value="<?php echo $Total;?>" maxLength="7" >
                    </div>
                </div>-->
            </div>
        
				
            <div class="col-sm-10">
                            <label class="form-label">&nbsp;&nbsp;</label>
                                     </div>
                        <div class="col-sm-2">
                            <label class="form-label">&nbsp;&nbsp;</label>
                          
                        </div>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
						<th>Date</th>
                        <th>Test</th>
                        <th>Discipline</th>
                        <th>Remarks.</th>
                        <th>Action</th>
                    </tr>
                </thead>


                <tbody>
                    <?php
                   
                    $num = 1;
					          $i =  1;
                    if($stmtlisttestdetails->Recordcount() > 0 ){
					while ($obj = $stmtlisttestdetails->FetchNextObject()){
            $linkview = 'pdf.php?viewpage=newpdf&test='.$obj->LT_PACKAGECODE.'&keys='.$obj->LT_VISITCODE.'&vkey='.$obj->LT_CODE; 
                   echo '<tr>
						
						    <td>'.$num.'</td>
                            <td>'.$sql->UserDate($obj->LT_DATE,'d/m/Y').'</td>
                           
                            <td>'.$encaes->decrypt($obj->LT_TESTNAME).'</td>
                            <td>'.$obj->LT_DISCPLINENAME.'</td>
                            <td>'.$encaes->decrypt($obj->LT_RMK).'</td>
                            <td>
						'.(($obj->LT_STATUS !='7')?'Pending':'<a href="'.$linkview.'"><button id="view" name="view" class="btn btn-info" type="button" onclick="/*window.open(\'localhost/socialhealth/media/uploaded/\');*/document.getElementById(\'vkey\').value=\''.$obj->LT_CODE.'\';document.getElementById(\'keys\').value=\''.$obj->LT_VISITCODE.'\';document.getElementById(\'view\').value=\'newpdf\';document.getElementById(\'viewpage\').value=\'newpdf\';document.getElementById(\'test\').value=\''.$obj->LT_PACKAGECODE.'\';document.myform.submit();"> View</button></a>').'
						</td>					 

						
					</tr>';
					$num ++; 
										
					?>			
							
				<?php $i++;	}}
					?>
                </tbody>
            </table>
        </div>	
						
    </div>

</div>

</body>

</html>