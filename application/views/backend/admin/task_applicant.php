<?php 
    $this->db->reset_query();

    $user_id = $this->session->userdata('login_user_id');

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
                        <a class="navs-links" href="<?php echo base_url();?>admin/task_dashboard/">
                            <i
                                class="os-icon picons-thin-icon-thin-0482_gauge_dashboard_empty"></i><span><?php echo getPhrase('dashboard');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links active" href="<?php echo base_url();?>admin/task_applicant/">
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
                        <?php
                        // echo '<pre>';
                        // var_dump($status_id);
                        // var_dump($priority_id);
                        // var_dump($department_id);
                        // echo '</pre>';
                        ?>
                        <h5 class="form-header"><?php echo getPhrase('task_list');?></h5>
                        <div class="row">
                            <div class="content-i">
                                <div class="content-box">
                                    <?php echo form_open(base_url() . 'admin/task_applicant/', array('class' => 'form m-b'));?>
                                    <div class="row" style="margin-top: -30px; border-radius: 5px;">
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating is-select">
                                                <label
                                                    class="control-label"><?php echo getPhrase('department');?></label>
                                                <div class="select">
                                                    <select name="category_id"
                                                        onchange="get_class_sections(this.value)">
                                                        <option value="_blank"><?php echo getPhrase('select');?>
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
                                                            <option value="<?php echo $item['category_id'];?>"
                                                                <?php if($category_id == $item['category_id']) echo "selected";?>>
                                                                <?php echo $item['name'];?></option>

                                                            <?php endforeach;?>
                                                            <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?php echo getPhrase('priority');?></label>
                                                <div class="select">
                                                    <select name="priority_id"
                                                        onchange="get_class_sections(this.value)">
                                                        <option value="_blank"><?php echo getPhrase('select');?>
                                                        </option>
                                                        <?php
                                                        $categories = $this->db->get('v_task_priorities')->result_array();
                                                        foreach($categories as $row):                        
                                                    ?>
                                                        <option value="<?php echo $row['priority_id'];?>"
                                                            <?php if($priority_id == $row['priority_id']) echo "selected";?>>
                                                            <?php echo $row['name'];?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?php echo getPhrase('status');?></label>
                                                <div class="select">
                                                    <select name="status_id">
                                                        <option value="_blank"><?php echo getPhrase('select');?>
                                                        </option>
                                                        <?php
                                                        $status = $this->db->get('v_task_status')->result_array();
                                                        foreach($status as $row):
                                                    ?>
                                                        <option value="<?php echo $row['status_id'];?>"
                                                            <?php if($status_id == $row['status_id']) echo "selected";?>>
                                                            <?php echo $row['name'];?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating"
                                                style="border: 1px solid #EAEAF5; border-radius: 5px; background: white;">
                                                <label class="control-label"><?php echo getPhrase('text');?></label>
                                                <input class="form-control" name="name" type="text" value="<?= $text?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="description-toggle">
                                                <div class="description-toggle-content">
                                                    <div class="h6"><?php echo getPhrase('assigned_to_me');?></div>
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
                                                    type="submit"><span><?php echo getPhrase('search');?></span></button>
                                            </div>
                                        </div>
                                    </div>
                                    <?php echo form_close();?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="table-responsive">
                                <?php 
                                    if($status_id != "_blank" || $priority_id != "_blank" || $department_id != "_blank"):
                                        if($task_query->num_rows() > 0):
                                ?>
                                <a href="#" id="btnExport" data-toggle="tooltip" data-placement="top"
                                    data-original-title="<?php echo getPhrase('download');?>">
                                    <button class="btn btn-info btn-sm btn-rounded">
                                        <i class="picons-thin-icon-thin-0123_download_cloud_file_sync"
                                            style="font-weight: 300; font-size: 25px;"></i>
                                    </button>
                                </a>

                                <table class="table table-padded" id="dvData">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><?php echo getPhrase('title')?></th>
                                            <th class="text-center"><?php echo getPhrase('category')?></th>
                                            <th class="text-center"><?php echo getPhrase('user')?></th>
                                            <th class="text-center"><?php echo getPhrase('status')?></th>
                                            <th class="text-center"><?php echo getPhrase('priority')?></th>
                                            <th class="text-center"><?php echo getPhrase('assigned_to')?></th>
                                            <th class="text-center"><?php echo getPhrase('created_by')?></th>
                                            <th class="text-center"><?php echo getPhrase('created_at')?></th>
                                            <th class="text-center"><?php echo getPhrase('updated_by')?></th>
                                            <th class="text-center"><?php echo getPhrase('options')?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            foreach($tasks as $row) :
                                                $allow_actions = $this->task->is_task_closed($row['status_id']);
                                        ?>
                                        <tr style="height:25px;">
                                            <td>
                                                <center>
                                                    <?= ($row['title']);?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?= $this->task->get_category($row['category_id']);?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?= $this->crud->get_name($row['user_type'], $row['user_id']);?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?= $this->task->get_status($row['status_id']);?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?= $this->task->get_priority($row['priority_id']);?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?= $this->crud->get_name('admin', $row['assigned_to']);?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?= $this->crud->get_name('admin', $row['created_by']);?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?php echo ($row['created_at']);?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?= $this->crud->get_name('admin', $row['updated_by']);?>
                                                </center>
                                            </td>
                                            <td class="row-actions">
                                                <a href="<?php echo base_url();?>admin/task_info/<?= $row['task_code'];?>"
                                                    class="grey" data-toggle="tooltip" data-placement="top"
                                                    data-original-title="<?php echo getPhrase('view');?>">
                                                    <i
                                                        class="os-icon picons-thin-icon-thin-0043_eye_visibility_show_visible"></i>
                                                </a>
                                                <?php if(!$allow_actions):?>
                                                <a href="javascript:void(0);" class="grey" data-toggle="tooltip"
                                                    data-placement="top"
                                                    data-original-title="<?php echo getPhrase('add_interaction');?>"
                                                    onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_task_add_message/<?= $row['task_code'].'/task_applicant/';?>');">
                                                    <i class="os-icon picons-thin-icon-thin-0151_plus_add_new"></i>
                                                </a>
                                                <a href="javascript:void(0);" class="grey" data-toggle="tooltip"
                                                    data-placement="top"
                                                    data-original-title="<?php echo getPhrase('edit');?>"
                                                    onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_task_edit/<?=$row['task_code'].'/task_applicant/';?>');">
                                                    <i
                                                        class="os-icon picons-thin-icon-thin-0001_compose_write_pencil_new"></i>
                                                </a>
                                                <? endif;?>
                                            </td>
                                        </tr>
                                        <?php endforeach; endif;?>
                                    </tbody>
                                </table>
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
    var reportName = '<?php echo getPhrase('task_applicant').'_'.date('d-m-Y');?>';
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