<?php 
    $user_id = $this->session->userdata('login_user_id');
    $student_info = $this->db->get_where('student' , array('student_id' => $student_id))->result_array(); 
    
    foreach($student_info as $row):
        $student_id = $row['student_id'];
        $return_url = base64_encode('student_profile/'.$student_id);
?>  
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="content-i">
        <div class="content-box">
            <div class="conty">
                <div class="row">
                    <main class="col col-xl-9 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
                        <div id="newsfeed-items-grid">
                            <div class="ui-block paddingtel">
                                <div class="user-profile">
                                    <?php include 'student__header.php';?>
                                    <div class="ui-block">
                                        <div class="ui-block-title">
                                            <h6 class="title"><?= getPhrase('personal_information');?></h6>
                                        </div>
                                        <div class="ui-block-content">
                                            <div class="row">
                                                <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                    <ul class="widget w-personal-info item-block">
                                                        <li>
                                                            <span class="title"><?= getPhrase('name');?>:</span>
                                                            <span class="text"><?= $row['first_name'];?>
                                                                <?= $row['last_name'];?></span>
                                                        </li>
                                                        <li>
                                                            <span class="title"><?= getPhrase('email');?>:</span>
                                                            <span class="text"><?= $row['email'];?></span>
                                                        </li>
                                                        <li>
                                                            <span
                                                                class="title"><?= getPhrase('username');?>:</span>
                                                            <span class="text"><?= $row['username'];?></span>
                                                        </li>
                                                        <li>
                                                            <span
                                                                class="title"><?= getPhrase('address');?>:</span>
                                                            <span class="text"><?= $row['address'];?></span>
                                                        </li>
                                                        <li>
                                                            <span
                                                                class="title"><?= getPhrase('section');?>:</span>
                                                            <?php
    															    $section_id = $this->db->get_where('enroll', array('student_id' => $row['student_id']))->row()->section_id;?>
                                                            <span
                                                                class="text"><?= $this->db->get_where('section', array('section_id' => $section_id))->row()->name;?></span>
                                                        </li>
                                                        <li>
                                                            <span
                                                                class="title"><?= getPhrase('classroom');?>:</span>
                                                            <span
                                                                class="text"><?= $this->db->get_where('class_room', array('classroom_id' => $row['classroom_id']))->row()->name;?></span>
                                                        </li>
                                                        <li>
                                                            <span
                                                                class="title"><?= getPhrase('allergies');?>:</span>
                                                            <span class="text"><?= $row['allergies'];?></span>
                                                        </li>
                                                        <li>
                                                            <span
                                                                class="title"><?= getPhrase('personal_doctor');?>:</span>
                                                            <span class="text"><?= $row['doctor'];?></span>
                                                        </li>
                                                        <li>
                                                            <span
                                                                class="title"><?= getPhrase('authorized_person');?>:</span>
                                                            <span
                                                                class="text"><?= $row['authorized_person'];?></span>
                                                        </li>
                                                        <li>
                                                            <span class="title"><?= getPhrase('note');?>:</span>
                                                            <span class="text"><?= $row['note'];?></span>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                    <ul class="widget w-personal-info item-block">
                                                        <li>
                                                            <span
                                                                class="title"><?= getPhrase('parent');?>:</span>
                                                            <span
                                                                class="text"><?= $this->db->get_where('parent', array('parent_id' => $row['parent_id']))->row()->first_name." ".$this->db->get_where('parent', array('parent_id' => $row['parent_id']))->row()->last_name;?></span>
                                                        </li>
                                                        <li>
                                                            <span class="title"><?= getPhrase('phone');?>:</span>
                                                            <span class="text"><?= $row['phone'];?></span>
                                                        </li>
                                                        <li>
                                                            <span
                                                                class="title"><?= getPhrase('birthday');?>:</span>
                                                            <span class="text"><?= $row['birthday'];?></span>
                                                        </li>
                                                        <li>
                                                            <span
                                                                class="title"><?= getPhrase('gender');?>:</span>
                                                            <span
                                                                class="text"><?= $this->db->get_where('gender', array('code' => $row['sex']))->row()->name;?></span>
                                                        </li>
                                                        <li>
                                                            <span class="title"><?= getPhrase('class');?>:</span>
                                                            <?php
    															    $class_id = $this->db->get_where('enroll', array('student_id' => $row['student_id']))->row()->class_id;
															        $section_id = $this->db->get_where('enroll', array('student_id' => $row['student_id']))->row()->section_id;?>
                                                            <span
                                                                class="text"><?= $this->db->get_where('class', array('class_id' => $class_id))->row()->name;?></span>
                                                        </li>
                                                        <li>
                                                            <span
                                                                class="title"><?= getPhrase('transport');?>:</span>
                                                            <span
                                                                class="text"><?= $this->db->get_where('transport', array('transport_id' => $row['transport_id']))->row()->route_name;?></span>
                                                        </li>
                                                        <li>
                                                            <span
                                                                class="title"><?= getPhrase('conditions_or_diseases');?>:</span>
                                                            <span class="text"><?= $row['diseases'];?></span>
                                                        </li>
                                                        <li>
                                                            <span
                                                                class="title"><?= getPhrase('doctor_phone');?>:</span>
                                                            <span class="text"><?= $row['doctor_phone'];?></span>
                                                        </li>
                                                        <li>
                                                            <span
                                                                class="title"><?= getPhrase('authorized_person_phone');?>:</span>
                                                            <span
                                                                class="text"><?= $row['authorized_phone'];?></span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="ui-block">
                                            <div class="ui-block-title">
                                                <h6 class="col title"><?= getPhrase('task');?>
                                                </h6>
                                                <div class="col" style="justify-content: flex-end;">
                                                    <?php if(!$allow_actions):?>
                                                    <div class="form-buttons">
                                                        <button class="btn btn-rounded btn-primary"
                                                        onclick="showAjaxModal('<?= base_url();?>modal/popup_task/modal_task_add/<?= $row['student_id'].'/student/';?>');">
                                                            <?= getPhrase('add_task');?></button>
                                                    </div> &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <?php endif;?>
                                                </div>
                                            </div>
                                            <div class="ui-block-content">
                                                <div class="edu-posts cta-with-media">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead style="text-align: center;">
                                                                <tr style="background:#f2f4f8;">
                                                                    <th>
                                                                        <?= getPhrase('title');?>
                                                                    </th>
                                                                    <th>
                                                                        <?= getPhrase('created_by');?>
                                                                    </th>
                                                                    <th>
                                                                        <?= getPhrase('created_at');?>
                                                                    </th>
                                                                    <th>
                                                                        <?= getPhrase('file');?>
                                                                    </th>
                                                                    <th>
                                                                        <?= getPhrase('status');?>
                                                                    </th>
                                                                    <th>
                                                                        <?= getPhrase('options');?>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php 
                                                                $tasks = $this->db->get_where('task', array('user_type' => 'student', 'user_id' => $student_id))->result_array();

                                                                // echo '<pre>';
                                                                // var_dump($return_url);
                                                                // echo '</pre>';

                                                                foreach ($tasks as $item):
                                                                ?>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <?= $item['title'];?>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <?= $this->crud->get_name($item['created_by_type'], $item['created_by']);?>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <?= $item['created_at'];?>
                                                                    </td>
                                                                    <td class="row-actions">
                                                                        <?php if($item['task_file']):?>
                                                                        <a href="<?= base_url().PATH_TASK_FILES;?><?= $item['task_file'];?>"
                                                                            class="grey" data-toggle="tooltip"
                                                                            data-placement="top" target="_blank"
                                                                            data-original-title="<?= getPhrase('view');?>">
                                                                            <i
                                                                                class="os-icon picons-thin-icon-thin-0043_eye_visibility_show_visible"></i>
                                                                        </a>
                                                                        <? endif;?>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <?= $this->task->get_status($item['status_id']);?>
                                                                    </td>
                                                                    <td class="row-actions">
                                                                        <a href="<?= base_url();?>assignment/task_info/<?= $item['task_code'];?>"
                                                                            class="grey" data-toggle="tooltip" data-placement="top"
                                                                            data-original-title="<?= getPhrase('view');?>">
                                                                            <i
                                                                                class="os-icon picons-thin-icon-thin-0043_eye_visibility_show_visible"></i>
                                                                        </a>
                                                                        <?php if($user_id == $item['created_by'] && !$allow_actions):?>                                                                        
                                                                        <a href="javascript:void(0);" class="grey"
                                                                            data-toggle="tooltip" data-placement="top"
                                                                            data-original-title="<?= getPhrase('add_message');?>"
                                                                            onclick="showAjaxModal('<?= base_url();?>modal/popup_task/modal_task_add_message/<?=$item['task_code'].'/';?>');">
                                                                            <i
                                                                                class="os-icon picons-thin-icon-thin-0151_plus_add_new"></i>
                                                                        </a>
                                                                        <?php endif;?>
                                                                    </td>
                                                                </tr>
                                                                <?php endforeach?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <br/>
                                    <div class="ui-block">
                                        <div class="ui-block-title">
                                            <h6 class="title"><?= getPhrase('interactions');?>
                                            </h6>
                                            <span class="action-right">
                                            <button class="btn btn-rounded btn-primary"
                                                            onclick="showAjaxModal('<?= base_url();?>modal/popup_task/modal_student_add_interaction/<?= $student_id;?>');">
                                                            <?= getPhrase('add_interaction');?></button>
                                            </span>
                                        </div>
                                        <div class="ui-block-content">
                                            <div class="edu-posts cta-with-media">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead style="text-align: center;">
                                                            <tr style="background:#f2f4f8;">
                                                                <th>
                                                                    <?= getPhrase('comment');?>
                                                                </th>
                                                                <th>
                                                                    <?= getPhrase('created_by');?>
                                                                </th>
                                                                <th>
                                                                    <?= getPhrase('created_at');?>
                                                                </th>
                                                                <th>
                                                                    <?= getPhrase('file');?>
                                                                </th>
                                                                <th>
                                                                    <?= getPhrase('options');?>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php 

                                                                $interactions = $this->studentModel->get_interactions($row['student_id']);
                                                                // $this->db->get_where('student_interaction', array('student_id' => $row['student_id']))->result_array();
                                                                // echo '<pre>';
                                                                // var_dump($interactions);
                                                                // echo '</pre>';
                                                                foreach ($interactions as $item):
                                                            ?>
                                                            <tr>
                                                                <td class="text-center">
                                                                    <?php
                                                                        $html_text = strip_tags(html_entity_decode($item['comment']));
                                                                        if(strlen($html_text) > 100)
                                                                        {
                                                                            echo substr($html_text, 0, 100).'...';
                                                                        }
                                                                        else
                                                                        {
                                                                            echo $html_text;
                                                                        }                                                                            
                                                                    ?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <center>
                                                                        <?= $this->crud->get_name($item['created_by_type'], $item['created_by']);?>
                                                                    </center>
                                                                </td>
                                                                <td class="text-center">
                                                                    <center>
                                                                        <?= $item['created_at'];?>
                                                                    </center>
                                                                </td>
                                                                <td class="row-actions">
                                                                    <?php if($item['file_name']):?>
                                                                    <a href="<?= base_url().PATH_STUDENT_INTERACTION_FILES;?><?= $item['file_name'];?>"
                                                                        class="grey" data-toggle="tooltip"
                                                                        data-placement="top" target="_blank"
                                                                        data-original-title="<?= getPhrase('view');?>">
                                                                        <i
                                                                            class="os-icon picons-thin-icon-thin-0043_eye_visibility_show_visible"></i>
                                                                    </a>
                                                                    <? endif;?>
                                                                </td>
                                                                <td class="row-actions">
                                                                    <a href="javascript:void(0);" class="grey"
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        data-original-title="<?= getPhrase('view');?>"
                                                                        onclick="showAjaxModal('<?= base_url();?>modal/popup_task/modal_student_view_interaction/<?=$item['interaction_id'];?>');">
                                                                        <i
                                                                            class="os-icon picons-thin-icon-thin-0043_eye_visibility_show_visible"></i>
                                                                    </a>
                                                                    <?php if($user_id == $item['created_by'] && !$allow_actions):?>
                                                                    <a href="javascript:void(0);" class="grey"
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        data-original-title="<?= getPhrase('edit');?>"
                                                                        onclick="showAjaxModal('<?= base_url();?>modal/popup_task/modal_student_update_interaction/<?=$item['interaction_id'];?>');">
                                                                        <i
                                                                            class="os-icon picons-thin-icon-thin-0001_compose_write_pencil_new"></i>
                                                                    </a>
                                                                    <?php endif;?>
                                                                </td>
                                                            </tr>
                                                            <?php endforeach;?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                    <?php include 'student__nav.php';?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach;?>