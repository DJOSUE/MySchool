<?php 

    $token = generate_token();
    $url_app = ADMISSION_PLATFORM_URL.'student_info?auth_token='.$token.'&user_email='.$email;

    $ch_app = curl_init($url_app);
    curl_setopt($ch_app, CURLOPT_HTTPGET, true);
    curl_setopt($ch_app, CURLOPT_RETURNTRANSFER, true);
    $response_json_app = curl_exec($ch_app);
    curl_close($ch_app);
    $response_app = json_decode($response_json_app, true);

    

    if($response_app['status'] == 'success')
    {
        $user_details = $response_app['user_info'];

        $user_application = $response_app['user_application'];
        
        $application = $user_application['application'];
        // $application_process = $user_application['application_process'];
        // $application_documents = $user_application['application_documents'];
        // $application_error = $user_application['error'];
    }  

    // echo '<pre>';
    // var_dump($application);
    // // var_dump($response_app);
    // echo '</pre>';

    // $user_details = $this->db->get_where('users', array(
    //     'id' => $user_id ,
    //     'status' => 1
    // ))->row();

    // $user_application = $this->db->get_where('applications', array(
    //     'id' => $application_id,
    //     'user_id' => $user_id
    // ))->row();    

    $spouse_info = json_decode($application['spouse_info'], true);

    $children_info = json_decode($application['children_info'], true);


    // echo '<pre>';
    // var_dump($application);
    // // var_dump($response_app);
    // echo '</pre>';
    
?>
<html>
    <head>
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet" type="text/css">
    <link href="<?= base_url();?>public/style/cms/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url();?>public/style/cms/css/main.css?version=3.3" rel="stylesheet">

        <style>
            * {
                -webkit-print-color-adjust: exact !important;   /* Chrome, Safari */
                color-adjust: exact !important;                 /* Firefox */
            }
            label{
                margin-bottom: 0.1rem !important;
            }
            section{
                margin-top: 1em;
            }
            hr{
                margin-top: 0.25em;
                margin-bottom: 0.25em;
            }
            .form-control{
                padding: 0.1rem 0.1rem;
            }
            .mb-3{
                margin-bottom: 0.1rem !important;
            }
            
        </style>
    </head>
    <body>
        <div class="content-w">
            <div class="content-i">
                <div class="content-box">
                    <div class="element-wrapper">
                        <div class="rcard-wy" id="print_area">
                            <div class="rcard-w">
                                <div class="infos">
                                    <div class="info-1">
                                        <div class="rcard-logo-w">
                                            <img alt="" src="https://admission.americanone-esl.com/uploads/system/1f88c7c5d7d94ae08bd752aa3d82108b.png">
                                        </div>
                                        <div class="company-name"><?= getPhrase('application_for_admission');?></div>                                        
                                    </div>
                                    <div class="info-2">
                                        <div class="rcard-profile">
                                            <img alt="" src="<?php //echo $this->user_model->get_user_image_url($user_id); ?>">
                                        </div>                                        
                                    </div>
                                </div>
                                <div class="">                                    
                                    <section id="personal_information">
                                        <h5 class="mb-3 header-title"><?php echo getPhrase('personal_information'); ?></h5>
                                        <hr />
                                        <div class="row">
                                            <div class="col">
                                                <label for="last_name"><?= getPhrase('1st_last_name');?></label>
                                                <input type="text" class="form-control" id="last_name" name="last_name"
                                                    value="<?= $application['last_name'];?>" disabled>
                                            </div>
                                            <div class="col">
                                                <label for="maternal_last_name"><?= getPhrase('2nd_last_name');?></label>
                                                <input type="text" class="form-control" id="maternal_last_name" name="maternal_last_name"
                                                    value="<?= $application['maternal_last_name'];?>" disabled>
                                            </div>
                                            <div class="col">
                                                <label for="first_name"><?= getPhrase('first_name');?></label>
                                                <input type="text" class="form-control" id="first_name" name="first_name"
                                                    value="<?= $application['first_name'];?>" disabled>
                                            </div>
                                            <div class="col">
                                                <label for="middle_name"><?= getPhrase('middle_name');?></label>
                                                <input type="text" class="form-control" id="middle_name" name="middle_name"
                                                    value="<?= $application['middle_name'];?>" disabled>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <label for="city_birth"><?= getPhrase('city_birth');?></label>
                                                <input type="text" class="form-control" id="city_birth" name="city_birth"
                                                    value="<?= $application['city_birth'];?>" disabled>
                                            </div>
                                            <div class="col">
                                                <label for="country_birth"><?= getPhrase('country_birth');?></label>
                                                <input type="text" class="form-control" id="country_birth" name="country_birth"
                                                    value="<?= $application['country_birth'];?>" disabled>
                                            </div>
                                            <div class="col">
                                                <label for="country_citizenship"><?= getPhrase('country_citizenship');?></label>
                                                <input type="text" class="form-control" id="country_citizenship" name="country_citizenship"
                                                    value="<?= $application['country_citizenship'];?>" disabled>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <label for="birthdate"><?= getPhrase('birthdate');?></label>
                                                <input type="date" class="form-control" id="birthdate" name="birthdate"
                                                    value="<?= $application['birthdate'];?>" disabled>
                                            </div>
                                            <div class="col">
                                                <label for="gender"><?= getPhrase('gender');?></label>
                                                <input type="text" class="form-control" id="gender" name="gender"
                                                    value="<?= $application['gender'];?>" disabled>
                                            </div>
                                        </div>
                                    </section>
                                    <section id="address_information">
                                        <h5 class=" "><?php echo getPhrase('address_information'); ?></h5>
                                        <hr />
                                        <section id="us_address">
                                            <h6 style="font-weight: bold;"><?=getPhrase('us_address');?></h6>
                                            <div class="row">
                                                <div class="col">
                                                    <label for="us_street_address"><?=getPhrase('street_address')?></label>
                                                    <input type="text" class="form-control" id="us_street_address" name="us_street_address"
                                                        value="<?= $application['us_street_address']?>" disabled>
                                                </div>
                                                <div class="col">
                                                    <label for="us_city_address"><?=getPhrase('city')?></label>
                                                    <input type="text" class="form-control" id="us_city_address" name="us_city_address"
                                                        value="<?= $application['us_city_address']; ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="row">  
                                                <div class="col">
                                                    <label for="us_state_address"><?=getPhrase('state')?></label>
                                                    <input type="text" class="form-control" id="us_state_address" name="us_state_address"
                                                        value="<?= $application['us_state_address']?>" disabled>
                                                </div>
                                                <div class="col">
                                                    <label for="us_zipcode_address"><?=getPhrase('zip_code')?></label>
                                                    <input type="text" class="form-control" id="us_zipcode_address" name="us_zipcode_address"
                                                        value="<?=$application['us_zipcode_address']?>" disabled>
                                                </div>
                                            </div>
                                        </section>                                        
                                        <section id="foreign_address">
                                            <h6 style="font-weight: bold;"><?=getPhrase('foreign_address');?></h6>
                                            <div class="row">
                                                <div class="col">
                                                    <label for="foreign_street_address"><?=getPhrase('street_address')?></label>
                                                    <input type="text" class="form-control" id="foreign_street_address" name="foreign_street_address"
                                                        value="<?=$application['foreign_street_address']?>" disabled>
                                                </div>
                                                <div class="col">
                                                    <label for="foreign_city_address"><?=getPhrase('city')?></label>
                                                    <input type="text" class="form-control" id="foreign_city_address" name="foreign_city_address"
                                                        value="<?=$application['foreign_city_address']?>" disabled>
                                                </div>
                                            </div>
                                            <div class="row">                                                  
                                                <div class="col">
                                                    <label for="foreign_state_address"><?=getPhrase('state')?></label>
                                                    <input type="text" class="form-control" id="foreign_state_address" name="foreign_state_address"
                                                        value="<?=$application['foreign_state_address']?>" disabled>
                                                </div>
                                                <div class="col">
                                                    <label for="foreign_zipcode_address"><?=getPhrase('zip_code')?></label>
                                                    <input type="text" class="form-control" id="foreign_zipcode_address" name="foreign_zipcode_address"
                                                        value="<?=$application['foreign_zipcode_address']?>" disabled>
                                                </div>
                                                <div class="col">
                                                    <label for="foreign_country_address"><?=getPhrase('country')?></label>
                                                    <input type="text" class="form-control" id="foreign_country_address" name="foreign_country_address"
                                                        value="<?=$application['foreign_country_address']?>" disabled>
                                                </div>
                                            </div>
                                        </section>
                                    </section>
                                    <section id="phone_numbers">
                                        <h5 class=" "><?php echo getPhrase('phone_numbers'); ?></h5>
                                        <hr/>
                                        <div class="row">
                                            <div class="col">
                                                <label for="us_phone_number"><?= getPhrase('us_phone_number');?></label>
                                                <input type="phone" class="form-control" id="us_phone_number" name="us_phone_number"
                                                    value="<?= $application['us_phone_number'];?>" disabled>
                                            </div>
                                            <div class="col">
                                                <label for="foreign_phone_number"><?= getPhrase('foreign_phone_number');?></label>
                                                <input type="phone" class="form-control" id="foreign_phone_number" name="foreign_phone_number"
                                                    value="<?= $application['foreign_phone_number']?>" disabled>
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="row col">
                                            <h6 style="font-weight: bold;"><?=getPhrase('emergency_contact');?></h6>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <label for="emergency_contact_name"><?= getPhrase('emergency_contact_name');?></label>
                                                <input type="phone" class="form-control" id="emergency_contact_name" name="emergency_contact_name"
                                                    value="<?= $application['emergency_contact_name']?>" disabled>
                                            </div>
                                            <div class="col">
                                                <label for="emergency_contact_phone"><?= getPhrase('emergency_contact_phone');?></label>
                                                <input type="phone" class="form-control" id="emergency_contact_phone" name="emergency_contact_phone"
                                                    value="<?= $application['emergency_contact_phone']?>" disabled>
                                            </div>
                                        </div>
                                    </section>
                                    <section id="program_information">
                                        <h5 class=" "><?php echo getPhrase('program_information'); ?></h5>
                                        <hr />
                                        <div class="row">
                                            <div class="col">
                                                <label for="semester_id"><?= getPhrase('semester_start');?></label>
                                                <input type="text" class="form-control" id="semester_id" name="semester_id"
                                                    value="<?= $application['semester_id']?>" disabled>
                                            </div>
                                            <div class="col">
                                                <label for="expected_start_date"><?= getPhrase('expected_start_date');?></label>
                                                <input type="date" class="form-control" id="expected_start_date" name="expected_start_date"
                                                    value="<?= $application['expected_start_date']?>" disabled>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <label for="medical_condition"><?= getPhrase("medical_condition");?></label>
                                                <input type="text" class="form-control" name="medical_condition" id="medical_condition" 
                                                    value="<?= $application['medical_condition']?>" disabled>
                                            </div>
                                            <div class="col">
                                                <label for="medical_condition_explanation"><?= getPhrase('If_yes,_please_explain');?></label>
                                                <input type="text" class="form-control" id="medical_condition_explanation" name="medical_condition_explanation"
                                                    value="<?= $application['medical_condition_explanation']?>" disabled>
                                            </div>
                                        </div>
                                    </section>
                                    <section id="dependents_information">
                                        <h5 class=" "><?php echo getPhrase('dependents_information'); ?></h5>
                                        <hr />
                                        <div class="row">
                                            <div class="col">
                                                <label for="dependents_question"><?= getPhrase("Do_you_have_dependents?");?></label>
                                                <input type="text" class="form-control" name="dependents_question" id="dependents_question" 
                                                    value="<?= $application['dependents_question']?>" disabled>
                                            </div>
                                            <div class="col">                                                
                                            </div>
                                        </div>
                                        <section id="spouse_info">
                                            <hr />
                                            <div class="row col">
                                                <h6 style="font-weight: bold;"><?=getPhrase('spouse_info');?></h6>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <label for="spouse_full_name"><?= getPhrase("spouse_full_name");?></label>
                                                    <input type="text" class="form-control" id="spouse_full_name" name="spouse_full_name"
                                                        value="<?= $spouse_info['spouse_full_name']?>" disabled>
                                                </div>
                                                <div class="col">
                                                    <label for="spouse_email_address"><?= getPhrase('email_address');?></label>
                                                    <input type="email" class="form-control" id="spouse_email_address" name="spouse_email_address"
                                                        value="<?= $spouse_info['spouse_email_address']?>" disabled>
                                                </div>                                                
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <label for="spouse_birthdate"><?= getPhrase('date_birth');?></label>
                                                    <input type="date" class="form-control" id="spouse_birthdate" name="spouse_birthdate"
                                                        value="<?= $spouse_info['spouse_birthdate']?>" disabled>
                                                </div>
                                                <div class="col">
                                                    <label for="spouse_gender"><?= getPhrase('gender');?></label>
                                                    <input type="text" class="form-control" id="spouse_gender" name="spouse_gender"
                                                        value="<?= $spouse_info['spouse_gender']?>" disabled>
                                                </div>
                                                <div class="col">
                                                    <label for="spouse_passport_number"><?= getPhrase('passport_number');?></label>
                                                    <input type="text" class="form-control" id="spouse_passport_number" name="spouse_passport_number"
                                                        value="<?= $spouse_info['spouse_passport_number']?>" disabled>
                                                </div>
                                            </div>
                                            <div class="row">    
                                                <div class="col">
                                                    <label for="spouse_city_birth"><?= getPhrase('city_of_birth');?></label>
                                                    <input type="text" class="form-control" id="spouse_city_birth" name="spouse_city_birth"
                                                        value="<?= $spouse_info['spouse_city_birth']?>" disabled>
                                                </div>
                                                <div class="col">
                                                    <label for="spouse_country_birth"><?= getPhrase('country_of_birth');?></label>
                                                    <input type="text" class="form-control" id="spouse_country_birth" name="spouse_country_birth" 
                                                        value="<?= $spouse_info['spouse_country_birth']?>" disabled>
                                                </div>
                                                <div class="col">
                                                    <label for="spouse_country_citizenship"><?= getPhrase('country_of_citizenship');?></label>
                                                    <input type="text" class="form-control" id="spouse_country_citizenship" name="spouse_country_citizenship" 
                                                        value="<?= $spouse_info['spouse_country_citizenship']?>" disabled>
                                                </div>
                                            </div>
                                        </section>
                                        <?php 
                                            foreach ($children_info as $key => $value):
                                                $item += 1;                                            
                                        ?>
                                        <section id="child_info">
                                            <hr />
                                            <div class="row col">
                                                <h6 style="font-weight: bold;"><?=getPhrase('child_info');?> <?=$item;?></h6>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <label for="child_1_full_name"><?= getPhrase("full_name");?></label>
                                                    <input type="text" class="form-control" id="child_1_full_name" name="child_1_full_name"
                                                        value="<?= $value['full_name']?>" disabled>
                                                </div>
                                                <div class="col">
                                                    <label for="child_1_email_address"><?= getPhrase('email_address');?></label>
                                                    <input type="email" class="form-control" id="child_1_email_address" name="child_1_email_address"
                                                        value="<?= $value['email_address']?>" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <label for="child_gender"><?= getPhrase('gender');?></label>
                                                    <input type="text" class="form-control" id="child_gender" name="child_gender"
                                                        value="<?= $value['gender']?>" disabled>
                                                </div>
                                                <div class="col">
                                                    <label for="child_1_birthdate"><?= getPhrase('date_birth');?></label>
                                                    <input type="date" class="form-control" id="child_1_birthdate" name="child_1_birthdate"
                                                        value="<?= $value['birthdate']?>" disabled>
                                                </div>
                                                <div class="col">
                                                    <label for="child_1_passport_number"><?= getPhrase('passport_number');?></label>
                                                    <input type="text" class="form-control" id="child_1_passport_number" name="child_1_passport_number"
                                                        value="<?= $value['passport_number']?>" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <label for="child_1_city_birth"><?= getPhrase('city_of_birth');?></label>
                                                    <input type="text" class="form-control" id="child_1_city_birth" name="child_1_city_birth"
                                                        value="<?= $value['city_birth']?>" disabled>
                                                </div>
                                                <div class="col">
                                                    <label for="child_1_country_birth"><?= getPhrase('country_of_birth');?></label>
                                                    <input type="text" class="form-control" id="child_1_country_birth" name="child_1_country_birth" 
                                                        value="<?= $value['country_birth']?>" disabled>
                                                </div>
                                                <div class="col">
                                                    <label for="child_1_country_citizenship"><?= getPhrase('country_of_citizenship');?></label>
                                                    <input type="text" class="form-control" id="child_1_country_citizenship" name="child_1_country_citizenship" 
                                                        value="<?= $value['country_citizenship']?>" disabled>
                                                </div>
                                            </div>
                                        </section>
                                        <?php endforeach;?>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-info btn-rounded" onclick="printDiv('print_area')"><?php echo getPhrase('print');?></button>
                </div>
            </div>
        </div>
        <script>
            function printDiv(nombreDiv) 
            {
                var contenido= document.getElementById(nombreDiv).innerHTML;
                var contenidoOriginal= document.body.innerHTML;
                document.body.innerHTML = contenido;
                window.print();
                document.body.innerHTML = contenidoOriginal;
            }
        </script>    
    </body>
</html>