<?php 
    // Array Pages
    $message_pages      = array('message', 'group');
    $academic_pages     = array('attendance_report', 'online_exam_result', 'study_material', 'live', 'meet', 'homework_edit', 'subject_marks', 
                                'forum', 'forum_room', 'subject', 'subject_dashboard', 'homework_room', 'homework', 'online_exams', 'subject_daily_marks', 
                                'subject_daily_marks_all');
    $marks_pages        = array('my_marks', 'my_daily_marks', 'my_daily_marks_old', 'my_past_marks', 'my_past_daily_marks', 'student_placement_achievement');
?>
<div class="fixed-sidebar">
    <div class="fixed-sidebar-left sidebar--small" id="sidebar-left">
        <a href="<?php echo base_url();?>student/panel/" class="logo">
            <div class="img-wrap">
                <img class="nav-icon" src="<?php echo base_url();?>public/uploads/<?php echo $this->crud->getInfo('icon_white');?>">
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
                    <a href="<?php echo base_url();?>student/panel/" data-toggle="tooltip" data-placement="right"
                        data-original-title="<?php echo getPhrase('dashboard');?>">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0045_home_house"></i>
                        </div>
                    </a>
                </li>
                <li class="<?= in_array($page_name, $message_pages) ? 'currentItem' : '';?>">
                    <a href="<?php echo base_url();?>student/message/" data-toggle="tooltip" data-placement="right"
                        data-original-title="<?php echo getPhrase('messages');?>">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0322_mail_post_box"></i>
                        </div>
                    </a>
                </li>
                <li <?php if($page_name == 'teachers'):?>class="currentItem" <?php endif;?>>
                    <a href="<?php echo base_url();?>student/teachers/" data-toggle="tooltip" data-placement="right"
                        data-original-title="<?php echo getPhrase('teachers');?>">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0704_users_profile_group_couple_man_woman"></i>
                        </div>
                    </a>
                </li>
                <li class="<?= in_array($page_name, $academic_pages) ? 'currentItem' : '';?>">
                    <a href="<?php echo base_url();?>student/subject/" data-toggle="tooltip" data-placement="right"
                        data-original-title="<?php echo getPhrase('academic');?>">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0680_pencil_ruller_drawing"></i>
                        </div>
                    </a>
                </li>
                <li class="<?= in_array($page_name, $marks_pages) ? 'currentItem' : '';?>">
                    <a href="<?php echo base_url();?>student/my_marks/" data-toggle="tooltip" data-placement="right"
                        data-original-title="<?php echo getPhrase('marks');?>">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i>
                        </div>
                    </a>
                </li>
                <?php if(menu_option_visible('class_routine')):?>
                <li <?php if($page_name == 'class_routine'):?>class="currentItem" <?php endif;?>>
                    <a href="<?php echo base_url();?>student/class_routine/" data-toggle="tooltip"
                        data-placement="right" data-original-title="<?php echo getPhrase('class_routine');?>">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0029_time_watch_clock_wall"></i>
                        </div>
                    </a>
                </li>
                <?php endif; ?>
                <?php if(menu_option_visible('library')):?>
                <li <?php if($page_name == 'library'):?>class="currentItem" <?php endif;?>>
                    <a href="<?php echo base_url();?>student/library/" data-toggle="tooltip" data-placement="right"
                        data-original-title="<?php echo getPhrase('library');?>">
                        <div class="left-menu-icon">
                            <i class="os-icon picons-thin-icon-thin-0017_office_archive"></i>
                        </div>
                    </a>
                </li>
                <?php endif; ?>
                <li <?php if($page_name == 'noticeboard'):?>class="currentItem" <?php endif;?>>
                    <a href="<?php echo base_url();?>student/noticeboard/" data-toggle="tooltip" data-placement="right"
                        data-original-title="<?php echo getPhrase('news');?>">
                        <div class="left-menu-icon">
                            <i class="os-icon picons-thin-icon-thin-0010_newspaper_reading_news"></i>
                        </div>
                    </a>
                </li>
                <?php if(menu_option_visible('permissions')):?>
                <li <?php if($page_name == 'request'):?>class="currentItem" <?php endif;?>>
                    <a href="<?php echo base_url();?>student/request/" data-toggle="tooltip" data-placement="right"
                        data-original-title="<?php echo getPhrase('permissions');?>">
                        <div class="left-menu-icon">
                            <i class="os-icon picons-thin-icon-thin-0015_fountain_pen"></i>
                        </div>
                    </a>
                </li>
                <?php endif; ?>
                <?php if(menu_option_visible('teacher_reports')):?>
                <li <?php if($page_name == 'send_report' || $page_name == 'view_report'):?>class="currentItem"
                    <?php endif;?>>
                    <a href="<?php echo base_url();?>student/send_report/" data-toggle="tooltip" data-placement="right"
                        data-original-title="<?php echo getPhrase('teacher_reports');?>">
                        <div class="left-menu-icon">
                            <i class="os-icon picons-thin-icon-thin-0389_gavel_hammer_law_judge_court"></i>
                        </div>
                    </a>
                </li>
                <?php endif;?>
                <li <?php if($page_name == 'calendar'):?>class="currentItem" <?php endif;?>>
                    <a href="<?php echo base_url();?>student/calendar/" data-toggle="tooltip" data-placement="right"
                        data-original-title="<?php echo getPhrase('calendar');?>">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0021_calendar_month_day_planner"></i>
                        </div>
                    </a>
                </li>
                <?php if(menu_option_visible('payments')):?>
                <li <?php if($page_name == 'invoice' || $page_name == 'view_invoice'):?>class="currentItem"
                    <?php endif;?>>
                    <a href="<?php echo base_url();?>student/invoice/" data-toggle="tooltip" data-placement="right"
                        data-original-title="<?php echo getPhrase('payments');?>">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0426_money_payment_dollars_coins_cash"></i>
                        </div>
                    </a>
                </li>
                <?php endif; ?>
                <?php if(!menu_option_visible('school_books')):?>
                <li <?php if($page_name == 'book' ):?>class="currentItem"
                    <?php endif;?>>
                    <a href="<?php echo base_url();?>books/" data-toggle="tooltip" data-placement="right"
                        data-original-title="<?php echo getPhrase('school_books');?>">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0008_book_reading_read_manual"></i>
                        </div>
                    </a>
                </li>
                <?php endif;?>
            </ul>
        </div>
    </div>

    <div class="fixed-sidebar-left sidebar--large" id="sidebar-left-1">
        <a href="<?php echo base_url();?>student/panel/" class="logo">
            <div class="img-wrap">
                <img class="nav-icon"  src="<?php echo base_url();?>public/uploads/<?php echo $this->crud->getInfo('icon_white');?>">
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
                    <a href="<?php echo base_url();?>student/panel/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0045_home_house"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('dashboard');?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url();?>student/message/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0322_mail_post_box"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('messages');?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url();?>student/teachers/" data-toggle="tooltip" data-placement="right"
                        data-original-title="<?php echo getPhrase('teachers');?>">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0704_users_profile_group_couple_man_woman"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('teachers');?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url();?>student/subject/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0680_pencil_ruller_drawing"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('academic');?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url();?>student/my_marks/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('marks');?></span>
                    </a>
                </li>
                <?php if(menu_option_visible('class_routine')):?>
                <li>
                    <a href="<?php echo base_url();?>student/class_routine/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0029_time_watch_clock_wall"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('class_routine');?></span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if(menu_option_visible('library')):?>
                <li>
                    <a href="<?php echo base_url();?>student/library/">
                        <div class="left-menu-icon">
                            <i class="os-icon picons-thin-icon-thin-0017_office_archive"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('library');?></span>
                    </a>
                </li>
                <?php endif; ?>
                <li>
                    <a href="<?php echo base_url();?>student/noticeboard/">
                        <div class="left-menu-icon">
                            <i class="os-icon picons-thin-icon-thin-0010_newspaper_reading_news"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('news');?></span>
                    </a>
                </li>                
                <?php if(menu_option_visible('permissions')):?>
                <li>
                    <a href="<?php echo base_url();?>student/request/">
                        <div class="left-menu-icon">
                            <i class="os-icon picons-thin-icon-thin-0015_fountain_pen"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('permissions');?></span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if(menu_option_visible('students_reports')):?>                
                <li>
                    <a href="<?php echo base_url();?>student/send_report/">
                        <div class="left-menu-icon">
                            <i class="os-icon picons-thin-icon-thin-0389_gavel_hammer_law_judge_court"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('teacher_reports');?></span>
                    </a>
                </li>
                <?php endif;?>
                <li>
                    <a href="<?php echo base_url();?>student/calendar/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0021_calendar_month_day_planner"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('calendar');?></span>
                    </a>
                </li>
                <?php if(menu_option_visible('payments')):?>
                <li>
                    <a href="<?php echo base_url();?>student/invoice/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0426_money_payment_dollars_coins_cash"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('payments');?></span>
                    </a>
                </li>
                <?php endif;?>
                <?php if(!menu_option_visible('school_books')):?>
                <li>
                    <a href="<?php echo base_url();?>books/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0008_book_reading_read_manual"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('school_books');?></span>
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
        <a href="<?php echo base_url();?>student/panel/" class="logo js-sidebar-open">
            <img class="nav-icon" src="<?php echo base_url();?>public/uploads/<?php echo $this->crud->getInfo('icon_white');?>">
        </a>
    </div>
    <div class="fixed-sidebar-left sidebar--large" id="sidebar-left-1-responsive">
        <a href="<?php echo base_url();?>student/panel/" class="logo">
            <div class="img-wrap">
                <img class="nav-icon-mobile" src="<?php echo base_url();?>public/uploads/<?php echo $this->crud->getInfo('icon_white');?>">
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
                    <a href="<?php echo base_url();?>student/panel/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0045_home_house"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('dashboard');?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url();?>student/message/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0322_mail_post_box"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('messages');?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url();?>student/teachers/" data-toggle="tooltip" data-placement="right"
                        data-original-title="<?php echo getPhrase('teachers');?>">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0704_users_profile_group_couple_man_woman"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('teachers');?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url();?>student/subject/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0680_pencil_ruller_drawing"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('academic');?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url();?>student/my_marks/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('marks');?></span>
                    </a>
                </li>
                <?php if(menu_option_visible('class_routine')):?>
                <li>
                    <a href="<?php echo base_url();?>student/class_routine/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0029_time_watch_clock_wall"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('class_routine');?></span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if(menu_option_visible('library')):?>
                <li>
                    <a href="<?php echo base_url();?>student/library/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0017_office_archive"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('library');?></span>
                    </a>
                </li>
                <?php endif; ?>
                <li>
                    <a href="<?php echo base_url();?>student/noticeboard/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0010_newspaper_reading_news"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('news');?></span>
                    </a>
                </li>
                <?php if(menu_option_visible('permissions')):?>
                <li>
                    <a href="<?php echo base_url();?>student/request/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0015_fountain_pen"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('permissions');?></span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if(menu_option_visible('teacher_reports')):?>
                <li>
                    <a href="<?php echo base_url();?>student/send_report/">
                        <div class="left-menu-icon">
                            <i class="os-icon picons-thin-icon-thin-0389_gavel_hammer_law_judge_court"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('teacher_reports');?></span>
                    </a>
                </li>
                <?php endif;?>
                <li>
                    <a href="<?php echo base_url();?>student/calendar/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0021_calendar_month_day_planner"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('calendar');?></span>
                    </a>
                </li>
                <?php if(menu_option_visible('payments')):?>
                <li>
                    <a href="<?php echo base_url();?>student/invoice/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0426_money_payment_dollars_coins_cash"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('payments');?></span>
                    </a>
                </li>
                <?php endif;?>
                <?php if(!menu_option_visible('school_books')):?>
                <li>
                    <a href="<?php echo base_url();?>books/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0008_book_reading_read_manual"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('school_books');?></span>
                    </a>
                </li>
                <?php endif;?>
                <br><br>
                <li></li>
            </ul>
        </div>
    </div>
</div>