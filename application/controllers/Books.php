<?php
if (!defined('BASEPATH'))
{
    exit('No direct script access allowed');
}

class Books extends EduAppGT
{
    /*
        Software:       MySchool - School Management System
        Author:         DHCoder - Software, Web and Mobile developer.
        Author URI:     https://dhcoder.com
        PHP:            5.6+
        Created:        22 September 2021.
    */

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    }

    //Index function.
    public function index()
    {
        echo "Hola";
    }

    //Live classes function.
    function basic  ($task = "", $document_id = "")
    {
        $this->isLogged();

        $data['page_name']      = 'basic';
        $data['data']           = $task;
        $data['page_title']     = getPhrase('basic');
        $this->load->view('backend/books/', $data);
    }

    //Check student session.
    function isLogged()
    {
        if ($this->session->userdata('student_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
    }
    
}