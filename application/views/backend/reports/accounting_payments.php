<?php 
    $running_year       = $this->crud->getInfo('running_year');
    $running_semester   = $this->crud->getInfo('running_semester'); 

    $payment_type       = $this->payment->get_transaction_types();
    $income_type        = $this->payment->get_income_types();

    $cashier_all    = has_permission('accounting_dashboard');
    $advisor        = $this->user->get_advisor();
    $accounters     = $this->user->get_accounters();


    $startDate  = date_format(date_create($start_date), "Y-m-d");
    $endDate    = date_format(date_create($end_date), "Y-m-d");
    $this->db->reset_query(); 
    if($cashier_id != "")
    {
        $ex = explode(':',$cashier_id);

        $this->db->where('created_by', $ex['1']);
        $this->db->where('created_by_type', $ex['0']);
    }
    $this->db->where('invoice_date >=', $startDate);
    $this->db->where('invoice_date <=', $endDate);
    $payments = $this->db->get('payment')->result_array();
?>

<?php include  $view_path.'_data_table_dependency.php';?>

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
                        <?= form_open(base_url() . 'reports/accounting_payments/');?>
                        <div class="row">
                            <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group label-floating is-select">
                                    <label class="control-label">
                                        <?= getPhrase('cashier');?>
                                    </label>
                                    <div class="select">
                                        <select name="cashier_id" <?= $cashier_all == false ? 'disabled' : ''?>>
                                            <option value=""><?= getPhrase('select');?></option>
                                            <?php foreach($advisor as $row): ?>
                                            <option value="admin:<?= $row['admin_id'];?>"
                                                <?php if($cashier_id == ('admin:'.$row['admin_id'])) echo "selected";?>>
                                                <?= $row['first_name'].' '.$row['last_name'];?></option>
                                            <?php endforeach;?>
                                            <?php foreach($accounters as $item): ?>
                                            <option value="accountant:<?= $item['accountant_id'];?>"
                                                <?php if($cashier_id == ('accountant:'.$item['accountant_id'])) echo "selected";?>>
                                                <?= $item['first_name'].' '.$item['last_name'];?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                            </div>
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
                            <div class="">
                                <div class="">
                                    <div class="">
                                        <table class="display" id="dvData" style="width: 100%;"> 
                                            <thead>
                                                <tr>
                                                    <th>Year - Semester</th>
                                                    <th><?= getPhrase('date');?></th>
                                                    <th><?= getPhrase('student');?></th>
                                                    <th><?= getPhrase('origin');?></th>
                                                    <?php foreach ($income_type as $type):  ?>
                                                    <th><?= $type['name']?></th>
                                                    <?php endforeach;?>
                                                    <th><?= getPhrase('discounts');?></th>
                                                    <th><b><?= getPhrase('total');?></b></th>
                                                    <?php foreach ($payment_type as $type):  ?>
                                                    <th><?= $type['name']?></th>
                                                    <?php endforeach;?>
                                                    <th><?= getPhrase('cashier');?></th>
                                                    <th><?= getPhrase('comments');?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach($payments as $row):
                                                        if($row['user_type'] === 'student')
                                                        {
                                                            $program = ucfirst($row['user_type']) .' - '. $this->studentModel->get_student_program_name($row['user_id']);
                                                        }
                                                        else
                                                        {
                                                            $program = ucfirst($row['user_type']) .' - '.  $this->applicant->get_applicant_program_name($row['user_id']);
                                                        }

                                                        // Get Discounts
                                                        $this->db->reset_query();
                                                        $this->db->select_sum('amount');
                                                        $this->db->where('payment_id =', $row['payment_id']);
                                                        $discounts = $this->db->get('payment_discounts')->row()->amount;  
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?=  $row['year'].' - '. $this->academic->get_semester_name($row['semester_id']) ;?>
                                                    </td>
                                                    <td>
                                                        <?=  date_format(date_create($row['created_at']), "Y-m-d");?>
                                                    </td>
                                                    <td class="cell-with-media">
                                                        <span>
                                                            <?= $this->crud->get_name($row['user_type'], $row['user_id']);?>
                                                        </span>
                                                    </td>
                                                    <td class="cell-with-media">
                                                        <span>
                                                            <?= $program;?>
                                                        </span>
                                                    </td>
                                                    <?php foreach ($income_type as $type):
                                                       $this->db->reset_query();
                                                       $this->db->select_sum('amount');
                                                       $this->db->where('payment_id =', $row['payment_id']);
                                                       $this->db->where('concept_type =', $type['income_type_id']);
                                                       $income = $this->db->get('payment_details')->row()->amount;
                                                    ?>
                                                    <td>
                                                        <?= number_format($income, 2);?>
                                                    </td>
                                                    <?php endforeach;?>
                                                    <td class="cell-with-media">
                                                        <span>
                                                            - <?= number_format($discounts, 2);?>
                                                        </span>
                                                    </td>
                                                    <td class="cell-with-media">
                                                        <span>
                                                            <b> <?= $row['amount'];?></b>
                                                        </span>
                                                    </td>
                                                    <?php foreach ($payment_type as $type):
                                                        $this->db->reset_query();
                                                        $this->db->select_sum('amount');
                                                        $this->db->where('payment_id =', $row['payment_id']);
                                                        $this->db->where('transaction_type =', $type['transaction_type_id']);
                                                        $transaction = $this->db->get('payment_transaction')->row()->amount; 
                                                    ?>
                                                    <td>
                                                        <?= number_format($transaction, 2);?>
                                                    </td>
                                                    <?php endforeach;?>
                                                    <td>
                                                        <?= $this->crud->get_name($row['created_by_type'], $row['created_by']);?>
                                                    </td>
                                                    <td class="cell-with-media">
                                                        <span>
                                                            <?= $row['comment'];?>
                                                        </span>
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
        scrollX: true,
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