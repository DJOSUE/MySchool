<?php 
    $running_year = $this->crud->getInfo('running_year');
    $running_semester = $this->crud->getInfo('running_semester');
    $roundPrecision   = $this->crud->getInfo('round_precision');
    
    $min = $this->db->get_where('academic_settings' , array('type' =>'minium_mark'))->row()->description;
?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="content-i">
            <div class="content-box">
                <div class="back"> <a href="<?php echo base_url();?>teacher/students_area/"><i
                            class="picons-thin-icon-thin-0131_arrow_back_undo"></i></a> </div>
                <div class="row">
                    <?php 
                        // = $this->db->get_where('enroll' , array('student_id' => $student_id , 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description))->result_array(); 
                        $student_info = $this->db->query("SELECT * FROM v_enroll 
                                                                    WHERE student_id = '$student_id' 
                                                                    AND year = '$running_year'
                                                                    AND semester_id = '$running_semester'
                                                                    LIMIT 1
                                                                    ")->result_array();
                        foreach($student_info as $row): 
                    ?>
                    <div class="col-sm-12">
                        <div class="pipeline white lined-secondary">
                            <div class="pipeline-header">
                                <h5 class="pipeline-name"><?php echo getPhrase('student');?></h5>
                            </div>
                            <div class="pipeline-item">
                                <div class="pi-foot">
                                    <a class="extra-info" href="javascript:void(0);"><img alt=""
                                            src="<?php echo base_url();?>public/uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>"
                                            width="15%" style="margin-right:5px"><span
                                            class="text-white"><?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;?></span></a>
                                </div>
                                <div class="pi-body">
                                    <div class="avatar" style="width:75px;">
                                        <img alt="" width="15%"
                                            src="<?php echo $this->crud->get_image_url('student',$row['student_id']);?>">
                                    </div>
                                    <div class="pi-info">
                                        <div class="h6 pi-name">
                                            <?php echo $this->crud->get_name('student', $row['student_id']);?><br>
                                            <small><?php echo getPhrase('roll');?>: <?php echo $row['roll'];?></small>
                                        </div>
                                        <div class="pi-sub">
                                            <?php echo getPhrase('class');?>:
                                            <?php echo $this->crud->get_class_name($row['class_id']); ?><br>
                                            <?php echo getPhrase('section');?>:
                                            <?php echo $this->db->get_where('section' , array('section_id' => $row['section_id']))->row()->name; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach;?>
                    <?php 
                        $student_info = $this->crud->get_student_info($student_id);
                        $exams         = $this->crud->get_exams();
                        foreach ($student_info as $row1):
                        foreach ($exams as $row2):
                    ?>
                    <div class="col-sm-12">
                        <div class="element-box lined-primary">
                            <h5 class="form-header">
                                <?php echo getPhrase('marks');?><br>
                                <small><?php echo $row2['name'];?></small>
                            </h5>
                            <div class="table-responsive">
                                <table class="table table-lightborder">
                                    <thead>
                                        <tr>
                                            <th><?php echo getPhrase('subject');?></th>
                                            <th><?php echo getPhrase('teacher');?></th>
                                            <th><?php echo getPhrase('mark');?></th>
                                            <th><?php echo getPhrase('grade');?></th>
                                            <th><?php echo getPhrase('gpa');?></th>
                                            <th><?php echo getPhrase('view_all');?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $section_id = $this->db->get_where('enroll' , array('student_id' => $student_id, 'year' => $running_year, 'semester_id' => $running_semester))->row()->section_id;
                                            $subjects = $this->db->get_where('v_enroll' , array('class_id' => $class_id, 'section_id' => $section_id, 'student_id' => $student_id, 'year' => $running_year, 'semester_id' => $running_semester))->result_array();
                                            foreach ($subjects as $row3): 
                                                $subject_id = $row3['subject_id'];
                                                $unit_id    = $row2['unit_id'];

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
                                        ?>
                                        <tr>
                                            <td>
                                                <?= $row3['subject_name'];?>
                                            </td>
                                            <td>
                                                <?php 
                                                    $teacher = $this->db->get_where('v_subject', array('subject_id' => $row3['subject_id']))->row();
                                                ?>
                                                <img alt="" src="<?= $this->crud->get_image_url('teacher', $teacher->teacher_id);?>" width="25px" style="border-radius: 10px;margin-right:5px;">
                                                <?= $teacher->teacher_name;?>
                                            </td>
                                            <td>
                                                <?php if(($mark < $min || $mark == 0) && $mark != '-'):?>
                                                <a class="btn btn-rounded btn-sm btn-danger"
                                                    style="color:white"><?php if($mark == 0) echo '0'; else echo $mark;?></a>
                                                <?php endif;?>
                                                <?php if($mark >= $min):?>
                                                <a class="btn btn-rounded btn-sm btn-info"
                                                    style="color:white"><?php echo $mark;?></a>
                                                <?php endif;?>
                                            </td>
                                            <td>
                                                <?php echo $grade = $this->crud->get_grade($mark);?>
                                            </td>
                                            <td>
                                                <?php echo $grade = $this->crud->get_gpa($mark);?>
                                            </td>
                                            <?php $data = base64_encode($class_id."-".$section_id."-".$row3['subject_id']."-".$row2['unit_id']."-".$student_id."-"); ?>
                                            <td>
                                                <a class="btn btn-rounded btn-sm btn-primary" style="color:white"
                                                    href="<?php echo base_url();?>teacher/subject_marks/<?php echo $data;?>"><?php echo getPhrase('view_all');?></a>
                                            </td>
                                        </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                                <div class="form-buttons-w text-right">
                                    <a target="_blank"
                                        href="<?php echo base_url();?>teacher/marks_print_view/<?php echo $student_id;?>/<?php echo $row2['unit_id'];?>"><button
                                            class="btn btn-rounded btn-success" type="submit"><i
                                                class="picons-thin-icon-thin-0333_printer"></i>
                                            <?php echo getPhrase('print');?></button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>