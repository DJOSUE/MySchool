<?php
    $students = $this->db->get('v_students')->result_array();
?>
<?php include $view_path.'_data_table_dependency.php';?>
<div class="content-w">
    <?php include $fancy_path.'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <?php include 'academic__nav.php';?>
            </div>
        </div><br>
        <div class="container-fluid">
            <div class="content-box">
                <div class="element-wrapper">
                    <div class="element-box table-responsive lined-primary shadow" id="print_area<?= $row['section_id'];?>">
                        <div class="row m-b">
                            <div style="padding-left:20px;display:inline-block;">
                                <h5><?= getPhrase('schedule_level');?></h5>
                            </div>
                        </div>                        
                        <div>
                            <table id="dvData" class="table table-bordered table-schedule table-hover" cellpadding="0"
                                cellspacing="0" width="100%">
                                <thead>
                                    <tr class="text-center">
                                        <th>
                                            <?= getPhrase('id');?>
                                        </th>
                                        <th>
                                            <?= getPhrase('sevis_number');?>
                                        </th>
                                        <th>
                                            <?= getPhrase('name');?>
                                        </th>
                                        <th>
                                            <?= getPhrase('country');?>
                                        </th>
                                        <th>
                                            <?= getPhrase('birthday');?>
                                        </th>
                                        <th>
                                            <?= getPhrase('gender');?>
                                        </th>
                                        <th>
                                            <?= getPhrase('address');?>
                                        </th>
                                        <th>
                                            <?= getPhrase('phone');?>
                                        </th>
                                        <th>
                                            <?= getPhrase('email');?>
                                        </th>
                                        <th>
                                            <?= getPhrase('program');?>
                                        </th>
                                        <th>
                                            <?= getPhrase('status');?>
                                        </th>
                                        <th>
                                            Last Agreement
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        foreach($students as $item):                                            
                                            $agreement = $this->studentModel->get_student_last_enrollment($item['student_id']);
                                            
                                    ?>
                                    <tr class="text-center">
                                        <td>
                                            <?= $item['student_id']?>
                                        </td>
                                        <td>
                                            <?= $item['sevis_number']?>
                                        </td>
                                        <td>
                                            <?= $item['full_name']?>
                                        </td>
                                        <td>
                                            <?= $item['country_name']?>
                                        </td>
                                        <td>
                                            <?= $item['birthday']?>
                                        </td>
                                        <td>
                                            <?= $item['gender']?>
                                        </td>
                                        <td>
                                            <?= $item['address'] . '' . $item['city']  . '' . $item['state'] . '' . $item['postal_code']?>
                                        </td>
                                        <td>
                                            <?= $item['phone']?>
                                        </td>
                                        <td>
                                            <?= $item['email']?>
                                        </td>
                                        <td>
                                            <?= $item['program_name']?>
                                        </td>
                                        <td>
                                            <?= $item['student_session_name']?>
                                        </td>
                                        <td>
                                            <?= $agreement['year'] . ' - ' . $agreement['semester']?>
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
<script type="text/javascript">
    var table = $('#dvData').DataTable({
        dom: 'Blifrtp',
        lengthMenu: [
            [10, 20, 50, -1],
            [10, 20, 50, "All"]
        ],
        pageLength: 20,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="picons-thin-icon-thin-0123_download_cloud_file_sync" style="font-size: 20px;"></i>',
            titleAttr: 'Export to Excel'
        }]
    });
    $("select[name='dvData_length']" ).addClass('select-page');
</script>