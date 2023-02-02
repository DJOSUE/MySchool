<?php 

    $min          =   $this->crud->getInfo('minium_mark');
    $student_info = $this->db->get_where('student' , array('student_id' => $student_id))->result_array();
    $running_year     =   $this->crud->getInfo('running_year');
    $running_semester =   $this->crud->getInfo('running_semester'); 

    $agreements   = $this->agreement->get_student_agreements($student_id);
    $enrollments  = $this->academic->get_student_enrollments($student_id);

    $student_month = $this->academic->get_student_month_by_student($student_id);

    foreach($student_info as $row): 
        $status_info = $this->studentModel->get_status_info($row['student_session']);
        $program_info = $this->studentModel->get_program_info($row['program_id']);
?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="content-i">
        <div class="content-box">
            <div class="conty">
                <div class="back" style="margin-top:-20px;margin-bottom:10px">
                    <a title="<?php echo getPhrase('return');?>" href="<?php echo base_url();?>admin/students/"><i
                            class="picons-thin-icon-thin-0131_arrow_back_undo"></i></a>
                </div>
                <div class="row">
                    <main class="col col-xl-9 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
                        <div id="newsfeed-items-grid">
                            <div class="ui-block paddingtel">
                                <div class="user-profile">
                                    <?php include 'student_area_header.php';?>
                                </div>
                            </div>
                        </div>
                        <div id="documents">
                            <div class="ui-block">
                                <div class="ui-block-title">
                                    <div class="col-sm-2">
                                        <h6 class="title"><?php echo getPhrase('documents');?></h6>
                                    </div>
                                </div>
                                <div class="ui-block-content">
                                    <div class="row">
                                        <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                            <a target="_blank" href="<?= $url_schedule_agreement;?>/">
                                            <div class="ui-block list" data-mh="friend-groups-item">
                                                <div class="friend-item friend-groups">
                                                    <div class="friend-item-content">
                                                        <div class="friend-avatar">
                                                            
                                                            <img src="<?= base_url();?>public/uploads/icons/doc.svg"
                                                                width="80px"
                                                                style="background-color:#fff;padding:15px; border-radius:0px;">
                                                            <h6 style="font-weight:bold;">
                                                            <?php echo getPhrase('acceptance_letter');?>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </a>
                                        </div>
                                        <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                            <a target="_blank" href="<?= $url_schedule_agreement;?>/">
                                            <div class="ui-block list" data-mh="friend-groups-item">
                                                <div class="friend-item friend-groups">
                                                    <div class="friend-item-content">
                                                        <div class="friend-avatar">
                                                            
                                                            <img src="<?= base_url();?>public/uploads/icons/doc.svg"
                                                                width="80px"
                                                                style="background-color:#fff;padding:15px; border-radius:0px;">
                                                            <h6 style="font-weight:bold;">
                                                            <?php echo getPhrase('student_ID');?>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </a>
                                        </div>
                                        <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                            <a target="_blank" href="<?= $url_schedule_agreement;?>/">
                                            <div class="ui-block list" data-mh="friend-groups-item">
                                                <div class="friend-item friend-groups">
                                                    <div class="friend-item-content">
                                                        <div class="friend-avatar">
                                                            
                                                            <img src="<?= base_url();?>public/uploads/icons/doc.svg"
                                                                width="80px"
                                                                style="background-color:#fff;padding:15px; border-radius:0px;">
                                                            <h6 style="font-weight:bold;">
                                                            <?php echo getPhrase('DMV_letter');?>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="agreements">
                            <div class="ui-block">
                                <div class="ui-block-title">
                                    <div class="col-sm-2">
                                        <h6 class="title"><?php echo getPhrase('agreements');?></h6>
                                    </div>
                                </div>
                                <div class="ui-block-content">
                                    <div class="table-responsive">
                                        <table class="table table-padded">
                                            <thead>
                                                <tr>
                                                    <th><?= getPhrase('date');?></th>
                                                    <th><?= getPhrase('modality');?></th>
                                                    <th><?= getPhrase('book');?></th>
                                                    <th><?= getPhrase('program_type');?></th>
                                                    <th><?= getPhrase('payment_date');?></th>
                                                    <th><?= getPhrase('year');?></th>
                                                    <th><?= getPhrase('semester');?></th>
                                                    <th><?= getPhrase('created_by');?></th>
                                                    <th><?= getPhrase('actions');?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($agreements as $key => $value):
                                                    $url_agreement          = '/PrintDocument/print_payment_schedule/'.base64_encode($value['agreement_id']);
                                                    $url_schedule_agreement = '/PrintDocument/print_payment_schedule/'.base64_encode($value['agreement_id']);
                                                ?>
                                                <tr class="text-center">
                                                    <td>
                                                        <?= $value['agreement_date'];?>
                                                    </td>
                                                    <td>
                                                        <?= $this->academic->get_modality_name($value['modality_id']);?>
                                                    </td>
                                                    <td>
                                                        <?= $value['book_type'];?>
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

                                                        <a class="btn btn-rounded btn-sm btn-primary" target="_blank"
                                                            style="color:white" href="<?= $url_schedule_agreement;?>/">
                                                            <i
                                                                class="os-icon picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i>
                                                            <?php echo getPhrase('payment_schedule');?>
                                                        </a>

                                                        <a class="btn btn-rounded btn-sm btn-primary" target="_blank"
                                                            style="color:white" href="<?= $url_agreement;?>/">
                                                            <i class="os-icon picons-thin-icon-thin-0333_printer"></i>
                                                            <?php echo getPhrase('agreement');?>
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
                        <div id="certificate_semester">
                            <div class="ui-block">
                                <div class="ui-block-title">
                                    <div class="col-sm-2">
                                        <h6 class="title"><?php echo getPhrase('semester_certificate');?></h6>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="row" style="justify-content: flex-end;">
                                            <div class="form-buttons">
                                                <a href="/PrintDocument/print_transcript/<?=$student_id?>"
                                                    class="btn btn-rounded btn-primary">
                                                    <i class="os-icon picons-thin-icon-thin-0333_printer"></i>
                                                    <?php echo getPhrase('print_transcript');?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ui-block-content">
                                    <div class="table-responsive">
                                        <table class="table table-padded">
                                            <thead>
                                                <tr>
                                                    <th><?= getPhrase('year');?></th>
                                                    <th><?= getPhrase('semester');?></th>
                                                    <th><?= getPhrase('class');?></th>
                                                    <th><?= getPhrase('section');?></th>
                                                    <th><?= getPhrase('grade');?></th>
                                                    <th><?= getPhrase('grade');?></th>
                                                    <th><?= getPhrase('gpa');?></th>
                                                    <th><?= getPhrase('actions');?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                foreach ($enrollments as $key => $value):
                                                    $url_code        = base64_encode($student_id.'-'.$value['class_id'].'-'.$value['section_id'].'-'.$value['year'].'-'.$value['semester_id']);
                                                    $url_print       = base_url().'admin/student_print_marks_past_cea/'.$url_code;
                                                    $url_certificate = base_url().'PrintDocument/student_certificate/'.$url_code;
                                                ?>
                                                <tr class="text-center">
                                                    <td>
                                                        <?= $value['year'];?>
                                                    </td>
                                                    <td>
                                                        <?= $value['semester_id'];?>
                                                    </td>
                                                    <td>
                                                        <?= $value['class_name'];?>
                                                    </td>
                                                    <td>
                                                        <?= $value['section_name'];?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                        $grades = $this->academic->get_student_grades($student_id, $value['year'], $value['semester_id']);
                                                        echo $grades['mark'];
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?= $this->crud->get_grade($grades['mark']);?>
                                                    </td>
                                                    <td>
                                                        <?= $this->crud->get_gpa($grades['mark']); ?>
                                                    </td>
                                                    <td class="row-actions">
                                                        <div align="left">
                                                            <a class="btn btn-rounded btn-sm btn-primary"
                                                                target="_blank" style="color:white"
                                                                href="<?= $url_print;?>/">
                                                                <i
                                                                    class="os-icon picons-thin-icon-thin-0333_printer"></i>
                                                                <?php echo getPhrase('transcript');?>
                                                            </a>
                                                            <?php 
                                                            $semester_id = intval($value['semester_id']);
                                                            $year = intval($value['year']);
                                                            if(($grades['mark'] >= $min) && (!(($semester_id == $running_semester) && ($year == $running_year)))):
                                                            ?>
                                                            <a class="btn btn-rounded btn-sm btn-success"
                                                                target="_blank" style="color:white"
                                                                href="<?= $url_certificate;?>/">
                                                                <i
                                                                    class="os-icon picons-thin-icon-thin-0666_award_achievement_prize_medal"></i>
                                                                <?= getPhrase('certificate');
                                                                ?>
                                                            </a>
                                                            <?php endif;?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php endforeach;?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="student_month">
                            <div class="ui-block">
                                <div class="ui-block-title">
                                    <div class="col-sm-2">
                                        <h6 class="title"><?php echo getPhrase('student_month');?></h6>
                                    </div>
                                </div>
                                <div class="ui-block-content">
                                    <div class="table-responsive">
                                        <table class="table table-padded">
                                            <thead>
                                                <tr>
                                                    <th><?= getPhrase('class');?></th>
                                                    <th><?= getPhrase('section');?></th>
                                                    <th><?= getPhrase('subject');?></th>
                                                    <th><?= getPhrase('modality');?></th>
                                                    <th><?= getPhrase('teacher');?></th>
                                                    <th><?= getPhrase('month');?></th>
                                                    <th><?= getPhrase('student');?></th>
                                                    <th><?= getPhrase('grade');?></th>
                                                    <th><?= getPhrase('');?></th>
                                                    <th><?= getPhrase('options');?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($student_month as $item):
                                                    $url_certificate = base_url().'PrintDocument/student_month_certificate/'.base64_encode($item['student_month_id']);
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?= $item['class_name'];?>
                                                    </td>
                                                    <td>
                                                        <?= $item['section_name'];?>
                                                    </td>
                                                    <td>
                                                        <?= $item['subject_name'];?>
                                                    </td>
                                                    <td>
                                                        <?php $modality = $this->academic->get_modality_of_subject($item['subject_id'], $item['year'], $item['semester_id']);
                                                        echo $modality['name'];
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?= $item['teacher_name'];?>
                                                    </td>
                                                    <td>
                                                        <?= get_month_name($item['month']);?>
                                                    </td>
                                                    <td>
                                                        <?= $item['student_name'];?>
                                                    </td>
                                                    <td>
                                                        <?php $grades = $this->academic->get_student_grades($item['student_id'], $item['year'], $item['semester_id']);
                                                        echo $grades['mark'];
                                                        ?>
                                                    </td>
                                                    <td class="row-actions">
                                                        <?php 
                                                        if($item['is_best'] == 1) {
                                                            echo '<i class="os-icon picons-thin-icon-thin-0658_cup_place_winner_award_prize_achievement"></i>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="row-actions">
                                                        <a class="btn btn-rounded btn-sm btn-success" target="_blank"
                                                            style="color:white" href="<?= $url_certificate;?>/">
                                                            <i
                                                                class="os-icon picons-thin-icon-thin-0666_award_achievement_prize_medal"></i>
                                                            <?php echo getPhrase('print_certificate');?>
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
                        <div id="payments_history_div" style="display:block;">
                            <div class="ui-block">
                                <div class="ui-block-title">
                                    <div class="col-sm-2">
                                        <h6 class="title"><?= getPhrase('payment_history');?></h6>
                                    </div>
                                </div>
                                <div class="ui-block-content">
                                    <div class="table-responsive">
                                        <table class="table table-padded" id="tblPayments">
                                            <thead>
                                                <tr>
                                                    <th class="orderby"><?= getPhrase('invoice_number');?></th>
                                                    <th class="orderby"><?= getPhrase('amount');?></th>
                                                    <th class="orderby"><?= getPhrase('comment');?></th>
                                                    <th class="orderby"><?= getPhrase('created_by');?></th>
                                                    <th class="orderby"><?= getPhrase('created_at');?></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $this->db->reset_query();                                                
                                                $this->db->order_by('created_at' , 'desc');
                                                $invoices = $this->db->get_where('payment', array('user_type' => 'student','user_id' => $row['student_id']))->result_array();
                                                foreach($invoices as $invoice):
                                                    $url_invoice = base_url() .'admin/payment_invoice/'. base64_encode($invoice['payment_id']);
                                            ?>
                                                <tr>
                                                    <td>
                                                        <?= $invoice['invoice_number'];?>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-primary">
                                                            <?= $this->crud->getInfo('currency');?><?= $invoice['amount'];?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <?= $invoice['comment'];?>
                                                    </td>
                                                    <td>
                                                        <?= $invoice['created_at'];?>
                                                    </td>
                                                    <td>
                                                        <?= $this->crud->get_name($invoice['created_by_type'], $invoice['created_by']);?>
                                                    </td>
                                                    <td class="row-actions">
                                                    <a class="btn btn-rounded btn-sm btn-success" target="_blank"
                                                            style="color:white" href="<?= $url_invoice;?>/">
                                                            <i
                                                                class="os-icon picons-thin-icon-thin-0393_hand_papers_payment"></i>
                                                            <?php echo getPhrase('print_invoice');?>
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
                    </main>
                    <?php include 'student_area_menu.php';?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach;?>

<script type="text/javascript">

</script>