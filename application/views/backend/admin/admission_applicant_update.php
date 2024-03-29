<?php 
    $user_id = get_login_user_id();
    $applicant_info = $this->db->get_where('applicant' , array('applicant_id' => $applicant_id))->result_array(); 
    $allow_actions = is_student($applicant_id);
    foreach($applicant_info as $row): 
        $tags_applicant = json_decode($row['tags'], true)['tags_id'];
        $status_info = $this->applicant->get_applicant_status_info($row['status']);
        $type_info = $this->applicant->get_type_info($row['type_id']);
        $birthday = date('Y-m-d', strtotime($row['birthday']));

        $css_assigned_to = "";
        $allow_re_assigned = has_permission('re_assigned_applicant');
        if(!$allow_re_assigned)
        {
            $css_assigned_to = 'style="display:none"';
        }
        
?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <? include 'admission__nav.php';?>
        </div><br>
        <div class="row">
            <div class="content-i">
                <div class="content-box">
                    <div class="row">
                        <main class="col col-xl-9 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
                            <div id="newsfeed-items-grid">
                                <div class="ui-block paddingtel">
                                    <div class="user-profile">
                                        <?php include 'admission_applicant__header.php';?>
                                        <div class="ui-block">
                                            <div class="ui-block-title">
                                                <h6 class="title"><?= getPhrase('personal_information');?>
                                                </h6>
                                            </div>
                                            <?= form_open(base_url() . 'admin/applicant/update/'.$row['applicant_id'].'/admission_applicant' , array('enctype' => 'multipart/form-data'));?>
                                            <div class="ui-block-content">
                                                <div class="row">
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating is-select">
                                                            <label class="control-label"><?= getPhrase('status');?></label>
                                                            <div class="select">
                                                                <select name="status_id" required="">
                                                                    <?php $status = $this->applicant->get_applicant_status_update($row['status']);
                                                                        foreach($status as $item):
                                                                            if($item['status_id'] != 3):
                                                                    ?>
                                                                    <option value="<?=$item['status_id']?>"
                                                                        <?php if($row['status'] == $item['status_id']) echo "selected";?>>
                                                                        <?= $item['name'];?>
                                                                    </option>
                                                                            <?php endif;?>    
                                                                    <?php endforeach;?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12" <?=$css_assigned_to;?>>
                                                        <div class="form-group label-floating is-select" style="border-color: #000 !important;">
                                                            <label class="control-label"><?= getPhrase('assigned_to');?></label>
                                                            <div class="select">
                                                                <select name="assigned_to">
                                                                    <option value=""><?= getPhrase('select');?></option>

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
                                                                class="control-label"><?= getPhrase('first_name');?></label>
                                                            <input class="form-control" name="first_name"
                                                                value="<?= $row['first_name'];?>" type="text" required="">
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating">
                                                            <label
                                                                class="control-label"><?= getPhrase('last_name');?></label>
                                                            <input class="form-control" name="last_name"
                                                                value="<?= $row['last_name'];?>" type="text" required="">
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group date-time-picker label-floating">
                                                            <label class="control-label"><?= getPhrase('birthday');?></label>
                                                            <input type='text' class="datepicker-here" data-position="top left"
                                                                data-language='en' name="datetimepicker"
                                                                data-multiple-dates-separator="/"
                                                                value="<?= $birthday;?>" />
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label"><?= getPhrase('email');?></label>
                                                            <input class="form-control" name="email"
                                                                value="<?= $row['email'];?>" type="email">
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label"><?= getPhrase('phone');?></label>
                                                            <input class="form-control" name="phone"
                                                                value="<?= $row['phone'];?>" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating is-select">
                                                            <label class="control-label"><?= getPhrase('gender');?></label>
                                                            <div class="select">
                                                                <select name="gender" required="">
                                                                    <option value=""><?= getPhrase('select');?></option>
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
                                                            <label class="control-label"><?= getPhrase('country_of_birth');?></label>
                                                            <div class="select">
                                                                <select name="country_id" required="">
                                                                    <option value=""><?= getPhrase('select');?></option>
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
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12"></div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label"><?= getPhrase('address');?></label>
                                                            <input class="form-control" name="address"
                                                                value="<?= $row['address'];?>" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label"><?= getPhrase('city');?></label>
                                                            <input class="form-control" name="city"
                                                                value="<?= $row['city'];?>" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label"><?= getPhrase('state');?></label>
                                                            <input class="form-control" name="state"
                                                                value="<?= $row['state'];?>" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label"><?= getPhrase('postal_code');?></label>
                                                            <input class="form-control" name="postal_code"
                                                                value="<?= $row['postal_code'];?>" type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr/>
                                                <h6 class="title"><?= getPhrase('tags');?></h6>
                                                <div class="row">
                                                    <?php 
                                                    $tags = $this->applicant->get_tags();
                                                    foreach($tags as $tag):
                                                        $tag_id = $tag['tag_id'];
                                                    ?>
                                                    <div class="col-sm-2">
                                                        <div class="description-toggle">
                                                            <div class="description-toggle-content">
                                                                <div class="h7"><?= $tag['name'];?></div>
                                                            </div>
                                                            <div class="togglebutton">
                                                                <label><input name="tag_<?=$tag_id?>" value="1" type="checkbox"
                                                                        <?php if(in_array($tag_id, $tags_applicant)) echo "checked";?>></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php endforeach;?>
                                                </div>                                                
                                                <div class="form-buttons-w">
                                                    <button class="btn btn-rounded btn-success" style="float: right;" type="submit">
                                                        <?= getPhrase('save');?></button><br>
                                                </div>
                                            </div>
                                            <?= form_close();?>
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
                                                <h3 class="title"><?= getPhrase('quick_links');?></h3>
                                                <? include 'admission_applicant__menu.php'?>
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
