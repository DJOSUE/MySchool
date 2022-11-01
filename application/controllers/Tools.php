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

        function notification_delete($notify_id, $deleteAll = false)
        {

            $this->isLogin();
            
            if(!$deleteAll)
            {   
                $this->db->where('id', $notify_id);
                $this->db->set('status', '1', FALSE);
                $this->db->update('notification');
                
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted')); 

                $page_data['page_name']  =  'notifications';
                $page_data['page_title'] =  getPhrase('your_notifications');
                $this->load->view('backend/index', $page_data);
            }
            else
            {
                $user_id    = $this->session->userdata('login_user_id');
                $user_type  = get_table_user($this->session->userdata('role_id'));

                $this->db->where('user_id', $user_id);
                $this->db->where('user_type', $user_type);
                $this->db->set('status', '1', FALSE);
                $this->db->update('notification');

                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));   

                $page_data['page_name']  =  'notifications';
                $page_data['page_title'] =  getPhrase('your_notifications');
                $this->load->view('backend/index', $page_data);
            }
        }

        function close_class_unit($class_id, $unit_id)
        {
            $this->db->reset_query();
            $this->db->select('sequence');
            $this->db->where('unit_id', $unit_id);
            $this->db->where('class_id', $class_id);
            $sequence = $this->db->get('class_unit')->row()->sequence;

            $sequence += 1;

            $this->db->reset_query();
            $this->db->where('unit_id', $unit_id);
            $this->db->where('class_id', $class_id);
            $this->db->update('class_unit', array('is_current' => 0));

            $this->db->reset_query();            
            $this->db->where('sequence', $sequence);
            $this->db->where('class_id', $class_id);
            $this->db->update('class_unit', array('is_current' => 1));
            
            return 'success';
        }
    }