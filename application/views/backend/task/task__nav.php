                <ul class="navs navs-tabs upper">
                    <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'task_dashboard' ? 'active': '' ;?>"
                            href="<?php echo base_url();?>assignment/task_dashboard/">
                            <i class="os-icon picons-thin-icon-thin-0482_gauge_dashboard_empty"></i>
                            <span><?php echo getPhrase('dashboard');?></span>
                        </a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'task_list' ? 'active': '' ;?>"
                            href="<?php echo base_url();?>assignment/task_list/">
                            <i class="os-icon picons-thin-icon-thin-0093_list_bullets"></i>
                            <span><?php echo getPhrase('task_list');?></span>
                        </a>
                    </li>
                    <?php if($page_name == 'task_info' || $page_name == 'task_update'): ?>
                    <li class="navs-item">
                        <a class="navs-links active" href="#">
                            <i class="os-icon picons-thin-icon-thin-0100_to_do_list_reminder_done"></i>
                            <span><?php echo getPhrase('task_info');?></span>
                        </a>
                    </li>
                    <?php endif;?>
                </ul>