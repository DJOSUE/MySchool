<?php 
    $running_year       = $this->crud->getInfo('running_year');
    $running_semester   = $this->crud->getInfo('running_semester'); 

    $startDate  = date_format(date_create($start_date), "Y-m-d");
    $endDate    = date_format(date_create($end_date), "Y-m-d");

    $this->db->reset_query();
    $this->db->select('student_id, first_name, last_name, phone, email,class_id, class_name, section_id, section_name, subject_id, subject_name, count(date) as absence');
    $this->db->where('date >=', $startDate);
    $this->db->where('date <=', $endDate);
    $this->db->where('labuno', '0');
    $this->db->group_by('student_id, class_id, section_id, subject_id');
    $this->db->order_by('first_name');
    $payments = $this->db->get('v_mark_daily')->result_array();

?>
<div class="content-w">
    <?php include  $fancy_path.'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <?php include "academic__nav.php";?>
            </div>
        </div><br>
        <div class="content-i">
            <div class="content-box">
                <div class="element-wrapper">
                    <div class="tab-content">
                        <?= form_open(base_url() . 'reports/academic_absence/');?>
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
                        <br />
                        <div class="tab-pane active" id="invoices">
                            <div class="element-wrapper">
                                <div>
                                    <a href="#" id="btnExport"><button class="btn btn-info btn-sm btn-rounded"><i
                                                class="picons-thin-icon-thin-0123_download_cloud_file_sync"
                                                style="font-weight: 300; font-size: 25px;"></i></button>
                                    </a>
                                </div>
                                <div class="element-box-tp">
                                    <div class="table-responsive">
                                        <table class="table table-padded" id="dvData">
                                            <thead>
                                                <tr>
                                                    <th class="orderby"><?= getPhrase('student');?></th>
                                                    <th class="orderby"><?= getPhrase('phone');?></th>
                                                    <th class="orderby"><?= getPhrase('email');?></th>
                                                    <th class="orderby"><?= getPhrase('class');?></th>
                                                    <th class="orderby"><?= getPhrase('section');?></th>
                                                    <th class="orderby"><?= getPhrase('subject');?></th>
                                                    <th class="orderby"><?= getPhrase('modality');?></th>
                                                    <th class="orderby"><?= getPhrase('teacher');?></th>
                                                    <th class="orderby"># <?= getPhrase('absence');?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach($payments as $row):
                                                        $this->db->reset_query();
                                                        $this->db->where('subject_id', $row['subject_id']);
                                                        $subject_info = $this->db->get('v_subject')->row_array();
                                                        
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?=  $row['first_name'] .''. $row['last_name']; ?>
                                                    </td>
                                                    <td>
                                                        <?=  $row['phone'] ?>
                                                    </td>
                                                    <td>
                                                        <?=  $row['email'] ?>
                                                    </td>
                                                    <td>
                                                        <?=  $row['class_name'] ?>
                                                    </td>
                                                    <td>
                                                        <?=  $row['section_name'] ?>
                                                    </td>
                                                    <td>
                                                        <?=  $row['subject_name'] ?>
                                                    </td>
                                                    <td>
                                                    <?=  $subject_info['modality_name'] ?>
                                                    </td>
                                                    <td>
                                                    <?=  $subject_info['teacher_name'] ?>
                                                    </td>
                                                    <td>
                                                        <?=  $row['absence'] ?>
                                                    </td>

                                                </tr>
                                                <?php endforeach;?>
                                            </tbody>
                                        </table>
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
<script>
$("#btnExport").click(function(e) {
    var reportName = '<?php echo getPhrase('reports_tabulation').'_'.date('d-m-Y');?>';
    var a = document.createElement('a');
    var data_type = 'data:application/vnd.ms-excel;charset=utf-8';
    var table_html = $('#dvData')[0].outerHTML;
    table_html = table_html.replace(/<tfoot[\s\S.]*tfoot>/gmi, '');
    var css_html =
        '<style>td {border: 0.5pt solid #c0c0c0} .tRight { text-align:right} .tLeft { text-align:left} </style>';
    a.href = data_type + ',' + encodeURIComponent('<html><head>' + css_html + '</' + 'head><body>' +
        table_html + '</body></html>');
    a.download = reportName + '.xls';
    a.click();
    e.preventDefault();
});
</script>

<script type="text/javascript">
$('.orderby').click(function() {
    var table = $(this).parents('table').eq(0)
    var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()))
    this.asc = !this.asc
    if (!this.asc) {
        rows = rows.reverse()
    }
    for (var i = 0; i < rows.length; i++) {
        table.append(rows[i])
    }
})

function comparer(index) {
    return function(a, b) {
        var valA = getCellValue(a, index),
            valB = getCellValue(b, index)
        return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.toString().localeCompare(valB)
    }
}

function getCellValue(row, index) {
    return $(row).children('td').eq(index).text()
}
</script>