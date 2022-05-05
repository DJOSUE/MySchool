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
                        <a class="navs-links active" href="<?php echo base_url();?>student/my_marks/"><i
                                class="picons-thin-icon-thin-0658_cup_place_winner_award_prize_achievement"></i>
                            <span><?php echo getPhrase('current_marks');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>student/my_past_marks/"><i
                                class="picons-thin-icon-thin-0658_cup_place_winner_award_prize_achievement"></i>
                            <span><?php echo getPhrase('past_marks');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>student/placement_achievement/"><i
                                class="picons-thin-icon-thin-0658_cup_place_winner_award_prize_achievement"></i>
                            <span><?php echo getPhrase('placement_and_achievement');?></span></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="content-i">
            <div class="content-box">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="element-box lined-primary shadow">
                            <h5 class="form-header"><?php echo getPhrase('your_marks');?><br>
                                <small><?= getPhrase('average');?></small>
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $subjects = $this->db->get_where('v_enrollment' , array('class_id' => $class_id, 'student_id' => $student_id, 'year' => $running_year, 'semester_id'=> $running_semester))->result_array();
                                        foreach ($subjects as $key => $item):

                                            $subject_id = $item['subject_id'];
                                            $section_id = $item['section_id'];

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

                                            $labototal      = (float)$labouno + (float)$labodos + (float)$labotres + (float)$labocuatro + (float)$labocinco + (float)$laboseis + (float)$labosiete + (float)$laboocho + (float)$labonueve + (float)$labodiez;
                                            
                                            $mark = $count > 0 ? round(($labototal/$count), (int)$roundPrecision) : '-';

                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $item['subject_name'];?>
                                            </td>
                                            <td>
                                                <img alt=""
                                                    src="<?php echo $this->crud->get_image_url('teacher',$item['teacher_id']);?>"
                                                    width="25px" style="border-radius: 10px;margin-right:5px;">
                                                <?php echo $item['teacher_name']; ?>
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
                                                <?php echo $this->crud->get_grade($mark);?>
                                            </td>
                                            <td>
                                                <?php echo $this->crud->get_gpa($mark);?>
                                            </td>    
                                        </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <?php 
        				//$student_info = $this->db->get_where('v_enroll' , array('student_id' => $student_id , 'class_id' => $class_id, 'year' => $running_year, 'semester_id' => $running_semester))->result_array();
                        $student_info = $this->db->query("SELECT * FROM v_enroll 
                                                                    WHERE student_id = '$student_id'
                                                                    AND class_id = $class_id
                                                                    AND year = '$running_year'
                                                                    AND semester_id = '$running_semester'
                                                                    LIMIT 1
                                                                    ")->result_array();

    				    $exams = $this->db->get_where('v_class_units', array('class_id' => $class_id))->result_array();

    				    foreach ($student_info as $row1):
    				    foreach ($exams as $row2):
				    ?>
                    <div class="col-sm-12">
                        <div class="element-box lined-primary shadow">
                            <h5 class="form-header"><?php echo getPhrase('your_marks');?><br>
                                <small><?php echo $row2['unit_name'];?></small>
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
                                			$subjects = $this->db->get_where('v_subject' , array('class_id' => $row1['class_id'], 'section_id' => $row1['section_id']))->result_array();
                            			    foreach ($subjects as $row3): 

                                                $subject_id = $row3['subject_id'];
                                                $section_id = $row3['section_id'];
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

                                            $labototal      = (float)$labouno + (float)$labodos + (float)$labotres + (float)$labocuatro + (float)$labocinco + (float)$laboseis + (float)$labosiete + (float)$laboocho + (float)$labonueve + (float)$labodiez;
                                            
                                            $mark = $count > 0 ? round(($labototal/$count), (int)$roundPrecision) : '-';
                            		    ?>
                                        <tr>
                                            <td>
                                                <?php echo $row3['name'];?>
                                            </td>
                                            <td>
                                                <img alt=""
                                                    src="<?php echo $this->crud->get_image_url('teacher',$row3['teacher_id']);?>"
                                                    width="25px" style="border-radius: 10px;margin-right:5px;">
                                                <?php echo $row3['teacher_name']; ?>
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
                                            <td><?php echo $this->crud->get_grade($mark);?>
                                            </td>
                                            <td><?php echo $this->crud->get_gpa($mark);?>
                                            </td>
                                            <?php $data = base64_encode($row1['class_id']."-".$row1['section_id']."-".$row3['subject_id']); ?>
                                            <td><a class="btn btn-rounded btn-sm btn-primary" style="color:white"
                                                    href="<?php echo base_url();?>student/subject_marks/<?php echo $data;?>/<?=$unit_id;?>"><?php echo getPhrase('view_all');?></a>
                                            </td>
                                        </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                                <div class="form-buttons-w text-right">
                                    <a target="_blank"
                                        href="<?php echo base_url();?>student/marks_print_view/<?php echo base64_encode($student_id.'-'. $row2['unit_id']);?>/"><button
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