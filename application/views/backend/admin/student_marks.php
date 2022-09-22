<?php 
    $min = $this->db->get_where('academic_settings' , array('type' =>'minium_mark'))->row()->description;
    $running_year = $this->crud->getInfo('running_year');
    $student_info = $this->db->get_where('student' , array('student_id' => $student_id))->result_array(); 
    foreach($student_info as $row):
        $class_id = $this->db->get_where('enroll', array('student_id' => $row['student_id'], 'year' => $running_year))->row()->class_id;
        $section_id = $this->db->get_where('enroll', array('student_id' => $row['student_id'], 'year' => $running_year))->row()->section_id;
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
                                    $exams         = $this->crud->get_exams();
                                    foreach ($student_info as $row1):
                                    foreach ($exams as $row2):
                                ?>
                                <div class="col-sm-12">
                                    <div class="element-box lined-primary">
                                        <h5 class="form-header"><?php echo getPhrase('marks');?><br>
                                            <small><?php echo $row2['name'];?></small></h5>
                                        <div class="table-responsive">
                                            <table class="table table-lightborder">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo getPhrase('subject');?></th>
                                                        <th><?php echo getPhrase('teacher');?></th>
                                                        <th><?php echo getPhrase('mark');?></th>
                                                        <th><?php echo getPhrase('grade');?></th>
                                                        <th><?php echo getPhrase('comment');?></th>
                                                        <th><?php echo getPhrase('view_all');?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        $subjects = $this->db->get_where('subject' , array('class_id' => $class_id, 'section_id' => $section_id))->result_array();
                                                        foreach ($subjects as $row3): 
                                                        $obtained_mark_query = $this->db->get_where('mark' , array('subject_id' => $row3['subject_id'], 'unit_id' => $row2['unit_id'],'class_id' => $class_id, 'student_id' => $student_id, 'year' => $running_year));
                                                        if($obtained_mark_query->num_rows() > 0) 
                                                        {
                                                            $marks = $obtained_mark_query->result_array();
                                                            foreach ($marks as $row4):
                                                        
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $row3['name'];?></td>
                                                        <td><img alt="" src="" width="25px"
                                                                style="border-radius: 10px;margin-right:5px;">
                                                            <?php echo $this->crud->get_name('teacher', $row3['teacher_id']); ?>
                                                        </td>
                                                        <td>
                                                            <?php $mark = $this->db->get_where('mark' , array('subject_id' => $row3['subject_id'], 'unit_id' => $row2['unit_id'], 'student_id' => $student_id, 'year' => $running_year))->row()->mark_obtained;?>
                                                            <?php if($mark < $min || $mark == 0):?>
                                                            <a class="btn btn-rounded btn-sm btn-danger"
                                                                style="color:white"><?php if($this->db->get_where('mark' , array('subject_id' => $row3['subject_id'], 'unit_id' => $row2['unit_id'], 'student_id' => $student_id, 'year' => $running_year))->row()->mark_obtained == 0) echo '0'; else echo $mark;?></a>
                                                            <?php endif;?>
                                                            <?php if($mark >= $min):?>
                                                            <a class="btn btn-rounded btn-sm btn-info"
                                                                style="color:white"><?php echo $this->db->get_where('mark' , array('subject_id' => $row3['subject_id'], 'unit_id' => $row2['unit_id'], 'student_id' => $student_id, 'year' => $running_year))->row()->mark_obtained;?></a>
                                                            <?php endif;?>
                                                        </td>
                                                        <td><?php echo $grade = $this->crud->get_grade($this->db->get_where('mark' , array('subject_id' => $row3['subject_id'], 'unit_id' => $row2['unit_id'], 'student_id' => $student_id, 'year' => $running_year))->row()->mark_obtained);?>
                                                        </td>
                                                        <td><?php echo $this->db->get_where('mark' , array('subject_id' => $row3['subject_id'], 'unit_id' => $row2['unit_id'], 'student_id' => $student_id, 'year' => $running_year))->row()->comment; ?>
                                                        </td>
                                                        <?php $data = base64_encode($row2['unit_id']."-".$student_id."-".$row3['subject_id']); ?>
                                                        <td><a class="btn btn-rounded btn-sm btn-primary"
                                                                style="color:white"
                                                                href="<?php echo base_url();?>admin/subject_marks/<?php echo $data;?>"><?php echo getPhrase('view_all');?></a>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach;} endforeach;?>
                                                </tbody>
                                            </table>
                                            <div class="form-buttons-w text-right">
                                                <a target="_blank"
                                                    href="<?php echo base_url();?>admin/marks_print_view/<?php echo $student_id;?>/<?php echo $row2['unit_id'];?>"><button
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
                    </main>
                    <?php include 'student_area_menu.php';?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach;?>