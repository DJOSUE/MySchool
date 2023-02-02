<?php 
    $this->db->reset_query();
    $this->db->where('ticket_message_id' , $param2);
    $ticket_query = $this->db->get('ticket_message');
    $edit_data = $ticket_query->result_array();

    foreach ($edit_data as $row):
        $comment =   html_entity_decode(str_replace(array("\r", "\n"), '', $row['message']));
?>
<div class="modal-body">
    <div class="modal-header" style="background-color:#00579c">
        <h6 class="title" style="color:white"><?= getPhrase('add_interaction');?></h6>
    </div>
    <div class="ui-block-content">        
        <input type="hidden" name="applicant_id" value="<?= $row['applicant_id']?>">
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?= getPhrase('comment');?></label>
            <div class="col-sm-9">
                <div class="form-group" style="border: 1px; border-style:solid; padding: 20px;">
                    <?= $comment;?>
                </div>
            </div>
        </div>
        <?php if($row['message_file']):?>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?= getPhrase('file');?></label>
            <div class="col-sm-9">
                
                <a href="<?= base_url().PATH_TASK_FILES;?><?= $row['message_file'];?>"
                    class="grey" data-toggle="tooltip" data-placement="top" target="_blank"
                    data-original-title="<?= getPhrase('view_file');?>"> <?= getPhrase('view_file')?>
                    <i
                        class="os-icon picons-thin-icon-thin-0043_eye_visibility_show_visible"></i>
                </a>                
            </div>
        </div>
        <? endif;?>
        <div class="form-buttons-w">
            <button class="btn btn-rounded btn-success" style="float: right;" type="close" data-dismiss="modal"
                aria-label="Close">
                <?= getPhrase('close');?>
            </button>
        </div>
    </div>
</div>
<?php endforeach; ?>