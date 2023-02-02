<?php
    $system_name        =	$this->crud->getInfo('system_name');
    $system_email       =   $this->crud->getInfo('system_email');
    $running_year       =   $this->crud->getInfo('running_year');
    $running_semester   =   $this->crud->getInfo('running_semester');
    $roundPrecision     =   $this->crud->getInfo('round_precision');
    $phone              =   $this->crud->getInfo('phone');
    $currency_symbol    =   $this->crud->getInfo('currency');

    $payment_info = $this->payment->get_payment_info($payment_id);
    
?>
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet" type="text/css">
    <link href="<?= base_url();?>public/style/cms/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url();?>public/style/cms/css/main.css?version=3.3" rel="stylesheet">
    <style>
        * {
            -webkit-print-color-adjust: exact !important;   /* Chrome, Safari */
            color-adjust: exact !important;                 /*Firefox*/
        }
    </style>
    <div class="content-w">
        <div class="conty">
            <div class="content-i">
                <div class="content-box">
                    <div class="element-wrapper">
                        <button type="button" class="btn btn-rounded btn-success" onclick="Print('invoice_id')"><?= getPhrase('print');?></button>
	                    <br><br>
                        <div class="invoice-w" id="invoice_id">                            
                            <div class="infos">
                                <div class="info-1">
                                    <div class="invoice-logo-w">
                                        <img alt="" src="<?= base_url();?>public/uploads/<?= $this->crud->getInfo('logo');?>">
                                    </div>
                                    <div class="company-name" style="color:#000;">
    				                    <?= $system_name;?>
			                        </div>
                                </div>
                                <div class="info-2" style="float:right"><br><br>                                    
                                    <div class="company-name"><?= $this->crud->get_name($payment_info['user_type'], $payment_info['user_id']);?></div>
                                </div>
                            </div>
                            <div class="invoice-heading">
                                <h3><?= getPhrase('invoice');?></h3>
                                <div class="invoice-date">
                                    <?= $payment_info['invoice_number'];?>
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
                                    <img src="<?= base_url();?>public/uploads/<?= $this->crud->getInfo('logo');?>"><span><?= $this->crud->getInfo('system_name');?></span>
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
        function Print(div) 
        {
            var printContents = document.getElementById(div).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>    