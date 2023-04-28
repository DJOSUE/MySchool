<?php 
    $user_id = get_login_user_id();
    $applicant_info = $this->db->get_where('applicant' , array('applicant_id' => $applicant_id))->result_array(); 
    $allow_actions = is_student($applicant_id);
    $is_international = is_international($applicant_id);

    foreach($applicant_info as $row): 
        $full_name_encode = base64_encode(str_replace(" ","_",strtoupper($row['full_name'])));
        $return_url = base64_encode('admission_applicant/'.$applicant_id);
        $tags_applicant = json_decode($row['tags'], true)['tags_id'];
        $status_info = $this->applicant->get_applicant_status_info($row['status']);
        $type_info = $this->applicant->get_type_info($row['type_id']);
        $assigned_to = $this->crud->get_name('admin', $row['assigned_to']);
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
        <div class="row">
            <div class="content-i">
                <div class="content-box">
                    <div class="row">
                        <main class="col col-xl-9 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
                            <div id="newsfeed-items-grid">
                                <div class="ui-block paddingtel">
                                    <div class="user-profile">
                                        <?php include 'applicant__header.php';?>
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
                                                <div class="form-buttons">
                                                    <button class="btn btn-rounded btn-success"
                                                        onclick="create_payment()">
                                                        <?= getPhrase('create_payment');?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="create_payment_div" style="display:none;">
                                <div class="ui-block">
                                    <?= form_open(base_url() . 'admin/payment_process/'.$applicant_id.'/applicant/');?>
                                    <div class="ui-block-title">
                                        <div class="col-sm-4">
                                            <h6 class="title"><?= getPhrase('new_payment');?></h6>
                                        </div>
                                        <div class="col-sm-1">
                                            <div class="description-toggle" style="justify-content: flex-end;">
                                                <div class="description-toggle-content">
                                                    <div class="h6"><?= getPhrase('send_email');?></div>
                                                </div>
                                                <div class="togglebutton">
                                                    <label>
                                                        <input name="send_email" value="1" type="checkbox" checked>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                                        <table id="items" class="table table-padded">
                                                            <thead>
                                                                <th><?=getPhrase('type')?></th>
                                                                <th><?=getPhrase('amount')?></th>
                                                                <th></th>
                                                            </thead>
                                                            <tbody>
                                                                <?php 
                                                            $income_types = $this->payment->get_income_types_by_user('applicant');
                                                            foreach($income_types as $item):
                                                            ?>
                                                                <tr>
                                                                    <td>
                                                                        <select class="custom-select" tabindex="-1"
                                                                            id="income_type_<?=$item['income_type_id']?>"
                                                                            name="income_type_<?=$item['income_type_id']?>">
                                                                            <option
                                                                                value="<?=$item['income_type_id']?>">
                                                                                <?=$item['name']?></option>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <input
                                                                            id="income_amount_<?=$item['income_type_id']?>"
                                                                            name="income_amount_<?=$item['income_type_id']?>"
                                                                            type="text" class="currency"
                                                                            placeholder="00.00"
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
                                                                        <?= getPhrase('')?>
                                                                    </td>
                                                                    <td>
                                                                        <input id="total_amount" class="currency"
                                                                            type="hidden" disabled />
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
                                                            $discount_types = $this->payment->get_discount_types_by_user('applicant');
                                                            foreach($discount_types as $item):
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
                                                                            type="text" class="currency"
                                                                            placeholder="00.00"
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
                                                            ?>
                                                                <tr>
                                                                    <td>
                                                                        <select class="custom-select" tabindex="-1"
                                                                            id="payment_type_<?=$item['transaction_type_id']?>"
                                                                            name="payment_type_<?=$item['transaction_type_id']?>">
                                                                            <option
                                                                                value="<?=$item['transaction_type_id']?>">
                                                                                <?=$item['name']?></option>
                                                                        </select>
                                                                        <?php if($item['name'] == 'Card'):?>
                                                                        <select class="custom-select"
                                                                            style="width: 200px;"
                                                                            id="card_type_<?=$item['transaction_type_id']?>"
                                                                            name="card_type_<?=$item['transaction_type_id']?>"
                                                                            onchange="apply_fee()" tabindex="-1">
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
                                                                            type="text" class="currency"
                                                                            placeholder="00.00"
                                                                            onfocusout="payment_total()" />
                                                                        <?php if($item['name'] == 'Card'):?>
                                                                        <span id="card_fee" class="currency"></span>
                                                                        <span id="total_fee" class="currency"></span>
                                                                        <?php endif;?>
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
                                                            require></textarea>
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
                                                                    <span id="totalDiscount"
                                                                        class="currency">-00.00</span>
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
                                                                    <span id="totalCardFee"
                                                                        class="currency">00.00</span>
                                                                    <input id="txtTotalCardFee" type="hidden" />
                                                                </td>
                                                            </tr>

                                                            <tr style="border-top: 1px solid;">
                                                                <td>Total to pay
                                                                </td>
                                                                <td>
                                                                    <span id="total" class="currency">00.00</span>
                                                                    <input id="txtTotal" name="txtTotal"
                                                                        type="hidden" />
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
                            <div id="payments_history_div" style="display:block;">
                                <div class="ui-block">
                                    <div class="ui-block-content">

                                    </div>
                                    <div class="ui-block-content">
                                        <div class="table-responsive">
                                            <table class="table table-padded" id="tblPayments">
                                                <thead>
                                                    <tr>
                                                        <th class="orderby"><?= getPhrase('invoice_number');?></th>
                                                        <th class="orderby"><?= getPhrase('invoice_date');?></th>
                                                        <th class="orderby"><?= getPhrase('amount');?></th>
                                                        <th class="orderby"><?= getPhrase('comment');?></th>
                                                        <th class="orderby"><?= getPhrase('created_by');?></th>
                                                        <th class="orderby"><?= getPhrase('created_at');?></th>
                                                        <th><?= getPhrase('action');?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $this->db->reset_query();
                                                        $this->db->order_by('created_at' , 'desc');
                                                        $invoices = $this->db->get_where('payment', array('user_type' => 'applicant','user_id' => $row['applicant_id']))->result_array();
                                                        foreach($invoices as $row2): 
                                                            $delete_url     = base_url().'payments/delete/'.base64_encode($row2['payment_id']).'/'.base64_encode('accountant/applicant_payment/'.$row['applicant_id']);
                                                            $invoice_url    = base_url().'accountant/payment_invoice/'.base64_encode($row2['payment_id']);
                                                            $return_url     = base64_encode('accountant/student_payments/'.$student_id.'/');
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?= $row2['invoice_number'];?>
                                                        </td>
                                                        <td>
                                                            <?= $row2['invoice_date'];?>
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
                                                            <?php if(has_permission('management_payments')):?>
                                                            <a class="grey" href="javascript:void(0);"
                                                                data-toggle="tooltip" data-toggle="tooltip"
                                                                data-placement="top"
                                                                data-original-title="<?= getPhrase('edit_invoice');?>"
                                                                onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_payment_invoice_update/<?= $row2['payment_id'].'/'.$return_url;?>');">
                                                                <i
                                                                    class="os-icon picons-thin-icon-thin-0001_compose_write_pencil_new">
                                                                </i>
                                                            </a>
                                                            <a class="grey" data-toggle="tooltip" data-placement="top"
                                                                data-original-title="<?= getPhrase('delete_invoice');?>"
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
                        </main>
                        <div class="col col-xl-3 order-xl-1 col-lg-12 order-lg-2 col-md-12 col-sm-12 col-12">
                            <div class="eduappgt-sticky-sidebar">
                                <div class="sidebar__inner">
                                    <div class="ui-block paddingtel">
                                        <div class="ui-block-content">
                                            <div class="help-support-block">
                                                <h3 class="title"><?= getPhrase('quick_links');?></h3>
                                                <? include 'applicant__menu.php'?>
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
    var totalFee = parseFloat(total) + parseFloat(amount);

    if (total > 0) {
        document.getElementById('totalCardFee').innerText = parseFloat(total).toFixed(2);
        var htmlFee = "<b style='color:#ff214f'> Card Fee : $" + parseFloat(total).toFixed(2) + "</b>";
        document.getElementById('card_fee').innerHTML = htmlFee;
        var htmlFee = "<b style='color:#ff214f'> Total Card : $" + parseFloat(totalFee).toFixed(2) + "</b>";
        document.getElementById('total_fee').innerHTML = htmlFee;
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

// $(document).ready( function () {
//     $('#tblPayments').DataTable();
// } );
</script>