<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class StudentModel extends School 
{
    private $runningYear = '';
    private $runningSemester = '';
    
    function __construct() 
    {
        parent::__construct();
        $this->load->database();
        $this->runningYear      = $this->crud->getInfo('running_year'); 
        $this->runningSemester  = $this->crud->getInfo('running_semester');
    }

    public function update_student_enroll($studentId)
    {
        $md5 = md5(date('d-m-Y H:i:s'));
        $data['first_name']      = $this->input->post('first_name');
        $data['last_name']       = $this->input->post('last_name');
        $data['birthday']        = $this->input->post('datetimepicker');
        $data['sex']             = $this->input->post('gender');
        $data['country_id']      = $this->input->post('country_id');
        $data['email']           = $this->input->post('email');
        $data['phone']           = $this->input->post('phone');
        $data['address']         = $this->input->post('address');        
        
        if($this->input->post('password') != "")
        {
           $data['password'] = sha1($this->input->post('password'));
        }        
        
        $this->db->where('student_id', $studentId);
        $this->db->update('student', $data);

        $table      = 'student';
        $action     = 'update';        
        $this->crud->save_log($table, $action, $studentId, $data);
    }

    /**** interaction  */
    function add_interaction($student_id, $type = '')
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

    function get_interactions($student_id)
    {
        $this->db->reset_query();
        $this->db->order_by('created_at', 'desc');   
        $this->db->where('student_id', $student_id);
        $query = $this->db->get('student_interaction')->result_array();;
        
        return $query;
    }
    
    /**** functions */
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

    public function get_request_types()
    {
        $this->db->reset_query();
        $this->db->order_by('code', 'DESC');
        $this->db->select('code as request_type, name, value_1 as color, value_2 as icon');
        $this->db->where('parameter_id', 'STUDENT_REQUEST');
        $query = $this->db->get('parameters')->result_array();;
        
        return $query;
    }
    
    public function get_request_type($request_type)
    {
        $this->db->reset_query();
        $this->db->select('code as request_type, name, value_1 as color, value_2 as icon');
        $this->db->where('parameter_id', 'STUDENT_REQUEST');
        $this->db->where('code', $request_type);
        $query = $this->db->get('parameters')->row_array();
        
        return $query;
    }

    public function get_request_type_name($request_type)
    {
        $this->db->reset_query();
        $this->db->select('name');
        $this->db->where('parameter_id', 'STUDENT_REQUEST');
        $this->db->where('code', $request_type);
        $query = $this->db->get('parameters')->row()->name;
        
        return $query;
    }

    public function get_request_statuses()
    {
        $this->db->reset_query();
        $this->db->select('code as status_id, name, value_1 as color, value_2 as icon');
        $this->db->where('parameter_id', 'REQUEST_STATUS');
        $query = $this->db->get('parameters')->result_array();;
        
        return $query;
    }
    
    public function get_request_status($status_id)
    {
        $this->db->reset_query();
        $this->db->select('code as status_id, name, value_1 as color, value_2 as icon');
        $this->db->where('parameter_id', 'REQUEST_STATUS');
        $this->db->where('code', $status_id);
        $query = $this->db->get('parameters')->row_array();
        
        return $query;
    }

    public function get_request_status_name($status_id)
    {
        $this->db->reset_query();
        $this->db->select('name');
        $this->db->where('parameter_id', 'REQUEST_STATUS');
        $this->db->where('code', $status_id);
        $query = $this->db->get('parameters')->row()->name;
        
        return $query;
    }

    public function get_student_program_info($student_id)
    {
        $this->db->reset_query();
        $this->db->select('program_id');
        $this->db->where('student_id', $student_id);
        $program_id = $this->db->get('student')->row()->program_id;

        $this->db->reset_query();        
        $this->db->where('program_id', $program_id);
        $query = $this->db->get('program')->row_array();
        
        return $query;
    }

    public function get_student_program($student_id)
    {
        $this->db->reset_query();
        $this->db->select('program_id');
        $this->db->where('student_id', $student_id);
        $query = $this->db->get('student')->row()->program_id;
        
        return $query;
    }

    public function get_applicant_program($applicant_id)
    {
        $this->db->reset_query();
        $this->db->select('program_id');
        $this->db->where('applicant_id', $applicant_id);
        $query = $this->db->get('applicant')->row()->program_id;
        
        return $query;
    }

    public function get_student_program_name($student_id)
    {
        $this->db->reset_query();
        $this->db->select('program_id');
        $this->db->where('student_id', $student_id);
        $program_id = $this->db->get('student')->row()->program_id;

        $this->db->reset_query();        
        $this->db->where('program_id', $program_id);
        $query = $this->db->get('program')->row()->name;
        
        return $query;
    }

    public function get_applicant_program_name($student_id)
    {
        $this->db->reset_query();
        $this->db->select('program_id');
        $this->db->where('student_id', $student_id);
        $program_id = $this->db->get('student')->row()->program_id;

        $this->db->reset_query();        
        $this->db->where('program_id', $program_id);
        $query = $this->db->get('program')->row()->name;
        
        return $query;
    }

    public function get_modality()
    {
        $this->db->reset_query();
        $this->db->select('code as modality_id, name, value_1 as color, value_2 as icon');
        $this->db->where('parameter_id', 'MODALITY');
        $query = $this->db->get('parameters')->result_array();;
        
        return $query;
    }
    
    public function get_modality_info($modality_id)
    {
        $this->db->reset_query();
        $this->db->select('code as modality_id, name, value_1 as color, value_2 as icon');
        $this->db->where('parameter_id', 'MODALITY');
        $this->db->where('code', $modality_id);
        $query = $this->db->get('parameters')->row_array();
        
        return $query;
    }

    public function get_modality_name($modality_id)
    {
        $this->db->reset_query();
        $this->db->select('name');
        $this->db->where('parameter_id', 'MODALITY');
        $this->db->where('code', $modality_id);
        $query = $this->db->get('parameters')->row()->name;
        
        return $query;
    }

    public function get_program_type()
    {
        $this->db->reset_query();
        $this->db->select('code as program_type_id, name, value_1 as price, value_2 as icon');
        $this->db->where('parameter_id', 'PROGRAM_TYPE');
        $query = $this->db->get('parameters')->result_array();;
        
        return $query;
    }
    
    public function get_program_type_info($program_type_id)
    {
        $this->db->reset_query();
        $this->db->select('code as program_type_id, name, value_1 as price, value_2 as icon');
        $this->db->where('parameter_id', 'PROGRAM_TYPE');
        $this->db->where('code', $program_type_id);
        $query = $this->db->get('parameters')->row_array();
        
        return $query;
    }

    public function get_program_type_name($program_type_id)
    {
        $this->db->reset_query();
        $this->db->select('name');
        $this->db->where('parameter_id', 'PROGRAM_TYPE');
        $this->db->where('code', $program_type_id);
        $query = $this->db->get('parameters')->row()->name;
        
        return $query;
    }
    
    public function get_semester_enroll($year, $semester_id)
    {
        $this->db->reset_query();        
        $this->db->where('year', $year);
        $this->db->where('semester_id', $semester_id);
        $query = $this->db->get('semester_enroll')->result_array();
        
        return $query;
    }

    public function get_enrollment($student_id, $year = "", $semester_id = "")
    {
        $_year          = $year != "" ? $year : $this->runningYear;
        $_semester_id   = $semester_id != "" ? $semester_id : $this->runningSemester;;

        $this->db->reset_query();        
        $this->db->where('year', $_year);
        $this->db->where('semester_id', $_semester_id);
        $this->db->where('student_id', $student_id);
        $query = $this->db->get('v_enrollment')->result_array();
        
        return $query;


    }
}