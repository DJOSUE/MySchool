<?php 
    $running_year       = $this->crud->getInfo('running_year');
    $running_semester   = $this->crud->getInfo('running_semester');  
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

    $grades[] = [1, 'lab_uno', 'labuno'];
    $grades[] = [2, 'lab_dos', 'labdos'];
    $grades[] = [3, 'lab_tres', 'labtres'];
    $grades[] = [4, 'lab_cuatro', 'labcuatro'];
    $grades[] = [5, 'lab_cinco', 'labcinco'];
    $grades[] = [6, 'lab_seis', 'labseis'];
    $grades[] = [7, 'lab_siete', 'labsiete'];
    $grades[] = [8, 'lab_ocho', 'labocho'];
    $grades[] = [9, 'lab_nueve', 'labnueve'];
    $grades[] = [10, 'lab_diez', 'labdiez'];

    
    $sub = $this->db->get_where('subject', array('subject_id' => $ex[2]))->result_array();
    foreach($sub as $subs):
?>
<div class="content-w">
    <div class="conty">
        <?php include 'fancy.php';?>
        <div class="header-spacer"></div>
        <div class="cursos cta-with-media" style="background: #<?= $subs['color'];?>;">
            <div class="cta-content">
                <div class="user-avatar">
                    <img alt="" src="<?= base_url();?>public/uploads/subject_icon/<?= $subs['icon'];?>"
                        style="width:60px;">
                </div>
                <h3 class="cta-header"><?= $subs['name'];?> - <small><?= getPhrase('marks');?></small>
                </h3>
                <small
                    style="font-size:0.90rem; color:#fff;"><?= $this->db->get_where('class', array('class_id' => $ex[0]))->row()->name;?>
                    "<?= $this->db->get_where('section', array('section_id' => $ex[1]))->row()->name;?>"
                </small>
            </div>
        </div>
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <?php include 'subject__nav.php';?>
            </div>
        </div>
        <div class="content-i">
            <div class="content-box">
                <div class="row">
                    <main class="col col-xl-12 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
                        <div class="ui-block">
                            <article class="hentry post thumb-full-width">
                                <div class="post__author author vcard inline-items">
                                    <img src="<?= base_url();?>public/uploads/<?= $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>"
                                        style="border-radius:0px;">
                                    <div class="author-date">
                                        <a class="h6 post__author-name fn"
                                            href="javascript:void(0);"><?= getPhrase('marks');?>
                                            <small>(<?= $this->db->get_where('v_class_units', array('class_id' => $class_id, 'unit_id' => $unit_id))->row()->unit_name;?>)</small>.</a>
                                    </div>
                                    <br />
                                    <div class="post__author author vcard inline-items">
                                        <span>Date: </span>
                                        <span><?= $date; ?></span>
                                    </div>
                                </div>
                                <div class="edu-posts cta-with-media">
                                    <div style="padding:0% 0%">
                                        <div id='cssmenu'>
                                            <ul>
                                                <?php  
                    				                $var = 0;
                    				                $examss = $this->crud->get_exam_by_class($class_id); // db->get_where('v_class_units', array( 'class_id' => $class_id))->result_array();
                    				                foreach($examss as $exam):
                    				                $var++;
                    				            ?>
                                                <li class="<?php if($exam['unit_id'] == $unit_id) echo "act";?>"><a
                                                        href="<?= base_url();?>teacher/subject_upload_marks/<?= $data.'/'.$exam['unit_id'];?>/"><i
                                                            class="os-icon picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i><?= $exam['unit_name'];?></a>
                                                </li>
                                                <?php endforeach;?>
                                            </ul>
                                        </div>
                                    </div>
                                    <?= form_open(base_url() . 'teacher/marks_update/'.$unit_id.'/'.$class_id.'/'.$section_id.'/'.$subject_id.'/'.$date);?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr style="background:#f2f4f8;">
                                                    <th style="text-align: center;">
                                                        <?= getPhrase('student');?>
                                                    </th>
                                                    <?php 
                                                        $subjectLabel = $this->db->get_where('subject' , array('subject_id' => $subject_id))->row();
                                                        for ($i=1; $i <= $quantityGrades; $i++):
                                                            $name = 'la'.$i;
                                                    ?>
                                                    <th style="text-align: center;">
                                                        <?= $subjectLabel->$name; ?>
                                                    </th>
                                                    <?php endfor; ?>
                                                    <th style="text-align: center;">
                                                        <?= getPhrase('comment');?>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                        $count = 1;
                                                        $students = $this->db->get_where('enroll' , array('class_id' => $class_id, 'section_id' => $section_id, 'subject_id' => $subject_id, 'year' => $running_year, 'semester_id' => $running_semester,))->result_array();
                                                        $students_list = "";
                                                        foreach ($students as $key => $row) :
                                                            $student_id     = $row['student_id'];
                                                            $mark_daily_id  = $this->academic->get_daily_mark_id($student_id, $class_id, $section_id, $subject_id, $date, $unit_id);
                                                            $student_mark   = $this->db->get_where('mark_daily' , array('mark_daily_id' => $mark_daily_id))->row_array();
                                                    ?>
                                                <tr style="height:25px;">
                                                    <td style="min-width:190px">
                                                        <img name="<?=$student_id?>" alt=""
                                                            src="<?= $this->crud->get_image_url('student', $student_id);?>"
                                                            width="25px" style="border-radius: 10px;margin-right:5px;">
                                                        <?= $this->crud->get_name('student', $student_id);?>
                                                    </td>
                                                    <?php 
                                                        for ($i=0; $i < $quantityGrades; $i++):
                                                            $name           = $grades[$i];
                                                            $mark_name      = 'daily_mark_student['.$student_id.']['.$name[1].']';
                                                            $comment_name   = 'daily_mark_student['.$student_id.'][comment]';
                                                    ?>
                                                    <td>
                                                        <center>
                                                            <input type="text" name="<?= $mark_name;?>"
                                                                placeholder="0" maxlength="3"
                                                                style="width:65px; border: 1; text-align: center;"
                                                                value="<?= $student_mark[$name[2]];?>">
                                                        </center>
                                                    </td>
                                                    <?php endfor; ?>
                                                    <td>
                                                        <center>
                                                            <input type="text" class="form-control"
                                                                name="<?= $comment_name;?>"
                                                                value="<?= $student_mark['comment'];?>">
                                                        </center>
                                                    </td>
                                                </tr>
                                                <?php endforeach;?>
                                            </tbody>
                                        </table>
                                        <div class="form-buttons-w text-center">
                                            <button class="btn btn-success btn-rounded"
                                                type="submit"><?= getPhrase('update');?></button>
                                            <a class="btn btn-danger btn-rounded" style="color: white;"
                                                onclick="close_class_unit(<?= $unit_id?>)"><?= getPhrase('close_unit');?></a>
                                        </div>
                                        <?= form_close();?>
                                    </div>
                                </div>
                                <div class="control-block-button post-control-button">
                                    <a href="javascript:void(0);"
                                        onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_mark/<?= $ex[2];?>/<?= $ex[1];?>/');"
                                        class="btn btn-control featured-post"
                                        style="background-color: #99bf2d; color: #fff;" data-toggle="tooltip"
                                        data-placement="top"
                                        data-original-title="<?= getPhrase('update_activities');?>">
                                        <i class="picons-thin-icon-thin-0102_notebook_to_do_bullets_list"></i>
                                    </a>
                                </div>
                            </article>
                        </div>
                    </main>
                </div>
            </div>
            <a class="back-to-top" href="javascript:void(0);">
                <img src="<?= base_url();?>public/style/olapp/svg-icons/back-to-top.svg" alt="arrow" class="back-icon">
            </a>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $("#update_daily_marks :input").attr("readonly", true);
});

function close_class_unit(unit_id) {
    Swal.fire({
        title: '<?= getPhrase('confirm_close_unit');?>',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            class_id = <?=$class_id;?>;
            $.ajax({
                url: '<?php echo base_url();?>tools/close_class_unit/' + class_id + '/' + unit_id,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timerProgressBar: true,
                        title: '<?= getPhrase('successfully_updated');?>',
                        timer: 3000
                    })
                    location.reload(true);
                }
            });
        }
    })
}
</script>
<?php endforeach;?>