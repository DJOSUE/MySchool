<?php

?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <ul class="navs navs-tabs upper">
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/academic_settings/"><i
                                class="os-icon picons-thin-icon-thin-0006_book_writing_reading_read_manual"></i><span><?php echo getPhrase('academic_settings'); ?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links active" href="<?php echo base_url();?>admin/grade/"><i
                                class="os-icon picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i><span><?php echo getPhrase('grades'); ?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/gpa/"><i
                                class="os-icon picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i><span><?php echo getPhrase('gpa_level'); ?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/semesters/"><i
                                class="os-icon picons-thin-icon-thin-0007_book_reading_read_bookmark"></i><span><?php echo getPhrase('semesters'); ?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/units/"><i
                                class="os-icon picons-thin-icon-thin-0007_book_reading_read_bookmark"></i><span><?php echo getPhrase('units'); ?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/sections/"><i
                                class="os-icon picons-thin-icon-thin-0002_write_pencil_new_edit"></i><span><?php echo getPhrase('sections'); ?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/subjects/"><i
                                class="os-icon picons-thin-icon-thin-0002_write_pencil_new_edit"></i><span><?php echo getPhrase('subject'); ?></span></a>
                    </li>
                    <!-- <li class="navs-item">
                            <a class="navs-links" href="<?php echo base_url();?>admin/student_promotion/"><i
                                    class="os-icon picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i><span><?php echo getPhrase('student_promotion'); ?></span></a>
                        </li> -->
                </ul>
            </div>
        </div>
        <div class="content-i">
            <div class="content-box">
                <div class="expense">
                    <button class="btn btn-success btn-rounded btn-upper" data-target="#new_grade" data-toggle="modal"
                        type="button">
                        +<?php echo getPhrase('new');?>
                    </button>
                </div>
                <br>
                <div class="element-wrapper">
                    <h6 class="element-header"><?php echo getPhrase('grade_levels');?></h6>
                    <div class="element-box-tp">
                        <div class="table-responsive">
                            <table class="table table-padded">
                                <thead>
                                    <tr>
                                        <th><?php echo getPhrase('name');?></th>
                                        <th><?php echo getPhrase('point');?></th>
                                        <th><?php echo getPhrase('mark_from');?></th>
                                        <th><?php echo getPhrase('mark_to');?></th>
                                        <th class="text-center"><?php echo getPhrase('options');?></th>
                                    </tr>
                                </thead>
                                <?php 
                                            $grades = $this->db->get('grade')->result_array();
                                            foreach($grades as $row):
                                        ?>
                                <tr>
                                    <td><?php echo $row['name'];?></td>
                                    <td><?php echo $row['grade_point'];?></td>
                                    <td><?php echo $row['mark_from'];?></td>
                                    <td><?php echo $row['mark_upto'];?></td>
                                    <td class="row-actions">
                                        <a href="javascript:void(0);" class="grey"
                                            onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_edit_grade/<?php echo $row['grade_id'];?>');"><i
                                                class="os-icon picons-thin-icon-thin-0001_compose_write_pencil_new"></i></a>
                                        <a style="color:grey"
                                            onClick="return confirm('<?php echo getPhrase('confirm_delete');?>')"
                                            href="<?php echo base_url();?>admin/grade/delete/<?php echo $row['grade_id'];?>"><i
                                                class="os-icon picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="new_grade" tabindex="-1" role="dialog" aria-labelledby="new_grade"
                    aria-hidden="true">
                    <div class="modal-dialog window-popup create-friend-group create-friend-group-1" role="document">
                        <div class="modal-content">
                            <?php echo form_open(base_url() . 'admin/grade/create/');?>
                            <a href="javascript:void(0);" class="close icon-close" data-dismiss="modal"
                                aria-label="Close"></a>
                            <div class="modal-header">
                                <h6 class="title"><?php echo getPhrase('new');?></h6>
                            </div>
                            <div class="modal-body">
                                <div class="form-group with-button">
                                    <label><?php echo getPhrase('name');?></label>
                                    <input class="form-control" name="name" type="text" required="">
                                </div>
                                <div class="form-group with-button">
                                    <label><?php echo getPhrase('point');?></label>
                                    <input class="form-control" name="point" type="text" required="">
                                </div>
                                <div class="form-group with-button">
                                    <label><?php echo getPhrase('mark_from');?></label>
                                    <input class="form-control" name="from" type="text" required="">
                                </div>
                                <div class="form-group with-button">
                                    <label><?php echo getPhrase('mark_to');?></label>
                                    <input class="form-control" name="to" type="text" required="">
                                </div>
                                <button type="submit"
                                    class="btn btn-rounded btn-success btn-lg full-width"><?php echo getPhrase('save');?></button>
                            </div>
                            <?php echo form_close();?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>