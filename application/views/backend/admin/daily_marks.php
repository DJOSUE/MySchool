<?php 
    $running_year       = $this->crud->getInfo('running_year');
    $running_semester   = $this->crud->getInfo('running_semester'); 
    $roundPrecision    = $this->crud->getInfo('round_precision');
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
                        <a class="navs-links active"
                            href="<?php echo base_url();?>admin/daily_marks/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i><span><?php echo getPhrase('marks');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links"
                            href="<?php echo base_url();?>admin/subject_daily_marks_average/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0197_layout_grid_view"></i><span><?php echo getPhrase('daily_marks_average');?></span></a>
                    </li>
                    <?php else: ?>
                    <li class="navs-item">
                        <a class="navs-links"
                            href="<?php echo base_url();?>admin/upload_marks/<?php echo $data;?>/"><i
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
                        <div class="ui-block">
                            <article class="hentry post thumb-full-width">
                                <div class="post__author author vcard inline-items">
                                    <img src="<?php echo base_url();?>public/uploads/<?php echo $this->crud->getInfo('logo');?>"
                                        style="border-radius:0px">
                                    <div class="author-date">
                                        <a class="h6 post__author-name fn"
                                            href="javascript:void(0);"><?php echo getPhrase('daily_marks');?>
                                            <small>(<?php echo $this->db->get_where('units', array('unit_id' => $unit_id))->row()->name;?>)</small>.</a>
                                    </div>
                                </div>
                                <div>
                                    <?php echo form_open(base_url() . 'admin/daily_marks/'.$data, array('class' => 'form'));?>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?php echo getPhrase('student');?></label>
                                                <div class="select">
                                                    <select name="student_id" id="student_id">
                                                        <option value=""><?php echo getPhrase('select');?></option>
                                                        <?php 
                                                            $students = $this->db->query("SELECT student_id, full_name FROM v_enroll 
                                                                                    WHERE class_id = '$class_id'
                                                                                    AND section_id = '$section_id'
                                                                                    AND subject_id = '$subject_id'
                                                                                    AND year = '$running_year'
                                                                                    AND semester_id = '$running_semester'                                                                                      
                                                                                    GROUP BY student_id
                                                                                    ORDER BY full_name
                                                                                    "
                                                                                )->result_array();    

                                                            $students_list = "";

                                                            foreach($students as $row):
                                                                $students_list .= $row['student_id'].", ";
                                                        ?>
                                                        <option value="<?php echo $row['student_id'];?>"
                                                            <?php if($student_id == $row['student_id']) echo "selected"; ?>>
                                                            <?php echo $row['full_name'];?>
                                                        </option>
                                                        <?php endforeach;
                                                            $students_list = rtrim($students_list, ", ");
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?php echo getPhrase('units');?></label>
                                                <div class="select">
                                                    <select name="unit_id" id="unit_id">
                                                        <option value=""><?php echo getPhrase('select');?></option>
                                                        <?php 
                                                            $exams = $this->crud->get_exam_by_class($class_id);
                                                            foreach($exams as $row):
                                                        ?>
                                                        <option value="<?php echo $row['unit_id'];?>"
                                                            <?php if($unit_id == $row['unit_id']) echo "selected"; ?>>
                                                            <?php echo $row['unit_name'];?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?php echo getPhrase('date');?></label>
                                                <input name="mark_date" id="mark_date" type="date" class="form-control"
                                                    value="<?php 
                                                    if(!$mark_date)
                                                        echo "";
                                                    else
                                                        echo $mark_date;
                                                    ?>" max="<?php echo date('Y-m-d');?>">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <button class="btn btn-success btn-upper"
                                                type="submit"><?php echo getPhrase('search');?>
                                            </button>
                                        </div>
                                    </div>
                                    <?php echo form_close();?>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr style="background:#f2f4f8;">
                                                <th style="text-align: center;">
                                                    <?php echo getPhrase('student');?>
                                                </th>
                                                <th style="text-align: center;">
                                                    <?php echo getPhrase('units');?>
                                                </th>
                                                <th style="text-align: center;">
                                                    <?php echo getPhrase('date');?>
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
                                                        
                                                        // Get marks
                                                        if($student_id != '' && $unit_id != '' && $mark_date != ''){
                                                            $marks = $this->db->query("SELECT *
                                                                                    FROM v_mark_daily 
                                                                                    WHERE class_id = '$class_id'
                                                                                        AND section_id = '$section_id'
                                                                                        AND subject_id = '$subject_id'
                                                                                        AND unit_id = '$unit_id'
                                                                                        AND year = '$running_year'
                                                                                        AND semester_id = '$running_semester'
                                                                                        AND date = '$mark_date'
                                                                                        AND student_id = '$student_id'
                                                                                        ORDER BY first_name asc
                                                                                        ")->result_array();
                                                        }
                                                        else if($student_id != '' && $unit_id != '' && $mark_date == '') {
                                                            $marks = $this->db->query("SELECT *
                                                                                    FROM v_mark_daily 
                                                                                    WHERE student_id = '$student_id'
                                                                                        AND class_id = '$ex[0]'
                                                                                        AND section_id = '$ex[1]'
                                                                                        AND subject_id = '$ex[2]'
                                                                                        AND unit_id = '$unit_id'
                                                                                        AND year = '$running_year'
                                                                                        AND semester_id = '$running_semester'
                                                                                    ORDER BY date, first_name asc
                                                                                        ")->result_array();
                                                        }
                                                        else if($student_id != '' && $unit_id == '' && $mark_date != '') {
                                                            $marks = $this->db->query("SELECT *
                                                                                    FROM v_mark_daily 
                                                                                    WHERE student_id = '$student_id'
                                                                                        AND class_id = '$ex[0]'
                                                                                        AND section_id = '$ex[1]'
                                                                                        AND subject_id = '$ex[2]'
                                                                                        AND date = '$mark_date'
                                                                                        AND year = '$running_year'
                                                                                        AND semester_id = '$running_semester'
                                                                                    ORDER BY date, first_name asc
                                                                                        ")->result_array();
                                                        }
                                                        else if($student_id != '' && $unit_id == '' && $mark_date == '') {
                                                            $marks = $this->db->query("SELECT *
                                                                                    FROM v_mark_daily 
                                                                                    WHERE student_id = '$student_id'
                                                                                        AND class_id = '$ex[0]'
                                                                                        AND section_id = '$ex[1]'
                                                                                        AND subject_id = '$ex[2]'
                                                                                        AND year = '$running_year'
                                                                                        AND semester_id = '$running_semester'
                                                                                    ORDER BY date, first_name asc
                                                                                        ")->result_array();
                                                        }
                                                        else if($student_id == '' && $unit_id != '' && $mark_date == ''){
                                                            $marks = $this->db->query("SELECT *
                                                                                    FROM v_mark_daily 
                                                                                    WHERE class_id = '$ex[0]'
                                                                                        AND section_id = '$ex[1]'
                                                                                        AND subject_id = '$ex[2]'
                                                                                        AND unit_id = '$unit_id'
                                                                                        AND student_id in ($students_list)
                                                                                        AND year = '$running_year'
                                                                                        AND semester_id = '$running_semester'
                                                                                    ORDER BY date, first_name asc
                                                                                        ")->result_array();
                                                        }
                                                        else if($student_id == '' && $unit_id != '' && $mark_date != ''){
                                                            $marks = $this->db->query("SELECT *
                                                                                    FROM v_mark_daily 
                                                                                    WHERE class_id = '$ex[0]'
                                                                                        AND section_id = '$ex[1]'
                                                                                        AND subject_id = '$ex[2]'
                                                                                        AND unit_id = '$unit_id'
                                                                                        AND student_id in ($students_list)
                                                                                        AND date = '$mark_date'
                                                                                        AND year = '$running_year'
                                                                                        AND semester_id = '$running_semester'
                                                                                    ORDER BY date, first_name asc
                                                                                        ")->result_array();
                                                        }
                                                        else if($student_id == '' && $unit_id == '' && $mark_date != ''){
                                                            $marks = $this->db->query("SELECT *
                                                                                    FROM v_mark_daily 
                                                                                    WHERE class_id = '$ex[0]'
                                                                                        AND section_id = '$ex[1]'
                                                                                        AND subject_id = '$ex[2]'
                                                                                        AND student_id in ($students_list)
                                                                                        AND date = '$mark_date'
                                                                                        AND year = '$running_year'
                                                                                        AND semester_id = '$running_semester'
                                                                                    ORDER BY date, first_name asc
                                                                                        ")->result_array();
                                                        }
                                                        else {
                                                            $marks = $this->db->query("SELECT *
                                                                                    FROM v_mark_daily 
                                                                                    WHERE class_id = '$ex[0]'
                                                                                        AND section_id = '$ex[1]'
                                                                                        AND subject_id = '$ex[2]'
                                                                                        AND student_id in ($students_list)
                                                                                        AND year = '$running_year'
                                                                                        AND semester_id = '$running_semester'
                                                                                    ORDER BY date, first_name asc
                                                                                        ")->result_array();
                                                        }
                                                        
                                                        foreach($marks as $row):
                                                    ?>
                                            <tr style="height:25px;">
                                                <td style="min-width:190px">
                                                    <img alt=""
                                                        src="<?php echo $this->crud->get_image_url('student', $row['student_id']);?>"
                                                        width="25px" style="border-radius: 10px;margin-right:5px;">
                                                    <?php echo $this->crud->get_name('student', $row['student_id']);?>
                                                </td>
                                                <td>
                                                    <center>
                                                        <label name="unit_id_<?php echo $item['mark_id'];?>"
                                                            style="width:55px; border: 1; text-align: center;">
                                                            <?php echo ($row['unit_name']);?>
                                                        </label>
                                                    </center>
                                                </td>
                                                <td>
                                                    <center>
                                                        <label name="unit_id_<?php echo $item['mark_id'];?>"
                                                            style="width:55px; border: 1; text-align: center;">
                                                            <?php echo ($row['date']);?>
                                                        </label>
                                                    </center>
                                                </td>
                                                <?php 
                                                        for ($i=0; $i < $quantityGrades; $i++):
                                                            $name = $grades[$i];
                                                    ?>
                                                <td>
                                                    <center>
                                                        <input type="text"
                                                            id="<?php echo $name[1].$row['mark_daily_id'];?>"
                                                            name="<?php echo $name[1].$row['mark_daily_id'];?>"
                                                            style="width:65px; border: 1; text-align: center;"
                                                            value="<?php echo $row[$name[2]];?>" type="text"
                                                            maxlength="3" readonly />
                                                    </center>
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