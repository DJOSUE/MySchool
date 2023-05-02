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
    $absence = $this->db->get('v_mark_daily')->result_array();

?>
<?php include $view_path.'_data_table_dependency.php';?>
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
                                <div class="element-box-tp">
                                    <div class="table-responsive">
                                        <table class="table table-padded" id="dvData" style="width: 100%;">
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
                                                    <th class="orderby"><?= getPhrase('dates');?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach($absence as $row):
                                                        $this->db->reset_query();
                                                        $this->db->where('subject_id', $row['subject_id']);
                                                        $subject_info = $this->db->get('v_subject')->row_array();

                                                        $this->db->reset_query();
                                                        $this->db->select('date');
                                                        $this->db->where('date >=', $startDate);
                                                        $this->db->where('date <=', $endDate);
                                                        $this->db->where('labuno', '0');
                                                        $this->db->where('student_id', $row['student_id']);
                                                        $this->db->where('class_id', $row['class_id']);
                                                        $this->db->where('section_id', $row['section_id']);
                                                        $this->db->where('subject_id', $row['subject_id']);
                                                        $this->db->group_by('student_id, class_id, section_id, subject_id, date');
                                                        $this->db->order_by('first_name');
                                                        $dates = $this->db->get('v_mark_daily')->result_array();
                                                        
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
                                                    <td>
                                                        <?php
                                                        foreach ($dates as $item) {
                                                            echo $item['date'].'<br/>';
                                                        }
                                                        ?>
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
var table = $('#dvData').DataTable({
    dom: 'Bflrtip',
    lengthMenu: [
        [10, 20, 50, -1],
        [10, 20, 50, "All"]
    ],
    pageLength: 20,
    buttons: [{
        extend: 'excelHtml5',
        text: '<i class="picons-thin-icon-thin-0123_download_cloud_file_sync" style="font-size: 20px;"></i>',
        titleAttr: 'Export to Excel'
    }]
});

$("select[name='dvData_length']" ).addClass('select-page');;

</script>
