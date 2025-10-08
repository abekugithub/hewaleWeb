<div class="main-content">

    <div class="page-wrapper">
        <div class="page form">
        


            <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper">Prescription History Details
                <input id="keyscode" name="keyscode" value="<?php echo $keyscode; ?>" type="hidden" />   
                
                
                <!-- <button type="submit" class="btn btn-dark pull-right" onClick="document.getElementById('view').value='';document.getElementById('viewpage').value='cancelsale';document.myform.submit();">Back</button></div> -->

                <?php $engine->msgBox($msg,$status); ?>
            </div>
           
            <div class="row col-sm-12">
                <!-- Table Section -->
                <div class="col-sm-12 tableoptblock">
                   
                    <div class="row">
                        <div class="panel-body table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Drug</th>
                                    <th>Quantity</th>
                                    <th>Dosage</th>
                                   
                                   
                                </tr>
                                </thead>
                                <tbody>
                                <!-- table displays here -->

                                <?php 
                                if ($stmtdetails->RecordCount()>0) {
                                    $num=1;
                                    while ($objx=$stmtdetails->FetchNextObject()) {
                                
                                echo '    
                               <tr>
                                   <td>'.$num++.'</td>

                                   <td>'. $encaes->decrypt($objx->PRESC_DRUG).'</td>

                                   <td>'.$objx->PRESC_QUANTITY.'</td>
                                   <td>'.$objx->PRESC_DOSAGENAME.'</td>

                               </tr>';

                                    }

                                }

                               ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- End -->

                <!-- Footer Section -->
                
            </div>


            <!-- Begining of image
		<div class="row col-sm-3" >
		<table class="table table-hover">
		<thead><td>Drug</td><td>Quantity</td><td>Dosage</td></thead>
		<tbody>
<?php foreach ($prescarray as $value){?>
		<tr><td><?php echo $encaes->decrypt($value[1]);?></td><td><?php echo $value[2];?></td><td><?php echo $value[3];?></td></tr>
           <?php }?>
		<?php  //print_r($prescarray);?>
		</tbody>
		</table>
		    </div>-->
        </div>
    </div>
</div>
</div>

