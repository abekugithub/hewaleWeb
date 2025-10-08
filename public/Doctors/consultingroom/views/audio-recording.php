<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">

<?php
/**
$recorder = file_get_contents('php://input');
$name = md5($recorder).'.wav';
$status = file_put_contents('recording/audiofiles/'.$name, $recorder);
if($status==TRUE){
	echo "Well Done";
}else{
	echo "Not Done";
}**/
?>
<hr>
<div><audio controls autoplay id="my-audio-id"></audio>
</div>
<button type ="button" id="btn-start-recording" class="btn btn-info">Start Recording</button>
<button type ="button" id="btn-stop-recording" disabled class="btn btn-secondary">Stop </button>
<button type ="button" id="btn-release-microphone" disabled class="btn btn-danger">Cancel</button>
<button type ="button" id="btn-download-recording" disabled class="btn btn-success" >Done</button>
<script type="text/javascript" src="../../../../media/js/adapter-latest.js"></script>
<script type="text/javascript" src="../../../../media/js/RecordRTC.js"></script>
<script>
var audio = document.querySelector('audio');

function captureMicrophone(callback) {
    btnReleaseMicrophone.disabled = false;

    if(microphone) {
        callback(microphone);
        return;
    }

    if(typeof navigator.mediaDevices === 'undefined' || !navigator.mediaDevices.getUserMedia) {
        alert('This browser does not supports WebRTC getUserMedia API.');

        if(!!navigator.getUserMedia) {
            alert('This browser seems supporting deprecated getUserMedia API.');
        }
    }

    navigator.mediaDevices.getUserMedia({
        audio: isEdge ? true : {
            echoCancellation: false
        }
    }).then(function(mic) {
        callback(mic);
    }).catch(function(error) {
        alert('Unable to capture your microphone. Please check console logs.');
        console.error(error);
    });
}

function replaceAudio(src) {
    var newAudio = document.createElement('audio');
    newAudio.controls = true;

    if(src) {
        newAudio.src = src;
    }
    
    var parentNode = audio.parentNode;
    parentNode.innerHTML = '';
    parentNode.appendChild(newAudio);

    audio = newAudio;
}

function stopRecordingCallback() {
    replaceAudio(URL.createObjectURL(recorder.getBlob()));

    btnStartRecording.disabled = false;

    setTimeout(function() {
        if(!audio.paused) return;

        setTimeout(function() {
            if(!audio.paused) return;
            audio.play();
        }, 1000);
        
        audio.play();
    }, 300);

    audio.play();

    btnDownloadRecording.disabled = false;

    if(isSafari) {
        click(btnReleaseMicrophone);
    }
}

var isEdge = navigator.userAgent.indexOf('Edge') !== -1 && (!!navigator.msSaveOrOpenBlob || !!navigator.msSaveBlob);
var isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);

var recorder; // globally accessible
var microphone;

var btnStartRecording = document.getElementById('btn-start-recording');
var btnStopRecording = document.getElementById('btn-stop-recording');
var btnReleaseMicrophone = document.querySelector('#btn-release-microphone');
var btnDownloadRecording = document.getElementById('btn-download-recording');

btnStartRecording.onclick = function() {
    this.disabled = true;
    this.style.border = '';
    this.style.fontSize = '';
   // btnDownloadRecording.disabled =true;

    if (!microphone) {
        captureMicrophone(function(mic) {
            microphone = mic;

            if(isSafari) {
                replaceAudio();

                audio.muted = true;
                setSrcObject(microphone, audio);
                audio.play();

                btnStartRecording.disabled = false;
                btnStartRecording.style.border = '1px solid red';
                btnStartRecording.style.fontSize = '150%';

                alert('Please click startRecording button again. First time we tried to access your microphone. Now we will record it.');
                return;
            }

            click(btnStartRecording);
        });
        return;
    }

    replaceAudio();

    audio.muted = true;
    setSrcObject(microphone, audio);
    audio.play();

    var options = {
        type: 'audio',
        numberOfAudioChannels: isEdge ? 1 : 2,
        checkForInactiveTracks: true,
        bufferSize: 16384
    };

    if(navigator.platform && navigator.platform.toString().toLowerCase().indexOf('win') === -1) {
        options.sampleRate = 48000; // or 44100 or remove this line for default
    }

    if(recorder) {
        recorder.destroy();
        recorder = null;
    }

    recorder = RecordRTC(microphone, options);

    recorder.startRecording();

    btnStopRecording.disabled = false;
    btnDownloadRecording.disabled = true;
};

btnStopRecording.onclick = function() {
    this.disabled = true;
    recorder.stopRecording(stopRecordingCallback);
    if(microphone) {
        microphone.stop();
        microphone = null;
    }
};

btnReleaseMicrophone.onclick = function() {
    this.disabled = true;
    btnStartRecording.disabled = false;
    btnDownloadRecording.disabled =true;

    if(microphone) {
        microphone.stop();
        microphone = null;
    }

    if(recorder) {
        // click(btnStopRecording);
    }
};

btnDownloadRecording.onclick = function() {
	btnStartRecording.disabled=true;
    this.disabled = true;
    if(!recorder || !recorder.getBlob()) return;

    if(isSafari) {
        recorder.getDataURL(function(dataURL) {
            SaveToDisk(dataURL, getFileName('mp3'));
        });
        return;
    }

    var blob = recorder.getBlob();
    var file = new File([blob], getFileName('mp3'), {
        type: 'audio/mp3'
    });
	uploadToPHPServer(blob);

};

function click(el) {
    el.disabled = false; // make sure that element is not disabled
    var evt = document.createEvent('Event');
    evt.initEvent('click', true, true);
    el.dispatchEvent(evt);
}

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
function uploadToPHPServer(blob) {
                // create FormData
				recorder.stopRecording(stopRecordingCallback);
                var formData = new FormData();
			    var fileType = blob.type.split('/')[0] || 'audio';
				var fileName = (Math.random() * 1000).toString().replace('.', '');
                formData.append(fileType + '-filename', fileName);
				formData.append(fileType + '-blob', blob);
				//callback('Uploading recorded-file to server.');
                makeXMLHttpRequest('../../../../public/Doctors/consultingroom/views/audiosave.php', formData, function(progress) {
                    if (progress !== 'upload-ended') {
                    //    callback(progress);
                        return;
                    }
                    //var initialURL = 'https://webrtcweb.com/RecordRTC/uploads/' + blob.name;
                  //  callback('ended', initialURL);
                });
            }
			
 function makeXMLHttpRequest(url, data, callback) {
                var request = new XMLHttpRequest();
                request.onreadystatechange = function() {
                    if (request.readyState == 4 && request.status == 200) {
                        if (request.responseText === 'success') {
                            callback('upload-ended');
                            return;
                        }
                        alert(request.responseText);
                        return;
                    }
                };
                request.upload.onloadstart = function() {
                    callback('PHP upload started...');
                };
                request.upload.onprogress = function(event) {
                    callback('PHP upload Progress ' + Math.round(event.loaded / event.total * 100) + "%");
                };
                request.upload.onload = function() {
                    callback('progress-about-to-end');
                };
                request.upload.onload = function() {
                    callback('PHP upload ended. Getting file URL.');
                };
                request.upload.onerror = function(error) {
                    callback('PHP upload failed.');
                };
                request.upload.onabort = function(error) {
                    callback('PHP upload aborted.');
                };
                request.open('POST', url);
                request.send(data);
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
</script>
