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
            <?php include 'reports__menu.php';?>
        </div>
        <div class="content-i">
            <div class="content-box">
                <h5 class="form-header"><?= getPhrase('students_report');?></h5>
                <div class="content-i">
                    <div class="content-box">
                        <?= form_open(base_url() . 'admin/reports_students/', array('class' => 'form m-b'));?>
                        <div class="row" style="margin-top: -30px; border-radius: 5px;">
                            <div class="col-sm-3">
                                <div class="form-group label-floating is-select">
                                    <label class="control-label"><?= getPhrase('class');?></label>
                                    <div class="select">
                                        <select name="class_id" id="class_id" required=""
                                            onchange="get_class_sections(this.value)">
                                            <option value=""><?= getPhrase('select');?></option>
                                            <?php
										                $classes = $this->db->get('class')->result_array();
										                foreach($classes as $row):                        
									                ?>
                                            <option value="<?= $row['class_id'];?>"
                                                <?php if($class_id == $row['class_id']) echo "selected";?>>
                                                <?= $row['name'];?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group label-floating is-select">
                                    <label class="control-label"><?= getPhrase('section');?></label>
                                    <div class="select">
                                        <?php if($section_id == ""):?>
                                        <select name="section_id" required id="section_holder"
                                            onchange="get_class_section_subjects(this.value)">
                                            <option value=""><?= getPhrase('select');?></option>
                                        </select>
                                        <?php else:?>
                                        <select name="section_id" required id="section_holder"
                                            onchange="get_class_section_subjects(this.value)">
                                            <option value=""><?= getPhrase('select');?></option>
                                            <?php 
												$sections = $this->db->get_where('section', array('class_id' => $class_id, 'year' => $running_year, 'semester_id' => $running_semester))->result_array();
												foreach ($sections as $key):
											?>
                                            <option value="<?= $key['section_id'];?>"
                                                <?php if($section_id == $key['section_id']) echo "selected";?>>
                                                <?= $key['name'];?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group label-floating is-select">
                                    <label class="control-label"><?= getPhrase('subject');?></label>
                                    <div class="select">
                                        <?php if($subject_id == ""):?>
                                        <select name="subject_id" required id="subject_holder">
                                            <option value=""><?= getPhrase('select');?></option>
                                        </select>
                                        <?php else:?>
                                        <select name="subject_id" required id="subject_holder">
                                            <option value=""><?= getPhrase('select');?></option>
                                            <?php 
												$subjects = $this->db->get_where('subject', array('class_id' => $class_id, 'section_id' => $section_id, 'year' => $running_year, 'semester_id' => $running_semester))->result_array();
												foreach ($subjects as $key):
											?>
                                            <option value="<?= $key['subject_id'];?>"
                                                <?php if($subject_id == $key['subject_id']) echo "selected";?>>
                                                <?= $key['name'];?>
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
                                        type="submit"><span><?= getPhrase('get_report');?></span></button>
                                </div>
                            </div>
                        </div>
                        <?= form_close();?>

                        <?php if($class_id != "" && $section_id != ""):?>
                        <a href="#" id="btnExport"><button class="btn btn-info btn-sm btn-rounded"><i
                                    class="picons-thin-icon-thin-0123_download_cloud_file_sync"
                                    style="font-weight: 300; font-size: 25px;"></i></button></a>
                        <div class="row">
                            <div class="text-center col-sm-12"><br>
                                <h4><?= $this->db->get_where('class', array('class_id' => $class_id))->row()->name;?>
                                    -
                                    <?= $this->db->get_where('section', array('section_id' => $section_id))->row()->name;?>
                                    - <?= getPhrase('subject');?>:
                                    <?= $this->db->get_where('subject', array('subject_id' => $subject_id))->row()->name;?>
                                </h4>
                                <p><b><?= getPhrase('teacher');?>:</b>
                                    <?= $subject->teacher_name;?><br>
                                    <b>
                                        <?php 
											$this->db->where('year', $running_year); 
											$this->db->where('class_id', $class_id); 
											$this->db->where('section_id', $section_id); 
											$this->db->where('subject_id', $subject_id); 
											echo $this->db->count_all_results('enroll');
										?>
                                    </b><?= getPhrase('students');?>
                                </p>
                            </div>
                            <hr>
                            <!-- <div class="col-sm-3" style="border: 1px solid #eee;">
                                <h5 class="form-header"><?= getPhrase('gender');?></h5>
                                <canvas id="myChart" width="400" height="400"></canvas>
                            </div> -->
                            <div class="col-sm-9">
                                <div class="element-box">
                                    <div class="form-header">
                                        <h6><?= getPhrase('students');?></h6>
                                    </div>
                                    <div class="table-responsive">
                                        <table width="100%" class="table table-striped table-lightfont" id="dvData">
                                            <thead>
                                                <tr class="text-center">
                                                    
                                                    <th><?= getPhrase('name');?></th>
                                                    <th><?= getPhrase('program');?></th>
                                                    <th><?= getPhrase('email');?></th>
                                                    <th><?= getPhrase('phone');?></th>
                                                    <th><?= getPhrase('age');?></th>
                                                    <th><?= getPhrase('status');?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
													$students = $this->db->get_where('enroll',array('class_id' => $class_id, 
																									'section_id' => $section_id,
																									'subject_id' => $subject_id
													))->result_array();
          											foreach($students as $row):
                                                        $student_info = $this->db->get_where('v_students', array('student_id' => $row['student_id']))->row_array();
                                                        // echo '<pre>';
                                                        // var_dump($student_info );
                                                        // echo '</pre>';
          										?>
                                                <tr class="text-center">
                                                    
                                                    <td class="text-left">                                                        
                                                        <?= $student_info['full_name'];?>
                                                    </td>
                                                    <td>
                                                        <?= $student_info['program_name']; ?>
                                                    </td>
                                                    <td>
                                                        <?= $student_info['email']?>
                                                    </td>
                                                    <td>
                                                        <?= $student_info['phone']?>
                                                    </td>
                                                    <td>
                                                        <?= calculate_age($student_info['birthday'])?>
                                                    </td>
                                                    <td>
                                                    <span class="badge badge-success" style="background-color: <?=$student_info['student_session_color']?>;">
                                                        <?= $student_info['student_session_name']?>
                                                    </span>
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
    var reportName = '<?= getPhrase('reports_tabulation').'_'.date('d-m-Y');?>';
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
        url: '<?= base_url();?>admin/get_class_section/' + class_id,
        success: function(response) {
            jQuery('#section_holder').html(response);
        }
    });
}

function get_class_section_subjects(section_id) {
    var class_id = document.getElementById("class_id").value;
    $.ajax({
        url: '<?= base_url();?>admin/get_class_section_subjects/' + class_id + '/' + section_id,
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
        labels: ["<?= getPhrase('female');?>", "<?= getPhrase('male');?>"],
        datasets: [{
            label: '#',
            data: [<?= $female;?>, <?= $male;?>],
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