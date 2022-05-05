<?php
    $user_id = $this->session->userdata('login_user_id');    
    $payment_period = $this->db->get_where('payment_period', array('period_id' => $period_id))->row();    
    // $worker = $this->db->get_where('worker', array('type_user' => 'admin', 'user_id' => $user_id))->row();
    // $worker_id = $worker->worker_id;    

    // $total_hours = $this->db->query("SELECT TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(`hours_worked`))),'%H:%i') AS Total 
    //                                    FROM v_time_sheet
    //                                   WHERE date BETWEEN '$payment_period->start_date' AND '$payment_period->end_date'")->row();
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
                        <a class="navs-links" href="<?php echo base_url();?>admin/payment_period/"><i class="os-icon picons-thin-icon-thin-0406_money_dollar_euro_currency_exchange_cash"></i>  <span><?php echo getPhrase('payment_period');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/worker_schedule/"><i class="picons-thin-icon-thin-0021_calendar_month_day_planner"></i>  <span><?php echo getPhrase('worker_schedule');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/workers/"><i class="picons-thin-icon-thin-0704_users_profile_group_couple_man_woman"></i> <span><?php echo getPhrase('worker');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links active" href="<?php echo base_url();?>admin/worked_hours/"><i class="picons-thin-icon-thin-0100_to_do_list_reminder_done"></i>  <span><?php echo getPhrase('worked_hours');?></span></a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="content-i">
            <div class="content-box">                
                <div class="col-sm">
                    <div class="element-box lined-primary shadow" style="padding-left: 50px;">
                        <!-- Dropdown Period -->
                        <?php echo form_open(base_url() . 'admin/worked_hours/', array('class' => 'form m-b'));?>
                        <div class="row sm">
                            <div class="container align-center">                            
                                <div class="form-group label-floating is-select">
                                    <label class="control-label"><?= getPhrase('payment_period');?></label>
                                    <div class="select">
                                        <select name="selected_period_id" id="selected_period_id" onchange="submit();">
                                            <?php $payment_period_list = $this->db->query('SELECT * FROM payment_period ORDER BY end_date DESC')->result_array();
                                            foreach($payment_period_list as $item):
                                        ?>
                                            <option value="<?= $item['period_id'];?>" <?php if($item['period_id'] == $period_id) echo 'selected';?>>
                                                <?= $item['name'];?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>                            
                            </div>
                        </div>
                        <?php echo form_close();?>
                        <!-- Timesheet -->
                        <div class="row table-responsive align-center">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col"><?=getPhrase('name')?></th>
                                        <th scope="col"><?=getPhrase('total_hours')?></th>
                                        <th scope="col"><?=getPhrase('notes')?></th>
                                        <th scope="col"><?=getPhrase('options')?></th>
                                    </tr>
                                </thad>
                                <tbody>
                                    <?php 
                                        $timesheet = $this->db->query("SELECT * FROM v_workers WHERE status = '1'")->result_array();
                                        foreach ($timesheet as $key => $value):
                                            $worker_id = $value['worker_id'];  
                                            $issues = $this->db->query("SELECT COUNT(*) as 'count' FROM time_sheet WHERE worker_id = $worker_id AND `clock_out` is null AND date BETWEEN '$payment_period->start_date' AND '$payment_period->end_date'")->first_row()->count;
                                            $timesheet = $this->db->query("SELECT worker_id, SEC_TO_TIME(TIME_TO_SEC(hours_worked)) AS hours_worked FROM v_time_sheet WHERE worker_id = $worker_id and date BETWEEN '$payment_period->start_date' AND '$payment_period->end_date' GROUP by worker_id")->first_row()->hours_worked;
                                    ?>                                            
                                    <tr>
                                        <td>
                                            <?= $value['name']; ?>
                                        </td>
                                        <td>
                                            <?= $timesheet; ?>
                                        </td>
                                        <td>
                                            <?php 
                                                if ($issues > 0){
                                                    echo getPhrase('time_sheet_error');
                                                }
                                            ?>
                                        </td>
                                        <td class="row-actions">
                                            <a href="javascript:void(0);" 
                                                style="color:grey"
                                                data-toggle="tooltip" 
                                                data-placement="top"
                                                data-original-title="<?php echo getPhrase('view');?>"
                                                onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_worker_timesheet/<?= $value['worker_id'];?>/<?= $period_id;?>');">
                                                <i class="os-icon picons-thin-icon-thin-0043_eye_visibility_show_visible"></i>
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
    </div>
</div>