<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends EduAppGT
{
    /*
        Software:       MySchool - School Management System
        Author:         DHCoder - Software, Web and Mobile developer.
        Author URI:     https://dhcoder.com
        PHP:            5.6+
        Created:        22 September 2021.
        Base:           EduAppGT
    */

    private $runningYear     = '';
    private $runningSemester = '';
    private $account_type = '';
    private $role_id = 0;

    
	function __construct()
	{
		parent::__construct();
		$this->load->database();
        $this->load->library('session');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');

        $this->runningYear      = $this->crud->getInfo('running_year'); 
        $this->runningSemester  = $this->crud->getInfo('running_semester'); 
        $this->account_type       =   $this->session->userdata('login_type'); 
        $this->role_id = $this->session->userdata('role_id');
    }
    
    //Index function.
    public function index()
    {
        $this->isLogin();
        echo 'test';
    }

    //Check session function.
    function isLogin($permission_for = '')
    {
        $array      = ['admin', 'accountant'];
        $login_type = $this->session->userdata('login_type');
        
        if (!in_array($login_type, $array))
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if($permission_for != '')
        {
            check_permission($permission_for);
        }
    }

/***** Accounting Reports *******************************************************************************************************************************/
    function report_dashboard()
    {
        
    }
    
/***** Academic Reports   *******************************************************************************************************************************/
/***** Advisors Reports   *******************************************************************************************************************************/
/***** President Reports  *******************************************************************************************************************************/


}