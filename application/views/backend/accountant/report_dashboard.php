    <?php 
        $running_year = $this->crud->getInfo('running_year'); 
        $running_semester = $this->crud->getInfo('running_semester'); 
        $currency = $this->crud->getInfo('currency');
    ?>
    <div class="content-w">
        <?php include 'fancy.php';?>
        <div class="header-spacer"></div>
        <div class="conty">
            <div class="os-tabs-w menu-shad">
                <div class="os-tabs-controls">
                    <?php include "report__nav.php";?>
                </div>
            </div><br>
            <div class="container-fluid">
                <div class="layout-w">
                    <div class="content-w">
                        <div class="content-i">
                            <div class="content-box">
                                <div class="app-em ail-w">
                                    <div class="ae-conte nt-w">
                                        <div class="aec-full-m essage-w">
                                            <div class="aec-full -message">
                                                <div class="container- fluid">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <h2 style="float:left"><?= getPhrase('accounting');?>
                                                            </h2>
                                                        </div>
                                                        <hr>
                                                        <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="ui-block list" data-mh="friend-groups-item"
                                                                style="">
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
                                                                style="">
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
                                                                style="">
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
                                                                style="">
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
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="element-wrapper">
                                                                <h6 class="element-header">
                                                                    <?= getPhrase('recent_income');?></h6>
                                                                <div class="element-box-tp">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-padded">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th><?= getPhrase('user');?>
                                                                                    </th>
                                                                                    <th><?= getPhrase('comment');?>
                                                                                    </th>
                                                                                    <th><?= getPhrase('amount');?>
                                                                                    </th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                    $this->db->reset_query();
                                                                                    $this->db->limit(10);
                                                                                    $this->db->where('year' , $running_year);
                                                                                    $this->db->where('semester_id', $running_semester);
                                                                                    $this->db->order_by('created_at' , 'desc');
                                                                                    $invoices = $this->db->get('payment')->result_array();
                                                                                    foreach($invoices as $row):
                                                                                ?>
                                                                                <tr>
                                                                                    <td class="cell-with-media">
                                                                                        <a href="<?php echo base_url();?>accountant/payment_invoice/<?= base64_encode($row['payment_id']);?>"
                                                                                            class="grey"
                                                                                            target="_blank">
                                                                                            <img alt=""
                                                                                                src="<?= $this->crud->get_image_url($row['user_type'], $row['user_id']);?>"
                                                                                                style="height: 25px;">
                                                                                            <span>
                                                                                                <?= $this->crud->get_name($row['user_type'], $row['user_id']);?>
                                                                                            </span>
                                                                                        </a>
                                                                                    </td>
                                                                                    <td>
                                                                                        <?= substr($row['comment'], 0, 50);?>
                                                                                    </td>
                                                                                    <td><a class="badge badge-primary"
                                                                                            href="javascript:void(0);"><?= $this->crud->getInfo('currency'); ?><?= $row['amount'];?></a>
                                                                                    </td>
                                                                                </tr>
                                                                                <?php endforeach;?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="element-wrapper">
                                                                <h6 class="element-header">
                                                                    <?= getPhrase('recent_expense');?></h6>
                                                                <div class="element-box-tp">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-padded">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th><?= getPhrase('title');?>
                                                                                    </th>
                                                                                    <th><?= getPhrase('category');?>
                                                                                    </th>
                                                                                    <th><?= getPhrase('amount');?>
                                                                                    </th>
                                                                                    <th><?= getPhrase('method');?>
                                                                                    </th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php 
                                                                	            $this->db->limit(10);
                                                            	                // $this->db->where('payment_type' , 'expense');
                                                            	                // $this->db->where('year' , $running_year);
                                                                        	    // $this->db->order_by('timestamp' , 'desc');
                                                            	                $expenses = $this->db->get('invoice')->result_array();
                                                            	                foreach ($expenses as $row):
                                                        	                ?>
                                                                                <tr>
                                                                                    <td><?= $row['title'];?></td>
                                                                                    <td>
                                                                                        <a
                                                                                            class="btn btn-sm btn-rounded btn-purple text-white"><?php 
                                                                                            if ($row['expense_category_id'] != 0 || $row['expense_category_id'] != '')
                                                                                            echo $this->db->get_where('expense_category' , array('expense_category_id' => $row['expense_category_id']))->row()->name;
                                                                                            ?>
                                                                                        </a>
                                                                                    </td>
                                                                                    <td><?= $this->crud->getInfo('currency');?><?= $row['amount'];?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a class="btn nc btn-rounded btn-sm btn-primary"
                                                                                            style="color:white">
                                                                                            <?php 
                                                                                            if ($row['method'] == 1) echo getPhrase('cash');
                                                                                            if ($row['method'] == 2) echo getPhrase('check');
                                                                                            if ($row['method'] == 3) echo getPhrase('card');
                                                                                        ?>
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
                                                    </div><br>
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