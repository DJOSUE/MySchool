<?php 
    $running_year       = $this->crud->getInfo('running_year');
    $running_semester   = $this->crud->getInfo('running_semester'); 

    $useDailyMarks      = $this->crud->getInfo('use_daily_marks');
    $useGradeAttendance = $this->crud->getInfo('use_grade_attendance');

    $quantity_score         = intval($this->academic->getInfo('ap_quantity_score'));
    $ap_test_names          = json_decode($this->academic->getInfo('ap_test_names'), true);
    $achievement_weighting  = json_decode($this->academic->getInfo('achievement_weighting'), true);

    $info   = base64_decode($data);
    $ex     = explode('-', $info);
    
    $class_id   = $ex[0];
    $subject_id = $ex[2];

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
                <h3 class="cta-header"><?php echo $row['name'];?> - <small><?php echo getPhrase('dashboard');?></small>
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
                            href="<?php echo base_url();?>teacher/subject_dashboard/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0482_gauge_dashboard_empty"></i><span><?php echo getPhrase('dashboard');?></span></a>
                    </li>
                    <?php if($this->academic->getInfo('show_achievement_test') == 1) :?>
                    <li class="navs-item">
                        <a class="navs-links active"
                            href="<?php echo base_url();?>teacher/achievement_test/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0658_cup_place_winner_award_prize_achievement"></i><span><?php echo getPhrase('achievement_test');?></span></a>
                    </li>
                    <?php endif; ?>
                    <?php if($this->academic->getInfo('show_online_exams') == 1) :?>
                    <li class="navs-item">
                        <a class="navs-links"
                            href="<?php echo base_url();?>teacher/online_exams/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0207_list_checkbox_todo_done"></i><span><?php echo getPhrase('online_exams');?></span></a>
                    </li>
                    <?php endif; ?>
                    <?php if($this->academic->getInfo('show_homework') == 1) :?>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>teacher/homework/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0004_pencil_ruler_drawing"></i><span><?php echo getPhrase('homework');?></span></a>
                    </li>
                    <?php endif; ?>
                    <?php if($this->academic->getInfo('show_forum') == 1) :?>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>teacher/forum/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0281_chat_message_discussion_bubble_reply_conversation"></i><span><?php echo getPhrase('forum');?></span></a>
                    </li>
                    <?php endif; ?>
                    <?php if($this->academic->getInfo('show_study_material') == 1) :?>
                    <li class="navs-item">
                        <a class="navs-links"
                            href="<?php echo base_url();?>teacher/study_material/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0003_write_pencil_new_edit"></i><span><?php echo getPhrase('study_material');?></span></a>
                    </li>
                    <?php endif; ?>
                    <li class="navs-item">
                        <a class="navs-links"
                            href="<?php echo base_url();?>teacher/upload_marks/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i><span><?php echo getPhrase('marks');?></span></a>
                    </li>                    
                    <?php if($useDailyMarks): ?>
                    <li class="navs-item">
                        <a class="navs-links"
                            href="<?php echo base_url();?>teacher/daily_marks_average/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0197_layout_grid_view"></i><span><?php echo getPhrase('daily_marks_average');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links"
                            href="<?php echo base_url();?>teacher/update_daily_marks/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0256_input_box_text_edit"></i><span><?php echo getPhrase('update_daily_marks');?></span></a>
                    </li>
                    <?php endif; ?>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>teacher/meet/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0591_presentation_video_play_beamer"></i><span><?php echo getPhrase('live');?></span></a>
                    </li>
                    <?php if(!$useGradeAttendance):?>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>teacher/attendance/<?php echo $data;?>/"><i
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
                        <div class="ui-block">
                            <article class="hentry post thumb-full-width">
                                <div class="post__author author vcard inline-items">
                                    <img src="<?php echo base_url();?>public/uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>"
                                        style="border-radius:0px;">
                                    <div class="author-date">
                                        <a class="h6 post__author-name fn"><?php echo getPhrase('achievement_test');?></a>
                                    </div>
                                </div>
                                <div class="edu-posts cta-with-media">
                                    <?php echo form_open(base_url() . 'teacher/update_achievement_test_batch/'.$data);?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr style="background:#f2f4f8;">
                                                    <th style="text-align: center;">
                                                        <?php echo getPhrase('student');?>
                                                    </th>
                                                    <?php for ($i=1; $i <= $quantity_score; $i++):
                                                        $name = 'score'.$i;?>
                                                    <th class="text-center">
                                                        <?= $ap_test_names[$name] ?>
                                                    </th>
                                                    <?php endfor; ?>

                                                    <th style="text-align: center;"><?php echo getPhrase('comment');?>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                        $count = 1;
                                                        $test_students = $this->db->get_where('pa_test' , array('class_id' => $ex[0], 'section_id' => $ex[1] ,'year' => $running_year,'semester_id' => $running_semester))->result_array();
                                                        foreach($test_students as $row):
                                                    ?>
                                                <tr style="height:25px;">
                                                    <td style="min-width:190px">
                                                        <img alt=""
                                                            src="<?php echo $this->crud->get_image_url('student', $row['student_id']);?>"
                                                            width="25px" style="border-radius: 10px;margin-right:5px;">
                                                        <?php echo $this->crud->get_name('student', $row['student_id']);?>
                                                    </td>
                                                    <?php 
                                                        for ($i=1; $i <= $quantity_score; $i++):
                                                            $name = 'score'.$i
                                                    ?>
                                                    <td>
                                                        <center><input type="number"
                                                                name="<?= $name.'_'.$row['test_id'];?>"
                                                                placeholder="0"
                                                                max="<?= $achievement_weighting[$name] ?>"
                                                                style="width:85px; border: 1; text-align: center;"
                                                                value="<?php echo $row[$name];?>"> </center>
                                                    </td>
                                                    
                                                    <?php endfor;?>
                                                    <td>
                                                        <center><input type="text" class="form-control"
                                                                name="comment_<?php echo $row['test_id'];?>"
                                                                value="<?php echo $row['comment'];?>"></center>
                                                    </td>
                                                </tr>
                                                <?php endforeach;?>
                                            </tbody>
                                        </table>
                                        <div class="form-buttons-w text-center">
                                            <button class="btn btn-success btn-rounded"
                                                type="submit"><?php echo getPhrase('update');?></button>
                                        </div>
                                        <?php echo form_close();?>
                                    </div>
                                    <?php form_close(); ?>
                                </div>                                
                            </article>
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
<?php endforeach;?>
