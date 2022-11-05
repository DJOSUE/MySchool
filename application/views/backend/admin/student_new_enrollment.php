<?php 
    $running_year = $this->crud->getInfo('running_year');
    $running_semester = $this->crud->getInfo('running_semester');

    $student_info = $this->db->get_where('student' , array('student_id' => $student_id))->result_array(); 

    $student_enroll = $this->db->get_where('enroll', array('student_id' => $student_id, 'year' => $running_year, 'semester_id' => $running_semester ))->result_array(); 

    $class_id = $student_enroll[0]['class_id'];
    $section_id = $student_enroll[0]['section_id'];

    foreach($student_info as $row): 
        $status_info = $this->studentModel->get_status_info($row['student_session']);
        $program_info = $this->studentModel->get_program_info($row['program_id']);
?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="content-i">
        <div class="content-box">
            <div class="conty">
                <div class="back" style="margin-top:-20px;margin-bottom:10px">
                    <a title="<?= getPhrase('return');?>" href="<?= base_url();?>admin/students/"><i
                            class="picons-thin-icon-thin-0131_arrow_back_undo"></i></a>
                </div>
                <div class="row">
                    <main class="col col-xl-9 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
                        <div id="newsfeed-items-grid">
                            <div class="ui-block paddingtel">
                                <div class="user-profile">
                                    <?php include 'student_area_header.php';?>
                                </div>
                            </div>
                        </div>
                        <!-- add enrollments -->
                        <div>
                            <div class="ui-block">
                                <div class="ui-block-title">
                                    <div class="col-sm-2">
                                        <h6 class="title"><?= getPhrase('new_enrollment');?></h6>
                                    </div>
                                </div>
                                <div class="ui-block-content">
                                    <div class="steps-w">
                                        <div class="step-triggers">
                                            <a class="step-trigger active"
                                                href="#stepContent1"><?= getPhrase('personal_info');?></a>
                                            <a class="step-trigger"
                                                href="#stepContent2"><?= getPhrase('class_info');?></a>
                                            <a class="step-trigger"
                                                href="#stepContent3"><?= getPhrase('payment_info');?></a>
                                        </div>
                                        <div class="step-contents">
                                            <div class="step-content active" id="stepContent1" name="personal_info">
                                                <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                    <div class="description-toggle">
                                                        <div class="description-toggle-content">
                                                            <div class="h6"><?= getPhrase('update_info');?>
                                                            </div>
                                                        </div>
                                                        <div class="togglebutton">
                                                            <label>
                                                                <input id="update_info" value="1" type="checkbox"
                                                                    onchange="update_info()">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label"><?= getPhrase('first_name');?>
                                                            </label>
                                                            <input class="form-control" name="first_name"
                                                                id="first_name" value="<?= $row['first_name'];?>"
                                                                type="text" required="" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label"><?= getPhrase('last_name');?>
                                                            </label>
                                                            <input class="form-control" name="last_name" id="last_name"
                                                                value="<?= $row['last_name'];?>" type="text" required=""
                                                                disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group date-time-picker label-floating">
                                                            <label class="control-label"><?= getPhrase('birthday');?>
                                                            </label>
                                                            <input type='text' class="datepicker-here"
                                                                data-position="top left" data-language='en'
                                                                name="datetimepicker" id="datetimepicker"
                                                                data-multiple-dates-separator="/" disabled
                                                                value="<?= $row['birthday'];?>" />
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating is-select">
                                                            <label class="control-label"><?= getPhrase('gender');?>
                                                            </label>
                                                            <div class="select">
                                                                <select name="gender" id="gender" required="" disabled>
                                                                    <option value=""><?= getPhrase('select');?>
                                                                    </option>
                                                                    <?php
                                                                    $genders = $this->db->get('gender')->result_array();
                                                                    foreach($genders as $gender):
                                                                    ?>
                                                                    <option value="<?= $gender['code']?>"
                                                                        <?= $gender['code'] == $row['sex'] ? 'selected': ''; ?>>
                                                                        <?= $gender['name']?></option>
                                                                    <?php endforeach;?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating is-select">
                                                            <label
                                                                class="control-label"><?= getPhrase('country_of_birth');?>
                                                            </label>
                                                            <div class="select">
                                                                <select name="country_id" id="country_id" required=""
                                                                    disabled>
                                                                    <option value=""><?= getPhrase('select');?>
                                                                    </option>
                                                                    <?php
                                                                    $countries = $this->db->get('countries')->result_array();
                                                                    foreach($countries as $country):
                                                                    ?>
                                                                    <option value="<?= $country['country_id']?>"
                                                                        <?= $country['country_id'] == $row['country_id'] ? 'selected': ''; ?>>
                                                                        <?= $country['name']?></option>
                                                                    <?php endforeach;?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label"><?= getPhrase('email');?>
                                                            </label>
                                                            <input class="form-control" name="email" id="email_address"
                                                                type="email" value="<?= $row['email'];?>" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label"><?= getPhrase('phone');?>
                                                            </label>
                                                            <input class="form-control" name="phone" id="phone"
                                                                type="text" value="<?= $row['phone'];?>" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label"><?= getPhrase('address');?>
                                                            </label>
                                                            <input class="form-control" name="address" id="address"
                                                                value="<?= $row['address'];?>" type="text" disabled>
                                                        </div>
                                                    </div>

                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating">
                                                            <label
                                                                class="control-label"><?= getPhrase('username');?></label>
                                                            <input class="form-control" name="username" id="username"
                                                                type="text" value="<?= $row['username'];?>"
                                                                autocomplete="false" required="" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating">
                                                            <label
                                                                class="control-label"><?= getPhrase('update_password');?></label>
                                                            <input class="form-control" name="password" id="password"
                                                                type="password" disabled>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="form-buttons-w text-right">
                                                    <a class="btn btn-rounded btn-success btn-lg step-trigger-btn"
                                                        href="#stepContent2">
                                                        <?= getPhrase('next');?>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="step-content" id="stepContent2">
                                                <div class="row">
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating is-select">
                                                            <label
                                                                class="control-label"><?= getPhrase('program_type');?>
                                                            </label>
                                                            <div class="select">
                                                                <select name="program_type_id" id="program_type_id"
                                                                    required="">
                                                                    <option value=""><?= getPhrase('select');?>
                                                                    </option>
                                                                    <?php 
                                                                        $programs = $this->studentModel->get_program_type();
                                                                        foreach($programs as $item):
                                                                    ?>
                                                                    <option value="<?= $item['program_type_id']; ?>">
                                                                        <?= $item['name']; ?>
                                                                    </option>
                                                                    <?php endforeach?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating is-select">
                                                            <label class="control-label"><?= getPhrase('modality');?>
                                                            </label>
                                                            <div class="select">
                                                                <select name="modality_id" id="modality_id" required="">
                                                                    <option value=""><?= getPhrase('select');?>
                                                                    </option>
                                                                    <?php 
                                                                        $modalities = $this->studentModel->get_modality();
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
                                                                    <option value="Online"><?= getPhrase('Online');?>
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
                                                                <select name="year_id" id="year_id" required="">
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
                                                                <select name="semester_id" id="semester_id" required="">
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
                                                                <select name="section_id" id="section_selector_holder"
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
                                                                <select name="subject_id[]" id="subject_selector_holder"
                                                                    multiple class="selectpicker form-control" title="">
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-buttons-w text-right">
                                                    <a class="btn btn-rounded btn-success btn-lg step-trigger-btn"
                                                        href="#stepContent3">
                                                        <?= getPhrase('next');?>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="step-content" id="stepContent3">
                                                <div class="row">
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">
                                                                <?= getPhrase('cost_tuition');?>
                                                            </label>
                                                            <input class="form-control" name="cost_tuition"
                                                                id="cost_tuition" type="text" required="" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">
                                                                <?= getPhrase('scholarship');?>
                                                            </label>
                                                            <input class="form-control" name="scholarship"
                                                                id="scholarship" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">
                                                                <?= getPhrase('discount');?>
                                                            </label>
                                                            <input class="form-control" name="discount" id="discount"
                                                                type="text">
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">
                                                                <?= getPhrase('books_fee');?>
                                                            </label>
                                                            <input class="form-control" name="books_fee" id="books_fee"
                                                                value="75" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">
                                                                <?= getPhrase('total_payment');?>
                                                            </label>
                                                            <input class="form-control" name="cost_tuition"
                                                                id="cost_tuition" type="text" required="" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr />
                                                <div class="row">
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
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">
                                                                Payment 1
                                                            </label>
                                                            <input class="form-control" name="amount_1" id="amount_1"
                                                                type="text" required="" value="0" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">
                                                                <?= getPhrase('date_1');?>
                                                            </label>
                                                            <input class="datepicker-here" name="date_1" id="date_1"
                                                                data-position="bottom left" data-language='en'
                                                                type="text" required="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" id="payment_schedule">

                                                </div>
                                                <hr />
                                                <div class="row">
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="description-toggle">
                                                            <div class="description-toggle-content">
                                                                <div class="h6"><?= getPhrase('automatic_payment');?>
                                                                </div>
                                                            </div>
                                                            <div class="togglebutton">
                                                                <label>
                                                                    <input id="automatic_payment" value="1"
                                                                        type="checkbox" onchange="automatic_payment()">
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" id="automatic_payment_div" style="display: none;">
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating is-select">
                                                            <label class="control-label"><?= getPhrase('type_card');?>
                                                            </label>
                                                            <div class="select">
                                                                <select name="type_card_id" id="type_card_id"
                                                                    required="">
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
                                                            <label class="control-label"><?= getPhrase('card_holder');?>
                                                            </label>
                                                            <input class="form-control" name="card_holder"
                                                                id="card_holder" type="text" required="">
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label"><?= getPhrase('card_number');?>
                                                            </label>
                                                            <input class="form-control" name="card_number"
                                                                id="card_number" type="text" required="" minlength="10"
                                                                maxlength="19">
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating">
                                                            <label
                                                                class="control-label"><?= getPhrase('security_code');?>
                                                            </label>
                                                            <input class="form-control" name="security_code"
                                                                id="security_code" type="text" required="" minlength="3"
                                                                maxlength="4">
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label"><?= getPhrase('expiration_date');?>
                                                            </label>
                                                            <input class="form-control" name="expiration_date"
                                                                id="expiration_date" type="text" required="">
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label"><?= getPhrase('zip_code');?>
                                                            </label>
                                                            <input class="form-control" name="zip_code"
                                                                id="zip_code" type="text" required="" minlength="5">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-buttons-w text-right">
                                                    <button class="btn btn-rounded btn-success" type="submit">
                                                    <?= getPhrase('save');?>
                                                </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </main>
                    <?php include 'student_area_menu.php';?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach;?>



<script type="text/javascript">
function update_info() {
    var checked = document.getElementById("update_info").checked;

    document.getElementById("first_name").disabled = !checked;
    document.getElementById("last_name").disabled = !checked;
    document.getElementById("datetimepicker").disabled = !checked;
    document.getElementById("gender").disabled = !checked;
    document.getElementById("country_id").disabled = !checked;
    document.getElementById("phone").disabled = !checked;
    document.getElementById("address").disabled = !checked;
    document.getElementById("password").disabled = !checked;
    document.getElementById("email_address").disabled = !checked;

}

function get_price() {

}

function add_fees() {
    var nro = document.getElementById("number_payments").value;
    document.getElementById("payment_schedule").innerHTML = "";

    if (nro > 1) {
        document.getElementById("payment_schedule").innerHTML = "";
        for (let index = 2; index <= nro; index++) {
            let html = '<div class="col col-lg-6 col-md-6 col-sm-12 col-12">'
            html += '    <div class="form-group label-floating">'
            html += '        <label class="control-label">'
            html += '            Payment ' + index
            html += '        </label>'
            html += '        <input class="form-control" name="amount_' + index + '"'
            html += '            id="amount_' + index + '" type="text" required="" disabled>'
            html += '    </div>'
            html += '</div>'
            html += '<div class="col col-lg-6 col-md-6 col-sm-12 col-12">'
            html += '    <div class="form-group label-floating">'
            html += '        <label class="control-label">'
            html += '            Date ' + index
            html += '        </label>'
            html += '        <input class="datepicker-here" name="date_' + index + '" id="date_' + index + '"'
            html += '            data-position="bottom left" data-language="en"'
            html += '            type="text" required="" disabled>'
            html += '    </div>'
            html += '</div>'
            document.getElementById("payment_schedule").innerHTML += html;
        }
    }
}

function automatic_payment(){
    var checked = document.getElementById("automatic_payment").checked;

    if(checked)
        document.getElementById("automatic_payment_div").style.display = 'flex';
    else
        document.getElementById("automatic_payment_div").style.display = 'none';
}

function create_agreement() {
    document.getElementById("create_agreement_div").style.display = 'block';
}

function get_class_sections(class_id) {
    var year = document.getElementById("year_id").value;
    var semester_id = document.getElementById("semester_id").value;

    $.ajax({
        url: '<?= base_url();?>admin/get_class_section/' + class_id + '/' + year + '/' + semester_id,
        success: function(response) {
            jQuery('#section_selector_holder').html(response);
        }
    });
}

function get_class_section_subjects(section_id) {
    var year = document.getElementById("year_id").value;
    var semester = document.getElementById("semester_id").value;
    var class_id = document.getElementById("class_id").value;

    $.ajax({
        url: '<?= base_url();?>admin/get_class_section_subjects/' + class_id + '/' + section_id + '/' +
            year + '/' + semester,
        success: function(response) {
            jQuery('#subject_selector_holder').html(response).selectpicker('refresh');
        }
    });
}

function save() {
    var subjects = $("#subject_selector_holder").val();
    var _subjects = btoa(subjects);
    console.log(_subjects);
    window.location.href = '<?= base_url();?>admin/save_student_enrollment/' + _subjects;
}

function confirm_delete(enroll_id) {

    var student_id = document.getElementById("student_id").value;

    Swal.fire({
        title: "<?= getPhrase('confirm_delete');?>",
        text: "<?= getPhrase('message_delete');?>",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "<?= getPhrase('delete');?>"
    }).then((result) => {
        if (result.isConfirmed) {
            location.href = '<?= base_url();?>admin/delete_student_enrollment/' + enroll_id + '/' +
                student_id;
        }
    })
}
</script>