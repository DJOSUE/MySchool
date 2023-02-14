                <ul class="navs navs-tabs upper">
                    <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'dashboard' ? 'active': '' ;?>"
                            href="<?php echo base_url();?>helpdesk/dashboard/">
                            <i class="os-icon picons-thin-icon-thin-0482_gauge_dashboard_empty"></i>
                            <span><?php echo getPhrase('dashboard');?></span>
                        </a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links  <?= $page_name == 'ticket_list' ? 'active': '' ;?>"
                            href="<?php echo base_url();?>helpdesk/ticket_list/">
                            <i class="os-icon picons-thin-icon-thin-0093_list_bullets"></i>
                            <span><?php echo getPhrase('ticket_list');?></span>
                        </a>
                    </li>
                    <?php  if($page_name == 'ticket_info'):?>
                    <li class="navs-item">
                        <a class="navs-links active" href="#">
                            <i class="os-icon picons-thin-icon-thin-0100_to_do_list_reminder_done"></i>
                            <span><?php echo getPhrase('ticket_info');?></span>
                        </a>
                    </li>
                    <?php endif;?>
                    <li class="navs-item">
                        <a class="navs-links  <?= $page_name == 'tutorial' ? 'active': '' ;?>"
                            href="<?php echo base_url();?>helpdesk/tutorial/">
                            <i class="os-icon picons-thin-icon-thin-0273_video_multimedia_movie"></i>
                            <span><?php echo getPhrase('video_tutorial');?></span>
                        </a>
                    </li>
                </ul>