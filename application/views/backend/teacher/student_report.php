<?php 
    $running_year = $this->crud->getInfo('running_year');
    $running_semester = $this->crud->getInfo('running_semester');
    
    $user = get_account_type()."-".get_login_user_id();
    $teacher_id = get_login_user_id();
?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <ul class="navs navs-tabs upper">
                    <li class="navs-item">
                        <a class="navs-links active" href="<?php echo base_url();?>teacher/student_report/"><i
                                class="os-icon picons-thin-icon-thin-0389_gavel_hammer_law_judge_court"></i><span><?php echo getPhrase('reports');?></span></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="content-box">
            <br>
            <div class="tab-content ">
                <div class="tab-pane active" id="students">
                    <div class="element-wrapper">
                        <h6 class="element-header">
                            <?php echo getPhrase('behavior');?>
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
                                            <th><?php echo getPhrase('priority');?></th>
                                            <th><?php echo getPhrase('date');?></th>
                                            <th><?php echo getPhrase('created_by');?></th>
                                            <th><?php echo getPhrase('student');?></th>
                                            <th><?php echo getPhrase('class');?></th>
                                            <th><?php echo getPhrase('section');?></th>
                                            <th><?php echo getPhrase('title');?></th>
                                            <th><?php echo getPhrase('options');?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $reports = $this->db->get_where('reports', array('user_id' => $user))->result_array();
        					                foreach($reports as $row):
        				                    $users = $row['user_id'];
                                            $re = explode('-', $users);
                                        ?>
                                        <tr>
                                            <td>
                                                <?php if($row['priority'] == 'alta'):?>
                                                <span
                                                    class="status-pill red"></span><span><?php echo getPhrase('high');?></span>
                                                <?php endif;?>
                                                <?php if($row['priority'] == 'media'):?>
                                                <span
                                                    class="status-pill yellow"></span><span><?php echo getPhrase('medium');?></span>
                                                <?php endif;?>
                                                <?php if($row['priority'] == 'baja'):?>
                                                <span
                                                    class="status-pill green"></span><span><?php echo getPhrase('low');?></span>
                                                <?php endif;?>
                                            </td>
                                            <td><span><?php echo $row['date'];?></span></td>
                                            <td class="cell-with-media">
                                                <img alt=""
                                                    src="<?php echo $this->crud->get_image_url($re[0], $re[1]);?>"
                                                    style="height: 25px;"><span><?php echo $this->crud->get_name($re[0], $re[1]);?></span>
                                            </td>
                                            <td class="cell-with-media">
                                                <img alt=""
                                                    src="<?php echo $this->crud->get_image_url('student', $row['student_id']);?>"
                                                    style="height: 25px;"><span>
                                                    <?php echo $this->crud->get_name('student', $row['student_id']);?></span>
                                            </td>
                                            <td><a class="badge badge-primary"
                                                    href="javascript:void(0);"><?php echo $this->db->get_where('class', array('class_id' => $row['class_id']))->row()->name;?></a>
                                            </td>
                                            <td><a class="badge badge-success"
                                                    href="javascript:void(0);"><?php echo $this->db->get_where('section', array('section_id' => $row['section_id']))->row()->name;?></a>
                                            </td>
                                            <td><?php echo $row['title'];?></td>
                                            <td class="bolder">
                                                <a href="<?php echo base_url();?>teacher/view_report/<?php echo $row['code'];?>/"
                                                    class="grey"><i class="px20"
                                                        class="picons-thin-icon-thin-0012_notebook_paper_certificate"
                                                        data-toggle="tooltip" data-placement="top"
                                                        data-original-title="<?php echo getPhrase('view_details');?>"></i></a>
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
            <div class="modal-body">
                <div class="ui-block-title" style="background-color:#00579c">
                    <h6 class="title" style="color:white"><?php echo getPhrase('add_report');?></h6>
                </div>
                <div class="ui-block-content">
                    <?php echo form_open(base_url() . 'teacher/student_report/send/', array('enctype' => 'multipart/form-data')); ?>
                    <div class="row">
                        <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group label-floating is-empty">
                                <label class="control-label"><?php echo getPhrase('title');?></label>
                                <input class="form-control" placeholder="" type="text" name="title">
                                <span class="material-input"></span>
                            </div>
                        </div>
                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group label-floating is-select">
                                <label class="control-label"><?php echo getPhrase('priority');?></label>
                                <div class="select">
                                    <select name="priority" id="slct" required="">
                                        <option value=""><?php echo getPhrase('select');?></option>
                                        <option value="baja"><?php echo getPhrase('low');?></option>
                                        <option value="media"><?php echo getPhrase('medium');?></option>
                                        <option value="alta"><?php echo getPhrase('high');?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
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
                        <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group label-floating is-select">
                                <label class="control-label"><?php echo getPhrase('student');?></label>
                                <div class="select">
                                    <select name="student_id" id="students_holder">
                                        <option value=""><?php echo getPhrase('select');?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="control-label"><?php echo getPhrase('file');?></label>
                                <input class="form-control" placeholder="" type="file" name="file">
                                <span class="material-input"></span>
                            </div>
                        </div>
                        <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <textarea class="form-control" rows="6"
                                    placeholder="<?php echo getPhrase('description');?>..." name="description"
                                    required=""></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-buttons-w text-right">
                        <center><button class="btn btn-rounded btn-success"
                                type="submit"><?php echo getPhrase('save');?></button></center>
                    </div>
                    <?php echo form_close();?>
                </div>
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