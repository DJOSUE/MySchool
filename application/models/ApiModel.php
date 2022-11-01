<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ApiModel extends School 
{

    // constructor
	function __construct()
	{
		parent::__construct();
        $this->load->database();
        $this->load->library('excel');
	}

    // Login mechanism
	public function login_get($username, $password)
	{
        
        $credential = array('username' => $username, 'password' => sha1($password), 'status' => '1');

        $userdata['validity'] = 0;

        $query = $this->db->get_where('admin', $credential);
        if ($query->num_rows() > 0) 
        {
            $row = $query->row();
            $userdata['user_type']  = 'admin';
        	$userdata['user_id']    = $row->admin_id;
            $userdata['username']   = $username;
            $userdata['user_role']  = $row->owner_status;
        	$userdata['first_name'] = $row->first_name;
        	$userdata['last_name']  = $row->last_name;
        	$userdata['email']      = $row->email;
        	$userdata['validity']   = 1;
            
            return $userdata;
        }

        // $query = $this->db->get_where('teacher', $credential);
        // if ($query->num_rows() > 0) 
        // {
        //     $row = $query->row();
        //     $userdata['user_id']    = $row->teacher_id;
        // 	$userdata['first_name'] = $row->first_name;
        // 	$userdata['last_name']  = $row->last_name;
        // 	$userdata['email']      = $row->email;
        // 	$userdata['validity']   = 1;

        //     return $userdata;
        // }

        // $query = $this->db->get_where('student', $credential);
        // if ($query->num_rows() > 0) 
        // {
        //     $row = $query->row();
        //     $userdata['user_id']    = $row->student_id;
        // 	$userdata['first_name'] = $row->first_name;
        // 	$userdata['last_name']  = $row->last_name;
        // 	$userdata['email']      = $row->email;
        // 	$userdata['validity']   = 1;

        //     return $userdata;
        // }

        // $query = $this->db->get_where('parent', $credential);
        // if ($query->num_rows() > 0) 
        // {
        //     $row = $query->row();
        //     $userdata['user_id']    = $row->parent_id;
        // 	$userdata['first_name'] = $row->first_name;
        // 	$userdata['last_name']  = $row->last_name;
        // 	$userdata['email']      = $row->email;
        // 	$userdata['validity']   = 1;

        //     return $userdata;
        // }

        // $query = $this->db->get_where('accountant', $credential);
        // if ($query->num_rows() > 0) 
        // {
        //     $row = $query->row();
        //     $userdata['user_id']    = $row->accountant_id;
        // 	$userdata['first_name'] = $row->first_name;
        // 	$userdata['last_name']  = $row->last_name;
        // 	$userdata['email']      = $row->email;
        // 	$userdata['validity']   = 1;

        //     return $userdata;
        // }

        // $query = $this->db->get_where('librarian', $credential);
        // if ($query->num_rows() > 0) 
        // {
        //     $row = $query->row();
        //     $userdata['user_id']    = $row->librarian_id;
        // 	$userdata['first_name'] = $row->first_name;
        // 	$userdata['last_name']  = $row->last_name;
        // 	$userdata['email']      = $row->email;
        // 	$userdata['validity']   = 1;

        //     return $userdata;
        // }

        return $credential;
	}
}