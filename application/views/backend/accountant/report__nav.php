                    <ul class="navs navs-tabs upper">
                        <li class="navs-item">
                            <a class="navs-links <?= $page_name == 'report_dashboard' ? 'active' : ''?>" href="<?= base_url();?>accountant/report_dashboard/"><i
                                    class="os-icon picons-thin-icon-thin-0482_gauge_dashboard_empty"></i><span><?= getPhrase('home');?></span></a>
                        </li>
                        <li class="navs-item">
                            <a class="navs-links <?= $page_name == 'report_daily_income' ? 'active' : ''?>" href="<?= base_url();?>accountant/report_daily_income/"><i
                                    class="os-icon picons-thin-icon-thin-0426_money_payment_dollars_coins_cash"></i><span><?= getPhrase('daily_income');?></span></a>
                        </li>
                        <li class="navs-item">
                            <a class="navs-links <?= $page_name == 'report_monthly_income' ? 'active' : ''?>" href="<?= base_url();?>accountant/report_monthly_income/"><i
                                    class="os-icon picons-thin-icon-thin-0426_money_payment_dollars_coins_cash"></i><span><?= getPhrase('monthly_income');?></span></a>
                        </li>
                        <li class="navs-item">
                            <a class="navs-links <?= $page_name == 'report_payments' ? 'active' : ''?>" href="<?= base_url();?>accountant/report_payments/"><i
                                    class="os-icon picons-thin-icon-thin-0426_money_payment_dollars_coins_cash"></i><span><?= getPhrase('payments');?></span></a>
                        </li>
                        <li class="navs-item">
                            <a class="navs-links <?= $page_name == 'report_expense' ? 'active' : ''?>" href="<?= base_url();?>accountant/report_expense/"><i
                                    class="os-icon picons-thin-icon-thin-0420_money_cash_coins_payment_dollars"></i><span><?= getPhrase('expense');?></span></a>
                        </li>                        
                    </ul>