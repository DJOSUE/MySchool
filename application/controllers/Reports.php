<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends EduAppGT
{
    /*
        Software:       MySchool - School Management System
        Author:         DHCoder - Software, Web and Mobile developer.
        Author URI:     https://dhcoder.com
        PHP:            5.6+
        Created:        22 September 2021.
        Base:           EduAppGT
    */

    private $runningYear     = '';
    private $runningSemester = '';
    private $account_type = '';
    private $fancy_path = '';
    private $role_id = 0;

    
	function __construct()
	{
		parent::__construct();
		$this->load->database();
        $this->load->library('session');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');

        $this->runningYear      =   $this->crud->getInfo('running_year'); 
        $this->runningSemester  =   $this->crud->getInfo('running_semester'); 
        $this->account_type     =   get_table_user(get_role_id()); 
        $this->role_id          =   get_role_id();
        $this->fancy_path       =   $_SERVER['DOCUMENT_ROOT'].'/application/views/backend/'.$this->account_type.'/';
    }
    
    //Index function.
    public function index()
    {
        $this->isLogin();
        echo 'test';
    }

    //Check session function.
    function isLogin($permission_for = '')
    {
        $array      = ['admin', 'accountant'];
        $login_type = get_account_type();
        
        if (!in_array($login_type, $array))
        {
            redirect(base_url(), 'refresh');
        }

        if($permission_for != '')
        {
            check_permission($permission_for);
        }
    }

/***** Accounting Reports *******************************************************************************************************************************/
    function accounting_dashboard()
    {
        $this->isLogin();

        if(has_permission('accounting_dashboard'))
        {
            $page_data['page_name']     = 'accounting_dashboard';
            $page_data['page_title']    = getPhrase('accounting_dashboard');
            $page_data['fancy_path']    = $this->fancy_path;
            $this->load->view('backend/reports/index', $page_data); 
        }
        else
        {
            redirect(base_url() . 'reports/accounting_daily_income', 'refresh');
        }
        
    }
    
    function accounting_daily_income()
    {     
        $this->isLogin();

        $cashier_all  = has_permission('accounting_dashboard');
        $login_type = get_account_type();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $date_start = html_escape($this->input->post('date_start'));
            $date_end = html_escape($this->input->post('date_end'));

            if($cashier_all)
                $cashier_id = html_escape($this->input->post('cashier_id'));
            else
                $cashier_id = $login_type.":".get_login_user_id();
        }
        else
        {
            if($cashier_all)
            {
                $date = "";
                $cashier_id = "";
            }
            else
            {
                $date = "";
                $cashier_id = $login_type.":".get_login_user_id();
            }
        }

        $page_data['date_start']    = $date_start;
        $page_data['date_end']      = $date_end;
        $page_data['cashier_id']    = $cashier_id;
        $page_data['cashier_all']   = $cashier_all; 
        $page_data['fancy_path']    = $this->fancy_path;        
        $page_data['page_name']     = 'accounting_daily_income';
        $page_data['page_title']    = getPhrase('daily_income');        
        $this->load->view('backend/reports/index', $page_data); 
    }

    function accounting_payments()
    {
        $this->isLogin();

        $interval   = date_interval_create_from_date_string('1 days');
        $objDate    = date_create(date("m/d/Y"));
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $start_date = html_escape($this->input->post('start_date'));
            $end_date   = html_escape($this->input->post('end_date'));
            $cashier_id = html_escape($this->input->post('cashier_id'));
        }
        else
        {
            $start_date = date_format($objDate, "m/d/Y");
            $end_date   = date_format(date_add($objDate, $interval), "m/d/Y");
            $cashier_id = "";
        }
        
        $page_data['cashier_id'] = $cashier_id;
        $page_data['start_date'] = $start_date;
        $page_data['end_date']   = $end_date;
        $page_data['page_name']  = 'accounting_payments';
        $page_data['page_title'] = getPhrase('payments');
        $page_data['fancy_path']    = $this->fancy_path;
        $this->load->view('backend/reports/index', $page_data); 
    }

    function accounting_agreements()
    {
        $this->isLogin();

        $day = date('w');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $year_id     = html_escape($this->input->post('year_id'));
            $semester_id = html_escape($this->input->post('semester_id'));
        }
        else
        {
            $year_id        = $this->runningYear;
            $semester_id = $this->runningSemester;
        }
        
        $page_data['year_id']       = $year_id;
        $page_data['semester_id']   = $semester_id;
        $page_data['page_name']     = 'accounting_agreements';
        $page_data['page_title']    = getPhrase('agreements');
        $page_data['fancy_path']    = $this->fancy_path;
        $this->load->view('backend/reports/index', $page_data); 
    }

    function accounting_collection_management()
    {
        $this->isLogin();
        $end_date = date("Y-m-d");
        $program_id = '';
        $auto_payment = 0;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {            
            $end_date   = html_escape($this->input->post('end_date'));
            $program_id = html_escape($this->input->post('program_id'));
            $auto_payment = $this->input->post('auto_payment'); 
        }

        $page_data['end_date']      = $end_date;        
        $page_data['program_id']    = $program_id;
        $page_data['auto_payment']  = $auto_payment;
        $page_data['page_name']     = 'accounting_collection_management';
        $page_data['page_title']    = getPhrase('collection_management');
        $page_data['fancy_path']    = $this->fancy_path;
        $this->load->view('backend/reports/index', $page_data); 
    }

/***** Academic Reports   *******************************************************************************************************************************/

    function academic_dashboard()
    {
        $this->isLogin();

        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {   
            $year_id        = $this->input->post('year_id');
            $semester_id    = $this->input->post('semester_id');
        }
        else
        {    
            $year_id        = $this->runningYear;
            $semester_id    = $this->runningSemester;
        } 
        
        if(has_permission('academic_dashboard_report'))
        {
            $page_data['year_id']       = $year_id;
            $page_data['semester_id']   = $semester_id;  
            $page_data['page_name']     = 'academic_dashboard';
            $page_data['page_title']    = getPhrase('academic_dashboard');
            $page_data['fancy_path']    = $this->fancy_path;
            $this->load->view('backend/reports/index', $page_data); 
        }
        else
        {
            redirect(base_url() . 'reports/academic_schedule_class', 'refresh');
        }        
    }

    function academic_schedule_class()
    {
        $this->isLogin('academic_schedule_class_report');

        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {   
            $year_id        = $this->input->post('year_id');
            $semester_id    = $this->input->post('semester_id');
        }
        else
        {    
            $year_id        = $this->runningYear;
            $semester_id    = $this->runningSemester;
        } 
        
        $page_data['year_id']       = $year_id;
        $page_data['semester_id']   = $semester_id;            
        $page_data['fancy_path']    = $this->fancy_path;
        $page_data['page_name']     = 'academic_schedule_class';
        $page_data['page_title']    = getPhrase('schedule_class');
        $this->load->view('backend/reports/index', $page_data); 
    }

    function academic_student_enrollments()
    {
        $this->isLogin('academic_student_enrollments_report');

        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {   
            $year_id        = $this->input->post('year_id');
            $semester_id    = $this->input->post('semester_id');
        }
        else
        {    
            $year_id        = $this->runningYear;
            $semester_id    = $this->runningSemester;
        } 
        
        $page_data['year_id']       = $year_id;
        $page_data['semester_id']   = $semester_id;            
        $page_data['fancy_path']    = $this->fancy_path;
        $page_data['page_name']     = 'academic_student_enrollments';
        $page_data['page_title']    = getPhrase('student_enrollments');
        $this->load->view('backend/reports/index', $page_data); 
    }

    function academic_attendance()
    {
        $this->isLogin();
        
        $interval   = date_interval_create_from_date_string('1 days');
        $objDate    = date_create(date("m/d/Y"));
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $start_date = html_escape($this->input->post('start_date'));
            $end_date   = html_escape($this->input->post('end_date'));
        }
        else
        {
            $start_date = date_format($objDate, "m/d/Y");
            $end_date   = date_format(date_add($objDate, $interval), "m/d/Y");            
        }        
        
        $page_data['start_date'] = $start_date;
        $page_data['end_date']   = $end_date;
        $page_data['page_name']     = 'academic_attendance';
        $page_data['page_title']    = getPhrase('academic_attendance');
        $page_data['fancy_path']    = $this->fancy_path;
        $this->load->view('backend/reports/index', $page_data); 
    }

    function academic_absence()
    {
        $this->isLogin();
        
        $day = date('w');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $start_date = html_escape($this->input->post('start_date'));
            $end_date   = html_escape($this->input->post('end_date'));
        }
        else
        {
            $start_date = date('Y-m-d', strtotime('-'.$day.' days'));
            $end_date   = date('Y-m-d', strtotime('+'.(6-$day).' days'));         
        }        
        
        $page_data['start_date']    = $start_date;
        $page_data['end_date']      = $end_date;
        $page_data['fancy_path']    = $this->fancy_path;
        $page_data['page_name']     = 'academic_absence';
        $page_data['page_title']    = getPhrase('academic_absence');        
        $this->load->view('backend/reports/index', $page_data); 
    }

    function academic_students_achievement()
    {
        $this->isLogin('academic_students_achievement');

        $year_id = $this->input->post( 'year_id' );
        if ($year_id == '') {
            $year_id = $this->runningYear;
        }
        
        $page_data['year_id']       = $year_id;            
        $page_data['fancy_path']    = $this->fancy_path;
        $page_data['page_name']     = 'academic_students_achievement';
        $page_data['page_title']    = getPhrase('students_achievement');
        $this->load->view('backend/reports/index', $page_data); 
    }

    function academic_all_student()
    {
        $this->isLogin('academic_all_student_report');

        $page_data['page_name']     = 'academic_all_student';
        $page_data['page_title']    = getPhrase('all_student');
        $page_data['fancy_path']    = $this->fancy_path;
        $this->load->view('backend/reports/index', $page_data); 
    }

/***** Advisors Reports   *******************************************************************************************************************************/
    function advisor_dashboard()
    {
        $this->isLogin();

        $start_date = date('Y-m-d',strtotime('last Monday'));
        $end_date = date('Y-m-d',strtotime('next Saturday'));

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $start_date = html_escape($this->input->post('start_date'));
            $end_date   = html_escape($this->input->post('end_date'));
        }
        
        $page_data['start_date']    = $start_date;
        $page_data['end_date']      = $end_date;
        $page_data['page_name']     = 'advisor_dashboard';
        $page_data['page_title']    = getPhrase('advisor_dashboard');
        $page_data['fancy_path']    = $this->fancy_path;
        $this->load->view('backend/reports/index', $page_data); 
    }

/***** President Reports  *******************************************************************************************************************************/


}
