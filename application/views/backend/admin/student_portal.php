<?php 
    $user_id = $this->session->userdata('login_user_id');
    $student_info = $this->db->get_where('student' , array('student_id' => $student_id))->result_array(); 
    foreach($student_info as $row):
        $student_id = $row['student_id'];
        $return_url = base64_encode('student_portal/'.$student_id);
?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="content-i">
        <div class="content-box">
            <div class="conty">
                <div class="back" style="margin-top:-20px;margin-bottom:10px">
                    <a title="<?= getPhrase('return');?>" href="<?= base_url();?>admin/students/"><i
                            class="picons-thin-icon-thin-0131_arrow_back_undo"></i></a>
                </div>
                <div class="row">
                    <main class="col col-xl-9 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
                        <div id="newsfeed-items-grid">
                            <div class="ui-block paddingtel">
                                <div class="user-profile">
                                    <?php include 'student_area_header.php';?>
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
                                                            <span class="title"><?= getPhrase('username');?>:</span>
                                                            <span class="text"><?= $row['username'];?></span>
                                                        </li>
                                                        <li>
                                                            <span class="title"><?= getPhrase('address');?>:</span>
                                                            <span class="text"><?= $row['address'];?></span>
                                                        </li>
                                                        <li>
                                                            <span class="title"><?= getPhrase('sevis');?>:</span>
                                                            <span class="text"><?= $row['sevis_number'];?></span>
                                                        </li>
                                                        <li>
                                                            <span class="title"><?= getPhrase('allergies');?>:</span>
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
                                                            <span class="text"><?= $row['authorized_person'];?></span>
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
                                                            <span class="title"><?= getPhrase('country');?>:</span>
                                                            <span class="text">
                                                                <?= $this->db->get_where('countries', array('country_id' => $row['country_id']))->row()->name;?>
                                                            </span>
                                                        </li>
                                                        <li>
                                                            <span class="title"><?= getPhrase('phone');?>:</span>
                                                            <span class="text"><?= $row['phone'];?></span>
                                                        </li>
                                                        <li>
                                                            <span class="title"><?= getPhrase('birthday');?>:</span>
                                                            <span class="text"><?= $row['birthday'];?></span>
                                                        </li>
                                                        <li>
                                                            <span class="title"><?= getPhrase('gender');?>:</span>
                                                            <span
                                                                class="text"><?= $this->db->get_where('gender', array('code' => $row['sex']))->row()->name;?></span>
                                                        </li>
                                                        <li>
                                                            <span
                                                                class="title"><?= getPhrase('conditions_or_diseases');?>:</span>
                                                            <span class="text"><?= $row['diseases'];?></span>
                                                        </li>
                                                        <li>
                                                            <span class="title"><?= getPhrase('doctor_phone');?>:</span>
                                                            <span class="text"><?= $row['doctor_phone'];?></span>
                                                        </li>
                                                        <li>
                                                            <span
                                                                class="title"><?= getPhrase('authorized_person_phone');?>:</span>
                                                            <span class="text"><?= $row['authorized_phone'];?></span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="ui-block">
                                        <div class="ui-block-title">
                                            <h6 class="col title"><?= getPhrase('task');?>
                                            </h6>
                                            <div class="col" style="justify-content: flex-end;">
                                                <?php if(!$allow_actions):?>
                                                <div class="form-buttons">
                                                    <button class="btn btn-rounded btn-primary"
                                                        onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_task_add/<?= $row['student_id'].'/student/'.$return_url;?>');">
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
                                                                    <?= getPhrase('assigned_to');?>
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
                                                                    <?= $item['assigned_to_type'] != "" ? $this->crud->get_name($item['assigned_to_type'],$item['assigned_to']) : '';?>
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
                                                                    <a href="<?= base_url();?>admin/task_info/<?= $item['task_code'];?>"
                                                                        class="grey" data-toggle="tooltip"
                                                                        data-placement="top"
                                                                        data-original-title="<?= getPhrase('view');?>">
                                                                        <i
                                                                            class="os-icon picons-thin-icon-thin-0043_eye_visibility_show_visible"></i>
                                                                    </a>
                                                                    <?php if($user_id == $item['created_by'] && !$allow_actions):?>
                                                                    <a href="javascript:void(0);" class="grey"
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        data-original-title="<?= getPhrase('add_message');?>"
                                                                        onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_task_add_message/<?=$item['task_code'].'/'.$return_url;?>');">
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
                                    <br />
                                    <div class="ui-block">
                                        <div class="ui-block-title">
                                            <h6 class="title"><?= getPhrase('interactions');?>
                                            </h6>
                                            <span class="action-right">
                                                <button class="btn btn-rounded btn-primary"
                                                    onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_student_add_interaction/<?= $student_id;?>');">
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
                                                                // $this->db->get_where('v_student_interaction', array('student_id' => $row['student_id']))->result_array();
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
                                                                        onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_student_view_interaction/<?=$item['interaction_id'];?>');">
                                                                        <i
                                                                            class="os-icon picons-thin-icon-thin-0043_eye_visibility_show_visible"></i>
                                                                    </a>
                                                                    <?php if($user_id == $item['created_by'] && !$allow_actions):?>
                                                                    <a href="javascript:void(0);" class="grey"
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        data-original-title="<?= getPhrase('edit');?>"
                                                                        onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_student_update_interaction/<?=$item['interaction_id'];?>');">
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
                                    <?php if($row['applicant_id'] != ''): ?>
                                    <br />
                                    <hr />
                                    <div>
                                        <h4 class="title" style="margin-left: 20px;margin-top: 40px;">
                                            Applicant Info
                                        </h4>
                                        <br />
                                        <div class="ui-block">
                                            <div class="ui-block-title">
                                                <h6 class="col title">
                                                    <?= getPhrase('task');?>
                                                </h6>
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
                                                                        <?= getPhrase('assigned_to');?>
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
                                                                $tasks = $this->db->get_where('task', array('user_type' => 'applicant', 'user_id' => $row['applicant_id']))->result_array();
                                                                foreach ($tasks as $item):
                                                                ?>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <?= $item['title'];?>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <?= $item['created_by_type'] != "" ? $this->crud->get_name($item['created_by_type'],$item['created_by']) : '';?>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <?= $item['assigned_to_type'] != "" ? $this->crud->get_name($item['assigned_to_type'],$item['assigned_to']) : '';?>
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
                                                                        <a href="<?= base_url();?>admin/task_info/<?= $item['task_code'];?>"
                                                                            class="grey" data-toggle="tooltip"
                                                                            data-placement="top"
                                                                            data-original-title="<?= getPhrase('view');?>">
                                                                            <i
                                                                                class="os-icon picons-thin-icon-thin-0043_eye_visibility_show_visible"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                                <?php endforeach?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ui-block">
                                            <div class="ui-block-title">
                                                <h6 class="title"><?= getPhrase('interactions');?>
                                                </h6>
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
                                                                $interactions = $this->applicant->get_interactions($row['applicant_id']);
                                                                
                                                                foreach ($interactions as $item):
                                                            ?>
                                                                <tr>
                                                                    <td>
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
                                                                            <?= $item['created_by_type'] != "" ? $this->crud->get_name($item['created_by_type'],$item['created_by']) : '';?>
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
                                                                            onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_admission_view_interaction/<?=$item['interaction_id'];?>');">
                                                                            <i
                                                                                class="os-icon picons-thin-icon-thin-0043_eye_visibility_show_visible"></i>
                                                                        </a>
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
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                    </main>
                    <?php include 'student_area_menu.php';?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach;?>