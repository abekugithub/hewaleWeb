<?php
/**
 * Created by PhpStorm.
 * User: Adusei
 * Date: 11/15/2018
 * Time: 12:11 PM
 */
	   $rs = $paging->paginate();
 ?>
  <input id="srvcategory" name="srvcategory" value="<?php echo $srvcategory?>" type="hidden" />
    <input id="servicename" name="servicename" value="<?php echo $servicename; ?>" type="hidden" />
 

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
          
         
    <div class="page-wrapper">
        <ul class="nav nav-tabs">
            <li class=" <?php echo $srvcategory == '%'?'active':''; ?>">
                <a data-toggle="tab" href="javascript:;" onclick="$('#srvcategory').val('%');$('#myform').submit();">All</a>
            </li>
            <?php  foreach($categories as $categoryCode => $categoryName){?>

            	<li class=" <?php echo $srvcategory == $categoryCode?'active':''; ?>">
                <a data-toggle="tab" href="javascript:;"  onclick="$('#srvcategory').val('<?php echo $categoryCode; ?>');$('#myform').submit();"> <?php echo $categoryName; ?></a>
            </li>

       <?php    } ?>
           <!--  
            <li>
                <a data-toggle="tab" href="#menu2">Menu 2</a>
            </li> -->
        </ul>
        <div class="page form">
            <div class="tab-content">
                <div id="" class="tab-pane fade in active">
                  
            <div class="pagination-tab">
                <div class="table-title">
                    <div class="col-sm-3">
                        <div id="pager">
                            <?php echo $paging->renderFirst('<span class="fa fa-angle-double-left"></span>');?>
                            <?php echo $paging->renderPrev('<span class="fa fa-arrow-circle-left"></span>','<span class="fa fa-arrow-circle-left"></span>');?>
                            <input name="page" type="text" class="pagedisplay short" value="<?php echo $paging->renderNavNum();?>" readonly />
                            <?php echo $paging->renderNext('<span class="fa fa-arrow-circle-right"></span>','<span class="fa fa-arrow-circle-right"></span>');?>
                            <?php echo $paging->renderLast('<span class="fa fa-angle-double-right"></span>');?>
                            <?php $paging->limitList($limit,"myform");?>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="input-group">
                            <input type="text" tabindex="1" value="<?php echo $fdsearch; ?>" class="form-control square-input" name="fdsearch" placeholder="Search "/>
                            <span class="input-group-btn">
                                <button type="submit" onclick="document.getElementById('action_search').value='search';document.getElementById('viewpage').value='';document.myform.submit;" class="btn btn-default btn-gyn-search"> <i class="fa fa-search"></i> </button>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group">
                            <button type="submit" onclick="document.getElementById('action_search').value='';
                        	        document.getElementById('viewpage').value='reset';document.myform.submit;" class="btn btn-success btn-square"> <i class="fa fa-refresh"></i> </button>
                        </div>
                    </div>
                     <div class="pagination-right">
                            <button type="submit" onclick="document.getElementById('view').value='add';document.getElementById('viewpage').value='';document.myform.submit;" class="btn btn-info"><i class="fa fa-plus-circle"></i> Add Account </button>
                            
                            
                        </div>
                    <div class="pagination-right" id="hiddenbtn" style="display: ">
                                 </div>
                </div>
            </div>

  <table class="table table-hover">
                <thead>
                    <tr>
                        <th></th>
                        
						<th>Account Type</th>
                        <th>Account Name</th>
                        <th>Account No.</th>
                        <th>Date</th>
						<th>Status</th>
                        <th>Action</th>
                        
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
						   //$usergroup = $engine->geAllUsersGroup($obj->USR_USERID);
                    if ($obj->SET_TYPE=='1') {
                    	$mytype='Mobile Money';
                    }elseif($obj->SET_TYPE=='3'){

                     $mytype='Bank';	
                    }
                    else{
                    $mytype='Card'; 
                    }
                    if ($obj->SET_STATUS==1) {
                        $status="ACTIVE";
                    }else{
                        $status="INACTIVE"; 
                    }
                   echo '<tr >
							
						<td>'.$num.'</td>
                        <td>'.$mytype.'</td>
                        <td>'.$obj->SET_ACC_NAME.'</td>
						<td>'.$obj->SET_ACC_NO.'</td>
                        <td>'.$sql->UserDate($obj->SET_DATE,'d/m/Y').'</td>
						<td>'. $status.'</td>
						<td> 
                            <div class="btn-group">
                                <button type="button" class="btn btn-info btn-square" dropdown-toggle" data-toggle="dropdown">Options <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><button type="submit" onclick="document.getElementById(\'view\').value=\'edit\';document.getElementById(\'keys\').value=\''.$obj->SET_CODE.'\';document.getElementById(\'viewpage\').value=\'edit\';document.myform.submit;">Edit Account</button></li>
                                
                                    <li><button type="submit" onclick="if(confirm(\'You are about to delete this account.\\n\\n Note: This process cannot be reversed.\\n \\n Are you sure?\')){document.getElementById(\'view\').value=\'\';document.getElementById(\'keys\').value=\''.$obj->SET_CODE.'\';document.getElementById(\'viewpage\').value=\'delete\';document.myform.submit;}else{return false ; }">Delete Account</button></li>
                                </ul>
                            </div>
							
						</td>
                    </tr>';
					$num ++; }
				
					
					}else{
					?>
                    <tr><td colspan="5">No Records Found</td></tr>
                    <?php }?>
                </tbody>
            </table>

                </div>
             <!--    <div id="menu1" class="tab-pane fade">
                    <h3>Menu 1</h3>
                    <p>Some content in menu 1.</p>
                </div>
                <div id="menu2" class="tab-pane fade">
                    <h3>Menu 2</h3>
                    <p>Some content in menu 2.</p>
                </div> -->
            </div>
        </div>
    </div>

       

        </div>
    </div>





   


   

</div>