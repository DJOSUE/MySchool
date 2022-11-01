    <?php 
    
    $this->db->reset_query();                                                
    $this->db->order_by('created_at' , 'desc');
    $invoices = $this->db->get_where('payment', array('user_type' => 'student','user_id' => $student_id))->result_array();
    $date_format = $this->crud->getInfo('date_format');
    
    ?>
    <div class="content-w">
        <?php include 'fancy.php';?>
        <div class="header-spacer"></div>
        <div class="conty">
            <div class="content-i">
                <div class="content-box">
                    <div class="element-wrapper">
                        <h6 class="element-header"><?= getPhrase('payments');?></h6>
                        <div class="element-box-tp">
                            <div class="table-responsive">
                                <table class="table table-padded">
                                    <thead>
                                        <tr>
                                            <th><?= getPhrase('invoice_number');?></th>
                                            <th class="text-center"><?= getPhrase('amount');?></th>
                                            <th><?= getPhrase('date');?></th>
                                            <th><?= getPhrase('invoice');?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        foreach($invoices as $row):
                                            $created_at = strtotime($row['created_at']);    
                                        ?>
                                        <tr>
                                            <td>
                                                <?= $row['invoice_number'];?>
                                            </td>
                                            <td class="text-center">
                                                <strong>
                                                    <?= $this->db->get_where('settings' , array('type' =>'currency'))->row()->description;?><?= $row['amount'];?>
                                                </strong>
                                            </td>
                                            <td>
                                                <a class="btn nc btn-rounded btn-sm btn-secondary"
                                                    style="color:white"><?= date($date_format, $created_at);?></a>
                                            </td>
                                            <td>
                                                <a class="btn btn-rounded btn-primary" style="color:white"
                                                    target="_blank"
                                                    href="<?= base_url();?>student/view_invoice/<?= base64_encode($row['payment_id']);?>">
                                                    <i
                                                        class="picons-thin-icon-thin-0406_money_dollar_euro_currency_exchange_cash"></i>
                                                    <?= getPhrase('invoice');?>
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
            </div>
        </div>
    </div>