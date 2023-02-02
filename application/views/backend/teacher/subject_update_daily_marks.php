<?php 
    $running_year       = $this->crud->getInfo('running_year');
    $running_semester   = $this->crud->getInfo('running_semester');  
    $quantityGrades     = $this->crud->getInfo('quantity_grades');
    $useDailyMarks      = $this->crud->getInfo('use_daily_marks');
    $useGradeAttendance = $this->crud->getInfo('use_grade_attendance');

    $tmpQuantity = $quantityGrades;

    $info   = base64_decode($data);
    $ex     = explode('-', $info);

    $class_id   = $ex[0];
    $section_id = $ex[1];
    $subject_id = $ex[2];

    $grades[] = [1, 'lab_uno_', 'labuno'];
    $grades[] = [2, 'lab_dos_', 'labdos'];
    $grades[] = [3, 'lab_tres_', 'labtres'];
    $grades[] = [4, 'lab_cuatro_', 'labcuatro'];
    $grades[] = [5, 'lab_cinco_', 'labcinco'];
    $grades[] = [6, 'lab_seis_', 'labseis'];
    $grades[] = [7, 'lab_siete_', 'labsiete'];
    $grades[] = [8, 'lab_ocho_', 'labocho'];
    $grades[] = [9, 'lab_nueve_', 'labnueve'];
    $grades[] = [10, 'lab_diez_', 'labdiez'];

    
    $sub = $this->db->get_where('subject', array('subject_id' => $ex[2]))->result_array();
    foreach($sub as $subs):
?>
<div class="content-w">
    <div class="conty">
        <?php include 'fancy.php';?>
        <div class="header-spacer"></div>
        <div class="cursos cta-with-media" style="background: #<?php echo $subs['color'];?>;">
            <div class="cta-content">
                <div class="user-avatar">
                    <img alt="" src="<?php echo base_url();?>public/uploads/subject_icon/<?php echo $subs['icon'];?>"
                        style="width:60px;">
                </div>
                <h3 class="cta-header"><?php echo $subs['name'];?> - <small><?php echo getPhrase('marks');?></small>
                </h3>
                <small
                    style="font-size:0.90rem; color:#fff;"><?php echo $this->db->get_where('class', array('class_id' => $ex[0]))->row()->name;?>
                    "<?php echo $this->db->get_where('section', array('section_id' => $ex[1]))->row()->name;?>"
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
                                    <img src="<?php echo base_url();?>public/uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>"
                                        style="border-radius:0px;">
                                    <div class="author-date">
                                        <a class="h6 post__author-name fn"
                                            href="javascript:void(0);"><?php echo getPhrase('marks');?>
                                            <small>(<?php echo $this->db->get_where('v_class_units', array('class_id' => $class_id, 'unit_id' => $unit_id))->row()->unit_name;?>)</small>.</a>
                                    </div>
                                </div>
                                <div class="edu-posts cta-with-media">
                                    <div style="padding:0% 0%">
                                        <?php echo form_open(base_url() . 'teacher/subject_update_daily_marks/'.$data, array('class' => 'form'));?>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group label-floating is-select">
                                                    <label class="control-label"><?php echo getPhrase('student');?></label>
                                                    <div class="select">
                                                        <select name="student_id" id="student_id">
                                                            <option value=""><?php echo getPhrase('select');?></option>
                                                            <?php 
                                                                $students = $this->db->query("SELECT student_id, full_name FROM v_enroll 
                                                                                        WHERE class_id = '$class_id'
                                                                                        AND section_id = '$section_id'
                                                                                        AND subject_id = '$subject_id'
                                                                                        AND year = '$running_year'
                                                                                        AND semester_id = '$running_semester'                                                                                      
                                                                                        GROUP BY student_id
                                                                                        ORDER BY full_name
                                                                                        "
                                                                                    )->result_array();    

                                                                $students_list = "";

                                                                foreach($students as $row):
                                                                    $students_list .= $row['student_id'].", ";
                                                            ?>
                                                            <option value="<?php echo $row['student_id'];?>"
                                                                <?php if($student_id == $row['student_id']) echo "selected"; ?>>
                                                                <?php echo $row['full_name'];?>
                                                            </option>
                                                            <?php endforeach;
                                                                $students_list = rtrim($students_list, ", ");
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group label-floating is-select">
                                                    <label class="control-label"><?php echo getPhrase('units');?></label>
                                                    <div class="select">
                                                        <select name="unit_id" id="unit_id">
                                                            <option value=""><?php echo getPhrase('select');?></option>
                                                            <?php 
                                                                $exams = $this->crud->get_exam_by_class($class_id);
                                                                foreach($exams as $row):
                                                            ?>
                                                            <option value="<?php echo $row['unit_id'];?>"
                                                                <?php if($unit_id == $row['unit_id']) echo "selected"; ?>>
                                                                <?php echo $row['unit_name'];?></option>
                                                            <?php endforeach;?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group label-floating is-select">
                                                    <label class="control-label"><?php echo getPhrase('date');?></label>
                                                    <input name="mark_date" id="mark_date" type="date" class="form-control"
                                                        value="<?php 
                                                        if(!$mark_date)
                                                            echo "";
                                                        else
                                                            echo $mark_date;
                                                        ?>" max="<?php echo date('Y-m-d');?>">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <button class="btn btn-success btn-upper"
                                                    type="submit"><?php echo getPhrase('search');?>
                                                </button>
                                                <a class="btn btn-secondary btn-rounded" style="color: white;"
                                                    onclick="add_daily_marks('<?= $data;?>')"><?php echo getPhrase('add');?></a>                                        
                                            </div>
                                        </div>
                                        <?php echo form_close();?>
                                    </div>
                                    <?php if($can_edit):                                        
                                        $url = base_url() . 'teacher/update_daily_marks_batch/' . $data . '/' . ($student_id == '' ? 'NA' : $student_id)  . '/' . ($unit_id == '' ? 'NA' : $unit_id). '/' . ($mark_date == '' ? 'NA' : $mark_date);
                                        echo form_open( $url, array('class' => 'form', 'id' => 'update_daily_marks_batch', 'name' => 'update_daily_marks_batch'));
                                    ?>
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <a class="btn btn-secondary btn-rounded" style="color: white;"
                                                    onclick="edit_daily_marks('update_daily_marks_process')"><?php echo getphrase('edit');?></a>
                                        </div>
                                        <div class="col-sm-1">
                                            <button class="btn btn-danger btn-upper" id="btn_update"
                                                type="submit" disabled><?php echo getphrase('save');?>
                                            </button>
                                        </div>
                                        
                                    </div>
                                    <?php endif;?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr style="background:#f2f4f8;">
                                                    <th style="text-align: center;">
                                                        <?php echo getPhrase('student');?>
                                                    </th>
                                                    <th style="text-align: center;">
                                                        <?php echo getPhrase('units');?>
                                                    </th>
                                                    <th style="text-align: center;">
                                                        <?php echo getPhrase('date');?>
                                                    </th>
                                                    <?php 
                                                        $subjectLabel = $this->db->get_where('subject' , array('subject_id' => $ex[2]))->row();
                                                        for ($i=1; $i <= $quantityGrades; $i++):
                                                            $name = 'la'.$i;
                                                    ?>
                                                        <th style="text-align: center;">
                                                            <?php echo $subjectLabel->$name; ?>
                                                        </th>
                                                    <?php endfor; ?>
                                                    <th style="text-align: center;">
                                                        <?php echo getPhrase('comment');?>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                        $count = 1;
                                                        $students = $this->db->get_where('enroll' , array('class_id' => $class_id, 'section_id' => $section_id, 'subject_id' => $subject_id, 'year' => $running_year, 'semester_id' => $running_semester,))->result_array();
                                                        $students_list = "";
                                                        foreach ($students as $key => $value) {
                                                            $students_list .= $value['student_id'].', ';
                                                        }
    
                                                        $students_list = rtrim($students_list, ", ");
                                                        
                                                        // Get marks
                                                        if($student_id != '' && $unit_id != '' && $mark_date != ''){
                                                            $marks = $this->db->query("SELECT *
                                                                                    FROM v_mark_daily 
                                                                                    WHERE class_id = '$class_id'
                                                                                        AND section_id = '$section_id'
                                                                                        AND subject_id = '$subject_id'
                                                                                        AND unit_id = '$unit_id'
                                                                                        AND year = '$running_year'
                                                                                        AND semester_id = '$running_semester'
                                                                                        AND date = '$mark_date'
                                                                                        AND student_id = '$student_id'
                                                                                        ORDER BY first_name asc
                                                                                        ")->result_array();
                                                        }
                                                        else if($student_id != '' && $unit_id != '' && $mark_date == '') {
                                                            $marks = $this->db->query("SELECT *
                                                                                    FROM v_mark_daily 
                                                                                    WHERE student_id = '$student_id'
                                                                                        AND class_id = '$ex[0]'
                                                                                        AND section_id = '$ex[1]'
                                                                                        AND subject_id = '$ex[2]'
                                                                                        AND unit_id = '$unit_id'
                                                                                        AND year = '$running_year'
                                                                                        AND semester_id = '$running_semester'
                                                                                    ORDER BY date, first_name asc
                                                                                        ")->result_array();
                                                        }
                                                        else if($student_id != '' && $unit_id == '' && $mark_date != '') {
                                                            $marks = $this->db->query("SELECT *
                                                                                    FROM v_mark_daily 
                                                                                    WHERE student_id = '$student_id'
                                                                                        AND class_id = '$ex[0]'
                                                                                        AND section_id = '$ex[1]'
                                                                                        AND subject_id = '$ex[2]'
                                                                                        AND date = '$mark_date'
                                                                                        AND year = '$running_year'
                                                                                        AND semester_id = '$running_semester'
                                                                                    ORDER BY date, first_name asc
                                                                                        ")->result_array();
                                                        }
                                                        else if($student_id != '' && $unit_id == '' && $mark_date == '') {
                                                            $marks = $this->db->query("SELECT *
                                                                                    FROM v_mark_daily 
                                                                                    WHERE student_id = '$student_id'
                                                                                        AND class_id = '$ex[0]'
                                                                                        AND section_id = '$ex[1]'
                                                                                        AND subject_id = '$ex[2]'
                                                                                        AND year = '$running_year'
                                                                                        AND semester_id = '$running_semester'
                                                                                    ORDER BY date, first_name asc
                                                                                        ")->result_array();
                                                        }
                                                        else if($student_id == '' && $unit_id != '' && $mark_date == ''){
                                                            $marks = $this->db->query("SELECT *
                                                                                    FROM v_mark_daily 
                                                                                    WHERE class_id = '$ex[0]'
                                                                                        AND section_id = '$ex[1]'
                                                                                        AND subject_id = '$ex[2]'
                                                                                        AND unit_id = '$unit_id'
                                                                                        AND student_id in ($students_list)
                                                                                        AND year = '$running_year'
                                                                                        AND semester_id = '$running_semester'
                                                                                    ORDER BY date, first_name asc
                                                                                        ")->result_array();
                                                        }
                                                        else if($student_id == '' && $unit_id != '' && $mark_date != ''){
                                                            $marks = $this->db->query("SELECT *
                                                                                    FROM v_mark_daily 
                                                                                    WHERE class_id = '$ex[0]'
                                                                                        AND section_id = '$ex[1]'
                                                                                        AND subject_id = '$ex[2]'
                                                                                        AND unit_id = '$unit_id'
                                                                                        AND student_id in ($students_list)
                                                                                        AND date = '$mark_date'
                                                                                        AND year = '$running_year'
                                                                                        AND semester_id = '$running_semester'
                                                                                    ORDER BY date, first_name asc
                                                                                        ")->result_array();
                                                        }
                                                        else if($student_id == '' && $unit_id == '' && $mark_date != ''){
                                                            $marks = $this->db->query("SELECT *
                                                                                    FROM v_mark_daily 
                                                                                    WHERE class_id = '$ex[0]'
                                                                                        AND section_id = '$ex[1]'
                                                                                        AND subject_id = '$ex[2]'
                                                                                        AND student_id in ($students_list)
                                                                                        AND date = '$mark_date'
                                                                                        AND year = '$running_year'
                                                                                        AND semester_id = '$running_semester'
                                                                                    ORDER BY date, first_name asc
                                                                                        ")->result_array();
                                                        }
                                                        else {
                                                            $marks = $this->db->query("SELECT *
                                                                                    FROM v_mark_daily 
                                                                                    WHERE class_id = '$ex[0]'
                                                                                        AND section_id = '$ex[1]'
                                                                                        AND subject_id = '$ex[2]'
                                                                                        AND student_id in ($students_list)
                                                                                        AND year = '$running_year'
                                                                                        AND semester_id = '$running_semester'
                                                                                    ORDER BY date, first_name asc
                                                                                        ")->result_array();
                                                        }
                                                        
                                                        foreach($marks as $row):
                                                    ?>
                                                <tr style="height:25px;">
                                                    <td style="min-width:100px">
                                                        <img alt=""
                                                            src="<?php echo $this->crud->get_image_url('student', $row['student_id']);?>"
                                                            width="25px" style="border-radius: 10px;margin-right:5px;">
                                                        <?php echo $this->crud->get_name('student', $row['student_id']);?>
                                                    </td>
                                                    <td>
                                                        <center>                                                            
                                                            <label
                                                                name="unit_id_<?php echo $item['mark_id'];?>"
                                                                style=" border: 1; text-align: center;">
                                                                <?php echo ($row['unit_name']);?>
                                                            </label>
                                                        </center>
                                                    </td>
                                                    <td>
                                                        <center>                                                            
                                                            <label
                                                                name="unit_id_<?php echo $item['mark_id'];?>"
                                                                style="border: 1; text-align: center;">
                                                                <?php echo ($row['date']);?>
                                                            </label>
                                                        </center>
                                                    </td>
                                                    <?php 
                                                        for ($i=0; $i < $quantityGrades; $i++):
                                                            $name = $grades[$i];
                                                    ?>
                                                    <td>
                                                        <center>
                                                            <input type="text"
                                                                   id="<?php echo $name[1].$row['mark_daily_id'];?>"
                                                                   name="<?php echo $name[1].$row['mark_daily_id'];?>"
                                                                   style="width:65px; border: 1; text-align: center;"
                                                                   value="<?php echo $row[$name[2]];?>"
                                                                   type="text"
                                                                   maxlength="3"
                                                                   readonly 
                                                                /> 
                                                        </center>
                                                    </td>
                                                    <?php endfor; ?>
                                                    <td>
                                                        <center><input type="text" class="form-control"
                                                                name="comment_<?php echo $row['mark_daily_id'];?>"
                                                                value="<?php echo $row['comment'];?>"></center>
                                                    </td>
                                                </tr>
                                                <?php endforeach;?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php if($can_edit){ echo form_close();}?>
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
<script>
    function edit_daily_marks(form_id){
        
        var student_id = document.getElementById("student_id").value;
        var unit_id = document.getElementById("unit_id").value;
        var mark_date = document.getElementById("mark_date").value;
        var count = 0; 

        if(student_id != '') { count++; }
        if(unit_id != '') { count++; }
        if(mark_date != '') { count++; }

        if(count > 0)
        {
            $("#update_daily_marks_batch :button").attr("disabled", false);
            $("#update_daily_marks_batch :input").attr("readonly", false);
        }
        else{
            Swal.fire({
                icon: 'error',
                title: '<?= getPhrase('error')?>',
                text: 'You have to select one of the following options: student, unit or date.',
            })
        }

    }

    function add_daily_marks(data) {
        var student_id = document.getElementById("student_id").value;
        var unit_id = document.getElementById("unit_id").value;
        var mark_date = document.getElementById("mark_date").value;
        
        console.log('entra');

        if(unit_id == '' || mark_date == '' ){
            Swal.fire({
                icon: 'error',
                title: '<?= getPhrase('error')?>',
                text: 'You need select a unit and date.',
            })
        }else{
            if(student_id=='')
                student_id = 'none';

            var URL = '<?php echo base_url();?>teacher/add_daily_marks/' + student_id + '/' + unit_id + '/' + mark_date + '/' + data;
            console.log(URL);
            
            $.ajax({
                url: URL,
                success: function(response) {
                    location.reload(); 
                }
            });
        }
    }
       
</script>
<?php endforeach;?>
