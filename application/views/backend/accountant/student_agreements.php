<?php 
    $running_year = $this->crud->getInfo('running_year');
    $running_semester = $this->crud->getInfo('running_semester');

    $student_info = $this->db->get_where('student' , array('student_id' => $student_id))->result_array();

    $this->db->reset_query();        
    $this->db->where('student_id', $student_id);
    $agreements = $this->db->get('agreement')->result_array();

    $disabled = '';
    foreach ($agreements as $value) 
    {
        if($value['year'] == $running_year && $value['semester_id'] == $running_semester)
        {
            $disabled = 'disabled';
            break;
        }
    }
    
    foreach($student_info as $row):
        $student_id = $row['student_id'];
        $return_url = base64_encode('student_profile/'.$student_id);
?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="content-i">
        <div class="content-box">
            <div class="conty">
                <div class="row">
                    <main class="col col-xl-9 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
                        <div id="newsfeed-items-grid">
                            <div class="ui-block paddingtel">
                                <div class="user-profile">
                                    <?php include 'student__header.php';?>
                                    <div>
                                        <div class="ui-block">
                                            <div class="ui-block-title">
                                                <div class="col-sm-2">
                                                    <h6 class="title"><?= getPhrase('agreements');?></h6>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="row" style="justify-content: flex-end;">
                                                        <div class="form-buttons">
                                                            <a id="create_agreement"
                                                                href="/accountant/student_new_agreement/<?=$student_id?>"
                                                                class="btn btn-rounded btn-success <?= $disabled?>">
                                                                <?= getPhrase('create_new_agreement');?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ui-block-content">
                                                <div class="table-responsive">
                                                    <table class="table table-padded">
                                                        <thead>
                                                            <tr class="text-center">
                                                                <th><?= getPhrase('date');?></th>
                                                                <th><?= getPhrase('amount');?></th>
                                                                <th># <?= getPhrase('payments');?></th>
                                                                <th><?= getPhrase('card_info');?></th>
                                                                <th><?= getPhrase('program_type');?></th>
                                                                <th><?= getPhrase('payment_date');?></th>
                                                                <th><?= getPhrase('year');?></th>
                                                                <th><?= getPhrase('semester');?></th>
                                                                <th><?= getPhrase('created_by');?></th>
                                                                <th><?= getPhrase('actions');?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
                                                            foreach ($agreements as $key => $value):
                                                                $amount = ((floatval($value['tuition']) + floatval($value['materials']) + floatval($value['fees'])) - (floatval($value['discounts']) + floatval($value['scholarship'])));
                                                            ?>
                                                            <tr class="text-center">
                                                                <td>
                                                                    <?= $value['agreement_date'];?>
                                                                </td>
                                                                <td>
                                                                    $<?= number_format($amount, 2);?>
                                                                </td>
                                                                <td>
                                                                    <?= $value['number_payments'];?>
                                                                </td>
                                                                <td>
                                                                    <?= intval($value['automatic_payment']) == 0 ? 'No': 'Yes';?>
                                                                </td>
                                                                <td>
                                                                    <?= $this->academic->get_program_type_name($value['program_type_id']);?>
                                                                </td>
                                                                <td>
                                                                    <?= $value['payment_date'];?>
                                                                </td>
                                                                <td>
                                                                    <?= $value['year'];?>
                                                                </td>
                                                                <td>
                                                                    <?= $this->academic->get_semester_name($value['semester_id']);?>
                                                                </td>
                                                                <td>
                                                                    <?= $this->crud->get_name('admin', $value['created_by']);?>
                                                                </td>
                                                                <td class="row-actions">
                                                                    <a href="javascript:void(0);" class="grey"
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        data-original-title="<?= getPhrase('view_payment_schedule');?>"
                                                                        onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_agreement_payment_schedule/<?=$value['agreement_id'];?>');">
                                                                        <i
                                                                            class="os-icon picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i>
                                                                    </a>
                                                                    <a href="/PrintDocument/print_agreement/<?=base64_encode($value['agreement_id']);?>"
                                                                        class="grey" data-toggle="tooltip"
                                                                        data-placement="top"
                                                                        data-original-title="<?= getPhrase('print_agreement');?>">
                                                                        <i
                                                                            class="os-icon picons-thin-icon-thin-0333_printer"></i>
                                                                    </a>
                                                                    <!-- <a class="grey" data-toggle="tooltip"
                                                                        data-placement="top" class="danger"
                                                                        data-original-title="<?= getPhrase('delete');?>"
                                                                        onClick="confirm_delete(<?= $value['agreement_id']; ?>)"
                                                                        href="/accountant/student/delete_agreement/<?=$value['agreement_id'].'/'.$student_id;?>">
                                                                        <i
                                                                            class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i>
                                                                    </a> -->
                                                                </td>
                                                            </tr>
                                                            <?php endforeach;?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- current enrollments -->
                                    <div>
                                        <div class="ui-block">
                                            <div class="ui-block-title">
                                                <h6 class="title"><?= getPhrase('class_enrollments');?></h6>
                                            </div>
                                            <div class="ui-block-content">
                                                <div class="edu-posts cta-with-media">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-lightfont ">
                                                            <thead style="text-align: center;">
                                                                <tr>
                                                                    <th>
                                                                        <?= getPhrase('year');?>
                                                                    </th>
                                                                    <th>
                                                                        <?= getPhrase('semester');?>
                                                                    </th>
                                                                    <th>
                                                                        <?= getPhrase('class');?>
                                                                    </th>
                                                                    <th>
                                                                        <?= getPhrase('section');?>
                                                                    </th>
                                                                    <th>
                                                                        <?= getPhrase('subject');?>
                                                                    </th>
                                                                    <th>
                                                                        <?= getPhrase('teacher');?>
                                                                    </th>
                                                                    <!-- <th>
                                                            <?= getPhrase('options');?>
                                                        </th> -->
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php 
                                                        $enrollments = $this->db->get_where('v_enrollment', array('student_id' => $student_id))->result_array();
                                                        
                                                        // echo '<pre>';
                                                        // var_dump($enrollments);
                                                        // echo '</pre>';

                                                        foreach ($enrollments as $item):
                                                    ?>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <center>
                                                                            <label name="year_<?= $item['enroll_id'];?>"
                                                                                placeholder="0"
                                                                                style="width:55px; border: 1; text-align: center;">
                                                                                <?= $item['year'];?>
                                                                            </label>
                                                                        </center>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <center>
                                                                            <label
                                                                                name="semester_<?= $item['semester_id'];?>"
                                                                                placeholder="0"
                                                                                style="width:55px; border: 1; text-align: center;">
                                                                                <?= $item['semester_name']?>
                                                                            </label>
                                                                        </center>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <center>
                                                                            <label
                                                                                name="class_<?= $item['enroll_id'];?>"
                                                                                placeholder="0"
                                                                                style="width:55px; border: 1; text-align: center;">
                                                                                <?= $item['class_name']?>
                                                                            </label>
                                                                        </center>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <center>
                                                                            <label
                                                                                name="section_<?= $item['enroll_id'];?>"
                                                                                placeholder="0"
                                                                                style="width:55px; border: 1; text-align: center;">
                                                                                <?= $item['section_name'];?>
                                                                            </label>
                                                                        </center>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <center>
                                                                            <label
                                                                                name="subject_<?= $item['enroll_id'];?>"
                                                                                placeholder="0"
                                                                                style="width:55px; border: 1; text-align: center;">
                                                                                <?= $item['subject_name'];?>
                                                                            </label>
                                                                        </center>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <center>
                                                                            <label
                                                                                name="teacher_<?= $item['enroll_id'];?>"
                                                                                placeholder="0"
                                                                                style="border: 1; text-align: center;">
                                                                                <?= $item['teacher_name'];?>
                                                                            </label>
                                                                        </center>
                                                                    </td>
                                                                    <!-- <td class="text-center bolder">
                                                                            <a class="grey" 
                                                                            data-toggle="tooltip" 
                                                                            data-placement="top" 
                                                                            data-original-title="<?= getPhrase('delete');?>" 
                                                                            class="danger" 
                                                                            onClick="confirm_delete(<?= $item['enroll_id']; ?>)" >
                                                                            <i class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i>
                                                                            </a>
                                                                        </td> -->
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
                    </main>
                    <?php include 'student__nav.php';?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach;?>