<?php
    $user_id = $this->session->userdata('login_user_id');    
    $payment_period = $this->db->get_where('payment_period', array('period_id' => $period_id))->row();    
    $worker = $this->db->get_where('worker', array('type_user' => 'teacher', 'user_id' => $user_id))->row();
    $worker_id = $worker->worker_id;    

    $total_hours = $this->db->query("SELECT TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(`hours_worked`))),'%H:%i') AS Total 
                                       FROM v_time_sheet
                                       WHERE worker_id = '$worker_id'
                                      AND date BETWEEN '$payment_period->start_date' AND '$payment_period->end_date'")->row();
?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <ul class="navs navs-tabs">
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>teacher/time_card/"><i class="picons-thin-icon-thin-0844_stopwatch_training_time"></i> <span><?php echo getPhrase('time_card');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links <?php if($page_name == 'time_sheet') echo "active";?>" href="<?php echo base_url();?>teacher/time_sheet/"><i class="picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i>  <span><?php echo getPhrase('time_sheet');?></span></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="content-i">
            <div class="content-box">                
                <div class="col-sm">
                    <div class="element-box lined-primary shadow" style="padding-left: 50px;">
                        <!-- Dropdown Period -->
                        <?php echo form_open(base_url() . 'teacher/time_sheet/', array('class' => 'form m-b'));?>
                        <div class="row sm">
                            <div class="container align-center">                            
                                <div class="form-group label-floating is-select">
                                    <label class="control-label"><?= getPhrase('payment_period');?></label>
                                    <div class="select">
                                        <select name="select_period_id" id="select_period_id" onchange="submit();">
                                            <option value=""><?php echo getPhrase('select');?></option>
                                            <?php $payment_period_list = $this->db->query('SELECT * FROM payment_period ORDER BY end_date DESC')->result_array(); 
                                            foreach($payment_period_list as $item):
                                            ?>
                                            <option value="<?= $item['period_id'];?>" <?php if($item['period_id'] == $period_id) echo 'selected';?> >
                                                <?= $item['name'];?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>                            
                            </div>
                        </div>
                        <?php echo form_close();?>
                        <!-- Period Header -->
                        <div class="container align-center">
                            <div>
                                <h3><?= getPhrase('total_hours')?>: <?php echo "$total_hours->Total" ?> </h3>
                                <h5>Closing on <?php echo date("F  jS\, Y", strtotime($payment_period->close_date))?></h5>
                                <h6>PAY DATE FOR THIS IS ON <?php echo date("F  jS\, Y", strtotime($payment_period->payment_date))?></h6>
                            </div>
                        </div><br><br>
                        <!-- Timesheet -->
                        <div class="row table-responsive align-center">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col"><?= getPhrase('date')?></th>
                                        <th scope="col"><?= getPhrase('clock-in')?></th>
                                        <th scope="col"><?= getPhrase('clock-out')?></th>
                                        <th scope="col"><?= getPhrase('overtime')?></th>
                                        <th scope="col"><?= getPhrase('total_hours')?></th>
                                        <th scope="col"><?= getPhrase('note')?></th>
                                    </tr>
                                </thad>
                                <tbody>
                                    <?php 
                                        $timesheet = $this->db->query("SELECT * FROM v_time_sheet WHERE worker_id = $worker_id and date BETWEEN '$payment_period->start_date' AND '$payment_period->end_date'")->result_array();
                                        foreach ($timesheet as $key => $value):?>                                            
                                            <tr>
                                                <td>
                                                    <?= $value['date']; ?>
                                                </td>
                                                <td>
                                                    <?= $value['start_time']; ?>
                                                </td>
                                                <td>
                                                    <?= $value['end_time']; ?>
                                                </td>
                                                <td>
                                                    <?= $value['overtime']; ?>
                                                </td>
                                                <td>
                                                    <?= $value['hours_worked']; ?>
                                                </td>
                                                <td>
                                                    <?= $value['note']; ?>
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