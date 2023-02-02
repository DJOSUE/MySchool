<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Task extends School 
{    
    private $runningYear = '';
    private $runningSemester = '';
    private $user_id    = "";
    private $user_type  = "";
    private $user_name  = "";
    
    function __construct() 
    {
        parent::__construct();
        $this->load->database();
        $this->runningYear = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $this->runningSemester = $this->db->get_where('settings' , array('type' => 'running_semester'))->row()->description;
        $this->load->library('excel');
        $this->load->library('session');

        $this->user_id      = $this->session->userdata('login_user_id');
        $this->user_type    = get_table_user($this->session->userdata('role_id'));
        if($this->user_type != "")
            $this->user_name    = $this->crud->get_name($this->user_type, $this->user_id);
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

    public function get_categories_where($department)
    {
        $this->db->reset_query();
        $this->db->select('code as category_id');
        $this->db->where('parameter_id', 'TASKCATEGO');
        $this->db->where('level_1', $department);
        $this->db->where('code >', $department);
        $query = $this->db->get('parameters')->result_array();      
        
        $category_list = [];
        foreach($query as $item)
        {
            array_push($category_list, $item['category_id']);
        }

        return $category_list;
    }

    public function get_category_info($category_id)
    {
        $this->db->reset_query();
        $this->db->select('code as category_id, name, value_1 as color, value_2 as icon, value_4 as default_user');
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

    public function get_department_by_category($category_id)
    {
        $this->db->reset_query();
        $this->db->select('level_1 as department_id');
        $this->db->where('parameter_id', 'TASKCATEGO');
        $this->db->where('code', $category_id);
        $department_id = $this->db->get('parameters')->row()->department_id; 
        
        $this->db->reset_query();
        $this->db->select('level_1 as department_id, name');
        $this->db->where('parameter_id', 'TASKCATEGO');
        $this->db->where('level_1', $department_id);
        $this->db->where('code', '0');
        $query = $this->db->get('parameters')->row();        
        
        return $query->name;
    }

    public function get_category_assigned_to($category_id)
    {
        $this->db->reset_query();
        $this->db->select('value_4 as assigned_to');
        $this->db->where('parameter_id', 'TASKCATEGO');
        $this->db->where('code', $category_id);
        $query = $this->db->get('parameters')->row_array();
        return $query['assigned_to'];
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
        $code           = md5(date('d-m-Y H:i:s'));
        $account_type   =   get_table_user($this->session->userdata('role_id'));

        $data['created_by']      = $this->session->userdata('login_user_id');
        $data['created_by_type'] = $account_type;
        $data['title']           = html_escape($this->input->post('title'));
        $data['task_code']       = $code;
        $data['category_id']     = html_escape($this->input->post('category_id'));
        $data['status_id']       = html_escape($this->input->post('status_id'));
        $data['priority_id']     = html_escape($this->input->post('priority_id'));
        $data['description']     = html_escape($this->input->post('description'));
        $data['user_type']       = html_escape($this->input->post('user_type'));
        $data['user_id']         = html_escape($this->input->post('user_id'));

        if(!empty($this->input->post('assigned_to')))
        {
            $data['assigned_to_type'] = 'admin';
            $data['assigned_to'] = html_escape($this->input->post('assigned_to'));
        }
        else
        {
            // Get if the category has a default
            $category_assigned_to = $this->get_category_assigned_to($data['category_id']);
            $assigned_to = explode("|",$category_assigned_to);

            if(is_array($assigned_to))
            {
                $data['assigned_to_type'] = $assigned_to[0];
                $data['assigned_to'] = $assigned_to[1];
            }
        }

        if(!empty($this->input->post('due_date')))
        {
            $data['due_date'] = html_escape($this->input->post('due_date'));
        }

        if($this->task->is_task_closed($this->input->post('status_id')))
        {
            // Get table  
            $data['assigned_to_type'] = 'admin';
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

    function create_follow_up($data)
    {
        $code           = md5(date('d-m-Y H:i:s'));
        $account_type   = get_table_user($this->session->userdata('role_id'));

        $data['created_by']      = $this->session->userdata('login_user_id');
        $data['created_by_type'] = $account_type;        
        $data['task_code']       = $code;

        $this->db->insert('task', $data);

        $table      = 'task';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);

        return $insert_id;

    }

    function update($task_id)
    {
        $user_id    = $this->session->userdata('login_user_id');
        $user_type  = get_table_user($this->session->userdata('role_id'));
        $user_name  = $this->crud->get_name($user_type, $user_id);

        $data['updated_by']         = $user_id;
        $data['updated_by_type']    = get_table_user($this->session->userdata('role_id'));

        $task_code = $this->db->get_where('task' , array('task_id' => $task_id) )->row()->task_code;
        $assigned_to_old = $this->get_current_assigned($task_code);
        $assigned_to_new = $this->input->post('assigned_to');

        if(!empty($this->input->post('title')))
            $data['title']     = ucfirst(html_escape($this->input->post('title')));
        if(!empty($this->input->post('status_id')))
            $data['status_id']       = html_escape($this->input->post('status_id'));
        
        if(!empty($this->input->post('priority_id')))
            $data['priority_id']          = html_escape($this->input->post('priority_id'));
        
        if(!empty($this->input->post('description')))
            $data['description']          = html_escape($this->input->post('description'));
        
        if(!empty($this->input->post('category_id')))
        {   
            $data['category_id'] = $this->input->post('category_id');
            $previously_category =  $this->get_current_category($task_code); 

            if($data['category_id'] != $previously_category )
            {
                // Create a new comment
                $message = $user_name.' change the category to <b>'.$this->get_category($data['category_id']).'</b>.';

                $this->add_message_automatic($task_code, $message);
            }
        }
        
        if(!empty($this->input->post('assigned_to')))
        {
            $assigned_to = explode('|', $this->input->post('assigned_to'));

            if(is_array($assigned_to))
            {
                $data['assigned_to_type']    = $assigned_to[0];
                $data['assigned_to']         = $assigned_to[1];
            }
            else
            {
                $data['assigned_to_type']    = 'admin';
                $data['assigned_to']         = html_escape($this->input->post('assigned_to'));
            }
            
        }
        
        if($_FILES['task_file']['name'] != '')
        {
            $md5 = md5(date('d-m-Y H:i:s'));

            $data['task_file']  = $md5.str_replace(' ', '', $_FILES['task_file']['name']); 
            move_uploaded_file($_FILES['task_file']['tmp_name'], PATH_TASK_FILES . $md5.str_replace(' ', '', $_FILES['task_file']['name']));
        }

        if(!empty($this->input->post('due_date')))
            $data['due_date']          = html_escape($this->input->post('due_date'));

        $this->db->where('task_id', $task_id);
        $this->db->update('task', $data);

        $table      = 'task';
        $action     = 'update';        
        $this->crud->save_log($table, $action, $task_id, $data);

        if($assigned_to_new != '' && ($assigned_to_new != $assigned_to_old))
        {
            $assigned = explode('|', $assigned_to_new);
            $assigned_name = $this->crud->get_name($assigned[0], $assigned[1]);

            // Create a new comment
            $message = $user_name.' assigned to '.$assigned_name.' this task.';
            $this->add_message_automatic($task_code, $message);
        }
    }

    function update_status($task_code, $status_id)
    {
        // Create a new comment
        $message = $this->user_name.' change the status to <b>'.$this->get_status($status_id).'</b>.';
        $this->add_message_automatic($task_code, $message);

        $data['updated_by']         = $this->user_id;
        $data['updated_by_type']    = $this->user_type;
        $data['status_id']          = $status_id;
        $this->db->where('task_code', $task_code);
        $this->db->update('task', $data);

        $table      = 'task';
        $action     = 'update';
        $this->crud->save_log($table, $action, $task_code, $data);

        return true;
    }

    function update_category($task_code, $category_id)
    {
        // Create a new comment
        $message = $this->user_name.' change the category to <b>'.$this->get_category($category_id).'</b>.';
        $this->add_message_automatic($task_code, $message);

        $data['updated_by']         = $this->user_id;
        $data['updated_by_type']    = $this->user_type;
        $data['category_id']        = $category_id;
        $this->db->where('task_code', $task_code);
        $this->db->update('task', $data);

        $table      = 'task';
        $action     = 'update';
        $this->crud->save_log($table, $action, $task_code, $data);

        return true;
    }

    function update_assignment_to($task_code, $assignment_to)
    {
        $assigned = explode('|', $assignment_to);

        $data['assigned_to_type']   = $assigned[0];
        $data['assigned_to']        = $assigned[1];
        $data['updated_by']         = $this->user_id;
        $data['updated_by_type']    = $this->user_type;
        $this->db->where('task_code', $task_code);
        $this->db->update('task', $data);

        $table      = 'task';
        $action     = 'update';
        $this->crud->save_log($table, $action, $task_code, $data);

        $assigned_name = $this->crud->get_name($assigned[0], $assigned[1]);
        $message = $this->user_name.' assigned to '.$assigned_name.' this task.';

        $this->add_message_automatic($task_code, $message);
        return true;
    }

    function update_due_date($task_code, $due_date)
    {
        $data['due_date']           = $due_date;        
        $data['updated_by']         = $this->user_id;
        $data['updated_by_type']    = $this->user_type;
        $this->db->where('task_code', $task_code);
        $this->db->update('task', $data);

        $table      = 'task';
        $action     = 'update';
        $this->crud->save_log($table, $action, $task_code, $data);

        // $message = $this->user_name.' assigned to '.$assigned_name.' this task.';
        // $this->add_message_automatic($task_code, $message);
        return true;
    }

    function add_message_automatic($task_code, $message)
    {
        $data['sender_id']          = DEFAULT_USER;
        $data['sender_type']        = DEFAULT_TABLE;
        $data['task_code']          = $task_code;
        $data['message']            = html_escape($message);
        $data['current_status']     = $this->get_current_status($task_code);
        $data['current_category']   = $this->get_current_category($task_code);


        $this->db->insert('task_message', $data);

        $table      = 'task_message';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);
        return $insert_id;
    }

    function add_message($task_code, $type = "")
    {
        $md5 = md5(date('d-m-Y H:i:s'));
        $table_user = get_table_user($this->session->userdata('role_id'));

        $current_status = $this->db->get_where('task' , array('task_code' => $task_code))->row()->status_id;
        
        if($type != 'automatic')
        {
            $data['sender_id']      = $this->session->userdata('login_user_id');        
            $data['sender_type']    = $table_user;
        }
        else
        {
            $data['sender_id']      = DEFAULT_USER;
            $data['sender_type']    = DEFAULT_TABLE;
        }
        

        $data['task_code']      = $task_code;
        $data['message']        = html_escape($this->input->post('message'));
        $data['current_status'] = $current_status;


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
    
    public function get_task($task_id)
    {
        $task_info = $this->db->get_where('task' , array('task_id' => $task_id) )->row_array();
        return $task_info;        
    }

    public function get_task_code($task_id)
    {
        $task_code = $this->db->get_where('task' , array('task_id' => $task_id) )->row()->task_code;
        return $task_code;        
    }

    //** Get numbers for dashboard */
    function task_total($field, $field_id)
    {
        $this->db->where($field, $field_id);
        $applicant_query = $this->db->get('task');
        return $applicant_query->num_rows();
    }

    function task_total_created_by($field, $field_id, $created_by)
    {
        $this->db->where($field, $field_id);
        $this->db->where('created_by', $created_by);
        $applicant_query = $this->db->get('task');
        return $applicant_query->num_rows();
    }

    function task_total_assigned_to($field, $field_id, $assigned_to, $assigned_to_type)
    {
        $this->db->where($field, $field_id);
        $this->db->where('assigned_to_type', $assigned_to_type);
        $this->db->where('assigned_to', $assigned_to);
        $applicant_query = $this->db->get('task');
        return $applicant_query->num_rows();
    }

    function task_total_assigned_to_no_close($field, $field_id, $assigned_to, $assigned_to_type)
    {
        // All close
        $this->db->reset_query();
        $this->db->select('code as status_id');
        $this->db->where('parameter_id', 'TASKSTATUS');
        $this->db->where('value_3', '1');
        $query = $this->db->get('parameters')->result_array();
        $status_list = [];
        foreach($query as $item)
        {
            array_push($status_list, $item['status_id']);
        }

        $this->db->reset_query();
        $this->db->where($field, $field_id);
        $this->db->where('assigned_to', $assigned_to);
        $this->db->where('assigned_to_type', $assigned_to_type);        
        $this->db->where_not_in('status_id', $status_list);
        $applicant_query = $this->db->get('task');
        return $applicant_query->num_rows();
    }

    function get_current_status($task_code)
    {
        $current_status = $this->db->get_where('task' , array('task_code' => $task_code))->row()->status_id;

        return $current_status;
    }

    function get_current_category($task_code)
    {
        $current_status = $this->db->get_where('task' , array('task_code' => $task_code))->row()->category_id;

        return $current_status;
    }

    function get_current_assigned($task_code)
    {
        $current = $this->db->get_where('task' , array('task_code' => $task_code))->row_array();

        $assigned_to = $current['assigned_to_type'].'|'.$current['assigned_to'];

        return $assigned_to;
    }

    function get_user_list()
    {
        $this->db->reset_query();
        $this->db->select("admin_id as user_id, 'admin' as user_type, first_name, last_name");
        $this->db->where('status', '1');
        $this->db->where_in('owner_status', array('3','9','10'));        
        $advisor = $this->db->get('admin')->result_array();
        

        $this->db->reset_query();
        $this->db->select("accountant_id as user_id, 'accountant' as user_type, first_name, last_name");
        $this->db->where('status', '1');
        $this->db->where_in('role_id', array('4', '14', '15'));
        $finances  = $this->db->get('accountant')->result_array();

        $query = array_merge($advisor, $finances);

        $key_values = array_column($query, 'first_name'); 
        array_multisort($key_values, SORT_ASC, $query);

        return $query;
    }

    function get_user_list_dropbox($user_id = "", $user_type = "")
    {
        // $user['user_id'] == $row['assigned_to'] ? 'selected': '';

        $assigned_to = $user_type.'|'.$user_id;
        
        $this->db->reset_query();
        $this->db->select("admin_id as user_id, 'admin' as user_type, first_name, last_name");
        $this->db->where('status', '1');
        $this->db->where_in('owner_status', array('3'));        
        $this->db->order_by('first_name', 'ASC');
        $advisors = $this->db->get('admin')->result_array();

        $dropbox = '<optgroup label="'.getPhrase('advisors').'">';
        foreach($advisors as $item)
        {
            $value = $item['user_type'].'|'.$item['user_id'];
            $name  = $item['first_name'].' '.$item['last_name'];
            $selected = $assigned_to == $value ? 'selected' : '';

            $dropbox .= '<option value="'.$value.'" '.$selected.'>'.$name.'</option>';            
        }

        $this->db->reset_query();
        $this->db->select("admin_id as user_id, 'admin' as user_type, first_name, last_name");
        $this->db->where('status', '1');
        $this->db->where_in('owner_status', array('9'));
        $this->db->order_by('first_name', 'ASC');
        $managers = $this->db->get('admin')->result_array();

        $dropbox .= '<optgroup label="'.getPhrase('office_manager').'">';
        foreach($managers as $item)
        {
            $value = $item['user_type'].'|'.$item['user_id'];
            $name  = $item['first_name'].' '.$item['last_name'];
            $selected = $assigned_to == $value ? 'selected' : '';
            
            $dropbox .= '<option value="'.$value.'" '.$selected.'>'.$name.'</option>';             
        }

        $this->db->reset_query();
        $this->db->select("admin_id as user_id, 'admin' as user_type, first_name, last_name");
        $this->db->where('status', '1');
        $this->db->where_in('owner_status', array('10'));
        $this->db->order_by('first_name', 'ASC');
        $dso = $this->db->get('admin')->result_array();

        $dropbox .= '<optgroup label="'.getPhrase('dso').'">';
        foreach($dso as $item)
        {
            $value = $item['user_type'].'|'.$item['user_id'];
            $name  = $item['first_name'].' '.$item['last_name'];
            $selected = $assigned_to == $value ? 'selected' : '';
            
            $dropbox .= '<option value="'.$value.'" '.$selected.'>'.$name.'</option>'; 
        }
        
        $this->db->reset_query();
        $this->db->select("accountant_id as user_id, 'accountant' as user_type, first_name, last_name");
        $this->db->where('status', '1');
        $this->db->where_in('role_id', array('4', '14', '15'));
        $this->db->order_by('first_name', 'ASC');
        $finances  = $this->db->get('accountant')->result_array();

        $dropbox .= '<optgroup label="'.getPhrase('finances').'">';
        foreach($finances as $item)
        {
            $value = $item['user_type'].'|'.$item['user_id'];
            $name  = $item['first_name'].' '.$item['last_name'];
            $selected = $assigned_to == $value ? 'selected' : '';
            
            $dropbox .= '<option value="'.$value.'" '.$selected.'>'.$name.'</option>'; 
        }
        
        return $dropbox;
    }    
}