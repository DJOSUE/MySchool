<?php 
    $this->db->reset_query();
    $this->db->where('ticket_code' , $param2);
    $ticket_query = $this->db->get('ticket');
    $tickets = $ticket_query->result_array();

    // echo '<pre>';
    // var_dump($param3);
    // echo '</pre>';
    
    foreach ($tickets as $row):
?>
<div class="modal-body">
    <div class="modal-header" style="background-color:#00579c">
        <h6 class="title" style="color:white"><?php echo getPhrase('add_message');?></h6>
    </div>
    <div class="ui-block-content">        
        <?php echo form_open(base_url() . 'helpdesk/ticket_message/add/'.$param2 , array('enctype' => 'multipart/form-data'));?>
        <input type="hidden" name="ticket_code" value="<?= $param2?>">
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('status');?></label>
            <div class="col-sm-6">
                <div class="input-group">
                    <div class="select">
                        <select name="status_id" required="" style="width: 150px;">
                            <?php
                        $status = $this->ticket->get_statuses();
                        foreach($status as $status_row):
                        ?>
                            <option value="<?= $status_row['status_id']?>"
                                <?= $status_row['status_id'] == $row['status_id'] ? 'selected': ''; ?>>
                                <?= $status_row['name']?>
                            </option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('comment');?></label>
            <div class="col-sm-9">
                <div class="form-group">
                    <textarea id="ckeditor2" name="message" required=""></textarea>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('file');?></label>
            <div class="col-sm-9">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="picons-thin-icon-thin-0003_write_pencil_new_edit"></i>
                    </div>
                    <input class="form-control" name="message_file" type="file"
                        accept="image/jpeg,image/png,application/pdf">
                </div>
            </div>
        </div>
        <div class="form-buttons-w">
            <button class="btn btn-rounded btn-success" style="float: right;" type="submit">
                <?php echo getPhrase('add');?></button><br>
        </div>
        <?php echo form_close();?>
    </div>
</div>
<?php endforeach; ?>
<script>
if ($('#ckeditor2').length) {
    CKEDITOR.replace('ckeditor2');
}
</script>