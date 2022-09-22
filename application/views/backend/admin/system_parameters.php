<?php     
    if($parameter_id != '')
    {
        $this->db->where('parameter_id' , $parameter_id);
    }  
    $parameters_query = $this->db->get('parameters');
    $parameters = $parameters_query->result_array();

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
                        <a class="navs-links" href="<?= base_url();?>admin/system_security/">
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
                    <li class="navs-item">
                        <a class="navs-links active" href="<?= base_url();?>admin/system_parameters/">
                            <i class="picons-thin-icon-thin-0244_text_bullets_list"></i>
                            <span><?= getPhrase('parameters');?></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="container-fluid">
            <div class="content-i">
                <div class="content-box">
                    <div class="element-box-tp">
                        <h5 class="form-header"><?= getPhrase('system_parameters');?></h5>
                        <div class="row">
                            <div class="content-i">
                                <div class="content-box">
                                    <?= form_open(base_url() . 'admin/system_parameters/', array('class' => 'form m-b'));?>
                                    <div class="row" style="margin-top: -30px; border-radius: 5px;">
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating"
                                                style="border: 1px solid #EAEAF5;border-radius: 5px; background: white;">
                                                <label class="control-label"><?= getPhrase('name');?></label>
                                                <input class="form-control" name="name" type="text" value="<?= $name?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?= getPhrase('parameter_id');?></label>
                                                <div class="select">
                                                    <select name="parameter_id">
                                                        <option value=""><?= getPhrase('select');?></option>
                                                        <?php
                                                        $parametersID = $this->system->get_parameters_id();
                                                        foreach($parametersID as $row):
                                                    ?>
                                                        <option value="<?= $row['parameter_id'];?>"
                                                            <?php if($parameter_id == $row['parameter_id']) echo "selected";?>>
                                                            <?= $row['parameter_id'];?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <button class="btn btn-success btn-upper" style="margin-top:20px"
                                                    type="submit"><span><?= getPhrase('search');?></span></button>
                                            </div>
                                        </div>
                                    </div>
                                    <?= form_close();?>
                                </div>
                            </div>
                        </div>
                        <div class="row content-i">
                            <div class="content-box">
                                <div class="expense">
                                    <button class="btn btn-success btn-rounded btn-upper" data-target="#new_parameter"
                                        data-toggle="modal" type="button">
                                        +<?= getPhrase('new');?>
                                    </button>
                                </div>
                                <br>
                                <div class="element-wrapper">
                                    <h6 class="element-header"><?= getPhrase('parameters');?></h6>
                                    <div class="element-box-tp">
                                        <div class="table-responsive">
                                            <table class="table table-padded">
                                                <thead>
                                                    <tr>
                                                        <th><?= getPhrase('parameter_id');?></th>
                                                        <th><?= getPhrase('level_1');?></th>
                                                        <th><?= getPhrase('level_2');?></th>
                                                        <th><?= getPhrase('code');?></th>
                                                        <th><?= getPhrase('name');?></th>
                                                        <th><?= getPhrase('value_1');?></th>
                                                        <th><?= getPhrase('value_2');?></th>
                                                        <th><?= getPhrase('value_3');?></th>
                                                        <th><?= getPhrase('value_4');?></th>
                                                        <th><?= getPhrase('status');?></th>
                                                        <th class="text-center"><?= getPhrase('options');?></th>
                                                    </tr>
                                                </thead>
                                                <?php
                                                    foreach($parameters as $row):
                                                        $text_id = $row['parameter_id']."|".$row['level_1']."|".$row['level_2']."|".$row['code'];
                                                        $id = base64_encode($text_id);
                                                ?>
                                                <tr>
                                                    <td><?= $row['parameter_id'];?></td>
                                                    <td><?= $row['level_1'];?></td>
                                                    <td><?= $row['level_2'];?></td>
                                                    <td><?= $row['code'];?></td>
                                                    <td><?= $row['name'];?></td>
                                                    <td><?= $row['value_1'];?></td>
                                                    <td><?= $row['value_2'];?></td>
                                                    <td><?= $row['value_3'];?></td>
                                                    <td><?= $row['value_4'];?></td>
                                                    <td><?= $row['status'];?></td>
                                                    <td class="row-actions">
                                                        <a href="javascript:void(0);" class="grey"
                                                            onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_system_parameter_edit/<?= $id;?>');"><i
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
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="new_parameter" tabindex="-1" role="dialog" aria-labelledby="new_account_role"
    aria-hidden="true">
    <div class="modal-dialog window-popup create-friend-group create-friend-group-1" role="document">
        <div class="modal-content">
            <?= form_open(base_url() . 'admin/parameters/add/');?>
            <a href="javascript:void(0);" class="close icon-close" data-dismiss="modal" aria-label="Close"></a>
            <div class="modal-header">
                <h6 class="title"><?= getPhrase('new_access');?></h6>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('parameter_id');?></label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="picons-thin-icon-thin-0003_write_pencil_new_edit"></i>
                            </div>
                            <div class="select">
                                <select name="parameter_id" style="width: 150px;">
                                    <?php
                                    $parametersID = $this->system->get_parameters_id();
                                    foreach($parametersID as $row):
                                ?>
                                    <option value="<?= $row['parameter_id'];?>"
                                        <?php if($parameter_id == $row['parameter_id']) echo "selected";?>>
                                        <?= $row['parameter_id'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('level_1');?></label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="picons-thin-icon-thin-0003_write_pencil_new_edit"></i>
                            </div>
                            <input class="form-control" name="level_1" required="" type="text">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('level_2');?></label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="picons-thin-icon-thin-0003_write_pencil_new_edit"></i>
                            </div>
                            <input class="form-control" name="level_2" required="" type="text">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('code');?></label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="picons-thin-icon-thin-0003_write_pencil_new_edit"></i>
                            </div>
                            <input class="form-control" name="code" required="" type="text">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('name');?></label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="picons-thin-icon-thin-0003_write_pencil_new_edit"></i>
                            </div>
                            <input class="form-control" name="name" required="" type="text">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('value_1');?></label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="picons-thin-icon-thin-0003_write_pencil_new_edit"></i>
                            </div>
                            <input class="form-control" name="value_1" type="text">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('value_2');?></label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="picons-thin-icon-thin-0003_write_pencil_new_edit"></i>
                            </div>
                            <input class="form-control" name="value_2" type="text">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('value_3');?></label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="picons-thin-icon-thin-0003_write_pencil_new_edit"></i>
                            </div>
                            <input class="form-control" name="value_3" type="text">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('value_4');?></label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="picons-thin-icon-thin-0003_write_pencil_new_edit"></i>
                            </div>
                            <input class="form-control" name="value_4" type="text">
                        </div>
                    </div>
                </div>
                <div class="form-buttons-w">
                    <button class="btn btn-rounded btn-success" style="float: right;" type="submit">
                        <?= getPhrase('save');?>
                    </button>
                </div>
                <br>
            </div>
            <?= form_close();?>
        </div>
    </div>
</div>