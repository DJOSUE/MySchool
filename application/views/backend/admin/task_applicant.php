<?php 
    $this->db->reset_query();
    $this->db->order_by('created_at', 'desc');

    $user_id        = get_login_user_id();
    $account_type   =   get_table_user(get_role_id()); 

    if($department_id != '')
    {
        $array = $this->task->get_categories_where($department_id);
        $this->db->where_in('category_id', $array);
    }
    if($category_id != '_blank')
    {
        $this->db->where('category_id', $category_id);
    }
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
        $this->db->like('title' , str_replace("%20", " ", $text));
    }
    if($assigned_me == 1)
    {
        $this->db->where('assigned_to_type', $account_type);
        $this->db->where('assigned_to' , $user_id);
    }
    if($due_date != '')
    {
        $this->db->where('due_date' , $due_date);
    }
    if($type_id != '_blank')
    {   
        $this->db->where('type_id', $type_id);
    }

    $this->db->where('user_type' , 'applicant');
    $task_query = $this->db->get('v_task_applicants');
    $tasks = $task_query->result_array();
?>
<style>
th {
    cursor: pointer;
}
</style>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <?php include 'task__nav.php'?>
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
                        <h5 class="form-header"><?= getPhrase('task_list');?></h5>
                        <div class="row">
                            <div class="content-i">
                                <div class="content-box">
                                    <?= form_open(base_url() . 'admin/task_applicant/', array('class' => 'form m-b'));?>
                                    <div class="row" style="margin-top: -30px; border-radius: 5px;">
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?= getPhrase('department');?></label>
                                                <div class="select">
                                                    <select name="department_id" style="width: 200px;"
                                                        onchange="get_categories(this.value);">
                                                        <option value=""><?= getPhrase('select');?></option>
                                                        <?php $departments = $this->task->get_departments();
                                                            foreach($departments as $department):
                                                        ?>
                                                        <option value="<?= $department['department_id']?>"
                                                            <?php if($department_id == $department['department_id']) echo "selected";?>>
                                                            <?= $department['name']?>
                                                        </option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?= getPhrase('department');?></label>
                                                <div class="select">
                                                    <select name="category_id"
                                                        onchange="get_class_sections(this.value)">
                                                        <option value="_blank"><?= getPhrase('select');?>
                                                        </option>

                                                        <?php
                                                        $departments = $this->task->get_departments();
                                                        foreach($departments as $row):                        
                                                        ?>
                                                        <optgroup label="<?= $row['name'];?>">
                                                            <?php
                                                        $categories = $this->task->get_categories($row['department_id']);
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
                                                        <option value="_blank"><?= getPhrase('select');?>
                                                        </option>
                                                        <?php
                                                        $categories = $this->db->get('v_task_priorities')->result_array();
                                                        foreach($categories as $row):                        
                                                    ?>
                                                        <option value="<?= $row['priority_id'];?>"
                                                            <?php if($priority_id == $row['priority_id']) echo "selected";?>>
                                                            <?= $row['name'];?></option>
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
                                                        <option value="_blank"><?= getPhrase('select');?>
                                                        </option>
                                                        <?php
                                                        $status = $this->db->get('v_task_status')->result_array();
                                                        foreach($status as $row):
                                                    ?>
                                                        <option value="<?= $row['status_id'];?>"
                                                            <?php if($status_id == $row['status_id']) echo "selected";?>>
                                                            <?= $row['name'];?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?= getPhrase('type_applicant');?></label>
                                                <div class="select">
                                                    <select name="type_id">
                                                        <option value="_blank"><?= getPhrase('select');?></option>
                                                        <?php
                                                        $applicant_type = $this->db->get('v_applicant_type')->result_array();
                                                        foreach($applicant_type as $row):
                                                    ?>
                                                        <option value="<?= $row['type_id'];?>"
                                                            <?php if($type_id == $row['type_id']) echo "selected";?>>
                                                            <?= $row['name'];?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating"
                                                style="border: 1px solid #EAEAF5; border-radius: 5px; background: white;">
                                                <label class="control-label"><?php echo getPhrase('due_date');?></label>
                                                <input type='text' class="datepicker-here" data-position="top left"
                                                    data-language='en' name="due_date" data-multiple-dates-separator="/"
                                                    value="<?= $due_date;?>" />
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating"
                                                style="border: 1px solid #EAEAF5; border-radius: 5px; background: white;">
                                                <label class="control-label"><?= getPhrase('text');?></label>
                                                <input class="form-control" name="title" type="text"
                                                    value="<?= $text?>">
                                            </div>
                                        </div>
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
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <button class="btn btn-success btn-upper" style="margin-top:20px"
                                                    type="submit"><span><?= getPhrase('search');?></span></button>
                                            </div>
                                        </div>
                                    </div>
                                    <?= form_close();?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="table-responsive">
                                <?php
                                    if($task_query->num_rows() > 0):
                                ?>
                                <a href="#" id="btnExport" data-toggle="tooltip" data-placement="top"
                                    data-original-title="<?= getPhrase('download');?>">
                                    <button class="btn btn-info btn-sm btn-rounded">
                                        <i class="picons-thin-icon-thin-0123_download_cloud_file_sync"
                                            style="font-weight: 300; font-size: 25px;"></i>
                                    </button>
                                </a>

                                <table class="table table-padded" id="dvData">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><?= getPhrase('title')?></th>
                                            <th class="text-center"><?= getPhrase('category')?></th>
                                            <th class="text-center"><?= getPhrase('user')?></th>
                                            <th class="text-center"><?= getPhrase('type')?></th>
                                            <th class="text-center"><?= getPhrase('status')?></th>
                                            <th class="text-center"><?= getPhrase('priority')?></th>
                                            <th class="text-center"><?= getPhrase('assigned_to')?></th>
                                            <th class="text-center"><?= getPhrase('due_date')?></th>
                                            <th class="text-center"><?= getPhrase('created_by')?></th>
                                            <th class="text-center"><?= getPhrase('created_at')?></th>
                                            <th class="text-center"><?= getPhrase('updated_by')?></th>
                                            <th class="text-center"><?= getPhrase('updated_at')?></th>
                                            <th class="text-center"><?= getPhrase('options')?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            foreach($tasks as $row) :
                                                $allow_actions = $this->task->is_task_closed($row['status_id']);
                                        ?>
                                        <tr style="height:25px;">
                                            <td>
                                                <a href="<?php echo base_url();?>admin/task_info/<?= $row['task_code'];?>"
                                                    class="grey">
                                                    <center>
                                                        <?= ($row['title']);?>
                                                    </center>
                                                </a>
                                            </td>
                                            <td>
                                                <center>
                                                    <?= $this->task->get_category($row['category_id']);?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?= $row['first_name'] .' '. $row['last_name'];?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?= $this->applicant->get_type_name($row['type_id']);?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?= $this->task->get_status($row['status_id']);?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?php $priority_info = $this->task->get_priority_info($row['priority_id']);?>
                                                    <div class="value badge badge-pill badge-primary"
                                                        style="background-color: <?= $priority_info['color']?>;">
                                                        <?= $priority_info['name'];?>
                                                    </div>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?= $row['assigned_to_type'] != '' ? $this->crud->get_name($row['assigned_to_type'], $row['assigned_to']) : '';?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?= $row['due_date'];?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?= $row['created_by_type'] != '' ? $this->crud->get_name($row['created_by_type'], $row['created_by']) : '';?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?= ($row['created_at']);?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?= $this->crud->get_name('admin', $row['updated_by']);?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?= ($row['updated_at']);?>
                                                </center>
                                            </td>
                                            <td class="row-actions">
                                                <a href="<?= base_url();?>admin/task_info/<?= $row['task_code'];?>"
                                                    class="grey" data-toggle="tooltip" data-placement="top"
                                                    data-original-title="<?= getPhrase('view');?>">
                                                    <i
                                                        class="os-icon picons-thin-icon-thin-0043_eye_visibility_show_visible"></i>
                                                </a>
                                                <?php if(!$allow_actions):?>
                                                <a href="javascript:void(0);" class="grey" data-toggle="tooltip"
                                                    data-placement="top"
                                                    data-original-title="<?= getPhrase('add_interaction');?>"
                                                    onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_task_add_message/<?= $row['task_code'].'/task_applicant/';?>');">
                                                    <i class="os-icon picons-thin-icon-thin-0151_plus_add_new"></i>
                                                </a>
                                                <a href="javascript:void(0);" class="grey" data-toggle="tooltip"
                                                    data-placement="top" data-original-title="<?= getPhrase('edit');?>"
                                                    onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_task_edit/<?=$row['task_code'].'/task_applicant/';?>');">
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
$("#btnExport").click(function(e) {
    var reportName = '<?= getPhrase('task_applicant').'_'.date('d-m-Y');?>';
    var a = document.createElement('a');
    var data_type = 'data:application/vnd.ms-excel;charset=utf-8';
    var table_html = $('#dvData')[0].outerHTML;
    table_html = table_html.replace(/<tfoot[\s\S.]*tfoot>/gmi, '');
    var css_html =
        '<style>td {border: 0.5pt solid #c0c0c0} .tRight { text-align:right} .tLeft { text-align:left} </style>';
    a.href = data_type + ',' + encodeURIComponent('<html><head>' + css_html + '</' + 'head><body>' +
        table_html + '</body></html>');
    a.download = reportName + '.xls';
    a.click();
    e.preventDefault();
});
</script>
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