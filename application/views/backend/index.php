<?php 
    $system_name    =	$this->crud->getInfo('system_name');
	$system_title   =	$this->crud->getInfo('system_title');
    $account_type   =   get_account_type();
    
    $page_array     = array('subject_dashboard', 'online_exams', 'homework', 'forum', 'study_material', 'upload_marks', 'meet', 'gamification');

    $layout         = in_array($page_name, $message_pages) ? 'class="layout-w"' : '';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $page_title;?> | <?= $system_title;?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta content="ie=edge" http-equiv="x-ua-compatible">
    <meta content="School System, MySchool, DHCoder" name="keywords">
    <meta content="DHCoder" name="author">
    <meta content="9.0" name="soft_version">
    <meta content="<?= $system_name ." ".$system_title;?>" name="description">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link href="<?= base_url();?>public/uploads/<?= $this->crud->getInfo('favicon');?>" rel="icon">
    <link href="<?= base_url();?>public/style/cms/css/main.css" media="all" rel="stylesheet">
    <script src="<?= base_url();?>public/style/jquery.min.js"></script>
    <script src="<?= base_url();?>public/style/js/sweetalert2.all.min.js"></script>
    <?php include 'topcss.php';?>
    <script>
    'use strict';
    var rootAppURI = '<?= base_url();?>';
    var today = '<?= getPhrase('today');?>';
    var month = '<?= getPhrase('month');?>';
    var week = '<?= getPhrase('week');?>';
    var day = '<?= getPhrase('day');?>';
    var list = '<?= getPhrase('list');?>';
    var exist = '<?= getPhrase('email_already_exist');?>';
    var locale = '<?= $this->crud->getInfo('calendar');?>';
    var updated = '<?= getPhrase('successfully_updated');?>';
    var uriseg = '<?= $this->uri->segment(2);?>';
    var urig = '<?= $this->uri->segment(1);?>';
    var select_qn = '<?= getPhrase('select_question_type');?>';
    </script>
</head>

<!-- <div>
    <?php
        echo '<pre>';
        var_dump($_SESSION);
        echo '</pre>';
    ?>
</div> -->
<body class="menu-position-side menu-side-left full-screen with-content-panel">
    <div class="with-side-panel">
        <div <?php $layout;?>>
            <?php include $account_type.'/navigation.php';?>
            <?php  include $account_type.'/'.$page_name.'.php'; ?>
        </div>
        <div class="display-type"></div>
    </div>
    <?php include 'modal.php';?>
    <?php include 'scripts.php';?>
</body>

</html>