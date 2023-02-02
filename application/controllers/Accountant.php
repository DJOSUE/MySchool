<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Accountant extends EduAppGT
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
    private $useDailyMarks   = '';
    
	function __construct()
	{
		parent::__construct();
		$this->load->database();
        $this->load->library('session');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');

        $this->runningYear      = $this->crud->getInfo('running_year'); 
        $this->runningSemester  = $this->crud->getInfo('running_semester'); 
        $this->useDailyMarks    = $this->crud->getInfo('use_daily_marks');
    }
    
    //Index function.
    public function index()
    {
        $this->isAccountant();
    }

    //Get expense data.
    function get_expense(){
        $this->isAccountant();
        echo $this->crud->get_expense(date('M'));
    }
    
    //Get payment data.
    function get_payments(){
        $this->isAccountant();
        echo $this->crud->get_payments(date('M'));
    }

    //Delete notifications function.
    function notification($param1 ='', $param2 = '')
    {
        $this->isAccountant();
        if($param1 == 'delete')
        {
            $this->crud->deleteNotification($param2);   
            $this->session->set_flashdata('flash_message', getPhrase('successfully_deleted'));
            redirect(base_url() . 'accountant/notifications/', 'refresh');
        }
    }
    
    //Chat group function.
    function group($param1 = "group_message_home", $param2 = "")
    {
        $this->isAccountant();
        if ($param1 == 'group_message_read') 
        {
            $page_data['current_message_thread_code'] = $param2;
        }
        else if($param1 == 'send_reply')
        {
            $this->crud->send_reply_group_message($param2);
            $this->session->set_flashdata('flash_message', getPhrase('message_sent'));
            redirect(base_url() . 'accountant/group/group_message_read/'.$param2, 'refresh');
        } 
        $page_data['message_inner_page_name']   = $param1;
        $page_data['page_name']                 = 'group';
        $page_data['page_title']                = getPhrase('message_group');
        $this->load->view('backend/index', $page_data);
    }
    
    //Private Message function.
    function message($param1 = 'message_home', $param2 = '', $param3 = '') 
    {
        parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
        $this->isAccountant();
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
            $message_thread_code = $this->crud->send_new_private_message();
            $this->session->set_flashdata('flash_message' , getPhrase('message_sent'));
            redirect(base_url() . 'accountant/message/message_read/' . $message_thread_code, 'refresh');
        }
        if ($param1 == 'send_reply') 
        {
            $this->session->set_flashdata('flash_message' , getPhrase('reply_sent'));
            $this->crud->send_reply_message($param2);
            redirect(base_url() . 'accountant/message/message_read/' . $param2, 'refresh');
        }
        if ($param1 == 'message_read') 
        {
            $page_data['current_message_thread_code'] = $param2; 
            $this->crud->mark_thread_messages_read($param2);
        }
        $page_data['infouser'] = $param2;
        $page_data['message_inner_page_name']   = $param1;
        $page_data['page_name']                 = 'message';
        $page_data['page_title']                = getPhrase('private_messages');
        $this->load->view('backend/index', $page_data);
    }
    
    //Birthdays function.
    function birthdays()
    {
        $this->isAccountant();
        $page_data['page_name']  = 'birthdays';
        $page_data['page_title'] = getPhrase('birthdays');
        $this->load->view('backend/index', $page_data);
    }
    
    //Save poll response function.
    function polls($param1 = '', $param2 = '')
    {
        $this->isAccountant();
        if($param1 == 'response')
        {
            $this->crud->pollReponse();
        }
    }
    
    //Manage notifications function.
    function notifications()
    {
        $this->isAccountant();
        $page_data['page_name']  =  'notifications';
        $page_data['page_title'] =  getPhrase('your_notifications');
        $this->load->view('backend/index', $page_data);
    }
    
    //Manage news function.
    function news($param1 = '', $param2 = '', $param3 = '') 
    {
        $this->isAccountant();
        $page_data['page_name'] = 'news';
        $page_data['page_title'] = getPhrase('news');
        $this->load->view('backend/index', $page_data);
    }
    
    //Manage calendar function.
    function calendar($param1 = '', $param2 = '', $param3 = '') 
    {
        $this->isAccountant();
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
        $page_data['page_name'] = 'calendar';
        $page_data['page_title'] = getPhrase('calendar_events');
        $this->load->view('backend/index', $page_data);
    }
    
    //My Profile function.
    function my_profile($param1 = '' , $param2 = '')
    {
        $this->isAccountant();
        if($param1 == 'remove_facebook')
        {
            $this->user->removeFacebook();
            $this->session->set_flashdata('flash_message' , getPhrase('facebook_delete'));
            redirect(base_url() . 'accountant/my_profile/', 'refresh');
        }
        if($param1 == '1')
        {
            $this->session->set_flashdata('error_message' , getPhrase('google_err'));
            redirect(base_url() . 'accountant/my_profile/', 'refresh');
        }
        if($param1 == '3')
        {
            $this->session->set_flashdata('error_message' , getPhrase('facebook_err'));
            redirect(base_url() . 'accountant/my_profile/', 'refresh');
        }
        if($param1 == '2')
        {
            $this->session->set_flashdata('flash_message' , getPhrase('google_true'));
            redirect(base_url() . 'accountant/my_profile/', 'refresh');
        }
        if($param1 == '4')
        {
            $this->session->set_flashdata('flash_message' , getPhrase('facebook_true'));
            redirect(base_url() . 'accountant/my_profile/', 'refresh');
        }  
        if($param1 == 'remove_google')
        {
            $this->user->removeGoogle();
            $this->session->set_flashdata('flash_message' , getPhrase('google_delete'));
            redirect(base_url() . 'accountant/my_profile/', 'refresh');
        }
        if ($param1 == 'update_profile') 
        {
            $this->user->updateCurrentAccountant();
            $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
            redirect(base_url() . 'accountant/accountant_update/', 'refresh');
        }
        $page_data['page_name']  = 'my_profile';
        $page_data['page_title'] = getPhrase('my_profile');
        $page_data['output']     = $this->crud->getGoogleURL();
        $this->load->view('backend/index', $page_data); 
    }
    
    //Accountant update profile function.
    function accountant_update($param1 = '' , $param2 = '')
    {
        $this->isAccountant();
        $page_data['page_name']  = 'accountant_update';
        $page_data['info']       = $this->user->getAccountantInfo();
        $page_data['page_title'] = getPhrase('update_information');
        $page_data['output']     = $this->crud->getGoogleURL();
        $this->load->view('backend/index', $page_data); 
    }
    
    //Manage student payments function.
    function students_payments($param1 = '' , $param2 = '')
    {
        $this->isAccountant();
        $page_data['page_name']  = 'students_payments';
        $page_data['page_title'] = getPhrase('students_payments');
        $this->load->view('backend/index', $page_data); 
    }
    
    //Manage expenses function.
    function expense($param1 = '' , $param2 = '')
    {
        $this->isAccountant();
        if ($param1 == 'create') 
        {
            $this->crud->createExpense();
            $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
            redirect(base_url() . 'accountant/expense', 'refresh');
        }
        if ($param1 == 'edit') 
        {
            $this->crud->updateExpense($param2);
            $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
            redirect(base_url() . 'accountant/expense', 'refresh');
        }
        if ($param1 == 'delete') 
        {
            $this->crud->deleteExpense($param2);
            $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
            redirect(base_url() . 'accountant/expense/', 'refresh');
        }
        $page_data['page_name']  = 'expense';
        $page_data['page_title'] = getPhrase('expense');
        $this->load->view('backend/index', $page_data); 
    }

    //Manage expense categories function.
    function expense_category($param1 = '' , $param2 = '')
    {
        $this->isAccountant();
        if ($param1 == 'create') 
        {
            $this->crud->createCategory();
            $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
            redirect(base_url() . 'accountant/expense');
        }
        if ($param1 == 'update') 
        {
            $this->crud->updateCategory($param2);
            $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
            redirect(base_url() . 'accountant/expense');
        }
        if ($param1 == 'delete') 
        {
            $this->crud->deleteCategory($param2);
            $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
            redirect(base_url() . 'accountant/expense');
        }
        $page_data['page_name']  = 'expense';
        $page_data['page_title'] = getPhrase('expense');
        $this->load->view('backend/index', $page_data);
    }
    
    //Manage invoices function.
    function invoice($param1 = '', $param2 = '', $param3 = '')
    {
        $this->isAccountant();
        if ($param1 == 'bulk') 
        {
            $this->payment->createBulkInvoice();
            $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
            redirect(base_url() . 'accountant/students_payments/', 'refresh');
        }
        if ($param1 == 'create') 
        {
            $this->payment->singleInvoice();
            $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
            redirect(base_url() . 'accountant/students_payments/', 'refresh');
        }
        if ($param1 == 'do_update') 
        {
            $this->payment->updateInvoice($param2);
            $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
            redirect(base_url() . 'accountant/students_payments/', 'refresh');
        }
        if ($param1 == 'delete') 
        {
            $this->payment->deleteInvoice($param2);
            $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
            redirect(base_url() . 'accountant/students_payments/', 'refresh');
        }
    }
    
    //Invoice details function.
    function invoice_details($id)
    {
        $this->isAccountant();
        $page_data['invoice_id'] = $id;
        $page_data['page_title'] = getPhrase('invoice_details');
        $page_data['page_name']  = 'invoice_details';
        $this->load->view('backend/index', $page_data);
    }
    
    //New payment function.
    function new_payment($param1 = '', $param2 = '')
    {
        $this->isAccountant();
        $page_data['page_name']  = 'new_payment';
        $page_data['page_title'] = getPhrase('new_payment');
        $this->load->view('backend/index', $page_data);
    }
    
    //Accountant dashboard function.
    function panel()
    {
        $this->isAccountant();
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
        $page_data['page_title'] = getPhrase('accountant_dashboard');
        $this->load->view('backend/index', $page_data);
    }

    //Check session function.
    function isAccountant()
    {
        if ($this->session->userdata('accountant_login') != 1)
        {
            redirect(site_url('login'), 'refresh');
        }
    }

    //Time card
    function time_card( $param1 = '', $param2 = '' ) {

        $this->isAccountant();

        $page_data['page_name']  = 'time_card';
        $page_data['page_title'] = getPhrase( 'time_card' );
        $this->load->view( 'backend/index', $page_data );
    }

    //Time Card Actions
    function timesheet_actions( $param1 = '', $param2 = '' ){
        
        if ( $param1 == 'clock-in' )
        {
            $data['worker_id']  = $this->input->post( 'worker_id' );
            $data['date']       = date("Y-m-d");
            $data['start_time'] = date("H:i");
            $data['pcinfo_in']  = $this->input->post( 'pcinfo_in' );
            $this->db->insert('time_sheet', $data);

            $table      = 'time_sheet';
            $action     = 'insert';
            $insert_id  = $this->db->insert_id();
            $this->crud->save_log($table, $action, $insert_id, $data);

            $this->session->set_flashdata('flash_message', getPhrase('successfully_updated'));
        }

        if ( $param1 == 'clock-out' )
        {
            $data['end_time']   = date("H:i");
            $data['clock_out']  = $this->input->post( 'clock_out' );
            $data['note']       = $this->input->post( 'note' );
            $data['pcinfo_out'] = $this->input->post( 'pcinfo_out' );
            $this->db->where( 'timesheet_id', $param2 );
            $this->db->update( 'time_sheet', $data );
            $this->session->set_flashdata('flash_message', getPhrase('successfully_updated'));
        }

        redirect(base_url().'admin/time_card/', 'refresh');
    }

    // Time Sheet
    function time_sheet( $param1 = '', $param2 = '' ) {

        $this->isAccountant();

        $select_period_id   = $this->input->post('select_period_id');

        if($param1 != ''){
            $period_id = $param1;
        }
        else if ($select_period_id != '')
        {
            $period_id = $select_period_id;
        }
        else
        {
            $payment_period = $this->db->get_where('payment_period', array('active' => '1'))->row();
            $period_id = $payment_period->period_id;
        }
        
        $page_data['period_id'] = $period_id;
        $page_data['page_name']  = 'time_sheet';
        $page_data['page_title'] = getPhrase( 'time_sheet' );
        $this->load->view( 'backend/index', $page_data );
    }



    function payment_process($user_id, $user_type)
    {

        $this->payment->create_payment($user_id, $user_type);

        $page_data['student_id'] =  $user_id;
        $page_data['page_name']  = 'student_payments';
        $page_data['page_title'] =  getPhrase('student_payments');
        
        $this->load->view('backend/index', $page_data);
    }

    function payment_invoice($payment_id)
    {
        $this->isAccountant();            
        
        $page_data['payment_id'] =  base64_decode($payment_id);
        $page_data['page_name']  = 'payment_invoice';
        $page_data['page_title'] =  getPhrase('payment_invoice');
        $this->load->view('backend/print/payment_invoice', $page_data);
        
    }

    //End of Accountant.php

/***** Student Module ******************************************************************************************************************************/
    
    function student($param1 = '', $param2 = '', $param3 = '')
    {
        if ($param1 == 'do_update') 
        {
            $this->user->updateStudent($param2);
            $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
            redirect(base_url() . 'accountant/student_profile/'. $param2.'/', 'refresh');
        }
    }

    function student_profile($student_id, $param1='')
    {
        $this->isAccountant();
        $class_id     = $this->db->get_where('enroll' , array('student_id' => $student_id , 'year' => $this->runningYear, 'semester_id' => $this->runningSemester))->row()->class_id;
        $page_data['page_name']  = 'student_profile';
        $page_data['page_title'] =  getPhrase('student_profile');
        $page_data['student_id'] =  $student_id;
        $page_data['class_id']   =  $class_id;
        $this->load->view('backend/index', $page_data);
    }

    //Student update function.
    function student_update($student_id = '', $param1='')
    {
        $this->isAccountant();
        $page_data['page_name']  = 'student_update';
        $page_data['page_title'] =  getPhrase('student_portal');
        $page_data['student_id'] =  $student_id;
        $this->load->view('backend/index', $page_data);
    }
            
    function student_grades($student_id, $param1='')
    {
        $this->isAccountant();

        if($this->useDailyMarks){
            $page_data['page_name']  = 'student_daily_grades';
            $page_data['page_title'] =  getPhrase('student_grades');
            $page_data['student_id'] =  $student_id;
            $this->load->view('backend/index', $page_data);
        } 
        else {
            $page_data['page_name']  = 'student_marks';
            $page_data['page_title'] =  getPhrase('student_grades');
            $page_data['student_id'] =  $student_id;
            $this->load->view('backend/index', $page_data);
        }
    }

    //Student Past Marks
    function student_past_grades($student_id = '', $param1='')
    {
        $this->isAccountant();
        
        if($this->useDailyMarks){
            $page_data['page_name']  = 'student_past_daily_grades_by_semester';
            $page_data['page_title'] =  getPhrase('student_past_daily_grades_by_semester');
            $page_data['student_id'] =  $student_id;
            $this->load->view('backend/index', $page_data);
        } 
        else {
            $page_data['page_name']  = 'student_past_marks';
            $page_data['page_title'] =  getPhrase('student_past_marks');
            $page_data['student_id'] =  $student_id;
            $this->load->view('backend/index', $page_data);
        }
    }

    //Student Profile Attendance function.
    function student_attendance($student_id = '', $param1='', $param2 = '', $param3 = '', $param4 = '', $param5 = '')
    {
        $this->isAccountant();

        $page_data['page_name']  = 'student_attendance';
        $page_data['page_title'] =  getPhrase('student_attendance');
        $page_data['student_id'] =  $student_id;
        // $page_data['subject_id'] =  $param3;
        // $page_data['class_id'] =  $param1;
        // $page_data['section_id'] =  $param2;
        $page_data['month'] =  $param1;
        $page_data['year'] =  $param2;
        $this->load->view('backend/index', $page_data);
    }

    //Student attendance report selector function.
    function student_attendance_report_selector()
    {
        $this->isAccountant();
        // $data['class_id']   = $this->input->post('class_id');
        // $data['subject_id'] = $this->input->post('subject_id');
        $data['year']       = $this->input->post('year');
        $data['month']      = $this->input->post('month');
        // $data['section_id'] = $this->input->post('section_id');

        redirect(base_url().'accountant/student_attendance/'.$this->input->post('student_id').'/'.$data['month'].'/'.$data['year'].'/','refresh');

        // redirect(base_url().'admin/student_profile_attendance/'.$this->input->post('student_id').'/'.$data['class_id'].'/'.$data['section_id'].'/'.$data['subject_id'].'/'.$data['month'].'/'.$data['year'].'/','refresh');
    }

    function student_payments($student_id, $param1='')
    {
        $this->isAccountant();
        $class_id     = $this->db->get_where('enroll' , array('student_id' => $student_id , 'year' => $this->runningYear, 'semester_id' => $this->runningSemester))->row()->class_id;
        $page_data['student_id'] =  $student_id;
        $page_data['class_id']   =  $class_id;
        
        $page_data['page_name']  = 'student_payments';
        $page_data['page_title'] =  getPhrase('student_payments');
        
        $this->load->view('backend/index', $page_data);
    }
/***** Applicant Module ******************************************************************************************************************************/
    function applicant_profile($applicant_id, $param1='')
    {
        $this->isAccountant();
        
        $page_data['page_name']  = 'applicant_profile';
        $page_data['page_title'] =  getPhrase('applicant_profile');
        $page_data['applicant_id'] =  $applicant_id;
        // $page_data['class_id']   =  $class_id;
        $this->load->view('backend/index', $page_data);
    }

    function applicant_payment($applicant_id, $param1='')
    {
        $this->isAccountant();
        
        $page_data['applicant_id'] =  $applicant_id;
        
        $page_data['page_name']  = 'applicant_payment';
        $page_data['page_title'] =  getPhrase('applicant_payment');
        
        $this->load->view('backend/index', $page_data);
    }
/***** Report Module *******************************************************************************************************************************/
    //Manage payments function.
    function report_dashboard($param1 = '' , $param2 = '' , $param3 = '') 
    {
        $this->isAccountant();

        if(has_permission('accounting_dashboard'))
        {
            $page_data['page_name']  = 'report_dashboard';
            $page_data['page_title'] = getPhrase('dashboard');
            $this->load->view('backend/index', $page_data); 
        }
        else
        {
            redirect(base_url() . 'accountant/report_income', 'refresh');
        }        
    }

    function report_income($param1 = '' , $param2 = '' , $param3 = '') 
    {
        $this->isAccountant();

        $cashier_all = has_permission('accounting_dashboard');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {        
            $date_start = html_escape($this->input->post('date_start'));
            $date_end = html_escape($this->input->post('date_end'));

            if($cashier_all)
                $cashier_id = html_escape($this->input->post('cashier_id'));
            else
                $cashier_id = "accountant:".$this->session->userdata('login_user_id');
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
                $cashier_id = "accountant:".$this->session->userdata('login_user_id');
            }
        }

        $page_data['date_start']    = $date_start;
        $page_data['date_end']      = $date_end;
        $page_data['cashier_id']    = $cashier_id;
        $page_data['cashier_all']   = $cashier_all; 
        $page_data['page_name']     = 'report_income';
        $page_data['page_title']    = getPhrase('income');
        $this->load->view('backend/index', $page_data); 
    }

    function report_monthly_income($param1 = '' , $param2 = '' , $param3 = '') 
    {
        $this->isAccountant();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $date = html_escape($this->input->post('date'));
            $cashier_id = html_escape($this->input->post('cashier_id'));
        }
        else
        {
            $date = "";
            $cashier_id = "";
        }

        $page_data['date']  = $date;
        $page_data['cashier_id']  = $cashier_id;
        $page_data['page_name']  = 'report_monthly_income';
        $page_data['page_title'] = getPhrase('monthly_income');
        $this->load->view('backend/index', $page_data); 
    }

    function report_payments($param1 = '' , $param2 = '' , $param3 = '') 
    {
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

        $this->isAccountant();
        $page_data['start_date'] = $start_date;
        $page_data['end_date']   = $end_date;
        $page_data['page_name']  = 'report_payments';
        $page_data['page_title'] = getPhrase('payments');
        $this->load->view('backend/index', $page_data); 
    }

/***** HelpDesk functions **************************************************************************************************************************/

    // ticket Dashboard
    function helpdesk_dashboard()
    {
        $this->isAccountant('helpdesk_module');

        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {   
            $department_id  = $this->input->post('department_id');                
            $priority_id    = $this->input->post('priority_id');
            $status_id      = $this->input->post('status_id');
            $text           = $this->input->post('text');
            $assigned_me    = $this->input->post('assigned_me');                
        }
        else
        {    
            $department_id  = "_blank";
            $priority_id    = "_blank";
            $status_id      = "_blank";
            $assigned_me = 1;
        }

        $page_data['department_id'] = $department_id;
        $page_data['priority_id']   = $priority_id;
        $page_data['status_id']     = $status_id;
        $page_data['text']          = $text;
        $page_data['assigned_me']   = $assigned_me;
        $page_data['page_name']     = 'helpdesk_dashboard';
        $page_data['page_title']    =  getPhrase('help_desk_dashboard');
        $this->load->view('backend/helpdesk/index', $page_data);
    }

    function helpdesk_ticket_list($param1 = '')
    {
        $this->isAccountant('helpdesk_module');

        if($param1 != '')
        {
            $array      = explode('|',base64_decode($param1));

            $status_id      = $array[0] != '-' ? $array[0] : '';
            $priority_id    = $array[1] != '-' ? $array[1] : '';
            $assigned_me    = $array[2] != '-' ? $array[2] : 0;
            $department_id  = "";
        }
        else
        {
            $department_id  = "";
            $priority_id    = "";
            $status_id      = "";
            $assigned_me    = 1;
        }
        
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {   
            $category_id    = $this->input->post('category_id');                
            $priority_id    = $this->input->post('priority_id');
            $status_id      = $this->input->post('status_id');
            $text           = $this->input->post('text');
            $assigned_me    = $this->input->post('assigned_me');  
            $search         = true;              
        }

        $page_data['department_id'] = $department_id;
        $page_data['category_id']   = $category_id;
        $page_data['priority_id']   = $priority_id;
        $page_data['status_id']     = $status_id;
        $page_data['text']          = $text;
        $page_data['search']        = $search;
        $page_data['assigned_me']   = $assigned_me;
        $page_data['page_name']     = 'helpdesk_ticket_list';
        $page_data['page_title']    =  getPhrase('helpdesk_ticket_list');
        $this->load->view('backend/helpdesk/index', $page_data);

        // echo '<pre>';
        // var_dump($array);
        // echo '</pre>';
    }

    function helpdesk_ticket_info($ticket_code = '', $param2 = '')
    {
        $this->isAccountant('helpdesk_module');
        $page_data['ticket_code']   = $ticket_code;
        $page_data['page_name']     = 'helpdesk_ticket_info';
        $page_data['page_title']    = getPhrase('ticket_info');
        $this->load->view('backend/helpdesk/index', $page_data);
    }
    
    function helpdesk_tutorial()
    {
        $this->isAccountant();

        $page_data['page_name']  = 'helpdesk_tutorial';
        $page_data['page_title'] = getPhrase( 'video_tutorial' ); 
        $this->load->view('backend/helpdesk/index', $page_data);
    }

/***** Search functions ****************************************************************************************************************************/

    //Search query function.
    function search_query($search_key = '') 
    {        
        if ($_POST)
        {
            redirect(base_url() . 'accountant/search_results?query=' . base64_encode(html_escape($this->input->post('search_key'))), 'refresh');
        }
    }

    //Search results function.
    function search_results()
    {
        $this->isAccountant();

        parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
        if (html_escape($_GET['query']) == "")
        {
            redirect(base_url(), 'refresh');
        }

        $page_data['search_key'] =  html_escape($_GET['query']);
        $page_data['page_name']  =  'search_results';
        $page_data['page_title'] =  getPhrase('search_results');
        $this->load->view('backend/index', $page_data);
    }

    function admission_applicant_interaction($action, $applicant_id = '', $interaction_id = '', $return_url = '')
    {
        $this->isAccountant();

        $message = '';
        switch ($action) {
            case 'add':
                if($return_url == '')
                {
                    if($applicant_id != '')
                        $return_url = 'accountant/admission_applicant/'.$applicant_id;
                    else
                        $return_url = 'accountant/admission_applicants';
                }

                $this->applicant->add_interaction();
                $message =  getPhrase('successfully_added');

                if($applicant_id != '')
                {
                    $status_id_old = $this->db->get_where('v_applicants' , array('applicant_id' => $applicant_id) )->row()->status;
    
                    $status_id_new = $this->input->post('status_id');
    
                    if($status_id_old != $status_id_new)
                    {
                        $this->applicant->update_status($applicant_id, $status_id_new);
                    }                       
                }

                break;
            case 'update':
                if($return_url == '')
                    $return_url = 'accountant/admission_applicant/'.$applicant_id;
                $this->applicant->update_interaction($interaction_id);
                $message =  getPhrase('successfully_added');

            default:
                # code...
                break;
        }

        $this->session->set_flashdata('flash_message' , $message);
        redirect(base_url() . $return_url, 'refresh');
    }
}
