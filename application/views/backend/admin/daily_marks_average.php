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
                        <a class="navs-links"
                            href="<?php echo base_url();?>admin/daily_marks/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i><span><?php echo getPhrase('marks');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links active"
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
                                            href="javascript:void(0);"><?php echo getPhrase('upload_marks');?>
                                            <small>(<?php echo $this->db->get_where('units', array('unit_id' => $unit_id))->row()->name;?>)</small>.</a>
                                    </div>
                                </div>
                                <div class="edu-posts cta-with-media">
                                    <div style="padding:0% 0%">
                                        <div id='cssmenu'>
                                            <ul>
                                                <?php  
                                                    $var = 0;
                                                    $exams = $this->crud->get_exam_by_class($class_id);
                                                    foreach($exams as $exam):
                                                    $var++;
                                                ?>
                                                <li class='<?php if($exam['unit_id'] == $unit_id) echo "act";?>'><a
                                                        href="<?php echo base_url();?>admin/subject_daily_marks_average/<?php echo $data.'/'.$exam['unit_id'];?>/"><i
                                                            class="os-icon picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i><?php echo $exam['unit_name'];?></a>
                                                </li>
                                                <?php endforeach;?>
                                                <li class='<?php if(0 == $unit_id) echo "act";?>'>
                                                <a href="<?php echo base_url();?>admin/subject_daily_marks_average/<?php echo $data?>/0/"><i
                                                            class="os-icon picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i><?php echo getPhrase('average')?></a> 
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <?php echo form_open(base_url() . 'admin/marks_update/'.$unit_id.'/'.$ex[0].'/'.$ex[1].'/'.$ex[2]);?>
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
                                                        <?php echo getPhrase('average');?>
                                                        
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                        $count = 1;
                                                        
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
                                                        
                                                        foreach($students as $row):
                                                            
                                                            // Get average
                                                            if($unit_id == 0){
                                                                $average = $this->db->query("SELECT ROUND((SUM(labuno)/COUNT(IF(labuno = '-' or labuno IS NULL,null,'1'))), $roundPrecision) AS 'labuno',
                                                                                                    ROUND((SUM(labdos)/COUNT(IF(labdos = '-' or labdos IS NULL,null,'1'))), $roundPrecision) AS 'labdos',
                                                                                                    ROUND((SUM(labtres)/COUNT(IF(labtres = '-' or labtres IS NULL,null,'1'))), $roundPrecision) AS 'labtres',
                                                                                                    ROUND((SUM(labcuatro)/COUNT(IF(labcuatro = '-' or labcuatro IS NULL,null,'1'))), $roundPrecision) AS 'labcuatro',
                                                                                                    ROUND((SUM(labcinco)/COUNT(IF(labcinco = '-' or labcinco IS NULL,null,'1'))), $roundPrecision) AS 'labcinco',
                                                                                                    ROUND((SUM(labseis)/COUNT(IF(labseis = '-' or labseis IS NULL,null,'1'))), $roundPrecision) AS 'labseis',
                                                                                                    ROUND((SUM(labsiete)/COUNT(IF(labsiete = '-' or labsiete IS NULL,null,'1'))), $roundPrecision) AS 'labsiete',
                                                                                                    ROUND((SUM(labocho)/COUNT(IF(labocho = '-' or labocho IS NULL,null,'1'))), $roundPrecision) AS 'labocho',
                                                                                                    ROUND((SUM(labnueve)/COUNT(IF(labnueve = '-' or labnueve IS NULL,null,'1'))), $roundPrecision) AS 'labnueve',
                                                                                                    ROUND((SUM(labdiez)/COUNT(IF(labdiez = '-' or labdiez IS NULL,null,'1'))), $roundPrecision) AS 'labdiez'
                                                                                            FROM mark_daily 
                                                                                            WHERE student_id = '$row[student_id]'
                                                                                                AND class_id = '$class_id'
                                                                                                AND section_id = '$section_id'
                                                                                                AND subject_id = '$subject_id'
                                                                                                AND year = '$running_year'
                                                                                                AND semester_id = '$running_semester' 
                                                                                                ")->result_array();
                                                            } else { 
                                                                $average = $this->db->query("SELECT ROUND((SUM(labuno)/COUNT(IF(labuno = '-' or labuno IS NULL,null,'1'))), $roundPrecision) AS 'labuno',
                                                                                                    ROUND((SUM(labdos)/COUNT(IF(labdos = '-' or labdos IS NULL,null,'1'))), $roundPrecision) AS 'labdos',
                                                                                                    ROUND((SUM(labtres)/COUNT(IF(labtres = '-' or labtres IS NULL,null,'1'))), $roundPrecision) AS 'labtres',
                                                                                                    ROUND((SUM(labcuatro)/COUNT(IF(labcuatro = '-' or labcuatro IS NULL,null,'1'))), $roundPrecision) AS 'labcuatro',
                                                                                                    ROUND((SUM(labcinco)/COUNT(IF(labcinco = '-' or labcinco IS NULL,null,'1'))), $roundPrecision) AS 'labcinco',
                                                                                                    ROUND((SUM(labseis)/COUNT(IF(labseis = '-' or labseis IS NULL,null,'1'))), $roundPrecision) AS 'labseis',
                                                                                                    ROUND((SUM(labsiete)/COUNT(IF(labsiete = '-' or labsiete IS NULL,null,'1'))), $roundPrecision) AS 'labsiete',
                                                                                                    ROUND((SUM(labocho)/COUNT(IF(labocho = '-' or labocho IS NULL,null,'1'))), $roundPrecision) AS 'labocho',
                                                                                                    ROUND((SUM(labnueve)/COUNT(IF(labnueve = '-' or labnueve IS NULL,null,'1'))), $roundPrecision) AS 'labnueve',
                                                                                                    ROUND((SUM(labdiez)/COUNT(IF(labdiez = '-' or labdiez IS NULL,null,'1'))), $roundPrecision) AS 'labdiez'
                                                                                            FROM mark_daily 
                                                                                            WHERE student_id = '$row[student_id]'
                                                                                                AND class_id = '$class_id'
                                                                                                AND section_id = '$section_id'
                                                                                                AND subject_id = '$subject_id'
                                                                                                AND unit_id = '$unit_id'
                                                                                                AND year = '$running_year'
                                                                                                AND semester_id = '$running_semester' 
                                                                                                ")->result_array();
                                                            }
                                                            
                                                            // Math to get Average
                                                            $Total_Sum = array_sum($average[0]) - $average[0][labuno];
                                                            $count = 0;
                                                            
                                                            $labouno        = $average[0][labuno];
                                                            $labodos        = $average[0][labdos];
                                                            $labotres       = $average[0][labtres];
                                                            $labocuatro     = $average[0][labcuatro];
                                                            $labocinco      = $average[0][labcinco];
                                                            $laboseis       = $average[0][labseis];
                                                            $labosiete      = $average[0][labsiete];
                                                            $laboocho       = $average[0][labocho];
                                                            $labonueve      = $average[0][labnueve];
                                                            $labodiez       = $average[0][labdiez];
                                                
                                                            // Calculate the average 
                                                            // if(is_numeric($labouno)     && $labouno != '-' ) { $count++; } 
                                                            if(is_numeric($labodos)     && $labodos != '-' ) { $count++; }  
                                                            if(is_numeric($labotres)    && $labotres != '-' ) { $count++; }  
                                                            if(is_numeric($labocuatro)  && $labocuatro != '-' ) { $count++; }  
                                                            if(is_numeric($labocinco)   && $labocinco != '-') { $count++; }
                                                            if(is_numeric($laboseis)    && $laboseis != '-' ) { $count++; } 
                                                            if(is_numeric($labosiete)   && $labosiete != '-' ) { $count++; }  
                                                            if(is_numeric($laboocho)    && $laboocho != '-' ) { $count++; }  
                                                            if(is_numeric($labonueve)   && $labonueve != '-' ) { $count++; }  
                                                            if(is_numeric($labodiez)    && $labodiez != '-') { $count++; }

                                                            if($Total_Sum > 0)
                                                                $mark =  round(($Total_Sum/$count),$roundPrecision);
                                                            else
                                                                $mark = "-";
                                                            
                                                            $tmpQuantity = $quantityGrades;
                                                            
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
                                                        <center><label
                                                                name="<?php echo $name[1].$row['mark_daily_id'];?>"
                                                                style="width:55px; border: 1; text-align: center;">
                                                                <?php echo $average[0][$name[2]];?></label> </center>
                                                    </td>
                                                    <?php endfor; ?>
                                                    <td>
                                                        <center>
                                                            <?php if(($mark < $min || $mark == 0) && $mark != '-'):?>
                                                            <a class="btn btn-rounded btn-sm btn-danger"
                                                                style="color:white"><?php if($mark == '' ) echo '0'; else echo $mark;?></a>
                                                            <?php endif;?>
                                                            <?php if($mark >= $min):?>
                                                            <a class="btn btn-rounded btn-sm btn-info"
                                                                style="color:white"><?php echo $mark;?></a>
                                                            <?php endif;?>
                                                        </center>
                                                    </td>
                                                </tr>
                                                <?php endforeach;?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="control-block-button post-control-button">
                                    <a href="javascript:void(0);"
                                        onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_mark/<?php echo $ex[2];?>/<?php echo $ex[1];?>');"
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
<?php endforeach;?>