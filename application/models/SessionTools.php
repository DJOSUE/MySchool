<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class SessionTools extends School 
{    
    private $runningYear = '';
    private $runningSemester = '';
    
    function __construct() 
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->runningYear = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $this->runningSemester = $this->db->get_where('settings' , array('type' => 'running_semester'))->row()->description;
        $this->load->library('excel');
    }


    function get_account_type()
    {
        return $this->session->userdata('user_data')['login_type'];
    }
    
}
