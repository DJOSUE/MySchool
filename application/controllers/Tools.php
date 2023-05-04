<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
    
    class Tools extends EduAppGT
    {
        /*
            Software:       MySchool - School Management System
            Author:         DHCoder - Software, Web and Mobile developer.
            Author URI:     https://dhcoder.com
            PHP:            5.6+
            Created:        22 September 2021.
        */

        private $runningYear     = '';
        private $runningSemester = '';

        function __construct()
        {
            parent::__construct();
            $this->load->database();
            $this->load->library('session');
            $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
            $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
            $this->output->set_header('Pragma: no-cache');
            $this->output->set_header("Expires: Mon, 26 Jul 2023 05:00:00 GMT");

            $this->runningYear      = $this->crud->getInfo('running_year'); 
            $this->runningSemester  = $this->crud->getInfo('running_semester'); 

        }

        //Index function for Admin controller.
        public function index()
        {
            $this->isLogin();
        }

        public function check_duplication($table, $column)
        {
            $value =  $_POST['value'];

            if(isset($value)){
                $where = array($column => ($value));
                $query = $this->db->get_where($table, $where);
                
                if ($query->num_rows() > 0) 
                {
                    echo 'success';                  
                } 
                else
                {
                    echo 'error'; 
                }
            }
            else {
                echo 'error';
            }
        }

        //Check Admin session.
        function isLogin()
        {
            $array      = ['admin', 'teacher', 'student', 'parent', 'accountant', 'librarian'];
            $login_type = get_account_type();
            
            if (!in_array($login_type, $array))
            {
                redirect(base_url(), 'refresh');
            }
        }
        //End of Admin.php content. 

        function notification_delete($notify_id, $deleteAll = false)
        {
            $this->isLogin();

            $this->notification->delete($notify_id, $deleteAll);

            redirect(base_url() , 'refresh');

            $page_data['page_name']  =  'notifications';
            $page_data['page_title'] =  getPhrase('your_notifications');
            $this->load->view('backend/index', $page_data);
        
        }

        function close_class_unit($class_id, $unit_id)
        {
            $this->db->reset_query();
            $this->db->select('sequence');
            $this->db->where('unit_id', $unit_id);
            $this->db->where('class_id', $class_id);
            $sequence = $this->db->get('class_unit')->row()->sequence;

            $sequence += 1;

            $this->db->reset_query();
            $this->db->where('unit_id', $unit_id);
            $this->db->where('class_id', $class_id);
            $this->db->update('class_unit', array('is_current' => 0));

            $this->db->reset_query();            
            $this->db->where('sequence', $sequence);
            $this->db->where('class_id', $class_id);
            $this->db->update('class_unit', array('is_current' => 1));
            
            return 'success';
        }

        function get_semester_enroll($year, $semester_id)
        {
            $semester_enroll = $this->academic->get_semester_enroll($year, $semester_id);
            echo '<pre>';
            var_dump($semester_enroll);
            echo '</pre>';
        }

        //Get sections by classId and teacherID of the current semester.
        function get_class_section_by_teacher($class_id = '', $teacher_id = '')
        {
            $year       =   $this->runningYear;
            $SemesterId =   $this->runningSemester;

            $this->db->reset_query();
            $this->db->select('section_id, section_name');
            $this->db->from('v_subject');            
            $this->db->where('year', $year);
            $this->db->where('semester_id', $SemesterId);
            $this->db->where('class_id', $class_id);            
            $this->db->where('teacher_id', $teacher_id);
            $this->db->group_by('subject_id');
            $sections =  $this->db->get()->result_array();  


            // $sections = $this->db->query("SELECT section_id, section_name FROM v_subject WHERE class_id = '$class_id' AND teacher_id = '$teacher_id' AND year = '$year' AND semester_id = '$SemesterId' GROUP BY section_id")->result_array();
            
            echo '<option value="">' . getPhrase('select') . '</option>';
            foreach ($sections as $row) 
            {
                echo '<option value="' . $row['section_id'] . '">' . $row['section_name'] . '</option>';
            }
        }

        //Get sections by classId and teacherID of the current semester.
        function get_class_section_subject_by_teacher($class_id = '', $section_id = '', $teacher_id = '')
        {
            $year       =   $this->runningYear;
            $SemesterId =   $this->runningSemester;
            
            $this->db->reset_query();
            $this->db->select('subject_id, name');
            $this->db->from('v_subject');            
            $this->db->where('year', $year);
            $this->db->where('semester_id', $SemesterId);
            $this->db->where('class_id', $class_id);
            $this->db->where('section_id', $section_id);
            $this->db->where('teacher_id', $teacher_id);
            $this->db->group_by('subject_id');
            $subject =  $this->db->get()->result_array();           

            // $sections = $this->db->query("SELECT subject_id, name as 'subject_name' FROM v_subject WHERE class_id = '$class_id' AND teacher_id = '$teacher_id' AND year = '$year' AND semester_id = '$SemesterId' GROUP BY section_id")->result_array();
            
            echo '<option value="">' . getPhrase('select') . '</option>';
            foreach ($subject as $row) 
            {
                echo '<option value="' . $row['subject_id'] . '">' . $row['name'] . '</option>';
            }
        }

        //Get Students by sectionId function of the current semester.
        function get_class_section_subject_students($subject_id = '')
        {
            $year       =   $this->runningYear;
            $SemesterId =   $this->runningSemester;

            $this->db->reset_query();
            $this->db->select('student_id, full_name');
            $this->db->from('v_enroll');            
            $this->db->where('year', $year);
            $this->db->where('semester_id', $SemesterId);
            // $this->db->where('class_id', $class_id);
            // $this->db->where('section_id', $section_id);
            $this->db->where('subject_id', $subject_id);
            $this->db->group_by('student_id');
            $this->db->order_by('full_name');
            $students =  $this->db->get()->result_array();   

            // $students = $this->db->get_where('enroll' , array('section_id' => $section_id))->result_array();
            // $students = $this->db->query("SELECT student_id, full_name FROM v_enroll WHERE section_id = '$section_id' AND year = '$year' AND semester_id = '$SemesterId' GROUP BY student_id")->result_array();;

            foreach ($students as $row) 
            {
                echo '<option value="' . $row['student_id'] . '">' . $row['full_name'] . '</option>';
            }
        }

        //Get Students by sectionId function of the current semester.
        function get_class_students($section_id = '')
        {
            $year       =   $this->runningYear;
            $SemesterId =   $this->runningSemester;

            // $students = $this->db->get_where('enroll' , array('section_id' => $section_id))->result_array();
            $students = $this->db->query("SELECT student_id, full_name FROM v_enroll WHERE section_id = '$section_id' AND year = '$year' AND semester_id = '$SemesterId' GROUP BY student_id")->result_array();;

            foreach ($students as $row) 
            {
                echo '<option value="' . $row['student_id'] . '">' . $row['full_name'] . '</option>';
            }
        }

        function update_subject($subject_id, $return_url = '')
        {
            $this->isLogin();
            $this->academic->updateCourse($subject_id);
            $class_id = $this->db->get_where('subject', array('subject_id' => $subject_id))->row()->class_id;
            $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
            redirect(base_url() . 'teacher/cursos/'.base64_encode($class_id)."/", 'refresh');
        }

        function run_agent($token = '', $data = '')
        {
            // 87878b73a13af46d24edf62640b80ca2d20c1d95

            if ($token == DEFAULT_TOKEN_AGENT) {
                
                $agent_name = base64_decode($data);
                echo $agent_name;

                switch ($agent_name) {
                    case 'payment_reminder':
                        // cGF5bWVudF9yZW1pbmRlcg
                        $this->agent->payment_reminder();
                        break;
                        
                    case 'late_payment_reminder':
                        // bGF0ZV9wYXltZW50X3JlbWluZGVy
                        $this->agent->late_payment_reminder();
                        break;
                }
            }            
        }

        // test 
        // function can_request($year, $semester_id, $request_type, $student_id)
        // {
        //     $this->request->can_request($year, $semester_id, $request_type, $student_id);
        // }

        // function ticket_notification($ticket_code)
        // {
        //     $this->ticket->send_notification($ticket_code, 'add_comment', 2);            
        // }

        function last_enrollment($student_id)
        {
            $result = $this->studentModel->get_student_last_enrollment($student_id);

            echo '<pre>';
            var_dump($result);
            echo '</pre>';

        }
    }