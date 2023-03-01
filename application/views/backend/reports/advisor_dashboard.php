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
                        <div class="col-sm-6">
                            <div class="element-box">
                                <canvas id="myChart" width="100" height="100"></canvas>
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
const labels = [<?= $labelName;?>];


const data = {
    labels: labels,
    datasets: [{
        label: 'Register',
        data: [<?= implode(',', $totals);?>],
        borderWidth: 2,
        borderRadius: Number.MAX_VALUE,
        borderSkipped: false,
    }]
};
var ctx = document.getElementById("myChart");
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
                text: 'Total Applicants Create by Advisor'
            }
        }
    },
});

document.getElementById("myChart").onclick = function(evt) {
    var ids = [<?=implode(',', $ids);?>]
    var activePoints = myChart.getElementsAtEventForMode(evt, 'point', myChart.options);
    var firstPoint = activePoints[0];
    var index = firstPoint['index']
    console.log(ids[index]);

    var f = $("<form target='_blank' method='POST' style='display:none;'></form>").attr({
        action: 'https://myschool.dhcoder.com/admin/admission_applicants/'
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