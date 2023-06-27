<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('check_permission')) {
    function check_permission($permission_for)
    {
        $CI    = &get_instance();
        $CI->load->database();

        if (!has_permission($permission_for)) {
            $CI->session->set_flashdata('flash_message', getPhrase('you_are_not_authorized_to_access_this_page'));
            redirect(site_url('/'), 'refresh');
        }
    }
}

if (!function_exists('has_permission'))
{
    function has_permission($permission_for, $role_id = ''){
        $CI	=&	get_instance();
		$CI->load->database();

        if (empty($role_id)) {
            $role_id = get_role_id();
        }

        $CI->db->where('role_id', $role_id);
        $CI->db->where('type', $permission_for);
        $has_permission = $CI->db->get('account_role')->row()->permissions;

        if(is_super_admin()){
            return true;
        }
        else
        {
            if($has_permission == 1){
                return true;
            }
            else{
                return false;
            }
        }

    } 
}

if (!function_exists('is_super_admin'))
{
    function is_super_admin($admin_id = ''){
        $CI	=&	get_instance();
		$CI->load->database();

        if (empty($admin_id)) {
            $admin_id = get_admin_id();
        }
        
        $admin = $CI->db->get_where('admin', array('admin_id' => $admin_id))->row();

        if($admin->owner_status == 1 && ( in_array($admin->username, SYSADMIN_LIST))) {
            return true;
        } else {
            return false;
        }

        return false;
    }
}


if (!function_exists('academic_option_visible'))
{
    function option_visible($option){
        $CI	=&	get_instance();
		$CI->load->database();

        $query = $CI->db->get_where('academic_settings', array('type' => $option))->row();
        
        if($query->description == 1){
            return true;
        }
        else{
            return false;
        }
    } 
}

if (!function_exists('menu_option_visible'))
{
    function menu_option_visible($option){
        $CI	=&	get_instance();
		$CI->load->database();

        $query = $CI->db->get_where('menu_option', array('code' => $option))->row();
        
        if($query->show == 1){
            return true;
        }
        else{
            return false;
        }
    } 
}

if (!function_exists('compress'))
{
    function compress($source, $destination, $quality){
        $info = getimagesize($source);

        if ($info['mime'] == 'image/jpeg') 
            $image = imagecreatefromjpeg($source);
    
        elseif ($info['mime'] == 'image/gif') 
            $image = imagecreatefromgif($source);
    
        elseif ($info['mime'] == 'image/png') 
            $image = imagecreatefrompng($source);
    
        imagejpeg($image, $destination, $quality);
    
        return $destination;
    } 
}

if (!function_exists('is_student'))
{
    function is_student($applicant_id)
    {
        $CI	=&	get_instance();
		$CI->load->database();

        $query = $CI->db->get_where('applicant', array('applicant_id' => $applicant_id))->row();
        
        // 3 = student
        if($query->status == 3){
            return true;
        }
        else{
            return false;
        }
    } 
}

if (!function_exists('is_international'))
{
    function is_international($applicant_id)
    {
        $CI	=&	get_instance();
		$CI->load->database();

        $query = $CI->db->get_where('applicant', array('applicant_id' => $applicant_id))->row();
        
        // 3 = student
        if($query->type_id == 1){
            return true;
        }
        else{
            return false;
        }
    } 
}

if (!function_exists('generate_token'))
{
    function generate_token()
    {
        $url = ADMISSION_PLATFORM_URL.'login?email=victor.ochoa@americanone-esl.com&password=victor.ochoa';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response_json = curl_exec($ch);
        curl_close($ch);
        $response=json_decode($response_json, true);

        return $response['token'];
    } 
}

if (!function_exists('get_table_user'))
{
    function get_table_user($role_id)
    {
        $CI	=&	get_instance();
		$CI->load->database();
        $CI->db->reset_query();
        $query = $CI->db->get_where('roles', array('role_id' => $role_id))->row();
        return $query->table;
    } 
}

if(!function_exists('calculate_age'))
{
    function calculate_age($birthDate)
    {
        $birthDate = str_replace("-", "-", $birthDate);

		//explode the date to get month, day and year
		$birthDate = explode("/", $birthDate);
                
		//get age from date or birthdate
		$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
		? ((date("Y") - $birthDate[2]) - 1)
		: (date("Y") - $birthDate[2]));
        
		return $age;
    }
}

if (!function_exists('get_settings')) {
    function get_settings($key = '')
    {
        $CI    = &get_instance();
        $CI->load->database();
        
        $CI->db->where('type', $key);
        $result = $CI->db->get('settings')->row()->description;
        return $result;
    }
}

if(!function_exists('get_encrypt'))
{
    function get_encrypt($text)
    {
        // Store the cipher method
        $ciphering = CIPHER_METHOD;
        $options = 0;

        // Non-NULL Initialization Vector for encryption 1234567891011121
        $encryption_iv = ENCRYPTION_IV;

        // Store the encryption key
        $encryption_key = ENCRYPTION_KEY;

        // Use openssl_encrypt() function to encrypt the data
        $encryption = openssl_encrypt($text, $ciphering, $encryption_key, $options, $encryption_iv);

		return $encryption;
    }
}

if(!function_exists('get_decrypt'))
{
    function get_decrypt($encryption)
    {
        // Store the cipher method
        $ciphering = CIPHER_METHOD;
        $options = 0;
        
        // Non-NULL Initialization Vector for decryption
        $decryption_iv = ENCRYPTION_IV;

        // Store the decryption key
        $decryption_key = ENCRYPTION_KEY;

        // Use openssl_decrypt() function to decrypt the data
        $decryption = openssl_decrypt ($encryption, $ciphering, $decryption_key, $options, $decryption_iv);

		return $decryption;
    }
}

if(!function_exists('ordinal'))
{
    function ordinal($number) {
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if ((($number % 100) >= 11) && (($number%100) <= 13))
            return $number. 'th';
        else
            return $number. $ends[$number % 10];
    }
}

if(!function_exists('get_month_name'))
{
    function get_month_name($monthNum) {

        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F'); // March

        return $monthName;
    }
}

if(!function_exists('get_admin_id'))
{
    function get_admin_id() 
    {
        $CI	=&	get_instance();

        return $CI->session->userdata('user_data')['admin_id'];
    }
}

if(!function_exists('get_admin_login'))
{
    function get_admin_login() 
    {
        $CI	=&	get_instance();

        return $CI->session->userdata('user_data')['admin_login'];
    }
}

if(!function_exists('get_teacher_login'))
{
    function get_teacher_login() 
    {
        $CI	=&	get_instance();

        return $CI->session->userdata('user_data')['teacher_login'];
    }
}

if(!function_exists('get_student_login'))
{
    function get_student_login() 
    {
        $CI	=&	get_instance();

        return $CI->session->userdata('user_data')['student_login'];
    }
}

if(!function_exists('get_accountant_login'))
{
    function get_accountant_login() 
    {
        $CI	=&	get_instance();

        return $CI->session->userdata('user_data')['accountant_login'];
    }
}

if(!function_exists('get_account_type'))
{
    function get_account_type() 
    {
        $CI	=&	get_instance();

        return $CI->session->userdata('user_data')['login_type'];
    }
}

if(!function_exists('get_role_id'))
{
    function get_role_id() 
    {
        $CI	=&	get_instance();

        return $CI->session->userdata('user_data')['role_id'];
    }
}

if(!function_exists('get_login_user_id'))
{
    function get_login_user_id() 
    {
        $CI	=&	get_instance();

        return $CI->session->userdata('user_data')['login_user_id'];
    }
}

if(!function_exists('get_name_user_login'))
{
    function get_name_user_login() 
    {
        $CI	=&	get_instance();

        return $CI->session->userdata('user_data')['name'];
    }
}


if(!function_exists('get_program_id'))
{
    function get_program_id() 
    {
        $CI	=&	get_instance();

        return $CI->session->userdata('user_data')['program_id'];
    }
}

/**
 * 
 * 
 * $monthNum  = 3;
 * $dateObj   = DateTime::createFromFormat('!m', $monthNum);
 * $monthName = $dateObj->format('F'); // March
 */