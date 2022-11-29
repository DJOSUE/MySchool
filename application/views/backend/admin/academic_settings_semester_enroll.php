<?php

?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <?php include 'academic_settings__nav.php'; ?>
        </div>
        <div class="content-i">
            <div class="content-box">
                <div class="expense">
                    <button id="btn_show" class="btn btn-success btn-rounded btn-upper" type="button"
                        onclick="display_content()">
                        + <?= getPhrase('new');?>
                    </button>
                </div>
                <br>
                <div id="data_div" style="display: block;">
                    <div class="element-wrapper">
                        <h6 class="element-header"><?= getPhrase('semester_enroll');?></h6>
                        <div class="element-box-tp">
                            <div class="table-responsive">
                                <table class="table table-padded">
                                    <thead>
                                        <tr>
                                            <th><?= getPhrase('year');?></th>
                                            <th><?= getPhrase('semester');?></th>
                                            <th><?= getPhrase('start_date');?></th>
                                            <th><?= getPhrase('end_date');?></th>
                                            <th class="text-center"><?= getPhrase('options');?></th>
                                        </tr>
                                    </thead>
                                    <?php 
                                                $grades = $this->db->get('semester_enroll')->result_array();
                                                foreach($grades as $row):
                                            ?>
                                    <tr>
                                        <td><?= $row['year'];?></td>
                                        <td><?= $this->academic->get_semester_name($row['semester_id']);?></td>
                                        <td><?= $row['start_date'];?></td>
                                        <td><?= $row['end_date'];?></td>
                                        <td class="row-actions">
                                            <!-- <a href="javascript:void(0);" class="grey"
                                                onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_edit_grade/<?= $row['grade_id'];?>');"><i
                                                    class="os-icon picons-thin-icon-thin-0001_compose_write_pencil_new"></i></a>
                                            <a style="color:grey"
                                                onClick="return confirm('<?= getPhrase('confirm_delete');?>')"
                                                href="<?= base_url();?>admin/grade/delete/<?= $row['grade_id'];?>"><i
                                                    class="os-icon picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></a> -->
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="new_div" class="element-wrapper" style="display: none;">
                    <br />
                    <div class="element-box lined-primary shadow">
                        <h6 class="element-header"><?= getPhrase('new_semester_enroll');?></h6>
                        <?= form_open(base_url() . 'admin/semester_enroll/create/');?>
                        <div class="ui-block-content">
                            <div class="row">
                                <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group label-floating is-select">
                                        <label class="control-label">
                                            <?= getPhrase('year');?>
                                        </label>
                                        <div class="select">
                                            <select name="year" required>
                                                <?php 
                                                            $running_year = $this->crud->getInfo('running_year');
                                                            $years = $this->crud->get_years(1);
                                                            foreach($years as $year):
                                                        ?>
                                                <option value="<?= $year['year'];?>"
                                                    <?php if($running_year == $year['year']) echo 'selected';?>>
                                                    <?= $year['year'];?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group label-floating is-select">
                                        <label class="control-label">
                                            <?= getPhrase('semester');?>
                                        </label>
                                        <div class="select">
                                            <select name="semester_id" required>
                                                <?php 
                                                    $running_semester = $this->crud->getInfo('running_semester');
                                                    $semesters = $this->crud->get_periods(1);
                                                    foreach($semesters as $semester):
                                                ?>
                                                <option value="<?= $semester['semester_id'];?>"
                                                    <?php if($running_semester == $semester['semester_id']) echo 'selected';?>>
                                                    <?= $semester['name'];?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-lg-3 col-md-3 col-sm-12 col-12">
                                    <div class="form-group label-floating is-select">
                                        <label class="control-label"><?= getPhrase('modality');?></label>
                                        <div>
                                            <select name="modality_ids[]" id="modality_ids" multiple
                                                class="selectpicker form-control" title="" required>
                                                <?php 
                                                    $modalities = $this->academic->get_modality();
                                                    foreach($modalities as $item):
                                                ?>
                                                <option value="<?= $item['modality_id']; ?>">
                                                    <?= $item['name']; ?>
                                                </option>
                                                <?php endforeach?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-lg-3 col-md-3 col-sm-12 col-12">
                                    <div class="form-group label-floating is-select">
                                        <label class="control-label"><?= getPhrase('schedule');?></label>
                                        <div>
                                            <select name="schedule[]" id="schedule" multiple 
                                                class="selectpicker form-control" title="" required>
                                                <?php 
                                                    $programs = $this->academic->get_schedule_type();
                                                    foreach($programs as $item):
                                                ?>
                                                <option value="<?= $item['schedule_type_id']; ?>">
                                                    <?= $item['name']; ?>
                                                </option>
                                                <?php endforeach?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-lg-3 col-md-3 col-sm-12 col-12">
                                    <div class="form-group label-floating is-select">
                                        <label class="control-label"><?= getPhrase('classes');?></label>
                                        <div>
                                            <select name="class_ids[]" id="class_ids" multiple
                                                class="selectpicker form-control" title="" required>
                                                <?php 
                                                    $classes = $this->academic->get_classes();
                                                    foreach($classes as $item):
                                                ?>
                                                <option value="<?= $item['class_id']; ?>">
                                                    <?= $item['name']; ?>
                                                </option>
                                                <?php endforeach?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-lg-3 col-md-3 col-sm-12 col-12">
                                    <div class="form-group label-floating is-select" style="background-color: #fff;">
                                        <label class="control-label"><?php echo getPhrase('number_class');?></label>
                                        <div class="form-group date-time-picker">
                                            <input type="number" name="number_class" id="number_class" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group label-floating is-select" style="background-color: #fff;">
                                        <label class="control-label"><?php echo getPhrase('date_start');?></label>
                                        <div class="form-group date-time-picker">
                                            <input type="text" autocomplete="off" class="datepicker-here" required
                                                data-position="bottom left" data-language='en' name="date_start"
                                                id="date_start">

                                        </div>
                                    </div>
                                </div>
                                <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group label-floating is-select" style="background-color: #fff;">
                                        <label class="control-label"><?php echo getPhrase('date_end');?></label>
                                        <div class="form-group date-time-picker">
                                            <input type="text" autocomplete="off" class="datepicker-here" required
                                                data-position="bottom left" data-language='en' name="date_end"
                                                id="date_end">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                            </div>
                            <div class="expense">
                                <button class="btn btn-success btn-rounded btn-upper" type="submit">
                                    <?= getPhrase('save');?>
                                </button>
                            </div>
                        </div>
                        <?= form_close();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
function display_content() {
    var current = document.getElementById("data_div").style.display;

    if (current == 'block') {
        document.getElementById("data_div").style.display = 'none';
        document.getElementById("new_div").style.display = 'block';
        document.getElementById("btn_show").textContent = '<?= getPhrase('show_data');?>';
    } else {
        document.getElementById("data_div").style.display = 'block';
        document.getElementById("new_div").style.display = 'none';
        document.getElementById("btn_show").textContent = '+ <?= getPhrase('new');?>';
    }
}
</script>