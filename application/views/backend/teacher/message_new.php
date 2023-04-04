<?php 
    $teacher_id = get_login_user_id();

    $running_year       = $this->crud->getInfo('running_year');
    $running_semester   = $this->crud->getInfo('running_semester');

    $teachers = $this->user->get_teachers();

    $admins = $this->user->get_advisor();

    $students = $this->user->get_students_by_teacher($teacher_id);

    // echo '<pre>';
    // var_dump($students);
    // echo '</pre>';

?>
<div class="full-chat-middle">
    <div class="chat -head">
        <div class="row">
            <div class="col-sm-12">
                <?= form_open(base_url() . 'teacher/message/send_new/', array('class' => 'form', 'enctype' => 'multipart/form-data')); ?>
                <div class="form-group label-floating is-select">
                    <label class="control-label"><?= getPhrase('receiver');?></label>
                    <div class="select">
                        <select name="reciever" id="slct" required="">
                            <option value=""><?= getPhrase('select');?></option>
                            <optgroup label="<?= getPhrase('students');?>">
                                <?php
                                    foreach ($students as $row):
                                ?>
                                <option value="student-<?= $row['student_id']; ?>"
                                    <?php if($usertype == 'student' && $user_id == $row['student_id']) echo 'selected';?>>
                                    <?= $row['full_name'] ?>
                                </option>
                                <?php endforeach; ?>
                            </optgroup>
                            <optgroup label="<?= getPhrase('teachers');?>">
                                <?php 
                                    foreach ($teachers as $row):
                                ?>
                                <option value="teacher-<?= $row['teacher_id']; ?>"
                                    <?php if($usertype == 'teacher' && $user_id == $row['teacher_id']) echo 'selected';?>>
                                    <?= $row['first_name'] .' '. $row['last_name'] ?>
                                </option>
                                <?php endforeach; ?>
                            </optgroup>
                            <optgroup label="<?= getPhrase('advisors');?>">
                                <?php 
                                    foreach ($admins as $advisor):
                                ?>
                                <option value="admin-<?= $advisor['admin_id']; ?>"
                                    <?php if($usertype == 'admin' && $user_id == $advisor['admin_id']) echo 'selected';?>>
                                    <?= $advisor['first_name'] . ' ' . $advisor['last_name']?>
                                </option>
                                <?php endforeach; ?>
                            </optgroup>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="chat-content-w">
        <div class="chat-content"></div>
    </div>
    <div class="chat-controls b-b">
        <div class="chat-input">
            <input placeholder="<?= getPhrase('write_message');?>..." type="text" name="message" required="">
        </div>
        <div class="chat-input-extra">
            <div class="chat-extra-actions">
                <input type="file" name="file_name" id="file-3" class="inputfile inputfile-3" style="display:none" />
                <label for="file-3"><i class="os-icon picons-thin-icon-thin-0042_attachment"></i>
                    <span><?= getPhrase('send_file');?>...</span></label>
            </div>
            <div class="chat-btn">
                <button class="btn btn-rounded btn-primary" type="submit"><?= getPhrase('send');?></button>
            </div>
        </div>
    </div>
    <?= form_close();?>
</div>