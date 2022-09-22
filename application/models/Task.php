<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Task extends School 
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

    public function get_departments()
    {
        $this->db->reset_query();
        $this->db->select('level_1 as department_id, name, value_1 as color, value_2 as icon');
        $this->db->where('parameter_id', 'TASKCATEGO');
        $this->db->where('code', '0');
        $query = $this->db->get('parameters')->result_array();
        return $query;
    }
    
    public function get_categories($department)
    {
        $this->db->reset_query();
        $this->db->select('code as category_id, name, value_1 as color, value_2 as icon');
        $this->db->where('parameter_id', 'TASKCATEGO');
        $this->db->where('level_1', $department);
        $this->db->where('code >', $department);
        $query = $this->db->get('parameters')->result_array();        
        return $query;
    }

    public function get_category_info($category_id)
    {
        $this->db->reset_query();
        $this->db->select('code as category_id, name, value_1 as color, value_2 as icon');
        $this->db->where('parameter_id', 'TASKCATEGO');
        $this->db->where('code', $category_id);
        $query = $this->db->get('parameters')->row_array();
        return $query;
    }

    public function get_category($category_id)
    {
        $query = $this->db->get_where('v_task_categories', array('category_id' => $category_id))->row();
        return $query->name;
    }

    public function get_priorities()
    {
        $this->db->reset_query();
        $this->db->select('code as priority_id, name, value_1 as color, value_2 as icon');
        $this->db->where('parameter_id', 'TASKPRIORI');
        $query = $this->db->get('parameters')->result_array();
        return $query;
    }

    public function get_priority_info($priority_id)
    {
        $this->db->reset_query();
        $this->db->select('code as priority_id, name, value_1 as color, value_2 as icon');
        $this->db->where('parameter_id', 'TASKPRIORI');
        $this->db->where('code', $priority_id);
        $query = $this->db->get('parameters')->row_array();
        return $query;
    }

    public function get_priority($priority_id)
    {
        $query = $this->db->get_where('parameters', array('parameter_id' => 'TASKPRIORI', 'code' => $priority_id))->row();
        return $query->name;
    }

    public function get_statuses()
    {
        $this->db->reset_query();
        $this->db->select('code as status_id, name, value_1 as color, value_2 as icon');
        $this->db->where('parameter_id', 'TASKSTATUS');
        $query = $this->db->get('parameters')->result_array();
        return $query;
    }

    public function get_status_info($status_id)
    {
        $this->db->reset_query();
        $this->db->select('code as category_id, name, value_1 as color, value_2 as icon');
        $this->db->where('parameter_id', 'TASKSTATUS');
        $this->db->where('code', $status_id);
        $query = $this->db->get('parameters')->row_array();
        return $query;
    }
    
    public function get_status($status_id)
    {
        $query = $this->db->get_where('parameters', array('parameter_id' => 'TASKSTATUS', 'code' => $status_id))->row();
        return $query->name;
    }

    public function is_task_closed($status_id)
    {
        $query = $this->db->get_where('parameters', array('parameter_id' => 'TASKSTATUS', 'code' => $status_id))->row();
        
        // 3 = student
        if($query->value_3 == '1'){
            return true;
        }
        else{
            return false;
        }
    }

    public function get_user_status($type, $user_id)
    {
        switch ($type) {
            case 'student':
                $status_id = $this->db->get_where('student', array('student_id' => $user_id))->row()->student_session;
                $status_info = $this->studentModel->get_status_info($status_id);
                return $status_info;
                break;
            case 'applicant':
                $status_id = $this->db->get_where('applicant', array('applicant_id' => $user_id))->row()->status;
                $status_info = $this->applicant->get_applicant_status_info($status_id);
                return $status_info;
                break;
        }
    }

    function create()
    {
        $code = md5(date('d-m-Y H:i:s'));
        $data['created_by']     = $this->session->userdata('login_user_id');
        $data['title']          = html_escape($this->input->post('title'));
        $data['task_code']      = $code;
        $data['category_id']    = html_escape($this->input->post('category_id'));
        $data['status_id']      = html_escape($this->input->post('status_id'));
        $data['priority_id']    = html_escape($this->input->post('priority_id'));
        $data['description']    = html_escape($this->input->post('description'));
        $data['user_type']      = html_escape($this->input->post('user_type'));
        $data['user_id']        = html_escape($this->input->post('user_id'));

        if(!empty($this->input->post('assigned_to')))
        {
            $data['assigned_to'] = html_escape($this->input->post('assigned_to'));
        }

        if($this->task->is_task_closed($this->input->post('status_id')))
        {
            $data['assigned_to'] =  $this->session->userdata('login_user_id');
        }
        
        if($_FILES['task_file']['name'] != '')
        {
            $md5 = md5(date('d-m-Y H:i:s'));

            $data['task_file']  = $md5.str_replace(' ', '', $_FILES['task_file']['name']); 
            move_uploaded_file($_FILES['task_file']['tmp_name'], PATH_TASK_FILES . $md5.str_replace(' ', '', $_FILES['task_file']['name']));
        }

        $this->db->insert('task', $data);

        $table      = 'task';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);

        return $insert_id;

    }

    function update($task_id)
    {
        $data['updated_by']     = $this->session->userdata('login_user_id');

        $task_code = $this->db->get_where('task' , array('task_id' => $task_id) )->row()->task_code;
        $assigned_to_old = $this->db->get_where('task' , array('task_id' => $task_id) )->row()->assigned_to;
        
        $assigned_to_new = $this->input->post('assigned_to');


        if(!empty($this->input->post('title')))
            $data['title']     = ucfirst(html_escape($this->input->post('title')));

        if(!empty($this->input->post('category_id')))
            $data['category_id']      = ucfirst(html_escape($this->input->post('category_id')));

        if(!empty($this->input->post('status_id')))
            $data['status_id']       = html_escape($this->input->post('status_id'));
        
        if(!empty($this->input->post('priority_id')))
            $data['priority_id']          = html_escape($this->input->post('priority_id'));
        
        if(!empty($this->input->post('description')))
            $data['description']          = html_escape($this->input->post('description'));
        
        if(!empty($this->input->post('assigned_to')))
            $data['assigned_to']         = html_escape($this->input->post('assigned_to'));
        
       
        if(!empty($this->input->post('assigned_to')))
            $data['assigned_to']    = html_escape($this->input->post('assigned_to'));
        
        if($_FILES['task_file']['name'] != '')
        {
            $md5 = md5(date('d-m-Y H:i:s'));

            $data['task_file']  = $md5.str_replace(' ', '', $_FILES['task_file']['name']); 
            move_uploaded_file($_FILES['task_file']['tmp_name'], PATH_TASK_FILES . $md5.str_replace(' ', '', $_FILES['task_file']['name']));
        }

        $this->db->where('task_id', $task_id);
        $this->db->update('task', $data);

        $table      = 'task';
        $action     = 'update';        
        $this->crud->save_log($table, $action, $task_id, $data);

        if($assigned_to_new != '' && ($assigned_to_new != $assigned_to_old))
        {
            $user_name  = $this->crud->get_name('admin', $this->session->userdata('login_user_id'));
            $assigned_name  = $this->crud->get_name('admin', $assigned_to_new);

            // Create a new interaction
            $_POST['login_user_id']  = $data['updated_by'];
            $_POST['message']           = $user_name.' assigned to '.$assigned_name.' this task.';
            
            $this->add_message($task_code);
        }
    }

    function update_status($task_code, $status_id)
    {
        $data['updated_by']     = $this->session->userdata('login_user_id');
        $data['status_id']   = $status_id;
        $this->db->where('task_code', $task_code);
        $this->db->update('task', $data);

        $table      = 'task';
        $action     = 'update';
        $this->crud->save_log($table, $action, $task_code, $data);

        return true;
    }

    function add_message($task_code)
    {
        $md5 = md5(date('d-m-Y H:i:s'));
        $table_user = get_table_user($this->session->userdata('role_id'));

        $data['sender_id']      = $this->session->userdata('login_user_id');
        $data['sender_type']    = $table_user;
        $data['task_code']      = $task_code;
        $data['message']        = html_escape($this->input->post('message'));


        if($_FILES['message_file']['name'] != '')
        {
            $data['message_file']  = $md5.str_replace(' ', '', $_FILES['message_file']['name']); 
            move_uploaded_file($_FILES['message_file']['tmp_name'], PATH_TASK_FILES . $md5.str_replace(' ', '', $_FILES['message_file']['name']));
        }

        $this->db->insert('task_message', $data);

        $table      = 'task_message';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);

        return $insert_id;
    }

    function update_message($task_message_id)
    {
        $md5 = md5(date('d-m-Y H:i:s'));
        $data['message']      = html_escape($this->input->post('message'));

        if($_FILES['message_file']['name'] != '')
        {
            $data['message_file']  = $md5.str_replace(' ', '', $_FILES['message_file']['name']); 
            move_uploaded_file($_FILES['message_file']['tmp_name'], PATH_TASK_FILES . $md5.str_replace(' ', '', $_FILES['message_file']['name']));
        }
        $this->db->where('task_message_id', $task_message_id);
        $this->db->update('task_message', $data);

        $table      = 'task_message';
        $action     = 'update';
        $this->crud->save_log($table, $action, $task_message_id, $data);
    }

    //** Get numbers for dashboard */
    function task_total($field, $field_id)
    {
        $this->db->where($field, $field_id);
        $applicant_query = $this->db->get('task');
        return $applicant_query->num_rows();
    }
}
