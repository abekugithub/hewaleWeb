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
        
        
         <input type="hidden" class="form-control" id="" name="visitcode" value="<?php echo $visitcode; ?>" readonly>
		<input type="hidden" class="form-control" id="" name="patientnum" value="<?php echo $patientnum; ?>" readonly>
		<input type="hidden" class="form-control" id="" name="patient" value="<?php echo $patient; ?>" readonly>
        <input type="hidden" class="form-control" id="" name="faccode" value="<?php echo $faccode; ?>" readonly>
		
		
           


            <?php //$engine->msgBox($msg,$status); ?>

            <!-- <div class="page-lable lblcolor-page">Table</div>-->
            <div class="page form">
                <div class="moduletitle" style="margin-bottom:0px;">
                    <div class="moduletitleupper">Prescriptions Details</div> 
                </div>
                
			<div class="form-group">
                <div class="col-sm-4 required">
                    <label class="control-label" for="fname">Patient Name</label>
                    <?php  echo $patient; ?>
                </div>
                <div class="col-sm-4 required">
                    <label for="othername">Patient Number</label>
                    <?php  echo $patientnum; ?>
                </div>
                <div class="col-sm-4">
                    <label for="email">Visit Code</label>
                    <?php  echo $visitcode; ?>
                </div>
            </div>
			
            <?php $engine->msgBox($msg,$status); ?>
                <div class="pagination-tab">
                    <div class="table-title">
                      
                        
                     <div class="pagination-right" id="hiddenbtn" style="display: ">
					 <?php if($obj->PRESC_DEL_STATUS == 1){ ?>
                       <div class="col-sm-6">
                       
                       <select name="courier" id="courier" class="form-control" tabindex="2"><option value="<?php echo $courier; ?>"> -- Select Courier --</option>
        				<?php while($obj = $stmtcourierlov->FetchNextObject()){  ?>
        				<option value="<?php echo $obj->PCO_COURIERCODE.'@@@'.$obj->PCO_COURIER ;?>" <?php echo (($obj->PCO_COURIERCODE == $courier)?'selected':'' )?> ><?php echo $obj->PCO_COURIER ;?></option>
        				<?php }  ?> 

			           </select>
                        </div>
						<?php } ?> 
                        <button type="submit" id="acceptLab" onclick="document.getElementById('view').value='adduser';document.getElementById('viewpage').value='accept';document.myform.submit;" class="btn btn-info"><i class="fa fa-plus-circle"></i> Ready </button>
					    <button type="submit" id="acceptLab" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit;" class="btn btn-Danger"><i class="fa fa-times-circle"></i> Back </button>
                    
                    </div>
                    
                    </div>
                </div>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th></th>
							<th>#</th>
							<th>Prescription Date</th>
							<th>Drug</th>
							<th>Form</th>
                            <th>Frequency</th>
                            <th>Days</th>
                            <th>Quantity</th>
                            <th>Unit price</th>
                            <th>Total</th>
                            <th>Delivery</th>
                            <th>Status</th>
                            
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                 $num = 1;
                 if($stmtlist->Recordcount() > 0 ){
					while ($obj = $stmtlist->FetchNextObject()){
					
					$drugs = $encaes->decrypt($obj->PRESC_DRUG);
					$drugid = $encaes->decrypt($obj->PRESC_DRUGID);
                      if($obj->PRESC_STATUS ==3){
					       
					       $st = 'Not Ready';
					       
					   }else if($obj->PRESC_STATUS ==4){
					       
					       $st = 'Ready';
                           
                        }else if($obj->PRESC_STATUS ==2){
					       
					       $st = 'Unpaid';
                           
                           }else if($obj->PRESC_STATUS ==1){
					       
					       $st = 'Paid';
					   }
                   echo '<tr >
				   <div align="center">
                   <td>
					
                
                '.(($obj->PRESC_STATUS == '3'  )?'
                <input type="checkbox" value="'.$obj->PRESC_CODE.'@@@'.$drugid.'@@@'.$obj->PRESC_QUANTITY.'" name="syscheckbox['.$obj->PRESC_CODE.']" id="selcheck" >
                ':(($obj->PRESC_STATUS == '4' )?
                'NA':'NA')).'
				
				
            
							</div>
                        <td>'.$num++.'</td>
                        <td>'.date("d/m/Y",strtotime($obj->PRESC_DATE)).'</td>
                     	<td>'.$drugs.'</td>
                        <td>'.$obj->PRESC_DOSAGENAME.'</td>
						<td>'.$obj->PRESC_FREQ.'</td>
                        <td>'.$obj->PRESC_DAYS .'</td>
                        <td>'.$obj->PRESC_QUANTITY.'</td>
						<td>'.number_format($obj->PRESC_UNITPRICE , 2).'</td>
                        <td>'.number_format($obj->PRESC_TOTAL, 2).'</td>
                        <td>'.(($obj->PRESC_DEL_STATUS == 1)?'Courrier Pickup':'Self Pickup').'</td>
                        <td>'.$st.'</td>
					
                    </tr>';
					}}
					?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>

