    <div class="content-w">
       <div class="conty">
           <?php 
                $dat = base64_decode($data);
                $ex = explode('-',$dat);
            ?>
            <?php include 'fancy.php';?>
            <div class="header-spacer"></div>
            <div class="os-tabs-w menu-shad">
                <div class="os-tabs-controls">
                    <?php include 'subject__nav.php';?>
                </div>
            </div>
            <div class="content-i">
                <div class="content-box">
                    <div class="col-lg-12">   
                        <div class="back hidden-sm-down" style="margin-top:-20px;margin-bottom:10px">   
                            <a href="<?php echo base_url();?>teacher/online_exams/<?php echo $data;?>/"><i class="picons-thin-icon-thin-0131_arrow_back_undo"></i></a>  
                        </div>  
                        <div class="element-wrapper"> 
                            <div class="element-box lined-primary shadow">
                                <div class="modal-header">
                                    <h5 class="modal-title"><?php echo getPhrase('new_exam');?></h5>
                                </div>
                                <br>
                                <?php echo form_open(base_url() . 'teacher/create_online_exam/'.$data, array('enctype' => 'multipart/form-data')); ?>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label" for=""><?php echo getPhrase('title');?></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="exam_title" required="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label" for=""><?php echo getPhrase('date');?></label>
                                                <div class="input-group">
                                                    <input type='text' class="datepicker-here" data-position="top left" data-language='en' name="exam_date" data-multiple-dates-separator="/"/>
                                                </div>    
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="col-form-label" for=""><?php echo getPhrase('start_time');?></label>
                                                <div class="input-group clockpicker" data-align="top" data-autoclose="true">
                                                    <input type="text" required="" name="time_start" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="col-form-label" for=""><?php echo getPhrase('end_time');?></label>
                                                <div class="input-group clockpicker" data-align="top" data-autoclose="true">
                                                    <input type="text" required="" name="time_end" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="col-form-label" for=""><?php echo getPhrase('percentage_required');?></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="minimum_percentage">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="col-form-label" for=""><?php echo getPhrase('password');?></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="password">
                                                </div>
                                                <small><?php echo getPhrase('optional');?></small>
                                            </div>
                                        </div>
                                        <div class="col-sm-4"><br>
                                            <div class="form-group is-select">
                                                <label class="control-label"><?php echo getPhrase('show_results');?></label>
                                                <div class="select">
                                                    <select name="results" required="">
                                                        <option value=""><?php echo getPhrase('select');?></option>
                                                        <option value="1"><?php echo getPhrase('keep_hidden');?></option>
                                                        <option value="2"><?php echo getPhrase('show_when_exam_is_finished');?></option>
                                                        <option value="3"><?php echo getPhrase('15_minutes_after_finished');?></option>
                                                        <option value="4"><?php echo getPhrase('30_minutes_after_finished');?></option> 
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="description-toggle">
                                                <div class="description-toggle-content">
                                                    <label><?php echo getPhrase('show_questions_randomly'); ?></label>
                                                </div>
                                                <div class="togglebutton">
                                                    <label><input name="show_random" value="1" type="checkbox"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label" for=""><?php echo getPhrase('description');?></label>
                                                <textarea class="form-control" name="instruction" id="ckeditorEmail"></textarea>
                                            </div>
                                        </div>
                                        <input type="hidden" value="<?php echo $ex[0];?>" name="class_id">
                                        <input type="hidden" value="<?php echo $ex[1];?>" name="section_id">
                                        <input type="hidden" value="<?php echo $ex[2];?>" name="subject_id">
                                        <div class="form-group">
                                            <div class="col-sm-12" style="text-align: center;">
                                                <button type="submit" class="btn btn-success"><?php echo getPhrase('save');?></button>
                                            </div>
                                        </div>
                                    </div>
                                <?php echo form_close();?>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div>