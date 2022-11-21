                    <ul class="navs navs-tabs upper">
                        <li class="navs-item">
                            <a class="navs-links <?= $page_name == 'accounting_dashboard' ? 'active' : ''?>"
                                href="<?php echo base_url();?>admin/accounting_dashboard/">
                                <i class="os-icon picons-thin-icon-thin-0482_gauge_dashboard_empty"></i>
                                <span><?php echo getPhrase('home');?></span>
                            </a>
                        </li>
                        <li class="navs-item">
                            <a class="navs-links <?= $page_name == 'accounting_daily_income' ? 'active' : ''?>"
                                href="<?= base_url();?>admin/accounting_daily_income/">
                                <i class="os-icon picons-thin-icon-thin-0426_money_payment_dollars_coins_cash"></i>
                                <span><?= getPhrase('daily_income');?></span>
                            </a>
                        </li>
                        <li class="navs-item">
                            <a class="navs-links <?= $page_name == 'accounting_payments' ? 'active' : ''?>"
                                href="<?php echo base_url();?>admin/accounting_payments/">
                                <i class="os-icon picons-thin-icon-thin-0420_money_cash_coins_payment_dollars"></i>
                                <span><?php echo getPhrase('payments');?></span>
                            </a>
                        </li>
                        <!-- <li class="navs-item">
                            <a class="navs-links <?= $page_name == 'report_dashboard' ? 'active' : ''?>" href="<?php echo base_url();?>admin/expense/"><i
                                    class="os-icon picons-thin-icon-thin-0420_money_cash_coins_payment_dollars"></i><span><?php echo getPhrase('expense');?></span></a>
                        </li> -->
                    </ul>