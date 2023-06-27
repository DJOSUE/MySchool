<?php 
    $running_year = $this->crud->getInfo('running_year');
    $running_semester = $this->crud->getInfo('running_semester');

    $classes    = $this->db->get_where('class', array('status' => 1))->result_array();
?>
<div class="content-w">
    <?php include $fancy_path.'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <?php include 'academic__nav.php';?>
            </div>
        </div><br>
        <div class="container-fluid">

            <div class="col-sm-6">
                <div class="element-box">
                    <h5 class="form-header"><?= getPhrase('gender');?></h5>
                    <canvas id="myChart" width="100" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.2.1/helpers.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.2.1/chart.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.2.1/chart.umd.js"></script>


<script>
const DATA_COUNT = 7;
const NUMBER_CFG = {
    count: DATA_COUNT,
    min: -100,
    max: 100
};

const labels = [
  'January',
  'February',
  'March',
  'April',
  'May',
  'June',
  'July'
];
const data = {
    labels: labels,
    datasets: [{
            label: 'Fully Rounded',
            data: [38,44,56,20,51,68,67],
            borderWidth: 2,
            borderRadius: Number.MAX_VALUE,
            borderSkipped: false,
        },
        {
            label: 'Small Radius',
            data: [80,40,60,40,51,80,46],
            borderWidth: 2,
            borderRadius: 5,
            borderSkipped: false,
        }
    ]
};
var ctx = document.getElementById("myChart");
var myChart = new Chart(ctx, {
    type: 'bar',
    data: data,
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Chart.js Bar Chart'
            }
        }
    },
});
</script>