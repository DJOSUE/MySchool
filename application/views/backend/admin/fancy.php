<?php 
    $fancy_count = $this->db->get_where('notification', array('user_id' => get_login_user_id(), 'user_type' => get_account_type(), 'status' => '0'));
    $fancy_number = $this->crud->count_unread_messages();
    $fc_info = base64_decode($class_id);
    $fc_info_data = base64_decode($data); $fc_ex = explode("-", $fc_info_data);

    $running_year       = $this->crud->getInfo('running_year');
    $running_semester   = $this->crud->getInfo('running_semester'); 
?>

<header class="header" id="site-header">
    <?php if($page_name == 'users' || $page_name == 'admins' || $page_name == 'pending' || $page_name == 'teachers' || $page_name == 'students' || $page_name == 'parents' || $page_name == 'accountant' || $page_name == 'librarian'):?>
    <div class="page-title">
        <div class="fancy-selector-w">
            <div class="fancy-selector-current">
                <div class="fs-img">
                    <img alt=""
                        src="<?php echo base_url();?>public/uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>">
                </div>
                <div class="fs-main-info">
                    <div class="fs-name"><?php echo getPhrase($page_name);?></div>
                </div>
                <div class="fs-selector-trigger">
                    <i class="ti-angle-down"></i>
                </div>
            </div>
            <div class="fancy-selector-options active">
                <a href="<?php echo base_url();?>admin/admins/">
                    <div class="fancy-selector-option">
                        <div class="fs-img">
                            <img alt="" src="<?php echo base_url();?>public/uploads/icons/admins.svg">
                        </div>
                        <div class="fs-main-info">
                            <div class="fs-name">
                                <?php echo getPhrase('admins');?>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="<?php echo base_url();?>admin/teachers/">
                    <div class="fancy-selector-option">
                        <div class="fs-img">
                            <img alt="" src="<?php echo base_url();?>public/uploads/icons/teachers.svg">
                        </div>
                        <div class="fs-main-info">
                            <div class="fs-name">
                                <?php echo getPhrase('teachers');?>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="<?php echo base_url();?>admin/students/">
                    <div class="fancy-selector-option">
                        <div class="fs-img">
                            <img alt="" src="<?php echo base_url();?>public/uploads/icons/students.svg">
                        </div>
                        <div class="fs-main-info">
                            <div class="fs-name">
                                <?php echo getPhrase('students');?>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="<?php echo base_url();?>admin/parents/">
                    <div class="fancy-selector-option">
                        <div class="fs-img">
                            <img alt="" src="<?php echo base_url();?>public/uploads/icons/parents.svg">
                        </div>
                        <div class="fs-main-info">
                            <div class="fs-name">
                                <?php echo getPhrase('parents');?>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="<?php echo base_url();?>admin/accountant/">
                    <div class="fancy-selector-option">
                        <div class="fs-img">
                            <img alt="" src="<?php echo base_url();?>public/uploads/icons/accountant.svg">
                        </div>
                        <div class="fs-main-info">
                            <div class="fs-name">
                                <?php echo getPhrase('accountants');?>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="<?php echo base_url();?>admin/librarian/">
                    <div class="fancy-selector-option">
                        <div class="fs-img">
                            <img alt="" src="<?php echo base_url();?>public/uploads/icons/librarian.svg">
                        </div>
                        <div class="fs-main-info">
                            <div class="fs-name">
                                <?php echo getPhrase('librarians');?>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <?php endif;?>
    <?php if($page_name == 'meet' || $page_name == 'subject_dashboard' || $page_name == 'upload_marks' || $page_name == 'online_exams' || $page_name == 'homework' || $page_name == 'forum' || $page_name == 'study_material' || $page_name == 'subject_marks' || $page_name == 'daily_marks' || $page_name == 'daily_marks_average'):?>
    <div class="page-title">
        <div class="fancy-selector-w">
            <div class="fancy-selector-current">
                <div class="fs-img">
                    <img alt=""
                        src="<?php echo base_url();?>public/uploads/subject_icon/<?php echo $this->db->get_where('subject', array('subject_id' => $fc_ex[2], 'section_id' => $fc_ex[1], 'year' => $running_year, 'semester_id' => $running_semester))->row()->icon;?>">
                </div>
                <div class="fs-main-info">
                    <div class="fs-name">
                        <?php echo $this->db->get_where('subject', array('subject_id' => $fc_ex[2], 'section_id' => $fc_ex[1], 'year' => $running_year, 'semester_id' => $running_semester))->row()->name;?>
                        -
                        (<?php echo $this->db->get_where('section', array('section_id' => $fc_ex[1], 'year' => $running_year, 'semester_id' => $running_semester))->row()->name;?>)
                    </div>
                </div>
                <div class="fs-selector-trigger">
                    <i class="ti-angle-down"></i>
                </div>
            </div>
            <div class="fancy-selector-options active">
                <?php 
                    $fancy_subjects = $this->db->get_where('subject', array('class_id' => $fc_ex[0], 'section_id' => $fc_ex[1], 'year' => $running_year, 'semester_id' => $running_semester ))->result_array();
                    foreach($fancy_subjects as $fancy_row2):
                ?>
                <a
                    href="<?php echo base_url();?>admin/subject_dashboard/<?php echo base64_encode($fc_ex[0].'-'.$fc_ex[1].'-'.$fancy_row2['subject_id']);?>/">
                    <div class="fancy-selector-option">
                        <div class="fs-img">
                            <img alt=""
                                src="<?php echo base_url();?>public/uploads/subject_icon/<?php echo $fancy_row2['icon'];?>">
                        </div>
                        <div class="fs-main-info">
                            <div class="fs-name">
                                <?php echo $fancy_row2['name'];?> -
                                (<?php echo $this->db->get_where('section', array('section_id' => $fc_ex[1], 'year' => $running_year, 'semester_id' => $running_semester))->row()->name;?>)
                            </div>
                        </div>
                    </div>
                </a>
                <?php endforeach;?>
            </div>
        </div>
    </div>
    <?php endif;?>
    <?php if($page_name == 'cursos'):?>
    <div class="page-title">
        <div class="fancy-selector-w">
            <div class="fancy-selector-current">
                <div class="fs-main-info">
                    <div class="fs-name">
                        <?php echo $this->db->get_where('class', array('class_id' => $fc_info))->row()->name;?></div>
                </div>
                <div class="fs-selector-trigger">
                    <i class="ti-angle-down"></i>
                </div>
            </div>
            <div class="fancy-selector-options">
                <?php 
                    $fancy_subjects = $this->db->get_where('class')->result_array();
                    foreach($fancy_subjects as $fancy_row2):
                ?>
                <a href="<?php echo base_url();?>admin/cursos/<?php echo base64_encode($fancy_row2['class_id']);?>/">
                    <div class="fancy-selector-option <?php if($fc_info == $fancy_row2['class_id']) echo "active";?>">
                        <div class="fs-main-info">
                            <div class="fs-name">
                                <?php echo $fancy_row2['name'];?>
                            </div>
                        </div>
                    </div>
                </a>
                <?php endforeach;?>
            </div>
        </div>
    </div>
    <?php endif;?>
    <div class="header-content-wrapper" <?php if($page_name != 'cursos'):?> style="padding-left: 85px;" <?php endif;?>>
        <?php echo form_open(base_url() . 'admin/search_query' , array('class' => 'search-bar w-search notification-list friend-requests', 'onsubmit' => 'return validate() role="search"')); ?>
        <div class="form-group with-button">
            <input class="form-control js-user-se arch" placeholder="<?php echo getPhrase('search_students');?>..."
                type="text" value="<?php echo base64_decode($search_key);?>" name="search_key" required>
            <button type="submit"><i class="picons-thin-icon-thin-0033_search_find_zoom"></i></button>
        </div>
        <?php echo form_close();?>
        <div class="control-block">
            <div class="control-icon more has-items">
                <i class="picons-thin-icon-thin-0309_support_help_talk_call"
                    onclick="showAjaxModal('<?= base_url();?>modal/popup_helpdesk/modal_ticket_add/');"></i>
            </div>
            <div class="control-icon more has-items">
                <i class="picons-thin-icon-thin-0275_chat_message_comment_bubble_typing"></i>
                <?php if($fancy_number > 0):?><div class="label-avatar bg-success"><?php echo $fancy_number;?></div>
                <?php endif;?>
                <div class="more-dropdown more-with-triangle triangle-top-center">
                    <div class="mCustomScrollbar" data-mcs-theme="dark">
                        <ul class="notification-list chat-message">
                            <?php 
                                $fancy_current_user = get_account_type() . '-' . get_login_user_id();
                                $fancy_message_threads = $this->crud->getFancyChat();
                                foreach ($fancy_message_threads as $fancy_rows):
                                if ($fancy_rows['sender'] == $fancy_current_user)
                                {
                                    $fancy_user_to_show = explode('-', $fancy_rows['reciever']);
                                }
                                if ($fancy_rows['reciever'] == $fancy_current_user)
                                {
                                    $fancy_user_to_show = explode('-', $fancy_rows['sender']);
                                }
                                $fancy_user_to_show_type = $fancy_user_to_show[0];
                                $fancy_user_to_show_id = $fancy_user_to_show[1];
                                $unread_message_number = $this->crud->count_unread_message_of_thread($fancy_rows['message_thread_code']);
                            ?>
                            <?php $this->db->where('message_thread_code',$fancy_rows['message_thread_code']); $rw= $this->db->get('message')->last_row();?>
                            <?php $dbinfos = explode('-',$rw->sender);?>
                            <li class="message-unread">
                                <div class="author-thumb">
                                    <img src="<?php echo $this->crud->get_image_url($fancy_user_to_show_type, $fancy_user_to_show_id);?>"
                                        width="35px">
                                </div>
                                <div class="notification-event">
                                    <a href="<?php echo base_url();?>admin/message/message_read/<?php echo $fancy_rows['message_thread_code'];?>/"
                                        class="h6 notification-friend"><?php echo $this->crud->get_name($fancy_user_to_show_type, $fancy_user_to_show_id);?></a>
                                    <span class="chat-message-item"
                                        style="text-align: justify;"><?php if($rw->sender == $fancy_current_user) echo getPhrase('you').": " .substr($rw->message, 0, 90).'...'; else echo substr($rw->message, 0, 90);?>...</span>
                                    <span class="notification-date"><time
                                            class="entry-date updated"><?php echo $rw->timestamp;?></time></span>
                                </div>
                            </li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                    <a href="<?php echo base_url();?>admin/message/"
                        class="view-all bg-info"><?php echo getPhrase('view_all_messages');?></a>
                </div>
            </div>
            <div class="control-icon more has-items">
                <i class="picons-thin-icon-thin-0543_world_earth_worldwide_location_travel"></i>
                <?php if($fancy_count->num_rows() > 0):?><div class="label-avatar bg-success">
                    <?php echo $fancy_count->num_rows();?> </div><?php endif;?>
                <div class="more-dropdown more-with-triangle triangle-top-center">
                    <div class="mCustomScrollbar" data-mcs-theme="dark">
                        <ul class="notification-list">
                            <?php 
                                $this->db->limit(5);
                                $this->db->order_by('id', 'desc');
                                $n = $this->crud->fetchNotifications();
                                foreach($n as $fancy_notify):
                            ?>
                            <li>
                                <div class="author-thumb">
                                    <img alt="" src="<?php echo base_url();?>public/uploads/notify.svg" width="35px">
                                </div>
                                <div class="notification-event">
                                    <div>
                                        <a href="<?php echo base_url();?><?php echo $fancy_notify['url'];?><?php if($fancy_notify['status'] == 0) {echo "?id=".$fancy_notify['id'];}?>"
                                            class="h6 notification-friend"> <?php echo $fancy_notify['notify'];?></a>
                                    </div>
                                    <span class="notification-date"><time
                                            class="entry-date updated"><?php echo $fancy_notify['date'];?>
                                            <?php echo getPhrase('at');?>
                                            <?php echo $fancy_notify['time'];?></time></span>
                                </div>
                            </li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                    <a href="<?php echo base_url();?>admin/notifications/"
                        class="view-all bg-info"><?php echo getPhrase('view_all_notifications');?></a>
                </div>
            </div>
            <div class="author-page author vcard inline-items more">
                <div class="author-thumb">
                    <img alt="author"
                        src="<?php echo $this->crud->get_image_url('admin', get_login_user_id());?>"
                        class="avatar bg-white" width="32px">
                    <div class="more-dropdown more-with-triangle">
                        <div class="mCustomScrollbar" data-mcs-theme="dark">
                            <ul class="account-settings">
                                <li>
                                    <a href="<?php echo base_url();?>admin/my_account/">
                                        <i class="picons-thin-icon-thin-0699_user_profile_avatar_man_male"></i>
                                        <span><?php echo getPhrase('my_account');?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url();?>login/logout/">
                                        <i class="picons-thin-icon-thin-0040_exit_logout_door_emergency_outside"></i>
                                        <span><?php echo getPhrase('logout');?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url();?>helpdesk/helpdesk_tutorial/">
                                        <i class="picons-thin-icon-thin-0308_support_help"></i>
                                        <span><?php echo getPhrase('help');?></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <a href="javascript:void(0);" class="author-name fn">
                    <div class="author-title">
                        <?php echo $this->crud->get_name('admin', get_login_user_id());?> <svg
                            class="olymp-dropdown-arrow-icon">
                            <use
                                xlink:href="<?php echo base_url();?>public/style/olapp/svg-icons/sprites/icons.svg#olymp-dropdown-arrow-icon">
                            </use>
                        </svg>
                    </div>
                    <span class="author-subtitle">
                        <?php 
                            $role_id = get_role_id();
                            echo $this->system->get_role_name($role_id);
                        ?>
                    </span>
                </a>
            </div>
        </div>
    </div>
</header>
<header class="header header-responsive" id="site-header-responsive">
    <div class="header-content-wrapper">
        <ul class="nav nav-tabs mobile-app-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#helpdesk" role="tab">
                    <div class="control-icon has-items">
                        <i class="picons-thin-icon-thin-0309_support_help_talk_call"
                        onclick="showAjaxModal('<?= base_url();?>modal/popup_helpdesk/modal_ticket_add/');"></i>
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#chat" role="tab">
                    <div class="control-icon has-items">
                        <i class="picons-thin-icon-thin-0275_chat_message_comment_bubble_typing"></i>
                        <?php if($fancy_number > 0):?><div class="label-avatar bg-success"><?php echo $fancy_number;?>
                        </div><?php endif;?>
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#notification" role="tab">
                    <div class="control-icon has-items">
                        <i class="picons-thin-icon-thin-0543_world_earth_worldwide_location_travel"></i>
                        <?php if($fancy_count->num_rows() > 0):?><div class="label-avatar bg-success">
                            <?php echo $fancy_count->num_rows();?> </div><?php endif;?>
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#autor" role="tab">
                    <div class="author-page author vcard inline-items more top16">
                        <div class="author-thumb imgs">
                            <img alt="author"
                                src="<?php echo $this->crud->get_image_url(get_account_type(), get_login_user_id());?>"
                                class="avatar bg-white" width="35px">
                        </div>
                    </div>
                </a>
            </li>
        </ul>
    </div>
    <div class="tab-content tab-content-responsive">
        <div class="tab-pane " id="helpdesk" role="tabpanel">            
        </div>
        <div class="tab-pane " id="chat" role="tabpanel">
            <div class="mCustomScrollbar" data-mcs-theme="dark">
                <ul class="notification-list chat-message">
                    <?php 
                        $fancy_current_user = get_account_type() . '-' . get_login_user_id();
                        $fancy_message_threads = $this->crud->getFancyChat();
                        foreach ($fancy_message_threads as $row1):
                        if ($row1['sender'] == $fancy_current_user)
                        {
                            $fancy_user_to_show = explode('-', $row1['reciever']);
                        }
                        if ($row1['reciever'] == $fancy_current_user)
                        {
                            $fancy_user_to_show = explode('-', $row1['sender']);
                        }
                        $fancy_user_to_show_type = $fancy_user_to_show[0];
                        $fancy_user_to_show_id = $fancy_user_to_show[1];
                        $unread_message_number = $this->crud->count_unread_message_of_thread($row1['message_thread_code']);
                    ?>
                    <?php $this->db->where('message_thread_code',$row1['message_thread_code']); $rw= $this->db->get('message')->last_row();?>
                    <?php $dbinf = explode('-',$rw->sender);?>
                    <li class="message-unread">
                        <div class="author-thumb">
                            <img src="<?php echo $this->crud->get_image_url($fancy_user_to_show_type, $fancy_user_to_show_id);?>"
                                width="35px">
                        </div>
                        <div class="notification-event">
                            <a href="<?php echo base_url();?>admin/message/message_read/<?php echo $row1['message_thread_code'];?>/"
                                class="h6 notification-friend"><?php echo $this->crud->get_name($fancy_user_to_show_type, $fancy_user_to_show_id);?></a>
                            <span class="chat-message-item"
                                style="text-align: justify;"><?php if($rw->sender == $fancy_current_user) echo getPhrase('you').": ". substr($rw->message, 0, 90).'...'; else echo substr($rw->message, 0, 90);?>...</span>
                            <span class="notification-date"><time
                                    class="entry-date updated"><?php echo $rw->timestamp;?></time></span>
                        </div>
                    </li>
                    <?php endforeach;?>
                </ul>
                <a href="<?php echo base_url();?>admin/message/"
                    class="view-all bg-info"><?php echo getPhrase('view_all_messages');?></a>
            </div>
        </div>
        <div class="tab-pane " id="notification" role="tabpanel">
            <div class="mCustomScrollbar" data-mcs-theme="dark">
                <ul class="notification-list">
                    <?php 
                        $n = $this->crud->fetchNotifications();
                        foreach($n as $fancy_notify):
                    ?>
                    <li>
                        <div class="author-thumb">
                            <img alt="" src="<?php echo base_url();?>public/uploads/notify.svg" width="35px">
                        </div>
                        <div class="notification-event">
                            <div>
                                <a href="<?php echo base_url();?><?php echo $fancy_notify['url'];?><?php if($fancy_notify['status'] == 0) {echo "?id=".$fancy_notify['id'];}?>"
                                    class="h6 notification-friend"> <?php echo $fancy_notify['notify'];?></a>
                            </div>
                            <span class="notification-date"><time
                                    class="entry-date updated"><?php echo $fancy_notify['date'];?>
                                    <?php echo getPhrase('at');?> <?php echo $fancy_notify['time'];?></time></span>
                        </div>
                    </li>
                    <?php endforeach;?>
                </ul>
                <a href="<?php echo base_url();?>admin/notifications/"
                    class="view-all bg-info"><?php echo getPhrase('view_all_notifications');?></a>
            </div>
        </div>
        <div class="tab-pane " id="autor" role="tabpanel">
            <div class="mCustomScrollbar" data-mcs-theme="dark">
                <ul class="account-settings">
                    <li>
                        <a href="<?php echo base_url();?>admin/my_account/">
                            <i class="picons-thin-icon-thin-0699_user_profile_avatar_man_male"></i>
                            <span><?php echo getPhrase('my_profile');?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url();?>login/logout/">
                            <i class="picons-thin-icon-thin-0040_exit_logout_door_emergency_outside"></i>
                            <span><?php echo getPhrase('logout');?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url();?>helpdesk/helpdesk_tutorial/">
                            <i class="picons-thin-icon-thin-0308_support_help"></i>
                            <span><?php echo getPhrase('help');?></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>