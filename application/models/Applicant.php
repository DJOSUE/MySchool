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

        $type_info = $this->applicant->get_type_info($data['type_id']);
        $data['program_id']        = $type_info['program_id'];

        if(!empty($this->input->post('is_imported')))
        {
            $data['is_imported'] = $this->input->post('is_imported');
        }

        if(!empty($this->input->post('agent_code')))
        {
            $data['agent_code']  = $this->input->post('agent_code');
        }

        if(!empty($this->input->post('status_id')))
            $data['status']       = html_escape($this->input->post('status_id'));

        if(!empty($this->input->post('agent_code')))
            $data['agent_code']   = html_escape($this->input->post('agent_code'));

        if(!empty($this->input->post('referral_by')))
            $data['referral_by']  = html_escape($this->input->post('referral_by'));

        if(!empty($this->input->post('assigned_to')))
        {
            $data['assigned_to']    = html_escape($this->input->post('assigned_to'));
        }
        else
        {
            $data['assigned_to']    = $this->session->userdata('login_user_id');
        }
        
       
        $this->db->insert('applicant', $data);

        $table      = 'applicant';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);


        // create an interaction 
        if($data['is_imported'])
        {
            $account_type   =   get_table_user($this->session->userdata('role_id'));
            $user_name  = $this->crud->get_name($account_type, $this->session->userdata('login_user_id'));            

            $_POST['applicant_id']  = $insert_id;
            $_POST['comment']       = $user_name.' imported to this applicant';
            
            $this->applicant->add_interaction('automatic');
        }

        return $insert_id;
        

    }

    function update($applicant_id)
    {
        $data['updated_by']     = $this->session->userdata('login_user_id');

        $assigned_to_old = $this->db->get_where('v_applicants' , array('applicant_id' => $applicant_id) )->row()->assigned_to;
        $assigned_to_new = $this->input->post('assigned_to');

        $status_id_old = $this->db->get_where('v_applicants' , array('applicant_id' => $applicant_id) )->row()->status;
        $status_id_new = html_escape($this->input->post('status_id'));


        if(!empty($this->input->post('first_name')))
            $data['first_name']     = ucfirst(html_escape($this->input->post('first_name')));

        if(!empty($this->input->post('last_name')))
            $data['last_name']      = ucfirst(html_escape($this->input->post('last_name')));

        if(!empty($this->input->post('datetimepicker')))
            $data['birthday']       = date('Y-m-d', strtotime($this->input->post('datetimepicker')));
        
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
        if(!empty($this->input->post('agent_code')))
            $data['agent_code']     = $this->input->post('agent_code');
        if(!empty($this->input->post('reference_id')))
            $data['reference_id']   = $this->input->post('reference_id');
        
        
        
            // Get tags
        $tags = $this->applicant->get_tags();
        $tags_selected = [];
        foreach($tags as $tag){
            if($this->input->post('tag_'.$tag['tag_id']))                
                array_push($tags_selected, $tag['tag_id']);
        }

        if(count($tags_selected) > 0)
        {
            $tags_id['tags_id'] = $tags_selected;
            $data['tags']    = json_encode($tags_id);
        }

        // echo$data['birthday'];
        $this->db->reset_query();
        $this->db->where('applicant_id', $applicant_id);
        $this->db->update('applicant', $data);

        $table      = 'applicant';
        $action     = 'update';        
        $this->crud->save_log($table, $action, $applicant_id, $data);

        if($assigned_to_new != '' && ($assigned_to_new != $assigned_to_old))
        {
            $user_name  = $this->crud->get_name('admin', $this->session->userdata('login_user_id'));
            $assigned_name  = $this->crud->get_name('admin', $assigned_to_new);

            // Create a new interaction
            $_POST['applicant_id']  = $applicant_id;
            $_POST['comment']       = $user_name.' assigned to '.$assigned_name.' this applicant';
            
            $this->applicant->add_interaction('automatic');
        }

        if($status_id_new != '' && ($status_id_new != $status_id_old))
        {
            // Add automatic interaction
            $this->add_interaction_update_status($applicant_id, $status_id_new);
        }
    }

    function update_tag($applicant_id, $tag_id, $selected)
    {
        $this->db->reset_query();
        $this->db->select('tags');
        $this->db->where('applicant_id', $applicant_id);
        $query = $this->db->get('applicant')->row_array();

        $tags_id =  json_decode($query['tags']);
        $ids =  $tags_id->tags_id;
        $exist = in_array($tag_id, $ids);

        if($selected == 'true')
        {
            if(!$exist)
                array_push($ids, $tag_id);
        }
        else 
        {
            $key = array_search($tag_id, $ids);
            unset($ids[$key]);
            $ids = array_values($ids);
        }

        $tags['tags_id'] = $ids;
        $data['tags']    = json_encode($tags);

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

        // Add automatic interaction
        $this->add_interaction_update_status($applicant_id, $status_id);

        return true;
    }

    function add_interaction_update_status($applicant_id, $status_id)
    {
        $user_name  = $this->crud->get_name('admin', $this->session->userdata('login_user_id'));
        $status_info = $this->get_applicant_status_info($status_id);

        // Create a new interaction
        $_POST['applicant_id']  = $applicant_id;
        $_POST['comment']       = $user_name.' update the status to: '.$status_info['name'].'.';
        
        $this->applicant->add_interaction('automatic');
    }

    function add_interaction($type = '')
    {
        $md5 = md5(date('d-m-Y H:i:s'));
        $account_type   =   get_table_user($this->session->userdata('role_id'));

        if($type != 'automatic')
        {
            $data['created_by']         = $this->session->userdata('login_user_id');
            $data['created_by_type']    = $account_type;
        }
        else
            $data['created_by']   = DEFAULT_USER;

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

    public function get_tags()
    {
        $this->db->reset_query();
        $this->db->select('code as tag_id, name, value_1 as color, value_2 as icon');
        $this->db->where('parameter_id', 'TAGSFD');
        $query = $this->db->get('parameters')->result_array();
        return $query;
    }

    // Get the list of the info pf the applicants
    public function get_applicant_types()
    {
        $this->db->reset_query();
        $this->db->select('code as type_id, name, value_1 as color, value_2 as icon, value_4 as program_id');
        $this->db->where('parameter_id', 'TYPEAPPLIC');
        $query = $this->db->get('parameters')->result_array();;
        
        return $query;
    }

    public function get_type_info($type_id)
    {
        $this->db->reset_query();
        $this->db->select('code as type_id, name, value_1 as color, value_2 as icon, value_4 as program_id');
        $this->db->where('parameter_id', 'TYPEAPPLIC');
        $this->db->where('code', $type_id);
        $query = $this->db->get('parameters')->row_array();
        
        return $query;
    }

    // Get the list of the info pf the applicants
    public function get_applicant_status()
    {
        $this->db->reset_query();
        $this->db->select('code as status_id, name, value_1 as color, value_2 as icon');
        $this->db->where('parameter_id', 'APPLSTATUS');
        $query = $this->db->get('parameters')->result_array();;
        
        return $query;
    }

    // Get the list of the info pf the applicants
    public function get_applicant_status_update($status_id)
    {
        $this->db->reset_query();
        $this->db->select('code as status_id, name, value_1 as color, value_2 as icon');
        $this->db->where('parameter_id', 'APPLSTATUS');
        $this->db->like('value_4', $status_id);
        $query = $this->db->get('parameters')->result_array();;
        
        return $query;
    }

    public function get_applicant_status_info($status_id)
    {
        $this->db->reset_query();
        $this->db->select('code as type_id, name, value_1 as color, value_2 as icon');
        $this->db->where('parameter_id', 'APPLSTATUS');
        $this->db->where('code', $status_id);
        $query = $this->db->get('parameters')->row_array();
        
        return $query;
    }

    public function get_agent_list()
    {
        $this->db->reset_query();
        $this->db->select('code as agent_code, name, ');
        $this->db->where('parameter_id', 'APPLAGENT');
        $query = $this->db->get('parameters')->result_array();;
        
        return $query;
    }
    //** Get numbers for dashboard */

    function applicant_total($field ,$field_id)
    {
        $this->db->where($field, $field_id);
        $applicant_query = $this->db->get('v_applicants');
        return $applicant_query->num_rows();
    }

    function applicant_total_type($type_id, $field, $field_id)
    {
        $this->db->where('type_id', $type_id);
        $this->db->where($field, $field_id);
        $applicant_query = $this->db->get('v_applicants');
        return $applicant_query->num_rows();
    }
}