<?php 
    $edit_data		=	$this->db->get_where('v_applicants' , array('applicant_id' => $param2) )->result_array();
    foreach ($edit_data as $row):
?>
<div class="modal-body">
    <div class="modal-header" style="background-color:#00579c">
        <h6 class="title" style="color:white"><?php echo getPhrase('add_interaction');?></h6>
    </div>
    <div class="ui-block-content">
        <span style="display:inline;">
            <h4><?= getPhrase('applicant');?>: </h4>
            <h6><?= $row['first_name'] . ' ' . $row['last_name']; ?></h6>
        </span>
        <?php echo form_open(base_url() . 'admin/admission_applicant_interaction/add/'.$row['applicant_id'] , array('enctype' => 'multipart/form-data'));?>
        <input type="hidden" name="applicant_id" value="<?= $row['applicant_id']?>">
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('status');?></label>
            <div class="col-sm-6">
                <div class="input-group">
                    <div class="select">
                    <select name="status_id" required="" style="width: 150px;">
                            <?php
                        $status = $this->applicant->get_applicant_status_update($row['status']);
                        foreach($status as $status_row):
                            if($status_row['status_id'] != 3):
                        ?>
                            <option value="<?= $status_row['status_id']?>"
                                <?= $status_row['status_id'] == $row['status'] ? 'selected': ''; ?>>
                                <?= $status_row['name']?>
                            </option>
                            <?php endif; endforeach;?>
                        </select>
                    </div>
                    <!-- <input class="form-control" name="status" value="<?php echo $row['status'];?>" required="" type="text"> -->
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('comment');?></label>
            <div class="col-sm-9">
                <div class="form-group">
                    <textarea id="ckeditor2" name="comment" required=""></textarea>
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