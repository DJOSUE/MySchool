    <div class="content-w">
        <?php include 'fancy.php';?>
        <div class="header-spacer"></div>
        <div class="conty">
            <div class="os-tabs-w menu-shad">
                <div class="os-tabs-controls">
                    <ul class="navs navs-tabs upper">
                        <li class="navs-item">
                            <a class="navs-links active" href="<?php echo base_url();?>admin/academic_settings/"><i
                                    class="os-icon picons-thin-icon-thin-0006_book_writing_reading_read_manual"></i><span><?php echo getPhrase('academic_settings'); ?></span></a>
                        </li>
                        <li class="navs-item">
                            <a class="navs-links" href="<?php echo base_url();?>admin/grade/"><i
                                    class="os-icon picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i><span><?php echo getPhrase('grades'); ?></span></a>
                        </li>
                        <li class="navs-item">
                            <a class="navs-links" href="<?php echo base_url();?>admin/gpa/"><i
                                    class="os-icon picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i><span><?php echo getPhrase('gpa_level'); ?></span></a>
                        </li>
                        <li class="navs-item">
                            <a class="navs-links" href="<?php echo base_url();?>admin/semesters/"><i
                                    class="os-icon picons-thin-icon-thin-0007_book_reading_read_bookmark"></i><span><?php echo getPhrase('semesters'); ?></span></a>
                        </li>
                        <li class="navs-item">
                            <a class="navs-links" href="<?php echo base_url();?>admin/units/"><i
                                    class="os-icon picons-thin-icon-thin-0007_book_reading_read_bookmark"></i><span><?php echo getPhrase('units'); ?></span></a>
                        </li>                        
                        <li class="navs-item">
                            <a class="navs-links" href="<?php echo base_url();?>admin/sections/"><i
                                    class="os-icon picons-thin-icon-thin-0002_write_pencil_new_edit"></i><span><?php echo getPhrase('sections'); ?></span></a>
                        </li>
                        <li class="navs-item">
                            <a class="navs-links" href="<?php echo base_url();?>admin/subjects/"><i
                                    class="os-icon picons-thin-icon-thin-0002_write_pencil_new_edit"></i><span><?php echo getPhrase('subject'); ?></span></a>
                        </li>
                        <!-- <li class="navs-item">
                            <a class="navs-links" href="<?php echo base_url();?>admin/student_promotion/"><i
                                    class="os-icon picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i><span><?php echo getPhrase('student_promotion'); ?></span></a>
                        </li> -->
                    </ul>
                </div>
            </div>
            <div class="content-i">
                <div class="content-box">
                    <div class="col-sm-12">
                        <div class="element-box lined-primary shadow">
                            <h5 class="form-header"><?php echo getPhrase('academic_settings');?></h5><br>
                            <?php echo form_open(base_url() . 'admin/academic_settings/do_update' , array('target'=>'_top'));?>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group label-floating is-select">
                                        <label class="control-label"><?php echo getPhrase('running_year');?></label>
                                        <div class="select">
                                            <select name="running_year" required="">
                                                <?php 
                                                    $running_year = $this->crud->getInfo('running_year');
                                                    $years = $this->crud->get_years(1);
                                                    foreach($years as $year):
                                                ?>
                                                    <option value="<?= $year['year'];?>" <?php if($running_year == $year['year']) echo 'selected';?>><?= $year['year'];?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group label-floating is-select">
                                        <label class="control-label"><?php echo getPhrase('running_semester');?></label>
                                        <div class="select">
                                            <select name="running_semester" required="">
                                                <?php 
                                                    $running_semester = $this->crud->getInfo('running_semester');
                                                    $semesters = $this->crud->get_periods(1);
                                                    foreach($semesters as $semester):
                                                ?>
                                                    <option value="<?= $semester['semester_id'];?>" <?php if($running_semester == $semester['semester_id']) echo 'selected';?>><?= $semester['name'];?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="description-toggle">
                                        <div class="description-toggle-content">
                                            <label><?php echo getPhrase('enable_teacher_reports'); ?></label>
                                        </div>
                                        <div class="togglebutton">
                                            <label><input name="report_teacher" value="1" type="checkbox"
                                                    <?php if($this->crud->getInfo('students_reports') == 1) echo "checked";?>></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="description-toggle">
                                        <div class="description-toggle-content">
                                            <label><?php echo getPhrase('enable_sundays_schedules'); ?></label>
                                        </div>
                                        <div class="togglebutton">
                                            <label><input name="routine" value="1" type="checkbox"
                                                    <?php if($this->academic->getInfo('routine') == 1) echo 'checked';?>></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo getPhrase('minimum_mark'); ?></label>
                                        <input class="form-control" name="minium_mark" type="text" required=""
                                            value="<?php echo $this->academic->getInfo('minium_mark');?>">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group label-floating">
                                        <label><?php echo getPhrase('terms_conditions'); ?></label>
                                        <textarea class="form-control" name="terms"
                                            id="ckeditor1"><?php echo $this->academic->getInfo('terms');?></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-buttons-w">
                                <button class="btn btn-rounded btn-success" type="submit">
                                    <?php echo getPhrase('update');?></button>
                            </div>
                            <?php echo form_close();?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>