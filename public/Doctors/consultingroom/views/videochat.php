<?php
include('../../../../config.php');
include SPATH_LIBRARIES.DS."engine.Class.php";
include SPATH_LIBRARIES.DS."doctors.Class.php";
$engine = new engineClass();
$doctors = new doctorClass();
$usrcode = $engine->getActorCode();

$encaes = new encAESClass($saltencrypt,'CBC',$pepperdecrypt);

//Get Chps compound details and room id
$objchpsdetails = $doctors->getDocChpsDetails($usrcode);
$facicode = $objchpsdetails->CONSROOM_FACICODE ;
$roomid = $objchpsdetails->CONSROOM_CODE;

$msgroom = $doctors->getChatPerRoom($usrcode,$roomid);

?>
<!DOCTYPE html>
<html lang="en">

<head>
<link href="../../../../media/css/main.css" rel = "stylesheet" type = "text/css"/>

<script type="text/javascript" src="../../../../media/js/jquery.min.js"></script>
<script type="text/javascript" src="../../../../media/js/jquery-ui.min.js"></script>
<script src="../../../../media/js/socket.io/socket.io.js"></script>
<script type="text/javascript" src="../../../../media/js/easyrtc.js"></script>
<script type="text/javascript" src="../../../../media/js/demo_audio_video_simple.js"></script>
<script type="text/javascript" src="../../../../media/js/demo_instant_messaging.js"></script>

<script type="text/javascript" src="../../../../media/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../../../../media/js/bootstrap-toggle.min.js"></script>

<script type="text/javascript" src="../../../../media/js/select2.full.js"></script>
<script type="text/javascript" src="../../../../media/js/custom.js"></script>
<script type="text/javascript" src="../../../../media/js/moment.min.js"></script>
<script type="text/javascript" src="../../../../media/js/ez.countimer.js"></script>

<script type="text/javascript" src="../../../../media/js/RecordRTC.js"></script>

</head>


<body>

<script >

      function openscreen(){
        var elemlt = document.getElementById("callerVideo");
        if (elemlt.requestFullscreen) {
            elemlt.requestFullscreen();
            } else if (elemlt.mozRequestFullScreen) { // Firefox 
                elemlt.mozRequestFullScreen();
            } else if (elemlt.webkitRequestFullscreen) { // Chrome, Safari and Opera 
                elemlt.webkitRequestFullscreen();
            } else if (elemlt.msRequestFullscreen) { // IE/Edge 
                elemlt.msRequestFullscreen();
            }
    }
</script>

<input id="consultcode" name="consultcode" value="<?php echo $consultcode; ?>" type="hidden" />
<input id="doctorcode" name="doctorcode" value="<?php echo $usrcode; ?>" type="hidden" />
<input id="viewdynamic" name="viewdynamic" value="" type="hidden" />

<input id="facicode" name="facicode" value="<?php echo $facicode ; ?>" type="hidden" />
<input id="roomid" name="roomid" value="<?php echo $roomid ; ?>" type="hidden" />
<input id="patienteasyrtcid" name="patienteasyrtcid" value="<?php echo $patienteasyrtcid ; ?>" type="hidden" />


<ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#video"><i class="fa fa-video-camera"></i></a></li>
            <li><a data-toggle="tab" href="#audio"><i class="fa fa-phone"></i></a></li>
            <li><a data-toggle="tab" href="#chat"><i class="fa fa-comment"></i></a></li>
        </ul>

            
        <div class="tab-content">
            <button fullscreen type="button" onClick="openscreen()"><i class="fa fa-window-maximize"></i> Full Screen</button>
            <div id="video" class="tab-pane fade in active">
                <div class="tab-pane fade in">
                    <div class="callervideoview">
                        <video autoplay id="callerVideo" width="250" height="300"></video>
                    </div>
                    <!-- Recording Video -->
                    <video  id="vid2" width="200" height="200" controls></video>
                   <!-- <button id="btnStart">Start Recording</button>
                    <button id="btnStop">Stop Recording</button> -->
                    
                    <button id="btn-start-recording">Start Recording</button> 
                    <button id="btn-stop-recording">Stop Recording</button>
                    <!--End recording-->
                </div>
                <video autoplay class="easyrtcMirror" id="selfVideo" muted volume="0" width="200" height="200"></video>
                <section class="controls">
                    <div class="call" id="picker" onClick="geteasyrtcid()" ><i class="fa fa-phone"></i></div>
                    <div class="call" id="picker2" onClick="" ><i class="fa fa-phone"></i></div>
                    <div class="endcall" id="callcancel"><i class="fa fa-phone"></i></div>
                </section>
            </div>

            <div id="audio" class="tab-pane fade">
                <p id="audioimg"><img src="../../../../media/img/audio.svg" alt="audio"></p>
                <section class="controls">
                    <div class="call" id="picker3" onClick="geteasyrtcidcallonly()"><i class="fa fa-phone"></i></div>
                    <div class="endcall" id="callcancel2"><i class="fa fa-phone"></i></div>
                </section>
            </div>

            <div id="chat" class="tab-pane fade chat-show">
              
            <div class="chatarea" id="chatarea">   
           <?php 
           if($msgroom){ 
                  while($obj = $msgroom->FetchNextObject()){
                      ?>
                    <?php if($obj->CH_SENDER_CODE == $usrcode){ ?>
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
               
                <section class="chatbox">
                    <textarea name="chatmsg" id="chatmsg" rows="1"></textarea>
                    <button type="button" id="otherClients" onclick="geteasyrtcchatid()" ><i class="fa fa-send"></i></button>
                </section>
            </div>
        </div>


        <script>
    $(document).ready(function () { 
        $("#chatarea").animate({
                scrollTop: $('#chatarea').prop("scrollHeight")
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
             if (key === 13 || text!=='') {
                el.style.borderRadius = '10px';
             }
         }, 0);
    }

   
</script>


<script type="text/javascript">

var audio2 = new Audio('../../../../media/audio/ackerpeace.mp3');
var audio = new Audio('../../../../media/audio/ackerjoy.mp3');

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
    
       $('#callcancel').hide();
       $('#callcancel2').hide();
       $('#picker2').hide();
  
            easyrtc.setAcceptChecker(function(easyrtcid, acceptor) {
                $('#picker').hide();
                $('#picker2').show();
                $('#callcancel').show();
                $('#callcancel2').show();
         
                	/*Start ringing tone*/
                    audio2.play();
					audio2.addEventListener('ended', function() {
                    this.currentTime = 0;
                    this.play();
                    }, false);

                $('#picker2').animate({
                    left: '200px',
                    top: '50',
                    opacity: '1',
                    height: '200px',
                    width: '200px'
                });

                animate_loop = function animate_loop(){
                $( "#picker2" ).animate({
                    height: '80px',
                    width: '80px'
                }, 1000, function() {
                    
                    $( "#picker2" ).animate({
                    height: '100px',
                    width: '100px'
                }, 1000, function() { 
                });

                  animate_loop();
                });

            }

            animate_loop();

                $( "#picker2" ).click(function() {
                    acceptor(true);
                    audio2.pause();
                })

                $( "#callcancel" ).click(function() {
                    acceptor(false);
                    audio2.pause();
                })

                $( "#callcancel2" ).click(function() {
                    acceptor(false);
                    audio2.pause();
                })

            })     

        easyrtc.setStreamAcceptor(function (easyrtcid, stream, streamName) {
            $('#picker2').hide();
            $('#picker').hide();
            $('#picker3').hide();

            easyrtc.setVideoObjectSrc(document.getElementById("callerVideo"), stream);
            easyrtc.enableVideo(true);
            easyrtc.enableVideoReceive(true);
            easyrtc.initMediaSource(
                function (mediastream) {
                    easyrtc.setVideoObjectSrc(
                        document.getElementById("selfVideo"),
                        mediastream);
                        $('#picker2').hide();
                        $('#picker').hide();
                        $('#picker3').hide();
                   
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
            easyrtc.setVideoObjectSrc(document.getElementById("callerVideo"), "");
           /* alert("Call ended successfully."); */
            $('#picker2').hide();
            $('#picker').show();
            $('#picker3').show();
            $('#callcancel').hide();
            $('#callcancel2').hide();

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
        easyrtc.setCallCancelled( function(easyrtcid, explicitlyCancelled){
             if( explicitlyCancelled ){
                 audio.pause();
                 $('#picker2').animate({
                    left: '50px',
                    top: '420px',
                    height: '50px',
                    width: '50px'
                });
                $('#picker2').stop();

                 /*alert('Call ended by the caller!');*/
                 audio.pause();
                 $('#picker2').stop();
              }
              else{
              }
          });
        //End checking that call was ended before being picked up

        $( "#callcancel" ).click(function() {
        easyrtc.hangupAll();
		audio.pause();
		alert("Call ended successfully.");
        
        easyrtc.setOnStreamClosed( function(easyrtcid, stream, streamName){
			//This clears media stream
			easyrtc.clearMediaStream = function(element) {
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


        $( "#callcancel2" ).click(function() {
        easyrtc.hangupAll();
		audio.pause();
        $('#picker3').show();
        $('#callcancel2').hide();
		alert("Call ended successfully.");

        easyrtc.setOnStreamClosed( function(easyrtcid, stream, streamName){
			//This clears media stream
			easyrtc.clearMediaStream = function(element) {
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



    $( "#picker3" ).click(function() {
                easyrtc.enableVideo(false);
                easyrtc.enableVideoReceive(false);
                easyrtc.initMediaSource(function (mediastream) {
              /* easyrtc.setVideoObjectSrc(
                document.getElementById("selfVideo"),
                mediastream);*/
               
            },
            function (errorCode, errorText) {
                easyrtc.showError(errorCode, errorText);
            });

            easyrtc.setOnStreamClosed( function(easyrtcid, stream, streamName){
			//This clears media stream
			easyrtc.clearMediaStream = function(element) {
                element.src = "";
                element.srcObject = "";
                element.mozSrcObject = null;
			//End clearing media stream
			};
          });
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


    function geteasyrtcid(){
		 /*
		  * Get patient easyrtcid code
		  */
		  var roomid = $('#roomid').val();
        
		        $.ajax({
			        type: 'POST',
                    dataType:'json',
					url: '../../../../public/Doctors/consultingroom/model/getpatienteasyrtcid.php?roomid='+roomid,
					data: {"roomid": roomid},
					success: function(e){
						performCall(e.easyrtcid);
						/*Start ringing tone*/
                        $('#callcancel').show();
                        $('#callcancel2').show();

                        audio.play();
						audio.addEventListener('ended', function() {
                        this.currentTime = 0;
                        this.play();
                        }, false);

					},
			     });
		 //End getting easyrtcid and calling performcall function
	}   



    function geteasyrtcidcallonly(){
		 /*
		  * Get patient easyrtcid code
		  */
		  var roomid = $('#roomid').val();
        
		        $.ajax({
			        type: 'POST',
                    dataType:'json',
					url: '../../../../public/Doctors/consultingroom/model/getpatienteasyrtcid.php?roomid='+roomid,
					data: {"roomid": roomid},
					success: function(e){
						performCall(e.easyrtcid);
						/*Start ringing tone*/
                        $('#callcancel').show();
                        $('#callcancel2').show();

                        audio.play();
						audio.addEventListener('ended', function() {
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
        var selfEasyrtcid = easyrtcid;
        //document.getElementById("iam").innerHTML = "I am " + easyrtc.cleanId(easyrtcid);
        /*
        * Save doctor easyrtcid
        */
        $.ajax({
            type: 'POST',
            url: '../../../../public/Doctors/consultingroom/model/saveeasyrtcid.php',
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
            $(".chatarea").append(
                "<div class='speech-bubble-rt'><div class='speech-bubble-rt speech-bubble-right' id='conversation2'><div class='profile'></div><div class='text'>" +
                content + "</div></div>");
            $("#chatarea").animate({
                scrollTop: $('#chatarea').prop("scrollHeight")
            }, 1000);

        } else { 
            var  patienteasyrtcid = $('#patienteasyrtcid').val();
            if(who == patienteasyrtcid){
            $(".chatarea").append(
                "<div class='speech-bubble-lt'><div class='speech-bubble-lt speech-bubble-left' id='conversation2'><div class='profile'></div><div class='text'>" +
                content + "</div></div>");
            }
            $("#chatarea").animate({
                scrollTop: $('#chatarea').prop("scrollHeight")
            }, 1000);

        }
    } 


    function geteasyrtcchatid() {
        /*
         * Get Patient easyrtcid room code
         */
        var roomid = $('#roomid').val();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '../../../../public/Doctors/consultingroom/model/getpatienteasyrtcid.php?roomid='+roomid,
            data: {
                "roomid": roomid
            },
            success: function (e) {
                sendStuffWS(e.easyrtcid);
                $('#patienteasyrtcid').val(e.easyrtcid);
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
        addToConversation("Me","message", text);

        //Save chat even if easyRTC fails sending it
        var doctorcode = $('#doctorcode').val();
        var roomid = $('#roomid').val();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '../../../../public/Doctors/consultingroom/model/addchat.php',
            data: {
                "doctorcode": doctorcode,
                "roomid": roomid,
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

<script>
/*
  let constraintObj = {
     audio: true,
     video: true
  };

    navigator.mediaDevices.getUserMedia(constraintObj)
    .then(function(mediaStreamObj){
        let video = document.querySelector('video');
        //let video = document.getElementById('callerVideo');
        
        if("srcObjet" in video){
           video.srcObjet = mediaStreamObj;
        }else{
        // video.src = window.URL.createObjectURL(mediaStreamObj);
        }

        video.onloademetadata = function(ev){
            video.play();
        }

        //Add listeners to save video
        //let start = document.getElementById('btnStart');
        //let stop = document.getElementById('btnStop');
        let vidSave = document.getElementById('vid2');
        let mediaRecorder = new MediaRecorder(mediaStreamObj);
        let chunks = [] ;

       /* start.addEventListener('click', (ev)=>{
            mediaRecorder.start();
            console.log(mediaRecorder.state);
        });
        stop.addEventListener('click', (ev)=>{
            mediaRecorder.stop();
            console.log(mediaRecorder.state);
        }); */
       /* $('#picker').click(function() {
            mediaRecorder.start();
            console.log(mediaRecorder.state);
        });
        
        easyrtc.setOnStreamClosed(function (easyrtcid, stream, streamName) {
            mediaRecorder.stop();
            console.log(mediaRecorder.state);
        });

        mediaRecorder.ondataavailable = function(ev){
            chunks.push(ev.data);
        }
        mediaRecorder.onstop = (ev)=>{
    
            let blob = new Blob(chunks, {type: 'video/mp4;'});
            chunks = [] ;
            let videoURL = window.URL.createObjectURL(blob);
            vidSave.src = videoURL ;
            
        }

    })
    .catch(function(err){
       console.log(err.name,err.message);
    }); */

</script>


<script>
var video = document.querySelector('video');
function captureCamera(callback) {
    navigator.mediaDevices.getUserMedia({ audio: true, video: true }).then(function(camera) {
        callback(camera);
    }).catch(function(error) {
        alert('Unable to capture your camera. Please check console logs.');
        console.error(error);
    });
}

// Download recording P2
function getRandomString() {
    if (window.crypto && window.crypto.getRandomValues && navigator.userAgent.indexOf('Safari') === -1) {
        var a = window.crypto.getRandomValues(new Uint32Array(3)),
            token = '';
        for (var i = 0, l = a.length; i < l; i++) {
            token += a[i].toString(36);
        }
        return token;
    } else {
        return (Math.random() * new Date().getTime()).toString(36).replace(/\./g, '');
    }
}

function getFileName(fileExtension) {
    var d = new Date();
    var year = d.getFullYear();
    var month = d.getMonth();
    var date = d.getDate();
    return 'RecordRTC-' + year + month + date + '-' + getRandomString() + '.' + fileExtension;
}
//End download recording P2

function stopRecordingCallback() {
    video.src = video.srcObject = null;
    video.muted = false;
    video.volume = 1;
    //video.src = URL.createObjectURL(recorder.getBlob());
    
    /*recorder.camera.stop();
    recorder.destroy();
    recorder = null;*/


    //Download recording P1
    if(!recorder || !recorder.getBlob()) return;

    if(isSafari) {
        recorder.getDataURL(function(dataURL) {
            SaveToDisk(dataURL, getFileName('mp4'));
        });
        return;
    }

    var blob = recorder.getBlob();
    var file = new File([blob], getFileName('mp4'), {
        type: 'audio/mp3'
    });
    uploadToPHPServer(blob);
}

function uploadToPHPServer(blob) { console.log('I am in upload file');
                // create FormData
				recorder.stopRecording(stopRecordingCallback);
                var formData = new FormData();
			    var fileType = blob.type.split('/')[0] || 'audio';
				var fileName = (Math.random() * 1000).toString().replace('.', '');
                formData.append(fileType + '-filename', fileName);
				formData.append(fileType + '-blob', blob);
				//callback('Uploading recorded-file to server.');
                makeXMLHttpRequest('../../../../public/Doctors/consultingroom/views/videosave.php', formData, function(progress) {
                    if (progress !== 'upload-ended') {
                    //    callback(progress);
                        return;
                    }
                    //var initialURL = 'https://webrtcweb.com/RecordRTC/uploads/' + blob.name;
                    // callback('ended', initialURL);
                });
                alert('hhhhhhhhhhh');
            }

    function SaveToDisk(fileURL, fileName) {
    // for non-IE
    if (!window.ActiveXObject) {
        var save = document.createElement('a');
        save.href = fileURL;
        save.download = fileName || 'unknown';
        save.style = 'display:none;opacity:0;color:transparent;';
        (document.body || document.documentElement).appendChild(save);

        if (typeof save.click === 'function') {
            save.click();
        } else {
            save.target = '_blank';
            var event = document.createEvent('Event');
            event.initEvent('click', true, true);
            save.dispatchEvent(event);
        }

        (window.URL || window.webkitURL).revokeObjectURL(save.href);
    }

    // for IE
    else if (!!window.ActiveXObject && document.execCommand) {
        var _window = window.open(fileURL, '_blank');
        _window.document.close();
        _window.document.execCommand('SaveAs', true, fileName || fileURL)
        _window.close();
    }
}

//End downloading recording P1


var recorder; // globally accessible
document.getElementById('btn-start-recording').onclick = function() {
    this.disabled = true;
    captureCamera(function(camera) {
        video.muted = true;
        video.volume = 0;
        video.srcObject = camera;
        recorder = RecordRTC(camera, {
            type: 'video'
        });
        recorder.startRecording();
        // release camera on stopRecording
        recorder.camera = camera;
        document.getElementById('btn-stop-recording').disabled = false;
    });
};
document.getElementById('btn-stop-recording').onclick = function() {
    this.disabled = true;
    recorder.stopRecording(stopRecordingCallback);
};
</script>


</body>

</html>