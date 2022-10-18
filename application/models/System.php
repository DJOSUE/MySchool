<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class System extends School 
{
    
    function __construct() 
    {
        parent::__construct();
        $this->load->database();

    }

    function role_create()
    {        
        $data['name']   = html_escape($this->input->post('name'));
        $data['table']  = html_escape($this->input->post('table'));

        $this->db->reset_query();
        $this->db->insert('roles', $data);

        $table      = 'roles';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);

        return $insert_id;
    }

    function role_update($role_id)
    {
        $data['name']   = html_escape($this->input->post('name'));
        $data['table']  = html_escape($this->input->post('table'));

        $this->db->reset_query();
        $this->db->where('role_id', $role_id);
        $this->db->update('roles', $data);

        $table      = 'roles';
        $action     = 'update';
        $insert_id  = $role_id;
        $this->crud->save_log($table, $action, $insert_id, $data);

        return $insert_id;
    }

    function role_delete($role_id)
    {
        $data['action'] = 'delete';
        
        $this->db->reset_query();
        $this->db->where('role_id', $role_id);
        $this->db->delete('roles');

        $table      = 'roles';
        $action     = 'delete';
        $insert_id  = $role_id;

        $this->crud->save_log($table, $action, $insert_id, $data);

        return $insert_id;
    }

    function get_role_info($role_id)
    {
        $role = $this->db->get_where('roles', array('role_id' => $role_id))->result_array();
        return $role;
    }

    function get_admins_role()
    {
        $this->db->order_by('name', 'ASC');
        $roles = $this->db->get_where('roles', array('status' => 1, 'table' => 'admin', 'role_id !=' => '1' ))->result_array();
        return $roles;
    }
    
    function get_role_name($role_id)
    {
        $role = $this->db->get_where('roles', array('role_id' => $role_id))->row_array();
        return $role['name'];
    }

    function account_role_add()
    {
        $data['role_id']        = html_escape($this->input->post('role_id'));
        $data['type']           = html_escape($this->input->post('type'));
        $data['permissions']    = html_escape($this->input->post('permissions'));

        $this->db->reset_query();
        $this->db->insert('account_role', $data);

        $table      = 'account_role';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);

        return $insert_id;
    }

    function account_role_update($account_role_id)
    {
        $data['role_id']        = html_escape($this->input->post('role_id'));
        $data['type']           = html_escape($this->input->post('type'));
        $data['permissions']    = html_escape($this->input->post('permissions'));

        $this->db->reset_query();
        $this->db->where('account_role_id', $account_role_id);
        $this->db->update('account_role', $data);

        $table      = 'account_role';
        $action     = 'update';
        $insert_id  = $account_role_id;
        $this->crud->save_log($table, $action, $insert_id, $data);

        return $insert_id;
    }

    function account_role_delete($account_role_id)
    {
        $data['action'] = 'delete';

        $this->db->reset_query();
        $this->db->where('account_role_id', $account_role_id);
        $this->db->delete('account_role');

        $table      = 'account_role';
        $action     = 'delete';
        $insert_id  = $account_role_id;

        $this->crud->save_log($table, $action, $insert_id, $data);

        return $insert_id;
    }

    function get_parameters_id()
    {
        $query =  $this->db->query("SELECT DISTINCT(parameter_id) FROM `parameters`")->result_array();
        return $query;
    }

}