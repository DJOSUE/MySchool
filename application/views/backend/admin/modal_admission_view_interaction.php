<?php 
    $edit_data		=	$this->db->get_where('applicant_interaction' , array('interaction_id' => $param2) )->result_array();
    foreach ($edit_data as $row):
        $comment =   html_entity_decode(str_replace(array("\r", "\n"), '', $row['comment']));
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
        <?php if($row['file_name']):?>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?= getPhrase('file');?></label>
            <div class="col-sm-9">

                <a href="<?= base_url().PATH_APPLICANT_FILES;?><?= $row['file_name'];?>" class="grey"
                    data-toggle="tooltip" data-placement="top" target="_blank"
                    data-original-title="<?= getPhrase('view_file');?>"> <?= getPhrase('view_file')?>
                    <i class="os-icon picons-thin-icon-thin-0043_eye_visibility_show_visible"></i>
                </a>
            </div>
        </div>
        <? endif;?>
        <div class="form-buttons-w">
            <button class="btn btn-rounded btn-success" style="float: right;" type="close" data-dismiss="modal"
                aria-label="Close">
                <?= getPhrase('close');?>
            </button>
            <br>
        </div>
    </div>
</div>
<?= form_close();?>
<?php endforeach; ?>