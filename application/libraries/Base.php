<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );


/**
 * 
 */
class Base extends CI_Controller
{
	// User session variables
	protected $token = '';
	protected $userRole = '';
	protected $userId = '';
	protected $id ='';
	


	/**
	 * Takes mixed data and optionally a status code, then creates the response
	 *
	 * @access public
	 * @param array|NULL $data
	 *        	Data to output to the user
	 *        	running the script; otherwise, exit
	 */
	public function response($data = NULL) {
		$this->output->set_status_header ( 200 )->set_content_type ( 'application/json', 'utf-8' )->set_output ( json_encode ( $data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) )->_display ();
		exit ();
	}

	/**
	 * This function used to check the user is logged in or not
	 */
	function isLoggedIn() {
		$isLoggedIn = $this->session->userdata ( 'isLoggedIn' );
		
		if (! isset ( $isLoggedIn ) || $isLoggedIn != TRUE) {
			redirect ( '' );
		} else {
			$this->datas();
		}
	}
	
	/**
     * This function used to load views
     * @param {string} $viewName : This is view name
     * @param {mixed} $headerInfo : This is array of header information
     * @param {mixed} $pageInfo : This is array of page information
     * @param {mixed} $footerInfo : This is array of footer information
     * @return {null} $result : null
     */
    function loadViews($viewName = "", $headerInfo = NULL, $pageInfo = NULL, $footerInfo = NULL){

        $this->load->view('includes/header', $headerInfo);
        $this->load->view($viewName, $pageInfo);
        $this->load->view('includes/footer', $footerInfo);
    }



	/**
	 * This function used to load user sessions
	 */
	function datas()
	{
		$this->token = $this->session->userdata ( 'token' );
		$this->userId = $this->session->userdata ( 'userId' );
		$this->userRole = $this->session->userdata ( 'userRole' );
		$this->id = $this->session->userdata('id');
		
		
		$this->global ['token'] = $this->token;
		$this->global ['userId'] = $this->userId;
		$this->global ['userRole'] = $this->userRole;
		//$this->global ['id'] = $this->$id;
	}


}
