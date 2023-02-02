<?php 
    $running_year = $this->crud->getInfo('running_year');
    $running_semester = $this->crud->getInfo('running_semester');
    
    $user = $this->session->userdata('login_type')."-".$this->session->userdata('login_user_id');
    $teacher_id = $this->session->userdata('login_user_id');

    if($month_id === '')
    {
        $month_id = intval(date('m')) - 1;
    }

    $this->db->reset_query();
    $this->db->where('year', $running_year);
    $this->db->where('semester_id', $running_semester);    
    $this->db->where('month', $month_id);    
    $query = $this->db->get('v_student_month')->result_array();

    $has_best = $this->academic->student_month_has_best($month_id);
    
?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <ul class="navs navs-tabs upper">
                    <li class="navs-item">
                        <a class="navs-links active" href="<?php echo base_url();?>admin/student_month_dashboard/">
                            <i class="os-icon picons-thin-icon-thin-0482_gauge_dashboard_empty"></i>
                            <span><?php echo getPhrase('dashboard');?></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="content-box">
            <br>
            <div class="tab-content ">
                <div class="tab-pane active" id="students">
                    <div class="element-wrapper">
                        <h6 class="element-header">
                            <?php echo getPhrase('student_month');?>
                        </h6>
                        <br />
                        <br />
                        <?= form_open(base_url() . 'admin/student_month_dashboard/', array('class' => 'form m-b'));?>
                        <div class="row" style="margin-top: -30px; border-radius: 5px;">
                            <div class="col-sm-5">
                                <div class="form-group label-floating is-select">
                                    <label class="control-label"><?= getPhrase('month');?></label>
                                    <div class="select">
                                        <select name="month_id" id="month_id">
                                            <option month=""><?= getPhrase('select');?></option>
                                            <?php foreach(MONTH_LIST as $row): ?>
                                            <option value="<?= $row[0];?>"
                                                <?php if($month_id == $row[0]) echo "selected";?>>
                                                <?= $row[1];?>
                                            </option>
                                            <?php endforeach;?>
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
                        <div class="element-box-tp">
                            <div class="table-responsive">
                                <a href="#" id="btnExport" data-toggle="tooltip" data-placement="top"
                                    data-original-title="<?= getPhrase('download');?>">
                                    <button class="btn btn-info btn-sm btn-rounded">
                                        <i class="picons-thin-icon-thin-0123_download_cloud_file_sync"
                                            style="font-weight: 300; font-size: 25px;"></i>
                                    </button>
                                </a>
                                <a href="<?= base_url();?>PrintDocument/student_month_certificate_all/<?= base64_encode($month_id);?>"
                                    data-toggle="tooltip" data-placement="top"
                                    data-original-title="<?= getPhrase('print_all_certificate');?>">
                                    <button class="btn btn-info btn-sm btn-rounded">
                                        <i class="picons-thin-icon-thin-0333_printer"
                                            style="font-weight: 300; font-size: 25px;"></i>
                                    </button>
                                </a>
                                <table class="table table-padded" id="dvData">
                                    <thead>
                                        <tr>
                                            <th><?= getPhrase('class');?></th>
                                            <th><?= getPhrase('section');?></th>
                                            <th><?= getPhrase('subject');?></th>
                                            <th><?= getPhrase('modality');?></th>
                                            <th><?= getPhrase('teacher');?></th>
                                            <th><?= getPhrase('month');?></th>
                                            <th><?= getPhrase('student');?></th>
                                            <th><?= getPhrase('grade');?></th>
                                            <th><?= getPhrase('');?></th>
                                            <th><?= getPhrase('options');?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
        					                foreach($query as $row):
                                        ?>
                                        <tr>
                                            <td>
                                                <?= $row['class_name'];?>
                                            </td>
                                            <td>
                                                <?= $row['section_name'];?>
                                            </td>
                                            <td>
                                                <?= $row['subject_name'];?>
                                            </td>
                                            <td>
                                                <?php
                                                $modality = $this->academic->get_modality_of_subject($row['subject_id'], $row['year'], $row['semester_id']);
                                                echo $modality['name'];
                                                ?>
                                            </td>
                                            <td>
                                                <?= $row['teacher_name'];?>
                                            </td>
                                            <td>
                                                <?= get_month_name($row['month']);?>
                                            </td>
                                            <td>
                                                <?= $row['student_name'];?>
                                            </td>
                                            <td>
                                                <?php
                                                $grades = $this->academic->get_student_grades($row['student_id'], $row['year'], $row['semester_id']);
                                                echo $grades['mark'];
                                                ?>
                                            </td>
                                            <td class="row-actions">
                                                <?php 
                                                if($row['is_best'] == 1) {
                                                    echo '<i class="os-icon picons-thin-icon-thin-0658_cup_place_winner_award_prize_achievement"></i>';
                                                }
                                                ?>
                                            </td>
                                            <td class="row-actions">
                                                <a href="<?= base_url();?>PrintDocument/student_month_certificate/<?= base64_encode($row['student_month_id']);?>"
                                                    target="_blank" class="grey" data-toggle="tooltip"
                                                    data-placement="top"
                                                    data-original-title="<?= getPhrase('print_certificate');?>">
                                                    <i
                                                        class="os-icon picons-thin-icon-thin-0666_award_achievement_prize_medal"></i>
                                                </a>
                                                <?php if(!$has_best && has_permission('approve_best_student_month')):?>
                                                <a href="<?= base_url();?>admin/student_month_action/best/<?= $row['student_month_id'];?>"
                                                    class="grey" data-toggle="tooltip" data-placement="top"
                                                    onClick="return confirm('<?php echo getPhrase('confirm_student_month');?>')"
                                                    data-original-title="<?= getPhrase('confirm_student_month');?>">
                                                    <i
                                                        class="os-icon picons-thin-icon-thin-0659_medal_first_place_winner_award_prize_achievement"></i>
                                                </a>
                                                <?php endif;?>
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
    <div class="display-type"></div>
</div>


<script type="text/javascript">
$("#btnExport").click(function(e) {
    var reportName = '<?= getPhrase('student_month').'_'.date('d-m-Y');?>';
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