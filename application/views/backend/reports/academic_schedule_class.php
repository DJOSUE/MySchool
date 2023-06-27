<?php 
    $classes = $this->academic->get_classes_by_semester($year_id, $semester_id);
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
            <div class="content-box">
                <?= form_open(base_url() . 'reports/academic_schedule_class/', array('class' => 'form m-b'));?>
                <div class="row">
                    <div class="col col-lg-3 col-md-3 col-sm-12 col-12">
                        <div class="form-group label-floating is-select">
                            <label class="control-label"><?= getPhrase('filter_by_year');?></label>
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
                    <div class="col col-lg-3 col-md-3 col-sm-12 col-12">
                        <div class="form-group label-floating is-select">
                            <label class="control-label"><?php echo getPhrase('filter_by_semester');?></label>
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
                <?php
                // echo '<pre>';
                // var_dump($classes);
                // echo '</pre>';
                ?>
                <div class="element-wrapper">
                    <div class="element-box table-responsive lined-primary shadow" id="print_area<?= $row['section_id'];?>">
                        <div class="row m-b">
                            <div style="padding-left:20px;display:inline-block;">
                                <h5><?= getPhrase('schedule_level');?></h5>
                            </div>
                        </div>
                        <div class="row m-b" style="padding-left:20px;display:inline-block;">
                            <a href="#">
                                <button id="btnExport" class="btn btn-info btn-sm btn-rounded">
                                    <i class="picons-thin-icon-thin-0123_download_cloud_file_sync"
                                        style="font-weight: 300; font-size: 25px;"></i>
                            </a>
                            <a href="#" id="print">
                                <button class="btn btn-info btn-sm btn-rounded" onclick="printDiv('print_area');">
                                    <i class="picons-thin-icon-thin-0333_printer"
                                        style="font-weight: 300; font-size: 25px;"></i>
                                </button>
                            </a>
                        </div>
                        <div>
                            <table id="dvData" class="table table-bordered table-schedule table-hover" cellpadding="0"
                                cellspacing="0" width="100%">
                                <thead>
                                    <tr class="text-center">
                                        <th>
                                            <?= getPhrase('id');?>
                                        </th>
                                        <th>
                                            <?= getPhrase('class');?>
                                        </th>
                                        <th>
                                            <?= getPhrase('schedule');?>
                                        </th>
                                        <th>
                                            <?= getPhrase('subject');?>
                                        </th>
                                        <th>
                                            <?= getPhrase('modality');?>
                                        </th>
                                        <th>
                                            <?= getPhrase('teacher');?>
                                        </th>
                                        <th>
                                            # <?= getPhrase('classroom');?>
                                        </th>
                                        <th>
                                            # <?= getPhrase('students');?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($classes as $item):?>
                                    <tr class="text-center">
                                        <td>
                                            <?=$item['subject_id']?>
                                        </td>
                                        <td>
                                            <?=$item['class_name']?>
                                        </td>
                                        <td>
                                            <?=$item['section_name']?>
                                        </td>
                                        <td>
                                            <?=$item['name']?>
                                        </td>
                                        <td>
                                            <?= $this->academic->get_modality_name($item['modality_id'])?>
                                        </td>
                                        <td>
                                            <?=$item['teacher_name']?>
                                        </td>
                                        <td>
                                            <?=$item['classroom']?>
                                        </td>
                                        <td>
                                            <?=$this->academic->countStudentsSubject($item['class_id'], $item['section_id'], $item['subject_id']);?>
                                        </td>

                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <button class="btn btn-rounded btn-primary pull-right"
                        onclick="printDiv('print_area')"><?= getPhrase('print');?>
                    </button>
                    <br><br><br>
                </div>

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

function printDiv(nombreDiv) {
    var contenido = document.getElementById(nombreDiv).innerHTML;
    var contenidoOriginal = document.body.innerHTML;
    document.body.innerHTML = contenido;
    window.print();
    document.body.innerHTML = contenidoOriginal;
}
</script>