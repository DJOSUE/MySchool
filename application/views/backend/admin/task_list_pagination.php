<div class="content-w">
    <?php include 'fancy.php';?>
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
                        <?php
                        // echo '<pre>';
                        // var_dump($task_list);
                        // echo '</pre>';
                        ?>
                        <h5 class="form-header">
                            <?= getPhrase('task_list');?>
                        </h5>
                        <div class="row">
                            <div class="content-i">
                                <div class="content-box">
                                    <?= form_open(base_url() . 'admin/task_list/', array('class' => 'form m-b'));?>
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
                                                            <?php if($search['department_id'] == $department['department_id']) echo "selected";?>>
                                                            <?= $department['name']?>
                                                        </option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?= getPhrase('category');?></label>
                                                <div class="select">
                                                    <select name="category_id"
                                                        onchange="get_class_sections(this.value)">
                                                        <option value=""><?= getPhrase('select');?>
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
                                                                <?php if($search['category_id'] == $item['category_id']) echo "selected";?>>
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
                                                        $categories = $this->db->get('v_task_priorities')->result_array();
                                                        foreach($categories as $row):                        
                                                    ?>
                                                        <option value="<?= $row['priority_id'];?>"
                                                            <?php if($search['priority_id'] == $row['priority_id']) echo "selected";?>>
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
                                                        <option value=""><?= getPhrase('select');?>
                                                        </option>
                                                        <?php
                                                        $status = $this->db->get('v_task_status')->result_array();
                                                        foreach($status as $row):
                                                    ?>
                                                        <option value="<?= $row['status_id'];?>"
                                                            <?php if($search['status_id'] == $row['status_id']) echo "selected";?>>
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
                                                    value="<?= $search['due_date'];?>" />
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating"
                                                style="border: 1px solid #EAEAF5; border-radius: 5px; background: white;">
                                                <label class="control-label"><?= getPhrase('title');?></label>
                                                <input class="form-control" name="title" type="text"
                                                    value="<?= $search['text']?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="description-toggle">
                                                <div class="description-toggle-content">
                                                    <div class="h6"><?= getPhrase('assigned_to_me');?></div>
                                                </div>
                                                <div class="togglebutton">
                                                    <label><input name="assigned_me" value="1" type="checkbox"
                                                            <?php if($search['assigned_me'] == 1) echo "checked";?>></label>
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
                                <p><?php echo $links; ?></p>
                                <table class="table table-padded" id="dvData">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><?= getPhrase('title')?></th>
                                            <th class="text-center"><?= getPhrase('category')?></th>
                                            <th class="text-center"><?= getPhrase('user')?></th>
                                            <th class="text-center"><?= getPhrase('status')?></th>
                                            <th class="text-center"><?= getPhrase('priority')?></th>
                                            <th class="text-center"><?= getPhrase('due_date')?></th>
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
                                            foreach($task_list as $row) :
                                                $allow_actions      = $this->task->is_task_closed($row['status_id']);
                                                $assigned_to_type   = trim($row['assigned_to_type']);
                                        ?>
                                        <tr style="height:25px;">
                                            <td>
                                                <a href="<?= base_url();?>admin/task_info/<?= $row['task_code'];?>"
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
                                                    <?php $priority_info = $this->task->get_priority_info($row['priority_id']);?>
                                                    <div class="value badge badge-pill badge-primary"
                                                        style="background-color: <?= $priority_info['color']?>;">
                                                        <?= $priority_info['name'];?>
                                                    </div>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?= $row['due_date'];?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?= $assigned_to_type != '' ? $this->crud->get_name($assigned_to_type, $row['assigned_to']) : '';?>
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
                                                    <?= $row['updated_by_type'] != '' ? $this->crud->get_name($row['assigned_to_type'], $row['assigned_to']) : '';?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?= $row['updated_at'];?>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>