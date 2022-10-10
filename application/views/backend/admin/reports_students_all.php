<?php 
	// $period =  $this->db->get_where( 'settings', array( 'type' => 'running_period' ) )->row()->description;
	// $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;?>
<style type="text/css">
.titulosincss {
    text-align: center;
    font-weight: bold;
}

.imagen {
    position: absolute;
    right: 5px;
    top: 10px;
}

.mediano {
    font-size: 11px;
}

.grande {
    font-size: 13px;
}

.tablatitulo {
    padding: 10px 0;
}

td.descripcion {
    font-weight: bold;
}

td.nota {
    text-align: center;
}

td.notapromedio {
    text-align: center;
    font-weight: bold;
    padding: 3px;
}

td.notapromediofinal {
    text-align: center;
    font-weight: bold;
    font-size: 14px;
    padding: 5px;
}

.firmadirector {
    padding: 40px 0 20px 0;
    font-weight: bold;
    float: right;
    width: 300px;
}

.firma {
    border-bottom: 1px solid #000;
}

.firmadirector .texto {
    text-align: center;
}

table {
    width: 100%;
}

.negrita {
    font-weight: bold;
}

.cuadro {
    width: 100%;
}

.min-width {
    min-width: 150px;
}
</style>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <ul class="navs navs-tabs">
                    <li class="navs-item">
                        <a class="navs-links" href="<?= base_url();?>admin/reports_general/"><i
                                class="picons-thin-icon-thin-0658_cup_place_winner_award_prize_achievement"></i>
                            <span><?= getPhrase('classes');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links <?php if($page_name == 'reports_students') echo "active";?>"
                            href="<?= base_url();?>admin/reports_students/"><i
                                class="picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i>
                            <span><?= getPhrase('students');?></span></a>
                    </li>
                    <?php if(!$useGradeAttendance): ?>
                    <li class="navs-item">
                        <a class="navs-links" href="<?= base_url();?>admin/attendance_report/"><i
                                class="os-icon picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i>
                            <span><?= getPhrase('attendance');?></span></a>
                    </li>
                    <?php endif;?>
                    <li class="navs-item">
                        <a class="navs-links" href="<?= base_url();?>admin/reports_marks/"><i
                                class="picons-thin-icon-thin-0100_to_do_list_reminder_done"></i>
                            <span><?= getPhrase('final_marks');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?= base_url();?>admin/reports_tabulation/"><i
                                class="picons-thin-icon-thin-0070_paper_role"></i>
                            <span><?= getPhrase('tabulation_sheet');?></span></a>
                    </li>
                    <?php if($accounting_report == 'true'):?>
                    <li class="navs-item">
                        <a class="navs-links" href="<?= base_url();?>admin/reports_accounting/"><i
                                class="picons-thin-icon-thin-0406_money_dollar_euro_currency_exchange_cash"></i>
                            <span><?= getPhrase('accounting');?></span></a>
                    </li>
                    <?php endif;?>
                </ul>
            </div>
        </div>
        <div class="content-i">
            <div class="content-box">
                <h5 class="form-header"><?= getPhrase('tabulation_sheet');?></h5>
                <hr>
                <?= form_open(base_url() . 'admin/reports_students_all/', array('class' => 'form m-b'));?>
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
                        <div class="form-group label-floating is-select">
                            <label class="control-label"><?= getPhrase('semester');?></label>
                            <div class="select">
                                <select name="semester_id" id="semester_id" required="">
                                    <option value=""><?= getPhrase('select');?></option>
                                    <?php 
                                        $semesters = $this->db->get('semesters')->result_array();
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
                <?php if($year_id != "" && $semester_id != ""):?>
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
                    <div class="cuadro" id="print_area" style="overflow-x: auto; height: 500px;">
                        <table cellpading="0" cellspacing="0" border="1"
                            style="margin: 20px 0; width:100%; table-layout: fixed;overflow-wrap: break-word;"
                            class="bg-white" id="dvData">
                            <tr class="text-center" style="background-color: #a01a7a; color: #fff;text-align: center;">
                                <th>#</th>
                                <th>
                                    <?= getPhrase('first_name');?>
                                </th>
                                <th>
                                    <?= getPhrase('last_name');?>
                                </th>
                                <th class="min-width">
                                    <?= getPhrase('birthday');?>
                                </th>
                                <th class="min-width">
                                    <?= getPhrase('age');?>
                                </th>
                                <th class="min-width">
                                    <?= getPhrase('gender');?>
                                </th>
                                <th class="min-width">
                                    <?= getPhrase('address');?>
                                </th>
                                <th class="min-width">
                                    <?= getPhrase('phone');?>
                                </th>
                                <th class="min-width">
                                    <?= getPhrase('email');?>
                                </th>
                                <th class="min-width">
                                    <?= getPhrase('program');?>
                                </th>
                                <th class="min-width">
                                    <?= getPhrase('status');?>
                                </th>
                                <th class="min-width">
                                    <?= getPhrase('type_student');?>
                                </th>
								<th class="min-width">
                                    <?= getPhrase('last_semester');?>
                                </th>
								<th class="min-width">
                                    <?= getPhrase('last_level');?>
                                </th>
								<th class="min-width">
                                    <?= getPhrase('current_semester');?>
                                </th>
								<th class="min-width">
                                    <?= getPhrase('current_level');?>
                                </th>
								<th class="min-width">
                                    <?= getPhrase('current_section');?>
                                </th>
								<th class="text-center min-width">
                                    <?= getPhrase('current_grade');?>
                                </th>
                                <th class="min-width">
                                    <?= getPhrase('semesters');?>
                                </th>
                            </tr>
                            <tbody style=" overflow: scroll;">
                                <?php

								$students = $this->db->get('student')->result_array();
								$n = 1;
								foreach($students as $row):
							?>
                                <tr class="text-center" id="student-<?= $row['student_id'];?>">
                                    <td>
                                        <?= $n++;?>
                                    </td>
                                    <td>
                                        <?= $row['first_name'];?>
                                    </td>
                                    <td>
                                        <?= $row['last_name'];?>
                                    </td>
                                    <td>
                                        <?= $row['birthday'];?>
                                    </td>
                                    <td>
                                        <?= calculate_age($row['birthday']);?>
                                    </td>
                                    <td>
                                        <?= $row['sex'];?>
                                    </td>
                                    <td>
                                        <?= $row['address'];?>
                                    </td>
                                    <td>
                                        <?= $row['phone'];?>
                                    </td>
                                    <td>
                                        <?= $row['email'];?>
                                    </td>
                                    <td>
                                        <?= $this->crud->get_student_program($row['student_id']);?>
                                    </td>
                                    <td>
                                        <?= $row['student_session'];?>
                                    </td>
                                    <td class="text-center">
                                        <?= $row['class_name'];?></label>
                                    </td>
                                    <td class="text-center">
                                        <?= $row['section_name'];?></label>
                                    </td>
                                    <td class="text-center"><?= $mark;?></td>
                                </tr>
                            </tbody>
                            <?php endforeach;?>
                        </table>
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