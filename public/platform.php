<?php
include "public/layout/header.php";

if(isset($uiid) && $uiid = md5('1_pop')){}else{
include "public/layout/sidebar.php";
}
$activeinstitution = $session->get('activeinstitution');
$objfac = $engine->getFacilityDetails();
?>

<div id="main">
<?php
if(isset($uiid) && $uiid = md5('1_pop')){}else{
include "public/layout/notification.php";
echo '<div class="content-area">';
include "public/layout/topnote.php";
} ?>  
        <div class="content-body">
            <form name="myform" id="myform" method="post" action="#" data-toggle="validator" role="form" enctype="multipart/form-data" autocomplete="off">
                <input id="view" name="view" value="" type="hidden" />
                <input id="viewpage" name="viewpage" value="" type="hidden" />
                <input id="keys" name="keys" value="<?php echo (!empty($keys)?$keys:'') ;?>" type="hidden" />
                <input id="newkeys" name="newkeys" value="<?php echo $keys;?>" type="hidden" />
                <input id="data" name="data" value="" type="hidden" />
                <input id="action_search" name="action_search" value="" type="hidden" />
                <input id="microtime" name="microtime" value="<?php echo md5(microtime()); ?>" type="hidden" />
                <input type="hidden" name="grkeys" id="grkeys" value="<?php echo $string;?>" />
                <input type="hidden" name="datefrom" value="<?php echo $datefrom;?>" id="datefrom" />
                <input type="hidden" name="dateto" value="<?php echo $dateto; ?>" id="dateto"  />
				<input type="hidden" name="hewale_number" value="<?php echo $hewale_number;?>" id="hewale_number" />
               <input type="hidden" name="prescriber_name" value="<?php echo $prescriber_name;?>" id="prescriber_name" />
               <input type="hidden" name="patient_name" value="<?php echo $patient_name;?>" id="patient_name" />
               <input type="hidden" name="visitcode" value="<?php echo $visitcode;?>" id="visitcode" />
               <input type="hidden" name="labresult" value="" id="labresult" />
               <input id="agent_name" name="agent_name" value="<?php echo $agent_name;?>" type="hidden" />
                <?php
				$doctordetails = $doctors->getDoctorProfile($actordetails->USR_CODE);
				if($actordetails->USR_CHANGE_PASSWORD_STATUS == 0){
					include ("Setup/changepassword/platform.php");
				}/* elseif($actordetails->USR_TYPE == '2' && empty($doctordetails->MP_CONSULTATION_CHARGES)){
					  include ("Doctors/doctorsettings/platform.php");	  
                    } */
                    else{

                        
                    switch($pg){

                        

                        case md5('X-ray'):
                        
                           include ("X-ray/platform.php");
                        break;

                        case md5('forms'):
                            include ("forms/platform.php");
                        break;

                        /*
                        case md5('patient'):
                            include ("patientregistration/platform.php");
                        break;
                        */
						
						case md5('OPD'):
                            include ("OPD/platform.php");
                        break;
						case md5('IPD'):
                            include ("IPD/platform.php");
                        break;
						case md5('Records'):
                            include ("Records/platform.php");
                        break;
                        case md5('Setup'):
                   
						     include ("Setup/platform.php");
						break;  
                        case md5('Pharmacy'):
						     include ("Pharmacy/platform.php");
						break; 
						case md5('Laboratory'):
                            include ("Laboratory/platform.php");
                        break;
						
						case md5('Nurses Post'):
                            include ("OPD/platform.php");
                        break;
						case md5('Doctors'):
                            include ("Doctors/platform.php");
                        break;

                        case md5('Doctors Reports'):
                            include ("Doctors Reports/platform.php");
                        break;

						case md5('Bank'):
                            include ("Bank/platform.php");
                        break; 
						case md5('Wallet'):
                            include ("wallet/platform.php");
                        break; 
						case md5('Delivery'):
                            include ("Delivery/platform.php");
                        break;
						case md5('Stock'):
                            include ("Stock/platform.php");
                        break;
						
						case md5('hrm'):
                            include ("hrm/platform.php");
                        break;

                        case md5('Laboratory Reports'):
                            include ("Laboratory Reports/platform.php");
                        break;
						
						case md5('OPD Reports'):
                            include ("OPD Reports/platform.php");
                        break;
						
                        case md5('Pharmacy Reports'):
                            include ("Pharmacy Reports/platform.php");
                        break;
                       
                        

                        case md5('Nurse'):
                            include ("Nurse/platform.php");
                        break;

                        case md5('Ambulance'):
                            include ("Ambulance/platform.php");
                        break;
												
												case md5('Home Service'):
                            include ("Home Service/platform.php");
                        break;
                        
                        default:
                            include ("dashboard/platform.php");
                        break;
                    
                    }
                    
            }

                     
?>

<script>
function CallWindow(linkview) {
//var randomnumber = Math.floor((Math.random()*100)+1); 
 var winpop =  window.open(linkview,linkview,"toolbar=no,scrollbars=yes,resizable=yes,top=120,left=150,channelmode=1,location=0,menubar=0,status=no,titlebar=0,toolbar=0,modal=1,width=1450,height=670");
 
}

function CallSmallerWindow(linkview) {
//var randomnumber = Math.floor((Math.random()*100)+1); 
 var winpop =  window.open(linkview,linkview,"toolbar=no,scrollbars=yes,resizable=yes,top=160,left=245,channelmode=1,location=0,menubar=0,status=no,titlebar=0,toolbar=0,modal=1,width=1130,height=550");
 
}

function CallVideoWindow(linkview) {
//var randomnumber = Math.floor((Math.random()*100)+1); 
 var winpop =  window.open(linkview,linkview,"toolbar=no,scrollbars=yes,resizable=yes,top=120,left=105,channelmode=1,location=0,menubar=0,status=no,titlebar=0,toolbar=0,modal=1,width=630,height=650");
 
}
</script>
    
</form>
        
        </div>
    </div>
</div>

<script>

    

</script>



<?php include 'public/layout/footer.php';?>