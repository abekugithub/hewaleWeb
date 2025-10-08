<?php
    switch($option){
	
      case md5("Job Categories"):
	  include("jobcategories/platform.php");
	  break;
	  
	  case md5("Salary Component"):
	  include("salarycomponent/platform.php");
	  break;
	  
	  case md5("Staff Management"):
	  include("staffmanagement/platform.php");
	  break;
	  
	  case md5("Pay Grade"):
	  include("paygrade/platform.php");
	  break;
	  
	  case md5("Leave Type"):
	  include("leavetype/platform.php");
	  break;
	  
	  case md5("Leave Request"):
	  include("leaverequest/platform.php");
	  break;
	  
	  case md5("Approve Leave"):
	  include("leaveapproval/platform.php");
	  break;
	  
	  case md5("Disciplinary Config"):
	  include("disciplineconfig/platform.php");
	  break;
	  
	  case md5("Disciplinary Cases"):
	  include("disciplinecases/platform.php");
	  break;
      
    }
?>