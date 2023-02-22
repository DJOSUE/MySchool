            <div class="os-tabs-controls">
                <ul class="navs navs-tabs upper">
                    <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'admission_dashboard' ? 'active' : ''?>"
                            href="<?php echo base_url();?>admin/admission_dashboard/">
                            <i class="os-icon picons-thin-icon-thin-0482_gauge_dashboard_empty"></i>
                            <span><?php echo getPhrase('dashboard');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'admission_applicants' ? 'active' : ''?>"
                            href="<?php echo base_url();?>admin/admission_applicants/">
                            <i class="os-icon picons-thin-icon-thin-0093_list_bullets"></i>
                            <span><?php echo getPhrase('applicants');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'admission_new_applicant' ? 'active' : ''?>"
                            href="<?= base_url();?>admin/admission_new_applicant/">
                            <i class="os-icon picons-thin-icon-thin-0716_user_profile_add_new"></i>
                            <span><?= getPhrase('new_applicant');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'admission_new_student' ? 'active' : ''?>"
                            href="<?= base_url();?>admin/admission_new_student/">
                            <i class="os-icon picons-thin-icon-thin-0706_user_profile_add_new"></i>
                            <span><?= getPhrase('new_student');?></span></a>
                    </li>
                    <?php if($page_name == 'admission_applicant'):?>
                    <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'admission_applicant' ? 'active' : ''?>"
                            href="<?= base_url();?>admin/admission_applicant/">
                            <i class="os-icon picons-thin-icon-thin-0704_users_profile_group_couple_man_woman"></i>
                            <span><?= getPhrase('applicant');?></span></a>
                    </li>
                    <?php endif;?>
                </ul>
            </div>