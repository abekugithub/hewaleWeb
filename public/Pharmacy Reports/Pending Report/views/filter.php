<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 11/27/2017
 * Time: 4:35 PM
 */
?>

<div class="main-content">
    <div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Filter - Pending Report
                    <span class="pull-right">
                        <button class="form-tools" onclick="document.getElementById('view').value='';document.myform.submit;" style="font-size:18px; padding-top:-10px;">
                            <i class="fa fa-clone"></i>
                        </button>
                        <button class="form-tools" onclick="document.getElementById('view').value='';document.myform.submit;" style="font-size:25px; padding-top:-10px;">&times;</button>
                    </span>
                </div>
            </div>
            <form action="" method="post" enctype="multipart/form-data" name="myform">
              <!--  <input type="hidden" name="views" value="" id="views" class="form-control" />
                <input type="hidden" name="viewpages" value="" id="viewpages" class="form-control" />
                <input type="hidden" name="key" value="<?php //echo $key;?>" id="key" class="form-control" />
                <input type="hidden" name="patkey" value="<?php //echo $patkey; ?>" id="patkey" class="form-control" />
                <input type="hidden" name="microtime" value="<?php //echo microtime();?>" id="microtime" class="form-control" />
                <input type="hidden" name="action_search" value="" id="action_search" class="form-control" />-->
                

            <div class="form-group">
                <div class="col-sm-10">
                <div class="col-sm-5 required">
                    <label for="datefrom">From:</label>
                    <input type="date" class="form-control" id="datefrom" name="datefrom">
                </div>
                <div class="col-sm-5 required">
                    <label for="dateto">To:</label>
                    <input type="date" class="form-control" id="dateto" name="dateto">
                </div>
                </div>
                <div class="col-sm-10">
                <div class="col-sm-5">
                    <label for="hewale_number">Hewale Number:</label>
                    <input type="input" placeholder="Enter hewale number" class="form-control" id="hewale_number" name="hewale_number">
                </div>
                <div class="col-sm-5">
                    <label for="prescriber">Prescribed By:</label>
                    <select id="prescriber_name" name="prescriber_name" class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                    <option value="">--Select Prescriber--</option>
					<?php if($prescriber_list->RecordCount()>0){
                    while($obj=$prescriber_list->FetchNextObject()){?>
                    
                    <option value ="<?php echo $obj->PRESC_ACTORNAME?>"><?php echo $obj->PRESC_ACTORNAME;?></option>
                    
                 <?php    }
                    }else{?>
                    	<option value ="">--No Prescriber--</option>
                    <?php }?>
                    </select>
                    
                </div>
                </div>
            </div>
            
            

            <div class="btn-group pull-right">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-success" id="report" onclick="document.getElementById('view').value='report';document.getElementById('viewpage').value='report';document.myform.submit();">Submit</button>
                    <button type="submit" class="btn btn-danger">Cancel</button>
                   
                </div>
            </div>

        </div>
    </div>
     <?php 
           /**            $stmt = $sql->Execute($sql->Prepare("SELECT PRESC_CODE,PRESC_VISITCODE,PRESC_PATIENTNUM,PRESC_PATIENT,PRESC_ACTORNAME,PRESC_DATE,PRESC_DRUGID,PRESC_DRUG,PRESC_QUANTITY,PRESC_DOSAGENAME,PRESC_FREQ,PRESC_DAYS,PRESC_TIMES,CASE PRESC_STATUS WHEN '0' THEN 'CANCELLED' WHEN '1' THEN 'PENDING' WHEN '2' THEN 'PENDING PAYMENT' WHEN '3' THEN 'PAID' WHEN '4' THEN 'COURIER' WHEN '5' THEN 'TRANSIT' WHEN '6' THEN 'DELIVERED' END PRESC_STATUS FROM hms_patient_prescription WHERE PRESC_INSTCODE ='0002'"));
		 if ($stmt->RecordCount()>0){
		 	while ($obj=$stmt->FetchNextObject()){
		 		$data_array[$obj->PRESC_VISITCODE][]=array('PRESC_CODE'=>$obj->PRESC_CODE,'PRESC_PATIENTNUM'=>$obj->PRESC_PATIENTNUM,'PRESC_PATIENT'=>$obj->PRESC_PATIENT,'PRESC_ACTORNAME'=>$obj->PRESC_ACTORNAME,'PRESC_DATE'=>$obj->PRESC_DATE,'PRESC_DRUGID'=>$obj->PRESC_DRUGID,'PRESC_DRUG'=>$obj->PRESC_DRUG,'PRESC_QUANTITY'=>$obj->PRESC_QUANTITY,'PRESC_DOSAGENAME'=>$obj->PRESC_DOSAGENAME,'PRESC_FREQ'=>$obj->PRESC_FREQ,'PRESC_DAYS'=>$obj->PRESC_DAYS,'PRESC_TIMES'=>$obj->PRESC_TIMES,'PRESC_STATUS'=>$obj->PRESC_STATUS);
		 	}
		 }
		 foreach ($data_array as $key=>$val){
		 	echo $key;
		 	 foreach ($val as $value){
		 	 //	echo $value['PRESC_CODE'];
		 	 }
		 }
		
        print '<pre>';
        print_r($data_array);
        print '</pre>';**/
                    ?>
</div>
