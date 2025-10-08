<?php $rs = $paging->paginate();?>

<div class="main-content">

    <div class="page-wrapper">

        <!-- <div class="page-lable lblcolor-page">Table</div>-->
        <div class="page form">
            <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper">Pending Appointments</div>
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
                        <th>Full Name</th>
                        <th>Request Date</th>
                        <th>Request Reasons</th>
                        <th>Appointment Date</th>
                        <th>Appointment Time</th>
                        <th>Consultation Medium</th>
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
						   $linkview = 'index.php?pg='.md5('Doctors').'&amp;option='.md5('Consultation').'&uiid='.md5('1_pop').'&viewpage=historylist&view=historylist&keys='.$obj->REQU_PATIENTNUM;
                           if($obj->REQU_CONSULTTYPE == '1'){$medium = 'Text <i class="fa fa-comments-o" style="float:right;font-size:20px;color:red"></i>'; }elseif($obj->REQU_CONSULTTYPE == '2'){$medium = 'Audio <i class="fa fa-phone" style="float:right;font-size:20px;color:green"></i>';}elseif($obj->REQU_CONSULTTYPE == '3'){$medium = 'Video <i class="fa fa-file-video-o" style="float:right;font-size:20px;color:orange"></i>' ;}else{$medium = 'Text <i class="fa fa-comments-o" style="float:right;font-size:20px;color:red"></i>';}
                   echo '<tr>
                        <td>'.$num.'</td>
                        <td>'.$obj->REQU_PATIENTNUM.'</td>
                        <td>'.$obj->REQU_PATIENT_FULLNAME.'</td>
                        <td>'.date("d/m/Y", strtotime($obj->REQU_DATE)).'</td>
                        <td>'.$obj->REQU_REASONS.'</td>
                        <td>'.$obj->REQU_APPOINTDATE.'</td>
                        <td>'.$obj->REQU_APPOINTTIME.'</td>
                        <td>'.$medium.'</td>
						<td> 
						
						<div class="btn-group">
                                <button type="button" class="btn btn-info btn-square" dropdown-toggle" data-toggle="dropdown">Options <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="menu">
								
                                    <li><button type="button" onclick="if(confirm(\'You are about to confirm this service request.\n\n Note: This process cannot be reversed.\n \n Are you sure ?.\')){document.getElementById(\'view\').value=\'\';document.getElementById(\'keys\').value=\''.$obj->REQU_CODE.'\';document.getElementById(\'viewpage\').value=\'consult\';document.myform.submit();}else{return false ;}">Confirm</button></li>

                                    <li><button type="submit" data-toggle="modal" data-target="#addDesp" onclick="document.getElementById(\'view\').value=\'\';document.getElementById(\'keys\').value=\''.$obj->REQU_CODE.'\';document.getElementById(\'viewpage\').value=\'confirmbooking\';document.myform.submit; ">Re-Schedule</button></li>
									
									<li><button type="submit" onclick="CallSmallerWindow(\''.$linkview.'\')"> Medical History</button></li>
									
                                  
									 
									
                                </ul>
                            </div>
							
						</td>
                    </tr>';
					$num ++; }}
					?>
                </tbody>
            </table>
            
            <!--<li><button type="submit" onclick="document.getElementById(\'view\').value=\'patientdetails\';document.getElementById(\'keys\').value=\''.$obj->REQU_PATIENTNUM.'\';document.getElementById(\'viewpage\').value=\'patientdetails\';document.myform.submit();">Medical History</button></li>-->
            
        </div>

    </div>

</div>


<!--The modal below pops up the schedule window-->

<div id="addDesp" class="modal fade" role="dialog">
  <div class="modal-dialog"> 
    
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Schedule consultation Time</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
                            <div class="col-sm-8">
                                <label for="fname">Date:</label>
                               <!-- <input type="text" class="form-control" id="date" name="consultdate" value="<?php// echo $consultdate;?>" autocomplete="off" required> -->
                                <input class="form-control" id="date" name="startdate" placeholder="dd/mm/yyyy" type="text" required/>
                            </div>


<div class="input-group clockpicker">
                            <div class="col-sm-8">
                                <label for="time">Time:</label>
                                <input type="text" id="clockpicker" name="inputtime" class="form-control" value="<?php echo  $inputtime ;?>" required placeholder="09:30">
                            </div>
        </div>                    
                            
                          
                           
                        </div>
           
           
           <div class="form-group">
                          <div class="col-sm-8">
                          &nbsp;
                          <br />
                          </div>
                          
                         <div class="col-sm-8">
        <button type="button" class="btn btn-success btn-square" data-dismiss="modal" onclick="document.getElementById('viewpage').value='consult';document.myform.submit();">Save</button>
        <button type="button" class="btn btn-danger btn-square" data-dismiss="modal">Cancel</button>
                            </div> 
                           
                        </div>
                        
                        
      </div>
   
      <div class="modal-footer">
      
      </div>
    </div>
  </div>
</div>
<!--End of setting the schedule pop up-->

<script type="text/javascript">
$('.clockpicker').clockpicker()
	.find('input').change(function(){
		console.log(this.value);
	});
var input = $('#single-input').clockpicker({
	placement: 'bottom',
	align: 'left',
	autoclose: true,
	'default': 'now'
});

$('.clockpicker-with-callbacks').clockpicker({
		donetext: 'Done',
		init: function() { 
			console.log("colorpicker initiated");
		},
		beforeShow: function() {
			console.log("before show");
		},
		afterShow: function() {
			console.log("after show");
		},
		beforeHide: function() {
			console.log("before hide");
		},
		afterHide: function() {
			console.log("after hide");
		},
		beforeHourSelect: function() {
			console.log("before hour selected");
		},
		afterHourSelect: function() {
			console.log("after hour selected");
		},
		beforeDone: function() {
			console.log("before done");
		},
		afterDone: function() {
			console.log("after done");
		}
	})
	.find('input').change(function(){
		console.log(this.value);
	});

// Manually toggle to the minutes view
$('#check-minutes').click(function(e){
	// Have to stop propagation here
	e.stopPropagation();
	input.clockpicker('show')
			.clockpicker('toggleView', 'minutes');
});

</script>
