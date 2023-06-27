<?php 
    $running_year = $this->crud->getInfo('running_year');
    $running_semester = $this->crud->getInfo('running_semester');
    
    $records = $this->applicant->applicant_total_by_date($start_date, $end_date);
    $ids    = array_column($records, 'created_by');
    $names  = array_column($records, 'created_by_name');
    $totals = array_column($records, 'total');

    $labelName = "";

    foreach($names as $name)
    {
        $labelName .= "'".$name."',"; 
    }

    $record_students = $this->applicant->student_total_by_date($start_date, $end_date);
    $id_students     = array_column($record_students, 'assigned_to');
    $name_students   = array_column($record_students, 'assigned_to_name');
    $total_students  = array_column($record_students, 'total');

    $label_student = "";

    foreach($name_students as $item)
    {
        $label_student .= "'".$item."',"; 
    }

    $record_students_update = $this->applicant->student_total_by_update_date($start_date, $end_date);
    $id_students_update     = array_column($record_students_update, 'assigned_to');
    $name_students_update   = array_column($record_students_update, 'assigned_to_name');
    $total_students_update  = array_column($record_students_update, 'total');

    $label_student_update = "";

    foreach($name_students_update as $item)
    {
        $label_student_update .= "'".$item."',"; 
    }

?>
<div class="content-w">
    <?php include $fancy_path.'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <?php include 'advisor__nav.php';?>
            </div>
        </div><br>
        <div class="content-i">
            <div class="content-box">
                <div class="element-wrapper">
                    <div class="tab-content">
                        <?= form_open(base_url() . 'reports/advisor_dashboard/');?>
                        <div class="row">
                            <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group label-floating is-select" style="background-color: #fff;">
                                    <label class="control-label"><?= getPhrase('start_date');?></label>
                                    <div class="form-group date-time-picker">
                                        <input type="text" autocomplete="off" class="datepicker-here"
                                            data-position="bottom left" data-language='en' name="start_date"
                                            id="start_date" value="<?=$start_date?>">

                                    </div>
                                </div>
                            </div>
                            <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group label-floating is-select" style="background-color: #fff;">
                                    <label class="control-label"><?= getPhrase('end_date');?></label>
                                    <div class="form-group date-time-picker">
                                        <input type="text" autocomplete="off" class="datepicker-here"
                                            data-position="bottom left" data-language='en' name="end_date" id="end_date"
                                            value="<?=$end_date?>">

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <button class="btn btn-success btn-upper" style="margin-top:20px"
                                        type="submit"><span><?= getPhrase('search');?></span></button>
                                </div>
                            </div>
                        </div>
                        <?= form_close()?>
                    </div>
                    <div class="tab-pane active">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="element-box">
                                    <canvas id="myChartCreated"></canvas>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="element-box">
                                    <canvas id="myChartRegister"></canvas>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="element-box">
                                    <canvas id="myChartConvert"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.2.1/helpers.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.2.1/chart.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.2.1/chart.umd.js"></script>


<script>
// Created
    const labels = [<?= $labelName;?>];
    const data = {
        labels: labels,
        datasets: [{
            label: 'Created',
            data: [<?= implode(',', $totals);?>],
            borderWidth: 2,
            borderRadius: Number.MAX_VALUE,
            borderSkipped: false,
        }]
    };
    var ctx = document.getElementById("myChartCreated");
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            indexAxis: 'y',
            plugins: {
                legend: {
                    display: false,
                },
                title: {
                    display: true,
                    text: 'Prospect Created by Advisors'
                }
            }
        },
    });

    document.getElementById("myChartCreated").onclick = function(evt) {
        var ids = [<?=implode(',', $ids);?>]
        var activePoints = myChart.getElementsAtEventForMode(evt, 'point', myChart.options);
        var firstPoint = activePoints[0];
        var index = firstPoint['index']
        console.log(ids[index]);

        var f = $("<form target='_blank' method='POST' style='display:none;'></form>").attr({
            action: '/admin/admission_applicants/'
        }).appendTo(document.body);

        $('<input type="hidden" />').attr({
            name: 'advisor_id',
            value: ids[index]
        }).appendTo(f);

        $('<input type="hidden" />').attr({
            name: 'start_date',
            value: '<?=$start_date;?>'
        }).appendTo(f);

        $('<input type="hidden" />').attr({
            name: 'end_date',
            value: '<?=$end_date;?>'
        }).appendTo(f);

        f.submit();

        f.remove();

    };
</script>
<script>
    // Register
    const labelRegister = [<?= $label_student;?>];
    const dataRegister = {
        labels: labelRegister,
        datasets: [{
            label: 'Register',
            data: [<?= implode(',', $total_students);?>],
            borderWidth: 2,
            borderRadius: Number.MAX_VALUE,
            borderSkipped: false,
        }]
    };
    var ctx = document.getElementById("myChartRegister");
    var myChartRegister = new Chart(ctx, {
        type: 'bar',
        data: dataRegister,
        options: {
            responsive: true,
            indexAxis: 'y',
            plugins: {
                legend: {
                    display: false,
                },
                title: {
                    display: true,
                    text: 'Registered and Converted'
                },
                subtitle: {
                    display: true,
                    text: '(<?=$start_date .' to '. $end_date?>)'
                },
            }
        },
    });
    document.getElementById("myChartRegister").onclick = function(evt) {
        var ids = [<?=implode(',', $id_students);?>]
        var activePoints = myChartRegister.getElementsAtEventForMode(evt, 'point', myChart.options);
        var firstPoint = activePoints[0];
        var index = firstPoint['index']
        console.log(ids[index]);

        var f = $("<form target='_blank' method='POST' style='display:none;'></form>").attr({
            action: '/admin/admission_applicants/'
        }).appendTo(document.body);

        $('<input type="hidden" />').attr({
            name: 'advisor_id',
            value: ids[index]
        }).appendTo(f);

        $('<input type="hidden" />').attr({
            name: 'start_date',
            value: '<?=$start_date;?>'
        }).appendTo(f);

        $('<input type="hidden" />').attr({
            name: 'end_date',
            value: '<?=$end_date;?>'
        }).appendTo(f);

        $('<input type="hidden" />').attr({
            name: 'status_id',
            value: '3'
        }).appendTo(f);

        f.submit();

        f.remove();

    };
</script>
<script>
// Convert
    const labelConvert = [<?= $label_student_update;?>];
    const dataConvert = {
        labels: labelConvert,
        datasets: [{
            label: 'Convert',
            data: [<?= implode(',', $total_students_update);?>],
            borderWidth: 2,
            borderRadius: Number.MAX_VALUE,
            borderSkipped: false,
        }]
    };
    var ctx = document.getElementById("myChartConvert");
    var myChartConvert = new Chart(ctx, {
        type: 'bar',
        data: dataConvert,
        options: {
            responsive: true,
            indexAxis: 'y',
            plugins: {
                legend: {
                    display: false,
                },
                title: {
                    display: true,
                    text: 'Converted to Students'
                },
                subtitle: {
                    display: true,
                    text: '(<?=$start_date .' to '. $end_date?>)'
                },

            }
        },
    });
    document.getElementById("myChartConvert").onclick = function(evt) {
        var ids = [<?=implode(',', $id_students);?>]
        var activePoints = myChartConvert.getElementsAtEventForMode(evt, 'point', myChart.options);
        var firstPoint = activePoints[0];
        var index = firstPoint['index']
        console.log(ids[index]);

        var f = $("<form target='_blank' method='POST' style='display:none;'></form>").attr({
            action: '/admin/admission_converted/'
        }).appendTo(document.body);

        $('<input type="hidden" />').attr({
            name: 'advisor_id',
            value: ids[index]
        }).appendTo(f);

        $('<input type="hidden" />').attr({
            name: 'start_date',
            value: '<?=$start_date;?>'
        }).appendTo(f);

        $('<input type="hidden" />').attr({
            name: 'end_date',
            value: '<?=$end_date;?>'
        }).appendTo(f);

        $('<input type="hidden" />').attr({
            name: 'status_id',
            value: '3'
        }).appendTo(f);

        f.submit();

        f.remove();

    };
</script>
