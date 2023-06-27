<?php 
    $student_id = $param2;    
?>
<div class="modal-body">
    <div class="modal-header" style="background-color:#00579c">
        <h6 class="title" style="color:white"><?= getPhrase('add_document');?></h6>
    </div>
    <div class="ui-block-content">
        <?= form_open(base_url() . 'documents/student_document/upload/'.$student_id , array('enctype' => 'multipart/form-data'));?>
        <input type="hidden" name="student_id" value="<?= $student_id?>">
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for="">
                <?php echo getPhrase('document_type');?>
            </label>
            <div class="col-sm-6">
                <div class="input-group">
                    <div class="select">
                        <select name="type_id" style="width: 250px;" required>
                            <?php
                            $document_types = $this->document->get_types();
                            foreach($document_types as $item):
                            ?>
                            <option value="<?= $item['type_id']?>">
                                <?= $item['name']?>
                            </option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> 
                <?= getPhrase('name');?>
            </label>
            <div class="col-sm-9">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="picons-thin-icon-thin-0003_write_pencil_new_edit"></i>
                    </div>
                    <input class="form-control" name="doc_name" type="text"
                        accept="image/jpeg,image/png,application/pdf" required>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for="">
                <?= getPhrase('file');?>
            </label>
            <div class="col-sm-9">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="picons-thin-icon-thin-0003_write_pencil_new_edit"></i>
                    </div>
                    <input class="form-control" name="document_file" type="file"
                        accept="image/jpeg,image/png,application/pdf" required>
                </div>
            </div>
        </div>
        <div class="form-buttons-w">
            <button class="btn btn-rounded btn-success" style="float: right;" type="submit">
                <?= getPhrase('add');?></button><br>
        </div>
    </div>
</div>
<?= form_close();?>
<script>
if ($('#ckeditor2').length) {
    CKEDITOR.replace('ckeditor2');
}
</script>