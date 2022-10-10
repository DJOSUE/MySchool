<?php 
    $edit_data		=	$this->db->get_where('student_interaction' , array('interaction_id' => $param2) )->result_array();
    foreach ($edit_data as $row):
        $comment =   str_replace(array("\r", "\n"), '', $row['comment']);
?>
<div class="modal-body">
    <div class="modal-header" style="background-color:#00579c">
        <h6 class="title" style="color:white"><?php echo getPhrase('add_interaction');?></h6>
    </div>
    <div class="ui-block-content">
        <?php echo form_open(base_url() . 'admin/admission_student_interaction/update/'.$row['student_id'].'/'.$row['interaction_id'] , array('enctype' => 'multipart/form-data'));?>
        <input type="hidden" name="applicant_id" value="<?= $row['applicant_id']?>">
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('comment');?></label>
            <div class="col-sm-9">
                <div class="form-group">
                    <textarea id="ckeditor3" name="comment" required=""></textarea>
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
                    <input class="form-control" name="applicant_file" type="file"
                        accept="image/jpeg,image/png,application/pdf">
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

    var t = "<?=html_entity_decode($comment);?>";

    CKEDITOR.instances.ckeditor3.setData(t.replace(/(\r\n|\n|\r)/gm, ""));
}
</script>

<?php endforeach; ?>