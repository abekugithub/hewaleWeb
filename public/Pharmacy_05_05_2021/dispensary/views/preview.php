<?php
	$company =$engine->getFacilityDetails();
  //  $report_comp_logo = $company->FACI_LOGO_ONAME;
  	$report_comp_logo = "media/img/report-logo.png";
    $report_comp_name = $company->FACI_NAME;
    $report_title = "Receipt";
    $report_comp_location =$company->FACI_LOCATION;
    $report_phone_number =  $company->FACI_PHONENUM;
    $report_content = '';
    $salcode =$session->get('salecode');
    $pickupcode=$session->get('pickupcode');
    $stmt=$sql->Execute($sql->Prepare("SELECT SAL_CODE,SAL_DRUG,SAL_DOSAGE,SAL_QUANTITY,SAL_COST,SAL_NHIS,SAL_CUSTOMER,SAL_USERNAME,SAL_METHOD,SAL_CRDATE,SAL_TOTALCOMMISSION,SAL_GRANDTOTAL from hms_pharmacysales WHERE SAL_CODE=".$sql->Param('a')." AND SAL_FACICODE=".$sql->Param('b')." AND SAL_COST > ".$sql->Param('c').""),array($salcode,$faccode,'0'));
    print $sql->ErrorMsg();
      if ($stmt->RecordCount()>0){
      	while ($obj=$stmt->FetchNextObject()){
      	$drugs = $encaes->decrypt($obj->SAL_DRUG);
      	$salsmethod=$obj->SAL_METHOD;
      	$customer=$obj->SAL_CUSTOMER;
      	$code=$obj->SAL_CODE;
		//$drugid = $encaes->decrypt($obj->PRESC_DRUGID);	
      	$date_rec=$obj->SAL_CRDATE;
      	$cart_rec[]=array('DRUG'=>$drugs,'DOSAGE'=>$obj->SAL_DOSAGE,'QUANTITY'=>$obj->SAL_QUANTITY,'NHIS'=>$obj->SAL_NHIS,'COST'=>$obj->SAL_COST,'CUSTOMER'=>$obj->SAL_CUSTOMER,'USERNAME'=>$obj->SAL_USERNAME,'METHOD'=>$obj->SAL_METHOD,'DATE'=>$obj->SAL_CRDATE,'TOTALCOMMISSION'=>$obj->SAL_TOTALCOMMISSION,'GRANDTOTAL'=>$obj->SAL_GRANDTOTAL);
      	}
      }
      $stmt_cour=$sql->Execute($sql->Prepare("SELECT PRESC_COUR_NAME,PRESC_COUR_CODE from hms_patient_prescription WHERE PRESC_PACKAGECODE=".$sql->Param('a')." "),array($keys));
      if ($stmt_cour->RecordCount()>0){
      	$objcour=$stmt_cour->FetchNextObject();
      $courier_name=$objcour->PRESC_COUR_NAME;
   //   $courier_number=$objcour->PRESC_COUR_CODE;
      $stmt_tel=$sql->Execute($sql->Prepare("SELECT FACI_PHONENUM from hmsb_allfacilities WHERE FACI_CODE=".$sql->Param('a').""),array($objcour->PRESC_COUR_CODE));
      if ($stmt_tel->RecordCount()>0){
      	$objnum=$stmt_tel->FetchNextObject();
      	$courier_number=$objnum->FACI_PHONENUM;
      }else{
      	$courier_number='';
      }
      }else{
      	$courier_name='';
      }
    ?>
<div class="main-content">
    <div class="page-wrapper page form">
        <div class="moduletitle">
            <div class="moduletitleupper">Receipt
                <span class="pull-right">
                <input type="hidden" class="form-control" value="<?php echo $visitcode;?>"id="visitcode" name="visitcode" >
               <button type="button" class="form-tools print-block" onclick="printDiv('printReport')" style="font-size:18px; padding-top:-10px;" title="Print Receipt">
                        <i class="fa fa-print"></i>
                    </button>
                    <button class="btn btn-dark" onclick="document.getElementById('view').value='';document.myform.submit;" style="font-size:15px; padding-top:-10px; line-height:1.3em" title="Done">Done</button>
               <!--     <button class="form-tools" onclick="document.getElementById('view').value='';document.myform.submit;" style="font-size:18px; padding-top:-10px;" title="Generate Excel">
                        <i class="fa fa-file-excel-o"></i>
                    </button>
                    <button class="form-tools" onclick="document.getElementById('view').value='';document.myform.submit;" style="font-size:18px; padding-top:-10px;" title="Generate PDF">
                        <i class="fa fa-file-pdf-o"></i>
                    </button>
                    
                    -->
                </span>
            </div>
        </div>
        <div class="page-report" id="printReport">
            <table>
                <tr class="report-title">
                    <td width="25%"><?php //echo $keys."BooooooooooooooooooooooooooM"?>
                        <img src="<?php echo $report_comp_logo; ?>"/><br>
                        <span><b> Name:</b> <?php echo $customer; ?></span><br>
                        <span><b>#:</b> <?php echo $code; ?></span><br>
                        
                    </td>
                    <td width="60%"><h4><?php echo $report_title; ?></h4></td>
                    <td class="address" width="30%">
                    	<span><b>Pharmacy:</b> <?php echo $report_comp_name; ?></span><br>
                        <span><b>Location:</b> <?php echo $report_comp_location; ?></span><br>
                        <span><b>Phone Number:</b> <?php echo $report_phone_number; ?></span><br>
                        <span><b>Date:</b> <?php echo date("d/m/Y",strtotime($date_rec)); ?></span><br>
                        <?php if(!empty($courier_name)){?>
                        <span><b>Courier:</b> <?php echo $courier_name; echo !empty($courier_number)?"($courier_number)":'';?></span><br><br>	
                        <?php }else{?>
                        <span><b>Self pickup</b> </span><br><br>
                        <?php }?>
                        <span><b>Pickup Code: </b><?php echo $pickupcode?> </span><br><br>
                        
                    </td>
                </tr>
                </table>
                <table>
                <tr width="100%">
                <th width="5%"><b>No.</b></th>
                <th width="30%"><b>Medication</b></th>
                <th width="10%"><b>Unit Price</b></th>
                <th width="10%"><b>Quantity</b></th>
                <th width="10%"><b>Total</b></th>
                
                </tr>
                <br>
                <?php 
                $i=1;
                $grandtotal=0;
                foreach ($cart_rec as $key){
                	//$grandtotal = $grandtotal + $key['QUANTITY']* $key['COST']; 
                //	$totalcommision=$key['TOTALCOMMISSION'];
                	$grandtotal=$key['GRANDTOTAL'];
                ?>
                <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $key['DRUG'];?></td>
                <td><?php echo number_format($key['COST'],2);?></td>
                <td><?php echo number_format($key['QUANTITY'],2);?></td>
                <td><?php echo number_format($key['COST']* $key['QUANTITY'],2);?></td>
                </tr>
                </br>
                <?php }?>
                <!-- <tr>
                <td colspan="4"><b>Service Charge:</b></td>
                <td><b><?php echo number_format($totalcommision,2);?></b></td>
                </tr>-->
                <tr>
                <td colspan="4" style="text-align: right"><b>Total:</b></td>
                <td><b><?php echo number_format($grandtotal,2);?></b></td>
                </tr>
                    <td class="report-content">
                    <?php //print_r($cart_rec);?>
                        <?php // echo $report_content; ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>