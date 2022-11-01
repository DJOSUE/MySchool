<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

    
require APPPATH . '/libraries/TokenHandler.php';
require APPPATH . 'libraries/REST_Controller.php';

class Api extends REST_Controller
{
    /*
        Software:       MySchool - School Management System
        Author:         DHCoder - Software, Web and Mobile developer.
        Author URI:     https://dhcoder.com
        PHP:            5.6+
        Created:        22 September 2021.
        Base:           EduAppGT
    */

    protected $token;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        // creating object of TokenHandler class at first
        $this->tokenHandler = new TokenHandler();
        header('Content-Type: application/json');
    }


    // Login Api
    public function login_post()
    {
        
        $auth_token = $this->post('auth_token'); // $_GET['auth_token'];
        $username = $this->post('username'); 
        $password = $this->post('password'); 
        

        if(DEFAULT_GUID == $auth_token)
        {
            $userdata = $this->apiModel->login_get($username, $password);

            if ($userdata['validity'] == 1) 
            {
                $userdata['token'] = $this->tokenHandler->GenerateToken($userdata);
                return $this->set_response($userdata, REST_Controller::HTTP_OK);
            }
            else
            {
                return $this->set_response($userdata, REST_Controller::HTTP_UNAUTHORIZED);
            }
            
        }
        else
        {
            $data['error'] = "Invalid token";
            return $this->set_response($data, REST_Controller::HTTP_UNAUTHORIZED);
        }
        
    }

    //////// get data from token ////////////
    public function GetTokenData()
    {
        $received_Token = $this->input->request_headers('Authorization');
        if (isset($received_Token['Token'])) 
        {
            try
            {
                $jwtData = $this->tokenHandler->DecodeToken($received_Token['Token']);
                return json_encode($jwtData);
            }
            catch (Exception $e)
            {
                http_response_code('401');
                echo json_encode(array( "status" => false, "message" => $e->getMessage()));
                exit;
            }
        }
        else
        {
            echo json_encode(array( "status" => false, "message" => "Invalid Token"));
        }
    }

    public function token_data_get($auth_token)
    {
        //$received_Token = $this->input->request_headers('Authorization');
        if (isset($auth_token))
        {
            try
            {
                $jwtData = $this->tokenHandler->DecodeToken($auth_token);
                return json_encode($jwtData);
            }
            catch (Exception $e)
            {
                echo 'catch';
                http_response_code('401');
                echo json_encode(array( "status" => false, "message" => $e->getMessage()));
                exit;
            }
        }
        else
        {
            echo json_encode(array( "status" => false, "message" => "Invalid Token"));
        }
    }
}