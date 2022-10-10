<?php 
    // validate if has access as admin/helpdesk user
    $is_helpdesk_admin = has_permission('helpdesk_admin_module');
    $is_helpdesk_team  = has_permission('helpdesk_team');
    $user_id           = $this->session->userdata('login_user_id');

?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <ul class="navs navs-tabs upper">
                    <li class="navs-item">
                        <a class="navs-links active" href="<?php echo base_url();?>admin/helpdesk_dashboard/">
                            <i class="os-icon picons-thin-icon-thin-0482_gauge_dashboard_empty"></i>
                            <span><?php echo getPhrase('dashboard');?></span>
                        </a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/helpdesk_ticket_list/">
                            <i class="os-icon picons-thin-icon-thin-0093_list_bullets"></i>
                            <span><?php echo getPhrase('ticket_list');?></span>
                        </a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/helpdesk_tutorial/">
                            <i class="os-icon picons-thin-icon-thin-0273_video_multimedia_movie"></i>
                            <span><?php echo getPhrase('video_tutorial');?></span>
                        </a>
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
                                    <a href="<?php echo base_url().'admin/helpdesk_ticket_list/'.$code_search;?>">
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
                                                                echo $this->ticket->ticket_total_created_by('status_id', $item['status_id'], $user_id);
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
                                    <a href="<?php echo base_url().'admin/helpdesk_ticket_list/'.$code_search;?>">
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
                                                                echo $this->ticket->ticket_total_created_by('priority_id', $item['priority_id'], $user_id);
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