    <div class="main-content">

        <div class="page-wrapper">

            <div class="page form">
                <div class="moduletitle">
                    <div class="moduletitleupper">Map Services <?php if(!empty($keys)){?>for <?php echo $depname ; ?> department <?php } ?> </div>
                </div>
                <?php $engine->msgBox($msg,$status); ?>
                <div class="col-sm-12">
                <div class="form-group">
                      <div class="col-sm-6">
                            <label for="status">Select Department</label>

                            
                            <select class="form-control select2" name="depcode" id="depcode">
                                <option value="" >-- Select Department --</option>
                                <?php
                                while ($dept = $stmtdept->FetchNextObject()){?>
                                    <option value="<?php echo $dept->DEPT_CODE; ?>" <?php echo (($depcode == $dept->DEPT_CODE)?'selected':'') ?> >
                                        <?php echo $dept->DEPT_NAME; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                </div>        
                </div>
                
                  <div class="col-sm-12">
                        <div class="form-group">
                        <div class="col-sm-6">
                        
              </div></div></div>
              
                 <div class="col-sm-12">
                        <div class="form-group">
                        <div class="col-sm-6">
                   <label for="status">Select Services</label>   
              </div></div></div>
              
               <div class="col-sm-12">
                        <div class="form-group">
                        <div class="col-sm-6">
                        
              </div></div></div>
            
                    <div class="col-sm-12">
                        <div class="form-group">
                        <div class="col-sm-6"> 
                       
                        <?php 
						$stmtserv = $engine->getAllOfficialServices();
						while($objserv = $stmtserv->FetchNextObject()){
						 
					      $stmtsemap = $engine->getServiceMapDept($activeinstitution,$depcode,$objserv->SERV_CODE);
						  $objsemap = $stmtsemap->FetchNextObject();
						  $syscheckbox[$objserv->SERV_CODE] = $objsemap->ST_SERVICE;
						
						?>
                        <div class="col-sm-6">
                               
                                <label><input type="checkbox" id="servicecode" name="syscheckbox[<?php echo $objsubft->SERV_CODE ; ?> ]" value="<?php echo $objserv->SERV_CODE ;?>" autocomplete="off"  <?php echo (($objserv->SERV_CODE == $syscheckbox[$objserv->SERV_CODE])?'checked':'') ; ?> ></label>&nbsp;&nbsp; <label for="fname"><?php echo $objserv->SERV_NAME ;?></label>
                            </div>
                            
                       <?php } ?>

                        </div>
                
                 </div>
                    </div>

            <div class="btn-group">
                            <div class="col-sm-12">
                                 <button type="submit" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='savemapedit';document.myform.submit;" class="btn btn-info"><i class="fa fa-plus-circle"></i> Save </button>
                                <button type="submit" class="btn btn-danger" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit;">Cancel</button>
                     
                            </div>
                        </div>        

            </div>
        </div>
    </div>