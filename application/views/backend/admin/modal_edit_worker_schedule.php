<?php 
    $sequence = $param2;
    $worker_id = $param3;
    $period_id = $this->db->get_where('payment_period', array('active' => '1'))->row()->period_id;
?>
    <div class="modal-content">
        <?php echo form_open(base_url() . 'admin/worker_schedule/update/');?>
        <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close"></a>
        <div class="modal-header" style="background-color:#00579c">
            <h6 class="title" style="color:white"><?php echo getPhrase('new');?></h6>
        </div>
        <div class="ui-block-content">
            <input name="sequence_update" value="<?=$sequence?>" style="display: none;">
            <div class="form-group label-floating is-select">
                <label class="control-label"><?php echo getPhrase('worker');?></label>
                <div class="select">
                    <select id="worker_id_update" name="worker_id_update" required="">
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
            <?php
                $days = $this->db->query("SELECT code, LOWER(name) as 'name' FROM `v_days`")->result_array();

                foreach($days as $item):
                    $name = $item['name'];
                    $day_id = $item['code'];
                    $schedule = $this->db->get_where('worker_schedule', array('worker_id' => $worker_id, 'period_id' => $period_id, 'sequence' => $sequence, 'day_id' => $day_id))->first_row();                    
            ?>
            <h6 class="element-header"><?php echo getPhrase($name);?></h6>
            <input name="schedule_id_<?=$name;?>" value="<?=$schedule->schedule_id;?>" style="display: none;">
            <div class="row" >
                <div class="col">
                    <div class="form-group label-floating is-select">
                        <label class="control-label"><?php echo getPhrase('start');?></label>
                        <input class="form-control" name="start_<?=$name;?>" type="time" value="<?=$schedule->start_time;?>">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group label-floating is-select">
                        <label class="control-label"><?php echo getPhrase('end');?></label>
                        <input class="form-control" name="end_<?=$name;?>" type="time" value="<?= $schedule->end_time;?>">
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <button type="submit"
                class="btn btn-rounded btn-success btn-lg full-width"><?php echo getPhrase('save');?></button>
        </div>
        <?php echo form_close();?>
    </div>