<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Applicant extends School 
{    
    private $runningYear = '';
    private $runningSemester = '';
    
    function __construct() 
    {
        parent::__construct();
        $this->load->database();
        $this->runningYear = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $this->runningSemester = $this->db->get_where('settings' , array('type' => 'running_semester'))->row()->description;
        $this->load->library('excel');
    }

    function register()
    {
        $data['created_by']     = $this->session->userdata('login_user_id');
        $data['first_name']     = $this->input->post('first_name');
        $data['last_name']      = $this->input->post('last_name');
        $data['birthday']       = $this->input->post('datetimepicker');
        $data['email']          = $this->input->post('email');
        $data['phone']          = $this->input->post('phone');
        $data['gender']         = $this->input->post('gender');
        $data['address']        = $this->input->post('address');
        $data['country_id']     = $this->input->post('country_id');
        $data['type_id']        = $this->input->post('type_id');

        $this->db->insert('applicant', $data);

        $table      = 'applicant';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);

        return $insert_id;

    }
}