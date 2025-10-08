<div class="main-content">

    <div class="page-wrapper">
        <div class="page form">
        


            <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper">Prescription History 
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
                                    <th>Visit Date</th>
                                    <th>Action</th>
                                   
                                   
                                </tr>
                                </thead>
                                <tbody>
                                <!-- table displays here -->

                                <?php 
                                if ($stmthis->RecordCount()>0) {
                                    $num=1;
                                    while ($obj=$stmthis->FetchNextObject()) {
                                       // echo "jashdjfhjasd";
                                
                                echo '    
                               <tr>
                                   <td>'.$num++.'</td>

                                   <td>'.date("d/m/Y", strtotime($obj->PRESCM_DATE)).'</td>

                                   <td><button class="btn btn-primary" type="submit" onClick="document.getElementById(\'view\').value=\'details\';document.getElementById(\'viewpage\').value=\'detailshist\';document.getElementById(\'keyscode\').value=\''.$obj->PRESCM_VISITCODE.'\';document.myform.submit()"><span class="fa fa-pencil"></span> Details</button></td>

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

