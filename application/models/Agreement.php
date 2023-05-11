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
        $md5         = md5(date('d-m-y H:i:s'));
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
        $data['created_by']         = get_login_user_id();        
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
        $day = intval(date_format($objDate, "d"));

        if($day > $payment_date)
        {
            $month++;
        }

        // Create payment Schedule
        for ($i=1; $i <= $number_payments; $i++) 
        {
            if($has_down_payment == 1 &&  $i == 1)
            {
                $date = date("Y-m-d");
                $month = intval(date_format(date_create($date), "m"));
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


            if($semester_id != $this->runningSemester &  $i == 1)
            {
                $objDate = date_create($start_semester);
                $month = intval(date_format($objDate, "m"));
            }
            
            $month++;
            
            if($has_down_payment == 1 &&  $i == 1)
            {
                $down_payment_id = $insert_id;
            }
        }

        //DownPayment add the payment
        if($has_down_payment == 1)
        {
            $payment_total      = floatval($this->input->post('amount_1'));
            $temp_payment       = floatval($this->input->post('amount_1'));
            $tuition_payment    = 0.00;            
            $fees               = floatval($data['fees']);
            $fees_dif           = 0.00;
            $fees_payment       = 0.00;
            $materials          = floatval($data['materials']);
            $materials_dif      = 0.00;
            $materials_payment  = 0.00;

            if($fees > 0)
            {
                if($temp_payment >= $fees)
                {
                    $fees_payment = $fees;
                    $temp_payment -= $fees;
                }
                else
                {
                    $fees_payment = $temp_payment;
                    $fees_dif     = $fees - $temp_payment;
                    $temp_payment = 0;                    
                }
            }

            if($materials > 0)
            {
                if ($temp_payment > 0)
                {                
                    if($temp_payment >= $materials)
                    {
                        $materials_payment = $materials;
                        $temp_payment -= $materials;
                    }
                    else
                    {
                        $materials_payment = $temp_payment;
                        $materials_dif     = $materials - $temp_payment;
                        $temp_payment      = 0;
                    }
                }
                else
                {
                    $materials_dif = $materials;
                }
            }

            if($temp_payment > 0)
            {
                $tuition_payment = $temp_payment;
            }            
            
            $this->payment->create_down_payment($student_id, 'student', $agreement_id, $down_payment_id, $payment_total, $tuition_payment, $materials_payment, $fees_payment);

            // If the down payment is less than fee + materials add to the next amortization
            // Update the amortization
            $amortization_id = $down_payment_id + 1; 
            $this->update_amortization_by_down_payment($amortization_id, $fees_dif, $materials_dif);

        }

        //Add Card info(Automatic payment)
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

        
        return $agreement_id;
    }

    public function update_amortization_by_down_payment($amortization_id, $fees, $materials)
    {
        $this->db->reset_query();        
        $this->db->where('amortization_id', $amortization_id);
        $amortization = $this->db->get('agreement_amortization')->row_array();
        

        $data = array();
        $data['amount']     = $amortization['amount'] - ($materials + $fees);
        $data['materials']  = $materials;
        $data['fees']       = $fees;

        $this->db->reset_query();
        $this->db->where('amortization_id', $amortization_id);
        $this->db->update('agreement_amortization', $data);

        $table      = 'agreement_amortization';
        $action     = 'update';        
        $this->crud->save_log($table, $action, $amortization_id, $data);
    }
    
    public function create_agreement_accountant($student_id)
    {   
        $year        = html_escape($this->input->post('year_id'));
        $semester_id = html_escape($this->input->post('semester_id'));

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
        $data['modality_id']        = 0;
        $data['book_type']          = '';
        $data['program_type_id']    = 0;
        $data['number_payments']    = html_escape($this->input->post('number_payments'));
        $data['payment_date']       = html_escape($this->input->post('payment_date'));
        $data['automatic_payment']  = $has_automatic_payment;
        $data['created_by']         = get_login_user_id();
        $data['created_by_type']    = get_table_user(get_role_id());
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
            $name       = 'amount_'.$i;
            $dateName   = 'paid_amount_'.$i;

            $date = html_escape($this->input->post('due_date_'.$name));
            $paid = html_escape($this->input->post($dateName));

            $due_date   = date_create($date);

            $dataAmortization['amortization_no'] = $i;
            $dataAmortization['agreement_id']     = $agreement_id;
            $dataAmortization['amount']          = html_escape($this->input->post($name));
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

            if($paid == 1)
            {
                $dataAmortization['status_id']       = DEFAULT_AMORTIZATION_PAID;
            }
            else
            {
                $dataAmortization['status_id']       = DEFAULT_AMORTIZATION_PENDING;
            }

            $this->db->insert('agreement_amortization', $dataAmortization);

            $table      = 'agreement_amortization';
            $action     = 'insert';
            $insert_id  = $this->db->insert_id();
            $this->crud->save_log($table, $action, $insert_id, $dataAmortization);
            $month++;

            
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
        $query = $this->db->get('v_agreement')->row_array();
        
        return $query;
    }

    public function get_agreement_archive($agreement_id)
    {
        $this->db->reset_query();
        $this->db->where('agreement_id', $agreement_id);
        $query = $this->db->get('archive_agreement')->first_row();
        
        return $query;
    }

    public function get_student_agreements($student_id)
    {
        $this->db->reset_query();        
        $this->db->where('student_id', $student_id);
        $agreements = $this->db->get('agreement')->result_array();

        return $agreements;
    }

    public function get_agreement_agreement_amortization($agreement_id)
    {
        $this->db->reset_query();                                                
        $this->db->order_by('due_date' , 'ASC');
        $this->db->where('agreement_id', $agreement_id);
        $amortizations = $this->db->get('agreement_amortization')->result_array();

        return $amortizations;
    }

    public function get_agreement_amount_paid($agreement_id)
    {
        $this->db->reset_query();                                                
        $this->db->order_by('due_date' , 'ASC');
        $this->db->where('agreement_id', $agreement_id);
        $amortization = $this->db->get('agreement_amortization')->result_array();
        $total_paid = 0;

        foreach($amortization as $item)
        {
            $status_id          = $item['status_id'];
            $tuition            = floatval($item['amount']);
            $materials          = floatval($item['materials']);
            $fees               = floatval($item['fees']);
            $amortization_id    = $item['amortization_id']; 

            $total_amount = $tuition + $materials + $fees;

            // Partial Payment
            if($status_id == DEFAULT_AMORTIZATION_PARTIAL)
            {                                                      
                $this->db->reset_query();
                $this->db->select_sum('amount');
                $this->db->where('amortization_id =', $amortization_id);                
                $paid = $this->db->get('payment_details')->row()->amount;
            }

            // calculate the pending 
            if($status_id == DEFAULT_AMORTIZATION_PARTIAL || $status_id == DEFAULT_AMORTIZATION_PENDING)
            {
                $total_paid += $paid;
                
            }
        }

        return $total_paid;
    } 

    public function delete_agreement($param)
    {
        $agreement_id = base64_decode($param);

        $agreement = $this->get_agreement_info($agreement_id);
        $amortizations = $this->get_agreement_agreement_amortization($agreement_id);

        //Delete student enrollment 
        $year           = $agreement['year'];
        $semester_id    = $agreement['semester_id'];
        $student_id     = $agreement['student_id'];
        $this->academic->delete_student_enrollment($student_id, $year, $semester_id);

        foreach ($amortizations as $item) 
        {
            $this->db->reset_query();        
            $this->db->where('amortization_id =', $item['item']);
            $this->db->where('concept_type =', CONCEPT_TUITION_ID);
            $payment_id = $this->db->get('payment_details')->row()->payment_id;

            $this->payment->delete_payment($payment_id);
        }

        $this->db->reset_query();
        $this->db->where('agreement_id', $agreement_id);
        $this->db->delete('agreement');

        $table      = 'agreement';
        $action     = 'delete';
        $this->crud->save_log($table, $action, $agreement_id, []);  

        $this->db->where('agreement_id', $agreement_id);
        $this->db->delete('agreement_amortization');

        $table      = 'agreement_amortization';
        $action     = 'delete';
        $this->crud->save_log($table, $action, $agreement_id, []);

        $this->db->where('agreement_id', $agreement_id);
        $this->db->delete('agreement_card');

        $table      = 'agreement_card';
        $action     = 'delete';
        $this->crud->save_log($table, $action, $agreement_id, []);

    }

    public function add_addendum($agreement_id)
    {
        
        // Copy Data
            $this->db->reset_query();
            $this->db->where('agreement_id', $agreement_id);
            $data_agreement = $this->db->get('agreement')->row_array();

            $amount_paid = $this->get_agreement_amount_paid($agreement_id);

            $this->db->reset_query();
            $this->db->insert('archive_agreement', $data_agreement);

            $table      = 'archive_agreement';
            $action     = 'insert';
            $archive_id  = $this->db->insert_id();
            $this->crud->save_log($table, $action, $archive_id, $data_agreement);

            // Update paid
            $data_paid['paid']    = $amount_paid;

            $this->db->reset_query();
            $this->db->where('archive_id', $archive_id);
            $this->db->update('archive_agreement', $data_paid);

            $this->db->reset_query();
            $this->db->select($archive_id.' as archive_id, amortization_no, amount, materials, fees, due_date, orig_due_date, status_id');
            $this->db->where('agreement_id', $agreement_id);
            $data_amortization = $this->db->get('agreement_amortization');

            $this->db->reset_query();
            $this->db->insert_batch('archive_agreement_amortization', $data_amortization->result());

            $table      = 'archive_agreement_amortization';
            $action     = 'insert';
            $new_agreement_id  = $this->db->insert_id();
            $this->crud->save_log($table, $action, $new_agreement_id, $data_amortization->result());

            


        // Update Contract        
            $new_number_payments = html_escape($this->input->post('new_number_payments'));
            $number_payments     = intval($data_agreement['number_payments']);

            $user_id    = get_login_user_id();
            $user_type  = get_table_user(get_role_id());

            $new_data['updated_by']         = $user_id;
            $new_data['has_addendum']       = '1';
            $new_data['updated_by_type']    = $user_type;
            $new_data['number_payments']    = $new_number_payments;

            $this->db->reset_query();
            $this->db->where('agreement_id', $agreement_id);
            $this->db->update('agreement', $new_data);

            $table      = 'agreement';
            $action     = 'update';        
            $this->crud->save_log($table, $action, $agreement_id, $new_data);    

        // Update Amortization
        $this->db->reset_query();        
        $this->db->where('agreement_id', $agreement_id);
        $update_data = $this->db->get('agreement_amortization')->result_array();
        
        foreach($update_data as $amortization)
        {
            if($amortization['status_id'] == DEFAULT_AMORTIZATION_PENDING)
            {

                $amortization_id                    =  $amortization['amortization_id'];                
                $new_data_amortization              = array();
                $new_data_amortization['amount']    = $this->input->post('amount_'.$amortization_id);                
                $new_data_amortization['fees']      = $this->input->post('fees_'.$amortization_id);
                $new_data_amortization['materials'] = $this->input->post('materials_'.$amortization_id);
                $new_data_amortization['due_date']  = $this->input->post('due_date_'.$amortization_id);

                $this->db->reset_query();
                $this->db->where('amortization_id', $amortization_id);
                $this->db->update('agreement_amortization', $new_data_amortization);
        
                $table      = 'agreement_amortization';
                $action     = 'update';        
                $this->crud->save_log($table, $action, $agreement_id, $new_data_amortization);
            }
        }

        // Add the new amortization 4 -> 6 
        if($new_number_payments > $number_payments)
        {

            for ($i=($number_payments + 1); $i <= $new_number_payments; $i++) { 
                
                $new_data_amortization                  = array();                
                $new_data_amortization['amount']        = $this->input->post('amount_'.$i);
                $new_data_amortization['fees']          = $this->input->post('fees_'.$i);
                $new_data_amortization['materials']     = $this->input->post('materials_'.$i);
                $new_data_amortization['due_date']      = $this->input->post('due_date_'.$i);
                $new_data_amortization['agreement_id']  = $agreement_id;
                $new_data_amortization['amortization_no'] = $i;

                $this->db->reset_query();
                $this->db->insert('agreement_amortization', $new_data_amortization);
        
                $table           = 'agreement_amortization';
                $action          = 'update';       
                $amortization_id = $this->db->insert_id(); 
                $this->crud->save_log($table, $action, $amortization_id, $new_data_amortization);
            }
        }




    }
}