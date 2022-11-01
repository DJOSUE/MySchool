<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends EduAppGT 
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
        $this->output->set_header("Expires: Mon, 03 Jun 2022 05:00:00 GMT");
    }

    //Index and validation session function.
    public function index() 
    {

        if ($this->session->userdata('admin_login') == 1)
        {
            redirect(base_url() . 'admin/panel/', 'refresh');
        }
        if ($this->session->userdata('teacher_login') == 1)
        {
            redirect(base_url() . 'teacher/panel/', 'refresh');
        }
        if ($this->session->userdata('librarian_login') == 1)
        {
            redirect(base_url() . 'librarian/panel/', 'refresh');
        }
        if ($this->session->userdata('accountant_login') == 1)
        {
            redirect(base_url() . 'accountant/panel/', 'refresh');
        }
        if ($this->session->userdata('student_login') == 1)
        {
            redirect(base_url() . 'student/panel/', 'refresh');
        }
        if ($this->session->userdata('parent_login') == 1)
        {
            redirect(base_url() . 'parents/panel/', 'refresh');
        }
        $this->load->view('backend/login');
    }
    
    //Check login credentials and set it function.
    function auth() 
    {
        $username = html_escape($this->input->post('username'));
        $password = html_escape($this->input->post('password'));
        $credential = array('username' => $username, 'password' => sha1($password), 'status' => '1');

        $query = $this->db->get_where('admin', $credential);
        if ($query->num_rows() > 0) 
        {
            $row = $query->row();
            $this->session->set_userdata('admin_login', '1');
            $this->session->set_userdata('role_id', $row->owner_status);
            $this->session->set_userdata('admin_id', $row->admin_id);
            $this->session->set_userdata('login_user_id', $row->admin_id);
            $this->session->set_userdata('name', $row->first_name);
            $this->session->set_userdata('login_type', 'admin');
            redirect(base_url() . 'admin/panel/', 'refresh');
        }
        $query = $this->db->get_where('teacher', $credential);
        if ($query->num_rows() > 0) 
        {
            $row = $query->row();
            $this->session->set_userdata('role_id', '5');
            $this->session->set_userdata('program_id', '0');
            $this->session->set_userdata('teacher_login', '1');
            $this->session->set_userdata('teacher_id', $row->teacher_id);
            $this->session->set_userdata('login_user_id', $row->teacher_id);
            $this->session->set_userdata('name', $row->first_name);
            $this->session->set_userdata('login_type', 'teacher');
            redirect(base_url() . 'teacher/panel/', 'refresh');
        }
        $query = $this->db->get_where('student', $credential);
        if ($query->num_rows() > 0) 
        {
            $row = $query->row();
            $this->session->set_userdata('role_id', '6');
            $this->session->set_userdata('program_id', $row->program_id);
            $this->session->set_userdata('student_login', '1');
            $this->session->set_userdata('student_id', $row->student_id);
            $this->session->set_userdata('login_user_id', $row->student_id);
            $this->session->set_userdata('name', $row->first_name);
            $this->session->set_userdata('login_type', 'student');
            redirect(base_url() . 'student/panel/', 'refresh');
        }
        $query = $this->db->get_where('parent', $credential);
        if ($query->num_rows() > 0) 
        {
            $row = $query->row();
            $this->session->set_userdata('role_id', '7');
            $this->session->set_userdata('parent_login', '1');
            $this->session->set_userdata('parent_id', $row->parent_id);
            $this->session->set_userdata('login_user_id', $row->parent_id);
            $this->session->set_userdata('name', $row->first_name);
            $this->session->set_userdata('login_type', 'parent');
            redirect(base_url() . 'parents/panel/', 'refresh');
        }
        $query = $this->db->get_where('accountant', $credential);
        if ($query->num_rows() > 0) 
        {
            $row = $query->row();
            $this->session->set_userdata('role_id', '4');
            $this->session->set_userdata('accountant_login', '1');
            $this->session->set_userdata('accountant_id', $row->accountant_id);
            $this->session->set_userdata('login_user_id', $row->accountant_id);
            $this->session->set_userdata('name', $row->first_name);
            $this->session->set_userdata('login_type', 'accountant');
            redirect(base_url() . 'accountant/panel/', 'refresh');
        }
        $query = $this->db->get_where('librarian', $credential);
        if ($query->num_rows() > 0) 
        {
            $row = $query->row();
            $this->session->set_userdata('role_id', '8');
            $this->session->set_userdata('librarian_login', '1');
            $this->session->set_userdata('librarian_id', $row->librarian_id);
            $this->session->set_userdata('login_user_id', $row->librarian_id);
            $this->session->set_userdata('name', $row->first_name);
            $this->session->set_userdata('login_type', 'librarian');
            redirect(base_url() . 'librarian/panel/', 'refresh');
        }
        $this->session->set_flashdata('error', '1');
        redirect(base_url(), 'refresh');
    }

    //Recover your passowrd function.
    function lost_password($param1 = '', $param2 = '')
    {
        if($param1 == 'recovery')
        {
            $email  = html_escape($_POST["field"]);
            $bytes = random_bytes(20);
            $password_token = bin2hex($bytes);

            $query = $this->db->get_where('admin' , array('email' => $email, 'status' => '1'));
            if ($query->num_rows() > 0) 
            {
                $table = base64_encode('admin');
                $this->db->where('email' , $email);
                $this->db->update('admin' , array('password_token' => $password_token));
                $this->mail->submitPassword($email, $password_token, $table);

            }
            $query = $this->db->get_where('teacher' , array('email' => $email, 'status' => '1'));
            if ($query->num_rows() > 0) 
            {
                $table = base64_encode('teacher');
                $this->db->where('email' , $email);
                $this->db->update('teacher' , array('password_token' => $password_token));
                $this->mail->submitPassword($email, $password_token, $table);

            }
            $query = $this->db->get_where('parent' , array('email' => $email, 'status' => '1'));
            if ($query->num_rows() > 0) 
            {
                $table = base64_encode('parent');
                $this->db->where('email' , $email);
                $this->db->update('parent' , array('password_token' => $password_token));
                $this->mail->submitPassword($email, $password_token, $table);

            }
            $query = $this->db->get_where('student' , array('email' => $email, 'status' => '1'));
            if ($query->num_rows() > 0) 
            {
                $table = base64_encode('student');
                $this->db->where('email' , $email);
                $this->db->update('student' , array('password_token' => $password_token));
                $this->mail->submitPassword($email, $password_token, $table);
            }
            $query = $this->db->get_where('accountant' , array('email' => $email, 'status' => '1'));
            if ($query->num_rows() > 0) 
            {
                $table = base64_encode('accountant');
                $this->db->where('email' , $email);
                $this->db->update('accountant' , array('password_token' => $password_token));
                $this->mail->submitPassword($email, $password_token, $table);
            }
            $query = $this->db->get_where('librarian' , array('email' => $email, 'status' => '1'));
            if ($query->num_rows() > 0) 
            {
                $table = base64_encode('librarian');
                $this->db->where('email' , $email);
                $this->db->update('librarian' , array('password_token' => $password_token));
                $this->mail->submitPassword($email, $password_token, $table);
            }
            $this->session->set_flashdata('success_recovery', '1');
            redirect(base_url(), 'refresh'); 
        }
        $this->load->view('backend/lost');
    }
    
    //Logout function.
    function logout() 
    { 
        $this->session->sess_destroy();
        redirect(base_url(), 'refresh');
    }
    
    //End of Login.php
}