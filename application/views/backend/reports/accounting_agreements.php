<?php 
    $this->db->reset_query();        
    $this->db->where('year', $year_id);
    $this->db->where('semester_id', $semester_id);
    $agreements = $this->db->get('v_agreement')->result_array();
?>

<?php include $view_path.'_data_table_dependency.php';?>

<div class="content-w">
    <?php include  $fancy_path.'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <?php include "accounting__nav.php";?>
            </div>
        </div><br>
        <div class="content-i">
            <div class="content-box">
                <div class="element-wrapper">
                    <div class="tab-content">
                        <?= form_open(base_url() . 'reports/accounting_agreements/');?>
                        <div class="row">
                            <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group label-floating is-select">
                                    <label class="control-label"><?= getPhrase('year');?></label>
                                    <div class="select">
                                        <select name="year_id" id="year_id" required="">
                                            <option value=""><?= getPhrase('select');?></option>
                                            <?php 
                                        $years = $this->db->get_where('years', array('status' => '1'))->result_array();
                                        foreach ($years as $row): ?>
                                            <option value="<?= $row['year']; ?>"
                                                <?php if($year_id == $row['year']) echo "selected";?>>
                                                <?= $row['year']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
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
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <button class="btn btn-success btn-upper" style="margin-top:20px"
                                        type="submit"><span><?= getPhrase('search');?></span></button>
                                </div>
                            </div>
                        </div>
                        <?= form_close()?>
                        <br />
                        <div class="tab-pane active" id="invoices" style="width: 100%;">
                            <div class="element-wrapper" style="width: 100%;">
                                <div class="element-box-tp" style="width: 100%;">
                                    <div class="table-responsive" style="width: 100%;">
                                        <table class="table table-padded" id="dvData" style="width: 100%;">
                                            <thead>
                                                <tr class="text-center">
                                                    <th><?= getPhrase('id');?></th>
                                                    <th><?= getPhrase('program');?></th>
                                                    <th><?= getPhrase('sevis_number');?></th>
                                                    <th><?= getPhrase('student');?></th>
                                                    <th><?= getPhrase('phone');?></th>
                                                    <th><?= getPhrase('email');?></th>
                                                    <th><?= getPhrase('date');?></th>
                                                    <th><?= getPhrase('amount');?></th>
                                                    <th>#<?= getPhrase('payments');?></th>
                                                    <th><?= getPhrase('automatic_payment');?></th>
                                                    <th><?= getPhrase('program_type');?></th>
                                                    <th><?= getPhrase('payment_date');?></th>
                                                    <th><?= getPhrase('year');?></th>
                                                    <th><?= getPhrase('semester');?></th>
                                                    <th><?= getPhrase('created_by');?></th>
                                                    <th><?= getPhrase('actions');?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                foreach ($agreements as $key => $value):
                                                    $amount = ((floatval($value['tuition']) + floatval($value['materials']) + floatval($value['fees'])) - (floatval($value['discounts']) + floatval($value['scholarship'])));                                                   
                                                    $delete_url = base_url().$account_type.'/student/delete_agreement/'.base64_encode($value['agreement_id']).'/'.base64_encode($student_id);
                                                    $student_url = '/'.$account_type.'/student_agreements/'.$value['student_id'];
                                                    $payment_schedule_url = base_url().'modal/popup/modal_agreement_payment_schedule/'.$value['agreement_id'];
                                                    $card_info_url = base_url().'modal/popup/modal_agreement_card_info/'.$value['agreement_id'];

                                                    $this->db->reset_query();        
                                                    $this->db->where('agreement_id', $value['agreement_id']);
                                                    $card = $this->db->get('agreement_card')->row_array();
                                                    
                                                    $has_card = $card['card_holder'] == '' ? false : true ;
                                                    $automatic_payment =intval($value['automatic_payment']) == 0 ? true : false;                                                   

                                                ?>
                                                <tr class="text-center">
                                                    <td>
                                                        <?= $value['agreement_id'];?>
                                                    </td>
                                                    <td>
                                                        <?= $value['program_name'];?>
                                                    </td>
                                                    <td>
                                                        <?= $value['sevis_number'];?>
                                                    </td>
                                                    <td>
                                                        <a href="<?=$student_url;?>" target="_blank" class="grey">
                                                            <?= $value['first_name'] .' '. $value['last_name'];?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <?= $value['phone'];?>
                                                    </td>
                                                    <td class="table-td-wrap">
                                                        <?= $value['email'];?>
                                                    </td>
                                                    <td>
                                                        <?= $value['agreement_date'];?>
                                                    </td>
                                                    <td>
                                                        <?= number_format($amount, 2);?>
                                                    </td>
                                                    <td>
                                                        <?= $value['number_payments'];?>
                                                    </td>
                                                    <td>
                                                        <?= intval($value['automatic_payment']) == 0 ? 'No': 'Yes';?>
                                                    </td>
                                                    <td>
                                                        <?= $this->academic->get_program_type_name($value['program_type_id']);?>
                                                    </td>
                                                    <td>
                                                        <?= $value['payment_date'];?>
                                                    </td>
                                                    <td>
                                                        <?= $value['year'];?>
                                                    </td>
                                                    <td>
                                                        <?= $this->academic->get_semester_name($value['semester_id']);?>
                                                    </td>
                                                    <td>
                                                        <?= $this->crud->get_name('admin', $value['created_by']);?>
                                                    </td>
                                                    <td class="row-actions">
                                                        <a href="javascript:void(0);" class="grey" data-toggle="tooltip"
                                                            data-placement="top"
                                                            data-original-title="<?= getPhrase('view_payment_schedule');?>"
                                                            onclick="showAjaxModal('<?=$payment_schedule_url?>');">
                                                            <i
                                                                class="os-icon picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i>
                                                        </a>
                                                        <a href="/PrintDocument/print_agreement/<?=base64_encode($value['agreement_id']);?>"
                                                            class="grey" data-toggle="tooltip" data-placement="top"
                                                            data-original-title="<?= getPhrase('print_agreement');?>">
                                                            <i class="os-icon picons-thin-icon-thin-0333_printer"></i>
                                                        </a>
                                                        <?php if(has_permission('management_automate_payments') && $has_card):?>
                                                        <a class="grey" data-toggle="tooltip" data-placement="top"
                                                            data-original-title="<?= getPhrase('view_card_info');?>"
                                                            href="javascript:void(0);"
                                                            onclick="showAjaxModal('<?=$card_info_url;?>');">
                                                            <i
                                                                class="os-icon picons-thin-icon-thin-0407_credit_card"></i>
                                                        </a>
                                                        <?php endif;?>
                                                        <?php if(has_permission('management_agreements')):?>
                                                        <a class="grey" data-toggle="tooltip" data-placement="top"
                                                            data-original-title="<?= getPhrase('delete_agreement');?>"
                                                            onClick="return confirm('<?= getPhrase('confirm_delete');?>')"
                                                            href="<?= $delete_url;?>">
                                                            <i
                                                                class="os-icon picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i>
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
        </div>
    </div>
</div>
<script>
    var table = $('#dvData').DataTable({
        dom: 'Blifrtp',
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
    $("select[name='dvData_length']" ).addClass('select-page');
</script>