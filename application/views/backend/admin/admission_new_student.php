<?php
	$quantity_score         = intval($this->academic->getInfo('ap_quantity_score'));
    $ap_test_names          = json_decode($this->academic->getInfo('ap_test_names'), true);
    $placement_weighting	= json_decode($this->academic->getInfo('placement_weighting'), true);
    $level_percent          =    $this->db->query('SELECT * FROM class WHERE percentage IS NOT NULL')->result_array(); 

    $first_name     = $data['first_name'];
    $last_name      = $data['last_name'];
    $birthday       = $data['birthday'];
    $email          = $data['email'];
    $phone          = $data['phone'];
    $genderCode     = $data['gender'];
    $address        = $data['address'];
    $country_id     = $data['country_id'];
    $applicant_id   = $data['applicant_id'];
    $referral_by    = $data['referral_by'];
    $type_id        = $data['type_id'] ;
    $program_id     = $data['program_id'];


?>

<link rel="stylesheet" href="/public/style/picker/picker.min.css">
<script type="text/javascript" src="/public/style/picker/picker.min.js"></script>

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
                            <i class="os-icon picons-thin-icon-thin-0482_gauge_dashboard_empty"></i>
                            <span><?php echo getPhrase('dashboard');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/admission_applicants/">
                            <i class="os-icon picons-thin-icon-thin-0093_list_bullets"></i>
                            <span><?php echo getPhrase('applicants');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/admission_new_applicant/">
                            <i class="os-icon picons-thin-icon-thin-0716_user_profile_add_new"></i>
                            <span><?php echo getPhrase('new_applicant');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links active" href="<?php echo base_url();?>admin/admission_new_student/">
                            <i class="os-icon picons-thin-icon-thin-0706_user_profile_add_new"></i>
                            <span><?php echo getPhrase('new_student');?></span></a>
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

                                        <?php endif;?>
                                        <div class="steps-w">
                                            <div class="step-triggers">
                                                <a class="step-trigger active"
                                                    href="#stepContent1"><?php echo getPhrase('placement_test');?></a>
                                                <a class="step-trigger"
                                                    href="#stepContent2"><?php echo getPhrase('student_info');?></a>
                                                <a class="step-trigger"
                                                    href="#stepContent3"><?php echo getPhrase('class_info');?></a>
                                                <a class="step-trigger"
                                                    href="#stepContent4"><?php echo getPhrase('payment_info');?></a>
                                            </div>
                                            <div class="step-contents">
                                                <div class="step-content active" id="stepContent1"
                                                    name="placement_test">
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
                                                                                    id="<?= $name;?>" value="0"
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
                                                            href="#stepContent2"
                                                            onclick="get_level()"><?php echo getPhrase('next');?></a>
                                                    </div>
                                                </div>
                                                <div class="step-content" id="stepContent2" name="personal_info">
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
                                                            <div class="form-group label-floating is-select">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('program');?></label>
                                                                <div class="select">
                                                                    <select name="program_id" id="program_id" required
                                                                        <?= $type_id != 2 && $type_id != '' ? 'readonly' : '' ?>>
                                                                        <?php 
                                                                            $programs = $this->db->get('program')->result_array();
                                                                            foreach($programs as $program):
                                                                        ?>
                                                                        <option
                                                                            value="<?php echo $program['program_id'];?>"
                                                                            <?= $program['program_id'] == $program_id ? 'selected' : '' ?>>
                                                                            <?php echo $program['name'];?>
                                                                        </option>
                                                                        <?php endforeach;?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('first_name');?></label>
                                                                <input class="form-control" name="first_name"
                                                                    id="first_name" type="text" required=""
                                                                    value="<?=$first_name;?>">
                                                                <small><span id="first_name_error"></span></small>
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('last_name');?></label>
                                                                <input class="form-control" name="last_name"
                                                                    id="last_name" type="text" required=""
                                                                    value="<?=$last_name;?>">
                                                                <small><span id="last_name_error"></span></small>
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group date-time-picker label-floating">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('birthday');?></label>
                                                                <input type='text' class="datepicker-here"
                                                                    data-position="top left" data-language='en'
                                                                    name="datetimepicker" id="datetimepicker"
                                                                    data-multiple-dates-separator="/"
                                                                    value="<?= $birthday;?>" />
                                                                <small><span id="birthday_error"></span></small>
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
                                                                <input class="form-control" name="phone" id="phone"
                                                                    type="text" value="<?=$phone;?>">
                                                                <small><span id="phone_error"></span></small>
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating is-select">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('gender');?></label>
                                                                <div class="select">
                                                                    <select name="gender" id="gender" required="">
                                                                        <option value="">
                                                                            <?php echo getPhrase('select');?></option>
                                                                        <?php $genders = $this->db->get('gender')->result_array();
                                                                            foreach($genders as $gender):
                                                                        ?>
                                                                        <option value="<?= $gender['code']?>"
                                                                            <?=$genderCode == $gender['code'] ? 'selected' : '' ;?>>
                                                                            <?= $gender['name']?>
                                                                        </option>
                                                                        <?php endforeach;?>
                                                                    </select>
                                                                    <small><span id="gender_error"></span></small>
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
                                                                <input class="form-control" name="password"
                                                                    id="password" required="" autocomplete="false"
                                                                    type="password">
                                                                <small><span id="password_error"></span></small>
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('address');?></label>
                                                                <input class="form-control" name="address" id="address"
                                                                    type="text" value="<?=$address;?>">
                                                                <small><span id="address_error"></span></small>
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
                                                                    <small><span id="country_error"></span></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                                                            <div class="form-group">
                                                                <label
                                                                    class="control-label"><?php echo getPhrase('photo');?></label>
                                                                <input class="form-control" placeholder=""
                                                                    name="userfile" type="file">
                                                                <small><span id="photo_error"></span></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr />
                                                    <h3>Complementary data</h3>
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
                                                    </div>
                                                    <div name="hide_items">
                                                        <input type="hidden" name="applicant_id"
                                                            value="<?=$applicant_id;?>" />
                                                        <input type="hidden" name="referral_by"
                                                            value="<?=$referral_by;?>" />
                                                    </div>
                                                    <div class="form-buttons-w text-right">
                                                        <a class="btn btn-rounded btn-success btn-lg"
                                                            style="color: #fff;"
                                                            onclick="validate_form_student_info()"><?php echo getPhrase('next');?></a>
                                                        <a class="btn btn-rounded btn-success btn-lg step-trigger-btn"
                                                            id="btnStepContent3" style="display: none;"
                                                            href="#stepContent3"><?php echo getPhrase('next');?></a>
                                                    </div>
                                                </div>
                                                <div class="step-content" id="stepContent3" name="class_info">
                                                    <div class="row">
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating is-select">
                                                                <label
                                                                    class="control-label"><?= getPhrase('program_type');?>
                                                                </label>
                                                                <div class="select">
                                                                    <select name="program_type_id" id="program_type_id"
                                                                        required=""
                                                                        <?= $is_international == true ?  'readonly ': ''?>
                                                                        onchange="rest_selection()">
                                                                        </option>
                                                                        <?php 
                                                                        $programs = $this->studentModel->get_program_type();
                                                                        foreach($programs as $item):
                                                                    ?>
                                                                        <option value="<?= $item['program_type_id']; ?>"
                                                                            <?= $program_type_id == $item['program_type_id'] ? 'selected': ''; ?>>
                                                                            <?= $item['name']; ?>
                                                                        </option>
                                                                        <?php endforeach?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating is-select">
                                                                <label
                                                                    class="control-label"><?= getPhrase('modality');?>
                                                                </label>
                                                                <div class="select">
                                                                    <select name="modality_id" id="modality_id"
                                                                        required="" onchange="rest_selection()">
                                                                        </option>
                                                                        <?php 
                                                                        $modalities = $this->academic->get_modality();
                                                                        foreach($modalities as $item):
                                                                    ?>
                                                                        <option value="<?= $item['modality_id']; ?>">
                                                                            <?= $item['name']; ?>
                                                                        </option>
                                                                        <?php endforeach?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating is-select">
                                                                <label class="control-label"><?= getPhrase('books');?>
                                                                </label>
                                                                <div class="select">
                                                                    <select name="book_type" id="book_type" required="">
                                                                        <option value="Physical">
                                                                            <?= getPhrase('Physical');?>
                                                                        </option>
                                                                        <option value="Online">
                                                                            <?= getPhrase('Online');?>
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating is-select">
                                                                <label class="control-label"><?= getPhrase('year');?>
                                                                </label>
                                                                <div class="select">
                                                                    <select name="year_id" id="year_id" required=""
                                                                        onchange="rest_selection()">
                                                                        <option value=""><?= getPhrase('select');?>
                                                                        </option>
                                                                        <?php 
                                                                        $years = $this->db->get_where('years', array('status' => '1'))->result_array();
                                                                        foreach($years as $item):
                                                                    ?>
                                                                        <option value="<?= $item['year']; ?>"
                                                                            <?php if($running_year == $item['year']) echo 'selected';?>>
                                                                            <?= $item['year']; ?></option>
                                                                        <?php endforeach?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating is-select">
                                                                <label
                                                                    class="control-label"><?= getPhrase('semester');?></label>
                                                                <div class="select">
                                                                    <select name="semester_id" id="semester_id"
                                                                        required="" onchange="rest_selection()">
                                                                        <option value=""><?= getPhrase('select');?>
                                                                        </option>
                                                                        <?php 
                                                                        $semesters = $this->db->get('semesters')->result_array();
                                                                        foreach($semesters as $semester):
                                                                    ?>
                                                                        <option value="<?= $semester['semester_id'];?>"
                                                                            <?php if($running_semester == $semester['semester_id']) echo 'selected';?>>
                                                                            <?= $semester['name']?></option>
                                                                        <?php endforeach;?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating is-select">
                                                                <label
                                                                    class="control-label"><?= getPhrase('class');?></label>
                                                                <div class="select">
                                                                    <select name="class_id" id="class_id"
                                                                        onchange="get_class_sections(this.value);">
                                                                        <option value=""><?= getPhrase('select');?>
                                                                        </option>
                                                                        <?php $classes = $this->db->get('class')->result_array();
                                                                foreach($classes as $class):
                                                            ?>
                                                                        <option value="<?= $class['class_id'];?>">
                                                                            <?= $class['name'];?></option>
                                                                        <?php endforeach;?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating is-select">
                                                                <label
                                                                    class="control-label"><?= getPhrase('section');?></label>
                                                                <div class="select">
                                                                    <select name="section_id"
                                                                        id="section_selector_holder"
                                                                        onchange="get_class_section_subjects(this.value);">
                                                                        <option value=""><?= getPhrase('select');?>
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating is-select">
                                                                <label
                                                                    class="control-label"><?= getPhrase('subject');?></label>
                                                                <div>
                                                                    <select name="subject_id[]"
                                                                        id="subject_selector_holder" multiple
                                                                        class="selectpicker form-control" title="">
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <small><span id="class_error"></span></small>
                                                    <div class="form-buttons-w text-right">
                                                        <a class="btn btn-rounded btn-success btn-lg step-trigger-btn"
                                                            onclick="validate_form_class()" style="color: white;">
                                                            <?= getPhrase('next');?>
                                                        </a>
                                                        <a class="btn btn-rounded btn-success btn-lg step-trigger-btn"
                                                            id="btnStepContent4" href="#stepContent4"
                                                            style="display: none;">
                                                            <?= getPhrase('next');?>
                                                        </a>
                                                    </div>

                                                </div>
                                                <div class="step-content" id="stepContent4" name="payment_info">
                                                    <div class="row">
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">
                                                                    <?= getPhrase('cost_tuition');?>
                                                                </label>
                                                                <input class="form-control" name="cost_tuition"
                                                                    id="tuition" type="text" required="" readonly
                                                                    value="0">
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">
                                                                    <?= getPhrase('enrol_fee');?>
                                                                </label>
                                                                <input class="form-control" name="fees"
                                                                    id="cost_fees" value="0"
                                                                    onfocusout="agreement_amount_total()" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">
                                                                    <?= getPhrase('books_fee');?>
                                                                </label>
                                                                <input class="form-control" name="books_fee"
                                                                    id="cost_books_fee" value="75"
                                                                    onfocusout="agreement_amount_total()" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">
                                                                    <?= getPhrase('scholarship');?>
                                                                </label>
                                                                <input class="form-control" name="discount_scholarship"
                                                                    id="discount_scholarship"
                                                                    onfocusout="agreement_amount_total()" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">
                                                                    <?= getPhrase('discount');?>
                                                                </label>
                                                                <input class="form-control" name="discount"
                                                                    id="discount" onfocusout="agreement_amount_total()"
                                                                    type="text">
                                                            </div>
                                                        </div>

                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        </div>
                                                    </div>
                                                    <hr />
                                                    <div class="row">
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">
                                                                    <?= getPhrase('total_agreement');?>
                                                                </label>
                                                                <input class="form-control" name="total_agreement"
                                                                    value="0" id="total_agreement" type="text"
                                                                    required="" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr />
                                                    <br />
                                                    <h3>Payment Schedule</h3>
                                                    <br />
                                                    <div class="row">
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="description-toggle">
                                                                <div class="description-toggle-content">
                                                                    <div class="h6"><?= getPhrase('has_down_payment');?>
                                                                    </div>
                                                                </div>
                                                                <div class="togglebutton">
                                                                    <label>
                                                                        <input id="has_down_payment"
                                                                            name="has_down_payment" value="1"
                                                                            type="checkbox"
                                                                            onchange="enable_down_payment()">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating is-select">
                                                                <label
                                                                    class="control-label"><?= getPhrase('payment_date');?>
                                                                </label>
                                                                <div class="select">
                                                                    <select name="payment_date" id="payment_date"
                                                                        required="">
                                                                        <?php 
                                                                        $payment_dates = $this->agreement->get_payment_date();
                                                                        foreach($payment_dates as $item):
                                                                    ?>
                                                                        <option value="<?= $item['date'];?>">
                                                                            <?= $item['name']?></option>
                                                                        <?php endforeach;?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="schedule_without_down_payment">
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating is-select">
                                                                <label
                                                                    class="control-label"><?= getPhrase('number_of_payments');?>
                                                                </label>
                                                                <div class="select">
                                                                    <select name="number_payments" id="number_payments"
                                                                        required="" onchange="add_fees()">
                                                                        <option value="1">1</option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="schedule_with_down_payment">
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">
                                                                    <?= getPhrase('payment_1');?>
                                                                </label>
                                                                <input class="form-control" name="amount_1"
                                                                    id="amount_1" onfocusout="validate_amount_1()"
                                                                    type="text" required="" value="0" readOnly="">
                                                                <small>
                                                                    <span id="amount_error"></span>
                                                                </small>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="row" id="payment_schedule">

                                                    </div>
                                                    <hr />
                                                    <div class="row" id="create_payment_div" style="display:none;">
                                                        <div class="row">
                                                        <h3>Payment Transaction</h3>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col" id="transactions">
                                                                <div class="row" style="padding: 0 10px;">
                                                                    <div class="table-responsive">
                                                                        <table id="items" class="table table-padded">
                                                                            <thead>
                                                                                <th><?=getPhrase('type')?></th>
                                                                                <th><?=getPhrase('amount')?></th>
                                                                                <th></th>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php 
                                                                        $transaction_types = $this->payment->get_transaction_types();
                                                                        foreach($transaction_types as $item):
                                                                        ?>
                                                                                <tr>
                                                                                    <td>
                                                                                        <select class="custom-select"
                                                                                            tabindex="-1"
                                                                                            id="payment_type_<?=$item['transaction_type_id']?>"
                                                                                            name="payment_type_<?=$item['transaction_type_id']?>">
                                                                                            <option
                                                                                                value="<?=$item['transaction_type_id']?>">
                                                                                                <?=$item['name']?>
                                                                                            </option>
                                                                                        </select>
                                                                                        <?php if($item['name'] == 'Card'):?>
                                                                                        <select class="custom-select"
                                                                                            style="width: 200px;"
                                                                                            id="card_type_<?=$item['transaction_type_id']?>"
                                                                                            name="card_type_<?=$item['transaction_type_id']?>"
                                                                                            onchange="apply_card_fee()"
                                                                                            tabindex="-1">
                                                                                            <?php 
                                                                                    $card_types = $this->payment->get_credit_cards();
                                                                                    foreach($card_types as $card):
                                                                                    ?>
                                                                                            <option
                                                                                                value="<?=$card['creditcard_id']?>">
                                                                                                <?=$card['name']?>
                                                                                            </option>
                                                                                            <?php endforeach;?>
                                                                                        </select>
                                                                                        <?php endif;?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <input style="width: 150px;"
                                                                                            id="payment_amount_<?=$item['transaction_type_id']?>"
                                                                                            name="payment_amount_<?=$item['transaction_type_id']?>"
                                                                                            type="text" class="currency"
                                                                                            placeholder="00.00"
                                                                                            onfocusout="payment_total()" />
                                                                                        <?php if($item['name'] == 'Card'):?>
                                                                                        <span id="card_fee"
                                                                                            class="currency"></span>
                                                                                        <span id="total_fee"
                                                                                            class="currency"></span>
                                                                                        <?php endif;?>
                                                                                    </td>
                                                                                    <?php if($item['name'] != 'Cash'):?>
                                                                                    <td>
                                                                                        <input
                                                                                            name="transaction_code_<?=$item['transaction_type_id']?>"
                                                                                            type="text"
                                                                                            style="width: 150px;" />
                                                                                    </td>
                                                                                    <?php endif;?>
                                                                                </tr>
                                                                                <?php endforeach;?>
                                                                                <tr>
                                                                                    <td class="currency">
                                                                                        <b style='color:#ff214f'>Remaining
                                                                                            to
                                                                                            pay:</b>
                                                                                    </td>
                                                                                    <td>
                                                                                        <span id="remainingAmount"
                                                                                            class="currency">00.00</span>
                                                                                        <input id="total_payment"
                                                                                            class="currency"
                                                                                            type="hidden" disabled />
                                                                                    </td>
                                                                                    <td>
                                                                                        <span
                                                                                            id="txtRemainingAmount"></span>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="comment"><?=getPhrase('comment')?></label>
                                                                        <textarea class="form-control" name="comment"
                                                                            rows="3" require></textarea>
                                                                    </div>
                                                                </div>
                                                                <br /><br />
                                                                <div class="" style="margin-right: 50px;">
                                                                    <h6 class="title">
                                                                        <?= getPhrase('payment_summary');?>
                                                                    </h6>
                                                                    <table>
                                                                        <thead>
                                                                            <th></th>
                                                                            <th></th>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>Total Down Payment
                                                                                </td>
                                                                                <td>
                                                                                    <span id="totalAmount"
                                                                                        class="currency">00.00</span>
                                                                                    <input id="txtTotalAmount"
                                                                                        type="hidden" />
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Credit card fee
                                                                                </td>
                                                                                <td>
                                                                                    <span id="totalCardFee"
                                                                                        class="currency">00.00</span>
                                                                                    <input id="txtTotalCardFee"
                                                                                        type="hidden" />
                                                                                </td>
                                                                            </tr>
                                                                            <tr style="border-top: 1px solid;">
                                                                                <td>Total to pay
                                                                                </td>
                                                                                <td>
                                                                                    <span id="total"
                                                                                        class="currency">00.00</span>
                                                                                    <input id="txtTotal" name="txtTotal"
                                                                                        type="hidden" />
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <small><span id="payment_error"></span></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr />
                                                    <div class="row">
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="description-toggle">
                                                                <div class="description-toggle-content">
                                                                    <div class="h6">
                                                                        <?= getPhrase('automatic_payment');?>
                                                                    </div>
                                                                </div>
                                                                <div class="togglebutton">
                                                                    <label>
                                                                        <input id="automatic_payment"
                                                                            name="automatic_payment" value="1"
                                                                            type="checkbox"
                                                                            onchange="automatic_payment_enable_fields()">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" id="automatic_payment_div" style="display: none;">

                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating is-select">
                                                                <label
                                                                    class="control-label"><?= getPhrase('type_card');?>
                                                                </label>
                                                                <div class="select">
                                                                    <select name="type_card_id" id="type_card_id">
                                                                        <option value=""><?= getPhrase('select');?>
                                                                        </option>
                                                                        <?php 
                                                                        $card_types = $this->payment->get_credit_cards();
                                                                        foreach($card_types as $item):
                                                                    ?>
                                                                        <option value="<?= $item['creditcard_id']; ?>">
                                                                            <?= $item['name']; ?>
                                                                        </option>
                                                                        <?php endforeach?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label
                                                                    class="control-label"><?= getPhrase('card_holder');?>
                                                                </label>
                                                                <input class="form-control" name="card_holder"
                                                                    id="card_holder" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label
                                                                    class="control-label"><?= getPhrase('card_number');?>
                                                                </label>
                                                                <input class="form-control" name="card_number"
                                                                    id="card_number" type="text" minlength="15"
                                                                    maxlength="16">
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label
                                                                    class="control-label"><?= getPhrase('security_code');?>
                                                                </label>
                                                                <input class="form-control" name="security_code"
                                                                    id="security_code" type="text" minlength="3"
                                                                    maxlength="4">
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label
                                                                    class="control-label"><?= getPhrase('expiration_date');?>
                                                                </label>
                                                                <input class="form-control" name="expiration_date"
                                                                    id="expiration_date" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="form-group label-floating">
                                                                <label
                                                                    class="control-label"><?= getPhrase('zip_code');?>
                                                                </label>
                                                                <input class="form-control" name="zip_code"
                                                                    id="zip_code" type="text" minlength="5">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-buttons-w text-right">
                                                        <button class="btn btn-rounded btn-success" type="submit"
                                                            id="btn_save">
                                                            <?= getPhrase('save');?>
                                                        </button>
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

<script type="text/javascript">
$(function() {
    var keyStop = {
        8: ":not(input:text, textarea, input:file, input:password)", // stop backspace = back
        13: "input:text, input:password", // stop enter = submit 

        end: null
    };
    $(document).bind("keydown", function(event) {
        var selector = keyStop[event.which];

        if (selector !== undefined && $(event.target).is(selector)) {
            event.preventDefault(); //stop event
        }
        return true;
    });
});

function rest_selection() {

    // document.getElementById("year_id").selectedIndex = 0;
    // document.getElementById("semester_id").selectedIndex = 0;
    document.getElementById("class_id").selectedIndex = 0;
    document.getElementById("section_selector_holder").selectedIndex = 0;
    jQuery('#subject_selector_holder').html('').selectpicker('refresh');

}

function validate_form_student_info() {

    var valid = true;
    var obj_fn = document.getElementById("first_name");
    var obj_ln = document.getElementById("last_name");
    var obj_em = document.getElementById("student_email");
    var obj_ph = document.getElementById("phone");
    var obj_ad = document.getElementById("address");
    var obj_un = document.getElementById("user_student");
    var obj_pw = document.getElementById("password");

    $("span[id*='_error']").html("");
    var text = "<b style='color:#ff214f'><?php echo getPhrase('please_fill_out_this_field');?></b>";

    if (obj_fn.value == '') {
        valid = false;
        obj_fn.focus();
        $("#first_name_error").html(text);

    } else if (obj_ln.value == '') {
        valid = false;
        obj_ln.focus();
        $("#last_name_error").html(text);
    } else if (obj_em.value == '') {
        valid = false;
        obj_em.focus();
        $("#email_result_student").html(text);
    } else if (obj_ph.value == '') {
        valid = false;
        obj_ph.focus();
        $("#phone_error").html(text);
    } else if (obj_ad.value == '') {
        valid = false;
        obj_ad.focus();
        $("#address_error").html(text);
    } else if (obj_un.value == '') {
        valid = false;
        obj_un.focus();
        $("#result_student").html(text);
    } else if (obj_pw.value == '') {
        valid = false;
        obj_pw.focus();
        $("#password_error").html(text);
    }

    if (valid) {
        document.getElementById('btnStepContent3').click();
    }

}

$('#ex-multiselect-limit').picker({
    limit: 2
});


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

function get_class_sections(class_id) {
    var year = document.getElementById("year_id").value;
    var semester_id = document.getElementById("semester_id").value;
    var program_type = $("#program_type_id option:selected").text().trim().toLowerCase();

    if (program_type.includes('saturdays')) {
        console.log(program_type);

        $.ajax({
            url: '<?= base_url();?>admin/get_class_section_saturdays/' + class_id + '/' + year + '/' +
                semester_id,
            success: function(response) {
                jQuery('#section_selector_holder').html(response);
            }
        });
    } else {
        $.ajax({
            url: '<?= base_url();?>admin/get_class_section_international/' + class_id + '/' + year + '/' +
                semester_id,
            success: function(response) {
                jQuery('#section_selector_holder').html(response);
            }
        });
    }


}

function get_class_section_subjects(section_id) {
    var year = document.getElementById("year_id").value;
    var semester = document.getElementById("semester_id").value;
    var class_id = document.getElementById("class_id").value;
    var modality_id = document.getElementById("modality_id").value;

    $.ajax({
        url: '<?= base_url();?>admin/get_class_section_subjects_modality/' + class_id + '/' + section_id + '/' +
            year + '/' + semester + '/' + modality_id,
        success: function(response) {
            jQuery('#subject_selector_holder').html(response).selectpicker('refresh');
        }
    });
}

function validate_form_class() {
    var subjects = $("#subject_selector_holder").val();
    var program_type = $("#program_type_id option:selected").text().trim();
    var program_type_id = document.getElementById("program_type_id").value;

    let length = subjects.length;

    var text = "";
    var valid = true;

    $("#class_error").html(text);

    if (program_type.includes("Full time") && (length > 2 || length < 2)) {
        text = "<b style='color:#ff214f'><?php echo getPhrase('please_select_2_class');?></b>";
        $("#class_error").html(text);
        valid = false;
    } else if (length > 1 && (!program_type.includes("Full time"))) {
        text = "<b style='color:#ff214f'><?php echo getPhrase('please_select_1_class');?></b>";
        $("#class_error").html(text);
        valid = false;
    } else if (length == 0) {
        text = "<b style='color:#ff214f'><?php echo getPhrase('please_select_a_class');?></b>";
        $("#class_error").html(text);
        valid = false;
    }

    if (valid) {
        get_tuition();
        document.getElementById('btnStepContent4').click();

    }
}

function get_tuition() {
    var program_type_id = document.getElementById("program_type_id").value;
    var _url = '<?= base_url();?>admin/get_cost_tuition/' + program_type_id;
    var cost = "";

    $.ajax({
        url: _url,
        success: function(response) {
            cost = response;
            document.getElementById("tuition").value = cost;

        }
    });
}

function add_fees() {
    let index       = 2
    var nro         = document.getElementById("number_payments").value;
    var tuition     = parseFloat(document.getElementById("tuition").value);
    var downPayment = parseFloat(document.getElementById("amount_1").value);
    var costs       = parseFloat(totalCost());
    var discounts   = parseFloat(totalDiscount());

    var total = tuition + costs;
    var quota = Math.round(tuition / parseInt(nro));    

    if (nro == 1) {
        document.getElementById('amount_1').value               = ((quota + costs) - discounts);
        document.getElementById('amount_1').min                 = ((quota + costs) - discounts);
        document.getElementById("payment_schedule").innerHTML   = "";
    } else {
        document.getElementById('amount_1').value               = (quota + costs);
        document.getElementById('amount_1').min                 = (quota + costs);
        document.getElementById("payment_schedule").innerHTML   = "";
    }

    if (nro > 1) {
        for (index; index <= nro; index++) {
            let html = '<div class="col col-lg-6 col-md-6 col-sm-12 col-12">'
            html += '    <div class="form-group label-floating">'
            html += '        <label class="control-label">'
            html += '            Payment ' + index
            html += '        </label>'
            html += '        <input class="form-control" name="amount_' + index + '"'
            html += '            id="amount_' + index + '" value="' + quota + '"type="text" required="" readonly >'
            html += '    </div>'
            html += '</div>'
            document.getElementById("payment_schedule").innerHTML += html;            
        }

        var last_index = parseInt(index) - 1;
        
        var total_quota = (quota * (last_index - 1)) + costs;
        var last_quota = ((total - total_quota) - discounts);
         
        var name = "amount_" + last_index;
        document.getElementById(name).value = last_quota;
    }

    validate_amount_1();

}


function add_fees_with_dow() {
    let index = 2
    var nro = document.getElementById("number_payments").value;
    var amount = parseFloat(document.getElementById("tuition").value);
    var downPayment = parseFloat(document.getElementById("amount_1").value);
    var costs = parseFloat(totalCost());
    var discounts = parseFloat(totalDiscount());

    var total = amount - (downPayment - costs);
    var quota = Math.round((total / (parseInt(nro) - 1)));

    // document.getElementById('amount_1').value = (quota + costs);
    document.getElementById("payment_schedule").innerHTML = "";

    if (nro > 1) {
        for (index; index <= nro; index++) {
            let html = '<div class="col col-lg-6 col-md-6 col-sm-12 col-12">'
            html += '    <div class="form-group label-floating">'
            html += '        <label class="control-label">'
            html += '            Payment ' + index
            html += '        </label>'
            html += '        <input class="form-control" name="amount_' + index + '"'
            html += '            id="amount_' + index + '" value="' + quota + '"type="text" required="" readonly >'
            html += '    </div>'
            html += '</div>'
            document.getElementById("payment_schedule").innerHTML += html;

        }

        var last_index = parseInt(index) - 1;

        var total_quota = Math.round(quota * (last_index - 2))
        var last_quota = Math.round((total - total_quota) - discounts)

        var name = "amount_" + last_index;
        document.getElementById(name).value = last_quota;
    }

}


function agreement_amount_total() {

    var tuition = parseFloat(document.getElementById("tuition").value);
    var total = ((tuition + totalCost()) - totalDiscount());

    var nro_payments = parseFloat(document.getElementById("number_payments").value);

    var amount_1 = (tuition / nro_payments) + (total - tuition);

    document.getElementById('total_agreement').value = total;
    document.getElementById('amount_1').value = amount_1;
    document.getElementById("amount_1").min = amount_1;

    add_fees();
}

function enable_down_payment() {
    var checked = document.getElementById("has_down_payment").checked;

    if (!checked) {
        document.getElementById("amount_1").readOnly = 'true';
        document.getElementById("create_payment_div").style.display = 'none';
        document.getElementById("btn_save").disabled = false;
    } else {
        document.getElementById("amount_1").removeAttribute('readOnly');
        document.getElementById("create_payment_div").style.display = 'block';
        document.getElementById("btn_save").disabled = true;
    }
}

function totalCost() {
    var arrCost = document.querySelectorAll('input[id^="cost_"]');
    var totalCost = 0.00;

    for (var i = 0; i < arrCost.length; i++) {
        if (parseFloat(arrCost[i].value))
            totalCost += parseFloat(arrCost[i].value);
    }

    return totalCost;
}

function totalDiscount() {
    var arrDiscount = document.querySelectorAll('input[id^="discount"]');
    var totalDiscount = 0.00;

    for (var i = 0; i < arrDiscount.length; i++) {
        if (parseFloat(arrDiscount[i].value))
            totalDiscount += parseFloat(arrDiscount[i].value);
    }

    return totalDiscount;
}


function automatic_payment_enable_fields() {
    var checked = document.getElementById("automatic_payment").checked;

    if (checked)
        document.getElementById("automatic_payment_div").style.display = 'flex';
    else
        document.getElementById("automatic_payment_div").style.display = 'none';
}

function validate_amount_1() {
    var checked = document.getElementById("has_down_payment").checked;

    if (checked) {
        var min = parseFloat(document.getElementById("amount_1").min);
        var amount = parseFloat(document.getElementById("amount_1").value);
        var error = "";

        if (amount < min) {
            error = "<b style='color:#ff214f'>The amount must be equal to or greater than " + min + " </b>";
            document.getElementById("btn_save").disabled = true;
        } else {
            console.log('disable ');
            document.getElementById("btn_save").disabled = false;
        }

        add_fees_with_dow();
        $("#amount_error").html(error);

        document.getElementById("totalAmount").innerText = (amount);

        payment_total();

        reset_total_payment();
    }
}

function payment_total() {
    var array = document.querySelectorAll('input[id^="payment_amount_"]');
    var total = 0.00;
    for (var i = 0; i < array.length; i++) {
        if (parseFloat(array[i].value)) {
            total += parseFloat(array[i].value);
        }

        if (array[i].id == 'payment_amount_2') {
            apply_card_fee();
        }
    }

    document.getElementById('total_payment').value = total;
    update_total();
}

function reset_total_payment() {
    var array = document.querySelectorAll('input[id^="payment_amount_"]');
    var total = 0.00;

    for (var i = 0; i < array.length; i++) {
        document.getElementById(array[i].id).value = '';
    }
}

function update_total() {
    var totalAmount = parseFloat(document.getElementById('amount_1').value);
    var totalDiscount = 0;
    var totalCardFee = parseFloat(document.getElementById('totalCardFee').innerText);
    var totalPayment = parseFloat(document.getElementById('total_payment').value);

    var totalToPay = (totalAmount + totalCardFee) - totalDiscount;
    var subtotal = totalAmount - totalDiscount;

    var remainingAmount = (totalPayment > 0 ? totalPayment : 0) - subtotal;

    document.getElementById('txtTotal').value = totalToPay;
    document.getElementById('total').innerText = totalToPay;

    if (remainingAmount > 0) {
        var txtRemainingAmount = "<b style='color:#ff214f'> Payment Exceeds </b>";
        document.getElementById('txtRemainingAmount').innerHTML = txtRemainingAmount;
    } else {
        document.getElementById('txtRemainingAmount').innerHTML = "";
    }

    document.getElementById('remainingAmount').innerText = remainingAmount;


    if (totalPayment == subtotal) {
        document.getElementById("btn_save").disabled = false;
        document.getElementById("payment_error").innerHTML = '';
    } else {
        document.getElementById("btn_save").disabled = true;
        document.getElementById("payment_error").innerHTML =
            "<b style='color:#ff214f'>Validate that \"Remaining to Pay\" is 00.00</b>";
    }

}

function apply_card_fee() {
    var amount = document.getElementById('payment_amount_2').value;
    var sel = document.getElementById("card_type_2");
    var text = sel.options[sel.selectedIndex].text;

    document.getElementById('card_fee').innerText = ""
    document.getElementById('total_fee').innerText = ""
    document.getElementById('totalCardFee').innerText = '00.00';

    if (text != 'Visa') {
        var total = ((parseFloat(amount) * 5) / 100);
        var totalFee = parseFloat(total) + parseFloat(amount);

        if (total > 0) {
            document.getElementById('totalCardFee').innerText = parseFloat(total).toFixed(2);
            var htmlFee = "<b style='color:#ff214f'> Card Fee : $" + parseFloat(total).toFixed(2) + "</b>";
            document.getElementById('card_fee').innerHTML = htmlFee;
            var htmlFee = "<b style='color:#ff214f'> Total Card : $" + parseFloat(totalFee).toFixed(2) + "</b>";
            document.getElementById('total_fee').innerHTML = htmlFee;
        }
    } else {
        document.getElementById('card_fee').innerText = ""
        document.getElementById('total_fee').innerText = ""
        document.getElementById('totalCardFee').innerText = '00.00';
    }

    update_total();
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