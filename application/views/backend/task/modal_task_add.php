<?php 
    $user_id = $param3.'_id';
    $table   = $param3;

    $this->db->reset_query();
    $this->db->where($user_id, $param2);
    $task_query = $this->db->get($param3);
    $edit_data = $task_query->result_array();

    foreach ($edit_data as $row):
        $message =   str_replace(array("\r", "\n"), '', $row['description']);
?>
<div class="modal-body">
    <div class="modal-header" style="background-color:#00579c">
        <h6 class="title" style="color:white"><?php echo getPhrase('edit_task');?></h6>
    </div>
    <div class="ui-block-content">
        <span style="display:inline;">
            <h4><?= getPhrase($table);?>: </h4>
            <h6><?= $row['first_name'] . ' ' . $row['last_name']; ?></h6>
        </span>
        <?php echo form_open(base_url() . 'assignment/task/register/-/' , array('enctype' => 'multipart/form-data'));?>
        <input type="hidden" name="user_id" value="<?= $row[$user_id]?>">
        <input type="hidden" name="user_type" value="<?= $table?>">
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('department');?></label>
            <div class="col-sm-6">
                <div class="input-group">
                    <div class="select">
                        <select name="department_id" style="width: 200px;"
                            onchange="get_categories(this.value);"
                        >
                            <option value=""><?php echo getPhrase('select');?></option>
                            <?php $departments = $this->task->get_departments();
                                foreach($departments as $department):
                            ?>
                            <option value="<?= $department['department_id']?>">
                                <?= $department['name']?>
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
                        <select id="category_holder" name="category_id" style="width: 300px;">
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('status');?></label>
            <div class="col-sm-6">
                <div class="input-group">
                    <div class="select">
                        <select name="status_id" style="width: 200px;">
                            <?php
                        $status = $this->db->get('v_task_status')->result_array();
                        foreach($status as $status_row):
                        ?>
                            <option value="<?= $status_row['status_id']?>"
                                <?= $status_row['status_id'] == $row['status_id'] ? 'selected': ''; ?>>
                                <?= $status_row['name']?>
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
                        <select name="priority_id" style="width: 200px;">
                            <?php
                        $priorities = $this->task->get_priorities();
                        foreach($priorities as $priority_row):
                        ?>
                            <option value="<?= $priority_row['priority_id']?>"
                                <?= $priority_row['priority_id'] == $row['priority_id'] ? 'selected': ''; ?>>
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
                    <input class="form-control" name="title" value="<?php echo $row['title'];?>" required=""
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
                    <input class="form-control" name="task_file" type="file"
                        accept="<?=FILES_ALLOWED_ATTACHMENT?>">
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

    if ($('#ckeditor2').length) 
    {
        CKEDITOR.replace('ckeditor2', { toolbar: 'Basic' });

        var t = "<?=html_entity_decode($message);?>";

        CKEDITOR.instances.ckeditor2.setData(t.replace(/(\r\n|\n|\r)/gm, ""));
    }

    function get_categories(department_id) 
    {        
        $.ajax({
            url: '<?php echo base_url();?>admin/get_category_dropdown/' + department_id + '/',
            success: function(response) {
                jQuery('#category_holder').html(response);
            }
        });
    }

</script>

