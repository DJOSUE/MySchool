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

if ( ! function_exists('has_permission'))
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

if ( ! function_exists('is_super_admin'))
{
    function is_super_admin($admin_id = ''){
        $CI	=&	get_instance();
		$CI->load->database();

        if (empty($admin_id)) {
            $admin_id = $CI->session->userdata('admin_id');
        }
        
        $owner_status = $CI->db->get_where('admin', array('admin_id' => $admin_id))->row()->owner_status;

        if($owner_status == 1){
            return true;
        }
        else{
            return false;
        }

        return false;
    }
}
