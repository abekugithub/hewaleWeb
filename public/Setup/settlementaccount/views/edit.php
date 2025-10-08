    <div class="main-content">

        <div class="page-wrapper">

            <?php $engine->msgBox($msg,$status);
               
                // echo "okkk".$catname;
             ?>

            <div class="page form">
                <div class="moduletitle">
                    <div class="moduletitleupper">Manage Settlement Account
                    <span class="pull-right">
                       <!--  <button class="form-tools" onclick="document.getElementById('view').value='';document.myform.submit;" style="font-size:18px; padding-top:-10px;">
                            <i class="fa fa-clone"></i>
                        </button> -->
                        <button class="form-tools" onclick="document.getElementById('view').value='';document.myform.submit;" style="font-size:25px; padding-top:-10px;">&times;</button>
                    </span>
                </div>
                </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label for="fname">Payment Mode:</label> <span id="mypaymode" class="text-danger" ></span>
                                <select class="form-control" name="paymode" id="paymode" disabled="disabled" >
                                    <option value=""> Select Payment Mode</option>
                                    <?php while ($edobj= $stmt->FetchNextObject()) {?>
                                        <option value="<?php echo $edobj->SETM_CODE ?>" <?php echo (($edobj->SETM_CODE==$catname)?"selected='selected'":''); ?>><?php echo $edobj->SETM_NAME; ?></option>

                                      <?php  # code...
                                    } ?>
                                </select>
                                   </div>
                            
                            
                               <div class="col-sm-12">
                               
                            </div>  
                            <?php if ($catname=='1816111') {?>
                              <div class="col-sm-12" id="showmomo" >
                                <label for="userlevel">Network:</label> <span id="mynetwork" class="text-danger"></span>
                               
                                 
                                   <select name="userlevel1" id="userlevel1" class="form-control" >
                                    <option value=" ">Select Network</option>
                                    <option  value="MTN" <?php echo (($accname=='MTN')?"selected='selected'":''); ?> >MTN</option>
                                    <option  value="AIRTLE" <?php echo (($accname=='AIRTEL')?"selected='selected'":''); ?>>AIRTEL</option>
                                    <option  value="VODAFONE" <?php echo (($accname=='VODAFONE')?"selected='selected'":''); ?>>VODAFONE</option>
                                    <option value="TIGO" <?php echo (($accname=='TIGO')?"selected='selected'":''); ?>>TIGO</option>
                                 </select>
                                 
                            </div>
                             <?php   # code...
                            }elseif ($catname=='1816193') {
                                # code...
                             ?>
                              <div class="col-sm-12" id="showmomo" >
                                <label for="userlevel">Bank Name:</label> <span id="mynetwork" class="text-danger"></span>
                               
                                 
                                   <select name="userlevel1" id="userlevel1" class="form-control" >
                                    <option value=" ">Select Bank Name</option>
                                    <?php 
                                    if ($stmtd->RecordCount() > 0) {

                                        while ($obj=$stmtd->FetchNextObject()) { ?>
                                    <option value="<?php echo $obj->BANK_NAME; ?>" <?php echo (($accname==$obj->BANK_NAME)?"selected='selected'":''); ?> ><?php echo $obj->BANK_NAME; ?></option>

                                    <?php    }
                                    }else{
                                        echo '<option>no records found</option>';
                                    }
                                    ?>
                                    
                                         </select>
                                 
                            </div>
                            <?php }
                            ?>
                                
                             <div class="col-sm-12">
                            

                                <label for="userlevel" id="momon"><?php 
                                if ($catname=='1816111') {
                                    # code...
                                    echo 'Mobile Number';
                                }elseif ($catname=='1816193') {
                                    # code...
                                    echo 'Account Number ';
                                }else{
                                   echo 'Card Number'; 
                                }
                                //echo $catname=='1816111'?' Mobile Number': 'Card Number'; ?></label> <span id="momocrid" class="text-danger"></span>
                                 <input type="number" name="momo_crdno" id="momo_crdno" min="0" class="form-control" value="<?php echo $accno; ?>">
                            </div> 
                            
                   
                        </div>

                       <?php if ( $catname=='1816193') {?>
                           <div class="form-group" id="mybranch" style="">
                            <div class="col-sm-12">
                                <label>Branch Name</label> <span id="mbranch" class="text-danger"></span>
                                <input type="text" name="branchname" id="branchname" value="<?php echo $msbranch ?>" class="form-control">
                            </div>
                        </div>
                    <!--     <div class="form-group " id="cardms">
                            <div class="col-sm-8">
                                 <label for="userlevel">Expiration Date:</label> <span id="mycdexe" class="text-danger"></span>
                                <input  type="text" class="form-control monthpicker" name="cardExpiry" id="cardExpiry" min="0"  placeholder="MM / YY" autocomplete="cc-exp"  value="<?php echo $expydate; ?>" />
                            </div> 
                            <div class="col-sm-4">
                               <label for="userlevel">CV Code:</label> <span id="mycvcode" class="text-danger"></span>
                               <input type="number" name="cvcode" id="cvcode" min="0" maxlength="4" class="form-control" value="<?php echo $ccvcode; ?>">
                            </div> 
                        </div> -->
                      <?php     # code...
                       } ?>
                        
            
                        <div class="form-group">
                           <!--  <?php if($mstatus !=='2'){?> -->
                          <div class="col-sm-12">
                                <label for="othername">Status:</label> 
                                <select id="status" name="status" class="form-control">
                                    <option value="1" <?php echo (($mstatus=='1')?"selected='selected'":''); ?>>Active</option>
                                    <option value="0" <?php echo (($mstatus=='0')?"selected='selected'":''); ?>>Inactive</option>
                                </select>                                
                                
                                 
                            </div>
                           <!--  <?php  }?> -->
                           
       
                        </div>
              
                    
<div class="btn-group">
                            <div class="col-sm-12">
                                 <button type="button" onclick="getAccountData()" class="btn btn-info"><i class="fa fa-plus-circle"></i> Save </button>
                                <button type="submit" class="btn btn-danger" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit;">Cancel</button>
                            </div>
                        </div>
                        
                    </div>

                    

            </div>
        </div>
    </div>

<script type="text/javascript">
    function getAccountData(){
        // alert("hi");
        if($('#paymode').val()==""){
            // 
            $('#mypaymode').html("required");
            return false;
        }
        // alert($('#paymode').val());
        if ($('#paymode').val()=="1816111" && $('#userlevel1').val()==" " ) {
           $('#mynetwork').html("required");
           return false;

        }     
         if ($('#momo_crdno').val()=="" ) {
            $('#momocrid').html("required");   
           return false;

        }
        // if ($('#paymode').val() =="1816112" && $('#cardExpiry').val()=="" ) {
        //    $('#mycdexe').html("required");
        //    return false;

        // } 
        // if ($('#paymode').val() =="1816112" && $('#cvcode').val()=="" ) {
        //    $('#mycvcode').html("required");
        //    return false;

        // }

       

        if ($('#paymode').val()=="1816111") {
            // alert("asdsadasda");
            document.getElementById('view').value='';document.getElementById('viewpage').value='editmomo';document.myform.submit();
  

        }else if($('#paymode').val()=="1816193"){
              document.getElementById('view').value='';document.getElementById('viewpage').value='editbank';document.myform.submit();
  
        }
        else{
            // alert("card");
              document.getElementById('view').value='';document.getElementById('viewpage').value='editcard';document.myform.submit();
        }
           }

      // $('#paymode').change(function(e){
      //   var paymode = $(this).val();
      //   // alert(paymode);
        
      // });



    $(document).ready(function(){
        // alert( $('#paymode').val());
       
$('.monthpicker').datepicker({
        viewMode: 'months',
        minViewMode: 'months',
        todayHighlight: true,
        autoclose: true,
        format: 'mm/yyyy',
        dateFormat:'mm/yy'
    });

    
});

     // function getmomo(){
     //        alert("erwrwe");
     //          var paymode = $('#paymode').val();
     //        $.ajax({
     //        method:'POST',
     //        url:'public/Setup/settlementaccount/model/getMomData.php',
     //        data:{'paymode':paymode},
     //        success:function(response){
     //            if (paymode=='1816111') {
     //                $('#showmomo').show();
     //                $('#cardms').hide();
     //            $('#userlevel1').html(response);
     //            $("#momon").html("Mobile Number");
     //            }else{
     //               $('#showmomo').hide();  
     //               $('#cardms').show();  
     //               $("#momon").html("Card Number");
     //            }

     //        }
     //    });
     //    }

  </script>