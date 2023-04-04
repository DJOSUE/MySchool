<?php 
    // $admin_type = $this->db->get_where('admin', array('admin_id' => get_login_user_id()))->row()->owner_status;
    $admin_id = get_login_user_id();
    $role_id = get_role_id();

    $admin_type = $role_id;
?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="all-wrapper no-padding-content solid-bg-all">
            <div class="layout-w">
                <div class="content-w">
                    <div class="content-i">
                        <div class="content-box">
                            <div class="app-email-w">
                                <div class="app-email-i">
                                    <div class="ae-content-w grbg">
                                        <div class="top-header top-header-favorit">
                                            <div class="top-header-thumb">
                                                <img src="<?= base_url();?>public/uploads/bglogin.jpg" alt="nature"
                                                    class="bgcover">
                                                <div class="top-header-author">
                                                    <div class="author-thumb">
                                                        <img src="<?= base_url();?>public/uploads/<?= $this->crud->getInfo('logo');?>"
                                                            alt="author" class="authorCv">
                                                    </div>
                                                    <div class="author-content">
                                                        <a href="javascript:void(0);"
                                                            class="h3 author-name"><?= getPhrase('users');?></a>
                                                        <div class="country">
                                                            <?= $this->crud->getInfo('system_name');?> |
                                                            <?= $this->crud->getInfo('system_title');?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="profile-section" style="background-color: #fff;">
                                                <div class="control-block-button"></div>
                                            </div>
                                        </div>
                                        <div class="aec-full-message-w">
                                            <div class="aec-full-message">
                                                <div class="container-fluid grbg"><br>
                                                    <div class="col-sm- 12">
                                                        <div class="row">
                                                            <?php if(has_permission('admin_users')) : ?>
                                                            <div
                                                                class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                                <div class="ui-block" data-mh="friend-groups-item">
                                                                    <div class="friend-item friend-groups">
                                                                        <div class="friend-item-content">
                                                                            <div class="friend-avatar">
                                                                                <div class="author-thumb">
                                                                                    <img src="<?= base_url();?>public/uploads/icons/admins.svg"
                                                                                        width="110px"
                                                                                        style="background-color:#fff;padding:15px; border-radius:0px;">
                                                                                </div>
                                                                                <div class="author-content">
                                                                                    <a href="<?= base_url();?>admin/admins/"
                                                                                        class="h5 author-name"><?= getPhrase('admins');?></a>
                                                                                    <div class="country">
                                                                                        <?php
                                                                                        $this->db->reset_query();
                                                                                        $this->db->where('status', '0');
                                                                                        $this->db->from('admin');
                                                                                        echo $this->db->count_all_results();
                                                                                        ?>
                                                                                        <?= getPhrase('admins');?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php endif;?>

                                                            <?php 
                                                            if(has_permission('advisor_users')) : 
                                                                $this->db->reset_query();
                                                                $this->db->where('table', 'admin');
                                                                $this->db->where_not_in('role_id', array('1','2'));
                                                                $admins = $this->db->get('roles')->result_array();
                                                                
                                                                foreach($admins as $admin):    
                                                            ?>

                                                            <div
                                                                class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                                <div class="ui-block" data-mh="friend-groups-item">
                                                                    <div class="friend-item friend-groups">
                                                                        <div class="friend-item-content">
                                                                            <div class="friend-avatar">
                                                                                <div class="author-thumb">
                                                                                    <img src="<?= base_url();?>public/uploads/icons/admins.svg"
                                                                                        width="110px"
                                                                                        style="background-color:#fff;padding:15px; border-radius:0px;">
                                                                                </div>
                                                                                <div class="author-content">
                                                                                    <a href="<?= base_url().'admin/admins/'.base64_encode($admin['role_id']);?>"
                                                                                        class="h5 author-name"><?= $admin['name'];?></a>
                                                                                    <div class="country">
                                                                                        <?php 
                                                                                        $this->db->reset_query();
                                                                                        $this->db->where('status', '1');
                                                                                        $this->db->where('owner_status', $admin['role_id']);
                                                                                        $this->db->from('admin');
                                                                                        echo $this->db->count_all_results();
                                                                                        ?>
                                                                                        <?= $admin['name'];?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php endforeach;?>
                                                            <?php endif;?>
                                                            <?php if(has_permission('teacher_users')) : ?>
                                                            <div
                                                                class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                                <div class="ui-block" data-mh="friend-groups-item">
                                                                    <div class="friend-item friend-groups">
                                                                        <div class="friend-item-content">
                                                                            <div class="friend-avatar">
                                                                                <div class="author-thumb">
                                                                                    <img src="<?= base_url();?>public/uploads/icons/teachers.svg"
                                                                                        width="110px"
                                                                                        style="background-color:#fff;padding:15px;border-radius:0px;">
                                                                                </div>
                                                                                <div class="author-content">
                                                                                    <a href="<?= base_url();?>admin/teachers/"
                                                                                        class="h5 author-name"><?= getPhrase('teachers');?></a>
                                                                                    <div class="country">
                                                                                        <?= $this->db->count_all_results('teacher');?>
                                                                                        <?= getPhrase('teachers');?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php endif;?>
                                                            <?php if(has_permission('student_users')) : ?>
                                                            <div
                                                                class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                                <div class="ui-block" data-mh="friend-groups-item">
                                                                    <div class="friend-item friend-groups">
                                                                        <div class="friend-item-content">
                                                                            <div class="friend-avatar">
                                                                                <div class="author-thumb">
                                                                                    <img src="<?= base_url();?>public/uploads/icons/students.svg"
                                                                                        width="110px"
                                                                                        style="background-color:#fff;padding:15px; border-radius:0px;">
                                                                                </div>
                                                                                <div class="author-content">
                                                                                    <a href="<?= base_url();?>admin/students/"
                                                                                        class="h5 author-name"><?= getPhrase('students');?></a>
                                                                                    <div class="country">
                                                                                        <?= $this->db->count_all_results('student');?>
                                                                                        <?= getPhrase('students');?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php endif;?>                                                            
                                                            <?php if(has_permission('accountant_users')) : ?>
                                                            <div
                                                                class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                                <div class="ui-block" data-mh="friend-groups-item">
                                                                    <div class="friend-item friend-groups">
                                                                        <div class="friend-item-content">
                                                                            <div class="friend-avatar">
                                                                                <div class="author-thumb">
                                                                                    <img src="<?= base_url();?>public/uploads/icons/accountant.svg"
                                                                                        width="110px"
                                                                                        style="background-color:#fff;padding:15px; border-radius:0px;">
                                                                                </div>
                                                                                <div class="author-content">
                                                                                    <a href="<?= base_url();?>admin/accountant/"
                                                                                        class="h5 author-name"><?= getPhrase('accountants');?></a>
                                                                                    <div class="country">
                                                                                        <?= $this->db->count_all_results('accountant');?>
                                                                                        <?= getPhrase('accountants');?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php endif;?>
                                                            <?php if(has_permission('librarian_users')) : ?>
                                                            <div
                                                                class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                                <div class="ui-block" data-mh="friend-groups-item">
                                                                    <div class="friend-item friend-groups">
                                                                        <div class="friend-item-content">
                                                                            <div class="friend-avatar">
                                                                                <div class="author-thumb">
                                                                                    <img src="<?= base_url();?>public/uploads/icons/librarian.svg"
                                                                                        width="110px"
                                                                                        style="background-color:#fff;padding:15px; border-radius:0px;">
                                                                                </div>
                                                                                <div class="author-content">
                                                                                    <a href="<?= base_url();?>admin/librarian/"
                                                                                        class="h5 author-name"><?= getPhrase('librarians');?></a>
                                                                                    <div class="country">
                                                                                        <?= $this->db->count_all_results('librarian');?>
                                                                                        <?= getPhrase('librarians');?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php endif;?>
                                                            <?php if($this->db->get_where('settings', array('type' => 'register'))->row()->description == 1):?>
                                                            <div
                                                                class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                                <div class="ui-block" data-mh="friend-groups-item">
                                                                    <div class="friend-item friend-groups">
                                                                        <div class="friend-item-content">
                                                                            <div class="friend-avatar">
                                                                                <div class="author-thumb">
                                                                                    <img src="<?= base_url();?>public/uploads/icons/pendings.svg"
                                                                                        width="110px"
                                                                                        style="background-color:#fff;padding:15px; border-radius:0px;">
                                                                                </div>
                                                                                <div class="author-content">
                                                                                    <a href="<?= base_url();?>admin/pending/"
                                                                                        class="h5 author-name"><?= getPhrase('pending_users');?></a>
                                                                                    <div class="country">
                                                                                        <?= $this->db->count_all_results('pending_users');?>
                                                                                        <?= getPhrase('pending');?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php endif;?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="display-type"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="access_admin" tabindex="-1" role="dialog" aria-labelledby="access_admin" aria-hidden="true">
    <div class="modal-dialog window-popup edit-my-poll-popup" role="document">
        <div class="modal-content">
            <?= form_open(base_url() . 'admin/users/permissions/' , array('enctype' => 'multipart/form-data'));?>
            <a href="javascript:void(0);" class="close icon-close" data-dismiss="modal" aria-label="Close"></a>
            <div class="modal-header" style="background-color:#00579c">
                <h6 class="title" style="color:white"><?= getPhrase('admin_permissions');?></h6>
            </div>
            <div class="ui-block-title ui-block-title-small">
                <h6 class="title"><?= getPhrase('admin');?></h6>
            </div>
            <div class="modal-body">
                <div class="ui-block-content">
                    <div class="row">
                        <div class="input-group">
                            <div class="select">
                                <select name="role_id" required="" style="width: 150px;">
                                    <?php
                                $roles = $this->db->get('roles')->result_array();
                                foreach($roles as $role):
                                ?>
                                    <option value="<?= $role['status_id']?>"
                                        <?= $role['role_id'] == $row['role_id'] ? 'selected': ''; ?>>
                                        <?= $role['name']?>
                                    </option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="messages" value="1"
                                        <?php if($this->db->get_where('account_role', array('type' => 'messages'))->row()->permissions == 1) echo "checked";?>><?= getPhrase('messages');?>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="admins" value="1"
                                        <?php if($this->db->get_where('account_role', array('type' => 'admins'))->row()->permissions == 1) echo "checked";?>>
                                    <?= getPhrase('admins');?>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="parents" value="1"
                                        <?php if($this->db->get_where('account_role', array('type' => 'parents'))->row()->permissions == 1) echo "checked";?>><?= getPhrase('parents');?>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="teachers" value="1"
                                        <?php if($this->db->get_where('account_role', array('type' => 'teachers'))->row()->permissions == 1) echo "checked";?>><?= getPhrase('teachers');?>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="students" value="1"
                                        <?php if($this->db->get_where('account_role', array('type' => 'students'))->row()->permissions == 1) echo "checked";?>><?= getPhrase('students');?>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="accountants" value="1"
                                        <?php if($this->db->get_where('account_role', array('type' => 'accountants'))->row()->permissions == 1) echo "checked";?>><?= getPhrase('accountants');?>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="librarians" value="1"
                                        <?php if($this->db->get_where('account_role', array('type' => 'librarians'))->row()->permissions == 1) echo "checked";?>><?= getPhrase('librarians');?>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="library" value="1"
                                        <?php if($this->db->get_where('account_role', array('type' => 'library'))->row()->permissions == 1) echo "checked";?>><?= getPhrase('library');?>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="academic" value="1"
                                        <?php if($this->db->get_where('account_role', array('type' => 'academic'))->row()->permissions == 1) echo "checked";?>><?= getPhrase('academic');?>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="attendance" value="1"
                                        <?php if($this->db->get_where('account_role', array('type' => 'attendance'))->row()->permissions == 1) echo "checked";?>><?= getPhrase('attendance');?>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="calendar" value="1"
                                        <?php if($this->db->get_where('account_role', array('type' => 'calendar'))->row()->permissions == 1) echo "checked";?>><?= getPhrase('calendar');?>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="files" value="1"
                                        <?php if($this->db->get_where('account_role', array('type' => 'files'))->row()->permissions == 1) echo "checked";?>><?= getPhrase('files');?>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="polls" value="1"
                                        <?php if($this->db->get_where('account_role', array('type' => 'polls'))->row()->permissions == 1) echo "checked";?>><?= getPhrase('polls');?>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="notifications" value="1"
                                        <?php if($this->db->get_where('account_role', array('type' => 'notifications'))->row()->permissions == 1) echo "checked";?>><?= getPhrase('notifications');?>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="admissions" value="1"
                                        <?php if($this->db->get_where('account_role', array('type' => 'admissions'))->row()->permissions == 1) echo "checked";?>><?= getPhrase('admissions');?>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="behavior" value="1"
                                        <?php if($this->db->get_where('account_role', array('type' => 'behavior'))->row()->permissions == 1) echo "checked";?>><?= getPhrase('behavior');?>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="news" value="1"
                                        <?php if($this->db->get_where('account_role', array('type' => 'news'))->row()->permissions == 1) echo "checked";?>><?= getPhrase('news');?>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="school_bus" value="1"
                                        <?php if($this->db->get_where('account_role', array('type' => 'school_bus'))->row()->permissions == 1) echo "checked";?>><?= getPhrase('school_bus');?>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="classrooms" value="1"
                                        <?php if($this->db->get_where('account_role', array('type' => 'classrooms'))->row()->permissions == 1) echo "checked";?>><?= getPhrase('classrooms');?>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="accounting" value="1"
                                        <?php if($this->db->get_where('account_role', array('type' => 'accounting'))->row()->permissions == 1) echo "checked";?>><?= getPhrase('accounting');?>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="schedules" value="1"
                                        <?php if($this->db->get_where('account_role', array('type' => 'schedules'))->row()->permissions == 1) echo "checked";?>><?= getPhrase('schedules');?>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="system_reports" value="1"
                                        <?php if($this->db->get_where('account_role', array('type' => 'system_reports'))->row()->permissions == 1) echo "checked";?>><?= getPhrase('system_reports');?>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="academic_settings" value="1"
                                        <?php if($this->db->get_where('account_role', array('type' => 'academic_settings'))->row()->permissions == 1) echo "checked";?>><?= getPhrase('academic_settings');?>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="settings" value="1"
                                        <?php if($this->db->get_where('account_role', array('type' => 'settings'))->row()->permissions == 1) echo "checked";?>><?= getPhrase('settings');?>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ui-block-title ui-block-title-small">
                <h6 class="title"><?= getPhrase('super_admin');?></h6>
            </div>
            <div class="modal-body">
                <div class="ui-block-content">
                    <div class="row">
                        <div class="col-sm-12">
                            <?= getPhrase('all_permissions');?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit"
                    class="btn btn-rounded btn-success btn-lg full-width"><?= getPhrase('save');?></button>
            </div>
            <?= form_close();?>
        </div>
    </div>
</div>

<script type="text/javascript">
function get_class_sections(class_id) {
    $.ajax({
        url: '<?= base_url();?>admin/get_class_section/' + class_id,
        success: function(response) {
            jQuery('#section_selector_holder').html(response);
        }
    });
}

function get_class_sections2(class_id) {
    $.ajax({
        url: '<?= base_url();?>admin/get_class_section/' + class_id,
        success: function(response) {
            jQuery('#section_selector_holder2').html(response);
        }
    });
}
</script>