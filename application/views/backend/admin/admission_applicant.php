<?php 
    $user_id = $this->session->userdata('login_user_id');
    $applicant_info = $this->db->get_where('applicant' , array('applicant_id' => $applicant_id))->result_array(); 
    $allow_actions = is_student($applicant_id);
    $is_international = is_international($applicant_id);

    foreach($applicant_info as $row): 
        $full_name_encode = base64_encode(str_replace(" ","_",strtoupper($row['full_name'])));
        $return_url = base64_encode('admission_applicant/'.$applicant_id);
        $tags_applicant = json_decode($row['tags'], true)['tags_id'];
        $status_info = $this->applicant->get_applicant_status_info($row['status']);
        $type_info = $this->applicant->get_type_info($row['type_id']);
        $assigned_to = $this->crud->get_name('admin', $row['assigned_to']);
?>
<style>
    th {
        cursor: pointer;
    }
</style>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <? include 'admission__nav.php';?>
        </div><br>
        <div class="row">
            <div class="content-i">
                <div class="content-box">
                    <div class="row">
                        <main class="col col-xl-9 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
                            <div id="newsfeed-items-grid">
                                <div class="ui-block paddingtel">
                                    <div class="user-profile">
                                        <?php include 'admission_applicant__header.php';?>
                                        <div class="ui-block">
                                            <div class="ui-block-title">
                                                <h6 class="title"><?= getPhrase('personal_information');?>
                                                </h6>
                                            </div>
                                            <div id="div_tags" class="ui-block-content" >
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
                                                            <li>
                                                                <span class="title"><?= getPhrase('assigned_to');?>:</span>
                                                                <span class="text"><?= $assigned_to;?></span>
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
                                                                    class="text"><?= $this->db->get_where('gender', array('code' => $row['gender']))->row()->name;?></span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <hr />
                                                <h6 class="title"><?= getPhrase('tags');?></h6>
                                                <div class="row">
                                                    <?php 
                                                    $tags = $this->applicant->get_tags();
                                                    foreach($tags as $tag):
                                                        $tag_id = $tag['tag_id'];
                                                    ?>
                                                    <div class="col-sm-2">
                                                        <div class="description-toggle">
                                                            <div class="description-toggle-content">
                                                                <div class="h7"><?= $tag['name'];?></div>
                                                            </div>
                                                            <div class="togglebutton">
                                                                <label>
                                                                    <input name="tag_<?=$tag_id?>" value="1" <?= $allow_actions == true ? "disabled" : ""?>
                                                                        type="checkbox" onchange="update_tag(this, <?=$tag_id?>)"
                                                                        <?php if(in_array($tag_id, $tags_applicant)) echo "checked";?>>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php endforeach;?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" ui-block-title row" style="border-style: none;">
                                            <div class="col-sm-4">
                                                <div class="row" style="justify-content: flex-end;">
                                                    <?php if($is_international):?>
                                                    <div class="form-buttons">
                                                        <button class="btn btn-rounded btn-primary" id="btn_show_form"
                                                            onclick="window.open('/admin/admission_applicant_form/<?=base64_encode($row['email'])?>', '_blank'); return false;">
                                                            <?= getPhrase('view_application_form');?></button>
                                                    </div> &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <div class="form-buttons">
                                                        <button class="btn btn-rounded btn-primary" id="btn_show"
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
                                                <br />
                                                <br />
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

                                            </div>
                                        </div>
                                        <?php endif;?>
                                        <br />
                                        <div class="ui-block">
                                            <div class="ui-block-title">
                                                <h6 class="col title"><?= getPhrase('task');?>
                                                </h6>
                                                <div class="col" style="justify-content: flex-end;">
                                                    <?php if(!$allow_actions):?>
                                                    <div class="form-buttons">
                                                        <button class="btn btn-rounded btn-primary"
                                                            onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_task_add/<?= $row['applicant_id'].'/applicant/'.$return_url;?>');">
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
                                                                $tasks = $this->db->get_where('task', array('user_type' => 'applicant', 'user_id' => $applicant_id))->result_array();

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
                                                                        <?= $this->crud->get_name('admin', $item['created_by']);?>
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
                                                                        <a href="<?php echo base_url();?>admin/task_info/<?= $item['task_code'];?>"
                                                                            class="grey" data-toggle="tooltip"
                                                                            data-placement="top"
                                                                            data-original-title="<?php echo getPhrase('view');?>">
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
                                                <h6 class="col title"><?= getPhrase('interactions');?>
                                                </h6>
                                                <div class="col" style="justify-content: flex-end;">
                                                    <?php if(!$allow_actions):?>
                                                    <div class="form-buttons">
                                                        <button class="btn btn-rounded btn-primary"
                                                            onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_admission_add_interaction/<?= $applicant_id;?>');">
                                                            <?= getPhrase('add_interaction');?></button>
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
                                                                $this->db->reset_query();
                                                                $this->db->where('applicant_id', $applicant_id);
                                                                $this->db->order_by('created_at', 'DESC');
                                                                $interactions = $this->db->get('v_applicant_interaction')->result_array();

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
                                                <? include 'admission_applicant__menu.php'?>
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
    function show_application() 
    {
        var current = document.getElementById("application_view").style.display;
        if (current == 'block') {
            document.getElementById("application_view").style.display = 'none';
            document.getElementById("btn_show").textContent = '<?= getPhrase('show_application');?>';
        } else {
            document.getElementById("application_view").style.display = 'block';
            document.getElementById("btn_show").textContent = '<?= getPhrase('hide_application');?>';
        }
    }

    function update_tag(checkboxElem, tag_id)
    {
        var isSelected = false;

        if (checkboxElem.checked) {
            isSelected = true;
        } else {
            isSelected = false;            
        }

        const loading = '<img src="<?= '/'.PATH_PUBLIC_ASSETS_IMAGES_FILES.'loader-1.gif';?>" />'
        $.ajax({
            url: '<?php echo base_url();?>admin/admission_applicant_update_tags/' + <?=$applicant_id;?> + '/' + tag_id + '/' + isSelected,
            beforeSend: function() {
                $('#div_tags :input').attr('disabled', true);
            },
            success: function(response) {
                $('#div_tags :input').attr('disabled', false);
            }
        });
    }
</script>
<script type="text/javascript">
    $('th').click(function () {
        var table = $(this).parents('table').eq(0)
        var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()))
        this.asc = !this.asc
        if (!this.asc) { rows = rows.reverse() }
        for (var i = 0; i < rows.length; i++) { table.append(rows[i]) }
    })
    function comparer(index) {
        return function (a, b) {
            var valA = getCellValue(a, index), valB = getCellValue(b, index)
            return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.toString().localeCompare(valB)
        }
    }
    function getCellValue(row, index) { return $(row).children('td').eq(index).text() }
</script>