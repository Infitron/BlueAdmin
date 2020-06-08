<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/Base.php';

/**
 * Class : User (UserControllerAPI)
 * User Class to control all user related operations.
 * @author : TechySmart360.com / support@techysmart360.com
 * @version : 2.0
 * @since : 06.03.2020
 */

class Admin extends Base
{
	//$login = new Login();
    

    //$tokes = $this->session->tokes;

	public function __construct()
    {
        parent::__construct();
        $this->load->library('rest_api');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->isLoggedIn();

        $token = $this->session->userdata('token');
        //getArticle($token, 1);
    }


	/**
     * This function used to load the first screen of the user
    */
	function dashboard()
 	{
 		
	 	$this->global['pageTitle'] = 'CollarHub : Dashboard';

	    $this->loadViews("index", $this->global, NULL);
 	}


 	function allUsers()
 	{
        
		$this->global['pageTitle'] = 'CollarHub : All Users';
		
		$this->loadViews("allUsers", $this->global, NULL);
 	}

 	/**
     * This function is used load user edit information
     * @param number $userId : Optional : This is user id
    */
    function editUser($userId = NULL)
    {
        if($userId == null)
        {
            redirect('allUsers');
        }

        $curl = curl_init();

        //$token = $this->session->userdata('token');

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.bluecollarhub.com.ng/api/v1.1/Account/AllUser?id=".$userId,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 60,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "content-type: application/json",
            "authorization: Bearer ".$this->session->userdata('token')
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

            $user = json_decode($response, TRUE);

            curl_close($curl);
        }
                
        $result['message'] = $user;
        //print_r($result);
        //exit();

        $this->global['pageTitle'] = 'CollarHub : Edit User';
            
        $this->loadViews("editUser", $this->global, $result, NULL);
    }

    /*
     * This method is to update user details
    */
    function updateUser()
    {
        $UserId = $this->input->post('UserId');

        $this->form_validation->set_rules('StatusId','Status','required|numeric');

        if($this->form_validation->run() == FALSE)
        {
            $this->editUser($UserId);
        }
        else
        {
            // User account info
            $userInfo = array(
                'UserId' => $this->input->post('UserId', TRUE),
                'StatusId' => $this->input->post('StatusId', TRUE),
            );

            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://api.bluecollarhub.com.ng/api/v1.1/Account/UpdateStatus/",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "PUT",
              CURLOPT_POSTFIELDS =>json_encode($userInfo),
              CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer ".$this->session->userdata('token'),
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
            }

            if($result > 0)
            {
                $this->session->set_flashdata('success', 'User updated successfully');
            }
            else
            {
                $this->session->set_flashdata('error', 'User update failed');
            }                
            redirect('allUsers');
        }
    }

    /*
     * print all users details
    */
    function export_users()
    {
        $this->load->library("excel");

        $object = new PHPExcel();

        $object->setActiveSheetIndex(0);

        $table_columns = array("Username", "User Role", "Email Address", "Date Registered", "User Status");

        $column = 0;

        foreach($table_columns as $field)
        {
            $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
            $column++;
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.bluecollarhub.com.ng/api/v1.1/Account/AllUser/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer ".$this->session->userdata('token')
            ),
        ));
        $response = curl_exec($curl);

        curl_close($curl);
        //echo $response;

        $excel_row = 2;

        foreach($response as $row)
        {
            $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->username);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->userRole);
            $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->emailAddress);
            //$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->account);
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->dateRegisterd);
            $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->status);
            //$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->name);
            $excel_row++;
        }

        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Users List Data.xls"');
        $object_writer->save('php://output');       
    }


 	function articles()
 	{
 		$this->global['pageTitle'] = 'CollarHub : All Users';
 		
        $this->loadViews("articles", $this->global, NULL);
 	}


 	/**
     * This function is used load user edit information
     * @param number $userId : Optional : This is user id
    */
    function editArticle($id = NULL)
    {
        if($id == null)
        {
            redirect('articles');
        }      
        
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://api.bluecollarhub.com.ng/api/v1/Article/".$id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer ".$this->session->userdata('token')
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
            $article = json_decode($response, TRUE);

            curl_close($curl);
        }
        
        $result['message'] = $article;

        //$data['test'] = $result;

        //print_r($result);
        //exit();

        $this->global['pageTitle'] = 'CollarHub : Edit User';
            
        $this->loadViews("editArticle", $this->global, $result, NULL);
    }

    function updateArticle()
    {
        $this->load->library('form_validation');

        $id = $this->input->post('id');

        $this->form_validation->set_rules('articleBody','Description','trim|required');
        $this->form_validation->set_rules('ApprovalStatusId','Article Status','required|numeric');

        if($this->form_validation->run() == FALSE)
        {
            $this->editArticle($id);
        }
        else
        {
            // User account info
            $articleData = array(
                'id' => $this->input->post('id', TRUE),
                'articleBody' => $this->input->post('articleBody', TRUE),
                'ApprovalStatusId' => $this->input->post('ApprovalStatusId', TRUE),
            );

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://api.bluecollarhub.com.ng/api/v1/Article/".$id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "PUT",
                CURLOPT_POSTFIELDS =>json_encode($articleData),
                CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer ".$this->session->userdata('token'),
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
            }

            if($result > 0)
            {
                $this->session->set_flashdata('success', 'Article updated successfully');
            }
            else
            {
                $this->session->set_flashdata('error', 'Article update failed');
            }
                
            redirect('articles');
        }
    }

    function bookings()
    {

        $this->global['pageTitle'] = 'CollarHub : All Booking';
            
        $this->loadViews("bookings", $this->global, NULL);
    }
 	

    function project()
    {

        $this->global['pageTitle'] = 'CollarHub : Project';
            
        $this->loadViews("projects", $this->global, NULL);
    }

    // Test new artisan
    function newArtisan()
    {
        $this->global['pageTitle'] = 'CollarHub : Project';
            
        $this->loadViews("new_artisan", $this->global, NULL);
    }

    function addArtisan()
    {
        $this->load->library('form_validation');

        $UserId = $this->input->post('UserId');

        $this->form_validation->set_rules('FirstName','First Name','trim|required');
        $this->form_validation->set_rules('LastName','Last Name','required');
        $this->form_validation->set_rules('PhoneNumber','Phone Number','trim|required');
        $this->form_validation->set_rules('AreaLocationId','Area Location','required|numeric');
        $this->form_validation->set_rules('IdcardNo','Id cardNo','trim|required');
        $this->form_validation->set_rules('Address','Address','required');
        $this->form_validation->set_rules('ArtisanCategoryId','ArtisanCategoryId','required|numeric');
        $this->form_validation->set_rules('State','State','required');
        $this->form_validation->set_rules('AboutMe','About Me','required');

        if($this->form_validation->run() == FALSE)
        {
            $this->newArtisan();
        }
        else
        {
            // User account info
            $artisanData = array(
                'UserId' => $this->input->post('UserId', TRUE),
                'FirstName' => $this->input->post('FirstName', TRUE),
                'LastName' => $this->input->post('LastName', TRUE),
                'PhoneNumber' => $this->input->post('PhoneNumber', TRUE),
                'AreaLocationId' => $this->input->post('AreaLocationId', TRUE),
                'IdcardNo' => $this->input->post('IdcardNo', TRUE),
                'Address' => $this->input->post('Address', TRUE),
                'ArtisanCategoryId' => $this->input->post('ArtisanCategoryId', TRUE),
                'AreaLocationId' => $this->input->post('AreaLocationId', TRUE),
                'State' => $this->input->post('State', TRUE),
                'AboutMe' => $this->input->post('AboutMe', TRUE),
                'PicturePath' => $this->input->post('PicturePath', TRUE),
            );
            //print_r($artisanData);
            //exit();

            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://api.bluecollarhub.com.ng/api/v1/artisan",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS =>json_encode($artisanData),
              CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer ".$this->session->userdata('token'),
                "Content-Type: application/json"
              ),
            ));
            $response = curl_exec($curl);

            curl_close($curl);
            //echo $response;

            //exit();

            if($response > 0)
            {
                $this->session->set_flashdata('success', 'Artisan updated successfully');
            }
            else
            {
                $this->session->set_flashdata('error', 'Artisan update failed');
            }
                
            redirect('newArtisan');
        }
    }


}