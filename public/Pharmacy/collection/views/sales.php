<div class="main-content">

    <div class="page-wrapper">
        <?php $engine->msgBox($msg,$status); ?>
        <div class="page form">
        
            <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper">Point of Collection</div>
            </div>
<input type="hidden" class="form-control" id="hewalenumber" name="hewalenumber" value="<?php echo $hewalenumber;?>">
<input type="hidden" class="form-control" id="phone" name="phone" value="<?php echo $phone;?>">
<input type="hidden" class="form-control" id="prescripcode" name="prescripcode" value="<?php echo $prescripcode;?>">
<input type="hidden" class="form-control" id="deliverycode" name="deliverycode" value="<?php echo $deliverycode;?>">
 <input type="hidden" class="form-control" id="visitcode" name="visitcode" value="<?php echo $visitcode;?>"> 
<input type="hidden" class="form-control" id="deliverystatus" name="deliverystatus" value="<?php echo $deliverystatus; ?>" >
            <!-- Sales Option Section -->
            <div class="col-sm-12 salesoptblock">
                <div class="col-sm-8 salesoptselect">
                    <div class="form row">
                        <div class="col-sm-6 form-group">
                        <label class="form-label required">Prescription Code: <?php echo $prescripcode;?></label>
                           
                           
                        </div>
                        <div class="col-sm-6 form-group">
                            <label class="form-label required">Gender: <?php echo $gender;?></label>
                           
                        </div>

                        <div class="col-sm-6 form-group">
                        <label class="form-label required">Customer Name:  <?php echo $customername;?></label>
                           
                        </div>

                        <div class="col-sm-6 form-group">
                            <label class="form-label required">Age: <?php echo $age ; ?></label>
                           
                        </div>

                        <div class="col-sm-6 form-group">
                        <label class="form-label required">Hewale Number:  <?php echo $hewalenumber ; ?></label>
                           
                        </div>
                        
                        <div class="col-sm-6 form-group">
                        <label class="form-label required">Prescription Date:  <?php echo date("d/m/Y",strtotime($presdate))  ;?></label>
                           
                        </div>

                        <div class="col-sm-6 form-group">
                        <label class="form-label required">Customer Contact:  <?php echo $phone;?></label>
                           
                        </div>

                        <div class="col-sm-6 form-group">
                        <label class="form-label required">Allergies:  <?php echo $allergies ;?></label>
                           
                        </div>

                        <?php if ($deliverystatus=='1'){?>
                       
						<div class="col-sm-6">
                        <label class="form-label required">Courier: <?php echo $couriername ;?> </label>
                      
                        </div>
                        <?php }?>

                        <div class="col-sm-6 form-group">
                        <label class="form-label required">Pickup Code:  <?php echo $pickupcode ;?> </label>
                           
                        </div>

                     

                        <div class="col-sm-2">
                            <label class="form-label">&nbsp;&nbsp;</label>
                        
                        </div>

                    </div>
                </div>
                
                <?php if($prescrsource != 1){?>
                <div class="col-sm-4 salestotalarea">
                    <div class="col-sm-12">
                    <?php
                     if(!empty($imagename) && $prescrsource == 2){ ?>
                    <img src="<?php echo SHOST_PRESCRIPTION.$imagename;?>" alt="Prescription Image" style="width:100%;height:600px;" />
                    <?php }elseif($prescrsource == 3){
                         echo $imagename;
                    } ?>
                 
                    </div>
                </div>
                <?php } ?>
            </div>
            <!-- End -->

            <!-- Table Section -->
            
            <div class="col-sm-12 tableoptblock">
                <div class="row">
                    <div class="panel-body table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Medication</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                                <?php
                               
                              
                                    $i=1;
                                    //$servicechargeval = 0;
                                	while($obj = $stmtr->FetchNextObject()){
                                       	$servicecharge = $obj->PEND_PERCENTAGE;
	                                    $grandtotal = $obj->PEND_GRAND_TOTAL; 
	                                    $servicechargeval = $obj->PEND_TOTALCOMMISSION;
                                      $drugrowtotal =  $obj->PEND_QUANTITY * $obj->PEND_UNITPRICE;
                               
                                	?>
                                	
                                <tr>
                                <td><?php echo $i++;?></td>
                                <td><label class="form-label required"><?php echo $encaes->decrypt($obj->PEND_DRUG) ;?></label>
                               </td>
                                <td><label class="form-label required"><?php echo number_format($obj->PEND_UNITPRICE,2);?></label>
                         		</td>
                                <td> <?php echo $obj->PEND_QUANTITY;?> </td>
                                <td>
                                <label class="form-label required"><?php echo number_format($drugrowtotal,2);?></label>
                               </td>
                                
                               <!-- <input type="hidden" class="form-control" id="drugcode" name="drugcode" value="<?php  //echo $encaes->decrypt($obj->PEND_DRUGID) ;?>" -->
                               
                                </tr>	
                            	
                                	<?php }
                                	
                                ?>
                         
                            <tr >
                            <td colspan="3">&nbsp; </td>
                            <td style="text-align: right" >
                             Service Charge (<?php echo $servicecharge.'%' ; ?>) 
                             </td>         
                             <td><strong></strong>
                             <label class="form-label required"><?php  echo $servicechargeval ;?></label>
                             <input type="hidden" class="form-control" id="grandtotal" name="grandtotal" value="<?php  echo $servicechargeval ;?>" readonly></strong></td>
                             
                           </tr>

                           <tr >
                           <td colspan="3">&nbsp; </td>
                           <td style="text-align: right">
                             <label class="form-label">Total</label>
                             </td>          
                             <td><strong></strong>
                             <label class="form-label required"><?php  echo (!empty($grandtotal)?number_format($grandtotal,2):'0');?></label>
                             <input type="hidden" class="form-control" id="grandtotal" name="grandtotal" value="<?php  echo (!empty($grandtotal)?number_format($grandtotal,2):'0');?>" readonly></strong></td>
                             
                           </tr>
                          

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="col-sm-12">
                    <div class="col-sm-12">
                        <label>Instructions</label>
                        
                    </div>
            </div>

            <div class="col-sm-12">
                <div class="col-sm-12 phinstructionfooter">
               
                 <?php echo $instructions ;?>

                </div>
            </div>

            <!-- End -->

            <!-- Footer Section -->
            <div class="col-sm-12">
                <div class="col-sm-12 salesfooter">
               
                    <div class="pull-right">
                        <button type="button" 
                        onClick="confirmSubmit('Are you sure you want to  proceed?','Yes',function(){document.getElementById('prescripcode').value='<?php echo $prescripcode ;?>';document.getElementById('viewpage').value='savedispatch';document.myform.submit();});"
                          class="btn btn-success"></i>Dispatch</button> 

                        <button type="submit" class="btn btn-danger"  onClick="document.getElementById('viewpage').value='';document.myform.submit();";>Cancel</button>
                    </div>
                </div>
            </div>

            
        </div>

    </div>
</div>
</div>