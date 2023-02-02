                <ul class="navs navs-tabs upper">
                    <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'request_dashboard' ? 'active' : ''?>"
                            href="<?php echo base_url();?>admin/request_dashboard/"><i
                                class="os-icon picons-thin-icon-thin-0482_gauge_dashboard_empty"></i>
                            <span><?php echo getPhrase('dashboard');?></span>
                        </a>
                    </li>
                    <?php if(has_permission('request_reports')):?>
                    <!-- <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'request_reports' ? 'active' : ''?>"
                            href="<?php echo base_url();?>admin/request_reports/"><i
                                class="os-icon picons-thin-icon-thin-0389_gavel_hammer_law_judge_court"></i>
                            <span><?php echo getPhrase('reports');?></span>
                        </a>
                    </li> -->
                    <?php endif;?>
                    <?php if(has_permission('request_teacher')):?>
                    <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'request_teacher' ? 'active' : ''?>"
                            href="<?php echo base_url();?>admin/request_teacher/"><i
                                class="os-icon picons-thin-icon-thin-0015_fountain_pen"></i>
                            <span><?php echo getPhrase('teacher_permissions');?></span>
                        </a>
                    </li>
                    <?php endif;?>
                    <?php if(has_permission('request_student')):?>
                    <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'request_student' ? 'active' : ''?>"
                            href="<?php echo base_url();?>admin/request_student/"><i
                                class="os-icon picons-thin-icon-thin-0015_fountain_pen"></i>
                            <span><?php echo getPhrase('student_permissions');?></span>
                        </a>
                    </li><?php endif;?>
                    <?php if(has_permission('request_vacation')):?>
                    <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'request_vacation' ? 'active' : ''?>"
                            href="<?php echo base_url();?>admin/request_vacation/"><i
                                class="os-icon picons-thin-icon-thin-0015_fountain_pen"></i>
                            <span><?php echo getPhrase('student_vacations');?></span>
                        </a>
                    </li><?php endif;?>
                    
                </ul>