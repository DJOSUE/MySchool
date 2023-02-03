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

    public function get_payment_date()
    {
        $this->db->reset_query();
        $this->db->select('code as date, name');
        $this->db->where('parameter_id', 'PAYMENT_DATE');
        $query = $this->db->get('parameters')->result_array();;
        
        return $query;
    }

    public function create_agreement($student_id)
    {
        $md5 = md5(date('d-m-y H:i:s'));
        $year        = intval(html_escape($this->input->post('year_id')));
        $semester_id = intval(html_escape($this->input->post('semester_id')));

        $has_down_payment = html_escape($this->input->post('has_down_payment'));
        $has_automatic_payment = html_escape($this->input->post('automatic_payment'));

        //DownPayment add the payment
        if($has_down_payment == 1)
        {
            $down_payment = floatval($this->input->post('amount_1'));
            $data['down_payment'] = $down_payment;
        }

        // Get the enrolment ID
        $semester_enroll = $this->academic->get_semester_enroll($year, $semester_id);

        $data['student_id']         = $student_id;
        $data['agreement_date']     = date('Y-m-d');        
        $data['tuition']            = html_escape($this->input->post('cost_tuition'));
        $data['scholarship']        = html_escape($this->input->post('discount_scholarship'));
        $data['discounts']          = html_escape($this->input->post('discount'));
        $data['materials']          = html_escape($this->input->post('books_fee'));
        $data['fees']               = html_escape($this->input->post('fees'));
        $data['modality_id']        = html_escape($this->input->post('modality_id'));
        $data['book_type']          = html_escape($this->input->post('book_type'));
        $data['program_type_id']    = html_escape($this->input->post('program_type_id'));
        $data['number_payments']    = html_escape($this->input->post('number_payments'));
        $data['payment_date']       = html_escape($this->input->post('payment_date'));
        $data['automatic_payment']  = $has_automatic_payment;
        $data['created_by']         = $this->session->userdata('login_user_id');        
        $data['year']               = $year;
        $data['semester_id']        = $semester_id;
        $data['semester_enroll_id'] = $semester_enroll['semester_enroll_id'];        

        $this->db->insert('agreement', $data);

        $table      = 'agreement';
        $action     = 'insert';
        $agreement_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $agreement_id, $data);

        $number_payments = $data['number_payments'];
        $payment_date    = $data['payment_date'];
        $start_semester  = $semester_enroll['start_date'];

        $objDate = date_create($start_semester);

        $current_date = date_create(date("Y-m-d"));

        if( $current_date > $objDate)
        {
            $objDate = $current_date;
        }

        $month = intval(date_format($objDate, "m"));

        // Create payment Schedule
        for ($i=1; $i <= $number_payments; $i++) 
        {
            if($has_down_payment == 1 &&  $i == 1)
            {
                $date = date("Y-m-d");
                $month = intval($date, "m");
            }
            else
            {
                $date = $year."-". $month ."-". $payment_date;
            }

            $amount     = 'amount_'.$i;
            $due_date   = date_create($date);

            $dataAmortization['amortization_no'] = $i;
            $dataAmortization['agreement_id']     = $agreement_id;
            $dataAmortization['amount']          = html_escape($this->input->post($amount));
            $dataAmortization['due_date']        = date_format($due_date, "Y-m-d");
            $dataAmortization['orig_due_date']   = date_format($due_date, "Y-m-d");

            if($i == 1)
            {                
                $fees       = floatval($data['fees']);
                $materials  = floatval($data['materials']);
                $amount     = floatval($dataAmortization['amount']) - $fees - $materials;

                $dataAmortization['amount']     = $amount;
                $dataAmortization['materials']  = $materials;
                $dataAmortization['fees']       = $fees;
            }
            else
            {                
                $dataAmortization['materials']  = null;
                $dataAmortization['fees']       = null;
            }

            $this->db->insert('agreement_amortization', $dataAmortization);

            $table      = 'agreement_amortization';
            $action     = 'insert';
            $insert_id  = $this->db->insert_id();
            $this->crud->save_log($table, $action, $insert_id, $dataAmortization);
            $month++;

            if($has_down_payment == 1 &&  $i == 1)
            {
                $down_payment_id = $insert_id;
            }
        }

        //DownPayment add the payment
        if($has_down_payment == 1)
        {
            $down_payment = floatval($this->input->post('amount_1'));
            $fees = floatval($data['fees']);
            $materials = floatval($data['materials']);
            
            $this->payment->create_down_payment($student_id, 'student', $agreement_id, $down_payment_id, $down_payment, $materials, $fees);
        }

        //Add Card info(Automatic payment)
        if($has_automatic_payment == 1)
        {
            $dataCard['agreement_id']       = $agreement_id;
            $dataCard['type_card_id']       = $this->input->post('type_card_id');
            $dataCard['card_holder']        = $this->input->post('card_holder');
            $dataCard['card_number']        = get_encrypt($this->input->post('card_number'));
            $dataCard['security_code']      = get_encrypt($this->input->post('security_code'));
            $dataCard['expiration_date']    = get_encrypt($this->input->post('expiration_date'));
            $dataCard['zip_code']           = get_encrypt($this->input->post('zip_code'));

            $this->db->insert('agreement_card', $dataCard);

            $table      = 'agreement_card';
            $action     = 'insert';
            $table_id  = $this->db->insert_id();
            $this->crud->save_log($table, $action, $table_id, $data);            
        }
        
        return $agreement_id;
    }

    public function get_agreement_info($agreement_id)
    {
        $this->db->reset_query();
        $this->db->where('agreement_id', $agreement_id);
        $query = $this->db->get('agreement')->row_array();
        
        return $query;
    }

    public function get_student_agreements($student_id)
    {
        $this->db->reset_query();        
        $this->db->where('student_id', $student_id);
        $agreements = $this->db->get('agreement')->result_array();

        return $agreements;
    }
}