<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class StudentModel extends School 
{
    function add_interaction($student_id)
    {
        $md5 = md5(date('d-m-Y H:i:s'));

        $data['created_by'] = $this->session->userdata('login_user_id');
        $data['student_id'] = $student_id;
        $data['comment']    = html_escape($this->input->post('comment'));

        if($_FILES['applicant_file']['name'] != '')
        {
            $data['file_name']  = $md5.str_replace(' ', '', $_FILES['applicant_file']['name']); 
            move_uploaded_file($_FILES['applicant_file']['tmp_name'], PATH_STUDENT_INTERACTION_FILES . $md5.str_replace(' ', '', $_FILES['applicant_file']['name']));
        }

        $this->db->insert('student_interaction', $data);

        $table      = 'student_interaction';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);

        return $insert_id;
    }

    function update_interaction($interaction_id)
    {
        $md5 = md5(date('d-m-Y H:i:s'));
        $data['comment'] = html_escape($this->input->post('comment'));

        if($_FILES['applicant_file']['name'] != '')
        {
            $data['file_name']  = $md5.str_replace(' ', '', $_FILES['applicant_file']['name']); 
            move_uploaded_file($_FILES['applicant_file']['tmp_name'], PATH_STUDENT_INTERACTION_FILES . $md5.str_replace(' ', '', $_FILES['applicant_file']['name']));
        }
        
        $this->db->where('interaction_id', $interaction_id);
        $this->db->update('student_interaction', $data);

        $table      = 'student_interaction';
        $action     = 'update';
        $this->crud->save_log($table, $action, $interaction_id, $data);
    }
    
    public function get_status()
    {
        $this->db->reset_query();
        $this->db->select('code as status_id, name, value_1 as color, value_2 as icon');
        $this->db->where('parameter_id', 'STUDENTSTA');
        $query = $this->db->get('parameters')->result_array();;
        
        return $query;
    }

    public function get_status_info($status_id)
    {
        $this->db->reset_query();
        $this->db->select('code as status_id, name, value_1 as color, value_2 as icon');
        $this->db->where('parameter_id', 'STUDENTSTA');
        $this->db->where('code', $status_id);
        $query = $this->db->get('parameters')->row_array();
        
        return $query;
    }

    public function get_programs()
    {
        $this->db->reset_query();
        $this->db->select('program_id, name, color, icon');
        $query = $this->db->get('program')->result_array();;
        
        return $query;
    }

    public function get_program_info($program_id)
    {
        $this->db->reset_query();
        $this->db->select('program_id, name, color, icon');
        $this->db->where('program_id', $program_id);
        $query = $this->db->get('program')->row_array();
        
        return $query;
    }
}