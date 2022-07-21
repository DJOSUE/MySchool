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
                        <i class="os-icon picons-thin-icon-thin-0482_gauge_dashboard_empty"></i><span><?php echo getPhrase('home');?></span></a>
                    </li>
                    <li class="navs-item active">
                        <a class="navs-links" href="<?php echo base_url();?>admin/admission_new_applicant/">
                        <i class="os-icon picons-thin-icon-thin-0716_user_profile_add_new"></i><span><?php echo getPhrase('new_applicant');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/admission_new_student/">
                        <i class="os-icon picons-thin-icon-thin-0706_user_profile_add_new"></i><span><?php echo getPhrase('new_student');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links active" href="<?php echo base_url();?>admin/admission_applicant/">
                        <i class="os-icon picons-thin-icon-thin-0704_users_profile_group_couple_man_woman"></i><span><?php echo getPhrase('applicant');?></span></a>
                    </li>
                </ul>
            </div>
        </div><br>
        <div class="container-fluid">
            <?php 
                // Test to get 
                $url = 'https://admission.americanone-esl.com/api/login?email=victor.ochoa@americanone-esl.com&password=victor.ochoa';
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_HTTPGET, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response_json = curl_exec($ch);
                curl_close($ch);
                $response=json_decode($response_json, true);

                echo '<pre>';

                $url_app = 'https://admission.americanone-esl.com/api/student_info?auth_token='.$response['token'].'&user_email=ALEJA21148@GMAIL.COM';

                $ch_app = curl_init($url_app);
                curl_setopt($ch_app, CURLOPT_HTTPGET, true);
                curl_setopt($ch_app, CURLOPT_RETURNTRANSFER, true);
                $response_json_app = curl_exec($ch_app);
                curl_close($ch_app);
                $response_app = json_decode($response_json_app, true);

                
                
                var_dump($response_app);
                echo '</pre>';
            ?>
        </div>
    </div>
</div>