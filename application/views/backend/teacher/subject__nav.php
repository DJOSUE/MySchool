                <ul class="navs navs-tabs upper">
                    <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'subject_dashboard' ? 'active' : ''?>"
                            href="<?php echo base_url();?>teacher/subject_dashboard/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0482_gauge_dashboard_empty"></i><span><?php echo getPhrase('dashboard');?></span></a>
                    </li>
                    <?php if($this->academic->getInfo('show_achievement_test') == 1) :?>
                    <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'subject_achievement_test' ? 'active' : ''?>"
                            href="<?php echo base_url();?>teacher/subject_achievement_test/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0658_cup_place_winner_award_prize_achievement"></i><span><?php echo getPhrase('achievement_test');?></span></a>
                    </li>
                    <?php endif; ?>
                    <?php if($this->academic->getInfo('show_online_exams') == 1) :?>
                    <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'online_exams' ? 'active' : ''?>"
                            href="<?php echo base_url();?>teacher/online_exams/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0207_list_checkbox_todo_done"></i><span><?php echo getPhrase('online_exams');?></span></a>
                    </li>
                    <?php endif; ?>
                    <?php if($this->academic->getInfo('show_homework') == 1) :?>
                    <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'homework' ? 'active' : ''?>"
                            href="<?php echo base_url();?>teacher/homework/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0004_pencil_ruler_drawing"></i><span><?php echo getPhrase('homework');?></span></a>
                    </li>
                    <?php endif; ?>
                    <?php if($this->academic->getInfo('show_forum') == 1) :?>
                    <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'forum' ? 'active' : ''?>"
                            href="<?php echo base_url();?>teacher/forum/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0281_chat_message_discussion_bubble_reply_conversation"></i><span><?php echo getPhrase('forum');?></span></a>
                    </li>
                    <?php endif; ?>
                    <?php if($this->academic->getInfo('show_study_material') == 1) :?>
                    <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'study_material' ? 'active' : ''?>"
                            href="<?php echo base_url();?>teacher/study_material/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0003_write_pencil_new_edit"></i><span><?php echo getPhrase('study_material');?></span></a>
                    </li>
                    <?php endif; ?>
                    <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'subject_upload_marks' || $page_name == 'subject_upload_daily_marks' ? 'active' : ''?>"
                            href="<?php echo base_url();?>teacher/subject_upload_marks/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i><span><?php echo getPhrase('daily_grades');?></span></a>
                    </li>
                    <?php if($useDailyMarks): ?>
                    <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'subject_daily_marks_average' ? 'active' : ''?>"
                            href="<?php echo base_url();?>teacher/subject_daily_marks_average/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0197_layout_grid_view"></i><span><?php echo getPhrase('unit_averages');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'subject_update_daily_marks' ? 'active' : ''?>"
                            href="<?php echo base_url();?>teacher/subject_update_daily_marks/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0256_input_box_text_edit"></i><span><?php echo getPhrase('edit_grades');?></span></a>
                    </li>
                    <?php endif; ?>
                    <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'subject_meet' ? 'active' : ''?>"
                            href="<?php echo base_url();?>teacher/subject_meet/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0591_presentation_video_play_beamer"></i><span><?php echo getPhrase('live');?></span></a>
                    </li>
                    <?php if(!$useGradeAttendance):?>
                    <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'subject_attendance' ? 'active' : ''?>"
                            href="<?php echo base_url();?>teacher/subject_attendance/<?php echo $data;?>/"><i
                                class="os-icon picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i><span><?php echo getPhrase('attendance');?></span></a>
                    </li>
                    <?php endif;?>
                </ul>