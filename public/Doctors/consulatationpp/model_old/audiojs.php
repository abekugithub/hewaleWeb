<script type="text/javascript">

			var fileType = 'audio'; // or "audio"
			var fileName = 'ABCDEF.wav';  // or "wav"
			
			var formData = new FormData();
			formData.append(fileType + '-filename', fileName);
			formData.append(fileType + '-blob', blob);
			
			xhr('audiosave.php', formData, function (fName) {
			    window.open(location.href + fName);
			});
			
			function xhr(url, data, callback) {
			    var request = new XMLHttpRequest();
			    request.onreadystatechange = function () {
			        if (request.readyState == 4 && request.status == 200) {
			            callback(location.href + request.responseText);
			        }
			    };
			    request.open('POST', url);
			    request.send(data);
			}
	</script>