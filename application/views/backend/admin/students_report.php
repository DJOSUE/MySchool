<?php 
	$running_year 		= $this->crud->getInfo('running_year');
	$running_semester 	= $this->crud->getInfo('running_semester');
	$useDailyMarks      = $this->crud->getInfo('use_daily_marks');
    $useGradeAttendance = $this->crud->getInfo('use_grade_attendance');

	$subject = $this->db->get_where('v_subject', array('subject_id' => $subject_id))->row();

    $accounting_report  = has_permission('accounting_report');
?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <ul class="navs navs-tabs">
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/general_reports/"><i
                                class="picons-thin-icon-thin-0658_cup_place_winner_award_prize_achievement"></i>
                            <span><?php echo getPhrase('classes');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links <?php if($page_name == 'students_report') echo "active";?>"
                            href="<?php echo base_url();?>admin/students_report/"><i
                                class="picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i>
                            <span><?php echo getPhrase('students');?></span></a>
                    </li>
                    <?php if(!$useGradeAttendance): ?>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/attendance_report/"><i
                                class="os-icon picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i>
                            <span><?php echo getPhrase('attendance');?></span></a>
                    </li>
                    <?php endif;?>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/marks_report/"><i
                                class="picons-thin-icon-thin-0100_to_do_list_reminder_done"></i>
                            <span><?php echo getPhrase('final_marks');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/tabulation_report/"><i
                                class="picons-thin-icon-thin-0070_paper_role"></i>
                            <span><?php echo getPhrase('tabulation_sheet');?></span></a>
                    </li>
                    <?php if($accounting_report == 'true'):?>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/accounting_report/"><i
                                class="picons-thin-icon-thin-0406_money_dollar_euro_currency_exchange_cash"></i>
                            <span><?php echo getPhrase('accounting');?></span></a>
                    </li>
                    <?php endif;?>
                </ul>
            </div>
        </div>
        <div class="content-i">
            <div class="content-box">
                <h5 class="form-header"><?php echo getPhrase('students_report');?></h5>
                <div class="content-i">
                    <div class="content-box">
                        <?php echo form_open(base_url() . 'admin/students_report/', array('class' => 'form m-b'));?>
                        <div class="row" style="margin-top: -30px; border-radius: 5px;">
                            <div class="col-sm-3">
                                <div class="form-group label-floating is-select">
                                    <label class="control-label"><?php echo getPhrase('class');?></label>
                                    <div class="select">
                                        <select name="class_id" id="class_id" required=""
                                            onchange="get_class_sections(this.value)">
                                            <option value=""><?php echo getPhrase('select');?></option>
                                            <?php
										                $classes = $this->db->get('class')->result_array();
										                foreach($classes as $row):                        
									                ?>
                                            <option value="<?php echo $row['class_id'];?>"
                                                <?php if($class_id == $row['class_id']) echo "selected";?>>
                                                <?php echo $row['name'];?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group label-floating is-select">
                                    <label class="control-label"><?php echo getPhrase('section');?></label>
                                    <div class="select">
                                        <?php if($section_id == ""):?>
                                        <select name="section_id" required id="section_holder"
                                            onchange="get_class_section_subjects(this.value)">
                                            <option value=""><?php echo getPhrase('select');?></option>
                                        </select>
                                        <?php else:?>
                                        <select name="section_id" required id="section_holder"
                                            onchange="get_class_section_subjects(this.value)">
                                            <option value=""><?php echo getPhrase('select');?></option>
                                            <?php 
												$sections = $this->db->get_where('section', array('class_id' => $class_id, 'year' => $running_year, 'semester_id' => $running_semester))->result_array();
												foreach ($sections as $key):
											?>
                                            <option value="<?php echo $key['section_id'];?>"
                                                <?php if($section_id == $key['section_id']) echo "selected";?>>
                                                <?php echo $key['name'];?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group label-floating is-select">
                                    <label class="control-label"><?php echo getPhrase('subject');?></label>
                                    <div class="select">
                                        <?php if($subject_id == ""):?>
                                        <select name="subject_id" required id="subject_holder">
                                            <option value=""><?php echo getPhrase('select');?></option>
                                        </select>
                                        <?php else:?>
                                        <select name="subject_id" required id="subject_holder">
                                            <option value=""><?php echo getPhrase('select');?></option>
                                            <?php 
												$subjects = $this->db->get_where('subject', array('class_id' => $class_id, 'section_id' => $section_id, 'year' => $running_year, 'semester_id' => $running_semester))->result_array();
												foreach ($subjects as $key):
											?>
                                            <option value="<?php echo $key['subject_id'];?>"
                                                <?php if($subject_id == $key['subject_id']) echo "selected";?>>
                                                <?php echo $key['name'];?>
                                            </option>
                                            <?php endforeach;?>
                                        </select>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <button class="btn btn-success btn-upper" style="margin-top:20px"
                                        type="submit"><span><?php echo getPhrase('get_report');?></span></button>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close();?>

                        <?php if($class_id != "" && $section_id != ""):?>
                        <a href="#" id="btnExport"><button class="btn btn-info btn-sm btn-rounded"><i
                                    class="picons-thin-icon-thin-0123_download_cloud_file_sync"
                                    style="font-weight: 300; font-size: 25px;"></i></button></a>
                        <div class="row">
                            <div class="text-center col-sm-12"><br>
                                <h4><?php echo $this->db->get_where('class', array('class_id' => $class_id))->row()->name;?>
                                    -
                                    <?php echo $this->db->get_where('section', array('section_id' => $section_id))->row()->name;?>
                                    - <?php echo getPhrase('subject');?>:
                                    <?php echo $this->db->get_where('subject', array('subject_id' => $subject_id))->row()->name;?>
                                </h4>
                                <p><b><?php echo getPhrase('teacher');?>:</b>
                                    <?php echo $subject->teacher_name;?><br>
                                    <b>
                                        <?php 
											$this->db->where('year', $running_year); 
											$this->db->where('class_id', $class_id); 
											$this->db->where('section_id', $section_id); 
											$this->db->where('subject_id', $subject_id); 
											echo $this->db->count_all_results('enroll');
										?>
                                    </b><?php echo getPhrase('students');?>
                                </p>
                            </div>
                            <hr>
                            <!-- <div class="col-sm-3" style="border: 1px solid #eee;">
                                <h5 class="form-header"><?php echo getPhrase('gender');?></h5>
                                <canvas id="myChart" width="400" height="400"></canvas>
                            </div> -->
                            <div class="col-sm-9">
                                <div class="element-box">
                                    <div class="form-header">
                                        <h6><?php echo getPhrase('students');?></h6>
                                    </div>
                                    <div class="table-responsive">
                                        <table width="100%" class="table table-striped table-lightfont" id="dvData">
                                            <thead>
                                                <tr>
                                                    <th class="text-center"><?php echo getPhrase('name');?></th>
                                                    <th class="text-center"><?php echo getPhrase('roll');?></th>
                                                    <th class="text-center"><?php echo getPhrase('parent');?></th>
                                                    <th class="text-center"><?php echo getPhrase('status');?></th>
                                                    <th class="text-center"><?php echo getPhrase('gender');?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
													$students = $this->db->get_where('enroll',array('class_id' => $class_id, 
																									'section_id' => $section_id,
																									'subject_id' => $subject_id
													))->result_array();
          											foreach($students as $row):
          										?>
                                                <tr>
                                                    <td><img alt=""
                                                            src="<?php echo $this->crud->get_image_url('student', $row['student_id']);?>"
                                                            width="25px" style="border-radius: 10px;margin-right:5px;">
                                                        <?php echo $this->crud->get_name('student', $row['student_id']);?>
                                                    </td>
                                                    <td class="text-center"><?php echo $row['roll']; ?></td>
                                                    <?php $parent_id = $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->parent_id;?>
                                                    <td class="text-center">
                                                        <?php echo $this->crud->get_name('parent', $parent_id);?></td>
                                                    <td class="text-center">
                                                        <?php if($this->db->get_where('student', array('student_id' => $row['student_id']))->row()->student_session == 1):?>
                                                        <div class="pt-btn">
                                                            <a class="btn nc btn-success btn-sm btn-rounded">
                                                                <font color="white"><?php echo getPhrase('active');?>
                                                                </font>
                                                            </a>
                                                        </div>
                                                        <?php else:?>
                                                        <div class="pt-btn">
                                                            <a class="btn nc btn-danger btn-sm btn-rounded">
                                                                <font color="white"><?php echo getPhrase('inactive');?>
                                                                </font>
                                                            </a>
                                                        </div>
                                                        <?php endif;?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php if($this->db->get_where('student', array('student_id' => $row['student_id']))->row()->sex == 'F'):?>
                                                        <span class="btn btn-sm btn-purple">
                                                            <?php echo $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->sex; ?></span>
                                                        <?php else:?>
                                                        <span class="btn btn-sm btn-primary">
                                                            <?php echo $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->sex; ?></span>
                                                        <?php endif;?>
                                                    </td>
                                                </tr>
                                                <?php endforeach;?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.js"></script>
<script type="text/javascript">
    $("#btnExport").click(function(e) {
		var reportName = '<?php echo getPhrase('tabulation_report').'_'.date('d-m-Y');?>';
		var a = document.createElement('a');
		var data_type = 'data:application/vnd.ms-excel;charset=utf-8';
		var table_html = $('#dvData')[0].outerHTML;
		table_html = table_html.replace(/<tfoot[\s\S.]*tfoot>/gmi, '');
		var css_html =
			'<style>td {border: 0.5pt solid #c0c0c0} .tRight { text-align:right} .tLeft { text-align:left} </style>';
		a.href = data_type + ',' + encodeURIComponent('<html><head>' + css_html + '</' + 'head><body>' +
			table_html + '</body></html>');
		a.download = reportName + '.xls';
		a.click();
		e.preventDefault();
	});
    function get_class_sections(class_id) {
        $.ajax({
            url: '<?php echo base_url();?>admin/get_class_section/' + class_id,
            success: function(response) {
                jQuery('#section_holder').html(response);
            }
        });
    }

    function get_class_section_subjects(section_id) {
        var class_id = document.getElementById("class_id").value;
        $.ajax({
            url: '<?php echo base_url();?>admin/get_class_section_subjects/' + class_id + '/' + section_id,
            success: function(response) {
                jQuery('#subject_holder').html(response);
            }
        });
    }
</script>
<?php
    	$male = 0;
    	$female = 0;
    	$students = $this->db->get_where('enroll', array('class_id' => $class_id, 'section_id' => $section_id, 'subject_id' => $subject_id))->result_array();
    	foreach($students as $row){
    		if($this->db->get_where('student', array('student_id' => $row['student_id']))->row()->sex == "F")
    		{
    			$female+= 1;
    		}else{
    			$male += 1;
    		}
    	}
    ?>
<script>
var ctx = document.getElementById("myChart");
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ["<?php echo getPhrase('female');?>", "<?php echo getPhrase('male');?>"],
        datasets: [{
            label: '#',
            data: [<?php echo $female;?>, <?php echo $male;?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.7)',
                'rgba(54, 162, 235, 0.7)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)'
            ],
            borderWidth: 0
        }]
    },
});
</script>