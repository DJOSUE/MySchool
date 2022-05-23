<?php
if (!defined('BASEPATH'))
{
    exit('No direct script access allowed');
}

class Books extends EduAppGT
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
    private $useDailyMarks   = '';

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

    function _remap($param) {
        $this->index($param);
    }

    //Index function.
    public function index($param = '')
    {
        $userLogged = $this->UserLogged();
        $parameters = explode('|', base64_decode($param));

        

        if($param == '' || $param == 'index' )
        {
            switch ($userLogged) {
                case 'student':
                    // Get the class and the section
                    $student_id = $this->session->userdata('login_user_id');                    
                    $class = $this->db->get_where('enroll' , array('student_id' => $student_id, 'year' => $this->runningYear, 'semester_id'=> $this->runningSemester))->row();
                    $section = $this->db->get_where('section', array('section_id' => $class->section_id, 'year' => $this->runningYear, 'semester_id'=> $this->runningSemester))->row();

                    if(strpos(strtolower($section->name), 'saturday')!== false)
                    {
                        $is_saturday = true;
                    }
                    else
                    {
                        $is_saturday = false;
                    }

                    $this->book($class->class_id, $is_saturday);
                    break;
                
                default:
                    $this->book_list();
                    break;
            }
        }
        else
        {
            $class_id    = $parameters[0];
            $is_saturday = $parameters[1];

            $this->book($class_id, $is_saturday);
        }

        
    }

    //book function.
    private function book ($class_id, $is_saturday = false)
    {
        $data['class_id']       = $class_id;
        $data['is_saturday']    = $is_saturday;
        $data['page_name']      = 'book';
        $data['page_title']     = 'beginner';
         $this->load->view('backend/books/index', $data);
        // $this->load->view('backend/index', $data);
    }

    //Book list function.
    private function book_list ()
    {
        $data['page_name']      = 'book_list';
        $data['page_title']     = 'book_list';
        $this->load->view('backend/books/index', $data);
    }

    //Check student session.
    private function UserLogged ()
    {
        if ($this->session->userdata('admin_login') == 1)
        {
            return 'admin';
        }
        else if ($this->session->userdata('teacher_login') == 1)
        {
            return 'teacher';
        }
        else if ($this->session->userdata('student_login') == 1)
        {
            return 'student';
        }
        else if ($this->session->userdata('parent_login') == 1)
        {
            return 'parent';
        }
        else
        {
            return 'none';
        }
    }
    
}