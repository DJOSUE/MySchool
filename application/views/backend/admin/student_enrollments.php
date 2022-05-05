<?php 
    $running_year = $this->crud->getInfo('running_year');
    $running_semester = $this->crud->getInfo('running_semester');

    $student_info = $this->db->get_where('student' , array('student_id' => $student_id))->result_array(); 

    $student_enroll = $this->db->get_where('enroll', array('student_id' => $student_id, 'year' => $running_year, 'semester_id' => $running_semester ))->result_array(); 

    $class_id = $student_enroll[0]['class_id'];
    $section_id = $student_enroll[0]['section_id'];

    foreach($student_info as $row): 
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
                                    <div class="up-head-w"
                                        style="background-image:url(<?php echo base_url();?>public/uploads/bglogin.jpg)">
                                        <div class="up-main-info">
                                            <div class="user-avatar-w">
                                                <div class="user-avatar">
                                                    <img alt=""
                                                        src="<?php echo $this->crud->get_image_url('student', $row['student_id']);?>"
                                                        style="background-color:#fff;">
                                                </div>
                                            </div>
                                            <h3 class="text-white"><?php echo $row['first_name'];?>
                                                <?php echo $row['last_name'];?></h3>
                                            <h5 class="up-sub-header">@<?php echo $row['username'];?></h5>
                                        </div>
                                        <svg class="decor" width="842px" height="219px" viewBox="0 0 842 219"
                                            preserveAspectRatio="xMaxYMax meet" version="1.1"
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <g transform="translate(-381.000000, -362.000000)" fill="#FFFFFF">
                                                <path class="decor-path"
                                                    d="M1223,362 L1223,581 L381,581 C868.912802,575.666667 1149.57947,502.666667 1223,362 Z">
                                                </path>
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="up-controls">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="value-pair">
                                                    <div><?php echo getPhrase('account_type');?>:</div>
                                                    <div class="value badge badge-pill badge-primary">
                                                        <?php echo getPhrase('student');?></div>
                                                </div>
                                                <div class="value-pair">
                                                    <div><?php echo getPhrase('member_since');?>:</div>
                                                    <div class="value"><?php echo $row['since'];?>.</div>
                                                </div>
                                                <div class="value-pair">
                                                    <div><?php echo getPhrase('roll');?>:</div>
                                                    <div class="value">
                                                        <?php echo $this->db->get_where('enroll', array('student_id' => $row['student_id']))->row()->roll;?>.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                            </div>
                        </div>
                        <!-- add enrollments -->
                        <div>
                            <div class="ui-block">
                                <div class="ui-block-title">
                                    <div class="col-sm-2">
                                        <h6 class="title"><?php echo getPhrase('enrollment');?></h6>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="row" style="justify-content: flex-end;">
                                            <div class="form-buttons">
                                                <button class="btn btn-rounded btn-primary">
                                                    <?php echo getPhrase('print_agreement');?></button>
                                            </div> &nbsp;&nbsp;&nbsp;&nbsp;
                                            <div class="form-buttons">
                                                <button class="btn btn-rounded btn-success"
                                                    onclick="create_agreement()">
                                                    <?php echo getPhrase('create_agreement');?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php echo form_open(base_url() . 'admin/save_student_enrollment/'.$row['student_id'] , array('enctype' => 'multipart/form-data'));?>
                                <div id="create_agreement_div" class="ui-block-content" style="display:none;">
                                    <br />
                                    <input id="student_id" name="student_id" style="display: none;"
                                        value="<?= $student_id; ?>" />
                                    <div class="row">
                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?php echo getPhrase('year');?></label>
                                                <div class="select">
                                                    <select name="year_id" id="year_id" required="">
                                                        <option value=""><?php echo getPhrase('select');?></option>
                                                        <?php 
                                                        $years = $this->db->get_where('years', array('status' => '1'))->result_array();
                                                        foreach($years as $item):
                                                    ?>
                                                        <option value="<?= $item['year']; ?>"
                                                            <?php if($running_year == $item['year']) echo 'selected';?>>
                                                            <?= $item['year']; ?></option>
                                                        <?php endforeach?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?php echo getPhrase('semester');?></label>
                                                <div class="select">
                                                    <select name="semester_id" id="semester_id" required="">
                                                        <option value=""><?php echo getPhrase('select');?></option>
                                                        <?php 
                                                            $semesters = $this->db->get('semesters')->result_array();
                                                            foreach($semesters as $semester):
                                                        ?>
                                                        <option value="<?php echo $semester['semester_id'];?>"
                                                            <?php if($running_semester == $semester['semester_id']) echo 'selected';?>>
                                                            <?php echo $semester['name']?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?php echo getPhrase('class');?></label>
                                                <div class="select">
                                                    <select name="class_id" id="class_id"
                                                        onchange="get_class_sections(this.value);">
                                                        <option value=""><?php echo getPhrase('select');?></option>
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
                                                <label class="control-label"><?php echo getPhrase('section');?></label>
                                                <div class="select">
                                                    <select name="section_id" id="section_selector_holder"
                                                        onchange="get_class_section_subjects(this.value);">
                                                        <option value=""><?php echo getPhrase('select');?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?php echo getPhrase('subject');?></label>
                                                <div>
                                                    <select name="subject_id[]" id="subject_selector_holder" multiple
                                                        class="selectpicker form-control" title="">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-buttons-w">
                                                <button class="btn btn-rounded btn-success" type="submit">
                                                    <?php echo getPhrase('save');?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php echo form_close();?>
                            </div>
                        </div>
                        <!-- current enrollments -->
                        <div>
                            <div class="ui-block">
                                <div class="ui-block-title">
                                    <h6 class="title"><?php echo getPhrase('old_enrollments');?></h6>
                                </div>
                                <div class="ui-block-content">
                                    <div class="edu-posts cta-with-media">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead style="text-align: center;">
                                                    <tr style="background:#f2f4f8;">
                                                        <th>
                                                            <?php echo getPhrase('year');?>
                                                        </th>
                                                        <th>
                                                            <?php echo getPhrase('semester');?>
                                                        </th>
                                                        <th>
                                                            <?php echo getPhrase('class');?>
                                                        </th>
                                                        <th>
                                                            <?php echo getPhrase('section');?>
                                                        </th>
                                                        <th>
                                                            <?php echo getPhrase('subject');?>
                                                        </th>
                                                        <th>
                                                            <?php echo getPhrase('teacher');?>
                                                        </th>
                                                        <th>
                                                            <?php echo getPhrase('options');?>
                                                        </th>
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
                                                                <label name="year_<?php echo $item['enroll_id'];?>"
                                                                    placeholder="0"
                                                                    style="width:55px; border: 1; text-align: center;">
                                                                    <?= $item['year'];?>
                                                                </label>
                                                            </center>
                                                        </td>
                                                        <td class="text-center">
                                                            <center>
                                                                <label name="semester_<?php echo $item['semester_id'];?>"
                                                                    placeholder="0"
                                                                    style="width:55px; border: 1; text-align: center;">
                                                                    <?= $item['semester_name']?>
                                                                </label>
                                                            </center>
                                                        </td>
                                                        <td class="text-center">
                                                            <center>
                                                                <label name="class_<?php echo $item['enroll_id'];?>"
                                                                    placeholder="0"
                                                                    style="width:55px; border: 1; text-align: center;">
                                                                    <?= $item['class_name']?>
                                                                </label>
                                                            </center>
                                                        </td>
                                                        <td class="text-center">
                                                            <center>
                                                                <label name="section_<?php echo $item['enroll_id'];?>"
                                                                    placeholder="0"
                                                                    style="width:55px; border: 1; text-align: center;">
                                                                    <?= $item['section_name'];?>
                                                                </label>
                                                            </center>
                                                        </td>
                                                        <td class="text-center">
                                                            <center>
                                                                <label name="subject_<?php echo $item['enroll_id'];?>"
                                                                    placeholder="0"
                                                                    style="width:55px; border: 1; text-align: center;">
                                                                    <?= $item['subject_name'];?>
                                                                </label>
                                                            </center>
                                                        </td>
                                                        <td class="text-center">
                                                            <center>
                                                                <label name="teacher_<?php echo $item['enroll_id'];?>"
                                                                    placeholder="0"
                                                                    style="width:55px; border: 1; text-align: center;">
                                                                    <?= $item['teacher_name'];?>
                                                                </label>
                                                            </center>
                                                        </td>
                                                        <td class="text-center bolder">
                                                            <a class="grey" 
                                                            data-toggle="tooltip" 
                                                            data-placement="top" 
                                                            data-original-title="<?php echo getPhrase('delete');?>" 
                                                            class="danger" 
                                                            onClick="confirm_delete(<?= $item['enroll_id']; ?>)" >
                                                            <i class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i>
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
                    </main>
                    <div class="col col-xl-3 order-xl-1 col-lg-12 order-lg-2 col-md-12 col-sm-12 col-12">
                        <div class="eduappgt-sticky-sidebar">
                            <div class="sidebar__inner">
                                <div class="ui-block paddingtel">
                                    <div class="ui-block-content">
                                        <div class="widget w-about">
                                            <a href="javascript:void(0);" class="logo"><img
                                                    src="<?php echo base_url();?>public/uploads/<?php echo $this->crud->getInfo('logo');?>"></a>
                                            <ul class="socials">
                                                <li><a class="socialDash fb"
                                                        href="<?php echo $this->crud->getInfo('facebook');?>"><i
                                                            class="fab fa-facebook-square" aria-hidden="true"></i></a>
                                                </li>
                                                <li><a class="socialDash tw"
                                                        href="<?php echo $this->crud->getInfo('twitter');?>"><i
                                                            class="fab fa-twitter" aria-hidden="true"></i></a></li>
                                                <li><a class="socialDash yt"
                                                        href="<?php echo $this->crud->getInfo('youtube');?>"><i
                                                            class="fab fa-youtube" aria-hidden="true"></i></a></li>
                                                <li><a class="socialDash ig"
                                                        href="<?php echo $this->crud->getInfo('instagram');?>"><i
                                                            class="fab fa-instagram" aria-hidden="true"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="ui-block paddingtel">
                                    <div class="ui-block-content">
                                        <div class="help-support-block">
                                            <h3 class="title"><?php echo getPhrase('quick_links');?></h3>
                                            <ul class="help-support-list">
                                                <li>
                                                    <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                        style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                    <a
                                                        href="<?php echo base_url();?>admin/student_portal/<?php echo $student_id;?>/">
                                                        <?php echo getPhrase('personal_information');?>
                                                    </a>
                                                </li>
                                                <li>
                                                    <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                        style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                    <a
                                                        href="<?php echo base_url();?>admin/student_update/<?php echo $student_id;?>/">
                                                        <?php echo getPhrase('update_information');?>
                                                    </a>
                                                </li>
                                                <li>
                                                    <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                        style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                    <a
                                                        href="<?php echo base_url();?>admin/student_update_class/<?php echo $student_id;?>/">
                                                        <?php echo getPhrase('update_class');?>
                                                    </a>
                                                </li>
                                                <li>
                                                    <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                        style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                    <a
                                                        href="<?php echo base_url();?>admin/student_enrollments/<?php echo $student_id;?>/">
                                                        <?php echo getPhrase('student_enrollments');?>
                                                    </a>
                                                </li>
                                                <li>
                                                    <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                        style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                    <a
                                                        href="<?php echo base_url();?>admin/student_invoices/<?php echo $student_id;?>/">
                                                        <?php echo getPhrase('payments_history');?>
                                                    </a>
                                                </li>
                                                <li>
                                                    <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                        style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                    <a
                                                        href="<?php echo base_url();?>admin/student_marks/<?php echo $student_id;?>/">
                                                        <?php echo getPhrase('marks');?>
                                                    </a>
                                                </li>
                                                <li>
                                                    <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                        style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                    <a
                                                        href="<?php echo base_url();?>admin/student_past_marks/<?php echo $student_id;?>/">
                                                        <?php echo getPhrase('old_marks');?>
                                                    </a>
                                                </li>
                                                <li>
                                                    <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                        style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                    <a
                                                        href="<?php echo base_url();?>admin/student_profile_attendance/<?php echo $student_id;?>/">
                                                        <?php echo getPhrase('attendance');?>
                                                    </a>
                                                </li>
                                                <li>
                                                    <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                        style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                    <a
                                                        href="<?php echo base_url();?>admin/student_profile_report/<?php echo $student_id;?>/">
                                                        <?php echo getPhrase('behavior');?>
                                                    </a>
                                                </li>
                                            </ul>
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
</div>
<?php endforeach;?>
<script type="text/javascript">

    function create_agreement() {
        document.getElementById("create_agreement_div").style.display = 'block';
    }

    function get_class_sections(class_id) {
        var year = document.getElementById("year_id").value;
        var semester_id = document.getElementById("semester_id").value;
            
        $.ajax({
            url: '<?php echo base_url();?>admin/get_class_section/' + class_id + '/' + year + '/' + semester_id,
            success: function(response) {
                jQuery('#section_selector_holder').html(response);
            }
        });
    }

    function get_class_section_subjects(section_id){
        var year = document.getElementById("year_id").value;
        var semester = document.getElementById("semester_id").value;
        var class_id = document.getElementById("class_id").value;
            
        $.ajax({
            url: '<?php echo base_url();?>admin/get_class_section_subjects/' + class_id + '/' + section_id + '/' + year + '/' + semester ,
            success: function(response) {
                jQuery('#subject_selector_holder').html(response).selectpicker('refresh');
            }
        });
    }

    function save(){
        var subjects = $("#subject_selector_holder").val();
        var _subjects = btoa(subjects);
        console.log(_subjects);
        window.location.href = '<?php echo base_url();?>admin/save_student_enrollment/' + _subjects;
    }

    function confirm_delete(enroll_id){

        var student_id = document.getElementById("student_id").value;

        Swal.fire({
            title: "<?= getPhrase('confirm_delete');?>",
            text: "<?= getPhrase('message_delete');?>",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "<?= getPhrase('delete');?>"
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = '<?php echo base_url();?>admin/delete_student_enrollment/' + enroll_id + '/' + student_id;
            }
        })
    }    

</script>