<?php 
    $this->db->reset_query();
    $this->db->where('task_code' , $task_code);
    $task_query = $this->db->get('task');
    $tasks = $task_query->result_array();

    $fancy_path         =   $_SERVER['DOCUMENT_ROOT'].'/application/views/backend/'.$account_type.'/';
    $account_type       =   get_table_user($this->session->userdata('role_id'));

?>
<div class="content-w">
    <?php include $fancy_path.'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <?php include 'task__nav.php';?>
            </div>
        </div><br>
        <div class="row">
            <div class="content-i">
                <div class="content-box">
                    <div class="row">
                        <?php 
                        foreach ($tasks as $row):
                            $user_info      = $this->crud->get_user_info($row['user_type'], $row['user_id']);
                            $status_info    = $this->task->get_status_info($row['status_id']);
                            $priority_info  = $this->task->get_priority_info($row['priority_id']);
                            $category_info  = $this->task->get_category_info($row['category_id']);
                            $description    = str_replace(array("\r", "\n"), '', $row['description']);
                            $default_user   = explode('|',$category_info['default_user']);
                            $df_user_table  = $default_user[0];

                            // echo '<pre>';
                            // var_dump($default_user);
                            // echo '</pre>';
                        ?>
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
                                                            src="<?= $this->crud->get_image_url($row['user_type'], $row['user_id']);?>"
                                                            style="background-color:#fff;">
                                                    </div>
                                                </div>
                                                <h3 class="text-white"><?= $user_info['first_name'];?>
                                                    <?= $user_info['last_name'];?></h3>
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
                                                        <div><?= getPhrase('priority');?>:</div>
                                                        <div class="value badge-status badge-pill badge-primary"
                                                            style="background-color: <?= $priority_info['color']?>;">
                                                            <?= $priority_info['name'];?>
                                                        </div>
                                                    </div>
                                                    <div class="value-pair">
                                                        <div><?= getPhrase('status_task');?>:</div>
                                                        <div class="value badge-status badge-pill badge-primary"
                                                            style="background-color: <?= $status_info['color']?>;">
                                                            <?= $status_info['name'];?>
                                                        </div>
                                                    </div>
                                                    <div class="value-pair">
                                                        <div><?= getPhrase('type_user');?>:</div>
                                                        <div class="value badge-status badge-pill badge-primary">
                                                            <?= $row['user_type'];?>
                                                        </div>
                                                    </div>
                                                    <div class="value-pair">
                                                        <div><?= getPhrase('user_status');?>:</div>
                                                        <?php 
                                                            $user_status_info = $this->task->get_user_status($row['user_type'], $row['user_id']);
                                                        ?>
                                                        <div class="value badge-status badge-pill badge-primary"
                                                            style="background-color: <?= $user_status_info['color']?>;">
                                                            <?= $user_status_info['name'];?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ui-block">
                                            <div class="ui-block-title">
                                                <h6 class="title"><?= getPhrase('task_information');?>
                                                </h6>
                                            </div>
                                            <div class="ui-block-content">
                                            <?php echo form_open(base_url() . 'assignment/task/update/'.$row['task_id'].'/' , array('enctype' => 'multipart/form-data'));?>
                                                <div class="row">
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating">
                                                            <label
                                                                class="control-label"><?php echo getPhrase('title');?></label>
                                                            <input class="form-control" name="title"
                                                                value="<?php echo $row['title'];?>" type="text"
                                                                required="">
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating is-select">
                                                            <label
                                                                class="control-label"><?php echo getPhrase('assigned_to');?></label>
                                                            <div class="select">
                                                                <select name="assigned_to">
                                                                    <option value=""><?= getPhrase('select');?></option>
                                                                    <?php $default_users = $this->db->get_where($df_user_table, array('status' => 1))->result_array();
                                                                    foreach($default_users as $item):
                                                                        $id = $df_user_table.'_id';
                                                                    ?>
                                                                    <option value="<?= $df_user_table.'|'.$item[$id];?>"
                                                                        <?= $item[$id] == $row['assigned_to'] ? 'selected': ''; ?>>
                                                                        <?= $item['first_name']?>
                                                                    </option>
                                                                    <?php endforeach;?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                <?php echo getPhrase('description');?>
                                                            </label>
                                                            <textarea id="ckeditor1" name="description" required="">
                                                                <?=html_entity_decode($description);?>
                                                            </textarea>

                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="form-buttons-w">
                                                            <button class="btn btn-rounded btn-success" type="submit">
                                                                <?php echo getPhrase('update');?></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php echo form_close();?>
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
                                                                <span class="text"><?= $user_info['first_name'];?>
                                                                    <?= $user_info['last_name'];?></span>
                                                            </li>
                                                            <li>
                                                                <span class="title"><?= getPhrase('email');?>:</span>
                                                                <span class="text"><?= $user_info['email'];?></span>
                                                            </li>
                                                            <li>
                                                                <span class="title"><?= getPhrase('address');?>:</span>
                                                                <span class="text"><?= $user_info['address'];?></span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <ul class="widget w-personal-info item-block">
                                                            <li>
                                                                <span class="title"><?= getPhrase('phone');?>:</span>
                                                                <span class="text"><?= $user_info['phone'];?></span>
                                                            </li>
                                                            <li>
                                                                <span class="title"><?= getPhrase('birthday');?>:</span>
                                                                <span class="text"><?= $user_info['birthday'];?></span>
                                                            </li>
                                                            <li>
                                                                <span class="title"><?= getPhrase('gender');?>:</span>
                                                                <span
                                                                    class="text"><?= $this->crud->get_gender_user($user_info['gender']);?></span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </main>
                        <?php endforeach;?>
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
                                                            style="font-size:20px;"></i> &nbsp;&nbsp;&nbsp;
                                                        <a href="<?= base_url();?>assignment/task_info/<?= $task_code;?>/">
                                                            <?= getPhrase('task_information');?>
                                                        </a>
                                                    </li>
                                                    <?php if(!$allow_actions):?>
                                                    <li>
                                                        <i class="picons-thin-icon-thin-0133_arrow_right_next menu_left_selected_icon"
                                                            style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                        <a class="menu_left_selected_text"
                                                            href="<?= base_url();?>assignment/task_update/<?= $task_code;?>/">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
if ($('#ckeditor1').length) {

    CKEDITOR.replace('ckeditor1', {
        toolbar: 'Basic'
    });

    var t = "<?=html_entity_decode($description);?>";

    CKEDITOR.instances.ckeditor1.setData(t.replace(/(\r\n|\n|\r)/gm, ""));
}
</script>