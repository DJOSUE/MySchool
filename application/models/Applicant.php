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
        $data['first_name']     = ucfirst(html_escape($this->input->post('first_name')));
        $data['last_name']      = ucfirst(html_escape($this->input->post('last_name')));
        $data['birthday']       = html_escape($this->input->post('datetimepicker'));
        $data['email']          = html_escape($this->input->post('email'));
        $data['phone']          = html_escape($this->input->post('phone'));
        $data['gender']         = html_escape($this->input->post('gender'));
        $data['address']        = html_escape($this->input->post('address'));
        $data['country_id']     = html_escape($this->input->post('country_id'));
        $data['type_id']        = html_escape($this->input->post('type_id'));

        if(!empty($this->input->post('is_imported')))
        {
            $data['is_imported']        = $this->input->post('is_imported');
        }

        $this->db->insert('applicant', $data);

        $table      = 'applicant';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);

        return $insert_id;

    }

    function update($applicant_id)
    {
        $data['updated_by']     = $this->session->userdata('login_user_id');

        if(!empty($this->input->post('first_name')))
            $data['first_name']     = ucfirst(html_escape($this->input->post('first_name')));

        if(!empty($this->input->post('last_name')))
            $data['last_name']      = ucfirst(html_escape($this->input->post('last_name')));

        if(!empty($this->input->post('datetimepicker')))
            $data['birthday']       = html_escape($this->input->post('datetimepicker'));
        
        if(!empty($this->input->post('email')))
            $data['email']          = html_escape($this->input->post('email'));
        
        if(!empty($this->input->post('phone')))
            $data['phone']          = html_escape($this->input->post('phone'));
        
        if(!empty($this->input->post('gender')))
            $data['gender']         = html_escape($this->input->post('gender'));
        
        if(!empty($this->input->post('address')))
            $data['address']        = html_escape($this->input->post('address'));
        
        if(!empty($this->input->post('country_id')))
            $data['country_id']     = html_escape($this->input->post('country_id'));
        
        if(!empty($this->input->post('type_id')))
            $data['type_id']        = html_escape($this->input->post('type_id'));
        
        if(!empty($this->input->post('status_id')))
            $data['status']         = html_escape($this->input->post('status_id'));
        if(!empty($this->input->post('assigned_to')))
            $data['assigned_to']    = html_escape($this->input->post('assigned_to'));
        

        $this->db->where('applicant_id', $applicant_id);
        $this->db->update('applicant', $data);

        $table      = 'applicant';
        $action     = 'update';        
        $this->crud->save_log($table, $action, $applicant_id, $data);
    }

    function update_status($applicant_id, $status_id)
    {
        $data['updated_by']     = $this->session->userdata('login_user_id');
        $data['status']   = $status_id;
        $this->db->where('applicant_id', $applicant_id);
        $this->db->update('applicant', $data);

        $table      = 'applicant';
        $action     = 'update';
        $this->crud->save_log($table, $action, $applicant_id, $data);

        return true;
    }

    function add_interaction()
    {
        $md5 = md5(date('d-m-Y H:i:s'));

        $data['created_by']   = $this->session->userdata('login_user_id');
        $data['applicant_id'] = $this->input->post('applicant_id');
        $data['comment']      = html_escape($this->input->post('comment'));

        if($_FILES['applicant_file']['name'] != '')
        {
            $data['file_name']  = $md5.str_replace(' ', '', $_FILES['applicant_file']['name']); 
            move_uploaded_file($_FILES['applicant_file']['tmp_name'], PATH_APPLICANT_FILES . $md5.str_replace(' ', '', $_FILES['applicant_file']['name']));
        }

        $this->db->insert('applicant_interaction', $data);

        $table      = 'applicant_interaction';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);

        return $insert_id;
    }

    function update_interaction($interaction_id)
    {
        $md5 = md5(date('d-m-Y H:i:s'));
        $data['comment']      = html_escape($this->input->post('comment'));

        if($_FILES['applicant_file']['name'] != '')
        {
            $data['file_name']  = $md5.str_replace(' ', '', $_FILES['applicant_file']['name']); 
            move_uploaded_file($_FILES['applicant_file']['tmp_name'], PATH_APPLICANT_FILES . $md5.str_replace(' ', '', $_FILES['applicant_file']['name']));
        }
        $this->db->where('interaction_id', $interaction_id);
        $this->db->update('applicant_interaction', $data);

        $table      = 'applicant_interaction';
        $action     = 'update';
        $this->crud->save_log($table, $action, $interaction_id, $data);
    }
}