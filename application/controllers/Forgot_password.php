<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Forgot_password extends EduAppGT 
{
    /*
        Software:       MySchool - School Management System
        Author:         DHCoder - Software, Web and Mobile developer.
        Author URI:     https://dhcoder.com
        PHP:            5.6+
        Created:        22 September 2021.
        Base:           EduAppGT
    */
    
    function __construct() 
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 2010 05:00:00 GMT");
    }

    //Index function.
    public function index() 
    {
        $this->load->view('backend/forgot_password');
    }

    //View create a New password
    function new_password($token = "", $type_user = "")
    {
        $page_data['token']  = $token;
        $page_data['type_user']  = $type_user;
        $page_data['page_title'] = getPhrase('set_new_password');
        $this->load->view('backend/new_password', $page_data);
    }

    //Process to update new password
    function set_new_password($token = "", $type_user = "")
    {
        $table = base64_decode($type_user);
        $password = sha1($this->input->post('password'));

        $user = $this->db->get_where($table, array('password_token' => $token))->row();
        $user_id = 0;

        switch ($table) {
            case 'admin':
                $user_id = $user->admin_id;
                break;
            case 'teacher':
                $user_id = $user->teacher_id;
                break;
            case 'student':
                $user_id = $user->student_id;
                break;
            case 'parent':
                $user_id = $user->parent_id;
                break;
            case 'accountant':
                $user_id = $user->accountant_id;
                break;
            case 'librarian':
                $user_id = $user->librarian_id;
                break;
            default:
                $this->session->set_flashdata('error_new_password', 1);
                redirect( base_url(), 'refresh' );
                break;
        }

        if($user_id == 0)
        {
            $this->session->set_flashdata('error_new_password', 1);
            redirect( base_url(), 'refresh' );
        }
        else
        {
            $this->user->updatePasswordUser($table, $password, $user_id);
            $this->session->set_flashdata('success_new_password', '1');
        }
        
        redirect(base_url(), 'refresh'); 
    }
    
    //End of Forgot_password.php
}