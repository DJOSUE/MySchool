<?php 
    $currency = $this->crud->getInfo('currency');

    $this->db->reset_query();
    $this->db->select('v_agreement.agreement_id, amortization_id,amortization_no, program_name, first_name, last_name, due_date, agreement_amortization.amount, agreement_amortization.materials, agreement_amortization.fees');
    $this->db->from('agreement_amortization');
    $this->db->join('v_agreement', 'agreement_amortization.agreement_id = v_agreement.agreement_id');
    $this->db->where('v_agreement.year', $year_id);
    $this->db->where('v_agreement.semester_id', $semester_id);
    $agreements = $this->db->get()->result_array();

    $query = $this->db->last_query();

    $programs = $this->studentModel->get_programs();

    // echo '<pre>';
    // var_dump($query);
    // echo '</pre>';
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
                        <?= form_open(base_url() . 'reports/accounting_collection/');?>
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
                                                    <th><?= getPhrase('amortization_id');?></th>
                                                    <th><?= getPhrase('amortization_no');?></th>
                                                    <th><?= getPhrase('student_type');?></th>
                                                    <th><?= getPhrase('student_name');?></th>
                                                    <th><?= getPhrase('due_month');?></th>
                                                    <th><?= getPhrase('due_date');?></th>
                                                    <th><?= getPhrase('amount_due');?></th>
                                                    <th><?= getPhrase('amount_paid');?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                foreach ($agreements as $item):

                                                    $total = (floatval($item['amount']) + floatval($item['materials']) + floatval($item['fees']));

                                                    //Get Payments                                                    
                                                    $this->db->reset_query();    
                                                    $this->db->select_sum('amount');    
                                                    $this->db->where('amortization_id', $item['amortization_id']);
                                                    $this->db->where_not_in('concept_type', array(CONCEPT_LATE_FEE_ID, CONCEPT_CARD_ID));
                                                    $paid = $this->db->get('payment_details')->row()->amount; 
                                                ?>
                                                <tr class="text-center">
                                                    <td>
                                                        <?= $item['agreement_id'];?>
                                                    </td>
                                                    <td>
                                                        <?= $item['amortization_id'];?>
                                                    </td>
                                                    <td>
                                                        <?= $item['amortization_no'];?>
                                                    </td>
                                                    <td>
                                                        <?= $item['program_name'];?>
                                                    </td>
                                                    <td>
                                                        <?= $item['first_name'] . ' ' . $item['last_name'];?>
                                                    </td>
                                                    <td>
                                                        <?= date("F",strtotime($item['due_date']));?>
                                                    </td>
                                                    <td>
                                                        <?= $item['due_date'];?>
                                                    </td>
                                                    <td>
                                                        <?= $currency.' '.number_format($total,2);?>
                                                    </td>
                                                    <td>
                                                        <?= $currency.' '.number_format($paid, 2)?>
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
