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
        $data['city']            = $this->input->post('city');
        $data['state']           = $this->input->post('state');
        $data['postal_code']     = $this->input->post('postal_code');
        
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
        $account_type   =   get_table_user(get_role_id());

        if($type != 'automatic')
        {
            $data['created_by']         = get_login_user_id();
            $data['created_by_type']    = $account_type;
        }
        else
        {
            $data['created_by']         = DEFAULT_USER;
            $data['created_by_type']    = DEFAULT_TABLE;
        }

        
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

    function add_interaction_data($data)
    {
        $this->db->insert('student_interaction', $data);

        $table      = 'student_interaction';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);

        return $insert_id;
    }

    /**** functions */

    public function update_student_collection_profile($student_id, $collection_id)
    {
        $data['collection'] = $collection_id;

        $this->db->reset_query();
        $this->db->where('student_id', $student_id);
        $this->db->update('student', $data);

        $table      = 'student';
        $action     = 'update';
        $this->crud->save_log($table, $action, $student_id, $data);

    }

    public function get_status()
    {
        $this->db->reset_query();
        $this->db->select('code as status_id, name, value_1 as color, value_2 as icon');
        $this->db->where('parameter_id', 'STUDENTSTA');
        $query = $this->db->get('parameters')->result_array();;
        
        return $query;
    }

    public function get_student_status_info($student_id)
    {
        $this->db->reset_query();
        $this->db->select('student_session');
        $this->db->where('student_id', $student_id);
        $status_id = $this->db->get('student')->row()->student_session;        
        
        $this->db->reset_query();
        $this->db->select('code as status_id, name, value_1 as color, value_2 as icon');
        $this->db->where('parameter_id', 'STUDENTSTA');
        $this->db->where('code', $status_id);
        $query = $this->db->get('parameters')->row_array();
        
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

    public function get_program_name($program_id)
    {
        $this->db->reset_query();
        $this->db->select('program_id, name, color, icon');
        $this->db->where('program_id', $program_id);
        $query = $this->db->get('program')->row_array();
        
        return $query['name'];
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

    public function get_last_student_code()
    {
        $this->db->reset_query();
        $this->db->order_by('student_id', 'DESC');
        $query = $this->db->get('student')->first_row();        
        return $query->student_code;
    }

    public function generate_student_code()
    {
        $student_code = 1;

        $last_student_code = $this->get_last_student_code();

        if(!empty($last_student_code))
        {
            $year = date("y"); 
            $month = date("m"); 

            $correlative = intval(substr($last_student_code, -8));

            $student_code = 'A'.$year.$month.sprintf('%08d', ($correlative+1));
        }

        return $student_code;
    }

    public function get_student_id_by_email($email)
    {
        $this->db->reset_query();
        $this->db->select('student_id');
        $this->db->where('email', $email);
        $student_id = $this->db->get('student')->row()->student_id;
        
        return $student_id;
    }

    public function get_student_id($student_code)
    {
        $this->db->reset_query();
        $this->db->select('student_id');
        $this->db->where('student_code', $student_code);
        $student_id = $this->db->get('student')->row()->student_id;
        
        return $student_id;
    }

    public function get_student_financial_profile($student_id)
    {
        $result = 'red';

        // $this->db->reset_query();
        // $this->db->select('*');
        // $this->db->from('agreement');
        // $this->db->join('agreement_amortization', 'agreement_amortization.agreement_id = agreement.agreement_id');
        // $this->db->where('agreement.student_id', $student_id);
        // $this->db->where('agreement_amortization.due_date <', date("Y-m-d"));
        // $this->db->where_in('agreement_amortization.status_id', array(DEFAULT_AMORTIZATION_PENDING, DEFAULT_AMORTIZATION_PARTIAL));
        // $due = $this->db->get()->num_rows();

        // if($due == 0)
        // {
        //     $result = 'green';
        // }
        // else if ( $due == 1)
        // {
        //     $result = 'yellow';
        // }
        // else
        // {
        //     $result = 'red';
        // }
        

        $this->db->reset_query();
        $this->db->select('financial');
        $this->db->where('student_id', $student_id);
        $result = $this->db->get('student')->row()->financial;
        
        return $result;
    }

    public function get_student_installments_due($student_id, $due_date)
    {
        $this->db->reset_query();
        $this->db->select('*');
        $this->db->from('agreement');
        $this->db->join('agreement_amortization', 'agreement_amortization.agreement_id = agreement.agreement_id');
        $this->db->where('agreement.student_id', $student_id);
        $this->db->where('agreement_amortization.due_date <', $due_date);
        $this->db->where_in('agreement_amortization.status_id', array(DEFAULT_AMORTIZATION_PENDING, DEFAULT_AMORTIZATION_PARTIAL));
        $number = $this->db->get()->num_rows();

        $this->db->reset_query();
        $this->db->select_sum('amount');        
        $this->db->from('agreement');
        $this->db->join('agreement_amortization', 'agreement_amortization.agreement_id = agreement.agreement_id');
        $this->db->where('agreement.student_id', $student_id);
        $this->db->where('agreement_amortization.due_date <', $due_date);
        $this->db->where_in('agreement_amortization.status_id', array(DEFAULT_AMORTIZATION_PENDING, DEFAULT_AMORTIZATION_PARTIAL));        
        $amount = $this->db->get()->row()->amount;

        $this->db->reset_query();
        $this->db->select_sum('agreement_amortization.materials');        
        $this->db->from('agreement');
        $this->db->join('agreement_amortization', 'agreement_amortization.agreement_id = agreement.agreement_id');
        $this->db->where('agreement.student_id', $student_id);
        $this->db->where('agreement_amortization.due_date <', $due_date);
        $this->db->where_in('agreement_amortization.status_id', array(DEFAULT_AMORTIZATION_PENDING, DEFAULT_AMORTIZATION_PARTIAL));        
        $materials = $this->db->get()->row()->materials;

        $this->db->reset_query();
        $this->db->select_sum('agreement_amortization.fees');        
        $this->db->from('agreement');
        $this->db->join('agreement_amortization', 'agreement_amortization.agreement_id = agreement.agreement_id');
        $this->db->where('agreement.student_id', $student_id);
        $this->db->where('agreement_amortization.due_date <', $due_date);
        $this->db->where_in('agreement_amortization.status_id', array(DEFAULT_AMORTIZATION_PENDING, DEFAULT_AMORTIZATION_PARTIAL));        
        $fees = $this->db->get()->row()->fees;

        $total_amount = $amount + $materials + $fees;


        $result = array('number' => $number, 'amount' => $total_amount);
        
        return $result;
    }

    public function get_student_collection_profile($student_id)
    {
        $this->db->reset_query();
        $this->db->select('collection');
        $this->db->where('student_id', $student_id);
        $collection_id = $this->db->get('student')->row()->collection;

        $this->db->reset_query();
        $this->db->select('code as collection_id, name, value_1 as color, value_2 as icon');
        $this->db->where('parameter_id', 'COLLECTION_PROFILE');
        $this->db->where('code', $collection_id);
        $query = $this->db->get('parameters')->row_array();
        
        return $query;
    }

    public function get_collection_profiles()
    {
        $this->db->reset_query();
        $this->db->select('code as collection_id, name, value_1 as color, value_2 as icon');
        $this->db->where('parameter_id', 'COLLECTION_PROFILE');        
        $query = $this->db->get('parameters')->result_array();

        return $query;
    }

    public function get_collection_profile_info($collection_id)
    {
        $this->db->reset_query();
        $this->db->select('code as collection_id, name, value_1 as color, value_2 as icon');
        $this->db->where('parameter_id', 'COLLECTION_PROFILE');
        $this->db->where('code', $collection_id);
        $query = $this->db->get('parameters')->row_array();

        return $query;
    }
}
