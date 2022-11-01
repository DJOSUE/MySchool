<?php 
    $this->db->reset_query();
    $this->db->where('task_code' , $param2);
    $task_query = $this->db->get('task');
    $tasks = $task_query->result_array();

    $return_url = '';
    if($param3 != '')
    {
        $return_url = '-/'.$param3;
    }
    
    // echo '<pre>';
    // var_dump($tasks);
    // echo '</pre>';
    
    foreach ($tasks as $row):
?>
<div class="modal-body">
    <div class="modal-header" style="background-color:#00579c">
        <h6 class="title" style="color:white"><?php echo getPhrase('add_message');?></h6>
    </div>
    <div class="ui-block-content">
        <span style="display:inline;">
            <h4><?= getPhrase('user');?>: </h4>
            <h6><?= $this->crud->get_name($row['user_type'], $row['user_id']);?></h6>
        </span>
        <?php echo form_open(base_url() . 'assignment/task_message/add/'.$param2.'/'.$return_url , array('enctype' => 'multipart/form-data'));?>
        <input type="hidden" name="task_code" value="<?= $param2?>">
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('status');?></label>
            <div class="col-sm-6">
                <div class="input-group">
                    <div class="select">
                        <select name="status_id" required="" style="width: 150px;">
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
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('comment');?></label>
            <div class="col-sm-9">
                <div class="form-group">
                    <textarea id="ckeditor2" name="message" required=""></textarea>
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
                    <input class="form-control" name="message_file" type="file"
                        accept="image/jpeg,image/png,application/pdf">
                </div>
            </div>
        </div>
        <div class="form-buttons-w">
            <button class="btn btn-rounded btn-success" style="float: right;" type="submit">
                <?php echo getPhrase('add');?></button><br>
        </div>
    </div>
</div>
<?php echo form_close();?>
<?php endforeach; ?>
<script>
if ($('#ckeditor2').length) {
    CKEDITOR.replace('ckeditor2');
}
</script>