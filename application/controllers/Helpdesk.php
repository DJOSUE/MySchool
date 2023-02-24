<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Helpdesk extends EduAppGT
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
        redirect(base_url() .'helpdesk/dashboard', 'refresh');
    }

    function dashboard()
    {
        $page_data['page_name']     = 'dashboard';
        $page_data['page_title']    =  getPhrase('helpdesk_dashboard');
        $this->load->view('backend/helpdesk/index', $page_data);
    }

    function ticket_list($param1 ='')
    {
        if($param1 != '')
        {
            $array      = explode('|',base64_decode($param1));

            $status_id      = $array[0] != '-' ? $array[0] : '';
            $priority_id    = $array[1] != '-' ? $array[1] : '';
            $assigned_me    = $array[2] != '-' ? $array[2] : 0;
            $department_id  = "";
        }
        else
        {
            $department_id  = "";
            $priority_id    = "";
            $status_id      = "";
            $assigned_me    = 1;
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

        $page_data['department_id'] = $department_id;
        $page_data['category_id']   = $category_id;
        $page_data['priority_id']   = $priority_id;
        $page_data['status_id']     = $status_id;
        $page_data['text']          = $text;
        $page_data['search']        = $search;
        $page_data['assigned_me']   = $assigned_me;


        $page_data['page_name']     = 'ticket_list';
        $page_data['page_title']    =  getPhrase('ticket_list');
        $this->load->view('backend/helpdesk/index', $page_data);
    }

    function ticket_info($ticket_code = '', $param2 = '')
    {
        $this->isLogin('helpdesk_module');
        $page_data['ticket_code']   = $ticket_code;
        $page_data['page_name']     = 'ticket_info';
        $page_data['page_title']    = getPhrase('ticket_info');
        $this->load->view('backend/helpdesk/index', $page_data);
    }

    function ticket($action, $ticket_id = '', $return_url = '')
    {
        $this->isLogin();

        $message = '';
        switch ($action) {
            case 'register':
                
                $ticket_id = $this->ticket->create();
                $message =  getPhrase('successfully_added');

                if($return_url == '')
                {
                    $ticket_code = $this->ticket->get_ticket_code($ticket_id);
                    $return_url = 'ticket_info/'.$ticket_code;
                }
                break;

            case 'update':
                $this->ticket->update($ticket_id);
                $message =  getPhrase('successfully_updated');

                if($return_url == '')
                {
                    $ticket_code = $this->ticket->get_ticket_code($ticket_id);
                    $return_url = 'ticket_info/'.$ticket_code;
                }
                break;
            
            default:
                # code...
                break;
        }

        $this->session->set_flashdata('flash_message' , $message);
        redirect(base_url() .'helpdesk/'.$return_url, 'refresh');
    }

    function ticket_message($action, $ticket_code = '', $ticket_message_id = '', $return_url = '')
    {
        $this->isLogin();

        if($return_url == '')
        {
            $return_url = 'helpdesk/ticket_info/'.$ticket_code;
        }
        else
        {
            if(base64_decode($return_url, true ))
            {
                $return_url = 'helpdesk/'.base64_decode($return_url);
            }
            else
            {
                $return_url = $this->account_type.'/'.$return_url;
            }
        }

        $message = '';

        switch ($action) {
            case 'add':

                if($ticket_code != '')
                {
                    $status_id_old = $this->db->get_where('ticket' , array('ticket_code' => $ticket_code))->row()->status_id;
    
                    $status_id_new = $this->input->post('status_id');
    
                    if($status_id_old != $status_id_new)
                    {
                        $this->ticket->update_status($ticket_code, $status_id_new);
                    }
                }

                $this->ticket->add_message($ticket_code);
                $message =  getPhrase('successfully_added');

                break;
            case 'update':                    
                $this->ticket->update_message($ticket_message_id);
                $message =  getPhrase('successfully_updated');

            default:
                # code...
                break;
        }

        $this->session->set_flashdata('flash_message' , $message);
        redirect(base_url() . $return_url, 'refresh');
    }

    function tutorial()
    {
        $page_data['page_name']     = 'tutorial';
        $page_data['page_title']    =  getPhrase('helpdesk_tutorial');
        $this->load->view('backend/helpdesk/index', $page_data);
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
            check_permission('helpdesk_module');
        }
    }
}