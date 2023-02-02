<?php 
    $student_id = $this->session->userdata('login_user_id');
?>
<div class="full-chat-middle">
    <?= form_open(base_url() . 'student/message/send_new/', array('class' => 'form', 'enctype' => 'multipart/form-data')); ?>
    <div class="chat -head">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group label-floating is-select">
                    <label class="control-label"><?= getPhrase('receiver');?></label>
                    <div class="select">
                        <select name="reciever" id="slct" required="">
                            <option value=""><?= getPhrase('select');?></option>
                            <optgroup label="<?= getPhrase('advisors');?>">
                                <?php
                                        $admins = $this->user->get_advisor();
                                        foreach ($admins as $advisor):
                                    ?>
                                <option value="admin-<?= $advisor['admin_id']; ?>"
                                    <?php if($usertype == 'admin' && $user_id == $advisor['admin_id']) echo 'selected';?>>
                                    <?= $advisor['first_name'] . ' ' . $advisor['last_name']?>
                                </option>
                                <?php endforeach; ?>
                            </optgroup>
                            <optgroup label="<?= getPhrase('teachers');?>">
                                <?php
                                        $teachers = $this->academic->get_teachers_by_student($student_id);
                                        foreach ($teachers as $teacher):
                                    ?>
                                <option value="teacher-<?= $teacher['teacher_id']; ?>"
                                    <?php if($usertype == 'teacher' && $user_id == $teacher['teacher_id']) echo 'selected';?>>
                                    <?= $teacher['teacher_name'] ?>
                                </option>
                                <?php endforeach; ?>
                            </optgroup>
                            <!-- <optgroup label="<?= getPhrase('students');?>">
                                    <?php
                                        $students = $this->db->get('student')->result_array();
                                        foreach ($students as $row):
                                    ?>
                                    <option value="student-<?= $row['student_id']; ?>"
                                        <?php if($usertype == 'student' && $user_id == $row['student_id']) echo 'selected';?>>
                                        <?= $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->first_name." ".$this->db->get_where('student', array('student_id' => $row['student_id']))->row()->last_name; ?>
                                    </option>
                                    <?php endforeach; ?>
                                </optgroup> -->
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="chat-content-w">
        <div class="chat-content">
        </div>
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