<?php $title = $this->crud->getInfo('system_title'); ?>
<?php $system_name = $this->crud->getInfo('system_name'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta content="School System, MySchool, DHCoder" name="keywords">
    <meta content="DHCoder" name="author">
    <meta content="9.0" name="soft_version">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo getPhrase('login');?> | <?php echo $title;?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/style/login/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/style/login/css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/style/login/css/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/style/login/css/iofrm-theme16.css">
    <link href="<?php echo base_url();?>public/uploads/<?php echo $this->crud->getInfo('favicon');?>" rel="icon">
</head>
<body>
    <div class="form-body without-side">
        <div class="row">
            <div class="form-holder">
                <div class="form-content" style="background-image: url(<?php echo base_url();?>public/uploads/<?php echo $this->crud->getInfo('bglogin');?>); background-size:cover;">
                    <div class="form-items">
                        <center><img class="logo-size" src="<?php echo base_url();?>public/uploads/<?php echo $this->crud->getInfo('logo');?>" alt="" class="w120"></center>
                        <br><h5><?php echo getPhrase('login_to_your_account');?></h5><br>
                         <?php if($this->session->userdata('error') == '1'):?>    
                            <div class="form-login-error">
                                <center><div class="alert alert-danger"><?php echo getPhrase('login_error');?></div></center>
                            </div>
                        <?php endif;?>
                        <?php if($this->session->userdata('failed') == '1'):?>
                            <div class="alert alert-danger text-center text-bold"><?php echo getPhrase('social_error');?></div>
                        <?php endif;?>
                        <?php if($this->session->userdata('success_recovery') == '1'):?>
                            <div class="alert alert-success text-center text-bold"><?php echo getPhrase('password_reset');?></div>
                        <?php endif;?>
                        <?php if($this->session->userdata('success_new_password') == '1'):?>
                            <div class="alert alert-success text-center text-bold"><?php echo getPhrase('success_set_new_password');?></div>
                        <?php endif;?>
                        <?php if($this->session->userdata('error_new_password') == '1'):?>
                            <div class="alert alert-success text-center text-bold"><?php echo getPhrase('token_expired');?></div>
                        <?php endif;?>
                        <?php if($this->session->userdata('failedf') == '1'):?>
                            <div class="alert alert-danger text-center text-bold"><?php echo getPhrase('social_error');?></div>
                        <?php endif;?>
                        <form method="post" action="<?php echo base_url();?>login/auth/">
                            <input class="form-control" type="text" name="username" placeholder="<?php echo getPhrase('username');?>" required>
                            <input class="form-control" type="password" name="password" placeholder="<?php echo getPhrase('password');?>" required>
                            <div class="form-button">
                                <button id="submit" type="submit" class="ibtn"><?php echo getPhrase('login');?></button> <a href="<?php echo base_url();?>forgot_password/"><?php echo getPhrase('forgot_my_password');?></a>
                            </div>
                        </form>
                        <?php if($this->crud->getInfo('social_login') == 1):?>
                            <div class="other-links text-center">
                                <div class="text"><?php echo getPhrase('or');?></div>
                                <a href="<?php echo $this->crud->getFacebookURL();?>"><i class="fab fa-facebook-f"></i>Facebook</a><a href="<?php echo $this->crud->getGoogleURL();?>"><i class="fab fa-google"></i>Google</a>
                            </div>
                        <?php else:?><br><br>
                        <?php endif;?>
                        <div class="page-links">
                            <a href="<?php echo base_url();?>terms/"><?php echo getPhrase('terms_conditions');?></a>
                            <?php if($this->crud->getInfo('register') == 1):?><a href="<?php echo base_url();?>register/"><?php echo getPhrase('create_account');?></a><?php endif;?>
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
</html>