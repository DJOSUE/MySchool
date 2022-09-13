<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
    
    class Admin extends EduAppGT
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
            $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
            $this->output->set_header('Cache-Control: no-cache, must-revalidate, post-check=0, pre-check=0');
            $this->output->set_header('Pragma: no-cache');
            $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
            
            $this->runningYear      = $this->crud->getInfo('running_year'); 
            $this->runningSemester  = $this->crud->getInfo('running_semester');
            $this->useDailyMarks    = $this->crud->getInfo('use_daily_marks');
        }

        //Index function for Admin controller.
        public function index()
        {
            $this->isAdmin();
        }

        //Payments Gateways settings.
        function accounting_settings($param1 = '', $param2 = '')
        {
            $this->isAdmin();

            if($param1 == 'update')
            {
                if($param2 == 'paypal'){
                    $this->payment->updatePayPal();   
                }
                if($param2 == 'stripe'){
                    $this->payment->updateStripe();   
                }
                if($param2 == 'razorpay'){
                    $this->payment->updateRazorpay();   
                }
                if($param2 == 'paystack'){
                    $this->payment->updatePaystack();   
                }
                if($param2 == 'flutterwave'){
                    $this->payment->updateFlutterwave();   
                }
                if($param2 == 'pesapal'){
                    $this->payment->updatePesapal();   
                }
                if($param2 == 'gpay'){
                    $this->payment->updateGpay();   
                }
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/accounting_settings/', 'refresh');
            }
            $page_data['page_name']  = 'accounting_settings';
            $page_data['page_title'] = getPhrase('accounting_settings');
            $this->load->view('backend/index', $page_data);
        }
        
        //Get expense data.
        function get_expense(){
            $this->isAdmin();
            echo $this->crud->get_expense(date('M'));
        }
        
        //Get payment data.
        function get_payments(){
            $this->isAdmin();
            echo $this->crud->get_payments(date('M'));
        }
    
        function graphIncome(){
            $this->isAdmin();
            echo $this->crud->income();
        }
        
        function graphExpense(){
            $this->isAdmin();
            echo $this->crud->expense();
        }

        //Generate PDF after Admission form.
        function generate($student_id,$pw)
        {
            $this->crud->getPDF($student_id,$pw);
        }

        //Update SMTP Settings function.
        function smtp($param1 = '', $param2 = '')
        {
            $this->isAdmin();
            if($param1 == 'update'){
                $this->crud->updateSMTP();
                $this->session->set_flashdata('flash_message' , getPhrase('success_update'));
                redirect(base_url() . 'admin/system_settings/', 'refresh');
            }
            $page_data['page_name']  = 'smtp';
            $page_data['page_title'] = getPhrase('smtp_settings');
            $this->load->view('backend/index', $page_data);
        }


        //Send Marks by SMS to Parents and Students.
        function send_marks($param1 = '', $param2 = '')
        {
            if($param1 == 'email')
            {
                if($this->input->post('receiver') == 'student')
                {
                    $this->mail->sendStudentMarks();
                }else{
                    $this->mail->sendParentsMarks();
                }
            }
            $this->session->set_flashdata('flash_message' , getPhrase('marks_sent'));
            redirect(base_url() . 'admin/grados/', 'refresh');
        }
        
        //Download admission sheet function.
        function download_file($param1 = '', $param2 = '')
        {
            $this->isAdmin();
            $page_data['pw']  = $param2;
            $page_data['student_id']  = $param1;
            $page_data['page_name']  = 'download_file';
            $page_data['page_title'] = getPhrase('download_file');
            $this->load->view('backend/index', $page_data);
        }
        
        //Enter to live class function.
        function live($param1 = '', $param2 = '')
        {
            $this->isAdmin();
            $page_data['live_id']  = $param1;
            $page_data['page_name']  = 'live';
            $page_data['page_title'] = getPhrase('live');
            $this->load->view('backend/index', $page_data);
        }
        
        //Meet for Live Classes function.
        function meet($param1 = '', $param2 = '', $param3 = '')
        {
            $this->isAdmin();
            if($param1 == 'create')
            {
                $this->academic->createLiveClass();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'admin/meet/'.$param2, 'refresh');
            }
            if($param1 == 'update')
            {
                $this->academic->updateLiveClass($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/meet/'.$param3, 'refresh');
            }
            if($param1 == 'delete')
            {
                $this->academic->deleteLiveClass($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
                redirect(base_url() . 'admin/meet/'.$param3, 'refresh');
            }
            $page_data['data'] = $param1;
            $page_data['page_name']  = 'meet';
            $page_data['page_title'] = getPhrase('meet');
            $this->load->view('backend/index', $page_data);
        }

        //Admin dashboard function.
        function panel($param1 = '', $param2 = '')
        {
            $this->isAdmin();
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
        
        //Read and manage news function.
        function news($param1 = '', $param2 = '', $param3 = '') 
        {
            $this->isAdmin();

            if ($param1 == 'create') 
            {
                $this->crud->create_news();
                $this->crud->send_news_notify();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'admin/panel/', 'refresh');
            }
            if ($param1 == 'update_panel') 
            {
                $this->crud->update_panel_news($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'admin/panel/', 'refresh');
            }
            if ($param1 == 'create_video') 
            {
                $this->crud->create_video();
                $this->crud->send_news_notify();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'admin/panel/', 'refresh');
            }
            if ($param1 == 'update_news') 
            {
                $this->crud->update_panel_news($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'admin/news/', 'refresh');
            }
            if ($param1 == 'delete') 
            {
                $this->crud->delete_news($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
                redirect(base_url() . 'admin/panel/', 'refresh');
            }
            if ($param1 == 'delete2') 
            {
                $this->crud->delete_news($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
                redirect(base_url() . 'admin/news/', 'refresh');
            }
            $page_data['page_name'] = 'news';
            $page_data['page_title'] = getPhrase('news');
            $this->load->view('backend/index', $page_data);
        }
        
        //Private messages function.
        function message($param1 = 'message_home', $param2 = '', $param3 = '') 
        {
            parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
            $this->isAdmin();
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
                redirect(base_url() . 'admin/message/message_read/' . $message_thread_code, 'refresh');
            }
            if ($param1 == 'send_reply') 
            {
                $this->crud->send_reply_message($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('reply_sent'));
                redirect(base_url() . 'admin/message/message_read/' . $param2, 'refresh');
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
    
        //Chat groups function.
        function group($param1 = "group_message_home", $param2 = "", $param3 = '')
        {
            $this->isAdmin();
            if ($param1 == "create_group") 
            {
                $this->crud->create_group();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'admin/group/', 'refresh');
            }
            elseif($param1 == "delete_group")
            {
                $this->crud->deleteGroup($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
                redirect(base_url() . 'admin/group/', 'refresh');
            }
            elseif ($param1 == "edit_group") 
            {
                $this->crud->update_group($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/group/', 'refresh');
            }
            else if ($param1 == 'group_message_read') 
            {
                $page_data['current_message_thread_code'] = $param2;
            }
            else if ($param1 == 'create_message_group') 
            {
                $page_data['current_message_thread_code'] = $param2;
            }
            else if ($param1 == 'update_group') 
            {
                $page_data['current_message_thread_code'] = $param2;
            }
            else if($param1 == 'send_reply')
            {
                $this->crud->send_reply_group_message($param2);
                $this->session->set_flashdata('flash_message', getPhrase('message_sent'));
                redirect(base_url() . 'admin/group/group_message_read/'.$param2, 'refresh');
            }
            $page_data['message_inner_page_name']   = $param1;
            $page_data['page_name']                 = 'group';
            $page_data['page_title']                = getPhrase('message_group');
            $this->load->view('backend/index', $page_data);
        }
    
        //Pending users function.
        function pending($param1 = '', $param2 = '')
        {
            $this->isAdmin();
            $page_data['page_name']  = 'pending';
            $page_data['page_title'] = getPhrase('pending_users');
            $this->load->view('backend/index', $page_data);
        }
    
        //Students reports function.
        function reports_students($param1 = '', $param2 = '')
        {
            $this->isAdmin();
            $page_data['class_id']      = html_escape($this->input->post('class_id'));
            $page_data['section_id']    = html_escape($this->input->post('section_id'));
            $page_data['subject_id']    = $this->input->post('subject_id');
            $page_data['page_name']     = 'reports_students';
            $page_data['page_title']    = getPhrase('students_report');
            $this->load->view('backend/index', $page_data);
        }
    
        //General reports function.
        function reports_general($class_id = '', $section_id = '')
        {
            $this->isAdmin();
            $page_data['page_name']     = 'reports_general';
            $page_data['class_id']      = html_escape($this->input->post('class_id'));
            $page_data['section_id']    = html_escape($this->input->post('section_id'));
            $page_data['page_title']    = getPhrase('general_reports');
            $this->load->view('backend/index', $page_data);
        }

        //Manage birthdays function.
        function birthdays()
        {
            $this->isAdmin();
            $page_data['page_name']  = 'birthdays';
            $page_data['page_title'] = getPhrase('birthdays');
            $this->load->view('backend/index', $page_data);
        }

        //Manage Librarians function.
        function librarian($param1 = '', $param2 = '')
        {
            $this->isAdmin();
            if ($param1 == 'create') 
            {
                $this->user->createLibrarian();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'admin/librarian/', 'refresh');
            }
            if ($param1 == 'update') 
            {
                $this->user->updateLibrarian($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/librarian/', 'refresh');
            }
            if ($param1 == 'update_profile') 
            {
                $this->user->updateLibrarian($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/librarian_update/'.$param2.'/', 'refresh');
            }
            if ($param1 == 'delete') 
            {
                $this->user->deleteLibrarian($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
                redirect(base_url() . 'admin/librarian/', 'refresh');
            }
            $page_data['page_name']  = 'librarian';
            $page_data['page_title'] = getPhrase('librarians');
            $this->load->view('backend/index', $page_data);
        }
        
        //Create Invoice function.
        function new_payment($param1 = '', $param2 = '')
        {
            $this->isAdmin();
            $page_data['page_name']  = 'new_payment';
            $page_data['page_title'] = getPhrase('new_payment');
            $this->load->view('backend/index', $page_data);
        }

        //Manage accountants function.
        function accountant($param1 = '', $param2 = '', $param3 = '')
        {
            $this->isAdmin();
            if ($param1 == 'create') 
            {
                $this->user->createAccountant();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'admin/accountant/', 'refresh');
            }
            if ($param1 == 'update') 
            {
                $this->user->updateAccountant($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/accountant/', 'refresh');
            }
            if ($param1 == 'update_profile') 
            {
                $this->user->updateAccountant($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/accountant_update/'.$param2.'/', 'refresh');
            }
            if ($param1 == 'delete') 
            {
                $this->user->deleteAccountant($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
                redirect(base_url() . 'admin/accountant/', 'refresh');
            }
            $page_data['page_name']  = 'accountant';
            $page_data['page_title'] = getPhrase('accountants');
            $this->load->view('backend/index', $page_data);
        }

        //System notifications function.
        function notifications($param1 = '', $param2 = '')
        {
            $this->isAdmin();
            if($param1 == 'delete')
            {
                $this->db->where('id', $param2);
                $this->db->delete('notification');
                redirect(base_url() . 'admin/notifications/', 'refresh');
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
            }
            $page_data['page_name']  =  'notifications';
            $page_data['page_title'] =  getPhrase('your_notifications');
            $this->load->view('backend/index', $page_data);
        }

        //Update academic settings function.
        function academic_settings($param1 = '', $param2 = '', $param3 = '')
        {
            $this->isAdmin();
            if ($param1 == 'do_update') 
            {
                $this->crud->updateAcademicSettings();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/academic_settings/', 'refresh');
            }
            $page_data['page_name']  = 'academic_settings';
            $page_data['page_title'] = getPhrase('academic_settings');
            $page_data['settings']   = $this->db->get('settings')->result_array();
            $this->load->view('backend/index', $page_data);
        }
        
        //Check if student exist function.
        function query() 
        {
            if(html_escape($_POST['b']) != "")
            {       
                $this->db->like('name' , html_escape($_POST['b']));
                $query = $this->db->get_where('student')->result_array();
                if(count($query) > 0)
                {
                    foreach ($query as $row) 
                    {
                        echo '<p class="text-left text-white px15"><a class="text-left text-white text-bold" href="'.base_url().'admin/student_portal/'. $row['student_id'] .'/">'. $row['name'] .'</a>' ." &nbsp;".$status.""."</p>";
                    }
                } else{
                    echo '<p class="col-md-12 text-left text-white text-bold">'.getPhrase('no_results').'</p>';
                }
            }
        }
        
        //Grade Levels function.
        function grade($param1 = '', $param2 = '')
        {
            $this->isAdmin();
            if ($param1 == 'create') 
            {
                $this->academic->createLevel();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'admin/grade/', 'refresh');
            }
            if ($param1 == 'update') 
            {
                $this->academic->updateLevel($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/grade/', 'refresh');
            }
            if ($param1 == 'delete') 
            {
                $this->academic->deleteLevel($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
                redirect(base_url() . 'admin/grade/', 'refresh');
            }
            $page_data['page_name']  = 'grade';
            $page_data['page_title'] = getPhrase('grades');
            $this->load->view('backend/index', $page_data);
        }

        //GPA function.
        function gpa($param1 = '', $param2 = '')
        {
            $this->isAdmin();
            if ($param1 == 'create') 
            {
                $this->academic->createGPA()();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'admin/gpa/', 'refresh');
            }
            if ($param1 == 'update') 
            {
                $this->academic->updateGPA()($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/gpa/', 'refresh');
            }
            if ($param1 == 'delete') 
            {
                $this->academic->deleteGPA()($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
                redirect(base_url() . 'admin/gpa/', 'refresh');
            }
            $page_data['page_name']  = 'gpa';
            $page_data['page_title'] = getPhrase('gpa');
            $this->load->view('backend/index', $page_data);
        }
    
        //All users and manage admin permissions function.
        function users($param1 = '' , $param2 = '')
        {
            $this->isAdmin();
            if($param1 == 'permissions')
            {
                $this->crud->setPermissions();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/users/', 'refresh');
            }
            $page_data['page_name']                 = 'users';
            $page_data['page_title']                = getPhrase('users');
            $this->load->view('backend/index', $page_data);
        }
    
        //Manage Admins function.
        function admins($param1 = '' , $param2 = '')
        {
            $this->isAdmin();
            if ($param1 == 'create') 
            {
                $this->user->createAdmin();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/admins/', 'refresh');
            }
            if ($param1 == 'update') 
            {
                $this->user->updateAdmin($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/admins/', 'refresh');
            }
            if ($param1 == 'update_profile') 
            {
                $this->user->updateAdmin($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/admin_update/'.$param2.'/', 'refresh');
            }
            if ($param1 == 'delete')
            {
                $data['status']   = 0;
                $this->db->where('admin_id', $param2);
                $this->db->update('admin', $data);

                $table      = 'admin';
                $action     = 'update';
                $update_id  = $param2;
                $this->crud->save_log($table, $action, $update_id, $data);

                // $this->db->delete('admin');
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
                redirect(base_url() . 'admin/admins/', 'refresh');
            }
            $page_data['page_name']     = 'admins';
            $page_data['page_title']    = getPhrase('admins');
            $this->load->view('backend/index', $page_data);
        }

        //Manage students function.
        function students($id = '')
        {
            $this->isAdmin();
            $id = $this->input->post('class_id');
            if ($id == '')
            {
                $id = $this->db->get('class')->first_row()->class_id;
            }
            $page_data['page_name']   = 'students';
            $page_data['page_title']  = getPhrase('students');
            $page_data['class_id']  = $id;
            $this->load->view('backend/index', $page_data);
        }

        //Admin Profile function.
        function admin_profile($admin_id_selected = '')
        {
            $this->isAdmin();
            $page_data['page_name']  = 'admin_profile';
            $page_data['page_title'] =  getPhrase('profile');
            $page_data['admin_id_selected']  =  $admin_id_selected;
            $this->load->view('backend/index', $page_data);
        }
        
        //Accountant profile function.
        function accountant_profile($accountant_id = '')
        {
            $this->isAdmin();
            $page_data['page_name']  = 'accountant_profile';
            $page_data['page_title'] =  getPhrase('profile');
            $page_data['accountant_id']  =  $accountant_id;
            $this->load->view('backend/index', $page_data);
        }
        
        //Librarian Profile function.
        function librarian_profile($librarian_id = '')
        {
            $this->isAdmin();
            $page_data['page_name']  = 'librarian_profile';
            $page_data['page_title'] =  getPhrase('profile');
            $page_data['librarian_id']  =  $librarian_id;
            $this->load->view('backend/index', $page_data);
        }
    
        //Librarian update profile function.
        function librarian_update($librarian_id = '')
        {
            $this->isAdmin();
            $page_data['page_name']  = 'librarian_update';
            $page_data['page_title'] =  getPhrase('librarian_update');
            $page_data['librarian_id']  =  $librarian_id;
            $this->load->view('backend/index', $page_data);
        }
        
        //Accountant update profile function.
        function accountant_update($accountant_id = '')
        {
            $this->isAdmin();
            $page_data['page_name']  = 'accountant_update';
            $page_data['page_title'] =  getPhrase('update_information');
            $page_data['accountant_id']  =  $accountant_id;
            $this->load->view('backend/index', $page_data);
        }
        
        //Admin update profile function.
        function admin_update($admin_id_selected = '')
        {
            $this->isAdmin();

            check_permission('can_edit_admin');

            $page_data['page_name']  = 'admin_update';
            $page_data['page_title'] =  getPhrase('update_information');
            $page_data['admin_id_selected']  =  $admin_id_selected;
            $this->load->view('backend/index', $page_data);
        }
    
        //Update account for Admin function.
        function update_account($admin_id = '')
        {
            $this->isAdmin();
            $output                  = $this->crud->getGoogleURL();
            $page_data['page_name']  = 'update_account';
            $page_data['output']     = $output;
            $page_data['page_title'] =  getPhrase('profile');
            $this->load->view('backend/index', $page_data);
        }

        //Manage teachers function.
        function teachers($param1 = '', $param2 = '', $param3 = '')
        {
            $this->isAdmin();
            if($param1 == 'accept')
            {
                $this->user->acceptTeacher($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/teachers/', 'refresh');
            }
            if ($param1 == 'create') 
            {
                $this->user->createTeacher();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'admin/teachers/', 'refresh');
            }
            if ($param1 == 'update') 
            {
                $this->user->updateTeacher($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/teachers/', 'refresh');
            }
            if ($param1 == 'update_profile') 
            {
                $this->user->updateTeacher($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/teacher_update/'.$param2. '/', 'refresh');
            }
            if ($param1 == 'delete') 
            {
                $this->user->deleteTeacher($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
                redirect(base_url() . 'admin/teachers/', 'refresh');
            }
            $page_data['page_name']  = 'teachers';
            $page_data['page_title'] = getPhrase('teachers');
            $this->load->view('backend/index', $page_data);
        }
        
        //Teacher Profile function.
        function teacher_profile($teacher_id = '')
        {
            $this->isAdmin();
            $page_data['page_name']  = 'teacher_profile';
            $page_data['page_title'] =  getPhrase('profile');
            $page_data['teacher_id']  =  $teacher_id;
            $this->load->view('backend/index', $page_data);
        }
        
        //Teacher Update info function.
        function teacher_update($teacher_id = '')
        {
            $this->isAdmin();
            $page_data['page_name']  = 'teacher_update';
            $page_data['page_title'] =  getPhrase('update_information');
            $page_data['teacher_id']  =  $teacher_id;
            $this->load->view('backend/index', $page_data);
        }
        
        //Teacher Schedules function.
        function teacher_schedules($teacher_id = '')
        {
            $this->isAdmin();
            $page_data['page_name']  = 'teacher_schedules';
            $page_data['page_title'] =  getPhrase('teacher_schedules');
            $page_data['teacher_id']  =  $teacher_id;
            $this->load->view('backend/index', $page_data);
        }
        
        //Teacher subjects function.
        function teacher_subjects($teacher_id = '')
        {
            $this->isAdmin();
            $page_data['page_name']  = 'teacher_subjects';
            $page_data['page_title'] =  getPhrase('teacher_subjects');
            $page_data['teacher_id']  =  $teacher_id;
            $this->load->view('backend/index', $page_data);
        }
        
        //Manage parents function.
        function parents($param1 = '', $param2 = '', $param3 = '')
        {
            $this->isAdmin();
            if ($param1 == 'create') 
            {
                $this->user->createParent();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'admin/parents/', 'refresh');
            }
            if ($param1 == 'update') 
            {
                $this->user->updateParent($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/parents/', 'refresh');
            }
            if ($param1 == 'update_profile') 
            {
                $this->user->updateParent($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/parent_update/'.$param2.'/', 'refresh');
            }
            if($param1 == 'accept')
            {
                $this->user->acceptParent($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/parents/', 'refresh');
            }
            if ($param1 == 'delete') 
            {
                $this->user->deleteParent($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
                redirect(base_url() . 'admin/parents/', 'refresh');
            }
            $page_data['page_title']  = getPhrase('parents');
            $page_data['page_name']  = 'parents';
            $this->load->view('backend/index', $page_data);
        }
    
        //Delete student homework delivery function.
        function delete_delivery($param1 = '', $param2 = '')
        {
            $this->isAdmin();
            if($param1 != '')
            {
                $this->academic->deleteDelivery($param1);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
                redirect(base_url() . 'admin/homework_details/'.$param2.'/', 'refresh');
            }
        }
    
        //Notification center function.
        function notify($param1 = '', $param2 = '')
        {
          $this->isAdmin();
          if($param1 == 'send_emails')
          {
                $this->mail->sendEmailNotify();
                $this->session->set_flashdata('flash_message' , getPhrase('sent_successfully'));
                redirect(base_url() . 'admin/notify/', 'refresh');
            }
            if($param1 == 'sms')
            {       
                $this->crud->sendSMS();
                $this->session->set_flashdata('flash_message' , getPhrase('sent_successfully'));
                redirect(base_url() . 'admin/notify/', 'refresh');
            }
            $page_data['page_name']  = 'notify';
            $page_data['page_title'] = getPhrase('notifications');
            $this->load->view('backend/index', $page_data);
        }
    
        //Parent profile function.
        function parent_profile($parent_id = '')
        {
            $this->isAdmin();
            $page_data['parent_id']  = $parent_id;
            $page_data['page_name']  = 'parent_profile';
            $page_data['page_title'] = getPhrase('profile');
            $this->load->view('backend/index', $page_data);
        }
        
        //Parent update profile function.
        function parent_update($parent_id = '')
        {
            $this->isAdmin();
            $page_data['parent_id']  = $parent_id;
            $page_data['page_name']  = 'parent_update';
            $page_data['page_title'] = getPhrase('update_information');
            $this->load->view('backend/index', $page_data);
        }
        
        //Parent childs function.
        function parent_childs($parent_id = '')
        {
            $this->isAdmin();
            $page_data['parent_id']  = $parent_id;
            $page_data['page_name']  = 'parent_childs';
            $page_data['page_title'] = getPhrase('parent_childs');
            $this->load->view('backend/index', $page_data);
        }
    
        //Delete Student function.
        function delete_student($student_id = '', $class_id = '') 
        {
            $this->isAdmin();
            $this->crud->deleteStudent($student_id);
            $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
            redirect(base_url() . 'admin/students/', 'refresh');
        }
    
        //Attendance selector function.
        function attendance_selector()
        {
            $timestamp = $this->crud->attendanceSelector();
            redirect(base_url().'admin/attendance/'.$this->input->post('data').'/'.$timestamp,'refresh');
        }
    
        //Attendance Update function.
        function attendance_update($class_id = '' , $section_id = '', $subject_id = '' , $timestamp = '')
        {        
            $this->crud->attendanceUpdate($class_id, $section_id,$subject_id, $timestamp);
            $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
            redirect(base_url().'admin/attendance/'.base64_encode($class_id.'-'.$section_id.'-'.$subject_id).'/'.$timestamp , 'refresh');
        }
    
        //Database tools function.
        function database($param1 = '', $param2 = '')
        {
            $this->isAdmin();
            if($param1 == 'restore')
            {
                $this->crud->import_db();
                $this->session->set_flashdata('flash_message' , getPhrase('restored'));
                redirect(base_url() . 'admin/database/', 'refresh');
            }
            if($param1 == 'create')
            {
                $this->crud->create_backup();
                $this->session->set_flashdata('flash_message' , getPhrase('backup_created'));
                redirect(base_url() . 'admin/database/', 'refresh');
            }
            $page_data['page_name']                 = 'database';
            $page_data['page_title']                = getPhrase('database');
            $this->load->view('backend/index', $page_data);
        }
    
        //SMS API's Settings function.
        function sms($param1 = '', $param2 = '')
        {
            $this->isAdmin();
            if($param1 == 'update')
            {
                $this->crud->smsStatus();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/sms/', 'refresh');
            }
            if($param1 == 'msg91')
            {
                $this->crud->msg91();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/sms/', 'refresh');
            }
            if($param1 == 'clickatell')
            {
                $this->crud->clickatellSettings();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/sms/', 'refresh');
            }
            if($param1 == 'twilio') 
            {
                $this->crud->twilioSettings();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/sms/', 'refresh');
            }
            if($param1 == 'services') 
            {
                $this->crud->services();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/sms/', 'refresh');
            }
            $page_data['page_name']  = 'sms';
            $page_data['page_title'] = getPhrase('sms');
            $this->load->view('backend/index', $page_data);
        }
    
        //Email settings function.
        function email($param1 = '', $param2 = '')
        {
            $this->isAdmin();
            if($param1 == 'template')
            {
                $this->crud->emailTemplate($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/email/', 'refresh');
            }
            $page_data['page_name']  = 'email';
            $page_data['current_email_template_id']  = 1;
            $page_data['page_title'] = getPhrase('email_settings');
            $this->load->view('backend/index', $page_data);
        }
    
        //View teacher report function.
        function view_teacher_report()
        {
            $this->isAdmin();
            $page_data['page_name']  = 'view_teacher_report';
            $page_data['page_title'] = getPhrase('teacher_report');
            $this->load->view('backend/index', $page_data);
        }
        
        //System translation function.
        function translate($param1 = '', $param2 = '')
        {
            $this->isAdmin();
            if ($param1 == 'update') 
            {
                $page_data['edit_profile']  = $param2;
            }
            if ($param1 == 'update_language') 
            {
                $this->crud->updateLang($param2);
            }
            if ($param1 == 'add') 
            {
                $this->crud->createLang();
                $this->session->set_flashdata('flash_message', getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/translate/', 'refresh');
            }
            $page_data['page_name']  = 'translate';
            $page_data['page_title'] = getPhrase('translate');
            $this->load->view('backend/index', $page_data);
        }
        
        //Manage polls function.
        function polls($param1 = '', $param2 = '')
        {
            $this->isAdmin();
            if($param1 == 'create')
            {
                $this->crud->createPoll();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'admin/panel/', 'refresh');
            }
            if($param1 == 'create_wall')
            {
                $this->crud->createPoll();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'admin/polls/', 'refresh');
            }
            if($param1 == 'response')
            {
                $this->crud->pollReponse();
            }
            if($param1 == 'delete')
            {
                $this->crud->deletePoll($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
                redirect(base_url() . 'admin/panel/', 'refresh');
            }
            if($param1 == 'delete2')
            {
                $this->crud->deletePoll($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
                redirect(base_url() . 'admin/polls/', 'refresh');
            }
            $page_data['page_name']  = 'polls';
            $page_data['page_title'] = getPhrase('polls');
            $this->load->view('backend/index', $page_data);
        }
    
        //View poll details function.
        function view_poll($code = '')
        {
            $this->isAdmin();
            $page_data['code'] = $code;
            $page_data['page_name']  = 'view_poll';
            $page_data['page_title'] = getPhrase('poll_details');
            $this->load->view('backend/index', $page_data);
        }
        
        //New poll function.
        function new_poll($code = '')
        {
            $this->isAdmin();
            $page_data['page_name']  = 'new_poll';
            $page_data['page_title'] = getPhrase('new_poll');
            $this->load->view('backend/index', $page_data);
        }
        
        //Teacher Routine function.
        function teacher_routine()
        {
            $this->isAdmin();
            $teacher_id = $this->input->post('teacher_id');
            $page_data['page_name']  = 'teacher_routine';
            $page_data['teacher_id']  = $teacher_id;
            $page_data['page_title'] = getPhrase('teacher_routine');
            $this->load->view('backend/index', $page_data);
        }
    
        //Student Profile function.
        function student_portal($student_id, $param1='')
        {
            $this->isAdmin();
            $class_id     = $this->db->get_where('enroll' , array('student_id' => $student_id , 'year' => $this->runningYear, 'semester_id' => $this->runningSemester))->row()->class_id;
            $page_data['page_name']  = 'student_portal';
            $page_data['page_title'] =  getPhrase('student_portal');
            $page_data['student_id'] =  $student_id;
            $page_data['class_id']   =  $class_id;
            $this->load->view('backend/index', $page_data);
        }
        
        //Student update function.
        function student_update($student_id = '', $param1='')
        {
            $this->isAdmin();
            $page_data['page_name']  = 'student_update';
            $page_data['page_title'] =  getPhrase('student_portal');
            $page_data['student_id'] =  $student_id;
            $this->load->view('backend/index', $page_data);
        }

        //Student update class function.
        function student_update_class($student_id, $param1='')
        {
            $this->isAdmin();
            $class_id     = $this->db->get_where('enroll' , array('student_id' => $student_id , 'year' => $this->runningYear, 'semester_id' => $this->runningSemester))->row()->class_id;
            $page_data['page_name']  = 'student_update_class';
            $page_data['page_title'] =  getPhrase('student_update_class');
            $page_data['student_id'] =  $student_id;
            $page_data['class_id']   =  $class_id;
            $this->load->view('backend/index', $page_data);
        }

        // Student update class process.
        function student_update_class_process ($student_id, $param1 = "")
        {
            $this->isAdmin();

            $current_class_id   = $this->input->post('current_class_id');
            $current_section_id = $this->input->post('current_section_id');
            
            $future_class_id    = $this->input->post('future_class_id');
            $future_section_id  = $this->input->post('future_section_id');
    
            $current_subjects = $this->db->get_where( 'subject', array( 'class_id' => $current_class_id, 'section_id' => $current_section_id  ) )->result_array();
        
            $current_subject_ids = array();
            $future_subject_ids = array();

            $count = 0;
            foreach ($current_subjects as $item) {
                $current_subject_ids[] = $this->input->post('current_subject_id_'.$item['subject_id']);
                $future_subject_ids[] = $this->input->post('future_subject_id_'.$item['subject_id']);
            }
    
            $result = array_diff($current_subject_ids, $future_subject_ids);
    
            if(($current_class_id != $future_class_id || $current_section_id != $future_class_id) && count($result) > 0){

                foreach ($current_subjects as $item) {
                    
                    $current_subject_id = $this->input->post('current_subject_id_'.$item['subject_id']);
                    $future_subject_id = $this->input->post('future_subject_id_'.$item['subject_id']);


                    $this->db->reset_query();
                    // Update Enroll
                    $data['class_id']   = $future_class_id;
                    $data['section_id'] = $future_section_id;
                    $data['subject_id'] = $future_subject_id;
                    
                    $this->db->where('student_id', $student_id );
                    $this->db->where('class_id', $current_class_id);
                    $this->db->where('section_id', $current_section_id);
                    $this->db->where('subject_id', $current_subject_id);
                    $this->db->where('year', $this->runningYear);
                    $this->db->where('semester_id', $this->runningSemester);
                    $this->db->update('enroll', $data );

                    $table      = 'enroll';
                    $action     = 'update';
                    $update_id  = $student_id.'-'.$current_class_id.'-'.$current_section_id.'-'.$current_subject_id;
                    $this->crud->save_log($table, $action, $update_id, $data);
                    
                    $this->db->reset_query();
                    // Update Marks
                    $data1['class_id']   = $future_class_id;
                    $data1['section_id'] = $future_section_id;
                    $data['subject_id'] = $future_subject_id;

                    $this->db->where('student_id', $student_id );
                    $this->db->where('class_id', $current_class_id);
                    $this->db->where('section_id', $current_section_id);
                    $this->db->where('subject_id', $current_subject_id);
                    $this->db->where('year', $this->runningYear);
                    $this->db->where('semester_id', $this->runningSemester);

                    
                    $action     = 'update';
                    $update_id  = $student_id.'-'.$current_class_id.'-'.$current_section_id.'-'.$current_subject_id;

                    if($this->useDailyMarks){
                        $this->db->update('mark_daily', $data1 );
                        $table      = 'mark_daily';
                        $this->crud->save_log($table, $action, $update_id, $data1);

                    }else{
                        $this->db->update('mark', $data1 );
                        $table      = 'mark';
                        $this->crud->save_log($table, $action, $update_id, $data1);
                    }
                    
                }

                $this->session->set_flashdata( 'flash_message', getPhrase( 'successfully_updated' ) );
            }
            else {
                $this->session->set_flashdata( 'flash_message', getPhrase( 'error' ) );
            }
    
            $this->crud_model->clear_cache();
            redirect( base_url() . 'admin/student_update_class/'. $student_id.'/', 'refresh' );
        }

        //Student Enrollments function.
        function student_enrollments($student_id, $param1='') 
        {
            $this->isAdmin();
            $class_id     = $this->db->get_where('enroll' , array('student_id' => $student_id , 'year' => $this->runningYear, 'semester_id' => $this->runningSemester))->row()->class_id;
            $page_data['page_name']  = 'student_enrollments';
            $page_data['page_title'] =  getPhrase('student_enrollments');
            $page_data['student_id'] =  $student_id;
            $page_data['class_id']   =  $class_id;
            $this->load->view('backend/index', $page_data);
        }

        //Save student enrollment 
        function save_student_enrollment()
        {
            $this->isAdmin();
            $student_id         = $this->input->post('student_id');
            $subjects           = $this->input->post('subject_id');
    
            $data['student_id']     = $student_id;
            $data['class_id']       = $this->input->post('class_id');
            $data['section_id']     = $this->input->post('section_id');
            $data['year']           = $this->input->post('year_id');
            $data['semester_id']    = $this->input->post('semester_id');
            $data['enroll_code']    = substr(md5(rand(0, 1000000)), 0, 7);
            $data['date_added']     = strtotime(date('Y-m-d H:i:s'));
    
            foreach ($subjects as $key) {
                $data['subject_id'] = $key;
                $this->db->insert('enroll', $data);

                $table      = 'enroll';
                $action     = 'insert';
                $insert_id  = $this->db->insert_id();
                $this->crud->save_log($table, $action, $insert_id, $data);
            }
    
            $this->session->set_flashdata('flash_message', getPhrase('successfully_added'));
            redirect(base_url() . 'admin/student_enrollments/'.$student_id, 'refresh');
        }

        //Delete student enrollment 
        function delete_student_enrollment($enroll_id = '', $student_id = '')
        {
            $this->isAdmin();
            $this->db->where( 'enroll_id', $enroll_id );
            $this->db->delete( 'enroll' );
    
            $this->session->set_flashdata( 'flash_message', getphrase( 'successfully_deleted' ) );
            redirect( base_url() . 'admin/student_enrollments/'.$student_id, 'refresh' );
        }

        //Sutdent invoices function.
        function student_invoices($student_id = '', $param1='')
        {
            $this->isAdmin();
            $page_data['page_name']  = 'student_invoices';
            $page_data['page_title'] =  getPhrase('student_invoices');
            $page_data['student_id'] =  $student_id;
            $this->load->view('backend/index', $page_data);
        }
        
        //Student marks function.
        function student_marks($student_id = '', $param1='')
        {
            $this->isAdmin();

            if($this->useDailyMarks){
                $page_data['page_name']  = 'student_daily_marks';
                $page_data['page_title'] =  getPhrase('student_daily_marks');
                $page_data['student_id'] =  $student_id;
                $this->load->view('backend/index', $page_data);
            } 
            else {
                $page_data['page_name']  = 'student_marks';
                $page_data['page_title'] =  getPhrase('student_marks');
                $page_data['student_id'] =  $student_id;
                $this->load->view('backend/index', $page_data);
            }
        }

        //Student Past Marks
        function student_past_marks($student_id = '', $param1='')
        {
            $this->isAdmin();
            
            if($this->useDailyMarks){
                $page_data['page_name']  = 'student_past_daily_marks_a';
                $page_data['page_title'] =  getPhrase('student_past_daily_marks');
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
    
        //Student attendance report selector function.
        function student_attendance_report_selector()
        {
            $this->isAdmin();
            $data['class_id']   = $this->input->post('class_id');
            $data['subject_id'] = $this->input->post('subject_id');
            $data['year']       = $this->input->post('year');
            $data['month']      = $this->input->post('month');
            $data['section_id'] = $this->input->post('section_id');
            redirect(base_url().'admin/student_profile_attendance/'.$this->input->post('student_id').'/'.$data['class_id'].'/'.$data['section_id'].'/'.$data['subject_id'].'/'.$data['month'].'/'.$data['year'].'/','refresh');
        }
        
        //Student Profile Attendance function.
        function student_profile_attendance($student_id = '', $param1='', $param2 = '', $param3 = '', $param4 = '', $param5 = '')
        {
            $this->isAdmin();
            $page_data['page_name']  = 'student_profile_attendance';
            $page_data['page_title'] =  getPhrase('student_attendance');
            $page_data['student_id'] =  $student_id;
            $page_data['subject_id'] =  $param3;
            $page_data['class_id'] =  $param1;
            $page_data['section_id'] =  $param2;
            $page_data['month'] =  $param4;
            $page_data['year'] =  $param5;
            $this->load->view('backend/index', $page_data);
        }
        
        //Student profile report function.
        function student_profile_report($student_id = '', $param1='')
        {
            $this->isAdmin();
            $page_data['page_name']  = 'student_profile_report';
            $page_data['page_title'] =  getPhrase('behavior');
            $page_data['student_id'] =  $student_id;
            $this->load->view('backend/index', $page_data);
        }
    
        //Student info function.
        function student_info($student_id = '', $param1='')
        {
            $this->isAdmin();
            $page_data['page_name']  = 'student_info';
            $page_data['page_title'] =  getPhrase('student_portal');
            $page_data['student_id'] =  $student_id;
            $this->load->view('backend/index', $page_data);
        }
    
        //My account function.
        function my_account($param1 = "", $page_id = "")
        {
            $this->isAdmin();     
            if($param1 == 'remove_facebook')
            {
                $this->user->removeFacebook();
                $this->session->set_flashdata('flash_message' , getPhrase('facebook_delete'));
                redirect(base_url() . 'admin/my_account/', 'refresh');
            }
            if($param1 == '1')
            {
                $this->session->set_flashdata('error_message' , getPhrase('google_err'));
                redirect(base_url() . 'admin/my_account/', 'refresh');
            }
            if($param1 == '3')
            {
                $this->session->set_flashdata('error_message' , getPhrase('facebook_err'));
                redirect(base_url() . 'admin/my_account/', 'refresh');
            }
            if($param1 == '2')
            {
                $this->session->set_flashdata('flash_message' , getPhrase('google_true'));
                redirect(base_url() . 'admin/my_account/', 'refresh');
            }
            if($param1 == '4')
            {
                $this->session->set_flashdata('flash_message' , getPhrase('facebook_true'));
                redirect(base_url() . 'admin/my_account/', 'refresh');
            }  
            if($param1 == 'remove_google')
            {
                $this->user->removeGoogle();
                $this->session->set_flashdata('flash_message' , getPhrase('google_delete'));
                redirect(base_url() . 'admin/my_account/', 'refresh');
            }
            if ($param1 == 'update_profile') 
            {
                $this->user->updateCurrentAdmin();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/update_account/', 'refresh');
            }
            $output                 = $this->crud->getGoogleURL();
            $data['page_name']      = 'my_account';
            $data['output']         = $output;
            $data['page_title']     = getPhrase('profile');
            $this->load->view('backend/index', $data);
        }
        
        //Book request function.
        function book_request($param1 = "", $param2 = "")
        {
            $this->isAdmin();
            if ($param1 == "accept")
            {
                $this->academic->acceptBook($param2);
                $this->session->set_flashdata('flash_message', getPhrase('request_accepted_successfully'));
                redirect(site_url('admin/book_request/'), 'refresh');
            }
            if ($param1 == "reject")
            {
                $this->academic->rejectBook($param2);
                $this->session->set_flashdata('flash_message', getPhrase('request_rejected_successfully'));
                redirect(site_url('admin/book_request/'), 'refresh');
            }
            $data['page_name']  = 'book_request';
            $data['page_title'] = getPhrase('book_request');
            $this->load->view('backend/index', $data);
        }
    
        //Permissions request for teachers function.
        function request($param1 = "", $param2 = "")
        {
            $this->isAdmin();
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
            if ($param1 == "accept")
            {
                $this->crud->acceptRequest($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/request/', 'refresh');
            }
            if ($param1 == "reject")
            {
                $this->crud->rejectRequest($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('rejected_successfully'));
                redirect(base_url() . 'admin/request/', 'refresh');
            }
            $data['page_name']  = 'request';
            $data['page_title'] = getPhrase('permissions');
            $this->load->view('backend/index', $data);
        }
    
        //Permissions request for students function.
        function request_student($param1 = "", $param2 = "")
        {
            $this->isAdmin();
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
            if ($param1 == "accept")
            {
                $this->crud->acceptStudentRequest($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/request/', 'refresh');
            }
            if ($param1 == "reject")
            {
                $this->crud->rejectStudentRequest($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('rejected_successfully'));
                redirect(base_url() . 'admin/request/', 'refresh');
            }
            if($param1 == 'delete')
            {
                $this->crud->deletePermission($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
                redirect(base_url() . 'admin/request_student/', 'refresh');
            }
            if($param1 == 'delete_teacher')
            {
                $this->crud->deleteTeacherPermission($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
                redirect(base_url() . 'admin/request_student/', 'refresh');
            }
            $data['page_name']  = 'request_student';
            $data['page_title'] = getPhrase('reports');
            $this->load->view('backend/index', $data);
        }
    
        //Create message for reports function.
        function create_report_message($code = '') 
        {
            $this->isAdmin();
            $this->crud->createReportMessage();
        }  
    
        //View report function.
        function view_report($param1 = '', $param2 = '', $param3 = '') 
        {
            $this->isAdmin();
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
            if($param1 == 'update')
            {
                $this->crud->updateReport($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/view_report/'.$param2, 'refresh');
            }
            $page_data['report_code'] = $param1;
            $page_data['page_title']  =   getPhrase('report_details');
            $page_data['page_name']   = 'view_report';
            $this->load->view('backend/index', $page_data);
        }
    
        //Manage Online exam status function.
        function manage_online_exam_status($online_exam_id = "", $status = "", $data)
        {
            $this->isAdmin();   
            $this->crud->manage_online_exam_status($online_exam_id, $status);
            redirect(base_url() . 'admin/online_exams/'.$data."/", 'refresh');
        }
    
        //Online exams function.
        function online_exams($param1 = '', $param2 = '', $param3 = '') 
        {
            $this->isAdmin();   
            if ($param1 == 'edit') 
            {
                if ($this->input->post('class_id') > 0 && $this->input->post('section_id') > 0 && $this->input->post('subject_id') > 0) {
                    $this->crud->update_online_exam();
                    $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                    redirect(base_url() . 'admin/exam_edit/' . $this->input->post('online_exam_id'), 'refresh');
                }
                else{
                    $this->session->set_flashdata('error_message' , getPhrase('error_updated'));
                    redirect(base_url() . 'admin/exam_edit/' . $this->input->post('online_exam_id'), 'refresh');
                }
            }
            if ($param1 == 'questions') 
            {
                $this->crud->add_questions();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'admin/exam_questions/' . $param2 , 'refresh');
            }
            if ($param1 == 'delete_questions') 
            {
                $this->db->where('question_id', $param2);
                $this->db->delete('questions');
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
                redirect(base_url() . 'admin/exam_questions/'.$param3, 'refresh');
            }
            if($param1 == 'delete')
            {
                $this->academic->deleteOnlineExam($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'admin/online_exams/'.$param3."/", 'refresh');
            }
            $page_data['data']       = $param1;
            $page_data['page_name']  = 'online_exams';
            $page_data['page_title'] = getPhrase('online_exams');
            $this->load->view('backend/index', $page_data);
        }
    
        //Update online exam function.
        function exam_edit($exam_code= '') 
        { 
            $this->isAdmin();   
            $page_data['online_exam_id'] = $exam_code;
            $page_data['page_name']      = 'exam_edit';
            $page_data['page_title']     = getPhrase('update_exam');
            $this->load->view('backend/index', $page_data);
        }
    
        //View exam results function.
        function exam_results($exam_code = '') 
        { 
            $this->isAdmin();   
            $page_data['online_exam_id'] = $exam_code;
            $page_data['page_name']      = 'exam_results';
            $page_data['page_title']     = getPhrase('exams_results');
            $this->load->view('backend/index', $page_data);
        }
    
        //Homework details function.
        function homeworkroom($param1 = '' , $param2 = '')
        {
            $this->isAdmin();
            if ($param1 == 'file') 
            {
                $page_data['room_page']    = 'homework_file';
                $page_data['homework_code'] = $param2;
            }  
            else if ($param1 == 'details') 
            {
                $page_data['room_page'] = 'homework_details';
                $page_data['homework_code'] = $param2;
            }
            else if ($param1 == 'edit') 
            {
                $page_data['room_page'] = 'homework_edit';
                $page_data['homework_code'] = $param2;
            }
            $page_data['homework_code'] =   $param1;
            $page_data['page_name']   = 'homework_room'; 
            $page_data['page_title']  = getPhrase('homework');
            $this->load->view('backend/index', $page_data);
        }
    
        //Homework Edit function.
        function homework_edit($homework_code = '') 
        {   
            $this->isAdmin(); 
            $page_data['homework_code'] = $homework_code;
            $page_data['page_name'] = 'homework_edit';
            $page_data['page_title'] = getPhrase('homework');
            $this->load->view('backend/index', $page_data);
        }
    
        //Single Homework Function.
        function single_homework($param1 = '', $param2 = '') 
        {
           $this->isAdmin();
           $page_data['answer_id'] = $param1;
           $page_data['page_name'] = 'single_homework';
           $page_data['page_title'] = getPhrase('homework');
           $this->load->view('backend/index', $page_data);
        }
    
        //Homework details function.
        function homework_details($param1 = '', $param2 = '', $param3 = '')
        {
            $this->isAdmin();
            $page_data['homework_code'] = $param1;
            $page_data['page_name']     = 'homework_details';
            $page_data['page_title']    = getPhrase('homework_details');
            $this->load->view('backend/index', $page_data);
        }
        
        //New online exam function.
        function new_exam($data = '')
        {
            $this->isAdmin();
            $page_data['data'] = $data;
            $page_data['page_name']  = 'new_exam';
            $page_data['page_title'] = getPhrase('new_exam');
            $this->load->view('backend/index', $page_data);
        }
    
        //Homework function.
        function homework($param1 = '', $param2 = '', $param3 = '') 
        {
            $this->isAdmin();
            if ($param1 == 'create') 
            {
                $homework_code = $this->academic->createHomework();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'admin/homeworkroom/' . $homework_code .'/', 'refresh');
            }
            if($param1 == 'update')
            {
                $this->academic->updateHomework($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/homework_edit/' . $param2 , 'refresh');
            }
            if($param1 == 'review')
            {
                $this->academic->reviewHomework();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/homework_details/' . $param2 , 'refresh');
            }
            if($param1 == 'single')
            {
                $this->academic->singleHomework();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/single_homework/' . $this->input->post('id') , 'refresh');
            }
            if ($param1 == 'edit') 
            {
                $this->crud->update_homework($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/homeworkroom/edit/' . $param2 , 'refresh');
            }
            if ($param1 == 'delete')
            {
                $this->crud->delete_homework($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
                redirect(base_url() . 'admin/homework/'.$param3."/", 'refresh');
            }
            $page_data['data'] = $param1;
            $page_data['page_name'] = 'homework';
            $page_data['page_title'] = getPhrase('homework');
            $this->load->view('backend/index', $page_data);
        }
    
        //Manage Forums funcion.
        function forum($param1 = '', $param2 = '', $param3 = '') 
        {
            $this->isAdmin();
            if ($param1 == 'create') 
            {
                $this->academic->createForum();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'admin/forum/' . $param2."/" , 'refresh');
            }
            if ($param1 == 'update') 
            {
                $this->academic->updateForum($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/edit_forum/' . $param2 , 'refresh');
            }
            if ($param1 == 'delete')
            {
                $this->crud->delete_post($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
                redirect(base_url() . 'admin/forum/'.$param3."/" , 'refresh');
            }
            $page_data['data'] = $param1;
            $page_data['page_name'] = 'forum';
            $page_data['page_title'] = getPhrase('forum');
            $this->load->view('backend/index', $page_data);
        }
    
        //Study Material Function.
        function study_material($task = "", $document_id = "", $data = '')
        {
            $this->isAdmin(); 
            if ($task == "create")
            {
                $this->academic->createMaterial();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_uploaded'));
                redirect(base_url() . 'admin/study_material/'.$document_id."/" , 'refresh');
            }
            if ($task == "delete")
            {
                $this->crud->delete_study_material_info($document_id);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
                redirect(base_url() . 'admin/study_material/'.$data."/");
            }
            $page_data['data']          = $task;
            $page_data['page_name']     = 'study_material';
            $page_data['page_title']    = getPhrase('study_material');
            $this->load->view('backend/index', $page_data);
        }
    
        //Edit forum function
        function edit_forum($code = '')
        {
            $this->isAdmin();
            $page_data['page_name']  = 'edit_forum';
            $page_data['page_title'] = getPhrase('update_forum');
            $page_data['code']   = $code;
            $this->load->view('backend/index', $page_data);    
        }
    
        //Forum details function.
        function forumroom($param1 = '' , $param2 = '')
        {
            $this->isAdmin();
            if ($param1 == 'comment') 
            {
                $page_data['room_page']    = 'comments';
                $page_data['post_code'] = $param2; 
            }
            else if ($param1 == 'posts') 
            {
                $page_data['room_page'] = 'post';
                $page_data['post_code'] = $param2; 
            }
            else if ($param1 == 'edit') 
            {
                $page_data['room_page'] = 'post_edit';
                $page_data['post_code'] = $param2;
            }
            $page_data['page_name']   = 'forum_room'; 
            $page_data['post_code']   = $param1;
            $page_data['page_title']  = getPhrase('forum');
            $this->load->view('backend/index', $page_data);
        }
    
        //Forum Message Function.
        function forum_message($param1 = '', $param2 = '', $param3 = '') 
        {
            $this->isAdmin();
            if ($param1 == 'add') 
            {
                $this->crud->create_post_message(html_escape($this->input->post('post_code')));
            }
        }
        
        //Manage multiple choice questions function.
        function manage_multiple_choices_options() 
        {
            $this->isAdmin();
            $page_data['number_of_options'] = $this->input->post('number_of_options');
            $this->load->view('backend/admin/manage_multiple_choices_options', $page_data);
        }
    
        //Manage image questions function.
        function manage_image_options() 
        {
            $this->isAdmin();
            $page_data['number_of_options'] = $this->input->post('number_of_options');
            $this->load->view('backend/admin/manage_image_options', $page_data);
        }
    
        //Load question type function.
        function load_question_type($type, $online_exam_id) 
        {
            $this->isAdmin();
            $page_data['question_type']  = $type;
            $page_data['online_exam_id'] = $online_exam_id;
            $this->load->view('backend/admin/online_exam_add_'.$type, $page_data);
        }
        
        //Online exam questions function.
        function manage_online_exam_question($online_exam_id = "", $task = "", $type = "")
        {
            $this->isAdmin();
            if ($task == 'add') {
                if ($type == 'multiple_choice') {
                    $this->crud->add_multiple_choice_question_to_online_exam($online_exam_id);
                }
                elseif ($type == 'true_false') {
                    $this->crud->add_true_false_question_to_online_exam($online_exam_id);
                }
                elseif ($type == 'image') {
                    $this->crud->add_image_question_to_online_exam($online_exam_id);
                }
                elseif ($type == 'fill_in_the_blanks') {
                    $this->crud->add_fill_in_the_blanks_question_to_online_exam($online_exam_id);
                }
                redirect(base_url() . 'admin/examroom/'.$online_exam_id, 'refresh');
            }
        }
    
        //Online exam details function.
        function examroom($param1 = '' , $param2 = '')
        {
            $this->isAdmin();
            $page_data['page_name']   = 'exam_room'; 
            $page_data['online_exam_id']  = $param1;
            $page_data['page_title']  = getPhrase('online_exams');
            $this->load->view('backend/index', $page_data);
        }
        
        //Create Online Exam function.
        function create_online_exam($info = '')
        {
            $this->isAdmin();
            $this->academic->createOnlineExam();
            $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
            redirect(base_url().'admin/online_exams/'.$info."/", 'refresh');
        }
        
        //Manage invoices function.
        function invoice($param1 = '', $param2 = '', $param3 = '')
        {
            $this->isAdmin();
            if($param1 == 'bulk') 
            {
                $this->payment->createBulkInvoice();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'admin/students_payments/', 'refresh');
            }
            if ($param1 == 'create') 
            {
                $this->payment->singleInvoice();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'admin/students_payments/', 'refresh');
            }
            if ($param1 == 'do_update') 
            {
                $this->payment->updateInvoice($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/students_payments/', 'refresh');
            }
            if ($param1 == 'delete') 
            {
                $this->payment->deleteInvoice($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
                redirect(base_url() . 'admin/students_payments/', 'refresh');
            }
        }
        
        //Delete question from online exam function.
        function delete_question_from_online_exam($question_id)
        {
            $this->isAdmin();
            $online_exam_id = $this->db->get_where('question_bank', array('question_bank_id' => $question_id))->row()->online_exam_id;
            $this->crud->delete_question_from_online_exam($question_id);
            $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
            redirect(base_url() . 'admin/examroom/'.$online_exam_id, 'refresh');
        }
        
        //Update online exam question function.
        function update_online_exam_question($question_id = "", $task = "", $online_exam_id = "") 
        {
            $this->isAdmin();
            $online_exam_id = $this->db->get_where('question_bank', array('question_bank_id' => $question_id))->row()->online_exam_id;
            $type = $this->db->get_where('question_bank', array('question_bank_id' => $question_id))->row()->type;
            if ($task == "update") {
                if ($type == 'multiple_choice') {
                    $this->crud->update_multiple_choice_question($question_id);
                }
                elseif($type == 'true_false'){
                    $this->crud->update_true_false_question($question_id);
                }
                elseif($type == 'image'){
                    $this->crud->update_image_question($question_id);
                }
                elseif($type == 'fill_in_the_blanks'){
                    $this->crud->update_fill_in_the_blanks_question($question_id);
                }
                redirect(base_url() . 'admin/examroom/'.$online_exam_id, 'refresh');
            }
            $page_data['question_id'] = $question_id;
            $page_data['page_name'] = 'update_online_exam_question';
            $page_data['page_title'] = getPhrase('update_questions');
            $this->load->view('backend/index', $page_data);
        }
    
        //Search query function.
        function search_query($search_key = '') 
        {        
            if ($_POST)
            {
                redirect(base_url() . 'admin/search_results?query=' . base64_encode(html_escape($this->input->post('search_key'))), 'refresh');
            }
        }
    
        //Search results function.
        function search_results()
        {
            $this->isAdmin();
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
    
        //Invoice details function.
        function invoice_details($id = '')
        {
            $this->isAdmin();
            $page_data['invoice_id'] = $id;
            $page_data['page_title'] = getPhrase('invoice_details');
            $page_data['page_name']  = 'invoice_details';
            $this->load->view('backend/index', $page_data);
        }
    
        //Loking behavior report function.
        function looking_report($report_code = '') 
        {
            $this->isAdmin();
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
            $page_data['code'] = $report_code;
            $page_data['page_name'] = 'looking_report';
            $page_data['page_title'] = getPhrase('report_details');
            $this->load->view('backend/index', $page_data);
        }
        
        //Manage students function.
        function student($param1 = '', $param2 = '', $param3 = '')
        {
            $this->isAdmin();
            if($param1 == 'reject')
            {
                $this->user->rejectStudent($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
                redirect(base_url() . 'admin/pending/', 'refresh');
            }
            if($param1 == 'excel')
            {
                $this->user->downloadExcel();
            }
            if ($param1 == 'admission') 
            {
                $student_id = $this->user->studentAdmission();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                if($this->input->post('download_pdf') == '1')
                {
                   redirect(base_url() . 'admin/download_file/'.$student_id.'/'.base64_encode($this->input->post('password')), 'refresh');
                }else{
                    redirect(base_url() . 'admin/admission_new_student/', 'refresh');
                }
            }
            if ($param1 == 'do_update') 
            {
                $this->user->updateStudent($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/student_update/'. $param2.'/', 'refresh');
            }
            if ($param1 == 'do_updates') 
            {
                $this->user->updateModalStudent($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/students/', 'refresh');
            }
            if($param1 == 'accept')
            {
                $this->user->acceptStudent($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/students/', 'refresh');
            }
            if($param1 == 'bulk')
            {
                $this->user->bulkStudents();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'admin/students/', 'refresh');
            }
        }
    
        //Promote students function.
        function student_promotion($param1 = '' , $param2 = '')
        {
            $this->isAdmin();
            if($param1 == 'promote') 
            {
                $this->academic->promoteStudents();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_promoted'));
                redirect(base_url() . 'admin/student_promotion' , 'refresh');
            }
            $page_data['page_title']    = getPhrase('student_promotion');
            $page_data['page_name']  = 'student_promotion';
            $this->load->view('backend/index', $page_data);
        }
    
        //View marks function.
        function view_marks($student_id = '')
        {
            $this->isAdmin();
            $class_id                = $this->db->get_where('enroll' , array('student_id' => $student_id , 'year' => $this->runningYear, 'semester_id' => $this->runningSemester ))->row()->class_id;
            $page_data['class_id']   =   $class_id;
            $page_data['page_name']  = 'view_marks';
            $page_data['page_title'] = getPhrase('marks');
            $page_data['student_id'] = $student_id;
            $this->load->view('backend/index', $page_data);    
        }
    
        //Subject marks function.
        function subject_marks($data = '') 
        {
            $this->isAdmin();

            if($this->useDailyMarks){
                $page_data['data'] = $data;
                $page_data['page_name']    = 'subject_daily_marks';
                $page_data['page_title']   = getPhrase('subject_daily_marks');
                $this->load->view('backend/index',$page_data);
            } 
            else {
                $page_data['data'] = $data;
                $page_data['page_name']    = 'subject_marks';
                $page_data['page_title']   = getPhrase('subject_marks');
                $this->load->view('backend/index',$page_data);
            }
        }
         
        //Subject dashboard function.
        function subject_dashboard($data = '') 
        {
            $this->isAdmin();
            $page_data['data'] = $data;
            $page_data['page_name']    = 'subject_dashboard';
            $page_data['page_title']   = getPhrase('subject_dashboard');
            $this->load->view('backend/index',$page_data);
        }
    
        //Manage subjects function.
        function courses($param1 = '', $param2 = '' , $param3 = '')
        {
            $this->isAdmin();
            if ($param1 == 'create') 
            {
                $this->academic->createCourse();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'admin/cursos/'.base64_encode($param2)."/", 'refresh');
            }
            if ($param1 == 'update_labs') 
            {
                $class_id = $this->db->get_where('subject', array('subject_id' => $param2))->row()->class_id;
                $this->academic->updateCourseActivity($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/upload_marks/'.base64_encode($class_id."-".$this->input->post('section_id')."-".$param2).'/', 'refresh');
            }
            if ($param1 == 'update') 
            {
                $this->academic->updateCourse($param2);
                $class_id = $this->db->get_where('subject', array('subject_id' => $param2))->row()->class_id;
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/cursos/'.base64_encode($class_id."-".$this->input->post('section_id').'-'.$param2)."/", 'refresh');
            }
            if ($param1 == 'delete') 
            {
                $this->academic->deleteCourse($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
                redirect(base_url() . 'admin/cursos/', 'refresh');
            }
        }
        
        //Online exam result function.
        function online_exam_result($param1 = '', $param2 = '') 
        {
            $this->isAdmin();
            $page_data['page_name']  = 'online_exam_result';
            $page_data['param2']     = $param1;
            $page_data['student_id'] = $param2;
            $page_data['page_title'] = getPhrase('online_exam_results');
            $this->load->view('backend/index', $page_data);
        }
        
        //Manage your classes.
        function manage_classes($param1 = '', $param2 = '')
        {
            $this->isAdmin();
            if ($param1 == 'create') 
            {
                $this->academic->createClass();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'admin/grados/', 'refresh');
            }
            if ($param1 == 'update')
            {
                $this->academic->updateClass($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/grados/', 'refresh');
            }
            if ($param1 == 'delete') 
            {
                $this->academic->deleteClass($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
                redirect(base_url() . 'admin/grados/', 'refresh');
            }
        }
    
        //Download virtual book function.
        function download_book($libro_code = '')
        {
            $file_name = $this->db->get_where('libreria', array('libro_code' => $libro_code))->row()->file_name;
            $this->load->helper('download');
            $data = file_get_contents("public/uploads/libreria/" . $file_name);
            $name = $file_name;
            force_download($name, $data);
        }

        //Manage school sections function.
        function sections($param1 = '', $param2 = '')
        {
            $this->isAdmin();
            $class = $this->input->post('class_id');
            if ($class == '')
            {
                $class = $this->db->get('class')->first_row()->class_id;
            }
            $year_id = $this->input->post('year_id');
            if ($year_id == '')
            {
                $year_id = $this->runningYear;
            }
            $semester_id = $this->input->post('semester_id');
            if ($semester_id == '')
            {
                $semester_id = $this->runningSemester;
            }
            
            if ($param1 == 'create') 
            {
                $new_year_id = $this->input->post('new_year_id');
                $new_semester_id = $this->input->post('new_semester_id');

                $this->academic->createSection($new_year_id, $new_semester_id);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'admin/sections/' . $this->input->post('class_id') ."/", 'refresh');
            }
            if($param1 == 'update')
            {
                $this->academic->updateSection($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/sections/', 'refresh');
            }
            if ($param1 == 'delete') 
            {
                $this->academic->deleteSection($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
                redirect(base_url() . 'admin/sections/' , 'refresh');
            }
            $page_data['page_name']     = 'section';
            $page_data['page_title']    = getPhrase('sections');
            $page_data['class_id']      = $class;
            $page_data['year_id']       = $year_id;
            $page_data['semester_id']   = $semester_id;
            $this->load->view('backend/index', $page_data);    
        }

        //Manage school subjects function.
        function subjects($param1 = '', $param2 = '')
        {
            $this->isAdmin();

            $class = $this->input->post('class_id');
            if ($class == '')
            {
                $class = $this->db->get('class')->first_row()->class_id;
            }

            $year_id = $this->input->post('year_id');
            if ($year_id == '')
            {
                $year_id = $this->runningYear;
            }

            $semester_id = $this->input->post('semester_id');
            if ($semester_id == '')
            {
                $semester_id = $this->runningSemester;
            }

            $section_id = $this->input->post('section_id');

            if ($param1 == 'create') 
            {
                $new_year_id = $this->input->post('new_year_id');
                $new_semester_id = $this->input->post('new_semester_id');

                $this->academic->createSubject($new_year_id, $new_semester_id);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'admin/subjects/' . $this->input->post('class_id') ."/", 'refresh');
            }
            if($param1 == 'update')
            {
                $this->academic->updateCourse($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/subjects/', 'refresh');
            }
            if ($param1 == 'delete') 
            {
                $this->academic->deleteCourse($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
                redirect(base_url() . 'admin/subjects/' , 'refresh');
            }
            $page_data['page_name']     = 'subjects';
            $page_data['page_title']    = getPhrase('subjects');
            $page_data['class_id']      = $class;
            $page_data['year_id']       = $year_id;
            $page_data['section_id']    = $section_id;
            $page_data['semester_id']   = $semester_id;
            $this->load->view('backend/index', $page_data);    
        }

        //Manage units function.
        function units($param1 = '', $param2 = '' , $param3 = '')
        {
            $this->isAdmin();
            if ($param1 == 'create') 
            {
                $this->academic->createUnit();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'admin/units/', 'refresh');
            }
            if ($param1 == 'update') 
            {
                $this->academic->updateUnit($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/units/', 'refresh');
            }
            if ($param1 == 'delete') 
            {
                $this->academic->deleteUnit($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
                redirect(base_url() . 'admin/units/', 'refresh');
            }
            $page_data['page_name']  = 'units';
            $page_data['page_title'] = getPhrase('units');
            $this->load->view('backend/index', $page_data);
        }

        //Manage semesters function.
        function semesters($param1 = '', $param2 = '' , $param3 = '')
        {
            $this->isAdmin();
            if ($param1 == 'create') 
            {
                $this->academic->createSemester();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'admin/semesters/', 'refresh');
            }
            if ($param1 == 'update') 
            {
                $this->academic->updateSemester($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/semesters/', 'refresh');
            }
            if ($param1 == 'delete') 
            {
                $this->academic->deleteSemester($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
                redirect(base_url() . 'admin/semesters/', 'refresh');
            }
            $page_data['page_name']  = 'semester';
            $page_data['page_title'] = getPhrase('units');
            $this->load->view('backend/index', $page_data);
        }

        //Update Book Function.
        function update_book($param1 = '', $param2 = '')
        {
            $this->isAdmin();
            $page_data['book_id'] = $param1;
            $page_data['page_name']  =   'update_book';
            $page_data['page_title'] = getPhrase('update_book');
            $this->load->view('backend/index', $page_data);
        }
        
        //Upload your marks function.
        function upload_marks($datainfo = '', $param2 = '')
        {
            $this->isAdmin();
            if($param2 != ""){
                $page = $param2;
            }else{
                $info = base64_decode( $datainfo );
                $ex = explode( '-', $info );
                $page = $this->academic->getClassCurrentUnit($ex[0]);
            }
            $this->academic->uploadMarks($datainfo,$page);

            
            $page_data['unit_id'] = $page;
            $page_data['data'] = $datainfo;
            $page_data['page_name']  =   'upload_marks';
            $page_data['page_title'] = getPhrase('upload_marks');
            $this->load->view('backend/index', $page_data);
            
        }

        //Upload your marks function.
        function daily_marks($datainfo = '', $param2 = '')
        {
            $this->isAdmin();

            $student_id = $this->input->post( 'student_id' );
            $unit_id    = $this->input->post( 'unit_id' );
            $mark_date   = $this->input->post( 'mark_date' );

            if($unit_id == ""){
                $info = base64_decode( $datainfo );
                $ex = explode( '-', $info );
                $unit_id = $this->academic->getClassCurrentUnit($ex[0]);
            }

            if($mark_date == ""){
                $mark_date = date('Y-m-d');
            }

            $page_data['student_id'] = $student_id;
            $page_data['unit_id']    = $unit_id;
            $page_data['mark_date']  = $mark_date;
            $page_data['data']       = $datainfo;
            $page_data['page_name']  =   'daily_marks';
            $page_data['page_title'] = getPhrase('daily_marks');
            $this->load->view('backend/index', $page_data);
            
        }

        // Daily marks average
        function daily_marks_average($datainfo = '', $param2 = ''){
            $this->isAdmin();
            if($param2 != ""){
                $page = $param2;
            }else{
                $info = base64_decode( $datainfo );
                $ex = explode( '-', $info );
                $page = $this->academic->getClassCurrentUnit($ex[0]);
            }
            $this->academic->uploadMarks($datainfo,$page);
            $page_data['unit_id'] = $page;
            $page_data['data'] = $datainfo;
            $page_data['page_name']  =   'daily_marks_average';
            $page_data['page_title'] = getPhrase('daily_marks_average');
            $this->load->view('backend/index', $page_data);
        }

        //Update marks function.
        function marks_update($exam_id = '' , $class_id = '' , $section_id = '' , $subject_id = '')
        {
            $info = $this->academic->updateMarks($exam_id, $class_id, $section_id, $subject_id);
            $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
            redirect(base_url().'admin/upload_marks/'.$info.'/'.$exam_id.'/' , 'refresh');
        }

        //Tabulation sheet function.
        function tab_sheet_print($class_id  = '', $section_id = '', $subject_id = '') 
        {
            $this->isAdmin();
            $page_data['class_id']    = $class_id;
            // $page_data['unit_id']     = $unit_id;
            $page_data['section_id']  = $section_id;
            $page_data['subject_id']  = $subject_id;
            $this->load->view('backend/admin/tab_sheet_print' , $page_data);
        }
    
        //Manage Class Routine.
        function class_routine($param1 = '', $param2 = '', $param3 = '')
        {
            $this->isAdmin();
            if ($param1 == 'create') 
            {
                $this->academic->createRoutine();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'admin/class_routine_view/', 'refresh');
            }
            if ($param1 == 'update') 
            {
                $this->academic->updateRoutine($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/class_routine_view/', 'refresh');
            }
            if ($param1 == 'delete') 
            {
                $this->academic->deleteRoutine($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
                redirect(base_url() . 'admin/class_routine_view/' . $class_id, 'refresh');
            } 
        }
    
        //Class routine view function.
        function class_routine_view($param1 = '', $param2 = '')
        {
            $this->isAdmin();
            $id = $this->input->post('class_id');
            if ($id == '')
            {
                $id = $this->db->get('class')->first_row()->class_id;
            }
            $page_data['page_name']  = 'class_routine_view';
            $page_data['id']         =   $id;
            $page_data['page_title'] = getPhrase('class_routine');
            $this->load->view('backend/index', $page_data);
        }
    
        //Manage attendance function.
        function attendance($param1 = '', $param2 = '')
        {
            $this->isAdmin();
            $page_data['data']       = $param1;
            $page_data['timestamp']  = $param2;
            $page_data['page_name']  =  'attendance';
            $page_data['page_title'] =  getPhrase('attendance');
            $this->load->view('backend/index', $page_data);
        }
    
        //Manage attendance function.
        function manage_attendance($class_id = '' , $section_id = '' , $timestamp = '')
        {
            $this->isAdmin();
            $page_data['class_id'] = $class_id;
            $page_data['timestamp'] = $timestamp;
            $page_data['page_name'] = 'manage_attendance';
            $page_data['section_id'] = $section_id;
            $page_data['page_title'] = getPhrase('attendance');
            $this->load->view('backend/index', $page_data);
        }
    
        //Attendance report function.
        function attendance_report($param1 = '', $param2 = '', $param3 = '', $param4 = '', $param5 = '') 
        {
            if($param1 == 'check')
            {
                $data['class_id']    = $this->input->post('class_id');
                $data['subject_id']  = $this->input->post('subject_id');
                $data['year']        = $this->input->post('year');
                $data['month']       = $this->input->post('month');
                $data['section_id']  = $this->input->post('section_id');
                redirect(base_url().'admin/attendance_report/'.$data['class_id'].'/'.$data['section_id'].'/'.$data['subject_id'].'/'.$data['month'].'/'.$data['year'],'refresh');
            }
            $page_data['class_id']    = $param1;
            $page_data['section_id']  = $param2;
            $page_data['subject_id']  = $param3;
            $page_data['month']       = $param4;
            $page_data['year']        = $param5;
            $page_data['page_name']   = 'attendance_report';
            $page_data['page_title']  = getPhrase('attendance_report');
            $this->load->view('backend/index',$page_data);
        }
        
        //Tabulation report function.
        function reports_tabulation($param1 = '', $param2 = '')
        {
            $this->isAdmin();

            $year_id = $this->input->post( 'year_id' );
            if ($year_id == '') {
                $year_id = $this->runningYear;
            }

            $semester_id = $this->input->post( 'semester_id' );
            if ( $semester_id == '' ) {
                $semester_id = $this->runningSemester;
            }

            $page_data['year_id']       = $year_id;
            $page_data['semester_id']   = $semester_id;
            $page_data['class_id']      = $this->input->post('class_id');
            $page_data['section_id']    = $this->input->post('section_id');
            $page_data['subject_id']    = $this->input->post('subject_id');

            if($this->useDailyMarks){
                $page_data['page_name']   = 'reports_tabulation_daily';
                $page_data['page_title']  = getPhrase('tabulation_daily_report');
                $this->load->view('backend/index', $page_data);
            } 
            else { 
                $page_data['page_name']   = 'reports_tabulation';
                $page_data['page_title']  = getPhrase('tabulation_report');
                $this->load->view('backend/index', $page_data);
            }
        }
        
        //Accounting report function.
        function reports_accounting($param1 = '', $param2 = '')
        {
          $this->isAdmin();
          $page_data['page_name']   = 'reports_accounting';
          $page_data['page_title']  = getPhrase('accounting_report');
          $this->load->view('backend/index', $page_data);
        }
         
        //Marks report function.
        function reports_marks($param1 = '', $param2 = '')
        {
            $this->isAdmin();
            if($param1 == 'generate')
            {
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'admin/reports_marks/', 'refresh');
            }
            $page_data['class_id']   = $this->input->post('class_id');
            $page_data['section_id']   = $this->input->post('section_id');
            $page_data['student_id']   = $this->input->post('student_id');
            $page_data['unit_id']   = $this->input->post('unit_id');
            $page_data['page_name']   = 'reports_marks';
            $page_data['page_title']  = getPhrase('marks_report');
            $this->load->view('backend/index', $page_data);
        }
    
        //Report attendance view function.
        function report_attendance_view($class_id = '' , $section_id = '', $month = '', $year = '') 
        {
            $this->isAdmin();
            $page_data['class_id']   = $class_id;
            $page_data['month']      = $month;
            $page_data['year']       = $year;
            $page_data['page_name']  = 'report_attendance_view';
            $page_data['section_id'] = $section_id;
            $page_data['page_title'] = getPhrase('attendance_report');
            $this->load->view('backend/index', $page_data);
        }
    
        //Manage behavior report function.
        function create_report($param1 = '', $param2 = '')
        {
            $this->isAdmin();
            if($param1 == 'send')
            {
                $this->academic->createReport();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'admin/request_student/', 'refresh');
            }
            if($param1 == 'response')
            {
                $this->academic->reportResponse();
            }
            if($param1 == 'update')
            {
                $this->academic->updateReport($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/looking_report/'.$param2, 'refresh');
            }
        }
        
        //Calendar events function.
        function calendar($param1 = '', $param2 = '')
        {
            $this->isAdmin();
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
            if($param1 == 'create')
            {
                $this->crud->createCalendarEvent();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'admin/calendar/', 'refresh');
            }
            if($param1 == 'update'){
                $this->crud->updateCalendarEvent();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/calendar/', 'refresh');
            }
            if($param1 == 'update_date')
            {
                $this->crud->updateCalendarDate();
            }
            $page_data['page_name']  = 'calendar';
            $page_data['page_title'] = getPhrase('calendar');
            $this->load->view('backend/index', $page_data); 
        }
    
        //Attendance report selector function.
        function attendance_report_selector()
        {
           $this->isAdmin();
            $data['class_id']   = $this->input->post('class_id');
            $data['year']       = $this->input->post('year');
            $data['month']  = $this->input->post('month');
            $data['section_id'] = $this->input->post('section_id');
            redirect(base_url().'admin/report_attendance_view/'.$data['class_id'].'/'.$data['section_id'].'/'.$data['month'].'/'.$data['year'],'refresh');
        }
       
        //Manage student payments function.
        function students_payments($param1 = '' , $param2 = '')
        {
            $this->isAdmin();
            $page_data['page_name']  = 'students_payments';
            $page_data['page_title'] = getPhrase('student_payments');
            $this->load->view('backend/index', $page_data); 
        }
        
        //Manage payments function.
        function payments($param1 = '' , $param2 = '' , $param3 = '') 
        {
            $this->isAdmin();
            $page_data['page_name']  = 'payments';
            $page_data['page_title'] = getPhrase('payments');
            $this->load->view('backend/index', $page_data); 
        }
    
        //Manage expenses function.
        function expense($param1 = '' , $param2 = '')
        {
            $this->isAdmin();
            if ($param1 == 'create') 
            {
                $this->crud->createExpense();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'admin/expense', 'refresh');
            }
            if ($param1 == 'edit') 
            {
                $this->crud->updateExpense($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/expense', 'refresh');
            }
            if ($param1 == 'delete') 
            {
                $this->crud->deleteExpense($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
                redirect(base_url() . 'admin/expense/', 'refresh');
            }
            $page_data['page_name']  = 'expense';
            $page_data['page_title'] = getPhrase('expense');
            $this->load->view('backend/index', $page_data); 
        }
    
        //Manage expense categoies function.
        function expense_category($param1 = '' , $param2 = '')
        {
            $this->isAdmin();
            if ($param1 == 'create') 
            {
                $this->crud->createCategory();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'admin/expense');
            }
            if ($param1 == 'update') 
            {
                $this->crud->updateCategory($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/expense');
            }
            if ($param1 == 'delete') 
            {
                $this->crud->deleteCategory($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
                redirect(base_url() . 'admin/expense');
            }
            $page_data['page_name']  = 'expense';
            $page_data['page_title'] = getPhrase('expense');
            $this->load->view('backend/index', $page_data);
        }
    
        //Teacher attendance function.
        function teacher_attendance()
        {
            $this->isAdmin();
            $page_data['page_name']  =  'teacher_attendance';
            $page_data['page_title'] =  getPhrase('teacher_attendance');
            $this->load->view('backend/index', $page_data);
        }
    
        //Teacher attendance report function.
        function teacher_attendance_report() 
        {
            $this->isAdmin();
             $page_data['month']        =  date('m');
             $page_data['page_name']    = 'teacher_attendance_report';
             $page_data['page_title']   = getPhrase('teacher_attendance_report');
             $this->load->view('backend/index',$page_data);
         }
    
        //Teacher report selector function.
        function teacher_report_selector()
        {
            $this->isAdmin();
            $data['year']       = $this->input->post('year');
            $data['month']      = $this->input->post('month');
            $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
            redirect(base_url().'admin/teacher_report_view/'.$data['month'].'/'.$data['year'],'refresh');
        }

        //Teachers report view function.
        function teacher_report_view($month = '', $year = '') 
        {
            $this->isAdmin();
            $page_data['month']      = $month;
            $page_data['year']       = $year;
            $page_data['page_name']  = 'teacher_report_view';
            $page_data['page_title'] = getPhrase('teacher_attendance_report');
            $this->load->view('backend/index', $page_data);
         }
    
        //Attendance for teachers function.
        function attendance_teacher()
        {
            $this->isAdmin();
            $timestamp = $this->crud->teacherAttendance();
            redirect(base_url().'admin/teacher_attendance_view/'. $timestamp,'refresh');
        }
    
        //Update attendance for teachers function.
        function attendance_update2($timestamp = '')
        {
            $this->isAdmin();
            $this->crud->updateAttendance($timestamp);
            $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
            redirect(base_url().'admin/teacher_attendance_view/'.$timestamp , 'refresh');
        }
    
        //View teacher attendance function.
        function teacher_attendance_view($timestamp = '')
        {
            $this->isAdmin();
            $page_data['timestamp'] = $timestamp;
            $page_data['page_name'] = 'teacher_attendance_view';
            $page_data['page_title'] = getPhrase('teacher_attendance');
            $this->load->view('backend/index', $page_data);
        }
    
        //Manage school bus function.
        function school_bus($param1 = '', $param2 = '', $param3 = '')
        {
            $this->isAdmin();
            if ($param1 == 'create') 
            {
                $this->crud->createBus();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'admin/school_bus/', 'refresh');
            }
            if ($param1 == 'update') 
            {
                $this->crud->updateBus($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/school_bus', 'refresh');
            }
            if ($param1 == 'delete') 
            {
                $this->crud->deleteBus($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
                redirect(base_url() . 'admin/school_bus/', 'refresh');
            }
            $page_data['page_name']  = 'school_bus';
            $page_data['page_title'] = getPhrase('school_bus');
            $this->load->view('backend/index', $page_data); 
        }
        
        //Manage your classrooms function.
        function classrooms($param1 = '', $param2 = '', $param3 = '')
        {
            $this->isAdmin();
            if ($param1 == 'create') 
            {
                $this->crud->createClassroom();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_added'));
                redirect(base_url() . 'admin/classrooms/', 'refresh');
            }
            if ($param1 == 'update') 
            {
                $this->crud->updateClassroom($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/classrooms/', 'refresh');
            }
            if ($param1 == 'delete') 
            {
                $this->crud->deleteClassroom($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
                redirect(base_url() . 'admin/classrooms/', 'refresh');
            }
            $page_data['page_name']   = 'classroom';
            $page_data['page_title']  = getPhrase('classrooms');
            $this->load->view('backend/index', $page_data);
        }
    
        //Update social login function.
        function social($param1 = '', $param2 = '', $param3 = '')
        {
            $this->isAdmin();
            if($param1 == 'login')
            {   
                $this->crud->updateSocialLogin();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/system_settings/', 'refresh');
            }
        }
    
        //System settings function.
        function system_settings($param1 = '', $param2 = '', $param3 = '')
        {
            $this->isAdmin();
            if ($param1 == 'do_update') 
            {
                $this->crud->updateSettings();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/system_settings/', 'refresh');
            }
            if($param1 == 'skin')
            {
                $this->crud->updateSkins();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/system_settings/', 'refresh');
            }
            if($param1 == 'social')
            {
                $this->crud->updateSocial();
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_updated'));
                redirect(base_url() . 'admin/system_settings/', 'refresh');
            }
            $page_data['page_name']  = 'system_settings';
            $page_data['page_title'] = getPhrase('system_settings');
            $this->load->view('backend/index', $page_data);
        }
    
        //Classes functions.
        function academic($param1 = '', $param2 = '', $param3 = '')
        {
            $this->isAdmin();
            $page_data['page_name']  = 'academic';
            $page_data['page_title'] = getPhrase('classes');
            $this->load->view('backend/index', $page_data);
        }
        
        //Subjects function.
        function cursos($class_id = '')
        {
            $this->isAdmin();
            $page_data['class_id']  = $class_id;
            $page_data['page_name']  = 'cursos';
            $page_data['page_title'] =  getPhrase('subjects');
            $this->load->view('backend/index', $page_data);
        }
    
        //Manage Library function.
        function library($param1 = '', $param2 = '', $param3 = '')
        {
            $this->isAdmin(); 
            if ($param1 == 'create') 
            {
                $this->crud->createBook();
                redirect(base_url() . 'admin/library/', 'refresh');
            }
            if ($param1 == 'update') 
            {
                $this->crud->updateBook($param2);
                redirect(base_url() . 'admin/update_book/'.$param2, 'refresh');
            }
            if ($param1 == 'delete') 
            {
                $this->crud->deleteBook($param2);
                $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));
                redirect(base_url() . 'admin/library', 'refresh');
            }
            $id = $this->input->post('class_id');
            if ($id == '')
            {
                $id = $this->db->get('class')->first_row()->class_id;
            }
            $page_data['id']         = $id;
            $page_data['page_name']  = 'library';
            $page_data['page_title'] = getPhrase('library');
            $this->load->view('backend/index', $page_data);
        }
    
        //Marks print view function.
        function marks_print_view($student_id  = '', $unit_id = '') 
        {
            $this->isAdmin();

            if($this->useDailyMarks){
                $class_id     = $this->db->get_where('enroll' , array('student_id' => $student_id , 'year' => $this->runningYear, 'semester_id' => $this->runningSemester))->row()->class_id;
                $class_name   = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
                $page_data['student_id'] =   $student_id;
                $page_data['class_id']   =   $class_id;
                $page_data['unit_id']    =   $unit_id;
                $this->load->view('backend/admin/daily_marks_print_view', $page_data);
            }
            else{
                $class_id     = $this->db->get_where('enroll' , array('student_id' => $student_id , 'year' => $this->runningYear, 'semester_id' => $this->runningSemester))->row()->class_id;
                $class_name   = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
                $page_data['student_id'] =   $student_id;
                $page_data['class_id']   =   $class_id;
                $page_data['unit_id']    =   $unit_id;
                $this->load->view('backend/admin/marks_print_view', $page_data);
            }
        }

        //Marks print view function.
        function marks_all_print_view($student_id  = '', $unit_id = '') 
        {
            $this->isAdmin();

            if($this->useDailyMarks){
                $class_id     = $this->db->get_where('enroll' , array('student_id' => $student_id , 'year' => $this->runningYear, 'semester_id' => $this->runningSemester))->row()->class_id;
                $class_name   = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
                $page_data['student_id'] =   $student_id;
                $page_data['class_id']   =   $class_id;
                $page_data['unit_id']    =   $unit_id;
                $this->load->view('backend/admin/daily_marks_all_print_view', $page_data);
            }
            else{
                $class_id     = $this->db->get_where('enroll' , array('student_id' => $student_id , 'year' => $this->runningYear, 'semester_id' => $this->runningSemester))->row()->class_id;
                $class_name   = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
                $page_data['student_id'] =   $student_id;
                $page_data['class_id']   =   $class_id;
                $page_data['unit_id']    =   $unit_id;
                $this->load->view('backend/admin/marks_all_print_view', $page_data);
            }
        }

        //Marks print view function.
        function marks_old_print_view($data = '') 
        {
            $this->isAdmin();

            $info = base64_decode($data);
            $ex = explode("-",$info);

            // <?php echo base64_encode($student_id.'-'.$class_id.'-'.$section_id.'-'.$year.'-'.$semester_id)
            
            $student_id = $ex[0];
            $class_id = $ex[1];

            if($this->useDailyMarks){                
                $page_data['student_id'] =   $student_id;
                $page_data['class_id']   =   $class_id;
                $page_data['data']       =   $data;
                $this->load->view('backend/admin/daily_marks_old_print_view_all_a', $page_data);
            }
            else{
                $page_data['student_id'] =   $student_id;
                $page_data['class_id']   =   $class_id;
                $page_data['data']       =   $data;                
                $this->load->view('backend/admin/marks_old_print_view_all', $page_data);
            }
        }

        /** Time Card Module */
        //Time card
        function time_card( $param1 = '', $param2 = '' ) 
        {
            $this->isAdmin();
            check_permission('time_card');
    
            $page_data['page_name']  = 'time_card';
            $page_data['page_title'] = getPhrase( 'time_card' );
            $this->load->view( 'backend/index', $page_data );
        }
        
        //Time Card Actions
        function timesheet_actions( $param1 = '', $param2 = '' )
        {            
            $this->isAdmin();
            check_permission('time_card');
    
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

            $this->isAdmin();
            check_permission('time_card');

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

        // Period Payment
        function payment_period( $param1 = '', $param2 = '' ) {

            $this->isAdmin();
            check_permission('time_card');

            $period_id = $this->db->get_where('payment_period', array('active' => '1'))->row()->period_id;
    
            if ( $param1 == 'create' )  {
                
                //Inactive old payment Period 
                $this->db->reset_query();
                $all['active']  = 0;
                $this->db->update( 'payment_period', $all );

                // Create 
                $this->db->reset_query();
                $data['name']           = $this->input->post( 'name' );
                $data['start_date']     = $this->input->post( 'start_date' );
                $data['end_date']       = $this->input->post( 'end_date' );
                $data['close_date']     = $this->input->post( 'close_date' );
                $data['payment_date']   = $this->input->post( 'payment_date' );
                $this->db->insert( 'payment_period', $data );
                $insert_id = $this->db->insert_id();

                // Create Schedule New_ Period
                $this->db->reset_query();
                $query = $this->db->query('CALL create_schedule_new_period('.$period_id.', '.$insert_id.')');
                $result1 =  $query->result();

                $this->session->set_flashdata( 'flash_message', getPhrase( 'successfully_added' ) );
                redirect( base_url() . 'admin/payment_period/', 'refresh' );
            }
    
            if ( $param1 == 'update' )  {
                $data['name']           = $this->input->post( 'name' );
                $data['start_date']     = $this->input->post( 'start_date' );
                $data['end_date']       = $this->input->post( 'end_date' );
                $data['close_date']     = $this->input->post( 'close_date' );
                $data['payment_date']   = $this->input->post( 'payment_date' );
                $this->db->where( 'period_id', $param2 );
                $this->db->update( 'payment_period', $data );
                $this->session->set_flashdata( 'flash_message', getPhrase( 'successfully_added' ) );
                redirect( base_url() . 'admin/payment_period/', 'refresh' );
            }
            if ( $param1 == 'delete' ) {
                $this->db->where( 'period_id', $param2 );
                $this->db->delete( 'payment_period' );
            }
    
            $page_data['page_name']  = 'payment_period';
            $page_data['page_title'] = getPhrase( 'payment_period' );
            $this->load->view( 'backend/index', $page_data );
        }

        // Worker Schedule
        function worker_schedule( $param1 = '', $param2 = '' ) {

            $this->isAdmin();
            check_permission('time_card');
            
            $payment_period = $this->db->get_where('payment_period', array('active' => '1'))->row();
            $period_id = $payment_period->period_id;
            
            if ( $param1 == 'create' )  {
                $worker_id          = $this->input->post( 'worker_id_new' );
                $last_sequence      = 1 + $this->db->query("SELECT max(sequence) as 'sequence' FROM `worker_schedule` WHERE worker_id = '$worker_id' AND period_id = '$period_id'")->first_row()->sequence;
                $data['worker_id']  = $worker_id;
                $data['period_id']  = $period_id;
                $data['sequence']   = $last_sequence;

                $days = $this->db->query("SELECT code, LOWER(name) as 'name' FROM `v_days`")->result_array();

                foreach($days as $item){

                    $name = $item['name'];
                    if($this->input->post( 'start_'.$name )){
                        $data['day_id']     = $item['code'];;
                        $data['start_time'] = $this->input->post( 'start_'.$name );
                        $data['end_time']   = $this->input->post( 'end_'.$name );
                        $this->db->insert( 'worker_schedule', $data );
                    }
                }

                $this->session->set_flashdata( 'flash_message', getPhrase( 'successfully_added' ) );
                redirect( base_url() . 'admin/worker_schedule/', 'refresh' );
            }

            if ( $param1 == 'update' )  {
                $worker_id  = $this->input->post( 'worker_id_update' );
                $sequence   = $this->input->post( 'sequence_update' );
                $days       = $this->db->query("SELECT code, LOWER(name) as 'name' FROM `v_days`")->result_array();

                foreach($days as $item){
                    $name               = $item['name'];
                    $schedule_id        = $this->input->post( 'schedule_id_'.$name );

                    if($schedule_id != ""){
                        $data['start_time'] = $this->input->post( 'start_'.$name );
                        $data['end_time']   = $this->input->post( 'end_'.$name );
                        $this->db->where( 'schedule_id', $schedule_id );
                        $this->db->update( 'worker_schedule', $data );
                    }
                    else if ($this->input->post( 'start_'.$name ))
                    {
                        $data['worker_id']  = $worker_id;
                        $data['period_id']  = $period_id;
                        $data['sequence']   = $sequence;
                        $data['day_id']     = $item['code'];;
                        $data['start_time'] = $this->input->post( 'start_'.$name );
                        $data['end_time']   = $this->input->post( 'end_'.$name );
                        $this->db->insert( 'worker_schedule', $data );
                    }
                }

                $this->session->set_flashdata( 'flash_message', getPhrase( 'successfully_updated' ) );
                redirect( base_url() . 'admin/worker_schedule/', 'refresh' );
            }
    
            $page_data['worker_id']  = $this->input->post('worker_id');
            $page_data['period_id']  = $period_id ;
            $page_data['page_name']  = 'worker_schedule';
            $page_data['page_title'] = getPhrase( 'worker_schedule' );
            $this->load->view( 'backend/index', $page_data );
        }

        // Worker
        function workers( $param1 = '', $param2 = '', $param3 = '' ) {

            $this->isAdmin();
            check_permission('time_card');
    
            if ( $param1 == 'create' )  {
                $data['user_id']        = $this->input->post( 'user_id' );
                $data['type_user']      = $this->input->post( 'type_user' );
                $data['start_date']     = $this->input->post( 'start_date' );
                $data['manual_hours']   = $this->input->post( 'manual_hours' );
                $data['over_time']       = $this->input->post( 'overtime' );
                $this->db->insert( 'worker', $data );
                $this->session->set_flashdata( 'flash_message', getPhrase( 'successfully_added' ) );
                redirect( base_url() . 'admin/workers/', 'refresh' );
            }
            if ( $param1 == 'update' )  {
                $data['start_date']     = $this->input->post( 'start_date' );
                $data['manual_hours']   = $this->input->post( 'manual_hours' );
                $data['over_time']       = $this->input->post( 'overtime' );
                $this->db->where( 'worker_id', $param2 );
                $this->db->update( 'worker', $data );
                $this->session->set_flashdata( 'flash_message', getPhrase( 'successfully_updated' ) );
                redirect( base_url() . 'admin/workers/', 'refresh' );
            }
            if ( $param1 == 'delete' )  {
                $data['status'] = 0;
                $this->db->where( 'worker_id', $param2 );
                $this->db->update( 'worker', $data );
                $this->session->set_flashdata( 'flash_message', getPhrase( 'successfully_deleted' ) );
                redirect( base_url() . 'admin/workers/', 'refresh' );
            }
    
            $page_data['page_name']  = 'workers';
            $page_data['page_title'] = getPhrase( 'workers' );
            $this->load->view( 'backend/index', $page_data );
        }

        // Worked hours 
        function worked_hours( $param1 = '', $param2 = '' ) {

            $this->isAdmin();
            check_permission('time_card');

            $selected_period_id = $this->input->post('selected_period_id');
    
            if($param1 != ''){
                $period_id = $param1;
            }
            else if ($selected_period_id != '')
            {
                $period_id = $selected_period_id;
            }
            else
            {
                $payment_period = $this->db->get_where('payment_period', array('active' => '1'))->row();
                $period_id = $payment_period->period_id;
            }
            
            $page_data['period_id'] = $period_id;
            $page_data['page_name']  = 'worked_hours';
            $page_data['page_title'] = getPhrase( 'worked_hours' );
            $this->load->view( 'backend/index', $page_data );
        }

        // Get List of Users
        function get_users( $type_user = '') {

            $users = $this->db->get_where('v_users', array('type_user' => $type_user, 'status' => 1 ))->result_array();
            echo '<option value="">' . getPhrase( 'select' ) . '</option>';
            foreach ( $users as $row )  {
                echo '<option value="' . $row['user_id'] . '">' . $row['name'] . '</option>';
            }
        }

        // login_as
        function login_as($param1 = '', $user_id = ''){
            $this->isAdmin();

            $hasPermissions = 0;

            $role_id = $this->session->userdata( 'role_id' );
            $type = '';
            
            //validate if the user has the right to do
            switch ($param1) {
                case 'admin':
                    $type = 'login_as_admin';
                    break;
                case 'teacher':
                    $type = 'login_as_teacher';
                    break;
                case 'student':
                    $type = 'login_as_student';
                    break;
                case 'parent':
                    $type = 'login_as_parent';
                    break;
                case 'accountant':
                    $type = 'login_as_accountant';
                    break;
                case 'librarian':
                    $type = 'login_as_librarian';
                    break;
                default:
                    $this->session->set_flashdata('flash_message', getPhrase('not_authorized'));
                    redirect( base_url(), 'refresh' );
                    break;
            }

            if(has_permission($type, $role_id)) {

                $table_id = $param1 . '_id';
                $query = $this->db->get_where($param1, array($table_id => $user_id));
                $row = $query->row();

                $this->crud->save_login_as_log($param1, $user_id);  

                if ( $param1 == 'admin' ) {

                    $this->unset_admin();
                    $this->session->set_userdata('admin_login', '1');
                    $this->session->set_userdata('role_id', $row->owner_status);
                    $this->session->set_userdata('admin_id', $row->admin_id);
                    $this->session->set_userdata('login_user_id', $row->admin_id);
                    $this->session->set_userdata('name', $row->first_name);
                    $this->session->set_userdata('login_type', 'admin');
                    redirect(base_url() . 'admin/panel/', 'refresh');
                }
                if ( $param1 == 'teacher' ) {

                    $this->unset_admin();
                    $this->session->set_userdata('role_id', '5');
                    $this->session->set_userdata('teacher_login', '1');
                    $this->session->set_userdata('teacher_id', $row->teacher_id);
                    $this->session->set_userdata('login_user_id', $row->teacher_id);
                    $this->session->set_userdata('name', $row->first_name);
                    $this->session->set_userdata('login_type', 'teacher');

                    redirect(base_url() . 'teacher/panel/', 'refresh');
                }
                if ( $param1 == 'student' ){
                    $this->unset_admin();
                    $this->session->set_userdata('role_id', '6');
                    $this->session->set_userdata('program_id', $row->program_id);
                    $this->session->set_userdata('student_login', $row->student_session);
                    $this->session->set_userdata('student_id', $row->student_id);
                    $this->session->set_userdata('login_user_id', $row->student_id);
                    $this->session->set_userdata('name', $row->first_name);
                    $this->session->set_userdata('login_type', 'student');
                    redirect(base_url() . 'student/panel/', 'refresh');
                }
                if ( $param1 == 'parent' ){
                    
                    $this->unset_admin();
                    $this->session->set_userdata('role_id', '7');
                    $this->session->set_userdata('parent_login', '1');
                    $this->session->set_userdata('parent_id', $row->parent_id);
                    $this->session->set_userdata('login_user_id', $row->parent_id);
                    $this->session->set_userdata('name', $row->first_name);
                    $this->session->set_userdata('login_type', 'parent');
                    redirect(base_url() . 'parents/panel/', 'refresh');
                }
                if ( $param1 == 'accountant' ){
                    
                    $this->unset_admin();
                    $this->session->set_userdata('role_id', '4');
                    $this->session->set_userdata('accountant_login', '1');
                    $this->session->set_userdata('accountant_id', $row->accountant_id);
                    $this->session->set_userdata('login_user_id', $row->accountant_id);
                    $this->session->set_userdata('name', $row->first_name);
                    $this->session->set_userdata('login_type', 'accountant');
                    redirect(base_url() . 'accountant/panel/', 'refresh');
                }
                if ( $param1 == 'librarian' ){
                    
                    $this->unset_admin();
                    $this->session->set_userdata('role_id', '8');
                    $this->session->set_userdata('librarian_login', '1');
                    $this->session->set_userdata('librarian_id', $row->librarian_id);
                    $this->session->set_userdata('login_user_id', $row->librarian_id);
                    $this->session->set_userdata('name', $row->first_name);
                    $this->session->set_userdata('login_type', 'librarian');
                    redirect(base_url() . 'librarian/panel/', 'refresh');
                }

            }
            else{
                $this->session->set_flashdata('flash_message', getPhrase('not_authorized'));
                redirect( base_url(), 'refresh' );
            }
            redirect( base_url(), 'refresh' );
        }
        
        // Help View
        function help(){
            $this->isAdmin();
    
            $page_data['page_name']  = 'help';
            $page_data['page_title'] = getPhrase( 'help' ); 
            $this->load->view( 'backend/index', $page_data );
        }

        /** Student Module */
        // 
        function admission_student_interaction($action, $student_id = '', $interaction_id = '', $return_url = '')
        {
            $message = '';
            switch ($action) 
            {
                case 'add':
                    if($return_url == '')
                    {
                        $return_url = 'admin/student_portal/'.$student_id;
                    }
                    else
                    {
                        $return_url = base64_decode($return_url);
                    }
                    
                    $this->student->add_interaction($student_id);
                    $message =  getPhrase('successfully_added');
                    break;

                case 'update':
                    if($return_url == '')
                        $return_url = 'admin/student_portal/'.$student_id;
                    
                    $this->student->update_interaction($interaction_id);
                    $message =  getPhrase('successfully_added');
                    break;

                default:
                    # code...
                    break;
            }

            $this->session->set_flashdata('flash_message' , $message);
            redirect(base_url() . $return_url, 'refresh');
        } 
        
        // Student Placement Test
        function placement_achievement($student_id, $param1='')
        {
            $this->isAdmin();
            
            $class_id     = $this->db->get_where('enroll' , array('student_id' => $student_id , 'year' => $this->runningYear, 'semester_id' => $this->runningSemester))->row()->class_id;
            $page_data['page_name']  = 'placement_achievement';
            $page_data['page_title'] =  getPhrase('placement_achievement');
            $page_data['student_id'] =  $student_id;
            $page_data['class_id']   =  $class_id;
            $this->load->view('backend/index', $page_data);
        }
        
        // Test print view function.
        function test_print($test_id, $student_id = "") 
        {
            $this->isAdmin();

            $page_data['test_id']       = $test_id;
            $page_data['student_id']    = $student_id;
            $this->load->view('backend/admin/test_print', $page_data);
            
        }

        /** Admission Module */
        // Admission Dashboard
        function admission_dashboard()
        {
            $this->isAdmin('admission_module');

            $name       = "";
            $country_id = "_blank";
            $status_id  = "_blank";

            if ($_SERVER['REQUEST_METHOD'] === 'POST') 
            {
                $country_id = $this->input->post('country_id');
                $status_id  = $this->input->post('status_id');
                $name       = $this->input->post('name');
            }

            $page_data['country_id'] = $country_id;
            $page_data['status_id']  = $status_id;
            $page_data['name']       = $name;
            $page_data['page_name']  = 'admission_dashboard';
            $page_data['page_title'] =  getPhrase('admission_dashboard');
            $this->load->view('backend/index', $page_data);
        }

        function admission_applicants($param1 = '')
        {
            $this->isAdmin('admission_module');

            if($param1 != '')
            {
                $array      = explode('|',base64_decode($param1));
                
                $name       = "";
                $country_id = "";
                $status_id  = $array[1];
                $type_id    = $array[0];
            }
            else
            {
                $name       = "";
                $country_id = "";
                $status_id  = "";
                $type_id    = "";
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') 
            {
                $country_id = $this->input->post('country_id');
                $status_id  = $this->input->post('status_id');
                $type_id    = $this->input->post('type_id');
                $name       = $this->input->post('name');
                $search     = true;
            }

            $page_data['country_id'] = $country_id;
            $page_data['status_id']  = $status_id;
            $page_data['type_id']    = $type_id;
            $page_data['search']     = $search;
            $page_data['name']       = $name;
            $page_data['page_name']  = 'admission_applicants';
            $page_data['page_title'] =  getPhrase('admission_applicants');
            $this->load->view('backend/index', $page_data);
        }

        //Create Student function.
        function admission_new_applicant($param1 = '', $param2 = '')
        {
            $this->isAdmin('admission_module');
            $page_data['page_name']  = 'admission_new_applicant';
            $page_data['page_title'] = getPhrase('admissions');
            $this->load->view('backend/index', $page_data);
        }

        //Create Student function.
        function admission_new_student($data = '', $param2 = '')
        {
            $this->isAdmin('admission_module');
            // If is convert of applicant to student
            $page_data['data']  = $data;
            $page_data['page_name']  = 'admission_new_student';
            $page_data['page_title'] = getPhrase('admissions');
            $this->load->view('backend/index', $page_data);
        }

        // Create Student function.
        function admission_applicant($applicant_id = '', $param2 = '')
        {
            $this->isAdmin('admission_module');
            $page_data['applicant_id'] = $applicant_id;
            $page_data['page_name']    = 'admission_applicant';
            $page_data['page_title']   = getPhrase('admission_applicant');
            $this->load->view('backend/index', $page_data);
        }

        // 
        function admission_applicant_update($applicant_id = '', $param2 = '')
        {
            $this->isAdmin('admission_module');
            $page_data['applicant_id'] = $applicant_id;
            $page_data['page_name']    = 'admission_applicant_update';
            $page_data['page_title']   = getPhrase('admission_applicant_update');
            $this->load->view('backend/index', $page_data);
        }


        function applicant($action, $applicant_id = '', $return_url = '')
        {
            $this->isAdmin('admission_module');

            if($return_url == '')
            {
                $return_url = 'admission_applicants';
            }

            $message = '';
            switch ($action) {
                case 'register':
                    $id = $this->applicant->register();
                    $return_url = 'admission_applicant/'.$id;
                    $message =  getPhrase('successfully_added');
                    break;
                case 'update':
                    $this->applicant->update($applicant_id);
                    $return_url = 'admission_applicant/'.$applicant_id;
                    $message =  getPhrase('successfully_updated');
                    break;
                
                default:
                    # code...
                    break;
            }

            $this->session->set_flashdata('flash_message' , $message);// getPhrase('account_has_been_created_but_require_approval'));
            redirect(base_url() . 'admin/'.$return_url, 'refresh');
        }

        function admission_search($search_key)
        {
            $this->isAdmin('admission_module');
            $token = $this->generate_token();

            $search_value = base64_encode($search_key);

            $url_app = ADMISSION_PLATFORM_URL.'student_list?auth_token='.$token.'&search_string='.$search_value.'&search_field=name';

            $ch_app = curl_init($url_app);
            curl_setopt($ch_app, CURLOPT_HTTPGET, true);
            curl_setopt($ch_app, CURLOPT_RETURNTRANSFER, true);
            $response_json_app = curl_exec($ch_app);
            curl_close($ch_app);
            $response = json_decode($response_json_app, true);

            if($response["status"] === "success")
            {
                if(count($response["student_list"]) > 0 )
                {
                    // Create the HTML response
                    
                    $html_string  = '<div class="table-responsive">';
                    $html_string .= '<table class="table table-bordered">';
                    $html_string .= '<thead>';

                    $html_string .= '<tr style="background:#f2f4f8; height:35px;">';
                    $html_string .= '<th style="text-align: center;">';
                    $html_string .= getPhrase('full_name');
                    $html_string .= '</th>';
                    
                    $html_string .= '<th style="text-align: center;">';
                    $html_string .= getPhrase('gender');;
                    $html_string .= '</th>';

                    $html_string .= '<th style="text-align: center;">';
                    $html_string .= getPhrase('birthdate');;
                    $html_string .= '</th>';

                    $html_string .= '<th style="text-align: center;">';
                    $html_string .= getPhrase('phone');;
                    $html_string .= '</th>';

                    $html_string .= '<th style="text-align: center;">';
                    $html_string .= getPhrase('country');;
                    $html_string .= '</th>';

                    $html_string .= '<th style="text-align: center;">';
                    $html_string .= getPhrase('email');
                    $html_string .= '</th>';

                    $html_string .= '<th style="text-align: center;">';
                    $html_string .= getPhrase('status_application');;
                    $html_string .= '</th>';

                    $html_string .= '<th style="text-align: center;">';
                    $html_string .= getPhrase('payment_type');;
                    $html_string .= '</th>';

                    $html_string .= '<th style="text-align: center;">';
                    $html_string .= getPhrase('created_at');
                    $html_string .= '</th>';

                    $html_string .= '<th style="text-align: center;">';
                    $html_string .= getPhrase('action');
                    $html_string .= '</th>';
                    $html_string .= '</tr>';
                    $html_string .= '</thead>';
                    $html_string .= '<tbody>';

                    $student_list = $response["student_list"];

                    foreach ($student_list as $row)
                    {

                        $email = $row['email'];
                        // look if exist
                        $applicant_id     = $this->db->get_where('applicant' , array('email' => $email ))->result_array();

                        if(count($applicant_id) == 0 ){

                            $encode = base64_encode($row['email']);

                            $html_string .= '<tr style="height:25px;">';
                            $html_string .= '<td><center>';
                            $html_string .= '<label name="full_name_'.$row['user_id'].'">';
                            $html_string .= $row['full_name'];
                            $html_string .= '</label>';
                            $html_string .= '</center></td>';

                            $html_string .= '<td><center>';
                            $html_string .= '<label name="gender'.$row['user_id'].'">';
                            $html_string .= $row['gender'];
                            $html_string .= '</label>';
                            $html_string .= '</center></td>';

                            $html_string .= '<td><center>';
                            $html_string .= '<label name="birthday'.$row['user_id'].'">';
                            $html_string .= date('m/d/Y', strtotime($row['birthday']));
                            $html_string .= '</label>';
                            $html_string .= '</center></td>';

                            $html_string .= '<td><center>';
                            $html_string .= '<label name="phone'.$row['user_id'].'">';
                            $html_string .= $row['phone'];
                            $html_string .= '</label>';
                            $html_string .= '</center></td>';

                            $html_string .= '<td><center>';
                            $html_string .= '<label name="country'.$row['user_id'].'">';
                            $html_string .= $row['country'];
                            $html_string .= '</label>';
                            $html_string .= '</center></td>';

                            $html_string .= '<td><center>';
                            $html_string .= '<label name="email_'.$row['user_id'].'">';
                            $html_string .= $email;
                            $html_string .= '</label>';
                            $html_string .= '</center></td>';

                            $html_string .= '<td><center>';
                            $html_string .= '<label name="status_name_'.$row['user_id'].'">';
                            $html_string .= $row['status_name'];
                            $html_string .= '</label>';
                            $html_string .= '</center></td>';                            


                            $html_string .= '<td><center>';
                            $html_string .= '<label name="created_at_'.$row['user_id'].'">';
                            $html_string .= ($row['payment_type'] == null ? '' : ( $row['payment_type'] == 1 ? 'PayPal' : 'Manual'));
                            $html_string .= '</label>';
                            $html_string .= '</center></td>';

                            $html_string .= '<td><center>';
                            $html_string .= '<label name="created_at_'.$row['user_id'].'">';
                            $html_string .= $row['created_at'];
                            $html_string .= '</label>';
                            $html_string .= '</center></td>';

                            $html_string .= '<td><center>';                            
                            $html_string .= '<a class="text-center" href="/admin/admission_import_student/'.$encode.'">';
                            $html_string .= '<i class="picons-thin-icon-thin-0086_import_file_load"></i>';
                            $html_string .= '</a>';
                            $html_string .= '</center></td>';
                        }
                        
                    }
                    
                    $html_string .= '</tbody>';
                    $html_string .= '</table>';
                    $html_string .= '</div>';

                    echo $html_string;
                }
                else
                {
                    echo "no_result";
                }
            }
            else
            {
                echo "failed";
            }
            
        }

        function admission_import_student($encode)
        {
            $this->isAdmin('admission_module');

            $email = base64_decode($encode);
            $token = $this->generate_token();

            $url_app = ADMISSION_PLATFORM_URL.'student_list?auth_token='.$token.'&search_string='.$encode.'&search_field=email';

            $ch_app = curl_init($url_app);
            curl_setopt($ch_app, CURLOPT_HTTPGET, true);
            curl_setopt($ch_app, CURLOPT_RETURNTRANSFER, true);
            $response_json_app = curl_exec($ch_app);
            curl_close($ch_app);
            $response = json_decode($response_json_app, true);

            if($response["status"] === "success")
            {
                if(count($response["student_list"]) == 1 )
                {
                    $student = $response["student_list"][0];

                    $gender = strtoupper(substr($student['gender'], 0, 1));

                    $country_id = $this->db->get_where('countries' , array('name' => $student['country'] ))->row()->country_id;

                    $status = $student['payment_type'] > 0 ? 2 : 0;

                    $_POST['first_name']        = $student['first_name'];
                    $_POST['last_name']         = $student['last_name'];
                    $_POST['datetimepicker']    = $student['birthday'];
                    $_POST['email']             = $student['email'];
                    $_POST['phone']             = $student['phone'];
                    $_POST['gender']            = $gender;
                    $_POST['address']           = $student['address'];
                    $_POST['country_id']        = $country_id;
                    $_POST['admission_id']      = $student['user_id']; 
                    $_POST['type_id']           = '1'; // 1 = international
                    $_POST['is_imported']       = '1'; 
                    
                    if($status > 0)
                        $_POST['status_id']     = 2; 
                    
                    $this->applicant('register');
                }
            }
            else
            {
                echo "failed";
            }

        }

        function admission_applicant_interaction($action, $applicant_id = '', $interaction_id = '', $return_url = '')
        {
            $this->isAdmin('admission_module');

            $message = '';
            switch ($action) {
                case 'add':
                    if($return_url == '')
                    {
                        if($applicant_id != '')
                            $return_url = 'admin/admission_applicant/'.$applicant_id;
                        else
                            $return_url = 'admin/admission_applicants';
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
                        $return_url = 'admin/admission_applicant/'.$applicant_id;
                    $this->applicant->update_interaction($interaction_id);
                    $message =  getPhrase('successfully_added');

                default:
                    # code...
                    break;
            }

            $this->session->set_flashdata('flash_message' , $message);
            redirect(base_url() . $return_url, 'refresh');
        }

        function admission_applicant_convert($applicant_id)
        {
            $this->isAdmin('admission_module');

            $applicant = $this->db->get_where('applicant' , array('applicant_id' => $applicant_id))->row();

            $birthday = date('m/d/Y', strtotime($applicant->birthday));

            $data['first_name']     = $applicant->first_name;
            $data['last_name']      = $applicant->last_name;
            $data['birthday']       = $birthday;
            $data['email']          = $applicant->email;
            $data['phone']          = $applicant->phone;
            $data['gender']         = $applicant->gender;
            $data['address']        = $applicant->address;
            $data['country_id']     = $applicant->country_id;
            $data['referral_by']    = $applicant->referral_by;
            $data['applicant_id']   = $applicant_id;

            // echo '<pre>';
            // var_dump($data);
            // echo '</pre>';
            
            
            $this->admission_new_student($data);
        }

        function admission_applicant_document_api($document_id, $user_id)
        {
            $this->isAdmin('admission_module');
            $page_data['document_id']  = str_replace('==','',$document_id);
            $page_data['user_id']      = $user_id;
            $page_data['page_name']    = 'admission_applicant_document_api';
            $page_data['page_title']   = getPhrase('admission_applicant_document_api');
            $this->load->view('backend/admin/admission_applicant_document_api', $page_data);
        }

        function admission_applicant_send_message_api($email, $message_thread_code)
        {
            $this->isAdmin('admission_module');

            $message = html_escape($this->input->post( 'message' ));

            $email = base64_decode($email);

            $token = $this->generate_token();
            $url_app = ADMISSION_PLATFORM_URL.'message_thread?auth_token='.$token.'&email='.$email.'&message_thread_code='.$message_thread_code.'&message='.$message;
            $ch_app = curl_init($url_app);
            curl_setopt($ch_app, CURLOPT_POST, true);
            curl_setopt($ch_app, CURLOPT_POSTFIELDS, $message);

            $response_json_app = curl_exec($ch_app);
            curl_close($ch_app);
            $response_app = json_decode($response_json_app, true);

            echo $response_app;
        }

        function admission_applicant_update_tags($applicant_id, $tag_id, $selected)
        {
            $this->isAdmin('admission_module');

            $this->applicant->update_tag($applicant_id, $tag_id, $selected);
        }

        /** Reports Module */
        // task Dashboard
        function reports_students_all()
        {
            $year_id = $this->input->post( 'year_id' );
            if ($year_id == '') {
                $year_id = $this->runningYear;
            }

            $semester_id = $this->input->post( 'semester_id' );
            if ( $semester_id == '' ) {
                $semester_id = $this->runningSemester;
            }

            $this->isAdmin();
            $page_data['year_id']       = $year_id;
            $page_data['semester_id']   = $semester_id;
            $page_data['page_name']     = 'reports_students_all';
            $page_data['page_title']    = getPhrase('reports_students_all');
            $this->load->view('backend/index', $page_data);
        }
        
        /** Task Module */
        // task Dashboard
        function task_dashboard()
        {
            $this->isAdmin('task_module');

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
            $page_data['page_name']     = 'task_dashboard';
            $page_data['page_title']    =  getPhrase('task_dashboard');
            $this->load->view('backend/index', $page_data);
        }

        function task_list($param1 = '')
        {
            $this->isAdmin('task_module');

            if($param1 != '')
            {
                $array      = explode('|',base64_decode($param1));

                $status_id      = $array[0] != '-' ? $array[0] : '';
                $priority_id    = $array[1] != '-' ? $array[1] : '';
                $assigned_me    = 0;
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
            $page_data['page_name']     = 'task_list';
            $page_data['page_title']    =  getPhrase('task_list');
            $this->load->view('backend/index', $page_data);
        }

        function task_applicant()
        {
            $this->isAdmin('task_module');
            
            if($_SERVER['REQUEST_METHOD'] === 'POST')
            {   
                $category_id    = $this->input->post('category_id');                
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

            $page_data['category_id']   = $category_id;
            $page_data['priority_id']   = $priority_id;
            $page_data['status_id']     = $status_id;
            $page_data['text']          = $text;
            $page_data['assigned_me']   = $assigned_me;
            $page_data['page_name']     = 'task_applicant';
            $page_data['page_title']    =  getPhrase('task_applicant');
            $this->load->view('backend/index', $page_data);
        }

        function task_student()
        {
            $this->isAdmin('task_module');
            
            if($_SERVER['REQUEST_METHOD'] === 'POST')
            {   
                $category_id    = $this->input->post('category_id');                
                $priority_id    = $this->input->post('priority_id');
                $status_id      = $this->input->post('status_id');
                $text           = $this->input->post('text');
                $assigned_me    = $this->input->post('assigned_me');                
            }
            else
            {    
                $category_id  = "_blank";
                $priority_id    = "_blank";
                $status_id      = "_blank";
                $assigned_me = 1;
            }

            $page_data['category_id']   = $category_id;
            $page_data['priority_id']   = $priority_id;
            $page_data['status_id']     = $status_id;
            $page_data['text']          = $text;
            $page_data['assigned_me']   = $assigned_me;
            $page_data['page_name']     = 'task_student';
            $page_data['page_title']    =  getPhrase('task_student');
            $this->load->view('backend/index', $page_data);
        }

        function task_info($task_code = '', $param2 = '')
        {
            $this->isAdmin('task_module');
            $page_data['task_code']    = $task_code;
            $page_data['page_name']    = 'task_info';
            $page_data['page_title']   = getPhrase('task_info');
            $this->load->view('backend/index', $page_data);

        }

        function task($action, $task_id = '', $return_url = '')
        {
            $this->isAdmin('task_module');

            $message = '';
            switch ($action) {
                case 'register':
                    
                    $this->task->create();
                    $message =  getPhrase('successfully_added');
                    
                    $user_id    = html_escape($this->input->post('user_id'));

                    switch ($return_url) {
                        case 'student':
                            $return_url = 'student_portal/'.$user_id;
                            break;
                        case 'applicant':
                            $return_url = 'admission_applicant/'.$user_id;
                            # code...
                            break;
                    }
                    break;
                case 'update':
                    $this->task->update($task_id);
                    $message =  getPhrase('successfully_updated');
                    break;
                
                default:
                    # code...
                    break;
            }

            $this->session->set_flashdata('flash_message' , $message);
            redirect(base_url() .'admin/'.$return_url, 'refresh');
        }

        function task_message($action, $task_code = '', $task_message_id = '', $return_url = '')
        {
            $this->isAdmin('task_module');

            if($return_url == '')
            {
                $return_url = 'admin/task_info/'.$task_code;
            }
            else
            {
                if(base64_decode($return_url, true ))
                {
                    $return_url = 'admin/'.base64_decode($return_url);
                }
                else
                {
                    $return_url = 'admin/'.$return_url;
                }
            }

            $message = '';
            switch ($action) {
                case 'add':
                    $this->task->add_message($task_code);
                    $message =  getPhrase('successfully_added');

                    if($task_code != '')
                    {
                        $status_id_old = $this->db->get_where('task' , array('task_code' => $task_code))->row()->status;
        
                        $status_id_new = $this->input->post('status_id');
        
                        if($status_id_old != $status_id_new)
                        {
                            $this->task->update_status($task_code, $status_id_new);
                        }
                    }

                    break;
                case 'update':                    
                    $this->task->update_message($task_message_id);
                    $message =  getPhrase('successfully_updated');

                default:
                    # code...
                    break;
            }

            $this->session->set_flashdata('flash_message' , $message);
            redirect(base_url() . $return_url, 'refresh');
        }

        //Get subjects by classId and sectionId.
        function get_category_dropdown($department_id)
        {
            $departments = $this->task->get_categories($department_id);
            $options = '';
            foreach ( $departments as $row )  {
                $options .= '<option value="' . $row['category_id'] . '">' . $row['name'] . '</option>';
            }
            echo $options;
        }

        /** Tools functions */
        // unset Admin cookies
        function unset_admin(){
            $this->session->unset_userdata('admin_login');
            $this->session->unset_userdata('role_id');
            $this->session->unset_userdata('admin_id');
            $this->session->unset_userdata('login_user_id');
            $this->session->unset_userdata('name');
            $this->session->unset_userdata('login_type');
            $this->session->unset_userdata('program_id');
        }

        //Check Admin session and access. 
        function isAdmin($permission_for = '')
        {
            if ($this->session->userdata('admin_login') != 1 )
            {
                $this->session->set_userdata('last_page', current_url());
                redirect(base_url(), 'refresh');
            }

            if($permission_for != '')
            {
                check_permission($permission_for);
            }
        }

        /** Admission Integration */
        function generate_token()
        {
            $url = 'https://admission.americanone-esl.com/api/login?email=victor.ochoa@americanone-esl.com&password=victor.ochoa';
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HTTPGET, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response_json = curl_exec($ch);
            curl_close($ch);
            $response=json_decode($response_json, true);

            return $response['token'];
        }

        //Get sections by classId function.
        function get_class_section($class_id = '', $pYear = '', $pSemesterId = '')
        {
            $year       =   $pYear == '' ? $this->runningYear : $pYear;
            $SemesterId =   $pSemesterId == '' ? $this->runningSemester : $pSemesterId;
            
            $sections = $this->db->get_where('section' , array('class_id' => $class_id, 'year' => $year, 'semester_id' => $SemesterId))->result_array();
            echo '<option value="">' . getPhrase('select') . '</option>';
            foreach ($sections as $row) 
            {
                echo '<option value="' . $row['section_id'] . '">' . $row['name'] . '</option>';
            }
        }

        //Get sections by classId and teacherID of the current semester.
        function get_class_section_by_teacher($class_id = '', $teacher_id = '')
        {
            $year       =   $this->runningYear;
            $SemesterId =   $this->runningSemester;
            
            $sections = $this->db->query("SELECT section_id, section_name FROM v_subject WHERE class_id = '$class_id' AND teacher_id = '$teacher_id' AND year = '$year' AND semester_id = '$SemesterId' GROUP BY section_id")->result_array();
            
            echo '<option value="">' . getPhrase('select') . '</option>';
            foreach ($sections as $row) 
            {
                echo '<option value="' . $row['section_id'] . '">' . $row['section_name'] . '</option>';
            }
        }

        //Get subjects by classId and sectionId.
        function get_class_section_subjects($class_id = '', $section_id = '', $pYear = '', $pSemesterId = '')
        {
            $year       =   $pYear == '' ? $this->runningYear : $pYear;
            $SemesterId =   $pSemesterId == '' ? $this->runningSemester : $pSemesterId;

            $subject = $this->db->get_where( 'subject', array( 'class_id' => $class_id, 'section_id' => $section_id, 'year' => $year, 'semester_id' => $SemesterId ) )->result_array();
            
            foreach ( $subject as $row )  {
                echo '<option value="' . $row['subject_id'] . '">' . $row['name'] . ' (' . $this->crud->get_name('teacher', $row['teacher_id']) . ')' . '</option>';
            }
        }

        //Get subjects by classId and sectionId of the current semester.
        function get_class_section_subjects_for_update($student_id = '', $class_id = '', $section_id = '')
        {
            $running_year = $this->runningYear;
            $running_semester = $this->runningSemester;

            $student_enroll = $this->db->get_where('v_enroll', array('student_id' => $student_id, 'year' => $running_year, 'semester_id' => $running_semester ))->result_array(); 

            $subjects = $this->db->get_where( 'v_subject', array( 'class_id' => $class_id, 'section_id' => $section_id  ) )->result_array();
            $html = "";
            $count = 0;
    
            foreach ($student_enroll as $item) {
                $count++;
                $html .= '<div class="col col-lg-6 col-md-6 col-sm-12 col-12">';
                $html .= '<div class="form-group label-floating is-select">';
                $html .= '<label class="control-label">'.getPhrase('subject').'_'.$count.'</label>';
                $html .= '<div class="select">';
                $html .= '<select name="future_subject_id_'.$item['subject_id'].'">';
                $html .= '<option value="">'.getPhrase('select').'</option>';
                foreach ( $subjects as $item )  {
                    $html .= '<option value="'.$item['subject_id'].'">';
                    $html .= $item['name']." - ".$item["teacher_name"];
                    $html .= '</option> ';
                }
                $html .= '</select> </div> </div> </div>';
            }
            echo $html;
        }

        //Get Students by sectionId function of the current semester.
        function get_class_stundets($section_id = '')
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

        //Get subjects by sectionId function.
        function get_class_subject($section_id = '')
        {
            $subjects = $this->db->get_where('subject' , array('section_id' => $section_id))->result_array();
            foreach ($subjects as $row) 
            {
                echo '<option value="' . $row['subject_id'] . '">' . $row['name'] . '</option>';
            }
        }
        
        //Get Students by SectionId function.
        function get_class_students_section($section_id = '')
        {
            $students = $this->db->get_where('enroll' , array('section_id' => $section_id , 'year' => $this->runningYear, 'semester_id' => $this->runningSemester))->result_array();
            foreach ($students as $row) 
            {
                echo '<option value="' . $row['student_id'] . '">' . $this->crud->get_name('student', $row['student_id']) . '</option>';
            }
        }

        //Get Students by SectionId
        function get_class_studentss($section_id = '')
        {
            $students = $this->db->get_where('enroll' , array('section_id' => $section_id))->result_array();
            foreach ($students as $row) 
            {
             echo '<option value="' . $row['student_id'] . '">' . $this->crud->get_name('student', $row['student_id'])  . '</option>';
            }
        }

        //Get all students to Bulk invoice function.
        function get_class_students_mass($class_id = '')
        {
            $this->crud->fetchStudents($class_id);
        }

        //Get students to promote function.
        function get_students_to_promote($class_id_from = '' , $class_id_to  = '', $running_year  = '', $promotion_year = '', $section_id_from = '')
        {
            $page_data['class_id_from']     =   $class_id_from;
            $page_data['section_id_from']   =   $section_id_from;
            $page_data['class_id_to']       =   $class_id_to;
            $page_data['running_year']      =   $running_year;
            $page_data['promotion_year']    =   $promotion_year;
            $this->load->view('backend/admin/student_promotion_selector' , $page_data);
        }
        
        //Get subjects by classId function
        function get_subject($class_id = '') 
        {
            $subject = $this->db->get_where('subject' , array('class_id' => $class_id))->result_array();
            foreach ($subject as $row) 
            {
                echo '<option value="' . $row['subject_id'] . '">' . $row['name'] . '</option>';
            }
        }

        //Get Sections by ClassId in dropdown function.
        function get_sectionss($class_id = '')
        {
            $sections = $this->db->get_where('section' , array('class_id' => $class_id))->result_array();
            foreach ($sections as $row) 
            {
                echo '<option value="' . $row['section_id'] . '">' . $row['name'] . '</option>';
            }
        }
        //End of Admin.php content. 
    }