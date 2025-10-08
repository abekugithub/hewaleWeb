<?php
ob_start();
include("../../../../config.php");
include(SPATH_LIBRARIES."/engine.Class.php");
$engine = new engineClass();


$stmt = $sql->Execute($sql->Prepare("SELECT * FROM hms_patient WHERE PATIENT_PATIENTNUM = ".$sql->Param('a').""),array($patientnum));
     print $sql->ErrorMsg();
            if ($stmt){
                $patient = $stmt->FetchNextObject();
				$patientphoto = SHOST_PASSPORT.$patient->PATIENT_IMAGE;
			}
?>
<html>
<head>
<link href="../../../../media/css/main.css" rel="stylesheet" type="text/css" media="all">
</head>

<body>
<div class="main-content">
    <div class="page-wrapper">
        <div class="page form">
            
            <div class="col-sm-2">
                <div class="id-photo">
                    <img src="<?php echo(($patientphoto))?$patientphoto:'media/img/avatar.png';?>" alt="" id="prevphoto" style="width:100% !important; margin:0px !important;">
                </div>
            </div>
            <div class="col-sm-10">
                             
                <div class="form-group">
                    <div class="col-sm-12 client-vitals">
                        <table class="table table-hover">
                       
                            <tbody>
                              <div class="form-group">
                             <div class="col-sm-12" style="font-size:16px">
                             
                               <?php echo $content; ?>
                               <br /><br />
                              
                               <?php
							    $type='excuseduty';
								$urls = '../../../../plugins/phpqrcode/php/qr_img.php?d='; 
                                $qrcodeindexs = 'hewale.net/socialhealth/public/qrcodeverification/qrverification.php?code='.$verifcode.'-'.$type;
								  
                                   echo "
                                   <?xml version='1.0' encoding='UTF-8' standalone='no'?>
                                   <svg
                                      xmlns='http://www.w3.org/2000/svg'
                                      xmlns:xlink='www.w3.org/1999/xlink'
                                      width='100%'
                                      height='100%'
                                      id='svg2'
                                      version='1.1'>
                                      <image width='150' height='150'
                                      xlink: href='$urls$qrcodeindexs&e=H&s=8'/>
                                     </svg>
                                     ";
                                 
							   
							   ?>
                              
                              
                            </div>
                           
                           
                        </div> 
                             
                            </tbody>
                        </table>    
                    </div>
                </div>

            </div>
            
        </div>
    </div>
</div>

</body>
</html>
