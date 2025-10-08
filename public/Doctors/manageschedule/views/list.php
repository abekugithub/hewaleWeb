<?php $rs = $paging->paginate();?>
<style type="text/css">
    .demo {
        position: relative;
    }

    .demo i {
        position: absolute;
        bottom: 10px;
        right: 24px;
        top: auto;
        cursor: pointer;
    }
</style>
<div class="main-content">
    <div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Manage Schedule &amp; Appointment</div>
            </div>
            <div class="col-sm-6">

                <div class="form-group">

                    <div class="col-sm-12" col-md-offset-2 demo>
                        <label for="emcontact">Select Date</label>
                        <input type="text" class="form-control" id="config-demo" name="emcontact" value="<?php echo $emcontact ;?>" autocomplete="off">
                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>

                    </div>
                    <div class="col-sm-12">
                        <label for="email">Reasons</label>
                        <input type="text" class="form-control" id="address" name="address" value="<?php echo $address;?>" autocomplete="off">
                    </div>

                </div>

                <div class="btn-group">
                    <div class="col-sm-12">
                        <button type="submit" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='saveuser';document.myform.submit;"
                            class="btn btn-info"><i class="fa fa-plus-circle"></i> Save </button>
                        <button type="submit" class="btn btn-danger" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='';document.myform.submit;">Cancel</button>
                    </div>
                </div>
            </div>

            <div class="col-sm-6  ">
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">Coming Appointment</legend>
                    <div class="form-group">
                        <!--Content goes here-->
                    </div>
                </fieldset>
            </div>

        </div>
    </div>



    <div class="page-wrapper">


        <?php $engine->msgBox($msg,$status); ?>

        <!-- <div class="page-lable lblcolor-page">Table</div>-->
        <div class="page form">
            <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper">Pending Appointment</div>
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
                    <div class="col-sm-5">
                        <div class="input-group">
                            <input type="text" tabindex="1" value="<?php echo $fdsearch; ?>" class="form-control square-input" name="fdsearch" placeholder="Enter Category to Search"/>
                            <span class="input-group-btn">
                                <button type="submit" onclick="document.getElementById('action_search').value='search';document.getElementById('viewpage').value='';document.myform.submit;" class="btn btn-default btn-gyn-search"> <i class="fa fa-search"></i> </button>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group">
                            <button type="submit" onclick="document.getElementById('action_search').value='';document.getElementById('view').value='';
                        	        document.getElementById('viewpage').value='reset';document.myform.submit;" class="btn btn-success btn-square"> <i class="fa fa-refresh"></i> </button>
                        </div>
                    </div>
                    <div class="pagination-right">
                        <!--<button type="submit" onclick="document.getElementById('view').value='adduser';document.getElementById('viewpage').value='';document.myform.submit;" class="btn btn-info"><i class="fa fa-plus-circle"></i> Add User </button> -->


                    </div>
                </div>
            </div>




            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Patient No.</th>
                        <th>First Name</th>
                        <th>Other Name</th>
                        <th>Phone No.</th>
                        <th>Booking Date</th>
                        <th>Appointment Date</th>
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
						   $usergroup = $engine->geAllUsersGroup($obj->USR_USERID);
                    
                   echo '<tr>
                        <td>'.$num.'</td>
                        <td>'.$obj->USR_SURNAME.'</td>
                        <td>'.$obj->USR_OTHERNAME.'</td>
                        <td>'.$obj->USR_USERNAME.'</td>
                        <td>'.$obj->USR_EMAIL.'</td>
                        <td>'.$usergroup.'</td>
						<td>'.(($obj->USR_STATUS == 1)?'Active':(($obj->USR_STATUS == 0)?'Disable':'Locked')).'</td>
						<td> 
						
						<div class="btn-group">
                                <button type="button" class="btn btn-info btn-square" dropdown-toggle" data-toggle="dropdown">Options <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><button type="submit" onclick="document.getElementById(\'view\').value=\'edituser\';document.getElementById(\'keys\').value=\''.$obj->USR_USERID.'\';document.getElementById(\'viewpage\').value=\'edituser\';document.myform.submit;">Accept</button></li>
                                    <li><button type="submit" onclick="document.getElementById(\'view\').value=\'resetpwd\';document.getElementById(\'keys\').value=\''.$obj->USR_USERID.'\';document.getElementById(\'viewpage\').value=\'\';document.myform.submit;">Reject</a></button>
                                </ul>
                            </div>
							
						</td>
                    </tr>';
					$num ++; }}
					?>
                </tbody>
            </table>
        </div>

    </div>

</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#config-demo').daterangepicker();

        // updateConfig();

        // function updateConfig() {
        //     var options = {};

        //     $('#config-demo').daterangepicker(options, function (start, end, label) {
        //         console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        //     });

        // }

    });
</script>