<?php 
    $currency = $this->crud->getInfo('currency');
    $this->db->reset_query();
    $this->db->select('agreement_id, MIN(due_date) due_date');
    $this->db->where('due_date <=', $end_date);
    $this->db->where_in('status_id', array(DEFAULT_AMORTIZATION_PENDING, DEFAULT_AMORTIZATION_PARTIAL));
    $this->db->group_by('agreement_id');
    $agreements = $this->db->get('agreement_amortization')->result_array();
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
                        <?= form_open(base_url() . 'reports/accounting_collection_management/');?>
                        <div class="row">
                            <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group label-floating is-select"  style="background-color: #fff;">
                                    <label class="control-label"><?php echo getPhrase('end_date');?></label>
                                    <div class="form-group date-time-picker">
                                        <input type="text" autocomplete="off" class="datepicker-here"
                                            data-position="bottom left" data-language='en' name="end_date"
                                            id="end_date" value="<?=$end_date;?>">

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
                                                    <th><?= getPhrase('agreement_id');?></th>
                                                    <th>Year - Semester</th>
                                                    <th><?= getPhrase('collection_profile');?></th>
                                                    <th><?= getPhrase('student_type');?></th>
                                                    <th><?= getPhrase('student_name');?></th>
                                                    <th><?= getPhrase('due_date');?></th>
                                                    <th>#<?= getPhrase('installments_due');?></th>
                                                    <th><?= getPhrase('amount_due');?></th>
                                                    <th><?= getPhrase('automatic_payment');?></th>
                                                    <th><?= getPhrase('agreement_type');?></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                foreach ($agreements as $item):

                                                    $agreement_id = $item['agreement_id'];
                                                    $this->db->reset_query();
                                                    $this->db->where('agreement_id', $agreement_id);
                                                    $agreement = $this->db->get('v_agreement')->row_array();

                                                    $student_id = $agreement['student_id'];                                                    

                                                    $program = $this->studentModel->get_student_program_info($student_id);
                                                    $collection_profile = $this->studentModel->get_student_collection_profile($student_id);
                                                    $due = $this->studentModel->get_student_installments_due($student_id, $end_date, $agreement_id);

                                                    $this->db->reset_query();        
                                                    $this->db->where('agreement_id', $agreement_id);
                                                    $card = $this->db->get('agreement_card')->row_array();
                                                    
                                                    $has_card = $card['card_holder'] == '' ? false : true ;
                                                    $automatic_payment =intval($agreement['automatic_payment']) == 0 ? false : true;  

                                                    $student_url = '/'.$account_type.'/student_payments/'.$agreement['student_id'];
                                                    $card_info_url = base_url().'modal/popup/modal_agreement_card_info/'.$item['agreement_id'];

                                                ?>
                                                <tr class="text-center">
                                                    <td>
                                                        <?= $item['agreement_id'];?>
                                                    </td>
                                                    <td>
                                                        <?= $agreement['year'].' - '.$agreement['semester_name'] ;?>
                                                    </td>
                                                    <td>
                                                        <?= $collection_profile['name'];?>
                                                    </td>
                                                    <td>
                                                        <?= $program['name'];?>
                                                    </td>
                                                    <td>
                                                        <a class="grey" href="<?=$student_url?>">
                                                            <?= $agreement['first_name'] .' '. $agreement['last_name'];?>
                                                        </a>                                                        
                                                    </td>
                                                    <td>
                                                        <?= $item['due_date'];?>
                                                    </td>
                                                    <td>
                                                        <?= $due['number'];?>
                                                    </td>
                                                    <td>
                                                        <?= $currency.' '.number_format($due['amount'], 2);?>
                                                    </td>
                                                    <td>
                                                        <?= $automatic_payment ? 'Yes' : 'No' ;?>
                                                    </td>
                                                    <td>
                                                        <?= intval($item['updated_by']) > 0 ? 'Payment Agreement': 'Contract';?>
                                                    </td>
                                                    <td>
                                                        <?php if(has_permission('management_automate_payments') && $has_card):?>
                                                        <a class="grey" data-toggle="tooltip" data-placement="top"
                                                            data-original-title="<?= getPhrase('view_card_info');?>"
                                                            href="javascript:void(0);"
                                                            onclick="showAjaxModal('<?=$card_info_url;?>');">
                                                            <i
                                                                class="os-icon picons-thin-icon-thin-0407_credit_card"></i>
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
