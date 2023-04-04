<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    
class Payments extends EduAppGT
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
        $this->load->library('session');
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        $this->load->library('paystack_lib');
        $this->load->helper('string');
        $this->load->library('flutterwave_lib');
        $this->runningYear = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
    }
    
    public function paypal($invoiceId = ''){
        if (get_account_type() != 'student' && get_account_type() != 'parent')
        {
            redirect(base_url(), 'refresh');
        }
        $this->payment->payWithPayPal($invoiceId);
    }
    
    function paypal_success()
    {
        $type = get_account_type();
        $this->payment->paypalSuccess();
        $this->session->set_flashdata('flash_message' , getPhrase('thanks_for_your_payment'));
        if($type == 'parent'){
            redirect(base_url() . 'parents/invoice/', 'refresh');
        }else{
            redirect(base_url() . 'student/invoice/', 'refresh');
        }
    }
    
    public function stripe($invoiceId){
        if (get_account_type() != 'student' && get_account_type() != 'parent')
        {
            redirect(base_url(), 'refresh');
        }
        $stripe_data = json_decode($this->db->get_where('payment_gateways', array('name' => 'stripe'))->row()->settings);
        $page['invoice_id'] = base64_decode($invoiceId);
        $page['stripe_data'] = $stripe_data;
        $page['stripe_amount'] = $this->db->get_where('invoice' , array('invoice_id' => base64_decode($invoiceId)))->row()->amount;
        $this->load->view('backend/gateways/stripe', $page);
    }
    
    public function stripe_success($invoiceId)
    {
        $type = get_account_type();
        if($this->input->post('stripeToken') != ''){
            $data['payment_details']   = $this->input->post('stripeToken');
            $data['payment_timestamp'] = strtotime(date("m/d/Y"));
            $data['payment_method']    = 'stripe';
            $data['status']            = 'completed';   
            $this->db->where('invoice_id', $invoiceId);
            $this->db->update('invoice', $data);

            $table      = 'invoice';
            $action     = 'update';
            $update_id  = $invoiceId;
            $this->crud->save_log($table, $action, $update_id, $data);

            $data2['method']       =   'stripe';
            $data2['invoice_id']   =   $invoiceId;
            $data2['timestamp']    =   strtotime(date("m/d/Y"));
            $data2['payment_type'] =   'income';
            $data2['title']        =   $this->db->get_where('invoice' , array('invoice_id' => $invoiceId))->row()->title;
            $data2['description']  =   $this->db->get_where('invoice' , array('invoice_id' => $invoiceId))->row()->description;
            $data2['student_id']   =   $this->db->get_where('invoice' , array('invoice_id' => $invoiceId))->row()->student_id;
            $data2['amount']       =   $this->db->get_where('invoice' , array('invoice_id' => $invoiceId))->row()->amount;
            $this->db->insert('payment' , $data2);

            $table      = 'payment';
            $action     = 'insert';
            $insert_id  = $this->db->insert_id();
            $this->crud->save_log($table, $action, $insert_id, $data2);

        }
        $this->session->set_flashdata('flash_message' , getPhrase('thanks_for_your_payment'));
        if($type == 'parent'){
            redirect(base_url() . 'parents/invoice/', 'refresh');
        }else{
            redirect(base_url() . 'student/invoice/', 'refresh');
        }
    }
    
    public function razorpay($invoiceId){
        if (get_account_type() != 'student' && get_account_type() != 'parent')
        {
            redirect(base_url(), 'refresh');
        }
        $razorpay_data = json_decode($this->db->get_where('payment_gateways', array('name' => 'razorpay'))->row()->settings);
        $page['invoice_id'] = base64_decode($invoiceId);
        $page['razorpay_data']   = $razorpay_data;
        $page['razorpay_amount'] = $this->db->get_where('invoice' , array('invoice_id' => base64_decode($invoiceId)))->row()->amount;
        $this->load->view('backend/gateways/razorpay', $page);
    }
    
    function razorpay_callback()
    {
        $razorpay_data = json_decode($this->db->get_where('payment_gateways', array('name' => 'razorpay'))->row()->settings);
        $type = get_account_type();
        if (!empty($this->input->post('razorpay_payment_id')) && !empty($this->input->post('merchant_order_id'))) 
        {
            $inv = explode('-',$this->input->post('merchant_order_id'));
            $invoiceId = $inv[0];
            $razorpay_payment_id = $this->input->post('razorpay_payment_id');
            $merchant_order_id = $this->input->post('merchant_order_id');
            
            $this->session->set_flashdata('razorpay_payment_id', $this->input->post('razorpay_payment_id'));
            $this->session->set_flashdata('merchant_order_id', $this->input->post('merchant_order_id'));
            $currency_code = $razorpay_data->currency;
            $amount = $this->input->post('merchant_total');
            $success = false;
            $error = '';
            try {                
                $ch = $this->curl_handler($razorpay_payment_id, $amount);
                $result = curl_exec($ch);
                $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($result === false) {
                    $success = false;
                    $error = 'Curl error: '.curl_error($ch);
                } else {
                    $response_array = json_decode($result, true);
                        if ($http_status === 200 and isset($response_array['error']) === false) {
                            $success = true;
                        } else {
                            $success = false;
                            if (!empty($response_array['error']['code'])) {
                                $error = $response_array['error']['code'].':'.$response_array['error']['description'];
                            } else {
                                $error = 'RAZORPAY_ERROR:Invalid Response <br/>'.$result;
                            }
                        }
                }
                curl_close($ch);
            } catch (Exception $e) {
                $success = false;
                $error = 'Request to Razorpay Failed';
            }
            
            if ($success === true) {
                $data['payment_details']   = $this->input->post('razorpay_payment_id');
                $data['payment_timestamp'] = strtotime(date("m/d/Y"));
                $data['payment_method']    = 'razorpay';
                $data['status']            = 'completed';   
                $this->db->where('invoice_id', $invoiceId);
                $this->db->update('invoice', $data);

                $table      = 'invoice';
                $action     = 'update';
                $update_id  = $invoiceId;
                $this->crud->save_log($table, $action, $update_id, $data);
                
                $data2['method']       =   'razorpay';
                $data2['invoice_id']   =   $invoiceId;
                $data2['timestamp']    =   strtotime(date("m/d/Y"));
                $data2['payment_type'] =   'income';
                $data2['title']        =   $this->db->get_where('invoice' , array('invoice_id' => $invoiceId))->row()->title;
                $data2['description']  =   $this->db->get_where('invoice' , array('invoice_id' => $invoiceId))->row()->description;
                $data2['student_id']   =   $this->db->get_where('invoice' , array('invoice_id' => $invoiceId))->row()->student_id;
                $data2['amount']       =   $this->db->get_where('invoice' , array('invoice_id' => $invoiceId))->row()->amount;
                $this->db->insert('payment' , $data2);

                $table      = 'payment';
                $action     = 'insert';
                $insert_id  = $this->db->insert_id();
                $this->crud->save_log($table, $action, $insert_id, $data2);
            
                $this->session->set_flashdata('flash_message' , getPhrase('thanks_for_your_payment'));
                if($type == 'parent'){
                    redirect(base_url() . 'parents/invoice/', 'refresh');
                }else{
                    redirect(base_url() . 'student/invoice/', 'refresh');
                }
            }else {
                $this->session->set_flashdata('flash_message' , getPhrase('payment_failed'));
                if($type == 'parent'){
                    redirect(base_url() . 'parents/invoice/', 'refresh');
                }else{
                    redirect(base_url() . 'student/invoice/', 'refresh');
                }
            }
        } else {
            echo 'An error occured. Contact site administrator, please!';
        }
    }
    
    private function curl_handler($payment_id, $amount)  
    {
        $razorpay_data = json_decode($this->db->get_where('payment_gateways', array('name' => 'razorpay'))->row()->settings);
        if($razorpay_data->test_mode == 1){
            $key_id         = $razorpay_data->test_key_id;
            $key_secret     = $razorpay_data->test_key_secret;
        }else{
            $key_id         = $razorpay_data->production_key_id;
            $key_secret     = $razorpay_data->production_key_secret;
        }
        $url            = 'https://api.razorpay.com/v1/payments/'.$payment_id.'/capture';
        $fields_string  = "amount=$amount";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, $key_id.':'.$key_secret);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        return $ch;
    }
    
    public function paystack($invoiceId = '')
    {
        if (get_account_type() != 'student' && get_account_type() != 'parent')
        {
            redirect(base_url(), 'refresh');
        }
        
        $amount = $this->db->get_where('invoice' , array('invoice_id' => base64_decode($invoiceId)))->row()->amount;
        $payment_amount = $amount * 100;
        $studentId = $this->db->get_where('invoice' , array('invoice_id' => base64_decode($invoiceId)))->row()->student_id;
        $user_email = $this->db->get_where('student' , array('student_id' => $studentId))->row()->email;
        $payment_reference = base64_decode($invoiceId).'-'.random_string('md5');
        $this->paystack_lib->add_field('email', $user_email);
        $this->paystack_lib->add_field('amount', $payment_amount);
        $this->paystack_lib->add_field('callback_url', base_url().'payments/paystack_verify');
        $this->paystack_lib->add_field('reference', $payment_reference);
        $this->paystack_lib->ps_auto_form();
    }
    
    public function paystack_verify()
    {
        $type = get_account_type();
        if ($_GET['trxref'] OR $_GET['reference'])
        {
            $inv = explode('-',$_GET['reference']);
            $invoiceId = $inv[0];
            $reference = ($_GET['trxref']) ? $_GET['trxref'] : $_GET['reference'];
            $ps_api_response = $this->paystack_lib->verify_transaction($reference);
            if (array_key_exists('data', $ps_api_response) && array_key_exists('status', $ps_api_response['data']) && ($ps_api_response['data']['status'] === 'success')) 
            {
                $data['payment_details']   = html_escape($_GET['reference']);
                $data['payment_timestamp'] = strtotime(date("m/d/Y"));
                $data['payment_method']    = 'paystack';
                $data['status']            = 'completed';   
                $this->db->where('invoice_id', $invoiceId);
                $this->db->update('invoice', $data);

                $table      = 'invoice';
                $action     = 'update';
                $update_id  = $invoiceId;
                $this->crud->save_log($table, $action, $update_id, $data);

                $data2['method']       =   'paystack';
                $data2['invoice_id']   =   $invoiceId;
                $data2['timestamp']    =   strtotime(date("m/d/Y"));
                $data2['payment_type'] =   'income';
                $data2['title']        =   $this->db->get_where('invoice' , array('invoice_id' => $invoiceId))->row()->title;
                $data2['description']  =   $this->db->get_where('invoice' , array('invoice_id' => $invoiceId))->row()->description;
                $data2['student_id']   =   $this->db->get_where('invoice' , array('invoice_id' => $invoiceId))->row()->student_id;
                $data2['amount']       =   $this->db->get_where('invoice' , array('invoice_id' => $invoiceId))->row()->amount;
                $this->db->insert('payment' , $data2);

                $table      = 'payment';
                $action     = 'insert';
                $insert_id  = $this->db->insert_id();
                $this->crud->save_log($table, $action, $insert_id, $data2);
            
                $this->session->set_flashdata('flash_message' , getPhrase('thanks_for_your_payment'));
                if($type == 'parent'){
                    redirect(base_url() . 'parents/invoice/', 'refresh');
                }else{
                    redirect(base_url() . 'student/invoice/', 'refresh');
                }
            } 
            else
            {
                $this->session->set_flashdata('flash_message' , getPhrase('payment_failed'));
                if($type == 'parent'){
                    redirect(base_url() . 'parents/invoice/', 'refresh');
                }else{
                    redirect(base_url() . 'student/invoice/', 'refresh');
                }
            } 
        }
        else 
        {
            redirect(base_url());
        }
    }
    
    public function flutterwave($invoiceId = '')
    {
        $type = get_account_type();
        if (get_account_type() != 'student' && get_account_type() != 'parent')
        {
            redirect(base_url(), 'refresh');
        }
        $amount = $this->db->get_where('invoice' , array('invoice_id' => base64_decode($invoiceId)))->row()->amount;
        $student_id = $this->db->get_where('invoice' , array('invoice_id' => base64_decode($invoiceId)))->row()->student_id;
        $email = $this->db->get_where('student' , array('student_id' => $student_id))->row()->email;
		$data = array(
			'amount' => $amount,
			'customer_email' => $email,
			'redirect_url' => base_url("payments/flutterwave_status"),
			'payment_plan' => base64_decode($invoiceId)
		);
		$this->response = $this->flutterwave_lib->create_payment($data);
		if(!empty($this->response) || $this->response != ''){
			$this->response = json_decode($this->response,1);
			if(isset($this->response['status']) && $this->response['status'] == 'success'){
                redirect($this->response['data']['link']);
			}else{
				$this->session->set_flashdata('flash_message' , getPhrase('payment_failed'));
                if($type == 'parent'){
                    redirect(base_url() . 'parents/invoice/', 'refresh');
                }else{
                    redirect(base_url() . 'student/invoice/', 'refresh');
                }
			}
		}
    }
    
    public function flutterwave_status()
	{
	    $type = get_account_type();
		if(isset($_GET['txref']) && !empty($_GET['txref'])){
			$response = $this->flutterwave_lib->verify_transaction($_GET['txref']);
			if(!empty($response)){
				$response = json_decode($response,1);
				if($response['status'] == 'success' && isset($response['data']['chargecode']) && ( $response['data']['chargecode'] == '00' || $response['data']['chargecode'] == '0') )
				{
					$invoiceId    = $response['data']['paymentplan'];
					$update_data['payment_details']   = json_encode($response);
                    $update_data['payment_timestamp'] = strtotime(date("m/d/Y"));
                    $update_data['payment_method']    = 'flutterwave';
                    $update_data['status']            = 'completed';   
                    $this->db->where('invoice_id', $invoiceId);
                    $this->db->update('invoice', $update_data);

                    $table      = 'invoice';
                    $action     = 'update';
                    $update_id  = $invoiceId;
                    $this->crud->save_log($table, $action, $update_id, $update_data);

                    $insert_data['method']       =   'flutterwave';
                    $insert_data['invoice_id']   =   $invoiceId;
                    $insert_data['timestamp']    =   strtotime(date("m/d/Y"));
                    $insert_data['payment_type'] =   'income';
                    $insert_data['title']        =   $this->db->get_where('invoice' , array('invoice_id' => $invoiceId))->row()->title;
                    $insert_data['description']  =   $this->db->get_where('invoice' , array('invoice_id' => $invoiceId))->row()->description;
                    $insert_data['student_id']   =   $this->db->get_where('invoice' , array('invoice_id' => $invoiceId))->row()->student_id;
                    $insert_data['amount']       =   $this->db->get_where('invoice' , array('invoice_id' => $invoiceId))->row()->amount;
                    $this->db->insert('payment' , $insert_data);

                    $table      = 'payment';
                    $action     = 'insert';
                    $insert_id  = $this->db->insert_id();
                    $this->crud->save_log($table, $action, $insert_id, $insert_data);

					$this->session->set_flashdata('flash_message' , getPhrase('thanks_for_your_payment'));
					
				}elseif( (isset($_GET['cancelled']) && $_GET['cancelled'] == true))
				{
					$this->session->set_flashdata('flash_message' , getPhrase('payment_cancelled_by_user'));
				}
				elseif( $response['status'] == 'error')
				{
					$this->session->set_flashdata('flash_message' , getPhrase('payment_failed'));
				}
			}else{
				$this->session->set_flashdata('flash_message' , getPhrase('payment_failed'));
			}
		}
        if($type == 'parent'){
            redirect(base_url() . 'parents/invoice/', 'refresh');
        }else{
            redirect(base_url() . 'student/invoice/', 'refresh');
        }
	}

    public function manual_payment_process($user_id, $user_type)
    {
        $this->isLogin();

        $this->payment->create_payment($user_id, $user_type);
        
        $message =  getPhrase('successfully_added');
        
        if($user_type == 'student')
        {
            $page_data['student_id'] =  $user_id;
            $page_data['page_name']  = 'student_payments';
            $page_data['page_title'] =  getPhrase('student_payments');
        }
        else
        {
            $page_data['applicant_id'] =  $user_id;
            $page_data['page_name']  = 'applicant_payments';
            $page_data['page_title'] =  getPhrase('applicant_payments');
        }       
        
        $this->session->set_flashdata('flash_message' , $message);
        $this->load->view('backend/index', $page_data);
    }
    
    public function update_amortization_status($amortization_id)
    {
        echo '<pre>';
        var_dump($this->payment->update_amortization_status_delete($amortization_id));
        echo '</pre>';
    }

    public function delete($param1, $return_url)
    {
        $this->isLogin();
        $payment_id = base64_decode($param1);
        $this->payment->delete_payment($payment_id);

        redirect(base_url() . base64_decode($return_url), 'refresh');
    }

    public function update($param1, $return_url = '')
    {
        $this->isLogin();
        $payment_id = base64_decode($param1);
        $this->payment->update_payment($payment_id);
        redirect(base_url() . base64_decode($return_url), 'refresh');
    }

    function isLogin()
    {
        $array      = ['admin', 'accountant'];
        $login_type = get_account_type();
        
        if (!in_array($login_type, $array))
        {
            redirect(base_url(), 'refresh');
        }
    }

}