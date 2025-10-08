<?php
$rs = $paging->paginate();

$engine = new engineClass();
$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);

?>
<style>
.rowdanger{
	background-color:#97181B4D}
.rowwarning{
	background-color:#EBECB9}
.rowinfo{
	background-color:#FFA500}
</style>
    <div class="main-content">

        <div class="page-wrapper">
          <?php $engine->msgBox($msg,$status); ?>
     
        
        
         <input type="hidden" class="form-control" id="" name="visitcode" value="<?php echo $visitcode; ?>" readonly>
		<input type="hidden" class="form-control" id="" name="patientnum" value="<?php echo $patientnum; ?>" readonly>
		<input type="hidden" class="form-control" id="" name="patient" value="<?php echo $patient; ?>" readonly>
        <input type="hidden" class="form-control" id="" name="faccode" value="<?php echo $faccode; ?>" readonly>
        <input type="hidden" class="form-control" id="" name="keys" value="<?php echo $keys; ?>" readonly>
        <input type="hidden" class="form-control" id="" name="deliverystatus" value="<?php echo $deliverystatus; ?>" readonly>
		
		
           


            <?php //$engine->msgBox($msg,$status); ?>

            <!-- <div class="page-lable lblcolor-page">Table</div>-->
            <div class="page form">
                <div class="moduletitle" style="margin-bottom:0px;">
                    <div class="moduletitleupper">Prescriptions Details
                    <div class="pagination-right" id="hiddenbtn" style="display: ">
					 <?php if($obj->PRESC_DEL_STATUS == 1){ ?>
                       <div class="col-sm-6">
                       
                       <select name="courier" id="courier" class="form-control" tabindex="2"><option value=""> -- Select Courier --</option>
        				<?php while($obj = $stmtcourierlov->FetchNextObject()){  ?>
        				<option value="<?php echo $obj->CS_COURIERCODE.'|'.$obj->CS_COURIERNAME ;?>" <?php echo (($obj->CS_COURIERCODE == $courier)?'selected':'' )?> ><?php echo $obj->CS_COURIERNAME ;?></option>
        				<?php }  ?> 

			           </select>
                        </div>
						<?php } ?>
						<button type="submit" id="acceptLab" onclick="document.getElementById('view').value='sales';document.getElementById('keys').value='<?php echo $visitcode?>';document.getElementById('viewpage').value='prepare';document.myform.submit;" class="btn btn-info"> Prepare </button> 
                        <button type="submit" id="acceptLab" onclick="document.getElementById('view').value='sales';document.getElementById('keys').value='<?php echo $visitcode?>';document.getElementById('viewpage').value='sales';document.myform.submit;" class="btn btn-success"> Sale </button>
					    <button type="submit" id="acceptLab" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit;" class="btn btn-dark"><i class="fa fa-times-circle"></i> Back </button>
                    
                    </div>
                    </div> 
                
                </div>
                
                
			<div class="form-group">
			<div class="col-sm-4 ">
                    <label class="control-label" for="fname">Patient Name :</label><br>
                    <?php  echo $patient; ?>
                </div>
                <div class="col-sm-4 ">
                    <label for="othername">Pickup Number :</label><br>
                    <?php  echo (!empty($pickupcode)?$pickupcode:'N/A'); ?>
                </div>
                 <div class="col-sm-4 ">
                    <label for="othername">Delivery :</label><br>
                    <?php  echo (($pickupdelivery=='1')?'Courier Pick Up':'Self Pick Up'); ?>
                </div>
            </div>
			
          
                <div class="pagination-tab">
                    <div class="table-title">
                      
                        
                     
                    
                    </div>
                </div>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            
							<th>#</th>
							
							<th>Drug</th>
							<th>Form</th>
                            <th>Frequency</th>
                            <th>Days</th>
                            <th>Quantity</th>
                            <th>Unit price</th>
                            <th>Total</th>
                                </tr>
                    </thead>
                    <tbody>
                        <?php
                 $num = 1;
                 if($stmtlist->Recordcount() > 0 ){
					while ($obj = $stmtlist->FetchNextObject()){
					
					$drugs = $encaes->decrypt($obj->PRESC_DRUG);
					$drugid = $encaes->decrypt($obj->PRESC_DRUGID);
                      if($obj->PRESC_STATUS ==5){
					       
					       $st = 'Dispensed';
					       
					   }else if($obj->PRESC_STATUS ==4){
					       
					       $st = 'Ready';
                           
                        }else if($obj->PRESC_STATUS ==2){
					       
					       $st = 'Unpaid';
                           
                           }else if($obj->PRESC_STATUS ==1){
					       
					       $st = 'Paid';
					   }
                   echo '<tr >
				                     <td>'.$num++.'</td>
                      
                     	<td>'.$drugs.'</td>
                        <td>'.$obj->PRESC_DOSAGENAME.'</td>
						<td>'.$obj->PRESC_FREQ.'</td>
                        <td>'.$obj->PRESC_DAYS .'</td>
                        <td>'.$obj->PRESC_QUANTITY.'</td>
						<td>'.number_format($obj->PRESC_UNITPRICE , 2).'</td>
                        <td>'.number_format($obj->PRESC_UNITPRICE*$obj->PRESC_QUANTITY, 2).'</td>
                        
                        
                    </tr>';
					}}
					?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>

