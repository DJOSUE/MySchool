<?php 
    $account_id = get_login_user_id();
    $role_id    = get_role_id();

    $admin_type = $role_id;// $this->db->get_where('admin', array('admin_id' => $admin_id))->row()->owner_status;

    // Array Pages
    $task_pages         = array('task_dashboard', 'task_list', 'task_info');
    $message_pages      = array('message', 'group');
    $time_card_pages    = array('time_card', 'time_sheet', 'payment_period', 'worker_schedule', 'workers', 'worked_hours');
    $calendar_pages     = array('calendar');
    $helpdesk_pages     = array('helpdesk_dashboard', 'helpdesk_ticket_list', 'helpdesk_ticket_info');
    $reports_pages      = array('accounting_dashboard', 'accounting_daily_income', 'accounting_payments', 'new_payment');

?>
<div class="fixed-sidebar">
    <div class="fixed-sidebar-left sidebar--small" id="sidebar-left">
        <a href="<?php echo base_url();?>accountant/panel/" class="logo">
            <div class="img-wrap">
                <img src="<?php echo base_url();?>public/uploads/<?php echo $this->crud->getInfo('icon_white');?>">
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
                    <a href="<?php echo base_url();?>accountant/panel/" data-toggle="tooltip" data-placement="right"
                        data-original-title="<?php echo getPhrase('dashboard');?>">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0045_home_house"></i>
                        </div>
                    </a>
                </li>
                <!-- Time Card Access -->
                <?php if(has_permission('time_card_module')):?>
                <li <?= in_array($page_name, $time_card_pages) ? 'class="currentItem"' : '';?>>
                    <a href="<?php echo base_url();?>accountant/time_card/" data-toggle="tooltip" data-placement="right"
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
                    <a href="<?php echo base_url();?>assignment/task_dashboard/" data-toggle="tooltip"
                        data-placement="right" data-original-title="<?php echo getPhrase('task_dashboard');?>">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0100_to_do_list_reminder_done"></i>
                        </div>
                    </a>
                </li>
                <?php endif;?>
                <!-- Messages Access -->
                <?php if(has_permission('messages_module')):?>
                <li <?= in_array($page_name, $message_pages) ? 'class="currentItem"' : '';?>>
                    <a href="<?php echo base_url();?>accountant/message/" data-toggle="tooltip" data-placement="right"
                        data-original-title="<?php echo getPhrase('messages');?>">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0322_mail_post_box"></i>
                        </div>
                    </a>
                </li>
                <?php endif;?>
                <!-- News Access -->
                <?php if(has_permission('news_module')):?>
                <li <?php if($page_name == 'news'):?>class="currentItem" <?php endif;?>>
                    <a href="<?php echo base_url();?>accountant/news/" data-toggle="tooltip" data-placement="right"
                        data-original-title="<?php echo getPhrase('news');?>">
                        <div class="left-menu-icon">
                            <i class="os-icon picons-thin-icon-thin-0010_newspaper_reading_news"></i>
                        </div>
                    </a>
                </li>
                <?php endif;?>
                <!-- Accounting Reports Access -->
                <li <?= in_array($page_name, $reports_pages) ? 'class="currentItem"' : '';?>>
                    <a href="<?php echo base_url();?>reports/accounting_dashboard/" data-toggle="tooltip" data-placement="right"
                        data-original-title="<?php echo getPhrase('accounting_report');?>">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0428_money_payment_dollar_bag_cash"></i>
                        </div>
                    </a>
                </li>
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
                <!-- Calendar Access -->
                <?php if(has_permission('calendar_module')):?>
                <li <?= in_array($page_name, $calendar_pages) ? 'class="currentItem"' : '';?>>
                    <a href="<?php echo base_url();?>accountant/calendar/" data-toggle="tooltip" data-placement="right"
                        data-original-title="<?php echo getPhrase('calendar');?>">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0021_calendar_month_day_planner"></i>
                        </div>
                    </a>
                </li>
                <?php endif;?>
                
                <!-- Helpdesk Access -->
                <?php if(has_permission('helpdesk_module')):?>
                <li <?php if(in_array($page_name, $helpdesk_pages)):?>class="currentItem" <?php endif;?>>
                    <a href="<?php echo base_url();?>helpdesk/dashboard/" data-toggle="tooltip"
                        data-placement="right" data-original-title="<?php echo getPhrase('help_desk');?>">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0309_support_help_talk_call"></i>
                        </div>
                    </a>
                </li>
                <?php endif;?>
            </ul>
        </div>
    </div>
    <div class="fixed-sidebar-left sidebar--large" id="sidebar-left-1">
        <a href="<?php echo base_url();?>accountant/panel/" class="logo">
            <div class="img-wrap">
                <img src="<?php echo base_url();?>public/uploads/<?php echo $this->crud->getInfo('icon_white');?>">
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
                    <a href="<?php echo base_url();?>accountant/panel/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0045_home_house"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('dashboard');?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url();?>accountant/message/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0322_mail_post_box"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('messages');?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url();?>accountant/news/">
                        <div class="left-menu-icon">
                            <i class="os-icon picons-thin-icon-thin-0010_newspaper_reading_news"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('news');?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url();?>reports/accounting_dashboard/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0428_money_payment_dollar_bag_cash"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('accounting_reports');?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url();?>accountant/calendar/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0021_calendar_month_day_planner"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('calendar');?></span>
                    </a>
                </li>
                <br><br>
                <li></li>
            </ul>
        </div>
    </div>
</div>
<div class="fixed-sidebar fixed-sidebar-responsive">
    <div class="fixed-sidebar-left sidebar--small" id="sidebar-left-responsive">
        <a href="<?php echo base_url();?>accountant/panel/" class="logo js-sidebar-open">
            <img src="<?php echo base_url();?>public/uploads/<?php echo $this->crud->getInfo('icon_white');?>">
        </a>
    </div>
    <div class="fixed-sidebar-left sidebar--large" id="sidebar-left-1-responsive">
        <a href="<?php echo base_url();?>accountant/panel/" class="logo">
            <div class="img-wrap">
                <img class="nav-icon-mobile"
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
                    <a href="<?php echo base_url();?>accountant/panel/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0045_home_house"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('dashboard');?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url();?>accountant/message/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0322_mail_post_box"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('messages');?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url();?>accountant/news/">
                        <div class="left-menu-icon">
                            <i class="os-icon picons-thin-icon-thin-0010_newspaper_reading_news"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('news');?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url();?>reports/accounting_dashboard/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0428_money_payment_dollar_bag_cash"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('accounting_reports');?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url();?>accountant/calendar/">
                        <div class="left-menu-icon">
                            <i class="picons-thin-icon-thin-0021_calendar_month_day_planner"></i>
                        </div>
                        <span class="left-menu-title"><?php echo getPhrase('calendar');?></span>
                    </a>
                </li>
                <br><br>
                <li></li>
            </ul>
        </div>
    </div>
</div>