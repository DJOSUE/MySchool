<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ticket extends School 
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
        $this->db->where('parameter_id', 'TICKETCATEGORY');
        $this->db->where('code', '0');
        $query = $this->db->get('parameters')->result_array();
        return $query;
    }
    
    public function get_categories($department)
    {
        $this->db->reset_query();
        $this->db->select('code as category_id, name, value_1 as color, value_2 as icon');
        $this->db->where('parameter_id', 'TICKETCATEGORY');
        $this->db->where('level_1', $department);
        $this->db->where('code >', $department);
        $query = $this->db->get('parameters')->result_array();        
        return $query;
    }

    public function get_category_info($category_id)
    {
        $this->db->reset_query();
        $this->db->select('code as category_id, name, value_1 as color, value_2 as icon, value_3 as default_user');
        $this->db->where('parameter_id', 'TICKETCATEGORY');
        $this->db->where('code', $category_id);
        $query = $this->db->get('parameters')->row_array();
        return $query;
    }

    public function get_category_default_user($category_id)
    {
        $this->db->reset_query();
        $query = $this->db->get_where('parameters', array('parameter_id' => 'TICKETCATEGORY', 'code' => $category_id))->row();
        return $query->value_3;
    }

    public function get_category_name($category_id)
    {
        $this->db->reset_query();
        $query = $this->db->get_where('parameters', array('parameter_id' => 'TICKETCATEGORY', 'code' => $category_id))->row();
        return $query->name;
    }

    public function get_priorities()
    {
        $this->db->reset_query();
        $this->db->select('code as priority_id, name, value_1 as color, value_2 as icon');
        $this->db->where('parameter_id', 'TICKETPRIORITY');
        $query = $this->db->get('parameters')->result_array();
        return $query;
    }

    public function get_priority_info($priority_id)
    {
        $this->db->reset_query();
        $this->db->select('code as priority_id, name, value_1 as color, value_2 as icon');
        $this->db->where('parameter_id', 'TICKETPRIORITY');
        $this->db->where('code', $priority_id);
        $query = $this->db->get('parameters')->row_array();
        return $query;
    }

    public function get_priority_name($priority_id)
    {
        $this->db->reset_query();
        $query = $this->db->get_where('parameters', array('parameter_id' => 'TICKETPRIORITY', 'code' => $priority_id))->row();
        return $query->name;
    }

    public function get_statuses()
    {
        $this->db->reset_query();
        $this->db->select('code as status_id, name, value_1 as color, value_2 as icon');
        $this->db->where('parameter_id', 'TICKETSTATUS');
        $query = $this->db->get('parameters')->result_array();
        return $query;
    }

    public function get_status_info($status_id)
    {
        $this->db->reset_query();
        $this->db->select('code as category_id, name, value_1 as color, value_2 as icon');
        $this->db->where('parameter_id', 'TICKETSTATUS');
        $this->db->where('code', $status_id);
        $query = $this->db->get('parameters')->row_array();
        return $query;
    }
    
    public function get_status_name($status_id)
    {
        $query = $this->db->get_where('parameters', array('parameter_id' => 'TICKETSTATUS', 'code' => $status_id))->row();
        return $query->name;
    }

    public function is_ticket_closed($status_id)
    {
        $query = $this->db->get_where('parameters', array('parameter_id' => 'TICKETSTATUS', 'code' => $status_id))->row();
        
        // 3 = student
        if($query->value_3 == '1'){
            return true;
        }
        else{
            return false;
        }
    }

    function create()
    {
        $code = md5(date('d-m-Y H:i:s'));
        $data['ticket_code']        = $code;
        $data['created_by']         = $this->session->userdata('login_user_id');
        $data['created_by_type']    = get_table_user($this->session->userdata('role_id'));
        $data['category_id']        = html_escape($this->input->post('category_id'));
        $data['status_id']          = html_escape($this->input->post('status_id'));
        $data['priority_id']        = html_escape($this->input->post('priority_id'));
        $data['link']               = html_escape($this->input->post('link'));
        $data['description']        = html_escape($this->input->post('description'));

        if(!empty($this->input->post('assigned_to')))
        {
            $data['assigned_to'] = html_escape($this->input->post('assigned_to'));
        }
        else
        {
            $data['assigned_to'] = $this->get_category_default_user($data['category_id']);
        }

        if(!empty($this->input->post('title')))
        {
            $data['title']      = html_escape($this->input->post('title'));
        }

        if($this->ticket->is_ticket_closed($this->input->post('status_id')))
        {
            $data['assigned_to'] =  $this->session->userdata('login_user_id');
        }
        
        if($_FILES['ticket_file']['name'] != '')
        {
            $md5 = md5(date('d-m-Y H:i:s'));

            $data['ticket_file']  = $md5.str_replace(' ', '', $_FILES['ticket_file']['name']); 
            move_uploaded_file($_FILES['ticket_file']['tmp_name'], PATH_TICKET_FILES . $md5.str_replace(' ', '', $_FILES['ticket_file']['name']));
        }

        $this->db->insert('ticket', $data);

        $table      = 'ticket';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);

        return $insert_id;

    }

    function update($ticket_id)
    {
        $data['updated_by']         = $this->session->userdata('login_user_id');
        $data['updated_by_type']    = get_table_user($this->session->userdata('role_id'));

        $ticket_code = $this->db->get_where('ticket' , array('ticket_id' => $ticket_id) )->row()->ticket_code;
        $assigned_to_old = $this->db->get_where('ticket' , array('ticket_id' => $ticket_id) )->row()->assigned_to;
        
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
        
        if($_FILES['ticket_file']['name'] != '')
        {
            $md5 = md5(date('d-m-Y H:i:s'));

            $data['ticket_file']  = $md5.str_replace(' ', '', $_FILES['ticket_file']['name']); 
            move_uploaded_file($_FILES['ticket_file']['tmp_name'], PATH_TICKET_FILES . $md5.str_replace(' ', '', $_FILES['ticket_file']['name']));
        }

        $this->db->where('ticket_id', $ticket_id);
        $this->db->update('ticket', $data);

        $table      = 'ticket';
        $action     = 'update';        
        $this->crud->save_log($table, $action, $ticket_id, $data);

        if($assigned_to_new != '' && ($assigned_to_new != $assigned_to_old))
        {
            $user_name  = $this->crud->get_name('admin', $this->session->userdata('login_user_id'));
            $assigned_name  = $this->crud->get_name('admin', $assigned_to_new);

            // Create a new interaction
            $_POST['login_user_id']  = $data['updated_by'];
            $_POST['message']           = $user_name.' assigned to '.$assigned_name.' this ticket.';
            
            $this->add_message($ticket_code);
        }
    }

    function update_status($ticket_code, $status_id)
    {
        $data['updated_by_type']    = get_table_user($this->session->userdata('role_id'));
        $data['updated_by']         = $this->session->userdata('login_user_id');
        $data['status_id']          = $status_id;
        $this->db->where('ticket_code', $ticket_code);
        $this->db->update('ticket', $data);

        $table      = 'ticket';
        $action     = 'update';
        $this->crud->save_log($table, $action, $ticket_code, $data);

        return true;
    }

    function add_message($ticket_code, $type = "")
    {
        $md5 = md5(date('d-m-Y H:i:s'));
        $table_user = get_table_user($this->session->userdata('role_id'));

        $current_status = $this->db->get_where('ticket' , array('ticket_code' => $ticket_code))->row()->status_id;
        
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
        

        $data['ticket_code']    = $ticket_code;
        $data['message']        = html_escape($this->input->post('message'));
        $data['current_status'] = $current_status;


        if($_FILES['file_name']['name'] != '')
        {
            $data['file_name']  = $md5.str_replace(' ', '', $_FILES['file_name']['name']); 
            move_uploaded_file($_FILES['file_name']['tmp_name'], PATH_TICKET_FILES . $md5.str_replace(' ', '', $_FILES['file_name']['name']));
        }

        $this->db->insert('ticket_message', $data);

        $table      = 'ticket_message';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);

        return $insert_id;
    }

    function update_message($ticket_message_id)
    {
        $md5 = md5(date('d-m-Y H:i:s'));
        $data['message']      = html_escape($this->input->post('message'));

        if($_FILES['file_name']['name'] != '')
        {
            $data['file_name']  = $md5.str_replace(' ', '', $_FILES['file_name']['name']); 
            move_uploaded_file($_FILES['file_name']['tmp_name'], PATH_TICKET_FILES . $md5.str_replace(' ', '', $_FILES['file_name']['name']));
        }
        $this->db->where('ticket_message_id', $ticket_message_id);
        $this->db->update('ticket_message', $data);

        $table      = 'ticket_message';
        $action     = 'update';
        $this->crud->save_log($table, $action, $ticket_message_id, $data);
    }
    
    public function get_ticket($ticket_id)
    {
        $ticket_info = $this->db->get_where('ticket' , array('ticket_id' => $ticket_id) )->row_array();
        return $ticket_info;        
    }

    public function get_ticket_interactions($ticket_id)
    {
        $this->db->reset_query();                                                
        $this->db->order_by('created_at' , 'DESC');
        $this->db->where('ticket_code', $ticket_id);
        $interactions = $this->db->get('ticket_message')->result_array();

        return $interactions;
    }

    public function get_ticket_code($ticket_id)
    {
        $ticket_code = $this->db->get_where('ticket' , array('ticket_id' => $ticket_id) )->row()->ticket_code;
        return $ticket_code;        
    }

    //** Get numbers for dashboard */
    function ticket_total($field, $field_id)
    {
        $this->db->where($field, $field_id);
        $applicant_query = $this->db->get('ticket');
        return $applicant_query->num_rows();
    }

    function ticket_total_created_by($field, $field_id, $created_by, $created_by_type)
    {
        $this->db->where($field, $field_id);
        $this->db->where('created_by_type', $created_by_type);        
        $this->db->where('created_by', $created_by);
        $applicant_query = $this->db->get('ticket');
        return $applicant_query->num_rows();
    }

    function ticket_total_assigned_to($field, $field_id, $assigned_to)
    {
        $this->db->where($field, $field_id);        
        $this->db->where('assigned_to', $assigned_to);
        $applicant_query = $this->db->get('ticket');
        return $applicant_query->num_rows();
    }

}
