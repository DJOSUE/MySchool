    <div class="content-w">
        <?php include 'fancy.php';?>
        <div class="header-spacer"></div>
        <div class="conty">
            <div class="os-tabs-w menu-shad">
                <?php include 'academic_settings_nav.php'; ?>
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