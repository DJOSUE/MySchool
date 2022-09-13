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
                                    <div class="up-head-w"
                                        style="background-image:url(<?php echo base_url();?>public/uploads/bglogin.jpg)">
                                        <div class="up-main-info">
                                            <div class="user-avatar-w">
                                                <div class="user-avatar">
                                                    <img alt=""
                                                        src="<?php echo $this->crud->get_image_url('student', $row['student_id']);?>"
                                                        style="background-color:#fff;">
                                                </div>
                                            </div>
                                            <h3 class="text-white"><?php echo $row['first_name'];?>
                                                <?php echo $row['last_name'];?></h3>
                                            <h5 class="up-sub-header">@<?php echo $row['username'];?></h5>
                                        </div>
                                        <svg class="decor" width="842px" height="219px" viewBox="0 0 842 219"
                                            preserveAspectRatio="xMaxYMax meet" version="1.1"
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <g transform="translate(-381.000000, -362.000000)" fill="#FFFFFF">
                                                <path class="decor-path"
                                                    d="M1223,362 L1223,581 L381,581 C868.912802,575.666667 1149.57947,502.666667 1223,362 Z">
                                                </path>
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="up-controls">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="value-pair">
                                                    <div><?php echo getPhrase('account_type');?>:</div>
                                                    <div class="value badge badge-pill badge-primary">
                                                        <?php echo getPhrase('student');?></div>
                                                </div>
                                                <div class="value-pair">
                                                    <div><?php echo getPhrase('member_since');?>:</div>
                                                    <div class="value"><?php echo $row['since'];?>.</div>
                                                </div>
                                                <div class="value-pair">
                                                    <div><?php echo getPhrase('roll');?>:</div>
                                                    <div class="value">
                                                        <?php echo $this->db->get_where('enroll', array('student_id' => $row['student_id']))->row()->roll;?>.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="element-box lined-primary">
                                        <div class="table-responsive">
                                            <table class="table table-lightborder">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo getPhrase('year')?></th>
                                                        <th><?php echo getPhrase('semester')?></th>
                                                        <th><?php echo getPhrase('class')?></th>
                                                        <th><?php echo getPhrase('attendance')?></th>
                                                        <th><?php echo getPhrase('mark')?></th>
                                                        <th><?php echo getPhrase('grade')?></th>
                                                        <th><?php echo getPhrase('gpa')?></th>
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
                                                                style="color:white"><?php echo $attendance;?></a>
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
                                                            <?= $gpa = $this->crud->get_gpa($mark);?>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach;?>
                                                </tbody>
                                            </table>
                                            <div class="form-buttons-w text-right">
                                                <a target="_blank"
                                                    href="<?php echo base_url();?>admin/marks_old_print_view/<?php echo base64_encode($student_id.'-'.$class_id.'-'.$section_id.'-'.$year.'-'.$semester_id);?>"><button
                                                        class="btn btn-rounded btn-success" type="submit"><i
                                                            class="picons-thin-icon-thin-0333_printer"></i>
                                                        <?php echo getPhrase('print');?></button></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                    <div class="col col-xl-3 order-xl-1 col-lg-12 order-lg-2 col-md-12 col-sm-12 col-12 ">
                        <div class="eduappgt-sticky-sidebar">
                            <div class="sidebar__inner">
                                <div class="ui-block paddingtel">
                                    <div class="ui-block-content">
                                        <div class="widget w-about">
                                            <a href="javascript:void(0);" class="logo"><img
                                                    src="<?php echo base_url();?>public/uploads/<?php echo $this->crud->getInfo('logo');?>"></a>
                                            <ul class="socials">
                                                <li><a class="socialDash fb"
                                                        href="<?php echo $this->crud->getInfo('facebook');?>"><i
                                                            class="fab fa-facebook-square" aria-hidden="true"></i></a>
                                                </li>
                                                <li><a class="socialDash tw"
                                                        href="<?php echo $this->crud->getInfo('twitter');?>"><i
                                                            class="fab fa-twitter" aria-hidden="true"></i></a></li>
                                                <li><a class="socialDash yt"
                                                        href="<?php echo $this->crud->getInfo('youtube');?>"><i
                                                            class="fab fa-youtube" aria-hidden="true"></i></a></li>
                                                <li><a class="socialDash ig"
                                                        href="<?php echo $this->crud->getInfo('instagram');?>"><i
                                                            class="fab fa-instagram" aria-hidden="true"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="ui-block paddingtel">
                                    <div class="ui-block-content">
                                        <div class="help-support-block">
                                            <h3 class="title"><?php echo getPhrase('quick_links');?></h3>
                                            <ul class="help-support-list">
                                                <li>
                                                    <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                        style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                    <a
                                                        href="<?php echo base_url();?>admin/student_portal/<?php echo $student_id;?>/">
                                                        <?php echo getPhrase('personal_information');?>
                                                    </a>
                                                </li>
                                                <li>
                                                    <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                        style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                    <a
                                                        href="<?php echo base_url();?>admin/student_update/<?php echo $student_id;?>/">
                                                        <?php echo getPhrase('update_information');?>
                                                    </a>
                                                </li>
                                                <li>
                                                    <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                        style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                    <a
                                                        href="<?php echo base_url();?>admin/student_update_class/<?php echo $student_id;?>/">
                                                        <?php echo getPhrase('update_class');?>
                                                    </a>
                                                </li>
                                                <li>
                                                    <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                        style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                    <a
                                                        href="<?php echo base_url();?>admin/student_enrollments/<?php echo $student_id;?>/">
                                                        <?php echo getPhrase('student_enrollments');?>
                                                    </a>
                                                </li>
                                                <li>
                                                    <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                        style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                    <a
                                                        href="<?php echo base_url();?>admin/student_invoices/<?php echo $student_id;?>/">
                                                        <?php echo getPhrase('payments_history');?>
                                                    </a>
                                                </li>
                                                <li>
                                                    <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                        style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                    <a
                                                        href="<?php echo base_url();?>admin/student_marks/<?php echo $student_id;?>/">
                                                        <?php echo getPhrase('marks');?>
                                                    </a>
                                                </li>
                                                <li>
                                                    <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                        style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                    <a
                                                        href="<?php echo base_url();?>admin/student_past_marks/<?php echo $student_id;?>/">
                                                        <?php echo getPhrase('old_marks');?>
                                                    </a>
                                                </li>
                                                <li>
                                                    <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                        style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                    <a
                                                        href="<?php echo base_url();?>admin/student_profile_attendance/<?php echo $student_id;?>/">
                                                        <?php echo getPhrase('attendance');?>
                                                    </a>
                                                </li>
                                                <li>
                                                    <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                        style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                    <a
                                                        href="<?php echo base_url();?>admin/student_profile_report/<?php echo $student_id;?>/">
                                                        <?php echo getPhrase('behavior');?>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach;?>