<?php
    $system_name        =	$this->crud->getInfo('system_name');
    $system_email       =   $this->crud->getInfo('system_email');
    $address            =   $this->crud->getInfo('address');
    $running_year       =   $this->crud->getInfo('running_year');
    $running_semester   =   $this->crud->getInfo('running_semester');
    $roundPrecision     =   $this->crud->getInfo('round_precision');
    $phone              =   $this->crud->getInfo('phone');
    $currency_symbol    =   $this->crud->getInfo('currency');

    $payment_info = $this->payment->get_payment_info($payment_id);

    if($payment_info['user_type'] == 'applicant')
    {
        $customer_info = $this->applicant->get_applicant_info($payment_info['user_id']);
    }
    else
    {
        $customer_info = $this->studentModel->get_student_info($payment_info['user_id']);     
    }   
    
?>
<link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet" type="text/css">
<link href="<?= base_url();?>public/style/cms/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css"
    rel="stylesheet">
<link href="<?= base_url();?>public/style/cms/css/main.css?version=3.3" rel="stylesheet">
<style>
* {
    -webkit-print-color-adjust: exact !important;
    /* Chrome, Safari */
    color-adjust: exact !important;
    /*Firefox*/
}
</style>
<div class="content-w">
    <div class="conty">
        <div class="content-i">
            <div class="content-box">
                <div class="element-wrapper">
                    <button type="button" class="btn btn-rounded btn-success"
                        onclick="Print('invoice_id')"><?= getPhrase('print');?></button>
                    <br><br>
                    <div class="invoice-w" id="invoice_id" style="padding-top: 50px !important;">
                        <div class="infos">
                            <div class="info-1">
                                <div class="invoice-logo-w">
                                    <img alt=""
                                        src="<?= base_url();?>public/uploads/<?= $this->crud->getInfo('logo');?>">
                                </div>
                            </div>
                            <div class="info-2" style="float:right; padding-top: 25px !important;"><br><br>
                                <div class="company-name" style="color:#000;">
                                    American One English Schools
                                </div>
                                <div class="company-address" bis_skin_checked="1">
                                    <?=$address;?>
                                </div>
                                <!-- <div class="company-name">
                                    <?= $this->crud->get_name($payment_info['user_type'], $payment_info['user_id']);?>
                                </div> -->
                            </div>

                        </div>
                        <div class="invoice-heading">
                            <div class="row">
                                <h3><?= getPhrase('invoice');?></h3>
                            </div>
                            <br/>
                            <div class="row">
                                <table>
                                    <tr>
                                        <td style="width: 80px;">
                                            <b>Name:</b>
                                        </td>
                                        <td style="width: 300px;">
                                            <?=$customer_info['full_name']?>
                                        </td>
                                        <td style="width: 80px;">
                                            <b>Invoice:</b>
                                        </td>
                                        <td style="width: 200px;">
                                           <?=$payment_info['invoice_number']?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                           <b>Address:</b>
                                        </td>
                                        <td>
                                           <?=$customer_info['address']?>
                                        </td>
                                        <td>
                                           <b>Date:</b>
                                        </td>
                                        <td>
                                           <?=$payment_info['invoice_date']?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <table>
                                                <tr>
                                                    <td>
                                                       <b>City:</b>
                                                    </td>
                                                    <td>
                                                       <?=$payment_info['city']?>
                                                    </td>
                                                    <td>
                                                       <b>State:</b>
                                                    </td>
                                                    <td>
                                                       <?=$payment_info['state']?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                       <b>Zip Code:</b>
                                                    </td>
                                                    <td>
                                                       <?=$payment_info['postal_code']?>
                                                    </td>
                                                    <td>
                                                       <b>Phone:</b>
                                                    </td>
                                                    <td>
                                                       <?=$customer_info['phone']?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                           <b>Cashier:</b>
                                        </td>
                                        <td>
                                           <?=$this->crud->get_name($payment_info['created_by_type'], $payment_info['created_by'])?>
                                        </td>
                                    </tr>
                                </table>
                                <!-- <div class="invoice-date">
                                    <?= $payment_info['invoice_number'];?>
                                </div> -->
                            </div>


                        </div>
                        <div class="invoice-body">
                            <div class="invoice-table" style="width:100%;">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th><?= getPhrase('title');?></th>
                                            <th><?= getPhrase('description');?></th>
                                            <th class="text-right"><?= getPhrase('amount');?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $payment_details = $this->payment->get_payment_details($payment_id);
                                            $total_details = 0.00;
                                            foreach($payment_details as $item):
                                                $total_details += $item['amount'];
                                            ?>
                                        <tr>
                                            <td>
                                                <?= $this->payment->get_income_type_name($item['concept_type']);?>
                                            </td>
                                            <td>
                                                <?= $item['comment'];?>
                                            </td>
                                            <td class="text-right">
                                                <?= $currency_symbol?><?= $item['amount'];?>
                                            </td>
                                        </tr>
                                        <?php endforeach;?>
                                        <?php 
                                            $payment_discounts = $this->payment->get_payment_discounts($payment_id);
                                            $total_discounts = 0.00;
                                            foreach($payment_discounts as $item):
                                                $total_discounts += $item['amount'];
                                            ?>
                                        <tr>
                                            <td>
                                                <?= $this->payment->get_discount_type_name($item['discount_type']);?>
                                            </td>
                                            <td>
                                                <?= $item['comment'];?>
                                            </td>
                                            <td class="text-right">
                                                <?= '-'.$currency_symbol.''.$item['amount'];?>
                                            </td>
                                        </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>
                                                <?= getPhrase('total');?>
                                            </td>
                                            <td class="text-right" colspan="2">
                                                <?php $total = $total_details - $total_discounts; ?>
                                                <?= $currency_symbol.' '.$total;?>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="invoice-footer">
                            <div class="invoice-logo">
                                <img
                                    src="<?= base_url();?>public/uploads/<?= $this->crud->getInfo('logo');?>"><span><?= $this->crud->getInfo('system_name');?></span>
                            </div>
                            <div class="invoice-info">
                                <span><?= $this->crud->getInfo('system_email');?></span><span><?= $this->crud->getInfo('phone');?></span>
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