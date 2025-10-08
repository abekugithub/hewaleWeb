<?php
/*
 * This class is designed to upload documents from the consumer reference system
 * Author: Ake 
 */
class upload extends engineClass{
	   
	   function __construct(){
		   parent::__construct();
		   }

/* 
 * @params file = the name of the file input field name. this is compulsory
 * optional params are...
 * @params neu_name = the new file name
 * @params size = the file size limit you want to enforce */
 


public function attachfile($file,$neu_name="-1",$size="-1"){
	
	$format_types = array("application/vnd.openxmlformats-officedocument.wordprocessingml.document","application/pdf");
	$uploadit = $uploadpass_size = $uploadpass_type = true;
	$target_dir = ATTACH_LABRESULT;
	$neu_name = ($neu_name == "-1")?basename($_FILES[$file]["name"]):$neu_name;
	$ext = explode('.', $neu_name);//explode file name from dot(.) 
        $file_extension = end($ext); //store extensions in the variable
       		$filename= md5($_FILES['file']['name']) . "." . $ext[1];
			//$target_file = $target_dir.DS.$neu_name;
			$target_file = $target_dir.DS.$filename;	
	//check file exits
	if (!file_exists($target_file)) {
		$uploadit = true;
	} else {		
		//$uploadit = false;
	}
	
	//check file size	
	if ($size != "-1" && $_FILES[$file]["size"] > $size) {
			$uploadpass_size = false;
		}
	
	//check format	
	if(!in_array($_FILES[$file]["type"],$format_types)){
		$uploadpass_type = false;
	}
	if($uploadit && $uploadpass_size && $uploadpass_type){
		 
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	if (move_uploaded_file($_FILES[$file]["tmp_name"], $target_file)) {
	
		return $filename; //$neu_name;
	} else {
		return $_FILES[file]["error"];
	}
	}else{
		return false;
	}
}



public function attachfilescans($file,$neu_name="-1",$size="-1"){
	
	$format_types = array("application/vnd.openxmlformats-officedocument.wordprocessingml.document","application/pdf");
	$uploadit = $uploadpass_size = $uploadpass_type = true;
	$target_dir = ATTACH_SCANRESULT;
	$neu_name = ($neu_name == "-1")?basename($_FILES[$file]["name"]):$neu_name;
	$ext = explode('.', $neu_name);//explode file name from dot(.) 
        $file_extension = end($ext); //store extensions in the variable
       		$filename= md5($_FILES['file']['name']) . "." . $ext[1];
			//$target_file = $target_dir.DS.$neu_name;
			$target_file = $target_dir.DS.$filename;	
	//check file exits
	if (!file_exists($target_file)) {
		$uploadit = true;
	} else {		
		//$uploadit = false;
	}
	
	//check file size	
	if ($size != "-1" && $_FILES[$file]["size"] > $size) {
			$uploadpass_size = false;
		}
	
	//check format	
	if(!in_array($_FILES[$file]["type"],$format_types)){
		$uploadpass_type = false;
	}
	if($uploadit && $uploadpass_size && $uploadpass_type){
		 
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	if (move_uploaded_file($_FILES[$file]["tmp_name"], $target_file)) {
	
		return $filename; //$neu_name;
	} else {
		return $_FILES[file]["error"];
	}
	}else{
		return false;
	}
}
	
}
?>