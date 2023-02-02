                            <?php
                                $url = $row['user_type'] == 'applicant' ? 'admission_applicant' : 'student_portal';
                                $icon_info = '';
                                $text_info = '';
                                $icon_update = '';
                                $text_update = '';

                                if($page_name == 'task_info')
                                {
                                    $icon_info = 'menu_left_selected_icon';
                                    $text_info = 'class="menu_left_selected_text"';
                                }
                                else
                                {
                                    $icon_update = 'menu_left_selected_icon';
                                    $text_update = 'class="menu_left_selected_text"';
                                }
                            ?>
                            <div class="eduappgt-sticky-sidebar">
                                <div class="sidebar__inner">
                                    <div class="ui-block paddingtel">
                                        <div class="ui-block-content">
                                            <div class="help-support-block">
                                                <h3 class="title"><?= getPhrase('quick_links');?></h3>
                                                <ul class="help-support-list">
                                                    <li>
                                                        <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                            style="font-size:20px;"></i> &nbsp;&nbsp;&nbsp;
                                                        <a href="<?= base_url();?>admin/<?= $url.'/'.$row['user_id']?>/"
                                                            target="_blank">
                                                            <?= getPhrase('personal_information');?>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <i class="picons-thin-icon-thin-0133_arrow_right_next <?=$icon_info?>"
                                                            style="font-size:20px;"></i> &nbsp;&nbsp;&nbsp;
                                                        <a <?=$text_info?>
                                                            href="<?= base_url();?>admin/task_info/<?= $task_code;?>/">
                                                            <?= getPhrase('task_information');?>
                                                        </a>
                                                    </li>
                                                    <?php if(!$allow_actions):?>
                                                    <li>
                                                        <i class="picons-thin-icon-thin-0133_arrow_right_next <?=$icon_update?>"
                                                            style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                        <a <?=$text_update?>
                                                            href="<?= base_url();?>admin/task_update/<?= $task_code;?>/">
                                                            <?= getPhrase('update_task');?>
                                                        </a>
                                                    </li>
                                                    <?php endif;?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>