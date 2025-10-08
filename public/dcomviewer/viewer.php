<?php
ob_start();
include('../../config.php');



if(isset($visitcode) && !empty($visitcode) && !empty($keys)){
	  $stmt = $sql->Execute($sql->Prepare("SELECT XTMI_FILENAME FROM hms_patient_xraytest_files WHERE XTMI_VISITCODE = ".$sql->Param('a')." AND XTMI_LTCODE = ".$sql->Param('a')),array($visitcode,$keys));
	   if ($stmt){
			  $obj = $stmt->FetchNextObject();
			  $labfile_name = $obj->XTMI_FILENAME;
			  
	   }

}
?>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    
    	<!-- iOS meta tags -->
    	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"/>
    	<meta name="apple-mobile-web-app-capable" content="yes">
    	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    
    	<link rel="stylesheet" type="text/css" href="papaya.css?build=1435" />
    	<script type="text/javascript" src="papaya.js?build=1435"></script>
    
    	<title>Papaya Viewer</title>
    
		<style>
			img{
			    width: 100%;
			}

			.download_btn{
				text-decoration: none;
				border: 1px solid #24a2d6;
				color: #24a2d6;
				margin: 1em !important;
				padding: 0.6em 1.5em;
				border-radius: 9px;
			}
		</style>


    	<!--<script type="text/javascript">
var params = [];
</script>-->
    <script type="text/javascript">
        var params = [];
        params["worldSpace"] = true;
		 params["images"] = ["../../media/uploaded/xrayresult/<?php echo $labfile_name ;?>"];
		// params["images"] = ["data/US-MONO2-8-8x-execho","data/CR-MONO1-10-chest"];
       <!-- params["images"] = ["data/myBaseImage.nii.gz", "data/myOverlayImage.nii.gz"]; -->
       /* params["surfaces"] = ["data/mySurface.surf.gii"];*/
        params["myOverlayImage.nii.gz"] = {"min": 4, "max": 10};
    </script>

	


	</head>

	<body style="background: white;">

		<?php

			if(file_exists('../../media/uploaded/xrayresult/'.$labfile_name) && in_array( exif_imagetype('../../media/uploaded/xrayresult/'.$labfile_name) , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP)))
			{
		?>

			<img src="../../media/uploaded/xrayresult/<?php echo $labfile_name ;?>" alt="">
	
		<?php
			}else if (in_array(pathinfo($labfile_name, PATHINFO_EXTENSION), array('docx'))){
		?>

			<div style="text-align: center !important;">
				<img src="../../media/img/result.png" style="width: 25em;" alt="">
				<div>
					<a class="download_btn" href="<?php echo '../../media/download.php?filename='.$labfile_name; ?>"> Download Result</a>
				</div>
			</div>
			
		<?php
			// header("Location: ../../media/download.php?filename=".$labfile_name);
			}else{
		?>

			<div class="papaya" data-params="params"></div>
		
		<?php
			}
		?>
		
		
		
		
	</body>
</html>
