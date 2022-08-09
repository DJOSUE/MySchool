<?php 
    $user_id = $this->session->userdata('login_user_id');
    $applicant_info = $this->db->get_where('v_applicants' , array('applicant_id' => $applicant_id))->result_array(); 
    $allow_actions = is_student($applicant_id);
    $is_international = is_international($applicant_id);

    foreach($applicant_info as $row): 
        $full_name_encode = base64_encode(str_replace(" ","_",strtoupper($row['full_name'])));

?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <ul class="navs navs-tabs upper">
                    <li class="navs-item">
                        <a class="navs-links" href="<?= base_url();?>admin/admission_dashboard/">
                            <i
                                class="os-icon picons-thin-icon-thin-0482_gauge_dashboard_empty"></i><span><?= getPhrase('home');?></span></a>
                    </li>
                    <li class="navs-item active">
                        <a class="navs-links" href="<?= base_url();?>admin/admission_new_applicant/">
                            <i
                                class="os-icon picons-thin-icon-thin-0716_user_profile_add_new"></i><span><?= getPhrase('new_applicant');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?= base_url();?>admin/admission_new_student/">
                            <i
                                class="os-icon picons-thin-icon-thin-0706_user_profile_add_new"></i><span><?= getPhrase('new_student');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links active" href="<?= base_url();?>admin/admission_applicant/">
                            <i
                                class="os-icon picons-thin-icon-thin-0704_users_profile_group_couple_man_woman"></i><span><?= getPhrase('applicant');?></span></a>
                    </li>
                </ul>
            </div>
        </div><br>
        <div class="row">
            <div class="content-i">
                <div class="content-box">
                    <div class="row">
                        <main class="col col-xl-9 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
                            <div id="newsfeed-items-grid">
                                <div class="ui-block paddingtel">
                                    <div class="user-profile">
                                        <div class="up-head-w"
                                            style="background-image:url(<?= base_url();?>public/uploads/bglogin.jpg)">
                                            <div class="up-main-info">
                                                <div class="user-avatar-w">
                                                    <div class="user-avatar">
                                                        <img alt=""
                                                            src="<?= $this->crud->get_image_url('applicant', $row['applicant_id']);?>"
                                                            style="background-color:#fff;">
                                                    </div>
                                                </div>
                                                <h3 class="text-white"><?= $row['first_name'];?>
                                                    <?= $row['last_name'];?></h3>
                                            </div>
                                            <svg class="decor" width="842px" height="219px" viewBox="0 0 842 219"
                                                preserveAspectRatio="xMaxYMax meet" version="1.1"
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <g transform="translate(-381.000000, -362.000000)" fill="#FFFFFF">
                                                    <path class="decor-path"
                                                        d="M1223,362 L1223,581 L381,581 C868.912802,575.666667 1149.57947,502.666667 1223,362 Z">
                                                    </path>
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="up-controls">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="value-pair">
                                                        <div><?= getPhrase('applicant_type');?>:</div>
                                                        <div class="value badge badge-pill badge-info"
                                                            style="background-color: <?= $row['applicant_type_color']?>;">
                                                            <?=$row['applicant_type'];?>

                                                        </div>
                                                    </div>
                                                    <div class="value-pair">
                                                        <div><?= getPhrase('status');?>:</div>
                                                        <div class="value badge badge-pill badge-primary"
                                                            style="background-color: <?= $row['status_name_color']?>;">
                                                            <?= $row['status_name'];?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ui-block">
                                            <div class="ui-block-title">
                                                <h6 class="title"><?= getPhrase('personal_information');?>
                                                </h6>
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
                                                                <span class="title"><?= getPhrase('address');?>:</span>
                                                                <span class="text"><?= $row['address'];?></span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <ul class="widget w-personal-info item-block">
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
                                                                    class="text"><?= $this->db->get_where('gender', array('code' => $row['gender']))->row()->name;?></span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" ui-block-title row" style="border-style: none;">
                                            <div class="col-sm-4">
                                                <div class="row" style="justify-content: flex-end;">
                                                    <?php if(!$allow_actions):?>
                                                    <div class="form-buttons">
                                                        <button class="btn btn-rounded btn-primary"
                                                            onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_admission_add_interaction/<?= $applicant_id;?>');">
                                                            <?= getPhrase('add_interaction');?></button>
                                                    </div> &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <?php endif;?>
                                                    <?php if($is_international):?>
                                                    <div class="form-buttons">
                                                        <button class="btn btn-rounded btn-primary"
                                                            onclick="show_application()">
                                                            <?= getPhrase('view_application');?></button>
                                                    </div> &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <div class="form-buttons">
                                                        <button class="btn btn-rounded btn-success"
                                                            onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_admission_platform_send_message/<?= base64_encode($row['email']);?>/<?= base64_encode($applicant_id);?>');">
                                                            <?= getPhrase('send_message');?></button>
                                                    </div>
                                                    <?php endif;?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if($is_international):?>
                                        <div class="ui-block" id="application_view" style="display: none;">
                                            <div class="ui-block-title">
                                                <h6 class="title"><?= getPhrase('application');?>
                                                </h6>`
                                            </div>
                                            <div class="ui-block-content">
                                                <?php // Load the application
                                                    $token = generate_token();
                                                    $url_app = ADMISSION_PLATFORM_URL.'student_info?auth_token='.$token.'&user_email='.$row['email'];

                                                    $ch_app = curl_init($url_app);
                                                    curl_setopt($ch_app, CURLOPT_HTTPGET, true);
                                                    curl_setopt($ch_app, CURLOPT_RETURNTRANSFER, true);
                                                    $response_json_app = curl_exec($ch_app);
                                                    curl_close($ch_app);
                                                    $response_app = json_decode($response_json_app, true);

                                                    

                                                    if($response_app['status'] == 'success'){
                                                        $user_application = $response_app['user_application'];
                                                        $application = $user_application['application'];
                                                        $application_process = $user_application['application_process'];
                                                        $application_documents = $user_application['application_documents'];
                                                        $application_error = $user_application['error'];
                                                    }   

                                                    // echo '<pre>';
                                                    // var_dump($user_application);
                                                    // echo '</pre>';

                                                    if($application_error != '')
                                                        echo getPhrase('application_was_not_found');
                                                ?>

                                                <?php if(is_array($application_process)):?>
                                                <div class="edu-posts cta-with-media">
                                                    <h6 class="title"><?= getPhrase('process');?></h6>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead style="text-align: center;">
                                                                <tr style="background:#f2f4f8;">
                                                                    <th>
                                                                        <?= getPhrase('process');?>
                                                                    </th>
                                                                    <th>
                                                                        <?= getPhrase('date_process');?>
                                                                    </th>
                                                                    <th>
                                                                        <?= getPhrase('note');?>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach($application_process as $item):?>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <center>
                                                                            <?= strip_tags(html_entity_decode($item['process_name']));?>
                                                                        </center>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <center>
                                                                            <?= strip_tags(html_entity_decode($item['date_process']));?>
                                                                        </center>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <center>
                                                                            <?= strip_tags(html_entity_decode($item['note']));?>
                                                                        </center>
                                                                    </td>
                                                                </tr>
                                                                <?php endforeach;?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <?php endif;?>
                                                <?php if(is_array($application_documents)):?>
                                                <br />
                                                <br />
                                                <div class="edu-posts cta-with-media">
                                                    <div>
                                                        <h6 class="title" style="float:left;">
                                                            <?= getPhrase('documents');?></h6>
                                                        <span style="float:right;">
                                                            <a href="https://admission.americanone-esl.com/home/download_files_api/<?= base64_encode($application['user_id']).'/'.$full_name_encode;?>"
                                                                class="grey" data-toggle="tooltip" data-placement="top"
                                                                target="_blank"
                                                                data-original-title="<?php echo getPhrase('download_all_files');?>">
                                                                <i
                                                                    class="os-icon picons-thin-icon-thin-0122_download_file_computer_drive"></i>
                                                            </a>
                                                        </span>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead style="text-align: center;">
                                                                <tr style="background:#f2f4f8;">
                                                                    <th>
                                                                        <?= getPhrase('document');?>
                                                                    </th>
                                                                    <th>
                                                                        <?= getPhrase('name');?>
                                                                    </th>
                                                                    <th>
                                                                        <?= getPhrase('date_added');?>
                                                                    </th>
                                                                    <th>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach($application_documents as $item):?>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <?= strip_tags(html_entity_decode($item['document_type_name']));?>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <?= strip_tags(html_entity_decode($item['name']));?>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <?= strip_tags(html_entity_decode($item['date_added']));?>
                                                                    </td>
                                                                    <td class="row-actions">
                                                                        <a href="<?php echo base_url();?>admin/admission_applicant_document_api/<?= base64_encode($item['id']).'/'.base64_encode($item['user_id']);?>"
                                                                            class="grey" data-toggle="tooltip"
                                                                            data-placement="top" target="_blank"
                                                                            data-original-title="<?php echo getPhrase('view');?>">
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
                                                <?php endif;?>
                                            </div>
                                        </div>
                                        <?php endif;?>
                                        <br />
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
                                                                $interactions = $this->db->get_where('v_applicant_interaction', array('applicant_id' => $applicant_id))->result_array();
                                                                
                                                                // echo '<pre>';
                                                                // var_dump($interactions);
                                                                // echo '</pre>';

                                                                foreach ($interactions as $item):
                                                            ?>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <center>
                                                                            <?= strip_tags(html_entity_decode($item['comment']));?>
                                                                        </center>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <center>
                                                                            <?= $item['first_name'];?>
                                                                        </center>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <center>
                                                                            <?= $item['created_at'];?>
                                                                        </center>
                                                                    </td>
                                                                    <td class="row-actions">
                                                                        <?php if($item['file_name']):?>
                                                                        <a href="<?= base_url().PATH_APPLICANT_FILES;?><?= $item['file_name'];?>"
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
                                                                        <?php if($user_id == $item['created_by'] && !$allow_actions):?>
                                                                        <a href="javascript:void(0);" class="grey"
                                                                            data-toggle="tooltip" data-placement="top"
                                                                            data-original-title="<?= getPhrase('edit');?>"
                                                                            onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_admission_update_interaction/<?=$item['interaction_id'];?>');">
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
                        <div class="col col-xl-3 order-xl-1 col-lg-12 order-lg-2 col-md-12 col-sm-12 col-12">
                            <div class="eduappgt-sticky-sidebar">
                                <div class="sidebar__inner">
                                    <div class="ui-block paddingtel">
                                        <div class="ui-block-content">
                                            <div class="help-support-block">
                                                <h3 class="title"><?= getPhrase('quick_links');?></h3>
                                                <ul class="help-support-list">
                                                    <li>
                                                        <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                            style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                        <a
                                                            href="<?= base_url();?>admin/admission_applicant/<?= $applicant_id;?>/">
                                                            <?= getPhrase('personal_information');?>
                                                        </a>
                                                    </li>
                                                    <?php if(!$allow_actions):?>
                                                    <li>
                                                        <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                            style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                        <a
                                                            href="<?= base_url();?>admin/admission_applicant_update/<?= $applicant_id;?>/">
                                                            <?= getPhrase('update_information');?>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                            style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                        <a
                                                            href="<?= base_url();?>admin/admission_applicant_convert/<?= $applicant_id;?>/">
                                                            <?= getPhrase('convert_to_student');?>
                                                        </a>
                                                    </li>
                                                    <?php endif;?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach;?>

<script>
function show_application() {
    document.getElementById("application_view").style.display = 'block';
}
</script>