<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Assignment extends EduAppGT
{
    /*
        Software:       MySchool - School Management System
        Author:         DHCoder - Software, Web and Mobile developer.
        Author URI:     https://dhcoder.com
        PHP:            5.6+
        Created:        22 September 2021.
        Base:           EduAppGT
    */

    private $runningYear     = '';
    private $runningSemester = '';
    private $account_type = '';
    private $role_id = 0;

    
	function __construct()
	{
		parent::__construct();
		$this->load->database();
        $this->load->library('session');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');

        $this->runningYear      = $this->crud->getInfo('running_year'); 
        $this->runningSemester  = $this->crud->getInfo('running_semester'); 
        $this->account_type       =   $this->session->userdata('login_type'); 
        $this->role_id = $this->session->userdata('role_id');
    }
    
    //Index function.
    public function index()
    {
        $this->isLogin();
        echo 'test';
    }

    // task Dashboard
    function task_dashboard()
    {
        
        $this->isLogin();

        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {   
            $department_id  = $this->input->post('department_id');                
            $priority_id    = $this->input->post('priority_id');
            $status_id      = $this->input->post('status_id');
            $text           = $this->input->post('text');
            $assigned_me    = $this->input->post('assigned_me');                
        }
        else
        {    
            $department_id  = "_blank";
            $priority_id    = "_blank";
            $status_id      = "_blank";
            $assigned_me = 1;
        }

        $page_data['department_id'] = $department_id;
        $page_data['priority_id']   = $priority_id;
        $page_data['status_id']     = $status_id;
        $page_data['text']          = $text;
        $page_data['assigned_me']   = $assigned_me;
        $page_data['page_name']     = 'task_dashboard';
        $page_data['page_title']    =  getPhrase('task_dashboard');
        $this->load->view('backend/task/index', $page_data);
    }

    function task_list($param1 = '')
    {
        $this->isLogin();

        if($param1 != '')
        {
            $array      = explode('|',base64_decode($param1));

            $status_id      = $array[0] != '-' ? $array[0] : '';
            $priority_id    = $array[1] != '-' ? $array[1] : '';            
            $department_id  = "";
        }
        else
        {
            $department_id  = "";
            $priority_id    = "";
            $status_id      = "";            
        }
        
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {   
            $category_id    = $this->input->post('category_id');                
            $priority_id    = $this->input->post('priority_id');
            $status_id      = $this->input->post('status_id');
            $text           = $this->input->post('text');
            $assigned_me    = $this->input->post('assigned_me');  
            $search         = true;              
        }

        $assigned_me    = 1;

        $page_data['department_id'] = $department_id;
        $page_data['category_id']   = $category_id;
        $page_data['priority_id']   = $priority_id;
        $page_data['status_id']     = $status_id;
        $page_data['text']          = $text;
        $page_data['search']        = $search;
        $page_data['assigned_me']   = $assigned_me;
        $page_data['page_name']     = 'task_list';
        $page_data['page_title']    =  getPhrase('task_list');
        $this->load->view('backend/task/index', $page_data);
    }

    function task_info($task_code = '', $param2 = '')
    {
        $this->isLogin();
        $page_data['task_code']    = $task_code;
        $page_data['page_name']    = 'task_info';
        $page_data['page_title']   = getPhrase('task_info');
        $this->load->view('backend/task/index', $page_data);
    }

    function task_update($task_code = '', $param2 = '')
    {
        $this->isLogin();
        $page_data['task_code']    = $task_code;
        $page_data['page_name']    = 'task_update';
        $page_data['page_title']   = getPhrase('task_update');
        $this->load->view('backend/task/index', $page_data);
    }

    function task($action, $task_id = '', $return_url = '')
    {
        $this->isLogin();

        if($return_url == '')
        {
            $task_code = $this->task->get_task_code($task_id);
            $return_url = 'task_info/'.$task_code;
        }

        $message = '';
        switch ($action) {
            case 'register':                
                $this->task->create();
                $message =  getPhrase('successfully_added');                
                break;
            case 'update':
                $this->task->update($task_id);
                $message =  getPhrase('successfully_updated');
                break;
            
            default:
                # code...
                break;
        }

        $this->session->set_flashdata('flash_message' , $message);
        redirect(base_url() .'assignment/'.$return_url, 'refresh');
    }

    function task_message($action, $task_code = '', $task_message_id = '', $return_url = '')
    {
        $this->isLogin();

        if($return_url == '')
        {
            $return_url = 'assignment/task_info/'.$task_code;
        }
        else
        {
            if(base64_decode($return_url, true ))
            {
                $return_url = 'assignment/'.base64_decode($return_url);
            }
            else
            {
                $return_url = 'assignment/'.$return_url;
            }
        }

        $message = '';
        switch ($action) {
            case 'add':

                if($task_code != '')
                {
                    $status_id_old = $this->db->get_where('task' , array('task_code' => $task_code))->row()->status_id;
    
                    $status_id_new = $this->input->post('status_id');
    
                    if($status_id_old != $status_id_new)
                    {
                        $this->task->update_status($task_code, $status_id_new);
                    }
                }

                $this->task->add_message($task_code);
                $message =  getPhrase('successfully_added');

                break;
            case 'update':                    
                $this->task->update_message($task_message_id);
                $message =  getPhrase('successfully_updated');

            default:
                # code...
                break;
        }

        $this->session->set_flashdata('flash_message' , $message);
        redirect(base_url() . $return_url, 'refresh');
    }

    //Get subjects by classId and sectionId.
    function get_category_dropdown($department_id)
    {
        $departments = $this->task->get_categories($department_id);
        $options = '';
        foreach ( $departments as $row )  {
            $options .= '<option value="' . $row['category_id'] . '">' . $row['name'] . '</option>';
        }
        echo $options;
    }

    function student_interaction($action, $student_id = '', $interaction_id = '', $return_url = '')
    {
        $message = '';


        $return_url = $_SERVER['HTTP_REFERER'];

        switch ($action) 
        {
            case 'add':
                $this->studentModel->add_interaction($student_id);
                $message =  getPhrase('successfully_added');
                break;

            case 'update':
                $this->studentModel->update_interaction($interaction_id);
                $message =  getPhrase('successfully_added');
                break;

            default:
                # code...
                break;
        }

        $this->session->set_flashdata('flash_message' , $message);
        redirect($return_url, 'refresh');
    }

    //Check session function.
    function isLogin()
    {
        if ($this->session->userdata('login_user_id') == '')
        {
            redirect(site_url('login'), 'refresh');
        }
        else
        {
            check_permission('task_module');
        }
    }
}