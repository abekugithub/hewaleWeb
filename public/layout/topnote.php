<div class="content-nav">
            <span class="left">
                <b class="mnavi">
                    <span id="mopen" onclick="openNav()">&#9776;</span>
                    <span id="mclose" onclick="closeNav()" hidden>&times;</span>
                </b>
                <b class="logo-txt"><?php echo $appname;?></b>
            </span>
<span><b>Hewale</b> <info><?php if($actordetails->USR_TYPE == 7){

}else{?>[ <?php echo $objfac->FACI_NAME; ?> ]<?php } ?></info></span>
            <span class="content-nav-right">
            <?php 
            if( $actordetails->USR_TYPE == 2 ){?>
                        <label class="checkbox-inline boxie">
                            <input type="checkbox" onChange="setOnline()"  <?php echo (($actordetails->USR_ONLINE_STATUS == 1)?'checked':'') ?> data-toggle="toggle" data-size="mini" data-onstyle="success" data-offstyle="danger" data-on="Online" data-off="Offline" data-style="android">
                        </label>
            <?php }elseif($actordetails->USR_TYPE == 7){  ?>
                 <!--   <label class="checkbox-inline boxie" style="margin-top:-10px">  -->

                    <?php
                    /* $usrcode = $engine->getActorCode();
                     $objusr = $engine->getActorDetails();
                    
                     $stmtrp = $doctors->getDocRoom($objusr->USR_FACICODE,$usrcode);
               
                     if( $stmtrp->RecordCount() == 0){ 
                    ?>
                       <select name="roomid" id="roomid" style="height:36px;border:1px solid #ddd;">
                          <option value='0'>Select Room</option>
                          <?php
                         
                          $stmtr = $doctors->getDocAvailRoom($objusr->USR_FACICODE);
                          if($stmtr->RecordCount() > 0){ 
                          while($objr = $stmtr->FetchNextObject()){
                         
                           echo '<option value='.$objr->CONSROOM_ID.' '.(($objr->CONSROOM_ID == $roomid)?'selected="selected"':'').' >'.$objr->CONSROOM_NAME.'</option>';
                         }} ?>
                       </select>

                       <button onClick="setRoomOn()" class="btn btn-success btn-square">Open Room</button>
                    <?php }else{ ?>
                        <button onClick="setRoomOff()" class="btn btn-danger btn-square">Close Room</button>
                    <?php } */?>  
                             
                  <!--  </label> -->
            <?php }?>
                        <a id="userinfo" href="#"><i class="fa fa-user"></i> <?php 
						
						$docspeciality = $doctors->getDoctorSpeciality($usrcode); 
                        $userrole = $engine->getUserRole();						
					
						echo ucwords($engine->getActorName()).' [ '.(!empty($userrole)?$userrole:ucwords(strtolower($docspeciality))).' ]';
						?></a>
                      
                      <a href="#" class="logout" id="logout"><i class="fa fa-lock"></i> <span>Logout</span></a>
            </span>
</div>
<?php 
 include('model/js.php');
?>
<script>
    document.querySelector('a.logout').onclick = function(e){
        swal({
            title: "Warning",
            text: "Are you sure you want to logout?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '',
            confirmButtonText: "Yes, Logout!",
            closeOnConfirm: false
        }, function(){
            window.location.href = 'index.php?action=logout';
        });
    }
</script>