<div class="main-content">
    <div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Medical History <span class="pull-right">
                    <button class="btn btn-dark" onclick="document.getElementById('view').value='';document.myform.submit;"><i class="fa fa-arrow-left"></i> Back</button>
                    </span>
                </div>
            </div>
       
            
            <div class="col-sm-12 conshistoryinfo">
               
                <div class="col-sm-3">
                Diagnosis
                </div>
                 <div class="col-sm-8">
                 <?php echo $diagnosishes;?>
                 </div>
                
                
                <div class="col-sm-3">
                Lab Request 
                </div>
                 <div class="col-sm-8">
                 <?php echo $labshes;?>
                 </div>
                 
                 <div class="col-sm-3">
                Prescription
                </div>
                 <div class="col-sm-8">
                 <?php echo $patpresc;?>
                 </div>
                
                
                
                
                
                
            </div>
            
            
            
            
            

        </div>
    </div>

</div>