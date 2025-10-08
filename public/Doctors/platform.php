


<?php
    switch($option){
	
      case md5("Consultation"):
	  include("consulatationpp/platform.php");
	  break;
      case md5("Manage Schedule"):
	  include("manageschedule/platform.php");
	  break;
      case md5("Appointment"):
	  include("servicerequest/platform.php");
	  break;
	  case md5("Doctor Profile"):
	  include("doctorprofile/platform.php");
	  break;
	  case md5("My Patients"):
	  include("mypatient/platform.php");
	  break;
	  case md5("Medical History"):
	  include("medicalhistory/platform.php");
	  break;
	  case md5("My Settings"):
	  include("doctorsettings/platform.php");
	  break;
	  case md5("Patients Lab Result"):
	  include("patientslabresult/platform.php");
	  break;
		case md5("Patient Lab Results"):
	  include("patientslabresult/platform.php");
	  break;
	  case md5("Quick Consult"):
	  include("quickconsult/platform.php");
	  break;
	  case md5("My Wallet"):
	  include("wallet/platform.php");
	  break;
	  case md5("Patients X-Ray Result"):
	  include("patientsxrayresult/platform.php");
	  break;
		case md5("Patient X-Ray Results"):
	  include("patientsxrayresult/platform.php");
	  break;
	  case md5("Paediatric"):
	  include("paediatric/platform.php");
	  break;
	  case md5("Premium Service"):
	  include("premiumservice/platform.php");
	  break;
	  case md5("Request Nurse"):
	  include("requestnurse/platform.php");
	  break;
	  case md5("My Nurses"):
	  include("mynurses/platform.php");
	  break;
	  case md5("Consulting Room"):
	  include("consultingroom/platform.php");
	  break;
	  case md5("Conference Room"):
	  include("conferenceroom/platform.php");
	  break;
	  case md5("Go Social"):
	  include("gosocial/platform.php");
	  break;
	  case md5("Direct Call"):
	  include("directcall/platform.php");
	  break;
    }
?>