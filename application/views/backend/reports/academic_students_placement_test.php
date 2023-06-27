<?php 

    $min            = floatval($this->crud->getInfo('minium_mark'));
    $quantity_score = intval($this->academic->getInfo('ap_quantity_score'));
    $ap_test_names  = json_decode($this->academic->getInfo('ap_test_names'), true);
    $weighting      = json_decode($this->academic->getInfo('placement_weighting'), true);
    $level_percent  =    $this->db->query('SELECT * FROM class WHERE percentage IS NOT NULL')->result_array(); 

    $this->db->reset_query();

    if($year_id != '')
    {
        $this->db->where('year', $year_id);
    }
    if($semester_id != '')
    {
        $this->db->where('semester_id', $semester_id);
    }
    $this->db->where('first_name is NOT NULL', NULL, FALSE);
    $this->db->where('type_test', 1);
    $pa_test_query = $this->db->get('v_pa_test');
    $pa_test = $pa_test_query->result_array();
?>

<link href="<?php echo base_url();?>public/style/print/report.css" media="all" rel="stylesheet">

<div class="content-w">
    <?php include  $fancy_path.'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <?php include 'academic__nav.php';?>
        </div>
        <div class="content-i">
            <div class="content-box">
                <h5 class="form-header"><?= getPhrase('tabulation_sheet');?></h5>
                <hr>
                <?= form_open(base_url() . 'report/academic_students_placement_test/', array('class' => 'form m-b'));?>
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group label-floating is-select">
                            <label class="control-label"><?= getPhrase('year');?></label>
                            <div class="select">
                                <select name="year_id" id="year_id" required="">
                                    <option value=""><?= getPhrase('select');?></option>
                                    <?php 
                                        $class = $this->db->get_where('years', array('status' => '1'))->result_array();
                                        foreach ($class as $row): ?>
                                    <option value="<?= $row['year']; ?>"
                                        <?php if($year_id == $row['year']) echo "selected";?>>
                                        <?= $row['year']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group label-floating is-select">
                            <label class="control-label"><?= getPhrase('semester');?></label>
                            <div class="select">
                                <select name="semester_id" id="semester_id" required="">
                                    <option value=""><?= getPhrase('select');?></option>
                                    <?php 
                                        $semesters = $this->db->get_where('semesters', array('status' => '1'))->result_array();
                                        foreach ($semesters as $row): ?>
                                    <option value="<?= $row['semester_id']; ?>"
                                        <?php if($semester_id == $row['semester_id']) echo "selected";?>>
                                        <?= $row['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
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
                <hr>
                <?php if($year_id != ""):?>
                <div>
                    <div class="row"><br><br>

                        <a href="#" id="btnExport"><button class="btn btn-info btn-sm btn-rounded"><i
                                    class="picons-thin-icon-thin-0123_download_cloud_file_sync"
                                    style="font-weight: 300; font-size: 25px;"></i></button>
                        </a>
                        <a href="#" id="print"><button class="btn btn-info btn-sm btn-rounded"
                                onclick="printDiv('print_area');"><i class="picons-thin-icon-thin-0333_printer"
                                    style="font-weight: 300; font-size: 25px;"></i></button>
                        </a>
                    </div>
                    <div class="row">
                        <br><br>
                        <div class="cuadro" id="print_area">
                            <table cellpading="0" cellspacing="0" border="1"
                                style="margin: 20px 0; width:100%; table-layout: fixed;overflow-wrap: break-word;"
                                class="bg-white" id="dvData">
                                <thead>
                                    <tr
                                        style="background-color: #a01a7a; color: #fff;text-align: center; text-transform: uppercase;">
                                        <th style="text-align: center;">
                                            <?php echo getPhrase('student');?>
                                        </th>
                                        <?php for ($i=1; $i <= $quantity_score; $i++):
                                        $name = 'score'.$i;?>
                                        <th class="text-center">
                                            <?= $ap_test_names[$name] ?>
                                        </th>
                                        <?php endfor; ?>

                                        <th style="text-align: center;">
                                            <?php echo getPhrase('class');?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody style=" overflow: scroll;">
                                    <?php foreach($pa_test as $item):
                                    $average = [];

                                    for ($i = 1; $i < $quantity_score; $i++) {
                                        $name = 'score'.$i;
                                        $value = $item[$name];
                                        $average[$i] = ($value / $weighting[$name]);
                                    }

                                    $result = (array_sum($average) / $i ) * 100;

                                    foreach($level_percent as $row)
                                    {
                                        $val = json_decode($row['percentage'], true);

                                        if($result >= $val['min'] && $result <= $val['max'] )
                                        {
                                            $class_name = $row['name'];
                                            break;
                                        }
                                    }

                                    ?>
                                    <tr style="text-align: center;">
                                        <td>
                                            <?=$item['first_name'].' '.$item['last_name']?>
                                        </td>
                                        <?php for ($i=1; $i <= $quantity_score; $i++):
                                        $name = 'score'.$i;?>
                                        <td>
                                            <?=$item[$name]?>
                                        </td>
                                        <?php endfor; ?>
                                        <td>
                                            <?=$class_name?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
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

<script type="text/javascript">
function get_level() {

    const weighting = <?=json_encode($placement_weighting)?>;

    var average = [];

    for (let i = 0; i < <?= $quantity_score ?>; i++) {
        name = 'score' + (i + 1);
        value = document.getElementById(name).value;
        average[i] = (value / weighting[name]);
    }

    var result = Math.round((eval(average.join('+')) / average.length) * 100);

    if (result >= 0 && result <= 20) {
        document.getElementById("suggested_level").innerHTML = "BEGINNERS";
    } else if (result >= 21 && result <= 40) {
        document.getElementById("suggested_level").innerHTML = "BASIC";
    } else if (result >= 41 && result <= 60) {
        document.getElementById("suggested_level").innerHTML = "INTERMEDIATE";
    } else if (result >= 61 && result <= 80) {
        document.getElementById("suggested_level").innerHTML = "ADVANCED";
    } else if (result >= 81 && result <= 100) {
        document.getElementById("suggested_level").innerHTML = "EXPERT I";
    }
}

$("#btnExport").click(function(e) {

    var reportName = '<?= getPhrase('tabulation_report').'_'.date('d-m-Y');?>';
    var a = document.createElement('a');
    var data_type = 'data:application/vnd.ms-excel;charset=utf-8';
    var table_html = $('#dvData')[0].outerHTML;
    table_html = table_html.replace(/<tfoot[\s\S.]*tfoot>/gmi, '');

    console.log(reportName);

    var css_html =
        '<style>td {border: 0.5pt solid #c0c0c0} .tRight { text-align:right} .tLeft { text-align:left} </style>';
    a.href = data_type + ',' + encodeURIComponent('<html><head>' + css_html + '</' + 'head><body>' +
        table_html + '</body></html>');
    a.download = reportName + '.xls';
    a.click();
    e.preventDefault();
});
</script>
<script>
function printDiv(nombreDiv) {
    var contenido = document.getElementById(nombreDiv).innerHTML;
    var contenidoOriginal = document.body.innerHTML;
    document.body.innerHTML = contenido;
    window.print();
    document.body.innerHTML = contenidoOriginal;
}
</script>