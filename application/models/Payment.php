<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends School 
{
    private $runningYear = '';
    private $runningSemester = '';
    
    function __construct() 
    {
        parent::__construct();
        $this->load->database();
        $this->runningYear      = $this->crud->getInfo('running_year'); 
        $this->runningSemester  = $this->crud->getInfo('running_semester'); 
    }
    function isActive($method){
        return $this->db->get_where('payment_gateways', array('name' => $method))->row()->status;
    }
    
    function updatePayPal(){
        $data['status'] = $this->input->post('status');
        $jsondata['sandbox']            = $this->input->post('sandbox_mode');
        $jsondata['currency']           = $this->input->post('paypal_currency');
        $jsondata['clientIdSandbox']    = $this->input->post('client_id_sandbox');
        $jsondata['clientIdProduction'] = $this->input->post('client_id_production');
        $jsondata['sandbox_email']      = $this->input->post('sandbox_email');
        $jsondata['production_email']   = $this->input->post('production_email');
        $data['settings']               = json_encode($jsondata);
        $this->db->where('name', 'paypal');
        $this->db->update('payment_gateways', $data);
    }
    
    function updateStripe(){
        $data['status']                 = $this->input->post('status');
        $jsondata['test_mode']          = $this->input->post('test_mode');
        $jsondata['currency']           = $this->input->post('stripe_currency');
        $jsondata['test_secret']        = $this->input->post('test_secret');
        $jsondata['test_public_key']    = $this->input->post('test_public_key');
        $jsondata['live_secret_key']    = $this->input->post('live_secret_key');
        $jsondata['live_public_key']    = $this->input->post('live_public_key');
        $data['settings']               = json_encode($jsondata);
        $this->db->where('name', 'stripe');
        $this->db->update('payment_gateways', $data);
    }
    
    function updateRazorpay(){
        $data['status']                    = $this->input->post('status');
        $jsondata['test_mode']             = $this->input->post('test_mode');
        $jsondata['currency']              = $this->input->post('razorpay_currency');
        $jsondata['test_key_id']           = $this->input->post('test_key_id');
        $jsondata['test_key_secret']       = $this->input->post('test_key_secret');
        $jsondata['production_key_id']     = $this->input->post('production_key_id');
        $jsondata['production_key_secret'] = $this->input->post('production_key_secret');
        $data['settings']                  = json_encode($jsondata);
        $this->db->where('name', 'razorpay');
        $this->db->update('payment_gateways', $data);
    }
    
    function updatePaystack(){
        $data['status']               = $this->input->post('status');
        $jsondata['test_mode']        = $this->input->post('test_mode');
        $jsondata['currency']         = $this->input->post('paystack_currency');
        $jsondata['test_public_key']  = $this->input->post('test_public_key');
        $jsondata['test_secret_key']  = $this->input->post('test_secret_key');
        $jsondata['live_public_key']  = $this->input->post('live_public_key');
        $jsondata['live_secret_key']  = $this->input->post('live_secret_key');
        $data['settings']             = json_encode($jsondata);
        $this->db->where('name', 'paystack');
        $this->db->update('payment_gateways', $data);
    }
    
    function updateFlutterwave(){
        $data['status']                  = $this->input->post('status');
        $jsondata['test_mode']           = $this->input->post('test_mode');
        $jsondata['currency']            = $this->input->post('flutterwave_currency');
        $jsondata['test_public_key']     = $this->input->post('test_public_key');
        $jsondata['test_secret_key']     = $this->input->post('test_secret_key');
        $jsondata['test_encryption_key'] = $this->input->post('test_encryption_key');
        $jsondata['live_public_key']     = $this->input->post('live_public_key');
        $jsondata['live_secret_key']     = $this->input->post('live_secret_key');
        $jsondata['live_encryption_key'] = $this->input->post('live_encryption_key');
        $data['settings']                = json_encode($jsondata);
        $this->db->where('name', 'flutterwave');
        $this->db->update('payment_gateways', $data);
    }
    
    function updatePesapal(){
        $data['status']                  = $this->input->post('status');
        $jsondata['test_mode']           = $this->input->post('test_mode');
        $jsondata['currency']            = $this->input->post('pesapal_currency');
        $jsondata['test_pesapal_consumer_key']     = $this->input->post('test_pesapal_consumer_key');
        $jsondata['test_pesapal_consumer_secret']     = $this->input->post('test_pesapal_consumer_secret');
        $jsondata['live_pesapal_consumer_key']     = $this->input->post('live_pesapal_consumer_key');
        $jsondata['live_pesapal_consumer_secret']     = $this->input->post('live_pesapal_consumer_secret');
        $data['settings']                = json_encode($jsondata);
        $this->db->where('name', 'pesapal');
        $this->db->update('payment_gateways', $data);
    }

    public function createBulkInvoice()
    {
        foreach ($this->input->post('student_id') as $id) 
        {
            $data['student_id']         = $id;
            $data['class_id']           = $this->input->post('class_id');
            $data['title']              = html_escape($this->input->post('title'));
            $data['description']        = html_escape($this->input->post('description'));
            $data['amount']             = html_escape($this->input->post('amount'));
            $data['due']                = $data['amount'];
            $data['status']             = $this->input->post('status');
            $data['creation_timestamp'] = $this->crud->getDateFormat();
            $data['year']               = $this->runningYear;
            $this->db->insert('invoice', $data);

            $table      = 'invoice';
            $action     = 'insert';
            $insert_id  = $this->db->insert_id();
            $this->crud->save_log($table, $action, $insert_id, $data);

            $invoice_id = $this->db->insert_id();
            $data2['invoice_id']        = $invoice_id;
            $data2['student_id']        = $id;
            $data2['title']             = html_escape($this->input->post('title'));
            $data2['description']       = html_escape($this->input->post('description'));
            $data2['payment_type']      = 'income';
            $data2['method']            = $this->input->post('method');
            $data2['amount']            = html_escape($this->input->post('amount'));
            $data2['timestamp']         = strtotime($this->input->post('date'));
            $data2['month']             = date('M');
            $data2['year']              = $this->runningYear;
            $this->db->insert('payment' , $data2);

            $table      = 'payment';
            $action     = 'insert';
            $insert_id  = $this->db->insert_id();
            $this->crud->save_log($table, $action, $insert_id, $data2);
        }
    }
    
    public function singleInvoice()
    {
        $data['student_id']         = $this->input->post('student_id');
        $data['class_id']           = $this->input->post('class_id');
        $data['title']              = html_escape($this->input->post('title'));
        $data['description']        = html_escape($this->input->post('description'));
        $data['amount']             = html_escape($this->input->post('amount'));
        $data['due']                = $data['amount'];
        $data['status']             = $this->input->post('status');
        $data['creation_timestamp'] = $this->crud->getDateFormat();
        $data['year']               = $this->runningYear;
        $this->db->insert('invoice', $data);

        $table      = 'invoice';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);

        $invoice_id = $this->db->insert_id();
        $data2['invoice_id']        =   $invoice_id;
        $data2['student_id']        =   $this->input->post('student_id');
        $data2['title']             =   html_escape($this->input->post('title'));
        $data2['description']       =   html_escape($this->input->post('description'));
        $data2['payment_type']      =  'income';
        $data2['method']            =   $this->input->post('method');
        $data2['amount']            =   $this->input->post('amount');
        $data2['timestamp']         =   strtotime($this->input->post('date'));
        $data2['month']             =   date('M');
        $data2['year']              =  $this->runningYear;
        $data2['semester_id']       =  $this->runningSemester;
        $this->db->insert('payment' , $data2);

        $table      = 'payment';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data2);

        $student_name     = $this->crud->get_name('student', $this->input->post('student_id'));
        $student_email    = $this->db->get_where('student', array('student_id' => $this->input->post('student_id')))->row()->email;
        $student_phone    = $this->db->get_where('student', array('student_id' => $this->input->post('student_id')))->row()->phone;
        $parent_id        = $this->db->get_where('student', array('student_id' => $this->input->post('student_id')))->row()->parent_id;
        $parent_phone     = $this->db->get_where('parent', array('parent_id' => $parent_id))->row()->phone;
        $parent_email     = $this->db->get_where('parent', array('parent_id' => $parent_id))->row()->email;
        $notify           = $this->crud->getInfo('p_new_invoice');
        $notify2          = $this->crud->getInfo('s_new_invoice');
        $message          = getPhrase('new_invoice_has_been_generated_for')." " . $student_name;
        $sms_status       = $this->crud->getInfo('sms_status');
        if($notify == 1)
        {
            if ($sms_status == 'msg91') 
            {
                $result = $this->crud->send_sms_via_msg91($message, $parent_phone);
            }
            else if ($sms_status == 'twilio') 
            {
                $this->crud->twilio_api($message,"".$parent_phone."");
            }
            else if ($sms_status == 'clickatell') 
            {
                $this->crud->clickatell($message,$parent_phone);
            }
        }
        $this->crud->parent_new_invoice($student_name, "".$parent_email."");
        if($notify2 == 1)
        {
          if ($sms_status == 'msg91') 
          {
             $result = $this->crud->send_sms_via_msg91($message, $student_phone);
          }
          else if ($sms_status == 'twilio') 
          {
              $this->crud->twilio_api($message,"".$student_phone."");
          }
          else if ($sms_status == 'clickatell') 
          {
              $this->crud->clickatell($message,$student_phone);
          }
        }
        $this->crud->student_new_invoice($student_name, "".$student_email."");
    }
    
    public function updateInvoice($invoiceId)
    {
        $data['title']              = html_escape($this->input->post('title'));
        $data['description']        = html_escape($this->input->post('description'));
        $data['amount']             = html_escape($this->input->post('amount'));
        $data['status']             = $this->input->post('status');

        $this->db->where('invoice_id', $invoiceId);
        $this->db->update('invoice', $data);
    }
    
    public function deleteInvoice($invoiceId)
    {
        $this->db->where('invoice_id', $invoiceId);
        $this->db->delete('invoice');
    }
    
    public function makePayPal()
    {
        $type = '';
        if($this->session->userdata('login_type') == 'parent')
        {
            $type = 'parents';
        }else{
            $type = 'student';
        }
        $invoice_id      = $this->input->post('invoice_id');
        $system_settings = $this->db->get_where('settings', array('type' => 'paypal_email'))->row();
        $invoice_details = $this->db->get_where('invoice', array('invoice_id' => $invoice_id))->row();
        $this->paypal->add_field('rm', 2);
        $this->paypal->add_field('no_note', 0);
        $this->paypal->add_field('item_name', $invoice_details->title);
        $this->paypal->add_field('amount', $invoice_details->due);
        $this->paypal->add_field('currency_code', $this->db->get_where('settings' , array('type' =>'currency'))->row()->description);
        $this->paypal->add_field('custom', $invoice_details->invoice_id);
        $this->paypal->add_field('business', $system_settings->description);
        $this->paypal->add_field('notify_url', base_url() . $type.'/invoice/');
        $this->paypal->add_field('cancel_return', base_url() . $type.'/invoice/paypal_cancel');
        $this->paypal->add_field('return', base_url() . $type.'/invoice/paypal_success');
        $this->paypal->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
        $this->paypal->submit_paypal_post();
    }
    
    public function payWithPayPal($invoice_id)
    {
        $paypal_data = json_decode($this->db->get_where('payment_gateways', array('name' => 'paypal'))->row()->settings);
        $type = '';
        if($this->session->userdata('login_type') == 'parent')
        {
            $type = 'parents';
        }else{
            $type = 'student';
        }
															
																									
        $invoice_details = $this->db->get_where('invoice', array('invoice_id' => base64_decode($invoice_id)))->row();
        $this->paypal->add_field('rm', 2);
        $this->paypal->add_field('no_note', 0);
        $this->paypal->add_field('item_name', $invoice_details->title);
        $this->paypal->add_field('amount', $invoice_details->due);
        $this->paypal->add_field('currency_code', $paypal_data->currency);
        $this->paypal->add_field('custom', $invoice_details->invoice_id);
        if($paypal_data->sandbox == 1){
            $this->paypal->add_field('business', $paypal_data->sandbox_email);
        }else{
            $this->paypal->add_field('business', $paypal_data->production_email);
        }
        $this->paypal->add_field('notify_url', base_url() . $type.'/invoice');
        $this->paypal->add_field('cancel_return', base_url() .'/payments/paypal_cancel');
        $this->paypal->add_field('return', base_url() . '/payments/paypal_success');
        if($paypal_data->sandbox == 1){
            $this->paypal->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';   
        }else{
            $this->paypal->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
        }
        $this->paypal->submit_paypal_post();
    }

    public function paypalSuccess()
    {
        $ipn_response = '';
        
        foreach ($_POST as $key => $value) 
        {
            $value = urlencode(stripslashes($value));
            $ipn_response .= "\n$key=$value";
        }

        $data['payment_details']   = $ipn_response;
        $data['payment_timestamp'] = strtotime(date("m/d/Y"));
        $data['payment_method']    = 'paypal';
        $data['status']            = 'completed';
        $invoice_id                = html_escape($_POST['custom']);
        $this->db->where('invoice_id', $invoice_id);
        $this->db->update('invoice', $data);

        $data2['method']       =   'paypal';
        $data2['invoice_id']   =   html_escape($_POST['custom']);
        $data2['timestamp']    =   strtotime(date("m/d/Y"));
        $data2['payment_type'] =   'income';
        $data2['title']        =   $this->db->get_where('invoice' , array('invoice_id' => $data2['invoice_id']))->row()->title;
        $data2['description']  =   $this->db->get_where('invoice' , array('invoice_id' => $data2['invoice_id']))->row()->description;
        $data2['student_id']   =   $this->db->get_where('invoice' , array('invoice_id' => $data2['invoice_id']))->row()->student_id;
        $data2['amount']       =   $this->db->get_where('invoice' , array('invoice_id' => $data2['invoice_id']))->row()->amount;
        $this->db->insert('payment' , $data2);

        $table      = 'payment';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data2);
    }
    
/********************** New Payment *****************************************************************************************************************************/
    
    public function create_payment($user_id, $user_type)
    {
        $invoice_number = $this->get_next_invoice_number();

        $send_email = intval($this->input->post('send_email'));
        $payment_no_agreement = intval($this->input->post('previous_semester_payment'));

        $data_payment['invoice_number']  = $invoice_number;
        $data_payment['invoice_date']    = date("Y-m-d");
        $data_payment['user_id']         = $user_id;
        $data_payment['user_type']       = $user_type;
        $data_payment['user_id']         = $user_id;
        $data_payment['year']            = $this->runningYear;
        $data_payment['semester_id']     = $this->runningSemester;
        $data_payment['comment']         = html_escape($this->input->post('comment'));
        $data_payment['amount']          = $this->input->post('txtTotal');
        $data_payment['created_by']      = $this->session->userdata('login_user_id');
        $data_payment['created_by_type'] = get_table_user($this->session->userdata('role_id'));

        if(floatval($data_payment['amount']) > 0)
        {
            $this->db->insert('payment', $data_payment);

            $table      = 'payment';
            $action     = 'insert';
            $payment_id  = $this->db->insert_id();
            $this->crud->save_log($table, $action, $payment_id, $data_payment);

            // payment_details
            $income_types = $this->payment->get_income_types();
            foreach($income_types as $item)
            {
                $id     = $item['income_type_id'];
                $amount = floatval($this->input->post('income_amount_'.$id));

                if($amount > 0)
                {
                    $concept_type = $this->input->post('income_type_'.$id);

                    // If is tuition

                    if($concept_type == CONCEPT_TUITION_ID)
                    {
                        if($payment_no_agreement == 0)
                        {
                            $amortization_id = $this->input->post('amortization_id');
                            
                            if($amortization_id != "")
                            {
                                //Calculate paid
                                $this->db->reset_query();
                                $this->db->select_sum('amount');
                                $this->db->where('amortization_id =', $amortization_id);
                                $this->db->where('concept_type =', CONCEPT_TUITION_ID);
                                $paid = $this->db->get('payment_details')->row()->amount; 

                                // Calculate the amount
                                $this->db->reset_query();
                                $this->db->select_sum('amount');
                                $this->db->where('amortization_id =', $amortization_id);
                                $payment = $this->db->get('agreement_amortization')->row()->amount;

                                $dif = $payment - $paid;

                                if($dif > 0 && $amount <= $dif)
                                {
                                    $this->insert_payment_details($payment_id, $concept_type, $amount, $amortization_id);
                                }
                                else if($dif > 0 && $amount > $dif)
                                {                                
                                    $this->insert_payment_details($payment_id, $concept_type, $dif, $amortization_id);

                                    $_dif = $amount - $dif;

                                    while ($_dif > 0)
                                    {
                                        $amortization = $this->get_next_amortization($user_id);
                                        $_amount = $amortization['amount'];
                                        $_amortization_id = $amortization['amortization_id'];

                                        if($_dif <= $_amount)
                                        {
                                            $this->insert_payment_details($payment_id, $concept_type, $_dif, $_amortization_id);
                                            $_dif = 0;
                                        }

                                        if($_dif > $_amount)
                                        {
                                            $_dif = $_dif - $_amount; 
                                            $this->insert_payment_details($payment_id, $concept_type, $_amount, $_amortization_id);
                                        }
                                    }
                                }
                            }
                            else
                            {
                                $amortization = $this->get_next_amortization($user_id);
                                $_amount = $amortization['amount'];
                                $_amortization_id = $amortization['amortization_id'];

                                if($amount <= $_amount)
                                {
                                    $this->insert_payment_details($payment_id, $concept_type, $amount, $_amortization_id);
                                }
                                else
                                {
                                    $_dif = $amount - $_amount;
                                    $this->insert_payment_details($payment_id, $concept_type, $_amount, $_amortization_id);

                                    while ($_dif > 0)
                                    {
                                        $amortization = $this->get_next_amortization($user_id);
                                        $_amount = $amortization['amount'];
                                        $_amortization_id = $amortization['amortization_id'];

                                        if($_dif <= $_amount)
                                        {
                                            $this->insert_payment_details($payment_id, $concept_type, $_dif, $_amortization_id);
                                            $_dif = 0;
                                        }

                                        if($_dif > $_amount)
                                        {
                                            $_dif = $_dif - $_amount; 
                                            $this->insert_payment_details($payment_id, $concept_type, $_amount, $_amortization_id);
                                        }
                                    }
                                }



                            }
                        }
                        else
                        {
                            $this->insert_payment_details($payment_id, $concept_type, $amount);
                        }
                    }
                    else
                    {
                        $this->insert_payment_details($payment_id, $concept_type, $amount);
                    }
                }
            }        

            // Discounts
            $discount_types = $this->payment->get_discount_types();
            foreach($discount_types as $item)
            {
                $id     = $item['discount_id'];
                $amount = floatval($this->input->post('discount_amount_'.$id));

                if($amount > 0)
                {
                    $payment_discount['payment_id']      = $payment_id;
                    $payment_discount['discount_type']   = $this->input->post('discount_type_'.$id);
                    // $payment_discount['comment']         = html_escape($this->input->post('discount_comment_'.$id));
                    $payment_discount['amount']          = $amount;

                    $this->db->insert('payment_discounts', $payment_discount);

                    $table      = 'payment_discounts';
                    $action     = 'insert';
                    $insert_id  = $this->db->insert_id();
                    $this->crud->save_log($table, $action, $insert_id, $payment_discount);
                }
            }

            // payment_transaction
            $transaction_types = $this->payment->get_transaction_types();
            foreach($transaction_types as $item)
            {
                $id     = $item['transaction_type_id'];
                $amount = floatval($this->input->post('payment_amount_'.$id));

                if($amount > 0)
                {
                    $payment_transaction['payment_id']          = $payment_id;
                    $payment_transaction['transaction_type']    = $this->input->post('payment_type_'.$id);
                    $payment_transaction['transaction_code']    = $this->input->post('transaction_code_'.$id);
                    // $payment_transaction['comment']             = html_escape($this->input->post('comment_'.$id));
                    $payment_transaction['amount']              = $this->input->post('payment_amount_'.$id);

                    if($item['name'] == 'Card')
                    {
                        $payment_transaction['card_type']       = $this->input->post('card_type_'.$id);

                        // add a new concept
                        $fee = $this->get_credit_card_fee($payment_transaction['card_type'] );

                        if($fee > 0 )
                        {
                            $payment_fee['payment_id']      = $payment_id;
                            $payment_fee['concept_type']    = CONCEPT_CARD_ID;
                            // $payment_fee['comment']         = html_escape($this->input->post('income_comment_'.$id));
                            $payment_fee['amount']          = round((($amount * $fee)/100), 2);

                            $this->db->insert('payment_details', $payment_fee);

                            $table      = 'payment_details';
                            $action     = 'insert';
                            $insert_id  = $this->db->insert_id();
                            $this->crud->save_log($table, $action, $insert_id, $payment_fee);

                        }
                    }

                    $this->db->insert('payment_transaction', $payment_transaction);

                    $table      = 'payment_transaction';
                    $action     = 'insert';
                    $insert_id  = $this->db->insert_id();
                    $this->crud->save_log($table, $action, $insert_id, $payment_transaction);
                }
            }

            if($send_email == 1)
            {
                $user_info = $this->crud->get_user_info($user_type, $user_id);
                $this->crud->student_new_invoice($user_info['first_name'], "".$user_info['email']."", $payment_id);
            }

            $created_by       = $this->session->userdata('login_user_id');
            $created_by_type  = $data_payment['created_by_type'];
            $created_name     = $this->crud->get_name($created_by_type, $created_by);            
            $comment          = $created_name.' posted a payment of $ '. $data_payment['amount'];
            $_POST['comment'] = $comment;

            // Create an interaction
            if($user_type == 'applicant')
            {
                $_POST['applicant_id']  = $user_id;
                
                $this->applicant->add_interaction('automatic');
            }
            else
            {
                $this->studentModel->add_interaction($user_id, 'automatic');
            }
        
        }
    }

    public function _update_payment($user_id, $user_type)
    {
        $invoice_number = $this->get_next_invoice_number();

        $data_payment['invoice_number']  = $invoice_number;
        $data_payment['user_id']         = $user_id;
        $data_payment['user_type']       = $user_type;
        $data_payment['comment']         = html_escape($this->input->post('comment'));
        $data_payment['amount']          = $this->input->post('txtTotal');
        $data_payment['created_by']      = $this->session->userdata('login_user_id');
        $data_payment['created_by_type'] = get_table_user($this->session->userdata('role_id'));

        $this->db->insert('payment', $data_payment);

        $table      = 'payment';
        $action     = 'insert';
        $payment_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $payment_id, $data_payment);

        // payment_details

        $income_types = $this->payment->get_income_types();
        foreach($income_types as $item)
        {
            $id     = $item['income_type_id'];
            $amount = floatval($this->input->post('income_amount_'.$id));

            if($amount > 0)
            {
                $payment_details['payment_id']      = $payment_id;
                $payment_details['concept_type']    = $this->input->post('income_type_'.$id);
                // $payment_details['comment']         = html_escape($this->input->post('income_comment_'.$id));
                $payment_details['amount']          = $amount;

                $this->db->insert('payment_details', $payment_details);

                $table      = 'payment_details';
                $action     = 'insert';
                $insert_id  = $this->db->insert_id();
                $this->crud->save_log($table, $action, $insert_id, $payment_details);
            }

        }        

        // Discounts
        $discount_types = $this->payment->get_discount_types();
        foreach($discount_types as $item)
        {
            $id     = $item['discount_id'];
            $amount = floatval($this->input->post('discount_amount_'.$id));

            if($amount > 0)
            {
                $payment_discount['payment_id']      = $payment_id;
                $payment_discount['discount_type']   = $this->input->post('discount_type_'.$id);
                // $payment_discount['comment']         = html_escape($this->input->post('discount_comment_'.$id));
                $payment_discount['amount']          = $amount;

                $this->db->insert('payment_discounts', $payment_discount);

                $table      = 'payment_discounts';
                $action     = 'insert';
                $insert_id  = $this->db->insert_id();
                $this->crud->save_log($table, $action, $insert_id, $payment_discount);
            }
        }

        // payment_transaction
        $transaction_types = $this->payment->get_transaction_types();
        foreach($transaction_types as $item)
        {
            $id     = $item['transaction_type_id'];
            $amount = floatval($this->input->post('payment_amount_'.$id));

            if($amount > 0)
            {
                $payment_transaction['payment_id']          = $payment_id;
                $payment_transaction['transaction_type']    = $this->input->post('payment_type_'.$id);
                $payment_transaction['transaction_code']    = $this->input->post('transaction_code_'.$id);
                // $payment_transaction['comment']             = html_escape($this->input->post('comment_'.$id));
                $payment_transaction['amount']              = $this->input->post('payment_amount_'.$id);

                if($item['name'] == 'Card')
                {
                    $payment_transaction['card_type']       = $this->input->post('card_type_'.$id);

                    // add a new concept
                    $fee = $this->get_credit_card_fee($payment_transaction['card_type'] );

                    if($fee > 0 )
                    {
                        $payment_fee['payment_id']      = $payment_id;
                        $payment_fee['concept_type']    = CONCEPT_CARD_ID;
                        // $payment_fee['comment']         = html_escape($this->input->post('income_comment_'.$id));
                        $payment_fee['amount']          = round((($amount * $fee)/100), 2);

                        $this->db->insert('payment_details', $payment_fee);

                        $table      = 'payment_details';
                        $action     = 'insert';
                        $insert_id  = $this->db->insert_id();
                        $this->crud->save_log($table, $action, $insert_id, $payment_fee);

                    }
                }

                $this->db->insert('payment_transaction', $payment_transaction);

                $table      = 'payment_transaction';
                $action     = 'insert';
                $insert_id  = $this->db->insert_id();
                $this->crud->save_log($table, $action, $insert_id, $payment_transaction);
            }
        }
    }

    public function update_payment($payment_id)
    {

        $invoice_number = $this->input->post('invoice_number'); 

        $this->db->reset_query();        
        $this->db->where('invoice_number', $invoice_number);        
        $query = $this->db->get('payment');

        if($query->num_rows() == 0)
        {
            $created =  explode(':', $this->input->post('cashier_id'));

            $user_id      = $this->session->userdata('login_user_id');
            $user_type    = get_table_user($this->session->userdata('role_id'));

            $data['created_by']         = $created[1];
            $data['created_by_type']    = $created[0];
            $data['invoice_date']       = $this->input->post('invoice_date');
            $data['invoice_number']     = $this->input->post('invoice_number');        

            $data['updated_by']         = $user_id;
            $data['updated_by_type']    = $user_type;

            $this->db->where('payment_id', $payment_id);
            $this->db->update('payment', $data);

            $table      = 'payment';
            $action     = 'update';
            $this->crud->save_log($table, $action, $payment_id, $data);

            $this->session->set_flashdata('flash_message' , getPhrase('successfully_update'));
        }
        else
        {
            $this->session->set_flashdata('flash_error_message' , getPhrase('invoice_number_duplicate'));
        }

    }

    public function delete_payment($payment_id)
    {
        $amortization_id = '';
        $this->db->reset_query();        
        $this->db->where('payment_id =', $payment_id);
        $this->db->where('concept_type =', CONCEPT_TUITION_ID);
        $amortization_id = $this->db->get('payment_details')->row()->amortization_id;

        $this->db->where('payment_id', $payment_id);
        $this->db->delete('payment');

        $table      = 'payment';
        $action     = 'delete';
        $this->crud->save_log($table, $action, $payment_id, []);

        // payment_details
        $this->db->where('payment_id', $payment_id);
        $this->db->delete('payment_details');

        $table      = 'payment_details';
        $action     = 'delete';
        $this->crud->save_log($table, $action, $payment_id, []);

        // payment_discounts
        $this->db->where('payment_id', $payment_id);
        $this->db->delete('payment_discounts');

        $table      = 'payment_discounts';
        $action     = 'delete';
        $this->crud->save_log($table, $action, $payment_id, []);

        // payment_transaction
        $this->db->where('payment_id', $payment_id);
        $this->db->delete('payment_transaction');

        $table      = 'payment_transaction';
        $action     = 'delete';
        $this->crud->save_log($table, $action, $payment_id, []);

        if($amortization_id != '')
        {
            $this->update_amortization_status_delete($amortization_id);
        }
        
    }

    public function create_down_payment($user_id, $user_type, $agreement_id, $amortization_id, $down_payment, $books, $fees)
    {
        $invoice_number = $this->get_next_invoice_number();

        $agreement = $this->agreement->get_agreement_info($agreement_id);

        $amount = floatval($down_payment);
        
        $tuition = (floatval($down_payment) - floatval($books) - floatval($fees));

        $data_payment['invoice_number']  = $invoice_number;
        $data_payment['invoice_date']    = date("Y-m-d");
        $data_payment['user_id']         = $user_id;
        $data_payment['user_type']       = $user_type;
        $data_payment['year']            = $agreement['year'];
        $data_payment['semester_id']     = $agreement['semester_id'];
        $data_payment['comment']         = "Down payment";
        $data_payment['amount']          = $amount;
        $data_payment['created_by']      = $this->session->userdata('login_user_id');
        $data_payment['created_by_type'] = get_table_user($this->session->userdata('role_id'));

        $this->db->insert('payment', $data_payment);

        $table      = 'payment';
        $action     = 'insert';
        $payment_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $payment_id, $data_payment);

        // Update the amortization
        $this->update_amortization_by_down_payment($amortization_id, $tuition, $books, $fees);

        // payment_details
        if(floatval($tuition) > 0)
            $this->insert_payment_details($payment_id, CONCEPT_TUITION_ID, $tuition, $amortization_id );
        if(floatval($books) > 0)
            $this->insert_payment_details($payment_id, CONCEPT_BOOKS_ID, $books);
        if(floatval($fees) > 0)
            $this->insert_payment_details($payment_id, CONCEPT_ENROL_FEE_ID, $fees);

        // payment_transaction
        $transaction_types = $this->payment->get_transaction_types();
        foreach($transaction_types as $item)
        {
            $id     = $item['transaction_type_id'];
            $amount = floatval($this->input->post('payment_amount_'.$id));

            if($amount > 0)
            {
                $payment_transaction['payment_id']          = $payment_id;
                $payment_transaction['transaction_type']    = $this->input->post('payment_type_'.$id);
                $payment_transaction['transaction_code']    = $this->input->post('transaction_code_'.$id);
                // $payment_transaction['comment']             = html_escape($this->input->post('comment_'.$id));
                $payment_transaction['amount']              = $this->input->post('payment_amount_'.$id);

                if($item['name'] == 'Card')
                {
                    $payment_transaction['card_type']       = $this->input->post('card_type_'.$id);

                    // add a new concept
                    $fee = $this->get_credit_card_fee($payment_transaction['card_type'] );

                    if($fee > 0)
                    {
                        $payment_fee['payment_id']      = $payment_id;
                        $payment_fee['concept_type']    = CONCEPT_CARD_ID;
                        // $payment_fee['comment']         = html_escape($this->input->post('income_comment_'.$id));
                        $payment_fee['amount']          = round((($amount * $fee)/100), 2);

                        $this->db->insert('payment_details', $payment_fee);

                        $table      = 'payment_details';
                        $action     = 'insert';
                        $insert_id  = $this->db->insert_id();
                        $this->crud->save_log($table, $action, $insert_id, $payment_fee);

                    }
                }

                $this->db->insert('payment_transaction', $payment_transaction);

                $table      = 'payment_transaction';
                $action     = 'insert';
                $insert_id  = $this->db->insert_id();
                $this->crud->save_log($table, $action, $insert_id, $payment_transaction);
            }
        }

        //Send Invoice
        $user_info = $this->crud->get_user_info($user_type, $user_id);
        $this->crud->student_new_invoice($user_info['first_name'], "".$user_info['email']."", $payment_id);

        //Add automatic interaction
        $created_by       = $this->session->userdata('login_user_id');
        $created_by_type  = $data_payment['created_by_type'];
        $created_name     = $this->crud->get_name($created_by_type, $created_by);            
        $comment          = $created_name.' posted a payment of $ '. $data_payment['amount'];
        $_POST['comment'] = $comment;

        if($user_type == 'applicant')
        {
            $_POST['applicant_id']  = $user_id;
            
            $this->applicant->add_interaction('automatic');
        }
        else
        {
            $this->studentModel->add_interaction($user_id, 'automatic');
        }
    }

    public function update_amortization_by_down_payment($amortization_id, $amount, $materials, $fees)
    {
        $data = array();
        $data['amount']     = $amount;
        $data['materials']  = $materials;
        $data['fees']       = $fees;

        $this->db->reset_query();
        $this->db->where('amortization_id', $amortization_id);
        $this->db->update('agreement_amortization', $data);
    }

    public function insert_payment_details($payment_id, $concept_type, $amount, $amortization_id = "")
    {
        $payment_details['payment_id']      = $payment_id;
        $payment_details['concept_type']    = $concept_type;
        $payment_details['amount']          = $amount;

        if($amortization_id != "")
        {
            $payment_details['amortization_id'] = $amortization_id;
            
        }

        $this->db->insert('payment_details', $payment_details);

        $table      = 'payment_details';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $payment_details);

        if($amortization_id != "")
        {
            $this->update_amortization_status($amortization_id);
        }
    }
    
    public function get_next_amortization($user_id)
    {
        $this->db->reset_query();        
        $this->db->where('student_id', $user_id);
        $this->db->where('year', $this->runningYear);
        $this->db->where('semester_id', $this->runningSemester);
        $agreement = $this->db->get('agreement')->row_array();

        $this->db->reset_query();
        $this->db->order_by('due_date' , 'ASC');
        $this->db->where('agreement_id =', $agreement['agreement_id']);
        $this->db->where('status_id <>', '0');
        $amortization = $this->db->get('agreement_amortization')->row_array();

        return $amortization;
    }

    public function update_amortization_status($amortization_id)
    {
        $this->db->reset_query();
        $this->db->order_by('due_date' , 'ASC');
        $this->db->where('amortization_id =', $amortization_id);
        $this->db->where('status_id <>', '0');
        $amortization = floatval($this->db->get('agreement_amortization')->row()->amount);

        $this->db->reset_query();
        $this->db->select_sum('amount');
        $this->db->where('amortization_id =', $amortization_id);
        $this->db->where('concept_type =', CONCEPT_TUITION_ID);
        $paid = floatval($this->db->get('payment_details')->row()->amount);

        // echo '<pre>';
        // var_dump($amortization);
        // echo '</pre>';

        if($paid > 0)
        {
            if($amortization == $paid)
            {
                $data['status_id'] = DEFAULT_AMORTIZATION_PAID; // PAID ALL
                $this->db->where('amortization_id', $amortization_id);
                $this->db->update('agreement_amortization', $data);
            }
            else if($amortization > $paid)
            {
                $data['status_id'] = DEFAULT_AMORTIZATION_PARTIAL; // PAID PARTIAL
                $this->db->where('amortization_id', $amortization_id);
                $this->db->update('agreement_amortization', $data);
            }
            else if($amortization < $paid)
            {
                $data['status_id'] = DEFAULT_AMORTIZATION_PAID; // PAID ALL
                $this->db->where('amortization_id', $amortization_id);
                $this->db->update('agreement_amortization', $data);
            }
        }
        else
        {
            $data['status_id'] = DEFAULT_AMORTIZATION_PENDING; // PAID ALL
            $this->db->where('amortization_id', $amortization_id);
            $this->db->update('agreement_amortization', $data);
        }

        $table      = 'agreement_amortization';
        $action     = 'update';
        $this->crud->save_log($table, $action, $amortization_id, $data);
    }

    public function update_amortization_status_delete($amortization_id)
    {
        $this->db->reset_query();
        $this->db->order_by('due_date' , 'ASC');
        $this->db->where('amortization_id =', $amortization_id);        
        $amortization = floatval($this->db->get('agreement_amortization')->row()->amount);

        $this->db->reset_query();
        $this->db->select_sum('amount');
        $this->db->where('amortization_id =', $amortization_id);
        $this->db->where('concept_type =', CONCEPT_TUITION_ID);
        $paid = floatval($this->db->get('payment_details')->row()->amount);

        // echo '<pre>';
        // var_dump($amortization);
        // echo '</pre>';

        if($paid > 0)
        {
            if($amortization == $paid)
            {
                $data['status_id'] = DEFAULT_AMORTIZATION_PAID; // PAID ALL
                $this->db->where('amortization_id', $amortization_id);
                $this->db->update('agreement_amortization', $data);
            }
            else if($amortization > $paid)
            {
                $data['status_id'] = DEFAULT_AMORTIZATION_PARTIAL; // PAID PARTIAL
                $this->db->where('amortization_id', $amortization_id);
                $this->db->update('agreement_amortization', $data);
            }
            else if($amortization < $paid)
            {
                $data['status_id'] = DEFAULT_AMORTIZATION_PAID; // PAID ALL
                $this->db->where('amortization_id', $amortization_id);
                $this->db->update('agreement_amortization', $data);
            }
        }
        else
        {
            $data['status_id'] = DEFAULT_AMORTIZATION_PENDING; // PAID ALL
            $this->db->where('amortization_id', $amortization_id);
            $this->db->update('agreement_amortization', $data);
        }

        $table      = 'agreement_amortization';
        $action     = 'update';
        $this->crud->save_log($table, $action, $amortization_id, $data);
    }

    public function get_payment_info($payment_id)
    {
        $this->db->reset_query();
        $this->db->where('payment_id', $payment_id);
        $query = $this->db->get('payment')->row_array();
        return $query;        
    }

    public function get_payment_details($payment_id)
    {
        $this->db->reset_query();
        $this->db->where('payment_id', $payment_id);
        $query = $this->db->get('payment_details')->result_array();
        return $query;        
    }

    public function get_payment_discounts($payment_id)
    {
        $this->db->reset_query();
        $this->db->where('payment_id', $payment_id);
        $query = $this->db->get('payment_discounts')->result_array();
        return $query;        
    }

    public function get_payment_transaction($payment_id)
    {
        $this->db->reset_query();
        $this->db->where('payment_id', $payment_id);
        $query = $this->db->get('payment_transaction')->result_array();
        return $query;        
    }

    public function get_income_types()
    {
        $this->db->reset_query();
        $this->db->select('code as income_type_id, name');
        $this->db->where('parameter_id', 'INCOME_TYPE');
        $this->db->where_not_in('name', CONCEPT_CARD_NAME);
        $query = $this->db->get('parameters')->result_array();
        return $query;
    }

    public function get_income_types_by_user($user_type)
    {
        $this->db->reset_query();
        $this->db->select('code as income_type_id, name');

        switch ($user_type) {
            case 'student':
                $this->db->where('value_1', '1');
                break;
            case 'applicant':
                $this->db->where('value_2', '1');
                break;
        }
        
        
        $this->db->where('parameter_id', 'INCOME_TYPE');
        $this->db->where_not_in('name', CONCEPT_CARD_NAME);
        $query = $this->db->get('parameters')->result_array();
        return $query;
    }

    public function get_income_type($income_type_id)
    {
        $this->db->reset_query();
        $this->db->select('code as income_type_id, name');
        $this->db->where('parameter_id', 'INCOME_TYPE');
        $this->db->where('code', $income_type_id);
        $query = $this->db->get('parameters')->row_array();
        return $query;
    }

    public function get_income_type_name($income_type_id)
    {
        $query = $this->db->get_where('parameters', array('parameter_id' => 'INCOME_TYPE', 'code' => $income_type_id))->row();
        return $query->name;
    }

    public function get_transaction_types()
    {
        $this->db->reset_query();
        $this->db->select('code as transaction_type_id, name');
        $this->db->where('parameter_id', 'TRANSACTION_TYPE');
        $query = $this->db->get('parameters')->result_array();
        return $query;
    }

    public function get_transaction_type($transaction_type_id)
    {
        $this->db->reset_query();
        $this->db->select('code as transaction_type_id, name');
        $this->db->where('parameter_id', 'TRANSACTION_TYPE');
        $this->db->where('code', $transaction_type_id);
        $query = $this->db->get('parameters')->row_array();
        return $query;
    }

    public function get_transaction_type_name($transaction_type_id)
    {
        $query = $this->db->get_where('parameters', array('parameter_id' => 'TRANSACTION TYPE', 'code' => $transaction_type_id))->row();
        return $query->name;
    }

    public function get_credit_cards()
    {
        $this->db->reset_query();
        $this->db->select('code as creditcard_id, name, value_2 as fee');
        $this->db->where('parameter_id', 'CREDITCARD_TYPE');
        $query = $this->db->get('parameters')->result_array();
        return $query;
    }

    public function get_credit_card($creditcard_id)
    {
        $this->db->reset_query();
        $this->db->select('code as creditcard_id, name, value_2 as fee');
        $this->db->where('parameter_id', 'CREDITCARD_TYPE');
        $this->db->where('code', $creditcard_id);
        $query = $this->db->get('parameters')->row_array();
        return $query;
    }

    public function get_credit_card_name($creditcard_id)
    {
        $query = $this->db->get_where('parameters', array('parameter_id' => 'CREDITCARD_TYPE', 'code' => $creditcard_id))->row();
        return $query->name;
    }

    public function get_credit_card_fee($creditcard_id)
    {
        $fee = 0;

        $query = $this->db->get_where('parameters', array('parameter_id' => 'CREDITCARD_TYPE', 'code' => $creditcard_id))->row();
        $fee = floatval($query->value_2);

        return  $fee;
    }

    public function get_discount_types()
    {
        $this->db->reset_query();
        $this->db->select('code as discount_id, name');
        $this->db->where('parameter_id', 'DISCOUNT_TYPE');
        $query = $this->db->get('parameters')->result_array();
        return $query;
    }

    public function get_discount_types_by_user($user_type)
    {
        $this->db->reset_query();
        $this->db->select('code as discount_id, name');
        switch ($user_type) {
            case 'student':
                $this->db->where('value_1', '1');
                break;
            case 'applicant':
                $this->db->where('value_2', '1');
                break;
        }
        $this->db->where('parameter_id', 'DISCOUNT_TYPE');
        $query = $this->db->get('parameters')->result_array();
        return $query;
    }

    public function get_discount_type($discount_id)
    {
        $this->db->reset_query();
        $this->db->select('code as discount_id, name');
        $this->db->where('parameter_id', 'DISCOUNT_TYPE');
        $this->db->where('code', $discount_id);
        $query = $this->db->get('parameters')->row_array();
        return $query;
    }

    public function get_discount_type_name($discount_id)
    {
        $query = $this->db->get_where('parameters', array('parameter_id' => 'DISCOUNT_TYPE', 'code' => $discount_id))->row();
        return $query->name;
    }
    
    public function get_next_invoice_number()
    {
        $this->db->reset_query();
        $this->db->select('invoice_number');
        $this->db->order_by('invoice_number', 'DESC');
        $invoice_number = floatval($this->db->get('payment')->first_row()->invoice_number);


        return str_pad(($invoice_number + 1),  8, '0', STR_PAD_LEFT);   
        
    }

    public function get_payment_schedule_statuses()
    {
        $this->db->reset_query();
        $this->db->select('code as status_id, name, value_1 as color');
        $this->db->where('parameter_id', 'PAYMENT_SCHEDULE_STATUS');
        $query = $this->db->get('parameters')->result_array();
        return $query;
    }

    public function get_payment_schedule_status_info($status_id)
    {
        $this->db->reset_query();
        $this->db->select('code as status_id, name, value_1 as color');
        $this->db->where('parameter_id', 'PAYMENT_SCHEDULE_STATUS');
        $this->db->where('code', $status_id);
        $query = $this->db->get('parameters')->row_array();
        return $query;
    }

    public function get_payment_schedule_status_name($status_id)
    {
        $this->db->reset_query();
        $this->db->select('name');
        $this->db->where('parameter_id', 'PAYMENT_SCHEDULE_STATUS');
        $this->db->where('code', $status_id);
        $query = $this->db->get('parameters')->row();
        return $query->name;
    }

}