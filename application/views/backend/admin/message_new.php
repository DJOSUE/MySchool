    <div class="full-chat-middle">
        <?= form_open(base_url() . 'admin/message/send_new/', array('class' => 'form', 'enctype' => 'multipart/form-data')); ?>
        <div class="chat -head">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group label-floating is-select">
                        <label class="control-label"><?= getPhrase('receiver');?></label>
                        <div class="select">
                            <select name="reciever" id="slct" required="">
                                <option value=""><?= getPhrase('select');?></option>
                                <optgroup label="<?= getPhrase('admins');?>">
                                    <?php
                                        $admins = $this->db->get('admin')->result_array();
                                        foreach ($admins as $row):
                                    ?>
                                    <?php if(get_login_user_id() != $row['admin_id']):?>
                                    <option value="admin-<?= $row['admin_id']; ?>">
                                        <?= $this->crud->get_name('admin',$row['admin_id']);?></option>
                                    <?php endif;?>
                                    <?php endforeach; ?>
                                </optgroup>
                                <optgroup label="<?= getPhrase('teachers');?>">
                                    <?php
                                        $teachers = $this->db->get('teacher')->result_array();
                                        foreach ($teachers as $row):
                                    ?>
                                    <option value="teacher-<?= $row['teacher_id']; ?>">
                                        <?= $this->crud->get_name('teacher',$row['teacher_id']);?></option>
                                    <?php endforeach; ?>
                                </optgroup>
                                <optgroup label="<?= getPhrase('parents');?>">
                                    <?php
                                        $parents = $this->db->get('parent')->result_array();
                                        foreach ($parents as $row):
                                    ?>
                                    <option value="parent-<?= $row['parent_id']; ?>">
                                        <?= $this->crud->get_name('parent',$row['parent_id']);?></option>
                                    <?php endforeach; ?>
                                </optgroup>
                                <optgroup label="<?= getPhrase('students');?>">
                                    <?php
                                        $students = $this->db->get('student')->result_array();
                                        foreach ($students as $row):
                                    ?>
                                    <option value="student-<?= $row['student_id']; ?>">
                                        <?= $this->crud->get_name('student',$row['student_id']);?></option>
                                    <?php endforeach; ?>
                                </optgroup>
                                <optgroup label="<?= getPhrase('librarians');?>">
                                    <?php
                                        $librarian = $this->db->get('librarian')->result_array();
                                        foreach ($librarian as $row):
                                    ?>
                                    <option value="librarian-<?= $row['librarian_id']; ?>">
                                        <?= $this->crud->get_name('librarian',$row['librarian_id']);?></option>
                                    <?php endforeach; ?>
                                </optgroup>
                                <optgroup label="<?= getPhrase('accountants');?>">
                                    <?php
                                        $accountant = $this->db->get('accountant')->result_array();
                                        foreach ($accountant as $row):
                                    ?>
                                    <option value="accountant-<?= $row['accountant_id']; ?>">
                                        <?= $this->crud->get_name('accountant',$row['accountant_id']);?></option>
                                    <?php endforeach; ?>
                                </optgroup>
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
                    <input type="file" name="file_name" id="file-3" class="inputfile inputfile-3"
                        style="display:none" />
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