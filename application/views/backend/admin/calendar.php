<script src="<?php echo base_url();?>public/style/js/admin_calendar.js"></script>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty"><br>
        <div class="container-fluid">
            <div class="layout-w">
                <div class="content-w">
                    <div class="container-fluid">
                        <div class="element-box">
                            <h3 class="form-header"><?php echo getPhrase('calendar_events');?></h3><br>
                            <div class="table-responsive">
                                <div id="admin_calendar" class="col-centered"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="display-type"></div>
        </div>
        <?php if(has_permission('calendar_management')):?>
        <div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="ModalEdit"
            aria-hidden="true">
            <div class="modal-dialog window-popup create-friend-group create-friend-group-1" role="document">
                <div class="modal-content">
                    <form method="POST" action="<?php echo base_url()?>admin/calendar/update">
                        <a href="javascript:void(0);" class="close icon-close" data-dismiss="modal"
                            aria-label="Close"></a>
                        <div class="modal-header">
                            <h6 class="title"><?php echo getPhrase('edit_event');?></h6>
                        </div>
                        <div class="modal-body">
                            <div class="form-group with-button">
                                <input class="form-control" name="title" placeholder="<?php echo getPhrase('title');?>"
                                    type="text" id="title" required="">
                            </div>
                            <div class="form-group label-floating is-select">
                                <label class="control-label"><?php echo getPhrase('color');?></label>
                                <div class="select">
                                    <select name="color" id="colore" required="">
                                        <option class="e-blue" value="e-blue">&#9724; <?php echo getPhrase('blue');?>
                                        </option>
                                        <option class="e-turquoise" value="e-turquoise">&#9724;
                                            <?php echo getPhrase('turquoise');?></option>
                                        <option class="e-green" value="e-green">&#9724; <?php echo getPhrase('green');?>
                                        </option>
                                        <option class="e-yellow" value="e-yellow">&#9724;
                                            <?php echo getPhrase('yellow');?></option>
                                        <option class="e-orange" value="e-orange">&#9724;
                                            <?php echo getPhrase('orange');?></option>
                                        <option class="e-red" value="e-red">&#9724; <?php echo getPhrase('red');?>
                                        </option>
                                        <option class="e-black" value="e-black">&#9724; <?php echo getPhrase('black');?>
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="id" class="form-control" id="id">
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <div class="checkbox">
                                        <label class="text-danger"><input type="checkbox" name="delete">
                                            <?php echo getPhrase('delete');?></label>
                                    </div>
                                </div>
                            </div>
                            <button type="submit"
                                class="btn btn-rounded btn-success btn-lg full-width"><?php echo getPhrase('update');?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="ModalAdd" aria-hidden="true">
            <div class="modal-dialog window-popup create-friend-group create-friend-group-1" role="document">
                <div class="modal-content">
                    <form method="POST" action="<?php echo base_url()?>admin/calendar/create">
                        <a href="javascript:void(0);" class="close icon-close" data-dismiss="modal"
                            aria-label="Close"></a>
                        <div class="modal-header">
                            <h6 class="title"><?php echo getPhrase('add_event');?></h6>
                        </div>
                        <div class="modal-body">
                            <div class="form-group with-button">
                                <input class="form-control" name="title" placeholder="<?php echo getPhrase('title');?>"
                                    type="text" id="title" required="">
                            </div>
                            <div class="form-group label-floating is-select">
                                <label class="control-label"><?php echo getPhrase('color');?></label>
                                <div class="select">
                                    <select name="color" id="color" required="">
                                        <option value=""><?php echo getPhrase('select');?></option>
                                        <option class="e-blue" value="e-blue">&#9724; <?php echo getPhrase('blue');?>
                                        </option>
                                        <option class="e-turquoise" value="e-turquoise">&#9724;
                                            <?php echo getPhrase('turquoise');?></option>
                                        <option class="e-green" value="e-green">&#9724; <?php echo getPhrase('green');?>
                                        </option>
                                        <option class="e-yellow" value="e-yellow">&#9724;
                                            <?php echo getPhrase('yellow');?></option>
                                        <option class="e-orange" value="e-orange">&#9724;
                                            <?php echo getPhrase('orange');?></option>
                                        <option class="e-red" value="e-red">&#9724; <?php echo getPhrase('red');?>
                                        </option>
                                        <option class="e-black" value="e-black">&#9724; <?php echo getPhrase('black');?>
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group with-button">
                                <label><?php echo getPhrase('start_date');?></label>
                                <div class="input-group">
                                    <input type="text" required class="datepicker-here" data-timepicker="true"
                                        data-language="en" placeholder="<?php echo getPhrase('start_date');?>"
                                        id="start" data-position="top left" data-time-format="hh:ii" name="start"
                                        data-date-format="yyyy-mm-dd">
                                </div>
                            </div>
                            <div class="form-group with-button">
                                <label><?php echo getPhrase('end_date');?></label>
                                <input type="text" required class="datepicker-here" data-timepicker="true"
                                    data-language="en" placeholder="<?php echo getPhrase('start_date');?>" id="end"
                                    data-position="top left" data-time-format="hh:ii" name="end"
                                    data-date-format="yyyy-mm-dd">
                            </div>
                            <button type="submit"
                                class="btn btn-rounded btn-success btn-lg full-width"><?php echo getPhrase('add');?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endif;?>
    </div>
</div>