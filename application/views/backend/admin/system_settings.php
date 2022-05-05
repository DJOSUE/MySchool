    <div class="content-w">
        <?php include 'fancy.php';?>
        <div class="header-spacer"></div>
        <div class="conty">
            <div class="os-tabs-w menu-shad">
                <div class="os-tabs-controls">
                    <ul class="navs navs-tabs upper">
                        <li class="navs-item">
                            <a class="navs-links active" href="<?php echo base_url();?>admin/system_settings/"><i class="os-icon picons-thin-icon-thin-0050_settings_panel_equalizer_preferences"></i><span><?php echo getPhrase('system_settings');?></span></a>
                        </li>
                        <li class="navs-item">
                            <a class="navs-links" href="<?php echo base_url();?>admin/sms/"><i class="os-icon picons-thin-icon-thin-0287_mobile_message_sms"></i><span><?php echo getPhrase('sms');?></span></a>
                        </li>
                        <li class="navs-item">
                            <a class="navs-links" href="<?php echo base_url();?>admin/email/"><i class="os-icon picons-thin-icon-thin-0315_email_mail_post_send"></i><span><?php echo getPhrase('email_settings');?></span></a>
                        </li>
                        <li class="navs-item">
                            <a class="navs-links" href="<?php echo base_url();?>admin/translate/"><i class="os-icon picons-thin-icon-thin-0307_chat_discussion_yes_no_pro_contra_conversation"></i><span><?php echo getPhrase('translate');?></span></a>
                        </li>
                        <li class="navs-item">
                            <a class="navs-links" href="<?php echo base_url();?>admin/database/"><i class="picons-thin-icon-thin-0356_database"></i><span><?php echo getPhrase('database');?></span></a>
                        </li>
                    </ul>
                </div>
            </div><br>
            <div class="all-wrapper no-padding-content solid-bg-all">
                <div class="layout-w">
                    <div class="content-w">
                        <div class="content-i">
                            <div class="content-box">
                                <?php echo form_open(base_url() . 'admin/system_settings/do_update');?>
                                    <div class="col-sm-12">
                                        <div class="element-box lined-primary shadow" style="border-radius:10px;">
                                            <h4 class="form-header"><?php echo getPhrase('system_settings');?></h4><br>
                                            <div class="row">   
                                                <div class="col-sm-6">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label"><?php echo getPhrase('system_name');?></label>
                                                        <input class="form-control" value="<?php echo $this->crud->getInfo('system_name');?>" type="text" name="system_name" required="">
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6"> 
                                                    <div class="form-group label-floating">
                                                        <label class="control-label"><?php echo getPhrase('system_title');?></label>
                                                        <input class="form-control" value="<?php echo $this->crud->getInfo('system_title');?>" type="text" name="system_title" required="">
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label"><?php echo getPhrase('system_email');?></label>
                                                        <input class="form-control" value="<?php echo $this->crud->getInfo('system_email');?>" type="text" name="system_email" required="">
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label"><?php echo getPhrase('system_phone');?></label>
                                                        <input class="form-control" value="<?php echo $this->crud->getInfo('phone');?>" type="text" name="phone" required="">
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label"><?php echo getPhrase('address');?></label>
                                                        <textarea class="form-control" name="address"><?php echo $this->crud->getInfo('address');?></textarea>
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="description-toggle">
                                                        <div class="description-toggle-content">
                                                            <div class="h6"><?php echo getPhrase('allow_user_register');?></div>
                                                            <p><?php echo getPhrase('user_register_message');?></p>
                                                        </div>          
                                                        <div class="togglebutton">
                                                            <label><input name="register" value="1" type="checkbox" <?php if($this->crud->getInfo('register') == 1) echo "checked";?>></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group label-floating is-select">
                                                        <label class="control-label"><?php echo getPhrase('language');?></label>
                                                        <div class="select">
                                                            <select name="language" required="">
                                                                <option value=""><?php echo getPhrase('select');?></option>
                                                                <?php $fields = $this->db->list_fields('language');
                                                                    foreach ($fields as $field)
                                                                {
                                                                if ($field == 'phrase_id' || $field == 'phrase') continue;
                                                                $current_default_language = $this->crud->getInfo('language'); ?>
                                                                <option value="<?php echo $field;?>"<?php if ($current_default_language == $field) echo 'selected';?>> <?php echo $field;?> </option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group label-floating is-select">
                                                        <label class="control-label"><?php echo getPhrase('calendar_language');?></label>
                                                        <div class="select">
                                                            <select name="calendar" required="">
                                                                <option value=""><?php echo getPhrase('select');?></option>
                                                                <?php $current_calendar_language = $this->crud->getInfo('calendar'); ?>
                                                                <option value="hy" <?php if ($current_calendar_language == 'hy') echo 'selected';?>> Armenio </option>
                                                                <option value="ca" <?php if ($current_calendar_language == 'ca') echo 'selected';?>> Catalán </option>
                                                                <option value="nl" <?php if ($current_calendar_language == 'nl') echo 'selected';?>> Holandés </option>
                                                                <option value="es" <?php if ($current_calendar_language == 'es') echo 'selected';?>> Español </option>
                                                                <option value="ru" <?php if ($current_calendar_language == 'ru') echo 'selected';?>> Russian </option>
                                                                <option value="en" <?php if ($current_calendar_language == 'en') echo 'selected';?>> English </option>
                                                                <option value="pt" <?php if ($current_calendar_language == 'pt') echo 'selected';?>> Portuguese </option>
                                                                <option value="hi" <?php if ($current_calendar_language == 'hi') echo 'selected';?>> Hindi </option>
                                                                <option value="fr" <?php if ($current_calendar_language == 'fr') echo 'selected';?>> French </option>
                                                                <option value="sr" <?php if ($current_calendar_language == 'sr') echo 'selected';?>> Serbian </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group label-floating is-select">
                                                        <label class="control-label"><?php echo getPhrase('timezone');?></label>
                                                        <div class="select">
                                                            <select name="timezone" required="">
                                                                <option value=""><?php echo getPhrase('select');?></option>
                                                                <?php foreach($this->crud->tz_list() as $t) { ?>
                                                                <option value="<?php echo $t['zone'] ?>" <?php if($this->crud->getInfo('timezone') == $t['zone']) echo "selected";?>><?php echo $t['diff_from_GMT'] . ' - ' . $t['zone'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group label-floating is-select">
                                                        <label class="control-label"><?php echo getPhrase('date_format');?></label>
                                                        <div class="select">
                                                            <select name="date_format" required="">
                                                            <?php $date_format = $this->crud->getInfo('date_format');?>
                                                                <option value=""><?php echo getPhrase('select');?></option>
                             		                            <option value="m/d" <?php if($date_format == 'm/d') echo 'selected';?>>mm/dd</option>
                                                         		<option value="m/d/Y" <?php if($date_format == 'm/d/Y') echo 'selected';?>>mm/dd/yyyy</option>
                                                         		<option value="Y-m" <?php if($date_format == 'Y-m') echo 'selected';?>>yy-mm</option>
                                                         		<option value="Y-m-d" <?php if($date_format == 'Y-m-d') echo 'selected';?>>yyy-mm-dd</option>
                                                         		<option value="m-d-Y" <?php if($date_format == 'm-d-Y') echo 'selected';?>>mm-dd-yyyy</option>
                                                         		<option value="d/m/Y" <?php if($date_format == 'd/m/Y') echo 'selected';?>>dd/mm/yyyy</option>
                                                         		<option value="d-m-Y" <?php if($date_format == 'd-m-Y') echo 'selected';?>>dd-mm-yyyy</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group label-floating is-select">
                                                        <label class="control-label"><?php echo getPhrase('running_year');?></label>
                                                        <div class="select">
                                                            <select name="running_year" required="">
                                                                <?php 
                                                                    $running_year = $this->crud->getInfo('running_year');
                                                                    $years = $this->crud->get_years(1);
                                                                    foreach($years as $year):
                                                                ?>
                                                                    <option value="<?= $year['year'];?>" <?php if($running_year == $year['year']) echo 'selected';?>><?= $year['year'];?></option>
                                                                <?php endforeach;?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group label-floating is-select">
                                                        <label class="control-label"><?php echo getPhrase('running_semester');?></label>
                                                        <div class="select">
                                                            <select name="running_semester" required="">
                                                                <?php 
                                                                    $running_semester = $this->crud->getInfo('running_semester');
                                                                    $semesters = $this->crud->get_periods(1);
                                                                    foreach($semesters as $semester):
                                                                ?>
                                                                    <option value="<?= $semester['semester_id'];?>" <?php if($running_semester == $semester['semester_id']) echo 'selected';?>><?= $semester['name'];?></option>
                                                                <?php endforeach;?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-sm-6">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label"><?php echo getPhrase('currency');?></label>
                                                        <input class="form-control" value="<?php echo $this->crud->getInfo('currency');?>" type="text" name="currency" required="">
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label"><?php echo getPhrase('paypal_email');?></label>
                                                        <input class="form-control" value="<?php echo $this->crud->getInfo('paypal_email');?>" type="text" name="paypal_email" required="">
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Facebook</label>
                                                        <input class="form-control" value="<?php echo $this->crud->getInfo('facebook');?>" type="text" name="facebook">
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Twitter</label>
                                                        <input class="form-control" value="<?php echo $this->crud->getInfo('twitter');?>" type="text" name="twitter">
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>  
                                                <div class="col-sm-6">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Instagram</label>
                                                        <input class="form-control" value="<?php echo $this->crud->getInfo('instagram');?>" type="text" name="instagram">
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">YouTube</label>
                                                        <input class="form-control" value="<?php echo $this->crud->getInfo('youtube');?>" type="text" name="youtube">
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group label-floating is-select">
                                                        <label class="control-label"><?php echo getPhrase('use_daily_marks');?></label>
                                                        <div class="select">
                                                            <select name="logs" required="">
                                                            <?php $use_daily = $this->crud->getInfo('use_daily_marks');?>
                                                     		    <option value="0" <?php if($use_daily == 0) echo 'selected';?>><?php echo getPhrase('no');?></option>
                                                     		    <option value="1" <?php if($use_daily == 1) echo 'selected';?>><?php echo getPhrase('yes');?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group label-floating is-select">
                                                        <label class="control-label"><?php echo getPhrase('enable_logs');?></label>
                                                        <div class="select">
                                                            <select name="logs" required="">
                                                            <?php $logs = $this->crud->getInfo('logs');?>
                                                                <option value=""><?php echo getPhrase('select');?></option>
                                                     		    <option value="0" <?php if($logs == 0) echo 'selected';?>><?php echo getPhrase('no');?></option>
                                                     		    <option value="1" <?php if($logs == 1) echo 'selected';?>><?php echo getPhrase('yes');?></option>
                                                            </select>
                                                        </div>
                                                        <small><b>(<?php echo getPhrase('for_development_purposes');?>)</b></small>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="pull-right">
                                                        <button class="btn btn-primary btn-rounded pull-right" type="submit"> <?php echo getPhrase('update');?></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php echo form_close();?>

                                        <div class="element-box lined-success shadow" style="border-radius:10px;">
                                            <?php echo form_open(base_url() . 'admin/smtp/update');?>
                                                <h4 class="form-header"><?php echo getPhrase('smtp_settings');?></h4><br>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label"><?php echo getPhrase('protocol');?></label>
                                                                <input class="form-control" value="<?php echo $this->db->get_where('settings', array('type' => 'protocol'))->row()->description;?>" type="text" name="protocol" required="">
                                                                <span class="material-input"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6"> 
                                                            <div class="form-group label-floating">
                                                                <label class="control-label"><?php echo getPhrase('smtp_host');?></label>
                                                                <input class="form-control" value="<?php echo $this->db->get_where('settings', array('type' => 'smtp_host'))->row()->description;?>" type="text" name="smtp_host" required="">
                                                                <span class="material-input"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label"><?php echo getPhrase('smtp_port');?></label>
                                                                <input class="form-control" value="<?php echo $this->db->get_where('settings', array('type' => 'smtp_port'))->row()->description;?>" type="text" name="smtp_port" required="">
                                                                <span class="material-input"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label"><?php echo getPhrase('smtp_user');?></label>
                                                                <input class="form-control" value="<?php echo $this->db->get_where('settings', array('type' => 'smtp_user'))->row()->description;?>" type="text" name="smtp_user" required="">
                                                                <span class="material-input"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label"><?php echo getPhrase('smtp_pass');?></label>
                                                                <input class="form-control" value="<?php echo $this->db->get_where('settings', array('type' => 'smtp_pass'))->row()->description;?>" type="text" name="smtp_pass" required="">
                                                                <span class="material-input"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label"><?php echo getPhrase('charset');?></label>
                                                                <input class="form-control" value="<?php echo $this->db->get_where('settings', array('type' => 'charset'))->row()->description;?>" type="text" name="charset" required="">
                                                                <span class="material-input"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <button class="btn btn-primary btn-rounded pull-right" type="submit"> <?php echo getPhrase('update');?></button>
                                                        </div>
                                                    <div>
                                                </div>
                                            </div>
                                        <?php echo form_close();?>
                                    </div>

                                        <div class="element-box lined-success shadow" style="border-radius:10px;">
                                            <?php echo form_open(base_url() . 'admin/social/login');?>
                                                <h4 class="form-header"><?php echo getPhrase('social_login');?></h4><br>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="description-toggle">
                                                                <div class="description-toggle-content">
                                                                    <div class="h6"><?php echo getPhrase('enable_social_login');?></div>
                                                                    <p><?php echo getPhrase('social_login_message');?></p>
                                                                </div>          
                                                                <div class="togglebutton">
                                                                    <label><input name="social_login" value="1" type="checkbox" <?php if($this->crud->getInfo('social_login') == 1) echo "checked";?>></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Google Client ID</label>
                                                                <input class="form-control" value="<?php echo $this->crud->getInfo('google_sync');?>" type="text" name="google_sync">
                                                                <span class="material-input"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Google Secret</label>
                                                                <input class="form-control" value="<?php echo $this->crud->getInfo('google_login');?>" type="text" name="google_login">
                                                                <span class="material-input"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Facebook Sync UR</label>
                                                                <input class="form-control" value="<?php echo base_url();?>auth/facebook/" type="text" readonly>
                                                                <span class="material-input"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Facebook Login URL</label>
                                                                <input class="form-control" value="<?php echo base_url();?>auth/loginfacebook/" type="text" readonly>
                                                                <span class="material-input"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Google Sync URL</label>
                                                                <input class="form-control" value="<?php echo base_url();?>auth/sync/" type="text" readonly>
                                                                <span class="material-input"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Google Login URL</label>
                                                                <input class="form-control" value="<?php echo base_url();?>auth/login/" type="text" readonly>
                                                                <span class="material-input"></span>
                                                            </div>
                                                        </div>    
                                                        <div class="col-sm-12">
                                                            <button class="btn btn-primary btn-rounded pull-right" type="submit"> <?php echo getPhrase('update');?></button>
                                                        </div>
                                                    <div>
                                                </div>
                                            </div>
                                        <?php echo form_close();?>
                                    </div>
                                    <div class="element-box lined-purple shadow" style="border-radius:10px;">
                                        <h4 class="form-header"><i class="os-icon picons-thin-icon-thin-0688_paint_bucket_color"></i> <?php echo getPhrase('personalization');?></h4><br>
                                        <?php echo form_open(base_url() . 'admin/system_settings/skin', array('enctype' => 'multipart/form-data'));?>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><?php echo getPhrase('logo');?></label>
                                                        <input class="form-control" type="file" name="userfile">
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><?php echo getPhrase('logo_white');?></label>
                                                        <input class="form-control" type="file" name="logow">
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><?php echo getPhrase('icon_white');?></label>
                                                        <input class="form-control" type="file" name="icon_white">
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><?php echo getPhrase('favicon');?></label>
                                                        <input class="form-control" type="file" name="favicon">
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <legend><span><?php echo getPhrase('background');?></span></legend>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <input class="form-control" type="file" name="bglogin">
                                                        <span class="material-input"></span>
                                                    </div>    
                                                </div>
                                            </div>
                                            <div class="form-buttons-w text-right">
                                                <button class="btn btn-purple btn-rounded" type="submit"> <?php echo getPhrase('update');?></button>
                                            </div>
                                        <?php echo form_close();?> 
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