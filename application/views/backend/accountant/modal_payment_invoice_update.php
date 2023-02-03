<?php 
    
    $advisor    = $this->user->get_advisor();
    $accounters = $this->user->get_accounters();

    $edit_data	= $this->db->get_where('payment' , array('payment_id' => $param2) )->result_array();
    
    foreach ($edit_data as $data):
        $cashier_id = $data["created_by_type"].':'.$data["created_by"];
        $userList = $this->task->get_user_list_dropbox($data['created_by'], $data['created_by_type']);
?>
<div class="modal-body">
    <?php echo form_open(base_url() . 'payments/update/'.$data['payment_id'].'/'.$param3, array('enctype' => 'multipart/form-data')); ?>
    <div class="modal-header" style="background-color:#00579c">
        <h6 class="title" style="color:white"><?= getPhrase('edit_payment');?></h6>
    </div>
    <div class="modal-body">
        <div class="ui-block-content">
            <div class="row">
                <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-group label-floating is-select">
                        <label class="control-label"><?= getPhrase('status');?></label>
                        <div class="select">
                            <select name="cashier_id">
                                <option value=""><?= getPhrase('select');?></option>
                                <?= $userList?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-group label-floating">
                        <label class="control-label"><?= getPhrase('invoice_date');?></label>
                        <input class="form-control" type="date" required="" name="invoice_date"
                            value="<?= $data['invoice_date'];?>">
                    </div>
                </div>
                <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-group label-floating">
                        <label class="control-label"><?= getPhrase('invoice_number');?></label>
                        <input class="form-control" type="text" required="" name="invoice_number"
                            value="<?= $data['invoice_number'];?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-rounded btn-success" type="submit"> <?php echo getPhrase('update');?></button>
    </div>
    <?= form_close();?>
</div>
<?php endforeach; ?>