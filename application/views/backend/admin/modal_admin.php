<?php 
    $admin = $this->db->get_where('admin' , array('admin_id' => $param2))->result_array();
    $roles = $this->system->get_admins_role();
    foreach($admin as $row):
?>
<div class="modal-body">
    <div class="modal-header" style="background-color:#00579c">
        <h6 class="title" style="color:white"><?= getPhrase('update_information');?></h6>
    </div>
    <div class="ui-block-content">
        <?= form_open(base_url() . 'admin/admins/update/'.$row['admin_id'].'/'.$param3, array('enctype' => 'multipart/form-data'));?>
        <div class="row">
            <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="form-group">
                    <label class="control-label"><?= getPhrase('photo');?></label>
                    <input name="userfile" accept="image/x-png,image/gif,image/jpeg" id="imgpre" type="file" />
                </div>
            </div>
            <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="form-group label-floating">
                    <label class="control-label"><?= getPhrase('first_name');?></label>
                    <input class="form-control" type="text" name="first_name" required=""
                        value="<?= $row['first_name'];?>">
                </div>
            </div>
            <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="form-group label-floating">
                    <label class="control-label"><?= getPhrase('last_name');?></label>
                    <input class="form-control" type="text" required="" name="last_name"
                        value="<?= $row['last_name'];?>">
                </div>
            </div>
            <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="form-group label-floating">
                    <label class="control-label"><?= getPhrase('username');?></label>
                    <input class="form-control" type="text" name="username" required="" value="<?= $row['username'];?>">
                </div>
            </div>
            <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="form-group label-floating">
                    <label class="control-label"><?= getPhrase('password');?></label>
                    <input class="form-control" type="text" name="password">
                </div>
            </div>
            <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="form-group label-floating">
                    <label class="control-label"><?= getPhrase('email');?></label>
                    <input class="form-control" type="email" name="email" id="emailx" value="<?= $row['email'];?>">
                    <small><span id="result_emailx"></span></small>
                    <span class="input-group-addon">
                        <i class="icon-feather-mail"></i>
                    </span>
                </div>
            </div>
            <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="form-group label-floating is-select">
                    <label class="control-label"><?= getPhrase('account_type');?></label>
                    <div class="select">
                        <select name="owner_status" id="slct">
                            <option value=""><?= getPhrase('select');?></option>
                            <?php 
                            foreach ($roles as $role) :
                            ?>
                            <option value="<?= $role['role_id']?>"
                                <?php if($row['owner_status'] == $role['role_id']) echo 'selected';?>>
                                <?= $role['name'];?>
                            </option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="form-group label-floating">
                    <label class="control-label"><?= getPhrase('phone');?></label>
                    <input class="form-control" placeholder="" name="phone" type="text" value="<?= $row['phone'];?>">
                    <span class="input-group-addon">
                        <i class="icon-feather-phone"></i>
                    </span>
                </div>
            </div>
            <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="form-group label-floating is-select">
                    <label class="control-label"><?= getPhrase('gender');?></label>
                    <div class="select">
                        <select name="gender" id="slct">
                            <option value=""><?= getPhrase('select');?></option>
                            <?php
                                    $genders = $this->db->get('gender')->result_array();
                                    foreach($genders as $gender):
                                    ?>
                            <option value="<?= $gender['code']?>"
                                <?= $gender['code'] == $row['gender'] ? 'selected': ''; ?>><?= $gender['name']?>
                            </option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="form-group label-floating">
                    <label class="control-label"><?= getPhrase('address');?></label>
                    <input class="form-control" placeholder="" name="address" type="text"
                        value="<?= $row['address'];?>">
                    <span class="input-group-addon">
                        <i class="icon-feather-map-pin"></i>
                    </span>
                </div>
            </div>
            <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                <button class="btn btn-rounded btn-success btn-lg " id="sub_form"
                    type="submit"><?= getPhrase('update');?></button>
            </div>
        </div>
        <?= form_close();?>
    </div>
</div>
<?php endforeach;?>

<script type="text/javascript">
$(document).ready(function() {
    var query;
    $("#emailx").keyup(function(e) {
        query = $("#emailx").val();
        $("#result_emailx").queue(function(n) {
            $.ajax({
                type: "POST",
                url: '<?= base_url();?>register/search_email',
                data: "c=" + query,
                dataType: "html",
                error: function() {
                    alert("¡Error!");
                },
                success: function(data) {
                    if (data == "success") {
                        texto =
                            "<b style='color:#ff214f'><?= getPhrase('email_already_exist');?></b>";
                        $("#result_emailx").html(texto);
                        $('#sub_form').attr('disabled', 'disabled');
                    } else {
                        texto = "";
                        $("#result_emailx").html(texto);
                        $('#sub_form').removeAttr('disabled');
                    }
                    n();
                }
            });
        });
    });
});
</script>