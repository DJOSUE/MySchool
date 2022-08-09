<?php
	$quantity_score         = intval($this->academic->getInfo('ap_quantity_score'));
    $ap_test_names          = json_decode($this->academic->getInfo('ap_test_names'), true);
    $placement_weighting	= json_decode($this->academic->getInfo('placement_weighting'), true);
    $level_percent          =    $this->db->query('SELECT * FROM class WHERE percentage IS NOT NULL')->result_array(); 

    $first_name = $data['first_name'];
    $last_name  = $data['last_name'];
    $birthday   = $data['birthday'];
    $email      = $data['email'];
    $phone      = $data['phone'];
    $gender     = $data['gender'];
    $address    = $data['address'];
    $country_id = $data['country_id'];
    $applicant_id = $data['applicant_id'];
?>

<?php $running_year = $this->crud->getInfo('running_year');?>
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
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/admission_new_applicant/">
                            <i
                                class="os-icon picons-thin-icon-thin-0716_user_profile_add_new"></i><span><?php echo getPhrase('new_applicant');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links active" href="<?php echo base_url();?>admin/admission_new_student/">
                            <i
                                class="os-icon picons-thin-icon-thin-0706_user_profile_add_new"></i><span><?php echo getPhrase('new_student');?></span></a>
                    </li>
                </ul>
            </div>
        </div><br>
        <div class="container-fluid">
            <div class="layout-w">
                <div class="content-w">
                    <div class="content-i">
                        <div class="content-box">
                            <div class="conty">
                                <div class="ui-block">
                                    <div class="ui-block-content">
                                        <?php echo form_open(base_url() . 'admin/student/admission/' , array('enctype' => 'multipart/form-data', 'autocomplete' => 'off'));?>
                                        <?php if($applicant_id > 0):?>
                                        <input type="hidden" name="applicant_id" value="<?=$applicant_id;?>"/>
                                        <?php endif;?>
                                        <div class="steps-w">
                                            <div class="step-triggers">
                                                <a class="step-trigger active"
                                                    href="#stepContent0"><?php echo getPhrase('placement_test');?></a>
                                                <a class="step-trigger"
                                                    href="#stepContent1"><?php echo getPhrase('student_details');?></a>
                                                <a class="step-trigger"
                                                    href="#stepContent2"><?php echo getPhrase('parent_details');?></a>
                                                <a class="step-trigger"
                                                    href="#stepContent3"><?php echo getPhrase('complementary_data');?></a>
                                            </div>
                                            <div class="step-contents">
                                                <div class="step-content active" id="stepContent0">
                                                    <div class="row">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr style="background:#f2f4f8;">
                                                                        <?php for ($i=1; $i <= $quantity_score; $i++):
															$name = 'score'.$i;?>
                                                                        <th class="text-center">
                                                                            <?= $ap_test_names[$name] ?>
                                                                        </th>
                                                                        <?php endfor; ?>

                                                                        <th style="text-align: center;">
                                                                            <?php echo getPhrase('comment');?>
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <?php for ($i=1; $i <= $quantity_score; $i++):
															$name = 'score'.$i;?>
                                                                        <td class="text-center">
                                                                            <center>
                                                                                <input type="number" name="<?= $name;?>"
                                                                                    id="<?= $name;?>" placeholder="-"
                                                                                    max="<?= $placement_weighting[$name] ?>"
                                                                                    required
                                                                                    style="width:85px; border: 1; text-align: center;">
                                                                            </center>
                                                                        </td>
                                                                        <?php endfor; ?>

                                                                        <td style="text-align: center;">
                                                                            <center>
                                                                                <input type="text" class="form-control"
                                                                                    name="comment_placement" 
                                                                                    value="<?php echo $row['comment'];?>">
                                                                            </center>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="form-buttons-w text-right">
                                                        <a class="btn btn-rounded btn-success btn-lg step-trigger-btn"
                                                            href="#stepContent1"
                                                            onclick="get_level()"><?php echo getPhrase('next');?></a>
                                                    </div>
                                                </div>
                                                <div class="step-content" id="stepContent1">
                                                    <div class="row div-center text-center">
                                                        <div class="info-box"
                                                            style="background-color: #f2f4f8; color:#000">
                                                            <p>
                                                                <?= getPhrase('suggested_level')?>: <br />
                                                                <span id="suggested_level"
                                                                    class="h5"><?= getPhrase('enter_score_placement_test')?></span>
                                                            </p>
                                                        </div>

                                                    </div>
                                                    <br />
                                                    <br />
                                                    <div class="row">
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('first_name');?></label>
                                                                <input class="form-control" name="first_name"
                                                                    type="text" required="" value="<?=$first_name;?>">
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('last_name');?></label>
                                                                <input class="form-control" name="last_name" type="text"
                                                                    required="" value="<?=$last_name;?>">
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group date-time-picker label-floating">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('birthday');?></label>
                                                                <input type='text' class="datepicker-here"
                                                                    data-position="bottom left" data-language='en'
                                                                    name="datetimepicker"
                                                                    data-multiple-dates-separator="/" />
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('email');?></label>
                                                                <input class="form-control" name="email" type="email"
                                                                    id="student_email" required="" value="<?=$email;?>">
                                                                <small><span id="email_result_student"></span></small>
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('phone');?></label>
                                                                <input class="form-control" name="phone" type="text"
                                                                    value="<?=$phone;?>">
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating is-select">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('gender');?></label>
                                                                <div class="select">
                                                                    <select name="gender" required="">
                                                                        <option value="">
                                                                            <?php echo getPhrase('select');?></option>
                                                                        <?php $genders = $this->db->get('gender')->result_array();
                                                                            foreach($genders as $gender):
                                                                        ?>
                                                                        <option value="<?= $gender['code']?>"
                                                                            <?=$gender == $gender['code'] ? 'selected' : '' ;?>">
                                                                            <?= $gender['name']?>
                                                                        </option>
                                                                        <?php endforeach;?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('username');?></label>
                                                                <input class="form-control" name="username"
                                                                    autocomplete="false" required="" type="text"
                                                                    id="user_student">
                                                                <small><span id="result_student"></span></small>
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('password');?></label>
                                                                <input class="form-control" name="password" required=""
                                                                    autocomplete="false" type="password">
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('address');?></label>
                                                                <input class="form-control" name="address" type="text"
                                                                    value="<?=$address;?>">
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating is-select">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('country_of_birth');?></label>
                                                                <div class="select">
                                                                    <select name="country_id" id="country_id"
                                                                        required="true">
                                                                        <option value="">
                                                                            <?php echo getPhrase('select');?></option>
                                                                        <?php $countries = $this->db->get('countries')->result_array();
                                                                            foreach($countries as $country):
                                                                        ?>
                                                                        <option
                                                                            value="<?php echo $country['country_id'];?>"
                                                                            <?=$country_id == $country['country_id'] ? 'selected' : '' ;?>>
                                                                            <?php echo $country['name'];?></option>
                                                                        <?php endforeach;?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('roll');?></label>
                                                                <input class="form-control" name="student_code"
                                                                    type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating is-select">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('class');?></label>
                                                                <div class="select">
                                                                    <select name="class_id" id="class_id" required=""
                                                                        onchange="get_class_sections(this.value);">
                                                                        <option value="">
                                                                            <?php echo getPhrase('select');?></option>
                                                                        <?php $classes = $this->db->get('class')->result_array();
        	                  										foreach($classes as $class):
               											        ?>
                                                                        <option
                                                                            value="<?php echo $class['class_id'];?>">
                                                                            <?php echo $class['name'];?></option>
                                                                        <?php endforeach;?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating is-select">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('section');?></label>
                                                                <div class="select">
                                                                    <select name="section_id"
                                                                        id="section_selector_holder"
                                                                        onchange="get_class_section_subjects(this.value);">
                                                                        <option value="">
                                                                            <?php echo getPhrase('select');?></option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating is-select">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('subject');?></label>
                                                                <div>
                                                                    <select name="subject_id[]"
                                                                        id="subject_selector_holder" multiple
                                                                        class="selectpicker form-control" title="">

                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating is-select">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('transport');?></label>
                                                                <div class="select">
                                                                    <select name="transport_id">
                                                                        <option value="">
                                                                            <?php echo getPhrase('select');?></option>
                                                                        <?php 
        											                $bus = $this->db->get('transport')->result_array();
                  											        foreach($bus as $trans):
               											        ?>
                                                                        <option
                                                                            value="<?php echo $trans['transport_id'];?>">
                                                                            <?php echo $trans['route_name'];?></option>
                                                                        <?php endforeach;?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating is-select">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('program');?></label>
                                                                <div class="select">
                                                                    <select name="program_id" required>
                                                                        <option value="">
                                                                            <?php echo getPhrase('select');?></option>
                                                                        <?php 
        	                  										$classroom = $this->db->get('program')->result_array();
                  											        foreach($classroom as $room):
               											        ?>
                                                                        <option
                                                                            value="<?php echo $room['program_id'];?>">
                                                                            <?php echo $room['name'];?></option>
                                                                        <?php endforeach;?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                                                            <div class="form-group">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('photo');?></label>
                                                                <input class="form-control" placeholder=""
                                                                    name="userfile" type="file">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-buttons-w text-right">
                                                        <a class="btn btn-rounded btn-success btn-lg step-trigger-btn"
                                                            href="#stepContent2"><?php echo getPhrase('next');?></a>
                                                    </div>
                                                </div>
                                                <div class="step-content" id="stepContent2">
                                                    <div class="row">
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="description-toggle">
                                                                <div class="description-toggle-content">
                                                                    <div class="h6">
                                                                        <?php echo getPhrase('new_parent_admission');?>
                                                                    </div>
                                                                    <p><?php echo getPhrase('new_parent_admission_message');?>
                                                                    </p>
                                                                </div>
                                                                <div class="togglebutton">
                                                                    <label><input type="checkbox" id="check" value="1"
                                                                            name="account"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12"
                                                            id="initial">
                                                            <div class="form-group label-floating is-select">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('select_parent');?></label>
                                                                <div class="select">
                                                                    <select name="parent_id">
                                                                        <option value="">
                                                                            <?php echo getPhrase('select');?></option>
                                                                        <?php $parents = $this->db->get('parent')->result_array();
                      												foreach($parents as $parent):
              											        ?>
                                                                        <option
                                                                            value="<?php echo $parent['parent_id'];?>">
                                                                            <?php echo $parent['first_name']." ".$parent['last_name'];?>
                                                                        </option>
                                                                        <?php endforeach;?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" id="new_parent">
                                                        <div class="ui-block-title" style="margin-bottom:10px;">
                                                            <h6 class="title"><?php echo getPhrase('parent_details');?>
                                                            </h6>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('first_name');?></label>
                                                                <input class="form-control" name="parent_first_name"
                                                                    type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('last_name');?></label>
                                                                <input class="form-control" name="parent_last_name"
                                                                    type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating is-select">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('gender');?></label>
                                                                <div class="select">
                                                                    <select name="parent_gender">
                                                                        <option value="">
                                                                            <?php echo getPhrase('select');?></option>
                                                                        <?php
                                                        $genders = $this->db->get('gender')->result_array();
                                                        foreach($genders as $gender):
                                                        ?>
                                                                        <option value="<?= $gender['code']?>">
                                                                            <?= $gender['name']?>
                                                                        </option>
                                                                        <?php endforeach;?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('email');?></label>
                                                                <input class="form-control" name="parent_email"
                                                                    id="parent_email" type="email">
                                                                <small><span id="email_result_parent"></span></small>
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('username');?></label>
                                                                <input class="form-control" name="parent_username"
                                                                    autocomplete="false" type="text"
                                                                    id="parent_username">
                                                                <small><span id="result"></span></small>
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('password');?></label>
                                                                <input class="form-control" name="parent_password"
                                                                    autocomplete="false" type="password">
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('phone');?></label>
                                                                <input class="form-control" name="parent_phone"
                                                                    type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('identification');?></label>
                                                                <input class="form-control" name="parent_idcard"
                                                                    type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('profession');?></label>
                                                                <input class="form-control" name="parent_profession"
                                                                    type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('address');?></label>
                                                                <input class="form-control" name="parent_address"
                                                                    type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('home_phone');?></label>
                                                                <input class="form-control" name="parent_home_phone"
                                                                    type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('business_work');?></label>
                                                                <input class="form-control" name="parent_business"
                                                                    type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('phone_work');?></label>
                                                                <input class="form-control" name="parent_business_phone"
                                                                    type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-buttons-w text-right">
                                                        <a class="btn btn-rounded btn-success btn-lg step-trigger-btn"
                                                            href="#stepContent3"><?php echo getPhrase('next');?></a>
                                                    </div>
                                                </div>
                                                <div class="step-content" id="stepContent3">
                                                    <div class="row">
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('conditions_or_diseases');?></label>
                                                                <input class="form-control" name="diseases" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('allergies');?></label>
                                                                <input class="form-control" name="allergies"
                                                                    type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('personal_doctor');?></label>
                                                                <input class="form-control" name="doctor" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('doctor_phone');?></label>
                                                                <input class="form-control" name="doctor_phone"
                                                                    type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('athorized_person');?></label>
                                                                <input class="form-control" name="auth_person"
                                                                    type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('phone_authorized_person');?></label>
                                                                <input class="form-control" name="auth_phone"
                                                                    type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('notes');?>:</label>
                                                                <textarea class="form-control" name="note"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="description-toggle">
                                                                <div class="description-toggle-content">
                                                                    <div class="h6">
                                                                        <?php echo getPhrase('download_adminssion_sheet');?>
                                                                    </div>
                                                                    <p><?php echo getPhrase('download_adminssion_sheet_message');?>
                                                                    </p>
                                                                </div>
                                                                <div class="togglebutton">
                                                                    <label><input type="checkbox" value="1"
                                                                            name="download_pdf"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-buttons-w text-right">
                                                        <button class="btn btn-rounded btn-success btn-lg" type="submit"
                                                            id="sub_form"><?php echo getPhrase('register');?></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php echo form_close();?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="display-type"></div>
        </div>
    </div>
</div>

<script>
function get_level() {

    const weighting = <?=json_encode($placement_weighting)?>;

    var average = [];

    for (let i = 0; i < <?= $quantity_score ?>; i++) {
        name = 'score' + (i + 1);
        value = document.getElementById(name).value;
        average[i] = (value / weighting[name]);
    }

    var result = Math.round((eval(average.join('+')) / average.length) * 100);

    if (result >= 0 && result <= 20) {
        document.getElementById("suggested_level").innerHTML = "BEGINNERS";
    } else if (result >= 21 && result <= 40) {
        document.getElementById("suggested_level").innerHTML = "BASIC";
    } else if (result >= 41 && result <= 60) {
        document.getElementById("suggested_level").innerHTML = "INTERMEDIATE";
    } else if (result >= 61 && result <= 80) {
        document.getElementById("suggested_level").innerHTML = "ADVANCED";
    } else if (result >= 81 && result <= 100) {
        document.getElementById("suggested_level").innerHTML = "EXPERT I";
    }
}

$(document).ready(function() {
    var query;
    $("#user_student").keyup(function(e) {
        query = $("#user_student").val();
        $("#result_student").queue(function(n) {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>register/search_user',
                data: "c=" + query,
                dataType: "html",
                error: function() {
                    alert("¡Error!");
                },
                success: function(data) {
                    if (data == "success") {
                        texto =
                            "<b style='color:#ff214f'><?php echo getPhrase('already_exist');?></b>";
                        $("#result_student").html(texto);
                        $('#sub_form').attr('disabled', 'disabled');
                    } else {
                        texto = "";
                        $("#result_student").html(texto);
                        $('#sub_form').removeAttr('disabled');
                    }
                    n();
                }
            });
        });
    });
});

$(document).ready(function() {
    var query;
    $("#parent_username").keyup(function(e) {
        query = $("#parent_username").val();
        $("#result").queue(function(n) {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>register/search_user',
                data: "c=" + query,
                dataType: "html",
                error: function() {
                    alert("¡Error!");
                },
                success: function(data) {
                    if (data == "success") {
                        texto =
                            "<b style='color:#ff214f'><?php echo getPhrase('already_exist');?></b>";
                        $("#result").html(texto);
                        $('#sub_form').attr('disabled', 'disabled');
                    } else {
                        texto = "";
                        $("#result").html(texto);
                        $('#sub_form').removeAttr('disabled');
                    }
                    n();
                }
            });
        });
    });
});

$(document).ready(function() {
    var query;
    $("#parent_email").keyup(function(e) {
        query = $("#parent_email").val();
        $("#email_result_parent").queue(function(n) {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>register/search_email',
                data: "c=" + query,
                dataType: "html",
                error: function() {
                    alert("¡Error!");
                },
                success: function(data) {
                    if (data == "success") {
                        texto =
                            "<b style='color:#ff214f'><?php echo getPhrase('email_already_exist');?></b>";
                        $("#email_result_parent").html(texto);
                        $('#sub_form').attr('disabled', 'disabled');
                    } else {
                        texto = "";
                        $("#email_result_parent").html(texto);
                        $('#sub_form').removeAttr('disabled');
                    }
                    n();
                }
            });
        });
    });
});

$(document).ready(function() {
    var query;
    $("#student_email").keyup(function(e) {
        query = $("#student_email").val();
        $("#email_result_student").queue(function(n) {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>register/search_email',
                data: "c=" + query,
                dataType: "html",
                error: function() {
                    alert("¡Error!");
                },
                success: function(data) {
                    if (data == "success") {
                        texto =
                            "<b style='color:#ff214f'><?php echo getPhrase('email_already_exist');?></b>";
                        $("#email_result_student").html(texto);
                        $('#sub_form').attr('disabled', 'disabled');
                    } else {
                        texto = "";
                        $("#email_result_student").html(texto);
                        $('#sub_form').removeAttr('disabled');
                    }
                    n();
                }
            });
        });
    });
});

function get_class_sections(class_id) {
    console.log(class_id);

    $.ajax({
        url: '<?php echo base_url();?>admin/get_class_section/' + class_id,
        success: function(response) {
            jQuery('#section_selector_holder').html(response);
        }
    });
}

function get_class_section_subjects(section_id) {

    console.log(section_id);

    var class_id = document.getElementById("class_id").value;
    // var year = document.getElementById("year_id").value;
    // var period = document.getElementById("period_id").value;



    $.ajax({
        url: '<?php echo base_url();?>admin/get_class_section_subjects/' + class_id + '/' +
            section_id, //+ '/' + year + '/' + period ,
        success: function(response) {
            jQuery('#subject_selector_holder').html(response).selectpicker('refresh');
        }
    });
}

$('#check').click(function() {
    if ($('#check').is(':checked') == true) {
        $("#new_parent").show(500);
        $("#initial").hide(500);
    } else {
        $("#new_parent").hide(500);
        $("#initial").show(500);
    }
});
$("#new_parent").hide();
</script>