<?php 
    $min                = $this->crud->getInfo('minium_mark');
    $running_year       = $this->crud->getInfo('running_year');
    $running_semester   = $this->crud->getInfo('running_semester');
    $roundPrecision   =   $this->crud->getInfo('round_precision');

    $student_info = $this->db->get_where('student' , array('student_id' => $student_id))->result_array(); 
    foreach($student_info as $row):
        $class_id = $this->db->get_where('enroll', array('student_id' => $student_id, 'year' => $running_year, 'semester_id' => $running_semester))->row()->class_id;
        $section_id = $this->db->get_where('enroll', array('student_id' => $student_id, 'year' => $running_year, 'semester_id' => $running_semester))->row()->section_id;
        $status_info = $this->studentModel->get_status_info($row['student_session']);
        $program_info = $this->studentModel->get_program_info($row['program_id']);
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
                                    $student_info = $this->crud->get_student_info($student_id);
                                    $student_enrollment = $this->crud->get_current_enrollment($student_id);
                                    $exams         = $this->crud->get_exam_by_class($class_id);

                                    if(count($student_enrollment) > 0):                                    
                                ?>
                                <div class="col-sm-12">
                                    <div class="element-box lined-primary">
                                        <h5 class="form-header"><?= getPhrase('marks');?><br>
                                            <small><?= getPhrase('average');?></small>
                                        </h5>
                                        <div class="table-responsive">
                                            <table class="table table-lightborder">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo getPhrase('subject');?></th>
                                                        <th><?php echo getPhrase('teacher');?></th>
                                                        <th><?php echo getPhrase('attendance');?></th>
                                                        <th><?php echo getPhrase('mark');?></th>
                                                        <th><?php echo getPhrase('grade');?></th>
                                                        <th><?php echo getPhrase('gpa');?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php 
                                                        $enrollment_average = $this->db->get_where('v_enrollment' , array('student_id' => $student_id, 'class_id' => $class_id, 'section_id' => $section_id, 'year' => $running_year, 'semester_id' => $running_semester))->result_array();
                                                        
                                                        foreach ($enrollment_average as $row_average): 
                                                            $subject_id = $row_average['subject_id'];
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
                                                                                                AND year = '$running_year'
                                                                                                AND semester_id = '$running_semester'
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
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?= $row_average['subject_name'];?>
                                                        </td>
                                                        <td>
                                                            <?= $row_average['teacher_name'];?>
                                                        </td>
                                                        <td>
                                                            <?php if(is_numeric($labouno) && ($labouno < $min || $labouno == 0)):?>
                                                            <a class="btn btn-rounded btn-sm btn-danger"
                                                                style="color:white"><?php if($labouno == 0) echo '0'; else echo $labouno;?></a>
                                                            <?php endif;?>
                                                            <?php if(is_numeric($labouno) && ($labouno >= $min)):?>
                                                            <a class="btn btn-rounded btn-sm btn-info"
                                                                style="color:white"><?php echo $labouno;?></a>
                                                            <?php endif;?>
                                                        </td>
                                                        <td>
                                                            <?php if(is_numeric($mark) && ($mark < $min || $mark == 0)):?>
                                                            <a class="btn btn-rounded btn-sm btn-danger"
                                                                style="color:white"><?php if($mark == 0) echo '0'; else echo $mark;?></a>
                                                            <?php endif;?>
                                                            <?php if(is_numeric($mark) && ($mark >= $min)):?>
                                                            <a class="btn btn-rounded btn-sm btn-info"
                                                                style="color:white"><?php echo $mark;?></a>
                                                            <?php endif;?>
                                                        </td>
                                                        <td>
                                                            <?= $grade = $this->crud->get_grade($mark);?>
                                                        </td>
                                                        <td>
                                                            <?= $grade = $this->crud->get_gpa($mark);?>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach;?>
                                                </tbody>
                                            </table>
                                            <div class="form-buttons-w text-right">
                                                <a target="_blank"
                                                    href="<?php echo base_url();?>admin/marks_all_print_view/<?php echo $student_id;?>/<?php echo $row2['unit_id'];?>"><button
                                                        class="btn btn-rounded btn-success" type="submit"><i
                                                            class="picons-thin-icon-thin-0333_printer"></i>
                                                        <?php echo getPhrase('print');?></button></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php foreach ($exams as $row2):
                                ?>
                                <div class="col-sm-12">
                                    <div class="element-box lined-primary">
                                        <h5 class="form-header"><?php echo getPhrase('marks');?><br>
                                            <small><?php echo $row2['unit_name'];?></small>
                                        </h5>
                                        <div class="table-responsive">
                                            <table class="table table-lightborder">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo getPhrase('subject');?></th>
                                                        <th><?php echo getPhrase('teacher');?></th>
                                                        <th><?php echo getPhrase('attendance');?></th>
                                                        <th><?php echo getPhrase('mark');?></th>
                                                        <th><?php echo getPhrase('grade');?></th>
                                                        <th><?php echo getPhrase('gpa');?></th>
                                                        <th><?php echo getPhrase('view_all');?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        $enrollment = $this->db->get_where('v_enrollment' , array('student_id' => $student_id, 'class_id' => $class_id, 'section_id' => $section_id, 'year' => $running_year, 'semester_id' => $running_semester))->result_array();

                                                        foreach ($enrollment as $row3): 
                                                            $subject_id = $row3['subject_id'];
                                                            $unit_id = $row2['unit_id'];



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
                                                                                                AND unit_id = '$unit_id'
                                                                                                AND year = '$running_year'
                                                                                                AND semester_id = '$running_semester'
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
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?= $row3['subject_name'];?>
                                                        </td>
                                                        <td>
                                                            <?= $row3['teacher_name'];?>
                                                        </td>
                                                        <td>
                                                            <?php if(is_numeric($labouno) && ($labouno < $min || $labouno == 0)):?>
                                                            <a class="btn btn-rounded btn-sm btn-danger"
                                                                style="color:white"><?php if($labouno == 0) echo '0'; else echo $labouno;?></a>
                                                            <?php endif;?>
                                                            <?php if(is_numeric($labouno) && ($labouno >= $min)):?>
                                                            <a class="btn btn-rounded btn-sm btn-info"
                                                                style="color:white"><?php echo $labouno;?></a>
                                                            <?php endif;?>
                                                        </td>
                                                        <td>
                                                            <?php if(is_numeric($mark) && ($mark < $min || $mark == 0)):?>
                                                            <a class="btn btn-rounded btn-sm btn-danger"
                                                                style="color:white"><?php if($mark == 0) echo '0'; else echo $mark;?></a>
                                                            <?php endif;?>
                                                            <?php if(is_numeric($mark) && ($mark >= $min)):?>
                                                            <a class="btn btn-rounded btn-sm btn-info"
                                                                style="color:white"><?php echo $mark;?></a>
                                                            <?php endif;?>
                                                        </td>
                                                        <td>
                                                            <?= $grade = $this->crud->get_grade($mark);?>
                                                        </td>
                                                        <td>
                                                            <?= $grade = $this->crud->get_gpa($mark);?>
                                                        </td>
                                                        <?php $data = base64_encode($student_id."-".$class_id."-".$section_id."-".$row3['subject_id']."-".$row2['unit_id']); ?>
                                                        <td><a class="btn btn-rounded btn-sm btn-primary"
                                                                style="color:white"
                                                                href="<?php echo base_url();?>admin/subject_marks/<?php echo $data;?>"><?php echo getPhrase('view_all');?></a>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach;?>
                                                </tbody>
                                            </table>
                                            <!-- <div class="form-buttons-w text-right">
                                                <a target="_blank"
                                                    href="<?php echo base_url();?>admin/marks_print_view/<?php echo $student_id;?>/<?php echo $row2['unit_id'];?>"><button
                                                        class="btn btn-rounded btn-success" type="submit"><i
                                                            class="picons-thin-icon-thin-0333_printer"></i>
                                                        <?php echo getPhrase('print');?></button></a>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; endif;?>
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