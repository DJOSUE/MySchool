<?php 
    $edit_data		=	$this->db->get_where('account_role' , array('account_role_id' => $param2) )->result_array();
    
    foreach ( $edit_data as $row):
?>
<div class="modal-body">

    <div class="ui-block-content">
        <?php echo form_open(base_url() . 'admin/account_role/update/'.$row['account_role_id'] , array('enctype' => 'multipart/form-data'));?>
        <input type="hidden" name="role_id" value="<?php echo $row['role_id'];?>">
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('type');?></label>
            <div class="col-sm-9">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="picons-thin-icon-thin-0003_write_pencil_new_edit"></i>
                    </div>
                    <input class="form-control" name="type" value="<?php echo $row['type'];?>" required="" type="text">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for=""> <?php echo getPhrase('permissions');?></label>
            <div class="col-sm-6">
                <div class="input-group">
                    <div class="select">
                        <select name="permissions" required="" style="width: 150px;">
                            <option value="0" <?= $row['permissions'] == 0 ? 'selected': ''; ?>>                                
                                <?= getPhrase('forbid')?>
                            </option>
                            <option value="1" <?= $row['permissions'] == 1 ? 'selected': ''; ?>>
                                <?= getPhrase('allow')?>
                            </option>
                        </select>
                    </div>
                    <!-- <input class="form-control" name="status" value="<?php echo $row['status'];?>" required="" type="text"> -->
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