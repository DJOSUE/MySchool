<?php 

    $roundPrecision         =   $this->crud->getInfo('round_precision');
	$quantity_score         =   intval($this->academic->getInfo('ap_quantity_score'));
    $ap_test_names          =   json_decode($this->academic->getInfo('ap_test_names'), true);    
    $placement_weighting    =   json_decode($this->academic->getInfo('placement_weighting'), true);
    $achievement_weighting  =   json_decode($this->academic->getInfo('achievement_weighting'), true);    

	$system_name        =	$this->crud->getInfo('system_name');
    $system_email       =   $this->crud->getInfo('system_email');
    $phone              =   $this->crud->getInfo('phone');

    
    $level_percent  =    $this->db->query('SELECT * FROM class WHERE percentage IS NOT NULL')->result_array(); 
    $names          =    array_column($level_percent, 'name');
    $percentage     =    array_column($level_percent, 'percentage');
    $achieve_level  =    ''; 
    $achieve_level2 =    ''; 
    $comment        =    '';

    $count_all  = 0;
    $total_all  = 0;

    $select     = 'style="background-color: #22b9ff!important; color: #fff !important;"';
?>
<title><?php echo $page_title;?> | <?php echo $system_name;?></title>
<link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet" type="text/css">
<link
    href="<?php echo base_url();?>public/style/cms/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css"
    rel="stylesheet">
<link href="<?php echo base_url();?>public/style/cms/css/main.css" rel="stylesheet">
<link href="<?php echo base_url();?>public/style/cms/icon_fonts_assets/simple-line-icons/css/simple-line-icons.css"
    rel="stylesheet">
<link href="<?php echo base_url();?>public/style/cms/icon_fonts_assets/picons-thin/style.css" rel="stylesheet">
<link href="<?php echo base_url();?>public/style/cms/icon_fonts_assets/picons-social/style.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<style>
    * {
        -webkit-print-color-adjust: exact !important;
        /* Chrome, Safari */
        color-adjust: exact !important;
        /*Firefox*/
        ;
    }
    .table-achieved,
    .table-achieved > th,
    .table-achieved > td {
    background-color: #d1edf6;
    }
</style>
<style type="text/css" media="print">
    @page {
        size: auto;   /* auto is the initial value */
        margin: 20px;  /* this affects the margin in the printer settings */
    }
</style>
<div class="content-w">
    <div class="content-i">
        <div class="content-box">
            <div class="element-wrapper">
                <div class="rcard-wy" id="print_area">
                    <div class="rcard-w">
                        <div class="infos">
                            <div class="info-1">
                                <div class="rcard-logo-w">
                                    <img alt=""
                                        src="<?php echo base_url();?>public/uploads/<?php echo $this->crud->getInfo('logo');?>">
                                </div>
                            </div>
                            <div class="info-2">
                                <div class="rcard-profile">
                                    <img alt="" src="<?php echo $this->crud->get_image_url('student', $student_id);?>">
                                </div>
                                <div class="company-name"><?php echo $this->crud->get_name('student', $student_id);?>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <br/>
                        <div class="rcard-table table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>                                            
                                        </th>
                                        <?php for ($i=1; $i <= $quantity_score; $i++):
                                            $name = 'score'.$i;?>
                                        <th class="text-center">
                                            <?= $ap_test_names[$name] ?>
                                        </th>
                                        <?php endfor; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $tests = $this->db->get_where('v_pa_test' , array('test_id' => $test_id, 'student_id' => $student_id))->result_array(); 
                                        foreach ($tests as $item):
                                            $type           = $item['type_test'];
                                            $average        = 0;
                                            $comment        = $item['comment'];                                            
                                            $score_array    = [];

                                            if($type == '2') // Placement test
                                            {
                                                for ($i=1; $i <= $quantity_score; $i++) { 
                                                    $name = 'score'.$i;
                                                    $score_array[$i] = (($item[$name]/$achievement_weighting[$name]));
                                                }

                                                $average = (array_sum($score_array)/count($score_array));
                                            }
                                            else
                                            {
                                                for ($i=1; $i <= $quantity_score; $i++) { 
                                                    $name = 'score'.$i;
                                                    $score_array[$i] = (($item[$name]/$placement_weighting[$name]));
                                                    
                                                }
                                                
                                                $average = (array_sum($score_array)/count($score_array));

                                            }
                                            
                                            $averageScore = round($average*100, 0);
                                            foreach ($level_percent as $value) {

                                                $var = json_decode($value['percentage'], true);
                                                
                                                if($var['min'] <= $averageScore && $var['max'] >= $averageScore){
                                                    $achieve_level = $value['name'];
                                                    $achieve_level2 = $value['percentage'];
                                                }                                                
                                            }
                                    ?>
                                    <tr class="text-center">
                                        <td>
                                            <?= getPhrase('score'); ?>:
                                        </td>
                                        <?php 
                                            for ($i=1; $i <= $quantity_score; $i++):
                                                $name = 'score'.$i
                                        ?>
                                        <td>
                                            <?= $item[$name]; ?>
                                        </td>
                                        
                                        <?php endfor;?>
                                    </tr>
                                    <?php endforeach;?>
                                    <tr class="text-center">
                                        <td>
                                            %
                                        </td>
                                        <?php 
                                            for ($i=1; $i <= $quantity_score; $i++):
                                                $name = 'score'.$i
                                        ?>
                                        <td>
                                            <?= round($score_array[$i]*100,2); ?>
                                        </td>
                                        
                                        <?php endfor;?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="rcard-heading div-center top-40">
                            <div id="chart_div"></div>
                        </div>
                        <div class="rcard-body div-center top-20 text-center">
                            <div class="round-corners">
                                <h7>AVERAGE SCORE %</h7>
                                <h6><?=round($average*100, 2);?></h6>
                            </div>
                        </div>
                        <div class="rcard-body div-center top-20 text-center">
                            <table class="table width-500">
                                <thead>
                                    <tr>
                                        <?php foreach ($names as $item) :?>
                                        <th class="text-center" <?= $achieve_level == $item ? $select  : '' ?>>
                                            <?= $item ?>
                                        </th>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center">
                                        <?php foreach ($percentage as $item) :
                                            $var = json_decode($item, true);
                                        ?>
                                        <td class="text-center" <?= $achieve_level2 == $item ? $select : '' ?>>
                                            <?= $var['min'].' - '.$var['max'].'&' ?>
                                        </td>
                                        <?php endforeach; ?>
                                    </tr>
                                </tbody>
                                
                            </table>
                        </div>
                        <div class="rcard-body div-center top-20 text-center">
                            <table class="table width-500">
                                <tr>
                                    <td><b>Comment</b></td>
                                </tr>
                                <tr>
                                    <td >
                                        <?=$comment;?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="rcard-footer">
                            <div class="rcard-logo">
                                <img alt=""
                                    src="<?php echo base_url();?>public/uploads/<?php echo $this->crud->getInfo('logo');?>"><span><?php echo $system_name;?></span>
                            </div>
                            <div class="rcard-info">
                                <span><?php echo $system_email;?></span><span><?php echo $phone;?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-info btn-rounded"
                onclick="printDiv('print_area')"><?php echo getPhrase('print');?></button>
        </div>
    </div>
</div>

<script>
    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Score', ''],
            <?php 
                for ($i=1; $i <= $quantity_score; $i++):
                    $name = 'score'.$i;
            ?>
            ['<?=$ap_test_names[$name];?>', <?=$score_array[$i];?>],
            <?php endfor;?>
        ]);

        var options = {
            title: 'Test Score %',
            bars: 'vertical',
            vAxis: {
                format: 'percent',
                viewWindowMode:'pretty',
                gridlines: { count: 4 },
                viewWindow: {
                    max:1,
                    min:0
                }
            },
            height: 200,
            width: 350,
            legend: {position: 'none'},
            colors: ['#0033CC']
        };

        var chart = new google.charts.Bar(document.getElementById('chart_div'));

        chart.draw(data, google.charts.Bar.convertOptions(options));

        var btns = document.getElementById('btn-group');

        btns.onclick = function (e) {

            if (e.target.tagName === 'BUTTON') {
            options.vAxis.format = e.target.id === 'none' ? '' : e.target.id;
            chart.draw(data, google.charts.Bar.convertOptions(options));
            }
        }
    }

    function printDiv(nombreDiv) {
        var contenido = document.getElementById(nombreDiv).innerHTML;
        var contenidoOriginal = document.body.innerHTML;
        document.body.innerHTML = contenido;
        window.print();
        document.body.innerHTML = contenidoOriginal;
    }
</script>

