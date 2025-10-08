<?php
include('../../../../public/Doctors/consultingroom/validate.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
<link href="../../../../media/css/main.css" rel = "stylesheet" type = "text/css"/>

<script type="text/javascript" src="../../../../media/js/jquery.min.js"></script>
<script type="text/javascript" src="../../../../media/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../../../../media/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../../../../media/js/bootstrap-toggle.min.js"></script>

</head>

<body>
<form action="consultinglist.php" method="POST">
<style>
    .rowdanger {
        background-color: #97181B4D
    }

    .rowwarning {
        background-color: #EBECB9
    }
</style>
<div class="main-content">
    <input id="new_visitcode" name="new_visitcode" value="<?php echo $new_visitcode; ?>" type="hidden" />
    <input id="patientcode" name="patientcode" value="<?php echo $patientcode; ?>" type="hidden" />
    <input type="hidden" name="canceldata" id="canceldata" />

    <div class="page-wrapper">

        <?php //$engine->msgBox($msg,$status); ?>

        <!-- <div class="page-lable lblcolor-page">Table</div>-->
        <div class="page form">
            <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper"><?php echo $objfacdetails->FACI_NAME.' (<i>'.$objfacdetails->FACI_PHONENUM.'</i>) :: '.$roomname ;?>
                
                </div>

            </div>
            
            <div class="pagination-tab">
                <div class="table-title row">
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
                    <div class="5">
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
                    <th>Request Date</th>
                    <th>Patient Name</th>
                    <th>Hewale Number</th>
                    <th>Status</th>
                    <th>Action</th>
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
                        $consperiod = $patientCls->getConsultPeriod($obj->CONS_CODE);
                        //$linkview = 'index.php?pg='.md5('Doctors').'&amp;option='.md5('Consultation').'&uiid='.md5('1_pop').'&viewpage=historylist&view=historylist&keys='.$obj->CONS_PATIENTNUM;

                        $linkview = 'historylist.php?viewpage=historylist&keys='.$obj->CONS_PATIENTNUM;

                        $linkviewrequst =  'index.php?pg='.md5('Doctors').'&amp;option='.md5('Consultation').'&uiid='.md5('1_pop').'&viewpage=requestreason&view=requestreason&keys='.$obj->CONS_PATIENTNUM;
                        //$requestdetails = $patientCls->getServRequestInfo($obj->CONS_VISITCODE);
                        

                        echo '<tr>
                        <td>'.$num++.'</td>
                        <td>'.date("d/m/Y",strtotime($obj->CONS_DATE)).'</td>
                        <td>'.$obj->CONS_PATIENTNAME.'</td>
                        <td>'.$obj->CONS_PATIENTNUM.'</td>
						<td>'.(($obj->CONS_STATUS == 1)?(($obj->CONS_SERVCODE == 'SER0004')?'Awaiting Vitals':'Pending'):(($obj->CONS_STATUS == 2)?'Incomplete':'')).'</td>
                        <td><div class="btn-group">
                                <button type="button" class="btn btn-info btn-square" dropdown-toggle" data-toggle="dropdown">Options <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="menu">';
								    echo '
									<li>
									<a href="consultingdetails.php?keys='.$obj->CONS_CODE.'&patientcode='.md5($obj->CONS_PATIENTNUM).'&new_visitcode='.$obj->CONS_VISITCODE.'&viewpage=consult">Consulting Room</a>
                                    </li>';

									 echo '<li><a href="#" onclick="CallSmallerWindow('.$linkview.')" ><button type="submit" onclick="CallSmallerWindow(\''.$linkview.'\')"> Medical History</button></a></li>
                                    
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

//<!-- Modal -->
                
                    <div id="addDesp" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                    
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Cancellation Reason</h4>
                          </div>
                          <div class="modal-body ">
                            <p><textarea class="form-control" name="cancel" id="cancel"></textarea> </p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-success btn-square" id="save" data-dismiss="modal"  >Save</button>
                            <button type="button" class="btn btn-info btn-square" data-dismiss="modal">Close</button>
                            
                          </div>
                        </div>
                    
                      </div>
                    </div>


<script>
function CallSmallerWindow(linkview) {
//var randomnumber = Math.floor((Math.random()*100)+1); 
 var winpop =  window.open(linkview,linkview,"toolbar=no,scrollbars=yes,resizable=yes,top=160,left=245,channelmode=1,location=0,menubar=0,status=no,titlebar=0,toolbar=0,modal=1,width=1130,height=550");
 
}
</script>

</form>
</body>

</html>