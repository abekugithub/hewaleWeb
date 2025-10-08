<?php //include ('model/js.php');?>
<div class="main-content">

    <div class="page-wrapper">
        <?php $engine->msgBox($msg,$status); ?>
        <div class="page form">
        <input type="hidden" value="<?php echo $facilitypercent?>" name="facilitypercent" id="facilitypercent">
        <input type="hidden" value="<?php echo $deliverystatus?>" name="deliverystatus" id="deliverystatus">
        <input type="hidden" value="<?php echo $state?>" name="state" id="state">
            <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper">Sales Image Prescription</div>
                <button class="btn btn-dark pull-right" onclick="document.getElementById('view').value='cancelsale';document.myform.submit;" style="font-size:15px; padding-top:-10px; line-height:1.3em;  margin-top:-40px;" title="Back" formnovalidate>Back</button>
            </div>
			<div class="row col-sm-9">
            <!-- Sales Option Section -->
            <div class="col-sm-8 salesoptblock">
                <div class="col-sm-10 salesoptselect">
                    <div class="form row">
                    <div class="col-sm-6 form-group">
                        <label class="form-label required">Prescription Code: <?php echo ($packagecode?$packagecode:'');?></label>
                             <input type="hidden" class="form-control" value="<?php echo $deliverystatus;?>"id="deliverystatus" name="deliverystatus" >
                            <input type="hidden" class="form-control" value="<?php echo $imagename;?>"id="imagename" name="imagename" >
                            <input type="hidden" class="form-control" value="<?php echo $keys;?>"id="visitcode" name="visitcode" >
                          <input type="hidden" class="form-control" value="<?php echo $patientnum;?>"id="hewalenumber" name="hewalenumber" >
                            <input type="hidden" class="form-control" value="<?php echo $packagecode;?>"id="packagecode" name="packagecode" >
                           
                        </div>
                        <div class="col-sm-6 form-group">
                            <label class="form-label required">Gender: <?php echo ($patgender?$patgender:'');?></label>
                           
                        </div>

                        <div class="col-sm-6 form-group">
                        <label class="form-label required">Customer Name:  <?php echo ($patientfullname?$patientfullname:'');?></label>
                           <input type="hidden" name="customername" value="<?php echo $patientfullname;?>">
                        </div>

                        <div class="col-sm-6 form-group">
                            <label class="form-label required">Age: <?php echo ($patage?$patage:'') ; ?></label>
                           
                        </div>

                        <div class="col-sm-6 form-group">
                        <label class="form-label required">Hewale Number:  <?php echo ($patientnum?$patientnum:'') ; ?></label>
                           
                        </div>
                        
                        <div class="col-sm-6 form-group">
                        <label class="form-label required">Prescription Date:  <?php echo date("d/m/Y",strtotime($prescdate))  ;?></label>
                           
                        </div>

                        <div class="col-sm-6 form-group">
                        <label class="form-label required">Customer Contact:  <?php echo ($patphonenumber?$patphonenumber:'');?></label>
                           
                        </div>

                        <div class="col-sm-6 form-group">
                        <label class="form-label required">Allergies:  <?php echo ($patalergies?$patalergies:'N/A') ;?></label>
                        </div>
                        <div class="col-sm-6 form-group">
                        <label class="form-label required">Estimated Amount:  <?php echo ($expectedtotal?$expectedtotal:'N/A') ;?></label>
                           
                        </div>
                        <?php  if ($deliverystatus=='1'){?>
                       
						<div class="col-sm-4 form-group">
						<label>Courier:</label>
                       <select required="required" name="courier" id="courier" class="form-control select2" tabindex="2" ><option value=""> -- Select Courier --</option>
        				<?php while($obj = $stmtcourierlov->FetchNextObject()){  ?>
        				<option value="<?php echo $obj->CS_COURIERCODE.'|'.$obj->CS_COURIERNAME ;?>" <?php echo (($obj->CS_COURIERCODE == $courier)?'selected':'' )?> ><?php echo $obj->CS_COURIERNAME ;?></option>
        				<?php }  ?> 

			           </select>
                        </div>
                        <?php  }?>
                        <div class="col-sm-4 form-group">
                        <label>Instructions:</label>
                        <textarea name="remarks" placeholder="Enter Instructions"></textarea>                          
                        </div> 
                                          
<input type="hidden" class="form-control" id="grandtotal" name="grandtotal" value="" readonly></strong></td>
                       

                    </div>
                    <div class="form row">
                    <div class="col-sm-6 form-group">
                            <label class="form-label required">Medication</label>
                            <select type="text" class="form-control select2" id="drugid" name="drugid" >
                            <option value="">Select Medication</option>
                            <?php foreach ($finaldrugsarray as $key=>$value){
                          
                            ?>
                                <option value="<?php echo $value['ST_CODE'];?>"><?php echo $value['ST_NAME'].' '.$value['ST_DOSAGE']?></option>
                                <?php }?>
                            
                            </select>
                        </div>
                         <div class="col-sm-2">
                            <label class="form-label">&nbsp;&nbsp;</label>
                           
                            <button type="button" id="addDrug" class="btn btn-success form-control"><i class="fa fa-plus"></i> Add</button>
                        </div>
                        
                        
                     <div class="col-sm-4 salespreparearea" >
                        <label>Total:</label>
                        <span><?php echo $currency;?></span>
                        <input type="text" name="totalamount" id="totalamount" maxLength="7" >
                    </div>
                    
                    </div>
                    
                </div>
                 
               <!--  <div class="col-sm-4 salespreparearea">
                    <div class="col-sm-12">
                        <label>Total:</label>
                        <span><?php echo $currency;?></span>
                        <input type="text" name="totalamount" id="totalamount" maxLength="7" >
                    </div>
                </div>-->
            </div>
            <!-- End -->

            <!-- Table Section -->
            <div class="col-sm-12 tableoptblock">
                <div class="row">
                    <div class="panel-body table-responsive">
                        <table class="table table-hover" id="traydev">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Medication</th>
                                    <th>Dosage</th>
                                    <th width="10%">Price</th>
                                    <th width="10%">Quantity</th>
                                    <th width="15%">Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="traydev">
                                <!-- table displays here -->
                                <?php
                                $cartprepare = $session->get('cartprepare'); 
                              
                                $grandtotal=0;
                                if (!empty($cartprepare) && count($cartprepare)>0){
                                	$i=1;
                                	
                                	foreach ($cartprepare as $key){
                                		$grandtotal = $grandtotal + ($key['QUANTITY']* $key['COST']);
                                	?>
                                
                                	<?php }
                                	
                                }?>
                           <tr >
                                      
                             
                             <td colspan="2"></td>
                           </tr>

                            </tbody>
                        </table>
                        <table class="table table-hover">
                        <tbody>
                        <tr>
                        <td style="text-align: right" width="72%">
                        <p style="font-size:10px">Service Charge (<?php echo $facilitypercent*100?>)%:</p>
                        </td>
                        <td width="15%">
                        
                        <input name="commission" class="form-control" readonly id="commission"></input></strong>
                        </td>
                        
                        </tr>
                         <tr>
                        <td style="text-align: right" width="72%">
                        <strong>Total :</strong>
                        </td>
                        <td width="15%">
                        <strong>
                        <input name="finalgrandtotal" class="form-control" readonly id="finalgrandtotal"></input></strong>
                        </td>
                        <td>
                        </td>
                        </tr>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End -->

            <!-- Footer Section -->
            <div class="col-sm-12">
                <div class="col-sm-12 salesfooter">
               
                    <div class="pull-right">
                    
                        <!-- <button type="button" onClick="confirmSubmit('Are you sure you want to  proceed?','Yes',function(){document.getElementById('viewpage').value='saveimagesales';document.myform.submit();});" class="btn btn-success" id="saveform"></i> Sale</button>-->
                        <button disabled type="button" onClick="if(document.getElementById('deliverystatus').value=='1' && document.getElementById('courier').value==''){alert('Please select a courier');}else{confirmSubmit('Are you sure you want to  proceed?','Yes',function(){document.getElementById('viewpage').value='saveimagesales';document.myform.submit();});}" class="btn btn-success" id="saveform"></i> Sale</button>
                    <?php if ($deliverystatus==1){?>
                    <button type="button" class="btn btn-danger" onClick="confirmSubmit('Are you sure you want to  cancel the sale?','Yes',function(){document.getElementById('viewpage').value='cancelsale';document.myform.submit();});" formnovalidate>Cancel</button>
                    <?php }else{?>    
                        <button type="button" class="btn btn-danger" onClick="confirmSubmit('Are you sure you want to  cancel the sale?','Yes',function(){document.getElementById('viewpage').value='cancelsale';document.myform.submit();});">Cancel</button>
                        <?php }?>
                    </div>
                </div>
            </div>
		</div>
		
		
<!-- Begining of image -->
<?php if ($state=='2'){//if its an image prescription?>
		<div class="col-sm-3" style="background: #eee; padding-top: 10px">
		<!-- <label><strong>Purchase for:</strong></label><br>
		<label class="form-label required">Age: </label><?php echo !empty($behalfage)?$behalfage:'N/A';?><br>
		<label class="form-label required">Gender: </label><?php echo !empty($behalfgender)?$behalfgender:'N/A';?><br>
	-->
	<?php if(!empty($behalfage) || !empty($behalfgender)){//if buying for 3rd Party?>
	<div class="" style="margin-top: 10px">
                                <p><b>Please Note:</b> <span>The prescription request below is for the person with the following details:</span></p>
                                <p><label style="width: 9em;font-weight: 400">Patient Age:</label><label><?php echo $behalfage?></label></p>
                                <p><label style="width: 9em;font-weight: 400">Patient Gender:</label><label><?php echo $behalfgender?></label></p>
         </div><?php }?>
		 <table class="table table-hover">
	<!-- 	<img src="<?php echo SHOST_PRESCRIPTION.$imagename;?>" alt="No prescription image" style="width:400px;height:600px;">
		   </table>-->
		   <p>List of Prescritpion: </p>
                        <img src="<?php echo SHOST_PRESCRIPTION.$imagename;?>" alt="Prescription Image" style="width:100%;height:600px;" />
		    </div>
<!--Ending of image  -->
<?php }else {//if text?>
		<div class="col-sm-3" style="background: #eee; padding-top: 10px" >
		<!-- <label><strong>Purchase for:</strong></label><br>
		<label class="form-label required">Age: </label><?php echo !empty($behalfage)?$behalfage:'N/A';?><br>
		<label class="form-label required">Gender: </label><?php echo !empty($behalfgender)?$behalfgender:'N/A';?><br>--><?php if(!empty($behalfage) || !empty($behalfgender)){ //if buying for a 3rd party?>
	<div class="" style="margin-top: 10px">
                                <p><b>Please Note:</b> <span>The prescription request below is for the person with the following details:</span></p>
                                <p><label style="width: 9em;font-weight: 400">Patient Age:</label><label><?php echo $behalfage?></label></p>
                                <p><label style="width: 9em;font-weight: 400">Patient Gender:</label><label><?php echo $behalfgender?></label></p>
         </div><?php }?>
         <p>List of Prescritpion: </p>
          <div style="border: 1px dashed;padding: 0 3px"><?php echo nl2br($behalfimage); ?></div>
		     <!--  <div class=" col-sm-12">
		      <label>Medications:</label>
		      <textarea  class="form-control" rows="12" cols="10" readonly><?php echo !empty($behalfimage)?ltrim($behalfimage):'' ;?></textarea>
			</div>-->	
            </div>
<?php }?>
        </div>
    </div>
</div>
</div>

<script>
    /**$(document).ready(function () {
    	var value = document.getElementById('grandtotal').value;
    	$('#totalamount').val(value);
    });**/
    //var value = document.getElementById('grandtotal').value;
    function doSum(quantity,cost,total)
    {
       // alert('Bingoooo');
        // Capture the entered values of two input boxes
        var percenttotal = <?php echo $facilitypercent;?>;
        var my_quantity = document.getElementById(quantity).value;
        var my_cost = document.getElementById(cost).value;
        var perctotal=my_cost*percenttotal;
      //  percenttotal=parseFloat(my_cost)+parseFloat(perctotal);
         var tot = my_quantity*my_cost ;//*percenttotal;
         //alert(tot);
        document.getElementById(total).value = tot;

         var arr = document.getElementsByName('total');
        var tot=0;
        for(var i=0;i<arr.length;i++){
            if(parseFloat(arr[i].value))
                tot += parseFloat(arr[i].value);
        }
        perctotal=parseFloat(tot)*percenttotal;
        var finalgrandtotal=parseFloat(tot)+parseFloat(perctotal);
       // alert(perctotal)
      //  alert(tot);
        document.getElementById('commission').value = perctotal.toFixed(2);
        document.getElementById('finalgrandtotal').value = finalgrandtotal.toFixed(2);
        document.getElementById('grandtotal').value = tot;
        document.getElementById('totalamount').value = finalgrandtotal.toFixed(2);
        document.getElementById('grtotal').value = tot;
 }
   
</script>