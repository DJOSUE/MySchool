<?php

    $running_year = $this->crud->getInfo('running_year');
    $user_id = $this->session->userdata('login_user_id');

    if($start_date != '')
    {
        $this->db->where('created_at >=', $start_date);       
    }
    if($end_date != '')
    {        
        $this->db->where('created_at <=', $end_date);
    }
    if($advisor_id != '')
    {
        $this->db->where('created_by', $advisor_id);
    }   
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
    if($tag_id != '')
    {
        $this->db->like('tags',$tag_id, 'both');
    }
    if($assigned_me == 1)
    {
        $this->db->where('assigned_to' , $user_id);
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
            <? include 'admission__nav.php';?>
        </div><br>
        <div class="container-fluid">
            <div class="content-i">
                <div class="content-box">
                    <div class="element-box-tp">
                        <h5 class="form-header"><?= getPhrase('applicant_report');?></h5>
                        <div class="row">
                            <div class="content-i">
                                <div class="content-box">
                                    <?= form_open(base_url() . 'admin/admission_applicants/', array('class' => 'form m-b'));?>
                                    <div class="row" style="margin-top: -30px; border-radius: 5px;">
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating"
                                                style="border: 1px solid #EAEAF5;border-radius: 5px; background: white;">
                                                <label class="control-label"><?= getPhrase('name');?></label>
                                                <input class="form-control" name="name" type="text" value="<?= $name?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?= getPhrase('country');?></label>
                                                <div class="select">
                                                    <select name="country_id" onchange="get_class_sections(this.value)">
                                                        <option value=""><?= getPhrase('select');?></option>
                                                        <?php
                                                        $countries = $this->db->get('countries')->result_array();
                                                        foreach($countries as $row):
                                                    ?>
                                                        <option value="<?= $row['country_id'];?>"
                                                            <?php if($country_id == $row['country_id']) echo "selected";?>>
                                                            <?= $row['name'];?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?= getPhrase('type');?></label>
                                                <div class="select">
                                                    <select name="type_id">
                                                        <option value=""><?= getPhrase('select');?></option>
                                                        <?php
                                                        $type = $this->db->get('v_applicant_type')->result_array();
                                                        foreach($type as $row):
                                                    ?>
                                                        <option value="<?= $row['type_id'];?>"
                                                            <?php if($type_id == $row['type_id']) echo "selected";?>>
                                                            <?= $row['name'];?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?= getPhrase('status');?></label>
                                                <div class="select">
                                                    <select name="status_id">
                                                        <option value=""><?= getPhrase('select');?></option>
                                                        <?php
                                                        $status = $this->db->get('v_applicant_status')->result_array();
                                                        foreach($status as $row):                                                            
                                                    ?>
                                                        <option value="<?= $row['status_id'];?>"
                                                            <?php if($status_id == $row['status_id']) echo "selected";?>>
                                                            <?= $row['name'];?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?= getPhrase('tags');?></label>
                                                <div class="select">
                                                    <select name="tag_id">
                                                        <option value=""><?= getPhrase('select');?></option>
                                                        <?php
                                                        $tags = $this->applicant->get_tags();
                                                        foreach($tags as $tag):
                                                            
                                                    ?>
                                                        <option value="<?= $tag['tag_id'];?>"
                                                            <?php if($tag_id == $tag['tag_id']) echo "selected";?>>
                                                            <?= $tag['name'];?></option>
                                                        <?php  endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?= getPhrase('advisor');?></label>
                                                <div class="select">
                                                    <select name="advisor_id">
                                                        <option value=""><?= getPhrase('select');?></option>
                                                        <?php
                                                        $tags = $this->user->get_advisor();
                                                        foreach($tags as $tag):
                                                            
                                                    ?>
                                                        <option value="<?= $tag['admin_id'];?>"
                                                            <?php if($advisor_id == $tag['admin_id']) echo "selected";?>>
                                                            <?= $tag['first_name'].' '.$tag['last_name'];?></option>
                                                        <?php  endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating is-select"
                                                style="background-color: #fff;">
                                                <label class="control-label"><?= getPhrase('start_date');?></label>
                                                <div class="form-group date-time-picker">
                                                    <input type="text" autocomplete="off" class="datepicker-here"
                                                        data-position="bottom left" data-language='en' name="start_date"
                                                        id="start_date" value="<?=$start_date?>">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating is-select"
                                                style="background-color: #fff;">
                                                <label class="control-label"><?= getPhrase('end_date');?></label>
                                                <div class="form-group date-time-picker">
                                                    <input type="text" autocomplete="off" class="datepicker-here"
                                                        data-position="bottom left" data-language='en' name="end_date"
                                                        id="end_date" value="<?=$end_date?>">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="description-toggle">
                                                <div class="description-toggle-content">
                                                    <div class="h6"><?= getPhrase('assigned_to_me');?></div>
                                                </div>
                                                <div class="togglebutton">
                                                    <label><input name="assigned_me" value="1" type="checkbox"
                                                            <?php if($assigned_me == 1) echo "checked";?>></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>                                        
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <button class="btn btn-success btn-upper"
                                                    type="submit"><span><?= getPhrase('search');?></span></button>
                                                <a href="/admin/admission_applicants_assignation/"
                                                    class="btn btn-info btn-upper">Bulk assignment
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <?= form_close();?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="table-responsive">
                                <?php
                                    if($student_query->num_rows() > 0):
                                    ?>
                                <a href="#" id="btnExport" data-toggle="tooltip" data-placement="top"
                                    data-original-title="<?= getPhrase('download');?>">
                                    <button class="btn btn-info btn-sm btn-rounded">
                                        <i class="picons-thin-icon-thin-0123_download_cloud_file_sync"
                                            style="font-weight: 300; font-size: 25px;"></i>
                                    </button>
                                </a>
                                <br />
                                <br />
                                <table class="table table-padded" id="dvData">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><?= getPhrase('first_name')?></th>
                                            <th class="text-center"><?= getPhrase('last_name')?></th>
                                            <th class="text-center"><?= getPhrase('country')?></th>
                                            <th class="text-center"><?= getPhrase('email')?></th>
                                            <th class="text-center"><?= getPhrase('phone')?></th>
                                            <th class="text-center"><?= getPhrase('type')?></th>
                                            <th class="text-center"><?= getPhrase('status')?></th>
                                            <th class="text-center"><?= getPhrase('created_by')?></th>
                                            <th class="text-center"><?= getPhrase('created_at')?></th>
                                            <th class="text-center"><?= getPhrase('updated_by')?></th>
                                            <th class="text-center"><?= getPhrase('updated_at')?></th>
                                            <th class="text-center"><?= getPhrase('assigned_to')?></th>
                                            <th class="text-center"><?= getPhrase('options')?></th>
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
                                                    <a href="<?= base_url();?>admin/admission_applicant/<?= $row['applicant_id'];?>"
                                                        class="grey">
                                                        <?= ($row['first_name']);?>
                                                    </a>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <label style="width:55px; border: 1; text-align: center;">
                                                        <?= ($row['last_name']);?>
                                                    </label>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <label style="width:55px; border: 1; text-align: center;">
                                                        <?= ($row['country_name']);?>
                                                    </label>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?= ($row['email']);?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?= ($row['phone']);?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <div class="value badge badge-pill"
                                                        style="background-color: <?= $row['applicant_type_color']?>;">
                                                        <?= ($row['applicant_type']);?>
                                                    </div>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <div class="value badge badge-pill"
                                                        style="background-color: <?= $row['status_color']?>;">
                                                        <?= ($row['status_name']);?>
                                                    </div>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?= ($row['created_by_name']);?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?= ($row['created_at']);?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?= ($row['updated_by_name']);?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?= ($row['updated_at']);?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <?= ($row['assigned_to_name']);?>
                                                </center>
                                            </td>
                                            <td class="row-actions">
                                                <a href="<?= base_url();?>admin/admission_applicant/<?= $row['applicant_id'];?>"
                                                    class="grey" data-toggle="tooltip" data-placement="top"
                                                    data-original-title="<?= getPhrase('view');?>">
                                                    <i
                                                        class="os-icon picons-thin-icon-thin-0043_eye_visibility_show_visible"></i>
                                                </a>
                                                <?php if(!$allow_actions):?>
                                                <a href="javascript:void(0);" class="grey" data-toggle="tooltip"
                                                    data-placement="top"
                                                    data-original-title="<?= getPhrase('add_interaction');?>"
                                                    onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_admission_add_interaction/<?= $row['applicant_id'];?>');">
                                                    <i class="os-icon picons-thin-icon-thin-0151_plus_add_new"></i>
                                                </a>
                                                <a href="javascript:void(0);" class="grey" data-toggle="tooltip"
                                                    data-placement="top" data-original-title="<?= getPhrase('edit');?>"
                                                    onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_admission_edit_applicant/<?=$row['applicant_id'];?>');">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$('th').click(function() {
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
<script>
$("#btnExport").click(function(e) {
    var reportName = '<?= getPhrase('applicants').'_'.date('d-m-Y');?>';
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