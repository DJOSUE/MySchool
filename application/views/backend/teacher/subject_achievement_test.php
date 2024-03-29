<?php

use function PHPSTORM_META\map;

    $running_year       = $this->crud->getInfo('running_year');
    $running_semester   = $this->crud->getInfo('running_semester'); 

    $useDailyMarks      = $this->crud->getInfo('use_daily_marks');
    $useGradeAttendance = $this->crud->getInfo('use_grade_attendance');

    $quantity_score         = intval($this->academic->getInfo('ap_quantity_score'));
    $ap_test_names          = json_decode($this->academic->getInfo('ap_test_names'), true);
    $achievement_weighting  = json_decode($this->academic->getInfo('achievement_weighting'), true);

    $info   = base64_decode($data);
    $ex     = explode('-', $info);
    
    $class_id   = $ex[0];
    $section_id = $ex[1];
    $subject_id = $ex[2];

    $sub = $this->db->get_where('subject', array('subject_id' => $ex[2]))->result_array();
    foreach($sub as $row):
?>
<div class="content-w">
    <div class="conty">
        <?php include 'fancy.php';?>
        <div class="header-spacer"></div>
        <div class="cursos cta-with-media" style="background: #<?php echo $row['color'];?>;">
            <div class="cta-content">
                <div class="user-avatar">
                    <img alt="" src="<?php echo base_url();?>public/uploads/subject_icon/<?php echo $row['icon'];?>"
                        style="width:60px;">
                </div>
                <h3 class="cta-header"><?php echo $row['name'];?> - <small><?php echo getPhrase('dashboard');?></small>
                </h3>
                <small
                    style="font-size:0.90rem; color:#fff;"><?php echo $this->db->get_where('class', array('class_id' => $ex[0]))->row()->name;?>
                    "<?php echo $this->db->get_where('section', array('section_id' => $ex[1]))->row()->name;?>"</small>
            </div>
        </div>
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <?php include 'subject__nav.php'?>
            </div>
        </div>
        <div class="content-i">
            <div class="content-box">
                <div class="row">
                    <main class="col col-xl-12 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
                        <div class="ui-block">
                            <article class="hentry post thumb-full-width">
                                <div class="post__author author vcard inline-items">
                                    <img src="<?php echo base_url();?>public/uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>"
                                        style="border-radius:0px;">
                                    <div class="author-date">
                                        <a
                                            class="h6 post__author-name fn"><?php echo getPhrase('achievement_test');?></a>
                                    </div>
                                </div>
                                <div class="edu-posts cta-with-media">
                                    <?php echo form_open(base_url() . 'teacher/update_achievement_test_batch/'.$data);?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr style="background:#f2f4f8;">
                                                    <th style="text-align: center;">
                                                        <?php echo getPhrase('student');?>
                                                    </th>
                                                    <?php for ($i=1; $i <= $quantity_score; $i++):
                                                        $name = 'score'.$i;?>
                                                    <th class="text-center">
                                                        <?= $ap_test_names[$name] ?>
                                                    </th>
                                                    <?php endfor; ?>

                                                    <th style="text-align: center;"><?php echo getPhrase('comment');?>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                        $count = 0;

                                                        $students = $this->db->query("SELECT student_id FROM enroll 
                                                        WHERE class_id = '$ex[0]' 
                                                        AND section_id = '$ex[1]' 
                                                        AND subject_id = '$subject_id'
                                                        AND year = '$running_year'
                                                        AND semester_id = '$running_semester'
                                                        GROUP BY student_id")->result_array();

                                                        $student_ids = array_column($students, 'student_id');
                                                        $List = implode(', ', $student_ids);

                                                        $test_students = $this->db->get_where('pa_test' , array('class_id' => $ex[0], 'section_id' => $ex[1],'year' => $running_year,'semester_id' => $running_semester))->result_array();
                                                        foreach($test_students as $row):
                                                            $key = array_search($row['student_id'], array_column($students, 'student_id'));
                                                            if(is_numeric($key)):
                                                                $student_id     = $row['student_id'];
                                                                $status_info    = $this->studentModel->get_student_status_info($student_id);
                                                                $count++;
                                                    ?>
                                                <tr style="height:25px;">
                                                    <td style="min-width:190px">
                                                        <div class="inline-items">
                                                            <div class="author-thumb" style="margin-right: 10px;">
                                                                <img src="<?= $this->crud->get_image_url('student', $student_id);?>"
                                                                    width="35px">
                                                            </div>                                                            
                                                            <div class="notification-event">
                                                                <a class="h6 notification-friend">
                                                                    <?= $this->crud->get_name('student', $student_id)?>
                                                                </a>
                                                                <br/>
                                                                <span class="badge"
                                                                    style="background-color: <?=$status_info['color']?>;">
                                                                    <?= $status_info['name'];?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <?php 
                                                        for ($i=1; $i <= $quantity_score; $i++):
                                                            $name = 'score'.$i
                                                    ?>
                                                    <td>
                                                        <center><input type="number"
                                                                name="<?= $name.'_'.$row['test_id'];?>" placeholder="0"
                                                                max="<?= $achievement_weighting[$name] ?>"
                                                                style="width:85px; border: 1; text-align: center;"
                                                                value="<?php echo $row[$name];?>"> </center>
                                                    </td>

                                                    <?php endfor;?>
                                                    <td>
                                                        <center><input type="text" class="form-control"
                                                                name="comment_<?php echo $row['test_id'];?>"
                                                                value="<?php echo $row['comment'];?>"></center>
                                                    </td>
                                                </tr>
                                                <?php endif; endforeach;?>
                                            </tbody>
                                        </table>
                                        <div class="form-buttons-w text-center">
                                            <button class="btn btn-success btn-rounded"
                                                type="submit"><?php echo getPhrase('update');?></button>
                                        </div>
                                        <?php echo form_close();?>
                                    </div>
                                    <?php form_close(); ?>
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