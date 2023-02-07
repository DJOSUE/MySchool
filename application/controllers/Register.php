<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Register extends EduAppGT 
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
        $this->load->model('crud');
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
        if($this->db->get_where('settings', array('type' => 'register'))->row()->description == 0)
        {
            redirect(base_url(), 'refresh');
        }else{
            $this->load->view('backend/register');
        }
    }

    //Verify if username not exist in the database function.
    function search_user() 
    {
        echo $this->crud->checkPublicUsername();
    }
    
    function search_email() 
    {
        echo $this->user->checkPublicEmail();
    }

    function applicant()
    {
        $this->load->view('backend/register_applicant');
    }
    

    //Create account function.
    function create_account($param1 = '')
    {
        if($param1 == 'teacher')
        {
            $this->user->createPublicTeacherAccount();
            $this->session->set_flashdata('flash_message' ,getPhrase('account_has_been_created_but_require_approval'));
            redirect(base_url() . 'register', 'refresh');
        }
        if($param1 == 'student')
        {
            $this->user->createPublicStudentAccount();
            $this->session->set_flashdata('flash_message' ,getPhrase('account_has_been_created_but_require_approval'));
            redirect(base_url() . 'register', 'refresh');
        }
        if($param1 == 'parent')
        {
            $this->user->createPublicParentAccount();
            $this->session->set_flashdata('flash_message' ,getPhrase('account_has_been_created_but_require_approval'));
            redirect(base_url() . 'register', 'refresh');
        }
    }
    
    //End of Register.php
}