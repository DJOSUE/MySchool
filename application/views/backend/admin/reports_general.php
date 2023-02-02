<?php 
	$running_year 		= $this->crud->getInfo('running_year');
	$running_semester 	= $this->crud->getInfo('running_semester');
	$useDailyMarks      = $this->crud->getInfo('use_daily_marks');
    $useGradeAttendance = $this->crud->getInfo('use_grade_attendance');

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
                <h5 class="form-header"><?= getPhrase('class_report');?></h5>
                <div class="row">
                    <div class="content-i">
                        <div class="content-box">
                            <?= form_open(base_url() . 'admin/reports_general/', array('class' => 'form m-b'));?>
                            <div class="row" style="margin-top: -30px; border-radius: 5px;">
                                <div class="col-sm-5">
                                    <div class="form-group label-floating is-select">
                                        <label class="control-label"><?= getPhrase('class');?></label>
                                        <div class="select">
                                            <select name="class_id" required=""
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
                                <div class="col-sm-5">
                                    <div class="form-group label-floating is-select">
                                        <label class="control-label"><?= getPhrase('section');?></label>
                                        <div class="select">
                                            <?php if($section_id == ""):?>
                                            <select name="section_id" required id="section_holder">
                                                <option value=""><?= getPhrase('select');?></option>
                                            </select>
                                            <?php else:?>
                                            <select name="section_id" required id="section_holder">
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
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <button class="btn btn-success btn-upper" style="margin-top:20px"
                                            type="submit"><span><?= getPhrase('get_report');?></span></button>
                                    </div>
                                </div>
                            </div>
                            <?= form_close();?>
                            <?php if($class_id != "" && $section_id != ""):?>
                            <div class="row">
                                <div class="text-center col-sm-6"><br>
                                    <h4><?= $this->db->get_where('class', array('class_id' => $class_id))->row()->name;?>
                                        - <?= getPhrase('section');?>:
                                        <?= $this->db->get_where('section', array('section_id' => $section_id))->row()->name;?>
                                    </h4>
                                    <p>
                                        <b>
                                            <?php 
											$this->db->where('class_id', $class_id); 
											$this->db->where('section_id', $section_id); 
											$this->db->group_by('student_id');
											echo $this->db->count_all_results('enroll');
										?>
                                        </b>
                                        <?= getPhrase('students');?> |
                                        <b>
                                            <?php 
											$this->db->where('class_id', $class_id);
											$this->db->where('section_id', $section_id); 
											echo $this->db->count_all_results('subject');?>
                                        </b>
                                        <?= getPhrase('subjects');?>.
                                        <br>
                                        <b><?= getPhrase('running_year');?>:</b>
                                        <?= $running_year;?>
                                        <br>
                                        <b><?= getPhrase('running_semester');?>:</b>
                                        <?= $this->db->get_where('semesters', array('semester_id' => $running_semester))->row()->name;;?>
                                    </p>
                                </div>
                                <div class="col-sm-6 text-center">
                                    <div class="up-main-info">
                                        <!-- <div class="user-avatar-w">
                                            <div class="user-avatar">
                                                <img alt=""
                                                    src="<?php //echo $this->crud->get_image_url('teacher', $this->db->get_where('class', array('class_id' => $class_id))->row()->teacher_id);?>"
                                                    width="80">
                                            </div>
                                        </div>
                                        <h4 class="up-header">
                                            <?php //echo $this->crud->get_name('teacher', $this->db->get_where('class', array('class_id' => $class_id))->row()->teacher_id);?>
                                        </h4>
                                        <h6 class="up-sub-header">
                                            <div class="value badge badge-pill badge-success">
                                                <?php //echo getPhrase('teacher');?></div>
                                        </h6> -->
                                    </div>
                                </div>
                                <hr>
                                <!-- <div class="col-sm-6">
                                    <div class="element-box">
                                        <h5 class="form-header"><?= getPhrase('gender');?></h5>
                                        <canvas id="myChart" width="100" height="100"></canvas>
                                    </div>
                                </div> -->
                                <div class="col-sm-6">
                                    <div class="element-box">
                                        <div class="form-header">
                                            <h6><?= getPhrase('subjects');?></h6>
                                        </div>
                                        <div class="table-responsive">
                                            <table width="100%" class="table table-lightborder table-lightfont">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: left;">
                                                            <?= getPhrase('subject');?>
                                                        </th>
                                                        <th style="text-align: center;">
                                                            <?= getPhrase('modality');?>
                                                        </th>
                                                        <th style="text-align: center;">
                                                            <?= getPhrase('teacher');?>
                                                        </th>
                                                        <th style="text-align: center;">
                                                            <?= getPhrase('total');?>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
   												        $subjects = $this->db->get_where('subject',array('class_id' => $class_id, 'section_id' => $section_id))->result_array();
   												        foreach ($subjects as $subject): ?>
                                                    <tr>
                                                        <td style="text-align: left;">
                                                            <?= $subject['name'];?>
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <?= $this->academic->get_modality_name($subject['modality_id']);?>
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <a class="btn btn-rounded btn-sm btn-purple"
                                                                style="color:white">
                                                                <?= $this->crud->get_name('teacher', $subject['teacher_id']);?>
                                                            </a>
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <?= $this->academic->countStudentsSubject($class_id, $section_id, $subject['subject_id']);?>
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
</div>
<?php
    	$male = 0;
    	$female = 0;
    	// $students = $this->db->get_where('enroll', array('class_id' => $class_id, 'section_id' => $section_id, 'year' => $running_year))->result_array();
		$students = $this->db->query("SELECT DISTINCT student_id FROM enroll where class_id = '$class_id' AND section_id ='$section_id' ")->result_array();
    	foreach($students as $row){
    		if($this->db->get_where('student', array('student_id' => $row['student_id']))->row()->sex == "F")
    		{
    			$female+= 1;
    		}else{
    			$male += 1;
    		}
    	}
    ?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.js"></script>
<script type="text/javascript">
function get_class_sections(class_id) {
    $.ajax({
        url: '<?= base_url();?>admin/get_class_section/' + class_id,
        success: function(response) {
            jQuery('#section_holder').html(response);
        }
    });
}
</script>
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
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>