<?php 
    $running_year       = $this->crud->getInfo('running_year');
    $running_semester   = $this->crud->getInfo('running_semester'); 
    $useDailyMarks      = $this->crud->getInfo('use_daily_marks');
    $useGradeAttendance = $this->crud->getInfo('use_grade_attendance');

    $info = base64_decode($data);
    $ex = explode('-', $info);
    
    $class_id   = $ex[0];
    $section_id = $ex[1];
    $subject_id = $ex[2];

    $section_name = $this->db->get_where('section', array('section_id' => $ex[1]))->row()->name;

    $sub = $this->db->get_where('subject', array('subject_id' => $ex[2]))->result_array();
    foreach($sub as $row):
?>
<div class="content-w">
    <div class="conty">
        <?php include 'fancy.php';?>
        <div class="header-spacer"></div>
        <div class="cursos cta-with-media" style="background: #<?= $row['color'];?>;">
            <div class="cta-content">
                <div class="user-avatar">
                    <img alt="" src="<?= base_url();?>public/uploads/subject_icon/<?= $row['icon'];?>"
                        style="width:60px;">
                </div>
                <h3 class="cta-header"><?= $row['name'];?> - <small><?= getPhrase('dashboard');?></small>
                </h3>
                <small
                    style="font-size:0.90rem; color:#fff;"><?= $this->db->get_where('class', array('class_id' => $ex[0]))->row()->name;?>
                    "<?= $section_name; ?>"</small>
            </div>
        </div>
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <?php include 'subject__nav.php';?>
            </div>
        </div>
        <div class="content-i">
            <div class="content-box">
                <div class="row">
                    <main class="col col-xl-6 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
                        <div id="newsfeed-items-grid">
                        <?php 
                            $db = $this->db->query("SELECT homework_id, wall_type, publish_date FROM homework WHERE class_id = $ex[0] AND subject_id = $ex[2] AND section_id = $ex[1] 
                                                    UNION SELECT document_id, wall_type, publish_date FROM document WHERE class_id = $ex[0] AND subject_id = $ex[2] AND section_id = $ex[1] 
                                                    UNION SELECT online_exam_id, wall_type, publish_date FROM online_exam WHERE class_id = $ex[0] AND subject_id = $ex[2] AND section_id = $ex[1] 
                                                    UNION SELECT post_id, wall_type, publish_date FROM forum WHERE class_id = $ex[0] AND subject_id = $ex[2] AND section_id = $ex[1] 
                                                    ORDER BY publish_date DESC LIMIT 10");
                            if($db->num_rows() > 0):
                            foreach($db->result_array() as $wall):
                        ?>
                            <?php if($wall['wall_type'] == 'homework'):
                                $comment =   html_entity_decode(str_replace(array("\r", "\n"), '', $this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->description));    
                            ?>
                            <div class="ui-block">
                                <article class="hentry post thumb-full-width">
                                    <div class="post__author author vcard inline-items">
                                        <img
                                            src="<?= $this->crud->get_image_url($this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->uploader_type, $this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->uploader_id);?>">
                                        <div class="author-date">
                                            <a class="h6 post__author-name fn"
                                                href="javascript:void(0);"><?= $this->crud->get_name($this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->uploader_type, $this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->uploader_id);?></a>
                                            <div class="post__date">
                                                <time
                                                    class="published"><?= $this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->upload_date;?></time>
                                            </div>
                                        </div>
                                        <div class="more">
                                            <i class="icon-options"></i>
                                            <ul class="more-dropdown">
                                                <li><a
                                                        href="<?= base_url();?>teacher/homework_edit/<?= $this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->homework_code;?>/"><?= getPhrase('edit');?></a>
                                                </li>
                                                <li><a onClick="return confirm('<?= getPhrase('confirm_delete');?>')"
                                                        href="<?= base_url(); ?>teacher/homework/delete/<?= $this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->homework_code;?>/<?= $data;?>/"><?= getPhrase('delete');?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="edu-posts cta-with-media verde">
                                        <div class="cta-content">
                                            <div class="highlight-header morado"><?= $row['name'];?></div>
                                            <div class="grado">
                                                <?= $this->db->get_where('class', array('class_id' => $ex[0]))->row()->name;?>
                                                "<?= $this->db->get_where('section', array('section_id' => $ex[1]))->row()->name;?>"
                                            </div>
                                            <h3 class="cta-header">
                                                <?= $this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->title;?>
                                            </h3>
                                            <div class="descripcion">
                                                <?= $comment;?>
                                            </div>
                                            <?php if($this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->file_name != ""):?>
                                            <div class="table-responsive">
                                                <table class="table table-down">
                                                    <tbody>
                                                        <tr style="background:#a11a7a">
                                                            <td class="text-left cell-with-media">
                                                                <a
                                                                    href="<?= base_url().'public/uploads/homework/' . $this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->file_name;?>"><i
                                                                        class="picons-thin-icon-thin-0111_folder_files_documents"
                                                                        style="font-size:16px; color:#fff;"></i>
                                                                    <span><?= $this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->file_name;?></span><span
                                                                        class="smaller">(<?= $this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->filesize;?>)</span></a>
                                                            </td>
                                                            <td class="text-center bolder">
                                                                <a
                                                                    href="<?= base_url().'public/uploads/homework/' . $this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->file_name;?>">
                                                                    <span><i
                                                                            class="picons-thin-icon-thin-0121_download_file"></i></span>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php endif;?>
                                            <div class="deadtime">
                                                <span><?= getPhrase('date');?>:</span><i
                                                    class="picons-thin-icon-thin-0027_stopwatch_timer_running_time"></i><?= $this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->date_end;?>
                                                @
                                                <?= $this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->time_end;?>
                                            </div>
                                            <a
                                                href="<?= base_url();?>teacher/homeworkroom/<?= $this->db->get_where('homework', array('homework_id' => $wall['homework_id']))->row()->homework_code;?>/"><button
                                                    class="btn btn-rounded btn-posts"><i
                                                        class="picons-thin-icon-thin-0100_to_do_list_reminder_done"></i>
                                                    <?= getPhrase('view_homework');?></button></a>
                                        </div>
                                    </div>
                                    <div class="control-block-button post-control-button">
                                        <a href="javascript:void(0);" class="btn btn-control featured-post"
                                            style="background-color: #99bf2d; color: #fff;" data-toggle="tooltip"
                                            data-placement="top" data-original-title="<?= getPhrase('homework');?>">
                                            <i class="picons-thin-icon-thin-0004_pencil_ruler_drawing"></i>
                                        </a>
                                    </div>
                                    <?php
                                            $checkData = $this->academic->getRead($wall['homework_id'],'homework',$ex[2]);
                                            if(count($checkData) > 0):
                                        ?>
                                    <div class="post-additional-info inline-items">
                                        <ul class="friends-harmonic">
                                            <?php foreach($checkData as $readed):?>
                                            <li>
                                                <a href="javascript:void(0);">
                                                    <img loading="lazy"
                                                        onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_students/<?= $wall['homework_id'].'/'.$ex[2].'/homework';?>');"
                                                        title="<?= $this->crud->get_name('student', $readed['student_id']);?>"
                                                        src="<?= $this->crud->get_image_url('student', $readed['student_id']);?>"
                                                        alt="<?= $this->crud->get_name('student', $readed['student_id']);?>"
                                                        width="28" height="28">
                                                </a>
                                            </li>
                                            <?php endforeach;?>
                                        </ul>
                                        <div class="names-people-likes">
                                            <?php if(count($checkData) > 5):?>
                                            <?= getPhrase('and');?> <?= count($checkData)-5;?>
                                            <?= getPhrase('other_people_viewed_this_post');?>.
                                            <?php else:?>
                                            <?= getPhrase('have_seen_this_post');?>
                                            <?php endif;?>
                                        </div>
                                        <div class="comments-shared">
                                            <a href="javascript:void(0);" class="post-add-icon inline-items"></a>
                                            <a href="javascript:void(0);" class="post-add-icon inline-items"></a>
                                        </div>
                                    </div>
                                    <?php else:?>
                                    <br><br><br>
                                    <?php endif;?>
                                </article>
                            </div>
                            <?php endif;?>
                            <?php if($wall['wall_type'] == 'exam' ):?>
                            <div class="ui-block">
                                <article class="hentry post thumb-full-width">
                                    <div class="post__author author vcard inline-items">
                                        <img
                                            src="<?= $this->crud->get_image_url($this->db->get_where('online_exam', array('online_exam_id' => $wall['homework_id']))->row()->uploader_type, $this->db->get_where('online_exam', array('online_exam_id' => $wall['homework_id']))->row()->uploader_id);?>">
                                        <div class="author-date">
                                            <a class="h6 post__author-name fn"
                                                href="javascript:void(0);"><?= $this->crud->get_name($this->db->get_where('online_exam', array('online_exam_id' => $wall['homework_id']))->row()->uploader_type, $this->db->get_where('online_exam', array('online_exam_id' => $wall['homework_id']))->row()->uploader_id);?></a>
                                            <div class="post__date">
                                                <time
                                                    class="published"><?= $this->db->get_where('online_exam', array('online_exam_id' => $wall['homework_id']))->row()->upload_date;?></time>
                                            </div>
                                        </div>
                                        <div class="more">
                                            <i class="icon-options"></i>
                                            <ul class="more-dropdown">
                                                <li><a
                                                        href="<?= base_url();?>teacher/exam_edit/<?= $this->db->get_where('online_exam', array('online_exam_id' => $wall['homework_id']))->row()->online_exam_id;?>/"><?= getPhrase('edit');?></a>
                                                </li>
                                                <li><a onClick="return confirm('<?= getPhrase('confirm_delete');?>')"
                                                        href="<?= base_url();?>teacher/manage_exams/delete/<?= $this->db->get_where('online_exam', array('online_exam_id' => $wall['homework_id']))->row()->online_exam_id;?>/<?= $data;?>"><?= getPhrase('delete');?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="edu-posts cta-with-media verde">
                                        <div class="cta-content">
                                            <div class="highlight-header celeste">
                                                <?= $row['name'];?>
                                            </div>
                                            <div class="grado">
                                                <?= $this->db->get_where('class', array('class_id' => $ex[0]))->row()->name;?>
                                                "<?= $this->db->get_where('section', array('section_id' => $ex[1]))->row()->name;?>"
                                            </div>
                                            <h3 class="cta-header">
                                                <?= $this->db->get_where('online_exam', array('online_exam_id' => $wall['homework_id']))->row()->title;?>
                                            </h3>
                                            <div class="descripcion">
                                                <?= strip_tags($this->db->get_where('online_exam', array('online_exam_id' => $wall['homework_id']))->row()->instruction);?>
                                            </div>
                                            <div class="deadtime">
                                                <span><?= getPhrase('date');?>:</span><i
                                                    class="picons-thin-icon-thin-0027_stopwatch_timer_running_time"></i><?= date('M d, Y', $this->db->get_where('online_exam', array('online_exam_id' => $wall['homework_id']))->row()->exam_date);?>
                                            </div>
                                            <div class="deadtime">
                                                <span><?= getPhrase('hour');?>:</span><i
                                                    class="picons-thin-icon-thin-0027_stopwatch_timer_running_time"></i><?= $this->db->get_where('online_exam', array('online_exam_id' => $wall['homework_id']))->row()->time_start. " - ".$this->db->get_where('online_exam', array('online_exam_id' => $wall['homework_id']))->row()->time_end;?>
                                            </div>
                                            <div class="deadtime">
                                                <span><?= getPhrase('duration');?>:</span><i
                                                    class="picons-thin-icon-thin-0026_time_watch_clock"></i><?php $minutes = number_format($this->db->get_where('online_exam', array('online_exam_id' => $wall['homework_id']))->row()->duration/60,0); echo $minutes;?>
                                                mins.
                                            </div>
                                            <a
                                                href="<?= base_url();?>teacher/examroom/<?= $this->db->get_where('online_exam', array('online_exam_id' => $wall['homework_id']))->row()->online_exam_id;?>/"><button
                                                    class="btn btn-rounded btn-posts verde"><i
                                                        class="picons-thin-icon-thin-0014_notebook_paper_todo"></i>
                                                    <?= getPhrase('view_exam');?></button></a>
                                        </div>
                                    </div>
                                    <div class="control-block-button post-control-button">
                                        <a href="javascript:void(0);" class="btn btn-control"
                                            style="background-color: #a01a7a; color: #fff;" data-toggle="tooltip"
                                            data-placement="top" data-original-title="<?= getPhrase('online_exams');?>">
                                            <i class="picons-thin-icon-thin-0207_list_checkbox_todo_done"></i>
                                        </a>
                                    </div>
                                    <?php
                                            $checkData = $this->academic->getRead($wall['homework_id'],'exam',$ex[2]);
                                            if(count($checkData) > 0):
                                        ?>
                                    <div class="post-additional-info inline-items">
                                        <ul class="friends-harmonic">
                                            <?php foreach($checkData as $readed):?>
                                            <li>
                                                <a href="javascript:void(0);">
                                                    <img loading="lazy"
                                                        onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_students/<?= $wall['homework_id'].'/'.$ex[2].'/exam';?>');"
                                                        title="<?= $this->crud->get_name('student', $readed['student_id']);?>"
                                                        src="<?= $this->crud->get_image_url('student', $readed['student_id']);?>"
                                                        alt="<?= $this->crud->get_name('student', $readed['student_id']);?>"
                                                        width="28" height="28">
                                                </a>
                                            </li>
                                            <?php endforeach;?>
                                        </ul>
                                        <div class="names-people-likes">
                                            <?php if(count($checkData) > 5):?>
                                            <?= getPhrase('and');?> <?= count($checkData)-5;?>
                                            <?= getPhrase('other_people_viewed_this_post');?>.
                                            <?php else:?>
                                            <?= getPhrase('have_seen_this_post');?>
                                            <?php endif;?>
                                        </div>
                                        <div class="comments-shared">
                                            <a href="javascript:void(0);" class="post-add-icon inline-items"></a>
                                            <a href="javascript:void(0);" class="post-add-icon inline-items"></a>
                                        </div>
                                    </div>
                                    <?php else:?>
                                    <br><br><br>
                                    <?php endif;?>
                                </article>
                            </div>
                            <?php endif;?>
                            <?php if($wall['wall_type'] == 'material'):?>
                            <div class="ui-block">
                                <article class="hentry post thumb-full-width">
                                    <div class="post__author author vcard inline-items">
                                        <img
                                            src="<?= $this->crud->get_image_url($this->db->get_where('document', array('document_id' => $wall['homework_id']))->row()->type, $this->db->get_where('document', array('document_id' => $wall['homework_id']))->row()->teacher_id);?>">
                                        <div class="author-date">
                                            <a class="h6 post__author-name fn"
                                                href="javascript:void(0);"><?= $this->crud->get_name($this->db->get_where('document', array('document_id' => $wall['homework_id']))->row()->type, $this->db->get_where('document', array('document_id' => $wall['homework_id']))->row()->teacher_id);?></a>
                                            <div class="post__date">
                                                <time
                                                    class="published"><?= $this->db->get_where('document', array('document_id' => $wall['homework_id']))->row()->upload_date;?></time>
                                            </div>
                                        </div>
                                        <div class="more">
                                            <i class="icon-options"></i>
                                            <ul class="more-dropdown">
                                                <li><a onClick="return confirm('<?= getPhrase('confirm_delete');?>')"
                                                        href="<?= base_url();?>teacher/study_material/delete/<?= $this->db->get_where('document', array('document_id' => $wall['homework_id']))->row()->document_id;?>/<?= $data;?>"><?= getPhrase('delete');?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="edu-posts cta-with-media verde">
                                        <div class="cta-content">
                                            <div class="highlight-header morado">
                                                <?= $row['name'];?>
                                            </div>
                                            <div class="grado">
                                                <?= $this->db->get_where('class', array('class_id' => $ex[0]))->row()->name;?>
                                                "<?= $this->db->get_where('section', array('section_id' => $ex[1]))->row()->name;?>"
                                            </div>
                                            <h3 class="cta-header"><?= getPhrase('study_material');?></h3>
                                            <div class="descripcion">
                                                <?= strip_tags($this->db->get_where('document', array('document_id' => $wall['homework_id']))->row()->description);?>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-down">
                                                    <tbody>
                                                        <tr style="background:#a11a7a">
                                                            <td class="text-left cell-with-media">
                                                                <a
                                                                    href="<?= base_url().'public/uploads/document/'.$this->db->get_where('document', array('document_id' => $wall['homework_id']))->row()->file_name; ?>"><i
                                                                        class="picons-thin-icon-thin-0111_folder_files_documents"
                                                                        style="font-size:16px; color:#fff;"></i>
                                                                    <span><?= $this->db->get_where('document', array('document_id' => $wall['homework_id']))->row()->file_name;?></span><span
                                                                        class="smaller">(<?= $this->db->get_where('document', array('document_id' => $wall['homework_id']))->row()->filesize;?>)</span></a>
                                                            </td>
                                                            <td class="text-center bolder">
                                                                <a
                                                                    href="<?= base_url().'public/uploads/document/'.$this->db->get_where('document', array('document_id' => $wall['homework_id']))->row()->file_name; ?>">
                                                                    <span><i
                                                                            class="picons-thin-icon-thin-0121_download_file"></i></span>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="control-block-button post-control-button">
                                        <a href="javascript:void(0);" class="btn btn-control"
                                            style="background-color: #00579c; color: #fff;" data-toggle="tooltip"
                                            data-placement="top"
                                            data-original-title="<?= getPhrase('study_material');?>">
                                            <i class="picons-thin-icon-thin-0003_write_pencil_new_edit"></i>
                                        </a>
                                    </div>
                                    <?php
                                            $checkData = $this->academic->getRead($wall['homework_id'],'material',$ex[2]);
                                            if(count($checkData) > 0):
                                        ?>
                                    <div class="post-additional-info inline-items">
                                        <ul class="friends-harmonic">
                                            <?php foreach($checkData as $readed):?>
                                            <li>
                                                <a href="javascript:void(0);">
                                                    <img loading="lazy"
                                                        onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_students/<?= $wall['homework_id'].'/'.$ex[2].'/material';?>');"
                                                        title="<?= $this->crud->get_name('student', $readed['student_id']);?>"
                                                        src="<?= $this->crud->get_image_url('student', $readed['student_id']);?>"
                                                        alt="<?= $this->crud->get_name('student', $readed['student_id']);?>"
                                                        width="28" height="28">
                                                </a>
                                            </li>
                                            <?php endforeach;?>
                                        </ul>
                                        <div class="names-people-likes">
                                            <?php if(count($checkData) > 5):?>
                                            <?= getPhrase('and');?> <?= count($checkData)-5;?>
                                            <?= getPhrase('other_people_viewed_this_post');?>.
                                            <?php else:?>
                                            <?= getPhrase('have_seen_this_post');?>
                                            <?php endif;?>
                                        </div>
                                        <div class="comments-shared">
                                            <a href="javascript:void(0);" class="post-add-icon inline-items"></a>
                                            <a href="javascript:void(0);" class="post-add-icon inline-items"></a>
                                        </div>
                                    </div>
                                    <?php else:?>
                                    <br><br><br>
                                    <?php endif;?>
                                </article>
                            </div>
                            <?php endif;?>
                            <?php if($wall['wall_type'] == 'forum' ):?>
                            <div class="ui-block">
                                <article class="hentry post thumb-full-width">
                                    <div class="post__author author vcard inline-items">
                                        <img
                                            src="<?= $this->crud->get_image_url($this->db->get_where('forum', array('post_id' => $wall['homework_id']))->row()->type, $this->db->get_where('forum', array('post_id' => $wall['homework_id']))->row()->teacher_id);?>">
                                        <div class="author-date">
                                            <a class="h6 post__author-name fn"
                                                href="javascript:void(0);"><?= $this->crud->get_name($this->db->get_where('forum', array('post_id' => $wall['homework_id']))->row()->type, $this->db->get_where('forum', array('post_id' => $wall['homework_id']))->row()->teacher_id);?></a>
                                            <div class="post__date">
                                                <time
                                                    class="published"><?= $this->db->get_where('forum', array('post_id' => $wall['homework_id']))->row()->upload_date;?></time>
                                            </div>
                                        </div>
                                        <div class="more">
                                            <i class="icon-options"></i>
                                            <ul class="more-dropdown">
                                                <li><a
                                                        href="<?= base_url();?>teacher/edit_forum/<?= $this->db->get_where('forum', array('post_id' => $wall['homework_id']))->row()->post_code;?>/"><?= getPhrase('edit');?></a>
                                                </li>
                                                <li><a onClick="return confirm('<?= getPhrase('confirm_delete');?>')"
                                                        href="<?= base_url(); ?>teacher/forum/delete/<?= $this->db->get_where('forum', array('post_id' => $wall['homework_id']))->row()->post_code;?>/<?= $data;?>"><?= getPhrase('delete');?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="edu-posts cta-with-media verde">
                                        <div class="cta-content">
                                            <div class="highlight-header yellow">
                                                <?= $row['name'];?>
                                            </div>
                                            <div class="grado">
                                                <?= $this->db->get_where('class', array('class_id' => $ex[0]))->row()->name;?>
                                                "<?= $this->db->get_where('section', array('section_id' => $ex[1]))->row()->name;?>"
                                            </div>
                                            <h3 class="cta-header">
                                                <?= $this->db->get_where('forum', array('post_id' => $wall['homework_id']))->row()->title;?>
                                            </h3>
                                            <div class="descripcion">
                                                <?= html_entity_decode($this->db->get_where('forum', array('post_id' => $wall['homework_id']))->row()->description);?>
                                            </div>
                                            <a
                                                href="<?= base_url();?>teacher/forumroom/<?= $this->db->get_where('forum', array('post_id' => $wall['homework_id']))->row()->post_code;?>/"><button
                                                    class="btn btn-rounded btn-posts"><i
                                                        class="picons-thin-icon-thin-0014_notebook_paper_todo"></i>
                                                    <?= getPhrase('view_forum');?></button></a>
                                        </div>
                                    </div>
                                    <div class="control-block-button post-control-button">
                                        <a href="javascript:void(0);" class="btn btn-control"
                                            style="background-color: #f4af08; color: #fff;" data-toggle="tooltip"
                                            data-placement="top" data-original-title="<?= getPhrase('forum');?>">
                                            <i
                                                class="picons-thin-icon-thin-0281_chat_message_discussion_bubble_reply_conversation"></i>
                                        </a>
                                    </div>
                                    <?php
                                            $checkData = $this->academic->getRead($wall['homework_id'],'forum',$ex[2]);
                                            if(count($checkData) > 0):
                                        ?>
                                    <div class="post-additional-info inline-items">
                                        <ul class="friends-harmonic">
                                            <?php foreach($checkData as $readed):?>
                                            <li>
                                                <a href="javascript:void(0);">
                                                    <img loading="lazy"
                                                        onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_students/<?= $wall['homework_id'].'/'.$ex[2].'/forum';?>');"
                                                        title="<?= $this->crud->get_name('student', $readed['student_id']);?>"
                                                        src="<?= $this->crud->get_image_url('student', $readed['student_id']);?>"
                                                        alt="<?= $this->crud->get_name('student', $readed['student_id']);?>"
                                                        width="28" height="28">
                                                </a>
                                            </li>
                                            <?php endforeach;?>
                                        </ul>
                                        <div class="names-people-likes">
                                            <?php if(count($checkData) > 5):?>
                                            <?= getPhrase('and');?> <?= count($checkData)-5;?>
                                            <?= getPhrase('other_people_viewed_this_post');?>.
                                            <?php else:?>
                                            <?= getPhrase('have_seen_this_post');?>
                                            <?php endif;?>
                                        </div>
                                        <div class="comments-shared">
                                            <a href="javascript:void(0);" class="post-add-icon inline-items"></a>
                                            <a href="javascript:void(0);" class="post-add-icon inline-items"></a>
                                        </div>
                                    </div>
                                    <?php else:?>
                                    <br><br><br>
                                    <?php endif;?>
                                </article>
                            </div>
                            <?php endif;?>
                            <?php endforeach;?>
                            <?php elseif($db->num_rows() == 0):?>
                            <div class="ui-block">
                                <article class="hentry post thumb-full-width">
                                    <div class="edu-posts cta-with-media">
                                        <br><br>
                                        <center>
                                            <h3><?= getPhrase('no_recent_activity');?></h3>
                                        </center><br>
                                        <center><img src="<?= base_url();?>public/uploads/icons/norecent.svg"
                                                width="55%"></center>
                                        <br><br>
                                    </div>
                                </article>
                            </div>
                            <?php endif;?>
                        </div>
                    </main>
                    <div class="col col-xl-3 order-xl-1 col-lg-6 order-lg-2 col-md-6 col-sm-12 col-12">
                        <div class="eduappgt-sticky-sidebar">
                            <div class="sidebar__inner">
                                <div class="ui-block paddingtel lined-danger">
                                    <div class="ui-block-title">
                                        <h6 class="title"><?= getPhrase('teacher_of_the_subject');?></h6>
                                    </div>
                                    <div class="ui-block-content">
                                        <div class="widget w-about" style="text-align:center">
                                            <?php $tch= $this->db->get_where('subject', array('subject_id' => $ex[2]))->row()->teacher_id;?>
                                            <a href="javascript:void(0);" class="logo"><img
                                                    src="<?= $this->crud->get_image_url('teacher', $tch);?>"
                                                    style="width:90px;"></a>
                                            <h5><?= $this->crud->get_name('teacher', $tch)?><br>
                                                <small><?= $this->db->get_where('teacher', array('teacher_id' => $tch))->row()->email;?></small>
                                            </h5>
                                            <h6><a class="badge badge-primary" href="javascript:void(0);">
                                                    <?= getPhrase('teacher');?></a></h6>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                                <div class="ui-block">
                                    <div class="ui-block-title">
                                        <h6 class="title"><?= getPhrase('subject_activity');?></h6>
                                    </div>
                                    <?php 
                                            $this->db->order_by('id', 'desc');
                                            $this->db->group_by('type');
                                            $notifications = $this->db->get_where('notification', array('class_id' => $ex[0], 'subject_id' => $ex[2], 'year' => $running_year));
                                            if($notifications->num_rows() > 0):
                                        ?>
                                    <ul class="widget w-activity-feed notification-list">
                                        <?php foreach($notifications->result_array() as $notify):?>
                                        <li>
                                            <div class="author-thumb">
                                                <img src="<?= base_url();?>public/uploads/notify.svg">
                                            </div>
                                            <div class="notification-event">
                                                <a href="javascript:void(0);"
                                                    class="notification-friend"><?= $notify['notify'];?>.</a>
                                                <span class="notification-date"><time
                                                        class="entry-date updated"><?= $notify['date'];?>
                                                        <?= getPhrase('at');?>
                                                        <?= $notify['time'];?></time></span>
                                            </div>
                                        </li>
                                        <?php endforeach;?>
                                    </ul>
                                    <?php else:?>
                                    <br><br><br>
                                    <center>
                                        <h6><?= getPhrase('no_subject_activity');?></h6>
                                    </center>
                                    <br><br><br>
                                    <?php endif;?>
                                </div>
                                <div class="ui-block">
                                    <div class="ui-block-title">
                                        <h6 class="title"><?= getPhrase('class_books');?></h6>
                                    </div>
                                    <div class="ui-block-content">
                                        <ul class="widget w-personal-info item-block">
                                            <?php
                                                $is_saturday = false;
                                                if(strpos(strtolower($section_name),'saturday')!== false)
                                                {
                                                    $is_saturday = true;
                                                }
                                            ?>
                                            <a href="<?= base_url();?>books/<?= base64_encode($class_id."|".$is_saturday);?>/"
                                                class="h6 author-name">
                                                <?= getPhrase('books');?>
                                            </a>
                                            <hr>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col col-xl-3 order-xl-3 col-lg-6 order-lg-3 col-md-6 col-sm-12 col-12">
                        <div class="eduappgt-sticky-sidebar">
                            <div class="sidebar__inner">
                                <div class="ui-block paddingtel">
                                    <div class="ui-block-title">
                                        <h6 class="title"><?= getPhrase('about_the_subject');?></h6>
                                    </div>
                                    <div class="ui-block-content">
                                        <ul class="widget item-block">
                                            <li>
                                                <span class="text">
                                                    <b><?= getPhrase('classroom')?>:</b><br /><?= $row['classroom'];?>
                                                </span>
                                            </li>
                                            <li>
                                                <span class="text">
                                                    <b><?= getPhrase('about')?>:</b><br /><?= $row['about'];?>
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="ui-block paddingtel">
                                    <div class="ui-block-title">
                                        <h6 class="title"><?= getPhrase('subject_stats');?></h6>
                                    </div>
                                    <div class="ui-block-content">
                                        <div style="margin-bottom:10px">
                                            <span
                                                class="subjectCounter"><?= $this->academic->countOnlineExams($ex[0],$ex[1],$ex[2]);?></span>
                                            <span class="counterText"><?= getPhrase('online_exams');?>.</span>
                                        </div>
                                        <div style="margin-bottom:10px">
                                            <span
                                                class="subjectCounter"><?= $this->academic->countHomeworks($ex[0],$ex[1],$ex[2]);?></span>
                                            <span class="counterText"><?= getPhrase('homeworks');?>.</span>
                                        </div>
                                        <div style="margin-bottom:10px">
                                            <span
                                                class="subjectCounter"><?= $this->academic->countForums($ex[0],$ex[1],$ex[2]);?></span>
                                            <span class="counterText"><?= getPhrase('forums');?>.</span>
                                        </div>
                                        <div style="margin-bottom:10px">
                                            <span
                                                class="subjectCounter"><?= $this->academic->countMaterial($ex[0],$ex[1],$ex[2]);?></span>
                                            <span class="counterText"><?= getPhrase('study_material');?>.</span>
                                        </div>
                                        <div style="margin-bottom:10px">
                                            <span
                                                class="subjectCounter"><?= $this->academic->countLive($ex[0],$ex[1],$ex[2]);?></span>
                                            <span class="counterText"><?= getPhrase('live_classes');?>.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="ui-block paddingtel">
                                    <div class="ui-block-title">
                                        <h6 class="title"><?= getPhrase('students');?></h6>
                                    </div>
                                    <ul class="widget w-friend-pages-added notification-list friend-requests">
                                        <?php 
                                            $students   =   $this->db->get_where('enroll' , array('class_id' => $ex[0], 'section_id' => $ex[1] , 'subject_id' => $subject_id , 'year' => $running_year))->result_array();
                                            foreach($students as $row2):
                                                $status_info = $this->studentModel->get_student_status_info($row2['student_id']);
                                        ?>
                                        <li class="inline-items">
                                            <div class="author-thumb">
                                                <img src="<?= $this->crud->get_image_url('student', $row2['student_id']);?>"
                                                    width="35px">
                                            </div>
                                            <div class="notification-event">
                                                <a class="h6 notification-friend">
                                                    <?= $this->crud->get_name('student', $row2['student_id'])?>
                                                </a>
                                                <span class="chat-message-item"><?= getPhrase('status');?>:
                                                    <span class="badge"
                                                        style="background-color: <?=$status_info['color']?>;">
                                                        <?= $status_info['name'];?>
                                                    </span>
                                                </span>
                                            </div>
                                        </li>
                                        <?php endforeach;?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a class="back-to-top" href="javascript:void(0);">
                <img src="<?= base_url();?>public/style/olapp/svg-icons/back-to-top.svg" alt="arrow" class="back-icon">
            </a>
        </div>
    </div>
</div>
<?php endforeach;?>