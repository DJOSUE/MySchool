<?php 

    $cover_photo = $this->crud->getInfo('cover_photo'); 

    $running_year = $this->crud->getInfo('running_year');
    $running_semester = $this->crud->getInfo('running_semester');

    $student_info = $this->db->get_where('student' , array('student_id' => $student_id))->result_array(); 

    $student_enroll = $this->db->get_where('v_enroll', array('student_id' => $student_id, 'year' => $running_year, 'semester_id' => $running_semester ))->result_array(); 

    $class_id = $student_enroll[0]['class_id'];
    $section_id = $student_enroll[0]['section_id'];

    $subject_ids = array();
    foreach ($student_enroll as $item) {
        $subject_ids[] = $item["subject_id"];
    }
    
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
                                <div>
                                    <?php echo form_open(base_url() . 'admin/student_update_class_process/'.$row['student_id'] , array('enctype' => 'multipart/form-data'));?>
                                    <!-- current_class -->
                                    <div>
                                        <div class="ui-block">
                                            <div class="ui-block-title bg-info">
                                                <h6 class="title"><?php echo getPhrase('current_class');?></h6>
                                            </div>
                                            <div class="ui-block-content">
                                                <div class="row">
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating is-select">
                                                            <label
                                                                class="control-label"><?php echo getPhrase('class');?></label>
                                                            <div class="select">
                                                                <select name="current_class_id">
                                                                    <?php 
                                                                        $classes = $this->db->get_where('class', array('class_id' => $class_id))->result_array();

                                                                        foreach($classes as $class):
                                                                    ?>
                                                                    <option value="<?php echo $class['class_id'];?>"
                                                                        <?php if($class['class_id'] == $class_id) echo "selected";?>>
                                                                        <?php echo $class['name'];?></option>
                                                                    <?php endforeach;?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating is-select">
                                                            <label
                                                                class="control-label"><?php echo getPhrase('section');?></label>
                                                            <div class="select">
                                                                <select name="current_section_id">
                                                                    <?php 
                                                                        $sections = $this->db->get_where('section', array('class_id' => $class_id, 'section_id' => $section_id))->result_array();
                                                                        foreach($sections as $section):
                                                                    ?>
                                                                    <option value="<?php echo $section['section_id'];?>"
                                                                        <?php if($section['section_id'] == $section_id) echo "selected";?>>
                                                                        <?php echo $section['name'];?></option>
                                                                    <?php endforeach;?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                        foreach ($student_enroll as $item): 
                                                            $count++;
                                                    ?>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating is-select">
                                                            <label
                                                                class="control-label"><?php echo getPhrase('subject').'_'.$count ;?></label>
                                                            <div class="select">
                                                                <select
                                                                    name="current_subject_id_<?= $item['subject_id']; ?>">
                                                                    <option value="<?php echo $item['subject_id'];?>">
                                                                        <?php echo $item['subject_name'];?>
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- future_class -->
                                    <div>
                                        <div class="ui-block">
                                            <div class="ui-block-title bg-warning">
                                                <h6 class="title"><?php echo getPhrase('future_class');?></h6>
                                            </div>
                                            <div class="ui-block-content">
                                                <div class="row">
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating is-select">
                                                            <label class="control-label">
                                                                <?php echo getPhrase('modality');?>
                                                            </label>
                                                            <div class="select">
                                                                <select name="modality_id" id="modality_id" required=""
                                                                    onchange="rest_selection()">
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
                                                </div>
                                            </div>
                                            <div class="ui-block-content">
                                                <div class="row">
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating is-select">
                                                            <label
                                                                class="control-label"><?php echo getPhrase('class');?></label>
                                                            <div class="select">
                                                                <select name="future_class_id" id="future_class_id"
                                                                    onchange="get_class_sections(this.value);">
                                                                    <option value=""><?php echo getPhrase('select');?>
                                                                    </option>
                                                                    <?php $classes = $this->db->get('class')->result_array();
                                                                        foreach($classes as $class):
                                                                    ?>
                                                                    <option value="<?php echo $class['class_id'];?>">
                                                                        <?php echo $class['name'];?></option>
                                                                    <?php endforeach;?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group label-floating is-select">
                                                            <label
                                                                class="control-label"><?php echo getPhrase('section');?></label>
                                                            <div class="select">
                                                                <select name="future_section_id"
                                                                    id="section_selector_holder"
                                                                    onchange="get_class_section_subjects(this.value);">
                                                                    <option value=""><?php echo getPhrase('select');?>
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" id="subject_selector_holder">

                                                </div>
                                                <div class="row">
                                                    <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="form-buttons-w">
                                                            <button class="btn btn-rounded btn-success" type="submit">
                                                                <?php echo getPhrase('update');?></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php echo form_close();?>
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
    function rest_selection() {

        document.getElementById("future_class_id").selectedIndex = 0;
        document.getElementById("section_selector_holder").selectedIndex = 0;
    }

    function get_class_sections(class_id) {
        $.ajax({
            url: '<?php echo base_url();?>admin/get_class_section/' + class_id,
            success: function(response) {
                jQuery('#section_selector_holder').html(response);
            }
        });
    }

    function get_class_section_subjects(section_id) {
        var modality_id = document.getElementById("modality_id").value;
        var class_id = document.getElementById("future_class_id").value;
        var student_id = <?= $student_id;?>;

        $.ajax({
            url: '<?php echo base_url();?>admin/get_class_section_subjects_for_update/' + student_id + '/' +
                class_id + '/' + section_id + '/' + modality_id,
            success: function(response) {
                jQuery('#subject_selector_holder').html(response);
            }
        });
    }
</script>