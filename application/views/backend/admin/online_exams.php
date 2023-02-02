<?php 
    $running_year       = $this->crud->getInfo('running_year');
    $running_semester   = $this->crud->getInfo('running_semester'); 
    $useDailyMarks      = $this->crud->getInfo('use_daily_marks');
    $useGradeAttendance = $this->crud->getInfo('use_grade_attendance');

    $info = base64_decode($data);
    $ex = explode('-', $info);
    $class_id   = $ex[0];
    $section_id = $ex[1];
    $subject_id = $ex[2];

    $sub = $this->db->get_where('subject', array('subject_id' => $subject_id))->result_array();

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
                <h3 class="cta-header"><?php echo $row['name'];?> -
                    <small><?php echo getPhrase('online_exams');?></small>
                </h3>
                <small
                    style="font-size:0.90rem; color:#fff;"><?php echo $this->db->get_where('class', array('class_id' => $class_id))->row()->name;?>
                    "<?php echo $this->db->get_where('section', array('section_id' => $section_id))->row()->name;?>"</small>
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
                        <a class="navs-links active"
                            href="<?php echo base_url();?>admin/online_exams/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0207_list_checkbox_todo_done"></i><span><?php echo getPhrase('online_exams');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/homework/<?php echo $data;?>/"><i
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
                                        <?php echo getPhrase('online_exams');?>
                                        <?php if(has_permission('online_exams_management')):?>
                                        <div style="margin-top:auto;float:right;"><a
                                                href="<?php echo base_url();?>admin/new_exam/<?php echo $data;?>/"
                                                class="text-white btn btn-control btn-grey-lighter btn-success"><i
                                                    class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i>
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
                                                    <th><?php echo getPhrase('date');?></th>
                                                    <th><?php echo getPhrase('options');?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $this->db->order_by('online_exam_id', 'desc');
                                                    $online_exams = $this->db->where(array('year' => $running_year, 'semester_id' => $running_semester, 'subject_id' => $row['subject_id'], 'class_id' => $row['class_id'],'section_id' => $section_id))->get('online_exam')->result_array();
                                                    foreach($online_exams as $row):
                                                ?>
                                                <tr>
                                                    <td><button
                                                            class="btn btn-<?php echo $row['status'] == 'published' ? 'success' : 'warning'; ?> btn-sm"><?php if($row['status'] == "published") echo getPhrase('published'); else if($row['status'] == "pending") echo getPhrase('pending'); else echo getPhrase('expired');?></button>
                                                    </td>
                                                    <td><span><?php echo $row['title'];?></span></td>
                                                    <td><span><?php echo '<b>'.getPhrase('date').':</b> '.date('M d, Y', $row['exam_date']).'<br>'.'<b>'.getPhrase('hour').':</b> '.$row['time_start'].' - '.$row['time_end'];?></span>
                                                    </td>
                                                    <td class="bolder">
                                                        <a href="<?php echo base_url();?>admin/examroom/<?php echo $row['online_exam_id'];?>"
                                                            class="btn btn-success btn-sm">
                                                            <?php echo getPhrase('details');?>
                                                        </a>
                                                        <br>
                                                        <?php if(has_permission('online_exams_management')):?>
                                                        <?php if ($row['status'] == 'pending'): ?>
                                                        <a href="<?php echo base_url();?>admin/manage_online_exam_status/<?php echo $row['online_exam_id'];?>/published/<?php echo $data;?>/"
                                                            onclick="return confirm('<?php echo getPhrase('confirm_publish');?>')"
                                                            class="btn btn-info btn-sm"><?php echo getPhrase('publish_exam');?>
                                                        </a><br>
                                                        <?php elseif ($row['status'] == 'published'): ?>
                                                        <a href="<?php echo base_url();?>admin/manage_online_exam_status/<?php echo $row['online_exam_id'];?>/expired/<?php echo $data;?>/"
                                                            onclick="return confirm('<?php echo getPhrase('confirm_expired');?>')"
                                                            class="btn btn-primary btn-sm">
                                                            <?php echo getPhrase('mark_as_expired');?>
                                                        </a><br>
                                                        <?php elseif($row['status'] == 'expired'): ?>
                                                        <a href="javascript:void(0);" class="btn btn-warning btn-sm">
                                                            <?php echo getPhrase('expired');?>
                                                        </a><br>
                                                        <?php endif; ?>
                                                        <a class="btn btn-danger btn-sm"
                                                            onClick="return confirm('<?php echo getPhrase('confirm_delete');?>')"
                                                            href="<?php echo base_url();?>admin/online_exams/delete/<?php echo $row['online_exam_id'];?>/<?php echo $data;?>/"><?php echo getPhrase('delete');?>
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
        </div>
    </div>
</div>
<?php endforeach;?>