<?php 
    $this->db->reset_query();
    $this->db->where('task_code' , $param2);
    $task_query = $this->db->get('task');
    $edit_data = $task_query->result_array();
        
    foreach ($edit_data as $task):
        $message        =   str_replace(array("\r", "\n"), '', $task['description']);
        $category_id    = $task['category_id'];
        $category_info  = $this->task->get_category_info($category_id);

        $default_user   = explode('|',$category_info['default_user']);
        $df_user_table  = $default_user[0];
        
?>
<div class="modal-body">
    <div class="modal-header" style="background-color:#00579c">
        <h6 class="title" style="color:white"><?php echo getPhrase('edit_task');?></h6>
    </div>
    <div class="ui-block-content">
        <?php echo form_open(base_url() . 'assignment/task/update/'.$task['task_id'].'/'.$param3 , array('enctype' => 'multipart/form-data'));?>
        <input type="hidden" name="task_id" value="<?= $task['task_id']?>">        
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('status');?></label>
            <div class="col-sm-6">
                <div class="input-group">
                    <div class="select">
                        <select name="status_id" style="width: 150px;">
                            <?php
                        $status = $this->db->get('v_task_status')->result_array();
                        foreach($status as $status_row):
                        ?>
                            <option value="<?= $status_row['status_id']?>"
                                <?= $status_row['status_id'] == $task['status_id'] ? 'selected': ''; ?>>
                                <?= $status_row['name']?>
                            </option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('category');?></label>
            <div class="col-sm-6">
                <div class="input-group">
                    <div class="select">
                        <select name="category_id">
                            <option value=""><?php echo getPhrase('select');?>
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
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('assigned_to');?></label>
            <div class="col-sm-6">
                <div class="input-group">
                    <div class="select">
                        <select name="assigned_to" style="width: 150px;">
                            <option value=""><?= getPhrase('select');?></option>
                            <?php $users = $this->db->get_where($df_user_table, array('status' => 1))->result_array();
                            foreach($users as $user):
                                $id = $df_user_table.'_id';
                            ?>
                            <option value="<?= $df_user_table.'|'.$user[$id];?>"
                                <?= $user[$id] == $task['assigned_to'] ? 'selected': ''; ?>>
                                <?= $user['first_name']?>
                            </option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('priority');?></label>
            <div class="col-sm-6">
                <div class="input-group">
                    <div class="select">
                        <select name="priority_id" style="width: 150px;">
                            <?php
                        $priorities = $this->task->get_priorities();
                        foreach($priorities as $priority_row):
                        ?>
                            <option value="<?= $priority_row['priority_id']?>"
                                <?= $priority_row['priority_id'] == $task['priority_id'] ? 'selected': ''; ?>>
                                <?= $priority_row['name']?>
                            </option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('title');?></label>
            <div class="col-sm-9">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="picons-thin-icon-thin-0003_write_pencil_new_edit"></i>
                    </div>
                    <input class="form-control" name="title" value="<?php echo $task['title'];?>" required=""
                        type="text">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('description');?></label>
            <div class="col-sm-9">
                <div class="form-group">
                    <textarea id="ckeditor2" name="description" required=""></textarea>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('file');?></label>
            <div class="col-sm-9">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="picons-thin-icon-thin-0003_write_pencil_new_edit"></i>
                    </div>
                    <input class="form-control" name="task_file" type="file" accept="<?=FILES_ALLOWED_ATTACHMENT?>">
                </div>
            </div>
        </div>
        <div class="form-buttons-w">
            <button class="btn btn-rounded btn-success" style="float: right;" type="submit">
                <?php echo getPhrase('save');?></button><br>
        </div>
    </div>
</div>
<?php echo form_close();?>
<?php endforeach; ?>
<script>
if ($('#ckeditor2').length) {
    CKEDITOR.replace('ckeditor2', {
        toolbar: 'Basic'
    });

    var t = "<?=html_entity_decode($message);?>";

    CKEDITOR.instances.ckeditor2.setData(t.replace(/(\r\n|\n|\r)/gm, ""));
}
</script>