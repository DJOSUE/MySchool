<?php

    $running_year = $this->crud->getInfo('running_year');

    if($country_id != '')
    {
        $this->db->where('country_id', $country_id);
    }
    if($status_id != '')
    {
        $this->db->where('status', $status_id);
    }
    if($name != '')
    {
        $this->db->like('full_name' , str_replace("%20", " ", $name));
    }
    $student_query = $this->db->get('v_applicants');
    $students = $student_query->result_array();



?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <? include 'admission__nav.php';?>
        </div><br>
        <div class="container-fluid">
            <div class="content-i">
                <div class="content-box">
                    <div class="element-box-tp">                        
                        <?php $applicant_type = $this->applicant->get_applicant_types();
                            foreach($applicant_type as $type):
                        ?>
                        <h5 class="form-header"><?= $type['name'];;?></h5>
                        <div class="row">
                            <?php $applicant_status = $this->db->get('v_applicant_status')->result_array();
                                foreach($applicant_status as $status):
                                    $code_search = base64_encode($type['type_id'].'|'.$status['status_id']);
                            ?>
                            <div class="col col-xl-2 col-lg-4 col-md-4 col-sm-8 col-8">
                                <div class="ui-block list" data-mh="friend-groups-item">
                                    <a href="<?php echo base_url().'admin/admission_applicants/'.$code_search;?>">
                                    <div class="friend-item friend-groups">
                                        <div class="friend-item-content">
                                            <div class="friend-avatar">
                                                <?php if($status['icon'] != ''):?>
                                                <br/>
                                                <i class="picons-thin-icon-thin-<?= $status['icon'];?>" style="font-size:45px; color: <?= $status['color'];?>;"></i>
                                                <?php endif;?>
                                                <h1 style="font-weight:bold;"><?= $this->applicant->applicant_total_type($type['type_id'],'status', $status['status_id'])?></h1>
                                                <div class="author-content">
                                                    <div class="country text-font-12"><b> <?= $status['name'];?></b></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                            </div>
                            <?php endforeach;?>
                        </div>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $("#btnExport").click(function(e) {
        var reportName = '<?php echo getPhrase('applicants').'_'.date('d-m-Y');?>';
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