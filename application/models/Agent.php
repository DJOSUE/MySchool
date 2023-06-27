<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Agent extends School 
{    
    private $runningYear = '';
    private $runningSemester = '';
    
    function __construct() 
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->runningYear = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $this->runningSemester = $this->db->get_where('settings' , array('type' => 'running_semester'))->row()->description;
        $this->load->library('excel');
    }

    public function payment_reminder()
    {
        $due_date = date('Y-m-d'); // '2023-04-13';
        $this->db->reset_query();
        $this->db->select('agreement_id, MAX(due_date) due_date');
        $this->db->where('DATE_ADD(due_date, INTERVAL -2 DAY) =', $due_date);
        $this->db->where_in('status_id', array(DEFAULT_AMORTIZATION_PENDING, DEFAULT_AMORTIZATION_PARTIAL));
        $this->db->group_by('agreement_id');
        $agreement_ids = $this->db->get('agreement_amortization')->result_array();

        // echo '<pre>';
        // var_dump($agreement_ids);
        // echo '</pre>';

        $array = [];
        foreach($agreement_ids as  $value){
            array_push($array, $value['agreement_id']);
        }
        
        if(count($array) > 0)
        {
            $this->db->reset_query();
            $this->db->where_in('agreement_id', $array);
            $agreements = $this->db->get('v_agreement')->result_array();            

            foreach ($agreements as $item) {
                $user_name = $item['last_name'].', '.$item['first_name'];
                $user_email = $item['email'];
                $student_id = $item['student_id'];                
                
                $this->studentModel->update_student_collection_profile($student_id, DEFAULT_COLLECTION_ID_REMINDER);
                $this->mail->payment_reminder($user_name, $user_email, 'payment_reminder');                
            }
        }
    }

    public function late_payment_reminder()
    {
        $date = date('Y-m-d');
        $date = '2023-04-04';
        $due_date = date('Y-m-d', strtotime($date. ' - 3 days'));

        $this->db->reset_query();
        $this->db->select('agreement_id, MAX(due_date) due_date');
        $this->db->where('DATE_ADD(due_date, INTERVAL -2 DAY) =', $due_date);
        $this->db->where_in('status_id', array(DEFAULT_AMORTIZATION_PENDING, DEFAULT_AMORTIZATION_PARTIAL));
        $this->db->group_by('agreement_id');
        $agreement_ids = $this->db->get('agreement_amortization')->result_array();        

        $array = [];
        foreach($agreement_ids as  $value){
            array_push($array, $value['agreement_id']);
        }
        
        if(count($array) > 0)
        {
            $this->db->reset_query();
            $this->db->where_in('agreement_id', $array);
            $agreements = $this->db->get('v_agreement')->result_array();
    
            foreach ($agreements as $item) {
                $user_name = $item['last_name'].', '.$item['first_name'];
                $user_email = $item['email'];
                $student_id = $item['student_id'];
                
                $this->studentModel->update_student_collection_profile($student_id, DEFAULT_COLLECTION_ID_LATE);
                $this->mail->payment_reminder($user_name, $user_email, 'late_payment_reminder');
            }
        }


    }

    public function update_student_status()
    {
        // Get all students on status Active or vacation
        $this->db->reset_query();        
        $this->db->where_in('status_id', array(DEFAULT_STUDENT__STATUS_ENROLLED, DEFAULT_STUDENT__STATUS_VACATION));
        $students = $this->db->get('student')->result_array();

        
        
    }
    
}
