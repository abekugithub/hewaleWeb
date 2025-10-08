<?php $rs = $paging->paginate();?>
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
 

 <div class="main-content">

 <div class="page-wrapper">
      <div class="page form">


	    <input type="hidden" class="form-control" id="" name="packagecode" value="<?php echo $packagecode; ?>" readonly>
        <input type="hidden" class="form-control" id="" name="visitcode" value="<?php echo $visitcode; ?>" readonly>
		<input type="hidden" class="form-control" id="" name="patientnum" value="<?php echo $patientnum; ?>" readonly>
		<input type="hidden" class="form-control" id="" name="patient" value="<?php echo $patient; ?>" readonly>
		<input type="hidden" class="form-control" id="" name="keys" value="<?php echo $keys; ?>" readonly>
		<input type="hidden" class="form-control" id="" name="vkeys" value="<?php echo $vkeys; ?>" readonly>
		
		<input type="hidden" class="form-control" id="" name="patientgender" value="<?php echo $patientgender; ?>" readonly>
		<input type="hidden" class="form-control" id="" name="patientage" value="<?php echo $patientage; ?>" readonly>
		<input type="hidden" class="form-control" id="" name="patientcontact" value="<?php echo $patientcontact; ?>" readonly>


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
            <div class="moduletitleupper">Lab Request Results</div>
			
            <button class="btn btn-dark pull-right" onclick="document.getElementById('view').value='';document.myform.submit;" style="font-size:15px; padding-top:-10px; line-height:1.3em;  margin-top:-40px;" title="Back" formnovalidate>Back</button>
            
        </div>
        <div class="col-sm-12 salesoptblock">
            <?php $engine->msgBox($msg,$status); ?>
                <div class="col-sm-8 salesoptselect">
                    <div class="form row">
                                <div class="col-sm-6 form-group">
                        <label class="form-label required">Batch Code: <?php echo ($packagecode?$packagecode:'');?></label>
                            
                        </div>
                        <div class="col-sm-6 form-group">
                            <label class="form-label required">Gender: <?php echo ($patientgender?$patientgender:'');?></label>
                           
                        </div>

                        <div class="col-sm-6 form-group">
                        <label class="form-label required">Customer Name:  <?php echo ($patient?$patient:'');?></label>
                           <input type="hidden" name="customername" value="<?php echo $patient;?>">
                        </div>

                        <div class="col-sm-6 form-group">
                            <label class="form-label required">Age: <?php echo ($patientage?$patientage:'N/A') ; ?></label>
                           
                        </div>

                        <div class="col-sm-6 form-group">
                        <label class="form-label required">Hewale Number:  <?php echo ($patientnum?$patientnum:'') ; ?></label>
                           
                        </div>
                        
                        <div class="col-sm-6 form-group">
                        <label class="form-label required">Request Date:  <?php echo date("d/m/Y",strtotime($patientdate))  ;?></label>
                           
                        </div>

                        <div class="col-sm-6 form-group">
                        <label class="form-label required">Customer Contact:  <?php echo ($patientcontact?$patientcontact:'');?></label>
                           
                        </div>

                        <div class="col-sm-6 form-group">
                        <label class="form-label required">Doctor:  <?php echo ($medic?$medic:'N/A') ;?> </label>
                           
                        </div>
                        
						
                        

                    </div>
                    </div>
                <!-- <div class="col-sm-4 salestotalarea">
                    <div class="col-sm-12">
                        <label>Total:</label>
                        <span><?php echo $currency;?></span>
                        <input type="text" name="totalamounts" id="totalamounts" value="<?php echo $Total;?>" maxLength="7" >
                    </div>
                </div> -->
                <div class="col-sm-4 salestotalarea">
                        <div class="col-sm-12" style="/*border: 1px solid red*/height: 130px;">
                            <label style="padding-top: 1px;">Total:</label>
                            <span style="height: 20vh;padding-top: 4vh;"><?php echo $currency;?></span>
                            <div style="height: 20vh;font-size: 10vh;margin: 20px 36px;"> <?php echo $Total;?>  </div>
                        </div>
                    </div>
            </div>
        
				
            <div class="col-sm-10">
                            <label class="form-label">&nbsp;&nbsp;</label>
                                     </div>
                        <div class="col-sm-2">
                            <label class="form-label">&nbsp;&nbsp;</label>
                           <button type="submit" onClick="document.getElementById('viewpage').value='resultdone';document.myform.submit;" class="btn btn-success form-control"><i class="fa fa-check"></i> Done</button>
                        </div>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
						<th>Date</th>
                        <th>Test</th>
                        <th>Discipline</th>
                        <th>Remarks.</th>
                        <th>Status.</th>
						<th>Action</th>
                    </tr>
                </thead>


                <tbody>
                    <?php
                    $num = 1;
					$i =  1;
                    if($stmtlisttestdetails->Recordcount() > 0 ){
					while ($obj = $stmtlisttestdetails->FetchNextObject()){
                    
                   echo '<tr>
						
						    <td>'.$num.'</td>
                            <td>'.$sql->UserDate($obj->LT_DATE,'d/m/Y').'</td>
                           
                            <td>'.$encaes->decrypt($obj->LT_TESTNAME).'</td>
                            <td>'.$obj->LT_DISCPLINENAME.'</td>
                            <td>'.$encaes->decrypt($obj->LT_RMK).'</td>
                            <td>'.(($obj->LT_STATUS == '4')?'Awaiting Results':(($obj->LT_STATUS == '6' )?'Results Attached':'N/A')).'</td>
												
						<td>
						
                           
                        '.(($obj->LT_STATUS == '4')?'<button type="submit" class="btn btn-info btn-square" onclick="document.getElementById(\'view\').value=\'results\';document.getElementById(\'vkey\').value=\''.$obj->LT_CODE.'\';document.getElementById(\'viewpage\').value=\'res\';document.myform.submit;">Enter Results</button>':(($obj->LT_STATUS == '8')?'<button type="submit" class="btn btn-warning btn-square" onclick="document.getElementById(\'view\').value=\'results\';document.getElementById(\'vkey\').value=\''.$obj->LT_CODE.'\';document.getElementById(\'viewpage\').value=\'res\';document.myform.submit;">Change Results</button>':'N/A')).'
                        
                        
                        
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


