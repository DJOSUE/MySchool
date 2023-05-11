<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Document extends School 
{    
    private $runningYear = '';
    private $runningSemester = '';
    
    function __construct() 
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->runningYear = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $this->runningSemester = $this->db->get_where('settings' , array('type' => 'running_semester'))->row()->description;
        $this->load->library('excel');
    }

    function create_student_document($student_id)
    {
        

        $data['created_by']         = get_login_user_id();
        $data['created_by_type']    = get_table_user(get_role_id());        
        $data['name']           = html_escape($this->input->post('doc_name'));
        $data['type_id']            = html_escape($this->input->post('type_id'));
        $data['student_id']         = $student_id;

        if($_FILES['document_file']['name'] != '')
        {
            $md5 = md5(date('d-m-Y H:i:s'));

            $data['file_name']  = $md5.str_replace(' ', '', $_FILES['document_file']['name']); 
            move_uploaded_file($_FILES['document_file']['tmp_name'], PATH_STUDENT_DOCUMENTS . $md5.str_replace(' ', '', $_FILES['document_file']['name']));
        }
       
        $this->db->insert('student_documents', $data);

        $table      = 'student_documents';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);

        return $insert_id;
    }

    function delete_student_document($document_id)
    {
        $this->db->reset_query();
        $this->db->where('document_id', $document_id);
        $this->db->delete('student_documents');

        $table      = 'student_documents';
        $action     = 'delete';
        
        $this->crud->save_log($table, $action, $document_id, []);
    }    

    function get_student_documents($student_id)
    {
        $this->db->reset_query();        
        $this->db->where('student_id', $student_id);
        $documents = $this->db->get('student_documents')->result_array();

        return $documents;
    }
    

    // Get the list Types of documents
    public function get_types()
    {
        $this->db->reset_query();
        $this->db->select('code as type_id, name, value_1 as icon');
        $this->db->where('parameter_id', 'DOCUMENT_TYPE');
        $query = $this->db->get('parameters')->result_array();;
        
        return $query;
    }

    public function get_type_info($type_id)
    {
        $this->db->reset_query();
        $this->db->select('code as type_id, name, value_1 as icon');
        $this->db->where('parameter_id', 'DOCUMENT_TYPE');
        $this->db->where('code', $type_id);
        $query = $this->db->get('parameters')->row_array();
        
        return $query;
    }

    public function get_type_name($type_id)
    {
        $this->db->reset_query();
        $this->db->select('code as type_id, name, value_1 as icon');
        $this->db->where('parameter_id', 'DOCUMENT_TYPE');
        $this->db->where('code', $type_id);
        $query = $this->db->get('parameters')->row_array();
        
        return $query['name'];
    }
}
