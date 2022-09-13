<?php

    $running_year = $this->crud->getInfo('running_year');

    if($country_id != '')
    {
        $this->db->where('country_id', $country_id);
    }
    if($type_id != '')
    {
        $this->db->where('type_id', $type_id);
    }
    if($status_id != '')
    {
        $this->db->where('status', $status_id);
    }
    if($name != '')
    {
        $this->db->like('full_name' , str_replace("%20", " ", $name));
    }
    $student_query = $this->db->get('v_applicants');
    $students = $student_query->result_array();

    
?>
<style>
    th {
        cursor: pointer;
    }
</style>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <ul class="navs navs-tabs upper">
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/admission_dashboard/">
                            <i class="os-icon picons-thin-icon-thin-0482_gauge_dashboard_empty"></i>
                            <span><?php echo getPhrase('dashboard');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links active" href="<?php echo base_url();?>admin/admission_applicants/">
                            <i class="os-icon picons-thin-icon-thin-0093_list_bullets"></i>
                            <span><?php echo getPhrase('applicants');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/admission_new_applicant/">
                            <i class="os-icon picons-thin-icon-thin-0716_user_profile_add_new"></i>
                            <span><?php echo getPhrase('new_applicant');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/admission_new_student/">
                            <i class="os-icon picons-thin-icon-thin-0706_user_profile_add_new"></i>
                            <span><?php echo getPhrase('new_student');?></span></a>
                    </li>
                </ul>
            </div>
        </div><br>
        <div class="container-fluid">
            <div class="content-i">
                <div class="content-box">
                    <div class="element-box-tp">
                        <h5 class="form-header"><?php echo getPhrase('applicant_report');?></h5>
                        <div class="row">
                            <div class="content-i">
                                <div class="content-box">
                                    <?php echo form_open(base_url() . 'admin/admission_applicants/', array('class' => 'form m-b'));?>
                                    <div class="row" style="margin-top: -30px; border-radius: 5px;">
                                        <div class="col-sm-3">
                                            <div class="form-group label-floating"
                                                style="border: 1px solid #EAEAF5;border-radius: 5px; background: white;">
                                                <label class="control-label"><?php echo getPhrase('name');?></label>
                                                <input class="form-control" name="name" type="text" value="<?= $name?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?php echo getPhrase('country');?></label>
                                                <div class="select">
                                                    <select name="country_id" onchange="get_class_sections(this.value)">
                                                        <option value=""><?php echo getPhrase('select');?></option>
                                                        <?php
                                                        $countries = $this->db->get('countries')->result_array();
                                                        foreach($countries as $row):
                                                    ?>
                                                        <option value="<?php echo $row['country_id'];?>"
                                                            <?php if($country_id == $row['country_id']) echo "selected";?>>
                                                            <?php echo $row['name'];?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?php echo getPhrase('type');?></label>
                                                <div class="select">
                                                    <select name="type_id">
                                                        <option value=""><?php echo getPhrase('select');?></option>
                                                        <?php
                                                        $type = $this->db->get('v_applicant_type')->result_array();
                                                        foreach($type as $row):
                                                    ?>
                                                        <option value="<?php echo $row['type_id'];?>"
                                                            <?php if($type_id == $row['type_id']) echo "selected";?>>
                                                            <?php echo $row['name'];?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?php echo getPhrase('status');?></label>
                                                <div class="select">
                                                    <select name="status_id">
                                                        <option value=""><?php echo getPhrase('select');?></option>
                                                        <?php
                                                        $status = $this->db->get('v_applicant_status')->result_array();
                                                        foreach($status as $row):
                                                            if($row['status_id'] != 3):
                                                    ?>
                                                        <option value="<?php echo $row['status_id'];?>"
                                                            <?php if($status_id == $row['status_id']) echo "selected";?>>
                                                            <?php echo $row['name'];?></option>
                                                        <?php endif; endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <button class="btn btn-success btn-upper" style="margin-top:20px"
                                                    type="submit"><span><?php echo getPhrase('search');?></span></button>
                                            </div>
                                        </div>
                                    </div>
                                    <?php echo form_close();?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="table-responsive">
                                <?php
                                if( $search == true || $name != '' || $type_id != "" || $status_id != "" || $country_id != ""):
                                    if($student_query->num_rows() > 0):
                                    ?>
                                <a href="#" id="btnExport" data-toggle="tooltip" data-placement="top"
                                    data-original-title="<?php echo getPhrase('download');?>">
                                    <button class="btn btn-info btn-sm btn-rounded">
                                        <i class="picons-thin-icon-thin-0123_download_cloud_file_sync"
                                            style="font-weight: 300; font-size: 25px;"></i>
                                    </button>
                                </a>
                                <br/>
                                <br/>
                                <table class="table table-padded" id="dvData">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><?php echo getPhrase('first_name')?></th>
                                            <th class="text-center"><?php echo getPhrase('last_name')?></th>
                                            <th class="text-center"><?php echo getPhrase('country')?></th>
                                            <th class="text-center"><?php echo getPhrase('email')?></th>
                                            <th class="text-center"><?php echo getPhrase('phone')?></th>
                                            <th class="text-center"><?php echo getPhrase('type')?></th>
                                            <th class="text-center"><?php echo getPhrase('status')?></th>
                                            <th class="text-center"><?php echo getPhrase('created_by')?></th>
                                            <th class="text-center"><?php echo getPhrase('updated_by')?></th>
                                            <th class="text-center"><?php echo getPhrase('assigned_to')?></th>
                                            <th class="text-center"><?php echo getPhrase('options')?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $students = $student_query->result_array();
                                            foreach($students as $row) :
                                                $allow_actions = is_student($row['applicant_id']);
                                        ?>
                                        <tr style="height:25px;">
                                            <td>
                                                <center>
                                                    <label style="width:55px; border: 1; text-align: center;">
                                                        <?php echo ($row['first_name']);?>
                                                    </label>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <label style="width:55px; border: 1; text-align: center;">
                                                        <?php echo ($row['last_name']);?>
                                                    </label>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <label style="width:55px; border: 1; text-align: center;">
                                                        <?php echo ($row['country_name']);?>
                                                    </label>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?php echo ($row['email']);?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?php echo ($row['phone']);?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <div class="value badge badge-pill"
                                                        style="background-color: <?= $row['applicant_type_color']?>;">
                                                        <?php echo ($row['applicant_type']);?>
                                                    </div>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <div class="value badge badge-pill"
                                                        style="background-color: <?= $row['status_color']?>;">
                                                        <?php echo ($row['status_name']);?>
                                                    </div>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?php echo ($row['created_by_name']);?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?php echo ($row['updated_by_name']);?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?php echo ($row['assigned_to_name']);?>
                                                </center>
                                            </td>
                                            <td class="row-actions">
                                                <a href="<?php echo base_url();?>admin/admission_applicant/<?= $row['applicant_id'];?>"
                                                    class="grey" data-toggle="tooltip" data-placement="top"
                                                    data-original-title="<?php echo getPhrase('view');?>">
                                                    <i
                                                        class="os-icon picons-thin-icon-thin-0043_eye_visibility_show_visible"></i>
                                                </a>
                                                <?php if(!$allow_actions):?>
                                                <a href="javascript:void(0);" class="grey" data-toggle="tooltip"
                                                    data-placement="top"
                                                    data-original-title="<?php echo getPhrase('add_interaction');?>"
                                                    onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_admission_add_interaction/<?= $row['applicant_id'];?>');">
                                                    <i class="os-icon picons-thin-icon-thin-0151_plus_add_new"></i>
                                                </a>
                                                <a href="javascript:void(0);" class="grey" data-toggle="tooltip"
                                                    data-placement="top"
                                                    data-original-title="<?php echo getPhrase('edit');?>"
                                                    onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_admission_edit_applicant/<?=$row['applicant_id'];?>');">
                                                    <i
                                                        class="os-icon picons-thin-icon-thin-0001_compose_write_pencil_new"></i>
                                                </a>
                                                <? endif;?>
                                            </td>
                                        </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                                <?php else:?>
                                <div class="bg-danger" style="border-radius: 10px">
                                    <div class="container">
                                        <div class="col-sm-12"><br><br>
                                            <h3 class="text-white"> <?= getPhrase('no_results_found');?></h3><br><br>
                                        </div>
                                    </div>
                                </div>
                                <?php endif;?>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('th').click(function () {
        var table = $(this).parents('table').eq(0)
        var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()))
        this.asc = !this.asc
        if (!this.asc) { rows = rows.reverse() }
        for (var i = 0; i < rows.length; i++) { table.append(rows[i]) }
    })
    function comparer(index) {
        return function (a, b) {
            var valA = getCellValue(a, index), valB = getCellValue(b, index)
            return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.toString().localeCompare(valB)
        }
    }
    function getCellValue(row, index) { return $(row).children('td').eq(index).text() }
</script>
<script>
$("#btnExport").click(function(e) {
    var reportName = '<?php echo getPhrase('applicants').'_'.date('d-m-Y');?>';
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