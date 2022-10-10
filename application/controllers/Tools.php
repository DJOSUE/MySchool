<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
    
    class Tools extends EduAppGT
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
        public function index()
        {
            $this->isLogin();
        }

        public function check_duplication($table, $column)
        {
            $value =  $_POST['value'];

            if(isset($value)){
                $where = array($column => ($value));
                $query = $this->db->get_where($table, $where);
                
                if ($query->num_rows() > 0) 
                {
                    echo 'success';                  
                } 
                else
                {
                    echo 'error'; 
                }
            }
            else {
                echo 'error';
            }
        }

        //Check Admin session.
        function isLogin()
        {
            $array      = ['admin', 'teacher', 'student', 'parent', 'accountant', 'librarian'];
            $login_type = $this->session->userdata('login_type');
            
            if (in_array($login_type, $array))
            {
                redirect(base_url(), 'refresh');
            }
        }
        //End of Admin.php content. 
    }