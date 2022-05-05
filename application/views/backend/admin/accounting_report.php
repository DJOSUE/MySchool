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
            <div class="os-tabs-controls">
                <ul class="navs navs-tabs">
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/general_reports/"><i
                                class="picons-thin-icon-thin-0658_cup_place_winner_award_prize_achievement"></i>
                            <span><?php echo getPhrase('classes');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/students_report/"><i
                                class="picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i>
                            <span><?php echo getPhrase('students');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/attendance_report/"><i
                                class="os-icon picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i>
                            <span><?php echo getPhrase('attendance');?></span></a>
                    </li>
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
                <h5 class="form-header"><?php echo getPhrase('accounting_report');?></h5>
                <hr>
                <div class="row  bg-white">
                    <div class="col-sm-12">
                        <canvas id="myChart" style="width: auto; min-height:600px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.js"></script>
<script>
new Chart(document.getElementById("myChart"), {
    type: 'line',
    data: {
        labels: ["<?php echo getPhrase('january');?>", "<?php echo getPhrase('february');?>",
            "<?php echo getPhrase('march');?>", "<?php echo getPhrase('april');?>",
            "<?php echo getPhrase('may');?>", "<?php echo getPhrase('june');?>",
            "<?php echo getPhrase('july');?>", "<?php echo getPhrase('august');?>",
            "<?php echo getPhrase('september');?>", "<?php echo getPhrase('october');?>",
            "<?php echo getPhrase('november');?>", "<?php echo getPhrase('december');?>"
        ],
        datasets: [{
            data: [<?php echo $this->crud->income('Jan');?>, <?php echo $this->crud->income('Feb');?>,
                <?php echo $this->crud->income('Mar');?>, <?php echo $this->crud->income('Apr');?>,
                <?php echo $this->crud->income('May');?>, <?php echo $this->crud->income('Jun');?>,
                <?php echo $this->crud->income('Jul');?>, <?php echo $this->crud->income('Aug');?>,
                <?php echo $this->crud->income('Sep');?>, <?php echo $this->crud->income('Oct');?>,
                <?php echo $this->crud->income('Nov');?>, <?php echo $this->crud->income('Dec');?>
            ],
            label: "<?php echo getPhrase('income');?>",
            borderColor: "#3e95cd",
            backgroundColor: "#3e95cd",
            fill: false
        }, {
            data: [<?php echo $this->crud->expense('Jan');?>, <?php echo $this->crud->expense('Feb');?>,
                <?php echo $this->crud->expense('Mar');?>,
                <?php echo $this->crud->expense('Apr');?>,
                <?php echo $this->crud->expense('May');?>,
                <?php echo $this->crud->expense('Jun');?>,
                <?php echo $this->crud->expense('Jul');?>,
                <?php echo $this->crud->expense('Aug');?>,
                <?php echo $this->crud->expense('Sep');?>,
                <?php echo $this->crud->expense('Oct');?>,
                <?php echo $this->crud->expense('Nov');?>, <?php echo $this->crud->expense('Dec');?>
            ],
            label: "<?php echo getPhrase('expense');?>",
            borderColor: "#8e5ea2",
            backgroundColor: "#8e5ea2",
            fill: false
        }]
    },
    options: {
        title: {
            display: true,
            text: '<?php echo getPhrase('accounting_report');?> <?php echo getPhrase('running_year');?> <?php echo $running_year;?>'
        }
    }
});
</script>