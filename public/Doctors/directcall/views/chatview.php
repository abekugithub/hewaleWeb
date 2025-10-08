<div class="main-content">
<input type="hidden" class="form-control" id="easyrtcid" name="easyrtcid" value="<?php echo $easyrtcid ;?>">
<input type="hidden" class="form-control" id="doctoreasyrtcid" name="doctoreasyrtcid" value="<?php echo $doctoreasyrtcid ;?>">
<input type="hidden" class="form-control" id="doctorcode" name="doctorcode" value="<?php echo $doctorcode ;?>">
<input type="hidden" class="form-control" id="sendercode" name="sendercode" value="<?php echo $roomcode ;?>">
<input type="hidden" id="patientcode" name="patientcode" value="<?php echo $patientcode ;?>" >

    <div class="page-wrapper">


        <?php //$engine->msgBox($msg,$status); ?>

        <!-- <div class="page-lable lblcolor-page">Table</div>-->
        <div class="page form">
            <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper">
                <span class="pull-right">
                <button class="btn btn-dark" onclick="document.getElementById('view').value='';document.myform.submit;"><i class="fa fa-arrow-left"></i> Close</button>
                    </span>
                </div>

            </div>
            

<div class="page-chat page-content bg-page">
   
    <div class="content-block">

        
        <div class="col-sm-12">
            <div class="chat-area chatarea" id="chat-area" onload="scrollToBottom();">
           <?php 
           
           if($msgdetails){
                  while($obj = $msgdetails->FetchNextObject()){
                      ?>
                    <?php if($obj->CH_SENDER_CODE == $sendercode){ ?>
                        <div class="speech-bubble-rt">
                            <div class="speech-bubble-rt speech-bubble-right" id="conversation2"> <?php echo $encaes->decrypt($obj->CH_MSG) ;?> <div class="formatchatdate"><div class="formatchatdate"><?php echo date("d M Y H:i",strtotime($obj->CH_DATE)) ;?></div></div></div>
                        </div>
                        <?php }else{ ?>
                            <div class="speech-bubble-lt">
                                <div class="speech-bubble-lt speech-bubble-left" id="conversation"> <?php echo $encaes->decrypt($obj->CH_MSG) ;?> <div class="formatchatdate"><?php echo date("d M Y H:i",strtotime($obj->CH_DATE)) ;?></div></div>
                        </div>
                    <?php } ?>

                <?php  } }?>
            </div>

            <div class="chat-footer">
                <textarea name="chatmsg" id="chatmsg" class="form-control textareaexpand" rows="1"></textarea>
                <button type="button" id="otherClients" onclick="geteasyrtcchatid()"><i
                        class="fa fa-paper-plane"></i></button>
            </div>

 

        <div>


    

       
    </div>
</div>





        </div>

    </div>

</div>


<script>
    $(document).ready(function () {
        $("#chat-area").animate({
            scrollTop: $('#chat-area').prop("scrollHeight")
        }, 1000);
    })


    var textarea = document.querySelector('textarea');
    textarea.addEventListener('keydown', autosize);
    function autosize(e) {
         var el = this;
         var key = e.which || e.keyCode;
         setTimeout(function () {
            el.style.cssText = 'height:auto;';
            el.style.cssText = 'height:' + el.scrollHeight + 'px';
            var text = document.querySelector('textarea').value;
             if (key === 13 || text!=='') {
                el.style.borderRadius = '10px';
             }
         }, 0);
    }

   
</script>


<script type="text/javascript">


    $(document).ready(function () { alert('bravoooo');
        //easyrtc.setSocketUrl("https://192.168.15.8:8443");
        easyrtc.setSocketUrl("https://orconsvideo.com:8443");       
        
        easyrtc.easyApp("easyrtc.audioVideoSimple", "selfVideo", ["callerVideo"], loginSuccess, loginFailure);
        //easyrtc.connect("easyrtc.audioVideoSimple",loginSuccess,loginFailure); easyrtc.connect("easyrtc.audioVideoSimple",loginSuccess,loginFailure); 
        easyrtc.setPeerListener(addToConversation); 
    

        easyrtc.setOnError(function (errorObject) {
            alert("Notification: Slow Network. ");
            //alert(errorObject.errorText);
            //document.getElementById("errMessageDiv").innerHTML += errorObject.errorText;
        });


    })

/*
    easyrtc.setStreamAcceptor(function (easyrtcid, stream, streamName) {
            $('#picker').hide();
            easyrtc.setVideoObjectSrc(document.getElementById("callerVideo"), stream);
            easyrtc.enableVideo(true);
            easyrtc.enableVideoReceive(true);
            easyrtc.initMediaSource(
                function (mediastream) {
                    easyrtc.setVideoObjectSrc(
                        document.getElementById("selfVideo"),
                        mediastream);
                   
                },
                function (errorCode, errorText) {
                    easyrtc.showError(errorCode, errorText);
                });
            //Notify client if there is a disconnection
            easyrtc.setDisconnectListener(function () {
                //
                easyrtc.showError("SYSTEM-ERROR",
                    "Disconnected.You will be automatically reconnected when your internet connection is stable.Click Okay to continue "
                    );
                self.disconnectListener = disconnectListener;
            });
            //audio.pause();
        })
    */

        easyrtc.setOnError(function (errorObject) {
            alert("Notification: Slow Network. ");
            //alert(errorObject.errorText);
            //document.getElementById("errMessageDiv").innerHTML += errorObject.errorText;
        });

        easyrtc.setOnStreamClosed(function (easyrtcid, stream, streamName) {
            alert("Call ended successfully.");

            //This clears media stream
            easyrtc.clearMediaStream = function (element) {
                if (typeof element.src !== 'undefined') {
                    //noinspection JSUndefinedPropertyAssignment
                    element.src = "";

                } else if (typeof element.srcObject !== 'undefined') {
                    element.srcObject = "";
                } else if (typeof element.mozSrcObject !== 'undefined') {
                    element.mozSrcObject = null;
                }
                //End clearing media stream

            };
        });
        /*
         * End of media stream
         */

        /**
         * This function checks if a call coming was ended by the caller
         * before it's picked up
         */
    
        //End checking that call was ended before being picked up


    })


    function hidevideobtn() {
        /*$('.startPMsg').hide();
        $('.startPCall2').hide();
        $('#selfVideo').hide();*/
    }

    function clearConnectList() {
        var otherClientDiv = document.getElementById("otherClients");
        while (otherClientDiv.hasChildNodes()) {
            otherClientDiv.removeChild(otherClientDiv.lastChild);
        }
    }

    function convertListToButtons(roomName, data, isPrimary) {
        clearConnectList();
        var otherClientDiv = document.getElementById("otherClients");
        for (var easyrtcid in data) {
            var button = document.createElement("button");
            button.setAttribute("type", "button");
            button.onclick = function (easyrtcid) {
                return function () {
                    performCall(easyrtcid);
                };
            }(easyrtcid);

            var label = document.createTextNode(easyrtc.idToName(easyrtcid));
            button.appendChild(label);
            otherClientDiv.appendChild(button);
        }
    }

    function loginSuccess(easyrtcid) { 
        var sendercode = $('#sendercode').val();
        var selfEasyrtcid = easyrtcid;
        //document.getElementById("iam").innerHTML = "I am " + easyrtc.cleanId(easyrtcid);
        /*
        * Save patient easyrtcid
        */
        $.ajax({
            type: 'POST',
            url: 'public/OPD/consulingroom/model/saveeasyrtcid.php?sendercode='+sendercode,
            data: {
                selfEasyrtcid: selfEasyrtcid
            },
            success: function (e) {
                $('#easyrtcid').val(selfEasyrtcid);
            },
        });
    }

    function loginFailure(errorCode, message) {
        easyrtc.showError(errorCode, message);
    }
</script>


<!--Start instant messaging chat-->
<script type="text/javascript">
    function addToConversation(who, msgType, content) {
        // Escape html special characters, then add linefeeds.
        content = content.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;");
        content = content.replace(/\n/g, "<br />");
       
        if (who == 'Me') {

            $(".chat-area").append(
                "<div class='speech-bubble-rt'><div class='speech-bubble-rt speech-bubble-right' id='conversation2'><div class='profile'></div><div class='text'>" +
                content + "</div></div>");
            $("#chat-area").animate({
                scrollTop: $('#chat-area').prop("scrollHeight")
            }, 1000);

        } else {
            var  doctoreasyrtcid = $('#doctoreasyrtcid').val();
            //alert('Incoming message');
            if(who == doctoreasyrtcid){
            $(".chat-area").append(
                "<div class='speech-bubble-lt'><div class='speech-bubble-lt speech-bubble-left' id='conversation2'><div class='profile'></div><div class='text'>" +
                content + "</div></div>");
            }
            $("#chat-area").animate({
                scrollTop: $('#chat-area').prop("scrollHeight")
            }, 1000);

        }
    } 


    function geteasyrtcchatid() {
        /*
         * Get doctor easyrtcid code
         */
        var doctorcode = $('#doctorcode').val();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'public/OPD/consultingroom/model/getdoctoreasyrtcid.php',
            data: {
                "doctorcode": doctorcode
            },
            success: function (e) {
                sendStuffWS(e.easyrtcid);
                $('#doctoreasyrtcid').val(e.easyrtcid);
            },
        });
        //End getting easyrtcid and calling performcall function
    }

    function sendStuffWS(otherEasyrtcid) {  
        var text = document.getElementById("chatmsg").value;
        
        if (text.replace(/\s/g, "").length === 0) { // Don"t send just whitespace
            return;
        }
        
        easyrtc.sendDataWS(otherEasyrtcid, "message", text, ackhandler);
		alert(text);
        //easyrtc.sendDataWS(otherEasyrtcid, "message",  text);
        addToConversation("Me","message", text);

        //Save chat even if easyRTC fails sending it
        var doctorcode = $('#doctorcode').val();
        var sendercode = $('#sendercode').val();
        alert(otherEasyrtcid);
		alert('bravooooo');
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'public/OPD/consultingroom/model/addchat.php',
            data: {
                "doctorcode": doctorcode,
                "sendercode": sendercode,
                "message": text
            },
            success: function (e) {

            },
        });
        //End saving chat

        document.getElementById("chatmsg").value = "";
    }

    function ackhandler(response) {

        if (response.msgType === "error") {
            //alert(response.msgType);
            geteasyrtcchatid();
        } else {
            //console.log('Success sending message');
            //alert(response.msgType);
        }
    }
    //End ackhandler
</script>
