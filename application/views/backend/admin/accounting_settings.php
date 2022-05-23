<?php $running_year = $this->crud->getInfo('running_year'); ?>
    <div class="content-w">
	    <?php include 'fancy.php';?>
        <div class="header-spacer"></div>
        <div class="conty">
            <div class="os-tabs-w menu-shad">
                <div class="os-tabs-controls">
                    <ul class="navs navs-tabs upper">
                        <li class="navs-item">
                            <a class="navs-links" href="<?php echo base_url();?>admin/payments/"><i class="os-icon picons-thin-icon-thin-0482_gauge_dashboard_empty"></i><span><?php echo getPhrase('home');?></span></a>
                        </li>
                        <li class="navs-item">
                            <a class="navs-links" href="<?php echo base_url();?>admin/students_payments/"><i class="os-icon picons-thin-icon-thin-0426_money_payment_dollars_coins_cash"></i><span><?php echo getPhrase('payments');?></span></a>
                        </li>
                        <li class="navs-item">
                            <a class="navs-links" href="<?php echo base_url();?>admin/expense/"><i class="os-icon picons-thin-icon-thin-0420_money_cash_coins_payment_dollars"></i><span><?php echo getPhrase('expense');?></span></a>
                        </li>
                        <li class="navs-item">
                            <a class="navs-links active" href="<?php echo base_url();?>admin/accounting_settings/"><i class="os-icon picons-thin-icon-thin-0049_settings_panel_equalizer_preferences"></i><span><?php echo getPhrase('accounting_settings');?></span></a>
                        </li>
                    </ul>
                </div>
            </div><br>
            <div class="content-i"> 
                <div class="content-box">
	                <div class="element-wrapper">
		                <div class="row">
		                    <div class="col-sm-3">
                                <div class="profile-tile profile-tile-inlined">
                                    <a class="profile-tile-box full-width" href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_gateway/paypal');">
                                        <div class="pt-avatar-w no-border"><br>
                                            <img alt="" class="imgwidth85" src="<?php echo base_url();?>public/style/images/gateways/paypal.png"> <?php if($this->db->get_where('payment_gateways', array('name' => 'paypal'))->row()->status == 1):?><div class="status-pill green" data-title="<?php echo getPhrase('enabled');?>" data-toggle="tooltip" data-original-title="" title=""></div><?php else:?><div class="status-pill red" data-title="<?php echo getPhrase('disabled');?>" data-toggle="tooltip" data-original-title="" title=""></div><?php endif;?>
                                        </div><br><br>
                                    </a>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="profile-tile profile-tile-inlined">
                                    <a class="profile-tile-box full-width" href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_gateway/stripe');">
                                        <div class="pt-avatar-w no-border"><br>
                                            <img alt="" src="<?php echo base_url();?>public/style/images/gateways/stripe.png"> <?php if($this->db->get_where('payment_gateways', array('name' => 'stripe'))->row()->status == 1):?><div class="status-pill green" data-title="<?php echo getPhrase('enabled');?>" data-toggle="tooltip" data-original-title="" title=""></div><?php else:?><div class="status-pill red" data-title="<?php echo getPhrase('disabled');?>" data-toggle="tooltip" data-original-title="" title=""></div><?php endif;?>
                                        </div><br><br>
                                    </a>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="profile-tile profile-tile-inlined">
                                    <a class="profile-tile-box full-width" href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_gateway/razorpay');"><br>
                                        <div class="pt-avatar-w no-border">
                                            <img alt="" class="imgwidth85" src="<?php echo base_url();?>public/style/images/gateways/razorpay.png"> <?php if($this->db->get_where('payment_gateways', array('name' => 'razorpay'))->row()->status == 1):?><div class="status-pill green" data-title="<?php echo getPhrase('enabled');?>" data-toggle="tooltip" data-original-title="" title=""></div><?php else:?><div class="status-pill red" data-title="<?php echo getPhrase('disabled');?>" data-toggle="tooltip" data-original-title="" title=""></div><?php endif;?>
                                        </div><br><br>
                                    </a>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="profile-tile profile-tile-inlined">
                                    <a class="profile-tile-box full-width" href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_gateway/paystack');">
                                        <div class="pt-avatar-w no-border"><br>
                                            <img alt="" class="imgwidth85" src="<?php echo base_url();?>public/style/images/gateways/paystack.png"> <?php if($this->db->get_where('payment_gateways', array('name' => 'paystack'))->row()->status == 1):?><div class="status-pill green" data-title="<?php echo getPhrase('enabled');?>" data-toggle="tooltip" data-original-title="" title=""></div><?php else:?><div class="status-pill red" data-title="<?php echo getPhrase('disabled');?>" data-toggle="tooltip" data-original-title="" title=""></div><?php endif;?>
                                        </div><br><br>
                                    </a>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="profile-tile profile-tile-inlined">
                                    <a class="profile-tile-box full-width" href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_gateway/flutterwave');">
                                        <div class="pt-avatar-w no-border"><br>
                                            <img alt="" class="imgwidth85" src="<?php echo base_url();?>public/style/images/gateways/flutterwave.png"> <?php if($this->db->get_where('payment_gateways', array('name' => 'flutterwave'))->row()->status == 1):?><div class="status-pill green" data-title="<?php echo getPhrase('enabled');?>" data-toggle="tooltip" data-original-title="" title=""></div><?php else:?><div class="status-pill red" data-title="<?php echo getPhrase('disabled');?>" data-toggle="tooltip" data-original-title="" title=""></div><?php endif;?>
                                        </div><br><br>
                                    </a>
                                </div>
                            </div>
		                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>