<?php $running_year = $this->crud->getInfo('running_year');?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <ul class="navs navs-tabs upper">
                    <li class="navs-item">
                        <a class="navs-links active" href="<?php echo base_url();?>admin/admission_dashboard/">
                            <i
                                class="os-icon picons-thin-icon-thin-0482_gauge_dashboard_empty"></i><span><?php echo getPhrase('home');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/admission_new_applicant/">
                            <i
                                class="os-icon picons-thin-icon-thin-0716_user_profile_add_new"></i><span><?php echo getPhrase('new_applicant');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>admin/admission_new_student/">
                            <i
                                class="os-icon picons-thin-icon-thin-0706_user_profile_add_new"></i><span><?php echo getPhrase('new_student');?></span></a>
                    </li>
                </ul>
            </div>
        </div><br>
        <div class="container-fluid">
            <div class="content-i">
                <div class="content-box">
                    <h5 class="form-header"><?php echo getPhrase('class_report');?></h5>
                    <div class="row">
                        <div class="content-i">
                            <div class="content-box">
                                <?php echo form_open(base_url() . 'admin/reports_general/', array('class' => 'form m-b'));?>
                                <div class="row" style="margin-top: -30px; border-radius: 5px;">
                                    <div class="col-sm-3">
                                        <div class="form-group label-floating is-select">
                                            <label class="control-label"><?php echo getPhrase('country');?></label>
                                            <div class="select">
                                                <select name="country_id"
                                                    onchange="get_class_sections(this.value)">
                                                    <option value=""><?php echo getPhrase('select');?></option>
                                                    <?php
													$countries = $this->db->get('countries')->result_array();
													foreach($countries as $row):                        
										        ?>
                                                    <option value="<?php echo $row['country_id'];?>"
                                                        <?php if($country_id == $row['country_id']) echo "selected";?>>
                                                        <?php echo $row['name'];?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group label-floating is-select">
                                            <label class="control-label"><?php echo getPhrase('status');?></label>
                                            <div class="select">
                                                <select name="status_id"
                                                    onchange="get_class_sections(this.value)">
                                                    <option value=""><?php echo getPhrase('select');?></option>
                                                    <?php
													$countries = $this->db->get('v_applicant_status')->result_array();
													foreach($countries as $row):                        
										        ?>
                                                    <option value="<?php echo $row['status_id'];?>"
                                                        <?php if($status_id == $row['status_id']) echo "selected";?>>
                                                        <?php echo $row['name'];?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 bd-white">
                                            <div class="form-group label-floating">
                                                <label
                                                    class="control-label"><?php echo getPhrase('name');?></label>
                                                <input class="form-control" name="name" type="text">
                                            </div>
                                        </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <button class="btn btn-success btn-upper" style="margin-top:20px"
                                                type="submit"><span><?php echo getPhrase('get_report');?></span></button>
                                        </div>
                                    </div>
                                </div>
                                <?php echo form_close();?>
                                <?php if($class_id != "" && $section_id != ""):?>
                                <div class="row">
                                    <div class="text-center col-sm-6"><br>
                                        <h4><?php echo $this->db->get_where('class', array('class_id' => $class_id))->row()->name;?>
                                            - <?php echo getPhrase('section');?>:
                                            <?php echo $this->db->get_where('section', array('section_id' => $section_id))->row()->name;?>
                                        </h4>
                                        <p>
                                            <b>
                                                <?php 
											$this->db->where('class_id', $class_id); 
											$this->db->where('section_id', $section_id); 
											$this->db->group_by('student_id');
											echo $this->db->count_all_results('enroll');
										?>
                                            </b>
                                            <?php echo getPhrase('students');?> |
                                            <b>
                                                <?php 
											$this->db->where('class_id', $class_id);
											$this->db->where('section_id', $section_id); 
											echo $this->db->count_all_results('subject');?>
                                            </b>
                                            <?php echo getPhrase('subjects');?>.
                                            <br>
                                            <b><?php echo getPhrase('running_year');?>:</b>
                                            <?php echo $running_year;?>
                                            <br>
                                            <b><?php echo getPhrase('running_semester');?>:</b>
                                            <?php echo $this->db->get_where('semesters', array('semester_id' => $running_semester))->row()->name;;?>
                                        </p>
                                    </div>
                                    <div class="col-sm-6 text-center">
                                        <div class="up-main-info">
                                            <!-- <div class="user-avatar-w">
                                            <div class="user-avatar">
                                                <img alt=""
                                                    src="<?php //echo $this->crud->get_image_url('teacher', $this->db->get_where('class', array('class_id' => $class_id))->row()->teacher_id);?>"
                                                    width="80">
                                            </div>
                                        </div>
                                        <h4 class="up-header">
                                            <?php //echo $this->crud->get_name('teacher', $this->db->get_where('class', array('class_id' => $class_id))->row()->teacher_id);?>
                                        </h4>
                                        <h6 class="up-sub-header">
                                            <div class="value badge badge-pill badge-success">
                                                <?php //echo getPhrase('teacher');?></div>
                                        </h6> -->
                                        </div>
                                    </div>
                                    <hr>
                                    <!-- <div class="col-sm-6">
                                    <div class="element-box">
                                        <h5 class="form-header"><?php echo getPhrase('gender');?></h5>
                                        <canvas id="myChart" width="100" height="100"></canvas>
                                    </div>
                                </div> -->
                                    <div class="col-sm-6">
                                        <div class="element-box">
                                            <div class="form-header">
                                                <h6><?php echo getPhrase('subjects');?></h6>
                                            </div>
                                            <div class="table-responsive">
                                                <table width="100%" class="table table-lightborder table-lightfont">
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align: left;">
                                                                <?php echo getPhrase('subject');?>
                                                            </th>
                                                            <th style="text-align: center;">
                                                                <?php echo getPhrase('teacher');?>
                                                            </th>
                                                            <th style="text-align: center;">
                                                                <?php echo getPhrase('total');?>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
   												        $subjects = $this->db->get_where('subject',array('class_id' => $class_id, 'section_id' => $section_id))->result_array();
   												        foreach ($subjects as $subject): ?>
                                                        <tr>
                                                            <td style="text-align: left;"><?php echo $subject['name'];?>
                                                            </td>
                                                            <td style="text-align: center;"><a
                                                                    class="btn btn-rounded btn-sm btn-purple"
                                                                    style="color:white"><?php echo $this->crud->get_name('teacher', $subject['teacher_id']);?></a>
                                                            </td>
                                                            <td style="text-align: center;">
                                                                <?= $this->academic->countStudentsSubject($class_id, $section_id, $subject['subject_id']);?>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach;?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>