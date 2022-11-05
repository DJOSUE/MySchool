<?php 
    $running_year = $this->crud->getInfo('running_year');
    $running_semester = $this->crud->getInfo('running_semester'); 

    $startDate  = date_format(date_create($start_date), "Y-m-d");
    $endDate    = date_format(date_create($end_date), "Y-m-d");

    $this->db->reset_query();    
    $this->db->where('created_at >=', $startDate);
    $this->db->where('created_at <=', $endDate);
    $payments = $this->db->get('payment')->result_array();

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
        <div class="content-i">
            <div class="content-box">
                <div class="element-wrapper">
                    <div class="tab-content">
                        <?= form_open(base_url() . 'accountant/report_payments/');?>
                        <div class="row">
                            <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group label-floating is-select" style="background-color: #fff;">
                                    <label class="control-label"><?= getPhrase('start_date');?></label>
                                    <div class="form-group date-time-picker">
                                        <input type="text" autocomplete="off" class="datepicker-here"
                                            data-position="bottom left" data-language='en' name="start_date"
                                            id="start_date" value="<?=$start_date?>">

                                    </div>
                                </div>
                            </div>
                            <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group label-floating is-select" style="background-color: #fff;">
                                    <label class="control-label"><?= getPhrase('end_date');?></label>
                                    <div class="form-group date-time-picker">
                                        <input type="text" autocomplete="off" class="datepicker-here"
                                            data-position="bottom left" data-language='en' name="end_date" id="end_date"
                                            value="<?=$end_date?>">

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <button class="btn btn-success btn-upper" style="margin-top:20px"
                                        type="submit"><span><?= getPhrase('search');?></span></button>
                                </div>
                            </div>
                        </div>
                        <?= form_close()?>
                        <br />
                        <?php 
                            // echo '<pre>';
                            // var_dump($start_date);
                            // var_dump($end_date);
                            // echo '</pre>';
                        ?>
                        <div class="tab-pane active" id="invoices">
                            <div class="element-wrapper">
                                <div>
                                    <a href="#" id="btnExport"><button class="btn btn-info btn-sm btn-rounded"><i
                                        class="picons-thin-icon-thin-0123_download_cloud_file_sync"
                                        style="font-weight: 300; font-size: 25px;"></i></button>
                                    </a>
                                </div>
                                <div class="element-box-tp">
                                    <div class="table-responsive">
                                        <table class="table table-padded" id="dvData">
                                            <thead>
                                                <tr>
                                                    <th><?= getPhrase('date');?></th>
                                                    <th><?= getPhrase('student');?></th>
                                                    <th><?= getPhrase('origin');?></th>
                                                    <th><?= getPhrase('tuition');?></th>
                                                    <th><?= getPhrase('book');?></th>
                                                    <th><?= getPhrase('fee');?></th>
                                                    <th><?= getPhrase('other');?></th>
                                                    <th><?= getPhrase('total');?></th>
                                                    <th><?= getPhrase('comments');?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach($payments as $row):
                                                        $program = $this->studentModel->get_student_program_name($row['user_id']);

                                                        // Get Discounts
                                                        $this->db->reset_query();
                                                        $this->db->select_sum('amount');
                                                        $this->db->where('payment_id =', $row['payment_id']);
                                                        $discounts = $this->db->get('payment_discounts')->row()->amount; 

                                                        // Get Tuition  id = 1
                                                        $this->db->reset_query();
                                                        $this->db->select_sum('amount');
                                                        $this->db->where('payment_id =', $row['payment_id']);
                                                        $this->db->where('concept_type =', '1');
                                                        $tuition = $this->db->get('payment_details')->row()->amount;

                                                        // Get books  id = 2
                                                        $this->db->reset_query();
                                                        $this->db->select_sum('amount');
                                                        $this->db->where('payment_id =', $row['payment_id']);
                                                        $this->db->where('concept_type =', '2');
                                                        $books = $this->db->get('payment_details')->row()->amount; 

                                                        // Get application/enroll  id = 3
                                                        $this->db->reset_query();
                                                        $this->db->select_sum('amount');
                                                        $this->db->where('payment_id =', $row['payment_id']);
                                                        $this->db->where('concept_type =', '3');
                                                        $application = $this->db->get('payment_details')->row()->amount; 

                                                        // Get others                                      
                                                        $otherTransaction = array(4,5);
                                                        $this->db->reset_query();
                                                        $this->db->select_sum('amount');
                                                        $this->db->where('payment_id', $row['payment_id']);
                                                        $this->db->where_in('concept_type', $otherTransaction);
                                                        $other = $this->db->get('payment_details')->row()->amount; 

                                                        $tuition = $tuition - $discounts;

                                                ?>
                                                <tr>
                                                    <td>
                                                        <?=  date_format(date_create($row['created_at']), "Y-m-d");?>
                                                    </td>
                                                    <td class="cell-with-media">
                                                        <span>
                                                            <?= $this->crud->get_name($row['user_type'], $row['user_id']);?>
                                                        </span>
                                                    </td>
                                                    <td class="cell-with-media">
                                                        <span>
                                                            <?= $program;?>
                                                        </span>
                                                    </td>
                                                    <td class="cell-with-media">
                                                        <span>
                                                            <?= number_format($tuition, 2);?>
                                                        </span>
                                                    </td>
                                                    <td class="cell-with-media">
                                                        <span>
                                                            <?= number_format($books, 2);?>
                                                        </span>
                                                    </td>
                                                    <td class="cell-with-media">
                                                        <span>
                                                            <?= number_format($application, 2);?>
                                                        </span>
                                                    </td>
                                                    <td class="cell-with-media">
                                                        <span>
                                                            <?= number_format($other, 2);?>
                                                        </span>
                                                    </td>
                                                    <td class="cell-with-media">
                                                        <span>
                                                            <?= $row['amount'];?>
                                                        </span>
                                                    </td>
                                                    <td class="cell-with-media">
                                                        <span>
                                                            <?= $row['comments'];?>
                                                        </span>
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
        </div>
    </div>
</div>
<script>
    $("#btnExport").click(function(e) {
		var reportName = '<?php echo getPhrase('reports_tabulation').'_'.date('d-m-Y');?>';
		var a = document.createElement('a');
		var data_type = 'data:application/vnd.ms-excel;charset=utf-8';
		var table_html = $('#dvData')[0].outerHTML;
		table_html = table_html.replace(/<tfoot[\s\S.]*tfoot>/gmi, '');
		var css_html =
			'<style>td {border: 0.5pt solid #c0c0c0} .tRight { text-align:right} .tLeft { text-align:left} </style>';
		a.href = data_type + ',' + encodeURIComponent('<html><head>' + css_html + '</' + 'head><body>' +
			table_html + '</body></html>');
		a.download = reportName + '.xls';
		a.click();
		e.preventDefault();
	});
</script>