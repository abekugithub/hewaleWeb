<?php
$rs = $paging->paginate();
?>
<style>
.rowdanger{
	background-color:#97181B4D}
.rowwarning{
	background-color:#EBECB9}
</style>
    <div class="main-content">

        <div class="page-wrapper">


            <?php //$engine->msgBox($msg,$status); ?>

            <!-- <div class="page-lable lblcolor-page">Table</div>-->
            <div class="page form">
                <div class="moduletitle" style="margin-bottom:0px;">
                    <div class="moduletitleupper">Registration of Stocks</div> 
                </div>

                <div class="pagination-tab">
                    <div class="table-title">
                        <div class="col-sm-3">
                            <div id="pager">
                                <?php echo $paging->renderFirst('<span class="fa fa-angle-double-left"></span>');?>
                                <?php echo $paging->renderPrev('<span class=""></span>','<span class="fa fa-arrow-circle-left"></span>');?>
                                <input name="page" type="text" class="pagedisplay short" value="<?php echo $paging->renderNavNum();?>" readonly />
                                <?php echo $paging->renderNext('<span class="fa fa-arrow-circle-right"></span>','<span class="fa fa-arrow-circle-right"></span>');?>
                                <?php echo $paging->renderLast('<span class="fa fa-angle-double-right"></span>');?>
                                <?php $paging->limitList($limit,"myform");?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <input type="text" tabindex="1" value="<?php echo $fdsearch; ?>" class="form-control square-input" name="fdsearch" placeholder="Enter Category to Search"/>
                                <span class="input-group-btn">
                                            <button type="submit" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='searchitem';document.myform.submit;" class="btn btn-default btn-gyn-search"> <i class="fa fa-search"></i> </button>
                                        </span>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <button type="submit" onclick="document.getElementById('view').value='';
                        	        document.getElementById('viewpage').value='reset';document.myform.submit;" class="btn btn-success btn-square"> <i class="fa fa-refresh"></i> </button>
                            </div>
                        </div>
                        <div class="pagination-right">
                         <button type="submit" onclick="document.getElementById('view').value='upload';document.getElementById('viewpage').value='upload';document.myform.submit;" class="btn btn-success"><i class="fa fa-upload"></i>Upload Drug(s)</button>
                           <button type="submit" onclick="document.getElementById('view').value='add';document.getElementById('viewpage').value='';document.myform.submit;" class="btn btn-info"><i class="fa fa-plus-circle"></i> Add Stock </button>
                                                      
                        </div>
                        
                    </div>
                </div>
<?php $engine->msgBox($msg,$status); ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            
							<th>#</th>
							<th>Item Name</th>
							<th>Dosage</th>
							
							
							
							
                            <th width="170">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                 $num = 1;
                  if($paging->total_rows > 0 ){
                           $page = (empty($page))? 1:$page;
                           $num = (isset($page))? ($limit*($page-1))+1:1;
                           while(!$rs->EOF){
                           $obj = $rs->FetchNextObject();
					//	   $consperiod = $patientCls->getConsultPeriod($obj->PRESC_CODE);
						  
                   echo '<tr >
				   
                        <td>'.$num++.'</td>
                        
                        <td>'.$obj->ST_NAME.'</td>
                        <td>'.$obj->ST_DOSAGE.'</td>
						
                       
						
						
						<td><div class="btn-group">
                                <button type="button" class="btn btn-info btn-square" dropdown-toggle" data-toggle="dropdown">Options <span class="caret"></span></button>
                         <ul class="dropdown-menu" role="menu">
                             <li><button type="submit" onclick="document.getElementById(\'keys\').value=\''.$obj->ST_CODE.'\';document.getElementById(\'viewpage\').value=\'edititem\';document.getElementById(\'view\').value=\'edit\';document.myform.submit;">Edit</button></li>
							<li><button type="submit" onclick="document.getElementById(\'keys\').value=\''.$obj->ST_CODE.'\';document.getElementById(\'viewpage\').value=\'\';document.getElementById(\'view\').value=\'addstock\';document.myform.submit;">Delete</button></li>
									
                         </ul>
                            </div>
                        </td>
										 
						
                    </tr>';
					}}
					?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>


    <!-- Modal -->
<div id="addDesp" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Despensary</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
        <div class="form-group">
                           
                            <div class="col-sm-6">
                                <label for="dosage">Dosage:</label>
                                 <input type="text" class="form-control" id="dosage" name="dosage" value="" autocomplete="off" readonly  value="<?php echo $dosage;?>">
                            </div>
                            
                            
                            
                           
                            
                
                            <div class="form-group">  
                            <div class="col-sm-6">
                                <label for="level">Alert Stock</label>
                               <input type="text" class="form-control" id="level" name="level" value="<?php echo $level;?>" autocomplete="off">
                            </div>
							</div>
                           
                           

                           
                        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success btn-square" data-dismiss="modal">Save</button>
        <button type="button" class="btn btn-info btn-square" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>