<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of importClass
 *
 * @author orcons systems
 */
class importClass  extends engineClass{
    //put your code here
    function  __construct() {
        parent::__construct();
    }

    public function uploadImage($file,$destination){
        if(is_uploaded_file($file['tmp_name']) && $file['error'] == 0){
        $ext = array('image/pjpeg','image/jpeg','image/jpg','image/png','image/x-png','image/gif','application/octet-stream');
	$rand_numb = md5(uniqid(microtime()));
	$neu_name = $rand_numb.$file['name'];
	$_name_ = $file['name'];
	$_type_ = $file['type'];
	$_tmp_name_ = $file['tmp_name'];
	$_size_ = $file['size'] / 1024;
	
	if(in_array($_type_,$ext)){ // echo $destination.$neu_name;
        if(@move_uploaded_file($_tmp_name_,$destination.$neu_name))
	{ 
		return $neu_name;
            }else{
                return false;
            }
        }else{
            return false;
        }
            }else{
                return false;
            }
    }//end

    public function uploadExcel($file){
        if(is_uploaded_file($file['tmp_name']) && $file['error'] == 0){
        $ext = array('application/vnd.ms-excel','application/msexcel');
	$rand_numb = md5(uniqid(microtime()));
	$neu_name = $rand_numb.$file['name'];
	$_name_ = $file['name'];
	$_type_ = $file['type'];
	$_tmp_name_ = $file['tmp_name'];
	$_size_ = $file['size'] / 1024;

	if(in_array($_type_,$ext)){
        if(@move_uploaded_file($_tmp_name_,SPATH_UPLOADED.$neu_name))
	{
		return $neu_name;
            }else{
                return false;
            }
        }else{
            return false;
        }
            }else{
                return false;
            }
    }//end


    /**
     * @param $file
     * @param $temporarylocation
     * @return bool|string
     */
    public function remoteTransfer($file,$temporarylocation){
        $temporaryname=$this->uploadImage($file,$temporarylocation);
//        print_r($temporarylocation.$temporaryname);
        $templocation=$temporarylocation.$temporaryname;
        $remotelocation=SHOST_FTP_PATIENTPHOTO.$temporaryname;
        $connect = ftp_connect('192.168.15.25');  //connect to ftp server
        $login = ftp_login($connect, 'socialhealth', 'space123');   //ftp server login
        if($login)
        {
            if(ftp_put($connect,$remotelocation,$templocation, FTP_BINARY))
            {
                unlink($templocation);
                return $temporaryname;
            }else{
                return false;
            }
            ftp_close($connect);
        } else{
            return false;
        }
    }
}
?>
