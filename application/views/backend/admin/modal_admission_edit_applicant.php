<?php 
    $edit_data		=	$this->db->get_where('v_applicants' , array('applicant_id' => $param2) )->result_array();
    foreach ($edit_data as $row):
?>
<div class="modal-body">
    <div class="modal-header" style="background-color:#00579c">
        <h6 class="title" style="color:white"><?php echo getPhrase('edit_applicant');?></h6>
    </div>
    <div class="ui-block-content">
        <span style="display:inline;">
            <h4><?= getPhrase('applicant');?>: <?= $row['first_name'] . ' ' . $row['last_name']; ?> </h4>
        </span>
        <?php echo form_open(base_url() . 'admin/applicant/update/'.$row['applicant_id'] , array('enctype' => 'multipart/form-data'));?>
        <input type="hidden" name="applicant_id" value="<?= $row['applicant_id']?>">
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('assigned_to');?></label>
            <div class="col-sm-6">
                <div class="input-group">
                    <div class="select">
                        <select name="assigned_to" style="width: 150px;">
                            <option value=""><?= getPhrase('select');?></option>
                            <?php $advisors = $this->db->get_where('admin', array('status' => 1, 'owner_status' => '3'))->result_array();
                            foreach($advisors as $advisor):
                            ?>
                            <option value="<?= $advisor['admin_id']?>"
                                <?= $advisor['admin_id'] == $row['assigned_to'] ? 'selected': ''; ?>>
                                <?= $advisor['first_name']?>
                            </option>
                            <?php endforeach;?>
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
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('first_name');?></label>
            <div class="col-sm-9">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="picons-thin-icon-thin-0003_write_pencil_new_edit"></i>
                    </div>
                    <input class="form-control" name="first_name" value="<?php echo $row['first_name'];?>" required=""
                        type="text">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('last_name');?></label>
            <div class="col-sm-9">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="picons-thin-icon-thin-0003_write_pencil_new_edit"></i>
                    </div>
                    <input class="form-control" name="last_name" value="<?php echo $row['last_name'];?>" required=""
                        type="text">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('gender');?></label>
            <div class="col-sm-6">
                <div class="input-group">
                    <div class="select">
                        <select name="gender" required="" style="width: 250px;">
                            <?php
                        $gender = $this->db->get('gender')->result_array();
                        foreach($gender as $gender_row):
                        ?>
                            <option value="<?= $gender_row['code']?>"
                                <?= $gender_row['code'] == $row['gender'] ? 'selected': ''; ?>>
                                <?= $gender_row['name']?>
                            </option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('country_id');?></label>
            <div class="col-sm-6">
                <div class="input-group">
                    <div class="select">
                        <select name="country_id" required="" style="width: 250px;">
                            <?php
                        $gender = $this->db->get('countries')->result_array();
                        foreach($gender as $gender_row):
                        ?>
                            <option value="<?= $gender_row['country_id']?>"
                                <?= $gender_row['country_id'] == $row['country_id'] ? 'selected': ''; ?>>
                                <?= $gender_row['name']?>
                            </option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('birthday');?></label>
            <div class="col-sm-9">
                <div class="input-group date-time-picker">
                    <div class="input-group-addon">
                        <i class="picons-thin-icon-thin-0003_write_pencil_new_edit"></i>
                    </div>
                    <input type='date' class="datepicker-here" data-position="bottom left" data-language='en'
                        name="datetimepicker" data-multiple-dates-separator="/" value="<?php echo $row['birthday'];?>"/>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('email');?></label>
            <div class="col-sm-9">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="picons-thin-icon-thin-0003_write_pencil_new_edit"></i>
                    </div>
                    <input class="form-control" name="email" value="<?php echo $row['email'];?>" required=""
                        type="text">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('phone');?></label>
            <div class="col-sm-9">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="picons-thin-icon-thin-0003_write_pencil_new_edit"></i>
                    </div>
                    <input class="form-control" name="phone" value="<?php echo $row['phone'];?>" required=""
                        type="text">
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
    CKEDITOR.replace('ckeditor2');
}
</script>