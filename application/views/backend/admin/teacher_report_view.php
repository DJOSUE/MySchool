<?php $running_year = $this->crud->getInfo('running_year');?>
    <div class="content-w">
        <div class="conty">
            <?php include 'fancy.php';?>
            <div class="header-spacer"></div>
            <div class="os-tabs-w menu-shad">
                <div class="os-tabs-controls">
                    <ul class="navs navs-tabs upper">
                        <li class="navs-item">
                            <a class="navs-links" href="<?php echo base_url();?>admin/teacher_attendance/"><i class="os-icon picons-thin-icon-thin-0704_users_profile_group_couple_man_woman"></i><span><?php echo getPhrase('teacher_attendance');?></span></a>
                        </li>
                        <li class="navs-item">
                            <a class="navs-links active" href="<?php echo base_url();?>admin/teacher_attendance_report/"><i class="os-icon picons-thin-icon-thin-0386_graph_line_chart_statistics"></i><span><?php echo getPhrase('teacher_attendance_report');?></span></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="content-i">
                <div class="content-box">
                    <div class="element-wrapper">
                        <?php echo form_open(base_url() . 'admin/teacher_report_selector/', array('class' => 'form m-b')); ?>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group label-floating is-select">
                                        <label class="control-label"><?php echo getPhrase('month');?></label>
                                        <div class="select">
                                            <select name="month" required onchange="show_year()" id="month">
                                                <option value=""><?php echo getPhrase('select');?></option>
                                                <?php
                                                    for ($i = 1; $i <= 12; $i++):
                                                    if ($i == 1) $m = getPhrase('january');
                                                    else if ($i == 2) $m = getPhrase('february');
                                                    else if ($i == 3) $m = getPhrase('march');
                                                    else if ($i == 4) $m = getPhrase('april');
                                                    else if ($i == 5) $m = getPhrase('may');
                                                    else if ($i == 6) $m = getPhrase('june');
                                                    else if ($i == 7) $m = getPhrase('july');
                                                    else if ($i == 8) $m = getPhrase('august');
                                                    else if ($i == 9) $m = getPhrase('september');
                                                    else if ($i == 10) $m = getPhrase('october');
                                                    else if ($i == 11) $m = getPhrase('november');
                                                    else if ($i == 12) $m = getPhrase('december');
                                                ?>
                                                <option value="<?php echo $i; ?>"<?php if($month == $i) echo 'selected'; ?>  ><?php echo ucwords($m); ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="operation" value="selection">
                                <div class="col-md-2">
                                    <div class="form-group label-floating is-select">
                                        <label class="control-label"><?php echo getPhrase('year');?></label>
                                        <div class="select">
                                            <select name="year" required>
                                                <?php $year_options = explode('-', $running_year); ?>
                                                <option value="<?php echo $year_options[0]; ?>" <?php if($year == $year_options[0]) echo 'selected'; ?>><?php echo $year_options[0]; ?></option>
                                                <option value="<?php echo $year_options[1]; ?>" <?php if($year == $year_options[1]) echo 'selected'; ?>><?php echo $year_options[1]; ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group"> <button class="btn btn-primary btn-rounded btn-upper" style="margin-top:20px" type="submit"><span><?php echo getPhrase('generate');?></span></button></div>
                                </div>
                            </div>
                        <?php echo form_close();?>
                        <?php if ($month != '' && $year != ''): ?>
                        <div class="row">
                            <div class="text-center col-sm-12"><br>
                                <h4><?php echo getPhrase('teacher_attendance_report');?></h4>
                                <p><b><?php echo getPhrase('year');?>:</b> <?php echo $year;?></p>
                            </div>
                            <hr>
                            <div class="col-7 text-left">
                                <h5 class="form-header"><?php 
                                if ($month == 1)  {$mo = getPhrase('january');}
                                else if ($month == 2)  {$mo = getPhrase('february');}
                                else if ($month == 3)  {$mo = getPhrase('march');}
                                else if ($month == 4)  {$mo = getPhrase('april');}
                                else if ($month == 5)  {$mo = getPhrase('may');}
                                else if ($month == 6)  {$mo = getPhrase('june');}
                                else if ($month == 7)  {$mo = getPhrase('july');}
                                else if ($month == 8)  {$mo = getPhrase('august');}
                                else if ($month == 9)  {$mo = getPhrase('september');}
                                else if ($month == 10) {$mo = getPhrase('october');}
                                else if ($month == 11) {$mo = getPhrase('november');}
                                else if ($month == 12) {$mo = getPhrase('december');} echo $mo;?>
                                </h5>
                            </div>
                        </div>
                        <div class="table-responsive bg-white">
                            <table class="table table-sm table-lightborder table-bordered">
                                <thead>
                                    <tr class="text-center" height="30px">
                                        <td style="background-color: #a01a7a; color: #fff; font-weight: 700; text-align: center;"><?php echo getPhrase('teachers');?> </td>
                                        <?php
                                            $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                                            for ($i = 1; $i <= $days; $i++) 
                                            {
                                        ?>
                                        <td style="background-color: #a01a7a; color: #fff; font-weight: 700; text-align: center;"><?php echo $i; ?></td>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $data = array();
                                        $teachers = $this->db->get('teacher')->result_array();
                                        foreach ($teachers as $row): 
                                    ?>
                                    <tr>
                                        <td nowrap> <img alt="" src="<?php echo $this->crud->get_image_url('teacher', $row['teacher_id']);?>" width="20px" style="border-radius:20px;margin-right:5px;"> <?php echo $this->crud->get_name('teacher',$row['teacher_id']); ?> </td>
                                        <?php
                                            $status = 0;
                                            for ($i = 1; $i <= $days; $i++) {
                                            $timestamp = strtotime($i . '-' . $month . '-' . $year);
                                            $attendance = $this->db->get_where('teacher_attendance', array('teacher_id' => $row['teacher_id'], 'timestamp' => $timestamp, 'year' => $running_year))->result_array();
                                            foreach ($attendance as $row1):
                                            $month_dummy = date('d', $row1['timestamp']);
                                            if ($i == $month_dummy)
                                            $status = $row1['status'];
                                            endforeach;
                                        ?>
                                        <td class="text-center">
                                            <?php if ($status == 1) { ?>
                                            <div class="status-pilli green" data-title="<?php echo getPhrase('present');?>" data-toggle="tooltip"></div>
                                            <?php  } if($status == 2)  { ?>
                                            <div class="status-pilli red" data-title="<?php echo getPhrase('absent');?>" data-toggle="tooltip"></div>
                                            <?php  } if($status == 3)  { ?>
                                            <div class="status-pilli yellow" data-title="<?php echo getPhrase('late');?>" data-toggle="tooltip"></div>
                                            <?php  } if($status != 1 && $status != 2 && $status != 3)  { ?>
                                                -
                                            <?php  } $status =0;?>
                                        </td>
                                        <?php } ?>         
                                    <?php endforeach; ?>
                                    </tr>                 
                                </tbody>
                            </table>
                        </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>