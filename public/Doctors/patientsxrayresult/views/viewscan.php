<?php
 $linkview = 'index.php?pg='.md5('Doctors').'&amp;option='.md5('Consultation').'&uiid='.md5('1_pop').'&view=consulting&viewpage=consult&keys='.$consultcode.'&visitcode='.$visitcode.'&xrayid='.$xrayid;
?>
<div class="main-content">
    <div class="page-wrapper">

        <input type="hidden" class="form-control" id="" name="visitcode" value="<?php echo $visitcode; ?>" readonly>
		<input type="hidden" class="form-control" id="" name="patientnum" value="<?php echo $patientnum; ?>" readonly>
		<input type="hidden" class="form-control" id="" name="patient" value="<?php echo $patient; ?>" readonly>

        <div class="page form">
            <div class="moduletitle" style="padding-bottom: 1px">
                <div class="moduletitleupper">X-Ray Result for  <?php echo $patientname.' ['.$hewalenum.']';?>
                    <button type="submit" id="acceptLab" onclick="document.getElementById('view').value='labdetails';document.getElementById('viewpage').value='testdetails';document.getElementById('keys').value='<?php echo $keys; ?>';document.myform.submit();" class="btn btn-dark pull-right"><i class="fa fa-arrow-left"></i> Back </button>
                </div>
            </div>

            <?php $engine->msgBox($msg,$status); ?>

            <div class="col-sm-12 paddingclose personalinfo">
                <div class="col-sm-2">
                    <div class="id-photo">
                        <img src="<?php echo((!empty($patientphoto))?$photourl:'media/img/avatar.png');?>" alt="" id="prevphoto" style="width:100% !important; margin:0px !important;">
                    </div>
                </div>
                <div class="col-sm-10 paddingclose">
                    <div class="form-group">
                        <div class="col-sm-12 personalinfo-info">
                   <iframe width="900px" height="700px" src="<?php echo $printpath ;?>"></iframe>
                        </div>
                        
                        <div class="col-sm-12">
                        
                        <div class="col-sm-10">
                <div class="form-group">
                    <div class="col-sm-10">
                        <label for="comment">Analysis</label>
                        <textarea class="form-control" name="comment" id="comment" style="width:800px;"><?php echo $comment ?></textarea>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="btn-group pull-left">
                        <button type="button" class="btn btn-success btn-square" onclick="document.getElementById('view').value='';document.getElementById('viewpage').value='savexrayresult';document.getElementById('keys').value='<?php echo $xrayid; ?>';document.myform.submit();" style="margin-right: 1em">Save</button>
                        
                        <button class="btn btn-info" type="button" onclick="CallSmallerWindow('<?php echo $linkview ; ?>')" style="margin-right: 1em">Consulting Room</button>
                        
                        <button type="submit" id="acceptLab" onclick="document.getElementById('view').value='labdetails';document.getElementById('viewpage').value='';document.myform.submit();" class="btn btn-danger">Cancel </button>
                    </div>
                </div>
            </div>
                        
                        </div>
                    </div>
                </div>
                
                
            </div>

            <div class="col-sm-2"></div>


        </div>

    </div>

</div>