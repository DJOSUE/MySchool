<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
    
    class UploadController extends EduAppGT
    {
        /*
            Software:       MySchool - School Management System
            Author:         DHCoder - Software, Web and Mobile developer.
            Author URI:     https://dhcoder.com
            PHP:            5.6+
            Created:        22 September 2021.
        */

        function __construct()
        {
            parent::__construct();
            $this->load->database();
            $this->load->library('session');
            $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
            $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
            $this->output->set_header('Pragma: no-cache');
            $this->output->set_header("Expires: Mon, 26 Jul 2023 05:00:00 GMT");

        }

        //Index function for Admin controller.
        function index()
        {
            $this->isLogin();
        }


        
        function upload_agreements()
        {
            $this->isLogin();
            
            $page_data['page_name']     = 'upload_agreements';
            $page_data['page_title']    =  getPhrase('upload_agreements');
            $this->load->view('backend/upload/index', $page_data);
        }

        function upload_bulk($type = "")
        {
            $result = "";

            switch ($type) {
                case 'agreements':
                    $result = $this->UploadBulk->agreements_bulk();

                    break;
                
                default:
                    # code...
                    break;
            }

            $this->session->set_flashdata('flash_message' , $result);
            redirect(base_url() . 'UploadController/upload_agreements/', 'refresh');

        }

        //Check user is login session.
        function isLogin()
        {
            $array      = ['admin', 'teacher', 'student', 'parent', 'accountant', 'librarian'];
            $login_type = $this->session->userdata('login_type');
            
            if (!in_array($login_type, $array))
            {
                redirect(base_url(), 'refresh');
            }
        }

    }