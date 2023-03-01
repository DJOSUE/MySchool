<?php $running_year = $this->crud->getInfo('running_year');?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <?php include 'admission__nav.php';?>
        </div><br>
        <div class="content-i">
            <div class="content-box">
                <div class="col-sm-12">
                    <div class="element-box shadow">
                        <div class="steps-w">
                            <div class="os-tabs-w">
                                <div class="os-tabs-controls">
                                    <ul class="navs navs-tabs upper centered">
                                        <li class="navs-item">
                                            <a class="navs-links active text-center" data-toggle="tab" href="#new">
                                                <i class="picons-thin-icon-thin-0151_plus_add_new"></i>
                                                <span><?php echo getPhrase('new');?></span>
                                            </a>
                                        </li>
                                        <li class="navs-item">
                                            <a class="navs-links text-center" data-toggle="tab" href="#import">
                                                <i class="picons-thin-icon-thin-0086_import_file_load"></i>
                                                <span><?php echo getPhrase('import');?></span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane active" id="new">
                                    <div class="row">
                                        <?php echo form_open(base_url() . 'admin/applicant/register/' , array('enctype' => 'multipart/form-data', 'autocomplete' => 'off'));?>
                                        <div class="row">
                                            <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group label-floating is-select">
                                                    <label class="control-label"><?php echo getPhrase('type');?></label>
                                                    <div class="select">
                                                        <select name="type_id" id="type_id" required="">
                                                            <option value="">
                                                                <?php echo getPhrase('select');?></option>
                                                            <?php $applicant_types = $this->db->get('v_applicant_type')->result_array();
        	                  										foreach($applicant_types as $type):
               											        ?>
                                                            <option value="<?php echo $type['type_id'];?>">
                                                                <?php echo $type['name'];?></option>
                                                            <?php endforeach;?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>                                            
                                            <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group label-floating is-select">
                                                    <label
                                                        class="control-label"><?php echo getPhrase('agent');?></label>
                                                    <div class="select">
                                                        <select name="agent_code" id="agent_code">
                                                            <option value="">
                                                                <?php echo getPhrase('select');?></option>
                                                            <?php $agents = $this->applicant->get_agent_list();
        	                  										foreach($agents as $agent):
               											        ?>
                                                            <option value="<?php echo $agent['agent_code'];?>">
                                                                <?php echo $agent['name'];?></option>
                                                            <?php endforeach;?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group label-floating">
                                                    <label
                                                        class="control-label"><?php echo getPhrase('first_name');?></label>
                                                    <input class="form-control" name="first_name" type="text"
                                                        required="">
                                                </div>
                                            </div>
                                            <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group label-floating">
                                                    <label
                                                        class="control-label"><?php echo getPhrase('last_name');?></label>
                                                    <input class="form-control" name="last_name" type="text"
                                                        required="">
                                                </div>
                                            </div>
                                            <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group date-time-picker label-floating">
                                                    <label
                                                        class="control-label"><?php echo getPhrase('birthday');?></label>
                                                    <input type='text' class="datepicker-here"
                                                        data-position="bottom left" data-language='en'
                                                        name="datetimepicker" data-multiple-dates-separator="/" />
                                                </div>
                                            </div>
                                            <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group label-floating">
                                                    <label
                                                        class="control-label"><?php echo getPhrase('email');?></label>
                                                    <input class="form-control" name="email" id="applicant_email"
                                                        type="email">
                                                    <small><span id="applicant_email_result"></span></small>
                                                </div>
                                            </div>
                                            <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group label-floating">
                                                    <label
                                                        class="control-label"><?php echo getPhrase('phone');?></label>
                                                    <input class="form-control" name="phone" type="text" required="">
                                                </div>
                                            </div>
                                            <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group label-floating is-select">
                                                    <label
                                                        class="control-label"><?php echo getPhrase('gender');?></label>
                                                    <div class="select">
                                                        <select name="gender">
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
                                                        class="control-label"><?php echo getPhrase('address');?></label>
                                                    <input class="form-control" name="address" type="text">
                                                </div>
                                            </div>
                                            <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group label-floating is-select">
                                                    <label
                                                        class="control-label"><?php echo getPhrase('country_of_birth');?></label>
                                                    <div class="select">
                                                        <select name="country_id" id="country_id">
                                                            <option value="">
                                                                <?php echo getPhrase('select');?></option>
                                                            <?php $countries = $this->db->get('countries')->result_array();
                                                              foreach($countries as $country):
                                                        ?>
                                                            <option value="<?php echo $country['country_id'];?>">
                                                                <?php echo $country['name'];?></option>
                                                            <?php endforeach;?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group  label-floating is-select">
                                                    <label
                                                        class="control-label"><?php echo getPhrase('student_referral');?></label>
                                                    <div class="">
                                                        <select class="selectpicker form-control"
                                                            data-live-search="true" name="referral_by">
                                                            <option value="">
                                                                <?php echo getPhrase('select');?></option>
                                                            <?php $students = $this->db->get_where('student',array('status <>' => '0'))->result_array();
        	                  										foreach($students as $student):
               											        ?>
                                                            <option value="<?php echo $student['student_id'];?>">
                                                                <?php echo $student['first_name'] . ' ' . $student['last_name'];?>
                                                            </option>
                                                            <?php endforeach;?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col col-lg-6 col-md-6 col-sm-12 col-12">                                                
                                            </div>
                                            <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group date-time-picker label-floating">
                                                    <label
                                                        class="control-label"><?php echo getPhrase('future_contact_date');?></label>
                                                    <input type='text' class="datepicker-here"
                                                        data-position="bottom left" data-language='en'
                                                        name="contact_date" id="contact_date"
                                                        onfocusout="enable_description()" />
                                                </div>
                                            </div>
                                            <div id="div_comments" class="col col-lg-6 col-md-6 col-sm-12 col-12"
                                                style="display: none;">
                                                <div class="form-group label-floating">
                                                    <label
                                                        class="control-label"><?php echo getPhrase('comments');?></label>
                                                    <textarea name="comments" cols="40" rows="5"></textarea>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="form-buttons-w text-right">
                                            <button class="btn btn-rounded btn-success btn-lg" type="submit"
                                                id="sub_form"><?php echo getPhrase('register');?></button>
                                        </div>
                                        <?php echo form_close();?>
                                    </div>
                                </div>
                                <div class="tab-pane" id="import">
                                    <div class="row">
                                        <div class="row">
                                            <div class="col-sm-8 bd-white">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">
                                                        <?php echo getPhrase('full_name');?>
                                                    </label>
                                                    <input class="form-control" name="name" id="name" type="text"
                                                        onkeypress="return enterKeyPressed(event)">
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <button class="btn btn-success btn-upper" style="margin-top:20px"
                                                        onclick="get_list()">
                                                        <span><?php echo getPhrase('search');?></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="search_result">

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


<script>
$(document).ready(function() {
    var query;
    $("#applicant_email").keyup(function(e) {
        query = $("#applicant_email").val();
        $("#applicant_email_result").queue(function(n) {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>tools/check_duplication/applicant/email',
                data: "value=" + query,
                dataType: "html",
                error: function() {
                    alert("¡Error!");
                },
                success: function(data) {
                    console.log('return: ' + data);
                    if (data == "success") {
                        texto =
                            "<b style='color:#ff214f'><?php echo getPhrase('email_already_exist');?></b>";
                        $("#applicant_email_result").html(texto);
                        $('#sub_form').attr('disabled', 'disabled');
                    } else {
                        texto = "";
                        $("#applicant_email_result").html(texto);
                        $('#sub_form').removeAttr('disabled');
                    }
                    n();
                }
            });
        });
    });
});

function get_list() {
    let text = document.getElementById("name").value;
    const loading = '<img src="<?= '/'.PATH_PUBLIC_ASSETS_IMAGES_FILES.'loader-1.gif';?>" />'
    $.ajax({
        url: '<?php echo base_url();?>admin/admission_search/' + text,
        beforeSend: function() {
            jQuery('#search_result').html(loading);
        },
        success: function(response) {
            jQuery('#search_result').html(response);
        }
    });
}

function enterKeyPressed(event) {
    if (event.keyCode == 13) {
        get_list();
        return false;
    } else {
        return true;
    }
}

function enable_description() {
    var date = document.getElementById("contact_date").value;

    console.log('date', date);

    if (date != '') {
        document.getElementById("div_comments").style.display = 'block';
    } else {
        document.getElementById("div_comments").style.display = 'none';

    }
}
</script>