<?php 
    $account_type       =   get_account_type(); 
    $fancy_path         =   $_SERVER['DOCUMENT_ROOT'].'/application/views/backend/'.$account_type.'/';

    $this->db->reset_query();
    $this->db->where('ticket_code' , $ticket_code);
    $ticket_query = $this->db->get('ticket');
    $tickets = $ticket_query->result_array();

    $interactions = $this->ticket->get_ticket_interactions($ticket_code);
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
        <div class="row">
            <div class="content-i">
                <div class="content-box">
                    <div class="row">
                        <?php 
                        foreach ($tickets as $row):
                            $user_info      = $this->crud->get_user_info($row['created_by_type'], $row['created_by']);
                            $status_info    = $this->ticket->get_status_info($row['status_id']);
                            $priority_info  = $this->ticket->get_priority_info($row['priority_id']);
                            $description    = html_entity_decode(str_replace(array("\r", "\n"), '', $row['description']));
                            $allow_actions  = false;// $this->ticket->is_ticket_closed($row['status_id']);

                            // echo '<pre>';
                            // var_dump($row['created_by_type']);
                            // echo '</pre>';                            
                        ?>
                        <main class="col col-xl-9 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
                            <div id="newsfeed-items-grid">
                                <div class="ui-block paddingtel">
                                    <div class="user-profile">
                                        <div class="up-controls">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="value-pair">
                                                        <div><?= getPhrase('priority');?>:</div>
                                                        <div class="value badge-status badge-pill badge-primary"
                                                            style="background-color: <?= $priority_info['color']?>;">
                                                            <?= $priority_info['name'];?>
                                                        </div>
                                                    </div>
                                                    <div class="value-pair">
                                                        <div><?= getPhrase('status_ticket');?>:</div>
                                                        <div class="value badge-status badge-pill badge-primary"
                                                            style="background-color: <?= $status_info['color']?>;">
                                                            <?= $status_info['name'];?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ui-block">
                                            <div class="ui-block-title">
                                                <h6 class="title"><?= getPhrase('user_information');?>
                                                </h6>
                                            </div>
                                            <div class="ui-block-content">
                                                <div class="row">
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <ul class="widget w-personal-info item-block">
                                                            <li>
                                                                <span class="title"><?= getPhrase('name');?>:</span>
                                                                <span class="text"><?= $user_info['first_name'];?>
                                                                    <?= $user_info['last_name'];?></span>
                                                            </li>
                                                            <li>
                                                                <span class="title"><?= getPhrase('email');?>:</span>
                                                                <span class="text"><?= $user_info['email'];?></span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <ul class="widget w-personal-info item-block">
                                                            <li>
                                                                <span class="title"><?= getPhrase('phone');?>:</span>
                                                                <span class="text"><?= $user_info['phone'];?></span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ui-block">
                                            <div class="ui-block-title">
                                                <h6 class="title"><?= getPhrase('ticket_information');?>
                                                </h6>
                                            </div>
                                            <div class="ui-block-content">
                                                <div class="row">
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <ul class="widget w-personal-info item-block">
                                                            <li>
                                                                <span class="title"><?= getPhrase('title');?>:</span>
                                                                <span class="text"><?= $row['title'];?></span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <ul class="widget w-personal-info item-block">
                                                            <li>
                                                                <span
                                                                    class="title"><?= getPhrase('assigned_to');?>:</span>
                                                                <span
                                                                    class="text"><?= $this->crud->get_name('admin',$row['assigned_to']);?></span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <?php if($row['ticket_file']):?>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <ul class="widget w-personal-info item-block">
                                                            <li>
                                                                <span class="title">
                                                                    <?= getPhrase('file');?>:
                                                                </span>
                                                                <span class="text">
                                                                    <a href="<?= base_url().PATH_TICKET_FILES;?><?= $row['ticket_file'];?>"
                                                                        class="grey" data-toggle="tooltip"
                                                                        data-placement="top" target="_blank"
                                                                        data-original-title="<?= getPhrase('view_file');?>">
                                                                        <i
                                                                            class="os-icon picons-thin-icon-thin-0075_document_file_paper_text_article_blog_template"></i>
                                                                        <?= getPhrase('view_file');?>
                                                                    </a>
                                                                </span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <? endif;?>
                                                    <?php if($row['link']):?>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <ul class="widget w-personal-info item-block">
                                                            <li>
                                                                <span class="title">
                                                                    <?= getPhrase('link');?>:
                                                                </span>
                                                                <span class="text">
                                                                    <a href="<?= $row['link'];?>" class="grey"
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        target="_blank"
                                                                        data-original-title="<?= getPhrase('view_link');?>">
                                                                        <i
                                                                            class="os-icon picons-thin-icon-thin-0260_link_url_chain_hyperlink"></i>
                                                                        <?= getPhrase('view_link');?>
                                                                    </a>
                                                                </span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <? endif;?>
                                                </div>

                                                <div>
                                                    <ul class="widget w-personal-info item-block">
                                                        <li>
                                                            <span class="title"><?= getPhrase('description');?>:</span>
                                                            <span class="text"><?= $description;?></span>
                                                        </li>
                                                    </ul>
                                                </div>

                                            </div>
                                        </div>

                                        <div class=" ui-block-title row" style="border-style: none;">
                                            <div class="col-sm-4">
                                                <div class="row" style="justify-content: flex-end;">
                                                    <?php if(!$allow_actions):?>
                                                    <div class="form-buttons">
                                                        <button class="btn btn-rounded btn-primary"
                                                            onclick="showAjaxModal('<?= base_url();?>modal/popup_helpdesk/modal_ticket_add_message/<?= $ticket_code;?>');">
                                                            <?= getPhrase('add_commentary');?></button>
                                                    </div> &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <?php endif;?>
                                                </div>
                                            </div>
                                        </div>
                                        <br />
                                        <div class="ui-block">
                                            <div class="ui-block-title">
                                                <h6 class="title"><?= getPhrase('commentaries');?>
                                                </h6>
                                            </div>
                                            <div class="ui-block-content">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead style="text-align: center;">
                                                            <tr style="background:#f2f4f8;">
                                                                <th style="width: 5%">
                                                                    <?= getPhrase('options');?>
                                                                </th>
                                                                <th style="width: 5%">
                                                                    <?= getPhrase('files');?>
                                                                </th>
                                                                <th style="width: 85%">
                                                                    <?= getPhrase('comment');?>
                                                                </th>
                                                                <th style="width: 5%">
                                                                    <?= getPhrase('info');?>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                foreach ($interactions as $item):
                                                                    $message = html_entity_decode(str_replace(array("\r", "\n"), '', $item['message']));
                                                            ?>
                                                            <tr>
                                                                <td class="row-actions" style="vertical-align: top;">
                                                                    <?php if($created_by == $item['created_by'] && !$allow_actions):?>
                                                                    <a href="javascript:void(0);" class="grey"
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        data-original-title="<?= getPhrase('edit');?>"
                                                                        onclick="showAjaxModal('<?= base_url();?>modal/popup_helpdesk/modal_ticket_update_message/<?=$item['ticket_message_id'];?>');">
                                                                        <i
                                                                            class="os-icon picons-thin-icon-thin-0001_compose_write_pencil_new"></i>
                                                                    </a>
                                                                    <?php endif;?>
                                                                </td>
                                                                <td class="row-actions">
                                                                    <?php if($item['file_name']):?>
                                                                    <a href="<?= base_url().PATH_TICKET_FILES;?><?= $item['file_name'];?>"
                                                                        class="grey" data-toggle="tooltip"
                                                                        data-placement="top" target="_blank"
                                                                        data-original-title="<?= getPhrase('view');?>">
                                                                        <i
                                                                            class="os-icon picons-thin-icon-thin-0043_eye_visibility_show_visible"></i>
                                                                    </a>
                                                                    <? endif;?>
                                                                </td>
                                                                <td>
                                                                    <?php 
                                                                    echo $message;
                                                                    ?>
                                                                </td>
                                                                <td style="vertical-align: top;">
                                                                    <center>
                                                                        <?= $item['created_at'];?>
                                                                    </center>
                                                                    <center>
                                                                        <?= $this->ticket->get_status_info($item['current_status'])['name'];?>
                                                                    </center>
                                                                    <center>
                                                                        <?= $this->crud->get_name($item['sender_type'], $item['sender_id']);?>
                                                                        <img src="<?= $this->crud->get_image_url($item['sender_type'], $item['sender_id']);?>"
                                                                            width="50px">
                                                                    </center>
                                                                </td>
                                                            </tr>
                                                            <?php endforeach;?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </main>
                        <?php endforeach;?>
                        <div class="col col-xl-3 order-xl-1 col-lg-12 order-lg-2 col-md-12 col-sm-12 col-12">
                            <div class="eduappgt-sticky-sidebar">
                                <div class="sidebar__inner">
                                    <div class="ui-block paddingtel">
                                        <div class="ui-block-content">
                                            <div class="help-support-block">
                                                <h3 class="title"><?= getPhrase('quick_links');?></h3>
                                                <ul class="help-support-list">
                                                    <li>
                                                        <i class="picons-thin-icon-thin-0133_arrow_right_next menu_left_selected_icon"
                                                            style="font-size:20px;"></i> &nbsp;&nbsp;&nbsp;
                                                        <a class="menu_left_selected_text"
                                                            href="<?= base_url();?>helpdesk/ticket_info/<?= $ticket_code;?>/">
                                                            <?= getPhrase('ticket_information');?>
                                                        </a>
                                                    </li>
                                                    <!-- <?php if(!$allow_actions):?>
                                                    <li>
                                                        <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                            style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                        <a
                                                            href="<?= base_url();?>ticket/update/<?= $ticket_code;?>/">
                                                            <?= getPhrase('update_ticket');?>
                                                        </a>
                                                    </li>
                                                    <?php endif;?> -->
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>