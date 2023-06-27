<?php 
    $running_year = $this->crud->getInfo('running_year');
    $running_semester = $this->crud->getInfo('running_semester');
    
    $user = get_account_type()."-".get_login_user_id();
    $teacher_id = get_login_user_id();

    $month_number = date('m');

?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="content-box">
            <br>
            <div class="tab-content ">
                <div class="tab-pane active" id="students">
                    <div class="element-wrapper">
                        <h6 class="element-header">
                            <?= getPhrase('student_month');?>
                            <div style="margin-top:auto;text-align:right;"><a href="#" data-target="#addroutine"
                                    data-toggle="modal" class="btn btn-control btn-grey-lighter btn-purple"><i
                                        class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i>
                                    <div class="ripple-container"></div>
                                </a></div>
                        </h6>
                        <div class="element-box-tp">
                            <div class="table-responsive">
                                <table class="table table-padded">
                                    <thead>
                                        <tr>
                                            <th><?= getPhrase('class');?></th>
                                            <th><?= getPhrase('section');?></th>
                                            <th><?= getPhrase('subject');?></th>
                                            <th><?= getPhrase('student');?></th>
                                            <th><?= getPhrase('month');?></th>
                                            <th><?= getPhrase('options');?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $this->db->reset_query();
                                            $this->db->where('year', $running_year);
                                            $this->db->where('semester_id', $running_semester);
                                            $this->db->where('created_by', $teacher_id);
                                            $reports = $this->db->get('v_student_month')->result_array();

                                            // $reports = $this->db->get_where('v_student_month ', array('created_by' => $teacher_id))->result_array();
        					                foreach($reports as $row):
                                        ?>
                                        <tr>
                                            <td>
                                                <?= $row['class_name'];?>
                                            </td>
                                            <td>
                                                <?= $row['section_name'];?>
                                            </td>
                                            <td>
                                                <?= $row['subject_name'];?>
                                            </td>
                                            <td>
                                                <?= $row['student_name'];?>
                                            </td>
                                            <td>
                                                <?= get_month_name($row['month']);?>
                                            </td>
                                            <td class="row-actions">
                                                <a href="<?= base_url();?>teacher/student_month_action/delete/<?= $row['student_month_id'];?>"
                                                    class="grey" data-toggle="tooltip" data-placement="top"
                                                    onClick="return confirm('<?php echo getPhrase('confirm_delete');?>')"
                                                    data-original-title="<?= getPhrase('delete');?>">
                                                    <i
                                                        class="os-icon picons-thin-icon-thin-0057_bin_trash_recycle_delete_garbage_full"></i>
                                                </a>
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
    <div class="display-type"></div>
</div>

<div class="modal fade" id="addroutine" tabindex="-1" role="dialog" aria-labelledby="addroutine" aria-hidden="true">
    <div class="modal-dialog window-popup edit-my-poll-popup" role="document">
        <div class="modal-content">
            <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close"></a>
            <?= form_open(base_url() . 'teacher/student_month_action/add/', array('enctype' => 'multipart/form-data')); ?>
            <div class="modal-body">
                <div class="ui-block-title" style="background-color:#00579c">
                    <h6 class="title" style="color:white"><?= getPhrase('add_student_month');?></h6>
                </div>
                <div class="ui-block-content">
                    <div class="row">
                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group label-floating is-select">
                                <label class="control-label"><?= getPhrase('class');?></label>
                                <div class="select">
                                    <select name="class_id" id="class_id" onchange="get_class_sections(this.value);">
                                        <option value=""><?= getPhrase('select');?></option>
                                        <?php 
                                            $cl = $this->crud->get_class_by_teacher($teacher_id);
                                            foreach($cl as $row):
                                        ?>
                                        <option value="<?= $row['class_id'];?>"><?= $row['class_name'];?>
                                        </option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group label-floating is-select">
                                <label class="control-label"><?= getPhrase('section');?></label>
                                <div class="select">
                                    <select name="section_id" id="section_selector_holder"
                                        onchange="get_class_sections_subjects(this.value);">
                                        <option value=""><?= getPhrase('select');?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group label-floating is-select">
                                <label class="control-label"><?= getPhrase('subject');?></label>
                                <div class="select">
                                    <select name="subject_id" id="subject_selector_holder"
                                        onchange="get_subject_students(this.value);">
                                        <option value=""><?= getPhrase('select');?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group label-floating is-select">
                                <label class="control-label"><?= getPhrase('month');?></label>
                                <div class="select">
                                    <select name="month">
                                        <option value="<?=($month_number - 1);?>">
                                            <?= get_month_name(($month_number - 1));?>
                                        </option>
                                        <option value="<?=$month_number;?>">
                                            <?= get_month_name($month_number);?>
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group label-floating is-select">
                                <label class="control-label"><?= getPhrase('student');?></label>
                                <div class="select">
                                    <select name="student_id" id="students_holder">
                                        <option value=""><?= getPhrase('select');?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group label-floating">
                                <label class="control-label"><?php echo getPhrase('reason');?>:</label>
                                <textarea class="form-control" name="reason" rows="3"></textarea>
                                <span class="material-input"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <center>
                    <button class="btn btn-rounded btn-success" type="submit">
                        <?php echo getPhrase('save');?>
                    </button>
                </center>
            </div>
            <?= form_close();?>
        </div>
    </div>
</div>
</div>

<script type="text/javascript">
function get_class_sections(class_id) {
    $.ajax({
        url: '<?= base_url();?>tools/get_class_section_by_teacher/' + class_id + '/<?=$teacher_id;?>',
        success: function(response) {
            jQuery('#section_selector_holder').html(response);
        }
    });
}

function get_class_sections_subjects(section_id) {

    var class_id = document.getElementById("class_id").value;

    $.ajax({
        url: '<?= base_url();?>tools/get_class_section_subject_by_teacher/' + class_id + '/' + section_id +
            '/<?=$teacher_id;?>',
        success: function(response) {
            jQuery('#subject_selector_holder').html(response);
        }
    });
}

function get_subject_students(subject_id) {
    $.ajax({
        url: '<?= base_url(); ?>tools/get_class_section_subject_students/' + subject_id,
        success: function(response) {
            jQuery('#students_holder').html(response);
        }
    });
}
</script>