<?php
//echo $delstatus;exit;
?>

  <div class="main-content">
    <div class="page-wrapper">

      <!-- <div class="page-lable lblcolor-page">Table</div>-->
      <div class="page form">
        <div class="moduletitle" style="margin-bottom:0px;">

          <div class="moduletitleupper">View Delivery History Of:
            <?php echo $patientname;?>
          </div>

        </div>
        <div class="pagination-tab">
          <div class="table-title">
            <div class="pagination-right">
              <button type="button" class="btn btn-danger" onclick="document.getElementById('viewpage').value='';document.getElementById('view').value='';document.myform.submit();"><i class="fa fa-arrow-left"></i> Back </button>
            </div>
          </div>
        </div>
        <div class="col-sm-12">
          <div class="col-sm-6">
            <div class="form-group">
              <div class="moduletitleupper">Personal Information </div>
              <div class="col-sm-12 personalinfo-info">

                <table class="table personalinfo-table">
                  <tr>
                    <td><b>Name:</b>
                      <?php echo $patientname;?>
                    </td>
                     <?php if($delstatus == '5') {?>
                    <td><b>Pickup Code:</b>
                      <?php echo $pickupcode;?>
                    </td>
                    <?php } elseif ($delstatus == '6') {?>
                    <td><b>Delivery Code:</b>
                      <?php echo $pickdelcode;?>
                    </td>
                    <?php } ?>
                  </tr>
                </table>

              </div>
            </div>
          </div>

          <div class="col-sm-6">
            <div class="form-group">
              <div class="moduletitleupper">Pharmacy </div>
              <div class="col-sm-12 personalinfo-info">

                <table class="table personalinfo-table">
                  <tr>
                    <td><b>Pharmacy:</b>
                      <?php echo $pharmname; ?>
                    </td>
                    <td><b>Location:</b>
                      <?php echo $pharmloc; ?>
                    </td>
                    <td><b>Date:</b>
                      <?php echo $pharmdate; ?>
                    </td>
                  </tr>
                </table>

              </div>
            </div>
          </div>
        </div>
		
         <div class="col-sm-12 deliveredtrack">
         
         <ol class="progtrckr" data-progtrckr-steps="3">
        <li class="progtrckr-done"> Processing</li><!--
     --><li class="progtrckr-done">In Transit</li><!--
     --><li class="progtrckr-done">Delivered</li>
    </ol>
         
         </div>
   
        <div class="col-sm-12">
          <div class="moduletitleupper">Drugs Information </div>
          <table class="table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Drugs</th>
                <th>Quantity</th>
                <th>Dosage Form</th>
              </tr>
            </thead>
            <tbody>
              <?php
                 
                    if($stmtpris->RecordCount()>0){  
    $num = 1;
    while($obj = $stmtpris->FetchNextObject()){
                    
                   echo '<tr>
                        <td>'.$num.'</td>
                        <td>'.$encaes->decrypt($obj->PRESC_DRUG).'</td>
                        <td>'.$obj->PRESC_QUANTITY.'</td>
                        <td>'.$obj->PRESC_DOSAGENAME.'</td>
                       
						
						
                    </tr>';
										}}
					?>
            </tbody>
          </table>


        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->