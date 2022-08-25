    <?php 
    $return_url = base64_encode('/admin/search_results?query='.$search_key);
    ?>
    <div class="content-w">
        <?php include 'fancy.php';?>
        <div class="header-spacer"></div>
        <div class="conty">
            <div class="header-spacer"></div>
            <div class="container">
                <div class="">
                    <div class="col">
                        <div class="ui-block">
                            <div class="ui-block-title">
                                <h6 class="title"><?= getPhrase('search_results_students');?></h6>
                            </div>
                            <?php 
				                $query = base64_decode($search_key);
				                $this->db->like('full_name' , str_replace("%20", " ", $query));
					            $student_query = $this->db->get('v_students');
					            if($student_query->num_rows() > 0):
					            $students = $student_query->result_array();
                            ?>
                            <ul class="notification-list">
                                <?php  
									foreach($students as $row):
								?>
                                <li>
                                    <div class="author-thumb">
                                        <img src="<?= $this->crud->get_image_url('student', $row['student_id']);?>"
                                            width="35px">
                                    </div>
                                    <div class="notification-event">
                                        <a href="<?= base_url();?>admin/student_portal/<?= $row['student_id'];?>/"
                                            class="h6 notification-friend"><?= $this->crud->get_name('student', $row['student_id']) ;?></a>.                                        
                                        <span class="notification-date">
                                            <span class="badge badge-info" style="background-color: <?=$row['program_color']?>;">
                                                <?= $row['program_name'];?>
                                            </span>
                                            <span class="badge badge-success" style="background-color: <?=$row['student_session_color']?>;">
                                                <?= $row['student_session_name']?>
                                            </span>
                                            <?php $class_id = $this->db->get_where('enroll', array('student_id' => $row['student_id']))->row()->class_id; 
												$class_name = $this->db->get_where('class', array('class_id' => $class_id))->row()->name;
                                                if($class_id > 0):
											?>                                            
                                            <span class="badge badge-success">
                                                <?=$class_name;?>
                                            </span>
                                            <?php endif;?>
                                        </span>
                                    </div>
                                    <div class="navs-links action-right">
                                        <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top"
                                            data-original-title="<?= getPhrase('add_task');?>"
                                            onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_task_add/<?= $row['student_id'].'/student/'.$return_url;?>');">
                                            <i class="picons-thin-icon-thin-0706_user_profile_add_new"></i>
                                        </a>
                                    </div>
                                    <div class="navs-links action-right">
                                        <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top"
                                            data-original-title="<?= getPhrase('add_interaction');?>"
                                            onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_student_add_interaction/<?= $row['student_id'].'/'.$return_url;?>');">
                                            <i class="picons-thin-icon-thin-0151_plus_add_new"></i>
                                        </a>
                                    </div>
                                </li>
                                <?php endforeach;?>
                            </ul>
                            <?php else:?>
                            <div class="bg-danger">
                                <div class="container">
                                    <div class="col-sm-12"><br><br>
                                        <h3 class="text-white"> <?= getPhrase('no_results_found');?></h3><br><br>
                                    </div>
                                </div>
                            </div>
                            <?php endif;?>
                        </div>
                        <div class="ui-block">
                            <div class="ui-block-title">
                                <h6 class="title"><?= getPhrase('search_results_applicants');?></h6>
                            </div>
                            <?php 
				                $query = base64_decode($search_key);
				                $this->db->like('full_name' , str_replace("%20", " ", $query));
					            $student_query = $this->db->get('v_applicants');
					            if($student_query->num_rows() > 0):
					            $students = $student_query->result_array();
                            ?>
                            <ul class="notification-list">
                                <?php  
									foreach($students as $row):
								?>
                                <li>
                                    <div class="author-thumb">
                                        <img src="<?= $this->crud->get_image_url('applicant', $row['applicant_id']);?>"
                                            width="35px">
                                    </div>
                                    <div class="notification-event">
                                        <a href="<?= base_url();?>admin/admission_applicant/<?= $row['applicant_id'];?>/"
                                            class="h6 notification-friend"><?= $this->crud->get_name('applicant', $row['applicant_id']) ;?></a>.
                                        <span class="notification-date">
                                            <span class="badge badge-info"
                                                style="background-color: <?= $row['applicant_type_color'];?>;">
                                                <?= $row['applicant_type'];?>
                                            </span>
                                            <span class="badge badge-success"
                                                style="background-color: <?= $row['status_color'];?>;">
                                                <?= $row['status_name'];?>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="navs-links action-right">
                                        <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top"
                                            data-original-title="<?= getPhrase('add_task');?>"
                                            onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_task_add/<?= $row['applicant_id'].'/applicant/'.$return_url;?>');">
                                            <i class="picons-thin-icon-thin-0706_user_profile_add_new"></i>
                                        </a>
                                    </div>
                                    <div class="navs-links action-right">
                                        <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top"
                                            data-original-title="<?= getPhrase('add_interaction');?>"
                                            onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_admission_add_interaction/<?= $row['applicant_id'].'/'.$return_url;?>');">
                                            <i class="picons-thin-icon-thin-0151_plus_add_new"></i>
                                        </a>
                                    </div>
                                </li>
                                <?php endforeach;?>
                            </ul>
                            <?php else:?>
                            <div class="bg-danger">
                                <div class="container">
                                    <div class="col-sm-12"><br><br>
                                        <h3 class="text-white"> <?= getPhrase('no_results_found');?></h3><br><br>
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