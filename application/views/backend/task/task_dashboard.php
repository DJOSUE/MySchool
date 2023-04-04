<?php 
    
    $fancy_path         =   $_SERVER['DOCUMENT_ROOT'].'/application/views/backend/'.$account_type.'/';
    $account_type       =   get_table_user(get_role_id());    

    $this->db->reset_query();

    $user_id = get_login_user_id();

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
    <?php include $fancy_path.'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <?php include 'task__nav.php';?>
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
                                    $code_search = base64_encode($item['status_id'].'|-');
                            ?>
                            <div class="col col-xl-2 col-lg-4 col-md-4 col-sm-8 col-8">
                                <div class="ui-block list" data-mh="friend-groups-item">
                                    <a href="<?php echo base_url().'assignment/task_list/'.$code_search;?>">
                                        <div class="friend-item friend-groups">
                                            <div class="friend-item-content">
                                                <div class="friend-avatar">
                                                    <?php if($item['icon'] != ''):?>
                                                    <br />
                                                    <i class="picons-thin-icon-thin-<?= $item['icon'];?>"
                                                        style="font-size:45px; color: <?= $item['color'];?>;"></i>
                                                    <?php endif;?>
                                                    <h1 style="font-weight:bold;">
                                                        <?= $this->task->task_total_assigned_to('status_id', $item['status_id'], $user_id, $account_type)?>
                                                    </h1>
                                                    <div class="author-content">
                                                        <div class="country text-font-12"><b> <?= $item['name'];?></b></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <?php endforeach;?>
                        </div>

                        <h5 class="form-header"><?= getPhrase('priority');?></h5>
                        <div class="row">
                            <?php $priorities = $this->task->get_priorities();
                                foreach($priorities as $item):
                                    $code_search = base64_decode('-|'.$item['priority_id']);
                            ?>
                            <div class="col col-xl-2 col-lg-4 col-md-4 col-sm-8 col-8">
                                <div class="ui-block list" data-mh="friend-groups-item">
                                    <a href="<?php echo base_url().'assignment/task_list/'.$code_search;?>">
                                        <div class="friend-item friend-groups">
                                            <div class="friend-item-content">
                                                <div class="friend-avatar">
                                                    <?php if($item['icon'] != ''):?>
                                                    <br />
                                                    <i class="picons-thin-icon-thin-<?= $item['icon'];?>"
                                                        style="font-size:45px; color: <?= $item['color'];?>;"></i>
                                                    <?php endif;?>
                                                    <h1 style="font-weight:bold;">
                                                        <?= $this->task->task_total_assigned_to_no_close('priority_id', $item['priority_id'], $user_id, $account_type)?>
                                                    </h1>
                                                    <div class="author-content">
                                                        <div class="country text-font-12"><b> <?= $item['name'];?></b></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
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