<?php 
    $form_url     = base_url() . 'accountant/agreement/update/'. base64_encode($agreement_id) . '/'. base64_encode($student_id);
    $student_info = $this->db->get_where('student' , array('student_id' => $student_id))->result_array();
    $agreement    = $this->db->get_where('v_agreement' , array('agreement_id' => $agreement_id))->row_array();
    $amortization = $this->db->get_where('agreement_amortization' , array('agreement_id' => $agreement_id))->result_array();

    $total_tuition = ($agreement['tuition'] - ($agreement['scholarship'] +  $agreement['discounts']));

    foreach($student_info as $row):
        $student_id = $row['student_id'];
        $return_url = base64_encode('student_profile/'.$student_id);
        
?>
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
                                    <div>
                                        <div class="ui-block">
                                            <div class="ui-block-title">
                                                <div class="col-sm-2">
                                                    <h6 class="title"><?= getPhrase('agreement');?></h6>
                                                </div>

                                            </div>
                                            <div class="ui-block-content">
                                                <div class="row">
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <ul class="widget w-personal-info item-block">
                                                            <li>
                                                                <span
                                                                    class="title"><?= getPhrase('agreement_id');?>:</span>
                                                                <span
                                                                    class="text"><?= $agreement['agreement_id'];?></span>
                                                            </li>
                                                            <li>
                                                                <span class="title"><?= getPhrase('tuition');?>:</span>
                                                                <span class="text"><?= $agreement['tuition'];?></span>
                                                            </li>
                                                            <li>
                                                                <span
                                                                    class="title"><?= getPhrase('materials');?>:</span>
                                                                <span class="text"><?= $agreement['materials'];?></span>
                                                            </li>
                                                            <li>
                                                                <span class="title"><?= getPhrase('fees');?>:</span>
                                                                <span class="text"><?= $agreement['fees'];?></span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <ul class="widget w-personal-info item-block">
                                                            <li>
                                                                <span
                                                                    class="title"><?= getPhrase('agreement_date');?>:</span>
                                                                <span
                                                                    class="text"><?= $agreement['agreement_date'];?></span>
                                                            </li>
                                                            <li>
                                                                <span
                                                                    class="title"><?= getPhrase('scholarship');?>:</span>
                                                                <span
                                                                    class="text"><?= $agreement['scholarship'];?></span>
                                                            </li>
                                                            <li>
                                                                <span
                                                                    class="title"><?= getPhrase('discounts');?>:</span>
                                                                <span class="text"><?= $agreement['discounts'];?></span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <hr />
                                                <div class="row">
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <ul class="widget w-personal-info item-block">
                                                            <li>
                                                                <span class="title"><?= getPhrase('modality');?>:</span>
                                                                <span
                                                                    class="text"><?= $agreement['modality_name'];?></span>
                                                            </li>
                                                            <li>
                                                                <span
                                                                    class="title"><?= getPhrase('payment_date');?>:</span>
                                                                <span
                                                                    class="text"><?= $agreement['payment_date'];?></span>
                                                            </li>
                                                            <li>
                                                                <span
                                                                    class="title"><?= getPhrase('book_type');?>:</span>
                                                                <span class="text"><?= $agreement['book_type'];?></span>
                                                            </li>
                                                            <li>
                                                                <span class="title"><?= getPhrase('program');?>:</span>
                                                                <span
                                                                    class="text"><?= $agreement['program_type_id'];?></span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <ul class="widget w-personal-info item-block">
                                                            <li>
                                                                <span
                                                                    class="title"><?= getPhrase('number_payments');?>:</span>
                                                                <span
                                                                    class="text"><?= $agreement['number_payments'];?></span>
                                                            </li>
                                                            <li>
                                                                <span class="title"><?= getPhrase('year');?>:</span>
                                                                <span class="text"><?= $agreement['year'];?></span>
                                                            </li>
                                                            <li>
                                                                <span
                                                                    class="title"><?= getPhrase('semester_name');?>:</span>
                                                                <span
                                                                    class="text"><?= $agreement['semester_name'];?></span>
                                                            </li>
                                                            <li>
                                                                <span class="title"><?= getPhrase('status');?>:</span>
                                                                <span class="text"><?= $agreement['status'];?></span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ui-block">
                                            <div class="ui-block-title">
                                                <div class="col-sm-2">
                                                    <h6 class="title">
                                                        <?= getPhrase('installments')?>
                                                    </h6>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="row" style="justify-content: flex-end;">
                                                        <div class="form-buttons">
                                                            <button id="add_installment" onclick="add_installment()"
                                                                class="btn btn-rounded btn-success">
                                                                +
                                                            </button>
                                                            <button id="delete_installment"
                                                                onclick="delete_installment()"
                                                                class="btn btn-rounded btn-danger">
                                                                -
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?= form_open($form_url , array('enctype' => 'multipart/form-data', 'autocomplete' => 'off', 'onsubmit' => 'return validateForm()'));?>
                                            <div class="ui-block-content">
                                                <input type="hidden" id="new_number_payments" name="new_number_payments"
                                                    value="<?=$agreement['number_payments']?>" />
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="tbl_installment">
                                                        <thead>
                                                            <tr style="text-align: center; background:#f2f4f8;">
                                                                <th>
                                                                    #
                                                                </th>
                                                                <th>
                                                                    <?= getPhrase('due_date');?>
                                                                </th>
                                                                <th>
                                                                    <?= getPhrase('amount');?>
                                                                </th>
                                                                <th>
                                                                    <?= getPhrase('materials');?>
                                                                </th>
                                                                <th>
                                                                    <?= getPhrase('fees');?>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
                                                        foreach ($amortization as $value):
                                                            $status_info        = $this->payment->get_payment_schedule_status_info($value['status_id']);
                                                            $id = $value['amortization_id'];
                                                            $readonly = $value['status_id'] != 1 ? 'readonly' : '';
                                                        ?>
                                                            <tr style="text-align: center;">
                                                                <td style="max-width: 20px;">
                                                                    <?= $value['amortization_no'];?>
                                                                </td>
                                                                <td>
                                                                    <center>
                                                                        <input type="date"
                                                                            id="<?= 'due_date_'.$value['amortization_id'];?>"
                                                                            name="<?= 'due_date_'.$value['amortization_id'];?>"
                                                                            value="<?= $value['due_date'];?>"
                                                                            <?=$readonly?> />
                                                                    </center>
                                                                </td>
                                                                <td>
                                                                    <center>
                                                                        <input type="text" class="currency"
                                                                            id="<?= 'amount_'.$value['amortization_id'];?>"
                                                                            name="<?= 'amount_'.$value['amortization_id'];?>"
                                                                            value="<?= $value['amount'];?>"
                                                                            onfocusout="update_totals()"
                                                                            <?=$readonly?> />
                                                                    </center>
                                                                </td>
                                                                <td>
                                                                    <center>
                                                                        <input type="text" class="currency"
                                                                            id="<?= 'materials_'.$value['amortization_id'];?>"
                                                                            name="<?= 'materials_'.$value['amortization_id'];?>"
                                                                            value="<?= $value['materials'];?>"
                                                                            onfocusout="update_totals()"
                                                                            placeholder="0.00" <?=$readonly?> />
                                                                    </center>
                                                                </td>
                                                                <td>
                                                                    <center>
                                                                        <input type="text" class="currency"
                                                                            id="<?= 'fees_'.$value['amortization_id'];?>"
                                                                            name="<?= 'fees_'.$value['amortization_id'];?>"
                                                                            value="<?= $value['fee'];?>"
                                                                            onfocusout="update_totals()"
                                                                            placeholder="0.00" <?=$readonly?> />
                                                                    </center>
                                                                </td>
                                                            </tr>
                                                            <?php endforeach;?>
                                                        </tbody>
                                                    </table>
                                                    <br />
                                                    <div class="row" style="min-width: 300px; float: right;">
                                                        <table class="">
                                                            <tr>
                                                                <td>
                                                                    Total Tuition:
                                                                </td>
                                                                <td style="float: right;margin-right: 15px;">
                                                                    <span id="total_tuition">00.00</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Total Materials:
                                                                </td>
                                                                <td style="float: right;margin-right: 15px;">
                                                                    <span id="total_materials">00.00</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Total Fees:
                                                                </td>
                                                                <td style="float: right;margin-right: 15px;">
                                                                    <span id="total_fees">00.00</span>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="container row">
                                                    <span id="error"></span>
                                                </div>
                                                <div class="form-buttons row" style="float: right; margin-top: 10px;">
                                                    <button type="submit" class="btn btn-rounded btn-success">
                                                        <?=getPhrase('save')?>
                                                    </button>
                                                </div>
                                                <br />
                                                <br />
                                            </div>
                                            <?= form_close();?>
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
<script>
$(document).ready(function() {
    update_totals();
});

function add_installment() {
    var table = document.getElementById("tbl_installment");
    var no_rows = table.rows.length;

    document.getElementById('new_number_payments').value = no_rows;

    var row = table.insertRow(no_rows);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);

    cell1.innerHTML = no_rows;

    var cell2html = '<center>'
    cell2html += '    <input type="date"';
    cell2html += '        id="due_date_' + no_rows + '"';
    cell2html += '        name="due_date_' + no_rows + '"';
    cell2html += '    />';
    cell2html += '</center>';
    cell2.innerHTML = cell2html;

    var cell3html = '<center>'
    cell3html += '    <input type="text"';
    cell3html += '        class="currency"';
    cell3html += '        id="amount_' + no_rows + '"';
    cell3html += '        name="amount_' + no_rows + '"';
    cell3html += '        placeholder="0.00"';
    cell3html += '        onfocusout="update_totals()"';
    cell3html += '    />';
    cell3html += '</center>';
    cell3.innerHTML = cell3html;

    var cell4html = '<center>'
    cell4html += '    <input type="text"';
    cell4html += '        class="currency"';
    cell4html += '        id="materials_' + no_rows + '"';
    cell4html += '        name="materials_' + no_rows + '"';
    cell4html += '        placeholder="0.00"';
    cell4html += '        onfocusout="update_totals()"';
    cell4html += '    />';
    cell4html += '</center>';
    cell4.innerHTML = cell4html;

    var cell5html = '<center>'
    cell5html += '    <input type="text"';
    cell5html += '        class="currency"';
    cell5html += '        id="fee_' + no_rows + '"';
    cell5html += '        name="fee_' + no_rows + '"';
    cell5html += '        placeholder="0.00"';
    cell5html += '        onfocusout="update_totals()"';
    cell5html += '    />';
    cell5html += '</center>';
    cell5.innerHTML = cell5html;

}

function delete_installment() {
    var table = document.getElementById("tbl_installment");
    var last = table.rows.length - 1;

    if (last > <?= $agreement['number_payments'];?>) {
        table.deleteRow(last);
        document.getElementById('new_number_payments').value = (last - 1);
    }
}

function update_totals() {

    var tuition_arr = document.querySelectorAll('input[id^="amount_"]');
    var tuition = 0.00;
    for (var i = 0; i < tuition_arr.length; i++) {
        if (parseFloat(tuition_arr[i].value))
            tuition += parseFloat(tuition_arr[i].value);
    }

    $("#total_tuition").html(tuition.toFixed(2));

    var material_arr = document.querySelectorAll('input[id^="materials_"]');
    var material = 0.00;
    for (var i = 0; i < material_arr.length; i++) {
        if (parseFloat(material_arr[i].value))
            material += parseFloat(material_arr[i].value);
    }

    $("#total_materials").html(material.toFixed(2));

    var fee_arr = document.querySelectorAll('input[id^="fees_"]');
    var fee = 0.00;
    for (var i = 0; i < fee_arr.length; i++) {
        if (parseFloat(fee_arr[i].value))
            fee += parseFloat(fee_arr[i].value);
    }

    $("#total_fees").html(fee.toFixed(2));


}

function validateForm() {
    var validated = true;
    var total_tuition = parseFloat(<?= floatval($total_tuition);?>);
    var total_material = parseFloat(<?= floatval($agreement['materials']);?>);
    var total_fee = parseFloat(<?= floatval($agreement['fees']);?>);

    var tuition_arr = document.querySelectorAll('input[id^="amount_"]');
    var tuition = 0.00;
    for (var i = 0; i < tuition_arr.length; i++) {
        if (parseFloat(tuition_arr[i].value))
            tuition += parseFloat(tuition_arr[i].value);
    }

    var material_arr = document.querySelectorAll('input[id^="materials_"]');
    var material = 0.00;
    for (var i = 0; i < material_arr.length; i++) {
        if (parseFloat(material_arr[i].value))
            material += parseFloat(material_arr[i].value);
    }

    var fee_arr = document.querySelectorAll('input[id^="fees_"]');
    var fee = 0.00;
    for (var i = 0; i < fee_arr.length; i++) {
        if (parseFloat(fee_arr[i].value))
            fee += parseFloat(fee_arr[i].value);
    }

    var html = "";

    // Validate Amounts
    if (total_tuition != tuition) {
        html += "<b style='color:#ff214f'>The tuition must be equal to the contract.</b><br/>";
        validated = false;
    }

    if (total_material != material) {
        html += "<b style='color:#ff214f'>The materials must be equal to the contract.</b><br/>";
        validated = false;
    }

    if (total_fee != fee) {
        html += "<b style='color:#ff214f'>The fees must be equal to the contract.</b><br/>";
        validated = false;
    }

    // Validate dates
    var due_date_arr = document.querySelectorAll('input[id^="due_date_"]');
    
    for (var i = 0; i < due_date_arr.length; i++) {
        if (!due_date_arr[i].value)
        {
            html += "<b style='color:#ff214f'>Enter a valid date on the due date.</b><br/>";
            validated = false;
        }
    }


    $("#error").html(html);

    return validated;
}
</script>