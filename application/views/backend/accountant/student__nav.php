<div class="col col-xl-3 order-xl-1 col-lg-12 order-lg-2 col-md-12 col-sm-12 col-12">
    <div class="eduappgt-sticky-sidebar">
        <div class="sidebar__inner">
            <div class="ui-block paddingtel">
                <div class="ui-block-content">
                    <div class="widget w-about">
                        <a href="javascript:void(0);" class="logo"><img
                                src="<?= base_url();?>public/uploads/<?= $this->crud->getInfo('logo');?>"></a>
                        <ul class="socials">
                            <li><a class="socialDash fb"
                                    href="<?= $this->crud->getInfo('facebook');?>"><i
                                        class="fab fa-facebook-square" aria-hidden="true"></i></a>
                            </li>
                            <li><a class="socialDash tw"
                                    href="<?= $this->crud->getInfo('twitter');?>"><i
                                        class="fab fa-twitter" aria-hidden="true"></i></a></li>
                            <li><a class="socialDash yt"
                                    href="<?= $this->crud->getInfo('youtube');?>"><i
                                        class="fab fa-youtube" aria-hidden="true"></i></a></li>
                            <li><a class="socialDash ig"
                                    href="<?= $this->crud->getInfo('instagram');?>"><i
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
                            <li <?= $page_name == 'student_profile' ? 'class="menu-left-selected-icon"' : ''?>>
                                <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                    style="font-size:20px;"></i> &nbsp;&nbsp;&nbsp;
                                <a
                                    href="<?= base_url();?>accountant/student_profile/<?= $student_id;?>/">
                                    <?= getPhrase('personal_information');?>
                                </a>
                            </li>
                            <li <?= $page_name == 'student_update' ? 'class="menu-left-selected-icon"' : ''?>>
                                <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                    style="font-size:20px;"></i> &nbsp;&nbsp;&nbsp;
                                <a
                                    href="<?= base_url();?>accountant/student_update/<?= $student_id;?>/">
                                    <?= getPhrase('update_information');?>
                                </a>
                            </li>
                            <li <?= $page_name == 'student_grades' ? 'class="menu-left-selected-icon"' : ''?>>
                                <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                    style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                <a
                                    href="<?= base_url();?>accountant/student_grades/<?= $student_id;?>/">
                                    <?= getPhrase('student_grades');?>
                                </a>
                            </li>
                            <li <?= $page_name == 'student_past_marks' ? 'class="menu-left-selected-icon"' : ''?>>
                                <i class="picons-thin-icon-thin-0133_arrow_right_next" style="font-size:20px"></i>
                                &nbsp;&nbsp;&nbsp;
                                <a href="<?= base_url();?>accountant/student_past_grades/<?= $student_id;?>/">
                                    <?= getPhrase('past_grades');?>
                                </a>
                            </li>
                            <li <?= $page_name == 'student_attendance' ? 'class="menu-left-selected-icon"' : ''?>>
                                <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                    style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                <a
                                    href="<?= base_url();?>accountant/student_attendance/<?= $student_id;?>/">
                                    <?= getPhrase('student_attendance');?>
                                </a>
                            </li>
                            <li <?= $page_name == 'student_payments' ? 'class="menu-left-selected-icon"' : ''?>>
                                <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                    style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                <a
                                    href="<?= base_url();?>accountant/student_payments/<?= $student_id;?>/">
                                    <?= getPhrase('payments_history');?>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>