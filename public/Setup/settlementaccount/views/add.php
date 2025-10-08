    <div class="main-content">

        <div class="page-wrapper">

            <?php $engine->msgBox($msg,$status); ?>

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
                                <label for="fname">Payment Mode:</label> <span id="mypaymode" class="text-danger"></span>
                                <select class="form-control" name="paymode" id="paymode">
                                    <option value=""> Select Payment Mode</option>
                                    <?php while ($edobj= $stmt->FetchNextObject()) {?>
                                        <option value="<?php echo $edobj->SETM_CODE ?>"><?php echo $edobj->SETM_NAME; ?></option>

                                      <?php  # code...
                                    } ?>
                                </select>
                                   </div>
                            
                            
                               <div class="col-sm-12">
                               
                            </div>  
                            
                                 <div class="col-sm-12" id="showmomo" style="display: none;">
                                <label for="userlevel" id="netw">Network:</label> <span id="mynetwork" class="text-danger"></span>
                               
                                 
                                   <select name="userlevel1" id="userlevel1" class="form-control select2" >
                                    
                                 </select>
                                 
                            </div>
                             <div class="col-sm-12">
                                <label for="userlevel" id="momon">Mobile / Bank / Card Number</label> <span id="momocrid" class="text-danger"></span>
                                <input type="number" name="momo_crdno" id="momo_crdno" min="0" class="form-control">
                            </div> 
                            
                   
                        </div>
                        <div class="form-group" id="mybranch" style="display: none;">
                            <div class="col-sm-12">
                                <label>Branch Name</label> <span id="mbranch" class="text-danger"></span>
                                <input type="text" name="branchname" id="branchname" class="form-control">
                            </div>
                        </div>
                       
                   <!--      <div class="form-group " id="cardms">
                            <div class="col-sm-8">
                                 <label for="userlevel">Expiration Date:</label> <span id="mycdexe" class="text-danger"></span>
                                <input  type="text" class="form-control monthpicker" name="cardExpiry" id="cardExpiry" min="0"  placeholder="MM / YY" autocomplete="cc-exp"  />
                            </div> 
                            <div class="col-sm-4">
                               <label for="userlevel">CV Code:</label> <span id="mycvcode" class="text-danger"></span>
                               <input type="Number" name="cvcode" id="cvcode" min="0" maxlength="4" class="form-control">
                            </div> 
                        </div> -->
            
                        <div class="form-group">
   
                        <!--   <div class="col-sm-12">
                                <label for="othername">Description:</label>                                 
                                 <textarea class="form-control" cols="20" name="descrpt" id= "descrpt">
                                 <?php echo $descrpt ;?>
                                 </textarea>
                                 
                            </div> -->
                            
                           
       
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
        
        if($('#paymode').val()==""){
            // 
            $('#mypaymode').html("required");
            return false;
        }
        // alert($('#paymode').val());
        if ($('#paymode').val()=="1816111"  && $('#userlevel1').val()==" " ) {
           $('#mynetwork').html("required");
           return false;

        }  
        if ( $('#paymode').val()=="1816193"  && $('#userlevel1').val()==" " ) {
           $('#mynetwork').html("required");
           return false;

        }     
         if ($('#momo_crdno').val()=="" ) {
            $('#momocrid').html("required");   
           return false;

        }
         if ($('#paymode').val() =="1816193" && $('#branchname').val()=="" ) {
           $('#mbranch').html("required");
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
           document.getElementById('view').value='';document.getElementById('viewpage').value='savemomo';document.myform.submit();
  

        }else if($('#paymode').val()=="1816193"){
              document.getElementById('view').value='';document.getElementById('viewpage').value='savebank';document.myform.submit();
  
        }
        else{
             document.getElementById('view').value='';document.getElementById('viewpage').value='savecard';document.myform.submit();
        }
           }

      $('#paymode').change(function(e){
        var paymode = $(this).val();
        // alert(paymode);
        $.ajax({
            method:'POST',
            url:'public/Setup/settlementaccount/model/getMomData.php',
            data:{'paymode':paymode},
            success:function(response){
                if (paymode=='1816111') {
                    $('#showmomo').show();
                    $('#cardms').hide();
                    $('#mybranch').hide();
                    $('#netw').html('Network');
                $('#userlevel1').html(response);
                $("#momon").html("Mobile Number");
                }else if(paymode=='1816193'){
                     $('#showmomo').show();
                     $('#mybranch').show();
                    $('#userlevel1').html(response);  
                    $('#cardms').hide();
                    $('#netw').html('Bank Name');
                     $("#momon").html("Bank Account");
                }
                else if(paymode==''){
                   $('#showmomo').hide();  
                   $('#mybranch').hide();  
                   $('#cardms').show();  
                   $("#momon").html("Mobile / Bank / Card Number");
                }else{
                   $('#showmomo').hide();  
                   $('#mybranch').hide();  
                   $('#cardms').show();  
                   $("#momon").html("Card Number");
                }

            }
        })
      });
    $(document).ready(function(){
$('.monthpicker').datepicker({
        viewMode: 'months',
        minViewMode: 'months',
        todayHighlight: true,
        autoclose: true,
        format: 'mm/yyyy',
        dateFormat:'mm/yy'
    });

    
});
  </script>