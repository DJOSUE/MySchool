<?php
    
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
                        <a class="navs-links active" href="<?php echo base_url();?>admin/workers/"><i class="picons-thin-icon-thin-0704_users_profile_group_couple_man_woman"></i> <span><?php echo getPhrase('worker');?></span></a>
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
                        data-target="#new_worker" data-toggle="modal" type="button">+
                        <?php echo getPhrase('new');?></button>
                    </div>
                    <br>
                    <div class="element-wrapper">
                        <h4 class="element-header"><?php echo getPhrase('worker');?></h4>
                        <div class="element-box-tp">
                            <div class="table-responsive">
                                <table class="table table-padded">
                                    <thead>
                                        <tr>
                                            <th><?php echo getPhrase('name');?></th>
                                            <th><?php echo getPhrase('type_user');?></th>
                                            <th><?php echo getPhrase('start_date');?></th>
                                            <th><?php echo getPhrase('over_time');?></th>
											<th class="text-center"><?php echo getPhrase('manual_hours');?></th>
                                            <th class="text-center"><?php echo getPhrase('status');?></th>
                                            <th class="text-center"><?php echo getPhrase('options');?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $workers = $this->db->get_where('worker', array('status' => '1'))->result_array();
                                            foreach($workers as $item):	
												$worker = $this->db->get_where('v_users', array('user_id' => $item['user_id'], 'type_user' => $item['type_user'] ))->first_row();
                                        ?>
                                            <tr>
                                                <td><?= $worker->name;?></td>
                                                <td><?= $item['type_user'];?></td>
                                                <td><?= $item['start_date'];?></td>
                                                <td><?= $item['over_time'];?></td>
												<td class="text-center">
													<?php if($item['manual_hours'] == 1):?>
                                                        <div class="pt-btn">
                                                            <a class="btn nc btn-success btn-sm btn-rounded">
                                                                <font color="white"><?php echo getPhrase('true');?>
                                                                </font>
                                                            </a>
                                                        </div>
                                                        <?php else:?>
                                                        <div class="pt-btn">
                                                            <a class="btn nc btn-danger btn-sm btn-rounded">
                                                                <font color="white"><?php echo getPhrase('false');?>
                                                                </font>
                                                            </a>
                                                        </div>
                                                    <?php endif;?>
												</td>
                                                <td class="text-center">
                                                        <?php if($item['status'] == 1):?>
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
                                                        onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_edit_worker/<?php echo $item['worker_id'];?>');"><i
                                                            class="os-icon picons-thin-icon-thin-0001_compose_write_pencil_new"></i></a>
                                                    <a href="javascript:void(0);" class="grey"
                                                        onClick="confirm_delete(<?= $item['worker_id']; ?>)"><i
                                                            class="os-icon picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                    
                                </table>
                            </div>
                        </div> 
                    </div>
                    <div class="modal fade" id="new_worker" tabindex="-1" role="dialog" aria-labelledby="new_worker"
                         aria-hidden="true">
                         <div class="modal-dialog window-popup create-friend-group create-friend-group-1" role="document">
                            <div class="modal-content">
                                <?php echo form_open(base_url() . 'admin/workers/create/');?>
                                <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close"></a>
                                <div class="modal-header" style="background-color:#00579c">
                                    <h6 class="title" style="color:white"><?php echo getPhrase('new');?></h6>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group with-button">
                                        <label><?php echo getPhrase('type_user');?></label>
										<div class="select">
											<select name="type_user" id="type_user" onchange="get_users(this.value)">
												<option value=""><?php echo getPhrase('select');?></option>
												<option value="admin"><?php echo getPhrase('admin');?></option>
												<option value="teacher"><?php echo getPhrase('teacher');?></option>
												<option value="student"><?php echo getPhrase('student');?></option>
												<option value="accountant"><?php echo getPhrase('accountant');?></option>
												<option value="librarian"><?php echo getPhrase('librarian');?></option>
											</select>
										</div>                                        
                                    </div>
									<div class="form-group with-button">
                                        <label><?php echo getPhrase('manual_hours');?></label>
										<div class="select">
											<select name="manual_hours" id="manual_hours">
												<option value="false"><?php echo getPhrase('false');?></option>
												<option value="true"><?php echo getPhrase('true');?></option>
											</select>
										</div>                                        
                                    </div>
									<div class="form-group with-button">
                                        <label><?php echo getPhrase('user');?></label>
										<div class="select">
											<select name="user_id" id="user_id">
											</select>
										</div>                                        
                                    </div>
                                    <div class="form-group with-button">
                                        <label><?php echo getPhrase('start_date');?></label>
                                        <div class="form-group date-time-picker">
                                            <input type="text" autocomplete="off" class="datepicker-here" data-position="bottom left" data-language='en'name="start_date" id="start_date" required="">
                                        </div>
                                    </div>
									<div class="form-group with-button">
                                        <label><?php echo getPhrase('overtime');?></label>
                                        <input class="form-control" name="overtime" id="overtime" type="number" required="">
                                    </div>
                                    <button type="submit"
                                        class="btn btn-rounded btn-success btn-lg full-width"><?php echo getPhrase('save');?>
									</button>
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
	function  get_users(type_user){
		$.ajax({
            url: '<?php echo base_url();?>admin/get_users/' + type_user,
            success: function(response) {
                jQuery('#user_id').html(response);
            }
        });
	}

    function confirm_delete(worker_id){

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
                location.href = '<?php echo base_url();?>admin/workers/delete/' + worker_id;
            }
        })
    }
</script>