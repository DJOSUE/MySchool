<?php 
    $user_id = $this->session->userdata('login_user_id');
    $applicant_info = $this->db->get_where('v_applicants' , array('applicant_id' => $applicant_id))->result_array(); 
    $allow_actions = is_student($applicant_id);
    foreach($applicant_info as $row): 
?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <ul class="navs navs-tabs upper">
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/admission_dashboard/">
                            <i
                                class="os-icon picons-thin-icon-thin-0482_gauge_dashboard_empty"></i><span><?php echo getPhrase('home');?></span></a>
                    </li>
                    <li class="navs-item active">
                        <a class="navs-links" href="<?php echo base_url();?>admin/admission_new_applicant/">
                            <i
                                class="os-icon picons-thin-icon-thin-0716_user_profile_add_new"></i><span><?php echo getPhrase('new_applicant');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/admission_new_student/">
                            <i
                                class="os-icon picons-thin-icon-thin-0706_user_profile_add_new"></i><span><?php echo getPhrase('new_student');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links active" href="<?php echo base_url();?>admin/admission_applicant/">
                            <i
                                class="os-icon picons-thin-icon-thin-0704_users_profile_group_couple_man_woman"></i><span><?php echo getPhrase('applicant');?></span></a>
                    </li>
                </ul>
            </div>
        </div><br>
        <div class="row">
            <div class="content-i">
                <div class="content-box">
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
                                                            src="<?php echo $this->crud->get_image_url('applicant', $row['applicant_id']);?>"
                                                            style="background-color:#fff;">
                                                    </div>
                                                </div>
                                                <h3 class="text-white"><?php echo $row['first_name'];?>
                                                    <?php echo $row['last_name'];?></h3>
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
                                                        <div><?php echo getPhrase('applicant_type');?>:</div>
                                                        <div class="value badge badge-pill badge-info" style="background-color: <?= $row['applicant_type_color']?>;">
                                                            <?=$row['applicant_type'];?>
                                                        </div>
                                                    </div>
                                                    <div class="value-pair">
                                                        <div><?php echo getPhrase('status');?>:</div>
                                                        <div class="value badge badge-pill badge-primary" style="background-color: <?= $row['status_name_color']?>;">
                                                            <?= $row['status_name'];?></div>
                                                    </div>                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ui-block">
                                            <div class="ui-block-title">
                                                <h6 class="title"><?php echo getPhrase('personal_information');?>
                                                </h6>
                                            </div>
                                            <?php echo form_open(base_url() . 'admin/applicant/update/'.$row['applicant_id'] , array('enctype' => 'multipart/form-data'));?>
                                            <div class="ui-block-content">
                                                <div class="row">
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating is-select">
                                                            <label class="control-label"><?php echo getPhrase('status');?></label>
                                                            <div class="select">
                                                                <select name="status_id" required="">
                                                                    <option value=""><?php echo getPhrase('select');?></option>

                                                                    <?php $status = $this->db->get('v_applicant_status')->result_array();
                                                                        foreach($status as $item):
                                                                    ?>
                                                                    <option value="<?=$item['status_id']?>"
                                                                        <?php if($row['status'] == $item['status_id']) echo "selected";?>>
                                                                        <?= $item['name'];?>
                                                                    </option>
                                                                    <? endforeach;?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating is-select" style="border-color: #000 !important;">
                                                            <label class="control-label"><?php echo getPhrase('assigned_to');?></label>
                                                            <div class="select">
                                                                <select name="assigned_to" required="">
                                                                    <option value=""><?php echo getPhrase('select');?></option>

                                                                    <?php $status = $this->db->get_where('admin', array('status' => 1, 'owner_status' => '3'))->result_array();
                                                                        foreach($status as $item):
                                                                    ?>
                                                                    <option value="<?=$item['admin_id']?>"
                                                                        <?php if($row['assigned_to'] == $item['admin_id']) echo "selected";?>>
                                                                        <?= $item['first_name'];?>
                                                                    </option>
                                                                    <? endforeach;?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating">
                                                            <label
                                                                class="control-label"><?php echo getPhrase('first_name');?></label>
                                                            <input class="form-control" name="first_name"
                                                                value="<?php echo $row['first_name'];?>" type="text" required="">
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group date-time-picker label-floating">
                                                            <label class="control-label"><?php echo getPhrase('birthday');?></label>
                                                            <input type='text' class="datepicker-here" data-position="top left"
                                                                data-language='en' name="datetimepicker"
                                                                data-multiple-dates-separator="/"
                                                                value="<?php echo $row['birthday'];?>" />
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label"><?php echo getPhrase('email');?></label>
                                                            <input class="form-control" name="email"
                                                                value="<?php echo $row['email'];?>" type="email">
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label"><?php echo getPhrase('phone');?></label>
                                                            <input class="form-control" name="phone"
                                                                value="<?php echo $row['phone'];?>" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating is-select">
                                                            <label class="control-label"><?php echo getPhrase('gender');?></label>
                                                            <div class="select">
                                                                <select name="gender" required="">
                                                                    <option value=""><?php echo getPhrase('select');?></option>
                                                                    <?php
                                                                    $genders = $this->db->get('gender')->result_array();
                                                                    foreach($genders as $gender):
                                                                    ?>                                                        
                                                                    <option value="<?= $gender['code']?>" <?= $gender['code'] == $row['gender'] ? 'selected': ''; ?>><?= $gender['name']?></option>
                                                                    <?php endforeach;?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating is-select">
                                                            <label class="control-label"><?php echo getPhrase('country_of_birth');?></label>
                                                            <div class="select">
                                                                <select name="country_id" required="">
                                                                    <option value=""><?php echo getPhrase('select');?></option>
                                                                    <?php
                                                                    $countries = $this->db->get('countries')->result_array();
                                                                    foreach($countries as $country):
                                                                    ?>                                                        
                                                                    <option value="<?= $country['country_id']?>" <?= $country['country_id'] == $row['country_id'] ? 'selected': ''; ?>><?= $country['name']?></option>
                                                                    <?php endforeach;?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label"><?php echo getPhrase('address');?></label>
                                                            <input class="form-control" name="address"
                                                                value="<?php echo $row['address'];?>" type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-buttons-w">
                                                    <button class="btn btn-rounded btn-success" style="float: right;" type="submit">
                                                        <?php echo getPhrase('save');?></button><br>
                                                </div>
                                            </div>
                                            <?php echo form_close();?>
                                        </div>
                                        <br/>    
                                    </div>
                                </div>
                            </div>
                        </main>
                        <div class="col col-xl-3 order-xl-1 col-lg-12 order-lg-2 col-md-12 col-sm-12 col-12">
                            <div class="eduappgt-sticky-sidebar">
                                <div class="sidebar__inner">
                                    <div class="ui-block paddingtel">
                                        <div class="ui-block-content">
                                            <div class="help-support-block">
                                                <h3 class="title"><?php echo getPhrase('quick_links');?></h3>
                                                <ul class="help-support-list">
                                                    <li>
                                                        <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                            style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                        <a
                                                            href="<?php echo base_url();?>admin/admission_applicant/<?php echo $applicant_id;?>/">
                                                            <?php echo getPhrase('personal_information');?>
                                                        </a>
                                                    </li>
                                                    <?php if(!$allow_actions):?>
                                                    <li>
                                                        <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                            style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                        <a
                                                            href="<?php echo base_url();?>admin/admission_applicant_update/<?php echo $applicant_id;?>/">
                                                            <?php echo getPhrase('update_information');?>
                                                        </a>
                                                    </li>                                                    
                                                    <li>
                                                        <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                            style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                        <a
                                                            href="<?php echo base_url();?>admin/admission_applicant_convert/<?php echo $applicant_id;?>/">
                                                            <?php echo getPhrase('convert_to_student');?>
                                                        </a>
                                                    </li>
                                                    <?php endif;?>
                                                </ul>
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
    </div>
</div>
<?php endforeach;?>