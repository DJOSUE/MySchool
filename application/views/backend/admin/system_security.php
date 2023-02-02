<?php

    $this->db->reset_query();
    $this->db->where_not_in('role_id', '1');
    $this->db->order_by('table ASC, name ASC');
    $roles = $this->db->get('roles')->result_array();


?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <ul class="navs navs-tabs upper">
                    <li class="navs-item">
                        <a class="navs-links" href="<?= base_url();?>admin/system_settings/">
                            <i class="os-icon picons-thin-icon-thin-0050_settings_panel_equalizer_preferences"></i>
                            <span><?= getPhrase('system_settings');?></span>
                        </a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links active" href="<?= base_url();?>admin/system_security/">
                            <i
                                class="picons-thin-icon-thin-0328_computer_screen_locked_password_protected_security"></i>
                            <span><?= getPhrase('system_security');?></span>
                        </a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?= base_url();?>admin/system_sms/">
                            <i class="os-icon picons-thin-icon-thin-0287_mobile_message_sms"></i>
                            <span><?= getPhrase('sms');?></span>
                        </a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?= base_url();?>admin/system_email/">
                            <i class="os-icon picons-thin-icon-thin-0315_email_mail_post_send"></i>
                            <span><?= getPhrase('email_settings');?></span>
                        </a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?= base_url();?>admin/system_translate/">
                            <i
                                class="os-icon picons-thin-icon-thin-0307_chat_discussion_yes_no_pro_contra_conversation"></i>
                            <span><?= getPhrase('translate');?></span>
                        </a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?= base_url();?>admin/system_database/">
                            <i class="picons-thin-icon-thin-0356_database"></i>
                            <span><?= getPhrase('database');?></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="content-i">
            <div class="content-box">
                <div class="element-box lined-purple shadow" style="border-radius:10px;">
                    <h4 class="form-header"><i class="picons-thin-icon-thin-0095_file_protected_password_security"></i>
                        <?= getPhrase('role_access');?></h4><br>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group label-floating is-select">
                                <label class="control-label"><?= getPhrase('role');?></label>
                                <div class="select">
                                    <select name="language" required="" onchange="get_list(this)">
                                        <option value=""><?= getPhrase('select');?></option>
                                        <?php 
                                            foreach ($roles as $row) {
                                        ?>
                                        <option value="<?= $row['role_id'];?>">
                                            <?= $row['name'];?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="expense">
                            <button class="btn btn-success btn-rounded btn-upper" data-target="#new_account_role"
                                data-toggle="modal" type="button">
                                +<?= getPhrase('new_access');?>
                            </button>
                        </div>
                    </div>

                    <div class="row" id="search_result">

                    </div>
                </div>
            </div>
        </div>
        <div class="content-i">
            <div class="content-box">
                <div class="expense">
                    <button class="btn btn-success btn-rounded btn-upper" data-target="#new_role" data-toggle="modal"
                        type="button">
                        +<?= getPhrase('new');?>
                    </button>
                </div>
                <br>
                <div class="element-wrapper">
                    <h6 class="element-header"><?= getPhrase('Roles');?></h6>
                    <div class="element-box-tp">
                        <div class="table-responsive">
                            <table class="table table-padded">
                                <thead>
                                    <tr>
                                        <th><?= getPhrase('name');?></th>
                                        <th><?= getPhrase('table');?></th>
                                        <th><?= getPhrase('status');?></th>
                                        <th class="text-center"><?= getPhrase('options');?></th>
                                    </tr>
                                </thead>
                                <?php                                     
                                    foreach($roles as $row):
                                ?>
                                <tr>
                                    <td><?= $row['name'];?></td>
                                    <td><?= $row['table'];?></td>
                                    <td><?= $row['status'];?></td>
                                    <td class="row-actions">
                                        <a href="javascript:void(0);" class="grey"
                                            onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_system_roles_edit/<?= $row['role_id'];?>');"><i
                                                class="os-icon picons-thin-icon-thin-0001_compose_write_pencil_new"></i></a>
                                        <!-- <a style="color:grey"
                                            onClick="return confirm('<?= getPhrase('confirm_delete');?>')"
                                            href="<?= base_url();?>admin/grade/delete/<?= $row['grade_id'];?>"><i
                                                class="os-icon picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></a> -->
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

<div class="modal fade" id="new_account_role" tabindex="-1" role="dialog" aria-labelledby="new_account_role"
    aria-hidden="true">
    <div class="modal-dialog window-popup create-friend-group create-friend-group-1" role="document">
        <div class="modal-content">
            <?= form_open(base_url() . 'admin/account_role/add/');?>
            <a href="javascript:void(0);" class="close icon-close" data-dismiss="modal" aria-label="Close"></a>
            <div class="modal-header">
                <h6 class="title"><?= getPhrase('new_access');?></h6>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="" for=""> <?php echo getPhrase('role');?></label>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <div class="select">
                                <select name="role_id" required="" style="width: 250px;">
                                    <?php 
                                            foreach ($roles as $row) {
                                        ?>
                                        <option value="<?= $row['role_id'];?>">
                                            <?= $row['name'];?>
                                        </option>
                                        <?php } ?>
                                </select>
                            </div>
                            <!-- <input class="form-control" name="status" value="<?php echo $row['status'];?>" required="" type="text"> -->
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label><?= getPhrase('type');?></label>
                    <input class="form-control" name="type" type="text" required="">
                </div>
                <div class="form-group">
                    <label class="" for=""> <?php echo getPhrase('permissions');?></label>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <div class="select">
                                <select name="permissions" required="" style="width: 250px;">
                                    <option value="0" >
                                        <?= getPhrase('forbid')?>
                                    </option>
                                    <option value="1" selected>
                                        <?= getPhrase('allow')?>
                                    </option>
                                </select>
                            </div>
                            <!-- <input class="form-control" name="status" value="<?php echo $row['status'];?>" required="" type="text"> -->
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-rounded btn-success btn-lg full-width">
                    <?= getPhrase('save');?>
                </button>
            </div>
            <?= form_close();?>
        </div>
    </div>
</div>

<div class="modal fade" id="new_" tabindex="-1" role="dialog" aria-labelledby="new_grade" aria-hidden="true">
    <div class="modal-dialog window-popup create-friend-group create-friend-group-1" role="document">
        <div class="modal-content">
            <?= form_open(base_url() . 'admin/role/create/');?>
            <a href="javascript:void(0);" class="close icon-close" data-dismiss="modal" aria-label="Close"></a>
            <div class="modal-header">
                <h6 class="title"><?= getPhrase('new');?></h6>
            </div>
            <div class="modal-body">
                <div class="form-group with-button">
                    <label><?= getPhrase('name');?></label>
                    <input class="form-control" name="name" type="text" required="">
                </div>
                <div class="form-group with-button">
                    <label><?= getPhrase('table');?></label>
                    <input class="form-control" name="table" type="text" required="">
                </div>
                <button type="submit"
                    class="btn btn-rounded btn-success btn-lg full-width"><?= getPhrase('save');?></button>
            </div>
            <?= form_close();?>
        </div>
    </div>
</div>

<script>
function get_list(option) {
    const role_id = option.value;

    const loading = '<img src="<?= '/'.PATH_PUBLIC_ASSETS_IMAGES_FILES.'loader-1.gif';?>" />'
    $.ajax({
        url: '<?php echo base_url();?>admin/get_role_access/' + role_id,
        beforeSend: function() {
            jQuery('#search_result').html(loading);
        },
        success: function(response) {
            jQuery('#search_result').html(response);
        }
    });
}
</script>