<?php 
    $running_year       = $this->crud->getInfo('running_year');
    $running_semester   = $this->crud->getInfo('running_semester');
?>    
    <div class="content-w" > 
        <?php include 'fancy.php';?>
        <div class="header-spacer"></div>
        <div class="conty">
            <div class="os-tabs-w menu-shad">
                <div class="os-tabs-controls">
                    <?php include 'request__nav.php';?>
                </div>
            </div><br>
    	    <div class="container-fluid">
                <div class="layout-w">
                    <div class="content-w">
                        <div class="content-i">
                            <div class="content-box">
                                <div class="app-em ail-w">
                                    <div class="ae-conte nt-w">
                                        <div class="aec-full-message-w">
                                            <div class="aec-full -message">
                                                <div class="container- fluid">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <h2 style="float:left"><?= getPhrase('requesting');?>
                                                            </h2>
                                                        </div>
                                                        <hr>
                                                        <!-- <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="ui-block list" data-mh="friend-groups-item"
                                                                >
                                                                <div class="friend-item friend-groups">
                                                                    <div class="friend-item-content">
                                                                        <div class="friend-avatar">
                                                                            <br><br>
                                                                            <i class="picons-thin-icon-thin-0383_graph_columns_growth_statistics"
                                                                                style="font-size:45px; color: #99bf2d;"></i>
                                                                            <h1 style="font-weight:bold;">
                                                                                <?= $currency; ?>
                                                                                <?php 
                                                                                $this->db->reset_query();
                                                                                $this->db->select_sum('amount');
                                                                                $this->db->where('year' , $running_year);
                                                                                $this->db->where('semester_id', $running_semester);
                                                                                $payments = $this->db->get('payment')->row(); 
                                                                                echo number_format($payments->amount, 2);?>
                                                                            </h1>
                                                                            <div class="author-content">
                                                                                <div class="country"><b>
                                                                                        <?= getPhrase('total_income');?></b>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="ui-block list" data-mh="friend-groups-item"
                                                                >
                                                                <div class="friend-item friend-groups">
                                                                    <div class="friend-item-content">
                                                                        <div class="friend-avatar">
                                                                            <br><br>
                                                                            <i class="picons-thin-icon-thin-0384_graph_columns_drop_statistics"
                                                                                style="font-size:45px; color: #dd2979;"></i>
                                                                            <h1 style="font-weight:bold;">
                                                                                <?= $currency; ?>
                                                                                <?php 
                                                                                $this->db->reset_query();
                                                                                $this->db->select_sum('amount');
                                                                                $this->db->where('year' , $running_year);
                                                                                $this->db->where('semester_id', $running_semester);
                                                                                $payments = $this->db->get('invoice')->row(); 
                                                                                echo number_format($payments->amount, 2);?>
                                                                            </h1>
                                                                            <div class="author-content">
                                                                                <div class="country"><b>
                                                                                        <?= getPhrase('total_expense');?></b>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="ui-block list" data-mh="friend-groups-item"
                                                                >
                                                                <div class="friend-item friend-groups">
                                                                    <div class="friend-item-content">
                                                                        <div class="friend-avatar">
                                                                            <br><br>
                                                                            <i class="picons-thin-icon-thin-0406_money_dollar_euro_currency_exchange_cash"
                                                                                style="font-size:45px; color: #f4af08 ;"></i>
                                                                            <h1 style="font-weight:bold;">
                                                                                <?php $this->db->where('status', 'pending'); echo $this->db->count_all_results('invoice');?>
                                                                            </h1>
                                                                            <div class="author-content">
                                                                                <div class="country"><b>
                                                                                        <?= getPhrase('pending_payments');?></b>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="ui-block list" data-mh="friend-groups-item"
                                                                >
                                                                <div class="friend-item friend-groups">
                                                                    <div class="friend-item-content">
                                                                        <div class="friend-avatar">
                                                                            <br><br>
                                                                            <i class="picons-thin-icon-thin-0406_money_dollar_euro_currency_exchange_cash"
                                                                                style="font-size:45px; color: #0084ff;"></i>
                                                                            <h1 style="font-weight:bold;">
                                                                                <?php $this->db->where('status', 'completed'); echo $this->db->count_all_results('invoice');?>
                                                                            </h1>
                                                                            <div class="author-content">
                                                                                <div class="country"><b>
                                                                                        <?= getPhrase('completed_payments');?></b>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> -->
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
                <div class="display-type"></div>
            </div>
        </div>
    </div>