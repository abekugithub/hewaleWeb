<?php
include 'controller.php';
$engine = new EngineClass();
switch($view){
	
	case 'add_new':
		include 'views/add.php';
	break;
	
	case 'edit':
		include 'views/edit.php';
	break;
	
	case 'details':
		include 'views/details.php';
	break;
	
	default:
		include 'views/list.php';
	break;
}

?>