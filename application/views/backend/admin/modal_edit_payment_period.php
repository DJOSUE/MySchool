<?php 
    $this->db->order_by('start_date', 'desc');
    $edit_data	=	$this->db->get_where('payment_period' , array('period_id' => $param2) )->result_array();
    foreach ( $edit_data as $row):
?>
<div class="modal-body">
    <div class="modal-header" style="background-color:#00579c">
        <h6 class="title" style="color:white"><?php echo getPhrase('update_payment_period');?></h6>
    </div>
    <div class="ui-block-content">

        <?php echo form_open(base_url() . 'admin/payment_period/update/'.$row['period_id'] , array('enctype' => 'multipart/form-data'));?>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('name');?></label>
            <div class="col-sm-9">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="picons-thin-icon-thin-0003_write_pencil_new_edit"></i>
                    </div>
                    <input class="form-control" name="name" value="<?php echo $row['name'];?>" required="" type="text">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('start_date');?></label>
            <div class="col-sm-9">
                <div class="form-group date-time-picker">
                    <input type="date" class="datepicker-here" name="start_date" value="<?php echo $row['start_date'];?>" required="">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('end_date');?></label>
            <div class="col-sm-9">
                <div class="input-group">
                    <input type="date" class="datepicker-here" name="end_date" value="<?php echo $row['end_date'];?>" required="">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('close_date');?></label>
            <div class="col-sm-9">
                <div class="input-group">
                    <input type="date" class="datepicker-here" name="close_date" value="<?= $row['close_date'];?>" required="">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?= getPhrase('payment_date');?></label>
            <div class="col-sm-9">
                <div class="input-group">
                    <input type="date" class="datepicker-here" name="payment_date" value="<?=$row['payment_date'];?>" required="">
                </div>
            </div>
        </div>
        <div class="form-buttons-w">
            <button class="btn btn-rounded btn-success" style="float: right;" type="submit">
                <?= getPhrase('update');?></button><br>
        </div>
    </div>
</div>
<?php echo form_close();?>
<?php endforeach; ?>