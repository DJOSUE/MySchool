<?php 
    $date_format = $this->crud->getInfo('date_format');

    $this->db->reset_query();        
    $this->db->where('student_id', $student_id);
    $agreements = $this->db->get('agreement')->result_array();
    
?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="content-i">
            <div class="content-box">
                <div class="element-wrapper">
                    <h6 class="element-header"><?= getPhrase('my_agreements');?></h6>

                    <div class="element-box-tp">
                        <div class="table-responsive">
                            <table class="table table-padded">
                                <thead>
                                    <tr>
                                        <th><?= getPhrase('id');?></th>
                                        <th><?= getPhrase('date');?></th>
                                        <th class="text-center"><?= getPhrase('tuition');?></th>
                                        <th class="text-center"><?= getPhrase('scholarship');?></th>
                                        <th class="text-center"><?= getPhrase('discounts');?></th>
                                        <th class="text-center"><?= getPhrase('materials');?></th>
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
                                    <?php 
                                        foreach ($agreements as $key => $value):                                            
                                        ?>
                                    <tr class="text-center">
                                        <td>
                                            <?= $value['agreement_id'];?>
                                        </td>
                                        <td>
                                            <?= $value['agreement_date'];?>
                                        </td>
                                        <td>
                                            <?= number_format($value['tuition'], 2);?>
                                        </td>
                                        <td>
                                            <?= number_format($value['scholarship'], 2);?>
                                        </td>
                                        <td>
                                            <?= number_format($value['discounts'], 2);?>
                                        </td>
                                        <td>
                                            <?= number_format($value['materials'], 2);?>
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
                                            <a href="javascript:void(0);" class="grey" data-toggle="tooltip"
                                                data-placement="top"
                                                data-original-title="<?= getPhrase('view_payment_schedule');?>"
                                                onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_agreement_payment_schedule/<?=$value['agreement_id'];?>');">
                                                <i
                                                    class="os-icon picons-thin-icon-thin-0023_calendar_month_day_planner_events"></i>
                                            </a>
                                            <a href="/PrintDocument/print_agreement/<?=base64_encode($value['agreement_id']);?>"
                                                class="grey" data-toggle="tooltip" data-placement="top"
                                                data-original-title="<?= getPhrase('print_agreement');?>">
                                                <i class="os-icon picons-thin-icon-thin-0333_printer"></i>
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
        </div>
    </div>
</div>