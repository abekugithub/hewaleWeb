<?php
$rs = $paging->paginate();
?>

    <div class="main-content">

        <div class="page-wrapper">


            

            <!-- <div class="page-lable lblcolor-page">Table</div>-->
            <div class="page form">
                <div class="moduletitle" style="margin-bottom:0px;">
                    <div class="moduletitleupper">Delivery Payments</div>
                </div>
<?php $engine->msgBox($msg,$status); ?>
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
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" tabindex="1" value="<?php echo $fdsearch; ?>" class="form-control square-input" name="fdsearch" placeholder="Enter Process Code to Search"
                                />
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
                            <!--<button type="button" data-toggle="modal" data-target="#addDesp" class="btn btn-info"><i class="fa fa-plus-circle"></i> Add Dispensary </button>-->
                        </div>
                    </div>
                </div>


                

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Process Code</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Status</th>
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
						   $newdate = date("d/m/Y", strtotime($obj->COUP_DATE));
						   $delievery = $obj->COUP_STATUS;
						   $delstatus = "";
						   
						   if ($delievery == '1') {
							   $delstatus = 'Paid';
							   }else {
								  $delstatus = 'Not Paid'; 
							   }
                    
                   echo '<tr>
                        <td>'.$num++.'</td>
                        <td>'.$obj->COUP_PROCESSCODE.'</td>
                        <td>'.$obj->COUP_AMT.'</td>
                        <td>'.$newdate.'</td>
						<td>'.$delstatus.'</td>
						
                    </tr>';
										}}
					?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>


    <!-- Modal -->
