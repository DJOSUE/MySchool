<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Academic extends School 
{
    private $runningYear = '';
    private $runningSemester = '';
    private $useDailyMarks = false;
    private $roundPrecision = 0;
    
    function __construct() 
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('excel');
        
        $this->runningYear      = $this->crud->getInfo('running_year'); 
        $this->runningSemester  = $this->crud->getInfo('running_semester'); 
        $this->useDailyMarks    = $this->crud->getInfo('use_daily_marks');
        $this->roundPrecision   = $this->crud->getInfo('round_precision');
    }
    
    function countOnlineExams($class_id,$section_id,$subject_id){
        $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $match = array('year' => $running_year, 'class_id' => $class_id, 'section_id' => $section_id,'subject_id' => $subject_id, 'status' => 'published');
        $exams = $this->db->where($match)->get('online_exam')->num_rows();
        return $exams;
    }
    
    public function countHomeworks($class_id,$section_id,$subject_id){
        $homeworks = $this->db->get_where('homework', array('class_id' => $class_id, 'status' => 1, 'section_id' => $section_id, 'subject_id' => $subject_id))->num_rows();
        return $homeworks;
    }

    public function countForums($class_id,$section_id,$subject_id){
        $forums = $this->db->get_where('forum', array('class_id' => $class_id, 'section_id' => $section_id, 'post_status' => 1, 'subject_id' => $subject_id))->num_rows();
        return $forums;
    }
    
    public function countMaterial($class_id,$section_id,$subject_id){
        $study_material = $this->db->get_where('document', array('class_id' => $class_id, 'section_id' => $section_id, 'subject_id' => $subject_id))->num_rows();
        return $study_material;
    }
    
    public function countLive($class_id,$section_id,$subject_id){
        $this->db->where('class_id', $class_id);
        $this->db->where('section_id', $section_id);
        $this->db->where('subject_id', $subject_id);
        $lives = $this->db->get('live')->num_rows();
        return $lives;
    }
    
    //SetRead
    public function setRead($code,$type,$subject_id)
    {
        $year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $userId    = $this->session->userdata('login_user_id');
        $check = $this->db->get_where('activity_read', array('student_id' => $userId, 'subject_activity_id' => $code,'activity_type' => $type, 'subject_id' => $subject_id, 'year' => $year));
        if($check->num_rows() == 0){
            $data['student_id']          = $userId;
            $data['subject_id']          = $subject_id;
            $data['subject_activity_id'] = $code;
            $data['date']                = $this->crud->getDateFormat().' '.date('h:i A');
            $data['year']                = $year;
            $data['activity_type']       = $type;
            $this->db->insert('activity_read',$data);

            $table      = 'activity_read';
            $action     = 'insert';
            $insert_id  = $this->db->insert_id();
            $this->crud->save_log($table, $action, $insert_id, $data);

        }
    }
    
    //GetRead
    public function getRead($code,$type,$subject_id){
        $year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $this->db->limit(5);
        $this->db->order_by('actividy_read_id', 'RANDOM');
        $check = $this->db->get_where('activity_read', array('subject_activity_id' => $code, 'activity_type' => $type, 'subject_id' => $subject_id, 'year' => $year))->result_array();
        return $check;
    }
    
    //Create Live Class.
    public function createLiveClass()
    {
        $data['user_type']      = $this->session->userdata('login_type');
        $data['title']          = html_escape($this->input->post('title'));
        $data['liveType']       = $this->input->post('livetype');   
        if($this->input->post('livetype') == '2'){
            $data['siteUrl']    = $this->input->post('siteUrl');   
        }
        $data['description']    = html_escape($this->input->post('description'));
        $data['upload_date']    = $this->crud->getDateFormat().' '.date('H:iA');
        $data['date']           = html_escape($this->input->post('start_date'));
        $data['time']           = html_escape($this->input->post('start_time'));
        $data['publish_date']   = date('Y-m-d H:i:s');
        $data['year']           = $this->runningYear;
        $data['semester_id']    = $this->runningSemester;
        $data['room']           =  md5(date('d-m-Y H:i:s')).substr(md5(rand(100000000, 200000000)), 0, 10);
        $data['wall_type']      = 'live';
        $data['class_id']       = $this->input->post('class_id');
        $data['subject_id']     = $this->input->post('subject_id');
        $data['section_id']     = $this->input->post('section_id');
        $data['user_id']        = $this->session->userdata('login_user_id');
        $this->db->insert('live',$data);

        $table      = 'live';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);

    }
    
    public function updateLiveClass($liveId)
    {
        $data['title']             = html_escape($this->input->post('title'));
        $data['description']       = html_escape($this->input->post('description'));
        if($this->input->post('livetype') == '2'){
            $data['siteUrl']       = $this->input->post('siteUrl');   
        }
        $data['date']              = html_escape($this->input->post('start_date'));
        $data['time']              = html_escape($this->input->post('start_time'));
        $data['wall_type']         = 'live';
        $this->db->where('live_id', $liveId);
        $this->db->update('live',$data);  

        $table      = 'live';
        $action     = 'update';
        $update_id  = $liveId;
        $this->crud->save_log($table, $action, $update_id, $data);

    }
    
    public function deleteLiveClass($liveId)
    {
        $this->db->where('live_id', $liveId);
        $this->db->delete('live');
    }
    
    public function createLevel()
    {
        $data['name']        = html_escape($this->input->post('name'));
        $data['grade_point'] = html_escape($this->input->post('point'));
        $data['mark_from']   = html_escape($this->input->post('from'));
        $data['mark_upto']   = html_escape($this->input->post('to'));
        $this->db->insert('grade', $data);

        $table      = 'grade';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);

    }   
    
    public function updateLevel($levelId)
    {
        $data['name']        = html_escape($this->input->post('name'));
        $data['grade_point'] = html_escape($this->input->post('point'));
        $data['mark_from']   = html_escape($this->input->post('from'));
        $data['mark_upto']   = html_escape($this->input->post('to'));
        $this->db->where('grade_id', $levelId);
        $this->db->update('grade', $data);

        $table      = 'grade';
        $action     = 'update';
        $update_id  = $levelId;
        $this->crud->save_log($table, $action, $update_id, $data);

    }
    
    public function deleteLevel($levelId)
    {
        $this->db->where('grade_id', $levelId);
        $this->db->delete('grade');
    }

    public function createGPA()
    {
        $data['name']       = $this->input->post('name');
        $data['gpa_point']  = $this->input->post('gpa_point');
        $data['mark_from']  = $this->input->post('from');
        $data['mark_upto']  = $this->input->post('to');
        $this->db->insert('gpa', $data);

        $table      = 'gpa';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);
    }

    public function updateGPA($gpaID)
    {
        $data['name']       = $this->input->post('name');
        $data['gpa_point']  = $this->input->post('gpa_point');
        $data['mark_from']  = $this->input->post('from');
        $data['mark_upto']  = $this->input->post('to');
        $this->db->where('gpa_id', $gpaID);
        $this->db->update('gpa', $data);

        $table      = 'gpa';
        $action     = 'update';
        $update_id  = $gpaID;
        $this->crud->save_log($table, $action, $update_id, $data);
    }
    
    public function deleteGPA($gpaID)
    {
        $this->db->where('gpa_id', $gpaID);
        $this->db->delete('gpa');
    }
    
    public function deleteDelivery($Id)
    {
        $this->db->where('id',$Id);
        $this->db->delete('deliveries');
    }
    
    public function acceptBook($bookId)
    {
        $data['status'] = 1;
        $this->db->update('book_request', $data, array('book_request_id' => $bookId));
        $book_id        = $this->db->get_where('book_request', array('book_request_id' => $bookId))->row()->book_id;
        $issued_copies  = $this->db->get_where('book', array('book_id' => $book_id))->row()->issued_copies;
        $data2['issued_copies'] = $issued_copies + 1;
        $this->db->update('book', $data2, array('book_id' => $book_id));
    }
    
    public function rejectBook($bookId)
    {
        $data['status'] = 2;
        $this->db->update('book_request', $data, array('book_request_id' => $bookId));
    }
    
    public function deleteOnlineExam($examId)
    {
        $this->db->where('online_exam_id', $examId);
        $this->db->delete('online_exam');
    }
    
    public function createHomework()
    {
        $data['title']          = html_escape($this->input->post('title'));
        $data['description']    = html_escape($this->input->post('description'));
        $data['time_end']       = $this->input->post('time_end');
        $data['date_end']       = $this->input->post('date_end');
        $data['type']           = $this->input->post('type');
        $data['wall_type']      = 'homework';
        $data['publish_date']   = date('Y-m-d H:i:s');
        $data['upload_date']    = $this->crud->getDateFormat().' '.date('H:iA');
        $data['year']           = $this->runningYear;
        $data['semester_id']    = $this->runningSemester;
        $data['status']         = $this->input->post('status');
        $data['class_id']       = $this->input->post('class_id');
        $data['file_name']      = $_FILES["file_name"]["name"];
        $data['section_id']     = $this->input->post('section_id');
        $data['user']           = $this->session->userdata('login_type');
        $data['subject_id']     = $this->input->post('subject_id');
        $data['uploader_type']  = $this->session->userdata('login_type');
        $data['uploader_id']    = $this->session->userdata('login_user_id');
        $data['homework_code']  = substr(md5(rand(100000000, 200000000)), 0, 10);
        $this->db->insert('homework', $data);

        $table      = 'homework';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);

        move_uploaded_file($_FILES["file_name"]["tmp_name"], "public/uploads/homework/" . $_FILES["file_name"]["name"]);
        $this->crud->send_homework_notify();
        $homework_code = $data['homework_code'];
        $notify['notify'] = "<strong>".$this->crud->get_name($this->session->userdata('login_type'),$this->session->userdata('login_user_id'))."</strong>". " ". getPhrase('new_homework_notify') ." <b>".html_escape($this->input->post('title'))."</b>";
        $students = $this->db->get_where('enroll', array('class_id' => $this->input->post('class_id'), 'section_id' => $this->input->post('section_id'), 'year' => $this->runningYear))->result_array();
        foreach($students as $row)
        {
            $notify['user_id']       = $row['student_id'];
            $notify['user_type']     = 'student';
            $notify['url']           = "student/homeworkroom/".$homework_code;
            $notify['date']          = $this->crud->getDateFormat();
            $notify['time']          = date('h:i A');
            $notify['status']        = 0;
            $notify['type']          = 'homework';
            $notify['class_id']      = $this->input->post('class_id');
            $notify['section_id']    = $this->input->post('section_id');
            $notify['year']          = $this->runningYear;
            $notify['semester_id']   = $this->runningSemester;
            $notify['subject_id']    = $this->input->post('subject_id');
            $notify['original_id']   = $this->session->userdata('login_user_id');
            $notify['original_type'] = $this->session->userdata('login_type');
            $this->db->insert('notification', $notify);

            $table      = 'notification';
            $action     = 'insert';
            $insert_id  = $this->db->insert_id();
            $this->crud->save_log($table, $action, $insert_id, $notify);
        }
        return $homework_code;
    }
    
    public function updateHomework($homework_code)
    {
        $data['title']       = html_escape($this->input->post('title'));
        $data['description'] = html_escape($this->input->post('description'));
        $data['time_end']    = html_escape($this->input->post('time_end'));
        $data['date_end']    = html_escape($this->input->post('date_end'));
        $data['user']        = $this->session->userdata('login_type');
        $data['status']      = $this->input->post('status');
        $data['type']        = $this->input->post('type');
        $this->db->where('homework_code', $homework_code);
        $this->db->update('homework', $data);

        $table      = 'homework';
        $action     = 'update';
        $update_id  = $homework_code;
        $this->crud->save_log($table, $action, $update_id, $data);
    }
    
    public function reviewHomework()
    {
        $id      = $this->input->post('answer_id');
        $mark    = html_escape($this->input->post('mark'));
        $comment = html_escape($this->input->post('comment'));
        $entries = sizeof($mark);
        for($i = 0; $i < $entries; $i++) 
        {
            $data['mark']            = $mark[$i];
            $data['teacher_comment'] = $comment[$i];
            $this->db->where_in('id', $id[$i]);
            $this->db->update('deliveries', $data);

            $table      = 'deliveries';
            $action     = 'update';
            $update_id  = $id[$i];
            $this->crud->save_log($table, $action, $update_id, $data);
            
        }
    }
    
    public function singleHomework()
    {
        $student_id  = $this->db->get_where('deliveries', array('id' => $this->input->post('id')))->row()->student_id;
        $code        = $this->db->get_where('deliveries', array('id' => $this->input->post('id')))->row()->homework_code;
        $title       = $this->db->get_where('homework', array('homework_code' => $code))->row()->title;

        $data['teacher_comment'] = html_escape($this->input->post('comment'));
        $data['mark']            = html_escape($this->input->post('mark'));
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('deliveries', $data);

        $table      = 'deliveries';
        $action     = 'update';
        $update_id  = $this->input->post('id');
        $this->crud->save_log($table, $action, $update_id, $data);

        $notify['notify']        = "<strong>". $this->crud->get_name($this->session->userdata('login_type'), $this->session->userdata('login_user_id'))."</strong>". " ". getPhrase('homework_rated') ." <b>".$title.".</b>";
        $notify['user_id']       = $student_id;
        $notify['user_type']     = 'student';
        $notify['date']          = $this->crud->getDateFormat();
        $notify['time']          = date('h:i A');
        $notify['url']           = "student/homeworkroom/".$code;
        $notify['status']        = 0;
        $notify['original_id']   = $this->session->userdata('login_user_id');
        $notify['original_type'] = $this->session->userdata('login_type');
        $this->db->insert('notification', $notify);

        $table      = 'notification';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $notify);
    }
    
    public function createForum()
    {
        $data['title']           = html_escape($this->input->post('title'));
        $data['description']     = html_escape($this->input->post('description'));
        $data['class_id']        = $this->input->post('class_id');
        $data['type']            = $this->session->userdata('login_type');
        $data['section_id']      = $this->input->post('section_id');
        if($this->input->post('post_status') != "1"){
            $data['post_status'] = 0;
        }else{
            $data['post_status'] = $this->input->post('post_status');   
        }
        $data['publish_date']    = date('Y-m-d H:i:s');
        $data['upload_date']     = $this->crud->getDateFormat().' '.date('H:iA');
        $data['wall_type']       = "forum";
        $data['timestamp']       = $this->crud->getDateFormat().' '.date("H:iA");
        $data['subject_id']      = $this->input->post('subject_id');
        $data['file_name']       = $_FILES["userfile"]["name"];
        $data['teacher_id']      = $this->session->userdata('login_user_id');
        $data['post_code']       = substr(md5(rand(100000000, 200000000)), 0, 10);
        $this->db->insert('forum', $data);

        $table      = 'forum';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);

        $this->crud->send_forum_notify();
        move_uploaded_file($_FILES["userfile"]["tmp_name"], "public/uploads/forum/" . $_FILES["userfile"]["name"]);
    }
    
    public function updateForum($code)
    {
        if($this->input->post('post_status') != "1"){
            $data['post_status'] = 0;
        }else{
            $data['post_status'] = $this->input->post('post_status');   
        }
        $data['title']           = html_escape($this->input->post('title'));
        $data['description']     = html_escape($this->input->post('description'));
        $data['type']            = $this->session->userdata('login_type');
        $data['timestamp']       = $this->crud->getDateFormat().' '.date("H:iA");
        $data['teacher_id']      = $this->session->userdata('login_user_id');
        $this->db->where('post_code', $code);
        $this->db->update('forum', $data);

        $table      = 'forum';
        $action     = 'update';
        $update_id  = $code;
        $this->crud->save_log($table, $action, $update_id, $data);
    }
    
    public function createMaterial()
    {
        $data['type']              = $this->session->userdata('login_type');
        $data['timestamp']         = strtotime(date("Y-m-d H:i:s"));
        $data['title']             = html_escape($this->input->post('title'));
        $data['description']       = html_escape($this->input->post('description'));
        $data['upload_date']       = $this->crud->getDateFormat().' '.date('H:iA');
        $data['publish_date']      = date('Y-m-d H:i:s');
        $data['file_name']         = str_replace(" ", "",$_FILES["file_name"]["name"]);
        $data['filesize']          = $this->crud->formatBytes($_FILES["file_name"]["size"]);
        $data['wall_type']         = 'material';
        $data['file_type']         = $this->input->post('file_type');
        $data['class_id']          = $this->input->post('class_id');
        $data['subject_id']        = $this->input->post('subject_id');
        $data['section_id']        = $this->input->post('section_id');
        $data['teacher_id']        = $this->session->userdata('login_user_id');
        $data['year']              = $this->runningYear;
        $data['semester_id']       = $this->runningSemester;
        $this->db->insert('document',$data);

        $table      = 'document';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);

        move_uploaded_file($_FILES["file_name"]["tmp_name"], "public/uploads/document/" . str_replace(" ", "",$_FILES["file_name"]["name"]));
        
        $notify['notify'] = "<strong>".$this->crud->get_name($this->session->userdata('login_type'), $this->session->userdata('login_user_id'))."</strong> ". " ".getPhrase('study_material_notify');
        $students = $this->db->get_where('enroll', array('class_id' => $this->input->post('class_id'),'section_id' => $this->input->post('section_id'), 'year' => $this->runningYear))->result_array();
        foreach($students as $row)
        {
            $notify['user_id']       = $row['student_id'];
            $notify['user_type']     = 'student';
            $notify['url']           = "student/study_material/".base64_encode($this->input->post('class_id').'-'.$this->input->post('section_id').'-'.$this->input->post('subject_id'));
            $notify['date']          = $this->crud->getDateFormat();
            $notify['time']          = date('h:i A');
            $notify['type']          = 'material';
            $notify['status']        = 0;
            $notify['year']          = $this->runningYear;
            $notify['class_id']      = $this->input->post('class_id');
            $notify['section_id']    = $this->input->post('section_id');
            $notify['subject_id']    = $this->input->post('subject_id');
            $notify['original_id']   = $this->session->userdata('login_user_id');
            $notify['original_type'] = $this->session->userdata('login_type');
            $this->db->insert('notification', $notify);

            $table      = 'notification';
            $action     = 'insert';
            $insert_id  = $this->db->insert_id();
            $this->crud->save_log($table, $action, $insert_id, $notify);

        }
    }
    
    public function update_online_exam()
    {
        $ts  = explode(':',$this->input->post('time_start'));
        $nts = count($ts);
        $te  = explode(':',$this->input->post('time_end'));
        $nte = count($te);
        $data['title']              = html_escape($this->input->post('exam_title'));
        $data['class_id']           = $this->input->post('class_id');
        $data['section_id']         = $this->input->post('section_id');
        $data['results']            = $this->input->post('results');
        $data['show_random']        = $this->input->post('show_random');
        $data['subject_id']         = $this->input->post('subject_id');
        $data['minimum_percentage'] = html_escape($this->input->post('minimum_percentage'));
        $data['instruction']        = html_escape($this->input->post('instruction'));
        $data['password']           = html_escape($this->input->post('password'));
        $data['exam_date']          = strtotime(html_escape($this->input->post('exam_date')));
        if($nts == 3){
            $data['time_start']         = $this->input->post('time_start');   
        }else{
            $data['time_start']         = $this->input->post('time_start').':00';
        }
        if($nte == 3){
            $data['time_end']         = $this->input->post('time_end');   
        }else{
            $data['time_end']         = $this->input->post('time_end').':00';
        }
        $data['duration']           = strtotime(date('Y-m-d', $data['exam_date']).' '.$data['time_end']) - strtotime(date('Y-m-d', $data['exam_date']).' '.$data['time_start']);

        $this->db->where('online_exam_id', $this->input->post('online_exam_id'));
        $this->db->update('online_exam', $data);
        
        $table      = 'online_exam';
        $action     = 'update';
        $update_id  = $this->input->post('online_exam_id');
        $this->crud->save_log($table, $action, $update_id, $data);
    }
    
    public function createOnlineExam()
    {
        $data['publish_date']       = date('Y-m-d H:i:s');
        $data['uploader_type']      = $this->session->userdata('login_type');
        $data['wall_type']          = "exam";
        $data['uploader_id']        = $this->session->userdata('login_user_id');
        $data['upload_date']        = $this->crud->getDateFormat().' '.date('H:iA');
        $data['password']           = html_escape($this->input->post('password'));
        $data['show_random']        = $this->input->post('show_random');
        $data['results']            = $this->input->post('results');
        $data['code']               = substr(md5(uniqid(rand(), true)), 0, 7);
        $data['title']              = html_escape($this->input->post('exam_title'));
        $data['class_id']           = $this->input->post('class_id');
        $data['section_id']         = $this->input->post('section_id');
        $data['subject_id']         = $this->input->post('subject_id');
        $data['minimum_percentage'] = html_escape($this->input->post('minimum_percentage'));
        $data['instruction']        = html_escape($this->input->post('instruction'));
        $data['exam_date']          = strtotime(html_escape($this->input->post('exam_date')));
        $data['time_start']         = html_escape($this->input->post('time_start').":00");
        $data['time_end']           = html_escape($this->input->post('time_end').":00");
        $data['duration']           = strtotime(date('Y-m-d', $data['exam_date']).' '.$data['time_end']) - strtotime(date('Y-m-d', $data['exam_date']).' '.$data['time_start']);
        $data['year']               = $this->runningYear;
        $data['semester_id']        = $this->runningSemester;
        
        $this->crud->send_exam_notify();
        $this->db->insert('online_exam', $data);

        $table      = 'online_exam';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);
    }
    
    public function promoteStudents()
    {
        $running_year                =   $this->input->post('running_year');  
        $from_class_id               =   $this->input->post('promotion_from_class_id'); 
        $from_section_id             =   $this->input->post('promotion_from_section_id'); 
        $students_of_promotion_class =   $this->db->get_where('enroll' , array('class_id' => $from_class_id, 'section_id' => $from_section_id , 'year' => $running_year))->result_array();
        foreach($students_of_promotion_class as $row) 
        {
            $enroll_data['enroll_code']     =   substr(md5(rand(0, 1000000)), 0, 7);
            $enroll_data['student_id']      =   $row['student_id'];
            $enroll_data['section_id']      =   $this->input->post('promotion_status_section_'.$row['student_id']);
            $enroll_data['class_id']        =   $this->input->post('promotion_status_'.$row['student_id']);
            $enroll_data['year']            =   $this->input->post('promotion_year');
            $enroll_data['date_added']      =   strtotime(date("Y-m-d H:i:s"));
            $this->db->insert('enroll' , $enroll_data);

            $table      = 'enroll';
            $action     = 'insert';
            $insert_id  = $this->db->insert_id();
            $this->crud->save_log($table, $action, $insert_id, $enroll_data);
        } 
    }
    
    public function createCourse($year = '', $semesterId = '')
    {
        $md5 = md5(date('d-m-y H:i:s'));
        $data['name']        = html_escape($this->input->post('name'));
        $data['about']       = html_escape($this->input->post('about'));
        $data['class_id']    = $this->input->post('class_id');
        $data['section_id']  = $this->input->post('section_id');
        $data['color']       = $this->input->post('color');
        $data['icon']        = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
        $data['teacher_id']  = $this->input->post('teacher_id');
        $data['year']        = $year == '' ? $this->runningYear : $year;
        $data['semester_id'] = $semesterId == '' ? $this->runningSemester : $semesterId;
        $this->db->insert('subject', $data);

        $table      = 'subject';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);

        move_uploaded_file($_FILES['userfile']['tmp_name'], 'public/uploads/subject_icon/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
    }

    public function createSubject($year = '', $semesterId = '')
    {
        $md5 = md5(date('d-m-y H:i:s'));
        $data['name']               = html_escape($this->input->post('new_name'));
        $data['about']              = html_escape($this->input->post('new_about'));
        $data['class_id']           = html_escape($this->input->post('new_class_id'));
        $data['section_id']         = html_escape($this->input->post('new_section_id'));
        $data['color']              = html_escape($this->input->post('new_color'));
        $data['icon']               = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
        $data['modality_id']        = html_escape($this->input->post('modality_id'));
        $data['teacher_id']         = html_escape($this->input->post('new_teacher_id'));
        $data['subject_capacity']   = html_escape($this->input->post('subject_capacity'));
        
        $data['year']        = $year == '' ? $this->runningYear : $year;
        $data['semester_id'] = $semesterId == '' ? $this->runningSemester : $semesterId;

        $this->db->insert('subject', $data);

        $table      = 'subject';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);

        move_uploaded_file($_FILES['userfile']['tmp_name'], 'public/uploads/subject_icon/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));
    }
    
    public function updateCourseActivity($courseId)
    {
        $class_id = $this->db->get_where('subject', array('subject_id' => $courseId))->row()->class_id;
        $data['la1'] = html_escape($this->input->post('la1'));
        $data['la2'] = html_escape($this->input->post('la2'));
        $data['la3'] = html_escape($this->input->post('la3'));
        $data['la4'] = html_escape($this->input->post('la4'));
        $data['la5'] = html_escape($this->input->post('la5'));
        $data['la6'] = html_escape($this->input->post('la6'));
        $data['la7'] = html_escape($this->input->post('la7'));
        $data['la8'] = html_escape($this->input->post('la8'));
        $data['la9'] = html_escape($this->input->post('la9'));
        $data['la10'] = html_escape($this->input->post('la10'));
        $this->db->where('subject_id', $courseId);
        $this->db->update('subject', $data);

        $table      = 'subject';
        $action     = 'update';
        $update_id  = $courseId;
        $this->crud->save_log($table, $action, $update_id, $data);
    }
    
    public function updateCourse($courseId)
    {
        $class_id           = $this->db->get_where('subject', array('subject_id' => $courseId))->row()->class_id;
        $md5                =  md5(date('d-m-y H:i:s'));
        $data['color']      = $this->input->post('color');
        if($_FILES['userfile']['size'] > 0){
            $data['icon']   = $md5.str_replace(' ', '', $_FILES['userfile']['name']);
        }
        $data['name']       = html_escape($this->input->post('name'));
        $data['about']      = html_escape($this->input->post('about'));
        $data['teacher_id'] = $this->input->post('teacher_id');
        $this->db->where('subject_id', $courseId);
        $this->db->update('subject', $data);
        move_uploaded_file($_FILES['userfile']['tmp_name'], 'public/uploads/subject_icon/' . $md5.str_replace(' ', '', $_FILES['userfile']['name']));

        $table      = 'subject';
        $action     = 'update';
        $update_id  = $courseId;
        $this->crud->save_log($table, $action, $update_id, $data);

    }
    
    public function deleteCourse($courseId)
    {
        $this->db->where('subject_id', $courseId);
        $this->db->delete('subject');
    }
    
    public function createClass()
    {
        $data['name']         = html_escape($this->input->post('name'));
        $data['teacher_id']   = $this->input->post('teacher_id');
        $this->db->insert('class', $data);
        $class_id = $this->db->insert_id();
        $data2['class_id']    =   $class_id;
        $data2['name']        =   'A';
        $this->db->insert('section' , $data2);

        $table      = 'section';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data2);

    }
    
    public function updateClass($classId)
    {
        $data['name']         = html_escape($this->input->post('name'));
        $data['teacher_id']   = $this->input->post('teacher_id');
        $this->db->where('class_id', $classId);
        $this->db->update('class', $data);

        $table      = 'class';
        $action     = 'update';
        $update_id  = $classId;
        $this->crud->save_log($table, $action, $update_id, $data);
    }
    
    public function deleteClass($classId)
    {
        $this->db->where('class_id', $classId);
        $this->db->delete('class');
    }
    
    public function createSection($year = '', $semesterId = '')
    {   

        $data['name']           =   html_escape($this->input->post('name'));
        $data['class_id']       =   $this->input->post('class_id');
        $data['teacher_id']     =   $this->input->post('teacher_id');
        $data['year']           =   $year == '' ? $this->runningYear : $year;
        $data['semester_id']    =   $semesterId == '' ? $this->runningSemester : $semesterId;
        $this->db->insert('section' , $data);

        $table      = 'section';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);
    }
    
    public function updateSection($sectionId){
        $data['name']       = html_escape($this->input->post('name'));
        $data['teacher_id'] = $this->input->post('teacher_id');
        $this->db->where('section_id', $sectionId);
        $this->db->update('section', $data);

        $table      = 'section';
        $action     = 'update';
        $update_id  = $sectionId;
        $this->crud->save_log($table, $action, $update_id, $data);
    }
    
    public function deleteSection($sectionId)
    {
        $this->db->where('section_id' , $sectionId);
        $this->db->delete('section');
    }
    
    public function createUnit()
    {
        $data['name']    = $this->input->post('name');
        $this->db->insert('units', $data);

        $table      = 'units';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);
    }
    
    public function updateUnit($unitId)
    {
        $data['name']    = $this->input->post('name');
        $this->db->where('unit_id', $unitId);
        $this->db->update('units', $data);

        $table      = 'units';
        $action     = 'update';
        $update_id  = $unitId;
        $this->crud->save_log($table, $action, $update_id, $data);

    }
    
    public function deleteUnit($unitId)
    {
        $this->db->where('unit_id', $unitId);
        $this->db->delete('units');
    }

    public function createSemester()
    {
        $data['name']    = $this->input->post('name');
        $this->db->insert('semesters', $data);

        $table      = 'semesters';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);
    }
    
    public function updateSemester($semesterId)
    {
        $data['name']    = $this->input->post('name');
        $this->db->where('semester_id', $semesterId);
        $this->db->update('semesters', $data);

        $table      = 'semesters';
        $action     = 'update';
        $update_id  = $semesterId;
        $this->crud->save_log($table, $action, $update_id, $data);
    }
    
    public function deleteSemester($semesterId)
    {
        $this->db->where('semester_id', $semesterId);
        $this->db->delete('semesters');
    }
    
    public function createReport()
    {
        $parent_id           = $this->db->get_where('student', array('student_id' => $this->input->post('student_id')))->row()->parent_id;
        $student_name        = $this->db->get_where('student', array('student_id' => $this->input->post('student_id')))->row()->name;
        $parent_phone        = $this->db->get_where('parent', array('parent_id' => $parent_id))->row()->phone;
        $parent_email        = $this->db->get_where('parent', array('parent_id' => $parent_id))->row()->email;
        $data['student_id']  = $this->input->post('student_id');
        $data['class_id']    = $this->input->post('class_id');
        $data['section_id']  = $this->input->post('section_id');
        $data['user_id']     = $this->session->userdata('login_type')."-".$this->session->userdata('login_user_id');
        $data['title']       = html_escape($this->input->post('title'));
        $data['description'] = html_escape($this->input->post('description'));
        $data['file']        = $_FILES["file_name"]["name"];
        $data['date']        = $this->crud->getDateFormat();
        $data['priority']    = $this->input->post('priority');
        $data['status']      = 0;
        $data['code']        = substr(md5(rand(0, 1000000)), 0, 7);
        $this->db->insert('reports', $data);

        $table      = 'reports';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);

        $this->crud->students_reports($this->input->post('student_id'),$parent_id);
        move_uploaded_file($_FILES["file_name"]["tmp_name"], 'public/uploads/report_files/'. $_FILES["file_name"]["name"]);
        
        $notify = $this->db->get_where('settings' , array('type' => 'students_reports'))->row()->description;
        if($notify == 1)
        {
            $message = getPhrase('behavioral_report_has_been_created_for')." " . $student_name;
            $sms_status = $this->db->get_where('settings' , array('type' => 'sms_status'))->row()->description;
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
    }
    
    public function reportResponse()
    {
        $data['report_code'] = $this->input->post('report_code');
        $data['message']     = html_escape($this->input->post('message'));
        $data['date']        = $this->crud->getDateFormat();
        $data['sender_type'] = $this->session->userdata('login_type');
        $data['sender_id']   = $this->session->userdata('login_user_id');
        $this->db->insert('report_response', $data);

        $table      = 'report_response';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        return $this->crud->save_log($table, $action, $insert_id, $data);

    }
    
    public function updateReport($code)
    {
        $notify['notify'] =  "<b>".$this->db->get_where('reports', array('code' => $code))->row()->title."</b>"." ". getPhrase('report_solved');
        $user       = $this->db->get_where('reports', array('code' => $code))->row()->user_id;
        $final      = explode("-", $user);
        $user_type  = $final[0];
        $user_id    = $final[1];
        $student_id = $this->db->get_where('reports', array('code' => $code))->row()->student_id;
        $parent_id  = $this->db->get_where('student', array('student_id' => $student_id))->row()->parent_id;

        $notify['user_id']       = $user_id;
        $notify['user_type']     = $user_type;
        $notify['url']           = $user_type."/view_report/".$code;
        $notify['date']          = $this->crud->getDateFormat();
        $notify['time']          = date('h:i A');
        $notify['status']        = 0;
        $notify['original_id']   = $this->session->userdata('login_user_id');
        $notify['original_type'] = $this->session->userdata('login_type');
        $this->db->insert('notification', $notify);

        $table      = 'notification';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $notify);

        $notify2['notify']        = $notify['notify'];
        $notify2['user_id']       = $parent_id;
        $notify2['user_type']     = 'parent';
        $notify2['url']           = "parents/view_report/".$code;
        $notify2['date']          = $this->crud->getDateFormat();
        $notify2['time']          = date('h:i A');
        $notify2['status']        = 0;
        $notify2['original_id']   = $this->session->userdata('login_user_id');
        $notify2['original_type'] = $this->session->userdata('login_type');
        $this->db->insert('notification', $notify2);

        $table      = 'notification';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $notify2);

        $data['status']           = 1;
        $this->db->where('code', $code);
        $this->db->update('reports', $data);

        $table      = 'reports';
        $action     = 'update';
        $update_id  = $code;
        $this->crud->save_log($table, $action, $update_id, $data);
    }
    
    function getInfo($type) {
        $query = $this->db->get_where('academic_settings', array('type' => $type));
        return $query->row()->description;
    }
    
    public function createRoutine()
    {
        $data['class_id']       = $this->input->post('class_id');
        if($this->input->post('section_id') != '') 
        {
            $data['section_id'] = $this->input->post('section_id');
        }
        $subject_id = $this->input->post('subject_id');
        $teacher_id = $this->db->get_where('subject', array('subject_id' => $subject_id))->row()->teacher_id;
        $data['subject_id']     = $this->input->post('subject_id');
        $data['time_start']     = html_escape($this->input->post('time_start'));
        $data['time_end']       = html_escape($this->input->post('time_end'));
        $data['classroom_id']   = $this->input->post('classroom_id');
        $data['time_start_min'] = html_escape($this->input->post('time_start_min'));
        $data['time_end_min']   = html_escape($this->input->post('time_end_min'));
        $data['day']            = $this->input->post('day');
        $data['amend']          = $this->input->post('ending_ampm');
        $data['amstart']        = $this->input->post('starting_ampm');
        $data['day']            = $this->input->post('day');
        $data['teacher_id']     = $teacher_id;
        $data['year']           = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $this->db->insert('class_routine', $data);

        $table      = 'class_routine';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);
    }
    
    public function updateRoutine($routineId)
    {
        $data['time_start']     = html_escape($this->input->post('time_start'));
        $data['time_end']       = html_escape($this->input->post('time_end'));
        $data['time_start_min'] = html_escape($this->input->post('time_start_min'));
        $data['time_end_min']   = html_escape($this->input->post('time_end_min'));
        $data['amend']          = html_escape($this->input->post('ending_ampm'));
        $data['amstart']        = html_escape($this->input->post('starting_ampm'));
        $data['classroom_id']       = $this->input->post('classroom_id');
        $data['day']            = $this->input->post('day');
        $data['year']           = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
        $this->db->where('class_routine_id', $routineId);
        $this->db->update('class_routine', $data);

        $table      = 'class_routine';
        $action     = 'update';
        $update_id  = $routineId;
        $this->crud->save_log($table, $action, $update_id, $data);
    }
    
    public function deleteRoutine($routineId)
    {
        $this->db->where('class_routine_id', $routineId);
        $this->db->delete('class_routine');
    }
    
    public function updateMarks($exam_id, $class_id, $section_id, $subject_id)
    {
        $labototal = 0;
        $marks_of_students = $this->db->get_where('mark' , array('unit_id' => $exam_id, 'class_id' => $class_id, 'section_id' => $section_id, 'year' => $this->runningYear,'subject_id' => $subject_id))->result_array();
        foreach($marks_of_students as $row) 
        {
            $count          = 0;
            $obtained_marks = 0;
            
            $labouno        = html_escape($this->input->post('lab_uno_'.$row['mark_id']));
            $labodos        = html_escape($this->input->post('lab_dos_'.$row['mark_id']));
            $labotres       = html_escape($this->input->post('lab_tres_'.$row['mark_id']));
            $labocuatro     = html_escape($this->input->post('lab_cuatro_'.$row['mark_id']));
            $labocinco      = html_escape($this->input->post('lab_cinco_'.$row['mark_id']));
            $laboseis       = html_escape($this->input->post('lab_seis_'.$row['mark_id']));
            $labosiete      = html_escape($this->input->post('lab_siete_'.$row['mark_id']));
            $laboocho       = html_escape($this->input->post('lab_ocho_'.$row['mark_id']));
            $labonueve      = html_escape($this->input->post('lab_nueve_'.$row['mark_id']));
            $labodiez       = html_escape($this->input->post('lab_diez_'.$row['mark_id']));
            $comment        = html_escape($this->input->post('comment_'.$row['mark_id']));

            // Validate values
            if($labouno     == '' ) { $labouno      = '-'; } 
            if($labodos     == '' ) { $labodos      = '-'; }  
            if($labotres    == '' ) { $labotres     = '-'; }  
            if($labocuatro  == '' ) { $labocuatro   = '-'; }  
            if($labocinco   == '' ) { $labocinco    = '-'; }
            if($laboseis    == '' ) { $laboseis     = '-'; } 
            if($labosiete   == '' ) { $labosiete    = '-'; }  
            if($laboocho    == '' ) { $laboocho     = '-'; }  
            if($labonueve   == '' ) { $labonueve    = '-'; }  
            if($labodiez    == '' ) { $labodiez     = '-'; }

            // Calculate the average 
            if(is_numeric($labouno)     && $labouno != '-' ) { $count++; } 
            if(is_numeric($labodos)     && $labodos != '-' ) { $count++; }  
            if(is_numeric($labotres)    && $labotres != '-' ) { $count++; }  
            if(is_numeric($labocuatro)  && $labocuatro != '-' ) { $count++; }  
            if(is_numeric($labocinco)   && $labocinco != '-') { $count++; }
            if(is_numeric($laboseis)    && $laboseis != '-' ) { $count++; } 
            if(is_numeric($labosiete)   && $labosiete != '-' ) { $count++; }  
            if(is_numeric($laboocho)    && $laboocho != '-' ) { $count++; }  
            if(is_numeric($labonueve)   && $labonueve != '-' ) { $count++; }  
            if(is_numeric($labodiez)    && $labodiez != '-') { $count++; }

            $labototal      = (int)$labouno + (int)$labodos + (int)$labotres + (int)$labocuatro + (int)$labocinco + (int)$laboseis + (int)$labosiete + (int)$laboocho + (int)$labonueve + (int)$labodiez;
            
            $obtained_marks = round(($labototal / $count), $this->roundPrecision);
            
            $data['mark_obtained'] = $obtained_marks;
            $data['labuno'] = $labouno;
            $data['labdos'] = $labodos;
            $data['labtres'] = $labotres;
            $data['labcuatro'] = $labocuatro;
            $data['labcinco'] = $labocinco;
            $data['labseis'] = $laboseis;
            $data['labsiete'] = $labosiete;
            $data['labocho'] = $laboocho;
            $data['labnueve'] = $labonueve;
            $data['labdiez'] = $labodiez;
            $data['labtotal'] = $labototal;
            $data['comment'] = $comment;
            

            $this->db->where('mark_id' , $row['mark_id']);
            $this->db->update('mark' , $data);
            
            $table      = 'mark';
            $action     = 'update';
            $update_id  = $row['mark_id'];
            $this->crud->save_log($table, $action, $update_id, $data);
        }
        $info = base64_encode($class_id.'-'.$section_id.'-'.$subject_id);
        return $info;
    }

    public function updateDailyMarks($exam_id, $class_id, $section_id, $subject_id, $date)
    {
        $labototal = 0;
        $marks_of_students = $this->db->get_where('mark_daily' , array(
                                                                       'class_id'    => $class_id, 
                                                                       'section_id'  => $section_id, 
                                                                       'subject_id'  => $subject_id,
                                                                       'unit_id'     => $exam_id,
                                                                       'mark_date'   => $date,
                                                                       'year'        => $this->runningYear,
                                                                       'semester_id' => $this->runningSemester
                                                  ))->result_array();
        foreach($marks_of_students as $row) 
        {
            $count          = 0;
            $obtained_marks = 0;
            
            $labouno        = html_escape($this->input->post('lab_uno_'.$row['mark_daily_id']));
            $labodos        = html_escape($this->input->post('lab_dos_'.$row['mark_daily_id']));
            $labotres       = html_escape($this->input->post('lab_tres_'.$row['mark_daily_id']));
            $labocuatro     = html_escape($this->input->post('lab_cuatro_'.$row['mark_daily_id']));
            $labocinco      = html_escape($this->input->post('lab_cinco_'.$row['mark_daily_id']));
            $laboseis       = html_escape($this->input->post('lab_seis_'.$row['mark_daily_id']));
            $labosiete      = html_escape($this->input->post('lab_siete_'.$row['mark_daily_id']));
            $laboocho       = html_escape($this->input->post('lab_ocho_'.$row['mark_daily_id']));
            $labonueve      = html_escape($this->input->post('lab_nueve_'.$row['mark_daily_id']));
            $labodiez       = html_escape($this->input->post('lab_diez_'.$row['mark_daily_id']));
            $comment        = html_escape($this->input->post('comment_'.$row['mark_daily_id']));

            // Validate values
            if($labouno     == '' ) { $labouno      = '-'; } 
            if($labodos     == '' ) { $labodos      = '-'; }  
            if($labotres    == '' ) { $labotres     = '-'; }  
            if($labocuatro  == '' ) { $labocuatro   = '-'; }  
            if($labocinco   == '' ) { $labocinco    = '-'; }
            if($laboseis    == '' ) { $laboseis     = '-'; } 
            if($labosiete   == '' ) { $labosiete    = '-'; }  
            if($laboocho    == '' ) { $laboocho     = '-'; }  
            if($labonueve   == '' ) { $labonueve    = '-'; }  
            if($labodiez    == '' ) { $labodiez     = '-'; }

            // Calculate the average 
            if(is_numeric($labouno)     && $labouno != '-' ) { $count++; } 
            if(is_numeric($labodos)     && $labodos != '-' ) { $count++; }  
            if(is_numeric($labotres)    && $labotres != '-' ) { $count++; }  
            if(is_numeric($labocuatro)  && $labocuatro != '-' ) { $count++; }  
            if(is_numeric($labocinco)   && $labocinco != '-') { $count++; }
            if(is_numeric($laboseis)    && $laboseis != '-' ) { $count++; } 
            if(is_numeric($labosiete)   && $labosiete != '-' ) { $count++; }  
            if(is_numeric($laboocho)    && $laboocho != '-' ) { $count++; }  
            if(is_numeric($labonueve)   && $labonueve != '-' ) { $count++; }  
            if(is_numeric($labodiez)    && $labodiez != '-') { $count++; }

            $labototal      = (int)$labouno + (int)$labodos + (int)$labotres + (int)$labocuatro + (int)$labocinco + (int)$laboseis + (int)$labosiete + (int)$laboocho + (int)$labonueve + (int)$labodiez;
            
            if($count > 0)
                $obtained_marks = round(($labototal / $count), $this->roundPrecision);
            else 
                $obtained_marks = '-';
            
            $data['mark_obtained'] = $obtained_marks;
            $data['labuno'] = $labouno;
            $data['labdos'] = $labodos;
            $data['labtres'] = $labotres;
            $data['labcuatro'] = $labocuatro;
            $data['labcinco'] = $labocinco;
            $data['labseis'] = $laboseis;
            $data['labsiete'] = $labosiete;
            $data['labocho'] = $laboocho;
            $data['labnueve'] = $labonueve;
            $data['labdiez'] = $labodiez;
            $data['labtotal'] = $labototal;
            $data['comment'] = $comment;

            $this->db->where('mark_daily_id' , $row['mark_daily_id']);
            $this->db->update('mark_daily' , $data);

            $table      = 'mark_daily';
            $action     = 'update';
            $update_id  = $row['mark_daily_id'];
            $this->crud->save_log($table, $action, $update_id, $data);

        }
        $info = base64_encode($class_id.'-'.$section_id.'-'.$subject_id);
        return $info;
    }
    
    public function updateDailyMarksBatch($datainfo, $student_id, $unit_id, $mark_date)
    {
        $info = base64_decode( $datainfo );
        $ex = explode( '-', $info );

        $data['class_id']    = $ex[0];
        $data['section_id']  = $ex[1];
        $data['subject_id']  = $ex[2];
        $data['year']        = $this->runningYear;
        $data['semester_id'] = $this->runningSemester;

        //$data['student_id'] = $student_id;
        if($unit_id != 'NA')
            $data['unit_id']    = $unit_id;
        if($mark_date != 'NA')
            $data['mark_date']  = $mark_date;

        $data['can_edit']   = false;

        $running_year     = $data['year'] ;
        $running_semester = $data['semester_id'];
        
        $students = $this->db->query("SELECT student_id, full_name FROM v_enroll 
                                    WHERE class_id  = '$ex[0]'
                                    AND section_id  = '$ex[1]'
                                    AND subject_id  = '$ex[2]'
                                    AND year        = '$running_year'
                                    AND semester_id = '$running_semester'                                                                                      
                                    GROUP BY student_id
                                    ORDER BY full_name
                                    "
                                )->result_array();
        
        $students_list = "";

        foreach($students as $row){
            $students_list .= $row['student_id'].", ";
        }
        $students_list = rtrim($students_list, ", ");

        // Get marks
        if($student_id != 'NA' && $unit_id != 'NA' && $mark_date != 'NA'){
            $marks = $this->db->query("SELECT *
                                        FROM v_mark_daily 
                                        WHERE class_id      = '$ex[0]'
                                            AND section_id  = '$ex[1]'
                                            AND subject_id  = '$ex[2]'
                                            AND year        = '$running_year'
                                            AND semester_id = '$running_semester'
                                            AND unit_id     = '$unit_id'
                                            AND date        = '$mark_date'
                                            AND student_id  = '$student_id'
                                            ORDER BY first_name asc
                                            ")->result_array();
        }
        else if($student_id != 'NA' && $unit_id != 'NA' && $mark_date == 'NA') {
            $marks = $this->db->query("SELECT *
                                        FROM v_mark_daily 
                                        WHERE class_id      = '$ex[0]'
                                            AND section_id  = '$ex[1]'
                                            AND subject_id  = '$ex[2]'
                                            AND year        = '$running_year'
                                            AND semester_id = '$running_semester'
                                            AND unit_id     = '$unit_id'
                                            AND student_id  = '$student_id'
                                            ORDER BY first_name asc
                                            ")->result_array();
        }
        else if($student_id != 'NA' && $unit_id == 'NA' && $mark_date != 'NA' ){
            $marks = $this->db->query("SELECT *
                                        FROM v_mark_daily 
                                        WHERE class_id      = '$ex[0]'
                                            AND section_id  = '$ex[1]'
                                            AND subject_id  = '$ex[2]'
                                            AND year        = '$running_year'
                                            AND semester_id = '$running_semester'
                                            AND date        = '$mark_date'
                                            AND student_id  = '$student_id'
                                            ORDER BY first_name asc
                                            ")->result_array();
        }
        else if($student_id != 'NA' && $unit_id == 'NA' && $mark_date == 'NA') {
            $marks = $this->db->query("SELECT *
                                        FROM v_mark_daily 
                                        WHERE class_id      = '$ex[0]'
                                            AND section_id  = '$ex[1]'
                                            AND subject_id  = '$ex[2]'
                                            AND year        = '$running_year'
                                            AND semester_id = '$running_semester'
                                            AND student_id  = '$student_id'
                                            ORDER BY first_name asc
                                            ")->result_array();
        }
        else if($student_id == 'NA' && $unit_id != 'NA' && $mark_date == 'NA'){
            $marks = $this->db->query("SELECT *
                                        FROM v_mark_daily 
                                        WHERE class_id      = '$ex[0]'
                                            AND section_id  = '$ex[1]'
                                            AND subject_id  = '$ex[2]'
                                            AND year        = '$running_year'
                                            AND semester_id = '$running_semester'
                                            AND unit_id     = '$unit_id'
                                            ORDER BY first_name asc
                                            ")->result_array();
        }
        else if($student_id == 'NA' && $unit_id != 'NA' && $mark_date != 'NA'){
            $marks = $this->db->query("SELECT *
                                        FROM v_mark_daily 
                                        WHERE class_id      = '$ex[0]'
                                            AND section_id  = '$ex[1]'
                                            AND subject_id  = '$ex[2]'
                                            AND year        = '$running_year'
                                            AND semester_id = '$running_semester'
                                            AND unit_id     = '$unit_id'
                                            AND date        = '$mark_date'
                                            ORDER BY first_name asc
                                            ")->result_array();
        }
        else if($student_id == 'NA' && $unit_id == 'NA' && $mark_date != 'NA'){
            $marks = $this->db->query("SELECT *
                                        FROM v_mark_daily 
                                        WHERE class_id      = '$ex[0]'
                                            AND section_id  = '$ex[1]'
                                            AND subject_id  = '$ex[2]'
                                            AND year        = '$running_year'
                                            AND semester_id = '$running_semester'
                                            AND date   = '$mark_date'
                                            ORDER BY first_name asc
                                            ")->result_array();
        }
        else {
            $marks = $this->db->query("SELECT *
                                        FROM v_mark_daily 
                                        WHERE class_id      = '$ex[0]'
                                            AND section_id  = '$ex[1]'
                                            AND subject_id  = '$ex[2]'
                                            AND year        = '$running_year'
                                            AND semester_id = '$running_semester'
                                            ORDER BY first_name asc
                                            ")->result_array();
        }

        // echo '<pre>';
        // var_dump($marks);
        // echo '</pre>';

        foreach($marks as $row){
            
            $count          = 0;
            $obtained_marks = 0;
            
            $labouno        = html_escape($this->input->post('lab_uno_'.$row['mark_daily_id']));
            $labodos        = html_escape($this->input->post('lab_dos_'.$row['mark_daily_id']));
            $labotres       = html_escape($this->input->post('lab_tres_'.$row['mark_daily_id']));
            $labocuatro     = html_escape($this->input->post('lab_cuatro_'.$row['mark_daily_id']));
            $labocinco      = html_escape($this->input->post('lab_cinco_'.$row['mark_daily_id']));
            $laboseis       = html_escape($this->input->post('lab_seis_'.$row['mark_daily_id']));
            $labosiete      = html_escape($this->input->post('lab_siete_'.$row['mark_daily_id']));
            $laboocho       = html_escape($this->input->post('lab_ocho_'.$row['mark_daily_id']));
            $labonueve      = html_escape($this->input->post('lab_nueve_'.$row['mark_daily_id']));
            $labodiez       = html_escape($this->input->post('lab_diez_'.$row['mark_daily_id']));
            $comment        = html_escape($this->input->post('comment_'.$row['mark_daily_id']));

            // Validate values
            if($labouno     == '' ) { $labouno      = '-'; } 
            if($labodos     == '' ) { $labodos      = '-'; }  
            if($labotres    == '' ) { $labotres     = '-'; }  
            if($labocuatro  == '' ) { $labocuatro   = '-'; }  
            if($labocinco   == '' ) { $labocinco    = '-'; }
            if($laboseis    == '' ) { $laboseis     = '-'; } 
            if($labosiete   == '' ) { $labosiete    = '-'; }  
            if($laboocho    == '' ) { $laboocho     = '-'; }  
            if($labonueve   == '' ) { $labonueve    = '-'; }  
            if($labodiez    == '' ) { $labodiez     = '-'; }

            // Calculate the average 
            if(is_numeric($labouno)     && $labouno != '-' ) { $count++; } 
            if(is_numeric($labodos)     && $labodos != '-' ) { $count++; }  
            if(is_numeric($labotres)    && $labotres != '-' ) { $count++; }  
            if(is_numeric($labocuatro)  && $labocuatro != '-' ) { $count++; }  
            if(is_numeric($labocinco)   && $labocinco != '-') { $count++; }
            if(is_numeric($laboseis)    && $laboseis != '-' ) { $count++; } 
            if(is_numeric($labosiete)   && $labosiete != '-' ) { $count++; }  
            if(is_numeric($laboocho)    && $laboocho != '-' ) { $count++; }  
            if(is_numeric($labonueve)   && $labonueve != '-' ) { $count++; }  
            if(is_numeric($labodiez)    && $labodiez != '-') { $count++; }

            $labototal      = (int)$labouno + (int)$labodos + (int)$labotres + (int)$labocuatro + (int)$labocinco + (int)$laboseis + (int)$labosiete + (int)$laboocho + (int)$labonueve + (int)$labodiez;
            
            if($count > 0)
                $obtained_marks = round(($labototal / $count), $this->roundPrecision);
            else 
                $obtained_marks = '-';
            
            $data['mark_obtained'] = $obtained_marks;
            $data['labuno']     = $labouno;
            $data['labdos']     = $labodos;
            $data['labtres']    = $labotres;
            $data['labcuatro']  = $labocuatro;
            $data['labcinco']   = $labocinco;
            $data['labseis']    = $laboseis;
            $data['labsiete']   = $labosiete;
            $data['labocho']    = $laboocho;
            $data['labnueve']   = $labonueve;
            $data['labdiez']    = $labodiez;
            $data['labtotal']   = $labototal;
            $data['comment']    = $comment;

            $this->db->where('mark_daily_id' , $row['mark_daily_id']);
            $this->db->update('mark_daily' , $data);
        
            $table      = 'mark_daily';
            $action     = 'update';
            $update_id  = $row['mark_daily_id'];
            $this->crud->save_log($table, $action, $update_id, $data);

        }

        $filter = base64_encode( $student_id.'|'.$unit_id.'|'.$mark_date );

        return $filter;
        
    }

    public function uploadMarks($datainfo,$examId)
    {
        $info = base64_decode($datainfo);
        $ex = explode('-', $info);

        $date = date('Y-m-d');

        $data['unit_id']        = $examId;
        $data['class_id']       = $ex[0];
        $data['section_id']     = $ex[1];
        $data['subject_id']     = $ex[2];
        $data['year']           = $this->runningYear;
        $data['semester_id']    = $this->runningSemester;

        $students = $this->db->get_where('enroll' , array('class_id' => $data['class_id'] , 'section_id' => $data['section_id'] , 'subject_id' => $data['subject_id'] ,'year' => $data['year']))->result_array();
        
        foreach($students as $row) 
        {
            if($this->useDailyMarks)
            {
                $verify_data = array('unit_id' => $data['unit_id'], 'class_id' => $data['class_id'], 'section_id' => $data['section_id'],
                                    'student_id' => $row['student_id'],'subject_id' => $data['subject_id'], 'year' => $data['year'], 'mark_date' => $date);
                $query = $this->db->get_where('mark_daily' , $verify_data);

                if($query->num_rows() < 1) 
                {   
                    $data['mark_date']  = $date;
                    $data['student_id'] = $row['student_id'];
                    
                    $this->db->insert('mark_daily' , $data);

                    $table      = 'mark_daily';
                    $action     = 'insert';
                    $insert_id  = $this->db->insert_id();
                    $this->crud->save_log($table, $action, $insert_id, $data);
                }
            }
            else
            {
                $verify_data = array('unit_id' => $data['unit_id'], 'class_id' => $data['class_id'], 'section_id' => $data['section_id'],
                                    'student_id' => $row['student_id'],'subject_id' => $data['subject_id'], 'year' => $data['year']);
                $query = $this->db->get_where('mark' , $verify_data);

                if($query->num_rows() < 1) 
                {   
                    $data['student_id'] = $row['student_id'];
                    
                    $this->db->insert('mark' , $data);

                    $table      = 'mark';
                    $action     = 'insert';
                    $insert_id  = $this->db->insert_id();
                    $this->crud->save_log($table, $action, $insert_id, $data);
                }
            }
        }
    }
    
    public function submitExam($online_exam_id)
    {
        $answer_script = array();
        $question_bank = $this->db->get_where('question_bank', array('online_exam_id' => $online_exam_id))->result_array();
        foreach ($question_bank as $question) 
        {
          $correct_answers  = $this->crud->get_correct_answer($question['question_bank_id']);
          $container_2 = array();
          if (isset($_POST[$question['question_bank_id']])) 
          {
              foreach ($this->input->post($question['question_bank_id']) as $row) 
              {
                  $submitted_answer = "";
                  if ($question['type'] == 'true_false') {
                      $submitted_answer = $row;
                  }
                  elseif($question['type'] == 'fill_in_the_blanks'){
                    $suitable_words = array();
                    $suitable_words_array = explode(',', $row);
                    foreach ($suitable_words_array as $key) {
                      array_push($suitable_words, strtolower($key));
                    }
                    $submitted_answer = json_encode(array_map('trim',$suitable_words));
                  }
                  else{
                      array_push($container_2, strtolower($row));
                      $submitted_answer = json_encode($container_2);
                  }
                  $container = array(
                      "question_bank_id" => $question['question_bank_id'],
                      "submitted_answer" => $submitted_answer,
                      "correct_answers"  => $correct_answers
                  );
              }
          }
          else {
              $container = array(
                  "question_bank_id" => $question['question_bank_id'],
                  "submitted_answer" => "",
                  "correct_answers"  => $correct_answers
              );
          }
          array_push($answer_script, $container);
        }
        $this->crud->submit_online_exam($online_exam_id, json_encode($answer_script));
    }
    
    function requestStudentBook()
    {
        $data['book_id']            = $this->input->post('book_id');
        $data['student_id']         = $this->session->userdata('login_user_id');
        $data['issue_start_date']   = html_escape(strtotime($this->input->post('start')));
        $data['issue_end_date']     = html_escape(strtotime($this->input->post('end')));
        $this->db->insert('book_request', $data);

        $table      = 'book_request';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);
    }
    
    function sendFileHomework($homeworkCode)
    {
        ini_set( 'memory_limit', '200M' );
        ini_set('upload_max_filesize', '200M');  
        ini_set('post_max_size', '200M');  
        ini_set('max_input_time', 3600);  
        ini_set('max_execution_time', 3600);
        
        $data['homework_code']   = $homeworkCode;
        $name = substr(md5(rand(0, 1000000)), 0, 7).$_FILES["file_name"]["name"];
        $data['student_id']      = $this->session->userdata('login_user_id');
        $data['date']            = $this->crud->getDateFormat().' '.date('H:i');
        $data['class_id']        = $this->input->post('class_id');
        $data['section_id']      = $this->input->post('section_id');
        $data['file_name']       =  $name;
        $data['student_comment'] = html_escape($this->input->post('comment'));
        $data['subject_id']      = $this->input->post('subject_id');
        $data['status'] = 1;
        $this->db->insert('deliveries', $data);

        $table      = 'deliveries';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);

        $delivery = $this->db->insert_id();
        include 'public/class.fileuploader.php';
        $FileUploader = new FileUploader('files', array(
            'uploadDir' => './public/uploads/homework_delivery/',
            'replace' => true,
        ));
        $datax = $FileUploader->upload();
        for($i = 0; $i < count($datax['files']); $i++)
        {
            $insert_data['file']          = $datax['files'][$i]['name'];
            $insert_data['homework_code'] = $homeworkCode;
            $insert_data['student_id']    = $this->session->userdata('login_user_id');
            $insert_data['delivery_id']   = $delivery;
            $this->db->insert('homework_files', $insert_data); 

            $table      = 'homework_files';
            $action     = 'insert';
            $insert_id  = $this->db->insert_id();
            $this->crud->save_log($table, $action, $insert_id, $insert_data);

        }
    }
    
    public function sendTextHomework($homeworkCode)
    {
        $data['homework_code']    = $homeworkCode;
        $data['student_id']       = $this->session->userdata('login_user_id');
        $data['date']             = $this->crud->getDateFormat().' '.date('H:i');
        $data['class_id']         = $this->input->post('class_id');
        $data['section_id']       = $this->input->post('section_id');
        $data['homework_reply']   = html_escape($this->input->post('reply'));
        $data['student_comment']  = html_escape($this->input->post('comment'));
        $data['subject_id']       = $this->input->post('subject_id');
        $data['status']           = 1;
        $this->db->insert('deliveries', $data);

        $table      = 'deliveries';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);
        
    }
    
    public function updateTextHomework($id)
    {
        $data['date']             = $this->crud->getDateFormat().' '.date('H:i');
        $data['homework_reply']   = html_escape($this->input->post('reply'));
        $data['student_comment']  = html_escape($this->input->post('comment'));
        $this->db->where('id', $id);
        $this->db->update('deliveries', $data);

        $table      = 'deliveries';
        $action     = 'update';
        $update_id  = $id;
        $this->crud->save_log($table, $action, $update_id, $data);

    }
    
    public function deleteFileHomework($fhomework_file_id)
    {
        $file_n = $this->db->get_where('homework_files', array('fhomework_file_id' => $fhomework_file_id))->row()->file;
        unlink("public/uploads/homework_delivery/" . $file_n);
        $this->db->where('fhomework_file_id',$fhomework_file_id);
        $this->db->delete('homework_files');
    }
    
    function updateFileHomework($id,$homeworkCode)
    {
        ini_set( 'memory_limit', '200M' );
        ini_set('upload_max_filesize', '200M');  
        ini_set('post_max_size', '200M');  
        ini_set('max_input_time', 3600);  
        ini_set('max_execution_time', 3600);
        
        $name = substr(md5(rand(0, 1000000)), 0, 7).$_FILES["file_name"]["name"];
        $data['date']            = $this->crud->getDateFormat().' '.date('H:i');
        $data['file_name']       =  $name;
        $data['student_comment'] = html_escape($this->input->post('comment'));
        $this->db->where('id', $id);
        $this->db->update('deliveries', $data);

        $table      = 'deliveries';
        $action     = 'update';
        $update_id  = $id;
        $this->crud->save_log($table, $action, $update_id, $data);

        
        include 'public/class.fileuploader.php';
        $FileUploader = new FileUploader('files', array(
            'uploadDir' => './public/uploads/homework_delivery/',
            'replace' => true,
        ));
        $datax = $FileUploader->upload();
        for($i = 0; $i < count($datax['files']); $i++)
        {
            $insert_data['file']          = $datax['files'][$i]['name'];
            $insert_data['homework_code'] = $homeworkCode;
            $insert_data['student_id']    = $this->session->userdata('login_user_id');
            $insert_data['delivery_id']   = $id;
            $this->db->insert('homework_files', $insert_data);

            $table      = 'homework_files';
            $action     = 'insert';
            $insert_id  = $this->db->insert_id();
            $this->crud->save_log($table, $action, $insert_id, $data);
            
        }
    }
    
    public function getOtherLiveClasses($liveId,$classId,$sectionId)
    {
        $this->db->order_by('live_id', 'desc');
        $this->db->where('live_id !=', $liveId);
        $this->db->where('class_id', $classId);
        $this->db->where('section_id', $sectionId);
        $info = $this->db->get('live')->result_array();
        return $info;
    }
    
    public function getOtherLiveClassesForTeacher($liveId,$classId,$sectionId,$subjectId)
    {
        $this->db->order_by('live_id', 'desc');
        $this->db->where('live_id !=', $liveId);
        $this->db->where('class_id', $classId);
        $this->db->where('section_id', $sectionId);
        $this->db->where('subject_id',$subjectId);
        $info = $this->db->get('live')->result_array();
        return $info;
    }
    
    public function getClassCurrentUnit($class_id)
    {
        $query = $this->db->query("SELECT unit_id FROM v_class_units WHERE class_id='$class_id' AND is_current = 1 ORDER BY sequence ASC")->row()->unit_id;

        if($query == null){
            $query = $this->db->query("SELECT unit_id FROM v_class_units WHERE class_id='$class_id' ORDER BY sequence DESC")->first_row()->unit_id;
        }
        return $query;
    }
    
    public function uploadAchievement($datainfo) {

        $info = base64_decode($datainfo);
        $ex = explode('-', $info);

        $data['type_test']      = 2; //Achievement 
        $data['class_id']       = $ex[0];
        $data['section_id']     = $ex[1];
        $data['year']           = $this->runningYear;
        $data['semester_id']    = $this->runningSemester;

        $students = $this->db->query("SELECT student_id FROM enroll WHERE class_id = '$ex[0]' AND section_id = '$ex[1]' AND year = '$this->runningYear' AND semester_id = '$this->runningSemester' GROUP BY student_id")->result_array();

        foreach($students as $row) {
            $verify_data = array('student_id' => $row['student_id'], 'class_id' => $data['class_id'], 'section_id' => $data['section_id'],'year' => $data['year'], 'section_id' => $data['section_id']);

            $query = $this->db->get_where('pa_test' , $verify_data);

            if($query->num_rows() < 1) {

                $data['student_id'] = $row['student_id'];
                $this->db->insert('pa_test' , $data);
                
                $table      = 'pa_test';
                $action     = 'insert';
                $insert_id  = $this->db->insert_id();
                $this->crud->save_log($table, $action, $insert_id, $data);
            }
        }
    }   

    public function uploadAchievementBatch($datainfo, $student_id){

        $info = base64_decode( $datainfo );
        $ex = explode( '-', $info );

        
        $data['class_id']       = $ex[0];
        $data['section_id']     = $ex[1];
        $data['student_id']     = $student_id;
        $data['year']           = $this->runningYear;
        $data['semester_id']    = $this->runningSemester;

        $running_year     = $data['year'] ;
        $running_semester = $data['semester_id'];

        // Get Score
        if($student_id != ""){
            $scores = $this->db->query("SELECT * FROM pa_test 
                                        WHERE class_id  = '$ex[0]'
                                        AND section_id  = '$ex[1]'
                                        AND year        = '$running_year'
                                        AND semester_id = '$running_semester'
                                        AND student_id  = '$student_id'"
                                    )->result_array();
        }
        else 
        {
            $students = $this->db->query("SELECT student_id FROM enroll
                            WHERE class_id  = '$ex[0]'
                            AND section_id  = '$ex[1]'
                            AND subject_id  = '$ex[2]'
                            AND year        = '$running_year'
                            AND semester_id = '$running_semester'
                            AND student_id  = '$student_id'"
                        )->result_array();
            $List = implode(', ', $students);

            
            $scores = $this->db->query("SELECT * FROM pa_test 
                                        WHERE class_id  = '$ex[0]'
                                        AND section_id  = '$ex[1]'
                                        AND year        = '$running_year'
                                        AND semester_id = '$running_semester'
                                        AND student_id in ($List)
                                        "
                                    )->result_array();
        }

        foreach($scores as $row){
            
            $score1    = html_escape($this->input->post('score1_'.$row['test_id']));
            $score2    = html_escape($this->input->post('score2_'.$row['test_id']));
            $score3    = html_escape($this->input->post('score3_'.$row['test_id']));
            $score4    = html_escape($this->input->post('score4_'.$row['test_id']));
            $score5    = html_escape($this->input->post('score5_'.$row['test_id']));
            $score6    = html_escape($this->input->post('score6_'.$row['test_id']));
            $score7    = html_escape($this->input->post('score7_'.$row['test_id']));
            $score8    = html_escape($this->input->post('score8_'.$row['test_id']));
            $score9    = html_escape($this->input->post('score9_'.$row['test_id']));
            $score10   = html_escape($this->input->post('score10_'.$row['test_id']));

            $comment    = html_escape($this->input->post('comment_'.$row['test_id']));

            $scoretotal = (int)$score1 + (int)$score2 + (int)$score3 + (int)$score4 + (int)$score5 + (int)$score6 + (int)$score7 + (int)$score8 + (int)$score9 + (int)$score10;          
            
            $data_update['scoretotal'] = $scoretotal;
            $data_update['comment'] = $comment;
            $data_update['score1'] = $score1;
            $data_update['score2'] = $score2;
            $data_update['score3'] = $score3;
            $data_update['score4'] = $score4;
            $data_update['score5'] = $score5;
            $data_update['score6'] = $score6;
            $data_update['score7'] = $score7;
            $data_update['score8'] = $score8;
            $data_update['score9'] = $score9;
            $data_update['score10'] = $score10;


            $this->db->where('test_id' , $row['test_id']);
            $this->db->update('pa_test' , $data_update);

            $table      = 'pa_test';
            $action     = 'update';
            $update_id  = $row['test_id'];
            $this->crud->save_log($table, $action, $update_id, $data_update);
        }

        return true;
    }

    public function countStudentsSubject($classId, $sectionId, $subjectId){
        $students = $this->db->get_where('enroll', array('class_id' => $classId, 'section_id' => $sectionId, 'subject_id' => $subjectId))->num_rows();
        return $students;
    }

    public function get_semester_enroll($year, $semester_id)
    {
        $this->db->reset_query();        
        $this->db->where('year', $year);
        $this->db->where('semester_id', $semester_id);
        $query = $this->db->get('semester_enroll')->row_array();
        
        return $query;
    }

    public function get_subject_capacity($class_id, $section_id, $subject_id)
    {
        $this->db->reset_query();            
        $this->db->where('class_id', $class_id);
        $this->db->where('section_id', $section_id);
        $this->db->where('subject_id', $subject_id);
        $subject = $this->db->get('subject')->row_array();

        return $subject['subject_capacity'];
    }

    //Save student enrollment 
    function save_student_enrollment($student_id)
    {   
        $subjects               = $this->input->post('subject_id');
        $data['student_id']     = $student_id;
        $data['class_id']       = $this->input->post('class_id');
        $data['section_id']     = $this->input->post('section_id');
        $data['year']           = $this->input->post('year_id');
        $data['semester_id']    = $this->input->post('semester_id');
        $data['enroll_code']    = substr(md5(rand(0, 1000000)), 0, 7);
        $data['date_added']     = strtotime(date('Y-m-d H:i:s'));

        foreach ($subjects as $key) {
            $data['subject_id'] = $key;
            $this->db->insert('enroll', $data);

            $table      = 'enroll';
            $action     = 'insert';
            $insert_id  = $this->db->insert_id();
            $this->crud->save_log($table, $action, $insert_id, $data);

            // Validate if is full to create a new
            // $nroStudents = intval($this->academic->countStudentsSubject($data['class_id'] , $data['section_id'] , $key));
            // $capacity    = intval($this->academic->get_subject_capacity($data['class_id'] , $data['section_id'] , $key));

            // if($nroStudents >= $capacity)
            // {
            //     $this->academic->duplicate_subject($data['class_id'] , $data['section_id'] , $key);
            // }
        }

    }

    function duplicate_subject($class_id, $section_id, $subject_id)
    {
        $this->db->reset_query();            
        $this->db->where('class_id', $class_id);
        $this->db->where('section_id', $section_id);
        $this->db->where('subject_id', $subject_id);
        $subject = $this->db->get('subject')->row_array();
        
        $this->db->reset_query();
        $data['name']               = $subject['name'];
        $data['about']              = $subject['about'];
        $data['class_id']           = $subject['class_id'];
        $data['section_id']         = $subject['section_id'];
        $data['color']              = $subject['color'];
        $data['icon']               = $subject['icon'];
        $data['modality_id']        = $subject['modality_id'];
        $data['teacher_id']         = $subject['teacher_id'];
        $data['subject_capacity']   = $subject['subject_capacity'];
        
        $data['year']        = $subject['year'];
        $data['semester_id'] = $subject['semester_id'];

        $this->db->insert('subject', $data);

        $data['info_insert'] = "Automate Creation";
        $table      = 'subject';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();

        $this->crud->save_log($table, $action, $insert_id, $data);
    }

    function get_semester_name($semester_id)
    {
        $this->db->reset_query();
        $this->db->where('semester_id', $semester_id);
        $name  = $this->db->get('semesters')->row()->name;

        return $name;
    }

    function get_student_grades_vacations($student_id)
    {
        $roundPrecision   =   $this->crud->getInfo('round_precision');
        
        $this->db->reset_query();
        $this->db->order_by('date_added', 'DESC');
        $this->db->select('student_id, class_id, section_id, year, semester_id');
        $this->db->where('student_id', $student_id);        
        $this->db->group_by(array('student_id', 'class_id', 'section_id'));
        $this->db->limit(2);
        $enrollments  = $this->db->get('enroll')->result_array();

        $array = [];


        foreach ($enrollments as $enroll) {
            $class_id = $enroll['class_id'];
            $section_id = $enroll['section_id'];
            $year = $enroll['year'];
            $semester_id = $enroll['semester_id'];
            $enrollment = $this->db->get_where('v_enrollment' , array('student_id' => $student_id, 'class_id' => $class_id, 'section_id' => $section_id, 'year' => $year, 'semester_id' => $semester_id))->result_array(); 

            $labouno_total = 0;
            $count_total   = 0; 
            $mark_total    = 0;
            foreach ($enrollment as $row3){
                $subject_id = $row3['subject_id'];  
                $average = $this->db->query("SELECT ROUND((SUM(labuno)/COUNT(IF(labuno = '-' or labuno is null,null,'1'))), $roundPrecision) AS 'labuno',
                                                    ROUND((SUM(labdos)/COUNT(IF(labdos = '-' or labdos is null,null,'1'))), $roundPrecision) AS 'labdos',
                                                    ROUND((SUM(labtres)/COUNT(IF(labtres = '-' or labtres is null,null,'1'))), $roundPrecision) AS 'labtres',
                                                    ROUND((SUM(labcuatro)/COUNT(IF(labcuatro = '-' or labcuatro is null,null,'1'))), $roundPrecision) AS 'labcuatro',
                                                    ROUND((SUM(labcinco)/COUNT(IF(labcinco = '-' or labcinco is null,null,'1'))), $roundPrecision) AS 'labcinco',
                                                    ROUND((SUM(labseis)/COUNT(IF(labseis = '-' or labseis is null,null,'1'))), $roundPrecision) AS 'labseis',
                                                    ROUND((SUM(labsiete)/COUNT(IF(labsiete = '-' or labsiete is null,null,'1'))), $roundPrecision) AS 'labsiete',
                                                    ROUND((SUM(labocho)/COUNT(IF(labocho = '-' or labocho is null,null,'1'))), $roundPrecision) AS 'labocho',
                                                    ROUND((SUM(labnueve)/COUNT(IF(labnueve = '-' or labnueve is null,null,'1'))), $roundPrecision) AS 'labnueve',
                                                    ROUND((SUM(labdiez)/COUNT(IF(labdiez = '-' or labdiez is null,null,'1'))), $roundPrecision) AS 'labdiez'
                                                FROM mark_daily 
                                                WHERE student_id = '$student_id'
                                                    AND class_id = '$class_id'
                                                    AND section_id = '$section_id'
                                                    AND subject_id = '$subject_id'
                                                    AND year = '$year'
                                                    AND semester_id = '$semester_id'
                                                ")->first_row();

                // Calculate the average 
                $count = 0;

                $labouno        = $average->labuno;
                $labodos        = $average->labdos;
                $labotres       = $average->labtres;
                $labocuatro     = $average->labcuatro;
                $labocinco      = $average->labcinco;
                $laboseis       = $average->labseis;
                $labosiete      = $average->labsiete;
                $laboocho       = $average->labocho;
                $labonueve      = $average->labnueve;
                $labodiez       = $average->labdiez;

                // Validate values
                if($labouno     == '' ) { $labouno      = '-'; } 
                if($labodos     == '' ) { $labodos      = '-'; }  
                if($labotres    == '' ) { $labotres     = '-'; }  
                if($labocuatro  == '' ) { $labocuatro   = '-'; }  
                if($labocinco   == '' ) { $labocinco    = '-'; }
                if($laboseis    == '' ) { $laboseis     = '-'; } 
                if($labosiete   == '' ) { $labosiete    = '-'; }  
                if($laboocho    == '' ) { $laboocho     = '-'; }  
                if($labonueve   == '' ) { $labonueve    = '-'; }  
                if($labodiez    == '' ) { $labodiez     = '-'; }

                // if(is_numeric($average->labuno)     && $average->labuno != '' ) { $count++; } 
                if(is_numeric($average->labdos)     && $average->labdos != '' ) { $count++; }  
                if(is_numeric($average->labtres)    && $average->labtres != '' ) { $count++; }  
                if(is_numeric($average->labcuatro)  && $average->labcuatro != '' ) { $count++; }  
                if(is_numeric($average->labcinco)   && $average->labcinco != '') { $count++; }
                if(is_numeric($average->labseis)    && $average->labseis != '' ) { $count++; } 
                if(is_numeric($average->labsiete)   && $average->labsiete != '' ) { $count++; }  
                if(is_numeric($average->labocho)    && $average->labocho != '' ) { $count++; }  
                if(is_numeric($average->labnueve)   && $average->labnueve != '' ) { $count++; }  
                if(is_numeric($average->labdiez)    && $average->labdiez != '' ) { $count++; }                                                            
                
                $labototal      = (float)$labodos + (float)$labotres + (float)$labocuatro + (float)$labocinco + (float)$laboseis + (float)$labosiete + (float)$laboocho + (float)$labonueve + (float)$labodiez;

                $mark = $count > 0 ? round(($labototal/$count), (int)$roundPrecision) : '-';

                if($mark != '-'){
                    $mark_total += $mark;
                    $count_total++; 
                }

                if($labouno != '-'){
                    $labouno_total += $labouno;
                }
            }
            $final_mark = ($count_total > 0 ? round(($mark_total/$count_total), (int)$roundPrecision) : '-');
            $final_attendance = ($count_total > 0 ? round(($labouno_total/$count_total), (int)$roundPrecision) : '-');

            array_push($array, array('class_id' => $class_id, 'section_id' => $section_id, 'year' => $year, 'semester_id' => $semester_id, 'final_attendance' => $final_attendance,  'final_mark' => $final_mark));
        }
        return $array;
    }

    public function get_modality()
    {
        $this->db->reset_query();
        $this->db->select('code as modality_id, name, value_1 as color, value_2 as icon');
        $this->db->where('parameter_id', 'MODALITY');
        $query = $this->db->get('parameters')->result_array();;
        
        return $query;
    }
    
    public function get_modality_info($modality_id)
    {
        $this->db->reset_query();
        $this->db->select('code as modality_id, name, value_1 as color, value_2 as icon');
        $this->db->where('parameter_id', 'MODALITY');
        $this->db->where('code', $modality_id);
        $query = $this->db->get('parameters')->row_array();
        
        return $query;
    }

    public function get_modality_name($modality_id)
    {
        $this->db->reset_query();
        $this->db->select('name');
        $this->db->where('parameter_id', 'MODALITY');
        $this->db->where('code', $modality_id);
        $query = $this->db->get('parameters')->row()->name;
        
        return $query;
    }

    public function get_schedule_type()
    {
        $this->db->reset_query();
        $this->db->select('code as schedule_type_id, name, value_1 as price, value_2 as icon');
        $this->db->where('parameter_id', 'SCHEDULE_TYPE');
        $query = $this->db->get('parameters')->result_array();;
        
        return $query;
    }
    
    public function get_schedule_type_info($schedule_type_id)
    {
        $this->db->reset_query();
        $this->db->select('code as schedule_type_id, name, value_1 as price, value_2 as icon');
        $this->db->where('parameter_id', 'SCHEDULE_TYPE');
        $this->db->where('code', $schedule_type_id);
        $query = $this->db->get('parameters')->row_array();
        
        return $query;
    }

    public function get_schedule_type_name($schedule_type_id)
    {
        $this->db->reset_query();
        $this->db->select('name');
        $this->db->where('parameter_id', 'SCHEDULE_TYPE');
        $this->db->where('code', $schedule_type_id);
        $query = $this->db->get('parameters')->row()->name;
        
        return $query;
    }

    public function get_classes()
    {
        $this->db->reset_query();
        $query = $this->db->get('class')->result_array();;
        
        return $query;
    }
    
    public function get_class_info($class_id)
    {
        $this->db->reset_query();
        $this->db->where('class_id', $class_id);
        $query = $this->db->get('class')->row_array();
        
        return $query;
    }

    public function get_class_name($class_id)
    {
        $this->db->reset_query();
        $this->db->select('name');
        $this->db->where('class_id', $class_id);
        $query = $this->db->get('class')->row()->name;
        
        return $query;
    }

    public function exist_schedule($class_id, $year, $semester_id, $schedule)
    {
        $this->db->reset_query();
        $this->db->where('class_id', $class_id);
        $this->db->where('year', $year);
        $this->db->where('semester_id', $semester_id);
        $this->db->where('name', $schedule);
        $query = $this->db->get('section');

        if($query->num_rows() > 0)
        {
            return $query->row()->section_id;;
        }
        else
        {
            return 0;
        }       
        
    }

    public function exist_subject($class_id, $year, $semester_id, $section_id, $modality_id, $subject)
    {
        $this->db->reset_query();
        $this->db->where('class_id', $class_id);
        $this->db->where('year', $year);
        $this->db->where('semester_id', $semester_id);
        $this->db->where('section_id', $section_id);
        $this->db->where('modality_id', $modality_id);
        $this->db->where('name', $subject);
        $query = $this->db->get('subject');

        if($query->num_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }       
        
    }


    function create_semester_enroll()
    {
        $year           = $this->input->post('year');
        $semester_id    = $this->input->post('semester_id');

        $data['year']           = $this->input->post('year');
        $data['semester_id']    = $this->input->post('semester_id');
        $data['number_class']   = $this->input->post('number_class');
        $data['date_start']     = $this->input->post('date_start');
        $data['date_end']       = $this->input->post('date_end');
        $data['created_by']     = $this->session->userdata('login_user_id');

        $this->db->insert('semester_enroll', $data);

        $table      = 'semester_enroll';
        $action     = 'insert';
        $insert_id  = $this->db->insert_id();
        $this->crud->save_log($table, $action, $insert_id, $data);

        //Creating Classes 
        $class_ids = $this->input->post('class_ids');
        foreach ( $class_ids as $class_id )
        {            
            $schedules = $this->input->post('schedule');

            foreach ( $schedules as $subject_id )  
            {
                $schedule = $this->get_schedule_type_name($subject_id);
                $section_id = $this->exist_schedule($class_id, $year, $semester_id, $schedule);

                // Create Schedule
                if($section_id == 0)
                {
                    $dataSection['name']        = $schedule;
                    $dataSection['class_id']    = $class_id;
                    $dataSection['year']        = $year;
                    $dataSection['semester_id'] = $semester_id;                    

                    $this->db->insert('section', $dataSection);

                    $table       = 'section';
                    $action      = 'insert';  
                    $$section_id = $this->db->insert_id();                   
                    $this->crud->save_log($table, $action, $insert_id, $dataSection);
                }
                
                //Create Subject
                $modality_ids = $this->input->post('modality_ids');
                foreach ( $modality_ids as $modality_id )  
                {
                    $subjects = DEFAULT_SUBJECTS;
                    foreach ( $subjects as $subject )
                    {
                        if(!$this->exist_subject($class_id, $year, $semester_id, $section_id, $modality_id, $subject))
                        {
                            $dataSubject['name']        = $subject['name'];
                            $dataSubject['color']       = $subject['color'];
                            $dataSubject['icon']        = $subject['icon'];
                            $dataSubject['class_id']    = $class_id;
                            $dataSubject['year']        = $year;
                            $dataSubject['semester_id'] = $semester_id;                    
                            $dataSubject['modality_id'] = $subject['modality_id'];

                            $this->db->insert('subject', $dataSubject);
        
                            $table       = 'subject';
                            $action      = 'insert';  
                            $$section_id = $this->db->insert_id();                   
                            $this->crud->save_log($table, $action, $insert_id, $dataSubject);
                        }
                    }
                    
                }
            }
        }
    }
}