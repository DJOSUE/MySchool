<?php 
    
    $running_year = $this->crud->getInfo('running_year');

    $min = $this->db->get_where('academic_settings' , array('type' =>'minium_mark'))->row()->description;
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
                                        <?php include 'student_area_header.php';?>
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
						                            <!-- <div class="form-group label-floating is-select">
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
                                                    </div> -->
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
                                                            $date = $year.'/'.$month.'/'.$i;
                                                            $datetime = strtotime($date);
                                                            $day_name = date('D', $datetime);
                                                    ?>                    
                                                    <th class="text-center"> <?php echo $day_name.'<br/>'.$i; ?> </th>                    
                                                    <?php } ?>
                                                </tr> 
                                            </thead>                  
                                            <tbody>
                                            <tr>
                                                <td><img alt=""
                                                        src="<?php echo $this->crud->get_image_url('student', $student_id);?>"
                                                        width="20px" style="border-radius:20px;margin-right:5px;">
                                                    <?php echo $this->crud->get_name('student', $student_id); ?>
                                                </td>
                                                <?php
                                                    $status = 0;
                                                    for ($i = 1; $i <= $days; $i++) {                                                        
                                                        $date = ($year . '-' . $month . '-' . $i);                                                        
                                                        $attendance = $this->db->get_where('v_mark_daily_attendance', array('year' => $running_year, 'date' => $date, 'student_id' => $student_id))->result_array();
                                                        
                                                        // echo '<pre>';
                                                        // var_dump($date);
                                                        // echo '</pre>';


                                                        $attendanceValue = -1;
                                                        foreach ($attendance as $row1): 
                                                            $attendanceValue = (($row1['attendance'] > -1)? $row1['attendance'] : -1 );
                                                            break;
                                                        endforeach; 
                                                        
                                                ?>
                                                <td class="text-center">
                                                    <?php if ($attendanceValue == 100) { ?>
                                                    <div class="status-pilli green"
                                                        data-title="<?= getPhrase('present');?>"
                                                        data-toggle="tooltip"></div>
                                                    <?php  } else if($attendanceValue > 0)  { ?>
                                                    <div class="status-pilli yellow"
                                                        data-title="<?= getPhrase('late');?>"
                                                        data-toggle="tooltip"></div>
                                                    <?php  } else if($attendanceValue == 0)  { ?>
                                                    <div class="status-pilli red"
                                                        data-title="<?= getPhrase('absent');?>"
                                                        data-toggle="tooltip"></div>
                                                    <?php  } $attendanceValue = -1;?>
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
                        <?php include 'student_area_menu.php';?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach;?>