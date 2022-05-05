<?php 
    $running_year       = $this->crud->getInfo('running_year');
    $running_semester   = $this->crud->getInfo('running_semester');  
    $quantityGrades     = $this->crud->getInfo('quantity_grades');
    $useDailyMarks      = $this->crud->getInfo('use_daily_marks');
    $useGradeAttendance = $this->crud->getInfo('use_grade_attendance');

    $tmpQuantity = $quantityGrades;

    $info = base64_decode($data);
    $ex = explode('-', $info);

    $class_id   = $ex[0];
    $section_id = $ex[1];
    $subject_id = $ex[2];

    $date = date('Y-m-d');

    $grades[] = [1, 'lab_uno_', 'labuno'];
    $grades[] = [2, 'lab_dos_', 'labdos'];
    $grades[] = [3, 'lab_tres_', 'labtres'];
    $grades[] = [4, 'lab_cuatro_', 'labcuatro'];
    $grades[] = [5, 'lab_cinco_', 'labcinco'];
    $grades[] = [6, 'lab_seis_', 'labseis'];
    $grades[] = [7, 'lab_siete_', 'labsiete'];
    $grades[] = [8, 'lab_ocho_', 'labocho'];
    $grades[] = [9, 'lab_nueve_', 'labnueve'];
    $grades[] = [10, 'lab_diez_', 'labdiez'];

    
    $sub = $this->db->get_where('subject', array('subject_id' => $ex[2]))->result_array();
    foreach($sub as $subs):
?>
<div class="content-w">
    <div class="conty">
        <?php include 'fancy.php';?>
        <div class="header-spacer"></div>
        <div class="cursos cta-with-media" style="background: #<?php echo $subs['color'];?>;">
            <div class="cta-content">
                <div class="user-avatar">
                    <img alt="" src="<?php echo base_url();?>public/uploads/subject_icon/<?php echo $subs['icon'];?>"
                        style="width:60px;">
                </div>
                <h3 class="cta-header"><?php echo $subs['name'];?> - <small><?php echo getPhrase('marks');?></small>
                </h3>
                <small
                    style="font-size:0.90rem; color:#fff;"><?php echo $this->db->get_where('class', array('class_id' => $ex[0]))->row()->name;?>
                    "<?php echo $this->db->get_where('section', array('section_id' => $ex[1]))->row()->name;?>"
                </small>
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
                        <a class="navs-links"
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
                        <a class="navs-links active"
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
                                        <a class="h6 post__author-name fn"
                                            href="javascript:void(0);"><?php echo getPhrase('marks');?>
                                            <small>(<?php echo $this->db->get_where('v_class_units', array('class_id' => $class_id, 'unit_id' => $unit_id))->row()->unit_name;?>)</small>.</a>
                                    </div>
                                    <br />
                                    <div class="post__author author vcard inline-items">
                                        <span>Date: </span>
                                        <span><?= $date; ?></span>
                                    </div>
                                </div>
                                <div class="edu-posts cta-with-media">
                                    <div style="padding:0% 0%">
                                        <div id='cssmenu'>
                                            <ul>
                                                <?php  
                    				                $var = 0;
                    				                $examss = $this->db->get_where('v_class_units', array( 'class_id' => $class_id))->result_array();
                    				                foreach($examss as $exam):
                    				                $var++;
                    				            ?>
                                                <li class="<?php if($exam['unit_id'] == $unit_id) echo "act";?>"><a
                                                        href="<?php echo base_url();?>teacher/upload_marks/<?php echo $data.'/'.$exam['unit_id'];?>/"><i
                                                            class="os-icon picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i><?php echo $exam['unit_name'];?></a>
                                                </li>
                                                <?php endforeach;?>
                                            </ul>
                                        </div>
                                    </div>
                                    <?php echo form_open(base_url() . 'teacher/update_daily_marks/'.$unit_id.'/'.$ex[0].'/'.$ex[1].'/'.$ex[2].'/'.$date);?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr style="background:#f2f4f8;">
                                                    <th style="text-align: center;">
                                                        <?php echo getPhrase('student');?>
                                                    </th>
                                                    <?php 
                                                        $subjectLabel = $this->db->get_where('subject' , array('subject_id' => $ex[2]))->row();
                                                        for ($i=1; $i <= $quantityGrades; $i++):
                                                            $name = 'la'.$i;
                                                    ?>
                                                        <th style="text-align: center;">
                                                            <?php echo $subjectLabel->$name; ?>
                                                        </th>
                                                    <?php endfor; ?>
                                                    <th style="text-align: center;">
                                                        <?php echo getPhrase('comment');?>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                        $count = 1;
                                                        $students = $this->db->get_where('enroll' , array('class_id' => $class_id, 'section_id' => $section_id, 'subject_id' => $subject_id, 'year' => $running_year, 'semester_id' => $running_semester,))->result_array();
                                                        $students_list = "";
                                                        foreach ($students as $key => $value) {
                                                            $students_list .= $value['student_id'].', ';
                                                        }
    
                                                        $students_list = rtrim($students_list, ", ");

                                                        $marks_of_students = $this->db->query("SELECT * FROM v_mark_daily 
                                                                                            WHERE class_id = '$class_id'
                                                                                            AND section_id = '$section_id'
                                                                                            AND subject_id = '$subject_id'
                                                                                            AND unit_id = '$unit_id'
                                                                                            AND year = '$running_year'
                                                                                            AND semester_id = '$running_semester'
                                                                                            AND date = '$date'
                                                                                            AND student_id in ($students_list)
                                                                                            ORDER BY first_name asc
                                                                                        ")->result_array();
                                                        
                                                        foreach($marks_of_students as $row):
                                                    ?>
                                                <tr style="height:25px;">
                                                    <td style="min-width:190px">
                                                        <img alt=""
                                                            src="<?php echo $this->crud->get_image_url('student', $row['student_id']);?>"
                                                            width="25px" style="border-radius: 10px;margin-right:5px;">
                                                        <?php echo $this->crud->get_name('student', $row['student_id']);?>
                                                    </td>
                                                    <?php 
                                                        for ($i=0; $i < $quantityGrades; $i++):
                                                            $name = $grades[$i];
                                                    ?>
                                                    <td>
                                                        <center><input type="text"
                                                                name="<?php echo $name[1].$row['mark_daily_id'];?>"
                                                                placeholder="0"
                                                                maxlength="3"
                                                                style="width:65px; border: 1; text-align: center;"
                                                                value="<?php echo $row[$name[2]];?>"> </center>
                                                    </td>
                                                    <?php endfor; ?>
                                                    <td>
                                                        <center><input type="text" class="form-control"
                                                                name="comment_<?php echo $row['mark_daily_id'];?>"
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
                                </div>
                                <div class="control-block-button post-control-button">
                                    <a href="javascript:void(0);"
                                        onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_mark/<?php echo $ex[2];?>/<?php echo $ex[1];?>/');"
                                        class="btn btn-control featured-post"
                                        style="background-color: #99bf2d; color: #fff;" data-toggle="tooltip"
                                        data-placement="top"
                                        data-original-title="<?php echo getPhrase('update_activities');?>">
                                        <i class="picons-thin-icon-thin-0102_notebook_to_do_bullets_list"></i>
                                    </a>
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
<script>
    $(document).ready(function(){
		$("#update_daily_marks :input").attr("readonly", true);
    });
</script>
<?php endforeach;?>