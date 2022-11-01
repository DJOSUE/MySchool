<?php 
    $running_year = $this->crud->getInfo('running_year');
    $running_semester = $this->crud->getInfo('running_semester');

    $student_info = $this->db->get_where('student' , array('student_id' => $student_id))->result_array(); 

    $student_enroll = $this->db->get_where('enroll', array('student_id' => $student_id, 'year' => $running_year, 'semester_id' => $running_semester ))->result_array(); 

    $class_id = $student_enroll[0]['class_id'];
    $section_id = $student_enroll[0]['section_id'];

    foreach($student_info as $row): 
        $status_info = $this->studentModel->get_status_info($row['student_session']);
        $program_info = $this->studentModel->get_program_info($row['program_id']);
?>
<style>
.currency {
    padding-left: 12px;
    text-align: end;
}

.currency-symbol {
    position: absolute;
    padding: 2px 5px;
}
</style>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="content-i">
        <div class="content-box">
            <div class="conty">
                <div class="row">
                    <main class="col col-xl-9 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
                        <div id="newsfeed-items-grid">
                            <div class="ui-block paddingtel">
                                <div class="user-profile">
                                    <?php include 'student__header.php';?>
                                </div>
                            </div>
                        </div>
                        <!-- add payment -->
                        <div>
                            <div class="ui-block">
                                <div class="ui-block-title">
                                    <div class="col-sm-2">
                                        <h6 class="title"><?= getPhrase('payments');?></h6>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="row" style="justify-content: flex-end;">
                                            <!-- <div class="form-buttons">
                                                <button class="btn btn-rounded btn-primary">
                                                    <?= getPhrase('print_agreement');?></button>
                                            </div> &nbsp;&nbsp;&nbsp;&nbsp; -->
                                            <div class="form-buttons">
                                                <button class="btn btn-rounded btn-success" onclick="create_payment()">
                                                    <?= getPhrase('create_payment');?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="create_payment_div" style="display:none;">
                            <div class="ui-block">
                                <div class="ui-block-title">
                                    <div class="col-sm-2">
                                        <h6 class="title"><?= getPhrase('new_payment');?></h6>
                                    </div>
                                </div>
                                <?= form_open(base_url() . 'payments/manual_payment_process/'.$student_id.'/student/');?>
                                <div class="ui-block-content">
                                    <div class="row" id="">
                                        <div class="col" id="amounts">
                                            <div class="row">
                                                <h6 class="title" style="margin-left: 25px;"><?= getPhrase('items');?>
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
                                                            $income_types = $this->payment->get_income_types();
                                                            foreach($income_types as $item):
                                                            ?>
                                                            <tr>
                                                                <td>
                                                                    <select class="custom-select"
                                                                        id="income_type_<?=$item['income_type_id']?>"
                                                                        name="income_type_<?=$item['income_type_id']?>">
                                                                        <option value="<?=$item['income_type_id']?>">
                                                                            <?=$item['name']?></option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input
                                                                        id="income_amount_<?=$item['income_type_id']?>"
                                                                        name="income_amount_<?=$item['income_type_id']?>"
                                                                        type="text" class="currency" placeholder="00.00"
                                                                        onfocusout="amount_total()" />
                                                                </td>
                                                                <!-- <td>
                                                                    <i
                                                                        class="picons-thin-icon-thin-0057_bin_trash_recycle_delete_garbage_full"></i>
                                                                </td> -->
                                                            </tr>
                                                            <?php endforeach;?>
                                                            <tr>
                                                                <td>
                                                                    <?= getPhrase('total')?>
                                                                </td>
                                                                <td>
                                                                    <input id="total_amount" class="currency"
                                                                        disabled />
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
                                                            ?>
                                                            <tr>
                                                                <td>
                                                                    <select class="custom-select"
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
                                                                    <?= getPhrase('total')?>
                                                                </td>
                                                                <td>
                                                                    <input id="total_discount" class="currency"
                                                                        disabled />
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
                                                            ?>
                                                            <tr>
                                                                <td>
                                                                    <select class="custom-select"
                                                                        id="payment_type_<?=$item['transaction_type_id']?>"
                                                                        name="payment_type_<?=$item['transaction_type_id']?>">
                                                                        <option
                                                                            value="<?=$item['transaction_type_id']?>">
                                                                            <?=$item['name']?></option>
                                                                    </select>
                                                                    <?php if($item['name'] == 'Card'):?>
                                                                    <select class="custom-select" style="width: 200px;"
                                                                        id="card_type_<?=$item['transaction_type_id']?>"
                                                                        name="card_type_<?=$item['transaction_type_id']?>"
                                                                        onchange="apply_fee()">
                                                                        <?php 
                                                                        $card_types = $this->payment->get_credit_cards();
                                                                        foreach($card_types as $card):
                                                                        ?>
                                                                        <option value="<?=$card['creditcard_id']?>">
                                                                            <?=$card['name']?></option>
                                                                        <?php endforeach;?>
                                                                    </select>
                                                                    <?php endif;?>
                                                                </td>
                                                                <td>
                                                                    <input
                                                                        id="payment_amount_<?=$item['transaction_type_id']?>"
                                                                        name="payment_amount_<?=$item['transaction_type_id']?>"
                                                                        type="text" class="currency" placeholder="00.00"
                                                                        onfocusout="payment_total()" />
                                                                </td>
                                                                <?php if($item['name'] != 'Cash'):?>
                                                                <td>
                                                                    <input
                                                                        name="transaction_code_<?=$item['transaction_type_id']?>"
                                                                        type="text" style="width: 150px;" />
                                                                </td>
                                                                <?php endif;?>
                                                            </tr>
                                                            <?php endforeach;?>
                                                            <tr>
                                                                <td>
                                                                    <?= getPhrase('total')?>
                                                                </td>
                                                                <td>
                                                                    <input id="total_payment" class="currency"
                                                                        disabled />
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
                                                    <textarea class="form-control" name="comment" rows="3"></textarea>
                                                </div>
                                            </div>
                                            <br /><br />
                                            <div class="">

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
                                                                <span id="totalAmount">00.00</span>
                                                                <input id="txtTotalAmount" type="hidden" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Total Credit card fee
                                                            </td>
                                                            <td>
                                                                <span id="totalCardFee">00.00</span>
                                                                <input id="txtTotalCardFee" type="hidden" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Total discounts
                                                            </td>
                                                            <td>
                                                                <span id="totalDiscount">-00.00</span>
                                                                <input id="txtTotalDiscount" type="hidden" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Total
                                                            </td>
                                                            <td>
                                                                <span id="total">00.00</span>
                                                                <input id="txtTotal" name="txtTotal" type="hidden" />
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="form-buttons">
                                                <button class="btn btn-rounded btn-success" id="btnPayment"
                                                    type="submit" disabled>
                                                    <?= getPhrase('pay');?></button>
                                            </div>
                                            <small><span id="payment_error"></span></small>
                                        </div>
                                    </div>
                                </div>
                                <?= form_close()?>
                            </div>
                        </div>

                        <!-- payments history -->
                        <div id="payments_history_div">
                            <div class="ui-block">
                                <div class="ui-block-content">
                                    <div class="table-responsive">
                                        <table class="table table-padded">
                                            <thead>
                                                <tr>
                                                    <th><?= getPhrase('invoice_number');?></th>
                                                    <th><?= getPhrase('amount');?></th>
                                                    <th><?= getPhrase('comment');?></th>
                                                    <th><?= getPhrase('created_at');?></th>
                                                    <th><?= getPhrase('created_by');?></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $this->db->reset_query();                                                
                                                $this->db->order_by('created_at' , 'desc');
                                                $invoices = $this->db->get_where('payment', array('user_type' => 'student','user_id' => $row['student_id']))->result_array();
                                                foreach($invoices as $row2): 
                                            ?>
                                                <tr>
                                                    <td>
                                                        <?= $row2['invoice_number'];?>
                                                    </td>
                                                    <td>
                                                        <a class="badge badge-primary" href="javascript:void(0);">
                                                            <?= $this->crud->getInfo('currency');?><?= $row2['amount'];?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <?= $row2['comment'];?>
                                                    </td>
                                                    <td>
                                                        <?= $row2['created_at'];?>
                                                    </td>
                                                    <td>
                                                        <?= $this->crud->get_name($row2['created_by_type'], $row2['created_by']);?>
                                                    </td>
                                                    <td class="row-actions">
                                                        <a href="<?php echo base_url();?>accountant/payment_invoice/<?= base64_encode($row2['payment_id']);?>"
                                                            target="_blank" class="grey" data-toggle="tooltip"
                                                            data-placement="top"
                                                            data-original-title="<?php echo getPhrase('view_invoice');?>">
                                                            <i
                                                                class="os-icon picons-thin-icon-thin-0043_eye_visibility_show_visible">
                                                            </i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php endforeach;?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                    <?php include 'student__nav.php';?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach;?>
<script type="text/javascript">
function create_payment() {
    document.getElementById("create_payment_div").style.display = 'block';
    document.getElementById("payments_history_div").style.display = 'none';
}

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
    var arr = document.querySelectorAll('input[id^="income_amount_"]');
    var total = 0.00;
    for (var i = 0; i < arr.length; i++) {
        if (parseFloat(arr[i].value))
            total += parseFloat(arr[i].value);
    }
    document.getElementById('total_amount').value = total;
    document.getElementById('txtTotalAmount').value = total;
    document.getElementById('totalAmount').innerText = total;
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
        document.getElementById('totalCardFee').innerText = parseFloat(total).toFixed(2);
    } else {
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
    var total = totalAmount - totalDiscount;

    document.getElementById('txtTotal').value = totalToPay;
    document.getElementById('total').innerText = totalToPay;

    if (totalPayment == total) {
        document.getElementById("btnPayment").disabled = false;
        document.getElementById("payment_error").innerHTML = '';
    } else {
        document.getElementById("btnPayment").disabled = true;
        document.getElementById("payment_error").innerHTML = 'Validate that Total Amount is equal to Total Payment';
    }

}
</script>