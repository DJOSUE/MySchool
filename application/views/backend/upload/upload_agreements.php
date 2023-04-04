<?php 
    $account_type       =   get_account_type(); 
    $fancy_path         =   $_SERVER['DOCUMENT_ROOT'].'/application/views/backend/'.$account_type.'/';

    // validate if has access as admin/helpdesk user
    $user_id            = get_login_user_id();
    $account_type       =   get_account_type(); 

?>
<div class="content-w">
    <?php include $fancy_path.'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <?php include 'upload__nav.php';?>
            </div>
        </div><br>
        <div class="content-i">
            <div class="content-box">
                <div class="element-box lined-purple shadow" style="border-radius:10px;">
                    <h4 class="form-header"><i class="picons-thin-icon-thin-0356_database"></i>
                        <?= getPhrase('upload_agreements');?></h4><br>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="ui-block" data-mh="friend-groups-item">
                                <div class="friend-item friend-groups">
                                    <div class="friend-item-content">
                                        <div class="form-group with-button">
                                            <a href="/public/uploads/templates/agreement.xls">
                                                <input class="form-control " readonly="" value="Download template"
                                                    type="text" style="cursor: default; color:#000; font-weight:bold">
                                                <button class="bg-primary">
                                                    <i class="icon-feather-download"></i>
                                                </button>
                                            </a>
                                            <span class="material-input"></span>
                                        </div>
                                        <?= form_open(base_url() . 'UploadController/upload_bulk/agreements', array('enctype' => 'multipart/form-data'));?>
                                        <div class="friend-avatar">
                                            <div class="author-thumb">
                                                <img src="<?= base_url();?>public/uploads/icons/restore.svg"
                                                    width="110px"
                                                    style="background-color:#fff;padding:15px; border-radius:0px;">
                                            </div>
                                            <div class="author-content">
                                                <a href="javascript:void(0);" class="h5 author-name">
                                                    <?= getPhrase('upload_agreements');?>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="control-block-button">
                                            <center>
                                                <input id="upload_agreement" type="file" name="upload_agreement"
                                                    accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                                    style="background-color: #99bf2d; width:250px;">
                                            </center>
                                        </div>

                                        <div class="control-block-button">
                                            <button type="submit" class="btn btn-control bg-primary text-white">
                                                <i class="picons-thin-icon-thin-0124_upload_cloud_file_sync_backup"></i>
                                            </button>
                                        </div>
                                        <?= form_close();?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>