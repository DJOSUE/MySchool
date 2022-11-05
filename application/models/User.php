<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User extends School 
{
    private $runningYear = '';
    private $runningSemester = '';
    
    function __construct() 
    {
        parent::__construct();
        $this->load->database();
        $this->runningYear = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $this->runningSemester = $this->db->get_where('settings' , array('type' => 'running_semester'))->row()->description;
        $this->load->library('excel');
    }
    
    public function getAccountantInfo()
    {
        $info = $this->db->get_where('accountant', array('accountant_id' => $this->session->userdata('login_user_id')))->result_array();
        return $info;
    }
    
    public function checkPublicEmail()
    {
        if($_POST['c'] != "")
        {
            $credential = array('email' => html_escape($_POST['c']));
            $admin_query = $this->db->get_where('admin', $credential);
            if ($admin_query->num_rows() > 0) 
            {
                return 'success';
            }
            $teacher_query = $this->db->get_where('teacher', $credential);
            if ($teacher_query->num_rows() > 0) 
            {
              return 'success';
            }             
            $student_query = $this->db->get_where('student', $credential);
            if ($student_query->num_rows() > 0) 
            {
                return 'success';
            }
            $parent_query = $this->db->get_where('parent', $credential);
            if ($parent_query->num_rows() > 0) 
            {
                return 'success';                  
            } 
            $accountant_query = $this->db->get_where('accountant', $credential);
            if ($accountant_query->num_rows() > 0) 
            {
                return 'success';                  
            } 
            $librarian_query = $this->db->get_where('librarian', $credential);
            if ($librarian_query->num_rows() > 0) 
            {
                return 'success';                  
            }
            // $applicant_query = $this->db->get_where('applicant', $credential);
            // if ($applicant_query->num_rows() > 0) 
            // {
            //     return 'success';                  
            // } 
        }
    }
    
    public function createLibrarian()
    {
        $md5 = md5(date('d-m-Y H:i:s'));
        $data['first_name']   = html_escape($this->input->post('first_name'));
        $data['last_name']    = html_escape($this->input->post('last_name'));
        $data['address']      = html_escape($this->input->post('address'));
        $data['image']        = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
        $data['phone']        = html_escape($this->input->post('phone'));
        $data['gender']       = html_escape($this->input->post('gender'));
        $data['idcard']       = html_escape($this->input->post('idcard'));
        $data['email']        = html_escape($this->input->post('email'));
        $data['birthday']     = $this->input->post('datetimepicker');
        $data['since']        = $this->crud->getDateFormat();
        $data['username']     = html_escape($this->input->post('username'));
        $data['password']     = sha1($this->input->post('password'));
        $this->db->insert('librarian', $data);
        $teacher_id = $this->db->insert_id();

        $table      = 'librarian';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);

        move_uploaded_file($_FILES['userfile']['tmp_name'], 'public/uploads/librarian_image/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
    }
    
    public function updateLibrarian($librarianId)
    {
        $md5 = md5(date('d-m-y H:i:s'));
        $data['first_name']    = html_escape($this->input->post('first_name'));
        $data['last_name']     = html_escape($this->input->post('last_name'));
        $data['username']      = html_escape($this->input->post('username')); 
        $data['email']         = html_escape($this->input->post('email'));
        $data['gender']        = html_escape($this->input->post('gender'));
        $data['phone']         = html_escape($this->input->post('phone'));
        $data['idcard']        = html_escape($this->input->post('idcard'));
        $data['address']       = html_escape($this->input->post('address'));
        if($this->input->post('datetimepicker') != ''){
            $data['birthday']  = $this->input->post('datetimepicker');   
        }
        if($this->input->post('password') != ""){
            $data['password']  = sha1($this->input->post('password'));   
        }
        if($_FILES['userfile']['name'] != ""){
            $data['image']     = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
        }
        $this->db->where('librarian_id', $librarianId);
        $this->db->update('librarian', $data);
        move_uploaded_file($_FILES['userfile']['tmp_name'], 'public/uploads/librarian_image/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
    }
    
    public function deleteLibrarian($librarianId)
    {
        $data['status']   = 0;
        $this->db->where('librarian_id', $librarianId);
        $this->db->update('librarian', $data);
        // $this->db->delete('librarian');
    }
    
    public function createAccountant()
    {
        $md5 = md5(date('d-m-Y H:i:s'));
        $data['first_name']   = html_escape($this->input->post('first_name'));
        $data['last_name']    = html_escape($this->input->post('last_name'));
        $data['address']      = html_escape($this->input->post('address'));
        $data['image']        = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
        $data['phone']        = html_escape($this->input->post('phone'));
        $data['gender']       = html_escape($this->input->post('gender'));
        $data['idcard']       = html_escape($this->input->post('idcard'));
        $data['birthday']     = html_escape($this->input->post('datetimepicker'));
        $data['email']        = html_escape($this->input->post('email'));
        $data['since']        = $this->crud->getDateFormat();
        $data['username']     = html_escape($this->input->post('username'));
        $data['password']     = sha1($this->input->post('password'));
        $this->db->insert('accountant', $data);

        $table      = 'accountant';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);

        $teacher_id = $this->db->insert_id();
        move_uploaded_file($_FILES['userfile']['tmp_name'], 'public/uploads/accountant_image/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
    }
    
    public function updateAccountant($accountantId)
    {
        $md5 = md5(date('d-m-y H:i:s'));
        $data['first_name']   = html_escape($this->input->post('first_name'));
        $data['last_name']    = html_escape($this->input->post('last_name'));
        $data['username']     = html_escape($this->input->post('username'));
        $data['email']        = html_escape($this->input->post('email'));
        $data['gender']       = html_escape($this->input->post('gender'));
        $data['phone']        = html_escape($this->input->post('phone'));
        $data['idcard']       = html_escape($this->input->post('idcard'));
        $data['address']      = html_escape($this->input->post('address'));
        if($this->input->post('datetimepicker') != ''){
            $data['birthday'] = $this->input->post('datetimepicker');   
        }
        if($this->input->post('password') != ""){
            $data['password'] = sha1($this->input->post('password'));   
        }
        if($_FILES['userfile']['name'] != ""){
            $data['image']    = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
        }
        $this->db->where('accountant_id', $accountantId);
        $this->db->update('accountant', $data);
        move_uploaded_file($_FILES['userfile']['tmp_name'], 'public/uploads/accountant_image/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
    }
    
    public function deleteAccountant($accountantId)
    {
        $data['status']   = 0;
        $this->db->where('accountant_id', $accountantId);
        $this->db->update('accountant', $data);
        // $this->db->delete('accountant');
    }
    
    public function createAdmin()
    {
        $md5 = md5(date('d-m-y H:i:s'));
        $data['first_name']   = html_escape($this->input->post('first_name'));
        $data['last_name']    = html_escape($this->input->post('last_name'));
        $data['username']     = html_escape($this->input->post('username'));
        $data['password']     = sha1($this->input->post('password'));
        $data['email']        = html_escape($this->input->post('email'));
        $data['birthday']     = html_escape($this->input->post('datetimepicker'));
        $data['gender']       = html_escape($this->input->post('gender'));
        $data['phone']        = html_escape($this->input->post('phone'));
        $data['image']        = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
        $data['address']      = html_escape($this->input->post('address'));
        $data['since']        = $this->crud->getDateFormat();
        $data['owner_status'] = $this->input->post('owner_status');
        $this->db->insert('admin', $data);

        $table      = 'admin';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);

        move_uploaded_file($_FILES['userfile']['tmp_name'], 'public/uploads/admin_image/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
    }
    
    public function updateAdmin($adminId)
    {
        $md5 = md5(date('d-m-y H:i:s'));
        $data['first_name']   = html_escape($this->input->post('first_name'));
        $data['last_name']    = html_escape($this->input->post('last_name'));
        $data['username']     = html_escape($this->input->post('username'));
        $data['email']        = html_escape($this->input->post('email'));
        if($this->input->post('datetimepicker') != ""){
            $data['birthday'] = $this->input->post('datetimepicker');   
        }
        $data['gender']       = html_escape($this->input->post('gender'));
        $data['phone']        = html_escape($this->input->post('phone'));
        $data['address']      = html_escape($this->input->post('address'));
        if($this->input->post('password') != ""){
            $data['password'] = sha1($this->input->post('password'));   
        }
        if($_FILES['userfile']['size'] > 0){
            $data['image']    = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
        }
        if($this->input->post('datetimepicker') != ""){
            $data['birthday']     = $this->input->post('datetimepicker');   
        }
        if($this->input->post('profession') != ""){
            $data['profession']     = $this->input->post('profession');   
        }
        if($this->input->post('idcard') != ""){
            $data['idcard']     = $this->input->post('idcard');   
        }
        $data['owner_status'] = $this->input->post('owner_status');
        $this->db->where('admin_id', $adminId);
        $this->db->update('admin', $data);
        move_uploaded_file($_FILES['userfile']['tmp_name'], 'public/uploads/admin_image/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
    }
    
    public function deleteAdmin($adminId)
    {
        $data['status']   = 0;
        $this->db->where('admin_id', $adminId);
        $this->db->update('admin', $data);
    }

    public function acceptTeacher($teacherId)
    {
        $pending = $this->db->get_where('pending_users', array('user_id' => $teacherId))->result_array();
        foreach ($pending as $row) 
        {
            $data['first_name'] = $row['first_name'];
            $data['last_name']  = $row['last_name'];
            $data['email']      = $row['email'];
            $data['username']   = $row['username'];
            $data['sex']        = $row['sex'];
            $data['password']   = $row['password'];
            $data['phone']      = $row['phone'];
            $data['since']      = $row['since'];
            $this->db->insert('teacher', $data);

            $table      = 'teacher';
            $action     = 'insert';
            $insert_id  = $this->db->insert_id();
            $this->crud->save_log($table, $action, $insert_id, $data);

            $teacher_id = $this->db->insert_id();
            $this->mail->accountConfirm('teacher', $teacher_id);
        }
        $this->db->where('user_id', $teacherId);
        $this->db->delete('pending_users');
    }
    
    public function createTeacher()
    {
        $md5 = md5(date('d-m-y H:i:s'));
        $data['first_name']  = html_escape($this->input->post('first_name'));
        $data['last_name']   = html_escape($this->input->post('last_name'));
        $data['sex']         = html_escape($this->input->post('gender'));
        $data['email']       = html_escape($this->input->post('email'));
        $data['phone']       = html_escape($this->input->post('phone'));
        $data['idcard']      = html_escape($this->input->post('idcard'));
        $data['since']       = $this->crud->getDateFormat();
        $data['birthday']    = html_escape($this->input->post('datetimepicker'));
        $data['address']     = html_escape($this->input->post('address'));
        $data['username']    = html_escape($this->input->post('username'));
        if(!empty($_FILES['userfile']['tmp_name'])){
            $data['image']   = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
        }
        $data['password']    = sha1($this->input->post('password'));
        $this->db->insert('teacher', $data);

        $table      = 'teacher';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);

        move_uploaded_file($_FILES['userfile']['tmp_name'], 'public/uploads/teacher_image/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
    }
    
    public function updateTeacher($teacherId)
    {
        $md5 = md5(date('d-m-y H:i:s'));
        $data['first_name']   = $this->input->post('first_name');
        $data['last_name']    = $this->input->post('last_name');
        $data['email']        = $this->input->post('email');
        $data['phone']        = $this->input->post('phone');
        $data['idcard']       = $this->input->post('idcard');
        $data['address']      = $this->input->post('address');
        $data['username']     = $this->input->post('username');
        if($this->input->post('datetimepicker') != ''){
            $data['birthday'] = $this->input->post('datetimepicker');
        }
        if(!empty($_FILES['userfile']['tmp_name'])){
            $data['image']    = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
        }
        if($this->input->post('password') != ""){
            $data['password'] = sha1($this->input->post('password'));   
        }
        $this->db->where('teacher_id', $teacherId);
        $this->db->update('teacher', $data);
        move_uploaded_file($_FILES['userfile']['tmp_name'], 'public/uploads/teacher_image/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
    }
    
    public function deleteTeacher($teacherId)
    {
        $data['status']   = 0;
        $this->db->where('teacher_id', $teacherId);
        $this->db->update('teacher', $data);
        // $this->db->delete('teacher');
    }
    
    public function createParent()
    {
        $md5 = md5(date('d-m-y H:i:s'));
        $data['first_name']     = $this->input->post('first_name');
        $data['last_name']      = $this->input->post('last_name');
        $data['gender']         = $this->input->post('gender');
        $data['profession']     = $this->input->post('profession');
        $data['email']          = $this->input->post('email');
        $data['phone']          = $this->input->post('phone');
        $data['home_phone']     = $this->input->post('home_phone');
        $data['since']          = $this->crud->getDateFormat();
        $data['idcard']         = $this->input->post('idcard');
        $data['business']       = $this->input->post('business');
        $data['business_phone'] = $this->input->post('business_phone');
        $data['address']        = $this->input->post('address');
        $data['username']       = $this->input->post('username');
        $data['password']       = sha1($this->input->post('password'));
        $data['image']          = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
        $this->db->insert('parent', $data);

        $table      = 'parent';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);

        move_uploaded_file($_FILES['userfile']['tmp_name'], 'public/uploads/parent_image/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
    }
    
    public function updateParent($parentId)
    {
        if(!empty($_FILES['userfile']['tmp_name'])){
            $data['image']     = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
        }
        $data['first_name']      = $this->input->post('first_name');
        $data['last_name']       = $this->input->post('last_name');
        $data['gender']          = $this->input->post('gender');
        $data['profession']      = $this->input->post('profession');
        $data['email']           = $this->input->post('email');
        $data['phone']           = $this->input->post('phone');
        $data['home_phone']      = $this->input->post('home_phone');
        $data['idcard']          = $this->input->post('idcard');
        $data['business']        = $this->input->post('business');
        $data['business_phone']  = $this->input->post('business_phone');
        $data['address']         = $this->input->post('address');
        if($this->input->post('username') != ''){
            $data['username']        = $this->input->post('username');   
        }
        if($this->input->post('password') != ""){
            $data['password'] = sha1($this->input->post('password'));
        }
        $this->db->where('parent_id' , $parentId);
        $this->db->update('parent' , $data);
        move_uploaded_file($_FILES['userfile']['tmp_name'], 'public/uploads/parent_image/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
    }
    
    
    public function acceptParent($parentId)
    {
        $pending = $this->db->get_where('pending_users', array('user_id' => $parentId))->result_array();
        foreach ($pending as $row) 
        {
            $data['first_name']  = $row['first_name'];
            $data['last_name']   = $row['last_name'];
            $data['email']       = $row['email'];
            $data['username']    = $row['username'];
            $data['profession']  = $row['profession'];
            $data['since']       = $row['since'];
            $data['password']    = $row['password'];
            $data['phone']       = $row['phone'];
            $this->db->insert('parent', $data);

            $table      = 'parent';
            $action     = 'insert';
            $insert_id  = $this->db->insert_id();
            $this->crud->save_log($table, $action, $insert_id, $data);

            $parent_id = $this->db->insert_id();
            $this->mail->accountConfirm('parent', $parent_id);
        }
        $this->db->where('user_id', $parentId);
        $this->db->delete('pending_users');   
    }
    
    public function deleteParent($parentId)
    {
        $data['status']   = 0;
        $this->db->where('parent_id' , $parentId);
        $this->db->update('parent', $data);
        // $this->db->delete('parent');
    }
    
    public function updateCurrentAdmin()
    {
        $data['first_name']   = $this->input->post('first_name');
        $data['last_name']    = $this->input->post('last_name');
        $data['username']     = $this->input->post('username');
        $data['email']        = $this->input->post('email');
        $data['profession']   = $this->input->post('profession');
        $data['idcard']       = $this->input->post('idcard');
        if($this->input->post('datetimepicker') != ""){
            $data['birthday'] = $this->input->post('datetimepicker');   
        }
        if(!empty($_FILES['userfile']['tmp_name'])){
            $data['image']    = md5(date('d-m-y H:i:s')).str_replace(' ', '', $_FILES['userfile']['name']);
        }
        $data['gender']       = $this->input->post('gender');
        $data['phone']        = $this->input->post('phone');
        $data['address']      = $this->input->post('address');
        if($this->input->post('password') != ""){
            $data['password'] = sha1($this->input->post('password'));   
        }
        $this->db->where('admin_id', $this->session->userdata('login_user_id'));
        $this->db->update('admin', $data);
        move_uploaded_file($_FILES['userfile']['tmp_name'], 'public/uploads/admin_image/' . md5(date('d-m-y H:i:s')).str_replace(' ', '', $_FILES['userfile']['name']));
    }
    
    public function removeGoogle()
    {
        $data['g_oauth'] = "";
        $data['g_fname'] = "";
        $data['g_lname'] = "";
        $data['g_picture'] = "";
        $data['link'] = "";
        $data['g_email'] = "";  
        $this->db->where($this->session->userdata('login_type').'_id', $this->session->userdata('login_user_id'));
        $this->db->update($this->session->userdata('login_type'), $data);
        unset($_SESSION['token']);
        unset($_SESSION['userData']);
        $this->crud->googleRevokeToken();
    }
    
    public function removeFacebook()
    {
        $data['fb_token']   =  "";
        $data['fb_id']      =  "";
        $data['fb_photo']   =  "";
        $data['fb_name']    =  "";
        $data['femail']     = "";
        unset($_SESSION['access_token']);
        unset($_SESSION['userData']);
        $this->db->where($this->session->userdata('login_type').'_id', $this->session->userdata('login_user_id'));
        $this->db->update($this->session->userdata('login_type'), $data);
    }
    
    public function rejectStudent($studentId)
    {
        $this->db->where('user_id', $studentId);
        $this->db->delete('pending_users');
    }
    
    public function studentAdmission($p_year = '', $p_semesterId = '')
    {
        $year       =   $p_year         == '' ? $this->runningYear      : $p_year;
        $semesterId =   $p_semesterId   == '' ? $this->runningSemester  : $p_semesterId;
        $quantity_score = intval($this->academic->getInfo('ap_quantity_score'));
        $applicant_id = $this->input->post('applicant_id');

        $bytes = random_bytes(20);
        $password_token = bin2hex($bytes);

        $user_name  = $this->crud->get_name('admin', $this->session->userdata('login_user_id'));

        //Generate the student_code if is blank
        $student_code = $this->input->post('student_code');
        if(empty($student_code)){
            $student_code = 'L'.sprintf('%08d', rand()).$this->runningYear;
        }

        $md5 = md5(date('d-m-Y H:i:s'));
        $data['first_name']        = $this->input->post('first_name');
        $data['last_name']         = $this->input->post('last_name');
        $data['birthday']          = $this->input->post('datetimepicker');
        $data['username']          = $this->input->post('username');
        $data['student_code']      = $student_code;
        $data['student_session']   = 1;
        $data['email']             = $this->input->post('email');
        $data['since']             = $this->crud->getDateFormat();
        $data['phone']             = $this->input->post('phone');
        $data['sex']               = $this->input->post('gender');
        // $data['password']          = "NO_CONFIRM";// sha1($this->input->post('password'));
        $data['password']          = sha1($this->input->post('password'));
        $data['password_token']    = $password_token;
        $data['address']           = $this->input->post('address');
        $data['country_id']        = $this->input->post('country_id');
        $data['transport_id']      = $this->input->post('transport_id');
        $data['program_id']        = $this->input->post('program_id');
        $data['created_by']        = $this->session->userdata('login_user_id');

        if($_FILES['userfile']['name'] != ''){
            $data['image']             = $md5.str_replace(' ', '', $_FILES['userfile']['name']);   
        }

        if($this->input->post('account') != '1'){
            $data['parent_id']        = $this->input->post('parent_id');    
        } 
        else if($this->input->post('account') == '1'){
            $data3['first_name']      = $this->input->post('parent_first_name');
            $data3['last_name']       = $this->input->post('parent_last_name');
            $data3['gender']          = $this->input->post('parent_gender');
            $data3['profession']      = $this->input->post('parent_profession');
            $data3['email']           = $this->input->post('parent_email');
            $data3['phone']           = $this->input->post('parent_phone');
            $data3['home_phone']      = $this->input->post('parent_home_phone');
            $data3['idcard']          = $this->input->post('parent_idcard');
            $data3['business']        = $this->input->post('parent_business');
            $data3['since']           = $this->crud->getDateFormat();
            $data3['business_phone']  = $this->input->post('parent_business_phone');
            $data3['address']         = $this->input->post('parent_address');
            $data3['username']        = $this->input->post('parent_username');
            $data3['password']        = sha1($this->input->post('parent_password'));
            $data3['image']           = "";
            $this->db->insert('parent', $data3);

            $table      = 'parent';
            $action     = 'insert';
            $insert_id  = $this->db->insert_id();
            $this->crud->save_log($table, $action, $insert_id, $data3);

            $parent_id = $this->db->insert_id();
            $data['parent_id']        = $parent_id;    
        }

        $data['diseases']          = $this->input->post('diseases');
        $data['allergies']         = $this->input->post('allergies');
        $data['doctor']            = $this->input->post('doctor');
        $data['doctor_phone']      = $this->input->post('doctor_phone');
        $data['authorized_person'] = $this->input->post('auth_person');
        $data['authorized_phone']  = $this->input->post('auth_phone');
        $data['note']              = $this->input->post('note');

        if(!empty($this->input->post('referral_by')))
            $data['referral_by']  = html_escape($this->input->post('referral_by'));
        
        if($applicant_id > 0)
            $data['applicant_id']  = $applicant_id;

        $this->db->insert('student', $data);

        $table      = 'student';
        $action     = 'insert';
        $student_id = $this->db->insert_id();
        $this->crud->save_log($table, $action, $student_id, $data);

        // Enroll
        $data4['student_id']       = $student_id;
        $data4['enroll_code']      = substr(md5(rand(0, 1000000)), 0, 7);
        $data4['class_id']         = $this->input->post('class_id');

        if ($this->input->post('section_id') != '') {
            $data4['section_id']   = $this->input->post('section_id');
        }
        
        $data4['roll']             = $this->input->post('student_code');
        $data4['date_added']       = strtotime(date("Y-m-d H:i:s"));
        $data4['year']             = $year;
        $data4['semester_id']      = $semesterId;

        $subjects = $this->input->post('subject_id');

        foreach ( $subjects as $key )  
        {
            $data4['subject_id']     = $key;
            
            $table      = 'student';
            $action     = 'insert';            
            $enroll_id  = $this->db->insert( 'enroll', $data4 );
            $this->crud->save_log($table, $action, $enroll_id, $data);
        }

        //Register the Placement Test
        $data5['type_test']     = 1;
        $data5['student_id']    = $student_id;
        $data5['year']          = $year;
        $data5['semester_id']   = $semesterId;
        $data5['comment']       = $this->input->post('comment_placement');        

        for ($i=1; $i <= $quantity_score; $i++) {
            $name = 'score'.$i;
            $data5[$name] = $this->input->post($name);
        }

        $this->db->insert( 'pa_test', $data5 );

        move_uploaded_file($_FILES['userfile']['tmp_name'], PATH_STUDENT_IMAGE . $md5.str_replace(' ', '', $_FILES['userfile']['name']));

        // Send Email of Confirmation
        // $this->mail->accountConfirm('student', $student_id);

        // Update the Applicant status
        if($applicant_id > 0)
        {
            $this->applicant->update_status($applicant_id, 3);

            //Create a automatic interaction            
            $_POST['comment']       = $user_name.' convert the applicant to student.';
            $this->studentModel->add_interaction($student_id, 'automatic');
        }
        else
        {
            //Create a automatic interaction            
            $_POST['comment']       = $user_name.' register this student.';
            $this->studentModel->add_interaction($student_id, 'automatic');
        }
        
        return $student_id;
    }
    
    public function acceptStudent($studentId)
    {
        $pending = $this->db->get_where('pending_users', array('user_id' => $studentId))->result_array();
        foreach ($pending as $row) 
        {
            $data['first_name']    = $row['first_name'];
            $data['last_name']     = $row['last_name'];
            $data['email']         = $row['email'];
            $data['username']      = $row['username'];
            $data['sex']           = $row['sex'];
            $data['password']      = $row['password'];
            $data['birthday']      = $row['birthday'];
            $data['phone']         = $row['phone'];
            $data['since']         = $row['since'];
            $data['date']          = $this->crud->getDateFormat();
            $this->db->insert('student', $data);
            $student_id            = $this->db->insert_id();

            $data2['student_id']   = $student_id;
            $data2['enroll_code']  = substr(md5(rand(0, 1000000)), 0, 7);
            $data2['class_id']     = $row['class_id'];
            $data2['section_id']   = $row['section_id'];
            $data2['roll']         = $row['roll'];
            $data2['date_added']   = strtotime(date("Y-m-d H:i:s"));
            $data2['year']         = $this->runningYear;
            $this->db->insert('enroll', $data2);

            $table      = 'enroll';
            $action     = 'insert';
            $insert_id  = $this->db->insert_id();
            $this->crud->save_log($table, $action, $insert_id, $data2);
            
            $this->mail->accountConfirm('student', $student_id);
        }
        $this->db->where('user_id', $studentId);
        $this->db->delete('pending_users');
    }
    
    public function bulkStudents()
    {
        $path   = $_FILES["upload_student"]["tmp_name"];
        $object = PHPExcel_IOFactory::load($path);
        foreach($object->getWorksheetIterator() as $worksheet)
        {
           $highestRow = $worksheet->getHighestRow();
           $highestColumn = $worksheet->getHighestColumn();
           for($row=2; $row <= $highestRow; $row++)
           {                     
                $data['first_name']    =  $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                $data['last_name']     =  $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                $data['email']         =  $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                $data['phone']         =  $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                $data['sex']           =  $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                $data['username']      =  $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                $data['password']      =  sha1($worksheet->getCellByColumnAndRow(6, $row)->getValue());
                $data['address']       =  $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                $data['since']         =  $this->crud->getDateFormat();
                if($data['first_name'] != "")
                {
                    $this->db->insert('student', $data);

                    $table      = 'student';
                    $action     = 'insert';
                    $insert_id  = $this->db->insert_id();
                    $this->crud->save_log($table, $action, $insert_id, $data);

                    $student_id = $this->db->insert_id();
                    $data2['enroll_code']   =   substr(md5(rand(0, 1000000)), 0, 7);
                    $data2['student_id']    =   $student_id;
                    $data2['class_id']      =   $this->input->post('class_id');
                    if($this->input->post('section_id') != '') 
                    {
                        $data2['section_id']    =   $this->input->post('section_id');
                    }
                    $data2['roll']          =   $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                    $data2['date_added']    =   strtotime(date("Y-m-d H:i:s"));
                    $data2['year']          =   $this->runningYear;
                    $this->db->insert('enroll' , $data2);

                    $table      = 'enroll';
                    $action     = 'insert';
                    $insert_id  = $this->db->insert_id();
                    $this->crud->save_log($table, $action, $insert_id, $data2);

                }
           }
        }
    }
    
    public function updateStudent($studentId)
    {
        $md5 = md5(date('d-m-Y H:i:s'));
        $data['first_name']      = $this->input->post('first_name');
        $data['last_name']       = $this->input->post('last_name');
        $data['birthday']        = $this->input->post('datetimepicker');
        $data['email']           = $this->input->post('email');
        $data['phone']           = $this->input->post('phone');
        $data['sex']             = $this->input->post('gender');
        $data['username']        = $this->input->post('username');
        $data['student_code']    = $this->input->post('student_code');
        $data['country_id']      = $this->input->post('country_id');
        if($this->input->post('password') != "")
        {
           $data['password'] = sha1($this->input->post('password'));
        }
        $data['address']           = $this->input->post('address');
        $data['transport_id']      = $this->input->post('transport_id');
        $data['program_id']        = $this->input->post('program_id');
        $data['diseases']          = $this->input->post('diseases');
        $data['allergies']         = $this->input->post('allergies');
        $data['doctor']            = $this->input->post('doctor');
        $data['doctor_phone']      = $this->input->post('doctor_phone');
        $data['authorized_person'] = $this->input->post('auth_person');
        $data['authorized_phone']  = $this->input->post('auth_phone');
        $data['note']    = $this->input->post('note');
        if($_FILES['userfile']['size'] > 0){
            $data['image']         = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
        }
        $data['parent_id']         = $this->input->post('parent_id');
        $data['student_session']   = $this->input->post('student_session');
        $data['updated_by']        = $this->session->userdata('login_user_id');

        $this->db->where('student_id', $studentId);
        $this->db->update('student', $data);

        // $data2['roll']             = $this->input->post('roll');
        // $data2['class_id']         = $this->input->post('class_id');
        // $data2['section_id']       = $this->input->post('section_id');
        // $this->db->where('student_id', $studentId);
        // $this->db->update('enroll', $data2);
        move_uploaded_file($_FILES['userfile']['tmp_name'], PATH_STUDENT_IMAGE . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
    }
    
    public function updateCurrentStudent()
    {
        $md5 = md5(date('d-m-Y H:i:s'));
        $data['email'] = $this->input->post('email');
        $data['phone'] = $this->input->post('phone');
        $data['address'] = $this->input->post('address');
        $data['sex'] = $this->input->post('gender');
        $data['birthday'] = $this->input->post('datetimepicker');
        if($this->input->post('password') != "")
        {
            $data['password'] = sha1($this->input->post('password'));
        }
        if($_FILES['userfile']['size'] > 0){
            $data['image']     = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
        }
        $this->db->where('student_id', $this->session->userdata('login_user_id'));
        $this->db->update('student', $data);

        move_uploaded_file($_FILES['userfile']['tmp_name'], PATH_STUDENT_IMAGE . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
    }

    public function updateAvatar($table){
        $user_id = $this->session->userdata('login_user_id');
        if(isset($_POST["image"]))
        {
            $md5        = md5(date('d-m-Y H:i:s'));
            $image_name = $md5.str_replace(' ', '', $user_id).'png';

            $data = $_POST["image"];
            $image_array_1 = explode(";", $data);
            $image_array_2 = explode(",", $image_array_1[1]);

            $data = base64_decode($image_array_2[1]);

            $destination = 'public/uploads/'.$table.'_image/' . $image_name;

            $data_update['image'] = $image_name;
            $this->db->where($table.'_id', $user_id);
            $this->db->update($table, $data_update);

            file_put_contents($destination, $data);
        }
    }
    
    public function updateModalStudent($studentId)
    {
        $md5 = md5(date('d-m-Y H:i:s'));
        $data['first_name']      = $this->input->post('first_name');
        $data['last_name']       = $this->input->post('last_name');
        $data['username']        = $this->input->post('username');
        $data['phone']           = $this->input->post('phone');
        $data['address']         = $this->input->post('address');
        $data['parent_id']       = $this->input->post('parent_id');
        $data['student_session'] = $this->input->post('student_session');
        $data['email']           = $this->input->post('email');
        if($_FILES['userfile']['size'] > 0){
            $data['image']     = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
        }
        if($this->input->post('password') != "")
        {
           $data['password'] = sha1($this->input->post('password'));
        }
        $this->db->where('student_id', $studentId);
        $this->db->update('student', $data);
        move_uploaded_file($_FILES['userfile']['tmp_name'], PATH_STUDENT_IMAGE . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
    }
    
    public function downloadExcel()
    {
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', getPhrase('first_name'));
        $objPHPExcel->getActiveSheet()->setCellValue('B1', getPhrase('last_name'));
        $objPHPExcel->getActiveSheet()->setCellValue('C1', getPhrase('username'));
        $objPHPExcel->getActiveSheet()->setCellValue('D1', getPhrase('email'));
        $objPHPExcel->getActiveSheet()->setCellValue('E1', getPhrase('phone'));
        $objPHPExcel->getActiveSheet()->setCellValue('F1', getPhrase('gender'));
        $objPHPExcel->getActiveSheet()->setCellValue('G1', getPhrase('class'));
        $objPHPExcel->getActiveSheet()->setCellValue('H1', getPhrase('section'));
        $objPHPExcel->getActiveSheet()->setCellValue('I1', getPhrase('parent'));

        $a = 2; $b =2; $c =2; $d =2; $e =2; $f = 2;$g = 2;$h=2; $i = 2;

        $query = $this->db->get_where('enroll', array('class_id' => $this->input->post('class_id'), 'section_id' => $this->input->post('section_id'), 'year' => $this->runningYear))->result_array();
        foreach($query as $row)
        {
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a++, $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->first_name);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$b++, $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->last_name);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$c++, $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->username);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$d++, $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->email);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$e++, $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->phone);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$f++, $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->sex);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$g++, $this->db->get_where('class', array('class_id' => $row['class_id']))->row()->name);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$h++, $this->db->get_where('section', array('section_id' => $row['section_id']))->row()->name);
            $parent_id = $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->parent_id;
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$i++, $this->crud->get_name('parent',$parent_id));
        }
        $objPHPExcel->getActiveSheet()->setTitle(getPhrase('students'));
    
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="export_students_'.date('d-m-y:h:i:s').'.xlsx"');
        header("Content-Transfer-Encoding: binary ");
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        $objWriter->setOffice2003Compatibility(true);
        $objWriter->save('php://output');
    }
    
    public function updateCurrentAccountant()
    {
        $md5 = md5(date('d-m-y H:i:s'));
        $data['email']        = $this->input->post('email');
        $data['idcard']       = $this->input->post('idcard');
        $data['phone']        = $this->input->post('phone');
        $data['address']      = $this->input->post('address');
        if($this->input->post('password') != ""){
            $data['password'] = sha1($this->input->post('password'));   
        }
        if($_FILES['userfile']['name'] != ""){
            $data['image']    = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
        }
        $this->db->where('accountant_id', $this->session->userdata('login_user_id'));
        $this->db->update('accountant', $data);
        move_uploaded_file($_FILES['userfile']['tmp_name'], 'public/uploads/accountant_image/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
    }
    
    public function updateCurrentLibrarian()
    {
        $md5 = md5(date('d-m-y H:i:s'));
        $data['email']        = $this->input->post('email');
        $data['idcard']       = $this->input->post('idcard');
        $data['phone']        = $this->input->post('phone');
        $data['address']      = $this->input->post('address');
        if($this->input->post('password') != ""){
            $data['password'] = sha1($this->input->post('password'));   
        }
        if($_FILES['userfile']['name'] != ""){
            $data['image']    = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
        }
        $this->db->where('librarian_id', $this->session->userdata('login_user_id'));
        $this->db->update('librarian', $data);
        move_uploaded_file($_FILES['userfile']['tmp_name'], 'public/uploads/librarian_image/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
    }
    
    public function createPublicTeacherAccount()
    {
        $data['first_name']        = $this->input->post('first_name');
        $data['last_name']        = $this->input->post('last_name');
        $data['since']     = $this->crud->getDateFormat();
        $data['username']    = $this->input->post('username');
        $data['phone']       = $this->input->post('phone');
        $data['email']        = $this->input->post('email');
        $data['sex']       = $this->input->post('sex');
        $data['birthday']    = $this->input->post('birthday');
        $data['type']    = "teacher";
        $data['password']    = sha1($this->input->post('password'));
        $this->db->insert('pending_users', $data);

        $table      = 'pending_users';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);

        $user_id = $this->db->insert_id();
        $this->mail->welcomeUser($user_id);

        $notify['notify'] = "<strong>".getPhrase('register').":</strong>,". " ". getPhrase('reg_teacher') ."<b>".$this->input->post('name')."</b>";
        $admins = $this->db->get('admin')->result_array();
        foreach($admins as $row)
        {
            $notify['user_id'] = $row['admin_id'];
            $notify['user_type'] = 'admin';
            $notify['url'] = "admin/pending/";
            $notify['date'] = $this->crud->getDateFormat();
            $notify['time'] = date('h:i A');
            $notify['status'] = 0;
            $notify['original_id'] = "";
            $notify['original_type'] = "";
            $this->db->insert('notification', $notify);

            $table      = 'notification';
            $action     = 'insert';
            $insert_id  = $this->db->insert_id();
            $this->crud->save_log($table, $action, $insert_id, $notify);

        }
    }
    
    public function createPublicStudentAccount()
    {
        $data['class_id']    = $this->input->post('class_id');
        $data['section_id']  = $this->input->post('section_id');
        $data['parent_id']   = $this->input->post('parent_id');
        $data['first_name']        = $this->input->post('first_name');
        $data['last_name']        = $this->input->post('last_name');
        $data['since']     = $this->crud->getDateFormat();
        $data['username']    = $this->input->post('username');
        $data['phone']       = $this->input->post('phone');
        $data['email']        = $this->input->post('email');
        $data['sex']         = $this->input->post('sex');
        $data['birthday']    = $this->input->post('birthday');
        $data['roll']        = $this->input->post('roll');
        $data['type']        = "student";
        $data['password']    = sha1($this->input->post('password'));
        $this->db->insert('pending_users', $data);

        $table      = 'pending_users';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);

        $user_id = $this->db->insert_id();
        $this->mail->welcomeUser($user_id);

         $notify['notify'] = "<strong>".getPhrase('register').":</strong>,". " ". getPhrase('reg_student')."<b>".$this->input->post('name')."</b>";
        $admins = $this->db->get('admin')->result_array();
        foreach($admins as $row)
        {
            $notify['user_id'] = $row['admin_id'];
            $notify['user_type'] = 'admin';
            $notify['url'] = "admin/pending/";
            $notify['date'] = $this->crud->getDateFormat();
            $notify['time'] = date('h:i A');
            $notify['status'] = 0;
            $notify['original_id'] = "";
            $notify['original_type'] = "";
            $this->db->insert('notification', $notify);

            $table      = 'notification';
            $action     = 'insert';
            $insert_id  = $this->db->insert_id();
            $this->crud->save_log($table, $action, $insert_id, $notify);

        }

    }
    
    public function createPublicParentAccount()
    {
        $data['first_name']        = $this->input->post('first_name');
        $data['last_name']        = $this->input->post('last_name');
        $data['email']        = $this->input->post('email');
        $data['since']     = $this->crud->getDateFormat();
        $data['username']    = $this->input->post('username');
        $data['phone']       = $this->input->post('phone');
        $data['profession']    = $this->input->post('profession');
        $data['type']        = "parent";
        $data['password']    = sha1($this->input->post('password'));
        $this->db->insert('pending_users', $data);

        $table      = 'pending_users';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);
        
        $user_id = $this->db->insert_id();
        $this->mail->welcomeUser($user_id);

        $notify['notify'] = "<strong>".getPhrase('register').":</strong>,". " ". getPhrase('reg_parent')."<b>".$this->input->post('name')."</b>";
        $admins = $this->db->get('admin')->result_array();
        foreach($admins as $row)
        {
            $notify['user_id'] = $row['admin_id'];
            $notify['user_type'] = 'admin';
            $notify['url'] = "admin/pending/";
            $notify['date'] = $this->crud->getDateFormat();
            $notify['time'] = date('h:i A');
            $notify['status'] = 0;
            $notify['original_id'] = "";
            $notify['original_type'] = "";
            $this->db->insert('notification', $notify);

            $table      = 'notification';
            $action     = 'insert';
            $insert_id  = $this->db->insert_id();
            $this->crud->save_log($table, $action, $insert_id, $notify);
            
        }
    }
    
    public function updateCurrentTeacher()
    {
        $md5 = md5(date('d-m-y H:i:s'));
        $data['email']          = $this->input->post('email');
        $data['phone']          = $this->input->post('phone');
        $data['idcard']         = $this->input->post('idcard');
        $data['birthday']       = $this->input->post('birthday');
        $data['address']        = $this->input->post('address');
        $data['username']       = $this->input->post('username');
        if($_FILES['userfile']['name'] != ""){
            $data['image']      = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
        }
        if($this->input->post('password') != ""){
         $data['password']      = sha1($this->input->post('password'));   
        }
        $this->db->where('teacher_id', $this->session->userdata('login_user_id'));
        $this->db->update('teacher', $data);
        move_uploaded_file($_FILES['userfile']['tmp_name'], 'public/uploads/teacher_image/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
    }

    public function updatePasswordUser($table, $password, $user_id){
        
        $data_update['password'] = $password;
        $data_update['password_token'] = null;

        if($table == 'student'){
            $data_update['email_validated'] = 1;
        }

        $this->db->where($table.'_id', $user_id);
        $this->db->update($table, $data_update);
    }

    function add_interaction()
    {
        $md5 = md5(date('d-m-Y H:i:s'));

        $data['created_by'] = $this->session->userdata('login_user_id');
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

    function get_advisor()
    {
        $this->db->reset_query();
        $this->db->select('admin_id, first_name, last_name');
        $this->db->where('status', '1');
        $this->db->where('owner_status', '3');
        $this->db->order_by('first_name');
        $query = $this->db->get('admin')->result_array();        
        return $query;        
    }

}