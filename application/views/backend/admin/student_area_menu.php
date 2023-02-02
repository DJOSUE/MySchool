<div class="col col-xl-3 order-xl-1 col-lg-12 order-lg-2 col-md-12 col-sm-12 col-12">
    <div class="eduappgt-sticky-sidebar">
        <div class="sidebar__inner">
            <div class="ui-block paddingtel">
                <div class="ui-block-content">
                    <div class="widget w-about">
                        <a href="javascript:void(0);" class="logo"><img
                                src="<?= base_url();?>public/uploads/<?= $this->crud->getInfo('logo');?>"></a>
                        <ul class="socials">
                            <li><a class="socialDash fb" href="<?= $this->crud->getInfo('facebook');?>"><i
                                        class="fab fa-facebook-square" aria-hidden="true"></i></a>
                            </li>
                            <li><a class="socialDash tw" href="<?= $this->crud->getInfo('twitter');?>"><i
                                        class="fab fa-twitter" aria-hidden="true"></i></a></li>
                            <li><a class="socialDash yt" href="<?= $this->crud->getInfo('youtube');?>"><i
                                        class="fab fa-youtube" aria-hidden="true"></i></a></li>
                            <li><a class="socialDash ig" href="<?= $this->crud->getInfo('instagram');?>"><i
                                        class="fab fa-instagram" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="ui-block paddingtel">
                <div class="ui-block-content">
                    <div class="help-support-block">
                        <h3 class="title"><?= getPhrase('quick_links');?></h3>
                        <ul class="help-support-list">
                            <li <?= $page_name == 'student_portal' ? 'class="menu-left-selected-icon"' : ''?>>
                                <i class="picons-thin-icon-thin-0133_arrow_right_next" style="font-size:20px;"></i>
                                &nbsp;&nbsp;&nbsp;
                                <a href="<?= base_url();?>admin/student_portal/<?= $student_id;?>/">
                                    <?= getPhrase('personal_information');?>
                                </a>
                            </li>
                            <li <?= $page_name == 'student_update' ? 'class="menu-left-selected-icon"' : ''?>>
                                <i class="picons-thin-icon-thin-0133_arrow_right_next" style="font-size:20px"></i>
                                &nbsp;&nbsp;&nbsp;
                                <a href="<?= base_url();?>admin/student_update/<?= $student_id;?>/">
                                    <?= getPhrase('update_information');?>
                                </a>
                            </li>
                            <li <?= $page_name == 'student_update_class' ? 'class="menu-left-selected-icon"' : ''?>>
                                <i class="picons-thin-icon-thin-0133_arrow_right_next" style="font-size:20px"></i>
                                &nbsp;&nbsp;&nbsp;
                                <a href="<?= base_url();?>admin/student_update_class/<?= $student_id;?>/">
                                    <?= getPhrase('change_level');?>
                                </a>
                            </li>
                            <li <?= $page_name == 'student_enrollments' ? 'class="menu-left-selected-icon"' : ''?>>
                                <i class="picons-thin-icon-thin-0133_arrow_right_next" style="font-size:20px"></i>
                                &nbsp;&nbsp;&nbsp;
                                <a href="<?= base_url();?>admin/student_enrollments/<?= $student_id;?>/">
                                    <?= getPhrase('student_enrollments');?>
                                </a>
                            </li>
                            <li
                                <?= $page_name == 'student_placement_achievement' ? 'class="menu-left-selected-icon"' : ''?>>
                                <i class="picons-thin-icon-thin-0133_arrow_right_next" style="font-size:20px"></i>
                                &nbsp;&nbsp;&nbsp;
                                <a href="<?= base_url();?>admin/student_placement_achievement/<?= $student_id;?>/">
                                    <?= getPhrase('placement_and_achievement');?>
                                </a>
                            </li>
                            <li <?= $page_name == 'student_marks' ? 'class="menu-left-selected-icon"' : ''?>>
                                <i class="picons-thin-icon-thin-0133_arrow_right_next" style="font-size:20px"></i>
                                &nbsp;&nbsp;&nbsp;
                                <a href="<?= base_url();?>admin/student_marks/<?= $student_id;?>/">
                                    <?= getPhrase('marks');?>
                                </a>
                            </li>
                            <li <?= $page_name == 'student_past_marks' ? 'class="menu-left-selected-icon"' : ''?>>
                                <i class="picons-thin-icon-thin-0133_arrow_right_next" style="font-size:20px"></i>
                                &nbsp;&nbsp;&nbsp;
                                <a href="<?= base_url();?>admin/student_past_marks/<?= $student_id;?>/">
                                    <?= getPhrase('past_marks');?>
                                </a>
                            </li>
                            <li
                                <?= $page_name == 'student_profile_attendance' ? 'class="menu-left-selected-icon"' : ''?>>
                                <i class="picons-thin-icon-thin-0133_arrow_right_next" style="font-size:20px"></i>
                                &nbsp;&nbsp;&nbsp;
                                <a href="<?= base_url();?>admin/student_profile_attendance/<?= $student_id;?>/">
                                    <?= getPhrase('attendance');?>
                                </a>
                            </li>
                            <li <?= $page_name == 'student_profile_report' ? 'class="menu-left-selected-icon"' : ''?>>
                                <i class="picons-thin-icon-thin-0133_arrow_right_next" style="font-size:20px"></i>
                                &nbsp;&nbsp;&nbsp;
                                <a href="<?= base_url();?>admin/student_profile_report/<?= $student_id;?>/">
                                    <?= getPhrase('behavior');?>
                                </a>
                            </li>
                            <li <?= $page_name == 'student_payments' ? 'class="menu-left-selected-icon"' : ''?>>
                                <i class="picons-thin-icon-thin-0133_arrow_right_next" style="font-size:20px"></i>
                                &nbsp;&nbsp;&nbsp;
                                <a href="<?= base_url();?>admin/student_payments/<?= $student_id;?>/">
                                    <?= getPhrase('payments_history');?>
                                </a>
                            </li>
                            <li <?= $page_name == 'student_print_documents' ? 'class="menu-left-selected-icon"' : ''?>>
                                <i class="picons-thin-icon-thin-0333_printer" style="font-size:20px"></i>
                                &nbsp;&nbsp;&nbsp;
                                <a href="<?= base_url();?>admin/student_print_documents/<?= $student_id;?>/">
                                    <?= getPhrase('print_documents');?>
                                </a>
                            </li>
                            <?php if(has_permission('login_as_student')):?>
                            <li>
                                <i class="picons-thin-icon-thin-0329_computer_laptop_user_login"
                                    style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                <a
                                    href="<?= base_url();?>admin/login_as/student/<?= $student_id;?>/"><?= getPhrase('login_as');?></a>
                            </li>
                            <?php endif;?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>