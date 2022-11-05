<?php 
    $running_year = $this->crud->getInfo('running_year'); 
    $year = $this->db->get('years')->result_array();
    $currency = $this->crud->getInfo('currency');

    $interval = date_interval_create_from_date_string('1 days');

    if($date == "")
    {
        $objDate = date_create(date("Y-m-d"));
    }
    else
    {
        $objDate = date_create($date);
    }

    $first_date = date_format($objDate, "Y-m-d");
    $second_date = date_format(date_add($objDate, $interval), "Y-m-d");
    
    $tuition_int = 0.00;
    $application_int = 0.00;

    $tuition_local = 0.00;
    $application_local = 0.00;

    $books = 0.00;
    $legal_service = 0.00;


    $cash = 0.00;
    $card = 0.00;
    $check = 0.00;
    $venmo = 0.00;
    $transfer = 0.00;

    $this->db->reset_query();    
    $this->db->where('created_at >=', $first_date);
    $this->db->where('created_at <=', $second_date);

    if($cashier_id != "")
    {
        $ex = explode(':',$cashier_id);

        $this->db->where('created_by', $ex['1']);
        $this->db->where('created_by_type', $ex['0']);
    }    
    $payments = $this->db->get('payment')->result_array();

    foreach ($payments as $key => $value) {
        if($value['user_type'] == 'student')
        {
            $program_id = $this->studentModel->get_student_program($value['user_id']);
            $discounts = 0.00;

            // Get Discounts
            $this->db->reset_query();
            $this->db->select_sum('amount');
            $this->db->where('payment_id =', $value['payment_id']);
            $discounts = $this->db->get('payment_discounts')->row()->amount; 

            // Get Tuition  id = 1
            $this->db->reset_query();
            $this->db->select_sum('amount');
            $this->db->where('payment_id =', $value['payment_id']);
            $this->db->where('concept_type =', '1');
            $tuition = $this->db->get('payment_details')->row()->amount; 
            

            // Get books  id = 2
            $this->db->reset_query();
            $this->db->select_sum('amount');
            $this->db->where('payment_id =', $value['payment_id']);
            $this->db->where('concept_type =', '2');
            $books += $this->db->get('payment_details')->row()->amount; 


            // Get application/enroll  id = 3
            $this->db->reset_query();
            $this->db->select_sum('amount');
            $this->db->where('payment_id =', $value['payment_id']);
            $this->db->where('concept_type =', '3');
            $application = $this->db->get('payment_details')->row()->amount; 

            // Get Legal Service  id = 4
            $this->db->reset_query();
            $this->db->select_sum('amount');
            $this->db->where('payment_id =', $value['payment_id']);
            $this->db->where('concept_type =', '4');
            $legal_service += $this->db->get('payment_details')->row()->amount;

            // Get card fee id = 5
            $this->db->reset_query();
            $this->db->select_sum('amount');
            $this->db->where('payment_id =', $value['payment_id']);
            $this->db->where('concept_type =', '5');
            $card_fee += $this->db->get('payment_details')->row()->amount;

            if($program_id == 1) // International
            {
                $tuition_int        += ($tuition - $discounts);
                $application_int    += $application;
            }
            else
            {
                $tuition_local      += ($tuition - $discounts);
                $application_local  += $application;
            }

            // Get Payments Cash id = 1 
            $this->db->reset_query();
            $this->db->select_sum('amount');
            $this->db->where('payment_id =', $value['payment_id']);
            $this->db->where('transaction_type =', '1');
            $cash += $this->db->get('payment_transaction')->row()->amount; 

            // Get Payments card id = 2 
            $this->db->reset_query();
            $this->db->select_sum('amount');
            $this->db->where('payment_id =', $value['payment_id']);
            $this->db->where('transaction_type =', '2');
            $card += $this->db->get('payment_transaction')->row()->amount; 

            // Get Payments Venmo id = 3
            $this->db->reset_query();
            $this->db->select_sum('amount');
            $this->db->where('payment_id =', $value['payment_id']);
            $this->db->where('transaction_type =', '3');
            $venmo += $this->db->get('payment_transaction')->row()->amount; 

            // Get Payments Check id = 4
            $this->db->reset_query();
            $this->db->select_sum('amount');
            $this->db->where('payment_id =', $value['payment_id']);
            $this->db->where('transaction_type =', '4');
            $check += $this->db->get('payment_transaction')->row()->amount; 

            // Get Payments Transfer id = 5
            $this->db->reset_query();
            $this->db->select_sum('amount');
            $this->db->where('payment_id =', $value['payment_id']);
            $this->db->where('transaction_type =', '5');
            $transfer += $this->db->get('payment_transaction')->row()->amount; 

        }
        
    }

    $total_income = ($tuition_int + $application_int + $tuition_local + $application_local + $books + $legal_service);

    $total_payment = ($cash + $card + $check + $venmo + $transfer);
?>
<style>
.invoice-w::before {
    background-color: transparent !important;
}

.currency {
    padding-left: 12px;
    padding-right: 5px;
    text-align: end;
    float: right;
}
.bold {
    font-weight: bold;
}

td {
    padding: 6px 0px;
}
</style>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <?php include "report__nav.php";?>
            </div>
        </div><br>
        <?php 
            // echo '<pre>';
            // var_dump($year);
            // var_dump( MONTH_LIST);
            // echo '</pre>';
        ?>
        <div class="content-i">
            <div class="content-box">
                <div class="element-wrapper">
                    <div class="tab-content">
                        <div class="tab-pane active" id="invoices">
                            <?= form_open(base_url() . 'accountant/report_daily_income/');?>
                            <div class="row">
                                <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group label-floating is-select">
                                        <label class="control-label">
                                            <?= getPhrase('year');?>
                                        </label>
                                        <div class="select">
                                            <select name="year">
                                                <option value=""><?= getPhrase('select');?></option>
                                                <?php foreach($year as $row): ?>
                                                <option value="<?= $row['year'];?>"
                                                    <?php if($year == $row['year']) echo "selected";?>>
                                                    <?= $row['year'];?>
                                                </option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group label-floating is-select">
                                        <label class="control-label">
                                            <?= getPhrase('month');?>
                                        </label>
                                        <div class="select">
                                            <select name="year">
                                                <option value=""><?= getPhrase('select');?></option>
                                                <?php foreach(MONTH_LIST as $row): ?>
                                                <option value="<?= $row[0];?>"
                                                    <?php if($month == $row[0]) echo "selected";?>>
                                                    <?= $row[1];?>
                                                </option>
                                                <?php endforeach;?>
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
                            <div class="element-wrapper">
                                <div class="element-box-tp">
                                    <button type="button" class="btn btn-rounded btn-success"
                                        onclick="Print('invoice_id')"><?= getPhrase('print');?></button>
                                    <br><br>
                                    <div class="invoice-w" id="invoice_id">
                                        <div class="invoice-heading">
                                            <h3><?= getPhrase('daily_income');?></h3>
                                        </div>
                                        <div class="invoice-body">
                                            <table class="table-bordered" style="padding: 6px 0px;">
                                                <thead>
                                                    <tr>
                                                        <td rowspan="2" class="text-center">
                                                            <b><?= getPhrase('local');?></b>
                                                        </td>
                                                        <td rowspan="2" class="text-center">
                                                            <b><?= getPhrase('international');?></b>
                                                        </td>
                                                        <td rowspan="2" class="text-center">
                                                            <b><?= getPhrase('books');?></b>
                                                        </td>
                                                        <td rowspan="2" class="text-center">
                                                            <b><?= getPhrase('application_international');?></b>
                                                        </td>
                                                        <td rowspan="2" class="text-center">
                                                            <b><?= getPhrase('legal_service');?></b>
                                                        </td>
                                                        <td colspan="5" class="text-center">
                                                            <b><?= getPhrase('subtotal');?></b>
                                                        </td>
                                                        <td rowspan="2" class="text-center">
                                                            <b><?= getPhrase('total');?></b>
                                                        </td>

                                                    </tr>
                                                    
                                                </thead>
                                                <tbody class="text-center">
                                                    <tr>
                                                        <td class="text-center">
                                                        </td>
                                                        <td class="text-center">                                                            
                                                        </td>
                                                        <td class="text-center">                                                            
                                                        </td>
                                                        <td class="text-center">                                                            
                                                        </td>
                                                        <td class="text-center">                                                            
                                                        </td>
                                                        <td class="text-center">
                                                            <b><?= getPhrase('cash');?></b>
                                                        </td>
                                                        <td class="text-center">
                                                            <b><?= getPhrase('card');?></b>
                                                        </td>
                                                        <td class="text-center">
                                                            <b><?= getPhrase('check');?></b>
                                                        </td>
                                                        <td class="text-center">
                                                            <b><?= getPhrase('venmo');?></b>
                                                        </td>
                                                        <td class="text-center">
                                                            <b><?= getPhrase('transfer');?></b>
                                                        </td>
                                                        <td class="text-center">
                                                            
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            International Program
                                                        </td>
                                                        <td>
                                                            <span class="currency">
                                                                <?= $currency.' '.number_format($tuition_int, 2);?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <b>Day's earnings</b>
                                                        </td>
                                                        <td>
                                                            <span class="currency bold">
                                                                <?= $currency.' '.number_format($total_payment, 2);?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Local Program
                                                        </td>
                                                        <td>
                                                            <span class="currency">
                                                                <?= $currency.' '.number_format($tuition_local, 2);?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            Cash
                                                        </td>
                                                        <td>
                                                            <span class="currency">
                                                                <?= $currency.' '.number_format($cash, 2);?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Legal Service
                                                        </td>
                                                        <td>
                                                            <span class="currency">
                                                                <?= $currency.' '.number_format($legal_service, 2);?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            Card
                                                        </td>
                                                        <td>
                                                            <span class="currency">
                                                                <?= $currency.' '.number_format($card, 2);?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Application fee International
                                                        </td>
                                                        <td>
                                                            <span class="currency">
                                                                <?= $currency.' '.number_format($application_int, 2);?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            Check
                                                        </td>
                                                        <td>
                                                            <span class="currency">
                                                                <?= $currency.' '.number_format($check, 2);?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Application fee Local
                                                        </td>
                                                        <td>
                                                            <span class="currency">
                                                                <?= $currency.' '.number_format($application_local, 2);?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            Venmo
                                                        </td>
                                                        <td>
                                                            <span class="currency">
                                                                <?= $currency.' '.number_format($venmo, 2);?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Books
                                                        </td>
                                                        <td>
                                                            <span class="currency">
                                                                <?= $currency.' '.number_format($books, 2);?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            Transfer
                                                        </td>
                                                        <td>
                                                            <span class="currency">
                                                                <?= $currency.' '.number_format($transfer, 2);?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <b>Total of the day</b>
                                                        </td>
                                                        <td>
                                                            <span class="currency bold">
                                                                <?= $currency.' '.number_format($total_income, 2);?>
                                                            </span>
                                                        </td>
                                                        <td colspan="2">

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            
                                                        </td>
                                                        <td>
                                                            <br />
                                                            <br />
                                                            <b>Approved by</b>
                                                        </td>
                                                        <td colspan="2">
                                                            <br />
                                                            <br />
                                                            Victor Ochoa
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="invoice-footer">
                                            
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
</div>

<script>
function Print(div) {
    var printContents = document.getElementById(div).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}
</script>
