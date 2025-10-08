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
    $stmt=$sql->Execute($sql->Prepare("SELECT SAL_DRUG,SAL_DOSAGE,SAL_QUANTITY,SAL_COST,SAL_NHIS,SAL_CUSTOMER,SAL_USERNAME,SAL_METHOD,SAL_CRDATE from hms_pharmacysales WHERE SAL_CODE=".$sql->Param('a')." AND SAL_FACICODE=".$sql->Param('b')." "),array($salcode,$faccode));
      if ($stmt->RecordCount()>0){
      	while ($obj=$stmt->FetchNextObject()){
      	$date_rec=$obj->SAL_CRDATE;
      	$cart_rec[]=array('DRUG'=>$obj->SAL_DRUG,'DOSAGE'=>$obj->SAL_DOSAGE,'QUANTITY'=>$obj->SAL_QUANTITY,'NHIS'=>$obj->SAL_NHIS,'COST'=>$obj->SAL_COST,'CUSTOMER'=>$obj->SAL_CUSTOMER,'USERNAME'=>$obj->SAL_USERNAME,'METHOD'=>$obj->SAL_METHOD,'DATE'=>$obj->SAL_CRDATE);
      	}
      }
    ?>
<div class="main-content">
    <div class="page-wrapper page form">
        <div class="moduletitle">
            <div class="moduletitleupper">Receipt
                <span class="pull-right">
               <button type="button" class="form-tools print-block" onclick="printDiv('printReport')" style="font-size:18px; padding-top:-10px;" title="Print Receipt">
                        <i class="fa fa-print"></i>
                    </button>
                    <button class="form-tools" onclick="document.getElementById('view').value='';document.myform.submit;" style="font-size:25px; padding-top:-10px; line-height:1.3em" title="Close">&times;</button>
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
                    <td width="15%">
                        <img src="<?php echo $report_comp_logo; ?>"/>
                    </td>
                    <td width="60%"><h4><?php echo $report_title; ?></h4></td>
                    <td class="address" width="30%">
                    	<span><b>Pharmacy:</b> <?php echo $report_comp_name; ?></span><br><br>
                        <span><b>Location:</b> <?php echo $report_comp_location; ?></span><br><br>
                        <span><b>Phone Number:</b> <?php echo $report_phone_number; ?></span><br><br>
                        <span><b>Date:</b> <?php echo date("d/m/Y",strtotime($date_rec)); ?></span><br><br>
                    </td>
                </tr>
                </table>
                <table>
                <tr width="100%">
                <th width="5%"><b>No.</b></th>
                <th width="30%"><b>Drug</b></th>
                <th width="10%"><b>Price</b></th>
                <th width="10%"><b>Quantity</b></th>
                <th width="10%"><b>Total</b></th>
                <th width="5%"><b>Insurance</b></th>
                </tr>
                <br>
                <?php 
                $i=1;
                $grandtotal=0;
                foreach ($cart_rec as $key){
                	$grandtotal = $grandtotal + $key['QUANTITY']* $key['COST']; 
                ?>
                <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $key['DRUG'];?></td>
                <td><?php echo number_format($key['COST'],2);?></td>
                <td><?php echo number_format($key['QUANTITY'],2);?></td>
                <td><?php echo number_format($key['COST']* $key['QUANTITY'],2);?></td>
                <td><?php echo number_format($key['NHIS'],2);?></td>
                </tr>
                </br>
                <?php }?>
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