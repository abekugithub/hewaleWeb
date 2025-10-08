<script type="text/javascript" src="media/js/jquery-ui.min.js"></script>

    <input id="consultcode" name="consultcode" value="<?php echo $consultcode; ?>" type="hidden" />
    <input id="patientname" name="patientname" value="<?php echo $patientname; ?>" type="hidden" />
    <input id="patientnum" name="patientnum" value="<?php echo $patientnum; ?>" type="hidden" />
    <input id="patientdate" name="patientdate" value="<?php echo $patientdate; ?>" type="hidden" />
    <input id="visitcode" name="visitcode" value="<?php echo $visitcode; ?>" type="hidden" />
    <input id="patientcode" name="patientcode" value="<?php echo $patientcode; ?>" type="hidden" />

<div class="main-content">
  <div class="page-wrapper" style="width:1000px;  margin-left: auto;">
    <div class="page form col-sm-8">
      <div class="moduletitle " style="padding-bottom:0 !important">
        <div class="moduletitleupper" style="font-size:17px; font-weight:500;">Quick Consultation for <?php echo  $patientname ;?> [ <?php echo  $patientnum ;?>]    
        <!--  <span class="timer timerwell2"></span>-->
        
        <span class="pull-right">
      <button type="button"  class="btn btn-danger" onClick="if (confirm('Are you sure you want to  end session with the patient?')){document.getElementById('viewpage').value='endsession';document.getElementById('view').value='';document.myform.submit();}"><i class="fa fa-check"></i> End Session </button>  
          <button type="button"  class="btn btn-dark" onclick="document.getElementById('viewpage').value='';document.getElementById('view').value='';document.myform.submit();"><i class="fa fa-arrow-left"></i> Back </button> 
          </span> </div>
      </div>
      <p id="msg" class="alert alert-danger" hidden></p>
      <div class="col-sm-4">
        <div class="id-photo"> <img src="<?php echo(!empty($photourl))?$photourl:'media/img/avatar.png';?>" alt="" id="prevphoto" style="width:100% !important; margin:0px !important;"> </div>
        <div class="form-group">
          <div class="col-sm-12 client-info">
            <input type="hidden" class="form-control" id="patientnum" name="patientnum" value="<?php echo $patientnum; ?>">
            <input type="hidden" class="form-control" id="visitcode" name="visitcode" value="<?php echo $visitcode; ?>">
            <input type="hidden" class="form-control" id="patient" name="patient" value="<?php echo $patient; ?>">
            <input type="hidden" class="form-control" id="easyrtcid" name="easyrtcid" value="<?php echo $easyrtcid ;?>">
           
            
            </div>
          
          <!--Camera starts here-->
         
          
          <!--Camera ends here--> 
        </div>
      </div>
      <div class="col-sm-8">
        <div class="form-group">
     
          <div class="col-sm-12">
            <div class="form-group">
              <div class="col-sm-12 chatheadexp">
                <div class="innerchatwrap">
                  <div class="onlineheadertop">
                    <div align="right"> <span class="chatawe">
                      <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#chat"><i class="fa fa-comment" aria-hidden="true"></i></a></li>
                     
                      </ul>
                      </span> </div>
                    
                    <!--<label class="control-label" for="fname">Chat</label>--> 
                  </div>
                  <div class="col-sm-6 required"> </div>
                </div>
                <!--End innerchatwrap--> 
                
              </div>
             <div id="chat" class="tab-pane fade in active">
                <div class="col-sm-12 chatarea" id="chatareaindoc">
                 <div id="speech-bubble">
                  <?php 
					  if($msgdetails){
					  while($obj = $msgdetails->FetchNextObject()){?>
                  <?php if($obj->CHT_SENDER_CODE == $usrcode){ ?>
                  <div class="speech-bubble-rt">
                    <div class="speech-bubble-rt speech-bubble-right" id="conversation2"> <?php echo $encaes->decrypt($obj->CHT_MSG) ;?><div class="formatchatdate"><?php echo date("d M Y H:i",strtotime($obj->CHT_INPUTEDDATED)) ;?> </div> </div>
                  </div>
                  <?php }else{ ?>
                  <div class="speech-bubble-lt">
                 <div class="speech-bubble-lt speech-bubble-left" id="conversation"> <?php echo $encaes->decrypt($obj->CHT_MSG) ;?><div class="formatchatdate"><?php echo date("d M Y H:i",strtotime($obj->CHT_INPUTEDDATED)) ;?> </div> </div>
                  </div>
                  <?php } ?>
                  <?php } }?>
                  </div>
                  <input type="hidden" name="sendercode" id="sendercode" value="<?php echo $usrcode; ?>">
                  <input type="hidden" id="rcvchat" name="rcvchat">
                </div>
                <div class="col-sm-12 chattextarea">
                  <textarea name="chatmsg" id="chatmsg" class="chatmsg chatmsgcount" cols="" placeholder="Type message..." maxlength="230" ></textarea>
                  <!--<button type="button" ><i class="fa fa-send"></i></button>-->
                  
                <!--  <div id="otherClients"  onClick="sendStuffWS('MK0bsxx1NRvbTChC')" > <i class="fa fa-send"></i> </div>-->
                <?php if(!empty($easyrtcid)){?>
               <button type="button" id="otherClients" class="submitchat" onClick="geteasyrtcid()"><i class="fa fa-send"></i></button>
                <?php } ?>

                <span class="characters-count"><digit>0 </digit> / 230 
                
                </div>
              </div> 
           
            </div>
            
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

        <div id="sendMessageArea">
          <div id="iam" style="display:none">Obtaining ID...</div>
         <!-- <textarea id="sendMessageText"></textarea>-->
          <!--<div id="otherClients"></div>-->
    <!-- <div id="otherClients" class="btn btn-info myspecialform" onClick="sendStuffWS('PUGls1Xt5qUtRnQG')" style="width:180px; height:30px; padding-top:10px; padding-bottom:20px !important; color:#fff !important; font-size:15px; font-weight:bold;"> Send message</div> -->
           
        </div>
       <!-- <div id="receiveMessageArea">
          Received Messages:
         <div id="conversation"></div> 
        </div>-->

<!-- <input type="hidden" id="mytemproom" value="<?php //echo $usrcode.$patientcode ;?>"> -->

<!--Start instant messaging chat-->  
<script type="text/javascript">
     $( document ).ready(function() {
  easyrtc.setSocketUrl("https://orconsvideo.com:8443");
  easyrtc.setPeerListener(addToConversation);
 // easyrtc.setRoomOccupantListener(convertListToButtons);
  easyrtc.connect("easyrtc.kasahealth", loginSuccess, loginFailure);    
   
	  easyrtc.setDisconnectListener(function(){
        /* easyrtc.showError("SYSTEM-ERROR", "Disconnected. You will be automatically reconnected when your internet connection is stable. Click Okay to continue"); */
	 easyrtc.setSocketUrl("https://orconsvideo.com:8443");
         easyrtc.setPeerListener(addToConversation);
         easyrtc.connect("easyrtc.kasahealth", loginSuccess, loginFailure);
       }); 
	 
	 	  easyrtc.setOnError( function(errorObject){
			  //alert(errorObject.errorText);
                          console.log(errorObject.errorText);
            //document.getElementById("errMessageDiv").innerHTML += errorObject.errorText;
        });


                 //Set patient ode to be in chat with doctor
		  var patientcode = $('#patientcode').val();
		  $.ajax({
			        type: 'POST',
					dataType:"json",
					url: 'public/Doctors/quickconsult/model/setpatientcode.php',
					data: {patientcode: patientcode},
					success: function(e){
						
					},
	          });
		
    });
	
    var selfEasyrtcid = "";
function addToConversation(who, msgType, content) {
  // Escape html special characters, then add linefeeds.
  content = content.replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;");
  content = content.replace(/\n/g, "<br />");
  
  if(who == 'Me'){
	    
  $( "#speech-bubble"  ).append( "<div class='speech-bubble-rt'><div class='speech-bubble-rt speech-bubble-right' id='conversation2'>" + content + "</div></div>" );
	  }else{
	

	if(who == '<?php echo $easyrtcid ;?>'){
  $( "#speech-bubble"  ).append( "<div class='speech-bubble-lt'><div class='speech-bubble-lt speech-bubble-left' id='conversation'>" + content + "</div></div>" );
		  }
  }
  $('#chatareaindoc').scrollTop($('#chatareaindoc')[0].scrollHeight);
}
 


function geteasyrtcid(){
	var patientcode = $('#patientcode').val();
	            $.ajax({
			        type: 'POST',
					dataType:"json",
					url: 'public/Doctors/quickconsult/model/getpatienteasyrtcid.php',
					data: {patientcode: patientcode},
					success: function(e){
                                        //alert(e.patienteasycode);
						sendStuffWS(e.patienteasycode);
						
					},
			     });
}


function sendStuffWS(otherEasyrtcid) {

  var text = document.getElementById("chatmsg").value;
  if(text.replace(/\s/g, "").length === 0) { // Don"t send just whitespace
  return;
  }

  easyrtc.sendDataWS(otherEasyrtcid, "message",  text, ackhandler);
  addToConversation("Me", "message", text);
 
  //document.getElementById("chatmsg").value = "";     
}


 
function loginSuccess(easyrtcid) {
  selfEasyrtcid = easyrtcid;
  document.getElementById("iam").innerHTML = "I am " + easyrtcid;
//console.log(easyrtcid);
  
         /*
		  * Save Doctor easyrtcid
		  */
		        $.ajax({
			        type: 'POST',
					url: 'public/Doctors/quickconsult/model/saveeasyrtcid.php',
					data: {selfEasyrtcid: selfEasyrtcid},
					success: function(e){
						
					},
			     });
		 //End saving doctor easyrtcid	
}
 
 
function loginFailure(errorCode, message) { 
  easyrtc.showError(errorCode, message);
}

function ackhandler(response){
        if (response.msgType === "error") {
               //alert(response.msgType);
               geteasyrtcid();
            }
            else {
               //console.log('Success sending message');
               //alert(response.msgType);
             
            }        
}
//End ackhandler
</script>
<!--End instant messaging chat--> 