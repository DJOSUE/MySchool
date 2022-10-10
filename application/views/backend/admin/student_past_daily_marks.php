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
                    <a title="<?= getPhrase('return');?>" href="<?= base_url();?>admin/students/"><i
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
                                <div class="col-sm-12">
                                    <div class="element-box lined-primary">
                                        <div class="table-responsive">
                                            <table class="table table-lightborder">
                                                <thead>
                                                    <tr>
                                                        <th><?= getPhrase('year')?></th>
                                                        <th><?= getPhrase('semester')?></th>
                                                        <th><?= getPhrase('class')?></th>
                                                        <th><?= getPhrase('attendance')?></th>
                                                        <th><?= getPhrase('mark')?></th>
                                                        <th><?= getPhrase('grade')?></th>
                                                        <th><?= getPhrase('gpa')?></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
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
                                                    <?php                                                          

                                                        $data = base64_encode($student_id.'-'.$class_id."-".$section_id."-".$year.'-'.$semester_id);
                                                        
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
                                                                                            AND year = '$year'
                                                                                            AND semester_id = '$semester_id'
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
                                                        
                                                        $labototal  = (float)$labodos + (float)$labotres + (float)$labocuatro + (float)$labocinco + (float)$laboseis + (float)$labosiete + (float)$laboocho + (float)$labonueve + (float)$labodiez;
                                        
                                                        $attendance = (float)$labouno;

                                                        $mark = $count > 0 ? round(($labototal/$count), (int)$roundPrecision) : '-';
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?= $enroll['year'];?>
                                                        </td>
                                                        <td>
                                                            <?= $enroll['semester_name'];?>
                                                        </td>
                                                        <td>
                                                            <?= $enroll['class_name'];?>
                                                        </td>
                                                        <td>
                                                            <?php if(is_numeric($attendance) && ($attendance < $min || $attendance == 0)):?>
                                                            <a class="btn btn-rounded btn-sm btn-danger"
                                                                style="color:white"><?php if($attendance == 0) echo '0'; else echo $attendance;?></a>
                                                            <?php endif;?>
                                                            <?php if(is_numeric($attendance) && ($attendance >= $min)):?>
                                                            <a class="btn btn-rounded btn-sm btn-info"
                                                                style="color:white"><?= $attendance;?></a>
                                                            <?php endif;?>
                                                        </td>
                                                        <td>
                                                            <?php if(is_numeric($mark) && ($mark < $min || $mark == 0)):?>
                                                            <a class="btn btn-rounded btn-sm btn-danger"
                                                                style="color:white"><?php if($mark == 0) echo '0'; else echo $mark;?></a>
                                                            <?php endif;?>
                                                            <?php if(is_numeric($mark) && ($mark >= $min)):?>
                                                            <a class="btn btn-rounded btn-sm btn-info"
                                                                style="color:white"><?= $mark;?></a>
                                                            <?php endif;?>
                                                        </td>
                                                        <td>
                                                            <?= $grade = $this->crud->get_grade($mark);?>
                                                        </td>
                                                        <td>
                                                            <?= $gpa = $this->crud->get_gpa($mark);?>
                                                        </td>
                                                        <td>
                                                            <a class="btn btn-rounded btn-sm btn-primary"
                                                                style="color:white" target="_blank"
                                                                href="<?= base_url();?>admin/student_print_marks_past_cea/<?= $data;?>">
                                                                <?= getPhrase('view_CEA');?>
                                                            </a>
                                                            <a class="btn btn-rounded btn-sm btn-primary"
                                                                style="color:white" target="_blank"
                                                                href="<?= base_url();?>admin/student_print_marks_past/<?= $data;?>">
                                                                <?= getPhrase('view_all');?>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach;?>
                                                </tbody>
                                            </table>
                                            <div class="form-buttons-w text-right">
                                                <a target="_blank"
                                                    href="<?= base_url();?>admin/marks_old_print_view/<?= base64_encode($student_id.'-'.$class_id.'-'.$section_id.'-'.$year.'-'.$semester_id);?>"><button
                                                        class="btn btn-rounded btn-success" type="submit"><i
                                                            class="picons-thin-icon-thin-0333_printer"></i>
                                                        <?= getPhrase('print');?></button></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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