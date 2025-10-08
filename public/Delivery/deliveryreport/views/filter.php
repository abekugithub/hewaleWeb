<?php

?>

<div class="main-content">
    <div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Filter - Delivery Report
                    <span class="pull-right">
                        <button class="form-tools" onclick="document.getElementById('view').value='';document.myform.submit;" style="font-size:18px; padding-top:-10px;">
                            <i class="fa fa-clone"></i>
                        </button>
                        <button class="form-tools" onclick="document.getElementById('view').value='';document.myform.submit;" style="font-size:25px; padding-top:-10px;">&times;</button>
                    </span>
                </div>
            </div>
            <form action="" method="post" enctype="multipart/form-data" name="myform">
              <!-- <input type="hidden" name="agent_name" value="" id="views" class="form-control" />
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
                <?php if ($courieragent=='No'){?>
                <div class="col-sm-5">
                    <label for="grkeys">Agent :</label>
                    <select id="agent_name" name="agent_name" class="form-control select2" tabindex="-1" aria-hidden="true">
                    <option value="">--All Agents--</option>
					<?php if($agent_list->RecordCount()>0){
                    while($obj=$agent_list->FetchNextObject()){?>
                    
                    <option value =<?php echo "$obj->COU_CODE|$obj->COU_NAME";?>><?php echo $obj->COU_NAME;?></option>
                    
                 <?php    }
                    }else{?>
                    	<option value ="">--No Agent--</option>
                    <?php }?>
                    </select>
                    
                </div>
                <?php }?>
                </br>
                
                                <div class="col-sm-5">
                    <button type="submit" class="btn btn-success" id="report" onclick="document.getElementById('view').value='report';document.getElementById('viewpage').value='report';document.myform.submit();">Submit</button>
                    <button type="submit" class="btn btn-danger">Cancel</button>
                   
                </div>
                </div>
            </div>
            
            

            <div class="btn-group pull-right">

            </div>

        </div>
    </div>

</div>
