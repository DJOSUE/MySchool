<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Notification extends School 
{
    // private $runningYear = '';
    // private $runningSemester = '';
    
    function __construct() 
    {
        parent::__construct();
        $this->load->database();
        // $this->load->library('excel');
        
        // $this->runningYear      = $this->crud->getInfo('running_year'); 
        // $this->runningSemester  = $this->crud->getInfo('running_semester');
    }

    function create($message_code, $user_id, $user_type, $url_encode)
    {
        $original_id = get_login_user_id();
        $original_type = get_account_type();
        $user_name = $this->crud->get_name($original_type, $original_id);
        $url = base64_decode($url_encode);

        $notify['notify']        = "<strong>". $user_name ."</strong>". ".". getPhrase($message_code);
        $notify['user_id']       = $user_id;
        $notify['user_type']     = $user_type;
        $notify['url']           = $url;
        $notify['date']          = $this->crud->getDateFormat();
        $notify['time']          = date('h:i A');
        $notify['status']        = 0;
        $notify['original_id']   = $original_id;
        $notify['original_type'] = $original_type;
        $this->db->insert('notification', $notify);
        
        $table      = 'notification';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $notify);
    }

    function teacher_student_request($message_code, $student_name, $user_id, $user_type, $start_date, $end_date)
    {
        $original_id = get_login_user_id();
        $original_type = get_account_type();

        $user_name = $this->crud->get_name($original_type, $original_id);
        // $url = base64_decode($url_encode);

        $notify['notify']        = "<strong>". $user_name ."</strong>". " ". getPhrase($message_code). " ".$student_name." <br/> From: ". $start_date . " <br/> To: " . $end_date;
        $notify['user_id']       = $user_id;
        $notify['user_type']     = $user_type;
        $notify['date']          = $this->crud->getDateFormat();
        $notify['time']          = date('h:i A');
        $notify['status']        = 0;
        $notify['original_id']   = $original_id;
        $notify['original_type'] = $original_type;
        $this->db->insert('notification', $notify);
        
        $table      = 'notification';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $notify);
    }

    function update($notification_id, $status)
    {
        $notify['status'] = $status;
        $this->db->where('id', $notification_id);
        $this->db->update('notification', $notify);

        $table      = 'notification';
        $action     = 'update';
        $update_id  = html_escape($_GET['id']);
        $this->crud->save_log($table, $action, $update_id, $notify);
    }

    function delete($notify_id, $deleteAll = false)
    {
       
        if(!$deleteAll)
        {   
            $this->db->where('id', $notify_id);
            $this->db->set('status', '2', FALSE);
            $this->db->update('notification');
            
            $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted')); 
        }
        else
        {
            $user_id    = get_login_user_id();
            $user_type  = get_table_user(get_role_id());

            $this->db->where('user_id', $user_id);
            $this->db->where('user_type', $user_type);
            $this->db->set('status', '2');
            $this->db->update('notification');

            $this->session->set_flashdata('flash_message' , getPhrase('successfully_deleted'));   
        }
    }

    function create_email($message_code, $user_id, $user_type, $url_encode)
    {
        $user_id = get_login_user_id();
        $user_type = get_account_type();
        $user_name = $this->crud->get_name($user_type, $user_id);
        $url = base64_decode($url_encode);

        $notify['notify']     = "<strong>". $user_name ."</strong>". " ". getPhrase($message_code);
        $notify['user_id']    = $user_id;
        $notify['user_type']  = $user_type;
        $notify['url']        = $url;
        $notify['date'] = $this->crud->getDateFormat();
        $notify['time'] = date('h:i A');
        $notify['status'] = 0;
        $notify['original_id'] = $user_id;
        $notify['original_type'] = $user_type;
        $this->db->insert('notification', $notify);
        
        $table      = 'notification';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $notify);
    }
}