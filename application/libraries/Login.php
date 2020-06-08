<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


 /**
  * 
  */
class Login
{
 	public function __construct() {
        //$login = new Login();
        $CI =& get_instance();
        //$CI->login = $login;
        //  Calling cURL Library
		//$this->load->library('curl');
		//$this->load->helper('string');
    }

 	public function postLogin()
 	{
 		//Prepare you post parameters
		$postData = array(
		    'UserName' => $UserName,
		    'Password' => $Password,
		);

 		
 		$token = random_string('string');

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://api.bluecollarhub.com.ng/api/Account/Login",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 60,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS =>$data,
		  CURLOPT_HTTPHEADER => array(
		    "Content-Type: application/json",
		    "Authorization: Basic " .$token
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		//echo $response;
	}
}