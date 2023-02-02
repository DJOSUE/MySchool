<?php 
    $min                = $this->crud->getInfo('minium_mark');
    $running_year       = $this->crud->getInfo('running_year');
    $running_semester   = $this->crud->getInfo('running_semester'); 
    $useDailyMarks      = $this->crud->getInfo('use_daily_marks');
    $useGradeAttendance = $this->crud->getInfo('use_grade_attendance');
    $roundPrecision     = $this->crud->getInfo('round_precision');
    $quantityGrades     = $this->crud->getInfo('quantity_grades');

    $encode_data = $data;
    $decode_data = base64_decode($encode_data);
    $explode_data = explode("-", $decode_data);

    $class_id   = $explode_data[0];
    $section_id = $explode_data[1];
    $subject_id = $explode_data[2];
    
    $student_id = $this->session->userdata('login_user_id');
    $sub = $this->db->get_where('subject', array('subject_id' => $subject_id))->result_array();

    $grades[] = [1, 'labuno', 'la1'];
    $grades[] = [2, 'labdos', 'la2'];
    $grades[] = [3, 'labtres', 'la3'];
    $grades[] = [4, 'labcuatro', 'la4'];
    $grades[] = [5, 'labcinco', 'la5'];
    $grades[] = [6, 'labseis', 'la6'];
    $grades[] = [7, 'labsiete', 'la7'];
    $grades[] = [8, 'labocho', 'la8'];
    $grades[] = [9, 'labnueve', 'la9'];
    $grades[] = [10, 'labdiez', 'la10'];

    foreach($sub as $rows):
?>
<div class="content-w bg-white">
    <div class="conty">
        <?php $info = base64_decode($data);?>
        <?php $ids = explode("-",$info);?>
        <?php include 'fancy.php';?>
        <div class="header-spacer"></div>
        <div class="cursos cta-with-media" style="background: #<?php echo $rows['color'];?>;">
            <div class="cta-content">
                <div class="user-avatar">
                    <img alt="" src="<?php echo base_url();?>public/uploads/subject_icon/<?php echo $rows['icon'];?>"
                        style="width:60px;">
                </div>
                <h3 class="cta-header"><?php echo $rows['name'];?> - <small><?php echo getPhrase('marks');?></small>
                </h3>
                <small
                    style="font-size:0.90rem; color:#fff;"><?php echo $this->db->get_where('class', array('class_id' => $explode_data[0]))->row()->name;?>
                    "<?php echo $this->db->get_where('section', array('section_id' => $explode_data[1]))->row()->name;?>"</small>
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
                        <a class="navs-links" href="<?php echo base_url();?>student/homework/<?php echo $data;?>/"><i
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
                        <a class="navs-links active"
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
        <div class="content-i bg-white">
            <div class="content-box">
                <div class="row">
                    <main class="col col-xl-12 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
                        <?php echo form_open(base_url() . 'student/subject_daily_marks/'.$data, array('class' => 'form'));?>
                        <div class="from-control row">
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
                                    <input name="search_date" id="search_date" type="date" class="form-control"
                                        value="<?= $search_date;?>" max="<?php echo date('Y-m-d');?>">
                                </div>
                            </div>
                            <div class="col">
                                <button class="btn btn-success btn-upper"
                                    type="submit"><?php echo getPhrase('search');?>
                                </button>
                            </div>
                        </div>
                        <?php echo form_close();?>
                        <br />
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr style="background:#f2f4f8;">
                                            <th style="text-align: center;">
                                                <?php echo getPhrase('units');?>
                                            </th>
                                            <th style="text-align: center;">
                                                <?php echo getPhrase('date');?>
                                            </th>
                                            <?php 
                                                $subjectLabel = $this->db->get_where('subject' , array('subject_id' => $subject_id))->row();
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
                                        // Get marks
                                        if($unit_id != '' && $search_date != ''){
                                            $marks = $this->db->query("SELECT *
                                                                    FROM v_mark_daily 
                                                                    WHERE student_id = '$student_id'
                                                                        AND class_id = '$class_id'
                                                                        AND section_id = '$section_id'
                                                                        AND subject_id = '$subject_id'
                                                                        AND unit_id = '$unit_id'
                                                                        AND year = '$running_year'
                                                                        AND semester_id = '$running_semester'
                                                                        AND date = '$search_date'
                                                                        ")->result_array();
                                        }
                                        else if($unit_id != '' && $search_date == '') {
                                            $marks = $this->db->query("SELECT *
                                                                    FROM v_mark_daily 
                                                                    WHERE student_id = '$student_id'
                                                                        AND class_id = '$class_id'
                                                                        AND section_id = '$section_id'
                                                                        AND subject_id = '$subject_id'
                                                                        AND unit_id = '$unit_id'
                                                                        AND year = '$running_year'
                                                                        AND semester_id = '$running_semester'
                                                                        ")->result_array();
                                        }
                                        else if($unit_id == '' && $search_date != '') {
                                            $marks = $this->db->query("SELECT *
                                                                    FROM v_mark_daily 
                                                                    WHERE student_id = '$student_id'
                                                                        AND class_id = '$class_id'
                                                                        AND section_id = '$section_id'
                                                                        AND subject_id = '$subject_id'
                                                                        AND date = '$search_date'
                                                                        AND year = '$running_year'
                                                                        AND semester_id = '$running_semester'
                                                                        ")->result_array();
                                        }
                                        else
                                        {
                                            $marks = $this->db->query("SELECT *
                                                                    FROM v_mark_daily 
                                                                    WHERE student_id = '$student_id'
                                                                        AND class_id = '$class_id'
                                                                        AND section_id = '$section_id'
                                                                        AND subject_id = '$subject_id'                                                                        
                                                                        AND year = '$running_year'
                                                                        AND semester_id = '$running_semester'
                                                                        ")->result_array();
                                        }
                                        
                                        foreach($marks as $row):
                                        ?>
                                        <tr style="height:25px;">
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
                                                    <span name="<?php echo $name[1]."_".$row['mark_daily_id'];?>">
                                                        <?= $row[$name[1]];?>
                                                    </span>
                                                </center>
                                            </td>
                                            <?php endfor; ?>
                                            <td>
                                                <center>
                                                    <span name="comment_<?php echo $row['mark_daily_id'];?>">
                                                        <?php echo $row['comment'];?>
                                                    </span>
                                                </center>
                                            </td>

                                        </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach;?>