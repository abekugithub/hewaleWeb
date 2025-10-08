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
            <div class="moduletitleupper">Lab Request Details (<?php echo ($homeservicestatus > 0 ? 'Home Service' : 'Walk-in'); ?>) </div>
			
            <button class="btn btn-dark pull-right" onclick="document.getElementById('view').value='';document.myform.submit;" style="font-size:15px; padding-top:-10px; line-height:1.3em;  margin-top:-40px;" title="Back" formnovalidate>Back</button>
            
        </div>
		<?php $engine->msgBox($msg,$status); ?>
        <div class="col-sm-12 salesoptblock">
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
                    <small><b>NB:</b> A service charge of 10% will be added to the total amount entered</small>
                    <div class="col-sm-4 salestotalarea">
                        <div class="col-sm-12" style="/*border: 1px solid red*/height: 130px;">
                            <label style="padding-top: 1px;">Total:</label>
                            <span style="height: 20vh;padding-top: 4vh;"><?php echo $currency;?></span>
                            <input type="text" name="totalamounts" id="totalamounts" value="<?php echo $Total;?>" maxLength="7" autofocus placeholder="15.00" style="height: 20vh;font-size: 10vh;" />
                        </div>
                    </div>


                    <div class="row">
                <div class="col-sm-12" style="line-height: 0">
                    <div class="col-sm-4">
                        <!-- <label class="form-label">&nbsp;&nbsp;</label> -->
                        <button type="button" onClick="window.open('index.php?pg=<?php echo md5('Home Service')?>&option=<?php echo md5('Home Service')?>&uiid=c7e0e599d2520ee7fda7a45375e0e1b5&view=maps&ploc=<?php echo $patientlocation?>','Hewale Patient Location','toolbar=no,scrollbars=yes,resizable=yes,top=90,left=80,channelmode=1,location=0,menubar=0,status=no,titlebar=0,toolbar=0,modal=1,width=1200,height=600');" class="btn btn-default form-control"><i class="fa fa-map-marker"></i> Click here to view patient's location</button>
                    </div>
                    <div class="col-sm-4 pull-right">
                        <!-- <label class="form-label">&nbsp;&nbsp;</label> -->
                        <button type="submit" onClick="document.getElementById('viewpage').value='resultdone';document.myform.submit;" class="btn btn-success form-control"><i class="fa fa-check"></i> Done</button>
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
            </div>
        
				
            <div class="col-sm-10">
                <label class="form-label">&nbsp;&nbsp;</label>
            </div>
            <!-- <div class="col-sm-2">
                <label class="form-label">&nbsp;&nbsp;</label>
                <button type="submit" onClick="document.getElementById('viewpage').value='sampledone';document.myform.submit;" class="btn btn-success form-control"><i class="fa fa-check"></i> Done</button>
            </div> -->

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
						<th>Date</th>
                        <th>Test</th>
                        <th>Discipline</th>
                        <th>Remarks.</th>
                        <th>Sample.</th>
                        <th>Label.</th>
                        <th>Volume.</th>
                        <th>Status.</th>
						<th>Action</th>
                    </tr>
                </thead>


                <tbody>
                    <?php
                    $num = 1;
					$i =  1;
                    if($stmtlisttestsampledetails->Recordcount() > 0 ){
					while ($obj = $stmtlisttestsampledetails->FetchNextObject()){
                    
                   echo '<tr>
						
						    <td>'.$num.'</td>
                            <td>'.$sql->UserDate($obj->LT_DATE,'d/m/Y').'</td>
                           
                            <td>'.$encaes->decrypt($obj->LT_TESTNAME).'</td>
                            <td>'.$obj->LT_DISCPLINENAME.'</td>
                            <td>'.$encaes->decrypt($obj->LT_RMK).'</td>
                            <td>'.$encaes->decrypt($obj->LT_SPECIMEN).'</td>
                            <td>'.$obj->LT_SPECIMENLABEL.'</td>
                            <td>'.$obj->LT_SPECIMENVOLUME.'</td>
                            <td>'.(($obj->LT_STATUS == '3')?'Pending':(($obj->LT_STATUS == '4' )?'Sample Taken':'N/A')).'</td>
												
						<td>
						
                           
                        '.(($obj->LT_STATUS == '3')?'<button type="submit" class="btn btn-info btn-square" onclick="document.getElementById(\'view\').value=\'takesample\';document.getElementById(\'vkey\').value=\''.$obj->LT_CODE.'\';document.getElementById(\'viewpage\').value=\'takesample\';document.myform.submit;">Take Sample</button>':(($obj->LT_STATUS == '4')?'<button type="submit" class="btn btn-warning btn-square" onclick="document.getElementById(\'view\').value=\'takesample\';document.getElementById(\'vkey\').value=\''.$obj->LT_CODE.'\';document.getElementById(\'viewpage\').value=\'takesample\';document.myform.submit;">Edit</button>':'N/A')).'
                        
                        
                        
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


