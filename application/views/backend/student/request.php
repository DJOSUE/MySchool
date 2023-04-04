    <?php 
    $student_id = get_login_user_id();
    $program_name = $this->studentModel->get_student_program_name($student_id );

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
                                <span><?= getPhrase('request');?></span>
                            </a>
                        </li>
                        <li class="navs-item">
                            <a class="navs-links" data-toggle="tab" href="#permission_request">
                                <i class="os-icon picons-thin-icon-thin-0389_gavel_hammer_law_judge_court"></i>
                                <span><?= getPhrase('permission');?></span>
                            </a>
                        </li>
                        <?php if ($program_name == "International") :?>
                        <li class="navs-item">
                            <a class="navs-links" data-toggle="tab" href="#vacation_request">
                                <i class="os-icon picons-thin-icon-thin-0389_gavel_hammer_law_judge_court"></i>
                                <span><?= getPhrase('vacation');?></span>
                            </a>
                        </li>
                        <?php endif;?>
                    </ul>
                </div>
            </div>
            <div class="content-i">
                <div class="content-box">
                    <div class="element-wrapper">
                        <div class="tab-content">
                            <div class="tab-pane active" id="permissions">
                                <div class="element-box lined-primary shadow">
                                    <div class="table-responsive">
                                        <table width="100%" class="table table-lightborder table-lightfont">
                                            <thead>
                                                <tr>
                                                    <th><?= getPhrase('reason');?></th>
                                                    <th><?= getPhrase('description');?></th>
                                                    <th><?= getPhrase('from');?></th>
                                                    <th><?= getPhrase('until');?></th>
                                                    <th><?= getPhrase('status');?></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
        		                                $count = 1;
        		                                $this->db->order_by('request_id', 'desc');
        		                                $requests = $this->db->get_where('student_request', array('student_id' => get_login_user_id()))->result_array();
            		                            foreach ($requests as $row) {
                                                    $semester_name = $this->academic->get_semester_name($row['semester_id']);
        	                                ?>
                                                <tr>
                                                    <td>
                                                        <a class="btn nc btn-rounded btn-sm btn-purple"
                                                            style="color:white">
                                                            <?= $this->studentModel->get_request_type_name($row['request_type']);?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <?=   substr($row['description'], 0, 50).'...'; ?>
                                                    </td>
                                                    <?php if($row['request_type'] == 1):?>
                                                    <td>
                                                        <a class="btn nc btn-rounded btn-sm btn-primary"
                                                            style="color:white">
                                                            <?= $row['year'].'-'.$semester_name; ?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a class="btn nc btn-rounded btn-sm btn-secondary"
                                                            style="color:white">
                                                            <?= $row['year'].'-'.$semester_name; ?>
                                                        </a>
                                                    </td>
                                                    <?php else:?>
                                                    <td>
                                                        <a class="btn nc btn-rounded btn-sm btn-primary"
                                                            style="color:white">
                                                            <?= $row['start_date']; ?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a class="btn nc btn-rounded btn-sm btn-secondary"
                                                            style="color:white">
                                                            <?= $row['end_date']; ?>
                                                        </a>
                                                    </td>
                                                    <?php endif;?>
                                                    <td>
                                                        <?php $status_info =  $this->studentModel->get_request_status($row['status']);?>

                                                        <a class="btn nc btn-rounded btn-sm btn-primary"
                                                            style="color:white; background-color: <?= $status_info['color'];?>;">
                                                            <?= $status_info['name'];?>
                                                        </a>
                                                    </td>
                                                    <td class="row-actions" style="float: left;">
                                                        <a href="javascript:void(0);" class="grey" data-toggle="tooltip"
                                                            data-placement="top"
                                                            data-original-title="<?= getPhrase('view');?>"
                                                            onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_request_view/<?=$row['request_id'];?>');">
                                                            <i
                                                                class="os-icon picons-thin-icon-thin-0043_eye_visibility_show_visible"></i>
                                                        </a>
                                                        <?php if($row['file']):?>
                                                        <a href="<?= base_url().PATH_REQUEST_FILES;?><?= $row['file'];?>"
                                                            class="grey" data-toggle="tooltip" data-placement="top"
                                                            target="_blank"
                                                            data-original-title="<?= getPhrase('view_file');?>">
                                                            <i
                                                                class="os-icon picons-thin-icon-thin-0075_document_file_paper_text_article_blog_template"></i>
                                                        </a>
                                                        <? endif;?>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="permission_request">
                                <div class="element-wrapper">
                                    <div class="element-box lined-primary shadow">
                                        <h5 class="form-header"><?= getPhrase('apply');?></h5><br>
                                        <b>
                                            <?= getPhrase('permission_request_info');?>
                                        </b><br><br>
                                        <div>
                                            <?= form_open(base_url() . 'student/request/create' , array('enctype' => 'multipart/form-data'));?>
                                            <input type="text" name="request_type" hidden value="2" />
                                            <div class="form-group">
                                                <label for=""> <?= getPhrase('reason');?></label>
                                                <input class="form-control" placeholder="" type="text" name="title"
                                                    required="">
                                            </div>
                                            <div class="form-group">
                                                <label> <?= getPhrase('description');?></label>
                                                <textarea class="form-control" rows="4" name="description"
                                                    required=""></textarea>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for=""> <?= getPhrase('from');?></label>
                                                        <input type='text' class="datepicker-here" required=""
                                                            data-position="top left" data-language='en'
                                                            name="start_date" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for=""> <?= getPhrase('until');?></label>
                                                        <input type='text' class="datepicker-here" required=""
                                                            data-position="top left" data-language='en'
                                                            name="end_date" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for=""> <?= getPhrase('file');?></label>
                                                <input type='file' class="form-control" name="file_name" required="" />
                                            </div>
                                            <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="description-toggle">
                                                    <div class="description-toggle-content">
                                                        <div class="h6"><?php echo getPhrase('notice');?></div>
                                                        <p><?php echo getPhrase('disclosure_message');?></p>
                                                    </div>
                                                    <div class="togglebutton">
                                                        <label><input name="disclosure_message" value="1" required
                                                                type="checkbox"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-buttons-w text-right">
                                                <button class="btn btn-rounded btn-primary" type="submit">
                                                    <?= getPhrase('send');?></button>
                                            </div>
                                            <?= form_close();?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="vacation_request">
                                <div class="element-wrapper">
                                    <div class="element-box lined-primary shadow">
                                        <h5 class="form-header"><?= getPhrase('apply');?></h5><br>
                                        <b>
                                            <?= getPhrase('vacation_request_info');?>
                                        </b><br><br>

                                        <div>
                                            <?= form_open(base_url() . 'student/request/vacation' , array('enctype' => 'multipart/form-data'));?>
                                            <input type="text" name="request_type" hidden value="1" />
                                            <div class="row">
                                                <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                    <div class="form-group label-floating is-select">
                                                        <label class="control-label">
                                                            <?= getPhrase('year');?>
                                                        </label>
                                                        <div class="select">
                                                            <select name="year">
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
                                                <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                    <div class="form-group label-floating is-select">
                                                        <label class="control-label">
                                                            <?= getPhrase('semester');?>
                                                        </label>
                                                        <div class="select">
                                                            <select name="semester_id">
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
                                            <div class="form-group">
                                                <label> <?= getPhrase('description');?></label>
                                                <textarea class="form-control" rows="4" name="description"
                                                    required=""></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for=""> <?= getPhrase('file');?></label>
                                                <input type='file' class="form-control" name="vacation_request_file" />
                                            </div>
                                            <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="description-toggle">
                                                    <div class="description-toggle-content">
                                                        <div class="h6"><?php echo getPhrase('notice');?></div>
                                                        <p><?php echo getPhrase('disclosure_message');?></p>
                                                    </div>
                                                    <div class="togglebutton">
                                                        <label><input name="disclosure_message" value="1" required
                                                                type="checkbox"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-buttons-w text-right">
                                                <button class="btn btn-rounded btn-primary" type="submit">
                                                    <?= getPhrase('send');?></button>
                                            </div>
                                            <?= form_close();?>
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