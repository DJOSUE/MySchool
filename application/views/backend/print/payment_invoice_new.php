<?php 
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

    $payment_details = $this->payment->get_payment_details($payment_id);    
    $payment_discounts = $this->payment->get_payment_discounts($payment_id);
    
    $total_details = 0.00;
    $total_discounts = 0.00;
    
    
?>
<style>
    .text-right
    {
        margin-left: auto; 
        margin-right: 0;
        text-align: right;
    }
    #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #customers td, #customers th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #customers tr:nth-child(even){background-color: #f2f2f2;}

    #customers tr:hover {background-color: #ddd;}

    #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #04AA6D;
        color: white;
    }
</style>

<div class="row">
    <br/><br/>
    <div class="text-right">
        <h4>Invoice</h4>
    </div>
    <br/>
    <div class="">
        <table>            
            <tr>
                <td style="width: 80px;">
                    <small><b>Name:</b></small>
                </td>
                <td style="width: 300px;">
                    <small><?=$customer_info['full_name']?></small>
                </td>
                <td style="width: 80px;">
                    <small><b>Invoice:</b></small>
                </td>
                <td style="width: 200px;">
                    <small><?=$payment_info['invoice_number']?></small>
                </td>
            </tr>
            <tr>
                <td>
                    <small><b>Address:</b></small>
                </td>
                <td>
                    <small><?=$customer_info['address']?></small>
                </td>
                <td>
                    <small><b>Date:</b></small>
                </td>
                <td>
                    <small><?=$payment_info['invoice_date']?></small>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table>
                         <tr>
                            <td>
                                <small><b>City:</b></small>
                            </td>
                            <td>
                                <small><?=$payment_info['city']?></small>
                            </td>
                            <td>
                                <small><b>State:</b></small>
                            </td>
                            <td>
                                <small><?=$payment_info['state']?></small>
                            </td>
                         </tr>
                         <tr>
                            <td>
                                <small><b>Zip Code:</b></small>
                            </td>
                            <td>
                                <small><?=$payment_info['postal_code']?></small>
                            </td>
                            <td>
                                <small><b>Phone:</b></small>
                            </td>
                            <td>
                                <small><?=$customer_info['phone']?></small>
                            </td>
                         </tr>
                    </table>
                </td>
                <td>
                    <small><b>Cashier:</b></small>
                </td>
                <td>
                    <small><?=$this->crud->get_name($payment_info['created_by_type'], $payment_info['created_by'])?></small>
                </td>
            </tr>
        </table>
    </div>
    <div class="invoice-table" style="width:100%;">
        <table class="table" id="customers">
            <thead>
                <tr>
                    <th>
                        <small>
                            <b><?= getPhrase('description');?></b>
                        </small>
                    </th>
                    <th class="text-right">
                        <small>
                            <b><?= getPhrase('amount');?></b>
                        </small>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach($payment_details as $item):
                    $total_details += $item['amount'];
                ?>
                <tr>
                    <td>
                        <small>
                            <?= $this->payment->get_income_type_name($item['concept_type']);?>
                        </small>
                    </td>
                    <td class="text-right">
                        <small>
                            <?= $currency_symbol?><?= $item['amount'];?>
                </small>
                    </td>
                </tr>
                <?php endforeach;?>
                <?php 
                foreach($payment_discounts as $item):
                    $total_discounts += $item['amount'];
                ?>
                <tr>
                    <td>
                        <small>
                            <?= $this->payment->get_discount_type_name($item['discount_type']);?>
                        </small>
                    </td>
                    <td class="text-right">
                        <small>
                            <?= '-'.$currency_symbol.''.$item['amount'];?>
                        </small>
                    </td>
                </tr>
                <?php endforeach;?>
                <tfoot>
                    <tr>
                        <td>                            
                        </td>
                        <td class="text-right">
                            <table>
                                <tr>
                                    <td class="text-right">
                                        <small>
                                            <?= getPhrase('total');?>
                                        </small>
                                    </td>
                                    <td>
                                        <?php $total = $total_details - $total_discounts; ?>
                                        <small>
                                            <?= $currency_symbol.' '.$total;?>
                                        </small>
                                    </td>
                                </tr>
                            </table>                            
                        </td>
                    </tr>
                </tfoot>
            </tbody>
        </table>
    </div>
</div>