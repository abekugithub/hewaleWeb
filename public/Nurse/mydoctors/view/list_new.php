<?php
/**
 * Created by PhpStorm.
 * User: S3L0RM
 * Date: 5/1/2018
 * Time: 5:33 PM
 */
$rs = $paging->paginate();
?>
<div class="main-content">
    <input id="new_visitcode" name="new_visitcode" value="<?php echo $new_visitcode; ?>" type="hidden" />
    <input id="patientcode" name="patientcode" value="<?php echo $patientcode; ?>" type="hidden" />
    <input type="hidden" name="canceldata" id="canceldata" />

    <div class="page-wrapper">
        <?php //$engine->msgBox($msg,$status); ?>
        <div class="page form">
            <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper">My Doctors</div>
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
            <?php
            $num = 1;
            if($paging->total_rows > 0 ){
                $page = (empty($page))? 1:$page;
                $num = (isset($page))? ($limit*($page-1))+1:1;
                while(!$rs->EOF){
                    $obj = $rs->FetchNextObject();
                    ?>
                    <div class="container-fluid">
                        <div class="row-fluid">
                            <div class="col-sm-3">
                                <div class="card">
                                    <img src="media/img/tip.png" alt="Avatar" style="width:100% !important; margin:0px !important;">
                                    <div class="btn-group pull-right">
                                        <!--                                    <button type="button" class="btn btn-info btn-square">Options</button>-->
                                        <button type="button" class="btn btn-default btn-square dropdown-toggle" data-toggle="dropdown" style="border: none;background: none;color: inherit;">
                                            <span class="fa fa-ellipsis-v "></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><button type="submit" class="startchat" onclick="document.getElementById('keys').value='';document.getElementById('viewpage').value='consult';document.getElementById('view').value='consulting';document.myform.submit();">View Doctor</button>
                                            </li>
                                            <li><button type="button" class="" onclick="document.getElementById('keys').value='';document.getElementById('viewpage').value='consult';document.getElementById('view').value='consulting';document.myform.submit();">Disengage Doctor</button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="container">
                                        <h4>
                                            <span style="margin-right: 1em">Name:</span> <b><?php echo $obj->NRQ_DOCTOR_NAM; ?></b>
                                        </h4>
                                        <h5><span style="margin-right: 1em">Specialty:</span> <?php echo $obj->NRQ_DOCTOR_SPECIALTY; ?></h5>
                                        <p>Ambulance Service</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    }
                }else{
                ?>
                <div class="container-fluid">
                    <div class="row-fluid">
                        <div class="col-sm-3">
                            <div class="card">
                                <img src="media/img/tip.png" alt="Avatar" style="width:100% !important; margin:0px !important;">
                                <div class="btn-group pull-right">
<!--                                    <button type="button" class="btn btn-info btn-square">Options</button>-->
                                    <button type="button" class="btn btn-default btn-square dropdown-toggle" data-toggle="dropdown" style="border: none;background: none;color: inherit;">
                                        <span class="fa fa-ellipsis-v "></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                            <li><button type="submit" class="startchat" onclick="document.getElementById('keys').value='';document.getElementById('viewpage').value='consult';document.getElementById('view').value='consulting';document.myform.submit();">View Doctor</button>
                                        </li>
                                        <li><button type="button" class="" onclick="document.getElementById('keys').value='';document.getElementById('viewpage').value='consult';document.getElementById('view').value='consulting';document.myform.submit();">Disengage Doctor</button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="container">
                                    <h4>
                                        <span style="margin-right: 1em">Name:</span> <b>John Doe</b>
                                    </h4>
                                    <h5><span style="margin-right: 1em">Specialty:</span> John Doe</h5>
                                    <p>Ambulance Service</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
        </div>

    </div>

</div>