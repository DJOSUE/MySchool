<?php 
    $running_year = $this->crud->getInfo('running_year');
    $running_semester = $this->crud->getInfo('running_semester');

    $student_info = $this->db->get_where('student' , array('student_id' => $student_id))->result_array(); 

    $payment_info = $this->db->get_where('payment' , array('payment_id' => $payment_id))->row_array();

    $cashierList = $this->task->get_cashier_list_dropbox($payment_info['created_by'], $payment_info['created_by_type']);


    foreach($student_info as $row): 
        $status_info = $this->studentModel->get_status_info($row['student_session']);
        $program_info = $this->studentModel->get_program_info($row['program_id']);

        $this->db->reset_query();        
        $this->db->where('student_id', $student_id);
        $this->db->where('year', $running_year);
        $this->db->where('semester_id', $running_semester);
        $agreement = $this->db->get('agreement')->row_array();

        $has_agreement = false;
        if($agreement['agreement_id'] != '')
        {
            $has_agreement = true;
        }


?>

<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="content-i">
        <div class="content-box">
            <div class="conty">
                <div class="back" style="margin-top:-20px;margin-bottom:10px">
                    <a title="<?= getPhrase('return');?>" href="<?= base_url();?>admin/students/"><i
                            class="picons-thin-icon-thin-0131_arrow_back_undo"></i></a>
                </div>
                <div class="row">
                    <main class="col col-xl-9 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
                        <div id="newsfeed-items-grid">
                            <div class="ui-block paddingtel">
                                <div class="user-profile">
                                    <?php include 'student_area_header.php';?>
                                </div>
                            </div>
                        </div>
                        <div id="create_payment_div">
                            <div class="ui-block">
                                <?= form_open(base_url() . 'admin/payment_update/'.base64_encode($payment_id).'/'.$student_id.'/student/');?>
                                <div class="ui-block-title">
                                    <div class="col-sm-4">
                                        <h6 class="title"><?= getPhrase('update_payment');?></h6>
                                        <?php 
                                        echo '<pre>';
                                        var_dump($payment_id);
                                        echo '</pre>';
                                        ?>
                                    </div>
                                </div>
                                <div class="ui-block-content">
                                    <div class="row">
                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label"><?= getPhrase('invoice_number');?></label>
                                                <input class="form-control" name="invoice_number"
                                                    value="<?= $payment_info['invoice_number'];?>" type="text"
                                                    required="">
                                            </div>
                                        </div>
                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label"><?= getPhrase('amount');?></label>
                                                <input class="form-control" name="amount" id="amount"
                                                    value="<?= $payment_info['amount'];?>" type="text" readonly>
                                            </div>
                                        </div>
                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group date-time-picker label-floating">
                                                <label class="control-label"><?= getPhrase('invoice_date');?></label>
                                                <input type='text' class="datepicker-here" data-position="bottom left"
                                                    data-language='en' name="invoice_date"
                                                    data-multiple-dates-separator="/"
                                                    value="<?= $payment_info['invoice_date'];?>" />
                                            </div>
                                        </div>
                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?php echo getPhrase('cashier');?></label>
                                                <div class="select">
                                                    <select name="cashier_id">
                                                        <option value=""><?= getPhrase('select');?></option>
                                                        <?= $cashierList;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label"><?= getPhrase('year');?></label>
                                                <input class="form-control" name="year"
                                                    value="<?= $payment_info['year'];?>" type="text" required="">
                                            </div>
                                        </div>
                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?= getPhrase('semester');?></label>
                                                <div class="select">
                                                    <select name="semester_id" id="semester_id" required="">
                                                        <option value=""><?= getPhrase('select');?></option>
                                                        <?php 
                                                            $semesters = $this->db->get_where('semesters', array('status' => '1'))->result_array();
                                                            foreach ($semesters as $row): ?>
                                                        <option value="<?= $row['semester_id']; ?>"
                                                            <?php if($payment_info['semester_id'] == $row['semester_id']) echo "selected";?>>
                                                            <?= $row['name']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <hr />
                                <div class="ui-block-content">
                                    <div class="row" id="">
                                        <div class="col" id="amounts">
                                            <div class="row">
                                                <h6 class="title" style="margin-left: 25px;">
                                                    <?= getPhrase('items');?>
                                                </h6>
                                            </div>
                                            <div class="row" style="padding: 0 50px;">
                                                
                                                <div class="table-responsive">
                                                    <small>
                                                        <span id="amount_error"></span>
                                                    </small>
                                                    <table id="items" class="table table-padded">
                                                        <thead>
                                                            <th><?=getPhrase('type')?></th>
                                                            <th><?=getPhrase('amount')?></th>
                                                            <th></th>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
                                                            $income_types = $this->payment->get_income_types_by_user_upd('student');
                                                            foreach($income_types as $item):
                                                                $attribute = ($item['name'] == CONCEPT_LATE_FEE_NAME ? 'readonly' : ($item['name'] == CONCEPT_CARD_NAME ? 'readonly' : ''));
                                                                $has_update = $item['name'] == CONCEPT_CARD_NAME ? true : false;
                                                                // Get Payments Details
                                                                $income_type_id = $item['income_type_id'];
                                                                $this->db->reset_query();
                                                                $this->db->where('payment_id ', $payment_id);
                                                                $this->db->where('concept_type', $income_type_id);
                                                                $payment_detail = $this->db->get('payment_details')->row_array();
                                                            ?>
                                                            <tr>
                                                                <td>
                                                                    <select class="custom-select" tabindex="-1"
                                                                        id="income_type_<?=$income_type_id?>"
                                                                        name="income_type_<?=$income_type_id?>">
                                                                        <option value="<?=$income_type_id?>">
                                                                            <?=$item['name']?></option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input id="income_amount_<?=$income_type_id?>"
                                                                        name="income_amount_<?=$income_type_id?>"
                                                                        type="text" class="currency" placeholder="00.00"
                                                                        <?php if(!$has_update):?>
                                                                        onfocusout="amount_total()"
                                                                        <?php endif;?>
                                                                        value="<?=$payment_detail['amount']?>"
                                                                        <?= $attribute;?> />
                                                                    <?php if($payment_detail['amortization_id'] != ''):?>
                                                                    <input type="hidden" id="amortization_id" name="amortization_id"
                                                                        value="<?=$payment_detail['amortization_id']?>"
                                                                        readonly>
                                                                    <?php endif;?>
                                                                </td>
                                                            </tr>
                                                            <?php endforeach;?>
                                                            <tr>
                                                                <td>
                                                                    <?= getPhrase('total')?>
                                                                </td>
                                                                <td>
                                                                    <input id="total_amount"
                                                                        class="form-control currency" readonly
                                                                        value="<?=$payment_info['amount'];?>" />
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" col" id="discounts">
                                            <div class="row">
                                                <h6 class="title" style="margin-left: 25px;">
                                                    <?= getPhrase('discounts_scholarships');?>
                                                </h6>
                                            </div>
                                            <div class="row" style="padding: 0 50px;">
                                                <div class="table-responsive">
                                                    <table id="items" class="table table-padded">
                                                        <thead>
                                                            <th><?=getPhrase('type')?></th>
                                                            <th><?=getPhrase('amount')?></th>
                                                            <th></th>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
                                                            $discount_types = $this->payment->get_discount_types();
                                                            foreach($discount_types as $item):
                                                                // Get Payments Discount
                                                                $discount_id = $item['discount_id'];
                                                                $this->db->reset_query();
                                                                $this->db->where('payment_id ', $payment_id);
                                                                $this->db->where('discount_type', $discount_id);
                                                                $payment_discounts = $this->db->get('payment_discounts')->row_array();
                                                            ?>
                                                            <tr>
                                                                <td>
                                                                    <select class="custom-select" tabindex="-1"
                                                                        id="discount_type_<?=$item['discount_id']?>"
                                                                        name="discount_type_<?=$item['discount_id']?>">
                                                                        <option value="<?=$item['discount_id']?>">
                                                                            <?=$item['name']?></option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input
                                                                        id="discount_amount_<?=$item['discount_id']?>"
                                                                        name="discount_amount_<?=$item['discount_id']?>"
                                                                        type="text" class="currency" placeholder="00.00"
                                                                        value="<?=$payment_discounts['amount']?>"
                                                                        onfocusout="discount_total()" />
                                                                </td>
                                                                <!-- <td>
                                                                <i
                                                                    class="picons-thin-icon-thin-0057_bin_trash_recycle_delete_garbage_full"></i>
                                                            </td> -->
                                                            </tr>
                                                            <?php endforeach;?>
                                                            <tr>
                                                                <td>
                                                                    <?= getPhrase('')?>
                                                                </td>
                                                                <td>
                                                                    <input id="total_discount" class="currency"
                                                                        type="hidden" disabled />
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="col-sm-2">
                                        <h6 class="title"><?= getPhrase('payment_methods');?></h6>
                                    </div>
                                    <br /><br />
                                    <div class="row">
                                        <div class="col" id="transactions">
                                            <div class="row" style="padding: 0 10px;">
                                                <div class="table-responsive">
                                                    <table id="items" class="table table-padded">
                                                        <thead>
                                                            <th><?=getPhrase('type')?></th>
                                                            <th><?=getPhrase('amount')?></th>
                                                            <th></th>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
                                                            $transaction_types = $this->payment->get_transaction_types();
                                                            foreach($transaction_types as $item):
                                                                
                                                                $transaction_type_id    = $item['transaction_type_id'];
                                                                $has_credit_card        = $item['name'] == 'Card';
                                                                $has_fee                = false;

                                                                // Get Payments Discount
                                                                $this->db->reset_query();
                                                                $this->db->where('payment_id ', $payment_id);
                                                                $this->db->where('transaction_type', $transaction_type_id);
                                                                $payment_transaction = $this->db->get('payment_transaction')->row_array();
                                                            ?>
                                                            <tr>
                                                                <td>
                                                                    <select class="custom-select" tabindex="-1"
                                                                        id="payment_type_<?=$transaction_type_id?>"
                                                                        name="payment_type_<?=$transaction_type_id?>">
                                                                        <option
                                                                            value="<?=$transaction_type_id?>">
                                                                            <?=$item['name']?></option>
                                                                    </select>
                                                                    <?php if($has_credit_card):?>
                                                                    <select class="custom-select" style="width: 200px;"
                                                                        id="card_type_<?=$transaction_type_id?>"
                                                                        name="card_type_<?=$transaction_type_id?>"
                                                                        onchange="apply_fee()" tabindex="-1">
                                                                        <?php 
                                                                        $card_types = $this->payment->get_credit_cards();
                                                                        foreach($card_types as $card):
                                                                            if($card['creditcard_id'] == $payment_transaction['card_type'])
                                                                            {
                                                                                $selected = 'selected';
                                                                                $has_fee  = true;
                                                                            }
                                                                            else
                                                                            {
                                                                                $selected = '';
                                                                                $has_fee  = false;
                                                                            }
                                                                        ?>
                                                                        <option value="<?=$card['creditcard_id']?>"
                                                                            <?=$selected?>
                                                                        >
                                                                            <?=$card['name']?></option>
                                                                        <?php endforeach;?>
                                                                    </select>
                                                                    <?php endif;?>
                                                                </td>
                                                                <td>
                                                                    <input
                                                                        id="payment_amount_<?=$transaction_type_id?>"
                                                                        name="payment_amount_<?=$transaction_type_id?>"
                                                                        type="text" class="currency" placeholder="00.00"
                                                                        value="<?=$payment_transaction['amount']?>"
                                                                        onfocusout="payment_total()" />
                                                                    <?php 
                                                                    if($has_credit_card):
                                                                        $fee        = ((floatval($payment_transaction['amount']) * 5) / 100);
                                                                        $total      = (floatval($payment_transaction['amount']) + $fee);
                                                                        $text_fee   = "<b style='color:#ff214f'> Card Fee : $" . floatval($fee) . "</b>";
                                                                        $text_total = "<b style='color:#ff214f'> Total Card : $" . floatval($text_total) . "</b>";                                                                        
                                                                    ?>
                                                                    <span id="card_fee" class="currency">
                                                                        <?= $has_fee ? $text_fee  : ''?>
                                                                    </span>
                                                                    <span id="total_fee" class="currency">
                                                                        <?= $has_fee ? $text_total  : ''?>
                                                                    </span>
                                                                    <?php endif;?>
                                                                </td>
                                                                <?php if($item['name'] != 'Cash'):?>
                                                                <td>
                                                                    <input
                                                                        name="transaction_code_<?=$transaction_type_id?>"
                                                                        type="text" style="width: 150px;" />
                                                                </td>
                                                                <?php endif;?>
                                                            </tr>
                                                            <?php endforeach;?>
                                                            <tr>
                                                                <td class="currency">
                                                                    <b style='color:#ff214f'>Remaining to pay:</b>
                                                                </td>
                                                                <td>
                                                                    <span id="remainingAmount"
                                                                        class="currency">00.00</span>
                                                                    <input id="total_payment" class="currency"
                                                                        type="hidden" disabled />
                                                                </td>
                                                                <td>
                                                                    <span id="txtRemainingAmount"></span>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="">
                                                <div class="form-group">
                                                    <label for="comment"><?=getPhrase('comment')?></label>
                                                    <textarea class="form-control" name="comment" rows="3"
                                                        require><?=$payment_info['comment']?></textarea>
                                                </div>
                                            </div>
                                            <br /><br />
                                            <div class="" style="margin-right: 50px;">
                                                <h6 class="title"><?= getPhrase('payment_summary');?></h6>
                                                <table>
                                                    <thead>
                                                        <th></th>
                                                        <th></th>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Total Items
                                                            </td>
                                                            <td>
                                                                <span id="totalAmount" class="currency">00.00</span>
                                                                <input id="txtTotalAmount" type="hidden" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Total discounts
                                                            </td>
                                                            <td>
                                                                <span id="totalDiscount" class="currency">-00.00</span>
                                                                <input id="txtTotalDiscount" type="hidden" />
                                                            </td>
                                                        </tr>

                                                        <tr style="border-top: 1px solid;">
                                                            <td>Subtotal
                                                            </td>
                                                            <td>
                                                                <span id="subtotal" class="currency">00.00</span>
                                                                <input id="txtSubtotal" type="hidden" />
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>Credit card fee
                                                            </td>
                                                            <td>
                                                                <span id="totalCardFee" class="currency">00.00</span>
                                                                <input id="txtTotalCardFee" type="hidden" />
                                                            </td>
                                                        </tr>

                                                        <tr style="border-top: 1px solid;">
                                                            <td>Total to pay
                                                            </td>
                                                            <td>
                                                                <span id="total" class="currency">00.00</span>
                                                                <input id="txtTotal" name="txtTotal" type="hidden" />
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <br />
                                            <br />
                                            <div class="form-buttons">
                                                <button class="btn btn-rounded btn-success" id="btnPayment"
                                                    type="submit" disabled>
                                                    <?= getPhrase('update');?></button>
                                            </div>
                                            <small><span id="payment_error"></span></small>
                                        </div>
                                    </div>
                                </div>
                                <?= form_close()?>
                            </div>
                        </div>
                    </main>
                    <?php include 'student_area_menu.php';?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach;?>
<script type="text/javascript">
$(document).ready(function(){
    amount_total();
    discount_total();
    payment_total();

    
});

$('.currency').keyup(function() {
    var val = $(this).val();
    if (isNaN(val)) {
        val = val.replace(/[^0-9\.]/g, '');
        if (val.split('.').length > 2)
            val = val.replace(/\.+$/, "");
    }
    $(this).val(val);
});

function amount_total() {

    var error = "";
    var tuition_pending = document.getElementById('income_amount_1').max;
    var tuition = document.getElementById('income_amount_1').value;

    var arr = document.querySelectorAll('input[id^="income_amount_"]');
    var total = 0.00;
    for (var i = 0; i < arr.length; i++) {
        if (parseFloat(arr[i].value) && i != 4)
        {
            total += parseFloat(arr[i].value);
        }
    }
    document.getElementById('total_amount').value = total;
    document.getElementById('txtTotalAmount').value = total;
    document.getElementById('totalAmount').innerText = total;


    document.getElementById('amount').value = total;

    update_total();

}

function discount_total() {
    var arrayDiscount = document.querySelectorAll('input[id^="discount_amount_"]');
    var totalDiscount = 0.00;
    for (var i = 0; i < arrayDiscount.length; i++) {
        if (parseFloat(arrayDiscount[i].value))
            totalDiscount += parseFloat(arrayDiscount[i].value);
    }
    document.getElementById('total_discount').value = totalDiscount;
    document.getElementById('txtTotalDiscount').value = totalDiscount;
    document.getElementById('totalDiscount').innerText = totalDiscount;

    update_total();
}

function payment_total() {
    var array = document.querySelectorAll('input[id^="payment_amount_"]');
    var total = 0.00;
    for (var i = 0; i < array.length; i++) {
        if (parseFloat(array[i].value)) {
            total += parseFloat(array[i].value);
        }

        if (array[i].id == 'payment_amount_2') {
            apply_fee();
        }
    }

    document.getElementById('total_payment').value = total;
    update_total();
}

function apply_fee() {
    var amount = document.getElementById('payment_amount_2').value;
    var sel = document.getElementById("card_type_2");
    var text = sel.options[sel.selectedIndex].text;

    if (text != 'Visa') {
        var total = ((parseFloat(amount) * 5) / 100);
        var totalFee = parseFloat(total) + parseFloat(amount);

        if (total > 0) {
            document.getElementById('totalCardFee').innerText = parseFloat(total).toFixed(2);
            var htmlFee = "<b style='color:#ff214f'> Card Fee : $" + parseFloat(total).toFixed(2) + "</b>";
            document.getElementById('card_fee').innerHTML = htmlFee;
            var htmlFee = "<b style='color:#ff214f'> Total Card : $" + parseFloat(totalFee).toFixed(2) + "</b>";
            document.getElementById('total_fee').innerHTML = htmlFee;

            document.getElementById('income_amount_5').value = parseFloat(total).toFixed(2);
            
        }
    } else {
        document.getElementById('card_fee').innerText = ""
        document.getElementById('total_fee').innerText = ""
        document.getElementById('totalCardFee').innerText = '00.00';
    }

    update_total();
}

function update_total() {
    var totalAmount = parseFloat(document.getElementById('totalAmount').innerText);
    var totalDiscount = parseFloat(document.getElementById('totalDiscount').innerText);
    var totalCardFee = parseFloat(document.getElementById('totalCardFee').innerText);
    var totalPayment = parseFloat(document.getElementById('total_payment').value);

    var totalToPay = (totalAmount + totalCardFee) - totalDiscount;
    var subtotal = totalAmount - totalDiscount;

    var remainingAmount = (totalPayment > 0 ? totalPayment : 0) - subtotal;

    document.getElementById('txtTotal').value = totalToPay;
    document.getElementById('total').innerText = totalToPay;

    document.getElementById('subtotal').innerText = subtotal;
    document.getElementById('txtSubtotal').innerText = subtotal;

    if (remainingAmount > 0) {
        var txtRemainingAmount = "<b style='color:#ff214f'> Payment Exceeds </b>";
        document.getElementById('txtRemainingAmount').innerHTML = txtRemainingAmount;
    } else {
        document.getElementById('txtRemainingAmount').innerHTML = "";
    }

    document.getElementById('remainingAmount').innerText = remainingAmount;


    if (totalPayment == subtotal) {
        document.getElementById("btnPayment").disabled = false;
        document.getElementById("payment_error").innerHTML = '';
    } else {
        document.getElementById("btnPayment").disabled = true;
        document.getElementById("payment_error").innerHTML =
            "<b style='color:#ff214f'>Validate that \"Remaining to Pay\" is 00.00</b>";
    }

}
</script>

<script type="text/javascript">
    // Order By
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