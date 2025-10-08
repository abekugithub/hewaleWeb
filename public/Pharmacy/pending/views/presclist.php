<?php
$rs = $paging->paginate();
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
                    <div class="moduletitleupper">Pending Prescriptions Details</div> 
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
                        <button type="submit" id="acceptLab" onclick="document.getElementById('view').value='adduser';document.getElementById('viewpage').value='accept';document.myform.submit;" class="btn btn-info"><i class="fa fa-plus-circle"></i> Accept </button>
						<button type="submit" id="acceptLab" onclick="document.getElementById('view').value='adduser';document.getElementById('viewpage').value='decline';document.myform.submit;" class="btn btn-warning"><i class="fa fa-times-circle"></i> Decline </button>
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
                            <th>Unit Price</th>
                            <th>Total</th>
                            <th>Delivery</th>
                            <th>Status</th>
                       </tr>
                    </thead>
                    
                    <tbody>
                        <?php
                 $num = 1;
                 $totalrate = '';
                 if($stmtlist->Recordcount() > 0 ){
					while ($obj = $stmtlist->FetchNextObject()){
					   $dg = $obj->PRESC_DRUGID;
                       $qq = $obj->PRESC_QUANTITY;
					   $state = $engine->getpharmcystocks($faccode,$dg,$qq);
                       $unitprice = $engine->getunitprice($faccode,$dg);
                       $tota = $unitprice * $qq ;
                       $totalrate = $totalrate + $tota;
                      
					   if($state==1){
					       
					       $st = 'IN STOCK';
					       
					   }else{
					       
					       $st = 'NOT IN STOCK';
					   }
						  
                   echo 
                   '<tr >
                        <div align="center">
                   
						<td> 
                        '.(($state == 1)?'<input type="checkbox" value="'.$obj->PRESC_CODE.'@@@'.$unitprice.'@@@'.$tota.'" name="syscheckbox['.$obj->PRESC_CODE.']" id="selcheck" >':'N/A').'
                       
                        </td>
				                           
                        </div>
                            
                        <td>'.$num++.'</td>
                        <td>'.date("d/m/Y",strtotime($obj->PRESC_DATE)).'</td>
                        <td>'.$encaes->decrypt($obj->PRESC_DRUG).'</td>
                        <td>'.$obj->PRESC_DOSAGENAME.'</td>
						<td>'.$obj->PRESC_FREQ.'</td>
                        <td>'.$obj->PRESC_DAYS .'</td>
                        <td>'.$obj->PRESC_QUANTITY.'</td>
                        <td>'.number_format($unitprice , 2).'</td>
                        <td>'.number_format($tota, 2).'</td>
                        <td>'.(($obj->PRESC_DEL_STATUS == 1)?'Courrier Pickup':'Self Pickup').'</td>
						<td>'.$st.'</td>
                        
					
                    </tr>';
					}
                    echo '<tr><td colspan="9"><div align="left"><strong>Total</strong></div></td><td><div align="left"><strong>'.number_format($totalrate,2).'</strong></div></td></tr>';
                    }
					?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>
 