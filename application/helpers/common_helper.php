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
            $role_id = $CI->session->userdata('role_id');
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
            $admin_id = $CI->session->userdata('admin_id');
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