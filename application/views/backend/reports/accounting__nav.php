                    <ul class="navs navs-tabs upper">
                        <?php if(has_permission('accounting_dashboard')):?>
                        <li class="navs-item">
                            <a class="navs-links <?= $page_name == 'accounting_dashboard' ? 'active' : ''?>"
                                href="<?php echo base_url();?>reports/accounting_dashboard/">
                                <i class="os-icon picons-thin-icon-thin-0482_gauge_dashboard_empty"></i>
                                <span><?php echo getPhrase('home');?></span>
                            </a>
                        </li>
                        <?php endif;?>
                        <li class="navs-item">
                            <a class="navs-links <?= $page_name == 'accounting_daily_income' ? 'active' : ''?>"
                                href="<?= base_url();?>reports/accounting_daily_income/">
                                <i class="os-icon picons-thin-icon-thin-0426_money_payment_dollars_coins_cash"></i>
                                <span><?= getPhrase('daily_income');?></span>
                            </a>
                        </li>
                        <?php if(has_permission('accounting_dashboard')):?>
                        <li class="navs-item">
                            <a class="navs-links <?= $page_name == 'accounting_payments' ? 'active' : ''?>"
                                href="<?php echo base_url();?>reports/accounting_monthly_income/">
                                <i class="os-icon picons-thin-icon-thin-0426_money_payment_dollars_coins_cash"></i>
                                <span><?php echo getPhrase('monthly_income');?></span>
                            </a>
                        </li>
                        <?php endif;?>
                        <?php if(has_permission('accounting_dashboard')):?>
                        <li class="navs-item">
                            <a class="navs-links <?= $page_name == 'accounting_payments' ? 'active' : ''?>"
                                href="<?php echo base_url();?>reports/accounting_payments/">
                                <i class="os-icon picons-thin-icon-thin-0420_money_cash_coins_payment_dollars"></i>
                                <span><?php echo getPhrase('payments');?></span>
                            </a>
                        </li>
                        <?php endif;?>
                        <?php if(has_permission('accounting_agreements')):?>
                        <li class="navs-item">
                            <a class="navs-links <?= $page_name == 'accounting_agreements' ? 'active' : ''?>"
                                href="<?php echo base_url();?>reports/accounting_agreements/">
                                <i class="os-icon picons-thin-icon-thin-0394_business_handshake_deal_contract_sign"></i>
                                <span><?php echo getPhrase('agreements');?></span>
                            </a>
                        </li>
                        <?php endif;?>                           
                        <!-- <li class="navs-item">
                            <a class="navs-links <?= $page_name == 'report_dashboard' ? 'active' : ''?>" href="<?php echo base_url();?>reports/expense/"><i
                                    class="os-icon picons-thin-icon-thin-0420_money_cash_coins_payment_dollars"></i><span><?php echo getPhrase('expense');?></span></a>
                        </li> -->
                    </ul>