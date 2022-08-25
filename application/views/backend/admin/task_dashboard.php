<?php 
    $this->db->reset_query();

    $user_id = $this->session->userdata('login_user_id');

    if($priority_id != '_blank')
    {
        $this->db->where('priority_id', $priority_id);
    }
    if($status_id != '_blank')
    {   
        $this->db->where('status_id', $status_id);
    }
    if($text != '')
    {
        $this->db->like('description' , str_replace("%20", " ", $text));
    }
    if($assigned_me == 1)
    {
        $this->db->where('assigned_to' , $user_id);
    }
    $this->db->where('user_type' , 'applicant');
    $task_query = $this->db->get('task');
    $tasks = $task_query->result_array();
?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <ul class="navs navs-tabs upper">
                    <li class="navs-item">
                        <a class="navs-links active" href="<?php echo base_url();?>admin/task_dashboard/">
                            <i
                                class="os-icon picons-thin-icon-thin-0482_gauge_dashboard_empty"></i><span><?php echo getPhrase('dashboard');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/task_applicant/">
                            <i
                                class="os-icon picons-thin-icon-thin-0716_user_profile_add_new"></i><span><?php echo getPhrase('task_applicants');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/task_student/">
                            <i
                                class="os-icon picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i><span><?php echo getPhrase('task_students');?></span></a>
                    </li>
                </ul>
            </div>
        </div><br>
        <div class="container-fluid">
            <div class="content-i">
                <div class="content-box">
                    <div class="element-box-tp">
                        <h5 class="form-header"><?= getPhrase('status');?></h5>
                        <div class="row">
                            <?php $statuses = $this->task->get_statuses();
                                foreach($statuses as $item):
                            ?>                            
                            <div class="col col-xl-2 col-lg-4 col-md-4 col-sm-8 col-8">
                                <div class="ui-block list" data-mh="friend-groups-item">
                                    <div class="friend-item friend-groups">
                                        <div class="friend-item-content">
                                            <div class="friend-avatar">
                                                <?php if($item['icon'] != ''):?>
                                                <br/>
                                                <i class="picons-thin-icon-thin-<?= $item['icon'];?>" style="font-size:45px; color: <?= $item['color'];?>;"></i>
                                                <?php endif;?>
                                                <h1 style="font-weight:bold;"><?= $this->task->task_total('status_id', $item['status_id'])?></h1>
                                                <div class="author-content">
                                                    <div class="country"><b> <?= $item['name'];?></b></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach;?>
                        </div>
                        
                        <h5 class="form-header"><?= getPhrase('priority');?></h5>
                        <div class="row">
                            <?php $priorities = $this->task->get_priorities();
                                foreach($priorities as $item):
                            ?>                            
                            <div class="col col-xl-2 col-lg-4 col-md-4 col-sm-8 col-8">
                                <div class="ui-block list" data-mh="friend-groups-item">
                                    <div class="friend-item friend-groups">
                                        <div class="friend-item-content">
                                            <div class="friend-avatar">
                                                <?php if($item['icon'] != ''):?>
                                                <br/>
                                                <i class="picons-thin-icon-thin-<?= $item['icon'];?>" style="font-size:45px; color: <?= $item['color'];?>;"></i>
                                                <?php endif;?>
                                                <h1 style="font-weight:bold;"><?= $this->task->task_total('priority_id', $item['priority_id'])?></h1>
                                                <div class="author-content">
                                                    <div class="country"><b> <?= $item['name'];?></b></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach;?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>