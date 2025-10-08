<?php
if(isset($paging)){
$rs = $paging->paginate();
}
?>

    <div class="main-content">

        <div class="page-wrapper">

			  <input id="search" name="search" value="" type="hidden" />
            <!-- <div class="page-lable lblcolor-page">Table</div>-->
            <div class="page form">
          <!-- for selecting method type --> 
           <div class="moduletitle" style="margin-bottom:0px;">
                    <div class="moduletitleupper"> Add Payment Method</div>
                   
                </div>
                <div class="pagination-tab">
                    <div class="table-title">
                        <div class="col-sm-4">
                        <select name="category" id="category" class="form-control" onchange="<?php if (isset($categorytype)&& !empty($categorytype)){?> document.getElementById('categorytype').value='';<?php }?>document.myform.submit()">
                                     <option value="">Select Category</option>
                        <?php if(is_array($catarray) && count($catarray)>0){
                        foreach ($catarray as $value){?>
                        		<option value="<?php echo $value['CATEGORY_CODE']?>" <?php echo ($value['CATEGORY_CODE']==$category)?"selected":''; ?> ><?php echo $value['CATEGORY_NAME']?></option>
                        <?php }}?>             
                                 </select>
                        </div>
                        <?php 
                        //if category is CASH
                        if (isset($category) && !empty($category)){?>
                        <div class="col-sm-4">
                        <select name="categorytype" id="categorytype" class="form-control" onchange="document.myform.submit()">
                                     <option value="">Select Type</option>
                        <?php if(is_array($cattypearray) && count($cattypearray)>0){
                        foreach ($cattypearray as $valuetype){?>
                        		<option value="<?php echo $valuetype['TYPE_CODE']?>" <?php echo ($valuetype['TYPE_CODE']==$categorytype)?"selected":''; ?> ><?php echo $valuetype['TYPE_NAME']?></option>
                        <?php }}?>             
                                 </select>
                        </div>
                        <?php }?>

                        <div class="pagination-right">
                            <!-- <button type="submit" onclick="document.getElementById('view').value='vitals';document.myform.submit;" class="btn btn-info"><i class="fa fa-plus-circle"></i> Add Dispensary </button> -->
                        </div>
                    </div>
                </div>
                <!-- end of selecting payment method  -->
                <!-- begining of selecting payment type -->
                <?php if (isset($categorytype) && !empty($categorytype)){
                		$engine->msgBox($msg,$status);
                ?>
                
                <div class="pagination-tab">
                    <div class="table-title">
                <?php }?>
                <?php 
                //If it is cash:
                if ($category=='PC0001'){
                //mobile money
                	if ($categorytype=='PMT0001'){?>
                 <div class="col-sm-7">
                            <div class="col-sm-7 input-group" stye="margin-left:10px">
                            <label for="account">Mobile Number:</label>
<input id="account" class="form-control" name="account" required="" autocomplete="off" type="text" placeholder="Enter mobile money number" style="margin-right:0px;">
                             <span class="input-group-btn"></span>
                             <span class="input-group-btn">
                            <label for=""></label> 
                                            <button style="margin-bottom:-25px;" type="submit" onclick="document.getElementById('viewpage').value='savedetails';document.myform.submit;" class="btn btn-info btn-gyn-search"> <i class="fa fa-plus"></i>Add </button>
                                        </span>
                        </div>
                        </div>
                <?php }
                //master card
                elseif ($categorytype=='PMT0002'){?>
                	<div class="col-sm-7">
                            <div class="col-sm-7 input-group" stye="margin-left:10px">
                            <label for="account">Master Card Account Number:</label>
<input id="account" class="form-control" name="account" required="" autocomplete="off" type="text" placeholder="Enter mastercard number" style="margin-right:0px;">
                             <span class="input-group-btn"></span>
                             <span class="input-group-btn">
                            <label for=""></label> 
                                            <button style="margin-bottom:-25px;" type="submit" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='savedetails';document.myform.submit;" class="btn btn-info btn-gyn-search"> <i class="fa fa-plus"></i>Add </button>
                                        </span>
                        </div>
                        </div>
              <?php   }
                //bank accounts
                elseif ($categorytype=='PMT0009'){?>
                	<div class="col-sm-8">
                            <div class="col-sm-12 input-group" stye="margin-left:10px">
                            <label for="account">Bank Account Number:</label>
<input id="account" class="form-control" name="account" required="" autocomplete="off" type="text" placeholder="Enter bank account number" style="margin-right:0px;">
                             <span class="input-group-btn"></span>
                             <label for="accountname">Bank Name:</label>
<input id="accountname" class="form-control" name="accountname" required="" autocomplete="off" type="text" placeholder="Enter bank name" style="margin-right:0px;">
                             <span class="input-group-btn"></span>
                             <span class="input-group-btn">
                            <label for=""></label> 
                                            <button style="margin-bottom:-25px;" type="submit" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='savedetails';document.myform.submit;" class="btn btn-info btn-gyn-search"> <i class="fa fa-plus"></i>Add </button>
                                        </span>
                        </div>
                        </div>
                <?php }elseif($categorytype=='PMT0010'){?>
                	<button style="margin-bottom:-25px;" type="submit" onclick="document.getElementById('viewpage').value='savedetails';document.myform.submit;" class="btn btn-info btn-gyn-search"> <i class="fa fa-plus"></i>Add </button>
                <?php }
                }elseif($category=='PC0002'){
                if ($categorytype=='PMT0003'){
                	?>
                <!-- If it is NHIS -->
                <div class="col-sm-12">
                            <div class="col-sm-12 input-group" stye="margin-left:10px">
                            <label for="district">District :</label>
<input id="district" class="form-control" name="district" required="" autocomplete="off" type="text" placeholder="Enter NHIS District" style="margin-right:0px;">
                             <span class="input-group-btn"></span>
                             <label for="location">Location :</label>
<input id="location" class="form-control" name="location" required="" autocomplete="off" type="text" placeholder="Enter Location" style="margin-right:0px;">
                             <span class="input-group-btn"></span>
                             <label for="contact">Contact :</label>
<input id="contact" class="form-control" name="contact" autocomplete="off" type="text" placeholder="Enter telephone number" style="margin-right:0px;">
                             <span class="input-group-btn"></span>
                             <span class="input-group-btn">
                            <label for=""></label> 
                                            <button style="margin-bottom:-25px;" type="submit" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='savedetails';document.myform.submit;" class="btn btn-info btn-gyn-search"> <i class="fa fa-plus"></i>Add </button>
                                        </span>
                        </div>
                        </div>
                <!-- End of if it is NHIS -->
                <?php
                }}elseif ($category=='PC0003'){
                if ($categorytype=='PMT0004' ||$categorytype=='PMT0005'){
                	?>
                <!-- If it is Private health Insurance -->
                <div class="col-sm-12">
                            <div class="col-sm-12 input-group" stye="margin-left:10px">
                            <label for="companyname">Company Name :</label>
<input id="companyname" class="form-control" name="companyname" required="" autocomplete="off" type="text" placeholder="Enter Location" style="margin-right:0px;">
                             <span class="input-group-btn"></span>
                             <label for="insurance">Insurance :</label>
<input id="insurance" class="form-control" name="insurance" required="" autocomplete="off" type="text" placeholder="Enter Insurance type" style="margin-right:0px;">
							<span class="input-group-btn"></span>
                             <label for="location">Location :</label>
<input id="location" class="form-control" name="location" required="" autocomplete="off" type="text" placeholder="Enter Location" style="margin-right:0px;">
                             <span class="input-group-btn"></span>
                             <label for="contact">Contact :</label>
<input id="contact" class="form-control" name="contact" autocomplete="off" type="text" placeholder="Enter telephone number" style="margin-right:0px;">
                             <span class="input-group-btn"></span>
                             <span class="input-group-btn">
                            <label for=""></label> 
                                            <button style="margin-bottom:-25px;" type="submit" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='savedetails';document.myform.submit;" class="btn btn-info btn-gyn-search"> <i class="fa fa-plus"></i>Add </button>
                                        </span>
                        </div>
                        </div>
                <!-- End of if it is Private health Insurance -->
                <?php }}elseif ($category=='PC0004'){
                if ($categorytype=='PMT0006'|| $categorytype=='PMT0007' || $categorytype=='PMT0008'){
                	?>
                <!-- If it is Partner Company -->
                <div class="col-sm-12">
                            <div class="col-sm-12 input-group" stye="margin-left:10px">
                            <label for="companyname">Company Name :</label>
<input id="companyname" class="form-control" name="companyname" required="" autocomplete="off" type="text" placeholder="Enter Company Name" style="margin-right:0px;">
                            <span class="input-group-btn"></span>
                             <label for="location">Location :</label>
<input id="location" class="form-control" name="location" required="" autocomplete="off" type="text" placeholder="Enter Location" style="margin-right:0px;">
                             <span class="input-group-btn"></span>
                             <label for="contact">Contact :</label>
<input id="contact" class="form-control" name="contact" autocomplete="off" type="text" placeholder="Enter telephone number" style="margin-right:0px;">
                             <span class="input-group-btn"></span>
                             <span class="input-group-btn">
                            <label for=""></label> 
                                            <button style="margin-bottom:-25px;" type="submit" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='savedetails';document.myform.submit;" class="btn btn-info btn-gyn-search"> <i class="fa fa-plus"></i>Add </button>
                                        </span>
                        </div>
                        </div>
                <!-- End of if it is Partner Company -->
                <?php }}?>
			    <div class="pagination-tab">
                    <div class="table-title">
                       <!--  <div class="col-sm-3">
                         <input type="text" tabindex="1" value="<?php echo $fdsearch; ?>" class="form-control square-input" name="fdsearch" placeholder="Enter mobile money number"
                                />  
                        </div>-->
                       
                        
                        <div class="pagination-right">
                            <!-- <button type="submit" onclick="document.getElementById('view').value='vitals';document.myform.submit;" class="btn btn-info"><i class="fa fa-plus-circle"></i> Add Dispensary </button> -->
                        </div>
                    </div>
                </div>
                
                
                
                
                <!-- end ofselecting payment type -->
                
                <div class="moduletitle" style="margin-bottom:0px;">
                    <div class="moduletitleupper">Existing Payment Method</div>
                </div>

                <div class="pagination-tab">
                    <div class="table-title">
                        <div class="col-sm-3">
                            <div id="pager">
                            <?php if (isset($paging)){?>
                                <?php echo $paging->renderFirst('<span class="fa fa-angle-double-left"></span>');?>
                                <?php echo $paging->renderPrev('<span class="fa fa-arrow-circle-left"></span>','<span class="fa fa-arrow-circle-left"></span>');?>
                                <input name="page" type="text" class="pagedisplay short" value="<?php echo $paging->renderNavNum();?>" readonly />
                                <?php echo $paging->renderNext('<span class="fa fa-arrow-circle-right"></span>','<span class="fa fa-arrow-circle-right"></span>');?>
                                <?php echo $paging->renderLast('<span class="fa fa-angle-double-right"></span>');?>
                                <?php $paging->limitList($limit,"myform");?>
                                <?php }?>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" tabindex="1" value="<?php echo $fdsearch; ?>" class="form-control square-input" name="fdsearch" id="fdsearch" placeholder="Enter to search"
                                />
                                <span class="input-group-btn">
                                            <button type="submit" onclick="document.myform.submit;" class="btn btn-default btn-gyn-search"> <i class="fa fa-search"></i> </button>
                                        </span>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <button type="submit" onclick="document.getElementById('view').value='';
                        	        document.getElementById('fdsearch').value='';document.myform.submit;" class="btn btn-success btn-square"> <i class="fa fa-refresh"></i> </button>
                            </div>
                        </div>
                        <div class="pagination-right">
                           <!--    <button type="submit" onclick="document.getElementById('view').value='paymentscheme';document.myform.submit;" class="btn btn-info"><i class="fa fa-plus-circle"></i> Add Payment Scheme </button>-->
                        </div>
                    </div>
                </div>


                
<?php
/***********************************************************************************
 * 				IF CATEGORY IS SELECTED											   *
 * 					TABLE LOAD   												   *
 ***********************************************************************************/
//if ONLY METHOD TYPE IS SELECTED
if ((!empty($category) && isset($category)) || (isset($categorytype) && !empty($categorytype)) ){
	//CASH CATEGORY
	if ($category=='PC0001'){ ?>
		<table class="table table-hover">
                    <thead>
                        <tr>
                           <th>#</th>
                            <th>Category</th>
                            <th>Type</th>
                            <th>Details</th>
                           	<th>Status</th>
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
						   $usergroup = $engine->geAllUsersGroup($obj->USR_USERID);
                    
                   echo '<tr>
                        <td>'.$num++.'</td>
						<td>'.$obj->PCS_CATEGORY.'</td>
						<td>'.$obj->PAYM_NAME.'</td>
						<td>'.$obj->PINS_ACC_DETAILS.'</td>
                        <td>'.(($obj->PINS_STATUS == 1)?'Enabled':'Disabled').'</td>
						<td><div class="btn-group">
                                <button type="button" class="btn btn-info btn-square">Options</button>
                                <button type="" class="btn btn-info btn-square dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
								
								<li><button type="submit" onclick="document.getElementById(\'keys\').value=\''.$obj->PINS_CODE.'\';document.getElementById(\'viewpage\').value=\'getclientdetails\';document.getElementById(\'view\').value=\'firstaid\';document.myform.submit;">Disable</button></li>
								
                                    
                                </ul>
                            </div>
                        </td>
                    </tr>';
					}}
					?>
                    </tbody>
                </table>
	<?php }
	//NHIS
	elseif ($category=='PC0002'){?>
		<table class="table table-hover">
                    <thead>
                        <tr>
                           <th>#</th>
                            <th>Category</th>
                            <th>Type</th>
                            <th>Location</th>
                           	<th>Contact</th>
                           	<th>Status</th>
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
						   $usergroup = $engine->geAllUsersGroup($obj->USR_USERID);
                    
                   echo '<tr>
                        <td>'.$num++.'</td>
						<td>'.$obj->PCS_CATEGORY.'</td>
						<td>'.$obj->PAYM_NAME.'</td>
						<td>'.$obj->PINS_LOCATION.'</td>
						<td>'.$obj->PINS_CONTACT.'</td>
                        <td>'.(($obj->PINS_STATUS == 1)?'Enabled':'Disabled').'</td>
						<td><div class="btn-group">
                                <button type="button" class="btn btn-info btn-square">Options</button>
                                <button type="" class="btn btn-info btn-square dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
								
								<li><button type="submit" onclick="document.getElementById(\'keys\').value=\''.$obj->PINS_CODE.'\';document.getElementById(\'viewpage\').value=\'getclientdetails\';document.getElementById(\'view\').value=\'firstaid\';document.myform.submit;">Disable</button></li>
								
                                    
                                </ul>
                            </div>
                        </td>
                    </tr>';
					}}
					?>
                    </tbody>
                </table>
	<?php }
	//PRIVATE HEALTH
	elseif ($category=='PC0003'){?>
				<table class="table table-hover">
                    <thead>
                        <tr>
                           <th>#</th>
                            <th>Category</th>
                            <th>Type</th>
                            <th>Company</th>
                            <th>Insurance</th>
                            <th>Location</th>
                           	<th>Contact</th>
                           	<th>Status</th>
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
						   $usergroup = $engine->geAllUsersGroup($obj->USR_USERID);
                    
                   echo '<tr>
                        <td>'.$num++.'</td>
						<td>'.$obj->PCS_CATEGORY.'</td>
						<td>'.$obj->PAYM_NAME.'</td>
						<td>'.$obj->PINS_COMPANY_NAME.'</td>
						<td>'.$obj->PINS_LOCATION.'</td>
						<td>'.$obj->PINS_INSURANCE_NAME.'</td>
						<td>'.$obj->PINS_CONTACT.'</td>
                        <td>'.(($obj->PINS_STATUS == 1)?'Enabled':'Disabled').'</td>
						<td><div class="btn-group">
                                <button type="button" class="btn btn-info btn-square">Options</button>
                                <button type="" class="btn btn-info btn-square dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
								
								<li><button type="submit" onclick="document.getElementById(\'keys\').value=\''.$obj->PINS_CODE.'\';document.getElementById(\'viewpage\').value=\'getclientdetails\';document.getElementById(\'view\').value=\'firstaid\';document.myform.submit;">Disable</button></li>
								
                                    
                                </ul>
                            </div>
                        </td>
                    </tr>';
					}}
					?>
                    </tbody>
                </table>
		
	<?php }
	//PARTNER COMPANY
	elseif ($category=='PC0004'){?>
				<table class="table table-hover">
                    <thead>
                        <tr>
                           <th>#</th>
                            <th>Category</th>
                            <th>Type</th>
                            <th>Company</th>
                            <th>Location</th>
                           	<th>Contact</th>
                           	<th>Status</th>
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
						   $usergroup = $engine->geAllUsersGroup($obj->USR_USERID);
                    
                   echo '<tr>
                        <td>'.$num++.'</td>
						<td>'.$obj->PCS_CATEGORY.'</td>
						<td>'.$obj->PAYM_NAME.'</td>
						<td>'.$obj->PINS_COMPANY_NAME.'</td>
						<td>'.$obj->PINS_LOCATION.'</td>
						<td>'.$obj->PINS_CONTACT.'</td>
                        <td>'.(($obj->PINS_STATUS == 1)?'Enabled':'Disabled').'</td>
						<td><div class="btn-group">
                                <button type="button" class="btn btn-info btn-square">Options</button>
                                <button type="" class="btn btn-info btn-square dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
								
								<li><button type="submit" onclick="document.getElementById(\'keys\').value=\''.$obj->PINS_CODE.'\';document.getElementById(\'viewpage\').value=\'getclientdetails\';document.getElementById(\'view\').value=\'firstaid\';document.myform.submit;">Disable</button></li>
								
                                    
                                </ul>
                            </div>
                        </td>
                    </tr>';
					}}
					?>
                    </tbody>
                </table>
	<?php }?>
                
                <?php }
                
/***********************************************************************************
 * 				IF NOTHING IS SELECTED											   *
 * 					TABLE LOAD   												   *
 ***********************************************************************************/
                //if CATEGORY AND METHOD TYPE IS SELECTED
                elseif(empty($category) && !isset($category) && !isset($categorytype) && empty($categorytype)){ ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                           <th>#</th>
                            <th>Category</th>
                            <th>Method</th>
                            <th>Details</th>
                            <th>Status</th>
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
						   $usergroup = $engine->geAllUsersGroup($obj->USR_USERID);
                    
                   echo '<tr>
                        <td>'.$num++.'</td>
						<td>'.$obj->PCS_CATEGORY.'</td>
                        <td>'.$obj->PAYM_NAME.'</td>
                        <td>'.(!empty($obj->PINS_ACC_DETAILS)?$obj->PINS_ACC_DETAILS:$obj->PINS_COMPANYNAME.$obj->PINS_LOCATION).'</td>
                        <td>'.(($obj->PINS_STATUS == '1')?'Enabled':'Disabled').'</td>
						<td><div class="btn-group">
                                <button type="button" class="btn btn-info btn-square">Options</button>
                                <button type="" class="btn btn-info btn-square dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
								
								<li><button type="submit" onclick="document.getElementById(\'keys\').value=\''.$obj->REQU_CODE.'\';document.getElementById(\'viewpage\').value=\'getclientdetails\';document.getElementById(\'view\').value=\'firstaid\';document.myform.submit;">Disable</button></li>
								
                                    
                                </ul>
                            </div>
                        </td>
                    </tr>';
					}}
					?>
                    </tbody>
                </table>
                <?php }else{?>
                 
                <table class="table table-hover">
                    <thead>
                        <tr>
                           <th>#</th>
                            <th>Category</th>
                            <th>Method</th>
                            <th>Details</th>
                            <th>Status</th>
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
						   $usergroup = $engine->geAllUsersGroup($obj->USR_USERID);
                    
                   echo '<tr>
                        <td>'.$num++.'</td>
						<td>'.$obj->PCS_CATEGORY.'</td>
                        <td>'.$obj->PAYM_NAME.'</td>
                        <td>'.(!empty($obj->PINS_ACC_DETAILS)?$obj->PINS_ACC_DETAILS:$obj->PINS_COMPANYNAME.$obj->PINS_LOCATION).'</td>
                        <td>'.(($obj->PINS_STATUS == '1')?'Enabled':'Disabled').'</td>
						<td><div class="btn-group">
                                <button type="button" class="btn btn-info btn-square">Options</button>
                                <button type="" class="btn btn-info btn-square dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
								
								<li><button type="submit" onclick="document.getElementById(\'keys\').value=\''.$obj->REQU_CODE.'\';document.getElementById(\'viewpage\').value=\'getclientdetails\';document.getElementById(\'view\').value=\'firstaid\';document.myform.submit;">Disable</button></li>
								
                                    
                                </ul>
                            </div>
                        </td>
                    </tr>';
					}}
					?>
                    </tbody>
                </table>
                <?php 
                 }?>
            </div>

        </div>

    </div>
