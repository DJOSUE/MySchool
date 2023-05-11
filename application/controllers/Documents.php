<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
    
class Documents extends EduAppGT
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

    //Check id has a session.
    function isLogin()
    {
        $array      = ['admin', 'teacher', 'student', 'parent', 'accountant', 'librarian'];
        $login_type = get_account_type();
        
        if (!in_array($login_type, $array))
        {
            redirect(base_url(), 'refresh');
        }
    }

    function student_document($action = 'upload', $student_id, $param1 = '')
    {
        $this->isLogin();

        $document_id = base64_decode($param1);

        switch ($action) {
            case 'upload':
                $this->document->create_student_document($student_id);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                break;
            case 'delete':
                $this->document->delete_student_document($document_id);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));            
                break;
        }
        

        redirect(base_url() . 'admin/student_print_documents/'.$student_id, 'refresh');
    }
}