<?php 
    
    $vacation = $this->request->get_student_request_totals($year_id, $semester_id, '1');
    $ids    = array_column($vacation, 'status');
    $names  = array_column($vacation, 'status_name');
    $totals = array_column($vacation, 'total');
    
    $labelName = "";

    foreach($names as $name)
    {
        $labelName .= "'".$name."',"; 
    }

    $absence_l = $this->request->get_student_type_request_totals($year_id, $semester_id, '2', 'Local');

    $ids_absence_l     = array_column($absence_l, 'status');
    $names_absence_l   = array_column($absence_l, 'status_name');
    $totals_absence_l  = array_column($absence_l, 'total');
    
    $labelName_absence_l = "";

    foreach($names_absence_l as $name)
    {
        $labelName_absence_l .= "'".$name."',"; 
    }

    $absence_i = $this->request->get_student_type_request_totals($year_id, $semester_id, '2', 'International');

    $ids_absence_i     = array_column($absence_i, 'status');
    $names_absence_i   = array_column($absence_i, 'status_name');
    $totals_absence_i  = array_column($absence_i, 'total');
    
    $labelName_absence_i = "";

    foreach($names_absence_i as $name)
    {
        $labelName_absence_i .= "'".$name."',"; 
    }

?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <?php include 'request__nav.php';?>
            </div>
        </div><br>
        <div class="content-box">
            <div class="tab-content ">
                <div class="tab-pane active" id="students">
                    <div class="element-wrapper">
                        <h6 class="element-header"><?= getPhrase('student_permissions');?></h6>
                        <div class="row">
                            <div class="content-i">
                                <div class="content-box">
                                    <?= form_open(base_url() . 'admin/request_dashboard/', array('class' => 'form m-b'));?>
                                    <div class="row" style="margin-top: -30px; border-radius: 5px;">
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?= getPhrase('status');?></label>
                                                <div class="select">
                                                    <select name="year_id">
                                                        <?php $class = $this->db->get_where('years', array('status' => '1'))->result_array();
                                                                foreach ($class as $row): ?>
                                                        <option value="<?php echo $row['year']; ?>"
                                                            <?php if($year_id == $row['year']) echo "selected";?>>
                                                            <?php echo $row['year']; ?>
                                                        </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?= getPhrase('status');?></label>
                                                <div class="select">
                                                    <select name="semester_id">
                                                        <?php  $class = $this->db->get('semesters')->result_array();
                                                                foreach ($class as $row): ?>
                                                        <option value="<?php echo $row['semester_id']; ?>"
                                                            <?php if($semester_id == $row['semester_id']) echo "selected";?>>
                                                            <?php echo $row['name']; ?>
                                                        </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <button class="btn btn-success btn-upper" style="margin-top:20px"
                                                    type="submit"><span><?= getPhrase('search');?></span></button>
                                            </div>
                                        </div>
                                    </div>
                                    <?= form_close();?>
                                </div>
                            </div>
                        </div>
                        <hr />
                        <div class="row">
                            <div class="container-fluid">
                                <div class="tab-pane active">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="element-box">
                                                <canvas id="myChartPermissionStatus"></canvas>                                                
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="element-box">
                                                <canvas id="myChartVacationStatus"></canvas>
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
</div>
<?php 
    echo '<pre>';
    var_dump($labelName_absence_i);
    echo '</pre>';
?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.2.1/helpers.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.2.1/chart.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.2.1/chart.umd.js"></script>
<script>
// Created
    const labels = [<?= $labelName;?>];
    const data = {
        labels: labels,
        datasets: [{
            label: 'Number of requests',
            data: [<?= implode(',', $totals);?>],            
        }]
    };
    var ctx = document.getElementById("myChartVacationStatus");
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Vacation'
                }
            }
        },
    });
</script>
<script>
// Created
    const labels_absence_l = [<?= $labelName_absence_i;?>];
    const data_absence_l = {
        labels: labels_absence_l,
        datasets: [
            {
                label: 'Local',
                data: [<?= implode(',', $totals_absence_l);?>],            
            },
            {
                label: 'International',
                data: [<?= implode(',', $totals_absence_i);?>],            
            }
        ]
    };
    var ctx = document.getElementById("myChartPermissionStatus");
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: data_absence_l,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Absence'
                }
            }
        },
    });
</script>
