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
<div class="content-w">
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
                        <a class="navs-links active"
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
                        <a class="navs-links active"
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
                        <a class="navs-links" href="<?php echo base_url();?>student/meet/<?php echo $data;?>/"><i
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
                            <div style="padding:0% 0%">
                                <div id='cssmenu'>
                                    <ul>
                                        <?php  
                                            $var = 0;
                                            $examss = $this->db->get_where('v_class_units', array('class_id' => $class_id))->result_array();
                                            foreach($examss as $exam):
                                            $var++;
                                        ?>
                                        <li class='<?php if($exam['unit_id'] == $unit_id) echo "act";?>'><a
                                                href="<?php echo base_url();?>student/subject_marks/<?php echo $data.'/'.$exam['unit_id'];?>/"><i
                                                    class="os-icon picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i><?= $exam['unit_name'];?></a>
                                        </li>
                                        <?php endforeach;?>
                                    </ul>
                                </div>
                            </div>
                            <div class="element-wrapper bg-white">
                                <div class="element-box-tp">
                                    <div class="table-responsive">
                                        <table class="table table-lightborder">
                                            <thead>
                                                <tr style="background-color: #e1e8ed; color:#000;">
                                                    <th class="text-center">#</th>
                                                    <th class="text-center"><?php echo getPhrase('activity');?></th>
                                                    <th class="text-center"><?php echo getPhrase('mark');?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // var_dump($sub);

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
                                                                            WHERE student_id = '$student_id'
                                                                                AND class_id = '$class_id'
                                                                                AND section_id = '$section_id'
                                                                                AND subject_id = '$subject_id'
                                                                                AND unit_id = '$unit_id'
                                                                                AND year = '$running_year'
                                                                                AND semester_id = '$running_semester' 
                                                                                ")->result_array();
                                                // Math to get Average
                                                $Total_Sum = array_sum($average[0]);
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
                                                if(is_numeric($labouno)     && $labouno != '-' ) { $count++; } 
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

                                                for ($i=0; $i < $quantityGrades; $i++):
                                                    $name = $grades[$i];
                                                ?>
                                                <tr class="text-center">
                                                    <td>
                                                        <?= $grades[$i][0];?>
                                                    </td>
                                                    <td>
                                                        <?= $sub[0][$name[2]];?>
                                                    </td>
                                                    <td>
                                                        <?php echo $average[0][$name[1]];?></label>
                                                    </td>
                                                </tr>
                                                <?php endfor;?>
                                                <tr style="border-top: solid #a5a5a5;" class="text-center">
                                                    <td>-</td>
                                                    <td><?php echo getPhrase('total');?></td>
                                                    <td>
                                                        <?php if($mark < $min || $mark == ""):?>
                                                        <a class="btn btn-rounded btn-sm btn-danger"
                                                            style="color:white"><?php if($mark == "") echo '0'; else echo $mark;?></a>
                                                        <?php endif;?>
                                                        <?php if($mark >= $min):?>
                                                        <a class="btn btn-rounded btn-sm btn-success"
                                                            style="color:white"><?php echo $mark;?></a>
                                                        <?php endif;?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <a class="btn btn-sm btn-success text-white" style="margin-left:10px;"
                                        href="<?php echo base_url();?>student/my_marks/"><?php echo getPhrase('view_all_marks');?></a><br><br>
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