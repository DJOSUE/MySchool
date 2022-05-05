<?php 
    $running_year = $this->crud->getInfo('running_year');
    $running_semester = $this->crud->getInfo('running_semester');

    //Get Classes for a teacher 
    $teacher_id = $this->session->userdata('login_user_id');
    $classes = $this->db->query("SELECT class_id FROM `v_subject` 
                                                where teacher_id = '$teacher_id '
                                                  AND year = '$running_year' 
                                                  AND semester_id = '$running_semester'
                                             GROUP BY class_id
                                ")->result_array();
    $class_ids = "";

    foreach($classes as $row){
        $class_ids .= $row['class_id'].", ";
    }
    $class_ids = rtrim($class_ids, ", ");

    $sections = $this->db->query("SELECT section_id FROM `v_subject` 
                                                where teacher_id = '$teacher_id '
                                                  AND year = '$running_year' 
                                                  AND semester_id = '$running_semester'
                                             GROUP BY section_id
                                ")->result_array();
    $section_ids = "";

    foreach($sections as $row){
        $section_ids .= $row['section_id'].", ";
    }
    $section_ids = rtrim($section_ids, ", ");

?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="all-wrapper no-padding-content solid-bg-all">
            <div class="layout-w">
                <div class="content-w">
                    <div class="content-i">
                        <div class="content-box">
                            <div class="app-email-w">
                                <div class="app-email-i">
                                    <div class="ae-content-w grbg">
                                        <div class="top-header top-header-favorit">
                                            <div class="top-header-thumb">
                                                <img src="<?php echo base_url();?>public/uploads/bglogin.jpg"
                                                    class="bgcover">
                                                <div class="top-header-author">
                                                    <div class="author-thumb">
                                                        <img src="<?php echo base_url();?>public/uploads/<?php echo $this->crud->getInfo('logo');?>"
                                                            style="background-color: #fff; padding:10px">
                                                    </div>
                                                    <div class="author-content">
                                                        <a href="javascript:void(0);"
                                                            class="h3 author-name"><?php echo getPhrase('students');?>
                                                            <small>(<?php if($class_id > 0) echo $this->db->get_where('class', array('class_id' => $class_id))->row()->name;?>)</small></a>
                                                        <div class="country">
                                                            <?php echo $this->crud->getInfo('system_name');?> |
                                                            <?php echo $this->crud->getInfo('system_title');?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="profile-section" style="background-color: #fff;">
                                                <div class="control-block-button"></div>
                                            </div>
                                        </div>
                                        <div class="aec-full-message-w">
                                            <div class="aec-full-message">
                                                <div class="container-fluid grbg"><br>
                                                    <div class="col-sm-12">
                                                        <?php echo form_open(base_url() . 'teacher/students_area/', array('class' => 'form m-b'));?>
                                                        <div class="row">
                                                            <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                                <div class="form-group label-floating"
                                                                    style="background-color: #fff;">
                                                                    <label
                                                                        class="control-label"><?php echo getPhrase('search_students');?></label>
                                                                    <input class="form-control" name="last_name"
                                                                        id="filter" type="text" required="">
                                                                </div>
                                                            </div>
                                                            <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                                                                <div class="form-group label-floating is-select">
                                                                    <label
                                                                        class="control-label"><?php echo getPhrase('filter_by_class');?></label>
                                                                    <div class="select">
                                                                        <select onchange="submit();" name="class_id"
                                                                            id="slct">
                                                                            <option value="">
                                                                                <?php echo getPhrase('select');?>
                                                                            </option>
                                                                            <?php $cl = $this->db->query("SELECT * FROM class WHERE class_id in ($class_ids)")->result_array();
                                                                                        foreach($cl as $row):
                                                                                    ?>
                                                                            <option
                                                                                value="<?php echo $row['class_id'];?>"
                                                                                <?php if($class_id == $row['class_id']) echo 'selected';?>>
                                                                                <?php echo $row['name'];?></option>
                                                                            <?php endforeach;?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php echo form_close();?>
                                                        <div class="ui-block">
                                                            <div class="os-tabs-w">
                                                                <div class="os-tabs-controls">
                                                                    <ul class="navs navs-tabs upper"
                                                                        style="padding-left:20px; padding-top:20px">
                                                                        <li class="navs-item" style="display:inline;">
                                                                            <a class="navs-link active"
                                                                                style="color:#000;" data-toggle="tab"
                                                                                href="#all"><?php echo getPhrase('all');?></a>
                                                                        </li>
                                                                        <?php 
                                                                            $query = $this->db->query("SELECT * FROM section WHERE class_id = '$class_id' AND  year = '$running_year' AND semester_id = '$running_semester' AND section_id in ($section_ids)" );
                                                                            
                                                                            //, array()); 
                                                                            if ($query->num_rows() > 0):
                                                                                $sections = $query->result_array();
                                                                                foreach ($sections as $rows):
                                                                        ?>
                                                                        <li class="navs-item">
                                                                            <a class="navs-link" style="color:#000;"
                                                                                data-toggle="tab"
                                                                                href="#tab<?php echo $rows['section_id'];?>"><?php echo getPhrase('section');?>
                                                                                <?php echo $rows['name'];?></a>
                                                                        </li>
                                                                            <?php endforeach;?>
                                                                        <?php endif;?>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-content">
                                                            <div class="tab-pane active" id="all">
                                                                <div class="row" id="results">
                                                                    <?php 
                                                                        if($students = $this->db->get_where('enroll' , array('class_id' => $class_id , 'year' => $running_year, ))->num_rows() > 0):
                                                                            // $students = $this->db->get_where('enroll' , array('class_id' => $class_id , 'year' => $running_year))->result_array();
                                                                            $students = $this->db->query("SELECT * FROM v_enroll 
																												WHERE class_id = '$class_id'
																												AND year = '$running_year'
																												AND semester_id = '$running_semester'
																												GROUP BY student_id
																												ORDER BY full_name
																												")->result_array();
                                                                            foreach($students as $row):
                                                                    ?>
                                                                    <div class="col-xl-4 col-md-6 results">
                                                                        <div class="card-box widget-user ui-block list">
                                                                            <div class="more" class="pull-right">
                                                                                <i class="icon-options"></i>
                                                                                <ul class="more-dropdown">
                                                                                    <li><a
                                                                                            href="<?php echo base_url();?>teacher/view_marks/<?php echo $row['student_id'];?>"><?php echo getPhrase('marks');?></a>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                            <div>
                                                                                <img src="<?php echo $this->crud->get_image_url('student', $row['student_id']);?>"
                                                                                    class="img-responsive rounded-circle"
                                                                                    alt="user">
                                                                                <div class="wid-u-info">
                                                                                    <a href="<?php echo base_url();?>teacher/view_marks/<?php echo $row['student_id'];?>/"
                                                                                        class="h6 author-name">
                                                                                        <h5 class="mt-0 m-b-5">
                                                                                            <?php echo $this->crud->get_name('student', $row['student_id']);?>
                                                                                        </h5>
                                                                                    </a>
                                                                                    <p class="text-muted m-b-5 font-13">
                                                                                        <b><i
                                                                                                class="picons-thin-icon-thin-0291_phone_mobile_contact"></i></b>
                                                                                        <?php echo $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->phone;?><br>
                                                                                        <b><i
                                                                                                class="picons-thin-icon-thin-0321_email_mail_post_at"></i></b>
                                                                                        <?php echo $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->email;?><br>
                                                                                        <span
                                                                                            class="badge badge-primary"
                                                                                            class="px10"><?php echo $this->db->get_where('class', array('class_id' => $row['class_id']))->row()->name;?>
                                                                                            -
                                                                                            <?php echo $this->db->get_where('section', array('section_id' => $row['section_id']))->row()->name;?></span>
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php endforeach;?>
                                                                    <?php else:?>
                                                                    <div class="col-xl-12 col-md-12 bg-white">
                                                                        <center><img
                                                                                src="<?php echo base_url();?>public/uploads/empty.png">
                                                                        </center>
                                                                    </div>
                                                                    <?php endif;?>
                                                                </div>
                                                            </div>
                                                            <?php $query = $this->db->get_where('section' , array('class_id' => $class_id));
                                                                if ($query->num_rows() > 0):
                                                                $sections = $query->result_array();
                                                                foreach ($sections as $row): ?>
                                                            <div class="tab-pane"
                                                                id="tab<?php echo $row['section_id'];?>">
                                                                <div class="row">
                                                                    <?php 
                                                                        if($students = $this->db->get_where('enroll' , array('class_id'=> $class_id , 'section_id' => $row['section_id'] , 'year' => $running_year ,  'semester_id' => $running_semester))->num_rows() > 0):
                                                                            // $students = $this->db->get_where('enroll' , array('class_id'=> $class_id , 'section_id' => $row['section_id'] , 'year' => $running_year))->result_array();
                                                                            $section_id = $row['section_id'];
																		    $students = $this->db->query("SELECT * FROM v_enroll 
																												WHERE class_id = '$class_id'
																												AND section_id = '$section_id'
																												AND year = '$running_year'
																												AND semester_id = '$running_semester'
																												GROUP BY student_id
																												ORDER BY full_name
																												")->result_array();
                                                                            foreach($students as $row2):
                                                                    ?>
                                                                    <div class="col-xl-4 col-md-6">
                                                                        <div class="card-box widget-user ui-block list">
                                                                            <div class="more" class="pull-right">
                                                                                <i class="icon-options"></i>
                                                                                <ul class="more-dropdown">
                                                                                    <li><a
                                                                                            href="<?php echo base_url();?>teacher/view_marks/<?php echo $row2['student_id'];?>"><?php echo getPhrase('marks');?></a>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                            <div>
                                                                                <img src="<?php echo $this->crud->get_image_url('student',$row2['student_id']);?>"
                                                                                    class="img-responsive rounded-circle"
                                                                                    alt="user">
                                                                                <div class="wid-u-info">
                                                                                    <a href="<?php echo base_url();?>teacher/view_marks/<?php echo $row['student_id'];?>/"
                                                                                        class="h6 author-name">
                                                                                        <h5 class="mt-0 m-b-5">
                                                                                            <?php echo $this->crud->get_name('student', $row2['student_id']);?>
                                                                                        </h5>
                                                                                    </a>
                                                                                    <p class="text-muted m-b-5 font-13">
                                                                                    <p class="text-muted m-b-5 font-13">
                                                                                        <b><i
                                                                                                class="picons-thin-icon-thin-0291_phone_mobile_contact"></i></b>
                                                                                        <?php echo $this->db->get_where('student' , array('student_id' => $row2['student_id']))->row()->phone;?><br>
                                                                                        <b><i
                                                                                                class="picons-thin-icon-thin-0321_email_mail_post_at"></i></b>
                                                                                        <?php echo $this->db->get_where('student' , array('student_id' => $row2['student_id']))->row()->email;?><br>
                                                                                        <span
                                                                                            class="badge badge-primary"
                                                                                            class="px10"><?php echo $this->db->get_where('class', array('class_id' => $row2['class_id']))->row()->name;?>
                                                                                            -
                                                                                            <?php echo $this->db->get_where('section', array('section_id' => $row2['section_id']))->row()->name;?></span>
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php endforeach;?>
                                                                    <?php else:?>
                                                                    <div class="col-xl-12 col-md-12 bg-white">
                                                                        <center><img
                                                                                src="<?php echo base_url();?>public/uploads/empty.png">
                                                                        </center>
                                                                    </div>
                                                                    <?php endif;?>
                                                                </div>
                                                            </div>
                                                            <?php endforeach;?>
                                                            <?php endif;?>
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
            </div>
            <div class="display-type"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
window.onload = function() {
    $("#filter").keyup(function() {
        var filter = $(this).val(),
            count = 0;
        $('#results div').each(function() {
            if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                $(this).hide();
            } else {
                $(this).show();
                count++;
            }
        });
    });
}
</script>