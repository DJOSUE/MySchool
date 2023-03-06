<?php 
    $min        = floatval($this->crud->getInfo('minium_mark'));
    $programs   = $this->db->get('program')->result_array();
    $semesters  = $this->db->get('semesters')->result_array();
    $classes    = $this->db->get_where('class', array('status' => 1))->result_array();
?>

<link href="<?php echo base_url();?>public/style/print/report.css" media="all" rel="stylesheet">

<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <?php include 'reports__menu.php';?>
        </div>
        <div class="content-i">
            <div class="content-box">
                <h5 class="form-header"><?= getPhrase('tabulation_sheet');?></h5>
                <hr>
                <?= form_open(base_url() . 'admin/report_students_achievement/', array('class' => 'form m-b'));?>
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group label-floating is-select">
                            <label class="control-label"><?= getPhrase('year');?></label>
                            <div class="select">
                                <select name="year_id" id="year_id" required="" onchange="get_class_sections();">
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
                        <div class="form-group">
                            <button class="btn btn-success btn-upper" style="margin-top:20px"
                                type="submit"><span><?= getPhrase('get_report');?></span></button>
                        </div>
                    </div>
                </div>
                <?= form_close();?>
                <hr>
                <?php if($year_id != ""):?>
                <div id="pass">
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
                                    <tr class="text-center"
                                        style="background-color: #a01a7a; color: #fff;text-align: center;">
                                        <th rowspan="2">
                                            <?= getPhrase('pass_rates');?>
                                        </th>
                                        <?php 
                                    $class_total = [];                                                                    
                                    foreach ($classes as $class) :
                                        $data = array('total' => 0, 'pass' => 0);
                                        $class_total[$class['name']] = $data;
                                    ?>
                                        <th colspan="3">
                                            <?= $class['name'];?>
                                        </th>
                                        <?php endforeach;?>
                                        <th colspan="3">
                                            <?= getPhrase('total');?>
                                        </th>
                                    </tr>
                                    <tr class="text-center"
                                        style="background-color: #a01a7a; color: #fff;text-align: center;">

                                        <?php                                 
                                    foreach ($classes as $class) :
                                    ?>
                                        <th>
                                            #stu
                                        </th>
                                        <th>
                                            #pass
                                        </th>
                                        <th>
                                            %pass
                                        </th>
                                        <?php endforeach;?>
                                        <th>
                                            #stu
                                        </th>
                                        <th>
                                            #pass
                                        </th>
                                        <th>
                                            %pass
                                        </th>
                                    </tr>
                                </thead>

                                <tbody style=" overflow: scroll;">
                                    <?php
                                    $semesters = $this->db->get('semesters')->result_array();
                                    
                                    foreach($semesters as $semester):
                                    ?>
                                    <tr class="text-center">
                                        <td>
                                            <?= $semester['name'];?>
                                        </td>
                                        <?php
                                        $total_students = 0;
                                        $total_pass = 0;

                                        foreach ($classes as $class) :                                        
                                            $nro_students = $this->academic->get_total_student_class($class['class_id'], $year_id, $semester['semester_id']);
                                            $nro_pass = $this->academic->get_pass_student_class($class['class_id'], $year_id, $semester['semester_id']);

                                            $total_students += $nro_students;
                                            $total_pass     += $nro_pass;

                                            // $data = array('total' => 0, 'pass' => 0);

                                            $class_total[$class['name']]['total'] += $nro_students;
                                            $class_total[$class['name']]['pass'] += $nro_pass;

                                            $percentage = $nro_students > 1 ? round(($nro_pass / $nro_students) * 100) : 0;
                                        ?>
                                        <td>
                                            <?= $nro_students?>
                                        </td>
                                        <td>
                                            <?= $nro_pass?>
                                        </td>
                                        <td>
                                            <?= $percentage?> %
                                        </td>
                                        <?php endforeach;?>
                                        <td>
                                            <?= $total_students?>
                                        </td>
                                        <td>
                                            <?= $total_pass?>
                                        </td>
                                        <td>
                                            <?= $total_students > 1 ? round(($total_pass / $total_students) * 100) : 0?>
                                            %
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                    <tr class="text-center">
                                        <td>
                                            <?= $year_id;?>
                                        </td>
                                        <?php
                                        $total_students = 0;
                                        $total_pass = 0;
                                        foreach ($classes as $class) :
                                            $total_students += $class_total[$class['name']]['total'];
                                            $total_pass += $class_total[$class['name']]['pass'];
                                        ?>
                                        <td>
                                            <?= $class_total[$class['name']]['total']?>
                                        </td>
                                        <td>
                                            <?= $class_total[$class['name']]['pass']?>
                                        </td>
                                        <td>
                                            <?= $class_total[$class['name']]['total'] > 1 ? round(($class_total[$class['name']]['pass'] / $class_total[$class['name']]['total']) * 100) : 0?>
                                            %
                                        </td>
                                        <?php endforeach;?>
                                        <td>
                                            <?= $total_students?>
                                        </td>
                                        <td>
                                            <?= $total_pass?>
                                        </td>
                                        <td>
                                            <?= $total_students > 1 ? round(($total_pass / $total_students) * 100) : 0?>
                                            %
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <hr>
                <div id="type_total">
                    <div class="row"><br><br>
                        <a href="#" id="btnExport_2">
                            <button class="btn btn-info btn-sm btn-rounded">
                                <i class="picons-thin-icon-thin-0123_download_cloud_file_sync"
                                    style="font-weight: 300; font-size: 25px;"></i>
                            </button>
                        </a>
                        <a href="#" id="print_2">
                            <button class="btn btn-info btn-sm btn-rounded" onclick="printDiv('print_area_2');">
                                <i class="picons-thin-icon-thin-0333_printer"
                                    style="font-weight: 300; font-size: 25px;"></i>
                            </button>
                        </a>
                    </div>
                    <div class="row">
                        <br><br>
                        <div class="cuadro" id="print_area_2">
                            <table cellpading="0" cellspacing="0" border="1"
                                style="margin: 20px 0; width:100%; table-layout: fixed;overflow-wrap: break-word;"
                                class="bg-white" id="dvData_2">
                                <thead>
                                    <tr class="text-center"
                                        style="background-color: #a01a7a; color: #fff;text-align: center;">
                                        <th>

                                        </th>
                                        <?php 
                                        foreach($programs as $program):
                                        ?>
                                        <th>
                                            <?= $program['name'];?>
                                        </th>
                                        <?php endforeach;?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $semesters = $this->db->get('semesters')->result_array();                                    
                                    foreach($semesters as $semester):
                                        
                                    ?>
                                    <tr>
                                        <td>
                                            <?= $semester['name']?>
                                        </td>
                                        <?php 
                                        foreach($programs as $program):
                                        ?>
                                        <td>

                                            <?= $this->academic->get_total_student_type($program['program_id'], $year_id, $semester['semester_id']);?>
                                        </td>
                                        <?php endforeach;?>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <hr>
                <div id="finished">
                    <div class="row"><br><br>
                        <a href="#" id="btnExport_2"><button class="btn btn-info btn-sm btn-rounded"><i
                                    class="picons-thin-icon-thin-0123_download_cloud_file_sync"
                                    style="font-weight: 300; font-size: 25px;"></i></button>
                        </a>
                        <a href="#" id="print_2"><button class="btn btn-info btn-sm btn-rounded"
                                onclick="printDiv('print_area_2');"><i class="picons-thin-icon-thin-0333_printer"
                                    style="font-weight: 300; font-size: 25px;"></i></button>
                        </a>
                    </div>
                    <div class="row">
                        <br><br>
                        <div class="cuadro" id="print_area_2">
                            <table cellpading="0" cellspacing="0" border="1"
                                style="margin: 20px 0; width:100%; table-layout: fixed;overflow-wrap: break-word;"
                                class="bg-white" id="dvData_2">
                                <thead>
                                    <tr class="text-center"
                                        style="background-color: #a01a7a; color: #fff;text-align: center;">
                                        <th rowspan="2">

                                        </th>
                                        <?php                                         
                                        foreach($semesters as $semester):
                                        ?>
                                        <th colspan="2">
                                            <?= $semester['name'];?>
                                        </th>
                                        <?php endforeach;?>
                                    </tr>
                                    <tr class="text-center"
                                        style="background-color: #a01a7a; color: #fff;text-align: center;">

                                        <?php                                         
                                        foreach($semesters as $semester):
                                        ?>
                                        <th>
                                            Register
                                        </th>
                                        <th>
                                            Finished
                                        </th>
                                        <?php endforeach;?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($classes as $class):                                        
                                    ?>
                                    <tr class="text-center">
                                        <td>
                                            <?= $class['name']?>
                                        </td>
                                        <?php 
                                        foreach($semesters as $semester):
                                        ?>
                                        <td>
                                            <?= $this->academic->get_total_student_class($class['class_id'], $year_id, $semester['semester_id']);?>
                                        </td>
                                        <td>
                                            <?= $this->academic->get_total_student_class_semester_finished( $class['class_id'], $year_id, $semester['semester_id']);?>
                                        </td>
                                        <?php endforeach;?>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <hr>
                <div id="">
                    <div class="row"><br><br>
                        <a href="#" id="btnExport_2">
                            <button class="btn btn-info btn-sm btn-rounded">
                                <i class="picons-thin-icon-thin-0123_download_cloud_file_sync"
                                    style="font-weight: 300; font-size: 25px;"></i>
                            </button>
                        </a>
                        <a href="#" id="print_2">
                            <button class="btn btn-info btn-sm btn-rounded" onclick="printDiv('print_area_2');"><i
                                    class="picons-thin-icon-thin-0333_printer"
                                    style="font-weight: 300; font-size: 25px;"></i>
                            </button>
                        </a>
                    </div>
                    <div class="row">
                        <table cellpading="0" cellspacing="0" border="1"
                            style="margin: 20px 0; width:100%; table-layout: fixed;overflow-wrap: break-word;"
                            class="bg-white" id="dvData_2">
                            <thead>
                                <tr class="text-center"
                                    style="background-color: #a01a7a; color: #fff;text-align: center;">
                                    <th>Semester</th>
                                    <th>Total Students</th>
                                    <th>95% - 96%</th>
                                    <th>97% - 98%</th>
                                    <th>99% - 100%</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                foreach($semesters as $semester):
                                    $total = $this->academic->get_total_student_semester($year_id, $semester['semester_id']);
                                ?>
                                <tr class="text-center">
                                    <td>
                                        <?=$semester['name']?>
                                    </td>
                                    <td>
                                        <?=$total?>
                                    </td>
                                    <td>
                                        <?=$this->academic->get_student_approved($year_id, $semester['semester_id'],95,96);?>
                                    </td>
                                    <td>
                                        <?=$this->academic->get_student_approved($year_id, $semester['semester_id'],97,98);?>
                                    </td>
                                    <td>
                                        <?=$this->academic->get_student_approved($year_id, $semester['semester_id'],99,100);?>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif;?>
        </div>
    </div>
</div>
</div>

<script type="text/javascript">
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