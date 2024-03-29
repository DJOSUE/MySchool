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
                                <input type="hidden" name="year" value="<?php echo $running_year;?>">
                                <div class="col-sm-2">
                                    <div class="form-group"> <button class="btn btn-rounded btn-primary btn-upper" style="margin-top:20px" type="submit"><span><?php echo getPhrase('generate');?></span></button></div>
                                </div>
                            </div>
                        <?php echo form_close();?>
                    </div>
                </div>
            </div>
        </div>
    </div>