<?php 
    $account_type   =	$this->session->userdata('login_type');
?>
<div class="modal-body">
    <div class="modal-header" style="background-color:#00579c">
        <h6 class="title" style="color:white"><?= getPhrase('add_ticket');?></h6>
    </div>
    <div class="ui-block-content">
        <?= form_open(base_url() . 'helpdesk/ticket/register/', array('enctype' => 'multipart/form-data'));?>
        <input type="hidden" name="user_id" value="<?= $row[$user_id]?>">
        <input type="hidden" name="user_type" value="<?= $table?>">        
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?= getPhrase('category');?></label>
            <select name="status_id" style="width: 200px;" hidden>
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
            <div class="col-sm-6">
                <div class="input-group">
                    <div class="select">
                        <select name="category_id" style="width: 300px;">
                            <option value=""><?= getPhrase('select');?>
                            </option>

                            <?php
                        $departments = $this->ticket->get_departments();
                        foreach($departments as $row):                        
                        ?>
                            <optgroup label="<?= $row['name'];?>">
                                <?php
                        $categories = $this->ticket->get_categories($row['department_id']);
                        foreach($categories as $item):  
                        ?>
                                <option value="<?= $item['category_id'];?>"
                                    <?php if($category_id == $item['category_id']) echo "selected";?>>
                                    <?= $item['name'];?></option>

                                <?php endforeach;?>
                                <?php endforeach;?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?= getPhrase('priority');?></label>
            <div class="col-sm-6">
                <div class="input-group">
                    <div class="select">
                        <select name="priority_id" style="width: 200px;">
                            <?php
                        $priorities = $this->task->get_priorities();
                        foreach($priorities as $priority_row):
                        ?>
                            <option value="<?= $priority_row['priority_id']?>"
                                <?= $priority_row['priority_id'] == $row['priority_id'] ? 'selected': ''; ?>>
                                <?= $priority_row['name']?>
                            </option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?= getPhrase('title');?></label>
            <div class="col-sm-9">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="picons-thin-icon-thin-0003_write_pencil_new_edit"></i>
                    </div>
                    <input class="form-control" name="title" value="<?= $row['title'];?>" required=""
                        type="text">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?= getPhrase('description');?></label>
            <div class="col-sm-9">
                <div class="form-group">
                    <textarea id="ckeditor2" name="description" required=""></textarea>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""><?= getPhrase('link');?></label>
            <div class="col-sm-9">
                <div class="form-group">
                    <div class="input-group-addon">
                        <i class="picons-thin-icon-thin-0003_write_pencil_new_edit"></i>
                    </div>
                    <input name="link" type="link">  
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?= getPhrase('file');?></label>
            <div class="col-sm-9">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="picons-thin-icon-thin-0003_write_pencil_new_edit"></i>
                    </div>
                    <input class="form-control" name="ticket_file" type="file" accept="<?=FILES_ALLOWED_ATTACHMENT?>">
                </div>
            </div>
        </div>
        <div class="form-buttons-w">
            <button class="btn btn-rounded btn-success" style="float: right;" type="submit">
                <?= getPhrase('save');?></button><br>
        </div>
    </div>
</div>
<?= form_close();?>
<script>
$('.selectpicker').selectpicker('refresh');
if ($('#ckeditor2').length) {
    CKEDITOR.replace('ckeditor2', {
        toolbar: 'Basic'
    });
}
</script>