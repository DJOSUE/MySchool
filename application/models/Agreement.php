<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Agreement extends School 
{
    private $runningYear = '';
    private $runningSemester = '';
    
    function __construct() 
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('excel');
        
        $this->runningYear      = $this->crud->getInfo('running_year'); 
        $this->runningSemester  = $this->crud->getInfo('running_semester');
    }

    public function get_modality()
    {
        $this->db->reset_query();
        $this->db->select('code as modality_id, name, value_1 as color, value_2 as icon');
        $this->db->where('parameter_id', 'MODALITY');
        $query = $this->db->get('parameters')->result_array();;
        
        return $query;
    }
    
    public function get_modality_info($modality_id)
    {
        $this->db->reset_query();
        $this->db->select('code as modality_id, name, value_1 as color, value_2 as icon');
        $this->db->where('parameter_id', 'MODALITY');
        $this->db->where('code', $modality_id);
        $query = $this->db->get('parameters')->row_array();
        
        return $query;
    }

    public function get_modality_name($modality_id)
    {
        $this->db->reset_query();
        $this->db->select('name');
        $this->db->where('parameter_id', 'MODALITY');
        $this->db->where('code', $modality_id);
        $query = $this->db->get('parameters')->row()->name;
        
        return $query;
    }

    public function get_program_type()
    {
        $this->db->reset_query();
        $this->db->select('code as program_type_id, name, value_1 as price, value_2 as icon');
        $this->db->where('parameter_id', 'PROGRAM_TYPE');
        $query = $this->db->get('parameters')->result_array();;
        
        return $query;
    }
    
    public function get_program_type_info($program_type_id)
    {
        $this->db->reset_query();
        $this->db->select('code as program_type_id, name, value_1 as price, value_2 as icon');
        $this->db->where('parameter_id', 'PROGRAM_TYPE');
        $this->db->where('code', $program_type_id);
        $query = $this->db->get('parameters')->row_array();
        
        return $query;
    }

    public function get_program_type_name($program_type_id)
    {
        $this->db->reset_query();
        $this->db->select('name');
        $this->db->where('parameter_id', 'PROGRAM_TYPE');
        $this->db->where('code', $program_type_id);
        $query = $this->db->get('parameters')->row()->name;
        
        return $query;
    }

    public function create_agreement()
    {
        $md5 = md5(date('d-m-y H:i:s'));

        $data['agreement_date']     = html_escape($this->input->post('agreement_date'));
        $data['student_id']         = html_escape($this->input->post('student_id'));
        $data['tuition']            = html_escape($this->input->post('tuition'));
        $data['scholarship']        = html_escape($this->input->post('scholarship'));
        $data['discounts']          = html_escape($this->input->post('discounts'));
        $data['materials']          = html_escape($this->input->post('materials'));
        $data['fees']               = html_escape($this->input->post('fees'));
        $data['modality_id']        = html_escape($this->input->post('modality_id'));
        $data['book_type']          = html_escape($this->input->post('book_type'));
        $data['program_type_id']    = html_escape($this->input->post('program_type_id'));
        $data['number_payments']    = html_escape($this->input->post('number_payments'));
        $data['created_by']         = $this->session->userdata('login_user_id');

        $this->db->insert('agreement', $data);

        $table      = 'agreement';
        $action     = 'insert';
        $agreement_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $agreement_id, $data);

        $number_payments = $data['number_payments'];

        $data['agreement_id']     = $agreement_id;

        for ($i=1; $i <= $number_payments; $i++) 
        {
            $amount     = 'amount_'.$i;
            $due_date   = 'date_'.$i;

            $data1['amortization_no'] = $i;
            $data1['amount']          = html_escape($this->input->post($amount));
            $data1['due_date']        = html_escape($this->input->post($due_date));
            $data1['orig_due_date']   = html_escape($this->input->post($due_date));

            $this->db->insert('agreement_amortization', $data1);

            $table      = 'agreement_amortization';
            $action     = 'insert';
            $insert_id  = $this->db->insert_id();
            $this->crud->save_log($table, $action, $insert_id, $data);
        }        
    }
}