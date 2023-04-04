<?php
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
                        <a class="navs-links active" href="<?php echo base_url();?>admin/worker_schedule/"><i class="picons-thin-icon-thin-0021_calendar_month_day_planner"></i>  <span><?php echo getPhrase('worker_schedule');?></span></a>
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
                <div class="expense"><button class="btn btn-success btn-rounded btn-upper"
                    data-target="#new_worker_schedule" data-toggle="modal" type="button">+
                    <?php echo getPhrase('new');?></button>
                </div>
                <br>
                <div class="element-wrapper">
                    <h4 class="element-header"><?php echo getPhrase('worker_schedule');?></h4>
                    <div class="row">
                        <div class="content-i">
					        <div class="content-box">
                                <?php echo form_open(base_url() . 'admin/worker_schedule/', array('class' => 'form m-b'));?>
                                    <div class="row" style="margin-top: -30px; border-radius: 5px;">
							            <div class="col-sm-5">
							                <div class="form-group label-floating is-select">
                                                <label class="control-label"><?php echo getPhrase('worker');?></label>
                                                <div class="select">
                                                    <select id="worker_id" name="worker_id" required="" onchange="this.form.submit()">
                                                        <option value=""><?php echo getPhrase('select');?></option>
                                                        <?php
											                $workers = $this->db->get_where('v_workers', array('status' => '1'))->result_array();
											                foreach($workers as $row):                        
										                ?>                
										                    <option value="<?php echo $row['worker_id'];?>" <?php if($worker_id == $row['worker_id']) echo "selected";?>><?php echo $row['name'];?></option>            
										                <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
							            </div>
                                    </div>
                                <?php echo form_close();?>
                            </div>
                        </div>
                    </div>
                    <div class="element-box-tp">
                        <div class="table-responsive">
                            <table class="table table-padded">
                                <thead>
                                    <tr>
                                        <th><?php echo getPhrase('SUNDAY');?></th>
                                        <th><?php echo getPhrase('MONDAY');?></th>
                                        <th><?php echo getPhrase('TUESDAY');?></th>
                                        <th><?php echo getPhrase('WEDNESDAY');?></th>
                                        <th><?php echo getPhrase('THURSDAY');?></th>
                                        <th><?php echo getPhrase('FRIDAY');?></th>
                                        <th><?php echo getPhrase('SATURDAY');?></th>
                                        <th class="text-center"><?php echo getPhrase('options');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $workers = $this->db->get_where('v_worker_schedule', array('worker_id' => $worker_id, 'period_id' => $period_id))->result_array();
                                        foreach($workers as $item):	
                                            $worker = $this->db->get_where('v_users', array('user_id' => $item['user_id'], 'type_user' => $item['type_user'] ))->first_row();
                                    ?>
                                        <tr>
                                            <td><?= $item['SUNDAY'];?></td>
                                            <td><?= $item['MONDAY'];?></td>
                                            <td><?= $item['TUESDAY'];?></td>
                                            <td><?= $item['WEDNESDAY'];?></td>
                                            <td><?= $item['THURSDAY'];?></td>
                                            <td><?= $item['FRIDAY'];?></td>
                                            <td><?= $item['SATURDAY'];?></td>
                                            <td class="row-actions">
                                                <a href="javascript:void(0);" class="grey"
                                                   data-toggle="tooltip" 
                                                   data-placement="top" 
                                                   data-original-title="<?php echo getPhrase('edit');?>"
                                                   onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_edit_worker_schedule/<?php echo $item['sequence'].'/'.$worker_id;?>');">
                                                   <i class="os-icon picons-thin-icon-thin-0001_compose_write_pencil_new"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal fade" id="new_worker_schedule" tabindex="-1" role="dialog" aria-labelledby="new_worker_schedule" aria-hidden="true">
                        <div class="modal-dialog window-popup create-friend-group create-friend-group-1" role="document">
                            <div class="modal-content">
                                <?php echo form_open(base_url() . 'admin/worker_schedule/create/');?>
                                <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close"></a>
                                <div class="modal-header" style="background-color:#00579c">
                                    <h6 class="title" style="color:white"><?php echo getPhrase('new');?></h6>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group label-floating is-select">
                                        <label class="control-label"><?php echo getPhrase('worker');?></label>
                                        <div class="select">
                                            <select id="worker_id_new" name="worker_id_new" required="">
                                                <option value=""><?php echo getPhrase('select');?></option>
                                                <?php
                                                    $workers = $this->db->get_where('v_workers', array('status' => '1'))->result_array();
                                                    foreach($workers as $row):                        
                                                ?>                
                                                    <option value="<?php echo $row['worker_id'];?>" <?php if($worker_id == $row['worker_id']) echo "selected";?>><?php echo $row['name'];?></option>            
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div><br>
                                    <h6 class="element-header"><?php echo getPhrase('sunday');?></h6>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?php echo getPhrase('start');?></label>
                                                <input class="form-control" name="start_sunday" type="time">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?php echo getPhrase('end');?></label>
                                                <input class="form-control" name="end_sunday" type="time">
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="element-header"><?php echo getPhrase('monday');?></h6>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?php echo getPhrase('start');?></label>
                                                <input class="form-control" name="start_monday" type="time">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?php echo getPhrase('end');?></label>
                                                <input class="form-control" name="end_monday" type="time">
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="element-header"><?php echo getPhrase('tuesday');?></h6>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?php echo getPhrase('start');?></label>
                                                <input class="form-control" name="start_tuesday" type="time">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?php echo getPhrase('end');?></label>
                                                <input class="form-control" name="end_tuesday" type="time">
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="element-header"><?php echo getPhrase('wednesday');?></h6>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?php echo getPhrase('start');?></label>
                                                <input class="form-control" name="start_wednesday" type="time">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?php echo getPhrase('end');?></label>
                                                <input class="form-control" name="end_wednesday" type="time">
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="element-header"><?php echo getPhrase('thursday');?></h6>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?php echo getPhrase('start');?></label>
                                                <input class="form-control" name="start_thursday" type="time">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?php echo getPhrase('end');?></label>
                                                <input class="form-control" name="end_thursday" type="time">
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="element-header"><?php echo getPhrase('friday');?></h6>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?php echo getPhrase('start');?></label>
                                                <input class="form-control" name="start_friday" type="time">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?php echo getPhrase('end');?></label>
                                                <input class="form-control" name="end_friday" type="time">
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="element-header"><?php echo getPhrase('saturday');?></h6>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?php echo getPhrase('start');?></label>
                                                <input class="form-control" name="start_saturday" type="time">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?php echo getPhrase('end');?></label>
                                                <input class="form-control" name="end_saturday" type="time">
                                            </div>
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
</div>