<?php $title = $this->crud->getInfo('system_title'); ?>
<?php $system_name = $this->crud->getInfo('system_name'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo getPhrase('set_new_password');?> | <?php echo $title;?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/style/login/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css"
        href="<?php echo base_url();?>public/style/login/css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/style/login/css/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/style/login/css/iofrm-theme16.css">
    <link href="<?php echo base_url();?>public/uploads/<?php echo $this->crud->getInfo('favicon');?>" rel="icon">
</head>

<body>
    <div class="form-body without-side">
        <div class="row">
            <div class="form-holder">
                <div class="form-content"
                    style="background-image: url(<?php echo base_url();?>public/uploads/<?php echo $this->crud->getInfo('bglogin');?>); background-size:cover;">
                    <div class="form-items">
                        <center><img class="logo-size"
                                src="<?php echo base_url();?>public/uploads/<?php echo $this->crud->getInfo('logo');?>"
                                alt="" class="w120"></center>
                        <br>
                        <h5><?php echo getPhrase('set_your_password');?></h5><br>
                        <?php echo form_open(base_url() . 'forgot_password/set_new_password/'.$token.'/'.$type_user, array('onsubmit' => 'return validateForm();', 'name' => "myForm"));?>
                        <input class="form-control" type="password" name="password"
                            placeholder="<?php echo getPhrase('new_password');?>" autocomplete="off" required>
                        <small><span id="password_error"></span></small>
                        <input class="form-control" type="password" name="password_confirm"
                            placeholder="<?php echo getPhrase('repeat_new_password');?>" autocomplete="off" required>
                        <small><span id="password_confirm_error"></span></small>
                        <div class="form-button">
                            <button id="submit" type="submit"
                                class="ibtn"><?php echo getPhrase('set_password');?></button>
                            <a href="<?php echo base_url();?>"><?php echo getPhrase('return');?>.</a>
                        </div>
                        <?php echo form_close();?>
                        <br><br>
                        <div class="page-links">
                            <a href="<?php echo base_url();?>terms/"><?php echo getPhrase('terms_conditions');?></a>
                            <?php if($this->crud->getInfo('register') == 1):?><a
                                href="<?php echo base_url();?>register/"><?php echo getPhrase('create_account');?></a><?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url();?>public/style/login/js/jquery.min.js"></script>
    <script src="<?php echo base_url();?>public/style/login/js/popper.min.js"></script>
    <script src="<?php echo base_url();?>public/style/login/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>public/style/login/js/main.js"></script>
</body>
<script>
function validateForm() {
    let new_password = document.forms["myForm"]["password"].value;
    let new_password_c = document.forms["myForm"]["password_confirm"].value;
    var text = "";

    if (new_password.length < 6) {
        text = "<b style='color:#ff214f'><?php echo getPhrase('password_error_length');?></b>";
        $("#password_error").html(text);
        return false;
    }
    else
    {
        $("#password_error").html(text);
    }

    if (new_password != new_password_c) {
        text = "<b style='color:#ff214f'><?php echo getPhrase('password_does_not_match_new_password');?></b>";
        $("#password_confirm_error").html(text);
        return false;
    }

}
</script>

</html>