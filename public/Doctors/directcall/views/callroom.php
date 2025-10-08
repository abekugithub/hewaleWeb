<div class="main-content">
    <input type="hidden" class="form-control" id="easyrtcid" name="easyrtcid" value="<?php echo $easyrtcid ;?>">
    <input type="hidden" class="form-control" id="doctoreasyrtcid" name="doctoreasyrtcid"
        value="<?php echo $doctoreasyrtcid ;?>">
    <input type="hidden" class="form-control" id="receivercode" name="receivercode" value="<?php echo $receivercode ;?>">
    <input type="hidden" class="form-control" id="keys" name="keys" value="<?php echo $keys ;?>">

    <input type="hidden" class="form-control" id="sendercode" name="sendercode" value="<?php echo $usrcode ;?>">

    <div class="page-wrapper">
        <div class="page form">
           <!-- <div class="moduletitle" style="margin-bottom:0px;">
                <div class="moduletitleupper"><?php //echo 'Calling Dr. '.$receivername; ?>
                    <span class="pull-right">

                    </span>
                </div>

            </div> -->

            <div class="page-chat page-content bg-page">
                <div class="content-block" style="margin-top:30px;">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#videopage"><i class="fa fa-video-camera"></i> Video</a></li>
                        <li><a data-toggle="tab" href="#chatarea"><i class="fa fa-commenting"></i> Chat</a></li>
                    </ul>

                    <div class="tab-content">
                        <!------------------------- Video tab -------------------------------------->
                        <div id="videopage" class="tab-pane fade in active">
                            <div class="col-sm-12" no-padding>
                                <div id="videopage" class="tab-pane fade in">
                                    <div class="callervideoview">
                                        <button fullscreen type="button" onClick="openFullscreen()"><i class="fa fa-window-maximize"></i> Full Screen</button>
                                        <video autoplay id="callerVideo"></video>
                                    </div>
                                </div>
                                <div class="picker" id="picker" title="Pick/Dial Call"><i class="fa fa-phone"></i></div>
                                <div class="picker" id="picker2" title="Pick/Dial Call" onClick="geteasyrtcid()"><i class="fa fa-phone"></i></div>
                                <div class="callcancel" id="callcancel" title="End Call"><i class="fa fa-phone"></i></div>
                                <video autoplay class="easyrtcMirror" id="selfVideo" muted volume="0" width="150px" height="150px"></video>
                            </div>
                        </div>

                        <!------------------------- Chat tab -------------------------------------->
                        <div id="chatarea" class="tab-pane fade">
                            <div class="col-sm-12" no-padding>
                                <div class="chat-area chatarea" id="chat-area" onload="scrollToBottom();">
                                    <?php 
                                    if($msgdetails){
                                        while($obj = $msgdetails->FetchNextObject()){
                                    ?>
                                    <?php if($obj->CH_SENDER_CODE == $usrcode){ ?>
                                    <div class="speech-bubble-rt">
                                        <div class="speech-bubble-rt speech-bubble-right" id="conversation2">
                                            <?php echo $encaes->decrypt($obj->CH_MSG) ;?> <div class="formatchatdate">
                                                <div class="formatchatdate">
                                                <?php echo date("d M Y H:i",strtotime($obj->CH_DATE)) ;?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php }else{ ?>
                                    <div class="speech-bubble-lt">
                                        <div class="speech-bubble-lt speech-bubble-left" id="conversation">
                                            <?php echo $encaes->decrypt($obj->CH_MSG) ;?> <div class="formatchatdate">
                                            <?php echo date("d M Y H:i",strtotime($obj->CH_DATE)) ;?></div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <?php  } }?>
                                </div>

                                <div class="chat-footer">
                                    <textarea name="chatmsg" id="chatmsg" class="form-control textareaexpand" rows="1"></textarea>
                                    <button type="button" id="otherClients" onclick="geteasyrtcchatid()"><i class="fa fa-paper-plane"></i></button>
                                </div>
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
        $("#chat-area").animate({
            scrollTop: $('#chat-area').prop("scrollHeight")
        }, 1000);
    })


    // var textarea = document.querySelector('textarea');
    // textarea.addEventListener('keydown', autosize);
    // function autosize() {
    //      var el = this;
    //      setTimeout(function () {
    //          el.style.cssText = 'height:auto;';
    //          el.style.cssText = 'height:' + el.scrollHeight + 'px';
    //          el.style.borderRadius='10px;'
    //      }, 0);
    // }

    var textarea = document.querySelector('textarea');
    textarea.addEventListener('keydown', autosize);

    function autosize(e) {
        var el = this;
        var key = e.which || e.keyCode;
        setTimeout(function () {
            el.style.cssText = 'height:auto;';
            el.style.cssText = 'height:' + el.scrollHeight + 'px';
            var text = document.querySelector('textarea').value;
            if (key === 13 || text !== '') {
                el.style.borderRadius = '10px';
            }
        }, 0);
    }
</script>


<script type="text/javascript">
    var audio2 = new Audio('media/audio/ackerpeace.mp3');
    var audio = new Audio('media/audio/ackerjoy.mp3');

    $(document).ready(function () {
        //easyrtc.setSocketUrl("https://192.168.15.8:8443");
        easyrtc.setSocketUrl("https://orconsvideo.com:8443");
        easyrtc.setVideoDims(640, 480);
        //$('.callervideoview').hide();
        //easyrtc.setRoomOccupantListener(convertListToButtons);
        //
        easyrtc.easyApp("easyrtc.audioVideoSimple", "selfVideo", ["callerVideo"], loginSuccess, loginFailure);
        //easyrtc.connect("easyrtc.audioVideoSimple",loginSuccess,loginFailure); easyrtc.connect("easyrtc.audioVideoSimple",loginSuccess,loginFailure); 
        easyrtc.setPeerListener(addToConversation);

        $('#picker2').show();
        $('#callcancel').hide();

        easyrtc.setAcceptChecker(function (easyrtcid, acceptor) {
            $('#picker2').hide();
            $('#picker').show();
            $('#callcancel').show();

            /*Start ringing tone*/
            audio2.play();
            audio2.addEventListener('ended', function () {
                this.currentTime = 0;
                this.play();
            }, false);

            $('#picker').animate({
                left: '200px',
                top: '200',
                opacity: '1',
                height: '200px',
                width: '200px'
            });

            animate_loop = function animate_loop() {
                $("#picker").animate({
                    height: '100px',
                    width: '100px'
                }, 1000, function () {

                    $("#picker").animate({
                        height: '200px',
                        width: '200px'
                    }, 1000, function () {});

                    animate_loop();
                });

            }

            animate_loop();

            $("#picker").click(function () {
                acceptor(true);
                audio2.pause();
            })

            $("#callcancel").click(function () {
                acceptor(false);
                audio2.pause();
            })

        })

        easyrtc.setStreamAcceptor(function (easyrtcid, stream, streamName) {
            $('#picker').hide();
            $('#picker2').hide();
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
            audio.pause();
        })


        easyrtc.setOnError(function (errorObject) {
            alert("Notification: Slow Network. ");
            //alert(errorObject.errorText);
            //document.getElementById("errMessageDiv").innerHTML += errorObject.errorText;
        });

        easyrtc.setOnStreamClosed(function (easyrtcid, stream, streamName) {
            easyrtc.hangupAll();

            //This clears media stream
            easyrtc.enableVideoReceive(false);
            easyrtc.setVideoObjectSrc(document.getElementById("callerVideo"), "");

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

            alert("Call ended successfully.");
            $('#callcancel').hide();
            $('#picker').hide();
            $('#picker2').show();
        });
        /*
         * End of media stream
         */

        /**
         * This function checks if a call coming was ended by the caller
         * before it's picked up
         */
        easyrtc.setCallCancelled(function (easyrtcid, explicitlyCancelled) {
            if (explicitlyCancelled) {
                audio2.pause();
                audio.pause();
                $('#picker').animate({
                    left: '50px',
                    top: '420px',
                    height: '50px',
                    width: '50px'
                });
                $('#picker').stop();

                /*alert('Call ended by the caller!'); */
                audio2.pause();
                audio.pause();
                $('#picker').stop();


            } else {}
        });
        //End checking that call was ended before being picked up


        $("#callcancel").click(function () {
            easyrtc.hangupAll();
            audio2.pause();
            audio.pause();

            easyrtc.setOnStreamClosed(function (easyrtcid, stream, streamName) {

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

        })


    })


    function phonecall() {
        easyrtc.enableVideo(false);
        easyrtc.enableVideoReceive(false);
        easyrtc.initMediaSource(function (mediastream) {
                /*easyrtc.setVideoObjectSrc(
                document.getElementById("selfVideo"),
                mediastream);*/

            },
            function (errorCode, errorText) {
                easyrtc.showError(errorCode, errorText);
            });
    }

    function initvideo() {
        easyrtc.enableVideo(true);
        easyrtc.enableVideoReceive(true);
        easyrtc.initMediaSource(
            function (mediastream) {
                easyrtc.setVideoObjectSrc(document.getElementById("selfVideo"), mediastream);

            },
            function (errorCode, errorText) {
                easyrtc.showError(errorCode, errorText);
            });
    }


    function geteasyrtcid() {
        /*
         * Get patient easyrtcid code
         */
        var receivercode = $('#receivercode').val();
        //var roomid = $('#roomid').val();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'public/Doctors/directcall/model/getdoctoreasyrtcid.php',
            data: {
                "doctorcode": receivercode
            },
            success: function (e) {
                performCall(e.easyrtcid);
                /*Start ringing tone*/
                $('#callcancel').show();

                audio.play();
                audio.addEventListener('ended', function () {
                    this.currentTime = 0;
                    this.play();
                }, false);

            },
        });
        //End getting easyrtcid and calling performcall function
    }

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
            url: 'public/Doctors/directcall/model/saveeasyrtcid.php?sendercode=' + sendercode,
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
            if (key === 13 || text !== '') {
                el.style.borderRadius = '10px';
            }
        }, 0);
    }
</script>


<script type="text/javascript">
    $(document).ready(function () {
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
            var doctoreasyrtcid = $('#doctoreasyrtcid').val();
            //alert('Incoming message');
            if (who == doctoreasyrtcid) {
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
        var receivercode = $('#receivercode').val();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'public/Doctors/directcall/model/getdoctoreasyrtcid.php',
            data: {
                "doctorcode": receivercode
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

        //easyrtc.sendDataWS(otherEasyrtcid, "message",  text);
        addToConversation("Me", "message", text);

        //Save chat even if easyRTC fails sending it
        var receivercode = $('#receivercode').val();
        var sendercode = $('#sendercode').val();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'public/Doctors/directcall/model/addchat.php',
            data: {
                "doctorcode": receivercode,
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