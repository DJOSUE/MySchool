<?php 
	$social_login = $this->crud->getInfo('social_login');
    $teacher_id = get_login_user_id();
    $info = $this->db->get_where('teacher', array('teacher_id' => $teacher_id))->result_array();
    foreach($info as $row):
?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="content-i">
        <div class="content-box">
            <div class="conty">
                <div class="row">
                    <main class="col col-xl-9 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
                        <div id="newsfeed-items-grid">
                            <div class="ui-block paddingtel">
                                <div class="user-profile">
                                    <div class="up-head-w"
                                        style="background-image:url(<?php echo base_url();?>public/uploads/bglogin.jpg)">
                                        <div class="up-main-info">
                                            <div class="user-avatar-w">
                                                <div class="user-avatar">
                                                    <img alt=""
                                                        src="<?php echo $this->crud->get_image_url('teacher', $row['teacher_id']);?>"
                                                        style="background-color:#fff;">
                                                </div>
                                            </div>
                                            <h3 class="text-white">
                                                <?php echo $this->crud->get_name('teacher', $row['teacher_id']);?></h3>
                                            <h5 class="up-sub-header">@<?php echo $row['username'];?></h5>
                                        </div>
                                        <svg class="decor" width="842px" height="219px" viewBox="0 0 842 219"
                                            preserveAspectRatio="xMaxYMax meet" version="1.1"
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <g transform="translate(-381.000000, -362.000000)" fill="#FFFFFF">
                                                <path class="decor-path"
                                                    d="M1223,362 L1223,581 L381,581 C868.912802,575.666667 1149.57947,502.666667 1223,362 Z">
                                                </path>
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="up-controls">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="value-pair">
                                                    <div><?php echo getPhrase('account_type');?>:</div>
                                                    <div class="value badge badge-pill badge-success">
                                                        <?php echo getPhrase('teacher');?></div>
                                                </div>
                                                <div class="value-pair">
                                                    <div><?php echo getPhrase('member_since');?>:</div>
                                                    <div class="value"><?php echo $row['since'];?>.</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ui-block">
                                        <div class="ui-block-title">
                                            <h6 class="title"><?php echo getPhrase('update_information');?></h6>
                                        </div>
                                        <div class="ui-block-content">
                                            <?php echo form_open(base_url() . 'teacher/my_account/update_profile/'.$row['teacher_id'] , array('enctype' => 'multipart/form-data'));?>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label"><?php echo getPhrase('first_name');?></label>
                                                        <input class="form-control" type="text" name="first_name"
                                                            value="<?php echo $row['first_name'];?>" disabled="">
                                                        <span class="material-input"></span>
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label"><?php echo getPhrase('last_name');?></label>
                                                        <input class="form-control" type="text" name="last_name"
                                                            value="<?php echo $row['last_name'];?>" disabled="">
                                                        <span class="material-input"></span>
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label"><?php echo getPhrase('username');?></label>
                                                        <input class="form-control" type="text" name="username"
                                                            value="<?php echo $row['username'];?>" required="">
                                                        <span class="material-input"></span>
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label"><?php echo getPhrase('update_password');?></label>
                                                        <input class="form-control" type="password" name="password">
                                                        <span class="material-input"></span>
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label"><?php echo getPhrase('email');?></label>
                                                        <input class="form-control" type="text" name="email"
                                                            value="<?php echo $row['email'];?>">
                                                        <span class="material-input"></span>
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label"><?php echo getPhrase('phone');?></label>
                                                        <input class="form-control" type="text" name="phone"
                                                            value="<?php echo $row['phone'];?>">
                                                        <span class="material-input"></span>
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label"><?php echo getPhrase('identification');?></label>
                                                        <input class="form-control" type="text" name="idcard"
                                                            value="<?php echo $row['idcard'];?>">
                                                        <span class="material-input"></span>
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group is-focused">
                                                        <label
                                                            class="control-label"><?php echo getPhrase('birthday');?></label>
                                                        <input type='text' class="datepicker-here"
                                                            data-position='top left'
                                                            value="<?php echo $row['birthday'];?>" data-language='en'
                                                            name="birthday" data-multiple-dates-separator="/" />
                                                        <span class="input-group-addon">
                                                            <i class="icon-feather-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label"><?php echo getPhrase('photo');?></label>
                                                        <input class="form-control" type="file" name="userfile">
                                                        <span class="material-input"></span>
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label"><?php echo getPhrase('address');?></label>
                                                        <textarea class="form-control" name="address"
                                                            rows="3"><?php echo $row['address'];?></textarea>
                                                        <span class="material-input"></span>
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="pull-right">
                                                        <button class="btn btn-success btn-rounded pull-right"
                                                            type="submit"> <?php echo getPhrase('update');?></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php echo form_close();?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </main>
                    <div class="col col-xl-3 order-xl-1 col-lg-6 order-lg-2 col-md-6 col-sm-12 col-12">
                        <div class="eduappgt-sticky-sidebar">
                            <div class="sidebar__inner">
                                <div class="ui-block paddingtel">
                                    <div class="ui-block-content">
                                        <div class="widget w-about">
                                            <a href="javascript:void(0);" class="logo"><img
                                                    src="<?php echo base_url();?>public/uploads/<?php echo $this->crud->getInfo('logo');?>"></a>
                                            <ul class="socials">
                                                <li><a class="socialDash fb"
                                                        href="<?php echo $this->crud->getInfo('facebook');?>"><i
                                                            class="fab fa-facebook-square" aria-hidden="true"></i></a>
                                                </li>
                                                <li><a class="socialDash tw"
                                                        href="<?php echo $this->crud->getInfo('twitter');?>"><i
                                                            class="fab fa-twitter" aria-hidden="true"></i></a></li>
                                                <li><a class="socialDash yt"
                                                        href="<?php echo $this->crud->getInfo('youtube');?>"><i
                                                            class="fab fa-youtube" aria-hidden="true"></i></a></li>
                                                <li><a class="socialDash ig"
                                                        href="<?php echo $this->crud->getInfo('instagram');?>"><i
                                                            class="fab fa-instagram" aria-hidden="true"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="ui-block paddingtel">
                                    <div class="ui-block-content">
                                        <div class="help-support-block">
                                            <h3 class="title"><?php echo getPhrase('quick_links');?></h3>
                                            <ul class="help-support-list">
                                                <li>
                                                    <i class="picons-thin-icon-thin-0133_arrow_right_next px20"></i>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <a
                                                        href="<?php echo base_url();?>teacher/my_account/"><?php echo getPhrase('personal_information');?></a>
                                                </li>
                                                <li>
                                                    <i class="picons-thin-icon-thin-0133_arrow_right_next px20"></i>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <a
                                                        href="<?php echo base_url();?>teacher/teacher_update/"><?php echo getPhrase('update_information');?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
									<?php if($social_login != 0): ?>
                                    <h4 class="text-center"><?php echo getPhrase('your_linked_accounts');?></h4>
                                    <?php $photo  = $this->crud->getUserSocial('teacher', 'fb_photo');?>
                                    <?php $name   = $this->crud->getUserSocial('teacher', 'fb_name');?>
                                    <?php $id     = $this->crud->getUserSocial('teacher', 'fb_id');?>
                                    <?php $gid    = $this->crud->getUserSocial('teacher', 'g_oauth');?>
                                    <?php $fname  = $this->crud->getUserSocial('teacher', 'g_fname');?>
                                    <?php $lname  = $this->crud->getUserSocial('teacher', 'g_lname');?>
                                    <?php $gphoto = $this->crud->getUserSocial('teacher', 'g_picture');?>
                                    <?php $gemail = $this->crud->getUserSocial('teacher', 'g_email');?>
                                    <div class="pricing-plans row no-gutters">
                                        <div class="pricing-plan col-sm-6">
                                            <div class="plan-head">
                                                <div class="plan-image">
                                                    <?php if($photo != ""):?>
                                                    <img alt="" src="<?php echo $photo;?>">
                                                    <?php else:?>
                                                    <img src="<?php echo base_url();?>public/uploads/facebook.png">
                                                    <?php endif;?>
                                                </div>
                                                <div class="plan-name">
                                                    Facebook<?php if($name != ""):?><br><small><?php echo $name;?></small><?php endif;?>
                                                </div>
                                            </div>
                                            <div class="plan-body"><br><br>
                                                <div class="plan-btn-w">
                                                    <?php if($id == ""):?>
                                                    <a class="btn btn-success btn-rounded"
                                                        href="<?php echo $this->crud->getFacebookURL();?>"><?php echo getPhrase('link');?></a>
                                                    <?php else:?>
                                                    <a class="btn btn-danger btn-rounded"
                                                        href="<?php echo base_url();?>teacher/my_account/remove_facebook/"><?php echo getPhrase('unlink');?></a>
                                                    <?php endif;?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pricing-plan col-sm-6">
                                            <div class="plan-head">
                                                <div class="plan-image">
                                                    <?php if($gid != ""):?>
                                                    <img alt="" src="<?php echo $gphoto;?>">
                                                    <?php else:?>
                                                    <img src="<?php echo base_url();?>public/uploads/google.png">
                                                    <?php endif;?>
                                                </div>
                                                <div class="plan-name">
                                                    <?php if($gid != ""):?><?php echo $fname ." ". $lname;?><br><span
                                                        class="px10"><?php echo $gemail;?></span><?php else:?>Google<?php endif;?>
                                                </div>
                                            </div>
                                            <div class="plan-body"><br><br>
                                                <div class="plan-btn-w">
                                                    <?php if($gid == ""):?>
                                                    <a class="btn btn-success btn-rounded"
                                                        href="<?php echo $output;?>"><?php echo getPhrase('link');?></a>
                                                    <?php else:?>
                                                    <a class="btn btn-danger btn-rounded"
                                                        href="<?php echo base_url();?>teacher/my_account/remove_google/"><?php echo getPhrase('unlink');?></a>
                                                    <?php endif;?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									<?php endif;?>
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
<?php endforeach;?>