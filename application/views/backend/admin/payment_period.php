<?php
    $admin_type = $this->db->get_where('admin', array('admin_id' => $this->session->userdata('login_user_id')))->row()->owner_status;
?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <ul class="navs navs-tabs">
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/time_card/"><i class="picons-thin-icon-thin-0844_stopwatch_training_time"></i> <span><?php echo getPhrase('time_card');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/time_sheet/"><i class="picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i>  <span><?php echo getPhrase('time_sheet');?></span></a>
                    </li>
                    <?php if($admin_type == 1):?>
                    <li class="navs-item">
                        <a class="navs-links <?php if($page_name == 'payment_period') echo "active";?>" href="<?php echo base_url();?>admin/payment_period/"><i class="os-icon picons-thin-icon-thin-0406_money_dollar_euro_currency_exchange_cash"></i>  <span><?php echo getPhrase('payment_period');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/worker_schedule/"><i class="picons-thin-icon-thin-0021_calendar_month_day_planner"></i>  <span><?php echo getPhrase('worker_schedule');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/workers/"><i class="picons-thin-icon-thin-0704_users_profile_group_couple_man_woman"></i> <span><?php echo getPhrase('worker');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/worked_hours/"><i class="picons-thin-icon-thin-0100_to_do_list_reminder_done"></i>  <span><?php echo getPhrase('worked_hours');?></span></a>
                    </li>
                    <?php endif;?>
                </ul>
            </div>
        </div>
        <div class="content-i">
            <div class="content-box">                
                <div class="expense">
                    <button class="btn btn-success btn-rounded btn-upper"
                            data-target="#new_payment_period" 
                            data-toggle="modal" 
                            type="button">+
                    <?php echo getPhrase('new');?></button>
                </div>
                <br>
                <div class="element-wrapper">
                    <h4 class="element-header"><?php echo getPhrase('payment_periods');?></h4>
                    <div class="element-box-tp">
                        <div class="table-responsive">
                            <table class="table table-padded">
                                <thead>
                                    <tr>
                                        <th><?php echo getPhrase('name');?></th>
                                        <th><?php echo getPhrase('start_date');?></th>
                                        <th><?php echo getPhrase('end_date');?></th>
                                        <th><?php echo getPhrase('close_date');?></th>
                                        <th><?php echo getPhrase('payment_date');?></th>
                                        <th><?php echo getPhrase('status');?></th>
                                        <th class="text-center"><?php echo getPhrase('options');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $payment_periods = $this->db->get('payment_period')->result_array();
                                        foreach($payment_periods as $item):
                                    ?>
                                        <tr>
                                            <td><?= $item['name'];?></td>
                                            <td><?= $item['start_date'];?></td>
                                            <td><?= $item['end_date'];?></td>
                                            <td><?= $item['close_date'];?></td>
                                            <td><?= $item['payment_date'];?></td>
                                            <td class="text-center">
                                                    <?php if($item['active'] == 1):?>
                                                    <div class="pt-btn">
                                                        <a class="btn nc btn-success btn-sm btn-rounded">
                                                            <font color="white"><?php echo getPhrase('active');?>
                                                            </font>
                                                        </a>
                                                    </div>
                                                    <?php else:?>
                                                    <div class="pt-btn">
                                                        <a class="btn nc btn-danger btn-sm btn-rounded">
                                                            <font color="white"><?php echo getPhrase('inactive');?>
                                                            </font>
                                                        </a>
                                                    </div>
                                                    <?php endif;?>
                                                </td>
                                            <td class="row-actions">
                                                <a href="javascript:void(0);" class="grey"
                                                    onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_edit_payment_period/<?php echo $item['period_id'];?>');"><i
                                                        class="os-icon picons-thin-icon-thin-0001_compose_write_pencil_new"></i></a>
                                                <a href="javascript:void(0);" class="grey"
                                                    onClick="confirm_delete(<?= $item['period_id']; ?>)"><i
                                                        class="os-icon picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                </tbody>
                                
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="new_payment_period" tabindex="-1" role="dialog" aria-labelledby="new_payment_period"
                    aria-hidden="true">
                    <div class="modal-dialog window-popup create-friend-group create-friend-group-1" role="document">
                        <div class="modal-content">
                            <?php echo form_open(base_url() . 'admin/payment_period/create/');?>
                            <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close"></a>
                            <div class="modal-header" style="background-color:#00579c">
                                <h6 class="title" style="color:white"><?php echo getPhrase('new');?></h6>
                            </div>
                            <div class="modal-body">
                                <div class="form-group with-button">
                                    <label><?php echo getPhrase('name');?></label>
                                    <input class="form-control" name="name" type="text" required="">
                                </div>
                                <div class="form-group with-button">
                                    <label><?php echo getPhrase('start_date');?></label>
                                    <div class="form-group date-time-picker">
                                        <input type="text" autocomplete="off" class="datepicker-here" data-position="bottom left" data-language='en' name="start_date" id="start_date" required="">
                                    </div>
                                </div>
                                <div class="form-group with-button">
                                    <label><?php echo getPhrase('end_date');?></label>
                                    <div class="form-group date-time-picker">
                                        <input type="text" autocomplete="off" class="datepicker-here" data-position="bottom left" data-language='en' name="end_date" id="end_date" required="">
                                    </div>
                                </div>
                                <div class="form-group with-button">
                                    <label><?php echo getPhrase('close_date');?></label>
                                    <div class="form-group date-time-picker">
                                        <input type="text" autocomplete="off" class="datepicker-here" data-position="bottom left" data-language='en' name="close_date" id="close_date" required="">
                                    </div>
                                </div>
                                <div class="form-group with-button">
                                    <label><?php echo getPhrase('payment_date');?></label>
                                    <div class="form-group date-time-picker">
                                        <input type="text" autocomplete="off" class="datepicker-here" data-position="bottom left" data-language='en' name="payment_date" id="payment_date" required="">
                                    </div>
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
<script>
    function confirm_delete(period_id){

        Swal.fire({
            title: "<?= getPhrase('confirm_delete');?>",
            text: "<?= getPhrase('message_delete');?>",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "<?= getPhrase('delete');?>"
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = '<?php echo base_url();?>admin/payment_period/delete/' + period_id;
            }
        })
    }
</script>