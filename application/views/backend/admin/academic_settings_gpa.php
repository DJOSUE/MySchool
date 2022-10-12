<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <?php include 'academic_settings__nav.php'; ?>
        </div>
        <div class="content-i">
            <div class="content-box">
                <div class="expense"><button class="btn btn-success btn-rounded btn-upper"
                        data-target="#new_gpa" data-toggle="modal" type="button">+
                        <?php echo getPhrase('new');?></button></div><br>
                <div class="element-wrapper">
                    <h6 class="element-header"><?php echo getPhrase('gpa_levels');?></h6>
                    <div class="element-box-tp">
                        <div class="table-responsive">
                            <table class="table table-padded">
                                <thead>
                                    <tr>
                                        <th><?php echo getPhrase('name');?></th>
                                        <th><?php echo getPhrase('gpa_point');?></th>
                                        <th><?php echo getPhrase('mark_from');?></th>
                                        <th><?php echo getPhrase('mark_to');?></th>
                                        <th class="text-center"><?php echo getPhrase('options');?></th>
                                    </tr>
                                </thead>
                                <?php 
                                            $gpas = $this->db->get('gpa')->result_array();
                                            foreach($gpas as $row):
                                        ?>
                                <tr>
                                    <td><?php echo $row['name'];?></td>
                                    <td><?php echo $row['gpa_point'];?></td>
                                    <td><?php echo $row['mark_from'];?></td>
                                    <td><?php echo $row['mark_upto'];?></td>
                                    <td class="row-actions">
                                        <a href="javascript:void(0);" class="grey"
                                            onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_edit_gpa/<?php echo $row['gpa_id'];?>');"><i
                                                class="os-icon picons-thin-icon-thin-0001_compose_write_pencil_new"></i></a>
                                        <a style="color:grey"
                                            onClick="return confirm('<?php echo getPhrase('confirm_delete');?>')"
                                            href="<?php echo base_url();?>admin/gpa/delete/<?php echo $row['gpa_id'];?>"><i
                                                class="os-icon picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="new_gpa" tabindex="-1" role="dialog" aria-labelledby="new_gpa"
                    aria-hidden="true">
                    <div class="modal-dialog window-popup create-friend-group create-friend-group-1" role="document">
                        <div class="modal-content">
                            <?php echo form_open(base_url() . 'admin/gpa/create/');?>
                            <a href="javascript:void(0);" class="close icon-close" data-dismiss="modal"
                                aria-label="Close"></a>
                            <div class="modal-header">
                                <h6 class="title"><?php echo getPhrase('new');?></h6>
                            </div>
                            <div class="modal-body">
                                <div class="form-group with-button">
                                    <label><?php echo getPhrase('name');?></label>
                                    <input class="form-control" name="name" type="text" required="">
                                </div>
                                <div class="form-group with-button">
                                    <label><?php echo getPhrase('point');?></label>
                                    <input class="form-control" name="gpa_point" type="text" required="">
                                </div>
                                <div class="form-group with-button">
                                    <label><?php echo getPhrase('mark_from');?></label>
                                    <input class="form-control" name="from" type="text" required="">
                                </div>
                                <div class="form-group with-button">
                                    <label><?php echo getPhrase('mark_to');?></label>
                                    <input class="form-control" name="to" type="text" required="">
                                </div>
                                <button type="submit"
                                    class="btn btn-rounded btn-success btn-lg full-width"><?php echo getPhrase('save');?></button>
                            </div>
                            <?php echo form_close();?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>