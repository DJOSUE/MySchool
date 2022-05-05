<?php 
    $min = $this->db->get_where('academic_settings' , array('type' =>'minium_mark'))->row()->description;
    $running_year = $this->crud->getInfo('running_year');
    $student_info = $this->db->get_where('student' , array('student_id' => $student_id))->result_array(); 
    foreach($student_info as $row):
    $class_id = $this->db->get_where('enroll', array('student_id' => $row['student_id']))->row()->class_id;
    $section_id = $this->db->get_where('enroll', array('student_id' => $row['student_id']))->row()->section_id;
?>
    <div class="content-w"> 
        <?php include 'fancy.php';?>
        <div class="header-spacer"></div>
        <div class="content-i">
            <div class="content-box">
                <div class="conty">
                    <div class="back" style="margin-top:-20px;margin-bottom:10px">		
    	                <a title="<?php echo getPhrase('return');?>" href="<?php echo base_url();?>admin/students/"><i class="picons-thin-icon-thin-0131_arrow_back_undo"></i></a>	
	                </div>
                    <div class="row">
                        <main class="col col-xl-9 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">                
                            <div id="newsfeed-items-grid">
                                <div class="ui-block paddingtel">
                                    <div class="user-profile">
                                        <div class="up-head-w" style="background-image:url(<?php echo base_url();?>public/uploads/bglogin.jpg)">
                                            <div class="up-main-info">
                                                <div class="user-avatar-w">
                                                    <div class="user-avatar">
                                                        <img alt="" src="<?php echo $this->crud->get_image_url('student', $row['student_id']);?>" style="background-color:#fff;">
                                                    </div>
                                                </div>
                                                <h3 class="text-white"><?php echo $row['first_name'];?> <?php echo $row['last_name'];?></h3>
                                                <h5 class="up-sub-header"><?php echo $row['username'];?></h5>
                                            </div>
                                            <svg class="decor" width="842px" height="219px" viewBox="0 0 842 219" preserveAspectRatio="xMaxYMax meet" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g transform="translate(-381.000000, -362.000000)" fill="#FFFFFF"><path class="decor-path" d="M1223,362 L1223,581 L381,581 C868.912802,575.666667 1149.57947,502.666667 1223,362 Z"></path></g></svg>
                                        </div>
                                        <div class="up-controls">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="value-pair">
                                                        <div><?php echo getPhrase('account_type');?>:</div>
                                                        <div class="value badge badge-pill badge-primary"><?php echo getPhrase('student');?></div>
                                                    </div>
                                                    <div class="value-pair">
                                                        <div><?php echo getPhrase('member_since');?>:</div>
                                                        <div class="value"><?php echo $row['since'];?>.</div>
                                                    </div>
                                                    <div class="value-pair">
                                                        <div><?php echo getPhrase('roll');?>:</div>
                                                        <div class="value"><?php echo $this->db->get_where('enroll', array('student_id' => $row['student_id']))->row()->roll;?>.</div>
                                                    </div>
                                                </div>    
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="container">         
			                            <?php echo form_open(base_url() . 'admin/student_attendance_report_selector/', array('class' => 'form m-b')); ?>   
					                        <div class="row">                
							                    <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
							                    <input type="hidden" name="student_id" value="<?php echo $row['student_id']; ?>">
    						                    <input type="hidden" name="section_id" value="<?php echo $section_id; ?>">
    						                    <input type="hidden" name="operation" value="selection">
						                        <div class="col-sm-5">    
						                            <div class="form-group label-floating is-select">
                                                        <label class="control-label"><?php echo getPhrase('month');?></label>
                                                        <div class="select">
                                                            <select name="month" required="" onchange="show_year()">
                                                                <option value=""><?php echo getPhrase('select');?></option>
                                                                <?php
            						                                for ($i = 1; $i <= 12; $i++):
				                                                    if ($i == 1) $m = getPhrase('january');
				                                                    else if ($i == 2) $m = getPhrase('february');
				                                                    else if ($i == 3) $m = getPhrase('march');
				                                                    else if ($i == 4) $m = getPhrase('april');
				                                                    else if ($i == 5) $m = getPhrase('may');
				                                                    else if ($i == 6) $m = getPhrase('june');
				                                                    else if ($i == 7) $m = getPhrase('july');
				                                                    else if ($i == 8) $m = getPhrase('august');
				                                                    else if ($i == 9) $m = getPhrase('september');
				                                                    else if ($i == 10) $m = getPhrase('october');
				                                                    else if ($i == 11) $m = getPhrase('november');
    				                                                else if ($i == 12) $m = getPhrase('december');
                				                                ?>
                					                            <option value="<?php echo $i; ?>"<?php if($month == $i) echo 'selected'; ?>  ><?php echo $m; ?></option>
                    				                            <?php endfor;?>
                                                            </select>
                                                        </div>
                                                    </div>
						                        </div>  
						                        <div class="col-sm-5">    
						                            <div class="form-group label-floating is-select">
                                                        <label class="control-label"><?php echo getPhrase('subject');?></label>
                                                        <div class="select">
                                                            <select name="subject_id" required="">
                                                                <option value=""><?php echo getPhrase('select');?></option>
                                                                <?php
            						                                $subjects = $this->db->get_where('subject', array('class_id' => $class_id, 'section_id' => $section_id))->result_array();
            						                                foreach($subjects as $sbj):
                				                                ?>
                					                            <option value="<?php echo $sbj['subject_id']; ?>"<?php if($subject_id == $sbj['subject_id']) echo 'selected'; ?>  ><?php echo $sbj['name']; ?></option>
                    				                            <?php endforeach;?>
                                                            </select>
                                                        </div>
                                                    </div>
						                        </div>   
                                                <input type="hidden" name="year" value="<?php echo $running_year;?>">        
						                        <div class="col-sm-2">                 
							                        <div class="form-group"> 
    								                    <button class="btn btn-rounded btn-success btn-upper" style="margin-top:20px"><span><?php echo getPhrase('generate');?></span></button>
							                        </div>                
    						                    </div>             
					                        </div>            
    				                    <?php echo form_close();?>   
		                            </div> 
                                </div>
				                <?php if ($class_id != '' && $section_id != '' && $month != '' && $year != ''): ?>
                                <div class="element-box lined-primary shadow">              
                                    <div class="row">                
                                        <div class="col-7 text-left">                  
                                            <h5 class="form-header"><?php echo getPhrase('attendance_report');?></h5>
                                        </div>                
                                    </div>              
                                    <div class="table-responsive">                
                                        <table class="table table-sm table-lightborder">
                                            <thead>                    
                                                <tr class="text-center" height="50px">
                                                    <th class="text-left"> <?php echo getPhrase('student');?></th>  
                                                    <?php
                                                        $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                                                        for ($i = 1; $i <= $days; $i++) {
                                                    ?>                    
                                                    <th class="text-center"> <?php echo $i; ?> </th>                    
                                                    <?php } ?>
                                                </tr> 
                                            </thead>                  
                                            <tbody>                    
                                                <tr>                      
                                                    <td><img alt="" src="<?php echo $this->crud->get_image_url('student', $student_id);?>" width="20px" style="border-radius:20px;margin-right:5px;"> <?php echo $this->crud->get_name('student', $student_id); ?> </td>    
                                                    <?php
                                                        $status = 0;
                                                        for ($i = 1; $i <= $days; $i++) {
                                                        $timestamp = strtotime($i . '-' . $month . '-' . $year);
                                                        $this->db->group_by('timestamp');
                                                        $attendance = $this->db->get_where('attendance', array('subject_id' => $subject_id,'section_id' => $section_id, 'class_id' => $class_id, 'year' => $running_year, 'timestamp' => $timestamp, 'student_id' => $student_id))->result_array();
                                                        foreach ($attendance as $row1): $month_dummy = date('d', $row1['timestamp']);
                                                        if ($i == $month_dummy) $status = $row1['status'];
                                                        endforeach; ?>
                                                    <td class="text-center">
                                                    <?php if ($status == 1) { ?>
                                                        <div class="status-pilli green" data-title="<?php echo getPhrase('present');?>" data-toggle="tooltip"></div>
                                                    <?php  } if($status == 2)  { ?>
                                                        <div class="status-pilli red" data-title="<?php echo getPhrase('absent');?>" data-toggle="tooltip"></div>
                                                    <?php  } if($status == 3)  { ?>
                                                        <div class="status-pilli yellow" data-title="<?php echo getPhrase('late');?>" data-toggle="tooltip"></div>
                                                    <?php  } $status =0;?>
                                                    </td>                      
                                                    <?php } ?>
                                                </tr>                                      
                                            </tbody>                
                                        </table>             
                                    </div>           
                                </div>  
                                <?php endif;?>       
                            </div>
                        </main>
                        <div class="col col-xl-3 order-xl-1 col-lg-12 order-lg-2 col-md-12 col-sm-12 col-12 ">
                            <div class="eduappgt-sticky-sidebar">
                                <div class="sidebar__inner">
                                    <div class="ui-block paddingtel">
                                        <div class="ui-block-content">
                                            <div class="widget w-about">
                                                <a href="javascript:void(0);" class="logo"><img src="<?php echo base_url();?>public/uploads/<?php echo $this->crud->getInfo('logo');?>"></a>
                                                <ul class="socials">
                                                    <li><a class="socialDash fb" href="<?php echo $this->crud->getInfo('facebook');?>"><i class="fab fa-facebook-square" aria-hidden="true"></i></a></li>
                                                    <li><a class="socialDash tw" href="<?php echo $this->crud->getInfo('twitter');?>"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
                                                    <li><a class="socialDash yt" href="<?php echo $this->crud->getInfo('youtube');?>"><i class="fab fa-youtube" aria-hidden="true"></i></a></li>
                                                    <li><a class="socialDash ig" href="<?php echo $this->crud->getInfo('instagram');?>"><i class="fab fa-instagram" aria-hidden="true"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ui-block paddingtel">
                                        <div class="ui-block-content">
                                            <div class="help-support-block">
                                                <h3 class="title"><?php echo getPhrase('quick_links');?></h3>
                                                <ul class="help-support-list">
                                                <li>
                                                    <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                        style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                    <a
                                                        href="<?php echo base_url();?>admin/student_portal/<?php echo $student_id;?>/">
                                                        <?php echo getPhrase('personal_information');?>
                                                    </a>
                                                </li>
                                                <li>
                                                    <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                        style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                    <a
                                                        href="<?php echo base_url();?>admin/student_update/<?php echo $student_id;?>/">
                                                        <?php echo getPhrase('update_information');?>
                                                    </a>
                                                </li>
												<li>
                                                    <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                        style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                    <a
                                                        href="<?php echo base_url();?>admin/student_update_class/<?php echo $student_id;?>/">
                                                        <?php echo getPhrase('update_class');?>
                                                    </a>
                                                </li>
												<li>
                                                    <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                        style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                    <a
                                                        href="<?php echo base_url();?>admin/student_enrollments/<?php echo $student_id;?>/">
                                                        <?php echo getPhrase('student_enrollments');?>
                                                    </a>
                                                </li>
                                                <li>
                                                    <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                        style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                    <a
                                                        href="<?php echo base_url();?>admin/student_invoices/<?php echo $student_id;?>/">
                                                        <?php echo getPhrase('payments_history');?>
                                                    </a>
                                                </li>
                                                <li>
                                                    <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                        style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                    <a
                                                        href="<?php echo base_url();?>admin/student_marks/<?php echo $student_id;?>/">
                                                        <?php echo getPhrase('marks');?>
                                                    </a>
                                                </li>
												<li>
                                                    <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                        style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                    <a
                                                        href="<?php echo base_url();?>admin/student_past_marks/<?php echo $student_id;?>/">
                                                        <?php echo getPhrase('old_marks');?>
                                                    </a>
                                                </li>
                                                <li>
                                                    <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                        style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                    <a
                                                        href="<?php echo base_url();?>admin/student_profile_attendance/<?php echo $student_id;?>/">
                                                        <?php echo getPhrase('attendance');?>
                                                    </a>
                                                </li>
                                                <li>
                                                    <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                        style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                    <a
                                                        href="<?php echo base_url();?>admin/student_profile_report/<?php echo $student_id;?>/">
                                                        <?php echo getPhrase('behavior');?>
                                                    </a>
                                                </li>
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
<?php endforeach;?>