<?php  
    $semester_enroll = $this->db->get_where('semester_enroll' , array('semester_enroll_id' => $semester_enroll_id) )->row_array();

    $year = intval($semester_enroll['year']);
    $semester_id = intval($semester_enroll['semester_id']);

    $modalities = $this->academic->get_modality(); 
    $sections = $this->academic->get_sections($year, $semester_id );
    
?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <?php include 'academic_settings__nav.php'; ?>
        </div>
        <div class="content-i">
            <div class="content-box">
                <br>
                <div class="element-wrapper">
                    <h2 class="element-header">
                        <?= $year .' - '. $this->academic->get_semester_name($semester_id);?>
                    </h2>
                    <div class="element-box-tp">
                        <?php foreach($sections as $section):?>
                        <div class="row">
                            <h4 class="form-header"><?=$section['name'];?></h4><br>
                            <hr />
                        </div>
                        <?php foreach($modalities as $modality):
                                $subjects = $this->academic->get_subjects_by_modality_section($year, $semester_id, $modality['modality_id'], $section['name']);        
                            ?>
                        <div class="content-box">
                            <div class="col-sm-12">
                                <h5 class="form-header"><?=$modality['name'];?></h5><br>
                                <div class="row">
                                    <?php foreach($subjects as $subject):?>
                                    <div class="col-sm-4">
                                        <div class="ui-block list">
                                            <div class="more" style="float:right; margin-right:15px; ">
                                                <i class="icon-options"></i>
                                                <ul class="more-dropdown" style="z-index:999">
                                                    <li><a href="#"
                                                            onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_subject/<?php echo $subject['subject_id'];?>');"><?php echo getPhrase('edit');?></a>
                                                    </li>
                                                    <li><a onClick="return confirm('<?php echo getPhrase('confirm_delete');?>')"
                                                            href="<?php echo base_url();?>admin/subject/delete/<?php echo $subject['subject_id'];?>"><?php echo getPhrase('delete');?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="birthday-item inline-items">
                                                <div class="circle blue"><?=substr($subject['class_name'],0,2);?></div>
                                                &nbsp;&nbsp;&nbsp;
                                                <div class="birthday-author-name">
                                                    <div>
                                                        <b><?php echo getPhrase('class');?>:</b>
                                                        <?php echo $subject['class_name'];?>
                                                    </div>
                                                    <div>
                                                        <b><?php echo getPhrase('section');?>:</b>
                                                        <?php echo $subject['section_name'];?>
                                                    </div>
                                                    <div>
                                                        <b><?php echo getPhrase('name');?>:</b>
                                                        <?php echo $subject['name'];?>
                                                    </div>
                                                    <div>
                                                        <b><?php echo getPhrase('teacher');?>:</b>
                                                        <?php echo $subject['teacher_name'];?>
                                                    </div>
                                                    <div>
                                                        <b><?php echo getPhrase('students');?>:</b>
                                                        <?php 
                                                            $this->db->where('subject_id', $subject['subject_id']); 
                                                            $this->db->group_by('student_id'); 
                                                            echo $this->db->count_all_results('enroll');
                                                        ?>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach;?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach;?>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>