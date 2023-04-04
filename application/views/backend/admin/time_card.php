<?php
    $payment_period = $this->db->get_where('payment_period', array('active' => '1'))->row();
    $period_id = $payment_period->period_id;
    $user_id = get_login_user_id();

    $date_current = date("Y-m-d");

    $worker = $this->db->get_where('worker', array('type_user' => 'admin', 'user_id' => $user_id))->row();
    $worker_id = $worker->worker_id;

    // Get Schedule
    $schedule = $this->db->query("SELECT * FROM v_worker_schedule WHERE period_id = $period_id AND worker_id = $worker_id")->result_array();
    // echo '<pre>'; print_r($worker_id); echo '</pre>';

    // Get Clock-in
    $clockIn = $this->db->query("SELECT * FROM time_sheet WHERE worker_id = $worker_id AND active = 1 AND end_time IS NULL AND date = '$date_current' ")->row();
    $clockIn_id = $clockIn->timesheet_id;
    // echo $id_ClockIn;
    // echo '<pre>'; var_dump($clockIn); echo '</pre>';

    // Name of the day
    $name_day = date("l");

    $begin =  date('Y-m-d', strtotime("this week -1 days"));
    $end =  date('Y-m-d', strtotime("this week +6 days")); // Plus more one day
    $endQuery =  date('Y-m-d', strtotime("this week +5 days")); // Plus more one day

    $bk = " style='background: brown; color: white;'";

    $ip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);

    $admin_type = $this->db->get_where('admin', array('admin_id' => get_login_user_id()))->row()->owner_status;

?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <ul class="navs navs-tabs">
                    <li class="navs-item">
                        <a class="navs-links <?php if($page_name == 'time_card') echo "active";?>" href="<?php echo base_url();?>admin/time_card/"><i class="picons-thin-icon-thin-0844_stopwatch_training_time"></i> <span><?php echo getPhrase('time_card');?></span></a>
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
                        <a class="navs-links" href="<?php echo base_url();?>admin/worked_hours/"><i class="picons-thin-icon-thin-0100_to_do_list_reminder_done"></i>  <span><?php echo getPhrase('worked_hours');?></span></a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="content-i">
            <div class="content-box">                
                <div class="col-sm">
                    <div class="element-box lined-primary shadow" style="padding-left: 50px;">
                        <div class="row">
                            <h3 class="form-header">
                                <?= getPhrase('payment_period') . ': '. $payment_period->name;?>
                            </h3>
                        </div>
                        <!-- schedules -->
                        <div>                        
                            <div class="row">                            
                                <h5 class="form-header">
                                    <?= getPhrase('schedule');?>:
                                </h5>
                            </div>
                            <div class="row table-responsive">
                                <table class="table table-bordered table-hover ">
                                    <thead class="thead-dark">
                                        <tr>
                                            <?php
                                                echo "<th>". date('l - d', strtotime("this week -1 days")) ."</th>";
                                                echo "<th>". date('l - d', strtotime("this week +0 days")) ."</th>";
                                                echo "<th>". date('l - d', strtotime("this week +1 days")) ."</th>";
                                                echo "<th>". date('l - d', strtotime("this week +2 days")) ."</th>";
                                                echo "<th>". date('l - d', strtotime("this week +3 days")) ."</th>";
                                                echo "<th>". date('l - d', strtotime("this week +4 days")) ."</th>";
                                                echo "<th>". date('l - d', strtotime("this week +5 days")) ."</th>";
                                            ?>                                        
                                        </tr>
                                    </thead>
                                    <tbody id="tbSchedule">
                                        <?php // Get the Schedule for the day
                                            foreach ($schedule as $item) {
                                                
                                                $SUNDAY = is_null($item['SUNDAY']) ? "" : $item['SUNDAY'];
                                                $MONDAY = is_null($item['MONDAY']) ? "-" : $item['MONDAY'];
                                                $TUESDAY = is_null($item['TUESDAY']) ? "" : $item['TUESDAY'];
                                                $WEDNESDAY = is_null($item['WEDNESDAY']) ? "" : $item['WEDNESDAY'];
                                                $THURSDAY = is_null($item['THURSDAY']) ? "" : $item['THURSDAY'];
                                                $FRIDAY = is_null($item['FRIDAY']) ? "" : $item['FRIDAY'];
                                                $SATURDAY = is_null($item['SATURDAY']) ? "" : $item['SATURDAY'];
                                        
                                                echo "<tr>";
                                                echo "<td".($name_day == "Sunday" ? $bk : "").">".$SUNDAY."</td>";
                                                echo "<td".($name_day == "Monday" ? $bk : "").">".$MONDAY."</td>";
                                                echo "<td".($name_day == "Tuesday" ? $bk : "").">".$TUESDAY."</td>";
                                                echo "<td".($name_day == "Wednesday" ? $bk : "").">".$WEDNESDAY."</td>";
                                                echo "<td".($name_day == "Thursday" ? $bk : "").">".$THURSDAY."</td>";
                                                echo "<td".($name_day == "Friday" ? $bk : "").">".$FRIDAY."</td>";
                                                echo "<td".($name_day == "Saturday" ? $bk : "").">".$SATURDAY."</td>";
                                                echo "</tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div><br><br>
                        <!-- Time sheet -->
                        <div>
                            <div class="row">
                                <h5 class="form-header">
                                    <?= getPhrase('time_sheet');?>:
                                </h5>
                            </div>
                            <div class="row table-responsive rounded">
                                <table class="table table-bordered table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <?php
                                                echo "<th>". date('l - d', strtotime("this week -1 days")) ."</th>";
                                                echo "<th>". date('l - d', strtotime("this week +0 days")) ."</th>";
                                                echo "<th>". date('l - d', strtotime("this week +1 days")) ."</th>";
                                                echo "<th>". date('l - d', strtotime("this week +2 days")) ."</th>";
                                                echo "<th>". date('l - d', strtotime("this week +3 days")) ."</th>";
                                                echo "<th>". date('l - d', strtotime("this week +4 days")) ."</th>";
                                                echo "<th>". date('l - d', strtotime("this week +5 days")) ."</th>";
                                            ?>                                        
                                        </tr>
                                    </thead>
                                    <tbody id="tbSchedule">
                                        <tr>
                                            <?php // Get the Schedule for the day
                                                $_begin = new DateTime($begin);
                                                $_end = new DateTime($end);  

                                                $interval = DateInterval::createFromDateString('1 day');
                                                $period = new DatePeriod($_begin, $interval, $_end);

                                                foreach ($period as $dt) {

                                                    $newDate = $dt->format("Y-m-d");
                                                    $newDateName = $dt->format("l");
                                                    $timesheet= $this->db->query("SELECT start_time, end_time FROM time_sheet WHERE worker_id = $worker_id AND date = '$newDate' ORDER BY timesheet_id")->result_array();
                                                    $time = "";
                                                    $cnt = 0;
                                                    // echo '<pre>'; var_dump($newDate); echo '</pre>';
                                                    
                                                    foreach ($timesheet as $key => $value) {
                                                        $st = date('h:i A', strtotime($value['start_time']));
                                                        $et = ($value['end_time'] != NULL) ? (date('h:i A', strtotime($value['end_time']))) : " ";
                                                        $time .=  ($cnt > 0 ? "<br/>" : "").$st." - ".$et;
                                                        $cnt += 1;
                                                    }

                                                    echo "<td ".($newDateName == $name_day ? $bk : " ").">". $time ." </td>";

                                                }
                                            ?>                                            
                                        </tr>
                                    </tbody>
                                </table>
                            </div> 
                        </div><br><br>     
                        <!-- Clock in/out -->
                        <div>
                            <div class="form-horizontal">
                                <?php if(!$clockIn_id):?>
                                    <div class="form-inline">
                                        <button type="button" class="btn btn-primary btn-rounded" onclick='clockIn(<?=$worker_id;?>)'><?= getPhrase('clock-in');?></button>
                                    </div>
                                <?php else: ?>
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <div class="form-inline">                                                    
                                                <button type="button" class="btn btn-secondary btn-rounded disabled"><?= getPhrase('clock-in');?></button>
                                                <button type="button" class="btn btn-secondary btn-rounded" onclick='clockOut(<?=$clockIn_id;?>)'><?= getPhrase('clock-out');?></button>                                                    
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group label-floating is-select">
                                                    <label class="control-label"><?= getPhrase('reason_clock-out');?></label>
                                                    <div class="select">
                                                        <select name="clockout_id" id="clockout_id">
                                                            <?php $clockout = $this->db->get('v_clockout')->result_array(); 
                                                            foreach($clockout as $item):
                                                        ?>
                                                            <option value="<?= $item['code'];?>">
                                                                <?= $item['name'];?></option>
                                                            <?php endforeach;?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label"><?php echo getPhrase('note');?></label>
                                                    <textarea class="form-control" name="note" id="note" rows="3"></textarea>
                                                    <span class="material-input"></span>
                                                    <span class="material-input"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url();?>public/style/js/client.min.js"></script>
<script type="text/javascript">
    function clockIn(_idWorker) {
        var client = new ClientJS(); // Create A New Client Object
        var fingerprint = client.getFingerprint(); // Get Client's Fingerprint  
        var OS = client.getOS(); // Get OS Version 
        var IP = "<?php echo $ip; ?>";
        var worker_id = "<?= $worker_id;?>"
        var pcinfo_in = '{ "Clock-in": {"OS":"' + OS +'", "IP":"' + IP +'", "ID":"' + fingerprint +'"} }';

        $.ajax({
            url: '<?php echo base_url();?>admin/timesheet_actions/clock-in/',
            type: 'POST',
            data: {
                worker_id: worker_id,
                pcinfo_in: pcinfo_in
            },
            success: function(result) {
                window.location.reload();
            }
        });
    }

    function clockOut(clockIn_id) {
        var client = new ClientJS(); // Create A New Client Object
        var fingerprint = client.getFingerprint(); // Get Client's Fingerprint  

        var OS = client.getOS(); // Get OS Version 
        var IP = "<?php echo $ip; ?>"; 
        var pcinfo_out = '{ "Clock-in": {"OS":"' + OS +'", "IP":"' + IP +'", "ID":"' + fingerprint +'"} }';

        var clock_out = document.getElementById("clockout_id").value;
        var note = document.getElementById("note").value;

        var url = '<?php echo base_url();?>admin/timesheet_actions/clock-out/'+clockIn_id;

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                clock_out:  clock_out,
                note:       note,
                pcinfo_out: pcinfo_out
            },
            success: function(result) {
                window.location.reload();
            }
        });
    }
</script>