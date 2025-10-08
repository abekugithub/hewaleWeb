<?php
//Partial class attribution: Original PHP code by Chirp Internet: www.chirp.com.au
class cryptCls {

	private $key;
	private $iv;
	private $tag;	
	protected $cipher = 'AES-128-CTR'; // default
  
	protected function iv_bytes()
	{
	  return openssl_cipher_iv_length($this->cipher);
	}

	public function __construct(){
		//$this->config = new JConfig();
		$this->key = openssl_digest('haveuseenanackedmadmanbefore','sha256',true);	
			
	}//End Function
	
	public function encrypt($data)
	{
	  $iv = openssl_random_pseudo_bytes($this->iv_bytes());
	  $encrypted_string = bin2hex($iv) . openssl_encrypt($data, $this->cipher, $this->key, 0, $iv);
	  return $encrypted_string;
	}
  
	// decrypt encrypted string
	public function decrypt($data)
	{
	  $iv_strlen = 2  * $this->iv_bytes();
	  if(preg_match("/^(.{" . $iv_strlen . "})(.+)$/", $data, $regs)) {
		list(, $iv, $crypted_string) = $regs;
		$decrypted_string = openssl_decrypt($crypted_string, $this->cipher, $this->key, 0, hex2bin($iv));
		return $decrypted_string;
	  } else {
		return false;
	  }
	}
  
	
	public function Mhash(){
		$this->key = sha1("RAC-1".$this->config->secret,TRUE);
	}//End Function
	
	public function loginPassword($username,$password){
		$pepper = "$@&&%***TDOR)){987}[]";
		$salt = $username;
		return  hash("sha256",$pepper.$password.$salt,false);
	}
	
	public function checkPassword($pwd, &$errors) {
		$errors_init = $errors;
	
		if (strlen($pwd) < 8) {
			$errors[] = "Password too short!";
		}
	
		if (!preg_match("#[0-9]+#", $pwd)) {
			$errors[] = "Password must include at least one number!";
		}
	
		if (!preg_match("#[a-zA-Z]+#", $pwd)) {
			$errors[] = "Password must include at least one letter!";
		}
	
		return ($errors == $errors_init);
	}

	

}//End Class
?>
