                    <ul class="navs navs-tabs upper">
                        <?php if(has_permission('academic_dashboard_report')):?>
                        <li class="navs-item">
                            <a class="navs-links <?= $page_name == 'academic_dashboard' ? 'active' : ''?>"
                                href="<?php echo base_url();?>reports/academic_dashboard/">
                                <i class="os-icon picons-thin-icon-thin-0482_gauge_dashboard_empty"></i>
                                <span><?php echo getPhrase('home');?></span>
                            </a>
                        </li>
                        <?php endif;?>
                        <?php if(has_permission('academic_attendance_report')):?>
                        <li class="navs-item">
                            <a class="navs-links <?= $page_name == 'academic_attendance' ? 'active' : ''?>"
                                href="<?php echo base_url();?>reports/academic_attendance/">
                                <i class="os-icon picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i>
                                <span><?php echo getPhrase('attendance');?></span>
                            </a>
                        </li>
                        <?php endif;?> 
                    </ul>