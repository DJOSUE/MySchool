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
                        <?php if(has_permission('academic_schedule_class_report')):?>
                        <li class="navs-item">
                            <a class="navs-links <?= $page_name == 'academic_schedule_class' ? 'active' : ''?>"
                                href="<?php echo base_url();?>reports/academic_schedule_class/">
                                <i class="os-icon picons-thin-icon-thin-0024_calendar_month_day_planner_events"></i>
                                <span><?php echo getPhrase('schedule_class');?></span>
                            </a>
                        </li>
                        <?php endif;?> 
                        <?php if(has_permission('academic_absence_report')):?>
                        <li class="navs-item">
                            <a class="navs-links <?= $page_name == 'academic_absence' ? 'active' : ''?>"
                                href="<?php echo base_url();?>reports/academic_absence/">
                                <i class="os-icon picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i>
                                <span><?php echo getPhrase('absence');?></span>
                            </a>
                        </li>
                        <?php endif;?> 
                        <!-- <?php if(has_permission('academic_attendance_report')):?>
                        <li class="navs-item">
                            <a class="navs-links <?= $page_name == 'academic_attendance' ? 'active' : ''?>"
                                href="<?php echo base_url();?>reports/academic_attendance/">
                                <i class="os-icon picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i>
                                <span><?php echo getPhrase('attendance');?></span>
                            </a>
                        </li>
                        <?php endif;?>  -->
                        <?php if(has_permission('academic_students_achievement')):?>
                        <li class="navs-item">
                            <a class="navs-links <?= $page_name == 'academic_students_achievement' ? 'active' : ''?>"
                                href="<?php echo base_url();?>reports/academic_students_achievement/">
                                <i class="os-icon picons-thin-icon-thin-0187_window_graph_analytics"></i>
                                <span><?php echo getPhrase('students_achievement');?></span>
                            </a>
                        </li>
                        <?php endif;?>
                    </ul>