<?php 

    $account_type       =   get_account_type(); 
    $fancy_path         =   $_SERVER['DOCUMENT_ROOT'].'/application/views/backend/'.$account_type.'/';

    // validate if has access as admin/helpdesk user
    $is_helpdesk_admin  = has_permission('helpdesk_admin_module');
    $is_helpdesk_team   = has_permission('helpdesk_team');
    $user_id            = get_login_user_id();
    $is_helpdesk_admin = has_permission('helpdesk_admin_module');
    $is_helpdesk_team  = has_permission('helpdesk_team');

    $this->db->reset_query();

    $user_id = get_login_user_id();

    if($category_id != '')
    {
        $this->db->where('category_id', $category_id);
    }
    if($priority_id != '')
    {
        $this->db->where('priority_id', $priority_id);
    }
    if($status_id != '')
    {   
        $this->db->where('status_id', $status_id);
    }
    if($text != '')
    {
        $this->db->like('description' , str_replace("%20", " ", $text));
    }

    if($is_helpdesk_team || $is_helpdesk_admin)
    {
        if($assigned_me == 1)
        {
            $this->db->where('assigned_to' , $user_id);
        }    
    }
    else
    {
        $this->db->where('created_by_type' , $account_type);
        $this->db->where('created_by' , $user_id);
    }

    $ticket_query = $this->db->get('ticket');
    $tickets = $ticket_query->result_array();
?>
<?php include $view_path.'_data_table_dependency.php';?>
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
                        <?php
                        // echo '<pre>';
                        // var_dump($status_id);
                        // var_dump($priority_id);
                        // var_dump($department_id);
                        // echo '</pre>';
                        ?>
                        <h5 class="form-header"><?= getPhrase('ticket_list');?></h5>
                        <div class="row">
                            <div class="content-i">
                                <div class="content-box">
                                    <?= form_open(base_url() . 'helpdesk/ticket_list/', array('class' => 'form m-b'));?>
                                    <div class="row" style="margin-top: -30px; border-radius: 5px;">
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating is-select">
                                                <label
                                                    class="control-label"><?= getPhrase('department');?></label>
                                                <div class="select">
                                                    <select name="category_id"
                                                        onchange="get_class_sections(this.value)">
                                                        <option value=""><?= getPhrase('select');?>
                                                        </option>

                                                        <?php
                                                        $departments = $this->ticket->get_departments();
                                                        foreach($departments as $row):                        
                                                        ?>
                                                        <optgroup label="<?= $row['name'];?>">
                                                            <?php
                                                        $categories = $this->ticket->get_categories($row['department_id']);
                                                        foreach($categories as $item):  
                                                        ?>
                                                            <option value="<?= $item['category_id'];?>"
                                                                <?php if($category_id == $item['category_id']) echo "selected";?>>
                                                                <?= $item['name'];?></option>

                                                            <?php endforeach;?>
                                                            <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?= getPhrase('priority');?></label>
                                                <div class="select">
                                                    <select name="priority_id"
                                                        onchange="get_class_sections(this.value)">
                                                        <option value=""><?= getPhrase('select');?>
                                                        </option>
                                                        <?php
                                                        $priorities = $this->ticket->get_priorities();
                                                        foreach($priorities as $priority):                        
                                                    ?>
                                                        <option value="<?= $priority['priority_id'];?>"
                                                            <?php if($priority_id == $priority['priority_id']) echo "selected";?>>
                                                            <?= $priority['name'];?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?= getPhrase('status');?></label>
                                                <div class="select">
                                                    <select name="status_id">
                                                        <option value=""><?= getPhrase('select');?>
                                                        </option>
                                                        <?php
                                                        $statuses = $this->ticket->get_statuses();
                                                        foreach($statuses as $status):
                                                    ?>
                                                        <option value="<?= $status['status_id'];?>"
                                                            <?php if($status_id == $status['status_id']) echo "selected";?>>
                                                            <?= $status['name'];?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating"
                                                style="border: 1px solid #EAEAF5; border-radius: 5px; background: white;">
                                                <label class="control-label"><?= getPhrase('text');?></label>
                                                <input class="form-control" name="text" type="text" value="<?= $text?>">
                                            </div>
                                        </div>
                                        <?php if($is_helpdesk_team):?>
                                        <div class="col-sm-2">
                                            <div class="description-toggle">
                                                <div class="description-toggle-content">
                                                    <div class="h6"><?= getPhrase('assigned_to_me');?></div>
                                                </div>
                                                <div class="togglebutton">
                                                    <label><input name="assigned_me" value="1" type="checkbox"
                                                            <?php if($assigned_me == 1) echo "checked";?>></label>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <button class="btn btn-success btn-upper" style="margin-top:20px"
                                                    type="submit">
                                                    <span><?= getPhrase('search');?></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <?= form_close();?>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-upper" style="margin-top:20px"
                                                onclick="showAjaxModal('<?= base_url();?>modal/popup_helpdesk/modal_ticket_add/');">
                                                <span>+<?= getPhrase('new');?></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="table-responsive"  style="width: 100%;">
                                <?php
                                    if($ticket_query->num_rows() > 0):
                                ?>
                                <table class="table table-padded" id="dvData" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><?= getPhrase('title')?></th>
                                            <th class="text-center"><?= getPhrase('category')?></th>

                                            <th class="text-center"><?= getPhrase('status')?></th>
                                            <th class="text-center"><?= getPhrase('priority')?></th>
                                            <th class="text-center"><?= getPhrase('assigned_to')?></th>
                                            <th class="text-center"><?= getPhrase('created_by')?></th>
                                            <th class="text-center"><?= getPhrase('created_at')?></th>
                                            <th class="text-center"><?= getPhrase('updated_by')?></th>
                                            <th class="text-center"><?= getPhrase('updated_at')?></th>
                                            <th class="text-center"><?= getPhrase('options')?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            foreach($tickets as $row) :
                                                $allow_actions = $this->ticket->is_ticket_closed($row['status_id']);
                                                $view_url = base_url().'helpdesk/ticket_info/'.$row['ticket_code'];
                                        ?>
                                        <tr style="height:25px;">
                                            <td>
                                                <a href="<?= $view_url;?>" class="grey">
                                                    <center>
                                                        <?= ($row['title']);?>
                                                    </center>
                                                </a>
                                            </td>
                                            <td>
                                                <center>
                                                    <?= $this->ticket->get_category_name($row['category_id']);?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?= $this->ticket->get_status_name($row['status_id']);?>
                                                </center>
                                            </td>
                                            <td>
                                            <center>
                                                    <?php $priority_info = $this->ticket->get_priority_info($row['priority_id']);?>
                                                    <div class="value badge badge-pill badge-primary"
                                                        style="background-color: <?= $priority_info['color']?>;">
                                                        <?= $priority_info['name'];?>
                                                    </div>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?= $this->crud->get_name('admin', $row['assigned_to']);?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?= $this->crud->get_name($row['created_by_type'], $row['created_by']);?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?= ($row['created_at']);?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?= $row['updated_by'] != '' ? $this->crud->get_name($row['updated_by_type'], $row['updated_by']) : '';?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?= $row['updated_at'];?>
                                                </center>
                                            </td>
                                            <td class="row-actions">
                                                <a href="<?=$view_url?>"
                                                    class="grey" data-toggle="tooltip" data-placement="top"
                                                    data-original-title="<?= getPhrase('view');?>">
                                                    <i
                                                        class="os-icon picons-thin-icon-thin-0043_eye_visibility_show_visible"></i>
                                                </a>
                                                <?php if(!$allow_actions):?>
                                                <a href="javascript:void(0);" class="grey" data-toggle="tooltip"
                                                    data-placement="top"
                                                    data-original-title="<?= getPhrase('add_interaction');?>"
                                                    onclick="showAjaxModal('<?= base_url();?>modal/popup_helpdesk/modal_ticket_add_message/<?= $row['ticket_code'].'/ticket_applicant/';?>');">
                                                    <i class="os-icon picons-thin-icon-thin-0151_plus_add_new"></i>
                                                </a>
                                                <a href="javascript:void(0);" class="grey" data-toggle="tooltip"
                                                    data-placement="top"
                                                    data-original-title="<?= getPhrase('edit');?>"
                                                    onclick="showAjaxModal('<?= base_url();?>modal/popup_helpdesk/modal_ticket_edit/<?=$row['ticket_code'].'/ticket_applicant/';?>');">
                                                    <i
                                                        class="os-icon picons-thin-icon-thin-0001_compose_write_pencil_new"></i>
                                                </a>
                                                <? endif;?>
                                            </td>
                                        </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                                <?php else:?>
                                <div class="bg-danger" style="border-radius: 10px">
                                    <div class="container">
                                        <div class="col-sm-12"><br><br>
                                            <h3 class="text-white"> <?= getPhrase('no_results_found');?></h3><br><br>
                                        </div>
                                    </div>
                                </div>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var table = $('#dvData').DataTable({
        dom: 'Blifrtp',
        scrollX: true,
        lengthMenu: [
            [10, 20, 50, -1],
            [10, 20, 50, "All"]
        ],
        pageLength: 20,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="picons-thin-icon-thin-0123_download_cloud_file_sync" style="font-size: 20px;"></i>',
            titleAttr: 'Export to Excel'
        }]
    });
    $("select[name='dvData_length']" ).addClass('select-page');
</script>