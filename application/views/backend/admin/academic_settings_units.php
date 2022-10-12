<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <?php include 'academic_settings__nav.php' ?>
        </div>
        <div class="content-i">
            <div class="content-box">
                <div class="expense"><button class="btn btn-success btn-rounded btn-upper"
                        data-target="#new_unit" data-toggle="modal" type="button">+
                        <?php echo getPhrase('new_unit');?></button></div><br>
                <div class="element-wrapper">
                    <h6 class="element-header"><?php echo getPhrase('units');?></h6>
                    <div class="element-box-tp">
                        <div class="table-responsive">
                            <table class="table table-padded">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo getPhrase('name');?></th>
                                        <th><?php echo getPhrase('options');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $n = 1; 
                                            $untis = $this->db->get('units')->result_array(); 
                                            foreach($untis as $row):?>
                                    <tr>
                                        <td><?php echo $n++;?></td>
                                        <td><span><?php echo $row['name'];?></span></td>
                                        <td class="bolder">
                                            <a onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_unit/<?php echo $row['unit_id'];?>');"
                                                class="grey" href="javascript:void(0);" data-toggle="tooltip"
                                                data-placement="top"
                                                data-original-title="<?php echo getPhrase('edit');?>"><i
                                                    class="os-icon picons-thin-icon-thin-0001_compose_write_pencil_new"></i></a>
                                            <a class="grey" data-toggle="tooltip" data-placement="top"
                                                data-original-title="<?php echo getPhrase('delete');?>" class="danger"
                                                onClick="return confirm('<?php echo getPhrase('confirm_delete');?>')"
                                                href="<?php echo base_url();?>admin/units/delete/<?php echo $row['unit_id'];?>"><i
                                                    class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></a>
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="new_unit" tabindex="-1" role="dialog" aria-labelledby="new_unit"
                    aria-hidden="true" style="top:10%;">
                    <div class="modal-dialog window-popup edit-my-poll-popup" role="document">
                        <div class="modal-content">
                            <a href="javascript:void(0);" class="close icon-close" data-dismiss="modal"
                                aria-label="Close"></a>
                            <div class="modal-body">
                                <div class="modal-header" style="background-color:#00579c">
                                    <h6 class="title" style="color:white"><?php echo getPhrase('new_unit');?></h6>
                                </div>
                                <div class="ui-block-content">
                                    <form action="<?php echo base_url();?>admin/units/create"
                                        enctype="multipart/form-data" method="post" accept-charset="utf-8">
                                        <div class="row">
                                            <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label"><?php echo getPhrase('name');?></label>
                                                    <input class="form-control" type="text" name="name" required="">
                                                </div>
                                            </div>
                                            <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                <button class="btn btn-rounded btn-success"
                                                    type="submit"><?php echo getPhrase('save');?></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>