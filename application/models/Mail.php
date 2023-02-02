<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    
class Mail extends School 
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
    
    function __construct() 
    {
        parent::__construct();
        $this->load->database();
        $this->runningYear = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
    }
    
    //Submit email for behavior report.
    function students_reports($student_name,$parent_email)
    {
        $parent_id = $this->db->get_where('student', array('student_id' => $this->input->post('student_id')))->row()->parent_id;
        $s_name = $this->crud->get_name('student', $this->input->post('student_id'));
        $email_sub  = $this->db->get_where('email_template' , array('task' => 'student_reports'))->row()->subject;
        $email_msg  = $this->db->get_where('email_template' , array('task' => 'student_reports'))->row()->body;
        $PARENT_NAME =   $this->crud->get_name('parent', $parent_id);
        $email_msg   =   str_replace('[PARENT]' , $PARENT_NAME, $email_msg);
        $email_msg   =   str_replace('[STUDENT]' , $s_name , $email_msg);
        $email_to    =   $this->db->get_where('parent' , array('parent_id' => $parent_id))->row()->email;
        $email_data = array(
            'email_msg' => $email_msg
        );
        if($email_to != ''){
            $this->submit($email_to,$email_sub,$email_data,'notify');
        }
    }
    
    //Send attendance notification.
    function attendance($student_id,$parent_id)
    {
        $email_sub      = $this->db->get_where('email_template' , array('task' => 'student_absences'))->row()->subject;
        $email_msg      = $this->db->get_where('email_template' , array('task' => 'student_absences'))->row()->body;
        $STUDENT_NAME   = $this->crud->get_name('student', $student_id);
        $PARENT_NAME    = $this->crud->get_name('parent', $parent_id);
        $email_msg      = str_replace('[PARENT]' , $PARENT_NAME, $email_msg);
        $email_msg      = str_replace('[STUDENT]' , $STUDENT_NAME , $email_msg);
        $email_to       = $this->db->get_where('parent', array('parent_id' => $parent_id))->row()->email;
        
        $data = array(
            'email_msg' => $email_msg
        );
        if($email_to != '')
        {
            $this->submit($email_to,$email_sub,$data,'notify');
        }
    }
    
    //Send notifify to parents for new invoice.
    function parent_new_invoice($student_name,$parent_email)
    {
        $email_sub       = $this->db->get_where('email_template' , array('task' => 'parent_new_invoice'))->row()->subject;
        $email_msg       = $this->db->get_where('email_template' , array('task' => 'parent_new_invoice'))->row()->body;
        $parentId        = $this->db->get_where('parent' , array('email' => $parent_email))->row()->parent_id;
        $STUDENT_NAME    = $student_name;
        $PARENT_NAME     = $this->crud->get_name('parent' , $parentId);
        $email_msg       = str_replace('[PARENT]' , $PARENT_NAME, $email_msg);
        $email_msg       = str_replace('[STUDENT]' , $STUDENT_NAME , $email_msg);
        $email_to        = $parent_email;
        $data = array(
            'email_msg' => $email_msg
        );
        if($email_to != '')
        {
            $this->submit($email_to,$email_sub,$data,'notify');
        }
    }
    
    //Send notifify to students for new invoice.
    function student_new_invoice($student_name, $student_email, $payment_id = "")
    {
        $email_sub      = $this->db->get_where('email_template' , array('task' => 'student_new_invoice'))->row()->subject;
        $email_msg      = $this->db->get_where('email_template' , array('task' => 'student_new_invoice'))->row()->body;
        $STUDENT_NAME   = $student_name;
        $email_msg      = str_replace('[STUDENT]' , $STUDENT_NAME , $email_msg);
        $email_to       = $student_email;        


        // Generate the invoice detail [INVOICE_DETAILS]

        if($payment_id != "")
        {
            $payment_info = $this->payment->get_payment_info($payment_id);

            $html  = "<div class='invoice-w' id='invoice_id'>";
            $html .= "<div class='invoice-heading'>";
            $html .= "<h3>".getPhrase('invoice')."</h3>";
            $html .= "<div class='invoice-date'>";
            $html .= $payment_info['invoice_number'];
            $html .= "</div>";
            $html .= "<br/>";
            $html .= "<br/>";
            $html .= '<div class="invoice-body">';
            $html .= '<div class="invoice-table" style="width:100%;">';
            $html .= '<table class="table">';
            $html .= '<thead>';
            $html .= '<tr>';
            $html .= '<th>'.getPhrase('title').'</th>';
            $html .= '<th>'.getPhrase('description').'</th>';
            $html .= '<th class="text-right">'.getPhrase('amount').'</th>';
            $html .= '</tr>';
            $html .= '</thead>';
            $html .= '<tbody>';
            $html .= '<div>';
            $html .= '<div>';
            $html .= '</div>';


            $payment_details = $this->payment->get_payment_details($payment_id);
            $total_details = 0.00;
            foreach($payment_details as $item)
            {
                $total_details += $item['amount'];

                $html .= '<tr>';
                $html .= '<td>';
                $html .= $this->payment->get_income_type_name($item['concept_type']);
                $html .= '</td>';
                $html .= '<td>';
                $html .= $item['comment'];
                $html .= '</td>';
                $html .= '<td class="text-right">';
                $html .= $item['amount'];
                $html .= '</td>';
                $html .= '</tr>';
            }

            $payment_discounts = $this->payment->get_payment_discounts($payment_id);
            $total_discounts = 0.00;
            foreach($payment_discounts as $item)
            {
                $total_discounts += $item['amount'];

                $html .= '<tr>';
                $html .= '<td>';
                $html .= $this->payment->get_income_type_name($item['discount_type']);
                $html .= '</td>';
                $html .= '<td>';
                $html .= $item['comment'];
                $html .= '</td>';
                $html .= '<td class="text-right">';
                $html .= $item['amount'];
                $html .= '</td>';
                $html .= '</tr>';
            }

            $total = $total_details - $total_discounts;

            $html .= '</tbody>';
            $html .= '<tfoot>';
            $html .= '<tr>';
            $html .= '<td>';
            $html .= getPhrase('total');
            $html .= '</td>';
            $html .= '<td class="text-right" colspan="2">';
            $html .= $total;
            $html .= '</td>';
            $html .= '</tr>';
            $html .= '</tfoot>';
            $html .= '</table>';
            $html .= '</div>';
            $html .= '</div>';


            $email_msg      = str_replace('[INVOICE_DETAILS]' , $html , $email_msg);
        
        }

        $data = array(
            'email_msg' => $email_msg
        );


        if($email_to != '')
        {            
            $this->submit($email_to,$email_sub,$data,'notify');
        }
    }
    
    //Submit notification to students.
    function send_homework_notify()
    {
        $subj       = $this->db->get_where('subject', array('subject_id' => $this->input->post('subject_id')))->row()->name;
        $email_sub  = $this->db->get_where('email_template' , array('task' => 'new_homework'))->row()->subject;
        $email_msg  = $this->db->get_where('email_template' , array('task' => 'new_homework'))->row()->body;
        $email_msg  =  str_replace('[DESCRIPTION]' , $this->input->post('description'), $email_msg);
        $email_msg  =  str_replace('[TITLE]' , $this->input->post('title'), $email_msg);
        $email_msg  =  str_replace('[SUBJECT]' , $subj, $email_msg);

        $st = $this->db->get_where('enroll', array('class_id' => $this->input->post('class_id'), 'section_id' => $this->input->post('section_id'), 'year' => $this->runningYear))->result_array();
        foreach($st as $r)
        {
            $email_data = array(
                'email_msg' => $email_msg
            );
            if($this->db->get_where('student' , array('student_id' => $r['student_id']))->row()->email != '')
            {
                $this->submit($this->db->get_where('student' , array('student_id' => $r['student_id']))->row()->email,$email_sub,$email_data,'notify');
            }
        }
    }
    
    //Send new password to user function.
    function submitPassword($email, $password_token, $table)
    {
        $url         = base_url() . 'forgot_password/new_password/'.$password_token.'/'.$table;
        $email_sub   = getPhrase('recover_your_password');
        $email_msg   = "<h2>".getPhrase('success_password')."</h2><b/><br>";
        $email_msg  .= getPhrase('new_password_message');
        $email_msg  .= "<b/><br><br>";
        $email_msg  .= '<div style="text-align: center;">';
        $email_msg  .= '<a href="'.$url.'" class="button" target="_blank">'.getPhrase('set_new_password').'</a>';
        $email_msg  .= '</div>';

        $data = array(
            'email_msg' => $email_msg
        );
        $this->submit($email,$email_sub,$data,'password');
    }
    
    //Send Marks to Students.
    function sendStudentMarks()
    {
        $users = $this->db->get_where('enroll' , array('class_id' => $this->input->post('class_id'), 'section_id' => $this->input->post('section_id'), 'year' => $this->runningYear))->result_array();
        if(count($users) > 0)
        {
            foreach($users as $row)
            {
                $student_email = $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->email;
                $subject = getPhrase('student_marksheet')." [".$this->db->get_where('exam', array('unit_id' => $this->input->post('unit_id')))->row()->name."]";
                $data = array(
                    'class_id' => $row['class_id'],
                    'student_name' => $this->crud->get_name('student', $row['student_id']),
                    'type' => 'student',
                    'student_id' => $row['student_id'],
                    'section_id' => $row['section_id'],
                    'unit_id' => $this->input->post('unit_id')
                );
                if($student_email != ''){
                    $this->submit($student_email,$subject,$data,'marks');
                }
            }   
        }
    }
    
    //Send marks to Parents.
    function sendParentsMarks()
    {
        $st = $this->db->get_where('enroll' , array('class_id' => $this->input->post('class_id'), 'section_id' => $this->input->post('section_id'), 'year' => $this->runningYear))->result_array();
        if(count($st) > 0)
        {
            foreach($st as $row)
            {
                $parent_id = $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->parent_id;
                $parent_email = $this->db->get_where('parent', array('parent_id' => $parent_id))->row()->email;
                $subject = getPhrase('student_marksheet')." [".$this->db->get_where('exam', array('unit_id' => $this->input->post('unit_id')))->row()->name."]";
                $data = array(
                    'class_id' => $this->input->post('class_id'),
                    'type' => 'parent',
                    'student_name' => $this->crud->get_name('student', $row['student_id']),
                    'student_id' => $row['student_id'],
                    'section_id' => $this->input->post('section_id'),
                    'unit_id' => $this->input->post('unit_id')
                );
                if($parent_email != ''){
                    $this->submit($parent_email,$subject,$data,'marks');
                }
            }   
        }
    }
    
    //Send email confirmation for pending users.
    function accountConfirm($type = '', $id = '')
    {
        $user_email = $this->db->get_where($type, array($type.'_id' => $id))->row()->email;
        $user_name  = $this->db->get_where($type, array($type.'_id' => $id))->row()->first_name." ".$this->db->get_where($type, array($type.'_id' => $id))->row()->last_name;
        $username   = $this->db->get_where($type, array($type.'_id' => $id))->row()->username;
        
        $email_sub    =  getPhrase('congratulations');
        $email_msg    =  getPhrase('hi')." <strong>".$user_name.",</strong><br><br>";
        $email_msg   .=  getPhrase('your_account_has_been_approved_now_you_can_login')." <br><br>";
        $email_msg   .=  getPhrase('your_data_are_as_follows').":<br><br>";
        $email_msg   .=  "<strong>".getPhrase('name').":</strong> ".$user_name."<br/>";
        $email_msg   .=  "<strong>".getPhrase('email').":</strong> ".$user_email."<br/>";
        $email_msg   .=  "<strong>".getPhrase('username').":</strong> ".$username."<br/>";
        $email_msg   .=  "<strong>".getPhrase('password').":</strong> ********<br/><br/>";
        $data = array(
            'email_msg' => $email_msg
        );
        if($user_email != '')
        {
            $this->submit($user_email,$email_sub,$data,'accept');
        }
    }
	
	//Send mails to all users.
	function sendEmailNotify()
	{
	    $subject = $this->input->post('subject');
        $data    = array(
            'email_msg' => $this->input->post('content')
        );
        $users = $this->db->get(''.$this->input->post('type').'')->result_array();
        foreach($users as $row)
        {
            if($row['email'] != ''){
                $this->submit($row['email'],$subject,$data,'notify');
            }
        }    
	}
	
	//Sent notify to student or parent as teacher account.
	function teacherSendEmail()
    {
        $subject = $this->input->post('subject');
        $data = array(
            'email_msg' => $this->input->post('content')
        );
        $users = $this->db->get_where('enroll', array('year' => $this->runningYear, 'class_id' => $this->input->post('class_id'), 'section_id' => $this->input->post('section_id')))->result_array();
        foreach($users as $row)
        {
            if($this->input->post('receiver') == 'student'){
                if($this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->email != '')
                {
                    $this->submit($this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->email,$subject,$data,'notify');
                }
            }else if($this->input->post('receiver') == 'parent'){
                $this->db->group_by('parent_id');
                $this->db->where('student_id', $row['student_id']);
                $parent_id = $this->db->get('student')->row()->parent_id;
                if($this->db->get_where('parent' , array('parent_id' => $parent_id))->row()->email != '')
                {
                    $this->submit($this->db->get_where('parent' , array('parent_id' => $parent_id))->row()->email,$subject,$data,'notify');
                }
            }
        }
    }

	
	//Sent welcome email to users.
	function welcomeUser($id)
	{
	    $user_email   = $this->db->get_where('pending_users', array('user_id' => $id))->row()->email;
        $user_name    = $this->db->get_where('pending_users', array('user_id' => $id))->row()->first_name." ".$this->db->get_where('pending_users', array('user_id' => $id))->row()->last_name;
        $username     = $this->db->get_where('pending_users', array('user_id' => $id))->row()->username;
        $type         = $this->db->get_where('pending_users', array('user_id' => $id))->row()->type;
        $email_sub    = getPhrase('welcome')." ". $user_name;
        $email_msg    = getPhrase('hi')." <strong>".$user_name.",</strong><br><br>";
        $email_msg   .= getPhrase('new_account_has_been_created_with_your_email_address_in')." ".base_url()."<br><br>";
        $email_msg   .= getPhrase('your_data_are_as_follows').":<br><br>";
        $email_msg   .=  "<strong>".getPhrase('name').":</strong> ".$user_name."<br>";
        $email_msg   .=  "<strong>".getPhrase('email').":</strong> ".$user_email."<br>";
        $email_msg   .=  "<strong>".getPhrase('username').":</strong> ".$username."<br>";
        $email_msg   .=  "<strong>".getPhrase('account_type').":</strong> ".ucwords($type)."<br>";
        $email_msg   .=  "<strong>".getPhrase('password').":</strong> ********<br/><br/>";
        $email_msg   .=  "<strong>".getPhrase('note').":</strong> ".getPhrase('your_account_require_approval').".<br><br>";
        $data = array(
            'email_msg' => $email_msg
        );
        $this->submit($user_email,$email_sub,$data,'welcome');  
	}
	
	//Submit email by SMTP function.
	function submit($to, $subject, $message, $type)
	{
        $this->load->library('email');
        // $this->load->library('encrypt');
        
        $from = get_settings('system_email');
        $fromName = get_settings('system_name');

	    $config = array(
            'protocol'  => get_settings('protocol'), // $this->db->get_where('settings', array('type' => 'protocol'))->row()->description,
            'smtp_host' => get_settings('smtp_host'), // $this->db->get_where('settings', array('type' => 'smtp_host'))->row()->description,
            'smtp_port' => get_settings('smtp_port'), // $this->db->get_where('settings', array('type' => 'smtp_port'))->row()->description,
            'smtp_user' => get_settings('smtp_user'), // $this->db->get_where('settings', array('type' => 'smtp_user'))->row()->description,
            'smtp_pass' => get_settings('smtp_pass'), // $this->db->get_where('settings', array('type' => 'smtp_pass'))->row()->description,
            'mailtype'  => 'html', 
            'smtp_crypto' => 'ssl',
            'charset'   => get_settings('charset'), // $this->db->get_where('settings', array('type' => 'charset'))->row()->description
        );

        $this->email->set_header('MIME-Version', 1.0);
		$this->email->set_header('Content-type', 'text/html');
		$this->email->set_header('charset', 'UTF-8');

        $this->email->initialize($config);
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");

        $this->email->to($to);
        $this->email->from($from, $fromName);
        $this->email->subject($subject);

        if($type == 'marks')
        {
            $msg = $this->load->view('backend/mails/marks.php',$message,TRUE);
            $this->email->message($msg);
        }
        elseif($type == 'accept')
        {
            $msg = $this->load->view('backend/mails/accept.php',$message,TRUE);
            $this->email->message($msg);
        }
        else
        {
            $msg = $this->load->view('backend/mails/notify.php',$message,true);   
            $this->email->message($msg);
        }
        
        $this->email->send();

        // if (!$this->email->send()) 
        // {
        //     show_error($this->email->print_debugger());
        // }
	}

    //Sent password to the new student

    //Send attendance notification.
    function request_approved($user_id, $user_type, $request_type)
    {
        if($request_type === 'vacation')
        {
            $email_sub      = $this->db->get_where('email_template' , array('task' => 'vacation_approved'))->row()->subject;
            $email_msg      = $this->db->get_where('email_template' , array('task' => 'vacation_approved'))->row()->body;
        }
        else
        {
            $email_sub      = $this->db->get_where('email_template' , array('task' => 'request_approved'))->row()->subject;
            $email_msg      = $this->db->get_where('email_template' , array('task' => 'request_approved'))->row()->body;
        }

        $STUDENT_NAME   = $this->crud->get_name($user_type, $user_id);        

        $email_msg      = str_replace('[USER_NAME]' , $STUDENT_NAME , $email_msg);

        $email_to       = $this->db->get_where($user_type, array($user_type.'_id' => $user_id))->row()->email;
        
        $data = array(
            'email_msg' => $email_msg
        );

        if($email_to != '')
        {
            $this->submit($email_to,$email_sub,$data,'notify');
        }
    }

    function request_approved_to_teacher($user_id, $user_type, $data)
    {
        
        $email_sub      = $this->db->get_where('email_template' , array('task' => 'request_approved_to_teacher'))->row()->subject;
        $email_msg      = $this->db->get_where('email_template' , array('task' => 'request_approved_to_teacher'))->row()->body;
        

        $STUDENT_NAME   = $data['STUDENT_NAME'];
        $LEVEL_NAME     = $data['LEVEL_NAME'];
        $SCHEDULE       = $data['SCHEDULE'];
        $SUBJECT        = $data['SUBJECT'];
        $DATE_START     = $data['DATE_START'];
        $DATE_END       = $data['DATE_END'];

        $email_msg      = str_replace('[STUDENT_NAME]' , $STUDENT_NAME , $email_msg);
        $email_msg      = str_replace('[LEVEL_NAME]' , $LEVEL_NAME , $email_msg);
        $email_msg      = str_replace('[SCHEDULE]' , $SCHEDULE , $email_msg);
        $email_msg      = str_replace('[SUBJECT]' , $SUBJECT , $email_msg);
        $email_msg      = str_replace('[DATE_START]' , $DATE_START , $email_msg);
        $email_msg      = str_replace('[DATE_END]' , $DATE_END , $email_msg);

        $email_to       = $this->db->get_where($user_type, array($user_type.'_id' => $user_id))->row()->email;
        
        $data = array(
            'email_msg' => $email_msg
        );
        
        if($email_to != '')
        {
            $this->submit($email_to,$email_sub,$data,'notify');
        }
    }

    //Send attendance notification.
    function request_reject($user_id, $user_type, $request_type)
    {
        if($request_type === 'vacation')
        {
            $email_sub      = $this->db->get_where('email_template' , array('task' => 'vacation_rejected'))->row()->subject;
            $email_msg      = $this->db->get_where('email_template' , array('task' => 'vacation_rejected'))->row()->body;
        }
        else
        {
            $email_sub      = $this->db->get_where('email_template' , array('task' => 'request_rejected'))->row()->subject;
            $email_msg      = $this->db->get_where('email_template' , array('task' => 'request_rejected'))->row()->body;
        }

        $STUDENT_NAME   = $this->crud->get_name($user_type, $user_id);        

        $email_msg      = str_replace('[USER_NAME]' , $STUDENT_NAME , $email_msg);

        $email_to       = $this->db->get_where($user_type, array($user_type.'_id' => $user_id))->row()->email;
        
        $data = array(
            'email_msg' => $email_msg
        );
        if($email_to != '')
        {
            $this->submit($email_to,$email_sub,$data,'notify');
        }
    }
    
    //End of Mail.php
}
