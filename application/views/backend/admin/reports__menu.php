            <?php 
            $useGradeAttendance = $this->crud->getInfo('use_grade_attendance');
            ?>
            <div class="os-tabs-controls">
                <ul class="navs navs-tabs">
                    <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'reports_general' ? 'active' : ''?>"
                            href="<?= base_url();?>admin/reports_general/"><i
                                class="picons-thin-icon-thin-0658_cup_place_winner_award_prize_achievement"></i>
                            <span><?= getPhrase('classes');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'reports_students' ? 'active' : ''?>"
                            href="<?= base_url();?>admin/reports_students/"><i
                                class="picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i>
                            <span><?= getPhrase('students');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'report_students_achievement' ? 'active' : ''?>"
                            href="<?= base_url();?>admin/report_students_achievement/"><i
                                class="picons-thin-icon-thin-0187_window_graph_analytics"></i>
                            <span><?= getPhrase('students_achievement');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'report_students_placement_test' ? 'active' : ''?>"
                            href="<?= base_url();?>admin/report_students_placement_test/"><i
                                class="picons-thin-icon-thin-0187_window_graph_analytics"></i>
                            <span><?= getPhrase('students_placement_test');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'reports_students_all' ? 'active' : ''?>"
                            href="<?= base_url();?>admin/reports_students_all/"><i
                                class="picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i>
                            <span><?= getPhrase('all_students');?></span></a>
                    </li>
                    <?php if(!$useGradeAttendance): ?>
                    <li class="navs-item">
                        <a class="navs-links" href="<?= base_url();?>admin/attendance_report/"><i
                                class="os-icon picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i>
                            <span><?= getPhrase('attendance');?></span></a>
                    </li>
                    <?php endif;?>
                    <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'reports_marks' ? 'active' : ''?>"
                            href="<?= base_url();?>admin/reports_marks/"><i
                                class="picons-thin-icon-thin-0100_to_do_list_reminder_done"></i>
                            <span><?= getPhrase('final_marks');?></span></a>
                    </li>
                    <!-- <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'reports_past_marks' ? 'active' : ''?>" href="<?= base_url();?>admin/reports_past_marks/"><i
                                class="picons-thin-icon-thin-0100_to_do_list_reminder_done"></i>
                            <span><?= getPhrase('past_final_marks');?></span></a>
                    </li>                   -->
                    <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'reports_tabulation' ||  $page_name == 'reports_tabulation_daily' ? 'active' : ''?>"
                            href="<?= base_url();?>admin/reports_tabulation/"><i
                                class="picons-thin-icon-thin-0070_paper_role"></i>
                            <span><?= getPhrase('tabulation_sheet');?></span></a>
                    </li>
                    <?php if(has_permission('reports_accounting') == 'true'):?>
                    <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'reports_accounting' ? 'active' : ''?>"
                            href="<?= base_url();?>admin/reports_accounting/"><i
                                class="picons-thin-icon-thin-0406_money_dollar_euro_currency_exchange_cash"></i>
                            <span><?= getPhrase('accounting');?></span></a>
                    </li>
                    <?php endif;?>
                </ul>
            </div>