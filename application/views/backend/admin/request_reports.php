<?php 
    $running_year       = $this->crud->getInfo('running_year');
    $running_semester   = $this->crud->getInfo('running_semester');
?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <?php include('request__nav.php');?>
            </div>
        </div>
        <div class="content-box">
            <div class="os-tabs-w">
                <div class="os-tabs-controls">
                    <ul class="navs navs-tabs upper">
                        <li class="navs-item">
                            <a class="navs-links active" data-toggle="tab"
                                href="#students"><?php echo getPhrase('students');?></a>
                        </li>
                        <li class="navs-item">
                            <a class="navs-links" data-toggle="tab"
                                href="#teachers"><?php echo getPhrase('teachers');?></a>
                        </li>
                    </ul>
                </div>
            </div>
            <br>
            <div class="tab-content ">
                <div class="tab-pane active" id="students">
                    <div class="element-wrapper">
                        <h6 class="element-header">
                            <?php echo getPhrase('student_reports');?>
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
                                        <?php 
                                            $this->db->order_by('id', 'desc');
                                            $reports = $this->db->get('reports')->result_array();
					                        foreach($reports as $row):
				                            $user = $row['user_id'];
                                            $re = explode('-', $user);
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
                                                <a href="<?php echo base_url();?>admin/looking_report/<?php echo $row['code'];?>/"
                                                    class="grey"><i
                                                        class="picons-thin-icon-thin-0012_notebook_paper_certificate"
                                                        data-toggle="tooltip" data-placement="top"
                                                        data-original-title="<?php echo getPhrase('view_details');?>"></i></a>
                                                <a onClick="return confirm('<?php echo getPhrase('confirm_delete');?>')"
                                                    href="<?php echo base_url();?>admin/request_student/delete/<?php echo $row['code'];?>"
                                                    class="grey"><i
                                                        class="picons-thin-icon-thin-0057_bin_trash_recycle_delete_garbage_full"
                                                        data-toggle="tooltip" data-placement="top"
                                                        data-original-title="<?php echo getPhrase('delete');?>"></i></a>
                                            </td>
                                        </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="teachers">
                    <div class="element-wrapper">
                        <h6 class="element-header"><?php echo getPhrase('teachers_reports');?></h6>
                        <div class="element-box-tp">
                            <div class="table-responsive">
                                <table class="table table-padded">
                                    <thead>
                                        <tr>
                                            <th><?php echo getPhrase('priority');?></th>
                                            <th><?php echo getPhrase('date');?></th>
                                            <th><?php echo getPhrase('created_by');?></th>
                                            <th><?php echo getPhrase('teacher');?></th>
                                            <th><?php echo getPhrase('title');?></th>
                                            <th><?php echo getPhrase('options');?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
				                            $reports = $this->db->get('student_report')->result_array();
				                            foreach($reports as $row):
			                            ?>
                                        <tr>
                                            <td>
                                                <?php if($row['priority'] == 'alta'):?>
                                                <span
                                                    class="status-pill  red"></span><span><?php echo getPhrase('high');?></span>
                                                <?php endif;?>
                                                <?php if($row['priority'] == 'media'):?>
                                                <span
                                                    class="status-pill  yellow"></span><span><?php echo getPhrase('medium');?></span>
                                                <?php endif;?>
                                                <?php if($row['priority'] == 'baja'):?>
                                                <span
                                                    class="status-pill  green"></span><span><?php echo getPhrase('low');?></span>
                                                <?php endif;?>
                                            </td>
                                            <td><span><?php echo $row['timestamp'];?></span></td>
                                            <td class="cell-with-media">
                                                <img alt=""
                                                    src="<?php echo $this->crud->get_image_url('student', $row['student_id']);?>"
                                                    style="height: 25px;"><span><?php echo $this->crud->get_name('student', $row['student_id']);?></span>
                                            </td>
                                            <td class="cell-with-media">
                                                <img alt=""
                                                    src="<?php echo $this->crud->get_image_url('teacher', $row['teacher_id']);?>"
                                                    style="height: 25px;"><span><?php echo $this->crud->get_name('teacher', $row['teacher_id']);?></span>
                                            </td>
                                            <td><a class="badge badge-danger"
                                                    href="javascript:void(0);"><?php echo $row['title'];?></a></td>
                                            <td class="bolder">
                                                <a href="<?php echo base_url();?>admin/view_report/<?php echo $row['report_code'];?>/"
                                                    class="grey"><i class="px20"
                                                        class="picons-thin-icon-thin-0012_notebook_paper_certificate"
                                                        data-toggle="tooltip" data-placement="top"
                                                        data-original-title="<?php echo getPhrase('view_details');?>"></i></a>
                                                <a onClick="return confirm('<?php echo getPhrase('confirm_delete');?>')"
                                                    href="<?php echo base_url();?>admin/request_student/delete_teacher/<?php echo $row['report_code'];?>"
                                                    class="grey"><i class="px20"
                                                        class="picons-thin-icon-thin-0057_bin_trash_recycle_delete_garbage_full"
                                                        data-toggle="tooltip" data-placement="top"
                                                        data-original-title="<?php echo getPhrase('delete');?>"></i></a>
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
            <a href="javascript:void(0);" class="close icon-close" data-dismiss="modal" aria-label="Close"></a>
            <div class="modal-body">
                <div class="ui-block-title" style="background-color:#00579c">
                    <h6 class="title" style="color:white"><?php echo getPhrase('add_report');?></h6>
                </div>
                <div class="ui-block-content">
                    <?php echo form_open(base_url() . 'admin/create_report/send/', array('enctype' => 'multipart/form-data')); ?>
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
                                <label class="control-label"><?php echo getPhrase('class');?></label>
                                <div class="select">
                                    <select name="class_id"
                                        onchange="get_class_sections(this.value); get_class_subject(this.value);">
                                        <option value=""><?php echo getPhrase('select');?></option>
                                        <?php $cl = $this->db->get('class')->result_array();
                                                    foreach($cl as $row):
                                                ?>
                                        <option value="<?php echo $row['class_id'];?>"><?php echo $row['name'];?>
                                        </option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group label-floating is-select">
                                <label class="control-label"><?php echo getPhrase('section');?></label>
                                <div class="select">
                                    <select name="section_id" id="section_selector_holder"
                                        onchange="get_class_students(this.value);">
                                        <option value=""><?php echo getPhrase('select');?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group label-floating is-select">
                                <label class="control-label"><?php echo getPhrase('stduent');?></label>
                                <div class="select">
                                    <select name="student_id" id="students_holder">
                                        <option value=""><?php echo getPhrase('select');?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group label-floating is-select">
                                <label class="control-label"><?php echo getPhrase('priority');?></label>
                                <div class="select">
                                    <select name="priority" required="">
                                        <option value=""><?php echo getPhrase('select');?></option>
                                        <option value="baja"><?php echo getPhrase('low');?></option>
                                        <option value="media"><?php echo getPhrase('medium');?></option>
                                        <option value="alta"><?php echo getPhrase('high');?></option>
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
        url: '<?php echo base_url();?>admin/get_class_section/' + class_id,
        success: function(response) {
            jQuery('#section_selector_holder').html(response);
        }
    });
}

function get_class_students(class_id) {
    $.ajax({
        url: '<?php echo base_url(); ?>admin/get_class_students/' + class_id,
        success: function(response) {
            jQuery('#students_holder').html(response);
        }
    });
}
</script>