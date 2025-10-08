<?php $rs = $paging->paginate();?>

<div class="main-content">

    <div class="page-wrapper">

        <!-- <div class="page-lable lblcolor-page">Table</div>-->
        <div class="page form">
            <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper">Patients Lab Result</div>
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
                        <input id="visitcode" name="visitcode" value="<?php echo $visitcode; ?>" type="hidden" />
    <input id="patientcode" name="patientcode" value="<?php echo $patientcode; ?>" type="hidden" />
                            <input type="text" tabindex="1" value="<?php echo $fdsearch; ?>" class="form-control square-input" name="fdsearch" placeholder="Search..."/>
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
                        <!-- Content goes here -->
                    </div>
                </div>
            </div>


            <table class="table table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Patient No.</th>
                    <th>Patient Name</th>
                    <th>Date</th>
                    <th>Lab Name</th>
                    <th>Lab Contact</th>
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
					/*
						$decrypid = $obj->LTM_ENCRYPKEY;
				if($decrypid != $activekey){
				$saltencrypt = $encryptkeys[$decrypid]['salt'];
                $pepperdecrypt =  $encryptkeys[$decrypid]['pepper'];
				$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);
				}
                */
             
				$stmt1 = $sql->Execute($sql->Prepare("SELECT * FROM hms_consultation  WHERE CONS_VISITCODE = " . $sql->Param('a') . " ORDER BY CONS_CODE DESC LIMIT 1 "), array($obj->LTM_VISITCODE));
				$obj1=$stmt1->FetchNextObject();
				
                  $linkview = 'index.php?pg='.md5('Doctors').'&amp;option='.md5('Consultation').'&uiid='.md5('1_pop').'&view=consulting&viewpage=consult&keys='.$obj1->CONS_CODE.'&visitcode='.$obj->LTM_VISITCODE.'&labid='.$obj->LTM_ID;
        

                  $linkview2 = "public/Doctors/consultingroom/views/consultingdetails.php?keys=".$obj1->CONS_CODE."&patientcode=".md5($obj1->CONS_PATIENTNUM)."&new_visitcode=".$obj->LTM_VISITCODE."&viewpage=consult";
                		
                        echo '<tr>
                        <td>'.$num.'</td>
                        <td>'.$obj->LTM_PATIENTNUM.'</td>
                        <td>'.$obj->LTM_PATIENTNAME.'</td>
                        <td>'.$obj->LTM_DATE.'</td>
                        <td>'.$obj->LTM_LABNAME.'</td>
                        <td>'.$engine->faciPhoneNum($obj->LTM_LABCODE).'</td>
						<td>'.(($obj->LTM_STATUS !="7")?'Pending':'<button id="view" name="view" class="btn btn-info" type="button" onclick="/*window.open(\'localhost/socialhealth/media/uploaded/\');*/document.getElementById(\'keys\').value=\''.$obj->LTM_VISITCODE.'\';document.getElementById(\'view\').value=\'details\';document.getElementById(\'viewpage\').value=\'details\';document.myform.submit();"> Details</button>').'
			
                        '.(($usertype == 7 )?(($obj->LTM_STATUS !="7")?'':'<button class="btn btn-info" type="submit" onclick="CallSmallerWindow(\''.$linkview2.'\')">Consulting Room</button>'):(($obj->LTM_STATUS !="7")?'':'<button class="btn btn-info" type="submit" onclick="CallSmallerWindow(\''.$linkview.'\')">Consulting Room</button>')).'			
		</td> 
                    </tr>';
                        $num ++; }}
						
						//'.(($obj1->CONS_CODE =''&& $obj->LT_STATUS !="7")?'<button class="btn btn-info" type="submit" onclick="CallSmallerWindow(\''.$linkview.'\')">Consulting Room</button>':'' ).'
				//(($obj->LT_STATUS !="7")?'Pending':'<button id="view" name="view" class="btn btn-info" type="button" onclick="" data-toggle="modal" data-target="#addManagement">Download</button>').'
		//\''.SPATH_MEDIA.'uploaded/labresult/'.$obj->LT_LABRESULT.'\'
		//http://localhost/socialhealth/media/uploaded/labresult/view.docx
                ?>
                </tbody>
            </table>
        </div>

		</td> 
    </div>

</div>
<iframe id="invisible" style="display:none;"></iframe>
