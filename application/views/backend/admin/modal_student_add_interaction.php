<?php 
    $edit_data		=	$this->db->get_where('v_students' , array('student_id' => $param2) )->result_array();
    foreach ($edit_data as $row):
?>
<div class="modal-body">
    <div class="modal-header" style="background-color:#00579c">
        <h6 class="title" style="color:white"><?= getPhrase('add_interaction');?></h6>
    </div>
    <div class="ui-block-content">
        <span style="display:inline;">
            <h4><?= getPhrase('student');?>: </h4>
            <h6><?= $row['first_name'] . ' ' . $row['last_name']; ?></h6>
        </span>
        <?= form_open(base_url() . 'admin/admission_student_interaction/add/'.$row['student_id'].'/0/'.$param3 , array('enctype' => 'multipart/form-data'));?>
        <input type="hidden" name="student_id" value="<?= $row['student_id']?>">
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?= getPhrase('comment');?></label>
            <div class="col-sm-9">
                <div class="form-group">
                    <textarea id="ckeditor2" name="comment" id="comment" required=""></textarea>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?= getPhrase('file');?></label>
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
                <?= getPhrase('add');?></button><br>
        </div>
    </div>
</div>
<?= form_close();?>
<?php endforeach; ?>
<script>
    if ($('#ckeditor2').length) {
        CKEDITOR.replace('ckeditor2');
    }
</script>