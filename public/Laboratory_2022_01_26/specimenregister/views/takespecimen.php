
    
<?php $engine->msgBox($msg,$status); ?>

<script type="text/javascript" src="media/js/jquery-ui.min.js"></script>
<form name="myform" id="myform" method="post" action="#">
    <input id="view" name="view" value="" type="hidden" />
    <input id="viewpage" name="viewpage" value="" type="hidden" />
    <input id="keys" name="keys" value="" type="hidden" />
    <input id="micro_time" name="micro_time" value="<?php echo md5(microtime()); ?>" type="hidden" />
	
	<input id="patient" name="patient" value="<?php echo $patient; ?>" type="hidden" />
	<input id="patientnum" name="patientnum" value="<?php echo $patientnum; ?>" type="hidden" />
	<input id="patientdate" name="patientdate" value="<?php echo $patientdate; ?>" type="hidden" />
	<input id="visitcode" name="visitcode" value="<?php echo $visitcode; ?>" type="hidden" />

<div class="main-content">
    <div class="page-wrapper">
        <div class="page form">
            <div class="moduletitle">
                <div class="moduletitleupper">Consultation <span class="pull-right">
                    <button onclick="document.getElementById('view').value='';document.myform.submit;">&times;</button>
                    </span>
                </div>
            </div>
            <p id="msg" class="alert alert-danger" hidden></p>
            <div class="col-sm-2">
                <div class="id-photo">
                    <img src="<?php echo(($photourl))?$photourl:'media/img/avatar.png';?>" alt="" id="prevphoto" style="width:100% !important; margin:0px !important;">
                </div>
				<div class="form-group">
                    <div class="col-sm-12 client-info">
					<input type="hidden" class="form-control" id="patientnum" name="patientnum" value = "<?php echo $patientnum; ?>" >
					<input type="hidden" class="form-control" id="visitcode" name="visitcode" value = "<?php echo $visitcode; ?>" >
                    <input type="hidden" class="form-control" id="patient" name="patient" value = "<?php echo $patient; ?>" >
                    
					Patient Details:
						<br />
						<?php echo $patient; ?>
						<br />
						<?php echo $patientnum; ?>
                          <br />
						<?php echo $visitcode; ?>
                    </div>
                </div>
            </div>
			
			<div class="col-sm-10">
                
			<div class="form-group">
                    <div class="col-sm-4 client-vitals-opt">
					<label class="control-label" for="fname">Chat</label>
                    <div class="col-sm-6 required">
                        
                        
                    </div>
                   
                    </div>
					
				<div class="col-sm-8 client-vitals-opt">
                    <div class="col-sm-12 required">
                        
						<div class="page-wrapper">
        <ul class="nav nav-tabs">
            
            <li class="active"><a data-toggle="tab" href="#complains">Complains</a></li>
            <li><a data-toggle="tab" href="#labs">Lab Request</a></li>
			<li><a data-toggle="tab" href="#diagnosis">Diagnosis</a></li>
			<li><a data-toggle="tab" href="#presciption">Prescription</a></li>
			
        </ul>
        <div class="page form">
            <div class="tab-content">
                <div id="complains" class="tab-pane fade in active">
                    
                <div class="form-group">
				

                <div class="col-sm-9 required">
				    <input type="hidden" id="copmlaincode" name="copmlaincode">
                    <label class="control-label" for="copmlainner">Complains</label>
                    <input type="text" class="form-control" id="copmlainner" name="copmlainner">
                </div>
				<div class="col-sm-3 required">
                </div>
                     
                
            </div>
                </div>
				
                <div id="labs" class="tab-pane fade">
                    
                <div class="controls controls-row">
				<div class="control-group span4">
              <label class="control-label">Test:</label>
              <div class="controls">
			<select name="test" id="test" class="form-control" tabindex="2"><option value="<?php echo $test; ?>"> -- Select Test --</option>
				<?php while($objdpt = $stmttestlov->FetchNextObject()){  ?>
				<option value="<?php echo $objdpt->LTT_CODE.'@@@'.$objdpt->LTT_NAME.'@@@'.$objdpt->LTT_DISCIPLINE.'@@@'.$objdpt->LTT_DISCIPLINENAME;?>" <?php echo (($objdpt->LTT_CODE == $test)?'selected':'' )?> ><?php echo $objdpt->LTT_NAME ;?></option>
				<?php } ?> 

			</select>
              </div>
			  
			  <div class="control-group span4">
              <label class="control-label">Clinical Remark:</label>
              <div class="controls">
			  
			  <textarea name= 'crmk'></textarea>
			
              </div>
            </div>
            </div>
            </div>
			 </div>
				
				
                <div id="diagnosis" class="tab-pane fade">
                     <div class="controls controls-row">
				<div class="control-group span6">
              <label class="control-label">Diagnosis:</label>
              <div class="controls">
			<select name="dia" id="dia" class="form-control" tabindex="2"><option value="<?php echo $dia; ?>"> -- Select Test --</option>
				<?php while($objdpt = $stmtdiagnosislov->FetchNextObject()){  ?>
				<option value="<?php echo $objdpt->DIS_CODE.'@@@'.$objdpt->DIS_NAME ; ?>" <?php echo (($objdpt->DIS_CODE == $dia)?'selected':'' )?> ><?php echo $objdpt->DIS_NAME ;?></option>
				<?php } ?> 

			</select>
              </div>
            </div>
            </div>
			 <div class="control-group span4">
              <label class="control-label"> Remark:</label>
              <div class="controls">
			  
			  <textarea name= 'drmk'></textarea>
			
              </div>
            </div>
                </div>
				 <div id="presciption" class="tab-pane fade">
                    <div class="controls controls-row">
				<div class="control-group span4">
              <label class="control-label">Prescription:</label>
              <div class="controls">
			<select name="drug" id="drug" class="form-control" tabindex="2"><option value="<?php echo $drug; ?>"> -- Select Drugs --</option>
				<?php while($objdpt = $stmtdrugslov->FetchNextObject()){  ?>
				<option value="<?php echo $objdpt->DR_CODE.'@@@'.$objdpt->DR_NAME.'@@@'.$objdpt->DR_DOSAGE.'@@@'.$objdpt->DR_DOSAGENAME ;?>" <?php echo (($objdpt->DR_CODE == $drug)?'selected':'' )?> ><?php echo $objdpt->DR_NAME ;?></option>
				<?php } ?> 

			</select>
              </div>
            </div>
			</div>
			<div class="col-sm-4">
                        <label>Days</label>
                        <input type="numbers" class="form-control" id="Days" name="days" placeholder="Days" >
                    </div>
					<div class="col-sm-4">
                        <label>Frequency</label>
                        <input type="numbers" class="form-control" id="Frequency" name="frequency" placeholder="Frequency" >
                    </div>
			<div class="col-sm-4">
                        <label>Times</label>
                        <input type="numbers" class="form-control" id="Times" name="times" placeholder="Times" >
                    </div>
            </div>
                </div>
				</div>
            
					<button type="submit" onclick="document.getElementById('viewpage').value='savecomplain';document.myform.submit();" class="btn btn-info"><i class="fa fa-plus-circle"></i> Submit</button>
            </div>
			</div>
</div>
</div>
</div>
</div>
</div>
</div>			
					  
                       


<script>
    $(document).ready(function () {
        var max_fields = 5; //maximum input boxes allowed
        var wrapper = $(".input_fields_wrap"); //Fields wrapper
        var add_button = $(".add_field_button"); //Add button ID

        var x = 0; //initlal text box count
        $(add_button).click(function (e) { //on add input button click
            e.preventDefault();

            if (x < max_fields) { //max input box allowed
                x++; //text box increment
                $(wrapper).append('<div class="col-sm-12" id="main_' + x +
                    '">    <input type = "hidden" class = "form-control" id = "memid' +
                    x +
                    '" name = "trans[memid][]"/><label>Member Name</label><input type = "text" class = "form-control" id = "titname' +
                    x +
                    '" name = "memname" placeholder = "Member Name" required></div><div class="col-sm-4"><label>Amount</label><input type = "text" class = "form-control" id = "titamount" name = "trans[tranamount][]" placeholder = "Amount" requied></div><div class="col-sm-1 gyn-add"><a class="btn btn-gyn-add square" onClick="remove_cont(' +
                    x +
                    ');"><i class="fa fa-close"></i></a></div><div class="col-sm-10"><label>Narration</label><textarea type = "text" class = "form-control" id = "narration" name = "trans[narration][]" placeholder = "Narration"></textarea></div></div>'
                ); //add input box
                adddata(x);
            }
        });
    });


    function remove_cont(x) {
        $('#main_' + x).remove();
        x--;
    };
</script>

<script>
        $("#copmlainner").autocomplete({
            source: 'public/Doctors/consulatationpp/views/fetch.php',
            select: function (event, ui) {
                $("#copmlainner").val(ui.item.label);
                $("#copmlaincode").val(ui.item.value);
                return false;
            },

        });
</script>
