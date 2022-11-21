<?php
    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    class Student extends EduAppGT
    {
        /*
            Software:       MySchool - School Management System
            Author:         DHCoder - Software, Web and Mobile developer.
            Author URI:     https://dhcoder.com
            PHP:            5.6+
            Created:        22 September 2021.
            Base:           EduAppGT
        */

        private $runningYear = '';
        private $runningSemester = '';
        private $useDailyMarks = false;
        
        function __construct()
        {
            parent::__construct();
            $this->load->database();
            $this->load->library('session');
            $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
            $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
            $this->output->set_header('Pragma: no-cache');
            $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

            $this->runningYear      = $this->crud->getInfo('running_year'); 
            $this->runningSemester  = $this->crud->getInfo('running_semester'); 
            $this->useDailyMarks    = $this->crud->getInfo('use_daily_marks');
        }

        //Live classes function.
        function meet($task = "", $document_id = "")
        {
            $this->isStudent();
            $data['page_name']              = 'meet';
            $data['data']              = $task;
            $data['page_title']             = getPhrase('live');
            $this->load->view('backend/index', $data);
        }
        
        //Update delivery function.
        function homework_edit($param1 = "", $param2 = "")
        {
            $this->isStudent();
            $data['page_name']         = 'homework_edit';
            $data['delivery_id']       = base64_decode($param1);
            $data['page_title']        = getPhrase('edit_delivery');
            $this->load->view('backend/index', $data);
        }
        
        //Enter to Live Class function.
        function liveClass($param1 = '', $param2 = '')
        {
            $this->isStudent();
            $live_id  = base64_decode($param1);
            // $this->crud->saveLiveAttendance($live_id);

            if($param2 == 2){

                $this->db->where('live_id', $live_id);
                $links = $this->db->get('live')->row_array();

                header('Location: '.$links['siteUrl'].'');
            }   else{
                redirect(base_url() . 'student/live/'.base64_encode($live_id), 'refresh');
            }
        }
        
        //Student progress function.
        function progress($task = "", $document_id = "")
        {
            $this->isStudent();
            $data['page_name']              = 'progress';
            $data['page_title']             = getPhrase('progress');
            $this->load->view('backend/index', $data);
        }
        
        //Live Class Function.
        function live($task = "", $document_id = "")
        {
            $this->isStudent();
            $_id = base64_decode($task);
            $this->crud->saveLiveStatus($_id);
            $data['page_name']              = 'live';
            $data['live_id']                = $task;
            $data['page_title']             = getPhrase('live');
            $this->load->view('backend/index', $data);
        }
        
        //Create teacher report function.
        function listado_de_reportes($param1 = '', $param2 = '', $param3 = '') 
        {
            $this->isStudent();
            if ($param1 == 'create')
            {
                $this->crud->createTeacherReport();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'student/send_report/', 'refresh');
            }
        }
        
        //Marks print view function.
        function marks_print_view($data) 
        {
            $this->isStudent();
            
            $student_id = $this->session->userdata('login_user_id');
            $class_id = $this->db->get_where('enroll' , array('student_id' => $student_id , 'year' => $this->runningYear, 'semester_id'=> $this->runningSemester))->row()->class_id;

            if($this->useDailyMarks){
                $page_data['data']       =   $data;
                $page_data['class_id']   =   $class_id;
                $page_data['student_id'] =   $student_id;
                $this->load->view('backend/student/daily_marks_print_view', $page_data);
            } else {
                $page_data['data']       =   $data;
                $page_data['class_id']   =   $class_id;
                $page_data['student_id'] =   $student_id;
                $this->load->view('backend/student/marks_print_view', $page_data);
            }
        }

        //Marks print view function.
        function marks_print_all_view($data) 
        {
            $this->isStudent();
            
            $student_id = $this->session->userdata('login_user_id');
            $class_id = $this->db->get_where('enroll' , array('student_id' => $student_id , 'year' => $this->runningYear, 'semester_id'=> $this->runningSemester))->row()->class_id;

            if($this->useDailyMarks){
                $page_data['data']       =   $data;
                $page_data['class_id']   =   $class_id;
                $page_data['student_id'] =   $student_id;
                $this->load->view('backend/student/daily_marks_all_print_view', $page_data);
            } else {
                $page_data['data']       =   $data;
                $page_data['class_id']   =   $class_id;
                $page_data['student_id'] =   $student_id;
                $this->load->view('backend/student/marks_print_all_view', $page_data);
            }
        }

        //Marks print view function.
        function past_marks_print_view($data) 
        {
            $this->isStudent();
            
            $student_id = $this->session->userdata('login_user_id');

            if($this->useDailyMarks){
                $page_data['data']       =   $data;
                $page_data['student_id'] =   $student_id;
                $this->load->view('backend/student/past_daily_marks_print_view', $page_data);
            } else {
                $page_data['data']       =   $data;
                $page_data['student_id'] =   $student_id;
                $this->load->view('backend/student/past_marks_print_view', $page_data);
            }
        }
        
        //Submit online exam function.
        function submit_online_exam($online_exam_id = "")
        {
            $this->isStudent();
            $this->academic->submitExam($online_exam_id);
            redirect(base_url() . 'student/online_exams/'.$this->input->post('datainfo').'/', 'refresh');
        }
        
        //View online exam result function.
        function online_exam_result($param1 = '', $param2 = '') 
        {
            $this->isStudent();
            //Online exam validator
            $results      = $this->db->get_where('online_exam', array('online_exam_id' => $param1))->row()->results;
            $exam_date    = $this->db->get_where('online_exam', array('online_exam_id' => $param1))->row()->exam_date;
            $time_start   = $this->db->get_where('online_exam', array('online_exam_id' => $param1))->row()->time_start;
            $time_end     = $this->db->get_where('online_exam', array('online_exam_id' => $param1))->row()->time_end;
            $classId      = $this->db->get_where('online_exam', array('online_exam_id' => $param1))->row()->class_id;
            $sectionId    = $this->db->get_where('online_exam', array('online_exam_id' => $param1))->row()->section_id;
            $subjectId    = $this->db->get_where('online_exam', array('online_exam_id' => $param1))->row()->subject_id;
            $redirect = base64_encode($classId.'-'.$sectionId.'-'.$subjectId);
            if($results == 3){
                $addMinutes = 15;   
            }elseif($results == 4){
                $addMinutes = 30;
            }
            $current_time          = time();
            $exam_start_time       = strtotime(date('Y-m-d', $exam_date).' '.$time_start);
            $exam_end_time         = strtotime(date('Y-m-d', $exam_date).' '.$time_end);
            
            $startResult           = strtotime($time_end);
            $endResult             = $addMinutes*60;
            $newResult             = date("H:i",$startResult+$endResult).':00';
            $exam_end_time_results = strtotime(date('Y-m-d', $exam_date).' '.$newResult);
            
            if($results == 0 || $results == 1){
                $this->session->set_flashdata('flash_message' , getPhrase('ask_for_results'));
                redirect(base_url() . 'student/online_exams/'.$redirect, 'refresh');
            }
            elseif($current_time < $exam_end_time && $current_time < $exam_end_time_results && $results != 2){
                $this->session->set_flashdata('flash_message' , getPhrase('waiting_for_results'));
                redirect(base_url() . 'student/online_exams/'.$redirect, 'refresh');
            }
            //Online exam validator.                                  
            $page_data['page_name'] = 'online_exam_result';
            $page_data['param2'] = $param1;
            $page_data['page_title'] = getPhrase('online_exam_results');
            $this->load->view('backend/index', $page_data);
        }
        
        //Take online exam function.
        function take_online_exam($param1  = '', $param2 = '') 
        {
            $this->isStudent();
            if($param1 == 'start')
            {
                $password = md5($this->db->get_where('online_exam', array('code' => html_escape($this->input->post('rand'))))->row()->password);
                $user_password = md5($this->input->post('password'));
                if($password == $user_password)
                {
                    $online_exam_id = $this->db->get_where('online_exam', array('code' => $this->input->post('rand')))->row()->online_exam_id;
                    $student_id = $this->session->userdata('login_user_id');
                    $check = array('student_id' => $student_id, 'online_exam_id' => $online_exam_id);
                    $taken = $this->db->where($check)->get('online_exam_result')->num_rows();
                    $this->crud->change_online_exam_status_to_attended_for_student($online_exam_id);

                    $status = $this->crud->check_availability_for_student($online_exam_id);
                    if ($status == 'submitted'){
                        $page_data['page_name']  = 'page_not_found';
                    }
                    else{
                        $page_data['page_name']  = 'online_exam_take';
                    }
                }else{
                    $this->session->set_flashdata('flash_message' , getPhrase('password_does_not_match'));
                    redirect(base_url() . 'student/examroom/'.$this->input->post('rand'), 'refresh');
                }
            }
            $page_data['page_title'] = getPhrase('online_exam');
            $page_data['online_exam_id'] = $online_exam_id;
            $page_data['exam_info'] = $this->db->get_where('online_exam', array('online_exam_id' => $online_exam_id));
            $this->load->view('backend/index', $page_data);
        }
        
        //Index function.
        public function index()
        {
            if ($this->session->userdata('student_login') != 1)
            {
                redirect(base_url(), 'refresh');
            }else{
                redirect(base_url().'student/panel/', 'refresh');
            }
        }
        
        //Subject dashboard function
        function subject_dashboard($data  = '') 
        {
            $this->isStudent();
            $page_data['data'] = $data;
            $page_data['page_name']    = 'subject_dashboard';
            $page_data['page_title']   = getPhrase('subject_dashboard');
            $this->load->view('backend/index',$page_data);
        }
        
        //Birthdays function.
        function birthdays()
        {
            $this->isStudent();
            $page_data['page_name']  = 'birthdays';
            $page_data['page_title'] = getPhrase('birthdays');
            $this->load->view('backend/index', $page_data);
        }
        
        //Calendar function.
        function calendar($param1 = '', $param2 = '')
        {
            $this->isStudent();
            parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
            if(html_escape($_GET['id']) != "")
            {
                $notify['status'] = 1;
                $this->db->where('id', html_escape($_GET['id']));
                $this->db->update('notification', $notify);

                $table      = 'notification';
                $action     = 'update';
                $update_id  = html_escape($_GET['id']);
                $this->crud->save_log($table, $action, $update_id, $notify);

            }
            $page_data['page_name']  = 'calendar';
            $page_data['page_title'] = getPhrase('calendar');
            $page_data['code']   = $code;
            $this->load->view('backend/index', $page_data); 
        }
        
        //Chat group function.
        function group($param1 = "group_message_home", $param2 = "")
        {
            $this->isStudent();
            if ($param1 == 'group_message_read') 
            {
                $page_data['current_message_thread_code'] = $param2;
            }
            else if($param1 == 'send_reply')
            {
                $this->crud->send_reply_group_message($param2);
                $this->session->set_flashdata('flash_message', getPhrase('message_sent'));
                redirect(base_url() . 'student/group/group_message_read/'.$param2, 'refresh');
            }
            $page_data['message_inner_page_name']   = $param1;
            $page_data['page_name']                 = 'group';
            $page_data['page_title']                = getPhrase('message_group');
            $this->load->view('backend/index', $page_data);
        }

        //Submit poll response function
        function polls($param1 = '', $param2 = '')
        {
            $this->isStudent();
            if($param1 == 'response')
            {
                $this->crud->pollReponse();
            }
        }

        //Take online exam function.
        function take($exam_code  = '')
        {
            $this->isStudent();
            $page_data['questions'] = $this->db->get_where('questions' , array('exam_code' => $exam_code))->result_array();
            if($this->db->get_where('student_question',array('exam_code'=>$exam_code,'student_id'=>$this->session->userdata('login_user_id')))->row()->answered == 'answered')
            {
                redirect(base_url() . 'student/online_exams/', 'refresh');
            } 
            $page_data['exam_code'] = $exam_code;
            $page_data['page_name']   = 'take'; 
            $page_data['page_title']  = "";
            $this->load->view('backend/index', $page_data);
        }

        //Attendance report function.
        function attendance_report($data = '',$month = '', $year = '') 
        {
            $this->isStudent();
            $page_data['month']        = $month;
            $page_data['data']         = $data;
            $page_data['year']         = $year;
            $page_data['page_name']    = 'attendance_report';
            $page_data['page_title']   = getPhrase('attendance_report');
            $this->load->view('backend/index',$page_data);
        }

        //Exam room function.
        function examroom($online_exam_code = "") 
        {
            $this->isStudent();
            $online_exam_id = $this->db->get_where('online_exam', array('code' => $online_exam_code))->row()->online_exam_id;
            $class_id = $this->db->get_where('online_exam', array('code' => $online_exam_code))->row()->class_id;
            $section_id = $this->db->get_where('online_exam', array('code' => $online_exam_code))->row()->section_id;
            $subject_id = $this->db->get_where('online_exam', array('code' => $online_exam_code))->row()->subject_id;
            $student_id = $this->session->userdata('login_user_id');
            $check = array('student_id' => $student_id, 'online_exam_id' => $online_exam_id);
            $taken = $this->db->where($check)->get('online_exam_result')->num_rows();
            $this->crud->change_online_exam_status_to_attended_for_student($online_exam_id);
            $status = $this->crud->check_availability_for_student($online_exam_id);
            if ($status == 'submitted')
            {
                redirect(base_url() . 'student/online_exams/'.base64_encode($class_id.'-'.$section_id.'-'.$subject_id).'/', 'refresh');
            }
            else{
                $page_data['page_name']    = 'examroom';
            }
            $page_data['code'] = $online_exam_code;
            $page_data['page_title']   = getPhrase('take_exam');
            $this->load->view('backend/index',$page_data);
        }

        //Exam function.
        function exam($code = "") 
        { 
            $this->isStudent();
            $page_data['questions'] = $this->db->get_where('questions' , array('exam_code' => $code))->result_array();
            if($this->db->get_where('student_question',array('exam_code'=>$code,'student_id'=>$this->session->userdata('login_user_id')))->row()->answered == 'answered')
            {
                redirect(base_url() . 'student/online_exams/', 'refresh');
            } 
            $page_data['exam_code'] = $code; 
            $page_data['page_name']    = 'exam';
            $page_data['page_title']   = getPhrase('online_exam');
            $this->load->view('backend/index',$page_data);
        }

        //Exam results function.
        function exam_results($code = '') 
        {
            $this->isStudent();
            $page_data['exam_code'] = $code;
            $page_data['page_name']     = 'exam_results';
            $page_data['page_title']    = getPhrase('exam_results');
            $this->load->view('backend/index', $page_data);
        }
        
        //Print marks function.
        function print_marks() 
        {
            $this->isStudent();
            $page_data['month']        = date('m');
            $page_data['page_name']    = 'print_marks';
            $page_data['page_title']   = "";
            $this->load->view('backend/index',$page_data);
        }

        //Subject marks function.
        function subject_marks($data  = '', $param2  = '') 
        {
            $this->isStudent();
            if($param2 != ""){
                $page = $param2;
            }else{
                $info = base64_decode( $data );
                $ex = explode( '-', $info );
                $page = $this->academic->getClassCurrentUnit($ex[0]);
            }
            parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
            if(html_escape($_GET['id']) != "")
            {
                $notify['status'] = 1;
                $this->db->where('id', html_escape($_GET['id']));
                $this->db->update('notification', $notify);

                $table      = 'notification';
                $action     = 'update';
                $update_id  = html_escape($_GET['id']);
                $this->crud->save_log($table, $action, $update_id, $notify);
            }

            if($this->useDailyMarks){
                $page_data['unit_id'] = $page;
                $page_data['data'] = $data;
                $page_data['page_name']    = 'subject_daily_marks';
                $page_data['page_title']   =  getPhrase('subject_daily_marks');
                $this->load->view('backend/index',$page_data);
            }
            else {
                $page_data['unit_id'] = $page;
                $page_data['data'] = $data;
                $page_data['page_name']    = 'subject_marks';
                $page_data['page_title']   =  getPhrase('subject_marks');
                $this->load->view('backend/index',$page_data);
            }
        }

        //Subject daily marks 
        function subject_daily_marks($data = '', $param2 = '')
        {
            $this->isStudent();
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Boom baby we a POST method
           
                $unit_id = $this->input->post('unit_id');
                $search_date = $this->input->post('search_date');
            }
            else {
                $search_date = date('Y-m-d');
            }
    
            // echo $search_date;

            $page_data['data']         = $data;
            $page_data['unit_id']      = $unit_id;
            $page_data['search_date']  = $search_date;
            $page_data['page_name']    = 'subject_daily_marks_all';
            $page_data['page_title']   =  getPhrase('subject_daily_marks');
            $this->load->view('backend/index',$page_data);
        }

        //View invoice function.
        function view_invoice($payment_id  = '') 
        {
            $this->isStudent();

            // $page_data['invoice_id'] = $id;
            // $page_data['page_name']    = 'view_invoice';
            // $page_data['page_title']   = getPhrase('invoice');
            // $this->load->view('backend/index',$page_data);

            $page_data['payment_id'] =  base64_decode($payment_id);
            $page_data['page_name']  = 'payment_invoice';
            $page_data['page_title'] =  getPhrase('payment_invoice');
            $this->load->view('backend/print/payment_invoice', $page_data);
        }

        //View behavior report function.
        function view_report($code  = '') 
        {
            $this->isStudent();
            $page_data['code'] = $code;
            $page_data['page_name']    = 'view_report';
            $page_data['page_title']   = getPhrase('view_report');
            $this->load->view('backend/index',$page_data);
        }

        //My Profile function.
        function my_profile($param1 = '', $param2 = '') 
        {
            $this->isStudent();
            if($param1 == 'remove_facebook')
            {
                $this->user->removeFacebook();
                $this->session->set_flashdata('flash_message' , getPhrase('facebook_delete'));
                redirect(base_url() . 'student/my_profile/', 'refresh');
            }
            if($param1 == '1')
            {
                $this->session->set_flashdata('error_message' , getPhrase('google_err'));
                redirect(base_url() . 'student/my_profile/', 'refresh');
            }
            if($param1 == '3')
            {
                $this->session->set_flashdata('error_message' , getPhrase('facebook_err'));
                redirect(base_url() . 'student/my_profile/', 'refresh');
            }
            if($param1 == '2')
            {
                $this->session->set_flashdata('flash_message' , getPhrase('google_true'));
                redirect(base_url() . 'student/my_profile/', 'refresh');
            }
            if($param1 == '4')
            {
                $this->session->set_flashdata('flash_message' , getPhrase('facebook_true'));
                redirect(base_url() . 'student/my_profile/', 'refresh');
            }  
            if($param1 == 'remove_google')
            {
                $this->user->removeGoogle();
                $this->session->set_flashdata('flash_message' , getPhrase('google_delete'));
                redirect(base_url() . 'student/my_profile/', 'refresh');
            }
            if($param1 == 'update')
            {
                $this->user->updateCurrentStudent();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url().'student/student_update/','refresh');
            }
            $page_data['output']       = $this->crud->getGoogleURL();
            $page_data['page_name']    = 'my_profile';
            $page_data['page_title']   = getPhrase('profile');
            $this->load->view('backend/index',$page_data);
        }

        //Attendance report selector.
        function attendance_report_selector()
        {
            $this->isStudent();
            $data['year']       = $this->input->post('year');
            $data['month']      = $this->input->post('month');
            $data['data']       = $this->input->post('data');
            redirect(base_url().'student/attendance_report/'.$data['data'].'/'.$data['month'].'/'.$data['year'],'refresh');
        }

        //Student dashboard function.
        function panel()
        {
            $this->isStudent();
            parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
            
            if(html_escape($_GET['id']) != "")
            {
                $notify['status'] = 1;
                $this->db->where('id', html_escape($_GET['id']));
                $this->db->update('notification', $notify);
                
                $table      = 'notification';
                $action     = 'update';
                $update_id  = html_escape($_GET['id']);
                $this->crud->save_log($table, $action, $update_id, $notify);
            }
            $page_data['page_name']  = 'panel';
            $page_data['page_title'] = getPhrase('dashboard');
            $this->load->view('backend/index', $page_data);
        }
        
        //Teachers function.
        function teachers($param1 = '', $param2 = '', $param3 = '')
        {
            $this->isStudent();
            $page_data['page_name']  = 'teachers';
            $page_data['page_title'] = getPhrase('teachers');
            $this->load->view('backend/index', $page_data);
        }
        
        //Subject function.
        function subject($param1 = '', $param2 = '')
        {
            $this->isStudent();
            $student_profile         = $this->db->get_where('student', array('student_id' => $this->session->userdata('student_id')))->row();
            $student_class_id        = $this->db->get_where('enroll' , array('student_id' => $student_profile->student_id,'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
            ))->row()->class_id;
            $page_data['subjects']   = $this->db->get_where('subject', array('class_id' => $student_class_id,'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description))->result_array();
            $page_data['page_name']  = 'subject';
            $page_data['page_title'] = getPhrase('subjects');
            $this->load->view('backend/index', $page_data);
        }
        
        //My Marks function.
        function my_marks() 
        {
            $this->isStudent();
            $student_id = $this->session->userdata('login_user_id');
            $class_id = $this->db->get_where('enroll' , array('student_id' => $student_id , 'year' => $this->runningYear, 'semester_id'=> $this->runningSemester))->row()->class_id;

            if($this->useDailyMarks){
                $page_data['class_id']   =   $class_id;
                $page_data['student_id'] =   $student_id;
                $page_data['page_name']  =   'my_daily_marks';
                $page_data['page_title'] =   getPhrase('marks');
                $this->load->view('backend/index', $page_data);
            } else {
                $page_data['class_id']   =   $class_id;
                $page_data['student_id'] =   $student_id;
                $page_data['page_name']  =   'my_marks';
                $page_data['page_title'] =   getPhrase('marks');
                $this->load->view('backend/index', $page_data);
            }
        }

        //My Marks function.
        function my_past_marks() 
        {
            $this->isStudent();
            $student_id = $this->session->userdata('login_user_id');

            if($this->useDailyMarks){
                $page_data['student_id'] =   $student_id;
                $page_data['page_name']  =   'my_past_daily_marks';
                $page_data['page_title'] =   getPhrase('marks');
                $this->load->view('backend/index', $page_data);
            } else {
                $page_data['student_id'] =   $student_id;
                $page_data['page_name']  =   'my_past_marks';
                $page_data['page_title'] =   getPhrase('marks');
                $this->load->view('backend/index', $page_data);
            }
        }
        
        //Class routine function.
        function class_routine($param1 = '', $param2 = '', $param3 = '')
        {
            $this->isStudent();
            $student_profile         = $this->db->get_where('student', array('student_id' => $this->session->userdata('student_id')))->row();
            $page_data['class_id']   = $this->db->get_where('enroll' , array('student_id' => $student_profile->student_id,'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description))->row()->class_id;
            $page_data['student_id'] = $student_profile->student_id;
            $page_data['page_name']  = 'class_routine';
            $page_data['page_title'] = getPhrase('class_routine');
            $this->load->view('backend/index', $page_data);
        }

        //Homework function.
        function homework($student_id = '')
        {
            $this->isStudent();
            $page_data['page_name']  = 'homework';
            $page_data['page_title'] = getPhrase('homework');
            $page_data['data']   = $student_id;
            $this->load->view('backend/index', $page_data);
        }

        //Manage online exams function.
        function online_exams($student_id = '')
        {
            $this->isStudent();
            parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
            if(html_escape($_GET['id']) != "")
            {
                $notify['status'] = 1;
                $this->db->where('id', html_escape($_GET['id']));
                $this->db->update('notification', $notify);

                $table      = 'notification';
                $action     = 'update';
                $update_id  = html_escape($_GET['id']);
                $this->crud->save_log($table, $action, $update_id, $notify);
            }
            $info = base64_decode($student_id);
            $ex = explode('-', $info);
            $page_data['exams']      = $this->crud->available_exams($this->session->userdata('login_user_id'),$ex[2]);
            $page_data['data']       = $student_id;
            $page_data['page_name']  = 'online_exams';
            $page_data['page_title'] = getPhrase('online_exams');
            $page_data['student_id'] = $student_id;
            $this->load->view('backend/index', $page_data);
        }
        
        //Download book function.
        function descargar_libro($libro_code = '')
        {
            $this->isStudent();
            $file_name = $this->db->get_where('libreria', array('libro_code' => $libro_code))->row()->file_name;
            $this->load->helper('download');
            $data = file_get_contents("public/uploads/libreria/" . $file_name);
            $name = $file_name;
            force_download($name, $data);
        }

        //Invoices function.
        function invoice($param1 = '', $param2 = '', $param3 = '')
        {
            $this->isStudent();
            if ($param1 == 'make_payment') 
            {
                $this->payment->makePayPal();
            }
            if ($param1 == 'paypal_cancel') 
            {
                redirect(base_url() . 'student/invoice/', 'refresh');
            }
            if ($param1 == 'paypal_success') 
            {
                $this->payment->paypalSuccess();
                $this->session->set_flashdata('error_message' , getPhrase('thanks_for_your_payment'));
                redirect(base_url() . 'student/invoice/', 'refresh');
            }
            $student_profile         = $this->db->get_where('student', array('student_id'   => $this->session->userdata('student_id')))->row();
            $student_id              = $student_profile->student_id;
            $page_data['invoices']   = $this->db->get_where('invoice', array('student_id' => $student_id))->result_array();
            $page_data['student_id'] = $student_id;
            $page_data['page_name']  = 'invoice';
            $page_data['page_title'] = getPhrase('invoice');
            $this->load->view('backend/index', $page_data);
        }
        
        //Student info function.
        function student_info($student_id  = '', $param1='')
        {
            $this->isStudent();
            $page_data['output']     = $this->crud->getGoogleURL();
            $page_data['page_name']  = 'student_info';
            $page_data['page_title'] =  getPhrase('student_portal');
            $page_data['student_id'] =  $student_id;
            $this->load->view('backend/index', $page_data);
        }

        //Student update info function.
        function student_update($student_id = '', $param1='')
        {
            $this->isStudent();
            $page_data['page_name']  = 'student_update';
            $page_data['output']     = $this->crud->getGoogleURL();
            $page_data['page_title'] =  getPhrase('student_portal');
            $page_data['student_id'] =  $student_id;
            $this->load->view('backend/index', $page_data);
        }
        
        //Manage notifications function.    
        function notifications() 
        {
            $this->isStudent();
            $page_data['page_name']  =  'notifications';
            $page_data['page_title'] =  getPhrase('your_notifications');
            $this->load->view('backend/index', $page_data);
        }

        //Send teacher report function.
        function send_report() 
        {
            $this->isStudent();
            $page_data['page_name'] = 'send_report';
            $page_data['page_title'] = getPhrase('teacher_report');
            $this->load->view('backend/index', $page_data);
        }

        //Noticeboard function.
        function noticeboard($param1 = '', $param2 = '') 
        {
            $this->isStudent();
            $page_data['page_name'] = 'noticeboard';
            $page_data['page_title'] = getPhrase('news');
            $this->load->view('backend/index', $page_data);
        }

        //Chat message function.
        function message($param1 = 'message_home', $param2 = '', $param3 = '') 
        {
            $this->isStudent();
            parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
            if(html_escape($_GET['id']) != "")
            {
                $notify['status'] = 1;
                $this->db->where('id', html_escape($_GET['id']));
                $this->db->update('notification', $notify);

                $table      = 'notification';
                $action     = 'update';
                $update_id  = html_escape($_GET['id']);
                $this->crud->save_log($table, $action, $update_id, $notify);
            }
            if ($param1 == 'send_new') 
            {
                $this->session->set_flashdata('flash_message' , getPhrase('message_sent'));
                $message_thread_code = $this->crud->send_new_private_message();
                redirect(base_url() . 'student/message/message_read/' . $message_thread_code, 'refresh');
            }
            if ($param1 == 'send_reply') 
            {
                $this->session->set_flashdata('flash_message' , getPhrase('reply_sent'));
                $this->crud->send_reply_message($param2);
                redirect(base_url() . 'student/message/message_read/' . $param2, 'refresh');
            }
            if ($param1 == 'message_read') 
            {
                $page_data['current_message_thread_code'] = $param2;
                $this->crud->mark_thread_messages_read($param2);
            }
            $page_data['infouser']                  = $param2;
            $page_data['message_inner_page_name']   = $param1;
            $page_data['page_name']                 = 'message';
            $page_data['page_title']                = getPhrase('private_message');
            $this->load->view('backend/index', $page_data);
        }
        
        //Study material function
        function study_material($task = "", $document_id = "")
        {
            $this->isStudent();
            parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
            if(html_escape($_GET['id']) != "")
            {
                $notify['status'] = 1;
                $this->db->where('id', html_escape($_GET['id']));
                $this->db->update('notification', $notify);

                $table      = 'notification';
                $action     = 'update';
                $update_id  = html_escape($_GET['id']);
                $this->crud->save_log($table, $action, $update_id, $notify);
            }
            $data['page_name']              = 'study_material';
            $data['data']                   = $task;
            $data['page_title']             = getPhrase('study_material');
            $this->load->view('backend/index', $data);
        }

        //Manage library function.
        function library($param1 = '', $param2 = '', $param3 = '')
        {
            $this->isStudent();
            parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
            if(html_escape($_GET['id']) != "")
            {
                $notify['status'] = 1;
                $this->db->where('id', html_escape($_GET['id']));
                $this->db->update('notification', $notify);

                $table      = 'notification';
                $action     = 'update';
                $update_id  = html_escape($_GET['id']);
                $this->crud->save_log($table, $action, $update_id, $notify);
            }
            if ($param1 == "request")
            {
                $this->academic->requestStudentBook();
                $this->session->set_flashdata('flash_message', getPhrase('successfully_updated'));
                redirect(base_url() . 'student/library/' . $param2, 'refresh');
            }
            $page_data['page_name']  = 'library';
            $page_data['page_title'] = getPhrase('library');
            $this->load->view('backend/index', $page_data);
        }

        //Manage books function.
        function books($param1 = '', $param2 = '', $param3 = '')
        {
            $this->isStudent();
            
            $page_data['post_code'] = $param1;
            $page_data['page_name']  = 'books';
            $page_data['page_title'] = getPhrase('books');
            $this->load->view('backend/index', $page_data);
        }

        //Homework detials function.
        function homeworkroom($param1 = '' , $param2 = '')
        {
            $this->isStudent();
            parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
            if(html_escape($_GET['id']) != "")
            {
                $notify['status'] = 1;
                $this->db->where('id', html_escape($_GET['id']));
                $this->db->update('notification', $notify);

                $table      = 'notification';
                $action     = 'update';
                $update_id  = html_escape($_GET['id']);
                $this->crud->save_log($table, $action, $update_id, $notify);
            }
            $page_data['homework_code'] = $param1;
            $page_data['page_name']   = 'homework_room'; 
            $page_data['page_title']  = getPhrase('homework');
            $this->load->view('backend/index', $page_data);
        }

        //Send homework function.
        function delivery($param1 = '', $param2 = '',$param3 = '')
        {
            $this->isStudent();
            if($param1 == 'file')
            {
                $this->academic->sendFileHomework($param2);
                $this->session->set_flashdata('flash_message', getPhrase('successfully_updated'));
                redirect(base_url() . 'student/homeworkroom/' . $param2, 'refresh');
            }
            if($param1 == 'text')
            {
                $this->academic->sendTextHomework($param2);
                $this->session->set_flashdata('flash_message', getPhrase('successfully_updated'));
                redirect(base_url() . 'student/homeworkroom/' . $param2, 'refresh');
            }
            if($param1 == 'update_text')
            {
                $this->academic->updateTextHomework($param2);
                $this->session->set_flashdata('flash_message', getPhrase('successfully_updated'));
                redirect(base_url() . 'student/homeworkroom/' . $param3, 'refresh');
            }
            if($param1 == 'update_file')
            {
                $this->academic->updateFileHomework($param2,$param3);
                $this->session->set_flashdata('flash_message', getPhrase('successfully_updated'));
                redirect(base_url() . 'student/homeworkroom/' . $param3, 'refresh');
            }
            if($param1 == 'delete')
            {
                $this->academic->deleteFileHomework($param2);
                $this->session->set_flashdata('flash_message', getPhrase('successfully_deleted'));
                redirect(base_url() . 'student/homeworkroom/' . $param3, 'refresh');
            }
        }

        //Homework file function.
        function homework_file($param1 = '', $param2 = '', $param3 = '') 
        {
            $this->isStudent();
            $homework_code = $this->db->get_where('homework', array('homework_id'))->row()->homework_code;
            if ($param1 == 'upload')
            {
                $this->crud->upload_homework_file($param2);
                $this->session->set_flashdata('flash_message', getPhrase('successfully_updated'));
                redirect(base_url() . 'student/homeworkroom/file/' . $param2, 'refresh');
            }
            else if ($param1 == 'download')
            {
                $this->crud->download_homework_file($param2);
            }
        }

        //Forum function.
        function forumroom($param1 = '' , $param2 = '')
        {
            $this->isStudent();
            $page_data['post_code'] = $param1;
            $page_data['page_name']   = 'forum_room'; 
            $page_data['page_title']  = getPhrase('forum');
            $this->load->view('backend/index', $page_data);
        }

        //Create report message function.
        function create_report_message($code = '') 
        {
            $this->isStudent();
            $this->crud->createReportMessage();
        }  

        //Delete notifications function.
        function notification($param1 ='', $param2 = '')
        {
            $this->isStudent();
            if($param1 == 'delete')
            {
                $this->crud->deleteNotification($param2);
                $this->session->set_flashdata('flash_message', getPhrase('successfully_deleted'));
                redirect(base_url() . 'student/notifications/', 'refresh');
            }
        }

        //Create forum message function.
        function forum_message($param1 = '', $param2 = '', $param3 = '')
        {
            $this->isStudent();
            if ($param1 == 'add') 
            {
                $this->crud->create_post_message($this->input->post('post_code')); 
            }
        }

        //Forum page function.
        function forum($param1 = '', $param2 = '', $student_id = '') 
        {
            $this->isStudent();
            if ($param1 == 'create') 
            {
                $post_code = $this->crud->create_post();
                $this->session->set_flashdata('flash_message', getPhrase('successfully_added'));
                redirect(base_url() . 'student/forumroom/post/' . $post_code , 'refresh');
            }
            $page_data['page_name'] = 'forum';
            $page_data['page_title'] = getPhrase('forum');
            $page_data['data']   = $param1;
            $this->load->view('backend/index', $page_data);
        }
        
        //Request permission function.
        function request($param1 = "", $param2 = "")
        {
            $this->isStudent();
            parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);

            if(html_escape($_GET['id']) != "")
            {
                $notify['status'] = 1;
                $this->db->where('id', html_escape($_GET['id']));
                $this->db->update('notification', $notify);

                $table      = 'notification';
                $action     = 'update';
                $update_id  = html_escape($_GET['id']);
                $this->crud->save_log($table, $action, $update_id, $notify);
            }
            if ($param1 == "create")
            {
                $this->request->student_permission_request();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'student/request/', 'refresh');
            }
            if ($param1 == "vacation") 
            {
                $this->request->student_vacation_request();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'student/request/', 'refresh');
            }

            $data['page_name']  = 'request';
            $data['page_title'] = getPhrase('permissions');
            $this->load->view('backend/index', $data);
        }
        
        //Check student session.
        function isStudent()
        {
            if ($this->session->userdata('student_login') != 1)
            {
                redirect(base_url(), 'refresh');
            }
        }

        //Create a placement_achievement
        function placement_achievement()
        {
            $this->isStudent();

            $student_id = $this->session->userdata('login_user_id');
            $page_data['student_id'] =   $student_id;
            $page_data['page_name']  =   'placement_achievement';
            $page_data['page_title'] =   getPhrase('placement_and_achievement');
            $this->load->view('backend/index', $page_data);

        }

        //Test print view function.
        function test_print($test_id) 
        {
            $this->isStudent();
            
            $student_id = $this->session->userdata('login_user_id');

            $page_data['test_id']       = $test_id;
            $page_data['student_id']    = $student_id;
            $this->load->view('backend/student/test_print', $page_data);
            
        }

        function class_books()
        {
            $this->isStudent();            
            $student_id = $this->session->userdata('login_user_id');

            // Get the book 
            $class = $this->db->get_where('enroll' , array('student_id' => $student_id , 'year' => $this->runningYear, 'semester_id'=> $this->runningSemester))->row();

            $class_id = $class->class_id;
            $class_name = $class->name;
            
            $page_data['class_id']    = $class_id;
            $page_data['student_id']  = $student_id;
            $this->load->view('backend/student/book_'.$class_name, $page_data);
        }

        function updateAvatar(){
            if(isset($_POST["image"]))
            {
                $this->user->updateAvatar('student');
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url().'student/student_update/','refresh');
            }
            else{
                redirect(base_url().'student/student_update/','refresh');
            }
        }
        
        //End of Student.php
    }