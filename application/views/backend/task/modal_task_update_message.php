<?php 
    $this->db->reset_query();
    $this->db->where('task_message_id' , $param2);
    $task_query = $this->db->get('task_message');
    $edit_data = $task_query->result_array();

    foreach ($edit_data as $row):
        $message =   str_replace(array("\r", "\n"), '', $row['message']);
?>
<div class="modal-body">
    <div class="modal-header" style="background-color:#00579c">
        <h6 class="title" style="color:white"><?php echo getPhrase('add_interaction');?></h6>
    </div>
    <div class="ui-block-content">
        <?php echo form_open(base_url() . 'assignment/task_message/update/'.$row['task_code'].'/'.$row['task_message_id'] , array('enctype' => 'multipart/form-data'));?>
        <input type="hidden" name="applicant_id" value="<?= $row['applicant_id']?>">
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('comment');?></label>
            <div class="col-sm-9">
                <div class="form-group">
                    <textarea id="ckeditor3" name="message" required=""></textarea>
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
                        accept="<?=FILES_ALLOWED_ATTACHMENT?>">
                </div>
            </div>
        </div>
        <div class="form-buttons-w">
            <button class="btn btn-rounded btn-success" style="float: right;" type="submit">
                <?php echo getPhrase('submit');?></button><br>
        </div>
    </div>
</div>
<?php echo form_close();?>

<script>
if ($('#ckeditor3').length) {
    CKEDITOR.replace('ckeditor3', { toolbar: 'Basic' });

    var t = "<?=html_entity_decode($message);?>";

    CKEDITOR.instances.ckeditor3.setData(t.replace(/(\r\n|\n|\r)/gm, ""));
}
</script>

<?php endforeach; ?>