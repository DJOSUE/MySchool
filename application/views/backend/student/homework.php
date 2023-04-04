<?php 
    $$running_year       = $this->crud->getInfo('running_year');
    $running_semester   = $this->crud->getInfo('running_semester'); 
    $useDailyMarks      = $this->crud->getInfo('use_daily_marks');
    $useGradeAttendance = $this->crud->getInfo('use_grade_attendance');
    
    $class_info = $this->db->get('class')->result_array();
    $info = base64_decode($data);
    $ex = explode('-', $info);
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
                            href="<?php echo base_url();?>student/subject_dashboard/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0482_gauge_dashboard_empty"></i><span><?php echo getPhrase('dashboard');?></span></a>
                    </li>
                    <?php if($this->academic->getInfo('show_online_exams') == 1) :?>
                    <li class="navs-item">
                        <a class="navs-links"
                            href="<?php echo base_url();?>student/online_exams/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0207_list_checkbox_todo_done"></i><span><?php echo getPhrase('online_exams');?></span></a>
                    </li>
                    <?php endif;?>
                    <?php if($this->academic->getInfo('show_homework') == 1) :?>
                    <li class="navs-item">
                        <a class="navs-links active" href="<?php echo base_url();?>student/homework/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0004_pencil_ruler_drawing"></i><span><?php echo getPhrase('homework');?></span></a>
                    </li>
                    <?php endif;?>
                    <?php if($this->academic->getInfo('show_forum') == 1) :?>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>student/forum/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0281_chat_message_discussion_bubble_reply_conversation"></i><span><?php echo getPhrase('forum');?></span></a>
                    </li>
                    <?php endif;?>
                    <?php if($this->academic->getInfo('show_study_material') == 1) :?>
                    <li class="navs-item">
                        <a class="navs-links"
                            href="<?php echo base_url();?>student/study_material/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0003_write_pencil_new_edit"></i><span><?php echo getPhrase('study_material');?></span></a>
                    </li>
                    <?php endif;?>
                    <li class="navs-item">
                        <a class="navs-links"
                            href="<?php echo base_url();?>student/subject_marks/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i><span><?php echo getPhrase('marks');?></span></a>
                    </li>
                    <?php if($useDailyMarks): ?>
                    <li class="navs-item">
                        <a class="navs-links"
                            href="<?php echo base_url();?>student/subject_daily_marks/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0197_layout_grid_view"></i><span><?php echo getPhrase('daily_marks');?></span></a>
                    </li>
                    <?php endif;?>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>student/subject_meet/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0591_presentation_video_play_beamer"></i><span><?php echo getPhrase('live');?></span></a>
                    </li>                    
                    <?php if(!$useGradeAttendance):?>
                    <li class="navs-item">
                        <a class="navs-links"
                            href="<?php echo base_url();?>student/attendance_report/<?php echo $data;?>/"><i
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
                                    <h6 class="element-header"><?php echo getPhrase('homework');?></h6>
                                    <div class="table-responsive">
                                        <table class="table table-padded">
                                            <thead>
                                                <tr>
                                                    <th><?php echo getPhrase('title');?></th>
                                                    <th><?php echo getPhrase('type');?></th>
                                                    <th><?php echo getPhrase('allow_homework_deliveries');?></th>
                                                    <th><?php echo getPhrase('options');?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                			            $counter = 1;
                            			                $class_id = $this->db->get_where('enroll' , array('student_id' => get_login_user_id() , 'year' => $running_year))->row()->class_id;
                            			                $section_id = $this->db->get_where('enroll' , array('student_id' => get_login_user_id() , 'year' => $running_year))->row()->section_id;
                            			                $this->db->order_by('homework_id', 'desc');
                            			                $homeworks = $this->db->get_where('homework', array('class_id' => $class_id, 'status' => 1, 'section_id' => $section_id, 'subject_id' => $ex[2]))->result_array();
                            			                foreach ($homeworks as $row):
                                	                ?>
                                                <tr>
                                                    <td><span><?php echo $row['title'];?></span></td>
                                                    <td>
                                                        <?php if($row['type'] ==1):?>
                                                        <span
                                                            class="badge badge-success"><?php echo getPhrase('online_text');?></span>
                                                        <?php endif;?>
                                                        <?php if($row['type'] == 2):?>
                                                        <span
                                                            class="badge badge-info"><?php echo getPhrase('files');?></span>
                                                        <?php endif;?>
                                                    </td>
                                                    <td><?php echo $row['date_end'];?></td>
                                                    <td class="bolder">
                                                        <a class="grey"
                                                            href="<?php echo base_url();?>student/homeworkroom/<?php echo $row['homework_code']; ?>"
                                                            data-toggle="tooltip" data-placement="top"
                                                            data-original-title="<?php echo getPhrase('view_homework');?>"><i
                                                                class="picons-thin-icon-thin-0043_eye_visibility_show_visible"></i></a>
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