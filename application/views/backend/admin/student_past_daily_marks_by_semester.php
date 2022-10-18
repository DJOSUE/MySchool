<?php 
    $min                = $this->crud->getInfo('minium_mark');

    $running_year       = $this->crud->getInfo('running_year');
    $running_semester   = $this->crud->getInfo('running_semester');

    $roundPrecision   =   $this->crud->getInfo('round_precision');

    $student_info = $this->db->get_where('student' , array('student_id' => $student_id))->result_array(); 
    foreach($student_info as $row):    
?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="content-i">
        <div class="content-box">
            <div class="conty">
                <div class="back" style="margin-top:-20px;margin-bottom:10px">
                    <a title="<?php echo getPhrase('return');?>" href="<?php echo base_url();?>admin/students/"><i
                            class="picons-thin-icon-thin-0131_arrow_back_undo"></i></a>
                </div>
                <div class="row">
                    <main class="col col-xl-9 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
                        <div id="newsfeed-items-grid">
                            <div class="ui-block paddingtel">
                                <div class="user-profile">
                                    <?php include 'student_area_header.php';?>
                                </div>
                            </div>
                            <div class="row">
                                <?php 
                                    $enrollments = $this->db->query("SELECT class_id, class_name, section_id, section_name, year, semester_id, semester_name FROM v_enroll 
                                                                            WHERE student_id = '$student_id'
                                                                            GROUP BY class_id, section_id 
                                                                            ")->result_array();

                                    
                                    foreach ($enrollments as $enroll):
                                        $class_id = $enroll['class_id'];
                                        $section_id = $enroll['section_id'];
                                        $year = $enroll['year'];
                                        $semester_id = $enroll['semester_id'];
                                ?>
                                <div class="col-sm-12">
                                    <div class="element-box lined-primary">
                                        <h5 class="form-header"><?= $enroll['class_name'];?><br>
                                            <small><?= $enroll['year'].' - '.$enroll['semester_name'].' - '.$enroll['section_name'];?></small>
                                        </h5>
                                        <div class="table-responsive">
                                            <table class="table table-lightborder">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo getPhrase('subject');?></th>
                                                        <th><?php echo getPhrase('teacher');?></th>
                                                        <th class="text-center"><?php echo getPhrase('attendance');?>
                                                        </th>
                                                        <th class="text-center"><?php echo getPhrase('mark');?></th>
                                                        <th class="text-center"><?php echo getPhrase('grade');?></th>
                                                        <th class="text-center"><?php echo getPhrase('gpa');?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        $enrollment = $this->db->get_where('v_enrollment' , array('student_id' => $student_id, 'class_id' => $class_id, 'section_id' => $section_id, 'year' => $year, 'semester_id' => $semester_id))->result_array();                                                        
                                                        
                                                        $labouno_total = 0;
                                                        $count_total   = 0; 
                                                        $mark_total    = 0;
                                                        foreach ($enrollment as $row3): 
                                                            $subject_id = $row3['subject_id'];                                                            

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
                                                                                                AND semester_id = '$semester_id'
                                                                                            ")->first_row();

                                                            // Calculate the average 
                                                            $count = 0;

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

                                                            // if(is_numeric($average->labuno)     && $average->labuno != '' ) { $count++; } 
                                                            if(is_numeric($average->labdos)     && $average->labdos != '' ) { $count++; }  
                                                            if(is_numeric($average->labtres)    && $average->labtres != '' ) { $count++; }  
                                                            if(is_numeric($average->labcuatro)  && $average->labcuatro != '' ) { $count++; }  
                                                            if(is_numeric($average->labcinco)   && $average->labcinco != '') { $count++; }
                                                            if(is_numeric($average->labseis)    && $average->labseis != '' ) { $count++; } 
                                                            if(is_numeric($average->labsiete)   && $average->labsiete != '' ) { $count++; }  
                                                            if(is_numeric($average->labocho)    && $average->labocho != '' ) { $count++; }  
                                                            if(is_numeric($average->labnueve)   && $average->labnueve != '' ) { $count++; }  
                                                            if(is_numeric($average->labdiez)    && $average->labdiez != '' ) { $count++; }                                                            
                                                            
                                                            $labototal      = (float)$labodos + (float)$labotres + (float)$labocuatro + (float)$labocinco + (float)$laboseis + (float)$labosiete + (float)$laboocho + (float)$labonueve + (float)$labodiez;
                                            
                                                            $mark = $count > 0 ? round(($labototal/$count), (int)$roundPrecision) : '-';

                                                            if($mark != '-'){
                                                                $mark_total += $mark;
                                                                $count_total++; 
                                                            }
                
                                                            if($labouno != '-'){
                                                                $labouno_total += $labouno;
                                                            }
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?= $row3['subject_name'];?>
                                                        </td>
                                                        <td>
                                                            <?= $row3['teacher_name'];?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php if(is_numeric($labouno) && ($labouno < $min || $labouno == 0)):?>
                                                            <a class="btn btn-rounded btn-sm btn-danger"
                                                                style="color:white"><?php if($labouno == 0) echo '0'; else echo $labouno;?></a>
                                                            <?php endif;?>
                                                            <?php if(is_numeric($labouno) && ($labouno >= $min)):?>
                                                            <a class="btn btn-rounded btn-sm btn-info"
                                                                style="color:white"><?php echo $labouno;?></a>
                                                            <?php endif;?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php if(is_numeric($mark) && ($mark < $min || $mark == 0)):?>
                                                            <a class="btn btn-rounded btn-sm btn-danger"
                                                                style="color:white"><?php if($mark == 0) echo '0'; else echo $mark;?></a>
                                                            <?php endif;?>
                                                            <?php if(is_numeric($mark) && ($mark >= $min)):?>
                                                            <a class="btn btn-rounded btn-sm btn-info"
                                                                style="color:white"><?php echo $mark;?></a>
                                                            <?php endif;?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?= $grade = $this->crud->get_grade($mark);?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?= $grade = $this->crud->get_gpa($mark);?>
                                                        </td>
                                                    </tr>
                                                    <?php  endforeach; 
                                                        $final_mark = ($count_total > 0 ? round(($mark_total/$count_total), (int)$roundPrecision) : '-');
                                                        $final_attendance = ($count_total > 0 ? round(($labouno_total/$count_total), (int)$roundPrecision) : '-');

                                                        //$final_gpa = 
                                                    ?>
                                                    <tr>
                                                        <th colspan="2" class="text-right">
                                                            <b><?= getPhrase('average');?></b>
                                                        </th>
                                                        <th class="text-center">
                                                            <?php if(is_numeric($final_attendance) && ($final_attendance < $min || $final_attendance == 0)):?>
                                                            <a class="btn btn-rounded btn-sm btn-danger"
                                                                style="color:white"><?php if($final_attendance == 0) echo '0'; else echo $final_attendance;?></a>
                                                            <?php endif;?>
                                                            <?php if(is_numeric($final_attendance) && ($final_attendance >= $min)):?>
                                                            <a class="btn btn-rounded btn-sm btn-info"
                                                                style="color:white"><?php echo $final_attendance;?></a>
                                                            <?php endif;?>
                                                        </th>
                                                        <th class="text-center">
                                                            <?php if(is_numeric($final_mark) && ($final_mark < $min || $final_mark == 0)):?>
                                                            <a class="btn btn-rounded btn-sm btn-danger"
                                                                style="color:white"><?php if($final_mark == 0) echo '0'; else echo $final_mark;?></a>
                                                            <?php endif;?>
                                                            <?php if(is_numeric($final_mark) && ($final_mark >= $min)):?>
                                                            <a class="btn btn-rounded btn-sm btn-info"
                                                                style="color:white"><?php echo $final_mark;?></a>
                                                            <?php endif;?>
                                                        </th>
                                                        <th class="text-center">
                                                            <?= $grade = $this->crud->get_grade($final_mark);?>
                                                        </th>
                                                        <th class="text-center">
                                                            <?= $grade = $this->crud->get_gpa($final_mark);?>
                                                        </th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="form-buttons-w text-right">
                                                <a target="_blank"
                                                    href="<?php echo base_url();?>admin/student_print_marks_past_cea/<?php echo base64_encode($student_id.'-'.$class_id.'-'.$section_id.'-'.$year.'-'.$semester_id);?>"><button
                                                        class="btn btn-rounded btn-success" type="submit">
                                                        <i class="picons-thin-icon-thin-0333_printer"></i>
                                                        <?php echo getPhrase('print_CEA');?></button>
                                                </a>
                                                <a target="_blank"
                                                    href="<?php echo base_url();?>admin/student_print_marks_past/<?php echo base64_encode($student_id.'-'.$class_id.'-'.$section_id.'-'.$year.'-'.$semester_id);?>"><button
                                                        class="btn btn-rounded btn-success" type="submit">
                                                        <i class="picons-thin-icon-thin-0333_printer"></i>
                                                        <?php echo getPhrase('print');?></button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </main>
                    <?php include 'student_area_menu.php';?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach;?>