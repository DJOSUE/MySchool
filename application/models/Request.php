<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Request extends School 
{
    private $runningYear = '';
    private $runningSemester = '';
    
    function __construct() 
    {
        parent::__construct();
        $this->load->database();
        // $this->load->library('excel');
        
        $this->runningYear      = $this->crud->getInfo('running_year'); 
        $this->runningSemester  = $this->crud->getInfo('running_semester');
    }

    function student_permission_request()
    {
        $md5 = md5(date('d-m-Y H:i:s'));

        $student_id = get_login_user_id();
        $program = $this->studentModel->get_student_program_info($student_id);

        $data['request_type'] = $this->input->post('request_type');
        $data['student_id']   = $student_id;
        $data['description']  = $this->input->post('description');
        $data['parent_id']    = $this->db->get_where('student', array('student_id' => $student_id))->row()->parent_id;

        $data['title']            = $this->input->post('title');
        $data['start_date']       = $this->input->post('start_date');
        $data['end_date']         = $this->input->post('end_date');
        $data['status']           = 1;
        $data['year']             = $this->runningYear;
        $data['semester_id']      = $this->runningSemester;
        $data['assigned_to']      = $program['user_notify_id'];
        $data['assigned_to_type'] = $program['user_notify_type'];

        if($_FILES['file_name']['name'] != '')
        {
            $data['file_name']  = $md5.str_replace(' ', '', $_FILES['file_name']['name']);
            $path_to = PATH_REQUEST_FILES .$data['file_name'];
            $path_from = $_FILES['file_name']['tmp_name'];

            move_uploaded_file($path_from, $path_to);
        }

        $this->db->insert('student_request', $data);

        $table      = 'student_request';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);

        $url_encode = base64_encode('admin/request_student/');
        $this->notification->create('absence_request', $program['user_notify_id'], $program['user_notify_type'], $url_encode);

    }

    function student_vacation_request()
    {
        $md5 = md5(date('d-m-Y H:i:s'));

        $student_id = get_login_user_id();

        $program = $this->studentModel->get_student_program_info($student_id);

        $data['request_type'] = $this->input->post('request_type');
        $data['student_id']   = $student_id;
        $data['description']  = $this->input->post('description');
        $data['parent_id']    = $this->db->get_where('student', array('student_id' => $student_id))->row()->parent_id;
        $data['status']       = 1;
        $data['year']         = $this->input->post('year');
        $data['semester_id']  = $this->input->post('semester_id');

        $data['assigned_to']      = $program['user_notify_id'];
        $data['assigned_to_type'] = $program['user_notify_type'];

        if($_FILES['vacation_request_file']['name'] != '')
        {
            $data['file_name']  = $md5.str_replace(' ', '', $_FILES['vacation_request_file']['name']);
            $path_to = PATH_REQUEST_FILES .$data['file_name'];
            $path_from = $_FILES['vacation_request_file']['tmp_name'];

            move_uploaded_file($path_from, $path_to);
        }

        $this->db->insert('student_request', $data);

        $table      = 'student_request';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);

        $url_encode = base64_encode('admin/request_vacation/'.$insert_id);
        $this->notification->create('vacation_request', $program['user_notify_id'], $program['user_notify_type'], $url_encode);
        
    }

    public function accept_request($request_id, $user_type, $message = "")
    {
        $user_id = $this->get_request_user($request_id, $user_type);
        $user_name = $this->crud->get_name($user_type, $user_id);
        $table = $user_type.'_request';

        $url_encode = base64_encode($user_type.'/request/');
        $this->notification->create('absence_approved', $user_id, $user_type, $url_encode);

        $this->mail->request_approved($user_id, $user_type, 'permission');

        $data['status'] = DEFAULT_REQUEST_ACCEPTED; // Accept
        $this->db->where('request_id', $request_id);
        $this->db->update($table, $data);
        
        $action     = 'update';
        $this->crud->save_log($table, $action, $request_id, $data);

        //Notify the teacher
        if($user_type === 'student')
        {            
            $enrollments = $this->studentModel->get_enrollment($user_id);
            $teacher_id = "";

            foreach($enrollments as $item)
            {
                if($teacher_id != $item['teacher_id'])
                {
                    $teacher_id = $item['teacher_id'];
                    $request_info = $this->get_request_info($request_id, $user_type);
                    $this->notification->teacher_student_request('absence_approved_teacher', $user_name, $teacher_id, 'teacher', $request_info['start_date'], $request_info['end_date']);                    
        
                    $data['STUDENT_NAME'] = $user_name;
                    $data['LEVEL_NAME']   = $item['class_name'];
                    $data['SCHEDULE']     = $item['section_name'];
                    $data['SUBJECT']      = $item['subject_name'];
                    $data['DATE_START']   = $request_info['start_date'];
                    $data['DATE_END']     = $request_info['end_date'];

                    $this->mail->request_approved_to_teacher($teacher_id, 'teacher', $data);

                }
            }
        }

    }
    
    public function reject_request($request_id, $user_type, $message)
    {

        $user_id = $this->get_request_user($request_id, $user_type);
        $table = $user_type.'_request';

        $url_encode = base64_encode($user_type.'/request/');
        $this->notification->create('absence_rejected', $user_id, $user_type, $url_encode);

        $this->mail->request_reject($user_id, $user_type, 'permission');

        $data['status'] = DEFAULT_REQUEST_REJECTED; // Accept
        $data['comment'] = base64_decode($message);
        $data['assigned_to'] = get_login_user_id(); // Accept
        $data['assigned_to_type'] = get_account_type();        
        $this->db->where('request_id', $request_id);
        $this->db->update($table, $data);
        
        $action     = 'update';
        $this->crud->save_log($table, $action, $request_id, $data);
    }

    public function accept_vacation($request_id, $user_type, $message = "", $year = "", $semester_id = "")
    {
        $user_id = $this->get_request_user($request_id, $user_type);
        $table = $user_type.'_request';

        $url_encode = base64_encode($user_type.'/request/');
        $this->notification->create('vacation_approved', $user_id, $user_type, $url_encode);

        $this->mail->request_approved($user_id, $user_type, 'vacation');

        $data['status'] = DEFAULT_REQUEST_ACCEPTED; // Accept
        $this->db->where('request_id', $request_id);
        $this->db->update($table, $data);
        
        $action     = 'update';
        $this->crud->save_log($table, $action, $request_id, $data);
        

        // add to vacation table 
        $data_vacation['student_id']    = $user_id;
        $data_vacation['year']          = $year != ""? $year : $this->runningYear;
        $data_vacation['semester_id']   = $semester_id != ""? $semester_id : $this->runningSemester;

        $this->db->insert('student_vacation', $data_vacation);

        $table      = 'student_vacation';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data_vacation);

        // Update the status of the student on vacation
        $data_student['student_session'] = DEFAULT_USER_VACATION; // Accept
        $this->db->where('student_id', $user_id);
        $this->db->update('student', $data_student);

        $action     = 'update';
        $this->crud->save_log('student', $action, $user_id, $data_student);

    }
    
    public function reject_vacation($request_id, $user_type, $message)
    {

        $user_id = $this->get_request_user($request_id, $user_type);
        $table = $user_type.'_request';

        $url_encode = base64_encode($user_type.'/request/');
        $this->notification->create('vacation_rejected', $user_id, $user_type, $url_encode);

        $this->mail->request_reject($user_id, $user_type, 'vacation');

        $data['status'] = DEFAULT_REQUEST_REJECTED; // Accept
        $data['comment'] = base64_decode($message);
        $data['assigned_to'] = get_login_user_id(); // Accept
        $data['assigned_to_type'] = get_account_type();        
        $this->db->where('request_id', $request_id);
        $this->db->update($table, $data);
        
        $action     = 'update';
        $this->crud->save_log($table, $action, $request_id, $data);
    }

    public function get_request_user($request_id, $user_type)
    {
        $query = 0;
        if($user_type == 'student')
        {
            $this->db->reset_query();
            $this->db->select('student_id');
            $this->db->where('request_id', $request_id);
            $query = $this->db->get('student_request')->row()->student_id;
        }
        else if($user_type == 'teacher')
        {
            $this->db->reset_query();
            $this->db->select('teacher_id');
            $this->db->where('request_id', $request_id);
            $query = $this->db->get('teacher_request')->row()->teacher_id;
        }

        return $query;
    }

    public function get_request_info($request_id, $user_type)
    {
        $query = 0;
        if($user_type == 'student')
        {
            $this->db->reset_query();            
            $this->db->where('request_id', $request_id);
            $query = $this->db->get('student_request')->row_array();
        }
        else if($user_type == 'teacher')
        {
            $this->db->reset_query();            
            $this->db->where('request_id', $request_id);
            $query = $this->db->get('teacher_request')->row_array();
        }

        return $query;
    }

    public function can_request($year, $semester_id, $request_type, $student_id)
    {
        $this->db->reset_query();            
        $this->db->where('year', $year);
        $this->db->where('semester_id', $semester_id);
        $this->db->where('request_type', $request_type);
        $this->db->where('student_id', $student_id);
        $query = $this->db->get('student_request')->num_rows();

        // echo '<pre>';
        // var_dump($query);
        // echo '</pre>';

        if($query > 2)
        {
            return 'true';
        }
        else
        {
            return 'false';
        }

    }

    public function get_student_request_totals($year, $semester_id, $type = '')
    {
        $this->db->reset_query();
        $this->db->select('request_type, request_name, program_name, status, status_name, count(request_id) as total');
        $this->db->where('year', $year);
        $this->db->where('semester_id', $semester_id);
        
        if($type != '')
            $this->db->where('request_type', $type);
        
        $this->db->group_by('request_type, program_name, status');
        $this->db->order_by('total');
        $query = $this->db->get('v_student_request')->result_array();
        return $query;
    }

    public function get_student_type_request_totals($year, $semester_id, $request_type = '', $program_name = '')
    {
        $this->db->reset_query();
        $this->db->select('request_type, request_name, program_name, status, status_name, count(request_id) as total');
        $this->db->where('year', $year);
        $this->db->where('semester_id', $semester_id);
        
        if($request_type != '')
            $this->db->where('request_type', $request_type);

        if($program_name != '')
            $this->db->where('program_name', $program_name);

        $this->db->group_by('request_type, program_name, status');
        $this->db->order_by('total');
        $query = $this->db->get('v_student_request')->result_array();
        return $query;
    }
}
