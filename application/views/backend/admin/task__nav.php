                <ul class="navs navs-tabs upper">
                    <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'task_dashboard' ? 'active' : ''?>"
                            href="<?php echo base_url();?>admin/task_dashboard/">
                            <i class="os-icon picons-thin-icon-thin-0482_gauge_dashboard_empty"></i>
                            <span><?php echo getPhrase('dashboard');?></span>
                        </a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'task_list' ? 'active' : ''?>"
                            href="<?php echo base_url();?>admin/task_list/">
                            <i class="os-icon picons-thin-icon-thin-0093_list_bullets"></i>
                            <span><?php echo getPhrase('task_list');?></span>
                        </a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'task_applicant' ? 'active' : ''?>"
                            href="<?php echo base_url();?>admin/task_applicant/">
                            <i class="os-icon picons-thin-icon-thin-0716_user_profile_add_new"></i>
                            <span><?php echo getPhrase('task_applicants');?></span>
                        </a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'task_student' ? 'active' : ''?>"
                            href="<?php echo base_url();?>admin/task_student/">
                            <i
                                class="os-icon picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i>
                            <span><?php echo getPhrase('task_students');?></span>
                        </a>
                    </li>
                    <?php if($page_name == 'task_info') : ?>
                    <li class="navs-item">
                        <a class="navs-links active" href="#">
                            <i class="os-icon picons-thin-icon-thin-0100_to_do_list_reminder_done"></i>
                            <span><?php echo getPhrase('task_info');?></span>
                        </a>
                    </li>
                    <?php endif?>
                </ul>