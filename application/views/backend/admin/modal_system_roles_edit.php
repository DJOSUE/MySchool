<?php 
    $edit_data		=	$this->db->get_where('roles' , array('role_id' => $param2) )->result_array();
    foreach ( $edit_data as $row):
?>
<div class="modal-body">
    <div class="modal-header" style="background-color:#00579c">
        <h6 class="title" style="color:white"><?php echo getPhrase('update_role');?></h6>
    </div>
    <div class="ui-block-content">
        <?php echo form_open(base_url() . 'admin/role/update/'.$row['role_id'] , array('enctype' => 'multipart/form-data'));?>
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
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('table');?></label>
            <div class="col-sm-9">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="picons-thin-icon-thin-0003_write_pencil_new_edit"></i>
                    </div>
                    <input class="form-control" name="table" value="<?php echo $row['table'];?>" required=""
                        type="text">
                </div>
            </div>
        </div>
        <div class="form-buttons-w">
            <button class="btn btn-rounded btn-success" style="float: right;" type="submit">
                <?php echo getPhrase('update');?></button><br>
        </div>
    </div>
</div>
<?php echo form_close();?>
<?php endforeach; ?>