<?php 
    $account_type       =   $this->session->userdata('login_type'); 
    $fancy_path         =   $_SERVER['DOCUMENT_ROOT'].'/application/views/backend/'.$account_type.'/';

    // validate if has access as admin/helpdesk user
    $is_helpdesk_admin  = has_permission('helpdesk_admin_module');
    $is_helpdesk_team   = has_permission('helpdesk_team');
    $user_id            = $this->session->userdata('login_user_id');
    $account_type       =   $this->session->userdata('login_type'); 

?>
<div class="content-w">
    <?php include $fancy_path.'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <?php include 'helpdesk__nav.php';?>
            </div>
        </div><br>
        <div class="container-fluid">
            <div class="content-i">
                <div class="content-box">
                    <div class="element-box-tp">
                        <h5 class="form-header"><?= getPhrase('status');?></h5>
                        <div class="row">
                            <?php $statuses = $this->ticket->get_statuses();
                                foreach($statuses as $item):
                                    if($is_helpdesk_admin)
                                    {
                                        $code_search = base64_encode($item['status_id'].'|-');
                                    }
                                    else if($is_helpdesk_team)
                                    {
                                        $code_search = base64_encode($item['status_id'].'|-|1');
                                    }
                                    else
                                    {
                                        $code_search = base64_encode($item['status_id'].'|-');
                                    }
                            ?>
                            <div class="col col-xl-2 col-lg-4 col-md-4 col-sm-8 col-8">
                                <div class="ui-block list" data-mh="friend-groups-item">
                                    <a href="<?php echo base_url().$account_type.'/helpdesk_ticket_list/'.$code_search;?>">
                                        <div class="friend-item friend-groups">
                                            <div class="friend-item-content">
                                                <div class="friend-avatar">
                                                    <?php if($item['icon'] != ''):?>
                                                    <br />
                                                    <i class="picons-thin-icon-thin-<?= $item['icon'];?>"
                                                        style="font-size:45px; color: <?= $item['color'];?>;"></i>
                                                    <?php endif;?>
                                                    <h1 style="font-weight:bold;">
                                                        <?php
                                                            if($is_helpdesk_admin)
                                                            {
                                                                echo $this->ticket->ticket_total('status_id', $item['status_id']);
                                                            }
                                                            else if($is_helpdesk_team)
                                                            {
                                                                echo $this->ticket->ticket_total_assigned_to('status_id', $item['status_id'], $user_id);
                                                            }
                                                            else
                                                            {
                                                                echo $this->ticket->ticket_total_created_by('status_id', $item['status_id'], $user_id, $account_type);
                                                            }
                                                        ?>
                                                    </h1>
                                                    <div class="author-content">
                                                        <div class="country"><b> <?= $item['name'];?></b></div>
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
                            <?php $priorities = $this->ticket->get_priorities();
                                foreach($priorities as $item):
                                    
                                    if($is_helpdesk_admin)
                                    {
                                        $code_search = base64_encode('-|'.$item['priority_id']);
                                    }
                                    else if($is_helpdesk_team)
                                    {
                                        $code_search = base64_encode('-|'.$item['priority_id'].'|1');
                                    }
                                    else
                                    {
                                        $code_search = base64_encode('-|'.$item['priority_id']);
                                    }
                            ?>
                            <div class="col col-xl-2 col-lg-4 col-md-4 col-sm-8 col-8">
                                <div class="ui-block list" data-mh="friend-groups-item">
                                    <a href="<?php echo base_url().$account_type.'/helpdesk_ticket_list/'.$code_search;?>">
                                        <div class="friend-item friend-groups">
                                            <div class="friend-item-content">
                                                <div class="friend-avatar">
                                                    <?php if($item['icon'] != ''):?>
                                                    <br />
                                                    <i class="picons-thin-icon-thin-<?= $item['icon'];?>"
                                                        style="font-size:45px; color: <?= $item['color'];?>;"></i>
                                                    <?php endif;?>
                                                    <h1 style="font-weight:bold;">
                                                        <?php
                                                            if($is_helpdesk_admin)
                                                            {
                                                                echo $this->ticket->ticket_total('priority_id', $item['priority_id']);
                                                            }
                                                            else if($is_helpdesk_team)
                                                            {
                                                                echo $this->ticket->ticket_total_assigned_to('priority_id', $item['priority_id'], $user_id);
                                                            }
                                                            else
                                                            {
                                                                echo $this->ticket->ticket_total_created_by('priority_id', $item['priority_id'], $user_id, $account_type);
                                                            }                                                            
                                                        ?>
                                                    </h1>
                                                    <div class="author-content">
                                                        <div class="country"><b> <?= $item['name'];?></b></div>
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