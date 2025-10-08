<?php
$rs = $paging->paginate();
?>
<style>
    .rowdanger {
        background-color: #97181B4D
    }

    .rowwarning {
        background-color: #EBECB9
    }
</style>
<div class="main-content">
    <input id="sendercode" name="sendercode" value="<?php echo $usrcode; ?>" type="hidden" />
    <input type="hidden" name="canceldata" id="canceldata" />

    <div class="page-wrapper">


        <?php //$engine->msgBox($msg,$status); ?>

        <!-- <div class="page-lable lblcolor-page">Table</div>-->
        <div class="page form">
            <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper">Direct Call
                
                </div>

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
                            <input type="text" tabindex="1" value="<?php echo $fdsearch; ?>" class="form-control square-input" name="fdsearch" placeholder="Search..."
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

                    </div>
                </div>
            </div>
              <?php $engine->msgBox($msg,$status); ?>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Doctor Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th width="170">Action</th>
                </tr>
                </thead>
                <tbody class="tbody">
                <?php
                $num = 1;
                if($paging->total_rows > 0 ){
                    $page = (empty($page))? 1:$page;
                    $num = (isset($page))? ($limit*($page-1))+1:1;
                    while(!$rs->EOF){
                        $obj = $rs->FetchNextObject();
                      

                        $linkview2 = 'index.php?pg='.md5('Doctors').'&amp;option='.md5('Direct Call').'&uiid='.md5('1_pop').'&viewpage=calling&view=callroom&keys='.$obj->USR_USERID;

                        echo '<tr >
                        <td>'.$num++.'</td>
                        <td> Dr. '.$obj->USR_OTHERNAME.' '.$obj->USR_SURNAME.'</td>
                        <td>'.$obj->USR_PHONENO.'</td>
                        <td>'.$obj->USR_EMAIL.'</td>
                        <td>'.(($obj->USR_STATUS == 1)?'Active':'Inactive').'</td>
                        <td><div class="btn-group">
                                <button type="button" onclick="CallVideoWindow(\''.$linkview2.'\')" class="btn btn-info btn-square">Call Room</button>
                               
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
