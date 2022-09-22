<?php 
    $parametersID = explode("|", base64_decode($param2));

    $parameter_id = $parametersID[0];
    $level_1      = $parametersID[1];
    $level_2      = $parametersID[2];
    $code         = $parametersID[3];

    $edit_data		=	$this->db->get_where('parameters', array('parameter_id' => $parameter_id, 'level_1' => $level_1, 'level_2' => $level_2, 'code' => $code ) )->result_array();
    
    // echo '<pre>';
    // var_dump($parametersID);
    // echo '</pre>';
    foreach ( $edit_data as $row):
?>
<div class="modal-body">
    <div class="modal-header" style="background-color:#00579c">
        <h6 class="title" style="color:white"><?php echo getPhrase('update_parameter');?></h6>
    </div>
    <?php echo form_open(base_url() . 'admin/parameter/update/'.$row['role_id'] , array('enctype' => 'multipart/form-data'));?>
    <div class="ui-block-content">        
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('name');?></label>
            <div class="col-sm-9">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="picons-thin-icon-thin-0003_write_pencil_new_edit"></i>
                    </div>
                    <input class="form-control" name="name" required="" type="text" value="<?=$row['name']?>">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('value_1');?></label>
            <div class="col-sm-9">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="picons-thin-icon-thin-0003_write_pencil_new_edit"></i>
                    </div>
                    <input class="form-control" name="value_1" type="text" value="<?=$row['value_1']?>">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('value_2');?></label>
            <div class="col-sm-9">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="picons-thin-icon-thin-0003_write_pencil_new_edit"></i>
                    </div>
                    <input class="form-control" name="value_2" type="text" value="<?=$row['value_2']?>">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('value_3');?></label>
            <div class="col-sm-9">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="picons-thin-icon-thin-0003_write_pencil_new_edit"></i>
                    </div>
                    <input class="form-control" name="value_3" type="text" value="<?=$row['value_3']?>">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('value_4');?></label>
            <div class="col-sm-9">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="picons-thin-icon-thin-0003_write_pencil_new_edit"></i>
                    </div>
                    <input class="form-control" name="value_4" type="text" value="<?=$row['value_4']?>">
                </div>
            </div>
        </div>
        <div class="form-buttons-w">
            <button class="btn btn-rounded btn-success" style="float: right;" type="submit">
                <?= getPhrase('save');?>
            </button>
        </div>
        <br>
    </div>
    <?php echo form_close();?>
</div>
<?php endforeach; ?>