<?php 
    $running_year       = $this->crud->getInfo('running_year');
    $running_semester   = $this->crud->getInfo('running_semester'); 
    $useDailyMarks      = $this->crud->getInfo('use_daily_marks');
    $useGradeAttendance = $this->crud->getInfo('use_grade_attendance');

    $class_info = $this->db->get('class')->result_array();
    $info = base64_decode($data);
    $ex = explode('-', $info);
?>
<?php 
    $sub = $this->db->get_where('subject', array('subject_id' => $ex[2]))->result_array();
    foreach($sub as $row):
?>
<div class="content-w">
    <div class="conty">
        <?php include 'fancy.php';?>
        <div class="header-spacer"></div>
        <div class="cursos cta-with-media" style="background: #<?php echo $row['color'];?>;">
            <div class="cta-content">
                <div class="user-avatar">
                    <img alt="" src="<?php echo base_url();?>public/uploads/subject_icon/<?php echo $row['icon'];?>"
                        style="width:60px;">
                </div>
                <h3 class="cta-header"><?php echo $row['name'];?> - <small><?php echo getPhrase('homework');?></small>
                </h3>
                <small
                    style="font-size:0.90rem; color:#fff;"><?php echo $this->db->get_where('class', array('class_id' => $ex[0]))->row()->name;?>
                    "<?php echo $this->db->get_where('section', array('section_id' => $ex[1]))->row()->name;?>"</small>
            </div>
        </div>
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <ul class="navs navs-tabs upper">
                    <li class="navs-item">
                        <a class="navs-links"
                            href="<?php echo base_url();?>admin/subject_dashboard/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0482_gauge_dashboard_empty"></i><span><?php echo getPhrase('dashboard');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/online_exams/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0207_list_checkbox_todo_done"></i><span><?php echo getPhrase('online_exams');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links active"
                            href="<?php echo base_url();?>admin/homework/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0004_pencil_ruler_drawing"></i><span><?php echo getPhrase('homework');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/forum/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0281_chat_message_discussion_bubble_reply_conversation"></i><span><?php echo getPhrase('forum');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links"
                            href="<?php echo base_url();?>admin/study_material/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0003_write_pencil_new_edit"></i><span><?php echo getPhrase('study_material');?></span></a>
                    </li>
                    <?php if($useDailyMarks): ?>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/daily_marks/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i><span><?php echo getPhrase('marks');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links"
                            href="<?php echo base_url();?>admin/subject_daily_marks_average/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0197_layout_grid_view"></i><span><?php echo getPhrase('daily_marks_average');?></span></a>
                    </li>
                    <?php else: ?>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/upload_marks/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i><span><?php echo getPhrase('marks');?></span></a>
                    </li>
                    <?php endif; ?>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/subject_meet/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0591_presentation_video_play_beamer"></i><span><?php echo getPhrase('live');?></span></a>
                    </li>
                    <?php if(!$useGradeAttendance):?>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/attendance/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i><span><?php echo getPhrase('attendance');?></span></a>
                    </li>
                    <?php endif;?>
                </ul>
            </div>
        </div>
        <div class="content-i">
            <div class="content-box">
                <div class="row">
                    <main class="col col-xl-12 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
                        <div id="newsfeed-items-grid">
                            <div class="element-wrapper">
                                <div class="element-box-tp">
                                    <h6 class="element-header">
                                        <?php echo getPhrase('homework');?>
                                        <?php if(has_permission('homework_management')):?>
                                        <div style="margin-top:auto;float:right;">
                                            <a href="javascript:void(0);" data-target="#new_homework"
                                                data-toggle="modal"
                                                class="text-white btn btn-control btn-grey-lighter btn-success">
                                                <i class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i>
                                                <div class="ripple-container"></div>
                                            </a>
                                        </div>
                                        <?php endif;?>
                                    </h6>
                                    <div class="table-responsive">
                                        <table class="table table-padded">
                                            <thead>
                                                <tr>
                                                    <th><?php echo getPhrase('status');?></th>
                                                    <th><?php echo getPhrase('title');?></th>
                                                    <th><?php echo getPhrase('type');?></th>
                                                    <th><?php echo getPhrase('allow_homework_deliveries');?></th>
                                                    <th><?php echo getPhrase('options');?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
    			                                    $counter = 1;
    			                                    $this->db->order_by('homework_id', 'desc');
    			                                    $homeworks = $this->db->get_where('homework', array('subject_id' => $row['subject_id'], 'year' => $running_year, 'class_id' => $ex[0],'section_id' => $ex[1]))->result_array();
    			                                    foreach ($homeworks as $hm):
        	                                    ?>
                                                <tr>
                                                    <td>
                                                        <?php if($hm['status'] == 1):?>
                                                        <span class="status-pill green"></span>
                                                        <span><?php echo getPhrase('published');?></span>
                                                        <?php else:?>
                                                        <span
                                                            class="status-pill red"></span><span><?php echo getPhrase('no_published');?></span>
                                                        <?php endif;?>
                                                    </td>
                                                    <td><span><?php echo $hm['title'];?></span></td>
                                                    <td>
                                                        <?php if($hm['type'] ==1):?>
                                                        <span
                                                            class="badge badge-success"><?php echo getPhrase('online_text');?></span>
                                                        <?php endif;?>
                                                        <?php if($hm['type'] == 2):?>
                                                        <span
                                                            class="badge badge-info"><?php echo getPhrase('files');?></span>
                                                        <?php endif;?>
                                                    </td>
                                                    <td><?php echo $hm['date_end'];?></td>
                                                    <td class="bolder">
                                                        <a class="grey"
                                                            href="<?php echo base_url();?>admin/homeworkroom/<?php echo $hm['homework_code'];?>"
                                                            data-toggle="tooltip" data-placement="top"
                                                            data-original-title="<?php echo getPhrase('view_homework');?>">
                                                            <i class="picons-thin-icon-thin-0043_eye_visibility_show_visible"></i>
                                                        </a>
                                                        <?php if(has_permission('homework_management')):?>
                                                        <a class="grey" data-toggle="tooltip" data-placement="top"
                                                            data-original-title="<?php echo getPhrase('delete');?>"
                                                            class="danger"
                                                            href="<?php echo base_url(); ?>admin/homework/delete/<?php echo $hm['homework_code']; ?>/<?php echo $data;?>/"
                                                            onClick="return confirm('<?php echo getPhrase('confirm_delete');?>')">
                                                            <i class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i>
                                                        </a>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <?php endforeach;?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
            <a class="back-to-top" href="javascript:void(0);">
                <img src="<?php echo base_url();?>public/style/olapp/svg-icons/back-to-top.svg" alt="arrow"
                    class="back-icon">
            </a>
        </div>
    </div>
</div>

<div class="modal fade" id="new_homework" tabindex="-1" role="dialog" aria-labelledby="new_homework" aria-hidden="true">
    <div class="modal-dialog window-popup edit-my-poll-popup" role="document">
        <div class="modal-content">
            <a href="javascript:void(0);" class="close icon-close" data-dismiss="modal" aria-label="Close"></a>
            <div class="modal-body">
                <div class="ui-block-title" style="background-color:#00579c">
                    <h6 class="title" style="color:white"><?php echo getPhrase('new_homework');?></h6>
                </div>
                <div class="ui-block-content">
                    <?php echo form_open(base_url() . 'admin/homework/create/', array('enctype' => 'multipart/form-data')); ?>
                    <div class="row">
                        <input type="hidden" value="<?php echo $ex[0];?>" name="class_id" />
                        <input type="hidden" value="<?php echo $ex[1];?>" name="section_id" />
                        <input type="hidden" value="<?php echo $ex[2];?>" name="subject_id" />
                        <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group label-floating">
                                <label class="control-label"><?php echo getPhrase('title');?></label>
                                <input class="form-control" name="title" type="text" required="">
                            </div>
                        </div>
                        <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                            <label class="control-label"><?php echo getPhrase('type');?></label>
                        </div>
                        <div class="col col-lg-6 col-md-6 col-sm-6 col-6">
                            <center>
                                <div class="custom-control custom-radio" style="float: right">
                                    <input type="radio" name="type" id="1" required="" value="1"
                                        class="custom-control-input"> <label for="1"
                                        class="custom-control-label"><?php echo getPhrase('online_text');?></label>
                                </div>
                            </center>
                        </div>
                        <div class="col col-lg-6 col-md-6 col-sm-6 col-6">
                            <div class="custom-control custom-radio">
                                <input type="radio" name="type" id="2" value="2" class="custom-control-input"> <label
                                    for="2" class="custom-control-label"><?php echo getPhrase('files');?></label>
                            </div>
                        </div>
                        <div class="col col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group label-floating">
                                <label class="control-label"><?php echo getPhrase('date');?></label>
                                <input type='text' class="datepicker-here" required="" data-position="bottom left"
                                    data-language='en' name="date_end" data-multiple-dates-separator="/" />
                            </div>
                        </div>
                        <div class="col col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group label-floating">
                                <label class="control-label"><?php echo getPhrase('time');?></label>
                                <div class="input-group clockpicker" data-align="top" data-autoclose="true">
                                    <input type="text" required="" name="time_end" class="form-control" value="09:30">
                                </div>
                            </div>
                        </div>
                        <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="description-toggle">
                                <div class="description-toggle-content">
                                    <div class="h6"><?php echo getPhrase('show_students');?></div>
                                    <p><?php echo getPhrase('show_message');?></p>
                                </div>
                                <div class="togglebutton">
                                    <label><input name="status" value="1" type="checkbox"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="control-label"><?php echo getPhrase('description');?></label>
                                <textarea class="form-control" id="ckeditor1" name="description" required=""></textarea>
                            </div>
                        </div>
                        <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="control-label"><?php echo getPhrase('file');?></label>
                                <input class="form-control" name="file_name" type="file">
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
<?php endforeach;?>