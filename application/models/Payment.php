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
    }
    
    
    
    
}