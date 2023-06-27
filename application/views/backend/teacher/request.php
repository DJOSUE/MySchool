<?php 
	$running_year       = $this->crud->getInfo('running_year');
    $running_semester   = $this->crud->getInfo('running_semester');

    $teacher_id = get_login_user_id();

    $students = $this->academic->get_students_by_teacher($teacher_id);

    $student_list = [];

    foreach($students as $student)
    {
        array_push($student_list, $student['student_id']);
    }

	$this->db->reset_query(); 
	$this->db->where('year', $running_year);
	$this->db->where('semester_id', $running_semester);
	$this->db->where('status', DEFAULT_REQUEST_ACCEPTED);
	$this->db->where('request_type', '2');
	$this->db->where_in('student_id', $student_list);
    $student_requests = $this->db->get('student_request')->result_array();

?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <ul class="navs navs-tabs upper">
                    <li class="navs-item">
                        <a class="navs-links active" data-toggle="tab" href="#permissions">
                            <i class="os-icon picons-thin-icon-thin-0015_fountain_pen"></i>
                            <span><?= getPhrase('permissions');?></span>
                        </a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" data-toggle="tab" href="#apply">
                            <i class="os-icon picons-thin-icon-thin-0389_gavel_hammer_law_judge_court"></i>
                            <span><?= getPhrase('apply');?></span>
                        </a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" data-toggle="tab" href="#student_permissions">
                            <i class="os-icon picons-thin-icon-thin-0389_gavel_hammer_law_judge_court"></i>
                            <span><?= getPhrase('student_permissions');?></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="content-i">
            <div class="content-box">
                <div class="tab-content">
                    <div class="tab-pane active" id="permissions">
                        <div class="element-wrapper">
                            <h6 class="element-header">
                                <?= getPhrase('permissions');?>
                            </h6>
                            <div class="element-box-tp">
                                <div class="table-responsive">
                                    <table class="table table-padded">
                                        <thead>
                                            <tr>
                                                <th><?= getPhrase('status');?></th>
                                                <th><?= getPhrase('reason');?></th>
                                                <th><?= getPhrase('description');?></th>
                                                <th><?= getPhrase('user');?></th>
                                                <th><?= getPhrase('from');?></th>
                                                <th><?= getPhrase('until');?></th>
                                                <th><?= getPhrase('file');?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
            	                                $count = 1;
												$this->db->reset_query(); 
            	                                $this->db->order_by('request_id', 'desc');
            	                                $requests = $this->db->get_where('teacher_request', array('teacher_id' => get_login_user_id()))->result_array();
                	                            foreach ($requests as $row):
        	                                ?>
                                            <tr>
                                                <td>
                                                    <?php if($row['status'] == 2):?>
                                                    <span
                                                        class="status-pill red"></span><span><?= getPhrase('rejected');?></span>
                                                    <?php endif;?>
                                                    <?php if($row['status'] == 0):?>
                                                    <span
                                                        class="status-pill yellow"></span><span><?= getPhrase('pending');?></span>
                                                    <?php endif;?>
                                                    <?php if($row['status'] == 1):?>
                                                    <span
                                                        class="status-pill green"></span><span><?= getPhrase('approved');?></span>
                                                    <?php endif;?>
                                                </td>
                                                <td><a class="btn nc btn-rounded btn-sm btn-purple"
                                                        style="color:white"><?= $row['title']; ?></a></td>
                                                <td><?= $row['description']; ?></td>
                                                <td><img alt=""
                                                        src="<?= $this->crud->get_image_url('teacher', get_login_user_id());?>"
                                                        width="25px" style="border-radius: 10px;margin-right:5px;">
                                                    <?= $this->crud->get_name('teacher', $row['teacher_id']);?>
                                                </td>
                                                <td><a class="btn nc btn-rounded btn-sm btn-primary"
                                                        style="color:white"><?= $row['start_date']; ?></a>
                                                </td>
                                                <td><a class="btn nc btn-rounded btn-sm btn-secondary"
                                                        style="color:white"><?= $row['end_date']; ?></a></td>
                                                <td>
                                                    <?php if($row['file'] == ""):?>
                                                    <p><?= getPhrase('no_file');?></p>
                                                    <?php endif;?>
                                                    <?php if($row['file'] != ""):?>
                                                    <a href="<?= base_url();?>public/uploads/request/<?= $row['file'];?>"
                                                        class="btn btn-rounded btn-sm btn-primary"
                                                        style="color:white"><i
                                                            class="os-icon picons-thin-icon-thin-0042_attachment"></i>
                                                        <?= getPhrase('download');?></a>
                                                    <?php endif;?>
                                                </td>
                                            </tr>
                                            <?php endforeach;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="apply">
                        <div class="element-wrapper">
                            <div class="element-box lined-primary">
                                <?= form_open(base_url() . 'teacher/request/create', array('enctype' => 'multipart/form-data'));?>
                                <h5 class="form-header"><?= getPhrase('apply');?></h5><br>
                                <div class="form-group">
                                    <label for=""> <?= getPhrase('reason');?></label><input class="form-control"
                                        name="title" placeholder="" required type="text">
                                </div>
                                <div class="form-group">
                                    <label> <?= getPhrase('description');?></label><textarea name="description"
                                        class="form-control" required="" rows="4"></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for=""> <?= getPhrase('from');?></label>
                                            <input type='text' class="datepicker-here" data-position="top left"
                                                data-language='en' name="start_date"
                                                data-multiple-dates-separator="/" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for=""> <?= getPhrase('until');?></label>
                                            <input type='text' class="datepicker-here" data-position="top left"
                                                data-language='en' name="end_date" data-multiple-dates-separator="/" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for=""> <?= getPhrase('send_file');?></label>
                                    <div class="input-group form-control">
                                        <input type="file" name="file_name" id="file-3" class="inputfile inputfile-3"
                                            style="display:none" />
                                        <label for="file-3"><i
                                                class="os-icon picons-thin-icon-thin-0042_attachment"></i>
                                            <span><?= getPhrase('send_file');?>...</span></label>
                                    </div>
                                </div>
                                <div class="form-buttons-w text-right">
                                    <button class="btn btn-primary btn-rounded" type="submit">
                                        <?= getPhrase('apply');?></button>
                                </div>
                                <?= form_close();?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="student_permissions">
                        <div class="element-wrapper">
                            <h6 class="element-header">
                                <?= getPhrase('student_permissions');?>
                            </h6>
                            <div class="element-box-tp">
                                <div class="table-responsive">
                                    <table class="table table-padded">
                                        <thead>
                                            <tr>
                                                <th><?= getPhrase('status');?></th>
                                                <th><?= getPhrase('reason');?></th>
                                                <th><?= getPhrase('student');?></th>
                                                <th><?= getPhrase('student_info');?></th>
                                                <th><?= getPhrase('from');?></th>
                                                <th><?= getPhrase('until');?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
            	                                $count = 1;
												// echo '<pre>';
												// var_dump($student_requests);
												// echo '</pre>';
												foreach ($student_requests as $student_request):
        	                                ?>
                                            <tr>
                                                <td>
                                                    <?php $status_info =  $this->studentModel->get_request_status($student_request['status']);?>
                                                    <a class="btn nc btn-rounded btn-sm btn-primary"
                                                        style="color:white; background-color: <?= $status_info['color'];?>;">
                                                        <?= $status_info['name'];?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a class="btn nc btn-rounded btn-sm btn-purple"
                                                        style="color:white"><?= $student_request['title']; ?></a>
                                                </td>
                                                <td>
													<img alt=""
														src="<?= $this->crud->get_image_url('student', $student_request['student_id']);?>"
														style="height: 25px;">
													<span><?= $this->crud->get_name('student', $student_request['student_id']);?></span>
                                                </td>
                                                <td>
                                                    <?php
                                                        $enrols = $this->academic->get_student_enrollment($student_request['student_id']);

                                                        foreach($enrols as $enrol)
                                                        {
                                                            echo '<b>'.getPhrase('class').'</b>: '.$enrol['class_name'];
                                                            echo '<br/>';
                                                            echo '<b>'.getPhrase('section').'</b>: '.$enrol['section_name'];
                                                            echo '<br/>';
                                                        }  
                                                    ?>
                                                </td>
                                                <td>
													<a class="btn nc btn-rounded btn-sm btn-primary"
                                                        style="color:white"><?= $student_request['start_date']; ?></a>
                                                </td>
                                                <td>
													<a class="btn nc btn-rounded btn-sm btn-secondary"
                                                        style="color:white"><?= $student_request['end_date']; ?></a>
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
    </div>
</div>