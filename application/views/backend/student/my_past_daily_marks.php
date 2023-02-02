<?php 
    $min              =   $this->crud->getInfo('minium_mark');
    $running_year     =   $this->crud->getInfo('running_year');
    $running_semester =   $this->crud->getInfo('running_semester'); 
    $roundPrecision   =   $this->crud->getInfo('round_precision');
    $quantityGrades   =   $this->crud->getInfo('quantity_grades');
    $useDailyMarks    =   $this->crud->getInfo('use_daily_marks');
?>
<div class="content-w">
    <div class="conty">
        <?php include 'fancy.php';?>
        <div class="header-spacer"></div>
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <ul class="navs navs-tabs">
                    <li class="navs-item">
                        <a class="navs-links" href="<?= base_url();?>student/my_marks/"><i
                                class="picons-thin-icon-thin-0658_cup_place_winner_award_prize_achievement"></i>
                            <span><?= getPhrase('current_marks');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links active" href="<?= base_url();?>student/my_past_marks/"><i
                                class="picons-thin-icon-thin-0658_cup_place_winner_award_prize_achievement"></i>
                            <span><?= getPhrase('past_marks');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?= base_url();?>student/placement_achievement/"><i
                                class="picons-thin-icon-thin-0658_cup_place_winner_award_prize_achievement"></i>
                            <span><?= getPhrase('placement_and_achievement');?></span></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="content-i">
            <div class="content-box">
                <div class="row">
                    <?php 
                    $student_enrollment = $this->db->query("SELECT class_id, class_name, section_id, section_name, year, semester_name FROM v_enroll 
                                                                WHERE student_id = '$student_id'
                                                                GROUP BY class_id, section_id 
                                                                ")->result_array();                   

                    foreach ($student_enrollment as $row1):
				    ?>
                    <div class="col-sm-12">
                        <div class="element-box lined-primary shadow">
                            <h5 class="form-header"><?= $row1['class_name'];?><br>
                                <small><?= $row1['year'].' - '.$row1['semester_name'].' - '.$row1['section_name'];?></small>
                            </h5>
                            <div class="table-responsive">
                                <table class="table table-lightborder">
                                    <thead>
                                        <tr>
                                            <th><?= getPhrase('class');?></th>
                                            <th><?= getPhrase('subject');?></th>
                                            <th><?= getPhrase('teacher');?></th>
                                            <th><?= getPhrase('attendance');?></th>
                                            <th><?= getPhrase('mark');?></th>
                                            <th><?= getPhrase('grade');?></th>
                                            <th><?= getPhrase('gpa');?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                			$subjects = $this->db->get_where('v_enrollment' , array('class_id' => $row1['class_id'], 'section_id' => $row1['section_id'], 'student_id' => $student_id))->result_array();

                            			    foreach ($subjects as $row3): 

                                                $class_id   = $row1['class_id'];
                                                $subject_id = $row3['subject_id'];
                                                $section_id = $row1['section_id'];
                                                $year       = $row3['year'];
                                                $semester   = $row3['semester_id'];

                                                $average = $this->db->query("SELECT ROUND((SUM(labuno)/COUNT(IF(labuno = '-' or labuno is null,null,'1'))), $roundPrecision) AS 'labuno',
                                                                                    ROUND((SUM(labdos)/COUNT(IF(labdos = '-' or labdos is null,null,'1'))), $roundPrecision) AS 'labdos',
                                                                                    ROUND((SUM(labtres)/COUNT(IF(labtres = '-' or labtres is null,null,'1'))), $roundPrecision) AS 'labtres',
                                                                                    ROUND((SUM(labcuatro)/COUNT(IF(labcuatro = '-' or labcuatro is null,null,'1'))), $roundPrecision) AS 'labcuatro',
                                                                                    ROUND((SUM(labcinco)/COUNT(IF(labcinco = '-' or labcinco is null,null,'1'))), $roundPrecision) AS 'labcinco',
                                                                                    ROUND((SUM(labseis)/COUNT(IF(labseis = '-' or labseis is null,null,'1'))), $roundPrecision) AS 'labseis',
                                                                                    ROUND((SUM(labsiete)/COUNT(IF(labsiete = '-' or labsiete is null,null,'1'))), $roundPrecision) AS 'labsiete',
                                                                                    ROUND((SUM(labocho)/COUNT(IF(labocho = '-' or labocho is null,null,'1'))), $roundPrecision) AS 'labocho',
                                                                                    ROUND((SUM(labnueve)/COUNT(IF(labnueve = '-' or labnueve is null,null,'1'))), $roundPrecision) AS 'labnueve',
                                                                                    ROUND((SUM(labdiez)/COUNT(IF(labdiez = '-' or labdiez is null,null,'1'))), $roundPrecision) AS 'labdiez'
                                                                                FROM mark_daily 
                                                                                WHERE student_id = '$student_id'
                                                                                AND class_id = '$class_id'
                                                                                AND section_id = '$section_id'
                                                                                AND subject_id = '$subject_id'
                                                                                AND year = '$year'
                                                                                AND semester_id = '$semester'
                                                                            ")->first_row();

                                                // Calculate the average 
                                                $count = 0;
                                                $Total_Sum = array_sum($average);

                                                $labouno        = $average->labuno;
                                                $labodos        = $average->labdos;
                                                $labotres       = $average->labtres;
                                                $labocuatro     = $average->labcuatro;
                                                $labocinco      = $average->labcinco;
                                                $laboseis       = $average->labseis;
                                                $labosiete      = $average->labsiete;
                                                $laboocho       = $average->labocho;
                                                $labonueve      = $average->labnueve;
                                                $labodiez       = $average->labdiez;

                                                // Validate values
                                                if($labouno     == '' ) { $labouno      = '-'; } 
                                                if($labodos     == '' ) { $labodos      = '-'; }  
                                                if($labotres    == '' ) { $labotres     = '-'; }  
                                                if($labocuatro  == '' ) { $labocuatro   = '-'; }  
                                                if($labocinco   == '' ) { $labocinco    = '-'; }
                                                if($laboseis    == '' ) { $laboseis     = '-'; } 
                                                if($labosiete   == '' ) { $labosiete    = '-'; }  
                                                if($laboocho    == '' ) { $laboocho     = '-'; }  
                                                if($labonueve   == '' ) { $labonueve    = '-'; }  
                                                if($labodiez    == '' ) { $labodiez     = '-'; }

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

                                                $labototal      = (float)$labodos + (float)$labotres + (float)$labocuatro + (float)$labocinco + (float)$laboseis + (float)$labosiete + (float)$laboocho + (float)$labonueve + (float)$labodiez;
                                                
                                                $mark = $count > 0 ? round(($labototal/$count), (int)$roundPrecision) : '-';

                                                $url_parameter = base64_encode($student_id.'-'.$class_id.'-'.$section_id.'-'.$year.'-'.$semester);

                                                $count_total++;
                                                $mark_total += $mark;
                                                $attendance_total += $labototal;
                                                
                            		    ?>
                                        <tr>
                                            <td>
                                                <?= $row3['class_name'];?>
                                            </td>
                                            <td>
                                                <?= $row3['subject_name'];?>
                                            </td>
                                            <td>
                                                <img alt=""
                                                    src="<?= $this->crud->get_image_url('teacher',$row3['teacher_id']);?>"
                                                    width="25px" style="border-radius: 10px;margin-right:5px;">
                                                <?= $row3['teacher_name']; ?>
                                            </td>
                                            <td>
                                                <?= $labouno;?>
                                            </td>
                                            <td>
                                                <?php if(($mark < $min || $mark == 0) && $mark != '-'):?>
                                                <a class="btn btn-rounded btn-sm btn-danger"
                                                    style="color:white"><?php if($mark == 0) echo '0'; else echo $mark;?></a>
                                                <?php endif;?>
                                                <?php if($mark >= $min):?>
                                                <a class="btn btn-rounded btn-sm btn-info"
                                                    style="color:white"><?= $mark;?></a>
                                                <?php endif;?>
                                            </td>
                                            <td>
                                                <?= $this->crud->get_grade($mark);?>
                                            </td>
                                            <td>
                                                <?= $this->crud->get_gpa($mark); ?>
                                            </td>
                                        </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                                <div class="form-buttons-w text-right">
                                    <a target="_blank"
                                        href="<?= base_url();?>student/past_marks_print_view/<?= $url_parameter;?>/">
                                        <button class="btn btn-rounded btn-success" type="submit"><i
                                                class="picons-thin-icon-thin-0333_printer"></i>
                                            <?= getPhrase('print');?>
                                        </button>
                                    </a>
                                    <?php 
                                    
                                    $mark_final = $count_total > 0 ? round(($mark_total/$count_total), (int)$roundPrecision) : '-';
                                    

                                    if($mark_final >= $min):?>
                                    <a target="_blank"
                                        href="<?= base_url();?>PrintDocument/student_certificate/<?= $url_parameter;?>/">
                                        <button class="btn btn-rounded btn-success" type="submit"><i
                                                class="picons-thin-icon-thin-0333_printer"></i>
                                            <?= getPhrase('print_certificate');?>
                                        </button>
                                    </a>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>