<?php 
ob_start(); 
error_reporting(0);
include("../../../../config.php");
include SPATH_LIBRARIES.DS."engine.Class.php";
$engine= new engineClass();
$actor_id = $engine->getActorCode();
$userInfo= $engine->getActorDetails();
$facilitycode = $engine->getFacilityDetails();
$actor_facilitycode =!empty($facilitycode->FACI_CODE)?$facilitycode->FACI_CODE:$actor_id;
// echo $actor_facilitycode;
// var_dump($_POST);
$transcode=$_POST["transcode"];
$stmt=$sql->Execute($sql->Prepare("SELECT HRMSTRANS_ID,HRMSTRANS_CODE,HRMSTRANS_WALCODE,HRMSTRANS_USERCODE,HRMSTRANS_USERTYPE,HRMSTRANS_AMOUNT,HRMSTRANS_DATE,HRMSTRANS_RECEIVER,HRMSTRANS_TRANS_ACC,HRMSTRANS_STATUS,HRMSTRANS_CONFIRM_STATUS FROM hms_wallet_transaction   WHERE HRMSTRANS_CODE = ".$sql->Param('a')." "),array($transcode));
// var_dump($stmt);
$stmd= $sql->Execute($sql->Prepare("SELECT HRMSTRANSDETAILS_OPENING_BAL,HRMSTRANSDETAILS_AMOUNT,HRMSTRANSDETAILS_CLOSING_BAL,HRMSTRANSDETAILS_TYPE,HRMSTRANSDETAILS_USERCODE,HRMSTRANSDETAILS_DESC,HRMSTRANSDETAILS_DATE FROM hms_wallet_transaction_details WHERE HRMSTRANSDETAILS_TRANSCODE=".$sql->Param('a')." AND HRMSTRANSDETAILS_USERCODE=".$sql->Param('a').""),array($transcode,$actor_facilitycode));
// var_dump($stmd);
$objx=$stmt->FetchNextObject();

// echo $objx;
if($objx->HRMSTRANS_USERTYPE =='1'){
                        	$type="Doctor";
                        }elseif($objx->HRMSTRANS_USERTYPE =='2'){
                        	$type="Patient";
                        }elseif($objx->HRMSTRANS_USERTYPE =='3'){
                            $type="Lab";
                        }elseif($objx->HRMSTRANS_USERTYPE =='4'){
                            $type="Pharmacy";
                        }elseif($objx->HRMSTRANS_USERTYPE =='5'){
                            $type="Courier";
                        }
                        $currency='¢';
                           $sta=!empty($engine->getPaymentBy($objx->HRMSTRANS_USERCODE))?$engine->getPaymentBy($objx->HRMSTRANS_USERCODE): $type;
                      if($objx->HRMSTRANS_USERTYPE==2){
                       $status= $engine->getFacDetCode($objx->HRMSTRANS_RECEIVER);
                      }else{
                         $status=$sta;
                      }
                      $status_arr = array("1"=>"Credit","2"=>"Debit");
                    $status_trans = array("1"=>"Success","0"=>"Pending","2"=>"Failed");
                     $stas= ['0'=>'<label class="text-primary">PENDING</lable>','1'=>'<label class="text-success">SUCCESS</label>','2'=>'<label class="text-danger">FAILED</label>'];
                      if ($objx->HRMSTRANS_TRANS_ACC=="") {
                          # code...
                        $sttd=$sql->Execute($sql->Prepare("SELECT HRMSWAL_CODE FROM  hms_wallets WHERE HRMSWAL_USERCODE=".$sql->Param('a').""),array($objx->HRMSTRANS_USERCODE));
                        $sttobj=$sttd->FetchNextObject();
                        $accno=  $sttobj->HRMSWAL_CODE;
                        $paymethod="Hewale Wallet";
                      }else{
                         $accno=$objx->HRMSTRANS_TRANS_ACC;
                           $paymethod="MOMO Wallet";
                      }
?>

            <div class="col-sm-12 salesoptblock">
                <div class="col-sm-12 salesoptselect">
                    <div class="form row">
                        <div class="col-sm-4 form-group">
                        <label class="form-label required">Transaction Code: <?php echo $transcode; ?></label>
                           
                           
                        </div>
                        <div class="col-sm-4 form-group">
                            <label class="form-label required">Sender: <?php echo $engine->getUSerDetils($objx->HRMSTRANS_USERCODE) ?></label>
                           
                        </div>

                        <div class="col-sm-4 form-group">
                        <label class="form-label required">Reciever:  <?php echo $status; ?></label>
                           
                        </div>

                        <div class="col-sm-4 form-group">
                            <label class="form-label required">Amount: <?php echo $currency." ".number_format($objx->HRMSTRANS_AMOUNT,2); ?></label>
                           
                        </div>

                        <div class="col-sm-4 form-group">
                        <label class="form-label required">Account Number:  <?php echo  $accno; ?></label>
                           
                        </div>
                        
                        <div class="col-sm-4 form-group">
                        <label class="form-label required">Transaction Date:  <?php echo date("d/m/Y",strtotime($objx->HRMSTRANS_DATE)); ?></label>
                           
                        </div>

                        <div class="col-sm-4 form-group">
                        <label class="form-label required">Type:  <?php echo $status_arr[$objx->HRMSTRANS_STATUS] ?></label>
                           
                        </div>

                        <div class="col-sm-4 form-group">
                        <label class="form-label ">Status: <?php echo $stas[$objx->HRMSTRANS_CONFIRM_STATUS]; ?>  </label>
                           
                        </div>
                        <div class="col-sm-4 form-group">
                        <label class="form-label ">Payment Method: <?php echo $paymethod; ?>  </label>
                           
                        </div>
                                               
						<!-- <div class="col-sm-6">
                        <label class="form-label required">Courier:  </label>
                      
                        </div> -->
                        
                     

                      <!--   <div class="col-sm-2">
                            <label class="form-label">&nbsp;&nbsp;</label>
                        
                        </div> -->

                    </div>
                </div>
             <!--    <div class="col-sm-4 salestotalarea">
                    <div class="col-sm-12">
                        <label>Pickup Code:</label>
                        <span></span>
                        <input type="text" name="totalamount" id="" maxlength="7" value="" autocomplete="off">
                    </div>
                </div> -->
            </div>
             <div class="moduletitle" style="margin-bottom:0px; margin-top: 10px4">
                                          <!-- <div class="moduletitleupper">Wallet  Details</div> -->
                                          
            </div>
            <?php if ($stmd->RecordCount() > 0) {
            	$objex = $stmd->FetchNextObject();
            	# code...?>

   <div class="col-sm-12 salesoptblock">
                <div class="col-sm-12 salesoptselect">
                    <div class="form row">
                        <div class="col-sm-4 form-group">
                        <label class="form-label required">Previous Balance: <?php echo $currency." ".number_format($objex->HRMSTRANSDETAILS_OPENING_BAL,2); ?></label>
                           
                           
                        </div>
                        <div class="col-sm-4 form-group">
                            <label class="form-label required">Current Balance: <?php echo $currency." ".number_format($objex->HRMSTRANSDETAILS_CLOSING_BAL,2);  ?></label>
                           
                        </div>

                        <div class="col-sm-4 form-group">
                       <!--  <label class="form-label required">Deductions:  <?php $total= $objex->HRMSTRANSDETAILS_AMOUNT ;
                         	echo  $currency." ".number_format($total,2);
                         ?></label> -->
                           
                        </div>

                      <!--   <div class="col-sm-4 form-group">
                            <label class="form-label required">Amount: <?php echo $currency." ".number_format($objx->HRMSTRANS_AMOUNT,2); ?></label>
                           
                        </div> -->

                      

                                               
						<!-- <div class="col-sm-6">
                        <label class="form-label required">Courier:  </label>
                      
                        </div> -->
                        
                     

                      <!--   <div class="col-sm-2">
                            <label class="form-label">&nbsp;&nbsp;</label>
                        
                        </div> -->

                    </div>
                </div>

            <?php
        }else{

            } ?>