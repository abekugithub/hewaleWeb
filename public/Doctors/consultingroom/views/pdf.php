<?php
include('../../../../public/Doctors/consultingroom/validate.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
<link href="../../../../media/css/main.css" rel = "stylesheet" type = "text/css"/>

<script type="text/javascript" src="../../../../media/js/jquery.min.js"></script>
<script type="text/javascript" src="../../../../media/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../../../../media/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../../../../media/js/bootstrap-toggle.min.js"></script>

<script type="text/javascript" src="../../../../media/js/select2.full.js"></script>
<script type="text/javascript" src="../../../../media/js/custom.js"></script>
<script type="text/javascript" src="../../../../media/js/moment.min.js"></script>
<script type="text/javascript" src="../../../../media/js/ez.countimer.js"></script>

</head>
<body>
<div class="main-content">

<div class="page-wrapper">

    <!-- <div class="page-lable lblcolor-page">Table</div>-->
    <div class="page form">
            <input type="hidden" class="form-control" id="keys" name="keys" value="<?php echo $keys; ?>" readonly>
    
        <div class="moduletitle" style="margin-bottom:0px;">
            <div class="moduletitleupper">Preview of Patients Lab Result</div>
            <button class="btn btn-dark pull-right" onclick="document.getElementById('view').value='details';document.getElementById('viewpage').value='details';document.myform.submit;" style="font-size:15px; padding-top:-10px; line-height:1.3em;  margin-top:-40px;" title="Back" formnovalidate>Back</button>
        </div>
       <div class="col-sm-12 salesoptblock">
            <div class="col-sm-12 salesoptselect">
                <div class="form row">
                            <div class="col-sm-4 form-group">
                    <label class="form-label required">Batch Code: <?php echo ($packagecode?$packagecode:'');?></label>
                        
                    </div>
                    <div class="col-sm-4 form-group">
                        <label class="form-label required">Gender: <?php echo ($patientgender?$patientgender:'');?></label>
                       
                    </div>

                    <div class="col-sm-4 form-group">
                    <label class="form-label required">Customer Name:  <?php echo ($patient?$patient:'');?></label>
                       <input type="hidden" name="customername" value="<?php echo $patient;?>">
                    </div>

                    <div class="col-sm-4 form-group">
                        <label class="form-label required">Age: <?php echo ($patientage?$patientage:'N/A') ; ?></label>
                       
                    </div>

                    <div class="col-sm-4 form-group">
                    <label class="form-label required">Hewale Number:  <?php echo ($patientnum?$patientnum:'') ; ?></label>
                       
                    </div>
                    
                    <div class="col-sm-4 form-group">
                    <label class="form-label required">Request Date:  <?php echo date("d/m/Y",strtotime($patientdate))  ;?></label>
                       
                    </div>

                    <div class="col-sm-4 form-group">
                    <label class="form-label required">Customer Contact:  <?php echo ($patientcontact?$patientcontact:'');?></label>
                       
                    </div>

                    <div class="col-sm-4 form-group">
                    <label class="form-label required">Lab:  <?php echo ($labname?$labname:'N/A') ;?> </label>
                       
                    </div>
                    
                    <div class="col-sm-4 form-group">
                    <label class="form-label required">Test:<?php echo ($test_name?$encaes->decrypt($test_name):'N/A') ;?> </label>
                       
                    </div>
                    
                    

                </div>
                </div>
            <!-- <div class="col-sm-4 salestotalarea">
                <div class="col-sm-12">
                    <label>Total:</label>
                    <span><?php echo $currency;?></span>
                    <input type="text" name="totalamounts" id="totalamounts" value="<?php echo $Total;?>" maxLength="7" >
                </div>
            </div>-->
        </div>



<?php 
// var_dump($pdffile);die();
?>



<?php if (is_array($pdffile) && count($pdffile)> 0){
    foreach ($pdffile as $singlefile){
    ?>

<object>	

<!-- type="application/pdf" -->

    <iframe id="myFrame" src="media/uploaded/labresult/<?php echo $singlefile?>#toolbar=0" width="100%" height="1000" >                
    </iframe>  

    <script>
        document.getElementById('myFrame').onload = function() {

            var iframe = document.getElementById('myFrame'),
            iframeDoc = iframe.contentWindow.document;
            var otherimg = iframeDoc.getElementsByTagName("img")[0];

            var att = document.createAttribute("style");    
            att.value = "width: 100%;";                        
            otherimg.setAttributeNode(att); 
        }
    </script>

</object>  

<?php }}else{?>
    <p>Sorry, No file Found.</p>
<?php }?>

</div>




    <script>

        $(document).ready(function(e){
            var iframe = document.getElementById("myFrame");
            var elmnt = iframe.contentWindow.document.getElementsByClassName('toolbar');
            // alert(elmnt);
            elmnt.style.display = "none";

            console.log("hello");
            
        });

        

    </script>


</div>

</div>

<!--  <iframe id="invisible" style="display:none;"></iframe>-->

</body>
</html>
