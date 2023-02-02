<?php 
    $student_info = $this->db->get_where('student' , array('student_id' => $student_id))->result_array(); 
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
                            <div class="ui-block">
                                <div class="ui-block-title">
                                    <h6 class="title"><?= getPhrase('update_information');?></h6>
                                </div>
                                <?= form_open(base_url() . 'admin/student/do_update/'.$row['student_id'] , array('enctype' => 'multipart/form-data'));?>
                                <div class="ui-block-content">
                                    <div class="row">
                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label"><?= getPhrase('first_name');?></label>
                                                <input class="form-control" name="first_name"
                                                    value="<?= $row['first_name'];?>" type="text" required="">
                                            </div>
                                        </div>
                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label"><?= getPhrase('last_name');?></label>
                                                <input class="form-control" name="last_name"
                                                    value="<?= $row['last_name'];?>" type="text" required="">
                                            </div>
                                        </div>
                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group date-time-picker label-floating">
                                                <label class="control-label"><?= getPhrase('birthday');?></label>
                                                <input type='text' class="datepicker-here" data-position="top left"
                                                    data-language='en' name="datetimepicker"
                                                    data-multiple-dates-separator="/" value="<?= $row['birthday'];?>" />
                                            </div>
                                        </div>
                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label"><?= getPhrase('email');?></label>
                                                <input class="form-control" name="email" value="<?= $row['email'];?>"
                                                    type="email">
                                            </div>
                                        </div>
                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label"><?= getPhrase('phone');?></label>
                                                <input class="form-control" name="phone" value="<?= $row['phone'];?>"
                                                    type="text">
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
                                                    class="control-label"><?= getPhrase('country_of_birth');?></label>
                                                <div class="select">
                                                    <select name="country_id" required="">
                                                        <option value=""><?= getPhrase('select');?></option>
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
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?= getPhrase('status');?></label>
                                                <div class="select">
                                                    <select name="student_session" required="">
                                                        <option value=""><?= getPhrase('select');?></option>

                                                        <?php $status = $this->db->get('v_student_status')->result_array();
                                                            foreach($status as $item):
                                                        ?>
                                                        <option value="<?=$item['status_id']?>"
                                                            <?php if($row['student_session'] == $item['status_id']) echo "selected";?>>
                                                            <?= $item['name'];?>
                                                        </option>
                                                        <? endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label"><?= getPhrase('username');?></label>
                                                <input class="form-control" name="username"
                                                    value="<?= $row['username'];?>" autocomplete="false" required=""
                                                    type="text">
                                            </div>
                                        </div>
                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label"><?= getPhrase('update_password');?></label>
                                                <input class="form-control" name="password" type="password">
                                            </div>
                                        </div>
                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label"><?= getPhrase('address');?></label>
                                                <input class="form-control" name="address"
                                                    value="<?= $row['address'];?>" type="text">
                                            </div>
                                        </div>
                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label"><?= getPhrase('roll');?></label>
                                                <input class="form-control" name="student_code"
                                                    value="<?= $row['student_code'];?>" type="text">
                                            </div>
                                        </div>
                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label"><?= getPhrase('sevis');?></label>
                                                <input class="form-control" name="sevis_number"
                                                    value="<?= $row['sevis_number'];?>" type="text">
                                            </div>
                                        </div>
                                        <!-- <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?= getPhrase('parent');?></label>
                                                <div class="select">
                                                    <select name="parent_id">
                                                        <option value=""><?= getPhrase('select');?></option>
                                                        <?php 
                                                                    $parents = $this->db->get('parent')->result_array();
                                                                    foreach($parents as $parent):
                                                                ?>
                                                        <option value="<?= $parent['parent_id'];?>"
                                                            <?php if($parent['parent_id'] == $row['parent_id']) echo "selected";?>>
                                                            <?= $this->crud->get_name('parent', $parent['parent_id']);?>
                                                        </option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div> -->
                                        <!-- <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group label-floating is-select">
                                                <label
                                                    class="control-label"><?= getPhrase('transport');?></label>
                                                <div class="select">
                                                    <select name="transport_id">
                                                        <option value=""><?= getPhrase('select');?></option>
                                                        <?php 
                                                                    $bus = $this->db->get('transport')->result_array();
                                                                    foreach($bus as $trans):
                                                                ?>
                                                        <option value="<?= $trans['transport_id'];?>"
                                                            <?php if($row['transport_id'] == $trans['transport_id']) echo "selected";?>>
                                                            <?= $trans['route_name'];?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?= getPhrase('program');?></label>
                                                <div class="select">
                                                    <select name="program_id">
                                                        <option value=""><?= getPhrase('select');?></option>
                                                        <?php 
                                                            $programs = $this->db->get('program')->result_array();
                                                            foreach($programs as $program):
                                                        ?>
                                                        <option value="<?= $program['program_id'];?>"
                                                            <?php if($program_info['program_id'] == $program['program_id']) echo "selected";?>>
                                                            <?= $program['name'];?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group label-floating">
                                                <label
                                                    class="control-label"><?= getPhrase('conditions_or_diseases');?></label>
                                                <input class="form-control" name="diseases" type="text"
                                                    value="<?= $row['diseases'];?>">
                                            </div>
                                        </div>
                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label"><?= getPhrase('allergies');?></label>
                                                <input class="form-control" name="allergies" type="text"
                                                    value="<?= $row['allergies'];?>">
                                            </div>
                                        </div>
                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label"><?= getPhrase('personal_doctor');?></label>
                                                <input class="form-control" name="doctor" type="text"
                                                    value="<?= $row['doctor'];?>">
                                            </div>
                                        </div>
                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label"><?= getPhrase('doctor_phone');?>.</label>
                                                <input class="form-control" name="doctor_phone" type="text"
                                                    value="<?= $row['doctor_phone'];?>">
                                            </div>
                                        </div>
                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group label-floating">
                                                <label
                                                    class="control-label"><?= getPhrase('authorized_person');?></label>
                                                <input class="form-control" name="auth_person" type="text"
                                                    value="<?= $row['authorized_person'];?>">
                                            </div>
                                        </div>
                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group label-floating">
                                                <label
                                                    class="control-label"><?= getPhrase('authorized_person_phone');?></label>
                                                <input class="form-control" name="auth_phone" type="text"
                                                    value="<?= $row['authorized_phone'];?>">
                                            </div>
                                        </div>
                                        <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label"><?= getPhrase('notes');?>:</label>
                                                <textarea class="form-control"
                                                    name="note"><?= $row['note'];?></textarea>
                                            </div>
                                        </div>
                                        <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label class="control-label"><?= getPhrase('photo');?></label>
                                                <input class="form-control" placeholder="" name="userfile" type="file">
                                            </div>
                                        </div>
                                        <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-buttons-w">
                                                <button class="btn btn-rounded btn-success" type="submit">
                                                    <?= getPhrase('update');?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?= form_close();?>
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