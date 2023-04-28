<?php 
    $admin_id = get_login_user_id();
    $role_id = get_role_id();

    $admin_type = $role_id;// $this->db->get_where('admin', array('admin_id' => $admin_id))->row()->owner_status;

    // Array Pages
    $task_pages         = array('task_dashboard', 'task_student', 'task_applicant', 'task_info','task_update');
    $message_pages      = array('message', 'group');
    $admissions_pages   = array('admission_dashboard', 'admission_applicants','admission_converted','admission_new_applicant', 'admission_applicant','admission_new_student');
    $routine_pages      = array('class_routine_view', 'teacher_routine');
    $library_pages      = array('library', 'book_request', 'update_book');
    $time_card_pages    = array('time_card', 'time_sheet', 'payment_period', 'worker_schedule', 'workers', 'worked_hours');
    $users_pages        = array('subject_marks', 'admin_update', 'admin_profile', 'librarian_update', 'librarian_profile', 'accountant_profile', 'accountant_update', 
                                'parent_childs', 'parent_update', 'parent_profile', 'accountant', 'student_profile_report', 'student_profile_attendance', 'student_marks', 
                                'student_invoices', 'student_update', 'student_portal', 'librarian', 'pending', 'teacher_subjects', 'teacher_schedules', 'users', 'admins', 
                                'teachers', 'teacher_profile', 'teacher_update', 'parents', 'students', 'student_update_class', 'student_enrollments', 'student_past_marks',
                                'student_placement_achievement'
                            );    
    $academic_pages     = array('attendance', 'live', 'exam_room', 'exam_results', 'exam_edit', 'homework', 'homework_room', 'homework_edit', 'homework_details', 'meet', 
                                'grados', 'upload_marks', 'study_material', 'cursos', 'subject_dashboard', 'forum_room', 'online_exams', 'edit_forum', 'forum', 'daily_marks', 
                                'daily_marks_average');
    $reports_pages      = array('reports_general','reports_students', 'reports_students_all', 'reports_attendance', 'reports_accounting', 'reports_tabulation', 'reports_tabulation_daily', 'report_marks');

    $attendance_pages   = array('teacher_report_view', 'teacher_attendance_view', 'teacher_attendance_report','teacher_attendance');

    $calendar_pages     = array('calendar');

    $polls_pages        = array('polls', 'view_poll', 'new_poll');

    $system_pages       = array('system_settings', 'system_security', 'system_sms', 'system_email', 'system_translate', 'system_database');

    $helpdesk_pages     = array('dashboard', 'ticket_list', 'ticket_info');

    $accounting_pages   = array('accounting_dashboard', 'accounting_daily_income', 'accounting_payments','accounting_agreements', 'accounting_collection_management','invoice_details', 'payments', 'students_payments', 'expense', 'new_payment');    

    $upload_pages       = array('upload_agreements');

    $student_month_pages = array('student_month_dashboard');

    $academic_report_pages  = array('academic_dashboard', 'academic_schedule_class');

    $advisor_report_pages  = array('advisor_dashboard');
    

?>
<div class="fixed-sidebar">
    <div class="fixed-sidebar-left sidebar--small" id="sidebar-left">
        <a href="<?php echo base_url();?>admin/panel/" class="logo">
            <div class="img-wrap">
                <img class="nav-icon"
                    src="<?php echo base_url();?>public/uploads/<?php echo $this->crud->getInfo('icon_white');?>">
            </div>
        </a>
        <div class="mCustomScrollbar" data-mcs-theme="dark">
            <ul class="left-menu">
                <li>
                    <a href="#" class="js-sidebar-open">
                        <i class="left-menu-icon picons-thin-icon-thin-0069a_menu_hambuger"></i>
                    </a>
                </li>
                <li <?php if($page_name == 'panel'):?>class="currentItem" <?php endif;?>>
                    <a href="<?php echo base_url();?>admin/panel/" data-toggle="tooltip" data-placement="right"
                        data-original-title="<?php echo getPhrase('dashboard');?>">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0045_home_house"></i>
                        </div>
                    </a>
                </li>
                <!-- Time Card Access -->
                <?php if(has_permission('time_card_module')):?>
                <li <?= in_array($page_name, $time_card_pages) ? 'class="currentItem"' : '';?>>
                    <a href="<?php echo base_url();?>admin/time_card/" data-toggle="tooltip" data-placement="right"
                        data-original-title="<?php echo getPhrase('time_card');?>">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0844_stopwatch_training_time"></i>
                        </div>
                    </a>
                </li>
                <?php endif;?>
                <!-- Tasks -->
                <?php if(has_permission('task_module')):?>
                <li <?= in_array($page_name, $task_pages) ? 'class="currentItem"' : '';?>>
                    <a href="<?php echo base_url();?>admin/task_dashboard/" data-toggle="tooltip" data-placement="right"
                        data-original-title="<?php echo getPhrase('task_dashboard');?>">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0100_to_do_list_reminder_done"></i>
                        </div>
                    </a>
                </li>
                <?php endif;?>
                <!-- Messages Access -->
                <?php if(has_permission('messages_module')):?>
                <li <?= in_array($page_name, $message_pages) ? 'class="currentItem"' : '';?>>
                    <a href="<?php echo base_url();?>admin/message/" data-toggle="tooltip" data-placement="right"
                        data-original-title="<?php echo getPhrase('messages');?>">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0322_mail_post_box"></i>
                        </div>
                    </a>
                </li>
                <?php endif;?>
                <!-- Users Access -->
                <?php if(has_permission('user_module')):?>
                <li <?= in_array($page_name, $users_pages) ? 'class="currentItem"' : '';?>>
                    <a href="<?php echo base_url();?>admin/users/" data-toggle="tooltip" data-placement="right"
                        data-original-title="<?php echo getPhrase('users');?>">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0704_users_profile_group_couple_man_woman"></i>
                        </div>
                    </a>
                </li>
                <?php endif;?>
                <!-- Admissions Access -->
                <?php if(has_permission('admission_module')):?>
                <li <?= in_array($page_name, $admissions_pages) ? 'class="currentItem"': '';?>>
                    <a href="<?php echo base_url();?>admin/admission_dashboard/" data-toggle="tooltip"
                        data-placement="right" data-original-title="<?php echo getPhrase('admissions');?>">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i>
                        </div>
                    </a>
                </li>
                <?php endif;?>
                <!-- Class Routine Access -->
                <?php if(has_permission('schedule_teacher_module')):?>
                <li <?= in_array($page_name, $routine_pages) ? 'class="currentItem"' : '';?>>
                    <a href="<?php echo base_url();?>admin/class_routine_view/" data-toggle="tooltip"
                        data-placement="right" data-original-title="<?php echo getPhrase('class_routine');?>">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0029_time_watch_clock_wall"></i>
                        </div>
                    </a>
                </li>
                <?php endif;?>
                <!-- Academic Access -->
                <?php if(has_permission('academic_module')):?>
                <li <?= in_array($page_name, $academic_pages) ? 'class="currentItem"' : '';?>>
                    <a href="<?php echo base_url();?>admin/academic/" data-toggle="tooltip" data-placement="right"
                        data-original-title="<?php echo getPhrase('academic');?>">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0680_pencil_ruller_drawing"></i>
                        </div>
                    </a>
                </li>
                <?php endif;?>
                <!-- Library Access -->
                <?php if(has_permission('library_module')):?>
                <li <?= (in_array($page_name, $library_pages)) ? 'class="currentItem"' : '';?>>
                    <a href="<?php echo base_url();?>admin/library/" data-toggle="tooltip" data-placement="right"
                        data-original-title="<?php echo getPhrase('library');?>">
                        <div class="left-menu-icon">
                            <i class="os-icon picons-thin-icon-thin-0017_office_archive"></i>
                        </div>
                    </a>
                </li>
                <?php endif;?>
                <!-- Attendance Access -->
                <?php if(has_permission('attendance_module')):?>
                <li <? in_array($page_name, $attendance_pages) ? 'class="currentItem"' : '' ;?>>
                    <a href="<?php echo base_url();?>admin/teacher_attendance/" data-toggle="tooltip"
                        data-placement="right" data-original-title="<?php echo getPhrase('teacher_attendance');?>">
                        <div class="left-menu-icon">
                            <i class="os-icon picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i>
                        </div>
                    </a>
                </li>
                <?php endif;?>
                <!-- Calendar Access -->
                <?php if(has_permission('calendar_module')):?>
                <li <?= in_array($page_name, $calendar_pages) ? 'class="currentItem"' : '';?>>
                    <a href="<?php echo base_url();?>admin/calendar/" data-toggle="tooltip" data-placement="right"
                        data-original-title="<?php echo getPhrase('calendar');?>">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0021_calendar_month_day_planner"></i>
                        </div>
                    </a>
                </li>
                <?php endif;?>
                <!-- Polls Access -->
                <?php if(has_permission('polls_module')):?>
                <li <?= in_array($page_name, $polls_pages) ? 'class="currentItem"' : '';?>>
                    <a href="<?php echo base_url();?>admin/polls/" data-toggle="tooltip" data-placement="right"
                        data-original-title="<?php echo getPhrase('polls');?>">
                        <div class="left-menu-icon">
                            <i class="os-icon picons-thin-icon-thin-0385_graph_pie_chart_statistics"></i>
                        </div>
                    </a>
                </li>
                <?php endif;?>
                <!-- Notifications Access -->
                <?php if(has_permission('notifications_module')):?>
                <li <?php if($page_name == 'notify'):?>class="currentItem" <?php endif;?>>
                    <a href="<?php echo base_url();?>admin/notify/" data-toggle="tooltip" data-placement="right"
                        data-original-title="<?php echo getPhrase('notifications');?>">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0286_mobile_message_sms"></i>
                        </div>
                    </a>
                </li>
                <?php endif;?>
                <!-- Behavior Access -->
                <?php if(has_permission('request_module')):?>
                <li <?php if($page_name == 'request_student' || $page_name == 'request' || $page_name == 'looking_report'):?>class="currentItem"
                    <?php endif;?>>
                    <a href="<?php echo base_url();?>admin/request_dashboard/" data-toggle="tooltip"
                        data-placement="right" data-original-title="<?php echo getPhrase('requests');?>">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0389_gavel_hammer_law_judge_court"></i>
                        </div>
                    </a>
                </li>
                <?php endif;?>
                <!-- News Access -->
                <?php if(has_permission('news_module')):?>
                <li <?php if($page_name == 'news'):?>class="currentItem" <?php endif;?>>
                    <a href="<?php echo base_url();?>admin/news/" data-toggle="tooltip" data-placement="right"
                        data-original-title="<?php echo getPhrase('news');?>">
                        <div class="left-menu-icon">
                            <i class="os-icon picons-thin-icon-thin-0010_newspaper_reading_news"></i>
                        </div>
                    </a>
                </li>
                <?php endif;?>
                <!-- School Bus Access -->
                <?php if(has_permission('school_bus_module')):?>
                <li <?php if($page_name == 'school_bus'):?>class="currentItem" <?php endif;?>>
                    <a href="<?php echo base_url();?>admin/school_bus/" data-toggle="tooltip" data-placement="right"
                        data-original-title="<?php echo getPhrase('school_bus');?>">
                        <div class="left-menu-icon">
                            <i class="os-icon picons-thin-icon-thin-0470_bus_transport"></i>
                        </div>
                    </a>
                </li>
                <?php endif;?>
                <!-- Classrooms Access -->
                <?php if(has_permission('classrooms_module')):?>
                <li <?php if($page_name == 'classroom'):?>class="currentItem" <?php endif;?>>
                    <a href="<?php echo base_url();?>admin/classrooms/" data-toggle="tooltip" data-placement="right"
                        data-original-title="<?php echo getPhrase('classrooms');?>">
                        <div class="left-menu-icon">
                            <i class="os-icon picons-thin-icon-thin-0047_home_flat"></i>
                        </div>
                    </a>
                </li>
                <?php endif;?>
                <!-- Accounting Reports Access -->
                <?php if(has_permission('accounting_module')):?>
                <li <?php if(in_array($page_name, $accounting_pages)):?>class="currentItem" <?php endif;?>>
                    <a href="<?php echo base_url();?>reports/accounting_dashboard/" data-toggle="tooltip"
                        data-placement="right" data-original-title="<?php echo getPhrase('accounting_reports');?>">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0428_money_payment_dollar_bag_cash"></i>
                        </div>
                    </a>
                </li>
                <?php endif;?>
                <!-- Academic Reports Access -->
                <?php if(has_permission('academic_report_module')):?>
                <li <?php if(in_array($page_name, $academic_report_pages)):?>class="currentItem" <?php endif;?>>
                    <a href="<?php echo base_url();?>reports/academic_dashboard/" data-toggle="tooltip"
                        data-placement="right" data-original-title="<?php echo getPhrase('academic_reports');?>">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0375_screen_analytics_line_graph"></i>
                        </div>
                    </a>
                </li>
                <?php endif;?>
                <!-- Advisor Reports Access -->
                <?php if(has_permission('advisor_report_module')):?>
                <li <?php if(in_array($page_name, $advisor_report_pages)):?>class="currentItem" <?php endif;?>>
                    <a href="<?php echo base_url();?>reports/advisor_dashboard/" data-toggle="tooltip"
                        data-placement="right" data-original-title="<?php echo getPhrase('advisor_reports');?>">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0484_gauge_dashboard_full_fuel"></i>
                        </div>
                    </a>
                </li>
                <?php endif;?>
                <!-- System Reports Access -->
                <?php if(has_permission('system_reports_module')):?>
                <li <?php if(in_array($page_name, $reports_pages)):?>class="currentItem" <?php endif;?>>
                    <a href="<?php echo base_url();?>admin/reports_general/" data-toggle="tooltip"
                        data-placement="right" data-original-title="<?php echo getPhrase('system_reports');?>">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0378_analytics_presentation_statistics_graph"></i>
                        </div>
                    </a>
                </li>
                <?php endif;?>
                <!-- Academic Settings Access -->
                <?php if(has_permission('academic_settings_module')):?>
                <li <?php if($page_name == 'academic_settings' || $page_name == 'section' || $page_name == 'grade' || $page_name == 'semester' || $page_name == 'student_promotion' || $page_name == 'units' || $page_name == 'gpa' || $page_name == 'subjects'):?>class="currentItem"
                    <?php endif;?>>
                    <a href="<?php echo base_url();?>admin/academic_settings/" data-toggle="tooltip"
                        data-placement="right" data-original-title="<?php echo getPhrase('academic_settings');?>">
                        <div class="left-menu-icon">
                            <i class="os-icon picons-thin-icon-thin-0006_book_writing_reading_read_manual"></i>
                        </div>
                    </a>
                </li>
                <?php endif;?>
                <!-- Settings Access -->
                <?php if(has_permission('settings_module')):?>
                <li <?php if(in_array($page_name, $system_pages)):?>class="currentItem" <?php endif;?>>
                    <a href="<?php echo base_url();?>admin/system_settings/" data-toggle="tooltip"
                        data-placement="right" data-original-title="<?php echo getPhrase('settings');?>">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0051_settings_gear_preferences"></i>
                        </div>
                    </a>
                </li>
                <?php endif;?>
                <!-- HelpDesk Access -->
                <?php if(has_permission('helpdesk_module')):?>
                <li <?php if(in_array($page_name, $helpdesk_pages)):?>class="currentItem" <?php endif;?>>
                    <a href="<?php echo base_url();?>helpdesk/dashboard/" data-toggle="tooltip" data-placement="right"
                        data-original-title="<?php echo getPhrase('help_desk');?>">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0309_support_help_talk_call"></i>
                        </div>
                    </a>
                </li>
                <?php endif;?>
                <!-- Upload Module Access -->
                <?php if(has_permission('upload_module')):?>
                <li <?php if(in_array($page_name, $upload_pages)):?>class="currentItem" <?php endif;?>>
                    <a href="<?php echo base_url();?>UploadController/upload_agreements/" data-toggle="tooltip"
                        data-placement="right" data-original-title="<?php echo getPhrase('upload_info');?>">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0124_upload_cloud_file_sync_backup"></i>
                        </div>
                    </a>
                </li>
                <?php endif;?>
                <!-- Student of Month Module Access -->
                <?php if(has_permission('student_month_access')):?>
                <li <?php if(in_array($page_name, $student_month_pages)):?>class="currentItem" <?php endif;?>>
                    <a href="<?php echo base_url();?>admin/student_month_dashboard/" data-toggle="tooltip"
                        data-placement="right" data-original-title="<?php echo getPhrase('student_month');?>">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0659_medal_first_place_winner_award_prize_achievement"></i>
                        </div>
                    </a>
                </li>
                <?php endif;?>
            </ul>
        </div>
    </div>

    <div class="fixed-sidebar-left sidebar--large" id="sidebar-left-1">
        <a href="<?php echo base_url();?>admin/panel/" class="logo">
            <div class="img-wrap">
                <img class="nav-icon"
                    src="<?php echo base_url();?>public/uploads/<?php echo $this->crud->getInfo('icon_white');?>">
            </div>
            <div class="title-block">
                <h6 class="logo-title"><?php echo $this->crud->getInfo('system_name');?></h6>
            </div>
        </a>
        <div class="mCustomScrollbar" data-mcs-theme="dark">
            <ul class="left-menu">
                <li>
                    <a href="#" class="js-sidebar-open">
                        <i class="left-menu-icon picons-thin-icon-thin-0069a_menu_hambuger"></i>
                        <span class="left-menu-title"><?php echo getPhrase('minimize_menu');?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url();?>admin/panel/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0045_home_house"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('dashboard');?></span>
                    </a>
                </li>
                <!-- Time Card Access -->
                <?php if(has_permission('time_card_module')):?>
                <li>
                    <a href="<?php echo base_url();?>admin/time_card/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0844_stopwatch_training_time"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('time_card');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- Tasks -->
                <?php if(has_permission('task_module')):?>
                <li <?= in_array($page_name, $task_pages) ? 'class="currentItem"' : '';?>>
                    <a href="<?php echo base_url();?>admin/task_dashboard/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0100_to_do_list_reminder_done"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('task_dashboard');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- Messages Access -->
                <?php if(has_permission('messages_module')):?>
                <li>
                    <a href="<?php echo base_url();?>admin/message/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0322_mail_post_box"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('messages');?></span>
                    </a>
                </li>
                <?php endif;?>
                <li>
                    <a href="<?php echo base_url();?>admin/users/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0704_users_profile_group_couple_man_woman"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('users');?></span>
                    </a>
                </li>
                <!-- Admissions Access -->
                <?php if(has_permission('admission_module')):?>
                <li>
                    <a href="<?php echo base_url();?>admin/admission_dashboard/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('admissions');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- Class Routine Access -->
                <?php if(has_permission('schedule_teacher_module')):?>
                <li>
                    <a href="<?php echo base_url();?>admin/class_routine_view/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0029_time_watch_clock_wall"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('class_routine');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- Academic Access -->
                <?php if(has_permission('academic_module')):?>
                <li>
                    <a href="<?php echo base_url();?>admin/academic/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0680_pencil_ruller_drawing"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('academic');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- Library Access -->
                <?php if(has_permission('library_module')):?>
                <li>
                    <a href="<?php echo base_url();?>admin/library/">
                        <div class="left-menu-icon">
                            <i class="os-icon picons-thin-icon-thin-0017_office_archive"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('library');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- Attendance Access -->
                <?php if(has_permission('attendance_module')):?>
                <li>
                    <a href="<?php echo base_url();?>admin/teacher_attendance/">
                        <div class="left-menu-icon">
                            <i class="os-icon picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('teacher_attendance');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- Calendar Access -->
                <?php if(has_permission('calendar_module')):?>
                <li>
                    <a href="<?php echo base_url();?>admin/calendar/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0021_calendar_month_day_planner"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('calendar');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- Polls Access -->
                <?php if(has_permission('polls_module')):?>
                <li>
                    <a href="<?php echo base_url();?>admin/polls/">
                        <div class="left-menu-icon">
                            <i class="os-icon picons-thin-icon-thin-0385_graph_pie_chart_statistics"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('polls');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- Notifications Access -->
                <?php if(has_permission('notifications_module')):?>
                <li>
                    <a href="<?php echo base_url();?>admin/notify/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0286_mobile_message_sms"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('notifications');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- Behavior Access -->
                <?php if(has_permission('request_module')):?>
                <li>
                    <a href="<?php echo base_url();?>admin/request_dashboard/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0389_gavel_hammer_law_judge_court"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('behavior');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- News Access -->
                <?php if(has_permission('news_module')):?>
                <li>
                    <a href="<?php echo base_url();?>admin/news/">
                        <div class="left-menu-icon">
                            <i class="os-icon picons-thin-icon-thin-0010_newspaper_reading_news"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('news');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- School Bus Access -->
                <?php if(has_permission('school_bus_module')):?>
                <li>
                    <a href="<?php echo base_url();?>admin/school_bus/">
                        <div class="left-menu-icon">
                            <i class="os-icon picons-thin-icon-thin-0470_bus_transport"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('school_bus');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- Classrooms Access -->
                <?php if(has_permission('classrooms_module')):?>
                <li>
                    <a href="<?php echo base_url();?>admin/classrooms/">
                        <div class="left-menu-icon">
                            <i class="os-icon picons-thin-icon-thin-0047_home_flat"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('classrooms');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- Accounting Reports Access -->
                <?php if(has_permission('accounting_module')):?>
                <li>
                    <a href="<?php echo base_url();?>reports/accounting_dashboard/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0428_money_payment_dollar_bag_cash"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('accounting_reports');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- Academic Reports Access -->
                <?php if(has_permission('academic_report_module')):?>
                <li>
                    <a href="<?php echo base_url();?>reports/academic_dashboard/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0375_screen_analytics_line_graph"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('academic_reports');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- Advisor Reports Access -->
                <?php if(has_permission('advisor_report_module')):?>
                <li>
                    <a href="<?php echo base_url();?>reports/advisor_dashboard/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0484_gauge_dashboard_full_fuel"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('advisor_reports');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- System Reports Access -->
                <?php if(has_permission('system_reports_module')):?>
                <li>
                    <a href="<?php echo base_url();?>admin/reports_general/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0378_analytics_presentation_statistics_graph"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('system_reports');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- Academic Settings Access -->
                <?php if(has_permission('academic_settings_module')):?>
                <li>
                    <a href="<?php echo base_url();?>admin/academic_settings/">
                        <div class="left-menu-icon">
                            <i class="os-icon picons-thin-icon-thin-0006_book_writing_reading_read_manual"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('academic_settings');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- Settings Access -->
                <?php if(has_permission('settings_module')):?>
                <li>
                    <a href="<?php echo base_url();?>admin/system_settings/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0051_settings_gear_preferences"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('settings');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- helpdesk_module Access -->
                <?php if(has_permission('helpdesk_module')):?>
                <li>
                    <a href="<?php echo base_url();?>helpdesk/dashboard/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0309_support_help_talk_call"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('help_desk');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- Settings Access -->
                <?php if(has_permission('upload_module')):?>
                <li>
                    <a href="<?php echo base_url();?>UploadController/upload_agreements/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0124_upload_cloud_file_sync_backup"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('upload_info');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- Settings Access -->
                <?php if(has_permission('student_month_access')):?>
                <li>
                    <a href="<?php echo base_url();?>admin/student_month_dashboard/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0659_medal_first_place_winner_award_prize_achievement"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('student_month');?></span>
                    </a>
                </li>
                <?php endif;?>
                <br><br>
                <li></li>
            </ul>
        </div>
    </div>
</div>

<div class="fixed-sidebar fixed-sidebar-responsive">
    <div class="fixed-sidebar-left sidebar--small" id="sidebar-left-responsive">
        <a href="<?php echo base_url();?>admin/panel/" class="logo js-sidebar-open">
            <img class="nav-icon"
                src="<?php echo base_url();?>public/uploads/<?php echo $this->crud->getInfo('icon_white');?>">
        </a>
    </div>
    <div class="fixed-sidebar-left sidebar--large" id="sidebar-left-1-responsive">
        <a href="<?php echo base_url();?>" class="logo">
            <div class="img-wrap">
                <img class="nav-icon" class="nav-icon-mobile"
                    src="<?php echo base_url();?>public/uploads/<?php echo $this->crud->getInfo('icon_white');?>">
            </div>
            <div class="title-block">
                <h6 class="logo-title"><?php echo $this->crud->getInfo('system_name')?></h6>
            </div>
        </a>
        <div class="mCustomScrollbar" data-mcs-theme="dark">
            <ul class="left-menu">
                <li>
                    <a href="#" class="js-sidebar-open">
                        <i class="left-menu-icon picons-thin-icon-thin-0069a_menu_hambuger"></i>
                        <span class="left-menu-title"><?php echo getPhrase('minimize_menu');?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url();?>admin/panel/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0045_home_house"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('dashboard');?></span>
                    </a>
                </li>
                <!-- Time Card -->
                <?php if(has_permission('time_card_module')):?>
                <li>
                    <a href="<?php echo base_url();?>admin/time_card/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0844_stopwatch_training_time"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('time_card');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- Tasks -->
                <?php if(has_permission('task_module')):?>
                <li>
                    <a href="<?php echo base_url();?>admin/task_dashboard/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0100_to_do_list_reminder_done"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('task_dashboard');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- Messages Access -->
                <?php if(has_permission('messages_module')):?>
                <li>
                    <a href="<?php echo base_url();?>admin/message/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0322_mail_post_box"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('messages');?></span>
                    </a>
                </li>
                <?php endif;?>
                <li>
                    <a href="<?php echo base_url();?>admin/users/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0704_users_profile_group_couple_man_woman"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('users');?></span>
                    </a>
                </li>
                <!-- Admissions Access -->
                <?php if(has_permission('admission_module')):?>
                <li>
                    <a href="<?php echo base_url();?>admin/admission_dashboard/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('admissions');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- Class Routine Access -->
                <?php if(has_permission('schedule_teacher_module')):?>
                <li>
                    <a href="<?php echo base_url();?>admin/class_routine_view/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0029_time_watch_clock_wall"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('class_routine');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- Academic Access -->
                <?php if(has_permission('academic_module')):?>
                <li>
                    <a href="<?php echo base_url();?>admin/academic/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0680_pencil_ruller_drawing"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('academic');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- Library Access -->
                <?php if(has_permission('library_module')):?>
                <li>
                    <a href="<?php echo base_url();?>admin/library/">
                        <div class="left-menu-icon">
                            <i class="os-icon picons-thin-icon-thin-0017_office_archive"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('library');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- Attendance Access -->
                <?php if(has_permission('attendance_module')):?>
                <li>
                    <a href="<?php echo base_url();?>admin/teacher_attendance/">
                        <div class="left-menu-icon">
                            <i class="os-icon picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('teacher_attendance');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- Calendar Access -->
                <?php if(has_permission('calendar_module')):?>
                <li>
                    <a href="<?php echo base_url();?>admin/calendar/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0021_calendar_month_day_planner"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('calendar');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- Polls Access -->
                <?php if(has_permission('polls_module')):?>
                <li>
                    <a href="<?php echo base_url();?>admin/polls/">
                        <div class="left-menu-icon">
                            <i class="os-icon picons-thin-icon-thin-0385_graph_pie_chart_statistics"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('polls');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- Notifications Access -->
                <?php if(has_permission('notifications_module')):?>
                <li>
                    <a href="<?php echo base_url();?>admin/notify/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0286_mobile_message_sms"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('notifications');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- Behavior Access -->
                <?php if(has_permission('request_module')):?>
                <li>
                    <a href="<?php echo base_url();?>admin/request_dashboard/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0389_gavel_hammer_law_judge_court"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('behavior');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- News Access -->
                <?php if(has_permission('news_module')):?>
                <li>
                    <a href="<?php echo base_url();?>admin/news/">
                        <div class="left-menu-icon">
                            <i class="os-icon picons-thin-icon-thin-0010_newspaper_reading_news"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('news');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- School Bus Access -->
                <?php if(has_permission('school_bus_module')):?>
                <li>
                    <a href="<?php echo base_url();?>admin/school_bus/">
                        <div class="left-menu-icon">
                            <i class="os-icon picons-thin-icon-thin-0470_bus_transport"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('school_bus');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- Classrooms Access -->
                <?php if(has_permission('classrooms_module')):?>
                <li>
                    <a href="<?php echo base_url();?>admin/classrooms/">
                        <div class="left-menu-icon">
                            <i class="os-icon picons-thin-icon-thin-0047_home_flat"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('classrooms');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- Accounting Reports Access -->
                <?php if(has_permission('accounting_module')):?>
                <li>
                    <a href="<?php echo base_url();?>reports/accounting_dashboard/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0428_money_payment_dollar_bag_cash"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('accounting_reports');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- Advisor Reports Access -->
                <?php if(has_permission('advisor_report_module')):?>
                <li>
                    <a href="<?php echo base_url();?>reports/advisor_dashboard/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0484_gauge_dashboard_full_fuel"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('advisor_reports');?></span>
                    </a>
                </li>
                <?php endif;?>
                <?php if(has_permission('academic_report_module')):?>
                <li>
                    <a href="<?php echo base_url();?>reports/academic_dashboard/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0375_screen_analytics_line_graph"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('academic_reports');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- System Reports Access -->
                <?php if(has_permission('system_reports_module')):?>
                <li>
                    <a href="<?php echo base_url();?>admin/reports_general/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0378_analytics_presentation_statistics_graph"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('system_reports');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- Academic Settings Access -->
                <?php if(has_permission('academic_settings_module')):?>
                <li>
                    <a href="<?php echo base_url();?>admin/academic_settings/">
                        <div class="left-menu-icon">
                            <i class="os-icon picons-thin-icon-thin-0006_book_writing_reading_read_manual"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('academic_settings');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- Settings Access -->
                <?php if(has_permission('settings_module')):?>
                <li>
                    <a href="<?php echo base_url();?>admin/system_settings/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0051_settings_gear_preferences"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('settings');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- helpdesk_module Access -->
                <?php if(has_permission('helpdesk_module')):?>
                <li>
                    <a href="<?php echo base_url();?>helpdesk/dashboard/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0309_support_help_talk_call"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('help_desk');?></span>
                    </a>
                </li>
                <?php endif;?>
                <!-- Settings Access -->
                <?php if(has_permission('student_month_access')):?>
                <li>
                    <a href="<?php echo base_url();?>admin/student_month_dashboard/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0659_medal_first_place_winner_award_prize_achievement"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('student_month');?></span>
                    </a>
                </li>
                <?php endif;?>
                <br><br>
                <li></li>
            </ul>
        </div>
    </div>
</div>