<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
    
    class Calendar extends EduAppGT
    {
        /*
            Software:       MySchool - School Management System
            Author:         DHCoder - Software, Web and Mobile developer.
            Author URI:     https://dhcoder.com
            PHP:            5.6+
            Created:        22 September 2021.
        */
        private $runningYear = '';
    
        function __construct()
        {
            parent::__construct();
            $this->load->library('session');
            $this->load->database();
            $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
            $this->output->set_header('Pragma: no-cache');    
            $this->runningYear = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        }
        
        function hex2rgba($color, $opacity = false) {
 
	$default = 'rgb(0,0,0)';
 
	//Return default if no color provided
	if(empty($color))
          return $default; 
 
	//Sanitize $color if "#" is provided 
        if ($color[0] == '#' ) {
        	$color = substr( $color, 1 );
        }
 
        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
                return $default;
        }
 
        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);
 
        //Check if opacity is set(rgba or rgb)
        if($opacity){
        	if(abs($opacity) > 1)
        		$opacity = 1.0;
        	$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
        	$output = 'rgb('.implode(",",$rgb).')';
        }
 
        //Return rgb(a) color string
        return $output;
}
        
        //Index function for Calendar controller.
        public function index()
        {
            redirect(base_url(), 'refresh');
        }
        
        function getEvents(){
            if(get_account_type() == '')
            {
                exit;
            }
            $events = $this->db->get('events')->result_array();
            $response = array();
            foreach($events as $event)
            { 
                $start = explode(" ", $event['start']);
                $end = explode(" ", $event['end']);
                if($start[1] == '00:00:00'){
                    $start = $start[0];
                }else{
                    $start = $event['start'];
                }
                if($end[1] == '00:00:00'){
                    $end = $end[0];
                }else{
                    $end = $event['end'];
                }
                $data['title'] = $event['title'];
                $data['id']    = $event['id'];
                $data['start'] = $start;
                $data['end']   = $end;
                $data['classNames'] = $event['color'];
                array_push($response, $data);
            }
            echo json_encode($response);
        }
        
        
    }