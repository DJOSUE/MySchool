<?php 
    $this->db->reset_query();
    $this->db->where('task_code' , $task_code);
    $task_query = $this->db->get('task');
    $tasks = $task_query->result_array();   

?>
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script> -->

<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <?php include 'task__nav.php';?>
            </div>
        </div><br>
        <div class="row">
            <div class="content-i">
                <div class="content-box">
                    <div class="row">
                        <?php 
                        foreach ($tasks as $row):
                            $user_info      = $this->crud->get_user_info($row['user_type'], $row['user_id']);
                            $status_info    = $this->task->get_status_info($row['status_id']);
                            $priority_info  = $this->task->get_priority_info($row['priority_id']);
                            $description    =   html_entity_decode(str_replace(array("\r", "\n"), '', $row['description']));
                            $allow_actions  = $this->task->is_task_closed($row['status_id']);

                            
                            // echo '<pre>';
                            // var_dump($row['user_type']);
                            // echo '</pre>';
                        ?>
                        <main class="col col-xl-9 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
                            <div id="newsfeed-items-grid">
                                <div class="ui-block paddingtel">
                                    <div class="user-profile">
                                        <div class="up-head-w"
                                            style="background-image:url(<?= base_url();?>public/uploads/bglogin.jpg)">
                                            <div class="up-main-info">
                                                <div class="user-avatar-w">
                                                    <div class="user-avatar">
                                                        <img alt=""
                                                            src="<?= $this->crud->get_image_url($row['user_type'], $row['user_id']);?>"
                                                            style="background-color:#fff;">
                                                    </div>
                                                </div>
                                                <h3 class="text-white"><?= $user_info['first_name'];?>
                                                    <?= $user_info['last_name'];?></h3>
                                            </div>
                                            <svg class="decor" width="842px" height="219px" viewBox="0 0 842 219"
                                                preserveAspectRatio="xMaxYMax meet" version="1.1"
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <g transform="translate(-381.000000, -362.000000)" fill="#FFFFFF">
                                                    <path class="decor-path"
                                                        d="M1223,362 L1223,581 L381,581 C868.912802,575.666667 1149.57947,502.666667 1223,362 Z">
                                                    </path>
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="up-controls">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    
                                                    <div class="value-pair">
                                                        <div><?= getPhrase('type_user');?>:</div>
                                                        <div class="value badge-status badge-pill badge-primary">
                                                            <?= $row['user_type'];?>
                                                        </div>
                                                        <?php if($row['user_type'] == 'applicant') :
                                                            $applicant = $this->db->get_where('applicant', array('applicant_id' => $row['user_id']))->row_array();
                                                            $status_applicant =  $this->applicant->get_type_info($applicant['type_id']);
                                                        ?>
                                                        <br>
                                                        <div class="value badge-status badge-pill badge-primary"
                                                            style="background-color: <?= $status_applicant['color']?>;">
                                                            <?=$status_applicant['name']; ?>
                                                        </div>
                                                        <?endif;?>
                                                    </div>

                                                    <div class="value-pair">
                                                        <div><?= getPhrase('user_status');?>:</div>
                                                        <?php 
                                                            $user_status_info = $this->task->get_user_status($row['user_type'], $row['user_id']);
                                                        ?>
                                                        <div class="value badge-status badge-pill badge-primary"
                                                            style="background-color: <?= $user_status_info['color']?>;">
                                                            <?= $user_status_info['name'];?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ui-block">
                                            <div class="ui-block-title">
                                                <h6 class="title"><?= getPhrase('personal_information');?>
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
                                                            <li>
                                                                <span class="title"><?= getPhrase('address');?>:</span>
                                                                <span class="text"><?= $user_info['address'];?></span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <ul class="widget w-personal-info item-block">
                                                            <li>
                                                                <span class="title"><?= getPhrase('phone');?>:</span>
                                                                <span class="text"><?= $user_info['phone'];?></span>
                                                            </li>
                                                            <li>
                                                                <span class="title"><?= getPhrase('birthday');?>:</span>
                                                                <span class="text"><?= $user_info['birthday'];?></span>
                                                            </li>
                                                            <li>
                                                                <span class="title"><?= getPhrase('gender');?>:</span>
                                                                <span
                                                                    class="text"><?= $this->crud->get_gender_user($user_info['gender']);?></span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ui-block">
                                            <div class="ui-block-title">
                                                <h6 class="title"><?= getPhrase('task_information');?>
                                                </h6>
                                                <div class="value-pair">
                                                        <div><?= getPhrase('priority');?>:</div>
                                                        <div class="value badge-status badge-pill badge-primary"
                                                            style="background-color: <?= $priority_info['color']?>;">
                                                            <?= $priority_info['name'];?>
                                                        </div>
                                                    </div>
                                                    <div class="value-pair">
                                                        <div><?= getPhrase('status_task');?>:</div>
                                                        <div class="value badge-status badge-pill badge-primary"
                                                            style="background-color: <?= $status_info['color']?>;">
                                                            <?= $status_info['name'];?>
                                                        </div>
                                                    </div>
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
                                                                <span class="text">
                                                                    <?= $row['assigned_to_type'] != "" ? $this->crud->get_name($row['assigned_to_type'],$row['assigned_to']) : '';?>
                                                                </span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <ul class="widget w-personal-info item-block">
                                                            <li>
                                                                <span class="title">
                                                                    <?= getPhrase('department');?>:
                                                                </span>
                                                                <span class="text">
                                                                    <?= $this->task->get_department_by_category($row['category_id']);?>
                                                                </span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <ul class="widget w-personal-info item-block">
                                                            <li>
                                                                <span class="title">
                                                                    <?= getPhrase('category');?>:
                                                                </span>
                                                                <span class="text">
                                                                    <?= $this->task->get_category($row['category_id']);?>
                                                                </span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <ul class="widget w-personal-info item-block">
                                                            <li>
                                                                <span class="title">
                                                                    <?= getPhrase('due_date');?>:
                                                                </span>
                                                                <span class="text">
                                                                    <?= $row['due_date'];?>
                                                                </span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <ul class="widget w-personal-info item-block">
                                                        <li>
                                                            <span class="title"><?= getPhrase('description');?>:</span>
                                                            <span class="text"><?= $description;?></span>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <?php if($row['task_file']):?>
                                                <div class="row">
                                                    <div class="col">
                                                        <ul class="widget w-personal-info item-block">
                                                            <li>
                                                                <span class="title">
                                                                    <?= getPhrase('file');?>:
                                                                </span>
                                                                <span class="text">
                                                                    <a href="<?= base_url().PATH_TASK_FILES;?><?= $row['task_file'];?>"
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
                                                </div>
                                                <? endif;?>
                                            </div>
                                        </div>
                                        <div class=" ui-block-title row" style="border-style: none;">
                                            <div class="col-sm-4">
                                                <div class="row" style="justify-content: flex-end;">
                                                    <?php if(!$allow_actions):?>
                                                    <div class="form-buttons">
                                                        <button class="btn btn-rounded btn-primary"
                                                            onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_task_add_message/<?= $task_code;?>');">
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
                                                <div class="edu-posts cta-with-media">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered" id="table_id">
                                                            <thead style="text-align: center;">
                                                                <tr style="background:#f2f4f8;">
                                                                    <th>
                                                                        <?= getPhrase('comment');?>
                                                                    </th>
                                                                    <th>
                                                                        <?= getPhrase('status');?>
                                                                    </th>
                                                                    <th>
                                                                        <?= getPhrase('created_by');?>
                                                                    </th>
                                                                    <th>
                                                                        <?= getPhrase('created_at');?>
                                                                    </th>
                                                                    <th>
                                                                        <?= getPhrase('file');?>
                                                                    </th>
                                                                    <th>
                                                                        <?= getPhrase('options');?>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php 
                                                                $this->db->order_by('task_message_id', 'desc');
                                                                $this->db->where('task_code', $task_code);
                                                                $interactions = $this->db->get('task_message')->result_array();
                                                                // echo '<pre>';
                                                                // var_dump($interactions);
                                                                // echo '</pre>';

                                                                foreach ($interactions as $item):
                                                            ?>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <center>
                                                                            <?php 
                                                                                $message = strip_tags(html_entity_decode($item['message']));
                                                                                if (strlen($message) > 100)
                                                                                    $message = substr($message, 0, 97) . '...';
                                                                                
                                                                                echo $message;
                                                                            ?>
                                                                        </center>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <center>
                                                                            <?= $this->task->get_status_info($item['current_status'])['name'];?>
                                                                        </center>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <center>
                                                                            <?= $this->crud->get_name($item['sender_type'], $item['sender_id']);?>
                                                                        </center>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <center>
                                                                            <?= $item['created_at'];?>
                                                                        </center>
                                                                    </td>
                                                                    <td class="row-actions">
                                                                        <?php if($item['message_file']):?>
                                                                        <a href="<?= base_url().PATH_TASK_FILES;?><?= $item['message_file'];?>"
                                                                            class="grey" data-toggle="tooltip"
                                                                            data-placement="top" target="_blank"
                                                                            data-original-title="<?= getPhrase('view');?>">
                                                                            <i
                                                                                class="os-icon picons-thin-icon-thin-0043_eye_visibility_show_visible"></i>
                                                                        </a>
                                                                        <? endif;?>
                                                                    </td>
                                                                    <td class="row-actions">
                                                                        <a href="javascript:void(0);" class="grey"
                                                                            data-toggle="tooltip" data-placement="top"
                                                                            data-original-title="<?= getPhrase('view');?>"
                                                                            onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_task_view_message/<?=$item['task_message_id'];?>');">
                                                                            <i
                                                                                class="os-icon picons-thin-icon-thin-0043_eye_visibility_show_visible"></i>
                                                                        </a>
                                                                        <?php if($user_id == $item['created_by'] && !$allow_actions):?>
                                                                        <a href="javascript:void(0);" class="grey"
                                                                            data-toggle="tooltip" data-placement="top"
                                                                            data-original-title="<?= getPhrase('edit');?>"
                                                                            onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_task_update_message/<?=$item['task_message_id'];?>');">
                                                                            <i
                                                                                class="os-icon picons-thin-icon-thin-0001_compose_write_pencil_new"></i>
                                                                        </a>
                                                                        <?php endif;?>
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
                            </div>
                        </main>
                        <?php endforeach;?>
                        <div class="col col-xl-3 order-xl-1 col-lg-12 order-lg-2 col-md-12 col-sm-12 col-12">
                            <?php include 'task__menu.php'?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script type="text/javascript">
$(document).ready(function() {
    $('#table_id').DataTable();
});
</script> -->
<script type="text/javascript">
$('th').click(function() {
    var table = $(this).parents('table').eq(0)
    var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()))
    this.asc = !this.asc
    if (!this.asc) {
        rows = rows.reverse()
    }
    for (var i = 0; i < rows.length; i++) {
        table.append(rows[i])
    }
})

function comparer(index) {
    return function(a, b) {
        var valA = getCellValue(a, index),
            valB = getCellValue(b, index)
        return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.toString().localeCompare(valB)
    }
}

function getCellValue(row, index) {
    return $(row).children('td').eq(index).text()
}
</script>