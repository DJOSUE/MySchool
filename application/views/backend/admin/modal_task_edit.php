<?php 
    $this->db->reset_query();
    $this->db->where('task_code' , $param2);
    $task_query = $this->db->get('task');
    $edit_data = $task_query->result_array();
        
    foreach ($edit_data as $row):
        $message =   str_replace(array("\r", "\n"), '', $row['description']);
?>
<div class="modal-body">
    <div class="modal-header" style="background-color:#00579c">
        <h6 class="title" style="color:white"><?php echo getPhrase('edit_task');?></h6>
    </div>
    <div class="ui-block-content">        
        <?php echo form_open(base_url() . 'admin/task/update/'.$row['task_id'].'/'.$param3 , array('enctype' => 'multipart/form-data'));?>
        <input type="hidden" name="task_id" value="<?= $row['task_id']?>">
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
                        <select name="priority_id" style="width: 150px;">
                            <?php
                        $priorities = $this->task->get_priorities();
                        foreach($priorities as $priority_row):
                        ?>
                            <option value="<?= $status_row['priority_id']?>"
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
if ($('#ckeditor2').length) {
    CKEDITOR.replace('ckeditor2', { toolbar: 'Basic' });

    var t = "<?=html_entity_decode($message);?>";

    CKEDITOR.instances.ckeditor2.setData(t.replace(/(\r\n|\n|\r)/gm, ""));
}
</script>