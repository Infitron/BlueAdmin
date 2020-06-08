<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Login extends CI_Controller 
{
	protected $token = '';
	protected $userRole = '';
	protected $userId = '';



    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        //$this->load->library('curl');
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $this->load->view('login');
    }


    function postLogin()
    {
    	$this->load->library('form_validation');
        
        $this->form_validation->set_rules('UserName', 'Email', 'required|valid_email|max_length[128]|trim');
        $this->form_validation->set_rules('Password', 'Password', 'required');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->index();
        }
        else
        {
            /*$UserName = $this->security->xss_clean($this->input->post('UserName'));
            $Password = $this->input->post('Password');*/

            $postData = array(
                'UserName' => $this->input->post('UserName', TRUE),
                'Password' => $this->input->post('Password', TRUE),
            );
            
            //Prepare you post parameters
			/*$postData = array(
			    'UserName' => $UserName,
			    'Password' => $Password
			);*/

			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://api.bluecollarhub.com.ng/api/Account/Login",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS =>json_encode($postData),
			  CURLOPT_HTTPHEADER => array(
			    "Content-Type: application/json"
			  ),
			));

			$response = curl_exec($curl);

			if (curl_errno($curl))
		    {
		        print "Error: " . curl_error($curl);
		    }
		    else
		    {
		        // Show me the result

		        $result = json_decode($response, TRUE);

		        curl_close($curl);

		        $session_array = array(
	                'token'  => $result['token'],
	                'userId'  => $result['userId'],
	                'userRole'  => $result['userRole'],
	                'isLoggedIn'  => TRUE
	            );
		    }



		    if($result['userRole'] == "Admin")
            {                   
                $users = $this->session->set_userdata($session_array);

                $this->session->set_userdata('users',$session_array);

                $this->session->set_flashdata('user_loggedin', 'You are now lodded in');

                redirect('dashboard');
            }
            else 
            {
            	//$this->session->set_flashdata('error', 'Email address or password is incorrect');
                $this->session->set_flashdata('Error', 'Invalid Email/Password.');
                redirect('');
            }

		    //print_r($result);

		    //exit();
            
        }
    }
    

    /**
	 * This function used to check the user is logged in or not
	 */
	function isLoggedIn() {
		$isLoggedIn = $this->session->userdata ('isLoggedIn');
		
		if (! isset ( $isLoggedIn ) || $isLoggedIn != TRUE) {
			redirect ('');
		}
	} 


	/**
	 * This function is used to logged out user from system
	 */
	function logout() {

		$this->session->unset_userdata('isLoggedIn');
        $this->session->unset_userdata('userRole');
        $this->session->unset_userdata('userId');
        $this->session->unset_userdata('token');

        $this->session->sess_destroy();
		
		redirect ( '' );
	}


}